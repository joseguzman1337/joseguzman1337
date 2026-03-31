<?php /* Smarty version 2.3.0, created on 2008-04-07 13:17:06
         compiled from Default/edit_survey_access_control.tpl */ ?>
    <form method="POST" action="<?php echo $this->_tpl_vars['conf']['html']; ?>
/edit_survey.php">
      <input type="hidden" name="mode" value="<?php echo $this->_tpl_vars['data']['mode']; ?>
">
      <input type="hidden" name="sid" value="<?php echo $this->_tpl_vars['data']['sid']; ?>
">

      <div class="whitebox">Survey Access Control <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/docs/index.html#ac_type">[?]</a></div>

      <div class="indented_cell">
        <select name="access_control" size="1">
          <option value="0"<?php echo $this->_tpl_vars['data']['acs']['none']; ?>
>None - Public Survey</option>
          <option value="1"<?php echo $this->_tpl_vars['data']['acs']['cookie']; ?>
>Cookies</option>
          <option value="2"<?php echo $this->_tpl_vars['data']['acs']['ip']; ?>
>IP Address</option>
          <option value="3"<?php echo $this->_tpl_vars['data']['acs']['usernamepassword']; ?>
>Username and Password</option>
          <option value="4"<?php echo $this->_tpl_vars['data']['acs']['invitation']; ?>
>Invitation Only (Email)</option>
        </select>
      </div>

      <div class="whitebox">Hide Survey <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/docs/index.html#ac_hidden">[?]</a></div>

      <div class="indented_cell">
        <input type="checkbox" name="hidden" value="1"<?php echo $this->_tpl_vars['data']['hidden_checked']; ?>
