<?php /* Smarty version 2.3.0, created on 2008-04-07 11:56:19
         compiled from Default/edit_survey_edit_atc.tpl */ ?>
      <div class="whitebox">
        Choose Answer Type
      </div>

      
        <?php if (isset($this->_sections["del"])) unset($this->_sections["del"]);
$this->_sections["del"]['name'] = "del";
$this->_sections["del"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["del"]['show'] = (bool)$this->_tpl_vars['show']['del_message'];
$this->_sections["del"]['max'] = $this->_sections["del"]['loop'];
$this->_sections["del"]['step'] = 1;
$this->_sections["del"]['start'] = $this->_sections["del"]['step'] > 0 ? 0 : $this->_sections["del"]['loop']-1;
if ($this->_sections["del"]['show']) {
    $this->_sections["del"]['total'] = $this->_sections["del"]['loop'];
    if ($this->_sections["del"]['total'] == 0)
        $this->_sections["del"]['show'] = false;
} else
    $this->_sections["del"]['total'] = 0;
if ($this->_sections["del"]['show']):

            for ($this->_sections["del"]['index'] = $this->_sections["del"]['start'], $this->_sections["del"]['iteration'] = 1;
                 $this->_sections["del"]['iteration'] <= $this->_sections["del"]['total'];
                 $this->_sections["del"]['index'] += $this->_sections["del"]['step'], $this->_sections["del"]['iteration']++):
$this->_sections["del"]['rownum'] = $this->_sections["del"]['iteration'];
$this->_sections["del"]['index_prev'] = $this->_sections["del"]['index'] - $this->_sections["del"]['step'];
$this->_sections["del"]['index_next'] = $this->_sections["del"]['index'] + $this->_sections["del"]['step'];
$this->_sections["del"]['first']      = ($this->_sections["del"]['iteration'] == 1);
$this->_sections["del"]['last']       = ($this->_sections["del"]['iteration'] == $this->_sections["del"]['total']);
?>
          <div class="message" style="width:100%">Answer successfully deleted.</div>
        <?php endfor; endif; ?>
      

      <form method="GET" action="<?php echo $this->_tpl_vars['conf']['html']; ?>
/edit_answer.php">
        <input type="hidden" name="sid" value="<?php echo $this->_tpl_vars['answer']['sid']; ?>
">
        <select name="aid" size="1">
          <?php if (isset($this->_sections["a"])) unset($this->_sections["a"]);
$this->_sections["a"]['name'] = "a";
$this->_sections["a"]['loop'] = is_array($this->_tpl_vars['answer']['aid']) ? count($this->_tpl_vars['answer']['aid']) : max(0, (int)$this->_tpl_vars['answer']['aid']);
$this->_sections["a"]['show'] = true;
$this->_sections["a"]['max'] = $this->_sections["a"]['loop'];
$this->_sections["a"]['step'] = 1;
$this->_sections["a"]['start'] = $this->_sections["a"]['step'] > 0 ? 0 : $this->_sections["a"]['loop']-1;
if ($this->_sections["a"]['show']) {
    $this->_sections["a"]['total'] = $this->_sections["a"]['loop'];
    if ($this->_sections["a"]['total'] == 0)
        $this->_sections["a"]['show'] = false;
} else
    $this->_sections["a"]['total'] = 0;
if ($this->_sections["a"]['show']):

            for ($this->_sections["a"]['index'] = $this->_sections["a"]['start'], $this->_sections["a"]['iteration'] = 1;
                 $this->_sections["a"]['iteration'] <= $this->_sections["a"]['total'];
                 $this->_sections["a"]['index'] += $this->_sections["a"]['step'], $this->_sections["a"]['iteration']++):
$this->_sections["a"]['rownum'] = $this->_sections["a"]['iteration'];
$this->_sections["a"]['index_prev'] = $this->_sections["a"]['index'] - $this->_sections["a"]['step'];
$this->_sections["a"]['index_next'] = $this->_sections["a"]['index'] + $this->_sections["a"]['step'];
$this->_sections["a"]['first']      = ($this->_sections["a"]['iteration'] == 1);
$this->_sections["a"]['last']       = ($this->_sections["a"]['iteration'] == $this->_sections["a"]['total']);
?>
            <option value="<?php echo $this->_tpl_vars['answer']['aid'][$this->_sections['a']['index']]; ?>
"><?php echo $this->_tpl_vars['answer']['name'][$this->_sections['a']['index']]; ?>
</option>
          <?php endfor; endif; ?>
        </select>
        <input type="submit" value="Edit Answer Type">
        &nbsp;&nbsp;
        <a href="#show_answers" onclick="window.open('<?php echo $this->_tpl_vars['conf']['html']; ?>
/display_answers.php?sid=<?php echo $this->_tpl_vars['answer']['sid']; ?>
','mywindow','toolbar=no,location=no,directories=no,status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=640,height=480,left=30,top=30');">
          [ View Answer Types ]
        </a>

      </form>