<?php
  
  include_once Obtener_Direccion()."parametros.inc";
  include_once Obtener_Direccion()."conexion.inc.php";
  Conexion();
  include_once Obtener_Direccion()."identif.php";
  Administracion();
  include_once Obtener_Direccion()."funcarch.php";
  include_once Obtener_Direccion()."fgentrad.php";
  global $IdiomaSitio;
  $Mensajes = Comienzo ("tra-001",$IdiomaSitio);
  if (!isset($idioma_seleccionado))
   { echo "
    <html>
   <head> <title></title>
   </head>
   <body background='../imagenes/banda.jpg'>
     <table>
     <tr>
     <td width='20%' bgcolor='#666699' align='right' height='18'>
        <font face='MS Sans Serif' size='1' color='#FFFF99'>
      ".$Mensajes["st-009"]." &nbsp;&nbsp;
      </font>
      </td>
      <td width='20%' bgcolor='#666699' align='left' height='18'>
      <font face='MS Sans Serif' size='1'>
      <form name=form1 action='importar_trad.php' method=POST enctype='multipart/form-data'>
      <font color='#FFFFCC'>";

      $query1 =  "SELECT Id,Nombre From Idiomas";
      $resu = mysql_query($query1)
          or die("Error al buscar los idiomas. Verifique la conexion con la base de datos");
       echo "<select name='idioma_seleccionado'>";
       while ($row = mysql_fetch_array($resu))
         echo "<option value=".$row[0].">".$row[1]."</option>";

       echo "</select>
       </font> </font>
       </td>  </tr>
       <tr>
       <td width='25%' bgcolor='#666699' align='right' height='18'>
       <font face='MS Sans Serif' size='1' color='#FFFFCC'>
       ".$Mensajes["st-010"]."&nbsp;&nbsp; </td>
       <td width='20%' bgcolor='#666699' align='left' height='18'>
       <input type='file' name='archivo'> </td>
       </tr>
       <tr>
       <td width='25%' bgcolor='#666699' align='center' height='18' colspan=2>
        <input type=submit value='".$Mensajes["bot-01"]."'>
        </td>
        </tr>
         </form>";


     echo " </table> </body>
</html>";
    }
    else
      {
       echo "procesando";
       $arch = fopen($_FILES['archivo']['tmp_name'],'r');
       $pos = 1;
       $total = 0;

        while ($data = fgetcsv ($arch, 1000, ","))
          {$pos ++;
           if (count($data) != 4)
             {
              echo $Mensajes["st-012"]." ".$pos;
              }
            else
              {

                $query = "INSERT INTO `Traducciones` ( `Codigo_Pantalla` , `Codigo_Elemento` , `Codigo_Idioma` , `Texto` , `Nombre_Archivo` )
                          VALUES (".$data[0].",".$data[1].",".$idioma_seleccionado.",".$data[2].",NULL)";
                 mysql_query($query);
                 echo mysql_error()."<br>";
                 $total++;

               }
           echo "<br>";
           }

        echo  '<html>
                 <head> <title></title>
                    </head>
                   <body background="../imagenes/banda.jpg">
                   <a name="arriba"></a>
                   <center>
                   <table width=500>
                   <tr>
                   <td width="100%" colspan=2 bgcolor="#999999" align="left" height="18">
                   <font face="MS Sans Serif" size="1" color="#FFFFEE">
                   <b>'.$total.'</b> '.$Mensajes["st-011"].'</font>
                   </td> </tr>
                   <tr>
                   <td width="50%" bgcolor="#999999" align="left" height="18">
                   <a href="./importar_trad.php"<font face="MS Sans Serif" size="1" color="#FFFFEE">
                   '.$Mensajes["st-004"].'</font></a>
                   </td>
                   <td width="50%" bgcolor="#999999" align="right" height="18">
                   <a href="../admin/indexadm.php"<font face="MS Sans Serif" size="1" color="#FFFFEE">
                   '.$Mensajes["st-005"].'</font></a>
                   </td> </tr>
                   </table>';

     }//del else

?>


