<?php 
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../../Connections/sala2.php' );
$salatmp=$sala;
$rutaado=("../../../funciones/adodb/");
require_once("../../../Connections/salaado-pear.php");
$rutaorden = "../../../funciones/ordenpago/";
$ruta = "../../../funciones/";
require_once('../../../funciones/ordenpago/claseordenpago.php');
require_once('../../../funciones/clases/fpdf/fpdf.php');
require_once("../../../funciones/ordenpago/factura_pdf_nueva/funcionfacturas.php");
require_once("../../../funciones/ordenpago/factura_pdf_nueva/funciones/obtener_datos.php");
require_once("../../../funciones/ordenpago/factura_pdf_nueva/funciones/ean128.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");

$objetobase=new BaseDeDatosGeneral($sala);

setlocale(LC_MONETARY, 'en_US');
$fechahoy=date("Y-m-d H:i:s");
$universidad = new ADODB_Active_Record('universidad');
$universidad->Load('iduniversidad = 1');
//////////////////////////////////////////////////
if($_POST['Filtrar']=='Filtrar')
$_POST['estudiante']=$_POST['estudiantetmp'];

/*echo "POST<pre>";
print_r($_POST['estudiante']);
echo "</pre>";*/

for($i=0;$i<count($_POST['estudiante']);$i++){

$select ="select max(fo.fechaordenpago) from estudiante e,fechaordenpago fo,ordenpago o,detalleordenpago do where do.codigoconcepto= '".$_GET['codigoconcepto']."' and do.numeroordenpago=o.numeroordenpago and e.codigoestudiante=o.codigoestudiante and e.codigoestudiante=".$_POST['estudiante'][$i]." and o.codigoestadoordenpago like '1%'and fo.numeroordenpago=o.numeroordenpago group by e.codigoestudiante";

$tablas = "estudiante e,fechaordenpago fo,ordenpago o,detalleordenpago do";
$condicion=" and do.numeroordenpago=o.numeroordenpago and
e.codigoestudiante=o.codigoestudiante and
e.codigoestudiante=".$_POST['estudiante'][$i]." and
o.codigoestadoordenpago like '1%'and
fo.numeroordenpago=o.numeroordenpago and 
fo.fechaordenpago = (".$select.")
group by e.codigoestudiante
";
$datosconcepto=$objetobase->recuperar_datos_tabla($tablas,"do.codigoconcepto",$_GET['codigoconcepto'],$condicion,",max(o.numeroordenpago) maxnumeroordenpago",0);
$numeroordenpagoi[]=$datosconcepto['maxnumeroordenpago'];

//if(isset($datosconcepto['maxnumeroordenpago'])&&$datosconcepto['maxnumeroordenpago']!='')

}
//echo "NUMERO ESTUDIANTES".COUNT($_POST['estudiante']);
ordennespago($_POST['estudiante'],$numeroordenpagoi,$sala);

?>