<?php
require('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
require_once("estudiante.php");

/*if(isset($_SESSION['debug_sesion']))
{
   //$db->debug = true;
}
//print_r($_SERVER);*/
//$db->debug = true;

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Listado de Históricos</title>
<link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
<SCRIPT language="JavaScript" type="text/javascript">
function enviar()
{

    document.form1.submit();
}
</SCRIPT>
</head>
<body>
<form name="form1" id="form1"  method="POST">
<?php

            $query_selec = "select * from carrera
            where codigomodalidadacademica like '2%'
            and now() between fechainiciocarrera and fechavencimientocarrera
            order by nombrecarrera";
            $selec = $db->Execute($query_selec);
            $totalRows_selec = $selec->RecordCount();
            ?>
             <select name="selec" id="selec" onchange="enviar()" >
            <option value="todas">Todas</option>
            <?php while($row_selec = $selec->FetchRow()){?>
            <option value="<?php echo $row_selec['codigocarrera']?>"

<?php
 if ($row_selec['codigocarrera']==$_POST['selec']) {
                        echo "Selected";

                    }
?>>
                                <?php echo $row_selec['nombrecarrera'];
                                ?>
                            </option><?php }?>
                            </select></br>

<?php
if($_POST['selec'] == "todas") {
    $query_carrera = "select * from carrera
            where codigomodalidadacademica like '2%'
            and now() between fechainiciocarrera and fechavencimientocarrera
            order by nombrecarrera";
}
else
    $query_carrera = "select codigocarrera from carrera where codigocarrera='".$_POST['selec']."'";
$carrera = $db->Execute($query_carrera);
$totalRows_carrera = $carrera->RecordCount();
?>
</br>
</br>
<TABLE border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
    <TR id=trtitulogris>
        <TD>Carrera</TD>
        <TD>Total estudiantes</TD>
        <TD>Total estudiantes Diligenciados</TD>
    </TR>
<?php
while($row_carrera = $carrera->FetchRow()) {
    unset($Arrayestudiantes);
    $query_estudiante="SELECT eg.idestudiantegeneral,eg.numerodocumento,eg.nombresestudiantegeneral Nombres,eg.apellidosestudiantegeneral Apellidos, c.codigocarrera, c.nombrecarrera
        FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr, estudiantegeneral eg
        WHERE o.numeroordenpago=d.numeroordenpago
    and eg.idestudiantegeneral=e.idestudiantegeneral
        AND pr.codigoperiodo='20092'
        AND e.codigoestudiante=pr.codigoestudiante
        AND e.codigoestudiante=o.codigoestudiante
        AND c.codigocarrera=e.codigocarrera
        AND d.codigoconcepto=co.codigoconcepto
        AND co.cuentaoperacionprincipal=151
        AND e.codigocarrera='".$row_carrera['codigocarrera']."'
        AND o.codigoperiodo='20092'
        AND o.codigoestadoordenpago LIKE '4%'
        GROUP by e.codigoestudiante";

    $estudiante = $db->Execute($query_estudiante);
        $totalRows_estudiante = $estudiante->RecordCount();
        //$row_estudiantecarrera = $estudiantecarrera->FetchRow();
    $cuenta = 0;
    while ($row_estudiante=$estudiante->fetchRow()){
        if($row_estudiante['codigocarrera'] == $row_carrera['codigocarrera']) {
            $cuenta++;
            //echo "$cuenta -- ";
            $estudiantetest=new estudiante();
            $estudiantetest->atributos($row_estudiante['idestudiantegeneral'], $row_estudiante['codigocarrera'], $row_estudiante['apellidosestudiantegeneral'], $row_estudiante['nombresestudiantegeneral']);
            //$estudiantetest->imprimir();
            $Arrayestudiantes[$row_estudiante['nombrecarrera']][] = $estudiantetest;
        }
    }
    //echo "<h1>$cuenta</h1>";
    if(is_array($Arrayestudiantes)) {
?>
<TR>
<?php
        foreach($Arrayestudiantes as $nombreCarrera => $aestudianteCarrera) {
?>
<TD id=tdtitulogris><?php echo $nombreCarrera; ?> </TD>
<?php
    $totalestudiantes = count($Arrayestudiantes[$nombreCarrera]);
?>
<TD><?php echo $totalestudiantes; ?> </TD>
<?php
    $cuentaFormularios = array(
        0 => 0,
        1 => 0,
        2 => 0,
        3 => 0,
        4 => 0,
        5 => 0,
        6 => 0,
        7 => 0,
        8 => 0,
        9 => 0,
        10 => 0,
        11=>0,
        12=>0,
        13=>0,
        14=>0,
        15=>0,
        16=>0
    );
            //echo "<h1>$totalestudiantes</h1>";
            foreach($aestudianteCarrera as $estudiante) {
                unset($aFormularios);
                $cuentaFormularios[$estudiante->cuentaformulariosiniciados]++;
            }
?>
<TD>
<TABLE border="1" width="100%" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
<tr id=trtitulogris><TD>Número Formularios</TD><TD>Total estudiantes X Formulario</TD></tr>
<?php
            foreach($cuentaFormularios as $numeroformularios => $totalestudiantesformulario) {
       ?><TR>
<TD><?php echo $numeroformularios;?>
</TD>
<TD><?php echo $totalestudiantesformulario;?>
</TD>
</TR>
<?php
        //echo "$numeroformularios => $totalestudiantesformulario<br>";
            }
?>
</table>
</TD>
<?php
        }
?>
</TR>
<?php
    }
}
?>

</TABLE>
</form>
</body>
</html>