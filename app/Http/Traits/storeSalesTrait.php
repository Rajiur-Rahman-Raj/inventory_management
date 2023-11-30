<?php

namespace App\Http\Traits;


use App\Models\SalesItem;

trait StoreSalesTrait
{
    public function storeSalesItems($request, $sale)
    {
        $items = [];

        foreach ($request->item_name as $key => $value) {
            $items[] = [
                'item_id' => $request->item_id[$key],
                'item_name' => $value,
                'item_quantity' => $request->item_quantity[$key],
                'item_price' => $request->item_price[$key],
            ];
        }

        $sale->items = $items;

        return $items;
    }


    public function storeSalesItemsInSalesItemModel($request, $sale){
        foreach ($request->item_name as $key => $value) {
            $salesItem = new SalesItem();
            $salesItem->sales_id = $sale->id;
            $salesItem->item_id = $request->item_id[$key];
            $salesItem->item_name = $value;
            $salesItem->item_quantity = $request->item_quantity[$key];
            $salesItem->item_price = $request->item_price[$key];
            $salesItem->save();
        }
    }

}

