<?php
/*
 * @author Andres Ariza <arizaancres@unbosque.edu.co>
 * Reporte de entradas y salidas de los torniquetes de biblioteca
 * @since  junio 7, 2017
*/
ini_set('memory_limit', '16384M');
ini_set('max_execution_time', 24000);
date_default_timezone_set("America/Bogota");

require(realpath(dirname(__FILE__)."/../../../sala/config/Configuration.php"));
$Configuration = Configuration::getInstance();

if($Configuration->getEntorno()=="local"||$Configuration->getEntorno()=="pruebas"){
    @error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
    @ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!
    require (PATH_ROOT.'/kint/Kint.class.php');
}

require (PATH_SITE.'/lib/Factory.php');
$db = Factory::createDbo();


/*
 * Se definen las variables globales HTTP_ROOT y PATH_ROOT para utilizarlas en las funciones de importacion de archivos
 * @since  junio 7, 2017
*//*
if(!defined("HTTP_ROOT")){
    $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    //http://172.16.36.10/serviciosacademicos/consulta/sic/aplicaciones/docente/formularios/index.php?opc=prev
    $actual_link = explode("/serviciosacademicos", $actual_link);
    define("HTTP_ROOT", $actual_link[0]);
}
if(!defined("PATH_ROOT")){
    //Definimos el root del http
    $actual_link = getcwd();
    $actual_link = explode("/serviciosacademicos", $actual_link);
    define("PATH_ROOT", $actual_link[0]);
}*/

//session_start();

//require_once(PATH_ROOT.'/kint/Kint.class.php');

$rutaado = PATH_ROOT."/serviciosacademicos/funciones/adodb/";
require_once(PATH_ROOT.'/serviciosacademicos/Connections/sala2.php');
$fechahoy=date("Y-m-d H:i:s");
require_once(PATH_ROOT.'/serviciosacademicos/Connections/salaado.php');

require_once(PATH_ROOT."/assets/lib/paginator.class.php");

require_once(PATH_ROOT."/assets/lib/phpexcel/PHPExcel.php");
require_once(PATH_ROOT."/assets/lib/phpexcel/PHPExcel/IOFactory.php"); 
require_once(PATH_ROOT."/assets/lib/phpexcel/PHPExcel/Writer/Excel2007.php"); 


$fechahoy=date("Y-m-d H:i:s");

$rutaJS = HTTP_ROOT."/serviciosacademicos/consulta/sic/librerias/js/";

$fechainicio = $_REQUEST['fechainicio'];
$fechafin = $_REQUEST['fechafin'];
/*
 * Se inicializan las variables del paginador
 * $size -> registros por pagina
 * $page -> pagina actual
 * $start -> litmite inicial para la consulta
 * @since  junio 7 2017
*/
$size = 15;

$page = $_GET['page'];
if($page == null){
    $page = "";
}
//examino la página a mostrar y el inicio del registro a mostrar 
if (!$page) {
   $start = 0;
   $page = 1;
} else {
   $start = ($page) * $size;
}

$varguardar = 0;

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
/*if(!isset ($_SESSION['MM_Username'])){

echo "No tiene permiso para acceder a esta opción";
exit();
}*/
if(isset($_REQUEST['exportar'])) {
    $formato = 'xls';
    $nombrearchivo = "Reporte Horario Entrada-Salida";
    $strType = 'application/msexcel';
    $strName = $nombrearchivo.".xls";

    header("Content-Type: $strType");
    header("Content-Disposition: attachment; filename=$strName\r\n\r\n");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    //header("Cache-Control: no-store, no-cache");
    header("Pragma: public");   
}


$query_tipousuariobosque= "SELECT codigotipousuario, nombretipousuario "
        . "FROM tipousuario where codigoestado = 100 and codigotipousuario = 600";
$tipousuario= $db->Execute($query_tipousuariobosque);
//$totalRows_tipousuariobosque= $tipousuariobosque->RecordCount();


