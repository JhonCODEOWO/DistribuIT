<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest;
use App\Models\Sale;
use App\Services\SaleService;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sales/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sales/create');
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
    public function show(Sale $sale)
    {
        return view('sales/view', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaleRequest $request, Sale $sale, SaleService $saleService)
    {
        return $saleService->update($sale->id, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
