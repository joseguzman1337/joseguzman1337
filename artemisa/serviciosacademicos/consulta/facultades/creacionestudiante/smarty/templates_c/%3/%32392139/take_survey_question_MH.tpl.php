<?php /* Smarty version 2.3.0, created on 2008-04-07 10:11:28
         compiled from Default/take_survey_question_MH.tpl */ ?>
<div class="indented_cell">
  <table border="0" width="100%">
    <tr>
      <td>
        <table border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td>&nbsp;</td>
            <?php if (isset($this->_sections["mh"])) unset($this->_sections["mh"]);
$this->_sections["mh"]['name'] = "mh";
$this->_sections["mh"]['loop'] = is_array($this->_tpl_vars['q']['num_values']) ? count($this->_tpl_vars['q']['num_values']) : max(0, (int)$this->_tpl_vars['q']['num_values']);
$this->_sections["mh"]['show'] = (bool)"TRUE";
$this->_sections["mh"]['max'] = $this->_sections["mh"]['loop'];
$this->_sections["mh"]['step'] = 1;
$this->_sections["mh"]['start'] = $this->_sections["mh"]['step'] > 0 ? 0 : $this->_sections["mh"]['loop']-1;
if ($this->_sections["mh"]['show']) {
    $this->_sections["mh"]['total'] = $this->_sections["mh"]['loop'];
    if ($this->_sections["mh"]['total'] == 0)
        $this->_sections["mh"]['show'] = false;
} else
    $this->_sections["mh"]['total'] = 0;
if ($this->_sections["mh"]['show']):

            for ($this->_sections["mh"]['index'] = $this->_sections["mh"]['start'], $this->_sections["mh"]['iteration'] = 1;
                 $this->_sections["mh"]['iteration'] <= $this->_sections["mh"]['total'];
                 $this->_sections["mh"]['index'] += $this->_sections["mh"]['step'], $this->_sections["mh"]['iteration']++):
$this->_sections["mh"]['rownum'] = $this->_sections["mh"]['iteration'];
$this->_sections["mh"]['index_prev'] = $this->_sections["mh"]['index'] - $this->_sections["mh"]['step'];
$this->_sections["mh"]['index_next'] = $this->_sections["mh"]['index'] + $this->_sections["mh"]['step'];
$this->_sections["mh"]['first']      = ($this->_sections["mh"]['iteration'] == 1);
$this->_sections["mh"]['last']       = ($this->_sections["mh"]['iteration'] == $this->_sections["mh"]['total']);
?>
              <td><?php echo $this->_tpl_vars['q']['value'][$this->_sections['mh']['index']]; ?>
</td>
            <?php endfor; endif; ?>
          </tr>