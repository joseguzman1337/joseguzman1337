<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../../../Connections/sala2.php');
require_once("../../../../funciones/validacion.php");
require_once("../../../../funciones/errores_plandeestudio.php");
require("../funcionesequivalencias.php");
mysql_select_db($database_sala, $sala);
session_start();
require_once('../seguridadplandeestudio.php');
if(isset($_GET['planestudio']))
{
    //echo "adssad $tipomateria";
    $idplanestudio = $_GET['planestudio'];
    $materiaAreferenciar = $_GET['codigodemateria'];
    $tipomateria = $_GET['tipomateriaenplan'];
    $idlineaenfasis = $_GET['lineaenfasis'];
    //echo "sdasd $tipomateria";
    if($tipomateria == 5)
    {
        $query_selidlinea= "select idlineaenfasisplanestudio
        from detallelineaenfasisplanestudio
        where idplanestudio = '$idplanestudio'
        and codigomateriadetallelineaenfasisplanestudio = '$materiaAreferenciar'
        and codigotipomateria = '5'";
        //echo "$query_selidlinea";
        $selidlinea = mysql_query($query_selidlinea, $sala) or die("$query_selidlinea");
        $totalRows_selidlinea = mysql_num_rows($selidlinea);
        $row_selidlinea = mysql_fetch_assoc($selidlinea);
        $idlineamodificar = $row_selidlinea['idlineaenfasisplanestudio'];
    }
    else
    {
        $idlineamodificar = 1;
    }
}
$query_datomateria = "select nombremateria
from materia
where codigomateria = '".$_GET['codigodemateria']."'";
$datomateria = mysql_query($query_datomateria, $sala) or die("$query_datomateria");
$totalRows_datomateria = mysql_num_rows($datomateria);
$row_datomateria = mysql_fetch_assoc($datomateria);

