var responsables = [];
var resultados = [];
var url_controller = ''
var baseUrl= '';
$(document).ready(function(){
    baseUrl= document.getElementsByTagName('base')[0].href;
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })

    url_controller = baseUrl+'/javascript';

    console.log(baseUrl);
    cargar_responsables(function(state){
      console.log('Responsables cargados!');
      search_usuario_by_nombre('');
    });




    $("#search_by_oficinas").change(function(){
      search_usuario_by_nombre();
    });

    $('#search_word').keyup(function(){
      search_usuario_by_nombre();
    });

});


function search_usuario_by_nombre(){
  var wordSearch = $("#search_word").val();
  var op = "search_usuario_by_nombre";
  var oficina_id = $("#search_by_oficinas").val();
  var data = {op, oficina_id, wordSearch};
  console.log('cargar usuarios de oficina');
  myPost(url_controller, data, function(response, state){
    if(state=='ok'){
      resultados = response;
      var html = '';
      var x=0;
      for(var i in resultados){
        x = x+1;
        html += '<tr>';
          html += '<td>'+x+'</td>';
          html += '<td>'+resultados[i].nombres+' '+resultados[i].paterno+' '+resultados[i].materno+'</td>';
          html += '<td class="text-right"><a href="javascript: seleccionar_uno('+resultados[i].id+')" "><span id="span_'+resultados[i].id+'" class="'+marcar_responsable(resultados[i])+'"></td>';
        html += '</tr>';
      }
      $("#search_results").html(html);
    }
  });
}

function marcar_responsable(usuario){
  for(var i in responsables){
    if(responsables[i].id===usuario.id){
      return "fa fa-check-square-o";
    }
  }
  return "fa fa-square-o";
}

function span_check(id){//marca
  var span = $("#span_"+id).attr('class','fa fa-check-square-o');;
}

function span_uncheck(id){//desmarca
  var span = $("#span_"+id).attr('class','fa fa-square-o');;
}

function seleccionar_varios(usuario_id){
  if($("#span_"+usuario_id).attr('class')=='fa fa-square-o'){
    for(var i in resultados){
      agregar_a_responsables(resultados[i]);
      span_check(resultados[i].id);
    }
    span_check(usuario_id);
  }else{
    for(var i in resultados){
      span_uncheck(resultados[i].id);
      quitar_de_responsables(resultados[i].id);
    }
    span_uncheck(usuario_id);
  }
  console.log(responsables);
}

function seleccionar_uno(usuario_id){
  if($("#span_"+usuario_id).attr('class')=='fa fa-square-o'){
    usuario = get_user(usuario_id);
    agregar_a_responsables(usuario);
    span_check(usuario_id);
  }else{
    quitar_de_responsables(usuario_id);
    span_uncheck(usuario_id)
  }
  console.log(responsables);
}

function ver_seleccionados(){//acutaliza la tabla visula de responsables
  var num = 0;
  var html = '';
  for(var i in responsables){
    num++;
    html += '<tr>';
      html += '<td><input size="1" readonly style="border-width:0; background-color: transparent" type="text" name="usuarios[]" value="'+responsables[i].id+'"></td>';
      html += '<td>'+responsables[i].nombres+' '+responsables[i].paterno+' '+responsables[i].materno+'</td>';
      html += '<td class="text-right"><a href="javascript: quitar_de_responsables('+responsables[i].id+')"><span class="fa fa-check-square-o"></span></td>';
    html += '</tr>';
  }
  $("#responsables_selected").html(html);
}

function agregar_a_responsables(usuario){
  //verificamos si aun no esta en la lista de responsable
  var agregado = false;
  for(var i in responsables){
    if(responsables[i].id==usuario.id){
      agregado = true;
      break;
    }
  }
  if(!agregado){
    responsables.push(usuario);
    ver_seleccionados();
  }

}

function quitar_de_responsables(usuario_id){
  for(i=0; i<responsables.length; i++){
    if(responsables[i].id==usuario_id){
      responsables.splice(i,1);
      span_uncheck(usuario_id);
      ver_seleccionados();
      break;
    }
  }
}

function cargar_responsables(callback){
  var nombre = '';
  var actividad_id = $('input[name=actividad_id]').val();
  var op = 'consultar_like_responsables';
  var data = {op, actividad_id, nombre};
  myPost(url_controller, data, function(response, state){
    if(state=='ok'){
      responsables = response;
      ver_seleccionados();
      callback(state);
    }

  });
}

function marcar_resultado(id){
  $("#result_"+id).attr("checked", true);
}

function get_user(id){
  for(var i in resultados){
    if(resultados[i].id==id){
      return resultados[i];
      break;
    }
  }
  return null;
}

function myPost(url, data, callback){
  $.ajax({
      url: url,
      headers: {'X-CSRF-TOKEN': $("input[name=_token]").val()},
      type: 'post',
      data: data,
      success:function(data){
        callback(data, 'ok');
      },
      error: function(e){
        callback(e,'error' )
      }
  });
  callback(null, 'none');
}
