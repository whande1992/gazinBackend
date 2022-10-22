<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return response()->json([
       'description' => 'Api Backend Developers',
       'document API' => 'https://wanderleiborba.postman.co/workspace/My-Workspace~0e2d1497-d4a6-4e5e-87ae-09f9995482fa/documentation/24012300-a6ad8093-e156-43ea-a333-e98ff5ba27fb?workspace=0e2d1497-d4a6-4e5e-87ae-09f9995482fa',
        'name' => 'Wanderlei Borba Cordeiro'
    ]);
});
