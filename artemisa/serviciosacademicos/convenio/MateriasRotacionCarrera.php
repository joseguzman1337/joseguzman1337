<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once (realpath(dirname(__FILE__)).'/../EspacioFisico/templates/template.php');
    $rutaVistas = "./vistasRotaciones"; /*carpeta donde se guardaran las vistas (html) de la aplicación */
    require_once(realpath(dirname(__FILE__))."/../../Mustache/load.php"); /*Ruta a /html/Mustache */
	include(realpath(dirname(__FILE__))."/../utilidades/helpers/funcionesLoop.php");

    $db = getBD();

    $sql = "SELECT nombrecarrera,codigocarrera FROM carrera WHERE codigocarrera=".$_SESSION["codigofacultad"]; 
    $carrera=$db->GetRow($sql);
		
    $db->Execute("SET @conteo1=0");		
			
    $query ="select @conteo1 :=@conteo1 + 1 AS conteo, m.codigomateria, m.nombrecortomateria, ".
    " m.nombremateria, tm.nombretipomateria, m.codigoperiodo, m.codigocarrera, t.NombreTipoRotacion, ".
    "IF ( h.idhorario IS NULL, 'No tiene', 'Tiene' ) AS estadohorario ".
    " FROM materia m ".
    " INNER JOIN TipoRotaciones t ON t.TipoRotacionId=m.TipoRotacionId ".
    " INNER JOIN grupo g on  g.codigomateria = m.codigomateria ".
    " INNER JOIN tipomateria tm ON m.codigotipomateria = tm.codigotipomateria ".
    " LEFT JOIN horario h ON h.idgrupo = g.idgrupo ".
    " WHERE m.codigocarrera = '".$_SESSION["codigofacultad"]."' AND m.codigomateria<>1 ".
    " and m.codigoestadomateria = '01' ".
    " and g.codigoperiodo = '".$_SESSION['codigoperiodosesion']."' and g.codigoestadogrupo = '10' ".
    " and m.TipoRotacionId<>1  GROUP BY m.codigomateria order by m.nombremateria";
    $listamaterias=$db->GetAll($query);
    $c=0;
    foreach($listamaterias as $materia){
        $sqlmatriculados = "SELECT count(*) as  matriculadosgrupo,g.idgrupo, g.nombregrupo ".
        " FROM prematricula p ".
        " INNER JOIN detalleprematricula d on (p.idprematricula = d.idprematricula AND ".
        " d.codigomateria = '".$materia['codigomateria']."'  and d.codigoestadodetalleprematricula = 30) ".
        " INNER JOIN ordenpago o on (d.numeroordenpago = o.numeroordenpago AND o.codigoestadoordenpago  in (40,10)) ".
        " INNER JOIN grupo g on (d.idgrupo = g.idgrupo AND  g.codigoestadogrupo = '10') ".
        " WHERE p.codigoestadoprematricula IN (40, 41) AND p.codigoperiodo = '".$_SESSION['codigoperiodosesion']."' ";
        $matriculados = $db->GetRow($sqlmatriculados);
         
        $sql="SELECT g.idgrupo, g.nombregrupo FROM grupo g WHERE ".
        " g.codigomateria = '".$materia['codigomateria']."' ".
        " AND g.codigoperiodo = '".$_SESSION['codigoperiodosesion']."' ".
        " AND g.codigoestadogrupo = 10 AND  g.matriculadosgrupo>=1 GROUP BY idgrupo";
        $Gruposname = $db->GetAll($sql);

        $sqlnomatriculados = "SELECT SUM(d.idprematricula ) as  nomatriculados from grupo g ".
        " INNER JOIN detalleprematricula d ON d.idgrupo = g.idgrupo and d.codigomateria = g.codigomateria".
        " and d.codigoestadodetalleprematricula ='10' where g.codigoperiodo = '".$_SESSION['codigoperiodosesion']."' ".
        " and g.codigomateria = '".$materia['codigomateria']."'";
         $nomatriculados = $db->GetRow($sqlnomatriculados);

        $datosmaterias[$c]['conteo'] = $materia['conteo'];
        $datosmaterias[$c]['codigomateria'] = $materia['codigomateria'];
        $datosmaterias[$c]['nombrecortomateria'] = $materia['nombrecortomateria'];
        $datosmaterias[$c]['nombremateria'] = $materia['nombremateria'];
        $datosmaterias[$c]['nombretipomateria'] = $materia['nombretipomateria'];
        $datosmaterias[$c]['codigoperiodo'] = $materia['codigoperiodo'];
        $datosmaterias[$c]['codigocarrera'] = $materia['codigocarrera'];
        $datosmaterias[$c]['NombreTipoRotacion'] = $materia['NombreTipoRotacion'];
        $datosmaterias[$c]['estadohorario'] = $materia['estadohorario'];
        $datosmaterias[$c]['idgrupo'] = $Gruposname;
        $datosmaterias[$c]['Idgrupo'] = $matriculados['idgrupo'];
        $datosmaterias[$c]['nombregrupo'] = $matriculados['nombregrupo'];
        $datosmaterias[$c]['matriculadosgrupo'] = $matriculados['matriculadosgrupo'];

        if(!$nomatriculados['nomatriculados']){
            $no = '0';
        }else{
            $no = $nomatriculados['nomatriculados'];
        }
        $datosmaterias[$c]['nomatriculados'] = $no;
        $c++;
    }//foreach

    $template = $mustache->loadTemplate('listaMaterias');

    echo $template->render(array('title' => 'Materias del Programa',
							'carrera' =>$carrera["nombrecarrera"],
							'materias' =>$datosmaterias,
							'class_even' => $helper_contadorParImpar,
							'rotacion' => true
							)
						);
?>  