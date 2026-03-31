
<?php
   include("../templates/templateObservatorio.php");
   include("../class/toolsFormClass.php");
   
   $db =writeHeader("Observatorio",true);

   ?>
  
<style>
	#alerta{
		text-align:center;
		line-height:500px;
		vertical-align:middle;
		font-size:16px;
		font-weight:bold;
	}
	.obs-cit-usuarios{
		display:block;
		width:100%;
		height:160px;
		overflow:auto;
		
	}
	.obs-cit-formtags {
		background:#CCC;
		width:100%;
		text-align:center;
		display:block;
		margin-bottom:10px;
		padding:10px 0;
	}
	.obs-cit-formtags span{
		font-size:9px;
		padding:3px 10px;
		margin:5px;
		background:#f4f4f4;
	}
	.obs-cit-examptags{
		font-size:11px;
	}
</style> 
<div id="eldestino"> 
<?php

   $numerosid='';
if($_POST['resgitro_riesgo']==''){
	
	if(isset($_POST['mensaje'])){
		
	$correos1=$_POST['correo1'];
	$correos2=$_POST['correo2'];
	$nombres=$_POST['nombre'];
	$apellidos=$_POST['apellido'];
	$mensaje=$_POST['mensaje'];
	
	echo $_POST['mensaje'];
	//$mensaje=str_replace("lo que nos interesa quitar ","por lo que lo sustituimos",$mensaje);
	}
?>
<div id="alerta">
No ha seleccionado ningún estudiante
</div>    
<?php
	
}else{

  $sql="SELECT nombresestudiantegeneral, apellidosestudiantegeneral,  direccionresidenciaestudiantegeneral, emailestudiantegeneral, email2estudiantegeneral, codigogenero 
		FROM `estudiantegeneral` 
		WHERE numerodocumento  IN (". implode(',', array_map('intval',$_POST['resgitro_riesgo'])). ")";
		
		$data_in= $db->Execute($sql);
 //echo $sql;
?>
<div class="obs-cit-usuarios">
	<h2>Estudiantes a citar:</h2>
	<table style="width:100%">
        <thead>
            <tr>
                <th>Nombres</th>
                <th>Completos</th>
            </tr>
        </thead>
        <tbody>
<?php
foreach($data_in as $dt):
?>
        	<tr>
                <td><?php  echo $dt['nombresestudiantegeneral']; ?></td>
                <td>
				<?php
				echo $dt['apellidosestudiantegeneral'];
				?>
                </td>
            </tr>
<?php
endforeach;
?>
        </tbody>
    </table>
</div>

<div class="obs-cit-formulario">
<div class="obs-cit-formtags">
  <p><b>Tags para el mensaje</b></p>
  <p><span>{genero}</span><span>{nombres}</span><span>{apellidos}</span></p>
</div>

<div class="obs-cit-examptags">
<h5>Ejemplo:</h5>
  <p><strong>Saludos {genero} {nombres} {apellidos}</strong></p>
  <p>Recuerde el proximo lunes tiene una cita en la facultad</p>
</div>
 <script>
 $(function () {
	 
	 	 $( "#btn-enviar" ).on("click", function (e) {
                    e.preventDefault();
                    document.getElementById("mensajecita").innerHTML = $.trim(nicEditors.findEditor('mensajecita').getContent());
                    
                        sendForm()
                    
                });
	 
	 
	 
	 function sendForm() {
		
		 $.ajax({
				  type: "POST",
				  cache: false,
				  url: $("#form-citacion").attr('action'),
				  data: $("#form-citacion").serializeArray(), 
				  success: function (data) {
		               $("#eldestino").html(data);
              }
        });
	};
	
 })
 </script>
<form id="form-citacion" name="form-citacion" method="post" action="get_send_citaciones.php">
	<table style="width:100%">
    <tr>
        <td>
        <?php
        foreach($data_in as $dt):
        ?>
            <?php  echo toolsFormClass::getForm('hidden','correo1','1',$dt['emailestudiantegeneral']);?>
            <?php  echo toolsFormClass::getForm('hidden','correo2','1',$dt['email2estudiantegeneral']);?>
            <?php  echo toolsFormClass::getForm('hidden','nombre','1',$dt['nombresestudiantegeneral']);?>
            <?php  echo toolsFormClass::getForm('hidden','apellido','1',$dt['apellidosestudiantegeneral']);?>
            <?php  echo toolsFormClass::getForm('hidden','genero','1',$dt['codigogenero']);?>
        <?php
        endforeach;
        ?>    
        </td>
    </tr>
    <tr>
        <td>
            <?php  echo toolsFormClass::getForm('textarea','mensaje','2','','mensajecita','mensajecita','600px','200px');?>
        </td>
    </tr>
    <tr>
        <td>
            <?php  echo toolsFormClass::getForm('button','','1','Enviar','btn-enviar','btn-enviar');?>
        </td>
    </tr>
</table>
 </form>
</div>

<?php
}
?>
</div>