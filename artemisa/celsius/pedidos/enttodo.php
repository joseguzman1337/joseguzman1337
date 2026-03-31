<? 
 
include_once "../inc/"."conexion.inc.php";  
Conexion();
include_once "../inc/var.inc.php";
include_once "../inc/"."identif.php";
include_once "../inc/"."agregar_mov.php";
Administracion();
?>  

<html>

<head>
<title> <? echo Titulo_Sitio(); ?></title>
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
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 11px; }
.style23 {
	color: #000000;
	font-size: 11px;
	font-family: verdana;
}
.style28 {color: #FFFFFF}
.style29 {
	color: #006599;
	font-family: Verdana;
	font-size: 11px;
}
.style42 {color: #FFFFFF; font-size: 11px; font-family: verdana; }
-->
</style>
</head>


<? 
   include_once "../inc/"."fgenhist.php";
   include_once "../inc/"."fgentrad.php";
    global $IdiomaSitio;
   $Mensajes = Comienzo ("opp-001",$IdiomaSitio);
  
	$inst3="select * from Parametros ";
	$result3=mysql_query($inst3);
    $row3=mysql_fetch_array($result3);
    $valorPagina=$row3[1];
	$expresion = "SELECT Id,Numero_Paginas FROM Pedidos WHERE Codigo_Usuario=".$User." AND Estado=".Devolver_Estado_Recibido();
    $result2 = mysql_query ($expresion);
    $Dia = date ("d");
    $Mes = date ("m");
    $Anio = date ("Y");
    $FechaHoyn =$Anio."-".$Mes."-".$Dia;
 	$instruccion7="select * from Usuarios where Id='".$User."'";
    $result7=mysql_query($instruccion7);
    $row7=mysql_fetch_array($result7);
	$tipoPed = tipo_pedido($Id_Entrega);
			
	$pedidos="";
	while ($rowg=mysql_fetch_row($result2))
    {   
      
      $Dia = date ("d");
      $Mes = date ("m");
      $Anio = date ("Y");
      $FechaHoy =$Anio."-".$Mes."-".$Dia;

    
      if (!isset($Paises))
      {
        $Paises = 0;       
      }
    
      if (!isset($Instituciones))
      {
        $Instituciones = 0;
      }
    
      if (!isset($Dependencias))
      {
        $Dependencias = 0;
      }
    
      $Paises=0;
      $Instituciones=0;
      $Dependencias=0;
      $Observaciones="";    
      $Id = $rowg[0];      
      $Evento = Devuelve_Evento_entrega();
      $Instruccion = "INSERT INTO Eventos (Id_Pedido,Codigo_Evento,Codigo_Pais,Codigo_Institucion,Codigo_Dependencia,Fecha,Observaciones"; 
      $Instruccion = $Instruccion.",Operador,Es_Privado,Numero_Paginas) VALUES ('".$Id."',".$Evento.",".$Paises.",".$Instituciones.",".$Dependencias;
      $Instruccion = $Instruccion.",'".$FechaHoy."','".$Observaciones."',".$Operador.",0,0)";
      $result = mysql_query($Instruccion); 
      echo mysql_error();                 
      if (mysql_affected_rows()>0)       

    		{
    		 $Estado = Determinar_Estado ($Evento);
    		 if ($Operador!=0)
    		 {
    		    $Instruccion = "UPDATE Pedidos SET Operador_Corriente=".$Operador.",Estado=".$Estado.",Fecha_Entrega='".$FechaHoy."' WHERE Pedidos.Id='".$Id."'";
    		 }
    		 else
    		 {
       		 $Instruccion = "UPDATE Pedidos SET Estado=".$Estado." WHERE Pedidos.Id='".$Id."'";
    		 }   
    		 $result = mysql_query($Instruccion); 
    		 echo mysql_error();
    		 
    		 // Despues de la generacion de los eventos y la verificación
    		 // de los estados es que me fijo si el estado amerita una 
    		 // bajada a historico
    		 // Tipo Material me viene desde la presentacion de los pedidos
  
   			
			 if (Pasa_Historico($Estado)==1)
    		 {     		 
    		    Bajar_Historico($Id);
    		 }
    		 
    }		 

  } 

  
  ?>
<body topmargin="0">
<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <div align="center">
        <center>
      <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td align="center" valign="middle" bgcolor="#E4E4E4">            <div align="center">
              <center>
                <table width="97%" height="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr align="center">
                    <td colspan="3" align="center" valign="middle" class="style42">
                     <div align="center" class="style23">
                      <p>&nbsp;</p>

     <? if ($dedonde==1)
      {
        if ($Resp==1)
        {
      ?>
           <b><? echo $Mensajes["tf-1"]." "; if(!isset($Usuario)){$Usuario='';} echo  $Usuario." ".$Mensajes["tf-2"]." ".$Id; ?></b></font>
      <? 
         } else {
      ?>
           <b><? echo $Mensajes["tf-1"]." "; if (!isset($Usuario)){$Usuario='';}echo $Usuario." ".$Mensajes["tf-3"]." ".$Id; ?></b></font>
      <?
          }
       }
       else
       { ?>
	   
       <b><? echo $Mensajes["tf-1"]." ";if (!isset($Usuario)){$Usuario='';} echo $Usuario." ".$Mensajes["tf-4"]; ?></b></font>
       <?
	   $array_ids=array("1");
        $array_ids=split(":",$pedidos);
		 for ($i=0;$i<sizeof($array_ids)-1;$i++)
           {
              echo $array_ids[$i]."; ";
           }

  } ?>       
   </td>
  </tr>
  <tr>
    <td width="50%" align="center" class="style42">

    <? if ($dedonde==1)
      { ?>
       <a href="manpedcon.php"><? echo $Mensajes["hc-1"]; ?></a>
    <? } else { ?>
       <a href="manpedent3.php"><? echo $Mensajes["hc-2"]; ?></a>
    <? } ?>  
       

    </td>
                    </tr>
                </table>
              </center>
            </div>            </td>
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
                         <? if ($dedonde==1)
      { ?>
      <a href="../comunidad/indexcom2.php"><? echo $Mensajes["hc-3"]; ?></a>
    <? } else { ?>
      <a href="../admin/indexadm.php"><? echo $Mensajes["hc-4"]; ?></a>   
    <? } ?> 
</span></p>
                  </div>                  </td>
          </div></td>
		
		  <?
  //Desconectar();
 

		  //}
		  ?>
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
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a></div></td>
          <td width="50"><div align="center" class="style11">opp-001</div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
<?
  }
 ?>
</body>
</html>















