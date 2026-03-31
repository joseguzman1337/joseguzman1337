<?php  
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require('../../../Connections/sala2.php');
@@session_start();
$direccion = "otrasuniversidades.php";  



?>



<style type="text/css">



<!--



.Estilo1 {font-family: Tahoma; font-size: 12px}



.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}



.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}



.Estilo4 {color: #FF0000}



-->



</style>



<form name="inscripcion" method="post" action="">



<?php



       



		 mysql_select_db($database_sala, $sala);



	    $query_datosgrabados = "SELECT * 



								FROM estudianteuniversidad e



								WHERE e.idestudianteuniversidad = '".$_GET['id']."'							 						 



								";			  



		//echo $query_data; 



		$datosgrabados = mysql_query($query_datosgrabados, $sala) or die("$query_estudios".mysql_error());



		$totalRows_datosgrabados = mysql_num_rows($datosgrabados);



		$row_datosgrabados = mysql_fetch_assoc($datosgrabados);   



?>



<table width="70%" border="0" align="center" cellpadding="3" bordercolor="#003333">



	<tr class="Estilo3">



          <td colspan="3" bgcolor="#CCDADD"><div align="center">EDITAR</div></td>



    </tr>



		 <tr class="Estilo2">



          <td bgcolor="#CCDADD"><div align="center">Instituci&oacute;n:</div></td>



          <td bgcolor="#CCDADD"><div align="center">Programa:</div></td>



	      <td bgcolor="#CCDADD"><div align="center">Año Presentación:</div></td>



    </tr>



		<tr bgcolor='#FEF7ED' class="Estilo1">



          <td><div align="center">



            <input type="text" name="institucion" size="30" value="<?php if (isset($row_datosgrabados['institucioneducativaestudianteuniversidad'])) echo $row_datosgrabados['institucioneducativaestudianteuniversidad']; else  echo $_POST['institucion'];?>">



	      </div></td>



          <td ><div align="center">



            <input type="text" name="programa" size="30" value="<?php  if (isset($row_datosgrabados['programaacademicoestudianteuniversidad'])) echo $row_datosgrabados['programaacademicoestudianteuniversidad']; else echo $_POST['programa'];?>">



          </div></td>



		  <td ><div align="center"><input name="ano" type="text" id="ano" size="2" maxlength="4" value="<?php if (isset($row_datosgrabados['anoestudianteuniversidad'])) echo $row_datosgrabados['anoestudianteuniversidad']; else echo $_POST['ano'];?>"></div></td>



	</tr>        



 </table>



<?php



if (isset($_POST['grabado']))



 {		



	$banderagrabar = 0;    



	 if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['institucion'])) or $_POST['institucion'] == "")



	    {



		  echo '<script language="JavaScript">alert("Digite la institución"); history.go(-1);</script>';		



		 $banderagrabar = 1;



		}	



	else



	if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['programa'])) or $_POST['programa'] == "")



	 {   



		 echo '<script language="JavaScript">alert("Digite el programa"); history.go(-1);</script>';		



		$banderagrabar = 1;	



		



	 }



	else



	if ((!eregi("^[0-9]{1,15}$", $_POST['ano']) or $_POST['ano'] > date("Y")) and $_POST['ano'] <> "")



	  {



	    echo '<script language="JavaScript">alert("Año Incorrecto")</script>';		



		$banderagrabar = 1;



	  }      



   else



    if ($banderagrabar == 0)



	  {



           $base="update estudianteuniversidad 



		   set institucioneducativaestudianteuniversidad = '".$_POST['institucion']."',



		   programaacademicoestudianteuniversidad = '".$_POST['programa']."',



		   anoestudianteuniversidad = '".$_POST['ano']."'



		   WHERE idestudianteuniversidad = '".$_POST['id']."'";	  



		 // echo $base;



		   $sol=mysql_db_query($database_sala,$base);		



		   



		   echo "<script language='javascript'>



			window.opener.recargar('$direccion');



			window.opener.focus();



			window.close();



		    </script>"; 	 



	  }



 }	



?>



<script language="javascript">



function grabar()



 {



  document.inscripcion.submit();



 }



</script>



<br><br>



<div align="center">



   <a onClick="grabar()" style="cursor: pointer"><img src="../../../../imagenes/guardar.gif" width="25" height="25" alt="Guardar"></a>



   <input type="hidden" name="grabado" value="grabado">   



   <input type="hidden" name="id" value="<?php echo $_GET['id'];?>"> 



</div> 



</form>