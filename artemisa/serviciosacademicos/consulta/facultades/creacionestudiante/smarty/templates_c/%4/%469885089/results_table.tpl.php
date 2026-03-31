<?php /* Smarty version 2.3.0, created on 2008-04-07 17:12:31
         compiled from Default/results_table.tpl */ ?>
<table width="70%" align="center" cellpadding="0" cellspacing="0">
  <tr class="grayboxheader">
    <td width="14"><img src="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/box_left.gif" border="0" width="14"></td>
    <td background="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/box_bg.gif">Survey Results</td>
    <td width="14"><img src="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/box_right.gif" border="0" width="14"></td>
  </tr>
</table>
<table width="70%" align="center" class="bordered_table">
  <tr>
    <td>

      <div style="text-align:center">
        [ <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/index.php">Main</a> ]
        &nbsp;&nbsp;
        [ <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/results.php?sid=<?php echo $this->_tpl_vars['survey']['sid']; ?>
">Graphic Results</a> ]
        &nbsp;&nbsp;
        [ <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/results_csv.php?sid=<?php echo $this->_tpl_vars['survey']['sid']; ?>
">Export Results to CSV</a>
          <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/docs/index.html#csv_export">[?]</a> ]
      </div>

      <div class="whitebox">
        Results for Survey #<?php echo $this->_tpl_vars['survey']['sid']; ?>
: <?php echo $this->_tpl_vars['survey']['name']; ?>

      </div>

      <?php if (isset($this->_sections["filter_text"])) unset($this->_sections["filter_text"]);
$this->_sections["filter_text"]['name'] = "filter_text";
$this->_sections["filter_text"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["filter_text"]['show'] = (bool)$this->_tpl_vars['filter_text'];
$this->_sections["filter_text"]['max'] = $this->_sections["filter_text"]['loop'];
$this->_sections["filter_text"]['step'] = 1;
$this->_sections["filter_text"]['start'] = $this->_sections["filter_text"]['step'] > 0 ? 0 : $this->_sections["filter_text"]['loop']-1;
if ($this->_sections["filter_text"]['show']) {
    $this->_sections["filter_text"]['total'] = $this->_sections["filter_text"]['loop'];
    if ($this->_sections["filter_text"]['total'] == 0)
        $this->_sections["filter_text"]['show'] = false;
} else
    $this->_sections["filter_text"]['total'] = 0;
if ($this->_sections["filter_text"]['show']):

            for ($this->_sections["filter_text"]['index'] = $this->_sections["filter_text"]['start'], $this->_sections["filter_text"]['iteration'] = 1;
                 $this->_sections["filter_text"]['iteration'] <= $this->_sections["filter_text"]['total'];
                 $this->_sections["filter_text"]['index'] += $this->_sections["filter_text"]['step'], $this->_sections["filter_text"]['iteration']++):
$this->_sections["filter_text"]['rownum'] = $this->_sections["filter_text"]['iteration'];
$this->_sections["filter_text"]['index_prev'] = $this->_sections["filter_text"]['index'] - $this->_sections["filter_text"]['step'];
$this->_sections["filter_text"]['index_next'] = $this->_sections["filter_text"]['index'] + $this->_sections["filter_text"]['step'];
$this->_sections["filter_text"]['first']      = ($this->_sections["filter_text"]['iteration'] == 1);
$this->_sections["filter_text"]['last']       = ($this->_sections["filter_text"]['iteration'] == $this->_sections["filter_text"]['total']);
?>
        <br><span class="message">Notice: This result page shows the results filtered by the following questions:</span><br>
        <span style="font-size:x-small"><?php echo $this->_tpl_vars['filter_text']; ?>
</span>
      <?php endfor; endif; ?>

      <div>
        <table border="1" cellpadding="2" cellspacing="2" style="font-size:xx-small;margin-left:25px;margin-top:10px;margin-bottom:10px">
          <tr>
            <?php if (isset($this->_sections["q"])) unset($this->_sections["q"]);
$this->_sections["q"]['name'] = "q";
$this->_sections["q"]['loop'] = is_array($this->_tpl_vars['data']['questions']) ? count($this->_tpl_vars['data']['questions']) : max(0, (int)$this->_tpl_vars['data']['questions']);
$this->_sections["q"]['show'] = (bool)"TRUE";
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
              <th><?php echo $this->_tpl_vars['data']['questions'][$this->_sections['q']['index']]; ?>
</th>
            <?php endfor; endif; ?>
            <th>Datetime</th>
          </tr>
          <?php if (isset($this->_sections["x"])) unset($this->_sections["x"]);
$this->_sections["x"]['name'] = "x";
$this->_sections["x"]['loop'] = is_array($this->_tpl_vars['data']['answers']) ? count($this->_tpl_vars['data']['answers']) : max(0, (int)$this->_tpl_vars['data']['answers']);
$this->_sections["x"]['show'] = (bool)"TRUE";
$this->_sections["x"]['max'] = $this->_sections["x"]['loop'];
$this->_sections["x"]['step'] = 1;
$this->_sections["x"]['start'] = $this->_sections["x"]['step'] > 0 ? 0 : $this->_sections["x"]['loop']-1;
if ($this->_sections["x"]['show']) {
    $this->_sections["x"]['total'] = $this->_sections["x"]['loop'];
    if ($this->_sections["x"]['total'] == 0)
        $this->_sections["x"]['show'] = false;
} else
    $this->_sections["x"]['total'] = 0;
if ($this->_sections["x"]['show']):

            for ($this->_sections["x"]['index'] = $this->_sections["x"]['start'], $this->_sections["x"]['iteration'] = 1;
                 $this->_sections["x"]['iteration'] <= $this->_sections["x"]['total'];
                 $this->_sections["x"]['index'] += $this->_sections["x"]['step'], $this->_sections["x"]['iteration']++):
$this->_sections["x"]['rownum'] = $this->_sections["x"]['iteration'];
$this->_sections["x"]['index_prev'] = $this->_sections["x"]['index'] - $this->_sections["x"]['step'];
$this->_sections["x"]['index_next'] = $this->_sections["x"]['index'] + $this->_sections["x"]['step'];
$this->_sections["x"]['first']      = ($this->_sections["x"]['iteration'] == 1);
$this->_sections["x"]['last']       = ($this->_sections["x"]['iteration'] == $this->_sections["x"]['total']);
?>
            <tr>
              <?php if (isset($this->_sections["a"])) unset($this->_sections["a"]);
$this->_sections["a"]['name'] = "a";
$this->_sections["a"]['loop'] = is_array($this->_tpl_vars['data']['answers'][$this->_sections['x']['index']]) ? count($this->_tpl_vars['data']['answers'][$this->_sections['x']['index']]) : max(0, (int)$this->_tpl_vars['data']['answers'][$this->_sections['x']['index']]);
$this->_sections["a"]['show'] = (bool)"TRUE";
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
                <td><?php echo $this->_tpl_vars['data']['answers'][$this->_sections['x']['index']][$this->_sections['a']['index']]; ?>
</td>
              <?php endfor; endif; ?>
            </tr>
          <?php endfor; endif; ?>
        </table>
      </div>

      <div style="text-align:center">
        [ <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/index.php">Main</a> ]
        &nbsp;&nbsp;
        [ <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/results.php?sid=<?php echo $this->_tpl_vars['survey']['sid']; ?>
">Graphic Results</a> ]
        &nbsp;&nbsp;
        [ <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/results_csv.php?sid=<?php echo $this->_tpl_vars['survey']['sid']; ?>
">Export Results to CSV</a> ]
      </div>

    </td>
  </tr>
</table>