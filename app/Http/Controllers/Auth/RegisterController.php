<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Marketing;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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





    public function showRegistrationForm(Request $request)
    {
        Session::forget(['phone', 'referal_code']);
        if ($request->has('ref'))
        {
           $token = $request->ref;
           $user = User::where('refrrel_token', $token)->first();
           if ($user)
           {
              Session::put(['refered_user_id' =>$user->id, 'phone' => $user->phone, 'referal_code' => $token]);
           }
           else
           {
               return redirect()->route('register')->with('error', 'Your Refarrel Code is not valid !');
           }
        }
        return view('auth.register');
    }



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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
         $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'type' => 'user',
            'password' => Hash::make($data['password']),
             'refrrel_token' => \Illuminate\Support\Str::random(6),
        ]);


        if(Session::has('referal_code'))
        {
            Marketing::insert([
                'new_user_id' => $user->id,
                'referal_code' => session()->get( 'referal_code'),
                'refered_user_id' => session()->get( 'refered_user_id'),
                'referal_bonus' => 10,
            ]);
        }

        return $user;
    }
}
