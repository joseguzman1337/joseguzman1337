<?php
class ConsultaSic{

var $iditem;
var $objetobase;
var $tipovisualiza;

function ConsultaSic($iditem,$tipovisualiza,$objetobase,$formulario){

$this->iditem=$iditem;
$this->objetobase=$objetobase;
$this->formulario=$formulario;
$this->tipovisualiza=$tipovisualiza;

}
function descripcionxcarrera(){

//$this->objetobase=new BaseDeDatosGeneral($sala);
$tabla="itemsic i left join itemsiccarrera ic on i.iditemsic=ic.iditemsic
			and ic.codigocarrera='".$_SESSION["sissic_codigocarrera"]."'
			and ic.codigoestado like '1%'
			";
		$nombreidtabla="i.codigoestado";
		$idtabla="100";
		$condicion=" and i.iditemsic = '".$this->iditem."'";	
		$nivel++;
		$datositemsic=$this->objetobase->recuperar_datos_tabla($tabla,$nombreidtabla,$idtabla,$condicion," ,ic.iditemsiccarrera itemsiccarrera",0);

//return $datositemsic["valoritemsiccarrera"];
$this->formulario->dibujar_fila_titulo("".str_replace("\n","<br>",$datositemsic["valoritemsiccarrera"])."",'',"2","align='left'","td");

}
function descripcionxfacultad(){

//$this->objetobase=new BaseDeDatosGeneral($sala);
$tabla="itemsic i left join itemsiccarrera ic on i.iditemsic=ic.iditemsic
			and ic.codigocarrera='".$_SESSION["sissic_codigocarrera"]."'
			and ic.codigoestado like '1%'";
		$nombreidtabla="i.codigoestado";
		$idtabla="100";
		$condicion=" and i.iditemsic = '".$this->iditem."'";	
		$nivel++;
		$datositemsic=$this->objetobase->recuperar_datos_tabla($tabla,$nombreidtabla,$idtabla,$condicion," ,ic.iditemsiccarrera itemsiccarrera",0);

$this->formulario->dibujar_fila_titulo("".str_replace("\n","<br>",$datositemsic["valoritemsiccarrera"])."",'',"2","align='left'","td");

}
function mostraradjuntoxcarrera(){

$arraydireccion=explode("serviciosacademicos",$_SERVER['REQUEST_URI']);
$tabla="itemsic i left join itemsiccarrera ic on i.iditemsic=ic.iditemsic
			and ic.codigocarrera='".$_SESSION["sissic_codigocarrera"]."'
			and ic.codigoestado like '1%'
			and now() between fechacreacionitemsiccarrera and fechahastaitemsiccarrera
		  left join itemsiccarreraadjunto id on id.iditemsiccarrera=ic.iditemsiccarrera
		and now() between fechacreacionitemsiccarreraadjunto and fechaeliminacionitemsiccarreraadjunto";

		$nombreidtabla="i.codigoestado";
		$idtabla="100";
		$condicion=" and i.iditemsic = '".$this->iditem."'";	
		$nivel++;

		$datositemsicadjunto=$this->objetobase->recuperar_datos_tabla($tabla,$nombreidtabla,$idtabla,$condicion," ,ic.iditemsiccarrera itemsiccarrera",0);

		$this->formulario->dibujar_fila_titulo("".str_replace("\n","<br>",$datositemsicadjunto["valoritemsiccarrera"])."",'',"2","align='left'","td");

		if(isset($datositemsicadjunto["iditemsiccarreraadjunto"])&&trim($datositemsicadjunto["iditemsiccarreraadjunto"])!=''){
			

			echo "<tr><td align='center'><br><img src='http://".$_SERVER['SERVER_NAME'].$arraydireccion[0]."serviciosacademicos/consulta/sic/adjuntos/".$datositemsicadjunto["nombreitemsiccarreraadjunto"]."'   ><br><br></td></tr>";
		}
}
function mostrarlistaadjuntoxcarrera(){

$this->descripcionxfacultad();
$tabla="itemsic i left join itemsiccarrera ic on i.iditemsic=ic.iditemsic
			and ic.codigocarrera='".$_SESSION["sissic_codigocarrera"]."'
			and ic.codigoestado like '1%'
			and now() between fechacreacionitemsiccarrera and fechahastaitemsiccarrera
		  left join itemsiccarreraadjunto id on id.iditemsiccarrera=ic.iditemsiccarrera
		and now() between fechacreacionitemsiccarreraadjunto and fechaeliminacionitemsiccarreraadjunto";

		$nombreidtabla="i.codigoestado";
		$idtabla="100";
		$condicion=" and i.iditemsic = '".$this->iditem."'";	
		$nivel++;


		$this->formulario->dibujar_fila_titulo("".str_replace("\n","<br>",$datositemsicadjunto["valoritemsiccarrera"])."",'',"2","align='left'","td");

/*CONSULTA LISTA DE ADJUNTOS EN LA BASE*/
		$resultitemsicadjunto=$this->objetobase->recuperar_resultado_tabla($tabla,$nombreidtabla,$idtabla,$condicion," ,ic.iditemsiccarrera itemsiccarrera",0);

echo "<tr><td> <table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";


		$fila["Descripcion"]="";
		$fila["Adjunto"]="";
		$this->formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");
		while($rowadjunto=$resultitemsicadjunto->fetchRow())
		{
			unset($fila);
			if(trim($rowadjunto["descripcionitemsiccarreraadjunto"])!='')
				$fila[]=$rowadjunto["descripcionitemsiccarreraadjunto"];
			else
				$fila[]=$rowadjunto["nombreitemsiccarreraadjunto"];

			if(isset($rowadjunto["nombreitemsiccarreraadjunto"])&&(trim($rowadjunto["nombreitemsiccarreraadjunto"])!='')){
				$fila[]="<a href='../../adjuntos/".$rowadjunto["nombreitemsiccarreraadjunto"]."'  target='newadjunto'>Archivo</a>";
			}
			else
			{
				$fila[]="Ninguno";		
			}
			$this->formulario->dibujar_fila_texto($fila,'','',"colspan=4","colspan=4");
	
		}
echo "</table></td></tr>";
}
function mostrartablaproyeccionsocial(){

//echo "<H1>ENTRO  AMOSTRAR LA PROYECCION</H1>";
$tabla="proyeccionsocialcarrera p, tipoproyeccionsocialcarrera t";
$nombreidtabla="p.codigocarrera";
$idtabla=$_SESSION["sissic_codigocarrera"];
$condicion=" and p.codigoestado like '1%'
		and t.codigotipoproyeccionsocialcarrera=p.codigotipoproyeccionsocialcarrera";
$resultproyeccion=$this->objetobase->recuperar_resultado_tabla($tabla,$nombreidtabla,$idtabla,$condicion,"",0);

echo "<tr><td> <table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";

		$fila["Nombre de la Experiencia"]="";
		$fila["Año"]="";
		$fila["Producto"]="";
		$fila["Agentes Involucrados"]="";
		$fila["Responsabilidad Social Universitaria"]="";


		$this->formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");

while($rowproyeccion=$resultproyeccion->fetchRow())
{
unset($fila);
		$fila[]=$rowproyeccion["nombreproyeccionsocialcarrera"];
		$fila[]=substr($rowproyeccion["fechaproyeccionsocialcarrera"],0,4);
		$fila[]=$rowproyeccion["productoproyeccionsocialcarrera"];
		$fila[]=$rowproyeccion["agentesproyeccionsocialcarrera"];
		$fila[]=$rowproyeccion["nombretipoproyeccionsocialcarrera"];

		$this->formulario->dibujar_fila_texto($fila,'','',"colspan=4","colspan=4");	
}
echo "</table></td></tr>";
}
function mostrartablaconvenio(){

$arraydireccion=explode("serviciosacademicos",$_SERVER['REQUEST_URI']);
//echo "<H1>ENTRO  AMOSTRAR LA PROYECCION</H1>";
$tabla="convenio c,tipoconvenio t,conveniocarrera dc,carrera ca";
$nombreidtabla="c.codigoestado";
$idtabla="100";
$condicion="  and t.codigotipoconvenio=c.codigotipoconvenio and dc.codigocarrera=ca.codigocarrera and dc.idconvenio=c.idconvenio and dc.codigoestado like '1%'";
$resultproyeccion=$this->objetobase->recuperar_resultado_tabla($tabla,$nombreidtabla,$idtabla,$condicion,"",0);


echo "<tr><td><br><br> 
<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";

		$fila["Entidad"]="";
		$fila["Tipo de Convenio"]="";
		$fila["Objetivo"]="";
		$fila["Poliza"]="";
		$fila["Fecha de Inicio"]="";
		$fila["Fecha Final"]="";
		$fila["Carrera"]="";
		$fila["Adjunto"]="";


		$this->formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");

while($rowproyeccion=$resultproyeccion->fetchRow())
{
unset($fila);
		$fila[]=$rowproyeccion["nombreentidadconvenio"];
		$fila[]=$rowproyeccion["nombretipoconvenio"];
		$fila[]=$rowproyeccion["objetivoconvenio"];
		$fila[]=$rowproyeccion["polizaconvenio"];
		$fila[]=$rowproyeccion["fechainiciovigenciaconvenio"];
		$fila[]=$rowproyeccion["fechafinvigenciaconvenio"];
		$fila[]=$rowproyeccion["nombrecarrera"];
		if(isset($rowproyeccion["adjuntoconvenio"])&&trim($rowproyeccion["adjuntoconvenio"])!=''){
			$fila[]="<a href='http://".$_SERVER['SERVER_NAME'].$arraydireccion[0]."serviciosacademicos/consulta/mantenimiento/convenio/adjuntos/".$rowproyeccion["adjuntoconvenio"]."' target='newadjunto'>Archivo</a>";
		}
		else
		{
			$fila[]="Ninguno";		
		}

		$this->formulario->dibujar_fila_texto($fila,'','',"colspan=4","colspan=4");	
}
echo "</table></td></tr>";
}

function mostrartablaproduccionintelectual(){

//echo "<H1>ENTRO  AMOSTRAR LA intelectual</H1>";
$tabla="produccionintelectualcarrera pc,carrera c,tipoproduccionintelectual t";
$nombreidtabla="pc.codigoestado";
$idtabla="100";
$condicion=" and pc.codigocarrera='".$_SESSION['sissic_codigocarrera']."'
and c.codigocarrera=pc.codigocarrera
and t.codigotipoproduccionintelectual=pc.codigotipoproduccionintelectual
and pc.codigoestado like '1%'";
$resultproyeccion=$this->objetobase->recuperar_resultado_tabla($tabla,$nombreidtabla,$idtabla,$condicion,"",0);

echo "<tr><td> <table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";

		$fila["Descripcion"]="";
		$fila["Titulo"]="";
		$fila["Tipo_De_Producto"]="";
		$fila["Fecha_Publicacion"]="";
		$fila["Numero_Identificacion"]="";
		$fila["Autor"]="";

$this->formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");

while($rowproyeccion=$resultproyeccion->fetchRow())
{
unset($fila);
		$fila[]=$rowproyeccion["nombreproduccionintelectualcarrera"];
		$fila[]=$rowproyeccion["tituloproduccionintelectualcarrera"];
		$fila[]=$rowproyeccion["nombretipoproduccionintelectual"];
		$fila[]=$rowproyeccion["fechapublicacionproduccionintelectualcarrera"];
		$fila[]=$rowproyeccion["numeroproduccionintelectualcarrera"];
		$fila[]=$rowproyeccion["autorproduccionintelectualcarrera"];

		$this->formulario->dibujar_fila_texto($fila,'','',"colspan=4","colspan=4");	
}
echo "</table></td></tr>";
}

function mostraradjuntoxproceso(){

$this->descripcionxfacultad();
$arraydireccion=explode("serviciosacademicos",$_SERVER['REQUEST_URI']);
$tabla="itemsic i left join itemsiccarrera ic on i.iditemsic=ic.iditemsic
			and ic.codigocarrera='".$_SESSION["sissic_codigocarrera"]."'
			and ic.codigoestado like '1%'
			and now() between fechacreacionitemsiccarrera and fechahastaitemsiccarrera
		  left join itemsiccarreraadjunto id on id.iditemsiccarrera=ic.iditemsiccarrera
		and now() between fechacreacionitemsiccarreraadjunto and fechaeliminacionitemsiccarreraadjunto";

		$nombreidtabla="i.codigoestado";
		$idtabla="100";
		$condicion=" and i.iditemsic = '".$this->iditem."'
			and id.nombreitemsiccarreraadjunto like '%mapadeprocesos1%'";	
		$nivel++;


		$this->formulario->dibujar_fila_titulo("".str_replace("\n","<br>",$datositemsicadjunto["valoritemsiccarrera"])."",'',"2","align='left'","td");

/*CONSULTA LISTA DE ADJUNTOS EN LA BASE*/
		$resultitemsicadjunto=$this->objetobase->recuperar_resultado_tabla($tabla,$nombreidtabla,$idtabla,$condicion," ,ic.iditemsiccarrera itemsiccarrera",0);

echo "<tr><td> <table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";


		$fila["Descripcion"]="";
		$fila["Adjunto"]="";
		$this->formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");
		while($rowadjunto=$resultitemsicadjunto->fetchRow())
		{
			unset($fila);

			if(trim($rowadjunto["descripcionitemsiccarreraadjunto"])!='')
				$fila[]=$rowadjunto["descripcionitemsiccarreraadjunto"];
			else
				$fila[]="Consulta de procesos visión institucional";

			if(isset($rowadjunto["nombreitemsiccarreraadjunto"])&&(trim($rowadjunto["nombreitemsiccarreraadjunto"])!='')){
				$fila[]="<a href='http://".$_SERVER['SERVER_NAME'].$arraydireccion[0]."serviciosacademicos/consulta/sic/aplicaciones/procesos/consultaprocesos.php'  target='newadjunto'>Procesos</a>";
			}
			else
			{
				$fila[]="Ninguno";		
			}
			$this->formulario->dibujar_fila_texto($fila,'','',"colspan=4","colspan=4");
	
		}
echo "</table><br><br></td></tr>";
}

function mostrarindicadores(){
//echo "<h1>ENTRO ESTA CHURUMBELA</h1>";
$arraydireccion=explode("serviciosacademicos",$_SERVER['REQUEST_URI']);
$this->descripcionxfacultad();
$tabla="itemsic i left join itemsiccarrera ic on i.iditemsic=ic.iditemsic
			and ic.codigocarrera='".$_SESSION["sissic_codigocarrera"]."'
			and ic.codigoestado like '1%'
			and now() between fechacreacionitemsiccarrera and fechahastaitemsiccarrera
		  left join itemsiccarreraadjunto id on id.iditemsiccarrera=ic.iditemsiccarrera
		and now() between fechacreacionitemsiccarreraadjunto and fechaeliminacionitemsiccarreraadjunto";

		$nombreidtabla="i.codigoestado";
		$idtabla="100";
		$condicion=" and i.iditemsic = '".$this->iditem."'
			and id.nombreitemsiccarreraadjunto like '%mapadeprocesos1%'";	
		$nivel++;


		$this->formulario->dibujar_fila_titulo("".str_replace("\n","<br>",$datositemsicadjunto["valoritemsiccarrera"])."",'',"2","align='left'","td");

/*CONSULTA LISTA DE ADJUNTOS EN LA BASE*/
		$resultitemsicadjunto=$this->objetobase->recuperar_resultado_tabla($tabla,$nombreidtabla,$idtabla,$condicion," ,ic.iditemsiccarrera itemsiccarrera",0);

echo "<tr><td> <table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";


		$fila["Descripcion"]="";
		$fila["Adjunto"]="";
		$this->formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");
			unset($fila);

			$fila[]="Consulta de indicadores visión en el Area";
			$fila[]="<a href='http://".$_SERVER['SERVER_NAME'].$arraydireccion[0]."serviciosacademicos/consulta/estadisticas/indicadores/index.html'  target='newadjunto'>Consultar</a>";
			$this->formulario->dibujar_fila_texto($fila,'','',"colspan=4","colspan=4");
	

echo "</table><br><br></td></tr>";
}

function mostrarplanestudios(){
//echo "<h1>ENTRO ESTA CHURUMBELA</h1>";
$arraydireccion=explode("serviciosacademicos",$_SERVER['REQUEST_URI']);
$this->descripcionxfacultad();
$tabla="itemsic i left join itemsiccarrera ic on i.iditemsic=ic.iditemsic
			and ic.codigocarrera='".$_SESSION["sissic_codigocarrera"]."'
			and ic.codigoestado like '1%'
			and now() between fechacreacionitemsiccarrera and fechahastaitemsiccarrera
		  left join itemsiccarreraadjunto id on id.iditemsiccarrera=ic.iditemsiccarrera
		and now() between fechacreacionitemsiccarreraadjunto and fechaeliminacionitemsiccarreraadjunto";

		$nombreidtabla="i.codigoestado";
		$idtabla="100";
		$condicion=" and i.iditemsic = '".$this->iditem."'
			and id.nombreitemsiccarreraadjunto like '%mapadeprocesos1%'";	
		$nivel++;


		$this->formulario->dibujar_fila_titulo("".str_replace("\n","<br>",$datositemsicadjunto["valoritemsiccarrera"])."",'',"2","align='left'","td");

/*CONSULTA LISTA DE ADJUNTOS EN LA BASE*/
		$resultitemsicadjunto=$this->objetobase->recuperar_resultado_tabla($tabla,$nombreidtabla,$idtabla,$condicion," ,ic.iditemsiccarrera itemsiccarrera",0);

echo "<tr><td> <table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";


		$fila["Descripcion"]="";
		$fila["Adjunto"]="";
		$this->formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");
			unset($fila);

			$fila[]="Consulta de plan de estudios";
			$fila[]="<a href='http://".$_SERVER['SERVER_NAME'].$arraydireccion[0]."serviciosacademicos/consulta/facultades/planestudio/planestudioporcarrera/listafacultades.php'  target='newadjunto'>Consultar</a>";
			$this->formulario->dibujar_fila_texto($fila,'','',"colspan=4","colspan=4");
	

echo "</table><br><br></td></tr>";
}
function mostrarTablaEnlace(){
//echo "<h1>ENTRO ESTA CHURUMBELA</h1>";
$arraydireccion=explode("serviciosacademicos",$_SERVER['REQUEST_URI']);
$this->descripcionxfacultad();
$tabla="itemsic i left join itemsiccarrera ic on i.iditemsic=ic.iditemsic
			and ic.codigocarrera='".$_SESSION["sissic_codigocarrera"]."'
			and ic.codigoestado like '1%'
			and now() between fechacreacionitemsiccarrera and fechahastaitemsiccarrera
		  left join itemsiccarreraadjunto id on id.iditemsiccarrera=ic.iditemsiccarrera
		and now() between fechacreacionitemsiccarreraadjunto and fechaeliminacionitemsiccarreraadjunto";

		$nombreidtabla="i.codigoestado";
		$idtabla="100";
		$condicion=" and i.iditemsic = '".$this->iditem."'";	
		$nivel++;


		$this->formulario->dibujar_fila_titulo("".str_replace("\n","<br>",$datositemsicadjunto["valoritemsiccarrera"])."",'',"2","align='left'","td");

/*CONSULTA LISTA DE ADJUNTOS EN LA BASE*/
		$resultitemsicadjunto=$this->objetobase->recuperar_resultado_tabla($tabla,$nombreidtabla,$idtabla,$condicion," ,ic.iditemsiccarrera itemsiccarrera",0);
		$datositemsic=$resultitemsicadjunto->fetchRow();
echo "<tr><td> <table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";


		$fila["Descripcion"]="";
		$fila["Adjunto"]="";
		$this->formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");
			unset($fila);

			$fila[]="Consulte tabla adjunta ";
			$fila[]="<a href='http://".$_SERVER['SERVER_NAME'].$arraydireccion[0]."serviciosacademicos/consulta/".str_replace("../","",$datositemsic['enlaceitemsic'])."?nacodigocarrera=".$_SESSION["sissic_codigocarrera"]."&nacampoformulario[]=todos&naenviar=Enviar&codigocarrera=".$_SESSION["sissic_codigocarrera"]."&campos[]=todos&Enviar=Enviar'  target='newadjunto'>Consultar</a>";
			$this->formulario->dibujar_fila_texto($fila,'','',"colspan=4","colspan=4");
	

echo "</table><br><br></td></tr>";
}


}
?>