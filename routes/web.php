<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\ProdukController;

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

Route::group(['middleware' =>'revalidate'], function (){
    Route::get('/', function () {
        return view('home', [
            "title" => "Home",
            'active'=> 'home',
        ]);
    });

    Route::get('/about', function () {
        return view('about', [
            "title" => "About",
            'active'=> 'about',
        ]);
    });
    
    Route::get('/help', function () {
        return view('help', [
            "title" => "Help",
            'active'=> 'help',
        ]);
    });
});

Route::group(['middleware' =>['auth','revalidate']], function (){
    Route::get('/profil', function () {
        return view('profil', [
            "title" => "Profil",
            'active'=> 'profil',
        ]);
    });

    Route::post('pesan/{id}', [ProdukController::class, 'pesan']);

    Route::get('/posts', [PostController::class, 'index']);
    
    //Halaman Single Post
    Route::get('posts/{post:slug}', [PostController::class, 'show']);
    
    Route::get('/produk', [ProdukController::class, 'index']);
    
    Route::get('/dashboard', function(){
        return view('dashboard.index');
    })->middleware('admin');
    
    Route::get('/dashboard/posts/checkSlug', [DashboardPostController::class, 'checkSlug'])->middleware('auth');
    Route::resource('/dashboard/posts', DashboardPostController::class)->middleware('admin');
});

    Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
    Route::post('/login', [LoginController::class, 'authenticate']);
    Route::post('/logout', [LoginController::class, 'logout']);
    
    Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
    Route::post('/register', [RegisterController::class, 'store']);