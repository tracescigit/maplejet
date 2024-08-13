<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserLogController;
use Illuminate\Support\Facades\Route;
use Spatie\Activitylog\Models\Activity;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/node-data', function () {
    return view('node_data');
});


Route::middleware(['increase.execution.time'])->group(function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index']);
        Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');

        Route::get('/download-csv', [App\Http\Controllers\QrcodeController::class, 'downloadCsv']);
        Route::post('products/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('products.updated');
        Route::resource('products', App\Http\Controllers\ProductController::class);
        Route::resource('production-plants', App\Http\Controllers\ProductionPlantController::class);
        Route::resource('production-lines', App\Http\Controllers\ProductionLinesController::class);
        // Route::put('production-plants/{id}/edit', [App\Http\Controllers\ProductionPlantController::class, 'update'])->name('production-plants.update');
        Route::resource('scanhistories', App\Http\Controllers\ScanHistoriesController::class);
        Route::resource('jobs', App\Http\Controllers\JobsController::class);
        Route::get('/jobscsvdownload', [App\Http\Controllers\JobsController::class, 'jobscsvdownload'])->name('jobs.downloadcsv');

        Route::resource('print', App\Http\Controllers\PrintController::class);
        Route::get('/print_job', [App\Http\Controllers\PrintController::class, 'print_job'])->name('print_job');
        Route::get('/checkprintconnection', [App\Http\Controllers\PrintController::class, 'checkPrinterConnection'])->name('checkprintconnection');
        Route::get('/connectionweber', [App\Http\Controllers\PrintController::class, 'connectionweber'])->name('ConnectionWeber');

        Route::get('/SendPrintData', [App\Http\Controllers\PrintController::class, 'SendPrintData'])->name('SendPrintData');
        Route::get('/stopprint', [App\Http\Controllers\PrintController::class, 'StopPrint'])->name('stopprint');
        Route::get('/printmoduledownloadexcel', [App\Http\Controllers\PrintController::class, 'downloadexcel'])->name('downloadexcell');
        Route::get('/01/{product_id}/10/{qrcode}', [App\Http\Controllers\ProductController::class, 'getproductdetails'])->name('getscanproduct');
        Route::get('/11/{qrcode}', [App\Http\Controllers\ProductController::class, 'getproductdetailsqr'])->name('abc');
        Route::get('/cameradatacheck', [App\Http\Controllers\PrintController::class, 'cameradatacheck'])->name('cameradatacheck');
        Route::get('/populatemodal', [App\Http\Controllers\UserLogController::class, 'populatemodal'])->name('populatemodal');
        Route::get('/downloaduserlogexcel', [App\Http\Controllers\UserLogController::class, 'downloadexcel'])->name('userlog.downloadexcel');
        Route::get('/userlog', [App\Http\Controllers\UserLogController::class, 'index'])->name('userlog.index');
        Route::get('/userlog/show/{id}', [App\Http\Controllers\UserLogController::class, 'show'])->name('userlog.show');

        Route::post('forgotpassword', [App\Http\Controllers\AdminController::class, 'SendPassword'])
            ->name('password.send');
        // Route::middleware(['auth', 'permission:edit articles'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::resource('permissions', App\Http\Controllers\PermissionController::class);
        // Route::post('permissions/{id}', [App\Http\Controllers\PermissionController::class, 'destroy'])->name('permissions.destroy');
        Route::resource('roles', App\Http\Controllers\RoleController::class);
        // Route::post('roles/{id}', [App\Http\Controllers\RoleController::class, 'destroy'])->name('roles.destroy');
        Route::get('roles/{rolesId}/give-permissions', [App\Http\Controllers\RoleController::class, 'addPermissionToRole'])->name('manageroles');
        Route::put('roles/{rolesId}/give-permissions', [App\Http\Controllers\RoleController::class, 'givePermissionToRole'])->name('assignroles');
        Route::resource('users', App\Http\Controllers\UserController::class);
        Route::post('users/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');
        // });
        Route::resource('batches', App\Http\Controllers\BatchController::class);
        Route::post('batches/import', [App\Http\Controllers\BatchController::class, 'import'])->name('batches.import');
        Route::post('batches/bulkstatuschange', [App\Http\Controllers\QrcodeController::class, 'bulkstatuschange'])->name('batches.bulstatuschange');
        Route::resource('qrcodes', App\Http\Controllers\QrcodeController::class);
        Route::get('bulkuploads', [App\Http\Controllers\BulkUploadController::class, 'index'])->name('bulkuploads.index');
        Route::post('bulkuploads/store', [App\Http\Controllers\BulkUploadController::class, 'store'])->name('bulkuploads.store');
        Route::post('bulkuploads/storeserial_no', [App\Http\Controllers\BulkUploadController::class, 'store_serial_no'])->name('bulkuploads.store_serial_no');

        Route::post('bulkupload/bulkassign', [App\Http\Controllers\BulkUploadController::class, 'bulkassign'])->name('bulkupload.bulkassign');

        Route::get('/scans-data', [App\Http\Controllers\DashboardController::class, 'getCurrentMonthData']);


        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('/log_out', [App\Http\Controllers\adminController::class, 'logoutlanding'])->name('logout1');
        Route::get('/profileinfo', [App\Http\Controllers\adminController::class, 'viewprofile'])->name('profile');
        Route::get('/changepassword', [App\Http\Controllers\adminController::class, 'changepass']);
        Route::post('/changepassword', [App\Http\Controllers\adminController::class, 'changepasssave'])->name('changepassword');
        Route::get('/reportlog', [App\Http\Controllers\ReportLogController::class, 'index'])->name('reportlog.index');
        Route::get('/reportlogshow/{id}', [App\Http\Controllers\ReportLogController::class, 'show'])->name('reportlog.show');

        Route::get('/reportexceldownload', [App\Http\Controllers\ReportLogController::class, 'exceldownload'])->name('reportlog.exceldownload');
    });
});
Route::get('/checkcameraconn', [App\Http\Controllers\DashboardController::class, 'checkConnection'])->name('dashboard.checkConnection');
Route::get('download/{filename}', function ($filename) {
    $filePath = storage_path('app/exports/' . $filename);

    if (file_exists($filePath)) {
        return response()->download($filePath);
    } else {
        abort(404, 'File not found.');
    }
})->name('download');

require __DIR__ . '/auth.php';
