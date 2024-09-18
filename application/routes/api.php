<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IncidentController;

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

Route::post("register", [AuthController::class, "register"]);
Route::post("login", [AuthController::class, "login"]);

Route::group([
    "middleware" => ["auth:api"]
], function() {
    Route::get("profile", [AuthController::class, "profile"]);
    Route::get("refreshToken", [AuthController::class, "refreshToken"]);
    Route::get("logout", [AuthController::class, "logout"]);

    Route::get("incidents", [IncidentController::class, "getAllIncidents"]);
    Route::post("incidents", [IncidentController::class, "newIncident"]);
    Route::get("incidents/{id}", [IncidentController::class, "getIncidentByID"]);
    Route::put("incidents/{id}", [IncidentController::class, "updateIncident"]);
    Route::delete("incidents/{id}", [IncidentController::class, "deleteIncident"]);
});
