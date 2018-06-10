<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class JavascriptController extends Controller
{
  public function index(){
    return 'fuciones js';
  }

	public function funciones(Request $request){
      $response  = [];//datos que se devuelven a la vista
      switch ($request->op) {//controlador de la operacion que se va a realizar
        /*----------------------------JS:ACTIVIDAD----------------------------*/
        case 'show_info_user':
          $user = DB::table('users')->where('id',$request->user_id)->get();
          $oficina = DB::table('oficinas')->where('id', $user[0]->oficina_id)->get();
          $actividades_total = DB::table('responsables')->where('user_id',$request->user_id)->get();
          $metas_total = DB::table('meta_responsable')->join('responsables','meta_responsable.responsable_id','=','responsables.id')->where("user_id",$request->user_id)->get();
          $response = [
            'user'=>$user[0],
            'oficina'=>$oficina[0],
            'actividades'=>['total'=>count($actividades_total)],
            'metas'=>['total'=>count($metas_total)],
            'puntaje'=>['total'=>56]
          ];
          break;
        /*----------------------------JS:ACTIVIDAD----------------------------*/
        case 'consultar_oficinas_por_nombre':
          $response = DB::table('oficinas')
                      ->whereNull('deleted_at')
                      ->where('nombre', 'like', '%'.$request->nombre.'%')->get();
          break;

        case 'consultar_like_responsables':
          $response = DB::table('responsables')
                      ->where('actividad_id', $request->actividad_id)
                      ->whereNull('responsables.deleted_at')
                      ->join('users', 'users.id', '=', 'responsables.user_id')
                      ->select('users.*', 'responsables.deleted_at')
                      ->where('nombres', 'like', '%'.$request->nombre.'%')->get();
          break;

        case 'search_usuario_by_nombre':
            if($request->oficina_id>0){
              $response = \App\User::search1($request->wordSearch)
                            ->where('oficina_id', $request->oficina_id)
                            ->orderBy('paterno')->orderBy('materno')->orderBy('nombres')
                            ->get();
            }else{
              $response = \App\User::search1($request->wordSearch)
                            ->orderBy('paterno')->orderBy('materno')->orderBy('nombres')
                            ->get();
            }
            break;
        /*--------------------------jS:users-------------------------------------*/
        case 'oficina_disponible':
            $response = \App\User::where('oficina_id', '=', $request->oficina_id)
            ->where('jefe',1)
            ->get();
            break;

        default:
          break;
      }
      return $response;
  	}
}
