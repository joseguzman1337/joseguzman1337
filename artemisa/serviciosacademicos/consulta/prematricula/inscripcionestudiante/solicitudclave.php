<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">

<?php 

require_once('../../../Connections/sala2.php');

require("../../../funciones/funcionpassword.php");

@session_start();

mysql_select_db($database_sala, $sala);

if ($_POST['cancelar'])

{

	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=ingresopreinscripcion.php'>"; 

  	exit();

}

if (isset($_GET['usuario']))

{

	$usuario = $_GET['usuario'];  

}

else

{

	$usuario = $_POST['usuario'];

}

if ($_POST['cambio'])

{

	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=ingresopreinscripcion.php?usuario=".$usuario."&cambioclave'>"; 

	exit();

}

?>



<form name="form1" method="post" action="">

  <input  type="hidden" name="usuario" size="15" value="<?php echo $_GET['usuario'];?>">

<table width="100%">

<tr>

 <td> 

 <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="50%">

<?php 

////////////////////////////////////// 

if (isset($_GET['cambioclave']) or isset($_POST['cambioclave']))

{

?>  

	 <input  type="hidden" name="cambioclave" size="15" value="">

	  <tr>

		  <td colspan="2" align="left"><strong>Por seguridad se recomienda el cambio de clave, a continuación podrá realizarlo.</strong></td>

  	 </tr>

     <tr>

		  <td align="left" id="tdtitulogris">Usuario<br>

		  </td>

		  <td align="left"><input   type="text" name="usuario2" size="15" value="<?php echo $_GET['usuario'];?>"></td>

     </tr>

 		<tr>

		  <td align="left" id="tdtitulogris">Clave Anterior<br>

		  </td>

		  <td align="left"><input   type="password" name="clave" size="15" value="<?php echo $_POST['clave']; ?>"></td>

		</tr>

		 <tr>

		  <td align="left" id="tdtitulogris">Nueva Clave<br>

		  </td>

		  <td align="left"><input  type="password" name="nuevaclave"  size="15" value="<?php echo $_POST['nuevaclave']; ?>"></td>

		</tr>

		 <tr>

		  <td align="left" id="tdtitulogris">Confirmar Nueva Clave<br>

		  </td>

		  <td align="left"><input  type="password" name="confirmaclave"  size="15" value="<?php echo $_POST['confirmaclave']; ?>"></td>

		</tr>

		<!-- <tr>

		  <td width="60%">Digite una Palabra Clave<br></td>

		  <td width="40%"><input  type="text" name="palabraclave" size="15" value="<?php echo $_POST['palabraclave']; ?>"></td>

		</tr> -->

		<tr>

		  <td colspan="2" align="left">

	          <input type="submit" name="confirmar" value="Confirmar">

		      <input type="submit" name="cancelar" value="Cancelar">

		    </td>

		</tr>

	<?php  

}

else if (isset($_GET['palabra']) or isset($_POST['palabra']))

