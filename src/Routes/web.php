<?php

Route::post('/store/image', 'ImageController@store')->name('images.store');
Route::get('/storage/list', 'ImageController@show')->name('images.show');

Route::prefix('admin')->group(function(){
    Route::post('/logout', 'UserController@logout')->name('panel.admins.logout');
    Route::get('/login', "UserController@unauthenticated")->name('panel.unauthenticated')->middleware(['web']);
    Route::post('/login', "UserController@login")->name('panel.admins.login')->middleware(['web']);
    Route::middleware('auth')->group(function(){
        Route::get('/', function(){
            if(auth()->user()->hasRole('client')){
                return redirect()->route('/');
            }else{
                return redirect()->route('panel.admins.edit', ['id' => auth()->user()->id]);
            }
        })->name('panel.initial');
        Route::prefix('/cuentas')->group(function(){
            Route::prefix('/usuarios')->group(function(){
                Route::get('/', 'UserController@index')->name('panel.admins.index'); 
                Route::get('/nuevo', 'UserController@create')->name('panel.admins.create');
                Route::post('/store', 'UserController@store')->name('panel.admins.store');
                Route::get('/editar/{id}', 'UserController@edit')->name('panel.admins.edit');
                Route::put('/update/{id}', 'UserController@update')->name('panel.admins.update');
                Route::get('/password/editar/{id}', 'UserController@editPassword')->name('panel.admins.edit.password');
                Route::put('/password/update/{id}', 'UserController@updatePassword')->name('panel.admins.update.password');
                Route::delete('/destroy/{id}', 'UserController@destroy')->name('panel.admins.destroy');
            });
            Route::prefix('/roles')->group(function(){
                Route::get('/', 'RoleController@index')->name('panel.roles.index');
                Route::get('/nuevo', 'RoleController@create')->name('panel.roles.create');
                Route::get('/editar/{id}', 'RoleController@edit')->name('panel.roles.edit');
                Route::post('/store', 'RoleController@store')->name('panel.roles.store');
                Route::put('/update/{id}', 'RoleController@update')->name('panel.roles.update');
                Route::delete('/destroy/{id}', 'RoleController@destroy')->name('panel.roles.destroy');
            });
        });
    });
});