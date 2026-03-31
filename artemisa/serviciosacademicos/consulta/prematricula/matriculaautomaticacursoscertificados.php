<?php
session_start();
include_once('../../utilidades/ValidarSesion.php');
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
    
$quitarmaterias1 = "";

// Pone las materias de la carga que no aparecen en el plan de estudio
$query_materiascarga =
"select distinct m.codigomateria, m.nombremateria, d.semestredetalleplanestudio, 
t.nombretipomateria, t.codigotipomateria, d.numerocreditosdetalleplanestudio, 
c.codigoestadocargaacademica
from materia m, tipomateria t, cargaacademica c, detalleplanestudio d
where m.codigotipomateria = t.codigotipomateria
and c.codigoestudiante = '$codigoestudiante'
and c.codigomateria = m.codigomateria
and c.codigoperiodo = '$codigoperiodo'
and c.codigoestadocargaacademica like '1%'
and c.idplanestudio = d.idplanestudio
and d.codigomateria = c.codigomateria $quitarmaterias1
order by 3,2";

$materiascarga=mysql_query($query_materiascarga, $sala) or die("$query_materiascarga");
$totalRows_materiascarga = mysql_num_rows($materiascarga);

if($totalRows_materiascarga != "")
{
	while($row_materiascarga = mysql_fetch_array($materiascarga))
	{
		if(ereg("^1",$row_materiascarga['codigoestadocargaacademica']))
		{
			$quitarmaterias1 = "$quitarmaterias1 and c.codigomateria <> ".$row_materiascarga['codigomateria']."";
			$materiasponercarga[] = $row_materiascarga['codigomateria'];
			$materiasfinal[] = $row_materiascarga;
		}
	}
}

// OJO: El siguiente codigo toca quitarlo despues del 20052
// Se coloco para pasar por alto el error generado por no guardar el idplanestudio en cargaacademica
$query_materiascarga = "select m.codigomateria, m.nombremateria, d.semestredetalleplanestudio, 
t.nombretipomateria, t.codigotipomateria, d.numerocreditosdetalleplanestudio, 
c.codigoestadocargaacademica
from materia m, tipomateria t, cargaacademica c, detalleplanestudio d
where m.codigotipomateria = t.codigotipomateria
and c.codigoestudiante = '$codigoestudiante'
and c.codigomateria = m.codigomateria
and c.codigoperiodo = '$codigoperiodo'
and c.codigoestadocargaacademica like '1%'
and d.codigomateria = c.codigomateria
$quitarmaterias1
group by 1
order by 3,2";

$materiascarga=mysql_query($query_materiascarga, $sala) or die("$query_materiascarga");
$totalRows_materiascarga = mysql_num_rows($materiascarga);

if($totalRows_materiascarga != "")
{
	while($row_materiascarga = mysql_fetch_array($materiascarga))
	{
		if(ereg("^1",$row_materiascarga['codigoestadocargaacademica']))
		{
			$quitarmaterias1 = "$quitarmaterias1 and c.codigomateria <> ".$row_materiascarga['codigomateria']."";
			$materiasponercarga[] = $row_materiascarga['codigomateria'];
			$materiasfinal[] = $row_materiascarga;
		}
	}
}

// Este se coloca para coger las materias que no pertenecen a ningun plan de estudio (Electivas y materias no definidas en algun plan de estudio)
$query_materiascarga = "select m.codigomateria, m.nombremateria, 1 as semestredetalleplanestudio, 
t.nombretipomateria, t.codigotipomateria, m.numerocreditos as numerocreditosdetalleplanestudio, 
c.codigoestadocargaacademica
from materia m, tipomateria t, cargaacademica c
where m.codigotipomateria = t.codigotipomateria
and c.codigoestudiante = '$codigoestudiante'
and c.codigomateria = m.codigomateria
and c.codigoperiodo = '$codigoperiodo'
and c.codigoestadocargaacademica like '1%'
$quitarmaterias1
group by 1
order by 3,2";

$materiascarga=mysql_query($query_materiascarga, $sala) or die("$query_materiascarga");
$totalRows_materiascarga = mysql_num_rows($materiascarga);

