<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class PagesController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function databaseBackup()
    {
        //echo date('Y-m-d-H-i-s');
        //echo exec('php artisan backup:run');
        Artisan::call('backup:run');
        $path = storage_path('app/Todo-List/' . date('Y-m-d-H-i-s') . '.zip');
        return response()->download($path);
    }
}
