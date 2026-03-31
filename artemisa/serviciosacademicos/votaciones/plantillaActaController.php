<?php 
$rutaado = ("../funciones/adodb/");
require_once('../Connections/salaado-pear.php');
$controller = new plantillaActaController();
if($_POST['action']== 'checkVotaciones'){
	$ano=$_POST['ano'];
	$controller->checkVotaciones($sala,$ano);
}


class plantillaActaController{
	public function checkVotaciones($sala,$ano){
		$query = "SELECT idvotacion,nombrevotacion FROM votacion WHERE fechainiciovotacion LIKE '%".$ano."%' "; 
		
		$votacion = $sala->query($query);
		
		$arrayVot = array();
		
		$row = $votacion->fetchRow();
		do {
			$arrayVot[] = $row;
		} while ($row = $votacion->fetchRow());
		$chekV = null;
		$chekV="<table>";
		
		foreach ($arrayVot as $votacin) {
			$chekV.= "<tr><td>".$votacin["nombrevotacion"]."<input type='checkbox' id='checkid[]' name='checkid[]' value='".$votacin["idvotacion"]."'</td></tr>";
		}
		echo "</table>".$chekV;
	}
}

?>