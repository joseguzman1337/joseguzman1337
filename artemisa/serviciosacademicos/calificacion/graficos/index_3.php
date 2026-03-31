<?php 
    include '../db/db.inc';
    $_REQUEST['id'] = 1;
    $idcl_servicio = $_REQUEST['id'];
    $dbconnect = db_connect() or trigger_error("SQL", E_USER_ERROR);
    $query = "
    select sum(clicks) votos_por_nota,'Alto' nivel,
    (select sum(clicks) from cl_evaluacion where year(fecha_evaluacion) = year(CURDATE()) and month(fecha_evaluacion) = month(ev.fecha_evaluacion)) votos_por_mes,
    month(fecha_evaluacion) as mes from cl_evaluacion ev
    inner join cl_opcion_evaluacion as op on ev.idcl_opcion_evaluacion = op.idcl_opcion_evaluacion 
    where year(ev.fecha_evaluacion) = year(CURDATE()) 
    and peso in (4,5)
    AND idcl_servicio = '$idcl_servicio'
    group by nivel,month(fecha_evaluacion)
    union
    select sum(clicks) votos_por_nota,'Medio' nivel,
    (select sum(clicks) from cl_evaluacion where year(fecha_evaluacion) = year(CURDATE()) and month(fecha_evaluacion) = month(ev.fecha_evaluacion)) votos_por_mes,
    month(fecha_evaluacion) as mes from cl_evaluacion ev
    inner join cl_opcion_evaluacion as op on ev.idcl_opcion_evaluacion = op.idcl_opcion_evaluacion 
    where year(ev.fecha_evaluacion) = year(CURDATE()) 
    and peso in (2,3)
    AND idcl_servicio = '$idcl_servicio'
    group by month(fecha_evaluacion)
    union
    select sum(clicks) votos_por_nota, 'Bajo' nivel,
    (select sum(clicks) from cl_evaluacion where year(fecha_evaluacion) = year(CURDATE()) and month(fecha_evaluacion) = month(ev.fecha_evaluacion)) as votos_por_mes,
    month(fecha_evaluacion) as mes from cl_evaluacion ev
    inner join cl_opcion_evaluacion as op on ev.idcl_opcion_evaluacion = op.idcl_opcion_evaluacion 
    where year(ev.fecha_evaluacion) = year(CURDATE()) 
    and peso in (1)
    AND idcl_servicio = '$idcl_servicio'
    group by month(fecha_evaluacion);";    
    $result = mysql_query($query, $dbconnect) or trigger_error("SQL", E_USER_ERROR);        
    
    $stralto = "{name: 'Alto',data: [";
    $strmedio = "{name: 'Medio',data: [";
    $strbajo = "{name: 'Bajo',data: [";
    $dataalto = "";
    $datamedio = "";
    $databajo = "";
    $flag = 0;
    while($row = mysql_fetch_array($result)) {
        unset($arrMes);
        for($i=1;$i<$row['mes']-1;$i++){
            $arrMes[]=0;   
        }
        $meseFaltantes = implode( ', ', $arrMes);        
        
        if($row['nivel']=="Alto"){            
            $total_nota = $row['votos_por_nota'];
            
            $total_vmes = $row['votos_por_mes'];
            $porcentaje = round(($total_nota*100)/$total_vmes,2);
            $dataalto .= ",".$porcentaje;            
        }
        if($row['nivel']=="Medio"){
            $total_nota = $row['votos_por_nota'];
            
            $total_vmes = $row['votos_por_mes'];
            $porcentaje = round(($total_nota*100)/$total_vmes,2);
            $datamedio .= ",".$porcentaje;            
        }
        if($row['nivel']=="Bajo"){
            $total_nota = $row['votos_por_nota'];
            
            $total_vmes = $row['votos_por_mes'];
            $porcentaje = round(($total_nota*100)/$total_vmes,2);
            $databajo .= ",".$porcentaje;            
        }        
    }
    $data[] = $stralto.$meseFaltantes.$dataalto."]}";
    $data[] = $strmedio.$meseFaltantes.$datamedio."]}";
    $data[] = $strbajo.$meseFaltantes.$databajo."]}";
    $data = implode( ',', $data );
    
    mysql_free_result($result);
    
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
$(document).ready(function() {
    Highcharts.theme = {
   colors: ["#DDDF0D", "#55BF3B", "#DF5353", "#7798BF", "#aaeeee", "#ff0066", "#eeaaee",
      "#55BF3B", "#DF5353", "#7798BF", "#aaeeee"],
   chart: {
      backgroundColor: {
         linearGradient: [0, 0, 250, 500],
         stops: [
            [0, 'rgb(48, 96, 48)'],
            [1, 'rgb(0, 0, 0)']
         ]
      },
      borderColor: '#000000',
      borderWidth: 2,
      className: 'dark-container',
      plotBackgroundColor: 'rgba(255, 255, 255, .1)',
      plotBorderColor: '#CCCCCC',
      plotBorderWidth: 1
   },
   title: {
      style: {
         color: '#C0C0C0',
         font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
      }
   },
   subtitle: {
      style: {
         color: '#666666',
         font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
      }
   },
   xAxis: {
      gridLineColor: '#333333',
      gridLineWidth: 1,
      labels: {
         style: {
            color: '#A0A0A0'
         }
      },
      lineColor: '#A0A0A0',
      tickColor: '#A0A0A0',
      title: {
         style: {
            color: '#CCC',
            fontWeight: 'bold',
            fontSize: '12px',
            fontFamily: 'Trebuchet MS, Verdana, sans-serif'

         }
      }
   },
   yAxis: {
      gridLineColor: '#333333',
      labels: {
         style: {
            color: '#A0A0A0'
         }
      },
      lineColor: '#A0A0A0',
      minorTickInterval: null,
      tickColor: '#A0A0A0',
      tickWidth: 1,
      title: {
         style: {
            color: '#CCC',
            fontWeight: 'bold',
            fontSize: '12px',
            fontFamily: 'Trebuchet MS, Verdana, sans-serif'
         }
      }
   },
   tooltip: {
      backgroundColor: 'rgba(0, 0, 0, 0.75)',
      style: {
         color: '#F0F0F0'
      }
   },
   toolbar: {
      itemStyle: {
         color: 'silver'
      }
   },
   plotOptions: {
      line: {
         dataLabels: {
            color: '#CCC'
         },
         marker: {
            lineColor: '#333'
         }
      },
      spline: {
         marker: {
            lineColor: '#333'
         }
      },
      scatter: {
         marker: {
            lineColor: '#333'
         }
      },
      candlestick: {
         lineColor: 'white'
      }
   },
   legend: {
      itemStyle: {
         font: '9pt Trebuchet MS, Verdana, sans-serif',
         color: '#A0A0A0'
      },
      itemHoverStyle: {
         color: '#FFF'
      },
      itemHiddenStyle: {
         color: '#444'
      }
   },
   credits: {
      style: {
         color: '#666'
      }
   },
   labels: {
      style: {
         color: '#CCC'
      }
   },

   navigation: {
      buttonOptions: {
         backgroundColor: {
            linearGradient: [0, 0, 0, 20],
            stops: [
               [0.4, '#606060'],
               [0.6, '#333333']
            ]
         },
         borderColor: '#000000',
         symbolStroke: '#C0C0C0',
         hoverSymbolStroke: '#FFFFFF'
      }
   },

   exporting: {
      buttons: {
         exportButton: {
            symbolFill: '#55BE3B'
         },
         printButton: {
            symbolFill: '#7797BE'
         }
      }
   },

   // scroll charts
   rangeSelector: {
      buttonTheme: {
         fill: {
            linearGradient: [0, 0, 0, 20],
            stops: [
               [0.4, '#888'],
               [0.6, '#555']
            ]
         },
         stroke: '#000000',
         style: {
            color: '#CCC',
            fontWeight: 'bold'
         },
         states: {
            hover: {
               fill: {
                  linearGradient: [0, 0, 0, 20],
                  stops: [
                     [0.4, '#BBB'],
                     [0.6, '#888']
                  ]
               },
               stroke: '#000000',
               style: {
                  color: 'white'
               }
            },
            select: {
               fill: {
                  linearGradient: [0, 0, 0, 20],
                  stops: [
                     [0.1, '#000'],
                     [0.3, '#333']
                  ]
               },
               stroke: '#000000',
               style: {
                  color: 'yellow'
               }
            }
         }
      },
      inputStyle: {
         backgroundColor: '#333',
         color: 'silver'
      },
      labelStyle: {
         color: 'silver'
      }
   },

   navigator: {
      handles: {
         backgroundColor: '#666',
         borderColor: '#AAA'
      },
      outlineColor: '#CCC',
      maskFill: 'rgba(16, 16, 16, 0.5)',
      series: {
         color: '#7798BF',
         lineColor: '#A6C7ED'
      }
   },

   scrollbar: {
      barBackgroundColor: {
            linearGradient: [0, 0, 0, 20],
            stops: [
               [0.4, '#888'],
               [0.6, '#555']
            ]
         },
      barBorderColor: '#CCC',
      buttonArrowColor: '#CCC',
      buttonBackgroundColor: {
            linearGradient: [0, 0, 0, 20],
            stops: [
               [0.4, '#888'],
               [0.6, '#555']
            ]
         },
      buttonBorderColor: '#CCC',
      rifleColor: '#FFF',
      trackBackgroundColor: {
         linearGradient: [0, 0, 0, 10],
         stops: [
            [0, '#000'],
            [1, '#333']
         ]
      },
      trackBorderColor: '#666'
   },

   // special colors for some of the
   legendBackgroundColor: 'rgba(0, 0, 0, 0.5)',
   legendBackgroundColorSolid: 'rgb(35, 35, 70)',
   dataLabelsColor: '#444',
   textColor: '#C0C0C0',
   maskColor: 'rgba(255,255,255,0.3)'
};

// Apply the theme
var highchartsOptions = Highcharts.setOptions(Highcharts.theme);
	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'container',
			type: 'line'
		},
		title: {
			text: 'Historico de Nivel de Servicio'
		},
		subtitle: {
			text: ''
		},
		xAxis: {
			categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
		},
		yAxis: {
			title: {
				text: '% Nivel de Servicio'
			}
		},
		tooltip: {
			enabled: false,
			formatter: function() {
				return '<b>'+ this.series.name +'</b><br/>'+
					this.x +': '+ this.y +' % ';
			}
		},
		plotOptions: {
			line: {
				dataLabels: {
					enabled: true
				},
				enableMouseTracking: false
			}
		},
                
                series: [<?php echo $data;?>]
		//series: [{name: 'Alto',data: [3.7, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9]},
                //        {
		//	name: 'Medio',
		//	data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6]
		//}, {
		//	name: 'Bajo',
		//	data: [2.9, 1.2, 1.7, 1.5, 1.9, 1.2, 1.0, 1.6, 1.2, 1.3, 2.6]
		//}]
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
	<center><h4>Historico de Nivel de Servicio</h4></center>
	<div id="container" style="width: 800px; height: 400px; margin: 0 auto"></div>
		
</body>
</html>
