<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
      
require_once('../../../Connections/sala2.php');



@@session_start();



$direccion = "datosbasicos.php";



?>



<html>



<style type="text/css">



<!--



.Estilo1 {font-family: Tahoma; font-size: 12px}



.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }



.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}



.Estilo4 {color: #FF0000}



-->



</style>



<head>



<title>Paises</title>



</head>



<body>







<form name="f1" action="crearpais.php" method="POST" onSubmit="return validar(this)">



  <p align="center" class="Estilo3">CREAR LUGAR DE NACIMIENTO </p>



  <table width="60%"  border="1" align="center" cellpadding="1" bordercolor="#003333">



    <tr>



      <td bgcolor="#C5D5D6" class="Estilo2">&nbsp;Pais (Nombre Completo)<span class="Estilo4">*</span></td>



      <td colspan="3" class="Estilo1"><input name="pais" type="text" size="30"></td>



    </tr>



	<tr>



      <td bgcolor="#C5D5D6" class="Estilo2">&nbsp;Ciudad (Nombre Completo)<span class="Estilo4">*</span></td>



      <td colspan="3" class="Estilo1"><input name="ciudad" type="text" size="30"></td>



    </tr>



	<tr>



      <td bgcolor="#C5D5D6" class="Estilo2">&nbsp;Departamento (Nombre Completo)<span class="Estilo4">*</span></td>



      <td colspan="3" class="Estilo1"><input name="departamento" type="text" size="30"></td>



    </tr>



	<tr>



      <td colspan="4"><div align="center">



        <input type="submit" name="Submit" value="Guardar">



      </div></td>



    </tr>      



 </table>



 <?php 



 if ($_POST['Submit'])



  {



     $idpais = "";



	 



	 if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['pais']) or $_POST['pais'] == ""))



	  {



	     echo '<script language="JavaScript">alert("Pais Incorrecto"); history.go(-1);</script>';	  



	     exit();



	  }



	 else



	   if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['ciudad']) or $_POST['ciudad'] == ""))



	  {



	     echo '<script language="JavaScript">alert("Ciudad Incorrecta"); history.go(-1);</script>';	  



	     exit();



	  }



	 else



	   if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['departamento']) or $_POST['departamento'] == ""))



	  {



	     echo '<script language="JavaScript">alert("departamento Incorrecto"); history.go(-1);</script>';	  



	     exit();



	  }



	 



	 



	 mysql_select_db($database_sala, $sala);



	 $query_pais = "SELECT * FROM pais



	                where nombrepais like '%".$_POST['pais']."%'";



	 $pais = mysql_query($query_pais, $sala) or die(mysql_error());



	 $row_pais = mysql_fetch_assoc($pais);



	 $totalRows_pais = mysql_num_rows($pais);



	 if ($row_pais <> "")



	  {



	    $idpais = $row_pais['idpais'];



	  }



	 else



	  {



	      $sql = "insert pais(nombrecortopais,nombrepais)";



	      $sql.= "VALUES('".$_POST['pais']."','".$_POST['pais']."')"; 



	      $result = mysql_query($sql,$sala);    



	      $idpais = mysql_insert_id();



	  }



	



	 mysql_select_db($database_sala, $sala);



	 $query_departamento = "SELECT * FROM departamento



	                where nombredepartamento like '%".$_POST['departamento']."%'";



	 $departamento = mysql_query($query_departamento, $sala) or die(mysql_error());



	 $row_departamento = mysql_fetch_assoc($departamento);



	 $totalRows_departamento = mysql_num_rows($departamento);



	 if ($row_departamento <> "")



	  {



	    $iddepartamento = $row_departamento['iddepartamento'];



	  }



	 else



	  {



	      $sql = "insert departamento(nombrecortodepartamento,nombredepartamento,idpais)";



	      $sql.= "VALUES('".$_POST['departamento']."','".$_POST['departamento']."','$idpais')"; 



	      $result = mysql_query($sql,$sala);    



	      $iddepartamento = mysql_insert_id();



	  } 



	



	 mysql_select_db($database_sala, $sala);



	 $query_ciudad = "SELECT * FROM ciudad



	                where nombreciudad like '%".$_POST['ciudad']."%'";



	 $ciudad = mysql_query($query_ciudad, $sala) or die(mysql_error());



	 $row_ciudad = mysql_fetch_assoc($ciudad);



	 $totalRows_ciudad = mysql_num_rows($ciudad);



	 if ($row_ciudad <> "")



	  {



	    $idciudad = $row_departamento['idciudad'];



	  }



	 else



	  {



	      $sql = "insert ciudad(nombrecortociudad,nombreciudad,iddepartamento)";



	      $sql.= "VALUES('".$_POST['ciudad']."','".$_POST['ciudad']."','$iddepartamento')"; 



	      $result = mysql_query($sql,$sala);    



	      $idpais = mysql_insert_id();



	  } 



	



	      $sql = "insert titulo(nombretitulo,fechainiciotitulo,fechafintitulo,registrotitulo)";



	      $sql.= "VALUES('".$_POST['titulo']."','".date("y-m-d H:i:s")."','2999-12-31','1')"; 



	      $result = mysql_query($sql,$sala);    



	      echo "<script language='javascript'>



		  window.opener.recargar('".$direccion."');



		  window.opener.focus();



		  window.close();



		  </script>";  



	   



  } 



?>  



</form>



</body>



</html>