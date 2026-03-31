<?php /* Smarty version 2.3.0, created on 2008-04-07 11:00:55
         compiled from Default/edit_survey_properties.tpl */ ?>
    <form method="POST" action="<?php echo $this->_tpl_vars['conf']['html']; ?>
/edit_survey.php">
    <input type="hidden" name="mode" value="<?php echo $this->_tpl_vars['data']['mode']; ?>
">
    <input type="hidden" name="sid" value="<?php echo $this->_tpl_vars['data']['sid']; ?>
">

      <div class="whitebox">Survey Name <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/docs/index.html#ep_name">[?]</a></div>

      <div class="indented_cell">
        <input type="text" name="name" value="<?php echo $this->_tpl_vars['data']['name']; ?>
" size="50">
      </div>

      <div class="whitebox">Creation Date: <?php echo $this->_tpl_vars['data']['created']; ?>
</div>

      <div class="whitebox">Status <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/docs/index.html#ep_active">[?]</a></div>

      <div class="indented_cell">
        <input type="radio" name="active" value="1"<?php echo $this->_tpl_vars['data']['active_selected']; ?>
>Active
        &nbsp;
        <input type="radio" name="active" value="0"<?php echo $this->_tpl_vars['data']['inactive_selected']; ?>
>Inactive
      </div>

      <div class="whitebox">Start Date <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/docs/index.html#ep_dates">[?]</a></div>

      <div class="indented_cell">
        If Start and End dates are given, they will override the Active/Inactive Status setting.
        <br />
        If Start and End dates are blank, then the Active/Inactive Status will control the survey.
        <br />
        <input type="text" name="start" size="11" maxlength="10" value="<?php echo $this->_tpl_vars['data']['start_date']; ?>
"> (yyyy-mm-dd)
      </div>

      <div class="whitebox">End Date</div>

      <div class="indented_cell">
        <input type="text" name="end" size="11" maxlength="10" value="<?php echo $this->_tpl_vars['data']['end_date']; ?>
"> (yyyy-mm-dd)
      </div>

      <div class="whitebox">Survey Template <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/docs/index.html#ep_template">[?]</a></div>

      <div class="indented_cell">
        <select name="template" size="1">
          <?php if (isset($this->_sections["tem"])) unset($this->_sections["tem"]);
$this->_sections["tem"]['name'] = "tem";
$this->_sections["tem"]['loop'] = is_array($this->_tpl_vars['data']['templates']) ? count($this->_tpl_vars['data']['templates']) : max(0, (int)$this->_tpl_vars['data']['templates']);
$this->_sections["tem"]['show'] = (bool)"TRUE";
$this->_sections["tem"]['max'] = $this->_sections["tem"]['loop'];
$this->_sections["tem"]['step'] = 1;
$this->_sections["tem"]['start'] = $this->_sections["tem"]['step'] > 0 ? 0 : $this->_sections["tem"]['loop']-1;
if ($this->_sections["tem"]['show']) {
    $this->_sections["tem"]['total'] = $this->_sections["tem"]['loop'];
    if ($this->_sections["tem"]['total'] == 0)
        $this->_sections["tem"]['show'] = false;
} else
    $this->_sections["tem"]['total'] = 0;
if ($this->_sections["tem"]['show']):

            for ($this->_sections["tem"]['index'] = $this->_sections["tem"]['start'], $this->_sections["tem"]['iteration'] = 1;
                 $this->_sections["tem"]['iteration'] <= $this->_sections["tem"]['total'];
                 $this->_sections["tem"]['index'] += $this->_sections["tem"]['step'], $this->_sections["tem"]['iteration']++):
$this->_sections["tem"]['rownum'] = $this->_sections["tem"]['iteration'];
$this->_sections["tem"]['index_prev'] = $this->_sections["tem"]['index'] - $this->_sections["tem"]['step'];
$this->_sections["tem"]['index_next'] = $this->_sections["tem"]['index'] + $this->_sections["tem"]['step'];
$this->_sections["tem"]['first']      = ($this->_sections["tem"]['iteration'] == 1);
$this->_sections["tem"]['last']       = ($this->_sections["tem"]['iteration'] == $this->_sections["tem"]['total']);
?>
            <option value="<?php echo $this->_tpl_vars['data']['templates'][$this->_sections['tem']['index']]; ?>
