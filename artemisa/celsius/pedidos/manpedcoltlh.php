<?
include_once "../inc/var.inc.php";
 
include_once "../inc/"."conexion.inc.php";  
Conexion();
include_once "../inc/"."identif.php";
Usuario();
if (! isset($Texto))		$Texto ="";
if (! isset($Id_Usuario))	$Id_Usuario ="";
if (! isset($Usuario_C))	$Usuario_C ="";


?> 

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<!-- saved from url=(0129)http://sedici.unlp.edu.ar/horde/imp/view.php?thismailbox=INBOX&index=4890&id=2&actionID=113&mime=7f9e3d002209a8e9d5ccebb847a38796 -->
<HTML><HEAD><TITLE><? echo Titulo_Sitio();?></TITLE>
<META http-equiv=Content-Type 
content="text/html; charset=utf-8"><CLEANED_TAG 
content="text/html; charset=utf-8" http-equiv="Content-Type">
<style type="text/css">
<!--
body {
	margin:0px;
	background-color: #006599;
	margin-left: 10px;
}
body, td, th {
	color: #000000;
}
a:link {
	color: #000000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #000000;
}
a:hover {
	text-decoration: underline;
	color: #0099FF;
}
a:active {
	text-decoration: none;
	color: #000000;
}
.style22 {
	color: #333333;
	font-family: verdana;
	font-size: 11px;
}
.style33 {
	font-family: verdana;
	font-size: 11px;
	color: #006699;
}
.style34 {
	color: #FFFFFF;
	font-weight: normal;
	font-family: Verdana;
	font-size: 11px;
}
.style35 {color: #FFFFFF}
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 11px; }
-->
</style>
<META content="MSHTML 6.00.2743.600" name=GENERATOR></HEAD>
<BODY topMargin=0>
<? 
  include_once "../inc/"."fgenped.php";
  include_once "../inc/"."fgentrad.php";
  include_once "../inc/"."tabla_ped_unnoba.inc" ;
  global $Rol;
   global $IdiomaSitio;
   $Mensajes = Comienzo ("adm-002",$IdiomaSitio);
   $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
   $Modo=14;
   
?>

