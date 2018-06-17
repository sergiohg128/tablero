@extends('layouts.main')

@section('sidebar-page-manual', 'active')

@section('content')
<div class="row">
  <div class="col col-sm-12">
    <div class="box">
      <div class="box-header with-border">
        <div class="box-title">
          Manual
        </div>
        <div class="box-tools"></div>
      </div>
      <div class="box-body table-responsive">
        <iframe src="{{ url('manual.pdf') }}" width="100%" height="780" style="border: none;"></iframe>
      </div>

    </div>

  </div>
</div>
@endsection

@section('script')
  <script src="{{ url('js/comun.js') }}"></script>
@endsection
