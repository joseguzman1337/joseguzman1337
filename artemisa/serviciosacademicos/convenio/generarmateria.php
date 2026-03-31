<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php
//header( 'Content-type: text/html; charset=ISO-8859-1' );

require_once('../Connections/salasiq.php');
$rutaado = "../funciones/adodb/";
require_once('../Connections/salaado.php');


?>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
        <title>Materias</title>
        <style type="text/css" title="currentStyle">
                @import "../css/demo_page.css";
                @import "../css/demo_table_jui.css";
                @import "../css/themes/smoothness/jquery-ui-1.8.4.custom.css";
        </style>
        <script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript">
        var bTable;
        $(document).ready(function() {
             var sql;
             sql="SELECT m.codigomateria, m.nombrecortomateria, m.nombremateria, c.nombrecarrera FROM sala.materia as m inner join carrera as c on (m.codigocarrera=c.codigocarrera)";
             bTable = $('#example2').dataTable({ 
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "bServerSide": true,                
                "sAjaxSource": "server_processing.php?table=materia&IndexColumn=codigomateria&sql="+sql+"&wh=m.codigocarrera&vwh=<?php echo $_REQUEST['id']?> ",
                "aoColumns": [
                { "sTitle": "Cod Materia" },
                { "sTitle": "Nombre Corto" },
                { "sTitle": "Materia" },
                { "sTitle": "Carrera" }
                ]
              });

            });
        </script>
    </head>
    <body id="dt_example2">
        <div id="container2">            
            <div class="demo_jui2"> 
                <table cellpadding="0" cellspacing="0" border="0"  class="display" id="example2">
                    <thead>
                        <tr>                       
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>                        
                    </tbody>
                </table>
            </div>
        </div>        
    </body>
</html>