<?php 
    include '../db/db.inc';
    $_REQUEST['id'] = 1;
    $idcl_servicio = $_REQUEST['id'];
    $dbconnect = db_connect() or trigger_error("SQL", E_USER_ERROR);
    
    $query = "
    select opcion,sum(clicks) as votos_opcion,month(fecha_evaluacion) mes,year(CURDATE()) as anio
    from cl_evaluacion as ev inner join cl_opcion_evaluacion as op on ev.idcl_opcion_evaluacion = op.idcl_opcion_evaluacion 
    where year(fecha_evaluacion) = year(CURDATE()) AND idcl_servicio = '$idcl_servicio' group by op.idcl_opcion_evaluacion,month(fecha_evaluacion)
    order by op.idcl_opcion_evaluacion,fecha_evaluacion,1;
    ";
    $result = mysql_query($query, $dbconnect) or trigger_error("SQL", E_USER_ERROR);
    $color=0;
    $flag=0;    
    $nexPor[]="";
    
    while ($row = mysql_fetch_assoc($result)) {
            $array[] = $row;
    } // while
    //echo "<pre>";
    
    for($i=0;$i<count($array);$i++){        
        $query2 = "select sum(clicks) as total_votos from cl_evaluacion 
            where year(fecha_evaluacion) = year(CURDATE())
        and month(fecha_evaluacion) = '".$array[$i]['mes']."'
        AND idcl_servicio = '$idcl_servicio';";
        $result2 = mysql_query($query2, $dbconnect) or trigger_error("SQL", E_USER_ERROR);        
        $row2 = mysql_fetch_array($result2);
        $total_votos = $row2['total_votos'];
        $restodata = "";
        $porcentaje = round(($array[$i]['votos_opcion']*100) / $total_votos,2);        
        $array[$i]['porcentaje'] = round($porcentaje,2);
        //$nexPor[]=$array[$i]['porcentaje'];
        unset($arrMes);        
        if($array[$i+1]['opcion'] == $array[$i]['opcion']){            
            for($j=1;$j<$array[$i]['mes'];$j++){
                $arrMes[]=0;
            }            
        }else{            
            for($j=1;$j<$array[$i+1]['mes'];$j++){
                $arrMes[]=0;
            }
            //unset($nexPor);
        }
        
        //echo "<br>";
        //echo "<pre>";
        //print_r($array[$i]);
        
        if($array[$i+1]['opcion'] != $array[$i]['opcion'] and $array[$i+1]['opcion']!=""){
            unset($nexPor);
            for($k=1;$k<count($array);$k++){
                if($array[$k]['opcion'] == $array[$i]['opcion']){
                    $nexPor[] = $array[$k]['porcentaje'];
                }      
            }
            
            //echo "<pre>";
            $meseFaltantes = implode( ',', $arrMes);
            //echo "<br>";
            $datap = implode( ',',$nexPor);
            //print_r($nexPor);
            
//            //$array[$i+1]['opcion'];
            $data[] = str_replace(",,",",","{name: '".$array[$i]['opcion']."', data: [".$meseFaltantes.",".$datap).']}';
        }
    }
    //print_r($array);
    //print_r($data);
    
    //
    //exit();
    
//    while($row = mysql_fetch_array($result)) {
//        
//                     
//        if($flag == 0){
//            $varop = $row['opcion'];
//            $flag = 1;            
//        }
//        if($flag == 1 and $varop != $row['opcion']){
//           //echo $varop = $row['opcion'];
//           
//        }
//        //echo $varop;
//        if($varop != $row['opcion']){
//            $flag = 0;
//            //echo $row['opcion'];            
//            
//            $varop = $row['opcion'];
//        }
        
        //
        
        
        //if($flag == 0){    
        //    $varop = $row['opcion'];                        
        //    $serienet = "$seriesstr"."data: [".$meseFaltantes.",".round($porcentaje,2);
        //    if ($flag==0){
                //$data[] = $serienet.','.round($porcentaje,2).']}';
       //     }
        //}else{
        //    if($varop != $row['opcion']){           
        //        $flag = 0;
       //         $varop = $row['opcion'];
       //         $seriesstr = "{name: '$varop',";                
       //         $meseFaltantes = implode( ', ', $arrMes);  
       ///         $serienet = "$seriesstr"."data: [".$meseFaltantes.",".round($porcentaje,2);               
       ///     }else if ($flag!=0){
       ///         $data[] = $serienet.','.round($porcentaje,2).']}';
       //     }
       // }        
    //}
    mysql_free_result($result);
    //print_r($data);
    $data = implode( ',',$data);
    //echo "<pre>";
    //print_r($data);
    //exit();
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
	chart = new Highcharts.Chart({
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
		chart: {
			renderTo: 'container',
			type: 'column'
		},
		title: {
			text: 'Resultado Mensual de Calificacion'
		},
		subtitle: {
			text: ''
		},
		xAxis: {
			categories: [
				'Ene',
				'Feb',
				'Mar',
				'Abr',
				'May',
				'Jun',
				'Jul',
				'Ago',
                                'Sep',
                                'Oct',
                                'Nov',
                                'Dic'
			]
		},
		yAxis: {
			min: 0,
			title: {
				text: 'Numero de Evaluaciones de satifaccion: <?php echo $total_votos;?>'
			}
		},
		legend: {
			layout: 'vertical',
			backgroundColor: '#FFFFFF',
			align: 'left',
			verticalAlign: 'top',
			x: 100,
			y: 70,
			floating: true,
			shadow: true
		},
		tooltip: {
			formatter: function() {
				return ''+
					this.x +': '+ this.y +' ';
			}
		},
		plotOptions: {
			column: {
				pointPadding: 0.2,
				borderWidth: 0
			}
		},
			series: [
                        <?php echo $data ?>
            ]
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
	<center><h4>Historico de Calificacion</h4></center>
	<div id="container" style="width: 800px; height: 400px; margin: 0 auto"></div>
		
</body>
</html>
