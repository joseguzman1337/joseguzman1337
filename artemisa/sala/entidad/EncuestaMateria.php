<?php
/*
 * Caso 107461.
 * @author Luis Dario Gualteros <castroluisd@unbosque.edu.do>
 * Se realizan las validaciones para el acceso a las encuestas de evaluación docente.
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @since 20 de Noviembre de 2018. 
 */
defined('_EXEC') or die;
class EncuestaMateria implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $idencuestamateria;
    
    /**
     * @type int
     * @access private
     */
    private $codigomateria;
    
    /**
     * @type int
     * @access private
     */
    private $idencuesta;
    
    /**
     * @type int
     * @access private
     */
    private $codigomodulopostind;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function setIdencuenstamateria($idencuenstamateria){
        $this->idencuenstamateria = $idencuenstamateria;
    }
    
    public function setCodigomateria($codigomateria){
        $this->codigomateria = $codigomateria;
    }
    
    public function setIdencuesta($idencuesta){
        $this->idencuesta = $idencuesta;
    }
    
    public function setCodigomodulopostind($codigomodulopostind){
        $this->codigomodulopostind = $codigomodulopostind;
    }
    
    public function getIdencuenstamateria(){
        return $this->idencuenstamateria;
    }    
    
    public function getCodigomateria(){
        return $this->codigomateria;
    }
    
    public function getIdencuesta(){
        return $this->idencuesta;
    }
    
    public function getCodigomodulopostind(){
        return $this->codigomodulopostind;
    }
    
    public function getById(){
        if(!empty($this->idencuesta)){
            $query = "SELECT * FROM encuestamateria"
                    ." WHERE idencuesta = ".$this->db->qstr($this->idencuesta);
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->idencuestamateria = $d['idencuestamateria'];
                $this->codigomateria = $d['codigomateria'];
                $this->codigomodulopostind = $d['codigomodulopostind'];
            }           
        }
    }
    
    public static function getList($where=null, $orderBy = null){
        $return = array();
        
        $query = "SELECT * FROM encuestamateria "
                    ." WHERE 1 ";
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        if(!empty($orderBy)){
            $query .= " ORDER BY ".$orderBy;
        }
        //d($query);
        $datos = $this->db->Execute($query);
        
        while( $d = $datos->FetchRow() ){
            $EncuestaMateria = new EncuestaMateria();
            $EncuestaMateria->idencuesta = $d['idencuesta'];
            $EncuestaMateria->idencuestamateria = $d['idencuestamateria'];
            $EncuestaMateria->codigomateria = $d['codigomateria'];
            $EncuestaMateria->codigomodulopostind = $d['codigomodulopostind'];
            
            $return[] = $EncuestaMateria;
            unset($EncuestaMateria);
        }
        
        return $return;
    }
      /**
     * Caso 1456
     * @modified Luis Dario Gualteros C <castroluisd@unbosque.edu.co>
     * Se modifica el inner join con la tabla ordenpago para unir con el campo idprematricula con el fin que se muestren las 
     * Materias matriculadas en diferentes ordenes de pago para el mismo periodo.
     * @since Mayo 30 de 2019.
    */
    public function getEncuestamateriaEstudiante($periodo, $carrera, $estudiante){                
        $db = Factory::createDbo();
        $queryMaterias = "
        SELECT dp.idgrupo, m.nombremateria
                FROM detalleprematricula dp
                INNER JOIN ordenpago o ON ( o.idprematricula = dp.idprematricula AND o.codigoestadoordenpago IN (40,41,42,44))
                INNER JOIN detalleordenpago d ON (o.numeroordenpago = d.numeroordenpago )
                INNER JOIN estudiante e ON ( o.codigoestudiante = e.codigoestudiante  AND e.codigoestudiante = ".$estudiante.")
                INNER JOIN materia m ON ( dp.codigomateria = m.codigomateria )
                WHERE o.codigoperiodo = ".$periodo."
                AND d.codigoconcepto = 151
                AND dp.numeroordenpago = o.numeroordenpago
                AND dp.codigoestadodetalleprematricula = '30'
                AND e.codigocarrera = ".$carrera." ";
    //End Caso 1456    
        $listados = $db->GetAll($queryMaterias);        
        $listamaterias = array();
        
        $y=0;
        foreach($listados as $codigomaterias){
            $listamaterias[$y]['idgrupo'] = $codigomaterias['idgrupo'];            
            $listamaterias[$y]['nombremateria'] = $codigomaterias['nombremateria'];            
            $y++;
        }
        return $listamaterias;        
    }
    /**
     * Caso 105
     * @modified Luis Dario Gualteros C <castroluisd@unbosque.edu.co>
     * Se adiciona el parametro de la categoria ($cat) para realizar las respectivas validaciones 
     * Para las encuestas de Bienestar Universitario.
     * @since Febrero 4, 2019.
    */
    public function getRespuestaencuestamateria($idusuario, $id, $cat, $materia=null){       
        $db = Factory::createDbo();
        $resultado = 0;
        //Se adiciona la validación del estado para que no liste duplicados Caso 107461.
        /**
         * Caso 1489.
         * @modified Luis Dario Gualteros C <castroluisd@unbosque.edu.co>
         * Se adiciona la condición AND p.obligatoria = '1' para que liste solo las preguntas obligatorias.
         * @since Mayo 28, 2019.
        */
        $contadorpreguntas= "SELECT COUNT(*) as contador ".
        " FROM siq_Ainstrumento i ".
        " INNER JOIN siq_Apregunta p ON (i.idsiq_Apregunta = p.idsiq_Apregunta) ".
        " WHERE ".
        " i.idsiq_Ainstrumentoconfiguracion = '".$id."' ".
        " AND p.obligatoria = '1' ".        
        " AND i.codigoestado = '100' ";         
        $cantidadpreguntas = $db->GetRow($contadorpreguntas);  
               
        if($materia == null){
            $sqlmateria = "";
        }else{
            $sqlmateria = " AND r.idgrupo = '".$materia."'";
        }
        /**
         * Caso 1489.
         * @modified Luis Dario Gualteros C <castroluisd@unbosque.edu.co>
         * Se adiciona la condición AND p.obligatoria = '1' para que liste solo las preguntas obligatorias.
         * @since Mayo 28, 2019.
        */
        //Se adiciona la validación del estado para que no liste duplicados Caso 107461.
        $contadorrespuestas = "SELECT count(*) as contador ".
        " FROM siq_Arespuestainstrumento r ".
        " INNER JOIN siq_Apregunta p ON (r.idsiq_Apregunta = p.idsiq_Apregunta) ".
        " WHERE r.idsiq_Ainstrumentoconfiguracion = '".$id."' ".
        " AND r.codigoestado = '100' ".
        " AND p.obligatoria = '1' ".
        " AND r.usuariocreacion = '".$idusuario."' ".$sqlmateria." ";        
        
        $cantidadrespuestas = $db->GetRow($contadorrespuestas);          
        //si exiten las preguntas y las respuestas
        if(isset($cantidadpreguntas['contador']) && isset($cantidadrespuestas['contador'])){
            //si la cantidad de preguntas es mayor a cero 
            if($cantidadpreguntas['contador'] > 0 ){
                //si la cantidad de respuestas es mayor a cero              
                if($cantidadrespuestas['contador'] > 0){
                    //si cantidad de respuestas es igual  a la cantidad de preguntas
                    if($cantidadrespuestas['contador'] == $cantidadpreguntas['contador']){
                        //ya termino de responder todas la preguntas y la materiua debe salir de la lista
                        //validacion de la categoria para evaluación docente.
                        if($cat == 'EDOCENTES'){
                            //Si existe el registro del grupo en la tabla siq_ADetallesRespuestaInstrumentoEvaluacionDocente Caso 107461.
                            $SQL_existeRes = "SELECT UsuarioCreacion, idgrupo
                            FROM
                                siq_ADetallesRespuestaInstrumentoEvaluacionDocente
                            WHERE
                                UsuarioCreacion = '".$idusuario."'
                            AND idgrupo = '".$materia."' 
                            AND codigoestado = '100' "; 
                            $resExiste  = $db->GetAll($SQL_existeRes);     
                            //Si no existe el registro en la tabla siq_ADetallesRespuestaInstrumentoEvaluacionDocente se crea Caso 107461.
                            
                            /**
                             * Caso 1489.
                             * @modified Luis Dario Gualteros C <castroluisd@unbosque.edu.co>
                             * Se adiciona la condición AND id_instrumento = '".$id."' para insertar el idactualizacionusuario. 
                             * @since Mayo 28, 2019.
                            */
                            if(empty($resExiste)) {
                            $SQL_insert ="INSERT INTO siq_ADetallesRespuestaInstrumentoEvaluacionDocente (
                                idactualizacionusuario,
                                idgrupo,
                                codigojornada,
                                UsuarioCreacion,
                                FechaCreacion,
                                codigoestado,
                                UsuarioUltimaModificacion,
                                FechaUltimaModificacion
                            )
                            VALUES
                                (
                                    (SELECT idactualizacionusuario FROM actualizacionusuario WHERE usuarioid = '".$idusuario."' AND id_instrumento = '".$id."'),
                                    '".$materia."',
                                    '01',
                                    '".$idusuario."',
                                    NOW(),
                                    '100',
                                    '".$idusuario."',
                                    NOW()
                                )";
                            $db->Execute($SQL_insert);
                            }
                            $resultado = true;
                        }else{
                            //actualizar registro 
                             $resultado = true;
                        }
                    }else
                      
                        //Si la cantidad de respuestas es mayor a la cantidad de Preguntas Caso 107461. 
                        if($cantidadrespuestas['contador'] > $cantidadpreguntas['contador']){
                            $sqlmateria = "";
                            //validacion de la categoria para evaluación docente.
                            if($cat == 'EDOCENTES'){
                                $sqlmateria = " AND idgrupo = '".$materia."'";
                            }
                            $SQL_duplicado ="SELECT
                                        MAX(idsiq_Arespuestainstrumento)as idsiq_Arespuestainstrumento ,
                                        idsiq_Apregunta,
                                        COUNT(*) Total
                                FROM
                                        siq_Arespuestainstrumento
                                WHERE
                                codigoestado = '100'
                                AND idsiq_Ainstrumentoconfiguracion = '".$id."'
                                AND usuariocreacion = '".$idusuario."'
                                ".$sqlmateria."
                                GROUP BY
                                        idsiq_Apregunta
                                HAVING
                                     COUNT(*) > 1";
                            
                            $resDuplicado  = $db->GetAll($SQL_duplicado); 
                            //Cambia de estado todas las respuestas duplicadas Caso 107461.
                            foreach($resDuplicado as $idrespuesta){
                                $SQL_Update = "UPDATE siq_Arespuestainstrumento SET codigoestado = '200' "
                                    ." WHERE idsiq_Ainstrumentoconfiguracion = '".$id."' "
                                    ." AND usuariocreacion = '".$idusuario."' "
                                    .$sqlmateria
                                    ." AND idsiq_Arespuestainstrumento <> '".$idrespuesta['idsiq_Arespuestainstrumento']."'"
                                    ." AND idsiq_Apregunta = '".$idrespuesta['idsiq_Apregunta']."' ";
                       
                                $db->Execute($SQL_Update);
                            }
                            $resultado = true;
                                           
                    }else{
                        //Validación de la categoria de docentes.
                        if($cat == 'EDOCENTES'){
                          $sqlgrupo = " AND idgrupo = '".$materia."'";  
                        }
                        //Cuando el estudiante no finalizó la encuesta se elimina para que empiece de nuevo Caso 107461.
                        $SQL_eliminaRes = "UPDATE siq_Arespuestainstrumento SET codigoestado ='200' "
                                . "WHERE  UsuarioCreacion = '".$idusuario."' AND codigoestado = '100'";
                       
                        $db->Execute($SQL_eliminaRes);
                        
                        //Si el estudiante no ha terminado la evaluación se cambia el estado del usuario para que continue con la encuesta Caso 107461.             
                        $SQL_updateUser = "UPDATE actualizacionusuario SET estadoactualizacion ='2' "
                                . "WHERE id_instrumento = '".$id."' AND userid = '".$idusuario."' ".$sqlgrupo." LIMIT 1";
                         $db->Execute($SQL_updateUser);
                        $resultado = false;
                    }
                }else{
                    //Materia pendiente 
                     $resultado = false;
                }
            }else{
                //Materia pendiente 
                $resultado = false;
            }
    }
        return $resultado;
    }//public function getRespuestaencuestamateria
}
