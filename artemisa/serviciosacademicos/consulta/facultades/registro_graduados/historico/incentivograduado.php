<?php 
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
$rol=$_SESSION['rol'];
//$_SESSION['MM_Username']='admintecnologia';
//print_r($_SESSION);
$rutaado=("../../../../funciones/adodb/");
require_once("../../../../funciones/clases/debug/SADebug.php");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../../funciones/phpmailer/class.phpmailer.php");
require_once("../../../../funciones/validaciones/validaciongenerica.php");
require_once("../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
function comparacionregistro($fila1,$fila2){
	while (list ($clave, $val) = each ($fila1)) {
			if($fila1[$clave]!=$fila2[$clave])
				return false;
	}
	return true;
} 
function tablaregistrograduado($tabla,$nombreidtabla,$idtabla,$condicion2="",$tablaprincipal,$tmpregistrograduado,$objetobase,$formulario,$imprimir=0){
		$condicion=" and rg.codigoestudiante=e.codigoestudiante and
					ca.codigocarrera=e.codigocarrera and
					e.idestudiantegeneral=eg.idestudiantegeneral";
		$condicion.=$condicion2;
		$tablas="$tabla carrera ca, estudiante e,".
				" estudiantegeneral eg, registrograduado rg, incentivoacademico i";
		if($datosregistrogrado=$objetobase->recuperar_datos_tabla($tablas,$nombreidtabla,$idtabla,$condicion,'',$imprimir)){
			if(!comparacionregistro($datosregistrogrado,$tmpregistrograduado)||(!isset($tmpregistrograduado))){
				$formulario->dibujar_fila_titulo('Incentivo Academico','labelresaltado',4);
				$fila["Nombre_del_Egresado"]=$datosregistrogrado["apellidosestudiantegeneral"]." ".$datosregistrogrado["nombresestudiantegeneral"];//
				$fila["Documento_del_Egresado"]=$datosregistrogrado["numerodocumento"];//
				$formulario->dibujar_filas_texto($fila,'tdtitulogris','','colspan=2','colspan=2');
				unset($fila);
				$fila["Id_del_Estudiante"]=$datosregistrogrado["codigoestudiante"];
				$fila["Fecha_del_Registro"]=$datosregistrogrado["fecha$tablaprincipal"];
				$fila["Fecha_del_Acta"]=$datosregistrogrado["fechaacta$tablaprincipal"];
				$fila["Fecha_de_Acuerdo"]=$datosregistrogrado["fechaacuerdo$tablaprincipal"]."&nbsp;";
				$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"","");
				unset($fila);
				$fila["Incentivo"]=$datosregistrogrado["nombre$tablaprincipal"];
				$fila["Clase_de_incentivo"]=$datosregistrogrado["nombreincentivoacademico"];;		
				$fila["Numero_del_Acta"]=$datosregistrogrado["numeroacta$tablaprincipal"];
				$fila["Numero_de_Acuerdo"]=$datosregistrogrado["numeroacuerdo$tablaprincipal"];		
				$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"","");
				unset($fila);
				$fila["Observacion"]=$datosregistrogrado["observacion$tablaprincipal"]."&nbsp;";
				$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");
			}
			else{
				return 0;
			}
		}
		else{
			return 0;
		}
		
	return $datosregistrogrado;
}
?>

<script LANGUAGE="JavaScript">

function quitarFrame()
{
	if (self.parent.frames.length != 0)
	self.parent.location=document.location.href="../../../../aspirantes/aspirantes.php";

}
function regresarGET()
{
	//history.back();
	location.href="<?php echo '../../../prematricula/matriculaautomaticaordenmatricula.php';?>";
}
function enviarregistro(numerolog){
	form1.action="incentivograduado.php?idregistrograduado=<?php echo $_GET['idregistrograduado'] ?>&numerolog="+numerolog+"#"+numerolog;
	form1.submit();
}
function ventanaemergente(pagina){
open ( pagina ,"imprimir", " width=600, height=300, scrollbars=yes, resizable=yes " ) ;

}
//quitarFrame()
</script>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
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


?>

