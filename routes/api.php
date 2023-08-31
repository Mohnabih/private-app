<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Info\InformationController;
use App\Http\Controllers\Filter\FilterController;
use App\Http\Controllers\Info\NotificationController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Admin\AdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix'=>'users/v1'],function($router){
    Route::post('/register',[AuthController::class,'register']);
    Route::post('/update_fcm',[AuthController::class,'update_fcm']);
    Route::post('/CompleteRegister',[AuthController::class,'CompleteRegister']);
    Route::post('/login',[AuthController::class,'login']);
    Route::get('/refresh_fcm/{id}',[AuthController::class,'refresh_fcm']);
    Route::get('/logout',[AuthController::class,'logout']);
    Route::post('/editprofile',[AuthController::class,'editprofile']);
    Route::get('/info',[AuthController::class,'information']);
    Route::get('/UsersFiltering',[FilterController::class,'Search']);
    Route::get('/UserOrders',[OrderController::class,'UserOrders']);
    Route::get('/DestroyOrder/{id}',[OrderController::class,'DestroyOrder']);
    Route::get('/CardMetting/{id}',[OrderController::class,'CardMetting']);
    Route::post('/sendrequest/{id}',[OrderController::class,'sendrequest']);
    Route::post('/UpdateRequest/{id}',[OrderController::class,'UpdateRequest']);

}
);

Route::group(['prefix'=>'admin/v1'],function($router){
    Route::post('/registerAdmin',[AdminController::class,'registerAdmin']);
    Route::post('/loginAdmin',[AdminController::class,'loginAdmin']);
    Route::post('/editAdmin',[AdminController::class,'editAdmin']);
    Route::post('/logout',[AdminController::class,'logout']);
    Route::post('/AddJobs',[InformationController::class,'addJob']);
    Route::get('/JobDestroy/{id}',[InformationController::class,'JobDestroy']);
    Route::post('/addCity',[InformationController::class,'addCity']);
    Route::get('/DestroyCity/{id}',[InformationController::class,'DestroyCity']);
    Route::post('/addInterset',[InformationController::class,'addInterset']);
    Route::get('/DestroyInterset/{id}',[InformationController::class,'DestroyInterset']);
    Route::post('/addHobby',[InformationController::class,'addHobby']);
    Route::get('/DestroyHobby/{id}',[InformationController::class,'DestroyHobby']);
    Route::post('/addCoffee',[InformationController::class,'addCoffee']);
    Route::post('/updateCoffee/{id}',[InformationController::class,'updateCoffee']);
    Route::get('/DestroyCoffee/{id}',[InformationController::class,'DestroyCoffee']);
    Route::get('/allCoffees',[InformationController::class,'allCoffees']);
    Route::get('/allCities',[InformationController::class,'allCities']);
    Route::get('/allHobbies',[InformationController::class,'allHobbies']);
    Route::get('/allIntersets',[InformationController::class,'allIntersets']);
    Route::get('/allJobs',[InformationController::class,'allJobs']);
    Route::get('/Subscribers',[InformationController::class,'Subscribers']);
    Route::get('/AllOrders',[AdminController::class,'AllOrders']);
    Route::get('/allNotifications',[NotificationController::class,'all']);
    Route::post('/AddNotification',[NotificationController::class,'sendNote']);
}
);
