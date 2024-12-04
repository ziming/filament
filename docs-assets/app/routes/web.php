<?php

use App\Livewire\ActionsDemo;
use App\Livewire\Forms\FieldsDemo;
use App\Livewire\Forms\GettingStartedDemo;
use App\Livewire\Forms\LayoutDemo as FormsLayoutDemo;
use App\Livewire\Infolists\EntriesDemo;
use App\Livewire\Infolists\LayoutDemo as InfolistsLayoutDemo;
use App\Livewire\NotificationsDemo;
use App\Livewire\Panels\Navigation\UserMenuCustomization;
use App\Livewire\TablesDemo;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/actions', ActionsDemo::class);
Route::get('/notifications', NotificationsDemo::class);
Route::get('/tables', TablesDemo::class);

Route::group(['prefix' => 'forms'], function () {
    Route::get('fields', FieldsDemo::class);
    Route::get('getting-started', GettingStartedDemo::class);
    Route::get('layout', FormsLayoutDemo::class);
});

Route::group(['prefix' => 'infolists'], function () {
    Route::get('entries', EntriesDemo::class);
    Route::get('layout', InfolistsLayoutDemo::class);
});

Route::group(['prefix' => 'panels'], function () {
    Route::group(['prefix' => 'navigation'], function () {
        Route::get('user-menu-customization', UserMenuCustomization::class);
    });
});
