<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */
defined('_EXEC') or die;
class CalculoCreditosSemestre implements Model{
    /**
     * @type adodb Object
     * @access private
     */
    private $db; 
    
    public function __construct(){
        $this->db = Factory::createDbo();
    }
    
    public function getVariables($variables){
        $totalRowIniciales = $variables->totalRowIniciales;
        $usarcondetalleprematricula = $variables->usarcondetalleprematricula;
        $codigomodalidadacademica = $variables->codigomodalidadacademica;
        
        $codigoperiodo = Factory::getSessionVar('codigoperiodosesion');
        $codigoestudiante = Factory::getSessionVar('codigo');
        $cursosvacacionalessesion = Factory::getSessionVar('cursosvacacionalessesion');
        //$materiaselegidas = array();
        
        // Primero seleccionamos los datos de la prematricula
        // Datos de la primera prematricula hecha

        // Este script recibe los siguientes parametros:
        // $codigoperiodo, $codigoestudiante y $usarcondetalleprematricula (True para hacerlo con lo que hay en prematricula, False para hacerlo con otro arreglo)
        $cuentaelectivas = 0;
        d($usarcondetalleprematricula);
        
        if($usarcondetalleprematricula){
            // Si no es colegio entra al if
            if($codigomodalidadacademica != 100){
                if(!isset($cursosvacacionalessesion)){                    
                    // De este query quito las ordenes de curso de esducacion continuada
                    $query_premainicial1 = "SELECT d.codigomateria, d.codigomateriaelectiva "
                            . "FROM detalleprematricula d "
                            . "INNER JOIN prematricula p ON (d.idprematricula = p.idprematricula) "
                            . "INNER JOIN materia m ON (d.codigomateria = m.codigomateria) "
                            . "INNER JOIN estudiante e ON (p.codigoestudiante = e.codigoestudiante) "
                            . "WHERE e.codigoestudiante = ".$this->db->qstr($codigoestudiante)
                            . " AND (p.codigoestadoprematricula LIKE '4%' OR p.codigoestadoprematricula LIKE '1%') "
                            . " AND (d.codigoestadodetalleprematricula LIKE '3%' OR d.codigoestadodetalleprematricula LIKE '1%' OR d.codigoestadodetalleprematricula = '23') "
                            . " AND p.codigoperiodo = ".$this->db->qstr($codigoperiodo)
                            . " AND d.codigomateria <> ALL( "
                            . "  SELECT d.codigomateria "
                            . "  FROM detalleprematricula d "
                            . "  INNER JOIN prematricula p ON (d.idprematricula = p.idprematricula) "
                            . "  INNER JOIN materia m ON (d.codigomateria = m.codigomateria) "
                            . "  INNER JOIN estudiante e ON (p.codigoestudiante = e.codigoestudiante) "
                            . "  INNER JOIN detalleordenpago do ON (d.numeroordenpago = do.numeroordenpago) "
                            . "  INNER JOIN concepto c ON (do.codigoconcepto = c.codigoconcepto) "
                            . "  WHERE e.codigoestudiante = ".$this->db->qstr($codigoestudiante)
                            . "   AND (p.codigoestadoprematricula LIKE '4%' OR p.codigoestadoprematricula LIKE '1%') "
                            . "   AND (d.codigoestadodetalleprematricula LIKE '3%' OR d.codigoestadodetalleprematricula LIKE '1%' OR d.codigoestadodetalleprematricula = '23') "
                            . "   AND p.codigoperiodo = ".$this->db->qstr($codigoperiodo)
                            . "   AND c.codigoindicadoraplicacobrocreditosacademicos LIKE '1%'" 
                            . " )";
                }else{
                    $query_premainicial1 = "SELECT d.codigomateria, d.codigomateriaelectiva "
                            . "FROM detalleprematricula d "
                            . "INNER JOIN prematricula p ON (d.idprematricula = p.idprematricula) "
                            . "INNER JOIN materia m ON (d.codigomateria = m.codigomateria) "
                            . "INNER JOIN estudiante e ON (p.codigoestudiante = e.codigoestudiante) "
                            . "where e.codigoestudiante = ".$this->db->qstr($codigoestudiante)
                            . " AND (p.codigoestadoprematricula LIKE '4%' OR p.codigoestadoprematricula LIKE '1%') "
                            . " AND (d.codigoestadodetalleprematricula LIKE '3%' OR d.codigoestadodetalleprematricula LIKE '1%' OR d.codigoestadodetalleprematricula = '23') "
                            . " AND p.codigoperiodo = ".$this->db->qstr($codigoperiodo);
                                //echo "$query_premainicial1<br>";
                }
            }else{
                $query_premainicial1 = "SELECT d.codigomateria, d.codigomateriaelectiva "
                        . "FROM detalleprematricula d "
                        . "INNER JOIN prematricula p ON (d.idprematricula = p.idprematricula) "
                        . "INNER JOIN materia m ON (d.codigomateria = m.codigomateria) "
                        . "INNER JOIN estudiante e ON (p.codigoestudiante = e.codigoestudiante) "
                        . "where e.codigoestudiante = ".$this->db->qstr($codigoestudiante)
                        . " AND (p.codigoestadoprematricula LIKE '4%' OR p.codigoestadoprematricula LIKE '1%') "
                        . " AND (d.codigoestadodetalleprematricula LIKE '3%' OR d.codigoestadodetalleprematricula LIKE '1%' OR d.codigoestadodetalleprematricula = '23') "
                        . " AND p.codigoperiodo = ".$this->db->qstr($codigoperiodo);
            }
            
            $premainicial1 = $this->db->Execute($query_premainicial1);
            $totalRows_premainicial1 = $premainicial1->NumRows();
            
            while($row_premainicial1 = $premainicial1->FetchRow()){
                if($row_premainicial1['codigomateriaelectiva'] == ""){
                    $materiaselegidas[] = $row_premainicial1['codigomateria'];
                }else{
                    if(!isset($materiaselegidas[$row_premainicial1['codigomateriaelectiva']])){
                        $materiaselegidas[$row_premainicial1['codigomateriaelectiva']] = $row_premainicial1['codigomateria'];
                    }else{
                        $cuentaelectivas++;
                        $materiaselegidas[$row_premainicial1['codigomateriaelectiva']."elect$cuentaelectivas"] = $row_premainicial1['codigomateria'];
                    }
                }
            } 
        }
        
        // Toma del plan de estudios los datos de las materias
        // Este arreglo sirve para guardar el semestre que mas se repite
        // Tomo el maximo numero de semestres del plan de estudio
        //echo "$query_premainicial1<br>";
        $query = "SELECT MAX(cantidadsemestresplanestudio*1) AS semestre "
                . "FROM planestudio";
        $datos = $this->db->Execute($query);
        $totalRows_semestreplanes = $datos->NumRows();
        $row_semestreplanes = $datos->FetchRow();
        $semestre = array();
        for($semestreini = 1; $semestreini <= $row_semestreplanes['semestre']; $semestreini++){
            $semestre[$semestreini] = 0;
        }
        d($semestre);
        //$numerocreditoselectivas = 0;
        $creditos = 0;
        $creditosjornadaestudiante = 0;
        $creditoscalculados = 0;
        // En materiaselegidas debo guardar todo lo que halla sido insertado en detalleprematricula
        d($materiaselegidas);
        
        if(isset($materiaselegidas)){
            $semestreMatriculado = $this->calcularCreditosxSemestreMateriasMatriculadas($codigoperiodo,$codigoestudiante);
            
            foreach($materiaselegidas as $codigomateriaelectiva2 => $codigomateria2){
                if(ereg($codigomateriaelectiva2,"^[0-9]{1,7}elect[0-9]+$")){
                    ereg($codigomateriaelectiva2,"^[0-9]{1,7}",$registers);
                    $codigmateriaelectiva2 = $registers[0];
                }
                
                $codigomateriaelectiva2=str_replace("grupo","",$codigomateriaelectiva2);
                $eselectivalibre = false;
                $eselectivatecnica = false;
                // Primero calcula el numero de creditos mirando en la carga con el plan de estudios que tenga seleccionado

                // Toma todas las materias del plan de estudios, si no esta aca la materia es por que es una electiva tecnica(enfasis) o libre
                
                $query_datosmateriaselegidas = "SELECT m.nombremateria, m.codigomateria, dpe.semestredetalleplanestudio, dpe.numerocreditosdetalleplanestudio as numerocreditos "
                        . "FROM materia m "
                        . "INNER JOIN detalleplanestudio dpe ON (m.codigomateria = dpe.codigomateria) "
                        . "INNER JOIN planestudioestudiante peeON (pee.idplanestudio = dpe.idplanestudio) "
                        . "WHERE m.codigomateria = ".$this->db->qstr($codigomateria2) 
                        . " AND pee.codigoestudiante = ".$this->db->qstr($codigoestudiante)
                        . " AND pee.codigoestadoplanestudioestudiante LIKE '1%'";
                
                $datosmateriaselegidas = $this->db->Execute($query_datosmateriaselegidas);
                $totalRows_datosmateriaselegidas = $datosmateriaselegidas->NumRows();
                if(empty($totalRows_datosmateriaselegidas)){
                    // Toma los datos de la materia si es enfasis
                    $query_datosmateriaselegidas = "SELECT m.nombremateria, m.codigomateria, "
                            . " dle.semestredetallelineaenfasisplanestudio AS semestredetalleplanestudio, "
                            . " dle.numerocreditosdetallelineaenfasisplanestudio AS numerocreditos "
                            . "FROM materia m "
                            . "INNER JOIN detallelineaenfasisplanestudio dle ON (m.codigomateria = dle.codigomateriadetallelineaenfasisplanestudio) "
                            . "INNER JOIN lineaenfasisestudiante lee ON (lee.idplanestudio = dle.idplanestudio AND lee.idlineaenfasisplanestudio = dle.idlineaenfasisplanestudio) "
                            . "WHERE m.codigomateria = ".$this->db->qstr($codigomateria2) 
                            . " AND lee.codigoestudiante = ".$this->db->qstr($codigoestudiante) 
                            . " AND dle.codigoestadodetallelineaenfasisplanestudio LIKE '1%' "
                            . " AND (NOW() BETWEEN lee.fechainiciolineaenfasisestudiante AND lee.fechavencimientolineaenfasisestudiante)";
                    // Otro query para selecciona los datos de las materias cuando el anterior es vacio para las demás materias
                    // Tanto enfasis como electivas libres
                    
                    $datosmateriaselegidas = $this->db->Execute($query_datosmateriaselegidas);
                    $totalRows_datosmateriaselegidas = $datosmateriaselegidas->NumRows();
                    // Si se trata de una electiva
                }
                
                if($totalRows_datosmateriaselegidas == ""){
                    // Mira si tiene papa, si el papa es electiva libre (posee idgrupolinea == 100) toma los creditos directamente del hijo
                    // Si es tecnica toma los creditos directamente del papa
                    // Si no tiene papa toma los datos como si fuera una materia externa
                    $query_datosmateriapapa = "SELECT m.nombremateria, m.codigomateria, dpe.semestredetalleplanestudio, "
                            . " dpe.numerocreditosdetalleplanestudio as numerocreditos, dpe.codigotipomateria, gm.codigotipogrupomateria "
                            . "FROM grupomaterialinea gml "
                            . "INNER JOIN materia m ON (gml.codigomateria = m.codigomateria) "
                            . "INNER JOIN grupomateria gm ON (gml.idgrupomateria = gm.idgrupomateria AND gm.codigoperiodo = gml.codigoperiodo AND gml.codigoperiodo = gm.codigoperiodo) "
                            . "INNER JOIN detalleplanestudio dpe ON (dpe.codigomateria = m.codigomateria) "
                            . "INNER JOIN planestudioestudiante pee ON (pee.idplanestudio = dpe.idplanestudio) "
                            . "WHERE gm.codigoperiodo = ".$this->db->qstr($codigoperiodo)
                            . " AND gml.codigomateria = ".$this->db->qstr($codigomateriaelectiva2)
                            . " AND pee.codigoestudiante = ".$this->db->qstr($codigoestudiante)
                            . " AND pee.codigoestadoplanestudioestudiante LIKE '1%' "
                            . "ORDER BY m.nombremateria";
                    
                    $datosmateriapapa = $this->db->Execute($query_datosmateriapapa);
                    $totalRows_datosmateriapapa = $datosmateriapapa->FetchRow();
                    
                    if( empty($totalRows_datosmateriapapa) ){
                        // Mira si se trata de una materia electiva
                        $query_datosmateriapapa = "SELECT m.nombremateria, m.codigomateria, dpe.semestredetalleplanestudio, "
                                . " dpe.numerocreditosdetalleplanestudio as numerocreditos, dpe.codigotipomateria, m.codigoindicadorgrupomateria "
                                . "FROM materia m "
                                . "INNER JOIN detalleplanestudio dpe ON (dpe.codigomateria = m.codigomateria) "
                                . "INNER JOIN planestudioestudiante pee ON (pee.idplanestudio = dpe.idplanestudio) "
                                . "where m.codigomateria = ".$this->db->qstr($codigomateriaelectiva2)
                                . " AND pee.codigoestudiante = ".$this->db->qstr($codigoestudiante)
                                . " AND pee.codigoestadoplanestudioestudiante LIKE '1%' "
                                . "ORDER BY m.nombremateria";
                        
                        $datosmateriapapa = $this->db->Execute($query_datosmateriapapa);
                        $totalRows_datosmateriapapa = $datosmateriapapa->NumRows();
                        $row_datosmateriapapa = $datosmateriapapa->FetchRow();
                        
                        if($row_datosmateriapapa['codigotipomateria'] == '4' && $row_datosmateriapapa['codigoindicadorgrupomateria'] == "200"){
                            // La materia es electiva
                            // Materia electiva libre
                            // Si entra es por que la materia hija es libre y debe tomar el numero de creditos de ella 
                            $query_datosmateriaselegidas = "SELECT m.nombremateria, m.codigomateria, m.numerocreditos "
                                    . "FROM materia m "
                                    . "WHERE m.codigomateria = ".$this->db->qstr($codigomateria2)
                                    . " AND m.codigoestadomateria = '01'";
                            
                            $datosmateriaselegidas = $this->db->Execute($query_datosmateriaselegidas);
                            $totalRows_datosmateriaselegidas = $datosmateriaselegidas->NumRows();
                            $eselectivalibre = true;
                        }else{
                            // En el caso de haber hecho la prematricula y de tratarse de una materia externa en carga academica se
                            // Actualmente todos los planes de estudio tiene el mismo numero de creditos para una materia
                            // Toca empezar a guardar el plan de estudio de la materia externa en cargaacademica y de este tomar el semestre y
                            // y los creditos de la materia y efectuar el conteo de creditos a partir de aca.
                            // Debido a que esto no se hiso  para el semestre 20052 toca dejar el codigo siguiente.
                            $query_datosmateriaselegidas = "SELECT m.nombremateria, m.codigomateria, d.semestredetalleplanestudio, "
                                    . " d.numerocreditosdetalleplanestudio as numerocreditos, d.codigotipomateria "
                                    . "FROM materia m "
                                    . "INNER JOIN cargaacademica c ON (c.codigomateria = m.codigomateria) "
                                    . "INNER JOIN detalleplanestudio d ON (c.codigomateria = d.codigomateria AND c.idplanestudio = d.idplanestudio) "
                                    . "WHERE m.codigomateria = ".$this->db->qstr($codigomateria2)." "
                                    . " AND c.codigoestudiante = ".$this->db->qstr($codigoestudiante)." "
                                    . " AND m.codigoestadomateria = '01' "
                                    . " AND d.codigoestadodetalleplanestudio like '1%' "
                                    . " AND c.codigoestadocargaacademica like '1%'";
                            
                            $datosmateriaselegidas = $this->db->Execute($query_datosmateriaselegidas);
                            //echo "$query_datosmateriaselegidas<br>";
                            $totalRows_datosmateriaselegidas = $datosmateriaselegidas->NumRows();
                            // Este codigo sirve para le periodo 20052
                            // Después de este periodo quitarlo, el problema es que no esta colocando el semestre que es, este lo coloca si es del plan de estudios
                            // cualquiera
                        }
                        
                        if($totalRows_datosmateriaselegidas == ""){
                            $query_datosmateriaselegidas = "select m.nombremateria, m.codigomateria, "
                                    . "m.numerocreditos, d.semestredetalleplanestudio "
                                    . "from materia m, detalleplanestudio d "
                                    . "where m.codigomateria = ".$this->db->qstr($codigomateria2)." "
                                    . "and m.codigoestadomateria = '01' "
                                    . "and d.codigomateria = m.codigomateria";
                            
                            $datosmateriaselegidas = $this->db->Execute($query_datosmateriaselegidas);
                            $totalRows_datosmateriaselegidas = $datosmateriaselegidas->NumRows();
                        }else{
                            /*Se declara una variable o bandera que indica que es una materia externa que tiene plan de estudio para que mas abajo no tenga en cuenta esta materia y no recalcule el semestre con esta materia*/
                            $esmateriaexternaconplan=true;
                        }
                        
                        // Este lo coloca si no pertenece a ningun plan de estudios, esta colocando el 1 por defecto.
                        if( empty($totalRows_datosmateriaselegidas) ){
                            /*
                            Cuando se ha agregado como materia externa y no corresponde al plan de estudios se selecciona la informacion de la materia, en esta parte del codigo lo que se hizo
                            fue agregar la validacion que mira si el tipo de materia es electiva libre con el fin de no cobrarla ya q se estaba generando cobro de creditos por materias de este tipo.
                            Se hace la validacion y se crea la variable $numcreditoelectiva que acumula los creditos de electivas libres.
                            Esta modificacion o ajuste se realizo el dia agosto 14 de 2013
                            */
                            
                            $query_datosmateriaselegidas = "SELECT m.nombremateria, m.codigomateria, m.numerocreditos, "
                                    . " 1 as semestredetalleplanestudio, m.codigotipomateria "
                                    . "FROM materia m "
                                    . "WHERE m.codigomateria = ".$this->db->qstr($codigomateria2)." "
                                    . " AND m.codigoestadomateria = '01'";
                            
                            $datosmateriaselegidas = $this->db->Execute($query_datosmateriaselegidas);
                            $totalRows_datosmateriaselegidas = $datosmateriaselegidas->NumRows();
                            $row_datosmateriaselegidas = $datosmateriaselegidas->FetchRow();
                            
                            if($row_datosmateriaselegidas['codigotipomateria'] == '4'){
                                $query_datosmateriaselegidas = "SELECT m.nombremateria, m.codigomateria, m.numerocreditos "
                                        . "FROM materia m "
                                        . "WHERE m.codigomateria = ".$this->db->qstr($codigomateria2)." "
                                        . " AND m.codigoestadomateria = '01'";
                            
                                $datosmateriaselegidas = $this->db->Execute($query_datosmateriaselegidas);
                                $totalRows_datosmateriaselegidas = $datosmateriaselegidas->NumRows();
                                
                                $numcreditoelectiva=$numcreditoelectiva+$row_datosmateriaselegidas['numerocreditos'];
                            }else{
                                $query_datosmateriaselegidas = "SELECT m.nombremateria, m.codigomateria, m.numerocreditos "
                                        . "FROM materia m "
                                        . "WHERE m.codigomateria = ".$this->db->qstr($codigomateria2)." "
                                        . " AND m.codigoestadomateria = '01'";
                            
                                $datosmateriaselegidas = $this->db->Execute($query_datosmateriaselegidas);
                                $totalRows_datosmateriaselegidas = $datosmateriaselegidas->NumRows();
                            }
                        }
                    }else{
                        // Si entra aca quiere decir que la materia tiene hijos.
                        //echo "$totalRows_datosmateriapapa uno <br> $query_datosmateriapapa<br>";
                        
                        $row_datosmateriapapa = mysql_fetch_array($datosmateriapapa);
                        
                        // Se hizo pro si coloco alguna materia libre en grupomaterialinea
                        if($row_datosmateriapapa['codigotipogrupomateria'] == "100"){
                            // Materia electiva libre
                            // Si entra es por que la materia hija es libre y debe tomar el numero de creditos de ella
                            $query_datosmateriaselegidas = "SELECT m.nombremateria, m.codigomateria, m.numerocreditos "
                                    . "FROM materia m "
                                    . "WHERE m.codigomateria = ".$this->db->qstr($codigomateria2)." "
                                    . " AND m.codigoestadomateria = '01'";
                            
                            $datosmateriaselegidas = $this->db->Execute($query_datosmateriaselegidas);
                            $totalRows_datosmateriaselegidas = $datosmateriaselegidas->NumRows();
                            $eselectivalibre = true;
                            
                        }elseif($row_datosmateriapapa['codigotipogrupomateria'] == "200"){
                            // Materia electiva tecnica
                            // Si entra aca es por que la materia debe tomar el numero de creditos del papa
                            $query_datosmateriaselegidas = "SELECT m.nombremateria, m.codigomateria, m.numerocreditos "
                                    . "FROM materia m "
                                    . "WHERE m.codigomateria = ".$this->db->qstr($codigomateria2)." "
                                    . " AND m.codigoestadomateria = '01'";
                            
                            $datosmateriaselegidas = $this->db->Execute($query_datosmateriaselegidas);
                            $totalRows_datosmateriaselegidas = $datosmateriaselegidas->NumRows();
                            $creditospapa = $row_datosmateriapapa['numerocreditos'];
                            $eselectivatecnica = true;
                        }
                    }
                }
                
                if(empty($totalRows_datosmateriaselegidas)){
                    $row_datosmateriaselegidas = $datosmateriaselegidas->FetchRow();
                    $codigotipomateria = $row_datosmateriaselegidas['codigotipomateria'];
                    $codigomateria = $row_datosmateriaselegidas['codigomateria'];
                    
                    if( $eselectivatecnica ){
                        $creditosmateria = $creditospapa;
                    }else{
                        $creditosmateria = $row_datosmateriaselegidas['numerocreditos'];
                    }

                    // Obligatoria y lineas de enfasis
                    if(!$eselectivalibre){
                        $creditos = $creditos + $creditosmateria;
                        if($this->estagrupo_jornada($codigomateria2, $codigoestudiante, $codigoperiodo)){
                            $creditosjornadaestudiante = $creditosjornadaestudiante + $creditosmateria;
                        }
                        
                        // Guardo la materiahija y le asigno el papa
                        $materia[$codigomateriaelectiva2] = $codigomateria2;
                        
                        if(!$esmateriaexternaconplan){
                            if($row_datosmateriaselegidas['semestredetalleplanestudio'] == "externa"){
                                $semestre[$_GET['semestrerep']] = $semestre[$_GET['semestrerep']] + $creditosmateria;
                            }else{
                                if($row_datosmateriaselegidas['semestredetalleplanestudio'] == ""){
                                    $semestre[$row_datosmateriapapa['semestredetalleplanestudio']] = $semestre[$row_datosmateriapapa['semestredetalleplanestudio']] + $creditosmateria;
                                }else{
                                    $semestre[$row_datosmateriaselegidas['semestredetalleplanestudio']] = $semestre[$row_datosmateriaselegidas['semestredetalleplanestudio']] + $creditosmateria;
                                }
                            }
                        }else{
                            $semestre[$row_datosmateriaselegidas['semestredetalleplanestudio']] = $semestre[$row_datosmateriaselegidas['semestredetalleplanestudio']] + $creditosmateria;
                        }
                    }else{
                        // Electivas libres
                        // Toma la electiva libre que va a ver el chino
                        // Los creditos de las electivas no se suman ya que el estudiante puede tomarlos en cualquier momento
                        // de la carrera, debido a que no tienen ningún tipo de referencia
                        
                        $materia[] = $codigomateria2;
                        // Las electivas libres no afectan el semestre
                    }
                }
            }
        }else{
            $semestre[1] = 1;
        }
        /*Esta parte del codigo se agrega para que el calculo de creditos de electivas no afecte la ubicacion semestral del estudiante
        se verifica q en el arreglo de semestre haya un registro vacio q tiene los creditos de electivas
        luego se busca cual es el semestre que tiene la mayor cantidad de creditos y se añaden los creditos de electivas
        con el fin de dejar los creditos en el semestre con mayor cantidad de creditos seleccionados
        el ajuste se realizo el día 5 y 6 de febrero de 2014*/
        if(isset($semestre[''])){
            if($semestre[''] !=0 || $semestre[''] !=""){
                $semestreTemp = $semestre;
                $semestreTemp[""] = 0;
                $maximocreditos=max($semestreTemp);
                $buscarindice=array_search($maximocreditos, $semestreTemp);
                $semestre[$buscarindice]=$semestre[$buscarindice]+$semestre[''];
            }
        }
        
        /***** Total de creditos *******/
        d("El numero de creditos es : $creditos");

        /***** Retorna el (los) semestre(s) con el valor máximo de creditos *****/
        //print_r($semestre);
        @$maxcreditos = max($semestre);
        //var_dump(max($semestre));
        //var_dump($maxcreditos); echo "<br/><br/>";
        //echo "El máximo número de creditos en un semestre es $maxcreditos<br>";

        /************** Semestre real del alumno ********************/
        // Coloca los semestre con mayor número de creditos en una matriz, tomandolos del primero al decimo
        @$res_sem = array_keys ($semestre, $maxcreditos);
        //var_dump($semestre);
        //var_dump($maxcreditos);
        //var_dump(array_keys ($semestre, $maxcreditos));
        // Tooma el semestre de la primera posicion indicando que es el priemer semestre de los escogidos
        $res_sem[0];
        ddd($semestreMatriculado);
        if(!empty($semestreMatriculado)){
            //print_r($semestreMatriculado);
            $semestreF = $semestre;
            foreach($semestreMatriculado as $key=>$val){
                $semestreF[$key] += $val;
            }
            //var_dump($semestreF);
            $maxs = array_keys($semestreF, max($semestreF));
            //var_dump($maxs);
            $res_sem[0] = $maxs[0];
        } 
    }
    
