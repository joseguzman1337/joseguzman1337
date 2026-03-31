<script language="javascript">
function validar(){

	//var largoannio=document.getElementById('annio').value.length+0;
	//if(largoannio < 1){
		//alert('Porfavor Digite Año');
	//}
	//alert("Entro2="+largoannio;
	//else if(document.getElementById('periodo').value.length < 1){
		//alert('Porfavor Seleccione Periodo');
	//}
if(document.getElementById('accion').value.length < 1){
		alert('Porfavor Seleccione Accion');
	}
	else{
		document.getElementById('form1').submit();
	}
}
</script>
<form name="form1" id="form1" action="" method="POST">
<table>
<!--<tr>
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
</tr>-->
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
<tr>
	<td>Tipo</td>
	<td>
	<select name="tipo" id="tipo">
		<option value="2" <?php if($_POST['tipo']=='1')echo "selected"?>>Plan estudio</option>
	</select>
	</td>
</tr>

</table>
<input name="Enviar" type="button" value="Enviar" onclick="validar()">
</form>
<?php
print_r($_POST);
error_reporting(0);
ini_set('memory_limit','32M');
ini_set('pgsql.ignore_notice','1');
ini_set('pgsql.log_notice','0');
$rutaado=("../serviciosacademicos/funciones/adodb_mod/");
require_once('Excel/reader.php');
require_once('../serviciosacademicos/Connections/salaado-pear.php');
require_once('../serviciosacademicos/Connections/snies_conexion_postgresql.php');
require_once('../serviciosacademicos/funciones/clases/motor/motor.php');
require_once('funciones/obtener_datos.php');
$sala->debug=true;
$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('UTF-8');
$data->read("archivos/planestudiocursoplan.xls");
echo count($data->sheets[0]['cells'])-1,"<br>";
//DibujarTabla($data->sheets[0]['cells']);
echo "<pre>";
//print_r($data->sheets[0]['cellsInfo']);
echo "</pre>";
//se ingresa en participantes los datos basicos, para luego ingresar las autoridades (integridad ref)
$i=0;
if($_POST['accion']=='2')
foreach ($data->sheets[0]['cells'] as $llave => $valor)
{
	$fila['ies_code']=$valor[2];	
	$fila['fecha_vigencia']=$valor[4];
	//$paginaunbosqueplan="https://www.unbosque.edu.co/serviciosacademicos/consulta/facultades/planestudio/planestudiounbosque.php?planestudio=".$valor[7]."&visualizado";
	$fila['url_plan']=$paginaunbosqueplan;
	$fila['min_num_cred']=$valor[5];
	if(trim($valor[6])=='')
	$valor[6]=0;
	
	$fila['min_num_cred_el']=$valor[6];
	$fila['pro_consecutivo']=$valor[1];

	//$fila['puntaje_ecaes']='0';
$array_muestra[]=$fila;
	if($_POST['accion']=='2'){
		insertar_fila_bd($snies_conexion,'plan_estudios',$fila);
	}
echo "$i<pre>";
print_r($fila);
echo "</pre>";
	unset($fila);
$i++;
}
$motor = new matriz($array_muestra);
$motor->mostrar();
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