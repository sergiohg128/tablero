$(document).ready(function(){
    checkOficina($("select[name=oficina_id]").val());
    /*
    $("select[name=oficina_id]").change(function(){
      checkOficina($(this).val());
    });

    $("#btn-create").click(function(){
      create();
    });
    */

});

function checkOficina(oficina_id){
  $.ajax({
    url: 'checkOficina/'+oficina_id,
    type: 'GET',
    success: function(response){
      console.log(response);
    }
  });
}

//habilita o desabilita chekbox 'Jefe'
function enableJefe(id_oficina){
  var token = $("input[name=_token]").val();

  $.ajax({
    url: "funciones",
    headers: {'X-CSRF-TOKEN': token},
    data: {id_oficina: id_oficina},
    type: 'POST',
    success: function(data){
      //var lista = JSON.parse(data);
      //console.log(data.length);
      if(data.length == 0){
        $("input[name=jefe]").prop('disabled', false);
        $("input[name=jefe]").prop('checked', false);

      }else{
        $("input[name=jefe]").prop('disabled', true);
        $("input[name=jefe]").prop('checked', false);
      }
    }
  });
}

function create(){
  if(validarCampos()=='ok'){
    var token = $("input[name=_token]").val();
    var datos = {
      nombre: $("#nombre").val(),
      paterno: $("#paterno").val(),
      materno: $("#materno").val(),
      cuenta: $("#cuenta").val(),
      clave: $("#clave").val(),
      id_oficina: $("#id_oficina").val(),
      jefe: $("#jefe").prop('checked')?true:false
    }
    //var datos = $("#form-create").serialize();
    $.ajax({
      url: "create",
      headers: {'X-CSRF-TOKEN': token},
      dataType: 'json',
      data: datos,
      type: 'POST',
      success: function(data){
        windows.location='http://www.google.com';
      }
    });
  }else{
    alert(validarCampos());
  }
}

function validarCampos(){
  if($("#nombre").val()!=""){
    if($("#paterno").val()!=""){
      if($("#materno").val()!=""){
        if($("#usuario").val()!=""){
          if($("#clave").val()!=""){
            if($("#id_oficina").val()!=0){
              return 'ok';
            }else{
              return "Seleccione una oficina";
            }
          }else{
            return "El campo clave esta vacio";
          }
        }else{
          return "El campo usuario esta vacio";
        }
      }else{
        return "El campo apellido materno esta vacio";
      }
    }else{
      return "El campo apellido paterno esta vacio";
    }
  }else{
    return "El campo nombre esta vacio";
  }
}
