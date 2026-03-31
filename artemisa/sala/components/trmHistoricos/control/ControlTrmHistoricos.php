<?php
defined('_EXEC') or die;
class ControlTrmHistoricos
{
    private $db;
    public function __construct($variables) {
        $this->db = Factory::createDbo();
        $this->variables = $variables;
        if (empty($this->variables->dataType)) {
            $this->variables->dataType = null;
        }
        if (empty($this->variables->dataAction)) {
            $this->variables->dataAction = null;
        }
    }

    public function administrarTrmHistorico(){
        $logica = array();
        $validaTrmHistorico = $this->validarTrmHistorico();

        if (!empty($validaTrmHistorico)){
            if(empty($this->variables->item)){
                $return = array("n" => true, "msj" => "!Ya existe un TRM del día.");
                //se ingresa por el boton nuevo
            }else{
                $return = array("s" => true, "msj" => "!Registro actualizado con exito");
            }

            $logica["idTrmHistorico"] = $validaTrmHistorico[0]->getidTrmHistorico();
            $logica["fechaCreacion"]=$validaTrmHistorico[0]->getfechaCreacion();
            $logica["dia"]=$validaTrmHistorico[0]->getdia();
            $logica["tipoTrm"]=$validaTrmHistorico[0]->gettipoTrm();
            $logica["tipoMoneda"]=$validaTrmHistorico[0]->gettipoMoneda();
            $logica["valorTrm"]=$validaTrmHistorico[0]->getvalorTrm();
            $logica["novedad"]=$validaTrmHistorico[0]->getnovedad();
            $logica["vigenciaDesde"]=$validaTrmHistorico[0]->getvigenciaDesde();
            $logica["vigenciaHasta"]=$validaTrmHistorico[0]->getvigenciaHasta();
            $this->trmHistorico($logica);
        }else{
            $trm = $this->trmHistorico();
            if($trm==false){
                $return = array("n" => true, "msj" => "Ha ocurrido un error");
            }else{
                $return = array("s" => true, "msj" => "TRM del día guardado con exito");
            }
        }

        echo json_encode($return);
    }
    private function trmHistorico($logica = null ) {
        $estadoRegistro = 100;
        $item          = $this->variables->item;
        $valorTrm      = $this->variables->valorTrm;
        $fechaInicio   = $this->variables->fechaInicio." 00:00:00";
        $fechaFin      = $this->variables->fechaFin." 23:59:59";
        $tipoMoneda    = $this->variables->tipoMoneda;
        $novedad       = $this->variables->novedad;
        $fechaCreacion = date("Y-m-d H:i:s");
        $dia           = $this->obtenerDia($fechaInicio);
        $tipoTrm       = $this->variables->tipotrm;
        if(!empty($this->variables->estadoTrm)){
            $estadoRegistro = $this->variables->estadoTrm;
        }
        $trmHistorico = new \TrmHistorico();
        if (!empty($logica)){
            $trmHistorico->setIdTrmHistorico($logica["idTrmHistorico"]);
            $trmHistorico->setFechaCreacion($logica["fechaCreacion"]);
            $trmHistorico->setDia($logica["dia"]);
            $trmHistorico->setTipoTrm($logica["tipoTrm"]);
            $trmHistorico->setTipoMoneda($logica["tipoMoneda"]);
            $trmHistorico->setValorTrm($logica["valorTrm"]);
            $trmHistorico->setVigenciaDesde($logica["vigenciaDesde"]);
            $trmHistorico->setVigenciaHasta($logica["vigenciaHasta"]);
            $trmHistorico->setCodigoEstado($logica["vigenciaHasta"]);
            if ($this->variables->tipotrm != "Proceso-Automatico" && !empty($this->variables->item)) {
                $trmHistorico->setNovedad($this->variables->novedad);
            }else{
                $trmHistorico->setNovedad($logica["novedad"]);
            }
            $trmHistorico->setCodigoEstado($estadoRegistro);
        }else{
            $trmHistorico->setTipoTrm($this->variables->tipotrm);
            $trmHistorico->setFechaCreacion($fechaCreacion);
            $trmHistorico->setDia($dia);
            $trmHistorico->setNovedad($this->variables->novedad);
            $trmHistorico->setTipoMoneda($this->variables->tipoMoneda);
            $trmHistorico->setValorTrm($this->variables->valorTrm);
            $trmHistorico->setVigenciaDesde($fechaInicio);
            $trmHistorico->setVigenciaHasta($fechaFin);
            $trmHistorico->setCodigoEstado($estadoRegistro);
        }
        $trmHistoricoDAO = new Sala\entidadDAO\TrmHistoricoDAO($trmHistorico);
        $trmHistoricoDAO->setDb();
        return  $trmHistoricoDAO->save();

    }

    public function validarTrmHistorico(){

        $tipoMonedaTrm= $this->variables->tipoMoneda;
        $valorTrm = $this->variables->valorTrm;
        $fechaIncicio = $this->variables->fechaInicio." 00:00:00";
        $fechaIncicio = date("Y-m-d H:i:s", strtotime($fechaIncicio));
        $fechaFin = $this->variables->fechaFin." 23:59:59";
        $where = " vigenciatrmdesde >= '".$fechaIncicio."' AND vigenciatrmhasta <= '".$fechaFin."'  AND tipomoneda=".$tipoMonedaTrm;
        if (empty($this->variables->item)){  $where.=" AND codigoestado=100"; }
        $trmHistorico = new \TrmHistorico();
        $verificacionHistoricoDia = $trmHistorico->getList($where,' idtrmhistorico desc');
        return $verificacionHistoricoDia;
    }

    public function obtenerDia($fecha){
        $nuemeroDia="";
        $fechats = strtotime($fecha); //pasamos a timestamp
        //el parametro w en la funcion date indica que queremos el dia de la semana
        //lo devuelve en numero 0 domingo, 1 lunes,....
        switch (date('w', $fechats)){
            case 0:  $nuemeroDia = 7;   break;
            case 1:  $nuemeroDia = 1;   break;
            case 2:  $nuemeroDia = 2;   break;
            case 3:  $nuemeroDia = 3;   break;
            case 4:  $nuemeroDia = 4;   break;
            case 5:  $nuemeroDia = 5;   break;
            case 6:  $nuemeroDia = 6;   break;
        }
        return $nuemeroDia;
    }

}

