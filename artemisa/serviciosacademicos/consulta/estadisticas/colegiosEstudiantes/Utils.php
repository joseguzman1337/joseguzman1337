<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

// session_start(); 
 
    $ruta = "../";
    while (!is_file($ruta.'Connections/sala2.php'))
    {
        $ruta = $ruta."../";
    }
    require_once($ruta.'Connections/sala2.php');
    $rutaado = $ruta."funciones/adodb/";
    require_once($ruta.'Connections/salaado.php');
    require_once('../matriculasnew/funciones/obtener_datos.php');
    
    global $db; 

class Utils {

    private static $instance = NULL;
    private $db = NULL;
	
    
    private function __construct() {
        global $db;
        $this->db = $db;
    }
	
	public static function getInstance() {
		if(!isset(self::$instance)) {
		  self::$instance = new Utils();
		}
		return self::$instance;
	}
        
        public function getCarrerasPregrado(){
            $query_carreras="select nombrecarrera, codigocarrera from carrera 
	where codigomodalidadacademica ='200' order by nombrecarrera";

            $carreras= $this->db->GetAll($query_carreras);
            $totalRows_carreras = count($carreras);
            
            return array("carreras"=>$carreras, "total"=>$totalRows_carreras);
        }
        
        public function getCarrera($codigo){
            $query_carreras="select * from carrera where codigocarrera=".$codigo;

            $carrera= $this->db->GetRow($query_carreras);
            
            return $carrera;
        }
        
        public function getEstudiante($codigo,$codigoestudiante){
            if($codigo!=null){
                $query_estudiante="select * from estudiantegeneral where idestudiantegeneral=".$codigo;
            } else {
                $query_estudiante="select * from estudiante e 
                            inner join estudiantegeneral eg on eg.idestudiantegeneral=e.idestudiantegeneral
                            where e.codigoestudiante=".$codigoestudiante;
            }

            $estudiante= $this->db->GetRow($query_estudiante);
            
            return $estudiante;
        }
        
        public function calcularColegios($year,$totalRows_carreras,$carreras){
            $estadisticas = $this->getEstadisticasColegiosPeriodo($year."1",$totalRows_carreras,$carreras);
            $estadisticas2 = $this->getEstadisticasColegiosPeriodo($year."2",$totalRows_carreras,$carreras);
            
            $inscritos = array ("inscritosOficial"=>$estadisticas["inscritos"]["inscritosOficial"]+$estadisticas2["inscritos"]["inscritosOficial"],
                "inscritosPrivado"=>$estadisticas["inscritos"]["inscritosPrivado"]+$estadisticas2["inscritos"]["inscritosPrivado"],
                    "inscritosNoBogota"=>$estadisticas["inscritos"]["inscritosNoBogota"]+$estadisticas2["inscritos"]["inscritosNoBogota"],
                "inscritosSinDefinir"=>$estadisticas["inscritos"]["inscritosSinDefinir"]+$estadisticas2["inscritos"]["inscritosSinDefinir"]);
                
            $admitidos = array("admitidosOficial"=>$estadisticas["admitidos"]["admitidosOficial"]+$estadisticas2["admitidos"]["admitidosOficial"],
                "admitidosPrivado"=>$estadisticas["admitidos"]["admitidosPrivado"]+$estadisticas2["admitidos"]["admitidosPrivado"],
                    "admitidosNoBogota"=>$estadisticas["admitidos"]["admitidosNoBogota"]+$estadisticas2["admitidos"]["admitidosNoBogota"],
                "admitidosSinDefinir"=>$estadisticas["admitidos"]["admitidosSinDefinir"]+$estadisticas2["admitidos"]["admitidosSinDefinir"]);        
            
            
             $matriculados = array("matOficial"=>$estadisticas["matriculados"]["matOficial"]+$estadisticas2["matriculados"]["matOficial"],
                 "matPrivado"=>$estadisticas["matriculados"]["matPrivado"]+$estadisticas2["matriculados"]["matPrivado"],
                    "matNoBogota"=>$estadisticas["matriculados"]["matNoBogota"]+$estadisticas2["matriculados"]["matNoBogota"],
                 "matSinDefinir"=>$estadisticas["matriculados"]["matSinDefinir"]+$estadisticas2["matriculados"]["matSinDefinir"]);
            return array ("inscritos"=>$inscritos, "admitidos"=>$admitidos, "matriculados"=>$matriculados);
        }
        
