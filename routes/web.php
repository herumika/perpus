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

Route::get('/', function () {
    return view('welcome');
});

// Admin ===========================================================
// Admin ===========================================================
// Admin ===========================================================

Route::group(['middleware'=>'auth'], function(){

    Route::get('/keluar', 'HomeController@keluar');
    

    Route::group(['middleware'=>'AdminMiddleware'], function(){

        Route::get('/admin', 'Admin\Admin_controller@index');

        Route::get('/admin/penulis', 'Admin\Penulis_controller@index'); // PENULIS ****************************
        Route::post('/admin/penulis/store', 'Admin\Penulis_controller@store');
        Route::post('/admin/penulis/update/{id}', 'Admin\Penulis_controller@update');
        Route::post('/admin/penulis/delete/{id}', 'Admin\Penulis_controller@delete');
        Route::get('/admin/penulis/yajra', 'Admin\Penulis_controller@yajra');
        Route::get('/admin/penulis/details/{id}', 'Admin\Penulis_controller@details');
        Route::get('/admin/penulis/details-penulis/{id}', 'Admin\Penulis_controller@details_penulis');

        Route::get('/admin/kategori', 'Admin\Kategori_controller@index'); // KATEGORI ****************************
        Route::post('/admin/kategori/store', 'Admin\Kategori_controller@store');
        Route::post('/admin/kategori/update/{id}', 'Admin\Kategori_controller@update');
        Route::post('/admin/kategori/delete/{id}', 'Admin\Kategori_controller@delete');
        Route::get('/admin/kategori/yajra', 'Admin\Kategori_controller@yajra');

        Route::get('/admin/buku', 'Admin\Buku_controller@index'); // BUKU ****************************
        Route::post('/admin/buku/store', 'Admin\Buku_controller@store');
        Route::get('/admin/buku/edit/{id}', 'Admin\Buku_controller@edit');
        Route::post('/admin/buku/update/{id}', 'Admin\Buku_controller@update');
        Route::post('/admin/buku/delete/{id}', 'Admin\Buku_controller@delete');
        Route::get('/admin/buku/yajra', 'Admin\Buku_controller@yajra');
        Route::get('/admin/buku/ajax-detail/{id}', 'Admin\Buku_controller@ajax_detail');

        Route::get('/admin/pinjam/kembali/{buku_id}/{user_id}', 'Admin\Pinjaman_controller@kembali');

        Route::get('/admin/pinjaman', 'Admin\Pinjaman_controller@index');
        Route::get('/admin/pinjaman/yajra', 'Admin\Pinjaman_controller@yajra');

        
    });

    // User ==============================================================================================================
    // User ==============================================================================================================
    // User ==============================================================================================================

    Route::group(['middleware'=>'UserMiddleware'], function(){
        Route::get('/user', 'User\User_controller@index');

        Route::get('/user/kategori', 'User\Kategori_controller@index'); // KATEGORI ****************************
        Route::post('/user/kategori/store', 'User\Kategori_controller@store');
        Route::post('/user/kategori/update/{id}', 'User\Kategori_controller@update');
        Route::post('/user/kategori/delete/{id}', 'User\Kategori_controller@delete');
        Route::get('/user/kategori/yajra', 'User\Kategori_controller@yajra');

        Route::get('/user/buku', 'User\Buku_controller@index'); // BUKU ****************************
        Route::post('/user/buku/store', 'User\Buku_controller@store');
        Route::get('/user/buku/edit/{id}', 'User\Buku_controller@edit');
        Route::post('/user/buku/update/{id}', 'User\Buku_controller@update');
        Route::post('/user/buku/delete/{id}', 'User\Buku_controller@delete');
        Route::get('/user/buku/yajra', 'User\Buku_controller@yajra');
        Route::get('/user/buku/ajax-detail/{id}', 'User\Buku_controller@ajax_detail');
        
        Route::get('/user/pinjam/store/{buku_id}', 'User\Pinjaman_controller@store');// PINJAM BUKU *********************

        Route::get('/user/pinjaman', 'User\Pinjaman_controller@index');
        Route::get('/user/pinjaman/yajra', 'User\Pinjaman_controller@yajra');
    });
});


Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
