<div class="indented_cell">
  <table border="0" width="100%">
    <tr>
      <td>
        <table border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td>&nbsp;</td>
            {section name="mh" loop=$q.num_values show=TRUE}
              <td>{$q.value[mh]}</td>
            {/section}
          </tr>