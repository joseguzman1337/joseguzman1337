<?php
    session_start();
//    include_once('../../../utilidades/ValidarSesion.php');
//    $ValidarSesion = new ValidarSesion();
//    $ValidarSesion->Validar($_SESSION);
include (realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));

require_once('seguridadplandeestudio.php');
if(isset($_GET['planestudio']))
{
	$idplanestudio = $_GET['planestudio'];
}
//if(isset($_POST['regresar']))
//{
//		echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=plandeestudioinicial.php'>";
//}
$query_planestudio = "select p.idplanestudio, p.nombreplanestudio, p.fechacreacionplanestudio,
p.responsableplanestudio, p.cargoresponsableplanestudio, p.cantidadsemestresplanestudio,
c.nombrecarrera, p.numeroautorizacionplanestudio, t.nombretipocantidadelectivalibre,
p.cantidadelectivalibre, p.fechainioplanestudio, p.fechavencimientoplanestudio
from planestudio p, carrera c, tipocantidadelectivalibre t
where p.codigocarrera = c.codigocarrera
and p.codigotipocantidadelectivalibre = t.codigotipocantidadelectivalibre
and p.idplanestudio = '$idplanestudio'";
$planEstudio = $db->GetRow($query_planestudio);
$row_planestudio = $planEstudio;
$totalRows_planestudio = count($planEstudio);

if(!isset($_POST['busqueda_nombre']))
{
	$_POST['busqueda_nombre'] = "";
}

