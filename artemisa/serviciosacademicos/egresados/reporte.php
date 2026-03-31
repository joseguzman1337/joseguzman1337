<?php
/*
* Caso 90158
* @modified Luis Dario Gualteros 
* <castroluisd@unbosque.edu.co>
 * Se modifica la variable session_start por la session_start( ) ya que es la funcion la que contiene el valor de la variable $_SESSION.
 * @since Mayo 18 de 2017
*/
session_start( );
//End Caso  90158
include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

?>
<link rel="stylesheet" type="text/css" href="../estilos/sala.css">
<style>
    button,select , input[type="submit"], input[type="reset"], input[type="button"], .button {
    background-color: #ECF1F4;
    background-image: url("../../../../index.php?entryPoint=getImage&themeName=Sugar5&imageName=bgBtn.gif");
    border-color: #ABC3D7;
    color: #000000;
}
</style>
<table align="center" width="50%" style="" >
    <tr><td colspan="3">
            <div id="studiofields">
        <input class="button" type="button" onclick="document.location ='resultado_gestion.php'" value="Regresar" name="addfieldbtn"/>
        </div>
        </td></tr>
    <tr><td colspan="3">Encuesta de Egresados<hr></td></tr>
    <tr><td colspan="3">
<?php
//$_SESSION['MM_Username']='admintecnologia';
//echo '<pre>';print_r($_REQUEST);
error_reporting(0);
$rutaado = ("../funciones/adodb/");
require_once(realpath(dirname(__FILE__))."/../funciones/clases/motorv2/motor.php");
require_once(realpath(dirname(__FILE__))."/../Connections/salaado-pear.php");
require_once(realpath(dirname(__FILE__))."/../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once(realpath(dirname(__FILE__))."/../funciones/clases/formulario/clase_formulario.php");
require_once(realpath(dirname(__FILE__))."/../funciones/sala_genericas/FuncionesCadena.php");
require_once(realpath(dirname(__FILE__))."/../funciones/sala_genericas/FuncionesFecha.php");
require_once(realpath(dirname(__FILE__))."/../funciones/sala_genericas/FuncionesMatriz.php");
require_once(realpath(dirname(__FILE__))."/../funciones/sala_genericas/formulariobaseestudiante.php");
require_once(realpath(dirname(__FILE__))."/../funciones/sala_genericas/clasebasesdedatosgeneral.php");

$objetobase = new BaseDeDatosGeneral($sala);

echo "<form name=\"form3\" action=\"\" method=\"post\">";

$where=($_REQUEST['codigocarreraaux2']!='')?" where e.codigocarrera=".$_REQUEST['codigocarreraaux2']:"";

$query=" select count(*) as conteo from estudiante e join egresado_ext ee on e.idestudiantegeneral=ee.codigoestudiante $where";
$operacion = $objetobase->conexion->query($query);
$total=$operacion->fields['conteo'];


echo "<label id='labelresaltado'><h1>Total estudiantes encuestados : $total</h1></label>";

 $query_label="select * from label a inner join label_type b on a.idlabel_type = b.idlabel_type where table_name ='egresado_ext' and status = 1;";//Laber o etiquetas o Preguntas
$operacion = $objetobase->conexion->query($query_label);
while ($row = $operacion->fetchRow()) {
    echo "	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"100%\">
	<tr><td colspan='3'><label id='labelresaltado'><h3>".$row['label_field']."</h3></label></td></tr>";
        $query_label_detalle="select count(".$row['field'].") as conteo,".$row['field']."
            from egresado_ext ee inner join estudiante e on ee.codigoestudiante=e.idestudiantegeneral where e.codigocarrera=5
and  ".$row['field']." <> ''
group by ".$row['field'].";";//Respuestas a label
        $operacion_detalle = $objetobase->conexion->query($query_label_detalle);
        $totaql=0;
        $torta = '';
        $tortad =0;
        $torta='';
        $tortacampos='';
        while ($row_detalle= $operacion_detalle->fetchRow()) {
        $totaql+=$row_detalle['conteo'];
            echo "<tr><td>".$row_detalle[''.$row['field'].'']."</td><td align='right'>".$row_detalle['conteo']."</td><td align='right'>".round($row_detalle['conteo']*100/$total,2)."%</td></tr>";
            $torta[]=round($row_detalle['conteo']*100/$total,1);
            $tortacampos[]=$row_detalle[''.$row['field'].''];
        }
        foreach($torta as $valeu)$tortad += $valeu;        
        if ($tortad < 99){
           $torta[]=100-$tortad;
           $tortacampos[]="No Registra Informacion";
        }
        $cli='';
        $t='';
        foreach($torta as $datatorta){$t.=$datatorta.",";}
        $datatorta='';
        foreach($tortacampos as $datatorta){$cli.=$datatorta."|";}
        $t =substr ($t, 0, strlen($t) - 1);
        //echo "<br>";
        $cli =substr ($cli, 0, strlen($cli) - 1);
        
       
echo "	<tr><td><label id='labelresaltado'>TOTAL</label></td><td align='right'><label id='labelresaltado'>$totaql</label></td><td align='right'><label id='labelresaltado'>&nbsp;</label></td></tr>";
echo '<tr><td colspan=3><img src="http://chart.apis.google.com/chart?chs=650x150&chd=t:'.$t.'&cht=p3&chl='.$cli.'&chco='.$_REQUEST['color'].'&chdlp=r" alt="Primer ejemplo con Google Chart API" /> </td></tr>';
echo "	</table>";
echo "<br>";
}

$querySum="select sum(conteo) as total from ($query) as sub"; //Total de Encuestas
$operacion = $objetobase->conexion->query($querySum);


$row=$operacion->fetchRow();
$total=$row['total'];
$operacion = $objetobase->conexion->query($query_as);


while ($row = $operacion->fetchRow()) {
	echo "	<tr><td>".$row['pregunta']."</td><td align='right'>".$row['conteo']."</td><td align='right'>".round($row['conteo']*100/$total,2)."%</td></tr>";
	if($row['pregunta']=='Si') {
		$operacion2 = $objetobase->conexion->query($query2);
		while ($row2 = $operacion2->fetchRow())
			echo "	<tr bgcolor='#E6E6E6'><td>&nbsp;&nbsp;&nbsp;".$row2['lugar']."</td><td align='right'>".$row2['conteo']."</td><td align='right'>".round($row2['conteo']*100/$row['conteo'],2)."%</td></tr>";
	}
}
echo "	<tr><td><label id='labelresaltado'>TOTAL</label></td><td align='right'><label id='labelresaltado'>$total</label></td><td align='right'><label id='labelresaltado'>&nbsp;</label></td></tr>";
echo "	</table>";

echo "	<br>";

echo "	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"100%\">
	<tr><td colspan='3'><label id='labelresaltado'><h3>Usted es?</h3></label></td></tr>";
$query="select eedf.descripcion as pregunta
		,coalesce(conteo,0) as conteo
	from estudianteegresadodatosformulario eedf
	left join (	select ustedesestudianteegresado
				,count(*) as conteo
			from (	select ee.idestudiantegeneral
					,ee.ustedesestudianteegresado
				from estudianteegresado ee
				join estudiante e on ee.idestudiantegeneral=e.idestudiantegeneral
				$where
				group by ee.idestudiantegeneral
					,ee.ustedesestudianteegresado
			) as sub
			group by ustedesestudianteegresado
	) as sub on eedf.valor=sub.ustedesestudianteegresado
	where eedf.clasificacion=2
	order by conteo desc";
$querySum="select sum(conteo) as total from ($query) as sub";
$operacion = $objetobase->conexion->query($querySum);
$row=$operacion->fetchRow();
$total=$row['total'];
$operacion = $objetobase->conexion->query($query);
while ($row = $operacion->fetchRow())
	echo "	<tr><td>".$row['pregunta']."</td><td align='right'>".$row['conteo']."</td><td align='right'>".round($row['conteo']*100/$total,2)."%</td></tr>";
echo "	<tr><td><label id='labelresaltado'>TOTAL</label></td><td align='right'><label id='labelresaltado'>$total</label></td><td align='right'><label id='labelresaltado'>&nbsp;</label></td></tr>";
echo "	</table>";

echo "	<br>";

echo "	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"100%\">
	<tr><td colspan='3'><label id='labelresaltado'><h3>En cu&aacute;l de los siguientes sectores est&aacute; ubicada su empresa?</h3></label></td></tr>";
$query="select eedf.descripcion as pregunta
		,coalesce(conteo,0) as conteo
	from estudianteegresadodatosformulario eedf
	left join (	select sectordondeseubicasuempresaestudianteegresado
				,count(*) as conteo
			from (	select ee.idestudiantegeneral
					,ee.sectordondeseubicasuempresaestudianteegresado
				from estudianteegresado ee
				join estudiante e on ee.idestudiantegeneral=e.idestudiantegeneral
				$where
				group by ee.idestudiantegeneral
					,ee.sectordondeseubicasuempresaestudianteegresado
			) as sub
			group by sectordondeseubicasuempresaestudianteegresado
	) as sub on eedf.valor=sub.sectordondeseubicasuempresaestudianteegresado
	where eedf.clasificacion=3
	order by conteo desc";
$querySum="select sum(conteo) as total from ($query) as sub";
$operacion = $objetobase->conexion->query($querySum);
$row=$operacion->fetchRow();
$total=$row['total'];
$operacion = $objetobase->conexion->query($query);
while ($row = $operacion->fetchRow())
	echo "	<tr><td>".$row['pregunta']."</td><td align='right'>".$row['conteo']."</td><td align='right'>".round($row['conteo']*100/$total,2)."%</td></tr>";
echo "	<tr><td><label id='labelresaltado'>TOTAL</label></td><td align='right'><label id='labelresaltado'>$total</label></td><td align='right'><label id='labelresaltado'>&nbsp;</label></td></tr>";
echo "	</table>";


echo "	<br>";


echo "	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"100%\">
	<tr><td colspan='3'><label id='labelresaltado'><h3>El nivel de coincidencia entre la actividad laboral actual y su carrera profesional es?</h3></label></td></tr>";
$query="select eedf.descripcion as pregunta
		,coalesce(conteo,0) as conteo
	from estudianteegresadodatosformulario eedf
	left join (	select coincidenciaactlaboralactualvscarreraestudianteegresado
				,count(*) as conteo
			from (	select ee.idestudiantegeneral
					,ee.coincidenciaactlaboralactualvscarreraestudianteegresado
				from estudianteegresado ee
				join estudiante e on ee.idestudiantegeneral=e.idestudiantegeneral
				$where
				group by ee.idestudiantegeneral
					,ee.coincidenciaactlaboralactualvscarreraestudianteegresado
			) as sub
			group by coincidenciaactlaboralactualvscarreraestudianteegresado
	) as sub on eedf.valor=sub.coincidenciaactlaboralactualvscarreraestudianteegresado
	where eedf.clasificacion=4
	order by conteo desc";
$querySum="select sum(conteo) as total from ($query) as sub";
$operacion = $objetobase->conexion->query($querySum);
$row=$operacion->fetchRow();
$total=$row['total'];
$operacion = $objetobase->conexion->query($query);
while ($row = $operacion->fetchRow())
	echo "	<tr><td>".$row['pregunta']."</td><td align='right'>".$row['conteo']."</td><td align='right'>".round($row['conteo']*100/$total,2)."%</td></tr>";
echo "	<tr><td><label id='labelresaltado'>TOTAL</label></td><td align='right'><label id='labelresaltado'>$total</label></td><td align='right'><label id='labelresaltado'>&nbsp;</label></td></tr>";
echo "	</table>";


echo "	<br>";


echo "	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"100%\">
	<tr><td colspan='3'><label id='labelresaltado'><h3>Qu&eacute; tipo de contrato de vinculaci&oacute;n tiene con la empresa en que labora actualmente?</h3></label></td></tr>";
$query="select eedf.descripcion as pregunta
		,coalesce(conteo,0) as conteo
	from estudianteegresadodatosformulario eedf
	left join (	select tipocontratoactualestudianteegresado
				,count(*) as conteo
			from (	select ee.idestudiantegeneral
					,ee.tipocontratoactualestudianteegresado
				from estudianteegresado ee
				join estudiante e on ee.idestudiantegeneral=e.idestudiantegeneral
				$where
				group by ee.idestudiantegeneral
					,ee.tipocontratoactualestudianteegresado
			) as sub
			group by tipocontratoactualestudianteegresado
	) as sub on eedf.valor=sub.tipocontratoactualestudianteegresado
	where eedf.clasificacion=5
	order by conteo desc";
$querySum="select sum(conteo) as total from ($query) as sub";
$operacion = $objetobase->conexion->query($querySum);
$row=$operacion->fetchRow();
$total=$row['total'];
$operacion = $objetobase->conexion->query($query);
while ($row = $operacion->fetchRow())
	echo "	<tr><td>".$row['pregunta']."</td><td align='right'>".$row['conteo']."</td><td align='right'>".round($row['conteo']*100/$total,2)."%</td></tr>";


echo "	<tr><td><label id='labelresaltado'>TOTAL</label></td><td align='right'><label id='labelresaltado'>$total</label></td><td align='right'><label id='labelresaltado'>&nbsp;</label></td></tr>";
echo "	</table>";


echo "	<br>";


echo "	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"100%\">
	<tr><td colspan='3'><label id='labelresaltado'><h3>Cu&aacute;l es su ingreso salarial actual?</h3></label></td></tr>";
$query="select eedf.descripcion as pregunta
		,coalesce(conteo,0) as conteo
	from estudianteegresadodatosformulario eedf
	left join (	select ingresosalarialactualestudianteegresado
				,count(*) as conteo
			from (	select ee.idestudiantegeneral
					,ee.ingresosalarialactualestudianteegresado
				from estudianteegresado ee
				join estudiante e on ee.idestudiantegeneral=e.idestudiantegeneral
				$where
				group by ee.idestudiantegeneral
					,ee.ingresosalarialactualestudianteegresado
			) as sub
			group by ingresosalarialactualestudianteegresado
	) as sub on eedf.valor=sub.ingresosalarialactualestudianteegresado
	where eedf.clasificacion=6
	order by conteo desc";
$querySum="select sum(conteo) as total from ($query) as sub";
$operacion = $objetobase->conexion->query($querySum);
$row=$operacion->fetchRow();
$total=$row['total'];
$operacion = $objetobase->conexion->query($query);
while ($row = $operacion->fetchRow())
	echo "	<tr><td>".$row['pregunta']."</td><td align='right'>".$row['conteo']."</td><td align='right'>".round($row['conteo']*100/$total,2)."%</td></tr>";
echo "	<tr><td><label id='labelresaltado'>TOTAL</label></td><td align='right'><label id='labelresaltado'>$total</label></td><td align='right'><label id='labelresaltado'>&nbsp;</label></td></tr>";
echo "	</table>";

echo "	<br>";

echo "	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"100%\">
	<tr><td colspan='3'><label id='labelresaltado'><h3>Tiene carnet de egresado?</h3></label></td></tr>";
$query="select eedf.descripcion as pregunta
		,coalesce(conteo,0) as conteo
	from estudianteegresadodatosformulario eedf
	left join (	select tienecarnetegresadoestudianteegresado
				,count(*) as conteo
			from (	select ee.idestudiantegeneral
					,ee.tienecarnetegresadoestudianteegresado
				from estudianteegresado ee
				join estudiante e on ee.idestudiantegeneral=e.idestudiantegeneral
				$where
				group by ee.idestudiantegeneral
					,ee.tienecarnetegresadoestudianteegresado
			) as sub
			group by tienecarnetegresadoestudianteegresado
	) as sub on eedf.valor=sub.tienecarnetegresadoestudianteegresado
	where eedf.clasificacion=1
	order by conteo desc";
$querySum="select sum(conteo) as total from ($query) as sub";
$operacion = $objetobase->conexion->query($querySum);
$row=$operacion->fetchRow();
$total=$row['total'];
$operacion = $objetobase->conexion->query($query);
while ($row = $operacion->fetchRow())
	echo "	<tr><td>".$row['pregunta']."</td><td align='right'>".$row['conteo']."</td><td align='right'>".round($row['conteo']*100/$total,2)."%</td></tr>";
echo "	<tr><td><label id='labelresaltado'>TOTAL</label></td><td align='right'><label id='labelresaltado'>$total</label></td><td align='right'><label id='labelresaltado'>&nbsp;</label></td></tr>";
echo "	</table>";



echo "	<br><hr>";


$query2="select c.nombreciudad
		,sub.conteo
	from ciudad c
	join (	select ciudadresidenciaestudiantegeneral
			,count(ciudadresidenciaestudiantegeneral) as conteo
		from estudiante e
		join estudiantegeneral eg on e.idestudiantegeneral=eg.idestudiantegeneral
		join (select codigoestudiante from registrograduado union select codigoestudiante from registrograduadoantiguo) as sub on e.codigoestudiante=sub.codigoestudiante
		$where
		group by ciudadresidenciaestudiantegeneral
	) as sub on c.idciudad=sub.ciudadresidenciaestudiantegeneral
	order by conteo desc";


$query=" select sum(conteo) as conteo from ($query2) as sub";
$operacion = $objetobase->conexion->query($query);
$total=$operacion->fields['conteo'];

echo "<label id='labelresaltado'><h1>Total estudiantes egresados : $total</h1></label>";

echo "	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"100%\">
	<tr><th colspan='3'><label id='labelresaltado'><h3>Ciudad residencia</h3></label></th></tr>
	<tr>
		<th><label id='labelresaltado'>Ciudad</label></th>
		<th><label id='labelresaltado'>Resultado</label></th>
		<th><label id='labelresaltado'>Porcentaje</label></th>
	</tr>";

$operacion2 = $objetobase->conexion->query($query2);
while ($row = $operacion2->fetchRow())
	echo "	<tr><td>".$row['nombreciudad']."</td><td align='right'>".$row['conteo']."</td><td align='right'>".round($row['conteo']*100/$total,2)."%</td></tr>";
echo "	</table>";

echo "	</form>";
?>
        </tr>
</table>