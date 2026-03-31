<html>
  <head> <title> Parser XML </title>
  </head>
  <body>
<?
    
   include_once Obtener_Direccion()."parametros.inc";
   include_once('XMLParser.php');
   
   function imprimirUna($tree)
   {
    echo "Solo una: <br><table border='1' width='600' align='CENTER'>";
    for ($i=0;$i<=sizeof($tree['ROOT']['BIBLIOTECA']);$i++) {
	    //primero la biblioteca
      echo "<tr> 
	     <td width='20%' heigth='25' bgcolor='#B7CFEE' valign='middle'>
	     <font face='MS Sans Serif' size='1' color='#666699'> <b> Biblioteca </b> </font> </td>
 	     <td width='70%' bgcolor='#79A7C8' valign='middle'>
	     <font face='MS Sans Serif' size='1' color='#000000'> <b>
	     ".$tree['ROOT']['BIBLIOTECA']['NOMBRE']['VALUE']." </b> </font> 
	     </td>
            </tr>";
	    //luego el call number
	  if ($tree['ROOT']['BIBLIOTECA']['CALLNUMBER']['VALUE'] != '')
          echo "		    
	    <tr>
	     <td width='*' bgcolor='#B7CFE1' valign='middle'>
	     <font face='MS Sans Serif' size='1' color='#333399'> Call Number </font> </td>
 	     <td width='70%' bgcolor='#79A7C8' valign='middle'>
	     <font face='MS Sans Serif' size='1' color='#000000'> <b>
	     ".$tree['ROOT']['BIBLIOTECA']['CALLNUMBER']['VALUE']." 
	       </b> </td> </tr>";
	       //ahora la existencia
       echo "
       	    <tr>
	     <td width='30%' bgcolor='#B7CFE1' valign='middle'>
	     <font face='MS Sans Serif' size='1' color='#333399'> Existencia </font> </td>
 	     <td width='70%' bgcolor='#79A7C8' valign='middle'>
	     <font face='MS Sans Serif' size='1' color='#000000'> 
	     <b>".$tree['ROOT']['BIBLIOTECA']['EXISTENCIA']['VALUE']."</b> </td> </tr>";
	     //finalmente, las observaciones (si es que existen)
     if ($tree['ROOT']['BIBLIOTECA'][$i]['OBSERVACIONES']['VALUE'] != '')
      echo "<tr>
	     <td width='*' bgcolor='#B7CFE1' valign='middle'>
	     <font face='MS Sans Serif' size='1' color='#333399'> Observaciones </font> </td>
 	     <td width='70%' bgcolor='#79A7C8' valign='middle'>
	     <font face='MS Sans Serif' size='1' color='#000000'> <b>
	     ".$tree['ROOT']['BIBLIOTECA']['OBSERVACIONES']['VALUE']."
	     </b> </td> </tr>";
	     
      }  
    echo "</table>";
    

   }
   
   
   
   
   function imprimirExistencia($tree) 
   {
    //recibe toda una consulta de existencias y la imprime en forma de tabla
    echo "<table border='1' width='600' align='CENTER'>";
    if (sizeof($tree['ROOT']['BIBLIOTECA'][0]['NOMBRE']['VALUE']) != '') { 
     for ($i=0;$i<=sizeof($tree['ROOT']['BIBLIOTECA']);$i++) {
	    //primero la biblioteca
      echo "<tr> 
	     <td width='20%' heigth='25' bgcolor='#B7CFEE' valign='middle'>
	     <font face='MS Sans Serif' size='1' color='#666699'> <b> Biblioteca </b> </font> </td>
 	     <td width='70%' bgcolor='#79A7C8' valign='middle'>
	     <font face='MS Sans Serif' size='1' color='#000000'> <b>
	     ".$tree['ROOT']['BIBLIOTECA'][$i]['NOMBRE']['VALUE']." </b> </font> 
	     </td>
            </tr>";
	    //luego el call number
	  if ($tree['ROOT']['BIBLIOTECA'][$i]['CALLNUMBER']['VALUE'] != '')
          echo "		    
	    <tr>
	     <td width='*' bgcolor='#B7CFE1' valign='middle'>
	     <font face='MS Sans Serif' size='1' color='#333399'> Call Number </font> </td>
 	     <td width='70%' bgcolor='#79A7C8' valign='middle'>
	     <font face='MS Sans Serif' size='1' color='#000000'> <b>
	     ".$tree['ROOT']['BIBLIOTECA'][$i]['CALLNUMBER']['VALUE']." 
	       </b> </td> </tr>";
	       //ahora la existencia
       echo "
       	    <tr>
	     <td width='30%' bgcolor='#B7CFE1' valign='middle'>
	     <font face='MS Sans Serif' size='1' color='#333399'> Existencia </font> </td>
 	     <td width='70%' bgcolor='#79A7C8' valign='middle'>
	     <font face='MS Sans Serif' size='1' color='#000000'> 
	     <b>".$tree['ROOT']['BIBLIOTECA'][$i]['EXISTENCIA']['VALUE']."</b> </td> </tr>";
	     //finalmente, las observaciones (si es que existen)
     if ($tree['ROOT']['BIBLIOTECA'][$i]['OBSERVACIONES']['VALUE'] != '')
      echo "<tr>
	     <td width='*' bgcolor='#B7CFE1' valign='middle'>
	     <font face='MS Sans Serif' size='1' color='#333399'> Observaciones </font> </td>
 	     <td width='70%' bgcolor='#79A7C8' valign='middle'>
	     <font face='MS Sans Serif' size='1' color='#000000'> <b>
	     ".$tree['ROOT']['BIBLIOTECA'][$i]['OBSERVACIONES']['VALUE']."
	     </b> </td> </tr>";
	     
     }
    }
    else  //solo una biblioteca
    {
	 echo "<tr> 
	     <td width='20%' heigth='25' bgcolor='#B7CFEE' valign='middle'>
	     <font face='MS Sans Serif' size='1' color='#666699'> <b> Biblioteca </b> </font> </td>
 	     <td width='70%' bgcolor='#79A7C8' valign='middle'>
	     <font face='MS Sans Serif' size='1' color='#000000'> <b>
	     ".$tree['ROOT']['BIBLIOTECA']['NOMBRE']['VALUE']." </b> </font> 
	     </td>
            </tr>";
	    //luego el call number
	  if ($tree['ROOT']['BIBLIOTECA']['CALLNUMBER']['VALUE'] != '')
          echo "		    
	    <tr>
	     <td width='*' bgcolor='#B7CFE1' valign='middle'>
	     <font face='MS Sans Serif' size='1' color='#333399'> Call Number </font> </td>
 	     <td width='70%' bgcolor='#79A7C8' valign='middle'>
	     <font face='MS Sans Serif' size='1' color='#000000'> <b>
	     ".$tree['ROOT']['BIBLIOTECA']['CALLNUMBER']['VALUE']." 
	       </b> </td> </tr>";
	       //ahora la existencia
       echo "
       	    <tr>
	     <td width='30%' bgcolor='#B7CFE1' valign='middle'>
	     <font face='MS Sans Serif' size='1' color='#333399'> Existencia </font> </td>
 	     <td width='70%' bgcolor='#79A7C8' valign='middle'>
	     <font face='MS Sans Serif' size='1' color='#000000'> 
	     <b>".$tree['ROOT']['BIBLIOTECA']['EXISTENCIA']['VALUE']."</b> </td> </tr>";
	     //finalmente, las observaciones (si es que existen)
     if ($tree['ROOT']['BIBLIOTECA']['OBSERVACIONES']['VALUE'] != '')
      echo "<tr>
	     <td width='*' bgcolor='#B7CFE1' valign='middle'>
	     <font face='MS Sans Serif' size='1' color='#333399'> Observaciones </font> </td>
 	     <td width='70%' bgcolor='#79A7C8' valign='middle'>
	     <font face='MS Sans Serif' size='1' color='#000000'> <b>
	     ".$tree['ROOT']['BIBLIOTECA']['OBSERVACIONES']['VALUE']."
	     </b> </td> </tr>";
    }
    
    echo "</table>";
    
   }

    
   include_once Obtener_Direccion()."parametros.inc";

  
   $server = Devolver_Servidor();
   $user = Devolver_Usuario();
   $password = Devolver_Clave();
   
   mysql_connect($server,$user,$password);
   $sambLink= mysql_selectdb("Samb");
   $query = "SELECT Descripcion from Existencia Where Id_Titulo_Colecciones = 321";
   $resu = mysql_query($query);
          echo mysql_error();
	  echo "<h1> BD:".$server."-".$user."-".$password;
     if (mysql_num_rows($resu) != 1) {	  
        while ($row = mysql_fetch_row($resu)) {
          $data = "<root> ". $row[0]." </root>" ;
          $parser = new XMLParser($data, 'raw', 1);
          $tree = $parser->getTree();
	  echo"<br>";
	 // print_r($tree);
          imprimirExistencia($tree);
           }
	  }
     else
       if (mysql_num_rows($resu) == 1)
        {    echo $row[0];
	  $data = "<root> ". $row[0]." </root>" ;
          $parser = new XMLParser($data, 'raw', 1);
          $tree = $parser->getTree();
	 // print_r($tree);
          imprimirUna($tree);
       }
       else
         echo "no encontrado";

?>

<br> <a href="parser.php"> Reload page</a>
  </body>
</html>
