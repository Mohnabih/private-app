<?php

namespace App\Http\Controllers\Info;

use App\ApiCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\AppBaseController;
use App\Models\City;
use App\Models\Coffee;
use App\Models\Hobby;
use App\Models\Skill;
use App\Models\User;
use App\Models\Work;

class InformationController extends AppBaseController
{

//////////Jobs////////////////////////////////
public function allJobs(){
    $jobs=Work::paginate(5);

    return $this->sendResponse(
       ['jobs'=> $jobs],
      "all jobs",
      ApiCode::SUCCESS, 0);
}
    public function addJob(Request $request){
        $rules=[
            'value'=>'required'
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
        $input=$validator->validated();
        $job=Work::create($input);
        return $this->sendResponse(
           $job,
         "Job created successfully",
         ApiCode::CREATED, 0);
    }

    public function JobDestroy($job_id){
        $job=Work::findOrFail($job_id);
        $job->delete();
        return $this->sendResponse(
            null,
          "Job deleted successfully",
          ApiCode::CREATED, 0);
    }
    ////////////////EndJobs////////////////////////////////

    ////////////////Cities////////////////////////////////
    public function allCities(){
        $cities=City::paginate(5);

        return $this->sendResponse(
           ['cities'=> $cities],
          "all cities",
          ApiCode::SUCCESS, 0);
    }
    public function addCity(Request $request){
        $rules=[
            'value'=>'required'
        ];
        $message=[
            'value.required'=>'The City name field is required.'
        ];
        $validator=Validator::make($request->all(),$rules,$message);
        if($validator->fails()){
            return $this->sendResponse(
                $validator->errors(),
                "validation errors",
                ApiCode::BAD_REQUEST,
                1
            );
        }
        $input=$validator->validated();
        $city=City::create($input);
        return $this->sendResponse(
           $city,
         "City created successfully",
         ApiCode::CREATED, 0);
    }

    public function DestroyCity($City_id){
        $city=City::findOrFail($City_id);
        $city->delete();
        return $this->sendResponse(
            null,
          "City deleted successfully",
          ApiCode::SUCCESS, 0);
    }
      ////////////////EndCities////////////////////////////////

     ////////////////Interset////////////////////////////////
     public function allIntersets(){
        $intersets=Skill::paginate(5);

        return $this->sendResponse(
           ['intersets'=> $intersets],
          "all intersets",
          ApiCode::SUCCESS, 0);
    }
    public function addInterset(Request $request){
        $rules=[
            'key'=>'required'
        ];
        $message=[
            'key.required'=>'The Interset name field is required.'
        ];
        $validator=Validator::make($request->all(),$rules,$message);
        if($validator->fails()){
            return $this->sendResponse(
                $validator->errors(),
                "validation errors",
                ApiCode::BAD_REQUEST,
                1
            );
        }
        $input=$validator->validated();
        $Interset=Skill::create($input);
        return $this->sendResponse(
           $Interset,
         "Interset created successfully",
         ApiCode::CREATED, 0);
    }

    public function DestroyInterset($Interset_id){
        $Interset=Skill::findOrFail($Interset_id);
        $Interset->delete();
        return $this->sendResponse(
            null,
          "Interset deleted successfully",
          ApiCode::CREATED, 0);
    }
      ////////////////EndCities////////////////////////////////

    ////////////////Hobbies////////////////////////////////
    public function allHobbies(){
        $hobbies=Hobby::paginate(5);

        return $this->sendResponse(
           ['hobbies'=> $hobbies],
          "all hobbies",
          ApiCode::SUCCESS, 0);
    }
    public function addHobby(Request $request){
        $rules=[
            'key'=>'required'
        ];
        $message=[
            'key.required'=>'The Hobby name field is required.'
        ];
        $validator=Validator::make($request->all(),$rules,$message);
        if($validator->fails()){
            return $this->sendResponse(
                $validator->errors(),
                "validation errors",
                ApiCode::BAD_REQUEST,
                1
            );
        }
        $input=$validator->validated();
        $Hobby=Hobby::create($input);
        return $this->sendResponse(
           $Hobby,
         "Hobby created successfully",
         ApiCode::CREATED, 0);
    }

    public function DestroyHobby($Hobby_id){
        $Interset=Hobby::findOrFail($Hobby_id);
        $Interset->delete();
        return $this->sendResponse(
            null,
          "Hobby deleted successfully",
          ApiCode::CREATED, 0);
    }
      ////////////////EndHobbies////////////////////////////////

    ////////////////Coffees////////////////////////////////
    public function allCoffees(){
        $coffees=Coffee::paginate(5);

        return $this->sendResponse(
           ['coffees'=> $coffees],
          "all coffees",
          ApiCode::SUCCESS, 0);
    }
    public function addCoffee(Request $request){
        $rules=[
            'name'=>'required',
            'category'=>'required|numeric|between:0,2',
            'address'=>'required'
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
        $input=$request->all();
        $coffee=Coffee::create($input);
        return $this->sendResponse(
           $coffee,
         "coffee created successfully",
         ApiCode::CREATED, 0);
    }

    public function updateCoffee(Request $request,$Coffee_id){
        $rules=[
            'name'=>'required',
            'category'=>'required|numeric|between:0,2',
            'address'=>'required'
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

        $coffee=Coffee::findOrFail($Coffee_id);

        if($request->has('name'))
        if($request->name!=null)
            $coffee->name=$request->name;

        if($request->has('category'))
        if($request->category!=null)
            $coffee->category=$request->category;

        if($request->has('address'))
        if($request->address!=null)
            $coffee->address=$request->address;

        if($request->has('latitude'))
        if($request->latitude!=null)
            $coffee->latitude=$request->latitude;

        if($request->has('longitude'))
        if($request->longitude!=null)
            $coffee->longitude=$request->longitude;

        $coffee->save();
        return $this->sendResponse(
            $coffee,
          "coffee updated successfully",
          ApiCode::CREATED, 0);
    }

    public function DestroyCoffee($Coffee_id){
        $coffee=Coffee::findOrFail($Coffee_id);
        $coffee->delete();
        return $this->sendResponse(
            null,
          "coffee deleted successfully",
          ApiCode::SUCCESS, 0);
    }
      ////////////////EndCoffees////////////////////////////////

      public function Subscribers(Request $request){
        $subscribers=User::where('role',1)->when(request('title_search','') !='',function ($q){
            $q->where('first_name','LIKE','%'.request('title_search').'%')->orwhere('last_name','LIKE','%'.request('title_search').'%');
        })->paginate(10);

        return $this->sendResponse(
            ['subscribers'=> $subscribers],
           "all subscribers",
           ApiCode::SUCCESS, 0);
      }

}

