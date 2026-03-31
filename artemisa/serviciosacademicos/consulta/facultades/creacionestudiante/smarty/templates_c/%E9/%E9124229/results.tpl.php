<?php /* Smarty version 2.3.0, created on 2008-04-07 10:07:16
         compiled from Default/results.tpl */ ?>
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
/results_table.php?sid=<?php echo $this->_tpl_vars['survey']['sid']; ?>
">Results as Table</a>
          <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/docs/index.html#table_results">[?]</a> ]
        &nbsp;&nbsp;
        [ Export Results to CSV as
          <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/results_csv.php?sid=<?php echo $this->_tpl_vars['survey']['sid']; ?>
&export_type=<?php echo $this->_tpl_vars['survey']['export_csv_text']; ?>
">Text</a> or
          <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/results_csv.php?sid=<?php echo $this->_tpl_vars['survey']['sid']; ?>
&export_type=<?php echo $this->_tpl_vars['survey']['export_csv_numeric']; ?>
">Numeric</a> Values
          <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/docs/index.html#csv_export">[?]</a> ]
      </div>

      <div class="whitebox">
        Results for Survey #<?php echo $this->_tpl_vars['survey']['sid']; ?>
: <?php echo $this->_tpl_vars['survey']['name']; ?>

      </div>

      <form method="GET" action="results.php">
        <input type="hidden" name="sid" value="<?php echo $this->_tpl_vars['survey']['sid']; ?>
">

        <span class="example">
          Questions marked with a <?php echo $this->_tpl_vars['survey']['required']; ?>
 were required.
        </span>

        <br />

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

        <br />

        <div>
          <select name="action" size="1">
            <option value="filter">Filter On Checked Questions</option>
            <?php if (isset($this->_sections["clear_filter"])) unset($this->_sections["clear_filter"]);
$this->_sections["clear_filter"]['name'] = "clear_filter";
$this->_sections["clear_filter"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["clear_filter"]['show'] = (bool)$this->_tpl_vars['show']['clear_filter'];
$this->_sections["clear_filter"]['max'] = $this->_sections["clear_filter"]['loop'];
$this->_sections["clear_filter"]['step'] = 1;
$this->_sections["clear_filter"]['start'] = $this->_sections["clear_filter"]['step'] > 0 ? 0 : $this->_sections["clear_filter"]['loop']-1;
if ($this->_sections["clear_filter"]['show']) {
    $this->_sections["clear_filter"]['total'] = $this->_sections["clear_filter"]['loop'];
    if ($this->_sections["clear_filter"]['total'] == 0)
        $this->_sections["clear_filter"]['show'] = false;
} else
    $this->_sections["clear_filter"]['total'] = 0;
if ($this->_sections["clear_filter"]['show']):

            for ($this->_sections["clear_filter"]['index'] = $this->_sections["clear_filter"]['start'], $this->_sections["clear_filter"]['iteration'] = 1;
                 $this->_sections["clear_filter"]['iteration'] <= $this->_sections["clear_filter"]['total'];
                 $this->_sections["clear_filter"]['index'] += $this->_sections["clear_filter"]['step'], $this->_sections["clear_filter"]['iteration']++):
$this->_sections["clear_filter"]['rownum'] = $this->_sections["clear_filter"]['iteration'];
$this->_sections["clear_filter"]['index_prev'] = $this->_sections["clear_filter"]['index'] - $this->_sections["clear_filter"]['step'];
$this->_sections["clear_filter"]['index_next'] = $this->_sections["clear_filter"]['index'] + $this->_sections["clear_filter"]['step'];
$this->_sections["clear_filter"]['first']      = ($this->_sections["clear_filter"]['iteration'] == 1);
$this->_sections["clear_filter"]['last']       = ($this->_sections["clear_filter"]['iteration'] == $this->_sections["clear_filter"]['total']);
?>
              <option value="clear_filter">Clear Filter</option>
            <?php endfor; endif; ?>

            <?php if (isset($this->_sections["hide_show_questions"])) unset($this->_sections["hide_show_questions"]);
$this->_sections["hide_show_questions"]['name'] = "hide_show_questions";
$this->_sections["hide_show_questions"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["hide_show_questions"]['show'] = (bool)$this->_tpl_vars['survey']['hide_show_questions'];
$this->_sections["hide_show_questions"]['max'] = $this->_sections["hide_show_questions"]['loop'];
$this->_sections["hide_show_questions"]['step'] = 1;
$this->_sections["hide_show_questions"]['start'] = $this->_sections["hide_show_questions"]['step'] > 0 ? 0 : $this->_sections["hide_show_questions"]['loop']-1;
if ($this->_sections["hide_show_questions"]['show']) {
    $this->_sections["hide_show_questions"]['total'] = $this->_sections["hide_show_questions"]['loop'];
    if ($this->_sections["hide_show_questions"]['total'] == 0)
        $this->_sections["hide_show_questions"]['show'] = false;
} else
    $this->_sections["hide_show_questions"]['total'] = 0;
if ($this->_sections["hide_show_questions"]['show']):

            for ($this->_sections["hide_show_questions"]['index'] = $this->_sections["hide_show_questions"]['start'], $this->_sections["hide_show_questions"]['iteration'] = 1;
                 $this->_sections["hide_show_questions"]['iteration'] <= $this->_sections["hide_show_questions"]['total'];
                 $this->_sections["hide_show_questions"]['index'] += $this->_sections["hide_show_questions"]['step'], $this->_sections["hide_show_questions"]['iteration']++):
$this->_sections["hide_show_questions"]['rownum'] = $this->_sections["hide_show_questions"]['iteration'];
$this->_sections["hide_show_questions"]['index_prev'] = $this->_sections["hide_show_questions"]['index'] - $this->_sections["hide_show_questions"]['step'];
$this->_sections["hide_show_questions"]['index_next'] = $this->_sections["hide_show_questions"]['index'] + $this->_sections["hide_show_questions"]['step'];
$this->_sections["hide_show_questions"]['first']      = ($this->_sections["hide_show_questions"]['iteration'] == 1);
$this->_sections["hide_show_questions"]['last']       = ($this->_sections["hide_show_questions"]['iteration'] == $this->_sections["hide_show_questions"]['total']);
?>
              <option value="hide_questions">Hide Checked Questions</option>
              <option value="show_questions">Show Only Checked Questions</option>
            <?php endfor; endif; ?>

            <?php if (isset($this->_sections["show_all_questions"])) unset($this->_sections["show_all_questions"]);
$this->_sections["show_all_questions"]['name'] = "show_all_questions";
$this->_sections["show_all_questions"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["show_all_questions"]['show'] = (bool)$this->_tpl_vars['survey']['show_all_questions'];
$this->_sections["show_all_questions"]['max'] = $this->_sections["show_all_questions"]['loop'];
$this->_sections["show_all_questions"]['step'] = 1;
$this->_sections["show_all_questions"]['start'] = $this->_sections["show_all_questions"]['step'] > 0 ? 0 : $this->_sections["show_all_questions"]['loop']-1;
if ($this->_sections["show_all_questions"]['show']) {
    $this->_sections["show_all_questions"]['total'] = $this->_sections["show_all_questions"]['loop'];
    if ($this->_sections["show_all_questions"]['total'] == 0)
        $this->_sections["show_all_questions"]['show'] = false;
} else
    $this->_sections["show_all_questions"]['total'] = 0;
if ($this->_sections["show_all_questions"]['show']):

            for ($this->_sections["show_all_questions"]['index'] = $this->_sections["show_all_questions"]['start'], $this->_sections["show_all_questions"]['iteration'] = 1;
                 $this->_sections["show_all_questions"]['iteration'] <= $this->_sections["show_all_questions"]['total'];
                 $this->_sections["show_all_questions"]['index'] += $this->_sections["show_all_questions"]['step'], $this->_sections["show_all_questions"]['iteration']++):
$this->_sections["show_all_questions"]['rownum'] = $this->_sections["show_all_questions"]['iteration'];
$this->_sections["show_all_questions"]['index_prev'] = $this->_sections["show_all_questions"]['index'] - $this->_sections["show_all_questions"]['step'];
$this->_sections["show_all_questions"]['index_next'] = $this->_sections["show_all_questions"]['index'] + $this->_sections["show_all_questions"]['step'];
$this->_sections["show_all_questions"]['first']      = ($this->_sections["show_all_questions"]['iteration'] == 1);
$this->_sections["show_all_questions"]['last']       = ($this->_sections["show_all_questions"]['iteration'] == $this->_sections["show_all_questions"]['total']);
?>
              <option value="show_all_questions">Show All Questions</option>
            <?php endfor; endif; ?>
          </select>
          <input type="submit" name="results_action" value="Go">
          <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/docs/index.html#filter_results">[?]</a>
        </div>

        <br />

        <div class="whitebox">
          Survey Time Stats
        </div>
        <div class="indented_cell">
          Average Completion Time: <?php echo $this->_tpl_vars['survey']['avgtime']['minutes']; ?>
min <?php echo $this->_tpl_vars['survey']['avgtime']['seconds']; ?>
sec
          (Min: <?php echo $this->_tpl_vars['survey']['mintime']['minutes']; ?>
min <?php echo $this->_tpl_vars['survey']['mintime']['seconds']; ?>
sec, Max: <?php echo $this->_tpl_vars['survey']['maxtime']['minutes']; ?>
min <?php echo $this->_tpl_vars['survey']['maxtime']['seconds']; ?>
sec)
          <br />
          Average Time before Quit: <?php echo $this->_tpl_vars['survey']['quittime']['minutes']; ?>
min <?php echo $this->_tpl_vars['survey']['quittime']['seconds']; ?>
sec
        </div>

        <?php if (isset($this->_sections["qid"])) unset($this->_sections["qid"]);
$this->_sections["qid"]['name'] = "qid";
$this->_sections["qid"]['loop'] = is_array($this->_tpl_vars['qid']) ? count($this->_tpl_vars['qid']) : max(0, (int)$this->_tpl_vars['qid']);
$this->_sections["qid"]['show'] = true;
$this->_sections["qid"]['max'] = $this->_sections["qid"]['loop'];
$this->_sections["qid"]['step'] = 1;
$this->_sections["qid"]['start'] = $this->_sections["qid"]['step'] > 0 ? 0 : $this->_sections["qid"]['loop']-1;
if ($this->_sections["qid"]['show']) {
    $this->_sections["qid"]['total'] = $this->_sections["qid"]['loop'];
    if ($this->_sections["qid"]['total'] == 0)
        $this->_sections["qid"]['show'] = false;
} else
    $this->_sections["qid"]['total'] = 0;
if ($this->_sections["qid"]['show']):

            for ($this->_sections["qid"]['index'] = $this->_sections["qid"]['start'], $this->_sections["qid"]['iteration'] = 1;
                 $this->_sections["qid"]['iteration'] <= $this->_sections["qid"]['total'];
                 $this->_sections["qid"]['index'] += $this->_sections["qid"]['step'], $this->_sections["qid"]['iteration']++):
$this->_sections["qid"]['rownum'] = $this->_sections["qid"]['iteration'];
$this->_sections["qid"]['index_prev'] = $this->_sections["qid"]['index'] - $this->_sections["qid"]['step'];
$this->_sections["qid"]['index_next'] = $this->_sections["qid"]['index'] + $this->_sections["qid"]['step'];
$this->_sections["qid"]['first']      = ($this->_sections["qid"]['iteration'] == 1);
$this->_sections["qid"]['last']       = ($this->_sections["qid"]['iteration'] == $this->_sections["qid"]['total']);
?>
          <div class="whitebox">
            <?php if (isset($this->_sections["box"])) unset($this->_sections["box"]);
$this->_sections["box"]['name'] = "box";
$this->_sections["box"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["box"]['show'] = (bool)$this->_tpl_vars['survey']['hide_show_questions'];
$this->_sections["box"]['max'] = $this->_sections["box"]['loop'];
$this->_sections["box"]['step'] = 1;
$this->_sections["box"]['start'] = $this->_sections["box"]['step'] > 0 ? 0 : $this->_sections["box"]['loop']-1;
if ($this->_sections["box"]['show']) {
    $this->_sections["box"]['total'] = $this->_sections["box"]['loop'];
    if ($this->_sections["box"]['total'] == 0)
        $this->_sections["box"]['show'] = false;
} else
    $this->_sections["box"]['total'] = 0;
if ($this->_sections["box"]['show']):

            for ($this->_sections["box"]['index'] = $this->_sections["box"]['start'], $this->_sections["box"]['iteration'] = 1;
                 $this->_sections["box"]['iteration'] <= $this->_sections["box"]['total'];
                 $this->_sections["box"]['index'] += $this->_sections["box"]['step'], $this->_sections["box"]['iteration']++):
$this->_sections["box"]['rownum'] = $this->_sections["box"]['iteration'];
$this->_sections["box"]['index_prev'] = $this->_sections["box"]['index'] - $this->_sections["box"]['step'];
$this->_sections["box"]['index_next'] = $this->_sections["box"]['index'] + $this->_sections["box"]['step'];
$this->_sections["box"]['first']      = ($this->_sections["box"]['iteration'] == 1);
$this->_sections["box"]['last']       = ($this->_sections["box"]['iteration'] == $this->_sections["box"]['total']);
?>
              <input type="checkbox" name="select_qid[]" value="<?php echo $this->_tpl_vars['qid'][$this->_sections['qid']['index']]; ?>
">&nbsp;
            <?php endfor; endif; ?>

            <?php if (isset($this->_sections["qn"])) unset($this->_sections["qn"]);
$this->_sections["qn"]['name'] = "qn";
$this->_sections["qn"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["qn"]['show'] = (bool)$this->_tpl_vars['question_num'][$this->_sections['qid']['index']];
$this->_sections["qn"]['max'] = $this->_sections["qn"]['loop'];
$this->_sections["qn"]['step'] = 1;
$this->_sections["qn"]['start'] = $this->_sections["qn"]['step'] > 0 ? 0 : $this->_sections["qn"]['loop']-1;
if ($this->_sections["qn"]['show']) {
    $this->_sections["qn"]['total'] = $this->_sections["qn"]['loop'];
    if ($this->_sections["qn"]['total'] == 0)
        $this->_sections["qn"]['show'] = false;
} else
    $this->_sections["qn"]['total'] = 0;
if ($this->_sections["qn"]['show']):

            for ($this->_sections["qn"]['index'] = $this->_sections["qn"]['start'], $this->_sections["qn"]['iteration'] = 1;
                 $this->_sections["qn"]['iteration'] <= $this->_sections["qn"]['total'];
                 $this->_sections["qn"]['index'] += $this->_sections["qn"]['step'], $this->_sections["qn"]['iteration']++):
$this->_sections["qn"]['rownum'] = $this->_sections["qn"]['iteration'];
$this->_sections["qn"]['index_prev'] = $this->_sections["qn"]['index'] - $this->_sections["qn"]['step'];
$this->_sections["qn"]['index_next'] = $this->_sections["qn"]['index'] + $this->_sections["qn"]['step'];
$this->_sections["qn"]['first']      = ($this->_sections["qn"]['iteration'] == 1);
$this->_sections["qn"]['last']       = ($this->_sections["qn"]['iteration'] == $this->_sections["qn"]['total']);
?>
              <?php echo $this->_tpl_vars['question_num'][$this->_sections['qid']['index']]; ?>
.&nbsp;
            <?php endfor; endif; ?>

            <?php if (isset($this->_sections["req"])) unset($this->_sections["req"]);
$this->_sections["req"]['name'] = "req";
$this->_sections["req"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["req"]['show'] = (bool)$this->_tpl_vars['num_required'][$this->_sections['qid']['index']];
$this->_sections["req"]['max'] = $this->_sections["req"]['loop'];
$this->_sections["req"]['step'] = 1;
$this->_sections["req"]['start'] = $this->_sections["req"]['step'] > 0 ? 0 : $this->_sections["req"]['loop']-1;
if ($this->_sections["req"]['show']) {
    $this->_sections["req"]['total'] = $this->_sections["req"]['loop'];
    if ($this->_sections["req"]['total'] == 0)
        $this->_sections["req"]['show'] = false;
} else
    $this->_sections["req"]['total'] = 0;
if ($this->_sections["req"]['show']):

            for ($this->_sections["req"]['index'] = $this->_sections["req"]['start'], $this->_sections["req"]['iteration'] = 1;
                 $this->_sections["req"]['iteration'] <= $this->_sections["req"]['total'];
                 $this->_sections["req"]['index'] += $this->_sections["req"]['step'], $this->_sections["req"]['iteration']++):
$this->_sections["req"]['rownum'] = $this->_sections["req"]['iteration'];
$this->_sections["req"]['index_prev'] = $this->_sections["req"]['index'] - $this->_sections["req"]['step'];
$this->_sections["req"]['index_next'] = $this->_sections["req"]['index'] + $this->_sections["req"]['step'];
$this->_sections["req"]['first']      = ($this->_sections["req"]['iteration'] == 1);
$this->_sections["req"]['last']       = ($this->_sections["req"]['iteration'] == $this->_sections["req"]['total']);
?>
              <?php echo $this->_tpl_vars['survey']['required']; ?>

            <?php endfor; endif; ?>

            <?php echo $this->_tpl_vars['question'][$this->_sections['qid']['index']]; ?>

          </div>

          <div>
            <table border="0" cellpadding="2" cellspacing="2" style="font-size:xx-small;margin-left:25px;margin-top:10px;margin-bottom:10px">
              <?php if (isset($this->_sections["a"])) unset($this->_sections["a"]);
$this->_sections["a"]['name'] = "a";
$this->_sections["a"]['loop'] = is_array($this->_tpl_vars['answer'][$this->_sections['qid']['index']]['value']) ? count($this->_tpl_vars['answer'][$this->_sections['qid']['index']]['value']) : max(0, (int)$this->_tpl_vars['answer'][$this->_sections['qid']['index']]['value']);
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
                <tr>
                  <td><?php echo $this->_tpl_vars['answer'][$this->_sections['qid']['index']]['value'][$this->_sections['a']['index']]; ?>
</td>
                  <td> - </td>
                  <td><?php echo $this->_tpl_vars['count'][$this->_sections['qid']['index']][$this->_sections['a']['index']]; ?>
</td>
                  <td>
                    <?php if (isset($this->_sections["left_right_img"])) unset($this->_sections["left_right_img"]);
$this->_sections["left_right_img"]['name'] = "left_right_img";
$this->_sections["left_right_img"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["left_right_img"]['show'] = (bool)$this->_tpl_vars['show'][$this->_sections['qid']['index']]['left_right_image'][$this->_sections['a']['index']];
$this->_sections["left_right_img"]['max'] = $this->_sections["left_right_img"]['loop'];
$this->_sections["left_right_img"]['step'] = 1;
$this->_sections["left_right_img"]['start'] = $this->_sections["left_right_img"]['step'] > 0 ? 0 : $this->_sections["left_right_img"]['loop']-1;
if ($this->_sections["left_right_img"]['show']) {
    $this->_sections["left_right_img"]['total'] = $this->_sections["left_right_img"]['loop'];
    if ($this->_sections["left_right_img"]['total'] == 0)
        $this->_sections["left_right_img"]['show'] = false;
} else
    $this->_sections["left_right_img"]['total'] = 0;
if ($this->_sections["left_right_img"]['show']):

            for ($this->_sections["left_right_img"]['index'] = $this->_sections["left_right_img"]['start'], $this->_sections["left_right_img"]['iteration'] = 1;
                 $this->_sections["left_right_img"]['iteration'] <= $this->_sections["left_right_img"]['total'];
                 $this->_sections["left_right_img"]['index'] += $this->_sections["left_right_img"]['step'], $this->_sections["left_right_img"]['iteration']++):
$this->_sections["left_right_img"]['rownum'] = $this->_sections["left_right_img"]['iteration'];
$this->_sections["left_right_img"]['index_prev'] = $this->_sections["left_right_img"]['index'] - $this->_sections["left_right_img"]['step'];
$this->_sections["left_right_img"]['index_next'] = $this->_sections["left_right_img"]['index'] + $this->_sections["left_right_img"]['step'];
$this->_sections["left_right_img"]['first']      = ($this->_sections["left_right_img"]['iteration'] == 1);
$this->_sections["left_right_img"]['last']       = ($this->_sections["left_right_img"]['iteration'] == $this->_sections["left_right_img"]['total']);
?>
                      <img src="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/<?php echo $this->_tpl_vars['answer'][$this->_sections['qid']['index']]['left_image'][$this->_sections['a']['index']]; ?>
" alt=""><img src="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/<?php echo $this->_tpl_vars['answer'][$this->_sections['qid']['index']]['image'][$this->_sections['a']['index']]; ?>
" height="<?php echo $this->_tpl_vars['height'][$this->_sections['qid']['index']][$this->_sections['a']['index']]; ?>
" width="<?php echo $this->_tpl_vars['width'][$this->_sections['qid']['index']][$this->_sections['a']['index']]; ?>
" alt="<?php echo $this->_tpl_vars['percent'][$this->_sections['qid']['index']][$this->_sections['a']['index']]; ?>
%"><img src="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/<?php echo $this->_tpl_vars['answer'][$this->_sections['qid']['index']]['right_image'][$this->_sections['a']['index']]; ?>
" alt="">
                    <?php endfor; endif; ?>

                    <?php if (isset($this->_sections["left_img"])) unset($this->_sections["left_img"]);
$this->_sections["left_img"]['name'] = "left_img";
$this->_sections["left_img"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["left_img"]['show'] = (bool)$this->_tpl_vars['show'][$this->_sections['qid']['index']]['left_image'][$this->_sections['a']['index']];
$this->_sections["left_img"]['max'] = $this->_sections["left_img"]['loop'];
$this->_sections["left_img"]['step'] = 1;
$this->_sections["left_img"]['start'] = $this->_sections["left_img"]['step'] > 0 ? 0 : $this->_sections["left_img"]['loop']-1;
if ($this->_sections["left_img"]['show']) {
    $this->_sections["left_img"]['total'] = $this->_sections["left_img"]['loop'];
    if ($this->_sections["left_img"]['total'] == 0)
        $this->_sections["left_img"]['show'] = false;
} else
    $this->_sections["left_img"]['total'] = 0;
if ($this->_sections["left_img"]['show']):

            for ($this->_sections["left_img"]['index'] = $this->_sections["left_img"]['start'], $this->_sections["left_img"]['iteration'] = 1;
                 $this->_sections["left_img"]['iteration'] <= $this->_sections["left_img"]['total'];
                 $this->_sections["left_img"]['index'] += $this->_sections["left_img"]['step'], $this->_sections["left_img"]['iteration']++):
$this->_sections["left_img"]['rownum'] = $this->_sections["left_img"]['iteration'];
$this->_sections["left_img"]['index_prev'] = $this->_sections["left_img"]['index'] - $this->_sections["left_img"]['step'];
$this->_sections["left_img"]['index_next'] = $this->_sections["left_img"]['index'] + $this->_sections["left_img"]['step'];
$this->_sections["left_img"]['first']      = ($this->_sections["left_img"]['iteration'] == 1);
$this->_sections["left_img"]['last']       = ($this->_sections["left_img"]['iteration'] == $this->_sections["left_img"]['total']);
?>
                      <img src="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/<?php echo $this->_tpl_vars['answer'][$this->_sections['qid']['index']]['left_image'][$this->_sections['a']['index']]; ?>
" alt=""><img src="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/<?php echo $this->_tpl_vars['answer'][$this->_sections['qid']['index']]['image'][$this->_sections['a']['index']]; ?>
" height="<?php echo $this->_tpl_vars['height'][$this->_sections['qid']['index']][$this->_sections['a']['index']]; ?>
" width="<?php echo $this->_tpl_vars['width'][$this->_sections['qid']['index']][$this->_sections['a']['index']]; ?>
" alt="<?php echo $this->_tpl_vars['percent'][$this->_sections['qid']['index']][$this->_sections['a']['index']]; ?>
%">
                    <?php endfor; endif; ?>

                    <?php if (isset($this->_sections["right_img"])) unset($this->_sections["right_img"]);
$this->_sections["right_img"]['name'] = "right_img";
$this->_sections["right_img"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["right_img"]['show'] = (bool)$this->_tpl_vars['show'][$this->_sections['qid']['index']]['right_image'][$this->_sections['a']['index']];
$this->_sections["right_img"]['max'] = $this->_sections["right_img"]['loop'];
$this->_sections["right_img"]['step'] = 1;
$this->_sections["right_img"]['start'] = $this->_sections["right_img"]['step'] > 0 ? 0 : $this->_sections["right_img"]['loop']-1;
if ($this->_sections["right_img"]['show']) {
    $this->_sections["right_img"]['total'] = $this->_sections["right_img"]['loop'];
    if ($this->_sections["right_img"]['total'] == 0)
        $this->_sections["right_img"]['show'] = false;
} else
    $this->_sections["right_img"]['total'] = 0;
if ($this->_sections["right_img"]['show']):

            for ($this->_sections["right_img"]['index'] = $this->_sections["right_img"]['start'], $this->_sections["right_img"]['iteration'] = 1;
                 $this->_sections["right_img"]['iteration'] <= $this->_sections["right_img"]['total'];
                 $this->_sections["right_img"]['index'] += $this->_sections["right_img"]['step'], $this->_sections["right_img"]['iteration']++):
$this->_sections["right_img"]['rownum'] = $this->_sections["right_img"]['iteration'];
$this->_sections["right_img"]['index_prev'] = $this->_sections["right_img"]['index'] - $this->_sections["right_img"]['step'];
$this->_sections["right_img"]['index_next'] = $this->_sections["right_img"]['index'] + $this->_sections["right_img"]['step'];
$this->_sections["right_img"]['first']      = ($this->_sections["right_img"]['iteration'] == 1);
$this->_sections["right_img"]['last']       = ($this->_sections["right_img"]['iteration'] == $this->_sections["right_img"]['total']);
?>
                      <img src="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/<?php echo $this->_tpl_vars['answer'][$this->_sections['qid']['index']]['image'][$this->_sections['a']['index']]; ?>
" height="<?php echo $this->_tpl_vars['height'][$this->_sections['qid']['index']][$this->_sections['a']['index']]; ?>
" width="<?php echo $this->_tpl_vars['width'][$this->_sections['qid']['index']][$this->_sections['a']['index']]; ?>
" alt="<?php echo $this->_tpl_vars['percent'][$this->_sections['qid']['index']][$this->_sections['a']['index']]; ?>
%"><img src="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/<?php echo $this->_tpl_vars['answer'][$this->_sections['qid']['index']]['right_image'][$this->_sections['a']['index']]; ?>
" alt="">
                    <?php endfor; endif; ?>

                    <?php if (isset($this->_sections["middle_img"])) unset($this->_sections["middle_img"]);
$this->_sections["middle_img"]['name'] = "middle_img";
$this->_sections["middle_img"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["middle_img"]['show'] = (bool)$this->_tpl_vars['show'][$this->_sections['qid']['index']]['middle_image'][$this->_sections['a']['index']];
$this->_sections["middle_img"]['max'] = $this->_sections["middle_img"]['loop'];
$this->_sections["middle_img"]['step'] = 1;
$this->_sections["middle_img"]['start'] = $this->_sections["middle_img"]['step'] > 0 ? 0 : $this->_sections["middle_img"]['loop']-1;
if ($this->_sections["middle_img"]['show']) {
    $this->_sections["middle_img"]['total'] = $this->_sections["middle_img"]['loop'];
    if ($this->_sections["middle_img"]['total'] == 0)
        $this->_sections["middle_img"]['show'] = false;
} else
    $this->_sections["middle_img"]['total'] = 0;
if ($this->_sections["middle_img"]['show']):

            for ($this->_sections["middle_img"]['index'] = $this->_sections["middle_img"]['start'], $this->_sections["middle_img"]['iteration'] = 1;
                 $this->_sections["middle_img"]['iteration'] <= $this->_sections["middle_img"]['total'];
                 $this->_sections["middle_img"]['index'] += $this->_sections["middle_img"]['step'], $this->_sections["middle_img"]['iteration']++):
$this->_sections["middle_img"]['rownum'] = $this->_sections["middle_img"]['iteration'];
$this->_sections["middle_img"]['index_prev'] = $this->_sections["middle_img"]['index'] - $this->_sections["middle_img"]['step'];
$this->_sections["middle_img"]['index_next'] = $this->_sections["middle_img"]['index'] + $this->_sections["middle_img"]['step'];
$this->_sections["middle_img"]['first']      = ($this->_sections["middle_img"]['iteration'] == 1);
$this->_sections["middle_img"]['last']       = ($this->_sections["middle_img"]['iteration'] == $this->_sections["middle_img"]['total']);
?>
                      <img src="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/<?php echo $this->_tpl_vars['answer'][$this->_sections['qid']['index']]['image'][$this->_sections['a']['index']]; ?>
" height="<?php echo $this->_tpl_vars['height'][$this->_sections['qid']['index']][$this->_sections['a']['index']]; ?>
" width="<?php echo $this->_tpl_vars['width'][$this->_sections['qid']['index']][$this->_sections['a']['index']]; ?>
" alt="<?php echo $this->_tpl_vars['percent'][$this->_sections['qid']['index']][$this->_sections['a']['index']]; ?>
%">
                    <?php endfor; endif; ?>
                    &nbsp;<?php echo $this->_tpl_vars['percent'][$this->_sections['qid']['index']][$this->_sections['a']['index']]; ?>
%
                  </td>
                </tr>
              <?php endfor; endif; ?>

              <?php if (isset($this->_sections["totans"])) unset($this->_sections["totans"]);
$this->_sections["totans"]['name'] = "totans";
$this->_sections["totans"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["totans"]['show'] = (bool)$this->_tpl_vars['show']['numanswers'][$this->_sections['qid']['index']];
$this->_sections["totans"]['max'] = $this->_sections["totans"]['loop'];
$this->_sections["totans"]['step'] = 1;
$this->_sections["totans"]['start'] = $this->_sections["totans"]['step'] > 0 ? 0 : $this->_sections["totans"]['loop']-1;
if ($this->_sections["totans"]['show']) {
    $this->_sections["totans"]['total'] = $this->_sections["totans"]['loop'];
    if ($this->_sections["totans"]['total'] == 0)
        $this->_sections["totans"]['show'] = false;
} else
    $this->_sections["totans"]['total'] = 0;
if ($this->_sections["totans"]['show']):

            for ($this->_sections["totans"]['index'] = $this->_sections["totans"]['start'], $this->_sections["totans"]['iteration'] = 1;
                 $this->_sections["totans"]['iteration'] <= $this->_sections["totans"]['total'];
                 $this->_sections["totans"]['index'] += $this->_sections["totans"]['step'], $this->_sections["totans"]['iteration']++):
$this->_sections["totans"]['rownum'] = $this->_sections["totans"]['iteration'];
$this->_sections["totans"]['index_prev'] = $this->_sections["totans"]['index'] - $this->_sections["totans"]['step'];
$this->_sections["totans"]['index_next'] = $this->_sections["totans"]['index'] + $this->_sections["totans"]['step'];
$this->_sections["totans"]['first']      = ($this->_sections["totans"]['iteration'] == 1);
$this->_sections["totans"]['last']       = ($this->_sections["totans"]['iteration'] == $this->_sections["totans"]['total']);
?>
                <tr>
                  <td><strong>Total Answers</strong></td>
                  <td> - </td>
                  <td colspan="2"><strong><?php echo $this->_tpl_vars['num_answers'][$this->_sections['qid']['index']]; ?>
</strong></td>
                </tr>
              <?php endfor; endif; ?>

              <?php if (isset($this->_sections["t"])) unset($this->_sections["t"]);
$this->_sections["t"]['name'] = "t";
$this->_sections["t"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["t"]['show'] = (bool)$this->_tpl_vars['text'][$this->_sections['qid']['index']];
$this->_sections["t"]['max'] = $this->_sections["t"]['loop'];
$this->_sections["t"]['step'] = 1;
$this->_sections["t"]['start'] = $this->_sections["t"]['step'] > 0 ? 0 : $this->_sections["t"]['loop']-1;
if ($this->_sections["t"]['show']) {
    $this->_sections["t"]['total'] = $this->_sections["t"]['loop'];
    if ($this->_sections["t"]['total'] == 0)
        $this->_sections["t"]['show'] = false;
} else
    $this->_sections["t"]['total'] = 0;
if ($this->_sections["t"]['show']):

            for ($this->_sections["t"]['index'] = $this->_sections["t"]['start'], $this->_sections["t"]['iteration'] = 1;
                 $this->_sections["t"]['iteration'] <= $this->_sections["t"]['total'];
                 $this->_sections["t"]['index'] += $this->_sections["t"]['step'], $this->_sections["t"]['iteration']++):
$this->_sections["t"]['rownum'] = $this->_sections["t"]['iteration'];
$this->_sections["t"]['index_prev'] = $this->_sections["t"]['index'] - $this->_sections["t"]['step'];
$this->_sections["t"]['index_next'] = $this->_sections["t"]['index'] + $this->_sections["t"]['step'];
$this->_sections["t"]['first']      = ($this->_sections["t"]['iteration'] == 1);
$this->_sections["t"]['last']       = ($this->_sections["t"]['iteration'] == $this->_sections["t"]['total']);
?>
                <tr>
                  <td colspan="4">
                    [ <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/results.php?sid=<?php echo $this->_tpl_vars['survey']['sid']; ?>
&qid=<?php echo $this->_tpl_vars['qid'][$this->_sections['qid']['index']]; ?>
&qnum=<?php echo $this->_tpl_vars['question_num'][$this->_sections['qid']['index']]; ?>
">View Answers</a> ]
                  </td>
                </tr>
              <?php endfor; endif; ?>
            </table>
          </div>
        <?php endfor; endif; ?>
      </form>

      <div style="text-align:center">
        [ <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/index.php">Main</a> ]
      </div>

    </td>
  </tr>
</table>