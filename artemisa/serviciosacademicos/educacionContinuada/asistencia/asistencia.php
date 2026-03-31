<?php include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Lista de Asistencia",TRUE);

    if($_SERVER["REQUEST_METHOD"]="POST"){
	$fecha=addslashes($_POST['fechaLista']);
        $carrera=addslashes($_POST['carrera']);
        $codigocarrera=addslashes($_POST['codigocarrera']);
        $id=addslashes($_POST['idgrupo']);
        $hora=addslashes($_POST['horasSesion']);
    }

    
    
    
    $utils = Utils::getInstance();
	

$participantes = $utils->getParticipantesGrupoCursoEducacionContinuada($db,$id);  
       $numParticipantes = count($participantes);

?>
<style>
table,th,td
{
	border:1px solid black;
}
table
{
	border-collapse:collapse;
}
</style>
<h4 style="margin:0;">Lista de asistencia <?php echo $utils->getNombreCursoGrupo($db,$id)." (".$fecha.")"; ?></h4>
<form  action="" method="post" id="formAsistencia" style="position: absolute; z-index: -1; margin-top:0px; width:100%">
	<input id="inputCantidadAsistencia" name="inputCantidadAsistencia"  type="hidden"  value="<?php echo $numParticipantes; ?>"/>
        <input id="idGrupoAsistencia" name="idGrupoAsistencia"  type="hidden"  value="<?php echo $id; ?>"/>
        <input id="fechaAsistencia" name="fechaAsistencia" type="hidden"  value="<?php echo $fecha; ?>"/>
        <input id="horaAsistencia" name="horaAsistencia" type="hidden"  value="<?php echo $hora; ?>"/>
         <p id="mensajesuccess" style="margin:0; font-weight: bold; color:green; visibility: hidden;display:none">Se ha registrado la asistencia exitosamente</p>
	<table class="viewList greenList" width="80%">
            <thead>
		<tr class="dataColumns">
			<th class="column">Apellidos</th>
                        <th class="column">Nombres</th>
			<th class="column">Asistencia</th>
		</tr>
             </thead>
             <tbody>
	<?php
		$i=0;
		$color=false;
		for($i = 0; $i < $numParticipantes; ++$i) { 
		?>
		<tr <?php if($color){ ?> class="green" <?php } ?>>
			<td><?php echo $participantes[$i]['apellidosestudiantegeneral'];?></td>
			<td><?php echo $participantes[$i]['nombresestudiantegeneral'];?></td>
			<td class="center">
                            <input id="<?php echo 'idEstudiante'.$i; ?>" name="<?php echo 'idEstudiante'.$i; ?>" type="hidden"  value="<?php echo $participantes[$i]['idestudiantegeneral']; ?>"/>
			<?php
			$idHabilitar='cambiarEstadoAsistenciaHabilitar'.$i;
			$idInhabilitar='cambiarEstadoAsistenciaInhabilitar'.$i;
			
				
			?>
				Si:
					<input type="checkbox" class="radio" value="1" name="<?php echo $idHabilitar; ?>" id="<?php echo $idHabilitar; ?>" onClick="javascript: cambiarEstado(this,<?php echo $idInhabilitar; ?>);" checked />
					No:
					<input type="checkbox" class="radio" value="0" name="<?php echo $idInhabilitar; ?>" id="<?php echo $idInhabilitar; ?>" onClick="javascript: cambiarEstado(this,<?php echo $idHabilitar; ?>);"/>
				
			</td>
		</tr>
	<?php $color=!$color;
		}
	?>
                </tbody>
       </table>
	
			<input id="inputAsistencia" style="margin-left: 10px;margin-bottom:20px" type="submit" name="Submit" onClick="" value="Registrar asistencia"/>
	
</form>

<script type="text/javascript">
function cambiarEstado(element, intIdOtro){
	if(element.checked){
		intIdOtro.checked=false;
		intIdOtro.value='0';
		element.value='1';
	}
	else{
		element.checked=true;
	}
}

$('#inputAsistencia').click(function(e){
	e.preventDefault();
	$.ajax({
		url: 'asistenciaBackEnd.php',
		type: 'POST',
		dataType: 'json',
		data: $('#formAsistencia').serialize(),
		success: function(data) {
                    console.log(data);
			if(data.mensaje == "success"){
                            alert("La lista ha sido registrada correctamente.");
                            window.location.href="index.php";
                            //document.getElementById('mensajesuccess').style.display="visible";
                            
			}
			else{
				alert(data.mensaje);
			}
			},
			error: function(xhr,err) {
				//en caso de falla lols algo
			}
	});
});

</script>

