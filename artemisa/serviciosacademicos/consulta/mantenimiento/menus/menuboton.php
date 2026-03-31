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
$formValidation->addField("nombremenuboton", true, "text", "", "", "", "");
$formValidation->addField("linkmenuboton", true, "text", "", "", "", "");
$formValidation->addField("codigoestadomenuboton", true, "text", "", "", "", "");
$formValidation->addField("nivelmenuboton", true, "numeric", "", "", "", "");
$formValidation->addField("posicionmenuboton", true, "numeric", "", "", "", "");
$formValidation->addField("codigogerarquiarol", true, "text", "", "", "", "");
$formValidation->addField("linkimagenboton", true, "text", "", "", "", "");
$formValidation->addField("scriptmenuboton", true, "text", "", "", "", "");
$formValidation->addField("codigotipomenuboton", true, "text", "", "", "", "");
$formValidation->addField("variablesmenuboton", true, "text", "", "", "", "");
$formValidation->addField("propiedadesimagenmenuboton", true, "text", "", "", "", "");
$formValidation->addField("propiedadesmenuboton", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

mysql_select_db($database_sala, $sala);
$query_Recordset1 = "SELECT * FROM estadomenuboton ORDER BY nombreestadomenuboton ASC";
$Recordset1 = mysql_query($query_Recordset1, $sala) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_sala, $sala);
$query_Recordset2 = "SELECT * FROM gerarquiarol ORDER BY nombregerarquiarol ASC";
$Recordset2 = mysql_query($query_Recordset2, $sala) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_sala, $sala);
$query_Recordset3 = "SELECT * FROM tipomenuboton ORDER BY nombretipomenuboton ASC";
$Recordset3 = mysql_query($query_Recordset3, $sala) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