        public function getEstadisticasColegiosPeriodo($codigoperiodo,$totalRows_carreras,$carreras){
            //var_dump($totalRows_carreras); echo "<br/><br/>";
                $inscritos = $this->getCountInscritos($codigoperiodo,$totalRows_carreras,$carreras);
                $admitidos = $this->getCountAdmitidos($codigoperiodo,$totalRows_carreras,$carreras);
                $matriculados = $this->getCountMatriculados($codigoperiodo,$totalRows_carreras,$carreras);
                //var_dump($inscritos);
                return array("inscritos"=>$inscritos, "admitidos"=>$admitidos, "matriculados"=>$matriculados);
        }
        
        public function getEstudiantesInscritosNoClasificados($year,$totalRows_carreras,$carreras){
            $estadisticas = $this->getCountInscritos($year."1",$totalRows_carreras,$carreras);
            $estadisticas2 = $this->getCountInscritos($year."2",$totalRows_carreras,$carreras);
            $array_insc = array();
            if(count($estadisticas["sinClasificar"])>0){
                $array_insc = array_merge($array_insc, $estadisticas["sinClasificar"]);
            }
            if(count($estadisticas2["sinClasificar"])>0){
                $array_insc = array_merge($array_insc, $estadisticas2["sinClasificar"]);
            }
                            
            return $array_insc;
        }
        
        public function getCountInscritos($codigoperiodo,$totalRows_carreras,$carreras){
                $inscritosSinClasificar = array();
                //var_dump($codigoperiodo); echo "<br/><br/>"; 
                //var_dump($this->db); echo "<br/><br/>";
                $datos_estadistica=new obtener_datos_matriculas($this->db,$codigoperiodo);
//var_dump($datos_estadistica); die();
                $inscritosBogotaOficial = 0;
                $inscritosBogotaNoOficial = 0;
                $inscritosNoBogota = 0;
                $inscritosSinDefinir = 0;

                for($j=0; $j<$totalRows_carreras; $j++){
                    $array_insc=$datos_estadistica->ObtenerDatosCuentaOperacionPrincipalIncluyeInscritosSinPago($codigoperiodo,$carreras[$j]['codigocarrera'],153,'arreglo');
                    $totalInscritos = count($array_insc);
                    for($z=0; $z<$totalInscritos; $z++){
                        $sql = "SELECT e.codigoestudiante,e.idestudiantegeneral,e.codigocarrera,e.codigoperiodo,ee.idinstitucioneducativa,
                                ee.otrainstitucioneducativaestudianteestudio, ee.ciudadinstitucioneducativa, ee.colegiopertenececundinamarca,
                                i.nombreinstitucioneducativa, i.departamentoinstitucioneducativa, n.codigonaturaleza, n.nombrenaturaleza FROM sala.estudiante e
                                inner join estudianteestudio ee ON ee.idestudiantegeneral=e.idestudiantegeneral AND ee.idniveleducacion=2 AND ee.codigoestado=100 AND e.codigoestudiante='".$array_insc[$z]["codigoestudiante"]."'  
                                inner join institucioneducativa i ON i.idinstitucioneducativa=ee.idinstitucioneducativa 
                                left join naturaleza n ON n.codigonaturaleza=i.codigonaturaleza ";

                        $estudiante = $this->db->GetRow($sql);
                        $array_insc[$z]["extraInfo"] = $estudiante;
                        if($estudiante["nombrenaturaleza"]!=null & $estudiante["nombrenaturaleza"]!=""){
                            if($estudiante["departamentoinstitucioneducativa"]==="BOGOTA"){
                                if($estudiante["codigonaturaleza"]==="002"){
                                    $inscritosBogotaNoOficial +=1;
                                } else {
                                    $inscritosBogotaOficial +=1;
                                }
                            } else {
                                $inscritosNoBogota +=1;
                            }
                        } else {
                            $inscritosSinDefinir +=1;
                            array_push($inscritosSinClasificar, $array_insc[$z]);
                        }
                    }
                    /*$array_insc = array_values($array_insc);
                    $totalInscritos = count($array_insc);*/

                    //$array_admnomat=$datos_estadistica->seguimiento_inscripcionvsmatriculadosnuevos($carreras[$j]['codigocarrera'],'arreglo');
                //$array_admnoing=$datos_estadistica->ObtenerDatosCuentaOperacionPrincipalAdmitidosQueNoIngresaron($codigoperiodo,$carreras[$j]['codigocarrera'],153,'arreglo');
                //$array_matnuevo=$datos_estadistica->obtener_datos_estudiantes_matriculados_nuevos($carreras[$j]['codigocarrera'],'arreglo');
                //echo "<br/><br/><pre>";print_r($array_insc);
                /*if($totalInscritos>0){
                        $inscritos = array_merge($inscritos, $array_insc);
                }*/
                //echo "<br/><br/><pre>";print_r($inscritos);

                }
                //var_dump($inscritosBogotaOficial); echo "<br/><br/>"; 
                return array("inscritosOficial"=>$inscritosBogotaOficial,"inscritosPrivado"=>$inscritosBogotaNoOficial,
                    "inscritosNoBogota"=>$inscritosNoBogota,"inscritosSinDefinir"=>$inscritosSinDefinir,
                    "sinClasificar"=>$inscritosSinClasificar);
        }
        
