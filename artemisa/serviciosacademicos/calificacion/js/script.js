window.totalItems = '';
window.coments = 1;
window.timesLoader=5000;
$(document).ready(function() {  
    totalItems = $(".contadorClicks").length;    
    setInterval(function() {managecoments();}, timesLoader);
});
$("#ok").bind("click", function(){
  $("#ok").hide();
  coments = 0;
  $("#coments").fadeIn(1300, "linear");
  timesLoader = 5000;
  //coments = 1;
});

function managecoments(){   
    if (coments==1)
        setTimeout(function(){clearcontent();},5000);
}
function setComment(){
    coments = 0;
    timesLoader = 7000;
}
function clearcontent(){    
    if(coments==1){
        $(".centrado").fadeIn(1300, "linear");
        $("#ok").hide();$("#coments").hide();
        $("#identificacion").val('');$("#comentario").val('');
    }
}
$("#guadarcomentario").bind("click", function(){
    coments = 1;
    alert('Gracias por su colaboración');
    var comentario = $("#comentario").val();
    var identificacion = $("#identificacion").val();
    var idcl_servicio = $("#idcl_servicio").val();
    var idevaluacion = $("#idevaluacion").val();
    clearcontent();
    var dataString = 'identificacion='+identificacion+'&idcl_servicio='+idcl_servicio+'&comentario='+comentario+'&idevaluacion='+idevaluacion;
    $.ajax({
        type: "POST",
        url: "go.php",
        data: dataString,
        success: function() {					           
              
        }	
    });    
});
$(".contadorClicks").bind("click", function(){
                if($("#identificacion").val()==''){
                    alert('Debe registrar primero su Número de Cédula o Historia Clínica , gracias.');
                    return '';
                }
		actualPage = this.id;      
		for(j=1; j<=totalItems; j++){
			if(actualPage == 'image'+j){
                        var identificacion = $("#identificacion").val();
                        var idcl_servicio = $("#idcl_servicio").val();
			var dataString = 'id='+j+'&identificacion='+identificacion+'&idcl_servicio='+idcl_servicio;
                        $(".centrado").hide();
                        $("#ok").fadeIn(1300, "linear");		
                        $.ajax({
                            type: "POST",
                            url: "go.php",
                            data: dataString,
                            success: function(data) {
                                coments = 1;
                                $("#idevaluacion").val(data);                                         
                            }
                        });
			};
		}
	} );		