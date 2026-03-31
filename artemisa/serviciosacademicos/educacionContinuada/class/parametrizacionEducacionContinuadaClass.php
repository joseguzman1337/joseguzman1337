<?php

/**
 * Description of campoParametrizadoPlantillaEducacionContinuadaClass
 *
 * @author proyecto_mgi_cp
 */
class parametrizacionEducacionContinuadaClass {
    
    var $idparametrizacionEducacionContinuada = null;
    var $categoria = null;
    var $nombreCampo = null;
    var $nombreTabla = null;
    var $etiquetaCampo = null;
    var $valor = null;
    var $tipoCampo = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdparametrizacionEducacionContinuada() {
        return $this->idparametrizacionEducacionContinuada;
    }

    public function setIdparametrizacionEducacionContinuada($idparametrizacionEducacionContinuada) {
        $this->idparametrizacionEducacionContinuada = $idparametrizacionEducacionContinuada;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    public function getNombreTabla() {
        return $this->nombreTabla;
    }

    public function setNombreTabla($nombreTabla) {
        $this->nombreTabla = $nombreTabla;
    }

    public function getNombreCampo() {
        return $this->nombreCampo;
    }

    public function setNombreCampo($nombreCampo) {
        $this->nombreCampo = $nombreCampo;
    }
    
    public function getEtiquetaCampo() {
        return $this->etiquetaCampo;
    }

    public function setEtiquetaCampo($etiquetaCampo) {
        $this->etiquetaCampo = $etiquetaCampo;
    }
    
    public function getTipoCampo() {
        return $this->tipoCampo;
    }

    public function setTipoCampo($tipoCampo) {
        $this->tipoCampo = $tipoCampo;
    }
    
    public function getValor() {
        return $this->valor;
    }

    public function setValor($valor) {
        $this->valor = $valor;
    }
    
    public function getCodigoestado() {
        return $this->codigoestado;
    }

    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

    public function getFecha_modificacion() {
        return $this->fecha_modificacion;
    }

    public function setFecha_modificacion($fecha_modificacion) {
        $this->fecha_modificacion = $fecha_modificacion;
    }

    public function getUsuario_modificacion() {
        return $this->usuario_modificacion;
    }

    public function setUsuario_modificacion($usuario_modificacion) {
        $this->usuario_modificacion = $usuario_modificacion;
    }
        
    public function __destruct() {
        
    }
}
?>
