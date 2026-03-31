<?
   include_once "../inc/var.inc.php";
   include_once "../inc/conexion.inc.php";
   Conexion();	
   include_once "../inc/identif.php";
   include_once "../inc/"."fgenped.php";
   include_once "../inc/"."fgentrad.php";
   Administracion();
   global $IdiomaSitio;
   $Mensajes = Comienzo ("uid-001",$IdiomaSitio);
   if ($Predeterminado=="ON")
   {
   		$Predeterminado=1;
   }
   else
   {
   		$Predeterminado=0;
   }
   if ($Predeterminado==1)
   {
     	$Instruccion = "UPDATE Idiomas SET Predeterminado=0 WHERE Predeterminado=1";
   	   $result = mysql_query($Instruccion); 
   }
   

   if ($operacion==0)
   {
     $Instruccion = "INSERT INTO Idiomas (Nombre,";
      for ($i=0;$i<=6;$i++)
		{
			$Instruccion=$Instruccion.$i."_Dia,";
		}
		for ($i=1;$i<=12;$i++)
		{
			$Instruccion=$Instruccion.$i."_Mes,";
		}
		for ($i=1;$i<=12;$i++)
		{
			$Instruccion=$Instruccion."Evento".$i.",";
		}
		for ($i=1;$i<=3;$i++)
		{
			$Instruccion=$Instruccion."Eventos_Mail_".$i.",";
		}
		for ($i=1;$i<=10;$i++)
		{
			$Instruccion=$Instruccion."Estado_".$i."_Pedidos_S,";
			$Instruccion=$Instruccion."Estado_".$i."_Pedidos_P,";
		}
		for ($i=1;$i<=5;$i++)
		{
			$Instruccion=$Instruccion."Tipo_Pedido_".$i.",";
		}

		$Instruccion=$Instruccion."Perfil_Biblio_1,Perfil_Biblio_2,Perfil_Biblio_3,Operacion_1,Operacion_2,Predeterminado) VALUES (";
		$Instruccion=$Instruccion."'$Categoria',";
		
	    for ($i=1;$i<=7;$i++)
		{				
			$Nvar = "Dia".$i;
			$Instruccion=$Instruccion."'".$$Nvar."',";
						
		}
		
		for ($i=1;$i<=12;$i++)
		{
			$Nvar = "Mes".$i;
			$Instruccion=$Instruccion."'".$$Nvar."',";
					
		}
		
		for ($i=1;$i<=12;$i++)
		{
			$Nvar = "Ev".$i;
			$Instruccion=$Instruccion."'".$$Nvar."',";
		}
		
		for ($i=1;$i<=3;$i++)
		{
			$Nvar = "Evm".$i;
			$Instruccion=$Instruccion."'".$$Nvar."',";
		}

		for ($i=1;$i<=10;$i++)
		{
			$Nvar1 = "Es".$i;
			$Nvar2 = "Ep".$i;

			$Instruccion=$Instruccion."'".$$Nvar1."','".$$Nvar2."',";
						
		}
		
		for ($i=1;$i<=5;$i++)
		{
			$Nvar = "TPed".$i;
			$Instruccion=$Instruccion."'".$$Nvar."',";
						
		}
		$Instruccion = $Instruccion."'$PFB1','$PFB2','$PFB3','$Ope1','$Ope2',$Predeterminado)";
     
   }
   else
   {
     $Instruccion = "UPDATE Idiomas SET Nombre='$Categoria',";
      for ($i=1;$i<=7;$i++)
		{
		   $x = $i-1;
		   $Nvar = "Dia".$i; 
			$Instruccion=$Instruccion.$x."_Dia='".$$Nvar."',";
		}
		for ($i=1;$i<=12;$i++)
		{
		   $Nvar = "Mes".$i; 
			$Instruccion=$Instruccion.$i."_Mes='".$$Nvar."',";			
		}
		for ($i=1;$i<=12;$i++)
		{
			$Nvar = "Ev".$i;
			$Instruccion=$Instruccion."Evento".$i."='".$$Nvar."',";
		}
		for ($i=1;$i<=3;$i++)
		{
			$Nvar = "Evm".$i;
			$Instruccion=$Instruccion."Eventos_Mail_".$i."='".$$Nvar."',";
		}
		for ($i=1;$i<=10;$i++)
		{
			$Nvar = "Es".$i;			
			$Instruccion=$Instruccion."Estado_".$i."_Pedidos_S='".$$Nvar."',";
			$Nvar = "Ep".$i;			
			$Instruccion=$Instruccion."Estado_".$i."_Pedidos_P='".$$Nvar."',";
		}
		for ($i=1;$i<=5;$i++)		
		{
   			$Nvar = "TPed".$i;	
			$Instruccion=$Instruccion."Tipo_Pedido_".$i."='".$$Nvar."',";
		}

		$Instruccion.="Perfil_Biblio_1='$PFB1',Perfil_Biblio_2='$PFB2',Perfil_Biblio_3='$PFB3',Operacion_1='$Ope1',Operacion_2='$Ope2',Predeterminado=$Predeterminado WHERE Id=".$Id;
   
   
   }  
 
   $result = mysql_query($Instruccion); 
   	echo mysql_error();   
   
   if (mysql_affected_rows()>0) {
			

			  $texto = '<tr>';
			  $texto.= '	<td width="50%" class="style49"><div align="right">'. $Mensajes["ec-1"].'</div></td>';
			  $texto.= '	<td width="50%" class="style43"><div align="left">'.$Categoria.'</div></td>';
			  $texto.= '</tr>';
			  $texto.= '<tr>';
			  $texto.= '	<td width="50%" class="style49"><div align="right">'. $Mensajes["ec-2"].'</div></td>';
			  $texto.= '	<td width="50%" class="style43"><div align="left">';
								if ($Predeterminado==1) { $texto.=$Mensajes["ec-3"]; } else { $texto.= $Mensajes["ec-4"];} 
							$texto.='</div></td>';
			  $texto .= '</tr>';

			 // $texto.= "<b>".$Mensajes["ec-1"]." </b>".$Categoria."<br><b>".$Mensajes["ec-2"]." </b>";
			  

		}
		else
		{		$texto = '<tr> <td align="center"> <div align="center">';
				$texto.=  $Mensajes["ec-5"];
				$texto.= '</div></td> </tr> ';
		}

  
 ?>


