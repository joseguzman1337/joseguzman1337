
<? 

 include "../inc/"."conexion.inc.php";  
 Conexion();

 include "../inc/"."identif.php";
 Usuario();
 	
?> 

<html>

<head>
<title>Consulta de Pedidos</title>
</head>

<body background="../imagenes/banda.jpg">
<? 
  include "../inc/"."fgenped.php";
  include "../inc/"."fgentrad.php";
  include "../inc/"."tabla_ped.inc";
  
    
   $Mensajes = Comienzo ("adm-002",$IdiomaSitio);
   $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
   
?>

<script language="JavaScript">
 function Confirma_Pedido(Id)
{
   form1.action="opera_ped.php";
   form1.Resp.value=1;
   form1.Id.value = Id;
   form1.submit();
   
 }  

 function Cancela_Pedido(Id)
{
   form1.action="opera_ped.php";
   form1.Resp.value=0;
   form1.Id.value= Id;
   form1.submit();
 }  

 function rutear_pedidos (TipoPed,Id)
 {
    
	  switch (TipoPed)
	  {
	    case 1:
	      ventana=open("verped_col.php?Id="+Id+"&dedonde=1&Tabla=1","Colecciones","scrollbars=yes,width=700,height=450");   
	      break;
	    case 2:
	      ventana=open("verped_cap.php?Id="+Id+"&dedonde=1&Tabla=1","Libros","scrollbars=yes,width=700,height=450");
	      break;
	    case 3:           
          ventana=open("verped_pat.php?Id="+Id+"&dedonde=1&Tabla=1","Patentes","scrollbars=yes,width=700,height=450");
          break;	      
        case 4:           
          ventana=open("verped_tes.php?Id="+Id+"&dedonde=1&Tabla=1","Tesis","scrollbars=yes,width=700,height=450");
          break;	      
		 case 5:           
          ventana=open("verped_con.php?Id="+Id+"&dedonde=1&Tabla=1","Congresos","scrollbars=yes,width=700,height=450");
          break;	      
   
	  }
	    
	 return null	
	
 }
</script>

<P>