if(isset($_POST['filtrarbusqueda']) || isset($_GET['filtrarbusqueda']))
{
    // Guardar en la tabla detalleplanestudio, primero elimina lo que halla en la tabla
    if(isset($_POST['listados']))
    {
        $listadetalleplanestudio = $_POST['listados'];

        // Mira las materias que se encuentran en plan estudio y si no se encuentran en la listados las elimina
        $query_materiasplanestudio = "select d.codigomateria, m.nombremateria
		from detalleplanestudio d, materia m
		where d.idplanestudio = '$idplanestudio'
		and d.codigomateria = m.codigomateria";
        $materiasplanestudio = $db->GetAll($query_materiasplanestudio);
        $totalRows_materiasplanestudio = count($materiasplanestudio);
        if($totalRows_materiasplanestudio != "")
        {
            foreach($materiasplanestudio as $row_materiasplanestudio )
            {
                $codigomateria = $row_materiasplanestudio['codigomateria'];
                $entro = false;
                foreach($listadetalleplanestudio as $key1 => $codigo1)
                {
                    if($codigomateria == $codigo1)
                    {
                        $entro = true;
                    }
                }
                if(!$entro)
                {
                    $query_eliminarreferenciaplanestudio = "DELETE FROM referenciaplanestudio WHERE (codigomateria = $codigomateria or codigomateriareferenciaplanestudio = $codigomateria) and idplanestudio = $idplanestudio and idlineaenfasisplanestudio = 1";
                    $eliminarreferenciaplanestudio = $db->Execute($query_eliminarreferenciaplanestudio);

                    $query_eliminardetalleplanestudio = "DELETE FROM detalleplanestudio WHERE codigomateria = '$codigomateria' and idplanestudio = '$idplanestudio'";
                    $eliminardetalleplanestudio = $db->Execute($query_eliminardetalleplanestudio);

                }
            }
        }
        // Mira si las materia que vienen de la listados es diferente
        // En caso que sea asi la inserta en detalleplanestudio
        $cuentalistadodos = 0;
        foreach($listadetalleplanestudio as $key => $codigomateriaplan)
        {
            $cuentalistadodos++;
            $query_materiadetalleplanestudio = "select d.codigomateria
			from detalleplanestudio d
			where d.idplanestudio = '$idplanestudio'
			and d.codigomateria = '$codigomateriaplan'";
            $materiadetalleplanestudio = $db->GetRow($query_materiadetalleplanestudio);
            $totalRows_materiadetalleplanestudio = count($materiadetalleplanestudio);
            if($totalRows_materiadetalleplanestudio == "")
            {
                // Este if se hiso debido a que listados para que exista posee un vacio
                if($codigomateriaplan != 0)
                {
                    $query_numerocreditosmateriadetallepe = "select numerocreditos, codigotipomateria, numerohorassemanales
					from materia
					where codigomateria = '$codigomateriaplan'";
                    $numerocreditosmateriadetallepe = $db->GetRow($query_numerocreditosmateriadetallepe);
                    $totalRows_numerocreditosmateriadetallepe = count($numerocreditosmateriadetallepe);
                    $row_numerocreditosmateriadetallepe = $numerocreditosmateriadetallepe;

                    if($row_numerocreditosmateriadetallepe['codigotipomateria'] == 4)
                    {
                        $query_detallegrupo = "SELECT d.codigomateria FROM detallegrupomateria d
						WHERE d.codigomateria = '$codigomateriaplan'";
                        $detallegrupo = $db->GetRow($query_detallegrupo);
                        $totalRows_detallegrupo = count($detallegrupo);

                        if($totalRows_detallegrupo == "")
                        {
                            $query_insertardetalleplanestudio = "INSERT INTO detalleplanestudio(
							idplanestudio, codigomateria, semestredetalleplanestudio, valormateriadetalleplanestudio, numerocreditosdetalleplanestudio, codigoformacionacademica, codigoareaacademica, fechacreaciondetalleplanestudio, fechainiciodetalleplanestudio, fechavencimientodetalleplanestudio, codigoestadodetalleplanestudio, codigotipomateria)
							VALUES('$idplanestudio', '$codigomateriaplan', '0', '0', '".$row_numerocreditosmateriadetallepe['numerocreditos']."', '100', '100','".date("Y-m-d")."', '".date("Y-m-d")."', '2999-12-31', '101', '4')";
                        }
                        else
                        {
                            $query_insertardetalleplanestudio = "INSERT INTO detalleplanestudio(
							idplanestudio, codigomateria, semestredetalleplanestudio, valormateriadetalleplanestudio, numerocreditosdetalleplanestudio, codigoformacionacademica, codigoareaacademica, fechacreaciondetalleplanestudio, fechainiciodetalleplanestudio, fechavencimientodetalleplanestudio, codigoestadodetalleplanestudio, codigotipomateria)
							VALUES('$idplanestudio', '$codigomateriaplan', '0', '0', '".$row_numerocreditosmateriadetallepe['numerocreditos']."', '100', '100', '".date("Y-m-d")."', '".date("Y-m-d")."', '2999-12-31', '101', '1')";
                        }
                    }
                    else
                    {
                        $query_insertardetalleplanestudio = "INSERT INTO detalleplanestudio(
						idplanestudio, codigomateria, semestredetalleplanestudio, valormateriadetalleplanestudio, numerocreditosdetalleplanestudio, codigoformacionacademica, codigoareaacademica, fechacreaciondetalleplanestudio, fechainiciodetalleplanestudio, fechavencimientodetalleplanestudio, codigoestadodetalleplanestudio, codigotipomateria)
						VALUES('$idplanestudio', '$codigomateriaplan', '0', '0', '".$row_numerocreditosmateriadetallepe['numerocreditos']."', '100', '100', '".date("Y-m-d")."', '".date("Y-m-d")."', '2999-12-31', '101', '1')";
                    }
                    $insertardetalleplanestudio = $db->Execute($query_insertardetalleplanestudio);
                }
            }
        }
        if($_POST['filtrarbusqueda'] == "Continuar")
        {
            if($cuentalistadodos == 1)
            {
                ?>
                <script language="javascript">
                    alert("Debe seleccionar al menos una materia");
                    history.go(-1);
                </script>
                <?php
            }
        }
    }
    if($_POST['filtrarbusqueda'] == "Continuar")
    {
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=editarmateriasseleccionadas.php?planestudio=".$idplanestudio."'>";
    }
}
$query_detalleplanestudio = "select d.codigomateria
from detalleplanestudio d
where d.idplanestudio = '$idplanestudio'";
$detalleplanestudio = $db->GetRow($query_detalleplanestudio);
$totalRows_detalleplanestudio = count($detalleplanestudio);
$sinmateria = "";
if($totalRows_detalleplanestudio != "")
{
	foreach($detalleplanestudio as $row_detalleplanestudio)
	{
		$quitarcodigomateria = $row_detalleplanestudio['codigomateria'];
		$sinmateria = "$sinmateria and codigomateria <> '$quitarcodigomateria'";
	}

}