{

?>	

	<tr>

	<td colspan="2" align="left"><strong>Si olvidó su contraseña envíenos el e-mail que usted registró, y le enviaremos su contraseña a esa dirección.</strong></td>

	</tr>

     <tr>

        <td align="left">Usuario (No. Documento) <br>

        </td>

	    <td align="left"><input  type="text" name="usuario" size="15" value="<?php echo $usuario;?>" ></td>

      </tr>

      <tr>

		<td align="left">E-mail <br>

		</td>

    	<td>

    	      <input  type="text" name="palabraclave" size="15" value="">

    	      <input  type="hidden" name="palabra" size="15" value="<?php echo $_GET['palabraclave'];?>">

  	  </td>

      </tr>

<?php 

	if ($_POST['ingresar'])

	{	   

		if ($_POST['palabraclave'] == "")

		{

			echo '<script language="JavaScript">alert("Debe digitar su Usuario y E-mail"); history.go(-1);</script>';

		    exit();

		}	

		/*$query_clave = "select * 

		from usuariopreinscripcion u,claveusuariopreinscripcion c

		where u.idusuariopreinscripcion = c.idusuariopreinscripcion

		and usuariopreinscripcion = '$usuario'

		and codigoestadoclaveusuariopreinscripcion not like '2%'";

        //echo $query_clave;

		$clave = mysql_query($query_clave, $sala) or die("$query_clave");

		$totalRows_clave = mysql_num_rows($clave);

		$row_clave = mysql_fetch_assoc($clave);*/

		$usuario = $_REQUEST['usuario'];

		$query_clave = "select * 

		from estudiantegeneral eg,usuariopreinscripcion u

		where eg.numerodocumento = '$usuario'

		and u.usuariopreinscripcion = eg.numerodocumento ";

        //echo $query_clave;

		$clave = mysql_query($query_clave, $sala) or die("$query_clave");

		$totalRows_clave = mysql_num_rows($clave);

		$row_clave = mysql_fetch_assoc($clave);

	    if ($row_clave['emailestudiantegeneral'] == $_POST['palabraclave'])

		{                

			/* $query_email = "select emailestudiantegeneral

			from estudiantegeneral

			where numerodocumento = '$usuario'";

			$email = mysql_query($query_email, $sala) or die("$query_clave");

			$totalRows_email = mysql_num_rows($email);

			$row_email = mysql_fetch_assoc($email);          

 */

?>		     <tr>

	         <td colspan="2" align="left"><strong>Al cabo de unos segundos será enviada una nueva clave a su correo electrónico <?php echo $row_clave['emailestudiantegeneral'];?></strong></td>

			 </tr>

<?php	  	      

			$pass = generar_pass(8);

			$direccionemail = $row_clave['emailestudiantegeneral'];

		    mail($direccionemail,"Usuario y Clave para proceso de Inscripción","Bienvenido a la Universidad el Bosque.\n\nAdjunto al presente usuario y clave para el proceso de inscripción.\n\nusuario:".$usuario."\nclave:$pass","FROM: Universidad el Bosque <ayuda@unbosque.edu.co>\n"); 

		    $claveencriptada = md5($pass);

		    $treintadias = date('Y-m-d', time() + (60 * 60 * 24 * 30));

		    $noventadias = date('Y-m-d', time() + (60 * 60 * 24 * 90));	 

		    $query_insestudiante = "update usuariopreinscripcion

			set claveusuariopreinscripcion = '$claveencriptada',

			fechavencimientoclaveusuariopresinscripcion = '$treintadias',

			fechavencimientousuariopresinscripcion = '$noventadias'

			where usuariopreinscripcion = '$usuario'";

			//echo "$query_insestudiante <br>";			

			$insestudiante = mysql_db_query($database_sala,$query_insestudiante) or die("$query_insestudiante".mysql_error());

		    $query_estadoclave = "update claveusuariopreinscripcion

			set codigoestadoclaveusuariopreinscripcion = '200'		

			where idusuariopreinscripcion = '".$row_clave['idusuariopreinscripcion']."'";

			//echo "$query_insestudiante <br>";			

			$estadoclave = mysql_db_query($database_sala,$query_estadoclave) or die("$query_estadoclave".mysql_error());			

			$query_claveinscripcion = "INSERT INTO claveusuariopreinscripcion(idclaveusuariopreinscripcion,idusuariopreinscripcion,fechaclaveusuariopreinscripcion,recordarclaveusuariopreinscripcion,claveusuariopreinscripcion,codigoestadoclaveusuariopreinscripcion) 

		    VALUES(0,'".$row_clave['idusuariopreinscripcion']."','".date("Y-m-d H:i:s")."','temporal','$claveencriptada','100')"; 

		    $userclave = mysql_db_query($database_sala,$query_claveinscripcion) or die("$query_claveinscripcion".mysql_error());

		}

	    else

		{

?>

		     <tr>

	         <td colspan="2" align="left"><strong>El e-mail digitado no coincide con el registrado en su preinscripción por favor escribirnos a <a href="mailto:" style=" color:#000099">ayuda@unbosque.edu.co</a> para reenviarle su usuario y clave</strong></td>

			 </tr>

<?php	  

		}

	}

} // if 1

else