>
        Survey will not be shown anywhere on main page and will need to be directly linked
        to using the following links. <br />
        [ <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/survey.php?sid=<?php echo $this->_tpl_vars['data']['sid']; ?>
">Take Survey</a>
          &nbsp;|&nbsp;
          <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/results.php?sid=<?php echo $this->_tpl_vars['data']['sid']; ?>
">Survey Results</a>
          &nbsp;|&nbsp;
          <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/edit_survey.php?sid=<?php echo $this->_tpl_vars['data']['sid']; ?>
">Edit Survey</a> ]
      </div>

      <div class="whitebox">Public Survey Results <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/docs/index.html#ac_public_results">[?]</a></div>

      <div class="indented_cell">
        <input type="checkbox" name="public_results" value="1"<?php echo $this->_tpl_vars['data']['public_results_checked']; ?>
> Check this box to make the results of the survey
        public. If this box is not checked, access to the results will be controlled by the permissions
        you set below.
      </div>

      <?php if (isset($this->_sections["survey_limit"])) unset($this->_sections["survey_limit"]);
$this->_sections["survey_limit"]['name'] = "survey_limit";
$this->_sections["survey_limit"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["survey_limit"]['show'] = (bool)$this->_tpl_vars['data']['show']['survey_limit'];
$this->_sections["survey_limit"]['max'] = $this->_sections["survey_limit"]['loop'];
$this->_sections["survey_limit"]['step'] = 1;
$this->_sections["survey_limit"]['start'] = $this->_sections["survey_limit"]['step'] > 0 ? 0 : $this->_sections["survey_limit"]['loop']-1;
if ($this->_sections["survey_limit"]['show']) {
    $this->_sections["survey_limit"]['total'] = $this->_sections["survey_limit"]['loop'];
    if ($this->_sections["survey_limit"]['total'] == 0)
        $this->_sections["survey_limit"]['show'] = false;
} else
    $this->_sections["survey_limit"]['total'] = 0;
if ($this->_sections["survey_limit"]['show']):

            for ($this->_sections["survey_limit"]['index'] = $this->_sections["survey_limit"]['start'], $this->_sections["survey_limit"]['iteration'] = 1;
                 $this->_sections["survey_limit"]['iteration'] <= $this->_sections["survey_limit"]['total'];
                 $this->_sections["survey_limit"]['index'] += $this->_sections["survey_limit"]['step'], $this->_sections["survey_limit"]['iteration']++):
$this->_sections["survey_limit"]['rownum'] = $this->_sections["survey_limit"]['iteration'];
$this->_sections["survey_limit"]['index_prev'] = $this->_sections["survey_limit"]['index'] - $this->_sections["survey_limit"]['step'];
$this->_sections["survey_limit"]['index_next'] = $this->_sections["survey_limit"]['index'] + $this->_sections["survey_limit"]['step'];
$this->_sections["survey_limit"]['first']      = ($this->_sections["survey_limit"]['iteration'] == 1);
$this->_sections["survey_limit"]['last']       = ($this->_sections["survey_limit"]['iteration'] == $this->_sections["survey_limit"]['total']);
?>
        <div class="whitebox">Survey Limit <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/docs/index.html#ac_survey_limit">[?]</a></div>

        <div class="indented_cell">
          Allow users to take survey <input type="text" name="survey_limit_times" size="3" value="<?php echo $this->_tpl_vars['data']['survey_limit_times']; ?>
">
          time(s) every <input type="text" name="survey_limit_number" size="5" value="<?php echo $this->_tpl_vars['data']['survey_limit_number']; ?>
">
          <select name="survey_limit_unit" size="1">
            <option value="0"<?php echo $this->_tpl_vars['data']['survey_limit_unit'][0]; ?>
>minute(s)</option>
            <option value="1"<?php echo $this->_tpl_vars['data']['survey_limit_unit'][1]; ?>
>hour(s)</option>
            <option value="2"<?php echo $this->_tpl_vars['data']['survey_limit_unit'][2]; ?>
>day(s)</option>
            <option value="3"<?php echo $this->_tpl_vars['data']['survey_limit_unit'][3]; ?>
>ever</option>
          </select>
          <p class="example" style="margin:1px">Sets a limit for how many times users can complete a survey over
          a given time span, such as &quot;Allow users to take survey <strong>1</strong> time every <strong>7</strong>
          <strong>days</strong>&quot; or &quot;Allow users to take survey <strong>2</strong> times <strong>ever</strong>&quot; (second number is ignored in
          this case). Leave set at zero for no limit.</p>
        </div>
      <?php endfor; endif; ?>

      <?php if (isset($this->_sections["clear_completed"])) unset($this->_sections["clear_completed"]);
$this->_sections["clear_completed"]['name'] = "clear_completed";
$this->_sections["clear_completed"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["clear_completed"]['show'] = (bool)$this->_tpl_vars['data']['show']['clear_completed'];
$this->_sections["clear_completed"]['max'] = $this->_sections["clear_completed"]['loop'];
$this->_sections["clear_completed"]['step'] = 1;
$this->_sections["clear_completed"]['start'] = $this->_sections["clear_completed"]['step'] > 0 ? 0 : $this->_sections["clear_completed"]['loop']-1;
if ($this->_sections["clear_completed"]['show']) {
    $this->_sections["clear_completed"]['total'] = $this->_sections["clear_completed"]['loop'];
    if ($this->_sections["clear_completed"]['total'] == 0)
        $this->_sections["clear_completed"]['show'] = false;
} else
    $this->_sections["clear_completed"]['total'] = 0;
if ($this->_sections["clear_completed"]['show']):

            for ($this->_sections["clear_completed"]['index'] = $this->_sections["clear_completed"]['start'], $this->_sections["clear_completed"]['iteration'] = 1;
                 $this->_sections["clear_completed"]['iteration'] <= $this->_sections["clear_completed"]['total'];
                 $this->_sections["clear_completed"]['index'] += $this->_sections["clear_completed"]['step'], $this->_sections["clear_completed"]['iteration']++):
$this->_sections["clear_completed"]['rownum'] = $this->_sections["clear_completed"]['iteration'];
$this->_sections["clear_completed"]['index_prev'] = $this->_sections["clear_completed"]['index'] - $this->_sections["clear_completed"]['step'];
$this->_sections["clear_completed"]['index_next'] = $this->_sections["clear_completed"]['index'] + $this->_sections["clear_completed"]['step'];
$this->_sections["clear_completed"]['first']      = ($this->_sections["clear_completed"]['iteration'] == 1);
$this->_sections["clear_completed"]['last']       = ($this->_sections["clear_completed"]['iteration'] == $this->_sections["clear_completed"]['total']);
?>
        <div class="whitebox">Reset Completed Surveys <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/docs/index.html#ac_clear_completed">[?]</a></div>

        <div class="indented_cell">
          <input type="checkbox" name="clear_completed" value="1">Check this box to reset the completed surveys number for all users. This will not
          remove the actual answers the users gave, but simply reset to zero the number of times the system thinks they have completed the survey.
        </div>
      <?php endfor; endif; ?>

      <div class="indented_cell">
        <input type="submit" name="update_access_control" value="Update Access Control">
      </div>

      <hr>

      <div class="whitebox">Users <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/docs/index.html#ac_user_list">[?]</a></div>

      <div class="indented_cell">
        <strong>Be sure to click the &quot;Update Access Control&quot; button if any changes were made above before you
        edit the users below.</strong>
        <table border="1" cellspacing="0" cellpadding="3">
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Username</th>
            <th>Password</th>
            <?php if (isset($this->_sections["take_survey"])) unset($this->_sections["take_survey"]);
$this->_sections["take_survey"]['name'] = "take_survey";
$this->_sections["take_survey"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["take_survey"]['show'] = (bool)$this->_tpl_vars['data']['show']['take_priv'];
$this->_sections["take_survey"]['max'] = $this->_sections["take_survey"]['loop'];
$this->_sections["take_survey"]['step'] = 1;
$this->_sections["take_survey"]['start'] = $this->_sections["take_survey"]['step'] > 0 ? 0 : $this->_sections["take_survey"]['loop']-1;
if ($this->_sections["take_survey"]['show']) {
    $this->_sections["take_survey"]['total'] = $this->_sections["take_survey"]['loop'];
    if ($this->_sections["take_survey"]['total'] == 0)
        $this->_sections["take_survey"]['show'] = false;
} else
    $this->_sections["take_survey"]['total'] = 0;
if ($this->_sections["take_survey"]['show']):

            for ($this->_sections["take_survey"]['index'] = $this->_sections["take_survey"]['start'], $this->_sections["take_survey"]['iteration'] = 1;
                 $this->_sections["take_survey"]['iteration'] <= $this->_sections["take_survey"]['total'];
                 $this->_sections["take_survey"]['index'] += $this->_sections["take_survey"]['step'], $this->_sections["take_survey"]['iteration']++):
$this->_sections["take_survey"]['rownum'] = $this->_sections["take_survey"]['iteration'];
$this->_sections["take_survey"]['index_prev'] = $this->_sections["take_survey"]['index'] - $this->_sections["take_survey"]['step'];
$this->_sections["take_survey"]['index_next'] = $this->_sections["take_survey"]['index'] + $this->_sections["take_survey"]['step'];
$this->_sections["take_survey"]['first']      = ($this->_sections["take_survey"]['iteration'] == 1);
$this->_sections["take_survey"]['last']       = ($this->_sections["take_survey"]['iteration'] == $this->_sections["take_survey"]['total']);
?>
              <th>Sent Login</th>
              <th>Completed</th>
              <th>Take Survey</th>
            <?php endfor; endif; ?>
            <?php if (isset($this->_sections["view_results"])) unset($this->_sections["view_results"]);
$this->_sections["view_results"]['name'] = "view_results";
$this->_sections["view_results"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["view_results"]['show'] = (bool)$this->_tpl_vars['data']['show']['results_priv'];
$this->_sections["view_results"]['max'] = $this->_sections["view_results"]['loop'];
$this->_sections["view_results"]['step'] = 1;
$this->_sections["view_results"]['start'] = $this->_sections["view_results"]['step'] > 0 ? 0 : $this->_sections["view_results"]['loop']-1;
if ($this->_sections["view_results"]['show']) {
    $this->_sections["view_results"]['total'] = $this->_sections["view_results"]['loop'];
    if ($this->_sections["view_results"]['total'] == 0)
        $this->_sections["view_results"]['show'] = false;
} else
    $this->_sections["view_results"]['total'] = 0;
if ($this->_sections["view_results"]['show']):

            for ($this->_sections["view_results"]['index'] = $this->_sections["view_results"]['start'], $this->_sections["view_results"]['iteration'] = 1;
                 $this->_sections["view_results"]['iteration'] <= $this->_sections["view_results"]['total'];
                 $this->_sections["view_results"]['index'] += $this->_sections["view_results"]['step'], $this->_sections["view_results"]['iteration']++):
$this->_sections["view_results"]['rownum'] = $this->_sections["view_results"]['iteration'];
$this->_sections["view_results"]['index_prev'] = $this->_sections["view_results"]['index'] - $this->_sections["view_results"]['step'];
$this->_sections["view_results"]['index_next'] = $this->_sections["view_results"]['index'] + $this->_sections["view_results"]['step'];
$this->_sections["view_results"]['first']      = ($this->_sections["view_results"]['iteration'] == 1);
$this->_sections["view_results"]['last']       = ($this->_sections["view_results"]['iteration'] == $this->_sections["view_results"]['total']);
?>
              <th>View Results</th>
            <?php endfor; endif; ?>
            <th>Edit Survey</th>
            <th bgcolor="#DDDDDD">Action</th>
          </tr>
          <?php if (isset($this->_sections["u"])) unset($this->_sections["u"]);
$this->_sections["u"]['name'] = "u";
$this->_sections["u"]['loop'] = is_array($this->_tpl_vars['data']['users']) ? count($this->_tpl_vars['data']['users']) : max(0, (int)$this->_tpl_vars['data']['users']);
$this->_sections["u"]['show'] = (bool)"TRUE";
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
            <tr<?php if (isset($this->_sections["erruid"])) unset($this->_sections["erruid"]);
$this->_sections["erruid"]['name'] = "erruid";
$this->_sections["erruid"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["erruid"]['show'] = (bool)$this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['erruid'];
$this->_sections["erruid"]['max'] = $this->_sections["erruid"]['loop'];
$this->_sections["erruid"]['step'] = 1;
$this->_sections["erruid"]['start'] = $this->_sections["erruid"]['step'] > 0 ? 0 : $this->_sections["erruid"]['loop']-1;
if ($this->_sections["erruid"]['show']) {
    $this->_sections["erruid"]['total'] = $this->_sections["erruid"]['loop'];
    if ($this->_sections["erruid"]['total'] == 0)
        $this->_sections["erruid"]['show'] = false;
} else
    $this->_sections["erruid"]['total'] = 0;
if ($this->_sections["erruid"]['show']):

            for ($this->_sections["erruid"]['index'] = $this->_sections["erruid"]['start'], $this->_sections["erruid"]['iteration'] = 1;
                 $this->_sections["erruid"]['iteration'] <= $this->_sections["erruid"]['total'];
                 $this->_sections["erruid"]['index'] += $this->_sections["erruid"]['step'], $this->_sections["erruid"]['iteration']++):
$this->_sections["erruid"]['rownum'] = $this->_sections["erruid"]['iteration'];
$this->_sections["erruid"]['index_prev'] = $this->_sections["erruid"]['index'] - $this->_sections["erruid"]['step'];
$this->_sections["erruid"]['index_next'] = $this->_sections["erruid"]['index'] + $this->_sections["erruid"]['step'];
$this->_sections["erruid"]['first']      = ($this->_sections["erruid"]['iteration'] == 1);
$this->_sections["erruid"]['last']       = ($this->_sections["erruid"]['iteration'] == $this->_sections["erruid"]['total']);
?> style="background-color:red"<?php endfor; endif; ?>>
              <td><input type="text" name="name[<?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['uid']; ?>
]" size="20" maxlength="50" value="<?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['name']; ?>
"></td>
              <td><input type="text" name="email[<?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['uid']; ?>
]" size="20" maxlength="100" value="<?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['email']; ?>
"></td>
              <td><input type="text" name="username[<?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['uid']; ?>
]" size="10" maxlength="50" value="<?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['username']; ?>
"></td>
              <td><input type="text" name="password[<?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['uid']; ?>
]" size="10" maxlength="50" value="<?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['password']; ?>
"></td>
              <?php if (isset($this->_sections["take_survey"])) unset($this->_sections["take_survey"]);
$this->_sections["take_survey"]['name'] = "take_survey";
$this->_sections["take_survey"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["take_survey"]['show'] = (bool)$this->_tpl_vars['data']['show']['take_priv'];
$this->_sections["take_survey"]['max'] = $this->_sections["take_survey"]['loop'];
$this->_sections["take_survey"]['step'] = 1;
$this->_sections["take_survey"]['start'] = $this->_sections["take_survey"]['step'] > 0 ? 0 : $this->_sections["take_survey"]['loop']-1;
if ($this->_sections["take_survey"]['show']) {
    $this->_sections["take_survey"]['total'] = $this->_sections["take_survey"]['loop'];
    if ($this->_sections["take_survey"]['total'] == 0)
        $this->_sections["take_survey"]['show'] = false;
} else
    $this->_sections["take_survey"]['total'] = 0;
if ($this->_sections["take_survey"]['show']):

            for ($this->_sections["take_survey"]['index'] = $this->_sections["take_survey"]['start'], $this->_sections["take_survey"]['iteration'] = 1;
                 $this->_sections["take_survey"]['iteration'] <= $this->_sections["take_survey"]['total'];
                 $this->_sections["take_survey"]['index'] += $this->_sections["take_survey"]['step'], $this->_sections["take_survey"]['iteration']++):
$this->_sections["take_survey"]['rownum'] = $this->_sections["take_survey"]['iteration'];
$this->_sections["take_survey"]['index_prev'] = $this->_sections["take_survey"]['index'] - $this->_sections["take_survey"]['step'];
$this->_sections["take_survey"]['index_next'] = $this->_sections["take_survey"]['index'] + $this->_sections["take_survey"]['step'];
$this->_sections["take_survey"]['first']      = ($this->_sections["take_survey"]['iteration'] == 1);
$this->_sections["take_survey"]['last']       = ($this->_sections["take_survey"]['iteration'] == $this->_sections["take_survey"]['total']);
?>
                <td align="center"><?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['status_date']; ?>
</td>
                <td align="center"><?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['completed']; ?>
 (<?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['num_completed']; ?>
)</td>
                <td align="center"><input type="checkbox" name="take_priv[<?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['uid']; ?>
]" value="1"<?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['take_priv']; ?>
></td>
              <?php endfor; endif; ?>
              <?php if (isset($this->_sections["view_results"])) unset($this->_sections["view_results"]);
$this->_sections["view_results"]['name'] = "view_results";
$this->_sections["view_results"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["view_results"]['show'] = (bool)$this->_tpl_vars['data']['show']['results_priv'];
$this->_sections["view_results"]['max'] = $this->_sections["view_results"]['loop'];
$this->_sections["view_results"]['step'] = 1;
$this->_sections["view_results"]['start'] = $this->_sections["view_results"]['step'] > 0 ? 0 : $this->_sections["view_results"]['loop']-1;
if ($this->_sections["view_results"]['show']) {
    $this->_sections["view_results"]['total'] = $this->_sections["view_results"]['loop'];
    if ($this->_sections["view_results"]['total'] == 0)
        $this->_sections["view_results"]['show'] = false;
} else
    $this->_sections["view_results"]['total'] = 0;
if ($this->_sections["view_results"]['show']):

            for ($this->_sections["view_results"]['index'] = $this->_sections["view_results"]['start'], $this->_sections["view_results"]['iteration'] = 1;
                 $this->_sections["view_results"]['iteration'] <= $this->_sections["view_results"]['total'];
                 $this->_sections["view_results"]['index'] += $this->_sections["view_results"]['step'], $this->_sections["view_results"]['iteration']++):
$this->_sections["view_results"]['rownum'] = $this->_sections["view_results"]['iteration'];
$this->_sections["view_results"]['index_prev'] = $this->_sections["view_results"]['index'] - $this->_sections["view_results"]['step'];
$this->_sections["view_results"]['index_next'] = $this->_sections["view_results"]['index'] + $this->_sections["view_results"]['step'];
$this->_sections["view_results"]['first']      = ($this->_sections["view_results"]['iteration'] == 1);
$this->_sections["view_results"]['last']       = ($this->_sections["view_results"]['iteration'] == $this->_sections["view_results"]['total']);
?>
                <td align="center"><input type="checkbox" name="results_priv[<?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['uid']; ?>
]" value="1"<?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['results_priv']; ?>
></td>
              <?php endfor; endif; ?>
              <td align="center"><input type="checkbox" name="edit_priv[<?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['uid']; ?>
]" value="1"<?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['edit_priv']; ?>
></td>
              <td align="center" bgcolor="#DDDDDD"><input type="checkbox" name="users_checkbox[<?php echo $this->_tpl_vars['data']['users'][$this->_sections['u']['index']]['uid']; ?>
]" value="1"></td>
            </tr>
          <?php endfor; endif; ?>
          <tr>
            <td colspan="2">(Be sure to save users before sending login information)</td>
            <td colspan="<?php echo $this->_tpl_vars['data']['actioncolspan']; ?>
