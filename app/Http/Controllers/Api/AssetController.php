<?php

namespace App\Http\Controllers\Api;

use App\Order;
use App\Customer;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProposalResource;


use App\Http\Controllers\Controller;

class AssetController extends Controller
{
    public function index($user, $id, $type)
    {
    	$user = ucfirst($user);

    	$user_model = app("App\\" . $user);


    	if($user == "Customer")
    	{
    		$user = $user_model::findOrFail($id);
    		if($type == "orders")
    		{

	    		$customer_orders = $user->$type;
	        	$customer_orders->load(array('customer','contactMethods','propertyType','contractType'));
	        	return OrderResource::collection($customer_orders);
	        }
	        if($type == "proposals")
	        {
	        	$customer_order_proposals = $user->orderProposals->where('status_id', '!=', 4);
    			$customer_order_proposals->load(array('customer','order','status','cleaner'));
    			return ProposalResource::collection($customer_order_proposals);
	        }
    	}

    	if($user == "Cleaner")
    	{
    		$user = $user_model::findOrFail($id);
    		if($type == "orders")
    		{

	    		 	$orders = Order::where('cleaner_id',null)->get();
       				$orders->load(array('customer','contactMethods','propertyType','contractType'));
        			return OrderResource::collection($orders);
	        }
	        if($type == "proposals")
	        {
	        	$cleaner_sent_proposals = $user->orderProposals;
        		$cleaner_sent_proposals->load(array('customer','order','status'));
        		return ProposalResource::collection($cleaner_sent_proposals);
	        }
    	}

    }
}
