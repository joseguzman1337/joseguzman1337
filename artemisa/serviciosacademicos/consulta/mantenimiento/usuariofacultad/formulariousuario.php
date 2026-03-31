<?php
if($_SERVER['REMOTE_ADDR']=="127.0.0.1" || $_SERVER['REMOTE_ADDR']=="localhost"){
	require_once("../../../../kint/Kint.class.php");
	//d($_REQUEST);
}
	error_reporting(0);
	ini_set('display_errors', 0);
session_start();
 include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
$rol = $_SESSION['rol'];

//$_SESSION['MM_Username']='admintecnologia';
//print_r($_SESSION);
$rutaado = ("../../../funciones/adodb/");
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/debug/SADebug.php');
require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado-pear.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/formulario/clase_formulario.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/phpmailer/class.phpmailer.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/validaciones/validaciongenerica.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/FuncionesCadena.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/FuncionesFecha.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/formulariobaseestudiante.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/clasebasesdedatosgeneral.php');
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
<script LANGUAGE="JavaScript">
    function regresarGET()
    {
        document.location.href="<?php echo 'listadoformulariousuario.php'; ?>";
    }

</script>

<?php
//print_r($_SESSION);
$fechahoy = date("Y-m-d H:i:s");
$formulario = new formulariobaseestudiante($sala, 'form1', 'post', '', 'true');
$objetobase = new BaseDeDatosGeneral($sala);

$usuario = $formulario->datos_usuario();
$ip = $formulario->GetIP();
?>
<form name="form1" action="formulariousuario.php?idusuario=<?php echo $_GET['idusuario']?>" method="POST" >
    <input type="hidden" name="AnularOK" value="">
    <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
<?php
if (isset($_GET['idusuario'])&&trim($_GET['idusuario'])!='') {
    $datosplantillausuario = $objetobase->recuperar_datos_tabla("usuario", "idusuario", $_GET['idusuario'], '', '', 0);
    $usuario = $datosplantillausuario['usuario'];
    $numerodocumento = $datosplantillausuario['numerodocumento'];
    $tipodocumento = $datosplantillausuario['tipodocumento'];
    $apellidos = $datosplantillausuario['apellidos'];
    $nombres = $datosplantillausuario['nombres'];
    $codigousuario = $datosplantillausuario['codigousuario'];
    $semestre = $datosplantillausuario['semestre'];
    $codigorol = $datosplantillausuario['codigorol'];
    $fechainiciousuario = formato_fecha_defecto($datosplantillausuario['fechainiciousuario']);
    $fechavencimientousuario = formato_fecha_defecto($datosplantillausuario['fechavencimientousuario']);
    $fecharegistrousuario = formato_fecha_defecto($datosplantillausuario['fecharegistrousuario']);
    $codigotipousuario = $datosplantillausuario['codigotipousuario'];
    $idusuariopadre = $datosplantillausuario['idusuariopadre'];
    $ipaccesousuario = $datosplantillausuario['ipaccesousuario'];
    $codigoestadousuario = $datosplantillausuario['codigoestadousuario'];
} else {
    $usuario=  $_POST['usuario'];
    $numerodocumento =  $_POST['numerodocumento'];
    $tipodocumento =  $_POST['tipodocumento'];
    $apellidos =  $_POST['apellidos'];
    $nombres =  $_POST['nombres'];
    $codigousuario =  $_POST['codigousuario'];
    $semestre = $_POST['semestre'];
    $codigorol =  $_POST['codigorol'];
    $fechainiciousuario =  $_POST['fechainiciousuario'];
    $fechavencimientousuario =  $_POST['fechavencimientousuario'];
    $fecharegistrousuario =  $_POST['fecharegistrousuario'];
    $codigotipousuario =  $_POST['codigotipousuario'];
    $idusuariopadre =  $_POST['idusuariopadre'];
    $ipaccesousuario =  $_POST['ipaccesousuario'];
    $codigoestadousuario =  $_POST['codigoestadousuario'];

 /*   echo "USUARIO <pre>";
  print_r($usuario);
  echo "</pre>";*/
}


$conboton = 0;
$formulario->dibujar_fila_titulo('Usuario', 'labelresaltado');
$condicion = "";