{ //else

?>	   	

	<tr>

      <td align="left" id="tdtitulogris">Usuario (No. Documento)<br>

      </td>

      <td>

        <input  type="text" name="usuario3" size="15" value="<?php echo $usuario;?>" >

</td>

		</tr>

    <tr>

      <td align="left" id="tdtitulogris">Clave</td>

      <td align="left">        

          <input  type="password" name="clave" size="15">

        </td>

	</tr>

<?php 

	$validacaracteres = "";

	$validanumeros = "";

	if ($_POST['ingresar'])

	{    

		$passmd= md5($_POST['clave']);

		$query_clave = "select * 

		from usuariopreinscripcion u,claveusuariopreinscripcion c

		where u.idusuariopreinscripcion = c.idusuariopreinscripcion

		and usuariopreinscripcion = '".$_POST['usuario']."'

		and codigoestadoclaveusuariopreinscripcion not like '2%'";

		//echo $query_clave;

		$clave = mysql_query($query_clave, $sala) or die("$query_clave"."aca");

		$totalRows_clave = mysql_num_rows($clave);

		$row_clave = mysql_fetch_assoc($clave);

		if ($passmd == $row_clave['claveusuariopreinscripcion'])

		{

			if(!isset($_SESSION['MM_Username']))

			{

				$GLOBALS['MM_Username'];

				session_register("MM_Username");

				$_SESSION['MM_Username'] = "estudiante";

			}

			//echo "Bienvenido";	  

			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../serviciosacademicos/consulta/prematricula/inscripcionestudiante/formulariopreinscripcion.php?documentoingreso=$usuario&logincorrecto'>";   

			exit();

		}

		else

		{

?>

<script language="javascript">

	alert("La clave digitada es incorrecta, de click en el link Se te olvidó la Contraseña?");

</script>

<?php

		}

	}  

}

if(!isset($_REQUEST['palabra']) && !isset($_REQUEST['cambioclave']))

{

?>    

	<tr>

      <td colspan="2" align="left">

            <input type="submit" name="ingresar" value="Entrar">

            <!-- <input type="submit" name="cancelar" value="Cancelar">&nbsp;  -->

            <input type="submit" name="cambio" value="Cambio Clave">

      </td>

	</tr>

<?php 

}

else if(isset($_REQUEST['palabra']))

{

?>    

<tr>

      <td colspan="2" align="left">

            <input type="submit" name="ingresar" value="Entrar">

            <input type="submit" name="cancelar" value="Cancelar">

      </td>

</tr>

<?php 

}

?> 

 </table> 

 </td>

</tr>

</table>

<?php

if ($_POST['confirmar'])

