<?php 
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
$rol=$_SESSION['rol'];

?>
<script src="../../../../Grados/tema/jquery-1.7.1.js"></script>
<p><input type="hidden" id="txtCodigoEstudiante" name="txtCodigoEstudiante" value="<?php echo $_GET['codigoestudiante']; ?>" /></p>
<table>
	<tr>
		<td>
			<table>
				<tr>
					<td>Seleccione Registro Grado: </td>
					<td><select id="cmbRegistroGrado" name="cmbRegistroGrado">
						<option value="-1">Seleccione</option>
						<option value="1">Registro Grado Antiguo</option>
						<option value="2">Registro Grado Nuevo</option>
					</select></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<script type="text/javascript">
  $( "#cmbRegistroGrado" ).change( function( ) {
			var cmbRegistroGrado = $( "#cmbRegistroGrado" ).val( );
			var txtCodigoEstudiante = $("#txtCodigoEstudiante").val( );
			var url2 = "";
			if( cmbRegistroGrado == 2 ){
				url2 = "../../../../Grados/servicio/registroGradoNuevo.php";
				$.ajax({
			  		url: "../../../../Grados/servicio/registroGradoNuevo.php",
			  		type: "POST",
			  		data: { txtCodigoEstudiante : txtCodigoEstudiante },
					success: function( data ){
						$("#registroNuevo").html( data );
						$("#registroNuevo").css("display", "block");
						$("#registroAntiguo").css("display", "none");
						
					}
				});
			}else{
				$("#registroAntiguo").css("display", "block");
				$("#registroNuevo").css("display", "none");
			}
			//alert( url2 );*/
			
	});
