<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
function gobiernouniversitario($objetobase,$formulario){
$tabla="tipoconsejouniversidad tu left join participacionuniversitariadocente pd on tu.codigotipoconsejouniversidad=pd.codigotipoconsejouniversidad and pd.codigoestado like '1%'";
$condicion=" and tu.codigotipoconsejouniversidad <> 400";
$resulttipoparticipa=$objetobase->recuperar_resultado_tabla($tabla,"tu.codigoestado","100",$condicion,",tu.codigotipoconsejouniversidad tipoconsejouniversidad",0);
$i=0;
$archivo="asignatipoconsejouniversidad.php";
while($rowparticipa=$resulttipoparticipa->fetchRow()){
	
	$arrayparametroscajax[$i]["enunciado"]=$rowparticipa["nombretipoconsejouniversidad"];
	$arrayparametroscajax[$i]["nombre"]=$rowparticipa["tipoconsejouniversidad"];
	$arrayparametroscajax[$i]["valorsi"]="100";
	$arrayparametroscajax[$i]["valorno"]="200";	
	if(isset($rowparticipa["idparticipacionuniversitariadocente"])&&trim($rowparticipa["idparticipacionuniversitariadocente"])!='')
	{
		$arrayparametroscajax[$i]["check"]="checked";
	}
	else
	{
		$arrayparametroscajax[$i]["check"]="";
	}
	$i++;
	
}
$formulario->dibujar_cajax_chequeos($arrayparametroscajax,$archivo,$tipoestilo='labelresaltado');

}
?>