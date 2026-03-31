<?php
/**
 * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Ajuste de etiqueta php y limpieza de codigo.
 * @since Mayo 21, 2019
 */
session_start();
include_once('../../../../utilidades/ValidarSesion.php');
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

require_once('../../../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);
session_start();
require_once('../seguridadplandeestudio.php');
if (isset($_GET['planestudio'])) {
    $idplanestudio = $_GET['planestudio'];
    $idlineaenfasis = $_GET['lineaenfasis'];
    $codigomateriapapa = $_GET['materiapapa'];
}
$query_lineaenfasis = "select idlineaenfasisplanestudio, idplanestudio, nombrelineaenfasisplanestudio, fechacreacionlineaenfasisplanestudio,
fechainiciolineaenfasisplanestudio, fechavencimientolineaenfasisplanestudio, responsablelineaenfasisplanestudio
from lineaenfasisplanestudio
where idlineaenfasisplanestudio = '$idlineaenfasis'
and idplanestudio = '$idplanestudio'";
$lineaEnfasis = mysql_query($query_lineaenfasis, $sala) or die("$query_planestudio");
$row_lineaenfasis = mysql_fetch_assoc($lineaEnfasis);
$totalRows_lineaenfasis = mysql_num_rows($lineaEnfasis);

// Seleccion de los datos de la materia papa
$query_materiabase = "select d.codigomateria, d.semestredetalleplanestudio, m.nombremateria
from detalleplanestudio d, materia m
where d.idplanestudio = '$idplanestudio'
and d.codigotipomateria = '5'
and d.codigomateria = m.codigomateria
and m.codigomateria = '$codigomateriapapa'
order by 2 ";
$materiabase = mysql_query($query_materiabase, $sala) or die("$query_materiabase");
$totalRows_materiabase = mysql_num_rows($materiabase);
$row_materiabase = mysql_fetch_assoc($materiabase);

//Codigo para arreglar ya
/* * ***************************************************************************************** */
if (!isset($_POST['busqueda_nombre'])) {
    $_POST['busqueda_nombre'] = "";
}

if (isset($_POST['regresar'])) {
    echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=visualizarlineadeenfasis.php?planestudio=" . $idplanestudio . "&lineaenfasis=" . $idlineaenfasis . "'>";
}

if (isset($_POST['filtrarbusqueda']) || isset($_GET['filtrarbusqueda'])) {
    // Guardar en la tabla detalleplanestudio, primero elimina lo que halla en la tabla
    if (isset($_POST['listados'])) {
        $listadetallelineaenfasis = $_POST['listados'];

        // Mira las materias que se encuentran en linea enfasis y si no se encuentran en la listados las elimina
        $query_materiaslineaenfasis = "select d.codigomateriadetallelineaenfasisplanestudio, m.nombremateria
		from detallelineaenfasisplanestudio d, materia m
		where d.codigomateriadetallelineaenfasisplanestudio = m.codigomateria
		and d.idlineaenfasisplanestudio = '$idlineaenfasis'
		and d.idplanestudio = '$idplanestudio'
		and d.codigomateria = '$codigomateriapapa'";
        $materiaslineaenfasis = mysql_query($query_materiaslineaenfasis, $sala) or die("$query_materiaslineaenfasis");
        $totalRows_materiaslineaenfasis = mysql_num_rows($materiaslineaenfasis);
        if ($totalRows_materiaslineaenfasis != "") {
            while ($row_materiaslineaenfasis = mysql_fetch_assoc($materiaslineaenfasis)) {
                $codigomaterialineaenfais = $row_materiaslineaenfasis['codigomateriadetallelineaenfasisplanestudio'];
                $entro = false;
                foreach ($listadetallelineaenfasis as $key1 => $codigo1) {
                    if ($codigomaterialineaenfais == $codigo1) {
                        $entro = true;
                    }
                }
                if (!$entro) {
                    $query_eliminardetallelineaenfasis = "DELETE FROM detallelineaenfasisplanestudio
					WHERE idlineaenfasisplanestudio = '$idlineaenfasis'
					and idplanestudio = '$idplanestudio'
					and codigomateria = '$codigomateriapapa'
					and codigomateriadetallelineaenfasisplanestudio = '$codigomaterialineaenfais'";
                    $eliminardetallelineaenfasis = mysql_query($query_eliminardetallelineaenfasis, $sala) or die("$query_eliminardetallelineaenfasis");
                }
            }
        }

        // Mira si las materia que vienen de la listados es diferente
        // En caso que sea asi la inserta en detalleplanestudio
        $cuentalistadodos = 0;
        foreach ($listadetallelineaenfasis as $key => $codigomaterialinea) {
            $cuentalistadodos++;
            $query_materiadetallelineaenfasis = "select codigomateriadetallelineaenfasisplanestudio
			from detallelineaenfasisplanestudio
			where idlineaenfasisplanestudio = '$idlineaenfasis'
			and idplanestudio = '$idplanestudio'
			and codigomateria = '$codigomateriapapa'
			and codigomateriadetallelineaenfasisplanestudio = '$codigomaterialinea'";
            $materiadetallelineaenfasis = mysql_query($query_materiadetallelineaenfasis, $sala) or die("$query_materiadetalleplanestudio");
            $totalRows_materiadetallelineaenfasis = mysql_num_rows($materiadetallelineaenfasis);
            if ($totalRows_materiadetallelineaenfasis == "") {
                if ($codigomaterialinea != 0) {
                    $query_numerocreditosmateriadetallele = "select numerocreditos
					from materia
					where codigomateria = '$codigomaterialinea'";
                    $numerocreditosmateriadetallele = mysql_query($query_numerocreditosmateriadetallele, $sala) or die("$query_numerocreditosmateriadetallele");
                    $totalRows_numerocreditosmateriadetallele = mysql_num_rows($numerocreditosmateriadetallele);
                    $row_numerocreditosmateriadetallele = mysql_fetch_assoc($numerocreditosmateriadetallele);

                    $query_insertardetallelineaenfasis = "INSERT INTO detallelineaenfasisplanestudio(idlineaenfasisplanestudio, idplanestudio, codigomateria, codigomateriadetallelineaenfasisplanestudio, codigotipomateria, valormateriadetallelineaenfasisplanestudio, semestredetallelineaenfasisplanestudio, numerocreditosdetallelineaenfasisplanestudio, fechacreaciondetallelineaenfasisplanestudio, fechainiciodetallelineaenfasisplanestudio, fechavencimientodetallelineaenfasisplanestudio, codigoestadodetallelineaenfasisplanestudio)
    				VALUES('$idlineaenfasis', '$idplanestudio', '$codigomateriapapa', '$codigomaterialinea', '5', '0', '" . $row_materiabase['semestredetalleplanestudio'] . "', " . $row_numerocreditosmateriadetallele['numerocreditos'] . ", '" . date("Y-m-d") . "', '" . date("Y-m-d") . "', '2999-12-31', '101')";
                    $insertardetallelineaenfasis = mysql_query($query_insertardetallelineaenfasis, $sala) or die("$query_insertardetallelineaenfasis");
                }
            }
        }
        if ($_POST['filtrarbusqueda'] == "Continuar") {
            if ($cuentalistadodos == 1) {
                ?>
                <script language="javascript">
                    alert("Debe seleccionar al menos una materia");
                    history.go(-1);
                </script>
                <?php
            }
        }
    }
    if ($_POST['filtrarbusqueda'] == "Continuar") {
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=editarmateriaslineadeenfasisseleccionadas.php?planestudio=" . $idplanestudio . "&lineaenfasis=" . $idlineaenfasis . "&materiapapa=" . $codigomateriapapa . "'>";
    }
}
// Quita las materias que ya se encuentran en el plan de estudio
$query_detalleplanestudio = "select d.codigomateria
from detalleplanestudio d
where d.idplanestudio = '$idplanestudio'";
$detalleplanestudio = mysql_query($query_detalleplanestudio, $sala) or die("$query_detalleplanestudio");
$totalRows_detalleplanestudio = mysql_num_rows($detalleplanestudio);
$sinmateria = "";
if ($totalRows_detalleplanestudio != "") {
    while ($row_detalleplanestudio = mysql_fetch_assoc($detalleplanestudio)) {
        $quitarcodigomateria = $row_detalleplanestudio['codigomateria'];
        $sinmateria = "$sinmateria and codigomateria <> '$quitarcodigomateria'";
    }
}

// Quita las materias que ya esten en la linea de enfasis
$query_detallelineaenfasis = "select codigomateriadetallelineaenfasisplanestudio
from detallelineaenfasisplanestudio
where idlineaenfasisplanestudio = '$idlineaenfasis'
and idplanestudio = '$idplanestudio'";
$detallelineaenfasis = mysql_query($query_detallelineaenfasis, $sala) or die("$query_detallelineaenfasis");
$totalRows_detallelineaenfasis = mysql_num_rows($detallelineaenfasis);
if ($totalRows_detallelineaenfasis != "") {
    while ($row_detallelineaenfasis = mysql_fetch_assoc($detallelineaenfasis)) {
        $quitarcodigomateria = $row_detallelineaenfasis['codigomateriadetallelineaenfasisplanestudio'];
        $sinmateria = "$sinmateria and codigomateria <> '$quitarcodigomateria'";
    }
}
/* * ********************************************************************** */
?>
<html>
    <head>
        <title>Visualizar hijos línea de énfasis</title>
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
    <?php
    echo '<script language="javascript">
function cambia_tipo()
{
    //tomo el valor del select del tipo elegido
    var tipo
    tipo = document.f1.tipo[document.f1.tipo.selectedIndex].value
    //miro a ver si el tipo está definido
    if (tipo == 1)
	{
		window.location.href="visualizarhijoslineadeenfasis.php?busqueda=nombre&filtrarbusqueda&planestudio=' . $idplanestudio . '&lineaenfasis=' . $idlineaenfasis . '&materiapapa=' . $codigomateriapapa . '";
	}
    if (tipo == 2)
	{
		window.location.href="visualizarhijoslineadeenfasis.php?busqueda=codigo&filtrarbusqueda&planestudio=' . $idplanestudio . '&lineaenfasis=' . $idlineaenfasis . '&materiapapa=' . $codigomateriapapa . '";
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
		window.location.href="visualizarhijoslineadeenfasis.php?planestudio=' . $idplanestudio . '&lineaenfasis=' . $idlineaenfasis . '&materiapapa=' . $codigomateriapapa . '&buscar="+busca;
	}
}';
    ?>
</script>
<body>
    <div align="center">
        <form name="f1" method="post" action="visualizarhijoslineadeenfasis.php?planestudio=<?php echo "$idplanestudio&lineaenfasis=$idlineaenfasis&materiapapa=$codigomateriapapa"; ?>">
            <p class="Estilo1" align="center"><strong>LINEA DE ENFASIS</strong></p>
            <table width="400" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
                <tr bgcolor="#C5D5D6">
                    <td align="center"><strong>Nº Plan Estudio</strong></td>
                    <td align="center"><strong>Nº Línea de Enfasis</strong></td>
                    <td align="center"><strong>Fecha</strong></td>
                </tr>
                <tr>
                    <td align="center"><?php echo $idplanestudio; ?></td>
                    <td align="center"><?php echo $idlineaenfasis; ?></td>
                    <td align="center"><?php echo ereg_replace("[0-9]+:[0-9]+:[0-9]+", "", $row_lineaenfasis['fechacreacionlineaenfasisplanestudio']); ?></td>
                </tr>
                <tr bgcolor="#C5D5D6">
                    <td align="center"><strong>Nombre De la Línea</strong></td>
                    <td align="center" colspan="2"><strong>Responsable</strong></td>
                </tr>
                <tr>
                    <td align="center"><?php echo $row_lineaenfasis['nombrelineaenfasisplanestudio']; ?></td>
                    <td align="center" colspan="2"><?php echo $row_lineaenfasis['responsablelineaenfasisplanestudio']; ?></td>
                </tr>
                <tr bgcolor="#C5D5D6">
                    <td align="center"><strong>Fecha de Inicio</strong></td>
                    <td align="center" colspan="2"><strong>Fecha de Vencimiento</strong></td>
                </tr>
                <tr>
                    <td align="center"><?php echo ereg_replace("[0-9]+:[0-9]+:[0-9]+", "", $row_lineaenfasis['fechainiciolineaenfasisplanestudio']); ?>
                    </td>
                    <td align="center" colspan="2"><?php echo ereg_replace("[0-9]+:[0-9]+:[0-9]+", "", $row_lineaenfasis['fechavencimientolineaenfasisplanestudio']); ?>
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="3"><br></td>
                </tr>
                <tr bgcolor="#C5D5D6">
                    <td align="center" colspan="3"><p><strong>Datos de la Materia</strong></p>
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="3">
                        <table border="1" width="398" cellspacing='1' bordercolor='#D76B00'>
                            <tr bgcolor="#C5D5D6">
                                <td width="20%" align="center" class="Estilo1"><strong>Codigo</strong></td>
                                <td width="60%"  align="center" class="Estilo1" colspan="2"><strong>Nombre</strong></td>
                                <td align="center" class="Estilo1"><strong>Semestre</strong></td>
                            </tr>
                            <tr>
                                <td align="center" class="Estilo1"><?php echo $row_materiabase['codigomateria']; ?></td>
                                <td align="center" class="Estilo1" colspan="2"><?php echo $row_materiabase['nombremateria']; ?></td>
                                <td align="center" class="Estilo1" colspan="2"><?php echo $row_materiabase['semestredetalleplanestudio']; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="3">&nbsp; </td>
                </tr>
            </table>

            <?php
            $vacio = false;
            // La consulta es para ingresar los datos al select
            // Ojo hay que quitar las materias que ya hallan sido adicionadas al plan de estudios
            // es decir las que aparezcan en el select de la derecha
            if ((!isset($_POST['filtrarbusqueda']) || isset($_POST['buscar'])) && !isset($_GET['busqueda'])) {
                if (isset($_POST['busqueda_nombre'])) {
                    ?>
                    <input type="hidden" name="busqueda_nombre" value="<?php $_POST['busqueda_nombre']; ?>">
                    <?php
                    $nombre = $_POST['busqueda_nombre'];
                    $query_solicitud = "select m.codigomateria, m.nombremateria, m.numerocreditos, c.nombrecarrera
		from materia m, carrera c
		where m.codigocarrera = c.codigocarrera
		and m.nombremateria like '$nombre%'
		and m.codigoestadomateria = '01'
		$sinmateria
		order by 2";
                    $solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
                }
                if (isset($_POST['busqueda_codigo'])) {
                    ?>
                    <input type="hidden" name="busqueda_codigo" value="<?php $_POST['busqueda_codigo']; ?>">
                    <?php
                    $codigo = $_POST['busqueda_codigo'];
                    $query_solicitud = "select m.codigomateria, m.nombremateria, m.numerocreditos, c.nombrecarrera
		from materia m, carrera c
		where m.codigocarrera = c.codigocarrera
		and m.codigomateria like '$codigo%'
		and m.codigoestadomateria = '01'
		$sinmateria
		order by 2";
                    $solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
                }
                if (!$vacio) {
                    ?>
                    <table width="780" border="1" cellspacing='1' bordercolor='#D76B00'>
                        <tr>
                            <td width="364">
                                <select  multiple name="listauno[]" size="10" style="width:362px" class="Estilo2">
                                    <?php
                                    $totalRows_solicitud = mysql_num_rows($solicitud);
                                    if ($totalRows_solicitud != "") {
                                        while ($row_solicitud = mysql_fetch_assoc($solicitud)) {
                                            $nombremateria = $row_solicitud['nombremateria'];
                                            $codigomateria = $row_solicitud['codigomateria'];
                                            ?>
                                            <option value="<?php echo $codigomateria; ?>"><?php echo "$nombremateria &nbsp;&nbsp; $codigomateria"; ?></option>

                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <option value="0"><strong>No hay materias</strong></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </td>
                            <td width="42" align="center">
                                <input type="button" name="derecha"
                                       onClick="moverOpciones(this.form.elements['listauno[]'], this.form.elements['listados[]'])" value=">>">
                                <br>
                                <input type="button" name="izquierda"
                                       onClick="moverOpciones(this.form.elements['listados[]'], this.form.elements['listauno[]'])" value="<<">
                            </td>
                            <td width="364">
                                <select multiple name="listados[]" size="10" style="width:362px" class="Estilo2">
                                    <?php
                                    $query_materiaslineaenfasis = "select d.codigomateriadetallelineaenfasisplanestudio, m.nombremateria
                                    from detallelineaenfasisplanestudio d, materia m
                                    where d.idlineaenfasisplanestudio = '$idlineaenfasis'
                                    and d.idplanestudio = '$idplanestudio'
                                    and d.codigomateria = '$codigomateriapapa'
                                    and d.codigomateriadetallelineaenfasisplanestudio = m.codigomateria
                                    order by 2";
                                    $materiaslineaenfasis = mysql_query($query_materiaslineaenfasis, $sala) or die("$query_materiaslineaenfasis");
                                    $totalRows_materiaslineaenfasis = mysql_num_rows($materiaslineaenfasis);
                                    if ($totalRows_materiaslineaenfasis != "") {
                                        while ($row_materiaslineaenfasis = mysql_fetch_assoc($materiaslineaenfasis)) {
                                            $nombremateria = $row_materiaslineaenfasis['nombremateria'];
                                            $codigomateria = $row_materiaslineaenfasis['codigomateriadetallelineaenfasisplanestudio'];
                                            ?>
                                            <option value="<?php echo $codigomateria; ?>"><?php echo "$nombremateria &nbsp;&nbsp; $codigomateria"; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <option value="0"></option>
                                    <?php ?>
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
            if (isset($_POST['filtrarbusqueda']) || isset($_GET['filtrarbusqueda'])) {
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
                        if (isset($_GET['busqueda'])) {
                            ?>
                            <td class="Estilo1">&nbsp;
                                <?php
                                if ($_GET['busqueda'] == "nombre") {
                                    echo "Digite un Nombre : <input name='busqueda_nombre' type='text' value=''>";
                                }
                                if ($_GET['busqueda'] == "codigo") {
                                    echo "Digite un Código : <input name='busqueda_codigo' type='text' value=''>";
                                }
                                ?>
                            </td>
                            <td class="Estilo1"><strong>Fecha: </strong></td>
                            <td class="Estilo1"><?php echo $fechahoy = date("Y-m-d"); ?>&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="4" align="center" class="Estilo1"><input name="buscar" type="submit" value="Buscar">&nbsp;</td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td colspan="4" align="center" class="Estilo1"><input name="cancelar" type="button" value="Cancelar" onClick="window.location.href = '<?php echo 'visualizarhijoslineadeenfasis.php?planestudio=' . $idplanestudio . '&lineaenfasis=' . $idlineaenfasis . '&materiapapa=' . $codigomateriapapa . ''; ?>'">&nbsp;</td>
                    </tr>
                </table>
                <?php
            }
            ?>
        </form>
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
            if (listaFuente.options[i].value != 0)
            {
                if (listaFuente.options[i].selected && listaFuente.options[i].value != "")
                {
                    //Mueve el elemento seleccionado de la lista fuente a la lista destino
                    var opciont = new Option();
                    opciont.value = listaFuente.options[i].value;

                    opciont.text = listaFuente.options[i].text;
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
        for (contador = 0; contador < longLista; contador++)
        {
            listado = listado + "  (" + lista.options[contador].value + ","
            listado = listado + lista.options[contador].text + ")";
        }
        mensaje = mensaje + "\n" + listado
        alert(mensaje);
    }
</script>
</html>
