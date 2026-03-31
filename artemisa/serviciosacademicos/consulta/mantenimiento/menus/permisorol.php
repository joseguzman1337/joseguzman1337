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
$formValidation->addField("idmenuopcion", true, "numeric", "", "", "", "");
$formValidation->addField("idrol", true, "numeric", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

mysql_select_db($database_sala, $sala);
$query_idemenuopcion = "SELECT idmenuopcion, nombremenuopcion FROM menuopcion ORDER BY nombremenuopcion ASC";
$idemenuopcion = mysql_query($query_idemenuopcion, $sala) or die(mysql_error());
$row_idemenuopcion = mysql_fetch_assoc($idemenuopcion);
$totalRows_idemenuopcion = mysql_num_rows($idemenuopcion);

mysql_select_db($database_sala, $sala);
$query_idrol = "SELECT idrol, nombrerol FROM rol ORDER BY nombrerol ASC";
$idrol = mysql_query($query_idrol, $sala) or die(mysql_error());
$row_idrol = mysql_fetch_assoc($idrol);
$totalRows_idrol = mysql_num_rows($idrol);

// Make an insert transaction instance
$ins_permisorol = new tNG_multipleInsert($conn_sala);
$tNGs->addTransaction($ins_permisorol);
// Register triggers
$ins_permisorol->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_permisorol->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_permisorol->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../../../includes/nxt/back.php");
// Add columns
$ins_permisorol->setTable("permisorol");
$ins_permisorol->addColumn("idmenuopcion", "NUMERIC_TYPE", "POST", "idmenuopcion");
$ins_permisorol->addColumn("idrol", "STRING_TYPE", "POST", "idrol");
$ins_permisorol->setPrimaryKey("idrol", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_permisorol = new tNG_multipleUpdate($conn_sala);
$tNGs->addTransaction($upd_permisorol);
// Register triggers
$upd_permisorol->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_permisorol->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_permisorol->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../../../includes/nxt/back.php");
// Add columns
$upd_permisorol->setTable("permisorol");
$upd_permisorol->addColumn("idmenuopcion", "NUMERIC_TYPE", "POST", "idmenuopcion");
$upd_permisorol->addColumn("idrol", "STRING_TYPE", "POST", "idrol");
$upd_permisorol->setPrimaryKey("idrol", "NUMERIC_TYPE", "GET", "idrol");

// Make an instance of the transaction object
$del_permisorol = new tNG_multipleDelete($conn_sala);
$tNGs->addTransaction($del_permisorol);
// Register triggers
$del_permisorol->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_permisorol->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../../../includes/nxt/back.php");
// Add columns
$del_permisorol->setTable("permisorol");
$del_permisorol->setPrimaryKey("idrol", "NUMERIC_TYPE", "GET", "idrol");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rspermisorol = $tNGs->getRecordset("permisorol");
$row_rspermisorol = mysql_fetch_assoc($rspermisorol);
$totalRows_rspermisorol = mysql_num_rows($rspermisorol);
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
if (@$_GET['idrol'] == "") {
?>
    <?php echo NXT_getResource("Insert_FH"); ?>
    <?php 
// else Conditional region1
} else { ?>
    <?php echo NXT_getResource("Update_FH"); ?>
    <?php } 
// endif Conditional region1
?>
    Permisorol </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
      <?php $cnt1++; ?>
      <?php 
// Show IF Conditional region1 
if (@$totalRows_rspermisorol > 1) {
?>
      <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
      <?php } 
// endif Conditional region1
?>
      <table cellpadding="2" cellspacing="2" class="KT_tngtable">
        <tr>
          <td class="verdoso"><label for="idmenuopcion_<?php echo $cnt1; ?>">Idmenuopcion:</label></td>
          <td class="amarrillento"><select name="idmenuopcion_<?php echo $cnt1; ?>" id="idmenuopcion_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_idemenuopcion['idmenuopcion']?>"<?php if (!(strcmp($row_idemenuopcion['idmenuopcion'], $row_rspermisorol['idmenuopcion']))) {echo "SELECTED";} ?>><?php echo $row_idemenuopcion['nombremenuopcion']?></option>
              <?php
} while ($row_idemenuopcion = mysql_fetch_assoc($idemenuopcion));
  $rows = mysql_num_rows($idemenuopcion);
  if($rows > 0) {
      mysql_data_seek($idemenuopcion, 0);
	  $row_idemenuopcion = mysql_fetch_assoc($idemenuopcion);
  }
?>
            </select>
              <?php echo $tNGs->displayFieldError("permisorol", "idmenuopcion", $cnt1); ?> </td>
        </tr>
        <tr>
          <td class="verdoso"><label for="idrol_<?php echo $cnt1; ?>">Idrol:</label></td>
          <td class="amarrillento"><select name="idrol_<?php echo $cnt1; ?>" id="idrol_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_idrol['idrol']?>"<?php if (!(strcmp($row_idrol['idrol'], $row_rspermisorol['idrol']))) {echo "SELECTED";} ?>><?php echo $row_idrol['nombrerol']?></option>
              <?php
} while ($row_idrol = mysql_fetch_assoc($idrol));
  $rows = mysql_num_rows($idrol);
  if($rows > 0) {
      mysql_data_seek($idrol, 0);
	  $row_idrol = mysql_fetch_assoc($idrol);
  }
?>
            </select>
              <?php echo $tNGs->displayFieldError("permisorol", "idrol", $cnt1); ?> </td>
        </tr>
      </table>
      <input type="hidden" name="kt_pk_permisorol_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rspermisorol['kt_pk_permisorol']); ?>" />
      <?php } while ($row_rspermisorol = mysql_fetch_assoc($rspermisorol)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['idrol'] == "") {
      ?>
          <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
          <?php 
      // else Conditional region1
      } else { ?>
          <div class="KT_operations">
            <input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, 'idrol')" />
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
mysql_free_result($idemenuopcion);

mysql_free_result($idrol);
?>
