<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Indicador;
use App\Oficina;
use App\User;
use App\Actividad;
use App\Http\Requests\IndicadorRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Auth;

class IndicadorController extends Controller
{
    public function __construct(){
      $this->middleware('auth');
    }

    public function index(Request $request)
    {
      $indicadores = Indicador::search($request->get('search'))->orderBy('anio')->orderBy("nombre")->paginate(20);
      return view('indicadores.index', compact('indicadores'));
    }

    public function create()
    {
      $oficinas = Oficina::all();
      return view('indicadores.create', compact('oficinas'));
    }

    public function store(Request $request)
    {
      $this->validate($request, $this->rules, $this->messages);
      $datos = $request->all();
      $datos['creador_id'] = Auth::user()->id;
      $indicador = Indicador::create($datos);

      return redirect('indicadores');
    }

    public function show($id)
    {
        $indicador = Indicador::findOrFail($id);//datos del usuarios update
        $actividades = Actividad::where("indicador_id",$id)->orderBy("id")->get();
        return view('indicadores.show', compact('indicador','actividades'));
    }

    public function edit($id, Request $request)
    {
      $indicador = Indicador::findOrFail($id);//datos del usuarios update
      $oficinas = Oficina::all();
      return view('indicadores.edit', compact('indicador','oficinas'));
    }

    public function update(Request $request, $id)
    {
      $this->validate($request, $this->rules, $this->messages);

      $indicador = Indicador::find($request->id);
      $datos = $request->all();
      $indicador->update($datos);

      return redirect('indicadores');
    }

    public function destroy($id)
    {
        $indicador = Indicador::findOrFail($id);
        $indicador->delete();
        return redirect('indicadores');
    }

    public $rules = [
        'nombre' => 'required',
        'anio' => 'required|numeric|min:1900',
        'oficina_id' => 'required',
        'tipo'=>'required'
    ];

    public $messages = [
      'nombre.required'=>'Nombre requerido',
      'anio.required'=>'Año requerido',
      'anio.numeric'=>'Ingrese un número',
      'anio.min'=>'Ingrese un año correcto',
      'oficina_id.required' => 'Selecione una oficina',
      'tipo.required'=> 'Elija un tipo',
    ];

}
