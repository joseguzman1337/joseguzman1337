<?php
/*
* Caso 90158
* @modified Luis Dario Gualteros 
* <castroluisd@unbosque.edu.co>
 * Se modifica la variable session_start por la session_start( ) ya que es la funcion la que contiene el valor de la variable $_SESSION.
 * @since Mayo 18 de 2017
*/
session_start( );
//End Caso  90158
include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

ini_set('max_execution_time','6000');

?>
<link rel="stylesheet" type="text/css" href="../estilos/sala.css">
<style>
    button, select ,input[type="submit"], input[type="reset"], input[type="button"], .button {
    background-color: #ECF1F4;
    background-image: url("../../../../index.php?entryPoint=getImage&themeName=Sugar5&imageName=bgBtn.gif");
    border-color: #ABC3D7;
    color: #000000;
}
</style>
<script LANGUAGE="JavaScript">
	function  ventanaprincipal(pagina) {
		opener.focus();
		opener.location.href=pagina.href;
		window.close();
		return false;
	}
	function reCarga() {
		document.location.href="<?php echo 'consulta_egresado.php'; ?>";
	}
	function regresarGET() {
		document.location.href="<?php echo 'consulta_egresado.php'; ?>";
	}
	function enviarmenu() {
		form3.action="";
		form3.submit();
	}
</script>

<table align="center" width="50%" style="" >
    <tr><td colspan="3">
            <div id="studiofields">
        <input class="button" type="button" onclick="document.location ='admin_egresado.php'" value="Regresar" name="addfieldbtn"/>
        </div>
        </td></tr>
    <tr><td colspan="3">Informacion General de Egresados<hr></td></tr>
    <tr><td colspan="3">
<?php
$rutaado = ("../funciones/adodb/");
require_once(realpath(dirname(__FILE__))."/../funciones/clases/motorv2/motor.php");
require_once(realpath(dirname(__FILE__))."/../Connections/salaado-pear.php");
require_once(realpath(dirname(__FILE__))."/../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once(realpath(dirname(__FILE__))."/../funciones/clases/formulario/clase_formulario.php");
require_once(realpath(dirname(__FILE__))."/../funciones/sala_genericas/FuncionesCadena.php");
require_once(realpath(dirname(__FILE__))."/../funciones/sala_genericas/FuncionesFecha.php");
require_once(realpath(dirname(__FILE__))."/../funciones/sala_genericas/FuncionesMatriz.php");
require_once(realpath(dirname(__FILE__))."/../funciones/sala_genericas/formulariobaseestudiante.php");
require_once(realpath(dirname(__FILE__))."/../funciones/sala_genericas/clasebasesdedatosgeneral.php");

$objetobase = new BaseDeDatosGeneral($sala);
$formulario = new formulariobaseestudiante($sala, 'form2', 'post', '', 'true');

function determinaEstado($arreglo,$caracter,$objetobase) {
    $query = "select * from label where table_name = 'egresado_ext' and status = 1;";
    $operacion = $objetobase->conexion->query($query);
    while ($row_operacion = $operacion->fetchRow()) {
        $labels .=" ".$row_operacion['field']. ",";
        $elelmentos[] = $row_operacion['field'];
    }
    $cont = 0;
    $labels = "select distinct ". substr ($labels, 0, strlen($labels) - 1);
    $labels.=" from egresado_ext ee where ee.codigoestudiante ='".  $arreglo['idestudiantegeneral']."'";
    $operacion = $objetobase->conexion->query($labels);
    while ($row_operacion = $operacion->fetchRow()) {
        if(is_array($row_operacion)){
            foreach ($row_operacion as $values){ if ($values !='')$cont++;}
        }
        
       //if ($row_operacion['field']!='') $cont++;
    //echo $cont2++;
    }
     //   echo $cont;
    if($cont < count($elelmentos)/2)$imagen="rojo.gif";
    if($cont>=count($elelmentos)/2)$imagen="amarillo.gif";
    if($cont==count($elelmentos))$imagen="verde.gif";
	
    return $imagen;
}

if ($_REQUEST['codigocarreraaux'] || $_REQUEST['numerodocumentoaux']) {
	$_SESSION['codigocarreraaux']=$_REQUEST['codigocarreraaux'];
	$_SESSION['numerodocumentoaux']=$_REQUEST['numerodocumentoaux'];
}

$siglanoregistro="S/A";
$query = "select * from label where table_name = 'egresado' and status = 1;";
$operacion = $objetobase->conexion->query($query);
while ($row_operacion = $operacion->fetchRow()) {
    $labels .=" case when ee.".$row_operacion['field']." is null or trim(ee.".$row_operacion['field'].")='0' or trim(ee.".$row_operacion['field'].")=''
			then '$siglanoregistro'
			else ee.".$row_operacion['field']."
		 end as '".$row_operacion['label_field']."' ,";
    $elelmentos[] = $row_operacion['label_field'];
}
$labels = "select distinct ". substr ($labels, 0, strlen($labels) - 1);

$query = $labels ." from estudiante e
	join estudiantegeneral eg on e.idestudiantegeneral=eg.idestudiantegeneral
	join (select codigoestudiante,fechagradoregistrograduado as fechagrado from registrograduado union select codigoestudiante,fechagradoregistrograduadoantiguo as fechagrado from registrograduadoantiguo) as sub on e.codigoestudiante=sub.codigoestudiante
	left join ciudad c on eg.ciudadresidenciaestudiantegeneral=c.idciudad
	left join egresado ee on eg.idestudiantegeneral=ee.idestudiantegeneral ";

if ($_SESSION['numerodocumentoaux']!='')
	$query.=" WHERE eg.numerodocumento=trim(".$_SESSION['numerodocumentoaux'].")";
else
	$query.=" WHERE codigocarrera=".$_SESSION['codigocarreraaux'];
$query.=" ORDER BY eg. numerodocumento";
//echo $query;
$operacion = $objetobase->conexion->query($query);
$i=0;
while ($row_operacion = $operacion->fetchRow()) {        
	$array_interno[$i]['Estado']		= "<img src='img/imagesAlt2/".determinaEstado($row_operacion,$siglanoregistro,$objetobase)."'>";
        foreach ($elelmentos as $element){
            $array_interno[$i][''.$element.'']= $row_operacion[''.$element.''];
            if ($element=='Numero documento')
                $array_interno[$i][''.$element.'']= "<a href='encuesta_egresado.php?idestudiantegeneral=".$row_operacion['idestudiantegeneral']."'>".$row_operacion[''.$element.'']."</a>";
        }
	$i++;
}

$motor = new matriz($array_interno, "MATERIAS DEL PROGRAMA ", "consulta_egresado.php", 'si', 'si', 'consulta_egresado.php', '', false, "si", "../../../");
//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"

$motor->botonRecargar = false;
$motor->botonRegresar = true;
//$motor->agregar_llaves_totales('Cotizacion_ARP',"","","totales","","codigoestudiante","","xx",true);
$motor->mostrar();

?>
        </tr>
</table>
