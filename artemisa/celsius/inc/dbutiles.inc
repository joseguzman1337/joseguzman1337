<?
/*if (__DBUtiles_inc == 1)
	return;
define ('__DBUtiles_inc', 1);
*/
function TablaMuestra($result, $link="") {

?>
<font face="MS Sans Serif" size="1" color="#155CAA">
<TABLE BORDER=1 cellspacing=2 cellpadding=0 bgcolor="#c0c0c0">
   <THEAD>
      <TR>
	  	
         <?php
            for ($i = 0; $i < mysql_num_fields($result); $i++) {
               echo("<TH class=titulo><font face='MS Sans Serif' size='1' color='#155CAA'>" . mysql_field_name($result,$i) . "</font></TH>");
            }
         ?>
      </TR>
   </THEAD>
   <TBODY>
      <?php
         for ($i = 0; $i < mysql_num_rows($result); $i++) {
            echo("<TR>");
            $row_array = mysql_fetch_row($result);
            for ($j = 0; $j < mysql_num_fields($result); $j++) {
								if ($j==0 && !empty($link))
									 echo ("<td><a href=\"$link?" . mysql_field_name($result,0) . "=" . urlencode($row_array[$j]) . "\">" . $row_array[$j] . "</a></TD>");
								else
								  {
								    if ($row_array[$j]!="")
									{
								    	echo("<TD><font face='MS Sans Serif' size='1' color='#003399'>" . $row_array[$j] . "</font></TD>");
									}
									else
									{
										echo ("<TD>&nbsp;</TD>");
									}	
								   }	
            }
			
            echo("</TR>");
         }
      ?>
   </TBODY>
</TABLE>
</font>

<?
}

function RegistroMuestra($result) {
//  $row_array = mysql_fetch_row($result);
?>
<table>
<tbody>

<?
	for ($i = 0; $i < mysql_num_fields($result); $i++) {
?>
<tr>
<td><? echo mysql_field_name($result, $i) ?></td>
<td><? echo mysql_result($result,0, $i) ?></td>
</tr>
<?
	}
?>

</tbody>
</table>
<?
}
?>
