<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once(realpath(dirname(__FILE__)).'/../EspacioFisico/templates/template.php');
    require_once(realpath(dirname(__FILE__))."/../modelos/convenios/SolicitudConvenios.php");
    include_once(realpath(dirname(__FILE__)).'/Permisos/class/PermisosConvenio_class.php'); $C_Permisos = new PermisosConvenio();
    include_once(realpath(dirname(__FILE__)).'/../mgi/Menu.class.php');        $C_Menu_Global  = new Menu_Global();
    
    if(!$db){
    	$db = getBD();
    }
    $SQL_User='SELECT idusuario as id, codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
            
    if($Usario_id=&$db->GetRow($SQL_User)===false){
    		echo 'Error en el SQL Userid...<br>'.$SQL_User;
    		die;
    	}
    
    $userid=$Usario_id['id'];
    
    //$Acceso = $C_Permisos->PermisoUsuarioConvenio($db,$userid,1,12);
    //echo '<pre>'; print_r($Acceso);
    $Acceso2 = $C_Permisos->PermisoUsuarioConvenio($db,$userid, 1, 12);
    //echo '<pre>'; print_r($Acceso2);
    
    if($Acceso['val']===false && $Acceso2['val']===false){
        ?>
        <blink>
            <?PHP echo $Acceso['msn'];?>
        </blink>
        <?PHP
        Die;
    }

    $sqlS = "select idusuario from usuario where usuario = '" . $_SESSION['MM_Username'] . "'";
    $datosusuario = $db->GetRow($sqlS);
    $usuario = $datosusuario['idusuario'];
    
    $codigoFacultad = $_SESSION['codigofacultad'];
    $id = $_POST["id"];
    if(!isset ($id)){
        
        echo "<script>alert('Error de ingreso a los detalles de un convenio en trámite'); location.href='ConveniosEnTramite.php'; </script>";    
    }

$sqlsolicituddatos = "select FechaEnvioSolicitud, NumeroActa, ResponsableConvenio, CargoResponsableConvenio, CorreoResponsableConvenio, CelularResponsableConvenio, RepresentanteInstitucion, IdentificacionRepresentanteInstitucion, NombreContactoInstitucion, NombreInstitucion, CargoContactoInstitucion, CorreoContactoInstitucion, TelefonoContactoInstitucion, Ambito, DireccionInstitucion, ConvenioProcesoId, JustificacionSuscripcion, JustificacionImpacto, ObjetivoGeneral, ObjetivoEspecifico, Compromiso, DuracionConvenioId, ResponsableAcademico, Actividades, ResultadoEsperado  from SolicitudConvenios sc where sc.SolicitudConvenioId = '".$id."'";
//echo $sqlsolicituddatos;
$consultasolicitud = $db->GetRow($sqlsolicituddatos);

$Fecha = $consultasolicitud['FechaEnvioSolicitud']; 
$numeroacataconsejo = $consultasolicitud['NumeroActa'];
$responsableconvenio = $consultasolicitud['ResponsableConvenio'];
$cargoresponsableconvenio = $consultasolicitud['CargoResponsableConvenio'];
$correoresponsableconvenio = $consultasolicitud['CorreoResponsableConvenio'];
$celularresponsableconvenio = $consultasolicitud['CelularResponsableConvenio'];

$representanteinstitucion = $consultasolicitud['RepresentanteInstitucion'];
$identificacionrepresentanteinstitucion = $consultasolicitud['IdentificacionRepresentanteInstitucion'];
$nombrecontactoinstitucion = $consultasolicitud['NombreContactoInstitucion'];
$cargocontactoinstitucion = $consultasolicitud['CargoContactoInstitucion'];
$correocontactoinstitucion = $consultasolicitud['CorreoContactoInstitucion'];
$telefonocontactoinstitucion = $consultasolicitud['TelefonoContactoInstitucion'];
$Ambito = $consultasolicitud['Ambito'];
$direccioninstitucion = $consultasolicitud['DireccionInstitucion'];
$nombreinstitucion = $consultasolicitud['NombreInstitucion'];
$ConvenioProcesoId = $consultasolicitud['ConvenioProcesoId'];
$justificacionsuscripcion = $consultasolicitud['JustificacionSuscripcion'];
$justificacionimpacto = $consultasolicitud['JustificacionImpacto'];
$objetivogeneral = $consultasolicitud['ObjetivoGeneral'];
$objetivoespecifico = $consultasolicitud['ObjetivoEspecifico'];
$compromiso = $consultasolicitud['Compromiso'];
$duracionconvenioid = $consultasolicitud['DuracionConvenioId'];
$responsableacademico = $consultasolicitud['ResponsableAcademico'];
$actividades = $consultasolicitud['Actividades'];
$resultadoesperado = $consultasolicitud['ResultadoEsperado'];
$activ = $consultasolicitud['ResultadoEsperado'];

