<?php


function Primer_Palabra($cadena) {
	if (!empty ($cadena)) {
		$words = preg_split("/[\s,]+/", trim($cadena));
		return $words[0];
	} else
		return $cadena;
}

function Opciones_Color() {
	return "#003399,#993366,#009966,#ff6699,#ffffff,#ff9966,#6699ff,#666699,#ffccff,#00ccff,#ffff00,#66ff33,#ff0000,#6600ff,#00cc00,#ffccff,#ffcc99,#00ff00,#cccc33,#ffffcc,#00ff99";
}


//este php solo incluye la barra de navegación
function DibujarBarraInferior($IdiomaSitio = 1) {

	switch ($IdiomaSitio) {
		case 2 : //portugues
			$Mensajes = array (
				"msg-3" => "Contáctenos"
			);
			break;
		case 3 : //english
			$Mensajes = array (
				"msg-3" => "Contact us"
			);
			break;
		default : // == castellano
			$Mensajes = array (
				"msg-3" => "Contáctenos"
		);
	}
	?>
	   <tr>
	    <td height="25" background="../images/bar-below.jpg" bgcolor="#E4E4E4">
	    <div align="center" style="font-size:10px;font-family:Verdana;color:FFFFFF">
	           <a href="../mail/contactenos.php">
	              <span style="color:#E4E4E4"><?= $Mensajes["msg-3"] ?></span></a>
	     </div></td>
	  </tr>
<?}


/***************************/
/******FUNCIONES PARA EL PIDU; BORRAR*********************/
/***************************/
function armarScriptInstituciones($tablaInt, $tablaValoresInt, $tablaLongInt) {

	$Instruccion = "SELECT Codigo_Pais,Nombre,Codigo FROM instituciones ORDER BY Codigo_Pais,Nombre";
	$result = mysql_query($Instruccion);
	$cod_pais_anterior = "";
	$Indice = "";
	if (mysql_num_rows($result) > 0) {
		while ($row = mysql_fetch_row($result)) {

			If ($cod_pais_anterior != $row[0]) { //Inicializo el vector de dependencia de la institucion nueva
				$Indice[$row[0]] = 0;
				echo $tablaInt . "[" . $row[0] . "]=new Array;\n";
				echo $tablaValoresInt . "[" . $row[0] . "]=new Array;\n";
				$cod_pais_anterior = $row[0];
			}
			$pos = $Indice[$row[0]];

			echo $tablaInt . "[" . $row[0] . "][" . $pos . "]='" . $row[1] . "';\n";
			echo $tablaValoresInt . "[" . $row[0] . "][" . $pos . "]=" . $row[2] . ";\n";

			$Indice[$row[0]] += 1;

		}
		echo "//Reflejo las longitudes de los vectores\n";
		echo "\n";

		while (list ($key1, $valor1) = each($Indice)) {
			echo $tablaLongInt . "[" . $key1 . "]=" . $valor1 . ";\n";
		}

	}

	mysql_free_result($result);
}
function armarScriptDependencia($tablaDependencias, $tablaValoresDep, $tablaLongDep) {

	$Instruccion = "SELECT Codigo_Institucion,Nombre,Id FROM dependencias ORDER BY Codigo_Institucion,Nombre";
	$result = mysql_query($Instruccion);
	$cod_institucion_anterior = "";
	$Indice = "";
	if (mysql_num_rows($result) > 0) {
		while ($row = mysql_fetch_row($result)) {

			If ($cod_institucion_anterior != $row[0]) { //Inicializo el vector de dependencia de la institucion nueva
				$Indice[$row[0]] = 0;
				echo $tablaDependencias . "[" . $row[0] . "]=new Array;\n";
				echo $tablaValoresDep . "[" . $row[0] . "]=new Array;\n";
				$cod_institucion_anterior = $row[0];
			}
			$pos = $Indice[$row[0]];

			echo $tablaDependencias . "[" . $row[0] . "][" . $pos . "]='" . $row[1] . "';\n";
			echo $tablaValoresDep . "[" . $row[0] . "][" . $pos . "]=" . $row[2] . ";\n";

			$Indice[$row[0]] += 1;

		}
		echo "//Reflejo las longitudes de los vectores\n";
		echo "\n";

		while (list ($key1, $valor1) = each($Indice)) {
			echo $tablaLongDep . "[" . $key1 . "]=" . $valor1 . ";\n";
		}

	}
	mysql_free_result($result);

}

