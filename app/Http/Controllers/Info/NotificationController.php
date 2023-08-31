<?php

namespace App\Http\Controllers\Info;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\ApiCode;
use App\Jobs\SendPublicNotification;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class NotificationController extends AppBaseController
{

    public function all(Request $request)
    {
        $user = auth()->user();
        $all = Notification::Where('type', 1)->orderBy('created_at', 'DESC');
        $limit = 12;
        if ($request->query('limit') != null)
            $limit = $request->query('limit');

        $notifications = $all->paginate($limit);
        return  $this->sendResponse(
            ['notifications' => $notifications],
            "here are your notifications!",
            ApiCode::SUCCESS,
            0
        );
    }

    public function sendNote(Request $request)
    {
        $rules =
            [
                'ar_content' => 'required',
                'en_content' => 'required',
            ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->sendResponse(
                $validator->errors(),
                "validation errors",
                ApiCode::BAD_REQUEST,
                1
            );
        }
        $FcmToken = User::whereNotNull('fcm_token')->pluck('fcm_token')->all();
        $title_ar = 'Take Me Date';
        $title_en = 'Take Me Date';

        if ($request->has('en_title'))
            if ($request->en_title != null)
                $title_en = $request->en_title;

        if ($request->has('title_ar'))
            if ($request->title_ar != null)
                $title_ar = $request->title_ar;

        $notification = $this->saveNotification([
            'title' => $title_ar,
            'en_title' => $title_en,
            'content' => $request->ar_content,
            'en_content' => $request->en_content,
            'type' => 1,
        ]);

        SendPublicNotification::dispatch($notification->id);

        return $this->sendResponse(
            Notification::find($notification->id),
            'note sent successfully!',
            ApiCode::SUCCESS,
            0
        );
    }
}
