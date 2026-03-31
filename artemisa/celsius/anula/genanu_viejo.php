<?
   include_once "../inc/"."var.inc.php";
   include_once "../inc/conexion.inc.php";  
   Conexion();	
   include_once "../inc/identif.php"; 
   Administracion();
   
 ?>

<html>

<head>
<title>PrEBi</title>
</head>
<body>
<? 
   include_once "../inc/fgenped.php";
   include_once "../inc/fgentrad.php";
   
   global $IdiomaSitio;
   $Mensajes = Comienzo ("gen-anu",$IdiomaSitio); 
   
   
 ?>
 
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
	      form1.action = "reganuped.php";		 
	 <?
	      break;
		case 3:
	 ?>
	      form1.action = "reganueve.php";
	<?	   break;
		 case 5:
	?>	 
		   form1.action = "reganupedh.php";		     
	 <?}?>
     form1.submit();
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
	  	
	}
  
?>
<div align="center">
  <center>
 <form method="POST" name="form1" OnSubmit="return false">
  <table border="0" width="499" bgcolor="#D20000" height="111" cellspacing="0">
    <tr>
      <td width="364" colspan="4" height="22"><font face="MS Sans Serif" size="1" color="#FFFFCC">&nbsp;&nbsp;&nbsp; </font><b><font face="MS Sans Serif" size="1" color="#FFFF00"><? echo $Mensajes["ec-1"]; ?>&nbsp;
        </font><font face="MS Sans Serif" size="1" color="#00FFFF">
		 <? if ($dedonde==2){
		     echo $row[2].",".$row[3]; }
			else {
			 echo $Usuario; }  ?> 
		</font> </b> </td>
    </tr>
    <tr>
      <td width="107" height="27" align="right"><font face="MS Sans Serif" size="1" color="#FFFFCC"><? echo $Mensajes["tf-1"]; ?></font></td>
      <td width="371" height="27" colspan="3">
      <input type="text" name="Fecha_Anulacion" size="15" value="<? echo $FechaHoy; ?>">
    </tr>
    <tr>
      <td width="107" height="27" align="right" valign="top">
        <p><font face="MS Sans Serif" size="1" color="#FFFFCC"><? echo $Mensajes["tf-2"]; ?></font>
        </p>
      </td>
      <td width="371" height="27" colspan="3">
      <textarea rows="13" name="Causa_Anulacion" cols="41"><? echo $row[1]; ?></textarea>

    </tr>
    <tr>
      <td width="107" height="27" align="right">&nbsp;</td>
      <td width="2" height="27">
      &nbsp;
      <td width="370" height="27" colspan="2">
      <input type ="hidden" name="Id_Pedido" value="<? echo $Id_Pedido;?>">
	  <!-- Este hidden le sirve solo cuando es llamado para anular el evento-->
	  <input type="hidden" name="Id_Evento" value="<? echo $Id_Evento; ?>">
	 <? 
     if ($dedonde==1 || $dedonde==5)
	 { ?>
      <input type="submit" value="<? echo $Mensajes["bot-1"]; ?>"
      name="B1"; style="font-family: MS Sans Serif; font-size: 10 px; font-weight: bold" OnClick="valida_entrada()">
	<?
	  }
	 if ($dedonde==3)
	 {
	 ?>
	  <input type="submit" value="<? echo $Mensajes["bot-1"]; ?>"
      name="B1"; style="font-family: MS Sans Serif; font-size: 10 px; font-weight: bold" OnClick="valida_entrada()">
	 <? } ?> 
      <input type="button" value="<? echo $Mensajes["bot-2"]; ?>" name="B2" style="font-family: MS Sans Serif; font-size: 10 px; font-weight: bold" OnClick="javascript:self.close()"></center>&nbsp;

    </tr>
    <tr>
      <td width="107" height="27" align="right">&nbsp;</td>
      <td width="2" height="27">
      &nbsp;
      <td width="316" height="27">
      <font face="MS Sans Serif" size="1"><font color="#FFFFFF">cp:</font><font color="#FFFFCC">gen-anu</font></font>

      <td width="54" height="27">
      &nbsp;

    </tr>
  </table>
  </form>
</div>

    <? 
		if ($dedonde!=1)
		{
			mysql_free_result($result);
		}
           Desconectar();
    ?>



</body>

</html>

