?>
<html>
<head>
<title>Opciones de Referencia Plan de Estudio</title>
<link rel="stylesheet" href="../../../../estilos/sala.css" type="text/css"><style type="text/css">
<!--
.Estilo3 {
    font-size: 11px;
    font-weight: bold;
}
-->
</style>
</head><style type="text/css">
<!--
.Estilo1 {
    font-family: Tahoma;
    font-size: x-small;
}
.Estilo4 {font-size: 11px}
-->
</style>
<body>
<div align="center">
<form name="f1" method="post">
<p align="center"><strong> REFERENCIAS DE <?php echo $row_datomateria['nombremateria']; ?> </strong></p>
<?php
$query_selprerequisitos = "select r.codigomateriareferenciaplanestudio, m.nombremateria
from referenciaplanestudio r, materia m
where r.idplanestudio = '$idplanestudio'
and r.codigomateria = '".$_GET['codigodemateria']."'
and r.idlineaenfasisplanestudio = '1'
and r.codigotiporeferenciaplanestudio = '100'
and m.codigomateria = r.codigomateriareferenciaplanestudio";
//echo "UNO: $query_selprerequisitos <br>";
$selprerequisitos = mysql_query($query_selprerequisitos, $sala) or die("$query_selprerequisitos");
$totalRows_selprerequisitos = mysql_num_rows($selprerequisitos);
//$row_selprerequisitos = mysql_fetch_assoc($selprerequisitos);
if($totalRows_selprerequisitos == "")
{
    $query_selprerequisitos = "select r.codigomateriareferenciaplanestudio, m.nombremateria
    from referenciaplanestudio r, materia m
    where r.idplanestudio = '$idplanestudio'
    and r.codigomateria = '".$_GET['codigodemateria']."'
    and r.idlineaenfasisplanestudio = '$idlineamodificar'
    and r.codigotiporeferenciaplanestudio = '100'
    and m.codigomateria = r.codigomateriareferenciaplanestudio";
    //echo "DOS: $query_selprerequisitos <br>";
    $selprerequisitos = mysql_query($query_selprerequisitos, $sala) or die("$query_selprerequisitos");
    $totalRows_selprerequisitos = mysql_num_rows($selprerequisitos);
}
if($totalRows_selprerequisitos != "")
{
?>
<table border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr id="trtitulogris">
        <td align="center" bgcolor="#C5D5D6" colspan="2"><span>PREREQUISITOS</span></td>
  </tr>
  <tr id="trtitulogris">
        <td align="center" bgcolor="#C5D5D6"><span>CODIGO</span></td>
        <td align="center" bgcolor="#C5D5D6"><span>NOMBRE</span></td>
  </tr>
<?php
    while($row_selprerequisitos = mysql_fetch_assoc($selprerequisitos))
    {
?>
  <tr id="trtitulogris">
    <td><?php echo $row_selprerequisitos['codigomateriareferenciaplanestudio']?></td>
    <td><?php echo $row_selprerequisitos['nombremateria']?></td>
  </tr>

<?php
    }
?>
</table>
<br><br>
<?php
}
$query_selcorequisitos = "select r.codigomateriareferenciaplanestudio, m.nombremateria
from referenciaplanestudio r, materia m
where r.idplanestudio = '$idplanestudio'
and r.codigomateria = '".$_GET['codigodemateria']."'
and r.idlineaenfasisplanestudio = '1'
and r.codigotiporeferenciaplanestudio = '200'
and m.codigomateria = r.codigomateriareferenciaplanestudio";
$selcorequisitos = mysql_query($query_selcorequisitos, $sala) or die("$query_selcorequisitos");
$totalRows_selcorequisitos = mysql_num_rows($selcorequisitos);
if($totalRows_selcorequisitos == "")
{
    $query_selcorequisitos = "select r.codigomateriareferenciaplanestudio, m.nombremateria
    from referenciaplanestudio r, materia m
    where r.idplanestudio = '$idplanestudio'
    and r.codigomateria = '".$_GET['codigodemateria']."'
    and r.idlineaenfasisplanestudio = '$idlineaenfasis'
    and r.codigotiporeferenciaplanestudio = '200'
    and m.codigomateria = r.codigomateriareferenciaplanestudio";
    $selcorequisitos = mysql_query($query_selcorequisitos, $sala) or die("$query_selcorequisitos");
    $totalRows_selcorequisitos = mysql_num_rows($selcorequisitos);
}
if($totalRows_selcorequisitos != "")
{
?>
<table border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr id="trtitulogris">
        <td align="center" bgcolor="#C5D5D6" colspan="2"><span class="Estilo3">COREQUISITOS DOBLES </span></td>
  </tr>
  <tr id="trtitulogris">
        <td align="center" bgcolor="#C5D5D6"><span class="Estilo3">CODIGO</span></td>
        <td align="center" bgcolor="#C5D5D6"><span class="Estilo3">NOMBRE</span></td>
  </tr>
<?php
    while($row_selcorequisitos = mysql_fetch_assoc($selcorequisitos))
    {
?>
  <tr id="trtitulogris">
    <td><span class="Estilo4"><?php echo $row_selcorequisitos['codigomateriareferenciaplanestudio']?></span></td>
    <td><span class="Estilo4"><?php echo $row_selcorequisitos['nombremateria']?></span></td>
  </tr>

<?php
    }
?>
</table>
<br><br>
<?php
}
$query_selcorequisitosencillo = "select r.codigomateriareferenciaplanestudio, m.nombremateria
from referenciaplanestudio r, materia m
where r.idplanestudio = '$idplanestudio'
and r.codigomateria = '".$_GET['codigodemateria']."'
and r.idlineaenfasisplanestudio = '1'
and r.codigotiporeferenciaplanestudio = '201'
and m.codigomateria = r.codigomateriareferenciaplanestudio";
$selcorequisitosencillo = mysql_query($query_selcorequisitosencillo, $sala) or die("$query_selcorequisitosencillo");
$totalRows_selcorequisitosencillo = mysql_num_rows($selcorequisitosencillo);
//$row_selprerequisitos = mysql_fetch_assoc($selprerequisitos);
if($totalRows_selcorequisitosencillo == "")
{
    $query_selcorequisitosencillo = "select r.codigomateriareferenciaplanestudio, m.nombremateria
    from referenciaplanestudio r, materia m
    where r.idplanestudio = '$idplanestudio'
    and r.codigomateria = '".$_GET['codigodemateria']."'
    and r.idlineaenfasisplanestudio = '$idlineaenfasis'
    and r.codigotiporeferenciaplanestudio = '201'
    and m.codigomateria = r.codigomateriareferenciaplanestudio";
    $selcorequisitosencillo = mysql_query($query_selcorequisitosencillo, $sala) or die("$query_selcorequisitosencillo");
    $totalRows_selcorequisitosencillo = mysql_num_rows($selcorequisitosencillo);
    //$row_selprerequisitos = mysql_fetch_assoc($selprerequisitos);
}
if($totalRows_selcorequisitosencillo != "")
{
?>
<table border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr id="trtitulogris">
        <td align="center" bgcolor="#C5D5D6" colspan="2"><span class="Estilo3">COREQUISITOS SENCILLOS </span></td>
  </tr>
  <tr id="trtitulogris">
        <td align="center" bgcolor="#C5D5D6"><span class="Estilo3">CODIGO</span></td>
        <td align="center" bgcolor="#C5D5D6"><span class="Estilo3">NOMBRE</span></td>
  </tr>
<?php
    while($row_selcorequisitosencillo = mysql_fetch_assoc($selcorequisitosencillo))
    {
?>
  <tr id="trtitulogris">
    <td><span class="Estilo4"><?php echo $row_selcorequisitosencillo['codigomateriareferenciaplanestudio']?></span></td>
    <td><span class="Estilo4"><?php echo $row_selcorequisitosencillo['nombremateria']?></span></td>
  </tr>

<?php
    }
?>
</table>
<br><br>
<?php
}
$query_selequivalencias = "select r.codigomateriareferenciaplanestudio, m.nombremateria
from referenciaplanestudio r, materia m
where r.idplanestudio = '$idplanestudio'
and r.codigomateria = '".$_GET['codigodemateria']."'
and r.idlineaenfasisplanestudio = '1'
and r.codigotiporeferenciaplanestudio = '300'
and m.codigomateria = r.codigomateriareferenciaplanestudio";
$selequivalencias = mysql_query($query_selequivalencias, $sala) or die("$query_selequivalencias");
$totalRows_selequivalencias = mysql_num_rows($selequivalencias);
//$row_selprerequisitos = mysql_fetch_assoc($selprerequisitos);
if($totalRows_selequivalencias == "")
{
    $query_selequivalencias = "select r.codigomateriareferenciaplanestudio, m.nombremateria
    from referenciaplanestudio r, materia m
    where r.idplanestudio = '$idplanestudio'
    and r.codigomateria = '".$_GET['codigodemateria']."'
    and r.idlineaenfasisplanestudio = '$idlineaenfasis'
    and r.codigotiporeferenciaplanestudio = '300'
    and m.codigomateria = r.codigomateriareferenciaplanestudio";
    $selequivalencias = mysql_query($query_selequivalencias, $sala) or die("$query_selequivalencias");
    $totalRows_selequivalencias = mysql_num_rows($selequivalencias);
    //$row_selprerequisitos = mysql_fetch_assoc($selprerequisitos);
}
if($totalRows_selequivalencias != "")
{
?>
<table border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr id="trtitulogris">
        <td align="center" bgcolor="#C5D5D6" colspan="2"><span>EQIVALENCIAS</span></td>
  </tr>
  <tr id="trtitulogris">
        <td align="center" bgcolor="#C5D5D6"><span>CODIGO</span></td>
        <td align="center" bgcolor="#C5D5D6"><span>NOMBRE</span></td>
  </tr>
<?php
//  if(isset($Arregloequivalencias))
//  {
    while($row_selequivalencias = mysql_fetch_assoc($selequivalencias))
    {
?>
  <tr id="trtitulogris">
    <td><?php echo $row_selequivalencias['codigomateriareferenciaplanestudio'] ?></td>
    <td><?php echo $row_selequivalencias['nombremateria']; ?></td>
  </tr>

<?php
    }
?>
</table>
<?php
}
?>
</form>
</div>
</body>
</html>
