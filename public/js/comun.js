
$(document).ready(function(){

  paginacion();

});

function paginacion(){
  pag = $("ul.pagination").attr('class', 'pagination pagination-sm no-margin pull-right');
  $("#mypag").attr('hidden', false);
//   console.log(pag);
}