//echo 'proceso '.$ConvenioProcesoId;

?>
<html>
    <head>
        <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleDatos.css" type="text/css" /> 
        <link rel="stylesheet" href="cssEmail/style.css" type="text/css" />
        <link rel="stylesheet" href="uploadify/uploadify.css" type="text/css" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Solicitud Facultad</title>
        <style type="text/css" title="currentStyle">
            @import "../consulta/estadisticas/riesgos/data/media/css/demo_page.css";
            @import "../consulta/estadisticas/riesgos/data/media/css/demo_table_jui.css";
            @import "../consulta/estadisticas/riesgos/data/media/css/ColVis.css";
            @import "../consulta/estadisticas/riesgos/data/media/css/TableTools.css";
            @import "../consulta/estadisticas/riesgos/data/media/css/jquery.modal.css";
        </style>
        
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript" language="javascript" src="js/funcionesPropuestas.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/functions.js"></script>
        <script type="text/javascript" language="javascript" src="js/funcionesConvenios.js"></script>
        
        <script>
            function Regresar()
            {
                location.href = "../convenio/Propuestaconvenio.php";
            }
        </script>
        <script>
        function val_texto(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==8) return true;
            patron = /[a-zA-ZñÑ\s]+$/;
            te = String.fromCharCode(tecla);
            return patron.test(te);
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
        <div align="center" id="container">	
        <?php if($Acceso2['Rol']== '2' || $Acceso2['Rol']== '3'){ if($ConvenioProcesoId!='3'){ ?>
			<table class="tablagris">
				<tr>
					<td colspan="2" class="titulo" align="center">Información de Unidad Académica Solicitante de Convenio</td>
				</tr>
				<tr>
					<td>Fecha de Solicitud:</td><td><?php echo $Fecha; ?></td>
				</tr>
				<tr>
					<td>Programa Académico <span style="color: red;">*</span></td>
					<td><ul>		
					    <?php
					    $sqlCarrera = "SELECT c.codigocarrera, c.nombrecarrera FROM SolicitudConvenioCarrera scc INNER JOIN carrera c ON c.codigocarrera = scc.codigocarrera WHERE
	scc.SolicitudConvenioID = '".$id."' AND scc.CodigoEstado = '100' ORDER BY c.nombrecarrera";
					    $carreras = $db->GetAll($sqlCarrera);
                        foreach ($carreras as $carrera) {
							?>
                            <li value="<?php echo $carrera['codigocarrera'] ?>"><?php echo $carrera['nombrecarrera'] ?></li>
                            <?php
						}
						?></ul>
                    </td>
				</tr>
				<tr>
					<td>Acta Consejo Facultad (PDF):<span style="color: red;">*</span> </td>
					<td>
                    <?php
                     $sqlarchivo = "select Url from SolicitudAnexos where SolicitudConvenioId = '".$id."' and TipoAnexoId = '8'";
                     $consulta = $db->GetRow($sqlarchivo);
                    ?>						
                        <input name="archivo" type="hidden" id="archivo" value="<?php echo $consulta['Url']; ?>"/>
                        <a href='<?php echo $consulta['Url']?>' target="_blank"><img src='../mgi/images/file_document.png' width='50' height='37'  border="0" alt=""/></a>
					</td>
				</tr>
				<tr>
					<td>N°Acta Consejo de Facultad donde se aprobó solicitud de Gestión de Convenio <span style="color: red;">*</span></td>
					<td><?php echo $numeroacataconsejo; ?></td>
				</tr>
				<tr>
					<td>Responsable del Convenio en Facultad <span style="color: red;">*</span></td>
					<td><?php  echo $responsableconvenio; ?></td>
				</tr>
				<tr>
					<td>Cargo <span style="color: red;">*</span></td>
					<td><?php echo $cargoresponsableconvenio; ?></td>
				</tr>
				<tr>
					<td>Correo Electrónico <span style="color: red;">*</span></td>
					<td><?php  echo $correoresponsableconvenio; ?></td>
				</tr>
				<tr>
					<td>Teléfono celular</td>
					<td><?php echo $celularresponsableconvenio; ?></td>
				</tr>
                <tr>
		    		<td>Nombre Institución:<span style="color: red;">*</span></td>
                    <td><?php echo $nombreinstitucion; ?></td>
		    	</tr>
			</table>
            <table class="tablagris">
				<tr>
					<td colspan="2" align="center" class="titulo">Datos de la entidad contraparte</td>
				</tr>
				<tr>
					<td>Nombre del Representante legal <span style="color: red;">*</span></td>
					<td><?php echo $representanteinstitucion; ?></td>
				</tr>
				<tr>
					<td>Documento de Identificación <span style="color: red;">*</span></td>
					<td><?php echo $identificacionrepresentanteinstitucion; ?></td>
				</tr>
				<tr>
					<td>Nombre del Contacto en la Institución <span style="color: red;">*</span></td>
					<td><?php echo $nombrecontactoinstitucion; ?></td>
				</tr>
				<tr>
					<td>Cargo <span style="color: red;">*</span></td>
					<td><?php echo $cargocontactoinstitucion; ?></td>
				</tr>
				<tr>
					<td>Correo Electrónico <span style="color: red;">*</span></td>
					<td><?php echo $correocontactoinstitucion; ?></td>
				</tr>
				<tr>
					<td>Teléfono Celular / Fijo</td>
					<td><?php echo $telefonocontactoinstitucion; ?></td>
				</tr>
                <tr>
                    <td>Ambito</td>
                    <td><?php if($Ambito == '1'){echo "Internacional";}  if($Ambito == '2'){echo "Nacional";}?></td>
                </tr>
				<tr>
					<td>Dirección Institución<span style="color: red;">*</span></td>
					<td><?php echo $direccioninstitucion; ?></td>
				</tr>
			</table>
            <table>
				<tr>
					<td colspan="2" align="center" class="titulo">JUSTIFICACIÓN</td>
				</tr>
				<tr>
					<td style="background-color:#DDD;" colspan="2"><center>Descripción de la pertinencia de la suscripción</center></td>
				</tr>
				<tr>
					<td colspan="2">
                        <textarea readonly="true" style="height:auto;"><?php  echo $justificacionsuscripcion;?></textarea>
                    </td>
				</tr>
				<tr>
					<td style="background-color:#DDD;" colspan="2"><center>Descripción del Impacto sobre la comunidad académica (estudiantes, académicos, directivos, administrativos y egresados)</center></td>
				</tr>
				<tr>
					<td colspan="2"><textarea  readonly="true" style="height:auto;"><?php echo $justificacionimpacto; ?></textarea></td>
				</tr>				
			</table>
            <table>
			<tr>
					<td colspan="2" class="titulo" align="center">OBJETIVOS</td>
				</tr>
				<tr>
					<td style="background-color:#DDD;" align="center">General</td>
					<td style="background-color:#DDD;" align="center">Específicos</td>
				</tr>
				<tr>
					<td><textarea readonly="true"><?php echo $objetivogeneral; ?></textarea></td>
					<td><textarea readonly="true"><?php echo $objetivoespecifico; ?></textarea></td>
				</tr>
				<tr>
					<td style="background-color:#DDD;" align="center" colspan="2">Compromisos</td>
				</tr>
				<tr>
					<td colspan="2"><textarea readonly="true"><?php echo $compromiso; ?></textarea></td>
				</tr>
				<tr>
					<td style="background-color:#DDD;">Duración estimada del convenio<span style="color: red;">*</span></td>
					<td>
					    <ul>					        
					        <?php
					        $sqlDuracionConvenio = "select idsiq_duracionconvenio, nombreduracion from siq_duracionconvenio where idsiq_duracionconvenio = '".$duracionconvenioid."'";
					        $duracionConvenios = $db->GetRow($sqlDuracionConvenio);
                            ?>
                            <li><?php echo $duracionConvenios['nombreduracion'] ?></li>
					    </ul>
					</td>
				</tr>
				<tr>
					<td style="background-color:#DDD;">Responsable académico (Documento Docente)<span style="color: red;">*</span></td>
					<td><?php echo $responsableacademico; ?></td>
				</tr>
				<tr>
					<td style="border-color: #ccc; border-style: solid; border-width: 1px;"><center>Actividades<span style="color: red;">*</span></center></td>
					<td><textarea readonly="true"><?php  echo $actividades; ?></textarea></td>
				</tr>
				<tr>
					<td style="border-color: #ccc; border-style: solid; border-width: 1px;"><center>Resultados Esperados<span style="color: red;">*</span></center></td>
					<td><textarea readonly="true" ><?php echo $resultadoesperado; ?></textarea></td>
				</tr>
		    		</table>
                    <?php }}
                    if($ConvenioProcesoId != '3')
                    {
                    ?>
                <table>
			<tr>
				<td style="background-color:#DDD;" align="center" colspan="2">Anexos</td>
			</tr>
				<tr>
					<td>Carta de solicitud por parte de Decano de la Facultad o Director de Posgrados:<span style="color: red;">*</span> </td>
					<td id="archivo1">
                    <?php
                        $sql="SELECT s.Nombre, s.Url, s.SolicitudAnexoId FROM SolicitudAnexos s where s.TipoAnexoId ='1' and s.SolicitudConvenioId = '".$id."' and s.CodigoEstado = '100';"; 
                        $consultar = $db->GetRow($sql);
                        if($consultar['Nombre'])
                        {
                            ?><strong><?php echo $consultar['Nombre']?></strong>
                            <input type="hidden" id="indicador1" name="indicador1" value="1" />
                            <input name="archivoCarta" type="hidden" id="archivoCarta" value="<?php echo $consultar['Url']; ?>"/> 
                            <a href='<?php echo $consultar['Url']?>' target="_blank"><img src='../mgi/images/file_document.png' width='50' height='37'  border="0" alt=""/></a>
                            <?php    
                        }else
                        { 
                            ?>
                            Archivo no disponible. 
                            <?php
                        }
                        ?>
					</td>
				</tr>
				<tr>
					<td>Proyecto de Convenio:</td>
					<td id="archivo2">
                        <?php
                        $sql="SELECT s.Nombre, s.Url, s.SolicitudAnexoId FROM SolicitudAnexos s where s.TipoAnexoId ='2' and s.SolicitudConvenioId = '".$id."' and s.CodigoEstado = '100';"; 
                        $consultar = $db->GetRow($sql);
                        if($consultar['Nombre'])
                        {
                            ?><strong><?php echo $consultar['Nombre']?></strong>
                            <input type="hidden" id="indicador2" name="indicador2" value="1" />
                            <input name="archivoConvenio" type="hidden" id="archivoConvenio" value="<?php echo $consultar['Url']; ?>"/> 
                            <a href='<?php echo $consultar['Url']?>' target="_blank"><img src='../mgi/images/Microsoft_Office_2007_Word.png' width='40' height='37'  border="0" alt=""/></a>
                            <?php 
                        }
                        else
                        { 
                            ?>
                            Archivo no disponible. 
                            <?php
                        }
                        ?>                      
					</td>
				</tr>
				<tr>
					<td>Certificado Cámara de comercio o Representación legal de la contraparte:<span style="color: red;">*</span> </td>
					<td id="archivo3">
                        <?php
                        $sql="SELECT s.Nombre, s.Url, s.SolicitudAnexoId FROM SolicitudAnexos s where s.TipoAnexoId ='3' and s.SolicitudConvenioId = '".$id."' and s.CodigoEstado = '100';"; 
                        $consultar = $db->GetRow($sql);
                        if($consultar['Nombre'])
                        {
                            ?><strong><?php echo $consultar['Nombre']?></strong>
                            <input type="hidden" id="indicador3" name="indicador3" value="1" />
                            <input name="archivoCamara" type="hidden" id="archivoCamara" value="<?php echo $consultar['Url']; ?>"/>
                            <a href='<?php echo $consultar['Url']?>' target="_blank"><img src='../mgi/images/file_document.png' width='50' height='37'  border="0" alt=""/></a>
                            <?php
                         }else
                        {
                           ?>
                        Archivo no disponible. 
                        <?php 
                        }
                        ?>
					</td>
				</tr>
				<tr>
					<td>Documento de Identidad de Representante Legal:<span style="color: red;">*</span> </td>
					<td id="archivo4">
                    <?php
                    $sql="SELECT s.Nombre, s.Url, s.SolicitudAnexoId FROM SolicitudAnexos s where s.TipoAnexoId ='4' and s.SolicitudConvenioId = '".$id."' and s.CodigoEstado = '100';"; 
                    $consultar = $db->GetRow($sql);
                    if($consultar['Nombre'])
                    {
                        ?><strong><?php echo $consultar['Nombre']?></strong>
                        <input type="hidden" id="indicador4" name="indicador4" value="1" />
                        <input name="archivoRepresentante" type="hidden" id="archivoRepresentante" value="<?php echo $consultar['Url']; ?>"/>
                        <a href='<?php echo $consultar['Url']?>' target="_blank"><img src='../mgi/images/file_document.png' width='50' height='37'  border="0" alt=""/></a>
                      <?php
                     }else
                    {
                       ?>
                        Archivo no disponible. 
                        <?php 
                    }
                    ?>      
					</td>
				</tr>
				<tr>
					<td>Plan de trabajo:</td>
					<td id="archivo5">
                    <?php
                    $sql="SELECT s.Nombre, s.Url, s.SolicitudAnexoId FROM SolicitudAnexos s where s.TipoAnexoId ='5' and s.SolicitudConvenioId = '".$id."' and s.CodigoEstado = '100';"; 
                    $consultar = $db->GetRow($sql);
                    if($consultar['Nombre'])
                    {
                        ?><strong><?php echo $consultar['Nombre']?></strong>
                       <input type="hidden" id="indicador5" name="indicador5" value="1" />
                       <input name="archivoPlan" type="hidden" id="archivoPlan" value="<?php echo $consultar['Url']; ?>"/>
                       <a href='<?php echo $consultar['Url']?>' target="_blank"><img src='../mgi/images/file_document.png' width='50' height='37'  border="0" alt=""/></a>
                     <?php
                     }else
                    {
                       ?>
                        Archivo no disponible. 
                        <?php 
                    }
                    ?>
					</td>
				</tr>
				<tr>
					<td>Presupuesto:</td>
					<td id="archivo6">                
                    <?php
                    $sql="SELECT s.Nombre, s.Url, s.SolicitudAnexoId FROM SolicitudAnexos s where s.TipoAnexoId ='6' and s.SolicitudConvenioId = '".$id."' and s.CodigoEstado = '100';"; 
                    $consultar = $db->GetRow($sql);
                    if($consultar['Nombre'])
                    {
                        ?><strong><?php echo $consultar['Nombre']?></strong>
                        <input type="hidden" id="indicador6" name="indicador6" value="1" />
                         <input name="archivoPresupuesto" type="hidden" id="archivoPresupuesto" value="<?php echo $consultar['Url']; ?>"/>
                        <a href='<?php echo $consultar['Url']?>' target="_blank"><img src='../mgi/images/file_document.png' width='50' height='37'  border="0" alt=""/></a>
                    <?php
                     }else
                    {
                       ?>
                        Archivo no disponible. 
                        <?php 
                    }
                    ?>
					</td>
				</tr>
                <tr>
                 <td>Formulario de Solicitud</td>
                    <td id="archivo7">
                        <a href='./VistaPropuestaPdf.php?id=<?PHP echo $id;?>' target="_blank"><img src='../mgi/images/file_document.png' width='50' height='37'  border="0" alt=""/></a>
                    </td>
                </tr>
                <tr>
                    <td colspan="5"><hr /></td>
                </tr>
	    		</table> 
                <?php
                }
                 //3 Administrador Facultad (FACULTADES)
                //2 Administrador Convenios (OFICINA DE DESARROLLO)
                //1 Administrador Jurídico (SECREATRIA GENERAL)   
                if($Acceso2['Rol']== '2' ){
                     if($ConvenioProcesoId == '10' || $ConvenioProcesoId == '2' || $ConvenioProcesoId == '11'){?>
                     <table>
                     <tr>
                        <td>
                            <div>
                            <form id="formularioarchivo1" method="post">
                                <table style="width: 400px;">
                                    <tr>
                                   	   <td style="background-color:#DDD;" colspan="2"><center>Certificado Cámara de comercio o Representación legal de la contraparte</center></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="hidden" id="Action_id" name="Action_id" value="SaveFile" />
                                            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
                                            <input type="hidden" id="TipoAnexo" name="TipoAnexo" value="3" />
                                            <input type="hidden" id="usuario" name="usuario" value="<?php echo $usuario;?>" />
                                            <input name="archivoConvenio" type="file" id="archivoConvenio" accept=".pdf"/>
                                        </td>
                                        <td><input type="button" value="Subir Archivo" onclick="CargarArchivo('#formularioarchivo1')"/></td></td>
                                    </tr>
                                </table>
                                </form>
                            </div>
                        </td>
                        <td>
                            <div>
                             <form id="formularioarchivo2" method="post">
                            <table style="width: 400px;">
                                <tr>
                               	   <td style="background-color:#DDD;" colspan="2"><center>Documento de Identidad de Representante Legal</center></td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="hidden" id="Action_id" name="Action_id" value="SaveFile" />
                                        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
                                         <input type="hidden" id="TipoAnexo" name="TipoAnexo" value="4" />
                                        <input type="hidden" id="usuario" name="usuario" value="<?php echo $usuario;?>" />
                                        <input name="archivoConvenio" type="file" id="archivoConvenio" accept=".pdf"/>
                                    </td>
                                    <td><input type="button" value="Subir Archivo" onclick="CargarArchivo('#formularioarchivo2')"/></td></td>
                                </tr>
                            </table>
                            </form>
                            </div>
                        </td>
                     </tr>
                     <tr>
                        <td colspan="2" align="center">
                            <div>
                                 <form id="formularioarchivo3" method="post">
                            <table style="width: 400px;">
                                <tr>
                               	   <td style="background-color:#DDD;" colspan="2"><center>Proyecto del Convenio</center></td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="hidden" id="Action_id" name="Action_id" value="SaveFile" />
                                        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
                                        <input type="hidden" id="TipoAnexo" name="TipoAnexo" value="2" />
                                        <input type="hidden" id="usuario" name="usuario" value="<?php echo $usuario;?>" />
                                        <input name="archivoConvenio" type="file" id="archivoConvenio" accept="application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword"/>
                                    </td>
                                    <td><input type="button" value="Subir Archivo" onclick="CargarArchivo('#formularioarchivo3')"/></td></td>
                                </tr>
                            </table>
                            </form>
                            </div>
                        </td>
                     </tr>
                     </table>
                <br />
                 <?php }
                 }
                    ?>
                     <div style="overflow-y: scroll; width: 900px; height: 200px;">
                    <table>
                        <tr>
                   	        <td style="background-color:#DDD;" colspan="3"><center>Seguimiento Solicitud</center></td>
                        </tr>
                        <tr>
                            <th>Etapa</th>
                            <th>Usuario</th>
                            <th>Fecha Solicitud</th>
                        </tr>
                        <?php
                            $sqletapas = "select c.Nombre, u.usuario, l.FechaCreacion from LogSolicitudConvenios l INNER JOIN ConvenioProceso c ON c.ConvenioProcesoId = l.ConvenioProcesoId INNER JOIN usuario u ON u.idusuario = l.UsuarioCreacion where l.SolicitudConvenioId = '".$id."' order by FechaCreacion DESC";
                            //echo $sqletapas;
                            $listaetapas = $db->Getall($sqletapas);
                            foreach($listaetapas as $etapas)
                            {
                             ?>
                                <tr>
                                    <td><?php echo $etapas['Nombre'];?></td>
                                    <td><?php echo $etapas['usuario'];?></td>
                                    <td><?php echo $etapas['FechaCreacion'];?></td>
                                </tr>
                             <?php   
                            }
                         ?>
                    </table>
                    </div>
                     <br />
                    <?PHP 
                    if($Acceso2['Rol']== '2')
                    {
                        if($ConvenioProcesoId == '10' || $ConvenioProcesoId == '2' || $ConvenioProcesoId == '11'){
                            if($ConvenioProcesoId == '11'){
                                $Check_Contra = 'checked="checked"';
                            }else{
                                $Check_Contra = '';
                            }
                    ?>
                    <table>
                        <tr>
                            <td style="background-color:#DDD; text-align: center;">
                                <input type="checkbox" id="EnvioContraparte" <?PHP echo $Check_Contra?> name="EnvioContraparte" value="11" onclick="CambioProceso(<?PHP echo $id?>)" title="Revisión por la Contraparte" style="cursor: p;;" />&nbsp;&nbsp;<strong>Revisión por la Contraparte.</strong><!-- Estado y valor corespondiente a tabla Convenioproceso -->
                            </td>
                        </tr>
                    </table>
                    <?PHP
                        }
                    }
                    ?>
                <table>
                    <tr>
                   	   <td style="background-color:#DDD;" colspan="2"><center>Observaciones</center></td>
                    </tr>
                    <tr>
                    <td colspan="2">
                    <center>
                    <div style="overflow-y: scroll; width: 900px; height: 200px;">
                    <table >
                    <?php
                    $sqlobservaciones = "SELECT o.ObservacionSolicitudId, o.Observacion, o.FechaCreacion, u.usuario FROM ObservacionSolicitudes o INNER JOIN usuario u ON u.idusuario = o.Usuario WHERE o.SolicitudConvenioId = '".$id."' AND o.codigoestado = '100' order by ObservacionSolicitudId DESC";
                    $observaciones = $db->GetAll($sqlobservaciones);
                    foreach($observaciones as $listaobservacion)
                    {
                    ?>
                        <tr>
                            <td><li><?php echo $listaobservacion['Observacion']?></li></td>
                            <td><?php echo $listaobservacion['usuario']." - ".$listaobservacion['FechaCreacion']?></td>
                        </tr>        
                    <?php 
                    } 
                    ?></table>
                    </div>
                    </center>
                    </td>
                    </tr>
                   <?php
                     if($Acceso2['Rol']== '1' || $Acceso2['Rol']== '11'){
                        if($ConvenioProcesoId=='5' || $ConvenioProcesoId=='12'){
                            if($ConvenioProcesoId=='5' && $Acceso2['Rol']== '1'){
                                $TextoBoton = 'Enviar Secretaria General';
                                $VerBox = false;
                            }else if($ConvenioProcesoId=='12' && $Acceso2['Rol']== '11'){
                                $TextoBoton = 'Enviar Validación Jurídica';
                                $VerBox = true;
                            }
                            
                            if($VerBox){
                           ?>
                            <tr>
                                <td>
                                    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
                                    <input type="hidden" id="rol" name="rol" value="<?PHP echo $Acceso2['Rol']?>" />
                                    <input type="hidden" id="usuario" name="usuario" value="<?php echo $usuario; ?>" />
                                    <textarea id="observaciones" name="observaciones" class="required" onkeypress="return val_texto(event)"></textarea>
                                </td>
                                <td>
                                    <form>
                                        <input type="button" class="boton" id="guardarobservaciones" name="guardarobservaciones" value="Solicitar Ajustes Desarrollo" onclick="GuardarObservaciones()" />
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><hr /></td>
                            </tr>
                            <?PHP 
                            }
                            ?>
                            <tr>
                               <td style="background-color:#DDD;" colspan="2"><center>Observaciones Jurídicas</center></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                <center>
                                    <div style="overflow-y: scroll; width: 900px; height: 200px;">
                                        <table >
                                        <?php
                                        
                                        $Condicion = 'l.ConvenioProcesoId IN  (5,12)';
                                        
                                        
                                        $sqlobservaciones = "SELECT o.ObservacionSolicitudId, o.Observacion, o.FechaCreacion, u.usuario 
                                                             FROM ObservacionSolicitudes o 
                                                             INNER JOIN usuario u ON u.idusuario = o.Usuario 
                                                             INNER JOIN LogSolicitudConvenios l ON l.LogSolicitudConvenioId=o.LogSolicitudConvenioId
                    
                                                             WHERE o.SolicitudConvenioId = '".$id."' AND ".$Condicion." AND o.codigoestado = '100' order by ObservacionSolicitudId DESC";
                                        $observaciones = $db->GetAll($sqlobservaciones);
                                        foreach($observaciones as $listaobservacion)
                                        {
                                        ?>
                                        <tr>
                                            <td><li><?php echo $listaobservacion['Observacion']?></li></td>
                                            <td><?php echo $listaobservacion['usuario']." - ".$listaobservacion['FechaCreacion']?></td>
                                        </tr>        
                                        <?php 
                                        } 
                                        ?>
                                        </table>
                                    </div>
                                </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
                                    <input type="hidden" id="rol" name="rol" value="<?PHP echo $Acceso2['Rol']?>" />
                                    <input type="hidden" id="usuario" name="usuario" value="<?php echo $usuario; ?>" />
                                    <textarea id="observaciones_2" name="observaciones_2" class="required" onkeypress="return val_texto(event)"></textarea>
                                </td>
                                <td>
                                    <form>
                                        <input type="button" class="boton" id="guardarobservaciones" name="guardarobservaciones" value="<?PHP echo $TextoBoton?>" onclick="GuardarObservaciones(1)" />
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><hr /></td>
                            </tr>
                           <?PHP 
                        }
                    }
                        //3 Administrador Facultad (FACULTADES)
                        //2 Administrador Convenios (OFICINA DE DESARROLLO)
                        //1 Administrador Jurídico (SECREATRIA GENERAL)
                    if($Acceso2['Rol']== '1'){
                        if($ConvenioProcesoId == '4'){
                        ?>
                    <tr>
                        <td>
                            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
                            <input type="hidden" id="rol" name="rol" value="1" />
                            <input type="hidden" id="usuario" name="usuario" value="<?php echo $usuario; ?>" />
                            <textarea id="observaciones" name="observaciones" class="required" onkeypress="return val_texto(event)"></textarea>
                        </td>
                        <td>
                            <form>
                            <input type="button" class="boton" id="guardarobservaciones" name="guardarobservaciones" value="Solicitar Ajustes Desarrollo" onclick="GuardarObservaciones()" />
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><hr /></td>
                    </tr>
                    <?php }
                    }
                    if($Acceso2['Rol']== '2')
                     {
                        if($ConvenioProcesoId == '10' || $ConvenioProcesoId == '2' || $ConvenioProcesoId == '11'){
                    ?>
                         <tr>
                        <td>
                            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
                            <input type="hidden" id="rol" name="rol" value="2" />
                            <input type="hidden" id="usuario" name="usuario" value="<?php echo $usuario; ?>" />
                            <textarea id="observaciones" name="observaciones" class="required" onkeypress="return val_texto(event)"></textarea>
                        </td>
                        <td>
                            <form>
                            <input type="button" class="boton" id="guardarobservaciones" name="guardarobservaciones" value="Solicitar Ajustes Facultad" onclick="GuardarObservaciones()" />
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><hr /></td>
                    </tr>
                    <?php
                    }
                    //firma de la contra parte
                    if($ConvenioProcesoId == '3' || $ConvenioProcesoId == '8')
                    {
                        if($ConvenioProcesoId == '8')
                        {
                            $disabled = 'disabled="disabled"';
                            $Check = 'checked="checked"';
                        }
                    ?>
                        <tr>
                            <td>
                            <center>
                            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
                            <input type="hidden" id="usuario" name="usuario" value="<?php echo $usuario; ?>" />
                            <input type="checkbox" id="contraparte" name="contraparte" onchange="contraparte()" <?php echo $disabled; echo $Check; ?> />FIRMA DE LA CONTRAPARTE
                            </center> 
                            </td>
                        </tr>
                    <?php
                    }
                    }
                    ?>
                    <tr>
                        <td>
                        <form action="ConveniosEnTramite.php">
                            <input type="submit"   id="RegresarConveniosTramite" name="RegresarConveniosTramite" value="Regresar"  />
                        </form>
                        </td>
                    <?php
                    //2 Administrador Convenios (OFICINA DE DESARROLLO)
                     if($Acceso2['Rol']== '2' ){
                         if($ConvenioProcesoId == '10' || $ConvenioProcesoId == '2' || $ConvenioProcesoId == '11'){
                            $buscarinstitucion = "Select NombreInstitucion, InstitucionConvenioId from SolicitudConvenios where SolicitudConvenioId = '".$id."'";
                            $resultadoinstitucion = $db->GetRow($buscarinstitucion);
                            if($resultadoinstitucion['InstitucionConvenioId'] == '0')
                            {
                                $sqlinstitucion = "select SolicitudInstitucionId from SolicitudInstituciones where SolicitudConvenioId = '".$id."'"; 
                                //echo $sqlinstitucion;                          
                                $institucion = $db->GetRow($sqlinstitucion);
                                if(!$institucion['SolicitudInstitucionId'])
                                {
                                    ?>
                                    <td>
                                    <form action="PropuestaIsntitucionDesarrollo.php" method="post">
                                        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
                                        <input type="Submit" class="boton" id="continuar" name="continuar" value="Continuar" />
                                    </form>
                                    </td>
                                </tr>
                                 <tr>
                                    <td colspan="2"><hr /></td>
                                </tr>
                                <?php   
                                }else
                                {
                                    ?>
                                    <td>
                                    <form id="PasoSGeneral" method="post">
                                        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
                                        <input type="hidden" id="usuario" name="usuario" value="<?php echo $userid; ?>" />
                                        <input type="Button" class="boton" id="PasoSecretariaGeneral" name="PasoSecretariaGeneral" value="Enviar a Secretaria General" onclick="GuradarProcesoDesarrollo()"  />
                                        </form>
                                    </td>
                                </tr>
                                 <tr>
                                    <td colspan="2"><hr /></td>
                                </tr>
                                <?php
                                }
                            }
                            else
                            {
                                ?>
                                    <td>
                                    <form id="PasoSGeneral" method="post">
                                        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
                                        <input type="hidden" id="usuario" name="usuario" value="<?php echo $userid; ?>" />
                                        <input type="Button" class="boton" id="PasoSecretariaGeneral" name="PasoSecretariaGeneral" value="Enviar a Secretaria General" onclick="GuradarProcesoDesarrollo()"  />
                                        </form>
                                    </td>
                                </tr>
                                 <tr>
                                    <td colspan="2"><hr /></td>
                                </tr>
                                <?php
                            }
                         }
                    }
                    if($Acceso2['Rol']== '11'){
                       ?>
                       <tr>
                            <td>
                            <form action="" id="PasoFirmas" method="post">
                                <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
                                <input type="hidden" id="usuario" name="usuario" value="<?php echo $usuario; ?>" />
                                <input type="hidden" id="Action_id" name="Action_id" value="PasoFirmasProceso" />
                                <input type="button" class="boton" id="PasoFirmasProceso" name="PasoFirmasProceso" value="Paso A Firmas" onclick="PasoFirmasFinales()"  />
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><hr /></td>
                        </tr>
                       <?PHP  
                    }
                    //1 Administrador Jurídico (SECREATRIA GENERAL) 
                    if($Acceso2['Rol']== '1' ){
                         if($ConvenioProcesoId == '4'){
                    ?>
                     <tr>
                        <td>
                        <form action="" id="PasoSGeneral" method="post">
                            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
                            <input type="hidden" id="usuario" name="usuario" value="<?php echo $usuario; ?>" />
                            <input type="hidden" id="Action_id" name="Action_id" value="PasoJuridico" />
                            <input type="button" class="boton" id="PasoRevisonJuridica" name="PasoRevisonJuridica" value="Paso A Revisión Jurídica" onclick="PasoSecretariaGeneral()"  />
                            </form>
                        </td>
                    </tr>
                     <tr>
                        <td colspan="2"><hr /></td>
                    </tr>
                    <?php }
                    }?>
                </table>
		</div>
        <script>
        
           
            $('#PasoSecretariaGeneral').click(function(event) {
            event.preventDefault();
            });
             $('#guardarobservaciones').click(function(event) {
            event.preventDefault();
            });
            $('#PasoRevisonJuridica').click(function(event) {
            event.preventDefault();
            });
        </script>
    </body>
</html>