<?
require_once ('XMLParser.php');

$resumen = array ();

/**
 * espera un string de long 7 y verifica que $anio esté dentro de ese intervalo corto
 */
function verificarIntervaloCorto($str, $anio){
	$aux = explode('-', $str);

	if ((sizeof($aux) == 2) and (strlen($aux[0]) == '4') and (strlen($aux[1]) == 2)) //si no es algo de la forma xxxx-xx lo tiro
		{
		$max = '19' . $aux[1];
		if ($max < $aux[0]) //el segundo límite era 20xx
			$max = '20' . $max;
		return (($aux[0] <= $anio) and ($max >= $anio));
	} else
		if (strstr($str, '/')) //puede ser que el intervalo esté separado por / y no por -
			{
			$aux = explode('/', $str);
			if ((sizeof($aux) == 2) and (strlen($aux[0]) == '4') and (strlen($aux[1]) == 2)) //si no es algo de la forma xxxx-xx lo tiro
				{
				$max = '19' . $aux[1];
				if ($max < $aux[0]) //el segundo límite era 20xx
					$max = '20' . $max;
				return (($aux[0] <= $anio) and ($max >= $anio));
			} else
				return false;
		} else
			return false;
}

/**
 * espera un string de long 9 y verifica que $anio esté dentro de ese intervalo largo
 */
function verificarIntervaloLargo($str, $anio){
	$aux = explode('-', $str);
	if ((sizeof($aux) == 2) and (strlen($aux[0]) == '4') and (strlen($aux[1]) == 4)) //si no es algo de la forma xxxx-xxxx lo tiro
		return (($aux[0] <= $anio) and ($anio <= $aux[1]));
	else
		if (strstr($str, '/')) {
			$aux = explode('/', $str);
			if ((sizeof($aux) == 2) and (strlen($aux[0]) == '4') and (strlen($aux[1]) == 4)) //si no es algo de la forma xxxx-xx lo tiro
				{
				return (($aux[0] <= $anio) and ($aux[1] >= $anio));
			} else
				return false;
		} else
			return false;
}

function verificarIntervaloAbierto($str1, $anio) {
	$aux = explode('-', $str1);
	if ((sizeof($aux) == 1) and (strlen($aux[0] == 4)))
		return ($aux[0] <= $anio);
	else
		return false;
}

/**
 * recibe un string y retorna true si parece ser un año posterior a 1800
 */
function pareceAnioValido($str, $anio){
	if ($str == $anio) {
		return true;
	} else {
		$sinPar = substr($str, strpos($str, '(') + 1, 4);
	
		if ($sinPar == $anio)
			return true;
		else {
			$arr = explode(';', $str);
			for ($i = 0; $i < sizeof($arr); $i++) {
				$str1 = $arr[$i];

				if (strstr($str1, ',')) //posee comas en el medio, asi que no es un intervalo de años
					return false;
				 else {
					switch (strlen($str1)) //en vez de ser un año puede ser un intervalo separado por - como ser 1998-99
						{
						case 5 : //es algo de la forma 1999- que significa desde 1999 en adelante
							return (verificarIntervaloAbierto($str1, $anio));
							break;
						case 7 : //es algo de la forma 1999-00
							return verificarIntervaloCorto($str1, $anio);
							break;
						case 9 : //es algo de la forma 1998-2000
							return verificarIntervaloLargo($str1, $anio);
							break;
						default :
							return false;
					}
				}
			}
			return false;
		}
	}
}

/**
 * Esta funcion toma el string str y resalta, si es que existen, 
 * todas las coincidencias que parezcan ser ese año o ese volumen
 */
function resaltarParametros($str, $anio, $volumen){
	$ok = false;
	$arr = explode(' ', $str);
	//en $arr tengo todas las palabras sueltas, ahora las voy a trabajar una por una para ver si tienen algo resaltable
	for ($i = 0; $i < sizeof($arr); $i++) {
		if (strlen($arr[$i]) >= 4) //posiblemente sea un año
			{
			$aux = explode('[( )]', $arr[$i]);
			for ($j = 0; $j < sizeof($aux); $j++) {
				if (pareceAnioValido($aux[$j], $anio)) {
					$ok = true;
					echo "<font color='white'> " . $aux[$j] . " </font>";
				} else
					echo " " . $aux[$j] . " ";
			}
		}
	}
	return $ok;
}

/**
 * recibe toda una consulta de existencias y la imprime en forma de tabla
 */
