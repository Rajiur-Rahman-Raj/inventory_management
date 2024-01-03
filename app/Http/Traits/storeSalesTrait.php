<?php

namespace App\Http\Traits;


use App\Models\CartItems;
use App\Models\SalesItem;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait StoreSalesTrait
{
    public function storeSalesItems($request, $sale)
    {
        $items = [];

        foreach ($request->item_name as $key => $value) {
            $items[] = [
                'stock_id' => $request->stock_id[$key],
                'item_id' => $request->item_id[$key],
                'item_name' => $value,
                'item_quantity' => $request->item_quantity[$key],
                'cost_per_unit' => $request->cost_per_unit[$key],
                'item_price' => $request->item_price[$key],
            ];
        }

        $sale->items = $items;

        return $items;
    }


    public function storeSalesItemsInSalesItemModel($request, $sale)
    {
        foreach ($request->item_name as $key => $value) {
            $salesItem = new SalesItem();
            $salesItem->sales_id = $sale->id;
            $salesItem->stock_id = $request->stock_id[$key];
            $salesItem->item_id = $request->item_id[$key];
            $salesItem->item_name = $value;
            $salesItem->item_quantity = $request->item_quantity[$key];
            $salesItem->cost_per_unit = $request->cost_per_unit[$key];
            $salesItem->item_price = $request->item_price[$key];
            $salesItem->save();
        }
    }

    public function updateSalesItems($request, $sale)
    {
        foreach ($request->item_name as $key => $value) {
            $salesItem = SalesItem::where('sales_id', $sale->id)->where('stock_id', $request->stock_id[$key])->where('item_id', $request->item_id[$key])->first();

            if ($salesItem) {
                $stock = Stock::where('id', $request->stock_id[$key])->where('item_id', $request->item_id[$key])->first();
                if ($salesItem->item_quantity > (int)$request->item_quantity[$key]) {
                    $updateStockQuantity = $salesItem->item_quantity - $request->item_quantity[$key]; // stock +
                    $stock->quantity = $stock->quantity + $updateStockQuantity;
                    $stock->save();
                } elseif ($salesItem->item_quantity < $request->item_quantity[$key]) {
                    $updateStockQuantity = $request->item_quantity[$key] - $salesItem->item_quantity; // stock -
                    $stock->quantity = $stock->quantity - $updateStockQuantity;
                    $stock->save();
                }

                $salesItem->item_quantity = ($salesItem->item_quantity > $request->item_quantity[$key] ? ($salesItem->item_quantity - $request->item_quantity[$key]) : $request->item_quantity[$key]);
                $salesItem->cost_per_unit = $request->cost_per_unit[$key];
                $salesItem->item_price = $request->item_price[$key];
                $salesItem->save();
            } else {
                $newSalesItem = new SalesItem();
                $newSalesItem->sales_id = $sale->id;
                $newSalesItem->stock_id = $request->stock_id[$key];
                $newSalesItem->item_id = $request->item_id[$key];
                $newSalesItem->item_name = $value;
                $newSalesItem->item_quantity = $request->item_quantity[$key];
                $newSalesItem->cost_per_unit = $request->cost_per_unit[$key];
                $newSalesItem->item_price = $request->item_price[$key];
                $newSalesItem->save();

                $stock = Stock::where('id', $request->stock_id[$key])->where('item_id', $request->item_id[$key])->first();
                $stock->quantity = (int)$stock->quantity - (int)$request->item_quantity[$key];
                $stock->save();
            }

        }
    }




    public function updateSalesItemsInSalesItemModel($request, $sale)
    {
        foreach ($request->item_name as $key => $value) {
            $salesItem = SalesItem::where('sales_id', $sale->id)
                ->where('stock_id', $request->stock_id[$key])
                ->where('item_id', $request->item_id[$key])
                ->first();

            if (!$salesItem) {
                // If SalesItem does not exist, create a new one
                $salesItem = new SalesItem();
                $salesItem->sales_id = $sale->id;
                $salesItem->stock_id = $request->stock_id[$key];
                $salesItem->item_id = $request->item_id[$key];
                $salesItem->item_name = $value;
                $salesItem->item_quantity = $request->item_quantity[$key];
                $salesItem->cost_per_unit = $request->cost_per_unit[$key];
                $salesItem->item_price = $request->item_price[$key];
                $salesItem->save();

                $stock = Stock::where('company_id', Auth::user()->active_company_id)->whereNull('sales_center_id')->select('id', 'quantity')->where('item_id', $salesItem->item_id)->first();
                $stock->quantity = (int)$stock->quantity - (int)$salesItem->item_quantity;
                $stock->save();
            }

            // Update or set values
            $salesItem->item_name = $value;
            $salesItem->item_quantity = $request->item_quantity[$key];
            $salesItem->cost_per_unit = $request->cost_per_unit[$key];
            $salesItem->item_price = $request->item_price[$key];
            $salesItem->save();
        }
    }


}

