<?php /* Smarty version 2.3.0, created on 2008-04-07 11:01:33
         compiled from Default/message.tpl */ ?>
<table width="70%" align="center" cellpadding="0" cellspacing="0">
  <tr class="grayboxheader">
    <td width="14"><img src="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/box_left.gif" border="0" width="14"></td>
    <td background="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/box_bg.gif"><?php echo $this->_tpl_vars['message']['title']; ?>
</td>
    <td width="14"><img src="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/box_right.gif" border="0" width="14"></td>
  </tr>
</table>

<table width="70%" align="center" class="bordered_table">
  <tr>
    <td class="message"><?php echo $this->_tpl_vars['message']['text']; ?>
</td>
  </tr>
  <tr>
    <td align="center">
      [ <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/index.php">Main</a>
      <?php if (isset($this->_sections["admin"])) unset($this->_sections["admin"]);
$this->_sections["admin"]['name'] = "admin";
$this->_sections["admin"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["admin"]['show'] = (bool)$GLOBALS['HTTP_SESSION_VARS']['priv'][0][0];
$this->_sections["admin"]['max'] = $this->_sections["admin"]['loop'];
$this->_sections["admin"]['step'] = 1;
$this->_sections["admin"]['start'] = $this->_sections["admin"]['step'] > 0 ? 0 : $this->_sections["admin"]['loop']-1;
if ($this->_sections["admin"]['show']) {
    $this->_sections["admin"]['total'] = $this->_sections["admin"]['loop'];
    if ($this->_sections["admin"]['total'] == 0)
        $this->_sections["admin"]['show'] = false;
} else
    $this->_sections["admin"]['total'] = 0;
if ($this->_sections["admin"]['show']):

            for ($this->_sections["admin"]['index'] = $this->_sections["admin"]['start'], $this->_sections["admin"]['iteration'] = 1;
                 $this->_sections["admin"]['iteration'] <= $this->_sections["admin"]['total'];
                 $this->_sections["admin"]['index'] += $this->_sections["admin"]['step'], $this->_sections["admin"]['iteration']++):
$this->_sections["admin"]['rownum'] = $this->_sections["admin"]['iteration'];
$this->_sections["admin"]['index_prev'] = $this->_sections["admin"]['index'] - $this->_sections["admin"]['step'];
$this->_sections["admin"]['index_next'] = $this->_sections["admin"]['index'] + $this->_sections["admin"]['step'];
$this->_sections["admin"]['first']      = ($this->_sections["admin"]['iteration'] == 1);
$this->_sections["admin"]['last']       = ($this->_sections["admin"]['iteration'] == $this->_sections["admin"]['total']);
?>
        &nbsp;|&nbsp;<a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/admin.php">Admin</a>
      <?php endfor; endif; ?> ]
    </td>
  </tr>
</table>
<br>