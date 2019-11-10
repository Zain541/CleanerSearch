<?php

namespace App\Http\Controllers\Api\Cleaner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notification;
use App\Cleaner;
use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
    	$cleaner = Cleaner::findOrFail($request->cleaner_id);
    	return NotificationResource::collection($cleaner->notifications);
    }

    public function unread(Request $request)
    {
    	$cleaner = Cleaner::findOrFail($request->cleaner_id);
    	$unread_notifications = $cleaner->notifications->where('read',0);
    	return NotificationResource::collection($unread_notifications);
    }

    public function read(Request $request)
    {
    	$cleaner = Cleaner::findOrFail($request->cleaner_id);
    	$read_notifications = $cleaner->notifications->where('read',1);
    	return NotificationResource::collection($read_notifications);
    }



    public function show(Notification $notification)
    {
    	$notification->read = 1;
    	$notification->save();
    	return new NotificationResource($notification);
    }
}