$campo = "boton_tipo";
$parametros = "'text','usuario','" . $usuario . "','maxlength=\"15\"'";
$formulario->dibujar_campo($campo, $parametros, "Usuario", "tdtitulogris", 'usuario', 'requerido');
 /**
   * @modified Luis Dario Gualteros C <castroluisd@unbosque.edu.co>
   * Validación de tipos de documento pasaporte y Cédula de Extranjería para que permita letras en el campo de número de documento.
   * @since Enero 24, 2019.
 */   
    if($_POST['tipodocumento']== '03' || $_POST['tipodocumento']=='05'){
        $tipodato ='requerido';
    }else{
      $tipodato ='numero';
    }
//End Modificación. 
$campo = "boton_tipo";
$parametros = "'text','numerodocumento','" . $numerodocumento . "','maxlength=\"15\"'";
$formulario->dibujar_campo($campo, $parametros, "Número Documento", "tdtitulogris", 'numerodocumento', $tipodato); 

$formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("documento", "tipodocumento", "nombredocumento", $condicion, "", 0);
$formulario->filatmp[""] = "Seleccionar";
$menu = "menu_fila";
$parametrosmenu = "'tipodocumento','" . $tipodocumento . "',''";
$formulario->dibujar_campo($menu, $parametrosmenu, "Tipo Documento", "tdtitulogris", "tipodocumento", 'requerido');

$campo = "boton_tipo";
$parametros = "'text','apellidos','" . $apellidos . "','maxlength=\"15\"'";
$formulario->dibujar_campo($campo, $parametros, "Apellidos", "tdtitulogris", 'apellidos', 'requerido');

$campo = "boton_tipo";
$parametros = "'text','nombres','" . $nombres . "','maxlength=\"15\"'";
$formulario->dibujar_campo($campo, $parametros, "Nombres", "tdtitulogris", 'nombres', 'requerido');

$campo = "boton_tipo";
$parametros = "'text','codigousuario','" . $codigousuario . "','maxlength=\"15\"'";
$formulario->dibujar_campo($campo, $parametros, "Código Usuario", "tdtitulogris", 'codigousuario', 'requerido');

$campo = "boton_tipo";
$parametros = "'text','semestre','" . $semestre . "','maxlength=\"15\"'";
$formulario->dibujar_campo($campo, $parametros, "Semestre", "tdtitulogris", 'semestre', 'requerido');

$formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("rol", "idrol", "nombrerol", $condicion, "", 0);
$formulario->filatmp[""] = "Seleccionar";
$menu = "menu_fila";
$parametrosmenu = "'codigorol','" . $codigorol . "',''";
$formulario->dibujar_campo($menu, $parametrosmenu, "Rol", "tdtitulogris", "codigorol", 'requerido');



$campo = "campo_fecha";
$parametros = "'text','fechainiciousuario','" . $fechainiciousuario . "','onKeyUp = \"this.value=formateafecha(this.value);\" $funcionfechainicial'";
$formulario->dibujar_campo($campo, $parametros, "Fecha Inicio Usuario", "tdtitulogris", 'fechainiciousuario', 'requerido');

$campo = "campo_fecha";
$parametros = "'text','fechavencimientousuario','" . $fechavencimientousuario . "','onKeyUp = \"this.value=formateafecha(this.value);\" $funcionfechainicial'";
$formulario->dibujar_campo($campo, $parametros, "Fecha Vencimiento Usuario", "tdtitulogris", 'fechavencimientousuario', 'requerido');

$campo = "campo_fecha";
$parametros = "'text','fecharegistrousuario','" . $fecharegistrousuario . "','onKeyUp = \"this.value=formateafecha(this.value);\" $funcionfechainicial'";
$formulario->dibujar_campo($campo, $parametros, "Fecha Registro Usuario", "tdtitulogris", 'fecharegistrousuario', 'requerido');

$formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("tipousuario", "codigotipousuario", "nombretipousuario", $condicion, "", 0);
$formulario->filatmp[""] = "seleccionar";
$menu = "menu_fila";
$parametrosmenu = "'codigotipousuario','" . $codigotipousuario . "',''";
$formulario->dibujar_campo($menu, $parametrosmenu, "Código Tipo Usuario", "tdtitulogris", "codigotipousuario", 'requerido');



$campo = "boton_tipo";
$parametros = "'text','idusuariopadre','" . $idusuariopadre . "','maxlength=\"15\"'";
$formulario->dibujar_campo($campo, $parametros, "Id Usuario Padre", "tdtitulogris", 'idusuariopadre', 'numero');

