<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\V1\LevelController;
use \App\Http\Controllers\Api\V1\DeveloperController;

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

Route::get('/', function () {
    return [
        'app' => config('app.name'),
        'version' => '1.0.0',
        'version API' => 'V1'
    ];
});

Route::get('level/search', [LevelController::class , "search"]);
Route::get('developer/search', [DeveloperController::class , "search"]);

Route::resources([
    'levels' =>  LevelController::class,
    'developers' => DeveloperController::class
]);


