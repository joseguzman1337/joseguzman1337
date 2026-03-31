<?php /* Smarty version 2.3.0, created on 2008-04-07 11:56:41
         compiled from Default/edit_survey_edit_at.tpl */ ?>
<?php $this->_load_plugins(array(
array('function', 'cycle', 'Default/edit_survey_edit_at.tpl', 125, false),)); ?>      <form method="POST" action="<?php echo $this->_tpl_vars['conf']['html']; ?>
/edit_answer.php">
        <input type="hidden" name="aid" value="<?php echo $this->_tpl_vars['answer']['aid']; ?>
">
        <input type="hidden" name="sid" value="<?php echo $this->_tpl_vars['answer']['sid']; ?>
">

        
          <?php if (isset($this->_sections["success"])) unset($this->_sections["success"]);
$this->_sections["success"]['name'] = "success";
$this->_sections["success"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["success"]['show'] = (bool)$this->_tpl_vars['show']['success'];
$this->_sections["success"]['max'] = $this->_sections["success"]['loop'];
$this->_sections["success"]['step'] = 1;
$this->_sections["success"]['start'] = $this->_sections["success"]['step'] > 0 ? 0 : $this->_sections["success"]['loop']-1;
if ($this->_sections["success"]['show']) {
    $this->_sections["success"]['total'] = $this->_sections["success"]['loop'];
    if ($this->_sections["success"]['total'] == 0)
        $this->_sections["success"]['show'] = false;
} else
    $this->_sections["success"]['total'] = 0;
if ($this->_sections["success"]['show']):

            for ($this->_sections["success"]['index'] = $this->_sections["success"]['start'], $this->_sections["success"]['iteration'] = 1;
                 $this->_sections["success"]['iteration'] <= $this->_sections["success"]['total'];
                 $this->_sections["success"]['index'] += $this->_sections["success"]['step'], $this->_sections["success"]['iteration']++):
$this->_sections["success"]['rownum'] = $this->_sections["success"]['iteration'];
$this->_sections["success"]['index_prev'] = $this->_sections["success"]['index'] - $this->_sections["success"]['step'];
$this->_sections["success"]['index_next'] = $this->_sections["success"]['index'] + $this->_sections["success"]['step'];
$this->_sections["success"]['first']      = ($this->_sections["success"]['iteration'] == 1);
$this->_sections["success"]['last']       = ($this->_sections["success"]['iteration'] == $this->_sections["success"]['total']);
?>
            <div class="message">
              Answer successfully edited.
            </div>
          <?php endfor; endif; ?>
        

        <?php if (isset($this->_sections["error"])) unset($this->_sections["error"]);
$this->_sections["error"]['name'] = "error";
$this->_sections["error"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["error"]['show'] = (bool)$this->_tpl_vars['show']['error'];
$this->_sections["error"]['max'] = $this->_sections["error"]['loop'];
$this->_sections["error"]['step'] = 1;
$this->_sections["error"]['start'] = $this->_sections["error"]['step'] > 0 ? 0 : $this->_sections["error"]['loop']-1;
if ($this->_sections["error"]['show']) {
    $this->_sections["error"]['total'] = $this->_sections["error"]['loop'];
    if ($this->_sections["error"]['total'] == 0)
        $this->_sections["error"]['show'] = false;
} else
    $this->_sections["error"]['total'] = 0;
if ($this->_sections["error"]['show']):

            for ($this->_sections["error"]['index'] = $this->_sections["error"]['start'], $this->_sections["error"]['iteration'] = 1;
                 $this->_sections["error"]['iteration'] <= $this->_sections["error"]['total'];
                 $this->_sections["error"]['index'] += $this->_sections["error"]['step'], $this->_sections["error"]['iteration']++):
$this->_sections["error"]['rownum'] = $this->_sections["error"]['iteration'];
$this->_sections["error"]['index_prev'] = $this->_sections["error"]['index'] - $this->_sections["error"]['step'];
$this->_sections["error"]['index_next'] = $this->_sections["error"]['index'] + $this->_sections["error"]['step'];
$this->_sections["error"]['first']      = ($this->_sections["error"]['iteration'] == 1);
$this->_sections["error"]['last']       = ($this->_sections["error"]['iteration'] == $this->_sections["error"]['total']);
?>
          <div class="error"><?php echo $this->_tpl_vars['show']['error']; ?>
</div>
        <?php endfor; endif; ?>


        
          <?php if (isset($this->_sections["warning"])) unset($this->_sections["warning"]);
$this->_sections["warning"]['name'] = "warning";
$this->_sections["warning"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["warning"]['show'] = (bool)$this->_tpl_vars['show']['warning'];
$this->_sections["warning"]['max'] = $this->_sections["warning"]['loop'];
$this->_sections["warning"]['step'] = 1;
$this->_sections["warning"]['start'] = $this->_sections["warning"]['step'] > 0 ? 0 : $this->_sections["warning"]['loop']-1;
if ($this->_sections["warning"]['show']) {
    $this->_sections["warning"]['total'] = $this->_sections["warning"]['loop'];
    if ($this->_sections["warning"]['total'] == 0)
        $this->_sections["warning"]['show'] = false;
} else
    $this->_sections["warning"]['total'] = 0;
if ($this->_sections["warning"]['show']):

            for ($this->_sections["warning"]['index'] = $this->_sections["warning"]['start'], $this->_sections["warning"]['iteration'] = 1;
                 $this->_sections["warning"]['iteration'] <= $this->_sections["warning"]['total'];
                 $this->_sections["warning"]['index'] += $this->_sections["warning"]['step'], $this->_sections["warning"]['iteration']++):
$this->_sections["warning"]['rownum'] = $this->_sections["warning"]['iteration'];
$this->_sections["warning"]['index_prev'] = $this->_sections["warning"]['index'] - $this->_sections["warning"]['step'];
$this->_sections["warning"]['index_next'] = $this->_sections["warning"]['index'] + $this->_sections["warning"]['step'];
$this->_sections["warning"]['first']      = ($this->_sections["warning"]['iteration'] == 1);
$this->_sections["warning"]['last']       = ($this->_sections["warning"]['iteration'] == $this->_sections["warning"]['total']);
?>
            <div class="error">
              WARNING: This answer type is being used for <?php echo $this->_tpl_vars['num_usedanswers']; ?>
 question<?php echo $this->_tpl_vars['usedanswers_plural']; ?>
 in this survey. Changing
              the values will affect all questions using this answer type. Changing the answer type will
              DELETE all existing results for the old type! Deleting an answer value from the list
              below will DELETE all results using that value! Use extreme caution when editing answer types that are in use to prevent
              data loss.
            </div>
          <?php endfor; endif; ?>
        

        <?php if (isset($this->_sections["delete"])) unset($this->_sections["delete"]);
$this->_sections["delete"]['name'] = "delete";
$this->_sections["delete"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["delete"]['show'] = (bool)$this->_tpl_vars['show']['delete'];
$this->_sections["delete"]['max'] = $this->_sections["delete"]['loop'];
$this->_sections["delete"]['step'] = 1;
$this->_sections["delete"]['start'] = $this->_sections["delete"]['step'] > 0 ? 0 : $this->_sections["delete"]['loop']-1;
if ($this->_sections["delete"]['show']) {
    $this->_sections["delete"]['total'] = $this->_sections["delete"]['loop'];
    if ($this->_sections["delete"]['total'] == 0)
        $this->_sections["delete"]['show'] = false;
} else
    $this->_sections["delete"]['total'] = 0;
if ($this->_sections["delete"]['show']):

            for ($this->_sections["delete"]['index'] = $this->_sections["delete"]['start'], $this->_sections["delete"]['iteration'] = 1;
                 $this->_sections["delete"]['iteration'] <= $this->_sections["delete"]['total'];
                 $this->_sections["delete"]['index'] += $this->_sections["delete"]['step'], $this->_sections["delete"]['iteration']++):
$this->_sections["delete"]['rownum'] = $this->_sections["delete"]['iteration'];
$this->_sections["delete"]['index_prev'] = $this->_sections["delete"]['index'] - $this->_sections["delete"]['step'];
$this->_sections["delete"]['index_next'] = $this->_sections["delete"]['index'] + $this->_sections["delete"]['step'];
$this->_sections["delete"]['first']      = ($this->_sections["delete"]['iteration'] == 1);
$this->_sections["delete"]['last']       = ($this->_sections["delete"]['iteration'] == $this->_sections["delete"]['total']);
?>
          <div class="whitebox">
            Delete Answer
          </div>

          <div class="indented_cell">
            Check box and press button to delete answer.
            <br />
            <input type="checkbox" name="delete" value="1">
            &nbsp;&nbsp;
            <input type="submit" name="delete_submit" value="Delete Answer">
          </div>
        <?php endfor; endif; ?>

        <div class="whitebox">
          Answer Name
        </div>

        <div class="indented_cell">
          The Answer Name will appear in the drop
          downs used to select the type of answer you want. It should be short
          and describe the possible answers for this type. The Label
          field is a longer text area where you can give a description of this question
          and possibly explain how to answer (i.e. <em>Check all that apply</em>) The
          Label will be visible to users when they take the survey. Use it
          to explain the question or answers, otherwise leave it blank.

          <br />

          <input type="text" name="name" size="40" value="<?php echo $this->_tpl_vars['answer']['name']; ?>
">
        </div>

        <div class="whitebox">
          Label
        </div>

        <div class="indented_cell">
          <input type="text" name="label" size="60" value="<?php echo $this->_tpl_vars['answer']['label']; ?>
">
        </div>

        <div class="whitebox">
          Answer Type
        </div>

        <div class="indented_cell">
          <select name="type" size="1">
            <option value="MS" <?php echo $this->_tpl_vars['answer']['selected']['MS']; ?>
>MS - Multiple Choice, Single Answer</option>
            <option value="MM" <?php echo $this->_tpl_vars['answer']['selected']['MM']; ?>
>MM - Multiple Choice, Multiple Answers</option>
            <option value="T" <?php echo $this->_tpl_vars['answer']['selected']['T']; ?>
>T - Textbox, large</option>
            <option value="S" <?php echo $this->_tpl_vars['answer']['selected']['S']; ?>
>S - Textbox, small</option>
            <!-- <option value="NUM" <?php echo $this->_tpl_vars['answer']['selected']['NUM']; ?>
>NUM - Numeric Answer</option>
            <option value="DATE" <?php echo $this->_tpl_vars['answer']['selected']['DATE']; ?>
>DATE - Date/Time Answer</option> -->
            <option value="N" <?php echo $this->_tpl_vars['answer']['selected']['N']; ?>
>N - No Answer Values</option>
          </select>

          <ul>
            <li>MS = Multiple choice, one possible answer can be chosen.</li>
            <li>MM = Multiple choice, more than one possible answer can be chosen.</li>
            <li>T = Large text area, unlimited answer size.</li>
            <li>S = Sentence text box, 255 characters max.</li>
            <!-- <li>NUM = Numeric answer only. Use the Label above to tell users about any range that may be required.</li>
            <li>DATE = Date and/or Time answer only. Use the Label above to tell the users about any range that may be required and the format of the date and/or time that's required.</li> -->
            <li>N = No answer choices. Instead of a question, this will be more of a label with no choices below it. Useful
                for setting up a sequence of questions, for example: "<em>For the following 5 questions, choose the most likely answer:</em>"</li>
          </ul>
        </div>

        <div style="text-align:center">
          <input type="submit" name="submit" value="Edit Answer">
        </div>

        <div class="whitebox">
          Answer Values (MS and MM Answer Types only)
        </div>

        <div class="indented_cell">
          <ul>
            <li>You must supply a list of possible answers if you selected MS or MM for an Answer Type.</li>
            <li>List one answer per text box in the boxes below. Use the button at the bottom of the boxes to add more
              boxes for more answers. The order you list the answers here is the order they will be presented in the
              surveys.
            <li>You can optionally assign a numeric value to each answer value that you provide, also. This numeric value can then
              be used when exporting the results to a CSV file for processing by other analysis programs.</li>
          </ul>
        </div>


        <table border="0" cellspacing="0" width="100%">
          <tr class="whitebox" style="text-align:center">
            <td>Num</td>
            <td>Answer Value (Displayed)</td>
            <td>Numeric Value</td>
            <td>Bar Graph Image</td>
          </tr>
          <?php if (isset($this->_sections["i"])) unset($this->_sections["i"]);
$this->_sections["i"]['name'] = "i";
$this->_sections["i"]['loop'] = is_array($this->_tpl_vars['answer']['num_answers']) ? count($this->_tpl_vars['answer']['num_answers']) : max(0, (int)$this->_tpl_vars['answer']['num_answers']);
$this->_sections["i"]['show'] = (bool)"TRUE";
$this->_sections["i"]['max'] = $this->_sections["i"]['loop'];
$this->_sections["i"]['step'] = 1;
$this->_sections["i"]['start'] = $this->_sections["i"]['step'] > 0 ? 0 : $this->_sections["i"]['loop']-1;
if ($this->_sections["i"]['show']) {
    $this->_sections["i"]['total'] = $this->_sections["i"]['loop'];
    if ($this->_sections["i"]['total'] == 0)
        $this->_sections["i"]['show'] = false;
} else
    $this->_sections["i"]['total'] = 0;
if ($this->_sections["i"]['show']):

            for ($this->_sections["i"]['index'] = $this->_sections["i"]['start'], $this->_sections["i"]['iteration'] = 1;
                 $this->_sections["i"]['iteration'] <= $this->_sections["i"]['total'];
                 $this->_sections["i"]['index'] += $this->_sections["i"]['step'], $this->_sections["i"]['iteration']++):
$this->_sections["i"]['rownum'] = $this->_sections["i"]['iteration'];
$this->_sections["i"]['index_prev'] = $this->_sections["i"]['index'] - $this->_sections["i"]['step'];
$this->_sections["i"]['index_next'] = $this->_sections["i"]['index'] + $this->_sections["i"]['step'];
$this->_sections["i"]['first']      = ($this->_sections["i"]['iteration'] == 1);
$this->_sections["i"]['last']       = ($this->_sections["i"]['iteration'] == $this->_sections["i"]['total']);
?>
            <tr style="background-color:<?php $this->_plugins['function']['cycle'][0](array('values' => "#F9F9F9,#FFFFFF"), $this); if($this->_extract) { extract($this->_tpl_vars); $this->_extract=false; } ?>;text-align:center">
              <td><?php echo $this->_sections['i']['iteration']; ?>
.</td>
              <td><input type="text" name="value[<?php echo $this->_tpl_vars['answer']['avid'][$this->_sections['i']['index']]; ?>
]" value="<?php echo $this->_tpl_vars['answer']['value'][$this->_sections['i']['index']]; ?>
" size="40" maxlength="255"></td>
              <td><input type="text" name="numeric_value[<?php echo $this->_tpl_vars['answer']['avid'][$this->_sections['i']['index']]; ?>
]" value="<?php echo $this->_tpl_vars['answer']['numeric_value'][$this->_sections['i']['index']]; ?>
" size="4"></td>
              <td>
                <select name="image[<?php echo $this->_tpl_vars['answer']['avid'][$this->_sections['i']['index']]; ?>
]" size="1">
                  <?php if (isset($this->_sections["img"])) unset($this->_sections["img"]);
$this->_sections["img"]['name'] = "img";
$this->_sections["img"]['loop'] = is_array($this->_tpl_vars['answer']['allowable_images']) ? count($this->_tpl_vars['answer']['allowable_images']) : max(0, (int)$this->_tpl_vars['answer']['allowable_images']);
$this->_sections["img"]['show'] = (bool)"TRUE";
$this->_sections["img"]['max'] = $this->_sections["img"]['loop'];
$this->_sections["img"]['step'] = 1;
$this->_sections["img"]['start'] = $this->_sections["img"]['step'] > 0 ? 0 : $this->_sections["img"]['loop']-1;
if ($this->_sections["img"]['show']) {
    $this->_sections["img"]['total'] = $this->_sections["img"]['loop'];
    if ($this->_sections["img"]['total'] == 0)
        $this->_sections["img"]['show'] = false;
} else
    $this->_sections["img"]['total'] = 0;
if ($this->_sections["img"]['show']):

            for ($this->_sections["img"]['index'] = $this->_sections["img"]['start'], $this->_sections["img"]['iteration'] = 1;
                 $this->_sections["img"]['iteration'] <= $this->_sections["img"]['total'];
                 $this->_sections["img"]['index'] += $this->_sections["img"]['step'], $this->_sections["img"]['iteration']++):
$this->_sections["img"]['rownum'] = $this->_sections["img"]['iteration'];
$this->_sections["img"]['index_prev'] = $this->_sections["img"]['index'] - $this->_sections["img"]['step'];
$this->_sections["img"]['index_next'] = $this->_sections["img"]['index'] + $this->_sections["img"]['step'];
$this->_sections["img"]['first']      = ($this->_sections["img"]['iteration'] == 1);
$this->_sections["img"]['last']       = ($this->_sections["img"]['iteration'] == $this->_sections["img"]['total']);
?>
                    <option value="<?php echo $this->_tpl_vars['answer']['allowable_images'][$this->_sections['img']['index']]; ?>
"<?php echo $this->_tpl_vars['answer']['image_selected'][$this->_sections['i']['index']][$this->_sections['img']['index']]; ?>
><?php echo $this->_tpl_vars['answer']['allowable_images'][$this->_sections['img']['index']]; ?>
</option>
                  <?php endfor; endif; ?>
                </select>
              </td>
            </tr>
          <?php endfor; endif; ?>
        </table>

        <div>
          <?php if (isset($this->_sections["add_answer"])) unset($this->_sections["add_answer"]);
$this->_sections["add_answer"]['name'] = "add_answer";
$this->_sections["add_answer"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["add_answer"]['show'] = (bool)$this->_tpl_vars['answer']['show_add_answers'];
$this->_sections["add_answer"]['max'] = $this->_sections["add_answer"]['loop'];
$this->_sections["add_answer"]['step'] = 1;
$this->_sections["add_answer"]['start'] = $this->_sections["add_answer"]['step'] > 0 ? 0 : $this->_sections["add_answer"]['loop']-1;
if ($this->_sections["add_answer"]['show']) {
    $this->_sections["add_answer"]['total'] = $this->_sections["add_answer"]['loop'];
    if ($this->_sections["add_answer"]['total'] == 0)
        $this->_sections["add_answer"]['show'] = false;
} else
    $this->_sections["add_answer"]['total'] = 0;
if ($this->_sections["add_answer"]['show']):

            for ($this->_sections["add_answer"]['index'] = $this->_sections["add_answer"]['start'], $this->_sections["add_answer"]['iteration'] = 1;
                 $this->_sections["add_answer"]['iteration'] <= $this->_sections["add_answer"]['total'];
                 $this->_sections["add_answer"]['index'] += $this->_sections["add_answer"]['step'], $this->_sections["add_answer"]['iteration']++):
$this->_sections["add_answer"]['rownum'] = $this->_sections["add_answer"]['iteration'];
$this->_sections["add_answer"]['index_prev'] = $this->_sections["add_answer"]['index'] - $this->_sections["add_answer"]['step'];
$this->_sections["add_answer"]['index_next'] = $this->_sections["add_answer"]['index'] + $this->_sections["add_answer"]['step'];
$this->_sections["add_answer"]['first']      = ($this->_sections["add_answer"]['iteration'] == 1);
$this->_sections["add_answer"]['last']       = ($this->_sections["add_answer"]['iteration'] == $this->_sections["add_answer"]['total']);
?>
            Add
            <select name="add_answer_num" size="1">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="5">5</option>
              <option value="10">10</option>
              <option value="20">20</option>
            </select>
            more display and numeric value boxes.
            <input type="submit" name="add_answers_submit" value="Add">
            <input type="hidden" name="num_answers" value="<?php echo $this->_tpl_vars['answer']['num_answers']; ?>
">
          <?php endfor; endif; ?>
          <br />
        </div>

        <br />

        <div style="text-align:center">
          <input type="submit" name="submit" value="Edit Answer">
        </div>
      </form>