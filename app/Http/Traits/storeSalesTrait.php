<?php

namespace App\Http\Traits;


trait StoreSalesTrait
{
    public function storeSalesItems($request, $sale)
    {
        $items = [];
        foreach ($request->item_name as $key => $value) {
            $items[] = [
                'item_name' => $value,
                'item_quantity' => $request->item_quantity[$key],
                'item_price' => $request->item_price[$key],
            ];
        }
        $sale->items = $items;
    }

}

