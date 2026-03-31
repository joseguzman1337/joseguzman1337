<?php /* Smarty version 2.3.0, created on 2008-04-22 18:15:33
         compiled from Default/take_survey_question_MS_M.tpl */ ?>
<?php $this->_load_plugins(array(
array('function', 'cycle', 'Default/take_survey_question_MS_M.tpl', 1, false),)); ?>  <tr style="background-color:<?php $this->_plugins['function']['cycle'][0](array('values' => "#FFFFFF,F9F9F9"), $this); if($this->_extract) { extract($this->_tpl_vars); $this->_extract=false; } ?>">
    <td>
      <?php echo $this->_tpl_vars['q']['question_num']; ?>
. <?php echo $this->_tpl_vars['q']['required_text']; ?>
 <?php echo $this->_tpl_vars['q']['question']; ?>

    </td>

    <?php if (isset($this->_sections["ms"])) unset($this->_sections["ms"]);
$this->_sections["ms"]['name'] = "ms";
$this->_sections["ms"]['loop'] = is_array($this->_tpl_vars['q']['num_values']) ? count($this->_tpl_vars['q']['num_values']) : max(0, (int)$this->_tpl_vars['q']['num_values']);
$this->_sections["ms"]['show'] = (bool)"TRUE";
$this->_sections["ms"]['max'] = $this->_sections["ms"]['loop'];
$this->_sections["ms"]['step'] = 1;
$this->_sections["ms"]['start'] = $this->_sections["ms"]['step'] > 0 ? 0 : $this->_sections["ms"]['loop']-1;
if ($this->_sections["ms"]['show']) {
    $this->_sections["ms"]['total'] = $this->_sections["ms"]['loop'];
    if ($this->_sections["ms"]['total'] == 0)
        $this->_sections["ms"]['show'] = false;
} else
    $this->_sections["ms"]['total'] = 0;
if ($this->_sections["ms"]['show']):

            for ($this->_sections["ms"]['index'] = $this->_sections["ms"]['start'], $this->_sections["ms"]['iteration'] = 1;
                 $this->_sections["ms"]['iteration'] <= $this->_sections["ms"]['total'];
                 $this->_sections["ms"]['index'] += $this->_sections["ms"]['step'], $this->_sections["ms"]['iteration']++):
$this->_sections["ms"]['rownum'] = $this->_sections["ms"]['iteration'];
$this->_sections["ms"]['index_prev'] = $this->_sections["ms"]['index'] - $this->_sections["ms"]['step'];
$this->_sections["ms"]['index_next'] = $this->_sections["ms"]['index'] + $this->_sections["ms"]['step'];
$this->_sections["ms"]['first']      = ($this->_sections["ms"]['iteration'] == 1);
$this->_sections["ms"]['last']       = ($this->_sections["ms"]['iteration'] == $this->_sections["ms"]['total']);
?>
      <td>
        <input type="radio" name="answer[<?php echo $this->_tpl_vars['q']['qid']; ?>
][0]" value="<?php echo $this->_tpl_vars['q']['avid'][$this->_sections['ms']['index']]; ?>
" <?php echo $this->_tpl_vars['q']['selected'][0][$this->_sections['ms']['index']]; ?>
>
      </td>
    <?php endfor; endif; ?>