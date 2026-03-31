<table width="70%" align="center" cellpadding="0" cellspacing="0">
  <tr class="grayboxheader">
    <td width="14"><img src="{$conf.images_html}/box_left.gif" border="0" width="14"></td>
    <td background="{$conf.images_html}/box_bg.gif">User Login</td>
    <td width="14"><img src="{$conf.images_html}/box_right.gif" border="0" width="14"></td>
  </tr>
</table>

<table width="70%" align="center" class="bordered_table">
  {section name="message" show=$data.message}
    <tr><td class="error">{$data.message}</td></tr>
  {/section}
  <tr>
    <td align="center">
      <form method="POST" action="{$conf.html}/{$data.page}" name="login_form">
        {section name="h" loop=$data.hiddenkey show=true}
          <input type="hidden" name="{$data.hiddenkey[h]}" value="{$data.hiddenval[h]}">
        {/section}
        Please enter a username and password:
        <br>
        Username: <input type="text" name="username" value="{$data.username}" size="15" maxlength="25">
        Password: <input type="password" name="password" size="15" maxlength="25">
        <br>
        <input type="submit" value="Enter">
      </form>

      <div style="text-align:center;margin-top:20px">
        [ <a href="{$conf.html}/index.php">Main</a> ]
      </div>
    </td>
  </tr>
</table>
<script language="JavaScript">
document.login_form.username.focus();
</script>