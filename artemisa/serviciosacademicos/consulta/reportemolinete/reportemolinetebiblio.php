<?php
/*
 * @author Andres Ariza <arizaancres@unbosque.edu.co>
 * Reporte de entradas y salidas de los torniquetes de biblioteca
 * @since  Abril 05, 2017
*/

/*
 * Se expanden las configuraciones de limite de memoria y maximo tiempo de ejecucion para evitar que se bloquee la consulta cuando tenga
 * muchos datos, ademas se setea el timezone para bogota
 * @since  Abril 05, 2017
*/
ini_set('memory_limit', '16384M');
ini_set('max_execution_time', 24000);
date_default_timezone_set("America/Bogota");
/* Fin Modificacion */
/*error_reporting(E_ALL);
ini_set('display_errors', 1);/*

/*
 * Se definen las variables globales HTTP_ROOT y PATH_ROOT para utilizarlas en las funciones de importacion de archivos
 * @since  Abril 05, 2017
 * -----------------------------------------------------
 * @modified Andres Ariza <arizaancres@unbosque.edu.co>
 * Se unifica la declaracion de las rutas HTTP_ROOT Y PATH_ROOT con el archivo de configuracion general
 * @since  Junio 12 2018
*/
require_once(realpath ( dirname(__FILE__)."/../../../sala/config/Configuration.php" ));
$Configuration = Configuration::getInstance();
/* Fin Modificacion */

session_start();
    
    
require_once(PATH_ROOT.'/kint/Kint.class.php');

$fechahoy=date("Y-m-d H:i:s");

require (PATH_SITE.'/lib/Factory.php');
Factory::importGeneralLibraries();

$db = Factory::createDbo();
//d($db);
$dbAndover = Factory::createDbo("andover");
//d($dbAndover);

require_once(PATH_ROOT."/assets/lib/paginator.class.php");

require_once(PATH_ROOT."/assets/lib/phpexcel/PHPExcel.php");
require_once(PATH_ROOT."/assets/lib/phpexcel/PHPExcel/IOFactory.php"); 
require_once(PATH_ROOT."/assets/lib/phpexcel/PHPExcel/Writer/Excel2007.php"); 

/*
 * Se inicializan las variables del paginador
 * $size -> registros por pagina
 * $page -> pagina actual
 * $start -> litmite inicial para la consulta
 * @since  Abril 05, 2017
*/
$size = 15;
$page = @$_GET['page'];
//examino la página a mostrar y el inicio del registro a mostrar 
if (!$page) {
   $start = 0;
   $page = 1;
} else {
   $start = ($page) * $size;
}
/* Fin Modificacion */

$varguardar = 0;

/*
 * Se capturan las variables que se envian en el formulario para construir la url del paginador
 * @since  Abril 05, 2017
*/
$querystring = "";
if($_GET){
    $args = explode("&",$_SERVER['QUERY_STRING']);
    foreach($args as $arg){
        $keyval = explode("=",$arg);
        if($keyval[0] != "page" And $keyval[0] != "ipp" And $keyval[0] != "json"){
            $querystring .= "&" . $arg;
        }
    }
}

if($_POST){
    foreach($_POST as $key=>$val){
        if($key != "page" And $key != "ipp" And $key != "json"){
            $querystring .= "&$key=$val";
        }
    }
}
/* Fin Modificacion */

