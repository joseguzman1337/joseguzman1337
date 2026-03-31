<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
//session_cache_limiter('private');
//session_start();
$rutaado=("../../../funciones/adodb/");
//require_once("../../../funciones/clases/debug/SADebug.php");
//require_once("../../../funciones/clases/debug/SADebug.php");
require_once("../../../Connections/salaado-pear.php");
//require_once("../../../funciones/clases/formulario/clase_formulario.php");
//require_once("../../../funciones/validaciones/validaciongenerica.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
//require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/sala_genericas/DatosGenerales.php");
//require_once("funciones/FuncionesAportes.php");

		$objetobase=new BaseDeDatosGeneral($sala);
		
if(isset($_GET['iddetalleprocesodisciplinario']))
			if($datos=$objetobase->recuperar_datos_tabla("detalleprocesodisciplinario","iddetalleprocesodisciplinario",$_GET['iddetalleprocesodisciplinario'],' and codigoestado like \'1%\'','',0))
			{
				$idtipodetalleprocesodisciplinario=$datos['idtipodetalleprocesodisciplinario'];
				$descripciondetalleprocesodisciplinario=$datos['descripciondetalleprocesodisciplinario'];
				$fechadetalleprocesodisciplinario=formato_fecha_defecto($datos['fechadetalleprocesodisciplinario']);
				$rutaarchivodocumento=$datos['rutaarchivodocumentofisicodetalleprocesodisciplinario'];
				$descripciondocumentofisicodetalleprocesodisciplinario=$datos['descripciondocumentofisicodetalleprocesodisciplinario'];
				$idtipodocumentofisicodetalleprocesodisciplinario=$datos['idtipodocumentofisicodetalleprocesodisciplinario'];
 		}		

		$strType = 'text/plain';
		$strName = $_GET['nombrearchivo'];
		header("Content-Type: $strType ");
		header("Content-Disposition: attachment; filename=$strName\r\n\r\n");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Pragma: public");
		header("Content-Type: public");
		$gestor = fopen($rutaarchivodocumento, "rb");
		$contenido = fread($gestor, filesize($rutaarchivodocumento));
		echo $contenido;
		fclose($gestor);


		
		

?>