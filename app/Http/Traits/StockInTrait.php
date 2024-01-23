<?php

namespace App\Http\Traits;


use App\Models\ExpenseRawItem;
use App\Models\RawItemPurchaseStock;
use App\Models\Stock;
use App\Models\StockInDetails;
use App\Models\StockInExpenseRawItem;
use Exception;
use Illuminate\Database\QueryException;

trait StockInTrait
{
    public function storeStockInDetails($request, $stockIn)
    {
        foreach ($request->item_id as $itemKey => $value) {
            $stockInDetails = StockInDetails::create([
                'stock_in_id' => $stockIn->id,
                'item_id' => $value,
                'quantity' => $request->item_quantity[$itemKey],
                'cost_per_unit' => $request->cost_per_unit[$itemKey],
                'total_unit_cost' => $request->total_unit_cost[$itemKey],
                'stock_date' => $request->stock_date,
            ]);

            $rawItems = $request->raw_item_id[$itemKey];
            foreach ($rawItems as $rawItemKey => $rawItemId) {
                StockInExpenseRawItem::create([
                    'stock_in_details_id' => $stockInDetails->id,
                    'raw_item_id' => $rawItemId,
                    'quantity' => $request->raw_item_quantity[$itemKey][$rawItemKey],
                ]);

                $rawItemPurchaseStock = RawItemPurchaseStock::where('company_id', $this->user->active_company_id)
                    ->findOrFail($rawItemId);

                throw_if($rawItemPurchaseStock->quantity <= 0, new Exception('Raw item stock quantity finished'));

                $rawItemPurchaseStock->decrement('quantity', $request->raw_item_quantity[$itemKey][$rawItemKey]);
            }
        }
    }


    public function storeStocks($request, $loggedInUser)
    {
        foreach ($request->item_id as $key => $value) {
            $stock = Stock::firstOrNew([
                'company_id' => $loggedInUser->active_company_id,
                'item_id' => $value,
            ]);

            $stock->company_id = $loggedInUser->active_company_id;
            $stock->item_id = $value;
            $stock->quantity += $request->item_quantity[$key];
            $stock->cost_per_unit = ($stock->last_cost_per_unit) ?? $request->cost_per_unit[$key];
            $stock->last_cost_per_unit = $request->cost_per_unit[$key];
            $stock->selling_price = $request->cost_per_unit[$key];

            $stock->stock_date = ($stock->last_stock_date) ?? $request->stock_date;
            $stock->last_stock_date = $request->stock_date;
            $stock->save();
        }

    }

}

