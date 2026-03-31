<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */
defined('_EXEC') or die;
class MainMenu implements Model{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function getVariables($variables){
        $array = array();
        $menuEstudiante = empty($variables->menuEstudiante)?false:$variables->menuEstudiante;
        //ddd($menuEstudiante);
        if($menuEstudiante===false){
            require_once (PATH_SITE.'/lib/ModMainMenuHelper.php');
            $array['menu'] = ModMainMenuHelper::getMenu($this->db);
        }else{
            require_once (PATH_SITE.'/entidad/MenuBoton.php');
            $usuario = Factory::getSessionVar("MM_Username");
            $codigo = Factory::getSessionVar("codigo");
            $query = "SELECT mb.idmenuboton "
                    . "FROM permisorolboton pb "
                    . "INNER JOIN menuboton mb ON (mb.idmenuboton = pb.idmenuboton) "
                    . "INNER JOIN usuariorol ur ON (ur.idrol = pb.idrol) "
                    . "INNER JOIN UsuarioTipo ut ON (ut.UsuarioTipoId = ur.idusuariotipo) "
                    . "INNER JOIN usuario u ON (u.idusuario = ut.UsuarioId) "
                    . "WHERE mb.codigoestadomenuboton = '01' "
                    . " AND mb.scriptmenuboton = ".$this->db->qstr('matriculaautomaticaordenmatricula.php')
                    . " AND u.usuario = ".$this->db->qstr($usuario)
                    . " AND ( SELECT codigocarrera FROM estudiante WHERE codigoestudiante = ".$this->db->qstr($codigo).") ";
            //ddd($query);
            $datos = $this->db->Execute($query);
            $data = $datos->GetArray();
            
            $items = array();
            foreach($data as $d){
                $items[] = $d["idmenuboton"]; 
            }
            $i = implode(",", $items);
            $array['menuEstudiante'] = MenuBoton::getList(" idmenuboton IN (".$i.") ");
            $array['valores'] = MainMenu::getLinkBotonValores();
            foreach($array['menuEstudiante'] as $r){
                $r->generarLinkAutomatico();
            }
        }
        /*require_once (PATH_SITE.'/modelo/Menu.php');
        $Modelo = new Menu($this->db);
        $array = $Modelo->getVariables($variables);  /**/
         
        return $array;
    }
    
    public static function getLinkBotonValores(){
        require_once(PATH_SITE."/entidad/Carrera.php");
        require_once(PATH_SITE."/modelo/Cohorte.php");
        require_once(PATH_SITE."/modelo/CalculoCreditosSemestre.php");
        $db = Factory::createDbo();
        
        $usarcondetalleprematricula = false;
        $usuarioeditar = "facultad";
        //d($_SESSION);
        $idCarrera = Factory::getSessionVar('idCarrera');
        $carreraEstudiante = Factory::getSessionVar('carreraEstudiante');
        if(!empty($carreraEstudiante)){
            $Carrera = clone $carreraEstudiante;
            //$Carrera->setDb();
        }else{
            $Carrera = new Carrera();
            $Carrera->setDb();
            $Carrera->setCodigocarrera($idCarrera);
            $Carrera->getByCodigo();
        }
        $codigomodalidadacademica = $Carrera->getCodigomodalidadacademica();
        unset($Carrera);
        //ddd($codigomodalidadacademica);
        
        $codigoperiodo = Factory::getSessionVar('codigoperiodosesion');
        $codigoestudiante = Factory::getSessionVar('codigo');
        $numerocohorte = Cohorte::getNumeroCohorte($codigoperiodo, $codigoestudiante);
        //dddd($numerocohorte);
        
        $materias = Servicios::getMateriasMatriculadas($codigoestudiante, $codigoperiodo);
        if(empty($materias)){
            $periodos = Servicios::getPeriodosEstudiante($codigoestudiante);
            if(!empty($periodos)){
                $codigoperiodo = $periodos[0]->getCodigoperiodo();
            }
        }
        $datosIniciales = self::getIniciales($codigoperiodo, $codigoestudiante, $numerocohorte);
        //ddd($datosIniciales);
        $row_iniciales = $datosIniciales['rowIniciales'];
        $totalRowIniciales = $datosIniciales['totalRowIniciales'];
        $existeinicial = $datosIniciales['existeinicial'];
        
        if(empty($totalRowIniciales)){
            $usarcondetalleprematricula = true;
        }
        $variables = new stdClass();
        $variables->codigomodalidadacademica = $codigomodalidadacademica;
        $variables->usarcondetalleprematricula = $usarcondetalleprematricula;
        $variables->totalRowIniciales = $totalRowIniciales;
        
        $CalculoCreditosSemestre = new CalculoCreditosSemestre();
        //$datos = $CalculoCreditosSemestre->getVariables($variables);
        
        if($row_iniciales['codigocarrera'] == ""){
            $valores['codigocarrera'] = $idCarrera;
            $valores['codigogenero'] = null;
        }else{
            $valores['codigocarrera'] = $row_iniciales['codigocarrera'];
            $valores['codigogenero'] = $row_iniciales['codigogenero'];
        }
        $valores['estudiante']=$codigoestudiante;

        // Documentaciï¿½n
        $codigoFacultad = Factory::getSessionVar('codigofacultad');
        $valores['facultad'] =  empty($codigoFacultad)?Factory::getSessionVar('idCarrera'):$codigoFacultad;

        // Documentaciï¿½n y Certificados
        $valores['codigo'] = $codigoestudiante;

        // Mensajes
        $valores['usuarioeditar'] = $usuarioeditar;
        $valores['creditoscalculados'] = @$creditoscalculados;

        // Horarios y Prematricula
        $valores['programausadopor'] = "estudiante";

        // Consultar Historico
        $valores['tipocertificado'] = "todo";
        $valores['periodos'] = "true";

        // Modificar Historico
        $valores['codigoestudiante'] = $codigoestudiante;

        // Boletin de Calificaciones
        $valores['busqueda_codigo'] = $codigoestudiante;

        // Editar Estudiante
        $valores['usuarioeditar'] = $usuarioeditar;
        $valores['codigocreado'] = $codigoestudiante;

        // Cerrar sesiï¿½n
        $valores['doLogout'] = "true";
        $valores['redir'] = "false";
        
        return($valores);
        
    }
    