    public function calcularCreditosxSemestreMateriasMatriculadas($codigoperiodo,$codigoestudiante){
        $semestre = array();
        $query = "SELECT d.codigomateria, d.codigomateriaelectiva, edp.nombreestadodetalleprematricula, "
                . " d.idgrupo, d.numeroordenpago "
                . "FROM detalleprematricula d "
                . "INNER JOIN prematricula p ON (d.idprematricula = p.idprematricula) "
                . "INNER JOIN materia m ON (d.codigomateria = m.codigomateria) "
                . "INNER JOIN estudiante e ON (p.codigoestudiante = e.codigoestudiante) "
                . "INNER JOIN estadodetalleprematricula edp ON (edp.codigoestadodetalleprematricula = d.codigoestadodetalleprematricula) "
                . "WHERE e.codigoestudiante = ".$this->db->qstr($codigoestudiante)
                . " AND (p.codigoestadoprematricula like '4%') "
                . " AND (d.codigoestadodetalleprematricula like '3%' or d.codigoestadodetalleprematricula = '23') "
                . " AND p.codigoperiodo = ".$this->db->qstr($codigoperiodo);

        $datos = $this->db->Execute($query);
        $totalRows = $datos->NumRows();
        while($row_materia = $datos->FetchRow()){
            $codigo = $row_materia["codigomateriaelectiva"];
            if($row_materia["codigomateriaelectiva"]==0){
                $codigo = $row_materia["codigomateria"];
            }

            $query_materia = "SELECT m.nombremateria, m.codigomateria, dpe.semestredetalleplanestudio, "
                    . " dpe.numerocreditosdetalleplanestudio as numerocreditos "
                    . "FROM materia m "
                    . "INNER JOIN detalleplanestudio dpe ON (m.codigomateria = dpe.codigomateria) "
                    . "INNER JOIN planestudioestudiante pee ON (pee.idplanestudio = dpe.idplanestudio) "
                    . "WHERE m.codigomateria = ".$this->db->qstr($codigo)
                    . " AND pee.codigoestudiante = ".$this->db->qstr($codigoestudiante)
                    . " AND pee.codigoestadoplanestudioestudiante like '1%'";

            $materiaDetalle = $this->db->Execute($query_materia);
            $row_detalle = $materiaDetalle->FetchRow();

            if(isset($semestre[$row_detalle["semestredetalleplanestudio"]])){
                $semestre[$row_detalle["semestredetalleplanestudio"]] += $row_detalle["numerocreditos"];
            }else{
                $semestre[$row_detalle["semestredetalleplanestudio"]] = $row_detalle["numerocreditos"];
            }
        }
        return $semestre;
    }

