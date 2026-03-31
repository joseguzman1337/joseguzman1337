  <tr style="background-color:{cycle values="#FFFFFF,F9F9F9"}">
    <td>
      {$q.question_num}. {$q.required_text} {$q.question}
    </td>

    {section name="ms" loop=$q.num_values show=TRUE}
      <td>
        <input type="radio" name="answer[{$q.qid}][0]" value="{$q.avid[ms]}" {$q.selected[0][ms]}>
      </td>
    {/section}