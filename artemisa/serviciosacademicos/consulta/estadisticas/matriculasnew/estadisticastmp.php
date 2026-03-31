<?php 
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

require_once('../../../../serviciosacademicos/Connections/sala2.php' );
$rutaado=("../../../../serviciosacademicos/funciones/adodb/");
require_once("../../../../serviciosacademicos/Connections/salaado-pear.php");
require_once("../../../../serviciosacademicos/funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../../serviciosacademicos/funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../../serviciosacademicos/funciones/sala_genericas/FuncionesMatriz.php");
require_once("../../../../serviciosacademicos/funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../../serviciosacademicos/funciones/sala_genericas/DatosGenerales.php");
require_once("../../../../serviciosacademicos/funciones/clases/formulario/clase_formulario.php");
require_once("../../../../serviciosacademicos/funciones/sala_genericas/formulariobaseestudiante.php");

$periodo=$_POST['codigoperiodo'];
$fechahoy=date("Y-m-d H:i:s");
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);

if(!isset($_POST['codigoperiodo'])){
?>
<form name="form1" action="" method="POST" >
<input type="hidden" name="AnularOK" value="" onChange="">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
	<?php
	$formulario->dibujar_fila_titulo('ESTADISTICAS','labelresaltado',"2","align='center'"); 
	$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("periodo","codigoperiodo","codigoperiodo","codigoperiodo=codigoperiodo order by codigoperiodo desc");
	$codigoperiodo=$_POST['codigoperiodo'];
	$campo='menu_fila'; $parametros="'codigoperiodo','".$codigoperiodo."',''";
	$formulario->dibujar_campo($campo,$parametros,"Periodo","tdtitulogris",'codigoperiodo','');

	$conboton=0;
	$parametrobotonenviar[$conboton]="'submit','Seguir','Seguir','onClick=\"return enviarpagina();\"'";
	$boton[$conboton]='boton_tipo';
	$conboton++;				
	$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar','');
	?>	
	</tr>
  </table>
</form>	
<?php 
}
if(isset($_POST['codigoperiodo']))
echo "nombrecarrera;nombrecortodocumento;numerodocumento;semestre;".
"apellidosestudiantegeneral;nombresestudiantegeneral;".
"direccionresidenciaestudiantegeneral;telefonoresidenciaestudiantegeneral;".
"celularestudiantegeneral;emailestudiantegeneral;nombreestadocivil;".
"fechanacimientoestudiantegeneral;nombreciudad;nombregenero;".
"nombrejornada;nombretipoestudiante;periodoingreso;".
"periodo_salida;Credito;nombresituacioncarreraestudiante;<br>";


 $query_horarioinicial="SELECT *, e.codigoperiodo periodoingreso,pr.codigoperiodo periodo_salida,
		e.codigoestudiante codigoestudianteestudiante,o.numeroordenpago pago
		FROM ordenpago o, detalleordenpago d, estudiante e, carrera c, 
		concepto co, prematricula pr, estudiantegeneral eg
		WHERE o.numeroordenpago=d.numeroordenpago
		AND pr.codigoperiodo='$periodo'
		AND e.codigoestudiante=pr.codigoestudiante
		AND e.codigoestudiante=o.codigoestudiante
		AND d.codigoconcepto=co.codigoconcepto
		AND co.cuentaoperacionprincipal=151
		AND o.codigoperiodo='$periodo'
		AND o.codigoestadoordenpago LIKE '4%'
		and c.codigocarrera=e.codigocarrera
		and c.codigomodalidadacademica=200
		and eg.idestudiantegeneral=e.idestudiantegeneral
		GROUP by e.codigoestudiante
		order by eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,periodo_salida";
$operacion=$objetobase->conexion->query($query_horarioinicial);
$totalRows_premainicial1 = $operacion->RecordCount();
while($datosrow = $operacion->FetchRow())
{
//estadocivil ec, , documento tc, genero g, ciudad ci, jornada j, tipoestudiante te,
$datosestadocivil=$objetobase->recuperar_datos_tabla("estadocivil","idestadocivil",$datosrow["idestadocivil"],"","",0);
$datosciudad=$objetobase->recuperar_datos_tabla("ciudad","idciudad",$datosrow["idciudadnacimiento"],"","",0);
$datosgenero=$objetobase->recuperar_datos_tabla("genero","codigogenero",$datosrow["codigogenero"],"","",0);
$datosjornada=$objetobase->recuperar_datos_tabla("jornada","codigojornada",$datosrow["codigojornada"],"","",0);
$datosdocumento=$objetobase->recuperar_datos_tabla("documento","tipodocumento",$datosrow["tipodocumento"],"","",0);

$datostipoestudiante=$objetobase->recuperar_datos_tabla("tipoestudiante","codigotipoestudiante",$datosrow["codigotipoestudiante"],"","",0);

$condicion=" and hs.codigoperiodo=".$datosrow["periodo_salida"]." and
hs.codigosituacioncarreraestudiante= sce.codigosituacioncarreraestudiante 
order by idhistoricosituacionestudiante desc limit 1";

$datossituacioncarrera=$objetobase->recuperar_datos_tabla("historicosituacionestudiante hs, situacioncarreraestudiante sce","hs.codigoestudiante",$datosrow["codigoestudianteestudiante"],$condicion,"",0);

$condicion="and op.numerorodenpagoplandepagosap=o.numeroordenpago
	and numeroordenpago=".$datosrow["pago"];
if($datoscredito=$objetobase->recuperar_datos_tabla("ordenpago o , ordenpagoplandepago op ","o.codigoestudiante",$datosrow["codigoestudianteestudiante"],$condicion,"",0)){
$credito="CREDITO";
}
else
$credito ="";



//ordenpago o , ordenpagoplandepago 
/*c.nombrecarrera,
tc.nombrecortodocumento,
eg.numerodocumento,
e.semestre,
eg.apellidosestudiantegeneral,
eg.nombresestudiantegeneral,
eg.direccionresidenciaestudiantegeneral,
eg.telefonoresidenciaestudiantegeneral,
eg.celularestudiantegeneral,
eg.emailestudiantegeneral,
ec.nombreestadocivil estado_civil,
eg.fechanacimientoestudiantegeneral fecha_nacimiento,
ci.nombreciudad ciudad_nacimiento,
g.nombregenero,
j.nombrejornada,
te.nombretipoestudiante,
e.codigoperiodo periodoingreso,
p.codigoperiodo periodo_salida,
e2.codigoestudiante,
sce.nombresituacioncarreraestudiante*/

echo str_replace("\n","","".$datosrow["nombrecarrera"].";".$datosdocumento["nombrecortodocumento"].";".
$datosrow["numerodocumento"].";".$datosrow["semestre"].";".
$datosrow["apellidosestudiantegeneral"].";".$datosrow["nombresestudiantegeneral"].";".
$datosrow["direccionresidenciaestudiantegeneral"].";".$datosrow["telefonoresidenciaestudiantegeneral"].";".
$datosrow["celularestudiantegeneral"].";".$datosrow["emailestudiantegeneral"].";".$datosestadocivil["nombreestadocivil"].";".
$datosrow["fechanacimientoestudiantegeneral"].";".$datosciudad["nombreciudad"].";".$datosgenero["nombregenero"].";".
$datosjornada["nombrejornada"].";".$datostipoestudiante["nombretipoestudiante"].";".$datosrow["periodoingreso"].";".
$datosrow["periodo_salida"].";".$credito.";".$datossituacioncarrera["nombresituacioncarreraestudiante"]).";<br>";



}


?>