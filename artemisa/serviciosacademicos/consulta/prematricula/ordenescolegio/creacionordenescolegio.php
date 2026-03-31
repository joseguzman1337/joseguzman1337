<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION)
     
//session_start();
?>
<html>
<body>
<title>Servicios Academicos</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body marginheight="0" marginwidth="0">
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">

<script language="javascript">
function enviarperiodo(){
var formulario=document.getElementById("form2");
formulario.action="creacionordenescolegio.php?enviopropio=1";
formulario.submit();
}

function enviarmesorden(){
var formulario=document.getElementById("form2");
formulario.submit();
}
function enviarverorden(){
var formulario=document.getElementById("form1");

var selectconcepto=document.getElementById("codigoconcepto");
var codigoconcepto=selectconcepto.options[selectconcepto.selectedIndex].value;

var tmpformularioaction=formulario.action;
formulario.action="http://www.unbosque.edu.co/html/serviciosacademicos/consulta/prematricula/ordenescolegio/mostrarordenes.php?codigoconcepto="+codigoconcepto;
//formulario.action="http://172.16.7.109/calidad/desarrollo/serviciosacademicos/consulta/prematricula/ordenescolegio/mostrarordenes.php?codigoconcepto="+codigoconcepto;
//alert("ACTION="+formulario.action);

var tmpformulariotarget=formulario.target;
formulario.target="newpage";

var tmpformulariomethod=formulario.method;
formulario.method="post";



formulario.submit();
formulario.action=tmpformularioaction;
formulario.target=tmpformulariotarget;
formulario.method=tmpformulariomethod;

return false;
}
function enviarseleccion(seleccion){

if(seleccion=="generar")
return enviartarget();
if(seleccion=="imprimir")
return enviarverorden();

}
function enviartarget(){

if(confirm("Quiere Generar Ordenes de Pago?")==true){
	var formulario=document.getElementById("form1");
	var selectconcepto=document.getElementById("codigoconcepto");
	var codigoconcepto=selectconcepto.options[selectconcepto.selectedIndex].value;
	var selectcodigoperiodo=document.getElementById("codigoperiodo");
	var codigoperiodo=selectcodigoperiodo.options[selectcodigoperiodo.selectedIndex].value;
	var fechapago=document.getElementById("fechapago").value;
	var mesorden=document.getElementById("mesorden").value;
	var cadenaget="&codigoconcepto="+codigoconcepto+"&codigoperiodo="+codigoperiodo+"&fechapago="+fechapago+"&mesorden="+mesorden+"&Enviar=1";
	formulario.action="creacionordenescolegio.php?enviopropio=1"+cadenaget;
	formulario.target="";
	//alert("ACTION="+formulario.action);
	formulario.method="post";
	formulario.submit();
	
}
return false;
}
function habilitadeshabilita(obj){
var i=0;
var estudiantei=document.getElementById("estudiante"+i);
if(obj.checked)
	while(estudiantei!=null){
		estudiantei=document.getElementById("estudiante"+i);
		if((estudiantei!=null)&&(estudiantei.disabled!=true)){
			estudiantei.checked=true;
		}
		i++;
	}
else
	while(estudiantei!=null){
		estudiantei=document.getElementById("estudiante"+i);
		if(estudiantei!=null)
		estudiantei.checked=false;
		i++;
	}
}
</script>
 <script type="text/javascript" src="../../../funciones/sala_genericas/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css); 
    </style>
    <script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script><script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script><script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script><script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
    <link rel="stylesheet" href="../../../funciones/sala_genericas/ajax/tab/css/tab-view.css" type="text/css" media="screen">
    <script type="text/javascript" src="../../../funciones/sala_genericas/ajax/tab/js/ajax.js"></script><script type="text/javascript" src="../../../funciones/sala_genericas/ajax/tab/js/tab-view.js"></script>

