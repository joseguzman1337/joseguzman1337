<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */
defined('_EXEC') or die;
class ControlDashBoard{ 
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type stdObject
     * @access private
     */
    private $variables;
    
    public function __construct($variables) {
        $this->db = Factory::createDbo();
        $this->variables = $variables; 
    }
    
    public function seleccionarCarreraEstudiante(){
        
        $query = "SELECT distinct c.nombrecarrera, c.codigocarrera, eg.apellidosestudiantegeneral,
            eg.nombresestudiantegeneral, d.nombredocumento, d.tipodocumento,e.codigoestudiante,
            eg.numerodocumento, eg.fechanacimientoestudiantegeneral,eg.expedidodocumento,
            eg.idestudiantegeneral,gr.nombregenero,p.codigoperiodo, p.codigoestadoperiodo,
            eg.celularestudiantegeneral,eg.emailestudiantegeneral, eg.codigogenero,s.nombresituacioncarreraestudiante,
            eg.direccionresidenciaestudiantegeneral, eg.telefonoresidenciaestudiantegeneral,eg.ciudadresidenciaestudiantegeneral,
            eg.direccioncorrespondenciaestudiantegeneral, eg.telefonocorrespondenciaestudiantegeneral,eg.ciudadcorrespondenciaestudiantegeneral,e.codigocarrera
            FROM estudiante e
            INNER JOIN estudiantegeneral eg ON (e.idestudiantegeneral = eg.idestudiantegeneral)
            INNER JOIN estudiantedocumento ed ON (e.idestudiantegeneral = ed.idestudiantegeneral AND ed.idestudiantegeneral = eg.idestudiantegeneral)
            INNER JOIN carrera c ON (e.codigocarrera = c.codigocarrera)
            INNER JOIN documento d ON (eg.tipodocumento = d.tipodocumento)
            INNER JOIN situacioncarreraestudiante s ON (e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante)
            INNER JOIN genero gr ON (gr.codigogenero = eg.codigogenero)
            INNER JOIN carreraperiodo cp ON (cp.codigocarrera = c.codigocarrera)
            INNER JOIN periodo p ON (p.codigoperiodo = cp.codigoperiodo)
            WHERE e.codigoestudiante = '".$this->variables->codigoestudiante."'
                AND p.codigoestadoperiodo = '1' 
            ORDER BY e.codigosituacioncarreraestudiante desc";
        
        $datos = $this->db->Execute($query);
        $d = $datos->FetchRow();
        if(!empty($d)){
            Factory::setSessionVar('idCarrera', $d['codigocarrera']);
            //ddd($d);
        }
        
        Factory::setSessionVar('codigo', $this->variables->codigoestudiante);
        //Factory::setSessionVar('codigoperiodosesion', $this->variables->codigoperiodo);
        echo json_encode(array("s"=>true, "mensaje" => "Carrera seleccionada"));
        exit();
    }
    
}