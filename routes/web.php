<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('db/backup', function() {
    Spatie\DbDumper\Databases\MySql::create()
    ->setDbName('todolist')
    ->setUserName('root')
    ->setPassword('')
    ->dumpToFile('todolist.sql');
});
Route::get('/{any}', 'App\Http\Controllers\PagesController@index')->where('any', '.*');
