<?
/*esta pagina sirve para hacer carga masiva de datos relacionada con los pedidos y los archivos.
Desde aquí se podrán asociar archivos con pedidos directamente */
  
 include_once "../../inc/"."conexion.inc.php";  
 $link=Conexion();

 include_once "../../inc/"."identif.php";
 Administracion();
 include_once "farchivos/funcarch.php";
 	
?>
<html> 
  <head>
    <title><? echo Titulo_Sitio();?> </title>
    <script> 
 function archivo_es_correcto(nombreArchivo)
   { 
  if (nombreArchivo == "")
    return false;
    
  aux = nombreArchivo.substring(nombreArchivo.lastIndexOf(".") + 1,nombreArchivo.length);
  
  if ((aux.toLowerCase() != "pdf") && (aux.toLowerCase() != "arv"))
     return false;
   else
     return true;
   }
   
   function verificar()
   {var archivo1 = document.getElementById('userfile1');
    var archivo2 = document.getElementById('userfile2');
    var archivo3 = document.getElementById('userfile3');
    
    if ((archivo1.value == '') || (archivo2.value == '') || (archivo3.value == ''))
    {
      alert('Debe ingresar al menos un archivo');
      return null;
    }

    if (archivo1.value != '')
      if (!archivo_es_correcto(archivo1.value))
      {alert("El primer archivo no es un archivo pdf o arv");
	return null;
      }

    if (archivo2.value != '')  
      if (!archivo_es_correcto(archivo2.value))
      {alert("El segundo archivo no es un archivo pdf o arv");
	return null;
      }

    if (archivo3.value != '')  
      if (!archivo_es_correcto(archivo3.value))
      {alert("El tercer archivo no es un archivo pdf o arv");
	return null;
      } 
    if (document.getElementById('Id_Pedido').value == '')
    { alert('Debe ingresar el pedido que se asociará con estos archivos');
      return null;
    } 
     document.forms.form1.action = "cmasiva.php?subio=1";
     document.forms.form1.submit();
     return true;
   
      
   }
    </script>
  </head>
  <body>
  <? if ($subio != 1) {
	  ?>
     <form enctype="multipart/form-data" method="post" name="form1" OnSubmit="return false">
     
     <table border="0" width="499" bgcolor="#28497B" height="111" cellspacing="0">
      <tr>
       <td width="107" height="21" align="right">
         <font face="MS Sans Serif" size="1" color="#FFFFCC"> Pedido:  </font> 
       </td>
       <td>
        <input type="text" name="Id_Pedido" id="Id_Pedido"> 
       </td>
      </tr>
      <tr>
       <td width="107" height="27" align="right" valign="top">
         <font face="MS Sans Serif" size="1" color="#FFFFCC"> Archivo 1</font>
       </td>
       <input type="hidden" name="MAX_FILE_SIZE" value="100000000">
       <td width="371" height="27" bgcolor="#265C7D" colspan="3">
         <input name="userfile1" id="userfile1" type="file" size="20" class="fixed" />
       </td>
     </tr>

     <tr>
       <td width="107" height="27" align="right" valign="top">
         <font face="MS Sans Serif" size="1" color="#FFFFCC"> Archivo 2</font>
       </td>
       <input type="hidden" name="MAX_FILE_SIZE" value="100000000">
       <td width="371" height="27" bgcolor="#265C7D" colspan="3">
         <input name="userfile2" id="userfile2" type="file" size="20" class="fixed" />
       </td>
     </tr>

     <tr>
       <td width="107" height="27" align="right" valign="top">
         <font face="MS Sans Serif" size="1" color="#FFFFCC"> Archivo 3</font>
       </td>
       <input type="hidden" name="MAX_FILE_SIZE" value="100000000">
       <td width="371" height="27" bgcolor="#265C7D" colspan="3">
         <input name="userfile3" id="userfile3" type="file" size="20" class="fixed" />
       </td>
     </tr>
     <tr>
       <td width="107" height="27" align="right" valign="top">
         <input type="submit" value="Enviar datos" onclick="verificar()">
       </td>
       <td width="107" height="27" align="right" valign="top">
         <input type="reset" value="Limpiar campos">
       </td>
     </tr>
    </table>
     </form>
  <?  } //está subiendo un archivo 
  else {
	  $query = "SELECT * from PedHist where Id = ".$Id_Pedido;
	  $resu = mysql_query($query);
	      echo mysql_error();
	   $row = mysql_fetch_row($resu);
	   if ($row) //el pedido está en el Historial
	     $esHistorico = 1;
	     else {
         	  $query = "SELECT * from Pedidos where Id = ".$Id_Pedido;
	          $resu = mysql_query($query);
	          echo mysql_error();
	          $row = mysql_fetch_row($resu);
		  if ($row) //el pedido es un pedido actual
		    $esHistorico = 0;
		  else
		  {echo "El pedido no ha sido localizado. Verifique el código del pedido y vuelva a intentarlo
			  <br> <a ref='cmasiva.php'> Volver a intentarlo </a>";
		  }
	     }
	  
            if ($row)  //el pedido fue encontrado en algun momento
	    {
	  		  if ($_FILES['userfile1']['size'] != 0) {
			    upload_File($_FILES['userfile1']['name'],$_FILES['userfile1']['tmp_name']);
			    asociarPedidoAArchivo($Id_Pedido,$_FILES['userfile1']['name'], 1,1);
			   }
			   
			    if ($_FILES['userfile2']['size'] != 0) { 
			     upload_File($_FILES['userfile2']['name'],$_FILES['userfile2']['tmp_name']);
			     asociarPedidoAArchivo($Id_Pedido,$_FILES['userfile2']['name'], 1,1);
			    }
			    if ($_FILES['userfile3']['size'] != 0) {
			     upload_File($_FILES['userfile3']['name'],$_FILES['userfile3']['tmp_name']);
			     asociarPedidoAArchivo($Id_Pedido,$_FILES['userfile3']['name'], 1,1);
			    } 
	echo "<a href='cmasiva.php?subio=0'> Subir otro archivo para otro pedido </a>"; 		    
	    }
  } 
  
  ?>
  </body>  
