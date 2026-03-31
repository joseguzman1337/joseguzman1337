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
		<option value="01" <?php if($_POST['periodo']=='01')echo "selected"?>>01</option>
		<option value="02" <?php if($_POST['periodo']=='02')echo "selected"?>>02</option>
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
if(!empty($_POST['annio']) and !empty($_POST['periodo'])){

	$codigoperiodo=$_POST['annio'].($_POST['periodo']-0);

	error_reporting(0);
	ini_set('memory_limit', '128M');
	ini_set('max_execution_time','216000');
	$rutaado=("../serviciosacademicos/funciones/adodb_mod/");
	require_once('../serviciosacademicos/Connections/salaado-pear.php');
	require_once('../serviciosacademicos/Connections/snies_conexion_postgresql.php');
	require_once('../serviciosacademicos/funciones/clases/motor/motor.php');
	require_once('funciones/obtener_datos.php');
	echo date("Y-m-d H:i:s"),"\n\n";
	//$sala->debug=true;
	//$snies_conexion->debug=true;
	//SET CLIENT_ENCODING TO 'value';
	//$snies_conexion->query("SET NAMES '8859-1';");
	$snies = new snies($sala,$codigoperiodo);
	$snies->asignaConexionPostgreSQL(&$snies_conexion);

	$array_codigoestudiante_estudiante=$snies->codigoestudiante_estudiante($codigoperiodo);

	echo "<h1>".count($array_codigoestudiante_estudiante)." registros reportados</h1><br>";
	if($_POST['accion']=='2'){

		foreach ($array_codigoestudiante_estudiante as $llave => $valor)
		{
			$participante=$snies->datos_participante($valor['codigoestudiante']);
			$query="select * from estudiante where codigoestudiante=".$valor['codigoestudiante'];
			$operacionestudiante=$sala->query($query);
			$datosestudiante=$operacionestudiante->fetchRow();
			$numerocarreraregistro=$snies->carreraregistro($valor['codigocarrera']);

			$query_pro_consecutivo="SELECT pro_consecutivo FROM programa WHERE prog_code='".$numerocarreraregistro."'";
			$operacion_pro_consecutivo=$snies_conexion->query($query_pro_consecutivo);

			$fila['ies_code']=1729;
			$fila['codigo_unico']=$participante['CODIGO_UNICO'];
			$fila['tipo_doc_unico']=$participante['TIPO_DOC_UNICO'];
			$fila['annio']=$datosestudiante["codigoperiodo"][0].$datosestudiante["codigoperiodo"][1].$datosestudiante["codigoperiodo"][2].$datosestudiante["codigoperiodo"][3];
			$fila['semestre']="0".$datosestudiante["codigoperiodo"][4];
			if($operacion_pro_consecutivo)
			{
				$row_pro_consecutivo=$operacion_pro_consecutivo->fetchRow();
			}

			if(empty($row_pro_consecutivo['pro_consecutivo']))
			{
				$pro_consecutivo=111111;
			}
			else
			{
				$pro_consecutivo=$row_pro_consecutivo['pro_consecutivo'];
			}
			$fila['pro_consecutivo']=$pro_consecutivo;
			$fila['departamento']='11';
			$fila['municipio']='11001';
			$fila['cod_entidad_aula']='1729';
			$fila['retirado']='02';

			if(($fila['annio']==$_POST['annio'])&&($fila['semestre']==$_POST['periodo'])){
				$snies->insertar_fila_bd($snies_conexion,'estudiante_h_programa',$fila);
			}

			unset($fila);
			unset($participante);
		}
		echo "cant registros insertados: $snies->contador_inserta\n\n";
		echo "cant registros actualizados: $snies->contador_actualiza\n\n";
	}
	else{
		echo $query="SELECT count(*) as cantidad FROM estudiante_h_programa";
		$operacion=$snies_conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		echo "CANTIDAD=".$row_operacion['cantidad'];
		 $query="SELECT * FROM estudiante_programa limit 100 offset ".($row_operacion['cantidad']-100);
		$operacion=$snies_conexion->query($query);
		while ($row_operacion=$operacion->fetchRow()){
		$array_datos[]=$row_operacion;		
		}
			$motor = new matriz($array_datos);
			$motor->mostrar();
	}	
}
?>
