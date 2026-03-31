<?php /* Smarty version 2.3.0, created on 2008-04-07 11:37:07
         compiled from Default/edit_survey_edit_question.tpl */ ?>
  <form method="POST" action="<?php echo $this->_tpl_vars['conf']['html']; ?>
/edit_survey.php" name="qform">
    <input type="hidden" name="mode" value="<?php echo $this->_tpl_vars['data']['mode']; ?>
">
    <input type="hidden" name="sid" value="<?php echo $this->_tpl_vars['data']['sid']; ?>
">
    <input type="hidden" name="qid" value="<?php echo $this->_tpl_vars['data']['qid']; ?>
">

    <div class="whitebox">
      Question Text
    </div>

    <div class="indented_cell">
      Enter Text of Question. Use the new question form to add page breaks into your form.
      Questions can not be edited into a page break.
      <br />
      <textarea name="question" wrap="physical" cols="50" rows="6"><?php echo $this->_tpl_vars['data']['question_data']['question']; ?>
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
','mywindow','toolbar=no,location=no,directories=no,status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=640,height=480,left=30,top=30');"> Values </a> ]
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

    <?php if (isset($this->_sections["show_edep"])) unset($this->_sections["show_edep"]);
$this->_sections["show_edep"]['name'] = "show_edep";
$this->_sections["show_edep"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["show_edep"]['show'] = (bool)$this->_tpl_vars['data']['edep']['dep_id'];
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
      <div class="whitebox">
        Existing Dependencies:
      </div>

      <div class="indented_text">
        Check the box by the dependency to delete it when
        "Save Changes" is pressed below.

        <br />

        <?php if (isset($this->_sections["edep"])) unset($this->_sections["edep"]);
$this->_sections["edep"]['name'] = "edep";
$this->_sections["edep"]['loop'] = is_array($this->_tpl_vars['data']['edep']['dep_id']) ? count($this->_tpl_vars['data']['edep']['dep_id']) : max(0, (int)$this->_tpl_vars['data']['edep']['dep_id']);
$this->_sections["edep"]['show'] = (bool)"TRUE";
$this->_sections["edep"]['max'] = $this->_sections["edep"]['loop'];
$this->_sections["edep"]['step'] = 1;
$this->_sections["edep"]['start'] = $this->_sections["edep"]['step'] > 0 ? 0 : $this->_sections["edep"]['loop']-1;
if ($this->_sections["edep"]['show']) {
    $this->_sections["edep"]['total'] = $this->_sections["edep"]['loop'];
    if ($this->_sections["edep"]['total'] == 0)
        $this->_sections["edep"]['show'] = false;
} else
    $this->_sections["edep"]['total'] = 0;
if ($this->_sections["edep"]['show']):

            for ($this->_sections["edep"]['index'] = $this->_sections["edep"]['start'], $this->_sections["edep"]['iteration'] = 1;
                 $this->_sections["edep"]['iteration'] <= $this->_sections["edep"]['total'];
                 $this->_sections["edep"]['index'] += $this->_sections["edep"]['step'], $this->_sections["edep"]['iteration']++):
$this->_sections["edep"]['rownum'] = $this->_sections["edep"]['iteration'];
$this->_sections["edep"]['index_prev'] = $this->_sections["edep"]['index'] - $this->_sections["edep"]['step'];
$this->_sections["edep"]['index_next'] = $this->_sections["edep"]['index'] + $this->_sections["edep"]['step'];
$this->_sections["edep"]['first']      = ($this->_sections["edep"]['iteration'] == 1);
$this->_sections["edep"]['last']       = ($this->_sections["edep"]['iteration'] == $this->_sections["edep"]['total']);
?>
          <input type="checkbox" name="edep_id[]" value="<?php echo $this->_tpl_vars['data']['edep']['dep_id'][$this->_sections['edep']['index']]; ?>
">
          <?php echo $this->_tpl_vars['data']['edep']['option'][$this->_sections['edep']['index']]; ?>
 if question <?php echo $this->_tpl_vars['data']['edep']['qnum'][$this->_sections['edep']['index']]; ?>
 is <?php echo $this->_tpl_vars['data']['edep']['value'][$this->_sections['edep']['index']]; ?>

          <br />
        <?php endfor; endif; ?>
      </div>
    <?php endfor; endif; ?>

    <?php if (isset($this->_sections["dep"])) unset($this->_sections["dep"]);
$this->_sections["dep"]['name'] = "dep";
$this->_sections["dep"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["dep"]['show'] = (bool)$this->_tpl_vars['data']['qnum'];
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
      <div class="whitebox">
        New Dependency
      </div>

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
    <?php endfor; endif; ?>

    <div style="text-align:center">
      <br />
      <input type="submit" name="edit_question_submit" value="Save Changes">
      &nbsp;&nbsp;
      <input type="submit" name="edit_cancel" value="Cancel">
    </div>
  </form>