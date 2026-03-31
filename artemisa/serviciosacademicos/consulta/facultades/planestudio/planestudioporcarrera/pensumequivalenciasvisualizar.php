<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
if(!isset($_POST['busqueda_nombre']))
{
	$_POST['busqueda_nombre'] = "";
}

$query_detalleplanestudio = "select d.codigomateria from detalleplanestudio d where d.idplanestudio = '$idplanestudio'";
$detalleplanestudio = mysql_query($query_detalleplanestudio, $sala) or die("$query_detalleplanestudio");
$totalRows_detalleplanestudio = mysql_num_rows($detalleplanestudio);
$sinmateria = "";
if($totalRows_detalleplanestudio != "")
{
	while($row_detalleplanestudio = mysql_fetch_assoc($detalleplanestudio))
	{
		$quitarcodigomateria = $row_detalleplanestudio['codigomateria'];
		$sinmateria = "$sinmateria and codigomateria <> '$quitarcodigomateria'";
	}
	//echo $sinmateria;
}

// Quita las materias que ya esten en la linea de enfasis
$query_detallelineaenfasis = "select codigomateriadetallelineaenfasisplanestudio
from detallelineaenfasisplanestudio
where idlineaenfasisplanestudio = '$idlineaenfasis'
and idplanestudio = '$idplanestudio'";
$detallelineaenfasis = mysql_query($query_detallelineaenfasis, $sala) or die("$query_detallelineaenfasis");
$totalRows_detallelineaenfasis = mysql_num_rows($detallelineaenfasis);
if($totalRows_detallelineaenfasis != "")
{
	while($row_detallelineaenfasis = mysql_fetch_assoc($detallelineaenfasis))
	{
		$quitarcodigomateria = $row_detallelineaenfasis['codigomateriadetallelineaenfasisplanestudio'];
		$sinmateria = "$sinmateria and codigomateria <> '$quitarcodigomateria'";
	}
	//echo $sinmateria;
}
?>
<html>
<head>
<title>Editar equivalencias</title>
<link rel="stylesheet" href="https://artemisa.unbosque.edu.co/serviciosacademicos/estilos/sala.css" type="text/css">

</head>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Tahoma;
	font-size: x-small;
}
.Estilo2 {
	font-family: sans-serif;
	font-size: 9px;
}
-->
</style>
<body>
<div align="center">
<table width="20%"  border="0" align="center" cellpadding="3" cellspacing="3">
<TR><TD><?php if($estaEnenfasis == "no"){?><img src="../../../../../imagenes/noticias_logo.gif" height="71" ><?php
} else { ?><img src="../../../../../../imagenes/noticias_logo.gif" height="71" ><?php } ?></TD></TR></BR>
<TR><TD align="center"><p align="center"><strong><h3>SELECCION DE EQUIVALENCIAS</h3></strong></TD></TR>
</table>

<input type="hidden" name="tipodereferencia" value="<?php echo $Vartipodereferencia;?>">
<input type="hidden" name="editar" value="<?php echo $limite;?>">
<input type="hidden" name="codigodemateria" value="<?php echo $Varcodigodemateria;?>">
</p>
<table width="780" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr bgcolor="#C5D5D6">
	<td width="50%" align="center"><strong>Nombre Materia</strong></td>
	<td width="50%" align="center"><strong>Codigo Materia</strong></td>
  </tr>
  <tr id="trgris">
	<td align="center" ><?php echo $row_referenciasmateria['nombremateria']; ?></td>
	<td align="center" ><?php echo $Varcodigodemateria; ?></td>
  </tr>
  <tr bgcolor="#C5D5D6">
  	<td align="center"><strong>Nº Plan Estudio</strong></td>
	<td align="center" colspan="2"><strong>Nombre Plan de Estudio</strong></td>
  </tr>
  <tr id="trgris">
	<td align="center"><?php echo $idplanestudio; ?></td>
	<td align="center" colspan="2">	 <?php echo $row_planestudio['nombreplanestudio']; ?>	  </td>
  </tr>
  <tr bgcolor="#C5D5D6">
  	<td align="center"><strong>Fecha Inicio Equivalencias</strong></td>
	<td align="center" colspan="2"><strong>Fecha Vencimiento Equivalencias</strong></td>
  </tr>
  <tr id="trgris">
	<td align="center"><?php echo ereg_replace(" [0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}$","",$fechainicio);?>&nbsp;</td>
	<td align="center" colspan="2"><?php echo ereg_replace(" [0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}$","",$fechavencimiento);?>&nbsp;</td>
  </tr>
