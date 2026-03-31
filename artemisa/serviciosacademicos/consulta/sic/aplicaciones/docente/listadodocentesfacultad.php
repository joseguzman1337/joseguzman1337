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
	document.location.href="<?php echo 'listadodocentesfacultad.php';?>";
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

$query="select d.iddocente,d.numerodocumento,d.apellidodocente,d.nombredocente,if(ca.nombrecarrera='TODAS LAS CARRERAS','POSTGRADOS',ca.nombrecarrera) Nombre_Carrera,dc3.codigocarrera from  docente d,detallecontratodocente dc,contratodocente c
left join detallecontratodocente dc3 on dc3.idcontratodocente in (select idcontratodocente from contratodocente c4 where c4.iddocente=d.iddocente) and
dc3.horasxsemanadetallecontratodocente = (select max(dc2.horasxsemanadetallecontratodocente) from  contratodocente c2,detallecontratodocente dc2,docente d2 where d2.iddocente=c2.iddocente and c2.idcontratodocente=dc2.idcontratodocente and d2.iddocente=d.iddocente)
left join carrera ca on ca.codigocarrera =dc3.codigocarrera 
 where d.iddocente=c.iddocente and c.idcontratodocente=dc.idcontratodocente and dc.codigocarrera = '".$_SESSION['codigofacultad']."'
and d.codigoestado like '1%'
group by d.iddocente
union
select d.iddocente,d.numerodocumento,d.apellidodocente,d.nombredocente,ca.nombrecarrera Nombre_Carrera,ca.codigocarrera 
from  docente d,grupo g,carrera ca,materia m
where
d.numerodocumento =g.numerodocumento and
g.codigoperiodo in ('20092') and
g.codigomateria = m.codigomateria and
m.codigocarrera=ca.codigocarrera
and ca.codigocarrera = '".$_SESSION['codigofacultad']."'
and d.numerodocumento <> '1'
and d.iddocente not in(
select distinct d.iddocente
from  docente d,detallecontratodocente dc,contratodocente c
left join detallecontratodocente dc3 on dc3.idcontratodocente in (select idcontratodocente from contratodocente c4 where c4.iddocente=d.iddocente) and
dc3.horasxsemanadetallecontratodocente = (select max(dc2.horasxsemanadetallecontratodocente) from  contratodocente c2,detallecontratodocente dc2,docente d2 where d2.iddocente=c2.iddocente and c2.idcontratodocente=dc2.idcontratodocente and d2.iddocente=d.iddocente)
left join carrera ca on ca.codigocarrera =dc3.codigocarrera 
 where d.iddocente=c.iddocente and c.idcontratodocente=dc.idcontratodocente 
)
and d.codigoestado like '1%'
group by d.iddocente
union
select d.iddocente,d.numerodocumento,d.apellidodocente,d.nombredocente,ca2.nombrecarrera Nombre_Carrera,ca2.codigocarrera 
from  docente d,grupo g,carrera ca,carrera ca2,materia m,contratodocente cp, detallecontratodocente dcp
where
d.numerodocumento =g.numerodocumento and
g.codigoperiodo in ('20092') and
g.codigomateria = m.codigomateria and
m.codigocarrera=ca.codigocarrera
and ca.codigocarrera = '".$_SESSION['codigofacultad']."'
and d.numerodocumento <> '1'
and cp.iddocente=d.iddocente
and dcp.idcontratodocente=cp.idcontratodocente
and dcp.codigocarrera <> '".$_SESSION['codigofacultad']."'
and d.iddocente not in(
select distinct d.iddocente
from  docente d,detallecontratodocente dc,contratodocente c
left join detallecontratodocente dc3 on dc3.idcontratodocente in (select idcontratodocente from contratodocente c4 where c4.iddocente=d.iddocente) and
dc3.horasxsemanadetallecontratodocente = (select max(dc2.horasxsemanadetallecontratodocente) from  contratodocente c2,detallecontratodocente dc2,docente d2 where d2.iddocente=c2.iddocente and c2.idcontratodocente=dc2.idcontratodocente and d2.iddocente=d.iddocente)
left join carrera ca on ca.codigocarrera =dc3.codigocarrera 
 where d.iddocente=c.iddocente and c.idcontratodocente=dc.idcontratodocente and  dc.codigocarrera = '".$_SESSION['codigofacultad']."'
)
and dcp.codigocarrera=ca2.codigocarrera
and d.codigoestado like '1%'
group by d.iddocente

 ";

	$operacion=$objetobase->conexion->query($query);
	if($imprimir)
	echo $query;
	
	$operacion=$objetobase->conexion->query($query);
//$row_operacion=$operacion->fetchRow();
	while ($row_operacion=$operacion->fetchRow())
	{
		if($row_operacion["codigocarrera"]==$_SESSION['codigofacultad']){
		$row_operacion["numerodocumento"]="<a href='index.php?idusuario=".$row_operacion["numerodocumento"]."&listado=1'>".$row_operacion["numerodocumento"]."</a>";
		}
		$resultformulario=$objetobase->recuperar_resultado_tabla('formulario','codigoestado',"100"," and idformulario<>1 and codigotipousuario like '5%' ","",0);	
		while($rowformulario = $resultformulario->fetchRow())
		{
			if($datosformualriodocente=$objetobase->recuperar_datos_tabla('formulariodocente','iddocente',$row_operacion['iddocente']," and idformulario=".$rowformulario["idformulario"]." and now() between fechaformulariodocente and fechafinalformulariodocente","",0)){
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
		unset($row_operacion["iddocente"]);
		unset($row_operacion["codigocarrera"]);
		$array_interno[]=$row_operacion;
		
	}
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');

$datoscarrera=$objetobase->recuperar_datos_tabla('carrera','codigocarrera',$_SESSION['codigofacultad'],"","",0);
echo "<table width='100%'><tr><td align='center'><h3>LISTADO DOCENTES 2009 DE ".$datoscarrera["nombrecarrera"]."</h3></td>";

echo "</td></td></table>";

echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";
			/*CONSULTA INFORMACION FORMULARIO*/

			//$titulo="<input type='checkbox' onclick='selaprueba(this,".$idformulario.");'  ".$checked."/>&nbsp;".strtoupper($datosformulario["nombreformulario"]);

			$titulo="Si desea filtrar la información por cada estado (Iniciado, Sin Apropar y Aprobado), debe digitar en la columna <b>rojo</b> para <img src='../../imagenes/noiniciado.gif'>, <b>amarillo</b> para  <img src='../../imagenes/poraprobar.gif'> y <b>verde</b> para <img src='../../imagenes/aprobado.gif'>";
			
			$formulario->dibujar_fila_titulo($titulo,'tdtituloencuestadescripcion',"2","align='left'","td");

echo "</table>";

$motor = new matriz($array_interno,"ESTADISTICAS ALUMNOS X MATERIA ","listadodocentesfacultad.php",'si','si','menuasignacionsalones.php','listadodocentesfacultad.php',true,"si","../../../../");
$motor->botonRecargar=false;
$motor->botonRegresar=false;

$motor->mostrar();
?>