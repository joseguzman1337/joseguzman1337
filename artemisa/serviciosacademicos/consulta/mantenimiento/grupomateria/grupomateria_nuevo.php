<?php
/*
 * Ajustes de limpieza codigo y modificacion de interfaz
 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Universidad el Bosque - Direccion de Tecnologia.
 * Modificado 14 de Noviembre de 2017.
 */
session_start();
include_once(realpath(dirname(__FILE__)) . '/../../../utilidades/ValidarSesion.php');
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

$validaciongeneral = true;
$mensajegeneral = 'Los campos marcados con *, no han sido correctamente diligenciados\n';
ini_set("include_path", ".:/usr/share/pear_");
require_once(realpath(dirname(__FILE__)) . '/../funciones/conexion/conexion.php');
require_once(realpath(dirname(__FILE__)) . '/../funciones/pear/PEAR.php');
require_once(realpath(dirname(__FILE__)) . '/../funciones/pear/DB.php');
require_once(realpath(dirname(__FILE__)) . '/../funciones/pear/DB/DataObject.php');
require_once(realpath(dirname(__FILE__)) . '/../funciones/gui/combo_valida_get.php');
require_once(realpath(dirname(__FILE__)) . '/../funciones/gui/campotexto_valida_get.php');
require_once(realpath(dirname(__FILE__)) . '/../../../funciones/clases/autenticacion/redirect.php');

$config = parse_ini_file('../funciones/conexion/basedatos.ini', TRUE);
$config['DB_DataObject']['database'] = "mysql://" . $username_sala . ":" . $password_sala . "@" . $hostname_sala . "/" . $database_sala;
foreach ($config as $class => $values) {
    $options = &PEAR::getStaticProperty($class, 'options');
    $options = $values;
}
PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, 'error_handler');

function error_handler(&$obj) {
    $msg = $obj->getMessage();
    $code = $obj->getCode();
    $info = $obj->getUserInfo();
    echo $msg, ' ', $code, "<br>";
    if ($info) {
        print htmlspecialchars($info);
    }
}

$grupomateria = DB_DataObject::factory('grupomateria');
?>
<link type="text/css" rel="stylesheet" href="../../../../assets/css/normalize.css">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/font-page.css">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/font-awesome.css">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.css">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/general.css">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/chosen.css">
<script type="text/javascript" src="../../../../assets/js/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="../../../../assets/js/bootstrap.js"></script> 
<script language="Javascript">
    function abrir(pagina, ventana, parametros) {
        window.open(pagina, ventana, parametros);
    }
    function enviar()
    {
        document.form1.submit()
    }
</script>

<body>
    <div class="container">
        <form name="form1" method="get" action="">
            <center><h2>GRUPO MATERIA - CREAR NUEVO GRUPO</h2></center>
            <br>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th bgcolor="#CCDADD">Nombre grupo
                            <input type="hidden" name="codigoperiodo" value="<?php echo $_GET['codigoperiodo'] ?>">
                        </th>
                        <th bgcolor="#FEF7ED">
                            <?php
/*
 * modificar las validaciones para que sean mostradas las listas completas en el perfil de 'adminhumanidades' caso 95624
 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Universidad el Bosque - Direccion de Tecnologia.
 * Modificado 16 de Noviembre de 2017.
 */
//                            if ($_SESSION['MM_Username'] == "adminhumanidades") {
//                                echo "ELECTIVAS LIBRES";
//                            } else {
                                $validacion['nombregrupomateria'] = campotexto_valida_get("nombregrupomateria", "requerido", "Nombre del grupo", "80");
//                            }
                            ?>
                        </th>
                    </tr>
                    <tr>
                        <th bgcolor="#CCDADD">Tipo grupo</th>
                        <th bgcolor="#FEF7ED">
                            <?php
//                            if ($_SESSION['MM_Username'] == "adminhumanidades") {
//                                echo "ELECTIVAS LIBRES";
//                            } else {
                                $validacion['tipogrupomateria'] = combo_valida_get("codigotipogrupomateria", "tipogrupomateria", "codigotipogrupomateria", "nombretipogrupomateria", "", "", "", "si", "Tipo de grupo");
//                            }
                            ?>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="2">
                            <div align="center">
                                <input class="btn btn-fill-green-XL" name="Crear" type="submit" id="Crear" value="Crear grupo">
                            </div>
                        </th>
                    </tr>
                </table>
            </div>
        </form>
    </div>
</body>
<?php
if (isset($_GET['Crear'])) {
    $grupomateria->codigoperiodo = $_GET['codigoperiodo'];
//    if ($_SESSION['MM_Username'] == "adminhumanidades") {
//        $grupomateria->nombregrupomateria = "ELECTIVAS LIBRES";
//        $grupomateria->codigotipogrupomateria = 100;
//        $insertar = $grupomateria->insert();
//        if ($insertar) {
//            echo "<script language='javascript'>alert('Datos insertados correctamente');</script>";
//            echo '<script language="javascript">window.close();</script>';
//            echo '<script language="javascript">window.opener.recargar();</script>';
//        }
//    } else {
        foreach ($validacion as $key => $valor) {
            if ($valor['valido'] == 0) {
                $mensajegeneral = $mensajegeneral . '\n' . $valor['mensaje'];
                $validaciongeneral = false;
            }
        }
        if ($validaciongeneral == true) {
            $grupomateria->nombregrupomateria = $_GET['nombregrupomateria'];
            $grupomateria->codigotipogrupomateria = $_GET['codigotipogrupomateria'];
            $insertar = $grupomateria->insert();
            if ($insertar) {
                echo "<script language='javascript'>alert('Datos insertados correctamente');</script>";
                echo '<script language="javascript">window.close();</script>';
                echo '<script language="javascript">window.opener.recargar();</script>';
            }
        } else {
            echo "<script language='javascript'>alert('" . $mensajegeneral . "');</script>";
        }
//    }
//end
}
//end
?>