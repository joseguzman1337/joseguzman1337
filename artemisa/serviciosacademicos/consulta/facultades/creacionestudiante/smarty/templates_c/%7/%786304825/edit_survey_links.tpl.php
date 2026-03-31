<?php /* Smarty version 2.3.0, created on 2008-04-07 11:08:00
         compiled from Default/edit_survey_links.tpl */ ?>
  <tr>
    <td align="center">
      [ <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/edit_survey.php?sid=<?php echo $this->_tpl_vars['data']['sid']; ?>
&mode=properties"> Propiedades</a>
      &nbsp;|&nbsp;
      <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/edit_survey.php?sid=<?php echo $this->_tpl_vars['data']['sid']; ?>
&mode=questions">Edit Questions</a>
      &nbsp;|&nbsp;
      <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/new_answer_type.php?sid=<?php echo $this->_tpl_vars['data']['sid']; ?>
">New Answer Type</a>
      &nbsp;|&nbsp;
      <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/edit_answer.php?sid=<?php echo $this->_tpl_vars['data']['sid']; ?>
">Edit Answer Type</a>
      &nbsp;|&nbsp;
      <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/edit_survey.php?sid=<?php echo $this->_tpl_vars['data']['sid']; ?>
&mode=access_control">Access Control</a>
      &nbsp;|&nbsp;
      <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/survey.php?sid=<?php echo $this->_tpl_vars['data']['sid']; ?>
&preview_survey=1" target="_blank">Preview Survey</a>
      &nbsp;|&nbsp;
      <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/index.php">Return to Main</a>
      <?php if (isset($this->_sections["admin_link"])) unset($this->_sections["admin_link"]);
$this->_sections["admin_link"]['name'] = "admin_link";
$this->_sections["admin_link"]['show'] = (bool)$$conf.show_admin_link;
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