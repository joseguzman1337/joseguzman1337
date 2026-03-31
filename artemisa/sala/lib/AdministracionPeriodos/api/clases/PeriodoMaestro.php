<?php
namespace Sala\lib\AdministracionPeriodos\api\clases;
defined('_EXEC') or die;

/**
 * Clase PeriodoMaestro encargado de la orquestacion de las funcionalidades 
 * que controlan al periodo financiero
 * 
 * @author Diego Fernando Rivera Castro<riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package Sala\lib\AdministracionPeriodos\api\interfaces
 */
class PeriodoMaestro implements \Sala\lib\AdministracionPeriodos\api\interfaces\IPeriodo {
    
    /**
     * $variables es una variable privada, contenedora de el objeto estandar en 
     * el cual se setean todas las variables recibidas por el sistema a nivel 
     * POST, GET y REQUEST
     * 
     * @var stdObject
     * @access private
     */
    private $variables;
    
    private $iActualizaTablasPeriodos;

    /**
     * Constructor de la clase PeriodoMaestro 
     * @author Diego Fernando Rivera Castro<riveradiego@unbosque.edu.co>
     * @return void
     */ 
    public function __construct() {        
    }
    
    /**
     * Este metodo inicializa el atributo variables con el objeto variables 
     * recibido mediante el REQUEST
     * @access public
     * @param \stdClass $variables Variables recibidas del REQUEST
     * @author Diego Fernando Rivera Castro<riveradiego@unbosque.edu.co>
     * @since febrero 19, 2019
    */ 
    public function setVariables($variables) {
        $this->variables = $variables;
    }