</script>
<div id="registroNuevo" style="width: 1024px;">
</div>
<?php

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
function tablaregistrograduado($tabla,$nombreidtabla,$idtabla,$objetobase,$formulario){
		$condicion="and ca.codigocarrera=e.codigocarrera
					and e.codigoestudiante=rg.codigoestudiante
					and e.idestudiantegeneral=eg.idestudiantegeneral 
					and rg.codigoestado like '1%'
					and tr.codigotiporegistrograduado=rg.codigotiporegistrograduado
					and ar.codigoautorizacionregistrograduado=rg.codigoautorizacionregistrograduado
					and tm.codigotipomodificaregistrograduado=rg.codigotipomodificaregistrograduado
					and dir.iddirectivo=rg.iddirectivo
					and tg.idtipogrado=rg.idtipogrado";
		$tablas="$tabla rg,carrera ca, estudiante e,".
				" estudiantegeneral eg,tiporegistrograduado tr,".
				" autorizacionregistrograduado ar, tipomodificaregistrograduado tm,
				directivo dir, tipogrado tg";
		if($datosregistrogrado=$objetobase->recuperar_datos_tabla($tablas,$nombreidtabla,$idtabla,$condicion,'',0)){
		$formulario->dibujar_fila_titulo('Registro de Grado','labelresaltado',4);
		$fila["Nombre_del_Egresado"]=$datosregistrogrado["apellidosestudiantegeneral"]." ".$datosregistrogrado["nombresestudiantegeneral"];//
		$fila["Documento_del_Egresado"]=$datosregistrogrado["numerodocumento"];//
		$formulario->dibujar_filas_texto($fila,'tdtitulogris','','colspan=2','colspan=2');
		unset($fila);
		$fila["Id_del_Estudiante"]=$datosregistrogrado["codigoestudiante"];
		$fila["Fecha_del_Registro_de_Grado"]=formato_fecha_defecto($datosregistrogrado["fecharegistrograduado"]);//
		$fila["Fecha_del_Grado"]=formato_fecha_defecto($datosregistrogrado["fechagradoregistrograduado"]);//
		$fila["Fecha_de_Autorizacion"]=formato_fecha_defecto($datosregistrogrado["fechaautorizacionregistrograduado"]);//
		$formulario->dibujar_filas_texto($fila,'tdtitulogris','',$comentariotitulo,$comentariocelda);
		unset($fila);
		$fila["Tipo_del_Registro"]=$datosregistrogrado["nombretiporegistrograduado"];
		$fila["Fecha_del_Acuerdo"]=formato_fecha_defecto($datosregistrogrado["fechaacuerdoregistrograduado"]);//
		$fila["Fecha_del_Diploma"]=formato_fecha_defecto($datosregistrogrado["fechadiplomaregistrograduado"]);//
		$fila["Fecha_del_Acta"]=formato_fecha_defecto($datosregistrogrado["fechaactaregistrograduado"]);
		$formulario->dibujar_filas_texto($fila,'tdtitulogris','',$comentariotitulo,$comentariocelda);
		unset($fila);
		$fila["Numero_De_Promocion"]=$datosregistrogrado["numeropromocion"];//
		$fila["Numero_de_Acuerdo"]=$datosregistrogrado["numeroacuerdoregistrograduado"];//
		$fila["Numero_del_Diploma"]=$datosregistrogrado["numerodiplomaregistrograduado"];
		$fila["Numero_del_Acta"]=$datosregistrogrado["numeroactaregistrograduado"];
		$formulario->dibujar_filas_texto($fila,'tdtitulogris','',$comentariotitulo,$comentariocelda);
		unset($fila);
		$fila["Tipo_de_Grado"]=$datosregistrogrado["nombretipogrado"];
		$fila["Autorizacion"]=$datosregistrogrado["nombreautorizacionregistrograduado"];
		$fila["Carrera"]=$datosregistrogrado["nombrecortocarrera"];
		$fila["Tipo_de_Modificacion"]=$datosregistrogrado["nombretipomodificaregistrograduado"];
		$formulario->dibujar_filas_texto($fila,'tdtitulogris','',$comentariotitulo,$comentariocelda);
		unset($fila);
		$fila["Responsable_Acuerdo"]=$datosregistrogrado["responsableacuerdoregistrograduado"];
		$fila["Nombre_del_Directivo_Responsable"]=$datosregistrogrado["apellidosdirectivo"]." ".$datosregistrogrado["nombresdirectivo"];
		$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=2","colspan=2");
		unset($fila);
		$fila["Lugar_Registro"]=$datosregistrogrado["lugarregistrograduado"]."&nbsp;";
		$fila["Presidio_del_registro"]=$datosregistrogrado["presidioregistrograduado"]."&nbsp;";
		$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=2","colspan=2");
		unset($fila);
		$fila["Observaciones"]=$datosregistrogrado["observacionregistrograduado"]."&nbsp;";
		$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");

		}
		else{
			return 0;
		}
	return $datosregistrogrado["idregistrograduado"];
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
	form1.action="consultagraduado.php?codigoestudiante=<?php echo $_GET['codigoestudiante'] ?>&numerolog="+numerolog+"#"+numerolog;
	form1.submit();
}
function ventanaemergente(pagina){
open ( pagina ,"imprimir", " width=800, height=500, scrollbars=yes, resizable=yes " ) ;
return false;
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
<div id="registroAntiguo">
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
				
		if($idregistrograduado=tablaregistrograduado('registrograduado','e.codigoestudiante',$_GET['codigoestudiante'],$objetobase,$formulario))
		{
			unset($fila);
			$fila[""]="<a href='registroincentivos.php?idregistrograduado=".$idregistrograduado."' onclick=\"return ventanaemergente('incentivograduado.php?idregistrograduado=".$idregistrograduado."');\" >Incentivos academicos</a>&nbsp;";
			$formulario->dibujar_filas_texto($fila,'tdtitulogris','',"colspan=4","colspan=4");

			$operacion=$objetobase->recuperar_resultado_tabla("logregistrograduado","codigoestudiante",$_GET['codigoestudiante'],"and codigoestado like '1%' order by idlogregistrograduado","",0);
			$i=0;
			while($row_operacion=$operacion->fetchRow())
			{
				$i++;
				$mensaje="Mostrar >>>";
				if($_SESSION["logssesion"][$row_operacion["idlogregistrograduado"]])
				$mensaje="Ocultar <<<";
				$campo="boton_tipo"; $parametros="'button','logregistro$i','".$mensaje."','onclick=enviarregistro(".$row_operacion["idlogregistrograduado"].")'";
				$formulario->dibujar_campo($campo,$parametros,"<a name='".$row_operacion["idlogregistrograduado"]."'>Log del Registro $i</a>","tdtitulogris",'fechafinal','',0,'colspan=2');
				$cadenaanclaje.="<A HREF='#".$row_operacion["idlogregistrograduado"]."'>".$row_operacion["idlogregistrograduado"]."</A>&nbsp;";
				if($_SESSION["logssesion"][$row_operacion["idlogregistrograduado"]])
				tablaregistrograduado('logregistrograduado','rg.idlogregistrograduado',$row_operacion["idlogregistrograduado"],$objetobase,$formulario);
			}
			echo "<tr><td colspan=4>";
			$formulario->boton_tipo('button','Regresar','Regresar','onclick=\'regresarGET();\'');
			//echo $cadenaanclaje;
			echo "</tr></td>";
		}
		else{
			/*alerta_javascript("Este estudiante No tiene Registro de Graduado Actual");
			//header("location: matriculaautomaticaordenmatricula.php");
			echo "<script LANGUAGE='JavaScript'>regresarGET();</script>";*/
		}
?>

  </table>
</form>
</div>