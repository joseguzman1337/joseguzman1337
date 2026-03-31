<?php
//init_set(on);
if(isset($_POST['buscar']) &&  isset($_FILES)){

/*header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=reporte_".date('Y-m-d').".xls");
header("Pragma: no-cache");
header("Expires: 0");*/
}
session_start();
    include_once ('../EspacioFisico/templates/template.php');
    $db = getBD();
	$db->SetCharSet('utf8');
	require_once('../educacionContinuada/Excel/reader.php');
	header("Content-Type: text/html; charset=iso-8859-1");  

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
       <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
         <?php 
        /*@modified Diego Rivera<riveradiego@unbosque.edu.co>
         *se cambia css externa <link href="//datatables.net/download/build/nightly/jquery.dataTables.css?_=0188ba71c41a05452766c8a4627b767f.css" rel="stylesheet" type="text/css" />
	  por css local 
         */
        ?>
        <title>primiparos</title>
		<link  type="text/css" href="css/dataTables.tableTools.css" rel="stylesheet">
		<link  type="text/css" href="css/jquery.dataTables.css" rel="stylesheet">
        <script type="text/javascript" language="javascript" src="js/jquery.js"></script>
		<script type="text/javascript" charset="utf-8" src="js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8" src="js/dataTables.tableTools.js"></script>
		<!--<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
		<script src="//datatables.net/download/build/nightly/jquery.dataTables.js?_=0188ba71c41a05452766c8a4627b767f"></script>-->
		<script>
		$(document).ready(function(){
			$("form").submit(function(){
				var periodo = $("#tarchivo").val();
				if(periodo == ''){
					alert("Debe Seleccionar el tipo de archivo");
					return false;
				}
				
				var archivo = $("#fileCsv").val();
				if(archivo == ''){
					alert("Debe Seleccionar archivo");
					return false;
				}
			});
			  $('#myTable').DataTable( {
					dom: 'T<"clear">lfrtip'
				} );
				$('#cambios').DataTable( {
					dom: 'T<"clear">lfrtip'
				} );
				$('#nocambios').DataTable( {
					dom: 'T<"clear">lfrtip'
				} );
		});
		</script>
    </head>	
    <body>
        <div  class="wrapper" align="center">
			<h4>Cargue de preinscritos en Excel</h4>
            <form name="f1" id="f1" action="ReporteSpadiesPrimiparos.php" method="POST" enctype="multipart/form-data">
				<label>Archivo Csv:</label>
				<input type="file" class="required" value="" name="fileCsv" id="fileCsv" /><br/><br/>
				<label>Seleccione tipo de archivo</label><select id="tarchivo" name="tarchivo">
												<option value="">Seleccione</option>
												<option value="1">Primiparos</option>
												<option value="2">Matriculados</option>
												<option value="3">Graduados</option>
												</select><br/><br/>
				
                        <input name="buscar" id="buscar" type="submit" value="Generar">
            </form>
        </div>
    </body>

    <?php	
    if(isset($_POST['buscar']) &&  isset($_FILES)){
		//PROCESAR EL ARCHIVO 
		$tempFile = $_FILES['fileCsv']['tmp_name'];
		$nombre = $_FILES['fileCsv']['name'];
		$tipo = $_FILES['fileCsv']['type'];
		$tamano = $_FILES['fileCsv']['size'];
		$handle = fopen($tempFile,"r");
		//$periodo=$_POST['periodo'];
		$i=0;
		$html="";
		$cambio="";
		$cambioNo="";
		$temp = null;
		if($_POST['tarchivo']=== '1'){
	
		?>
			<table id="myTable" class="display" cellspacing="0" width="100%">
		<thead>
			<th>apellidos</th>
			<th>nombres</th>
			<th>tipoDocumento</th>
			<th>documento</th>
			<th>nombrePrograma</th>
			<th>codigoEstudiante</th>
			<th>sexo</th>
			<th>fechaNacimiento</th>
			<th>codigoSNIESprograma</th>
		</thead><tbody>	<?php
	
		while ($data = fgetcsv ($handle, 1000, ";")){ 
			if($i>0){
				$tipoDocumento="";
				$dataSala="";
				/* Consulta por Id estudiante*/
				 $Sql="SELECT EG.apellidosestudiantegeneral, EG.nombresestudiantegeneral,EG.idestudiantegeneral,EG.tipodocumento,C.nombrecortocarrera,EG.numerodocumento
							FROM estudiantegeneral EG
							INNER JOIN estudiante E ON (EG.idestudiantegeneral=E.idestudiantegeneral)
							INNER JOIN carrera C ON (E.codigocarrera=C.codigocarrera)
							WHERE EG.idestudiantegeneral='".str_replace("'","",$data[5])."' AND C.codigomodalidadacademica = '200' LIMIT 1";
				
				if($dataSala=&$db->GetAll($Sql) === false){
					echo 'Ocurrio un error al consultar la data'.$Sql;
					die;
				}
				if(!empty($data[3])){
					/* buscar por número documento y programa de pregrado*/
					$Sql="SELECT EG.apellidosestudiantegeneral, EG.nombresestudiantegeneral,EG.idestudiantegeneral,EG.tipodocumento,C.nombrecortocarrera ,
							EG.numerodocumento
							FROM estudiantegeneral EG
							INNER JOIN estudiante E ON (EG.idestudiantegeneral=E.idestudiantegeneral)
							INNER JOIN carrera C ON (E.codigocarrera=C.codigocarrera)
							WHERE EG.numerodocumento='".str_replace("'","",$data[3])."'
							AND C.codigomodalidadacademica = '200'";
					if($dataSala=&$db->GetAll($Sql) === false){
						echo 'Ocurrio un error al consultar la data';
						die;
					}
					/*buscar por docúmento y programa diferente a pregrado  */
					
					if(empty($dataSala)){
						   $Sql="SELECT  EG.apellidosestudiantegeneral, EG.nombresestudiantegeneral,EG.idestudiantegeneral,EG.tipodocumento,C.nombrecortocarrera ,
							EG.numerodocumento
							FROM estudiantegeneral EG
							INNER JOIN estudiante E ON (EG.idestudiantegeneral=E.idestudiantegeneral)
							INNER JOIN carrera C ON (E.codigocarrera=C.codigocarrera)
							WHERE EG.numerodocumento='".str_replace("'","",$data[3])."' LIMIT 1"; 
						if($dataSala=&$db->GetAll($Sql) === false){
							echo 'Ocurrio un error al consultar la data';
							die;
						}
					}
				
				}
				/* Busqueda por nombres y apellidos*/
				 if(empty($dataSala)){
						$nombreEstudiante = str_replace(" ","%",$data[1]);
						$nombreEstudiante = utf8_encode($nombreEstudiante);
						$apellidoEstudiante = str_replace(" ","%",$data[0]);
						$apellidoEstudiante=utf8_encode($apellidoEstudiante);
						$Sql="SELECT
									EG.apellidosestudiantegeneral,
									EG.nombresestudiantegeneral,
									EG.idestudiantegeneral,
									EG.tipodocumento,
									C.nombrecortocarrera,
									EG.numerodocumento
								FROM
									estudiantegeneral EG
								INNER JOIN estudiante E ON (
									EG.idestudiantegeneral = E.idestudiantegeneral
								)
								INNER JOIN carrera C ON (
									E.codigocarrera = C.codigocarrera
								)
								WHERE
									EG.nombresestudiantegeneral LIKE '%".$nombreEstudiante."%'
								AND EG.apellidosestudiantegeneral LIKE '%".$apellidoEstudiante."%'
								GROUP BY
									EG.idestudiantegeneral"; 						
					
					if($dataSala=&$db->GetAll($Sql) === false){
						echo 'Ocurrio un error al consultar la data';
						die;
					}
				}
				$idEstudiante = $dataSala[0]['idestudiantegeneral'];
				$tipoDocumento = $dataSala[0]['tipodocumento'];
				$nombrecortocarrera = $dataSala[0]['nombrecortocarrera'];
				$apellidosestudiantegeneral= $dataSala[0]['apellidosestudiantegeneral'];
				$nombresestudiantegeneral= $dataSala[0]['nombresestudiantegeneral'];
				if(!empty($dataSala)){
					$data[3]=$dataSala[0]['numerodocumento'];
						if(empty($data[4])){
							$data[4] = $nombrecortocarrera;
							$cambio .= "<tr><td>".$data[0]."</td>".
										 "<td>".$data[1]."</td>".
										 "<td>".$tipoDocumento."</td>".
										 "<td>".$data[3]."</td>".
										 "<td>".$idEstudiante."</td></tr>";
						}
						if(empty($data[0])){
													$data[0] = $apellidosestudiantegeneral;
													$cambio .= "<tr><td>".$data[0]."</td>".
																 "<td>".$data[1]."</td>".
																 "<td>".$data[3]."</td>".
																 "<td>".$idEstudiante."</td></tr>"; 
						}
						if(empty($data[1])){
													$data[1] = $nombresestudiantegeneral;
													$cambio .= "<tr><td>".$data[0]."</td>".
																 "<td>".$data[1]."</td>".
																 "<td>".$data[3]."</td>".
																 "<td>".$idEstudiante."</td></tr>"; 
						}						
						if(($data[2] === 'C' )&&($tipoDocumento !== '01')){
							if($tipoDocumento === '02'){
								$tipoDocumento = 'T';
							}
							if($tipoDocumento === '03'){
								$tipoDocumento = 'E';
							}
							 $html .= "<tr><td>".$data[0]."</td>".
										 "<td>".$data[1]."</td>".
										 "<td>".$tipoDocumento."</td>".
										 "<td>".$data[3]."</td>".
										 "<td>".$data[4]."</td>".
										 "<td>".$idEstudiante."</td>".
										 "<td>".$data[6]."</td>".
										 "<td>".$data[7]."</td>".
										 "<td>".$data[8]."</td></tr>";  
								$cambio .= "<tr><td>".$data[0]."</td>".
										 "<td>".$data[1]."</td>".
										 "<td>".$tipoDocumento."</td>".
										 "<td>".$data[3]."</td>".
										 "<td>".$idEstudiante."</td></tr>";
						}else if(($data[2] === 'T' )&&($tipoDocumento !== '02')){
							if($tipoDocumento === '01'){
								$tipoDocumento = 'C';
							}
							if($tipoDocumento === '03'){
								$tipoDocumento = 'E';
							}
							 $html .= "<tr><td>".$data[0]."</td>".
										 "<td>".$data[1]."</td>".
										 "<td>".$tipoDocumento."</td>".
										 "<td>".$data[3]."</td>".
										 "<td>".$data[4]."</td>".
										 "<td>".$idEstudiante."</td>".
										 "<td>".$data[6]."</td>".
										 "<td>".$data[7]."</td>".
										 "<td>".$data[8]."</td></tr>";  
							$cambio .= "<tr><td>".$data[0]."</td>".
										 "<td>".$data[1]."</td>".
										 "<td>".$data[3]."</td>".
										 "<td>".$idEstudiante."</td></tr>"; 			 
						}else if(($data[2] === 'E' )&&($tipoDocumento !== '03')){
							if($tipoDocumento === '01'){
								$tipoDocumento = 'C';
							}
							if($tipoDocumento === '02'){
								$tipoDocumento = 'T';
							}
							  $html .= "<tr><td>".$data[0]."</td>".
										 "<td>".$data[1]."</td>".
										 "<td>".$tipoDocumento."</td>".
										 "<td>".$data[3]."</td>".
										 "<td>".$data[4]."</td>".
										 "<td>".$idEstudiante."</td>".
										 "<td>".$data[6]."</td>".
										 "<td>".$data[7]."</td>".
										 "<td>".$data[8]."</td></tr>";  
							$cambio .= "<tr><td>".$data[0]."</td>".
										 "<td>".$data[1]."</td>".
										 "<td>".$data[3]."</td>".
										 "<td>".$idEstudiante."</td></tr>"; 			 
						}else{
								if($tipoDocumento === '01'){
								$tipoDocumento = 'C';
							}
							if($tipoDocumento === '02'){
								$tipoDocumento = 'T';
							}
							if($tipoDocumento === '03'){
								$tipoDocumento = 'E';
							}
								 $html .= "<tr><td>".$data[0]."</td>".
										 "<td>".$data[1]."</td>".
										 "<td>".$tipoDocumento."</td>".
										 "<td>".$data[3]."</td>".
										 "<td>".$data[4]."</td>".
										 "<td>".$idEstudiante."</td>".
										 "<td>".$data[6]."</td>".
										 "<td>".$data[7]."</td>".
										 "<td>".$data[8]."</td></tr>";  
						}
				
				}else{
					$html .= "<tr><td>".$data[0]."</td>".
										 "<td>".$data[1]."</td>".
										 "<td>".$data[2]."</td>".
										 "<td>".$data[3]."</td>".
										 "<td>".$data[4]."</td>".
										 "<td>".$data[5]."</td>".
										 "<td>".$data[6]."</td>".
										 "<td>".$data[7]."</td>".
										 "<td>".$data[8]."</td></tr>"; 
						 	$cambioNo .= "<tr><td>".$data[0]."</td>".
								 "<td>".$data[1]."</td>".
								 "<td>".$data[3]."</td>".
								 "</tr>"; 
				}
			
				
				
			}
			$i=$i+1;
		}
			echo ($html);
	}
	if($_POST['tarchivo']=== '2'){ ?>
	<table id="myTable" class="display" cellspacing="0" width="100%">
		<thead>
			<th>apellidos</th>
			<th>nombres</th>
			<th>tipoDocumento</th>
			<th>documento</th>
			<th>nombrePrograma</th>
			<th>materiasTomadas</th>
			<th>materiasAprobadas</th>
		</thead><tbody> <?php
		while ($data = fgetcsv ($handle, 1000, ";")){ 
			if($i>0){
				$tipoDocumento="";
				$dataSala="";
				if(!empty($data[3])){
					/* buscar por número documento y programa de pregrado*/
					$Sql="SELECT EG.apellidosestudiantegeneral, EG.nombresestudiantegeneral,EG.idestudiantegeneral,EG.tipodocumento,C.nombrecortocarrera ,
							EG.numerodocumento
							FROM estudiantegeneral EG
							INNER JOIN estudiante E ON (EG.idestudiantegeneral=E.idestudiantegeneral)
							INNER JOIN carrera C ON (E.codigocarrera=C.codigocarrera)
							WHERE EG.numerodocumento='".str_replace("'","",$data[3])."'
							AND C.codigomodalidadacademica = '200'";
					if($dataSala=&$db->GetAll($Sql) === false){
						echo 'Ocurrio un error al consultar la data';
						die;
					}
					/*buscar por docúmento y programa diferente a pregrado  */
					
					if(empty($dataSala)){
						   $Sql="SELECT  EG.apellidosestudiantegeneral, EG.nombresestudiantegeneral,EG.idestudiantegeneral,EG.tipodocumento,C.nombrecortocarrera ,
							EG.numerodocumento
							FROM estudiantegeneral EG
							INNER JOIN estudiante E ON (EG.idestudiantegeneral=E.idestudiantegeneral)
							INNER JOIN carrera C ON (E.codigocarrera=C.codigocarrera)
							WHERE EG.numerodocumento='".str_replace("'","",$data[3])."' LIMIT 1"; 
						if($dataSala=&$db->GetAll($Sql) === false){
							echo 'Ocurrio un error al consultar la data';
							die;
						}
					}
				
				}
			
				
				/* Busqueda por nombres y apellidos*/
				 if(empty($dataSala)){
						$nombreEstudiante = str_replace(" ","%",$data[1]);
						$nombreEstudiante = utf8_encode($nombreEstudiante);
						$apellidoEstudiante = str_replace(" ","%",$data[0]);
						$apellidoEstudiante=utf8_encode($apellidoEstudiante);
						$Sql="SELECT
									EG.apellidosestudiantegeneral,
									EG.nombresestudiantegeneral,
									EG.idestudiantegeneral,
									EG.tipodocumento,
									C.nombrecortocarrera,
									EG.numerodocumento
								FROM
									estudiantegeneral EG
								INNER JOIN estudiante E ON (
									EG.idestudiantegeneral = E.idestudiantegeneral
								)
								INNER JOIN carrera C ON (
									E.codigocarrera = C.codigocarrera
								)
								WHERE
									EG.nombresestudiantegeneral LIKE '%".$nombreEstudiante."%'
								AND EG.apellidosestudiantegeneral LIKE '%".$apellidoEstudiante."%'
								GROUP BY
									EG.idestudiantegeneral"; 						
					
					if($dataSala=&$db->GetAll($Sql) === false){
						echo 'Ocurrio un error al consultar la data';
						die;
					}
				}
				$idEstudiante = $dataSala[0]['idestudiantegeneral'];
				$tipoDocumento = $dataSala[0]['tipodocumento'];
				$nombrecortocarrera = $dataSala[0]['nombrecortocarrera'];
				$apellidosestudiantegeneral= $dataSala[0]['apellidosestudiantegeneral'];
				$nombresestudiantegeneral= $dataSala[0]['nombresestudiantegeneral'];
				
				if(!empty($dataSala)){
					$data[3]=$dataSala[0]['numerodocumento'];
						if(empty($data[4])){
							$data[4] = $nombrecortocarrera;
							$cambio .= "<tr><td>".$data[0]."</td>".
										 "<td>".$data[1]."</td>".
										 "<td>".$data[3]."</td>".
										 "</tr>"; 
						}
						if(empty($data[0])){
													$data[0] = $apellidosestudiantegeneral;
													$cambio .= "<tr><td>".$data[0]."</td>".
																 "<td>".$data[1]."</td>".
																 "<td>".$data[3]."</td>".
																 "</tr>"; 
						}
						if(empty($data[1])){
													$data[1] = $nombresestudiantegeneral;
													$cambio .= "<tr><td>".$data[0]."</td>".
																 "<td>".$data[1]."</td>".
																 "<td>".$data[3]."</td>".
																 "</tr>"; 
						}		
						if(($data[2] === 'C' )&&($tipoDocumento !== '01')){
							if($tipoDocumento === '02'){
								$tipoDocumento = 'T';
							}
							if($tipoDocumento === '03'){
								$tipoDocumento = 'E';
							}
								$html.= "<tr><td>".$data[0]."</td>".
										 "<td>".$data[1]."</td>".
										 "<td>".$tipoDocumento."</td>".
										 "<td>".$data[3]."</td>".
										 
										 "<td>".$data[4]."</td>".
										 "<td>".$data[5]."</td>".
										 "<td>".$data[6]."</td></tr>";
										 
								 $cambio .= "<tr><td>".$data[0]."</td>".
								 "<td>".$data[1]."</td>".
								 "<td>".$data[3]."</td>".
								 "<td>".$idEstudiante."</td></tr>";
						}else if(($data[2] === 'T' )&&($tipoDocumento !== '02')){
							if($tipoDocumento === '01'){
								$tipoDocumento = 'C';
							}
							if($tipoDocumento === '03'){
								$tipoDocumento = 'E';
							}
							 $html.= "<tr><td>".$data[0]."</td>".
										 "<td>".$data[1]."</td>".
										 "<td>".$tipoDocumento."</td>".
										 "<td>".$data[3]."</td>".
										 
										 "<td>".$data[4]."</td>".
										 "<td>".$data[5]."</td>".
										 "<td>".$data[6]."</td></tr>";
										 
							$cambio .= "<tr><td>".$data[0]."</td>".
										 "<td>".$data[1]."</td>".
										 "<td>".$data[3]."</td>".
										 "</tr>";
						}else if(($data[2] === 'E' )&&($tipoDocumento !== '03')){
							if($tipoDocumento === '01'){
								$tipoDocumento = 'C';
							}
							if($tipoDocumento === '02'){
								$tipoDocumento = 'T';
							}
							$html.= "<tr><td>".$data[0]."</td>".
										 "<td>".$data[1]."</td>".
										 "<td>".$tipoDocumento."</td>".
										 "<td>".$data[3]."</td>".
										 
										 "<td>".$data[4]."</td>".
										 "<td>".$data[5]."</td>".
										 "<td>".$data[6]."</td></tr>";
							$cambio .= "<tr><td>".$data[0]."</td>".
										 "<td>".$data[1]."</td>".
										 "<td>".$data[3]."</td>".
										 "</tr>"; 
						}else{
								$html.= "<tr><td>".$data[0]."</td>".
										 "<td>".$data[1]."</td>".
										 "<td>".$data[2]."</td>".
										 "<td>".$data[3]."</td>".
																				 
										 "<td>".$data[4]."</td>".
										 "<td>".$data[5]."</td>".
										 "<td>".$data[6]."</td></tr>";
						}
				
				}else{
					
					$html.= "<tr><td>".$data[0]."</td>".
							 "<td>".$data[1]."</td>".
							 "<td>".$data[2]."</td>".
							 "<td>".$data[3]."</td>".
																	 
							 "<td>".$data[4]."</td>".
							 "<td>".$data[5]."</td>".
							 "<td>".$data[6]."</td></tr>";
					$cambioNo .= "<tr><td>".$data[0]."</td>".
						 "<td>".$data[1]."</td>".
						 "<td>".$data[3]."</td>".
						 "</tr>"; 
				}
			
				
				
			}
			$i=$i+1;
			
		}
			echo ($html);
	}
	if($_POST['tarchivo']=== '3'){ ?>
	<table id="myTable" class="display" cellspacing="0" width="100%">
		<thead>
			<th>apellidos</th>
			<th>nombres</th>
			<th>tipoDocumento</th>
			<th>documento</th>
			<th>nombrePrograma</th>
		</thead><tbody> <?php
		while ($data = fgetcsv ($handle, 1000, ";")){ 
			if($i>0){
				$tipoDocumento="";
				$dataSala="";
				if(!empty($data[3])){
					/* Busqueda por documento */
					$Sql="SELECT EG.idestudiantegeneral,EG.tipodocumento,C.nombrecortocarrera ,EG.numerodocumento
							FROM estudiantegeneral EG
							INNER JOIN estudiante E ON (EG.idestudiantegeneral=E.idestudiantegeneral)
							INNER JOIN carrera C ON (E.codigocarrera=C.codigocarrera)
							WHERE EG.numerodocumento='".str_replace("'","",$data[3])."'
							AND C.codigomodalidadacademica = '200'";
					if($dataSala=&$db->GetAll($Sql) === false){
						echo 'Ocurrio un error al consultar la data';
						die;
					}
					/* Busqueda por documento y cualquier programa*/
					if(empty($dataSala)){
						  $Sql="SELECT EG.apellidosestudiantegeneral, EG.nombresestudiantegeneral,EG.idestudiantegeneral,
						  EG.tipodocumento,C.nombrecortocarrera ,EG.numerodocumento
						  
							FROM estudiantegeneral EG
							INNER JOIN estudiante E ON (EG.idestudiantegeneral=E.idestudiantegeneral)
							INNER JOIN carrera C ON (E.codigocarrera=C.codigocarrera)
							WHERE EG.numerodocumento='".str_replace("'","",$data[3])."' LIMIT 1"; 
						if($dataSala=&$db->GetAll($Sql) === false){
							echo 'Ocurrio un error al consultar la data';
							die;
						}
					}
					
				}
				/* Busqueda por nombres y apellidos*/
					if(empty($dataSala)){
							$Sql="SELECT  EG.apellidosestudiantegeneral, EG.nombresestudiantegeneral,EG.idestudiantegeneral,EG.tipodocumento,C.nombrecortocarrera ,
							EG.numerodocumento
							FROM estudiantegeneral EG
							INNER JOIN estudiante E ON (EG.idestudiantegeneral=E.idestudiantegeneral)
							INNER JOIN carrera C ON (E.codigocarrera=C.codigocarrera)
							WHERE EG.nombresestudiantegeneral = '".$data[1]." ' 
								AND	EG.apellidosestudiantegeneral  = '".$data[0]."'
						GROUP BY EG.idestudiantegeneral limit 1";
						if($dataSala=&$db->GetAll($Sql) === false){
							echo 'Ocurrio un error al consultar la data';
							die;
						}
					}
					
				$idEstudiante = $dataSala[0]['idestudiantegeneral'];
				$tipoDocumento = $dataSala[0]['tipodocumento'];
				$nombrecortocarrera = $dataSala[0]['nombrecortocarrera'];
				$apellidosestudiantegeneral= $dataSala[0]['apellidosestudiantegeneral'];
				$nombresestudiantegeneral= $dataSala[0]['nombresestudiantegeneral'];
				
				if(!empty($dataSala)){
					$data[3]=$dataSala[0]['numerodocumento'];
						if(empty($data[4])){
							$data[4] = $nombrecortocarrera;
							$cambio .= "<tr><td>".$data[0]."</td>".
										 "<td>".$data[1]."</td>".
										 "<td>".$data[3]."</td>".
										 "<td>".$idEstudiante."</td></tr>"; 
						}
						if(empty($data[0])){
													$data[0] = $apellidosestudiantegeneral;
													$cambio .= "<tr><td>".$data[0]."</td>".
																 "<td>".$data[1]."</td>".
																 "<td>".$data[3]."</td>".
																 "<td>".$idEstudiante."</td></tr>"; 
						}
						if(empty($data[1])){
													$data[1] = $nombresestudiantegeneral;
													$cambio .= "<tr><td>".$data[0]."</td>".
																 "<td>".$data[1]."</td>".
																 "<td>".$data[3]."</td>".
																 "<td>".$idEstudiante."</td></tr>"; 
						}						
						if(($data[2] === 'C' )&&($tipoDocumento !== '01')){
							if($tipoDocumento === '02'){
								$tipoDocumento = 'T';
							}
							if($tipoDocumento === '03'){
								$tipoDocumento = 'E';
							}
								$html.= "<tr><td>".$data[0]."</td>".
										 "<td>".$data[1]."</td>".
										 "<td>".$tipoDocumento."</td>".
										 "<td>".$data[3]."</td><td>".$data[4]."</td></tr>";
										 
								 $cambio .= "<tr><td>".$data[0]."</td>".
								 "<td>".$data[1]."</td>".
								 "<td>".$data[3]."</td>".
								 "<td>".$idEstudiante."</td></tr>";
						}else if(($data[2] === 'T' )&&($tipoDocumento !== '02')){
							if($tipoDocumento === '01'){
								$tipoDocumento = 'C';
							}
							if($tipoDocumento === '03'){
								$tipoDocumento = 'E';
							}
							 $html.= "<tr><td>".$data[0]."</td>".
										 "<td>".$data[1]."</td>".
										 "<td>".$tipoDocumento."</td>".
										 "<td>".$data[3]."</td><td>".$data[4]."</td></tr>";
										 
							$cambio .= "<tr><td>".$data[0]."</td>".
										 "<td>".$data[1]."</td>".
										 "<td>".$data[3]."</td>".
										 "<td>".$idEstudiante."</td></tr>";
						}else if(($data[2] === 'E' )&&($tipoDocumento !== '03')){
							if($tipoDocumento === '01'){
								$tipoDocumento = 'C';
							}
							if($tipoDocumento === '02'){
								$tipoDocumento = 'T';
							}
							$html.= "<tr><td>".$data[0]."</td>".
										 "<td>".$data[1]."</td>".
										 "<td>".$tipoDocumento."</td>".
										 "<td>".$data[3]."</td><td>".$data[4]."</td></tr>";
							$cambio .= "<tr><td>".$data[0]."</td>".
										 "<td>".$data[1]."</td>".
										 "<td>".$data[3]."</td>".
										 "<td>".$idEstudiante."</td></tr>"; 
						}else{
								$html.= "<tr><td>".$data[0]."</td>".
										 "<td>".$data[1]."</td>".
										 "<td>".$data[2]."</td>".
										 "<td>".$data[3]."</td><td>".$data[4]."</td></tr>";
						}
				
				}else{
					
					$html.= "<tr><td>".$data[0]."</td>".
										 "<td>".$data[1]."</td>".
										 "<td>".$data[2]."</td>".
										 "<td>".$data[3]."</td><td>".$data[4]."</td></tr>";
						 	$cambioNo .= "<tr><td>".$data[0]."</td>".
								 "<td>".$data[1]."</td>".
								 "<td>".$data[3]."</td>".
								 "</tr>"; 
				}
			
				
				
			}
			$i=$i+1;
			
		}
			echo ($html);
	}
    }
    ?>
	
	</tbody>
	</table>
	<br><br>
	<b><H3>Cambios Realizados</H3></b>
	<table id="cambios" border="3" >
		<thead>
			<th>Apellido</th>
			<th>Nombre</th>
			<th>Documento</th>
		</thead>	
		<tbody>
			<?php 
				echo utf8_encode($cambio);
			?>
		</tbody>
	</table>	
	<br><br>
	<b><H3>Cambios NO Realizados por algún tipo de Error</H3></b>
	<table id="nocambios" border="3" >
		<thead>
			<th>Nombre</th>
			<th>Apellido</th>
			<th>Documento</th>
		</thead>	
		<tbody>
			<?php 
				echo ($cambioNo);
			?>
		</tbody>
	</table>
	
</html>

