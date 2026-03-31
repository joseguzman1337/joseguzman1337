<?php
session_set_cookie_params(86400);
@session_start();
require('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
require_once('../../funciones/clases/autenticacion/redirect.php');

//require_once('conexionSIC.php');

$codigocarrera = $_SESSION['codigofacultad'];

$rutaPHP = 'librerias/php/';
require_once($rutaPHP.'funcionessic.php');

$rutaJS = 'librerias/js/';
$rutaEstilos = 'estilos/';
$rutaImagenes = 'imagenes/';

/*if(!isset($_REQUEST['enlace']))
{
    $aplicacion = "textogeneral";
}*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>SIQ</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="<?php echo $rutaEstilos; ?>sala2.css" />
        <link rel="stylesheet" href="<?php echo $rutaJS; ?>jquery-treeview/jquery.treeview.css" />
        <link rel="stylesheet" href="<?php echo $rutaJS; ?>jquery-ui/css/ui-lightness/jquery-ui-3.6.0.custom.css" />

        <script src="<?php echo $rutaJS; ?>jquery-3.6.0.js" type="text/javascript"></script>
        <script src="<?php echo $rutaJS; ?>jquery.layout.js" type="text/javascript"></script>
        <script src="<?php echo $rutaJS; ?>jquery.maxlength-min.js" type="text/javascript"></script>
        <script src="<?php echo $rutaJS; ?>jquery-treeview/lib/jquery.cookie.js" type="text/javascript"></script>
        <script src="<?php echo $rutaJS; ?>jquery-treeview/jquery.treeview.js" type="text/javascript"></script>
        <script src="<?php echo $rutaJS; ?>jquery-ui/js/jquery-ui-3.6.0.custom.min.js" type="text/javascript"></script>

        <link type="text/css" rel="stylesheet" href="<?php echo $rutaJS; ?>jquery-windows/jquery.windows-engine.css" />
        <script type="text/javascript" src="<?php echo $rutaJS; ?>jquery-windows/jquery.windows-engine.js"></script>

        <script type="text/javascript">
            //$.ui.dialog.defaults.bgiframe = true;

            $(document).ready(function () {
                var pageLayout;
                // create page layout
                pageLayout = $('body').layout({
                    applyDefaultStyles: true,
                    scrollToBookmarkOnLoad: false,
                    defaults: {
                    },
                    north: {
                        size: 40,
                        spacing_closed: 10,
                        spacing_open: 10,
                        closable: true
                    },
                    west: {
                        size: 270,
                        spacing_closed: 10,
                        spacing_open: 10,
                        //togglerLength_closed: 140,
                        slideTrigger_open: "mouseover"
                    }
                });

                //$('body').layout({ applyDefaultStyles: true });
                //$('body').layout().sizePane("west", 270);
                /*$('body').layout({
                    west: {closable: true, size: 250}
                });*/
            });

            $(function() {
                var Expresion = /\.php|\.htm|\.co/;

                //var texto;
                //var referenciaaplicacion;

                //referenciaaplicacion = "aplicaciones/<?php echo $aplicacion; ?>/vista/<?php echo $aplicacion; ?>.php";

                $("#tree").treeview({
                    collapsed: true,
                    animated: "medium",
                    control:"#sidetreecontrol",
                    //persist: "location"
                    persist: "cookie"
                    //unique: true
                });

                //$("#textogeneral").hide();
                /*$("#dialog").dialog({
                autoOpen: false,
                width: 500
            });*/

                $("label").click(function(){
                    iditemsic = $(this).attr('name');
                    nombreitemsic = $(this).text();
                    descripcionitemsic = $(this).attr('title');
                    longituddescripcionitemsic = $(this).attr('lang');
                    enlaceitemsic = $("#enlaceitemsic" + iditemsic).attr('value');

                    //alert(iditemsic + nombreitemsic + descripcionitemsic + longituddescripcionitemsic + enlaceitemsic);
                    //alert(aplicacion);
                    if(enlaceitemsic.match(Expresion))
                    {
                        //alert(enlaceitemsic);
                        aplicacion = "http://" + enlaceitemsic;
                        aplicacion = "" + enlaceitemsic + "?iditemsic=" + iditemsic;
                        $("#contenidocentral").attr("src", aplicacion);
                    }
                    else if(enlaceitemsic != "")
                    {
                        aplicacion = "aplicaciones/" + enlaceitemsic + "/controlador/php/" + enlaceitemsic + ".php?iditemsic=" + iditemsic;
                        $("#contenidocentral").attr("src", aplicacion);
                    }
                    else
                        alert("No existe una aplicación de modificación asociada a esta opción");



                    //        $("#contenidocentral").load(referenciaaplicacion, function() {
                    //Codigo Jquery cargado que se va a usar en cada aplicación
<?php
//require_once("aplicaciones/".$aplicacion."/controlador/js/".$aplicacion.".js.inc");
?>
            //        });
            /*$.ajax({
                    url: ref,
                    success: function(datos){
                        $("#central").html(datos);
                        //$("#dialog").append(datos);
                        //alert(datos);
                    }
                });*/
            //alert(texto);
            //$("#textogeneral").slideToggle(600);
            /*$("#textogeneral").css("display", "block");
                $("#areadetexto").remove();
                $(".status").remove();
                $("#iditemsicoculto").after('<textarea id="areadetexto" cols="50" rows="5" name="areadetexto" style="width: 450px"></textarea>');*/


            //$("#dialog").attr({
            //    title : 'texto'
            //});
            //$("#dialog").removeAttr("title");
            //$("#dialog").attr("title","button");
            //$("#dialog").replaceWith("<title>has changed</title>");
            //$("#dialog").attr('title','texto');
            //$("#dialog").attr("title",texto);
            //$("#dialog").attr("title", function(){ return texto });
            //if($("#dialog").dialog("isOpen"))
            //    $("#dialog").dialog("close");

            //$("#areadetexto").val("");
            //$("#dialog").dialog({
            //    autoOpen: false
            //});
            //$("#dialog").dialog("open");
            //$("#dialog").dialog("option", "title", texto);

            //$("#dialog").dialog("close");
            //alert($(this).text());
            //$("#dialog").dialog("open");
            //alert($(this).attr("name"));
        });
    })
        </script>
    </head>
    <body>
        <?php
        // Dependiendo de la selección que se haga en usuariodependencia o usuariocarrera, mostrar el menu
        if(isset($_REQUEST['ingresoInstitucional'])) {
            //$iditemsicsel = 2;
            $_SESSION['sesion_carreraitemsic'] = 156;
            unset($_SESSION['sesion_nombredependencia']);
        }
        else if (isset($_REQUEST['ingresoAdministrativo'])) {
                //$iditemsicsel = 289;
                if(!isset($_SESSION['sesion_nombredependencia'])) {
                    $_SESSION['sesion_carreraitemsic'] = obtenerCodigoDependencia($_SESSION['MM_Username']);
                    $_SESSION['sesion_nombredependencia'] = obtenerNombreDependencia($_SESSION['sesion_carreraitemsic']);
                }
                if($_SESSION['sesion_carreraitemsic'] == '' || !isset($_SESSION['sesion_carreraitemsic'])) {
                    ?>
        <script type="text/javascript">
            alert("No tiene acceso para ingresar a esta opción, verificar que su usuario esté asociado a una dependencia");
            window.close();
            //window.location.href='http://www.unbosque.edu.co';
        </script>
                    <?php
                    exit();
                }
            //unset($_SESSION['sesion_carreraitemsic']);
            // Validar que se alla seleccionado una facultad con modalidad 501
            }
            else {
            // Ingreso para facultades
                //$iditemsicsel = 85;
                unset($_SESSION['sesion_carreraitemsic']);
                unset($_SESSION['sesion_nombredependencia']);
            }
            if(isset($_SESSION['sesion_carreraitemsic'])) {
                // Obtiene los iditemsicsel a los que tiene acceso la carrera o dependencia
                // Vamos a hacerlo por carrera pa evitar vainas
                $iditemsicsel = obtenerPermisoItem($_SESSION['sesion_carreraitemsic']);
            }
            else {
                $iditemsicsel = obtenerPermisoItem($codigocarrera);
            }

        ?>
        <div class="ui-layout-north"><br /><div class="facultad">
                <?php
                if(isset($_REQUEST['ingresoInstitucional']) || isset($_REQUEST['ingresoAdministrativo']))
                    echo $_SESSION['sesion_nombredependencia'];
                else if(isset($_SESSION['nombrefacultad']))
                        echo $_SESSION['nombrefacultad'];

                ?></div>SISTEMA DE INFORMACION DE CALIDAD
        </div>

        <!--<div class="ui-layout-south">South</div>-->
        <!--<div class="ui-layout-east">East</div>-->

        <div class="ui-layout-center">
            <iframe id="contenidocentral" src="" width="100%" height="100%"></iframe>
            <!-- Se cargan el html o php que se va a mostrar -->
        </div>

        <div class="ui-layout-west">
            <?php
            /*if(isset($_SESSION['sesion_carreraitemsic']) && !isset($_REQUEST['ingresoInstitucional'])) {
                filtroDependencia();
            }*/
        //print_r($_SESSION);
        if($iditemsicsel != '') {

        ?>
            <img src="imagenes/todos.gif" width="252" height="25" alt="Todos" />
            <div id="sidetree">
                <div id="sidetreecontrol"><a href="?#">Contraer Todo</a> | <a href="?#">Expandir Todo</a></div>
                <?php
                //$db->debug = true;
                $query_papas = "select i.iditemsic, i.nombreitemsic, i.descripcionitemsic, i.iditemsicpadre, i.codigotipoitemsic, i.pesoitemsic, i.enlaceitemsic, i.codigoestadoitemsic, i.codigoestado
from itemsic i
where i.iditemsicpadre = 0
and i.codigoestado like '100'
order by i.pesoitemsic";
                $papas = $db->Execute($query_papas);
                $totalRows_papas = $papas->RecordCount();
                ?>
                <ul id="tree">
                    <?php
                    //$cuentaitem = 1;
                    while($row_papas = $papas->FetchRow()) {
                        ?>
                    <li><strong><?php echo "".$row_papas['nombreitemsic'];?></strong>
                        <ul>
                                <?php
                                $cuentaitem = 1;
                                getHijos($row_papas['iditemsic'], $iditemsicsel);
                                ?>
                        </ul>
                    </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
            <?php
        }
        else {
            echo "<h1>La carrera o dependencia no tiene opciones</h1>";
        }
            ?>

        </div>
    </body>
</html>
