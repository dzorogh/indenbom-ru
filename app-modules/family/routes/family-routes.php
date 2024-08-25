<?php

use Dzorogh\Family\Http\Controllers\FamilyTreeController;

Route::prefix('api')->group(function () {
    Route::prefix('v1')->group(function () {
        Route::prefix('family')->group(function () {
            Route::controller(FamilyTreeController::class)->group(function () {
                Route::get('/tree', 'tree');
            });
        });
    });
});
