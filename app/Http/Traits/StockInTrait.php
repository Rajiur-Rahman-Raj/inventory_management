<?php

namespace App\Http\Traits;


use App\Models\Stock;
use App\Models\StockInDetails;

trait StockInTrait
{
    public function storeStockInDetails($request, $stockIn)
    {
        foreach ($request->item_id as $key => $value){
            $stockInDetails = new StockInDetails();
            $stockInDetails->stock_in_id = $stockIn->id;
            $stockInDetails->item_id = $value;
            $stockInDetails->quantity = $request->item_quantity[$key];
            $stockInDetails->cost_per_unit = $request->cost_per_unit[$key];
            $stockInDetails->total_unit_cost = $request->total_unit_cost[$key];
            $stockInDetails->save();
        }
    }

    public function storeStocks($request, $loggedInUser){
        foreach ($request->item_id as $key => $value){

            $stock = Stock::firstOrNew([
                'company_id' => $loggedInUser->active_company_id,
                'item_id' => $value,
            ]);

            $stock->company_id = $loggedInUser->active_company_id;
            $stock->item_id = $value;
            $stock->quantity += $request->item_quantity[$key];
            $stock->cost_per_unit = ($stock->last_cost_per_unit)??$request->cost_per_unit[$key];
            $stock->last_cost_per_unit = $request->cost_per_unit[$key];
            $stock->save();
        }

    }

}

