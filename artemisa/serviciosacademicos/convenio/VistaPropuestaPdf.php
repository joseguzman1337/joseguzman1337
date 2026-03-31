<?php    
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once (realpath(dirname(__FILE__)).'/../EspacioFisico/templates/template.php');
    if(!$db){
    	$db = getBD();
    }


$SQL_User='SELECT idusuario as id, codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
        
if($Usario_id=&$db->GetRow($SQL_User)===false){
		echo 'Error en el SQL Userid...<br>'.$SQL_User;
		die;
	}
$userid=$Usario_id['id'];


$sqlS = "select idusuario from usuario where usuario = '" . $_SESSION['MM_Username'] . "'";
$datosusuario = $db->GetRow($sqlS);
$usuario = $datosusuario['idusuario'];



$codigoFacultad = $_SESSION['codigofacultad'];
$id = $_REQUEST["id"];


$sqlsolicituddatos = "select FechaEnvioSolicitud, NumeroActa, ResponsableConvenio, CargoResponsableConvenio, CorreoResponsableConvenio, CelularResponsableConvenio, RepresentanteInstitucion, IdentificacionRepresentanteInstitucion, NombreContactoInstitucion, NombreInstitucion, CargoContactoInstitucion, CorreoContactoInstitucion, TelefonoContactoInstitucion, DireccionInstitucion, ConvenioProcesoId, JustificacionSuscripcion, JustificacionImpacto, ObjetivoGeneral, ObjetivoEspecifico, Compromiso, DuracionConvenioId, ResponsableAcademico, Actividades, ResultadoEsperado  from SolicitudConvenios sc where sc.SolicitudConvenioId = '".$id."'";

$consultasolicitud = $db->GetRow($sqlsolicituddatos);
//echo '<pre>'; print_r($consultasolicitud);die;

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