{ // if cambio clave

	$query_usuarioclave = "select * 

	from usuariopreinscripcion u,claveusuariopreinscripcion c

	where u.idusuariopreinscripcion = c.idusuariopreinscripcion

	and usuariopreinscripcion = '$usuario'

	and codigoestadoclaveusuariopreinscripcion not like '2%'";

	$usuarioclave = mysql_query($query_usuarioclave, $sala) or die("$query_usuarioclave");

	$totalRows_usuarioclave = mysql_num_rows($usuarioclave);

	$row_usuarioclave = mysql_fetch_assoc($usuarioclave);

	$claveencriptada = md5($_POST['nuevaclave']);

	$pass = md5($_POST['clave']);        

	if ($_POST['clave'] == "") 

	{

		echo '<script language="JavaScript">alert("Debe digitar la clave anterior"); history.go(-1);</script>';		 

	}	

	else if ($_POST['nuevaclave'] == "") 

    {

		echo '<script language="JavaScript">alert("Debe digitar una Nueva clave"); history.go(-1);</script>';		 

	}

	else if ($_POST['confirmaclave'] == "") 

   	{

		echo '<script language="JavaScript">alert("Debe Confirmar la Nueva clave"); history.go(-1);</script>';		 

	}

	else if ($_POST['confirmaclave'] <> $_POST['nuevaclave']) 

    {

		echo '<script language="JavaScript">alert("La Nueva clave es diferente a la Confirmación"); history.go(-1);</script>';		 

	}

	/*else

	  if ($_POST['palabraclave'] == "") 

        {

		  echo '<script language="JavaScript">alert("Debe escribir una Palabra Clave"); history.go(-1);</script>';		 

		}*/

	else if($pass == $row_usuarioclave['claveusuariopreinscripcion'])

	{		   

		$validacaracteres = "";

        $validanumeros = "";		 

        $query_claverepetida = "select * 

		from usuariopreinscripcion u,claveusuariopreinscripcion c

		where u.idusuariopreinscripcion = c.idusuariopreinscripcion

		and usuariopreinscripcion = '$usuario'";

		$claverepetida = mysql_query($query_claverepetida, $sala) or die("$query_claverepetida");

		$totalRows_claverepetida = mysql_num_rows($claverepetida);

		$row_claverepetida = mysql_fetch_assoc($claverepetida);		 

		$indicadorclaverepetida = 0;

		

		do

		{

			if ($row_claverepetida['claveusuariopreinscripcion'] == $claveencriptada)

			{

				$indicadorclaverepetida = 1;

			}		   

		}

		while($row_claverepetida = mysql_fetch_assoc($claverepetida));

		

		foreach (count_chars($_POST['nuevaclave'],1) as $i => $val) 

	    {      

			if ($validanumeros == "")

			{

				if (eregi("^[0-9]$",chr($i)))

				{

					$validanumeros  = 1; 

				}			 		 

			}

			if ($validacaracteres == "")

			{

				if(ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",chr($i)))

				{

					$validacaracteres  = 1; 

				}			

			}	   

	        $suma = $suma + $val;

		} 

   		//echo "if ($validanumeros ==  or $validacaracteres ==  or $suma < 8)";

		if ($validanumeros == "" && $validacaracteres == "")

		{

			echo '<script language="JavaScript">alert("La nueva Clave debe ser alfanumerica y minimo de 8 caracteres"); history.go(-1);</script>';	

		}

		else if ($indicadorclaverepetida == 1)

		{

			echo '<script language="JavaScript">alert("La nueva Clave digitada debe ser diferente a las anteriores"); history.go(-1);</script>';	

		}

		else

		{		  

			$treintadias = date('Y-m-d', time() + (60 * 60 * 24 * 30));

		    $noventadias = date('Y-m-d', time() + (60 * 60 * 24 * 90));	 

		    $query_insestudiante = "update usuariopreinscripcion

			set claveusuariopreinscripcion = '$claveencriptada',

			fechavencimientoclaveusuariopresinscripcion = '$treintadias',

			fechavencimientousuariopresinscripcion = '$noventadias'

			where usuariopreinscripcion = '$usuario'";

			//echo "$query_insestudiante <br>";			

			$insestudiante = mysql_db_query($database_sala,$query_insestudiante) or die("$query_insestudiante".mysql_error());

		    $query_estadoclave = "update claveusuariopreinscripcion

			set codigoestadoclaveusuariopreinscripcion = '200'		

			where idusuariopreinscripcion = '".$row_usuarioclave['idusuariopreinscripcion']."'";

			//echo "$query_insestudiante <br>";			

			$estadoclave = mysql_db_query($database_sala,$query_estadoclave) or die("$query_estadoclave".mysql_error());			

			$query_claveinscripcion = "INSERT INTO claveusuariopreinscripcion(idclaveusuariopreinscripcion,idusuariopreinscripcion,fechaclaveusuariopreinscripcion,recordarclaveusuariopreinscripcion,claveusuariopreinscripcion,codigoestadoclaveusuariopreinscripcion) 

		    VALUES(0,'".$row_usuarioclave['idusuariopreinscripcion']."','".date("Y-m-d H:i:s")."','".$_POST['palabraclave']."','$claveencriptada','300')"; 

		    $userclave = mysql_db_query($database_sala,$query_claveinscripcion) or die("$query_claveinscripcion".mysql_error());  

		}		 

		echo '<script language="JavaScript">alert("Su Clave Fue Cambiada con Exito");</script>';		   

		echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=ingresopreinscripcion.php?usuario=".$usuario."'>"; 

        exit();

	}	

	else

	{		   

		echo '<script language="JavaScript">alert("La clave anterior que fue digitada es incorrecta"); history.go(-1);</script>';	

	}

}

?>

</form>

