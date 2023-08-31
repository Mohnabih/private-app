<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\ApiCode;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AdminController extends AppBaseController
{

    public function registerAdmin(Request $request)
    {

        $rules =
            [
                'first_name' => 'required',
                'phone' => 'required|unique:users',  /* |regex:/(0)[0-9]{9}/' */
                'password' => 'required|string|min:8|confirmed',
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
        $input = $request->all();
        $input['status'] = 1;
        $input['role']=0;
        $user = User::create($input);
        return $this->sendResponse([
            'user' => $user,
        ], "user created successfully", ApiCode::CREATED, 0);
    }


    public function loginAdmin(Request $request)
    {

        $rules =
            [
                'phone' => 'required',  /* |regex:/(0)[0-9]{9}/' */
                'password' => 'required',
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
        if ($token = auth()
            ->attempt([
                'phone' => request('phone'),
                'password' => request('password'),
                'role' => 0
            ])
        ) {
            $user = auth()->user();
            $user->remember_token = $token;
            $user->save();

            return  $this->sendResponse([
                'token' => $token,
                'user' => $user,
            ], "Admin successfully logged in",  ApiCode::SUCCESS, 0);
        } else {
            //if authentication is unsuccessfully, notice how I return json parameters
            return $this->sendResponse(
                null,
                "Invalid Phone or Password",
                ApiCode::BAD_REQUEST,
                1
            );
        }
    }

    public function editAdmin(Request $request)
    {
        $rules =
            [
                'password' => 'required|string|min:8|confirmed',
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
        $client = auth()->user();
        if ($request->has('password'))
            if ($request->password != null)
                $client->password = $request->password;

        $client->save();
        $client = User::where('id', $client->id)->first();
        return  $this->sendResponse(
            [
                'user' => $client,
            ],
            "Admin updated successfully!",
            ApiCode::SUCCESS,
            0
        );
    }

    public function logout()
    {
        auth()->logout();
        return  $this->sendResponse(null, "User successfully logged out",  ApiCode::SUCCESS, 0);
    }

    public function AllOrders(Request $request){

       $orders=Order::when($request->has('status') && $request->status!=null,function($q) use ($request){
        $q->where('status',$request->status);
       })->simplePaginate(10);
        return $this->sendResponse(['orders'=>$orders],
        "all Orders",ApiCode::SUCCESS,0);
   }

}
