<?php

use App\Http\Controllers\Attendance;
use App\Http\Controllers\Client;
use App\Http\Controllers\Lead as ControllersLead;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/* Registering Clients - Super admin or User */
Route::post("/register", [Client::class, 'register']);

/* For logged In the registered User */
Route::post("/login", [Client::class, "login"]);

/* Adding Leads To System */
Route::post("/addLead", [ControllersLead::class, 'addLead']);

/* View All Leads */
Route::get("/viewLeads", [ControllersLead::class, 'viewLead']);

/* View all Agent  */
Route::get('/viewAgent/{type}', [ControllersLead::class, 'viewAgent']);

/* Add Agent */
Route::post("/addAgent", [Client::class, 'addAgent']);

/* Edit Agent */
Route::post("/editAgent/{email}", [Client::class, 'editAgent']);

/* Delete Agent */

Route::post("/deleteAgent/{email}", [Client::class, 'deleteAgent']);

/* Add Super Admin */
Route::post("/addSuperAdmin", [Client::class, 'addSuperAdmin']);

/* For Check-In User */
Route::post('/timeIn/{useremail}', [Attendance::class, 'timeIn']);

/* For Checkout User */
Route::post('/timeOut/{email}', [Attendance::class, "timeOut"]);

/* Change Leads Status */
Route::post('/changeStatus/{email}', [ControllersLead::class, 'changeStatus']);
/* Assigning Leads to User || Admin */
Route::post("/assign/{fromemail}/{toemil}", [ControllersLead::class, 'assignLeads']);
