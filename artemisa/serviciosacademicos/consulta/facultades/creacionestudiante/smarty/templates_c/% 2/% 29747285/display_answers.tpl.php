<?php /* Smarty version 2.3.0, created on 2008-04-07 12:35:06
         compiled from Default/display_answers.tpl */ ?>
<?php $this->_load_plugins(array(
array('function', 'cycle', 'Default/display_answers.tpl', 29, false),)); ?><html>
  <head>
    <title>Answer Types and Values</title>
  </head>
  <body>

  <table width="95%" align="center" cellpadding="0" cellspacing="0">
    <tr class="grayboxheader">
      <td width="14"><img src="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/box_left.gif" border="0" width="14"></td>
      <td background="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/box_bg.gif">Survey #<?php echo $this->_tpl_vars['survey']['sid']; ?>
: <?php echo $this->_tpl_vars['survey']['name']; ?>
</td>
      <td width="14"><img src="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/box_right.gif" border="0" width="14"></td>
    </tr>
  </table>

  <table width="95%" align="center" border="1" cellspacing="0" style="border-color:#F9F9F9">
    <tr>
      <td colspan="5" style="text-align:center">
        [ <a href="#close_window" onclick="window.close();">Close Window</a> ]
      </td>
    </tr>
    <tr class="whitebox">
      <td>Answer Name</td>
      <td>Type*</td>
      <td>Values</td>
      <td>Label</td>
    </tr>

    <?php if (isset($this->_sections["answers"])) unset($this->_sections["answers"]);
$this->_sections["answers"]['name'] = "answers";
$this->_sections["answers"]['loop'] = is_array($this->_tpl_vars['answers']) ? count($this->_tpl_vars['answers']) : max(0, (int)$this->_tpl_vars['answers']);
$this->_sections["answers"]['show'] = (bool)"TRUE";
$this->_sections["answers"]['max'] = $this->_sections["answers"]['loop'];
$this->_sections["answers"]['step'] = 1;
$this->_sections["answers"]['start'] = $this->_sections["answers"]['step'] > 0 ? 0 : $this->_sections["answers"]['loop']-1;
if ($this->_sections["answers"]['show']) {
    $this->_sections["answers"]['total'] = $this->_sections["answers"]['loop'];
    if ($this->_sections["answers"]['total'] == 0)
        $this->_sections["answers"]['show'] = false;
} else
    $this->_sections["answers"]['total'] = 0;
if ($this->_sections["answers"]['show']):

            for ($this->_sections["answers"]['index'] = $this->_sections["answers"]['start'], $this->_sections["answers"]['iteration'] = 1;
                 $this->_sections["answers"]['iteration'] <= $this->_sections["answers"]['total'];
                 $this->_sections["answers"]['index'] += $this->_sections["answers"]['step'], $this->_sections["answers"]['iteration']++):
$this->_sections["answers"]['rownum'] = $this->_sections["answers"]['iteration'];
$this->_sections["answers"]['index_prev'] = $this->_sections["answers"]['index'] - $this->_sections["answers"]['step'];
$this->_sections["answers"]['index_next'] = $this->_sections["answers"]['index'] + $this->_sections["answers"]['step'];
$this->_sections["answers"]['first']      = ($this->_sections["answers"]['iteration'] == 1);
$this->_sections["answers"]['last']       = ($this->_sections["answers"]['iteration'] == $this->_sections["answers"]['total']);
?>
      <tr style="background-color:<?php $this->_plugins['function']['cycle'][0](array('values' => "#F9F9F9,#FFFFFF"), $this); if($this->_extract) { extract($this->_tpl_vars); $this->_extract=false; } ?>">
        <td><?php echo $this->_tpl_vars['answers'][$this->_sections['answers']['index']]['name']; ?>
</td>
        <td><?php echo $this->_tpl_vars['answers'][$this->_sections['answers']['index']]['type']; ?>
</td>
        <td>
          <?php if (isset($this->_sections["values"])) unset($this->_sections["values"]);
$this->_sections["values"]['name'] = "values";
$this->_sections["values"]['loop'] = is_array($this->_tpl_vars['answers'][$this->_sections['answers']['index']]['value']) ? count($this->_tpl_vars['answers'][$this->_sections['answers']['index']]['value']) : max(0, (int)$this->_tpl_vars['answers'][$this->_sections['answers']['index']]['value']);
$this->_sections["values"]['show'] = (bool)"TRUE";
$this->_sections["values"]['max'] = $this->_sections["values"]['loop'];
$this->_sections["values"]['step'] = 1;
$this->_sections["values"]['start'] = $this->_sections["values"]['step'] > 0 ? 0 : $this->_sections["values"]['loop']-1;
if ($this->_sections["values"]['show']) {
    $this->_sections["values"]['total'] = $this->_sections["values"]['loop'];
    if ($this->_sections["values"]['total'] == 0)
        $this->_sections["values"]['show'] = false;
} else
    $this->_sections["values"]['total'] = 0;
if ($this->_sections["values"]['show']):

            for ($this->_sections["values"]['index'] = $this->_sections["values"]['start'], $this->_sections["values"]['iteration'] = 1;
                 $this->_sections["values"]['iteration'] <= $this->_sections["values"]['total'];
                 $this->_sections["values"]['index'] += $this->_sections["values"]['step'], $this->_sections["values"]['iteration']++):
$this->_sections["values"]['rownum'] = $this->_sections["values"]['iteration'];
$this->_sections["values"]['index_prev'] = $this->_sections["values"]['index'] - $this->_sections["values"]['step'];
$this->_sections["values"]['index_next'] = $this->_sections["values"]['index'] + $this->_sections["values"]['step'];
$this->_sections["values"]['first']      = ($this->_sections["values"]['iteration'] == 1);
$this->_sections["values"]['last']       = ($this->_sections["values"]['iteration'] == $this->_sections["values"]['total']);
?>
            <?php echo $this->_tpl_vars['answers'][$this->_sections['answers']['index']]['value'][$this->_sections['values']['index']]; ?>
<br />
          <?php endfor; endif; ?>
        </td>
        <td><?php echo $this->_tpl_vars['answers'][$this->_sections['answers']['index']]['label']; ?>
</td>
      </tr>
    <?php endfor; endif; ?>

    <tr>
      <td colspan="5">
        *Answer Types:
        <ul>
          <li>T: Text Area (no max characters)</li>
          <li>S: Sentence (255 characters max)</li>
          <li>MM: Multiple Choice (more than one answer allowed)</li>
          <li>MS: Multiple Choice (only one answer allowed)</li>
          <li>N: No answer (label)</li>
        </ul>
      </td>
    </tr>

    <tr>
      <td colspan="5" style="text-align:center">
        [ <a href="#close_window" onclick="window.close();">Close Window</a> ]
      </td>
    </tr>
  </table>
</body>
</html>