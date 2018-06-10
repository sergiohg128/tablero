@extends('layouts.perfil')

@section('content2')
<?php
  $creaciones = \App\User::findOrFail(Auth::user()->id)->actividades;
  $totalCreaciones = $creaciones->count();
  $finalizadas = 0;
  if($totalCreaciones!=0){
    foreach ($creaciones as $key => $actividad) {
      $metas = count($actividad->metas) ;
      $metasCumplidas = count($actividad->metas->where('estado', 'F'));
      if($metas !=0  && $metas==$metasCumplidas){
        $finalizadas++;
      }
    }
    $porcentaje = round(($finalizadas/$totalCreaciones)*100).'%';
  }else{
    $porcentaje = 0;
  }

  $porcentaje  = $porcentaje.'%';

?>
@endsection

@section('script')

@endsection
