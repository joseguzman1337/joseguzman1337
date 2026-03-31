<?php 
    include '../db/db.inc';
    $_REQUEST['id'] = 1;
    $idcl_servicio = $_REQUEST['id'];
    $dbconnect = db_connect() or trigger_error("SQL", E_USER_ERROR);
    $query = "select sum(clicks) as total_votos from cl_evaluacion where fecha_evaluacion = CURDATE() AND idcl_servicio = '$idcl_servicio';";
    $result = mysql_query($query, $dbconnect) or trigger_error("SQL", E_USER_ERROR);        
    $row = mysql_fetch_array($result);
    $total_votos = $row['total_votos'];
    mysql_free_result($result);
    
    $query = "select sum(clicks) as votos_opcion, opcion 
    from cl_evaluacion as ev
    inner join cl_opcion_evaluacion as op on ev.idcl_opcion_evaluacion = op.idcl_opcion_evaluacion 
    where fecha_evaluacion = CURDATE() AND idcl_servicio = '$idcl_servicio' group by op.idcl_opcion_evaluacion;
    ";
    $result = mysql_query($query, $dbconnect) or trigger_error("SQL", E_USER_ERROR);
    $color=0;
    $colort=0;
    while($row = mysql_fetch_array($result)) {
        $porcentaje = ($row['votos_opcion']*100) / $total_votos;
        $opcion[] = "'".$row['opcion']."'";
        if($row['opcion']=="Malo"){
            $colort =9;
        }
        $data[] = "{y: ".  round($porcentaje,2).",color: colors[$color]}";
        $color++;
    }
    
    mysql_free_result($result);
    $data = implode( ', ', $data );    
    $opcion =  implode( ', ', $opcion );
    
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
		<script type="text/javascript" src="js/modules/exporting.js"></script>
	
		<script type="text/javascript">
		
			var chart;
                        var colorsp = new Array(3);
                        colorsp[0]= '#89A54E';
                        colorsp[1]= '#4572A7'; 
                        colorsp[2]= '#FFFF00';
                        colorsp[3]= '#FF0000';
                        //var colors = '','#DB843D','#92A8CD','#A47D7C','#B5CA92');
            $(document).ready(function() {

                var colors = colorsp,
                		categories = [<?php echo $opcion;?>],
		name = 'Evaluacion de Servicio',
		data = [
                        <?php echo $data;?>
                        //{
			//	y: 55.11,
		//		color: colors[0]//,
				//drilldown: {
				//	name: 'MSIE versions',
				//	categories: ['MSIE 6.0', 'MSIE 7.0', 'MSIE 8.0', 'MSIE 9.0'],
				//	data: [10.85, 7.35, 33.06, 2.81],
				//	color: colors[0]
				//}
		//	}, {
				//y: 21.63,
				//color: colors[1]//,
//				drilldown: {
//					name: 'Firefox versions',
//					categories: ['Firefox 2.0', 'Firefox 3.0', 'Firefox 3.5', 'Firefox 3.6', 'Firefox 4.0'],
//					data: [0.20, 0.83, 1.58, 13.12, 5.43],
//					color: colors[1]
//				}
			//}, {
				//y: 11.94,
				//color: colors[2]//,
//				drilldown: {
//					name: 'Chrome versions',
//					categories: ['Chrome 5.0', 'Chrome 6.0', 'Chrome 7.0', 'Chrome 8.0', 'Chrome 9.0',
//						'Chrome 10.0', 'Chrome 11.0', 'Chrome 12.0'],
//					data: [0.12, 0.19, 0.12, 0.36, 0.32, 9.91, 0.50, 0.22],
//					color: colors[2]
//				}
			//}, {
				//y: 7.15,
				//color: colors[3]//,
//				drilldown: {
//					name: 'Safari versions',
//					categories: ['Safari 5.0', 'Safari 4.0', 'Safari Win 5.0', 'Safari 4.1', 'Safari/Maxthon',
//						'Safari 3.1', 'Safari 4.1'],
//					data: [4.55, 1.42, 0.23, 0.21, 0.20, 0.19, 0.14],
//					color: colors[3]
//				}
			//}, {
			//	y: 2.14,
			//	color: colors[4]//,
//				drilldown: {
//					name: 'Opera versions',
//					categories: ['Opera 9.x', 'Opera 10.x', 'Opera 11.x'],
//					data: [ 0.12, 0.37, 1.65],
//					color: colors[4]
//				}
			//}
                        ];

	function setChart(name, categories, data, color) {
		chart.xAxis[0].setCategories(categories);
		chart.series[0].remove();
		chart.addSeries({
			name: name,
			data: data,
			color: color || 'white'
		});
	}

	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'container',
			type: 'column'
		},
		title: {
			text: 'Estadisticas del servicio al dia de hoy'
		},
		subtitle: {
			text: 'Numero de Registros de Evaluaciones: <?php echo $total_votos;?>'
		},
		xAxis: {
			categories: categories
		},
		yAxis: {
			title: {
				text: 'Numero de Registros de Evaluaciones: <?php echo $total_votos;?>'
			}
		},
		plotOptions: {
			column: {
				cursor: 'pointer',
				point: {
					events: {
						click: function() {
							var drilldown = this.drilldown;
							if (drilldown) { // drill down
								setChart(drilldown.name, drilldown.categories, drilldown.data, drilldown.color);
							} else { // restore
								setChart(name, categories, data);
							}
						}
					}
				},
				dataLabels: {
					enabled: true,
					color: colors[0],
					style: {
						fontWeight: 'bold'
					},
					formatter: function() {
						return this.y +'%';
					}
				}
			}
		},
		tooltip: {
			formatter: function() {
				var point = this.point,
					s = this.x +':<b>'+ this.y +'% </b><br/>';
				if (point.drilldown) {
					s += 'Click to view '+ point.category +' versions';
				} else {
					s += 'Click to return to browser brands';
				}
				return s;
			}
		},
		series: [{
			name: name,
			data: data,
			color: 'white'
		}],
		exporting: {
			enabled: false
		}
	});
});
				
		</script>
<style type="text/css">
		   h4{ font-family:Arial, Helvetica, sans-serif;
		   color:#630;}
		   .cabecera{
                background: #4A3C31;
                border-bottom: 5px solid #69AD3C;
                margin:-8px 0 0 -8px;
                width: 100%;
			}
           .cabecera img{ 
		        margin:40px 0 0 30px;
		    }

</style>	
	</head>
<body>
	<center><h4>Estadisticas de servicio por dia</h4></center>
	<div id="container" style="width: 800px; height: 400px; margin: 0 auto"></div>
</body>
</html>