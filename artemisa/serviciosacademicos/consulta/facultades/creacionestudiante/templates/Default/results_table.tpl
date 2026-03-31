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
        [ <a href="{$conf.html}/results.php?sid={$survey.sid}">Graphic Results</a> ]
        &nbsp;&nbsp;
        [ <a href="{$conf.html}/results_csv.php?sid={$survey.sid}">Export Results to CSV</a>
          <a href="{$conf.html}/docs/index.html#csv_export">[?]</a> ]
      </div>

      <div class="whitebox">
        Results for Survey #{$survey.sid}: {$survey.name}
      </div>

      {section name="filter_text" loop=1 show=$filter_text}
        <br><span class="message">Notice: This result page shows the results filtered by the following questions:</span><br>
        <span style="font-size:x-small">{$filter_text}</span>
      {/section}

      <div>
        <table border="1" cellpadding="2" cellspacing="2" style="font-size:xx-small;margin-left:25px;margin-top:10px;margin-bottom:10px">
          <tr>
            {section name=q loop=$data.questions show=TRUE}
              <th>{$data.questions[q]}</th>
            {/section}
            <th>Datetime</th>
          </tr>
          {section name=x loop=$data.answers show=TRUE}
            <tr>
              {section name=a loop=$data.answers[x] show=TRUE}
                <td>{$data.answers[x][a]}</td>
              {/section}
            </tr>
          {/section}
        </table>
      </div>

      <div style="text-align:center">
        [ <a href="{$conf.html}/index.php">Main</a> ]
        &nbsp;&nbsp;
        [ <a href="{$conf.html}/results.php?sid={$survey.sid}">Graphic Results</a> ]
        &nbsp;&nbsp;
        [ <a href="{$conf.html}/results_csv.php?sid={$survey.sid}">Export Results to CSV</a> ]
      </div>

    </td>
  </tr>
</table>