if($totalRows_materiascarga != "")
{
	while($row_materiascarga = mysql_fetch_array($materiascarga))
	{
		if(ereg("^1",$row_materiascarga['codigoestadocargaacademica']))
		{
			$quitarmaterias1 = "$quitarmaterias1 and c.codigomateria <> ".$row_materiascarga['codigomateria']."";
			$materiasponercarga[] = $row_materiascarga['codigomateria'];
			$materiasfinal[] = $row_materiascarga;
		}
	}
}

$entroenalgo = false;
?>
<div class="col-md-12">
<table class="table table-striped">
    <tr bgcolor="#C5D5D6">
        <td bgcolor="#FFC993" class="Estilo2 Estilo1 Estilo3 Estilo14">
            <div align="center"></div>
            <div align="center"><font face="Tahoma"><strong>C&oacute;digo</strong></font></div>
        </td>
        <td bgcolor="#FFC993" class="Estilo1 Estilo3 Estilo14"> <div align="center"></div>
            <div align="center"></div>
            <div align="center"><font face="Tahoma"><strong>Asignatura</strong></font></div>
        </td>
        <td bgcolor="#FFC993" class="Estilo1 Estilo3 Estilo8">
            <div align="center" class="Estilo14"><font face="Tahoma"><strong>Sem.</strong></font></div>
        </td>
        <td bgcolor="#FFC993" class="Estilo1 Estilo3">
            <div align="center" class="Estilo14"><font face="Tahoma"><font face="Tahoma"><strong>Tipo</strong></font></font></div>
        </td>
        <td bgcolor="#FFC993" class="Estilo1 Estilo3">
            <div align="center" class="Estilo14"><font face="Tahoma"><strong>Cr&eacute;ditos</strong></font></div>
        </td>
        <td bgcolor="#FFC993" class="Estilo1 Estilo3 Estilo14"> <div align="center"></div>
            <div align="center"></div>
            <div align="center"><font face="Tahoma"><strong>Seleccionar</strong></font></div>
        </td>
    </tr>
    <?php

    if(isset($materiasfinal))
    {
        foreach($materiasfinal as $key5 => $value5)
        {
            $valueserial5 = serialize($value5);
            if(isset($prematricula_inicial))
            {
                $desabilitar = "";
                $id = "";
                $chequear = "";

                foreach($prematricula_inicial as $llave => $codigomateriaprematricula)
                {
                    if($codigomateriaprematricula == $value5['codigomateria'])
                    {
                        $prematriculafiltrar[] = $value5;
                        $desabilitar = "disabled";
                        $id = "id='habilita'";
                        $chequear = "checked";
                    }
                }
            } // if(isset($prematricula_inicial))
            $entroenalgo = true;
            ?>
            <tr>
                <td><div align="center"><font size="2" face="Tahoma"><?php echo $value5['codigomateria'];?></font></strong></div></td>
                <td><div align="center"><font size="2" face="Tahoma"><?php echo $value5['nombremateria'];?></font></strong></div></td>
                <td><div align="center"><font size="2" face="Tahoma"><?php echo $value5['semestredetalleplanestudio'];?></font></strong></div></td>
                <td><div align="center"><font size="2" face="Tahoma">Sin Restricción</font></strong></div></td>
                <td><div align="center"><font size="2" face="Tahoma"><?php echo $value5['numerocreditosdetalleplanestudio'];?></font></strong></div></td>
                <td>
                    <div align="center">
                        <font size="2" face="Tahoma">
                            <?php echo "<input name='sinrestriccion$key5' type='checkbox' value='$valueserial5' $id $desabilitar $chequear>";?>
                        </font>
                    </div>
                </td>
                <?php $materiaspantallainicial[] = $value5['codigomateria']; ?>
            </tr>
        <?php
        }// foreach($materiasfinal as $key5 => $value5)

    } //if(isset($materiasfinal))

    if(!$entroenalgo)
    {
    ?>
        <tr>
            <td class="Estilo1 Estilo2 Estilo1 Estilo3 Estilo8" colspan="6" align="center"><strong>El estudiante no tiene carga académica</strong></td>
        </tr>
    <?php
    }
    ?>
