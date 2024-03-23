<?php

use App\Models\Company;
use App\Models\User;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    $config = [
        'host' => config('database.connections.clickhouse.host'),
        'port' => config('database.connections.clickhouse.port'),
        'username' => config('database.connections.clickhouse.username'),
        'password' => config('database.connections.clickhouse.password'),
        'https' => false
    ];

    $db = new ClickHouseDB\Client($config);
    if (!$db->ping()) {
        echo 'Error connect';
    }else{
       dump($db->select('SHOW DATABASES')) ;
    }
});