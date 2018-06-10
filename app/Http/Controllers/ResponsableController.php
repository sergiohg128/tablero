<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Responsable;

class ResponsableController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //desactivar responsable
        $olds = \App\Actividad::findOrFail($request->actividad_id)->responsables;
        foreach ($olds as $key => $responsable) {
          $responsable->delete();
        }

        if(isset($request->usuarios)){
          foreach ($request->usuarios as $user_id) {
            $tmp = Responsable::where('actividad_id', $request->actividad_id)
                                ->withTrashed()->where('user_id', $user_id)
                                ->get()->last();
            if(empty($tmp)){
              $new = new Responsable;
              $new->user_id = $user_id;
              $new->actividad_id = $request->actividad_id;
              $new->save();
              //notificacion al usuario de que a sido agregado
              \App\Notificacion::toUserLikeResponsableAsignar($request->actividad_id, $new->user_id);
            }else{
              $tmp->restore();
              //notificaion al usuario de que a sido restaurado
              \App\Notificacion::toUserLikeResponsableReasignar($request->actividad_id, $tmp->user_id);
            }
          }
        }


        foreach ($olds as $key => $old) {
          $r = \App\Actividad::findOrFail($request->actividad_id)->responsables->where('user_id',$old->user_id);
          if(sizeof($r)==0){
            \App\Notificacion::toUserLikeResponsableDeleted($request->actividad_id, $old->user_id);
            // \App\Notificacion::toUser(\Auth::user()->id, $old->user_id, 'responsable', $request->actividad_id, 'eliminar');
          }
        }
        // return 'fin';
      return back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
