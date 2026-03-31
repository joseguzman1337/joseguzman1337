<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
        
    include_once (realpath(dirname(__FILE__)).'/../EspacioFisico/templates/template.php');
    $db = getBD();            
    include_once (realpath(dirname(__FILE__)).'/Permisos/class/PermisosConvenio_class.php'); $C_Permisos = new PermisosConvenio();       
    include_once(realpath(dirname(__FILE__)).'/../mgi/Menu.class.php');        
    $C_Menu_Global  = new Menu_Global();
    //include_once('_menuConvenios.php');
    
    $SQL_User='SELECT idusuario as id, codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
    $Usario_id=$db->GetRow($SQL_User);
    $userid=$Usario_id['id'];    
    
    $Acceso = $C_Permisos->PermisoUsuarioConvenio($db,$userid,1,3);
    
    if($Acceso['val']===false){
        ?>
        <blink>
            <?PHP echo $Acceso['msn'];?>
        </blink>
        <?PHP
        Die;
    }
    
    $sqlS = "select idusuario from usuario where usuario = '".$_SESSION['MM_Username']."'";
    $usuario = $db->GetRow($sqlS);
    $user = $usuario['idusuario'];
    $id = $_REQUEST['idconvenio'];
    $carrea = $_REQUEST['Detalle'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Acuerdos</title>
             
         <style type="text/css" title="currentStyle">
                @import "../consulta/estadisticas/riesgos/data/media/css/demo_page.css";
                @import "../consulta/estadisticas/riesgos/data/media/css/demo_table_jui.css";
                @import "../consulta/estadisticas/riesgos/data/media/css/ColVis.css";
                @import "../consulta/estadisticas/riesgos/data/media/css/TableTools.css";
                @import "../consulta/estadisticas/riesgos/data/media/css/jquery.modal.css";
                
        </style>
		<link type="text/css" href="../educacionContinuada/css/normalize.css" rel="stylesheet">
		<link media="screen, projection" type="text/css" href="../educacionContinuada/css/style.css" rel="stylesheet">
		<link media="screen, projection" type="text/css" href="./css/style.css" rel="stylesheet">
        <script type='text/javascript' language="javascript" src="../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript" language="javascript" src="../consulta/estadisticas/riesgos/data/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8" src="../consulta/estadisticas/riesgos/data/media/js/ColVis.js"></script>
        <script type="text/javascript" charset="utf-8" src="../consulta/estadisticas/riesgos/data/media/js/ZeroClipboard.js"></script>
        <script type="text/javascript" charset="utf-8" src="../consulta/estadisticas/riesgos/data/media/js/TableTools.js"></script>
        <script type="text/javascript" charset="utf-8" src="../consulta/estadisticas/riesgos/data/media/js/jquery.modal.js"></script>
        <script type="text/javascript" language="javascript">
        /****************************************************************/
        	$(document).ready( function () {
        			
        			oTable = $('#example').dataTable({
                                    "sDom": '<"H"Cfrltip>',
                                    "bJQueryUI": true,
                                    "bPaginate": true,
                                    "sPaginationType": "full_numbers",
                                    "oColVis": {
                                          "buttonText": "Ver/Ocultar Columnas",
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
                                 $('#demo').before( oTableTools.dom.container );
                             
        		} );
        	/**************************************************************/
        </script>
    </head>
    <body class="body"> 
    <div id="pageContainer">
	<?php 
    // writeMenu(3);
   $Menu = $C_Permisos->PermisoUsuarioConvenio($db,$userid,2,3);
    
    for($i=0;$i<count($Menu['Data']);$i++){
        $URL[]    = $Menu['Data'][$i]['Url'];
        
        $Nombre[] = $Menu['Data'][$i]['Nombre'];
        
        if($Menu['Data'][$i]['ModuloSistemaId']==3){
            $Active[] = '1';    
        }else{
            $Active[] = '0';
        }
    }//for
    
    //$C_Menu_Global->writeMenu2($URL,"Sistema de Convenios",$Nombre,$Active);
    
    ?>   
        
        <div id="container">
            <center>
                <h1>ACUERDOS</h1>
            </center>
            </div>
            <div id="demo">            
            <form action="nuevoacuerdo.php">
                <input type="submit" id="NuevoAcuerdo" value="Nuevo Acuerdo" />
            </form>
             <table cellpadding="0" cellspacing="0" border="1" class="display" id="example">
            <thead>
            <tr>
                <td># Acuerdo</td>
                <td>Programa académico</td>
                <td>Cupos</td>
                <td>Institución</td>
                <td>Estado</td>
                <td>Archivo</td>
                <td>Detalles</td>
                </tr>
            </thead>
            <tbody>
            <?php
                $sqlcarrera = "select ac.numeroAcuerdo, ac.AcuerdoConvenioId, c.nombrecarrera, ac.Cupos, ic.NombreInstitucion, e.nombreestado, ac.RutaArchivo from AcuerdoConvenios ac join carrera c on c.codigocarrera = ac.codigocarrera join InstitucionConvenios ic on ic.InstitucionconvenioId = ac.InstitucionConvenioId join estado e on e.codigoestado = ac.codigoestado";
               
                $valorescarrea = $db->GetAll($sqlcarrera);
                foreach($valorescarrea as $datoscarrera)
                {
                    echo "<tr><td>".$datoscarrera['numeroAcuerdo']."</td>";
                    echo "<td>".$datoscarrera['nombrecarrera']."</td>";
                    echo "<td>".$datoscarrera['Cupos']."</td>";
                    echo "<td>".$datoscarrera['NombreInstitucion']."</td>"; 
                    echo "<td>".$datoscarrera['nombreestado']."</td>";
                    echo "<td><a href='files/".$datoscarrera['RutaArchivo']."' target='blank'><img src='../mgi/images/file_document.png' width='50' height='37' border='0'/></a></td>";
                    echo "<td valign='top'><form action='detallesacuerdo.php' method='post'>
                        <input type='hidden' name='Detalle' id='Detalle' value='".$datoscarrera['AcuerdoConvenioId']."' />
                        <input type='image' src='../mgi/images/file_search.png' width='20'></form></td></tr>";
                }
             ?>
             </tbody>
            </table>
            </div>  
    </div>
  </body>
  </html>