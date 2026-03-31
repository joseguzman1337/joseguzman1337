<?php include ('auth.php')?>
<?php
// *** Validate request to login to this site.
session_start();

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($accesscheck)) {
  $GLOBALS['PrevUrl'] = $accesscheck;
  session_register('PrevUrl');
}

if (isset($_POST['user'])) {
  $loginUsername=$_POST['user'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "singup.php";
  $MM_redirectLoginFailed = "login.php";
  $MM_redirecttoReferrer = false;
    

  $loginFoundUser = validar($loginUsername,$password);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $GLOBALS['MM_Username'] = $loginUsername;
    $GLOBALS['MM_UserGroup'] = $loginStrGroup;	      

    //register the session variables
    session_register("MM_Username");
    session_register("MM_UserGroup");

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Bosque en linea</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.style2 {
	font-family: Tahoma;
	font-size: small;
	font-weight: bold;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
.Estilo2 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
-->
</style>
</head>

<body>
<img src="../../imagenes/sala/serviciosacademicosinterna.jpg" width="750" height="122"><br>
<div align="center"><br>
  <br>
  <table width="90%"  border="0" align="left">
    <tr>
      <td><div align="center">
        <p><span class="Estilo2">Usted no esta registrado como estudiante activo de la Universidad<br>
  Por favor ac&eacute;rquese a su Facultad.</span><span class="Estilo1"><br>
          <strong>Si usted esta digitando su numero de c&eacute;dula, por favor intente con la tarjeta de identidad</strong><strong>.</strong> </span><br>
          </p>
        </div></td>
    </tr>
  </table>
</div>
</body>
</html>