<?php 
ini_set('max_execution_time','6000');
require_once('../../../Connections/sala2.php' );
$salatmp=$sala;
require_once("../../../funciones/funciontiempo.php");
require_once("../../../funciones/funcionip.php");
$rutaado=("../../../funciones/adodb/");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/sala_genericas/DatosGenerales.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/clases/motorv2/motor.php");
$rutaorden = "../../../funciones/ordenpago/";
$ruta = "../../../funciones/";
require_once('../../../funciones/ordenpago/claseordenpago.php');
function meses_anios($mesinicial,$mesfinal){

				$siga=1;
				$mm_fin=$mesfinal["mes"];
				$yyyy_fin=$mesfinal["anio"];
				$mes=$mesinicial["mes"];
				$anio=$mesinicial["anio"];
				$cadenames=agregarceros($mes,2)."/".$anio;
				$fila[$cadenames]=$cadenames;
				while($siga){
					 if(($mes==($mm_fin+0))&&($anio==($yyyy_fin+0))){
						$siga=0;
						}
	
					 $fechasiguiente=mes_siguiente($mes,$anio);
					 $mes=$fechasiguiente["mes"];
					 $anio=$fechasiguiente["anio"];
					 $cadenames=agregarceros($mes,2)."/".$anio;
					 $fila[$cadenames]=$cadenames;
					 
					 $diferencia++;
				}

		return $fila;
}
//require_once('../../../funciones/clases/autenticacion/redirect.php' ); 


$objetobase=new BaseDeDatosGeneral($sala);
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');

echo "<form name='form2' id='form2' action='' method='POST' >";
echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width='750'>";
$formulario->dibujar_fila_titulo('GENERACION DE ORDENES DE PENSIÒN COLEGIO','labelresaltado');


	



$condicion=" 1=1 order by codigoperiodo desc";
	$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("periodo","codigoperiodo","codigoperiodo",$condicion,"",0,0);
	$formulario->filatmp[""]="Seleccionar";
	//$_SESSION['codigoperiodoordenescolegio']=$_SESSION['codigoperiodosesion'];
	
if($_REQUEST['codigoperiodo']!=$_SESSION['codigoperiodoorform2denescolegio']&&(trim($_REQUEST['codigoperiodo'])!=''))
	$_SESSION['codigoperiodoordenescolegio']=$_REQUEST['codigoperiodo'];
	
	$campo='menu_fila'; $parametros="'codigoperiodo','".$_SESSION['codigoperiodoordenescolegio']."','onchange=enviarperiodo();'";
	$formulario->dibujar_campo($campo,$parametros,"Periodo","tdtitulogris",'codigoperiodo','');


