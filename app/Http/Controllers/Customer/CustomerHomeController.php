<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class CustomerHomeController extends Controller
{
    public function index()
    {
    	$user = Auth::guard("customer")->user();
    	return view('customer.home',compact('user'));
    }
}
