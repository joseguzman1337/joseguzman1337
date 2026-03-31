<?php
/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package servicio
 */

header ('Content-type: text/html; charset=utf-8');
session_start();

if( isset ( $_SESSION["datoSesion"] ) ){ ?>
	<?php
		/*$datos = $_SESSION["datoSesion"];
		$ddf = fopen("../log/session/" . $datos[ 1 ] . "_" .$datos[ 2 ] . ".log","a");
		fwrite($ddf, date("h:i:s") );
		fwrite($ddf, "\n" );
		fwrite($ddf, serialize( $_SESSION ) );
		fwrite($ddf, "\n" );
		fwrite($ddf, "\n" );
		fclose($ddf);*/
	?>
	<div class="ui-widget" style="width: 130px">
		<div class="ui-state-highlight ui-corner-all"> 
			<p><span class="ui-icon ui-icon-circle-check" style="float: left; margin-right: .3em;"></span> 
			<strong>Conectado</strong>
		</div>
	</div>
<?php } else{ ?>  
	<?php
		/*$ddf = fopen("../log/session/" . date("d_m_y h_i") . ".log","a");
		fwrite($ddf, date("h:i:s") );
		fwrite($ddf, "\n" );
		fwrite($ddf, serialize( $_SESSION ) );
		fwrite($ddf, "\n" );
		fwrite($ddf, "\n" );
		fclose($ddf);*/
	?>
	<div class="ui-widget" style="width: 130px">
		<div class="ui-state-error ui-corner-all"> 
			<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
			<strong>Sesión expirada</strong>
		</div>
	</div>
<?php } ?>