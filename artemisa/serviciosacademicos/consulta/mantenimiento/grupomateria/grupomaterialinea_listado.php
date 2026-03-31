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

$fechahoy = date("Y-m-d H:i:s");

/*
 * modificar las validaciones para que sean mostradas las listas completas en el perfil de 'adminhumanidades' caso 95624
 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Universidad el Bosque - Direccion de Tecnologia.
 * Modificado 16 de Noviembre de 2017.
 */
if ($_SESSION['rol'] == "13" || $_SESSION['MM_Username'] == "adminhumanidades") {
    $query_detalleplanestudio = "SELECT DISTINCT dpe.codigomateria,m.nombremateria,c.nombrecarrera ";
    $query_detalleplanestudio .= "FROM materia m, detalleplanestudio dpe, carrera c ";
    $query_detalleplanestudio .= "WHERE dpe.codigomateria=m.codigomateria ";
    $query_detalleplanestudio .= "AND m.codigocarrera=c.codigocarrera ";
    $query_detalleplanestudio .= "AND m.codigoindicadorgrupomateria=100 ";
    //$query_detalleplanestudio .= "AND dpe.codigotipomateria not like '4%' ";
    if($_GET['codigomodalidadacademica']!=""){
        $query_detalleplanestudio .= "and c.codigomodalidadacademica='" . $_GET['codigomodalidadacademica'] . "' ";
    }
    $query_detalleplanestudio .= "ORDER BY m.nombremateria, c.nombrecarrera ASC	";
} elseif ($_SESSION['rol'] == '3') {
    $query_detalleplanestudio = "SELECT DISTINCT dpe.codigomateria,m.nombremateria,c.nombrecarrera ";
    $query_detalleplanestudio .= "FROM materia m, detalleplanestudio dpe, planestudio pe, carrera c ";
    $query_detalleplanestudio .= "WHERE dpe.codigomateria=m.codigomateria ";
    $query_detalleplanestudio .= "AND dpe.idplanestudio=pe.idplanestudio ";
    $query_detalleplanestudio .= "AND pe.codigocarrera=c.codigocarrera ";
    $query_detalleplanestudio .= "AND m.codigoindicadorgrupomateria=100 ";
    //$query_detalleplanestudio .= "AND dpe.codigotipomateria not like '4%' ";
    $query_detalleplanestudio .= "AND pe.codigocarrera='" . $_SESSION['codigofacultad'] . "' ";
    if($_GET['codigomodalidadacademica']!=""){
    $query_detalleplanestudio .= "AND c.codigomodalidadacademica='" . $_GET['codigomodalidadacademica'] . "' ";
    }
    $query_detalleplanestudio .= "ORDER BY m.nombremateria, c.nombrecarrera ASC	";
}
//end
$detalleplanestudio = $sala->query($query_detalleplanestudio);
$row_detalleplanestudio = $detalleplanestudio->fetchRow();
?>
<meta charset="utf-8">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/normalize.css">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/font-page.css">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/font-awesome.css">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.css">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/general.css">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/chosen.css">
<script type="text/javascript" src="../../../../assets/js/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="../../../../assets/js/bootstrap.js"></script> 
<script language="javascript">
    function HabilitarTodos(chkbox, seleccion)
    {
        for (var i = 0; i < document.forms[0].elements.length; i++)
        {
            var elemento = document.forms[0].elements[i];
            if (elemento.type == "checkbox")
            {
                if (elemento.title == "materias")
                {
                    elemento.checked = chkbox.checked;
                }
            }
        }
    }
    function abrir(pagina, ventana, parametros) {
        window.open(pagina, ventana, parametros);
    }
    function enviar()
    {
        document.form1.submit();
    }
