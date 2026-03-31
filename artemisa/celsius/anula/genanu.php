<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?
   include_once "../inc/"."var.inc.php";
   include_once "../inc/conexion.inc.php";  
   Conexion();	
   include_once "../inc/identif.php"; 
   Administracion();
   include_once "../inc/fgenped.php";
   include_once "../inc/fgentrad.php";
  
   global $IdiomaSitio;
   $Mensajes = Comienzo ("gen-anu",$IdiomaSitio); 
?>

<title>PrEBi</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
	color: #006599;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #006599;
}
a:hover {
	text-decoration: underline;
	color: #0099FF;
}
a:active {
	text-decoration: none;
	color: #006599;
}
.style7 {color: #2D6FAC; font-size: 10px; }
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 9px; }
.style14 {
	font-size: 10px;
	font-family: Verdana;
	color: #FFFFFF;
}
.style15 {color: #006599}
.style17 {
	font-size: 9px;
	font-family: Verdana;
	color: #000000;
}
.style18 {color: #006699}
.style20 {color: #E4E4E4}
.style23 {font-size: 10}
.style24 {
	color: #000000;
	font-size: 9px;
	font-family: verdana;
}
.style26 {color: #006699; font-weight: bold; }
.style28 {font-size: 11px}
-->
</style>
<script language="JavaScript">
function valida_entrada()
{
   expresion=/^\d{4}-\d{1,2}-\d{1,2}$/;
	if (!expresion.exec(document.forms.form1.elements.Fecha_Anulacion.value))
	{
	  alert ("<? echo $Mensajes["me-1"]; ?>");
	  return false;	  
	}
	
	if (document.forms.form1.elements.Causa_Anulacion.value=="")
	{
	  alert ("<? echo $Mensajes["me-2"]; ?>");
	  return false;	  
	}
	
	if (confirm ("<? if ($dedonde==1) { echo $Mensajes["con-1"];} else { echo $Mensajes["con-2"]; } ?>"))
	{
	
	<?
	
	switch ($dedonde)	  
	  {
	    case 1:
	?>
	      document.forms.form1.action = "reganuped.php";		 
	 <?
	      break;
		case 3:
	 ?>
	      document.forms.form1.action = "reganueve.php";
	<?	   break;
		 case 5:
	?>	 
		   document.forms.form1.action = "reganupedh.php";		     
	 <?}?>
     document.forms.form1.submit();
     return true;
    }
    else
    {
    	return false;
    } 
}

</script>    
<?
  
    $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
    $Dia = date ("d");
    $Mes = date ("m");
    $Anio = date ("Y");
    $FechaHoy =$Anio."-".$Mes."-".$Dia;
	
	// dedonde puede ser 1 para anular pedidos
	// 2 para consultar anulaciones de Pedidos
	// 3 para anular eventos
	// 4 para consultar anulaciones de eventos
	
	switch ($dedonde)
	{
	   case 2:
		$Instruccion = "SELECT Fecha_Anulacion,Causa_Anulacion,Usuarios.Apellido,Usuarios.Nombres";
		$Instruccion .= " FROM PedAnula LEFT JOIN Usuarios ON";
		$Instruccion .= " Usuarios.Id = PedAnula.Operador_Anula";
		$Instruccion .= " WHERE PedAnula.Id ='".$Id."'";
		$result = mysql_query ($Instruccion);
		echo mysql_error();
		$row = mysql_fetch_row($result);
		$FechaHoy = $row[0];
		break;
	  case 4:
	    $Instruccion = "SELECT Fecha_Anulacion,Causa_Anulacion,Usuarios.Apellido,Usuarios.Nombres";
		$Instruccion .= " FROM EvAnula LEFT JOIN Usuarios ON";
		$Instruccion .= " Usuarios.Id = EvAnula.Operador_Anulacion";
		$Instruccion .= " WHERE EvAnula.Id =".$Id."";
		$result = mysql_query ($Instruccion);
		echo mysql_error();
		$row = mysql_fetch_row($result);
		$FechaHoy = $row[0];
      default: { $row=array('','','',''); }
	  	
	}
  
?>

<base target="_self">
</head>

<body topmargin="0">
<div align="left">

  <table width="780" border="0" align="left" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#E4E4E4" style="border-collapse: collapse">
  <tr>
    <td valign="top" bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <span align="center">
        <center>
          <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#E4E4E4">
        <td valign="top" bgcolor="#E4E4E4">
            <span align="center">
              <center>
                <table width="97%" border="0" style="margin-bottom: 0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
              <tr>
                <td class="style17" align=left><blockquote>
                  <p class="style17 style23"><span class="style28"> <? echo $Mensajes["ec-1"]; ?> <span class="style26">
				  <? if ($dedonde==2){
		     echo $row[2].",".$row[3]; }
			else {
			 echo $Usuario; }  ?> 
			 </span> </span></p>
                          <p class="style17 style28">

 <form method="POST" name="form1" OnSubmit="return false">
                          
                          <table valign="top">
                            <tr>
                             <td width=20% align=left valign="top">
                               <? echo $Mensajes["tf-1"]?> </td> <td align=left>  <input type="text" name="Fecha_Anulacion" class="style24" value="<? echo $FechaHoy; ?>">
                             </td>
                            <tr> <td valign="top"><? echo $Mensajes["tf-2"]; ?>
                            </td> <td align=left>
    						 <textarea name="Causa_Anulacion" cols=30 rows=5 class="style24"><? echo $row[1]; ?></textarea>
							 <script> document.forms.form1.Causa_Anulacion.focus(); </script>
                            </td>
                            </tr>
					
                            <tr td align=center><td> &nbsp;</td> <td colspan>
					      <input type ="hidden" name="Id_Pedido" value="<? echo $Id_Pedido;?>">
						  <!-- Este hidden le sirve solo cuando es llamado para anular el evento-->
						  <input type="hidden" name="Id_Evento" value="<? echo $Id_Evento; ?>">
							 <? 
						     if ($dedonde==1 || $dedonde==5)
							 { ?>
						      <input type="submit" value="<? echo $Mensajes["bot-1"]; ?>"
						      name="B1"; class="style24" OnClick="valida_entrada()">
								<?	
								  }
							 if ($dedonde==3)
							 {
							 ?>
							  <input type="submit" value="<? echo $Mensajes["bot-1"]; ?>"
						      name="B1"; class="style24" OnClick="valida_entrada()">
								 <? } ?> 

						      <input type="button" value="<? echo $Mensajes["bot-2"]; ?>" name="B2" class="style24"  OnClick="javascript:self.close()"></center>&nbsp;


                            </td> </tr> </table>
                          </form> </p>
                           <br>
                            </span><br>
                            </p>
                                
                  </blockquote></td>
              </tr>
            </table>
              </center>
            </span>            </td>

        </div>
          </td>
          <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
            <table width="100%" bgcolor="#ececec">
            <tr>
              <td class="style28"><span class="style55"><img src="../images/image001.jpg" width="150" height="118"></span></td>
            </tr>
          </table>
          </div>
          </td>
        </tr>
    </table>    </center>    </td>
    

  </tr>

  <tr>
    <td height="44" bgcolor="#E4E4E4">
     <font face="Arial">
      <center>
        <hr>
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50">&nbsp;</td>
            <td width="50"><div align="center" class="style17">
              <div align="right" class="style18">
                <div align="center">cou-001</div>
              </div>
            </div></td>
          </tr>
        </table>
        <a href='http://www.unlp.istec.org/prebi' target=_BLANK border=0>
        </a>
      </center>
     </font>
    </td>
  </tr>
</table>
</div>

</body>
</html>
