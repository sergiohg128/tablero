<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GastoRequest;

use App\Gasto;
use App\Meta;
use App\Tipo_documento;

use Auth;

class GastoController extends Controller
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
		$meta = Meta::findOrFail($id);
		$documentos = Tipo_documento::orderBy('id', 'ASC')->pluck('nombre', 'id');

		foreach ($meta->responsables as $responsable) {
			$usuario = $responsable->user;
			if($usuario->id == Auth::user()->id)
			{
				return view('gastos.index', compact('meta', 'documentos'));
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
    public function store(GastoRequest $request)
    {
		$request->fecha = date("Y-m-d", strtotime($request->fecha));

		$gasto = Gasto::create($request->all());

		return redirect()->route('gastos.create', $gasto->meta->id)
						->with('info', 'Gasto creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($meta_id, $id)
    {
		$meta = Meta::findOrFail($meta_id);
        $gasto = Gasto::findOrFail($id);
		$documentos = Tipo_documento::orderBy('id', 'ASC')->pluck('nombre', 'id');

		if ($gasto->meta->id != $meta->id) {
			return redirect()->route('metas.show', $meta->id);
		}

		foreach ($meta->responsables as $responsable) {
			$usuario = $responsable->user;
			if($usuario->id == Auth::user()->id)
			{
				return view('gastos.index', compact('gasto', 'meta', 'documentos'));
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
    public function update(Request $request, $id)
    {
		$gasto = Gasto::find($id);

		$request->fecha = date("Y-m-d", strtotime($request->fecha));

		$gasto->fill($request->all())->save();

		return redirect()->route('gastos.create', $gasto->meta->id)
    					->with('info', 'Gasto actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		$gasto = Gasto::findOrFail($id);
		
		foreach ($gasto->meta->responsables as $responsable) {
			$usuario = $responsable->user;
			if($usuario->id == Auth::user()->id)
			{
				$gasto->delete();
				return back()->with('info-delete', 'Eliminado correctamente');
			}
		}

		return redirect()->route('actividades.index');
    }
}