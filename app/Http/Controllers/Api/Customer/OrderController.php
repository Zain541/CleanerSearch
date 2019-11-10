<?php

namespace App\Http\Controllers\Api\Customer;

use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Order;
use App\Http\Resources\OrderResource;
use App\Http\Resources\CustomerResource;

class OrderController extends Controller
{
    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:10'],
            'last_name' => ['required', 'string', 'max:10'],
            'email' => ['required', 'email', 'email', 'max:50'],
            'phone_number' => ['required', 'string', 'max:30'],
            'post_code' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:300'],
            'alternative_address' => ['required', 'string', 'max:300'],
            'property_type_id' => ['required', 'string', 'max:30'],
            'contract_type_id' => ['required', 'string', 'max:30'],
            'no_of_bedrooms' => ['required', 'string', 'max:30'],
            'cleaning_type' => ['required', 'string', 'max:30'],
            'best_day' => ['required', 'string', 'max:30'],
            'best_day' => ['required', 'string', 'max:30'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $order = Order::create($request->all());
        if(isset($request->contact_methods))
        {
            foreach ($request->contact_methods as $key => $value) {
                $order->contactMethods()->create(['name'=> $value]);
            }
        }
        $order->load(array('customer','contactMethods','propertyType','contractType'));

        return new OrderResource($order);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:10'],
            'last_name' => ['required', 'string', 'max:10'],
            'email' => ['required', 'email', 'email', 'max:50'],
            'phone_number' => ['required', 'string', 'max:30'],
            'post_code' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:300'],
            'alternative_address' => ['required', 'string', 'max:300'],
            'property_type_id' => ['required', 'string', 'max:30'],
            'contract_type_id' => ['required', 'string', 'max:30'],
            'no_of_bedrooms' => ['required', 'string', 'max:30'],
            'cleaning_type' => ['required', 'string', 'max:30'],
            'best_day' => ['required', 'string', 'max:30'],
            'best_day' => ['required', 'string', 'max:30'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $order = Order::findOrFail($id);

       
         $order->contactMethods()->delete();
         if(isset($request->contact_methods))
        {
            foreach ($request->contact_methods as $key => $value) {
                $order->contactMethods()->create(['name'=> $value]);
            }
        }

        unset($request['contact_methods']);
        $order->update($request->all());

       
        $order->load(array('customer','contactMethods','propertyType','contractType'));

        return new OrderResource($order);
    }



    public function delete(Order $order)
    {
        $order->contactMethods()->delete();
        if ($order->delete()) {
            return response()->json(["success"=> true,
                                    "message" => "Order is deleted successfully"]);
        }
        return response()->json([
            "success"=> false,
            "message" => "Sorry! there is some problem while deleting the order"]);

    }

    public function show(Order $order)
    {
        $order->load(array('customer','contactMethods','propertyType','contractType'));
        return new OrderResource($order);

    }
    public function index(Customer $customer)
    {
        $customer_orders = $customer->orders;
        $customer_orders->load(array('customer','contactMethods','propertyType','contractType'));
        return OrderResource::collection($customer_orders);

    }
}