<script language="JavaScript">
 function Seteo_Modo()
 {
    document.forms.form2.action="manpedcoltlh.php";   
    document.forms.form2.submit();
   
     
 }

  function rutear_PedHist (TipoPed,Id)
 {

     switch (TipoPed)
	  {
	    case 1:
	      ventana=open("verped_col.php?Id="+Id+"&dedonde=1&Tabla=2","Colecciones","scrollbars=yes,width=700,height=450,alwaysLowered");   
	      break;
	    case 2:
	      ventana=open("verped_cap.php?Id="+Id+"&dedonde=1&Tabla=2","Capitulos","scrollbars=yes,width=700,height=450,alwaysLowered");
	      break;
	    case 3:           
          ventana=open("verped_pat.php?Id="+Id+"&dedonde=1&Tabla=2","Patentes","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;	
       case 4:           
          ventana=open("verped_tes.php?Id="+Id+"&dedonde=1&Tabla=2","Tesis","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;	
       case 3:           
          ventana=open("verped_conh.php?Id="+Id+"&dedonde=1&Tabla=2","Actas Congresos","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;	
                
	  }
	    
	 return null	
	
 }

</script>

<DIV align=left>
 <form name="form2">
<TABLE borderColor=#111111 cellSpacing=0 cellPadding=0 width=780 bgColor=#efefef 
border=0 Cleaned="border-collapse: collapse"> <!-- Primer Table-->
  <TBODY>
  <TR>
    <TD bgColor=#e4e4e4>
      <HR color=#e4e4e4 SIZE=1>
      <DIV align=center>
      <CENTER>
      <TABLE borderColor=#111111 cellSpacing=5 cellPadding=0 width=760 
      bgColor=#e4e4e4 border=0 Cleaned="border-collapse: collapse"> <!--Segunda Tabla-->
        <TBODY>
        <TR>
          <TD vAlign=top>
            <DIV align=center>
            <CENTER>
            <TABLE cellSpacing=1 cellPadding=1 width="95%" align=center 
            bgColor=#ececec border=0> <!---Tercer Table-->
               <TBODY>
               <TR bgColor=#006699>
                 <TD class=style33 height=20 align="left"><SPAN class=style34><IMG height=8 src="../images/square-lb.gif" width=8> <?echo $Mensajes["tf-19"];?> </SPAN>
				 </TD>
			   </TR>
               <TR vAlign=center align=left>
                 <TD class="style22">
                 <DIV class="style33" align=center>
                 <TABLE class="style22" cellSpacing=1 cellPadding=1 width="90%" 
                  align=center border=0> <!--Cuarta Tabla-->
                    <TBODY>
                    <TR>
                      <TD class="style22" width=120>
                        <DIV align=right><? echo $Mensajes["tc-9"]; ?></DIV>
					  </TD>
                      <TD class="style33">
                         <DIV align=left><INPUT TYPE="text" NAME="Texto" SIZE="27" value="<? echo $Texto; ?>">
                        </DIV>
					  </TD>
					</TR>
                    <TR>
                      <TD class="style22" width=120>
                        <DIV align=right></DIV>
					  </TD>
                      <TD>
                        <DIV align=left>
						<input type="button" value="<? echo $Mensajes["bot-1"]; ?>" name="B1" class="style22" OnClick="Seteo_Modo()">
                        </DIV>
					  </TD>
					 </TR>
				    </TBODY>
				 </TABLE> <!-- Cierre de la Cuarta Tabla-->
				 </DIV>
				 </TD>
				 </TR>
				 </TBODY>
				 </TABLE> <!--Cierre de Tercera Tabla-->
<input type="hidden" name="Id_Usuario" value="<? echo $Id_Usuario; ?>">
<input type="hidden" name="Usuario_C" value="<? echo $Usuario_C; ?>">
<input type="hidden" name="Modo" value=<? echo $Modo; ?>>
<input type="hidden" name="dedonde" value=<? echo $dedonde; ?>>
</form>  
<? if ($Texto!="")
{


   
  $expresion = armar_expresion_busqueda_hist();   
  $expresion = $expresion."WHERE Titulo_Revista LIKE '".$Texto."%'";
   if ($dedonde==1)
   {
   	 $expresion .= " AND Codigo_Usuario=".$Id_usuario;
   }
   $expresion = $expresion." ORDER BY Titulo_Revista";
  
   $result = mysql_query($expresion);
   echo mysql_error();
   
 ?>  

<HR>
			<DIV align=left>
            <TABLE cellSpacing=1 cellPadding=0 width="95%" align=center 
            bgColor=#0099cc border=0>
              <TBODY>
              <TR>
                <TD class=style22 height=20><IMG height=8 src="../images/square-w.gif"  width=8> 
                  <?  echo $Mensajes["et-9"]; ?> <SPAN 
                class=style35><? echo mysql_num_rows($result); ?></SPAN></TD></TR></TBODY></TABLE></DIV>

 <?
  
    while($row = mysql_fetch_row($result))
     {
		echo "<center>";
		If (!isset($Lista)) {$Lista="";} If ($Lista==2 || $Lista =="")
			 {
 
			 	Dibujar_Tabla_Comp_Hist ($VectorIdioma,$row,$Mensajes,1);     
	 
			 } 
		 echo "</center>";
	 }

   mysql_free_result($result);
 }  
 Desconectar();  
   
?>


			</DIV></TD>
			<? if ($Rol!=1)
		   {
		?>
		<td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
        <? dibujar_menu_usuarios($Usuario,1); ?>
          </div></td>
		  <?
		   }
		  else
		  {
		  ?>
            <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
                <p><img src="../images/image001.jpg" width="150" height="118"><br>
                    <a href="../admin/indexadm.php"><? echo $Mensajes["cf-13"]; ?></a></span></p>
                  </div>                  </td>
          </div></td>
		  <?
		  }	  
		  ?>
      <!--    <TD vAlign=top width=150>
            <DIV class=style22 align=center>
            <DIV align=left>
            <TABLE cellSpacing=0 cellPadding=0 width="97%" align=center 
border=0>
              <TBODY>
              <TR>
                <TD>
                  <DIV align=center>


				<table width="100%" bgcolor="#ececec">
            <tr>
              <td valign="top" class="style28"><div align="center"><img src="../images/image001.jpg" width="150" height="118"><br>
                  <span class="style60">
				  
				  <a href="<? if ($dedonde==1) { echo "../admin/indexadm.php";} else {echo "../admin/indexadm.php";} ?>"><? echo $Mensajes["h-1"]; ?></A></span></div>                <div align="center" class="style55"></div></td>-->
            </tr>
          </table>

          <!--    <TABLE cellSpacing=0 cellPadding=0 width="97%" align=center 
                  border=0>
                    <TBODY>
                    <TR>
                      <TD bgColor="#ececec">
                        <DIV align=center>
                        <P><IMG height=118 src="../images/image001.jpg" width=150><BR><SPAN 
                        class=style33></SPAN></P></DIV></TD></TR></TBODY>
						
						
						</TABLE>-->    <!--</DIV></TD></TR></TBODY></TABLE></DIV>-->

					
 
 
  <tr>
    <td height="44" bgcolor="#E4E4E4"><div align="center">      
      <hr>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" height="43" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50"><div align="right" class="style33">
            <div align="center">adm-002</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
</body>
</html>

