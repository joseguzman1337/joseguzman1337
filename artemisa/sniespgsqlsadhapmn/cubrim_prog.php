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
$rutaado=("../serviciosacademicos/funciones/adodb_mod/");
require_once('../serviciosacademicos/Connections/salaado-pear.php');
require_once('../serviciosacademicos/Connections/snies_conexion_postgresql.php');
require_once('../serviciosacademicos/funciones/clases/motor/motor.php');
require_once('funciones/obtener_datos.php');
//$sala->$ADODB_ASSOC_CASE=1;
if(!empty($_POST['annio']) and !empty($_POST['periodo'])){

echo date("Y-m-d H:i:s"),"\n\n";
$sala->SetFetchMode(ADODB_FETCH_NUM);
//$sala->debug=true;
$snies_conexion->debug=true;
$query="SELECT * FROM cubrimiento_programa";
$operacion=$snies_conexion->query($query);
$row_operacion=$operacion->fetchRow();
	if($_POST['accion']=="2"){
		echo "ENTRO?";
		do
		{
			$fila['ies_code']=$row_operacion['ies_code'];
			$fila['annio']=$_POST['annio'];
			$fila['semestre']="0".$_POST['periodo'];
			$fila['tipo_cubrim_code']=$row_operacion['tipo_cubrim_code'];
			$fila['departamento']=$row_operacion['departamento'];
			$fila['municipio']=$row_operacion['municipio'];
			$fila['cod_entidad_aula']=$row_operacion['cod_entidad_aula'];
			$fila['metodologia_code']=$row_operacion['metodologia_code'];
			$fila['pro_consecutivo']=$row_operacion['pro_consecutivo'];
		
			insertar_fila_bd(&$snies_conexion,'cubrimiento_programa',$fila);
		}
		while ($row_operacion=$operacion->fetchRow());
		
		echo "registros insertados ".$contador_inserta;
		
		
			$fila['ies_code']=$row_operacion['ies_code'];
			$fila['annio']=$_POST['annio'];
			$fila['semestre']=$_POST['periodo'];
			$fila['tipo_cubrim_code']=$row_operacion['tipo_cubrim_code'];
			$fila['departamento']=$row_operacion['departamento'];
			$fila['municipio']=$row_operacion['municipio'];
			$fila['cod_entidad_aula']=$row_operacion['cod_entidad_aula'];
			$fila['metodologia_code']=$row_operacion['metodologia_code'];
			$fila['pro_consecutivo']=$row_operacion['pro_consecutivo'];
		
	}
	else
	{
	
		echo $query="SELECT * FROM cubrimiento_programa where annio='".$_POST['annio']."' and semestre='0".$_POST['periodo']."'";
		$operacion=$snies_conexion->query($query);
		while ($row_operacion=$operacion->fetchRow()){
		$array_datos[]=$row_operacion;
		
		}
			$motor = new matriz($array_datos);
			$motor->mostrar();
	}
	
}

function insertar_fila_bd($conexion,$tabla,$fila)
{

	$claves="(";
	$valores="(";
	$i=0;
	while (list ($clave, $val) = each ($fila)) {

		if($i>0){
			$claves .= ",".$clave."";
			$valores .= ",'".$val."'";
		}
		else{
			$claves .= "".$clave."";
			$valores .= "'".$val."'";
		}
		$i++;
	}
	$claves .= ")";
	$valores .= ")";

	$sql="insert into $tabla $claves values $valores";
	$operacion=$conexion->query($sql);

}
?>