$campo = "boton_tipo";
$parametros = "'text','ipaccesousuario','" . $ipaccesousuario . "','maxlength=\"15\"'";
$formulario->dibujar_campo($campo, $parametros, "Ip Acceso Usuario", "tdtitulogris", 'ipaccesousuario', '');
$formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("estadousuario", "codigoestadousuario", "nombreestadousuario", $condicion, "", 0);
$formulario->filatmp[""] = "Seleccionar";
$menu = "menu_fila";
$parametrosmenu = "'codigoestadousuario','" . $codigoestadousuario . "',''";
$formulario->dibujar_campo($menu, $parametrosmenu, "Código Estado Usuario", "tdtitulogris", "codigoestadousuario", 'requerido');



if (isset($_GET['idusuario'])) {
   $parametrobotonenviar[$conboton] = "'submit','Modificar','Modificar'";
    $boton[$conboton] = 'boton_tipo';
    $formulario->boton_tipo('hidden', 'idusuario', $_GET['idusuario']);
    $conboton++;
} else {
    $parametrobotonenviar[$conboton] = "'submit','Enviar','Enviar'";
    $boton[$conboton] = 'boton_tipo';
    $conboton++;
}

$parametrobotonenviar[$conboton] = "'button','Regresar','Regresar','onclick=\'regresarGET();\''";
$boton[$conboton] = 'boton_tipo';
$formulario->dibujar_campos($boton, $parametrobotonenviar, "", "tdtitulogris", 'Enviar', '', 0);
 /*echo "<pre>";
  print_r($_POST);
  echo "</pre>";
*/
if (!empty($_REQUEST['Enviar'])) {
    if ($formulario->valida_formulario()) {
		$query_validacionusuario = "SELECT u.usuario FROM usuario u where u.usuario='$usuario'";
        $validacionusuario = $objetobase->conexion->Execute($query_validacionusuario);
        $totalRows_validacionusuario = $validacionusuario->RecordCount();
        
        $query_validacion = "SELECT u.numerodocumento, u.codigotipousuario FROM usuario u WHERE u.numerodocumento ='$numerodocumento'
                          and u.codigotipousuario ='$codigotipousuario'";
        $validacionnumero =  $objetobase->conexion->query($query_validacion);
        $totalRows_validacionnumero = $validacionnumero->RecordCount();
 
        $tabla = "usuario";
        $fila['usuario'] = $_POST['usuario'];
        $fila['numerodocumento'] = ltrim(rtrim($_POST['numerodocumento']));
        $fila['tipodocumento'] = ltrim(rtrim($_POST['tipodocumento']));
        $fila['apellidos'] = $_POST['apellidos'];
        $fila['nombres'] = $_POST['nombres'];
        $fila['codigousuario'] = $_POST['codigousuario'];
        $fila['semestre'] = $_POST['semestre'];
        $fila['codigorol'] = $_POST['codigorol'];
        $fila['fechainiciousuario'] =formato_fecha_mysql( $_POST['fechainiciousuario']);
        $fila['fechavencimientousuario'] = formato_fecha_mysql($_POST['fechavencimientousuario']);
        $fila['fecharegistrousuario'] = formato_fecha_mysql($_POST['fecharegistrousuario']);
        $fila['codigotipousuario'] = $_POST['codigotipousuario'];
        $fila['idusuariopadre'] = $_POST['idusuariopadre'];
        $fila['ipaccesousuario'] = $_POST['ipaccesousuario'];
        $fila['codigoestadousuario'] = $_POST['codigoestadousuario'];
        $condicionactualiza = "usuario='" . $fila['usuario']."'";
 
        if ($totalRows_validacionusuario >0) {
        ?>
            <script type="text/javascript">
                alert('El usuario digitado ya existe');
                window.location.href='';
            </script>
        <?php
        }elseif ($totalRows_validacionnumero >0){
        	?>
        	<script type="text/javascript">
        		alert('El número de documento y el código tipo usuario digitado ya existe');
        		window.location.href='';
        	</script>
        	<?php
		} else {
			/*echo "<pre>";
			print_r($fila);
			echo "</pre>";/**/
			$objetobase->insertar_fila_bd($tabla, $fila, 0, $condicionactualiza);
			
			/*
			 * @modified Andres Ariza <arizaandres@unbosque.edu.co>
			 * Se agregaron updates e inserts en las tablas UsuarioTipo y usuario rol para mantener la integridad necesaria en los datos
			 * @since  Febrero 07, 2017
			*/ 
			$query = "SELECT idusuario
					FROM usuario 
				   WHERE usuario='".$fila['usuario']."'";
			//d($query);
		
			$Usuario = $objetobase->conexion->Execute($query); 
			$idtabla=$Usuario->fetchRow();
			$idtabla=$idtabla['idusuario'];
					
			$query = "SELECT UsuarioTipoId
						FROM UsuarioTipo 
					   WHERE UsuarioId = ".$idtabla;
			//d($query);
			
			$UsuarioTipo = $objetobase->conexion->Execute($query);
                        $countUsuarioTipo = $UsuarioTipo->RecordCount();
	        
			$rowUsuarioTipo=$UsuarioTipo->fetchRow(); 
			
			$query = "UsuarioTipo 
						SET CodigoTipoUsuario ='".$fila['codigotipousuario']."',
							UsuarioId = '".$idtabla."',
							CodigoEstado = '100' ";
							
			if($countUsuarioTipo == 1){
				$query = "UPDATE ".$query;
				$query .= " WHERE UsuarioTipoId = ".$rowUsuarioTipo['UsuarioTipoId'];
			}else{
				$query = "INSERT INTO ".$query;
			}
			//d($query);
			//$result = $objetobase->conexion->query($query);
			$result = $objetobase->conexion->Execute($query);
			
	        if($countUsuarioTipo < 1){
				$query = "SELECT UsuarioTipoId
						FROM UsuarioTipo 
					   WHERE UsuarioId = ".$idtabla;
				//d($query);
				$UsuarioTipo = $objetobase->conexion->Execute($query);
				$rowUsuarioTipo=$UsuarioTipo->fetchRow();
			}
			
			
			$query = "SELECT * 
						FROM usuariorol
					   WHERE idusuariotipo = ".$rowUsuarioTipo['UsuarioTipoId'];
			//d($query);
			$UsuarioRol = $objetobase->conexion->Execute($query);
	        $countUsuarioRol = $UsuarioRol->RecordCount();
			
			if($countUsuarioRol == 1){
				$query = "UPDATE "; 
			}else{
				$query = "INSERT INTO ";
			}
			$query .= "usuariorol 
						SET idrol = '".$fila['codigorol']."',
							codigoestado = '100', 
							idusuariotipo = '".$rowUsuarioTipo['UsuarioTipoId']."'";
			if($countUsuarioRol == 1){
				$query .= " WHERE idusuariotipo = ".$rowUsuarioTipo['UsuarioTipoId']; 
			}
			//$result = $objetobase->conexion->query($query);
			$result = $objetobase->conexion->Execute($query);
			//ddd($query);
			/*END*/
			// echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";
        }
    }
}

