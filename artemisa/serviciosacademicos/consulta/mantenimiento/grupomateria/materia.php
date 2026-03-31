<?php
/*
 * Ajustes de limpieza codigo y modificacion de interfaz
 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Universidad el Bosque - Direccion de Tecnologia.
 * Modificado 14 de Noviembre de 2017.
 */
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php'); 
    $rutaado = "../../../funciones/adodb/";
    require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado.php');

$fechahoy = date("Y-m-d H:i:s");
$varguardar = 0;
$vardetalle = 0;
/* Consulta para seleccionar el periodo de origen */
$query_codigoperiodo = "SELECT codigoperiodo FROM periodo order by codigoperiodo desc";
$codigoperiodo = $db->Execute($query_codigoperiodo);
$totalRows_codigoperiodo = $codigoperiodo->RecordCount();

/* Verificación y consulta para imprimir un radio button con el que  se va a seleccionar la copia del detalle */
if (isset($_REQUEST['periododestino'])) {
    if ($_REQUEST['periododestino'] != '') {
        $query_activos = "select d.iddetallegrupomateria, d.idgrupomateria  FROM detallegrupomateria d, grupomateria g 
                                   where g.idgrupomateria = d.idgrupomateria
                                   and g.codigoperiodo='" . $_REQUEST['periododestino'] . "'
                                   and d.idgrupomateria = '" . $row_destino['idgrupomateria'] . "'
                                    group by 2";
        $activos = $db->Execute($query_activos);
        $totalRows_activos = $activos->RecordCount();
        $row_activos = $activos->FetchRow();

        $query_activos3 = "select *  FROM grupomateria  where codigoperiodo='" . $_REQUEST['periododestino'] . "'";
        $activos3 = $db->Execute($query_activos3);
        $totalRows_activos3 = $activos3->RecordCount();
        $row_activos3 = $activos3->FetchRow();
        if ($totalRows_activos == 0 && $totalRows_activos3 != '') {
            $existe = true;
        }
    }
}

/* Valida que exista seleecionado un periodo de origen y cuando ya esta seleccionado hace el ciclo de consultas y guarda la copia */
if (isset($_GET['grabar']) && $_GET['grabar'] != '') {

    if ($_GET['periododestino'] == "") {
        echo '<script language="JavaScript">alert("Debe Seleccionar el Periodo de Destino")</script>';
        $varguardar = 1;
    } elseif ($varguardar == 0) {
        $query_prueba = "SELECT idgrupomateria, nombregrupomateria, codigoperiodo, codigotipogrupomateria  FROM grupomateria where codigoperiodo = '" . $_REQUEST['codigoperiodo'] . "'";
        $prueba = $db->Execute($query_prueba) or die("$query_prueba" . mysql_error());
        $totalRows_prueba = $prueba->RecordCount();
        //$row_prueba = $prueba->FetchRow();


        while ($row_prueba = $prueba->FetchRow()) {
            $query_insertargrupomateria = "INSERT INTO grupomateria (idgrupomateria, nombregrupomateria, codigoperiodo, codigotipogrupomateria) values (0, '" . $row_prueba['nombregrupomateria'] . "', '" . $_REQUEST['periododestino'] . "', '" . $row_prueba['codigotipogrupomateria'] . "')";
            $insertargrupomateria = $db->Execute($query_insertargrupomateria) or die("$query_insertargrupomateria" . mysql_error());

            $idgrupomaterianuevo['idgrupomateria'] = $db->Insert_ID();

            $query_seleccionargrupomaterialinea = "SELECT idgrupomaterialinea, codigomateria, codigoperiodo, idgrupomateria, fechagrupomaterialinea, usuario FROM grupomaterialinea where codigoperiodo = '" . $_REQUEST['codigoperiodo'] . "'
                and idgrupomateria = '" . $row_prueba['idgrupomateria'] . "'";
            $seleccionargrupomaterialinea = $db->Execute($query_seleccionargrupomaterialinea) or die("$query_seleccionargrupomaterialinea" . mysql_error());
            $totalRows_seleccionargrupomaterialinea = $seleccionargrupomaterialinea->RecordCount();

            while ($row_seleccionargrupomaterialinea = $seleccionargrupomaterialinea->FetchRow()) {
                $query_insertargrupomaterialinea = "INSERT INTO grupomaterialinea (idgrupomaterialinea, codigomateria, codigoperiodo, idgrupomateria, fechagrupomaterialinea, usuario) values (0, '{$row_seleccionargrupomaterialinea['codigomateria']}','" . $_REQUEST['periododestino'] . "', '" . $idgrupomaterianuevo['idgrupomateria'] . "', now(), '{$row_seleccionargrupomaterialinea['usuario']}')";
                $insertargrupomaterialinea = $db->Execute($query_insertargrupomaterialinea) or die("$query_insertargrupomaterialinea" . mysql_error());
            }


            if (isset($_REQUEST['uno'])) {
                $query_detallegrupomateria = "SELECT iddetallegrupomateria, idgrupomateria, codigomateria FROM detallegrupomateria  where idgrupomateria = '" . $row_prueba['idgrupomateria'] . "'";
                $detallegrupomateria = $db->Execute($query_detallegrupomateria) or die("$query_detallegrupomateria" . mysql_error());
                $totalRows_detallegrupomateria = $detallegrupomateria->RecordCount();

                while ($row_detallegrupomateria = $detallegrupomateria->FetchRow()) {
                    $query_insertardetallegrupomateria = "INSERT INTO detallegrupomateria (iddetallegrupomateria, idgrupomateria, codigomateria) values (0, '" . $idgrupomaterianuevo['idgrupomateria'] . "', '" . $row_detallegrupomateria['codigomateria'] . "')";
                    $insertardetallegrupomateria = $db->Execute($query_insertardetallegrupomateria) or die("$query_insertardetallegrupomateria" . mysql_error());
                }
            }
        }

        echo "<script language='javascript'> alert('Se ha guardado la información correctamente');  </script>";
    }
}