<html>
<head>
<title>PrEBi </title>
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
a.style60 {
	font-family: verdana;
	font-size: 9px;
	color: #006699;
}

.style39 {color: #006699}

.style40 {
	color: #FFFFFF;
	font-family: Verdana;
	font-size: 9px;
}
.style41 {color: #006599}
.style43 {
	font-family: verdana;
	font-size: 10px;
}

.style49 {font-family: verdana; font-size: 10px; color: #006599; }
-->
</style>
<!-- <base target="_self"> -->

</head>
<body topmargin="0">
<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <div align="center">
        <center>
      <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
       <tr bgcolor="#EFEFEF" >
        <td valign="top" bgcolor="#E4E4E4" valign="top">            <div  align="center">
              
			              
				  
				  <table width="95%" border="0" cellpadding="1" cellspacing="0" valign="top">
							<? echo $texto?>
					</table>
			     
			
            </div></td>
                
            
        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <table width="100%" bgcolor="#ececec">
            <tr>
              <td valign="top" class="style28"><div align="center"><img src="../images/image001.jpg" width="150" height="118"><br>
                  <span class="style60"><a class="style60" href="../admin/indexadm.php"><? echo $Mensajes["h-1"];?> </a></span></div>                <div align="center" class="style55"></div></td>
            </tr>
          </table>
          </div>
          </td>
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
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50"><div align="right" class="style33">
            <div align="center">uid-001</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
</body>
</html>


<?
	if ((isset($result) ) &&  ! $result )
	  mysql_free_result ($result);
   Desconectar();
?>










































