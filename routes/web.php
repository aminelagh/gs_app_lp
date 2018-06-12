<?php

use Illuminate\Http\Request;
//use \App\Models\User;
use Carbon\Carbon;
use Cartalyst\Sentinel\Users\EloquentUser as User;


Route::get('/a', function () {
  $user = User::all();
  dump($user);
  return view('welcome');
});


Route::get('/s',function(){
  dd(Session::all());
});


//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@@   Admin-routes   @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () {
  Route::get('/', 'AdminController@home')->name('admin.accueil');
});

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@@   User-routes   @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
Route::group(['middleware' => 'user'], function () {
  Route::get('/', 'UserController@accueil')->name('accueil');
  Route::post('/updateProfil', 'UserController@updateProfil')->name('updateProfile');

  Route::get('/stock', 'StockController@stock')->name('stock');
  Route::post('/addStockIN','StockController@addStockIN')->name('addStockIN');
  Route::post('/addStockOUT','StockController@addStockOUT')->name('addStockOUT');
  Route::post('/addVente','StockController@addVente')->name('addVente');

  Route::get('/stockINs', 'StockController@stockINs')->name('stockINs');
  Route::get('/stockIN/{id_transaction}', 'StockController@stockIN')->name('stockIN');

  Route::get('/stockOUTs', 'StockController@stockOUTs')->name('stockOUTs');
  Route::get('/stockOUT/{id_transaction}', 'StockController@stockOUT')->name('stockOUT');

  Route::get('/ventes', 'StockController@ventes')->name('ventes');
  Route::get('/vente/{id_transaction}', 'StockController@vente')->name('vente');

  Route::get('/categorie/{id_categorie}','UserController@categorie')->name('categorie');
  Route::post('/addCategorie', 'UserController@addCategorie')->name('addCategorie');
  Route::post('/updateCategorie', 'UserController@updateCategorie')->name('updateCategorie');
  Route::post('/deleteCategorie', 'UserController@deleteCategorie')->name('deleteCategorie');

  Route::post('/addArticle', 'UserController@addArticle')->name('addArticle');
  Route::post('/updateArticle', 'UserController@updateArticle')->name('updateArticle');
  Route::post('/deleteArticle', 'UserController@deleteArticle')->name('deleteArticle');


});


Route::get('/error',function(){
  return "<h1>ErrorPageHere</h1>";
})->name('error');

//Authentification
//login
Route::get('/login', 'AuthController@login')->name('login');
Route::post('/login', 'AuthController@submitLogin')->name('submitLogin');

//register
Route::get('/register', 'AuthController@register')->name('register');
Route::post('/register', 'AuthController@submitRegister')->name('submitRegister');

//logout
Route::get('/logout', 'AuthController@logout')->name('logout');

//error Routes
Route::get('{any}', function () {
  return redirect()->back()->with('alert_warning',"Oups !<br>il paraît que vous avez pris le mauvais chemin");
});