</table>
<?php
$vacio = false;
// La consulta es para ingresar los datos al select
// Ojo hay que quitar las materias que ya hallan sido adicionadas al plan de estudios
// es decir las que aparescan en el select de la derecha
?>
<table width="780" border="1" cellpadding="2" cellspacing="1" bordercolor="#FFE6B1">
  <tr>
	<td align="center">
	<select multiple name="equivalencias[]" size="10" class="Estilo2">
<?
if(isset($Arregloequivalencias))
{
	foreach($Arregloequivalencias as $key3 => $selEquivalencias)
	{
		$codigomateria = $selEquivalencias;

		$query_datomateriaequivalente = "select nombremateria
		from materia
		where codigomateria = '$codigomateria'";
		$datomateriaequivalente = mysql_query($query_datomateriaequivalente, $sala) or die("$query_datomateriaequivalente");
		$totalRows_datomateriaequivalente = mysql_num_rows($datomateriaequivalente);
		$row_datomateriaequivalente = mysql_fetch_assoc($datomateriaequivalente);

		$nombremateria = $row_datomateriaequivalente['nombremateria'];
?>
	<option value="<?php echo $codigomateria; ?>"><?php echo "$nombremateria &nbsp;&nbsp; $codigomateria"; ?></option>
<?php
	}
}
else
{
?>
	<option value="0">No tiene materias equivalentes</option>
<?php
}
?>
	</select>
	</td>
  <tr id="trgris">
    <td align="center">
<?php
if(!isset($_GET['visualizado']))
{
?>
	<input type="submit" name="edi" value="Editar Equivalencias">
<?php
}
else
{
	$visual = "&visualizado";
}
if($estaEnenfasis == "no")
{
?>
      <input type="button" name="regresar" value="Regresar" onClick="window.location.href='materiasporsemestre.php?planestudio=<?php echo "$idplanestudio.$visual";?>'">
      <?php
}
else
{
?>
      <input type="button" name="regresar" value="Regresar" onClick="window.location.href='materiaslineadeenfasisporsemestre.php?planestudio=<?php echo "$idplanestudio&lineaenfasis=$idlineaenfasis.$visual";?>'">
      <?php
}
?>	</td>
  </tr>
</table>
</div>
</body>
<script language="javascript">
//Mueve las opciones seleccionadas en listaFuente a listaDestino
function moverOpciones(listaFuente, listaDestino)
{
	var i;
	var d = listaDestino.options.length;
	//Recorre la lista fuente buscando elementos seleccionados
	for (i = 0; i < listaFuente.options.length; i++)
	{
		if(listaFuente.options[i].value != 0)
		{
			if (listaFuente.options[i].selected && listaFuente.options[i].value != "")
			{
				//Mueve el elemento seleccionado de la lista fuente a la lista destino
				var opciont = new Option();
				opciont.value = listaFuente.options[i].value;

				opciont.text  = listaFuente.options[i].text;
				listaDestino[d] = opciont;
				d++;
				listaFuente[i] = null;
				i--;
			}
		}
	}

	//Llamado a la funcion de ordenamiento para cada lista
	//ordenarLista(listaFuente);
	//ordenarLista(listaDestino);
	//listaFuente.sort();
	//sort(listaDestino);
	//document.write("listaDestino" +listaDestino.options.length);
	//Quicksort(listaFuente, 0, listaFuente.options.length);
	//Quicksort(listaDestino, 0, listaDestino.options.length);
}

