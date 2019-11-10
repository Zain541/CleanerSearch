<?php

namespace App\Http\Controllers\Api\Customer;

use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'postal_code' => ['required', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:190'],
            'customer_id' => ['required'],
            'avatar' => ['required','mimes:jpeg,jpg,png,gif','max:10000'],
            ]);



        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $customer_id = $request->customer_id;
        $customer = Customer::findOrFail($customer_id);
        $customer_image = $customer->avatar;
        $customer->update($request->except('avatar'));

        $image_path = $request->avatar;
        
      
       	if($customer_image != null)
       	{
           unlink(storage_path("app/public/" . $customer_image)); 
       	}
            if ($request->file('avatar') ){
               
                    $path = $request->file('avatar')->store('images/profile/customer', 'public');
                    $customer->update(['avatar' => $path]);
                
            }
    }
}