if (!empty($_REQUEST['Modificar'])) {
	if ($formulario->valida_formulario()) {
		$query_actualizarusuario = "SELECT u.usuario FROM usuario u WHERE u.usuario='$usuario'";
		$actualizarusuario = $objetobase->conexion->Execute($query_actualizarusuario);
        $totalRows_actualizarusuario = $actualizarusuario->RecordCount();
		
		$query_actualizar = "SELECT u.numerodocumento, u.codigotipousuario 
							   FROM usuario u 
							  WHERE u.numerodocumento ='$numerodocumento'
								AND u.codigotipousuario ='$codigotipousuario'
								AND u.idusuario = '".$_POST['idusuario']."'";
		
		$actualizarnumero = $objetobase->conexion->Execute($query_actualizar);
        $totalRows_actualizarnumero = $actualizarnumero->RecordCount();
        $tabla = "usuario";
        $nombreidtabla = "idusuario";
        $idtabla = $_POST['idusuario'];
        $fila['usuario'] = $_POST['usuario'];
        $fila['numerodocumento'] = ltrim(rtrim($_POST['numerodocumento']));
        $fila['tipodocumento'] = ltrim(rtrim($_POST['tipodocumento']));
        $fila['apellidos'] = $_POST['apellidos'];
        $fila['nombres'] = $_POST['nombres'];
        $fila['codigousuario'] = $_POST['codigousuario'];
        $fila['semestre'] = $_POST['semestre'];
        $fila['codigorol'] = $_POST['codigorol'];
        $fila['fechainiciousuario'] =formato_fecha_mysql( $_POST['fechainiciousuario']);
        $fila['fechavencimientousuario'] =formato_fecha_mysql( $_POST['fechavencimientousuario']);
        $fila['fecharegistrousuario'] = formato_fecha_mysql($_POST['fecharegistrousuario']);
        $fila['codigotipousuario'] = $_POST['codigotipousuario'];
        $fila['idusuariopadre'] = $_POST['idusuariopadre'];
        $fila['ipaccesousuario'] = $_POST['ipaccesousuario'];
        $fila['codigoestadousuario'] = $_POST['codigoestadousuario'];
		
		/*
		 * @modified Andres Ariza <arizaandres@unbosque.edu.co>
		 * Se agregaron updates e inserts en las tablas UsuarioTipo y usuario rol para mantener la integridad necesaria en los datos
		 * @since  Febrero 07, 2017
		*/ 
		$objetobase->actualizar_fila_bd($tabla, $fila, $nombreidtabla, $idtabla,"",0); 
		//$result = $objetobase->conexion->query($query);
		$result = $objetobase->conexion->Execute($query);
		
		$query1 = "SELECT UsuarioTipoId
					FROM UsuarioTipo 
				   WHERE UsuarioId = ".$idtabla;
		//d($query1);
		$UsuarioTipo = $objetobase->conexion->Execute($query1);
        $countUsuarioTipo = $UsuarioTipo->RecordCount();
        
		$rowUsuarioTipo=$UsuarioTipo->fetchRow(); 
		
		$query2 = "UsuarioTipo 
					SET CodigoTipoUsuario ='".$fila['codigotipousuario']."',
						UsuarioId = '".$idtabla."',
						CodigoEstado = '100' ";
						
		if($countUsuarioTipo == 1){
			$query2 = "UPDATE ".$query2;
			$query2 .= " WHERE UsuarioTipoId = ".$rowUsuarioTipo['UsuarioTipoId'];
		}else{
			$query2 = "INSERT INTO ".$query2;
		}
		//d($query2);
		//$result = $objetobase->conexion->query($query2);
		$result = $objetobase->conexion->Execute($query2);
		
        if($countUsuarioTipo < 1){
			$query3 = "SELECT UsuarioTipoId
					FROM UsuarioTipo 
				   WHERE UsuarioId = ".$idtabla;
			//d($query3);
			$UsuarioTipo = $objetobase->conexion->Execute($query3);
			$rowUsuarioTipo=$UsuarioTipo->fetchRow();
		}
		
		$query4 = "SELECT * 
					FROM usuariorol
				   WHERE idusuariotipo = ".$rowUsuarioTipo['UsuarioTipoId'];
		//d($query4);
		$UsuarioRol = $objetobase->conexion->Execute($query4);
        $countUsuarioRol = $UsuarioRol->RecordCount();
		
		if($countUsuarioRol == 1){
			$query5 = "UPDATE "; 
		}else{
			$query5 = "INSERT INTO ";
		}
		$query5 .= "usuariorol 
					SET idrol = '".$fila['codigorol']."',
						codigoestado = '100', 
						idusuariotipo = '".$rowUsuarioTipo['UsuarioTipoId']."'";
		if($countUsuarioRol == 1){
			$query5 .= " WHERE idusuariotipo = ".$rowUsuarioTipo['UsuarioTipoId']; 
		}
		//d($query5);
		//$result = $objetobase->conexion->query($query5);
		$result = $objetobase->conexion->Execute($query5);
		/*END*/
		
        //echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>"; 
        
        if ($totalRows_actualizarusuario  >0) {
	        /*?>
	            <script type="text/javascript">
	                alert('El usuario digitado ya existe');
	                window.location.href='';
	            </script>
	        <?*/
        }elseif ($totalRows_actualizarnumero >0){
			?>
			<script type="text/javascript">
				alert('El número de documento y el código tipo usuario digitado ya existe');
				window.location.href='';
			</script>
			<?php
        } else {
        	$objetobase->actualizar_fila_bd($tabla, $fila, $nombreidtabla, $idtabla);
            echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";
        }
    }
}

        ?>

    </table>
</form>