</table>
</div>
<span class="Estilo1 Estilo3"> </span>
<p align="center">
  <input class="btn btn-success btn-sm" name="aceptar" type="submit" id="aceptar" value="Aceptar" onClick="habilitar(this.form.habilita)">
  <input class="btn btn-danger btn-sm" name="regresar1" type="button" value="Regresar" onClick="regresar()">
</p>
<?php
$sumacredtitoselectivas = 0;
$numeromateriaselegidas = 0;

foreach($_POST as $llavepost => $valorpost)
{
	if(ereg("sugerida",$llavepost))
	{
		echo "<bR>$llavepost => $valorpost<br>";
		$materiasugerida = unserialize(stripcslashes($valorpost));
		$numeromateriaselegidas++;
		$materiasseleccionadas[] = $materiasugerida['codigomateria'];
	}
	if(ereg("obligatoria",$llavepost))
	{
		echo "<bR>$llavepost => $valorpost<br>";
		$materiaobligatoria = unserialize(stripcslashes($valorpost));
		$numeromateriaselegidas++;
		$materiasseleccionadas[] = $materiaobligatoria['codigomateria'];
	}
	if(ereg("grupopapa",$llavepost))
	{
		$llaveini = ereg_replace("grupopapa","",$llavepost);
		$materiagrupo = unserialize(stripcslashes($valorpost));
		$materiahija = unserialize(stripcslashes($_POST['grupohijo'.$llaveini.'']));

		if($materiahija <> "")
		{
			$materiasseleccionadas["grupo".$materiagrupo['codigomateria']] = $materiahija['codigomateria'];
			end($materiasseleccionadas);
			reset($materiasseleccionadas);
			$numeromateriaselegidas++;
		}
	 	else
		{
            ?>
            <script language="javascript">
                alert("Debido a que selecciono ver un grupo, debe selecionar una materia del grupo deseado");
                history.go(-1);
            </script>
            <?php
		}
	}
	if(ereg("electoblig",$llavepost))
	{
		$materiaenfasis = unserialize(stripcslashes($valorpost));
		$numeromateriaselegidas++;
		$materiasseleccionadas[] = $materiaenfasis['codigomateria'];
	}
	if(ereg("electiva",$llavepost))
	{
		echo "<bR>$llavepost => $valorpost<br>";
		$materiaelectiva = unserialize(stripcslashes($valorpost));
		$sumacredtitoselectivas = $sumacredtitoselectivas + $materiaelectiva['numerocreditos'];
		$materiasseleccionadas[] = $materiaelectiva['codigomateria'];
	}
	if(ereg("sinrestriccion",$llavepost))
	{
		$materiasinrestriccion = unserialize(stripcslashes($valorpost));
		$materiasseleccionadas[] = $materiasinrestriccion['codigomateria'];
		$numeromateriaselegidas = $numeromateriaschequeadas + 1;
	}
}// foreach($_POST as $llavepost => $valorpost)

$materiasserial = serialize($materiasseleccionadas);
$cargaescogida = $materiasseleccionadas;

