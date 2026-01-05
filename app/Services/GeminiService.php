<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $baseUrl;
    protected $model;
    protected $temperature;
    protected $maxTokens;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->baseUrl = config('services.gemini.base_url');
        $this->model = config('services.gemini.model');
        $this->temperature = config('services.gemini.temperature');
        $this->maxTokens = config('services.gemini.max_tokens');
    }

    /**
     * Gửi chat message đến Gemini Pro
     */
    public function chat($message, $context = [])
    {
        try {
            // Xây dựng prompt với context
            $prompt = $this->buildPrompt($message, $context);

            // Gọi Gemini API (API key trong URL)
            $url = "{$this->baseUrl}/models/{$this->model}:generateContent?key={$this->apiKey}";
            
            $response = Http::timeout(30)
                ->post($url, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => $this->temperature,
                        'maxOutputTokens' => $this->maxTokens,
                        'topP' => 0.8,
                        'topK' => 40,
                    ],
                    'safetySettings' => [
                        [
                            'category' => 'HARM_CATEGORY_HARASSMENT',
                            'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                        ],
                        [
                            'category' => 'HARM_CATEGORY_HATE_SPEECH',
                            'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                        ],
                    ]
                ]);

            if ($response->failed()) {
                $payload = [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'url' => $url,
                    'model' => $this->model,
                    'base_url' => $this->baseUrl,
                ];

                // Log chi tiết để xem trong terminal (log stack)
                Log::error('Gemini API Error', $payload);

                return [
                    'success' => false,
                    // Đẩy mã lỗi và body về FE để hiển thị/debug
                    'reply' => 'API lỗi: ' . $response->status(),
                    'error' => $payload,
                ];
            }

            $data = $response->json();

            // Trích xuất reply từ response
            $reply = $this->extractReply($data);

            return [
                'success' => true,
                'reply' => $reply,
                'suggestions' => $this->generateSuggestions($context)
            ];

        } catch (\Exception $e) {
            Log::error('Gemini Service Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'reply' => 'Exception: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Xây dựng prompt với context
     */
    protected function buildPrompt($message, $context)
    {
        $systemPrompt = "Bạn là trợ lý AI thông minh của FARM FRESH - website bán nông sản sạch trực tuyến.\n\n";
        $systemPrompt .= "NHIỆM VỤ:\n";
        $systemPrompt .= "- Hỗ trợ khách hàng tìm kiếm, tư vấn sản phẩm nông sản\n";
        $systemPrompt .= "- Trả lời câu hỏi về sản phẩm, giá cả, khuyến mãi\n";
        $systemPrompt .= "- Gợi ý sản phẩm phù hợp với nhu cầu\n";
        $systemPrompt .= "- Hướng dẫn đặt hàng, thanh toán\n\n";
        
        $systemPrompt .= "QUY TẮC:\n";
        $systemPrompt .= "- CHỈ trả lời về sản phẩm và dịch vụ của FARM FRESH\n";
        $systemPrompt .= "- Nếu câu hỏi ngoài phạm vi, lịch sự từ chối và hướng dẫn quay lại chủ đề\n";
        $systemPrompt .= "- Trả lời ngắn gọn, rõ ràng, thân thiện bằng tiếng Việt\n";
        $systemPrompt .= "- Khi đề xuất sản phẩm, đưa tên và giá cụ thể\n";
        $systemPrompt .= "- LUÔN LUÔN nhấn mạnh sản phẩm đang GIẢM GIÁ, phần trăm giảm và giá sau giảm\n";
        $systemPrompt .= "- Ưu tiên đề xuất sản phẩm đang giảm giá khi khách hỏi về khuyến mãi\n";
        $systemPrompt .= "- Khi đề xuất sản phẩm, NÊU RÕ số sao đánh giá và nhận xét của khách hàng (nếu có)\n";
        $systemPrompt .= "- Ưu tiên sản phẩm có đánh giá cao (4-5 sao) khi tư vấn\n";
        $systemPrompt .= "- Khuyến khích khách hàng xem chi tiết hoặc thêm vào giỏ\n\n";

        // Thêm thông tin người dùng nếu có
        if (isset($context['user'])) {
            $systemPrompt .= "THÔNG TIN KHÁCH HÀNG:\n";
            $systemPrompt .= "- Tên: {$context['user']['name']}\n";
            if (isset($context['user']['is_member']) && $context['user']['is_member']) {
                $systemPrompt .= "- Trạng thái: Thành viên\n";
            }
            $systemPrompt .= "\n";
        }

        // Thêm thông tin giỏ hàng
        if (isset($context['cart']) && count($context['cart']) > 0) {
            $systemPrompt .= "GIỎ HÀNG HIỆN TẠI:\n";
            foreach ($context['cart'] as $item) {
                $systemPrompt .= "- {$item['name']}: {$item['quantity']} {$item['unit']} (";
                $systemPrompt .= number_format($item['price']) . "đ)\n";
            }
            $systemPrompt .= "\n";
        }

        // Thêm sản phẩm yêu thích
        if (isset($context['favorites']) && count($context['favorites']) > 0) {
            $systemPrompt .= "SẢN PHẨM YÊU THÍCH:\n";
            foreach ($context['favorites'] as $fav) {
                $systemPrompt .= "- {$fav['name']} ({$fav['category']})\n";
            }
            $systemPrompt .= "\n";
        }

        // Thêm danh sách sản phẩm có sẵn
        if (isset($context['products']) && count($context['products']) > 0) {
            $systemPrompt .= "SẢN PHẨM CÓ SẴN:\n";
            foreach ($context['products'] as $product) {
                $systemPrompt .= "- {$product['name']} ({$product['category']}): ";
                
                // Hiển thị giá giảm nếu có
                if (isset($product['has_promotion']) && $product['has_promotion'] && 
                    isset($product['discounted_price']) && $product['discounted_price'] < $product['price']) {
                    $discount_percent = round((($product['price'] - $product['discounted_price']) / $product['price']) * 100);
                    $systemPrompt .= number_format($product['discounted_price']) . "đ/{$product['unit']}";
                    $systemPrompt .= " (ĐANG GIẢM {$discount_percent}% từ " . number_format($product['price']) . "đ)";
                } else {
                    $systemPrompt .= number_format($product['price']) . "đ/{$product['unit']}";
                }
                
                // Thêm thông tin đánh giá
                if (isset($product['review_count']) && $product['review_count'] > 0) {
                    $stars = str_repeat('⭐', (int)$product['average_rating']);
                    $systemPrompt .= " | {$stars} {$product['average_rating']}/5 ({$product['review_count']} đánh giá)";
                    
                    // Thêm review mẫu nếu có
                    if (isset($product['sample_reviews']) && count($product['sample_reviews']) > 0) {
                        $systemPrompt .= " - Khách hàng nói: \"";
                        $firstReview = $product['sample_reviews'][0];
                        $systemPrompt .= ($firstReview['comment'] ?? 'Sản phẩm tốt') . "\"";
                    }
                }
                
                $systemPrompt .= "\n";
            }
            $systemPrompt .= "\n";
        }

        $systemPrompt .= "CÂU HỎI CỦA KHÁCH: {$message}\n\n";
        $systemPrompt .= "TRẢ LỜI (ngắn gọn, thân thiện):";

        return $systemPrompt;
    }

    /**
     * Trích xuất reply từ Gemini response
     */
    protected function extractReply($data)
    {
        if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            return trim($data['candidates'][0]['content']['parts'][0]['text']);
        }

        if (isset($data['error'])) {
            Log::error('Gemini API returned error', ['error' => $data['error']]);
        }

        return 'Xin lỗi, tôi không thể tạo phản hồi lúc này.';
    }

    /**
     * Tạo gợi ý câu hỏi nhanh
     */
    protected function generateSuggestions($context)
    {
        $suggestions = [
            'Có sản phẩm nào đang giảm giá?',
            'Tôi muốn mua rau củ tươi',
            'Sản phẩm nào bán chạy nhất?',
        ];

        // Thêm gợi ý dựa trên context
        if (isset($context['cart']) && count($context['cart']) > 0) {
            $suggestions[] = 'Tôi muốn thanh toán';
        }

        if (isset($context['favorites']) && count($context['favorites']) > 0) {
            $suggestions[] = 'Sản phẩm yêu thích có sẵn không?';
        }

        return array_slice($suggestions, 0, 3);
    }

    /**
     * Kiểm tra API key có hợp lệ không
     */
    public function isConfigured()
    {
        return !empty($this->apiKey);
    }
}
