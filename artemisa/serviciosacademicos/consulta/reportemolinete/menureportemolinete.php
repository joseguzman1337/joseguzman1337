<?php
/*
 * @author Andres Ariza <arizaancres@unbosque.edu.co>
 * Reporte de entradas y salidas de los torniquetes de biblioteca
 * @since  junio 7, 2017
*/

/*
 * Se expanden las configuraciones de limite de memoria y maximo tiempo de ejecucion para evitar que se bloquee la consulta cuando tenga
 * muchos datos, ademas se setea el timezone para bogota
 * @since  Abril 05, 2017
*/
ini_set('memory_limit', '16384M');
ini_set('max_execution_time', 24000);
date_default_timezone_set("America/Bogota");


/*
 * Se definen las variables globales HTTP_ROOT y PATH_ROOT para utilizarlas en las funciones de importacion de archivos
 * @since  junio 7, 2017
*/
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
}

session_start();

    
    
require_once(PATH_ROOT.'/kint/Kint.class.php');

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


/*
 * Se inicializan las variables del paginador
 * $size -> registros por pagina
 * $page -> pagina actual
 * $start -> litmite inicial para la consulta
 * @since  junio 7 2017
*/
$size = 15;
$page = $_GET['page'];
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


$query_tipousuariobosque= "SELECT * FROM tipousuarioadmdocen
    where idtipousuarioadmdocen not in (41,43,44)
    and codigoestado like '1%'";
$tipousuariobosque= $db->Execute($query_tipousuariobosque);
$totalRows_tipousuariobosque= $tipousuariobosque->RecordCount();


