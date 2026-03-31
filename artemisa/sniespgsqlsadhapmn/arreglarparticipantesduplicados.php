<script language="javascript">
function validar(){

	if(document.getElementById('annio').value.length < 1){
		alert('Porfavor Digite Año');
	}
	else if(document.getElementById('periodo').value.length < 1){
		alert('Porfavor Seleccione Periodo');
	}
	else if(document.getElementById('accion').value.length < 1){
		alert('Porfavor Seleccione Accion');
	}
	else{
		document.getElementById('form1').submit();
	}
}
</script>
<form name="form1" id="form1" action="" method="POST">
<table>
<tr>
	<td>Año</td>
	<td><input name="annio" id="annio" value="<?php echo $_POST['annio']?>"></td>
</tr>
<tr>
	<td>Periodo</td>
	<td>
	<select name="periodo" id="periodo">
		<option value="">Seleccionar</option>>
		<option value="1" <?php if($_POST['periodo']=='1')echo "selected"?>>01</option>
		<option value="2" <?php if($_POST['periodo']=='2')echo "selected"?>>02</option>
	</select>
	</td>
</tr>
<tr>
	<td>Accion</td>
	<td>
	<select name="accion" id="accion">
		<option value="">Seleccionar</option>>
		<option value="1" <?php if($_POST['accion']=='1')echo "selected"?>>Reportar</option>
		<option value="2" <?php if($_POST['accion']=='2')echo "selected"?>>Insertar</option>
	</select>
	</td>
