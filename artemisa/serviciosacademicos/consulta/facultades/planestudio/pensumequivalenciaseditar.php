<?php
if(!isset($_SESSION['MM_Username'])){
    session_start();
}
is_file(dirname(__FILE__) ."/../../../utilidades/ValidarSesion.php")
    ? include_once(dirname(__FILE__) .'/../../../utilidades/ValidarSesion.php')
    : include_once(realpath(dirname(__FILE__) .'/../../../utilidades/ValidarSesion.php'));
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
    
if(!isset($_POST['busqueda_nombre'])){
	$_POST['busqueda_nombre'] = "";
}

$sinmateria = "";
if(isset($Arregloequivalencias)){
	foreach($Arregloequivalencias as $keyINI => $selEquivalenciasINI){
		$codigomateria = $selEquivalenciasINI;
		$quitarcodigomateria = $codigomateria;
		$sinmateria = "$sinmateria and codigomateria <> '$quitarcodigomateria'";
	}
}
$sinmateria = "$sinmateria and codigomateria <> '$Varcodigodemateria'";

if(isset($fechainicio) && !empty($fechainicio)){
    $dateinicial = new DateTime($fechainicio);
    $fechainicio = $dateinicial->format('Y-m-d');
}else if(isset($_POST['finiciocorequisito'])){
    $fechainicio = $_POST['finiciocorequisito'];
}

if(!isset($fechainicio) || empty($fechainicio)){
    $fechainicio = date('Y-m-d');
}

if(isset($_POST['finiciocorequisito']))
{
    $fechainicio = $_POST['finiciocorequisito'];
    $imprimir = true;
    $fechainiciofecha = validar($fechainicio,"fecha",$error3,&$imprimir);
    $formulariovalido = $formulariovalido*$fechainiciofecha;
    if($formulariovalido == 1)
    {
        $inicio = new DateTime($_POST['finiciocorequisito']);
        $vencimiento = new DateTime($_POST['fvencimientocorequisito']);
        if($inicio > $vencimiento)
        {
            $msgfechainicio =  "La Fecha de Inicio debe ser menor que la Fecha de Vencimiento";
            $formulariovalido = 0;
        }
        if($inicio == $vencimiento)
        {
            $msgfechainicio = "La Fecha de Inicio debe ser diferente que la Fecha de Vencimiento";
            $formulariovalido = 0;
        }
    }
}

if(!isset($msgfechainicio) || empty($msgfechainicio)){
    $msgfechainicio ="";
}

