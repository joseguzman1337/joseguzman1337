<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
//Connection statement
require_once(realpath(dirname(__FILE__)).'/../../../../Connections/sala_adodb.php');
$fechahoy=date("Y-m-d H:i:s");

// Load the common classes
require_once(realpath(dirname(__FILE__)).'/../../../../includes/common/KT_common.php');

// Load the required classes
require_once(realpath(dirname(__FILE__)).'/../../../../includes/tfi/TFI.php');
require_once(realpath(dirname(__FILE__)).'/../../../../includes/tso/TSO.php');
require_once(realpath(dirname(__FILE__)).'/../../../../includes/nav/NAV.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');
// Filter
$tfi_listmateria1 = new TFI_TableFilter($sala_adodb, "tfi_listmateria1");
$tfi_listmateria1->addColumn("materia.codigomateria", "NUMERIC_TYPE", "codigomateria", "=");
$tfi_listmateria1->addColumn("materia.nombremateria", "STRING_TYPE", "nombremateria", "%");
$tfi_listmateria1->addColumn("modalidadmateria.codigomodalidadmateria", "STRING_TYPE", "codigomodalidadmateria", "%");
$tfi_listmateria1->addColumn("carrera.codigocarrera", "NUMERIC_TYPE", "codigocarrera", "=");
$tfi_listmateria1->addColumn("tipomateria.codigotipomateria", "STRING_TYPE", "codigotipomateria", "%");
$tfi_listmateria1->Execute();

// Sorter
$tso_listmateria1 = new TSO_TableSorter("rsmateria1", "tso_listmateria1");
$tso_listmateria1->addColumn("materia.codigomateria");
$tso_listmateria1->addColumn("materia.nombremateria");
$tso_listmateria1->addColumn("modalidadmateria.nombremodalidadmateria");
$tso_listmateria1->addColumn("carrera.nombrecarrera");
$tso_listmateria1->addColumn("tipomateria.nombretipomateria");
$tso_listmateria1->setDefault("materia.codigomateria");
$tso_listmateria1->Execute();

// Navigation
$nav_listmateria1 = new NAV_Regular("nav_listmateria1", "rsmateria1", "../../../../", $_SERVER['PHP_SELF'], 50);

// begin Recordset
$query_Recordset1 = "SELECT nombremodalidadmateria, codigomodalidadmateria FROM modalidadmateria ORDER BY nombremodalidadmateria";
$Recordset1 = $sala_adodb->SelectLimit($query_Recordset1) or die($sala_adodb->ErrorMsg());
$totalRows_Recordset1 = $Recordset1->RecordCount();
// end Recordset

// begin Recordset
$query_Recordset2 = "SELECT nombrecarrera, codigocarrera FROM carrera WHERE fechainiciocarrera <= '".$fechahoy."' and fechavencimientocarrera >= '".$fechahoy."' ORDER BY nombrecarrera";
$Recordset2 = $sala_adodb->SelectLimit($query_Recordset2) or die($sala_adodb->ErrorMsg());
$totalRows_Recordset2 = $Recordset2->RecordCount();
// end Recordset

// begin Recordset
$query_Recordset3 = "SELECT nombretipomateria, codigotipomateria FROM tipomateria ORDER BY nombretipomateria";
$Recordset3 = $sala_adodb->SelectLimit($query_Recordset3) or die($sala_adodb->ErrorMsg());
$totalRows_Recordset3 = $Recordset3->RecordCount();
// end Recordset

// Begin List Recordset
$maxRows_rsmateria1 = $_SESSION['max_rows_nav_listmateria1'];
$pageNum_rsmateria1 = 0;
if (isset($_GET['pageNum_rsmateria1'])) {
  $pageNum_rsmateria1 = $_GET['pageNum_rsmateria1'];
}
$startRow_rsmateria1 = $pageNum_rsmateria1 * $maxRows_rsmateria1;
$NXTFilter__rsmateria1 = '1=1';
if (isset($_SESSION['filter_tfi_listmateria1'])) {
  $NXTFilter__rsmateria1 = $_SESSION['filter_tfi_listmateria1'];
}
$NXTSort__rsmateria1 = 'materia.codigomateria';
if (isset($_SESSION['sorter_tso_listmateria1'])) {
  $NXTSort__rsmateria1 = $_SESSION['sorter_tso_listmateria1'];
}
$query_rsmateria1 = sprintf("SELECT materia.codigomateria, materia.nombremateria, modalidadmateria.nombremodalidadmateria AS codigomodalidadmateria, carrera.nombrecarrera AS codigocarrera, tipomateria.nombretipomateria AS codigotipomateria FROM ((materia LEFT JOIN modalidadmateria ON materia.codigomodalidadmateria = modalidadmateria.codigomodalidadmateria) LEFT JOIN carrera ON materia.codigocarrera = carrera.codigocarrera) LEFT JOIN tipomateria ON materia.codigotipomateria = tipomateria.codigotipomateria WHERE %s ORDER BY %s", $NXTFilter__rsmateria1, $NXTSort__rsmateria1);
$rsmateria1 = $sala_adodb->SelectLimit($query_rsmateria1, $maxRows_rsmateria1, $startRow_rsmateria1) or die($sala_adodb->ErrorMsg());
if (isset($_GET['totalRows_rsmateria1'])) {
  $totalRows_rsmateria1 = $_GET['totalRows_rsmateria1'];
} else {
  $all_rsmateria1 = $sala_adodb->SelectLimit($query_rsmateria1) or die($sala_adodb->ErrorMsg());
  $totalRows_rsmateria1 = $all_rsmateria1->RecordCount();
}
$totalPages_rsmateria1 = (int)(($totalRows_rsmateria1-1)/$maxRows_rsmateria1);
// End List Recordset

