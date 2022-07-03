<?php

use App\Http\Controllers\MatchController;
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

Route::get('/properties', [MatchController::class, 'list_properties']); //just for check results
Route::get('/search_profiles', [MatchController::class, 'list_search_profiles']); //just for check results

Route::get('/match/{propertyId}', [MatchController::class, 'searchSuitedProfiles']); //required

