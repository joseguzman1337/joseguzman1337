<html>

<head>
<title>Consulta de Noticias y Eventos</title>
<SCRIPT language=JavaScript src="ts_picker.js"></SCRIPT>
</head>

<body background="../imagenes/banda.jpg">

<?
     
    include_once Obtener_Direccion()."conexion.inc.php";  
    Conexion();
  	include_once Obtener_Direccion()."fgenped.php";
	include_once Obtener_Direccion()."fgentrad.php";


 
   $Mensajes = Comienzo ("eno-001",$IdiomaSitio);
   
?>

<script language="JavaScript">
 function confirmar()
 {
 	if (confirm("<? echo $Mensajes["err-1"]; ?>"))
 	{
 		return true
 	}
 	else
 	{
 		return false
 	}
 	
 }
</script>

<P>

<?   
      if (isset($Codigo_Idioma))
      {
         $expresion = "SELECT Id FROM Idiomas WHERE Predeterminado=1";
         $result = mysql_query($expresion);
         $vect = mysql_fetch_row($result);
         $Codigo_Idioma = $vect[0];
       }  
	   else
	     $Codigo_Idioma = 1;


		if (!isset($operacion))
		   $operacion = 0;
	   if ($operacion==2)
   		{
   			$expresion = "DELETE FROM Noticias WHERE Id=".$Id;
		   $result = mysql_query($expresion);
   		
   		}
   
	   $expresion = "SELECT Titulo,Texto_Noticia,Fecha,Id FROM Noticias";
	   $expresion = $expresion." WHERE ";
   
  		if ($Inicio!="" && $Fin!="")
	   {
   		  $expresion = $expresion." Fecha>='".$Inicio."'";
	     $expresion = $expresion." AND Fecha<='".$Fin."' AND ";  	    	      
   		}
       $expresion = $expresion." Codigo_Idioma=".$Codigo_Idioma;
      
   $expresion = $expresion." ORDER BY Fecha DESC";
   $result = mysql_query($expresion);
    $filas = mysql_num_rows($result);
  
    if ($fila_actual!=0)
  	  {             
       if (!mysql_data_seek ($result,$fila_actual))
       {
       }
      }  
?>


<div align="center">
  <center>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td width="24%" valign="top">
  <div align="left">
    <table border="0" width="100%" cellspacing="0" cellpadding="0" height="1">
      <tr>
        <td width="153%" bgcolor="#0099CC" align="left" height="23" nowrap colspan="4">
          <p align="center"><font face="MS Sans Serif" size="1" color="#FFFFFF"><? echo $Mensajes["tf-1"]; ?></font>
        </td>
      </tr>
      <tr>
        <td width="39%" bgcolor="#0099CC" align="left" height="1" nowrap>
          &nbsp;
        </td>
        <td width="63%" bgcolor="#0099CC" height="1" colspan="2">
          &nbsp;
      </td>
        <td width="51%" bgcolor="#0099CC" height="1">
          &nbsp;
      </td>
      </tr>
      <tr>
      
         <form method=post name='dateForm' action="<?echo $_SERVER['PHP_SELF']."?Inicio=".$Inicio."&Fin=".$Fin."&fila_actual=0";?>">
         <td width="39%" bgcolor="#0099CC" align="left" height="23" nowrap>
          <p align="center"><font face="MS Sans Serif" size="1" color="#FFFF99"><? echo $Mensajes["tf-2"]; ?>&nbsp;</font>
         </td>
         <td width="70%" bgcolor="#0099CC" height="23" colspan="2">
          <p align="left"><font face="MS Sans Serif" size="1"><b><input type="text" style='width:70' name="Inicio" <? if ($Inicio!="") 
		                     echo "value='".$Inicio."'";
						   ?> size="10"><a href="javascript:show_calendar('document.dateForm.Inicio',%20document.dateForm.Inicio.value);"><img src='cal.gif' border=0 width='20' height='20'></a> </b> </font> 
         </td>
         <td width="51%" bgcolor="#0099CC" height="23"></td>
         </tr>
         <tr>
         <td width="39%" bgcolor="#0099CC" align="left" height="23" nowrap>
          <p align="center"><font face="MS Sans Serif" size="1" color="#FFFF99"><? echo $Mensajes["tf-3"]; ?></font></p>
         </td>
         <td width="63%" bgcolor="#0099CC" height="23" colspan="2">
          <p align="left"><font face="MS Sans Serif" size="1"><b><input type="text" name="Fin" style='width:70' <? if ($Fin !='')
		                   echo "value='".$Fin."'"; ?>
		  size="10" ><a href="javascript:show_calendar('document.dateForm.Fin',%20document.dateForm.Fin.value);"><img src='cal.gif' border=0 width='20' height='20'></a> </b> </font> 
         </td>         
        <center>
        <td width="51%" bgcolor="#0099CC" height="23">
          &nbsp;
      </td>
      </tr>     
      <tr>
        <td width="20%" bgcolor="#0099CC" align="left" height="1">
        </td>
        <td width="19%" bgcolor="#0099CC" align="left" height="1">
         <select size="1" name="Codigo_Idioma">
         <?
          $Instruccion = "SELECT Id,Nombre,Predeterminado FROM Idiomas ORDER BY Nombre";	
          $result2 = mysql_query($Instruccion); 
          
          while ($rowx =mysql_fetch_row($result2))
          { 
          	   $cadena="<option value=";
				$cadena2=" selected";
				$signo=">";
				$cadena3="</option>";
				
				 if ($rowx[0]==$Codigo_Idioma || ($Codigo_Idioma=="" && $rowx[2]==1)) 
				 { 
				    echo $cadena.$rowx[0].$cadena2.$signo.$rowx[1].$cadena3; 
				    
      			 } else {	
             
          		    echo $cadena.$rowx[0].$signo.$rowx[1].$cadena3; 

                }  
              } ?> 	       
           </SELECT>
        </td>
        <td width="39%" bgcolor="#0099CC" align="left" height="1" colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td width="39%" bgcolor="#0099CC" align="left" height="1" colspan="2">
        &nbsp;</td>
        <td width="39%" bgcolor="#0099CC" align="left" height="1" colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td width="39%" bgcolor="#0099CC" align="center" height="1" colspan="3">
        <input type="submit" style="background-color:9DC1C6;color:black;font-size:10pt;width:90;font-weight:bold" value="<? echo $Mensajes["bot-1"]; ?>" name="B1"></td>
        <td width="39%" bgcolor="#0099CC" align="left" height="1" colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td width="39%" bgcolor="#0099CC" align="center" height="1" colspan="3"> </td>
        <td width="39%" bgcolor="#0099CC" align="left" height="1" colspan="2">&nbsp;</td>
      </tr>

       </form>
       
 </table>
 </center>
