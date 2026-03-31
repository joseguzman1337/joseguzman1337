<?php /* Smarty version 2.3.0, created on 2008-04-07 11:24:27
         compiled from Default/filter.tpl */ ?>
<form method="POST" action="<?php echo $this->_tpl_vars['conf']['html']; ?>
/results.php">
<input type="hidden" name="sid" value="<?php echo $this->_tpl_vars['sid']; ?>
">

  <table width="70%" align="center" cellpadding="0" cellspacing="0">
    <tr class="grayboxheader">
      <td width="14"><img src="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/box_left.gif" border="0" width="14"></td>
      <td background="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/box_bg.gif">Filter Results</td>
      <td width="14"><img src="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/box_right.gif" border="0" width="14"></td>
    </tr>
  </table>

  <table width="70%" align="center" class="bordered_table">
    <tr>
      <td>

        <div class="indented_cell">
          Choose the answers below that you want to filter survey results on. Only surveys that have
          matching answers to what you choose will be shown on the results page. You cannot base a filter
          on an answer type that is text, only multiple choice.
        </div>

        <?php if (isset($this->_sections["q"])) unset($this->_sections["q"]);
$this->_sections["q"]['name'] = "q";
$this->_sections["q"]['loop'] = is_array($this->_tpl_vars['question']['qid']) ? count($this->_tpl_vars['question']['qid']) : max(0, (int)$this->_tpl_vars['question']['qid']);
$this->_sections["q"]['show'] = true;
$this->_sections["q"]['max'] = $this->_sections["q"]['loop'];
$this->_sections["q"]['step'] = 1;
$this->_sections["q"]['start'] = $this->_sections["q"]['step'] > 0 ? 0 : $this->_sections["q"]['loop']-1;
if ($this->_sections["q"]['show']) {
    $this->_sections["q"]['total'] = $this->_sections["q"]['loop'];
    if ($this->_sections["q"]['total'] == 0)
        $this->_sections["q"]['show'] = false;
} else
    $this->_sections["q"]['total'] = 0;
if ($this->_sections["q"]['show']):

            for ($this->_sections["q"]['index'] = $this->_sections["q"]['start'], $this->_sections["q"]['iteration'] = 1;
                 $this->_sections["q"]['iteration'] <= $this->_sections["q"]['total'];
                 $this->_sections["q"]['index'] += $this->_sections["q"]['step'], $this->_sections["q"]['iteration']++):
$this->_sections["q"]['rownum'] = $this->_sections["q"]['iteration'];
$this->_sections["q"]['index_prev'] = $this->_sections["q"]['index'] - $this->_sections["q"]['step'];
$this->_sections["q"]['index_next'] = $this->_sections["q"]['index'] + $this->_sections["q"]['step'];
$this->_sections["q"]['first']      = ($this->_sections["q"]['iteration'] == 1);
$this->_sections["q"]['last']       = ($this->_sections["q"]['iteration'] == $this->_sections["q"]['total']);
?>
          <div class="whitebox">
            <?php echo $this->_sections['q']['iteration']; ?>
. <?php echo $this->_tpl_vars['question']['question'][$this->_sections['q']['index']]; ?>

          </div>
          <input type="hidden" name="name[<?php echo $this->_tpl_vars['question']['qid'][$this->_sections['q']['index']]; ?>
]" value="<?php echo $this->_tpl_vars['question']['encquestion'][$this->_sections['q']['index']]; ?>
">
          <div class="indented_cell">
            <?php if (isset($this->_sections["qv"])) unset($this->_sections["qv"]);
$this->_sections["qv"]['name'] = "qv";
$this->_sections["qv"]['loop'] = is_array($this->_tpl_vars['question']['value'][$this->_sections['q']['index']]) ? count($this->_tpl_vars['question']['value'][$this->_sections['q']['index']]) : max(0, (int)$this->_tpl_vars['question']['value'][$this->_sections['q']['index']]);
$this->_sections["qv"]['show'] = true;
$this->_sections["qv"]['max'] = $this->_sections["qv"]['loop'];
$this->_sections["qv"]['step'] = 1;
$this->_sections["qv"]['start'] = $this->_sections["qv"]['step'] > 0 ? 0 : $this->_sections["qv"]['loop']-1;
if ($this->_sections["qv"]['show']) {
    $this->_sections["qv"]['total'] = $this->_sections["qv"]['loop'];
    if ($this->_sections["qv"]['total'] == 0)
        $this->_sections["qv"]['show'] = false;
} else
    $this->_sections["qv"]['total'] = 0;
if ($this->_sections["qv"]['show']):

            for ($this->_sections["qv"]['index'] = $this->_sections["qv"]['start'], $this->_sections["qv"]['iteration'] = 1;
                 $this->_sections["qv"]['iteration'] <= $this->_sections["qv"]['total'];
                 $this->_sections["qv"]['index'] += $this->_sections["qv"]['step'], $this->_sections["qv"]['iteration']++):
$this->_sections["qv"]['rownum'] = $this->_sections["qv"]['iteration'];
$this->_sections["qv"]['index_prev'] = $this->_sections["qv"]['index'] - $this->_sections["qv"]['step'];
$this->_sections["qv"]['index_next'] = $this->_sections["qv"]['index'] + $this->_sections["qv"]['step'];
$this->_sections["qv"]['first']      = ($this->_sections["qv"]['iteration'] == 1);
$this->_sections["qv"]['last']       = ($this->_sections["qv"]['iteration'] == $this->_sections["qv"]['total']);
?>
              <input type="checkbox" value="<?php echo $this->_tpl_vars['question']['avid'][$this->_sections['q']['index']][$this->_sections['qv']['index']]; ?>
" name="filter[<?php echo $this->_tpl_vars['question']['qid'][$this->_sections['q']['index']]; ?>
][]" id="<?php echo $this->_tpl_vars['question']['avid'][$this->_sections['q']['index']][$this->_sections['qv']['index']]; ?>
">
              <label for="<?php echo $this->_tpl_vars['question']['avid'][$this->_sections['q']['index']][$this->_sections['qv']['index']]; ?>
"> <?php echo $this->_tpl_vars['question']['value'][$this->_sections['q']['index']][$this->_sections['qv']['index']]; ?>
</label>
              <br />
            <?php endfor; endif; ?>
          </div>
        <?php endfor; endif; ?>

        <div class="whitebox">
          Filter by Date
        </div>

        <div class="indented_cell">
          <input type="checkbox" name="date_filter" value="1">
          Limit Results by Date (Start and/or End Date can be left blank to include everything)

          <br />

          Start: <input type="text" name="start_date" value="<?php echo $this->_tpl_vars['date']['min']; ?>
">
          End: <input type="text" name="end_date" value="<?php echo $this->_tpl_vars['date']['max']; ?>
">
        </div>

        <div style="text-align:center">
          <input type="submit" value="Cancel">
          &nbsp;&nbsp;
          <input type="submit" name="filter_submit" value="Filter Results">
        </div>
      </td>
    </tr>
  </table>
</form>