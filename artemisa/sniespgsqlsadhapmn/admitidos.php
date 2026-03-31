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
print_r($_POST);
error_reporting(0);
ini_set('memory_limit','32M');
ini_set('pgsql.ignore_notice','1');
ini_set('pgsql.log_notice','0');
$rutaado=("../serviciosacademicos/funciones/adodb_mod/");
require_once('../serviciosacademicos/Connections/salaado-pear.php');
require_once('../serviciosacademicos/Connections/snies_conexion_postgresql.php');
require_once('../serviciosacademicos/funciones/clases/motor/motor.php');
require_once('funciones/obtener_datos.php');
//$sala->$ADODB_ASSOC_CASE=1;
echo date("Y-m-d H:i:s"),"\n\n";
//$sala->debug=true;
//pgsql.ignore_notice();
//$snies_conexion->debug=true;
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

	$snies = new snies($sala,$codigoperiodo);
	$array_admitido=$snies->codigoestudiante_admitido($codigoperiodo);



	echo "<h1>".count($array_admitido)." registros reportados</h1><br>";


	//if($_POST['accion']=='2'){
		foreach ($array_admitido as $llave => $valor)
		{
			$array_datos_inscrito=$snies->datos_participante($valor['codigoestudiante']);
                      $numerocarreraregistro=$snies->carreraregistro($valor['codigocarrera']);
                         $semestre="0".substr($codigoperiodo,4,5);
                                        $annio=substr($codigoperiodo,0,4);

			$query_pro_consecutivo="SELECT p.pro_consecutivo,cp.cod_entidad_aula FROM programa p,cubrimiento_programa cp
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

			$fila['tipo_identif']=$array_datos_inscrito['TIPO_DOC_UNICO'];
			$fila['documento']=$array_datos_inscrito['CODIGO_UNICO'];
			$fila['segundo_apellido']=sanear_string($array_datos_inscrito['SEGUNDO_APELLIDO']);
			$fila['pro_consecutivo']=$pro_consecutivo;
			$fila['snp']=1; //la relacion
			$fila['fecha_snp']='1900-01-01';
			$fila['ies_code']='1729';
			$fila['adm_annio']=substr($codigoperiodo,0,4);
			$fila['adm_semestre']="0".substr($codigoperiodo,4,5);
			$fila['departamento']=11;
			$fila['municipio']=11001;
			$fila['primer_nombre']=sanear_string($array_datos_inscrito['PRIMER_NOMBRE']);
			$fila['segundo_nombre']=sanear_string($array_datos_inscrito['SEGUNDO_NOMBRE']);
			$fila['primer_apellido']=sanear_string($array_datos_inscrito['PRIMER_APELLIDO']);
			$fila['codigo_ent_aula']='1729';
			$fila['genero']=$array_datos_inscrito['GENERO_CODE'];
			$array_admitido_fila[]=$fila;
			
			if($_POST['accion']=='2')
			$snies->insertar_fila_bd($snies_conexion,"admitido",$fila);
			
			
			$filains['ies_code']=$array_datos_inscrito['IES_CODE'];
			$filains['ins_annio']=substr($codigoperiodo,0,4);
			$filains['ins_semestre']='0'.$_POST['periodo'];
			$filains['tipo_ident_code']=$array_datos_inscrito['TIPO_DOC_UNICO'];
			$filains['documento']=$array_datos_inscrito['CODIGO_UNICO'];
			$filains['segundo_apellido']=sanear_string($array_datos_inscrito['SEGUNDO_APELLIDO']);
			$filains['prog_prim_opc']=$pro_consecutivo;
			$filains['prog_seg_opc']=111111;
			$filains['prog_terc_opc']=111111;
			$filains['snp']=0;
			$filains['genero']=$array_datos_inscrito['GENERO_CODE'];
			$filains['primer_nombre']=sanear_string($array_datos_inscrito['PRIMER_NOMBRE']);
			$filains['segundo_nombre']=sanear_string($array_datos_inscrito['SEGUNDO_NOMBRE']);
			$filains['primer_apellido']=sanear_string($array_datos_inscrito['PRIMER_APELLIDO']);
			$filains['codigo_ent_aula']='1729';
			$filains['departamento']=11;//$valor['DEPARTAMENTO'];
			$filains['municipio']=11001;//$snies->leerMunicioBDSNIES($valor['DEPARTAMENTO']);

			if($_POST['accion']=='2')
			$snies->insertar_fila_bd($snies_conexion,"inscrito",$filains);

			//$snies->ingresar_actualizar_fila_bd($snies_conexion,"admitido",$fila,"documento",$fila['documento'],"");
			unset($fila);
			unset($pro_consecutivo);
			unset($array_datos_inscrito);
		}

		echo "cant registros insertados: $snies->contador_inserta\n\n";
		echo "cant registros actualizados: $snies->contador_actualiza\n\n";
	//}
}
if(isset($array_admitido_fila))
if(is_array($array_admitido_fila))
{
	$motor = new matriz($array_admitido_fila);
	$motor->mostrar();
}

?>

