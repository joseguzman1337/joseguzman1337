<?php /* Smarty version 2.3.0, created on 2008-04-07 09:46:43
         compiled from Default/error.tpl */ ?>
<table width="70%" align="center" cellpadding="0" cellspacing="0">
  <tr class="grayboxheader">
    <td width="14"><img src="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/box_left.gif" border="0" width="14"></td>
    <td background="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/box_bg.gif">Error</td>
    <td width="14"><img src="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/box_right.gif" border="0" width="14"></td>
  </tr>
</table>
<table width="70%" align="center" class="bordered_table">
  <tr>
    <td class="error"><?php echo $this->_tpl_vars['error']; ?>
</td>
  </tr>
  <tr>
    <td align="center">
      [ <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/index.php">Main</a>
      <?php if (isset($this->_sections["admin_link"])) unset($this->_sections["admin_link"]);
$this->_sections["admin_link"]['name'] = "admin_link";
$this->_sections["admin_link"]['show'] = (bool)$this->_tpl_vars['conf']['show_admin_link'];
$this->_sections["admin_link"]['loop'] = 1;
$this->_sections["admin_link"]['max'] = $this->_sections["admin_link"]['loop'];
$this->_sections["admin_link"]['step'] = 1;
$this->_sections["admin_link"]['start'] = $this->_sections["admin_link"]['step'] > 0 ? 0 : $this->_sections["admin_link"]['loop']-1;
if ($this->_sections["admin_link"]['show']) {
    $this->_sections["admin_link"]['total'] = $this->_sections["admin_link"]['loop'];
    if ($this->_sections["admin_link"]['total'] == 0)
        $this->_sections["admin_link"]['show'] = false;
} else
    $this->_sections["admin_link"]['total'] = 0;
if ($this->_sections["admin_link"]['show']):

            for ($this->_sections["admin_link"]['index'] = $this->_sections["admin_link"]['start'], $this->_sections["admin_link"]['iteration'] = 1;
                 $this->_sections["admin_link"]['iteration'] <= $this->_sections["admin_link"]['total'];
                 $this->_sections["admin_link"]['index'] += $this->_sections["admin_link"]['step'], $this->_sections["admin_link"]['iteration']++):
$this->_sections["admin_link"]['rownum'] = $this->_sections["admin_link"]['iteration'];
$this->_sections["admin_link"]['index_prev'] = $this->_sections["admin_link"]['index'] - $this->_sections["admin_link"]['step'];
$this->_sections["admin_link"]['index_next'] = $this->_sections["admin_link"]['index'] + $this->_sections["admin_link"]['step'];
$this->_sections["admin_link"]['first']      = ($this->_sections["admin_link"]['iteration'] == 1);
$this->_sections["admin_link"]['last']       = ($this->_sections["admin_link"]['iteration'] == $this->_sections["admin_link"]['total']);
?>
        &nbsp;|&nbsp;<a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/admin.php">Admin</a>
      <?php endfor; endif; ?> ]
    </td>
  </tr>
</table>

<br />