$nav_listmateria1->checkBoundries();
 //PHP ADODB document - made with PHAkt 3.6.0?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
  .KT_col_codigomateria {width:140px; overflow:hidden;}
  .KT_col_nombremateria {width:700px; overflow:hidden;}
  .KT_col_codigomodalidadmateria {width:140px; overflow:hidden;}
  .KT_col_codigocarrera {width:350px; overflow:hidden;}
  .KT_col_codigotipomateria {width:140px; overflow:hidden;}
</style>
</head>

<body>

<div class="KT_tng" id="listmateria1">
  <h1> Materia
      <?php
  $nav_listmateria1->Prepare();
  require("../../../../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listmateria1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
        <?php 
  // Show IF Conditional region1 
  if (@$_GET['show_all_nav_listmateria1'] == 1) {
?>
        <?php echo $_SESSION['default_max_rows_nav_listmateria1']; ?>
        <?php 
  // else Conditional region1
  } else { ?>
        <?php } 
  // endif Conditional region1
?>
            <?php echo NXT_getResource("records"); ?></a> &nbsp; &nbsp;
            <?php 
  // Show IF Conditional region2 
  if (@$_SESSION['has_filter_tfi_listmateria1'] == 1) {
?>
            <a href="<?php echo $tfi_listmateria1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
            <?php 
  // else Conditional region2
  } else { ?>
            <a href="<?php echo $tfi_listmateria1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
            <?php } 
  // endif Conditional region2
?>
      </div>
      <table cellpadding="2" cellspacing="2" class="KT_tngtable">
        <thead>
          <tr class="verdoso">
            <th> <div align="center">
              <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
            </div></th>
            <th id="codigomateria" class="KT_sorter KT_col_codigomateria <?php echo $tso_listmateria1->getSortIcon('materia.codigomateria'); ?>"> <div align="center"><a href="<?php echo $tso_listmateria1->getSortLink('materia.codigomateria'); ?>">Codigomateria</a> </div></th>
            <th id="nombremateria" class="KT_sorter KT_col_nombremateria <?php echo $tso_listmateria1->getSortIcon('materia.nombremateria'); ?>"> <div align="center"><a href="<?php echo $tso_listmateria1->getSortLink('materia.nombremateria'); ?>">Nombremateria</a> </div></th>
            <th id="codigomodalidadmateria" class="KT_sorter KT_col_codigomodalidadmateria <?php echo $tso_listmateria1->getSortIcon('modalidadmateria.nombremodalidadmateria'); ?>"> <div align="center"><a href="<?php echo $tso_listmateria1->getSortLink('modalidadmateria.nombremodalidadmateria'); ?>">Codigomodalidadmateria</a> </div></th>
            <th id="codigocarrera" class="KT_sorter KT_col_codigocarrera <?php echo $tso_listmateria1->getSortIcon('carrera.nombrecarrera'); ?>"> <div align="center"><a href="<?php echo $tso_listmateria1->getSortLink('carrera.nombrecarrera'); ?>">Codigocarrera</a> </div></th>
            <th id="codigotipomateria" class="KT_sorter KT_col_codigotipomateria <?php echo $tso_listmateria1->getSortIcon('tipomateria.nombretipomateria'); ?>"> <div align="center"><a href="<?php echo $tso_listmateria1->getSortLink('tipomateria.nombretipomateria'); ?>">Codigotipomateria</a> </div></th>
            <th><div align="center"></div></th>
          </tr>
          <?php 
  // Show IF Conditional region3 
  if (@$_SESSION['has_filter_tfi_listmateria1'] == 1) {
?>
          <tr class="verde">
            <td><div align="center"></div></td>
            <td><div align="center">
              <input type="text" name="tfi_listmateria1_codigomateria" id="tfi_listmateria1_codigomateria" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listmateria1_codigomateria']); ?>" size="20" maxlength="100" />
            </div></td>
            <td><div align="center">
              <input type="text" name="tfi_listmateria1_nombremateria" id="tfi_listmateria1_nombremateria" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listmateria1_nombremateria']); ?>" size="20" maxlength="52" />
            </div></td>
            <td><div align="center">
              <select name="tfi_listmateria1_codigomodalidadmateria" id="tfi_listmateria1_codigomodalidadmateria">
                  <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listmateria1_codigomodalidadmateria']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
                  <?php
  while(!$Recordset1->EOF){
?>
                  <option value="<?php echo $Recordset1->Fields('codigomodalidadmateria')?>"<?php if (!(strcmp($Recordset1->Fields('codigomodalidadmateria'), @$_SESSION['tfi_listmateria1_codigomodalidadmateria']))) {echo "SELECTED";} ?>><?php echo $Recordset1->Fields('nombremodalidadmateria')?></option>
                  <?php
    $Recordset1->MoveNext();
  }
  $Recordset1->MoveFirst();
?>
                </select>
            </div></td>
            <td><div align="center">
              <select name="tfi_listmateria1_codigocarrera" id="tfi_listmateria1_codigocarrera">
                  <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listmateria1_codigocarrera']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
                  <?php
  while(!$Recordset2->EOF){
?>
                  <option value="<?php echo $Recordset2->Fields('codigocarrera')?>"<?php if (!(strcmp($Recordset2->Fields('codigocarrera'), @$_SESSION['tfi_listmateria1_codigocarrera']))) {echo "SELECTED";} ?>><?php echo $Recordset2->Fields('nombrecarrera')?></option>
                  <?php
    $Recordset2->MoveNext();
  }
  $Recordset2->MoveFirst();
?>
                </select>
            </div></td>
            <td><div align="center">
              <select name="tfi_listmateria1_codigotipomateria" id="tfi_listmateria1_codigotipomateria">
                  <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listmateria1_codigotipomateria']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
                  <?php
  while(!$Recordset3->EOF){
?>
                  <option value="<?php echo $Recordset3->Fields('codigotipomateria')?>"<?php if (!(strcmp($Recordset3->Fields('codigotipomateria'), @$_SESSION['tfi_listmateria1_codigotipomateria']))) {echo "SELECTED";} ?>><?php echo $Recordset3->Fields('nombretipomateria')?></option>
                  <?php
    $Recordset3->MoveNext();
  }
  $Recordset3->MoveFirst();
?>
                </select>
            </div></td>
            <td><div align="center">
              <input type="submit" name="tfi_listmateria1" value="<?php echo NXT_getResource("Filter"); ?>" />
            </div></td>
          </tr>
          <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rsmateria1 == 0) { // Show if recordset empty ?>
          <tr>
            <td colspan="7"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
          </tr>
          <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rsmateria1 > 0) { // Show if recordset not empty ?>
          <?php
  while (!$rsmateria1->EOF) { 
?>
          <tr class="amarrillento">
            <td><input type="checkbox" name="<?php echo "codigomateria".$rsmateria1->Fields('codigomateria');?>" class="id_checkbox" value="<?php echo $rsmateria1->Fields('codigomateria'); ?>" />
                <input type="hidden" name="codigomateria" class="id_field" value="<?php echo $rsmateria1->Fields('codigomateria'); ?>" />
            </td>
            <td><div class="KT_col_codigomateria"><?php echo KT_FormatForList($rsmateria1->Fields('codigomateria'), 20); ?></div></td>
            <td><div class="KT_col_nombremateria"><?php echo KT_FormatForList($rsmateria1->Fields('nombremateria'), 100); ?></div></td>
            <td><div class="KT_col_codigomodalidadmateria"><?php echo KT_FormatForList($rsmateria1->Fields('codigomodalidadmateria'), 20); ?></div></td>
            <td><div class="KT_col_codigocarrera"><?php echo KT_FormatForList($rsmateria1->Fields('codigocarrera'), 50); ?></div></td>
            <td><div class="KT_col_codigotipomateria"><?php echo KT_FormatForList($rsmateria1->Fields('codigotipomateria'), 20); ?></div></td>
            <td>&nbsp;  </td>
          </tr>
          <?php
    $rsmateria1->MoveNext(); 
  }
?>
          <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>        </div>
      </div>
      <div class="KT_bottombuttons">
        <div class="KT_operations">   </div>
        <span>&nbsp;</span>        </div>
    </form>
  </div>
  <?php
            $nav_listmateria1->Prepare();
            require("../../../../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
  <br class="clearfixplain" />
</div>
<p>&nbsp;</p>
</body>
</html>
<?php
$Recordset1->Close();

$Recordset2->Close();

$Recordset3->Close();

$rsmateria1->Close();
?>