" align="right" bgcolor="#DDDDDD">
              Action:
              <select name="users_selection" size="1">
                <option value="saveall">Save All Users</option>
                <option value="delete">Delete Selected</option>
                <option value="remind">Send Login Info to Selected</option>
                <?php if (isset($this->_sections["invite"])) unset($this->_sections["invite"]);
$this->_sections["invite"]['name'] = "invite";
$this->_sections["invite"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["invite"]['show'] = (bool)$this->_tpl_vars['data']['show']['invite'];
$this->_sections["invite"]['max'] = $this->_sections["invite"]['loop'];
$this->_sections["invite"]['step'] = 1;
$this->_sections["invite"]['start'] = $this->_sections["invite"]['step'] > 0 ? 0 : $this->_sections["invite"]['loop']-1;
if ($this->_sections["invite"]['show']) {
    $this->_sections["invite"]['total'] = $this->_sections["invite"]['loop'];
    if ($this->_sections["invite"]['total'] == 0)
        $this->_sections["invite"]['show'] = false;
} else
    $this->_sections["invite"]['total'] = 0;
if ($this->_sections["invite"]['show']):

            for ($this->_sections["invite"]['index'] = $this->_sections["invite"]['start'], $this->_sections["invite"]['iteration'] = 1;
                 $this->_sections["invite"]['iteration'] <= $this->_sections["invite"]['total'];
                 $this->_sections["invite"]['index'] += $this->_sections["invite"]['step'], $this->_sections["invite"]['iteration']++):
$this->_sections["invite"]['rownum'] = $this->_sections["invite"]['iteration'];
$this->_sections["invite"]['index_prev'] = $this->_sections["invite"]['index'] - $this->_sections["invite"]['step'];
$this->_sections["invite"]['index_next'] = $this->_sections["invite"]['index'] + $this->_sections["invite"]['step'];
$this->_sections["invite"]['first']      = ($this->_sections["invite"]['iteration'] == 1);
$this->_sections["invite"]['last']       = ($this->_sections["invite"]['iteration'] == $this->_sections["invite"]['total']);
?>
                  <option value="movetoinvite">Move Selected to Invitee List</option>
                <?php endfor; endif; ?>
              </select>
              <input type="submit" name="users_go" value="Go">
            </td>
          </tr>
        </table>
      </div>

      <?php if (isset($this->_sections["invite"])) unset($this->_sections["invite"]);
$this->_sections["invite"]['name'] = "invite";
$this->_sections["invite"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["invite"]['show'] = (bool)$this->_tpl_vars['data']['show']['invite'];
$this->_sections["invite"]['max'] = $this->_sections["invite"]['loop'];
$this->_sections["invite"]['step'] = 1;
$this->_sections["invite"]['start'] = $this->_sections["invite"]['step'] > 0 ? 0 : $this->_sections["invite"]['loop']-1;
if ($this->_sections["invite"]['show']) {
    $this->_sections["invite"]['total'] = $this->_sections["invite"]['loop'];
    if ($this->_sections["invite"]['total'] == 0)
        $this->_sections["invite"]['show'] = false;
} else
    $this->_sections["invite"]['total'] = 0;
if ($this->_sections["invite"]['show']):

            for ($this->_sections["invite"]['index'] = $this->_sections["invite"]['start'], $this->_sections["invite"]['iteration'] = 1;
                 $this->_sections["invite"]['iteration'] <= $this->_sections["invite"]['total'];
                 $this->_sections["invite"]['index'] += $this->_sections["invite"]['step'], $this->_sections["invite"]['iteration']++):
$this->_sections["invite"]['rownum'] = $this->_sections["invite"]['iteration'];
$this->_sections["invite"]['index_prev'] = $this->_sections["invite"]['index'] - $this->_sections["invite"]['step'];
$this->_sections["invite"]['index_next'] = $this->_sections["invite"]['index'] + $this->_sections["invite"]['step'];
$this->_sections["invite"]['first']      = ($this->_sections["invite"]['iteration'] == 1);
$this->_sections["invite"]['last']       = ($this->_sections["invite"]['iteration'] == $this->_sections["invite"]['total']);
?>
        <div class="whitebox" style="margin-top:10px">Invitation Code Type <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/docs/index.html#ac_invite_code">[?]</a></div>
        <div class="indented_cell">
          <p style="margin-top:1px; margin-bottom:1px">
            <input type="radio" id="alphanumeric" name="invite_code_type" value="alphanumeric"<?php echo $this->_tpl_vars['data']['invite_code_type']['alphanumeric']; ?>
>
            <label for="alphanumeric">Alphanumeric</label>
            <input type="text" name="invite_code_length" value="<?php echo $this->_tpl_vars['data']['invite_code_length']; ?>
" size="3" maxlength="2"> characters
            <em>(i.e &quot;5ta2ST7aE2&quot; or &quot;2jiW72sut97Y&quot;, max <?php echo $this->_tpl_vars['data']['alphanumeric']['maxlength']; ?>
 characters, default <?php echo $this->_tpl_vars['data']['alphanumeric']['defaultlength']; ?>
 characters)</em>
          </p>
          <p style="margin-top:1px; margin-bottom:1px">
            <input type="radio" id="words" name="invite_code_type" value="words"<?php echo $this->_tpl_vars['data']['invite_code_type']['words']; ?>
>
            <label for="words">Words</label> <em>(i.e &quot;buffalo-candy&quot; or &quot;interesting-something&quot;)</em>
          </p>
        </div>
        <div class="whitebox">Invitees <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/docs/index.html#ac_invitee_list">[?]</a></div>
        <div class="indented_cell">
          <table border="1" cellspacing="0" cellpadding="3">
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Invited</th>
              <th>Invite Code</th>
              <th>Completed</th>
              <?php if (isset($this->_sections["view_results"])) unset($this->_sections["view_results"]);
$this->_sections["view_results"]['name'] = "view_results";
$this->_sections["view_results"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["view_results"]['show'] = (bool)$this->_tpl_vars['data']['show']['results_priv'];
$this->_sections["view_results"]['max'] = $this->_sections["view_results"]['loop'];
$this->_sections["view_results"]['step'] = 1;
$this->_sections["view_results"]['start'] = $this->_sections["view_results"]['step'] > 0 ? 0 : $this->_sections["view_results"]['loop']-1;
if ($this->_sections["view_results"]['show']) {
    $this->_sections["view_results"]['total'] = $this->_sections["view_results"]['loop'];
    if ($this->_sections["view_results"]['total'] == 0)
        $this->_sections["view_results"]['show'] = false;
} else
    $this->_sections["view_results"]['total'] = 0;
if ($this->_sections["view_results"]['show']):

            for ($this->_sections["view_results"]['index'] = $this->_sections["view_results"]['start'], $this->_sections["view_results"]['iteration'] = 1;
                 $this->_sections["view_results"]['iteration'] <= $this->_sections["view_results"]['total'];
                 $this->_sections["view_results"]['index'] += $this->_sections["view_results"]['step'], $this->_sections["view_results"]['iteration']++):
$this->_sections["view_results"]['rownum'] = $this->_sections["view_results"]['iteration'];
$this->_sections["view_results"]['index_prev'] = $this->_sections["view_results"]['index'] - $this->_sections["view_results"]['step'];
$this->_sections["view_results"]['index_next'] = $this->_sections["view_results"]['index'] + $this->_sections["view_results"]['step'];
$this->_sections["view_results"]['first']      = ($this->_sections["view_results"]['iteration'] == 1);
$this->_sections["view_results"]['last']       = ($this->_sections["view_results"]['iteration'] == $this->_sections["view_results"]['total']);
?>
                <th>View Results</th>
              <?php endfor; endif; ?>
              <th bgcolor="#DDDDDD">Action</th>
            </tr>
            <?php if (isset($this->_sections["i"])) unset($this->_sections["i"]);
$this->_sections["i"]['name'] = "i";
$this->_sections["i"]['loop'] = is_array($this->_tpl_vars['data']['invite']) ? count($this->_tpl_vars['data']['invite']) : max(0, (int)$this->_tpl_vars['data']['invite']);
$this->_sections["i"]['show'] = (bool)"TRUE";
$this->_sections["i"]['max'] = $this->_sections["i"]['loop'];
$this->_sections["i"]['step'] = 1;
$this->_sections["i"]['start'] = $this->_sections["i"]['step'] > 0 ? 0 : $this->_sections["i"]['loop']-1;
if ($this->_sections["i"]['show']) {
    $this->_sections["i"]['total'] = $this->_sections["i"]['loop'];
    if ($this->_sections["i"]['total'] == 0)
        $this->_sections["i"]['show'] = false;
} else
    $this->_sections["i"]['total'] = 0;
if ($this->_sections["i"]['show']):

            for ($this->_sections["i"]['index'] = $this->_sections["i"]['start'], $this->_sections["i"]['iteration'] = 1;
                 $this->_sections["i"]['iteration'] <= $this->_sections["i"]['total'];
                 $this->_sections["i"]['index'] += $this->_sections["i"]['step'], $this->_sections["i"]['iteration']++):
$this->_sections["i"]['rownum'] = $this->_sections["i"]['iteration'];
$this->_sections["i"]['index_prev'] = $this->_sections["i"]['index'] - $this->_sections["i"]['step'];
$this->_sections["i"]['index_next'] = $this->_sections["i"]['index'] + $this->_sections["i"]['step'];
$this->_sections["i"]['first']      = ($this->_sections["i"]['iteration'] == 1);
$this->_sections["i"]['last']       = ($this->_sections["i"]['iteration'] == $this->_sections["i"]['total']);
?>
              <tr<?php if (isset($this->_sections["erruid"])) unset($this->_sections["erruid"]);
$this->_sections["erruid"]['name'] = "erruid";
$this->_sections["erruid"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["erruid"]['show'] = (bool)$this->_tpl_vars['data']['invite'][$this->_sections['i']['index']]['erruid'];
$this->_sections["erruid"]['max'] = $this->_sections["erruid"]['loop'];
$this->_sections["erruid"]['step'] = 1;
$this->_sections["erruid"]['start'] = $this->_sections["erruid"]['step'] > 0 ? 0 : $this->_sections["erruid"]['loop']-1;
if ($this->_sections["erruid"]['show']) {
    $this->_sections["erruid"]['total'] = $this->_sections["erruid"]['loop'];
    if ($this->_sections["erruid"]['total'] == 0)
        $this->_sections["erruid"]['show'] = false;
} else
    $this->_sections["erruid"]['total'] = 0;
if ($this->_sections["erruid"]['show']):

            for ($this->_sections["erruid"]['index'] = $this->_sections["erruid"]['start'], $this->_sections["erruid"]['iteration'] = 1;
                 $this->_sections["erruid"]['iteration'] <= $this->_sections["erruid"]['total'];
                 $this->_sections["erruid"]['index'] += $this->_sections["erruid"]['step'], $this->_sections["erruid"]['iteration']++):
$this->_sections["erruid"]['rownum'] = $this->_sections["erruid"]['iteration'];
$this->_sections["erruid"]['index_prev'] = $this->_sections["erruid"]['index'] - $this->_sections["erruid"]['step'];
$this->_sections["erruid"]['index_next'] = $this->_sections["erruid"]['index'] + $this->_sections["erruid"]['step'];
$this->_sections["erruid"]['first']      = ($this->_sections["erruid"]['iteration'] == 1);
$this->_sections["erruid"]['last']       = ($this->_sections["erruid"]['iteration'] == $this->_sections["erruid"]['total']);
?> style="background-color:red"<?php endfor; endif; ?>>
                <td><input type="text" name="invite_name[<?php echo $this->_tpl_vars['data']['invite'][$this->_sections['i']['index']]['uid']; ?>
]" size="20" maxlength="50" value="<?php echo $this->_tpl_vars['data']['invite'][$this->_sections['i']['index']]['name']; ?>
"></td>
                <td><input type="text" name="invite_email[<?php echo $this->_tpl_vars['data']['invite'][$this->_sections['i']['index']]['uid']; ?>
]" size="20" maxlength="100" value="<?php echo $this->_tpl_vars['data']['invite'][$this->_sections['i']['index']]['email']; ?>
"></td>
                <td align="center"><?php echo $this->_tpl_vars['data']['invite'][$this->_sections['i']['index']]['status_date']; ?>
</td>
                <td align="center"><?php echo $this->_tpl_vars['data']['invite'][$this->_sections['i']['index']]['invite_code']; ?>
</td>
                <td align="center"><?php echo $this->_tpl_vars['data']['invite'][$this->_sections['i']['index']]['completed']; ?>
 (<?php echo $this->_tpl_vars['data']['invite'][$this->_sections['i']['index']]['num_completed']; ?>
)</td>
                <?php if (isset($this->_sections["view_results"])) unset($this->_sections["view_results"]);
$this->_sections["view_results"]['name'] = "view_results";
$this->_sections["view_results"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["view_results"]['show'] = (bool)$this->_tpl_vars['data']['show']['results_priv'];
$this->_sections["view_results"]['max'] = $this->_sections["view_results"]['loop'];
$this->_sections["view_results"]['step'] = 1;
$this->_sections["view_results"]['start'] = $this->_sections["view_results"]['step'] > 0 ? 0 : $this->_sections["view_results"]['loop']-1;
if ($this->_sections["view_results"]['show']) {
    $this->_sections["view_results"]['total'] = $this->_sections["view_results"]['loop'];
    if ($this->_sections["view_results"]['total'] == 0)
        $this->_sections["view_results"]['show'] = false;
} else
    $this->_sections["view_results"]['total'] = 0;
if ($this->_sections["view_results"]['show']):

            for ($this->_sections["view_results"]['index'] = $this->_sections["view_results"]['start'], $this->_sections["view_results"]['iteration'] = 1;
                 $this->_sections["view_results"]['iteration'] <= $this->_sections["view_results"]['total'];
                 $this->_sections["view_results"]['index'] += $this->_sections["view_results"]['step'], $this->_sections["view_results"]['iteration']++):
$this->_sections["view_results"]['rownum'] = $this->_sections["view_results"]['iteration'];
$this->_sections["view_results"]['index_prev'] = $this->_sections["view_results"]['index'] - $this->_sections["view_results"]['step'];
$this->_sections["view_results"]['index_next'] = $this->_sections["view_results"]['index'] + $this->_sections["view_results"]['step'];
$this->_sections["view_results"]['first']      = ($this->_sections["view_results"]['iteration'] == 1);
$this->_sections["view_results"]['last']       = ($this->_sections["view_results"]['iteration'] == $this->_sections["view_results"]['total']);
?>
                  <td align="center"><input type="checkbox" name="invite_results_priv[<?php echo $this->_tpl_vars['data']['invite'][$this->_sections['i']['index']]['uid']; ?>
]" value="1"<?php echo $this->_tpl_vars['data']['invite'][$this->_sections['i']['index']]['results_priv']; ?>
></td>
                <?php endfor; endif; ?>
                <td align="center" bgcolor="#DDDDDD"><input type="checkbox" name="invite_checkbox[<?php echo $this->_tpl_vars['data']['invite'][$this->_sections['i']['index']]['uid']; ?>
]" value="1"></td>
              </tr>
            <?php endfor; endif; ?>
            <tr>
              <td colspan="2">(Be sure to save invitees before sending invite codes.)</td>
              <td colspan="<?php echo $this->_tpl_vars['data']['inviteactioncolspan']; ?>
" align="right" bgcolor="#DDDDDD">
                Action:
                <select name="invite_selection" size="1">
                  <option value="saveall">Save All Invitees</option>
                  <option value="delete">Delete Selected Invitees</option>
                  <option value="invite">Send Invitation Code to Selected</option>
                  <option value="movetousers">Move Selected to Users List</option>
                </select>
                <input type="submit" name="invite_go" value="Go">
              </td>
            </tr>
          </table>
        </div>
      <?php endfor; endif; ?>
    </form>