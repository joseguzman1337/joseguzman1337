<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
   include("../../templates/templateAutoevaluacion.php");
   $db =writeHeader("Rifas participantes",true,"Autoevaluacion");
   $sql = "SELECT idsiq_Ainstrumentoconfiguracion, nombre FROM siq_Ainstrumentoconfiguracion WHERE codigoestado=100 AND cat_ins='".$_REQUEST["cat_ins"]."'";
   $encuestas = $db->GetAll($sql);
   //var_dump($encuestas);
?>  
<style>
    .listadoSelect{
        overflow:scroll;width:100%;height: 120px;overflow-x:hidden;
    }
    
    fieldset{
        margin-bottom: 20px;
    }
    
    fieldset legend{
        padding-bottom: 5px;
        padding-top: 3px;
    }
    
    .listadoSelect table tr{
        background-color: rgb(255, 255, 255);
    }
    
    .listadoSelect table tr:hover{
        background-color: rgb(204, 204, 204);
    }
    
    input[type="submit"]{
        clear: both;
        display: block;
        margin-top: 20px;
        background:-moz-linear-gradient(center top , #7DB72F, #4E7D0E) repeat scroll 0 0 transparent; 
        background: -webkit-gradient(linear, left top, left bottom, from(#7DB72F), to(#4E7D0E));
        border: 1px solid #538312;
        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
        -khtml-border-radius: 10px;
        border-radius: 10px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.2);
        -moz-box-shadow: 0 1px 2px rgba(0,0,0,.2);
        box-shadow: 0 1px 2px rgba(0,0,0,.2);
        color: #E8F0DE;
        cursor: pointer;
        font-size: 14px;
        padding: 8px 19px 9px;
        text-align: center;
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);
    }
    
    ol li{
        margin-bottom:5px;
    }
</style>
<div id="container">
    <h4>Seleccione las encuestas que aplican para la rifa</h4>
    <form action="" method="post" id="rifa_form" >
    <fieldset style="width:98%;">
                    <legend>Encuesta(s)</legend>
                    <div class="listadoSelect">
                        
                    	<table width="100%" border="0">
                        	<tbody>
                                    <?php foreach($encuestas as $encuesta) { ?>
                                        <tr>
                                            <td><?php echo $encuesta["nombre"]; ?></td>
                                            <td><input type="checkbox" value="<?php echo $encuesta["idsiq_Ainstrumentoconfiguracion"]; ?>" name="idEncuesta[]"></td>
                                       </tr>
                                       <?php } ?>
				</tbody>
                        </table>
                    </div>
        </fieldset>
        <label>Número de ganadores:</label>
        <select name="numGanadores">
            <?php for($i=1; $i<11; $i++) { ?>
            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php } ?>
        </select>
        
        <input type="submit" value="Generar ganadores" class="first small" />	
        <img src="../../images/ajax-loader.gif" style="display:none;clear:both;margin:20px auto;" id="loading"/>
             <div id='tableDiv'></div>    
    </form>
</div>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
                var n = $("input:checkbox[name=idEncuesta[]]:checked").length;
		if(n>0){
			sendForm();
		} else {
                    alert("Por favor elegir al menos 1 encuesta antes de continuar.");
                }
	});
        
        
	function sendForm(){
            $('#tableDiv').html("");
            $("#loading").css("display","block");
		$.ajax({
				type: 'POST',
				url: 'generarGanadores.php',
				async: false,
				data: $('#rifa_form').serialize(),                
				success:function(data){	 
                                    $("#loading").css("display","none");	
                                    $('#tableDiv').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
<?php    writeFooter();
        ?>  