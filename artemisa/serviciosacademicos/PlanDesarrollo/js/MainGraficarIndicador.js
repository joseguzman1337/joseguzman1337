/**
 * @author Ivan quintero <quinterorivan@unbosque.edu.co>
*/

$(document).ready(function()
{ 	
    $("#selectTipoReporte").change(function(){	            
       /*Modified Diego Rivera<riveradiego@unbosque.edu.co>
        *Se agraga validacion con el fin no visualizar menus cuando el valor seleccionado es cero
        *Since May 07,2018
        */
        
        if( $("#selectTipoReporte").val()== 0 ){
             $('#formularioConsultas').hide(); 						
             $('#reportefacultades').hide();
             $("#periodo").hide();
        }
        //fin validacion
        $.ajax({
                    url: "../servicio/consultar.php",
                    type: "POST",
                    data:{
                        selectTipoReporte : $(this).val(), 
                        tipoOperacion : "TipoReporte"
                    },
                    dataType: "json",
                    success: function( data ){           
                                     
                        if(data.success){
                                $("#SelectDatos").html("");
                                $("#formularioConsultas").show();
                                $("#SelectDatos").html(data.html);
                                 
                                if($("#selectTipoReporte").val() == 4 || $("#selectTipoReporte").val() == 5 ){
                                        $("#periodo").hide();
                                }else{
                                        $("#periodo").show();
                                }
                                $("#reportefacultades").hide();
                        }else{					
                                $('#formularioConsultas').hide(); 						
                                $('#reportefacultades').hide();
                                $("#periodo").hide();
                        }
                    }
            });		
	});
	
	$("#btnConsultarReporte").button().click(function(e) { 
            $("#reportefacultades").html( "" );
            $('#msj').html('<div style="margin-right:auto;margin-left:auto"><img src="../css/images/cargando.gif"/></div>');
            
            e.preventDefault();
            e.stopPropagation();
           
            $.ajax({
                    url: "../servicio/consultar.php",
                    type: "POST",
                    data: $( "#formConsultar" ).serialize( ),
                    success: function( data )
                     {   
                       var valor=$("#cmbFacultadConsultar option:selected").html();
                        $("#reportefacultades").html(data);
			$("#reportefacultades").show();
                        $("#plan").html('PLan de desarrollo:<br>'+valor);
                        $('#msj').html("");
		     }
	    });
	});

	$("#btnRegresar").on("click",function( ){
		volver( );
	});




});
