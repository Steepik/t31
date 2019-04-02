<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        return view('auth.pre_register');
    }

    public function showRegistrationForm(Request $request)
    {
        $wholesaler = ($request->who == 'wholesaler') ? true : false;

        return view('auth.register', compact('wholesaler'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'birth' => 'sometimes|required|date_format:d.m.Y',
            'legal_name' => 'sometimes|required',
            'inn' => 'sometimes|required|max:12|min:10',
            'city' => 'required',
            'phone' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'first_name' => explode(" ", $data['name'])[1],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'birth' => isset($data['birth']) ? Carbon::parse($data['birth'])->format('Y-m-d') : null,
            'legal_name' => $data['legal_name'] ?? null,
            'inn' => $data['inn'] ?? null,
            'city' => $data['city'],
            'street' => $data['street'] ?? null,
            'house' => $data['house'] ?? null,
            'phone' => $data['phone'],
            'is_wholesaler' => ($data['wholesaler'] == true) ? 1 : false,
            'api_token' => Str::random(60),
        ]);
    }
}
