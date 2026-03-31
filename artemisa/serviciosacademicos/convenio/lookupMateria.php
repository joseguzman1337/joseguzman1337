<?php
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

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
        var dTable;
        $(document).ready(function() {
            /* Click event handler */
            $('#example2 tbody tr').live('click', function () {                
                var id = this.id;
                var vlor = $(this)[0].cells[0].firstChild; 
                var nomb = $(this)[0].cells[2].firstChild; 
                var o = new Object();               
                o.id = id;
                o.idm = vlor.nodeValue;
                o.nomb = nomb.nodeValue;
                //alert(o.id2);
                window.returnValue = o; 
                window.close();
            } );
            
            $("#codigomodalidadacademica").change(function(event){
           //     alert('hola');
                var id = $("#codigomodalidadacademica").find(':selected').val();
                $("#codigocarrera").load('generacarrera.php?id='+id);
            });
       
           $("#codigocarrera").change(function(event){
           //     alert('hola');
                var idcar = $("#codigocarrera").find(':selected').val();
                $("#show").load("generarmateria.php?id="+idcar);
            });

      });
        </script>
    </head>
    <body id="dt_example2">
        <div id="container2">            
            <div class="demo_jui2"> 
                        Programa
				<?php
                                        $query_programa = "SELECT nombremodalidadacademica, codigomodalidadacademica FROM modalidadacademica order by 1";
                                        $reg_programa =$db->Execute($query_programa);
                                        echo $reg_programa->GetMenu2('codigomodalidadacademica',$data['codigomodalidadacademica'],false,false,1,' id=codigomodalidadacademica  style="width:150px;"');
                                 ?>
                                 Carrera
                                 <select id="codigocarrera" name="codigocarrera" style="width:250px;">
                                     
                                 </select>
			</div>
                            <div id="show">
                </div>    
		</div>
       
    </body>
</html>