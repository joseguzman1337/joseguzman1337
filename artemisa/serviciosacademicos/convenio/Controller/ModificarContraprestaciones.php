<?php 
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
            
    $rutaVistas  = "../view"; /*carpeta donde se guardaran las vistas (html) de la aplicación */ 
    require_once(realpath(dirname(__FILE__))."/../../../Mustache/load.php"); /*Ruta a /html/Mustache */
	$template_index = $mustache->loadTemplate('listaconvenios'); /*carga la plantilla index*/
    $template_lista = $mustache->loadTemplate('lista'); /*carga la plantilla de las listas de contraprestacion*/
    $template_Detalles = $mustache->loadTemplate('detalles'); /*carga la plantilla de los detalles de contraprestacion*/     
    $template_Programas = $mustache->loadTemplate('programas'); /*carga la plantilla de los programas academicos*/
    $template_NuevoPrograma = $mustache->loadTemplate('nuevoprograma'); /*carga la plantilla de los detalles de los programas */
                  
    include_once (realpath(dirname(__FILE__)).'/../../EspacioFisico/templates/template.php');
    $db = getBD();    
    
    $Accion = $_POST['Accion'];
    
    switch($Accion)
    {
        case 'lista':
        {
            $idconvenio = $_POST['lista'];
            
            $nombreconvenion = "select NombreConvenio from Convenios where ConvenioId = '".$idconvenio."'";
            $nombre = $db->GetRow($nombreconvenion);
            
            $sqllista = "select (@row:=@row+1) AS row, sc.nombretipocontraprestacion, co.IdContraprestacion, tip.IdTipoPracticante, tip.NombrePracticante, tipco.IdTipoPagoContraprestacion, tipco.NombrePagoContraprestacion, TRUNCATE (co.ValorContraprestacion, 0) as 'ValorContraprestacion', co.codigoestado, e.nombreestado, co.ConvenioId, c.nombreconvenio 
            from (SELECT @ROW:=0) r, Contraprestaciones co 
            INNER JOIN TipoPracticantes tip ON tip.IdTipoPracticante = co.IdTipoPracticante
            INNER JOIN TipoPagoContraprestaciones tipco ON tipco.IdTipoPagoContraprestacion = co.IdTipoPagoContraprestacion
            INNER JOIN estado e ON e.codigoestado = co.codigoestado
            INNER JOIN siq_contraprestacion sc ON sc.idsiq_contraprestacion = co.idsiq_contraprestacion
            INNER JOIN Convenios c ON co.ConvenioId = c.ConvenioId
            WHERE co.ConvenioId = '".$idconvenio."' ORDER BY row";
            $listas = $db->GetAll($sqllista);
            echo $template_lista->render(array(
        			'title' => 'Lista Contraprestaciones',
                    'listas' => $listas,
                    'IdConvenio' => $idconvenio,
                    'nombreconvenio' => $nombre['NombreConvenio']
        		)
        	);
        }break;
        case 'detalles':
        {
            $convenioid = $_POST['Detalle'];
            $IdContraprestacion = $_POST['Detalle2'];
            
            $nombreconvenion = "select NombreConvenio from Convenios where ConvenioId = '".$convenioid."'";
            $nombre = $db->GetRow($nombreconvenion);
            
            $sqlcontrapretacion = "select co.IdContraprestacion,  sc.nombretipocontraprestacion, sc.idsiq_contraprestacion, tip.IdTipoPracticante, tip.NombrePracticante, tipco.IdTipoPagoContraprestacion, tipco.NombrePagoContraprestacion, co.ValorContraprestacion, co.codigoestado, e.nombreestado, co.Detalle 
            from Contraprestaciones co 
            INNER JOIN TipoPracticantes tip ON tip.IdTipoPracticante = co.IdTipoPracticante
            INNER JOIN TipoPagoContraprestaciones tipco ON tipco.IdTipoPagoContraprestacion = co.IdTipoPagoContraprestacion
            INNER JOIN estado e ON e.codigoestado = co.codigoestado
             INNER JOIN siq_contraprestacion sc ON sc.idsiq_contraprestacion = co.idsiq_contraprestacion
            WHERE co.IdContraprestacion = '".$IdContraprestacion."'";
                        
            $contraprestacion = $db->GetRow($sqlcontrapretacion);
            
            $sqltipopracticante="select IdTipoPracticante, NombrePracticante from TipoPracticantes where codigoestado ='100'";
            $tipospracticantes = $db->GetAll($sqltipopracticante);
            
            $sqltipopago = "select IdTipoPagoContraprestacion, NombrePagoContraprestacion from TipoPagoContraprestaciones WHERE codigoestado = '100'";
            $tipopagos = $db->GetAll($sqltipopago);
            
            $sqlestado = "select codigoestado, nombreestado from estado where codigoestado <> 300";
            $estados = $db->GetAll($sqlestado);
            
            $tipocontraprestacion = "select idsiq_contraprestacion, nombretipocontraprestacion from siq_contraprestacion ";
            $tiposcontra = $db->GetAll($tipocontraprestacion);
                        
            $ubicacion = "select ui.IdUbicacionInstitucion, ui.NombreUbicacion, ic.NombreInstitucion from Contraprestaciones c INNER JOIN UbicacionInstituciones ui on ui.IdUbicacionInstitucion = c.IdUbicacionInstitucion INNER JOIN InstitucionConvenios ic on ic.InstitucionConvenioId = ui.InstitucionConvenioId where c.IdContraprestacion = '".$IdContraprestacion."'";
            $listaubicacion = $db->GetRow($ubicacion);
            
            echo $template_Detalles->render(array(
        			'title' => 'CONTRAPRESTACION',
                    'nombreconvenio' => $nombre['NombreConvenio'],                    
                    'ubicaciones' => $listaubicacion,
                    'idtipopracticante' =>$contraprestacion['IdTipoPracticante'],
                    'practicante' =>$contraprestacion['NombrePracticante'],
                    'tipospracticantes' => $tipospracticantes,
                    'tipospagos' => $tipopagos,
                    'idtipopago' => $contraprestacion['IdTipoPagoContraprestacion'],
                    'nombrepago' => $contraprestacion['NombrePagoContraprestacion'],
                    'estados' => $estados,
                    'codigoestado'=> $contraprestacion['codigoestado'],
                    'nombreestado' => $contraprestacion['nombreestado'],
                    'ValorContraprestacion' => intval($contraprestacion['ValorContraprestacion']),
                    'IdContraprestacion'=> $contraprestacion['IdContraprestacion'],
                    'nombretipocontraprestacion' => $contraprestacion['nombretipocontraprestacion'],
                    'idsiq_contraprestacion'=> $contraprestacion['idsiq_contraprestacion'],
                    'articulo' => $contraprestacion['Detalle'],
                    'tiposcontra' => $tiposcontra,
                    'idconvenio' => $convenioid,
                    'accion' => 'update' 
        		)
        	);
            
        }break;
        case 'nuevo':
        {
            $convenioid = $_POST['Detalle'];
            
            $nombreconvenion = "select NombreConvenio from Convenios where ConvenioId = '".$convenioid."'";
            $nombre = $db->GetRow($nombreconvenion);
             
            $sqltipopracticante="select IdTipoPracticante, NombrePracticante from TipoPracticantes where codigoestado ='100'";
            $tipospracticantes = $db->GetAll($sqltipopracticante);
            
            $sqltipopago = "select IdTipoPagoContraprestacion, NombrePagoContraprestacion from TipoPagoContraprestaciones WHERE codigoestado = '100'";
            $tipopagos = $db->GetAll($sqltipopago);
            
            $sqlestado = "select codigoestado, nombreestado from estado where codigoestado <> 300";
            $estados = $db->GetAll($sqlestado);
            
            $tipocontraprestacion = "select idsiq_contraprestacion, nombretipocontraprestacion from siq_contraprestacion ";
            $tiposcontra = $db->GetAll($tipocontraprestacion);
            
            $ubicacion = "select i.NombreInstitucion, u.NombreUbicacion, u.IdUbicacionInstitucion from Convenios c INNER JOIN InstitucionConvenios i ON c.InstitucionConvenioId = i.InstitucionConvenioId INNER JOIN UbicacionInstituciones u ON u.InstitucionConvenioId = i.InstitucionConvenioId where c.ConvenioId = '".$convenioid."'";
            $listaubicacion = $db->GetAll($ubicacion);
            
             echo $template_Detalles->render(array(
        			'title' => 'NUEVA CONTRAPRESTACION',
                    'nombreconvenio' => $nombre['NombreConvenio'],
                    'idconvenio' => $convenioid,
                    'estados' => $estados,
                    'tipospagos' => $tipopagos,
                    'tipospracticantes' => $tipospracticantes,
                    'tiposcontra' => $tiposcontra,
                    'ubicaciones' => $listaubicacion,
                    'accion' => 'insert'
            		)
        	);
            
        }break;
        case 'programas':
        {
            $convenioid = $_POST['convenioid'];
            $Contraprestacion = $_POST['Contraprestacion'];
            
            $nombreconvenion = "select NombreConvenio from Convenios where ConvenioId = '".$convenioid."'";
            $nombre = $db->GetRow($nombreconvenion);
            
            $datoscontra = "SELECT siq.nombretipocontraprestacion, C.ValorContraprestacion, tp.NombrePagoContraprestacion
                            FROM Contraprestaciones C
                                     INNER JOIN siq_contraprestacion siq on siq.idsiq_contraprestacion = C.idsiq_contraprestacion
                                     INNER JOIN TipoPagoContraprestaciones tp on tp.IdTipoPagoContraprestacion = C.IdTipoPagoContraprestacion
                            WHERE C.IdContraprestacion = '".$Contraprestacion."'";
            $Contraprestaciondatos = $db->GetRow($datoscontra);
            
            $programas = "SELECT (@row:=@row+1) AS row, c.idconveniocarrera, c.codigocarrera, cc.nombrecarrera, cc.codigomodalidadacademica, m.nombremodalidadacademica, e.nombreestado, e.codigoestado
            FROM (SELECT @ROW:=0) r, conveniocarrera c 
            INNER JOIN carrera cc ON cc.codigocarrera = c.codigocarrera 
            INNER JOIN modalidadacademica m on m.codigomodalidadacademica = cc.codigomodalidadacademica 
            INNER JOIN estado e ON e.codigoestado = c.codigoestado 
            WHERE c.IdContraprestacion = '".$Contraprestacion."';";                        
            $lista_programas = $db->GetAll($programas);

             echo $template_Programas->render(array(
        			'title' => 'Programas Academicos',
                    'nombreconvenio' => $nombre['NombreConvenio'],
                    'nombrecontra' => $Contraprestaciondatos['nombretipocontraprestacion'].': '.intval($Contraprestaciondatos['ValorContraprestacion']).' '.$Contraprestaciondatos['NombrePagoContraprestacion'],
                    'lista_programas' => $lista_programas,
                    'idconvenio' => $convenioid,
                    'contraprestacion' => $Contraprestacion
                    ) 
           );
            
        }break;
        case 'nuevoprograma':
        {
            $idconvenio = $_POST['idconvenio'];
            $contraprestacion = $_POST['contraprestacion'];
            
            $nombreconvenion = "select NombreConvenio from Convenios where ConvenioId = '".$idconvenio."'";
            $nombre = $db->GetRow($nombreconvenion);
            
            $datoscontra = "SELECT siq.nombretipocontraprestacion, C.ValorContraprestacion FROM Contraprestaciones C
                            INNER JOIN siq_contraprestacion siq on siq.idsiq_contraprestacion = C.idsiq_contraprestacion WHERE C.IdContraprestacion = '".$contraprestacion."'";
            $Contraprestaciondatos = $db->GetRow($datoscontra);
            
            $tipopracticante = "SELECT idtipopracticante FROM Contraprestaciones where IdContraprestacion = '".$contraprestacion."'";
            $Practicate = $db->GetRow($tipopracticante);
           
           switch($Practicate['idtipopracticante'])
           {
            case '1':{
                $and  = " and codigomodalidadacademica = '200'";
            }break;
            case '2':{
                $and  = " and codigomodalidadacademica = '300'";
            }break;
            case '3':{
                $and  = "";
            }break;
           } 
            
            $tiposmodalidades = "SELECT codigomodalidadacademica, nombremodalidadacademica FROM modalidadacademica where codigoestado = '100'".$and;
            $modalidad = $db->GetAll($tiposmodalidades);
            
            echo $template_NuevoPrograma->render(array(
        			'title' => 'Programa Academico Detalles',
                    'nombreconvenio' => $nombre['NombreConvenio'],
                    'nombrecontra' => $Contraprestaciondatos['nombretipocontraprestacion'].' Valor: '.intval($Contraprestaciondatos['ValorContraprestacion']),
                    'modalidad' => $modalidad,
                    'idconvenio' => $idconvenio,
                    'IdContraprestacion' => $contraprestacion
                    ) 
           );
            
        }break;
        case '':
        {         
            $sqlconvenios = "SELECT (@ROW :=@ROW + 1) AS ROW, co.ConvenioId, co.NombreConvenio, ic.NombreInstitucion, sit.nombretipoconvenio 
            FROM
            (SELECT @ROW := 0) r, Convenios co 
            INNER JOIN InstitucionConvenios ic ON ic.InstitucionConvenioId = co.InstitucionConvenioId
            INNER JOIN siq_tipoconvenio sit ON sit.idsiq_tipoconvenio = co.idsiq_tipoconvenio
            WHERE
            	co.idsiq_estadoconvenio = '1' ORDER BY ROW;";
            $datosconvenios=$db->GetAll($sqlconvenios); 
            
             echo $template_index->render(array(
        			'title' => 'Gestion Contraprestaciones',
                    'convenios' => $datosconvenios 
        		)
        	);
        }break;
    }
?>