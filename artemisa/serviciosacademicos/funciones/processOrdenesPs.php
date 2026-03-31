<?php 
is_file(dirname(__FILE__) . "/../../sala/includes/adaptador.php")
    ? require_once(dirname(__FILE__) . "/../../sala/includes/adaptador.php")
    : require_once(realpath(dirname(__FILE__) . "/../../sala/includes/adaptador.php"));


	session_start();
	require_once('../Connections/sala2.php' );
	require_once("zfica_sala_crea_aspirante.php");
	$rutaado = "../funciones/adodb/";
	require_once('../Connections/salaado.php');
	require_once('../educacionContinuada/Excel/reader.php');
	include_once("funcionesOrdenes.php");
	
	//Esta variable sirve para que no se envien los descuentos a People
	$_GET['modulo']='reenvio_ordenes_ps';
	
	if($_REQUEST['action']=="envioOrden" and  $_REQUEST['ordenpago'] != ""){
		//TOCA PROCESAR 1 ORDEN
		
		//buscar el numero de documento asociado
		$row = validarOrden($_REQUEST['ordenpago'],$sala,$db);    
		if($row!==false){
			$Query= "INSERT INTO `tmpIntegracionorden20112` (`numeroordenpago`, `numerodocumento`) VALUES ('".$_REQUEST['ordenpago']."', '".$row['numerodocumento']."');";
//			$resultado = mysql_query($Query, $sala) or die("$Query<br>" . mysql_error());
                        $resultado = $db->Execute($Query);
			
			$Query= "select * from tmpIntegracionorden20112 where (estado='' OR estado IS NULL) AND numeroordenpago='".$_REQUEST['ordenpago']."' order by numeroordenpago";
//			$resultado = mysql_query($Query, $sala) or die("$Query<br>" . mysql_error());    
//                        $row = $db->GetRow($Query);
                        $resultado = $db->GetAll($Query);
//			while (($row = mysql_fetch_array($resultado, MYSQL_ASSOC)) != NULL) {
			foreach ($resultado as $row) {
				enviarps_orden($row['numeroordenpago'],$sala,$row['idtmpIntegracionorden'],$db);
			}			
			
			$data = array('success'=> true,'message'=>'Se ha enviado la orden de forma correcta.');
			echo json_encode($data);
			die;
		} else {
			$data = array('success'=> false,'message'=>'La orden de pago '.$_REQUEST['ordenpago'].' no es correcta, se encuentra anulada o es de reemplazo.');
			echo json_encode($data);
			die;
		}		
	} else if($_REQUEST['action']=="envioOrdenes" || isset($_FILES)){
		//TOCA PROCESAR EL ARCHIVO CON LAS ORDENES
		$data = new Spreadsheet_Excel_Reader();
		//echo "<pre>";print_r($_REQUEST); 
		//echo "<br/><br/><pre>";print_r($_FILES); die;
		$data->setOutputEncoding('CP1251');

		$data->read($_FILES["file"]["tmp_name"]);
		$filas = $data->sheets[0]['numRows'];
		$contador=0;
		$errores = 0;
		//se asume la primera como titulo
		for ($z = 2; $z <= $filas; $z++) {
			//traigo la primera columna
			$orden=$data->sheets[0]['cells'][$z][1];
			if($orden!=""){
				$filaReal = true;
			}
		
			if($filaReal){
				$row = validarOrden($orden,$sala);
				if($row!==false){
					$Query= "INSERT INTO `tmpIntegracionorden20112` (`numeroordenpago`, `numerodocumento`) VALUES ('".$orden."', '".$row['numerodocumento']."');";
//					$resultado = mysql_query($Query, $sala) or die("$Query<br>" . mysql_error());
                                        $resultado = $db->Execute($Query);
					$contador++;
				} else {
					$errores = $errores + 1;
					$mensajesError[] = "La fila ".$fila." correspondiente a la orden ".$orden." no es correcta o se encuentra anulada.";
				}
			}
			
		}
		
		$mensaje .= "Se cargaron ".$contador." ordenes de pago de forma correcta.<br/>";
		foreach($mensajesError as $error){
			$mensaje .= $error."<br/>";
		}
		
		if($contador>0){
			$data = array('success'=> true,'message'=>$mensaje);
		} else {
			$data = array('success'=> false,'message'=>$mensaje);
		}
		echo json_encode($data);
		die;
	} 
?>