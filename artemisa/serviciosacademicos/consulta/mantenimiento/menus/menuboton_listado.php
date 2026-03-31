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
$tfi_listmenuboton1 = new TFI_TableFilter($conn_sala, "tfi_listmenuboton1");
$tfi_listmenuboton1->addColumn("menuboton.nombremenuboton", "STRING_TYPE", "nombremenuboton", "%");
$tfi_listmenuboton1->addColumn("menuboton.linkmenuboton", "STRING_TYPE", "linkmenuboton", "%");
$tfi_listmenuboton1->addColumn("estadomenuboton.codigoestadomenuboton", "STRING_TYPE", "codigoestadomenuboton", "%");
$tfi_listmenuboton1->addColumn("menuboton.nivelmenuboton", "NUMERIC_TYPE", "nivelmenuboton", "=");
$tfi_listmenuboton1->addColumn("menuboton.posicionmenuboton", "NUMERIC_TYPE", "posicionmenuboton", "=");
$tfi_listmenuboton1->addColumn("gerarquiarol.codigogerarquiarol", "STRING_TYPE", "codigogerarquiarol", "%");
$tfi_listmenuboton1->addColumn("menuboton.linkimagenboton", "STRING_TYPE", "linkimagenboton", "%");
$tfi_listmenuboton1->addColumn("menuboton.scriptmenuboton", "STRING_TYPE", "scriptmenuboton", "%");
$tfi_listmenuboton1->addColumn("tipomenuboton.codigotipomenuboton", "STRING_TYPE", "codigotipomenuboton", "%");
$tfi_listmenuboton1->addColumn("menuboton.variablesmenuboton", "STRING_TYPE", "variablesmenuboton", "%");
$tfi_listmenuboton1->addColumn("menuboton.propiedadesimagenmenuboton", "STRING_TYPE", "propiedadesimagenmenuboton", "%");
$tfi_listmenuboton1->addColumn("menuboton.propiedadesmenuboton", "STRING_TYPE", "propiedadesmenuboton", "%");
$tfi_listmenuboton1->Execute();

// Sorter
$tso_listmenuboton1 = new TSO_TableSorter("rsmenuboton1", "tso_listmenuboton1");
$tso_listmenuboton1->addColumn("menuboton.nombremenuboton");
$tso_listmenuboton1->addColumn("menuboton.linkmenuboton");
$tso_listmenuboton1->addColumn("estadomenuboton.nombreestadomenuboton");
$tso_listmenuboton1->addColumn("menuboton.nivelmenuboton");
$tso_listmenuboton1->addColumn("menuboton.posicionmenuboton");
$tso_listmenuboton1->addColumn("gerarquiarol.nombregerarquiarol");
$tso_listmenuboton1->addColumn("menuboton.linkimagenboton");
$tso_listmenuboton1->addColumn("menuboton.scriptmenuboton");
$tso_listmenuboton1->addColumn("tipomenuboton.nombretipomenuboton");
$tso_listmenuboton1->addColumn("menuboton.variablesmenuboton");
$tso_listmenuboton1->addColumn("menuboton.propiedadesimagenmenuboton");
$tso_listmenuboton1->addColumn("menuboton.propiedadesmenuboton");
$tso_listmenuboton1->setDefault("menuboton.nombremenuboton");
$tso_listmenuboton1->Execute();

// Navigation
$nav_listmenuboton1 = new NAV_Regular("nav_listmenuboton1", "rsmenuboton1", "../../../../", $_SERVER['PHP_SELF'], 10);

mysql_select_db($database_sala, $sala);
$query_Recordset1 = "SELECT nombreestadomenuboton, codigoestadomenuboton FROM estadomenuboton ORDER BY nombreestadomenuboton";
$Recordset1 = mysql_query($query_Recordset1, $sala) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_sala, $sala);
$query_Recordset2 = "SELECT nombregerarquiarol, codigogerarquiarol FROM gerarquiarol ORDER BY nombregerarquiarol";
$Recordset2 = mysql_query($query_Recordset2, $sala) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_sala, $sala);
$query_Recordset3 = "SELECT nombretipomenuboton, codigotipomenuboton FROM tipomenuboton ORDER BY nombretipomenuboton";
$Recordset3 = mysql_query($query_Recordset3, $sala) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

