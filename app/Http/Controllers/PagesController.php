<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Storage;

class PagesController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function databaseBackup()
    {
        try {
            Artisan::call('backup:run');
            $path = storage_path('app/Todo-List/' . date('Y-m-d-H-i-s') . '.zip');
            
            do {
                if (!Storage::disk('local')->exists($path)) {
                    return response()->download($path);
                    break;
                }
            } while (true);
        } catch (\Exception $e) {
            echo '<div class="text-center">There is some problem, Please try again later.</div>';
        }
    }
}
