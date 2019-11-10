<?php

namespace App\Http\Controllers\Api\Cleaner;

use App\Cleaner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
     public function updatePersonalProfile(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:10'],
            'last_name' => ['required', 'string', 'max:10'],
            'company_name' => ['required', 'string', 'max:50'],
            'phone' => ['required', 'string'],
            'avatar' => ['required','mimes:jpeg,jpg,png,gif','max:10000'],
            ]);



        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $cleaner_id = $request->cleaner_id;
        $cleaner = Cleaner::findOrFail($cleaner_id);
        $cleaner_image = $cleaner->avatar;
        $cleaner->update($request->except('avatar'));

        $image_path = $request->avatar;
        
      
       	if($cleaner_image != null)
       	{
           unlink(storage_path("app/public/" . $cleaner_image)); 
       	}
            if ($request->file('avatar') ){
               
                    $path = $request->file('avatar')->store('images/profile/cleaner', 'public');
                    $cleaner->update(['avatar' => $path]);
                
            }
        
        
    }


    public function updateProfessionalProfile(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'speciality_other' => ['required', 'string', 'max:150'],
            'cleaner_id' => ['required', 'integer'],
            ]);



        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $cleaner_id = $request->cleaner_id;
        $cleaner = Cleaner::findOrFail($cleaner_id);
        $cleaner->update(['speciality_other' => $request['speciality_other']]);
        $cleaner->specialities()->syncWithoutDetaching($request['specialities']);
        
        
    }

    public function storage()
    {
        $url = Storage::url('images/profile/cleaner/u8rMcfNQXlsFinGZzEsHRX6V0FpVlnz5zWBHP1ce.png');
        return  env('APP_URL') . $url;
    }
}
