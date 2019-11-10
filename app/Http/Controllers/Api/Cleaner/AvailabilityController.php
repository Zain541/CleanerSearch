<?php

namespace App\Http\Controllers\Api\Cleaner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cleaner;
class AvailabilityController extends Controller
{
    public function update(Request $request)
    {
    	$cleaner_id = $request->cleaner_id;
    	$cleaner = Cleaner::findOrFail($cleaner_id);
    	$cleaner->availability = $request->availability;
    	if($cleaner->save()){
    	 return response()->json(
    	 	[
    	 		'success' => true,
    	 		'message' => "Availability is updated"
    	 	]
    	 );
    	}
    	else
    	{
    	 return response()->json(
    	 	[
    	 		'success' => false,
    	 		'message' => "There is some problem while updating the availability"
    	 	]
    	 );
    	}
    }
}