function armarScriptUnidades($tabla_Unidades, $tabla_val_Uni, $tabla_Long_Uni) {
	$Instruccion = "SELECT Codigo_Dependencia,Nombre,Id FROM unidades ORDER BY Codigo_Dependencia,Nombre";
	$result = mysql_query($Instruccion);
	$cod_dependencia_anterior = "";
	$Indice = "";
	if (mysql_num_rows($result) > 0) {
		while ($row = mysql_fetch_row($result)) {

			If ($cod_dependencia_anterior != $row[0]) {
				$Indice[$row[0]] = 0;
				echo $tabla_Unidades . "[" . $row[0] . "]=new Array;\n";
				echo $tabla_val_Uni . "[" . $row[0] . "]=new Array;\n";
				$cod_dependencia_anterior = $row[0];
			}
			$pos = $Indice[$row[0]];
			echo $tabla_Unidades . "[" . $row[0] . "][" . $pos . "]='" . $row[1] . "';\n";
			echo $tabla_val_Uni . "[" . $row[0] . "][" . $pos . "]=" . $row[2] . ";\n";
			$Indice[$row[0]] += 1;

		}

		if ($tabla_Long_Uni != "") {
			echo "//Reflejo las longitudes de los vectores\n";
			echo "\n";
			while (list ($key1, $valor1) = each($Indice)) {
				echo $tabla_Long_Uni . "[" . $key1 . "]=" . $valor1 . ";\n";
			}
		}

	}
	mysql_free_result($result);
}

function armarScriptLocalidades($tabla_Localidad, $tabla_val_Loc, $tabla_Long_Loc) {
	$Instruccion = "SELECT Codigo_Pais,Nombre,Id as Codigo FROM localidades ORDER BY Codigo_Pais,Nombre";
	$result = mysql_query($Instruccion);
	$cod_pais_anterior = "";
	$Indice = "";
	if (mysql_num_rows($result) > 0) {
		while ($row = mysql_fetch_row($result)) {

			If ($cod_pais_anterior != $row[0]) {
				$Indice[$row[0]] = 0;
				echo $tabla_Localidad . "[" . $row[0] . "]=new Array;\n";
				echo $tabla_val_Loc . "[" . $row[0] . "]=new Array;\n";
				$cod_pais_anterior = $row[0];
			}
			$pos = $Indice[$row[0]];
			echo $tabla_Localidad . "[" . $row[0] . "][" . $pos . "]='" . $row[1] . "';\n";
			echo $tabla_val_Loc . "[" . $row[0] . "][" . $pos . "]=" . $row[2] . ";\n";
			$Indice[$row[0]] += 1;

		}
		echo "//Reflejo las longitudes de los vectores\n";
		echo "\n";

		while (list ($key1, $valor1) = each($Indice)) {
			echo $tabla_Long_Loc . "[" . $key1 . "]=" . $valor1 . ";\n";
		}

	}
	mysql_free_result($result);
}

function armarScriptPaises($tabla_Pais, $tabla_val_Pais) {
	$Instruccion = "SELECT Id,Nombre FROM paises ORDER BY Nombre";
	$result = mysql_query($Instruccion);
	$contpaises = 0;
	if (mysql_num_rows($result) > 0) {
		while ($row = mysql_fetch_row($result)) {

			echo $tabla_Pais . "[" . $contpaises . "]='" . $row[1] . "';\n";
			echo $tabla_val_Pais . "[" . $contpaises . "]=" . $row[0] . ";\n";
			$contpaises++;

		}

		echo "contpaises=" . $contpaises . ";";

	}
	echo "contpaises=" . $contpaises . ";";
	mysql_free_result($result);
}
?>
