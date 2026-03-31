<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once (realpath(dirname(__FILE__)).'/../EspacioFisico/templates/template.php');
    require_once(realpath(dirname(__FILE__))."/../modelos/convenios/SolicitudConvenios.php");

    if(!$db){
    	$db = getBD();
    }
    $id = $_POST['id'];

    $sqlsolicitud = "select NombreInstitucion, RepresentanteInstitucion, IdentificacionRepresentanteInstitucion, DireccionInstitucion, NombreContactoInstitucion, ResponsableConvenio, CargoResponsableConvenio, CorreoResponsableConvenio, CelularResponsableConvenio, CorreoContactoInstitucion, CargoContactoInstitucion, TelefonoContactoInstitucion, DuracionConvenioId from SolicitudConvenios where SolicitudConvenioId = '".$id."'";
    $consulta = $db->GetRow($sqlsolicitud);

    $nombreinstitucion = $consulta['NombreInstitucion'];

    $RepresentanteInstitucion = $consulta['RepresentanteInstitucion'];
    $IdentificacionRepresentanteInstitucion = $consulta['IdentificacionRepresentanteInstitucion'];
    $CargoContactoInstitucion = $consulta['Cargo'];
    $direccioninstitucion = $consulta['DireccionInstitucion'];
    
    $NombreSupervisor = $consulta['NombreContactoInstitucion'];
    $CorreoSupervisor = $consulta['CorreoContactoInstitucion'];
    $CargoSupervisor = $consulta['CargoContactoInstitucion'];
    $TelefonoSupervisor = $consulta['TelefonoContactoInstitucion'];
    
    $NombreSolicitante = $consulta['ResponsableConvenio'];
    $CargoSolicitante = $consulta['CargoResponsableConvenio'];
    $CorreoResponsableConvenio = $consulta['CorreoResponsableConvenio'];
    $TelefonoResponsableConvenio = $consulta['CelularResponsableConvenio'];
    
    $DuracionConvenioId = $consulta['DuracionConvenioId'];