/* Valida que existe un periodo de origen y uno de destino. Se ejecutan las consultas e inserta el detallegrupomateria */
if (isset($_GET['guardar']) && $_GET['guardar'] != '') {

    if ($_GET['origen'] == 0) {
        echo '<script language="JavaScript">alert("Debe Seleccionar una Opción de Origen")</script>';
        $varguardar = 1;
    } elseif ($_GET['destino'] == 0) {
        echo '<script language="JavaScript">alert("Debe Seleccionar una Opción de Destino")</script>';
        $varguardar = 1;
    } elseif ($varguardar == 0) {
        $query_origen = "SELECT codigomateria FROM detallegrupomateria where idgrupomateria = '" . $_REQUEST['origen'] . "'";
        $origen = $db->Execute($query_origen) or die("$query_origen" . mysql_error());
        $totalRows_origen = $origen->RecordCount();

        while ($row_origen = $origen->FetchRow()) {
            $query_insertardetalle = "INSERT INTO detallegrupomateria (iddetallegrupomateria, idgrupomateria, codigomateria) values (0, '" . $_REQUEST['destino'] . "', '" . $row_origen['codigomateria'] . "')";
            $insertardetalle = $db->Execute($query_insertardetalle) or die("$query_insertardetalle" . mysql_error());
        }
           echo '<script language="JavaScript">alert("La copia se realizo Correctamente.")</script>'; 
    }
}


$rutaJS = "../../sic/librerias/js/";
?>