// Make an insert transaction instance
$ins_menuboton = new tNG_multipleInsert($conn_sala);
$tNGs->addTransaction($ins_menuboton);
// Register triggers
$ins_menuboton->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_menuboton->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_menuboton->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../../../includes/nxt/back.php");
// Add columns
$ins_menuboton->setTable("menuboton");
$ins_menuboton->addColumn("nombremenuboton", "STRING_TYPE", "POST", "nombremenuboton");
$ins_menuboton->addColumn("linkmenuboton", "STRING_TYPE", "POST", "linkmenuboton");
$ins_menuboton->addColumn("codigoestadomenuboton", "STRING_TYPE", "POST", "codigoestadomenuboton");
$ins_menuboton->addColumn("nivelmenuboton", "NUMERIC_TYPE", "POST", "nivelmenuboton");
$ins_menuboton->addColumn("posicionmenuboton", "NUMERIC_TYPE", "POST", "posicionmenuboton");
$ins_menuboton->addColumn("codigogerarquiarol", "STRING_TYPE", "POST", "codigogerarquiarol");
$ins_menuboton->addColumn("linkimagenboton", "STRING_TYPE", "POST", "linkimagenboton");
$ins_menuboton->addColumn("scriptmenuboton", "STRING_TYPE", "POST", "scriptmenuboton");
$ins_menuboton->addColumn("codigotipomenuboton", "STRING_TYPE", "POST", "codigotipomenuboton");
$ins_menuboton->addColumn("variablesmenuboton", "STRING_TYPE", "POST", "variablesmenuboton");
$ins_menuboton->addColumn("propiedadesimagenmenuboton", "STRING_TYPE", "POST", "propiedadesimagenmenuboton");
$ins_menuboton->addColumn("propiedadesmenuboton", "STRING_TYPE", "POST", "propiedadesmenuboton");
$ins_menuboton->setPrimaryKey("idmenuboton", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_menuboton = new tNG_multipleUpdate($conn_sala);
$tNGs->addTransaction($upd_menuboton);
// Register triggers
$upd_menuboton->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_menuboton->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_menuboton->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../../../includes/nxt/back.php");
// Add columns
$upd_menuboton->setTable("menuboton");
$upd_menuboton->addColumn("nombremenuboton", "STRING_TYPE", "POST", "nombremenuboton");
$upd_menuboton->addColumn("linkmenuboton", "STRING_TYPE", "POST", "linkmenuboton");
$upd_menuboton->addColumn("codigoestadomenuboton", "STRING_TYPE", "POST", "codigoestadomenuboton");
$upd_menuboton->addColumn("nivelmenuboton", "NUMERIC_TYPE", "POST", "nivelmenuboton");
$upd_menuboton->addColumn("posicionmenuboton", "NUMERIC_TYPE", "POST", "posicionmenuboton");
$upd_menuboton->addColumn("codigogerarquiarol", "STRING_TYPE", "POST", "codigogerarquiarol");
$upd_menuboton->addColumn("linkimagenboton", "STRING_TYPE", "POST", "linkimagenboton");
$upd_menuboton->addColumn("scriptmenuboton", "STRING_TYPE", "POST", "scriptmenuboton");
$upd_menuboton->addColumn("codigotipomenuboton", "STRING_TYPE", "POST", "codigotipomenuboton");
$upd_menuboton->addColumn("variablesmenuboton", "STRING_TYPE", "POST", "variablesmenuboton");
$upd_menuboton->addColumn("propiedadesimagenmenuboton", "STRING_TYPE", "POST", "propiedadesimagenmenuboton");
$upd_menuboton->addColumn("propiedadesmenuboton", "STRING_TYPE", "POST", "propiedadesmenuboton");
$upd_menuboton->setPrimaryKey("idmenuboton", "NUMERIC_TYPE", "GET", "idmenuboton");

// Make an instance of the transaction object
$del_menuboton = new tNG_multipleDelete($conn_sala);
$tNGs->addTransaction($del_menuboton);
// Register triggers
$del_menuboton->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_menuboton->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../../../includes/nxt/back.php");
// Add columns
$del_menuboton->setTable("menuboton");
$del_menuboton->setPrimaryKey("idmenuboton", "NUMERIC_TYPE", "GET", "idmenuboton");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsmenuboton = $tNGs->getRecordset("menuboton");
$row_rsmenuboton = mysql_fetch_assoc($rsmenuboton);
$totalRows_rsmenuboton = mysql_num_rows($rsmenuboton);
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
<div align="center">
  <?php
	echo $tNGs->getErrorMsg();
?>
</div>
<div class="KT_tng">
  <h1 align="center">
    <?php 
// Show IF Conditional region1 
if (@$_GET['idmenuboton'] == "") {
?>
    <?php echo NXT_getResource("Insert_FH"); ?>
    <?php 
// else Conditional region1
} else { ?>
    <?php echo NXT_getResource("Update_FH"); ?>
    <?php } 
// endif Conditional region1
?>
    Menuboton </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <div align="center">
        <?php $cnt1 = 0; ?>
        <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rsmenuboton > 1) {
?>
      </div>
      <h2 align="center"><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
      <div align="center">
        <?php } 
// endif Conditional region1
?>
        <table align="center" cellpadding="2" cellspacing="2" class="KT_tngtable">
          <tr>
            <td class="verdoso"><label for="nombremenuboton_<?php echo $cnt1; ?>">Nombremenuboton:</label></td>
            <td class="amarrillento"><div align="left">
                <input type="text" name="nombremenuboton_<?php echo $cnt1; ?>" id="nombremenuboton_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsmenuboton['nombremenuboton']); ?>" size="32" maxlength="50" />
                <?php echo $tNGs->displayFieldHint("nombremenuboton");?> <?php echo $tNGs->displayFieldError("menuboton", "nombremenuboton", $cnt1); ?> </div></td>
          </tr>
          <tr>
            <td class="verdoso"><label for="linkmenuboton_<?php echo $cnt1; ?>">Linkmenuboton:</label></td>
            <td class="amarrillento"><div align="left">
                <input type="text" name="linkmenuboton_<?php echo $cnt1; ?>" id="linkmenuboton_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsmenuboton['linkmenuboton']); ?>" size="32" maxlength="200" />
                <?php echo $tNGs->displayFieldHint("linkmenuboton");?> <?php echo $tNGs->displayFieldError("menuboton", "linkmenuboton", $cnt1); ?> </div></td>
          </tr>
          <tr>
            <td class="verdoso"><label for="codigoestadomenuboton_<?php echo $cnt1; ?>">Codigoestadomenuboton:</label></td>
            <td class="amarrillento"><div align="left">
                  <select name="codigoestadomenuboton_<?php echo $cnt1; ?>" id="codigoestadomenuboton_<?php echo $cnt1; ?>">
                    <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                    <?php 
