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
require_once(realpath(dirname(__FILE__)) . '/../../../funciones/clases/autenticacion/redirect.php');

$config = parse_ini_file('../funciones/conexion/basedatos.ini', TRUE);
$config['DB_DataObject']['database'] = "mysql://" . $username_sala . ":" . $password_sala . "@" . $hostname_sala . "/" . $database_sala;
foreach ($config as $class => $values) {
    $options = &PEAR::getStaticProperty($class, 'options');
    $options = $values;
}

class filtro {

    var $columnas = array();

    function crear_filtro($query_base) {
        $this->query_base = $query_base;
    }

    function agregarcolumna($nombrecolumna, $nombrecolumnab, $valorcolumna, $tipobusqueda, $abre,$cierra) { //puede ser cadena manda like, o normal manda =,
        if ($valorcolumna != "") {
            $this->columnas['nombrecolumna'] = $nombrecolumna;
            $this->columnas['nombrecolumnab'] = $nombrecolumnab;
            $this->columnas['valorcolumna'] = $valorcolumna;
            $this->columnas['tipobusqueda'] = $tipobusqueda;
            $this->columnas['abre'] = $abre;
            $this->columnas['cierra'] = $cierra;
            $this->arraycolumnas[] = $this->columnas;
        }
    }

    function filtrar() {
        error_reporting(2048);
        foreach ($this->arraycolumnas as $key => $valor) {
            $porciento = "";
            if ($valor['tipobusqueda'] == 'like') {
                $porciento = "%";
            }
            $query_columna="";
            if ($valor['abre'] != '' && $valor['cierra'] != '') {
            $query_columna .= " AND " . $valor['abre'] . " " . $valor['nombrecolumna'] . " " . $valor['tipobusqueda'] . " '" . $porciento . $valor['valorcolumna'] . $porciento . "' ";
            $query_columna .= " OR  " . $valor['nombrecolumnab'] . " " . $valor['tipobusqueda'] . " '" . $porciento . $valor['valorcolumna'] . $porciento . "' " . $valor['cierra'] ." ";
            }else{
            $query_columna .= " AND " . $valor['nombrecolumna'] . " " . $valor['tipobusqueda'] . " '" . $porciento . $valor['valorcolumna'] . $porciento . "'";
            }
            $query_filtro = $query_filtro . $query_columna;
        }
        $query_filtrado = $this->query_base . $query_filtro;
        return $query_filtrado;
    }

}

