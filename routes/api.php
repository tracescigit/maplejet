<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\QrController;
use App\Http\Controllers\Api\IssueSubmitController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => 'custom.baseurl'], function () {
    // Route::get('/generate-qr-code', [QRController::class, 'generateQRCode'])->name('generate.qr');
});
Route::get('/01/{product_id}/10/{qrcode}', [QrController::class, 'generateQRCode'])->name('generate.qr');
Route::get('/getphonenumber', [QrController::class, 'register'])->name('register.mob');
Route::get('/getotp', [QrController::class, 'getotp'])->name('register.getotp');
Route::get('/scanhistories/{product_id}', [QrController::class, 'scanhistoryall'])->name('scanhistoryall');
Route::get('/getproductdetails/{product_id}/{qrcode}', [QrController::class, 'getproductdetails'])->name('getproductdetails');

Route::get('/generate-token', [QrController::class, 'generateToken']);

Route::middleware(['capture.ip'])->group(function () {
    Route::post('/submitissue', [IssueSubmitController::class, 'submitissue'])->name('submitissue');
});
 

Route::post('/registeruser', [QrController::class, 'getuserdetails']);

Route::group(['middleware' => 'auth.bearer'], function () {
    Route::post('/getQrDetails', [QrController::class, 'getapidetails']);
    Route::post('/report', [QrController::class, 'reportProducts']); 
    Route::get('/scanHistory', [QrController::class, 'scanHistory']); 
    Route::get('/userProfile', [QrController::class, 'showUserProfile']); 
    Route::post('/updateProfile', [QrController::class, 'editProfile']); 


});




