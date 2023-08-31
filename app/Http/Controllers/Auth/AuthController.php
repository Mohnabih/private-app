<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\AppBaseController;
use App\ApiCode;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Work;
use App\Models\Skill;
use App\Models\City;
use App\Models\Hobby;

class AuthController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware('auth:api,',['except'=>[
            'register',
            'login',
        ]]);
    }

    public function register(Request $request){
        $rules =
        [
            'first_name' => 'required',
            'last_name' => 'required',
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
        $input=$request->all();
        $input['role'] = 1;
        $user= User::create($input);
        $token = auth()->login($user);
        $user->remember_token = $token;
        $user->save();
        return $this->sendResponse([
            'token' => $token,
            'user' => User::findOrFail($user->id)],
         __("user created successfully"),
         ApiCode::CREATED, 0);

    }


    public function login(Request $request)
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
                'password' => request('password')
            ])
        ) {
            $user = auth()->user();
            $user->remember_token = $token;
            $user->save();
            return  $this->sendResponse([
                'token' => $token,
                'user' => $user]
                , __("User successfully logged in"),  ApiCode::SUCCESS, 0);
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

    public function CompleteRegister(Request $request){
        $client=auth()->user();
        $rules=[
            'age'=>'required|numeric|min:18',
            'gender'=>'required|boolean',
            'city'=>'required',
            'hour'=>'required|numeric|between:1,24',
            'coffee_cat'=>'required|numeric|between:0,2',
            'work'=>'required',
            'skills'=>'required',
            'hobbies'=>'required'
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

        $client->age=$request->age;
        $client->gender=$request->gender;
        $client->city=$request->city;
        $client->hour=$request->hour;
        $client->coffee_cat=$request->coffee_cat;
        $client->work=$request->work;
        $client->skills()->attach($request->skills);
        $client->hobbies()->attach($request->hobbies);
        if ($request->has('image'))
        if ($request->image != null) {
            $client->media->each->delete();
             $client->save();
             $uuid = Str::uuid();
            $client->addMediaFromRequest('image')->usingName($uuid)->usingFileName($uuid . '.' . $request->image->extension())->toMediaCollection('images');
        }

        $client->save();

        return  $this->sendResponse(
            ['user' => User::findOrFail($client->id)],
            __("registration completed successfully!"),
            ApiCode::SUCCESS,
            0
        );
    }

    public function editprofile(Request $request){
        $rules=[
            'phone'=>'unique:users',
            'age'=>'numeric|min:18',
            'hour'=>'numeric|between:1,24',
            'coffee_cat'=>'numeric|between:0,2',
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
        $client=auth()->user();
        if ($request->has('first_name'))
        if ($request->first_name != null)
            $client->first_name = $request->first_name;

        if ($request->has('last_name'))
        if ($request->last_name != null)
            $client->last_name = $request->last_name;

        if($request->has('age'))
        if($request->age!=null)
            $client->age=$request->age;

        if($request->has('gender'))
        if($request->gender!=null)
            $client->gender=$request->gender;

        if($request->has('city'))
        if($request->city!=null)
            $client->city=$request->city;

        if($request->has('hour'))
        if($request->hour!=null)
            $client->hour=$request->hour;

        if($request->has('coffee_cat'))
        if($request->coffee_cat!=null)
            $client->coffee_cat=$request->coffee_cat;

        if($request->has('work'))
        if($request->work!=null)
            $client->work=$request->work;

        if ($request->has('image'))
        if ($request->image != null) {
            $client->media->each->delete();
             $client->save();
             $uuid = Str::uuid();
            $client->addMediaFromRequest('image')->usingName($uuid)->usingFileName($uuid . '.' . $request->image->extension())->toMediaCollection('images');
        }

        if($request->has('skills'))
        if($request->skills!=null)
            $client->skills()->sync($request->skills);

        if($request->has('hobbies'))
        if($request->hobbies!=null)
            $client->hobbies()->sync($request->hobbies);

        $client->save();
        return  $this->sendResponse(
            ['user' => User::findOrFail($client->id)],
            __("Updated successfully!"),
            ApiCode::SUCCESS,
            0
        );
    }

    public function logout()
    {
        auth()->logout();
        return  $this->sendResponse(null, __("User successfully logged out"),  ApiCode::SUCCESS, 0);
    }

    public function information(){

        $works=Work::all();
        $cities=City::all();
        $skills=Skill::all();
        $hobbies=Hobby::all();

        return $this->sendResponse([
            'works'=>$works,
            'cities'=>$cities,
            'skills'=>$skills,
            'hobbies'=>$hobbies
        ],"all details to users",ApiCode::SUCCESS,0);
    }

     // update user FCM token
     public function update_fcm(Request $request)
     {
        $rules=[
           'fcm_token'=>'required|string'
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
         $user =auth()->user();
         $user->fcm_token= $request->fcm_token;
         $user->save();
         return $this->sendResponse(['fcm_token' => $user->fcm_token], "fcm_token updated sccessfully",ApiCode::SUCCESS, 0);
     }

      // get user fcm
    public function refresh_fcm($id)
    {
        $user = User::find($id);
        $token = $user->fcm_token;
        if ($token != null) {
           return $this->sendResponse(['fcm_token' => $token], "fcm_token to user",ApiCode::SUCCESS, 0);
        } else {
            return $this->sendResponse(null, "error",ApiCode::BAD_REQUEST, 1);
        }
    }
}
