<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
//session_start();
require_once('../../../Connections/sala2.php' );
$salatmp=$sala;
require_once("../../../funciones/funciontiempo.php");
require_once("../../../funciones/funcionip.php");
$rutaado=("../../../funciones/adodb/");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/sala_genericas/DatosGenerales.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/clases/motorv2/motor.php");
$rutaorden = "../../../funciones/ordenpago/";
$ruta = "../../../funciones/";
require_once('../../../funciones/ordenpago/claseordenpago.php');

$objetobase=new BaseDeDatosGeneral($sala);


/*echo "<pre>";
print_r($_REQUEST);
echo "</pre>";

echo "<pre>";
print_r($_SESSION);
echo "</pre>";


exit();*/

$codigoestudiante=unserialize(stripslashes($_REQUEST['estudiante']));

$cuenta=count($codigoestudiante);

if($cuenta==0){
echo '<script language="JavaScript">alert("No existen ordenes para procesar, por favor seleccione al menos un estudiante.")
window.close();
</script>';
}

/*Creacion de la variable contador*/
if(isset($_REQUEST['contador'])){
$i=$_REQUEST['contador'];
}
else{
$i=0;
}

/*condicion con la cantidad de chinos*/
if($i<$cuenta){
//echo "entra ".$i."<br>";
//echo $codigoestudiante[$i];
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
    </head>
    <body>
        <form action=""  name="form1" method="GET">
            <table  border="0" cellpadding="3" cellspacing="3" align="center">
                <TR>
                    <TD align="center">
                        <label id="labelresaltadogrande" >GENERACIÓN ORDENES COLEGIO</label>
                    </TD>
                </TR>
                <TR>
                    <TD align="center">
                        <img  src="cargando.gif"  >
                    </TD>
                </TR>
                <TR>
                    <TD align="justify"><label id="labelresaltadogrande">Un momento por favor se esta ejecutando el proceso de creación de las ordenes de pensión.<br>Por favor No cierre esta ventana.</label>
                    </TD>
                </TR>
            </table>
        </form>
    </body>
</html>
<?php
$tablas="facturavalorpecuniario f, detallefacturavalorpecuniario df, valorpecuniario v, estudiante e, concepto c, referenciaconcepto r";

$ordenesxestudiante = new Ordenesestudiante($salatmp, $codigoestudiante[$i], $_SESSION['codigoperiodoordenescolegio']);

$condicion=" and f.codigocarrera = e.codigocarrera
        and df.idfacturavalorpecuniario = f.idfacturavalorpecuniario
        and v.idvalorpecuniario = df.idvalorpecuniario
        and f.codigoperiodo = '".$_SESSION['codigoperiodoordenescolegio']."'
        and f.codigoperiodo = v.codigoperiodo
        and e.codigotipoestudiante = df.codigotipoestudiante
        and e.codigoestudiante = '".$codigoestudiante[$i]."'
        and c.codigoconcepto = v.codigoconcepto
        and c.codigoreferenciaconcepto = r.codigoreferenciaconcepto
         and df.codigoestado like '1%'";


$datosconcepto=$objetobase->recuperar_datos_tabla($tablas,"c.codigoconcepto",$_REQUEST['codigoconcepto'],$condicion,"",1);

//echo "<br>ordenpago=".$ordenesxestudiante->ordenesdepago['numeroordenpago']."=";
$cantidades[$_REQUEST['codigoconcepto']]='1';
$conceptos1[0]=$_REQUEST['codigoconcepto'];

if(!isset($_REQUEST['fechapago'])||trim($_REQUEST['fechapago'])==''){
        //echo "<h1>generarordenpago_conceptoscantidad</h1>";
        $ordenesxestudiante->generarordenpago_conceptoscantidad($conceptos1, $cantidades, "Generacion masiva colegio");
        }
        else{
        $cantidadfecha[$_REQUEST['codigoconcepto']]=$datosconcepto['valorpecuniario'];
        //echo "<h1>generarordenpago_conceptos_fecha ".formato_fecha_mysql($_POST['fechapago'])."</h1>";
        $ordenesxestudiante->generarordenpago_conceptos_fecha($conceptos1, $cantidadfecha,formato_fecha_mysql($_REQUEST['fechapago']));
        }

        $tablasfechaentrega = "estudiante e,ordenpago o,detalleordenpago do";
        $condicion=" and do.numeroordenpago=o.numeroordenpago and
        e.codigoestudiante=o.codigoestudiante and
        e.codigoestudiante=".$codigoestudiante[$i]." and
        o.codigoestadoordenpago like '1%'
        group by e.codigoestudiante
        ";
        $datosconcepto=$objetobase->recuperar_datos_tabla($tablasfechaentrega,"do.codigoconcepto",$_REQUEST['codigoconcepto'],$condicion,",max(o.numeroordenpago) maxnumeroordenpago",0);
        unset($fila);
        $fila['fechaentregaordenpago']=formato_fecha_mysql("01/".$_REQUEST['mesorden']);
        $objetobase->actualizar_fila_bd("ordenpago",$fila,"numeroordenpago",$datosconcepto['maxnumeroordenpago'],'',0);

$i++;
//sleep(8);
/*echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=envioordenescolegio.php?contador=$i&estudiante=".serialize($codigoestudiante)."&codigoconcepto=".$_REQUEST['codigoconcepto']."&fechapago=".$_REQUEST['fechapago']."&mesorden=".$_REQUEST['mesorden']."'>";*/
echo "<script languaje='text/javascript'>
        window.location.href='envioordenescolegio.php?contador=$i&estudiante=".$_REQUEST['estudiante']."&codigoconcepto=".$_REQUEST['codigoconcepto']."&fechapago=".$_REQUEST['fechapago']."&mesorden=".$_REQUEST['mesorden']."'
    </script>";
}
else{
alerta_javascript("Se han Creado $i ordenes de pensión");
echo '<script language="JavaScript">window.close();
</script>';

}
?>
