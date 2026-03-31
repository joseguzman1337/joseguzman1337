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
//require_once("funciones/FuncionesAportes.php");
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
	document.location.href="<?php echo '../../prematricula/matriculaautomaticaordenmatricula.php';?>";
}
function nuevo(pagina)
{
	//history.back();
	document.location.href=pagina;
}
//quitarFrame()
</script>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script type="text/javascript" src="../../../funciones/sala_genericas/funciones_javascript.js"></script>
<style type="text/css">
@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);
.Estilo2 {
	color: #FF9E08;
}
</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
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
//$formulario->agregar_tablas('estudiante','codigoestudiante');
$idmenuboton=59;
$usuario=$formulario->datos_usuario();
//print_r($usuario);
//echo "<br>";
/*$condicion=" and u.usuario=ur.usuario 
			and ur.idrol=p.idrol".
		   " and p.idmenuboton=".$idmenuboton;*/
$condicion=" and ut.UsuarioId=u.idusuario
            and ur.idusuariotipo = ut.UsuarioTipoId
			and ur.idrol=p.idrol
            and p.idmenuboton=".$idmenuboton;
if($datosrolusuario=$objetobase->recuperar_datos_tabla("usuario u, usuariorol ur, permisorolboton p, UsuarioTipo ut","u.idusuario",$usuario['idusuario'],$condicion,'',0))
{
$condicion="";
$ip=$formulario->GetIP();    
		$datosestudiante=$objetobase->recuperar_datos_tabla("estudiante e, estudiantegeneral eg","e.codigoestudiante",$_GET['codigoestudiante'],$condicion,', e.idestudiantegeneral numeroestudiantegeneral',0);
		$idestudiantegeneral=$datosestudiante['numeroestudiantegeneral'];
		$codigoestudiante=$datosestudiante['codigoestudiante'];
		if(isset($_GET['idprocesodisciplinario']))
		if($datos=$objetobase->recuperar_datos_tabla("procesodisciplinario","idprocesodisciplinario",$_GET['idprocesodisciplinario'],' and codigoestado like \'1%\'','',0)){
		$fechaaperturaprocesodisciplinario=formato_fecha_defecto($datos['fechaaperturaprocesodisciplinario']);
		$fechanotificacionaperturaprocesodisciplinario=fecha_vacia(formato_fecha_defecto($datos['fechanotificacionaperturaprocesodisciplinario']));
		$fechanotificacionsancionprocesodisciplinario=fecha_vacia(formato_fecha_defecto($datos['fechanotificacionsancionprocesodisciplinario']));
		$fechacierreprocesodisciplinario=fecha_vacia(formato_fecha_defecto($datos['fechacierreprocesodisciplinario']));
		$descripcionprocesoadministrativo=quitarsaltolinea($datos['descripcionprocesoadmnistrativoprocesodisciplinario']);
		$numeroactoadministrativo=$datos['numeroactoadministrativoprocesodisciplinario'];
		$fechaactoadministrativo=fecha_vacia(formato_fecha_defecto($datos['fechaactoadministrativoprocesodisciplinario']));
		$iddirectivo=$datos['iddirectivoresponsablesancionprocesodisciplinario'];
		$idtipofaltaprocesodisciplinario=$datos['idtipofaltaprocesodisciplinario'];
		$idtiposancionprocesodisciplinario=$datos['idtiposancionprocesodisciplinario'];
		$codigoestadoprocesodisciplinario=$datos['codigoestadoprocesodisciplinario'];
		$codigoestudiante=$datos['codigoestudiante'];
		$idestudiantegeneral=$datos['idestudiantegeneral'];
	  	$fechainicio=date("d/m/Y");
		//alerta_javascript("Entro el mugroso ");
 		}		
		else{
		$idnovedadarp=$_POST['idnovedadarp'];
		$fechaingreso=date("d/m/Y");
		$fechafinal="01/01/2099";
		$fechaingreso=date("d/m/Y");
		if(isset($_POST['fechainicio']))
		$fechainicio=$_POST['fechainicio'];
		else
		$fechainicio=date("d/m/Y");
		}
		$idprocesodisciplinario=$datos['idprocesodisciplinario'];

		$_GET['codigoestudiante']=$codigoestudiante;
		$formulario->agregar_tablas('estudiantegeneral','idestudiantegeneral');
		$formulario->cargar('idestudiantegeneral',$idestudiantegeneral);
?>
<form name="form1" action="procesodisciplinario.php?codigoestudiante=<?php echo $codigoestudiante ?>" method="POST" >
  <p>
    <input name="AnularOK" type="hidden" class="name " value="">
  </p>
  <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
  	<tr>
	<td colspan="2">
	<?php 	
	$formulario->dibujar_tabla_informacion_estudiante(puntos(3),"#003333","Estilo3","Estilo4","#CCCCCC");
	?>	</td>
	</tr>
	<?php 
		//$formulario->dibujar_fila_titulo('APORTES SEGURIDAD SOCIAL EPS ARP','labelresaltado',"2","align='center'");
		$formulario->dibujar_fila_titulo('Proceso Disciplinario','labelresaltado');
        $campo="campo_fecha"; $parametros="'text','fechaaperturaprocesodisciplinario','".$fechaaperturaprocesodisciplinario."','onKeyUp = \"this.value=formateafecha(this.value);\" '";
	    $formulario->dibujar_campo($campo,$parametros,"Fecha de Apertura de Proceso","tdtitulogris",'fechaaperturaprocesodisciplinario','requerido');
        $campo="campo_fecha"; $parametros="'text','fechanotificacionaperturaprocesodisciplinario','".$fechanotificacionaperturaprocesodisciplinario."','onKeyUp = \"this.value=formateafecha(this.value);\" '";
	    $formulario->dibujar_campo($campo,$parametros,"Fecha de Notificación","tdtitulogris",'fechanotificacionaperturaprocesodisciplinario','');
        $campo="campo_fecha"; $parametros="'text','fechanotificacionsancionprocesodisciplinario','".$fechanotificacionsancionprocesodisciplinario."','onKeyUp = \"this.value=formateafecha(this.value);\" '";
	    $formulario->dibujar_campo($campo,$parametros,"Fecha de Notificación de Sanción","tdtitulogris",'echanotificacionsancionprocesodisciplinario','');
        $campo="campo_fecha"; $parametros="'text','fechacierreprocesodisciplinario','".$fechacierreprocesodisciplinario."','onKeyUp = \"this.value=formateafecha(this.value);\" '";
	    $formulario->dibujar_campo($campo,$parametros,"Fecha de Cierre","tdtitulogris",'fechacierreprocesodisciplinario','');
		$campo="memo"; $parametros="'descripcionprocesoadministrativo','descripcionprocesoadministrativo',70,8,'','','',''";
		$formulario->dibujar_campo($campo,$parametros,"Descripción de Proceso Administrativo","tdtitulogris",'descripcionprocesoadministrativo');
		$formulario->cambiar_valor_campo('descripcionprocesoadministrativo',$descripcionprocesoadministrativo);
		$campo="boton_tipo"; $parametros="'number','numeroactoadministrativo','".$numeroactoadministrativo."',''";
		$formulario->dibujar_campo($campo,$parametros,"Numero de Acta","tdtitulogris",'numeroactoadministrativo','requerido');
        $campo="campo_fecha"; $parametros="'text','fechaactoadministrativo','".$fechaactoadministrativo."','onKeyUp = \"this.value=formateafecha(this.value);\" '";
	    $formulario->dibujar_campo($campo,$parametros,"Fecha de Acta","tdtitulogris",'fechaactoadministrativo','');
		$condicion="codigotipodirectivo=100
					and '".$fechahoy."' between fechainiciodirectivo and fechavencimientodirectivo
					group by nombrecompleto
					order by nombrecompleto	";
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("directivo","iddirectivo","CONCAT(nombresdirectivo,' ',apellidosdirectivo,' ',cargodirectivo) nombrecompleto",$condicion,"",0,0);
		$formulario->filatmp[""]="Seleccionar";
		$campo='menu_fila'; $parametros="'iddirectivo','".$iddirectivo."',''";
		$formulario->dibujar_campo($campo,$parametros,"Directivo","tdtitulogris",'codigoperiodo','');
		$condicion=" codigoestado like '1%'";
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("tipofaltaprocesodisciplinario","idtipofaltaprocesodisciplinario","nombretipofaltaprocesodisciplinario",$condicion,"",0,0);
		$campo='menu_fila'; $parametros="'idtipofaltaprocesodisciplinario','".$idtipofaltaprocesodisciplinario."',''";
		$formulario->dibujar_campo($campo,$parametros,"Tipo de falta","tdtitulogris",'codigoperiodo','');

		$condicion=" codigoestado like '1%'";
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("tiposancionprocesodisciplinario","idtiposancionprocesodisciplinario","nombretiposancionprocesodisciplinario",$condicion,"",0,0);
		$campo='menu_fila'; $parametros="'idtiposancionprocesodisciplinario','".$idtiposancionprocesodisciplinario."',''";
		$formulario->dibujar_campo($campo,$parametros,"Tipo de sanción","tdtitulogris",'codigoperiodo','');

		$condicion=" codigoestado like '1%'";
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("estadoprocesodisciplinario","codigoestadoprocesodisciplinario","nombreestadoprocesodisciplinario",$condicion,"",0,0);
		$campo='menu_fila'; $parametros="'codigoestadoprocesodisciplinario','".$codigoestadoprocesodisciplinario."',' class=Estilo2'";
		$formulario->dibujar_campo($campo,$parametros,"Estado del proceso","tdtitulogris",'codigoperiodo','');
		

		$conboton=0;
		$formulario->boton_tipo('hidden','idestudiantegeneral',$idestudiantegeneral);
		$formulario->boton_tipo('hidden','codigoestudiante',$codigoestudiante);

		if(isset($idprocesodisciplinario)&&$idprocesodisciplinario!=''){
		//echo "PROCESODISCPLINARIO=".$idprocesodisciplinario;
				$parametros="'detalleprocesodisciplinario.php?idprocesodisciplinario=".$idprocesodisciplinario."&idestudiantegeneral=".$idestudiantegeneral."','Detalle',700,600,'no','',0";
								//$url,$nombrelink,$ancho,$alto,$menubar="no",$javascript="",$activafuncion=1
				$campo='boton_link_emergente';
				$formulario->dibujar_campo($campo,$parametros,"Detalle del proceso","tdtitulogris",'codigoperiodo','',0);
											//$tipo,$parametros,$titulo,$estilo_titulo,$idtitulo,$tipo_titulo="",$imprimir=0
					$parametrobotonenviar[$conboton]="'submit','Modificar','Modificar'";
					$boton[$conboton]='boton_tipo';
					$conboton++;
					$parametrobotonenviar[$conboton]="'submit','Anular','Anular'";
					$boton[$conboton]='boton_tipo';
					$conboton++;
					$parametrobotonenviar[$conboton]="'submit','Nuevo','Nuevo'";
					$boton[$conboton]='boton_tipo';
					$conboton++;

					$formulario->boton_tipo('hidden','idprocesodisciplinario',$idprocesodisciplinario);

					}
		else{
							$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar'";
							$boton[$conboton]='boton_tipo';
						
		
				$conboton++;					

		}

						//$parametrobotonenviar[$conboton]="'Listado','listadoprocesodisciplinario.php','idestudiantegeneral=".$idestudiantegeneral."',700,300,300,150,'yes','yes','yes','yes','yes'";
						$parametrobotonenviar[$conboton]="'Listado','listadoprocesodisciplinario.php','idestudiantegeneral=".$idestudiantegeneral."',700,600,5,50,'yes','yes','no','yes','yes'";
						$boton[$conboton]='boton_ventana_emergente';
						$conboton++;
						$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
						$boton[$conboton]='boton_tipo';
						$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');
		
	if(isset($_REQUEST['Enviar'])){
		if($formulario->valida_formulario()){
			$tabla="procesodisciplinario";
			$fila['idestudiantegeneral']=$_POST['idestudiantegeneral'];
			$fila['codigoestudiante']=$_POST['codigoestudiante'];
			$fila['fecharegistroprocesodisciplinario']=$fechahoy;
			$fila['fechaaperturaprocesodisciplinario']=formato_fecha_mysql($_POST['fechaaperturaprocesodisciplinario']);
			$fila['fechanotificacionaperturaprocesodisciplinario']=formato_fecha_mysql($_POST['fechanotificacionaperturaprocesodisciplinario']);
			$fila['fechanotificacionsancionprocesodisciplinario']=formato_fecha_mysql($_POST['fechanotificacionsancionprocesodisciplinario']);
			$fila['fechacierreprocesodisciplinario']=formato_fecha_mysql($_POST['fechacierreprocesodisciplinario']);
			$fila['descripcionprocesoadmnistrativoprocesodisciplinario']=$_POST['descripcionprocesoadministrativo'];
			
			$fila['numeroactoadministrativoprocesodisciplinario']=$_POST['numeroactoadministrativo'];
			$fila['fechaactoadministrativoprocesodisciplinario']=formato_fecha_mysql($_POST['fechaactoadministrativo']);
			$fila['direccionipregistroprocesodisciplinario']=$ip;
			if(isset($usuario["idusuario"])&&$usuario["idusuario"]!='')
				$fila["idusuarioregistroprocesodisciplinario"]=$usuario["idusuario"];
			else
				$fila["idusuarioregistroprocesodisciplinario"]=1;
			$fila['codigoestadoprocesodisciplinario']=$_POST['codigoestadoprocesodisciplinario'];
			$fila['iddirectivoresponsablesancionprocesodisciplinario']=$_POST['iddirectivo'];
			$fila['idtipofaltaprocesodisciplinario']=$_POST['idtipofaltaprocesodisciplinario'];
			$fila['idtiposancionprocesodisciplinario']=$_POST['idtiposancionprocesodisciplinario'];
			$fila['codigoestado']=100;
			$condicionactualiza="idestudiantegeneral=".$fila['idestudiantegeneral'].
								" and fecharegistroprocesodisciplinario='".$fila['fecharegistroprocesodisciplinario'].
								"' and fechaaperturaprocesodisciplinario='".$fila['fechaaperturaprocesodisciplinario'].
								"' and numeroactoadministrativoprocesodisciplinario='".$fila['numeroactoadministrativoprocesodisciplinario']."'";
		$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0'>";
		}
	}
	if(isset($_REQUEST['Modificar'])){
		if($formulario->valida_formulario()){
			$tabla="procesodisciplinario";
			$nombreidtabla="idprocesodisciplinario";
			$idtabla=$_POST['idprocesodisciplinario'];
			$fila['idestudiantegeneral']=$_POST['idestudiantegeneral'];
			$fila['codigoestudiante']=$_POST['codigoestudiante'];
			$fila['fecharegistroprocesodisciplinario']=$fechahoy;
			$fila['fechaaperturaprocesodisciplinario']=formato_fecha_mysql($_POST['fechaaperturaprocesodisciplinario']);
			$fila['fechanotificacionaperturaprocesodisciplinario']=formato_fecha_mysql($_POST['fechanotificacionaperturaprocesodisciplinario']);
			$fila['fechanotificacionsancionprocesodisciplinario']=formato_fecha_mysql($_POST['fechanotificacionsancionprocesodisciplinario']);
			$fila['fechacierreprocesodisciplinario']=$_POST['fechacierreprocesodisciplinario'];
			$fila['descripcionprocesoadmnistrativoprocesodisciplinario']=$_POST['descripcionprocesoadministrativo'];
			
			$fila['numeroactoadministrativoprocesodisciplinario']=$_POST['numeroactoadministrativo'];
			$fila['fechaactoadministrativoprocesodisciplinario']=formato_fecha_mysql($_POST['fechaactoadministrativo']);
			$fila['direccionipregistroprocesodisciplinario']=$ip;
			if(isset($usuario["idusuario"])&&$usuario["idusuario"]!='')
				$fila["idusuarioregistroprocesodisciplinario"]=$usuario["idusuario"];
			else
				$fila["idusuarioregistroprocesodisciplinario"]=1;
			$fila['codigoestadoprocesodisciplinario']=$_POST['codigoestadoprocesodisciplinario'];
			$fila['iddirectivoresponsablesancionprocesodisciplinario']=$_POST['iddirectivo'];
			$fila['idtipofaltaprocesodisciplinario']=$_POST['idtipofaltaprocesodisciplinario'];
			$fila['idtiposancionprocesodisciplinario']=$_POST['idtiposancionprocesodisciplinario'];
			//$fila['codigoestado']=100;
			$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla);
			//echo "<META HTTP-EQUIV='Refresh' CONTENT='0'>";
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=procesodisciplinario.php?codigoestudiante=$codigoestudiante&idprocesodisciplinario=".$_POST['idprocesodisciplinario']."'>";
		}
	}
	if(isset($_REQUEST['Anular'])){
	$tabla="procesodisciplinario";
	$nombreidtabla="idprocesodisciplinario";
	$idtabla=$_POST['idprocesodisciplinario'];
	$fila['codigoestado']=200;
	$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla);
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0'>";
	}
	if(isset($_REQUEST['Nuevo'])){
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0'>";
	}
}
else
{
 alerta_javascript("No puede ingresar a esta herramienta, verifique el estado de su sesion");
}
?>

  </table>
</form>