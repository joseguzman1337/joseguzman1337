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
error_reporting(2047);
ini_set('memory_limit','32M');
if(!empty($_POST['annio']) and !empty($_POST['periodo'])){

	$rutaado=("../serviciosacademicos/funciones/adodb_mod/");
	require_once('../serviciosacademicos/Connections/salaado-pear.php');
	require_once('../serviciosacademicos/Connections/snies_conexion_postgresql.php');
	require_once('../serviciosacademicos/funciones/clases/motor/motor.php');
	require_once('../serviciosacademicos/funciones/sala_genericas/FuncionesCadena.php');

	require_once('funciones/obtener_datos.php');
	echo date("Y-m-d H:i:s"),"\n\n";
	//$sala->debug=true;
	//$snies_conexion->debug=true;
//	$codigoperiodo=$_GET['codigoperiodo'];;
	//$snies_conexion->query("SET CLIENT_ENCODING TO 'UTF8';");

	$indiceperiodo=$_POST['periodo']-0;
	$codigoperiodo=$_POST['annio'].$indiceperiodo;

	$snies = new snies($sala,$codigoperiodo);
	$array_egresado=$snies->estudiante_graduado($codigoperiodo);
	$snies->asignaConexionPostgreSQL(&$snies_conexion);
	if($_POST['accion']=="2"){
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
		if(isset($_GET['tabla']))
		{
			$snies->tabla($array_egresado);
		}
		foreach ($array_egresado as $llave => $valor)
		{
			$query_obtener_consecutivo_bd_externa="SELECT pro_consecutivo FROM programa WHERE prog_code='".$valor['PROG_CODE']."'";
			$operacion=$snies_conexion->query($query_obtener_consecutivo_bd_externa);
			$row_operacion=$operacion->fetchRow();
			if(empty($row_operacion['pro_consecutivo']))
			{
				$pro_consecutivo=111111;
			}
			else
			{
				$pro_consecutivo=$row_operacion['pro_consecutivo'];
			}
			$fila['ies_code']=$valor['IES_CODE'];
			$fila['grad_annio']=$valor['GRAD_ANNIO'];
			$fila['grad_semestre']="0".substr($codigoperiodo,4,5);
			$fila['codigo_unico']=$valor['CODIGO_UNICO'];
			$fila['pro_consecutivo']=$pro_consecutivo;
			$fila['fecha_grado']=$valor['FECHA_GRADO'];
			$fila['ecaes_observaciones']=0;
			$fila['ecaes_resultados']=0;
			$fila['departamento']=11;
			$fila['municipio']=11001;
			$fila['codigo_ent_aula']=1729;
			$fila['acta']=$valor['ACTA'];
			if($valor['FOLIO']==null){
				$folio='NO REPORTADO AUN';
			}
			else {
				$folio=$valor['FOLIO'];
			}
			$fila['folio']=$folio;
			$fila['tipo_doc_unico']=$valor['TIPO_DOC_UNICO'];
			$fila['snp']='';
		




			$participante=$snies->datos_participante($valor['codigoestudiante']);
			$array_interno=$participante;
			$array_pais_ln=array($snies->pais($participante['idciudadnacimiento'],"pais"));
			$array_depto_ln=array($snies->pais($participante['idciudadnacimiento'],"departamento"));
			$array_pais_lr=array($snies->pais($participante['ciudadresidenciaestudiantegeneral'],"pais"));
			$array_depto_lr=array($snies->pais($participante['ciudadresidenciaestudiantegeneral'],"departamento"));
			$filapar['ies_code']=$array_interno['IES_CODE'];
			$filapar['primer_apellido']=sanear_string($array_interno['PRIMER_APELLIDO']);
			$filapar['segundo_apellido']=sanear_string($array_interno['SEGUNDO_APELLIDO']);
			$filapar['primer_nombre']=sanear_string($array_interno['PRIMER_NOMBRE']);
			$filapar['segundo_nombre']=sanear_string($array_interno['SEGUNDO_NOMBRE']);
			if($array_interno['FECHA_NACIM']<>'0000-00-00')
			{
				$filapar['fecha_nacim']=$array_interno['FECHA_NACIM'];
			}
			else
			{
				$filapar['fecha_nacim']='1900-01-01';
			}

			if($array_pais_ln[0]==''){
				$array_pais_ln[0]=0;
			}
			if($array_depto_ln[0]==''){
				$array_depto_ln[0]=0;
			}
			$filapar['pais_ln']=$array_pais_ln[0];
			$filapar['departamento_ln']=$array_depto_ln[0];
			$municipio_ln=$snies->leerMunicioBDSNIES($array_depto_ln[0]);
			if(empty($municipio_ln)){
				$municipio_ln=11001;
				$filapar['departamento_ln']="11";
			}
			
			$filapar['municipio_ln']=$municipio_ln;
			$filapar['genero_code']=$array_interno['GENERO_CODE'];
			$filapar['email']=$array_interno['EMAIL'];
			$filapar['est_civil_code']=$array_interno['EST_CIVIL_CODE'];
			$filapar['tipo_doc_unico']=$array_interno['TIPO_DOC_UNICO'];
			$filapar['codigo_unico']=$array_interno['CODIGO_UNICO'];
			//$filapar['tipo_id_ant']='NI';
			//$filapar['codigo_id_ant']=null;
			$filapar['pais_tel']=57;
			$filapar['area_tel']=1;
			$filapar['numero_tel']=$array_interno['telefonoresidenciaestudiantegeneral'];
			//$snies->ingresar_actualizar_fila_bd($snies_conexion,"PARTICIPANTE",$filapar,"CODIGO_UNICO",$filapar['codigo_unico'],"");
			//$snies->insertar_fila_bd($snies_conexion,'PARTICIPANTE',$filapar);


			$snies->ingresar_actualizar_fila_bd($snies_conexion,"PARTICIPANTE",$filapar,"codigo_unico",$fila['codigo_unico']," and tipo_doc_unico='".$valor['TIPO_DOC_UNICO']."'");
			unset($filapar);
		
				$tabla='participante';
				$filapar['genero_code']=$array_interno['GENERO_CODE'];
				$nombreidtabla='codigo_unico';
				$idtabla="'".$array_interno['CODIGO_UNICO']."'";
				$snies->actualizar_fila_bd($snies_conexion,$tabla,$filapar,$nombreidtabla,$idtabla,"");
			unset($filapar);

			$fila_est['ies_code']=$valor['IES_CODE'];
			$fila_est['codigo_unico']=$valor['CODIGO_UNICO'];
			$fila_est['tipo_doc_unico']=$valor['TIPO_DOC_UNICO'];

			$snies->ingresar_actualizar_fila_bd($snies_conexion,"estudiante",$fila_est,"codigo_unico",$fila['codigo_unico']," and tipo_doc_unico='".$valor['TIPO_DOC_UNICO']."'");


			

			$snies->ingresar_actualizar_fila_bd($snies_conexion,"graduado",$fila,"codigo_unico",$fila['codigo_unico']," and grad_annio='".$fila['grad_annio']."' and grad_semestre='".$fila['grad_semestre']."' and pro_consecutivo='".$fila['pro_consecutivo']."'");
			
			
			unset($fila);
		}
		echo "cant registros insertados: $snies->contador_inserta\n\n";
		echo "cant registros actualizados: $snies->contador_actualiza\n\n";
	}
	else
	{
		echo  $query="SELECT * FROM graduado where grad_annio=".$_POST['annio']." and grad_semestre='0".$_POST['periodo']."'";
		$operacion=$snies_conexion->query($query);
		while ($row_operacion=$operacion->fetchRow()){
		$array_datos[]=$row_operacion;		
		}
			$motor = new matriz($array_datos);
			$motor->mostrar();

	}
	
}
?>
