<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\DbDumper\Databases\MySql;

class PagesController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function databaseBackup()
    {
        MySql::create()
            ->setDbName(config('database.connections.mysql.database'))
            ->setUserName(config('database.connections.mysql.username'))
            ->setPassword(config('database.connections.mysql.password'))
            ->dumpToFile('dump.sql');
    }
}
