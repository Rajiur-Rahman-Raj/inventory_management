<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use App\Models\AffiliateMember;
use App\Models\CentralPromoter;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\IdentifyForm;
use App\Models\RawItem;
use App\Models\RawItemPurchaseIn;
use App\Models\RawItemPurchaseStock;
use App\Models\Sale;
use App\Models\SalesCenter;
use App\Models\Stock;
use App\Models\StockIn;
use App\Models\Supplier;
use App\Models\UserSocial;
use App\Models\Wastage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Stevebauman\Purify\Facades\Purify;


class HomeController extends Controller
{
    use Upload, Notify;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
        $this->theme = template();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function getSalesCenterYearSalesTransactionChartRecords()
    {
        $admin = $this->user;
        $basic = config('basic');
        $today = today();
        $data['yearLabels'] = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];

        $monthlySalesCenterSalesTransactions = Sale::when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin, $today) {
            return $query->where([
                ['company_id', $admin->salesCenter->company_id],
                ['sales_center_id', $admin->salesCenter->id],
                ['sales_by', 2],
            ])
                ->whereNotNull('customer_id')
                ->select('created_at')
                ->whereYear('created_at', $today)
                ->groupBy([DB::raw("DATE_FORMAT(created_at, '%m')")])
                ->selectRaw('SUM(total_amount) AS totalSalesAmount')
                ->selectRaw('SUM(CASE WHEN customer_id IS NOT NULL AND sales_by = 2 AND payment_status = 0 THEN due_amount END) AS totalDueAmount')
                ->get()
                ->groupBy([function ($query) {
                    return $query->created_at->format('F');
                }]);
        });


        $monthlySalesCenterStockTransactions = StockIn::when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin, $today) {
            return $query->where([
                ['company_id', $admin->salesCenter->company_id],
                ['sales_center_id', $admin->salesCenter->id],
            ])->select('created_at')
                ->whereYear('created_at', $today)
                ->groupBy([DB::raw("DATE_FORMAT(created_at, '%m')")])
                ->selectRaw('SUM(total_cost) AS totalStockAmount')
                ->get()
                ->groupBy([function ($query) {
                    return $query->created_at->format('F');
                }]);
        });

        $yearTotalStockAmount = [];
        $yearTotalSalesAmount = [];
        $yearTotalDueAmount = [];

        foreach ($data['yearLabels'] as $yearLabel) {
            $currentTotalStockAmount = 0;
            $currentTotalSalesAmount = 0;
            $currentTotalDueAmount = 0;

            if (isset($monthlySalesCenterStockTransactions[$yearLabel])) {
                foreach ($monthlySalesCenterStockTransactions[$yearLabel] as $key => $stock) {
                    $currentTotalStockAmount += $stock->totalStockAmount;
                }
            }

            if (isset($monthlySalesCenterSalesTransactions[$yearLabel])) {
                foreach ($monthlySalesCenterSalesTransactions[$yearLabel] as $key => $sale) {
                    $currentTotalSalesAmount += $sale->totalSalesAmount;
                    $currentTotalDueAmount += $sale->totalDueAmount;
                }
            }

            $yearTotalStockAmount[] = $currentTotalStockAmount;
            $yearTotalSalesAmount[] = $currentTotalSalesAmount;
            $yearTotalDueAmount[] = $currentTotalDueAmount;
        }

        $data['yearSalesCenterSalesTransactionChartRecords'] = [
            'yearLabels' => $data['yearLabels'],
            'yearTotalStockAmount' => $yearTotalStockAmount,
            'yearTotalSalesAmount' => $yearTotalSalesAmount,
            'yearTotalDueAmount' => $yearTotalDueAmount,
        ];

        return response()->json(['data' => $data, 'basic' => $basic]);

    }

    public function getYearSalesTransactionChartRecords()
    {
        $admin = $this->user;
        $basic = config('basic');
        $today = today();
        $data['yearLabels'] = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];

        $monthlySalesTransactions = Sale::when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin, $today) {
            return $query->where('company_id', $admin->active_company_id)
                ->select('created_at')
                ->whereYear('created_at', $today)
                ->groupBy([DB::raw("DATE_FORMAT(created_at, '%m')")])
                ->selectRaw('SUM(total_amount) AS totalSalesAmount')
                ->selectRaw('SUM(CASE WHEN customer_id IS NULL AND sales_by = 1 THEN total_amount END) AS soldSalesCenterAmount')
                ->selectRaw('SUM(CASE WHEN customer_id IS NOT NULL AND sales_by = 1 THEN total_amount END) AS soldCustomerAmount')
                ->selectRaw('SUM(CASE WHEN customer_id IS NULL AND sales_by = 1 AND payment_status = 0 THEN due_amount END) AS dueSalesCenterAmount')
                ->selectRaw('SUM(CASE WHEN payment_status = 0 THEN due_amount END) AS dueCustomerAmount')
                ->get()
                ->groupBy([function ($query) {
                    return $query->created_at->format('F');
                }]);
        });