    private static function getIniciales($codigoperiodo, $codigoestudiante, $numerocohorte, $case=0){
        $db = Factory::createDbo();
        
	$existeinicial = true;
        $baseSelect = "SELECT eg.codigogenero, c.codigocarrera, p.idprematricula, "
                . " c.nombrecarrera, e.codigoestudiante, "
                . " CONCAT(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) AS nombre, "
                . " e.semestre, g.nombregenero, e.codigotipoestudiante, eg.numerodocumento, "
                . " e.codigosituacioncarreraestudiante, e.codigocarrera, "
                . " eg.idestudiantegeneral, e.codigojornada ";
        
        $baseInner = "INNER JOIN estudiante e ON (p.codigoestudiante = e.codigoestudiante) "
                . "INNER JOIN carrera c ON (e.codigocarrera = c.codigocarrera) "
                . "INNER JOIN estudiantegeneral eg ON (e.idestudiantegeneral = eg.idestudiantegeneral ) "
                . "INNER JOIN genero g ON (g.codigogenero=eg.codigogenero) ";
        
        $baseWhere = " p.codigoperiodo = ".$db->qstr($codigoperiodo)." "
                . " AND (p.codigoestadoprematricula LIKE '4%' OR p.codigoestadoprematricula LIKE '1%') "
                . " AND e.codigoestudiante = ".$db->qstr($codigoestudiante)." ";
        
        if($case==1){
            $baseSelect .= " , det.valordetallecohorte ";
            $baseInner .= "INNER JOIN detallecohorte det ON (det.semestredetallecohorte = p.semestreprematricula) "
                . "INNER JOIN cohorte coh ON (coh.codigocarrera = c.codigocarrera AND coh.codigoperiodo = p.codigoperiodo AND coh.idcohorte = det.idcohorte AND coh.codigojornada = e.codigojornada) ";
            $baseWhere .= " AND coh.numerocohorte = ".$db->qstr($numerocohorte)."  ";
        }
        
        if($case==1){
            $baseSelect .= " , ve.preciovaloreducacioncontinuada AS valordetallecohorte ";
            $baseInner .= "INNER JOIN valoreducacioncontinuada ve ON (ve.codigocarrera = e.codigocarrera ) ";
            $baseWhere .= " AND ve.fechafinalvaloreducacioncontinuada > ".$db->qstr(date("Y-m-d"))." ";
        }
        if($case<2){
            $baseSelect .= " , p.semestreprematricula ";
        }else{
            $existeinicial = false;
            $baseSelect .= " , IF(p.semestreprematricula='' OR p.semestreprematricula IS NULL, e.semestre, p.semestreprematricula) as semestreprematricula, det.valordetallecohorte ";
            $baseInner .= "INNER JOIN cohorte coh ON (coh.codigocarrera = c.codigocarrera AND coh.codigoperiodo = p.codigoperiodo AND coh.codigojornada = e.codigojornada) "
                    . "INNER JOIN detallecohorte det ON (coh.idcohorte = det.idcohorte AND (det.semestredetallecohorte = p.semestreprematricula OR det.semestredetallecohorte = e.semestre )) ";
            $baseWhere .= " AND coh.numerocohorte = ".$db->qstr($numerocohorte)." ";
        }
        $query = $baseSelect
                . "FROM prematricula p "
                . $baseInner
                . "WHERE "
                . $baseWhere;
        //d($query);
        $datos = $db->Execute($query);
        $totalRowsIniciales = $datos->NumRows(); 
	$row = $datos->FetchRow();
        
        if($totalRowsIniciales == "" && $case<2){
            return self::getIniciales($codigoperiodo, $codigoestudiante, $numerocohorte, ($case+1));
        }
        
        return array("rowIniciales"=>$row, "totalRowIniciales" => $totalRowsIniciales, "existeinicial" => $existeinicial, "query" => $query);
    }
    
    public static function getLinkMenuBoton($menu, $valores){
        //d($menu);
        $arrayVariables = array();
        $VariablesMenuBoton = $menu->getVariablesmenuboton();
        
        if(!empty($VariablesMenuBoton)){
            $variables = explode(",", $VariablesMenuBoton);
            foreach($variables as $key => $value){
                    $arrayVariables[] = $value."=".$valores[$value];
            }
        }
        
        $cadenaVariables = implode("&", $arrayVariables);
        
	$cadenaVariables = ereg_replace("&$","",$cadenaVariables);
        
        //ddd($cadenaVariables);
        $return = $menu->getLinkAbsoluto().(!empty($cadenaVariables)?("?".$cadenaVariables):"");
        
        return $return;
    }
    
}
