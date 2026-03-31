<?php 
session_start();
 include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
$ruta="../../../";
require_once("../../../consulta/generacionclaves.php");
$rutaado=("../../../funciones/adodb/");
require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado-pear.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/clasebasesdedatosgeneral.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/FuncionesCadena.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/FuncionesFecha.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/formulario/clase_formulario.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/formulariobaseestudiante.php');
ini_set('max_execution_time','600000');


$objetobase=new BaseDeDatosGeneral($salaobjecttmp);
$condicion=" and codigoestadoperiodo like '1%'";
$datosperiodo=$objetobase->recuperar_datos_tabla("periodo","1",1,$condicion,"",0);
//$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
//$objetobase->conexion->query("select usuario from usuario order by usuario desc");


$condicion="";
echo $query="SELECT o.numeroordenpago numerordenpagotmp,e.codigoestudiante,min(o2.numeroordenpago) numeroordenpago
		FROM ordenpago o, detalleordenpago d, carrera c, concepto co,  estudiantegeneral eg,estudiante e		
		left join ordenpago o2 on o2.codigoestudiante=e.codigoestudiante and 
		o2.codigoestadoordenpago like '4%'
		left join detalleordenpago d2 on d2.numeroordenpago=o2.numeroordenpago
		WHERE o.numeroordenpago=d.numeroordenpago
		and d2.codigoconcepto=co.codigoconcepto
		AND e.codigoestudiante=o.codigoestudiante
		AND c.codigocarrera=e.codigocarrera
		AND d.codigoconcepto=co.codigoconcepto
		AND co.cuentaoperacionprincipal=151
		AND o.codigoestadoordenpago LIKE '4%'
		and o.codigoperiodo='".$datosperiodo['codigoperiodo']."'
		and eg.idestudiantegeneral=e.idestudiantegeneral
		and c.codigomodalidadacademica in ('200','300')		
		and eg.numerodocumento not in (select numerodocumento from usuario)		
		GROUP by e.codigoestudiante
		order by o.numeroordenpago";


$resultado=$objetobase->conexion->query($query);
$i=0;
echo "<table border='1'>";

while($row = $resultado->fetchRow()){

/*if(($i%100)==0) {
	ob_flush();
	flush();
}*/
	$objetoclaveusuario=new GeneraClaveUsuario($row["numeroordenpago"],$salaobjecttmp);
	/*if($row["numeroordenpago"]==1119881){
		echo "ENTRO A ORDEN PAGO";
		echo "<pre>";
		print_r($objetoclaveusuario->datosorden);
		echo "</pre>";
	}*/

	if(is_array($objetoclaveusuario->datosorden)&&(trim($objetoclaveusuario->datosorden)!='')){
		//echo " ---> ".$row["numeroordenpago"]."<br>";
		$arraylogcreacion[$i]=$objetoclaveusuario->datosorden;
		$arraylogcreacion[$i]["mensaje"]=$objetoclaveusuario->mensaje;
		$arraylogcreacion[$i]["numeroordenpago"]=$row["numeroordenpago"];
		echo "<tr><td>".$arraylogcreacion[$i]["nombrecarrera"]."</td><td>".$arraylogcreacion[$i]["numerodocumento"]."</td><td>".$arraylogcreacion[$i]["nombresestudiantegeneral"]."</td>".
		"<td>".$arraylogcreacion[$i]["apellidosestudiantegeneral"]." ".$arraylogcreacion[$i]["numerodocumento"]."</td><td>".$arraylogcreacion[$i]["mensaje"]."</td>".
		"<td>".$arraylogcreacion[$i]["numeroordenpago"]."</td></tr>";
		
		$i++;
	}
	unset($objetoclaveusuario->datosorden);
	
}
echo "</table>";
/*
for($i=0;$i<count($arraylogcreacion);$i++){
if(($i%100)==0) {
	ob_flush();
	flush();
}

} */
?>