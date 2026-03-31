<?php

function listaEstudiantes($db, $periodoinicial,$periodo,$ubicacionfacultad, $and_adicional)
{
    $SqlRotaciones="SELECT e.numerodocumento, e.idestudiantegeneral, e.nombresestudiantegeneral, e.apellidosestudiantegeneral, r.FechaIngreso, r.FechaEgreso, r.Totalhoras, r.TotalDias, r.codigocarrera, r.idsiq_convenio, r.IdUbicacionInstitucion, ui.NombreUbicacion, er.NombreEstado, r.JornadaId, r.codigomateria, i.NombreInstitucion, ui.DomicilioUbicacion, r.RotacionEstudianteId, r.codigoperiodo
						FROM Convenios c INNER JOIN RotacionEstudiantes r ON r.idsiq_convenio = c.ConvenioId 
						INNER JOIN InstitucionConvenios i ON i.InstitucionConvenioId = r.IdInstitucion 
						INNER JOIN UbicacionInstituciones ui ON ui.InstitucionConvenioId = i.InstitucionConvenioId 
						INNER JOIN estudiante es ON es.codigoestudiante = r.codigoestudiante 
						INNER JOIN estudiantegeneral e ON e.idestudiantegeneral = es.idestudiantegeneral 
						INNER JOIN EstadoRotaciones er ON er.EstadoRotacionId = r.EstadoRotacionId 
						WHERE 
					    r.EstadoRotacionId=1 
						AND r.codigoperiodo BETWEEN '".$periodoinicial."' AND '".$periodo."' ".$ubicacionfacultad." ". $and_adicional." GROUP BY RotacionEstudianteId";
    $valoresRotacion = $db->GetAll($SqlRotaciones);    
    return $valoresRotacion;
}//listaEstudiantes


function datosEstudiante ($db, $idestudiantegeneral, $codigocarrera)
{
    $sqlestudiante = "SELECT e.semestre, e.codigoperiodo, e.numerocohorte, e.codigoestudiante, eg.nombresestudiantegeneral, eg.apellidosestudiantegeneral, eg.numerodocumento, c.nombrecarrera, c.codigocarrera  FROM estudiante e INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral = e.idestudiantegeneral INNER JOIN carrera c on c.codigocarrera = e.codigocarrera WHERE e.idestudiantegeneral = '".$idestudiantegeneral."' AND e.codigocarrera = '".$codigocarrera."'";   
    $valoresEstudiante = $db->GetAll($sqlestudiante);
    return $valoresEstudiante; 
}//datosEstudiante

function servicios ($db, $RotacionEstudianteId)
{
    $sqlservicios = "SELECT ec.Especialidad FROM RotacionEspecialidades re INNER JOIN EspecialidadCarrera ec ON ec.EspecialidadCarreraId = re.EspecialidadCarreraId         WHERE re.RotacionEstudianteId = '".$RotacionEstudianteId."' AND re.CodigoEstado = '100';";
    $resultadoservicios = $db->GetAll($sqlservicios);      
    return $resultadoservicios;
}//servicios


function creditosEstudiante($db, $codigoestudiante, $semestre)
{
    $sqlcreditos = "SELECT sum( d.numerocreditosdetalleplanestudio ) AS totalcreditossemestre, d.idplanestudio FROM detalleplanestudio d, planestudioestudiante p   WHERE d.idplanestudio = p.idplanestudio AND p.codigoestudiante = '".$codigoestudiante."' AND d.semestredetalleplanestudio = '".$semestre."' AND p.codigoestadoplanestudioestudiante LIKE '1%'   AND d .codigotipomateria NOT LIKE '4'   AND d.codigotipomateria NOT LIKE '5' ";
    $numerocreditos = $db->GetRow($sqlcreditos);
    
    return $numerocreditos;
    
}//creditosEstudiante

function ValorSemestre($db,$periodo, $semestre, $codigocarrera)
{
    $sqlvalorsemestre= "SELECT dc.valordetallecohorte, 	cc.codigomodalidadacademica FROM cohorte c INNER JOIN detallecohorte dc ON dc.idcohorte = c.idcohorte INNER JOIN carrera cc ON cc.codigocarrera = c.codigocarrera WHERE c.codigoperiodo = '".$periodo."' AND dc.codigoconcepto = '151' AND dc.semestredetallecohorte = '".$semestre."' AND c.codigocarrera = '".$codigocarrera."'";
    $valorsemestre= $db->GetRow($sqlvalorsemestre);
    return $valorsemestre; 
}//ValorSemestre