if(isset($_POST['fvencimientocorequisito']))
{
    $fechavencimiento = $_POST['fvencimientocorequisito'];
    $imprimir = true;
    $fechavencimientofecha = validar($fechavencimiento,"fecha",$error3,&$imprimir);
    $formulariovalido = $formulariovalido*$fechavencimientofecha;
    if($formulariovalido == 1)
    {
        $inicio = new DateTime($_POST['finiciocorequisito']);
        $vencimiento = new DateTime($_POST['fvencimientocorequisito']);
        if($inicio > $vencimiento)
        {
            $msgfechavencimiento =  "La Fecha de Vencimiento debe ser mayor que la Fecha de Vencimiento";
            $formulariovalido = 0;
        }
        if($inicio == $vencimiento)
        {
            $msgfechavencimiento = "La Fecha de Vencimiento debe ser diferente que la Fecha de Inicio";
            $formulariovalido = 0;
        }
    }
}
if(!isset($msgfechavencimiento) || empty($msgfechavencimiento)){
    $msgfechavencimiento = "";
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
	<td align="center">
        <input type="text" name="finiciocorequisito" value="<?php echo $fechainicio;?>"
           placeholder="" size="10" onBlur="iniciarinicio(this)" onFocus="limpiarinicio(this)">
	  <font size="1" face="Tahoma"><font color="#FF0000">
	  <?php echo $msgfechainicio;?>
    </font></font></td>
	<td align="center" colspan="2"><input type="text" name="fvencimientocorequisito" value="<?php if($fechavencimiento != "") echo ereg_replace(" [0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}$","",$fechavencimiento); else if(isset($_POST['fvencimientocorequisito'])) echo $_POST['fvencimientocorequisito']; else echo "2999-12-31";?>" size="10" onBlur="iniciarvencimiento(this)" onFocus="limpiarvencimiento(this)">
	  <font size="1" face="Tahoma"><font color="#FF0000">
	  <?php echo $msgfechavencimiento; ?>
    </font></font></td>
  </tr>
</table>
<?php
$vacio = false;
// La consulta es para ingresar los datos al select
// Ojo hay que quitar las materias que ya hallan sido adicionadas al plan de estudios
// es decir las que aparescan en el select de la derecha
if((!isset($_POST['filtrarbusqueda']) || isset($_POST['buscar'])) && !isset($_GET['busqueda'])){
	if(isset($_POST['busqueda_nombre'])){
        ?>
        <input type="hidden" name="busqueda_nombre" value="<?php $_POST['busqueda_nombre']; ?>">
        <?php
		$nombre = $_POST['busqueda_nombre'];
		$query_solicitud = "select m.codigomateria, m.nombremateria, m.numerocreditos, c.nombrecarrera ".
		" from materia m, carrera c where m.codigocarrera = c.codigocarrera ".
		" and m.nombremateria like '$nombre%'".$sinmateria." order by 2, 1";
		$solicitud = $db->GetAll($query_solicitud);
	}
	if(isset($_POST['busqueda_codigo'])){
        ?>
        <input type="hidden" name="busqueda_codigo" value="<?php $_POST['busqueda_codigo']; ?>">
        <?php
		$codigo = $_POST['busqueda_codigo'];
		$query_solicitud = "select m.codigomateria, m.nombremateria, m.numerocreditos, c.nombrecarrera ".
		" from materia m, carrera c where m.codigocarrera = c.codigocarrera ".
		" and m.codigomateria like '$codigo%' ".$sinmateria." order by 2";
		$solicitud = $db->GetAll($query_solicitud);
	}
	if(!$vacio){
        ?>
        <table width="780" border="1" cellpadding="2" cellspacing="1" bordercolor="#D76B00">
            <tr>
	            <td width="364">
                    <select  multiple name="listauno[]" size="10" style="width:362px" class="Estilo2">
                    <?php
		                $totalRows_solicitud = count($solicitud);
		                if($totalRows_solicitud != ""){
			                foreach($solicitud as $row_solicitud){
				                $nombremateria = $row_solicitud['nombremateria'];
				                $codigomateria = $row_solicitud['codigomateria'];
                                ?>
			                    <option value="<?php echo $codigomateria; ?>">
                                    <?php echo "$nombremateria &nbsp;&nbsp; $codigomateria"; ?>
                                </option>
                                <?php
			                }//foreach
		                }
		                else{
                            ?>
		                    <option value="0"><strong>No hay materias</strong></option>
                            <?php
		                }
                    ?>
                    </select>
                </td>
                <td width="42" align="center">
	                <input type="button" name="derecha"
	                onClick="moverOpciones(this.form.elements['listauno[]'],this.form.elements['equivalencia[]'])" value=">>">
	                <br>
	                <input type="button" name="izquierda"
   	                onClick="moverOpciones(this.form.elements['equivalencia[]'],this.form.elements['listauno[]'])" value="<<">
  	            </td>
	            <td width="364">
                    <select multiple name="equivalencia[]" size="10" style="width:362px" class="Estilo2">
                        <?php
                        if(isset($Arregloequivalencias)){
                            foreach($Arregloequivalencias as $key3 => $selEquivalencias){
                                $codigomateria = $selEquivalencias;
                                $query_datomateriaequivalente = "select nombremateria from materia ".
                                " where codigomateria = '$codigomateria'";
                                $datomateriaequivalente = $db->GetRow($query_datomateriaequivalente);
                                $totalRows_datomateriaequivalente = count($datomateriaequivalente);
                                $row_datomateriaequivalente = $datomateriaequivalente;
                                $nombremateria = $row_datomateriaequivalente['nombremateria'];
                                ?>
                                <option value="<?php echo $codigomateria; ?>">
                                    <?php echo "$nombremateria &nbsp;&nbsp; $codigomateria"; ?>
                                </option>
                                <?php
                            }//foreach
                        }
                        ?>
                    </select>
	            </td>
            </tr>
            <tr>
                <td colspan="3" align="center">
	                <input type="submit" name="aceptarequivalencias" value="Aceptar"
                           onClick="activarLista(this.form.elements['equivalencia[]'])">
                    <?php
                    if($estaEnenfasis == "no"){
                        ?>
                        <input type="button" name="regresar" value="Regresar"
                               onClick="window.location.href='materiasporsemestre.php?planestudio=<?php echo "$idplanestudio";?>'">
                        <?php
                    }
                    else{
                        ?>
                        <input type="button" name="regresar" value="Regresar"
                               onClick="window.location.href='materiaslineadeenfasisporsemestre.php?planestudio=<?php
                               echo "$idplanestudio&lineaenfasis=$idlineaenfasis";?>'">
                        <?php
                    }
                    ?>
                </td>
            </tr>
        </table>
    <?php
	}
}
?>
</div>
</body>
<script language="javascript">
//Mueve las opciones seleccionadas en listaFuente a listaDestino
function moverOpciones(listaFuente, listaDestino){
	var i;
	var d = listaDestino.options.length;
	//Recorre la lista fuente buscando elementos seleccionados
	for (i = 0; i < listaFuente.options.length; i++){
		if(listaFuente.options[i].value != 0){
			if (listaFuente.options[i].selected && listaFuente.options[i].value != ""){
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

function activarLista(lista){
	for (i = 0; i < lista.options.length; i++){
		lista.options[i].selected = true;
	}
}

function verLista(lista){
	var listado = "";
	var longLista = lista.options.length;
	var contador;
	var mensaje = "Lista de opciones (valor,texto)";
	for (contador = 0;contador <longLista;contador++){
		listado = listado + "  (" + lista.options[contador].value + ","
		listado = listado + lista.options[contador].text + ")";
	}
	mensaje = mensaje + "\n" + listado
	alert(mensaje);
}
</script>
</html>