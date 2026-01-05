<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Favorite;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class FavoriteController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $user = Auth::user();

        /** @var LengthAwarePaginator $favorites */
        $favorites = Favorite::with('product')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(12);

        return view('favorites.index', compact('favorites'));
    }

    public function toggle(Product $product)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => 'unauthenticated',
                'message' => 'Vui lòng đăng nhập để dùng danh sách yêu thích.',
                'redirect' => route('login'),
            ], 401);
        }

        $fav = Favorite::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($fav) {
            $fav->delete();
            $favorited = false;
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
            $favorited = true;
        }

        return response()->json([
            'status' => 'ok',
            'favorited' => $favorited,
        ]);
    }
}
