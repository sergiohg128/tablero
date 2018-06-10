var responsables = [];

$(document).ready(function(){
    if($("#id").val()!=0){//solo en modo update
      cargar_responsables();
    }

    $('input:checkbox[name=responsables]').change(function(){
      selecionar_responsables($(this).val());
    });
    
    $('#search_word').keyup(function(){
      buscarResponsable();
    });

    $('#search_type').change(function(){
      $("#search_word").val('');
      buscarResponsable();
    });

});

function cargar_responsables(){

  var id = $("#id").val();
  var data = {id};
  var token = $("input[name=_token]").val();
  myPost('../cargarResponsables', token, data, function(response, state){
    if(state=='ok'){
      console.log(response);
      for(var i in response){
        response[i]['type'] = $("#search_type").val();
        verificarResponsable(response[i]);
      }

      ver_seleccionados();
      buscarResponsable();
    }
  });
}

//verificar si el usuario no esta en la lista de responsables
function selecionar_responsables(id){

  if(responsables.length===0){//agreagar por primera vez
    getResponsableDB(id);
  }else{
    var selected = false;
    for(i=0; i<responsables.length; i++){
      if(responsables[i].id==id && responsables[i].type==$("#search_type").val()){
        selected = true;
        break;
      }
    }
    if(!selected){//agregar al array
      getResponsableDB(id);
    }else{//eliminar del array desde checkbox, el tipo se saca de la select: search_type
      //auque el cbx se desecciona automaticamente cuando se actua sobre el mismo la funcion de desmarcar=eliminar
      borrar_responsable(id, $("#search_type").val());
    }
  }
  //console.log(responsables);
}

function quitar_de_lista(id, type){
  for(i=0; i<responsables.length; i++){
    if(responsables[i].id==id && responsables[i].type==type){
      responsables.splice(i,1);
      ver_seleccionados();
      break;
    }
  }
}

function desmarcarCbx(id, type){
  if($("#search_type").val()==type){
    $("#cbx_search_"+id).prop('checked', false);
  }
}

function ver_seleccionados(){
  var num = 0;
  var html = '';
  var tipo = '';//oficina o usuario
  for(i=0; i<responsables.length; i++){
    num++;
    html += '<tr>';
      //html += '<td>'+num+'</td>';
      html += '<td>'+responsables[i].id+'</td>';
      html += '<td>'+responsables[i].nombre+'</td>';
      html += '<td>'+responsables[i].type+'</td>';
      html += '<td><a href="javascript: borrar_responsable('+responsables[i].id+',\''+responsables[i].type+'\')" class="btn btn-sm btn-info">Borrar</<></td>';
    html += '</tr>';
  }
  $("#responsables_selected").html(html);
}

function getResponsableDB(id){
  var type = $("#search_type").val();
  var data = {id, type};
  var token = $("input[name=_token]").val();
  var ruta  = $("#id").val()==0?'responsableSelected':'../responsableSelected';
  myPost(ruta, token, data, function(response, state){
    if(state=='ok'){
      response['type']=$("#search_type").val();//agregamos un atributo para saber si es oficina o usuario

      //f: verificar si el usuario esta incluido en una oficina ya seleccionada
      // o verificar si la oficina incluye a usuarios ya seleccionados
      verificarResponsable(response)
      //responsables.push(response);

      ver_seleccionados();
    }
  });
}

function agregarResponsableHTMl(id, type){
  var idCode = type+id;
  if(type=='u'){
    var nuevo = '<input type="text" name="usuarios[]" value="'+id+'" id="'+idCode+'">';
  }else if(type=='o'){
    var nuevo = '<input type="text" name="oficinas[]" value="'+id+'" id="'+idCode+'">';
  }

  var html = $("#div_asignados").html()+nuevo;
  $("#div_asignados").html(html);

  var x = $("input[name=asigandos]");
  console.log(x);
}

