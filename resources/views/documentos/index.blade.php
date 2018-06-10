@extends('layouts.dashPanel')

@section('content')

<div class="row">
  <div class="col col-sm-12 col-md-4">
    @include('partials.myMessage')
    @if(isset($documento))
      @include('documentos.edit')
    @else
      @include('documentos.create')
    @endif
  </div>

  <div class="col col-sm-12 col-md-8">
    <div class="table-responsive">
      <table class="table table-hover table-sm ">
        <thead>
          <tr>
            <th>N°</th>
            <th>Descripcion</th>
            <th>
              <div class="d-flex flex-row-reverse">
                <div class="form-inline">
                  {{ Link_to('documentos', 'Nuevo', ['class'=>'btn btn-sm btn-danger'])}}
                </div>
              </div>


            </th>
          </tr>
        </thead>
        <tbody>
          <?php $num=0; ?>
          @foreach($documentos as $key => $documento)
          <?php $num++; ?>
          <tr>
            <td>{{$num}}</td>
            <td>{{$documento->nombre}}</td>
            <td>
              <div class="d-flex flex-row-reverse">
                <div class="form-inline ">
                  {{ link_to_action('DocumentoController@edit', 'Editar', $documento->id, ['class'=>'btn btn-sm btn-success mr-1']) }}

                  {{ Form::open(['action'=>['DocumentoController@destroy', $documento->id], 'method'=>'DELETE']) }}
                    {{ Form::submit('Borrar', ['class'=>'btn btn-sm btn-secondary']) }}
                  {{ Form::close()}}
                </div>
              </div>

            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

  </div>
</div>


@stop
