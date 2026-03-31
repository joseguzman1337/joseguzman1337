<?php
    session_start();
    include_once('../../../../serviciosacademicos/utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
    
    require_once('../../../../serviciosacademicos/Connections/sala2.php');
    require('../../../../serviciosacademicos/funciones/funcionpassword.php');
    $rutaado = '../../../../serviciosacademicos/funciones/adodb/';
    require_once('../../../../serviciosacademicos/Connections/salaado.php');
    
    require ('../../../../serviciosacademicos/funciones/notas/redondeo.php');
    require ('redondeado.php');
    function comprobar($array,$buscar){
        $retornar = false;
        foreach($array as $k => $v){
            if($v==$buscar){
                $retornar = $k;
            }
        }
        return $retornar;
    }
    switch($_POST['action'])
    {
        case 'Periodo':
            $sqlperiodo=" SELECT p.codigoperiodo,p.nombreperiodo
                            FROM periodo p
                            WHERE p.codigoperiodo>'20102' ORDER BY p.codigoperiodo DESC";
            $datosperiodo = $db->GetAll($sqlperiodo);
            
            $selectperiodohtml="<option value=''>Seleccione</option>";
            foreach ($datosperiodo as $periodo) {
            $selectperiodohtml.="<option value='".$periodo['codigoperiodo']."'>".$periodo['nombreperiodo']."</option>";
            }
            
            echo $selectperiodohtml;
            break;
        case 'Carrera':
            $sqlcarrera="SELECT codigocarrera,nombrecarrera 
                        FROM carrera c 
                        WHERE now()  BETWEEN fechainiciocarrera AND fechavencimientocarrera
                        AND codigomodalidadacademica LIKE '2%'
                        ORDER BY nombrecarrera";
            $datoscarrera = $db->GetAll($sqlcarrera);
            
            $selectcarrerahtml="<option value=''>Seleccione</option>";
            foreach ($datoscarrera as $carrera) {
            $selectcarrerahtml.="<option value='".$carrera['codigocarrera']."'>".$carrera['nombrecarrera']."</option>";
            }
            
            echo $selectcarrerahtml;
            break;
        case 'Recursosf':
            $sqlrecursosf="SELECT terf.idtipoestudianterecursofinanciero,terf.nombretipoestudianterecursofinanciero 
                        FROM tipoestudianterecursofinanciero terf
                        ORDER BY nombretipoestudianterecursofinanciero";
            $datosrecursosf = $db->GetAll($sqlrecursosf);
            
            $selectrecursosfhtml="<option value=''>Seleccione</option>";
            foreach ($datosrecursosf as $recursosf) {
            $selectrecursosfhtml.="<option value='".$recursosf['idtipoestudianterecursofinanciero']."'>".$recursosf['nombretipoestudianterecursofinanciero']."</option>";
            }
            
            echo $selectrecursosfhtml;
            break;
        case 'Consultar':
        {  
            $ecodigocarrera="";
            if($_POST['prograacad']!=""){
                if($_POST['prograacad']=="1"){
                    $ecodigocarrera.="";
                }else{                    
                    $ecodigocarrera.="AND e.codigocarrera='".$_POST['prograacad']."' ";
                }
            }
            $enumerodocumento="";
            if($_POST['numerodocumento']!=""){
            $enumerodocumento.="AND eg.numerodocumento='".$_POST['numerodocumento']."' ";
            }
            $recursofinanciero="";
            if($_POST['recfin']!=""){
            $recursofinanciero.="AND erf.idtipoestudianterecursofinanciero='".$_POST['recfin']."' ";
            }
            
            
            $sqldatosestudiantes = "SELECT 
                                    ca.codigocarrera,
                                    ca.nombrecarrera,
                                    pr.semestreprematricula,
                                    doc.nombrecortodocumento,
                                    eg.numerodocumento,
                                    eg.apellidosestudiantegeneral,
                                    eg.nombresestudiantegeneral,
                                    eg.emailestudiantegeneral,
                                    eg.celularestudiantegeneral,
                                    terf.nombretipoestudianterecursofinanciero AS recursofinanciero,
                                    eg.idestudiantegeneral,
                                    dtpr.idgrupo,
                                    e.codigoestudiante,                                    
                                    pr.codigoperiodo,
                                    mt.codigocarrera as codigocarreramateria,
                                    car.nombrecarrera AS carreramateria,
                                    mt.codigomateria,
                                    mt.nombremateria,
                                    nth.notadefinitiva AS definitiva,
                                    pr.idprematricula,
                                    mt.notaminimaaprobatoria
                                    FROM 
                                    estudiantegeneral eg 
                                    INNER JOIN documento doc ON doc.tipodocumento=eg.tipodocumento
                                    INNER JOIN estudiante e ON e.idestudiantegeneral = eg.idestudiantegeneral
                                    INNER JOIN carrera ca ON ca.codigocarrera = e.codigocarrera
                                    INNER JOIN prematricula pr ON pr.codigoestudiante = e.codigoestudiante
                                    INNER JOIN detalleprematricula dtpr ON dtpr.idprematricula = pr.idprematricula
                                    INNER JOIN materia mt ON mt.codigomateria = dtpr.codigomateria
                                    INNER JOIN carrera car ON car.codigocarrera = mt.codigocarrera

                                    LEFT JOIN estudianterecursofinanciero erf ON erf.idestudiantegeneral=eg.idestudiantegeneral AND erf.codigoestado=100 
                                    LEFT JOIN tipoestudianterecursofinanciero terf ON erf.idtipoestudianterecursofinanciero = terf.idtipoestudianterecursofinanciero
                                    
                                    LEFT JOIN notahistorico nth ON nth.codigomateria=dtpr.codigomateria 
                                                                AND nth.codigoestudiante=e.codigoestudiante
                                                                AND nth.codigoperiodo=pr.codigoperiodo
                                                                AND nth.codigoestadonotahistorico=100

                                    WHERE 
                                    pr.codigoperiodo='".$_POST['periodo']."'
                                     AND dtpr.codigoestadodetalleprematricula=30
                                     ".$ecodigocarrera."
                                     ".$enumerodocumento."
                                     ".$recursofinanciero."
                                     AND ca.codigomodalidadacademica='200'
                                     GROUP BY eg.numerodocumento,mt.codigomateria
                                    ORDER BY ABS(eg.numerodocumento) ASC;";
            $datos = $db->GetAll($sqldatosestudiantes);

            $html= "";
            $z=1;
            foreach($datos as $datosestudiantes)
            {    
                $html.= "<tr>
                            <td>".$z."</td>
                            <td>".$datosestudiantes['codigocarrera']."</td>
                            <td>".$datosestudiantes['nombrecarrera']."</td>
                            <td>".$datosestudiantes['semestreprematricula']."</td>
                            <td>".$datosestudiantes['nombrecortodocumento']."</td>
                            <td>".$datosestudiantes['numerodocumento']."</td>
                            <td>".$datosestudiantes['apellidosestudiantegeneral']."</td>
                            <td>".$datosestudiantes['nombresestudiantegeneral']."</td>
                            <td>".$datosestudiantes['emailestudiantegeneral']."</td>
                            <td>".$datosestudiantes['celularestudiantegeneral']."</td>
                            <td>".$datosestudiantes['recursofinanciero']."</td>
                            <td>".$datosestudiantes['codigocarreramateria']."</td>
                            <td>".$datosestudiantes['carreramateria']."</td>
                            <td>".$datosestudiantes['codigomateria']."</td>
                            <td>".$datosestudiantes['nombremateria']."</td>"; 
                            //---------------------------------------------------------------------------
                            $cortesql="SELECT cor.numerocorte,dtn.nota
                                        FROM detallenota dtn
                                        INNER JOIN corte cor ON cor.idcorte = dtn.idcorte 
                                        WHERE 1
                                        AND dtn.idgrupo=".$datosestudiantes['idgrupo']."
                                        AND dtn.codigoestudiante=".$datosestudiantes['codigoestudiante']."
                                        AND cor.codigoperiodo=".$_POST['periodo']." 
                                        AND dtn.codigoestado=100 ";
                            $acortesql = $db->Execute($cortesql);
                            $cornot="";
                            while($corte = $acortesql->FetchRow()){
                            $cornot.=$corte['numerocorte']."--".$corte['nota'].",";                                
                            }
                            $concornot=substr($cornot, 0, -1);
                            $tconcornot = explode(",", $concornot);
                            $n= array(1,2,3);
                            for($j=0;$j<=2;$j++){
                                list($cor[$j],$not[$j]) = explode("--", $tconcornot[$j]);

                                $pos = comprobar($cor , $n[$j]);
                                if($pos === false){
                                    $html.= "<td></td>";
                                }else{
                                    $html.= "<td>".$not[$pos]."</td>";
                                }                               
                            }
                    //---------------------------------------------------------------------------  
                    $html.= "<td>".$datosestudiantes['definitiva']."</td>";
                            $misql="SELECT count(DISTINCT detpr.codigomateria) AS materiasinscritas FROM detalleprematricula detpr 
                                            WHERE detpr.idprematricula=".$datosestudiantes['idprematricula']." 
                                            AND detpr.codigoestadodetalleprematricula=30";
                            $amisql = $db->Execute($misql);
                            $materiasinscritas = $amisql->FetchRow();                    
                    $html.= "<td>".$materiasinscritas['materiasinscritas']."</td>"; 
                    
                            $mcsql="SELECT count(DISTINCT detpr.codigomateria) AS materiascanceladas FROM detalleprematricula detpr
                            WHERE detpr.idprematricula=".$datosestudiantes['idprematricula']."
                            AND detpr.codigoestadodetalleprematricula IN(20,21,22,23,24)
                            AND detpr.codigomateria NOT IN(SELECT codigomateria FROM detalleprematricula
                            WHERE idprematricula=".$datosestudiantes['idprematricula']."
                            AND codigoestadodetalleprematricula=30) ";
                            $amcsql = $db->Execute($mcsql);
                            $materiascanceladas = $amcsql->FetchRow();           
                    $html.= "<td>".$materiascanceladas['materiascanceladas']."</td>";                    
                    
                            $mpsql="SELECT count(nth.notadefinitiva) AS materiasperdidas
                                        FROM notahistorico nth
                                        WHERE 1
                                        AND nth.notadefinitiva<".$datosestudiantes['notaminimaaprobatoria']."
                                        AND nth.codigoestudiante=".$datosestudiantes['codigoestudiante']."
                                        AND nth.codigoperiodo=".$_POST['periodo']."
                                        AND nth.codigoestadonotahistorico=100 ";
                            $ampsql = $db->Execute($mpsql);
                            $materiasperdidas = $ampsql->FetchRow(); 
                    $html.= "<td>".$materiasperdidas['materiasperdidas']."</td>";
                    
                            $promedioacumulado = AcumuladoReglamento1($datosestudiantes['codigoestudiante'],"todo",$sala,$datosestudiantes['codigoperiodo']);
                            if($promedioacumulado > 5) {
                                $promedioacumulado =  number_format(($promedioacumulado / 100),1);
                            }
                    $html.= "<td>".$promedioacumulado."</td>";
                    
                            $promediosemestralperiodo = PeriodoSemestralTodo($datosestudiantes['codigoestudiante'],$datosestudiantes['codigoperiodo'],"todo",$sala,1);
                            if ($promediosemestralperiodo > 5) {
                                $promediosemestralperiodo = number_format(($promediosemestralperiodo / 100),1);
                            }
                    $html.= "<td>".$promediosemestralperiodo."</td>";
                    $html.= "<td>".$datosestudiantes['codigoperiodo']."</td>";
                $html.="</tr>";
                $z++;
            }  
            echo $html;        
        }break;         
    }
?>