function imprimirExistencia($tree, $anio, $Mensajes, $VectorIdioma) {
	?>
	<table border='1' width='100%' align='CENTER'>
	<? if (sizeof($tree['ROOT']['BIBLIOTECA'][0]['NOMBRE']['VALUE']) != '') {
		for ($i = 0; $i < sizeof($tree['ROOT']['BIBLIOTECA']); $i++) {
			//primero la biblioteca
			?>
			<tr>
				<td width='20%' heigth='25' bgcolor='#B7CFEE' valign='middle'>
					<font face='MS Sans Serif' size='1' color='#666699'><b><?= $Mensajes['et-001'] ?></b></font>
				</td>
				<td width='70%' bgcolor='#79A7C8' valign='middle'>
					<font face='MS Sans Serif' size='1' color='#000000'>
						<b><?= $tree['ROOT']['BIBLIOTECA'][$i]['NOMBRE']['VALUE'] ?></b>
					</font>
				</td>
			</tr>
			<?
			//luego el call number
			if ($tree['ROOT']['BIBLIOTECA'][$i]['CALLNUMBER']['VALUE'] != ''){?>
				<tr>
					<td width='*' bgcolor='#B7CFE1' valign='middle'>
						<font face='MS Sans Serif' size='1' color='#333399'><? $Mensajes['et-002'] ?></font>
					</td>
					<td width='70%' bgcolor='#79A7C8' valign='middle'>
						<font face='MS Sans Serif' size='1' color='#000000'>
							<b><?= $tree['ROOT']['BIBLIOTECA'][$i]['CALLNUMBER']['VALUE'] ?></b>
						</font>
					</td>
				</tr>
			<?}
			//ahora la existencia
			?>
			<tr>
				<td width='30%' bgcolor='#B7CFE1' valign='middle'>
					<font face='MS Sans Serif' size='1' color='#333399'><?= $Mensajes['et-003'] ?></font>
				</td>
				<td width='70%' bgcolor='#79A7C8' valign='middle'>
					<font face='MS Sans Serif' size='1' color='#000000'>
						<b>
						<?
						$str = $tree['ROOT']['BIBLIOTECA'][$i]['EXISTENCIA']['VALUE'];
						$valido = resaltarParametros($str, $anio, '');
						if ($valido) //habia algun año valido, por lo tanto, esto deberá ir en el resumen al tope de la tabla
							{
							$bib = $tree['ROOT']['BIBLIOTECA'][$i]['NOMBRE']['VALUE'];
							$call = $tree['ROOT']['BIBLIOTECA'][$i]['CALLNUMBER']['VALUE'];
							$obs = $tree['ROOT']['BIBLIOTECA'][$i]['OBSERVACIONES']['VALUE'];
							$aux = array (
								"Bib" => $bib,
								"CallNumber" => $call,
								"existencia" => $str,
								"observaciones" => $obs
							);
							global $resumen;
							array_push($resumen, $aux);
						}
						?>
						</b>
					</font>
				</td>
			</tr>
			<?
			//finalmente, las observaciones (si es que existen)
			if ($tree['ROOT']['BIBLIOTECA'][$i]['OBSERVACIONES']['VALUE'] != ''){?>
				<tr>
					<td width='*' bgcolor='#B7CFE1' valign='middle'>
						<font face='MS Sans Serif' size='1' color='#333399'><?= $Mensajes['et-004'] ?></font>
					</td>
					<td width='70%' bgcolor='#79A7C8' valign='middle'>
						<font face='MS Sans Serif' size='1' color='#000000'>
							<b><?= $tree['ROOT']['BIBLIOTECA'][$i]['OBSERVACIONES']['VALUE'] ?></b>
						</font>
					</td>
				</tr>
			<?}
		}
	} else{ //solo una biblioteca ?>
		<tr>
			<td width='20%' heigth='25' bgcolor='#B7CFEE' valign='middle'>
				<font face='MS Sans Serif' size='1' color='#666699'><b> <?= $Mensajes['et-001'] ?></b></font>
			</td>
			<td width='70%' bgcolor='#79A7C8' valign='middle'>
				<font face='MS Sans Serif' size='1' color='#000000'>
					<b><?= $tree['ROOT']['BIBLIOTECA']['NOMBRE']['VALUE'] ?></b>
				</font>
			</td>
		</tr>
		<?
		//luego el call number
		if ($tree['ROOT']['BIBLIOTECA']['CALLNUMBER']['VALUE'] != ''){?>
			<tr>
				<td width='*' bgcolor='#B7CFE1' valign='middle'>
					<font face='MS Sans Serif' size='1' color='#333399'><?= $Mensajes['et-002'] ?></font>
				</td>
				<td width='70%' bgcolor='#79A7C8' valign='middle'>
					<font face='MS Sans Serif' size='1' color='#000000'>
						<b><?= $tree['ROOT']['BIBLIOTECA']['CALLNUMBER']['VALUE'] ?></b>
					</font>
				</td>
			</tr>
		<?}
		//ahora la existencia
		?>
		<tr>
			<td width='30%' bgcolor='#B7CFE1' valign='middle'>
				<font face='MS Sans Serif' size='1' color='#333399'><?=$Mensajes['et-003'] ?></font>
			</td>
			<td width='70%' bgcolor='#79A7C8' valign='middle'>
				<font face='MS Sans Serif' size='1' color='#000000'>
					<b>
					<?							    
					$str = $tree['ROOT']['BIBLIOTECA']['EXISTENCIA']['VALUE'];
					$valido = resaltarParametros($str, $anio, '');
					if ($valido){ //habia algun año valido, por lo tanto, esto deberá ir en el resumen al tope de la tabla
						$bib = $tree['ROOT']['BIBLIOTECA']['NOMBRE']['VALUE'];
						$call = $tree['ROOT']['BIBLIOTECA']['CALLNUMBER']['VALUE'];
						$obs = $tree['ROOT']['BIBLIOTECA']['OBSERVACIONES']['VALUE'];
						$aux = array (
							"Bib" => $bib,
							"CallNumber" => $call,
							"existencia" => $str,
							"observaciones" => $obs
						);
						global $resumen;
						array_push($resumen, $aux);
					}
					?>
					</b>
				</font>
			</td>
		</tr>
		<?
		//finalmente, las observaciones (si es que existen)
		if ($tree['ROOT']['BIBLIOTECA']['OBSERVACIONES']['VALUE'] != ''){?>
			<tr>
				<td width='*' bgcolor='#B7CFE1' valign='middle'>
					<font face='MS Sans Serif' size='1' color='#333399'><?=$Mensajes['et-004']?></font>
				</td>
				<td width='70%' bgcolor='#79A7C8' valign='middle'>
					<font face='MS Sans Serif' size='1' color='#000000'>
						<b><?= $tree['ROOT']['BIBLIOTECA']['OBSERVACIONES']['VALUE'] ?></b>
					</font>
				</td>
			</tr>
		<?}
	}?>
	</table>
	<br>
	<?
}