//NeXTenesio3 Special List Recordset
$maxRows_rsmenuboton1 = $_SESSION['max_rows_nav_listmenuboton1'];
$pageNum_rsmenuboton1 = 0;
if (isset($_GET['pageNum_rsmenuboton1'])) {
  $pageNum_rsmenuboton1 = $_GET['pageNum_rsmenuboton1'];
}
$startRow_rsmenuboton1 = $pageNum_rsmenuboton1 * $maxRows_rsmenuboton1;

$NXTFilter_rsmenuboton1 = "1=1";
if (isset($_SESSION['filter_tfi_listmenuboton1'])) {
  $NXTFilter_rsmenuboton1 = $_SESSION['filter_tfi_listmenuboton1'];
}
$NXTSort_rsmenuboton1 = "menuboton.nombremenuboton";
if (isset($_SESSION['sorter_tso_listmenuboton1'])) {
  $NXTSort_rsmenuboton1 = $_SESSION['sorter_tso_listmenuboton1'];
}
mysql_select_db($database_sala, $sala);

$query_rsmenuboton1 = sprintf("SELECT menuboton.nombremenuboton, menuboton.linkmenuboton, estadomenuboton.nombreestadomenuboton AS codigoestadomenuboton, menuboton.nivelmenuboton, menuboton.posicionmenuboton, gerarquiarol.nombregerarquiarol AS codigogerarquiarol, menuboton.linkimagenboton, menuboton.scriptmenuboton, tipomenuboton.nombretipomenuboton AS codigotipomenuboton, menuboton.variablesmenuboton, menuboton.propiedadesimagenmenuboton, menuboton.propiedadesmenuboton, menuboton.idmenuboton FROM ((menuboton LEFT JOIN estadomenuboton ON menuboton.codigoestadomenuboton = estadomenuboton.codigoestadomenuboton) LEFT JOIN gerarquiarol ON menuboton.codigogerarquiarol = gerarquiarol.codigogerarquiarol) LEFT JOIN tipomenuboton ON menuboton.codigotipomenuboton = tipomenuboton.codigotipomenuboton WHERE %s ORDER BY %s", $NXTFilter_rsmenuboton1, $NXTSort_rsmenuboton1);
$query_limit_rsmenuboton1 = sprintf("%s LIMIT %d, %d", $query_rsmenuboton1, $startRow_rsmenuboton1, $maxRows_rsmenuboton1);
$rsmenuboton1 = mysql_query($query_limit_rsmenuboton1, $sala) or die(mysql_error());
$row_rsmenuboton1 = mysql_fetch_assoc($rsmenuboton1);

