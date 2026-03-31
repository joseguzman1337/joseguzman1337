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
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
ini_set('display_errors', E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);

error_reporting(2047);
ini_set('memory_limit','32M');
ini_set('max_execution_time','216000');
$rutaado=("../serviciosacademicos/funciones/adodb_mod/");
require_once('../serviciosacademicos/Connections/salaado-pear.php');
require_once('../serviciosacademicos/Connections/snies_conexion_postgresql.php');
require_once('../serviciosacademicos/funciones/clases/motor/motor.php');
require_once('funciones/obtener_datos.php');
echo date("Y-m-d H:i:s"),"\n\n";

if(!empty($_POST['annio']) and !empty($_POST['periodo'])){

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
	$codigoperiodo=$_POST['annio'].$_POST['periodo'];

	$sala->debug=false;
	$snies_conexion->debug=true;
	$snies = new snies($sala,$codigoperiodo);
	$snies->asignaConexionPostgreSQL($snies_conexion);
	$array_inscrito=$snies->codigoestudiante_inscrito($codigoperiodo);


	echo "<h1>".count($array_inscrito)." registros reportados</h1>";

	if($_POST['accion']=='2'){
		foreach ($array_inscrito as $llave => $valor)

		{
                    echo "<h1>".count($array_inscrito)." registros reportados</h1>";
			$array_datos_inscrito=$snies->datos_participante($valor['codigoestudiante']);
			$numerocarreraregistro=$snies->carreraregistro($valor['codigocarrera']);
                         $semestre="0".substr($codigoperiodo,4,5);
                                        $annio=substr($codigoperiodo,0,4);
			//if(!empty($numeroregistrocarreraregistro)){
                      echo "<h1>$llave registros reportados</h1>";
                                         echo"<pre>";
         print_r($array_datos_inscrito);

	echo"</pre>";
        		echo $query_pro_consecutivo="SELECT p.pro_consecutivo,cp.cod_entidad_aula FROM programa p,cubrimiento_programa cp
                                        WHERE p.pro_consecutivo=cp.pro_consecutivo and prog_code='$numerocarreraregistro'and
                                         annio='$annio'and semestre='$semestre'";
				$operacion_pro_consecutivo=$snies_conexion->query($query_pro_consecutivo);
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
			//}
			//else{
				//$pro_consecutivo=111111;
			//}
			$query="SELECT * FROM cubrimiento_programa where pro_consecutivo=".$pro_consecutivo." limit 1";
			$operacion=$snies_conexion->query($query);
			$row_cubrimiento_programa=$operacion->fetchRow();

				$fila['ies_code']=$row_cubrimiento_programa['ies_code'];
				$fila['annio']=$_POST['annio'];
					$fila['semestre']="0".$_POST['periodo'];
					$fila['tipo_cubrim_code']=$row_cubrimiento_programa['tipo_cubrim_code'];
					$fila['departamento']=$row_cubrimiento_programa['departamento'];
					$fila['municipio']=$row_cubrimiento_programa['municipio'];
					$fila['cod_entidad_aula']=$row_pro_consecutivo['cod_entidad_aula'];
					$fila['metodologia_code']=$row_cubrimiento_programa['metodologia_code'];
					$fila['pro_consecutivo']=$row_cubrimiento_programa['pro_consecutivo'];
					//$snies->insertar_fila_bd($snies_conexion,'cubrimiento_programa',$fila);
					unset($fila);

			$fila['ies_code']=$array_datos_inscrito['IES_CODE'];
			$fila['ins_annio']=substr($codigoperiodo,0,4);
			$fila['ins_semestre']='0'.$_POST['periodo'];
			$fila['tipo_ident_code']=$array_datos_inscrito['TIPO_DOC_UNICO'];
			$fila['documento']=$array_datos_inscrito['CODIGO_UNICO'];
			$fila['segundo_apellido']=sanear_string($array_datos_inscrito['SEGUNDO_APELLIDO']);
			$fila['prog_prim_opc']=$pro_consecutivo;
			$fila['prog_seg_opc']=111111;
			$fila['prog_terc_opc']=111111;
			$fila['snp']=0;
			$fila['genero']=$array_datos_inscrito['GENERO_CODE'];
			$fila['primer_nombre']=sanear_string($array_datos_inscrito['PRIMER_NOMBRE']);
			$fila['segundo_nombre']=sanear_string($array_datos_inscrito['SEGUNDO_NOMBRE']);
			$fila['primer_apellido']=sanear_string($array_datos_inscrito['PRIMER_APELLIDO']);
			$fila['codigo_ent_aula']=$row_pro_consecutivo['cod_entidad_aula'];
			$fila['departamento']=11;//$valor['DEPARTAMENTO'];
			$fila['municipio']=11001;//$snies->leerMunicioBDSNIES($valor['DEPARTAMENTO']);
			$snies->insertar_fila_bd($snies_conexion,"inscrito",$fila);

			unset($fila);
			unset($array_datos_inscrito);
			unset($pro_consecutivo);
		
                }
		echo "cant registros insertados: $snies->contador_inserta\n\n";
		echo "cant registros actualizados: $snies->contador_actualiza\n\n";
		if(isset($_GET['tabla']))
		{
			$motor = new matriz($array_trans_ok);
			$motor->mostrar();
		}
	}
	else{
		$query="SELECT * FROM inscrito where ins_annio='".$_POST['annio']."' and ins_semestre='0".$_POST['periodo']."'";
		$operacion=$snies_conexion->query($query);
		while ($row_operacion=$operacion->fetchRow()){
		$array_datos[]=$row_operacion;		
		}
			$motor = new matriz($array_datos);
			$motor->mostrar();

	}
	
}
?>

