<?php
namespace App\Http\Controllers\api\Cleaner;
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


class ProposalController extends Controller
{
    public function create(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'order_id' => ['required', 'integer'],
	        'cleaner_id' => ['required', 'integer'],
	        'customer_id' => ['required', 'integer'],
	        'sent_by' => ['required', 'string','max:20'],
	        'cost' => ['required','integer'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $order_proposal = OrderProposal::create($request->all());

        $order_proposal->load(array('customer','order','status'));

        return new ProposalResource($order_proposal);
    }


    public function index(Cleaner $cleaner)
    {
       	$cleaner_sent_proposals = $cleaner->orderProposals;
        $cleaner_sent_proposals->load(array('customer','order','status'));
        return ProposalResource::collection($cleaner_sent_proposals);
    }


    public function withdraw(Request $request)
    {
    	$proposal_id = $request->id;
    	$order_proposal = OrderProposal::findOrFail($proposal_id);
    	$order_proposal->status_id = 4;
    	if($order_proposal->save())
    	{
    		$order_proposal->load(array('customer','order','status'));
    		return new ProposalResource($order_proposal);
    	}
    	 return response()->json
    	 (
    	 	[
    	 		"success" => false,
    	 		"message" => "Sorry! There is a problem while performing this action",
    	 	]
    	 );
    }


    
}
