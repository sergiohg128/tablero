<?php

namespace App\Http\Controllers;

use App\Meta;
use App\Monitoreo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\MonitoreoRequest;

use Auth;

class MonitoreoController extends Controller
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
     * Redirect to Actividades/index.
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
		$meta = Meta::findOrFail($id);
		
		if($meta->actividad->monitor_id == Auth::user()->id)
		{
			$hoy = Carbon::now()->format('d-m-Y');
			return view('monitoreos.index', compact('meta', 'hoy'));
		}
		
		return redirect()->route('actividades.index');
    }

    public function store(MonitoreoRequest $request)
    {
		$request->fecha = date("Y-m-d", strtotime($request->fecha));
		
        $monitoreo = Monitoreo::create($request->all());

        return redirect()->route('monitoreo.create', $monitoreo->meta->id)
            ->with('info', 'Registro de monitoreo creado con éxito');
    }

    public function show($id)
    {
        //
    }

    public function edit($meta_id, $id)
    {
		$meta = Meta::findOrFail($meta_id);
        $monitoreo = Monitoreo::findOrFail($id);

		if ($monitoreo->meta->id != $meta->id) 
		{
			return redirect()->route('metas.show', $meta->id);
		}
		
		if($meta->actividad->monitor_id == Auth::user()->id)
		{
			return view('monitoreos.index', compact('monitoreo', 'meta'));
		}
		
		return redirect()->route('actividades.index');
    }

    public function update(MonitoreoRequest $request, $id)
    {
		$monitoreo = Monitoreo::find($id);
		
		$request->fecha = date("Y-m-d", strtotime($request->fecha));
		
        $monitoreo->fill($request->all())->save();

        return redirect()->route('monitoreo.create', $monitoreo->meta->id)
            ->with('info', 'Registro de monitoreo actualizado con éxito');

    }

    public function destroy($id)
    {
		
		$registro = Monitoreo::findOrFail($id);
		
		if($registro->meta->actividad->monitor_id == Auth::user()->id)
		{
			$registro->delete();
			return back()->with('info-delete', 'Eliminado correctamente');
		}

		return redirect()->route('actividades.index');
    }
}