<html>
    <head>
        <title></title>
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/normalize.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/font-page.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/font-awesome.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/general.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/chosen.css">
        <script type="text/javascript" src="../../../../assets/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="../../../../assets/js/bootstrap.js"></script> 
        <script src="<?php echo $rutaJS; ?>jquery-3.6.0.js" type="text/javascript"></script>
        <script language="javascript">
            function cambio()
            {
                document.form1.submit();
            }
            /*JavaScript de confirmación para generar la copia del grupo de materias*/
            function confirmar() {
                if (confirm('¿Está seguro de Generar el Grupo de Materias para el Periodo Seleccionado?')) {
                    document.getElementById('grabar').value = 'ok';
                    document.form1.submit();
                }
            }
            /*JavaScript de confirmación para generar la copia del detalle grupo materias*/
            function generadetalle() {
                if (confirm('¿Está seguro de Generar el Detalle de Grupo Materias de Acuerdo a la Opción que Selecciono?')) {
                    document.getElementById('guardar').value = 'ok';
                    document.form1.submit();
                }
            }

            /*JavaScript para el checkbox. Confirma si quiere la copia sin grupo materias*/
            function detalle() {
                if (document.getElementById('uno').checked == false) {
                    if (confirm('¿Esta Seguro de No generar el detalle grupo materias?. Si confirma deberá hacer el proceso en el modo editar')) {
                        document.getElementById('uno').checked = false;
                    } else {
                        document.getElementById('uno').checked = true;
                    }
                }
            }

            /*Jquery para crear el botón que genera la copia del detallegrupomateria*/
            $(document).ready(function () {
                $("input[type='radio']").click(function () {
                    var boton = $("#crearboton");
                    boton.html('<label id="labelresaltado">GENERAR DETALLE GRUPO MATERIA </label><input type="hidden" value="" name="guardar" id="guardar"><input class="btn btn-fill-green-XL" type="button" value="Generar" onclick="return generadetalle()">');
                })
            })
        </script>
    </head> 
    <body>        
        <div class="container">
            <form name="form1" id="form1"  method="get">

                <center><h2>LISTADO GRUPO MATERIA</h2></center>
                <br>
                <div class="table-responsive">
                    <table class="table">
                        <tr bgcolor="#CCDADD">
                            <th><div align="center">SELECCIONE EL PERIODO ORIGEN</div></th>
                            <th>
                                <div>
                                    <select name="codigoperiodo" id="codigoperiodo" onchange="cambio()" >
                                        <option value="">Seleccionar</option>
                                        <?php while ($row_codigoperiodo = $codigoperiodo->FetchRow()) { ?>
                                            <option value="<?php echo $row_codigoperiodo['codigoperiodo']; ?>"
                                                <?php
                                                if ($row_codigoperiodo['codigoperiodo'] == $_GET['codigoperiodo']) {
                                                    echo "Selected";
                                                }
                                                ?>>
                                                <?php echo $row_codigoperiodo['codigoperiodo']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </th>
                        </tr>
                    </table>
                    <?php
                    if (isset($_REQUEST['codigoperiodo'])) {
                        if ($_REQUEST['codigoperiodo'] != '') {
                            $query = "select idgrupomateria, nombregrupomateria, codigoperiodo
                            from grupomateria
                            where codigoperiodo = '" . $_REQUEST['codigoperiodo'] . "'
                            order by nombregrupomateria asc ";
                            $rta = $db->Execute($query);
                            $totalRows_rta = $rta->RecordCount();
                            $row_rta = $rta->FetchRow();
                            if ($totalRows_rta != '') {
                                ?>
                                <table class="table">
                                    <tr bgcolor="#CCDADD">
                                        <td align="center"><label id="labelresaltado">NOMBRE GRUPO MATERIA </label></td>
                                        <td align="center"><label id="labelresaltado">PERIODO</label></td>  
                                        <?php if (isset($existe)) { ?>
                                        <td align="center"><label id="labelresaltado">DETALLE ORIGEN </label></td>
                                        <?php } ?>                                                                  
                                    </tr>
                                    <?php do { ?>
                                        <tr>
                                            <td align="center"><?php echo $row_rta['nombregrupomateria']; ?></td>
                                            <td align="center"><?php echo $row_rta['codigoperiodo']; ?></td>
                                            <?php if (isset($existe)) { ?>
                                                <td align="center"><input type="radio" name="origen" value="<?php echo $row_rta['idgrupomateria']; ?>"></td>
                                            <?php } ?>
                                        </tr>
                                    <?php } while ($row_rta = $rta->FetchRow());?>
                                    </table>
                                        <?php
                                        /* Selección del periodo de destino muestra los periodos mayores al perido seleccionado de origen */
                                        $query_periododestino = "SELECT p.codigoperiodo FROM periodo p
                                                                where  p.codigoperiodo > '" . $_REQUEST['codigoperiodo'] . "'";
                                        $periododestino = $db->Execute($query_periododestino);
                                        $totalRows_periododestino = $periododestino->RecordCount();
                                        if ($totalRows_periododestino != '') {
                                            ?>
                                            <table class="table">
                                                <tr bgcolor="#CCDADD">
                                                    <th align="center"><div align="center">SELECCIONE EL PERIODO DESTINO O PERIODO A EDITAR</div></th>
                                                    <th>
                                                        <div>
                                                            <select name="periododestino" id="periododestino" onchange="cambio()">
                                                                <option value="">Seleccionar</option>
                                                                <?php while ($row_periododestino = $periododestino->FetchRow()) { ?>
                                                                    <option value="<?php echo $row_periododestino['codigoperiodo']; ?>"
                                                                    <?php
                                                                    if ($row_periododestino['codigoperiodo'] == $_GET['periododestino']) {
                                                                        echo "Selected";
                                                                    }
                                                                    ?>>
                                                                    <?php echo $row_periododestino['codigoperiodo']; ?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </th>
                                                </tr>
                                            </table>
                                            <table class="table">
                                                <?php
                                                    if (isset($_REQUEST['periododestino'])) {
                                                        if ($_REQUEST['periododestino'] != '') {
                                                        $query_destino = "select idgrupomateria, nombregrupomateria, codigoperiodo
                                                        from grupomateria
                                                        where codigoperiodo = '" . $_REQUEST['periododestino'] . "'
                                                        order by nombregrupomateria asc ";
                                                        $destino = $db->Execute($query_destino);
                                                        $totalRows_destino = $destino->RecordCount();
                                                        $row_destino = $destino->FetchRow();
                                                        /*
                                                        * Caso 90458
                                                        * @modified Luis Dario Gualteros 
                                                        * <castroluisd@unbosque.edu.co>
                                                        * Se elimina la variable $totalRows_destino vacia con el fin que permita realizar la copia del detalle del * grupo sin duplicar el grupo.
                                                        * @since Mayo 31 de 2017
                                                        */
                                                        //$totalRows_destino = ''; 
                                                        // End caso 90458
                                                        if($totalRows_destino !=''){                                

                                                            $query_activos2 = "select d.iddetallegrupomateria, d.idgrupomateria  FROM detallegrupomateria d, grupomateria g where g.idgrupomateria = d.idgrupomateria
                                                            and g.codigoperiodo='" . $_REQUEST['periododestino'] . "'
                                                            group by 2";
                                                            $activos2 = $db->Execute($query_activos2);
                                                            $totalRows_activos2 = $activos2->RecordCount();
                                                            $row_activos2 = $activos2->FetchRow();
                                                            $checked2 = "";
                                                            $disabled2 = "";
                                                            if ($totalRows_activos2 > 0) {
                                                                $checked2 = 'checked';
                                                                $disabled2 = 'disabled';
                                                            } else {
                                                                $existe = true;
                                                            }
                                                            ?>  
                                                            <tr bgcolor="#CCDADD">
                                                                <th align="center"><label id="labelresaltado">NOMBRE GRUPO MATERIA </label></th>
                                                                <th align="center"><label id="labelresaltado">PERIODO</label></th>
                                                                <th id="crearboton" align="center"><label id="labelresaltado">GENERAR DETALLE GRUPO MATERIA</label></th>
                                                            </tr>
                                                    <?php   do { ?>
                                                                <tr>
                                                                    <td align="center"><?php echo $row_destino['nombregrupomateria']; ?></td>
                                                                    <td align="center"><?php echo $row_destino['codigoperiodo']; ?></td>     
                                                                    <td align="center">
                                                                    <?php
                                                                    $query_activos4 = "select d.iddetallegrupomateria, d.idgrupomateria  FROM detallegrupomateria d, grupomateria g 
                                                                       where g.idgrupomateria = d.idgrupomateria
                                                                       and g.codigoperiodo='" . $_REQUEST['periododestino'] . "'
                                                                       and d.idgrupomateria = '" . $row_destino['idgrupomateria'] . "'
                                                                        group by 2";

                                                                    $activos4 = $db->Execute($query_activos4);
                                                                    $totalRows_activos4 = $activos4->RecordCount();
                                                                    $row_activos2 = $activos2->FetchRow();

                                                                    if ($totalRows_activos4 == 0) { ?> 
                                                                            <input type="radio" name="destino" value="<?php echo $row_destino['idgrupomateria']; ?>" >
                                                                    <?php } ?>
                                                                    </td>
                                                                </tr>
                                                        <?php   } while ($row_destino = $destino->FetchRow());
                                                            } else {
                                                            ?>
                                                            <tr>                                            
                                                                <td align="center" colspan="2">Generar Con Detalle Grupo Materia 
                                                                    <input type="checkbox" name="uno" id="uno" checked="true" onclick="detalle()" >
                                                                </td>
                                                                <td align="center" colspan="2">
                                                                    <input type="hidden" value="" name="grabar" id="grabar">
                                                                    <input type="button" class="btn btn-fill-green-XL" value="Generar" onclick="return confirmar()">
                                                                </td>
                                                            </tr>
                                                        <?php
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    echo '<script language="JavaScript">alert("No Existen Periodos de Destino ")</script>';
                                                }
                                                ?>
                                            </table>
                                    <?php
                                } else {
                                    echo '<script language="JavaScript">alert("El Periodo Seleccionado no Contiene Grupo de Materias Asignadas por favor Seleccione otro Periodo")</script>';
                                }
                            }
                        }
                        ?>
                    <table class="table">
                        <tr>
                            <td align="center"><input class="btn btn-fill-green-XL" type="button" value="Regresar" onclick="window.location.href = 'grupomateria_listado.php'"></td>
                        </tr>
                    </table>
                </div>
            </form>
        </div>
    </body>
</html>
<!--end-->