<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/index';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function logout()
    {
        $guards = ['admin', 'customer', ''];

   
        if(Auth::guard("customer")->check()) {
            Auth::guard("customer")->logout();
            return $this->redirectLoggedOut("customer");
        }
        elseif(Auth::guard("admin")->check())
        {
            Auth::guard("admin")->logout();
            return $this->redirectLoggedOut("admin");   
        }
   // return redirect('/login');
    }

    public function redirectLoggedOut($guard)
    {
        switch($guard) {
            case 'customer':
                return redirect('/customer/login');
            case 'admin':
                return redirect('/login');
            default:
                return redirect('/login');
        }
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
