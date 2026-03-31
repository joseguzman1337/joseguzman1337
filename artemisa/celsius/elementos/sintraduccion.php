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
     <td width='50%' bgcolor='#666699' align='right' height='18'>
        <font face='MS Sans Serif' size='1' color='#FFFF99'>
      ".$Mensajes["st-001"]."
      </font>
      </td>
      <td width='20%' colspan=2 bgcolor='#666699' align='left' height='18'>
      <font face='MS Sans Serif' size='1'>
      <form name=form1 action='sintraduccion.php'>
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
       <td width='25%' bgcolor='#666699' align='center' height='18' colspan=2>
       <font face='MS Sans Serif' size='1' color='#FFFFCC'>
       ".$Mensajes["st-002"]."<input type='checkbox' name='aArchivo'> </td>
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
       $query = "SELECT * FROM Elementos";
       $resu = mysql_query($query);
       $sintrad = array();
       while ($row = mysql_fetch_array($resu)) //para cada elemento, veo si tiene traduccion en el idioma seleccionado
       {
        $elem = $row['Codigo_Elemento'];
        $pant = $row['Codigo_Pantalla'];
        //echo "<br> Analizando ".$elem." de la pagina ".$pant;
        $query_trad = "SELECT Codigo_Pantalla
                       FROM Traducciones
                       WHERE Codigo_Elemento = '".$elem."' and
                       Codigo_Pantalla = '".$pant."'
                       and Codigo_Idioma = ".$idioma_seleccionado;
         //echo $query_trad;
         $exec_query =mysql_query($query_trad);
          mysql_error();
         if (! (mysql_fetch_row($exec_query)))
           {
            $query_cast = "SELECT Texto FROM Traducciones
                           WHERE Codigo_Elemento = '".$elem."' and
                           Codigo_Pantalla = '".$pant."'
                           and Codigo_Idioma = 1";
            $traduc = mysql_query($query_cast);
            $trad = "";

            if ($texto = mysql_fetch_array($traduc))
               $trad = $texto['Texto'];

            $arr_aux = array($pant,$elem,$trad);
            array_push($sintrad,$arr_aux);
            }
         } //del while
       if ($aArchivo)
       { $arch = fopen(devolverDirectorioArchivos()."/sintraduccion.csv","w");
         if (!$arch)
         {   echo $Mensajes['err-001'];
           return;
         }
          foreach ($sintrad as $value) {
              fwrite($arch,"'".$value[0] ."','".$value[1]."','','".$value[2]."'\n");
             }
          fclose($arch);
          $size = filesize(devolverDirectorioArchivos()."/sintraduccion.csv");
       //   header("Content-type: application/pdf");
       
          header("Content-Disposition:attachment; filename= sintraduccion.csv");
          header("Accept-Ranges: bytes");
          header("Content-Length:$size");
          @readfile(devolverDirectorioArchivos()."/sintraduccion.csv");

       }
       else
        { echo  '<html>
                 <head> <title></title>
                    </head>
                   <body background="../imagenes/banda.jpg">
                   <a name="arriba"></a>
                   <center>
                   <table width=500>
                   <tr>
                   <td width="100%" colspan=2 bgcolor="#999999" align="left" height="18">
                   <font face="MS Sans Serif" size="1" color="#FFFFEE">
                   <b>'.count($sintrad).'</b> '.$Mensajes["st-003"].'</font>
                   </td> </tr>
                   <tr>
                   <td width="50%" bgcolor="#999999" align="left" height="18">
                   <a href="./sintraduccion.php"<font face="MS Sans Serif" size="1" color="#FFFFEE">
                   '.$Mensajes["st-004"].'</font></a>
                   </td>
                   <td width="50%" bgcolor="#999999" align="right" height="18">
                   <a href="../admin/indexadm.php"<font face="MS Sans Serif" size="1" color="#FFFFEE">
                   '.$Mensajes["st-005"].'</font></a>
                   </td> </tr>
                   </table>';
       

      echo "
      <table width=500>
       <tr>
       <td width='10%' bgcolor='#666699' align='center' height='18'>
        <font face='MS Sans Serif' size='1' color='#FFFF99'><b>".$Mensajes["st-006"]."</b></font>
       </td>
       <td width='10%' bgcolor='#666699' align='center' height='18'>
        <font face='MS Sans Serif' size='1' color='#FFFF99'><b>".$Mensajes["st-006"]."</b></font>
       </td>
       <td width='35%' bgcolor='#666699' align='center' height='18'>
        <font face='MS Sans Serif' size='1' color='#FFFF99'><b>".$Mensajes["st-006"]."</b></font>
       </td>
       </tr>

       ";


          foreach ($sintrad as $value) {
              echo "<tr>
              <td width='15%' bgcolor='#666699' align='center' height='18'>
              <font face='MS Sans Serif' size='1' color='#FFFF99'>".$value[0] ."</font> </td>
              <td width='15%' bgcolor='#666699' align='center' height='18'>
              <font face='MS Sans Serif' size='1' color='#FFFF99'>
              ".$value[1]."</font></td>
              <td width='15%' bgcolor='#666699' align='center' height='18'>
              <font face='MS Sans Serif' size='1' color='#FFFF99'>
              ".$value[2]."</font></td></tr>";
               }
        echo '
        <tr>
         <td colspan=1 width="5%" bgcolor="#999999" align="center" height="18">
         <a href="#arriba"><font face="MS Sans Serif" size="1" color="#FFFFEE">
         ^</font></a>
         </td>
         <td colspan=2 width="95%" bgcolor="#999999" align="right" height="18">
         <a href="../admin/indexadm.php"<font face="MS Sans Serif" size="1" color="#FFFFEE">
         '.$Mensajes["st-005"].'</font></a>
         </td> </tr>
        </table> </center> </body>
         </html>';
          }
     }//del else

?>


