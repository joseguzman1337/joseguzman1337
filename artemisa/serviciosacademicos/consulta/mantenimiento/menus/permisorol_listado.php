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
$tfi_listpermisorol2 = new TFI_TableFilter($conn_sala, "tfi_listpermisorol2");
$tfi_listpermisorol2->addColumn("menuopcion.idmenuopcion", "NUMERIC_TYPE", "idmenuopcion", "=");
$tfi_listpermisorol2->addColumn("rol.idrol", "NUMERIC_TYPE", "idrol", "=");
$tfi_listpermisorol2->Execute();

// Sorter
$tso_listpermisorol2 = new TSO_TableSorter("rspermisorol1", "tso_listpermisorol2");
$tso_listpermisorol2->addColumn("menuopcion.nombremenuopcion");
$tso_listpermisorol2->addColumn("rol.nombrerol");
$tso_listpermisorol2->setDefault("permisorol.idmenuopcion");
$tso_listpermisorol2->Execute();

// Navigation
$nav_listpermisorol2 = new NAV_Regular("nav_listpermisorol2", "rspermisorol1", "../../../../", $_SERVER['PHP_SELF'], 10);

mysql_select_db($database_sala, $sala);
$query_Recordset1 = "SELECT nombrerol, idrol FROM rol ORDER BY nombrerol";
$Recordset1 = mysql_query($query_Recordset1, $sala) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_sala, $sala);
$query_Recordset2 = "SELECT nombremenuopcion, idmenuopcion FROM menuopcion ORDER BY nombremenuopcion";
$Recordset2 = mysql_query($query_Recordset2, $sala) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

//NeXTenesio3 Special List Recordset
$maxRows_rspermisorol1 = $_SESSION['max_rows_nav_listpermisorol2'];
$pageNum_rspermisorol1 = 0;
if (isset($_GET['pageNum_rspermisorol1'])) {
  $pageNum_rspermisorol1 = $_GET['pageNum_rspermisorol1'];
}
$startRow_rspermisorol1 = $pageNum_rspermisorol1 * $maxRows_rspermisorol1;

$NXTFilter_rspermisorol1 = "1=1";
if (isset($_SESSION['filter_tfi_listpermisorol2'])) {
  $NXTFilter_rspermisorol1 = $_SESSION['filter_tfi_listpermisorol2'];
}
$NXTSort_rspermisorol1 = "permisorol.idmenuopcion";
if (isset($_SESSION['sorter_tso_listpermisorol2'])) {
  $NXTSort_rspermisorol1 = $_SESSION['sorter_tso_listpermisorol2'];
}
mysql_select_db($database_sala, $sala);

$query_rspermisorol1 = sprintf("SELECT menuopcion.nombremenuopcion AS idmenuopcion, rol.nombrerol AS idrol FROM (permisorol LEFT JOIN menuopcion ON permisorol.idmenuopcion = menuopcion.idmenuopcion) LEFT JOIN rol ON permisorol.idrol = rol.idrol WHERE %s ORDER BY %s", $NXTFilter_rspermisorol1, $NXTSort_rspermisorol1);
$query_limit_rspermisorol1 = sprintf("%s LIMIT %d, %d", $query_rspermisorol1, $startRow_rspermisorol1, $maxRows_rspermisorol1);
$rspermisorol1 = mysql_query($query_limit_rspermisorol1, $sala) or die(mysql_error());
$row_rspermisorol1 = mysql_fetch_assoc($rspermisorol1);

