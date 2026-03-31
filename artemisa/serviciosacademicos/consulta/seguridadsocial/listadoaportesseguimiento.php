<?php
session_start();
?>
<link rel="stylesheet" type="text/css" href="../../sala.css">
<script LANGUAGE="JavaScript">
function  ventanaprincipal(pagina){
opener.focus();
opener.location.href=pagina.href;
window.close();
return false;
}
function reCarga(){
}

</script>
<?php
$rutaado=("../../funciones/adodb/");
require_once("../../funciones/clases/motor/motor.php");
require_once("../../Connections/salaado-pear.php");
require_once("../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../funciones/sala_genericas/FuncionesFecha.php");
require_once("funciones/FuncionesAportes.php");
require_once("../../funciones/sala_genericas/FuncionesMatriz.php");

function resumen_cadena($cadena,$longitud){

$rescad="";
for($i=0;$i<$longitud;$i++)
$rescad .= $cadena[$i];

return $rescad;

}
if(isset($_GET['codigoestudiante'])&&($_GET['codigoestudiante']!=''))
$_SESSION['sesion_codigoestudiante']=$_GET['codigoestudiante'];
$final_mes=formato_fecha_mysql(final_mes_fecha(date("d/m/Y")));
$vector_fecha=vector_fecha(date("d/m/Y"));
$inicio_mes=formato_fecha_mysql("01/".$vector_fecha['mes']."/".$vector_fecha['anio']);
$query="SELECT 
en.idestudiantenovedadarp idestudiantenovedadarp,
en.idestudiantegeneral Codigo_Estudiante,
CONCAT(MID(en.observacionnovedadarp,1,20),'...') as Observacion,
em.nombreempresasalud as EPS,
no.nombrenovedadarp as Novedad,
en.fechaestudiantenovedadarp as Fecha_Ingreso,
en.fechainicioestudiantenovedadarp as Fecha_Inicio,
en.fechafinalestudiantenovedadarp as Fecha_Final,
en.numerodocumentonovedadarp as Documento_Respaldo
FROM estudiante es, estudiantenovedadarp en, empresasalud em, novedadarp no
WHERE es.codigoestudiante='".$_SESSION['sesion_codigoestudiante']."' and
en.idempresasalud=em.idempresasalud and
en.idnovedadarp=no.idnovedadarp and
en.idestudiantegeneral=es.idestudiantegeneral and
en.codigoestado like '1%' and
no.codigoestado like '1%' and
 '".$inicio_mes."' between no.fechainicionovedadarp and no.fechafinalnovedadarp
order by en.fechainicioestudiantenovedadarp desc
";
//en.fechainicioestudiantenovedadarp >= '$inicio_mes' 
$objetobase=new BaseDeDatosGeneral($sala);
$condicion="and es.idestudiantegeneral=eg.idestudiantegeneral
			and eg.tipodocumento=do.tipodocumento";
$datosestudiante=$objetobase->recuperar_datos_tabla("estudiante es, estudiantegeneral eg, documento do","es.codigoestudiante",$_SESSION['sesion_codigoestudiante'],$condicion);

$operacion=$sala->query($query);
//$row_operacion=$operacion->fetchRow();
while ($row_operacion=$operacion->fetchRow()){
	//if(validar_diferencia_fechas(formato_fecha_defecto($row_operacion['Fecha_Inicio']),formato_fecha_defecto($inicio_mes)))
	if(!validacionprocesoactivo(formato_fecha_defecto($row_operacion['Fecha_Inicio']),$objetobase,4,0))
	$disabled="disabled onclick='return false';";
	else
	$disabled="onclick='return ventanaprincipal(this)'";
	
		
	$row_temp["EstudianteNovedad"]="<a href='ingresoaportes.php?idestudiantenovedadarp=".$row_operacion['idestudiantenovedadarp']."&link_origen= ".$_GET['link_origen']."&codigoestudiante=".$_GET['codigoestudiante']."&modificar=1' $disabled >Modificar</a>";
	$row_operacion=InsertarColumnaFila($row_operacion,$row_temp,1);
	$array_interno[]=$row_operacion;
	
	//$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
}

//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
unset($_GET['Restablecer']);
unset($_GET['Regresar']);
unset($_GET['Recargar']);
$estudiante=ucwords(strtolower($datosestudiante['nombresestudiantegeneral']." ".$datosestudiante['apellidosestudiantegeneral']." con  ".$datosestudiante['nombrecortodocumento']." ".$datosestudiante['numerodocumento']));
$motor = new matriz($array_interno,"Listado de de novedades del estudiante ".$estudiante,$_SERVER['REQUEST_URI']."&codigoestudiante=".$_GET['codigoestudiante']);
//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
//$motor->agregarllave_drilldown('Observacion','listadoaportesseguimiento.php','ingresoaportes.php','','idestudiantenovedadarp',"codigoestudiante=".$_GET['codigoestudiante']."&modificar=1",'','','','','onclick= "return ventanaprincipal(this)"');

$motor->mostrar();
?>
 