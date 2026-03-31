<? 
 
include_once "../inc/"."conexion.inc.php";  
 Conexion();
include_once "../inc/var.inc.php";
 include_once "../inc/"."identif.php";
 Administracion();
 	
?>  
<html>

<head>
<title><? echo Titulo_Sitio(); ?></title>
</head>

<body>
<? 
   include_once "../inc/"."fgenhist.php";
   include_once "../inc/"."fgentrad.php";
    global $IdiomaSitio;
   $Mensajes = Comienzo ("opp-001",$IdiomaSitio);
  
 
    $expresion = "SELECT Id FROM Pedidos WHERE Codigo_Usuario=".$User." AND Estado=".Devolver_Estado_Recibido();
    $result2 = mysql_query ($expresion);
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

  } ?>
<div align="center">
  <center>
<table border="0" width="65%" bgcolor="#006699">
  <tr>
    <td width="100%" align="center" colspan="2"><font face="MS Sans Serif" size="1" color="#FFFF00">
     <? if ($dedonde==1)
      {
        if ($Resp==1)
        {
      ?>
           <b><? echo $Mensajes["tf-1"]." "; if(!isset($Comunidad)){$Comunidad='';} echo  $Comunidad." ".$Mensajes["tf-2"]." ".$Id; ?></b></font>
      <? 
         } else {
      ?>
           <b><? echo $Mensajes["tf-1"]." "; if (!isset($Comunidad)){$Comunidad='';}echo $Comunidad." ".$Mensajes["tf-3"]." ".$Id; ?></b></font>
      <?
          }
       }
       else
       { ?>       
       <b><? echo $Mensajes["tf-1"]." ";if (!isset($Comunidad)){$Comunidad='';} echo $Comunidad." ".$Mensajes["tf-4"]." ".$Id; ?></b></font>
      <? } ?>       
    </td>  
  </tr>
  <tr>
    <td width="50%" align="center">&nbsp;</td>
    <td width="50%" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="50%" align="center"><font face="MS Sans Serif" size="1">
    <? if ($dedonde==1)
      { ?>
       <a href="manpedcon.php"><font color="#FFFFFF"><? echo $Mensajes["hc-1"]; ?></font></a>
    <? } else { ?>
       <a href="manpedent3.php"><font color="#FFFFFF"><? echo $Mensajes["hc-2"]; ?></font></a>
    <? } ?>  
       
    </font></td>
    <td width="50%" align="center">
    <font face="MS Sans Serif" size="1">
     <? if ($dedonde==1)
      { ?>
      <a href="../comunidad/indexcom2.php"><font color="#FFFFFF"><? echo $Mensajes["hc-3"]; ?></font></a>
    <? } else { ?>
      <a href="../admin/indexadm.php"><font color="#FFFFFF"><? echo $Mensajes["hc-4"]; ?></font></a>   
    <? } ?> 
    </font></td>
  </tr>
</table>
  </center>
</div>
<P ALIGN="center"><IMG BORDER="0" SRC="../imagenes/rueda.jpg" width="248" height="240"></P>
<P ALIGN="center">
<FONT FACE="MS Sans Serif" SIZE="1"><FONT COLOR="#000080">cp:</FONT>opp-001</FONT>

<?
  Desconectar();
?>  

</body>

</html>






























