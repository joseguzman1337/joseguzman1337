<?php /* Smarty version 2.3.0, created on 2008-04-07 11:35:15
         compiled from Default/edit_survey_questions.tpl */ ?>
<?php $this->_load_plugins(array(
array('function', 'cycle', 'Default/edit_survey_questions.tpl', 22, false),)); ?>        <table border="1" width="95%" cellspacing="0" cellpadding="0" align="center">
          <tr class="whitebox" style="text-align:center">
            <td width="5%" rowspan="2">Question Number</td>
            <td width="5%" rowspan="2">QID</td>
            <td width="50%" rowspan="2">Question Text</td>
            <td colspan="3">
              Options
              <br>
              <span class="example">(Check box and press button to delete)</span>
            </td>
          </tr>
          <tr class="whitebox" style="text-align:center;">
            <td width="15%">Delete</td>
            <td width="10%">Edit</td>
            <td width="15%">Move</td>
          </tr>

          <?php if (isset($this->_sections["p"])) unset($this->_sections["p"]);
$this->_sections["p"]['name'] = "p";
$this->_sections["p"]['loop'] = is_array($this->_tpl_vars['data']['qid']) ? count($this->_tpl_vars['data']['qid']) : max(0, (int)$this->_tpl_vars['data']['qid']);
$this->_sections["p"]['show'] = true;
$this->_sections["p"]['max'] = $this->_sections["p"]['loop'];
$this->_sections["p"]['step'] = 1;
$this->_sections["p"]['start'] = $this->_sections["p"]['step'] > 0 ? 0 : $this->_sections["p"]['loop']-1;
if ($this->_sections["p"]['show']) {
    $this->_sections["p"]['total'] = $this->_sections["p"]['loop'];
    if ($this->_sections["p"]['total'] == 0)
        $this->_sections["p"]['show'] = false;
} else
    $this->_sections["p"]['total'] = 0;
if ($this->_sections["p"]['show']):

            for ($this->_sections["p"]['index'] = $this->_sections["p"]['start'], $this->_sections["p"]['iteration'] = 1;
                 $this->_sections["p"]['iteration'] <= $this->_sections["p"]['total'];
                 $this->_sections["p"]['index'] += $this->_sections["p"]['step'], $this->_sections["p"]['iteration']++):
$this->_sections["p"]['rownum'] = $this->_sections["p"]['iteration'];
$this->_sections["p"]['index_prev'] = $this->_sections["p"]['index'] - $this->_sections["p"]['step'];
$this->_sections["p"]['index_next'] = $this->_sections["p"]['index'] + $this->_sections["p"]['step'];
$this->_sections["p"]['first']      = ($this->_sections["p"]['iteration'] == 1);
$this->_sections["p"]['last']       = ($this->_sections["p"]['iteration'] == $this->_sections["p"]['total']);
?>
            <form method="GET" action="<?php echo $this->_tpl_vars['conf']['html']; ?>
/edit_survey.php">
            <input type="hidden" name="mode" value="<?php echo $this->_tpl_vars['data']['mode_edit_question']; ?>
">
            <input type="hidden" name="sid" value="<?php echo $this->_tpl_vars['data']['sid']; ?>
">
            <tr bgcolor="<?php $this->_plugins['function']['cycle'][0](array('values' => "#F9F9F9,#FFFFFF"), $this); if($this->_extract) { extract($this->_tpl_vars); $this->_extract=false; } ?>">
              <td style="text-align:center;">
                <?php echo $this->_tpl_vars['data']['qnum'][$this->_sections['p']['index']]; ?>

                <input type="hidden" name="qid" value="<?php echo $this->_tpl_vars['data']['qid'][$this->_sections['p']['index']]; ?>
">
              </td>
              <td style="text-align:center"><?php echo $this->_tpl_vars['data']['qid'][$this->_sections['p']['index']]; ?>
</td>
              <td>
                <div class="indented_cell">
                  <?php echo $this->_tpl_vars['data']['question'][$this->_sections['p']['index']]; ?>

                </div>

                <?php if (isset($this->_sections["show_edep"])) unset($this->_sections["show_edep"]);
