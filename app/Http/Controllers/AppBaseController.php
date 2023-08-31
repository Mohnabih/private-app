<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use App\Models\Notification;


class AppBaseController extends Controller
{
    public function sendResponse($result, $message,  $code = 200, $errorCode = 0)
    {
        return Response::json([
            'status' => $code,
            'errorCode' => $errorCode,
            'data' => $result,
            'message' => $message
        ], $code);
    }


    public function sendSuccess($message)
    {
        return Response::json([
            'success' => true,
            'message' => $message
        ], 200);
    }

    public function saveNotification($input)
    {
        return Notification::create($input);
    }

}
