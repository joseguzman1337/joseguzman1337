<?php
// this starts the session 
session_start();
if (isset($_REQUEST["usuario"])) {
    $_SESSION['MM_Username'] = $_REQUEST["usuario"];
}

require_once("../templates/template.php");
$db = writeHeader("Visualizar Reporte", TRUE);

if (!isset($_REQUEST["idIndicador"]) && (!isset($_REQUEST["menu"]) || $_REQUEST["menu"] !== "0")) {
    include("./menu.php");
    writeMenu(0);
} else if (isset($_REQUEST["menu"]) && $_REQUEST["menu"] === "0") {
    ?>
    <div id="menuPrincipal">
        <ul class="littleSmaller">
            <li><a href="./detalle.php?idIndicador=<?php echo $_REQUEST["idI"]; ?>&actualizar=1">Volver a lista de reportes</a></li>
        </ul>            
    </div>
<?php
}

$data = array();
$utils = new Utils_datos();
if (isset($_REQUEST["idIndicador"]) && $_REQUEST["idIndicador"] != "") {
    $data = $utils->getDataEntity("indicador", $_REQUEST["idIndicador"]);
    $indicadorG = $utils->getDataEntity("indicadorGenerico", $data["idIndicadorGenerico"]);
    $aspecto = $utils->getDataEntity("aspecto", $indicadorG["idAspecto"]);
    $caracteristica = $utils->getDataEntity("caracteristica", $aspecto["idCaracteristica"]);
    $factor = $utils->getDataEntity("factor", $caracteristica["idFactor"]);
    $rows = $utils->getIDReporteByIndicador($db, $_REQUEST["idIndicador"]);
    //lista de reportes 
    ?>
    <style type="text/css">
        #dt_example th, #dt_example td{
            border: 0;
            padding:0;
        }

        body.body div#pageContainer{
            margin: 0 10px;
        }
    </style>
    <div id="contenido">
        <h4 style="margin-top:10px;margin-bottom:0.8em;">Datos del indicador</h4>

        <table class="detalle">
            <tr>
                <th>Factor:</th>
                <td><?php echo $factor["nombre"]; ?></td>
            </tr>
            <tr>
                <th>Característica:</th>
                <td><?php echo $caracteristica["nombre"]; ?></td>
            </tr>
            <tr>
                <th>Descripción de la característica:</th>
                <td><?php echo $caracteristica["descripcion"]; ?></td>
            </tr>
            <tr>
                <th>Aspecto:</th>
                <td><?php echo $aspecto["nombre"]; ?></td>
            </tr>
            <tr>
                <th>Indicador:</th>
                <td><?php echo $indicadorG["codigo"] . " - " . $indicadorG["nombre"]; ?></td>
            </tr>
            <tr>
                <th>Descripción del indicador:</th>
                <td><?php echo $indicadorG["descripcion"]; ?></td>
            </tr>
        </table>

        <h4 style="margin-top:10px;margin-bottom:0.8em;">Reportes asociados al indicador</h4>
        <?php
        foreach ($rows as $row) {
            echo"<a href='./detalle.php?id=" . $row["idReporte"] . "&actualizar=1&menu=0&idI=" . $_REQUEST["idIndicador"] . "'>" . $row["nombre"] . "</a><br/><br/>";
        }
        if (count($rows) == 0) {
            echo "<div style='text-align:center;'><span>No hay reportes asociados</span></div>";
        }

        $SQL_Doc = 'SELECT idsiq_documento
            FROM siq_documento d 
            INNER JOIN siq_archivo_documento sq on sq.siq_documento_id=d.idsiq_documento and sq.codigoestado=100
            WHERE siqindicador_id="' . $data['idsiq_indicador'] . '"
                AND d.idsiq_estructuradocumento = "'.$_REQUEST['idsiq_estructuradocumento'].'"
                AND d.codigoestado=100';
        //echo $SQL_Doc;
        if ($Documento = &$db->Execute($SQL_Doc) === false) {
            echo 'Error en el SQl De Buscar el Documento....<br>' . $SQL_Doc;
            die;
        }

        $id_doc = $Documento->fields['idsiq_documento'];
        if ($id_doc === null) {
            $id_doc == "";
        }
        //print_r($_REQUEST);		
        $Fecha_ini = $_REQUEST['Fecha_ini'];
        if ($Fecha_ini === null) {
            $Fecha_ini == "";
        }
        $Fecha_fin = $_REQUEST['Fecha_fin'];
        if ($Fecha_fin === null) {
            $Fecha_fin == "";
        }
        ?>
        <h4 style="margin-top:10px;margin-bottom:0.8em;">Documentos asociados al indicador</h4>
        <div style='text-align:center;margin-top:20px;width:97%;font:80%/1.45em "Lucida Grande",Verdana,Arial,Helvetica,sans-serif' id="dt_example">
            <?php if ($id_doc == "") { ?>
                <span >No tiene documentos vigentes asociados.</span>
    <?php } else { ?>                  
                <input type="button" value="Ver Archivos Adjuntos" style="font-size:12px;cursor:pointer;" onClick="Open(<?PHP echo $id_doc ?>, '0', '0', '<?PHP echo $Fecha_ini ?>', '<?PHP echo $Fecha_fin ?>', true,<?php echo $_REQUEST['idsiq_estructuradocumento']; ?>)" class="full_width big" title="Click para ver..." >

                <div id="Contenedor_archivos" style="display:none;width:100%">

                </div>	 
        <?php } ?>			
        </div>
        <?php if ($id_doc != "") { ?>
            <script type="text/javascript" src="../../js/ajax.js">/*TODAS LAS FUCNIONES DE AJAX*/</script>
            <script type="text/javascript" src="../../js/funcionesAcreditacion.js" ></script>
    <?php } ?>
    </div>
    <?php
    writeFooter();
    exit();
} else {
    $id = str_replace('row_', '', $_REQUEST["id"]);
}
$reporte = $utils->getDataEntity("reporte", $id);
$categoria = $utils->getDataEntity("categoriaData", $reporte["categoria"]);
$dates = $utils->getDatesReport($db, $reporte["idsiq_reporte"]);

