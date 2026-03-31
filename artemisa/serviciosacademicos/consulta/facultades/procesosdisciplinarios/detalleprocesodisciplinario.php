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
function recuperartipodocumentomodificar($tipodocumento,$objetobase,$iddetalleprocesodisciplinario){
$condicion= " and dp.codigoestado like '1%'
			  and p.codigoestado like '1%'
			  and dp.idprocesodisciplinario=p.idprocesodisciplinario
			   and dp.idtipodocumentofisicodetalleprocesodisciplinario=tf.idtipodocumentofisicodetalleprocesodisciplinario
			  group by codigoestudiante";
$resultado2=$objetobase->recuperar_datos_tabla("detalleprocesodisciplinario dp, procesodisciplinario p, tipodocumentofisicodetalleprocesodisciplinario tf","dp.iddetalleprocesodisciplinario",$iddetalleprocesodisciplinario,$condicion,'',0);
$nombreextension = explode(".",$resultado['nombrearchivo']);
for($i=0;$i<(count($nombreextension)-1);$i++)
$nuevonombre.=$nombreextension[$i];
if(!isset($nuevonombre)||$nuevonombre=='')
$nuevonombre="1";
/*else
	if(!$modificar)
		$nuevonombre++;*/
//$tipodocumento=
$documento['tipodocumento']=$resultado2['nombretipodocumentofisicodetalleprocesodisciplinario'];
$documento['nuevonombre']=$nuevonombre;
$documento['nombrearchivo']=$resultado2['nombrearchivodocumentofisicodetalleprocesodisciplinario'];
//echo "<br>";
//imprimir $contenidos
//echo $nuevonombre;
return $documento;
}
function eliminararchivo($documento,$objetobase,$codigoestudiante){
			$servidor_ftp="172.16.7.111";
			$ftp_nombre_usuario="antecedentes";
			$ftp_contrasenya="antecedentes";
			// configurar la conexion basica
			//echo "Entro al ftp 1";
			$id_con = ftp_connect($servidor_ftp);
			//echo "Entro al ftp 2"; 
			// iniciar sesion con nombre de usuario y contrasenya
			$resultado_login = ftp_login($id_con, $ftp_nombre_usuario, $ftp_contrasenya);

				$archivoborrar="./".$codigoestudiante."/".cambiarespacio($documento['tipodocumento'])."/".$documento['nombrearchivo'];
				//echo "<br>";
				ftp_delete($id_con,$archivoborrar);
			ftp_close($id_con);


}
function recuperarnombretipodocumento($tipodocumento,$objetobase,$codigoestudiante,$modificar=0)
{
$condicion= " and dp.codigoestado like '1%'
			  and p.codigoestado like '1%'
			  and dp.idprocesodisciplinario=p.idprocesodisciplinario
			   and dp.idtipodocumentofisicodetalleprocesodisciplinario=tf.idtipodocumentofisicodetalleprocesodisciplinario
			   and dp.idtipodocumentofisicodetalleprocesodisciplinario=".$tipodocumento.
			 " and p.codigoestudiante=".$codigoestudiante.
			 " group by codigoestudiante";
$resultado=$objetobase->recuperar_datos_tabla("detalleprocesodisciplinario dp, procesodisciplinario p, tipodocumentofisicodetalleprocesodisciplinario tf","p.codigoestudiante",$codigoestudiante,$condicion,', max(dp.nombrearchivodocumentofisicodetalleprocesodisciplinario) nombrearchivo',0);
$nombreextension = explode(".",$resultado['nombrearchivo']);
for($i=0;$i<(count($nombreextension)-1);$i++)
$nuevonombre.=$nombreextension[$i];
if(!isset($nuevonombre)||$nuevonombre=='')
$nuevonombre="1";
else
	if(!$modificar)
		$nuevonombre++;
//$tipodocumento=
$documento2['tipodocumento']=$resultado['nombretipodocumentofisicodetalleprocesodisciplinario'];
$documento2['nuevonombre']=$nuevonombre;
$documento2['nombrearchivo']=$resultado['nombrearchivodocumentofisicodetalleprocesodisciplinario'];
//echo "<br>";
//imprimir $contenidos
//echo $nuevonombre;
return $documento2;
}
function enviaradjunto($objetobase,$archivo,$archivo_name,$archivo_size,$documento,$nombretipoarchivo,$codigoestudiante,$nombredocumento1=""){
//echo $documento['nombrearchivo'];
//echo "<br>";
//echo $documento['tipodocumento'];
$nombrearchivo=$documento['nuevonombre'];
		
			$extension = explode(".",$archivo_name);
			$num = count($extension)-1;
			switch($extension[$num]){
			case "pdf":
				$extensioncorrecta=1;
				$ext="pdf";
				break;
			case "jpg":
				$extensioncorrecta=1;
				$ext="jpg";
				break;
			case "JPG":
				$extensioncorrecta=1;
				$ext="jpg";
				break;
			default :
				$extensioncorrecta=0;
				break;
			}
			//$archivolocal="/tmp/".cambiarespacio($archivo_name);

			if($extensioncorrecta)
			{
				if($archivo_size < 200000)
				{
			
			if($nombredocumento1!="")
				eliminararchivo($nombredocumento1,$objetobase,$codigoestudiante);

			//$archivoremoto=$archivo_name;
			//$archivolocal
			$datosubicacion=$objetobase->recuperar_datos_tabla("ubicaciondocumentofisicodetalleprocesodisciplinario","idubicaciondocumentofisicodetalleprocesodisciplinario",2,'','',0);
			$raiz = $datosubicacion['ubicaciondocumentofisicodetalleprocesodisciplinario'];
			//"/var/documentosestudiantes/procesosdisciplinarios";
			$servidor_ftp="172.16.7.111";
			$ftp_nombre_usuario="antecedentes";
			$ftp_contrasenya="antecedentes";
			
			$directorio=opendir($raiz);
			
				$creardirectorio=0;
				$creardirectorio2=0;
			  while ($contenidos = readdir($directorio)) {
				$tmpcontenido=$contenidos;
				//echo "<br>if($tmpcontenido==$codigoestudiante){";
				if($tmpcontenido==$codigoestudiante){
				$creardirectorio=1;
					$directorio2=opendir($raiz."/".$codigoestudiante);
					while($contenidos2 = readdir($directorio2)){
						$tmpcontenido2=$contenidos2;
						//$tmpcontenido2=$contenidos2[$j];
						//echo "<br>if($tmpcontenido2==$nombretipoarchivo){";
						if($tmpcontenido2==cambiarespacio($nombretipoarchivo)){
							$creardirectorio2=1;
						}
					}
					closedir($directorio2);

				}
			}
			closedir($directorio);

			if(!$creardirectorio)
				mkdir($raiz."/".$codigoestudiante);
			if(!$creardirectorio2)
				mkdir($raiz."/".$codigoestudiante."/".cambiarespacio($nombretipoarchivo));

			$archivoremoto=$raiz."/".$codigoestudiante."/".cambiarespacio($nombretipoarchivo)."/".$nombrearchivo.".".$ext;
			
			if(!copy($archivo,$archivoremoto))
			{
						alerta_javascript("error al copiar el archivo");
			}

			/*if (ftp_put($id_con,$archivoremoto,$archivolocal,FTP_BINARY)) {
			 alerta_javascript("el archivo se ha cargado satisfactoriamente");
			} else {
			 alerta_javascript("Hubo un problema durante la transferencia de $archivo");
			}

			//var_dump($contenidos);*/
			
			$procesoarchivo['nombre']=$nombrearchivo.".".$ext;
			$procesoarchivo['url']=$raiz."/".$codigoestudiante."/".cambiarespacio($nombretipoarchivo)."/".$nombrearchivo.".".$ext;
			//unlink($archivolocal);
			return $procesoarchivo;
			
				}
				else
				{
					alerta_javascript("el archivo supera los 200 Kb");
				}

			}
			else
			{
				alerta_javascript("el formato de archivo no es valido ".$archivo_name);
				//print_r($extension);
			}
return false;

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
	location.href="<?php echo 'procesodisciplinario.php?idprocesodisciplinario='.$_GET['idprocesodisciplinario'] ;?>";
}
//quitarFrame()
</script>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
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

		$formulario->agregar_tablas('estudiantegeneral','idestudiantegeneral');
		$formulario->cargar('idestudiantegeneral',$_GET['idestudiantegeneral']);

