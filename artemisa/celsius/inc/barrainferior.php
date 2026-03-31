<?
  include_once "parametros.inc.php";

  // este php solo incluye la barra de navegación
  function DibujarBarraInferior($IdiomaSitio=1) {
  $address = Devolver_URL_completa();

  switch ($IdiomaSitio)
	{
		case 1: //castellano
			$Mensajes = array("msg-1"=>"Investigación","msg-2"=>"Otros Servicios","msg-3"=>"Contáctenos");
			break;
    	case 2:  //portugues
            $Mensajes = array("msg-1"=>"Investigación","msg-2"=>"Otros Servicios","msg-3"=>"Contáctenos");
			break;
		case 3: //english
   			$Mensajes = array("msg-1"=>"Research","msg-2"=>"Other services","msg-3"=>"Contact us");
			break;
		default :  // == castellano
   			$Mensajes = array("msg-1"=>"Investigación","msg-2"=>"Otros Servicios","msg-3"=>"Contáctenos");
	}

 echo '
   <tr>
    <td height="25" background="'.$address.'/images/bar-below.jpg" bgcolor="#E4E4E4">
    <div align="center" style="font-size:10px;font-family:Verdana;color:FFFFFF">
         <!-- esto lo saca gonzalo. No corresponde q esto este visible aqui
	     <a href="'.$address.'/usuarios/investigacion.php">
              <span style="color:#E4E4E4">'.$Mensajes["msg-1"].'</span></a>
         <span style="color:#006699"> |</span>
           <a href="'.$address.'/usuarios/otrosservicios.php">
                <span style="color:#E4E4E4">'.$Mensajes["msg-2"].'</span></a>
         <span style="color:#006699">|</span> -->
           <a href="'.$address.'/mail/contactus.php">
              <span style="color:#E4E4E4">'.$Mensajes["msg-3"].'</span></a>
     </div></td>
  </tr>';
   }

//aprovechando que éste script se usa en muchísimas paginas, lo uso para acceder a head y poner los mensajes correspondientes si esta logueado o no:
  switch ($IdiomaSitio)
	{
		case 1: //castellano
			$Mensajes = array("usr-logued"=>"Sitio de Usuarios","usr-notlogued"=>"Login Usuario","adm-logued"=>"Sitio de Administración", "adm-notlogued"=>"Login Administrador");
			break;
    	case 2:  //portugues
            $Mensajes = array("usr-logued"=>"Local dos usuários","usr-notlogued"=>"Início de uma sessão dos usuários","adm-logued"=>"Local da administração", "adm-notlogued"=>"Início de uma sessão da administração");
			break;
		case 3: //english
   			$Mensajes = array("usr-logued"=>"Users Site","usr-notlogued"=>"User Login","adm-logued"=>"Administration Site", "adm-notlogued"=>"Administration Login");
			break;
		default :  // == castellano
   			$Mensajes = array("usr-logued"=>"Sitio de Usuarios","usr-notlogued"=>"Login Usuario","adm-logued"=>"Sitio de Administración", "adm-notlogued"=>"Login Administrador");
	}


/*echo "<script>";
//atroden

if (!isset($Id_usuario))
  global $Id_usuario;
if (!isset($Rol))
  global $Rol;

if (($Id_usuario != '') && ($Id_usuario > 0))
{  echo "window.parent.frames[0].document.getElementById('login').firstChild.nodeValue = '".$Mensajes['usr-logued']."'\n"; //es usuario comun
         
   if ($Rol ==1) //es administrador
       echo "window.parent.frames[0].document.getElementById('login_admin').firstChild.nodeValue = '".$Mensajes['adm-logued']."'\n";
	else
		echo "window.parent.frames[0].document.getElementById('login_admin').firstChild.nodeValue = '".$Mensajes['adm-notlogued']."'\n";
}
else //no esta logueado
{
        echo "window.parent.frames[0].document.getElementById('login').firstChild.nodeValue = '".$Mensajes['usr-notlogued']."'\n"; 
		echo "window.parent.frames[0].document.getElementById('login_admin').firstChild.nodeValue = '".$Mensajes['adm-notlogued']."'\n";
}
//

echo "</script>";*/
?>