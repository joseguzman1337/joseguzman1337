    /*
        * @create Luis Dario Gualteros <castroluisd@unbosque.edu.co>
        * Se crea el reporte de curso Básico para listar matriculados a curso básico que posteriomente se matricularon en programas de Pregrado.
        * @since Septiembre 4 de 2018.
    */
        function periodo() {
              $.ajax({
                  type: 'POST',
                  url: 'funciones/funciones.php',
                  dataType: "html",
                  data: {action: "Periodo"},
                  success: function (data) {
                      $('#periodo').html(data);
                  },
                  error: function (data, error)
                  {
                   alert("Error en la consulta de los datos.");
                  }
              });
        }//funtion periodo

        function consultar() {
            var periodoc = $('#periodo').val(); 
            $('#flag_consulta').val('1'); 

                    if(periodoc){
                            $.ajax({
                                   dataType: 'json',
                                   type: 'POST',
                                   url: 'funciones/funciones.php',
                                   dataType: "html",
                                   data:{periodoc:periodoc, action:"ConsultarMatriculadosCursoBasico"},   
                                   beforeSend: function() {   
                                           $('#procesando').attr("style", "display:inline");   
                                           $('#tabla').attr("style", "display:none");
                                   },
                                   success:function(data){                      
                                           $('#procesando').attr("style", "display:none");
                                           $('#dataReporte').html(data);
                                           $('#tabla').attr("style", "display:inline");
                                            $('#tablapre').attr("style", "display:none");
                                           $('#exportarbtn').attr("style", "display:inline");
                                          
                                   },
                                   error: function(data,error)
                                   {
                                           alert("Error en la consulta de los datos.");
                                   }
                           });
            }else
            {
                            alert("Debe Seleccionar un Periodo.");
            } 
        }//funtion consultar

        function consultarPregrado() {
            var periodoc = $('#periodo').val(); 
            $('#flag_consulta').val('2');
                    if(periodoc){
                            $.ajax({
                                   dataType: 'json',
                                   type: 'POST',
                                   url: 'funciones/funciones.php',
                                   dataType: "html",
                                   data:{periodoc:periodoc, action:"ConsultarMatriculadosPregrado"},   
                                   beforeSend: function() {   
                                           $('#procesando').attr("style", "display:inline");   
                                           $('#tabla').attr("style", "display:none");
                                           $('#tablapre').attr("style", "display:none");
                                   },
                                   success:function(data){                      
                                           $('#procesando').attr("style", "display:none");
                                           $('#dataReportepre').html(data);
                                           $('#tabla').attr("style", "display:none");
                                           $('#tablapre').attr("style", "display:inline");
                                           $('#exportarbtn').attr("style", "display:inline");
                                          
                                           
                                   },
                                   error: function(data,error)
                                   {
                                           alert("Error en la consulta de los datos.");
                                   }
                           });
            }else
            {
                            alert("Debe Seleccionar un Periodo.");
            } 
        }//funtion consultarPregrado
  
window.onload = periodo();  