<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);   

require_once('../../../Connections/sala2.php');



@@session_start();



$direccion = "estudiosrealizados.php";



?>



<style type="text/css">



<!--



.Estilo1 {font-family: Tahoma; font-size: 12px}



.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }



.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}



.Estilo4 {color: #FF0000}



-->



</style>



<form name="f1" action="creartitulo.php" method="POST" onSubmit="return validar(this)">



  <p align="center" class="Estilo3">CREAR TITULO </p>



  <table width="60%"  border="1" align="center" cellpadding="1" bordercolor="#003333">



    <tr>



      <td bgcolor="#C5D5D6" class="Estilo2">&nbsp;Titulo (Nombre Completo)<span class="Estilo4">*</span></td>



      <td colspan="3" class="Estilo1"><input name="titulo" type="text" size="40"></td>



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



      mysql_select_db($database_sala, $sala);



	 $query_titulo = "SELECT * FROM titulo



	                   where nombretitulo like '%".$_POST['titulo']."%'";



	 $titulo = mysql_query($query_titulo, $sala) or die(mysql_error());



	 $row_titulo = mysql_fetch_assoc($titulo);



	 $totalRows_titulo = mysql_num_rows($titulo);



	 if ($row_titulo <> "")



	  {



	    echo '<script language="JavaScript">alert("Titulo ya Existe"); history.go(-1);</script>';	



	    exit();



	  }



	 else	



	 if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['titulo']) or $_POST['titulo'] == ""))



	  {



	    echo '<script language="JavaScript">alert("Titulo Incorrecto"); history.go(-1);</script>';	



	    exit();



	  }



	else



      {



	      $sql = "insert titulo(nombretitulo,fechainiciotitulo,fechafintitulo,registrotitulo)";



	      $sql.= "VALUES('".$_POST['titulo']."','".date("y-m-d H:i:s")."','2999-12-31','1')"; 



	      $result = mysql_query($sql,$sala);    



	      echo "<script language='javascript'>



		  window.opener.recargar('".$direccion."');



		  window.opener.focus();



		  window.close();



		  </script>";  



	  }   



  }



 



 



 ?>



  



</form>