</script>
<body>
    <div class="container">
        <form name="form1" method="get" action="">
            <center><h2>GRUPO MATERIA LINEA</h2></center>
            <br>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th width="45%" bgcolor="#CCDADD"><div align="center">Seleccione Periodo</div></th>
                        <th width="55%" bgcolor="#FEF7ED"><?php $validacion['codigoperiodo'] = combo_valida_get("codigoperiodo", "periodo", "codigoperiodo", "codigoperiodo", 'onChange="enviar()"', '', "codigoperiodo desc", "si", "Periodo") ?></th>
                    </tr>
                    <tr>
                        <th bgcolor="#CCDADD"><div align="center">Seleccione Grupo </div></th>
                        <th bgcolor="#FEF7ED"><?php $validacion['idgrupomateria'] = combo_valida_get("idgrupomateria", "grupomateria", "idgrupomateria", "nombregrupomateria", 'onChange="enviar()"', "codigoperiodo='" . $_GET['codigoperiodo'] . "'", "", "si", "Grupo materia") ?></th>
                    </tr>
                    <tr>
                        <th bgcolor="#CCDADD"><div align="center">Seleccione Modalidad </div></th>
                        <th bgcolor="#FEF7ED"><?php $validacion['codigomodalidadacademica'] = combo_valida_get("codigomodalidadacademica", "modalidadacademica", "codigomodalidadacademica", "nombremodalidadacademica", 'onChange="enviar()"', "codigoestado=100 and codigomodalidadacademica not between 500 and 599", "", "si", "Modalidad Academica") ?></th>
                    </tr>
                </table>
                <br>
                <table class="table">
                    <tr bgcolor="#CCDADD">
                        <th><div align="center">ID</div></th>
                        <th><div align="center">MATERIA</div></th>
                        <th><div align="center">CARRERA</div></th>
                        <th><div align="center">SELECCIONE</div></th>
                    </tr>
                    <?php
                    do {
                        $query_grupomaterialinea = "select gml.idgrupomaterialinea,gml.codigomateria ";
                        $query_grupomaterialinea .= "from grupomaterialinea gml ";
                        $query_grupomaterialinea .= "inner join grupomateria gm on gm.idgrupomateria=gml.idgrupomateria ";
                        $query_grupomaterialinea .= "where 1 ";
                        $query_grupomaterialinea .= "and gml.codigomateria='" . $row_detalleplanestudio['codigomateria'] . "' ";
                        if($_GET['codigoperiodo']!=""){
                            $query_grupomaterialinea .= "and gml.codigoperiodo='" . $_GET['codigoperiodo'] . "' ";
                        }
                        if($_GET['idgrupomateria']!=""){
                            $query_grupomaterialinea .= "and gml.idgrupomateria='" . $_GET['idgrupomateria'] . "' ";
                        }
                        if($_GET['codigomodalidadacademica']!=""){
                            $query_grupomaterialinea .= "and gm.codigomodalidadacademica='" . $_GET['codigomodalidadacademica'] . "' ";
                        }
                        $grupomaterialinea = $sala->query($query_grupomaterialinea);
                        $row_grupomaterialinea = $grupomaterialinea->fetchRow();
                        $numrowsgrupomaterialinea = $grupomaterialinea->numRows();
                        if ($row_grupomaterialinea['idgrupomaterialinea'] != "") {
                            $array_grupomaterialinea[] = $row_grupomaterialinea['codigomateria'];
                        }
                        ?>
                        <tr>
                            <td><div align="center"><?php echo $row_detalleplanestudio['codigomateria'] ?></div></td>
                            <td><div align="center"><?php echo $row_detalleplanestudio['nombremateria'] ?></div></td>
                            <td><div align="center"><?php echo $row_detalleplanestudio['nombrecarrera'] ?></div></td>
                            <td>
                                <div align="center">
                                    <input type="checkbox" title="materias" name="<?php echo "codigomateria" . $row_detalleplanestudio['codigomateria'] ?>" value="<?php echo $row_detalleplanestudio['codigomateria'] ?>" 
                                        <?php if ($row_grupomaterialinea['idgrupomaterialinea'] != "" and $numrowsgrupomaterialinea == 1) {
                                                echo "checked"; 
                                        } ?>>
                                </div>
                            </td>
                        </tr>
                    <?php } while ($row_detalleplanestudio = $detalleplanestudio->fetchRow()) ?>
                    <tr>
                        <td colspan="3">
                            <div align="center">
                                <input class="btn btn-fill-green-XL" name="Enviar" type="submit" id="Enviar" value="Enviar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input class="btn btn-fill-green-XL" name="Regresar" type="button" id="Regresar" value="Regresar" onclick="location.href = 'grupomateria_listado.php'">		  
                            </div>
                        </td>
                        <td>
                            <div align="center"><span>
                                    <input type="checkbox" name="checkbox" value="checkbox" onClick="HabilitarTodos(this)">
                            </span></div>
                        </td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