"<?php echo $this->_tpl_vars['data']['selected_template'][$this->_sections['tem']['index']]; ?>
><?php echo $this->_tpl_vars['data']['templates'][$this->_sections['tem']['index']]; ?>
</option>
          <?php endfor; endif; ?>
        </select>
      </div>

      <div class="whitebox">Text Modes <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/docs/index.html#ep_text_mode">[?]</a></div>

      <div class="indented_cell">
        These settings control the text modes for survey data (questions and answer values) and user data (answers
        supplied by users taking the survey).
        <?php if (isset($this->_sections["fullhtml_warning"])) unset($this->_sections["fullhtml_warning"]);
$this->_sections["fullhtml_warning"]['name'] = "fullhtml_warning";
$this->_sections["fullhtml_warning"]['loop'] = is_array("1") ? count("1") : max(0, (int)"1");
$this->_sections["fullhtml_warning"]['show'] = (bool)$this->_tpl_vars['data']['show']['fullhtmlwarning'];
$this->_sections["fullhtml_warning"]['max'] = $this->_sections["fullhtml_warning"]['loop'];
$this->_sections["fullhtml_warning"]['step'] = 1;
$this->_sections["fullhtml_warning"]['start'] = $this->_sections["fullhtml_warning"]['step'] > 0 ? 0 : $this->_sections["fullhtml_warning"]['loop']-1;
if ($this->_sections["fullhtml_warning"]['show']) {
    $this->_sections["fullhtml_warning"]['total'] = $this->_sections["fullhtml_warning"]['loop'];
    if ($this->_sections["fullhtml_warning"]['total'] == 0)
        $this->_sections["fullhtml_warning"]['show'] = false;
} else
    $this->_sections["fullhtml_warning"]['total'] = 0;
if ($this->_sections["fullhtml_warning"]['show']):

            for ($this->_sections["fullhtml_warning"]['index'] = $this->_sections["fullhtml_warning"]['start'], $this->_sections["fullhtml_warning"]['iteration'] = 1;
                 $this->_sections["fullhtml_warning"]['iteration'] <= $this->_sections["fullhtml_warning"]['total'];
                 $this->_sections["fullhtml_warning"]['index'] += $this->_sections["fullhtml_warning"]['step'], $this->_sections["fullhtml_warning"]['iteration']++):
$this->_sections["fullhtml_warning"]['rownum'] = $this->_sections["fullhtml_warning"]['iteration'];
$this->_sections["fullhtml_warning"]['index_prev'] = $this->_sections["fullhtml_warning"]['index'] - $this->_sections["fullhtml_warning"]['step'];
$this->_sections["fullhtml_warning"]['index_next'] = $this->_sections["fullhtml_warning"]['index'] + $this->_sections["fullhtml_warning"]['step'];
$this->_sections["fullhtml_warning"]['first']      = ($this->_sections["fullhtml_warning"]['iteration'] == 1);
$this->_sections["fullhtml_warning"]['last']       = ($this->_sections["fullhtml_warning"]['iteration'] == $this->_sections["fullhtml_warning"]['total']);
?>
          Notice: Allowing Full HTML is a security risk. Malicious users can include HTML that will mess up the
          page design and possibly introduce vulernabilities to those who view the HTML they create. It is recommended
          that Full HTML mode not be used for the user_text_mode and only used for survey_text_mode under controlled circumstances.
        <?php endfor; endif; ?>
        <br />
        Survey Text Mode:
          <select name="survey_text_mode" size="1">
            <?php if (isset($this->_sections["stm"])) unset($this->_sections["stm"]);
