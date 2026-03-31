<?php

if (!isset($_SESSION)) { 
	session_start();
}else{
	die("No ha iniciado sesion en el sistema");
}
if(isset($_REQUEST['Ver'])) {
    $Ver = $_REQUEST['Ver'];
}else{
    $Ver  = "";
}
$url = $_POST['url'];

if(!$url){
    $url = './';
}else{
    $url = $url;
}

require_once("./consultas_class.php");
$objeto = new ConsultarEspacios;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Menú</title>	
        <?php
        /**
         * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
         * Se reemplaza ../../../assets/js/jquery.js por ../../../assets/js/jquery-3.6.0.min.js
         * @since Enero 14, 2019
         */ 
        ?>
     <link href="../asignacionSalones/calendario3/wdCalendar/css/dailog.css" rel="stylesheet" type="text/css" />
    <link href="../asignacionSalones/calendario3/wdCalendar/css/calendar.css" rel="stylesheet" type="text/css" /> 
    <link href="../asignacionSalones/calendario3/wdCalendar/css/dp.css" rel="stylesheet" type="text/css" />   
    <link href="../asignacionSalones/calendario3/wdCalendar/css/alert.css" rel="stylesheet" type="text/css" /> 
    <link href="../asignacionSalones/calendario3/wdCalendar/css/main.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../../../assets/js/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../css/Styleventana.css" type="text/css" /> 
    <script type="text/javascript" language="javascript" src="../../mgi/js/jquery.js"></script>
    <script type="text/javascript" language="javascript" src="../../mgi/js/jquery.dataTables.js"></script>
    <script type="text/javascript" language="javascript" src="../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script> 
      
    <script src="../asignacionSalones/calendario3/wdCalendar/src/jquery.js" type="text/javascript"></script>  
    
    <script src="../asignacionSalones/calendario3/wdCalendar/src/Plugins/Common.js" type="text/javascript"></script>    
    <script src="../asignacionSalones/calendario3/wdCalendar/src/Plugins/datepicker_lang_US.js" type="text/javascript"></script>     
    <script src="../asignacionSalones/calendario3/wdCalendar/src/Plugins/jquery.datepicker.js" type="text/javascript"></script>

    <script src="../asignacionSalones/calendario3/wdCalendar/src/Plugins/jquery.alert.js" type="text/javascript"></script>    
    <script src="../asignacionSalones/calendario3/wdCalendar/src/Plugins/jquery.ifrmdailog.js" defer="defer" type="text/javascript"></script>
    <script src="../asignacionSalones/calendario3/wdCalendar/src/Plugins/wdCalendar_lang_US.js" type="text/javascript"></script>    
    <script src="../asignacionSalones/calendario3/wdCalendar/src/Plugins/jquery.calendar.js" type="text/javascript"></script>   
    
        
	<script>
	function seleccione(variable){
		/*
		//Esta función oculta los div y calendario de acuerdo a la selección anterior.
		*/
		if (variable==1) {
			$('#respuestaSalones').hide(); //oculto mediante id
			$('#mostrarCalendario').hide(); //oculto mediante id
		}else if(variable==2){
			$('#mostrarCalendario').hide(); //oculto mediante id
		}else{
			$('#respuestaBloques').hide(); //oculto mediante id
			$('#respuestaSalones').hide(); //oculto mediante id
			$('#mostrarCalendario').hide(); //oculto mediante id
		};
	}
	function bloques(variable){
		//Esta funcíon muestra en un select los bloques que existen de acuerdo al sitio seleccionado (Usaquen o chia).
		seleccione(1); //Controlo que no se muestre los salones si no se ha seleccionado un bloque
		$('#respuestaBloques').show(); //Muestro div mediante id
		var action = 'consultaBloques';
        
        $.ajax({//Ajax   
          type:'POST',
          url: '<?PHP echo $url?>consultas_funciones.php',
          async: false,
          dataType: 'html',
          data: ({"ClasificacionEspaciosId": variable,"action": action}),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
          success: function(data){
               $('#respuestaBloques').html(data);
        	}//data 
            
       });//AJAX 		
	}
	function salones(variable){
		/*Esta funcíon muestra en un select los salones que existen de acuerdo al bloque seleccionado (Bloque M, Campito, etc).
		*/
		// seleccione(1); //Controlo que no se muestre los salones si no se ha seleccionado un bloque
		
		$('#respuestaSalones').show(); //Muestro div mediante id
        var action = 'consultaSalones';
         $.ajax({//Ajax   
          type:'POST',
          url: '<?PHP echo $url?>consultas_funciones.php',
          async: false,
          dataType: 'html',
          data: ({"ClasificacionEspaciosId": variable,"action": action}),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
          success: function(data){
               $('#respuestaSalones').html(data);
        	}//data 
            
       });//AJAX
	}
	function mostrarAgenda(variable){
	  // alert('id->'+variable);
		/* Esta función muestra el calendario con los eventos correspondiente al salón seleccionado. */
		if ($('#mostrarCalendario').is(':hidden')){
			$('#mostrarCalendario').show(); //Muestro div mediante id
		}
	 
        $.ajax({//Ajax   
              type:'POST',
              url: '<?PHP echo $url?>consultas_funciones.php',
              async: false,
              dataType: 'json',
              data:({action:'Name',id:variable}),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
              success: function(data){
                   if(data.val==='FALSE'){
                        alert(data.descrip);
                        return false;
                   }else{
                        $('#TextDinamic').html(data.Name);
                   }
            	}//data 
            
       });//AJAX 
        
        $.ajax({//Ajax   
          //type:'POST',
          url: '<?PHP echo $url?>calendario3/wdCalendar/sample.php?id='+variable+'&Ver=<?PHP echo $Ver?>',
          async: false,
          dataType: 'html',
          //data:({actionID:'TipoNumber',Numero:i}),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
          success: function(data){
               $('#mostrarCalendario').html(data);
               $('#wk-allday').css('display','none');
        	}//data 
            
       });//AJAX 
	
	}
	</script>
	<style type="text/css">
	#respuestaSitio{
		position:relative;
	}
	#respuestaBloques{
		float:left;
		position: relative;
	}
	#respuestaSalones{
		float:left;
		position: relative;
	}
	#mostrarCalendario{
		float:left;
		position:relative;
		top:50px;
		left:-74%;
	}
	</style>	
