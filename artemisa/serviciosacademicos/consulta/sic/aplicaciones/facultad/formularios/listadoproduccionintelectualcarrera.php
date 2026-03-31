<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<link rel="stylesheet" type="text/css" href="../../../../../estilos/sala.css">
<script LANGUAGE="JavaScript">
function  ventanaprincipal(pagina){
opener.focus();
opener.location.href=pagina.href;
window.close();
return false;
}
function reCarga(){
}
</script>
<?php
$rutaado=("../../../../../funciones/adodb/");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/clases/motorv2/motor.php");
require_once(realpath(dirname(__FILE__))."/../../../../../Connections/salaado-pear.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");

function resumen_cadena($cadena,$longitud){

$rescad="";
for($i=0;$i<$longitud;$i++)
$rescad .= $cadena[$i];

return $rescad;

}

$query="select 
idproduccionintelectualcarrera, 
c.nombrecarrera Carrera,
pc.nombreproduccionintelectualcarrera Nombre,
pc.tituloproduccionintelectualcarrera Titulo,
t.nombretipoproduccionintelectual Tipo_de_producto,
pc.fechapublicacionproduccionintelectualcarrera Fecha_Publicacion,
pc.numeroproduccionintelectualcarrera Numero_Identificacion,
pc.autorproduccionintelectualcarrera Autor

 from 
produccionintelectualcarrera pc,carrera c,tipoproduccionintelectual t where 
pc.codigocarrera='".$_SESSION['codigofacultad']."'
and c.codigocarrera=pc.codigocarrera
and t.codigotipoproduccionintelectual=pc.codigotipoproduccionintelectual
and pc.codigoestado like '1%'
";

$objetobase=new BaseDeDatosGeneral($sala);

$operacion=$sala->query($query);
$row_operacion=$operacion->fetchRow();
do
{
	$array_interno[]=$row_operacion;
	//$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
}
while ($row_operacion=$operacion->fetchRow());
//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
//unset($_GET['Filtrar']);


//$motor = new matriz($array_interno,"Listado de Centros de trabajo ");
$motor = new matriz($array_interno,"LISTADO PRODUCCION INTELECTUAL CARRERA","listadoproduccionintelectualcarrera.php",'si','si','produccionintelectualcarrera.php','produccionintelectualcarrera.php',false,"si","../../../../../");
//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
$motor->agregarllave_drilldown('idproduccionintelectualcarrera','produccionintelectualcarrera.php','produccionintelectualcarrera.php','','idproduccionintelectualcarrera',"",'','','','','onclick= "return ventanaprincipal(this)"');
$motor->botonRecargar=false;
$motor->botonRegresar=false;

$motor->mostrar();
?>
