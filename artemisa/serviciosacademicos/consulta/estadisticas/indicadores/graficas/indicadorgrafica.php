<?php
session_start();
// generate some random data:

srand((double)microtime()*1000000);

$max = 50;
$data = array();
for( $i=0; $i<12; $i++ )
{
  $data[] = rand(0,$max);
}
// echo "indicefila<pre>";
// print_r($_SESSION["titulosindicador"]);
// 
// echo "</pre>";
// exit();
unset($data);
$valorymax=0;
$valorymin=0;
foreach($_SESSION["arraytablaprincipal"][$_GET["indicefila"]] as $codigoperido => $valor){
	if($valor<>0){
		$arrayx[]=$codigoperido;
		$data[]=$valor+0;
		if($valor>$valorymax)
			$valorymax=$valor;
		if($valor<$valorymin)
			$valorymin=$valor;
	}
}
// use the chart class to build the chart:
include_once( '../../../../funciones/clases/ofc-library/open-flash-chart.php' );
$g = new graph();

// Spoon sales, March 2007

$g->title( $_SESSION["titulosindicador"][$_GET["indicefila"]].' ', '{font-size: 18px;}' );
//. date("Y-m-d")
$g->set_data( $data );
$g->line_hollow( 2, 4, '0x80a033', $_SESSION["titulosindicador"][$_GET["indicefila"]], 10 );

// label each point with its value
$g->set_x_labels( $arrayx);

// set the Y max
$g->set_y_max( $valorymax );
// label every 20 (0,20,40,60)
$g->set_y_min( $valorymin );

$g->y_label_steps( 6 );

// display the data
echo $g->render();
?>