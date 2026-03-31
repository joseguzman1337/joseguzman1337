<?php
//session_start();
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">

<script LANGUAGE="JavaScript">
    function  ventanaprincipal(pagina){
        opener.focus();
        opener.location.href=pagina.href;
        window.close();
        return false;
    }
    function reCarga(){
        document.location.href="<?php echo 'listadoriesgos.php';?>";

    }
    function regresarGET()
    {
        document.location.href="<?php echo 'listadoriesgos.php';?>";
    }

</script>
<?php
$rutaado=("../../../funciones/adodb/");
require_once('../../../funciones/sala/nota/nota.php');
require_once('../../../funciones/sala/estudiante/estudiante.php');
require_once('../../../Connections/sala2.php');
//$rutazado = "../../../funciones/zadodb/";
require_once('../../../Connections/salaado.php');
require_once('../../../funciones/sala/nota/nota.php');
require ('../../../funciones/notas/redondeo.php');
require('../../../funciones/notas/funcionequivalenciapromedio.php');


//print_r($_POST);
// De acuerdo a la sesión y a lo que venga por get muestra el detalle
echo "<pre>";
//print_r($_SESSION);
echo "</pre>";

if(isset($_REQUEST['debug']))
    $db->debug = true;
// Selecciona los datos de la materia

$query_materia = "select m.codigomateria, m.nombremateria, g.idgrupo, g.nombregrupo, concat(d.apellidodocente,' ', d.nombredocente) as nombre
from materia m, grupo g, docente d
where m.codigomateria = g.codigomateria
and g.idgrupo = '".$_REQUEST["idgrupo"]."'
and g.numerodocumento = d.numerodocumento";
$materia = $db->Execute($query_materia);
$totalRows_materia = $materia->RecordCount();
if($totalRows_materia == "") {
    $query_materia = "select m.codigomateria, m.nombremateria, g.idgrupo, g.nombregrupo, concat(d.apellidodocente,' ', d.nombredocente) as nombre
    from materia m, grupo g, docente d
    where m.codigomateria = g.codigomateria
    and g.codigomateria = '".$_SESSION['codigomateriariesgo']."'
    and g.codigoperiodo = '".$_SESSION['codigoperiodoriesgo']."'
    and g.numerodocumento = d.numerodocumento";
    $materia = $db->Execute($query_materia);
    $totalRows_materia = $materia->RecordCount();
}

