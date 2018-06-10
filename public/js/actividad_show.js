$(document).ready(function(){
});


function show_info_user(user_id,){
	var baseUrl= document.getElementsByTagName('base')[0].href;
  var op = 'show_info_user';
  var data = {op, user_id};
  var url = baseUrl+'/javascript';
  
  myPost(url, data, function(response, state){
    if(state=='ok'){
        console.log(response);

        var user = response.user;
        var actividades = response.actividades;
        var metas = response.metas;
        var puntaje = response.puntaje;
				if(user.imagen==null){user.imagen = 'default.jpg';}
				$("#user-imagen").attr('src', baseUrl+'/images/profile/'+user.imagen);
        $("#user-fullname").html(user.nombres+" "+user.paterno+" "+user.materno);
        $("#user-puesto").html(user.jefe?'Jefe':'Usuario');
        $("#user-oficina").html(response.oficina.nombre);
        $("#user-actividades").html(actividades['total']);
        $("#user-metas").html(metas.total);
        //$("#user-puntaje").html(puntaje.total);
        $('#modalUserInfo').modal('show')

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
