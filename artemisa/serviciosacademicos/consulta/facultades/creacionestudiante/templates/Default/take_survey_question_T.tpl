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
    <p><textarea name="answer[{$q.qid}][{$smarty.section.na.index}]" cols="40" rows="5">{$q.answer[na]}</textarea></p>
  {/section}
</div>