        public function getCountAdmitidos($codigoperiodo,$totalRows_carreras,$carreras){
            $datos_estadistica=new obtener_datos_matriculas($this->db,$codigoperiodo);
            $bogotaOficial = 0;
            $bogotaNoOficial = 0;
            $noBogota = 0;
            $sinDefinir = 0;
            for($j=0; $j<$totalRows_carreras; $j++){
                    $array_insc=array();
                    $array_admnomat=$datos_estadistica->seguimiento_inscripcionvsmatriculadosnuevos($carreras[$j]['codigocarrera'],'arreglo');
                    if(count($array_admnomat)>0){
                        $array_insc = array_merge($array_insc, $array_admnomat);
                    }
                    $array_admnoing=$datos_estadistica->ObtenerDatosCuentaOperacionPrincipalAdmitidosQueNoIngresaron($codigoperiodo,$carreras[$j]['codigocarrera'],153,'arreglo');
                    if(count($array_admnoing)>0){
                        $array_insc = array_merge($array_insc, $array_admnoing);
                    }
                    $array_matnuevo=$datos_estadistica->obtener_datos_estudiantes_matriculados_nuevos($carreras[$j]['codigocarrera'],'arreglo');
                    if(count($array_admnoing)>0){
                        $array_insc = array_merge($array_insc, $array_matnuevo);
                    }
                    $totalInscritos = count($array_insc);
                    for($z=0; $z<$totalInscritos; $z++){
                        $sql = "SELECT e.codigoestudiante,e.idestudiantegeneral,e.codigocarrera,e.codigoperiodo,ee.idinstitucioneducativa,
                                ee.otrainstitucioneducativaestudianteestudio, ee.ciudadinstitucioneducativa, ee.colegiopertenececundinamarca,
                                i.nombreinstitucioneducativa, i.departamentoinstitucioneducativa, n.codigonaturaleza, n.nombrenaturaleza FROM sala.estudiante e
                                inner join estudianteestudio ee ON ee.idestudiantegeneral=e.idestudiantegeneral AND ee.idniveleducacion=2 AND ee.codigoestado=100 AND e.codigoestudiante='".$array_insc[$z]["codigoestudiante"]."'  
                                inner join institucioneducativa i ON i.idinstitucioneducativa=ee.idinstitucioneducativa 
                                left join naturaleza n ON n.codigonaturaleza=i.codigonaturaleza ";

                        $estudiante = $this->db->GetRow($sql);
                        if($estudiante["nombrenaturaleza"]!=null & $estudiante["nombrenaturaleza"]!=""){
                            if($estudiante["departamentoinstitucioneducativa"]==="BOGOTA"){
                                if($estudiante["codigonaturaleza"]==="002"){
                                    $bogotaNoOficial +=1;
                                } else {
                                    $bogotaOficial +=1;
                                }
                            } else {
                                $noBogota +=1;
                            }
                        } else {
                            $sinDefinir +=1;
                        }
                    }
            }
             return array("admitidosOficial"=>$bogotaOficial,"admitidosPrivado"=>$bogotaNoOficial,
                    "admitidosNoBogota"=>$noBogota,"admitidosSinDefinir"=>$sinDefinir);
        }
        
