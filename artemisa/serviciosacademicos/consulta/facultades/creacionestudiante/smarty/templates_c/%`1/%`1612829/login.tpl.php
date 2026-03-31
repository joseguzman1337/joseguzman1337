<?php /* Smarty version 2.3.0, created on 2008-04-07 10:59:59
         compiled from Default/login.tpl */ ?>
<table width="70%" align="center" cellpadding="0" cellspacing="0">
  <tr class="grayboxheader">
    <td width="14"><img src="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/box_left.gif" border="0" width="14"></td>
    <td background="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/box_bg.gif">User Login</td>
    <td width="14"><img src="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/box_right.gif" border="0" width="14"></td>
  </tr>
</table>

<table width="70%" align="center" class="bordered_table">
  <?php if (isset($this->_sections["message"])) unset($this->_sections["message"]);
$this->_sections["message"]['name'] = "message";
$this->_sections["message"]['show'] = (bool)$this->_tpl_vars['data']['message'];
$this->_sections["message"]['loop'] = 1;
$this->_sections["message"]['max'] = $this->_sections["message"]['loop'];
$this->_sections["message"]['step'] = 1;
$this->_sections["message"]['start'] = $this->_sections["message"]['step'] > 0 ? 0 : $this->_sections["message"]['loop']-1;
if ($this->_sections["message"]['show']) {
    $this->_sections["message"]['total'] = $this->_sections["message"]['loop'];
    if ($this->_sections["message"]['total'] == 0)
        $this->_sections["message"]['show'] = false;
} else
    $this->_sections["message"]['total'] = 0;
if ($this->_sections["message"]['show']):

            for ($this->_sections["message"]['index'] = $this->_sections["message"]['start'], $this->_sections["message"]['iteration'] = 1;
                 $this->_sections["message"]['iteration'] <= $this->_sections["message"]['total'];
                 $this->_sections["message"]['index'] += $this->_sections["message"]['step'], $this->_sections["message"]['iteration']++):
$this->_sections["message"]['rownum'] = $this->_sections["message"]['iteration'];
$this->_sections["message"]['index_prev'] = $this->_sections["message"]['index'] - $this->_sections["message"]['step'];
$this->_sections["message"]['index_next'] = $this->_sections["message"]['index'] + $this->_sections["message"]['step'];
$this->_sections["message"]['first']      = ($this->_sections["message"]['iteration'] == 1);
$this->_sections["message"]['last']       = ($this->_sections["message"]['iteration'] == $this->_sections["message"]['total']);
?>
    <tr><td class="error"><?php echo $this->_tpl_vars['data']['message']; ?>
</td></tr>
  <?php endfor; endif; ?>
  <tr>
    <td align="center">
      <form method="POST" action="<?php echo $this->_tpl_vars['conf']['html']; ?>
/<?php echo $this->_tpl_vars['data']['page']; ?>
" name="login_form">
        <?php if (isset($this->_sections["h"])) unset($this->_sections["h"]);
$this->_sections["h"]['name'] = "h";
$this->_sections["h"]['loop'] = is_array($this->_tpl_vars['data']['hiddenkey']) ? count($this->_tpl_vars['data']['hiddenkey']) : max(0, (int)$this->_tpl_vars['data']['hiddenkey']);
$this->_sections["h"]['show'] = true;
$this->_sections["h"]['max'] = $this->_sections["h"]['loop'];
$this->_sections["h"]['step'] = 1;
$this->_sections["h"]['start'] = $this->_sections["h"]['step'] > 0 ? 0 : $this->_sections["h"]['loop']-1;
if ($this->_sections["h"]['show']) {
    $this->_sections["h"]['total'] = $this->_sections["h"]['loop'];
    if ($this->_sections["h"]['total'] == 0)
        $this->_sections["h"]['show'] = false;
} else
    $this->_sections["h"]['total'] = 0;
if ($this->_sections["h"]['show']):

            for ($this->_sections["h"]['index'] = $this->_sections["h"]['start'], $this->_sections["h"]['iteration'] = 1;
                 $this->_sections["h"]['iteration'] <= $this->_sections["h"]['total'];
                 $this->_sections["h"]['index'] += $this->_sections["h"]['step'], $this->_sections["h"]['iteration']++):
$this->_sections["h"]['rownum'] = $this->_sections["h"]['iteration'];
$this->_sections["h"]['index_prev'] = $this->_sections["h"]['index'] - $this->_sections["h"]['step'];
$this->_sections["h"]['index_next'] = $this->_sections["h"]['index'] + $this->_sections["h"]['step'];
$this->_sections["h"]['first']      = ($this->_sections["h"]['iteration'] == 1);
$this->_sections["h"]['last']       = ($this->_sections["h"]['iteration'] == $this->_sections["h"]['total']);
?>
          <input type="hidden" name="<?php echo $this->_tpl_vars['data']['hiddenkey'][$this->_sections['h']['index']]; ?>
" value="<?php echo $this->_tpl_vars['data']['hiddenval'][$this->_sections['h']['index']]; ?>
">
        <?php endfor; endif; ?>
        Please enter a username and password:
        <br>
        Username: <input type="text" name="username" value="<?php echo $this->_tpl_vars['data']['username']; ?>
" size="15" maxlength="25">
        Password: <input type="password" name="password" size="15" maxlength="25">
        <br>
        <input type="submit" value="Enter">
      </form>

      <div style="text-align:center;margin-top:20px">
        [ <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/index.php">Main</a> ]
      </div>
    </td>
  </tr>
</table>
<script language="JavaScript">
document.login_form.username.focus();
</script>