if (isset($_GET['totalRows_rsmenuboton1'])) {
  $totalRows_rsmenuboton1 = $_GET['totalRows_rsmenuboton1'];
} else {
  $all_rsmenuboton1 = mysql_query($query_rsmenuboton1);
  $totalRows_rsmenuboton1 = mysql_num_rows($all_rsmenuboton1);
}
$totalPages_rsmenuboton1 = ceil($totalRows_rsmenuboton1/$maxRows_rsmenuboton1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listmenuboton1->checkBoundries();
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
  .KT_col_nombremenuboton {width:210px; overflow:hidden;}
  .KT_col_linkmenuboton {width:700px; overflow:hidden;}
  .KT_col_codigoestadomenuboton {width:70px; overflow:hidden;}
  .KT_col_nivelmenuboton {width:70px; overflow:hidden;}
  .KT_col_posicionmenuboton {width:70px; overflow:hidden;}
  .KT_col_codigogerarquiarol {width:70px; overflow:hidden;}
  .KT_col_linkimagenboton {width:700px; overflow:hidden;}
  .KT_col_scriptmenuboton {width:140px; overflow:hidden;}
  .KT_col_codigotipomenuboton {width:70px; overflow:hidden;}
  .KT_col_variablesmenuboton {width:140px; overflow:hidden;}
  .KT_col_propiedadesimagenmenuboton {width:140px; overflow:hidden;}
  .KT_col_propiedadesmenuboton {width:140px; overflow:hidden;}
</style>
</head>

<body>
<div class="KT_tng" id="listmenuboton1">
  <h1> Menuboton
      <?php
  $nav_listmenuboton1->Prepare();
  require("../../../../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listmenuboton1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
            <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listmenuboton1'] == 1) {
?>
            <?php echo $_SESSION['default_max_rows_nav_listmenuboton1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listmenuboton1'] == 1) {
?>
            <a href="<?php echo $tfi_listmenuboton1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
            <?php 
  // else Conditional region2
  } else { ?>
            <a href="<?php echo $tfi_listmenuboton1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
            <?php } 
  // endif Conditional region2
?>
      </div>
      <table cellpadding="2" cellspacing="2" class="KT_tngtable">
        <thead>
          <tr class="verdoso">
            <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
            </th>
            <th id="nombremenuboton" class="KT_sorter KT_col_nombremenuboton <?php echo $tso_listmenuboton1->getSortIcon('menuboton.nombremenuboton'); ?>"> <a href="<?php echo $tso_listmenuboton1->getSortLink('menuboton.nombremenuboton'); ?>">Nombremenuboton</a> </th>
            <th id="linkmenuboton" class="KT_sorter KT_col_linkmenuboton <?php echo $tso_listmenuboton1->getSortIcon('menuboton.linkmenuboton'); ?>"> <a href="<?php echo $tso_listmenuboton1->getSortLink('menuboton.linkmenuboton'); ?>">Linkmenuboton</a> </th>
            <th id="codigoestadomenuboton" class="KT_sorter KT_col_codigoestadomenuboton <?php echo $tso_listmenuboton1->getSortIcon('estadomenuboton.nombreestadomenuboton'); ?>"> <a href="<?php echo $tso_listmenuboton1->getSortLink('estadomenuboton.nombreestadomenuboton'); ?>">Codigoestadomenuboton</a> </th>
            <th id="nivelmenuboton" class="KT_sorter KT_col_nivelmenuboton <?php echo $tso_listmenuboton1->getSortIcon('menuboton.nivelmenuboton'); ?>"> <a href="<?php echo $tso_listmenuboton1->getSortLink('menuboton.nivelmenuboton'); ?>">Nivelmenuboton</a> </th>
            <th id="posicionmenuboton" class="KT_sorter KT_col_posicionmenuboton <?php echo $tso_listmenuboton1->getSortIcon('menuboton.posicionmenuboton'); ?>"> <a href="<?php echo $tso_listmenuboton1->getSortLink('menuboton.posicionmenuboton'); ?>">Posicionmenuboton</a> </th>
            <th id="codigogerarquiarol" class="KT_sorter KT_col_codigogerarquiarol <?php echo $tso_listmenuboton1->getSortIcon('gerarquiarol.nombregerarquiarol'); ?>"> <a href="<?php echo $tso_listmenuboton1->getSortLink('gerarquiarol.nombregerarquiarol'); ?>">Codigogerarquiarol</a> </th>
            <th id="linkimagenboton" class="KT_sorter KT_col_linkimagenboton <?php echo $tso_listmenuboton1->getSortIcon('menuboton.linkimagenboton'); ?>"> <a href="<?php echo $tso_listmenuboton1->getSortLink('menuboton.linkimagenboton'); ?>">Linkimagenboton</a> </th>
            <th id="scriptmenuboton" class="KT_sorter KT_col_scriptmenuboton <?php echo $tso_listmenuboton1->getSortIcon('menuboton.scriptmenuboton'); ?>"> <a href="<?php echo $tso_listmenuboton1->getSortLink('menuboton.scriptmenuboton'); ?>">Scriptmenuboton</a> </th>
            <th id="codigotipomenuboton" class="KT_sorter KT_col_codigotipomenuboton <?php echo $tso_listmenuboton1->getSortIcon('tipomenuboton.nombretipomenuboton'); ?>"> <a href="<?php echo $tso_listmenuboton1->getSortLink('tipomenuboton.nombretipomenuboton'); ?>">Codigotipomenuboton</a> </th>
            <th id="variablesmenuboton" class="KT_sorter KT_col_variablesmenuboton <?php echo $tso_listmenuboton1->getSortIcon('menuboton.variablesmenuboton'); ?>"> <a href="<?php echo $tso_listmenuboton1->getSortLink('menuboton.variablesmenuboton'); ?>">Variablesmenuboton</a> </th>
            <th id="propiedadesimagenmenuboton" class="KT_sorter KT_col_propiedadesimagenmenuboton <?php echo $tso_listmenuboton1->getSortIcon('menuboton.propiedadesimagenmenuboton'); ?>"> <a href="<?php echo $tso_listmenuboton1->getSortLink('menuboton.propiedadesimagenmenuboton'); ?>">Propiedadesimagenmenuboton</a> </th>
            <th id="propiedadesmenuboton" class="KT_sorter KT_col_propiedadesmenuboton <?php echo $tso_listmenuboton1->getSortIcon('menuboton.propiedadesmenuboton'); ?>"> <a href="<?php echo $tso_listmenuboton1->getSortLink('menuboton.propiedadesmenuboton'); ?>">Propiedadesmenuboton</a> </th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listmenuboton1'] == 1) {
?>
          <tr class="verde">
            <td>&nbsp;</td>
            <td><input type="text" name="tfi_listmenuboton1_nombremenuboton" id="tfi_listmenuboton1_nombremenuboton" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listmenuboton1_nombremenuboton']); ?>" size="30" maxlength="50" /></td>
            <td><input type="text" name="tfi_listmenuboton1_linkmenuboton" id="tfi_listmenuboton1_linkmenuboton" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listmenuboton1_linkmenuboton']); ?>" size="100" maxlength="200" /></td>
            <td><select name="tfi_listmenuboton1_codigoestadomenuboton" id="tfi_listmenuboton1_codigoestadomenuboton">
                <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listmenuboton1_codigoestadomenuboton']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
                <?php
do {  
?>
                <option value="<?php echo $row_Recordset1['codigoestadomenuboton']?>"<?php if (!(strcmp($row_Recordset1['codigoestadomenuboton'], @$_SESSION['tfi_listmenuboton1_codigoestadomenuboton']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['nombreestadomenuboton']?></option>
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
            <td><input type="text" name="tfi_listmenuboton1_nivelmenuboton" id="tfi_listmenuboton1_nivelmenuboton" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listmenuboton1_nivelmenuboton']); ?>" size="10" maxlength="100" /></td>
            <td><input type="text" name="tfi_listmenuboton1_posicionmenuboton" id="tfi_listmenuboton1_posicionmenuboton" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listmenuboton1_posicionmenuboton']); ?>" size="10" maxlength="100" /></td>
            <td><select name="tfi_listmenuboton1_codigogerarquiarol" id="tfi_listmenuboton1_codigogerarquiarol">
                <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listmenuboton1_codigogerarquiarol']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
                <?php
do {  
?>
                <option value="<?php echo $row_Recordset2['codigogerarquiarol']?>"<?php if (!(strcmp($row_Recordset2['codigogerarquiarol'], @$_SESSION['tfi_listmenuboton1_codigogerarquiarol']))) {echo "SELECTED";} ?>><?php echo $row_Recordset2['nombregerarquiarol']?></option>
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
            <td><input type="text" name="tfi_listmenuboton1_linkimagenboton" id="tfi_listmenuboton1_linkimagenboton" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listmenuboton1_linkimagenboton']); ?>" size="100" maxlength="200" /></td>
            <td><input type="text" name="tfi_listmenuboton1_scriptmenuboton" id="tfi_listmenuboton1_scriptmenuboton" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listmenuboton1_scriptmenuboton']); ?>" size="20" maxlength="200" /></td>
            <td><select name="tfi_listmenuboton1_codigotipomenuboton" id="tfi_listmenuboton1_codigotipomenuboton">
                <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listmenuboton1_codigotipomenuboton']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
                <?php
do {  
?>
                <option value="<?php echo $row_Recordset3['codigotipomenuboton']?>"<?php if (!(strcmp($row_Recordset3['codigotipomenuboton'], @$_SESSION['tfi_listmenuboton1_codigotipomenuboton']))) {echo "SELECTED";} ?>><?php echo $row_Recordset3['nombretipomenuboton']?></option>
                <?php
} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
  $rows = mysql_num_rows($Recordset3);
  if($rows > 0) {
      mysql_data_seek($Recordset3, 0);
	  $row_Recordset3 = mysql_fetch_assoc($Recordset3);
  }
?>
              </select>
            </td>
            <td><input type="text" name="tfi_listmenuboton1_variablesmenuboton" id="tfi_listmenuboton1_variablesmenuboton" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listmenuboton1_variablesmenuboton']); ?>" size="20" maxlength="200" /></td>
            <td><input type="text" name="tfi_listmenuboton1_propiedadesimagenmenuboton" id="tfi_listmenuboton1_propiedadesimagenmenuboton" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listmenuboton1_propiedadesimagenmenuboton']); ?>" size="20" maxlength="200" /></td>
            <td><input type="text" name="tfi_listmenuboton1_propiedadesmenuboton" id="tfi_listmenuboton1_propiedadesmenuboton" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listmenuboton1_propiedadesmenuboton']); ?>" size="20" maxlength="200" /></td>
            <td><input type="submit" name="tfi_listmenuboton1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
          </tr>
          <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rsmenuboton1 == 0) { // Show if recordset empty ?>
          <tr>
            <td colspan="14"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
          </tr>
          <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rsmenuboton1 > 0) { // Show if recordset not empty ?>
          <?php do { ?>
          <tr class="amarrillento">
            <td><input type="checkbox" name="kt_pk_menuboton" class="id_checkbox" value="<?php echo $row_rsmenuboton1['idmenuboton']; ?>" />
                <input type="hidden" name="idmenuboton" class="id_field" value="<?php echo $row_rsmenuboton1['idmenuboton']; ?>" />
            </td>
            <td><div class="KT_col_nombremenuboton"><?php echo KT_FormatForList($row_rsmenuboton1['nombremenuboton'], 30); ?></div></td>
            <td><div class="KT_col_linkmenuboton"><?php echo KT_FormatForList($row_rsmenuboton1['linkmenuboton'], 100); ?></div></td>
            <td><div class="KT_col_codigoestadomenuboton"><?php echo KT_FormatForList($row_rsmenuboton1['codigoestadomenuboton'], 10); ?></div></td>
            <td><div class="KT_col_nivelmenuboton"><?php echo KT_FormatForList($row_rsmenuboton1['nivelmenuboton'], 10); ?></div></td>
            <td><div class="KT_col_posicionmenuboton"><?php echo KT_FormatForList($row_rsmenuboton1['posicionmenuboton'], 10); ?></div></td>
            <td><div class="KT_col_codigogerarquiarol"><?php echo KT_FormatForList($row_rsmenuboton1['codigogerarquiarol'], 10); ?></div></td>
            <td><div class="KT_col_linkimagenboton"><?php echo KT_FormatForList($row_rsmenuboton1['linkimagenboton'], 100); ?></div></td>
            <td><div class="KT_col_scriptmenuboton"><?php echo KT_FormatForList($row_rsmenuboton1['scriptmenuboton'], 20); ?></div></td>
            <td><div class="KT_col_codigotipomenuboton"><?php echo KT_FormatForList($row_rsmenuboton1['codigotipomenuboton'], 10); ?></div></td>
            <td><div class="KT_col_variablesmenuboton"><?php echo KT_FormatForList($row_rsmenuboton1['variablesmenuboton'], 20); ?></div></td>
            <td><div class="KT_col_propiedadesimagenmenuboton"><?php echo KT_FormatForList($row_rsmenuboton1['propiedadesimagenmenuboton'], 20); ?></div></td>
            <td><div class="KT_col_propiedadesmenuboton"><?php echo KT_FormatForList($row_rsmenuboton1['propiedadesmenuboton'], 20); ?></div></td>
            <td><a class="KT_edit_link" href="menuboton.php?idmenuboton=<?php echo $row_rsmenuboton1['idmenuboton']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a> </td>
          </tr>
          <?php } while ($row_rsmenuboton1 = mysql_fetch_assoc($rsmenuboton1)); ?>
          <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listmenuboton1->Prepare();
            require("../../../../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
        </div>
      </div>
      <div class="KT_bottombuttons">
        <div class="KT_operations"> <a class="KT_edit_op_link" href="#" onclick="nxt_list_edit_link_form(this); return false;"><?php echo NXT_getResource("edit_all"); ?></a> <a class="KT_delete_op_link" href="#" onclick="nxt_list_delete_link_form(this); return false;"><?php echo NXT_getResource("delete_all"); ?></a> </div>
        <span>&nbsp;</span>
        <select name="no_new" id="no_new">
          <option value="1">1</option>
          <option value="3">3</option>
          <option value="6">6</option>
        </select>
        <a class="KT_additem_op_link" href="menuboton.php?KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a> </div>
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

mysql_free_result($Recordset3);

mysql_free_result($rsmenuboton1);
?>
