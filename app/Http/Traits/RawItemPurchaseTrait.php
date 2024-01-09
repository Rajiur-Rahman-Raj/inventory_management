<?php

namespace App\Http\Traits;


use App\Models\RawItemPurchaseInDetails;
use App\Models\RawItemPurchaseStock;

trait RawItemPurchaseTrait
{
    public function storeRawItemPurchaseInDetails($request, $purchaseIn)
    {

        foreach ($request->item_id as $key => $value){
            $purchaseInDetails = new RawItemPurchaseInDetails();
            $purchaseInDetails->raw_item_purchase_in_id = $purchaseIn->id;
            $purchaseInDetails->raw_item_id = $value;
            $purchaseInDetails->quantity = $request->item_quantity[$key];
            $purchaseInDetails->cost_per_unit = $request->cost_per_unit[$key];
            $purchaseInDetails->total_unit_cost = $request->total_unit_cost[$key];
            $purchaseInDetails->purchase_date = $request->purchase_date;
            $purchaseInDetails->save();
        }
    }


    public function storeRawItemPurchaseStock($request, $loggedInUser){
        foreach ($request->item_id as $key => $value){
            $purchaseStock = RawItemPurchaseStock::firstOrNew([
                'company_id' => $loggedInUser->active_company_id,
                'supplier_id' => $request->supplier_id,
                'raw_item_id' => $value,
            ]);

            $purchaseStock->company_id = $loggedInUser->active_company_id;
            $purchaseStock->supplier_id = $request->supplier_id;
            $purchaseStock->raw_item_id = $value;
            $purchaseStock->quantity += $request->item_quantity[$key];
            $purchaseStock->cost_per_unit = ($purchaseStock->last_cost_per_unit) ?? $request->cost_per_unit[$key];
            $purchaseStock->last_cost_per_unit = $request->cost_per_unit[$key];

            $purchaseStock->purchase_date = ($purchaseStock->last_purchase_date) ?? $request->purchase_date;
            $purchaseStock->last_purchase_date = $request->purchase_date;
            $purchaseStock->save();
        }

    }

}

