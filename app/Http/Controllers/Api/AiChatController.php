<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GeminiService;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AiChatController extends Controller
{
    protected $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    /**
     * API endpoint trả về danh sách sản phẩm cho AI
     */
    public function productsFeed(Request $request)
    {
        $query = Product::with('category')
                       ->select('id', 'name', 'price', 'unit', 'category_id', 'description', 'origin');

        // Nếu có từ khóa tìm kiếm
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
            $products = $query->limit(10)->get();
        } else {
            // Lấy sản phẩm nổi bật và có khuyến mãi
            $products = $query->inRandomOrder()->limit(15)->get();
        }

        $feed = $products->map(function($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'discounted_price' => $product->discounted_price ?? $product->price,
                'has_promotion' => $product->has_promotion ?? false,
                'unit' => $product->unit,
                'category' => $product->category->name ?? 'Nông sản',
                'description' => $product->description ? substr($product->description, 0, 100) : null,
                'origin' => $product->origin,
                'url' => route('products.show', $product->id)
            ];
        });

        return response()->json([
            'success' => true,
            'products' => $feed
        ]);
    }

    /**
     * API endpoint xử lý chat với AI
     */
    public function chat(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:500',
            'search_keyword' => 'nullable|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Tin nhắn không hợp lệ',
                'errors' => $validator->errors()
            ], 422);
        }

        // Kiểm tra service đã cấu hình chưa
        if (!$this->gemini->isConfigured()) {
            return response()->json([
                'success' => false,
                'error' => 'AI service chưa được cấu hình'
            ], 503);
        }

        // Xây dựng context
        $context = $this->buildContext($request);

        // Gọi Gemini service
        $result = $this->gemini->chat($request->message, $context);

        return response()->json($result);
    }

    /**
     * Xây dựng context cho AI từ request và user data
     */
    protected function buildContext(Request $request)
    {
        $context = [];

        // Thông tin user nếu đã đăng nhập
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $context['user'] = [
                'name' => $user->name,
                'is_member' => true
            ];

            // Lấy sản phẩm yêu thích
            $favorites = $user->favorites()->with('category')->limit(5)->get();
            if ($favorites->count() > 0) {
                $context['favorites'] = $favorites->map(function($fav) {
                    return [
                        'name' => $fav->name,
                        'category' => $fav->category->name ?? 'Nông sản',
                        'price' => $fav->price
                    ];
                })->toArray();
            }
        }

        // Thông tin giỏ hàng từ session
        $cart = session('cart', []);
        if (!empty($cart)) {
            $context['cart'] = collect($cart)->map(function($item) {
                return [
                    'name' => $item['name'] ?? 'Sản phẩm',
                    'quantity' => $item['quantity'] ?? 1,
                    'price' => $item['price'] ?? 0,
                    'unit' => $item['unit'] ?? 'kg'
                ];
            })->toArray();
        }

        // Lấy danh sách sản phẩm liên quan
        $searchKeyword = $request->input('search_keyword', '');
        $products = $this->getRelevantProducts($request->message, $searchKeyword);
        $context['products'] = $products;

        return $context;
    }

    /**
     * Lấy sản phẩm liên quan dựa trên message
     */
    protected function getRelevantProducts($message, $searchKeyword = '')
    {
        $query = Product::with(['category', 'reviews']);

        // Tìm kiếm theo keyword nếu có
        if (!empty($searchKeyword)) {
            $query->where(function($q) use ($searchKeyword) {
                $q->where('name', 'like', "%{$searchKeyword}%")
                  ->orWhere('description', 'like', "%{$searchKeyword}%");
            });
        } else {
            // Tìm kiếm trong message
            $keywords = ['rau', 'củ', 'quả', 'trái cây', 'nông sản', 'tươi', 'sạch', 'organic'];
            foreach ($keywords as $keyword) {
                if (stripos($message, $keyword) !== false) {
                    $query->where(function($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%")
                          ->orWhere('description', 'like', "%{$keyword}%")
                          ->orWhereHas('category', function($cq) use ($keyword) {
                              $cq->where('name', 'like', "%{$keyword}%");
                          });
                    });
                    break;
                }
            }
        }

        // Lấy nhiều sản phẩm hơn để AI thấy đủ danh mục/sản phẩm mới
        $products = $query->latest()->limit(50)->get();

        // Nếu không tìm thấy, lấy sản phẩm ngẫu nhiên
        if ($products->isEmpty()) {
            $products = Product::with(['category', 'reviews'])->latest()->limit(50)->get();
        }

        return $products->map(function($product) {
            $reviewCount = $product->reviews->count();
            $avgRating = $reviewCount > 0 ? round($product->reviews->avg('rating'), 1) : 0;
            
            // Lấy một vài review mẫu
            $sampleReviews = $product->reviews->take(2)->map(function($review) {
                return [
                    'rating' => $review->rating,
                    'comment' => $review->comment ? substr($review->comment, 0, 100) : null,
                    'user' => $review->user->name ?? 'Khách hàng'
                ];
            })->toArray();
            
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'discounted_price' => $product->discounted_price ?? $product->price,
                'has_promotion' => $product->has_promotion ?? false,
                'unit' => $product->unit,
                'category' => $product->category->name ?? 'Nông sản',
                'url' => route('products.show', $product->id),
                'review_count' => $reviewCount,
                'average_rating' => $avgRating,
                'sample_reviews' => $sampleReviews
            ];
        })->toArray();
    }
}

