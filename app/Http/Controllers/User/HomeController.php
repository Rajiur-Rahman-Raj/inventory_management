<?php

namespace App\Http\Controllers\User;

use App\Events\ChatEvent;
use App\Helper\GoogleAuthenticator;
use App\Helper\SystemInfo;
use App\Http\Controllers\Controller;
use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use App\Models\Badge;
use App\Models\Comment;
use App\Models\Fund;
use App\Models\Gateway;
use App\Models\IdentifyForm;
use App\Models\Investment;
use App\Models\Item;
use App\Models\KYC;
use App\Models\Language;
use App\Models\ManageProperty;
use App\Models\MoneyTransfer;
use App\Models\OfferLock;
use App\Models\OfferReply;
use App\Models\PayoutLog;
use App\Models\PayoutMethod;
use App\Models\PayoutSetting;
use App\Models\PropertyOffer;
use App\Models\PropertyShare;
use App\Models\Sale;
use App\Models\Stock;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserSocial;
use Facades\App\Services\InvestmentService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Stevebauman\Purify\Facades\Purify;
use Facades\App\Services\BasicService;

use App\Console\Commands\PayoutCurrencyUpdateCron;

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


    public function getSalesStatRecords()
    {
        $admin = $this->user;
        $currency = config('basic.currency_symbol');
        $data['salesStatRecords'] = collect(Sale::when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin) {
            return $query->where('company_id', $admin->active_company_id)->where('sales_by', 1)
                ->selectRaw('SUM(CASE WHEN customer_id IS NULL AND sales_by = 1 THEN total_amount END) AS soldSalesCenterAmount')
                ->selectRaw('SUM(CASE WHEN customer_id IS NOT NULL AND sales_by = 1 THEN total_amount END) AS soldCustomerAmount')
                ->selectRaw('SUM(CASE WHEN customer_id IS NULL AND sales_by = 1 AND payment_status = 0 THEN total_amount END) AS dueSalesCenterAmount')
                ->selectRaw('SUM(CASE WHEN customer_id IS NOT NULL AND sales_by = 1 AND payment_status = 0 THEN total_amount END) AS dueCustomerAmount');

        })
            ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin) {
                return $query->where([
                    ['company_id', $admin->salesCenter->company_id],
                    ['sales_center_id', $admin->salesCenter->id],
                    ['sales_by', 2],
                ])->whereNotNull('customer_id')
                    ->selectRaw('SUM(CASE WHEN customer_id IS NOT NULL AND sales_by = 2 AND payment_status = 0 THEN total_amount END) AS totalDueAmount');
            })
            ->selectRaw('SUM(total_amount) AS totalSalesAmount')
            ->get()->makeHidden('nextPayment')->toArray())->collapse();

        return response()->json(['data' => $data, 'currency' => $currency]);
    }

    public function getItemRecords()
    {
        $admin = $this->user;
        $currency = config('basic.currency_symbol');
        $data['itemRecords'] = collect(Stock::when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use ($admin) {
            return $query->where('company_id', $admin->active_company_id)->whereNull('sales_center_id');
        })
            ->when(isset($admin->salesCenter) && $admin->user_type == 2, function ($query) use ($admin) {
                return $query->where([
                    ['company_id', $admin->salesCenter->company_id],
                    ['sales_center_id', $admin->salesCenter->id],
                ]);
            })->get()->toArray())->collapse();

//        dd($data['itemRecords']);

