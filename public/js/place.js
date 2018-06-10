$(document).ready(function(){
    listar_busqueda("");
    $("#buscar").keypress(function(e){
        if(e.which==13){//enter
            listar_busqueda($("#buscar").val());
        }
    });
    
    $("#btn_clear").click(function(){
        $("#buscar").val("");
        listar_busqueda("");
    });
    $("#btn_buscar").click(function(){
        listar_busqueda($("#buscar").val());
    });
    
    $("#btn_nuevo").click(function(){
        location.href = "place_edit.php";
    });
    
});
            
function saludar(){
    alert("hola mundo");
}
function mensaje(txt){
    $("#mensaje").html(txt);
}

function eliminar(id_place){
    eliminar_place_all(id_place,function (data){
        listar_busqueda("");
    });
}

function eliminar_place_all(id_place,callback){
    var parametros = {
        op:'eliminar_place_all', 
        id_place:id_place
    };
    var ruta = "../controller/place_ctrl.php";
    $.ajax({
         url: ruta,
         type: "POST",
         data: parametros,
         success: function (data) {
            callback(data);
         }
    });
}

function editar(){
    $.post("../controller/place_ctrl.php",{op:'eliminar'}, function(data){
        var lista = JSON.parse(data);
        show_lista_places(lista);
    }).error(function(){
        alert("Error con el controlador");
    });
}



function listar_busqueda(nombre){
    $.post("../controller/place_ctrl.php",{op:'listar_busqueda', nombre:nombre}, function(data){
        var lista = JSON.parse(data);
        show_lista_places(lista);
    }).error(function(){
        alert("Error con el controlador");
    });
}

function show_lista_places(lista){
    var text = "";
    for(var i in lista){
        text += "<tr>";
            text += "<td>"+(parseInt(i)+1)+"</td>";
            text += "<td>"+lista[i].nombre+"</td>";
            text += "<td>"+lista[i].distrito+"</td>";
            text += "<td>"+lista[i].provincia+"</td>";
            text += "<td>"+lista[i].departamento+"</td>";
            text += "<td>";
                text += "<a href='place_edit.php?pag_mode=editar&id="+lista[i].id+"' class='btn btn-sm btn-secondary'><span class='icon-pencil'></span></a>";
            text += "</td>";
            text += "<td>";
                text += '<a href="javascript: eliminar('+lista[i].id+')" class="btn btn-sm btn-secondary" ><span class="icon-bin"></span></a>';
            text += "</td>";
        text += "</tr>";
    }
    $('#lista').html(text);
}

