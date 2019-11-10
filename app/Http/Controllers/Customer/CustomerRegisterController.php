<?php

namespace App\Http\Controllers\Customer;

use Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Customer;

class CustomerRegisterController extends Controller
{
     protected function redirectTo($path = "/customer/home")
    {
    /* generate URL dynamicaly */
    return $path; // return dynamicaly generated URL.
    }

	public function __construct()
    {
        $this->middleware('guest');
    }

	protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:10'],
            'last_name' => ['required', 'string', 'max:10'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:customers'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone_number' => ['required', 'string', 'max:50'],
            'postal_code' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:300'],
            'preferred_method_to_contact' => ['required', 'string', 'max:20'],
        ]);
    }


    public function showCustomerRegisterForm()
   	{
        return view('customer.register');
    }
     protected function createCustomer(Request $request)
    {
	    $validator = $this->validator($request->all())->validate();
	    $pasword_without_hash = $request['password'];
    	$request['password'] = Hash::make($request['password']);
	    $customer = new Customer();

 		$customer->create($request->all());
	    $auth = Auth::guard('customer')->attempt(['email' => $request['email'], 'password' => $pasword_without_hash]);

	       if($auth)
	       {
	       		return redirect()->route('customer.index');
	       }
	   
	}
    
}
