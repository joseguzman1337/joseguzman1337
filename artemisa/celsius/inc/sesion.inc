<?

	include_once "random.inc";
	include_once "parametros.inc.php";

	// Te banco hasta una hora inactivo
	// despues de eso te borro la sesión
	$SesionTiempo = Maximo_Sesion();
	
function SesionDepura() {
	global $SesionTiempo;
	global $CkSesionId;

	$tiempo = time() - $SesionTiempo;
	// Aca habría que verificar que mi sesión no esté incluida
	// en esta depuración, si lo está eliminar la cookie
	Conexion();
	
	$SesionId = $CkSesionId;
//	echo Devolver_Database();
	$rs = mysql_query("select id, codigo, texto from sesion where Codigo = '".$SesionId."' and Tiempo < ".$tiempo."");
	//echo "select id, codigo, texto from sesion where Codigo = '".$SesionId."' and Tiempo < ".$tiempo."";
   //     echo mysql_error();
	if (mysql_num_rows($rs))
	{
		// Perdi sesion, me desconecte por demasiado 
		// tiempo
		SesionDestruye();
	}
	mysql_query("delete from sesion where Tiempo < $tiempo");
	
}

function SesionDestruye() {
	global $CkSesionId;
	
	if (!$CkSesionId)
		return;

	mysql_query("delete from sesion where Codigo = '$CkSesionId'");
	setcookie('CkSesionId','', 0, "/");

}

function SesionCrea() {
	global $SesionId;
	global $Sesion;

	$SesionId = RandName(16);
//    $SesionId ='abcdefghi';
	$Sesion = array();
	$Texto = addSlashes(serialize($Sesion));
	$res=mysql_query("insert sesion set
		Codigo = '$SesionId',
		Texto = '$Texto',
		Tiempo = unix_timestamp()
		");
	if (!$res)
	{
		// preveo una identificacion duplicada...
		$SesionId='';
		return false;
	}
	else
	{
		setcookie('CkSesionId', $SesionId, 0, "/");	
		return true;
	}
}

function SesionLee() {
	global $CkSesionId;
	global $SesionId;
	global $Sesion;

	
	SesionDepura();

	if ($CkSesionId) {
		$SesionId=$CkSesionId;

		$rs = mysql_db_query(Devolver_Database(),"select id, codigo, texto from sesion where Codigo = '$SesionId'");

		if ($rs && mysql_num_rows($rs)) {
			list($Id,$Codigo,$Texto) = mysql_fetch_row($rs);
			$Sesion = unserialize($Texto);
			mysql_query("update sesion set Tiempo = unix_timestamp() where Codigo = '$SesionId'");
		}
	}

}

function SesionGraba() {
	global $Sesion;
	global $SesionId;

	
	$Texto = addSlashes(serialize($Sesion));
	$query = "update sesion set Texto = '$Texto', Tiempo = unix_timestamp() where Codigo = '$SesionId'";
	$res = mysql_query($query);
	if (!$res)
		echo mysql_error();

	
}

function SesionToma($nombre) {
	global $Sesion;

	if (is_array($Sesion))
		return($Sesion[$nombre]);

	return '';
}

function SesionPone($nombre,$valor,$graba=1) {
	global $Sesion;

	$Sesion[$nombre]=$valor;

	if ($graba)
		SesionGraba();
}

function SesionSaca($nombre,$graba=1) {
	global $Sesion;

	unset($Sesion[$nombre]);

	if ($graba)
		SesionGraba();
}

function SesionMuestra() {
	global $Sesion;
	global $SesionId;

	reset($Sesion);

	echo "SesionId: $SesionId<br>\n";

	while (list($codigo,$valor) = each($Sesion))
		echo "$codigo: $valor<br>\n";
}

	SesionLee();
?>