// Comparo las materias obligatorias con las escogidas por el estudiante
// Si hay modificación de la carga adicionando materias se deben pasar esas materias si validación 
if(isset($_POST['aceptar']))
{
	// Validar los corequisitos sencillos y dobles de las materias elegidas, con respecto a la carga generada
	// la carga generada es la que se imprime en la pantalla
	// Comparo la carga obligatoria con la carga escogida, tomando las materias diferentes
	// Si no se escoogen materias se devuelve

	if(!isset($cargaescogida))
	{
		echo '<script language="javascript">
		alert("Debe seleccionar materias para realizar la inscripción");
		window.location.href="matriculaautomatica.php?programausadopor='.$_GET['programausadopor'].'";
		</script>';
	}
	if($diferenciaenlacarga = @array_diff($cargaobligatoria, $cargaescogida))
	{
		foreach($diferenciaenlacarga as $llave1 => $codigomateria1)
		{

			/******** COREQUISITOS DOBLES ******/
			// Primero valida los dobles, usando la materia como papa
			// Despues se comparan lo resultados en el arreglo
			
			// En el siguiente código se quiere seleccionar la materia papa
			// Selecciona la materia si es papa
			$espapa = true;

			$query_materiascorequisito =
                "select distinct r.codigomateria
                from referenciaplanestudio r
                where r.idplanestudio = '$idplanestudioini'
                and r.codigomateria = '$codigomateria1'
                and r.codigotiporeferenciaplanestudio like '200'
                and r.codigoestadoreferenciaplanestudio = '101'";

			$materiascorequisito=mysql_query($query_materiascorequisito, $sala) or die("$query_materiascorequisito");
			$totalRows_materiascorequisito = mysql_num_rows($materiascorequisito);

			echo "$query_materiascorequisito<br>";

			if($totalRows_materiascorequisito == "")
			{
				$espapa = false;
				// Selecciona el papa de la materia si es hija
				$query_materiascorequisito = "select distinct r.codigomateria
				from referenciaplanestudio r
				where r.idplanestudio = '$idplanestudioini'
				and r.codigomateriareferenciaplanestudio = '$codigomateria1'
				and r.codigotiporeferenciaplanestudio like '200'
				and r.codigoestadoreferenciaplanestudio = '101'";
				$materiascorequisito=mysql_query($query_materiascorequisito, $sala) or die("$query_materiascorequisito");
				$totalRows_materiascorequisito = mysql_num_rows($materiascorequisito);
				$materiascorequisito=mysql_query($query_materiascorequisito, $sala) or die("$query_materiascorequisito");
				$totalRows_materiascorequisito = mysql_num_rows($materiascorequisito);
				echo "$query_materiascorequisito<br>";
			}
			// Si encontro el papa lo coje
			if($totalRows_materiascorequisito != "")
			{
				$row_materiascorequisito = mysql_fetch_array($materiascorequisito);
				$codigomateriapapa1 = $row_materiascorequisito['codigomateria']; 
				
				if(!$espapa)
				{
					if(in_array($codigomateriapapa1, $cargaescogida))
					{
						// Si la materia esta en la carga => mensaje
						if(in_array($codigomateria1, $materiaspantallainicial))
						{
							echo '<script language="javascript">
							alert("La materia '.$codigomateria1.' debe seleccionarse ya que tiene seleccionado un corequisito doble");
							window.location.href="matriculaautomatica.php?programausadopor='.$_GET['programausadopor'].'";
							</script>';
						}
					}
				}
				// Seleciona todos los corequisitos hijos y mira uno por uno
				$query_materiascorequisitodoble = "select distinct r.codigomateriareferenciaplanestudio
				from referenciaplanestudio r
				where r.idplanestudio = '$idplanestudioini'
				and r.codigomateria = '$codigomateriapapa1'
				and r.codigotiporeferenciaplanestudio like '200'
				and r.codigoestadoreferenciaplanestudio = '101'";
				$materiascorequisitodoble=mysql_query($query_materiascorequisitodoble, $sala) or die("$query_materiascorequisitodoble");
				$totalRows_materiascorequisitodobleo = mysql_num_rows($materiascorequisitodoble);

				while($row_materiascorequisitodoble = mysql_fetch_array($materiascorequisitodoble))
				{
					// Mira si alguno de los corequisitos esta en la carga escogida
					// Si no es así no permite seguir ya que debe cojer el papa
					$codigomateriahija = $row_materiascorequisitodoble['codigomateriareferenciaplanestudio'];
					//echo "<br>HIJA: $codigomateriahija<br>";
					if(in_array($codigomateriahija, $cargaescogida))
					{
						//echo "$codigomateriahija";
						if(in_array($codigomateria1, $materiaspantallainicial))
						{
							echo '<script language="javascript">
							alert("La materia '.$codigomateria1.' debe seleccionarse ya que tiene corequisitos dobles seleccionados");
							window.location.href="matriculaautomatica.php?programausadopor='.$_GET['programausadopor'].'";
							</script>';
						}
					}
				}
			}
			/******** COREQUISITOS SENCILLOS ******/
			// En el siguiente código se quiere seleccionar la materia papa
			// Selecciona los papas de la materia sin escoger
			$query_materiascorequisitosencillo = "select distinct r.codigomateriareferenciaplanestudio
			from referenciaplanestudio r
			where r.idplanestudio = '$idplanestudioini'
			and r.codigomateria = '$codigomateria1'
			and r.codigotiporeferenciaplanestudio like '201'
			and r.codigoestadoreferenciaplanestudio = '101'";
			$materiascorequisitosencillo=mysql_query($query_materiascorequisitosencillo, $sala) or die("$query_materiascorequisitosencillo");
			$totalRows_materiascorequisitosencillo = mysql_num_rows($materiascorequisitosencillo);
			//echo "<br>Sencillo:  $query_materiascorequisitosencillo<br>";
			while($row_materiascorequisitosencillo = mysql_fetch_array($materiascorequisitosencillo))
			{
				// Mira si la materia tiene hijos escogios
				// Si es así no permite seguir ya que debe cogerlos
				$codigomateriapapa = $row_materiascorequisitosencillo['codigomateriareferenciaplanestudio'];
				if(in_array($codigomateriapapa, $cargaescogida))
				{
					if(in_array($codigomateria1, $materiaspantallainicial))
					{
						echo '<script language="javascript">
						alert("La materia '.$codigomateria1.' debe seleccionarse ya que tiene como corequisito sencillo a '.$codigomateriapapa.'");
						window.location.href="matriculaautomatica.php?programausadopor='.$_GET['programausadopor'].'";
						</script>';
					}
				}
			}
		}
		// En la carga escogida por el estudiante se valida
		// Validacion del máximo numero de créditos permitidos
	}

	$numerocreditos = 0;
	foreach($cargaescogida as $llave2 => $codigomateria2)
	{	
		$query_selcreditosmateria = "select m.numerocreditos
		from materia m
		where m.codigomateria = '$codigomateria2'";
		//echo "$query_selcreditosmateria<br>";
		$selcreditosmateria=mysql_query($query_selcreditosmateria, $sala) or die("$query_selcreditosmateria");
		$totalRows_selcreditosmateria = mysql_num_rows($selcreditosmateria);
		$row_selcreditosmateria = mysql_fetch_array($selcreditosmateria);
		$numerocreditos = $numerocreditos + $row_selcreditosmateria['numerocreditos'];
	}

	$query_selcreditoscarrera = "select jc.numeromaximocreditosjornadacarrera as maximonumerocredito 
	from jornadacarrera jc
	where jc.codigocarrera = '".$row_estudiante['codigocarrera']."'
	and jc.codigojornada = '".$row_estudiante['codigojornada']."'";
	$selcreditoscarrera=mysql_query($query_selcreditoscarrera, $sala) or die("$query_selcreditoscarrera");
	$totalRows_selcreditoscarrera = mysql_num_rows($selcreditoscarrera);
	$row_selcreditoscarrera = mysql_fetch_array($selcreditoscarrera);
	$maximonumerocredito = $row_selcreditoscarrera['maximonumerocredito'];

	if($maximonumerocredito < $numerocreditos)
	{
		echo '<script language="javascript">
		alert("El número de créditos seleccionados supera a '.$maximonumerocredito.' que es el máximo permitido, por lo tanto debe seleccionar menos materias");
		window.location.href="matriculaautomatica.php?programausadopor='.$_GET['programausadopor'].'";
		</script>';
	}

	if($numeromateriaselegidas == $numeromateriaschequeadas)
	{
		echo "UNO $enfasisget";
		echo "<script language='javascript'>
			window.location.href='matriculaautomaticahorarios.php?programausadopor=".$_GET['programausadopor']."&materiassinhorarios=$materiasserial&$enfasisget&lineaunica=".$_POST['lineaunica']."';
		</script>";
	}
	else
	{
		echo "DOS: $enfasisget";
		echo "<script language='javascript'>
			window.location.href='matriculaautomaticahorarios.php?programausadopor=".$_GET['programausadopor']."&materiassinhorarios=$materiasserial&$enfasisget&lineaunica=".$_POST['lineaunica']."';
		</script>";
		//Se dirige a los horarios donde un estudiante elige
	}
}
