<?php require_once('../../../Connections/sala2.php'); ?>
<?php
// Load the common classes
require_once('../../../../includes/common/KT_common.php');

// Load the required classes
require_once('../../../../includes/tfi/TFI.php');
require_once('../../../../includes/tso/TSO.php');
require_once('../../../../includes/nav/NAV.php');

// Make unified connection variable
$conn_sala = new KT_connection($sala, $database_sala);

// Filter
$tfi_listmenuopcion3 = new TFI_TableFilter($conn_sala, "tfi_listmenuopcion3");
$tfi_listmenuopcion3->addColumn("menuopcion.nombremenuopcion", "STRING_TYPE", "nombremenuopcion", "%");
$tfi_listmenuopcion3->addColumn("menuopcion.linkmenuopcion", "STRING_TYPE", "linkmenuopcion", "%");
$tfi_listmenuopcion3->addColumn("estadomenuopcion.codigoestadomenuopcion", "STRING_TYPE", "codigoestadomenuopcion", "%");
$tfi_listmenuopcion3->addColumn("menuopcion.nivelmenuopcion", "NUMERIC_TYPE", "nivelmenuopcion", "=");
$tfi_listmenuopcion3->addColumn("menuopcion.posicionmenuopcion", "NUMERIC_TYPE", "posicionmenuopcion", "=");
$tfi_listmenuopcion3->addColumn("gerarquiarol.codigogerarquiarol", "STRING_TYPE", "codigogerarquiarol", "%");
$tfi_listmenuopcion3->Execute();

// Sorter
$tso_listmenuopcion3 = new TSO_TableSorter("rsmenuopcion1", "tso_listmenuopcion3");
$tso_listmenuopcion3->addColumn("menuopcion.nombremenuopcion");
$tso_listmenuopcion3->addColumn("menuopcion.linkmenuopcion");
$tso_listmenuopcion3->addColumn("estadomenuopcion.nombreestadomenuopcion");
$tso_listmenuopcion3->addColumn("menuopcion.nivelmenuopcion");
$tso_listmenuopcion3->addColumn("menuopcion.posicionmenuopcion");
$tso_listmenuopcion3->addColumn("gerarquiarol.nombregerarquiarol");
$tso_listmenuopcion3->setDefault("menuopcion.nombremenuopcion");
$tso_listmenuopcion3->Execute();

// Navigation
$nav_listmenuopcion3 = new NAV_Regular("nav_listmenuopcion3", "rsmenuopcion1", "../../../../", $_SERVER['PHP_SELF'], 10);

mysql_select_db($database_sala, $sala);
$query_Recordset1 = "SELECT codigoestadomenuopcion, nombreestadomenuopcion FROM estadomenuopcion ORDER BY codigoestadomenuopcion";
$Recordset1 = mysql_query($query_Recordset1, $sala) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_sala, $sala);
$query_Recordset2 = "SELECT nombregerarquiarol, nombregerarquiarol FROM gerarquiarol ORDER BY nombregerarquiarol";
$Recordset2 = mysql_query($query_Recordset2, $sala) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

//NeXTenesio3 Special List Recordset
$maxRows_rsmenuopcion1 = $_SESSION['max_rows_nav_listmenuopcion3'];
$pageNum_rsmenuopcion1 = 0;
if (isset($_GET['pageNum_rsmenuopcion1'])) {
  $pageNum_rsmenuopcion1 = $_GET['pageNum_rsmenuopcion1'];
}
$startRow_rsmenuopcion1 = $pageNum_rsmenuopcion1 * $maxRows_rsmenuopcion1;

$NXTFilter_rsmenuopcion1 = "1=1";
if (isset($_SESSION['filter_tfi_listmenuopcion3'])) {
  $NXTFilter_rsmenuopcion1 = $_SESSION['filter_tfi_listmenuopcion3'];
}
$NXTSort_rsmenuopcion1 = "menuopcion.nombremenuopcion";
if (isset($_SESSION['sorter_tso_listmenuopcion3'])) {
  $NXTSort_rsmenuopcion1 = $_SESSION['sorter_tso_listmenuopcion3'];
}
mysql_select_db($database_sala, $sala);