if (isset($_GET['totalRows_rspermisorol1'])) {
  $totalRows_rspermisorol1 = $_GET['totalRows_rspermisorol1'];
} else {
  $all_rspermisorol1 = mysql_query($query_rspermisorol1);
  $totalRows_rspermisorol1 = mysql_num_rows($all_rspermisorol1);
}
$totalPages_rspermisorol1 = ceil($totalRows_rspermisorol1/$maxRows_rspermisorol1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listpermisorol2->checkBoundries();
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
  .KT_col_idmenuopcion {width:420px; overflow:hidden;}
  .KT_col_idrol {width:140px; overflow:hidden;}
</style>
</head>

<body>
<div class="KT_tng" id="listpermisorol2">
  <h1> Permisorol
      <?php
  $nav_listpermisorol2->Prepare();
  require("../../../../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listpermisorol2->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
            <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listpermisorol2'] == 1) {
?>
            <?php echo $_SESSION['default_max_rows_nav_listpermisorol2']; ?>
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
  if (@$_SESSION['has_filter_tfi_listpermisorol2'] == 1) {
?>
            <a href="<?php echo $tfi_listpermisorol2->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
            <?php 
  // else Conditional region2
  } else { ?>
            <a href="<?php echo $tfi_listpermisorol2->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
            <?php } 
  // endif Conditional region2
?>
      </div>
      <table cellpadding="2" cellspacing="2" class="KT_tngtable">
        <thead>
          <tr class="verdoso">
            <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
            </th>
            <th id="idmenuopcion" class="KT_sorter KT_col_idmenuopcion <?php echo $tso_listpermisorol2->getSortIcon('menuopcion.nombremenuopcion'); ?>"> <a href="<?php echo $tso_listpermisorol2->getSortLink('menuopcion.nombremenuopcion'); ?>">Idmenuopcion</a> </th>
            <th id="idrol" class="KT_sorter KT_col_idrol <?php echo $tso_listpermisorol2->getSortIcon('rol.nombrerol'); ?>"> <a href="<?php echo $tso_listpermisorol2->getSortLink('rol.nombrerol'); ?>">Idrol</a> </th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listpermisorol2'] == 1) {
?>
          <tr class="KT_row_filter">
            <td>&nbsp;</td>
            <td><select name="tfi_listpermisorol2_idmenuopcion" id="tfi_listpermisorol2_idmenuopcion">
                <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listpermisorol2_idmenuopcion']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
                <?php
do {  
?>
                <option value="<?php echo $row_Recordset2['idmenuopcion']?>"<?php if (!(strcmp($row_Recordset2['idmenuopcion'], @$_SESSION['tfi_listpermisorol2_idmenuopcion']))) {echo "SELECTED";} ?>><?php echo $row_Recordset2['nombremenuopcion']?></option>
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
            <td><select name="tfi_listpermisorol2_idrol" id="tfi_listpermisorol2_idrol">
                <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listpermisorol2_idrol']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
                <?php
do {  
?>
                <option value="<?php echo $row_Recordset1['idrol']?>"<?php if (!(strcmp($row_Recordset1['idrol'], @$_SESSION['tfi_listpermisorol2_idrol']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['nombrerol']?></option>
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
            <td><input type="submit" name="tfi_listpermisorol2" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
          </tr>
          <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rspermisorol1 == 0) { // Show if recordset empty ?>
          <tr>
            <td colspan="4"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
          </tr>
          <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rspermisorol1 > 0) { // Show if recordset not empty ?>
          <?php do { ?>
          <tr class="amarrillento">
            <td><input type="checkbox" name="kt_pk_permisorol" class="id_checkbox" value="<?php echo $row_rspermisorol1['idrol']; ?>" />
                <input type="hidden" name="idrol" class="id_field" value="<?php echo $row_rspermisorol1['idrol']; ?>" />
            </td>
            <td><div class="KT_col_idmenuopcion"><?php echo KT_FormatForList($row_rspermisorol1['idmenuopcion'], 60); ?></div></td>
            <td><div class="KT_col_idrol"><?php echo KT_FormatForList($row_rspermisorol1['idrol'], 20); ?></div></td>
            <td><a class="KT_edit_link" href="permisorol.php?idrol=<?php echo $row_rspermisorol1['idrol']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a> </td>
          </tr>
          <?php } while ($row_rspermisorol1 = mysql_fetch_assoc($rspermisorol1)); ?>
          <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listpermisorol2->Prepare();
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
            <a class="KT_additem_op_link" href="permisorol.php?KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a></p>
        <p><a href="menuopcion_listado.php">Menú Opción</a> </p>
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

mysql_free_result($rspermisorol1);
?>
