<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>PrEBi </title>
<SCRIPT language=JavaScript src="ts_picker.js"></SCRIPT>
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
a.style33 {
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
.style35 {color: #CCCCCC}
.style36 {color: #666666}
.style37 {font-size: 11px; font-family: verdana;}
-->
</style>
<base target="_self">
</head>

<body topmargin="0">
<?
include_once "../inc/var.inc.php";
include_once "../inc/conexion.inc.php";  
    Conexion();
include_once "../inc/fgenped.php";
include_once "../inc/fgentrad.php";

global $IdiomaSitio;
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
<?   

	    $cantidad=2; // cantidad de resultados por p?ina
		if (! isset($fila_actual))
			{
				$inicial=0;
				$fila_actual =1;
			}
		else
			{
			$inicial = ($fila_actual-1) * $cantidad;
			
			}

	
      if (!isset($Codigo_Idioma))
      {
         $expresion = "SELECT Id FROM Idiomas WHERE Predeterminado=1";
         $result = mysql_query($expresion);
         $vect = mysql_fetch_row($result);
         $Codigo_Idioma = $vect[0];
       }  
      if (!isset($operacion)) {$operacion = 0; }
	  if (!isset($Inicio)) {$Inicio = 0; }
	  if (!isset($Fin)) {$Fin = 0; }
	   if ($operacion==2)
   		{
   			$expresion = "DELETE FROM Noticias WHERE Id=".$Id;
		   $result = mysql_query($expresion);
   		
   		}
   
	   $expresion = "SELECT Titulo,Texto_Noticia,Fecha,Id FROM Noticias";
	   $expresion = $expresion." WHERE ";
	   $ok=false;
		if ($Inicio!=""  && $Inicio != "0" )
	   {
   		  $expresion = $expresion." Fecha>='".$Inicio."'";
		  $ok=true;

   		}

		if ($Fin!=""  && $Fin != "0" )
	   {
		   if ($ok )
			   $expresion.=" and ";
   		  $expresion .=" Fecha<='".$Fin."'";
		  $ok=true;

   		}
		if ($ok)
			$expresion.=" and ";		
       $expresion = $expresion." Codigo_Idioma=".$Codigo_Idioma;
     
   $expresion = $expresion." ORDER BY Fecha DESC";
   
   
   $result = mysql_query($expresion);
   $filas = mysql_num_rows($result);
   
    if ($inicial >= 0)
  	  {             	
	
       if (!mysql_data_seek ($result,($inicial)))
       {
       }
      }  

	$total_records= mysql_num_rows($result);
?>


<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <div align="center">
        <center>
		<form method=post name='dateForm' action="<?echo $_SERVER['PHP_SELF']."?Inicio=".$Inicio."&Fin=".$Fin."&fila_actual=1";?>">
      <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr>
        <td valign="top">            <div align="center">
              <center>
                <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ECECEC">
                  <tr bgcolor="#006699">
                    <td height="20" colspan="2" class="style33"><span class="style34"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["tit-1"]?> </span><div align="right" class="style34 style35"></div></td>
                    </tr>
                  <tr align="left" valign="middle">
                    <td height="20" colspan="2" class="style22"><div align="center" class="style33"><? echo $Mensajes["tf-1"]; ?></div></td>
                    </tr>
                  <tr align="left" valign="middle">
                    <td width="250" height="20" class="style22">                      
                      <div align="right"><? echo $Mensajes["tf-2"]; ?>
                      </div></td>
                    <td class="style22"><div align="left">
                      <input type="text" name="Inicio" style='width:70' class="style22" size="10" <? if ($Inicio!="") 
		                     echo "value='".$Inicio."'";?>
							 ><a href="javascript:show_calendar('document.dateForm.Inicio',document.dateForm.Inicio.value);">
					  <img border="0" src="../images/calendar.gif" width="16" height="16"></a></div></td>
                  </tr>
                  <tr align="left" valign="middle">
                    <td width="250" height="20" class="style22"><div align="right"><? echo $Mensajes["tf-3"]; ?>
                          
                    </div></td>
                    <td height="20" class="style22"><div align="left">
                      <input type="text" class="style22" name="Fin" style='width:70' size="10" <? if ($Fin!="") 
		                     echo "value='".$Fin."'";?>
							 ><a href="javascript:show_calendar('document.dateForm.Fin',document.dateForm.Fin.value);">
					  <img src="../images/calendar.gif" width="16" height="16" border="0"></a></div></td>
                  </tr>
                  <tr valign="middle">
                    <td width="250" height="20" align="right" class="style22"><div align="center">
                    </div></td>
                    <td height="20" align="right" class="style22"><div align="left">
                      <select size="1" name="Codigo_Idioma" class="style22">
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
                    </div></td>
                  </tr>
                  <tr valign="middle">
                    <td width="250" height="20"><div align="center">
                    </div></td>
                    <td height="20">
					<input type="submit" class="style22"  value="<? echo $Mensajes["bot-1"]; ?>" name="B1">
					</td>
                  </tr>
                </table>
                <hr>
				<p><span class="style33"><?  
         
		 $pages = ceil($total_records / $cantidad);
		 
    	 $decena_actual= intval( $fila_actual / 10);
		 if ($decena_actual ==0)
			$decena_actual = 0.1; // Para el caso de que este el la decena 0
		 $desde = $decena_actual * 10; // Calculo de la pagina inicial
		 $fin_decena= $desde + 9;
		 if ($pages > $fin_decena)
					$hasta= $fin_decena;
			    else
				    $hasta = $pages;

		if ($fila_actual > 1)
					{
						$url = $fila_actual - 1;
						echo "<a class='style33' style='color: #006699;' href='".$PHP_SELF."?Inicio=".$Inicio."&Fin=".$Fin."&fila_actual=".$url."'>&lt;&lt;&nbsp;</a>";
					}
		 for ($i = $desde; $i<=$hasta ; $i++) {
			
			if ($i == $fila_actual)  
					{   
						if ($total_records > $cantidad)
						echo "<strong>$i</strong>";						

					}
					else 
						{
							echo "<a class='style33' style='color: #006699;' href='".$PHP_SELF."?Inicio=".$Inicio."&Fin=".$Fin."&fila_actual=".$i."'>".$i."</a>&nbsp;";
						}
			if (($i+1) <= $hasta )
							echo "&nbsp;|&nbsp;";
							
					
		 }
		 
		if ($fila_actual < $pages)
						{
							$url = $fila_actual + 1;
		 					echo "<a class='style33' style='color: #006699;' href='".$PHP_SELF."?Inicio=".$Inicio."&Fin=".$Fin."&fila_actual=".$url."'>&gt;&gt;</a>";
						}
						
    ?> </span></p>
	<?
     $contador=0; 
     while($row = mysql_fetch_row($result) and $contador<$cantidad)
     {  
   ?>
                <table width="95%"  border="0" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
                  <tr>
                    <td height="20" colspan="2" bgcolor="#0099CC" class="style34"><img src="../images/square-w.gif" width="8" height="8"><?echo $row[0];?></td>
                  </tr>
                
				  <tr>
                    <td colspan="2" class="style22"><div align="left"><?echo $row[1];?></div></td>
                  </tr>
                  <tr class="style33">
                    <td><div align="center" class="style33"><?echo $row[2];?></div></td>
                    <td><div align="center" class="style33"><a href="form_noticia.php?operacion=1&Id=<? echo $row[3]; ?>"><? echo $Mensajes["h-3"]; ?></a> |<a href="elige_not.php?operacion=2&Id=<? echo $row[3]; ?>" onClick="return confirmar()"><? echo $Mensajes["h-4"]; ?></a></div></td>
                    </tr>
                </table>
                <hr>
        <? $contador++;}?>
			   <!-- paginado -->
				   <p><span class="style33"><?  
					 
					 $pages = ceil($total_records / $cantidad);
					 
					 $decena_actual= intval( $fila_actual / 10);
					 if ($decena_actual ==0)
						$decena_actual = 0.1; // Para el caso de que este el la decena 0
					 $desde = $decena_actual * 10; // Calculo de la pagina inicial
					 $fin_decena= $desde + 9;
					 if ($pages > $fin_decena)
								$hasta= $fin_decena;
							else
								$hasta = $pages;

					if ($fila_actual > 1)
								{
									$url = $fila_actual - 1;
									echo "<a class='style33' style='color: #006699;' href='".$PHP_SELF."?Inicio=".$Inicio."&Fin=".$Fin."&fila_actual=".$url."'>&lt;&lt;&nbsp;</a>";
								}
					 for ($i = $desde; $i<=$hasta ; $i++) {
						
						if ($i == $fila_actual)  
								{   
									if ($total_records > $cantidad)
									echo "<strong>$i</strong>";						

								}
								else 
									{
										echo "<a class='style33' style='color: #006699;' href='".$PHP_SELF."?Inicio=".$Inicio."&Fin=".$Fin."&fila_actual=".$i."'>".$i."</a>&nbsp;";
									}
						if (($i+1) <= $hasta )
										echo "&nbsp;|&nbsp;";
										
								
					 }
					if ($fila_actual+1 < $pages)
									{
										$url = $fila_actual + 1;
										echo "<a class='style33' style='color: #006699;' href='".$PHP_SELF."?Inicio=".$Inicio."&Fin=".$Fin."&fila_actual=".$url."'>&gt;&gt;</a>";
									}
									
				?> </span></p>
              </center>
            </div>            </td>
        <td width="150" valign="top"><div align="center" class="style22">
          <div align="left">
            <table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td bgcolor="#ECECEC"><div align="center">
                  <p><img src="../images/image001.jpg" width="150" height="118"><br>
                    <span class="style33"><a href="../admin/indexadm.php"><? echo $Mensajes["h-1"]; ?></a></span></p>
                  </div>                  </td>
              </tr>
            </table>
            </div>
        </div></td>
        </tr>
    </table>    </center>
      </div>    </td>
  </tr>
   
  <tr>
    <td height="44" bgcolor="#E4E4E4"><div align="center">      
      <hr>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" height="43" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50"><div align="right" class="style33">
            <div align="center">eno-001</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
</body>
</html>