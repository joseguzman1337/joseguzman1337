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
	$sala->debug=false;
	$snies_conexion->debug=true;
	//SET CLIENT_ENCODING TO 'value';
	//$snies_conexion->query("SET NAMES '8859-1';");

	echo "<h1>Entro 1</h1>";
	$snies = new snies($sala,$codigoperiodo);
	$snies->asignaConexionPostgreSQL($snies_conexion);

	$array_codigoestudiante_participante=$snies->codigoestudiante_participante($codigoperiodo);
	if($_POST['accion']=='1')
	{
		echo "Cantidad participantes reportada por SALA: ".count($array_codigoestudiante_participante)."<br>";

	}
	if($_POST['accion']=='2'){

		function sanear_string($string) {
			$string = trim($string);
			$string = str_replace( array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'), array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'), $string);
			$string = str_replace( array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'), array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'), $string);
			$string = str_replace( array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'), array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'), $string);
			$string = str_replace( array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'), array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'), $string);
			$string = str_replace( array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'), array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'), $string);
			$string = str_replace( array('ñ', 'Ñ', 'ç', 'Ç'), array('n', 'N', 'c', 'C',), $string);
			return $string;
		}

		echo "Cantidad participantes reportada por SALA: ".count($array_codigoestudiante_participante)."<br><br>";
		foreach ($array_codigoestudiante_participante as $llave => $valor)
		{
			$participante=$snies->datos_participante($valor['codigoestudiante']);
			$array_interno[]=$participante;
			$array_pais_ln[]=array($snies->pais($participante['idciudadnacimiento'],"pais"));
			$array_depto_ln[]=array($snies->pais($participante['idciudadnacimiento'],"departamento"));
			$array_pais_lr[]=array($snies->pais($participante['ciudadresidenciaestudiantegeneral'],"pais"));
			$array_depto_lr[]=array($snies->pais($participante['ciudadresidenciaestudiantegeneral'],"departamento"));
		}

		for ($i=0;$i<count($array_codigoestudiante_participante);$i++)
		{
                     echo"<pre>";
         print_r($array_interno[$i]);
	echo"</pre>";
			$fila['ies_code']=$array_interno[$i]['IES_CODE'];
			$fila['primer_apellido']=sanear_string($array_interno[$i]['PRIMER_APELLIDO']);
			$fila['segundo_apellido']=sanear_string($array_interno[$i]['SEGUNDO_APELLIDO']);
			$fila['primer_nombre']=sanear_string($array_interno[$i]['PRIMER_NOMBRE']);
			$fila['segundo_nombre']=sanear_string($array_interno[$i]['SEGUNDO_NOMBRE']);
			if($array_interno[$i]['FECHA_NACIM']<>'0000-00-00')
			{
				$fila['fecha_nacim']=$array_interno[$i]['FECHA_NACIM'];
			}
			else
			{
				$fila['fecha_nacim']='1900-01-01';
			}

			if($array_pais_ln[$i][0]==''){
				$array_pais_ln[$i][0]=0;
			}
			if($array_depto_ln[$i][0]==''){
				$array_depto_ln[$i][0]=0;
			}
			$fila['pais_ln']=$array_pais_ln[$i][0];
			$fila['departamento_ln']=$array_depto_ln[$i][0];
			$municipio_ln=$snies->leerMunicioBDSNIES($array_depto_ln[$i][0]);
			if(empty($municipio_ln)){
				$municipio_ln=11001;
				$fila['departamento_ln']="11";
			}

			$fila['municipio_ln']=$municipio_ln;
			$fila['genero_code']=$array_interno[$i]['GENERO_CODE'];
			$fila['email']=$array_interno[$i]['EMAIL'];
			$fila['est_civil_code']=$array_interno[$i]['EST_CIVIL_CODE'];
			$fila['tipo_doc_unico']=$array_interno[$i]['TIPO_DOC_UNICO'];
			$fila['codigo_unico']=$array_interno[$i]['CODIGO_UNICO'];
			//$fila['tipo_id_ant']='NI';
			$fila['codigo_id_ant']='NULL';
			$fila['pais_tel']=57;
			$fila['area_tel']=1;
			$fila['numero_tel']=$array_interno[$i]['telefonoresidenciaestudiantegeneral'];
			$snies->ingresar_actualizar_fila_bd($snies_conexion,"PARTICIPANTE",$fila,"CODIGO_UNICO",$fila['codigo_unico'],"");
			//$snies->insertar_fila_bd($snies_conexion,'PARTICIPANTE',$fila);
			unset($fila);
		}
		echo "cant registros insertados: $snies->contador_inserta\n\n";
		echo "cant registros actualizados: $snies->contador_actualiza\n\n";
		echo "cant registros falla: $snies->contador_falla\n\n";
	}
}
?>

