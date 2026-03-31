<div class="whitebox">
  {$q.question_num}. {$q.required_text} {$q.question}
</div>

<div class="indented_cell">
  {section name="req_label" loop=1 show=$q.req_label}
    <div class="example">
      ({$q.num_required} respuesta(s) requiridas)
    </div>
  {/section}

  {section name="label" loop=1 show=$q.label}
    <div class="example">{$q.label}</div>
  {/section}

  {section name="na" loop=$q.num_answers show=TRUE}
    <input type="hidden" name="answer[{$q.qid}][{$smarty.section.na.index}]" value="">
    {section name="mm" loop=$q.num_values show=TRUE}
      <input type="checkbox" name="answer[{$q.qid}][{$smarty.section.na.index}][]" value="{$q.avid[mm]}" id="{$q.qid}-{$q.avid[mm]}"{$q.selected[na][mm]}>
      <label for="{$q.qid}-{$q.avid[mm]}"> {$q.value[mm]}</label>
    {/section}
    <br />
  {/section}
</div>
