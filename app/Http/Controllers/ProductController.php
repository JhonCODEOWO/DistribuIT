<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pagination;
use App\Models\Product;
use App\Services\ProductService;
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

    function find(Pagination $request){
        $paginated = $request->query('paginated', true);
        return ($paginated)? response()->json(Product::paginate(2)): response()->json(Product::all());
    }

    function findOne(string $slug, ProductService $productService){
        return response()->json($productService->findOne($slug));
    }
}