</div>
      <p>&nbsp;</td>
    <td width="4%" valign="top" align="left">
    </td>
  </center>
    <td width="72%" align="left">
<div align="left">
<table border="0" width="80%" cellspacing="0" cellpadding="0" height="45">
  <tr>
    <td width="1%" align="center" bgcolor="#0099CC">
      <p align="left">&nbsp;</p>
    </td>   
    <td width="95%" align="center" bgcolor="#0099CC">
      <p align="left"><font face="MS Sans Serif" size="1" color="#FFFFFF"><? echo $Mensajes["tf-4"]; ?>
      <?
       $numerito=(int)($fila_actual/5)+1;
       echo $numerito." ".$Mensajes["tf-5"]." <b>".$Inicio."</b> ".$Mensajes["tf-6"]." <b>".$Fin."</b>";
       ?>
      </font>
    </td>   
  </tr>
  <center>

  <tr>
    <td width="2%" align="left" bgcolor="#0099CC">
      &nbsp;
    </td>   
    <td width="58%" align="left" bgcolor="#0099CC">
    <font face="MS Sans Serif" size="1"><b>
    <?
    	if ($fila_actual>=5)
    	{
    	 $filita=$fila_actual-5;
    	 echo "<a href=".$PHP_Self."?Inicio=".$Inicio."&Fin=".$Fin."&fila_actual=".$filita.">".$Mensajes["h-5"]."</a>-";
    	} 
    	
    	$cociente = ($filas / 5);
    	if ($filas%5>0)
    	{ 
    	  $cociente+=1;
    	}  
    	 
    	$filita=0;
    	for ($i=1;$i<=$cociente;$i++)
    	{
    		echo "<a href=".$_SERVER['PHP_SELF']."?Inicio=".$Inicio."&Fin=".$Fin."&fila_actual=".$filita.">".$i."</a>-";
    		$filita+=5;
    	}    	
  	
     	if ($fila_actual+5<=$filas)
    	{
    	 $filita=$fila_actual+5;
    	 echo "<a href=".$_SERVER['PHP_SELF']."?Inicio=".$Inicio."&Fin=".$Fin."&fila_actual=".$filita.">".$Mensajes["h-6"]."</a>";
    	} 

    	
    ?></b></font>  
    </td>   
  </tr>
  
</table>
</div>
</center>  
<p align="left"><a href="../abajo.php"><font face="MS Sans Serif" size="1"><? echo $Mensajes["h-7"]; ?><br>
<br>
</font></a><?
     $contador=0; 
     while($row = mysql_fetch_row($result) and $contador<=4)
     {
   ?>
  <center>

<center>
<div align="left">
<table border="0" width="80%" cellspacing="0" cellpadding="0">
  <tr>
    <td width="3%" bgcolor="#FFFFCC" height="25">&nbsp;</td>
    <td width="94%" bgcolor="#FFFFCC" height="25"><font face="MS Sans Serif" size="1"><b><? echo
      $row[0];?></font></b></td>
	<td width="3%" bgcolor="#FFFFCC" height="25">&nbsp;</td>  
  </tr>
  <tr>
    <td width="3%" bgcolor="#99CCFF" height="55" valign="top">&nbsp;</td>
    <td width="94%" bgcolor="#99CCFF" height="55" valign="top"><font face="MS Sans Serif" size="1"><?echo $row[1];?></font></td>
	<td width="3%" bgcolor="#99CCFF" height="55" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="3%" height="20" bgcolor="#9DC1C6">&nbsp;</td>
    <td width="94%" height="20" bgcolor="#9DC1C6"><font face="MS Sans Serif" size="1"><b><?echo $row[2];?></b></font></td>
    <td width="3%" height="20" bgcolor="#9DC1C6">&nbsp;</td>
  </tr>
  <tr>
    <td width="3%" height="20" align="center" bgcolor="#9DC1C6">&nbsp;</td>
    <td width="94%" height="20" align="center" bgcolor="#9DC1C6">&nbsp;</td>
    <td width="3%" height="20" align="center" bgcolor="#9DC1C6">&nbsp;</td>
  </tr>
</table>
</div>
</center>
<br>
    <?
    $contador +=1;
    }
    ?></center>  
</table>
  &nbsp;
</div>

<P ALIGN="center">

<?
   mysql_free_result($result);
   Desconectar();
?><BR>
<FONT FACE="MS Sans Serif" SIZE="1"><FONT COLOR="#000080">cp:</FONT>eno-001</FONT>
</body>

