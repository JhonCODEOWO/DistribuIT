<?php

namespace App\Rules;

class SaleFormRules
{
    public static function createRules(): array
    {
        return  [
            "lng" => 'required',
            "lat" => 'required',
            "street" => "required",
            "city" => "required",
            "internal_number" => "required",
            "external_number" => "required",
            "references" => "required",
            "due_date" => "required|date",
            "products" => "required|array|min:1",
            "products.*.product_id" => "required|exists:products,id|distinct",
            "products.*.quantity" => "required|integer|min:1",
        ];
    }

    public static function updateRules(): array
    {
        return [
                "lng" => 'nullable',
                "lat" => 'nullable',
                "street" => "nullable",
                "city" => "nullable",
                "internal_number" => "nullable",
                "external_number" => "nullable",
                "references" => "nullable",
                "due_date" => "nullable|date",
                // "products" => "required|array|min:1",
                // "products.*.product_id" => "required|exists:products,id|distinct",
                // "products.*.quantity" => "required|integer|min:1",
        ];
    }

    // "city": "Zacatlán",
}
