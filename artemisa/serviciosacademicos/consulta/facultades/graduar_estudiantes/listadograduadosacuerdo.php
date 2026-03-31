<?php
session_start();
ini_set('max_execution_time','6000');
?>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<script LANGUAGE="JavaScript">
	function  ventanaprincipal(pagina)
	{
		opener.focus();
		opener.location.href=pagina.href;
		window.close();
		return false;
	}
	function reCarga()
	{
		document.location.href="<?php echo 'marcograduadosacuerdo.php';?>";	
	}
	function regresarGET()
	{
		document.location.href="<?php echo 'marcograduadosacuerdo.php';?>";
	}
	var paso=0;
	var tiempoestimadopaso=0;
	var otropaso=0;
	var pasonoentero=0;
	var pasonoenteroi=0;
	var i=0;
	var transcurretiempo=0;
	function Mensaje(total,tiempo)
	{
		
		//alert("Entro?");
	//window.document.getElementById("capageneral").style.visibility="visible";
	window.document.getElementById("Capa1").style.visibility="visible";
	window.document.getElementById("Capa3").style.left=0;
	window.document.getElementById("Capa3").style.top=0;
	window.document.getElementById("Capa3").style.width=5;
	window.document.getElementById("Capa3").style.background="blue";
	window.document.getElementById("Capa2").style.visibility="visible";
	window.document.getElementById("Capa3").style.visibility="visible";
	window.status="Ejecutando el programa ";
	i=0;
	paso=200/total;
	otropaso=1/paso;
	//tiempoestimadopaso=parseInt(otropaso*2000);
	//alert("tiempoestimadopaso="+tiempoestimadopaso);
	//setTimeout("Puntos()",tiempoestimadopaso);
	pasonoentero=paso-parseInt(paso);
	Puntos();
	}
	function Puntos(tiempotranscurrido) 
	{
	 //alert("entro?"+paso);
	i++;
	var pasopuntoi=i*parseInt(paso)+parseInt(i*pasonoentero);
	
/*  	if(pasonoenteroi<1)
		pasonoenteroi+=pasonoentero;
	else{
		pasopuntoi=i*parseInt(paso)+1;
		pasonoenteroi=pasonoenteroi-1;
		//alert("pasonoenteroi="+pasonoenteroi);
	 }
 */	 
	if (parseInt(window.document.getElementById("Capa3").style.width) < 200)
	//  window.document.getElementById("Capa3").style.width=parseInt(window.document.getElementById("Capa3").style.width)+pasopuntoi;
	  window.document.getElementById("Capa3").style.width=pasopuntoi;
	  window.document.getElementById("barratiempo").innerHTML="";
	  window.document.getElementById("barratiempo").innerHTML=tiempotranscurrido;
	// if(paso<1)
	 	//paso++;
	//else     //Se anula para que finalice cuando se llene la barra
	//  window.document.getElementById("Capa3").style.width=5;
	//setTimeout("Puntos()",tiempoestimadopaso);
	
	}
</script>
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<script type="text/javascript" src="../../../../funciones/sala_genericas/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<style type="text/css">
.CapaFondo {
	position:relative;
	left: 0px;
	top: 0px;
	visibility:hidden;
	width: 300px;
	height: 100px;
	font-weight: bold;
	font-weight: bold;
	border: 3px;
	border-style: ridge;
	text-align: center;
	padding: 10px;
	font-size: 10px;
}	

.Barra {
	position:fixed; 
	left: 50px; 
	top: 60px; 
	visibility:hidden; 
	width: 200px; 
	height: 20px; 
	background-color: #AAAAAA;
	text-align: left;
}
</style>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../../../funciones/clases/formulario/globo.js"></script>
<div id='capageneral' style='position:absolute; left:250px; top:10px; width:209px; height:10px; z-index:1; background-color: #FFFFFF; layer-background-color: #FFFFFF; visibility: hidden;'>
<table summary="" width="80%">
	<tr><td align="center">
  	<div id="Capa1" class=CapaFondo>Espere mientras se ejecuta ...<br>&nbsp;
  		 <div id="Capa2" class=Barra>
  		 			<div id="Capa3" class=Barra></div></div>
			<div id="barratiempo"  align="center"></div>
	</div>
</td></tr>
</table>
</div>
<?php
$rutaado=("../../../../funciones/adodb/");
require_once("../../../../funciones/clases/motorv2/motor.php");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once("../../../../funciones/sala_genericas/FuncionesMatematica.php");

