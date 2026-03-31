<?php
if(!isset($_SESSION['MM_Username'])){
    session_start();
}
is_file(dirname(__FILE__) ."/../../../utilidades/ValidarSesion.php")
    ? include_once(dirname(__FILE__) .'/../../../utilidades/ValidarSesion.php')
    : include_once(realpath(dirname(__FILE__) .'/../../../utilidades/ValidarSesion.php'));
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

if(!isset($_POST['busqueda_nombre']))
{
	$_POST['busqueda_nombre'] = "";
}

$query_detalleplanestudio = "select d.codigomateria from detalleplanestudio d ".
" where d.idplanestudio = '$idplanestudio'";
$detalleplanestudio = $db->GetAll($query_detalleplanestudio);
$totalRows_detalleplanestudio = count($detalleplanestudio);
$sinmateria = "";
if($totalRows_detalleplanestudio != "")
{
	foreach($detalleplanestudio as $row_detalleplanestudio )
	{
		$quitarcodigomateria = $row_detalleplanestudio['codigomateria'];
		$sinmateria = "$sinmateria and codigomateria <> '$quitarcodigomateria'";
	}
}

// Quita las materias que ya esten en la linea de enfasis
$query_detallelineaenfasis = "select codigomateriadetallelineaenfasisplanestudio
from detallelineaenfasisplanestudio
where idlineaenfasisplanestudio = '$idlineaenfasis'
and idplanestudio = '$idplanestudio'";
$detallelineaenfasis = $db->GetAll($query_detallelineaenfasis);
$totalRows_detallelineaenfasis = count($detallelineaenfasis);
if($totalRows_detallelineaenfasis != "")
{
	foreach($detallelineaenfasis as $row_detallelineaenfasis)
	{
		$quitarcodigomateria = $row_detallelineaenfasis['codigomateriadetallelineaenfasisplanestudio'];
		$sinmateria = "$sinmateria and codigomateria <> '$quitarcodigomateria'";
	}

}
?>
<html>
<head>
<title>Editar equivalencias</title>
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
<h2>SELECCION DE EQUIVALENCIAS</h2>
<input type="hidden" name="tipodereferencia" value="<?php echo $Vartipodereferencia;?>">
<input type="hidden" name="editar" value="<?php echo $limite;?>">
<input type="hidden" name="codigodemateria" value="<?php echo $Varcodigodemateria;?>">
</p>
<table width="780" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr bgcolor="#C5D5D6">
	<td width="50%" align="center" class="Estilo1"><strong>Nombre Materia</strong></td>
	<td width="50%" align="center" class="Estilo1"><strong>Codigo Materia</strong></td>
  </tr>
  <tr>
	<td align="center" class="Estilo1"><?php echo $row_referenciasmateria['nombremateria']; ?></td>
	<td align="center" class="Estilo1"><?php echo $Varcodigodemateria; ?></td>
  </tr>
  <tr bgcolor="#C5D5D6">
  	<td align="center"><strong>Nº Plan Estudio</strong></td>
	<td align="center" colspan="2"><strong>Nombre Plan de Estudio</strong></td>
  </tr>
  <tr>
	<td align="center"><?php echo $idplanestudio; ?></td>
	<td align="center" colspan="2">	 <?php echo $row_planestudio['nombreplanestudio']; ?>	  </td>
  </tr>
  <tr bgcolor="#C5D5D6">
  	<td align="center"><strong>Fecha Inicio Equivalencias</strong></td>
	<td align="center" colspan="2"><strong>Fecha Vencimiento Equivalencias</strong></td>
  </tr>
  <tr>
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
<table width="780" border="1" cellpadding="2" cellspacing="1" bordercolor="#D76B00">
  <tr>
	<td align="center">
	<select multiple name="equivalencias[]" size="10" class="Estilo2">
<?php
if(isset($Arregloequivalencias))
{
	foreach($Arregloequivalencias as $key3 => $selEquivalencias)
	{
		$codigomateria = $selEquivalencias;

		$query_datomateriaequivalente = "select nombremateria
		from materia
		where codigomateria = '$codigomateria'";
		$datomateriaequivalente = $db->GetRow($query_datomateriaequivalente);
		$totalRows_datomateriaequivalente = count($datomateriaequivalente);
		$row_datomateriaequivalente = $datomateriaequivalente;

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
  <tr>
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

}


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