        public function getCountMatriculados($codigoperiodo,$totalRows_carreras,$carreras){
            $datos_estadistica=new obtener_datos_matriculas($this->db,$codigoperiodo);
            $bogotaOficial = 0;
            $bogotaNoOficial = 0;
            $noBogota = 0;
            $sinDefinir = 0;
            for($j=0; $j<$totalRows_carreras; $j++){
                    $array_insc=$datos_estadistica->obtener_datos_estudiantes_matriculados_nuevos($carreras[$j]['codigocarrera'],'arreglo');
                    
                    $totalInscritos = count($array_insc);
                    for($z=0; $z<$totalInscritos; $z++){
                        $sql = "SELECT e.codigoestudiante,e.idestudiantegeneral,e.codigocarrera,e.codigoperiodo,ee.idinstitucioneducativa,
                                ee.otrainstitucioneducativaestudianteestudio, ee.ciudadinstitucioneducativa, ee.colegiopertenececundinamarca,
                                i.nombreinstitucioneducativa, i.departamentoinstitucioneducativa, n.codigonaturaleza, n.nombrenaturaleza FROM sala.estudiante e
                                inner join estudianteestudio ee ON ee.idestudiantegeneral=e.idestudiantegeneral AND ee.idniveleducacion=2 AND ee.codigoestado=100 AND e.codigoestudiante='".$array_insc[$z]["codigoestudiante"]."'  
                                inner join institucioneducativa i ON i.idinstitucioneducativa=ee.idinstitucioneducativa 
                                left join naturaleza n ON n.codigonaturaleza=i.codigonaturaleza ";

                        $estudiante = $this->db->GetRow($sql);
                        if($estudiante["nombrenaturaleza"]!=null & $estudiante["nombrenaturaleza"]!=""){
                            if($estudiante["departamentoinstitucioneducativa"]==="BOGOTA"){
                                if($estudiante["codigonaturaleza"]==="002"){
                                    $bogotaNoOficial +=1;
                                } else {
                                    $bogotaOficial +=1;
                                }
                            } else {
                                $noBogota +=1;
                            }
                        } else {
                            $sinDefinir +=1;
                        }
                    }
            }
             return array("matOficial"=>$bogotaOficial,"matPrivado"=>$bogotaNoOficial,
                    "matNoBogota"=>$noBogota,"matSinDefinir"=>$sinDefinir);
        }
        
        public function getYears(){
            $Y_date = date('Y');

            $years = array();
            $year = $Y_date-5;
            $count = 1;
                while($count <= 5) {
                    $years[] = $year;
                    $year = $year+1;
                    $count += 1;
                }
            return $years;
        }
}