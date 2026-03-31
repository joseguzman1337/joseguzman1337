<div class="whitebox">
  {$q.question_num}. {$q.required_text} {$q.question}
</div>

<div class="indented_cell">
  {section name="req_label" loop=1 show=$q.req_label}
    <div class="example">
      ({$q.num_required} repuesta(s) requerida(s))
    </div>
  {/section}

  {section name="label" loop=1 show=$q.label}
    <div class="example">{$q.label}</div>
  {/section}

  {section name="na" loop=$q.num_answers show=TRUE}
    <p><input type="text" name="answer[{$q.qid}][{$smarty.section.na.index}]" size="50" value="{$q.answer[na]}"></p>
  {/section}
</div>