<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once (realpath(dirname(__FILE__)).'/../EspacioFisico/templates/template.php');
    include_once (realpath(dirname(__FILE__)).'/./Permisos/class/PermisosConvenio_class.php'); $C_Permisos = new PermisosConvenio();
    include_once(realpath(dirname(__FILE__)).'/../mgi/Menu.class.php');        $C_Menu_Global  = new Menu_Global();
    //include_once('_menuConvenios.php');
    $db = getBD();

    $SQL_User='SELECT idusuario as id, codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
    $Usario_id=$db->GetRow($SQL_User);
    $userid=$Usario_id['id'];
    $Acceso = $C_Permisos->PermisoUsuarioConvenio($db,$Usario_id['id'],1,2);

    if($Acceso['val']===false){
        ?>
        <blink>
            <?PHP echo $Acceso['msn'];?>
        </blink>
        <?PHP
        Die;
    }

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
?>
<html>
    <head>
        <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Lista Instituciones</title>
             
         <style type="text/css" title="currentStyle">
            @import "../consulta/estadisticas/riesgos/data/media/css/demo_page.css";
            @import "../consulta/estadisticas/riesgos/data/media/css/demo_table_jui.css";
            @import "../consulta/estadisticas/riesgos/data/media/css/ColVis.css";
            @import "../consulta/estadisticas/riesgos/data/media/css/TableTools.css";
            @import "../consulta/estadisticas/riesgos/data/media/css/jquery.modal.css";
        tr.odd td.sorting_1,tr.even td.sorting_1{
			 background-color: transparent;  
		}
		   .odd{
			   background-color: #e2e4ff;
		   }
		   .even{
			 background-color: white;  
		   }  
		   tr.odd:hover,tr.even:hover{
			   background-color: yellow;
			   cursor: pointer;
		   }
		   .ClasOnclikColor{
				background-color: red;
		   }
		   
        </style>
		<link type="text/css" href="../educacionContinuada/css/normalize.css" rel="stylesheet">
		<link media="screen, projection" type="text/css" href="../educacionContinuada/css/style.css" rel="stylesheet">
		<link media="screen, projection" type="text/css" href="css/style.css" rel="stylesheet"> 
        <script type='text/javascript' language="javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery-ui-1.8.21.custom.min.js"></script>   
        <script type="text/javascript" language="javascript" src="../consulta/estadisticas/riesgos/data/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8" src="../consulta/estadisticas/riesgos/data/media/js/ColVis.js"></script>
        <script type="text/javascript" charset="utf-8" src="../consulta/estadisticas/riesgos/data/media/js/ZeroClipboard.js"></script>
        <script type="text/javascript" charset="utf-8" src="../consulta/estadisticas/riesgos/data/media/js/TableTools.js"></script>
        <script type="text/javascript" charset="utf-8" src="../consulta/estadisticas/riesgos/data/media/js/jquery.modal.js"></script>
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
                                 $('#demo').before( oTableTools.dom.container );
        		} );
        	/**************************************************************/
            
      
        </script>
      </head>	
  <html>
    <body class="body"> 
    <div id="pageContainer">
	<?php 
    //writeMenu(1);
    $Menu = $C_Permisos->PermisoUsuarioConvenio($db,$userid,2,2);
    
    for($i=0;$i<count($Menu['Data']);$i++){
        $URL[]    = $Menu['Data'][$i]['Url'];
        
        $Nombre[] = $Menu['Data'][$i]['Nombre'];
        
        if($Menu['Data'][$i]['ModuloSistemaId']==2){
            $Active[] = '1';    
        }else{
            $Active[] = '0';
        }
    }//for
    
    //$C_Menu_Global->writeMenu2($URL,"Sistema de Convenios",$Nombre,$Active);
     ?>   
    <div id="container">
     <center>
                <h1>LISTA INSTITUCIONES</h1>
            </center>      	
     <div id="demo">
       <div class="DTTT_container">     
        <?php if($Acceso['Rol']=='1'){?>
        <button  id="ToolTables_example_5" class="DTTT_button DTTT_button_text"  title="Nueva Instituci&oacute;n" />
        <span>Nueva Instituci&oacute;n</span> <?php }?>
        <button id="ToolTables_example_6" class="DTTT_button DTTT_button_text DTTT_disabled" title="Nueva Ubicaci&oacute;n"  >
        <span>Nueva Ubicaci&oacute;n</span>                
        </button>
        <button id="ToolTables_example_7" class="DTTT_button DTTT_button_text DTTT_disabled" title="Lista Ubicaci&oacute;n">
        <span>Lista Ubicaci&oacute;n</span>                
        </button>
        </div> 
        <input type="hidden" id="IdInstitucion" />
           <table cellpadding="0" cellspacing="0" border="1" class="display" id="example">
                <thead>
                    <tr>
                        <th>Código Institución</th>
                        <th>Nombre Institución</th>
                        <th>Nit</th>          
                        <th>Teléfono</th>
                        <th>Email</th>
						<th>Ubicaciones</th>
                        <th>Estado</th>
                        <th>Detalles</th>
                   </tr>
                </thead>
            <tbody>  
            <?php
                $sQl="SELECT s.InstitucionConvenioId, s.NombreInstitucion, s.Nit, s.Telefono, s.Email, 
				e.nombreestado FROM InstitucionConvenios s JOIN siq_estadoconvenio e ON e.idsiq_estadoconvenio = s.idsiq_estadoconvenio and s.InstitucionConvenioId <> '0'";
				//echo $sQl; die;                   
                $valores = $db->Execute($sQl);
                $datos =  $valores->getarray();
                $totaldatos=count($datos);
                if ($totaldatos>0){
                    $i = 1;
                    foreach($valores as $datos1){
                        /*$class="odd";
						if(intval($$variable) % 2 == 0){
							$class="even";
						}*/
                    ?>
                        <tr id="Tr_File_<?PHP echo $datos1['InstitucionConvenioId']?>"  >
                        
                            <td valign="top"><?php echo $datos1['InstitucionConvenioId']?></td>
                            <td valign="top"><?php echo $datos1['NombreInstitucion']?></td>
                            <td valign="top"><?php echo $datos1['Nit']?></td>
                            <td valign="top"><?php echo $datos1['Telefono']?></td>
                            <td valign="top"><?php echo $datos1['Email']?></td>
							<td valign="top">
                            <ul>
                            <?php 
                            $sqlubicacion = "select NombreUbicacion from UbicacionInstituciones where InstitucionConvenioId = '".$datos1['InstitucionConvenioId']."' and codigoestado=100";
                            //echo $sqlubicacion;
							$valoresubicaicon=$db->Execute($sqlubicacion);
                            $datosubicacion =  $valoresubicaicon->getarray();
                            $totaldatosU=count($datosubicacion);
                            if ($totaldatosU>0)
                            {
                                foreach($valoresubicaicon as $datosU)
                                {
                                   ?>
                                   <li><?php echo $datosU['NombreUbicacion'];?></li> 
                                   <?php          
                                }
                            }
                            ?>
                            </ul>
                            </td>
                            <td valign="top"><?php echo $datos1['nombreestado']?></td>
                            <td valign="top">
                                <form action="detalleInstitucion.php" method="post">
                                    <input type="hidden" name="Detalle" id="Detalle" value="<?php echo $datos1['InstitucionConvenioId']?>" />
                                    <input type="image" src="../mgi/images/file_search.png" width="20">
                                </form>
                            </td>
                        </tr>
                    <?php           
                    $i++; 
                    }//foreach
                }//if
            ?>                     
            </tbody>
        </table>
    </div>
   </div> 
   </div> <!-- pageContainer-->
   <script type="text/javascript">
        var aSelected = []; 
		$( "#example tbody tr" ).on( "click", function() {
			var id = this.id;
			id = id.replace("Tr_File_", ""); 
            var index = jQuery.inArray(id, aSelected);
                if ( $(this).children().hasClass('dataTables_empty') && index === -1  ) {
                    aSelected1.splice(index, 1);
                    $("#ToolTables_example_5").addClass('DTTT_disabled');
                    $("#ToolTables_example_6").addClass('DTTT_disabled');
                    $("#ToolTables_example_7").addClass('DTTT_disabled');
                }else{
                    aSelected.push(id); 
                    //alert(aSelected+' '+aSelected.length);
                    if (aSelected.length>1) aSelected.shift();
                   // alert(aSelected+' '+aSelected.length);
                    $('#example tr.row_selected').removeClass('row_selected');
                    $(this).addClass('row_selected');
                    $("#ToolTables_example_5").removeClass('DTTT_disabled');                    
                    $("#ToolTables_example_6").removeClass('DTTT_disabled');
                    $("#ToolTables_example_7").removeClass('DTTT_disabled');
                }
		}); 

			$('#ToolTables_example_5').click( function () {  
                if(!$('#ToolTables_example_5').hasClass('DTTT_disabled'))
                {NuevaInstitucion(); }
            } );		

			$('#ToolTables_example_6').click( function () {  
                if(!$('#ToolTables_example_6').hasClass('DTTT_disabled'))
                {
					if(aSelected.length==1){
                        var id = aSelected[0];
                           NuevaUbicacion(id);
                      } else{
                            return false;
                      }                  
					
				}
            } );

			$('#ToolTables_example_7').click( function () {  
                if(!$('#ToolTables_example_7').hasClass('DTTT_disabled'))
                {
					if(aSelected.length==1){
                        var id = aSelected[0];
                           ListaUbicacion(id);
                      } else{
                            return false;
                      }                  
					
				}
            } );
   </script>
  </body>
</html>