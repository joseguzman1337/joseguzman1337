<form method="POST" action="{$conf.html}/results.php">
<input type="hidden" name="sid" value="{$sid}">

  <table width="70%" align="center" cellpadding="0" cellspacing="0">
    <tr class="grayboxheader">
      <td width="14"><img src="{$conf.images_html}/box_left.gif" border="0" width="14"></td>
      <td background="{$conf.images_html}/box_bg.gif">Filter Results</td>
      <td width="14"><img src="{$conf.images_html}/box_right.gif" border="0" width="14"></td>
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

        {section name="q" loop=$question.qid}
          <div class="whitebox">
            {$smarty.section.q.iteration}. {$question.question[q]}
          </div>
          <input type="hidden" name="name[{$question.qid[q]}]" value="{$question.encquestion[q]}">
          <div class="indented_cell">
            {section name="qv" loop=$question.value[q]}
              <input type="checkbox" value="{$question.avid[q][qv]}" name="filter[{$question.qid[q]}][]" id="{$question.avid[q][qv]}">
              <label for="{$question.avid[q][qv]}"> {$question.value[q][qv]}</label>
              <br />
            {/section}
          </div>
        {/section}

        <div class="whitebox">
          Filter by Date
        </div>

        <div class="indented_cell">
          <input type="checkbox" name="date_filter" value="1">
          Limit Results by Date (Start and/or End Date can be left blank to include everything)

          <br />

          Start: <input type="text" name="start_date" value="{$date.min}">
          End: <input type="text" name="end_date" value="{$date.max}">
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