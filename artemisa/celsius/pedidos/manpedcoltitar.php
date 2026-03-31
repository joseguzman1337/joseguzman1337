<?
include_once "../inc/var.inc.php";
 
include_once "../inc/"."conexion.inc.php";  
Conexion();
include_once "../inc/"."identif.php";
Usuario();
if (! isset($Texto))	$Texto ="";
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
	font-size: 9px;
}
.style33 {
	font-family: verdana;
	font-size: 9px;
	color: #006699;
}
.style34 {
	color: #FFFFFF;
	font-weight: normal;
	font-family: Verdana;
	font-size: 9px;
}
.style35 {color: #FFFFFF}
-->
</style>
<META content="MSHTML 6.00.2743.600" name=GENERATOR></HEAD>
<BODY topMargin=0>
<? 
  include_once "../inc/"."fgenped.php";
  include_once "../inc/"."fgentrad.php";
  include_once "../inc/"."tabla_ped_unnoba.inc" ;
  
   
   $Mensajes = Comienzo ("adm-003",$IdiomaSitio);
   $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
   $Modo=14;
   
?>

<script language="JavaScript">
 function Seteo_Modo()
 {
    document.forms.form2.action="manpedcoltitar.php";   
    document.forms.form2.submit();
   
     
 }
 
 function genera_evento(Id,Estado,Mail,Nombre,Rol,IdCreador)
{
   ventana=window.open("gen_evento.php?Id="+Id+"&usuario=<? echo $Id_usuario; ?>&Modo=<? echo $Modo;?>&Estado="+Estado+"&Mail="+Mail+"&Nombre="+Nombre+"&RolCreador="+Rol+"&IdCreador="+IdCreador, "Eventos", "dependent=yes,toolbar=no,width=530,height=500,top=20,left=5");
   
 }  

 function rutear_pedidos (TipoPed,Id)
 {

     <?
     	if ($dedonde==1)
     	{
     		$cons = 1;
     	}
     	else
     	{
     		$cons = 2;
     	}
     ?>
     switch (TipoPed)
	  {
	    case 1:
	      ventana=open("verped_col.php?Id="+Id+"&dedonde=<? echo $cons; ?>&Tabla=1","1","scrollbars=yes,width=700,height=450,alwaysLowered");   
	      break;
	    case 2:
	      ventana=open("verped_cap.php?Id="+Id+"&dedonde=<? echo $cons; ?>&Tabla=1","1","scrollbars=yes,width=700,height=450,alwaysLowered");
	      break;
	    case 3:           
          ventana=open("verped_pat.php?Id="+Id+"&dedonde=<? echo $cons; ?>&Tabla=1","1","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;	
       case 4:           
          ventana=open("verped_tes.php?Id="+Id+"&dedonde=<? echo $cons; ?>&Tabla=1","1","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;	
       case 5:           
          ventana=open("verped_con.php?Id="+Id+"&dedonde=<? echo $cons; ?>&Tabla=1","1","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;	
                
	  }
	    
	 return null	
	
 }
</script>

<DIV align=left>
 <form name="form2">
<TABLE borderColor=#111111 cellSpacing=0 cellPadding=0 width=780 bgColor=#efefef 
border=0 Cleaned="border-collapse: collapse">
  <TBODY>
  <TR>
    <TD bgColor=#e4e4e4>
      <HR color=#e4e4e4 SIZE=1>

      <DIV align=center>
      <CENTER>
      <TABLE borderColor=#111111 cellSpacing=5 cellPadding=0 width=760 
      bgColor=#e4e4e4 border=0 Cleaned="border-collapse: collapse">
        <TBODY>
        <TR>
          <TD vAlign=top>
            <DIV align=center>
            <CENTER>
            <TABLE cellSpacing=1 cellPadding=1 width="95%" align=center 
            bgColor=#ececec border=0>
              <TBODY>
              <TR bgColor=#006699>
                <TD class=style33 height=20 align="left"><SPAN class=style34><IMG height=8 src="../images/square-lb.gif" width=8> <? echo $Mensajes["tf-10"]; ?> </SPAN></TD></TR>
              <TR vAlign=center align=left>
                <TD class="style22">
                  <DIV class="style33" align=center>
                  <TABLE class="style22" cellSpacing=1 cellPadding=1 width="90%" 
                  align=center border=0>
                    <TBODY>
                    <TR>
                      <TD class="style22" width=120>
                        <DIV align=right><? echo $Mensajes["tf-2"]; ?></DIV></TD>
                      <TD class="style33">
                        <DIV align=left><INPUT TYPE="text" NAME="Texto" SIZE="27" value="<? echo $Texto; ?>">
                        </DIV></TD></TR>
                    <TR>
                      <TD class="style22" width=120>
                        <DIV align=right></DIV></TD>
                      <TD>
                        <DIV align=left><input type="radio" value="1" name="Lista" <? If (!isset($Lista)) {$Lista="";} If ($Lista==1) { echo " checked"; }?>><? echo $Mensajes["op-1"]; ?>
        <input type="radio" name="Lista" value="2" <? If (!isset($Lista)) {$Lista="";} If ($Lista==2 || $Lista=="") { echo " checked";}?>><? echo $Mensajes["op-2"]; ?><BR><input type="button" value="<? echo $Mensajes["bot-1"]; ?>" name="B1" class="style22" OnClick="Seteo_Modo()">
                        </DIV></TD></TR></TBODY></TABLE></DIV></TD></TR></TBODY></TABLE>
<input type="hidden" name="Id_Usuario" value="<? echo $Id_Usuario; ?>">
<input type="hidden" name="Usuario_C" value="<? echo $Usuario_C; ?>">
<input type="hidden" name="Modo" value=<? echo $Modo; ?>>
<input type="hidden" name="dedonde" value=<? echo $dedonde; ?>>
</form>  
<? if ($Texto!="")
{
?>  

            <HR>
<?
   
   $expresion = armar_expresion_busqueda();
   if ($Bibliotecario>=1)
   {
   	$expresion.="LEFT JOIN Usuarios AS Biblio ON Pedidos.Codigo_Usuario=Biblio.Id "; 
   }
   /*
	 $dedonde = 1 quiere decir que el llamador fue un usuario comun. Sino, es un administrador.

	 $Bibliotecario >=1 dice que tipo de bibliotecario es. Los bibliotecarios, dependiendo del tipo que sean, tienen diferentes visiones (de la universidad, de la facultad, del laboratorio,...)

   */

   $expresion .= "WHERE Titulo_Articulo like '%$Texto%'";

   if ($dedonde==1 && $Bibliotecario>=1)
   {
   	   switch ($Bibliotecario)
    	{
		 case 1:
			$expresion.=" AND Biblio.Codigo_Institucion=".$Instit_usuario;
			break;
		 case 2:
			$expresion.=" AND Biblio.Codigo_Dependencia=".$Dependencia;
			break;
		 case 3:
			$expresion.=" AND Biblio.Codigo_Unidad=".$Unidad;
			break;
	  }	
   }
   elseif ($dedonde==1)
   {
   	 $expresion .= " AND Codigo_Usuario=".$Id_usuario;
   }
   $expresion = $expresion." ORDER BY Titulo_Articulo";

  
   $result = mysql_query($expresion);
   echo mysql_error();
   
 If (!isset($Lista)) {$Lista="";} If ($Lista==2 || $Lista=="")
   {
 ?>  


            <DIV align=left>
            <TABLE cellSpacing=1 cellPadding=0 width="95%" align=center 
            bgColor=#0099cc border=0>
              <TBODY>
              <TR>
                <TD class=style22 height=20><IMG height=8 src="../images/square-w.gif" width=8> 
                  <?  echo $Mensajes["tf-9"]; ?> <SPAN 
                class=style35><? echo mysql_num_rows($result); ?></SPAN></TD></TR></TBODY></TABLE></DIV>
            <? } else { ?>
			<DIV align=left>
            <TABLE cellSpacing=1 cellPadding=0 width="95%" align=center 
            bgColor=#0099cc border=0>
              <TBODY>
              <TR>
                <TD class=style22 height=20><IMG height=8 src="../images/square-w.gif"  width=8> 
                  <?  echo $Mensajes["tf-9"]; ?> <SPAN 
                class=style35><? echo mysql_num_rows($result); ?></SPAN></TD></TR></TBODY></TABLE></DIV>
 <?
   }
 
  
    while($row = mysql_fetch_row($result))
     {
   ?>    
 

 <? If (!isset($Lista)) {$Lista="";} If ($Lista==2 || $Lista =="")
 {
      Dibujar_Tabla_Comp_Cur_Pedidos ($VectorIdioma,$row,$Mensajes); 

 ?>
 
<form name="form3" method="POST"> 
  <p align="center">
  <input type="button" value="<? echo $Mensajes["bot-2"]; ?>" name="B3"  OnClick="rutear_pedidos(<? echo $row[4]; ?>,'<? echo $row[1]; ?>')">
 <? if ($dedonde!=1)
  { ?>
  <input type="button" value="<? echo $Mensajes["bot-3"]; ?>" name="B1" OnClick="genera_evento('<? echo $row[1]; ?>',<? echo $row[36]; ?>,'<? echo $row[46]; ?>','<? echo $row[2].",".$row[3]; ?>',<? echo $row[48];?>,<? echo $row[49];?>)">
 <? }  ?>
  </p>
  <input type="hidden" name="Modo">
  <input type="hidden" name="Lista">
 </form>
<br>
<? } 
   else
   {
         Dibujar_Tabla_Abrev_Cur ($VectorIdioma,$row,$Mensajes); 

 ?>
 <form name="form4" method="POST">  
   <td width="7%" height="17" align="left">
   <input type="button" value="P" name="B3" style="font-family: MS Sans Serif; font-size: 10 px; font-weight: bold" OnClick="rutear_pedidos(<? echo $row[4]; ?>,'<? echo $row[1]; ?>')">
   <? if ($dedonde!=1)
   { ?>
   <input type="button" value="E" name="B1" style="font-family: MS Sans Serif; font-size: 10 px; font-weight: bold" OnClick="genera_evento('<? echo $row[1]; ?>',<? echo $row[36]; ?>,'<? echo $row[46]; ?>','<? echo $row[2].",".$row[3]; ?>',<? echo $row[48];?>,<? echo $row[49];?>)">
   <? } ?> 
   </td>
   </form>
  </tr>
  </table>
  <table border="0" height="3" background="../images/banda.jpg">
  <tr>
   <td width="100%">
   </td>
  </tr>
  </table>
 </form>

<? } 
  } echo "</center>";
    ?>

<?
   mysql_free_result($result);
 }  
 Desconectar();
   
   
?>


			</DIV></TD>
          <TD vAlign=top width=150>
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
				  
				  <a href="<? if ($dedonde==1) { echo "../admin/indexadm.php";} else {echo "../admin/indexadm.php";} ?>"><? echo $Mensajes["tf-8"]; ?></A></span></div>                <div align="center" class="style55"></div></td>
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
						
						
						</TABLE>-->     </DIV></TD></TR></TBODY></TABLE></DIV>

					
 
 
  <tr>
    <td height="44" bgcolor="#E4E4E4"><div align="center">      
      <hr>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" height="43" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50"><div align="right" class="style33">
            <div align="center">adm-003</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
</body>
</html>