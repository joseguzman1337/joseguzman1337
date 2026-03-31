<?php 
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
$rol=$_SESSION['rol'];
//$_SESSION['MM_Username']='admintecnologia';
//print_r($_SESSION);
$rutaado=("../../../funciones/adodb/");
require_once("../../../funciones/clases/debug/SADebug.php");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/phpmailer/class.phpmailer.php");
require_once("../../../funciones/validaciones/validaciongenerica.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
function tablaprocesodisciplinario($tabla,$nombreidtabla,$idtabla,$objetobase,$formulario){
		$condicion="and p.codigoestado like '1%' and
					p.codigoestadoprocesodisciplinario=ep.codigoestadoprocesodisciplinario and 
					p.iddirectivoresponsablesancionprocesodisciplinario=d.iddirectivo and
					p.idtipofaltaprocesodisciplinario=t.idtipofaltaprocesodisciplinario and
					p.idtiposancionprocesodisciplinario=ts.idtiposancionprocesodisciplinario
					";
		$tablas="procesodisciplinario p, estadoprocesodisciplinario ep,
				directivo d, tipofaltaprocesodisciplinario t, tiposancionprocesodisciplinario ts";
		if($datosregistrogrado=$objetobase->recuperar_datos_tabla($tablas,$nombreidtabla,$idtabla,$condicion,'',0)){
		$formulario->dibujar_fila_titulo('Proceso disciplinario','labelresaltado',4);
		unset($fila);

		$fila["Estado"]=$datosregistrogrado["nombreestadoprocesodisciplinario"];//
		$fila["Fecha_del_Registro"]=formato_fecha_defecto($datosregistrogrado["fecharegistroprocesodisciplinario"]);//
		$fila["Fecha_de_Apertura"]=formato_fecha_defecto($datosregistrogrado["fechaaperturaprocesodisciplinario"]);//
		$fila["Fecha_de_Notificacion"]=formato_fecha_defecto($datosregistrogrado["fechanotificacionaperturaprocesodisciplinario"]);//
		$formulario->dibujar_filas_texto($fila,'tdtitulogris','',$comentariotitulo,$comentariocelda);
		unset($fila);
		$fila["Id_del_Estudiante"]=$datosregistrogrado["codigoestudiante"];
		$fila["Fecha_de_Sancion"]=formato_fecha_defecto($datosregistrogrado["fechanotificacionsancionprocesodisciplinario"]);//
		$fila["Fecha_del_cierre"]=formato_fecha_defecto($datosregistrogrado["fechacierreprocesodisciplinario"]);//
		$fila["Fecha_del_Acta"]=formato_fecha_defecto($datosregistrogrado["fechaactoadministrativoprocesodisciplinario"]);
		$formulario->dibujar_filas_texto($fila,'tdtitulogris','',$comentariotitulo,$comentariocelda);
		unset($fila);
		$fila["Tipo_de_sancion"]=$datosregistrogrado["nombretiposancionprocesodisciplinario"];
		$fila["Tipo_de_falta"]=$datosregistrogrado["nombretipofaltaprocesodisciplinario"];
		$fila["Nombre_directivo"]=$datosregistrogrado["apellidosdirectivo"]." ".$datosregistrogrado["nombresdirectivo"];
		$fila["Numero_del_Acta"]=$datosregistrogrado["numeroactoadministrativoprocesodisciplinario"]."&nbsp;";
		$formulario->dibujar_filas_texto($fila,'tdtitulogris','',$comentariotitulo,$comentariocelda);
		unset($fila);
		$fila["Observaciones"]=$datosregistrogrado["descripcionprocesoadmnistrativoprocesodisciplinario"]."&nbsp;";
		$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");

		}
		else{
			return 0;
		}
	return $datosregistrogrado["idregistrograduado"];
}
function tabladetalleprocesodisciplinario($tabla,$nombreidtabla,$idtabla,$objetobase,$formulario){
		$condicion=" and tp.idtipodetalleprocesodisciplinario=dp.idtipodetalleprocesodisciplinario 
						and tf.idtipodocumentofisicodetalleprocesodisciplinario=dp.idtipodocumentofisicodetalleprocesodisciplinario
						and dp.codigoestado like '1%'
						order by fechadetalleprocesodisciplinario desc";
		$tablas="detalleprocesodisciplinario dp,tipodetalleprocesodisciplinario tp, 
					tipodocumentofisicodetalleprocesodisciplinario tf";
		if($datos=$objetobase->recuperar_datos_tabla($tablas,$nombreidtabla,$idtabla,$condicion,'',0)){
		//$formulario->dibujar_fila_titulo('Proceso disciplinario','labelresaltado',4);
		unset($fila);

		$fila["Asunto"]=$datos["nombretipodetalleprocesodisciplinario"];//
		$fila["Fecha_del_Registro"]=formato_fecha_defecto($datos["fechadetalleprocesodisciplinario"]);//
		$fila["Tipo_de_documento"]=$datos["nombretipodocumentofisicodetalleprocesodisciplinario"];//
		$vparametros[1]="'archivoadjunto.php?iddetalleprocesodisciplinario=".$datos['iddetalleprocesodisciplinario']."&nombrearchivo=".$datos['nombrearchivodocumentofisicodetalleprocesodisciplinario']."','Visualizar',700,600";
		$vcampo[1]='boton_link_emergente';
		$fila["Archivo"]=$formulario->boton_link_emergente("archivoadjunto.php?iddetalleprocesodisciplinario=".$datos['iddetalleprocesodisciplinario']."&nombrearchivo=".$datos['nombrearchivodocumentofisicodetalleprocesodisciplinario']."","Visualizar",700,600,"no","",1,1);
		$formulario->dibujar_filas_texto($fila,'tdtitulogris','',$comentariotitulo,$comentariocelda);
		unset($fila);
		$fila["Descripción_del_Documento_Adjunto"]=$datos["descripciondocumentofisicodetalleprocesodisciplinario"]."&nbsp;";
		$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");
		unset($fila);
		$fila["Descripción_de_Detalle_del_Proceso"]=$datos["descripciondetalleprocesodisciplinario"]."&nbsp;";
		$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");

		}
		else{
			return 0;
		}
	return $datos["idregistrograduado"];
}

function fichadetalleprocesodisciplinario($idprocesodisciplinario,$formulario,$objetobase)
{

/*echo '$_SESSION["logssesiondetalle"][$_GET["numerodetallelog"]='.$_SESSION["logssesiondetalle"][$_GET["numerodetallelog"]].
		'-------->$_GET["numerodetallelog"]='.$_GET["numerodetallelog"]."<br>";*/
		if(isset($_GET["numerodetallelog"]))
			if($_SESSION["logssesiondetalle"][$_GET["numerodetallelog"]])
				$_SESSION["logssesiondetalle"][$_GET["numerodetallelog"]]=0;
			else
				$_SESSION["logssesiondetalle"][$_GET["numerodetallelog"]]=1;
		$condicion=" and t.idtipodetalleprocesodisciplinario = td.idtipodetalleprocesodisciplinario
					and t.codigoestado like '1%' order by iddetalleprocesodisciplinario desc";

		if($operacion=$objetobase->recuperar_resultado_tabla("detalleprocesodisciplinario t, tipodetalleprocesodisciplinario td","t.idprocesodisciplinario",$idprocesodisciplinario,$condicion,"",0))
		{
		$i=0;
			while($row_operacion=$operacion->fetchRow())
			{
				if($i==0){
				echo "<tr><td ></td><td colspan=4> <table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";

				$formulario->dibujar_fila_titulo('Detalle Proceso Disciplinario','labelresaltado',"4","align='left'");
				}
				$i++;

				$mensaje="Mostrar >>>";
				if($_SESSION["logssesiondetalle"][$row_operacion["iddetalleprocesodisciplinario"]])
				$mensaje="Ocultar <<<";
				$campo="boton_tipo"; $parametros="'button','logregistro$i','".$mensaje."','onclick=enviarregistrodetalle(".$row_operacion["idprocesodisciplinario"].",".$row_operacion["iddetalleprocesodisciplinario"].")'";
				$formulario->dibujar_campo($campo,$parametros,"<a name='d".$row_operacion["iddetalleprocesodisciplinario"]."'>".$row_operacion["nombretipodetalleprocesodisciplinario"]."</a>","tdtitulogris",'fechafinal','',0,'colspan=2');
				$cadenaanclaje.="<A HREF='#d".$row_operacion["iddetalleprocesodisciplinario"]."'>d".$row_operacion["iddetalleprocesodisciplinario"]."</A>&nbsp;";
				if($_SESSION["logssesiondetalle"][$row_operacion["iddetalleprocesodisciplinario"]])
				tabladetalleprocesodisciplinario('procesodisciplinario','dp.iddetalleprocesodisciplinario',$row_operacion["iddetalleprocesodisciplinario"],$objetobase,$formulario);
			}
			echo "<tr><td colspan=4>";
			//$formulario->boton_tipo('button','Regresar','Regresar','onclick=\'regresarGET();\'');
			//echo $cadenaanclaje;
			echo "</td></tr>";
			if($i>0)
			echo"  </table></td><tr>";

		}


}
?>

<script LANGUAGE="JavaScript">

function quitarFrame()
{
	if (self.parent.frames.length != 0)
	self.parent.location=document.location.href="../../../aspirantes/aspirantes.php";

}
function regresarGET()
{
	//history.back();
	location.href="<?php echo '../../prematricula/matriculaautomaticaordenmatricula.php';?>";
}
function enviarregistro(numerolog){
	x=document.getElementById('form1');
	x.action="consultaprocesodisciplinario.php?codigoestudiante=<?php echo $_GET['codigoestudiante'] ?>&numerolog="+numerolog+"#"+numerolog;
	//alert(x.action); 
	x.submit();
}
function enviarregistrodetalle(numerolog,numerodetallelog){
	x=document.getElementById('form1');
	x.action="consultaprocesodisciplinario.php?codigoestudiante=<?php echo $_GET['codigoestudiante'] ?>&numerodetallelog="+numerodetallelog+"#d"+numerodetallelog;
	//alert(x.action); 
	x.submit();
}

function ventanaemergente(pagina){
open ( pagina ,"imprimir", " width=800, height=500, scrollbars=yes, resizable=yes " ) ;
return false;
}
//quitarFrame()
</script>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script type="text/javascript" src="../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../funciones/clases/formulario/globo.js"></script>
<?php
//print_r($_SESSION);
$fechahoy=date("Y-m-d H:i:s");
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);

