<?php

Route::prefix('nhtsa')->group(function () {
    Route::prefix('vin')->group(function () {
        Route::get('{vin}', function (string $vin) {
            Artisan::call("search:vin", [
                'vin' => $vin,
            ]);
        });
    });
});
