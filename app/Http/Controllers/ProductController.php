<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        // Load reviews with user info
        $product->load('reviews.user', 'category');
        
        return view('products.show', compact('product'));
    }
}
