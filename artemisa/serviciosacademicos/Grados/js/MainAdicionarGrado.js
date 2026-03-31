$(function(){

    $(".numero").numeric(); 
    $( "#btnAdicionarGrado" ).button({ label: "Registrar" });
    $( "#btnRestaurarAGrado" ).button({ label: "Restaurar" });
    $( "#btnConsultarEstudiante" ).button({ label: "Buscar" });


    $("#cmbCarreraDistancia").change(function(){
        
        $("#codigoEstudiante").val( "" );
        $("#numeroDocumento").val( "" );
        $( "#nombre").val( "" );
        $("#cmbPeriodoDistancia").trigger("change");
        
    });

    $(".fechagrado").change(function(){
          var idCarrera = $("#cmbCarreraDistancia").val(); 
          var idPeriodo = $("#cmbPeriodoDistancia").val();
          var idTipoGrado = $("#cmbTipoGradoDistancia").val();
          var tipoOperacion = "fechagradocarrera";

          if(idPeriodo != "-1" && idTipoGrado !="-1" ){

             $.ajax({
                    url: "../servicio/fechaGrado.php",
                    type: "POST",
                    data: { tipoOperacion : tipoOperacion , idPeriodo : idPeriodo , idTipoGrado:idTipoGrado ,idCarrera:idCarrera},
                    success: function( data ){
                            $( "#cmbFechaGradoDistancia").html( data );
                    }
            });
          }      
    });

    $("#btnConsultarEstudiante").click(function(){
        
        var documento =$("#numeroDocumento").val();
        var idCarrera = $("#cmbCarreraDistancia").val();
        var tipoOperacion = "estudianteCarrera";
       
        if(idCarrera=="-1"){
               alert("Seleccione una carrera");
        
        }else{
            $.ajax({
                    url: "../servicio/estudiante.php",
                    type: "POST",
                    dataType:"json",
                    data: { tipoOperacion : tipoOperacion , documento : documento ,idCarrera:idCarrera },
                    success: function( data ){
                        if(data["codigo"]== null){
                           alert("No se encontraron datos en la busqueda , verifique la informacion");
                        }                        
                        else if(data["registro"]!= null){

                                alert("El estudiante ya  tiene registro de grado");
                                $( "#nombre").val( "");
                                $("#codigoEstudiante").val("");
                                $("#numeroDocumento").val("");


                        }else{
                            $( "#nombre").val( data["nombre"] );
                            $("#codigoEstudiante").val( data["codigo"]  )

                        }
                    }
            });  
        }
    });


    $("#btnAdicionarGrado").click(function(){
            var datos = $( "#adicionarGrado" ).serialize( );
            var camposVacios = validarFormulario( datos ); 
            if( camposVacios == "" ){
                var tipoOperacion ="registrarGradoDistancia"
                $.ajax({
                    url: "../servicio/registrarGrado.php",
                    type: "POST",
                    data: $( "#adicionarGrado" ).serialize( ) + "&tipoOperacion="+tipoOperacion,
                    success: function( data ){
                        if(data==1){
                            alert("Se ha registrado el estudiante")
                        }else{
                            alert("Ha ocurrido un error");
                        }
                        
                        $("#adicionarGrado").reset( );
                        
                    }

                });

            }else{
                crearMensaje( camposVacios );
            }

    });  

    $( "#btnRestaurarAGrado" ).button( ).click(function() {
            $("#adicionarGrado").reset( );
    });


    var dates = $( "#fechaAcuerdoCF, #fechaAcuerdo" ).datepicker({
            defaultDate: "0w",
            changeMonth: true,
            numberOfMonths: 2,
            changeYear: true,
            dateFormat : 'yy-mm-dd',
            onSelect: function( selectedDate ) {

                            instance = $( this ).data( "datepicker" ),
                            date = $.datepicker.parseDate(
                                    instance.settings.dateFormat ||
                                    $.datepicker._defaults.dateFormat,
                                    selectedDate, instance.settings );

            }
    },$.datepicker.regional["es"]);

});