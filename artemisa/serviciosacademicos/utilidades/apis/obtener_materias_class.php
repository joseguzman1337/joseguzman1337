<?PHP 
class obtener_materias{
    var $db;
    var $usuario;
    var $rol;
    var $PeriodoActivo;
    var $PeriodoPrecierre=false;
    var $periodoactual;
    function __construct($db,$usuario,$rol=0){ 
		$this->db      = $db;
        $this->usuario = $usuario;
        $this->rol     = $rol;
        $this->periodo();
	}//__construct
    function buscarmaterias(){        
        //$json["rol"]   =$this->rol;  
        if($this->rol==1){
           $materias =  $this->materiasestudiante();
        }else if($this->rol==2){
           $materias =  $this->materiasdocente();
        }
        
        $json["result"]   ="OK";    
        $json["codigoresultado"] =0;
        $json["materias"] = $materias;
        
        return $json;
    }//function buscarmaterias
    function materiasdocente(){ 
          $SQL='SELECT
                    m.codigomateria,
                    m.nombremateria
                FROM
                    usuario u
                INNER JOIN docente d ON d.numerodocumento = u.numerodocumento
                AND u.codigorol = ?
                AND u.idusuario = ?
                INNER JOIN grupo g ON g.numerodocumento = d.numerodocumento
                AND g.codigoperiodo = ?
                INNER JOIN materia m ON m.codigomateria = g.codigomateria';
        
        $variable[] = "$this->rol";
        $variable[] = "$this->usuario";
        if($this->PeriodoPrecierre){
            $variable[] = "$this->PeriodoPrecierre";
        }else{
            $variable[] = "$this->PeriodoActivo";
        }
        $Datos = $this->db->GetAll($SQL,$variable);
        if($Datos===false){
            $json["result"]   ="ERROR";
            $json["codigoresultado"] =1;
            $json["mensaje"]         ="Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }
        
      return $Datos;
    }//function materiasdocente
    function materiasestudiante(){
      $SQL='SELECT
                m.codigomateria,
                m.nombremateria
            FROM
                usuario u
            INNER JOIN estudiantegeneral e ON e.numerodocumento = u.numerodocumento
            AND u.idusuario = ?
            AND u.codigorol = ?
            INNER JOIN estudiante ee ON ee.idestudiantegeneral = e.idestudiantegeneral
            INNER JOIN prematricula p ON p.codigoestudiante = ee.codigoestudiante
            AND p.codigoperiodo = ?
            AND p.codigoestadoprematricula LIKE "4%"
            INNER JOIN detalleprematricula dp ON dp.idprematricula = p.idprematricula
            AND dp.codigoestadodetalleprematricula = 30
            INNER JOIN grupo g ON g.idgrupo = dp.idgrupo
            INNER JOIN materia m ON m.codigomateria = g.codigomateria
            INNER JOIN carrera c ON c.codigocarrera = m.codigocarrera
            AND c.codigomodalidadacademica IN (200, 300)';
        
        
        $variable[] = "$this->usuario";
        $variable[] = "$this->rol";
        if($this->PeriodoPrecierre){
            $variable[] = "$this->PeriodoPrecierre";
        }else{
            $variable[] = "$this->PeriodoActivo";
        }
        
        $Datos = $this->db->GetAll($SQL,$variable);
        
        if($Datos===false){
            $json["result"]   ="ERROR";
            $json["codigoresultado"] =1;
            $json["mensaje"]         ="Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }
      return $Datos;
    }//function materiasestudiante
    function periodo(){
        $SQL='SELECT 

              codigoperiodo ,
              codigoestadoperiodo

              FROM periodo

              WHERE

              codigoestadoperiodo IN(?,?)';//1 activo 3 precierre
        
        $variable[] = "1";
        $variable[] = "3";
        //$this->db->debug = true;
        $Periodo = $this->db->Execute($SQL,$variable);
        
        if($Periodo===false){
            $json["result"]   ="ERROR";
            $json["codigoresultado"] =1;
            $json["mensaje"]         ="Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }
        
        $this->PeriodoActivo = 0;
            
        while(!$Periodo->EOF){
            
            if($Periodo->fields['codigoestadoperiodo']==1){    
                $this->PeriodoActivo   = $Periodo->fields['codigoperiodo'];
                $this->periodoactual   = $Periodo->fields['codigoperiodo'];
            }else{
                $this->PeriodoPrecierre = $Periodo->fields['codigoperiodo'];
                $this->periodoactual    = $Periodo->fields['codigoperiodo'];
            }
            
            $Periodo->MoveNext();
        }
    }//function periodo
    function ObtenerGruposApp(){
        include_once(realpath(dirname(__FILE__)).'/../funcionesTexto.php'); 
        
        $Datosusuario = $this->DataUsusario();
        
        $numerodocumento = $Datosusuario['numerodocumento'];
    
        $Datos = $this->ConsultamateriaGrupo($numerodocumento);
        
        $num = count($Datos);
        
        for($i=0;$i<$num;$i++){
            $ResultadoMaterias[$i]['idmateria']               = $Datos[$i]['codigomateria'];
            $ResultadoMaterias[$i]['nombremateria']           = sanear_string($Datos[$i]['nombremateria'],true);
            $ResultadoMaterias[$i]['codigomodalidadmateria']  = $Datos[$i]['codigomodalidadmateria'];
            $ResultadoMaterias[$i]['nombremodalidadmateria']  = sanear_string($Datos[$i]['nombremodalidadmateria'],true);
            
            $DatosGrupo = $this->ConsultamateriaGrupo($numerodocumento,$Datos[$i]['codigomateria']);
            
            $numG = count($DatosGrupo);
            for($j=0;$j<$numG;$j++){
                $ResultadoMaterias[$i]['grupos'][$j]['idgrupo']                  = $DatosGrupo[$j]['idgrupo'];
                $ResultadoMaterias[$i]['grupos'][$j]['nombregrupo']              = sanear_string($DatosGrupo[$j]['nombregrupo'],true);      
            }//for
            
        }//for
        
        return $ResultadoMaterias;
        
    }//function ObtenerGruposApp
    function ConsultamateriaGrupo($numerodocumento,$codigomateria=false){
        if($codigomateria){
            $Campos     = ' g.idgrupo, g.nombregrupo ';
            $condicion  = ' AND m.codigomateria = ?';
            if($this->PeriodoPrecierre){
                $variable[] = "$this->PeriodoPrecierre";
            }else{
                $variable[] = "$this->PeriodoActivo";
            }
            $variable[] = "$numerodocumento";
            $variable[] = "$codigomateria";
            $agrupar    = 'GROUP BY g.idgrupo' ;
        }else{
            $Campos = ' m.codigomateria, m.nombremateria, mm.codigomodalidadmateria, mm.nombremodalidadmateria ';
            if($this->PeriodoPrecierre){
                $variable[] = "$this->PeriodoPrecierre";
            }else{
                $variable[] = "$this->PeriodoActivo";
            }
            $variable[] = "$numerodocumento";
            $condicion  = '';
            $agrupar    = 'GROUP BY g.codigomateria';
        }
        $SQL='SELECT
                '.$Campos.'
              FROM
                docente d
                INNER JOIN grupo g ON g.numerodocumento = d.numerodocumento
                INNER JOIN materia m ON m.codigomateria = g.codigomateria
                INNER JOIN modalidadmateria mm ON mm.codigomodalidadmateria = m.codigomodalidadmateria
              WHERE
                g.codigoperiodo = ?
                AND g.codigoestadogrupo = 10
                AND g.numerodocumento = ?'.$condicion.' '.$agrupar;
        
        
        //$this->db->debug = true;
        $Datos = $this->db->GetAll($SQL,$variable);
        
        if($Datos===false){
            $json["result"]   ="ERROR";
            $json["codigoresultado"] =1;
            $json["mensaje"]         ="Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }
        
        return $Datos;    
    }//function ConsultamateriaGrupo
    
/*    function write_log($cadena,$tipo)
	{	
		$arch = fopen(realpath( '.' )."/logs/milog_".date("Y-m-d").".txt", "a+"); 
	
		fwrite($arch, "[".date("Y-m-d H:i:s.u")." ".$_SERVER['REMOTE_ADDR']." ".
	                   $_SERVER['HTTP_X_FORWARDED_FOR']." - $tipo ] ".$cadena."\n");
		fclose($arch);
	}
    
  */  
    
    function DataUsusario(){
        $SQL='SELECT * FROM usuario WHERE idusuario=?';
        
        $variable[]  = "$this->usuario";
        //$this->db->debug = true;
        $Datos = $this->db->GetRow($SQL,$variable);
    //    $this->write_log($this->usuario, "text");
        if($Datos===false){
            $json["result"]   ="ERROR";
            $json["codigoresultado"] =1;
            $json["mensaje"]         ="Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }
        
        return $Datos; 
    }//function DataUsusario
    function ConsultaEstudianteGrupo($idgrupo,$consulta=false){
        
        if($consulta){
            $Campos      = 'e.codigoestudiante,
                            e.codigocarrera,
                            c.nombrecarrera,
                            CONCAT(ee.nombresestudiantegeneral," ",	ee.apellidosestudiantegeneral) AS nameestudiante,
                            ee.tipodocumento,
                            d.nombrecortodocumento,
                            ee.numerodocumento,
                            u.usuario';
            
            $tablasInner = 'INNER JOIN detalleprematricula dp ON dp.idgrupo = g.idgrupo
                            INNER JOIN prematricula p ON p.idprematricula = dp.idprematricula
                            INNER JOIN estudiante e ON e.codigoestudiante = p.codigoestudiante
                            INNER JOIN estudiantegeneral ee ON ee.idestudiantegeneral = e.idestudiantegeneral
                            INNER JOIN documento d ON d.tipodocumento=ee.tipodocumento
                            INNER JOIN carrera c ON c.codigocarrera = e.codigocarrera
                            INNER JOIN usuario u ON u.numerodocumento = ee.numerodocumento';
            $Condicion   = 'AND dp.codigoestadodetalleprematricula = 30
                           AND p.codigoestadoprematricula LIKE "4%"';
            $GrupoOrden  = ' GROUP BY e.codigoestudiante   ORDER BY c.codigocarrera';
        }else{
              $Campos      = 'm.codigomateria, m.nombremateria, g.idgrupo, g.nombregrupo,mm.codigomodalidadmateria,mm.nombremodalidadmateria';
            $tablasInner = '';
            $Condicion   = '';
            $GrupoOrden  = 'GROUP BY g.idgrupo';

        }
          $SQL='SELECT
                   '.$Campos.'                    
                FROM
                   grupo g 
                INNER JOIN materia m ON m.codigomateria = g.codigomateria
                INNER JOIN modalidadmateria mm ON mm.codigomodalidadmateria = m.codigomodalidadmateria
                '.$tablasInner.'
                WHERE
                    g.codigoperiodo = ?
                AND g.codigoestadogrupo = 10
                '.$Condicion.'
                AND g.idgrupo =?
                '.$GrupoOrden;
        
        if($this->PeriodoPrecierre){
            $variable[] = "$this->PeriodoPrecierre";
        }else{
            $variable[] = "$this->PeriodoActivo";
        }
        $variable[] = "$idgrupo";
        
       // $this->db->debug = true;
        
        $Datos = $this->db->GetAll($SQL,$variable);
        
        if($Datos===false){
            $json["result"]   ="ERROR";
            $json["codigoresultado"] =1;
            $json["mensaje"]         ="Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }
        
        return $Datos;
    }//function ConsultaEstudianteGrupo
    function ObtenerEstudianteGrupo($idgrupo){
        include_once(realpath(dirname(__FILE__)).'/../funcionesTexto.php'); 
       //$this->write_log($idgrupo, "idgrupo");
 
        $Datos = $this->ConsultaEstudianteGrupo($idgrupo);
        
        $num = count($Datos);
        
        for($i=0;$i<$num;$i++){
            $R_EstudianteGrupo[$i]['codigomateria'] = $Datos[$i]['codigomateria'];
            $R_EstudianteGrupo[$i]['nombremateria'] = sanear_string($Datos[$i]['nombremateria'],true);
            $R_EstudianteGrupo[$i]['idgrupo']       = $Datos[$i]['idgrupo'];
            $R_EstudianteGrupo[$i]['nombregrupo']   = sanear_string($Datos[$i]['nombregrupo'],true);
            $R_EstudianteGrupo[$i]['codigotipomateria']   = $Datos[$i]['codigomodalidadmateria'];
            $R_EstudianteGrupo[$i]['nombretipomateria']   = sanear_string($Datos[$i]['nombremodalidadmateria'],true);
            
            $DatosEstudiante = $this->ConsultaEstudianteGrupo($idgrupo,true);
            
            $numE = count($DatosEstudiante);
            
            $R_EstudianteGrupo[$i]['numTotalEstudiantes']   = $numE;
            
            for($j=0;$j<$numE;$j++){
                $R_EstudianteGrupo[$i]['Estudiantes'][$j]['codigoestudiante']           = $DatosEstudiante[$j]['codigoestudiante'];
                $R_EstudianteGrupo[$i]['Estudiantes'][$j]['codigocarrera']              = $DatosEstudiante[$j]['codigocarrera'];
                $R_EstudianteGrupo[$i]['Estudiantes'][$j]['programa']                   = sanear_string($DatosEstudiante[$j]['nombrecarrera'],true);
                $R_EstudianteGrupo[$i]['Estudiantes'][$j]['nombreestudiante']           = sanear_string($DatosEstudiante[$j]['nameestudiante'],true);
                $R_EstudianteGrupo[$i]['Estudiantes'][$j]['tipodocumento']              = $DatosEstudiante[$j]['nombrecortodocumento'];
                $R_EstudianteGrupo[$i]['Estudiantes'][$j]['numerodocumento']            = $DatosEstudiante[$j]['numerodocumento'];
                $R_EstudianteGrupo[$i]['Estudiantes'][$j]['usuario']                    = $DatosEstudiante[$j]['usuario'].'@unbosuqe.edu.co';
              
            }//for
        }//for
        
        return $R_EstudianteGrupo;
    }//function ObtenerEstudianteGrupo
    function ValidaAccesoHorrioGrupo($idgrupo){
        $dias = array('','1','2','3','4','5','6','7');    
        
        $diaValor  = $dias[date('N', strtotime(date('Y-m-d')))];
        $timehours = date('H:i');
        
        $SQL='SELECT
                h.idgrupo,
                h.codigodia,
                h.horainicial,
                h.horafinal
             FROM
                horario h
             WHERE
                h.idgrupo = ?
                AND h.codigoestado = 100
                AND ? BETWEEN DATE_FORMAT(h.horainicial,"%H:%i") AND DATE_FORMAT(h.horafinal,"%H:%i") 
                AND h.codigodia=?
            
            UNION
            
              SELECT
                    sg.idgrupo,
                    s.codigodia,
                    a.HoraInicio AS horainicial,
                    a.HoraFin AS horafina
              FROM
                    AsignacionEspacios a
                INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = a.SolicitudAsignacionEspacioId
                INNER JOIN AsociacionSolicitud aa ON aa.SolicitudAsignacionEspaciosId = s.SolicitudAsignacionEspacioId
                INNER JOIN SolicitudPadre sp ON sp.SolicitudPadreId = aa.SolicitudPadreId
                LEFT JOIN SolicitudEspacioGrupos sg ON sg.SolicitudAsignacionEspacioId = a.SolicitudAsignacionEspacioId
              WHERE
                    sp.CodigoEstado = 100
                AND s.codigoestado = 100
                AND a.codigoestado = 100
                AND sg.codigoestado = 100
                AND sg.idgrupo = ?
                AND ?  BETWEEN DATE_FORMAT(a.HoraInicio,"%H:%i") AND DATE_FORMAT(a.HoraFin,"%H:%i") 
                AND s.codigodia=?

              GROUP BY
                    sg.idgrupo';
        
        $variable[] = "$idgrupo";
        $variable[] = "$timehours";
        $variable[] = "$diaValor";
        $variable[] = "$idgrupo";
        $variable[] = "$timehours";
        $variable[] = "$diaValor";
        
        //$this->db->debug=true;
        
        $Datos = $this->db->Execute($SQL,$variable);
        
        if($Datos===false){
            $json["result"]   ="ERROR";
            $json["codigoresultado"] =1;
            $json["mensaje"]         ="Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }
        
        if(!$Datos->EOF){
            return 1;//true;
        }else{
            return 0;//false;
        }
        
    }//function ValidaAccesoHorrioGrupo
    function ObtenerCorte($idgrupo){
        $SQL='SELECT
                c.idcorte,
                c.numerocorte,
                c.porcentajecorte,
                c.fechainicialcorte,
                c.fechafinalcorte,
                if(c.fechainicialcorte <= CURDATE() && c.fechafinalcorte >= CURDATE(),"Activo","Inactivo") AS EstadoCorte,
                if(c.fechainicialcorte <= CURDATE() && c.fechafinalcorte >= CURDATE(),"1","0") AS CodigoEstadoCorte
              FROM
                corte c INNER JOIN materia m ON  (m.codigomateria=c.codigomateria OR m.codigocarrera=c.codigocarrera)
                INNER JOIN grupo g ON g.codigomateria=m.codigomateria AND g.idgrupo=?  AND g.codigoestadogrupo=10 AND g.codigoperiodo=c.codigoperiodo
              WHERE
                c.codigoperiodo=?';
        
        $variable[] = "$idgrupo";
        if($this->PeriodoPrecierre){
            $variable[] = "$this->PeriodoPrecierre";
        }else{
            $variable[] = "$this->PeriodoActivo";
        }
        
        // $this->db->debug = true;
        
        $Datos = $this->db->GetAll($SQL,$variable);
        
        if($Datos===false){
            $json["result"]   ="ERROR";
            $json["codigoresultado"] =1;
            $json["mensaje"]         ="Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }
        
        return $Datos;
    }//function ObtenerCorte
    function ObtenerNotasCorte($idgrupo,$idcorte){  
        
       $DatosPrincipales = $this->ObtenerDatosMateriaGrupo($idgrupo,$idcorte);
        
     
        $Resultado['nombremateria']    = $DatosPrincipales['nombremateria'];
        $Resultado['codigomateria']    = $DatosPrincipales['codigomateria'];
        $Resultado['idgrupo']          = $DatosPrincipales['idgrupo'];
        $Resultado['nombregrupo']      = $DatosPrincipales['nombregrupo'];
        $Resultado['TotalEstudiantes'] = $DatosPrincipales['TotalEstudiantes'];
        $Resultado['actAcdemica'] = $DatosPrincipales['actAcdemica'];
        $Resultado['ActPracticas'] = $DatosPrincipales['ActPracticas'];
        
        include_once(realpath(dirname(__FILE__)).'/../../funciones/sala/nota/nota.php');
               
        $Datos = $this->ListaEstudiantesXNota($idgrupo,$idcorte);
        
        $periodoactual = $this->periodoactual;
        
        $num = count($Datos);
        
          $Resultado['numTotalEstudiantes'] = $num;
        
        for($i=0;$i<$num;$i++){
            $C_detallenota = new detallenota($Datos[$i]['codigoestudiante'], $periodoactual); 
            
            $Resultado['Estudiantes'][$i]['codigoestudiante']      = $Datos[$i]['codigoestudiante'];
            $Resultado['Estudiantes'][$i]['nameEstudiante']        = $Datos[$i]['nameEstudiante'];
            $Resultado['Estudiantes'][$i]['nota']                  = $Datos[$i]['nota'];
            $Resultado['Estudiantes'][$i]['FAP']                   = $Datos[$i]['FAP'];
            $Resultado['Estudiantes'][$i]['FAT']                   = $Datos[$i]['FAT'];
            
            $TipoRiesgo = $C_detallenota->riesgoEstudianteXMateria($DatosPrincipales['codigomateria'], $idgrupo,true);
            $nameRiesgo = 'Sin Riesgo';
            $codigoRiesgo = 0;
            switch($TipoRiesgo){
                case '1':{$codigoRiesgo=1;$nameRiesgo='Alto';}break;//alto
                case '2':{$codigoRiesgo=2;$nameRiesgo='Medio';}break;//medio
                case '3':{$codigoRiesgo=3;$nameRiesgo='Bajo';}break;//bajo
            }//switch
            $Resultado['Estudiantes'][$i]['codigoriesgo']          = $codigoRiesgo;
            $Resultado['Estudiantes'][$i]['nombreriesgo']          = $nameRiesgo; 
            
        }//for
        //echo '<pre>';print_r($Resultado);
        return $Resultado;
    }//function ObtenerNotasCorte
    function ObtenerDatosMateriaGrupo($idgrupo,$idcorte=false){
        if($idcorte){
            $Campos  = ' , IF(n.actividadesacademicaspracticanota IS NULL,"0",n.actividadesacademicaspracticanota)  ActPracticas ,     IF(n.actividadesacademicasteoricanota IS NULL ,"0",n.actividadesacademicasteoricanota)  AS actAcdemica';
            $tabla = ' LEFT JOIN nota n ON n.idgrupo=g.idgrupo AND n.idcorte=?';
            
        }else{
            $Campos = '';
            $tabla= '';
        }
         $SQL='SELECT
                    m.nombremateria,
                    m.codigomateria,
                    g.idgrupo,
                    g.nombregrupo,
                    COUNT(dp.idgrupo) AS TotalEstudiantes
                    '.$Campos.'
             FROM
                    grupo g
                INNER JOIN detalleprematricula dp ON dp.idgrupo = g.idgrupo
                INNER JOIN prematricula p ON p.idprematricula = dp.idprematricula
                INNER JOIN materia m ON m.codigomateria = g.codigomateria
                '.$tabla.'
             
             WHERE
                    g.idgrupo = ?
                AND g.codigoestadogrupo = 10
                AND p.codigoestadoprematricula IN (40, 41)
                AND dp.codigoestadodetalleprematricula = 30';
        
        if($idcorte){
            $variable[] = "$idcorte";    
        }        
        
        $variable[] = "$idgrupo";
        
        //$this->db->debug = true;
        
        $DatosPrincipales = $this->db->GetRow($SQL,$variable);
        
        if($Datos===false){
            $json["result"]   ="ERROR";
            $json["codigoresultado"] =1;
            $json["mensaje"]         ="Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }        
        
        return $DatosPrincipales;
    }//function ObtenerDatosMateriaGrupo
    function ObtenerTotalNotas($idgrupo){
        
        $DatosPrincipales = $this->ObtenerDatosMateriaGrupo($idgrupo);
        
        $SQL='SELECT
                *,
                SUM(x.valor_nota) AS total_nota
             FROM
                (
                SELECT
                    e.codigoestudiante,
                    CONCAT(ee.nombresestudiantegeneral," ",	ee.apellidosestudiantegeneral) AS nameEstudiante,
                    n.nota,
                    n.numerofallaspractica AS FAP,
                    n.numerofallasteoria AS FAT,
                    ee.numerodocumento,
                    n.idcorte,
                    c.porcentajecorte,
                  (c.porcentajecorte/100) AS valor_porcentaje,
                  (n.nota*(c.porcentajecorte/100)) AS valor_nota

                FROM
                    detallenota n
                INNER JOIN estudiante e ON e.codigoestudiante = n.codigoestudiante
                INNER JOIN estudiantegeneral ee ON ee.idestudiantegeneral = e.idestudiantegeneral
                INNER JOIN corte c ON c.idcorte = n.idcorte
                WHERE
                    n.codigoestado = 100
                AND n.idgrupo = ?
                ORDER BY
                    e.codigoestudiante) x

             GROUP BY x.codigoestudiante';
        
        $variable[] = "$idgrupo";
        
         // $this->db->debug = true;
        
        $Datos = $this->db->GetAll($SQL,$variable);
        
        if($Datos===false){
            $json["result"]   ="ERROR";
            $json["codigoresultado"] =1;
            $json["mensaje"]         ="Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }     
        
        $Resultado['nombremateria']    = $DatosPrincipales['nombremateria'];
        $Resultado['codigomateria']    = $DatosPrincipales['codigomateria'];
        $Resultado['idgrupo']          = $DatosPrincipales['idgrupo'];
        $Resultado['nombregrupo']      = $DatosPrincipales['nombregrupo'];
        $Resultado['TotalEstudiantes'] = $DatosPrincipales['TotalEstudiantes'];
        
        $num = count($Datos);        
        
        include_once(realpath(dirname(__FILE__)).'/../../funciones/sala/nota/nota.php');
        
        $periodoactual = $this->periodoactual;
        
        for($i=0;$i<$num;$i++){
            $C_detallenota = new detallenota($Datos[$i]['codigoestudiante'], $periodoactual); 
            
            $Resultado['Estudiantes'][$i]['codigoestudiante']      = $Datos[$i]['codigoestudiante'];
            $Resultado['Estudiantes'][$i]['nameEstudiante']        = $Datos[$i]['nameEstudiante'];
            $Resultado['Estudiantes'][$i]['Total_nota']            = number_format($Datos[$i]['total_nota'],1,'.','.'); 
            $TipoRiesgo = $C_detallenota->riesgoEstudianteXMateria($DatosPrincipales['codigomateria'], $idgrupo,true);
            $nameRiesgo = 'Sin Riesgo';
            $codigoRiesgo = 0;
            switch($TipoRiesgo){
                case '1':{$codigoRiesgo=1;$nameRiesgo='Alto';}break;//alto
                case '2':{$codigoRiesgo=2;$nameRiesgo='Medio';}break;//medio
                case '3':{$codigoRiesgo=3;$nameRiesgo='Bajo';}break;//bajo
            }//switch
            $Resultado['Estudiantes'][$i]['codigoriesgo']          = $codigoRiesgo;
            $Resultado['Estudiantes'][$i]['nombreriesgo']          = $nameRiesgo; 
           
            
        }//for
        
        return $Resultado;
    }//function ObtenerTotalNotas
    function ListaEstudiantesXNota($idgrupo,$idcorte,$codigoestudiante=false){
        
        $SQL_Fechas='SELECT
                            c.numerocorte,
                            c.codigocarrera,
                            c.codigomateria,
                            c.fechainicialcorte,
                            c.fechafinalcorte,
                            DATE(p.fechainicioperiodo) AS fechainicioperiodo
                     FROM
                            periodo p
                        INNER JOIN corte c ON p.fechainicioperiodo <= c.fechainicialcorte
                        AND p.fechavencimientoperiodo >= c.fechafinalcorte
                     WHERE
                            p.codigoperiodo = ?
                        AND c.idcorte = ?';
        
        $validacionFecha[] = "$this->periodoactual";
        $validacionFecha[] = "$idcorte";
        
        //$this->db->debug = true;
        
        $Datos = $this->db->GetRow($SQL_Fechas,$validacionFecha);
        
        if($Datos===false){
            $json["result"]   ="ERROR";
            $json["codigoresultado"] =1;
            $json["mensaje"]         ="Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }   
        
        if($Datos['numerocorte']>1){
            
            $CorteNum = $Datos['numerocorte']-1;
            $codigocarrera = $Datos['codigocarrera'];
            $codigomateria = $Datos['codigomateria'];
            
            $SQL_Sub='SELECT
                            c.numerocorte,
                            c.codigocarrera,
                            c.codigomateria,
                            c.fechainicialcorte,
                            c.fechafinalcorte,
                            DATE(p.fechainicioperiodo) AS fechainicioperiodo,
                            c.idcorte
                      FROM
                            periodo p
                        INNER JOIN corte c ON p.fechainicioperiodo <= c.fechainicialcorte
                        AND p.fechavencimientoperiodo >= c.fechafinalcorte
                      WHERE
                            p.codigoperiodo = ?
                            AND numerocorte=?
                            AND codigocarrera=?
                            AND codigomateria=?';
            
            $VariablesSub[] = "$this->periodoactual";
            $VariablesSub[] = "$CorteNum";
            $VariablesSub[] = "$codigocarrera";
            $VariablesSub[] = "$codigomateria";
            
              //$this->db->debug = true;
        
            $DatosSub = $this->db->GetRow($SQL_Sub,$VariablesSub);

            if($DatosSub===false){
                $json["result"]   ="ERROR";
                $json["codigoresultado"] =1;
                $json["mensaje"]         ="Error de Conexión del Sistema SALA";
                echo json_encode($json);
                exit;
            } 
            
            $fecha_1 = $DatosSub['fechafinalcorte'];
            $fecha_2 = $Datos['fechafinalcorte'];
        }else{
            $fecha_1 = $Datos['fechainicioperiodo'];
            $fecha_2 = $Datos['fechafinalcorte'];
        }
        
         $Condicion = '';
        if($codigoestudiante){
            $Condicion = '    WHERE    xx.codigoestudiante="'.$codigoestudiante.'"   ';
        }
        
        $SQL='SELECT
                *
              FROM(
                    SELECT
                        e.codigoestudiante,
                        CONCAT(ee.nombresestudiantegeneral," ",ee.apellidosestudiantegeneral) AS nameEstudiante,
                        ee.numerodocumento,
                        n.nota,
                        n.numerofallaspractica AS FAP,
                        n.numerofallasteoria AS FAT
                     FROM
                            detallenota n
                        INNER JOIN estudiante e ON e.codigoestudiante = n.codigoestudiante
                        INNER JOIN estudiantegeneral ee ON ee.idestudiantegeneral=e.idestudiantegeneral

                     WHERE
                            n.codigoestado = 100
                        AND n.idcorte = ?
                        AND n.idgrupo = ?

                        GROUP BY e.codigoestudiante

                        UNION

                    SELECT
                        x.codigoestudiante,
                        x.nameEstudiante,
                        x.numerodocumento,
                        " " AS nota,
                        SUM(x.FAP) AS FAP,
                        SUM(x.FAT) AS FAT
                     FROM
                        (	SELECT
                                e.codigoestudiante,
                                CONCAT(ee.nombresestudiantegeneral," ",	ee.apellidosestudiantegeneral) AS nameEstudiante,
                                IF (f.codigomodalidadmateria = "01",COUNT(f.codigomodalidadmateria),0) AS FAT,
                                IF (f.codigomodalidadmateria = "02",COUNT(f.codigomodalidadmateria),0) AS FAP,
                                ee.numerodocumento
                            FROM
                                    prematricula p
                                INNER JOIN detalleprematricula dp ON dp.idprematricula = p.idprematricula
                                AND p.codigoestadoprematricula LIKE "4%"
                                AND dp.codigoestadodetalleprematricula = 30
                                INNER JOIN estudiante e ON e.codigoestudiante = p.codigoestudiante
                                INNER JOIN grupo g ON g.idgrupo = dp.idgrupo
                                AND g.codigoperiodo = p.codigoperiodo
                                AND g.codigoestadogrupo = 10
                                INNER JOIN estudiantegeneral ee ON ee.idestudiantegeneral = e.idestudiantegeneral
                                LEFT JOIN FallasEstudiante f ON f.CodigoEstudiante = e.codigoestudiante
                                AND f.IdGrupo = g.idgrupo
                                AND f.CodigoEstado = 100
                                AND f.FechaCreacion >= ?
                                AND f.FechaCreacion <= ?
                                LEFT JOIN modalidadmateria cm ON cm.codigomodalidadmateria = f.codigomodalidadmateria
                            WHERE
                                g.idgrupo = ?
                            GROUP BY
                                e.codigoestudiante,
                                f.codigomodalidadmateria	) x
                     GROUP BY
                        x.codigoestudiante) xx
                        '.$Condicion.'
                    GROUP BY xx.codigoestudiante
                    ORDER BY xx.codigoestudiante';
        
        $variable_principal[] = "$idcorte";
        $variable_principal[] = "$idgrupo";
        $variable_principal[] = "$fecha_1";
        $variable_principal[] = "$fecha_2";
        $variable_principal[] = "$idgrupo";
        
        //$this->db->debug = true;
        
        $Datos = $this->db->GetAll($SQL,$variable_principal);
        
        if($Datos===false){
            $json["result"]   ="ERROR";
            $json["codigoresultado"] =1;
            $json["mensaje"]         ="Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }
        
        $num = count($Datos);
        
        for($i=0;$i<$num;$i++){
            
            $Respuesta[$i]['codigoestudiante'] = $Datos[$i]['codigoestudiante'];
            $Respuesta[$i]['nameEstudiante']   = $Datos[$i]['nameEstudiante'];
            $Respuesta[$i]['numerodocumento']  = $Datos[$i]['numerodocumento'];
            $Respuesta[$i]['nota']             = $Datos[$i]['nota'];
            $Respuesta[$i]['FAP']              = $Datos[$i]['FAP'];
            $Respuesta[$i]['FAT']              = $Datos[$i]['FAT'];
        }//for
        //echo '<pre>';print_r($Respuesta);die;
        return $Respuesta;
    }//function ListaEstudiantesXNota
    function ValidarFechaCorte($idcorte){
        $SQL='SELECT
                idcorte
             FROM
                corte
             WHERE
                idcorte = ?
             AND CURDATE() >= fechainicialcorte
             AND fechafinalcorte >= CURDATE()';
        
        $variable[] = "$idcorte";
        
        //$this->db->debug=true;
        
        $Datos = $this->db->Execute($SQL,$variable);
        
        if($Datos===false){
            $json["result"]   ="ERROR";
            $json["codigoresultado"] =1;
            $json["mensaje"]         ="Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }
        
        if(!$Datos->EOF){
            return 1;
        }else{
            return 0;
        }
        
    }//function ValidarFechaCorte
    function DigitarNotasApp($idgrupo,$C_notas){
        
        $idcorte = $C_notas['NotasTotalCortes']['idcorte'];
        $act_Practica = $C_notas['NotasTotalCortes']['actividadespracticas'];                                                                   
        $act_Teorica = $C_notas['NotasTotalCortes']['actividadesteoricas'];   
        
        $SQL='SELECT *
			FROM nota n  
			WHERE idcorte = ?
			AND idgrupo = ?';    
        
        $variable_sql   = array();
        $variable_sql[] = "$idcorte";
        $variable_sql[] = "$idgrupo";
        
        //$this->db->debug=true;
        
        $DatosNota = $this->db->Execute($SQL,$variable_sql);
        
        if($DatosNota===false){
            $json["result"]   ="ERROR";
            $json["codigoresultado"] =1;
            $json["mensaje"]         ="Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }
        
        if(!$DatosNota->EOF){ 
              $query_updnota = 'UPDATE nota 

                                SET actividadesacademicasteoricanota =? , actividadesacademicaspracticanota = ?

                                WHERE
                                
                                idcorte = ?  AND idgrupo = ?';
            
            $VariablesUpNota   = array();
            $VariablesUpNota[] ="$act_Teorica";
            $VariablesUpNota[] ="$act_Practica";
            $VariablesUpNota[] ="$idcorte";
            $VariablesUpNota[] ="$idgrupo";
            
            //$this->db->debug=true;
        
            $NotaUpdate = $this->db->Execute($query_updnota,$VariablesUpNota);

            if($NotaUpdate===false){
                $json["result"]   ="ERROR";
                $json["codigoresultado"] =1;
                $json["mensaje"]         ="Error de Conexión del Sistema SALA";
                echo json_encode($json);
                exit;
            }
            
        }else{
          
             $insertSQL = 'INSERT INTO nota (idgrupo,idcorte,fechaorigennota,fechaultimoregistronota, actividadesacademicasteoricanota, actividadesacademicaspracticanota, codigotipoequivalencianota) VALUES(?,?,NOW(),NOW(),?,?,10)';
            
            $VariablesInsertSQL   = array();
            $VariablesInsertSQL[] ="$idgrupo";
            $VariablesInsertSQL[] ="$idcorte";
            $VariablesInsertSQL[] ="$act_Teorica";
            $VariablesInsertSQL[] ="$act_Practica";
            
            //$this->db->debug=true;
        
            $NotaInsert = $this->db->Execute($insertSQL,$VariablesInsertSQL);

            if($NotaInsert===false){
                $json["result"]   ="ERROR";
                $json["codigoresultado"] =1;
                $json["mensaje"]         ="Error de Conexión del Sistema SALA";
                echo json_encode($json);
                exit;
            }
            
        }
        
          $SQL_Materia='SELECT
                            codigomateria
                        FROM
                            grupo
                        WHERE
                            idgrupo = ?';
        
        $Variable_m   = array();
        $Variable_m[] = "$idgrupo";
        
        //$this->db->debug=true;
        
        $D_Materia = $this->db->GetRow($SQL_Materia,$Variable_m);
        
       $materia = $D_Materia['codigomateria'];
        
        if($D_Materia===false){
            $json["result"]   ="ERROR";
            $json["codigoresultado"] =1;
            $json["mensaje"]         ="Error de Conexión del Sistema SALA";
            echo json_encode($json);
            exit;
        }
        
        $numNotas = count($C_notas['NotasTotalCortes']['notas']);     
        
        for($i=0;$i<$numNotas;$i++){
            
            $codigoestudiante = $C_notas['NotasTotalCortes']['notas'][$i][$i]['codigoestudiante'];
            $Nota             = $C_notas['NotasTotalCortes']['notas'][$i][$i]['nota'];
            $FAT              = $C_notas['NotasTotalCortes']['notas'][$i][$i]['FAT'];
            $FAP              = $C_notas['NotasTotalCortes']['notas'][$i][$i]['FAP'];
            
            $SQL_Estudiante='SELECT 
                                    d.idgrupo,
                                    d.idcorte,
                                    d.codigoestudiante,
                                    d.codigomateria,
                                    d.nota,
                                    d.numerofallasteoria,
                                    d.numerofallaspractica,
                                    d.codigotiponota
                             FROM   
                                    detallenota d INNER JOIN nota n  ON d.idcorte=n.idcorte
                             WHERE 
                                    
                                 d.idcorte = ?
                             AND    d.idgrupo = ?
                             AND    d.codigoestudiante = ?
                             AND    d.codigomateria=?'; 
            
            $Variable_Detalle   = array();
            $Variable_Detalle[] = "$idcorte";
            $Variable_Detalle[] = "$idgrupo";
            $Variable_Detalle[] = "$codigoestudiante";
            $Variable_Detalle[] = "$materia";
            
            //$this->db->debug=true;
            
            $DetalleNota = $this->db->Execute($SQL_Estudiante,$Variable_Detalle);
            
            if($DetalleNota===false){
                $json["result"]   ="ERROR";
                $json["codigoresultado"] =1;
                $json["mensaje"]         ="Error de Conexión del Sistema SALA";
                echo json_encode($json);
                exit;
            }
           
            if(!$DetalleNota->EOF){  
                
                $base="UPDATE detallenota 
                 
                        SET    nota =?,
                               numerofallasteoria = ?,
                               numerofallaspractica = ?
                               
                        where idcorte = ?  and codigomateria = ?  and codigoestudiante =? AND idgrupo=?"; 
                
                $VariableBase    = array();
                $VariableBase[]  ="$Nota";
                $VariableBase[]  ="$FAT";
                $VariableBase[]  ="$FAP";
                $VariableBase[]  ="$idcorte";
                $VariableBase[]  ="$materia";
                $VariableBase[]  ="$codigoestudiante";
                $VariableBase[]  ="$idgrupo";
                
                //$this->db->debug=true;
                
                $DetalleNotaUpdate = $this->db->Execute($base,$VariableBase);
        
                if($DetalleNotaUpdate===false){
                    $json["result"]   ="ERROR";
                    $json["codigoresultado"] =1;
                    $json["mensaje"]         ="Error de Conexión del Sistema SALA";
                    echo json_encode($json);
                    exit;
                }
                
            }else{
                 
                $insertSQL_Detalle ='INSERT INTO detallenota (idgrupo,idcorte,codigoestudiante,codigomateria,nota,numerofallasteoria,numerofallaspractica,codigotiponota)VALUES(?,?,?,?,?,?,?,?)';
                $tipomateria        = 10;
                $VariableDetalle    = array();
                $VariableDetalle[]  ="$idgrupo";
                $VariableDetalle[]  ="$idcorte";
                $VariableDetalle[]  ="$codigoestudiante";
                $VariableDetalle[]  ="$materia";
                $VariableDetalle[]  ="$Nota";
                $VariableDetalle[]  ="$FAT";
                $VariableDetalle[]  ="$FAP";
                $VariableDetalle[]  ="$tipomateria";
                
                //$this->db->debug=true;
                
               $DetalleNotaInsert = $this->db->Execute($insertSQL_Detalle,$VariableDetalle);
                //die;
                if($DetalleNotaInsert===false){
                    $json["result"]   ="ERROR";
                    $json["codigoresultado"] =1;
                    $json["mensaje"]         ="Error de Conexión del Sistema SALA";
                    echo json_encode($json);
                    exit;
                }
                
            }
                
        }//for   
                                                                           
    }//function DigitarNotasApp
}//class
?>