$this->_sections["show_edep"]['name'] = "show_edep";
$this->_sections["show_edep"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["show_edep"]['show'] = (bool)$this->_tpl_vars['data']['show_edep'][$this->_sections['p']['index']];
$this->_sections["show_edep"]['max'] = $this->_sections["show_edep"]['loop'];
$this->_sections["show_edep"]['step'] = 1;
$this->_sections["show_edep"]['start'] = $this->_sections["show_edep"]['step'] > 0 ? 0 : $this->_sections["show_edep"]['loop']-1;
if ($this->_sections["show_edep"]['show']) {
    $this->_sections["show_edep"]['total'] = $this->_sections["show_edep"]['loop'];
    if ($this->_sections["show_edep"]['total'] == 0)
        $this->_sections["show_edep"]['show'] = false;
} else
    $this->_sections["show_edep"]['total'] = 0;
if ($this->_sections["show_edep"]['show']):

            for ($this->_sections["show_edep"]['index'] = $this->_sections["show_edep"]['start'], $this->_sections["show_edep"]['iteration'] = 1;
                 $this->_sections["show_edep"]['iteration'] <= $this->_sections["show_edep"]['total'];
                 $this->_sections["show_edep"]['index'] += $this->_sections["show_edep"]['step'], $this->_sections["show_edep"]['iteration']++):
$this->_sections["show_edep"]['rownum'] = $this->_sections["show_edep"]['iteration'];
$this->_sections["show_edep"]['index_prev'] = $this->_sections["show_edep"]['index'] - $this->_sections["show_edep"]['step'];
$this->_sections["show_edep"]['index_next'] = $this->_sections["show_edep"]['index'] + $this->_sections["show_edep"]['step'];
$this->_sections["show_edep"]['first']      = ($this->_sections["show_edep"]['iteration'] == 1);
$this->_sections["show_edep"]['last']       = ($this->_sections["show_edep"]['iteration'] == $this->_sections["show_edep"]['total']);
?>
                  <br />
                  <div class="indented_cell"><strong>Dependencies:</strong></div>
                  <?php if (isset($this->_sections["dep"])) unset($this->_sections["dep"]);
$this->_sections["dep"]['name'] = "dep";
$this->_sections["dep"]['loop'] = is_array($this->_tpl_vars['data']['edep_option'][$this->_sections['p']['index']]) ? count($this->_tpl_vars['data']['edep_option'][$this->_sections['p']['index']]) : max(0, (int)$this->_tpl_vars['data']['edep_option'][$this->_sections['p']['index']]);
$this->_sections["dep"]['show'] = (bool)$this->_tpl_vars['data']['edep_option'][$this->_sections['p']['index']];
$this->_sections["dep"]['max'] = $this->_sections["dep"]['loop'];
$this->_sections["dep"]['step'] = 1;
$this->_sections["dep"]['start'] = $this->_sections["dep"]['step'] > 0 ? 0 : $this->_sections["dep"]['loop']-1;
if ($this->_sections["dep"]['show']) {
    $this->_sections["dep"]['total'] = $this->_sections["dep"]['loop'];
    if ($this->_sections["dep"]['total'] == 0)
        $this->_sections["dep"]['show'] = false;
} else
    $this->_sections["dep"]['total'] = 0;
if ($this->_sections["dep"]['show']):

            for ($this->_sections["dep"]['index'] = $this->_sections["dep"]['start'], $this->_sections["dep"]['iteration'] = 1;
                 $this->_sections["dep"]['iteration'] <= $this->_sections["dep"]['total'];
                 $this->_sections["dep"]['index'] += $this->_sections["dep"]['step'], $this->_sections["dep"]['iteration']++):
$this->_sections["dep"]['rownum'] = $this->_sections["dep"]['iteration'];
$this->_sections["dep"]['index_prev'] = $this->_sections["dep"]['index'] - $this->_sections["dep"]['step'];
$this->_sections["dep"]['index_next'] = $this->_sections["dep"]['index'] + $this->_sections["dep"]['step'];
$this->_sections["dep"]['first']      = ($this->_sections["dep"]['iteration'] == 1);
$this->_sections["dep"]['last']       = ($this->_sections["dep"]['iteration'] == $this->_sections["dep"]['total']);
?>
                    <div style="margin-left:5%;">
                      &bull; <?php echo $this->_tpl_vars['data']['edep_option'][$this->_sections['p']['index']][$this->_sections['dep']['index']]; ?>
 if question <?php echo $this->_tpl_vars['data']['edep_qnum'][$this->_sections['p']['index']][$this->_sections['dep']['index']]; ?>

                      is: <?php echo $this->_tpl_vars['data']['edep_value'][$this->_sections['p']['index']][$this->_sections['dep']['index']]; ?>

                    </div>
                  <?php endfor; endif; ?>
                <?php endfor; endif; ?>
              </td>
                <?php if (isset($this->_sections["options"])) unset($this->_sections["options"]);
$this->_sections["options"]['name'] = "options";
$this->_sections["options"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["options"]['show'] = (bool)$this->_tpl_vars['data']['page_break'][$this->_sections['p']['index']];
$this->_sections["options"]['max'] = $this->_sections["options"]['loop'];
$this->_sections["options"]['step'] = 1;
$this->_sections["options"]['start'] = $this->_sections["options"]['step'] > 0 ? 0 : $this->_sections["options"]['loop']-1;
if ($this->_sections["options"]['show']) {
    $this->_sections["options"]['total'] = $this->_sections["options"]['loop'];
    if ($this->_sections["options"]['total'] == 0)
        $this->_sections["options"]['show'] = false;
} else
    $this->_sections["options"]['total'] = 0;
if ($this->_sections["options"]['show']):

            for ($this->_sections["options"]['index'] = $this->_sections["options"]['start'], $this->_sections["options"]['iteration'] = 1;
                 $this->_sections["options"]['iteration'] <= $this->_sections["options"]['total'];
                 $this->_sections["options"]['index'] += $this->_sections["options"]['step'], $this->_sections["options"]['iteration']++):
$this->_sections["options"]['rownum'] = $this->_sections["options"]['iteration'];
$this->_sections["options"]['index_prev'] = $this->_sections["options"]['index'] - $this->_sections["options"]['step'];
$this->_sections["options"]['index_next'] = $this->_sections["options"]['index'] + $this->_sections["options"]['step'];
$this->_sections["options"]['first']      = ($this->_sections["options"]['iteration'] == 1);
$this->_sections["options"]['last']       = ($this->_sections["options"]['iteration'] == $this->_sections["options"]['total']);
?>
                  <td style="text-align:center;" colspan="3">
                    <input type="hidden" name="page_break" value="1">
                    <input type="submit" name="delete_question" value="Delete">
                  </td>
                <?php endfor; else: ?>
                  <td style="text-align:center;" width="15%">
                    <input type="checkbox" name="del_qid" value="<?php echo $this->_tpl_vars['data']['qid'][$this->_sections['p']['index']]; ?>
">
                    <input type="submit" name="delete_question" value="Delete">
                  </td>
                  <td style="text-align:center;" width="10%">
                    <input type="submit" name="edit_question" value="Edit">
                  </td>
                  <td style="text-align:center;" width="15%">
                    <input type="submit" name="move_up" value="&nbsp;&uarr;&nbsp;">
                    <input type="submit" name="move_down" value="&nbsp;&darr;&nbsp;">
                  </td>
                <?php endif; ?>
            </tr>
            </form>
          <?php endfor; else: ?>
            <tr>
              <td colspan="5">No questions</td>
            </tr>
          <?php endif; ?>
        </table>

        <br>
        <form method="POST" action="<?php echo $this->_tpl_vars['conf']['html']; ?>
/edit_survey.php" name="qform">
        <input type="hidden" name="mode" value="<?php echo $this->_tpl_vars['data']['mode_new_question']; ?>
">
        <input type="hidden" name="sid" value="<?php echo $this->_tpl_vars['data']['sid']; ?>
">

        <div class="whitebox">
          Add A New Question  <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/docs/index.html#new_question">[?]</a>
        </div>

        <script language="javascript">
        function page_break()
        { document.qform.question.value = '<?php echo $this->_tpl_vars['conf']['page_break']; ?>
'; }
        </script>

        <div class="indented_cell">
          Enter Text of Question. Enter <a href="javascript:page_break();"><?php echo $this->_tpl_vars['conf']['page_break']; ?>
</a> as the text of the question
          in order to create a page break in your survey (answer type will be ignored).
          <br />
          <textarea name="question" wrap="physical" cols="50" rows="6"><?php echo $this->_tpl_vars['question']; ?>
</textarea>
        </div>

        <div class="whitebox">
          Answer Type
        </div>

        <div class="indented_cell">
          <select name="answer" size="1">
            <?php if (isset($this->_sections["answer"])) unset($this->_sections["answer"]);
$this->_sections["answer"]['name'] = "answer";
$this->_sections["answer"]['loop'] = is_array($this->_tpl_vars['data']['answer']) ? count($this->_tpl_vars['data']['answer']) : max(0, (int)$this->_tpl_vars['data']['answer']);
$this->_sections["answer"]['show'] = (bool)"TRUE";
$this->_sections["answer"]['max'] = $this->_sections["answer"]['loop'];
$this->_sections["answer"]['step'] = 1;
$this->_sections["answer"]['start'] = $this->_sections["answer"]['step'] > 0 ? 0 : $this->_sections["answer"]['loop']-1;
if ($this->_sections["answer"]['show']) {
    $this->_sections["answer"]['total'] = $this->_sections["answer"]['loop'];
    if ($this->_sections["answer"]['total'] == 0)
        $this->_sections["answer"]['show'] = false;
} else
    $this->_sections["answer"]['total'] = 0;
if ($this->_sections["answer"]['show']):

            for ($this->_sections["answer"]['index'] = $this->_sections["answer"]['start'], $this->_sections["answer"]['iteration'] = 1;
                 $this->_sections["answer"]['iteration'] <= $this->_sections["answer"]['total'];
                 $this->_sections["answer"]['index'] += $this->_sections["answer"]['step'], $this->_sections["answer"]['iteration']++):
$this->_sections["answer"]['rownum'] = $this->_sections["answer"]['iteration'];
$this->_sections["answer"]['index_prev'] = $this->_sections["answer"]['index'] - $this->_sections["answer"]['step'];
$this->_sections["answer"]['index_next'] = $this->_sections["answer"]['index'] + $this->_sections["answer"]['step'];
$this->_sections["answer"]['first']      = ($this->_sections["answer"]['iteration'] == 1);
$this->_sections["answer"]['last']       = ($this->_sections["answer"]['iteration'] == $this->_sections["answer"]['total']);
?>
              <option value="<?php echo $this->_tpl_vars['data']['answer'][$this->_sections['answer']['index']]['aid']; ?>
"<?php echo $this->_tpl_vars['data']['answer'][$this->_sections['answer']['index']]['selected']; ?>
><?php echo $this->_tpl_vars['data']['answer'][$this->_sections['answer']['index']]['name']; ?>
</option>
            <?php endfor; endif; ?>
          </select>
          &nbsp;
          [ <a href="#show_answers" onclick="window.open('display_answers.php?sid=<?php echo $this->_tpl_vars['data']['sid']; ?>
','mywindow','toolbar=no,location=no,directories=no,status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=640,height=480,left=30,top=30');">Values</a> ]
        </div>

        <div class="whitebox">
          Number of Answer Blocks
        </div>

        <div class="indented_cell">
          <select name="num_answers" size="1">
            <?php if (isset($this->_sections["num_answers"])) unset($this->_sections["num_answers"]);
$this->_sections["num_answers"]['name'] = "num_answers";
$this->_sections["num_answers"]['loop'] = is_array($this->_tpl_vars['data']['num_answers']) ? count($this->_tpl_vars['data']['num_answers']) : max(0, (int)$this->_tpl_vars['data']['num_answers']);
$this->_sections["num_answers"]['show'] = (bool)"TRUE";
$this->_sections["num_answers"]['max'] = $this->_sections["num_answers"]['loop'];
$this->_sections["num_answers"]['step'] = 1;
$this->_sections["num_answers"]['start'] = $this->_sections["num_answers"]['step'] > 0 ? 0 : $this->_sections["num_answers"]['loop']-1;
if ($this->_sections["num_answers"]['show']) {
    $this->_sections["num_answers"]['total'] = $this->_sections["num_answers"]['loop'];
    if ($this->_sections["num_answers"]['total'] == 0)
        $this->_sections["num_answers"]['show'] = false;
} else
    $this->_sections["num_answers"]['total'] = 0;
if ($this->_sections["num_answers"]['show']):

            for ($this->_sections["num_answers"]['index'] = $this->_sections["num_answers"]['start'], $this->_sections["num_answers"]['iteration'] = 1;
                 $this->_sections["num_answers"]['iteration'] <= $this->_sections["num_answers"]['total'];
                 $this->_sections["num_answers"]['index'] += $this->_sections["num_answers"]['step'], $this->_sections["num_answers"]['iteration']++):
$this->_sections["num_answers"]['rownum'] = $this->_sections["num_answers"]['iteration'];
$this->_sections["num_answers"]['index_prev'] = $this->_sections["num_answers"]['index'] - $this->_sections["num_answers"]['step'];
$this->_sections["num_answers"]['index_next'] = $this->_sections["num_answers"]['index'] + $this->_sections["num_answers"]['step'];
$this->_sections["num_answers"]['first']      = ($this->_sections["num_answers"]['iteration'] == 1);
$this->_sections["num_answers"]['last']       = ($this->_sections["num_answers"]['iteration'] == $this->_sections["num_answers"]['total']);
?>
              <option value="<?php echo $this->_tpl_vars['data']['num_answers'][$this->_sections['num_answers']['index']]; ?>
"<?php echo $this->_tpl_vars['data']['num_answers_selected'][$this->_sections['num_answers']['index']]; ?>
><?php echo $this->_tpl_vars['data']['num_answers'][$this->_sections['num_answers']['index']]; ?>
</option>
            <?php endfor; endif; ?>
          </select>
        </div>

        <div class="whitebox">
          Required Answers
        </div>

        <div class="indented_cell">
          <select name="num_required" size="1">
            <?php if (isset($this->_sections["num_required"])) unset($this->_sections["num_required"]);
$this->_sections["num_required"]['name'] = "num_required";
$this->_sections["num_required"]['loop'] = is_array($this->_tpl_vars['data']['num_required']) ? count($this->_tpl_vars['data']['num_required']) : max(0, (int)$this->_tpl_vars['data']['num_required']);
$this->_sections["num_required"]['show'] = (bool)"TRUE";
$this->_sections["num_required"]['max'] = $this->_sections["num_required"]['loop'];
$this->_sections["num_required"]['step'] = 1;
$this->_sections["num_required"]['start'] = $this->_sections["num_required"]['step'] > 0 ? 0 : $this->_sections["num_required"]['loop']-1;
if ($this->_sections["num_required"]['show']) {
    $this->_sections["num_required"]['total'] = $this->_sections["num_required"]['loop'];
    if ($this->_sections["num_required"]['total'] == 0)
        $this->_sections["num_required"]['show'] = false;
} else
    $this->_sections["num_required"]['total'] = 0;
if ($this->_sections["num_required"]['show']):

            for ($this->_sections["num_required"]['index'] = $this->_sections["num_required"]['start'], $this->_sections["num_required"]['iteration'] = 1;
                 $this->_sections["num_required"]['iteration'] <= $this->_sections["num_required"]['total'];
                 $this->_sections["num_required"]['index'] += $this->_sections["num_required"]['step'], $this->_sections["num_required"]['iteration']++):
$this->_sections["num_required"]['rownum'] = $this->_sections["num_required"]['iteration'];
$this->_sections["num_required"]['index_prev'] = $this->_sections["num_required"]['index'] - $this->_sections["num_required"]['step'];
$this->_sections["num_required"]['index_next'] = $this->_sections["num_required"]['index'] + $this->_sections["num_required"]['step'];
$this->_sections["num_required"]['first']      = ($this->_sections["num_required"]['iteration'] == 1);
$this->_sections["num_required"]['last']       = ($this->_sections["num_required"]['iteration'] == $this->_sections["num_required"]['total']);
?>
              <option value="<?php echo $this->_tpl_vars['data']['num_required'][$this->_sections['num_required']['index']]; ?>
"<?php echo $this->_tpl_vars['data']['num_required_selected'][$this->_sections['num_required']['index']]; ?>
><?php echo $this->_tpl_vars['data']['num_required'][$this->_sections['num_required']['index']]; ?>
</option>
            <?php endfor; endif; ?>
          </select>
        </div>

        <div class="whitebox">
          Insert After Number
        </div>

        <div class="indented_cell">
          <select name="insert_after" size="1">
            <option value="0-0">First</option>
            <?php if (isset($this->_sections["qnum"])) unset($this->_sections["qnum"]);
$this->_sections["qnum"]['name'] = "qnum";
$this->_sections["qnum"]['loop'] = is_array($this->_tpl_vars['data']['qnum2']) ? count($this->_tpl_vars['data']['qnum2']) : max(0, (int)$this->_tpl_vars['data']['qnum2']);
$this->_sections["qnum"]['show'] = (bool)"TRUE";
$this->_sections["qnum"]['max'] = $this->_sections["qnum"]['loop'];
$this->_sections["qnum"]['step'] = 1;
$this->_sections["qnum"]['start'] = $this->_sections["qnum"]['step'] > 0 ? 0 : $this->_sections["qnum"]['loop']-1;
if ($this->_sections["qnum"]['show']) {
    $this->_sections["qnum"]['total'] = $this->_sections["qnum"]['loop'];
    if ($this->_sections["qnum"]['total'] == 0)
        $this->_sections["qnum"]['show'] = false;
} else
    $this->_sections["qnum"]['total'] = 0;
if ($this->_sections["qnum"]['show']):

            for ($this->_sections["qnum"]['index'] = $this->_sections["qnum"]['start'], $this->_sections["qnum"]['iteration'] = 1;
                 $this->_sections["qnum"]['iteration'] <= $this->_sections["qnum"]['total'];
                 $this->_sections["qnum"]['index'] += $this->_sections["qnum"]['step'], $this->_sections["qnum"]['iteration']++):
$this->_sections["qnum"]['rownum'] = $this->_sections["qnum"]['iteration'];
$this->_sections["qnum"]['index_prev'] = $this->_sections["qnum"]['index'] - $this->_sections["qnum"]['step'];
$this->_sections["qnum"]['index_next'] = $this->_sections["qnum"]['index'] + $this->_sections["qnum"]['step'];
$this->_sections["qnum"]['first']      = ($this->_sections["qnum"]['iteration'] == 1);
$this->_sections["qnum"]['last']       = ($this->_sections["qnum"]['iteration'] == $this->_sections["qnum"]['total']);
?>
              <option value="<?php echo $this->_tpl_vars['data']['page_oid'][$this->_sections['qnum']['index']]; ?>
"<?php echo $this->_tpl_vars['data']['qnum2_selected'][$this->_sections['qnum']['index']]; ?>
><?php echo $this->_tpl_vars['data']['qnum2'][$this->_sections['qnum']['index']]; ?>
</option>
            <?php endfor; endif; ?>
          </select>
        </div>

        <div class="whitebox">
          Orientation
        </div>

        <div class="indented_cell">
          <select name="orientation" size="1">
            <?php if (isset($this->_sections["orient"])) unset($this->_sections["orient"]);
$this->_sections["orient"]['name'] = "orient";
$this->_sections["orient"]['loop'] = is_array($this->_tpl_vars['conf']['orientation']) ? count($this->_tpl_vars['conf']['orientation']) : max(0, (int)$this->_tpl_vars['conf']['orientation']);
$this->_sections["orient"]['show'] = (bool)"TRUE";
$this->_sections["orient"]['max'] = $this->_sections["orient"]['loop'];
$this->_sections["orient"]['step'] = 1;
$this->_sections["orient"]['start'] = $this->_sections["orient"]['step'] > 0 ? 0 : $this->_sections["orient"]['loop']-1;
if ($this->_sections["orient"]['show']) {
    $this->_sections["orient"]['total'] = $this->_sections["orient"]['loop'];
    if ($this->_sections["orient"]['total'] == 0)
        $this->_sections["orient"]['show'] = false;
} else
    $this->_sections["orient"]['total'] = 0;
if ($this->_sections["orient"]['show']):

            for ($this->_sections["orient"]['index'] = $this->_sections["orient"]['start'], $this->_sections["orient"]['iteration'] = 1;
                 $this->_sections["orient"]['iteration'] <= $this->_sections["orient"]['total'];
                 $this->_sections["orient"]['index'] += $this->_sections["orient"]['step'], $this->_sections["orient"]['iteration']++):
$this->_sections["orient"]['rownum'] = $this->_sections["orient"]['iteration'];
$this->_sections["orient"]['index_prev'] = $this->_sections["orient"]['index'] - $this->_sections["orient"]['step'];
$this->_sections["orient"]['index_next'] = $this->_sections["orient"]['index'] + $this->_sections["orient"]['step'];
$this->_sections["orient"]['first']      = ($this->_sections["orient"]['iteration'] == 1);
$this->_sections["orient"]['last']       = ($this->_sections["orient"]['iteration'] == $this->_sections["orient"]['total']);
?>
              <option value="<?php echo $this->_tpl_vars['conf']['orientation'][$this->_sections['orient']['index']]; ?>
"<?php echo $this->_tpl_vars['data']['orientation']['selected'][$this->_sections['orient']['index']]; ?>
><?php echo $this->_tpl_vars['conf']['orientation'][$this->_sections['orient']['index']]; ?>
</option>
            <?php endfor; endif; ?>
          </select>
        </div>

        <?php if (isset($this->_sections["dependencies"])) unset($this->_sections["dependencies"]);
$this->_sections["dependencies"]['name'] = "dependencies";
$this->_sections["dependencies"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["dependencies"]['show'] = (bool)$this->_tpl_vars['data']['show']['dep'];
$this->_sections["dependencies"]['max'] = $this->_sections["dependencies"]['loop'];
$this->_sections["dependencies"]['step'] = 1;
$this->_sections["dependencies"]['start'] = $this->_sections["dependencies"]['step'] > 0 ? 0 : $this->_sections["dependencies"]['loop']-1;
if ($this->_sections["dependencies"]['show']) {
    $this->_sections["dependencies"]['total'] = $this->_sections["dependencies"]['loop'];
    if ($this->_sections["dependencies"]['total'] == 0)
        $this->_sections["dependencies"]['show'] = false;
} else
    $this->_sections["dependencies"]['total'] = 0;
if ($this->_sections["dependencies"]['show']):

            for ($this->_sections["dependencies"]['index'] = $this->_sections["dependencies"]['start'], $this->_sections["dependencies"]['iteration'] = 1;
                 $this->_sections["dependencies"]['iteration'] <= $this->_sections["dependencies"]['total'];
                 $this->_sections["dependencies"]['index'] += $this->_sections["dependencies"]['step'], $this->_sections["dependencies"]['iteration']++):
$this->_sections["dependencies"]['rownum'] = $this->_sections["dependencies"]['iteration'];
$this->_sections["dependencies"]['index_prev'] = $this->_sections["dependencies"]['index'] - $this->_sections["dependencies"]['step'];
$this->_sections["dependencies"]['index_next'] = $this->_sections["dependencies"]['index'] + $this->_sections["dependencies"]['step'];
$this->_sections["dependencies"]['first']      = ($this->_sections["dependencies"]['iteration'] == 1);
$this->_sections["dependencies"]['last']       = ($this->_sections["dependencies"]['iteration'] == $this->_sections["dependencies"]['total']);
?>

          <div class="whitebox">
           Dependencies <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/docs/index.html#dependencies">[?]</a>
          </div>

          <div class="indented_cell">
            <span class="example">
              Dependencies are optional. If no dependencies are chosen, the question will be displayed to everyone
              who takes the survey and be requried based upon the choices above. You can optionally choose to <strong>Hide</strong> or
              <strong>Require</strong> a question based upon answers to previous questions. You can add up to three dependencies
              per question. Dependencies can only be based upon questions that are asked <strong>before</strong> the question that is
              currently being added. You can select multiple answers to base the dependency on by holding down the control key while
              selecting answer values. Additional dependencies can be added or existing dependencies deleted by clicking on the Edit
              button above after the question has been added to the survey.
            </span>
            <br />

            <?php if (isset($this->_sections["dep"])) unset($this->_sections["dep"]);
$this->_sections["dep"]['name'] = "dep";
$this->_sections["dep"]['loop'] = is_array("3") ? count("3") : max(0, (int)"3");
$this->_sections["dep"]['show'] = (bool)"TRUE";
$this->_sections["dep"]['max'] = $this->_sections["dep"]['loop'];
$this->_sections["dep"]['step'] = 1;
$this->_sections["dep"]['start'] = $this->_sections["dep"]['step'] > 0 ? 0 : $this->_sections["dep"]['loop']-1;
if ($this->_sections["dep"]['show']) {
    $this->_sections["dep"]['total'] = $this->_sections["dep"]['loop'];
    if ($this->_sections["dep"]['total'] == 0)
        $this->_sections["dep"]['show'] = false;
} else
    $this->_sections["dep"]['total'] = 0;
if ($this->_sections["dep"]['show']):

            for ($this->_sections["dep"]['index'] = $this->_sections["dep"]['start'], $this->_sections["dep"]['iteration'] = 1;
                 $this->_sections["dep"]['iteration'] <= $this->_sections["dep"]['total'];
                 $this->_sections["dep"]['index'] += $this->_sections["dep"]['step'], $this->_sections["dep"]['iteration']++):
$this->_sections["dep"]['rownum'] = $this->_sections["dep"]['iteration'];
$this->_sections["dep"]['index_prev'] = $this->_sections["dep"]['index'] - $this->_sections["dep"]['step'];
$this->_sections["dep"]['index_next'] = $this->_sections["dep"]['index'] + $this->_sections["dep"]['step'];
$this->_sections["dep"]['first']      = ($this->_sections["dep"]['iteration'] == 1);
$this->_sections["dep"]['last']       = ($this->_sections["dep"]['iteration'] == $this->_sections["dep"]['total']);
?>
              (<?php echo $this->_sections['dep']['iteration']; ?>
)
              &nbsp;&nbsp;&nbsp;
              <select name="option[<?php echo $this->_sections['dep']['iteration']; ?>
]" size="1">
                <option value=""></option>
                <?php if (isset($this->_sections["dep_mode"])) unset($this->_sections["dep_mode"]);
$this->_sections["dep_mode"]['name'] = "dep_mode";
$this->_sections["dep_mode"]['loop'] = is_array($this->_tpl_vars['conf']['dependency_modes']) ? count($this->_tpl_vars['conf']['dependency_modes']) : max(0, (int)$this->_tpl_vars['conf']['dependency_modes']);
$this->_sections["dep_mode"]['show'] = (bool)"TRUE";
$this->_sections["dep_mode"]['max'] = $this->_sections["dep_mode"]['loop'];
$this->_sections["dep_mode"]['step'] = 1;
$this->_sections["dep_mode"]['start'] = $this->_sections["dep_mode"]['step'] > 0 ? 0 : $this->_sections["dep_mode"]['loop']-1;
if ($this->_sections["dep_mode"]['show']) {
    $this->_sections["dep_mode"]['total'] = $this->_sections["dep_mode"]['loop'];
    if ($this->_sections["dep_mode"]['total'] == 0)
        $this->_sections["dep_mode"]['show'] = false;
} else
    $this->_sections["dep_mode"]['total'] = 0;
if ($this->_sections["dep_mode"]['show']):

            for ($this->_sections["dep_mode"]['index'] = $this->_sections["dep_mode"]['start'], $this->_sections["dep_mode"]['iteration'] = 1;
                 $this->_sections["dep_mode"]['iteration'] <= $this->_sections["dep_mode"]['total'];
                 $this->_sections["dep_mode"]['index'] += $this->_sections["dep_mode"]['step'], $this->_sections["dep_mode"]['iteration']++):
$this->_sections["dep_mode"]['rownum'] = $this->_sections["dep_mode"]['iteration'];
$this->_sections["dep_mode"]['index_prev'] = $this->_sections["dep_mode"]['index'] - $this->_sections["dep_mode"]['step'];
$this->_sections["dep_mode"]['index_next'] = $this->_sections["dep_mode"]['index'] + $this->_sections["dep_mode"]['step'];
$this->_sections["dep_mode"]['first']      = ($this->_sections["dep_mode"]['iteration'] == 1);
$this->_sections["dep_mode"]['last']       = ($this->_sections["dep_mode"]['iteration'] == $this->_sections["dep_mode"]['total']);
?>
                  <option value="<?php echo $this->_tpl_vars['conf']['dependency_modes'][$this->_sections['dep_mode']['index']]; ?>
"><?php echo $this->_tpl_vars['conf']['dependency_modes'][$this->_sections['dep_mode']['index']]; ?>
</option>
                <?php endfor; endif; ?>
              </select>
              if question
              <select name="dep_qid[<?php echo $this->_sections['dep']['iteration']; ?>
]" onchange="populate(<?php echo $this->_sections['dep']['iteration']; ?>
);">
                <option value=""></option>
                <?php if (isset($this->_sections["dep_qid"])) unset($this->_sections["dep_qid"]);
$this->_sections["dep_qid"]['name'] = "dep_qid";
$this->_sections["dep_qid"]['loop'] = is_array($this->_tpl_vars['data']['dep_qid']) ? count($this->_tpl_vars['data']['dep_qid']) : max(0, (int)$this->_tpl_vars['data']['dep_qid']);
$this->_sections["dep_qid"]['show'] = (bool)"TRUE";
$this->_sections["dep_qid"]['max'] = $this->_sections["dep_qid"]['loop'];
$this->_sections["dep_qid"]['step'] = 1;
$this->_sections["dep_qid"]['start'] = $this->_sections["dep_qid"]['step'] > 0 ? 0 : $this->_sections["dep_qid"]['loop']-1;
if ($this->_sections["dep_qid"]['show']) {
    $this->_sections["dep_qid"]['total'] = $this->_sections["dep_qid"]['loop'];
    if ($this->_sections["dep_qid"]['total'] == 0)
        $this->_sections["dep_qid"]['show'] = false;
} else
    $this->_sections["dep_qid"]['total'] = 0;
if ($this->_sections["dep_qid"]['show']):

            for ($this->_sections["dep_qid"]['index'] = $this->_sections["dep_qid"]['start'], $this->_sections["dep_qid"]['iteration'] = 1;
                 $this->_sections["dep_qid"]['iteration'] <= $this->_sections["dep_qid"]['total'];
                 $this->_sections["dep_qid"]['index'] += $this->_sections["dep_qid"]['step'], $this->_sections["dep_qid"]['iteration']++):
$this->_sections["dep_qid"]['rownum'] = $this->_sections["dep_qid"]['iteration'];
$this->_sections["dep_qid"]['index_prev'] = $this->_sections["dep_qid"]['index'] - $this->_sections["dep_qid"]['step'];
$this->_sections["dep_qid"]['index_next'] = $this->_sections["dep_qid"]['index'] + $this->_sections["dep_qid"]['step'];
$this->_sections["dep_qid"]['first']      = ($this->_sections["dep_qid"]['iteration'] == 1);
$this->_sections["dep_qid"]['last']       = ($this->_sections["dep_qid"]['iteration'] == $this->_sections["dep_qid"]['total']);
?>
                  <option value="<?php echo $this->_tpl_vars['data']['dep_qid'][$this->_sections['dep_qid']['index']]; ?>
"><?php echo $this->_tpl_vars['data']['dep_qnum'][$this->_sections['dep_qid']['index']]; ?>
</option>
                <?php endfor; endif; ?>
              </select>
              is answered with
              <select name="dep_aid[<?php echo $this->_sections['dep']['iteration']; ?>
][]" size="5" MULTIPLE>
                <option value="">>>Choose question number to view answers<<</option>
              </select>
              <br />
            <?php endfor; endif; ?>
          </div>
        <?php endfor; endif; ?>

        <script language="javascript">

        Answers = new Array;
        Values = new Array;
        Num_Answers = new Array;
        var Original_Length = 1;

        //Javascript from survey.class.php
        <?php echo $this->_tpl_vars['data']['js']; ?>


        var num = 0;

        function populate(num)
        {
            for(x=0;x<Original_Length;x++)
            { document.qform['dep_aid['+num+'][]'].options[0] = null; }

            qid = document.qform['dep_qid['+num+']'].value;

            for(x=0;x<Num_Answers[qid];x++)
            { document.qform['dep_aid['+num+'][]'].options[x] = new Option(Values[qid+','+x],Answers[qid+','+x]); }

            Original_Length = Num_Answers[qid];
        }

      </script>


        <br />

        <div style="text-align:center">
          <input type="submit" name="add_new_question" value="Add New Question">
        </div>

      </form>