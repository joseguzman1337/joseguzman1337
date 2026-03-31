<?php

	session_start();
	if(empty($_SESSION['MM_Username'])){
		echo "No ha iniciado sesión en el sistema";
		exit();
	}
    require_once("../templates/template.php");
    $db = getBD();
	//require_once('../../../educacionContinuada/Excel/reader.php');
    require_once('../../../../sala/assets/plugins/PHPExcel-1.8/Classes/PHPExcel.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
        <title>Cargar asistentes a diploma</title>
		<link rel="stylesheet" type="text/css" href="../../../../sala/assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="../../../../sala/assets/css/select2.min.css" />
        <!--<link rel="stylesheet" type="text/css" href="../../../mgi/css/styleOrdenes.css" media="screen" />-->
        <script type="text/javascript" language="javascript" src="../../../../sala/assets/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="../../../../sala/assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../../../../sala/assets/js/select2.min.js"></script>
		<link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css" />
    </head>
    <body>
        <div class="container">
            <div class="text-center">
                <h4>Cargue de asistentes en Excel</h4>
                <a href="ejemploParticipantes.xls">Descargar plantilla de ejemplo</a><br/><br>
                <form class="form-horizontal" role="form" action="../crons/aspirantesEducacionContinuadaAuto.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="col-lg-offset-4 col-lg-8">
                            <input type="file" class="required file" value="" name="file" id="file" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="selectDiplomas" class="col-lg-2 control-label">Nombre Diploma:</label>
                        <div class="col-lg-10">
                        <select class="form-control" id="selectDiplomas" name="diploma" required=”required”>
                            <option value="" disabled selected>Seleccion</option>
                            <?php
                            $sql = "SELECT iddiploma,nombrediploma 
                                        FROM diploma
                                        WHERE codigoestado=100";
                            $cnsDiplomas = $db->GetAll($sql);

                            foreach ($cnsDiplomas as $key => $value) {
                                $idDiploma =  $value['iddiploma'];
                                $nombreDiploma =  trim($value['nombrediploma']);
                                ?>
                                <option value="<?php echo $idDiploma;?>"><?php echo $nombreDiploma;?></option>
                            <?php } ?>
                        </select>
                            <input type="hidden" id="id_diploma" name="id_diploma" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button type="submit" name="buscar" id="buscar" class="btn btn-default" >Cargar asistentes</button>
                        </div>
                    </div>
                </form>
            </div>
        <div class="">
            <div class="row">
                <div class="p-3 mb-2 bg-success text-white">Registrado Correctamente</div>
                <div class="p-3 mb-2 bg-warning text-dark">No registro el asistente al Diploma</div>
                <div class="p-3 mb-2 bg-info text-white">Asistente Existente en Diploma</div>
                <div class="p-3 mb-2 bg-danger text-white">No se registro en tabla asistente</div>
            </div>
            <br>
    <?php
    if(isset($_POST['buscar']) &&  isset($_FILES)){
        ?>
        <div class="row">
            <div class="text-center col-sm-1 p-3 mb-2 bg-info text-white">#</div>
            <div class="col-sm-4 bg-info" >Nombre</div>
            <div class="col-sm-4 bg-info">Apellido</div>
            <div class="col-sm-2 mb-2 bg-info">Documento</div>
            <div class="col-sm-1 bg-info">Tipo</div>
        </div>
        <?php
        $archivoExcel = $_FILES["file"]["tmp_name"];
        $inputFileType = PHPExcel_IOFactory::identify($archivoExcel);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($archivoExcel);
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $num=0;

        for ($row = 2; $row <= $highestRow; $row++){ $num++;
            $nombreAsistente = $sheet->getCell("A".$row)->getValue();
            $apellidosAsistente = $sheet->getCell("B".$row)->getValue();
            $numeroDocumento = $sheet->getCell("C".$row)->getValue();
            $tipoDocumento = $sheet->getCell("D".$row)->getValue();

            $idDiploma = $_POST['diploma'];
            if ($tipoDocumento < 10){ $tipoDocumento = "0".$tipoDocumento; }

            ?>
            <div class="row">
            <?php
            if ($numeroDocumento <> ''){
                $sql = "SELECT * FROM asistente WHERE documentoasistente=".trim($numeroDocumento)." ORDER BY idasistente DESC";
                $result = $db->GetRow($sql);
                if(!empty($result))
                {
                    $idAsistenteSql = $result["idasistente"];
                    //$idDiploma = $result[0]["iddiploma"];
                    $sql = "UPDATE asistente 
                        SET nombreasistente = '".$nombreAsistente."', 
                    apellidoasistente='".$apellidosAsistente."'
                     WHERE (`idasistente`='".$result["idasistente"]."')";
                    $db->Execute($sql);
                    $sqlAsistenteDiploma = "SELECT * FROM asistentediploma WHERE idasistente=".$idAsistenteSql." AND iddiploma=".$idDiploma." AND codigoestado=100";
                    $fila = $db->GetAll($sqlAsistenteDiploma);
                    if(count($fila)>0){
                        $estilo = "p-3 mb-2 bg-info text-white";
                        $title = "El Asistente ya se encuentra relacionado al diploma ".$idDiploma;
                    }else{
                        $sqlAsistenteDiploma ="INSERT INTO asistentediploma (idasistente, iddiploma, codigoestado)
                                           VALUES ('".$idAsistenteSql."', '".$idDiploma."', '100')";
                        if ($db->Execute($sqlAsistenteDiploma)){
                            $estilo = "p-3 mb-2 bg-success text-white";
                            $title = "Se registro el asistente al diploma ".$idDiploma;
                        }else{
                            $estilo = "p-3 mb-2 bg-warning text-white";
                            $title = "Error al Registrar el asistente a diploma ".$idDiploma." se puede deber a que el numero de documento contenga espacios";
                        }
                    }
                    ?>
                    <div class="text-center col-sm-1 p-3 mb-2 bg-info text-white"><?php echo $num; ?></div>
                    <div class=" col-sm-4 <?php echo $estilo;?>" title="<?php echo $title;?>"> <?php echo $nombreAsistente; ?></div>
                    <div class=" col-sm-4 <?php echo $estilo;?>"> <?php echo $apellidosAsistente; ?></div>
                    <div class=" col-sm-2 <?php echo $estilo;?>"> <?php echo trim($numeroDocumento); ?></div>
                    <div class="text-center col-sm-1 <?php echo $estilo;?>"> <?php echo $tipoDocumento; ?></div>
                    <?php

                }else{
                    $sql="INSERT INTO asistente (nombreasistente,apellidoasistente,documentoasistente,tipodocumento)
                          VALUES('".$nombreAsistente."','".$apellidosAsistente."','".$numeroDocumento."','".$tipoDocumento."')";
                    $insertAsistente = $db->Execute($sql);
                    if ($insertAsistente){
                        $idAsistenteSql = $db->insert_Id();
                        $sqlAsistenteDiploma ="INSERT INTO asistentediploma (idasistente, iddiploma, codigoestado)
                                           VALUES ('".$idAsistenteSql."', '".$idDiploma."', '100')";
                        $insertAsistenteDiploma = $db->Execute($sqlAsistenteDiploma);
                        //$insertAsistenteDiploma = insertaAsistenteDiploma($db,$iddiploma,$idAsistenteSql);
                        if (!$insertAsistenteDiploma){
                            $estilo = "p-3 mb-2 bg-warning text-dark";// no inserto en tabla asistentediploma
                            $title = "Error al Registrar el asistente a diploma".$idDiploma." se puede deber a que el numero de documento contenga espacios";
                        }else{
                            $estilo = "p-3 mb-2 bg-success text-white";// inserto correctamente
                            $title = "Asistente Registrado a diploma ".$idDiploma;
                        }
                    }else{
                        $estilo = "p-3 mb-2 bg-danger text-white";// no inserto en la tabla asistente
                        $title = "Error al Registrar en la tabla asistente por favor revise el documento .xls";
                    }
                    //}

                    ?>
                    <div class="text-center col-sm-1 p-3 mb-2 bg-info text-white"><?php echo $num; ?></div>
                    <div class=" col-sm-4 <?php echo $estilo;?>" title="<?php echo $title;?>"> <?php echo utf8_encode($nombreAsistente); ?></div>
                    <div class=" col-sm-4 <?php echo $estilo;?>"> <?php echo utf8_encode($apellidosAsistente); ?></div>
                    <div class=" col-sm-2 <?php echo $estilo;?>"> <?php echo trim($numeroDocumento); ?></div>
                    <div class="text-center col-sm-1 <?php echo $estilo;?>"> <?php echo $tipoDocumento; ?></div>
                    <?php
                }
            }
            ?>
            </div>
            <?php

        }
    }
        ?>
            <br><br>
    </body>
</html>
<script type="text/javascript">
    $(function(){
        $('#selectDiplomas').select2({
            language: {

                noResults: function() {

                    return "No hay resultados";
                },
                searching: function() {

                    return "Buscando..";
                }
            },
        });
    });
</script>