</tr>
</table>
<input name="Enviar" type="button" value="Enviar" onclick="validar()">
</form>
<?php
//phpinfo();
error_reporting(0);
ini_set('memory_limit', '128M');
ini_set('max_execution_time','216000');
$rutaado=("../serviciosacademicos/funciones/adodb_mod/");
require_once('../serviciosacademicos/Connections/salaado-pear.php');
require_once('../serviciosacademicos/Connections/snies_conexion_postgresql.php');
require_once('../serviciosacademicos/funciones/clases/motor/motor.php');
require_once('funciones/obtener_datos.php');
echo date("Y-m-d H:i:s"),"\n\n";
if(!empty($_POST['annio']) and !empty($_POST['periodo'])){

	$codigoperiodo=$_POST['annio'].$_POST['periodo'];
	$sala->debug=true;
	$snies_conexion->debug=true;
	//SET CLIENT_ENCODING TO 'value';
	//$snies_conexion->query("SET NAMES '8859-1';");

	echo "<h1>Entro 1</h1>";
	$snies = new snies($sala,$codigoperiodo);
	$snies->asignaConexionPostgreSQL($snies_conexion);
	
	$array_codigoestudiante_participante=$snies->estudiantegeneral_participante($codigoperiodo);
	if($_POST['accion']=='1')
	{
		echo "Cantidad participantes reportada por SALA: ".count($array_codigoestudiante_participante)."<br>";

	}
	$contadorParticipanteNuevo=0;
	if($_POST['accion']=='2'){
		echo "Cantidad participantes reportada por SALA: ".count($array_codigoestudiante_participante)."<br><br>";
		foreach ($array_codigoestudiante_participante as $llave => $valor)
		{
			$arrayestudiantedocumento=$snies->estudianteDocumento($valor['idestudiantegeneral']);
			foreach($arrayestudiantedocumento as $iestudiantedoc=>$estudiatedocumento)
			{
				if($participanteDocumento=$snies->encuentraParticipante($estudiatedocumento['numerodocumento'])){
					echo "participanteDocumento<pre>";
					print_r($participanteDocumento);
					echo "</pre>";
				
						
					//I  crear participante , estudiante, estudiante_h
					$participante=$snies->datos_participante($valor['codigoestudiante']);


				
					if(($participante['CODIGO_UNICO']!=$participanteDocumento[0]['codigo_unico'])||($participante['TIPO_DOC_UNICO']!=$participanteDocumento[0]['tipo_doc_unico'])){

					echo "if((".$participante['CODIGO_UNICO']."!=".$participanteDocumento[0]['codigo_unico'].")||(".$participante['TIPO_DOC_UNICO']."!=".$participanteDocumento[0]['tipo_doc_unico'].")){";

					echo "participante<pre>";
					print_r($participante);
					echo "</pre>";

					$arrayModificarParticipante[$contadorParticipanteNuevo]["codigo_unico_1"]=$participanteDocumento[0]['codigo_unico'];
					$arrayModificarParticipante[$contadorParticipanteNuevo]["tipo_doc_unico_1"]=$participanteDocumento[0]['tipo_doc_unico'];

					$participanteDocumento[0]['codigo_unico']=$participante['CODIGO_UNICO'];
					$participanteDocumento[0]['tipo_doc_unico']=$participante['TIPO_DOC_UNICO'];
					unset($participanteDocumento[0]['codigo_id_ant']);
					unset($participanteDocumento[0]['tipo_id_ant']);
					
			//=$participante['CODIGO_UNICO'];
			//		$participanteDocumento[0]['tipo_id_ant']=$participante['TIPO_DOC_UNICO'];

					$snies->insertar_fila_bd($snies_conexion,'PARTICIPANTE',$participanteDocumento[0]);
					
					$estudiante['ies_code']=1729;
					$estudiante['codigo_unico']=$participante['CODIGO_UNICO'];
					$estudiante['tipo_doc_unico']=$participante['TIPO_DOC_UNICO'];
	
					$snies->insertar_fila_bd($snies_conexion,'estudiante',$estudiante);

					if($estudianteH=$snies->encuentraEstudianteH($estudiatedocumento['numerodocumento'])){
						$estudianteH[0]['codigo_unico']=$participante['CODIGO_UNICO'];
						$estudianteH[0]['tipo_doc_unico']=$participante['TIPO_DOC_UNICO'];
						$estudianteHtmp=$estudianteH;
						echo "<pre>";
						print_r($estudianteH);
						echo "</pre>";
						foreach($estudianteHtmp[0] as $llaveh=>$valorh){
							if($estudianteH[0][$llaveh]==''){
								echo "<br>estudianteH[0][$llaveh]=".$estudianteH[0][$llaveh];
								unset($estudianteH[0][$llaveh]);
							}
						}
						$snies->insertar_fila_bd($snies_conexion,'estudiante_h',$estudianteH[0]);
						//echo "<br>";

					}

					$arrayModificarParticipante[$contadorParticipanteNuevo]["codigo_unico_2"]=$participante['CODIGO_UNICO'];
					$arrayModificarParticipante[$contadorParticipanteNuevo]["tipo_doc_unico_2"]=$participante['TIPO_DOC_UNICO'];

					//II  modificar estudiante_programa, matriculado, est_h_programa,est_h_cred
					$tabla="estudiante_programa";
					$nombreidtabla="codigo_unico";
					$idtabla="'".$arrayModificarParticipante[$contadorParticipanteNuevo]["codigo_unico_1"]."'";
					$filamod['codigo_unico']=$participante['CODIGO_UNICO'];
					$filamod['tipo_doc_unico']=$participante['TIPO_DOC_UNICO'];


					$snies->actualizar_fila_bd($snies_conexion,$tabla,$filamod,$nombreidtabla,$idtabla);
					echo "<br>";
					$tabla="matriculado";
					$nombreidtabla="codigo_unico";
					$idtabla="'".$arrayModificarParticipante[$contadorParticipanteNuevo]["codigo_unico_1"]."'";

					$snies->actualizar_fila_bd($snies_conexion,$tabla,$filamod,$nombreidtabla,$idtabla);
					echo "<br>";
	
					$tabla="estudiante_h_programa";
					$nombreidtabla="codigo_unico";
					$idtabla="'".$arrayModificarParticipante[$contadorParticipanteNuevo]["codigo_unico_1"]."'";

					$snies->actualizar_fila_bd($snies_conexion,$tabla,$filamod,$nombreidtabla,$idtabla);
					echo "<br>";

					$tabla="estudiante_h_creditos";
					$nombreidtabla="codigo_unico";
					$idtabla="'".$arrayModificarParticipante[$contadorParticipanteNuevo]["codigo_unico_1"]."'";

					$snies->actualizar_fila_bd($snies_conexion,$tabla,$filamod,$nombreidtabla,$idtabla);
					echo "<br>";

					//III eliminar estudiante,estudiante_h,participante
					$query="delete from estudiante where codigo_unico='".$participanteDocumento[0]['codigo_unico']."' and tipo_doc_unico='".$participanteDocumento[0]['tipo_doc_unico']."'";
					$snies->conexionPSQL->query($query);

					$query="delete from estudiante_h where codigo_unico='".$participanteDocumento[0]['codigo_unico']."' and tipo_doc_unico='".$participanteDocumento[0]['tipo_doc_unico']."'";
					$snies->conexionPSQL->query($query);
					

					$query="delete from participante where codigo_unico='".$participanteDocumento[0]['codigo_unico']."' and tipo_doc_unico='".$participanteDocumento[0]['tipo_doc_unico']."'";
					$snies->conexionPSQL->query($query);
					
					$contadorParticipanteNuevo++;
					
				//	exit();	
					}	

				}
			}
			
			
		}


		echo "cant registros insertados: $snies->contador_inserta\n\n";
		echo "cant registros actualizados: $snies->contador_actualiza\n\n";
		echo "cant registros falla: $snies->contador_falla\n\n";
	}
}
?>

