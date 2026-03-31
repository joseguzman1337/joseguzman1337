<?php
$rutaado = (realpath(dirname(__FILE__)) . "/../../funciones/adodb/");
require_once(realpath(dirname(__FILE__)) . '/../../funciones/sala/nota/nota.php');
require_once(realpath(dirname(__FILE__)) . '/../../Connections/sala2.php');
require_once(realpath(dirname(__FILE__)) . '/../../Connections/salaado.php');
require_once('funcionespermisosmenu.php');

/**
 * Caso 370.
 * Se incluye el archivo adaptador para tener acceso a las funciones basicas de
 * del nuevo sala si la aplicacion se corre en un entorno local o de pruebas 
 * se activa la visualizacion de todos los errores de php
 * @modified Dario Gaulteros Castro <castroluisd@unbosque.edu.co>.
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @since 21 de Febrero 2019.
 */
require_once(realpath(dirname(__FILE__) . "/../../../sala/includes/adaptador.php"));

/**
 * El metodo Factory::validateSession($variables) hace una validacion de session activa en el sistema
 * dependiendo de los parametros que se le envíen, si determina que la session acabo redirige el sistema al login
 */
Factory::validateSession($variables);
$User = Factory::getSessionVar('usuario');
$itemId = Factory::getSessionVar('itemId');
/**
 * Caso 370.
 * @modified Luis Dario Gualteros C <castroluisd@unbosque.edu.co>
 * Ajuste de acceso por usuario por la opción de Gestion de Permisos.
 * @since 18 de Febrero 2019.
 */
require_once('../../../assets/lib/Permisos.php');
if (!Permisos::validarPermisosComponenteUsuario($User, $itemId)) {
    header("Location: " . HTTP_ROOT . "/serviciosacademicos/GestionRolesYPermisos/index.php?option=error");
    exit();
}
//End Caso 370.  

if (isset($_GET['debug'])) {
    $db->debug = true;
}

if (isset($_POST['CrearPropio'])) {
    crearPermisoPropio($_REQUEST['usuarionombre']);
}
if (isset($_POST['copiar'])) {
    copiarPermiso($_REQUEST['usuarionombre'], $_REQUEST['copiarpermiso']);
}
if (isset($_POST['guardar'])) {
    // Primero quita todos los permisos, los pone en 200
    quitarPermisos($_REQUEST['usuarionombre']);

    foreach ($_POST['opciones'] as $indice => $idmenuopcion) {
        // Agrega los permisos que vienen en el post
        if (!tienePermiso($_REQUEST['usuarionombre'], $idmenuopcion)) {
            // Insertar en la tabla detalpermisomenuopcion
            //echo "Dar permiso $idmenuopcion <br>";
            // Da permisos nuevos
            darPermiso($_REQUEST['usuarionombre'], $idmenuopcion);
        }
    }
}
?>
<html>
    <head>
        <title>Permisos men�</title>
        <script  src="js/dhtmlxcommon.js"></script>
        <script  src="js/dhtmlxtree.js"></script>
        <script  src="js/dhtmlxtree_start.js"></script>
        <script type="text/javascript">
            function alternar(division) {
                if (division.style.display == "none")
                {
                    division.style.display = "";
                } else
                {
                    division.style.display = "none"
                }
            }
        </script>
        <link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
    </head>
    <body>
        <form action="" method="get" name="f1">
            <b>Digite el nombre del usuario al que desea administrarle los permisos:</b><br>
            <input name="usuarionombre" value="<?php echo $_REQUEST['usuarionombre'] ?>" type="text">
        </form>
        <br>
<?php
if (isset($_REQUEST['usuarionombre'])) {
    $usuarionombre = $_REQUEST['usuarionombre'];
    $idusuario = getIdusuario($usuarionombre);
    $idpermisomenuopcion = getIdpermisomenuopcion($idusuario);
    if ($idpermisomenuopcion == "") {
        // Toca crearle permiso o asociarle uno
        ?>

                Para crearle los permisos a este usuario tiene dos opciones, una es que tome los permisos de otro usuario o crearle premisos propios. <br>
                <input type="button" value="Seleccione el usuario del cual desea tomar los permisos:" onClick="alternar(copiausuario)">
                <form action="" name="f1" onsubmit="if (!confirm('�Desea crear un idpermisomenuopcion propio?')) {
                    return false;
                }" method="post">
                    <input type="submit" value="Crear permisos propios:" name="CrearPropio">
                    <input type="hidden" value="<?php echo $usuarionombre; ?>" name="usuarionombre">
                </form>
                <form action="" name="f2" onsubmit="if (!confirm('�Est� seguro de copiar el idpermisomenuopcion?')) {
                    return false;
                }" method="post">
                    <div id="copiausuario" style="display:none">
                        <input type="hidden" value="<?php echo $usuarionombre; ?>" name="usuarionombre">
                    <?php
                    mostrarUsuariosyPermisos();
                    ?>
                        <input name="copiar" type="submit" value="Copiar permisos">
                    </div>
                </form>
                    <?php
                    exit();
                }
                ?>
            <form name="f2" method="post" action="">
                    <?php
                    $idusuario = getIdusuario($usuarionombre);
                    $query_usuarios = "select idusuario
                        from usuario
                        where usuario = '$usuarionombre'";
                    $usuarios = $db->Execute($query_usuarios);
                    $totalRows_usuarios = $usuarios->RecordCount();
                    if ($totalRows_usuarios != 0) {
                        ?>
                    Idpermisomenuopcion - <?php echo $idpermisomenuopcion; ?><br>
                    <input type="button" onClick="alternar(otros)" value="Si modifica los permisos de este usuario tambi�n se cambiarian los permisos de los siguientes usuarios">
                    <div id="otros" style="display:none">
                    <?php
                    mostrarUsuariosEquivalentes($usuarionombre);
                    ?>
                    </div>
                    <div style="position:relative; left:400px; top:250px"><input name="guardar" value="Guardar" type="submit"></div>
                    <div id="tree" setImagePath="js/imgs/" class="dhtmlxTree">
                        <ul>

                    <?php
                    $row_usuarios = $usuarios->FetchRow();
                    $idusuario = $row_usuarios['idusuario'];

                    // Traer el menu opción para el usuario de tecnologia, primero trae los papas
                    $query_papas = "select m.idmenuopcion, m.nombremenuopcion, m.linkmenuopcion, m.idpadremenuopcion, m.codigotipomenuopcion, m.nivelmenuopcion
                        from menuopcion m
                        where m.idpadremenuopcion = 0
                        and m.codigoestadomenuopcion like '01%'
                        order by m.nombremenuopcion";
                    $papas = $db->Execute($query_papas);
                    $totalRows_papas = $papas->RecordCount();
                    while ($row_papas = $papas->FetchRow()) {
                        ?>
                                <li><?php getCheck($row_papas['idmenuopcion'], $idusuario);
                    echo $row_papas['idmenuopcion'] . "-" . $row_papas['nombremenuopcion']; ?>
                                    <ul>
                                <?php
                                getHijos($row_papas['idmenuopcion'], $idusuario);
                                ?>
                                    </ul>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                            <?php
                        } else {
                            ?>
                    <p>Este usuario no existe</p>
                                    <?php
                                }
                            }
                            ?>
        </form>
    </body>
</html>