?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es" dir="ltr" xmlns:v="urn:schemas-microsoft-com:vml">	
    <head>
        <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
        <title>REPORTE ENTRADAS Y SALIDAS</title>		
        <link type="text/css" rel="stylesheet" href="<?php echo HTTP_ROOT;?>/assets/css/normalize.css?v=1">
        <link type="text/css" rel="stylesheet" href="<?php echo HTTP_ROOT;?>/assets/css/font-page.css?v=1">
        <link type="text/css" rel="stylesheet" href="<?php echo HTTP_ROOT;?>/assets/css/font-awesome.css?v=1">
        <link type="text/css" rel="stylesheet" href="<?php echo HTTP_ROOT;?>/assets/css/bootstrap.css?v=1">
        <link type="text/css" rel="stylesheet" href="<?php echo HTTP_ROOT;?>/assets/css/bootstrap-datetimepicker.min.css?v=1">
        <link type="text/css" rel="stylesheet" href="<?php echo HTTP_ROOT;?>/assets/css/general.css?v=1">	 
        <script src="<?php echo HTTP_ROOT;?>/assets/js/jquery.min.js?v=1"></script>
        <script src="<?php echo HTTP_ROOT;?>/assets/js/moment.min.js?v=1"></script>
        <script src="<?php echo HTTP_ROOT;?>/assets/js/bootstrap-datetimepicker.min.js?v=1"></script>
        <script src="<?php echo HTTP_ROOT;?>/assets/js/bootstrap-datetimepicker.es.js?v=1"></script>
        <script src="<?php echo HTTP_ROOT;?>/serviciosacademicos/consulta/reportemolinete/js/mainReporteMolinete.js?v=1"></script>
    </head>  
    <body>
        <div class="clearfix"></div>
        <div class="container">
            <form name="f1" id="f1"  method="POST" action="">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-8">
                            <h2 class="visually-hidden" id="labelresaltadogrande">Reporte Ingresos y Salidas Estudiantes</h2>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-4" id="tdtitulogris">
                            <label class="control-label">Reporte Detallado Ingreso-Salida</label>
                            <input type="radio" class="tiporeporte" name="tiporeporte" value="detallado" <?php if(isset($_REQUEST['tiporeporte']) && $_REQUEST['tiporeporte']=='detallado') echo "checked"; ?>>
                        </div>
                        <div class="col-md-4" id="tdtitulogris">
                            <label class="control-label">Reporte Ingreso-Salida</label>
                            <input type="radio" class="tiporeporte" name="tiporeporte" value="sencillo"<?php if(isset($_REQUEST['tiporeporte']) && $_REQUEST['tiporeporte']=='sencillo') echo "checked"; ?>>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-5">
                            <label class="control-label" for="date">(*) Tipo de Usuario:</label>
                            <select name="tipousuario" id="tipousuario" class="form-control">
                                <option value="">Seleccionar</option>
                                <?php foreach ($tipousuario as $usuarios){
                                    echo "<option value=".$usuarios['codigotipousuario'].">".$usuarios['nombretipousuario']."</option>";
                                }?>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    
                    <div class="row">
                        <div class='col-md-5'>
                            <div class="form-group">
                                <label class="control-label" for="date">(*) Fecha Inicial:</label>
                                <div class='input-group date form_datetime' >
                                    <input type="text" class="form-control"  id= "fechainicio" name="fechainicio" value="<?php if ($fechainicio!=""){ echo $_REQUEST['fechainicio']; } ?>" required>							 
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>	
                                </div>
                            </div>
                        </div>
                        <div class='col-md-5 pad-left-15'>
                            <div class="form-group">
                                <label class="control-label" for="date">(*) Fecha Final:</label>
                                <div class='input-group date form_datetime'>
                                    <input type="text" class="form-control"  id= "fechafin" name="fechafin" value="<?php if ($fechafin!=""){ echo $_REQUEST['fechafin']; } ?>" required>							 
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>	
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-5">
                            <label class="control-label">Nº Documento:</label>
                            <input type="text" class="form-control" name="numerodocumento" value="<?php if(isset($_REQUEST['numerodocumento'])) echo $_REQUEST['numerodocumento']; ?>">
                        </div>
                        <div class="col-md-5 pad-left-15">
                            <label class="control-label">Nº Carné:</label>
                            <input type="text" class="form-control" name="numerotarjetainteligente" value="<?php if(isset($_REQUEST['numerotarjetainteligente'])) echo $_REQUEST['numerotarjetainteligente']; ?>">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-5">
                            <label class="control-label">Nombres:</label>
                            <input type="text" class="form-control" name="nombre" value="<?php if(isset($_REQUEST['nombre'])) echo $_REQUEST['nombre']; ?>">
                        </div>
                        <div class="col-md-5 pad-left-15">
                            <label class="control-label">Apellidos:</label>
                            <input type="text" class="form-control" name="apellido" value="<?php if(isset($_REQUEST['apellido'])) echo $_REQUEST['apellido']; ?>">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">					
                        <input class="btn btn-fill-green-XL" id="submitFormEstudiante" type="button" value="Consultar"/> 
                        <button data-href="<?php echo "$_SERVER[PHP_SELF]?exportar=excel";?>" class="btn btn-fill-green-XL" id="btnexportar" >Exportar</button>
                        <input type="hidden" name="aceptar" value="aceptar"/>					
                    </div>
                </div>
            <?php
            if(!isset($_REQUEST['exportar'])){
            ?><?php
            }
            $documento = "";
            $sqldocumento1 = "";
            $sqldocumento = "";
            $sqldocumentosala = " ";
            if (isset($_REQUEST['aceptar'])){
                if($_POST['tipousuario']==''){
                    echo '<script language="JavaScript">alert("Debe Seleccionar el tipo de Usuario.")</script>';
                    $varguardar = 1;
                }
                elseif($_POST['fechainicio']==''){
                    echo '<script language="JavaScript">alert("Debe Ingresar la fecha de Inicio")</script>';
                    $varguardar = 1;
                }
                elseif($_POST['fechafin']==''){
                    echo '<script language="JavaScript">alert("Debe ingresar una fecha final.")</script>';
                    $varguardar = 1;
                }
                elseif($_POST['tiporeporte']==''){
                    echo '<script language="JavaScript">alert("Debe Seleccionar un tipo de reporte.")</script>';
                    $varguardar = 1;
                }
                elseif ($varguardar == 0) {                    
                    if($_POST['tipousuario']!='todos'){
                        $codigotipousuario="and tu.idtipousuarioadmdocen=".$_POST['tipousuario'];
                    }
                    if($_POST['tiporeporte']=='detallado'){
                        $fechainicio=$_POST['fechainicio']." 00:00:00";
                        $fechafin=$_POST['fechafin']." 23:59:59";
                    }
                    elseif($_POST['tiporeporte']=='sencillo'){
                        $fechainicio=$_POST['fechainicio'];
                        $fechafin=$_POST['fechafin'];
                    }
                    if($_POST['numerodocumento']!=''){
                        $sqldocumento=" and  p.SocSecNo = '".$_POST['numerodocumento']."'";
                        $sqldocumentosala = "where g.numerodocumento ='".$_POST['numerodocumento']."'";
                    }
                    if($_POST['numerotarjetainteligente']!=''){
                        $tarjeta="and ti.codigotarjetainteligenteadmindocen=".$_POST['numerotarjetainteligente'];
                    }
                    if($_POST['nombre']!=''){
                        $nombres="and a.nombresadministrativosdocentes like '%".$_POST['nombre']."%'";
                    }
                    if($_POST['apellido']!=''){
                        $apellidos="and a.apellidosadministrativosdocentes like '%".$_POST['apellido']."%'";
                    }
                    ?>
                    <div class="table-responsive">
                        <label id="labelresaltadogrande">
                            <?php 
                            if($_POST['tiporeporte']=='detallado'){
                                echo "Resultados Reporte Horario Detallado Ingreso - Salida";
                            }elseif($_POST['tiporeporte']=='sencillo'){
                                echo "Resultados Reporte Horario Ingreso - Salida";
                            } 
                            ?>
                        </label>
                        <table id="tabladatos" class="table table-bordered" cellpadding="3" cellspacing="3">
                            <?php if($_POST['tiporeporte']=='detallado'){ ?>
                            <tr>
                                <td>#</td>
                                <td id="tdtitulogris">Tipo documento</td>
                                <td id="tdtitulogris">Numero documento</td>
                                <td id="tdtitulogris">Nombres</td>
                                <td id="tdtitulogris">Apellidos</td>                                
                                <td id="tdtitulogris">Email institucional</td>
                                <td id="tdtitulogris">Celular</td>
                                <td id="tdtitulogris">Codigo serial sala</td>                                
                                <td id="tdtitulogris">Codigo carnet</td>
                                <td id="tdtitulogris">Codigo andover</td>
                                <td id="tdtitulogris">Hora entrada</td>
                                <td id="tdtitulogris">Hora salida</td>
                                <td id="tdtitulogris">Fecha</td>
                            </tr>
                            <?php
                            }
                            elseif($_POST['tiporeporte']=='sencillo'){
                            ?>
                            <tr>
                                <td id="tdtitulogris">Tipo documento</td>
                                <td id="tdtitulogris">Numero documento</td>
                                <td id="tdtitulogris">Nombres</td>
                                <td id="tdtitulogris">Apellidos</td>                                
                                <td id="tdtitulogris">Email institucional</td>
                                <td id="tdtitulogris">Celular</td>
                                <td id="tdtitulogris">Codigo serial</td>
                                <td id="tdtitulogris">Codigo carnet</td>
                            </tr>
                            <?php
                            }//else 
                    $documento = "";
	
                    require(PATH_ROOT.'/serviciosacademicos/Connections/sqlserver_4gs.php');
                   /*                    
                    $consultamssql = "select distinct  p.SocSecNo from Personnel p 
                    inner join AccessEvent a on ( p.ObjectIdLo=a.PersonIdLo)
                    where  a.TimeStamp between '".$fechainicio."' and '".$fechafin."' ".$sqldocumento." 
                    group by p.SocSecNo";
                    $numerosdocumentos = $dbAndover->GetAll($consultamssql);
                    
                    
                    array(
                        0: 1......1000
                        1: 1001....2000
                        2: 2001....3000
                    )
                    
                    
                    */
                    //$k=1;
                    //foreach($numerosdocumentos as $numero){
                        
                        $query_datospersona= "SELECT DISTINCT
                                g.tipodocumento,
                                g.numerodocumento,
                                g.nombresestudiantegeneral,
                                g.apellidosestudiantegeneral,
                                CONCAT( 	u.usuario, 	'@unbosque.edu.co' 	) AS email,
                                g.celularestudiantegeneral,
                                te.codigotarjetaestudiante
                        FROM
                                estudiantegeneral g
                        INNER JOIN tarjetaestudiante te ON ( g.idestudiantegeneral = te.idestudiantegeneral 	AND te.codigoestado = 100 )
                        INNER JOIN usuario u ON ( g.numerodocumento = u.numerodocumento 	AND u.codigotipousuario = 600 AND u.fechavencimientousuario > now() 	AND u.codigoestadousuario = 100 )
                        INNER JOIN estudiante e on (g.idestudiantegeneral = e.idestudiantegeneral)
                        INNER JOIN prematricula pm on (e.codigoestudiante = pm.codigoestudiante and pm.codigoestadoprematricula in (40, 41))
                        ".$sqldocumentosala." 
                        GROUP BY g.tipodocumento, g.numerodocumento"; 
                        $datospersona= $db->GetAll($query_datospersona);
                        $k=1;
                        foreach($datospersona as $numero){
                        // if(!empty($datospersona['0'])){
                            require(PATH_ROOT.'/serviciosacademicos/Connections/sqlserver_4gs.php');
                            $query_molinete="select 
                            sub.hora_entrada,
                            sub.hora_salida,
                            sub.fecha,
                            cast(sub.CardNumber as INTEGER) as Plastico,                                
                            sub.CardNumber,
                            SUBSTRING(REPLACE(CONVERT(char(20), sub.CardNumber, 1),'0x',''),11,10) carne1
                            from Personnel p
                            inner join (
                                select ae.NonABACardNumber,ae.PersonIdLo, ae.CardNumber,
                                        cast(datepart(year,ae.TimeStamp) as varchar(4))+'-'+right('00'+cast(datepart(month,ae.TimeStamp) as varchar(2)),2)+'-'+right('00'+cast(datepart(day,ae.TimeStamp) as varchar(2)),2) as fecha,
                                        min(Convert(varchar,ae.TimeStamp,8)) as hora_entrada,
                                        max(Convert(varchar,ae.TimeStamp,8)) as hora_salida
                                from AccessEvent ae
                                group by ae.NonABACardNumber,ae.PersonIdLo, ae.CardNumber,
                                        cast(datepart(year,ae.TimeStamp) as varchar(4))+'-'+right('00'+cast(datepart(month,ae.TimeStamp) as varchar(2)),2)+'-'+right('00'+cast(datepart(day,ae.TimeStamp) as varchar(2)),2)
                                        ) as sub on p.ObjectIdLo=sub.PersonIdLo
                            where 
                            p.SocSecNo = '".$numero['numerodocumento']."'
                            and 
                            CAST(sub.fecha AS DATE) between '$fechainicio' and '$fechafin'
                            order by sub.fecha";
                            //$entradas = $dbAndover->GetAll($query_molinete);
                            $entradas = $dbAndover->GetRow($query_molinete);
                            $td="";
                            $u=1;
                            if(!empty($entradas['0'])){                            
                                $td="<td>".$entradas[3]."</td><td>".$entradas[5]."</td>
                                    <td>".$entradas[0]."</td><td>".$entradas[1]."</td>
                                    <td>".$entradas[2]."</td>";
                                /*foreach ($entradas as $fechas){
                                    $u++;
                                    $td.= "<td>".$fechas[3]."</td><td>".$fechas[5]."</td>
                                    <td>".$fechas[0]."</td><td>".$fechas[1]."</td>
                                    <td>".$fechas[2]."</td></tr><tr>";
                                }*/
                                ?>
                                <tr>
                                    <td rowspan="<?php echo $u;?>"><?php echo $k; ?></td>
                                    <td rowspan="<?php echo $u;?>"><?php echo $numero['tipodocumento']; ?></td>
                                    <td rowspan="<?php echo $u;?>"><?php echo $numero['numerodocumento']; ?></td>
                                    <td rowspan="<?php echo $u;?>"><?php echo $numero['nombresestudiantegeneral']; ?></td>
                                    <td rowspan="<?php echo $u;?>"><?php echo $numero['apellidosestudiantegeneral']; ?></td>
                                    <td rowspan="<?php echo $u;?>"><?php echo $numero['email']; ?></td>
                                    <td rowspan="<?php echo $u;?>"><?php echo $numero['celularestudiantegeneral']; ?></td>
                                    <td rowspan="<?php echo $u;?>"><?php echo $numero['codigotarjetaestudiante']; ?></td>
                                    <?php echo $td;?>
                                </tr>
                                <?php
                                $k++;  
                            }
                        }//foreach
                    }//else
                    die;
                }
            //}
            ?>
        </form>
    </div>
    </body>
</html>