    /**
     * Retorna las variables requeridas en la vista listar periodo maestro
     * @access public
     * @return array Variables necesarias para la vista listar periodo maestro
     * @author Diego Fernando Rivera Castro<riveradiego@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public function listarPeriodo() {
        $array = array();
        $array["periodoMaestro"] = $this->getList(null,"codigo DESC");
        return $array;
    }

    /**
     * Retorna las variables requeridas en la vista para crear/editar periodo maestro
     * @access public
     * @return array Variables necesarias para la vista crear/editar periodo maestro
     * @author Diego Fernando Rivera Castro<riveradiego@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public function nuevoPeriodo() {
        $array = array();

        if (!empty($this->variables->id)) {
            $ePeriodoMaestro = new \PeriodoMaestro();
            $ePeriodoMaestro->setId($this->variables->id);
            $ePeriodoMaestro->setDb();
            $ePeriodoMaestro->getById();
        } else {
            $ePeriodoMaestro = null;
        }
        $array['ePeriodoMaestro'] = $ePeriodoMaestro;
        $anios = \Ano::getList(" codigoestado = 100");
        $array["anio"] = $anios;

        return $array;
    }

    /**
     * Retorna un array de DTOs de entidoades de tipo \PeriodoMaestro
     * @access public
     * @param string $where Si es necesaria, una condicion para filtrar la lista de entidades
     * @return array Array de DTOs de las entidades de periodo maestro
     * @author Diego Fernando Rivera Castro<riveradiego@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public function getList($where = null,$orderBy = null) {
        $periodosMaestros = \PeriodoMaestro::getList($where,$orderBy);
        $array = array();

        foreach ($periodosMaestros as $p) {
            $obj = new \stdClass();

            $obj->id = $p->getId();
            $obj->codigo = $p->getCodigo();
            $obj->nombre = $p->getNombre();
            $obj->numeroPeriodo = $p->getNumeroPeriodo();
            
            $idAgno=$obj->idAgno = $p->getIdAgno();
            $obj->codigoEstado = $p->getCodigoEstado(); 
            
            $eEstado = new \Estado();
            $eEstado->setCodigoestado($obj->codigoEstado);
            $eEstado->setDb();
            $eEstado->getById();
            
            $obj->codigoEstado = $eEstado->getNombreestado();
        
            $db = \Factory::createDbo();

            $Agno = new \Ano();
            $Agno->setDb($db);
            $Agno->setIdAno($idAgno);
            $Agno->getById();
            $obj->anio = $Agno->getCodigoAno();
            $array[] = $obj;
        }
        return $array;
    }

    /**
     * Guarda en base de datos el objeto creado/editado desde la vista de 
     * creacion/edicion de periodos maestros
     * @access public
     * @return array Array con la estructura de respuesta json s => estado, msj => mensaje
     * @author Diego Fernando Rivera Castro<riveradiego@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public function guardarPeriodo() {
        $result = false;
        $periodoMaestro = new \PeriodoMaestro();
        $verificarCodigoPeriodo = 0;
        $verificarSecuencia = 0;
        $nombrePeriodo = "Período de " . $this->variables->codigoMaestro;
        if ($this->variables->secuencia == "secuencia") {
            $return = array("s"=>true,"msj"=>"Periodo guardado/actualizado correctamente");
            $periodosSecuencia = $this->validarPeriodo();
            
            if(sizeof($periodosSecuencia)==0){
                $return = array("s"=>false,"msj"=>"No se han creado períodos maestros");
            }else{
                foreach($periodosSecuencia as $p){
                    $periodoMaestroDao = new \Sala\entidadDAO\PeriodoMaestroDAO($p);
                    $periodoMaestroDao->setDb();
                    $periodoMaestroDao->save();
                }
            }
            
          echo json_encode( $return  );
          
        } else {

            $validarPeriodoMaestro = $this->validarPeriodo();
            if($validarPeriodoMaestro["s"]){
                $periodoMaestroDao = new \Sala\entidadDAO\PeriodoMaestroDAO($periodoMaestro);
                $periodosMaestro = $this->getPeriodoMaestro($periodoMaestro);
                $periodoMaestroDao->setDb();
                $result = $periodoMaestroDao->save();
            }
            if($result && !empty($this->variables->id)){
                $this->iActualizaTablasPeriodos = \Sala\lib\AdministracionPeriodos\api\clases\PeriodoFacatory::IActualizarTablasPeriodos($periodoMaestro);
                $this->iActualizaTablasPeriodos->actualizarTablaCarreraPeriodo();
                $this->iActualizaTablasPeriodos->actualizarTablaPeriodo();
                $this->iActualizaTablasPeriodos->actualizarTablaSubperiodo();
            }
            echo json_encode( $validarPeriodoMaestro );            
        }
    }

    /**
     * Valida los datos recibido del periodo maestro antes del guardado
     * @access public
     * @return array Array con la estructura de respuesta json s => estado, msj => mensaje
     * @author Diego Fernando Rivera Castro<riveradiego@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public function validarPeriodo() {
        $verificarCodigoPeriodo = 0;
        $verificarSecuencia = 0;
        $numerador = null;
        $return = array("s"=>true,"msj"=>"Periodo guardado/actualizado correctamente");
        
        if ( is_numeric( $this->variables->numeroPeriodo ) ) {
             if ($this->variables->secuencia == "secuencia") {
                $verificarCodigoPeriodo = 0;
                $nombrePeriodo = "Período de " . $this->variables->codigoMaestro;
                $contador = 1;
                $periodosCreados = 0;
                $array=array();
                
                while ($contador <= $this->variables->numeroPeriodo) {
                    $periodoMaestro = new \PeriodoMaestro();
                    $periodosMaestro = $this->getPeriodoMaestro($periodoMaestro, $contador);
                    $codigo = $this->variables->codigoMaestro . $contador;
                    $verificarCodigoPeriodo = $this->validarDuplicado($periodosMaestro);
                    $nombre = \Sala\utiles\ConvertirNumeroLetra\NumerosLetra::numToOrdinal($contador);
                    
                    if ( $verificarCodigoPeriodo <> 0 ) {
                        $contador++;
                    }else {
                        $periodosMaestro->setId(NULL);
                        $periodosMaestro->setNombre(mb_strtoupper($nombre . " " . $nombrePeriodo, "UTF-8"));
                        $array[]=$periodosMaestro;
                        $contador++;
                    }
                }       
                return $array;
                
             }else{
                $periodoMaestro = new \PeriodoMaestro();
                $codigo = $this->variables->codigoMaestro . $this->variables->numeroPeriodo;

                if ( !empty($this->variables->id ) ) {
                    $periodosMaestro = $this->getPeriodoMaestro( $periodoMaestro,$numerador );
                } else {
                    $periodosMaestro = $this->getPeriodoMaestro( $periodoMaestro, $numerador );
                    $verificarCodigoPeriodo = $this->validarDuplicado( $periodosMaestro );
                }

                $validarSecuencia = $this->validarSecuenciaPeriodo( $periodoMaestro );

                if ($validarSecuencia == "Invalido") {
                      $return["s"] = false;
                      $return["msj"] = "El número de período no respeta la secuencia";
                      return $return;
                } else {
                    if ($verificarCodigoPeriodo <> 0 && empty($this->variables->id)) {
                       $return["s"] = false;
                       $return["msj"] = "El período ya existe";
                       return $return;
                    } else {
                        $return = array("s"=>true,"msj"=>"Periodo guardado/actualizado correctamente");
                        return $return; 
                    }
                }
            }
        } else {
            $return["s"] = false;
            $return["msj"] = "El numero de periodo no es valido";
            return $return;
        }
    }

    /**
     * Valida que el periodo maestro respete la secuencia de creacion
     * @access private
     * @param \PeriodoMaestro $periodoMaestro Entidad de periodo maestro
     * @return string mensaje de validacion
     * @author Diego Fernando Rivera Castro<riveradiego@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    private function validarSecuenciaPeriodo(\PeriodoMaestro $periodoMaestro) {
        $numeroSecuencia = $this->variables->numeroPeriodo;
        if ($numeroSecuencia == 1) {
            return "Valido";
        } else {
            $numeroPeriodo = ($this->variables->numeroPeriodo) - 1;
            $codigo = $this->variables->codigoMaestro . $numeroPeriodo;
            $where = "codigo=" . $codigo;
            $validarPeriodo = $periodoMaestro->getList($where);
            $verificarCodigoPeriodo = sizeof($validarPeriodo);

            if ($verificarCodigoPeriodo == 1) {
                return "Valido";
            } else {
                return "Invalido";
            }
        }
    }
    
    /**
     * Retorna los un objeto de tipo \PeriodoMaestro seteado con los datos recibidos
     * desde el formulario de creación/edición
     * @access private
     * @param \PeriodoMaestro $periodoMaestro Entidad de periodo maestro en blanco
     * @param int $numerador Si existe, es el numero de periodos que se deben crear automaticamente en secuencia
     * @return string mensaje de validacion
     * @author Diego Fernando Rivera Castro<riveradiego@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    public function getPeriodoMaestro(\PeriodoMaestro $periodoMaestro, $numerador = null) {

        if ($numerador != null) {
            $codigo = $this->variables->codigoMaestro . $numerador;
            $numeroPerdiodo = $numerador;
        } else {
            $codigo = $this->variables->codigoMaestro . $this->variables->numeroPeriodo;
            $numeroPerdiodo = $this->variables->numeroPeriodo;
        }

        if (!empty($this->variables->id)) {
            $periodoMaestro->setId($this->variables->id);
            $periodoMaestro->setCodigoEstado($this->variables->estado);
            $periodoMaestro->setIdUsuarioModificacion(\Factory::getSessionVar("idusuario"));
            $periodoMaestro->setFechaModificacion(date("Y-m-d H:i:s"));
        } else {
            $periodoMaestro->setIdUsuarioModificacion(null);
            $periodoMaestro->setFechaModificacion(null);
            $periodoMaestro->setCodigoEstado(100);
        }
        $periodoMaestro->setCodigo($codigo);
        $periodoMaestro->setNombre($this->variables->nombre);
        $periodoMaestro->setNumeroPeriodo($numeroPerdiodo);
        $periodoMaestro->setIdAgno($this->variables->anio);
        $periodoMaestro->setIdUsuarioCreacion(\Factory::getSessionVar("idusuario"));
        $periodoMaestro->setFechaCreacion(date("Y-m-d"));

        return $periodoMaestro;
    }
    
    /**
     * Valida que el periodo maestro no se haya creado previamente
     * @access private
     * @param int $codigo Codigo del nuevo periodo
     * @param \PeriodoMaestro $periodoMaestro Entidad de periodo maestro
     * @return string mensaje de validacion
     * @author Diego Fernando Rivera Castro<riveradiego@unbosque.edu.co>
     * @since febrero 19, 2019
    */
    private function validarDuplicado(\PeriodoMaestro $periodoMaestro) {
        $where = "codigo=" . $periodoMaestro->getCodigo();
        $validarPeriodo = \PeriodoMaestro::getList($where);
        return $verificarCodigoPeriodo = sizeof($validarPeriodo);
    }
    
    private function actualizarPeriodosSincronizados(\PeriodoMaestro $periodoMaestro){
        $this->actualizarTablaPeriodo($periodoMaestro);
        $this->actualizarTablaSubperiodo($periodoMaestro);
        //ddd($periodoMaestro);
    }
}
