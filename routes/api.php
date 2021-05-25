<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\{AccountController,TransactionController};

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

Route::group([
    'prefix' => 'v1',
    'as' => 'api.',
], function () {
    Route::apiResource('accounts', AccountController::class);

    Route::prefix('transactions')->group(function (){
        Route::post('store', [TransactionController::class, 'store'])->name('transaction.store');
    });
});