require_once("../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("funciones/validaciones.php");

//require_once('../../../../funciones/clases/autenticacion/redirect.php' ); 

function encuentra_array_materias($sala,$codigomateria,$codigocarrera,$codigomodalidadacademica,$codigoperiodo,$columna,$idpermisomenuopcion,$objetobase,$imprimir=0){
 
 
/*if($codigocarrera!="todos")
$carreradestino="AND e.codigocarrera='".$codigocarrera."'";
else
$carreradestino="";*/
$tienetodos=0;

if(is_array($codigocarrera)){
for($i=0;$i<count($codigocarrera);$i++){
	if($i==0)
		$lista=$codigocarrera[$i];
	else
		$lista.=",".$codigocarrera[$i];

if($codigocarrera[$i]=="todos"){
$tienetodos=1;
$carreradestino="";
}
}
if(!$tienetodos)
$carreradestino="AND e.codigocarrera in (".$lista.")";

}

//echo "<h1>".$carreradestino."</h1>";
if($codigomateria!="todos")
	$materiadestino="AND m.codigomateria='".$codigomateria."'";
else
	$materiadestino="";

if($columna){
$numerocorte="and co.numerocorte='".$columna."' ";
$condicionnotaaprobada="and ROUND(d.nota,1) < m.notaminimaaprobatoria";
}
else{
$condicionnotaaprobada="";
$numerocorte="";
}

if($columna==5){
$condicionnotaaprobada="and ROUND(h.notadefinitiva,1) < m.notaminimaaprobatoria";
$numerocorte="";
}

$query="select c.codigocarrera,c.nombrecarrera,e.codigoestudiante,
sc.nombresituacioncarreraestudiante Situacion_Actual,
e.semestre,eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,eg.codigogenero,
co.nombreconcepto Orden_Vigente
		from estudiantegeneral eg, estudiante e, planestudioestudiante pe,
		 planestudio p, ordenpago o, detalleordenpago do,carrera c,situacioncarreraestudiante sc,concepto co
			where 
			e.idestudiantegeneral=eg.idestudiantegeneral and
			pe.codigoestudiante=e.codigoestudiante and
			p.idplanestudio=pe.idplanestudio and 
			pe.codigoestadoplanestudioestudiante like '1%' and
			p.codigoestadoplanestudio like '1%' and
			e.semestre=p.cantidadsemestresplanestudio and
			o.codigoestudiante=e.codigoestudiante and
			o.numeroordenpago=do.numeroordenpago and
			do.codigoconcepto in  (151,108) and
			e.codigosituacioncarreraestudiante in (104,400) and
			c.codigocarrera=e.codigocarrera and
			e.codigosituacioncarreraestudiante=sc.codigosituacioncarreraestudiante
			and o.codigoperiodo=".$codigoperiodo."			
			".$carreradestino."
			and c.codigomodalidadacademica='".$codigomodalidadacademica."'
			and co.codigoconcepto=do.codigoconcepto
			group by o.codigoestudiante	
			UNION
			select c2.codigocarrera,c2.nombrecarrera,e.codigoestudiante,
			sc.nombresituacioncarreraestudiante,
			e.semestre,eg.numerodocumento,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral,
			eg.codigogenero,'' Orden_Vigente 
			from estudiantegeneral eg, estudiante e, carrera c2,situacioncarreraestudiante sc
			where 
			e.idestudiantegeneral=eg.idestudiantegeneral and
			c2.codigocarrera=e.codigocarrera and
			e.codigosituacioncarreraestudiante=104 and
			e.codigosituacioncarreraestudiante=sc.codigosituacioncarreraestudiante		
			".$carreradestino."
			and c2.codigomodalidadacademica='".$codigomodalidadacademica."'
			group by e.codigoestudiante	
			order by nombrecarrera,apellidosestudiantegeneral,nombresestudiantegeneral
			";
	//flush(); 
	if($imprimir)
	echo $query;
	//exit();
	$operacion=$objetobase->conexion->query($query);
	$totalregistros=$operacion->RecordCount();
	

	echo "<script LANGUAGE='JavaScript'>Mensaje(".$totalregistros.");</script>";
	ob_flush();
	flush();


//$row_operacion=$operacion->fetchRow();
$i=0;
$columnas['estado']=1;
$columnas['nombrecarrera']=1;
$columnas['codigoestudiante']=1;
$columnas['Situacion_Actual']=1;
$columnas['Orden_Vigente']=1;
$columnassiparametrizar=array("Orden_Vigente");
$columnas['semestre']=1;
$columnas['numerodocumento']=1;
$columnas['apellidosestudiantegeneral']=1;
$columnas['nombresestudiantegeneral']=1;

	$operaciontipopaz=$objetobase->recuperar_resultado_tabla("tipodetallepazysalvoegresado","codigoestado","100"," order by idtipodetallepazysalvoegresado","",0);
	while ($rowtipopaz=$operaciontipopaz->fetchRow()){
		if($rowtipopaz["codigotiporegistro"]==100)
			$columnas[cambiarespacio($rowtipopaz['nombretipodetallepazysalvoegresado'])]=1;
	}
	$tmpcarrera="";
	$horainicial=mktime(date("H"),date("i"),date("s"));

	while ($row_operacion=$operacion->fetchRow())
	{
		$i++;
		$tmpgenero=$row_operacion["genero"];
		
		//echo "$i) ESTUDIANTE=".$row_operacion['codigoestudiante']."<br>";
		if($i==1){
		$validaciones=new validaciones_requeridas($sala,$row_operacion['codigoestudiante'],$codigoperiodo,$debug);
		$validaciones->periodo=$codigoperiodo;
		}
		if($tmpcarrera!=$row_operacion["codigocarrera"]){
			$validaciones->codigoestudiante=$row_operacion['codigoestudiante'];
			$validaciones->codigocarrera=$row_operacion["codigocarrera"];
			$validaciones->codigogenero=$row_operacion["codigogenero"];
			$validaciones->carga_datos_a_validar();
			$tmpcarrera=$row_operacion["codigocarrera"];
		}
		//echo "<h1>$i) estudiante ".$row_operacion['codigoestudiante']." </h1>";

		$validaciones->periodo=$codigoperiodo;
		$validaciones->codigoestudiante=$row_operacion['codigoestudiante'];
		$validaciones->codigocarrera=$row_operacion["codigocarrera"];
		$validaciones->codigogenero=$row_operacion["codigogenero"];
		$valido=$validaciones->verifica_validaciones();
		$array_documentos_pendientes=$validaciones->retorna_array_documentos_pendientes();
		$array_materias_pendientes=$validaciones->retorna_array_materias_pendientes();

		$array_validaciones=$validaciones->retorna_array_validaciones();

		if(!is_array($array_validaciones[0]))
		{
				echo " NO SE HAN PARAMETRIZADO LAS TABLAS DE VALIDACION<BR>";
				//exit();
		}
/* 		 echo "<pre>";
			print_r($array_validaciones);
		echo "</pre>"; 
 */
		$conestadosi=0;$codigoestados=0;
		if(is_array($array_validaciones))
		foreach($array_validaciones as $llave => $valores){
			if($valores["requerido"]){
				$codigoestados++;

				if($valores["valido"]){
				
					$row_operacion[cambiarespacio($valores["validacion"])]="si";
					$arraytipopazysalvoestudiante[$row_operacion["codigoestudiante"]][$valores["idtipodetallepazysalvoegresado"]]=1;
					if($valores['idtipodetallepazysalvoegresado']==1){
					$row_operacion["estado"]="<img src='../../imagesAlt2/amarillo.gif' alt='estado' name='imagen' width='40' height='12'> ";
					}
					$conestadosi++;
				}
				else{
					if($valores['idtipodetallepazysalvoegresado']==1)
					$row_operacion["estado"]="<img src='../../imagesAlt2/rojo.gif' alt='estado' name='imagen' width='40' height='12'> ";
					$row_operacion[cambiarespacio($valores["validacion"])]="no";
				}
			}

			//$columnas[cambiarespacio($valores["validacion"])]=1;	
		}
			//echo "if($conestadosi==$codigoestados)<br>";
		
		if(is_array($array_documentos_pendientes))
			foreach($array_documentos_pendientes as $llave => $valores)
				$row_operacion["Documentos_Pendientes"].=" '".$valores["documentacion"]."',";
		else
			$row_operacion["Documentos_Pendientes"]="&nbsp;";
		
		if(is_array($array_materias_pendientes)){
			$array_materias_pendientes_tmp=$array_materias_pendientes;
			foreach($array_materias_pendientes as $llave => $valores)
				$row_operacion["Materias_Pendientes"].=$valores["nombremateria"]."-S:".$valores["semestredetalleplanestudio"]."";
		}
		else{
			$row_operacion["Materias_Pendientes"]="&nbsp;";
		}
		//if($valido)
		if($idpermisomenuopcion==254){
			if($conestadosi==$codigoestados){
				$row_operacion["estado"]="<img src='../../imagesAlt2/verde.gif' alt='estado' name='imagen' width='40' height='12'> ";
				$array_interno[]=$row_operacion;
			}
		}
		else{
			if($conestadosi==$codigoestados){
				$row_operacion["estado"]="<img src='../../imagesAlt2/verde.gif' alt='estado' name='imagen' width='40' height='12'> ";
			}
				$array_interno[]=$row_operacion;
		}
	//$array_observacion[]=array('resumen_observacion'=>substr($row_operacion['observacion'],0,5);
			$horafinal=mktime(date("H"),date("i"),date("s"));
			$diferencia=$horafinal-$horainicial;
			$datostiempo[]=$diferencia;
			//echo "<h1>Tiempo=";
			//echo $diferencia=$horafinal-$horainicial;
		//$datostiempo[]=$diferencia;
			//echo "</h1>";

			echo "<script LANGUAGE='JavaScript'>Puntos('".segundososaminutos($diferencia)."');</script>";
			ob_flush();
			flush();
	 }
/* 	echo "<h1>Promedio=";
	echo promedio($datostiempo);
	echo "</h1>";
 */	
	echo "<script LANGUAGE='JavaScript'>window.document.getElementById('Capa3').style.visibility='hidden';</script>";
	echo "<script LANGUAGE='JavaScript'>window.document.getElementById('Capa2').style.visibility='hidden';</script>";
	echo "<script LANGUAGE='JavaScript'>window.document.getElementById('Capa1').style.visibility='hidden';</script>";
	echo "<script LANGUAGE='JavaScript'>window.document.getElementById('capageneral').style.visibility='hidden';</script>";

	ob_flush();
	flush();


	$columnas["Documentos_Pendientes"]=1;	
	$columnas["Materias_Pendientes"]=1;
	for($i=0;$i<count($array_interno);$i++)
	 foreach($columnas as $llave => $valor)
			if(!isset($array_interno[$i][$llave])||(trim($array_interno[$i][$llave])=='')){
				if(!in_array($llave,$columnassiparametrizar))
				$array_nuevo[$i][$llave]="NO PARAMETRIZADO";
				else
				$array_nuevo[$i][$llave]="&nbsp;";
				//echo "ENTRO?array_interno[".$i."][".$llave."]=".$array_interno[$i][$llave]."<BR>";

			}
			else{
				$array_nuevo[$i][$llave]=$array_interno[$i][$llave];
			}
	
	$arrayretorno[0]=$array_nuevo;
	$arrayretorno[1]=$arraytipopazysalvoestudiante;

/*   	echo "<pre>";
	print_r($array_validaciones);
	echo "</pre>";
 */ 
 return $arrayretorno;
}

$objetobase=new BaseDeDatosGeneral($sala);
$formulario=new formulariobaseestudiante($sala,'form2','post','','true');


//if(isset($_POST['codigocarrera'])&&($_POST['codigocarrera']!=''))
//$codigofacultad="05";
/* echo "<pre>";
print_r($_POST['codigocarrera']);
echo "</pre>";
 *///exit();
unset($filacarreras);




if($_REQUEST['codigomodalidadacademica']!=$_SESSION['codigomodalidadacademicagraduadosacuerdo']&&trim($_REQUEST['codigomodalidadacademica'])!='')
$_SESSION['codigomodalidadacademicagraduadosacuerdo']=$_REQUEST['codigomodalidadacademica'];

//echo "<br>_SESSION[codigomateriagraduadosacuerdo]=".$_SESSION['codigomateriagraduadosacuerdo'];
if($_REQUEST['codigocarrera']!=$_SESSION['codigocarreragraduadosacuerdo']&&(trim($_REQUEST['codigocarrera'])!=''))
$_SESSION['codigocarreragraduadosacuerdo']=$_REQUEST['codigocarrera'];

if($_REQUEST['codigoperiodo']!=$_SESSION['codigoperiododgraduadosacuerdo']&&(trim($_REQUEST['codigoperiodo'])!=''))
$_SESSION['codigoperiododgraduadosacuerdo']=$_REQUEST['codigoperiodo'];


$usuario=$formulario->datos_usuario();
$datosrolusuario=$objetobase->recuperar_datos_tabla(" permisousuariomenuopcion pu","pu.idusuario",$usuario['idusuario'],'','',0);


if(isset($_REQUEST['Enviar'])){
$cantidadestmparray=encuentra_array_materias($sala,$_SESSION['codigomateriagraduadosacuerdo'],$_SESSION['codigocarreragraduadosacuerdo'],$_SESSION['codigomodalidadacademicagraduadosacuerdo'],$_SESSION['codigoperiododgraduadosacuerdo'],$_SESSION['columnagraduadosacuerdo'],$datosrolusuario["idpermisomenuopcion"],$objetobase,0);
$_SESSION['cantidadestmparraygraduadosacuerdo']=$cantidadestmparray;
}
echo "<pre>";
//print_r($cantidadestmparray);
echo "</pre>";
//echo "if(".$datosrolusuario["idpermisomenuopcion"]."==254){";
if($datosrolusuario["idpermisomenuopcion"]==254){
$formulario->dibujar_fila_titulo("GRADUANDOS ".$_SESSION['codigoperiododgraduadosacuerdo'],'labelresaltado',2);

?>
<form name="form2" action='' method="POST" >
<input type="hidden" name="AnularOK" value=""> 

<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
<?php
/* $condicion=" and dpm.idpermisomenuopcion=pm.idpermisomenuopcion".
			   " and dpm.idmenuopcion='".$idmenuopcion."'";
 */


$parametrobotontmp="'text','nombrelistado','',''";
$botontmp='boton_tipo';							
$formulario->dibujar_campo($botontmp,$parametrobotontmp,"Nombre De Listado","tdtitulogris",'nombrelistado','requerido',0,'colspan=1');

$campo="campo_fecha"; $parametros="'text','fechaacuerdograduado','".$fechaacuerdograduado."','onKeyUp = \"this.value=formateafecha(this.value);\" '";
$formulario->dibujar_campo($campo,$parametros,"Fecha del acuerdo","tdtitulogris",'fechaacuerdograduado','requerido');

$parametrobotontmp="'text','numeroacuerdograduado','',''";
$botontmp='boton_tipo';							
$formulario->dibujar_campo($botontmp,$parametrobotontmp,"Numero del Acuerdo","tdtitulogris",'numeroacuerdograduado','numero',0,'colspan=1');

$parametrobotontmp="'text','numeroactaacuerdograduado','',''";
$botontmp='boton_tipo';							
$formulario->dibujar_campo($botontmp,$parametrobotontmp,"Numero del Acta","tdtitulogris",'numeroactaacuerdograduado','numero',0,'colspan=1');

$campo="campo_fecha"; $parametros="'text','fechaactaacuerdograduado','".$fechaactaacuerdograduado."','onKeyUp = \"this.value=formateafecha(this.value);\" '";
$formulario->dibujar_campo($campo,$parametros,"Fecha del Acta","tdtitulogris",'fechaactaacuerdograduado','requerido');

$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("tipoacuerdograduado","idtipoacuerdograduado","nombretipoacuerdograduado","");
$formulario->filatmp[""]="Seleccionar";	
$campo='menu_fila'; $parametros="'idtipoacuerdograduado','".$idtipoacuerdograduado."','onchange=enviarmenu();'";
$formulario->dibujar_campo($campo,$parametros,"Tipo de titulo","tdtitulogris",'idtipoacuerdograduado','');


$conboton=0;
$parametrobotonenviar[$conboton]="'submit','Guardar_Graduandos','Aceptar','onclick=\" return confirm(\'Desea guardar el listado\')\"'";
$boton[$conboton]='boton_tipo';							
$conboton++;				
$formulario->dibujar_campos($boton,$parametrobotonenviar,"Guardar graduandos","tdtitulogris",'Enviar','',0,'colspan=1');

?>
 </table>
</form>

<?php 

//EliminarColumnaArrayBidimensional($columna,$array)
//$array_interno=Sumannnn($array_interno,$array_observacion);
//unset($_GET['Restablecer']);
//unset($_GET['Regresar']);
unset($_GET['Recargar']);
//unset($_GET['Filtrar']);
//$estudiante=ucwords(strtolower($datosestudiante['nombresestudiantegeneral']." ".$datosestudiante['apellidosestudiantegeneral']." con  ".$datosestudiante['nombrecortodocumento']." ".$datosestudiante['numerodocumento']));
//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
// echo "<pre>";
//print_r($motor->matriz_filtrada);
$fechahoy=date("Y-m-d H:i:s");
$arraytipopazysalvoestudiante=$_SESSION['cantidadestmparraygraduadosacuerdo'][1];

if(isset($_REQUEST['Guardar_Graduandos'])){
	if($formulario->valida_formulario()){
		$fila['fechageneracionacuerdograduado']=$fechahoy;
		$fila['nombreacuerdograduado']=$_POST['nombrelistado'];
		$fila['codigoestado']=100;
		$fila['fechaacuerdograduado']=formato_fecha_mysql($_POST['fechaacuerdograduado']);
		$fila['numeroacuerdograduado']=$_POST['numeroacuerdograduado'];
		$fila['numeroactaacuerdograduado']=$_POST['numeroactaacuerdograduado'];
		$fila['fechaactaacuerdograduado']=formato_fecha_mysql($_POST['fechaactaacuerdograduado']);
		$fila['idtipoacuerdograduado']=$_POST['idtipoacuerdograduado'];
		//echo "ENTRO O NO?";			
		$objetobase->insertar_fila_bd("acuerdograduado",$fila,1);

		$datosentradaacuerdo=$objetobase->recuperar_datos_tabla("acuerdograduado","codigoestado","100"," group by codigoestado",",max(codigoacuerdograduado) maxacuerdograduado",0);
		//echo "ENTRO O NO 2";			

		unset($fila);
		for($i=0;$i<count($motor->matriz_filtrada);$i++){
			//echo $motor->matriz_filtrada[$i]["codigoestudiante"]."<br>";
			$fila['numeroorden']=$i;
			$fila['codigoestado']=100;
			$fila['codigoacuerdograduado']=$datosentradaacuerdo['maxacuerdograduado'];
			$fila['codigoestudiante']=$motor->matriz_filtrada[$i]["codigoestudiante"];	
			$condicion = " codigoestudiante=".$fila['codigoestudiante'].
						 " and codigoacuerdograduado=".$fila['codigoacuerdograduado'];				
			$objetobase->insertar_fila_bd("detalleacuerdograduado",$fila,0,$condicion);
			unset($fila);
			unset($condicion);
			$datosdetalleentradaacuerdo=$objetobase->recuperar_datos_tabla("detalleacuerdograduado","codigoestado","100"," group by codigoestado",",max(iddetalleacuerdograduado) maxdetalleacuerdograduado",1);
			//print_r($arraytipopazysalvoestudiante[$motor->matriz_filtrada[$i]["codigoestudiante"]]);
			foreach($arraytipopazysalvoestudiante[$motor->matriz_filtrada[$i]["codigoestudiante"]] as $llave=>$valores){
				$fila["iddetalleacuerdograduado"]=$datosdetalleentradaacuerdo["maxdetalleacuerdograduado"];
				$fila["idtipodetallepazysalvoegresado"]=$llave;				
				$fila["codigoestado"]=100;				
				$fila["fechadetalleacuerdograduadopazysalvoegresado"]=$fechahoy;
				$objetobase->insertar_fila_bd("detalleacuerdograduadopazysalvoegresado",$fila,0,"");
			}
			unset($fila);
			unset($condicion);


		}
		alerta_javascript("Datos ingresados correctamente");
	}
}


}
//echo "</pre>";
/* 
$motor->agregarllave_drilldown('idcentrotrabajoarp','centrostrabajo.php','centrostrabajo.php','','idcentrotrabajoarp',"",'','','','','onclick= "return ventanaprincipal(this)"');
$motor->agregar_llaves_totales('Total_Alumnos',"","","totales","","codigomateria","","xx",true);
$motor->agregar_llaves_totales('Creditos_Materia',"","","totales","","codigomateria","","xx",true);
$motor->agregar_llaves_totales('Total_Creditos_Alumnos',"","","totales","","codigomateria","","xx",true);
*/
$motor = new matriz($_SESSION['cantidadestmparraygraduadosacuerdo'][0],"HISTORIAL LINEA ENFASIS ","listadograduadosacuerdo.php",'si','si','listadograduadosacuerdo.php','listadogeneral.php',true,"si","../../../../");
$tabla->botonRecargar=false;
//$motor->agregar_llaves_totales('Cotizacion_ARP',"","","totales","","codigoestudiante","","xx",true);
$motor->mostrar();


?>
