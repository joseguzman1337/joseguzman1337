<?php
    session_start();
    include_once('../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
//ini_set('display_errors', E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);

require_once("../../../templates/template.php");
$db = getBD();

$fecha=$_REQUEST['anio']."-".$_REQUEST['mes']."-15";
		
$query="select idsubperiodo
	from subperiodo
	where idtiposubperiodo=5
		and codigoestadosubperiodo='100'
		and '".$fecha."' between fechainicioacademicosubperiodo and fechafinalacademicosubperiodo";
if($row=&$db->Execute($query)===false){
	$data['success']=false;
	$data['message']='No se encuentra subperiodo para '.$_REQUEST['anio'].' - '.$_REQUEST['mes'];
} else {
	$data['success']=true;
	$data['message']='Subperiodo: '.$row->fields["idsubperiodo"];
	$data['idSub']=$row->fields["idsubperiodo"];
}
echo json_encode($data);
?>
