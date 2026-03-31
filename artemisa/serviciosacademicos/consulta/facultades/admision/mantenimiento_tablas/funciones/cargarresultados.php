<?php
    session_start();
    include_once('../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
function cargarresultados($arrayresultados,$codigocarrera,$codigoperiodo,$tiporesultado,$objetobase){
$query="update tmpresultadoadmisiones set codigoestado='200' where idtmptiporesultadoadmisiones=2
and codigocarreraadmision='".$codigocarrera."' and codigoperiodo='".$codigoperiodo."'";

$objetobase->conexion->execute($query);
foreach($arrayresultados as $llave=>$camporesultado){
$fila['nombre']=$camporesultado['nombre'];
$fila['documento']=$camporesultado['documento'];
$fila['estado']=$camporesultado['estado'];
$fila['hora']=$camporesultado['hora']."";
$fila['salon']=$camporesultado['salon']."";
$fila['edificio']=$camporesultado['edificio']."";
$fila['fecha']=$camporesultado['fecha']."";
$fila['fechatmpresultadoadmisiones']=date("Y-m-d");
$fila['idtmptiporesultadoadmisiones']=$tiporesultado;
$fila['codigocarreraadmision']=$codigocarrera;
$fila['carrerasegundaopcion']=$camporesultado['segunda_opcion']."";
$fila['codigoperiodo']=$codigoperiodo;
$fila['codigoestado']='100';

$condicionactualiza="  codigoperiodo='".$codigoperiodo."'
		and documento='".$fila['documento']."'";
//echo "<pre>";
$objetobase->insertar_fila_bd("tmpresultadoadmisiones",$fila,0,$condicionactualiza);
//echo "</pre>";
}


}
?>