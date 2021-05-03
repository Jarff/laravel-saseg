# Laravel Web Installer | A Web Installer [Package](https://packagist.org/packages/rodsaseg/saseg)

[![Total Downloads](https://poser.pugx.org/rodsaseg/laravel-saseg/downloads)](//packagist.org/packages/rodsaseg/laravel-saseg)
[![Latest Stable Version](https://poser.pugx.org/rodsaseg/laravel-saseg/v)](//packagist.org/packages/rodsaseg/laravel-saseg)
[![License](https://poser.pugx.org/rodsaseg/laravel-saseg/license)](//packagist.org/packages/rodsaseg/laravel-saseg)

- [About](#about)
- [Requirements](#requirements)
- [Installation](#installation)
- [Routes](#routes)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

## About

Do you want your clients to be able to install a Laravel project just like they do with WordPress or any other CMS?
This Laravel package allows users who don't use Composer, SSH etc to install your application just by following the setup wizard.
The current features are :

- Check For Server Requirements.
- Check For Folders Permissions.
- Ability to set database information.
	- .env text editor
	- .env form wizard
- Migrate The Database.
- Seed The Tables.

## Requirements

* [Laravel 5.8.*](https://laravel.com/docs/installation)

## Installation

1. From your projects root folder in terminal run:

```bash
    composer require rodsaseg/laravel-saseg
```

2. Register the package

* Laravel 5.5 and up
Uses package auto discovery feature, no need to edit the `config/app.php` file.

3. Publish the packages views, config file, assets, and language files by running the following from your projects root folder:

```bash
	#default Views and Controllers
    php artisan vendor:publish --tag=laravelsaseg
```

```bash
	#Spatie Permission
    php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

```bash
	#Spatie Media Library
    php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="migrations"
```

```bash
	#DataTables
    php artisan vendor:publish --tag=datatables
```

4. Clear your config cache. This package requires access to the permission config. Generally it's bad practice to do config-caching in a development environment. If you've been caching configurations locally, clear your config cache with either of these commands:

```bash
	php artisan optimize:clear
	# or
	php artisan config:clear
```

5. Run the migrations

```bash
	php artisan migrate
```

## Middleware

Update the redirect function inside Middleware/Authenticate.php with:

	if (! $request->expectsJson()) {
		if(preg_match("/\bpanel\b/", $request->route()->getName())){
			return route('panel.unauthenticated');
		}else{
			session()->flash('login', true);
			return route('/');
		}
	}

## Preparing Your Models

The `HasRoles` trait must be added to the User model to enable this package's features.

Thus, a typical basic User model would have these basic minimum requirements:

	use Illuminate\Foundation\Auth\User as Authenticatable;
	use Spatie\Permission\Traits\HasRoles;

	class User extends Authenticatable
	{
		use HasRoles;

		// ...
	}

To associate media with a model, the model must implement the following interface and trait:

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;
	use Spatie\MediaLibrary\HasMedia\HasMedia;
	use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

	class News extends Model implements HasMedia
	{
		use HasMediaTrait;
		...
	}


## Routes

Add the next routes to your web.php file

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

Additional these routes would be available for proper installation or update

* `/install`
* `/update`

## Usage

* **Install Routes Notes**
	* In order to install your application, go to the `/install` route and follow the instructions.
	* Once the installation has ran the empty file `installed` will be placed into the `/storage` directory. If this file is present the route `/install` will abort to the 404 page.

* **Update Route Notes**
	* In order to update your application, go to the `/update` route and follow the instructions.
	* The `/update` routes countes how many migration files exist in the `/database/migrations` folder and compares that count against the migrations table. If the files count is greater then the `/update` route will render, otherwise, the page will abort to the 404 page.

* Additional Files and folders published to your project :

|File|File Information|
|:------------|:------------|
|`config/installer.php`|In here you can set the requirements along with the folders permissions for your application to run, by default the array cotaines the default requirements for a basic Laravel app.|
|`public/panel`|All the assets necesary for the panel|
|`public/installer/assets`|This folder contains a css folder and inside of it you will find a `main.css` file, this file is responsible for the styling of your installer, you can overide the default styling and add your own.|
|`resources/views/vendor/installer`|This folder contains the HTML code for your installer, it is 100% customizable, give it a look and see how nice/clean it is.|
|`resources/lang/en/installer_messages.php`|This file holds all the messages/text, currently only English is available, if your application is in another language, you can copy/past it in your language folder and modify it the way you want.|

## Contributing

Stay tunned

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.