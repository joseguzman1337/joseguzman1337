<?php /* Smarty version 2.3.0, created on 2008-04-07 11:17:57
         compiled from Default/add_survey.tpl */ ?>
<?php $this->_load_plugins(array(
array('modifier', 'default', 'Default/add_survey.tpl', 77, false),)); ?><form method="GET" action="<?php echo $this->_tpl_vars['conf']['html']; ?>
/new_survey.php">

<table width="70%" align="center" cellpadding="0" cellspacing="0">
  <tr class="grayboxheader">
    <td width="14"><img src="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/box_left.gif" border="0" width="14"></td>
    <td background="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/box_bg.gif">Create New Survey</td>
    <td width="14"><img src="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/box_right.gif" border="0" width="14"></td>
  </tr>
</table>
<table width="70%" align="center" class="bordered_table">


  <?php if (isset($this->_sections["error"])) unset($this->_sections["error"]);
$this->_sections["error"]['name'] = "error";
$this->_sections["error"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["error"]['show'] = (bool)$this->_tpl_vars['error'];
$this->_sections["error"]['max'] = $this->_sections["error"]['loop'];
$this->_sections["error"]['step'] = 1;
$this->_sections["error"]['start'] = $this->_sections["error"]['step'] > 0 ? 0 : $this->_sections["error"]['loop']-1;
if ($this->_sections["error"]['show']) {
    $this->_sections["error"]['total'] = $this->_sections["error"]['loop'];
    if ($this->_sections["error"]['total'] == 0)
        $this->_sections["error"]['show'] = false;
} else
    $this->_sections["error"]['total'] = 0;
if ($this->_sections["error"]['show']):

            for ($this->_sections["error"]['index'] = $this->_sections["error"]['start'], $this->_sections["error"]['iteration'] = 1;
                 $this->_sections["error"]['iteration'] <= $this->_sections["error"]['total'];
                 $this->_sections["error"]['index'] += $this->_sections["error"]['step'], $this->_sections["error"]['iteration']++):
$this->_sections["error"]['rownum'] = $this->_sections["error"]['iteration'];
$this->_sections["error"]['index_prev'] = $this->_sections["error"]['index'] - $this->_sections["error"]['step'];
$this->_sections["error"]['index_next'] = $this->_sections["error"]['index'] + $this->_sections["error"]['step'];
$this->_sections["error"]['first']      = ($this->_sections["error"]['iteration'] == 1);
$this->_sections["error"]['last']       = ($this->_sections["error"]['iteration'] == $this->_sections["error"]['total']);
?>
  <tr>
    <td class="error">Error: <?php echo $this->_tpl_vars['error']; ?>
</td>
  </tr>
  <?php endfor; endif; ?>



<?php if (isset($this->_sections["name_survey"])) unset($this->_sections["name_survey"]);
$this->_sections["name_survey"]['name'] = "name_survey";
$this->_sections["name_survey"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["name_survey"]['show'] = (bool)$this->_tpl_vars['show']['survey_name'];
$this->_sections["name_survey"]['max'] = $this->_sections["name_survey"]['loop'];
$this->_sections["name_survey"]['step'] = 1;
$this->_sections["name_survey"]['start'] = $this->_sections["name_survey"]['step'] > 0 ? 0 : $this->_sections["name_survey"]['loop']-1;
if ($this->_sections["name_survey"]['show']) {
    $this->_sections["name_survey"]['total'] = $this->_sections["name_survey"]['loop'];
    if ($this->_sections["name_survey"]['total'] == 0)
        $this->_sections["name_survey"]['show'] = false;
} else
    $this->_sections["name_survey"]['total'] = 0;
if ($this->_sections["name_survey"]['show']):

            for ($this->_sections["name_survey"]['index'] = $this->_sections["name_survey"]['start'], $this->_sections["name_survey"]['iteration'] = 1;
                 $this->_sections["name_survey"]['iteration'] <= $this->_sections["name_survey"]['total'];
                 $this->_sections["name_survey"]['index'] += $this->_sections["name_survey"]['step'], $this->_sections["name_survey"]['iteration']++):
$this->_sections["name_survey"]['rownum'] = $this->_sections["name_survey"]['iteration'];
$this->_sections["name_survey"]['index_prev'] = $this->_sections["name_survey"]['index'] - $this->_sections["name_survey"]['step'];
$this->_sections["name_survey"]['index_next'] = $this->_sections["name_survey"]['index'] + $this->_sections["name_survey"]['step'];
$this->_sections["name_survey"]['first']      = ($this->_sections["name_survey"]['iteration'] == 1);
$this->_sections["name_survey"]['last']       = ($this->_sections["name_survey"]['iteration'] == $this->_sections["name_survey"]['total']);
?>
  <tr>
    <td class="whitebox">Survey Name</td>
  </tr>
  <tr>
    <td>
      <div class="indented_cell">
        Enter name of survey. This is the name that people will see when they are
        presented a list of active surveys on the server. This name should be unique
        from all other surveys so they can be told apart. Use a descriptive name such
        as "C447 Oct-2002 Command Climate Assessment" instead of "charlie survey."
        <br />
        <input type="text" name="survey_name" size="40" maxlength="255" value="<?php echo $this->_tpl_vars['survey_name']; ?>
">
      </div>
    </td>
  </tr>
  <tr>
    <td class="whitebox">Default Username and Password</td>
  </tr>
  <tr>
    <td>
      <div class="indented_cell">
        You must create a default user that will have permissions to edit the survey you're creating. You
        can later edit this user or add others from the Access Control portion of the Edit Survey pages.
        <p>Username: <input type="text" name="username" value="<?php echo $this->_tpl_vars['value']['username']; ?>
"></p>
        <p>Password: <input type="password" name="password" value="<?php echo $this->_tpl_vars['value']['password']; ?>
"><p>
      </div>
    </td>
  </tr>
  <tr>
    <td class="whitebox">Copy Survey</td>
  </tr>
  <tr>
    <td>
      <div class="indented_cell">
        To copy an already existing survey, choose it from the list below. Only public surveys
        can be copied. If you choose to copy a survey, all messages, demographics, and questions
        will be loaded from the existing survey and then you can go through and edit it to your
        liking.
        <br />
        <select name="copy_survey" size="1">
          <?php if (isset($this->_sections["cs"])) unset($this->_sections["cs"]);
$this->_sections["cs"]['name'] = "cs";
$this->_sections["cs"]['loop'] = is_array($this->_tpl_vars['public_surveys']['sid']) ? count($this->_tpl_vars['public_surveys']['sid']) : max(0, (int)$this->_tpl_vars['public_surveys']['sid']);
$this->_sections["cs"]['show'] = (bool)"1";
$this->_sections["cs"]['max'] = $this->_sections["cs"]['loop'];
$this->_sections["cs"]['step'] = 1;
$this->_sections["cs"]['start'] = $this->_sections["cs"]['step'] > 0 ? 0 : $this->_sections["cs"]['loop']-1;
if ($this->_sections["cs"]['show']) {
    $this->_sections["cs"]['total'] = $this->_sections["cs"]['loop'];
    if ($this->_sections["cs"]['total'] == 0)
        $this->_sections["cs"]['show'] = false;
} else
    $this->_sections["cs"]['total'] = 0;
if ($this->_sections["cs"]['show']):

            for ($this->_sections["cs"]['index'] = $this->_sections["cs"]['start'], $this->_sections["cs"]['iteration'] = 1;
                 $this->_sections["cs"]['iteration'] <= $this->_sections["cs"]['total'];
                 $this->_sections["cs"]['index'] += $this->_sections["cs"]['step'], $this->_sections["cs"]['iteration']++):
$this->_sections["cs"]['rownum'] = $this->_sections["cs"]['iteration'];
$this->_sections["cs"]['index_prev'] = $this->_sections["cs"]['index'] - $this->_sections["cs"]['step'];
$this->_sections["cs"]['index_next'] = $this->_sections["cs"]['index'] + $this->_sections["cs"]['step'];
$this->_sections["cs"]['first']      = ($this->_sections["cs"]['iteration'] == 1);
$this->_sections["cs"]['last']       = ($this->_sections["cs"]['iteration'] == $this->_sections["cs"]['total']);
?>
            <option value="<?php echo $this->_tpl_vars['public_surveys']['sid'][$this->_sections['cs']['index']]; ?>
"><?php echo $this->_tpl_vars['public_surveys']['name'][$this->_sections['cs']['index']]; ?>
</option>
          <?php endfor; endif; ?>
        </select>
      </div>
    </td>
  </tr>
<?php endfor; endif; ?>


  <tr>
    <td align="center">
    <br />

<?php if (isset($this->_sections["start_over_button"])) unset($this->_sections["start_over_button"]);
$this->_sections["start_over_button"]['name'] = "start_over_button";
$this->_sections["start_over_button"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["start_over_button"]['show'] = (bool)$this->_tpl_vars['show']['start_over_button'];
$this->_sections["start_over_button"]['max'] = $this->_sections["start_over_button"]['loop'];
$this->_sections["start_over_button"]['step'] = 1;
$this->_sections["start_over_button"]['start'] = $this->_sections["start_over_button"]['step'] > 0 ? 0 : $this->_sections["start_over_button"]['loop']-1;
if ($this->_sections["start_over_button"]['show']) {
    $this->_sections["start_over_button"]['total'] = $this->_sections["start_over_button"]['loop'];
    if ($this->_sections["start_over_button"]['total'] == 0)
        $this->_sections["start_over_button"]['show'] = false;
} else
    $this->_sections["start_over_button"]['total'] = 0;
if ($this->_sections["start_over_button"]['show']):

            for ($this->_sections["start_over_button"]['index'] = $this->_sections["start_over_button"]['start'], $this->_sections["start_over_button"]['iteration'] = 1;
                 $this->_sections["start_over_button"]['iteration'] <= $this->_sections["start_over_button"]['total'];
                 $this->_sections["start_over_button"]['index'] += $this->_sections["start_over_button"]['step'], $this->_sections["start_over_button"]['iteration']++):
$this->_sections["start_over_button"]['rownum'] = $this->_sections["start_over_button"]['iteration'];
$this->_sections["start_over_button"]['index_prev'] = $this->_sections["start_over_button"]['index'] - $this->_sections["start_over_button"]['step'];
$this->_sections["start_over_button"]['index_next'] = $this->_sections["start_over_button"]['index'] + $this->_sections["start_over_button"]['step'];
$this->_sections["start_over_button"]['first']      = ($this->_sections["start_over_button"]['iteration'] == 1);
$this->_sections["start_over_button"]['last']       = ($this->_sections["start_over_button"]['iteration'] == $this->_sections["start_over_button"]['total']);
?>
<input type="submit" value="<?php echo $this->_run_mod_handler('default', true, $this->_tpl_vars['button']['start_over'], "Start Over / Clear All"); ?>
" name="clear">
<?php endfor; endif; ?>


<?php if (isset($this->_sections["next_button"])) unset($this->_sections["next_button"]);
$this->_sections["next_button"]['name'] = "next_button";
$this->_sections["next_button"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["next_button"]['show'] = (bool)$this->_tpl_vars['show']['next_button'];
$this->_sections["next_button"]['max'] = $this->_sections["next_button"]['loop'];
$this->_sections["next_button"]['step'] = 1;
$this->_sections["next_button"]['start'] = $this->_sections["next_button"]['step'] > 0 ? 0 : $this->_sections["next_button"]['loop']-1;
if ($this->_sections["next_button"]['show']) {
    $this->_sections["next_button"]['total'] = $this->_sections["next_button"]['loop'];
    if ($this->_sections["next_button"]['total'] == 0)
        $this->_sections["next_button"]['show'] = false;
} else
    $this->_sections["next_button"]['total'] = 0;
if ($this->_sections["next_button"]['show']):

            for ($this->_sections["next_button"]['index'] = $this->_sections["next_button"]['start'], $this->_sections["next_button"]['iteration'] = 1;
                 $this->_sections["next_button"]['iteration'] <= $this->_sections["next_button"]['total'];
                 $this->_sections["next_button"]['index'] += $this->_sections["next_button"]['step'], $this->_sections["next_button"]['iteration']++):
$this->_sections["next_button"]['rownum'] = $this->_sections["next_button"]['iteration'];
$this->_sections["next_button"]['index_prev'] = $this->_sections["next_button"]['index'] - $this->_sections["next_button"]['step'];
$this->_sections["next_button"]['index_next'] = $this->_sections["next_button"]['index'] + $this->_sections["next_button"]['step'];
$this->_sections["next_button"]['first']      = ($this->_sections["next_button"]['iteration'] == 1);
$this->_sections["next_button"]['last']       = ($this->_sections["next_button"]['iteration'] == $this->_sections["next_button"]['total']);
?>
&nbsp;
<input type="submit" name="next" value="<?php echo $this->_run_mod_handler('default', true, $this->_tpl_vars['button']['next'], "Next Step"); ?>
">
<?php endfor; endif; ?>
    </td>
  </tr>

  <tr>
    <td style="text-align:center;">
      [ <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
">Main</a> ]
    </td>
  </tr>
</table>
</form>