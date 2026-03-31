<?php
session_start();
$fechahoy=date("Y-m-d H:i:s");
require_once('../../../../Connections/sala2.php');
$rutaado = "../../../../funciones/adodb/";
require_once('../../../../Connections/salaado.php');
if(!isset ($_SESSION['MM_Username'])){

echo "No tiene permiso para acceder a esta opción";
exit();
}
/*if($_REQUEST['tipogeneracion']==""){
    echo "<script language='javascript'> alert('Seleccione una Opción.');
          window.location.href = 'seleccion_impresion.php'; </script>";
}*/
if($_REQUEST['tipogeneracion']=='') {
    echo "<script language='javascript'>
    alert('Debe seleccionar una opción');
    window.location.href='seleccion_impresion.php';
    </script>";               
}
$varguardar = 0;
    if(isset ($_REQUEST['buscar'])){
        if($_POST['desde']==''){
            echo '<script language="JavaScript">alert("La busqueda de tener  Desde y Hasta")</script>';
            $varguardar = 1;
        }
        elseif ($_POST['hasta']==''){
            echo '<script language="JavaScript">alert("La busqueda de tener  Desde y Hasta")</script>';
            $varguardar = 1;
        }
        elseif ($varguardar == 0) {
            $filtroIdRegistro = "";
                    $filtroCodigo = "";
                    $filtroNombre = "";
                    $filtroDocumento = "";
                    $filtroTitulo = "";
                        if(isset($_REQUEST['registro'])) {
                        $filtroIdRegistro = " and rg.idregistrograduado like '%".$_REQUEST['registro']."%'";
                    }
                    if(isset($_REQUEST['codigo'])) {
                        $filtroCodigo = " and e.codigoestudiante like '%".$_REQUEST['codigo']."%'";
                    }
                    if(isset($_REQUEST['nombreestudiante'])) {
                        $filtroNombre = " and concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) like '%".$_REQUEST['nombreestudiante']."%'";
                    }
                    if(isset($_REQUEST['doc'])) {
                        $filtroDocumento = " and eg.numerodocumento like '%".$_REQUEST['doc']."%'";
                    }
                    if(isset($_REQUEST['titulo'])) {
                        $filtroTitulo = " and t.nombretitulo like '%".$_REQUEST['titulo']."%'";
                    }
            /*$query_folio ="SELECT drgf.idregistrograduado,rgf.idregistrograduadofolio
                    FROM
                    registrograduadofolio rgf, detalleregistrograduadofolio drgf
                    WHERE
                    rgf.idregistrograduadofolio=drgf.idregistrograduadofolio
                    AND rgf.idregistrograduadofolio>='".$_POST['desde']."'
                    AND rgf.idregistrograduadofolio<='".$_POST['hasta']."'
                    ORDER BY drgf.idregistrograduado";*/
                    $query_folio = "SELECT ft.folio, e.codigoestudiante, e.codigocarrera, rg.idregistrograduado,
                            rg.codigoestado, concat(eg.apellidosestudiantegeneral,' ', eg.nombresestudiantegeneral) AS 'nombre',
                            eg.numerodocumento, eg.expedidodocumento as 'expedicion', c.nombrecarrera AS 'programa',
                            t.nombretitulo, rg.numerodiplomaregistrograduado AS 'diploma', rg.numeropromocion as 'numeropromocion',
                            rg.numeroactaregistrograduado AS 'numeroacta', fechaactaregistrograduado as 'fechaacta',
                            rg.numeroacuerdoregistrograduado as 'numeroacuerdo', rg.fechaacuerdoregistrograduado as 'fechaacuerdo',
                            rg.fechagradoregistrograduado as 'fechagrado', rg.codigoestado, rg.codigoautorizacionregistrograduado, c.codigomodalidadacademica
                            FROM registrograduado rg, estudiantegeneral eg, estudiante e, carrera c, titulo t, foliotemporal ft
                            WHERE
                            rg.codigoestudiante=e.codigoestudiante
                            AND e.idestudiantegeneral=eg.idestudiantegeneral
                            AND e.codigocarrera=c.codigocarrera
                            AND c.codigotitulo=t.codigotitulo
                            AND rg.idregistrograduado=ft.idregistrograduado
                            AND ft.folio>='".$_POST['desde']."'
                            AND ft.folio<='".$_POST['hasta']."'
                            $filtroIdRegistro
                            $filtroCodigo
                            $filtroNombre
                            $filtroDocumento
                            $filtroTitulo
                            ORDER BY rg.idregistrograduado";
            $folio= $db->Execute($query_folio) or die("$query_folio".mysql_error());
            $totalRows_folio = $folio->RecordCount();
            $row_folio = $folio->FetchRow();
        }
    }

