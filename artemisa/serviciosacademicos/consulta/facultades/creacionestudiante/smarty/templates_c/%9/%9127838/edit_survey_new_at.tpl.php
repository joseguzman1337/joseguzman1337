<?php /* Smarty version 2.3.0, created on 2008-04-07 12:36:16
         compiled from Default/edit_survey_new_at.tpl */ ?>
<?php $this->_load_plugins(array(
array('function', 'cycle', 'Default/edit_survey_new_at.tpl', 97, false),)); ?>      
        <?php if (isset($this->_sections["success"])) unset($this->_sections["success"]);
$this->_sections["success"]['name'] = "success";
$this->_sections["success"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["success"]['show'] = (bool)$this->_tpl_vars['success'];
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
          <div class="message">New answer type successfully added.</div>
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

      <form method="POST" action="<?php echo $this->_tpl_vars['conf']['html']; ?>
/new_answer_type.php">

        <input type="hidden" name="sid" value="<?php echo $this->_tpl_vars['input']['sid']; ?>
">

        <div class="whitebox">
           <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/docs/index.html#new_answer_type">[Help]</a>
        </div>

        <div class="whitebox">
          Answer Name
        </div>

        <div class="indented_cell">
          <input type="text" name="name" size="40" value="<?php echo $this->_tpl_vars['input']['name']; ?>
">
          <br />
          The Answer Name will appear in the drop
          downs used to select the type of answer you want. It should be short
          and describe the possible answers for this type. The Label
          field is a longer text area where you can give a description of this question
          and possibly explain how to answer (i.e. <em>Check all that apply</em>) The
          Label will be visible to users when they take the survey. Use it
          to explain the question or answers, otherwise leave it blank.
        </div>

        <div class="whitebox">
          Label
        </div>

        <div class="indented_cell">
          <input type="text" name="label" size="60" value="<?php echo $this->_tpl_vars['input']['label']; ?>
">
        </div>

        <div class="whitebox">
          Answer Type
        </div>

        <div class="indented_cell">
          <select name="type" size="1">
            <option value="MS" <?php echo $this->_tpl_vars['selected']['MS']; ?>
>MS - Multiple Choice, Single Answer</option>
            <option value="MM" <?php echo $this->_tpl_vars['selected']['MM']; ?>
>MM - Multiple Choice, Multiple Answers</option>
            <option value="T" <?php echo $this->_tpl_vars['selected']['T']; ?>
>T - Textbox, large</option>
            <option value="S" <?php echo $this->_tpl_vars['selected']['S']; ?>
>S - Textbox, small</option>
            <!-- <option value="NUM" <?php echo $this->_tpl_vars['selected']['NUM']; ?>
>NUM - Numeric Answer</option>
            <option value="DATE" <?php echo $this->_tpl_vars['selected']['DATE']; ?>
>DATE - Date/Time Answer</option> -->
            <option value="N" <?php echo $this->_tpl_vars['selected']['N']; ?>
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
          <input type="submit" name="submit" value="Add Answer">
        </div>

        <div class="whitebox">
          Answer Values (MS and MM Answer Types Only)
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

        <table border="0" width="100%" cellspacing="0">
          <tr class="whitebox" style="text-align:center">
            <td>Num</td>
            <td>Answer Value (Displayed)</td>
            <td>Numeric Value</td>
            <td>Bar Graph Image</td>
          </tr>
          <?php if (isset($this->_sections["i"])) unset($this->_sections["i"]);
$this->_sections["i"]['name'] = "i";
$this->_sections["i"]['loop'] = is_array($this->_tpl_vars['input']['num_answers']) ? count($this->_tpl_vars['input']['num_answers']) : max(0, (int)$this->_tpl_vars['input']['num_answers']);
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
              <td><input type="text" name="value[]" value="<?php echo $this->_tpl_vars['input']['value'][$this->_sections['i']['index']]; ?>
" size="40" maxlength="255"></td>
              <td><input type="text" name="numeric_value[]" value="<?php echo $this->_tpl_vars['input']['numeric_value'][$this->_sections['i']['index']]; ?>
" size="4"></td>
              <td>
                <select name="image[]" size="1">
                  <?php if (isset($this->_sections["image"])) unset($this->_sections["image"]);
$this->_sections["image"]['name'] = "image";
$this->_sections["image"]['loop'] = is_array($this->_tpl_vars['input']['allowable_images']) ? count($this->_tpl_vars['input']['allowable_images']) : max(0, (int)$this->_tpl_vars['input']['allowable_images']);
$this->_sections["image"]['show'] = (bool)"TRUE";
$this->_sections["image"]['max'] = $this->_sections["image"]['loop'];
$this->_sections["image"]['step'] = 1;
$this->_sections["image"]['start'] = $this->_sections["image"]['step'] > 0 ? 0 : $this->_sections["image"]['loop']-1;
if ($this->_sections["image"]['show']) {
    $this->_sections["image"]['total'] = $this->_sections["image"]['loop'];
    if ($this->_sections["image"]['total'] == 0)
        $this->_sections["image"]['show'] = false;
} else
    $this->_sections["image"]['total'] = 0;
if ($this->_sections["image"]['show']):

            for ($this->_sections["image"]['index'] = $this->_sections["image"]['start'], $this->_sections["image"]['iteration'] = 1;
                 $this->_sections["image"]['iteration'] <= $this->_sections["image"]['total'];
                 $this->_sections["image"]['index'] += $this->_sections["image"]['step'], $this->_sections["image"]['iteration']++):
$this->_sections["image"]['rownum'] = $this->_sections["image"]['iteration'];
$this->_sections["image"]['index_prev'] = $this->_sections["image"]['index'] - $this->_sections["image"]['step'];
$this->_sections["image"]['index_next'] = $this->_sections["image"]['index'] + $this->_sections["image"]['step'];
$this->_sections["image"]['first']      = ($this->_sections["image"]['iteration'] == 1);
$this->_sections["image"]['last']       = ($this->_sections["image"]['iteration'] == $this->_sections["image"]['total']);
?>
                    <option value="<?php echo $this->_tpl_vars['input']['allowable_images'][$this->_sections['image']['index']]; ?>
"<?php echo $this->_tpl_vars['selected']['image'][$this->_sections['i']['index']][$this->_sections['image']['index']]; ?>
><?php echo $this->_tpl_vars['input']['allowable_images'][$this->_sections['image']['index']]; ?>
</option>
                  <?php endfor; endif; ?>
                </select>
              </td>
            </tr>
          <?php endfor; endif; ?>
        </table>

        <div style="margin-bottom:10px">
          <?php if (isset($this->_sections["add_answer"])) unset($this->_sections["add_answer"]);
$this->_sections["add_answer"]['name'] = "add_answer";
$this->_sections["add_answer"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["add_answer"]['show'] = (bool)$this->_tpl_vars['input']['show_add_answers'];
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
            <input type="hidden" name="num_answers" value="<?php echo $this->_tpl_vars['input']['num_answers']; ?>
">
          <?php endfor; endif; ?>
        </div>
        <div style="text-align:center;margin-top:20px">
          <input type="submit" name="submit" value="Add Answer">
        </div>

      </form>