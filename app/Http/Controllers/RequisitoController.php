<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Requisito;
use App\meta;

class RequisitoController extends Controller
{
    public function __construct(){
      $this->middleware('auth');
    }

    public function index()
    {
        //return redirect('requisitos/create');
    }

    public function create(Request $request, $meta_id)
    {
        $meta = Meta::findOrFail($meta_id);
        $requisitos = Requisito::search($request->get('search'))->where('meta_id', $meta->id)
                      ->orderBy('estado', 'asc')
                      ->paginate(5);
        return view('requisitos.index', compact('meta', 'requisitos'));
    }

    public function store(Request $request)
    {
        $request['estado']=0;
        Requisito::create($request->all());
        return redirect('metas/'.$request->meta_id.'/requisitos/create');
    }

    public function show($id)
    {
        //
    }

    public function edit(Request $request, $meta_id, $id)
    {
      $meta = Meta::find($meta_id);
      $requisitos = Requisito::search($request->get('search'))->where('meta_id', $meta->id)
                    ->orderBy('estado', 'asc')
                    ->paginate(5);
      $requisito = Requisito::findOrFail($id);
      return view('requisitos.index', compact('meta', 'requisitos', 'requisito'));
    }

    public function update(Request $request, $id)
    {
      $requisito = Requisito::findOrFail($id);
      if($request->estado ==1){//1: requisito completado
        $request['fecha_completado'] = \Carbon\Carbon::now();
      }
      $requisito->update($request->all());
      return redirect('metas/'.$request->meta_id.'/requisitos/create');
    }

    public function destroy($id)
    {
        $requisito = Requisito::findOrFail($id);
        $requisito->delete();
        return redirect('metas/'.$requisito->meta_id.'/requisitos/create');
    }
}
