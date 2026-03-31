<form method="GET" action="{$conf.html}/results.php">
  <input type="hidden" name="qnum" value="{$qnum}">
  <input type="hidden" name="sid" value="{$sid}">
  <input type="hidden" name="qid" value="{$qid}">

  <table width="70%" align="center" cellpadding="0" cellspacing="0">
    <tr class="grayboxheader">
      <td width="14"><img src="{$conf.images_html}/box_left.gif" border="0" width="14"></td>
      <td background="{$conf.images_html}/box_bg.gif">Text Results</td>
      <td width="14"><img src="{$conf.images_html}/box_right.gif" border="0" width="14"></td>
    </tr>
  </table>
  <table width="70%" align="center" class="bordered_table">
    <tr>
      <td>

        <div style="text-align:center">
          [ <a href="{$conf.html}/results.php?sid={$sid}">All Results</a>
            &nbsp;|&nbsp;
            <a href="{$conf.html}/index.php">Main</a> ]
        </div>

        <div class="whitebox">
          Answers to Question {$qnum}: {$question}
        </div>

        <div class="indented_cell">
          There are <strong>{$answer.num_answers}</strong> answers to this question.
        </div>

        {section name="search_text" loop=1 show=$answer.search_text}
          <div class="indented_cell">
            Showing only answers matching search for: <strong>{$answer.search_text}</strong>
          </div>
        {/section}

        <div style="text-align:right">
          <input type="text" name="search" value="{$answer.search_text}">
          <input type="submit" name="submit" value="Search">
          {section name="clear_search" loop=1 show=$button.clear}
            <input type="submit" name="clear" value="Clear Search Results">
          {/section}
        </div>

        <br />

        {section name="a" loop=$answer.text}
          <div class="indented_cell">
            {section name="del" loop=1 show=$answer.delete_access}
              <input type="checkbox" name="delete_rid[]" value="{$answer.rid[a]}">
            {/section}
            <strong>{$answer.num[a]}.</strong> {$answer.text[a]}
          </div>
        {sectionelse}
          <div style="text-align:center">
            <strong>No more answers to this question.</strong>
          </div>
        {/section}

        {section name="del2" loop=1 show=$answer.delete_access}
          <input type="submit" name="delete" value="Delete Checked Answers">
        {/section}

        {section name="clear_search" loop=1 show=$button.clear}
          <input type="submit" name="clear" value="Clear Search Results">
        {/section}

        {section name="prev" loop=1 show=$button.previous}
          <input type="submit" name="prev" value="&lt;&lt;&nbsp;Previous Page">&nbsp;
        {/section}

        {section name="next" loop=1 show=$button.next}
          <input type="submit" name="next" value="Next Page&nbsp;&gt;&gt;">
        {/section}

        <div style="text-align:center">
          [ <a href="{$conf.html}/results.php?sid={$sid}">All Results</a>
            &nbsp;|&nbsp;
            <a href="{$conf.html}/index.php">Main</a> ]
        </div>
      </td>
    </tr>
  </table>
</form>