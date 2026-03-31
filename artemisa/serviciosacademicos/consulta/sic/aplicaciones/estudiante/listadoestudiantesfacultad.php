<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">

<script LANGUAGE="JavaScript">
function  ventanaprincipal(pagina){
opener.focus();
opener.location.href=pagina.href;
window.close();
return false;
}
function reCarga(){
	document.location.href="<?php echo 'listadoestudiantesfacultad.php';?>";
}
function regresarGET()
{
	document.location.href="<?php echo 'menuseguimiento.php';?>";
}

</script>
<?php
$rutaado=("../../../../funciones/adodb/");
require_once(realpath(dirname(__FILE__))."/../../../../Connections/salaado-pear.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/clases/motorv2/motor.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/clases/formulario/clase_formulario.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/phpmailer/class.phpmailer.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/validaciones/validaciongenerica.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/FuncionesSeguridad.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/FuncionesMatematica.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
$objetobase=new BaseDeDatosGeneral($sala);
$formulario=new formulariobaseestudiante($sala,'form2','post','','true');

$query="SELECT eg.idestudiantegeneral,eg.numerodocumento,eg.nombresestudiantegeneral Nombres,eg.apellidosestudiantegeneral Apellidos
        FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr, estudiantegeneral eg
        WHERE o.numeroordenpago=d.numeroordenpago
	and eg.idestudiantegeneral=e.idestudiantegeneral	
        AND pr.codigoperiodo='".$_SESSION["codigoperiodosesion"]."'
        AND e.codigoestudiante=pr.codigoestudiante
        AND e.codigoestudiante=o.codigoestudiante
        AND c.codigocarrera=e.codigocarrera
        AND d.codigoconcepto=co.codigoconcepto
        AND co.cuentaoperacionprincipal=151
        AND e.codigocarrera='".$_SESSION['codigofacultad']."'
        AND o.codigoperiodo='".$_SESSION["codigoperiodosesion"]."'
        AND o.codigoestadoordenpago LIKE '4%'
        GROUP by e.codigoestudiante

 ";

	$operacion=$objetobase->conexion->query($query);
	if($imprimir)
	echo $query;
	
	$operacion=$objetobase->conexion->query($query);
//$row_operacion=$operacion->fetchRow();
	while ($row_operacion=$operacion->fetchRow())
	{
		//if($row_operacion["codigocarrera"]==$_SESSION['codigofacultad']){
		$row_operacion["numerodocumento"]="<a href='index.php?idusuario=".$row_operacion["idestudiantegeneral"]."&listado=1'>".$row_operacion["numerodocumento"]."</a>";
		//}
		$condiciontipousuario="and codigotipousuario = '600'";
		if(isset($_SESSION["codigofacultad"])||trim($_SESSION["codigofacultad"])!='')
			$condiciontipousuario="and codigotipousuario in ('600','700')";

		$resultformulario=$objetobase->recuperar_resultado_tabla('formulario','codigoestado',"100"," and idformulario<>1 ".$condiciontipousuario." order by pesoformulario","",0);	
		while($rowformulario = $resultformulario->fetchRow())
		{
			if($datosformualriodocente=$objetobase->recuperar_datos_tabla('formularioestudiante','idestudiantegeneral',$row_operacion['idestudiantegeneral'],"and idformulario=".$rowformulario["idformulario"],"",0)){
				switch($datosformualriodocente["codigoestadodiligenciamiento"]){
				case "200":
					$row_operacion[str_replace(" ","_",$rowformulario["nombreformulario"])]="<img id='amarillo".$row_operacion['iddocente']."' src='../../imagenes/poraprobar.gif' />";
				break;
				case "300":
					$row_operacion[str_replace(" ","_",$rowformulario["nombreformulario"])]="<img id='verde".$row_operacion['iddocente']."' src='../../imagenes/aprobado.gif' />";
				break;
				default:
					$row_operacion[str_replace(" ","_",$rowformulario["nombreformulario"])]="<img id='rojo".$row_operacion['iddocente']."' src='../../imagenes/noiniciado.gif' />";
				break;
				}
			}
			else{
				
				$row_operacion[str_replace(" ","_",$rowformulario["nombreformulario"])]="<img id='rojo".$row_operacion['iddocente']."' src='../../imagenes/noiniciado.gif' />";
			}
		}
		unset($row_operacion["iddetallecontratodocente"]);
		unset($row_operacion["idestudiantegeneral"]);
		unset($row_operacion["codigocarrera"]);
		$array_interno[]=$row_operacion;
		
	}
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');

$datoscarrera=$objetobase->recuperar_datos_tabla('carrera','codigocarrera',$_SESSION['codigofacultad'],"","",0);
echo "<table width='100%'><tr><td align='center'><h3>LISTADO ESTUDIANTES ".$_SESSION["codigoperiodosesion"]." DE ".$datoscarrera["nombrecarrera"]."</h3></td>";

echo "</td></td></table>";

echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";
			/*CONSULTA INFORMACION FORMULARIO*/

			//$titulo="<input type='checkbox' onclick='selaprueba(this,".$idformulario.");'  ".$checked."/>&nbsp;".strtoupper($datosformulario["nombreformulario"]);

			$titulo="Si desea filtrar la información por cada estado (Iniciado, Sin Apropar y Aprobado), debe digitar en la columna <b>rojo</b> para <img src='../../imagenes/noiniciado.gif'>, <b>amarillo</b> para  <img src='../../imagenes/poraprobar.gif'> y <b>verde</b> para <img src='../../imagenes/aprobado.gif'>";
			
			$formulario->dibujar_fila_titulo($titulo,'tdtituloencuestadescripcion',"2","align='left'","td");

echo "</table>";

$motor = new matriz($array_interno,"ESTADISTICAS ALUMNOS X MATERIA ","listadoestudiantesfacultad.php",'si','si','menuasignacionsalones.php','listadoestudiantesfacultad.php',true,"si","../../../../");
$motor->botonRecargar=false;
$motor->botonRegresar=false;

$motor->mostrar();
?>