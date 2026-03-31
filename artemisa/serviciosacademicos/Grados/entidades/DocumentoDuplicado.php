<?php

/**
 * @author Carlos Alberto Suárez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología - Universidad el Bosque
 * @package entidades
 */
class DocumentoDuplicado {

    /**
     * @type int
     * @access private
     */
    private $idDocumentoDuplicado;

    /**
     * @type Referencia
     * @access private
     */
    private $referenciaGrado;

    /**
     * @type RegistroGrado
     * @access private
     */
    private $registroGrado;

    /**
     * @type int
     * @access private
     */
    private $estadoDuplicado;
    
    function getNumeroDiploma() {
        return $this->numeroDiploma;
    }

    function getEstudiante() {
        return $this->estudiante;
    }

    function setNumeroDiploma($numeroDiploma) {
        $this->numeroDiploma = $numeroDiploma;
    }

    function setEstudiante($estudiante) {
        $this->estudiante = $estudiante;
    }

    
    /**
     * @type Singleton
     * @access private
     */
    private $persistencia;

    /**
     * Constructor
     * @param $persistencia Singleton
     */
    public function DocumentoDuplicado($persistencia) {
        $this->persistencia = $persistencia;
    }

    /**
     * Modifica el id del documento duplicado
     * @param int $idDocumentoDuplicado
     * @access public
     * @return void
     */
    public function setIdDocumentoDuplicado($idDocumentoDuplicado) {
        $this->idDocumentoDuplicado = $idDocumentoDuplicado;
    }

    /**
     * Retorna el id del documento duplicado
     * @access public
     * @return int
     */
    public function getIdDocumentoDuplicado() {
        return $this->idDocumentoDuplicado;
    }

    /**
     * Modifica la referencia del documento duplicado
     * @param Referencia $referenciaGrado
     * @access public
     * @return void
     */
    public function setReferenciaGrado($referenciaGrado) {
        $this->referenciaGrado = $referenciaGrado;
    }

    /**
     * Retorna la referencia del documento duplicado
     * @access public
     * @return Referencia
     */
    public function getReferenciaGrado() {
        return $this->referenciaGrado;
    }

    /**
     * Modifica el registro de grado del documento duplicado
     * @param RegistroGrado $registroGrado
     * @access public
     * @return void
     */
    public function setRegistroGrado($registroGrado) {
        $this->registroGrado = $registroGrado;
    }

    /**
     * Retorna el registro de grado del documento duplicado
     * @access public
     * @return RegistroGrado
     */
    public function getRegistroGrado() {
        return $this->registroGrado;
    }

    /**
     * Modifica el estado del documento duplicado
     * @param int $estadoDuplicado
     * @access public
     * @return void
     */
    public function setEstadoDuplicado($estadoDuplicado) {
        $this->estadoDuplicado = $estadoDuplicado;
    }

    /**
     * Retorna el estado del documento duplicado
     * @access public
     * @return int
     */
    public function getEstadoDuplicado() {
        return $this->estadoDuplicado;
    }

    /**
     * Crear registro Documento Duplicado
     * @access public
     * @return boolean
     */
    public function crearDocumentoDuplicado($txtIdReferenciaGrado, $txtCodigoEstudiante, $txtIdRegistroGrado, $txtNumeroDiplomaDuplicado, $idDirectivo, $txtIdUsuario) {

        $sql = "INSERT INTO DocumentoDuplicadoGrado (
						ReferenciaGradoId,
						EstudianteId,
						RegistroGradoId,
						NumeroDiploma,
						CodigoEstado,
						DirectivoId,
						UsuarioCreacion,
						UsuarioModificacion,
						FechaCreacion,
						FechaUltimaModificacion
					)
					VALUES
						(	
							?,
							?,
							?,
							?,
							100,
							?,
							?,
							NULL,
							NOW(),
							NULL
						)";
        $this->persistencia->crearSentenciaSQL($sql);


        $this->persistencia->setParametro(0, $txtIdReferenciaGrado, false);
        $this->persistencia->setParametro(1, $txtCodigoEstudiante, false);
        $this->persistencia->setParametro(2, $txtIdRegistroGrado, false);
        $this->persistencia->setParametro(3, $txtNumeroDiplomaDuplicado, true);
        $this->persistencia->setParametro(4, $idDirectivo, false);
        $this->persistencia->setParametro(5, $txtIdUsuario, false);
        //echo $this->persistencia->getSQLListo( );
        $estado = $this->persistencia->ejecutarUpdate();
        if ($estado)
            $this->persistencia->confirmarTransaccion();
        else
            $this->persistencia->cancelarTransaccion();

        //$this->persistencia->freeResult( );

        return $estado;
    }

    public function lista() {
        $duplicado = array();
        $sql = "SELECT
                        d.nombrecortodocumento,
                        eg.numerodocumento,
                        CONCAT( eg.nombresestudiantegeneral, ' ' , eg.apellidosestudiantegeneral )as nombre,
                        rg.RegistroGradoId,
                        c.nombrecarrera,
                        fg.CodigoPeriodo,
                        rg.NumeroDiploma,
                        ddg.NumeroDiploma as nuevo
                FROM
                        DocumentoDuplicadoGrado ddg
                        INNER JOIN estudiante e ON ( ddg.EstudianteId = e.codigoestudiante )
                        INNER JOIN estudiantegeneral eg ON ( e.idestudiantegeneral = eg.idestudiantegeneral )
                        INNER JOIN documento d ON ( eg.tipodocumento = d.tipodocumento )
                        INNER JOIN RegistroGrado rg ON ( ddg.RegistroGradoId = rg.RegistroGradoId )
                        INNER JOIN AcuerdoActa aa ON ( rg.AcuerdoActaId = aa.AcuerdoActaId )
                        INNER JOIN FechaGrado fg ON ( aa.FechaGradoId = fg.FechaGradoId )
                        INNER JOIN carrera c ON ( e.codigocarrera = c.codigocarrera )";

        $this->persistencia->crearSentenciaSQL($sql);
        //echo $this->persistencia->getSQLListo( );
        $this->persistencia->ejecutarConsulta();
        $n=0;
        $objeto="";
        while ($this->persistencia->getNext()) {
         
           $objetoGrado=$objeto.$n ;
           $objetoGrado= new stdClass();
            
            $objetoGrado->nombre = $this->persistencia->getParametro("nombre");
            $objetoGrado->documento=$this->persistencia->getParametro("nombrecortodocumento");
            $objetoGrado->numeroDocumento=$this->persistencia->getParametro("numerodocumento");
            $objetoGrado->carrera=$this->persistencia->getParametro("nombrecarrera");
            $objetoGrado->periodo=$this->persistencia->getParametro("CodigoPeriodo");
            $objetoGrado->diplomaAntiguo=$this->persistencia->getParametro("NumeroDiploma");
            
            $documentoDuplicado = new DocumentoDuplicado(null);
            $documentoDuplicado->setRegistroGrado($this->persistencia->getParametro("RegistroGradoId"));
            $documentoDuplicado->setNumeroDiploma($this->persistencia->getParametro("nuevo"));
            $documentoDuplicado->setReferenciaGrado($objetoGrado);
            $duplicado[] = $documentoDuplicado;
            $n++;            
        }
        return $duplicado;
    }

}

?>