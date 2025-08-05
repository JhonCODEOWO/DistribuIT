<?php

namespace App\Http\Controllers;

use App\DTOs\ProductDTO;
use App\Http\Requests\Pagination;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OAT;

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

    #[OAT\Get(
        path: '/api/products/list',
        tags: ['products'],
        description: 'Get products paginated or not',
        parameters: [
            new OAT\Parameter(name:'paginated', description: 'A flag to retrieve all products in one response or a paginated response', required: false, in: 'query'),
            new OAT\Parameter(name: 'page', description: 'Page of the elements to retrieve from the paginator', required: false, in:'query'),
            new OAT\Parameter(name: 'query', description: 'Keyword to search products', required: false, in:'query')
        ],
        responses: [
            new OAT\Response(response: 200,description: 'Paginated instance or array with all items'),
        ]
    )]
    function find(Pagination $request, ProductService $productService){
        $paginated = $request->query('paginated', true);
        $querySearch = $request->query('query', '');
        return response()->json($productService->findAll($paginated, $querySearch));
    }

    function findOne(string $slug, ProductService $productService){
        return response()->json(new ProductDTO($productService->findOne($slug)));
    }
}
