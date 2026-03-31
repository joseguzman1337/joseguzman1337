<? /*
if (__Conexion_inc == 1)
	return;
define ('__Conexion_inc', 1);
*/
	
$Conectado = 0;

include_once "parametros.inc.php";

function Conexion1()
{
$link=mysql_connect("localhost","root","");
return $link;
}
function Desconectar1() 
{
 mysql_close();
}

function Conexion() {

	global $Conectado;
	global $mysql_host;
	global $mysql_user;
	global $mysql_pwd;
	global $mysql_base;


	    $mysql_host=Devolver_Servidor().Devolver_Puerto();
        $mysql_user=Devolver_Usuario();
        $mysql_pwd =Devolver_Clave();
        $mysql_base=Devolver_Database();
        // echo $mysql_base;
		/*echo $mysql_host;
		echo $mysql_user;
		echo $mysql_pwd;
		echo $mysql_base;
*/
	$milink=false;
	if (!$Conectado){
		$milink= mysql_pconnect($mysql_host, $mysql_user, $mysql_pwd);
	//	$milink=mysql_connect($mysql_host, $mysql_user, $mysql_pwd);
		//echo $milink;
		//echo $mysql_base;
		mysql_select_db($mysql_base , $milink);
		}
    


	//mysql_select_db($mysql_base);

	$Conectado++;
	return $milink;
}

function Desconectar() {
	global $Conectado;

	if ($Conectado>1)
		$Conectado--;
	else {
		mysql_close();
		$Conectado=0;
	}
}
?>