if($_REQUEST['depurar']=="si")
{
	$depurar=new SADebug();
	$depurar->trace($formulario,'','');
	$formulario->depurar();
	if($_REQUEST['depurar_correo']=="si")
	{
		$depura_correo=true;
	}
	else
	{
		$depura_correo=false;
	}
}
$codigoperiodo=$formulario->carga_periodo(4);
$usuario=$formulario->datos_usuario();
$ip=$formulario->GetIP();

		//$_GET['codigoestudiante']=$codigoestudiante;
		$datosestudiante=$objetobase->recuperar_datos_tabla("estudiante e, estudiantegeneral eg","e.codigoestudiante",$_GET['codigoestudiante'],$condicion,', e.idestudiantegeneral numeroestudiantegeneral',0);
		$idestudiantegeneral=$datosestudiante['numeroestudiantegeneral'];

		$formulario->agregar_tablas('estudiantegeneral','idestudiantegeneral');
		$formulario->cargar('idestudiantegeneral',$idestudiantegeneral);

?>

<form name="form1" id="form1" action="consultagraduado.php" method="POST" >
<input type="hidden" name="AnularOK" value=""> 
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
  	<tr>
	<td colspan="4">
	<?php
	//if(isset($_GET['codigoestudiante'])&&($_GET['codigoestudiante']=="")){
	$condicion=" and t.idtiposancionprocesodisciplinario = ts.idtiposancionprocesodisciplinario
					and t.codigoestado like '1%' order by idprocesodisciplinario desc";
	if($operacion=$objetobase->recuperar_resultado_tabla("procesodisciplinario t, tiposancionprocesodisciplinario ts","t.idestudiantegeneral",$idestudiantegeneral,$condicion,"",0))
	{
 	
	$formulario->dibujar_tabla_informacion_estudiante(puntos(3),"#003333","Estilo3","Estilo4","#CCCCCC");
	?>	</td>
	</tr>

	<?php 
		$formulario->dibujar_fila_titulo('CONSULTA DE PROCESOS DISCIPLINARIO','labelresaltado',"4","align='center'");
		
		/*echo '$_SESSION["logssesion"][$_GET["numerolog"]]='.$_SESSION["logssesion"][$_GET["numerolog"]].
		'$_GET["numerolog"]='.$_GET["numerolog"]."<br>";*/
		//unset($_SESSION);
		if(isset($_GET["numerolog"]))
			if($_SESSION["logssesion"][$_GET["numerolog"]]){
				$_SESSION["logssesion"][$_GET["numerolog"]]=0;
				}
			else{
				$_SESSION["logssesion"][$_GET["numerolog"]]=1;
			}

		$i=0;
			while($row_operacion=$operacion->fetchRow())
			{
				$i++;
				$mensaje="Mostrar >>>";
				if($_SESSION["logssesion"][$row_operacion["idprocesodisciplinario"]])
				$mensaje="Ocultar <<<";
				$campo="boton_tipo"; $parametros="'button','logregistro$i','".$mensaje."','onclick=enviarregistro(".$row_operacion["idprocesodisciplinario"].")'";
				$formulario->dibujar_campo($campo,$parametros,"<a name='".$row_operacion["idprocesodisciplinario"]."'>".$row_operacion["nombretiposancionprocesodisciplinario"]."</a>","tdtitulogris",'fechafinal','',0,'colspan=2');
				$cadenaanclaje.="<A HREF='#".$row_operacion["idprocesodisciplinario"]."'>".$row_operacion["idprocesodisciplinario"]."</A>&nbsp;";
						/*echo '$_SESSION["logssesion"][$row_operacion["idprocesodisciplinario"]]='.$_SESSION["logssesion"][$row_operacion["idprocesodisciplinario"]].
		'$row_operacion["idprocesodisciplinario"]='.$row_operacion["idprocesodisciplinario"]."<br>";
*/
				if($_SESSION["logssesion"][$row_operacion["idprocesodisciplinario"]]){
				tablaprocesodisciplinario('procesodisciplinario','p.idprocesodisciplinario',$row_operacion["idprocesodisciplinario"],$objetobase,$formulario);
				fichadetalleprocesodisciplinario($row_operacion["idprocesodisciplinario"],$formulario,$objetobase);
				}
			}
			echo "<tr><td colspan=4>";
			$formulario->boton_tipo('button','Regresar','Regresar','onclick=\'regresarGET();\'');
			//echo $cadenaanclaje;
			echo "</tr></td>";
		}
		else{
			alerta_javascript("Este estudiante No tiene Proceso Disciplinario");
			//header("location: matriculaautomaticaordenmatricula.php");
			echo "<script LANGUAGE='JavaScript'>regresarGET();</script>";
		}
	//}
	/*else{
		alerta_javascript("Este estudiante No tiene Proceso Disciplinario");
		//header("location: matriculaautomaticaordenmatricula.php");
		echo "<script LANGUAGE='JavaScript'>regresarGET();</script>";
	}*/
	
?>

  </table>
</form>