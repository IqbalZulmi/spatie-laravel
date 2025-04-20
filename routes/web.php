<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Expr\Assign;

Route::get('/', function () {
    return redirect()->route('role.index');
});

Route::apiResource('/role', RolesController::class);
Route::apiResource('/permission', PermissionController::class);
Route::get('users/assign',[UserController::class,'assignIndex'])->name('user.assign.index');
Route::put('users/{id}/assign_roles',[UserController::class,'assignRoles'])->name('user.assign.roles.update');
Route::put('users/{id}/assign_permisson',[UserController::class,'assignPermission'])->name('user.assign.permissions.update');