//        $stockOutItems = Stock::when(!isset($admin->salesCenter) && $admin->user_type == 1, function ($query) use($admin){
//            return $query->where('company_id', $admin->active_company_id)->whereNull('sales_center_id');
//        })

        return $data['itemRecords'];

        return response()->json(['data' => $data, 'currency' => $currency]);
    }


    public function index()
    {
        $data['walletBalance'] = getAmount($this->user->balance);
        $data['interestBalance'] = getAmount($this->user->interest_balance);
        $data['totalDeposit'] = getAmount($this->user->funds()->whereStatus(1)->sum('amount'));
        $data['totalPayout'] = getAmount($this->user->payout()->whereStatus(2)->sum('amount'));
        $data['depositBonus'] = getAmount($this->user->referralBonusLog()->where('type', 'deposit')->sum('amount'));
        $data['investBonus'] = getAmount($this->user->referralBonusLog()->where('type', 'invest')->sum('amount'));
        $data['profitBonus'] = getAmount($this->user->referralBonusLog()->where('type', 'profit_commission')->sum('amount'));
        $data['lastBonus'] = getAmount(optional($this->user->referralBonusLog()->orderBy('id', 'DESC')->first())->amount);
        $data['totalBadgeBonus'] = getAmount($this->user->total_badge_bonous);

        $data['totalInterestProfit'] = getAmount($this->user->transaction()->where('balance_type', 'interest_balance')->where('trx_type', '+')->sum('amount'));


        $data['investment'] = collect(Investment::with('property')->where('user_id', $this->user->id)
            ->selectRaw('SUM( amount ) AS totalInvestAmount')
            ->selectRaw('SUM(CASE WHEN invest_status = 1 AND status = 0 AND is_active = 1 THEN amount END) AS runningInvestAmount')
            ->selectRaw('COUNT(id) AS totalInvestment')
            ->selectRaw('COUNT(CASE WHEN invest_status = 1 AND status = 0 AND is_active = 1 THEN id END) AS runningInvestment')
            ->selectRaw('COUNT(CASE WHEN invest_status = 0 AND status = 0 AND is_active = 1 THEN id END) AS dueInvestment')
            ->selectRaw('COUNT(CASE WHEN invest_status = 1 AND status = 1 AND is_active = 1 THEN id END) AS completedInvestment')
            ->get()->makeHidden('nextPayment')->toArray())->collapse();

        $data['ticket'] = Ticket::where('user_id', $this->user->id)->count();

        $monthlyInvestment = collect(['January' => 0, 'February' => 0, 'March' => 0, 'April' => 0, 'May' => 0, 'June' => 0, 'July' => 0, 'August' => 0, 'September' => 0, 'October' => 0, 'November' => 0, 'December' => 0]);
        Investment::where('user_id', $this->user->id)
            ->whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])
            ->select(
                DB::raw('sum(amount) as totalAmount'),
                DB::raw("DATE_FORMAT(created_at,'%M') as months")
            )
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->get()->makeHidden('nextPayment')->map(function ($item) use ($monthlyInvestment) {
                $monthlyInvestment->put($item['months'], round($item['totalAmount'], 2));
            });
        $monthly['investment'] = $monthlyInvestment;


        $monthlyPayout = collect(['January' => 0, 'February' => 0, 'March' => 0, 'April' => 0, 'May' => 0, 'June' => 0, 'July' => 0, 'August' => 0, 'September' => 0, 'October' => 0, 'November' => 0, 'December' => 0]);
        $this->user->payout()->whereStatus(2)
            ->whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])
            ->select(
                DB::raw('sum(amount) as totalAmount'),
                DB::raw("DATE_FORMAT(created_at,'%M') as months")
            )
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->get()->map(function ($item) use ($monthlyPayout) {
                $monthlyPayout->put($item['months'], round($item['totalAmount'], 2));
            });
        $monthly['payout'] = $monthlyPayout;


        $monthlyFunding = collect(['January' => 0, 'February' => 0, 'March' => 0, 'April' => 0, 'May' => 0, 'June' => 0, 'July' => 0, 'August' => 0, 'September' => 0, 'October' => 0, 'November' => 0, 'December' => 0]);
        $this->user->funds()->whereNull('plan_id')->whereStatus(1)
            ->whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])
            ->select(
                DB::raw('sum(amount) as totalAmount'),
                DB::raw("DATE_FORMAT(created_at,'%M') as months")
            )
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->get()->map(function ($item) use ($monthlyFunding) {
                $monthlyFunding->put($item['months'], round($item['totalAmount'], 2));
            });
        $monthly['funding'] = $monthlyFunding;

        $monthlyReferralInvestBonus = collect(['January' => 0, 'February' => 0, 'March' => 0, 'April' => 0, 'May' => 0, 'June' => 0, 'July' => 0, 'August' => 0, 'September' => 0, 'October' => 0, 'November' => 0, 'December' => 0]);
        $this->user->referralBonusLog()->where('type', 'invest')
            ->whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])
            ->select(
                DB::raw('sum(amount) as totalAmount'),
                DB::raw("DATE_FORMAT(created_at,'%M') as months")
            )
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->get()->map(function ($item) use ($monthlyReferralInvestBonus) {
                $monthlyReferralInvestBonus->put($item['months'], round($item['totalAmount'], 2));
            });

        $monthly['referralInvestBonus'] = $monthlyReferralInvestBonus;


        $monthlyReferralFundBonus = collect(['January' => 0, 'February' => 0, 'March' => 0, 'April' => 0, 'May' => 0, 'June' => 0, 'July' => 0, 'August' => 0, 'September' => 0, 'October' => 0, 'November' => 0, 'December' => 0]);

        $this->user->referralBonusLog()->where('type', 'deposit')
            ->whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])
            ->select(
                DB::raw('sum(amount) as totalAmount'),
                DB::raw("DATE_FORMAT(created_at,'%M') as months")
            )
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->get()->map(function ($item) use ($monthlyReferralFundBonus) {
                $monthlyReferralFundBonus->put($item['months'], round($item['totalAmount'], 2));
            });
        $monthly['referralFundBonus'] = $monthlyReferralFundBonus;


        $monthlyProfit = collect(['January' => 0, 'February' => 0, 'March' => 0, 'April' => 0, 'May' => 0, 'June' => 0, 'July' => 0, 'August' => 0, 'September' => 0, 'October' => 0, 'November' => 0, 'December' => 0]);

        $this->user->transaction()->whereBetween('created_at', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),
        ])
            ->select(
                DB::raw('SUM((CASE WHEN remarks LIKE "%Interest From%" THEN amount END)) AS totalAmount'),
                DB::raw("DATE_FORMAT(created_at,'%M') as months")
            )
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->get()->map(function ($item) use ($monthlyProfit) {
                $monthlyProfit->put($item['months'], round($item['totalAmount'], 2));
            });
        $monthly['monthlyGaveProfit'] = $monthlyProfit;


        $latestRegisteredUser = User::where('referral_id', $this->user->id)->latest()->first();
        $data['allBadges'] = Badge::with('details')->where('status', 1)->orderBy('sort_by', 'ASC')->get();
        $user = $this->user;

        $data['investorBadge'] = BasicService::getInvestorCurrentBadge($user);
        if ($data['investorBadge'] != null) {
            $data['lastInvestorBadge'] = $data['investorBadge']->with('details')->first();
        } else {
            $data['lastInvestorBadge'] = null;
        }

        return view($this->theme . 'user.dashboard', $data, compact('monthly', 'latestRegisteredUser'));
    }


    public function profile(Request $request)
    {
        $validator = Validator::make($request->all(), []);
        $data['user'] = $this->user;
        $data['languages'] = Language::all();
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

        $msg = [
            'name' => $user->fullname,
        ];

        $adminAction = [
            "link" => route('admin.user-edit', $user->id),
            "icon" => "fas fa-user text-white"
        ];
        $userAction = [
            "link" => route('user.profile'),
            "icon" => "fas fa-user text-white"
        ];

        $this->adminPushNotification('ADMIN_NOTIFY_USER_PROFILE_UPDATE', $msg, $adminAction);
        $this->userPushNotification($user, 'USER_NOTIFY_HIS_PROFILE_UPDATE', $msg, $userAction);

        $currentDate = dateTime(Carbon::now());
        $this->sendMailSms($user, $type = 'USER_MAIL_HIS_PROFILE_UPDATE', [
            'name' => $user->fullname,
            'date' => $currentDate,
        ]);

        $this->mailToAdmin($type = 'ADMIN_MAIL_USER_PROFILE_UPDATE', [
            'name' => $user->fullname,
            'date' => $currentDate,
        ]);

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
            $user->image = $this->uploadImage($request->profile_image, config('location.user.path'), config('location.user.size'), $user->image);
            $user->save();
        }

        $src = asset('assets/uploads/users/' . $user->image);

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
            'password' => "required|min:5|confirmed",
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

                $msg = [
                    'name' => $user->fullname,
                ];

                $adminAction = [
                    "link" => route('admin.user-edit', $user->id),
                    "icon" => "fas fa-user text-white"
                ];
                $userAction = [
                    "link" => route('user.profile'),
                    "icon" => "fas fa-user text-white"
                ];

                $this->adminPushNotification('ADMIN_NOTIFY_USER_PROFILE_PASSWORD_UPDATE', $msg, $adminAction);
                $this->userPushNotification($user, 'USER_NOTIFY_HIS_PROFILE_PASSWORD_UPDATE', $msg, $userAction);

                $currentDate = dateTime(Carbon::now());
                $this->sendMailSms($user, $type = 'USER_MAIL_HIS_PROFILE_PASSWORD_UPDATE', [
                    'name' => $user->fullname,
                    'date' => $currentDate,
                ]);

                $this->mailToAdmin($type = 'ADMIN_MAIL_USER_PROFILE_PASSWORD_UPDATE', [
                    'name' => $user->fullname,
                    'date' => $currentDate,
                ]);

                return back()->with('success', 'Password Changes successfully.');
            } else {
                throw new \Exception('Current password did not match');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
