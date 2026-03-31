<?php require_once('../../../../Connections/sala.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_sala = 10;
$pageNum_sala = 0;
if (isset($_GET['pageNum_sala'])) {
  $pageNum_sala = $_GET['pageNum_sala'];
}
$startRow_sala = $pageNum_sala * $maxRows_sala;

mysql_select_db($database_sala, $sala);
$query_sala = "SELECT * FROM auditoria ORDER BY idauditoria ASC";
$query_limit_sala = sprintf("%s LIMIT %d, %d", $query_sala, $startRow_sala, $maxRows_sala);
$sala = mysql_query($query_limit_sala, $sala) or die(mysql_error());
$row_sala = mysql_fetch_assoc($sala);

if (isset($_GET['totalRows_sala'])) {
  $totalRows_sala = $_GET['totalRows_sala'];
} else {
  $all_sala = mysql_query($query_sala);
  $totalRows_sala = mysql_num_rows($all_sala);
}
$totalPages_sala = ceil($totalRows_sala/$maxRows_sala)-1;

$queryString_sala = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_sala") == false && 
        stristr($param, "totalRows_sala") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_sala = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_sala = sprintf("&totalRows_sala=%d%s", $totalRows_sala, $queryString_sala);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_sala > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_sala=%d%s", $currentPage, 0, $queryString_sala); ?>"><img src="First.gif" border=0></a>
      <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_sala > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_sala=%d%s", $currentPage, max(0, $pageNum_sala - 1), $queryString_sala); ?>"><img src="Previous.gif" border=0></a>
      <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_sala < $totalPages_sala) { // Show if not last page ?>
      <a href="<?php printf("%s?pageNum_sala=%d%s", $currentPage, min($totalPages_sala, $pageNum_sala + 1), $queryString_sala); ?>"><img src="Next.gif" border=0></a>
      <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_sala < $totalPages_sala) { // Show if not last page ?>
      <a href="<?php printf("%s?pageNum_sala=%d%s", $currentPage, $totalPages_sala, $queryString_sala); ?>"><img src="Last.gif" border=0></a>
      <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<p>&nbsp;</p>

<table border="1">
  <tr>
    <td>idauditoria</td>
    <td>numerodocumento</td>
    <td>usuario</td>
    <td>fechaauditoria</td>
    <td>codigomateria</td>
    <td>grupo</td>
    <td>codigoestudiante</td>
    <td>notaanterior</td>
    <td>notamodificada</td>
    <td>corte</td>
    <td>tipoauditoria</td>
    <td>observacion</td>
    <td>ip</td>
  </tr>
  <?php do { ?>
  <tr>
    <td><?php echo $row_sala['idauditoria']; ?></td>
    <td><?php echo $row_sala['numerodocumento']; ?></td>
    <td><?php echo $row_sala['usuario']; ?></td>
    <td><?php echo $row_sala['fechaauditoria']; ?></td>
    <td><?php echo $row_sala['codigomateria']; ?></td>
    <td><?php echo $row_sala['grupo']; ?></td>
    <td><?php echo $row_sala['codigoestudiante']; ?></td>
    <td><?php echo $row_sala['notaanterior']; ?></td>
    <td><?php echo $row_sala['notamodificada']; ?></td>
    <td><?php echo $row_sala['corte']; ?></td>
    <td><?php echo $row_sala['tipoauditoria']; ?></td>
    <td><?php echo $row_sala['observacion']; ?></td>
    <td><?php echo $row_sala['ip']; ?></td>
  </tr>
  <?php } while ($row_sala = mysql_fetch_assoc($sala)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($sala);
?>
