<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<body background="../imagenes/banda.jpg"> 
<a href="extran_busqueda.php"> Recargar página </a> <br>
<?php

  include_once "../inc/"."conexion.inc.php";
  Conexion();
  include_once "../inc/"."parametros.inc";
  
  $local = Devolver_Abreviatura_Pais_Local();
  if (isset($setAll))
  {
 	$updQuery = "UPDATE PedHist Set Tipo_Pedido = 2 WHERE Pedidos.Id like '$local%'
			     and Pedidos.Tipo_Pedido = 1";
	$resu = mysql_query($updQuery);
	echo mysql_error();
	if (mysql_affected_rows() > 0)
	  if (mysql_affected_rows() == 1)
	     echo mysql_affected_rows()." pedido ha sido actualizado";
	     else  echo mysql_affected_rows()." pedidos han sido actualizados";
	else
	  echo "No se han encontrado pedidos para actualizar";

  }
  elseif (isset($Id_pedido)) //quiere decir que hay algún pedido para actualizar
    {
	$updQuery = "UPDATE PedHist Set Tipo_Pedido = 2 WHERE Id = '".$Id_pedido."'";
	$resu = mysql_query($updQuery);
	echo mysql_error();
	if (mysql_affected_rows() > 0)
	   echo "Se actualizó el pedido ".$Id_Pedido;
	else
	  echo "Ocurrió un error al actualizar el pedido ".$Id_Pedido.", ya que el mismo no ha sido encontrado";
    }
  //busco todos los pedidos que sean locales pero que sean provision (tipo 2)
  $query = "SELECT PedHist.Id as Id_Pedido, CONCAT(Usuarios.Apellido,', ',Usuarios.Nombres) 
            From PedHist, Usuarios
			Where not (PedHist.Id like '$local%')
			     and PedHist.Tipo_Pedido = 1
			     and PedHist.Codigo_Usuario = Usuarios.Id";
	$result = mysql_query($query);
	    echo mysql_error();
	    
	echo "<center> <h2> Pedidos Históricos externos que son busqueda </h2> ";
	echo "<table>";	
	while($row = mysql_fetch_row($result))
	  { echo "<tr height=18> <td> <table bgcolor='#99CCFF'> <tr height=18> ";
	    echo '<td bgcolor="#666699" align="center" width="130"> <font face="MS Sans Serif" size="1" color="#FFFFCC">'.$row[0].'</font> </td>';
	    echo '<td bgcolor="#666699" align="center" width="250"> <font face="MS Sans Serif" size="1" color="#FFFFCC">'.$row[1].'</font> </td>';
	    echo "<td bgcolor='#000080' align='center' width='130'> 
	             <form name='updateForm' action='extran_busqueda.php'>
	             <input type='submit' style='background-color:#68C9CE;color:#FFFFCC;size:8pt;font-face:MS Comic Sans' value='Pasar a provision'>
		     <input type='hidden' name='Id_pedido' value='".$row[0]."'>
		  </form> </td>";
	     echo " </tr> </table> </td> </tr>";
	       
	  }				 
   echo "</table> <br> <br>";
   echo "<form name='updtateForAll' action='extran_busqueda.php'>
          <!-- <input type='submit' style='background-color:#B7CFE1;color:navy;size:8pt;font-weight:bold;font-face:MS Comic Sans;height:15;width:25' value='Pasar todos a provision'> -->
	  <input type='hidden' name='setAll' value='1'>
	 </form> 
	</center>";  
?>
</body>

