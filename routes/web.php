<?php

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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get("/login","DiscordRedirectController")->name("login");
Route::get("/login/discord-callback", "DiscordLoginController@login");
Route::get("/logout","DiscordLoginController@logout");

//Route::resource("categories.resources","ResourceController")->middleware("IsAdmin");

Route::resource("categories","ResourceCategoryController")
    ->middleware(["auth",\App\Http\Middleware\IsAdmin::class . ":" . \App\Enums\DiscordPermissions::MANAGE_GUILD]);
