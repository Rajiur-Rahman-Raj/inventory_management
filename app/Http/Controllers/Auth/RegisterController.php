<?php

namespace App\Http\Controllers\Auth;

use App\Http\Traits\Notify;
use App\Models\Template;
use App\Models\User;
use App\Mail\UserRegisterNotifyMail;
use App\Mail\AdminRegisterNotifyMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    use Notify;
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
//    protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        $templateSection = ['news-letter'];
        $data['templates'] = Template::templateMedia()->whereIn('section_name', $templateSection)->get()->groupBy('section_name');
        if (config('basic.registration') == 0) {
            return redirect('/')->with('warning', 'Registration Has Been Disabled.');
        }

        $info = json_decode(json_encode(getIpInfo()), true);
        $country_code  = null;
        if(!empty($info['code'])){
        $country_code = @$info['code'][0];
        }
        $countries = config('country');

        return view(template().'auth.register', $data, compact('country_code','countries'));
    }

    public function sponsor($sponsor)
    {
        if (config('basic.registration') == 0) {
            return redirect('/')->with('warning', 'Registration Has Been Disabled.');
        }

        $info = json_decode(json_encode(getIpInfo()), true);
        $country_code  = null;
        if(!empty($info['code'])){
            $country_code = @$info['code'][0];
        }
        $countries = config('country');

        return view(template().'auth.register', compact('sponsor', 'countries','country_code'));

    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if (config('basic.strong_password') == 0) {
            $rules['password'] = ['required', 'min:6', 'confirmed'];
        } else {
            $rules['password'] = ["required", 'confirmed',
                Password::min(6)->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()];
        }

        $rules['firstname'] = ['required', 'string', 'max:91'];
        $rules['lastname'] = ['required', 'string', 'max:91'];
        $rules['username'] = ['required', 'alpha_dash', 'min:5', 'unique:users,username'];
        $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:users,email'];
        $rules['country_code'] = ['max:5'];
        $rules['phone_code'] = ['required'];
        $rules['phone'] = ['required'];
        return Validator::make($data, $rules, [
            'firstname.required' => 'First Name Field is required',
            'lastname.required' => 'Last Name Field is required',
            'g-recaptcha-response.required' => 'The reCAPTCHA field is required.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $basic = (object) config('basic');

        return  User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'username' => $data['username'],
            'email' => $data['email'],
            'referral_id' => null,
            'country_code' => $data['country_code'],
            'phone_code' => $data['phone_code'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'email_verification' => ($basic->email_verification) ? 0 : 1,
            'sms_verification' => ($basic->sms_verification) ? 0 : 1,
        ]);

    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $user = $this->create($request->all());
        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        if($request->ajax()) {
            return route('user.home');
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }


    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        $user->last_login = Carbon::now();
        $user->save();
    }

    protected function guard()
    {
        return Auth::guard();
    }

}
