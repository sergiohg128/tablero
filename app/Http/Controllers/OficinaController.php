<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OficinaRequest;
use App\Oficina;


class OficinaController extends Controller
{
    public function __construct(){
      $this->middleware('auth');
      $this->middleware('is_admin');
    }

    public function index()
    {
        return redirect('oficinas/create');
    }

    public function create(Request $request)
    {
        $oficinas = Oficina::search($request->get('search'))->orderBy('id')->paginate(20);
        return view('oficinas.index', compact('oficinas'));
    }

    public function store(OficinaRequest $request)
    {
        Oficina::create($request->all());
        return redirect('oficinas');
    }

    public function show($id)
    {
        //
    }

    public function edit(Request $request, $id)
    {
      $oficina = Oficina::findOrFail($id);
      $oficinas = Oficina::search($request->get('search'))->orderBy('id')->paginate(20);
      return view('oficinas.index', compact('oficinas', 'oficina'));
    }

    public function update(OficinaRequest $request, $id)
    {
      $oficina = Oficina::findOrFail($id);
      $oficina->update($request->all());
      return redirect('oficinas');
    }

    public function destroy($id)
    {
        $oficina = Oficina::findOrFail($id);
        $oficina->delete();
        return redirect('oficinas');
    }

}