if(isset($_REQUEST['aceptar'])){
    $exportar = @$_REQUEST["exportar"];
    $tarjeta = "";
    $documento = "";
    $inner = "";
    $nombretipousuario = "";
    if($_REQUEST['tiporeporte']=='restudiante'){

        $date = strtotime($_REQUEST['fechainicio']); 
        $date1 = strtotime($_REQUEST['fechafin']); 

        $fechainicio=date('Ymd', $date)." 00:00:00";
        //$fechainicio=str_replace("-", "", $_REQUEST['fechainicio']);
        $fechafin=date('Ymd', $date1)." 23:59:59";
        $fechafin2=date('Ymd', $date1)." 00:00:00";
        unset($date);
        unset($date1);
        $consulta = "and tu.codigotipousuario = '600'";
        $inner = " INNER JOIN ADMINSALAESTUDIANTE admsala ON (admsala.DocumentoEstudiante=p.SocSecNo) ";
        $nombretipousuario = ", 'ESTUDIANTE'  as nombretipousuario";
    }elseif($_REQUEST['tiporeporte']=='radmon'){
        $date = strtotime($_REQUEST['fechainicio']); 
        $date1 = strtotime($_REQUEST['fechafin']); 

        $fechainicio=date('Ymd', $date)." 00:00:00";
        //$fechainicio=str_replace("-", "", $_REQUEST['fechainicio']);
        $fechafin=date('Ymd', $date1)." 23:59:59";
        $fechafin2=date('Ymd', $date1)." 00:00:00";
        unset($date);
        unset($date1);

        $consulta = "";

        $inner = "INNER JOIN ADMINSALAADMINISTRATIVO AD ON (AD.NumeroDocumento = p.SocSecNo) ";
        $nombretipousuario = " , AD.CargoAdministrativosDocentes as nombretipousuario";
    }
    $numerodocumento = $_REQUEST['numerodocumento'];
    $numerotarjetainteligente = @$_REQUEST['numerotarjetainteligente'];
    $numero = "";
    if(!empty($numerodocumento)){
            $numero .= " AND p.SocSecNo = '".$numerodocumento."'";
    }

    $sql = "SELECT u.numerodocumento
              FROM usuario u 
        INNER JOIN tipousuario tu ON (tu.codigotipousuario = u.codigotipousuario) 
             WHERE  u.idusuario<>2  ".$consulta;

    $datospersona= $db->GetAll($sql);

    $docs = array();
    foreach($datospersona as $dp){
        $docs[] = $dp["numerodocumento"];
    }

    $inicial = 0;
    $contador = 1000;
    $limite = $contador;
    $entradasSalidas = array();

    $queryBase= "
                          FROM AccessEvent ae
                    INNER JOIN Area a ON (a.ObjectIdLo = ae.AreaIdLo)
                    INNER JOIN Personnel p ON (ae.PersonIdLo = p.ObjectIdLo)
                    INNER JOIN Door d ON (d.ObjectIdLo = ae.DoorIdLo)
                      ".$inner."
                         WHERE d.ObjectIdHi = ae.DoorIdHi
                           AND ae.TIMESTAMP >= '".$fechainicio."' 
                           AND ae.TIMESTAMP <= '".$fechafin."'
                           AND d.ObjectIdHi = '1010834276' 
                           AND d.ObjectIdLo IN ('1115691868','1115691869','1115691871','1115691872','1115691873','1115691875')
                           AND p.SocSecNo IS NOT NULL
                           ".$numero;

    $queryTotalRows = " SELECT COUNT(1) ".$queryBase;
//    $dbAndover->debug = true;
    $molineteTotal= $dbAndover->Execute($queryTotalRows); 
    if($row_molineteTotal = $molineteTotal->FetchRow()){
        $totalRows = $row_molineteTotal[0];
    }else{
        $totalRows = 0;
    }
    $inicio = ($page-1)*$size;
    $inicio = ($inicio==0)?$inicio:$inicio+1;
    $fin = $page*$size;
    $query_molinete = "SELECT * FROM ( 
                        SELECT ROW_NUMBER() OVER (ORDER BY ae.ObjectIdLo) as row2,
                               p.FirstName, p.lastname, ae.TIMESTAMP,
                               d.Description, d.uiName, p.CardNumber, p.SocSecNo
                               ".$nombretipousuario."
                        ".$queryBase."
                       ) d ";
    if(empty($exportar)){
        $query_molinete .= "  WHERE row2 BETWEEN '".$inicio."' and '".$fin."' ";

    }
    if(empty($exportar) && $_SERVER['REMOTE_ADDR']=="172.16.36.134"){
        d($query_molinete);
    }
    $molinete= $dbAndover->Execute($query_molinete); 

    $entradasSalidas=array();

    while($row_molinete = $molinete->FetchRow()){
        $entradasSalidas[] =  $row_molinete;
    }

    $totalPages = ceil( $totalRows / $size);
    $pagination = new Paginator;
    $pagination->items_total = $totalRows;
    $pagination->mid_range = $size; 
    $pagination->default_ipp = $size; 

    unset($molinete); 

    if(!empty($exportar)){
        PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
        $tituloHoja = "Reporte_".$_REQUEST['fechainicio']."_".$_REQUEST['fechafin'];

        // Create new PHPExcel object 
        $reporteExcel = new PHPExcel();

        // Set properties 
        $reporteExcel->getProperties()->setCreator("SALA"); 
        $reporteExcel->getProperties()->setTitle("REPORTE ENTRADAS Y SALIDAS BIBLIOTECA");

        // Add data 
        $reporteExcel->setActiveSheetIndex(0);
        $reporteExcel->getActiveSheet()->SetCellValue('A1', 'NOMBRE');
        $reporteExcel->getActiveSheet()->SetCellValue('B1', 'DOCUMENTO');
        $reporteExcel->getActiveSheet()->SetCellValue('C1', 'HORA');
        $reporteExcel->getActiveSheet()->SetCellValue('D1', 'FECHA');
        $reporteExcel->getActiveSheet()->SetCellValue('E1', 'MOLINETE');
        $reporteExcel->getActiveSheet()->SetCellValue('F1', 'CARGO');

        $i=1;

        foreach($entradasSalidas as $k => $row){
            $i++; 
            $date = strtotime($row[3]);
            $reporteExcel->getActiveSheet()->SetCellValue('A'.$i, utf8_decode($row[1]." ".$row[2]));
            $reporteExcel->getActiveSheet()->SetCellValue('B'.$i, $row[7]);
            $reporteExcel->getActiveSheet()->SetCellValue('C'.$i, date('H:i:s', $date));
            $reporteExcel->getActiveSheet()->SetCellValue('D'.$i, date('Y-m-d', $date));
            $reporteExcel->getActiveSheet()->SetCellValue('E'.$i, $row[4]);
            $reporteExcel->getActiveSheet()->SetCellValue('F'.$i, (!empty($row[8]))?$row[8]:""); 
        }

        $reporteExcel->getActiveSheet()->calculateColumnWidths();

        $reporteExcel->getActiveSheet()->setTitle($tituloHoja);

        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$tituloHoja.'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($reporteExcel, "Excel2007");
        $objWriter->save('php://output');            
        exit();
    }

}
    
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es" dir="ltr" xmlns:v="urn:schemas-microsoft-com:vml">	
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>REPORTE ENTRADAS Y SALIDAS BIBLIOTECA</title>
        <?php
            /*
             * @modified Andres Ariza <arizaancres@unbosque.edu.co>
             * Se unifica la importacion de librerias css y js con el formato del nuevo sala que evita problemas de cache
             * @since  Junio 12 2018
            */
            require_once(realpath ( dirname(__FILE__)."/../../../sala/lib/Factory.php" ));
            
            echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/normalize.css");
            echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/font-page.css");
            echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/font-awesome.css");
            echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/bootstrap.css");
            echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/bootstrap-datetimepicker.min.css");
            echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/general.css");
            echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/jquery.min.js");
            echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/moment.min.js");
            echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/bootstrap-datetimepicker.min.js");
            echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/bootstrap-datetimepicker.es.js");
            echo Factory::printImportJsCss("js",HTTP_ROOT."/serviciosacademicos/consulta/reportemolinete/js/main.js");
        ?>
    </head>  
    <body>
        <header id="header" role="banner">
            <div class="header-inner">
                <div class="header_first region-content">
                    <div class="block block-system block-system-branding-block">
                        <div class="block-inner">							
                            <img src="<?php echo HTTP_ROOT;?>/assets/ejemplos/img/logo.png" alt="Inicio">							
                        </div>
                    </div>
                </div>
                <div class="close-search"></div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </header>
        <div class="clearfix"></div>
        <div class="container">
            <form name="f1" id="f1" method="POST" action="reportemolinetebiblio.php" target="_SELF">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-8">
                            <h2 class="visually-hidden" id="labelresaltadogrande">Reporte Biblioteca Ingreso - Salidas </h2>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-4" id="tdtitulogris">
                            <label class="control-label">Usuario Estudiante </label>
                            <input type="radio" class="tiporeporte" name="tiporeporte" value="restudiante" <?php if(isset($_REQUEST['tiporeporte']) && $_REQUEST['tiporeporte']=='restudiante') echo "checked"; ?>>
                        </div>
                        <div class="col-md-4" id="tdtitulogris">
                            <label class="control-label">Usuario Academico-Administrativo</label>
                            <input type="radio" class="tiporeporte" name="tiporeporte" value="radmon"<?php if(isset($_REQUEST['tiporeporte']) && $_REQUEST['tiporeporte']=='radmon') echo "checked"; ?>>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                        <div class="row">
                            <div class='col-md-5'>
                                <div class="form-group">
                                    <label class="control-label" for="date">Fecha Inicial:</label>
                                    <div class='input-group date form_datetime' >
                                        <input type="text" class="form-control"  id= "fechainicio" name="fechainicio" value="<?php if (@$_REQUEST['fechainicio']!=""){ echo @$_REQUEST['fechainicio']; } ?>" required>							 
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>	
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class='col-md-5'>
                                <div class="form-group">
                                    <label class="control-label" for="date">Fecha Final:</label>
                                    <div class='input-group date form_datetime'>
                                        <input type="text" class="form-control"  id= "fechafin" name="fechafin" value="<?php if (@$_REQUEST['fechafin']!=""){ echo @$_REQUEST['fechafin']; } ?>" required>							 
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>	
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-8">
                                <label class="control-label">Nº Documento</label>
                                <input type="text" name="numerodocumento" value="<?php if(isset($_REQUEST['numerodocumento'])) echo $_REQUEST['numerodocumento']; ?>">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">					
                            <input class="btn btn-fill-green-XL" id="submitForm" type="button" value="Consultar"/> 
                            <button data-href="<?php echo "$_SERVER[PHP_SELF]?exportar=excel";?>" class="btn btn-fill-green-XL" id="btnexportar" >Exportar</button>
                            <input type="hidden" name="aceptar" value="aceptar"/>					
                        </div>
                </div>
                <?php 
                if (isset($_REQUEST['aceptar'])){
                ?>
                <div class="table-responsive"> 
                    <label id="labelresaltadogrande">
                        <?php
                        if($_REQUEST['tiporeporte']=='restudiante'){
                            echo "Resultados Reporte Ingreso - Salida Biblioteca Estudiantes";
                        }elseif($_REQUEST['tiporeporte']=='radmon'){
                            echo "Resultados Reporte Ingreso - Salida Biblioteca Administrativos";
                        }
                        ?>
                    </label>
                    <table class="table table-bordered" border="1"  cellpadding="3" cellspacing="3" id="tabladatos">					
                        <thead>							
                            <th id="tdtitulogris">#</th>
                            <th id="tdtitulogris">NOMBRE</th>
                            <th id="tdtitulogris">DOCUMENTO</th>
                            <th id="tdtitulogris">HORA</th>
                            <th id="tdtitulogris">FECHA</th>                                
                            <th id="tdtitulogris">MOLINETE</th>
                            <th id="tdtitulogris">CARGO</th>							
                        </thead> 
                        <tbody>
                        <?php
                        $i =1;					
                        foreach($entradasSalidas as $k => $row){                                           
                            $date = strtotime($row[3]); 	
                            ?>
                            <tr>
                                <td><?php echo ((($page-1) * $size)+$k+1); ?></td>
                                <td><?php echo utf8_decode($row[1]." ".$row[2]); ?></td>
                                <td><?php echo $row[7];?></td> 
                                <td><?php echo date('H:i:s', $date); ?></td>
                                <td><?php echo date('Y-m-d', $date); ?></td>
                                <td><?php echo $row[4]; ?></td>
                                <td>
                                <?php 
                                    echo (!empty($row[8]))?$row[8]:"";
                                ?>
                                </td>
                            </tr>                                                                
                            <?php
                            $i++;
                        }
                        ?> 
                        </tbody>
                    </table>
                    <?php echo $pagination->paginate();echo $pagination->display_pages(); ?>
                </div>
                <?php
                } //aceptar
                ?>
            </form>
        </div>
    </body>
</html>