$query = "select codigoperiodo from periodo where fechainicioperiodo>='" . $dates["fecha_inicial"] . "' AND fechavencimientoperiodo<='" . $dates["fecha_final"] . "' ORDER BY codigoperiodo ASC";
$periodos = $db->Execute($query);
$hayGrafica = file_exists("./graficasReportes/" . $categoria["alias"] . "/graficas" . $reporte["alias"] . ".php");
?>

<?php
if (count($reporte) == 0 || $reporte === false) {
    echo "No se encontró un reporte asociado.";
    die();
}
?>

<div id="contenido">
    <h2 style="margin-top:10px;margin-bottom:0.1em;"><?php echo $reporte["nombre"]; ?></h2>
<?php
if ($reporte["descripcion"] != null && $reporte["descripcion"] != "") {
    echo "<p>" . $reporte["descripcion"] . "</p>";
}
?>

    <ul class="drop" id="nav">     
        <li tabindex="1" class="level1-li"><button onclick="hacerCorte()" type="button">Generar PDF</button></li>
        <li tabindex="1" class="level1-li"><button onclick="hacerCorteExcel()" type="button">Generar Excel</button></li>
        <li tabindex="1" class="level1-li"><button onclick="verIndicadores()" type="button">Ver indicadores asociados</button></li>        
    <?php if ($hayGrafica) { ?><li tabindex="1" class="level1-li"><button onclick="verGraficas()" type="button">Ver gráficas</button></li><?php } ?>
    <?php if ($_REQUEST["actualizar"] == 1) { ?><li tabindex="1" class="level1-li"><button onclick="hacerAnalisis()" type="button">Hacer análisis</button></li><?php } ?>
    </ul><br/><br/>
    <form  action="./exportToExcel.php" method="post" id="formExcel" style="z-index: -1;  width:100%">
        <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
    </form>

