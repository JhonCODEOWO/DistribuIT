<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function index(){
        return view('products/index');
    }

    function edit(Product $product){
        return view('products/edit', compact('product'));
    }

    function create(){
        return view('products/create');
    }
}
