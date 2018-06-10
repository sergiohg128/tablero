@extends('layouts.dashPanel')

@section('content')
  {{ Form::open(['url'=>['monitoreos/admin'], 'method'=>'POST']) }}
    {{ Form::hidden('meta_id', 48) }}
    <button type="submit" name="button">Monitoreo meta 48</button>
  {{ Form::close()}}
@stop

@section('scripts')

@stop
