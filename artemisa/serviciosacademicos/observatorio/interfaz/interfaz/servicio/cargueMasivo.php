<?php
header ('Content-type: text/html; charset=utf-8');
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

session_start();
//cargue masivo de usuarios para cambio de estado a graduado.

require_once ("../../../../sniespgsqlsadhapmn/Excel/reader.php");

if($db==null){
	include_once ('../../../EspacioFisico/templates/template.php');
	$db = getBD(); 
}

if($_POST){ 
    $keys_post = array_keys($_POST); 
    foreach ($keys_post as $key_post){ 
      $$key_post = $_POST[$key_post] ; 
     } 
 }

 if($_GET){
    $keys_get = array_keys($_GET); 
    foreach ($keys_get as $key_get){ 
        $$key_get = $_GET[$key_get]; 
     } 
 }



$data = new Spreadsheet_Excel_Reader();

$data->read($_FILES["archivo"]["tmp_name"]);
    
    $i =1;
    
   // echo '<table border="1">';
    		
		    $j=1;
			$sqlAsignaturas = "SELECT idasignaturaestado
		       						FROM asignaturaestado 
	       							WHERE TipoPrueba=2 
	       							AND codigoestado=100 
	       							AND CuentaCompetenciaBasica=1
	       							AND idasignaturaestado != 16
									ORDER BY nombreasignaturaestado ASC";
				
		       $idMaterias = $db->GetAll($sqlAsignaturas);
		    
		    foreach ($data->sheets[0]['cells'] as $llave => $valor)
		    {
		       // echo '<tr><td>'.$j.'</td>';
		       
		       
		       
		       
		      // $idMaterias = array("14","15","10");
		       $notas = array($valor[10],$valor[12],$valor[11]);
			   
			   
			   
		       	$sqlIdEstudiante = "SELECT idestudiantegeneral FROM estudiantegeneral WHERE numerodocumento = '$valor[1]'";
				//echo "<pre>";print_r($sqlIdEstudiante);
		       	$datos = $db->GetRow($sqlIdEstudiante);
		       	if( $datos["idestudiantegeneral"] != ""){
		       		$idEstudianteG = $datos["idestudiantegeneral"];
		       	}else{
		       		$sql = "SELECT idestudiantegeneral FROM estudiantegeneral WHERE numerodocumento = $valor[1]";
		       		$datos = $db->GetRow($sql);
					$idEstudianteG = $datos["idestudiantegeneral"];
		       	}
		       	
		       //	echo "Id Estudiante---->".$idEstudianteG."<br/>";
		       	
		       	if( $idEstudianteG != ""){
				$sqlPruebaEstado = "SELECT idresultadopruebaestado FROM resultadopruebaestado WHERE idestudiantegeneral = '$idEstudianteG'";
				$resultadoEstado = $db->GetRow($sqlPruebaEstado);
				
				$idPruebaEstado = $resultadoEstado["idresultadopruebaestado"];
				
				//echo "Prueba de Estado---->".$idPruebaEstado."<br/>";
					if( $idPruebaEstado != ""){
						$k=0;
						foreach( $idMaterias as $idMateria ){
						//foreach( $idMaterias as $idMateria ){ 	
							//foreach( $notas as $nota ){	
								$sqlInsertResultado = "INSERT INTO detalleresultadopruebaestado (
													idresultadopruebaestado,
													idasignaturaestado,
													notadetalleresultadopruebaestado,
													nivel,
													decil,
													ChequeoFacultad,
													codigoestado
													)
													VALUES
														($idPruebaEstado, ".$idMateria["idasignaturaestado"].", '$notas[$k]', '', '',default, '100')";
														
								$insertarResultado = $db->Execute( $sqlInsertResultado );
								//echo $sqlInsertResultado."<br/>";
								$k = $k + 1;
							
						}
					}
				}
				//}	
				//$insertarDetalle = $db->Execute($sqlInsertResultado);
				
				
			}
		
		if( $insertarResultado === false ){
				echo "No se pudo cargar el archivo";
		}else{
				echo "Archivo cargado correctamente";
		}
			
		//	echo '</table>';

/*print_r($_FILES["archivo"]["name"]); print "\n"; 
print_r($_FILES["archivo"]["tmp_name"]); print "\n"; 
print_r($_FILES["archivo"]["type"]); print "\n"; 
print_r($_FILES["archivo"]["size"]); print "\n";*/ 
//echo "Si envía el archivo";


   
?>