do {  
?>
                    <option value="<?php echo $row_Recordset1['codigoestadomenuboton']?>"<?php if (!(strcmp($row_Recordset1['codigoestadomenuboton'], $row_rsmenuboton['codigoestadomenuboton']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['nombreestadomenuboton']?></option>
                    <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
                  </select>
                <?php echo $tNGs->displayFieldError("menuboton", "codigoestadomenuboton", $cnt1); ?> </div></td>
          </tr>
          <tr>
            <td class="verdoso"><label for="nivelmenuboton_<?php echo $cnt1; ?>">Nivelmenuboton:</label></td>
            <td class="amarrillento"><div align="left">
                <input type="text" name="nivelmenuboton_<?php echo $cnt1; ?>" id="nivelmenuboton_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsmenuboton['nivelmenuboton']); ?>" size="6" />
                <?php echo $tNGs->displayFieldHint("nivelmenuboton");?> <?php echo $tNGs->displayFieldError("menuboton", "nivelmenuboton", $cnt1); ?> </div></td>
          </tr>
          <tr>
            <td class="verdoso"><label for="posicionmenuboton_<?php echo $cnt1; ?>">Posicionmenuboton:</label></td>
            <td class="amarrillento"><div align="left">
                <input type="text" name="posicionmenuboton_<?php echo $cnt1; ?>" id="posicionmenuboton_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsmenuboton['posicionmenuboton']); ?>" size="6" />
                <?php echo $tNGs->displayFieldHint("posicionmenuboton");?> <?php echo $tNGs->displayFieldError("menuboton", "posicionmenuboton", $cnt1); ?> </div></td>
          </tr>
          <tr>
            <td class="verdoso"><label for="codigogerarquiarol_<?php echo $cnt1; ?>">Codigogerarquiarol:</label></td>
            <td class="amarrillento"><div align="left">
                  <select name="codigogerarquiarol_<?php echo $cnt1; ?>" id="codigogerarquiarol_<?php echo $cnt1; ?>">
                    <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                    <?php 
do {  
?>
                    <option value="<?php echo $row_Recordset2['codigogerarquiarol']?>"<?php if (!(strcmp($row_Recordset2['codigogerarquiarol'], $row_rsmenuboton['codigogerarquiarol']))) {echo "SELECTED";} ?>><?php echo $row_Recordset2['nombregerarquiarol']?></option>
                    <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
                  </select>
                <?php echo $tNGs->displayFieldError("menuboton", "codigogerarquiarol", $cnt1); ?> </div></td>
          </tr>
          <tr>
            <td class="verdoso"><label for="linkimagenboton_<?php echo $cnt1; ?>">Linkimagenboton:</label></td>
            <td class="amarrillento"><div align="left">
                <input type="text" name="linkimagenboton_<?php echo $cnt1; ?>" id="linkimagenboton_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsmenuboton['linkimagenboton']); ?>" size="32" maxlength="200" />
                <?php echo $tNGs->displayFieldHint("linkimagenboton");?> <?php echo $tNGs->displayFieldError("menuboton", "linkimagenboton", $cnt1); ?> </div></td>
          </tr>
          <tr>
            <td class="verdoso"><label for="scriptmenuboton_<?php echo $cnt1; ?>">Scriptmenuboton:</label></td>
            <td class="amarrillento"><div align="left">
                <input type="text" name="scriptmenuboton_<?php echo $cnt1; ?>" id="scriptmenuboton_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsmenuboton['scriptmenuboton']); ?>" size="32" maxlength="200" />
                <?php echo $tNGs->displayFieldHint("scriptmenuboton");?> <?php echo $tNGs->displayFieldError("menuboton", "scriptmenuboton", $cnt1); ?> </div></td>
          </tr>
          <tr>
            <td class="verdoso"><label for="codigotipomenuboton_<?php echo $cnt1; ?>">Codigotipomenuboton:</label></td>
            <td class="amarrillento"><div align="left">
                  <select name="codigotipomenuboton_<?php echo $cnt1; ?>" id="codigotipomenuboton_<?php echo $cnt1; ?>">
                    <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                    <?php 
do {  
?>
                    <option value="<?php echo $row_Recordset3['codigotipomenuboton']?>"<?php if (!(strcmp($row_Recordset3['codigotipomenuboton'], $row_rsmenuboton['codigotipomenuboton']))) {echo "SELECTED";} ?>><?php echo $row_Recordset3['nombretipomenuboton']?></option>
                    <?php
} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
  $rows = mysql_num_rows($Recordset3);
  if($rows > 0) {
      mysql_data_seek($Recordset3, 0);
	  $row_Recordset3 = mysql_fetch_assoc($Recordset3);
  }
?>
                  </select>
                <?php echo $tNGs->displayFieldError("menuboton", "codigotipomenuboton", $cnt1); ?> </div></td>
          </tr>
          <tr>
            <td class="verdoso"><label for="variablesmenuboton_<?php echo $cnt1; ?>">Variablesmenuboton:</label></td>
            <td class="amarrillento"><div align="left">
                <input type="text" name="variablesmenuboton_<?php echo $cnt1; ?>" id="variablesmenuboton_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsmenuboton['variablesmenuboton']); ?>" size="32" maxlength="200" />
                <?php echo $tNGs->displayFieldHint("variablesmenuboton");?> <?php echo $tNGs->displayFieldError("menuboton", "variablesmenuboton", $cnt1); ?> </div></td>
          </tr>
          <tr>
            <td class="verdoso"><label for="propiedadesimagenmenuboton_<?php echo $cnt1; ?>">Propiedadesimagenmenuboton:</label></td>
            <td class="amarrillento"><div align="left">
                <input type="text" name="propiedadesimagenmenuboton_<?php echo $cnt1; ?>" id="propiedadesimagenmenuboton_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsmenuboton['propiedadesimagenmenuboton']); ?>" size="32" maxlength="200" />
                <?php echo $tNGs->displayFieldHint("propiedadesimagenmenuboton");?> <?php echo $tNGs->displayFieldError("menuboton", "propiedadesimagenmenuboton", $cnt1); ?> </div></td>
          </tr>
          <tr>
            <td class="verdoso"><label for="propiedadesmenuboton_<?php echo $cnt1; ?>">Propiedadesmenuboton:</label></td>
            <td class="amarrillento"><div align="left">
                <input type="text" name="propiedadesmenuboton_<?php echo $cnt1; ?>" id="propiedadesmenuboton_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsmenuboton['propiedadesmenuboton']); ?>" size="32" maxlength="200" />
                <?php echo $tNGs->displayFieldHint("propiedadesmenuboton");?> <?php echo $tNGs->displayFieldError("menuboton", "propiedadesmenuboton", $cnt1); ?> </div></td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_menuboton_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsmenuboton['kt_pk_menuboton']); ?>" />
        <?php } while ($row_rsmenuboton = mysql_fetch_assoc($rsmenuboton)); ?>
      </div>
      <div class="KT_bottombuttons">
        <div>
          <div align="center">
            <?php 
      // Show IF Conditional region1
      if (@$_GET['idmenuboton'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
          </div>
          <div class="KT_operations">
            <div align="center">
              <input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, 'idmenuboton')" />
            </div>
          </div>
          <div align="center">
            <input type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Update_FB"); ?>" />
            <input type="submit" name="KT_Delete1" value="<?php echo NXT_getResource("Delete_FB"); ?>" onclick="return confirm('<?php echo NXT_getResource("Are you sure?"); ?>');" />
            <?php }
      // endif Conditional region1
      ?>
            <input type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancel_FB"); ?>" onclick="return UNI_navigateCancel(event, '../../../../includes/nxt/back.php')" />
          </div>
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
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);
?>
