<?php


use Dzorogh\Family\Http\Http\Controllers\FamilyCoupleController;
use Dzorogh\Family\Http\Http\Controllers\FamilyPersonController;

Route::prefix('api')->group(function () {
    Route::prefix('v1')->group(function () {
        Route::prefix('family')->group(function () {
            Route::prefix('couples')
                ->controller(FamilyCoupleController::class)
                ->group(function () {
                    Route::get('/', 'index');
                });

            Route::prefix('people')
                ->controller(FamilyPersonController::class)
                ->group(function () {
                    Route::get('/', 'index');
                    Route::get('{person}', 'show');
                });
        });
    });
});
