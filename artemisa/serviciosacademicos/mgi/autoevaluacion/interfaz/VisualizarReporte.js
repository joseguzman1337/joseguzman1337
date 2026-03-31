
 function BuscarData(){
           
           var Modalidad = $('#Modalidad').val();
            
            if(Modalidad=='-1' || Modalidad==-1){
                alert('Selecione Una Modalidad Academica.');
                $('#Modalidad').effect("pulsate", {times:3}, 500);
                $('#Modalidad').css('border-color','#F00');
                return false;
            }
           
           $('#actionID').val('Carrera');
           
           $.ajax({//Ajax
			  type: 'POST',
			  url: 'VisualizarReporte_html.php',
			  async: false,
			  dataType: 'html',
			  data:$('#NewReport').serialize(),
			  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			  success: function(data){
					$('#Td_Carrera').html(data);
				}//data 
		  }); //AJAX 
          
        }//function BuscarData
        function GenerarReporte(){
            $('#actionID').val('Reporte');
            $('#Div_Carga').html('Generando Reporte...');
            $.ajax({//Ajax
    			  type: 'POST',
    			  url: 'VisualizarReporte_html.php',
    			  async: false,
    			  dataType: 'html',
    			  data:$('#NewReport').serialize(),
    			  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    			  success: function(data){
    			        $('#Div_Carga').html(''); 
    					$('#Div_Carga').html(data);
    				}//data 
    		  }); //AJAX 
            
        }//function GenerarNewReporte