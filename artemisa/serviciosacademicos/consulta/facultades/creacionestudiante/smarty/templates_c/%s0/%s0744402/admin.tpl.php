<?php /* Smarty version 2.3.0, created on 2008-04-07 11:01:56
         compiled from Default/admin.tpl */ ?>
<table width="70%" align="center" cellpadding="0" cellspacing="0">
  <tr class="grayboxheader">
    <td width="14"><img src="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/box_left.gif" border="0" width="14"></td>
    <td background="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/box_bg.gif">Administration System</td>
    <td width="14"><img src="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/box_right.gif" border="0" width="14"></td>
  </tr>
</table>

<table width="70%" align="center" class="bordered_table">
  <?php if (isset($this->_sections["message"])) unset($this->_sections["message"]);
$this->_sections["message"]['name'] = "message";
$this->_sections["message"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["message"]['show'] = (bool)$this->_tpl_vars['data']['message'];
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
    <tr>
      <td class="message"><?php echo $this->_tpl_vars['data']['message']; ?>
</td>
    </tr>
  <?php endfor; endif; ?>

  <tr>
    <td class="whitebox">Edit Survey</td>
  </tr>
  <tr>
    <td>
      <form method="GET" action="<?php echo $this->_tpl_vars['conf']['html']; ?>
/edit_survey.php" class="indented_cell">
        <select name="sid">
          <?php if (isset($this->_sections["s"])) unset($this->_sections["s"]);
$this->_sections["s"]['name'] = "s";
$this->_sections["s"]['loop'] = is_array($this->_tpl_vars['data']['survey']['sid']) ? count($this->_tpl_vars['data']['survey']['sid']) : max(0, (int)$this->_tpl_vars['data']['survey']['sid']);
$this->_sections["s"]['show'] = true;
$this->_sections["s"]['max'] = $this->_sections["s"]['loop'];
$this->_sections["s"]['step'] = 1;
$this->_sections["s"]['start'] = $this->_sections["s"]['step'] > 0 ? 0 : $this->_sections["s"]['loop']-1;
if ($this->_sections["s"]['show']) {
    $this->_sections["s"]['total'] = $this->_sections["s"]['loop'];
    if ($this->_sections["s"]['total'] == 0)
        $this->_sections["s"]['show'] = false;
} else
    $this->_sections["s"]['total'] = 0;
if ($this->_sections["s"]['show']):

            for ($this->_sections["s"]['index'] = $this->_sections["s"]['start'], $this->_sections["s"]['iteration'] = 1;
                 $this->_sections["s"]['iteration'] <= $this->_sections["s"]['total'];
                 $this->_sections["s"]['index'] += $this->_sections["s"]['step'], $this->_sections["s"]['iteration']++):
$this->_sections["s"]['rownum'] = $this->_sections["s"]['iteration'];
$this->_sections["s"]['index_prev'] = $this->_sections["s"]['index'] - $this->_sections["s"]['step'];
$this->_sections["s"]['index_next'] = $this->_sections["s"]['index'] + $this->_sections["s"]['step'];
$this->_sections["s"]['first']      = ($this->_sections["s"]['iteration'] == 1);
$this->_sections["s"]['last']       = ($this->_sections["s"]['iteration'] == $this->_sections["s"]['total']);
?>
            <option value="<?php echo $this->_tpl_vars['data']['survey']['sid'][$this->_sections['s']['index']]; ?>
"><?php echo $this->_tpl_vars['data']['survey']['name'][$this->_sections['s']['index']]; ?>
</option>
          <?php endfor; endif; ?>
        </select>
        <input type="submit" value="Edit Survey">
        [ <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/new_survey.php">Create New Survey</a> ]
      </form>
    </td>
  </tr>
  <tr>
    <td class="whitebox">Users</td>
  </tr>
  <tr>
    <td>
      <form method="post" action="<?php echo $this->_tpl_vars['conf']['html']; ?>
/admin.php">
        <table border="1" cellspacing="0" cellpadding="2" align="center" width="80%">
          <tr>
            <th>Name</th>
            <th>Email<//th>
            <th>Username</th>
            <th>Password</th>
            <th>Administrator</th>
            <?php if (isset($this->_sections["create"])) unset($this->_sections["create"]);
$this->_sections["create"]['name'] = "create";
$this->_sections["create"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["create"]['show'] = (bool)$this->_tpl_vars['conf']['create_access'];
$this->_sections["create"]['max'] = $this->_sections["create"]['loop'];
$this->_sections["create"]['step'] = 1;
$this->_sections["create"]['start'] = $this->_sections["create"]['step'] > 0 ? 0 : $this->_sections["create"]['loop']-1;
if ($this->_sections["create"]['show']) {
    $this->_sections["create"]['total'] = $this->_sections["create"]['loop'];
    if ($this->_sections["create"]['total'] == 0)
        $this->_sections["create"]['show'] = false;
} else
    $this->_sections["create"]['total'] = 0;
if ($this->_sections["create"]['show']):

            for ($this->_sections["create"]['index'] = $this->_sections["create"]['start'], $this->_sections["create"]['iteration'] = 1;
                 $this->_sections["create"]['iteration'] <= $this->_sections["create"]['total'];
                 $this->_sections["create"]['index'] += $this->_sections["create"]['step'], $this->_sections["create"]['iteration']++):
$this->_sections["create"]['rownum'] = $this->_sections["create"]['iteration'];
$this->_sections["create"]['index_prev'] = $this->_sections["create"]['index'] - $this->_sections["create"]['step'];
$this->_sections["create"]['index_next'] = $this->_sections["create"]['index'] + $this->_sections["create"]['step'];
$this->_sections["create"]['first']      = ($this->_sections["create"]['iteration'] == 1);
$this->_sections["create"]['last']       = ($this->_sections["create"]['iteration'] == $this->_sections["create"]['total']);
?>
              <th>Create Surveys</th>
            <?php endfor; endif; ?>
            <th>Delete</th>
          </tr>
          <?php if (isset($this->_sections["u"])) unset($this->_sections["u"]);
$this->_sections["u"]['name'] = "u";
$this->_sections["u"]['loop'] = is_array($this->_tpl_vars['data']['users']) ? count($this->_tpl_vars['data']['users']) : max(0, (int)$this->_tpl_vars['data']['users']);
$this->_sections["u"]['show'] = true;
$this->_sections["u"]['max'] = $this->_sections["u"]['loop'];
$this->_sections["u"]['step'] = 1;
$this->_sections["u"]['start'] = $this->_sections["u"]['step'] > 0 ? 0 : $this->_sections["u"]['loop']-1;
if ($this->_sections["u"]['show']) {
    $this->_sections["u"]['total'] = $this->_sections["u"]['loop'];
    if ($this->_sections["u"]['total'] == 0)
        $this->_sections["u"]['show'] = false;
} else
    $this->_sections["u"]['total'] = 0;
if ($this->_sections["u"]['show']):

            for ($this->_sections["u"]['index'] = $this->_sections["u"]['start'], $this->_sections["u"]['iteration'] = 1;
                 $this->_sections["u"]['iteration'] <= $this->_sections["u"]['total'];
                 $this->_sections["u"]['index'] += $this->_sections["u"]['step'], $this->_sections["u"]['iteration']++):
$this->_sections["u"]['rownum'] = $this->_sections["u"]['iteration'];
$this->_sections["u"]['index_prev'] = $this->_sections["u"]['index'] - $this->_sections["u"]['step'];
$this->_sections["u"]['index_next'] = $this->_sections["u"]['index'] + $this->_sections["u"]['step'];
$this->_sections["u"]['first']      = ($this->_sections["u"]['iteration'] == 1);
$this->_sections["u"]['last']       = ($this->_sections["u"]['iteration'] == $this->_sections["u"]['total']);
?>
            <tr<?php if (isset($this->_sections["err"])) unset($this->_sections["err"]);
$this->_sections["err"]['name'] = "err";
$this->_sections["err"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["err"]['show'] = (bool)$this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['erruid'];
$this->_sections["err"]['max'] = $this->_sections["err"]['loop'];
$this->_sections["err"]['step'] = 1;
$this->_sections["err"]['start'] = $this->_sections["err"]['step'] > 0 ? 0 : $this->_sections["err"]['loop']-1;
if ($this->_sections["err"]['show']) {
    $this->_sections["err"]['total'] = $this->_sections["err"]['loop'];
    if ($this->_sections["err"]['total'] == 0)
        $this->_sections["err"]['show'] = false;
} else
    $this->_sections["err"]['total'] = 0;
if ($this->_sections["err"]['show']):

            for ($this->_sections["err"]['index'] = $this->_sections["err"]['start'], $this->_sections["err"]['iteration'] = 1;
                 $this->_sections["err"]['iteration'] <= $this->_sections["err"]['total'];
                 $this->_sections["err"]['index'] += $this->_sections["err"]['step'], $this->_sections["err"]['iteration']++):
$this->_sections["err"]['rownum'] = $this->_sections["err"]['iteration'];
$this->_sections["err"]['index_prev'] = $this->_sections["err"]['index'] - $this->_sections["err"]['step'];
$this->_sections["err"]['index_next'] = $this->_sections["err"]['index'] + $this->_sections["err"]['step'];
$this->_sections["err"]['first']      = ($this->_sections["err"]['iteration'] == 1);
$this->_sections["err"]['last']       = ($this->_sections["err"]['iteration'] == $this->_sections["err"]['total']);
?> style="background-color:red"<?php endfor; endif; ?>>
              <td><input type="text" name="name[<?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['uid']; ?>
]" size="15" value="<?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['name']; ?>
" maxlength="50"></td>
              <td><input type="text" name="email[<?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['uid']; ?>
]" size="25" value="<?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['email']; ?>
" maxlength="100"></td>
              <td><input type="text" name="username[<?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['uid']; ?>
]" size="15" value="<?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['username']; ?>
" maxlength="20"></td>
              <td><input type="text" name="password[<?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['uid']; ?>
]" size="15" value="<?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['password']; ?>
" maxlength="20"></td>
              <td align="center"><input type="checkbox" name="admin_priv[<?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['uid']; ?>
]" value="1"<?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['admin_selected']; ?>
></td>
              <?php if (isset($this->_sections["create2"])) unset($this->_sections["create2"]);
