</div>


<table width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr> 
	<td align="right" class="style15" height="20">
		<?= isset($pageName)?$pageName:""; ?>&nbsp;&nbsp;&nbsp;
	</td>
</tr>
<tr>
	<td height="25" bgcolor="#0099CC" align="center" class="style5">
		<? /* TODO traducir!!! el mensaje de copyright*/?>
		Todos los derechos reservados &copy; PrEBi, 2006/2007 | 
		<a href="../mail/contactenos.php">
			<?			
			if ($IdiomaSitio == 1)
				echo "Contáctenos";
			elseif ($IdiomaSitio == 2)
					echo "Fale Conosco";
			else
					echo "Contact us";
			?>
		</a>
	</td>
</tr>
<tr>
	<td align="center" >
		<a href="http://www.prebi.unlp.edu.ar" target="_blank" >
    		<img src="../images/logos/logo-prebi1.gif" width="271" height="53" alt="PrEBi | UNLP" border="0"/>
    	</a>
    </td>
</tr>
</table>
</div>
</body>
</html>