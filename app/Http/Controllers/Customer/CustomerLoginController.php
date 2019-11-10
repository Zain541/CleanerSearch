<?php

namespace App\Http\Controllers\Customer;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerLoginController extends Controller
{
    public function showCustomerLoginForm()
    {
        return view('customer.login');
    }

    public function customerLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email|exists:customers',
            'password' => 'required|min:8'
        ]);

        if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {


             return redirect()->route('customer.index');
        }
        return back()->withInput($request->only('email', 'remember'));
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