function encuentra_array_estudiantes($codigomateria, $codigocarrera, $codigomodalidadacademica, $codigoperiodo, $riesgo, $idgrupo="") {
    global $db;
    
    //$db->debug = true;
    if($idgrupo != "")
        $idgrupodestino = "and g.idgrupo = $idgrupo";
    if($codigocarrera!="todos")
        $carreradestino="AND c.codigocarrera='".$codigocarrera."'";
    else
        $carreradestino="";

    if($codigomateria!="todos")
        $materiadestino= "AND m.codigomateria='".$codigomateria."'";
    else
        $materiadestino= "";

    $query_estudiantes = "select c.codigocarrera, c.nombrecarrera, m.codigomateria, m.nombremateria,
    g.idgrupo, g.codigoperiodo, p.codigoestudiante, m.codigomateria, e.codigoperiodo
	from  grupo g, materia m, carrera c, detalleprematricula dp, prematricula p, estudiantegeneral eg, estudiante e
	where g.codigomateria = m.codigomateria
	and g.codigoperiodo = $codigoperiodo
            $carreradestino
            $materiadestino
            $idgrupodestino
	and m.codigocarrera = c.codigocarrera
	and c.codigomodalidadacademica = $codigomodalidadacademica
	and dp.idgrupo = g.idgrupo
	and dp.codigoestadodetalleprematricula like '3%'
	and p.codigoperiodo = g.codigoperiodo
	and dp.idprematricula = p.idprematricula
	and e.codigoestudiante = p.codigoestudiante
	and eg.idestudiantegeneral = e.idestudiantegeneral
	order by eg.apellidosestudiantegeneral";
    $estudiantes = $db->Execute($query_estudiantes);
    $totalRows_estudiantes = $estudiantes->RecordCount();

    //$db->debug = true;

    while($row_estudiantes = $estudiantes->FetchRow()) {
        unset($detallenota);

        $detallenota = new detallenota($row_estudiantes['codigoestudiante'], $codigoperiodo);
        
        $detallenota->setAcumuladoCertificado("1");
        /*if(22545 == $row_estudiantes['codigoestudiante'])
        	echo "<pre>"; print_r($detallenota); echo "</pre>";*/
        //if ($detallenota->tieneNotasXMateria($row_estudiantes['codigomateria']))
        {
            if($riesgo != "Estudiantes_Matriculados") {
                if($detallenota->esAltoRiesgoXMateria($codigomateria, $idgrupo)) {
                    if($riesgo != "Riesgo_Alto") {
                        /*if(22545 == $row_estudiantes['codigoestudiante'])
			        		echo "1 ".$riesgo;*/
                        continue;
                    }
                }
                elseif($detallenota->esMedianoRiesgoXMateria($codigomateria)) {
                    if($riesgo != "Riesgo_Medio") {
                        /*if(22545 == $row_estudiantes['codigoestudiante'])
			        		echo "2 ".$riesgo;*/
                        continue;
                    }
                }
                elseif($detallenota->esBajoRiesgoXMateria($codigomateria)) {
                    if($riesgo != "Riesgo_Bajo") {
                        /*if(22545 == $row_estudiantes['codigoestudiante'])
			        		echo "3 ".$riesgo;*/
                        continue;
                    }
                }
                else {
                    if($riesgo != "Sin_Riesgo") {
                        /*if(22545 == $row_estudiantes['codigoestudiante'])
			        		echo "4 ".$riesgo;*/
                        continue;
                    }
                }
            }
        }
        /*else
    	{
	    	if($riesgo != "Sin_Riesgo")
		        	continue;
	    }*/
        $array_interno[] = $row_estudiantes['codigoestudiante'];
        /*if(22545 == $row_estudiantes['codigoestudiante'])
	    {
	    	echo $riesgo;
	    	//exit();
	    }*/
    }
    return $array_interno;
}

$arrayEstudiantes = encuentra_array_estudiantes($_SESSION['codigomateriariesgo'], $_SESSION['codigocarrerariesgo'], $_SESSION['codigomodalidadacademicariesgo'], $_SESSION['codigoperiodoriesgo'], $_REQUEST["riesgo"], $_REQUEST["idgrupo"]);

if(count($arrayEstudiantes) > 0) {
    foreach($arrayEstudiantes as $key => $codigoestudiante) {
        $estudiantes[] = new estudiante($codigoestudiante, $_SESSION['codigoperiodoriesgo']);
    }
}
//print_r($estudiantes);
$columnas = array(
        'codigoestudiante' => 'Código', 'numerodocumento' => 'Documento',
        'nombresestudiantegeneral' => 'Nombres', 'apellidosestudiantegeneral' => 'Apellidos',
        'codigocarrera' => 'Carrera', 'semestre' => 'Semestre', 'codigoperiodo' => 'Periodo de Ingreso'
);

$links = array(
        'codigoestudiante' => 'estudianteriesgos.php?codigoestudiante='
);
?>
<h3>Detalle Estudiantes <?php echo $_REQUEST['riesgo'];?></h3>
<table border="1" cellspacing="0" cellpadding="0" width="50%">
    <tr id="trtitulogris">
        <td>Nombre de la materia</td>
        <td>Id Grupo</td>
        <td>Nombre del grupo Grupo</td>
        <td>Docente</td>
    </tr>
<?php
while($row_materia = $materia->FetchRow()) {
?>
    <tr>
        <td><?php echo $row_materia['nombremateria']; ?></td>
        <td><?php echo $row_materia['idgrupo']; ?></td>
        <td><?php echo $row_materia['nombregrupo']; ?></td>
        <td><?php echo $row_materia['nombre']; ?></td>
    </tr>
<?php
}
?>
</table>
<br>
<br>
<?php
if(count($arrayEstudiantes) > 0) {
    imprimirEstudiantes($estudiantes, $columnas, $links);
}
else {
    echo "No hay registros con el criterio específicado";
}
?>
<table border="1" cellspacing="0" cellpadding="0" width="50%">
    <tr>
        <td><input type="button" onclick="regresarGET()" value="Regresar"> <input type="button" name="imprimir" value="Imprimir" onClick="window.print()"></td>
    </tr>
</table>

