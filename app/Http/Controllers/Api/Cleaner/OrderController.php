<?php

namespace App\Http\Controllers\Api\Cleaner;

use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Order;
use App\Http\Resources\OrderResource;
use App\Http\Resources\CustomerResource;

class OrderController extends Controller
{


    public function show($id)
    {
        $order = Order::where('id',$id)->where('cleaner_id',null)->first();
        if($order != null)
        {
            $order->load(array('customer','contactMethods','propertyType','contractType'));
            return new OrderResource($order);
        }
        return response()->json([
            "success"=> false,
            "message" => "Sorry! The order with this link is not available"]);

    }

    public function index()
    {
        $orders = Order::where('cleaner_id',null)->get();
        $orders->load(array('customer','contactMethods','propertyType','contractType'));
        return OrderResource::collection($orders);
    }
}
