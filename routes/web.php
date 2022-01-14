<?php

use App\Http\Controllers\DealController;
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
    return view('welcome');
});

Route::group([
    'prefix' => 'portal'
], function () {
    Route::get('', [DealController::class, 'portalPage'])->name('add.portal');
    Route::post('', [DealController::class, 'portal'])->name('add.portal');
});

Route::group([
    'prefix' => 'lead'
], function () {
    Route::get('page/{slug}', [DealController::class, 'leadGenerationPage'])->name('lead.generation.page');
    Route::post('generation', [DealController::class, 'leadGeneration'])->name('lead.generation');
});

Route::group([
    'prefix' => 'deal'
], function () {
    Route::get('confirm/{id}', [DealController::class, 'confirmDeal'])->name('confirm.deal');
    Route::get('cancel/{id}', [DealController::class, 'cancelDeal'])->name('cancel.deal');
});
