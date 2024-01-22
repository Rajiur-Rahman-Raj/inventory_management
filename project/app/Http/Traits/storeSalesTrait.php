<?php

namespace App\Http\Traits;


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
        $admin = auth()->user();
        foreach ($request->item_name as $key => $value) {
            $salesItem = SalesItem::where('sales_id', $sale->id)->where('stock_id', $request->stock_id[$key])->where('item_id', $request->item_id[$key])->first();

            $salesCenterStock = Stock::where([
                'company_id' => $admin->active_company_id,
                'item_id' => $request->item_id[$key],
                'sales_center_id' => $sale->sales_center_id,
            ])->first();

            $companyStock = Stock::where('company_id', $admin->active_company_id)
                ->where('id', $request->stock_id[$key])
                ->where('item_id', $request->item_id[$key])
                ->whereNull('sales_center_id')
                ->first();

            if ($salesItem) {
                if ($salesItem->item_quantity > (int)$request->item_quantity[$key]) {
                    // company stock (+) and sales center stock (-)
                    $updateStockQuantity = $salesItem->item_quantity - $request->item_quantity[$key];
                    $salesCenterStock->quantity -= $updateStockQuantity;
                    $salesCenterStock->save();

                    $companyStock->quantity += $updateStockQuantity;
                    $companyStock->save();

                } elseif ($salesItem->item_quantity < $request->item_quantity[$key]) {
                    // company stock (-) and sales center stock (+)
                    $updateStockQuantity = $request->item_quantity[$key] - $salesItem->item_quantity;
                    $companyStock->quantity -= $updateStockQuantity;
                    $companyStock->save();

                    $salesCenterStock->quantity += $updateStockQuantity;
                    $salesCenterStock->save();
                }

                $salesItem->item_quantity = ($salesItem->item_quantity > (int)$request->item_quantity[$key] ? ($salesItem->item_quantity - (int)$request->item_quantity[$key]) : $request->item_quantity[$key]);
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


                $salesCenterStock = Stock::firstOrNew([
                    'company_id' => $admin->active_company_id,
                    'item_id' => $request->item_id[$key],
                    'sales_center_id' => $sale->sales_center_id,
                ]);

                $salesCenterStock->company_id = $admin->active_company_id;
                $salesCenterStock->sales_center_id = $sale->sales_center_id;
                $salesCenterStock->item_id = $request->item_id[$key];
                $salesCenterStock->quantity += (int)$request->item_quantity[$key];
                $salesCenterStock->cost_per_unit = ($salesCenterStock->last_cost_per_unit) ?? $request->cost_per_unit[$key];
                $salesCenterStock->last_cost_per_unit = $request->cost_per_unit[$key];
                $salesCenterStock->selling_price = $request->cost_per_unit[$key];
                $salesCenterStock->stock_date = ($salesCenterStock->last_stock_date) ?? Carbon::now();
                $salesCenterStock->last_stock_date = Carbon::now();
                $salesCenterStock->save();

                $companyStock = Stock::where('company_id', $admin->active_company_id)->where('id', $request->stock_id[$key])->where('item_id', $request->item_id[$key])->whereNull('sales_center_id')->first();
                $companyStock->quantity -= (int)$request->item_quantity[$key];
                $companyStock->save();
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


    public function storeAndUpdateStocks($request, $items, $admin){
        foreach ($items as $item) {
            $salesCenterStock = Stock::firstOrNew([
                'company_id' => $admin->active_company_id,
                'item_id' => $item['item_id'],
                'sales_center_id' => $request->sales_center_id,
            ]);

            $salesCenterStock->company_id = $admin->active_company_id;
            $salesCenterStock->sales_center_id = $request->sales_center_id;
            $salesCenterStock->item_id = $item['item_id'];
            $salesCenterStock->quantity += (int)$item['item_quantity'];
            $salesCenterStock->cost_per_unit = ($salesCenterStock->last_cost_per_unit) ?? $item['cost_per_unit'];
            $salesCenterStock->last_cost_per_unit = $item['cost_per_unit'];
            $salesCenterStock->selling_price = $item['cost_per_unit'];
            $salesCenterStock->stock_date = ($salesCenterStock->last_stock_date) ?? Carbon::now();
            $salesCenterStock->last_stock_date = Carbon::now();
            $salesCenterStock->save();

            $companyStock = Stock::where('company_id', $admin->active_company_id)->whereNull('sales_center_id')->where('item_id', $item['item_id'])->first();
            $companyStock->quantity -= (int)$item['item_quantity'];
            $companyStock->save();
        }
    }


}

