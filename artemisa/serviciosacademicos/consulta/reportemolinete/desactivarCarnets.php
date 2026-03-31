<?php
session_start();
$fechahoy=date("Y-m-d H:i:s");
require_once('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
	require_once('./Excel/reader.php');

$rutaJS = "../sic/librerias/js/";
$varguardar = 0;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
        <title>Cargar docentes</title>
		<!--<link rel="stylesheet" type="text/css" href="../mgi/css/themes/smoothness/jquery-ui-1.8.4.custom.css" media="screen" /> --> 
        <link rel="stylesheet" type="text/css" href="../../../mgi/css/styleOrdenes.css" media="screen" />
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
		<script type="text/javascript" language="javascript" src="../../../mgi/js/functions.js"></script>
    </head>
    <body>
	<?php if(!isset($_POST['buscar'])){ ?>
<div id="contenido" style="margin-top: 10px;">
<h4>Cargar Datos a Verificar</h4>
    <div id="form"> 
        <form action="desactivarCarnets.php" id="form_test" method="POST" enctype="multipart/form-data">
           
            <label for="file">Archivo con los datos andover:</label>
            <input accept="application/vnd.ms-excel" type="file" name="file" id="file">
            <br/>
            <br/>
            
            <input type="submit" name="buscar" value="Exportar queries" class="first" />
            
        </form>
    </div>
 </div>
	<?php } 
    
    if(isset($_POST['buscar']) &&  isset($_FILES)){ 
		//TOCA PROCESAR EL ARCHIVO CON LAS ORDENES
		$data = new Spreadsheet_Excel_Reader();
		//echo "<pre>";print_r($_REQUEST); 
		//echo "<br/><br/><pre>";print_r($_FILES); die;
		$data->setOutputEncoding('CP1251');
        
		$data->read($_FILES["file"]["tmp_name"]);
        $filas = $data->sheets[0]['numRows'];
		//var_dump($filas); die;
		$contador=0;
		$errores = 0;
		//se asume la primera como titulo
		for ($z = 2; $z <= $filas; $z++) {
			$fields['SocSecNo']=trim($data->sheets[0]['cells'][$z][1]);			
            $fields['uiName']=$data->sheets[0]['cells'][$z][2];
			if($fields['SocSecNo']!=""){
				$filaReal = true;
			}
			
			if($filaReal){		
				//verificar que no fue inscrito antes
				$sql = "SELECT idestudiantegeneral FROM estudiantegeneral 
				WHERE numerodocumento='".$fields['SocSecNo']."' 
				UNION SELECT idestudiantegeneral FROM estudiantedocumento 			
				WHERE numerodocumento='".$fields['SocSecNo']."' ";
				$result = $db->GetRow($sql);
				if(count($result)>0){				
					echo "UPDATE `tarjetaestudiante` SET `codigoestado`='200' WHERE idestudiantegeneral='".$result['idestudiantegeneral']."'; <br/><br/>"; 
				} 	
				
				$sql = "SELECT t.codigotarjetainteligenteadmindocen as codigo,t.idadministrativosdocentes FROM tarjetainteligenteadmindocen t 
					INNER JOIN administrativosdocentes a on a.idadministrativosdocentes=t.idadministrativosdocentes
					WHERE a.numerodocumento='".$fields['SocSecNo']."' AND t.codigoestado=100";
					$tarjeta = $db->GetRow($sql);	
				
				if(count($tarjeta)>0){	
					echo "UPDATE `tarjetainteligenteadmindocen` SET `codigoestado`='200' WHERE idadministrativosdocentes='".$tarjeta['idadministrativosdocentes']."'; <br/><br/>"; 
				}	
				
				if($fields['SocSecNo']==NULL || $fields['SocSecNo']=="NULL"){
					//echo "UPDATE Personnel SET State='0' WHERE SocSecNo IS NULL AND uiName='".$fields['uiName']."'; <br/><br/>";
				} else {
					//echo "UPDATE Personnel SET State='0' WHERE SocSecNo='".$fields['SocSecNo']."'; <br/><br/>";
				}				
			} //filaReal
		} //for 
    }
    ?>
  </body>
</html>