<?
 if ($Bibliotecario>=1)
 {
 ?>
 
<form name="form2" action="manpedcur.php">
  <table border="0" width="75%" height="4" bgcolor="#0083AE" cellspacing="0" align="center">
    <tr>
      <td width="40%" height="1" align="center">
        <p align="right"><b><font face="MS Sans Serif" size="1" color="#FFFFCC">&nbsp;&nbsp;&nbsp;</font>
        </b>
      </td>
      <td width="108%" height="1" align="center" colspan="3">
        &nbsp;
      </td>
    </tr>
  <center>
    <tr>
      <td width="40%" height="1" align="center">
        <font face="MS Sans Serif" size="1" color="#FFFFCC"><? echo $Mensajes["tc-3"]; ?></font>
      </td>
	  </center>
      <td width="37%" height="1" align="center">
        
        <p align="left"><b>
        <font face="MS Sans Serif" size="1" color="#FFFFCC">
        <select size="1" name="Id_Entrega" style="font-family: MS Sans Serif; font-size: 10 px">
        <?   
		   $expresion = "SELECT Usuarios.Id,Usuarios.Apellido,Usuarios.Nombres,COUNT(*) ";
   		   $expresion .= "FROM Pedidos ";
		   $expresion .= "LEFT JOIN Usuarios ON Pedidos.Codigo_Usuario = Usuarios.Id ";
		   if ($dedonde==0)
   		   {
     			$expresion = $expresion."WHERE (Pedidos.Estado<=3 OR Pedidos.Estado=5)";
				
    	   }
   		   else
   		   {
     			$expresion = $expresion."WHERE (Pedidos.Estado=6 OR Pedidos.Estado = ".Devolver_Estado_SolicitarPDF().")";
			}  
			
			// Con la modificación del 25-4 solo ve los pedidos
			// creados por el
		    switch ($Bibliotecario)
			{
					case 1:
						$expresion.=" AND Usuarios.Codigo_Institucion=".$Instit_usuario;
						break;
					case 2:
						$expresion.=" AND Usuarios.Codigo_Dependencia=".$Dependencia;
						break;
					case 3:
						$expresion.=" AND Usuarios.Codigo_Unidad=".$Unidad;
						break;
			}	
		   $expresion .=" AND Tipo_Usuario_Crea=2 GROUP BY Pedidos.Codigo_Usuario ORDER BY Usuarios.Apellido,Usuarios.Nombres";
		   
 			$result = mysql_query($expresion);
   			echo mysql_error();

			while($row = mysql_fetch_row($result))
		   { 
			
			if ($Id_Entrega==$row[0])
			{
			 ?>
           <option selected value="<? echo $row[0]; ?>"><? echo $row[1].",".$row[2]." [".$row[3]."]"; ?></option>  
          <?
            } else { ?>
			<option value="<? echo $row[0]; ?>"><? echo $row[1].",".$row[2]." [".$row[3]."]"; ?></option>               
          <? }
           } ?> 
            </select></font></b></p>
                
      </td>
      <td width="18%" height="1" align="center">
        
        <p align="left"><font face="MS Sans Serif" size="1" color="#FFFFCC"><input type="submit" value="<? echo $Mensajes["bot-1"]; ?>" name="B1" style="font-family: MS Sans Serif; font-size: 10 px; font-weight: bold"></font></p>
        
      </td>
      <td width="18%" height="1" align="center">
        
        &nbsp;
        
      </td>
    </tr>
    <tr>
      <td width="40%" height="1" align="center">
        &nbsp;<input type="hidden" name="dedonde" value="<? echo $dedonde; ?>">
      </td>
      <td width="54%" height="1" align="center">
        <p align="left"><font face="MS Sans Serif" size="1"><A HREF="../comunidad/indexcom2.php"><font color="#FFFFCC"><? echo $Mensajes["h-1"]; ?></font></A></font>
      </td>
      <td width="19%" height="1" align="center" colspan="2">
        &nbsp;
      </td>
    </tr>
  </table>
 </form>  
    
 <?
 }
 
  if (($Bibliotecario>=1 && $Id_Entrega!=0)||($Bibliotecario==0))
  {
  
   $expresion = armar_expresion_busqueda();
   
   if ($Bibliotecario>=1)
   {
   		// Si es bibliotecario solo va a ver lo creado por el mismo
	 	$Id_us = $Id_Entrega;
		$completa=" AND Pedidos.Tipo_Usuario_Crea=2";
   }
   else
   {
	 	$Id_us = $Id_usuario;
		$completa="";
   } 

      
   if ($dedonde==0)
   {  
     $expresion = $expresion."WHERE (Pedidos.Estado<=3 OR Pedidos.Estado=5) AND Pedidos.Codigo_Usuario=".$Id_us;
    }
   else
   {
     $expresion = $expresion."WHERE (Pedidos.Estado=6 OR Pedidos.Estado = ".Devolver_Estado_SolicitarPDF().") AND Pedidos.Codigo_Usuario=".$Id_us;
   }  
   
   $expresion.=$completa." ORDER BY Pedidos.Fecha_Alta_Pedido";

   $result = mysql_query($expresion);
   echo mysql_error();
?>

<br>
<table border="0" width="535" cellspacing="0" cellpadding="0" align="center" bgcolor="#66FFCC">
<td width="533" background="../imagenes/banda.jpg">
<table border="0" width="100%" cellspacing="0" cellpadding="0" height="21">
  <tr>
    <td width="1%" align="center" bgcolor="#0099CC" height="1">
      &nbsp;
    </td>   
    <td width="95%" align="center" bgcolor="#0099CC" height="1">
      <p align="left"><b><font face="MS Sans Serif" size="1" color="#000080"><? if ($dedonde==0) { echo $Mensajes["tc-5"]; } else { echo $Mensajes["tc-6"]; } ?></font></b>
    </td>   
  </tr>
  <? if ($Bibliotecario!=1)
    {  ?>
  <tr>
    <td width="1%" align="center" bgcolor="#0099CC" height="1">
      &nbsp;
    </td>   
    <td width="95%" align="center" bgcolor="#0099CC" height="1">
        <p align="left"><font face="MS Sans Serif" size="1"><a href="../comunidad/indexcom2.php"><font color="#FFFFCC"><? echo $Mensajes["h-1"]; ?></font></a></font>
    </td>   
  </tr>
  <? } ?>
  <tr>
    <td width="1%" align="center" height="1">
      <p align="left">&nbsp;</p>
    </td>   
    <td width="95%" align="center" height="1">
      <p align="left"><b><font face="MS Sans Serif" size="1" color="#000080">&nbsp;</font></b>
    </td>   
  </tr>
  <center>

</table>
 
 <?   
      while($row = mysql_fetch_row($result))
     {//echo $adm;
      if (!isset($adm))
		  $adm = 1; 
      Dibujar_Tabla_Comp_Cur ($VectorIdioma,$row,$Mensajes,$adm); 

   ?>    
<form name="form3"> 
  <p align="center">
  &nbsp; <input type="button" value="<? echo $Mensajes["bot-2"]; ?>" name="Revisa" style="font-family: MS Sans Serif; font-size: 10 px; font-weight: bold" OnClick="rutear_pedidos(<? echo $row[4] ?>,'<? echo $row[1]; ?>')">
  </p>
 </form>
<br>
    <?
       }
    ?>
    </center>  
  </div>
</center>  
</table>

<form name="form1">
 <input type="hidden" name="dedonde" value=1>
 <input type="hidden" name="Resp" value=1>
 <input type="hidden" name="Id">
</form>

<?
  }
   mysql_free_result($result);
   Desconectar();
?>
<P ALIGN="center"><FONT FACE="MS Sans Serif" SIZE="1"><FONT COLOR="#000080">cp:</FONT>adm-002</FONT>
</p>

</body>
</html>