<form name="form1" action="consultagraduado.php" method="POST" >
<input type="hidden" name="AnularOK" value=""> 
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
	<?php 
		//$formulario->dibujar_fila_titulo('APORTES SEGURIDAD SOCIAL EPS ARP','labelresaltado',"2","align='center'");
		if(isset($_GET["numerolog"]))
			if($_SESSION["logssesion"][$_GET["numerolog"]])
				$_SESSION["logssesion"][$_GET["numerolog"]]=0;
			else
				$_SESSION["logssesion"][$_GET["numerolog"]]=1;
				
	$condicion="and rg.codigoestudiante=e.codigoestudiante and
					e.idestudiantegeneral=eg.idestudiantegeneral";
	$datosestudiante=$objetobase->recuperar_datos_tabla("estudiante e, estudiantegeneral eg, registrograduado rg","rg.idregistrograduado",$_GET['idregistrograduado'],$condicion,'',0);
	$formulario->dibujar_fila_titulo("Incentivo De Grado de ".$datosestudiante['apellidosestudiantegeneral']." ".$datosestudiante['nombresestudiantegeneral']." ".$datosestudiante['numerodocumento']."",'labelresaltado',"4","align='center'");

				$condicion=" and ri.idregistrograduado=rg.idregistrograduado
							and ri.idincentivoacademico=i.idincentivoacademico
							and ri.codigoestado like '1%'";
				$tablaprincipal="registroincentivoacademico";
		if($registrograduado=tablaregistrograduado('registroincentivoacademico ri,','rg.idregistrograduado',$_GET['idregistrograduado'],$condicion,$tablaprincipal,$registrograduado,$objetobase,$formulario))
		{
			//unset($fila);
			//$fila[""]="<a href='registroincentivos.php?idregistrograduado=".$idregistrograduado."' onclick=ventanaemergente('registroincentivos.php?idregistrograduado=".$idregistrograduado."'); >Incentivos academicos</a>&nbsp;";
			//$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");

			$operacion=$objetobase->recuperar_resultado_tabla("logregistroincentivoacademico","idregistroincentivoacademico",$registrograduado['idregistrograduado'],"and codigoestado like '1%' order by idlogregistroincentivoacademico","",0);
			$i=0;
			while($row_operacion=$operacion->fetchRow())
			{
				$i++;
				if($_SESSION["logssesion"][$row_operacion["idlogregistroincentivoacademico"]]){
				$condicion=" and ri.idregistrograduado=rg.idregistrograduado
						and lr.idregistroincentivoacademico=ri.idregistroincentivoacademico
						and lr.idincentivoacademico=i.idincentivoacademico
						and rg.idregistrograduado=".$_GET['idregistrograduado'].
						" and ri.codigoestado like '1%' and lr.codigoestado like '1%'";
				$tablaprincipal="logregistroincentivoacademico";
					if($registrograduado=tablaregistrograduado('registroincentivoacademico ri, logregistroincentivoacademico lr,','lr.idlogregistroincentivoacademico',$row_operacion["idlogregistroincentivoacademico"],$condicion,$tablaprincipal,$registrograduado,$objetobase,$formulario,0))
					{
						$mensaje="Mostrar >>>";
						if($_SESSION["logssesion"][$row_operacion["idlogregistroincentivoacademico"]])
						$mensaje="Ocultar <<<";
						$campo="boton_tipo"; $parametros="'button','logregistro$i','".$mensaje."','onclick=enviarregistro(".$row_operacion["idlogregistroincentivoacademico"].")'";
						$formulario->dibujar_campo($campo,$parametros,"<a name='".$row_operacion["idlogregistroincentivoacademico"]."'>Log del Registro $i</a>","tdtitulogris",'fechafinal','',0,'colspan=2');
						$cadenaanclaje.="<A HREF='#".$row_operacion["idlogregistroincentivoacademico"]."'>".$row_operacion["idlogregistroincentivoacademico"]."</A>&nbsp;";
					}

				}
			}
			echo "<tr><td colspan=4>";

			//$formulario->boton_tipo('button','Regresar','Regresar','onclick=\'regresarGET();\'');
			//echo $cadenaanclaje;
			echo "</tr></td>";
		}
		else{
			alerta_javascript("Este estudiante No tiene Incentivos de Grado ");
			//header("location: matriculaautomaticaordenmatricula.php");
			echo "<script LANGUAGE='JavaScript'>window.close();</script>";
		}
?>

  </table>
</form>