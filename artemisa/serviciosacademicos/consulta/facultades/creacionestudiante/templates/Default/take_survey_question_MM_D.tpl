<div class="whitebox">
  {$q.question_num}. {$q.required_text} {$q.question}
</div>

<div class="indented_cell">
  {section name="req_label" loop=1 show=$q.req_label}
    <div class="example">
      ({$q.num_required} respuesta(s) requeridas)
    </div>
  {/section}

  {section name="label" loop=1 show=$q.label}
    <div class="example">{$q.label}</div>
  {/section}

  {section name="na" loop=$q.num_answers show=TRUE}
    <select name="answer[{$q.qid}][{$smarty.section.na.index}][]" MULTIPLE size="5">
      {section name="md2" loop=$q.num_values show=TRUE}
         <option value="{$q.avid[md2]}"{$q.selected[na][md2]}>{$q.value[md2]}</option>
      {/section}
    </select>
  {/section}
</div>