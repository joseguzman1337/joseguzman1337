<?php
session_start();
    require_once("../templates/template.php");
    $db = getBD();
	require_once('../../../educacionContinuada/Excel/reader.php');
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
        <div id="pageContainer" class="wrapper" align="center">
			<h4>Cargue de docentes desde Excel</h4>

            <form name="f1" action="actualizarDocentesCargaAcademica.php" method="POST" enctype="multipart/form-data">
               <label>Archivo con Docentes:</label>
				<input type="file" class="required" value="" name="file" id="file" /><br/><br/>
				<a href="ejemploDocentes.xls">Descargar plantilla de ejemplo</a><br/><br/>                      
                       
                        <input name="buscar" type="submit" value="Cargar docentes">
                       
               
            </form>
        </div>
    </body>
    <?php
	
    if(isset($_POST['buscar']) &&  isset($_FILES)){		
        ?> 
        <table>
        <tr>
        <?php
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
			$tipoDoc=$data->sheets[0]['cells'][$z][1];
			$fields['numerodocumento']=trim($data->sheets[0]['cells'][$z][2]);
            $fields['departamento']=$data->sheets[0]['cells'][$z][9];
			if($tipoDoc!=""){
				$filaReal = true;
			}
			            
            //verificar que no fue inscrito antes
            $sql = "SELECT * FROM docentesvoto d 
			WHERE d.numerodocumento='".$fields['numerodocumento']."' ";
            $result = $db->GetRow($sql);
                //echo $sql;
           //echo "<pre>";print_r($result);echo "<br/><br/>";
            if(count($result)>0 && $fields['numerodocumento']!="")
            {
                ?>
                <td><?php echo $fields['numerodocumento'];?> ya existe</td>                                  
                <?php
            }else 
            {
                //realiza una consulta para verificar si existe un asistente con ese numero de identificaion	
                $sql = "SELECT * FROM carrera a  WHERE a.centrocosto='".$fields['departamento']."' OR a.codigocentrobeneficio='".$fields['departamento']."'";
                $result = $db->GetRow($sql);
				//pregunta si? la consulta tiene resultados y si no ahy un asistente con esos datos para a  la segunda parte para crear el registro asociado de del asistente
				if(count($result)>0 && $fields['numerodocumento']!="")
                {
                    $sqlAsistente ="INSERT INTO `docentesvoto` (
								`numerodocumento`,
								`codigocarrera`
							)
							VALUES
								('".$fields['numerodocumento']."', '".$result['codigocarrera']."') ";
					$result=$db->Execute($sqlAsistente);
                    ?>
                    <td>Docente: <?php echo utf8_encode($fields['departamento']).' - '.$fields['numerodocumento'].' - '.$fields['tipodocumento'].' - '.$sqlAsistente; ?></td>
                    <?php
       	        } else { 
                    //que paso centro de costo ?>
				<td>Activado: <?php echo "NO SE ENCONTRO CENTRO DE COSTO: ".$fields['departamento'];?></td>
				<?php } 
            }
                ?>
                </tr>
				<?php 
		}
    }
    ?>
</html>
