<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SaleDeleteRequest;
use App\Http\Requests\SaleIndexRequest;
use App\Http\Requests\SaleRequest;
use App\Http\Requests\SaleShowRequest;
use App\Models\Sale;
use App\Services\SaleService;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SaleService $saleService, SaleIndexRequest $request){
        $searchQuery = $request->query('searchQuery') ?? '';
        return $saleService->findAll($searchQuery);
    }

    /**
     * Store a newly created resource in storage.
     */
        public function store(SaleRequest $request, SaleService $saleService)
    {
        $user = $request->user();
        $dataSale = $request->safe()->except('products');
        $dataSale["user_id"] = $user->id;

        return response()->json($saleService->createAndAppendProducts($dataSale, $request->safe()->products));
    }

    /**
     * Display the specified resource.
     */
    public function show(SaleShowRequest $request, SaleService $saleService)
    {
        return response()->json($saleService->findOne($request->sale));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaleRequest $request, Sale $sale, SaleService $saleService)
    {
        $saleData = $request->safe()->except('products');
        $products = $request->safe()->products ?? [];
        return $saleService->update($sale->id, $saleData, $products);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SaleDeleteRequest $request, SaleService $saleService)
    {
        $valid = $request->validated();
        return response()->json($saleService->delete($valid['sale'], ["soft" => true]));
    }
}