/*function Quicksort(vec, loBound, hiBound)
{
	var loSwap, hiSwap;
	var temp = new Option();
	var pivot = new Option();

	// Two items to sort
	if (hiBound - loBound == 1)
	{
		if (vec.options[loBound].text > vec.options[hiBound].text)
		{
			temp.value = vec.options[loBound].value;
			temp.text  = vec.options[loBound].text;
			vec.options[loBound].value = vec.options[hiBound].value;
			vec.options[loBound].text = vec.options[hiBound].text;
			vec.options[hiBound].value = temp.value;
			vec.options[hiBound].text = temp.text;
		}
		return;
	}

	// Three or more items to sort
	pivot.value = vec.options[parseInt((loBound + hiBound) / 2)].value;
	pivot.text = vec.options[parseInt((loBound + hiBound) / 2)].text;
	vec.options[parseInt((loBound + hiBound) / 2)].value = vec.options[loBound].value;
	vec.options[parseInt((loBound + hiBound) / 2)].text = vec.options[loBound].text;
	vec.options[loBound].value = pivot.value;
	vec.options[loBound].text = pivot.text;
	loSwap = loBound + 1;
	hiSwap = hiBound;

	do {
		// Find the right loSwap
		while (loSwap <= hiSwap && vec.options[loSwap].text <= pivot.text)
			loSwap++;

		// Find the right hiSwap
		while (vec.options[hiSwap].text > pivot.text)
			hiSwap--;

		// Swap values if loSwap is less than hiSwap
		if (loSwap < hiSwap)
		{
			temp.value = vec.options[loSwap].value;
			temp.text = vec.options[loSwap].text;
			vec.options[loSwap].value = vec.options[hiSwap].value;
			vec.options[loSwap].text = vec.options[hiSwap].text;
			vec.options[hiSwap].value = temp.value;
			vec.options[hiSwap].text = temp.text;
		}
	}
	while (loSwap < hiSwap);

	vec.options[loBound].text = vec.options[hiSwap].text;
	vec.options[loBound].value = vec.options[hiSwap].value;
	vec.options[hiSwap].text = pivot.text;
	vec.options[hiSwap].value = pivot.value;


	// Recursively call function...  the beauty of quicksort

	// 2 or more items in first section
	if (loBound < hiSwap - 1)
		Quicksort(vec, loBound, hiSwap - 1);

	// 2 or more items in second section
	if (hiSwap + 1 < hiBound)
		Quicksort(vec, hiSwap + 1, hiBound);
}

function ordenarLista(lista)
{
	var i;
	var j;
	var opcion1 = new Option();
	for (i = 0; i < lista.options.length; i++)
	{
		for (j = i + 1; j < lista.options.length; j++)
		{
		//alert("ij"+i+" "+j+" - "+lista.options[i].text+"  "+lista.options[j].text);
			if (lista.options[i].text > lista.options[j].text)
			{
				opcion1.value = lista.options[i].value;
				opcion1.text  = lista.options[i].text;
				lista.options[i].value = lista.options[j].value;
				lista.options[i].text  = lista.options[j].text;
				lista.options[j].value = opcion1.value;
				lista.options[j].text  = opcion1.text;
			}
		}
	}
}*/

function activarLista(lista)
{
	for (i = 0; i < lista.options.length; i++)
	{
		lista.options[i].selected = true;
	}
}

function verLista(lista)
{
	var listado = "";
	var longLista = lista.options.length;
	var contador;
	var mensaje = "Lista de opciones (valor,texto)";
	for (contador = 0;contador <longLista;contador++)
	{
		listado = listado + "  (" + lista.options[contador].value + ","
		listado = listado + lista.options[contador].text + ")";
	}
	mensaje = mensaje + "\n" + listado
	alert(mensaje);
}
</script>
</html>