?>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../../../estilos/sala.css" type="text/css">
        <input type="hidden" name="tipogeneracion" value="<?php echo $_REQUEST['tipogeneracion']; ?>">

    </head>
    <body>
        <form name="form1" id="form1"  method="POST" action="">
            <input type="hidden" name="tipogeneracion" value="<?php echo $_REQUEST['tipogeneracion']; ?>">
            <table width="50%"  border="0"  cellpadding="3" cellspacing="3">
                <TR >
                    <TD align="center">
                        <label id="labelresaltadogrande" >Generación de Diplomas <?php if($_REQUEST['tipogeneracion']=="generacionmasiva"){ echo " Masiva"; }
                        else if($_REQUEST['tipogeneracion']=="generacionestudiante"){ echo " por Estudiante"; }
                        else if($_REQUEST['tipogeneracion']=="generacionduplicado"){ echo " Duplicados por Estudiante"; }
                        ?>
                        </label>
                    </TD>
                </TR>
            </table>
            <table width="50%"  border="1"  cellpadding="3" cellspacing="3">
                <TR >
                    <TD id="tdtitulogris" colspan="6">Busqueda de Folios
                    </TD>
                </TR>
                <TR>
                    <TD id="tdtitulogris" >Folio Desde:
                    </TD>
                    <TD colspan="2"><input type="text" name="desde" value="<?php if ($_REQUEST['desde']!=""){
                            echo $_REQUEST['desde']; } ?>">
                    </TD>
                    <TD id="tdtitulogris">Folio Hasta:
                    </TD>
                    <TD colspan="2"><input type="text" name="hasta" value="<?php if ($_REQUEST['hasta']!=""){
                            echo $_REQUEST['hasta']; } ?>">
                    </TD>
                </TR>
                <tr>
                <tr>                         
                        <td id="tdtitulogris" align="center">IdRegistro
                        </td>
                        <td id="tdtitulogris" align="center">Codigo Estudiante
                        </td>
                        <td id="tdtitulogris" align="center">Nombre
                        </td>
                        <td id="tdtitulogris" align="center">Documento
                        </td>
                        <td id="tdtitulogris" align="center">Título
                        </td>
                    </tr>
                    <TR>                        
                        <TD align="center"><INPUT type="text" name="registro" id="registro" size="4" value="<?php if ($_REQUEST['registro']!=""){
                                echo $_REQUEST['registro']; } ?>"></TD>
                        <TD align="center"><INPUT type="text" name="codigo" id="codigo" size="4"  value="<?php if ($_REQUEST['codigo']!=""){
                                echo $_REQUEST['codigo']; } ?>"></TD>
                        <TD align="center"><INPUT type="text" name="nombreestudiante" id="nombreestudiante"   value="<?php if ($_REQUEST['nombreestudiante']!=""){
                                echo $_REQUEST['nombreestudiante']; } ?>"></TD>
                        <TD align="center"><INPUT type="text" name="doc" id="doc" size="15" value="<?php if ($_REQUEST['doc']!=""){
                                echo $_REQUEST['doc']; } ?>"></TD>
                        <TD><INPUT type="text" name="titulo" id="titulo" value="<?php if ($_REQUEST['titulo']!=""){
                                echo $_REQUEST['titulo']; } ?>"></TD>
                    </TR>
                    <td id="tdtitulogris" colspan="6" align="center">
                        <input type="hidden" name="tipogeneracion" value="<?php echo $_REQUEST['tipogeneracion']; ?>">
                        <input type="submit" name="buscar" value="Consultar">
                        <input type="button" name="regresar" value="Regresar" onclick="window.location.href='seleccion_impresion.php'">
                    </td>
                </tr>
            </table>
            <BR><BR>
            <?php
            if($totalRows_folio != "" && isset($_REQUEST['buscar'])){ ?>
            <input type="hidden" name="tipogeneracion" value="<?php echo $_REQUEST['tipogeneracion']; ?>">
            <table width="50%"  border="0"  cellpadding="3" cellspacing="3">
                    <TR >
                        <TD align="center">
                            <label id="labelresaltadogrande" >Resultado Busqueda, Folios desde <?php echo $_POST['desde'];?> hasta <?php echo $_POST['hasta']; ?>
                            </label>
                        </TD>
                    </TR>
                </table>
                <table width="50%"  border="1"  cellpadding="3" cellspacing="3">
                    <?php 
                    if(isset($_REQUEST['tipogeneracion']) && $_REQUEST['tipogeneracion']=="generacionmasiva"){
                    ?>
                    <tr>
                        <td colspan="7">
                            <input type="hidden" name="tipogeneracion" value="<?php echo $_REQUEST['desde']; ?>">
                            <input type="hidden" name="tipogeneracion" value="<?php echo $_REQUEST['hasta']; ?>">
                            <input type="hidden" name="tipogeneracion" value="<?php echo $_REQUEST['registro']; ?>">
                            <input type="hidden" name="tipogeneracion" value="<?php echo $_REQUEST['codigo']; ?>">
                            <input type="hidden" name="tipogeneracion" value="<?php echo $_REQUEST['nombreestudiante']; ?>">
                            <input type="hidden" name="tipogeneracion" value="<?php echo $_REQUEST['doc']; ?>">
                            <input type="hidden" name="tipogeneracion" value="<?php echo $_REQUEST['titulo']; ?>">
                            <input type="button" name="generamasivo" value="Generar Masivo Diplomas" onclick="window.open('../../../diplomas/diplomas.php?desde=<?php echo $_REQUEST['desde']."&hasta=".$_REQUEST['hasta']."&registro=".$_REQUEST['registro']."&codigo=".$_REQUEST['codigo']."&nombreestudiante=".$_REQUEST['nombreestudiante']."&doc=".$_REQUEST['doc']."&titulo=".$_REQUEST['titulo']."&tipogeneracion=".$_REQUEST['tipogeneracion']; ?>')">
                            
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                    <tr>
                         <td id="tdtitulogris" align="center">Nº
                        </td>
                        <td id="tdtitulogris" align="center">Nº Folio
                        </td>
                        <td id="tdtitulogris" align="center">IdRegistro
                        </td>
                        <td id="tdtitulogris" align="center">Codigo Estudiante
                        </td>
                        <td id="tdtitulogris" align="center">Nombre
                        </td>
                        <td id="tdtitulogris" align="center">Documento
                        </td>
                        <td id="tdtitulogris" align="center">Título
                        </td>
                    </tr>
                    

            <?php
                $num=0;              
                do{                    
                    $num=$num+1;                                
                    ?>
                    <tr>
                        <td><?php echo $num; ?>
                        </td>
                        <td><?php echo $row_folio['folio']; ?>
                        </td>
                        <td><?php echo $row_folio['idregistrograduado']; ?>
                        </td>
                        <td><?php echo $row_folio['codigoestudiante']; ?>
                        </td>
                        <td>
                            <?php if($_REQUEST['tipogeneracion']=="generacionestudiante" || $_REQUEST['tipogeneracion']=="generacionduplicado"){ ?>
                                <a target="_blank" id="aparencialink" href="../../../diplomas/diplomas.php?idregistrograduado=<?php echo $row_folio['idregistrograduado']."&codigomodalidadacademica=".$row_folio['codigomodalidadacademica']."&tipogeneracion=".$_REQUEST['tipogeneracion']; ?>"><?php echo $row_folio['nombre']; ?></a>
                            <?php
                            } else {
                             echo $row_folio['nombre'];   
                            }
                            ?>
                        </td>
                        <td><?php echo $row_folio['numerodocumento']; ?>
                        </td>
                        <td><?php echo $row_folio['nombretitulo']; ?>
                        </td>
                    </tr>
                    <?php
                    } while($row_folio = $folio->FetchRow());
                    ?>
                </table>
            <?php
            }
            else if(isset($totalRows_folio))
                {
                echo '<script language="JavaScript">alert("La busqueda no encuentra registros")</script>'; ?>
                <input type="hidden" name="tipogeneracion" value="<?php echo $_REQUEST['tipogeneracion']; ?>">
            <?php 
            }            
            ?>
            <input type="hidden" name="tipogeneracion" value="<?php echo $_REQUEST['tipogeneracion']; ?>">
        </form>
    </body>
</html>