$query_rsmenuopcion1 = sprintf("SELECT menuopcion.nombremenuopcion, menuopcion.linkmenuopcion, estadomenuopcion.nombreestadomenuopcion AS codigoestadomenuopcion, menuopcion.nivelmenuopcion, menuopcion.posicionmenuopcion, gerarquiarol.nombregerarquiarol AS codigogerarquiarol, menuopcion.idmenuopcion FROM (menuopcion LEFT JOIN estadomenuopcion ON menuopcion.codigoestadomenuopcion = estadomenuopcion.codigoestadomenuopcion) LEFT JOIN gerarquiarol ON menuopcion.codigogerarquiarol = gerarquiarol.codigogerarquiarol WHERE %s ORDER BY %s", $NXTFilter_rsmenuopcion1, $NXTSort_rsmenuopcion1);
$query_limit_rsmenuopcion1 = sprintf("%s LIMIT %d, %d", $query_rsmenuopcion1, $startRow_rsmenuopcion1, $maxRows_rsmenuopcion1);
$rsmenuopcion1 = mysql_query($query_limit_rsmenuopcion1, $sala) or die(mysql_error());
$row_rsmenuopcion1 = mysql_fetch_assoc($rsmenuopcion1);

if (isset($_GET['totalRows_rsmenuopcion1'])) {
  $totalRows_rsmenuopcion1 = $_GET['totalRows_rsmenuopcion1'];
} else {
  $all_rsmenuopcion1 = mysql_query($query_rsmenuopcion1);
  $totalRows_rsmenuopcion1 = mysql_num_rows($all_rsmenuopcion1);
}
$totalPages_rsmenuopcion1 = ceil($totalRows_rsmenuopcion1/$maxRows_rsmenuopcion1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listmenuopcion3->checkBoundries();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Documento sin t&iacute;tulo</title>
<link href="../../../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../../../../includes/common/js/base.js" type="text/javascript"></script>
<script src="../../../../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../../../../includes/skins/style.js" type="text/javascript"></script>
<script src="../../../../includes/nxt/scripts/list.js" type="text/javascript"></script>
<script src="../../../../includes/nxt/scripts/list.js.php" type="text/javascript"></script>
<script type="text/javascript">
$NXT_LIST_SETTINGS = {
  duplicate_buttons: false,
  duplicate_navigation: false,
  row_effects: false,
  show_as_buttons: false,
  record_counter: false
}
</script>
<style type="text/css">
  /* NeXTensio3 List row settings */
  .KT_col_nombremenuopcion {width:140px; overflow:hidden;}
  .KT_col_linkmenuopcion {width:420px; overflow:hidden;}
  .KT_col_codigoestadomenuopcion {width:140px; overflow:hidden;}
  .KT_col_nivelmenuopcion {width:140px; overflow:hidden;}
  .KT_col_posicionmenuopcion {width:140px; overflow:hidden;}
  .KT_col_codigogerarquiarol {width:140px; overflow:hidden;}
</style>
</head>

<body>
<div class="KT_tng" id="listmenuopcion3">
  <h1> Menuopcion
      <?php
  $nav_listmenuopcion3->Prepare();
  require("../../../../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listmenuopcion3->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
            <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listmenuopcion3'] == 1) {
?>
            <?php echo $_SESSION['default_max_rows_nav_listmenuopcion3']; ?>
            <?php 
  // else Conditional region1
  } else { ?>
            <?php echo NXT_getResource("all"); ?>
            <?php } 
  // endif Conditional region1
?>
            <?php echo NXT_getResource("records"); ?></a> &nbsp; &nbsp;
            <?php 
  // Show IF Conditional region2
  if (@$_SESSION['has_filter_tfi_listmenuopcion3'] == 1) {
?>
            <a href="<?php echo $tfi_listmenuopcion3->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
            <?php 
  // else Conditional region2
  } else { ?>
            <a href="<?php echo $tfi_listmenuopcion3->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
            <?php } 
  // endif Conditional region2
?>
      </div>
      <table cellpadding="2" cellspacing="2" class="KT_tngtable">
        <thead>
          <tr class="verdoso">
            <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
            </th>
            <th id="nombremenuopcion" class="KT_sorter KT_col_nombremenuopcion <?php echo $tso_listmenuopcion3->getSortIcon('menuopcion.nombremenuopcion'); ?>"> <a href="<?php echo $tso_listmenuopcion3->getSortLink('menuopcion.nombremenuopcion'); ?>">Nombremenuopcion</a> </th>
            <th id="linkmenuopcion" class="KT_sorter KT_col_linkmenuopcion <?php echo $tso_listmenuopcion3->getSortIcon('menuopcion.linkmenuopcion'); ?>"> <a href="<?php echo $tso_listmenuopcion3->getSortLink('menuopcion.linkmenuopcion'); ?>">Linkmenuopcion</a> </th>
            <th id="codigoestadomenuopcion" class="KT_sorter KT_col_codigoestadomenuopcion <?php echo $tso_listmenuopcion3->getSortIcon('estadomenuopcion.nombreestadomenuopcion'); ?>"> <a href="<?php echo $tso_listmenuopcion3->getSortLink('estadomenuopcion.nombreestadomenuopcion'); ?>">Codigoestadomenuopcion</a> </th>
            <th id="nivelmenuopcion" class="KT_sorter KT_col_nivelmenuopcion <?php echo $tso_listmenuopcion3->getSortIcon('menuopcion.nivelmenuopcion'); ?>"> <a href="<?php echo $tso_listmenuopcion3->getSortLink('menuopcion.nivelmenuopcion'); ?>">Nivelmenuopcion</a> </th>
            <th id="posicionmenuopcion" class="KT_sorter KT_col_posicionmenuopcion <?php echo $tso_listmenuopcion3->getSortIcon('menuopcion.posicionmenuopcion'); ?>"> <a href="<?php echo $tso_listmenuopcion3->getSortLink('menuopcion.posicionmenuopcion'); ?>">Posicionmenuopcion</a> </th>
            <th id="codigogerarquiarol" class="KT_sorter KT_col_codigogerarquiarol <?php echo $tso_listmenuopcion3->getSortIcon('gerarquiarol.nombregerarquiarol'); ?>"> <a href="<?php echo $tso_listmenuopcion3->getSortLink('gerarquiarol.nombregerarquiarol'); ?>">Codigogerarquiarol</a> </th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listmenuopcion3'] == 1) {
?>
          <tr class="KT_row_filter">
            <td>&nbsp;</td>
            <td><input type="text" name="tfi_listmenuopcion3_nombremenuopcion" id="tfi_listmenuopcion3_nombremenuopcion" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listmenuopcion3_nombremenuopcion']); ?>" size="20" maxlength="70" /></td>
            <td><input type="text" name="tfi_listmenuopcion3_linkmenuopcion" id="tfi_listmenuopcion3_linkmenuopcion" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listmenuopcion3_linkmenuopcion']); ?>" size="60" maxlength="200" /></td>
            <td><select name="tfi_listmenuopcion3_codigoestadomenuopcion" id="tfi_listmenuopcion3_codigoestadomenuopcion">
                <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listmenuopcion3_codigoestadomenuopcion']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
                <?php
do {  
?>
                <option value="<?php echo $row_Recordset1['nombreestadomenuopcion']?>"<?php if (!(strcmp($row_Recordset1['nombreestadomenuopcion'], @$_SESSION['tfi_listmenuopcion3_codigoestadomenuopcion']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['codigoestadomenuopcion']?></option>
                <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
              </select>
            </td>
            <td><input type="text" name="tfi_listmenuopcion3_nivelmenuopcion" id="tfi_listmenuopcion3_nivelmenuopcion" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listmenuopcion3_nivelmenuopcion']); ?>" size="20" maxlength="100" /></td>
            <td><input type="text" name="tfi_listmenuopcion3_posicionmenuopcion" id="tfi_listmenuopcion3_posicionmenuopcion" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listmenuopcion3_posicionmenuopcion']); ?>" size="20" maxlength="100" /></td>
            <td><select name="tfi_listmenuopcion3_codigogerarquiarol" id="tfi_listmenuopcion3_codigogerarquiarol">
                <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listmenuopcion3_codigogerarquiarol']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
                <?php
do {  
?>
                <option value="<?php echo $row_Recordset2['nombregerarquiarol']?>"<?php if (!(strcmp($row_Recordset2['nombregerarquiarol'], @$_SESSION['tfi_listmenuopcion3_codigogerarquiarol']))) {echo "SELECTED";} ?>><?php echo $row_Recordset2['nombregerarquiarol']?></option>
                <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
              </select>
            </td>
            <td><input type="submit" name="tfi_listmenuopcion3" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
          </tr>
          <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rsmenuopcion1 == 0) { // Show if recordset empty ?>
          <tr>
            <td colspan="8"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
          </tr>
          <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rsmenuopcion1 > 0) { // Show if recordset not empty ?>
          <?php do { ?>
          <tr class="amarrillento">
            <td><input type="checkbox" name="kt_pk_menuopcion" class="id_checkbox" value="<?php echo $row_rsmenuopcion1['idmenuopcion']; ?>" />
                <input type="hidden" name="idmenuopcion" class="id_field" value="<?php echo $row_rsmenuopcion1['idmenuopcion']; ?>" />
            </td>
            <td><div class="KT_col_nombremenuopcion"><?php echo KT_FormatForList($row_rsmenuopcion1['nombremenuopcion'], 20); ?></div></td>
            <td><div class="KT_col_linkmenuopcion"><?php echo KT_FormatForList($row_rsmenuopcion1['linkmenuopcion'], 60); ?></div></td>
            <td><div class="KT_col_codigoestadomenuopcion"><?php echo KT_FormatForList($row_rsmenuopcion1['codigoestadomenuopcion'], 20); ?></div></td>
            <td><div class="KT_col_nivelmenuopcion"><?php echo KT_FormatForList($row_rsmenuopcion1['nivelmenuopcion'], 20); ?></div></td>
            <td><div class="KT_col_posicionmenuopcion"><?php echo KT_FormatForList($row_rsmenuopcion1['posicionmenuopcion'], 20); ?></div></td>
            <td><div class="KT_col_codigogerarquiarol"><?php echo KT_FormatForList($row_rsmenuopcion1['codigogerarquiarol'], 20); ?></div></td>
            <td><a class="KT_edit_link" href="menuopcion.php?idmenuopcion=<?php echo $row_rsmenuopcion1['idmenuopcion']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a> </td>
          </tr>
          <?php } while ($row_rsmenuopcion1 = mysql_fetch_assoc($rsmenuopcion1)); ?>
          <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listmenuopcion3->Prepare();
            require("../../../../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
        </div>
      </div>
      <div class="KT_bottombuttons">
        <div class="KT_operations"> <a class="KT_edit_op_link" href="#" onclick="nxt_list_edit_link_form(this); return false;"><?php echo NXT_getResource("edit_all"); ?></a> <a class="KT_delete_op_link" href="#" onclick="nxt_list_delete_link_form(this); return false;"><?php echo NXT_getResource("delete_all"); ?></a> </div>
        <p><span>&nbsp;</span>
            <select name="no_new" id="no_new">
              <option value="1">1</option>
              <option value="3">3</option>
              <option value="6">6</option>
            </select>
            <a class="KT_additem_op_link" href="menuopcion.php?KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a></p>
        <p><a href="permisorol_listado.php">Permiso ROL</a> </p>
      </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($rsmenuopcion1);
?>
