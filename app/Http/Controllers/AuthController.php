<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Redirect;

class AuthController extends Controller
{

    public function index(){
      if(Auth::check()){
        return redirect('/actividades');
      }
      return view('usuarios.login');

    }
    public function login(Request $request){
    //   $credenciales = $this->validate($request, [
    //       'cuenta'=>'required|string',
    //       'password'=>'required|strings'
    //   ]);

      if(Auth::attempt(['cuenta' => $request->cuenta, 'password' => $cuenta->password])){
        return redirect('/actividades');
      }
      return redirect('login')->with('login_error', 'Tus datos son incorrectos');
    }

    public function logout(){
      Auth::logout();
      return Redirect::to('login')->with('logout_msn', 'Tu session a sido cerrada');
    }
}