// Quita las materias que ya esten en la linea de enfasis
$query_detallelineaenfasis = "select codigomateriadetallelineaenfasisplanestudio
from detallelineaenfasisplanestudio
where idplanestudio = '$idplanestudio'";
//echo "<br>$query_detallelineaenfasis";
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
<title>Visualizar plan de estudio</title>
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

<script language="javascript">
function cambia_tipo()
{
    //tomo el valor del select del tipo elegido
    var tipo
    tipo = document.f1.tipo[document.f1.tipo.selectedIndex].value
    //miro a ver si el tipo está definido
    if (tipo == 1)
	{
		window.location.href="visualizarplandeestudio.php?busqueda=nombre&filtrarbusqueda&planestudio=<?php echo $idplanestudio?>";
	}
    if (tipo == 2)
	{
		window.location.href="visualizarplandeestudio.php?busqueda=codigo&filtrarbusqueda&planestudio=<?php echo $idplanestudio?>";
	}
}

function buscar()
{
    //tomo el valor del select del tipo elegido
    var busca
    busca = document.f1.busqueda[document.f1.busqueda.selectedIndex].value
    //miro a ver si el tipo está definido
    if (busca != 0)
	{
		window.location.href="visualizarplandeestudio.php?planestudio='.$idplanestudio.'&buscar="+busca;
	}
}
</script>
<body>
<div align="center">
<form name="f1" method="post" action="visualizarplandeestudio.php?planestudio=<?php echo $idplanestudio;?>">
<p class="Estilo1" align="center"><strong>PLAN DE ESTUDIO</strong></p>
<table width="780" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
  	<td align="center" bgcolor="#C5D5D6"><strong>Nº Plan Estudio</strong></td>
	<td align="center" bgcolor="#C5D5D6"><strong>Nombre</strong></td>
	<td align="center" bgcolor="#C5D5D6"><strong>Fecha</strong></td>
  </tr>
  <tr>
	<td align="center"><?php echo $idplanestudio; ?></td>
	<td align="center">	 <?php echo $row_planestudio['nombreplanestudio']; ?>	  </td>
	<td align="center"><?php echo preg_replace("/[0-9]+:[0-9]+:[0-9]+/","",$row_planestudio['fechacreacionplanestudio']); ?></td>
  </tr>
  <tr>
  	<td align="center" colspan="2" bgcolor="#C5D5D6"><strong>Nombre Encargado</strong></td>
  	<td align="center" bgcolor="#C5D5D6"><strong>Cargo</strong></td>
  </tr>
  <tr>
	<td align="center" colspan="2"><?php echo $row_planestudio['responsableplanestudio']; ?>
	  </td>
	<td align="center"><?php echo $row_planestudio['cargoresponsableplanestudio']; ?>
	  </td>
  </tr>
  <tr>
  	<td align="center" bgcolor="#C5D5D6"><strong>Nº Semestres</strong></td>
  	<td align="center" bgcolor="#C5D5D6"><strong>Carrera</strong></td>
	<td align="center" bgcolor="#C5D5D6"><strong>Autorización Nº</strong></td>
  </tr>
  <tr>
  	<td align="center"><?php echo $row_planestudio['cantidadsemestresplanestudio']; ?></td>
	<td align="center"><?php echo $row_planestudio['nombrecarrera']; ?></td>
	<td align="center"><?php echo $row_planestudio['numeroautorizacionplanestudio']; ?></td>
  </tr>
 <tr>
  	<!-- <td align="center"><strong>Tipo de Electivas</strong></td>
	<td align="center"><strong>Cantidad</strong></td> -->
	<td align="center" bgcolor="#C5D5D6"><strong>Fecha de Inicio</strong></td>
	<td align="center" bgcolor="#C5D5D6"><strong>Fecha de Vencimiento</strong></td>
	<td rowspan="2">&nbsp;</td>
  </tr>
  <tr>
  	<!-- <td align="center"><?php echo $row_planestudio['nombretipocantidadelectivalibre']; ?></td>
	<td align="center"><?php echo $row_planestudio['cantidadelectivalibre']; ?></td> -->
	<td align="center"><?php echo preg_replace("/[0-9]+:[0-9]+:[0-9]+/","",$row_planestudio['fechainioplanestudio']); ?></td>
	<td align="center"><?php echo preg_replace("/[0-9]+:[0-9]+:[0-9]+/","",$row_planestudio['fechavencimientoplanestudio']); ?></td>
  </tr>
  <tr>
  	<td colspan="3" align="center"><input type="button" name="cambiarcabecera" value="Modificar Información del Plan de Estudios" onClick="window.location.href='cambiarcabeceraplandeestudio.php?planestudio=<?php echo "$idplanestudio";?>'"></td>
  </tr>