?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es" dir="ltr" xmlns:v="urn:schemas-microsoft-com:vml">	
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
                            <h2 class="visually-hidden" id="labelresaltadogrande">Reporte Horario Ingreso - Salidas Personal</h2>
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
                                <option value="todos" <?php if($_REQUEST['tipousuario']=='todos') echo "Selected"; ?>>
                                    TODOS
                                </option>
                                <?php while ($row_tipousuariobosque= $tipousuariobosque->FetchRow()) { ?>
                                <option value="<?php echo $row_tipousuariobosque['idtipousuarioadmdocen']; ?>"
                                <?php
                                if ($row_tipousuariobosque['idtipousuarioadmdocen'] == $_REQUEST['tipousuario']) {
                                echo "Selected";
                                } ?>>
                                <?php echo $row_tipousuariobosque['nombretipousuarioadmdocen']; ?>
                                </option><?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    
                    <div class="row">
                        <div class='col-md-5'>
                            <div class="form-group">
                                <label class="control-label" for="date">(*) Fecha Inicial:</label>
                                <div class='input-group date form_datetime' >
                                    <input type="text" class="form-control"  id= "fechainicio" name="fechainicio" value="<?php if ($_REQUEST['fechainicio']!=""){ echo $_REQUEST['fechainicio']; } ?>" required>							 
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
                                    <input type="text" class="form-control"  id= "fechafin" name="fechafin" value="<?php if ($_REQUEST['fechafin']!=""){ echo $_REQUEST['fechafin']; } ?>" required>							 
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
                        <input class="btn btn-fill-green-XL" id="submitForm" type="button" value="Consultar"/> 
                        <button data-href="<?php echo "$_SERVER[PHP_SELF]?exportar=excel";?>" class="btn btn-fill-green-XL" id="btnexportar" >Exportar</button>
                        <input type="hidden" name="aceptar" value="aceptar"/>					
                    </div>
                </div>
            <?php
            if(!isset($_REQUEST['exportar'])){
            ?><?php
            }
            ?>
            <?php
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
                        $documento="and a.numerodocumento=".$_POST['numerodocumento'];
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


                     $query_datospersona= "SELECT a.nombresadministrativosdocentes, a.apellidosadministrativosdocentes,
                            a.numerodocumento,a.cargoadministrativosdocentes, ti.codigotarjetainteligenteadmindocen,tu.nombretipousuarioadmdocen
                            FROM administrativosdocentes a 
				join tipousuarioadmdocen tu on tu.idtipousuarioadmdocen=a.idtipousuarioadmdocen
                            INNER join tarjetainteligenteadmindocen ti on ti.idadministrativosdocentes=a.idadministrativosdocentes
                            AND ti.codigotarjetainteligenteadmindocen <> ''
							AND ti.codigoestado LIKE '1%'
                            where a.codigoestado like '1%'
                            $codigotipousuario
                            $documento
                            $tarjeta
                            $nombres
                            $apellidos
                            order by a.apellidosadministrativosdocentes,a.nombresadministrativosdocentes "; 
                    $datospersona= $db->Execute($query_datospersona);
                    $totalRows_datospersona= $datospersona->RecordCount();
                    if($totalRows_datospersona !=''){                       
                        ob_flush();
                        flush();
                        ob_start();
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
                                <td id="tdtitulogris">NOMBRE</td>
                                <td id="tdtitulogris">DOCUMENTO</td>
                                <td id="tdtitulogris">HORA</td>
                                <td id="tdtitulogris">INGRESO-SALIDA</td>                                
                                <td id="tdtitulogris">MOLINETE</td>
                                <td id="tdtitulogris">CARGO</td>
                            </tr>
                            <?php
                            }
                            elseif($_POST['tiporeporte']=='sencillo'){
                            ?>
                            <tr>
                                <td id="tdtitulogris">NOMBRE</td>
                                <td id="tdtitulogris">DOCUMENTO</td>
                                <td id="tdtitulogris">FECHA</td>
                                <td id="tdtitulogris">HORA INGRESO</td>
                                <td id="tdtitulogris">HORA SALIDA</td>
                                <td id="tdtitulogris">CARGO</td>
                            </tr>
                            <?php
                            }
                            ?>
                    
                    <?php $documento = "";
                    /*Realizar busqueda en base de g4s*/
                    while ($row_datospersona= $datospersona->FetchRow()) {
				ob_flush();
				flush();
                $documento=$row_datospersona['numerodocumento'];
			$numerotarjeta=$row_datospersona['codigotarjetainteligenteadmindocen'];
			$primernumero=$numerotarjeta[0];
			switch($primernumero){
				case 0:
				$numeroarmado='0x0000000000';
				break;
				case 1:
				$numeroarmado='0x0001000000';
				break;
				case 2:
				$numeroarmado='0x0002000000';
				break;
				case 3:
				$numeroarmado='0x0003000000';
				break;
				case 4:
				$numeroarmado='0x0004000000';
				break;
				case 5:
				$numeroarmado='0x0005000000';
				break;
				case 6:
                $numeroarmado='0x0006000000';
                break;
				case 7:
                $numeroarmado='0x0007000000';
                break;
				case 8:
                $numeroarmado='0x0008000000';
                break;
				case 9:
                $numeroarmado='0x0009000000';
                break;			   
			}
			$numeroconvertir=substr($numerotarjeta,1);
			$convertido=dechex($numeroconvertir); 
			if(strlen($convertido)==7){
			   $convertido="0".$convertido;
			}
			$arreglo_separado=str_split($convertido,2);
			$numeroarmadoalreves=$arreglo_separado[3].$arreglo_separado[2].$arreglo_separado[1].$arreglo_separado[0];
			$numerotarjetaandover=$numeroarmado.$numeroarmadoalreves;
			$Fecha_1 = explode('-',$fechainicio);
			$FechaNew_1 = $Fecha_1[0].$Fecha_1[1].$Fecha_1[2];
			$Fecha_2 = explode('-',$fechafin);
            $FechaNew_2 = $Fecha_2[0].$Fecha_2[1].$Fecha_2[2];
	
//            require('../../Connections/sqlserver_4gs.php');
            require(PATH_ROOT.'/serviciosacademicos/Connections/sqlserver_4gs.php');
            if($_POST['tiporeporte']=='detallado'){
            if($numerotarjetaandover=='0x00000000000')
            {
                echo '<br><br>Documento->'.$documento;			
            }	
                            /*$query_molinete="SELECT
													p.FirstName,
													p.lastname,
													ae.TIMESTAMP,
													a.ControllerName
												FROM Personnel p 
												JOIN AccessEvent ae ON ae.PersonIdLo = p.ObjectIdLo 
												JOIN Area a ON a.ObjectIdLo = ae.AreaIdLo
											WHERE
												p.CardNumber = ".$numerotarjetaandover."
											AND ae. TIMESTAMP >= '$FechaNew_1' and ae. TIMESTAMP <= '$FechaNew_2' 
											order by p.lastname"; */
                              
                                //nueva consulta por el dba
            $query_molinete="SELECT
                                p.FirstName,
                                p.lastname,
                                ae. TIMESTAMP,
                                a.ControllerName,
                                d.uiName,
                                p.CardNumber,
                                p.CardNumber2,
                                p.SocSecNo
                         FROM
                                AccessEvent ae
                         JOIN Area a ON a.ObjectIdLo = ae.AreaIdLo
                         JOIN Personnel p ON ae.PersonIdLo = p.ObjectIdLo
                         JOIN Door d ON d.ObjectIdLo = ae.DoorIdLo
                         AND d.ObjectIdHi = ae.DoorIdHi
                         WHERE ae. TIMESTAMP >= '".$FechaNew_1.".000'
                    AND ae. TIMESTAMP < '".$FechaNew_2.".000'
                         AND P.SocSecNo='".$documento."'";
                      
            }
            elseif($_POST['tiporeporte']=='sencillo'){
                    $query_molinete="select p.FirstName, p.lastname,sub.hora_entrada,sub.hora_salida,sub.fecha
                    from Personnel p
                    left join (
                            select ae.NonABACardNumber,ae.PersonIdLo
                                    ,cast(datepart(year,ae.TimeStamp) as varchar(4))+'-'+right('00'+cast(datepart(month,ae.TimeStamp) as varchar(2)),2)+'-'+right('00'+cast(datepart(day,ae.TimeStamp) as varchar(2)),2) as fecha
                                    ,min(Convert(varchar,ae.TimeStamp,8)) as hora_entrada
                                    ,max(Convert(varchar,ae.TimeStamp,8)) as hora_salida
                            from AccessEvent ae
                            group by ae.NonABACardNumber,ae.PersonIdLo
                                    ,cast(datepart(year,ae.TimeStamp) as varchar(4))+'-'+right('00'+cast(datepart(month,ae.TimeStamp) as varchar(2)),2)+'-'+right('00'+cast(datepart(day,ae.TimeStamp) as varchar(2)),2)
                            ) as sub on p.ObjectIdLo=sub.PersonIdLo
                    where p.CardNumber = ".$numerotarjetaandover."
                    and sub.fecha >= '$fechainicio' and sub.fecha <= '$fechafin' 
                    order by p.lastname, sub.fecha";
            }
        $molinete= $dbAndover->Execute($query_molinete);							
        $totalRows_molinete= $molinete->RecordCount();
        if($totalRows_molinete !=0){

        ob_flush();
        flush();

            while ($row_molinete= $molinete->FetchRow()) {
                if($_POST['tiporeporte']=='detallado'){ ?>
                    <tr>
                        <td><?php echo $row_molinete[1]." ".$row_molinete[0]; ?></td>
                        <td><?php echo $row_datospersona['numerodocumento']; ?></td>
                        <td><?php echo $row_molinete[2]; ?></td>
                        <td><?php echo $row_molinete[3]; ?></td>
                        <td><?php echo $row_molinete[4]; ?></td>
                        <td><?php if($row_datospersona['cargoadministrativosdocentes']!=""){
                            echo $row_datospersona['cargoadministrativosdocentes'];
                            }
                            else{
                            echo "<br>";
                            } ?>
                        </td>
                    </tr>
            <?php
                }
                elseif($_POST['tiporeporte']=='sencillo'){ ?>
                    <tr>
                        <td><?php echo $row_molinete[1]." ".$row_molinete[0]; ?></td>
                        <td><?php echo $row_datospersona['numerodocumento']; ?></td>
                        <td><?php echo $row_molinete[4]; ?></td>
                        <td><?php echo $row_molinete[2]; ?></td>
                        <td><?php echo $row_molinete[3]; ?></td>
                        <td><?php if($row_datospersona['cargoadministrativosdocentes']!=""){
                            echo $row_datospersona['cargoadministrativosdocentes'];
                            }
                            else{
                            echo "<br>";
                            } ?>
                        </td>
                    </tr>                                    
            <?php
                }
            }
        }
        else
        { ?>
            <tr>
                <td><?php echo $row_datospersona['nombresadministrativosdocentes']." ".$row_datospersona['apellidosadministrativosdocentes']; ?></td>
                <td><?php echo $row_datospersona['numerodocumento']; ?></td>
                <td colspan="5"><?php echo "Con tarjeta ".$row_datospersona['codigotarjetainteligenteadmindocen']. " No reporta registros de Entrada-Salida en el Sistema."; ?></td>
            </tr>
        <?php
        }

    }
        ?>
        </table>
    </div>
      <?php

     }
    else{
        echo "<script language='javascript'>
            alert('No se encuentran resultados para esta búsqueda, Revise los criterios y realice nuevamente la consulta.');
            </script>";
    }
}
}
            ?>
        </form>
    </div>
    </body>
</html>