//        $data['salesStatRecords']['totalStockTransfer'] = StockIn::where('company_id', $admin->active_company_id)->whereNotNull('sales_center_id')->sum('total_cost');

        $monthlyStockTransactions = StockIn::where('company_id', $admin->active_company_id)
            ->select('created_at')
            ->whereYear('created_at', $today)
            ->groupBy([DB::raw("DATE_FORMAT(created_at, '%m')")])
            ->selectRaw('SUM(total_cost) AS totalStockAmount')
            ->selectRaw('SUM(CASE WHEN sales_center_id IS NOT NULL THEN total_cost END) AS totalStockTransfer')
            ->get()
            ->groupBy([function ($query) {
                return $query->created_at->format('F');
            }]);


        $yearTotalStockAmount = [];
        $yearTotalStockTransfer = [];

        $yearTotalSalesAmount = [];
        $yearTotalSoldSalesCenterAmount = [];
        $yearTotalSoldCustomerAmount = [];
        $yearTotalDueSalesCenterAmount = [];
        $yearTotalDueCustomerAmount = [];

        foreach ($data['yearLabels'] as $yearLabel) {
            $currentTotalStockAmount = 0;
            $currentTotalStockTransfer = 0;

            $currentTotalSalesAmount = 0;
            $currentTotalSoldSalesCenterAmount = 0;
            $currentTotalSoldCustomerAmount = 0;
            $currentTotalDueSalesCenterAmount = 0;
            $currentTotalDueCustomerAmount = 0;

            if (isset($monthlyStockTransactions[$yearLabel])) {
                foreach ($monthlyStockTransactions[$yearLabel] as $key => $stock) {
                    $currentTotalStockAmount += $stock->totalStockAmount;
                    $currentTotalStockTransfer += $stock->totalStockTransfer;
                }
            }

            if (isset($monthlySalesTransactions[$yearLabel])) {
                foreach ($monthlySalesTransactions[$yearLabel] as $key => $sale) {
                    $currentTotalSalesAmount += $sale->totalSalesAmount;
                    $currentTotalSoldSalesCenterAmount += $sale->soldSalesCenterAmount;
                    $currentTotalSoldCustomerAmount += $sale->soldCustomerAmount;
                    $currentTotalDueSalesCenterAmount += $sale->dueSalesCenterAmount;
                    $currentTotalDueCustomerAmount += $sale->dueCustomerAmount;
                }
            }

            $yearTotalStockAmount[] = $currentTotalStockAmount;
            $yearTotalStockTransfer[] = $currentTotalStockTransfer;

            $yearTotalSalesAmount[] = $currentTotalSalesAmount;
            $yearTotalSoldSalesCenterAmount[] = $currentTotalSoldSalesCenterAmount;
            $yearTotalSoldCustomerAmount[] = $currentTotalSoldCustomerAmount;
            $yearTotalDueSalesCenterAmount[] = $currentTotalDueSalesCenterAmount;
            $yearTotalDueCustomerAmount[] = $currentTotalDueCustomerAmount;
        }

        $data['yearSalesTransactionChartRecords'] = [
            'yearLabels' => $data['yearLabels'],
            'yearTotalStockAmount' => $yearTotalStockAmount,
            'yearTotalStockTransfer' => $yearTotalStockTransfer,
            'yearTotalSalesAmount' => $yearTotalSalesAmount,
            'yearTotalSoldSalesCenterAmount' => $yearTotalSoldSalesCenterAmount,
            'yearTotalSoldCustomerAmount' => $yearTotalSoldCustomerAmount,
            'yearTotalDueSalesCenterAmount' => $yearTotalDueSalesCenterAmount,
            'yearTotalDueCustomerAmount' => $yearTotalDueCustomerAmount,
        ];

        return response()->json(['data' => $data, 'basic' => $basic]);
    }

    public function getSalesStatRecords()
    {
        $admin = $this->user;
        $currency = config('basic.currency_symbol');
        $data['salesStatRecords'] = collect(Sale::when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin) {
            return $query->where('company_id', $admin->active_company_id)
                ->selectRaw('SUM(CASE WHEN customer_id IS NULL AND sales_by = 1 THEN total_amount END) AS soldSalesCenterAmount')
                ->selectRaw('SUM(CASE WHEN customer_id IS NOT NULL AND sales_by = 1 THEN total_amount END) AS soldCustomerAmount')
                ->selectRaw('SUM(CASE WHEN customer_id IS NULL AND sales_by = 1 AND payment_status = 0 THEN due_amount END) AS dueSalesCenterAmount')
                ->selectRaw('SUM(CASE WHEN payment_status = 0 THEN due_amount END) AS dueCustomerAmount');
        })
            ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin) {
                return $query->where([
                    ['company_id', $admin->salesCenter->company_id],
                    ['sales_center_id', $admin->salesCenter->id],
                    ['sales_by', 2],
                ])->whereNotNull('customer_id')
                    ->selectRaw('SUM(CASE WHEN customer_id IS NOT NULL AND sales_by = 2 AND payment_status = 0 THEN due_amount END) AS dueCustomerAmount');
            })
            ->selectRaw('SUM(total_amount) AS totalSalesAmount')
            ->get()->makeHidden('nextPayment')->toArray())->collapse();

        if (userType() == 1) {
            $data['salesStatRecords']['totalStockAmount'] = StockIn::where('company_id', $admin->active_company_id)->whereNull('sales_center_id')->sum('total_cost');
            $data['salesStatRecords']['totalStockTransfer'] = StockIn::where('company_id', $admin->active_company_id)->whereNotNull('sales_center_id')->sum('total_cost');
        } else {
            $data['salesStatRecords']['totalStockAmount'] = StockIn::where('company_id', $admin->salesCenter->company_id)->where('sales_center_id', $admin->salesCenter->id)->sum('total_cost');
        }
        return response()->json(['data' => $data, 'currency' => $currency]);
    }

    public function getItemRecords()
    {
        $admin = $this->user;
        $itemRecords = [];
        $totalItemsCount = Stock::when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin) {
            return $query->where('company_id', $admin->active_company_id)->whereNull('sales_center_id');
        })
            ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin) {
                return $query->where([
                    ['company_id', $admin->salesCenter->company_id],
                    ['sales_center_id', $admin->salesCenter->id],
                ]);
            })
            ->count();

        $totalOutOfStockItemsCount = Stock::when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin) {
            return $query->where('company_id', $admin->active_company_id)->whereNull('sales_center_id')->where('quantity', 0);
        })
            ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin) {
                return $query->where([
                    ['company_id', $admin->salesCenter->company_id],
                    ['sales_center_id', $admin->salesCenter->id],
                ])->where('quantity', 0);
            })
            ->count();

        $itemRecords['totalItems'] = $totalItemsCount;
        $itemRecords['totalOutOfStockItems'] = $totalOutOfStockItemsCount;
        return response()->json(['itemRecords' => $itemRecords]);
    }

    public function getCustomerRecords()
    {
        $admin = $this->user;

        $customerRecords = [];
        $customersCount = Customer::when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin) {
            return $query->where('company_id', $admin->active_company_id)->whereNull('sales_center_id');
        })
            ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin) {
                return $query->where([
                    ['company_id', $admin->salesCenter->company_id],
                    ['sales_center_id', $admin->salesCenter->id],
                ]);
            })
            ->count();

        $customerRecords['totalCustomers'] = $customersCount;
        return response()->json(['customerRecords' => $customerRecords]);
    }

    public function getRawItemRecords()
    {
        $admin = $this->user;
        $currency = config('basic.currency_symbol');
        $data['rawItemStatRecords'] = collect(RawItemPurchaseIn::where('company_id', $admin->active_company_id)
            ->selectRaw('SUM(total_price) AS totalRawItemPurchaseAmount')
            ->selectRaw('SUM(CASE WHEN payment_status = 0 THEN due_amount END) AS totalRawItemDueAmount')
            ->get()->toArray())->collapse();

        $data['rawItemStatRecords']['totalRawItemWastageAmount'] = Wastage::with('rawItemStock')
            ->where('company_id', $admin->active_company_id)->get()
            ->sum(function ($wastage) {
                return $wastage->quantity * optional($wastage->rawItemStock)->last_cost_per_unit;
            });

        $data['rawItemStatRecords']['totalOutOfStockRawItems'] = RawItemPurchaseStock::where('company_id', $admin->active_company_id)->where('quantity', '<=', 0)->count();

        $data['rawItemStatRecords']['totalRawItems'] = RawItem::where('company_id', $admin->active_company_id)->count();

        return response()->json(['data' => $data, 'currency' => $currency]);

    }

    public function getAffiliateMemberRecords()
    {
        $admin = $this->user;

        $currency = config('basic.currency_symbol');

        $data['affiliateMemberStatRecords'] = collect(AffiliateMember::where('company_id', $admin->active_company_id)
            ->selectRaw('SUM(total_commission_amount) AS totalAffiliateMemberCommission')
            ->selectRaw('COUNT(id) AS totalAffiliateMembers')
            ->get()->toArray())->collapse();

        $data['affiliateMemberStatRecords']['centralPromoterCommission'] = CentralPromoter::where('company_id', $admin->active_company_id)->sum('total_commission_amount');

        $data['affiliateMemberStatRecords']['totalAffiliateCommission'] = $data['affiliateMemberStatRecords']['totalAffiliateMemberCommission'] + $data['affiliateMemberStatRecords']['centralPromoterCommission'];

        return response()->json(['data' => $data, 'currency' => $currency]);
    }


    public function getSalesCenterRecords()
    {
        $admin = $this->user;
        $data['salesCenterStatRecords'] = collect(SalesCenter::where('company_id', $admin->active_company_id)
            ->selectRaw('COUNT(id) AS totalSalesCenter')
            ->get()->toArray())->collapse();
        return response()->json(['data' => $data]);
    }

    public function getSupplierRecords()
    {
        $admin = $this->user;
        $data['supplierStatRecords'] = collect(Supplier::where('company_id', $admin->active_company_id)
            ->selectRaw('COUNT(id) AS totalSuppliers')
            ->get()->toArray())->collapse();

        return response()->json(['data' => $data]);
    }

    public function getExpenseRecords()
    {
        $admin = $this->user;
        $currency = config('basic.currency_symbol');
        $data['expenseStatRecords'] = collect(Expense::where('company_id', $admin->active_company_id)
            ->selectRaw('SUM(amount) AS totalExpenseAmount')
            ->get()->toArray())->collapse();
        return response()->json(['data' => $data, 'currency' => $currency]);
    }


    public function index()
    {
        return view($this->theme . 'user.dashboard');
    }


    public function profile(Request $request)
    {
        $validator = Validator::make($request->all(), []);
        $data['user'] = $this->user;
        $data['social_links'] = UserSocial::where('user_id', $data['user']->id)->get();
        $data['identityFormList'] = IdentifyForm::where('status', 1)->get();
        if ($request->has('identity_type')) {
            $validator->errors()->add('identity', '1');
            $data['identity_type'] = $request->identity_type;
            $data['identityForm'] = IdentifyForm::where('slug', trim($request->identity_type))->where('status', 1)->firstOrFail();
            return view($this->theme . 'user.profile.myprofile', $data)->withErrors($validator);
        }
        return view($this->theme . 'user.profile.myprofile', $data);
    }

    public function updateProfile(Request $request)
    {
        $allowedExtensions = array('jpg', 'png', 'jpeg');

        $image = $request->image;
        $this->validate($request, [
            'image' => [
                'required',
                'max:4096',
                function ($fail) use ($image, $allowedExtensions) {
                    $ext = strtolower($image->getClientOriginalExtension());
                    if (($image->getSize() / 1000000) > 2) {
                        return $fail("Images MAX  2MB ALLOW!");
                    }
                    if (!in_array($ext, $allowedExtensions)) {
                        return $fail("Only png, jpg, jpeg images are allowed");
                    }
                }
            ]
        ]);

        $user = $this->user;
        if ($request->hasFile('image')) {
            $path = config('location.user.path');
            try {
                $user->image = $this->uploadImage($image, $path);
            } catch (\Exception $exp) {
                return back()->with('error', 'Could not upload your ' . $image)->withInput();
            }
        }
        $user->save();

        return back()->with('success', 'Updated Successfully.');
    }

    public function profileImageUpdate(Request $request)
    {

        $allowedExtensions = array('jpg', 'png', 'jpeg');
        $image = $request->profile_image;

        $this->validate($request, [
            'profile_image' => [
                'required',
                'max:4096',
                function ($fail) use ($image, $allowedExtensions) {
                    $ext = strtolower($image->getClientOriginalExtension());
                    if (($image->getSize() / 1000000) > 2) {
                        return $fail("Images MAX  2MB ALLOW!");
                    }
                    if (!in_array($ext, $allowedExtensions)) {
                        return $fail("Only png, jpg, jpeg images are allowed");
                    }
                }
            ]
        ]);

        $user = $this->user;

        if ($request->hasFile('profile_image')) {
            try {
                $image = $this->fileUpload($request->profile_image, config('location.user.path'), null, null, 'avif', null, null, null);
                if ($image) {
                    $user->image = $image['path'];
                    $user->driver = $image['driver'];
                    $user->save();
                }
            } catch (\Exception $exp) {
                return back()->with('error', 'Image could not be uploaded.');
            }
        }

        $src = asset('assets/upload/' . $user->image);
        return response()->json(['src' => $src]);

    }

    public function updateInformation(Request $request)
    {
        $req = Purify::clean($request->all());
        $user = $this->user;
        $rules = [
            'name' => 'required',
            'username' => "required|alpha_dash|min:5",
            'email' => "required|email",
            'phone' => "sometimes|required",
            'address' => "required",
        ];
        $message = [
            'name.required' => 'Name field is required',
            'username.required' => 'User Name field is required',
            'email.required' => 'Email field is required',
            'phone.required' => 'Phone number is required',
            'address.required' => 'Address is required',
        ];

        $validator = Validator::make($req, $rules, $message);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->name = $req['name'];
        $user->username = $req['username'];
        $user->email = $req['email'];
        $user->phone = $req['phone'];
        $user->address = $req['address'];
        $user->save();

        return back()->with('success', 'Updated Successfully.');
    }

    public function updatePassword(Request $request)
    {

        $rules = [
            'current_password' => "required",
            'password' => "required|min:2|confirmed",
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->errors()->add('password', '1');
            return back()->withErrors($validator)->withInput();
        }
        $user = $this->user;
        try {
            if (Hash::check($request->current_password, $user->password)) {
                $user->password = bcrypt($request->password);
                $user->save();

                return back()->with('success', 'Password Changes successfully.');
            } else {
                throw new \Exception('Current password did not match');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
