  <tr style="background-color:{cycle values="#FFFFFF,F9F9F9"}">
    <td>
      <input type="hidden" name="answer[{$q.qid}][0]" value="">
      {$q.question_num}. {$q.required_text} {$q.question}
    </td>

    {section name="mm" loop=$q.num_values show=TRUE}
      <td>
        <input type="checkbox" name="answer[{$q.qid}][0][]" value="{$q.avid[mm]}" {$q.selected[0][mm]}>
      </td>
    {/section}