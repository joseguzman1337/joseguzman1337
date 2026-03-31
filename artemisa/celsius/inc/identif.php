<? 
  /* if (__identif_inc == 1)
		return;
	define ('__identif_inc', 1);
*/

//  
include_once "sesion.inc";
include_once "parametros.inc.php";
include_once "var.inc.php";

function Administracion()
{
	global $Usuario;
	global $Id_usuario;
	global $Rol;
	global $Instit_usuario;
	
	$enviar="Usuario:".$Usuario."\n";
    $enviar.="Id Usuario:".$Id_usuario."\n";
    $enviar.="Usuario:".SesionToma("Rol")."\n";
    $enviar.="Usuario:".$Instit_usuario."\n";

	
	if (SesionToma("Rol")!="1")
	{
	  mysql_close();	
//	  echo "Location: ".Obtener_Direccion()."../admin/login.php";
	  header("Location: ".Devolver_URL_completa()."/admin/login.php");
	}
	else
	{
		$Usuario=SesionToma("Usuario");
		$Id_usuario=SesionToma("Id_usuario");
		$Instit_usuario = SesionToma("Instit_usuario");
		$Rol=1;
	}
	return;
}

function Usuario()
{
	global $Usuario;
	global $Id_usuario;
	global $Rol;
	global $Instit_usuario;
	global $Bibliotecario;
	global $Dependencia;
	global $Unidad;
	
	$Usuario=SesionToma("Usuario");
	$Id_usuario=SesionToma("Id_usuario");
	$Instit_usuario = SesionToma("Instit_usuario");
	
	switch (SesionToma("Rol"))
	{
		case 1:
			$Rol=1;
			$Bibliotecario=0;
			break;
		case 2:
			$Rol=2;
			$Bibliotecario = SesionToma("Bibliotecario");
	   	    $Dependencia = SesionToma("Dependencia");
		    $Unidad = SesionToma("Unidad");
			break;
		case 3:
		   
		 $Rol=3;
			$Bibliotecario = SesionToma("Bibliotecario");
	   	    $Dependencia = SesionToma("Dependencia");
		    $Unidad = SesionToma("Unidad");
			break;
		default:
			mysql_close();	
            header("Location: ".Devolver_URL_completa()."/usuarios/sitiousuario.php");

		
	}
	return;
}

function Bibliotecario()
{
	global $Usuario;
	global $Id_usuario;
	global $Rol;
	global $Instit_usuario;
	global $Bibliotecario;
	global $Dependencia;
	global $Unidad;
	
	$Usuario=SesionToma("Usuario");
	$Id_usuario=SesionToma("Id_usuario");
	$Instit_usuario = SesionToma("Instit_usuario");
	$paramandarpormail=$Usuario.','.$Id_usuario.','.$Instit_usuario.','.SesionToma("Rol");
	
	

	switch (SesionToma("Rol"))
	{
		case 1:
			$Bibliotecario=0;
			$Rol=1;
			break;
		case 2:
			$Rol=2;
			$Bibliotecario = SesionToma("Bibliotecario");
	   	    $Dependencia = SesionToma("Dependencia");
		    $Unidad = SesionToma("Unidad");
			break;
         case 3:
		      $Rol=3;
		      $Bibliotecario=0;
		      break;     
				
		default:
			mysql_close();	
            header("Location: ".Devolver_URL_completa()."/usuarios/sitiousuario.php");

		
	}
	return;
}
?>
