var url_base = '';
$(document).ready(function(){
  url_base = document.getElementsByTagName('base')[0].href;

  if($("#id").val()!=0){//modo edicion
    url_controller = url_base+'/javascript';
    oficina_disponible($('select[name=oficina_id]').val());
  }


  $("select[name=oficina_id]").change(function(){
      oficina_disponible($(this).val());
  });

});

function oficina_disponible(id){
  var oficina_id = id;
  var op = 'oficina_disponible';
  var data = {op, oficina_id};
  var url_controller = url_base+'/javascript';
  myPost(url_controller, data, function(response, state){
    if(state=='ok'){
      console.log(response);
      if(response.length==0){//oficina sin jefe
        $("input[name=jefe]").prop('disabled', false);
        $("input[name=jefe]").prop('checked', false);
      }else{//oficina con jefe
        //verificamos si el jefe de la oficina es el usuario en edicion
        if($("#id").val()==response[0].id){//Tu eres el jefe
          console.log('Tu eres el jefe de esta oficina');
          $("input[name=jefe]").prop('disabled', false);
          $("input[name=jefe]").prop('checked', true);
        }else{//Oficina ya tiene un jefe asignado
          $("input[name=jefe]").prop('disabled', true);
          $("input[name=jefe]").prop('checked', false);
        }
      }
    }
  });
}

function myPost(url, data, callback){
  $.ajax({
      url: url,
      headers: {'X-CSRF-TOKEN': $("input[name=_token]").val()},
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
