<?php
namespace App\Http\Controllers\api\Customer;
use App\Order;
use App\Cleaner;
use App\Customer;
use App\Status;
use App\OrderProposal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\CleanerResource;
use App\Http\Resources\ProposalResource;
use App\Http\Resources\CustomerResource;
use Illuminate\Support\Facades\Validator;
use App\Notifications\Cleaner\Proposal\Approved;
use App\Notifications\Cleaner\Proposal\Rejected;
use App\Notification;


class ProposalController extends Controller
{
    public function index(Request $request, Customer $customer)
    {
    	$customer_order_proposals = $customer->orderProposals->where('status_id', '!=', 4);
    	$customer_order_proposals->load(array('customer','order','status','cleaner'));
    	return ProposalResource::collection($customer_order_proposals);
    }

    public function reject(Request $request)
    {
    	$proposal_id = $request->proposal_id;
    	$proposal = OrderProposal::findOrFail($proposal_id);
    	$proposal->status_id = 3;
        $cleaner_id = $proposal->cleaner_id;
    	if($proposal->save())
    	{
    		$proposal->load(array('customer','order','status'));
            $cleaner = Cleaner::findOrFail($cleaner_id);
            $cleaner->notify(new Rejected($proposal));
    		return new ProposalResource($proposal);
    	}
    	 return response()->json
    	 (
    	 	[
    	 		"success" => false,
    	 		"message" => "Sorry! There is a problem while performing this action",
    	 	]
    	 );
    }


    public function approve(Request $request)
    {
    	$proposal_id = $request->proposal_id;
        $proposal = OrderProposal::findOrFail($proposal_id);
    	if(!$proposal->rejected)
    	{
    		$order_id = $proposal->order_id;
    		$customer_id = $proposal->customer_id;
    		$cleaner_id = $proposal->cleaner_id;
            $proposal->status_id = 2;
    		if($proposal->save())
    		{
               
    			OrderProposal::where('id','!=',$proposal->id)->where('order_id',$order_id)->update(['status_id' => 3]);
    			Order::where('id',$order_id)->update(['cleaner_id' => $cleaner_id]);
                $cleaner = Cleaner::findOrFail($cleaner_id);

                $cleaner->notify(new Approved($proposal));
    			return response()->json
    	 		(
    	 			[
    	 				"success" => true,
    	 				"message" => "Proposal is approved successfully",
    	 			]
    	 		);
    		}
        }
    		return response()->json
    	 		(
    	 			[
    	 				"success" => false,
    	 				"message" => "Proposal is already rejected",
    	 			]
    	 		);
    }

    
}
