<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
$rutaado=('../../../funciones/adodb/');
require_once('../../../Connections/salaado-pear.php');
require_once('../../../funciones/sala_genericas/FuncionesCadena.php');
require_once('../../../funciones/sala_genericas/FuncionesFecha.php');
require_once('../../../funciones/sala_genericas/FuncionesMatriz.php');
require_once('../../../funciones/sala_genericas/clasebasesdedatosgeneral.php');
require_once('../../../funciones/sala_genericas/DatosGenerales.php');
require_once('../../../funciones/clases/formulario/clase_formulario.php');
require_once('../../../funciones/sala_genericas/formulariobaseestudiante.php');
//require_once('../../../funciones/clases/autenticacion/redirect.php' ); 

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
function enviarmenu()
{
//form1.action="";
form1.submit();
}

//quitarFrame()
</script>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script type="text/javascript" src="../../../funciones/sala_genericas/funciones_javascript.js"></script>
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
$usuario=$formulario->datos_usuario();
$ip=$formulario->GetIP();
?>
<form name="form1" action="horarioprematricula.php" method="POST" >
    <input name="AnularOK" type="hidden" class="name " value="">
  <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
	<?php 
		$entroidprematricula=0;
		if(isset($_GET['idhorarioprematricula'])||isset($_POST['idhorarioprematricula'])){
		$entroidprematricula=1;
			if($datos=$objetobase->recuperar_datos_tabla("horarioprematricula h ","idhorarioprematricula",$_GET['idhorarioprematricula'],'','',0))
			{
				$datoscarrera=$objetobase->recuperar_datos_tabla("carrera","codigocarrera",$datos['codigocarrera'],'','',0);
				$codigomodalidadacademica=$datoscarrera['codigomodalidadacademica'];
				$idhorarioprematricula=$datos['idhorarioprematricula'];
				$codigocarrera=$datos['codigocarrera'];
				$idrol=$datos['idrol'];
				$codigotipopermisohorarioprematricula=$datos['codigotipopermisohorarioprematricula'];
				$codigoperiodo=$datos['codigoperiodo'];
			}
			else{
				$entroidprematricula=0;
			}

		}


		if(isset($_GET['iddetallehorarioprematricula'])||isset($_POST['iddetallehorarioprematricula'])){
		$entroidprematricula=1;
		$condicion="and d.codigoestado like '1%'
					and h.idhorarioprematricula=d.idhorarioprematricula";
			if($datos=$objetobase->recuperar_datos_tabla("horarioprematricula h ,detallehorarioprematricula d","iddetallehorarioprematricula",$_GET['iddetallehorarioprematricula'],$condicion,', h.idhorarioprematricula hidhorarioprematricula',0))
			{
				$datoscarrera=$objetobase->recuperar_datos_tabla("carrera","codigocarrera",$datos['codigocarrera'],'','',0);
				$codigomodalidadacademica=$datoscarrera['codigomodalidadacademica'];
				$idhorarioprematricula=$datos['hidhorarioprematricula'];

				$iddetallehorarioprematricula=$datos['iddetallehorarioprematricula'];
				$formulario->boton_tipo('hidden','iddetallehorarioprematricula',$iddetallehorarioprematricula);
				
				$codigocarrera=$datos['codigocarrera'];
				$idrol=$datos['idrol'];
				$codigotipopermisohorarioprematricula=$datos['codigotipopermisohorarioprematricula'];
				$codigoperiodo=$datos['codigoperiodo'];
				$fechainicio=formato_fecha_defecto($datos['fechainicialdetallehorarioprematricula']);
				$fechafinal=formato_fecha_defecto($datos['fechafinaldetallehorarioprematricula']);
				$horainicial=$datos['horainicialdetallehorarioprematricula'];
				$horafinal=$datos['horafinaldetallehorarioprematricula'];			
			}
			else{
				$entroidprematricula=0;
			}
		}
		
		if(!$entroidprematricula){
				$codigomodalidadacademica=$_POST['codigomodalidadacademica'];
				$codigocarrera=$_POST['codigocarrera'];
				$idrol=$_POST['idrol'];
				$codigotipopermisohorarioprematricula=$_POST['codigotipopermisohorarioprematricula'];
				$codigoperiodo=$_POST['codigoperiodo'];
				$fechainicio=$_POST['fechainicio'];
				$fechafinal=$_POST['fechafinal'];
				$horainicial=$_POST['horainicial'];
				$horafinal=$_POST['horafinal'];			
		}
				
		$formulario->boton_tipo('hidden','idhorarioprematricula',$idhorarioprematricula);

		//$formulario->dibujar_fila_titulo('APORTES SEGURIDAD SOCIAL EPS ARP','labelresaltado',"2","align='center'");
		$formulario->dibujar_fila_titulo('Horario Prematricula','labelresaltado');
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("modalidadacademica f","codigomodalidadacademica","nombremodalidadacademica","");
		$formulario->filatmp["todos"]="*Todos*";
		$formulario->filatmp[""]="Seleccionar";	
		$campo='menu_fila'; $parametros="'codigomodalidadacademica','".$codigomodalidadacademica."','onchange=enviarmenu();'";
		$formulario->dibujar_campo($campo,$parametros,"Modalidad Academica","tdtitulogris",'codigomodalidadacademica','');

		//$codigofacultad="05";
		$condicion="c.codigomodalidadacademica='".$codigomodalidadacademica."'
					and NOW() between fechainiciocarrera and fechavencimientocarrera
					order by c.nombrecarrera";
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c","codigocarrera","nombrecarrera",$condicion);
		$formulario->filatmp["todos"]="Todos";
		$formulario->filatmp[""]="Seleccionar";	
		$campo='menu_fila'; $parametros="'codigocarrera','".$codigocarrera."','onchange=enviarmenu();'";
		$formulario->dibujar_campo($campo,$parametros,"Carrera","tdtitulogris",'codigocarrera','');

		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("periodo","codigoperiodo","codigoperiodo","codigoperiodo=codigoperiodo order by codigoperiodo desc");
		$campo='menu_fila'; $parametros="'codigoperiodo','".$codigoperiodo."','onchange=enviarmenu();'";
		$formulario->dibujar_campo($campo,$parametros,"Periodo","tdtitulogris",'codigoperiodo','');

		
		$condicion=" idrol=idrol order by nombrerol";
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("rol r","idrol","nombrerol",$condicion);
		$formulario->filatmp[""]="Seleccionar";	
		$campo='menu_fila'; $parametros="'idrol','".$idrol."',''";
		$formulario->dibujar_campo($campo,$parametros,"Rol del usuario","tdtitulogris",'idrol','');

		$condicion="codigoestado like '1%'
		 			order by nombretipopermisohorarioprematricula";
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("tipopermisohorarioprematricula t","codigotipopermisohorarioprematricula","nombretipopermisohorarioprematricula",$condicion,'',0);
		$formulario->filatmp[""]="Seleccionar";	
		$campo='menu_fila'; $parametros="'codigotipopermisohorarioprematricula','".$codigotipopermisohorarioprematricula."','onchange=enviarmenu();'";
		$formulario->dibujar_campo($campo,$parametros,"Tipo de permiso","tdtitulogris",'codigotipopermisohorarioprematricula','');
		
		if(ereg("^2+",$codigotipopermisohorarioprematricula)){
			$campo="campo_fecha"; $parametros="'text','fechainicio','".$fechainicio."','onKeyUp = \"this.value=formateafecha(this.value);\" '";
			$formulario->dibujar_campo($campo,$parametros,"Fecha de Inicio","tdtitulogris",'fechainicio','');		

			$campo="campo_fecha"; $parametros="'text','fechafinal','".$fechafinal."','onKeyUp = \"this.value=formateafecha(this.value);\" '";
			$formulario->dibujar_campo($campo,$parametros,"Fecha Final","tdtitulogris",'fechafinal','');		
			$campo="boton_tipo"; $parametros="'text','horainicial','".$horainicial."',''";
			$formulario->dibujar_campo($campo,$parametros,"Hora Inicial","tdtitulogris",'horainicial','requerido');
			$campo="boton_tipo"; $parametros="'text','horafinal','".$horafinal."',''";
			$formulario->dibujar_campo($campo,$parametros,"Hora Final","tdtitulogris",'horafinal','requerido');
		}
		$conboton=0;
		if(isset($idhorarioprematricula)&&trim($idhorarioprematricula)!=''){
			$parametrobotonenviar[$conboton]="'submit','Modificar','Modificar'";
			$boton[$conboton]='boton_tipo';
			$conboton++;
			
			$parametrobotonenviar[$conboton]="'submit','Anular','Anular'";
			$boton[$conboton]='boton_tipo';
			$conboton++;

		}
		else{
			$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar'";
			$boton[$conboton]='boton_tipo';
			$conboton++;
		}
		
		
		$cadenaget="codigomodalidadacademicahpre=".$codigomodalidadacademica."&codigocarrerahpre=".$codigocarrera.
					"&codigoperiodohpre=".$codigoperiodo."&idrolhpre=".$idrol;					
		
		$parametrobotonenviar[$conboton]="'Listado','listadohorarioprematricula.php','".$cadenaget."',700,600,5,50,'yes','yes','no','yes','yes'";
		$boton[$conboton]='boton_ventana_emergente';
		$conboton++;
		$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
		$boton[$conboton]='boton_tipo';
		$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');



	if(isset($_REQUEST['Enviar'])){
		if($formulario->valida_formulario()){
			$tabla="horarioprematricula";
			$filahorario["codigoestado"]="100";
			$filahorario["codigoperiodo"]=$codigoperiodo;
			$filahorario["idrol"]=$idrol;
			$filahorario["codigotipopermisohorarioprematricula"]=$codigotipopermisohorarioprematricula;
			$filahorario["idusuario"]=$usuario["idusuario"];
			$filahorario["iphorarioprematricula"]=$ip;
			$filahorario["fechahorarioprematricula"]=$fechahoy;
			
			$filadetalle["fechadetallehorarioprematricula"]=$fechahoy;
			$filadetalle["fechainicialdetallehorarioprematricula"]=formato_fecha_mysql($fechainicio);
			$filadetalle["fechafinaldetallehorarioprematricula"]=formato_fecha_mysql($fechafinal);
			$filadetalle["horainicialdetallehorarioprematricula"]=$horainicial;
			$filadetalle["horafinaldetallehorarioprematricula"]=$horafinal;
			$filadetalle["codigoestado"]="100";
			//echo "$codigomodalidadacademica - $codigocarrera<pre>";
				//print_r($filadetalle);
			//echo "</pre>";
			
			$multiplescarreras=0;
			if($codigomodalidadacademica=="todos"){
				$operacion=$objetobase->recuperar_resultado_tabla("carrera","codigocarrera","codigocarrera","  and NOW() between fechainiciocarrera and fechavencimientocarrera","",0);
				$multiplescarreras=1;
			}
			else{
				if(trim($codigocarrera)=="todos"){
					$multiplescarreras=1;
					$operacion=$objetobase->recuperar_resultado_tabla("carrera","codigomodalidadacademica",$codigomodalidadacademica,"  and NOW() between fechainiciocarrera and fechavencimientocarrera ","",0);
				}
			}

			if($multiplescarreras)
				while($row_operacion=$operacion->fetchRow()){
					$filahorario["codigocarrera"]=$row_operacion['codigocarrera'];
					//$condicionactualiza="codigocarrera=";
					$tabla="horarioprematricula";
					$condicionactualiza=" 	  codigoestado=100
										  and codigoperiodo=".$filahorario["codigoperiodo"].
										" and idrol=".$filahorario["idrol"].
										" and codigocarrera=".$filahorario["codigocarrera"];
					//$condicionactualiza="";
					$objetobase->insertar_fila_bd($tabla,$filahorario,0,$condicionactualiza);
					if(ereg("^2+",$codigotipopermisohorarioprematricula))
					{
						$query="select idhorarioprematricula from horarioprematricula where $condicionactualiza";
						$operaciodetalle=$objetobase->conexion->query($query);
						$datoshorarioprematricula=$operaciodetalle->fetchRow();
						$tabla="detallehorarioprematricula";
						$filadetalle["idhorarioprematricula"]=$datoshorarioprematricula['idhorarioprematricula'];
						 $condicionactualiza=" idhorarioprematricula='".$filadetalle["idhorarioprematricula"]."'
											  and fechainicialdetallehorarioprematricula='".$filadetalle["fechainicialdetallehorarioprematricula"]."'".
											" and fechafinaldetallehorarioprematricula='".$filadetalle["fechafinaldetallehorarioprematricula"]."'".
											" and horainicialdetallehorarioprematricula='".$filadetalle["horainicialdetallehorarioprematricula"]."'
											 and horafinaldetallehorarioprematricula='".$filadetalle["horafinaldetallehorarioprematricula"]."'";
						$objetobase->insertar_fila_bd($tabla,$filadetalle,0,$condicionactualiza);
						//exit();
						//$datoshorarioprematricula=$objetobase->recuperar_datos_tabla("horarioprematricula","idhorarioprematricula",'idhorarioprematricula','','',0);
					}
				}
				else{
					$tabla="horarioprematricula";
					$filahorario["codigocarrera"]=$codigocarrera;
					$condicionactualiza=" codigoestado=100
										  and codigoperiodo=".$filahorario["codigoperiodo"].
										" and idrol=".$filahorario["idrol"].
										" and codigocarrera=".$filahorario["codigocarrera"];
					$objetobase->insertar_fila_bd($tabla,$filahorario,0,$condicionactualiza);
					if(ereg("^2+",$codigotipopermisohorarioprematricula))
					{
						$query="select idhorarioprematricula from horarioprematricula where $condicionactualiza";
						$operaciodetalle=$objetobase->conexion->query($query);
						$datoshorarioprematricula=$operaciodetalle->fetchRow();
						$tabla="detallehorarioprematricula";
						$filadetalle["idhorarioprematricula"]=$datoshorarioprematricula['idhorarioprematricula'];
						$condicionactualiza=" idhorarioprematricula='".$filadetalle["idhorarioprematricula"]."'
											  and fechainicialdetallehorarioprematricula='".$filadetalle["fechainicialdetallehorarioprematricula"]."'".
											" and fechafinaldetallehorarioprematricula='".$filadetalle["fechafinaldetallehorarioprematricula"]."'".
											" and horainicialdetallehorarioprematricula='".$filadetalle["horainicialdetallehorarioprematricula"]."'
											 and horafinaldetallehorarioprematricula='".$filadetalle["horafinaldetallehorarioprematricula"]."'";
						$objetobase->insertar_fila_bd($tabla,$filadetalle,0,$condicionactualiza);
					}

				}
				echo "<META HTTP-EQUIV='Refresh' CONTENT='0'>";

				
			//echo "<pre>";
				//print_r($filahorario);
			//echo "</pre>";

		}
	}
	
	if(isset($_REQUEST['Modificar'])){
		if($formulario->valida_formulario())
		{
				$tabla="horarioprematricula";
				$nombreidtabla="idhorarioprematricula";
				$idtabla=$idhorarioprematricula;
				$filahorario["codigoperiodo"]=$codigoperiodo;
				$filahorario["idrol"]=$idrol;
				$filahorario["codigotipopermisohorarioprematricula"]=$codigotipopermisohorarioprematricula;
				
				$filadetalle["fechadetallehorarioprematricula"]=$fechahoy;
				$filadetalle["fechainicialdetallehorarioprematricula"]=formato_fecha_mysql($fechainicio);
				$filadetalle["fechafinaldetallehorarioprematricula"]=formato_fecha_mysql($fechafinal);
				$filadetalle["horainicialdetallehorarioprematricula"]=$horainicial;
				$filadetalle["horafinaldetallehorarioprematricula"]=$horafinal;
				
				$filahorario["codigocarrera"]=$codigocarrera;

				$objetobase->actualizar_fila_bd($tabla,$filahorario,$nombreidtabla,$idtabla);
				
				if(isset($iddetallehorarioprematricula)&&$iddetallehorarioprematricula!='')
				{
						//$query="select idhorarioprematricula from horarioprematricula where $condicionactualiza";
						//$operaciodetalle=$objetobase->conexion->query($query);
						//$datoshorarioprematricula=$operaciodetalle->fetchRow();
						$tabla="detallehorarioprematricula";
						$nombreidtabla="iddetallehorarioprematricula";
						$idtabla=$iddetallehorarioprematricula;
						//$filadetalle["idhorarioprematricula"]=$idhorarioprematricula;
						/*$condicionactualiza=" idhorarioprematricula='".$filadetalle["idhorarioprematricula"]."'
											  and fechainicialdetallehorarioprematricula='".$filadetalle["fechainicialdetallehorarioprematricula"]."'".
											" and fechafinaldetallehorarioprematricula='".$filadetalle["fechafinaldetallehorarioprematricula"]."'".
											" and horainicialdetallehorarioprematricula='".$filadetalle["horainicialdetallehorarioprematricula"]."'
											  and horafinaldetallehorarioprematricula='".$filadetalle["horafinaldetallehorarioprematricula"]."'";*/
						$objetobase->actualizar_fila_bd($tabla,$filadetalle,$nombreidtabla,$idtabla);

				}
				echo "<META HTTP-EQUIV='Refresh' CONTENT='0'>";

			}
	}
	if(isset($_REQUEST['Anular'])){
		if($formulario->valida_formulario())
		{
				$tabla="horarioprematricula";
				$nombreidtabla="idhorarioprematricula";
				$idtabla=$idhorarioprematricula;
				$filahorario["codigoestado"]="200";
				
				$filadetalle["codigoestado"]="200";
				
				if(!isset($iddetallehorarioprematricula)&&$iddetallehorarioprematricula=='')
				$objetobase->actualizar_fila_bd($tabla,$filahorario,$nombreidtabla,$idtabla);
				
				if(isset($iddetallehorarioprematricula)&&$iddetallehorarioprematricula!='')
				{
						//$query="select idhorarioprematricula from horarioprematricula where $condicionactualiza";
						//$operaciodetalle=$objetobase->conexion->query($query);
						//$datoshorarioprematricula=$operaciodetalle->fetchRow();
						$tabla="detallehorarioprematricula";
						$nombreidtabla="iddetallehorarioprematricula";
						$idtabla=$iddetallehorarioprematricula;
						//$filadetalle["idhorarioprematricula"]=$idhorarioprematricula;
						/*$condicionactualiza=" idhorarioprematricula='".$filadetalle["idhorarioprematricula"]."'
											  and fechainicialdetallehorarioprematricula='".$filadetalle["fechainicialdetallehorarioprematricula"]."'".
											" and fechafinaldetallehorarioprematricula='".$filadetalle["fechafinaldetallehorarioprematricula"]."'".
											" and horainicialdetallehorarioprematricula='".$filadetalle["horainicialdetallehorarioprematricula"]."'
											  and horafinaldetallehorarioprematricula='".$filadetalle["horafinaldetallehorarioprematricula"]."'";*/
						$objetobase->actualizar_fila_bd($tabla,$filadetalle,$nombreidtabla,$idtabla);

				}
				echo "<META HTTP-EQUIV='Refresh' CONTENT='0'>";
			}
	
	}

?>
  </table>
</form>