<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;

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




// only guests or users who are not logged in or auth can access the following url
// middleware for guest, guest is obtained from App/Http/Kernel.php
Route::middleware(['guest'])->group(function() {
    // post type route, if the user is directed to the registration url then direct it to the following controller and there is its name
    Route::post('/registration', [RegistrationController::class, 'store'])->name('registration');
});


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
