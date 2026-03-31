<?php 

require_once('../serviciosacademicos/Connections/sala2.php');

require("../serviciosacademicos/funciones/funcionpassword.php");



$rutaado = "../serviciosacademicos/funciones/adodb/";

require_once('../serviciosacademicos/Connections/salaado.php'); 



@session_start();

if ($_POST['cancelar'])

{

	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=aspirantes.php?usuario=".$_REQUEST['usuario']."'>"; 

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

	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=aspirantes.php?usuario=".$usuario."&cambioclave'>"; 

	exit();

}



//print_r($_REQUEST);

?>

<style type="text/css">

<!--

.Estilo5 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10; }

.Estilo7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }

.Estilo11 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; color: #333333; }

.Estilo16 {font-size: 9px; color:#FFFFFF}

.Estilo19 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; font-weight: bold; color: #FFFFFF; }

.Estilo21 {font-size: 9px; color: #FFFFFF; }

.Estilo23 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; color: #FFFFFF; }

.Estilo26 {font-size: 10px; color: #FFFFFF; font-family: Verdana, Arial, Helvetica, sans-serif;}

-->

</style>

<form name="form1" method="post" action="">

  <input  type="hidden" name="usuario" style="font-size:9px" size="15" value="<?php echo $_GET['usuario'];?>">

<table width="100%">

<tr>

 <td> 

 <table border="1" cellpadding="1" cellspacing="0" bordercolor="#94944C">

<?php 

/****** FUNCIONES ***************/

function iniciar_sesion($db)

{

	$usuario = $_REQUEST['usuario'];

?>	   	

	<tr>

      <td align="left"><span class="Estilo11"><span class="Estilo21">Documento</span><br>

      </span></td>

      <td align="left">

        <input  type="text" name="usuario" size="12" value="<?php echo $usuario;?>"  style="font-size:9px">

</td>

		</tr>

    <tr>

      <td align="left"><span class="Estilo19">Clave</span></td>

      <td align="left">        

          <input  type="password" name="clave" size="15" style="font-size:10px">

        </td>

	</tr>

<?php 

	$validacaracteres = "";

	$validanumeros = "";

	if ($_POST['ingresar'])

	{    
        //$passmd = md5($_POST['clave']);
		$passmd = hash('sha256', $_POST['clave']);

		$query_clave = "select * 

		from usuariopreinscripcion u,claveusuariopreinscripcion c

		where u.idusuariopreinscripcion = c.idusuariopreinscripcion

		and usuariopreinscripcion = '$usuario'

		and codigoestadoclaveusuariopreinscripcion not like '2%'";

		//echo $query_clave;

		$clave = $db->Execute($query_clave);

		$totalRows_clave = $clave->RecordCount();

		$row_clave = $clave->FetchRow();



		if ($passmd == $row_clave['claveusuariopreinscripcion'])

		{

			if(!isset($_SESSION['MM_Username']))

			{

				$GLOBALS['MM_Username'];

				session_register("MM_Username");

				$_SESSION['MM_Username'] = "estudiante";			

			}

			//echo "Bienvenido";	  

			//echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../serviciosacademicos/consulta/prematricula/inscripcionestudiante/formulariopreinscripcion.php?documentoingreso=$usuario&logincorrecto'>";   

			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=enlinea.php?documentoingreso=$usuario&logincorrecto'>";   

			exit();

		}

		else

		{

?>

<script language="javascript">

	alert("La contraseña digitada es incorrecta, de click en el link Se te olvidó la Contraseña?");

</script>

<?php

		}

	}  

}



function cambio_clave()

{

?>  

	 <input  type="hidden" name="cambioclave" style="font-size:9px" size="15" value="">

	  <tr>

		  <td colspan="2" align="left" class="Estilo16">Por seguridad se recomienda el cambio de contraseña.</td>

  	 </tr>

     <tr>

		  <td align="left"><span class="Estilo19">Documento<br>

		  </span></td>

		  <td align="left"><input   type="text" name="usuario" size="12" value="<?php echo $_REQUEST['usuario'];?>" style="font-size:9px"></td>

     </tr>

 		<tr>

		  <td align="left"><span class="Estilo19">Clave Anterior<br>

		  </span></td>

		  <td align="left"><input   type="password" name="clave" size="15" value="<?php echo $_POST['clave']; ?>" style="font-size:10px"></td>

		</tr>

		 <tr>

		  <td align="left"><span class="Estilo19">Nueva Clave<br>

		  </span></td>

		  <td align="left"><input  type="password" name="nuevaclave"  style="font-size:10px" size="15" value="<?php echo $_POST['nuevaclave']; ?>"></td>

		</tr>

		 <tr>

		  <td align="left"><span class="Estilo19">Confirmar Nueva Clave<br>

		  </span></td>

		  <td align="left"><input  type="password" name="confirmaclave"  style="font-size:10px" size="15" value="<?php echo $_POST['confirmaclave']; ?>"></td>

		</tr>

		<!-- <tr>

		  <td width="60%">Digite una Palabra Clave<br></td>

		  <td width="40%"><input  type="text" name="palabraclave" style="font-size:9px" size="15" value="<?php echo $_POST['palabraclave']; ?>"></td>

		</tr> -->

		<tr>

		  <td colspan="2" align="left"><span class="Estilo5">

	          <input type="submit" name="confirmar" value="Confirmar" style="font-size:9px">

		      <input type="submit" name="cancelar" value="Cancelar" style="font-size:9px">

		    </span></td>

		</tr>

	<?php  

}

function mostrar_cambioclave()

{

?>	

	<tr>

	<td colspan="2" align="left" class="Estilo16">Si olvidó su contraseña envíenos el e-mail que usted registró, y le enviaremos su contraseña a esa dirección.</td>

	</tr>

     <tr>

        <td align="left" class="Estilo16"><strong>Documento</strong>

        </td>

	    <td align="left"><input  type="text" name="usuario" size="15" value="<?php echo $_REQUEST['usuario'];?>" style="font-size:9px"></td>

      </tr>

      <tr>

		<td align="left" class="Estilo16"><strong>E-mail</strong>

		</td>

    	<td align="left">

    	      <input  type="text" name="palabraclave" size="15" value="" style="font-size:9px">

    	      <input  type="hidden" name="palabra" size="15" value="<?php echo $_GET['palabraclave'];?>">

  	  </td>

      </tr>

<?php 

}

function recordar_clave($db)

{

	$usuario = $_REQUEST['usuario'];

	

	/* $query_clave = "select * 

	from estudiantegeneral eg,usuariopreinscripcion u

	where eg.numerodocumento = '$usuario'

	and u.usuariopreinscripcion = eg.numerodocumento ";

	//echo $query_clave;

	$clave = $db->Execute($query_clave);

	$totalRows_clave = $clave->RecordCount();

	$row_clave = $clave->FetchRow(); */

	

	

	$query_clave = "select * 

	from estudiantegeneral eg

	where eg.numerodocumento = '$usuario'

	";

	//echo $query_clave;

	$clave = $db->Execute($query_clave);

	$totalRows_clave = $clave->RecordCount();

	$row_clave = $clave->FetchRow();

	

    if ($row_clave['emailestudiantegeneral'] == $_POST['palabraclave'])

	{                

?>		     <tr>

	         <td colspan="2" align="left"><span class="Estilo16">Al cabo de unos segundos será enviada una nueva contraseña a su correo electrónico <?php echo $row_clave['emailestudiantegeneral'];?></span></td>

			 </tr>

<?php	  	      

		

		

		$query_selusuariopreinscripcion = "select eg.idestudiantegeneral, u.idusuariopreinscripcion

	    from estudiantegeneral eg, usuariopreinscripcion u

	    where eg.numerodocumento = '$usuario'

	    and u.usuariopreinscripcion = eg.numerodocumento";

	    $selusuariopreinscripcion = $db->Execute($query_selusuariopreinscripcion);

	    $totalRows_selusuariopreinscripcion = $selusuariopreinscripcion->RecordCount();

	    $row_selusuariopreinscripcion = $selusuariopreinscripcion->FetchRow();

	    $idestudiantegeneral = $row_selusuariopreinscripcion['idestudiantegeneral'];

	

		if($totalRows_selusuariopreinscripcion == "")

		{

			$query_selusuario = "select eg.idestudiantegeneral

			from estudiantegeneral eg

			where eg.numerodocumento = '$usuario'";

			$selusuario = $db->Execute($query_selusuario);

			$totalRows_selusuario = $selusuario->RecordCount();

			$row_selusuario = $selusuario->FetchRow();

			$idestudiantegeneral = $row_selusuario['idestudiantegeneral'];

		}

		

		$pass = generar_pass(8);

		$direccionemail = $row_clave['emailestudiantegeneral'];

	    mail($direccionemail,"Usuario y Contraseña para proceso de Inscripción","Bienvenido a la Universidad el Bosque.\n\nAdjunto al presente usuario y contraseña para el proceso de inscripción.\n\nusuario:".$usuario."\nclave:$pass","FROM: Universidad el Bosque <ayuda@unbosque.edu.co>\n"); 

	    //$claveencriptada = md5($pass);
        $claveencriptada = hash('sha256', $pass);

	    $treintadias = date('Y-m-d', time() + (60 * 60 * 24 * 30));

	    $noventadias = date('Y-m-d', time() + (60 * 60 * 24 * 90));	 

	    

		if($totalRows_selusuariopreinscripcion == "")

	    { 			

			$query_usuarioinscripcion = "INSERT INTO usuariopreinscripcion(idusuariopreinscripcion,idestudiantegeneral,usuariopreinscripcion,claveusuariopreinscripcion,fechavencimientoclaveusuariopresinscripcion,fechavencimientousuariopresinscripcion)

			VALUES(0,'$idestudiantegeneral','$usuario','$claveencriptada','$treintadias','$noventadias')";

			$user = $db->Execute($query_usuarioinscripcion);

			//echo $query_usuarioinscripcion,"<br><br>";

			$idusuariopreinscripcion = $db->Insert_ID();

			$row_selusuariopreinscripcion['idusuariopreinscripcion'] = 	$idusuariopreinscripcion;		

	    }

	   else

	    {		

			$query_insestudiante = "update usuariopreinscripcion

			set claveusuariopreinscripcion = '$claveencriptada',

			fechavencimientoclaveusuariopresinscripcion = '$treintadias',

			fechavencimientousuariopresinscripcion = '$noventadias'

			where usuariopreinscripcion = '$usuario'";

			//echo "$query_insestudiante <br>";			

			$insestudiante = $db->Execute($query_insestudiante);

		}

		

		$query_estadoclave = "update claveusuariopreinscripcion

		set codigoestadoclaveusuariopreinscripcion = '200'		

		where idusuariopreinscripcion = '".$row_selusuariopreinscripcion['idusuariopreinscripcion']."'";

		//echo "$query_estadoclave <br>";			

		$estadoclave = $db->Execute($query_estadoclave);

		

		$query_claveinscripcion = "INSERT INTO claveusuariopreinscripcion(idclaveusuariopreinscripcion,idusuariopreinscripcion,fechaclaveusuariopreinscripcion,recordarclaveusuariopreinscripcion,claveusuariopreinscripcion,codigoestadoclaveusuariopreinscripcion) 

	    VALUES(0,'".$row_selusuariopreinscripcion['idusuariopreinscripcion']."','".date("Y-m-d H:i:s")."','temporal','$claveencriptada','100')"; 

	    // echo $query_claveinscripcion,"<br>";

		$userclave = $db->Execute($query_claveinscripcion);

	

	    echo "<META HTTP-EQUIV='Refresh' CONTENT='2;URL=aspirantes.php?usuario=".$usuario."'>"; 

        exit();

	}

    else

	{

?>

		     <tr>

	         <td colspan="2" align="left" class="Estilo16">El e-mail digitado no coincide por favor ingrese su Nombre y Apellido para actualizarlo y envío de contraseña.

			 <input type="hidden" name="usuario" value="<?php echo $_REQUEST['usuario']; ?>">

			 </td>

			 </tr>

			 <tr>

        <td align="left" class="Estilo16"><strong>Documento</strong>

        </td>

	    <td align="left"><input  type="text" name="usuario" size="15" value="<?php echo $_REQUEST['usuario'];?>" style="font-size:9px"></td>

      </tr>

            <tr>

			 <td colspan="1" align="left" class="Estilo16"><strong>Nombre:</strong></td>

	         <td colspan="1" align="left" class="Estilo16"><input type="text" style="font-size:9px" size="15" value="<?php echo $_REQUEST['nombreaspirante'] ?>" name="nombreaspirante"></td>

			 </tr>

			 <tr>

			 <td colspan="1" align="left" class="Estilo16"><strong>Apellido:</strong></td>

	         <td colspan="1" align="left" class="Estilo16"><input type="text" style="font-size:9px" size="15" value="<?php echo $_REQUEST['apellidoaspirante'] ?>" name="apellidoaspirante"></td>

			 </tr>

			 <tr>

			 <td colspan="2" align="left" class="Estilo16"><a href="mailto:" style=" color:#000099">ayuda@unbosque.edu.co</a></td>

	         </tr>

<?php	  

	}

}



function confirmar_cambioclave($db)

{

	$usuario = $_REQUEST['usuario'];

	$query_usuarioclave = "select * 

	from usuariopreinscripcion u,claveusuariopreinscripcion c

	where u.idusuariopreinscripcion = c.idusuariopreinscripcion

	and usuariopreinscripcion = '$usuario'

	and codigoestadoclaveusuariopreinscripcion not like '2%'";

	$usuarioclave = $db->Execute($query_usuarioclave);

	$totalRows_usuarioclave = $usuarioclave->RecordCount();

	$row_usuarioclave = $usuarioclave->FetchRow();

	//$claveencriptada = md5($_POST['nuevaclave']);
    $claveencriptada = hash('sha256', $_POST['nuevaclave']);

	//$pass = md5($_POST['clave']);
    $pass = hash('sha256', $_POST['clave']);        

	if ($_POST['clave'] == "") 

	{

		echo '<script language="JavaScript">alert("Debe digitar la contraseña anterior"); history.go(-1);</script>';		 

	}	

	else if ($_POST['nuevaclave'] == "") 

    {

		echo '<script language="JavaScript">alert("Debe digitar una Nueva contraseña"); history.go(-1);</script>';		 

	}

	else if ($_POST['confirmaclave'] == "") 

   	{

		echo '<script language="JavaScript">alert("Debe Confirmar la Nueva contraseña"); history.go(-1);</script>';		 

	}

	else if ($_POST['confirmaclave'] <> $_POST['nuevaclave']) 

    {

		echo '<script language="JavaScript">alert("La Nueva contraseña es diferente a la Confirmación"); history.go(-1);</script>';		 

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

		$claverepetida = $db->Execute($query_claverepetida);

		$totalRows_claverepetida = $claverepetida->RecordCount();

		$row_claverepetida = $claverepetida->FetchRow();

		$indicadorclaverepetida = 0;

		

		do

		{

			if ($row_claverepetida['claveusuariopreinscripcion'] == $claveencriptada)

			{

				$indicadorclaverepetida = 1;

			}		   

		}

		while($row_claverepetida = $claverepetida->FetchRow());

		

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

			$insestudiante = $db->Execute($query_insestudiante);

			

			$query_estadoclave = "update claveusuariopreinscripcion

			set codigoestadoclaveusuariopreinscripcion = '200'		

			where idusuariopreinscripcion = '".$row_usuarioclave['idusuariopreinscripcion']."'";

			//echo "$query_insestudiante <br>";			

			$estadoclave = $db->Execute($query_estadoclave);

			

			$query_claveinscripcion = "INSERT INTO claveusuariopreinscripcion(idclaveusuariopreinscripcion,idusuariopreinscripcion,fechaclaveusuariopreinscripcion,recordarclaveusuariopreinscripcion,claveusuariopreinscripcion,codigoestadoclaveusuariopreinscripcion) 

		    VALUES(0,'".$row_usuarioclave['idusuariopreinscripcion']."','".date("Y-m-d H:i:s")."','".$_POST['palabraclave']."','$claveencriptada','300')"; 

		    $userclave = $db->Execute($query_claveinscripcion);

		}		 

		echo '<script language="JavaScript">alert("Su Clave Fue Cambiada con Exito");</script>';		   

		echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=aspirantes.php?usuario=".$usuario."'>"; 

        exit();

	}	

	else

	{		   

		echo '<script language="JavaScript">alert("La contraseña anterior que fue digitada es incorrecta"); history.go(-1);</script>';	

	}

}



function mostrar_cambioemail($db)

{

	$usuario = $_REQUEST['usuario'];

	$query_selemail = "select eg.idestudiantegeneral, eg.emailestudiantegeneral

	from estudiantegeneral eg

	where eg.numerodocumento = '$usuario'

	and eg.apellidosestudiantegeneral like '%".$_REQUEST['apellidoaspirante']."%'

	and eg.nombresestudiantegeneral like '%".$_REQUEST['nombreaspirante']."%'";

	$selemail = $db->Execute($query_selemail);

	$totalRows_selemail = $selemail->RecordCount();

	$row_selemail = $selemail->FetchRow();

	if($totalRows_selemail != "")

	{

?>

<tr>

      <td colspan="1" align="left"  class="Estilo16">Actualice su e-mail, al cual le será enviada su contraseña</td>

</tr>

<tr>  

	  <td><input type="text" name="emailestudiantegeneral" value="<?php if(isset($_REQUEST['emailestudiantegeneral'])) echo $_REQUEST['emailestudiantegeneral']; else echo $row_selemail['emailestudiantegeneral'];?>" style="font-size:9px" size="20"></td>

</tr>

<?php

	}

	else

	{

?>

<script language="javascript">

	alert("Los datos no se encuentran registrados en la base de datos, para mayor información comuniquese con ayuda@unbosque.edu.co");

	history.go(-1);

</script>

<?php	

	}

}



function cambio_email($db)

{

	$usuario = $_REQUEST['usuario'];

		

	//$db->debug = true;

	$query_selusuariopreinscripcion = "select eg.idestudiantegeneral, u.idusuariopreinscripcion

	from estudiantegeneral eg, usuariopreinscripcion u

	where eg.numerodocumento = '$usuario'

	and u.usuariopreinscripcion = eg.numerodocumento";

	$selusuariopreinscripcion = $db->Execute($query_selusuariopreinscripcion);

	$totalRows_selusuariopreinscripcion = $selusuariopreinscripcion->RecordCount();

	$row_selusuariopreinscripcion = $selusuariopreinscripcion->FetchRow();

	$idestudiantegeneral = $row_selusuariopreinscripcion['idestudiantegeneral'];

	

	if($totalRows_selusuariopreinscripcion == "")

	{

		$query_selusuario = "select eg.idestudiantegeneral

		from estudiantegeneral eg

		where eg.numerodocumento = '$usuario'";

		$selusuario = $db->Execute($query_selusuario);

		$totalRows_selusuario = $selusuario->RecordCount();

		$row_selusuario = $selusuario->FetchRow();

		$idestudiantegeneral = $row_selusuario['idestudiantegeneral'];

	}

	

	$pass = generar_pass(8);

	

	mail($_REQUEST['emailestudiantegeneral'],"Usuario y Clave para proceso de Inscripción","Bienvenido a la Universidad el Bosque.\n\n Adjunto al presente usuario y clave para el proceso de inscripción.\n\n\nusuario:$usuario\nclave:$pass","FROM: Universidad el Bosque <ayuda@unbosque.edu.co>\n");

?>

	<script language="JavaScript">

		alert("Se le ha generado una nueva contraseña: <?php echo $pass ;?>\n\nTambién se le enviara a su e-mail <?php echo $_REQUEST['emailestudiantegeneral'];?> el usuario y la contraseña.");

	</script> 

<?php

	

	$treintadias = date('Y-m-d', time() + (60 * 60 * 24 * 30));

    $noventadias = date('Y-m-d', time() + (60 * 60 * 24 * 90));

	//$pass = md5($pass);
    $pass = hash('sha256', $pass);

	

	// Primero hay que mirar si el usuario esxiste

	// Si no existe toca insertarlo	

	if($totalRows_selusuariopreinscripcion == "")

	{ 

		$query_usuarioinscripcion = "INSERT INTO usuariopreinscripcion(idusuariopreinscripcion,idestudiantegeneral,usuariopreinscripcion,claveusuariopreinscripcion,fechavencimientoclaveusuariopresinscripcion,fechavencimientousuariopresinscripcion)

		VALUES(0,'$idestudiantegeneral','$usuario','$pass','$treintadias','$noventadias')";

		$user = $db->Execute($query_usuarioinscripcion);

		$idusuariopreinscripcion = $db->Insert_ID();

	}

	else

	{

		$query_insestudiante = "update usuariopreinscripcion

		set claveusuariopreinscripcion = '$pass',

		fechavencimientoclaveusuariopresinscripcion = '$treintadias',

		fechavencimientousuariopresinscripcion = '$noventadias'

		where usuariopreinscripcion = '$usuario'";

		//echo "$query_insestudiante <br>";			

		$insestudiante = $db->Execute($query_insestudiante);

	}

	$query_updemail = "update estudiantegeneral
	set emailestudiantegeneral = '".$_REQUEST['emailestudiantegeneral']."',
	fechaactualizaciondatosestudiantegeneral = '" . date("Y-m-d G:i:s", time()) . "'
	where numerodocumento = '$usuario'";

	//echo "$query_insestudiante <br>";			

	$updemail = $db->Execute($query_updemail);

			

	$query_estadoclave = "update claveusuariopreinscripcion

	set codigoestadoclaveusuariopreinscripcion = '200'		

	where idusuariopreinscripcion = '".$row_selusuariopreinscripcion['idusuariopreinscripcion']."'";

	//echo "$query_insestudiante <br>";			

	$estadoclave = $db->Execute($query_estadoclave);

			

	$query_claveinscripcion = "INSERT INTO claveusuariopreinscripcion(idclaveusuariopreinscripcion,idusuariopreinscripcion,fechaclaveusuariopreinscripcion,recordarclaveusuariopreinscripcion,claveusuariopreinscripcion,codigoestadoclaveusuariopreinscripcion) 

    VALUES(0,'$idusuariopreinscripcion','".date("Y-m-d H:i:s")."','temporal','$pass','100')"; 

    $userclave = $db->Execute($query_claveinscripcion);

	

	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=aspirantes.php?usuario=".$usuario."'>";

}

//////////////////////////////////////

if(isset($_REQUEST['emailestudiantegeneral']))

{

	// Entra si se le va actualizar el correo y enviar clave a ese correo

	cambio_email($db);

} 

else if(isset($_REQUEST['nombreaspirante']))

{

	mostrar_cambioemail($db);

}

else if (isset($_GET['cambioclave']) or isset($_POST['cambioclave']))

{

	cambio_clave();

}

else if (isset($_GET['palabra']) or isset($_POST['palabra']))

{

	if(!isset($_REQUEST['palabraclave']))

	{

		mostrar_cambioclave();

	}

	if ($_POST['ingresar'])

	{	   

		if ($_POST['palabraclave'] == "")

		{

			echo '<script language="JavaScript">alert("Debe digitar su Usuario y E-mail"); history.go(-1);</script>';

		    exit();

		}

		recordar_clave($db);	

	}

} // if 1

else

{ //else

	iniciar_sesion($db);

}

if(!isset($_REQUEST['palabra']) && !isset($_REQUEST['cambioclave']) && !isset($_POST['palabraclave']))

{

?>    

	<tr>

      <td colspan="2" align="left"><input type="submit" name="ingresar" value="Entrar" style="font-size:9px">

            <input type="submit" name="cambio" value="Cambio Clave" style="font-size:9px">

      </td>

	</tr>

<?php 

}

else if(isset($_POST['palabraclave']))

{

?>    

<tr>

      <td colspan="2" align="left"><span class="Estilo5">

            <input type="submit" name="ingresar" value="Entrar" style="font-size:9px">



			<input type="submit" name="cancelar" value="Regresar" style="font-size:9px">

      </span></td>

</tr>

<?php 

}

else if(isset($_REQUEST['palabra']))

{

?>    

<tr>

      <td colspan="2" align="left"><span class="Estilo5">

            <input type="submit" name="ingresar" value="Entrar" style="font-size:9px">

            <input type="submit" name="cancelar" value="Cancelar" style="font-size:9px">

      </span></td>

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

	confirmar_cambioclave($db);

}

?>

</form>

