<?php /* Smarty version 2.3.0, created on 2008-04-07 16:07:12
         compiled from Default/take_survey_question_MM_M.tpl */ ?>
<?php $this->_load_plugins(array(
array('function', 'cycle', 'Default/take_survey_question_MM_M.tpl', 1, false),)); ?>  <tr style="background-color:<?php $this->_plugins['function']['cycle'][0](array('values' => "#FFFFFF,F9F9F9"), $this); if($this->_extract) { extract($this->_tpl_vars); $this->_extract=false; } ?>">
    <td>
      <input type="hidden" name="answer[<?php echo $this->_tpl_vars['q']['qid']; ?>
][0]" value="">
      <?php echo $this->_tpl_vars['q']['question_num']; ?>
. <?php echo $this->_tpl_vars['q']['required_text']; ?>
 <?php echo $this->_tpl_vars['q']['question']; ?>

    </td>

    <?php if (isset($this->_sections["mm"])) unset($this->_sections["mm"]);
$this->_sections["mm"]['name'] = "mm";
$this->_sections["mm"]['loop'] = is_array($this->_tpl_vars['q']['num_values']) ? count($this->_tpl_vars['q']['num_values']) : max(0, (int)$this->_tpl_vars['q']['num_values']);
$this->_sections["mm"]['show'] = (bool)"TRUE";
$this->_sections["mm"]['max'] = $this->_sections["mm"]['loop'];
$this->_sections["mm"]['step'] = 1;
$this->_sections["mm"]['start'] = $this->_sections["mm"]['step'] > 0 ? 0 : $this->_sections["mm"]['loop']-1;
if ($this->_sections["mm"]['show']) {
    $this->_sections["mm"]['total'] = $this->_sections["mm"]['loop'];
    if ($this->_sections["mm"]['total'] == 0)
        $this->_sections["mm"]['show'] = false;
} else
    $this->_sections["mm"]['total'] = 0;
if ($this->_sections["mm"]['show']):

            for ($this->_sections["mm"]['index'] = $this->_sections["mm"]['start'], $this->_sections["mm"]['iteration'] = 1;
                 $this->_sections["mm"]['iteration'] <= $this->_sections["mm"]['total'];
                 $this->_sections["mm"]['index'] += $this->_sections["mm"]['step'], $this->_sections["mm"]['iteration']++):
$this->_sections["mm"]['rownum'] = $this->_sections["mm"]['iteration'];
$this->_sections["mm"]['index_prev'] = $this->_sections["mm"]['index'] - $this->_sections["mm"]['step'];
$this->_sections["mm"]['index_next'] = $this->_sections["mm"]['index'] + $this->_sections["mm"]['step'];
$this->_sections["mm"]['first']      = ($this->_sections["mm"]['iteration'] == 1);
$this->_sections["mm"]['last']       = ($this->_sections["mm"]['iteration'] == $this->_sections["mm"]['total']);
?>
      <td>
        <input type="checkbox" name="answer[<?php echo $this->_tpl_vars['q']['qid']; ?>
][0][]" value="<?php echo $this->_tpl_vars['q']['avid'][$this->_sections['mm']['index']]; ?>
" <?php echo $this->_tpl_vars['q']['selected'][0][$this->_sections['mm']['index']]; ?>
>
      </td>
    <?php endfor; endif; ?>