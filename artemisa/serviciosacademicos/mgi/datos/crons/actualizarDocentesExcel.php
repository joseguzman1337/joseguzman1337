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

            <form name="f1" action="actualizarDocentesExcel.php" method="POST" enctype="multipart/form-data">
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
            $fields['nombre']=$data->sheets[0]['cells'][$z][3];
            $fields['apellidos']=$data->sheets[0]['cells'][$z][4];
            $fields['fechaContrato']=$data->sheets[0]['cells'][$z][5];
            $fields['correo']=$data->sheets[0]['cells'][$z][11];
            $fields['genero']=$data->sheets[0]['cells'][$z][12];
			if($tipoDoc!=""){
				$filaReal = true;
			}
			            
            //verificar que no fue inscrito antes
            $sql = "SELECT * FROM docente d 
			WHERE d.numerodocumento='".$fields['numerodocumento']."' AND d.codigoestado=100";
            $result = $db->GetRow($sql);
                
            //echo "<pre>";print_r($result);echo "<br/><br/>";
            if(count($result)>0 && $fields['numerodocumento']!="")
            {
                ?>
                <td><?php echo $fields['numerodocumento'];?> ya existe</td>                                  
                <?php
            }else 
            {
                //realiza una consulta para verificar si existe un asistente con ese numero de identificaion	
                $sql = "SELECT * FROM docente a  WHERE a.numerodocumento='".$fields['numerodocumento']."' ";
                $result = $db->GetRow($sql);
				//pregunta si? la consulta tiene resultados y si no ahy un asistente con esos datos para a  la segunda parte para crear el registro asociado de del asistente
				if(count($result)==0 && $fields['numerodocumento']!="")
                {
                    $sqlAsistente ="INSERT INTO `docente` (
								`tipodocumento`,
								`codigodocente`,
								`numerodocumento`,
								`nombredocente`,
								`apellidodocente`,
								`fechaprimercontratodocente`,
								`emaildocente`,
								`codigogenero`
							)
							VALUES
								('".$tipoDoc."', '".$fields['numerodocumento']."', '".$fields['numerodocumento']."', '".utf8_encode($fields['nombre'])."', '".utf8_encode($fields['apellidos'])."', '".$fields['fechaContrato']."', '".$fields['correo']."', '".$fields['genero']."') ";
					$result=$db->Execute($sqlAsistente);
                    ?>
                    <td>Docente: <?php echo utf8_encode($fields['nombre']).' - '.$fields['numerodocumento'].' - '.$fields['tipodocumento'].$sqlAsistente; ?></td>
                    <?php
       	        } else { 
                    //si ya existia un registro se activa
                        $sql = "UPDATE docente SET `codigoestado`='100' WHERE numerodocumento='".$fields['numerodocumento']."' ";
                        $result = $db->Execute($sql); ?>
				<td>Activado: <?php echo $fields['numerodocumento'];?></td>
				<?php } 
            }
                ?>
                </tr>
				<?php 
		}
    }
    ?>
</html>
