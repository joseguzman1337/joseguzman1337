<?php
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
require_once('../../../funciones/clases/autenticacion/redirect.php');
//mysql_select_db($database_sala, $sala);
session_start();
$codigocarrera = $_SESSION['codigofacultad'];
$codigoperiodo = $_SESSION['codigoperiodosesion'];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Reporte Gestión Docentes</title>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
</head>
<body>
<p>REPORTE DE GESTION DE DOCENTES</p>
<form action="" method="post" name="f1">
<table width="70%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
  <tr>
  <td colspan="2"><label id="labelresaltado">Facultad: <?php echo $_SESSION['nombrefacultad'].' - '.$codigocarrera; ?></td>
  </tr>
  <tr>
    <td id="tdtitulogris">Seleccione la materia y grupo que desee</td>
    <td>
    <select name="codigomateria_idgrupo" onChange="document.f1.submit()">
        <option value="0">Seleccionar Materia</option>
<?php
$query_grupos = "SELECT CONCAT(m.nombremateria,' - G:',g.idgrupo)  as nombre, g.codigomateria, g.idgrupo
FROM materia m, grupo g
WHERE m.codigomateria = g.codigomateria
and m.codigoestadomateria = '01'
and m.codigocarrera = '$codigocarrera'
and g.codigoperiodo = '$codigoperiodo'
and g.codigoestadogrupo = 10
order by nombre";
$grupos = $db->Execute($query_grupos);
$totalRows_grupos = $grupos->RecordCount();
while($row_grupos = $grupos->FetchRow()) :
    $idnombre = $row_grupos['codigomateria'].'-'.$row_grupos['idgrupo'];
    $selected = '';
    if($idnombre == $_POST['codigomateria_idgrupo'])
         $selected = 'selected="true"';
?>
    <option value="<?php echo $idnombre;?>" <?php echo $selected; ?>><?php echo $row_grupos['nombre'];?></option>
<?php
endwhile;
?>
    </select>
    </td>
  </tr>
</table>
</form>
<?php
//print_r($_SESSION);
//print_r($_POST);
if(isset($_POST['codigomateria_idgrupo']))
{
    if($_POST['codigomateria_idgrupo'] != 0)
        require_once("reporte.php");
}
?>
</body>
</html>
