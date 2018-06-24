<?php

use Illuminate\Http\Request;
use Carbon\Carbon;
use Cartalyst\Sentinel\Users\EloquentUser as User;
use \App\Models\Article;
use \App\Models\Categorie;
use \App\Models\Stock;
use \App\Models\Transaction;
use \App\Models\Transaction_article;
use \App\Models\Unite;
use \App\Models\Detail;

Route::get('/a', function () {
  $user = User::all();
  dump($user);
  return view('welcome');
});


Route::get('/s',function(){
  //dd(Session::all());

  //$pdf = App::make('dompdf.wrapper');
  //$pdf->loadHTML('<h1>Test</h1>');
  //return $pdf->stream();

  $data = [ "no data" ];
  $pdf = PDF::loadView('pdf.facture')->setPaper('a4', 'portrait');//->setPaper('a4', 'landscape');
  return $pdf->stream();
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

  Route::get('/ventes', 'VenteController@ventes')->name('ventes');
  Route::get('/vente/{id_transaction}', 'VenteController@vente')->name('vente');
  Route::post('/annulerVente', 'VenteController@annulerVente')->name('annulerVente');

  Route::get('/articles', 'UserController@articles')->name('articles');

  Route::get('/categorie/{id_categorie}','UserController@categorie')->name('categorie');
  Route::post('/addCategorie', 'CategorieController@addCategorie')->name('addCategorie');
  Route::post('/updateCategorie', 'CategorieController@updateCategorie')->name('updateCategorie');
  Route::post('/deleteCategorie', 'CategorieController@deleteCategorie')->name('deleteCategorie');

  Route::post('/addArticle', 'ArticleController@addArticle')->name('addArticle');
  Route::post('/updateArticle', 'ArticleController@updateArticle')->name('updateArticle');
  Route::post('/deleteArticle', 'ArticleController@deleteArticle')->name('deleteArticle');



});


Route::get('/error',function(){
  return view('user.error');
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
