<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?
header( 'Content-type: text/html; charset=ISO-8859-1' );
?>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
        <title>Lista de Instituciones</title>
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
            sql="SELECT idsiq_detalle_participante,idsiq_docenteconvenio, nombreparticipante, apellidoparticipante FROM siq_participante as p INNER JOIN siq_detalle_participante as dp on (p.idsiq_participante=dp.idsiq_participante)"
             bTable = $('#example2').dataTable({      
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "bServerSide": true,                
                "sAjaxSource": "server_processing.php?table=siq_participante&sql="+sql+"&wh=idsiq_detalle_convenio&vwh=<?php echo $_REQUEST['idsiq_detalle_convenio'] ?> ",
                "aoColumns": [
                { "sTitle": "ID" },    
                { "sTitle": "Docente" },
                { "sTitle": "Nombre Participante" },
                { "sTitle": "Apellido Participante" }
                ]
            });
            /* Click event handler */
            $('#example2 tbody tr').live('click', function () {                
                var id = this.id;
                var id2 = $(this)[0].cells[0].firstChild
                var doc = $(this)[0].cells[1].firstChild;  
                var nom = $(this)[0].cells[2].firstChild; 
                var app = $(this)[0].cells[3].firstChild; 
                var o = new Object();               
               // o.id = id;
               //  alert(id2.nodeValue);
                 o.id=id.replace('row_','');
                 o.id2 = id2.nodeValue;
                 o.doc = doc.nodeValue;
                 o.nombre = nom.nodeValue+' '+app.nodeValue;
                 o.app = app.nodeValue;
                 //alert(o.nombre);
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
                            <th>Participante</th> 
                            <th>Participante</th> 
                            <th>Participante</th> 
                            <th>Participante</th> 
                        </tr>
                    </thead>
                    <tbody>                        
                    </tbody>
                </table>
            </div>
        </div>        
    </body>
</html>