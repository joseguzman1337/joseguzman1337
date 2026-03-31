<table width="70%" align="center" cellpadding="0" cellspacing="0">
  <tr class="grayboxheader">
    <td width="14"><img src="{$conf.images_html}/box_left.gif" border="0" width="14"></td>
    <td background="{$conf.images_html}/box_bg.gif">Survey Results</td>
    <td width="14"><img src="{$conf.images_html}/box_right.gif" border="0" width="14"></td>
  </tr>
</table>
<table width="70%" align="center" class="bordered_table">
  <tr>
    <td>

      <div style="text-align:center">
        [ <a href="{$conf.html}/index.php">Main</a> ]
        &nbsp;&nbsp;
        [ <a href="{$conf.html}/results_table.php?sid={$survey.sid}">Results as Table</a>
          <a href="{$conf.html}/docs/index.html#table_results">[?]</a> ]
        &nbsp;&nbsp;
        [ Export Results to CSV as
          <a href="{$conf.html}/results_csv.php?sid={$survey.sid}&export_type={$survey.export_csv_text}">Text</a> or
          <a href="{$conf.html}/results_csv.php?sid={$survey.sid}&export_type={$survey.export_csv_numeric}">Numeric</a> Values
          <a href="{$conf.html}/docs/index.html#csv_export">[?]</a> ]
      </div>

      <div class="whitebox">
        Results for Survey #{$survey.sid}: {$survey.name}
      </div>

      <form method="GET" action="results.php">
        <input type="hidden" name="sid" value="{$survey.sid}">

        <span class="example">
          Questions marked with a {$survey.required} were required.
        </span>

        <br />

        {section name="filter_text" loop=1 show=$filter_text}
          <br><span class="message">Notice: This result page shows the results filtered by the following questions:</span><br>
          <span style="font-size:x-small">{$filter_text}</span>
        {/section}

        <br />

        <div>
          <select name="action" size="1">
            <option value="filter">Filter On Checked Questions</option>
            {section name="clear_filter" loop=1 show=$show.clear_filter}
              <option value="clear_filter">Clear Filter</option>
            {/section}

            {section name="hide_show_questions" loop=1 show=$survey.hide_show_questions}
              <option value="hide_questions">Hide Checked Questions</option>
              <option value="show_questions">Show Only Checked Questions</option>
            {/section}

            {section name="show_all_questions" loop=1 show=$survey.show_all_questions}
              <option value="show_all_questions">Show All Questions</option>
            {/section}
          </select>
          <input type="submit" name="results_action" value="Go">
          <a href="{$conf.html}/docs/index.html#filter_results">[?]</a>
        </div>

        <br />

        <div class="whitebox">
          Survey Time Stats
        </div>
        <div class="indented_cell">
          Average Completion Time: {$survey.avgtime.minutes}min {$survey.avgtime.seconds}sec
          (Min: {$survey.mintime.minutes}min {$survey.mintime.seconds}sec, Max: {$survey.maxtime.minutes}min {$survey.maxtime.seconds}sec)
          <br />
          Average Time before Quit: {$survey.quittime.minutes}min {$survey.quittime.seconds}sec
        </div>

        {section name="qid" loop=$qid}
          <div class="whitebox">
            {section name="box" loop=1 show=$survey.hide_show_questions}
              <input type="checkbox" name="select_qid[]" value="{$qid[qid]}">&nbsp;
            {/section}

            {section name="qn" loop=1 show=$question_num[qid]}
              {$question_num[qid]}.&nbsp;
            {/section}

            {section name="req" loop=1 show=$num_required[qid]}
              {$survey.required}
            {/section}

            {$question[qid]}
          </div>

          <div>
            <table border="0" cellpadding="2" cellspacing="2" style="font-size:xx-small;margin-left:25px;margin-top:10px;margin-bottom:10px">
              {section name="a" loop=$answer[qid].value}
                <tr>
                  <td>{$answer[qid].value[a]}</td>
                  <td> - </td>
                  <td>{$count[qid][a]}</td>
                  <td>
                    {section name="left_right_img" loop=1 show=$show[qid].left_right_image[a]}
                      <img src="{$conf.images_html}/{$answer[qid].left_image[a]}" alt=""><img src="{$conf.images_html}/{$answer[qid].image[a]}" height="{$height[qid][a]}" width="{$width[qid][a]}" alt="{$percent[qid][a]}%"><img src="{$conf.images_html}/{$answer[qid].right_image[a]}" alt="">
                    {/section}

                    {section name="left_img" loop=1 show=$show[qid].left_image[a]}
                      <img src="{$conf.images_html}/{$answer[qid].left_image[a]}" alt=""><img src="{$conf.images_html}/{$answer[qid].image[a]}" height="{$height[qid][a]}" width="{$width[qid][a]}" alt="{$percent[qid][a]}%">
                    {/section}

                    {section name="right_img" loop=1 show=$show[qid].right_image[a]}
                      <img src="{$conf.images_html}/{$answer[qid].image[a]}" height="{$height[qid][a]}" width="{$width[qid][a]}" alt="{$percent[qid][a]}%"><img src="{$conf.images_html}/{$answer[qid].right_image[a]}" alt="">
                    {/section}

                    {section name="middle_img" loop=1 show=$show[qid].middle_image[a]}
                      <img src="{$conf.images_html}/{$answer[qid].image[a]}" height="{$height[qid][a]}" width="{$width[qid][a]}" alt="{$percent[qid][a]}%">
                    {/section}
                    &nbsp;{$percent[qid][a]}%
                  </td>
                </tr>
              {/section}

              {section name="totans" loop=1 show=$show.numanswers[qid]}
                <tr>
                  <td><strong>Total Answers</strong></td>
                  <td> - </td>
                  <td colspan="2"><strong>{$num_answers[qid]}</strong></td>
                </tr>
              {/section}

              {section name="t" loop=1 show=$text[qid]}
                <tr>
                  <td colspan="4">
                    [ <a href="{$conf.html}/results.php?sid={$survey.sid}&qid={$qid[qid]}&qnum={$question_num[qid]}">View Answers</a> ]
                  </td>
                </tr>
              {/section}
            </table>
          </div>
        {/section}
      </form>

      <div style="text-align:center">
        [ <a href="{$conf.html}/index.php">Main</a> ]
      </div>

    </td>
  </tr>
</table>