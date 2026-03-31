<?php /* Smarty version 2.3.0, created on 2008-04-07 15:17:26
         compiled from Default/results_text.tpl */ ?>
<form method="GET" action="<?php echo $this->_tpl_vars['conf']['html']; ?>
/results.php">
  <input type="hidden" name="qnum" value="<?php echo $this->_tpl_vars['qnum']; ?>
">
  <input type="hidden" name="sid" value="<?php echo $this->_tpl_vars['sid']; ?>
">
  <input type="hidden" name="qid" value="<?php echo $this->_tpl_vars['qid']; ?>
">

  <table width="70%" align="center" cellpadding="0" cellspacing="0">
    <tr class="grayboxheader">
      <td width="14"><img src="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/box_left.gif" border="0" width="14"></td>
      <td background="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/box_bg.gif">Text Results</td>
      <td width="14"><img src="<?php echo $this->_tpl_vars['conf']['images_html']; ?>
/box_right.gif" border="0" width="14"></td>
    </tr>
  </table>
  <table width="70%" align="center" class="bordered_table">
    <tr>
      <td>

        <div style="text-align:center">
          [ <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/results.php?sid=<?php echo $this->_tpl_vars['sid']; ?>
">All Results</a>
            &nbsp;|&nbsp;
            <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/index.php">Main</a> ]
        </div>

        <div class="whitebox">
          Answers to Question <?php echo $this->_tpl_vars['qnum']; ?>
: <?php echo $this->_tpl_vars['question']; ?>

        </div>

        <div class="indented_cell">
          There are <strong><?php echo $this->_tpl_vars['answer']['num_answers']; ?>
</strong> answers to this question.
        </div>

        <?php if (isset($this->_sections["search_text"])) unset($this->_sections["search_text"]);
$this->_sections["search_text"]['name'] = "search_text";
$this->_sections["search_text"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["search_text"]['show'] = (bool)$this->_tpl_vars['answer']['search_text'];
$this->_sections["search_text"]['max'] = $this->_sections["search_text"]['loop'];
$this->_sections["search_text"]['step'] = 1;
$this->_sections["search_text"]['start'] = $this->_sections["search_text"]['step'] > 0 ? 0 : $this->_sections["search_text"]['loop']-1;
if ($this->_sections["search_text"]['show']) {
    $this->_sections["search_text"]['total'] = $this->_sections["search_text"]['loop'];
    if ($this->_sections["search_text"]['total'] == 0)
        $this->_sections["search_text"]['show'] = false;
} else
    $this->_sections["search_text"]['total'] = 0;
if ($this->_sections["search_text"]['show']):

            for ($this->_sections["search_text"]['index'] = $this->_sections["search_text"]['start'], $this->_sections["search_text"]['iteration'] = 1;
                 $this->_sections["search_text"]['iteration'] <= $this->_sections["search_text"]['total'];
                 $this->_sections["search_text"]['index'] += $this->_sections["search_text"]['step'], $this->_sections["search_text"]['iteration']++):
$this->_sections["search_text"]['rownum'] = $this->_sections["search_text"]['iteration'];
$this->_sections["search_text"]['index_prev'] = $this->_sections["search_text"]['index'] - $this->_sections["search_text"]['step'];
$this->_sections["search_text"]['index_next'] = $this->_sections["search_text"]['index'] + $this->_sections["search_text"]['step'];
$this->_sections["search_text"]['first']      = ($this->_sections["search_text"]['iteration'] == 1);
$this->_sections["search_text"]['last']       = ($this->_sections["search_text"]['iteration'] == $this->_sections["search_text"]['total']);
?>
          <div class="indented_cell">
            Showing only answers matching search for: <strong><?php echo $this->_tpl_vars['answer']['search_text']; ?>
</strong>
          </div>
        <?php endfor; endif; ?>

        <div style="text-align:right">
          <input type="text" name="search" value="<?php echo $this->_tpl_vars['answer']['search_text']; ?>
">
          <input type="submit" name="submit" value="Search">
          <?php if (isset($this->_sections["clear_search"])) unset($this->_sections["clear_search"]);
$this->_sections["clear_search"]['name'] = "clear_search";
$this->_sections["clear_search"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["clear_search"]['show'] = (bool)$this->_tpl_vars['button']['clear'];
$this->_sections["clear_search"]['max'] = $this->_sections["clear_search"]['loop'];
$this->_sections["clear_search"]['step'] = 1;
$this->_sections["clear_search"]['start'] = $this->_sections["clear_search"]['step'] > 0 ? 0 : $this->_sections["clear_search"]['loop']-1;
if ($this->_sections["clear_search"]['show']) {
    $this->_sections["clear_search"]['total'] = $this->_sections["clear_search"]['loop'];
    if ($this->_sections["clear_search"]['total'] == 0)
        $this->_sections["clear_search"]['show'] = false;
} else
    $this->_sections["clear_search"]['total'] = 0;
if ($this->_sections["clear_search"]['show']):

            for ($this->_sections["clear_search"]['index'] = $this->_sections["clear_search"]['start'], $this->_sections["clear_search"]['iteration'] = 1;
                 $this->_sections["clear_search"]['iteration'] <= $this->_sections["clear_search"]['total'];
                 $this->_sections["clear_search"]['index'] += $this->_sections["clear_search"]['step'], $this->_sections["clear_search"]['iteration']++):
$this->_sections["clear_search"]['rownum'] = $this->_sections["clear_search"]['iteration'];
$this->_sections["clear_search"]['index_prev'] = $this->_sections["clear_search"]['index'] - $this->_sections["clear_search"]['step'];
$this->_sections["clear_search"]['index_next'] = $this->_sections["clear_search"]['index'] + $this->_sections["clear_search"]['step'];
$this->_sections["clear_search"]['first']      = ($this->_sections["clear_search"]['iteration'] == 1);
$this->_sections["clear_search"]['last']       = ($this->_sections["clear_search"]['iteration'] == $this->_sections["clear_search"]['total']);
?>
            <input type="submit" name="clear" value="Clear Search Results">
          <?php endfor; endif; ?>
        </div>

        <br />

        <?php if (isset($this->_sections["a"])) unset($this->_sections["a"]);
$this->_sections["a"]['name'] = "a";
$this->_sections["a"]['loop'] = is_array($this->_tpl_vars['answer']['text']) ? count($this->_tpl_vars['answer']['text']) : max(0, (int)$this->_tpl_vars['answer']['text']);
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
          <div class="indented_cell">
            <?php if (isset($this->_sections["del"])) unset($this->_sections["del"]);
$this->_sections["del"]['name'] = "del";
$this->_sections["del"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["del"]['show'] = (bool)$this->_tpl_vars['answer']['delete_access'];
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
              <input type="checkbox" name="delete_rid[]" value="<?php echo $this->_tpl_vars['answer']['rid'][$this->_sections['a']['index']]; ?>
">
            <?php endfor; endif; ?>
            <strong><?php echo $this->_tpl_vars['answer']['num'][$this->_sections['a']['index']]; ?>
.</strong> <?php echo $this->_tpl_vars['answer']['text'][$this->_sections['a']['index']]; ?>

          </div>
        <?php endfor; else: ?>
          <div style="text-align:center">
            <strong>No more answers to this question.</strong>
          </div>
        <?php endif; ?>

        <?php if (isset($this->_sections["del2"])) unset($this->_sections["del2"]);
$this->_sections["del2"]['name'] = "del2";
$this->_sections["del2"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["del2"]['show'] = (bool)$this->_tpl_vars['answer']['delete_access'];
$this->_sections["del2"]['max'] = $this->_sections["del2"]['loop'];
$this->_sections["del2"]['step'] = 1;
$this->_sections["del2"]['start'] = $this->_sections["del2"]['step'] > 0 ? 0 : $this->_sections["del2"]['loop']-1;
if ($this->_sections["del2"]['show']) {
    $this->_sections["del2"]['total'] = $this->_sections["del2"]['loop'];
    if ($this->_sections["del2"]['total'] == 0)
        $this->_sections["del2"]['show'] = false;
} else
    $this->_sections["del2"]['total'] = 0;
if ($this->_sections["del2"]['show']):

            for ($this->_sections["del2"]['index'] = $this->_sections["del2"]['start'], $this->_sections["del2"]['iteration'] = 1;
                 $this->_sections["del2"]['iteration'] <= $this->_sections["del2"]['total'];
                 $this->_sections["del2"]['index'] += $this->_sections["del2"]['step'], $this->_sections["del2"]['iteration']++):
$this->_sections["del2"]['rownum'] = $this->_sections["del2"]['iteration'];
$this->_sections["del2"]['index_prev'] = $this->_sections["del2"]['index'] - $this->_sections["del2"]['step'];
$this->_sections["del2"]['index_next'] = $this->_sections["del2"]['index'] + $this->_sections["del2"]['step'];
$this->_sections["del2"]['first']      = ($this->_sections["del2"]['iteration'] == 1);
$this->_sections["del2"]['last']       = ($this->_sections["del2"]['iteration'] == $this->_sections["del2"]['total']);
?>
          <input type="submit" name="delete" value="Delete Checked Answers">
        <?php endfor; endif; ?>

        <?php if (isset($this->_sections["clear_search"])) unset($this->_sections["clear_search"]);
$this->_sections["clear_search"]['name'] = "clear_search";
$this->_sections["clear_search"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["clear_search"]['show'] = (bool)$this->_tpl_vars['button']['clear'];
$this->_sections["clear_search"]['max'] = $this->_sections["clear_search"]['loop'];
$this->_sections["clear_search"]['step'] = 1;
$this->_sections["clear_search"]['start'] = $this->_sections["clear_search"]['step'] > 0 ? 0 : $this->_sections["clear_search"]['loop']-1;
if ($this->_sections["clear_search"]['show']) {
    $this->_sections["clear_search"]['total'] = $this->_sections["clear_search"]['loop'];
    if ($this->_sections["clear_search"]['total'] == 0)
        $this->_sections["clear_search"]['show'] = false;
} else
    $this->_sections["clear_search"]['total'] = 0;
if ($this->_sections["clear_search"]['show']):

            for ($this->_sections["clear_search"]['index'] = $this->_sections["clear_search"]['start'], $this->_sections["clear_search"]['iteration'] = 1;
                 $this->_sections["clear_search"]['iteration'] <= $this->_sections["clear_search"]['total'];
                 $this->_sections["clear_search"]['index'] += $this->_sections["clear_search"]['step'], $this->_sections["clear_search"]['iteration']++):
$this->_sections["clear_search"]['rownum'] = $this->_sections["clear_search"]['iteration'];
$this->_sections["clear_search"]['index_prev'] = $this->_sections["clear_search"]['index'] - $this->_sections["clear_search"]['step'];
$this->_sections["clear_search"]['index_next'] = $this->_sections["clear_search"]['index'] + $this->_sections["clear_search"]['step'];
$this->_sections["clear_search"]['first']      = ($this->_sections["clear_search"]['iteration'] == 1);
$this->_sections["clear_search"]['last']       = ($this->_sections["clear_search"]['iteration'] == $this->_sections["clear_search"]['total']);
?>
          <input type="submit" name="clear" value="Clear Search Results">
        <?php endfor; endif; ?>

        <?php if (isset($this->_sections["prev"])) unset($this->_sections["prev"]);
$this->_sections["prev"]['name'] = "prev";
$this->_sections["prev"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["prev"]['show'] = (bool)$this->_tpl_vars['button']['previous'];
$this->_sections["prev"]['max'] = $this->_sections["prev"]['loop'];
$this->_sections["prev"]['step'] = 1;
$this->_sections["prev"]['start'] = $this->_sections["prev"]['step'] > 0 ? 0 : $this->_sections["prev"]['loop']-1;
if ($this->_sections["prev"]['show']) {
    $this->_sections["prev"]['total'] = $this->_sections["prev"]['loop'];
    if ($this->_sections["prev"]['total'] == 0)
        $this->_sections["prev"]['show'] = false;
} else
    $this->_sections["prev"]['total'] = 0;
if ($this->_sections["prev"]['show']):

            for ($this->_sections["prev"]['index'] = $this->_sections["prev"]['start'], $this->_sections["prev"]['iteration'] = 1;
                 $this->_sections["prev"]['iteration'] <= $this->_sections["prev"]['total'];
                 $this->_sections["prev"]['index'] += $this->_sections["prev"]['step'], $this->_sections["prev"]['iteration']++):
$this->_sections["prev"]['rownum'] = $this->_sections["prev"]['iteration'];
$this->_sections["prev"]['index_prev'] = $this->_sections["prev"]['index'] - $this->_sections["prev"]['step'];
$this->_sections["prev"]['index_next'] = $this->_sections["prev"]['index'] + $this->_sections["prev"]['step'];
$this->_sections["prev"]['first']      = ($this->_sections["prev"]['iteration'] == 1);
$this->_sections["prev"]['last']       = ($this->_sections["prev"]['iteration'] == $this->_sections["prev"]['total']);
?>
          <input type="submit" name="prev" value="&lt;&lt;&nbsp;Previous Page">&nbsp;
        <?php endfor; endif; ?>

        <?php if (isset($this->_sections["next"])) unset($this->_sections["next"]);
$this->_sections["next"]['name'] = "next";
$this->_sections["next"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["next"]['show'] = (bool)$this->_tpl_vars['button']['next'];
$this->_sections["next"]['max'] = $this->_sections["next"]['loop'];
$this->_sections["next"]['step'] = 1;
$this->_sections["next"]['start'] = $this->_sections["next"]['step'] > 0 ? 0 : $this->_sections["next"]['loop']-1;
if ($this->_sections["next"]['show']) {
    $this->_sections["next"]['total'] = $this->_sections["next"]['loop'];
    if ($this->_sections["next"]['total'] == 0)
        $this->_sections["next"]['show'] = false;
} else
    $this->_sections["next"]['total'] = 0;
if ($this->_sections["next"]['show']):

            for ($this->_sections["next"]['index'] = $this->_sections["next"]['start'], $this->_sections["next"]['iteration'] = 1;
                 $this->_sections["next"]['iteration'] <= $this->_sections["next"]['total'];
                 $this->_sections["next"]['index'] += $this->_sections["next"]['step'], $this->_sections["next"]['iteration']++):
$this->_sections["next"]['rownum'] = $this->_sections["next"]['iteration'];
$this->_sections["next"]['index_prev'] = $this->_sections["next"]['index'] - $this->_sections["next"]['step'];
$this->_sections["next"]['index_next'] = $this->_sections["next"]['index'] + $this->_sections["next"]['step'];
$this->_sections["next"]['first']      = ($this->_sections["next"]['iteration'] == 1);
$this->_sections["next"]['last']       = ($this->_sections["next"]['iteration'] == $this->_sections["next"]['total']);
?>
          <input type="submit" name="next" value="Next Page&nbsp;&gt;&gt;">
        <?php endfor; endif; ?>

        <div style="text-align:center">
          [ <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/results.php?sid=<?php echo $this->_tpl_vars['sid']; ?>
">All Results</a>
            &nbsp;|&nbsp;
            <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/index.php">Main</a> ]
        </div>
      </td>
    </tr>
  </table>
</form>