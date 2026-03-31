<?php /* Smarty version 2.3.0, created on 2008-04-07 11:06:56
         compiled from Default/edit_survey.tpl */ ?>
<table width="70%" align="center" cellpadding="0" cellspacing="0">
  <tr class="grayboxheader">
    <td width="14"></td>
    <td background="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
">Editar Encuesta</td>
    <td width="14"></td>
  </tr>
</table>
<table width="70%" align="center" class="bordered_table">

<?php echo $this->_tpl_vars['data']['links']; ?>


  <tr>
    <td>
      <?php echo $this->_tpl_vars['data']['content']; ?>

    </td>
  </tr>

  <tr>
    <td align="center">
      <br />
      [ <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/index.php">Volver al inicio</a>
      &nbsp;|&nbsp;
      <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/admin.php">Admin</a> ]
    </td>
  </tr>
</table>