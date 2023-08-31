<?php

namespace App\Http\Controllers\Order;

use App\ApiCode;
use App\Http\Controllers\AppBaseController;
use App\Models\Coffee;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use App\Models\Card;
use App\Models\User;

class OrderController extends AppBaseController
{
     public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function UserOrders(Request $request){

         $user=auth()->user();
         $orders=Order::where('sender_id',$user->id)
         ->orwhere('targeted_id',$user->id)
         ->when($request->has('status')  ,function ($q) use ($request){
             $q->where('status',$request->status);
         })->orderBy('created_at','DESC')->get();
          return $this->sendResponse(['orders'=>$orders],
          "all Orders",ApiCode::SUCCESS,0);
    }

    public function DestroyOrder($order_id){
        $order=Order::findOrFail($order_id);
        $order->delete();
        return $this->sendResponse(null,
        __("Order deleted successfully"),ApiCode::SUCCESS,0);
    }

    public function sendrequest(Request $request,$user_id){
        $sender=auth()->user();
        $input=$request->all();

        $oldorder=Order::where('status',0)->where('sender_id',$sender->id)->orwhere('targeted_id',$sender->id)
        ->where('targeted_id',$user_id)->orwhere('sender_id',$user_id)
        ->first();
        if($oldorder){
            return $this->sendResponse(null,
            __("Sorry,there is a previous request in the waiting list"),ApiCode::SUCCESS,0);
        }
        $input['sender_id']=$sender->id;
        $input['targeted_id']=$user_id;
        $order=Order::create($input);
        $order->end_at=Carbon::now()->addDays(3);
        $order->save();
        $sender->status=1;
        $sender->save();
        $recipient=User::find($user_id);
        $recipient->status=1;
        $recipient->save();
        if($order){
            $this->sendFcmNotification(
                $recipient->fcm_token,
                "Request a meeting",
                $sender->full_name." has sent an meeting request");
          /*   $this->sendUserNote(
                $user_id,
                "Request a meeting",
                "طلب دعوة",
                $sender->full_name." has sent an meeting request",
                "قام " . $sender->full_name. "بإرسال طلب دعوة  "
            ); */
            return $this->sendResponse(
                ['order'=>$order],
            __("The request has been sent successfully"),ApiCode::SUCCESS,0);
        }
        else{
            return $this->sendResponse(null,
            __("Sorry,something went worng.Please try again later"),ApiCode::SOMETHING_WENT_WRONG,1);
        }

    }

    public function UpdateRequest(Request $request,$order_id){
        $rules=[
            'status'=>'required|numeric|between:0,2',
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            return $this->sendResponse(
                $validator->errors(),
                "validation errors",
                ApiCode::BAD_REQUEST,
                1
            );
        }
        $user=auth()->user();
        $order=Order::findOrFail($order_id);
        if ($request->has('status'))
        if ($request->status != null) {
            $order->status=$request->status;
            $order->save();
            if($order){
                if ($request->status == 2) {
                    $recipient=$order->recipient;
                    $recipient->status=0;
                    $recipient->save();
                    $sender=$order->sender;
                    $sender->status=0;
                    $sender->save();
                    $senderFcm = $order->sender->fcm_token;
                    $this->sendFcmNotification(
                        $senderFcm,
                        "Request a meeting",
                        $order->recipient->full_name. " rejected the meeting request");
                /*     $this->sendUserNote(
                        $order->sender_id,
                        "Request a meeting",
                        "طلب دعوة",
                        $recipient->full_name. " rejected the meeting request",
                        "قام " . $recipient->full_name. "برفض طلب الدعوة  "
                    ); */
                    return $this->sendResponse($order,
                    __("request rejected successfully"),ApiCode::SUCCESS,0);
                }
                elseif($request->status==1){
                    $senderFcm = $order->sender->fcm_token;
                    $this->sendFcmNotification(
                        $senderFcm,
                        "Request a meeting",
                        $order->recipient->full_name. " rejected the meeting request");
                   /*  $this->sendUserNote(
                        $order->sender_id,
                        "Request a meeting",
                        "طلب دعوة",
                        $order->recipient->full_name." accepted the meeting request",
                        "قام " . $order->recipient->full_name. "بالموافقة على طلب الدعوة  "
                    ); */
                    $this->sendCard($order->id);
                    return $this->sendResponse($order,
                    __("request accepted successfully"),ApiCode::SUCCESS,0);
                }
            }
            else{
                return $this->sendResponse(null,
                __("Sorry,something went worng.Please try again later"),ApiCode::SOMETHING_WENT_WRONG,1);
            }
        }
    }

    public function sendCard($order_id){
        $order=Order::findOrFail($order_id);
       // if($order->Is_paid==1){
            $user=$order->sender;
            $coffee=Coffee::where('category',$user->coffee_cat)->first();
            $hour=$user->hour;
            $time=Carbon::createFromTime($hour,0,0)->addDays(1);
            if(!$order->card){
            $card=Card::create([
                'order_id'=>$order->id,
                'sender_id'=>$order->sender->id,
                'targeted_id'=>$order->recipient->id,
                'coffee_id'=>$coffee->id,
                'time'=>$time
            ]);
            $senderFcm = $order->recipient->fcm_token;
            $this->sendFcmNotification(
                $senderFcm,
                "Card meeting",
                $order->sender->full_name ." has sent an meeting request");}
           return;
        //}
       /*  else{
            return $this->sendResponse(null,
            "Sorry,Payment was not completed successfully",ApiCode::SUCCESS,0);
        } */
    }

    public function CardMetting($order_id){
        $user=auth()->user();
        $card=Card::where('targeted_id',$user->id)
        ->orwhere('sender_id',$user->id)
        ->where('order_id',$order_id)
        ->latest()->first();
        return $this->sendResponse($card,
        __("My card"),ApiCode::SUCCESS,0);

    }

    public function sendFcmNotification(array $tokenList,string $title, String $body)
    {

        $extraNotificationData = [
            "body" => $body,
            "title" => $title
        ];

        $fcmNotification = [
            'registration_ids' => $tokenList, //multple token array
            // 'to'        => "/topics/messaging", //single token
            'notification' => $extraNotificationData
        ];

        return $this->firebaseNotification($fcmNotification);
    }

}
