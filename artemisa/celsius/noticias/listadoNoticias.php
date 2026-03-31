<?

/**
 * @param string operacion? indica que operacion se debe realizar sobre la noticia 
 * indicada por el parametro $idNoticia 
 * @param int $idNoticia La noticia que sera modificada por la operacion indicada 
 * por el campo operacion
 * 
 * @param int Codigo_Idioma? el codigo de idioma que debera tener la noticia. 
 * Si no esta definido erl valor por default es el Codigo_Idioma_Predeterminado. 
 * Si su valor es cero, se mostraran noticias en cualquier idioma
 * @param string Fecha_Inicio La fecha que indica a partir de que fecha se deben listar las noticias. Su formato es dd-mm-yyyy
 * @param string Fecha_Inicio La fecha que indica hasta cuando se deben listar las noticias. Su formato es dd-mm-yyyy
 * 
 */
$pageName = "noticias1";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";
global $IdiomaSitio;

$Mensajes = Comienzo($pageName, $IdiomaSitio);

if ((isset ($operacion)) && ($operacion == 'borrar')) {
	$result = $servicesFacade->borrarNoticia($idNoticia);
	if (is_a($result, "Celsius_Exception")) {
		$mensaje_error = $Mensajes["warning.errorBorrado"];
		$excepcion = $res;
		require "../common/mostrar_error.php";
	}
}

if (!isset ($Codigo_Idioma)) {
	$idiomaPredeterminado = $servicesFacade->getIdiomaPredeterminado();
	$Codigo_Idioma = $idiomaPredeterminado["Id"];
}

if (empty ($Fecha_Inicio)) 
	$Fecha_Inicio = date("d-m-Y");
if (empty ($Fecha_Fin))
	$Fecha_Fin = date("d-m-Y");
if (empty ($tipoBusqueda)) 
	$tipoBusqueda = "fecha";

?>

<script language="JavaScript" src="../js/ts_picker.js"></script>

<script language="JavaScript">
	 	
 	function borrarNoticia(id_Noticia)
 	{
 		if (confirm("<? echo $Mensajes["err-1"]; ?>")){
 			var loc = location.href;
 			if (loc.indexOf('?') == -1)
 				loc = loc + '?';
 			else
 				loc = loc + '&';
 			location.href=loc+'operacion=borrar&idNoticia='+id_Noticia;
 		}
 	}
 	
</script>

<form method='post' name='dateForm'>
<table width="70%" class="table-form" border="0" align="center" cellpadding="1" cellspacing="1">
	<tr>
       	<td colspan="4" class="table-form-top-blue">
    		<img src="../images/square-w.gif" width="8" height="8" /> 
    		<? echo $Mensajes["tit-1"]; ?>
        </td>
    </tr>
    <tr>
		<th><? echo $Mensajes["campo.tipo_busqueda"]; ?></th>
		<td>
			<input type="radio" name="tipoBusqueda" value="fecha" <?if($tipoBusqueda == "fecha") echo "checked"?> />
			<? echo $Mensajes["tf-1"]; ?>
			<input type="radio" name="tipoBusqueda" value="todos" <?if($tipoBusqueda == "todos") echo "checked"?> />
			<? echo $Mensajes["campo.tipo_busqueda.todas"]; ?>
		</td>
    </tr>
    <tr>
       <th><? echo $Mensajes["tf-2"]; ?></th>
       <td>
       		<input type="text" name="Fecha_Inicio" style='width:90' size="10" value="<?=$Fecha_Inicio?>" readonly/>
       		<a href="javascript:show_calendar('document.dateForm.Fecha_Inicio',document.dateForm.Fecha_Inicio.value);">
			<img border="0" src="../images/ts_picker/calendar.gif" width="16" height="16" /></a>
	   </td>
    </tr>
    <tr>
       <th><? echo $Mensajes["tf-3"]; ?></th>
       <td>
            <input type="text" name="Fecha_Fin" style='width:90' size="10" value="<?=$Fecha_Fin?>" readonly />
            <a href="javascript:show_calendar('document.dateForm.Fecha_Fin',document.dateForm.Fecha_Fin.value);">
		    <img src="../images/ts_picker/calendar.gif" width="16" height="16" border="0" /></a>
	   </td>
    </tr>
    <tr>
       <th><? echo $Mensajes["campo.idioma"]; ?></th>
       <td>
            <select size="1" name="Codigo_Idioma">
	       		<?
				$idiomas = $servicesFacade->getIdiomasDisponibles();
				foreach ($idiomas as $idioma) {?>
					<option value="<?=$idioma["Id"]?>" <? if ($Codigo_Idioma == $idioma["Id"]) echo "selected";?>>
						<?=$idioma["Nombre"]?>
					</option>
				<?}?>
			</select>
       </td>
    </tr>
    <tr>
       <th>&nbsp;</th>
	   <td>
	   		<input type="submit" value="<? echo $Mensajes["bot-1"]; ?>" name="bBuscar" />
	   </td>
    </tr>