# Contenido HTML del documento que queremos generar en PDF.
$html= "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'
<html>
    <head>
         <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
        <title>Solicitud de Convenio de Facultad</title>
        <style>
			table{
				width:55%;
                
			}
		
			.titulo{
				font-size:16px;
				font-weight:bold;
				background-color:#CCC;
			}
			
		  tr{
                border: 1 solid #fff;
            }
            #contenedor{
                margin:20px;
                
            }
            #contenedor table{
                width:55%;
                margin: 0 auto;
            }
		</style>
        </head>
    <body>
        <div align='center' id='contenedor' >	
			<table  border=1>
				<tr>
					<td colspan='2' class='titulo' align='center'>Información de Unidad Académica Solicitante de Convenio</td>
				</tr>
				<tr>
					<td>Fecha de Solicitud:</td>
                    <td>".$Fecha."</td>
				</tr>
				<tr>
					<td>Programa Académico <span style='color: red;'>*</span></td>
                    <td><ul>";
                    $sqlCarrera = "SELECT c.codigocarrera, c.nombrecarrera FROM SolicitudConvenioCarrera scc INNER JOIN carrera c ON c.codigocarrera = scc.codigocarrera WHERE scc.SolicitudConvenioID = '".$id."' AND scc.CodigoEstado = '100' ORDER BY c.nombrecarrera";
                $carreras = $db->GetAll($sqlCarrera);
                foreach ($carreras as $carrera) {	
                $html.= "<li value=".$carrera['codigocarrera'].">".$carrera['nombrecarrera']."</li>";
                }
                $html.="</ul></td>
				</tr>			
				<tr>
					<td>N°Acta Consejo de Facultad donde se aprobó solicitud de Gestión de Convenio <span style='color: red;'>*</span></td>
					<td>".$numeroacataconsejo."</td>
				</tr>
				<tr>
					<td>Responsable del Convenio en Facultad <span style='color: red;'>*</span></td>
					<td>".$responsableconvenio."</td>
				</tr>
				<tr>
					<td>Cargo <span style='color: red;'>*</span></td>
					<td>".$cargoresponsableconvenio."</td>
				</tr>
				<tr>
					<td>Correo Electrónico <span style='color: red;'>*</span></td>
					<td>".$correoresponsableconvenio."</td>
				</tr>
				<tr>
					<td>Teléfono celular</td>
					<td>".$celularresponsableconvenio."</td>
				</tr>
                <tr>
		    		<td>Nombre Institución:<span style='color: red;'>*</span></td>
                    <td>".$nombreinstitucion."</td>
		    	</tr>
		
				<tr>
					<td colspan='2' align='center' class='titulo'>Datos de la entidad contraparte</td>
				</tr>
				<tr>
					<td>Nombre del Representante legal <span style='color: red;'>*</span></td>
					<td>".$representanteinstitucion."</td>
				</tr>
				<tr>
					<td>Documento de Identificación <span style='color: red;'>*</span></td>
					<td>".$identificacionrepresentanteinstitucion."</td>
				</tr>
				<tr>
					<td>Nombre del Contacto en la Institución <span style='color: red;'>*</span></td>
					<td>".$nombrecontactoinstitucion."</td>
				</tr>
				<tr>
					<td>Cargo <span style='color: red;'>*</span></td>
					<td>".$cargocontactoinstitucion."</td>
				</tr>
				<tr>
					<td>Correo Electrónico <span style='color: red;'>*</span></td>
					<td>".$correocontactoinstitucion."</td>
				</tr>
				<tr>
					<td>Teléfono Celular / Fijo</td>
					<td>".$telefonocontactoinstitucion."</td>
				</tr>
				<tr>
					<td>Dirección Institución<span style='color: red;'>*</span></td>
					<td>".$direccioninstitucion."</td>
				</tr>
                <tr>  
					<td colspan='2' align='center' class='titulo'>JUSTIFICACIÓN</td>
				 </tr>
				<tr>
					<td  colspan='2'>Descripción de la pertinencia de la suscripción</td>
				</tr>
				<tr>
					<td colspan='2'>
                        <textarea style='height:auto;'>".$justificacionsuscripcion."</textarea>
                    </td>
				</tr>
				<tr>
					<td  colspan='2'>Descripción del Impacto sobre la comunidad académica (estudiantes, académicos, directivos, administrativos y egresados)</td>
				</tr>
				<tr>
					<td colspan='2'><textarea  readonly='true' style='height:auto;'>".$justificacionimpacto."</textarea></td>
				</tr>				
			</table>
            <br>
            <br>
            <br>
            <table  border=1>
			    <tr>
					<td colspan='2' class='titulo' align='center'>OBJETIVOS</td>
				</tr>
				<tr>
					<td  align='center'>General</td>
					<td  align='center'>Específicos</td>
				</tr>
				<tr>
					<td><textarea readonly='true'>".$objetivogeneral."</textarea></td>
					<td><textarea readonly='true'>".$objetivoespecifico."</textarea></td>
				</tr>
				<tr>
					<td  align='center' colspan='2'>Compromisos</td>
				</tr>
				<tr>
					<td colspan='2'><textarea readonly='true'>".$compromiso."</textarea></td>
				</tr>
				<tr>
					<td >Duración estimada del convenio<span style='color: red;'>*</span></td>
					<td>
					    <ul>";					        
    $sqlDuracionConvenio = "select idsiq_duracionconvenio, nombreduracion from siq_duracionconvenio where idsiq_duracionconvenio = '".$duracionconvenioid."'";
	$duracionConvenios = $db->GetRow($sqlDuracionConvenio);
    
    $html.="<li>".$duracionConvenios['nombreduracion']."</li>
					    </ul>
					</td>
				</tr>
				<tr>
					<td >Responsable académico (Documento Docente)<span style='color: red;'>*</span></td>
					<td>".$responsableacademico."</td>
				</tr>
				<tr>
					<td style='border-color: #ccc; border-style: solid; border-width: 1px;'>Actividades<span style='color: red;'>*</span></td>
					<td><textarea readonly='true'>".$actividades."</textarea></td>
				</tr>
				<tr>
					<td style='border-color: #ccc; border-style: solid; border-width: 1px;'>Resultados Esperados<span style='color: red;'>*</span></td>
					<td><textarea readonly='true' >".$resultadoesperado."</textarea></td>
				</tr>
  		    </table>
		</div>
    </body>
</html>";

//echo $html;die;

require_once('../educacionContinuada/html2pdf/html2pdf.class.php');
   // try
    //{   
        $html2pdf = new HTML2PDF('L','A4','es', true, 'UTF-8', 0);
        //$html2pdf = new HTML2PDF('P','A4','es', true, 'UTF-8', 0);
		 $html2pdf->setDefaultFont('Arial');
        //$html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 0);
        //$html2pdf->pdf->SetDisplayMode('fullpage');
        //$html2pdf->WriteHTML($html, isset($_GET['vuehtml']));
        $html2pdf->WriteHTML($html);
        $html2pdf->Output('Formato_Solicitud_Convenios.pdf');
        //var_dump($content);
        //echo "<pre>";print_r($content);
  /*  }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }*/
?>