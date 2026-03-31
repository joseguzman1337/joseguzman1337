<?php

require "../utils/StringUtils.php";

/**
 * Paso 4:
 * 		- Crea la estructura de la BDD celsiusNT
 * 		si es una actualizacion 
 * 			- Calcula la interseccion de datos entre la BDD 1.6 y la NT, copia esos datos en la NT
 * 			- Actualiza los datos copiados para q sean consistentes.
 * 		si es una instalacion de cero
 * 			- carga los datos iniciales en la BDD celsiusNT
 */
set_time_limit(0);

$paso_numero = 4;

require "top_layout_install.php";
?>
<table class="table-form" width="90%">
	<tr>
		<td class="table-form-top">
			<?=PASO4_SUBTITULO?>
		</td>
	</tr>
	<tr>
		<td id="display-element">
			
  		</td>
	</tr>
</table>
<br/>

<table class="table-form" width="90%" >
	<tr>
		<td style="text-align: center; background-color:white">
			<form action="instalador_controller.php?paso_numero=4" method="post">
				<input type="submit" id="btnSiguiente" disabled value="<?=COMMON_BUTTON_SIGUIENTE?>" />
			</form>
		</td>
	</tr>
</table>

<?
require "base_layout_install.php";

flush();
//sleep(3);//sacar esto
/******************************************************************************************************/

function mostrarMensaje($text, $tipo = "normal"){?>
	<script language="JavaScript" type="text/javascript">
		<? if ($tipo == "success")
			$color = "green";
		elseif ($tipo == "error")
			$color = "red";
		else
			$color="transparent";
		?>
		elem = document.createElement("pre");
		elem.style.backgroundColor="<?=$color?>";
		text = document.createTextNode("<?=StringUtils::getSafeString($text)?>");
  		elem.appendChild(text);
		document.getElementById("display-element").appendChild(elem);
	</script>
  
	<?
	flush();
}
/*
//ESTO NO SE USA MAS
echo "Creando una base de datos temporal de Celsius...";
copiarBDD($configuracion["dbname16"],$configuracion["dbnameTemp"]);
*/


mostrarMensaje(PASO4_MENSAJE_DATOSINICIALES); 
$res = executeSQLFile("sql/celsiusNT_datos_iniciales.sql");
if (is_a($res, "Celsius_Exception")){
	$msgError = PASO4_MENSAJE_ERROR_DATOSINICIALES." \n";
	$msgError .= $res->getMessage();
	if (is_a($res, "DB_Exception")){
		$msgError .="\n".COMMON_MENSAJE_ERROR_MYSQL.": ".$res->dbError . ". Error No: ".$res->dbErrorNo;
	}
	mostrarMensaje($msgError, "error");
	return;
}