    // El calculo de creditos debe contener solamente aquellas materias que tengan concepto matricula
    //echo "<br>calculocreditossemestre.php<br>";
    function estagrupo_jornada($codigomateria, $codigoestudiante, $codigoperiodo){
            // Toma el grupo que tiene inscrito el estudiante
            $query_datagrupo = "SELECT d.idgrupo, h.codigodia, h.horainicial, "
                    . " h.horafinal, e.codigojornada, e.codigocarrera "
                    . "FROM detalleprematricula d "
                    . "INNER JOIN prematricula p ON (d.idprematricula = p.idprematricula) "
                    . "INNER JOIN estudiante e ON (p.codigoestudiante = e.codigoestudiante) "
                    . "INNER JOIN horario h ON (h.idgrupo = d.idgrupo) "
                    . "INNER JOIN grupo g ON (g.idgrupo = h.idgrupo) "
                    . "WHERE e.codigoestudiante = ".$this->db->qstr($codigoestudiante)." "
                    . " AND (p.codigoestadoprematricula LIKE '4%' OR p.codigoestadoprematricula LIKE '1%') "
                    . " AND (d.codigoestadodetalleprematricula LIKE '3%' OR d.codigoestadodetalleprematricula LIKE '1%') "
                    . " AND p.codigoperiodo = ".$this->db->qstr($codigoperiodo)." "
                    . " AND d.codigomateria = ".$this->db->qstr($codigomateria)." "
                    . " AND g.codigoindicadorhorario like '1%'";
            
            $datagrupo = $this->db->Execute($query_datagrupo);
            $totalRows_datagrupo = $datagrupo->NumRows();
            
            if(!empty($totalRows_datagrupo)){
                
                while($row_datagrupo = $datagrupo->FetchRow()){
                    // Mira si la hora inicio y hora final estan en su jornada junto con el dia
                    $query_selcobroexcedente = "SELECT c.nombrecobroexcedentecambiojornada, dc.horainiciodetallecobroexcedentecambiojornada, "
                            . " dc.horafinaldetallecobroexcedentecambiojornada "
                            . "FROM cobroexcedentecambiojornada c "
                            . "INNER JOIN detallecobroexcedentecambiojornada dc ON (dc.idcobroexcedentecambiojornada = c.idcobroexcedentecambiojornada) "
                            . "INNER JOIN subperiodo s ON (s.idsubperiodo = c.idsubperiodo) "
                            . "INNER JOIN carreraperiodo cp ON (s.idcarreraperiodo = cp.idcarreraperiodo) "
                            . "WHERE c.codigojornada = ".$this->db->qstr($row_datagrupo['codigojornada'])." "
                            . " AND c.codigocarrera = ".$this->db->qstr($row_datagrupo['codigocarrera'])." "
                            . " AND dc.codigodia = ".$this->db->qstr($row_datagrupo['codigodia'])." "
                            . " AND c.codigoestado LIKE '1%' "
                            . " AND dc.codigoestado LIKE '1%' "
                            . " AND cp.codigoperiodo = ".$this->db->qstr($codigoperiodo)." "
                            . " AND (".$this->db->qstr($row_datagrupo['horainicial'])." BETWEEN dc.horainiciodetallecobroexcedentecambiojornada AND dc.horafinaldetallecobroexcedentecambiojornada) "
                            . " AND (".$this->db->qstr($row_datagrupo['horafinal'])." BETWEEN dc.horainiciodetallecobroexcedentecambiojornada AND dc.horafinaldetallecobroexcedentecambiojornada) ";
                    
                    $selcobroexcedente = $this->db->Execute($query_selcobroexcedente);
                    $totalRows_selcobroexcedente = $selcobroexcedente->NumRows();
                    
                    if($totalRows_selcobroexcedente == ""){
                        // Mira si la carrera esta controlando el cambio de jornada
                        $query_selcobroexcedente = "SELECT c.nombrecobroexcedentecambiojornada, dc.horainiciodetallecobroexcedentecambiojornada, "
                                . " dc.horafinaldetallecobroexcedentecambiojornada "
                                . "FROM cobroexcedentecambiojornada c "
                                . "INNER JOIN detallecobroexcedentecambiojornada dc ON (dc.idcobroexcedentecambiojornada = c.idcobroexcedentecambiojornada) "
                                . "INNER JOIN subperiodo s ON (s.idsubperiodo = c.idsubperiodo) "
                                . "INNER JOIN carreraperiodo cp ON (s.idcarreraperiodo = cp.idcarreraperiodo) "
                                . "WHERE c.codigojornada = ".$this->db->qstr($row_datagrupo['codigojornada'])." "
                                . " AND c.codigocarrera = ".$this->db->qstr($row_datagrupo['codigocarrera'])." "
                                . " AND dc.codigodia = ".$this->db->qstr($row_datagrupo['codigodia'])." "
                                . " AND c.codigoestado LIKE '1%' "
                                . " AND dc.codigoestado LIKE '1%' "
                                . " AND cp.codigoperiodo = ".$this->db->qstr($codigoperiodo)." " ;
                        
                        $selcobroexcedente = $this->db->Execute($query_selcobroexcedente);
                        $totalRows_selcobroexcedente = $selcobroexcedente->NumRows();
                        
                        // Si entra es por que debe controlar y el grupo esta en otra jornada
                        if($totalRows_selcobroexcedente != ""){
                            return false;
                        }
                    }
                }
            }
            return true;
    }