if(isset($_SESSION['codigoperiodoordenescolegio'])&&trim($_SESSION['codigoperiodoordenescolegio'])!=''){
	
$condicion=" nombreconcepto like '%pension%'
	and v.idvalorpecuniario=df.idvalorpecuniario
	and f.idfacturavalorpecuniario=df.idfacturavalorpecuniario
	and v.codigoconcepto=c.codigoconcepto
	and f.codigocarrera=98
	and f.codigoperiodo=".$_SESSION['codigoperiodoordenescolegio'].
	" and df.codigoestado like '1%'";

	$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("concepto c,facturavalorpecuniario f , detallefacturavalorpecuniario df,valorpecuniario v","c.codigoconcepto","concat(c.nombreconcepto,\" \",v.valorpecuniario) valorconcepto",$condicion,"",0,0);
/*echo "<pre>";
print_r($formulario->filatmp);
echo "</pre>";*/
	$campo='menu_fila'; $parametros="'codigoconcepto','".$_POST['codigoconcepto']."',''";
	$formulario->dibujar_campo($campo,$parametros,"Concepto","tdtitulogris",'codigoconcepto','');

	if(isset($_REQUEST["fechapago"]))
		$_SESSION['fechapagoordenescolegio']=$_REQUEST["fechapago"];
	/*else
		$_SESSION['fechapagoordenescolegio']=$meshoy;*/

 	$campo="campo_fecha"; $parametros="'text','fechapago','".$_SESSION['fechapagoordenescolegio']."','onKeyUp = \"this.value=formateafecha(this.value);\" '";
    $formulario->dibujar_campo($campo,$parametros,"Fecha de Pago","tdtitulogris",'fechapago','requerido');


	$mesinicial["mes"]="01"; $mesinicial["anio"]=date("Y")-1;
	$mesfinal["mes"]="12";  $mesfinal["anio"]=date("Y")+1;
	$meshoy=date("m")."/".date("Y");
	$formulario->filatmp=meses_anios($mesinicial,$mesfinal);
	//$formulario->filatmp=listadomesesproceso($datos_bd,date("d/m/Y"),4,0);
	if(isset($_POST['mescierre']))
	$meshoy=$_POST['mescierre'];
	if(isset($_GET['mescierre']))
	$meshoy=$_GET['mescierre'];

	if($_REQUEST['mesorden']!=$_SESSION['mesordenordenescolegio']&&(trim($_REQUEST['mesorden'])!=''))
		$_SESSION['mesordenordenescolegio']=$_REQUEST["mesorden"];

if(!isset($_SESSION['mesordenordenescolegio'])){
$_SESSION['mesordenordenescolegio']=$meshoy;
}

//echo "MESORDEN=".$_SESSION['mesordenordenescolegio']."<H1>";
	$campo='menu_fila'; $parametros="'mesorden','".$_SESSION['mesordenordenescolegio']."','onchange=enviarmesorden(); 	'";
	$formulario->dibujar_campo($campo,$parametros,"Mes de orden","tdtitulogris",'mesorden','');

	if($_REQUEST['opcionseleccion']!=$_SESSION['opcionseleccionordenescolegio']&&(trim($_REQUEST['opcionseleccion'])!=''))
		$_SESSION['opcionseleccionordenescolegio']=$_REQUEST['opcionseleccion'];
	else
		$_SESSION['opcionseleccionordenescolegio']="generar";
	$formulario->filatmp["generar"]="Generar Orden(es)";
	$formulario->filatmp["imprimir"]="Imprimir Orden(es)";
	$campo='menu_fila'; $parametros="'opcionseleccion','".$_SESSION['opcionseleccionordenescolegio']."','onchange=enviarmesorden();'";
	$formulario->dibujar_campo($campo,$parametros,"Seleccionar","tdtitulogris",'opcionseleccion','');



	$conboton=0;
	$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar',' onclick=\'return enviarseleccion(\"".$_SESSION['opcionseleccionordenescolegio']."\");\''";
	$boton[$conboton]='boton_tipo';
	$conboton++;
	/*//$conboton=0;
	$parametrobotonenviar[$conboton]="'submit','verpdf','Ver Documento(s)',' onclick=\'return enviarverorden();\''";
	$boton[$conboton]='boton_tipo';
	$conboton++;*/

$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');
echo "</table>";

if(isset($_SESSION['mesordenordenescolegio'])&&trim($_SESSION['mesordenordenescolegio'])!=''){

echo "<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width='750' >";
//echo "<tr><td><b>No</b></td><td><b>DOCUMENTO</b></td><td><b>APELLIDOS</b></td><td><b>NOMBRES</b></td><td><b>SEMESTRE</b></td><td><b>PERIODO DE INGRESO</b></td><td><b>SITUACION ESTUDIANTE</b></td><td><b>SELECCIONADOS</b></td></tr>";


$rowinterno["DOCUMENTO"]="";
$rowinterno["APELLIDOS"]="";
$rowinterno["NOMBRES"]="";
$rowinterno["SEMESTRE"]="";
$rowinterno["PERIODO_DE_INGRESO"]="";
$rowinterno["SELECCIONADOS"]="<input name='checkhabilita' id='checkhabilita' type='checkbox' onclick='habilitadeshabilita(this);'>";
$rowinterno["ESTADO_ORDEN_MES"]="";
$rowinterno["NUMERO_ORDEN"]="";
$rowinterno["ORDENES"]="";
$arrayinterno[]=$rowinterno;
//echo "<tr><td><b></b></td><td><b></b></td><td><b></b></td><td><b></b></td><td><b></b></td><td><b></b></td><td><b></b></td><td><b></b></td></tr>";
//echo "<h1>".$_SESSION['mesordenordenescolegio']."</h1>";
$tmpmesordenpago=formato_fecha_mysql("01/".$_SESSION['mesordenordenescolegio']);

$condicion=" and codigoperiodo < ".$_SESSION['codigoperiodoordenescolegio']."";
$datoperiodoanterior=$objetobase->recuperar_datos_tabla("periodo","1",1,$condicion,",max(codigoperiodo) maxcodigoperiodo",0);

$condicion=" and e.idestudiantegeneral=eg.idestudiantegeneral
		and o.numeroordenpago=d.numeroordenpago
		AND e.codigoestudiante=o.codigoestudiante
		AND c.codigocarrera=e.codigocarrera
		AND d.codigoconcepto=co.codigoconcepto
		AND co.cuentaoperacionprincipal in (151,280)
		AND o.codigoestadoordenpago LIKE '4%'
		AND o.codigoperiodo in (".$datoperiodoanterior['maxcodigoperiodo'].",".$_SESSION['codigoperiodoordenescolegio'].")
		AND c.codigocarrera=e.codigocarrera
		and e.codigosituacioncarreraestudiante not like '1%'
		and e.codigosituacioncarreraestudiante not like '2%'
		group by e.codigoestudiante,o2.numeroordenpago
		order by e.semestre,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral
		";

$tablas="ordenpago o, detalleordenpago d,  carrera c, concepto co,estudiantegeneral eg,estudiante e
left join ordenpago o2 on o2.codigoestudiante = e.codigoestudiante
and o2.fechaentregaordenpago = '".$tmpmesordenpago."' and o2.codigoestadoordenpago not like '2%' and o2.numeroordenpago in (select d2.numeroordenpago from detalleordenpago d2 where d2.numeroordenpago=o2.numeroordenpago and d2.codigoconcepto in ('159','C9076','C9077','C9057')) 
left join estadoordenpago eo2 on eo2.codigoestadoordenpago=o2.codigoestadoordenpago 		
left join situacioncarreraestudiante sce on e.codigosituacioncarreraestudiante=sce.codigosituacioncarreraestudiante";

 $resultado=$objetobase->recuperar_resultado_tabla($tablas,"c.codigocarrera","98",$condicion,",e.codigoperiodo codigoperestudiante,o2.numeroordenpago ordenpagodos,count(distinct o2.numeroordenpago) cuentaordenpagos,e.codigoestudiante codigoestudianteestudiante",0);
$i=0;
while ($row = $resultado->fetchRow()){

$cadenagetestudiante="link_origen=ordenescolegio/creacionordenescolegio.php&codigoestudiante=".$row['codigoestudianteestudiante']."&codigofacultad=".$row['codigocarrera']."&programausadopor=facultad&descriptor=pantallaestudiante&estudiante=".$row['codigoestudianteestudiante']."";

$linkestudiante="../loginpru.php?".$cadenagetestudiante;

$check="";
if(is_array($_SESSION['estudiantesordencolegio']))
if(EncuentraFilaVector($_SESSION['estudiantesordencolegio'],$row['codigoestudianteestudiante'])==true)
$check="checked";




$arrayordenespension[$row['codigoestudianteestudiante']]["DOCUMENTO"]="<a href='".$linkestudiante."'>".$row['numerodocumento']."</a>";
$arrayordenespension[$row['codigoestudianteestudiante']]["APELLIDOS"]=$row['apellidosestudiantegeneral'];
$arrayordenespension[$row['codigoestudianteestudiante']]["NOMBRES"]=$row['nombresestudiantegeneral'];
$arrayordenespension[$row['codigoestudianteestudiante']]["SEMESTRE"]=$row['semestre'];
$arrayordenespension[$row['codigoestudianteestudiante']]["PERIODO_DE_INGRESO"]=$row['codigoperestudiante'];

if(isset($row['ordenpagodos'])&&trim($row['ordenpagodos'])!=''){


	
	if($arrayordenespension[$row['codigoestudianteestudiante']]["ORDENES"]>0){
	$arrayordenespension[$row['codigoestudianteestudiante']]["NUMERO_ORDEN"].=",".$row['ordenpagodos'];
	$arrayordenespension[$row['codigoestudianteestudiante']]["ESTADO_ORDEN_MES"].=",".$row['nombreestadoordenpago'];	
	}
	else{
	$arrayordenespension[$row['codigoestudianteestudiante']]["NUMERO_ORDEN"].=$row['ordenpagodos'];
	$arrayordenespension[$row['codigoestudianteestudiante']]["ESTADO_ORDEN_MES"].=$row['nombreestadoordenpago'];
	}
	$arrayordenespension[$row['codigoestudianteestudiante']]["ORDENES"]++;
}


$disable="";
if(($arrayordenespension[$row['codigoestudianteestudiante']]["ORDENES"]>0)&&($_SESSION["opcionseleccionordenescolegio"]=="generar"))
$disable="disabled";

if(isset($_GET['Filtrar'])&&trim($_GET['Filtrar'])!='')
$nombrecampoestudiante='estudiantetmp';
else
$nombrecampoestudiante='estudiante';




if(isset($_GET['Enviar']))
if(EncuentraFilaVector($_POST[$nombrecampoestudiante],$row['codigoestudianteestudiante'])==true)
$check="checked";


if(is_array($_SESSION['estudiantesordencolegio']))
$cajachequeo="<input type=checkbox name='".$nombrecampoestudiante."[]' id=estudiante".(count($arrayordenespension)-1)." value=".$row['codigoestudianteestudiante']." ".$check." ".$disable.">";
else
$cajachequeo="<input type=checkbox name='".$nombrecampoestudiante."[]' id=estudiante".(count($arrayordenespension)-1)." value=".$row['codigoestudianteestudiante']." ".$disable.">";

$arrayordenespension[$row['codigoestudianteestudiante']]["SELECCIONADOS"]=$cajachequeo;
$i++;

}

foreach($arrayordenespension as $codigoestudiante=>$filavector){
echo "<tr>";






$rowinterno["DOCUMENTO"]=$filavector["DOCUMENTO"];
$rowinterno["APELLIDOS"]=$filavector["APELLIDOS"];
$rowinterno["NOMBRES"]=$filavector["NOMBRES"];
$rowinterno["SEMESTRE"]=$filavector["SEMESTRE"];
$rowinterno["PERIODO_DE_INGRESO"]=$filavector["PERIODO_DE_INGRESO"];
$rowinterno["SELECCIONADOS"]=$filavector["SELECCIONADOS"];
$rowinterno["ESTADO_ORDEN_MES"]=$filavector["ESTADO_ORDEN_MES"];
$rowinterno["NUMERO_ORDEN"]=$filavector["NUMERO_ORDEN"];
$rowinterno["ORDENES"]=$filavector["ORDENES"]+0;
$arrayinterno[]=$rowinterno;

//echo "<td>".$i."</td><td><a href='".$linkestudiante."'>".$row['numerodocumento']."</a></td><td>".$row['apellidosestudiantegeneral']."</td><td>".$row['nombresestudiantegeneral']."</td><td>".$row['semestre']."</td><td>".$row['codigoperestudiante']."</td><td>".$row['nombresituacioncarreraestudiante']."</td><td>".$cajachequeo."</td>";

echo "</tr>";


/*ACABA WHILE DE ARNMADO DE ARRAY*/
}
echo "</table></form>";


unset($_GET['Recargar']);


$motor = new matriz($arrayinterno,"Listado de proceso de facultad","creacionordenescolegio.php","si","si","creacionordenescolegio.php?codigoperiodo=".$_SESSION['codigoperiodoordenescolegio'],"creacionordenescolegio.php?codigoperiodo=".$_SESSION['codigoperiodoordenescolegio'],true,"si","../../../");

$motor->botonRegresar=false;
$motor->botonRecargar=false;
$motor->mostrar();
//$formulario->filatmp["todos"]="*Todos*";
}
}
if(isset($_GET['Enviar'])){

	//exit();
	if(isset($_POST['estudiantetmp'])&&trim($_POST['estudiantetmp'][0])!='')
		$_POST['estudiante']=$_POST['estudiantetmp'];

	$_SESSION['estudiantesordencolegio']=(isset($_POST['estudiante']))?$_POST['estudiante']:$_SESSION['estudiantesordencolegio'];

	if(formato_fecha_mysql($_GET['fechapago'])>=date("Y-m-d")){

		$conteo=(isset($_SESSION['conteo_est']))?$_SESSION['conteo_est']:0;
		$conteo_aux=count($_SESSION['estudiantesordencolegio'])-1;
		if($conteo<=$conteo_aux) {

			$tablas="facturavalorpecuniario f, detallefacturavalorpecuniario df, valorpecuniario v, estudiante e, concepto c, referenciaconcepto r";

			$ordenesxestudiante = new Ordenesestudiante($salatmp, $_SESSION['estudiantesordencolegio'][$conteo], $_SESSION['codigoperiodoordenescolegio']);

			$condicion=" and f.codigocarrera = e.codigocarrera
				and df.idfacturavalorpecuniario = f.idfacturavalorpecuniario
				and v.idvalorpecuniario = df.idvalorpecuniario
				and f.codigoperiodo = '".$_SESSION['codigoperiodoordenescolegio']."'
				and f.codigoperiodo = v.codigoperiodo
				and e.codigotipoestudiante = df.codigotipoestudiante
				and e.codigoestudiante = '".$_SESSION['estudiantesordencolegio'][$conteo]."'
				and c.codigoconcepto = v.codigoconcepto
				and c.codigoreferenciaconcepto = r.codigoreferenciaconcepto
				and df.codigoestado like '1%'";


			$datosconcepto=$objetobase->recuperar_datos_tabla($tablas,"c.codigoconcepto",$_GET['codigoconcepto'],$condicion,"",1);


			//echo "<br>ordenpago=".$ordenesxestudiante->ordenesdepago['numeroordenpago']."=";
			$cantidades[$_GET['codigoconcepto']]='1';
			$conceptos1[0]=$_GET['codigoconcepto'];

			if(!isset($_GET['fechapago'])||trim($_GET['fechapago'])==''){
				//echo "<h1>generarordenpago_conceptoscantidad</h1>";
				$ordenesxestudiante->generarordenpago_conceptoscantidad($conceptos1, $cantidades, "Generacion masiva colegio");
			} else {
				$cantidadfecha[$_GET['codigoconcepto']]=$datosconcepto['valorpecuniario'];
				//echo "<h1>generarordenpago_conceptos_fecha ".formato_fecha_mysql($_POST['fechapago'])."</h1>";
				$ordenesxestudiante->generarordenpago_conceptos_fecha($conceptos1, $cantidadfecha,formato_fecha_mysql($_GET['fechapago']));
			}	
			
			$tablasfechaentrega = "estudiante e,ordenpago o,detalleordenpago do";
			$condicion = "	and do.numeroordenpago=o.numeroordenpago
					and e.codigoestudiante=o.codigoestudiante
					and e.codigoestudiante=".$_SESSION['estudiantesordencolegio'][$conteo]."
					and o.codigoestadoordenpago like '1%'
					group by e.codigoestudiante";
			$datosconcepto=$objetobase->recuperar_datos_tabla($tablasfechaentrega,"do.codigoconcepto",$_GET['codigoconcepto'],$condicion,",max(o.numeroordenpago) maxnumeroordenpago",0);
			unset($fila);
			$fila['fechaentregaordenpago']=formato_fecha_mysql("01/".$_GET['mesorden']);
			$objetobase->actualizar_fila_bd("ordenpago",$fila,"numeroordenpago",$datosconcepto['maxnumeroordenpago'],'',0);

			$conteo++;
			$_SESSION['conteo_est']=$conteo;
			echo "<script>document.form1.submit()</script>";
		} else {
			alerta_javascript("Se han Creado ".count($_SESSION['estudiantesordencolegio'])." ordenes de pensión");
			unset($_SESSION['conteo_est']);
			unset($_SESSION['estudiantesordencolegio']);
			echo "<script>location.href='creacionordenescolegio.php'</script>";
		}
	} else {
		alerta_javascript("Fecha de pago debe ser la actual o una posterior");
	}
}
//exit();
//if($_GET['enviopropio'])
//echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=creacionordenescolegio.php?codigoperiodo=".$_SESSION['codigoperiodoordenescolegio']."'>";
?>
</body>
</head>
</html>
