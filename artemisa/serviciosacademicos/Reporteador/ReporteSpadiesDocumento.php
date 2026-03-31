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
        /*@modified Diego Rivera <riveradiego@unbosque.edu.co>
         *se cambia css exstera<link href="//datatables.net/download/build/nightly/jquery.dataTables.css?_=0188ba71c41a05452766c8a4627b767f.css" rel="stylesheet" type="text/css" />
	  por css local
         *@since November 30,2018 
         */
        ?>
        <title>Diferencias Documento</title>
		<link  type="text/css" href="css/dataTables.tableTools.css" rel="stylesheet">
		<link  type="text/css" href="css/jquery.dataTables.css" rel="stylesheet">
               <script type="text/javascript" language="javascript" src="js/jquery.js"></script>
		<script type="text/javascript" charset="utf-8" src="js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8" src="js/dataTables.tableTools.js"></script>
		<!--<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
		<script src="//datatables.net/download/build/nightly/jquery.dataTables.js?_=0188ba71c41a05452766c8a4627b767f"></script>-->
		<script>
		$(document).ready(function(){
			
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
            <form name="f1" id="f1" action="ReporteSpadiesDocumento.php" method="POST" enctype="multipart/form-data">
               <label>Archivo CSV:</label>
				<input type="file" class="required" value="" name="file" id="file" /><br/><br/>
				<!--<label>Archivo Csv:</label><input type="file" class="required" value="" name="fileCsv" id="fileCsv" /><br/><br/>-->
				<!--<a href="ejemploPreinscritos.xls">Descargar plantilla de ejemplo</a><br/><br/>-->
                        <input name="buscar" id="buscar" type="submit" value="Generar">
            </form>
        </div>
    </body>
	<table id="myTable" class="display" cellspacing="0" width="100%">
	 <thead>
		<th>ies_codigo</th>
		<th>ies_nombre</th>
		<th>e_num_estudiante</th>
		<th>e_nombre</th>
		<th>e_apellido</th>
		<th>e_doc_tipo</th>
		<th>e_doc_num</th>
		<th>e_nacimiento_dia</th>
		<th>e_nacimiento_mes</th>
		<th>e_nacimiento_a�o</th>
		<th>e_sexo</th>
		<th>tipo_registro</th>
		<th>s11_cruzo</th>
		<th>ice_cruzo</th>
		<th>prog_cod</th>
		<th>prog_nombre</th>
		<th>prog_area</th>
		<th>prog_nucleo</th>
		<th>prog_metodologia</th>
		<th>prog_nivel</th>
		<th>em_segvar</th>
		<th>em_mat_tomadas</th>
		<th>em_mat_aprobadas</th>
		<th>em_apo_aca</th>
		<th>em_apo_fin</th>
		<th>em_apo_otr</th>
		<th>em_ice</th>
		<th>PERIODO</th>
	</thead>
	<tbody>	
    <?php	
    if(isset($_POST['buscar']) &&  isset($_FILES)){
        
		//PROCESAR EL ARCHIVO 
		$tempFile = $_FILES['file']['tmp_name'];
		$nombre = $_FILES['file']['name'];
		$tipo = $_FILES['file']['type'];
		$tamano = $_FILES['file']['size'];
		$handle = fopen($tempFile,"r");
		$html="";
		$cambio="";
		$cambioNo="";
		$temp = null;
		$cero=0;
		$funcionCero=null;
		while ($data = fgetcsv ($handle, 1000, ";")){
			if($i>0){	
			echo "<tr><td>".$data[0]."</td>";
			echo "<td>".$data[1]."</td>";
			echo "<td>".$data[2]."</td>";
			echo "<td>".$data[3]."</td>";
			echo "<td>".$data[4]."</td>";
			 $SQL = "SELECT
					tipodocumento,
					numerodocumento
				FROM
					estudiantegeneral
				WHERE
					numerodocumento = '".$data[6]."'";
			
			if($Resultado=&$db->GetAll($SQL)===false){
				echo 'Error en consulta a base de datos1';
				die;
			}
			if($Resultado[0]['numerodocumento'] === $data[6]){
				if(trim($data[5]) === 'T'){
					if($Resultado[0]['tipodocumento'] === '02'){
						$cadena=$Resultado[0]['numerodocumento'];
						$total=strlen($cadena);
						if($total < 11){
							for($i=$total;$i<11;$i++){
								$funcionCero.=$cero;
							}
							$cambio.="<tr><td>".$data[3]."</td>".
											 "<td>".$data[4]."</td>".
											 "<td>".$data[6]."</td>".
											 "<td>".$data[27]."</td></tr>";	
						}
					}else{
						$cambioNo.="<tr><td>".$data[3]."</td>".
											 "<td>".$data[4]."</td>".
											 "<td>".$data[6]."</td>".
											 "<td>".$data[27]."</td></tr>";	
					}
				}else{
					$cambioNo.="<tr><td>".$data[3]."</td>".
											 "<td>".$data[4]."</td>".
											 "<td>".$data[6]."</td>".
											 "<td>".$data[27]."</td></tr>";	
				}
			}else{
				$cambioNo.="<tr><td>".$data[3]."</td>".
											 "<td>".$data[4]."</td>".
											 "<td>".$data[6]."</td>".
											 "<td>".$data[27]."</td></tr>";	
			}
			echo "<td>".$data[5]."</td>";
			echo "<td>".$funcionCero.$data[6]."</td>";			
			echo "<td>".$data[7]."</td>";
			echo "<td>".$data[8]."</td>";
			echo "<td>".$data[9]."</td>";
			echo "<td>".$data[10]."</td>";
			echo "<td>".$data[11]."</td>";
			echo "<td>".$data[12]."</td>";
			echo "<td>".$data[13]."</td>";
			echo "<td>".$data[14]."</td>";
			echo "<td>".$data[15]."</td>";
			echo "<td>".$data[16]."</td>";
			echo "<td>".$data[17]."</td>";
			echo "<td>".$data[18]."</td>";
			echo "<td>".$data[19]."</td>";
			echo "<td>".$data[20]."</td>";
			echo "<td>".$data[21]."</td>";
			echo "<td>".$data[22]."</td>";
			echo "<td>".$data[23]."</td>";
			echo "<td>".$data[24]."</td>";
			echo "<td>".$data[25]."</td>";
			echo "<td>".$data[26]."</td>";
			echo "<td>".$data[27]."</td></tr>";
			
			}$funcionCero=null;$i=$i+1;
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
			<th>Documento Original</th>
			<th>Periodo</th>
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
			<th>Documento Original</th>
			<th>Periodo</th>
		</thead>	
		<tbody>
			<?php 
				echo $cambioNo;
			?>
		</tbody>
	</table>
	
</html>
