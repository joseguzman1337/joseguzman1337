<?php require_once('../../../Connections/sala2.php'); ?>
<?php
// Load the common classes
require_once('../../../../includes/common/KT_common.php');

// Load the tNG classes
require_once('../../../../includes/tng/tNG.inc.php');

// Load the KT_back class
require_once('../../../../includes/nxt/KT_back.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../../../../");

// Make unified connection variable
$conn_sala = new KT_connection($sala, $database_sala);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("nombremenuopcion", true, "text", "", "", "", "");
$formValidation->addField("linkmenuopcion", true, "text", "", "", "", "");
$formValidation->addField("codigoestadomenuopcion", true, "text", "", "", "", "");
$formValidation->addField("nivelmenuopcion", true, "numeric", "", "", "", "");
$formValidation->addField("posicionmenuopcion", true, "numeric", "", "", "", "");
$formValidation->addField("codigogerarquiarol", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

mysql_select_db($database_sala, $sala);
$query_codigoestadomenuopcion = "SELECT * FROM estadomenuopcion ORDER BY nombreestadomenuopcion ASC";
$codigoestadomenuopcion = mysql_query($query_codigoestadomenuopcion, $sala) or die(mysql_error());
$row_codigoestadomenuopcion = mysql_fetch_assoc($codigoestadomenuopcion);
$totalRows_codigoestadomenuopcion = mysql_num_rows($codigoestadomenuopcion);

mysql_select_db($database_sala, $sala);
$query_gerarquiarol = "SELECT * FROM gerarquiarol ORDER BY nombregerarquiarol ASC";
$gerarquiarol = mysql_query($query_gerarquiarol, $sala) or die(mysql_error());
$row_gerarquiarol = mysql_fetch_assoc($gerarquiarol);
$totalRows_gerarquiarol = mysql_num_rows($gerarquiarol);

// Make an insert transaction instance
$ins_menuopcion = new tNG_multipleInsert($conn_sala);
$tNGs->addTransaction($ins_menuopcion);
// Register triggers
$ins_menuopcion->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_menuopcion->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_menuopcion->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../../../includes/nxt/back.php");
// Add columns
$ins_menuopcion->setTable("menuopcion");
$ins_menuopcion->addColumn("nombremenuopcion", "STRING_TYPE", "POST", "nombremenuopcion");
$ins_menuopcion->addColumn("linkmenuopcion", "STRING_TYPE", "POST", "linkmenuopcion");
$ins_menuopcion->addColumn("codigoestadomenuopcion", "STRING_TYPE", "POST", "codigoestadomenuopcion");
$ins_menuopcion->addColumn("nivelmenuopcion", "NUMERIC_TYPE", "POST", "nivelmenuopcion");
$ins_menuopcion->addColumn("posicionmenuopcion", "NUMERIC_TYPE", "POST", "posicionmenuopcion");
$ins_menuopcion->addColumn("codigogerarquiarol", "STRING_TYPE", "POST", "codigogerarquiarol");
$ins_menuopcion->setPrimaryKey("idmenuopcion", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_menuopcion = new tNG_multipleUpdate($conn_sala);
$tNGs->addTransaction($upd_menuopcion);
// Register triggers
$upd_menuopcion->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_menuopcion->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_menuopcion->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../../../includes/nxt/back.php");
// Add columns
$upd_menuopcion->setTable("menuopcion");
$upd_menuopcion->addColumn("nombremenuopcion", "STRING_TYPE", "POST", "nombremenuopcion");
$upd_menuopcion->addColumn("linkmenuopcion", "STRING_TYPE", "POST", "linkmenuopcion");
$upd_menuopcion->addColumn("codigoestadomenuopcion", "STRING_TYPE", "POST", "codigoestadomenuopcion");
$upd_menuopcion->addColumn("nivelmenuopcion", "NUMERIC_TYPE", "POST", "nivelmenuopcion");
$upd_menuopcion->addColumn("posicionmenuopcion", "NUMERIC_TYPE", "POST", "posicionmenuopcion");
$upd_menuopcion->addColumn("codigogerarquiarol", "STRING_TYPE", "POST", "codigogerarquiarol");
$upd_menuopcion->setPrimaryKey("idmenuopcion", "NUMERIC_TYPE", "GET", "idmenuopcion");

// Make an instance of the transaction object
$del_menuopcion = new tNG_multipleDelete($conn_sala);
$tNGs->addTransaction($del_menuopcion);
// Register triggers
$del_menuopcion->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_menuopcion->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../../../includes/nxt/back.php");
// Add columns
$del_menuopcion->setTable("menuopcion");
$del_menuopcion->setPrimaryKey("idmenuopcion", "NUMERIC_TYPE", "GET", "idmenuopcion");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsmenuopcion = $tNGs->getRecordset("menuopcion");
$row_rsmenuopcion = mysql_fetch_assoc($rsmenuopcion);
$totalRows_rsmenuopcion = mysql_num_rows($rsmenuopcion);
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
<?php echo $tNGs->displayValidationRules();?>
<script src="../../../../includes/nxt/scripts/form.js" type="text/javascript"></script>
<script src="../../../../includes/nxt/scripts/form.js.php" type="text/javascript"></script>
<script type="text/javascript">
$NXT_FORM_SETTINGS = {
  duplicate_buttons: false,
  show_as_grid: true,
  merge_down_value: true
}
</script>
</head>

<body>
<?php
	echo $tNGs->getErrorMsg();
?>
<div class="KT_tng">
  <h1>
    <?php 
// Show IF Conditional region1 
if (@$_GET['idmenuopcion'] == "") {
?>
    <?php echo NXT_getResource("Insert_FH"); ?>
    <?php 
// else Conditional region1
} else { ?>
    <?php echo NXT_getResource("Update_FH"); ?>
    <?php } 
// endif Conditional region1
?>
    Menuopcion </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
      <?php $cnt1++; ?>
      <?php 
// Show IF Conditional region1 
if (@$totalRows_rsmenuopcion > 1) {
?>
      <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
      <?php } 
// endif Conditional region1
?>
      <table cellpadding="2" cellspacing="2" class="KT_tngtable">
        <tr>
          <td class="verdoso"><label for="nombremenuopcion_<?php echo $cnt1; ?>">Nombremenuopcion:</label></td>
          <td class="amarrillento"><input type="text" name="nombremenuopcion_<?php echo $cnt1; ?>" id="nombremenuopcion_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsmenuopcion['nombremenuopcion']); ?>" size="32" maxlength="70" />
              <?php echo $tNGs->displayFieldHint("nombremenuopcion");?> <?php echo $tNGs->displayFieldError("menuopcion", "nombremenuopcion", $cnt1); ?> </td>
        </tr>
        <tr>
          <td class="verdoso"><label for="linkmenuopcion_<?php echo $cnt1; ?>">Linkmenuopcion:</label></td>
          <td class="amarrillento"><input type="text" name="linkmenuopcion_<?php echo $cnt1; ?>" id="linkmenuopcion_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsmenuopcion['linkmenuopcion']); ?>" size="32" maxlength="200" />
              <?php echo $tNGs->displayFieldHint("linkmenuopcion");?> <?php echo $tNGs->displayFieldError("menuopcion", "linkmenuopcion", $cnt1); ?> </td>
        </tr>
        <tr>
          <td class="verdoso"><label for="codigoestadomenuopcion_<?php echo $cnt1; ?>">Codigoestadomenuopcion:</label></td>
          <td class="amarrillento"><select name="codigoestadomenuopcion_<?php echo $cnt1; ?>" id="codigoestadomenuopcion_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_codigoestadomenuopcion['codigoestadomenuopcion']?>"<?php if (!(strcmp($row_codigoestadomenuopcion['codigoestadomenuopcion'], $row_rsmenuopcion['codigoestadomenuopcion']))) {echo "SELECTED";} ?>><?php echo $row_codigoestadomenuopcion['nombreestadomenuopcion']?></option>
              <?php
} while ($row_codigoestadomenuopcion = mysql_fetch_assoc($codigoestadomenuopcion));
  $rows = mysql_num_rows($codigoestadomenuopcion);
  if($rows > 0) {
      mysql_data_seek($codigoestadomenuopcion, 0);
	  $row_codigoestadomenuopcion = mysql_fetch_assoc($codigoestadomenuopcion);
  }
?>
            </select>
              <?php echo $tNGs->displayFieldError("menuopcion", "codigoestadomenuopcion", $cnt1); ?> </td>
        </tr>
        <tr>
          <td class="verdoso"><label for="nivelmenuopcion_<?php echo $cnt1; ?>">Nivelmenuopcion:</label></td>
          <td class="amarrillento"><input type="text" name="nivelmenuopcion_<?php echo $cnt1; ?>" id="nivelmenuopcion_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsmenuopcion['nivelmenuopcion']); ?>" size="6" />
              <?php echo $tNGs->displayFieldHint("nivelmenuopcion");?> <?php echo $tNGs->displayFieldError("menuopcion", "nivelmenuopcion", $cnt1); ?> </td>
        </tr>
        <tr>
          <td class="verdoso"><label for="posicionmenuopcion_<?php echo $cnt1; ?>">Posicionmenuopcion:</label></td>
          <td class="amarrillento"><input type="text" name="posicionmenuopcion_<?php echo $cnt1; ?>" id="posicionmenuopcion_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsmenuopcion['posicionmenuopcion']); ?>" size="6" />
              <?php echo $tNGs->displayFieldHint("posicionmenuopcion");?> <?php echo $tNGs->displayFieldError("menuopcion", "posicionmenuopcion", $cnt1); ?> </td>
        </tr>
        <tr>
          <td class="verdoso"><label for="codigogerarquiarol_<?php echo $cnt1; ?>">Codigogerarquiarol:</label></td>
          <td class="amarrillento"><select name="codigogerarquiarol_<?php echo $cnt1; ?>" id="codigogerarquiarol_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_gerarquiarol['codigogerarquiarol']?>"<?php if (!(strcmp($row_gerarquiarol['codigogerarquiarol'], $row_rsmenuopcion['codigogerarquiarol']))) {echo "SELECTED";} ?>><?php echo $row_gerarquiarol['nombregerarquiarol']?></option>
              <?php
} while ($row_gerarquiarol = mysql_fetch_assoc($gerarquiarol));
  $rows = mysql_num_rows($gerarquiarol);
  if($rows > 0) {
      mysql_data_seek($gerarquiarol, 0);
	  $row_gerarquiarol = mysql_fetch_assoc($gerarquiarol);
  }
?>
            </select>
              <?php echo $tNGs->displayFieldError("menuopcion", "codigogerarquiarol", $cnt1); ?> </td>
        </tr>
      </table>
      <input type="hidden" name="kt_pk_menuopcion_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsmenuopcion['kt_pk_menuopcion']); ?>" />
      <?php } while ($row_rsmenuopcion = mysql_fetch_assoc($rsmenuopcion)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['idmenuopcion'] == "") {
      ?>
          <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
          <?php 
      // else Conditional region1
      } else { ?>
          <div class="KT_operations">
            <input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, 'idmenuopcion')" />
          </div>
          <input type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Update_FB"); ?>" />
          <input type="submit" name="KT_Delete1" value="<?php echo NXT_getResource("Delete_FB"); ?>" onclick="return confirm('<?php echo NXT_getResource("Are you sure?"); ?>');" />
          <?php }
      // endif Conditional region1
      ?>
          <input type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancel_FB"); ?>" onclick="return UNI_navigateCancel(event, '../../../../includes/nxt/back.php')" />
        </div>
      </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($codigoestadomenuopcion);

mysql_free_result($gerarquiarol);
?>
