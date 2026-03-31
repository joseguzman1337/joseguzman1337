<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
//session_start();
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<?php
$rutaado=("../../../funciones/adodb/");
require_once("../../../funciones/clases/motor/motor.php");
require_once("../../../Connections/salaado-pear.php");

$query="SELECT 
ps.idpreinscripcion, 
ps.observacionpreinscripcionseguimiento as observacion,
ps.fechapreinscripcionseguimiento as fecha,
ps.fechahastapreinscripcionseguimiento as 'Fecha_Proximo_Contacto',
u.usuario as usuario,
if(ps.idtipodetalleestudianteseguimiento=1,te.nombretipoestudianteseguimiento,CONCAT(te.nombretipoestudianteseguimiento,' / ',tde.nombretipodetalleestudianteseguimiento)) TipoObservacion
FROM usuario u, preinscripcionseguimiento ps
	left join tipoestudianteseguimiento te
	on ps.codigotipoestudianteseguimiento=te.codigotipoestudianteseguimiento
	and te.codigoestado like '1%'
	left join tipodetalleestudianteseguimiento tde
	on ps.idtipodetalleestudianteseguimiento=tde.idtipodetalleestudianteseguimiento
WHERE ps.idpreinscripcion='".$_GET['idpreinscripcion']."'
AND ps.idusuario = u.idusuario
AND ps.codigoestado=100
order by idpreinscripcionseguimiento desc
";
$operacion=$sala->query($query);
$row_operacion=$operacion->fetchRow();
do
{
	$array_interno[]=$row_operacion;
}
while ($row_operacion=$operacion->fetchRow());
$motor = new matriz($array_interno,'Listado seguimientos');
$motor->mostrar();
?>
