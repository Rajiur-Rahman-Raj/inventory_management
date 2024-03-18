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

            $stockInDetails = new StockInDetails();
            $stockInDetails->stock_in_id = $stockIn->id;
            $stockInDetails->item_id = $value;
            $stockInDetails->quantity = $request->item_quantity[$itemKey];
            $stockInDetails->cost_per_unit = $request->cost_per_unit[$itemKey];
            $stockInDetails->total_unit_cost = $request->total_unit_cost[$itemKey];
            $stockInDetails->stock_date = $request->stock_date;
            $stockInDetails->save();

            $rawItems = $request->raw_item_id[$itemKey];

            foreach ($rawItems as $rawItemKey => $rawItemId) {
                StockInExpenseRawItem::create([
                    'stock_in_details_id' => $stockInDetails->id,
                    'raw_item_id' => $rawItemId,
                    'quantity' => (int)$request->raw_item_quantity[$itemKey][$rawItemKey],
                ]);

                $rawItemPurchaseStock = RawItemPurchaseStock::with('rawItem')->where('company_id', $this->user->active_company_id)->find($rawItemId);

                throw_if(!$rawItemPurchaseStock, 'Raw item not available in stock');

                if ($rawItemPurchaseStock->quantity < (int)$request->raw_item_quantity[$itemKey][$rawItemKey]){
                    throw new \Exception("{$rawItemPurchaseStock->rawItem->name} raw item has only {$rawItemPurchaseStock->quantity} in stock. You gave {$request->raw_item_quantity[$itemKey][$rawItemKey]}");
                }

                $rawItemPurchaseStock->decrement('quantity', (int)$request->raw_item_quantity[$itemKey][$rawItemKey]);
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
            $stock->selling_price = $request->selling_price[$key];
            $stock->stock_date = ($stock->last_stock_date) ?? $request->stock_date;
            $stock->last_stock_date = $request->stock_date;
            $stock->save();
        }
    }
}