function diasSemestre($db, $periodo, $codigomateria)
{
    $sqltotaldiassemestre = "SELECT g.fechainiciogrupo, g.fechafinalgrupo, m.numerocreditos, m.nombremateria, g.codigomateria  FROM grupo g, materia m WHERE g.codigoperiodo='".$periodo."' and g.codigomateria='".$codigomateria."' and m.codigomateria = g.codigomateria";    
    $diassemestre = $db->GetRow($sqltotaldiassemestre);
    return $diassemestre;
}


function CalcularContrapestacion($db, $idconvenio,$tipopracticante, $codigocarrera)
{
    //consulta de la contraprestacion, se consulta por el tipo de participante, carrera y convenio.    
     $sqlcontraprestacion = "SELECT C.ValorContraprestacion, C.IdTipoPagoContraprestacion, 	tpc.NombrePagoContraprestacion  from Contraprestaciones C  INNER JOIN conveniocarrera cc ON cc.IdContraprestacion = C.IdContraprestacion AND cc.codigoestado ='100' INNER JOIN TipoPagoContraprestaciones tpc on tpc.IdTipoPagoContraprestacion = C.IdTipoPagoContraprestacion WHERE C.ConvenioId = '".$idconvenio."' and C.codigoestado = '100' and C.IdTipoPracticante ='".$tipopracticante."' and cc.codigocarrera = '".$codigocarrera."'";         
    $valorcontrapestacion = $db->GetRow($sqlcontraprestacion);
    return $valorcontrapestacion; 
}

function Formula ($db, $codigocarrera, $idconvenio, $valoresformula)
{
     $sqlentidades = "SELECT cc.IdContraprestacion, f.formula FROM conveniocarrera cc INNER JOIN Convenios c ON c.ConvenioId = cc.ConvenioId INNER JOIN InstitucionConvenios ic ON ic.InstitucionConvenioId = c.InstitucionConvenioId LEFT JOIN FormulaLiquidaciones f ON f.ConvenioId = c.ConvenioId AND f.codigocarrera = cc.Codigocarrera WHERE cc.codigocarrera = '".$codigocarrera."' and cc.ConvenioId = '".$idconvenio."'";
    $formula = $db->GetRow($sqlentidades);
    
    $sqlcampos = "SELECT cf.CamposFormulaId, cf.Nombre FROM CamposFormulas cf where cf.codigoestado ='100'";
    $campos = $db->GetAll($sqlcampos);
    
    if($formula['formula'])
    {
        $formula = $formula['formula'];        
        $formulatotal ='(';
        $formulaNombre ='';
        $datos = explode(",", $formula);
        $numero = count($datos);         
        $f='a';
        for($i=0;$i<=$numero;$i++)
        {                            
            if($f=='a')
            {                                
                foreach($campos as $nombres)
                {
                    $numeros = explode("-", $datos[$i]);
                    if($numeros[0]== '12' || $numeros[0]== '11' || $numeros[0]== '3' || $numeros[0]== '6' || $numeros[0]== '9')
                    {
                        if($nombres['CamposFormulaId'] == $numeros[0])
                        {                                        
                            $formulatotal.= $numeros[1]." ";
                            $formulaNombre.= $nombres['Nombre']."(".$numeros[1].") ";
                            if ($i == 2)
                            {
                                $formulatotal.=")";
                            }
                            $f='b';
                        }
                    }else
                    {
                        if($nombres['CamposFormulaId'] == $datos[$i])
                        {                                        
                            $formulatotal.= $valoresformula[$nombres['CamposFormulaId']];
                            $formulaNombre.= $nombres['Nombre']." ";
                            if ($i == 2)
                            {
                                $formulatotal.=")";
                            }
                            $f='b';
                        }
                    }//else                    
                }//foreach
            }else
            {
                if($f=='b')
                { 
                    switch($datos[$i]){
                        case '1':{ $formulatotal.= "* "; $formulaNombre.= "* "; $f='a';}break;
                        case '2':{ $formulatotal.= "/ "; $formulaNombre.= "/ "; $f='a';}break;
                        case '3':{ $formulatotal.= "- "; $formulaNombre.= "- "; $f='a';}break;
                        case '4':{ $formulatotal.= "+ "; $formulaNombre.= "+ "; $f='a';}break;
                        case '':{ $f=0;}break;
                    }//switch
                }//if
            }//else
        } //for         
        
        eval("\$var = $formulatotal;");            
        
        $formulasalida['formula'] = $formulaNombre;
        $formulasalida['total'] = $var;        
    }//if formula
    else
    {
        $formulasalida['formula'] = "sin formula definida";
        $formulasalida['total'] = "0";
    }
    return $formulasalida;
}//Formula
?>