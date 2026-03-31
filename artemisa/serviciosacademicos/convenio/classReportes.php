<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
include_once ('../EspacioFisico/templates/template.php');
if (!isset($_SESSION['MM_Username'])) {
    //header('Location: ../../consulta/facultades/consultafacultadesv22.htm');
    echo "No ha iniciado sesión en el sistema";
    exit();
}
$cReporte = new classReportes();
$db = getBD();
if($reporteGeneral=$_POST['reporteGeneral'])
{
    $cReporte->dataConvenios($db);
}
function limpiarCadena($cadena) {
     $cadena = (ereg_replace('[^ A-Za-z0-9_ñÑáéíóúÁÉÍÓÚ\s]', '', $cadena));
     return $cadena;
}

class classReportes
{
    public function dataConvenios($db)
    {
		$selecEstado=$_POST['selecEstado'];
		$instituConvenio = $_POST['instituConvenio'];
		$fechaIni = $_POST['fechaIni'];
		$fechaFin = $_POST['fechaFin'];
		$ambito= $_POST['ambito'];
		$tipoConvenio=$_POST['tipoConvenio'];
        
        $selecEstado = limpiarCadena(filter_var($selecEstado,FILTER_SANITIZE_NUMBER_INT));
        $instituConvenio = limpiarCadena(filter_var($instituConvenio,FILTER_SANITIZE_NUMBER_INT));
        $ambito = limpiarCadena(filter_var($ambito,FILTER_SANITIZE_NUMBER_INT));
        $tipoConvenio = limpiarCadena(filter_var($tipoConvenio,FILTER_SANITIZE_NUMBER_INT));
		
		$SQl="SELECT c.ConvenioId, c.CodigoConvenio, c.NombreConvenio, c.FechaInicio, c.FechaFin, c.FechaClausulaTerminacion, e.nombreestado, c.tipoSolicitud,c.Ambito, I.NombreInstitucion,  T.nombretipoconvenio
		, I.Direccion, ci.nombreciudad
		FROM Convenios c
		JOIN siq_estadoconvenio e ON e.idsiq_estadoconvenio = c.idsiq_estadoconvenio 
		INNER JOIN InstitucionConvenios I ON I.InstitucionConvenioId=c.InstitucionConvenioId
		INNER JOIN siq_tipoconvenio T ON c.idsiq_tipoconvenio= T.idsiq_tipoconvenio
		INNER JOIN ciudad ci ON ci.idciudad = I.CiudadId";
        
        $SQL2="SELECT co.ConvenioId, IF(co.NombreConvenio IS NULL, SC.NombreInstitucion,co.NombreConvenio) as NombreConvenio, c.nombrecarrera, SC.ResponsableConvenio, SC.CorreoResponsableConvenio, SC.FechaEnvioSolicitud, SC.FechaCreacion as FechaInicio, SC.SolicitudConvenioId, U.usuario, cp.Nombre, cp.ConvenioProcesoId 
        FROM SolicitudConvenios SC
        INNER JOIN usuario U ON ( U.idusuario = SC.UsuarioCreacion ) 
        INNER JOIN SolicitudConvenioCarrera scc on scc.SolicitudConvenioId=SC.SolicitudConvenioId AND scc.CodigoEstado=100 
        INNER JOIN carrera c on c .codigocarrera=scc.codigocarrera 
        LEFT JOIN RelacionSolicitudConvenio rsc on rsc.SolicitudConvenioId=SC.SolicitudConvenioId AND rsc.CodigoEstado=100 
        LEFT JOIN Convenios co on co.ConvenioId=rsc.ConvenioID INNER JOIN ConvenioProceso cp ON cp.ConvenioProcesoId = SC.ConvenioProcesoId ";
        
		if (!empty($selecEstado))
		{
            if($selecEstado=='2')
            {
                $where= " WHERE";
                $SQL2.= "".$where." SC.PasoSolicitud = 0 and cp.ConvenioProcesoId = 8";
            }else
            {
                $where= " WHERE";
                $SQl.= "".$where." c.idsiq_estadoconvenio = '".$selecEstado."'";
            }
		}
		if (!empty($instituConvenio))
		{
			if(empty($where)){
				$where= " WHERE";
				$SQl.= "".$where." c.InstitucionConvenioId = '".$instituConvenio."'";
			}else{
				$SQl.= "AND c.InstitucionConvenioId = '".$instituConvenio."'";
			}
		}
		if (!empty($fechaIni)&& !empty($fechaFin))
		{
			if(empty($where)){
				$where= " WHERE";
				$SQl.= "".$where." c.FechaInicio <= '".$fechaIni."' AND c.FechaFin >='".$fechaFin."'";
			}else{
				$SQl.= "AND c.FechaInicio <= '".$fechaIni."' AND c.FechaFin >= '".$fechaFin."'";
			}
		}
		if (!empty($ambito))
		{
			if(empty($where)){
				$where= " WHERE";
				$SQl.= "".$where." c.ambito = '".$ambito."'";
			}else{
				$SQl.= "AND c.ambito = '".$ambito."'";
			}
		}
		if (!empty($tipoConvenio))
		{
			if(empty($where)){
				$where= " WHERE";
				$SQl.= "".$where." c.idsiq_tipoconvenio = '".$tipoConvenio."'";
			}else{
				$SQl.= "AND c.idsiq_tipoconvenio = '".$tipoConvenio."'";
			}
		}
        //if($selecEstado=='3'){echo $SQl; die;}
        
        if($selecEstado=='2')
        {   
            if($Consulta=&$db->Execute($SQL2)===false)
            {
                echo 'Error en el SQL de la Consulta....<br><br>'.$SQL2;
                die;
            }   
        }else
        {
            if($Consulta=&$db->Execute($SQl)===false)
            {
                echo 'Error en el SQL de la Consulta....<br><br>'.$SQl;
                die;
            }
        }
        
       $reporte=$Consulta->getArray();
       $convenios = "<table id='dataR' name='dataR' class='display' cellspacing='0' ><tr><th>Código Convenio</th><th>Nombre Convenio</th><th>Intitución Convenio</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Fecha Clausula</th><th>Estado</th><th>Tipo Solicitud</th><th>Ambito</th><th>Tipo Convenio</th><th>Contrapretaciones</th><th>Programas Academicos</th><th>Anexos</th><th>Domicilio</th><th>Dirección</th></tr>";
       foreach($reporte as $convenio)
       {
            if($convenio['Ambito']='1'){
            	$convenio['Ambito']='Internacional';
            }
            if($convenio['Ambito']='2'){
            	$convenio['Ambito']='Nacional';
            }
            $convenios.="<tr><td>".$convenio['CodigoConvenio']."</td><td>".$convenio['NombreConvenio']."</td><td>".$convenio['NombreInstitucion']."</td><td>".$convenio['FechaInicio']."</td><td>".$convenio['FechaFin']."</td><td>".$convenio['FechaClausulaTerminacion']."</td><td>".$convenio['nombreestado']."</td><td>".$convenio['tipoSolicitud']."</td><td>".$convenio['Ambito']."</td><td>".$convenio['nombretipoconvenio']."</td>";
            
            $sqlcontra = "SELECT tp.NombrePracticante, co.ValorContraprestacion, co.IdTipoPagoContraprestacion FROM Contraprestaciones co INNER JOIN TipoPracticantes tp on tp.IdTipoPracticante = co.IdTipoPracticante WHERE co.ConvenioId = '".$convenio['ConvenioId']."'";
            $contraprestaciones = $db->GetAll($sqlcontra);
            if(!empty($contraprestaciones))
            {
                $convenios.= "<td>";
               foreach($contraprestaciones as $datos)
                {
                    if($datos['IdTipoPagoContraprestacion']=='1')
                    {
                        $valor = "%";
                    }
                    if($datos['IdTipoPagoContraprestacion']=='2')
                    {
                        $valor = ".C";
                    }
                    $convenios.= "<li>".(int)$datos['ValorContraprestacion']." ".$valor." ".$datos['NombrePracticante']."</li>";
                }
                $convenios.= "</td>"; 
            }else
            {
                $convenios.= "<td>Sin Contraprestacion</td>";
            }
            
            if($selecEstado=='2')
            {
                $sqlprogramas = "SELECT c.nombrecarrera FROM SolicitudConvenioCarrera sc INNER JOIN carrera c ON c.codigocarrera = sc.codigocarrera WHERE sc.SolicitudConvenioId = '".$convenio['SolicitudConvenioId']."'";
                $programas = $db->GetAll($sqlprogramas);                
            }else
            {
                $sqlprogramas = "SELECT c.nombrecarrera FROM conveniocarrera cc INNER JOIN carrera c ON c.codigocarrera = cc.codigocarrera WHERE cc.ConvenioId = '".$convenio['ConvenioId']."' and  codigoestado='100'";
                $programas = $db->GetAll($sqlprogramas);
            }   
            if(!empty($programas))
            {
                $convenios.= "<td>";
                foreach($programas as $carreras)
                {
                    $convenios.= "<li>".$carreras['nombrecarrera']."</li>";
                }
                $convenios.= "</td>";
                
            }else
            {
                $convenios.= "<td>Sin Programas</td>";
            }
        
            
            $sqlanexos = "SELECT a.Consecutivo, t.nombretipoanexo, a.TotalCupos FROM AnexoConvenios a INNER JOIN siq_tipoanexo t ON t.idsiq_tipoanexo = a.idsiq_tipoanexo WHERE	a.ConvenioId = '".$convenio['ConvenioId']."' AND a.codigoestado = 100;";
            $anexos = $db->GetAll($sqlanexos);
            if(!empty($anexos))
            {
                $convenios.= "<td>";
                foreach($anexos as $datos)
                {
                     $convenios.= "<li>".$datos['Consecutivo']." ".$datos['nombretipoanexo']." cupos:".$datos['TotalCupos']."</li>";
                }
                $convenios.= "</td>";
            }else
            {
                $convenios.= "<td>Sin Anexos</td>";  
            }
			$convenios.= "<td>".$convenio['nombreciudad']."</td>";
			$convenios.= "<td>".$convenio['Direccion']."</td>";
             $convenios.= "</tr>";
       }
       $convenios.= "</table>";      
        if(!empty($reporte)){
            echo $convenios;
        }
        else
        {
           echo $convenios.="<tr><td>No existe información Disponible</td></tr></table>";
        }
    }
}