$(document).ready(function(){
    if(typeof($("input[name=page]").val())!=='undefined'){//no es vista show

    }

    $("select[name=oficina_id]").change(function(){
      checkOficina($(this).val());
    });
});


function consultarController(){
  var token = $("input[name=_token]").val();

  $.ajax({
      url: 'usuarios.test',
      headers: {'X-CSRF-TOKEN': token},
      type: 'GET',
      data: null,
      success:function(data){
        console.log(data);
      },
      error: function(e){
        console.log('error en consulta ajax');
      }
  });
}

function checkOficina(oficina_id){
  var page = $("input[name=page]").val();
  var token = $("input[name=_token]").val();
  var data = {oficina_id, oficina_id};

  var url = page=='create'?'checkOficina':'../checkOficina';
  myPost(url, token, data, function(response, state){
    if(state=='ok'){
      if(response.length == 0){
        $("input[name=jefe]").prop('disabled', false);
        $("input[name=jefe]").prop('checked', false);

      }else{
          $("input[name=jefe]").prop('disabled', true);
          $("input[name=jefe]").prop('checked', false);
      }
    }
  });
}


function myPost(url, token, data, callback){
  $.ajax({
      url: url,
      headers: {'X-CSRF-TOKEN': token},
      type: 'post',
      data: data,
      success:function(data){
        return callback(data, 'ok');
      },
      error: function(e){
        return callback(e,'error' )
      }
  });
  return callback(null, 'none');
}
