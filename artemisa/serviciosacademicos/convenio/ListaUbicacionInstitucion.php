<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once ('../EspacioFisico/templates/template.php');
    $db = getBD();

    switch($_REQUEST['actionID']){
        case 'TipoNumber':{
           $numero = $_POST['Numero'];
         
           if ($numero%2==0){
              $num = 1;
           }else{
              $num = 0;
           }
           $a_vectt['val'] =true;
           $a_vectt['num']    =$num;
           echo json_encode($a_vectt);
           exit;
       }exit;
    }
    
    $id = $_GET['idinstitucion'];
?>

<html>
    <head>
        <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Lista Ubicacion Instituciones</title>
             
         <style type="text/css" title="currentStyle">
            @import "../consulta/estadisticas/riesgos/data/media/css/demo_page.css";
            @import "../consulta/estadisticas/riesgos/data/media/css/demo_table_jui.css";
            @import "../consulta/estadisticas/riesgos/data/media/css/ColVis.css";
            @import "../consulta/estadisticas/riesgos/data/media/css/TableTools.css";
            @import "../consulta/estadisticas/riesgos/data/media/css/jquery.modal.css";
        
                 
        </style>
        <script type='text/javascript' language="javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery-ui-1.8.21.custom.min.js"></script>   
        <script type="text/javascript" language="javascript" src="../consulta/estadisticas/riesgos/data/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8" src="../consulta/estadisticas/riesgos/data/media/js/ColVis.js"></script>
        <script type="text/javascript" charset="utf-8" src="../consulta/estadisticas/riesgos/data/media/js/ZeroClipboard.js"></script>
        <script type="text/javascript" charset="utf-8" src="../consulta/estadisticas/riesgos/data/media/js/TableTools.js"></script>
        <script type="text/javascript" charset="utf-8" src="../consulta/estadisticas/riesgos/data/media/js/jquery.modal.js"></script>
        <link type="text/css" href="../educacionContinuada/css/normalize.css" rel="stylesheet">
		<link media="screen, projection" type="text/css" href="../educacionContinuada/css/style.css" rel="stylesheet">
        <script type="text/javascript" language="javascript" src="js/funcionesInstituciones.js"></script> 
         <script type="text/javascript" language="javascript">
        /****************************************************************/
        	$(document).ready( function () {
        			
        			oTable = $('#example').dataTable({
                                    "sDom": '<"H"Cfrltip>',
                                    "bJQueryUI": true,
                                    "bPaginate": true,
                                    "sPaginationType": "full_numbers",
                                    "oColVis": {
                                          "buttonText": "Ver/Ocultar Columns",
                                           "aiExclude": [ 0 ]
                                    }
                                });
                                var oTableTools = new TableTools( oTable, {
        					"buttons": [
        						"copy",
        						"csv",
        						"xls",
        						"pdf",
        						{ "type": "print", "buttonText": "Print me!" }
        					]
        		         });
                                // $('#demo').before( oTableTools.dom.container );
        		} );
        	/**************************************************************/
            
            
        </script>
  <html>
    <body> 
    <div id="container"> 
        <div id="demo">     	
            <center>
                <h1>LISTA UBICACION INSTITUCION</h1>
            </center>
                <form action="NuevaUbicacionInstitucion.php" method="post" >
                <input type="submit" value="Nueva Ubicacion" name="Nuevo" id="Nuevo"/>
                <input type="hidden" id="idinstitucion" name="idinstitucion" value="<?php echo $id?>" />
                </form>
                <table cellpadding="3" width="100%" border="0" align="center" id="example">
                <thead>
                    <tr>
                        <td>Numero</td>
                        <td>Nombre Ubicacion</td>
                        <td>Institucion</td>
                        <td>Pais</td>
                        <td>Cuidad</td>
                        <td>Estado</td>
                        <td>Detalles</td>
                    </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i=1;
                        $sqlUbicacion = "SELECT u.IdUbicacionInstitucion, u.NombreUbicacion, e.nombreestado, s.NombreInstitucion, p.nombrecortopais, c.nombreciudad FROM UbicacionInstituciones u, InstitucionConvenios s, estado e, pais p, ciudad c WHERE u.InstitucionConvenioId = s.InstitucionConvenioId and u.codigoestado = e.codigoestado and p.idpais = u.idpais and c.idciudad = u.idciudad and u.InstitucionConvenioId = '".$id."'";
                        $valoresUbicacion = $db->Execute($sqlUbicacion);
                        //echo $sqlUbicacion;
                        foreach($valoresUbicacion as $datosUbicacion)
                        {
                        ?>
                    <tr>
                        <td><?php echo $i?></td>
                        <td><?php echo $datosUbicacion['NombreUbicacion']?></td>
                        <td><?php echo $datosUbicacion['NombreInstitucion']?></td>
                        <td><?php echo $datosUbicacion['nombrecortopais']?></td>
                        <td><?php echo $datosUbicacion['nombreciudad']?></td>
                        <td><?php echo $datosUbicacion['nombreestado']?></td>
                        <td valign="top">
                            <form action="DetallesUbicacionInstitucion.php" method="post">
                                <input type="hidden" name="detalle" id="detalle" value="<?php echo $datosUbicacion['IdUbicacionInstitucion']?>" />
                                <input type="image" src="../mgi/images/file_search.png" width="20">
                            </form>
                        </td>
                    </tr>        
                    <?php
                    $i++;
                    }
                    ?>
                </tbody>
                </table>
                <form action="../convenio/listaInstituciones.php" >
                <input type="hidden" id="idinstitucion" name="idinstitucion" value="<?php echo $id?>" />
                <input type="button" value="Regresar" onclick="Regresar()" />
                </form> 
        </div>
</div>
    <?php
       
    ?>
  </body>
</html>