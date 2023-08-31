<?php

namespace App\Http\Controllers\Filter;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\ApiCode;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Collection;

class FilterController extends AppBaseController
{

    public function Search(Request $request){
        $rules=[
            'gender'=>'required|boolean',
            'category'=>'required',
            'age_from'=>'required|numeric|min:18',
            'age_to'=>'required|numeric|max:100',
            'time_from'=>'required|numeric|min:1',
            'time_to'=>'required|numeric|max:24',
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
        $skills=DB::table('skill_user')->where('user_id',$user->id)->pluck('skill_id');
        $hobbies=DB::table('hobby_user')->where('user_id',$user->id)->pluck('hobby_id');

        $clinets=User::where('id','<>',$user->id)->where('status',0)
        ->where(function($query) use ($request,$user){
            $query->where('gender',$request->gender)
            ->where(function($query) use($request,$user){
                $query->where('coffee_cat',$request->category)
                    ->where(function($query) use($request,$user){
                        $query->where('age','>=',$request->age_from)
                        ->where('age','<=',$request->age_to)
                        ->where('hour','>=',$request->time_from)
                        ->where('hour','<=',$request->time_to)
                        ->where('city',$user->city);
                    });

            });
        })->get();

        return  $this->sendResponse($clinets,
            "all matches users",
            ApiCode::SUCCESS,
            0
        );
    }
}
