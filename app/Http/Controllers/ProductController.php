<?php

namespace App\Http\Controllers;

use App\DTOs\ProductDTO;
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

    function find(Pagination $request, ProductService $productService){
        $paginated = $request->query('paginated', true);
        return response()->json($productService->findAll($paginated));
    }

    function findOne(string $slug, ProductService $productService){
        return response()->json(new ProductDTO($productService->findOne($slug)));
    }
}