$this->_sections["stm"]['name'] = "stm";
$this->_sections["stm"]['loop'] = is_array($this->_tpl_vars['data']['survey_text_mode_options']) ? count($this->_tpl_vars['data']['survey_text_mode_options']) : max(0, (int)$this->_tpl_vars['data']['survey_text_mode_options']);
$this->_sections["stm"]['show'] = (bool)"TRUE";
$this->_sections["stm"]['max'] = $this->_sections["stm"]['loop'];
$this->_sections["stm"]['step'] = 1;
$this->_sections["stm"]['start'] = $this->_sections["stm"]['step'] > 0 ? 0 : $this->_sections["stm"]['loop']-1;
if ($this->_sections["stm"]['show']) {
    $this->_sections["stm"]['total'] = $this->_sections["stm"]['loop'];
    if ($this->_sections["stm"]['total'] == 0)
        $this->_sections["stm"]['show'] = false;
} else
    $this->_sections["stm"]['total'] = 0;
if ($this->_sections["stm"]['show']):

            for ($this->_sections["stm"]['index'] = $this->_sections["stm"]['start'], $this->_sections["stm"]['iteration'] = 1;
                 $this->_sections["stm"]['iteration'] <= $this->_sections["stm"]['total'];
                 $this->_sections["stm"]['index'] += $this->_sections["stm"]['step'], $this->_sections["stm"]['iteration']++):
$this->_sections["stm"]['rownum'] = $this->_sections["stm"]['iteration'];
$this->_sections["stm"]['index_prev'] = $this->_sections["stm"]['index'] - $this->_sections["stm"]['step'];
$this->_sections["stm"]['index_next'] = $this->_sections["stm"]['index'] + $this->_sections["stm"]['step'];
$this->_sections["stm"]['first']      = ($this->_sections["stm"]['iteration'] == 1);
$this->_sections["stm"]['last']       = ($this->_sections["stm"]['iteration'] == $this->_sections["stm"]['total']);
?>
              <option value="<?php echo $this->_tpl_vars['data']['survey_text_mode_options'][$this->_sections['stm']['index']]; ?>
"<?php echo $this->_tpl_vars['data']['survey_text_mode_selected'][$this->_sections['stm']['index']]; ?>
><?php echo $this->_tpl_vars['data']['survey_text_mode_values'][$this->_sections['stm']['index']]; ?>
</option>
            <?php endfor; endif; ?>
          </select>
        <br />
        User Text Mode:
          <select name="user_text_mode" size="1">
            <?php if (isset($this->_sections["utm"])) unset($this->_sections["utm"]);
$this->_sections["utm"]['name'] = "utm";
$this->_sections["utm"]['loop'] = is_array($this->_tpl_vars['data']['user_text_mode_options']) ? count($this->_tpl_vars['data']['user_text_mode_options']) : max(0, (int)$this->_tpl_vars['data']['user_text_mode_options']);
$this->_sections["utm"]['show'] = (bool)"TRUE";
$this->_sections["utm"]['max'] = $this->_sections["utm"]['loop'];
$this->_sections["utm"]['step'] = 1;
$this->_sections["utm"]['start'] = $this->_sections["utm"]['step'] > 0 ? 0 : $this->_sections["utm"]['loop']-1;
if ($this->_sections["utm"]['show']) {
    $this->_sections["utm"]['total'] = $this->_sections["utm"]['loop'];
    if ($this->_sections["utm"]['total'] == 0)
        $this->_sections["utm"]['show'] = false;
} else
    $this->_sections["utm"]['total'] = 0;
if ($this->_sections["utm"]['show']):

            for ($this->_sections["utm"]['index'] = $this->_sections["utm"]['start'], $this->_sections["utm"]['iteration'] = 1;
                 $this->_sections["utm"]['iteration'] <= $this->_sections["utm"]['total'];
                 $this->_sections["utm"]['index'] += $this->_sections["utm"]['step'], $this->_sections["utm"]['iteration']++):
