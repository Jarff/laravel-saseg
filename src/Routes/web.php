<?php

Route::post('/store/image', 'Rodsaseg\LaravelSaseg\Controllers\ImageController@store')->name('images.store');
Route::get('/storage/list', 'Rodsaseg\LaravelSaseg\Controllers\ImageController@show')->name('images.show');

Route::prefix('admin')->group(function(){
    Route::post('/logout', 'Rodsaseg\LaravelSaseg\Controllers\UserController@logout')->name('panel.admins.logout')->middleware(['web', 'auth']);
    Route::get('/login', "Rodsaseg\LaravelSaseg\Controllers\UserController@unauthenticated")->name('panel.unauthenticated')->middleware(['web']);
    Route::post('/login', "Rodsaseg\LaravelSaseg\Controllers\UserController@login")->name('panel.admins.login')->middleware(['web']);
    Route::middleware('web', 'auth')->group(function(){
        Route::get('/', function(){
            if(auth()->user()->hasRole('client')){
                return redirect()->route('/');
            }else{
                return redirect()->route('panel.admins.edit', ['id' => auth()->user()->id]);
            }
        })->name('panel.initial');
        Route::prefix('/cuentas')->group(function(){
            Route::prefix('/usuarios')->group(function(){
                Route::get('/', 'Rodsaseg\LaravelSaseg\Controllers\UserController@index')->name('panel.admins.index'); 
                Route::get('/nuevo', 'Rodsaseg\LaravelSaseg\Controllers\UserController@create')->name('panel.admins.create');
                Route::post('/store', 'Rodsaseg\LaravelSaseg\Controllers\UserController@store')->name('panel.admins.store');
                Route::get('/editar/{id}', 'Rodsaseg\LaravelSaseg\Controllers\UserController@edit')->name('panel.admins.edit');
                Route::put('/update/{id}', 'Rodsaseg\LaravelSaseg\Controllers\UserController@update')->name('panel.admins.update');
                Route::get('/password/editar/{id}', 'Rodsaseg\LaravelSaseg\Controllers\UserController@editPassword')->name('panel.admins.edit.password');
                Route::put('/password/update/{id}', 'Rodsaseg\LaravelSaseg\Controllers\UserController@updatePassword')->name('panel.admins.update.password');
                Route::delete('/destroy/{id}', 'Rodsaseg\LaravelSaseg\Controllers\UserController@destroy')->name('panel.admins.destroy');
            });
            Route::prefix('/roles')->group(function(){
                Route::get('/', 'Rodsaseg\LaravelSaseg\Controllers\RoleController@index')->name('panel.roles.index');
                Route::get('/nuevo', 'Rodsaseg\LaravelSaseg\Controllers\RoleController@create')->name('panel.roles.create');
                Route::get('/editar/{id}', 'Rodsaseg\LaravelSaseg\Controllers\RoleController@edit')->name('panel.roles.edit');
                Route::post('/store', 'Rodsaseg\LaravelSaseg\Controllers\RoleController@store')->name('panel.roles.store');
                Route::put('/update/{id}', 'Rodsaseg\LaravelSaseg\Controllers\RoleController@update')->name('panel.roles.update');
                Route::delete('/destroy/{id}', 'Rodsaseg\LaravelSaseg\Controllers\RoleController@destroy')->name('panel.roles.destroy');
            });
        });
    });
});