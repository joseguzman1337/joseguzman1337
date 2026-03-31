<script language="javascript">
function validar(){

	if(document.getElementById('annio').value.length < 1){
		alert('Porfavor Digite Año');
	}
	else if(document.getElementById('periodo').value.length < 1){
		alert('Porfavor Seleccione Periodo');
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
	<td>Tipo Informe</td>
	<td>
	<select name="tipo" id="tipo">
		<option value="">Seleccionar</option>>
		<option value="01" <?php if($_POST['tipo']=='01')echo "selected"?>>Insertar</option>
		<option value="02" <?php if($_POST['tipo']=='02')echo "selected"?>>Informe</option>
	</select>
	</td>
</tr>
</table>
<input name="Enviar" type="submit" value="Enviar">
</form>
<?php
//phpinfo();
error_reporting(2047);
ini_set('memory_limit','32M');
$rutaado=("../serviciosacademicos/funciones/adodb_mod/");
require_once('../serviciosacademicos/Connections/salaado-pear.php');
require_once('../serviciosacademicos/Connections/snies_conexion_postgresql.php');
require_once('../serviciosacademicos/funciones/clases/motor/motor.php');
require_once('funciones/obtener_datos.php');
echo date("Y-m-d H:i:s"),"\n\n";
if(!empty($_POST['annio'])){

	//$sala->debug=true;
	//$snies_conexion->debug=true;
	$indiceperiodo=$_POST['periodo']-0;
	$codigoperiodo=$_POST['annio'].$indiceperiodo;
	$snies = new snies($sala,$codigoperiodo);
	$array_egresado=$snies->estudiante_egresado($codigoperiodo);
	$snies->asignaConexionPostgreSQL(&$snies_conexion);
	if($_POST['tipo']=="01"){

	if(isset($_GET['tabla']))
	{
		$snies->tabla($array_egresado);
	}
		foreach ($array_egresado as $llave => $valor)
		{
				echo $query_obtener_consecutivo_bd_externa="SELECT pro_consecutivo FROM programa WHERE prog_code='".$valor['PROG_CODE']."'";
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
				$fila['ins_annio']=$valor['INS_ANNIO'];
				$fila['ins_semestre']=$valor['INS_SEMESTRE'];
				$fila['codigo_unico']=$valor['CODIGO_UNICO'];
				$fila['departamento']=11;
				$fila['municipio']=11001;
				$fila['codigo_ent_aula']=1729;
				$fila['tipo_doc_unico']=$valor['TIPO_DOC_UNICO'];
				$fila['pro_consecutivo']=$pro_consecutivo;
				$snies->ingresar_actualizar_fila_bd($snies_conexion,"egresado",$fila,"codigo_unico",$fila['codigo_unico'],"");
				unset($fila);
		}
		echo "cant registros insertados: $snies->contador_inserta\n\n";
		echo "cant registros actualizados: $snies->contador_actualiza\n\n";
	}
	else
	{
	
		echo $query="SELECT * FROM egresado where ins_annio='".$_POST['annio']."' and  ins_semestre='".$_POST['periodo']."'";
		$operacion=$snies_conexion->query($query);
		while ($row_operacion=$operacion->fetchRow()){
			$array_datos[]=$row_operacion;		
		}
		$motor = new matriz($array_datos);
		$motor->mostrar();
	}

}
?>