/**
 * 
 */
function mostrarExistencias($col, $anio, $Mensajes, $VectorIdioma) {
	global $servicesFacade;
	$existencias = $servicesFacade->getExistencias(array("Id_Titulo_Colecciones" => $col));
	
	global $resumen;
	if (count($existencias) >= 1) {
		//primero la tabla resumen
		?>
		<script language="JavaScript" type="text/javascript">
  			var oldSize = 0;
			function resize(){
				var boton = document.getElementById('sizer');
				var resume = document.getElementById('resume');
				if (boton.value=='-'){ //hay que minimizar
					boton.value = '+';
					resume.style.visibility = 'hidden';
					resume.style.position = 'absolute';
				} else { //hay que maximizar
					boton.value = '-';
					resume.style.visibility = 'visible';
					resume.style.position = 'relative';
				}
			}	
		</script>
		<style type="text/css">
			#resume {
				position='relative';
				visibility='visible';
			}
		</style>
		<br>
		<table width="95%"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#ECECEC" class="table-form">
			<tr style='background:#B7CFEE'>
				<td style='background:#B7CFEE;width:95%' align='center'>
					<font face='MS Sans Serif' size='1' color='#3333AA'><b><?=$Mensajes['et-006'] ?></b></font>
				</td>
				<td style='background:#B7CFEE;width:5%' align='center'>
					<input type='button' id='sizer' onClick='resize()' value='-' style='text-color:navy;font-weight:bold'>
				</td>
			</tr>
			<tr style='width:100%'>
				<td  style='width:100%' colspan="2"> &nbsp; </td>
			</tr>
		</table>
		
		<!-- ahora la tabla grande-->
		<table width="95%"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#ECECEC" class="table-form" id="resume">
			<tr>
				<td width='100%' align='center' colspan='6' bgcolor='#666699'>
					<center>
						<font face='MS Sans Serif' size='1' color='#FFFF00'>
							<b><?= $Mensajes['et-005'] ?></b>
						</font>
					</center>
				</td>
			</tr>
			<tr>
				<td width='100%'>
					<?
					foreach($existencias as $existencia){
						$data = "<root> " . $existencia["Descripcion"] . " </root>";
						$parser = new XMLParser($data, 'raw', 1);
						$tree = $parser->getTree();
						imprimirExistencia($tree, $anio, $Mensajes, $VectorIdioma);
					}
					?>
				</td>
			</tr>
		</table>
	<? } ?>
	<script language="JavaScript" type="text/javascript">
  		var resume = document.getElementById('resume');
		<?
		for ($i = 0; $i < sizeof($resumen); $i++) {
			$bib = $resumen[$i];
			$contenido = "Biblioteca " . $bib['Bib'];
			if ($bib['CallNumber'] != '')
				$contenido .= "- CallNumber " . $bib['CallNumber'];
			$contenido .= ". Existencias " . $bib['existencia'];
			if ($bib['observaciones'] != '')
				$contenido .= ". Observaciones " . $bib['observaciones'];
			require_once "../utils/StringUtils.php";
			$contenido = StringUtils::getSafeString($contenido); 
			?>
			var nueva = document.createElement('DIV');
			var contenido = '<?=$contenido?>';
			var text=document.createTextNode(contenido);
			nueva.appendChild(text); 
			resume.appendChild(nueva);";
		<? } ?>
	</script>
<?} 
?>