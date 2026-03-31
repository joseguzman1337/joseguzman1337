<?php 
    include '../db/db.inc';
    error_reporting(0);
    if(!$_REQUEST['id']){
        $_REQUEST['id'] = 1;
    }
    $idcl_servicio = $_REQUEST['id'];
    $dbconnect = db_connect() or trigger_error("SQL", E_USER_ERROR);
    $query = "select sum(clicks) as total_votos from cl_evaluacion where fecha_evaluacion = CURDATE() AND idcl_servicio = '$idcl_servicio';";
    $result = mysql_query($query, $dbconnect) or trigger_error("SQL", E_USER_ERROR);        
    $row = mysql_fetch_array($result);
    $total_votos = $row['total_votos'];
    mysql_free_result($result);
    $query = "select sum(peso)*sum(clicks) as total_votacion from cl_evaluacion as ev 
    inner join cl_opcion_evaluacion as op on ev.idcl_opcion_evaluacion = op.idcl_opcion_evaluacion 
    where fecha_evaluacion = CURDATE() AND idcl_servicio = '$idcl_servicio'
    group by ev.idcl_opcion_evaluacion";

    $result = mysql_query($query, $dbconnect) or trigger_error("SQL", E_USER_ERROR);
    
    while($row = mysql_fetch_array($result)) {            
        $total_votacion += $row['total_votacion'];
    }    
    
    mysql_free_result($result);
    
    $total_alto = $row['TOTAL_ALTO'];
    
    $query = "select sum(clicks) as TOTAL_ALTO from cl_evaluacion where fecha_evaluacion = CURDATE() AND idcl_servicio = '$idcl_servicio' AND idcl_opcion_evaluacion IN (1,2);";
    $result = mysql_query($query, $dbconnect) or trigger_error("SQL", E_USER_ERROR);
    $row = mysql_fetch_array($result);
    $total_alto = $row['TOTAL_ALTO'];
    mysql_free_result($result);
    $porcentajealto = ($total_alto*100)/$total_votos;
    $stado[]= $porcentajealto;
    $query = "select sum(clicks) as TOTAL_MEDIO from cl_evaluacion where fecha_evaluacion = CURDATE() AND idcl_servicio = '$idcl_servicio' AND idcl_opcion_evaluacion IN (3,4);";
    $result = mysql_query($query, $dbconnect) or trigger_error("SQL", E_USER_ERROR);        
    $row = mysql_fetch_array($result);
    $total_medio = $row['TOTAL_MEDIO'];
    mysql_free_result($result);
    $porcentajemedio = ($total_medio*100) / $total_votos;
    $stado[]= $porcentajemedio;
    $query = "select sum(clicks) as TOTAL_BAJO from cl_evaluacion where fecha_evaluacion = CURDATE() AND idcl_servicio = '$idcl_servicio' AND idcl_opcion_evaluacion IN (5);";
    $result = mysql_query($query, $dbconnect) or trigger_error("SQL", E_USER_ERROR);        
    $row = mysql_fetch_array($result);
    $total_bajo = $row['TOTAL_BAJO'];
    mysql_free_result($result);    
    $porcentajebajo = ($total_bajo*100) / $total_votos;
    $stado[] = $porcentajebajo;    
        
    $notapromedio = $total_votacion/$total_votos;
    if($notapromedio>4){
        $stadosa['alto'] = intval($stado[0]);
        $stadosa['medio'] = 0;
        $stadosa['bajo'] = 0;
        $stadosa['total'] = $total_alto;
    }
    if($notapromedio>=3 and $notapromedio<=4){
        $stadosa['alto'] = 0;
        $stadosa['medio'] = intval($stado[0]);
        $stadosa['bajo'] = 0;
        $stadosa['total'] = $total_medio;
    }
    if($notapromedio<3){
        $stadosa['alto'] = 0;
        $stadosa['medio'] = 0;
        $stadosa['bajo'] = intval($stado[0]);
        $stadosa['total'] = $total_bajo;
    }
    //print_r($stadosa);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Estadisticas Servicios</title>
            <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
            <script type="text/javascript" src="js/highcharts.js"></script>
            <!-- Este archivo es para darle un estilo (Este archivo es Opcional) -->
            <script type="text/javascript" src="js/themes/grid.js"></script>
            <!-- Este archivo es para poder exportar losd atos que obtengamos -->
            <!--script type="text/javascript" src="js/modules/exporting.js"></script-->
            <script type="text/javascript">
            var chart;
            function Refresh() {
                location.reload();
            };
            $(document).ready(function() {
                    chart = new Highcharts.Chart({
                            width : 300,
                            chart: {
                                    renderTo: 'container',
                                    type: 'column'
                            },
                            colors: [
                                '#89A54E',
                                '#4572A7', 
                                '#FFFF00',                                  
                                '#80699B', 
                                '#3D96AE', 
                                '#DB843D', 
                                '#92A8CD', 
                                '#A47D7C', 
                                '#B5CA92'
                                ],
                            title: {
                                    text: 'Nivel de Servicio - Hoy'
                            },
                            xAxis: {
                                    categories: ['Nivel del Servicio']
                            },
                            yAxis: {
                                    min: 1,
                                    title: {
                                            text: 'Total de Registros: <?php echo $total_votos;?>'
                                    },
                                    stackLabels: {
                                            enabled: true,
                                            style: {
                                                    fontWeight: 'bold',
                                                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                                            }
                                    }
                            },
                            legend: {
                                    align: 'right',
                                    x: -100,
                                    verticalAlign: 'top',
                                    y: 20,
                                    floating: true,
                                    backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
                                    borderColor: '#CCC',
                                    borderWidth: 1,
                                    shadow: false
                            },
                            tooltip: {
                                    formatter: function() {
                                            return '<b>'+ this.x +'</b><br/>'+
                                                    this.series.name +': '+ this.y +' % <br/>'+
                                                    'Numero de Calificaciones: '+'<?php echo $stadosa['total'];?>';
                                                    //'Total: '+ this.point.stackTotal;
                                    }
                            },
                            plotOptions: {
                                    column: {
                                            stacking: 'normal',
                                            dataLabels: {
                                                    enabled: true,
                                                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                                            }
                                    }
                            },
                            series: [{
                                    name: 'Alto',
                                    data: [<?php echo $stadosa['alto'];?>]
                            }, {
                                    name: 'Medio',
                                    data: [<?php echo $stadosa['medio'];?>]
                            }, {
                                    name: 'Bajo',
                                    data: [<?php echo $stadosa['bajo'];?>]
                            }]
                    });
                    //setTimeout("Refresh()", 5000); //5 sec.
            });
            
            
        
            </script>
    <style type="text/css">
    h4{ font-family:Arial, Helvetica, sans-serif;color:#630;}
    .cabecera{
    background: #4A3C31;
    border-bottom: 5px solid #69AD3C;
    margin:-8px 0 0 -8px;
    width: 100%;
    }
    .cabecera img{ margin:40px 0 0 30px; }
    </style>	
    </head>
<body>
	<center><h4>Nivel de Servicio</h4></center>
	<div id="container" style="width: 600px; height: 400px; margin: 0 auto"></div>
</body>
</html>
