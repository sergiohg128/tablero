<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Documento;

class DocumentoController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('is_admin');
	}

    public function index()
    {
        return redirect('documentos/create');
    }

    public function create()
    {

        $documentos = Documento::all();
        return view('documentos.index', [
          'documentos'=>$documentos
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
          'nombre'=>'required'
        ];

        $messages = [
          'nombre.required'=>'Nombre de meta requerido'
        ];

        $this->validate($request, $rules, $messages);

        $documento = new Documento;
        $documento->nombre = $request->nombre;
        $documento->save();
        return redirect('documentos');
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $documentos = Documento::all();
        $documento = Documento::findOrFail($id);
        return view('documentos.index', [
          'documentos'=>$documentos,
          'documento'=>$documento
        ]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
          'nombre'=>'required'
        ];

        $messages = [
          'nombre.required'=>'Ingrese un nombre de documento'
        ];

        $this->validate($request, $rules, $messages);

        $documento = Documento::findOrFail($id);
        $documento->nombre = $request->nombre;
        $documento->save();
        return redirect('documentos');
    }

    public function destroy($id)
    {
        $documento = Documento::findOrFail($id);
        $documento->delete();
        return redirect('documentos');
    }
}
