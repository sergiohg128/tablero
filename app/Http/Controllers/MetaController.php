<?php

namespace App\Http\Controllers;

use App\Actividad;
use App\Http\Requests\MetaResponsablesRequest;
use App\Http\Requests\MetaStoreRequest;
use App\Http\Requests\MetaUpdateRequest;
use App\Meta;
use App\Responsable;
use App\User;
use Auth;
use Illuminate\Http\Request;

class MetaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('actividades.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $actividad = Actividad::findOrFail($id);


        if(Auth::user()->tipo=='admin'){
          // Puede ver el admin
          return view('metas.index', compact('actividad'));
        }else{
            foreach ($actividad->responsables as $responsable) {
                $usuario = $responsable->user;
                if ($usuario->id == Auth::user()->id) {
                    return view('metas.index', compact('actividad'));
                }
            }
        }
            
        return redirect()->route('actividades.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MetaStoreRequest $request)
    {
		$request->fecha_inicio_esperada = date("Y-m-d", strtotime($request->fecha_inicio_esperada));
		$request->fecha_fin_esperada = date("Y-m-d", strtotime($request->fecha_fin_esperada));
        $datos = $request->all();

        $datos['creador_id'] = Auth::user()->id;

        $meta = Meta::create($datos);

        return redirect()->route('metas.create', $meta->actividad->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($actividad_id, $id)
    {
        $actividad = Actividad::findOrFail($actividad_id);
        $meta = Meta::findOrFail($id);

        if ($meta->actividad->id != $actividad->id) {
            return redirect()->route('actividades.show', $actividad->id);
        }

        if(Auth::user()->tipo=='admin'){
          // Puede ver el admin
          return view('metas.show', compact('meta', 'actividad'));
        }else{
            foreach ($actividad->responsables as $responsable) {
                $usuario = $responsable->user;
                if ($usuario->id == Auth::user()->id) {
                    return view('metas.show', compact('meta', 'actividad'));
                }
            }
        }
            

        return redirect()->route('actividades.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($actividad_id, $id)
    {
        $actividad = Actividad::findOrFail($actividad_id);
        $meta = Meta::findOrFail($id);

        if ($meta->actividad->id != $actividad->id) {
            return redirect()->route('actividades.show', $actividad->id);
        }


        if(Auth::user()->tipo=='admin'){
          // Puede ver el admin
          return view('metas.index', compact('meta', 'actividad'));
        }else{
            foreach ($actividad->responsables as $responsable) {
                $usuario = $responsable->user;
                if ($usuario->id == Auth::user()->id) {
                    $actividad = $meta->actividad;
                    return view('metas.index', compact('meta', 'actividad'));
                }
            }
        }

        return redirect()->route('actividades.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MetaUpdateRequest $request, $id)
    {
		if ($request->estado == 'P') {
			$request->fecha_fin = null;
            $request->fecha_inicio = null;
        }
        if ($request->estado == 'E') {
			$request->fecha_fin = null;
			$request->fecha_inicio = date("Y-m-d", strtotime($request->fecha_inicio));
		}
		
		$meta = Meta::find($id);
		if(isset($request->fecha_fin)) 
		{
			$request->fecha_inicio = $meta->fecha_inicio;
			$request->fecha_fin = date("Y-m-d", strtotime($request->fecha_fin));
		}

        $meta->fill($request->all())->save();

        return redirect()->route('metas.create', [$meta->actividad->id])
            ->with('info', 'Meta actualizada con éxito');
    }

    /**
     * Crear o Actualizar los responsables de cada meta.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function regResp(MetaResponsablesRequest $request, $id)
    {
        $meta = Meta::find($id);
        if ($meta->responsables()->get()->count() == 0) {
            $meta->responsables()->attach($request->get('responsables'));
        } else {
            $meta->responsables()->sync($request->get('responsables'));
        }

        return redirect()->route('metas.show', [$meta->actividad->id, $meta->id])
            ->with('info', 'Responsables de la meta actualizados con éxito');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $meta = Meta::findOrFail($id);

        if ($meta->creador_id == Auth::user()->id) {
            $meta->delete();
            return back()->with('info-delete', 'Eliminado correctamente');
        }

        return redirect()->route('actividades.index');

    }

    public function informacion($idactividad,$idmeta)
    {
        $meta = Meta::findOrFail($idmeta);
        $actividad = Actividad::find($meta->actividad_id);


        if(Auth::user()->tipo=='admin'){
          // Puede ver el admin
          return view('metas.informacion', compact('meta'));
        }else{
            foreach ($actividad->responsables as $responsable) {
                $usuario = $responsable->user;
                if ($usuario->id == Auth::user()->id) {
                    return view('metas.informacion', compact('meta'));
                }
            }
        }
            
        return redirect()->route('actividades.index');
    }

    public function informacioneditar(Request $request)
    {
        $informacion = $request->informacion;

        $meta = Meta::findOrfail($request->id);

        
        $meta->informacion = $informacion;
        $meta->save();
      
        return redirect('actividades/'.$meta->actividad->id.'/metas/'.$meta->id);
    }
}