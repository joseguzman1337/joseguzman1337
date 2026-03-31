<?php
/**
 * @author Diego Rivera<riveradiego@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package reportes/entidad
*/
defined('_EXEC') or die;
require_once(PATH_SITE."/entidad/LineaEnfasisPlanEstudio.php");
require_once(PATH_SITE."/entidad/EstudianteGeneral.php");

class EnfasisPlanEstudio extends LineaEnfasisPlanEstudio{
    /**
     * @type varchar
     * @access private
     */
    private $nombrePlanEstudio;
    /**
     * @type int
     * @access private
     */
    private $cantidadSemestres;
    /**
     * @type obj
     * @access private
     */
    private $estudianteGeneral;
    
    /**
     * @type int
     * @access private
     */
    private $codigoEstudiante;
    
    /**
     * @type varchar
     * @access private
     */
    private $email;
    
    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

        public function getCodigoEstudiante() {
        return $this->codigoEstudiante;
    }

    public function setCodigoEstudiante($codigoEstudiante) {
        $this->codigoEstudiante = $codigoEstudiante;
    }

        
    public function getEstudianteGeneral() {
        return $this->estudianteGeneral;
    }

    public function setEstudianteGeneral($estudianteGeneral) {
        $this->estudianteGeneral = $estudianteGeneral;
    }
       
    public function getNombrePlanEstudio() {
        return $this->nombrePlanEstudio;
    }

    public function setNombrePlanEstudio($nombrePlanEstudio) {
        $this->nombrePlanEstudio = $nombrePlanEstudio;
    }
    
    public function getCantidadSemestres() {
        return $this->cantidadSemestres;
    }

    public function setCantidadSemestres($cantidadSemestres) {
        $this->cantidadSemestres = $cantidadSemestres;
    }
    
    public static function getListLineas( ) {
        $db = Factory::createDbo();        
        $return = array();
        $query = "
                    SELECT
                            LE.idlineaenfasisplanestudio,
                            LE.nombrelineaenfasisplanestudio,
                            PE.nombreplanestudio
                    FROM
                            planestudio PE
                            INNER JOIN lineaenfasisplanestudio LE ON ( PE.idplanestudio = LE.idplanestudio ) 
                    WHERE
                            PE.codigocarrera = 130 
                            AND LE.fechavencimientolineaenfasisplanestudio > now( ) 
                            AND LE.codigoestadolineaenfasisplanestudio NOT IN ( 200 ) 
                            AND PE.codigoestadoplanestudio = 100 
                    GROUP BY
                            LE.idlineaenfasisplanestudio
                    ORDER BY         
                            PE.nombreplanestudio
                    ";
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $EnfasisPlanEstudio= new EnfasisPlanEstudio();
            $EnfasisPlanEstudio->setIdlineaenfasisplanestudio($d["idlineaenfasisplanestudio"]);
            $EnfasisPlanEstudio->setNombrelineaenfasisplanestudio($d["nombrelineaenfasisplanestudio"]);
            $EnfasisPlanEstudio->setNombreplanestudio($d["nombreplanestudio"]);
            $return[] = $EnfasisPlanEstudio;
            unset($EnfasisPlanEstudio);
        }
        return $return;
    }
    
    
    public function getSemestre( ){
        $db = Factory::createDbo();         
        $query = "SELECT
                      max( cantidadsemestresplanestudio ) as cantidadSemestres 
                  FROM
                      planestudio 
                  WHERE
                      codigocarrera = 130 AND codigoestadoplanestudio not in (200)";
            
          $datos = $db->Execute($query);
          $d = $datos->FetchRow();
          return $d;
    }
    
    public function estudianteEnfasis( $where=null ){
        $db = Factory::createDbo();        
        $return = array();
        
        $query ="
                SELECT
                    EG.numerodocumento,
                    EG.nombresestudiantegeneral,
                    EG.apellidosestudiantegeneral,
                    LEP.nombrelineaenfasisplanestudio,
                    E.codigoestudiante,
                    U.usuario
                FROM
                    prematricula P
                    INNER JOIN detalleprematricula DP ON ( P.idprematricula = DP.idprematricula )
                    INNER JOIN lineaenfasisestudiante LEE ON ( P.codigoestudiante = LEE.codigoestudiante )
                    INNER JOIN lineaenfasisplanestudio LEP ON ( LEE.idlineaenfasisplanestudio = LEP.idlineaenfasisplanestudio )
                    INNER JOIN estudiante E ON ( P.codigoestudiante = E.codigoestudiante )
                    INNER JOIN estudiantegeneral EG ON ( E.Idestudiantegeneral = EG.Idestudiantegeneral )
                    INNER JOIN detallelineaenfasisplanestudio DLE ON ( DP.codigomateria = DLE.codigomateriadetallelineaenfasisplanestudio ) 
                    INNER JOIN usuario U on (EG.numerodocumento = U.numerodocumento)
                WHERE  
                    DP.codigoestadodetalleprematricula = 30 
                    AND LEE.fechavencimientolineaenfasisestudiante > now( ) 
                    AND E.codigocarrera = 130 AND U.codigorol=1";
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        
        $query .=" GROUP BY numerodocumento";
        
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $EnfasisPlanEstudio= new EnfasisPlanEstudio();
            
            $estudianteGeneralEnfasis = new EstudianteGeneral();
            $estudianteGeneralEnfasis->setNombresestudiantegeneral( $d["nombresestudiantegeneral"] );
            $estudianteGeneralEnfasis->setNumerodocumento( $d["numerodocumento"] );
            $estudianteGeneralEnfasis->setApellidosestudiantegeneral( $d["apellidosestudiantegeneral"] );
            $EnfasisPlanEstudio->setCodigoEstudiante($d["codigoestudiante"]);
            $EnfasisPlanEstudio->setEstudianteGeneral($estudianteGeneralEnfasis);
            $EnfasisPlanEstudio->setNombrelineaenfasisplanestudio( $d["nombrelineaenfasisplanestudio"] );
            $EnfasisPlanEstudio->setEmail($d["usuario"]."@unbosque.edu.co" );
            $return[] = $EnfasisPlanEstudio;
            unset($EnfasisPlanEstudio);
        }
        return $return;
    }
    
}