$this->_sections["utm"]['rownum'] = $this->_sections["utm"]['iteration'];
$this->_sections["utm"]['index_prev'] = $this->_sections["utm"]['index'] - $this->_sections["utm"]['step'];
$this->_sections["utm"]['index_next'] = $this->_sections["utm"]['index'] + $this->_sections["utm"]['step'];
$this->_sections["utm"]['first']      = ($this->_sections["utm"]['iteration'] == 1);
$this->_sections["utm"]['last']       = ($this->_sections["utm"]['iteration'] == $this->_sections["utm"]['total']);
?>
              <option value="<?php echo $this->_tpl_vars['data']['user_text_mode_options'][$this->_sections['utm']['index']]; ?>
"<?php echo $this->_tpl_vars['data']['user_text_mode_selected'][$this->_sections['utm']['index']]; ?>
><?php echo $this->_tpl_vars['data']['user_text_mode_values'][$this->_sections['utm']['index']]; ?>
</option>
            <?php endfor; endif; ?>
          </select>
      </div>
      <div class="whitebox">Completion Redirect Page <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/docs/index.html#ep_redirect">[?]</a></div>
      <div class="indented_cell">
        This is the page users will be sent to after they complete the survey.<br />
        <input type="radio" name="redirect_page" value="index"<?php echo $this->_tpl_vars['data']['redirect_index']; ?>
> Main Survey Page <span class="example">(index.php)</span><br />
        <input type="radio" name="redirect_page" value="results"<?php echo $this->_tpl_vars['data']['redirect_results']; ?>
> Survey Results Page <span class="example">(Results Access should be Public)</span><br />
        <input type="radio" name="redirect_page" value="custom"<?php echo $this->_tpl_vars['data']['redirect_custom']; ?>
> Custom URL <span class="example">(If URL does not start with http:// or https://, it is assumed to be a relative URL from <?php echo $this->_tpl_vars['conf']['html']; ?>
)</span><br />
        <div style="margin-left:20px">
          URL: <input type="text" name="redirect_page_text" value="<?php echo $this->_tpl_vars['data']['redirect_page_text']; ?>
" size="30" maxlength="255">
        </div>
      </div>

      <div class="whitebox">Results Date Format <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/docs/index.html#ep_results_date_format">[?]</a></div>

      <div class="indented_cell">
        Format used for Table Results and CSV Export. Must match specifications given for PHP
        <a href="http://www.php.net/date" target="_blank">date()</a> function.<br />
        <input type="text" name="date_format" size="20" value="<?php echo $this->_tpl_vars['data']['date_format']; ?>
">
      </div>

      <div class="whitebox">Time Limit <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/docs/index.html#ep_time_limit">[?]</a></div>

      <div class="indented_cell">
        Optional time limit to take survey in minutes. Leave blank or zero for no time limit. Time limit begins from
        the time the first question is viewed. Only pages submitted before the time limit is up are saved in the
        results. If the time limit is 60 minutes and page 8 is submitted after 60 minutes, only pages 1 through 7
        are saved.<br />
        <input type="text" name="time_limit" size="5" value="<?php echo $this->_tpl_vars['data']['time_limit']; ?>
"> (minutes)
      </div>

      <div class="whitebox">Clear Results <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/docs/index.html#ep_clear">[?]</a></div>

      <div class="indented_cell">
        <input type="checkbox" name="clear_answers" value="1">
        Check this box to clear current answers to this survey.
        Answers will be cleared when you press Save Changes below.
      </div>

      <div class="whitebox">Delete Survey <a href="<?php echo $this->_tpl_vars['conf']['html']; ?>
/docs/index.html#ep_delete">[?]</a></div>

      <div class="indented_cell">
        <input type="checkbox" name="delete_survey" value="1">
        Check this box to Delete the Survey. All questions and answers associated with
        this survey will be erased. There is no way to 'undelete' this information. The
        survey will be deleted when you click Save Changes below.
      </div>

      <br />

      <div style="text-align:center">
        <input type="submit" name="edit_survey_submit" value="Save Changes">
      </div>
    </form>