<?PHP 

    session_start();
    include_once(realpath(dirname(__FILE__)).'../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    include_once(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');

    if(empty($_POST["id"]))
    {
       echo "<script>alert('Error de ingreso linea de tiempo'); location.href='../ConveniosEnTramite.php'; </script>"; 
    }else
    {
        $id = $_POST["id"];    
    }

    $SQl='SELECT l.LogSolicitudConvenioId, l.SolicitudConvenioId, l.ConvenioProcesoId, l.UsuarioCreacion, l.FechaCreacion , DATE(l.FechaCreacion) AS fecha, CONCAT(u.nombres," ",u.apellidos) AS NameUser, 
    u.usuario, cp.Nombre, cp.ConvenioProcesoId, o.Observacion 
    FROM
    LogSolicitudConvenios l INNER JOIN ConvenioProceso cp ON cp.ConvenioProcesoId=l.ConvenioProcesoId
    INNER JOIN usuario u ON u.idusuario=l.UsuarioCreacion
    LEFT JOIN ObservacionSolicitudes o ON o.LogSolicitudConvenioId=l.LogSolicitudConvenioId
    WHERE
    l.SolicitudConvenioId="'.$id.'" ORDER BY l.FechaCreacion';
    //echo $SQl;
    if($data=&$db->GetAll($SQl)===false){
        echo 'Error del Sistema....';
        die;
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Trazabilidad</title>

<link rel="stylesheet" type="text/css" href="styles.css" />

<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui.min.js"></script>

<script type="text/javascript" src="script.js"></script>

</head>
<body>

<div id="main">
     <div id="timelineLimiter"> <!-- Hides the overflowing timelineScroll div -->
	    <div id="timelineScroll"> <!-- Contains the timeline and expands to fit -->
        <?PHP
        $destino = '';
        $colors = array('green','blue','chreme');
		$scrollPoints = '';
        for($i=0;$i<count($data);$i++){
            $fecha = $data[$i]['fecha'];
            $origen = $data[$i]['NameUser'].'<br>'.$data[$i]['Nombre'].'<br>';
            if($data[$i]['ConvenioProcesoId']!=8){
            $N=$i+1;            
            $destino = $data[$N]['NameUser'];
            }
            ?>
            <div class="event">
            <?PHP echo $origen?>
            <br />
            <br />
            <div class="eventHeading <?PHP echo $colors[$i%3]?>"><?PHP echo $fecha?></div>
            <div style="text-align: right;"><?PHP echo $destino?></div>
                <ul class="eventList">
                <?PHP 
                 if($data[$i]['Observacion']){
                    ?>
                    <li class="news">
        				<span class="icon" title="News"></span>
        				<?PHP echo htmlspecialchars(substr($data[$i]['Observacion'],0,20))?>
                            <div class="content">
        					<div class="body">
                                <?PHP echo nl2br($data[$i]['Observacion'])?>
                            </div>
        					<!--<div class="title">'.htmlspecialchars($event['title']).'</div>-->
        					<div class="date"><?PHP echo date("F j, Y",strtotime($fecha))?>'</div>
    				    </div>
                    </li>
                    <?PHP
                }
                ?>
                </ul>
            </div>
            <?PHP
            
            	//$scrollPoints.='<div class="scrollPoints" style="font-size:9px">'.date("F j, Y",strtotime($fecha)).'</div>';
        }
        ?>
        <div class="clear"></div>
        </div>
      
           
        <div id="slider"> <!-- The slider container -->
        	<div id="bar" style="width: 192.269px ;"> <!-- The bar that can be dragged -->
            	<div id="barLeft"></div>  <!-- Left arrow of the bar -->
                <div id="barRight"></div>  <!-- Right arrow, both are styled with CSS -->
          </div>
        </div>
    </div>
</div>
</body>
</html>
