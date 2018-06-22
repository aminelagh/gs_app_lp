<?php

namespace App\Http\Controllers;

use \Exception;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Session;
use Sentinel;
use DB;
use Illuminate\Http\Request;
//use \App\Models\User;
use Cartalyst\Sentinel\Users\EloquentUser as User;

class AuthController extends Controller
{

  //login *****************************************************************************
  public function login(){
    try {
      DB::connection()->getPdo();
    } catch (Exception $e) {
      return view('login')->with('alert_danger',"Problème de connexion avec la base de données. Veuillez réessayer plus tard.");
    }
    if( Sentinel::check() ){
      return self::redirectToSpace();
    }
    else{
      return view('login');
    }
  }

  //Authentification ******************************************************************
  public function submitLogin(Request $request){
    try {
      $user = Sentinel::authenticate(Request()->all());
      if (Sentinel::check()) {
        Session::put('id_user', $user->id);
        Session::put('role', $this->getRole());
        Session::put('email', $user->email);
        Session::put('nom', $user->nom);
        Session::put('prenom', $user->prenom);
        //if( Sentinel::inRole('user') ){Session::put('role', 'user');}
        return $this->redirectToSpace();
      } else {
        return redirect()->back()->withInput()->with("alert_warning","<b>login et/ou mot de passe incorrect</b>");
      }
    } catch (ThrottlingException $e) {
      return redirect()->back()->withInput()->with("alert_danger", "<b>Une activité suspecte s'est produite sur votre adresse IP, l'accès vous est refusé pour " . $e->getDelay() . " seconde (s)</b>")->withTimerDanger($e->getDelay() * 1000);
    }
    catch (Exception $e) {
      return redirect()->route('login')->withInput()->with("alert_danger", "Erreur !<br>Code de l'erreur:  ".$e->getCode()." ");
    }
  }

  //Register *******************************************************************
  public function register(){
    try {
      DB::connection()->getPdo();
    } catch (Exception $e) {
      return view('register')->with('alert_danger',"Problème de connexion avec la base de données. Veuillez réessayer plus tard.");
    }
    if( Sentinel::check() ){
      return self::redirectToSpace();
    }
    else{
      return view('register');
    }
  }
  public function submitRegister(Request $request){
    //ajouter et activer le compte de l'utilisateur
    if($request->get('password') != $request->get('password2')){
      return redirect()->back()->withInput()->with('alert_warning',"Mot de passe incorrect");
    }
    try{
      $user = Sentinel::registerAndActivate($request->all());
    }catch(Exception $e){
      return redirect()->back()->with('alert_danger',"Erreur d'enregistrement. Message d'erreur: ".$e->getMessage()." ");
    }
    //chercher le role pour l'utilisateur
    $role = Sentinel::findRoleBySlug("user");
    //associer le role a l'utilisateur
    $role->users()->attach($user);
    return redirect()->back()->with('alert_success',"Enregistrement réussi");
  }

  //Deconnexion ***********************************************************************
  public function logout(){
    try{
      Sentinel::logout();
      Session::flush();
      return redirect('/');
    }
    catch (Exception $e) {
      return redirect()->back()->withInput()->with('alert_danger', "Erreur !<br>Message d'erreur:  ".$e->getMessage()."");
    }
  }

  //redirect to proper dashboard ******************************************************
  private static function redirectToSpace(){
    if( Sentinel::inRole('admin') ){
      return redirect()->route('admin');
    }elseif( Sentinel::inRole('user') ){
      return redirect()->route('accueil');
    }else{
      return redirect()->route('error')->with("alert_danger","Le rôle de l'utilisateur authentifié n'est pas répertorié, veuillez contacter l'administrateur de l'application.");
    }
  }

  //return role of the current users **************************************************
  public function getRole(){
    if (Sentinel::inRole('admin')){
      return "admin";
    }
    elseif(Sentinel::inRole('user')){
      return "user";
    }
  }
}
