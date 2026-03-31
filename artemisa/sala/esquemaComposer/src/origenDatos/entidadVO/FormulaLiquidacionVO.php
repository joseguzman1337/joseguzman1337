<?php

namespace App\origenDatos\entidadVO;


class FormulaLiquidacionVO
{

    private $FormulaLiquidacionId;

    private $CodigoCarrera;

    private $convenioId;

    private $Formula;

    private $CodigoEstado;

    private $FechaInicioVigencia;

    private $FechaFinVigencia;

    private $FechaCreacion;

    private $UsuarioCreacion;

    private $FechaModificacion;

    private $UsuarioModificacion;

    /**
     * @return mixed
     */
    public function getFormulaLiquidacionId()
    {
        return $this->FormulaLiquidacionId;
    }

    /**
     * @param mixed $FormulaLiquidacionId
     */
    public function setFormulaLiquidacionId($FormulaLiquidacionId)
    {
        $this->FormulaLiquidacionId = $FormulaLiquidacionId;
    }

    /**
     * @return mixed
     */
    public function getCodigoCarrera()
    {
        return $this->CodigoCarrera;
    }

    /**
     * @param mixed $CodigoCarrera
     */
    public function setCodigoCarrera($CodigoCarrera)
    {
        $this->CodigoCarrera = $CodigoCarrera;
    }

    /**
     * @return mixed
     */
    public function getConvenioId()
    {
        return $this->convenioId;
    }

    /**
     * @param mixed $convenioId
     */
    public function setConvenioId($convenioId)
    {
        $this->convenioId = $convenioId;
    }

    /**
     * @return mixed
     */
    public function getFormula()
    {
        return $this->Formula;
    }

    /**
     * @param mixed $Formula
     */
    public function setFormula($Formula)
    {
        $this->Formula = $Formula;
    }

    /**
     * @return mixed
     */
    public function getCodigoEstado()
    {
        return $this->CodigoEstado;
    }

    /**
     * @param mixed $CodigoEstado
     */
    public function setCodigoEstado($CodigoEstado)
    {
        $this->CodigoEstado = $CodigoEstado;
    }

    /**
     * @return mixed
     */
    public function getFechaInicioVigencia()
    {
        return $this->FechaInicioVigencia;
    }

    /**
     * @param mixed $FechaInicioVigencia
     */
    public function setFechaInicioVigencia($FechaInicioVigencia)
    {
        $this->FechaInicioVigencia = $FechaInicioVigencia;
    }

    /**
     * @return mixed
     */
    public function getFechaFinVigencia()
    {
        return $this->FechaFinVigencia;
    }

    /**
     * @param mixed $FechaFinVigencia
     */
    public function setFechaFinVigencia($FechaFinVigencia)
    {
        $this->FechaFinVigencia = $FechaFinVigencia;
    }

    /**
     * @return mixed
     */
    public function getFechaCreacion()
    {
        return $this->FechaCreacion;
    }

    /**
     * @param mixed $FechaCreacion
     */
    public function setFechaCreacion($FechaCreacion)
    {
        $this->FechaCreacion = $FechaCreacion;
    }

    /**
     * @return mixed
     */
    public function getUsuarioCreacion()
    {
        return $this->UsuarioCreacion;
    }

    /**
     * @param mixed $UsuarioCreacion
     */
    public function setUsuarioCreacion($UsuarioCreacion)
    {
        $this->UsuarioCreacion = $UsuarioCreacion;
    }

    /**
     * @return mixed
     */
    public function getFechaModificacion()
    {
        return $this->FechaModificacion;
    }

    /**
     * @param mixed $FechaModificacion
     */
    public function setFechaModificacion($FechaModificacion)
    {
        $this->FechaModificacion = $FechaModificacion;
    }

    /**
     * @return mixed
     */
    public function getUsuarioModificacion()
    {
        return $this->UsuarioModificacion;
    }

    /**
     * @param mixed $UsuarioModificacion
     */
    public function setUsuarioModificacion($UsuarioModificacion)
    {
        $this->UsuarioModificacion = $UsuarioModificacion;
    }



}