<?php 
session_start();
$rol=$_SESSION['rol'];
//$_SESSION['MM_Username']='admintecnologia';
//print_r($_SESSION);
$rutaado=("../../funciones/adodb/");
require_once("../../funciones/clases/debug/SADebug.php");
require_once("../../Connections/salaado-pear.php");
require_once("../../funciones/clases/formulario/clase_formulario.php");
require_once("../../funciones/phpmailer/class.phpmailer.php");
require_once("../../funciones/validaciones/validaciongenerica.php");
require_once("../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("funciones/FuncionesAportes.php");

$objetobase=new BaseDeDatosGeneral($sala);

?>

<?php
require_once('../../funciones/sala_genericas/ajax/json.php');
$json = new Services_JSON();

$condicion="and codigoestado like '1%' 
				and '".formato_fecha_mysql($_GET['fechainicio'])."' between fechainicionovedadarp and fechafinalnovedadarp";
if($_GET['ingresado']==3)
    $novedad=$objetobase->recuperar_datos_tabla("novedadarp","nombrecortonovedadarp","REA",$condicion,"",0);
$novedadeps=$objetobase->recuperar_datos_tabla("novedadarp","nombrecortonovedadarp","RET",$condicion,"",0);
//	else
//	$novedad=$objetobase->recuperar_datos_tabla("novedadarp","nombrecortonovedadarp","INX",$condicion,"",1);
$condicion=" and ed.numerodocumento=eg.numerodocumento";
$estudiantedocumento=$objetobase->recuperar_datos_tabla("estudiantegeneral eg, estudiantedocumento ed","eg.idestudiantegeneral",$_GET["idestudiantegeneral"],$condicion,"",0);


$tabla="estudiantenovedadarp";
//Fila de Ingreso de novedad 
$fila["idestudiantegeneral"]=$_GET["idestudiantegeneral"];
$fila["idnovedadarp"]=$novedad['idnovedadarp'];
$fila["fechaestudiantenovedadarp"]=formato_fecha_mysql(date("d/m/Y"));
$fila["fechainicioestudiantenovedadarp"]=formato_fecha_mysql($_GET['fechainicio']);
//$mesinicio=$_POST['fechainicio'][3].$_POST['fechainicio'][4];
$fila["fechafinalestudiantenovedadarp"]="2099-01-01";
//$mesfinal=$_POST['fechafinal'][3].$_POST['fechafinal'][4];
$fila["observacionnovedadarp"]="";

if($_GET["idempresasalud"]==1)
    $fila["codigoestado"]=200;
else
    $fila["codigoestado"]=100;

$fila["numerodocumentonovedadarp"]="";
$fila["idestudiantenovedadarporigen"]=0;
$fila["idempresasalud"]=$_GET["idempresasalud"];
$fila["idestudiantedocumento"]=$estudiantedocumento["idestudiantedocumento"];
/*
echo "fila<pre>";
print_r($fila);
echo "</pre>";
 *
 */
//Ingreso de primera vez de la eps
$condicion="and en.codigoestado like '1%' and 
				no.idnovedadarp = en.idnovedadarp and 
				no.codigotiponovedadarp like '1%' and
				no.codigotipoaplicacionnovedadarp like '2%' and
				('".formato_fecha_mysql($_GET['fechainicio'])."' between en.fechainicioestudiantenovedadarp and en.fechafinalestudiantenovedadarp)";
$datosnovedadvigente=$objetobase->recuperar_datos_tabla("estudiantenovedadarp en, novedadarp no","en.idestudiantegeneral",$_GET["idestudiantegeneral"],$condicion,', en.fechainicioestudiantenovedadarp inicionovedadarp',1);

$condicion="and en.codigoestado like '1%' and
				no.idnovedadarp = en.idnovedadarp and
				no.codigotiponovedadarp like '1%' and
				no.codigotipoaplicacionnovedadarp like '1%' and
				('".formato_fecha_mysql($_GET['fechainicio'])."' between en.fechainicioestudiantenovedadarp and en.fechafinalestudiantenovedadarp)";
$datosepsnovedad=$objetobase->recuperar_datos_tabla("estudiantenovedadarp en, novedadarp no","en.idestudiantegeneral",$_GET["idestudiantegeneral"],$condicion,', en.fechainicioestudiantenovedadarp inicionovedadarp',1);


$idtablavencida=$datosnovedadvigente['idestudiantenovedadarp'];
$idtablavencidaeps=$datosepsnovedad['idestudiantenovedadarp'];
$fechainiciovencida=$datosnovedadvigente['inicionovedadarp'];
if(isset($idtablavencida)&&($idtablavencida!=''))
    $fila["idestudiantenovedadarporigen"]=$idtablavencida;
$fechainiciovector=vector_fecha($_GET['fechainicio']);
$filavencida['fechafinalestudiantenovedadarp']=formato_fecha_mysql(agregarceros(($fechainiciovector["dia"]-1),2)."/".agregarceros($fechainiciovector["mes"],2)."/".$fechainiciovector["anio"]);

$objetobase->actualizar_fila_bd($tabla,$filavencida,'idestudiantenovedadarp',$idtablavencida);
$fila["idestudiantenovedadarporigen"]=$idtablavencidaeps;
$objetobase->actualizar_fila_bd($tabla,$filavencida,'idestudiantenovedadarp',$idtablavencidaeps);


//if((isset($_POST['epsnueva']))&&($_POST['epsnueva']!="")){
//$fila["idempresasalud"]=$_POST['epsnueva'];
//}
$finalmes=final_mes_fecha(date("d/m/Y"));	
//if($datosnovedad2=datos_novedad_vigente($mes,$datosestudiante['idestudiantegeneral'],$objetobase,"INA")){
//$ingarpvigente=1;

$condicionactualiza="idestudiantegeneral=".$fila['idestudiantegeneral'].
        " and fechainicioestudiantenovedadarp='".$fila["fechainicioestudiantenovedadarp"].
        "' and fechafinalestudiantenovedadarp='".$fila["fechafinalestudiantenovedadarp"].
        "' and idnovedadarp='".$fila["idnovedadarp"]."'";
$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
//}

$fila["idnovedadarp"]=$novedadeps['idnovedadarp'];
$fila["idempresasalud"]=$datosepsnovedad["idempresasalud"];

$condicionactualiza="idestudiantegeneral=".$fila['idestudiantegeneral'].
        " and fechainicioestudiantenovedadarp='".$fila["fechainicioestudiantenovedadarp"].
        "' and fechafinalestudiantenovedadarp='".$fila["fechafinalestudiantenovedadarp"].
        "' and idnovedadarp='".$fila["idnovedadarp"]."'";
$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
?>