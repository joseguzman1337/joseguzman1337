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
        <title>Cargar asistentes a diploma</title>
		<!--<link rel="stylesheet" type="text/css" href="../mgi/css/themes/smoothness/jquery-ui-1.8.4.custom.css" media="screen" /> --> 
        <link rel="stylesheet" type="text/css" href="../../../mgi/css/styleOrdenes.css" media="screen" />
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
		<script type="text/javascript" language="javascript" src="../../../mgi/js/functions.js"></script>
    </head>
    <body>
        <div id="pageContainer" class="wrapper" align="center">
			<h4>Cargue de asistentes en Excel</h4>

            <form name="f1" action="../crons/aspirantesEducacionContinuada.php" method="POST" enctype="multipart/form-data">
               <label>Archivo con Ordenes:</label>
				<input type="file" class="required" value="" name="file" id="file" /><br/><br/>
				<a href="ejemploParticipantes.xls">Descargar plantilla de ejemplo</a><br/><br/>
                      
                            <label>Número de diploma :</label>
                            <input name="diploma" id='diploma' type="text" /><br/><br/>
                       
                        <input name="buscar" type="submit" value="Cargar asistentes">
                       
               
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
        $iddiploma=$_POST['diploma'];
		//se asume la primera como titulo
		for ($z = 2; $z <= $filas; $z++) {
			$asistente=$data->sheets[0]['cells'][$z][1];
			$fields['numerodocumento']=trim($data->sheets[0]['cells'][$z][3]);
            $fields['nombre']=$data->sheets[0]['cells'][$z][1];
            $fields['apellidos']=$data->sheets[0]['cells'][$z][2];
            $fields['tipodocumento']=$data->sheets[0]['cells'][$z][4];
			if($asistente!=""){
				$filaReal = true;
			}
			            
            //verificar que no fue inscrito antes
            $sql = "SELECT a.idasistente FROM asistentediploma ad 
			INNER JOIN asistente a on a.idasistente=ad.idasistente AND ad.codigoestado=100 
			WHERE a.documentoasistente='".$fields['numerodocumento']."' AND ad.iddiploma='".$iddiploma."' ORDER BY a.idasistente DESC";
            $result = $db->GetRow($sql);
                
            //echo "<pre>";print_r($result);echo "<br/><br/>";
            if(count($result)>0 && $fields['numerodocumento']!="")
            {
				$sql = "UPDATE `asistente` SET `nombreasistente`='".utf8_encode($fields['nombre'])."', 
				`apellidoasistente`='".utf8_encode($fields['apellidos'])."' WHERE (`idasistente`='".$result["idasistente"]."')";
				$db->Execute($sql);
                ?>
                <td><?php echo $fields['numerodocumento'];?> no agregado</td>                                  
                <?php
            }else 
            {
                //realiza una consulta para verificar si existe un asistente con ese numero de identificaion	
                $sql = "SELECT * FROM asistente a  WHERE a.documentoasistente='".$fields['numerodocumento']."' ORDER BY idasistente ASC";
                $result = $db->GetRow($sql);
				//pregunta si? la consulta tiene resultados y si no ahy un asistente con esos datos para a  la segunda parte para crear el registro asociado de del asistente
				if(count($result)==0 && $fields['numerodocumento']!="")
                {
                    $sqlAsistente ="INSERT INTO asistente (nombreasistente, apellidoasistente, documentoasistente, tipodocumento) VALUES ('".utf8_encode($fields['nombre'])."', 
					'".utf8_encode($fields['apellidos'])."', '".$fields['numerodocumento']."', '0".$fields['tipodocumento']."')";
                    $result=$db->Execute($sqlAsistente);
                    ?>
                    <td>Asistente: <?php echo utf8_encode($fields['nombre']).' - '.$fields['numerodocumento'].' - '.$fields['tipodocumento']; ?></td>
                    <?php
       	        } 
                    //si ya existia un registro del asistente pasa a registrar los datos asociados del diploma
				    //obtiene el numero de idasistente para crear el insert y ejecutar el ultimo paso de registro de datos 
                        $sql = "SELECT idasistente FROM asistente a  WHERE a.documentoasistente='".$fields['numerodocumento']."' ORDER BY idasistente DESC";
                        $result = $db->GetRow($sql);
                        if(count($result)>0)
                        {
				
						$sql = "UPDATE `asistente` SET `nombreasistente`='".utf8_encode($fields['nombre'])."', 
						`apellidoasistente`='".utf8_encode($fields['apellidos'])."' WHERE (`idasistente`='".$result["idasistente"]."')";
						$db->Execute($sql);
                         $sqlAsistenteDiploma ="INSERT INTO asistentediploma (idasistente, iddiploma, codigoestado) VALUES ('".$result['idasistente']."', '".$iddiploma."', '100')";
                          $result=$db->Execute($sqlAsistenteDiploma);
                          ?>
                          <td>AsistenteDiploma:<?php echo utf8_encode($fields['nombre']).' - '.$fields['numerodocumento'].' - '.$fields['tipodocumento']; ?></td>
                          <?php  
                        }else{
                            ?>
                          <td> Ya existe en la tabla AsistenteDiploma: <?php echo utf8_encode($fields['nombre']).' - '.$fields['numerodocumento'].' - '.$fields['tipodocumento']; ?></td>
                          <?php
                        }
                }
                ?>
                </tr>
				<?php 
		}
    }
    ?>
</html>
