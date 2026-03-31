<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
$rutaado=("../../../../funciones/adodb/");
require_once(realpath(dirname(__FILE__))."/../../../../Connections/salaado-pear.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/clases/formulario/clase_formulario.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/phpmailer/class.phpmailer.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/validaciones/validaciongenerica.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once(realpath(dirname(__FILE__)).'/../../../../funciones/sala_genericas/FuncionesSeguridad.php');
require_once(realpath(dirname(__FILE__)).'/../../../../funciones/sala_genericas/FuncionesMatematica.php');
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once(realpath(dirname(__FILE__))."/../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once(realpath(dirname(__FILE__))."/clasemenusic.php");

//if(!isset($_GET['saveString']))die("no input");
//echo "Message from saveNodes.php\n";

$objetobase=new BaseDeDatosGeneral($sala);

$parejas = explode(",",$_GET['saveString']);
for($conparejas=0;$conparejas<count($parejas);$conparejas++){
	$item = explode("-",$parejas[$conparejas]);

	//echo "ID: ".$item[0]. " is sub of ".$item[1]."\n";	// Just for testing
	
				$tabla="itemsic";
				$nombreidtabla="iditemsic";
				$idtabla=$item[0];
				
				//$fila["idencuesta"]=$_POST["idencuesta"];
				$fila["iditemsicpadre"]=$item[1];
				$fila["pesoitemsic"]=$conparejas;
				$condicionactualiza="";
				$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla,"",0);
	// Example of sql
	
	// mysql_query("update nodes set parentID='".$tokens[1]."',position='$no' where ID='".$tokens[0]."'") or die(mysql_error());
	// for a table like this:
	
	/*
	
	nodes
	---------------------
	ID int
	title varchar(255)
	position int
	parentID int
	
	*/
	
}
echo "Guardo satisfactoriamente";
?>