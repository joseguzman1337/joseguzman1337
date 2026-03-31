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
        <title>Lista de Docentes</title>
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
                "sAjaxSource": "server_processing.php?table=docente",
                "aoColumns": [
                { "sTitle": "Codigodocente" },
                { "sTitle": "apellidocente" },
                { "sTitle": "nombredocente" },
                { "sTitle": "tipodocumento", "bVisible": false },
                { "sTitle": "numerodocumento" }
                ]
            });
            /* Click event handler */
            $('#example2 tbody tr').live('click', function () {  
                var id = this.id;
                var valid=$(this)[0].cells[0].firstChild;
                var o = new Object();               
                o.id = id;
                o.value = valid.nodeValue;
                 $.ajax({
                type: 'POST',
                url: 'buscardocente.php?id='+o.id,
                dataType: "xml",
                data: o.id,                
                success:function(data){        
                    //alert(data);
  			$(data).find('docentes').each(function(){
				  
                                var iddocente = $(this).find('iddocente').text();
                                var codigodocente = $(this).find('codigodocente').text();
				var apellidodocente= $(this).find('apellidodocente').text();
                                var nombredocente = $(this).find('nombredocente').text();
                                var tipodocumento = $(this).find('tipodocumento').text();
                                var numerodocumento= $(this).find('numerodocumento').text();
                                var codigogenero = $(this).find('codigogenero').text();
                                var fechanacimientodocente = $(this).find('fechanacimientodocente').text();
                                var idpaisnacimiento = $(this).find('idpaisnacimiento').text();
                                var iddepartamentonacimiento = $(this).find('iddepartamentonacimiento').text();
                                var idciudadnacimiento = $(this).find('idciudadnacimiento').text();
                                var idestadocivil = $(this).find('idestadocivil').text();
                                var direcciondocente = $(this).find('direcciondocente').text();
                                var idciudadresidencia = $(this).find('idciudadresidencia').text();
                                var telefonoresidenciadocente = $(this).find('telefonoresidenciadocente').text();
                                var profesion= $(this).find('profesion').text();
                                var emaildocente= $(this).find('emaildocente').text();
                               
                               var r = new Object();
                                r.iddocente=iddocente;
                                r.codigodocente=codigodocente;
                                r.apellidodocente=apellidodocente;
                                r.nombredocente =nombredocente;
                                r.tipodocumento =tipodocumento;
                                r.numerodocumento=numerodocumento;
                                r.codigogenero =codigogenero;
                                r.fechanacimientodocente =fechanacimientodocente;
                                r.idpaisnacimiento =idpaisnacimiento;
                                r.iddepartamentonacimiento =iddepartamentonacimiento;
                                r.idciudadnacimiento =idciudadnacimiento;
                                r.idestadocivil =idestadocivil;
                                r.direcciondocente =direcciondocente;
                                r.idciudadresidencia =idciudadresidencia;
                                r.telefonoresidenciadocente =telefonoresidenciadocente;
                                r.profesion=profesion;
                                r.emaildocente =emaildocente;
                               // alert(r.idciudadresidencia);
                                window.returnValue = r; 
                                window.close(); 
                                
			});
                },
                error: function(data,error){}
            });      

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
                            <th>Codigo</th> 
                            <th>Apellido del Docente</th> 
                            <th>Nombre del Docente</th> 
                            <th>Tipo Documento</th> 
                            <th>N° Documento</th> 
                        </tr>
                    </thead>
                    <tbody>                        
                    </tbody>
                </table>
            </div>
        </div>        
    </body>
</html>