</table>
<?php
$vacio = false;
// La consulta es para ingresar los datos al select
// Ojo hay que quitar las materias que ya hallan sido adicionadas al plan de estudios
// es decir las que aparescan en el select de la derecha
if((!isset($_POST['filtrarbusqueda']) || isset($_POST['buscar'])) && !isset($_GET['busqueda']))
{
	if(isset($_POST['busqueda_nombre']))
	{
?>
<input type="hidden" name="busqueda_nombre" value="<?php $_POST['busqueda_nombre']; ?>">
<?php
		$nombre = $_POST['busqueda_nombre'];
		$query_solicitud = "select m.codigomateria, m.nombremateria, m.numerocreditos
		from materia m
		where m.nombremateria like '$nombre%'
		and m.codigoestadomateria = '01'
		$sinmateria
		order by 2";
		$solicitud = $db->GetAll($query_solicitud);
	}
	if(isset($_POST['busqueda_codigo']))
	{
?>
<input type="hidden" name="busqueda_codigo" value="<?php $_POST['busqueda_codigo']; ?>">
<?php
		$codigo = $_POST['busqueda_codigo'];
		$query_solicitud = "select m.codigomateria, m.nombremateria, m.numerocreditos
		from materia m
		where m.codigomateria like '$codigo%'
		and m.codigoestadomateria = '01'
		$sinmateria
		order by 2";
		$solicitud = $db->GetAll($query_solicitud);

	}
	if(!$vacio)
	{
?>
<table width="780" border="1" cellpadding='2' cellspacing='1' bordercolor='#D76B00'>
  <tr>
  <td align="center"><strong>Todas las materias</strong></td>
  <td></td>
  <td align="center"><strong>Materias Seleccionadas</strong></td>
  </tr>
  <tr>
	<td width="364">
    <select  multiple name="listauno[]" size="10" style="width:362px" class="Estilo2">
<?php
		$totalRows_solicitud = count($solicitud);
		if($totalRows_solicitud != "")
		{
			foreach($solicitud as $row_solicitud)
			{
				$nombremateria = $row_solicitud['nombremateria'];
				$codigomateria = $row_solicitud['codigomateria'];
?>
			<option value="<?php echo $codigomateria; ?>"><?php echo "$nombremateria &nbsp;&nbsp; $codigomateria"; ?></option>

<?php
			}
		}
		else
		{
?>
		<option value="0"><strong>No hay materias</strong></option>
<?php
		}
?>
      </select>
</td>
    <td width="42" align="center">
	<input type="button" name="derecha"
	onClick="moverOpciones(this.form.elements['listauno[]'],this.form.elements['listados[]'])" value=">>">
	<br>
	<input type="button" name="izquierda"
   	onClick="moverOpciones(this.form.elements['listados[]'],this.form.elements['listauno[]'])" value="<<">
  	</td>
	<td width="364">
	<select multiple name="listados[]" size="10" style="width:362px" class="Estilo2">
<?php
		$query_materiasplanestudio = "select d.codigomateria, m.nombremateria
		from detalleplanestudio d, materia m
		where d.idplanestudio = '$idplanestudio'
		and d.codigomateria = m.codigomateria
		order by 2";
		$materiasplanestudio = $db->GetAll($query_materiasplanestudio);
		$totalRows_materiasplanestudio = count($materiasplanestudio);
		if($totalRows_materiasplanestudio != "")
		{
			foreach($materiasplanestudio as $row_materiasplanestudio)
			{
				$nombremateria = $row_materiasplanestudio['nombremateria'];
				$codigomateria = $row_materiasplanestudio['codigomateria'];
?>
	<option value="<?php echo $codigomateria; ?>"><?php echo "$nombremateria &nbsp;&nbsp; $codigomateria"; ?></option>
<?php
			}
		}
?>
	<option value="0"></option>
<?php
?>
	</select>
	</td>
  <tr>
    <td colspan="3" align="center">
	<input type="submit" name="filtrarbusqueda" value="Continuar" style="width:80px" onClick="activarLista(this.form.elements['listados[]'])">
	<input type="submit" name="regresar" value="Regresar" style="width:80px">
	</td>
  </tr>
<tr>
    <td colspan="3" align="center">
	<input type="submit" name="filtrarbusqueda" value="Filtrar Búsqueda" onClick="activarLista(this.form.elements['listados[]'])">
	</td>
  </tr>
</table>
<?php
	}
}
if(isset($_POST['filtrarbusqueda']) || isset($_GET['filtrarbusqueda']))
{
?>
  <p class="Estilo1"><strong>CRITERIO DE B&Uacute;SQUEDA DE MATERIAS</strong></p>
<table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
<tr>
    <td width="250" class="Estilo1">
	<strong>Búsqueda por:</strong>	<select name="tipo" onChange="cambia_tipo()">
		<option value="0">Seleccionar</option>
		<option value="1">Nombre</option>
		<option value="2">Código</option>
	</select>
	&nbsp;
	</td>
<?php
	if(isset($_GET['busqueda']))
	{
?>
	<td class="Estilo1">&nbsp;
<?php
		if($_GET['busqueda']=="nombre")
		{
			echo "Digite un Nombre : <input name='busqueda_nombre' type='text' value=''>";
		}
		if($_GET['busqueda']=="codigo")
		{
			echo "Digite un Código : <input name='busqueda_codigo' type='text' value=''>";
		}
?>
	</td>
    <td class="Estilo1"><strong>Fecha: </strong></td>
    <td class="Estilo1"><?php echo $fechahoy=date("Y-m-d");?>&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="4" align="center" class="Estilo1"><input name="buscar" type="submit" value="Buscar">&nbsp;</td>
  </tr>
<?php
	}
?>
<tr>
  	<td colspan="4" align="center" class="Estilo1"><input name="cancelar" type="button" value="Cancelar" onClick="cancelarfiltro()">&nbsp;</td>
</tr>
</table>
<?php
}
?>
</form>
</div>
</body>
<script language="javascript">
	function cancelarfiltro()
	{
		window.location.href="visualizarplandeestudio.php?planestudio='.$idplanestudio.'";
	}
	</script>
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
		listado = listado + "  (" + lista.options[contador].value + ",";
		listado = listado + lista.options[contador].text + ")";
	}
	mensaje = mensaje + "\n" + listado;
	alert(mensaje);
}
</script>
</html>
