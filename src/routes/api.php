<?php

use Amir\Access\RouteHelper;
use Amir\Access\Controllers\RoleController;
use Illuminate\Support\Facades\Route;



Route::prefix('administrator')->name('admin')->group(function () {


    // Roles Part
    Route::prefix('roles')->name('roles')->group(function () {

        Route::get('/{status?}', [RoleController::class, 'getRoles'])->name('roleList');

        Route::prefix('role')->name('role')->group(function () {
            (new RouteHelper(Route::get('/{id}', [RoleController::class, 'loadRole'])->name('roleSetting')))
                ->addTitle('Get data one role')
                ->addAccessRole('admin');

            (new RouteHelper(Route::post('/update-role/{id}', [RoleController::class, 'updateRole'])->name('uploadRole')))
                ->addTitle('Update data one role')
                ->addAccessRole('admin');

        });

    });

});


