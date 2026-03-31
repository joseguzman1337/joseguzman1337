<table width="70%" align="center" cellpadding="0" cellspacing="0">
  <tr class="grayboxheader">
    <td width="14"><img src="{$conf.images_html}/box_left.gif" border="0" width="14"></td>
    <td background="{$conf.images_html}/box_bg.gif">{$message.title}</td>
    <td width="14"><img src="{$conf.images_html}/box_right.gif" border="0" width="14"></td>
  </tr>
</table>

<table width="70%" align="center" class="bordered_table">
  <tr>
    <td class="message">{$message.text}</td>
  </tr>
  <tr>
    <td align="center">
      [ <a href="{$conf.html}/index.php">Main</a>
      {section name="admin" loop=1 show=$smarty.session.priv[0][0]}
        &nbsp;|&nbsp;<a href="{$conf.html}/admin.php">Admin</a>
      {/section} ]
    </td>
  </tr>
</table>
<br>