$fechahoy = date("Y-m-d H:i:s");
$query_detallegrupomateria = "SELECT DISTINCT m.nombremateria,m.codigomateria,c.nombrecarrera,tm.nombretipomateria
FROM materia m,carrera c,tipomateria tm
WHERE 
m.codigocarrera=c.codigocarrera
AND m.codigotipomateria=tm.codigotipomateria
AND m.codigoestadomateria='01'
";
if ($_GET['codigotipomateria']!=""){
$cods = str_replace("-", ",", $_GET['codigotipomateria']);
$query_detallegrupomateria.="AND m.codigotipomateria IN(".$cods.") ";
}
$cquery_detallegrupomateria=" ORDER BY m.codigotipomateria,m.nombremateria ASC";
if (isset($_GET['Filtrar']) and $_GET['Filtrar'] == 'Filtrar') {
    $mifiltro = new filtro;
    $mifiltro->query_base = ($query_detallegrupomateria);
    $mifiltro->agregarcolumna("m.codigomateria", "m.nombremateria", $_GET['f_nombremateria'], "like" ,"(" ,")");
    $mifiltro->agregarcolumna("m.codigocarrera", "", $_GET['f_codigocarrera'], "=" ,"" ,"");
    $mifiltro->agregarcolumna("tm.codigotipomateria", "", $_GET['f_codigotipomateria'], "=" ,"" ,"");
    $filtro = $mifiltro->filtrar();
    $filtro .= $cquery_detallegrupomateria;
    $detallegrupomateria = $sala->query($filtro);
    $row_detallegrupomateria = $detallegrupomateria->fetchRow();
} else {
    $query_detallegrupomateria .= $cquery_detallegrupomateria;
    $detallegrupomateria = $sala->query($query_detallegrupomateria);
    $row_detallegrupomateria = $detallegrupomateria->fetchRow();
}
?>

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
        for (var i = 0; i < document.forms[1].elements.length; i++)
        {
            var elemento = document.forms[1].elements[i];
            if (elemento.type == "checkbox")
            {
                if (elemento.title == "selcodigomateria")
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
    function restablecer()
    {
        location.href = "redireccion.php?idgrupomateria=<?php echo $_GET['idgrupomateria'] ?>&codigotipomateria=4-5&nombregrupomateria=<?php echo $_GET['nombregrupomateria'] ?>&flag=1";
    }
</script>

<body>
    <div class="container">
        <form name="form1" method="get" id="form1">
            <center><h2>LISTADO DE MATERIAS ASOCIADAS A GRUPO</h2></center>
            <br>
            <div align="center" class="Estilo3">
                <input type="hidden" name="idgrupomateria" id="idgrupomateria" value="<?php echo $_GET['idgrupomateria'] ?>">
                <input type="hidden" name="nombregrupomateria" id="nombregrupomateria" value="<?php echo $_GET['nombregrupomateria'] ?>">
                <input type="hidden" name="Filtrar" id="Filtrar" value="<?php echo $_GET['Filtrar'] ?>">
                <input type="hidden" name="f_codigocarrera" id="f_codigocarrera" value="<?php echo $_GET['f_codigocarrera'] ?>">
                <input type="hidden" name="f_nombremateria" id="f_nombremateria" value="<?php echo $_GET['f_nombremateria'] ?>">			                
            </div>            
            <div class="row">
                <div class="col-md-2">
                    <h3>Materia:</h3>
                </div>
                <div class="col-md-4">
                    <input name="f_nombremateria" type="text" id="f_nombremateria" value="<?php echo $_GET['f_nombremateria'] ?>" size="40">
                </div>
                <div class="col-md-2">
                    <h3>Tipo:</h3> 
                </div>
                <div class="col-md-3">
                    <br>
                    <?php combo_valida_get("f_codigotipomateria", "tipomateria", "codigotipomateria", "nombretipomateria", "class='form-control'", "", "nombretipomateria asc", "no", "tipomateria") ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <h3>Carrera:</h3>
                </div>
                <div class="col-md-3">
                    <br>
                    <?php combo_valida_get("f_codigocarrera", "carrera", "codigocarrera", "nombrecortocarrera", "class='form-control'", "fechainiciocarrera <= '" . $fechahoy . "' and fechavencimientocarrera >= '" . $fechahoy . "'", "nombrecarrera asc", "no", "carrera") ?>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-2">
                    <br>
                    <input class="btn btn-fill-green-XL" name="Filtrar" type="submit" id="Filtrar" value="Filtrar">
                </div>
            </div>
            <div>
                <table class="table">
                    <tr bgcolor="#CCDADD">
                        <th colspan="5">
                            <div align="center">
                                <span class="Estilo3">GRUPO&nbsp;<?php echo $_GET['nombregrupomateria'] ?></span>
                            </div>
                        </th>
                    </tr>
                    <tr bgcolor="#CCDADD">
                        <th><div align="center">
                                <span class="Estilo2">
                                    <input type="checkbox" name="checkbox" value="checkbox" onClick="HabilitarTodos(this)">
                                </span>
                            </div>
                        </th>
                        <th><div align="center">COD</div></th>
                        <th><div align="center">Materia</div></th>
                        <th><div align="center">Tipo</div></th>
                        <th><div align="center">Carrera</div></th>
                    </tr>
                    </form>
                    <form name="form2" method="post" action="">
                        <?php
                        do {
                            $query_verifica_chequeado = "SELECT idgrupomateria,codigomateria ";
                            $query_verifica_chequeado .= "FROM detallegrupomateria dgm ";
                            $query_verifica_chequeado .= "WHERE idgrupomateria='" . $_GET['idgrupomateria'] . "' ";
                            $query_verifica_chequeado .= "AND codigomateria='" . $row_detallegrupomateria['codigomateria'] . "' ";
                            $verifica_chequeado = $sala->query($query_verifica_chequeado);
                            $totalRows_verifica_chequeado = $verifica_chequeado->numRows();
                            $row_verifica_chequeado = $verifica_chequeado->fetchRow();
                            //crea array con lo que hay en bd
                            if ($row_verifica_chequeado['idgrupomateria'] != "") {
                                $array_detallegrupomateria[] = $row_verifica_chequeado['codigomateria'];
                            }
                            ?>
                            <tr>
                                <td>
                                    <div align="center">
                                        <input type="checkbox" title="selcodigomateria" name="<?php echo "selcodigomateria" . $row_detallegrupomateria['codigomateria'] ?>" value="<?php echo $row_detallegrupomateria['codigomateria'] ?>" <?php
                                        if ($totalRows_verifica_chequeado == 1) {
                                            echo "Checked";
                                        }
                                        ?>>
                                    </div>
                                </td>
                                <td><div align="center"><?php echo $row_detallegrupomateria['codigomateria'] ?></div></td>
                                <td><div align="center"><?php echo $row_detallegrupomateria['nombremateria']; ?></div></td>
                                <td><div align="center"><?php echo $row_detallegrupomateria['nombretipomateria']; ?></div></td>
                                <td><div align="center"><?php echo $row_detallegrupomateria['nombrecarrera']; ?></div></td>
                            </tr>
                        <?php } while ($row_detallegrupomateria = $detallegrupomateria->fetchRow()) ?>
                        <tr>
                            <td colspan="5">
                                <div align="center">
                                    <input class="btn btn-fill-green-XL" name="Enviar" type="submit" id="Enviar" value="Enviar">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input class="btn btn-fill-green-XL" name="Restablecer" type="button" id="Restablecer" value="Restablecer" onclick="restablecer();">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input class="btn btn-fill-green-XL" name="Regresar" type="button" id="Regresar" value="Regresar" onclick="location.href = 'detallegrupomateria_actual.php?idgrupomateria=<?php echo $_GET['idgrupomateria'] ?>&nombregrupomateria=<?php echo $_GET['nombregrupomateria'] ?>'">
                                </div>
                            </td>
                        </tr>
                </table>
            </div>
        </form>
    </div>
</body>
<?php
$borrartodo = true;
$query_verifica_algo = "SELECT dgm.idgrupomateria,dgm.codigomateria ";
$query_verifica_algo .= "FROM detallegrupomateria dgm, materia m,carrera c,tipomateria tm ";
$query_verifica_algo .= "WHERE dgm.idgrupomateria='" . $_GET['idgrupomateria'] . "' ";
$query_verifica_algo .= "AND dgm.codigomateria=m.codigomateria ";
$query_verifica_algo .= "AND m.codigotipomateria=tm.codigotipomateria ";
$query_verifica_algo .= "AND m.codigocarrera=c.codigocarrera ";
$query_verifica_algo .= "AND m.codigoestadomateria='01' ";
if($_GET['f_nombremateria']!=""){
$query_verifica_algo .= "AND (dgm.codigomateria like '%" . $_GET['f_nombremateria'] . "%' ";
$query_verifica_algo .= "OR m.nombremateria like '%" . $_GET['f_nombremateria'] . "%') ";
}
if($_GET['f_codigotipomateria']!=""){
$query_verifica_algo .= "AND tm.codigotipomateria = '" . $_GET['f_codigotipomateria'] . "' ";
}
if($_GET['f_codigocarrera']!=""){
$query_verifica_algo .= "AND m.codigocarrera='" . $_GET['f_codigocarrera'] . "' ";
}
$verifica_algo = $sala->query($query_verifica_algo);
$num_rows_verifica_algo = $verifica_algo->numRows();

if (isset($_POST['Enviar'])) {
    //crea arreglo con las materias seleccionadas en el post.
    foreach ($_POST as $vpost => $valor) {

        if (ereg("selcodigomateria", $vpost)) {
            $borrartodo = false;
            $codigomateria = $_POST[$vpost];
            $array_post[] = $codigomateria;
        }
    }
    //si borrar todo es true, vuela todo
    //No hay nada en BD, por lo tanto debe ingresar todo nuevo
    if ($num_rows_verifica_algo == 0) {
        foreach ($array_post as $inserccion_nueva => $val_inserccion_nueva) {
            $query_insertar_detallegrupomateria_nuevo = "insert into detallegrupomateria values('','" . $_GET['idgrupomateria'] . "','" . $array_post[$inserccion_nueva] . "')";
            $insertar_detallegrupomateria = $sala->query($query_insertar_detallegrupomateria_nuevo);
        }
    } elseif ($borrartodo == true and $num_rows_verifica_algo != 0) {
        $query_borrartodo = "delete from detallegrupomateria where idgrupomateria='" . $_GET['idgrupomateria'] . "'";
        $borrartodo = $sala->query($query_borrartodo);
        if ($borrartodo) {
            echo '<script language="javascript">alert("Datos eliminados correctamente");</script>';
            echo '<script language="javascript">history.go(-1);</script>';
        }
    }
    //si hay algo en bd, y algo en post, debe insertar/actualizar bd
    elseif (isset($array_post) and isset($array_detallegrupomateria)) {
        //se crean arrays para saber que hay que actualizar/eliminar
        $array_eliminar = array_diff($array_detallegrupomateria, $array_post);
        $array_insertar = array_diff($array_post, $array_detallegrupomateria);
    }
    if (isset($array_insertar)) {
        foreach ($array_insertar as $inserccion => $valinserccipn) {
            $query_insertar_detallegrupomateria = "insert into detallegrupomateria values('','" . $_GET['idgrupomateria'] . "','" . $array_insertar[$inserccion] . "')";
            $insertar_detallegrupomateria = $sala->query($query_insertar_detallegrupomateria);
        }
    }
    if (isset($array_eliminar)) {
        foreach ($array_eliminar as $eliminacion => $valeliminacion) {
            $query_eliminar_detallegrupomateria = "delete from detallegrupomateria where idgrupomateria='" . $_GET['idgrupomateria'] . "' and codigomateria='" . $array_eliminar[$eliminacion] . "'";
            $eliminar_detallegrupomateria = $sala->query($query_eliminar_detallegrupomateria);
        }
    }
    if ($insertar_detallegrupomateria or $eliminar_detallegrupomateria) {
        echo '<script language="javascript">alert("Datos insertados/actualizados correctamente");</script>';
        if($_GET['Filtrar']!="" || $_GET['f_nombremateria']!="" || $_GET['f_codigocarrera']!="" || $_GET['f_codigotipomateria']!=""){
        echo '<script language="Javascript">location.href="redireccion.php?flag=2&idgrupomateria=' . $_GET['idgrupomateria'] . '&nombregrupomateria=' . $_GET['nombregrupomateria'] . '&Filtrar=' . $_GET['Filtrar'] . '&f_nombremateria=' . $_GET['f_nombremateria'] . '&f_codigocarrera=' . $_GET['f_codigocarrera'] . '&f_codigotipomateria=' . $_GET['f_codigotipomateria'] . '";</script>';
        }else{
        echo '<script language="Javascript">location.href="redireccion.php?flag=2&idgrupomateria=' . $_GET['idgrupomateria'] . '&codigotipomateria=4-5&nombregrupomateria=' . $_GET['nombregrupomateria'] . '";</script>';
        }
    }
}
//end
?>