$this->_sections["create2"]['name'] = "create2";
$this->_sections["create2"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["create2"]['show'] = (bool)$this->_tpl_vars['conf']['create_access'];
$this->_sections["create2"]['max'] = $this->_sections["create2"]['loop'];
$this->_sections["create2"]['step'] = 1;
$this->_sections["create2"]['start'] = $this->_sections["create2"]['step'] > 0 ? 0 : $this->_sections["create2"]['loop']-1;
if ($this->_sections["create2"]['show']) {
    $this->_sections["create2"]['total'] = $this->_sections["create2"]['loop'];
    if ($this->_sections["create2"]['total'] == 0)
        $this->_sections["create2"]['show'] = false;
} else
    $this->_sections["create2"]['total'] = 0;
if ($this->_sections["create2"]['show']):

            for ($this->_sections["create2"]['index'] = $this->_sections["create2"]['start'], $this->_sections["create2"]['iteration'] = 1;
                 $this->_sections["create2"]['iteration'] <= $this->_sections["create2"]['total'];
                 $this->_sections["create2"]['index'] += $this->_sections["create2"]['step'], $this->_sections["create2"]['iteration']++):
$this->_sections["create2"]['rownum'] = $this->_sections["create2"]['iteration'];
$this->_sections["create2"]['index_prev'] = $this->_sections["create2"]['index'] - $this->_sections["create2"]['step'];
$this->_sections["create2"]['index_next'] = $this->_sections["create2"]['index'] + $this->_sections["create2"]['step'];
$this->_sections["create2"]['first']      = ($this->_sections["create2"]['iteration'] == 1);
$this->_sections["create2"]['last']       = ($this->_sections["create2"]['iteration'] == $this->_sections["create2"]['total']);
?>
                <td align="center"><input type="checkbox" name="create_priv[<?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['uid']; ?>
]" value="1"<?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['create_selected']; ?>
></td>
              <?php endfor; endif; ?>
              <td align="center"><input type="checkbox" name="delete[<?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['uid']; ?>
]" value="1"<?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['delete_selected']; ?>
></td>
            </tr>
          <?php endfor; endif; ?>
          <tr>
            <td colspan="7" align="right">
              <input type="submit" name="update_admin_users" value="Update Users">
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
  <tr>
    <td align="center">
      <br />
      [ <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/index.php">Return to Main</a> ]
    </td>
  </tr>
</table>