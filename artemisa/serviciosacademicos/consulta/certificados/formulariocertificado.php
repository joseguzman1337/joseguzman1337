<?php
session_start();
//$rol = $_SESSION['rol'];

//$_SESSION['MM_Username']='admintecnologia';
//print_r($_SESSION);
$rutaado = ("../../funciones/adodb/");
require_once("../../funciones/clases/debug/SADebug.php");
require_once("../../Connections/salaado-pear.php");
require_once("../../funciones/clases/formulario/clase_formulario.php");
require_once("../../funciones/phpmailer/class.phpmailer.php");
require_once("../../funciones/validaciones/validaciongenerica.php");
require_once("../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
?>
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<style type="text/css">@import url(../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../funciones/clases/formulario/globo.js"></script>
<script LANGUAGE="JavaScript">
    function regresarGET()
    {
        document.location.href="<?php echo 'listadoformulariousuario.php'; ?>";
    }

    function enviar()
    {
        form1.action="";
        document.form1.submit();


    }

</script>

<?php
//print_r($_SESSION);
$fechahoy = date("Y-m-d H:i:s");
$formulario = new formulariobaseestudiante($sala, 'form1', 'post', '', 'true');
$objetobase = new BaseDeDatosGeneral($sala);

//$usuario = $formulario->datos_usuario();
//$ip = $formulario->GetIP();
?>
<form name="form1" action="formulariocertificado.php?iddetallecertificado=<?php echo $_GET['iddetallecertificado'] ?>" method="POST" >
    <input type="hidden" name="AnularOK" value="">
    <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
        <?php
        if (isset($_POST['idcertificado']) && trim($_POST['idcertificado']) != ''
                && isset($_POST['idtipodetallecertificado']) && trim($_POST['idtipodetallecertificado']) != '') {
            $condicion = " and idtipodetallecertificado =" . $_POST['idtipodetallecertificado'];
            $datosplantillacertificado = $objetobase->recuperar_datos_tabla("detallecertificado", "idcertificado", $_POST['idcertificado'], $condicion, '',0);
            $idcertificado = $_POST['idcertificado'];
            $textodetallecertificado = $datosplantillacertificado['textodetallecertificado'];
            $idtipodetallecertificado = $_POST['idtipodetallecertificado'];
            $codigoestado = $datosplantillacertificado['codigoestado'];
        }

        elseif (isset($_GET['iddetallecertificado'])&& trim($_GET['iddetallecertificado'])) {
          
            $datosplantillaiddetallecertificado = $objetobase->recuperar_datos_tabla("detallecertificado", "iddetallecertificado", $_GET['iddetallecertificado'], '', '', 0);
            $idcertificado = $datosplantillaiddetallecertificado['idcertificado'];
            $textodetallecertificado = $datosplantillaiddetallecertificado['textodetallecertificado'];
            $idtipodetallecertificado = $datosplantillaiddetallecertificado['idtipodetallecertificado'];
            $codigoestado = $datosplantillaiddetallecertificado['codigoestado'];
        }
        else {

            $idcertificado = $_POST['idcertificado'];
            $idtipodetallecertificado = $_POST['idtipodetallecertificado'];
            $textodetallecertificado = $_POST['textodetallecertificado'];
            $codigoestado = $_POST['codigoestado'];
        }


        $conboton = 0;
        $formulario->dibujar_fila_titulo('Detalle Certificado', 'labelresaltado');
        $condicion = "";
        $condicion1 = "idcertificado not in (1,2,3,4,11,12,13)";
        $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("certificado", "idcertificado", "nombrecertificado", $condicion1, "", 0);
        $formulario->filatmp[""] = "Seleccionar";
        $menu = "menu_fila";
        $parametrosmenu = "'idcertificado','" . $idcertificado . "','onchange=\'enviar();\''";
        $formulario->dibujar_campo($menu, $parametrosmenu, "Certificado", "tdtitulogris", "idcertificado", 'requerido');

        $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("tipodetallecertificado", "idtipodetallecertificado", "nombretipodetallecertificado", $condicion, "", 0);
        $formulario->filatmp[""] = "Seleccionar";
        $menu = "menu_fila";
        $parametrosmenu = "'idtipodetallecertificado','" . $idtipodetallecertificado . "','onchange=\'enviar();\''";
        $formulario->dibujar_campo($menu, $parametrosmenu, "Tipo Detalle Certificado", "tdtitulogris", "idtipodetallecertificado", 'requerido');

        /* $campo = "boton_tipo";
          $parametros = "'text','textodetallecertificado','" . $textodetallecertificado . "','maxlength=\"15\"'";
          $formulario->dibujar_campo($campo, $parametros, "Texto Detalle", "tdtitulogris", 'textodetallecertificado', 'requerido'); */

        $campo = "memo";
        $parametros = "'textodetallecertificado','textodetallecertificado',70,8,'','','',''";
        $formulario->dibujar_campo($campo, $parametros, "Texto Detalle", "tdtitulogris", 'textodetallecertificado');
        $formulario->cambiar_valor_campo('textodetallecertificado', quitarsaltolinea($textodetallecertificado));

        //echo quitartilde($textodetallecertificado);


        $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("estado", "codigoestado", "nombreestado", $condicion, "", 0);
        $formulario->filatmp[""] = "Seleccionar";
        $menu = "menu_fila";
        $parametrosmenu = "'codigoestado','" . $codigoestado . "',''";
        $formulario->dibujar_campo($menu, $parametrosmenu, "Estado Certificado", "tdtitulogris", "codigoestado", 'requerido');


        if (isset($_GET['idusuario'])) {
            $parametrobotonenviar[$conboton] = "'submit','Modificar','Modificar'";
            $boton[$conboton] = 'boton_tipo';
            $formulario->boton_tipo('hidden', 'iddetallecertificado', $_GET['iddetallecertificado']);
            $conboton++;
        } else {
            $parametrobotonenviar[$conboton] = "'submit','Enviar','Enviar'";
            $boton[$conboton] = 'boton_tipo';
            $conboton++;
        }

        $parametrobotonenviar[$conboton] = "'button','Regresar','Regresar','onclick=\'regresarGET();\''";
        $boton[$conboton] = 'boton_tipo';
        $formulario->dibujar_campos($boton, $parametrobotonenviar, "", "tdtitulogris", 'Enviar', '', 0);

        if (isset($_REQUEST['Enviar'])) {
            if ($formulario->valida_formulario()) {
                $query_validacionusuario = "SELECT d.idcertificado FROM detallecertificado d where d.idcertificado='$idcertificado'";
                $validacionusuario = $objetobase->conexion->Execute($query_validacionusuario);
                $totalRows_validacionusuario = $validacionusuario->RecordCount();
                $tabla = "detallecertificado";
                $fila['idcertificado'] = $_POST['idcertificado'];
                $fila['idtipodetallecertificado'] = $_POST['idtipodetallecertificado'];
                $fila['textodetallecertificado'] = $_POST['textodetallecertificado'];
                $fila['codigoestado'] = $_POST['codigoestado'];
                $condicionactualiza = " idcertificado=" . $_POST['idcertificado'] .
                        " and idtipo" . $tabla . "=" . $_POST['idtipodetallecertificado'];

          $objetobase->insertar_fila_bd($tabla, $fila, 0, $condicionactualiza);
                       
          $query_actualizar = "SELECT d.idcertificado, d.idtipodetallecertificado, d.iddetallecertificado FROM detallecertificado d
          WHERE d.idcertificado ='$idcertificado' and d.idtipodetallecertificado ='$idtipodetallecertificado'";

          $actualizardetallecertificado = $objetobase->conexion->Execute($query_actualizar);
          $Rows_actualizarcertificado=$actualizardetallecertificado->fetchRow();
          $totalRows_actualizardetalle = $actualizardetallecertificado->RecordCount();
           echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=formulariocertificado.php?iddetallecertificado=".$Rows_actualizarcertificado['iddetallecertificado']."'>";
            }
        }
        /*
          if (isset($_REQUEST['Modificar'])) {
          if ($formulario->valida_formulario()) {

          echo $query_actualizarusuario = "SELECT d.idcertificado FROM detallecertificado d where d.idcertificado='$idcertificado'";
          $actualizarusuario = $objetobase->conexion->Execute($query_actualizarusuario);
          $totalRows_actualizarusuario = $actualizarusuario->RecordCount();

          echo  $query_actualizar = "SELECT d.idcertificado, d.idtipodetallecertificado FROM detallecertificado d
          WHERE d.idcertificado ='$idcertificado' and d.idtipodetallecertificado ='$idtipodetallecertificado'
          and u.iddetallecertificado <> '".$_POST['iddetallecertificado']."'";

          $actualizarnumero = $objetobase->conexion->Execute($query_actualizar);
          $totalRows_actualizarnumero = $actualizarnumero->RecordCount();


          $tabla = "detallecertificado";
          $nombreidtabla = "iddetallecertificado";
          $idtabla = $_POST['iddetallecertificado'];
          $fila['idcertificado'] = $_POST['idcertificado'];
          $fila['idtipodetallecertificado'] = $_POST['idtipodetallecertificado'];
          $fila['textodetallecertificado'] = $_POST['textodetallecertificado'];
          $fila['codigoestado'] = $_POST['codigoestado'];
          $objetobase->actualizar_fila_bd($tabla, $fila, $nombreidtabla, $idtabla);

          if ($totalRows_actualizarusuario  >0) {
          ?>
          <script type="text/javascript">
          alert('El número de documento y el código tipo usuario digitado ya existe');
          window.location.href='';
          </script>
          <?
          }

          else {

          $objetobase->actualizar_fila_bd($tabla, $fila, $nombreidtabla, $idtabla);
          //echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";
          }
          }
          }
         */
        ?>

    </table>
</form>
