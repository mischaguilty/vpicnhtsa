<?php

Route::prefix('nhtsa')->group(function () {
    Route::prefix('vin')->group(function () {
        Route::get('{vin}', function (string $vin) {
            (new \Mischa\Vpicnhtsa\Console\SearchVinCommand($vin))->handle();
        });
    });
});