$usuario=$formulario->datos_usuario();
$ip=$formulario->GetIP();
$idmenuboton=59;
/*$condicion=" and u.usuario=ur.usuario 
			and ur.idrol=p.idrol".
		   " and p.idmenuboton=".$idmenuboton;*/
$condicion=" and ut.UsuarioId=u.idusuario
            and ur.idusuariotipo = ut.CodigoTipoUsuario
			and ur.idrol=p.idrol".
		   " and p.idmenuboton=".$idmenuboton;

if($datosrolusuario=$objetobase->recuperar_datos_tabla("usuario u, usuariorol ur, permisorolboton p, UsuarioTipo ut","u.idusuario",$usuario['idusuario'],$condicion,'',0)){

//echo "LINK_ORIGEN=".$_GET['link_origen'];

?>
<form name="form1" action="detalleprocesodisciplinario.php?idprocesodisciplinario=<?php echo $_GET['idprocesodisciplinario'] ?>" method="POST" enctype="multipart/form-data">
<input type="hidden" name="AnularOK" value="">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
	<?php 
		//$formulario->dibujar_fila_titulo('APORTES SEGURIDAD SOCIAL EPS ARP','labelresaltado',"2","align='center'");
		//print_r($formulario->array_datos_cargados['estudiantegeneral']);
		$datosdocumento = $formulario->recuperar_datos_tabla('documento','tipodocumento',$formulario->array_datos_cargados['estudiantegeneral']->tipodocumento);

if(isset($_GET['idprocesodisciplinario']))
	if($datosprocesodisciplinario=$objetobase->recuperar_datos_tabla("procesodisciplinario","idprocesodisciplinario",$_GET['idprocesodisciplinario'],' and codigoestado like \'1%\'','',0)){
	$codigoestudiante=$datosprocesodisciplinario['codigoestudiante'];
	$estudiante= $formulario->array_datos_cargados['estudiantegeneral']->apellidosestudiantegeneral.' '.$formulario->array_datos_cargados['estudiantegeneral']->nombresestudiantegeneral.' con '.$datosdocumento['nombredocumento'].' '.$formulario->array_datos_cargados['estudiantegeneral']->numerodocumento;
		$formulario->dibujar_fila_titulo('Detalle proceso Disciplinario de '.$estudiante,'labelresaltado');
		if(isset($_GET['iddetalleprocesodisciplinario']))
			if($datos=$objetobase->recuperar_datos_tabla("detalleprocesodisciplinario","iddetalleprocesodisciplinario",$_GET['iddetalleprocesodisciplinario'],' and codigoestado like \'1%\'','',0))
			{
				$idtipodetalleprocesodisciplinario=$datos['idtipodetalleprocesodisciplinario'];
				$descripciondetalleprocesodisciplinario=$datos['descripciondetalleprocesodisciplinario'];
				$fechadetalleprocesodisciplinario=formato_fecha_defecto($datos['fechadetalleprocesodisciplinario']);
				$rutaarchivodocumento=$datos['rutaarchivodocumentofisicodetalleprocesodisciplinario'];
				$descripciondocumentofisicodetalleprocesodisciplinario=$datos['descripciondocumentofisicodetalleprocesodisciplinario'];
				$idtipodocumentofisicodetalleprocesodisciplinario=$datos['idtipodocumentofisicodetalleprocesodisciplinario'];
				$nombrearchivodocumentofisico=$datos['nombrearchivodocumentofisicodetalleprocesodisciplinario'];
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
		$condicion=" codigoestado like '1%'";
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("tipodetalleprocesodisciplinario","idtipodetalleprocesodisciplinario","nombretipodetalleprocesodisciplinario",$condicion,"",0,0);
		$campo='menu_fila'; $parametros="'idtipodetalleprocesodisciplinario','".$idtipodetalleprocesodisciplinario."',''";
		$formulario->dibujar_campo($campo,$parametros,"Tipo del Detalle","tdtitulogris",'codigoperiodo','');
		$campo="memo"; $parametros="'descripciondetalleprocesodisciplinario','descripciondetalleprocesodisciplinario',70,5,'','','',''";
		$formulario->dibujar_campo($campo,$parametros,"Descripción de Detalle del Proceso","tdtitulogris",'descripciondetalleprocesodisciplinario');
		$formulario->cambiar_valor_campo('descripciondetalleprocesodisciplinario',$descripciondetalleprocesodisciplinario);
        $campo="campo_fecha"; $parametros="'text','fechadetalleprocesodisciplinario','".$fechadetalleprocesodisciplinario."','onKeyUp = \"this.value=formateafecha(this.value);\" '";
		$formulario->dibujar_campo($campo,$parametros,"Fecha del Detalle","tdtitulogris",'fechadetalleprocesodisciplinario','requerido');
		
		if(isset($rutaarchivodocumento)&&$rutaarchivodocumento!=''){
			$vcampo[0]="boton_tipo"; $vparametros[0]="'file','archivo','".$archivo."',''";
			//$rutaarchivodocumento="ftp://antecedentes:antecedentes@172.16.7.111/20666/Acta_de_descargos/6.jpg";
			$vparametros[1]="'archivoadjunto.php?iddetalleprocesodisciplinario=".$_GET['iddetalleprocesodisciplinario']."&nombrearchivo=".$nombrearchivodocumentofisico."','Visualizar',700,600";
			$vcampo[1]='boton_link_emergente';
			$formulario->dibujar_campos($vcampo,$vparametros,"Archivo Adjunto","tdtitulogris",'archivo','');
			//boton_link_emergente($url,$nombrelink,$ancho,$alto,$menubar="no",$javascript="");
		}
		else{
			$campo="boton_tipo"; $parametros="'file','archivo','".$archivo."',''";
			$formulario->dibujar_campo($campo,$parametros,"Archivo Adjunto","tdtitulogris",'archivo','');
		}
		
		$campo="memo"; $parametros="'descripciondocumentofisicodetalleprocesodisciplinario','descripciondocumentofisicodetalleprocesodisciplinario',70,5,'','','',''";
		$formulario->dibujar_campo($campo,$parametros,"Descripción del Documento Adjunto","tdtitulogris",'descripciondocumentofisicodetalleprocesodisciplinario');
		$formulario->cambiar_valor_campo('descripciondocumentofisicodetalleprocesodisciplinario',$descripciondocumentofisicodetalleprocesodisciplinario);
		$condicion=" codigoestado like '1%'";
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("tipodocumentofisicodetalleprocesodisciplinario","idtipodocumentofisicodetalleprocesodisciplinario","nombretipodocumentofisicodetalleprocesodisciplinario",$condicion,"",0,0);
		$campo='menu_fila'; $parametros="'idtipodocumentofisicodetalleprocesodisciplinario','".$idtipodocumentofisicodetalleprocesodisciplinario."',''";
		$formulario->dibujar_campo($campo,$parametros,"Tipo del Documento","tdtitulogris",'codigoperiodo','');

		$conboton=0;
		if(isset($_GET['iddetalleprocesodisciplinario']))
		{
					$parametrobotonenviar[$conboton]="'submit','Modificar','Modificar'";
					$boton[$conboton]='boton_tipo';
					$conboton++;
					$parametrobotonenviar[$conboton]="'submit','Anular','Anular'";
					$boton[$conboton]='boton_tipo';
					$conboton++;
					$parametrobotonenviar[$conboton]="'submit','Nuevo','Nuevo'";
					$boton[$conboton]='boton_tipo';
					$conboton++;
					$formulario->boton_tipo('hidden','iddetalleprocesodisciplinario',$_GET['iddetalleprocesodisciplinario']);
		}
		else
		{
					$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar'";
					$boton[$conboton]='boton_tipo';
					$conboton++;
		}

						
						$parametrobotonenviar[$conboton]="'Listado','listadodetalleprocesodisciplinario.php','idprocesodisciplinario=".$_GET['idprocesodisciplinario']."&link_origen=".$_GET['link_origen']."',700,600,5,50,'yes','yes','no','yes','yes'";
						$boton[$conboton]='boton_ventana_emergente';
						$conboton++;
						$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
						$boton[$conboton]='boton_tipo';
						$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');


	if(isset($_REQUEST['Enviar'])){
			if($formulario->valida_formulario()){
				$tabla="detalleprocesodisciplinario";
				$condicionactualiza="";
				$fila['idprocesodisciplinario']=$_GET['idprocesodisciplinario'];
				$fila['idtipodetalleprocesodisciplinario']=$_POST['idtipodetalleprocesodisciplinario'];
				if(isset($usuario['idusuario'])&&$usuario['idusuario']!='')
				$fila['idusuarioregistrodetalleprocesodisciplinario']=$usuario['idusuario'];
				else 
				$fila['idusuarioregistrodetalleprocesodisciplinario']=1;
				
				$fila['descripciondetalleprocesodisciplinario']=$_POST['descripciondetalleprocesodisciplinario'];
				$fila['fechadetalleprocesodisciplinario']=formato_fecha_mysql($_POST['fechadetalleprocesodisciplinario']);
				$fila['direccionipregistrodetalleprocesodisciplinario']=$ip;

				$fila['idtipodocumentofisicodetalleprocesodisciplinario']=$_POST['idtipodocumentofisicodetalleprocesodisciplinario'];
				
				$resultado=$objetobase->recuperar_datos_tabla("tipodocumentofisicodetalleprocesodisciplinario","idtipodocumentofisicodetalleprocesodisciplinario",$fila['idtipodocumentofisicodetalleprocesodisciplinario'],'','',0);
				$nombredocumento=recuperarnombretipodocumento($fila['idtipodocumentofisicodetalleprocesodisciplinario'],$objetobase,$codigoestudiante);
				if($fila['idtipodocumentofisicodetalleprocesodisciplinario']!=1){
					if($procesoarchivo=enviaradjunto($objetobase,$archivo,$archivo_name,$archivo_size,$nombredocumento,$resultado['nombretipodocumentofisicodetalleprocesodisciplinario'],$codigoestudiante))
					{
						$fila['nombrearchivodocumentofisicodetalleprocesodisciplinario']=$procesoarchivo['nombre'];
						$fila['rutaarchivodocumentofisicodetalleprocesodisciplinario']=$procesoarchivo['url'];
					}
				}
				else
				{
						echo "Entro";
						$fila['nombrearchivodocumentofisicodetalleprocesodisciplinario']="";
						$fila['rutaarchivodocumentofisicodetalleprocesodisciplinario']="";
				}
				$fila['descripciondocumentofisicodetalleprocesodisciplinario']=$_POST['descripciondocumentofisicodetalleprocesodisciplinario'];
				if($fila['idtipodocumentofisicodetalleprocesodisciplinario']!=1)
					$fila['idubicaciondocumentofisicodetalleprocesodisciplinario']=2;
				else
					$fila['idubicaciondocumentofisicodetalleprocesodisciplinario']=1;
				$fila['codigoestado']=100;
					$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);

			}

		//echo "<META HTTP-EQUIV='Refresh' CONTENT='0'>";

	}
	if(isset($_REQUEST['Modificar'])){
			$tabla="detalleprocesodisciplinario";
			$nombreidtabla="iddetalleprocesodisciplinario";
			$idtabla=$_POST['iddetalleprocesodisciplinario'];
		
			$fila['idprocesodisciplinario']=$_GET['idprocesodisciplinario'];
			$fila['idtipodetalleprocesodisciplinario']=$_POST['idtipodetalleprocesodisciplinario'];
			if(isset($usuario['idusuario'])&&$usuario['idusuario']!='')
				$fila['idusuarioregistrodetalleprocesodisciplinario']=$usuario['idusuario'];
			else 
				$fila['idusuarioregistrodetalleprocesodisciplinario']=1;
			$fila['descripciondetalleprocesodisciplinario']=$_POST['descripciondetalleprocesodisciplinario'];
			$fila['fechadetalleprocesodisciplinario']=formato_fecha_mysql($_POST['fechadetalleprocesodisciplinario']);
			$fila['direccionipregistrodetalleprocesodisciplinario']=$ip;
			$fila['idtipodocumentofisicodetalleprocesodisciplinario']=$_POST['idtipodocumentofisicodetalleprocesodisciplinario'];
			$resultado=$objetobase->recuperar_datos_tabla("tipodocumentofisicodetalleprocesodisciplinario","idtipodocumentofisicodetalleprocesodisciplinario",$fila['idtipodocumentofisicodetalleprocesodisciplinario'],'','',0);
			$nombredocumento1=recuperartipodocumentomodificar($fila['idtipodocumentofisicodetalleprocesodisciplinario'],$objetobase,$idtabla,1);
			$nombredocumento2=recuperarnombretipodocumento($fila['idtipodocumentofisicodetalleprocesodisciplinario'],$objetobase,$codigoestudiante,0);
			
			if($fila['idtipodocumentofisicodetalleprocesodisciplinario']!=1){
			if($procesoarchivo=enviaradjunto($objetobase,$archivo,$archivo_name,$archivo_size,$nombredocumento2,$resultado['nombretipodocumentofisicodetalleprocesodisciplinario'],$codigoestudiante,$nombredocumento1))
			{
					$fila['nombrearchivodocumentofisicodetalleprocesodisciplinario']=$procesoarchivo['nombre'];
					$fila['rutaarchivodocumentofisicodetalleprocesodisciplinario']=$procesoarchivo['url'];
			}
			}
			else{
					$fila['nombrearchivodocumentofisicodetalleprocesodisciplinario']="";
					$fila['rutaarchivodocumentofisicodetalleprocesodisciplinario']="";
			}
			
					$fila['descripciondocumentofisicodetalleprocesodisciplinario']=$_POST['descripciondocumentofisicodetalleprocesodisciplinario'];
					if($fila['idtipodocumentofisicodetalleprocesodisciplinario']!=1)
						$fila['idubicaciondocumentofisicodetalleprocesodisciplinario']=2;
					else
						$fila['idubicaciondocumentofisicodetalleprocesodisciplinario']=1;
					$fila['codigoestado']=100;
			$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla);

			echo "<META HTTP-EQUIV='Refresh' CONTENT='0' target='_parent'>";
	}
	if(isset($_REQUEST['Anular'])){
	$tabla="detalleprocesodisciplinario";
	$nombreidtabla="iddetalleprocesodisciplinario";
	$idtabla=$_POST['iddetalleprocesodisciplinario'];
	$fila['codigoestado']=200;
	$nombredocumento1=recuperartipodocumentomodificar($_POST['idtipodocumentofisicodetalleprocesodisciplinario'],$objetobase,$idtabla,1);
	eliminararchivo($nombredocumento1,$objetobase,$codigoestudiante);
	$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla);
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0'>";
	}
	if(isset($_REQUEST['Nuevo'])){
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0'>";
	}

}
}
else
{
 alerta_javascript("No puede ingresar a esta herramienta, verifique el estado de su sesion");
}

?>

	
  </table>
</form>