if ($configuracion["tipo_instalacion"] == "actualizacion"){
	//migracion de 1.6 a NT
	mostrarMensaje(PASO4_MENSAJE_MIGRACIONBDD); 
	$res = copiarDatosComunesDeA($configuracion["dbname16"],$configuracion["dbnameNT"]);
	if (is_a($res, "Celsius_Exception")){
		$msgError = PASO4_MENSAJE_ERROR_MIGRACIONBDD." \n";
		$msgError .= $res->getMessage();
		if (is_a($res, "DB_Exception")){
			$msgError .="\n".COMMON_MENSAJE_ERROR_MYSQL.":".$res->dbError . ". Error No: ".$res->dbErrorNo;
		}
		mostrarMensaje($msgError, "error");
		return;
	}
	
	//limpieza de los datos provenientes de 1.6
	mostrarMensaje(PASO4_MENSAJE_PURGANDO);
	$res = executeSQLFile("sql/limpieza_bd_1.6.sql");
	if (is_a($res, "Celsius_Exception")){
		$msgError = PASO4_MENSAJE_ERROR_PURGANDO." \n";
		$msgError .= $res->getMessage();
		if (is_a($res, "DB_Exception")){
			$msgError .="\n ".COMMON_MENSAJE_ERROR_MYSQL.": ".$res->dbError . ". Error No: ".$res->dbErrorNo;
		}
		mostrarMensaje($msgError, "error");
		return;
	}
	
	
	//proceso actualizacion del PIDU 
	//require "actualizacion_bd_1.6.php";
	mostrarMensaje(PASO4_MENSAJE_ACTUALIZACIONPIDU);
	$res = executeSQLFile("sql/update_Ids_1.6.sql");
	if (is_a($res, "Celsius_Exception")){
		$msgError = PASO4_MENSAJE_ERROR_ACTUALIZACIONPIDU." \n";
		$msgError .= $res->getMessage();
		if (is_a($res, "DB_Exception")){
			$msgError .="\n ".COMMON_MENSAJE_ERROR_MYSQL.": ".$res->dbError . ". Error No: ".$res->dbErrorNo;
		}
		mostrarMensaje($msgError, "error");
		return;
	}
	
	
	//proceso actualizacion del resto de los datos 
	require "actualizacion_bd_1.6.php";
	mostrarMensaje(PASO4_MENSAJE_ACTUALIZACIONDATOS);
	//$res = executeSQLFile("sql/actualizacion_16_a_NT.sql");
	$res = actualizacion_16_a_NT($configuracion["dbname16"],$configuracion["dbnameNT"]);
	if (is_a($res, "Celsius_Exception")){
		$msgError = PASO4_MENSAJE_ERROR_ACTUALIZACIONDATOS." \n";
		$msgError .= $res->getMessage();
		if (is_a($res, "DB_Exception")){
			$msgError .="\n".COMMON_MENSAJE_ERROR_MYSQL.": ".$res->dbError . ". Error No: ".$res->dbErrorNo;
		}
		mostrarMensaje($msgError, "error");
		return;
	}
	
	
	//proceso actualizacion de pedidos y eventos 
	mostrarMensaje(PASO4_MENSAJE_ACTUALIZACIONPEDIDOS);
	$res = actualizacion_pedidos_16_a_NT();
	if (is_a($res, "Celsius_Exception")){
		$msgError = PASO4_MENSAJE_ERROR_ACTUALIZACIONPEDIDOS." \n";
		$msgError .= $res->getMessage();
		if (is_a($res, "DB_Exception")){
			$msgError .="\n".COMMON_MENSAJE_ERROR_MYSQL.": ".$res->dbError . ". Error No: ".$res->dbErrorNo;
		}
		mostrarMensaje($msgError, "error");
		return;
	}
}

//carga las traducciones nuevas.Borra las anteriores
mostrarMensaje(PASO4_MENSAJE_TRADUCCIONES); 
$res = executeSQLFile("sql/celsiusNT_datos_i18n.sql");
if (is_a($res, "Celsius_Exception")){
	$msgError = PASO4_MENSAJE_ERROR_TRADUCCIONES." \n";
	$msgError .= $res->getMessage();
	if (is_a($res, "DB_Exception")){
		$msgError .="\n ".COMMON_MENSAJE_ERROR_MYSQL.": ".$res->dbError . ". Error No: ".$res->dbErrorNo;
	}
	mostrarMensaje($msgError, "error");
	return;
}

if ($configuracion["tipo_instalacion"] != "actualizacion"){//es una instalacion desde cero
	mostrarMensaje(PASO4_MENSAJE_CARGANDODATOS2); 
	$res = executeSQLFile("sql/celsiusNT_datos_iniciales_instalacion.sql");
	if (is_a($res, "Celsius_Exception")){
		$msgError = PASO4_MENSAJE_ERROR_DATOSINICIALES." \n";
		$msgError .= $res->getMessage();
		if (is_a($res, "DB_Exception")){
			$msgError .="\n ".COMMON_MENSAJE_ERROR_MYSQL.": ".$res->dbError . ". Error No: ".$res->dbErrorNo;
		}
		mostrarMensaje($msgError, "error");
		
		return;
	}
}
mostrarMensaje(PASO4_MENSAJE_TERMINADO);
?>
<script language="JavaScript" type="text/javascript">
	document.getElementById("btnSiguiente").disabled=false;
</script>