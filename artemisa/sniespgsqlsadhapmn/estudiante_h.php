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
if(!empty($_POST['annio']) and !empty($_POST['periodo'])){

	$codigoperiodo=$_POST['annio'].$_POST['periodo'];
$sala->debug=false;
	$snies_conexion->debug=true;
	error_reporting(0);
	//ini_set('memory_limit', '128M');
	ini_set('max_execution_time','10000000');
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
	$snies->asignaConexionPostgreSQL($snies_conexion);

	
	$array_codigoestudiante_estudiante=$snies->codigoestudiante_estudiante($codigoperiodo);
/*echo "<pre>";
print_r($array_codigoestudiante_estudiante[0]);
//echo "</pre>";*/
	echo "<h1>".count($array_codigoestudiante_estudiante)." registros reportados</h1><br>";
	if($_POST['accion']=='2'){
$i=0;
$j=0;
		foreach ($array_codigoestudiante_estudiante as $llave => $valor)
		{
			 $j;
			ob_flush();
			flush();

			$participante=$snies->datos_participante($valor['codigoestudiante']);
			$fila['ies_code']=1729;
			$fila['codigo_unico']=$participante['CODIGO_UNICO'];
			$fila['tipo_doc_unico']=$participante['TIPO_DOC_UNICO'];
			$fila['annio']=$_POST['annio'];
			$fila['semestre']="0".$_POST['periodo'];
			
			$filacredito['ies_code']=1729;
			$filacredito['codigo_unico']=$participante['CODIGO_UNICO'];
			$filacredito['tipo_doc_unico']=$participante['TIPO_DOC_UNICO'];
			$filacredito['annio']=$_POST['annio'];
			$filacredito['semestre']="0".$_POST['periodo'];
			
			$tipofinanciero=$snies->recursofinancieroestudiante($valor["idestudiantegeneral"]);

			switch(trim($tipofinanciero[0]["idtipoestudianterecursofinanciero"])){
				case '3':
					$entidad="03";
				break;
				case '5':
					$entidad="02";
				break;
				case '9':
					$entidad="01";
				break;
				case '2':
					$entidad="99";
				break;
				case '4':
					$entidad="99";
				break;
				case '6':
					$entidad="99";
				break;
				
				default:
					$entidad="04";
				break;
			}
			//$fila['idtipoestudianterecursofinanciero']=$tipofinanciero[0]["idtipoestudianterecursofinanciero"];
			if($entidad=="99"){
				$filacredito['porcentaje_financiacion']='0';
				$fila['financiera']='02';
				$fila['recibio_apoyo_financiero']='02';
				$filacredito['entidad']='04';
			}
			else{
				$filacredito['porcentaje_financiacion']='100';
				$fila['financiera']='01';
				$fila['recibio_apoyo_financiero']='01';
				$filacredito['entidad']=$entidad;
			}
			//$fila['porcentaje_ayuda_financ_recib']='0';			
			$fila['academico']='02';			
			$fila['recibio_apoyo_academico']='02';			
			//$fila['nivel_satisfaccion_apoyo_acad']='3';
			$fila['recibio_otros_apoy']='02';
			$fila['otros']='02';				
			//$fila['valor_total_pagado']='0';			
			switch(trim($valor['idestadocivil'])){
				case '1':
				$fila['estado_civil']='01';
				break;
				case '2':
				$fila['estado_civil']='02';
				break;
				case '3':
				$fila['estado_civil']='03';
				break;
				case '4':
				$fila['estado_civil']='03';
				break;
				case '5':
				$fila['estado_civil']='05';
				break;
				case '6':
				$fila['estado_civil']='04';
				break;
			}
			$datosestratoestudiante=$snies->estudiante_historico($valor['idestudiantegeneral']);
			//$fila['personas_a_cargo']='0';
			if(!$datosestratoestudiante['idestrato'])
			$datosestratoestudiante['idestrato']=3;
			
			if($datosestratoestudiante['idestrato']=='9'){
			$datosestratoestudiante['idestrato']='6';
			}

			$fila['estrato']="0".$datosestratoestudiante['idestrato'];
			$fila['discapacidad']='02';
			$fila['trabajo_semestre']='02';
			$fila['tipo_de_trabajo']='03';
			//$fila['rango_de_ingreso']='01';
			//$fila['duracion']='01';
			
                        $snies->insertar_fila_bd($snies_conexion,'estudiante_h',$fila);
			$snies->insertar_fila_bd($snies_conexion,'estudiante_h_creditos',$filacredito);

			/*if($i<100){
				if(is_array($tipofinanciero)){
				echo "<pre>";
				 print_r($tipofinanciero);
				 echo "</pre>";
				}
			}*/
			
			if($tipofinanciero[0]["idtipoestudianterecursofinanciero"]){
			if($i<100){
			$array_datos[]=$fila;
/* 				echo "<pre>";
				print_r($valor);
				echo "</pre>";
 */			}
			$i++;
			}
			unset($fila);
			unset($participante);
			$j++;
		}
		echo "cant registros insertados: $snies->contador_inserta\n\n";
		echo "cant registros actualizados: $snies->contador_actualiza\n\n";
	}
	else{
		echo $query="SELECT count(*) as cantidad FROM estudiante";
		$operacion=$snies_conexion->query($query);
		$row_operacion=$operacion->fetchRow();
		echo "CANTIDAD=".$row_operacion['cantidad'];
		 $query="SELECT * FROM estudiante limit 100 offset ".($row_operacion['cantidad']-100);
		$operacion=$snies_conexion->query($query);
		while ($row_operacion=$operacion->fetchRow()){
		$array_datos[]=$row_operacion;		
		}
	}
	
	$motor = new matriz($array_datos);
	$motor->mostrar();

	
}
?>