</body>
<?php
$borrartodo = true;
$query_verifica_algo = "select gml.idgrupomaterialinea,gml.codigomateria ";
$query_verifica_algo .= "from grupomaterialinea gml ";
$query_verifica_algo .= "inner join grupomateria gm on gm.idgrupomateria=gml.idgrupomateria ";
$query_verifica_algo .= "where 1 ";
if($_GET['codigoperiodo']!=""){
    $query_verifica_algo .= "and gml.codigoperiodo='" . $_GET['codigoperiodo'] . "' ";
}
if($_GET['idgrupomateria']!=""){
    $query_verifica_algo .= "and gml.idgrupomateria='" . $_GET['idgrupomateria'] . "' ";
}
if($_GET['codigomodalidadacademica']!=""){
    $query_verifica_algo .= "and gm.codigomodalidadacademica='" . $_GET['codigomodalidadacademica'] . "' ";
}
$verifica_algo = $sala->query($query_verifica_algo);
$num_rows_verifica_algo = $verifica_algo->numRows();
if (isset($_GET['Enviar'])) {
    //crea arreglo con las materias seleccionadas en el post.
    foreach ($_GET as $vget => $valor) {
        if (ereg("codigomateria", $vget)) {
            $borrartodo = false;
            $codigomateria = $_GET[$vget];
            $array_get[] = $codigomateria;
        }
    }
    //si borrar todo es true, vuela todo
    //No hay nada en BD, por lo tanto debe ingresar todo nuevo
    if ($num_rows_verifica_algo == 0) {
        foreach ($array_get as $inserccion_nueva => $val_inserccion_nueva) {
            $query_insertar_grupomaterialinea = "insert into grupomaterialinea values('','" . $array_get[$inserccion_nueva] . "','" . $_GET['codigoperiodo'] . "','" . $_GET['idgrupomateria'] . "','" . $fechahoy . "','" . $_SESSION['MM_Username'] . "')";
            $insertar_grupomaterialinea = $sala->query($query_insertar_grupomaterialinea);
        }
    }

    if ($borrartodo == true and $row_grupomaterialinea['idgrupomaterialinea'] != "") {
        $query_borrartodo = "delete from grupomaterialinea where codigoperiodo='" . $_GET['codigoperiodo'] . "' and idgrupomateria='" . $_GET['idgrupomateria'] . "'";
        $borrartodo = $sala->query($query_borrartodo);
        if ($borrartodo) {
            echo '<script language="javascript">alert("Datos eliminados correctamente");</script>';
            echo '<script language="javascript">history.go(-1);</script>';
        }
    }
    //si hay algo en bd, y algo en post, debe insertar/actualizar bd
    elseif (isset($array_get) and isset($array_grupomaterialinea)) {
        //se crean arrays para saber que hay que actualizar/eliminar
        $array_eliminar = array_diff($array_grupomaterialinea, $array_get);
        $array_insertar = array_diff($array_get, $array_grupomaterialinea);
    }
    if (isset($array_insertar)) {
        foreach ($array_insertar as $inserccion => $valinserccipn) {
            $query_insertar_grupomaterialinea = "insert into grupomaterialinea values('','" . $array_insertar[$inserccion] . "','" . $_GET['codigoperiodo'] . "','" . $_GET['idgrupomateria'] . "','" . $fechahoy . "','" . $_SESSION['MM_Username'] . "')";
            $insertar_grupomaterialinea = $sala->query($query_insertar_grupomaterialinea);
        }
    }
    if (isset($array_eliminar)) {
        foreach ($array_eliminar as $eliminacion => $valeliminacion) {
            $query_eliminar_grupomaterialinea = "delete from grupomaterialinea where codigomateria='" . $array_eliminar[$eliminacion] . "' and codigoperiodo='" . $_GET['codigoperiodo'] . "' and idgrupomateria='" . $_GET['idgrupomateria'] . "'";
            $eliminar_grupomaterialinea = $sala->query($query_eliminar_grupomaterialinea);
        }
    }
    if ($insertar_grupomaterialinea or $eliminar_grupomaterialinea) {
        echo '<script language="javascript">alert("Datos insertados/actualizados correctamente");</script>';
        echo '<script language="javascript">history.go(-1);</script>';
    }
}
//ebd
?>