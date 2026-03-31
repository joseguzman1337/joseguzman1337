<div class="whitebox">
  {$q.question_num}. {$q.required_text} {$q.question}
</div>

<div class="indented_cell">
  {section name="req_label" loop=1 show=$q.req_label}
    <div class="example">
      ({$q.num_required} repuesta(s) requuerida(s))
    </div>
  {/section}

  {section name="label" loop=1 show=$q.label}
    <div class="example">{$q.label}</div>
  {/section}

  {section name="na" loop=$q.num_answers show=TRUE}
    {section name="ms" loop=$q.num_values show=TRUE}
      <input type="radio" name="answer[{$q.qid}][{$smarty.section.na.index}]" value="{$q.avid[ms]}" id="{$q.qid}-{$q.avid[ms]}"{$q.selected[na][ms]}>
      <label for="{$q.qid}-{$q.avid[ms]}"> {$q.value[ms]}</label>
    {/section}
    <br />
  {/section}
</div>