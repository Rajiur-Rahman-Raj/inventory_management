<?php

namespace App\Http\Traits;


use App\Models\AffiliateMember;
use App\Models\AffiliateMemberCommission;
use App\Models\SalesItem;
use App\Models\SalesPayment;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait StoreSalesTrait
{

    public function getSalesProfit($request, $admin){
        $totalStockPrice = 0;
        $totalSellingPrice = $request->total_amount;

        foreach ($request->item_id as $key => $itemId) {
            $stock = Stock::with('item')
                ->when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin) {
                    return $query->where('company_id', $admin->active_company_id)->whereNull('sales_center_id');
                })
                ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin) {
                    return $query->where([
                        ['company_id', $admin->salesCenter->company_id],
                        ['sales_center_id', $admin->salesCenter->id],
                    ]);
                })
                ->where('item_id', $itemId)->select('last_cost_per_unit')->first();

            $totalStockPrice += $request->item_quantity[$key] * optional($stock)->last_cost_per_unit ?? 0;
        }

        $profit = $totalSellingPrice - $totalStockPrice;
        return $profit;
    }

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

    public function storeSalesPayments($request, $sale, $admin){
        $due_or_change_amount = (float)floor($request->due_or_change_amount);

        $salesPayment = new SalesPayment();
        $salesPayment->sale_id = $sale->id;
        $salesPayment->amount = $due_or_change_amount <= 0 ? $request->total_amount : $request->customer_paid_amount;
        $salesPayment->payment_date = Carbon::parse($request->payment_date);
        $salesPayment->note = $request->note;
        $salesPayment->paid_by = $admin->id;
        $salesPayment->save();
    }


    public function updateSalesItems($request, $sale)
    {

        $admin = auth()->user();
        foreach ($request->item_name as $key => $value) {
            $salesItem = SalesItem::where('sales_id', $sale->id)->where('stock_id', $request->stock_id[$key])->where('item_id', $request->item_id[$key])->first();

            $companyId = ($admin->user_type == 1) ? $admin->active_company_id : $admin->salesCenter->company_id;
            $salesCenterId = ($admin->user_type == 1) ? $sale->sales_center_id : $admin->salesCenter->id;

            $salesCenterStock = Stock::where([
                'company_id' => $companyId,
                'item_id' => $request->item_id[$key],
                'sales_center_id' => $salesCenterId,
            ])->first();


            $companyStock = Stock::where('company_id', $companyId)
                ->where('id', $request->stock_id[$key])
                ->where('item_id', $request->item_id[$key])
                ->whereNull('sales_center_id')
                ->first();

            if ($salesItem) {
                if (($sale->company_id && $sale->sales_center_id) && ($sale->customer_id == null)){
                    // sales center item return to company
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
                }else{
                    // customer item return to sales center + company
                    if ($admin->user_type == 1){
                        // customer return items to direct company
                        if ($salesItem->item_quantity > (int)$request->item_quantity[$key]) {
                            // company stock (+)
                            $updateStockQuantity = $salesItem->item_quantity - $request->item_quantity[$key];
                            $companyStock->quantity += $updateStockQuantity;
                            $companyStock->save();

                        } elseif ($salesItem->item_quantity < $request->item_quantity[$key]) {
                            // company stock (-)
                            $updateStockQuantity = $request->item_quantity[$key] - $salesItem->item_quantity;
                            $companyStock->quantity -= $updateStockQuantity;
                            $companyStock->save();
                        }
                    }else{
                        // customer return items to sales center
                        if ($salesItem->item_quantity > (int)$request->item_quantity[$key]) {
                            // sales center stock (+)
                            $updateStockQuantity = $salesItem->item_quantity - $request->item_quantity[$key];
                            $salesCenterStock->quantity += $updateStockQuantity;
                            $salesCenterStock->save();

                        } elseif ($salesItem->item_quantity < $request->item_quantity[$key]) {
                            // sales center stock (-)
                            $updateStockQuantity = $request->item_quantity[$key] - $salesItem->item_quantity;
                            $salesCenterStock->quantity -= $updateStockQuantity;
                            $salesCenterStock->save();
                        }
                    }
                }

                $salesItem->item_quantity = $request->item_quantity[$key];
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


//                $salesCenterStock = Stock::firstOrNew([
//                    'company_id' => $admin->active_company_id,
//                    'item_id' => $request->item_id[$key],
//                    'sales_center_id' => $sale->sales_center_id,
//                ]);

                if (($sale->company_id && $sale->sales_center_id) && ($sale->customer_id == null)){
                    // sales center purchase new item, so sales center stock (+) and company stock (-)
                    $salesCenterStock->company_id = $companyId;
                    $salesCenterStock->sales_center_id = $salesCenterId;
                    $salesCenterStock->item_id = $request->item_id[$key];
                    $salesCenterStock->quantity += (int)$request->item_quantity[$key];
                    $salesCenterStock->cost_per_unit = ($salesCenterStock->last_cost_per_unit) ?? $request->cost_per_unit[$key];
                    $salesCenterStock->last_cost_per_unit = $request->cost_per_unit[$key];
                    $salesCenterStock->selling_price = $request->cost_per_unit[$key];
                    $salesCenterStock->stock_date = (Carbon::parse($salesCenterStock->last_stock_date)) ?? Carbon::now();
                    $salesCenterStock->last_stock_date = Carbon::now();
                    $salesCenterStock->save();

                    $companyStock->quantity -= (int)$request->item_quantity[$key];
                    $companyStock->save();
                }else{
                    // customer purchase new item so company stock (-) or sales center stock (-)
                    if ($admin->user_type == 1){
                        // company stock (-)
                        $companyStock->quantity -= (int)$request->item_quantity[$key];
                        $companyStock->save();
                    }else{
                        $salesCenterStock->quantity -= (int)$request->item_quantity[$key];
                        $salesCenterStock->save();
                    }
                }



//
//                if (($sale->company_id && $sale->sales_center_id) && ($sale->customer_id == null)){
//                    $salesCenterStock->company_id = $admin->active_company_id;
//                    $salesCenterStock->sales_center_id = $sale->sales_center_id;
//                    $salesCenterStock->item_id = $request->item_id[$key];
//                    $salesCenterStock->quantity += (int)$request->item_quantity[$key];
//                    $salesCenterStock->cost_per_unit = ($salesCenterStock->last_cost_per_unit) ?? $request->cost_per_unit[$key];
//                    $salesCenterStock->last_cost_per_unit = $request->cost_per_unit[$key];
//                    $salesCenterStock->selling_price = $request->cost_per_unit[$key];
//                    $salesCenterStock->stock_date = ($salesCenterStock->last_stock_date) ?? Carbon::now();
//                    $salesCenterStock->last_stock_date = Carbon::now();
//                    $salesCenterStock->save();
//                }
//
//                $companyStock = Stock::where('company_id', $admin->active_company_id)->where('id', $request->stock_id[$key])->where('item_id', $request->item_id[$key])->whereNull('sales_center_id')->first();
//                $companyStock->quantity -= (int)$request->item_quantity[$key];
//                $companyStock->save();
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


    public function storeAndUpdateStocks($request, $sale, $items){
        $admin = $this->user;
        $companyId = ($admin->user_type == 1) ? $admin->active_company_id : $admin->salesCenter->company_id;
        $salesCenterId = ($admin->user_type == 1) ? $request->sales_center_id : $admin->salesCenter->id;

        foreach ($items as $item) {
            $salesCenterStock = Stock::firstOrNew([
                'company_id' => $companyId,
                'item_id' => $item['item_id'],
                'sales_center_id' => $salesCenterId,
            ]);

            if ($admin->user_type == 1){
                if (($sale->company_id && $sale->sales_center_id) && ($sale->customer_id == null)){
                    $salesCenterStock->company_id = $companyId;
                    $salesCenterStock->sales_center_id = $salesCenterId;
                    $salesCenterStock->item_id = $item['item_id'];
                    $salesCenterStock->quantity += (int)$item['item_quantity'];
                    $salesCenterStock->cost_per_unit = ($salesCenterStock->last_cost_per_unit) ?? $item['cost_per_unit'];
                    $salesCenterStock->last_cost_per_unit = $item['cost_per_unit'];
                    $salesCenterStock->selling_price = $item['cost_per_unit'];
                    $salesCenterStock->stock_date = (Carbon::parse($salesCenterStock->last_stock_date)) ?? Carbon::now();
                    $salesCenterStock->last_stock_date = Carbon::now();
                    $salesCenterStock->save();
                }
            }

            if ($admin->user_type == 2){
                $salesCenterStock->quantity -= (int)$item['item_quantity'];
                $salesCenterStock->save();
            }

            if ($admin->user_type == 1){
                $companyStock = Stock::where('company_id', $admin->active_company_id)->whereNull('sales_center_id')->where('item_id', $item['item_id'])->first();
                $companyStock->quantity -= (int)$item['item_quantity'];
                $companyStock->save();
            }
        }
    }

    public function giveAffiliateMembersCommission($request, $admin){

        $affiliateMembers = optional($admin->salesCenter)->affiliateMembers;

        if (count($affiliateMembers) > 0){
            foreach ($affiliateMembers as $key => $member){
                $affiliateMember = AffiliateMember::where('company_id', $admin->salesCenter->company_id)->findOrFail($member->affiliate_member_id);
                $memberCommissionPercentage = $affiliateMember->member_commission;
                $wifeCommissionPercentage = $affiliateMember->wife_commission;

                if ($affiliateMember->date_of_death == null){
                    $memberCommissionAmount = $request->total_amount * $memberCommissionPercentage / 100;
                    $affiliateMember->member_commission_amount += $memberCommissionAmount;
                    $affiliateMember->save();

                    $affiliateMemberCommission = new AffiliateMemberCommission();
                    $affiliateMemberCommission->company_id = $affiliateMember->company_id;
                    $affiliateMemberCommission->affiliate_member_id = $affiliateMember->id;
                    $affiliateMemberCommission->amount = $memberCommissionAmount;
                    $affiliateMemberCommission->commission_date = Carbon::now();
                    $affiliateMemberCommission->save();
                }else{
                    $wifeCommissionAmount = $request->total_amount * $wifeCommissionPercentage / 100;
                    $affiliateMember->wife_commission_amount += $wifeCommissionAmount;
                    $affiliateMember->save();

                    $affiliateMemberCommission = new AffiliateMemberCommission();
                    $affiliateMemberCommission->company_id = $affiliateMember->company_id;
                    $affiliateMemberCommission->affiliate_member_id = $affiliateMember->id;
                    $affiliateMemberCommission->amount = $memberCommissionAmount;
                    $affiliateMemberCommission->commission_date = Carbon::now();
                    $affiliateMemberCommission->commission_by = 2;
                    $affiliateMemberCommission->save();
                }

                $totalCommissionAmount =  $affiliateMember->member_commission_amount + $affiliateMember->wife_commission_amount;
                $affiliateMember->total_commission_amount = $totalCommissionAmount;
                $affiliateMember->save();
            }
        }

    }


}

