<script language="javascript">
function validar(){

	var largoannio=document.getElementById('annio').value.length+0;

	if(largoannio < 1){
		alert('Porfavor Digite Año');
	}
	//alert("Entro2="+largoannio;

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
	<td height="43">Accion</td>
	<td>
	<select name="accion" id="accion">
		<option value="">Seleccionar</option>>
		<option value="1" <?php if($_POST['accion']=='1')echo "selected"?>>Reportar</option>
		<!--<option value="2" <?php if($_POST['accion']=='2')echo "selected"?>>Insertar</option>-->
	</select>
	</td>
</tr>
<tr>
	<td>Tipo</td>
	<td>
	<select name="tipo" id="tipo">
		<option value="1" <?php if($_POST['tipo']=='1')echo "selected"?>>estudio_docente</option>
<!--		<option value="2" <?php if($_POST['tipo']=='2')echo "selected"?>>Plan estudio</option>
		<option value="3" <?php if($_POST['tipo']=='3')echo "selected"?>>Plan estudio cursos</option>-->
		<option value="4" <?php if($_POST['tipo']=='4')echo "selected"?>>Resumen</option>
		
	</select>
	</td>
</tr>

</table>
<input name="Enviar" type="button" value="Enviar" onclick="validar()">
</form>
<?php
//print_r($_POST);
error_reporting(0);
ini_set('memory_limit','32M');
ini_set('pgsql.ignore_notice','1');
ini_set('pgsql.log_notice','0');
$rutaado=("../serviciosacademicos/funciones/adodb_mod/");
require_once('../serviciosacademicos/Connections/salaado-pear.php');
require_once('../serviciosacademicos/Connections/conexion.php');
require_once('../serviciosacademicos/Connections/snies_conexion_postgresql.php');
require_once('../serviciosacademicos/funciones/clases/motor/motor.php');
require_once('funciones/obtener_datos.php');

if(!empty($_POST['annio']) and !empty($_POST['periodo'])){
	$codigoperiodo=$_POST['annio'].$_POST['periodo'];
	$snies = new snies($sala,$codigoperiodo);
	$snies_conexion->debug=true;
    $cadena="";
	$query="SELECT d.codigo_unico FROM docente_h dh
				,docente d where dh.annio=".$_POST['annio']." and dh.semestre='0".$_POST['periodo']."'
				 and dh.codigo_unico=d.codigo_unico";
	echo "<br>";
    echo $query;
	$operacion=$snies_conexion->query($query);
	$i=0;
	while($row_operacion=$operacion->fetchRow())
    {
    	$row=$snies->docentehojavida($database_conexion,$row_operacion['codigo_unico']);
        //echo '<pre>';
        //print_r($row);
        //$row=docentesdatos($row_operacion['codigo_unico']);
        
			if(is_array($row)){
				$arraydocentetmp["IES_CODE"]="1729";
				$arraydocentetmp["TIPO_DOC_UNICO"]=$row['tipodocumento'];
				$arraydocentetmp["CODIGO_UNICO"]=$row['numerodocumento'];
				$arraydocentetmp["NOMBRE_INST"]=strtoupper(mayusculatilde($row['institucionhistorialacademico']));
				//$arraydocentetmp["CIUDAD"]=$row['lugarhistorialacademico'];
				$arraydocentetmp["PAIS_CODE"]=$row['pais'];
				$arraydocentetmp["PROGRAMA"]=strtoupper(mayusculatilde($row['tituloobtenidohistorialacademico']));
				$arraydocentetmp["COD_PROGRAMA"]='';
				$arraydocentetmp["NBC_CODE"]='14';
				$arraydocentetmp["NIVEL_EST_CODE"]=$row["tipogrado"];
				$arraydocentetmp["FECHA_ECAES"]='01-01-1970';
				$arraydocentetmp["PUNTAJE_ECAES"]='0';
				$array_muestra[]=$arraydocentetmp;
                
				if($i>=0)
  		        insertar_fila_bd($snies_conexion,'estudio_docente',$arraydocentetmp);
				$i++;
			}				

		if(is_array($row))
		foreach($row as $llaves=>$valores){
			if(!ereg('^[0-9]{1,6}$',$llaves)){
			  
			  $rowencabezado[$llaves]=1;
			   $cadena.="<td> ".$valores."</td>";
			   }
		   	}
            $cadena.="</tr>";
    }
    if(is_array($rowencabezado))
	foreach($rowencabezado as $llaves=>$valores){
	   $cadenaencabezado.="<td> ".$llaves."</td>";
	}
   
if($_POST['tipo']=="1"){
   		$motor = new matriz($array_muestra);
		$motor->mostrar();
	}   
   if($_POST['tipo']=="4"){
   	echo "<table>";
	echo "<tr>";
	echo $cadenaencabezado;
	echo "</tr>";
	echo "<tr>";
		 echo $cadena;
	//echo "</tr>";

   	echo "</table>";
	}


	//$array_cursos=$snies->planestudiocursos();
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

	echo $sql="insert into $tabla $claves values $valores";
	$operacion=$conexion->query($sql);

}
function mayusculatilde($palabra){
		$tildes=array("Á","É","Í","Ó","Ú","á","é","í","ó","ú","Ñ","ñ");
		$sintildes=array("A","E","I","O","U","A","E","I","O","U","n","n");
		$nuevacadena=$palabra;
			for($j=0;$j<count($tildes);$j++)
				$nuevacadena=str_replace($tildes[$j],$sintildes[$j],$nuevacadena);
		return $nuevacadena;
	}
    
function docentesdatos(){
    $sql = "SELECT * FROM nivelacademicodocente d, tiponivelacademico t, nucleobasicoareaconocimiento na, pais p, tipoformacion tf WHERE d.iddocente = '3470' AND d.codigoestado LIKE '1%' AND d.idnucleobasicoareaconocimiento = na.idnucleobasicoareaconocimiento
AND d.codigotiponivelacademico = t.codigotiponivelacademico
AND d.idpais = p.idpais
AND d.codigotiponivelacademico NOT IN ('09', '10', '11', '12', '13')
AND d.codigotipoformacion = tf.codigotipoformacion
AND d.codigotipoformacion <> '400'";   
}

?>