</table>
</form>

<hr width="90%"/>
<?
//carga la condiciones de busqueda
$conditions = array ();
 
if($tipoBusqueda == "fecha"){ 
	$conditions["FechaInicio"] = date("Y-m-d", mktime(0, 0, 0, substr($Fecha_Inicio, 3, 2), substr($Fecha_Inicio, 0, 2), substr($Fecha_Inicio, 6,4)));
	$conditions["FechaFin"] = date("Y-m-d", mktime(0, 0, 0, substr($Fecha_Fin, 3, 2), substr($Fecha_Fin, 0, 2), substr($Fecha_Fin, 6,4)));
}
if ($Codigo_Idioma != 0) 
	$conditions["Codigo_Idioma"] = $Codigo_Idioma;


$noticias = $servicesFacade->buscarNoticias($conditions);

$cantidad_pp = 3;
$total_records = count($noticias); //cantidad total de noticias
 $num_paginas = ceil($total_records / $cantidad_pp);
 
if (empty ($pagina_actual))
	$pagina_actual = 1;
elseif ($pagina_actual > $num_paginas)
	$pagina_actual = $num_paginas;


if ($total_records != 0){
	$noticias = array_chunk($noticias, $cantidad_pp);
	$noticias = $noticias[$pagina_actual -1];
}?>
<table width="90%" border="0" cellpadding="1" cellspacing="1" align="center" >
<?foreach ($noticias as $noticia) {?>
    	<tr>
        	<th class="table-form-top" style='text-align:left !important'>
            	<img src="../images/square-w.gif" width="8" height="8" />
            	<?echo $noticia["Titulo"];?>
            	[<?=date("d/m/Y",strtotime($noticia["Fecha"]))?>]
            </th>
        </tr>
        <tr>
           	<td class="style33"><?=$noticia["Texto_Noticia"];?></td>
		</tr>
        <tr>
        	<td class="style33">
        		<b>
				<a href="modificarOAgregarNoticia.php?idNoticia=<?= $noticia["Id"];?>"><? echo $Mensajes["h-3"]; ?></a> | 
                <a href='javascript:borrarNoticia(<?echo $noticia["Id"];?>)'><? echo $Mensajes["h-4"]; ?></a>
                </b>
			</td>
		</tr>
		<tr>
           	<td colspan="2">&nbsp;</td>
		</tr>

<?}?>
</table>
<!-- barra de paginado -->
<center>
<span style="text-align:center" width="100%">
	<?
	
	$decena_actual = intval($pagina_actual / 10);
	if ($decena_actual == 0) {
		//Para el caso de que este el la decena 0
		$decena_actual = 0.1;
	} 
	
	$pagina_desde = $decena_actual * 10; // Calculo de la pagina inicial
	$fin_decena = $pagina_desde + 9;
	
	if ($num_paginas > $fin_decena)
		$pagina_hasta = $fin_decena;
	else
		$pagina_hasta = $num_paginas;
	
	if ($pagina_actual > 1) {?>
		<a class='style33' href='listadoNoticias.php?Fecha_Inicio=<?=$Fecha_Inicio?>&Fecha_Fin=<?=$Fecha_Fin?>&pagina_actual=<?=($pagina_actual -1) ?>'>&lt;&lt;&nbsp;</a>
	<?}
	
	for ($i = $pagina_desde; $i <= $pagina_hasta; $i++) {
		if ($i == $pagina_actual) {
			echo "<strong class='style33'>$i</strong>";
		} else {
			echo "<a class='style33' style='color: #006699;' href='listadoNoticias.php?Fecha_Inicio=$Fecha_Inicio&Fecha_Fin=$Fecha_Fin&pagina_actual=$i'>$i</a>&nbsp;";
		}
		if (($i +1) <= $pagina_hasta)
			echo "&nbsp;|&nbsp;";
	}
	
	if ($pagina_actual < $num_paginas) {
		echo "<a class='style33' style='color: #006699;' href='listadoNoticias.php?Fecha_Inicio=$Fecha_Inicio&Fecha_Fin=$Fecha_Fin&pagina_actual=" . ($pagina_actual + 1) . "'>&gt;&gt;</a>";
	}
	?>
</span>
</center>   

<? require "../layouts/base_layout_admin.php";?>