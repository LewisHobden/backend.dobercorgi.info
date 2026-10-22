<?php

use App\Enums\DiscordPermissions;
use App\Http\Controllers\DiscordLoginController;
use App\Http\Controllers\DiscordRedirectController;
use App\Http\Controllers\ResourceCategoryController;
use App\Http\Controllers\ResourceController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get("/login", DiscordRedirectController::class)->name("login");
Route::get("/login/discord-callback", [DiscordLoginController::class, "login"]);
Route::get("/logout", [DiscordLoginController::class, "logout"]);

Route::resource("categories.resources", ResourceController::class)
    ->middleware(["auth", IsAdmin::class . ":" . DiscordPermissions::MANAGE_WEBHOOKS]);

Route::resource("categories", ResourceCategoryController::class)
    ->middleware(["auth", IsAdmin::class . ":" . DiscordPermissions::MANAGE_WEBHOOKS]);
