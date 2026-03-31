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
error_reporting(0);
ini_set('memory_limit', '128M');
ini_set('max_execution_time','216000');

$rutaado=("../serviciosacademicos/funciones/adodb_mod/");
require_once('../serviciosacademicos/Connections/salaado-pear.php');
require_once('../serviciosacademicos/Connections/snies_conexion_postgresql.php');
require_once('../serviciosacademicos/funciones/clases/motorv2/motor.php');
require_once("../serviciosacademicos/consulta/estadisticas/matriculas/funciones/obtener_datos.php");
require_once("../serviciosacademicos/funciones/clases/debug/dBug.php");
require_once("funciones/obtener_datos.php");
?>
<?php
if(!empty($_POST['annio']) and !empty($_POST['periodo'])){

	$codigoperiodo=$_POST['annio'].$_POST['periodo'];

	if(isset($_GET['codigocarrera'])){
		$codigocarrera=$_GET['codigocarrera'];
	}
	else{
		$codigocarrera=null;
	}

	echo "codigoperiodo ".$codigoperiodo," codigocarrera ".$codigocarrera;
	if(!empty($codigoperiodo)){

		$datos_matriculas=new obtener_datos_matriculas($sala,$codigoperiodo);
		$carreras=$datos_matriculas->obtenerCarrerasSnies($codigocarrera);
		if(is_array($carreras)){
			foreach ($carreras as $llave_carreras => $valor_carreras)
			{
				$array_matriculados=$datos_matriculas->obtener_total_matriculados($valor_carreras['codigocarrera'],'arreglo');
				foreach ($array_matriculados as $llave_m => $valor_m){
					$array_codigoestudiante_matriculado[]=$valor_m['codigoestudiante'];
				}
				unset($array_matriculados);
			}
		}
		foreach ($array_codigoestudiante_matriculado as $llave_e => $valor_e){
			$array_datos=$datos_matriculas->obtenerInfoSNIES($valor_e);
			$array_full[$valor_e]=$array_datos;
		}

		echo "<h1>".count($array_full)." registros reportados</h1><br>";

		if($_POST['accion']=='2'){
			foreach ($array_full as $llave_f => $valor_f)
			{
				$numeroregistrocarreraregistro=$carreras[$valor_f['codigocarrera']]['numeroregistrocarreraregistro'];

				if(!empty($numeroregistrocarreraregistro)){
                                        $semestre="0".substr($codigoperiodo,4,5);
                                        $annio=substr($codigoperiodo,0,4);
					$query_pro_consecutivo="SELECT p.pro_consecutivo,cp.cod_entidad_aula FROM programa p,cubrimiento_programa cp
                                        WHERE p.pro_consecutivo=cp.pro_consecutivo and prog_code='$numeroregistrocarreraregistro'and 
                                         annio='$annio'and semestre='$semestre'";
					$operacion_pro_consecutivo=$snies_conexion->query($query_pro_consecutivo);
					if($operacion_pro_consecutivo)
					{
						$row_pro_consecutivo=$operacion_pro_consecutivo->fetchRow();
					}
					echo $row_pro_consecutivo['pro_consecutivo'],"<br>";
					if(empty($row_pro_consecutivo['pro_consecutivo']))
					{
						$pro_consecutivo=111111;
					}
					else
					{
						$pro_consecutivo=$row_pro_consecutivo['pro_consecutivo'];
					}
				}
				else{
					$pro_consecutivo=111111;
				}

				$fila['ies_code']='1729';
				$fila['est_annio']=substr($codigoperiodo,0,4);
				$fila['est_semestre']="0".substr($codigoperiodo,4,5);
				$fila['codigo_unico']=$valor_f['CODIGO_UNICO'];
				$fila['horario_code']='03';
				$fila['ceres']=$row_pro_consecutivo['cod_entidad_aula'];
				$fila['departamento']=11;
				$fila['municipio']=11001;				
				$fila['departamento_le']=11;
				$fila['municipio_le']=11001;
				$fila['pro_consecutivo']=$pro_consecutivo;
				$fila['pago']='01';
				$fila['tipo_doc_unico']=$valor_f['TIPO_DOC_UNICO'];
				$datos_matriculas->insertar_fila_bd($snies_conexion,'matriculado',$fila);
				
				$tabla='participante';
				$filapar['genero_code']=$valor_f['GENERO_CODE'];
				$nombreidtabla='codigo_unico';
				$idtabla="'".$valor_f['CODIGO_UNICO']."'";
				$datos_matriculas->actualizar_fila_bd($snies_conexion,$tabla,$filapar,$nombreidtabla,$idtabla);
				unset($filapar);
			}
		}
	}
}

function depurar(){
	$deb_1 = new dBug($carreras);
	$deb_2= new dBug($array_codigoestudiante_matriculado);
	echo "<pre>";
	print_r($array_full);
	echo "</pre>";
}
?>