    function calcular_valormatriculaotrajornada($codigocarrera, $codigoperiodo, $codigojornada,$codigoestudiante=false){ //,
        $valor = 0;
        $tabla ="";
        $Condicion = "";
        // echo '<br>Estudoiante->'.$codigoestudiante;
        if($codigoestudiante){
            $query_selplanestudiante= "SELECT p.idplanestudio "
                    . "FROM planestudioestudiante p "
                    . "INNER JOIN planestudio pe ON (p.idplanestudio = pe.idplanestudio) "
                    . "WHERE p.codigoestudiante = ".$this->db->qstr($codigoestudiante)." " 
                    . " AND pe.codigoestadoplanestudio LIKE '1%' "
                    . " AND p.codigoestadoplanestudioestudiante LIKE '1%'";
            
            $selplanestudiante = $this->db->Execute($query_selplanestudiante);
            $totalRows_selplanestudiante = $selplanestudiante->NumRows();
            $row_selplanestudiante = $selplanestudiante->FetchRow();
            
            $idplan = $row_selplanestudiante['idplanestudio'];
            
            if($idplan=='615' || $idplan==615){
                $Condicion = ' AND c.idplanestudio=516';    
            }else{ 
                $Condicion = "";
            }

        }
        
        // Voy a la tabla jornadacarrera y hallo el plan de estudio y la cohorte
        // de la que debe sacar el valor
        $query_selcobroexcedente = "SELECT c.nombrecobroexcedentecambiojornada, c.idplanestudio, c.idcohorte "
                . "FROM cobroexcedentecambiojornada c "
                . "INNER JOIN subperiodo s ON (s.idsubperiodo = c.idsubperiodo) "
                . "INNER JOIN carreraperiodo cp ON (s.idcarreraperiodo = cp.idcarreraperiodo) "
                . "WHERE c.codigojornada = ".$this->db->qstr($codigojornada)." "
                . " AND c.codigocarrera = ".$this->db->qstr($codigocarrera)." "
                . " AND cp.codigoperiodo = ".$this->db->qstr($codigoperiodo)." " 
                . " AND c.codigoestado LIKE '1%' "
                . $Condicion;

        $selcobroexcedente = $this->db->Execute($query_selcobroexcedente);
        $totalRows_selcobroexcedente = $selcobroexcedente->NumRows();
        $row_selcobroexcedente = $selcobroexcedente->FetchRow();

        // Ahora con la cohorte y el semestre hallo el valor
        $query_selcohorte = "SELECT MAX(dc.valordetallecohorte) AS valordetallecohorte "
                . "FROM detallecohorte dc "
                . "WHERE dc.idcohorte = ".$this->db->qstr($row_selcobroexcedente['idcohorte'])." ";
        
        $selcohorte = $this->db->Execute($query_selcohorte);
        $totalRows_selcohorte = $selcohorte->NumRows();
        $row_selcohorte = $selcohorte->FetchRow;

        // Ahora con el plan de estudio hallo el numero de creditos del plan de estudios, y hallo el valor por credito
        // del plan de estudio
        $query_selcreditosplan = "SELECT p.idplanestudio, p.nombreplanestudio, p.fechacreacionplanestudio, "
                . " p.responsableplanestudio, p.cargoresponsableplanestudio, p.cantidadsemestresplanestudio, "
                . " c.nombrecarrera, p.numeroautorizacionplanestudio, t.nombretipocantidadelectivalibre, "
                . " p.cantidadelectivalibre, p.fechainioplanestudio, p.fechavencimientoplanestudio, "
                . " dp.codigomateria, dp.semestredetalleplanestudio, "
                . " SUM(dp.numerocreditosdetalleplanestudio) AS creditos "
                . "FROM planestudio p "
                . "INNER JOIN carrera c ON (p.codigocarrera = c.codigocarrera) "
                . "INNER JOIN tipocantidadelectivalibre t ON (p.codigotipocantidadelectivalibre = t.codigotipocantidadelectivalibre) "
                . "INNER JOIN detalleplanestudio dp ON (p.idplanestudio = dp.idplanestudio) "
                . "WHERE p.idplanestudio = ".$this->db->qstr($row_selcobroexcedente['idplanestudio'])." "
                . " AND dp.codigotipomateria NOT LIKE '4%' "
                . "GROUP BY p.idplanestudio";
        
        $selcreditosplan = $this->db->Execute($query_selcreditosplan);
        $totalRows_selcreditosplan = $selcreditosplan->NumRows();
        $row_selcreditosplan = $selcreditosplan->FetchRow();

        // Multiplico el numero de semestres del plan de estudio por la cohorte mas alta y lo divido por los creditos del plan de estudio
        $valor = $row_selcohorte['valordetallecohorte']*$row_selcreditosplan['cantidadsemestresplanestudio']/$row_selcreditosplan['creditos'];
        
        return $valor;
    }    
}