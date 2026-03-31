<?php 
class claseldap{
var $servidor;
var $puerto;
var $cadenaadmin;
var $conexion;
var $password;
var $tmpexisteusuario;
var $msgsientradaestudiante;
var $msgnoentradaestudiante;
var $raizdirectorio;
function claseldap($servidor,$password,$puerto,$cadenaadmin,$objetobase="",$raizdirectorio=""){
		
		//$this->raizdirectorio="dc=unbosque,dc=edu,dc=co";
		if(trim($raizdirectorio)!="")
		$this->raizdirectorio=$raizdirectorio;
		else
		$this->raizdirectorio="dc=admin,dc=com";
		$this->servidor=$servidor;
		$this->puerto=$puerto;
		$this->adminpassword=$password;
		$this->cadenaadmin=$cadenaadmin;
		$this->msgnoentradaestudiante="<br>No ingreso entrada Estudiante"; 
		$this->msgsientradaestudiante="<br>Ingreso entrada Estudiante"; 
		if($objetobase!=""){
			$this->objetobase=$objetobase;
		}
		$this->conexion=ldap_connect($this->servidor,$this->puerto);  // Asumimos que el servidor LDAP esta en el
   		@ldap_set_option($this->conexion,LDAP_OPT_PROTOCOL_VERSION,3);
		@ldap_set_option($this->conexion,LDAP_OPT_REFERRALS,0);
}
function Cerrar(){
ldap_close($this->conexion);
}
function ConexionAdmin(){

    if(!($resultado=@ldap_bind($this->conexion,$this->cadenaadmin,$this->adminpassword))){
	echo "ERROR DE CONEXION, COMPRUEBE LA CONEXION AL SERVIDOR LDAP ".$this->conexion.",".$this->cadenaadmin.",";
	$resultado=@ldap_bind($this->conexion);
	}
}
//Ingreso de diferente tipo de cuentas
function  CrearEntrada($tipoentrada,$usuario,$password,$informacionadicional="",$dependencia="",$dependenciapadre=""){
	switch ($tipoentrada){
		case "docente":
			if(!$this->EntradaDocente($usuario,$password,$informacionadicional)){
				echo "<br>ENTRADA DE DOCENTE ".$usuario." FALLIDA";
				return false;
			}
		break;
		case "administrador":
			if(!$this->EntradaAdministrador($usuario,$password,$informacionadicional,$dependencia)){
				echo "<br>ENTRADA DE ADMINISTRADOR ".$usuario." FALLIDA";
				return false;
				
			}
		break;
		case "estudiante":
			if(!$this->EntradaEstudiante($usuario,$password,$informacionadicional,$dependencia)){
				echo "<br>ENTRADA DE ESTUDIANTE ".$usuario." FALLIDA";
				return false;			
			}
		break;
		case "dependencia":
			if(!$this->EntradaDependencia($dependencia,$informacionadicional,$dependenciapadre)){
				echo "<br>ENTRADA DE DEPENDENCIA ".$usuario." FALLIDA";
				return false;			
			}
		break;

	}
	return true;
}
//Entrada de cuentas de docente
function EntradaDocente($usuario,$password,$informacionadicional,$dnpadre){
//INFORMACION OBLIGATORIA DEL USUARIO
	$info["cn"]=$usuario;
	$info["uid"]=$usuario;	
	$info["givenName"]=quitartilde($informacionadicional["nombres"]);	
	$info["sn"]=quitartilde($informacionadicional["apellidos"]);
	$info["mail"]=trim($usuario)."@unbosque.edu.co";
	$info["gidNumber"]=14969;	
	$info["homeDirectory"]="/home/".$usuario;


	$info['objectclass'][0] = "inetOrgPerson";
	$info['objectclass'][1] = "posixAccount";
	$info['objectclass'][2] = "googleUser";
	$info['objectclass'][3] = "top";
	$info['objectclass'][4] = "shadowAccount";
	$info["uidNumber"]=14965;

	$tiempo=(int) (mktime(0, 0, 0, date("m"), (date("d")+1), date("Y"))/(24*60*60));		
	$info["userPassword"]="{MD5}".base64_encode(pack("H*",md5($password)));
	$info["gacctFirstAccess"]="N";
	if(trim($informacionadicional["mail"])!='')
		$info["gacctMail"]=$informacionadicional["mail"];
	else
		$info["gacctMail"]=trim($usuario)."@unbosque.edu.co";
	$info["gacctVerified"]="Y";

	$respuesta=ldap_add($this->conexion,"cn=".$usuario.",".$dnpadre, $info);
    if(!$respuesta)
		return false;
		
	return true;
}
function EntradaEstudiante($usuario,$password,$informacionadicional,$dnpadre){
//INFORMACION OBLIGATORIA DEL USUARIO
 /*	$info["givenName"]="Estudiante numero3";
    $info["mail"]="docente4.p@example.com";
	$info["documentIdentifier"]="";
	$info["employeeNumber"]="";*/
	//$infoestudiante=$this->EntradaDependencia($informacionadicional["givenName"],$informacionadicional,"ou=Estudiante,".$this->raizdirectorio);
	//$dnpadre=$infoestudiante["dnpadre"];
	//unset($infoestudiante["dnpadre"]);
	//$info=$informacionadicional;
	//$info["cn"]=$usuario;	
	$info["cn"]=$usuario;
	$info["uid"]=$usuario;	
	$info["givenName"]=quitartilde($informacionadicional["nombres"]);	
	$info["sn"]=quitartilde($informacionadicional["apellidos"]);
	$info["mail"]=trim($usuario)."@unbosque.edu.co";
	$info["gidNumber"]=14969;	
	$info["homeDirectory"]="/home/".$usuario;


	$info['objectclass'][0] = "inetOrgPerson";
	$info['objectclass'][1] = "posixAccount";
	$info['objectclass'][2] = "googleUser";
	$info['objectclass'][3] = "top";
	$info['objectclass'][4] = "shadowAccount";
	//$info['objectclass'][3] = "posixAccount";
	$info["uidNumber"]=14965;

	//$info['objectclass'][2] = "shadowAccount";
	$tiempo=(int) (mktime(0, 0, 0, date("m"), (date("d")+1), date("Y"))/(24*60*60));		
	//$info["shadowLastChange"]=$tiempo;
	$info["userPassword"]="{MD5}".base64_encode(pack("H*",md5($password)));
	//$info["userPassword"]="{crypt}".$password;
	//$info["homeDirectory"]="/home/users/bosque/".$usuario;
	//$info["gidNumber"]=510;	
	//$info["uidNumber"]=$informacionadicional["numerodocumento"];
 	//$info["loginShell"]="/bin/false";
	//$info['objectClass'][0] = "organizationalUnit";
	//$info['objectClass'][1] = "top";	
	$info["gacctFirstAccess"]="N";
	if(trim($informacionadicional["mail"])!='')
	$info["gacctMail"]=$informacionadicional["mail"];
	else
	$info["gacctMail"]=trim($usuario)."@unbosque.edu.co";
	$info["gacctVerified"]="Y";
	//$info["gecos"]=$informacionadicional["apellidos"]." ".$informacionadicional["nombres"];
	
 	//echo "<pre>";
	//print_r($informacionadicional);
	//echo "</pre>";
 	echo "cn=".$usuario.",".$dnpadre."<br>";
	$respuesta=ldap_add($this->conexion,"cn=".$usuario.",".$dnpadre,$info);
    if(!$respuesta){
		echo $this->msgnoentradaestudiante;
		return false;
	}
	echo $this->msgsientradaestudiante;
	return true;
}
function EntradaPadre($usuario,$password,$emailusuariopadre,$dnpadre, $nombresusuariopadre, $apellidosusuariopadre){
//INFORMACION OBLIGATORIA DEL USUARIO
 /*	$info["givenName"]="Estudiante numero3";
    $info["mail"]="docente4.p@example.com";
	$info["documentIdentifier"]="";
	$info["employeeNumber"]="";*/
	//$infoestudiante=$this->EntradaDependencia($informacionadicional["givenName"],$informacionadicional,"ou=Estudiante,".$this->raizdirectorio);
	//$dnpadre=$infoestudiante["dnpadre"];
	//unset($infoestudiante["dnpadre"]);
	//$info=$informacionadicional;
	//$info["cn"]=$usuario;
    //echo "entro a la claselap <br>".$usuario." ".$password." ".$emailusuariopadre." ".$dnpadre." ".$nombresusuariopadre." ".$apellidosusuariopadre;

	$info["cn"]=$usuario;
	$info["uid"]=$usuario;
	$info["givenName"]=quitartilde($nombresusuariopadre);
	$info["sn"]=quitartilde($apellidosusuariopadre);
	$info["mail"]=trim($emailusuariopadre);
	$info["gidNumber"]=14969;
	$info["homeDirectory"]="/home/".$usuario;


	$info['objectclass'][0] = "inetOrgPerson";
	$info['objectclass'][1] = "posixAccount";
	$info['objectclass'][2] = "googleUser";
	$info['objectclass'][3] = "top";
	$info['objectclass'][4] = "shadowAccount";
	//$info['objectclass'][3] = "posixAccount";
	$info["uidNumber"]=14965;

	//$info['objectclass'][2] = "shadowAccount";
	$tiempo=(int) (mktime(0, 0, 0, date("m"), (date("d")+1), date("Y"))/(24*60*60));
	//$info["shadowLastChange"]=$tiempo;
	$info["userPassword"]="{MD5}".base64_encode(pack("H*",md5($password)));
	//$info["userPassword"]="{crypt}".$password;
	//$info["homeDirectory"]="/home/users/bosque/".$usuario;
	//$info["gidNumber"]=510;
	//$info["uidNumber"]=$informacionadicional["numerodocumento"];
 	//$info["loginShell"]="/bin/false";
	//$info['objectClass'][0] = "organizationalUnit";
	//$info['objectClass'][1] = "top";
	$info["gacctFirstAccess"]="N";
	$info["gacctMail"]=trim($emailusuariopadre);
	$info["gacctVerified"]="Y";
	//$info["gecos"]=$informacionadicional["apellidos"]." ".$informacionadicional["nombres"];

 	//echo "<pre>";
	//print_r($informacionadicional);
	//echo "</pre>";
 	//echo "cn=".$usuario.",".$dnpadre."<br>";
	$respuesta=ldap_add($this->conexion,"cn=".$usuario.",".$dnpadre,$info);
        if(!$respuesta){
		echo $this->msgnoentradaestudiante;
		return false;
	}
	//echo $this->msgsientradaestudiante;
	return true;
}
function EntradaDependencia($dependencia,$informacionadicional,$dnpadre){
//INFORMACION OBLIGATORIA DEL USUARIO
 /*   $info["givenName"]="Estudiante numero3";
    $info["mail"]="docente4.p@example.com";
	$info["documentIdentifier"]="";
	$info["employeeNumber"]="";
//	$info["uid"]=$usuario;
	*/
	//$info["uid"]=$usuario;
	if(is_array($informacionadicional["nivel"])){
		//echo "<br>Entro nivel".$informacionadicional["givenName"]."<br>";
		
			$informacionadicionaltmp=$informacionadicional;
			unset($informacionadicionaltmp["nivel"]);
			
			$info=$informacionadicionaltmp;
			unset($info["givenName"]);
			//$info["cn"]=$dependencia;
			//$info["sn"]=$dependencia;	
			$info["ou"]=$dependencia;	
			$info['objectClass'][0] = "organizationalUnit";
			$info['objectClass'][1] = "top";
			//$info["userPassword"]="{MD5}".base64_encode(pack("H*",md5($password)));
/* 			echo "<pre>";
			print_r($info);
			echo "</pre>";
 */
			//$dependencia["givenName"]
			//$sr=ldap_search($this->conexion,"ou=Estudiante,dc=adminldap,dc=com", "givenName=".$dependencia["givenName"]);  
			//$info=array_merge($info, $informacionadicional);
			//echo "<br>ou=".$dependencia.",".$dnpadre;
			if(!$this->AutentificarEntrada($dnpadre,"ou=".$dependencia)){
				echo "Entro ha hacer entrada "."ou=".$dependencia.",".$dnpadre."<br>";
				$respuesta=ldap_add($this->conexion,"ou=".$dependencia.",".$dnpadre, $info);
			}
			if(!$respuesta){
				//echo "No ingreso entrada "."ou=".$dependencia.",".$dnpadre."<br>";
				//echo "No ingreso entrada "."ou=".$dependencia.",".$dnpadre."<br>";
				//return false;
			}
			$informacion=$this->EntradaDependencia($informacionadicional["nivel"]["givenName"],$informacionadicional["nivel"],"ou=".$dependencia.",".$dnpadre);

			return $informacion;
				
	}
	else{
		//echo "salio?<br>";
		$informacionadicional["dnpadre"]=$dnpadre;
		return $informacionadicional;
	}
}

function Autentificar($usuario,$password){
    $sr=ldap_search($this->conexion,$this->raizdirectorio, "uid=".$usuario);  
    $info = ldap_get_entries($this->conexion, $sr);

	if(ldap_count_entries($this->conexion,$sr)<1)
		$this->tmpexisteusuario=false;
	else
		$this->tmpexisteusuario=true;

	//$this->tmpexisteusuario=true;
	/*echo "<pre>";
	print_r($info);
	echo "</pre>";
	echo $info[0]["dn"];*/
	//if($info[0]["userpassword"][0]=="{MD5}".base64_encode(pack("H*",md5($password)))){
	ldap_close($this->conexion);
	$this->conexion=ldap_connect($this->servidor,$this->puerto);  // Asumimos que el servidor LDAP esta en el
	@ldap_set_option($this->conexion,LDAP_OPT_PROTOCOL_VERSION,3);
	@ldap_set_option($this->conexion,LDAP_OPT_REFERRALS,0);
	//echo "\n".$info[0]["dn"].",".$password;
	if(@$resultado=ldap_bind($this->conexion,$info[0]["dn"],$password)){
		return true;
	}
	
	return false;
}
function DatosUsuario($usuario){
    $sr=ldap_search($this->conexion,$this->raizdirectorio, "uid=".$usuario);  
    $info = ldap_get_entries($this->conexion, $sr);
	if(ldap_count_entries($this->conexion,$sr)<1)
		return false;
	else
		return $info;
}
function BusquedaUsuarios($direccionbusqueda){
	$sr=ldap_search($this->conexion,$this->raizdirectorio,$direccionbusqueda);  
    $info = ldap_get_entries($this->conexion, $sr);
	return $info;
}
function ModificacionUsuario($infomodificado,$usuario){
   $sr=ldap_search($this->conexion,$this->raizdirectorio, "uid=".$usuario);  
   $info = ldap_get_entries($this->conexion, $sr);
 /*
   echo "<pre>";
   print_r($infomodificado);
   echo "</pre>";
   echo "<br>DN=".$info[0]["dn"];
 */
	if(@ldap_modify ($this->conexion, $info[0]["dn"], $infomodificado))
		{
		//echo "RETORNA VERDADERO MODIFICACION";
		//exit();
		return 1;
		}
	else{
		//echo "RETORNA FALSO MODIFICACION";
		//exit();
		return 0;
		}
}
function AdicionUsuario($infomodificado,$usuario){
   $sr=ldap_search($this->conexion,$this->raizdirectorio, "uid=".$usuario);  
   $info = ldap_get_entries($this->conexion, $sr);
  /*
   echo "<pre>";
   print_r($infomodificado);
   echo "</pre>";
   echo "<br>DN=".$info[0]["dn"];
  */
	if(@ldap_add($this->conexion, $info[0]["dn"], $infomodificado))
		{
		//echo "RETORNA VERDADERO ADICION";
		//exit();
		return 1;
		}
	else{
		//echo "RETORNA FALSO ADICION";
		//exit();
		return 0;
		}
}

function AutentificarEntrada($cadena,$busqueda){
//echo "<br>$cadena, $busqueda<br>";
    $sr=ldap_search($this->conexion,$cadena, $busqueda);  
	if(ldap_count_entries($this->conexion,$sr)==0){
		echo "No Encontro entradas<br>";
		return false;
	}
return true;
}
function SetVersion($version,$definicion=LDAP_OPT_PROTOCOL_VERSION){
		@ldap_set_option($this->conexion,$definicion,$version);

}
function SetReferencia($referencia,$definicion=LDAP_OPT_REFERRALS){
		@ldap_set_option($this->conexion,$definicion,$referencia);
}
function CreaUsuarioGoogle($datosusuario){
	require_once(dirname(__FILE__)."/../../../../../interfacegoogle/crearusuariogoogle.php");
		
	crearUsuarioGoogle($usuario,$apellidos,$nombres,$clave);
	/*echo $archivo=URLCREAUSUARIOGAPPS;
	$usuario=$datosusuario["usuario"];
	$nombres=quitartilde(str_replace(" ","_",$datosusuario["nombres"]));
	$apellidos=quitartilde(str_replace(" ","_",$datosusuario["apellidos"]));
	$clave=$datosusuario["clave"];
	$getcreusuario="?clave=".$clave."&apellidos=".$apellidos."&nombres=".$nombres."&usuario=".$usuario."&clavemd5=".md5(CLAVECREAUSUARIOGAPPS);
	//$recurso=fopen($archivo.$getcreusuario,"r");
	//$salida=fread($recurso,1000);
	$salida=file_get_contents($archivo.$getcreusuario);
	echo "<H1>SALIDA DEL ARCHIVO</H1><BR>".$salida;*/
	//fclose($recurso);
}

}

?>