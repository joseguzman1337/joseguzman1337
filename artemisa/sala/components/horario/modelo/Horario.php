<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */
defined('_EXEC') or die;
class Horario implements Model{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    private $queryBase = 'SELECT m.nombremateria,
                CONCAT( dc.nombredocente, " ", dc.apellidodocente ) AS DocenteName, 
                x.nombredia,
                IF ( a.HoraInicio IS NULL, h.horainicial, a.HoraInicio ) AS HoraInicio,
                IF ( a.HoraFin IS NULL, h.horafinal, a.HoraFin ) AS HoraFin,
                IF ( c.Nombre IS NULL, "Falta Por Asignar", c.Nombre ) AS Nombre,
                cc.Nombre AS Bloke, ccc.Nombre AS Campus, g.numerodocumento AS numDocente
            FROM prematricula p
            INNER JOIN detalleprematricula d ON (d.idprematricula = p.idprematricula )
            INNER JOIN estadodetalleprematricula edp ON (edp.codigoestadodetalleprematricula = d.codigoestadodetalleprematricula )
            INNER JOIN grupo g ON (g.idgrupo = d.idgrupo)
            INNER JOIN materia m ON (m.codigomateria = g.codigomateria)
            INNER JOIN estudiante e ON (e.codigoestudiante = p.codigoestudiante)
            INNER JOIN estudiantegeneral eg ON (eg.idestudiantegeneral = e.idestudiantegeneral)
            INNER JOIN docente dc ON (dc.numerodocumento = g.numerodocumento)
            LEFT JOIN horario h ON (h.idgrupo = d.idgrupo )
            LEFT JOIN dia x ON (x.codigodia = h.codigodia )
            LEFT JOIN SolicitudEspacioGrupos sg ON (sg.idgrupo = d.idgrupo)
            LEFT JOIN AsignacionEspacios a ON (a.SolicitudAsignacionEspacioId = sg.SolicitudAsignacionEspacioId AND a.codigoestado=100 )
            LEFT JOIN SolicitudAsignacionEspacios s ON (s.SolicitudAsignacionEspacioId = sg.SolicitudAsignacionEspacioId AND s.codigodia = h.codigodia )
            LEFT JOIN ClasificacionEspacios c ON (c.ClasificacionEspaciosId = a.ClasificacionEspaciosId)
            LEFT JOIN ClasificacionEspacios cc ON (cc.ClasificacionEspaciosId = c.ClasificacionEspacionPadreId)
            LEFT JOIN ClasificacionEspacios ccc ON (ccc.ClasificacionEspaciosId = cc.ClasificacionEspacionPadreId)/**/
            WHERE p.codigoestadoprematricula IN (40, 41)
                AND d.codigoestadodetalleprematricula = 30
                AND ( a.EstadoAsignacionEspacio = 1 OR a.EstadoAsignacionEspacio IS NULL )
                AND ( a.codigoestado = 100 OR a.codigoestado IS NULL )
                AND ( s.codigodia = h.codigodia OR a.FechaAsignacion IS NULL OR h.codigodia IS NULL )
                AND ( s.codigoestado = 100 OR s.codigoestado IS NULL )
                AND ( sg.codigoestado = 100 OR sg.codigoestado IS NULL ) ';


    public function __construct($db) {
        $this->db = $db;
    }
    
    public function getVariables($variables){
        $array = array();
        //d($_SESSION);
        $periodo = Factory::getSessionVar('codigoperiodosesion');
        if(!empty($variables->tipo)){
            $query = $this->queryBase.' AND p.codigoperiodo = "'.$periodo.'"
                    AND x.codigodia = "'.$variables->diaDeLaSemana.'" 
                    AND ( a.FechaAsignacion BETWEEN "'.$variables->FechaFutura_1.'" AND "'.$variables->FechaFutura_2.'" OR a.FechaAsignacion IS NULL) ';

            if($variables->tipo == "estudiante"){
                $codigoEstudiante = Factory::getSessionVar('codigo'); 
                $query .= ' AND e.codigoestudiante = "'.$codigoEstudiante.'"
                    AND eg.numerodocumento = "'.$variables->Usuario->getNumerodocumento().'" ';
                /*
                 * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
                 * Se Cambia la d minuscula por la D mayuscula para que solo muestre materias asociadas al docente
                 * @since Agosto 23, 2018
                 */ 
            }elseif($variables->tipo == "Docente"){
                $query .= ' AND g.numerodocumento = "'.$variables->Usuario->getNumerodocumento().'" ';
            }

            $query .= ' GROUP BY d.idgrupo,m.codigomateria,  x.codigodia, HoraInicio, HoraFin, a.FechaAsignacion
                ORDER BY a.HoraInicio ASC, a.HoraFin ASC ';
            //d($query);
            $datos = $this->db->Execute($query);

            $data = $datos->GetArray();

            if(!empty($data)){
                usort($data, array($this, 'cmp')); 
            }
            $fecha = Factory::printDateString(date("j"), date("n")-1, null, date("N")-1);
            //ddd($fecha);
            $array = array("datos"=>$data, "fecha"=>$fecha);
        }
        return $array;
    }
    
    function cmp($a, $b){
        return strcmp($a["HoraInicio"], $b["HoraInicio"]);
    }
}