var url_controller = "";
$(document).ready(function(){

  if($("#id").val()==0){
    url_controller = "meta_js";
  }else{
    url_controller = "../meta_js";//modo editar
  }

});


function show(meta_id){
  consultar_meta(meta_id);
}

function consultar_meta(meta_id){
  var op = 'consultar_meta';
  var token = $("input[name=_token]").val();
  var page = $("input[name=page]").val();
  var data = {op, meta_id};
  var url = '';
  myPost(url_controller, token, data, function(response, state){
    if(state=='ok'){
      var meta = response['meta'];
      var responsables = response['responsables'];

      var body = '';
      body += '<div class="row">';

        body += '<div class="col col-sm-12">';
          body += 'Meta';

          body += '<hr>Responables';
          console.log(responsables);
          for(var i in responsables){
            body += '<p>'+responsables[i].nombre+'</p>';
          }
        body += '</div>';

      body += '<div>';

      show_modal(response.nombre, body);
      //callback(state);
    }
  });
}

function show_modal(title, body){

  $("#modal-title").html(title);
  $('#modal-body').html(body);
  $('#windowsModal').modal('show');
}

function myPost(url, token, data, callback){
  $.ajax({
      url: url,
      headers: {'X-CSRF-TOKEN': token},
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