function verificarResponsable(response){//agrega oficinas/usuario al array responsables

  if(response.type=='u'){
    /*verificar si el usuario esta incluido en una oficina ya seleccionada
     de ser el caso ya no se agregara el usuario*/

    var incluido = false;
    for(var i in responsables){
      if(responsables[i].type=='o' && responsables[i].id==response.oficina_id){
        var msn = "Mensaje: La oficina "+responsables[i].nombre+" ya incluye a este usuario";
        alert(msn);
        incluido = true;
      }
    }
    if(!incluido){
      responsables.push(response);
        agregarResponsableHTMl(response.id, response.type);
    }else{
        desmarcarCbx(response.id, response.type);
    }
  }else{
    /*verificar si la oficina incluye a usuarios ya seleccionados
    de ser el caso eliminar todos estos usuarios y agregar solo la oficina*/

    var incluidos = [];

    //obtener el usuarios incluidos en la oficina seleccionada
    for(var i in responsables){
      if(responsables[i].type == 'u' && responsables[i].oficina_id == response.id){
        incluidos.push(responsables[i]);
      }
    }

    if(incluidos.length>0){//mostrar mensaje
      var msn = "Esta oficina incluye a: ";
      for(var i in incluidos){
        msn += incluidos[i].nombre + " ,"
      }
      msn = msn.substring(0, msn.length - 1);
      alert(msn);
    }

    //eliminar los usuarios que esta oficina incluye
    for(var i in incluidos){
      borrar_responsable(incluidos[i].id, incluidos[i].type);
    }
    responsables.push(response);
    agregarResponsableHTMl(response.id, response.type);
  }
}

function borrar_responsable(id, type){
  //quitar de la lista responsables
  quitar_de_lista(id, type);
  //quitar seleccion checkbox en la busqueda: verificar si la busqueda esta en modo: oficina/usuarios
  desmarcarCbx(id, type);

  inputDestroy(id, type);
}

function inputDestroy(id, type){//eliminar la etiqueta hidden con nombre = usuario[]/oficina[] e id=(type+id)
  var idCode = type+id;
  $("#"+idCode).remove();
}

function buscarResponsable(){
  var word = $("#search_word").val();
  var type = $("#search_type").val();
  var data = {word, type};
  var token = $("input[name=_token]").val();
  var ruta  = $("#id").val()==0?'buscarResponsable':'../buscarResponsable';
  myPost(ruta, token, data, function(response, state){
    if(state=='ok'){
      console.log(response);
      var html = '';
      for(var i in response){
        marcado = marcar_busqueda(response[i].id);//adiciona atributo checked
        html += '<tr>';
          html += '<td>'+response[i].id+'</td>';
          html += '<td>'+response[i].nombre+'</td>';
          html += '<td><input onclick="selecionar_responsables('+response[i].id+')" type="checkbox" id="cbx_search_'+response[i].id+'" name="responsables" '+marcado+'></td>'
        html += '</tr>';
      }
      $("#search_results").html(html);
      html
    }
  });
}
//verifica si un elmento de la lista de busqueda ya a sido seleccionado como responsable
function marcar_busqueda(id){
  for(var i in responsables){
    if(responsables[i].id==id && responsables[i].type==$("#search_type").val()){
    //if(responsables[i].id==id){
      return 'checked';
    }
  }
  return null;
}

function checkOficina(oficina_id){
  var token = $("input[name=_token]").val();
  var page = $("input[name=page]").val();
  var data = {oficina_id, oficina_id};

  var url = page=='create'?'checkOficina':'../checkOficina';
  myPost(url, token, data, function(response, state){
    if(state=='ok'){
      if(response.length == 0){
        $("input[name=jefe]").prop('disabled', false);
        $("input[name=jefe]").prop('checked', false);

      }else{
          $("input[name=jefe]").prop('disabled', true);
          $("input[name=jefe]").prop('checked', true);
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
