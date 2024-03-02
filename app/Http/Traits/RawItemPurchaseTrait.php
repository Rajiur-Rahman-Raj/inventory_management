<?php

namespace App\Http\Traits;


use App\Models\PurchaseRawItemMakePayment;
use App\Models\RawItemPurchaseInDetails;
use App\Models\RawItemPurchaseStock;
use Carbon\Carbon;

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

    public function storePurchaseRawItemMakePayment($request, $purchaseIn, $admin){
        $purchaseRawItemMakePayment = new PurchaseRawItemMakePayment();
        $purchaseRawItemMakePayment->raw_item_purchase_in_id = $purchaseIn->id;
        $purchaseRawItemMakePayment->amount = $request->total_payable_amount;
        $purchaseRawItemMakePayment->payment_date = Carbon::parse($request->payment_date);
        $purchaseRawItemMakePayment->due = $purchaseIn->due_amount;
        $purchaseRawItemMakePayment->note = $request->note;
        $purchaseRawItemMakePayment->paid_by = $admin->id;
        $purchaseRawItemMakePayment->save();
    }


    public function storeRawItemPurchaseStock($request, $purchaseIn, $admin){
        foreach ($request->item_id as $key => $value){
            $purchaseStock = RawItemPurchaseStock::firstOrNew([
                'company_id' => $admin->active_company_id,
                'raw_item_id' => $value,
            ]);

            $purchaseStock->company_id = $admin->active_company_id;
            $purchaseStock->supplier_id = $request->supplier_id;
            $purchaseStock->raw_item_purchase_in_id = $purchaseIn->id;
            $purchaseStock->raw_item_id = $value;
            $purchaseStock->quantity += $request->item_quantity[$key];
            $purchaseStock->cost_per_unit = ($purchaseStock->last_cost_per_unit) ?? $request->cost_per_unit[$key];
            $purchaseStock->last_cost_per_unit = $request->cost_per_unit[$key];

            $purchaseStock->purchase_date = (Carbon::parse($purchaseStock->last_purchase_date)) ?? Carbon::parse($request->purchase_date);
            $purchaseStock->last_purchase_date = Carbon::parse($request->purchase_date);
            $purchaseStock->save();
        }

    }

}

