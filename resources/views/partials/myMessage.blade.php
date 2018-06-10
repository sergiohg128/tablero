<div class="msn">
  @if(count($errors)>0)
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Mensaje!</strong>
    <ul>
      @foreach($errors->all() as $error)
        <li>{{$error}}</li>
      @endforeach
    </ul>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
</div>