</head>
<body>
	<form name="formul">
		<div>
            <?PHP if($Ver==1){
                ?>
                <h1>Ver Eventos Programados</h1>
                <?PHP
            }else{
                ?>
                <h1>Editar y Ver Eventos Programados</h1>
                <?PHP
            }?>
			
		</div>
        
        <table style="width: 100%;">
            <tr>
                <td>
                   <table>
                        <tr>
                            <td>
                                <div id="respuestaSitio">
                        			<label>Sítio:</label> 
                        			<select name="miSelect" onchange="bloques(this.value)">
                        				<option value="0">Seleccione Sitio</option>
                        			    <?php
                        			    $consultaSedes = $objeto->ConsultarSedes();
                        			    while (!$consultaSedes->EOF) {
                                            ?>
                                            <option value="<?php echo $consultaSedes->fields['ClasificacionEspaciosId']; ?>" >
                                                <?php echo $consultaSedes->fields['Nombre']; ?>
                                            </option>
                                            <?php
                                            $consultaSedes->MoveNext();
                        				}
                        			    ?>
                        			</select>
                        		</div>
                            </td>
                       </tr>
                       <tr>
                            <td>
                                <div id="respuestaBloques" ></div>
                            </td>
                       </tr>     
                      <tr>
                            <td>
                                <div id="respuestaSalones" ></div>
                            </td>
                      </tr> 
                    </table> 
                </td>
                <td style="width: 90%;">
                    <div style="text-align: center; margin-right: 20%; width: 100%;">
                        <fieldset style="width: 100%; height: 800px;">
                            <legend id="TextDinamic" style="color: black;"></legend>
                    		<div id="mostrarCalendario" style="text-align: center; margin-left: 75%; width: 100%; height: 100%; margin-top: -3%;"></div>
                        </fieldset>
                     </div>
                </td>
            </tr>
        </table>
	    <br />
        
        <div style="clear: both;"></div>	
	</form>
	
</body>
</html>