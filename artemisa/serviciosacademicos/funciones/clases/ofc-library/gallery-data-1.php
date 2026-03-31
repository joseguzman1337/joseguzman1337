<?php

// generate some random data
srand((double)microtime()*1000000);

$max = 20;
$tmp = array();
$meses=array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
for( $i=0; $i<9; $i++ )
{
  $tmp[] = rand(0,$max);

}

include_once( '../../serviciosacademicos/funciones/clases/ofc-library/open-flash-chart.php' );
$g = new graph();
$g->set_data( $tmp );
$g->set_x_labels( $meses );
$g->title( 'Size Example', '{font-size: 15px}' );
echo $g->render();
?>
