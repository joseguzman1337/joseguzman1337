<?php
if(isset($_POST['buscar']) &&  isset($_FILES)){
/*header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=reporte_".date('Y-m-d').".xls");
header("Pragma: no-cache");
header("Expires: 0");*/
}
session_start();
    include_once ('../EspacioFisico/templates/template.php');
    $db = getBD();
	require_once('../educacionContinuada/Excel/reader.php');

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
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
		<link href="//datatables.net/download/build/nightly/jquery.dataTables.css?_=0188ba71c41a05452766c8a4627b767f.css" rel="stylesheet" type="text/css" />
		<!--<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
		<script src="//datatables.net/download/build/nightly/jquery.dataTables.js?_=0188ba71c41a05452766c8a4627b767f"></script>-->
		<script>
		$(document).ready(function(){
			$("form").submit(function(){
				var periodo = $("#periodo").val();
				if(periodo == ''){
					alert("Debe Seleccionar Periodo");
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
            <form name="f1" id="f1" action="ReporteSpadies.php" method="POST" enctype="multipart/form-data">
               <label>Archivo Excel:</label>
				<input type="file" class="required" value="" name="file" id="file" /><br/><br/>
				<label>Archivo Csv:</label><input type="file" class="required" value="" name="fileCsv" id="fileCsv" /><br/><br/>
				<label>Seleccione Periodo</label><select id="periodo" name="periodo">
												<option value="">Seleccione</option>
												<option value="1998-1">1998-1</option>
												<option value="1998-2">1998-2</option>
												<option value="1999-1">1999-1</option>
												<option value="1999-2">1999-2</option>
												<option value="2000-1">2000-1</option>
												<option value="2000-2">2000-2</option>
												<option value="2001-1">2001-1</option>
												<option value="2001-2">2001-2</option>
												<option value="2002-1">2002-1</option>
												<option value="2002-2">2002-2</option>												
												<option value="1995-1">2003-1</option>
												<option value="1995-2">2003-2</option>
												<option value="1996-1">2004-1</option>
												<option value="1996-2">2004-2</option>
												<option value="1997-1">2005-1</option>
												<option value="1997-2">2005-2</option>
												<option value="1997-1">2006-1</option>
												<option value="1997-2">2006-2</option>
												</select><br/><br/>
				<!--<a href="ejemploPreinscritos.xls">Descargar plantilla de ejemplo</a><br/><br/>-->
                        <input name="buscar" id="buscar" type="submit" value="Generar">
            </form>
        </div>
    </body>
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
	</thead>
	<tbody>	
    <?php	
    if(isset($_POST['buscar']) &&  isset($_FILES)){
        
		//PROCESAR EL ARCHIVO 
		$dataEx = new Spreadsheet_Excel_Reader();		
		$dataEx->setOutputEncoding('CP1251');        
		$dataEx->read($_FILES["file"]["tmp_name"]);
        $filas = $dataEx->sheets[0]['numRows'];
		$tempFile = $_FILES['fileCsv']['tmp_name'];
		$nombre = $_FILES['fileCsv']['name'];
		$tipo = $_FILES['fileCsv']['type'];
		$tamano = $_FILES['fileCsv']['size'];
		$handle = fopen($tempFile,"r");
		$periodo=$_POST['periodo'];
		$i=0;
		$html="";
		$cambio="";
		$cambioNo="";
		$temp = null;
		while ($data = fgetcsv ($handle, 1000, ";")){ 
			if($i>0){
			//se asume la primera como titulo
			for ($z = 2; $z <= $filas; $z++) {
					
						if($dataEx->sheets[0]['cells'][$z][28] === $periodo){
							if($dataEx->sheets[0]['cells'][$z][8] < 10){
								$fields['e_nacimiento_dia']="0".$dataEx->sheets[0]['cells'][$z][8]."/";	
							}else{
								$fields['e_nacimiento_dia']=$dataEx->sheets[0]['cells'][$z][8]."/";	
							}
							$fields['e_nacimiento_mes']=$dataEx->sheets[0]['cells'][$z][9]."/";
							$fields['e_nacimiento_a�o']=$dataEx->sheets[0]['cells'][$z][10];
							if($data[3] === ($fields['e_doc_num']=$dataEx->sheets[0]['cells'][$z][7])){
									$cambio.="<tr><td>".$fields['e_nombre']=$dataEx->sheets[0]['cells'][$z][4]."</td>".
											 "<td>".$fields['e_apellido']=$dataEx->sheets[0]['cells'][$z][5]."</td>".
											 "<td>".$fields['e_doc_num']=$dataEx->sheets[0]['cells'][$z][7]."</td></tr>";											
									$html = $fields['e_nacimiento_dia'].$fields['e_nacimiento_mes'].$fields['e_nacimiento_a�o'];
									$cambios[]=$dataEx->sheets[0]['cells'][$z][7];
							}else{
								
								if($data[0] === (trim($dataEx->sheets[0]['cells'][$z][5]))){
									$cambio.="<tr><td>".$fields['e_nombre']=$dataEx->sheets[0]['cells'][$z][4]."</td>".
											 "<td>".$fields['e_apellido']=$dataEx->sheets[0]['cells'][$z][5]."</td>".
											 "<td>".$dataEx->sheets[0]['cells'][$z][7]."</td></tr>";											
									$html = $fields['e_nacimiento_dia'].$fields['e_nacimiento_mes'].$fields['e_nacimiento_a�o'];
									$idDocu = $dataEx->sheets[0]['cells'][$z][7];
									$cambios[]=$dataEx->sheets[0]['cells'][$z][7];
								}
								
							}
						}
			}
			if(!empty($html)){
				$data2= $html;
			}else{
				$data2= $data[7];
			}
			if(!empty($idDocu)){
				$data[3]= $idDocu;
			}
			echo "<tr><td>".$data[0]."</td>";
			echo "<td>".$data[1]."</td>";
			echo "<td>".$data[2]."</td>";
			echo "<td>".$data[3]."</td>";
			echo "<td>".$data[4]."</td>";
			echo "<td>".$data[5]."</td>";
			echo "<td>".$data[6]."</td>";
			echo "<td>".$data2."</td>";
			echo "<td>".$data[8]."</td></tr>";
			$html="";
			$data2="";
			}
			$i=$i+1;
		}
		$registros=count($cambios);
		for ($z = 2; $z <= $filas; $z++) 
		{
			for($f=0; $f<=$registros; $f++){
				$idCambiado=$cambios[$f];
				$idExcel= $dataEx->sheets[0]['cells'][$z][7];
				
				if($dataEx->sheets[0]['cells'][$z][28] === $periodo){
					if($idCambiado === $idExcel){
						$temp = 1;
						break;
					}
				}
			}
			//echo "<br>T->".$temp."-Idcambiado->".$idCambiado."idExcel->".$idExcel;
			
			if(empty($temp)){
				
				if($dataEx->sheets[0]['cells'][$z][28] === $periodo){
					
					$cambioNo.="<tr><td>".$fields['e_nombre']=$dataEx->sheets[0]['cells'][$z][4]."</td>".
					 "<td>".$fields['e_apellido']=$dataEx->sheets[0]['cells'][$z][5]."</td>".
					 "<td>".$fields['e_doc_num']=$dataEx->sheets[0]['cells'][$z][7]."</td></tr>";
				}	 
			}
			$temp=null;		
		}//for
	
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
				echo $cambio;
			?>
		</tbody>
	</table>	
	<br><br>
	<b><H3>Cambios NO Realizados</H3></b>
	<table id="nocambios" border="3" >
		<thead>
			<th>Nombre</th>
			<th>Apellido</th>
			<th>Documento</th>
		</thead>	
		<tbody>
			<?php 
				echo $cambioNo;
			?>
		</tbody>
	</table>
	
</html>
