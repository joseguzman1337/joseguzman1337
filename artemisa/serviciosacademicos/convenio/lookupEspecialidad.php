<?php
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
?>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
        <title>Lista de Especilidades</title>
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
            bTable = $('#example2').dataTable({      
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "bServerSide": true,                
                "sAjaxSource": "server_processing.php?table=siq_especialidad",
                "aoColumns": [
                { "sTitle": "Especialidad" },
                { "sTitle": "Tipo" },
                ]
            });
            /* Click event handler */
            $('#example2 tbody tr').live('click', function () {                
                var id = this.id;
                var vlor = $(this)[0].cells[0].firstChild;                 
                var o = new Object();               
                o.id = id;
                o.value = vlor.nodeValue;
                o.id=id.replace('row_','');
                //alert(id);
                window.returnValue = o; 
                window.close();
            } );
        } );
        </script>
    </head>
    <body id="dt_example2">
        <div id="container2">            
            <div class="demo_jui2">                
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example2">
                    <thead>
                        <tr>                       
                            <th>Especialidad</th> 
                            <th>Tipo</th> 
                        </tr>
                    </thead>
                    <tbody>                        
                    </tbody>
                </table>
            </div>
        </div>        
    </body>
</html>