?>
<html>
 <head>
        <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleDatos.css" type="text/css" /> 
        <link rel="stylesheet" href="cssEmail/style.css" type="text/css" />
        <link rel="stylesheet" href="uploadify/uploadify.css" type="text/css" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Solicitud Propuesta Institucion</title>
        <style type="text/css" title="currentStyle">
            @import "../consulta/estadisticas/riesgos/data/media/css/demo_page.css";
            @import "../consulta/estadisticas/riesgos/data/media/css/demo_table_jui.css";
            @import "../consulta/estadisticas/riesgos/data/media/css/ColVis.css";
            @import "../consulta/estadisticas/riesgos/data/media/css/TableTools.css";
            @import "../consulta/estadisticas/riesgos/data/media/css/jquery.modal.css";
        </style>
        
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/functions.js"></script>
        <script type="text/javascript" language="javascript" src="js/funcionesPropuestas.js"></script>
        <script type="text/javascript" language="javascript" src="js/funcionesConvenios.js"></script>
        <script>
        function val_texto(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==8) return true;
            patron = /[a-zA-ZÒ—\s]+$/;
            te = String.fromCharCode(tecla);
            return patron.test(te);
        }
        function val_dirrecion(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==8) return true;
            patron =/[0-9a-zA-ZÒ—-\s]+$/;            
            te = String.fromCharCode(tecla);
            return patron.test(te);
        }
         function val_numero(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==8) return true;
            patron =/[0-9-]+$/;            
            te = String.fromCharCode(tecla);
            return patron.test(te);
        }
        </script>
         <script>
        function val_email(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==8) return true;
            patron = /[0-9a-zA-Z\-\.\@\s]+$/;
            te = String.fromCharCode(tecla);
            return patron.test(te);
        }
        </script>
        <script>
            function Regresar()
            {
                location.href = "../convenio/Propuestaconvenio.php";
            }
        </script>
  <style>
			table{
				width:80%;
				align:"center";
			}
			
			#container{
				margin-top:10px;
			}
			.titulo{
				font-size:16px;
				font-weight:bold;
				background-color:#CCC;
			}
			.tablagris tr td:first-child{
				background-color:#DDD;
                width: 420px;
			}
			textarea{
				width:95%;
			}
			.boton{
				width:50%;
			}
		</style>
    </head>
    <body>
        <div>
            <div align="center" id="container">
            <form id="NuevaInstitucion" action="" method="post">
                <input type="hidden" id="Action_id" name="Action_id" value="SaveData" />
                <input type="hidden" id="duracion" name="duracion" value="<?php echo $DuracionConvenioId;?>" />	
                <table class="tablagris">
                    <tr>
    					<td colspan="2" class="titulo" align="center">Institucion Convenio</td>
    				</tr>
                    <tr>
                        <td>Nombre InstituciÛn:<span style="color: red;">*</span></td>
                        <td><input type="text" id="nombreinstitucion" name="nombreinstitucion" value="<?php echo $nombreinstitucion; ?>" class="required" onkeypress="return val_texto(event)" /></td>
                    </tr>
                    <tr>
                        <td>Ciudad:<span style="color: red;">*</span></td>
                        <td>
                        <select id="ciudadid" name="ciudadid" class="required">
                        <option value=""></option>
                            <?php
                               $sqlciudades = "SELECT c.idciudad, c.nombreciudad FROM ciudad c INNER JOIN departamento d ON d.iddepartamento = c.iddepartamento WHERE d.idpais = '1';";
                               $datos = $db->GetAll($sqlciudades);
                               foreach($datos as $ciudades)
                               {
                                ?>
                                    <option value="<?php echo $ciudades['idciudad']; ?>"><?php echo $ciudades['nombreciudad']; ?></option>
                                <?php 
                               } 
                            ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Direccion:</td>
                        <td><input type="text" id="Direccion" name="Direccion" value="<?php echo $direccioninstitucion; ?>" class="required" onkeypress="return val_dirrecion(event)" /></td>
                    </tr>
                    <tr>
                        <td>Tipo de institucion :</td>
                        <td>
                        <select id="tipoinstitucion" name="tipoinstitucion" class="required" onchange="ValidarInstitucion()">
                        <option value=""></option>
                            <?php
                               $sqltipoinstitucion = "SELECT idsiq_tipoinstitucion, nombretipoinstitucion FROM siq_tipoinstitucion;";
                               $datos = $db->GetAll($sqltipoinstitucion);
                               foreach($datos as $tipoinstituciones)
                               {
                                ?>
                                    <option value="<?php echo $tipoinstituciones['idsiq_tipoinstitucion']; ?>"><?php echo $tipoinstituciones['nombretipoinstitucion']; ?></option>
                                <?php 
                               } 
                            ?>
                        </select>
                        </td>
                    </tr>
                    <!--<tr id="Tr_Instituciones">
                    </tr>-->
                    </table>
                    <table class="tablagris">
                    <tr>
    					<td colspan="2" class="titulo" align="center">Representante Legal</td>
    				</tr>
                    <tr>
                        <td>Representante Legal:</td>
                        <td><input type="text" id="RepresentanteLegal" name="RepresentanteLegal" value="<?php echo $RepresentanteInstitucion; ?>" class="required" onkeypress="return val_texto(event)"/></td>
                    </tr>
                    <tr>
                        <td>Representante identificacion:</td>
                        <td><input type="text" id="IdentificacionRepresentante" name="IdentificacionRepresentante" value="<?php echo $IdentificacionRepresentanteInstitucion; ?>" class="required" onkeypress="return val_numero(event)" /></td>
                    </tr>
                </table>
                <table class="tablagris">
                    <tr>
    					<td colspan="2" class="titulo" align="center">Supervisor</td>
    				</tr>
                    <tr>
                        <td>Nombre:</td>
                        <td><input type="text" id="nombresupervisor" name="nombresupervisor" value="<?php echo $NombreSupervisor; ?>" class="required" onkeypress="return val_texto(event)"/></td>
                    </tr>
                    <tr>
                        <td>Correo:</td>
                        <td><input type="text" id="correosupervisor" name="correosupervisor" value="<?php echo $CorreoSupervisor; ?>" class="required" onkeypress="return val_email(event)" /></td>
                    </tr>
                    <tr>
                        <td>Cargo:</td>
                        <td><input type="text" id="cargosupervisor" name="cargosupervisor" value="<?php echo $CargoSupervisor; ?>" class="required" onkeypress="return val_texto(event)"/></td>
                    </tr>
                    <tr>
                        <td>Telefono:</td>
                        <td><input type="text" id="telefonosupervisor" name="telefonosupervisor" value="<?php echo $TelefonoSupervisor; ?>" class="required" onkeypress="return val_numero(event)" /></td>
                    </tr>
                </table>
                <table class="tablagris">
                    <tr>
    					<td colspan="2" class="titulo" align="center">Solicitante</td>
    				</tr>
                    <tr>
                        <td>Nombre:</td>
                        <td><input type="text" id="nombresolicitante" name="nombresolicitante" value="<?php echo $NombreSolicitante; ?>" class="required" onkeypress="return val_texto(event)"/></td>
                    </tr>
                    <tr>
                        <td>Cargo:</td>
                        <td><input type="text" id="cargosolicitante" name="cargosolicitante" value="<?php echo $CargoSolicitante; ?>" class="required" onkeypress="return val_texto(event)"/></td>
                    </tr>
                    <tr>
                        <td>Correo:</td>
                        <td><input type="text" id="correosolicitante" name="correosolicitante" value="<?php echo $CorreoResponsableConvenio; ?>" class="required" onkeypress="return val_email(event)"/></td>
                    </tr>
                    <tr>
                        <td>Telefono:</td>
                        <td><input type="text" id="telefonosolicitante" name="telefonosolicitante" value="<?php echo $TelefonoResponsableConvenio; ?>" class="required" onkeypress="return val_numero(event)" /></td>
                    </tr>
                </table>
                <center>
                <table width="600" id="botones"><tr>
                <td><input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
                <input type="button"  id="regresar" name="regresar" value="Regresar" onclick="RegresarDetalles()"/></td>
                <td align='right'><input type="button"  id="PasoSecretariaGeneral" name="PasoSecretariaGeneral" value="Enviar a Secretaria General" onclick="ValidarNuevaInstitucion('#NuevaInstitucion')"  /></td>
                </tr>
                </table></center>
                </form>
            </div>
        </div>
    </body>
</html>
<?php

?>