<?php
include("./dialogIndicadores.php");
//echo "./reportes/".$categoria["alias"]."/view".$reporte["alias"].".php";
include("./reportes/" . $categoria["alias"] . "/view" . $reporte["alias"] . ".php")
?>
</div>

<form method="post" name="myFormPDF" action="convertToPdf.php">
    <input type="hidden" name="reporte" value="<?php echo $reporte["idsiq_reporte"]; ?>" />
    <input type="hidden" name="usuario" value="<?php echo $_SESSION['MM_Username']; ?>" />
    <input type="hidden" name="html" value="" id="htmlText" />

</form>

<script type="text/javascript">
    function verIndicadores() {
        $("#dialog-indicadores").dialog("open");
    }

<?php if ($hayGrafica) { ?>
        function verGraficas() {
            popup_carga("./generarGrafica.php?id=row_" +<?php echo $reporte["idsiq_reporte"]; ?>);
        }
<?php } ?>

<?php if ($_REQUEST["actualizar"] == 1) { ?>
        function hacerAnalisis() {
            popup_carga("./analisisReporte.php?id=" +<?php echo $reporte["idsiq_reporte"]; ?> + "&idI=" +<?php echo $_REQUEST["idI"]; ?>);
        }
<?php } ?>

    function hacerCorte() {
        //var archivos = new Array();
        var html = $("#tableDiv").html();
        $("#htmlText").val(html);
        //popup_carga("./convertToPdf.php?reporte=<?php //echo $reporte["idsiq_reporte"];  ?>&usuario=<?php //echo $_SESSION['MM_Username'];  ?>&html="+html);
        var centerWidth = (window.screen.width - 850) / 2;
        var centerHeight = (window.screen.height - 700) / 2;

        var opciones = "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top=" + centerHeight + ", left=" + centerWidth;
        var mypopup = window.open("", "MYPOPUPPDF", opciones);
        //win = window.open('','myWin','toolbars=0');            
        document.myFormPDF.target = 'MYPOPUPPDF';
        document.myFormPDF.submit();
        /*$.ajax({
         dataType: 'json',
         type: 'POST',
         async: false,
         url: 'convertToPdf.php',
         data: { reporte: "<?php //echo $reporte["idsiq_reporte"];  ?>", usuario: "<?php //echo $_SESSION['MM_Username'];  ?>", html: html },                
         success:function(data){       
         console.log(data);
         if (data.success == true){
         archivos[i] = data.archivo;
         popup_carga("./reportesPDF/"+data.archivo);
         //     alert("Se ha editado la definición de indicador con éxito.");
         //     window.location.href="index.php";
         }
         else{                        
         alert(data.mensaje);
         }
         },
         error: function(data,error,errorThrown){alert(error + errorThrown);}
         });  */
    }

    function hacerCorteExcel() {
        $("#datos_a_enviar").val($("<div>").append($(".previewReport").eq(0).clone()).html());
        $("#formExcel").submit();
    }

    function popup_carga(url) {

        var centerWidth = (window.screen.width - 850) / 2;
        var centerHeight = (window.screen.height - 700) / 2;

        var opciones = "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top=" + centerHeight + ", left=" + centerWidth;
        var mypopup = window.open(url, "", opciones);
        //Para que me refresque la página apenas se cierre el popup
        //mypopup.onunload = windowClose;​

        //para poner la ventana en frente
        window.focus();
        mypopup.focus();

    }

//$( "#select-facultades" ).button().click(function() {
//                        $( "#dialog-facultades" ).dialog( "open" );                        
//});

    //dialogo indicadores asociados
    $("#dialog-indicadores").dialog({
        autoOpen: false,
        height: 350,
        width: 800,
        modal: true,
        position: 'center',
        buttons: {
        },
        close: function (event) {

            //Para que no le haga submit automaticamente al form al cerrar el dialog
            event.preventDefault();
        }
    });
</script>
<script type="text/javascript" language="javascript" src="../registroInformacion/js/funcionesTablasMaestras.js"></script>
<?php writeFooter(); ?>
