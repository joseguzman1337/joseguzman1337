<?php

if(session_id() == '' )
 {
// this starts the session 
 session_start(); 
  }
 
$ruta = "../";
while (!is_file($ruta.'ManagerEntity.php'))
{
    $ruta = $ruta."../";
}
require_once($ruta.'ManagerEntity.php');
class Utils_datos {
    var $rutaProyecto = "datos";
    var $prueba = "prueba";
    
    function __construct() {
        
    }
    
    public function processData($action,$table,$fields = array(),$usePost=true,$debug=false,$prefix ="siq_") {     
        if(!isset($_SESSION['MM_Username'])){
            //$_SESSION['MM_Username'] = 'admintecnologia';
            echo "No ha iniciado sesión en el sistema"; die();
        }
        
        $entity = new ManagerEntity("usuario",$this->rutaProyecto);
        $entity->sql_select = "idusuario";
        $entity->prefix ="";
        $entity->sql_where = " usuario='".$_SESSION['MM_Username']."' ";
        //$entity->debug = true;
        $data = $entity->getData();
        $userid = $data[0]['idusuario'];
        $entity = new ManagerEntity($table,$this->rutaProyecto);
        $currentdate  = date("Y-m-d H:i:s");
        $idname= "id".$prefix.$table;
        $fields['fecha_modificacion'] = $currentdate;
        $fields['usuario_modificacion'] = $userid;
        if($usePost || (!$usePost&&$fields["codigoestado"]==null)){
            $fields["codigoestado"] = 100;
        }
        
        if($usePost){
            foreach ($_POST as $key => $value)  {
                if (strcmp($key,"action") == 0) {
                } else{
                  //  echo $value.'<br>';
                    $fields[$key] = trim($value); 
                    
                }
            }
        }
        //var_dump($_POST);
        //die();
        //var_dump($action);
        //exit();

        if(strcmp($action,"save")==0){
            $fields['fecha_creacion'] = $currentdate;
            $fields['usuario_creacion'] = $userid;
            
            return $this->saveData($entity, $fields,$prefix,$debug);
        } else if(strcmp($action,"update")==0){
            return $this->updateData($entity, $fields, $idname,$prefix);
        } else if(strcmp($action,"inactivate")==0){
            return $this->inactivateData($entity, $fields, $idname);
        } else if(strcmp($action,"activate")==0){
            return $this->activateData($entity, $fields, $idname);
        }

    }
    
    public function saveData($entity, $fields,$prefix,$debug=false) {        
     // print_r($fields);
      // echo "aca..";
       $entity->SetEntity($fields);
       $entity->prefix = $prefix;
      // $debug = true;
       if($debug){
            $entity->debug = true;
       }
       return $entity->insertRecord();
    }
    
    public function updateData($entity, $fields, $idname,$prefix) { 
        $entity->SetEntity($fields);
        $entity->prefix = $prefix;
        $entity->fieldlist[$idname]['pkey']=$fields[$idname];
        //var_dump($fields);
        //var_dump($entity);
        //if($idname==="idsiq_verificarformTalentoHumanoNumeroPersonas")
        //$entity->debug = true;      
        $entity->updateRecord();
        return $fields[$idname];
    }
    
    public function inactivateData($entity, $fields, $idname) { 
        
        $entity->sql_where = "idsiq_".$entity->tablename." = ".$fields[$idname]."";
        //$entity->debug = true;
        $data = $entity->getData();
        $data = $data[0];
        
        foreach ($data as $key => $value)  {
            if ((strcmp($key,"fecha_modificacion") == 0) || (strcmp($key,"usuario_modificacion") == 0)) {
            } else{ $fields[$key] = $value; }
        }
        
        $fields["codigoestado"] = 200;
        $entity->SetEntity($fields);
        $entity->fieldlist[$idname]['pkey']=$fields[$idname];
        
        //$entity->debug = true;        
        $entity->updateRecord(); 
        return $fields[$idname];
    }
    
    
    public function activateData($entity, $fields, $idname) { 
        
        $entity->sql_where = "idsiq_".$entity->tablename." = ".$fields[$idname]."";
        //$entity->debug = true;
        $data = $entity->getData();
        $data = $data[0];
        
        foreach ($data as $key => $value)  {
            if ((strcmp($key,"fecha_modificacion") == 0) || (strcmp($key,"usuario_modificacion") == 0)) {
            } else{ $fields[$key] = $value; }
        }
        
        $fields["codigoestado"] = 100;
        $entity->SetEntity($fields);
        $entity->fieldlist[$idname]['pkey']=$fields[$idname];
        
        //$entity->debug = true;        
        $entity->updateRecord();
        return $fields[$idname];
    }  
    
    public function getPlantillasReporte($db,$asArray=true) {  
        $sql = "SELECT idsiq_plantillaReporte, nombre, nombre_imagen, tiene_categoria FROM siq_plantillaReporte WHERE codigoestado = '100' ORDER BY idsiq_plantillaReporte ASC";
        
        if($asArray){
            $rows = $db->GetAll($sql);
        } else {
            $rows = $db->Execute($sql);
        }
        
        return $rows;
    }
    
    public function getIndicadoresAsociadosReporte($db,$idReporte,$asArray=true) {  
        $sql = "SELECT
                        i.idsiq_indicador,
                        ig.codigo,
                        i.discriminacion,
                        ig.idsiq_indicadorGenerico,
                        ig.idAspecto,
                        ig.nombre,
                        ig.descripcion,
                        ig.idTipo,
                        ig.area,
                        c.codigocarrera,
                        c.codigocortocarrera,
                        c.nombrecortocarrera,
                        c.nombrecarrera,
                        c.codigofacultad
                        FROM 
                        siq_indicadorGenerico as ig
                        inner join siq_indicador as i on (ig.idsiq_indicadorGenerico=i.idindicadorGenerico)
                        left join carrera as c on (c.codigocarrera=i.idCarrera)
                        WHERE ig.codigoestado=100 and i.codigoestado=100 
                        AND i.idsiq_indicador IN (SELECT idIndicador FROM siq_relacionReporteIndicador ri 
                            WHERE ri.idReporte = '".$idReporte."' AND ri.codigoestado=100);";
        if($asArray){
            $rows = $db->GetAll($sql);
        } else {
            $rows = $db->Execute($sql);
        }
        
        return $rows;
    }
    
    public function getIndicadoresAsociadosFormulario($db,$idFormulario,$asArray=true) {  
        $sql = "SELECT
                        i.idsiq_indicador,
                        ig.codigo,
                        i.discriminacion,
                        ig.idsiq_indicadorGenerico,
                        ig.idAspecto,
                        ig.nombre,
                        ig.descripcion,
                        ig.idTipo,
                        ig.area,
                        c.codigocarrera,
                        c.codigocortocarrera,
                        c.nombrecortocarrera,
                        c.nombrecarrera,
                        c.codigofacultad
                        FROM 
                        siq_indicadorGenerico as ig
                        inner join siq_indicador as i on (ig.idsiq_indicadorGenerico=i.idindicadorGenerico)
                        left join carrera as c on (c.codigocarrera=i.idCarrera)
                        WHERE ig.codigoestado=100 and i.codigoestado=100 
                        AND i.idsiq_indicador IN (SELECT idIndicador FROM siq_relacionFormularioIndicador ri 
                            WHERE ri.idFormulario = '".$idFormulario."' AND ri.codigoestado=100);";
        if($asArray){
            $rows = $db->GetAll($sql);
        } else {
            $rows = $db->Execute($sql);
        }
        return $rows;
    }
    
    public function getGraficasReporte($db,$asArray=true) {  
        $sql = "SELECT idsiq_graficaReporte, nombre, nombre_imagen FROM siq_graficaReporte WHERE codigoestado = '100' ORDER BY idsiq_graficaReporte ASC";
        
        if($asArray){
            $rows = $db->GetAll($sql);
        } else {
            $rows = $db->Execute($sql);
        }
        
        return $rows;
    }
    
    public function getIndicadoresReporte($db,$id,$asArray=true) {  
        $sql = "SELECT ig.codigo,ig.nombre, i.idsiq_indicador FROM siq_relacionReporteIndicador r 
                inner join siq_indicador i ON i.idsiq_indicador = r.idIndicador AND i.codigoestado = '100' 
                inner join siq_indicadorGenerico ig ON ig.idsiq_indicadorGenerico = i.idIndicadorGenerico AND ig.codigoestado = '100' 
                WHERE r.codigoestado = '100' AND r.idReporte='".$id."' ORDER BY ig.nombre ASC";

        if($asArray){
            $rows = $db->GetAll($sql);
        } else {
            $rows = $db->Execute($sql);
        }
        
        return $rows;
    }
    
    public function getFormularioIndicador($db,$id) {  
        $sql = "SELECT f.idsiq_formulario,f.nombre,f.categoria,f.alias FROM siq_formulario f 
            inner join siq_relacionFormularioIndicador r ON r.idFormulario=f.idsiq_formulario 
            WHERE f.codigoestado = '100' AND r.codigoestado = '100' AND r.idIndicador='".$id."'";
        
        return $db->GetAll($sql);
    }
    
    public function getIDReporteByIndicador($db,$idIndicador){
        $sql = "SELECT r.idReporte, rep.nombre FROM siq_relacionReporteIndicador r 
                inner join siq_reporte rep ON rep.idsiq_reporte=r.idReporte 
                WHERE r.codigoestado = '100' AND r.idIndicador='".$idIndicador."'";

        $row = $db->GetAll($sql);
        
        return $row;
    }
    
    public function getPeriodosFechasReporte($db,$asArray=true) {  
        $sql = "SELECT idsiq_periodoFechaReporte, nombre, valor, tipo FROM siq_periodoFechaReporte WHERE codigoestado = '100' ORDER BY idsiq_periodoFechaReporte ASC";
        
        if($asArray){
            $rows = $db->GetAll($sql);
        } else {
            $rows = $db->Execute($sql);
        }
        
        return $rows;
    }
    
    public function getTiposData($db,$asArray=true) {  
        $sql = "SELECT idsiq_tipoData, nombre FROM siq_tipoData WHERE codigoestado = '100' ORDER BY nombre ASC";
        
        if($asArray){
            $rows = $db->GetAll($sql);
        } else {
            $rows = $db->Execute($sql);
        }
        
        return $rows;
    }
    
    public function getCategoriasData($db,$asArray=true) {  
        $sql = "SELECT idsiq_categoriaData, nombre FROM siq_categoriaData WHERE codigoestado = '100' ORDER BY nombre ASC";
        
        if($asArray){
            $rows = $db->GetAll($sql);
        } else {
            $rows = $db->Execute($sql);
        }
        
        return $rows;
    }
    
    public function getDetalleReporte($db,$id,$asArray=true) {  
        $sql = "SELECT idsiq_detalleReporte, etiqueta_columna, numero_columna FROM siq_detalleReporte WHERE idReporte='".$id."' AND codigoestado = '100' ORDER BY numero_columna ASC";
        
        if($asArray){
            $rows = $db->GetAll($sql);
        } else {
            $rows = $db->Execute($sql);
        }
        
        return $rows;
    }
    
    public function getDiscriminacionesIndicador($db,$asArray=true) {  
        $sql = "SELECT nombre, idsiq_discriminacionIndicador FROM siq_discriminacionIndicador WHERE codigoestado = '100' ORDER BY nombre ASC";
        
        if($asArray){
            $rows = $db->GetAll($sql);
        } else {
            $rows = $db->Execute($sql);
        }
        
        return $rows;
    }
    
    public function getModalidadesAcademicas($db,$asArray=true) {  
        $sql = "SELECT nombremodalidadacademica, codigomodalidadacademica FROM modalidadacademica WHERE codigoestado = '100' ORDER BY nombremodalidadacademica ASC";
                                        
        if($asArray){
            $rows = $db->GetAll($sql);
        } else {
            $rows = $db->Execute($sql);
        }
        
        return $rows;
    }
    
    public function getAllDetalleReporte($db,$id,$asArray=true) {  
        $sql = "SELECT idsiq_detalleReporte, etiqueta_columna, numero_columna,idDato,filtro FROM siq_detalleReporte WHERE idReporte='".$id."' AND codigoestado = '100' ORDER BY numero_columna ASC";
        
        if($asArray){
            $rows = $db->GetAll($sql);
        } else {
            $rows = $db->Execute($sql);
        }
        
        return $rows;
    }
    
    public function getFiltrosReporte($db,$id) {  
        $sql = "SELECT filtro,valor FROM siq_filtroDetalleReporte WHERE idDetalleReporte='".$id."' AND codigoestado = '100' ";
        
        $rows = $db->GetAll($sql);
        
        $num = count($rows);
        $filtros = array();
        for ($i = 0; $i < $num; $i++) 
        {    
             $filtros[$rows[$i]["filtro"]]=$rows[$i]["valor"];
        }
        
        return $filtros;
    }
    
    public function getFiltrosReporteJs($db,$id) {  
        $sql = "SELECT filtro,valor FROM siq_filtroDetalleReporte WHERE idDetalleReporte='".$id."' AND codigoestado = '100' ";
        
        $rows = $db->GetAll($sql);
        
        $num = count($rows);
        $filtros = array();
        for ($i = 0; $i < $num; $i++) 
        {    
            $filtros[$i]=array($rows[$i]["filtro"],$rows[$i]["valor"]);
        }
        
        return $filtros;
    }
    
    public function getDataFormFieldsByJoin($db,$table,$tableJoin,$campoJoin,$queryField,$value,$order="") {
        $sql = "SELECT * FROM ".$table." t
                INNER JOIN ".$tableJoin." s ON s.id".$tableJoin."=t.".$campoJoin." AND s.codigoestado='100' 
            WHERE ".$queryField."='".$value."' AND t.codigoestado = '100' ".$order;       

        return $db->GetAll($sql);
    } 
    
    public function getDataFormFields($db,$table,$queryField,$value,$codigocarrera=null) {
        $sql = "SHOW COLUMNS FROM `".$table."` LIKE 'nombre';";
        $result = $db->GetRow($sql);
        $order = "";
        if(count($result)>0){
            $order = "ORDER BY nombre ASC";
        }
        if($codigocarrera==null){
            $sql = "SELECT * FROM ".$table." t WHERE ".$queryField."='".$value."' AND t.codigoestado = '100' ".$order; 
        } else {
            $sql = "SELECT * FROM ".$table." t WHERE ".$queryField."='".$value."' AND t.codigoestado = '100' 
                AND t.codigocarrera='".$codigocarrera."' ".$order; 
        }
        return $db->GetAll($sql);
    } 
    
    public function getDataFormDynamic2($db,$entity,$tableJoin,$queryField,$value,$joinField="",$codigocarrera=null, $actividad=null,$order=null) {
        
        $sql = "SELECT * FROM siq_".$entity." t 
                INNER JOIN siq_detalle".$entity." d ON d.idData = t.idsiq_".$entity." AND d.codigoestado='100' ";
        if($joinField===""){
             $sql .=  " INNER JOIN ".$tableJoin." s ON s.id".$tableJoin."=d.idCategory AND s.codigoestado='100' ";
        } else {
            $sql .=  " INNER JOIN ".$tableJoin." s ON s.".$joinField."=d.idCategory ";
        }
            $sql .=  " WHERE t.".$queryField."='".$value."' AND t.codigoestado = '100' ";  
            if($codigocarrera!=null){
                $sql .=  " AND t.codigocarrera='".$codigocarrera."'";
            }
            if($actividad!=null){
                $sql .=  " AND t.actividad='".$actividad."'";
            }
            $sql .= " GROUP BY d.idCategory";
            if($order!=null){
                $sql .=  " ORDER BY s.".$order." ASC";
            }
        //echo $sql;
        $result = array();
        $result["data"]=$db->GetAll($sql);
        if(count($result["data"])>0){
            $result["id"]=$result["data"][0]["idData"];
        }
        return $result;
    }
	
	public function getPeriodos($valuePeriodo,$valuePeriodo2,$tipo,$formato){
		//echo $valuePeriodo." - ". $valuePeriodo2;
		$periodos = "";
		if($tipo==="mes"){
				if($formato==="m-Y"){
					$datos1 = explode("-",$valuePeriodo);
					$datos2 = explode("-",$valuePeriodo2);
					
					$currentYear = intval($datos1[1]);
					$finalYear = intval($datos2[1]);
					
					$currentM = intval($datos1[0]);
					$finalM = intval($datos2[0]);
					
					$diffAnios = $finalYear - $currentYear;
					$diffM = $finalM - $currentM;
					//echo "diferencia años ".$diffAnios;
					for($i=0;$i<=$diffAnios;$i++){
						$year = $currentYear+$i;
						//echo "<br/>año ".$year;
						//si estoy en el año de inicio
						if($currentYear==$year && $finalYear!=$currentYear){	
							//echo "<br/>año de inicio diferente al final ".$currentYear;
							for($j=$currentM;$j<=12;$j++){
								$mes = $j;
								if($periodos === ""){
									$periodos = "'".$mes."-".$year."'";
								} else {
									$periodos .= ",'".$mes."-".$year."'";
								}
							}
						} else if($finalYear==$year && $finalYear!=$currentYear){ //estoy en el último pero es diferente al inicial		
							//echo "en el año final diferente ".$finalYear." - ".$currentYear;
							for($j=1;$j<=$finalM;$j++){
								$mes = $j;
								if($periodos === ""){
									$periodos = "'".$mes."-".$year."'";
								} else {
									$periodos .= ",'".$mes."-".$year."'";
								}
							}
						} else if($finalYear==$year){ //estoy en el último, igual al inicial		
							//echo " en el año final wtf!  ".$diffM." - ".$currentM;						
							for($j=0;$j<=$diffM;$j++){
								$mes = $currentM+$j;
								if($periodos === ""){
									$periodos = "'".$mes."-".$year."'";
								} else {
									$periodos .= ",'".$mes."-".$year."'";
								}
							}
						} else { //estoy en otros años	
							//echo "<br/>wtf otros años ".$currentYear." - ".$year." - ".$finalYear;						
							for($j=1;$j<=12;$j++){
								$mes = $j;
								if($periodos === ""){
									$periodos = "'".$mes."-".$year."'";
								} else {
									$periodos .= ",'".$mes."-".$year."'";
								}
							}						
						}
						
					}
				}
		} else if($tipo==="semestral"){
			if($formato==="Yp"){
				$datos1 = str_split($valuePeriodo, 4);
				$datos2 = str_split($valuePeriodo2, 4);
				
				$currentYear = intval($datos1[0]);
				$finalYear = intval($datos2[0]);
					
				$currentP = intval($datos1[1]);
				$finalP = intval($datos2[1]);
				
				$diffAnios = $finalYear - $currentYear;
				$diffP = $finalP - $currentP;
				
				for($i=0;$i<=$diffAnios;$i++){
						$year = $currentYear+$i;
						//echo "<br/>año ".$year;
						//si estoy en el año de inicio
						if($currentYear==$year && $finalYear!=$currentYear){	
							//echo "<br/>año de inicio diferente al final ".$currentYear;
							for($j=$currentP;$j<=2;$j++){
								$mes = $j;
								if($periodos === ""){
									$periodos = "'".$year.$mes."'";
								} else {
									$periodos .= ",'".$year.$mes."'";
								}
							}
						} else if($finalYear==$year && $finalYear!=$currentYear){ //estoy en el último pero es diferente al inicial		
							for($j=1;$j<=$finalP;$j++){
								$mes = $j;
								if($periodos === ""){
									$periodos = "'".$year.$mes."'";
								} else {
									$periodos .= ",'".$year.$mes."'";
								}
							}
						} else if($finalYear==$year){ //estoy en el último, igual al inicial		
							//echo " en el año final wtf!  ".$diffM." - ".$currentM;						
							for($j=0;$j<=$diffP;$j++){
								$mes = $currentP+$j;
								if($periodos === ""){
									$periodos = "'".$year.$mes."'";
								} else {
									$periodos .= ",'".$year.$mes."'";
								}
							}
						} else { //estoy en otros años	
							//echo "<br/>wtf otros años ".$currentYear." - ".$year." - ".$finalYear;						
							for($j=1;$j<=2;$j++){
								$mes = $j;
								if($periodos === ""){
									$periodos = "'".$year.$mes."'";
								} else {
									$periodos .= ",'".$year.$mes."'";
								}
							}						
						}
						
					}
			}
		}
		//echo $periodos;
		return $periodos;
	}
	
	public function getValoresOrdenados($arreglo,$funcion,$campoPeriodo){
		$arregloOrdenado = array();
		foreach($arreglo as $data){
			if($funcion==="getDataDynamic"){
				if(!isset($arregloOrdenado[$data[$campoPeriodo]][$data["idCategory"]])){
					$arregloOrdenado[$data[$campoPeriodo]][$data["idCategory"]] = $data;
				} else {
					foreach($data as $key=>$row){
						if(is_numeric($row)){
							$arregloOrdenado[$data[$campoPeriodo]][$data["idCategory"]][$key] += $row;
						}
					}
				}
			}else {
				//print_r( $data); echo $campoPeriodo."<br/>";
				$arregloOrdenado[$data[$campoPeriodo]][] = $data;
			}
		}
		//print_r($arregloOrdenado);echo "<br/>";
		//die;
		return $arregloOrdenado;
	}
	
	public function getMissingPeriodos($arreglo,$periodos){
		$periodosArray = explode(",",$periodos);
		$periodosFaltantes = "";
		foreach($periodosArray as $periodo){
			$per = str_replace("'", "", $periodo);
			if (!array_key_exists($per, $arreglo)) {
				if($periodosFaltantes === ""){
					$periodosFaltantes = $per;
				} else {
					$periodosFaltantes .= ", ".$per;
				}
			}
		}
		return $periodosFaltantes;
	}
	
	public function getMissingPeriodosAdjuntos($db,$periodos,$idFormulario,$numPestana,$codigocarrera=null){
		$periodosArray = explode(",",$periodos);
		$periodosFaltantes = "";
		$select = "";
		$carrera = "";
		if($codigocarrera!==null){
			$carrera = "AND codigocarrera=".$codigocarrera;
		}
		
		foreach($periodosArray as $periodo){
			if($select===""){
				$select = "select periodo from (
						select ".$periodo." as periodo";
			} else {
				$select .= " union select ".$periodo;
			}
		}
		
		if($select!==""){
			$select .= ") as x
					WHERE periodo NOT IN (SELECT periodo from siq_documento_infoHuerfana 
					where idFormulario=".$idFormulario." and numPestana=".$numPestana." AND codigoestado=100 
					AND periodo IN (".$periodos.") $carrera 
					GROUP BY periodo)";
		//echo $select;
			$resultados = $db->GetAll($select);
			foreach($resultados as $per){
				if($periodosFaltantes === ""){
					$periodosFaltantes = $per["periodo"];
				} else {
					$periodosFaltantes .= ", ".$per["periodo"];
				}
			}
		}
		return $periodosFaltantes;
	}
	
	public function getDataDynamicConsolidada($db,$entity,$tableJoin,$campoPeriodo,$valuePeriodo,
	$valuePeriodo2,$tipo,$formato,$funcion,$idFormulario,$numPestana,
	$joinField="",$codigocarrera=null, $actividad=null, $order=null, $modalidad=null) {
        //echo "hola ";
        $sql = "SELECT * FROM siq_".$entity." t 
                INNER JOIN siq_detalle".$entity." d ON d.idData = t.idsiq_".$entity." AND d.codigoestado='100' ";
        if($joinField===""){
             $sql .=  " INNER JOIN ".$tableJoin." s ON s.id".$tableJoin."=d.idCategory AND s.codigoestado='100' ";
        } else {
            $sql .=  " INNER JOIN ".$tableJoin." s ON s.".$joinField."=d.idCategory ";
        }
		if($modalidad!=null && ($codigocarrera==null || $codigocarrera=="" || $codigocarrera=="null")){
            $sql .=  " INNER JOIN carrera c ON c.codigocarrera=t.codigocarrera AND c.codigomodalidadacademicasic='".$modalidad."'";
        }
		
		$periodos = $this->getPeriodos($valuePeriodo,$valuePeriodo2,$tipo,$formato);
		//echo $periodos;
            $sql .=  " WHERE t.".$campoPeriodo." IN (".$periodos.") AND t.codigoestado = '100' ";  
            if($codigocarrera!=null && $codigocarrera!="null"){
                $sql .=  " AND t.codigocarrera='".$codigocarrera."'";
            }
            if($actividad!=null && $actividad!="null"){
                $sql .=  " AND t.actividad='".$actividad."'";
            }
            if($order!=null && $order!="" && $order!="null"){
				//echo "wtf<br/>"; var_dump($order);
                $sql .=  "ORDER BY ".$order;
            }
         //   $sql .= " GROUP BY d.idCategory";
        //echo $sql."<br/>"; 
        $result = array();
        $result["dataTemp"]=$db->GetAll($sql);
		//echo "1";
		$result["data"]=$this->getValoresOrdenados($result["dataTemp"],"getDataDynamic",$campoPeriodo);
		//echo "2";
		//print_r($result["data"]);echo "<br/>";
		//Informes totalizado
		//var_dump($modalidad);
		//echo $codigocarrera;
		if($codigocarrera==null || $codigocarrera=="" || $codigocarrera=="null"){
			$result["infoPeriodos"] = array();
			$result["infoAdjuntos"] = array();
		} else {
			$result["infoPeriodos"] = $this->getMissingPeriodos($result["data"],$periodos);
			//echo "3";
			$result["infoAdjuntos"] = $this->getMissingPeriodosAdjuntos($db,$periodos,$idFormulario,$numPestana,$codigocarrera);
		}
		//print_r($result);
        /*if(count($result["data"])>0){
            $result["id"]=$result["data"][0]["idData"];
        }*/
        return $result;
    }
	
	public function getDataConsolidada($db,$table,$queryField,$valuePeriodo,$prefix="siq_",$codigocarrera=null,$planEstudio=null,
		$valuePeriodo2,$tipo,$formato,$funcion,$idFormulario,$numPestana, $order=null, $modalidad=null) {
		$sql = "SELECT * FROM ".$prefix.$table." t ";
		
		$periodos = $this->getPeriodos($valuePeriodo,$valuePeriodo2,$tipo,$formato);
		if($modalidad!=null && ($codigocarrera==null || $codigocarrera=="" || $codigocarrera=="null")){
            $sql .=  " INNER JOIN carrera c ON c.codigocarrera=t.codigocarrera AND c.codigomodalidadacademicasic='".$modalidad."'";
        }
		//echo $periodos;
            $sql .=  " WHERE t.".$queryField." IN (".$periodos.") AND t.codigoestado = '100' ";  
            if($codigocarrera!=null){
                $sql .=  " AND t.codigocarrera='".$codigocarrera."'";
            }
			if($planEstudio!=null){
				$sql .=  " AND t.planEstudio = '".$planEstudio."'";
			}
            if($order!=null){
                $sql .=  "ORDER BY ".$order;
            }
		//echo $sql."<br/>"; 
		$result = array();
        $result["dataTemp"]=$db->GetAll($sql);
		//echo "1";
		//print_r($result["dataTemp"]);echo "<br/>";
		$result["data"]=$this->getValoresOrdenados($result["dataTemp"],"getData",$queryField);
		//echo "2";
		//print_r($result["data"]);echo "<br/>";
		if($codigocarrera==null || $codigocarrera=="" || $codigocarrera=="null"){
			$result["infoPeriodos"] = array();
			$result["infoAdjuntos"] = array();
		} else {
			$result["infoPeriodos"] = $this->getMissingPeriodos($result["data"],$periodos);
			//echo "3";
			$result["infoAdjuntos"] = $this->getMissingPeriodosAdjuntos($db,$periodos,$idFormulario,$numPestana,$codigocarrera);
		}
        
        return $result;
    }
    
    public function getDataFormFieldsByDate($db,$table,$queryField,$value,$codigocarrera=null,$tipo=null,$modalidad=null){
        if (strpos($value,'-') == false && $tipo==null) {
            // es un periodo
             $sql = "SELECT fechainicioperiodo,fechavencimientoperiodo FROM periodo 
                 WHERE codigoperiodo='".$value."' "; 
             $periodo = $db->GetRow($sql);
             if(count($periodo)>0){
                $query = "(".$queryField.">='".$periodo["fechainicioperiodo"]."' AND ".$queryField."<='".$periodo["fechavencimientoperiodo"]."')";
             } else {
                $query = "(".$queryField.">='".$value."' AND ".$queryField."<='".$value."')"; 
             }
        } else {
            $query = "(".$queryField.">='".$value."' AND ".$queryField."<='".$value."')";
        }
		$query2 = "";
		if($modalidad!=null && ($codigocarrera==null || $codigocarrera=="" || $codigocarrera=="null")){
            $query2 =  " INNER JOIN carrera c ON c.codigocarrera=t.codigocarrera AND c.codigomodalidadacademicasic='".$modalidad."'";
        }
            if($codigocarrera==null){
                $sql = "SELECT * FROM ".$table." t ".$query2." WHERE ".$query." AND t.codigoestado = '100' ORDER BY 2 ASC"; 
            } else {
                $sql = "SELECT * FROM ".$table." t ".$query2." WHERE ".$query." 
                    AND t.codigoestado = '100' 
                    AND t.codigocarrera='".$codigocarrera."' ORDER BY 2 ASC"; 
            }
            //echo $sql;
            return $db->GetAll($sql);
    }
    
    public function getDataFormCategoryDynamic($db,$table,$periodo,$tableJoin,$nombreOrder="",$activos=true,$carrera="") {
        /*$sql = "SELECT * FROM siq_".$table." t 
            INNER JOIN siq_detalle".$table." d ON d.idData = t.idsiq_".$table." AND d.codigoestado='100' 
                INNER JOIN ".$tableJoin." s ON s.id".$tableJoin."=d.idCategory AND s.codigoestado='100' 
            WHERE t.codigoestado = '100' ORDER BY t.".$periodo." DESC, d.idData DESC, s.nombre ASC";    */  

        if($activos){
            $where = "WHERE t.codigoestado = '100' ";
        } else {   
            $where = "";
        }
        
        if($where==="" && $carrera!==""){
            $where1 = $where . "WHERE codigocarrera='".$carrera."' ";
        } else if($carrera!==""){
            $where1 = $where . "AND codigocarrera='".$carrera."' ";
        } else {
            $where1 = $where;
        }
        
            $sql2 = "SELECT DISTINCT t.".$periodo." as periodo FROM siq_".$table." t ".$where1;
            
        
        if($nombreOrder===""){
            $sql3 = "SELECT * FROM ".$tableJoin." t ".$where." ORDER BY nombre ASC";
        } else {
            $sql3 = "SELECT * FROM ".$tableJoin." t ".$where." ORDER BY ".$nombreOrder." ASC";
        }
        //var_dump($sql3);

        return array("dataPeriodos" => $db->GetAll($sql2), "actividades"=>$db->GetAll($sql3));
    } 
    
    public function getValorDynamic($db,$table,$periodo,$tableJoin,$valorPeriodo,$idCategory,$campoJoin="",$nombreOrder="nombre",$carrera=""){
        	
        
        $sql = "SELECT * FROM siq_".$table." t 
            INNER JOIN siq_detalle".$table." d ON d.idData = t.idsiq_".$table." AND d.codigoestado='100' 
                AND t.".$periodo."='".$valorPeriodo."' ";
        if($campoJoin===""){
            $sql .= " INNER JOIN ".$tableJoin." s ON s.id".$tableJoin."=d.idCategory AND s.codigoestado='100' AND 
                    s.id".$tableJoin."='".$idCategory."' "; 
        } else {
            $sql .= " INNER JOIN ".$tableJoin." s ON s.".$campoJoin."=d.idCategory AND 
                    s.".$campoJoin."='".$idCategory."' ";
        }
            if($carrera!==""){
                $sql .= "  WHERE t.codigoestado = '100' AND t.codigocarrera='".$carrera."' ORDER BY t.".$periodo." DESC, d.idData DESC, s.".$nombreOrder." ASC"; 
            } else {
                $sql .= "  WHERE t.codigoestado = '100' ORDER BY t.".$periodo." DESC, d.idData DESC, s.".$nombreOrder." ASC"; 
            }
        //var_dump($sql);echo "<br/><br/>";
        return $db->GetRow($sql); 
    }
    
    public function getDataFormCategory($db,$table,$periodo,$tableJoin,$campoJoin) {
        $sql = "SELECT * FROM ".$table." t
                INNER JOIN ".$tableJoin." s ON s.id".$tableJoin."=t.".$campoJoin." AND s.codigoestado='100' 
            WHERE t.codigoestado = '100' ORDER BY t.".$periodo." DESC, t.".$campoJoin." ASC";      

        $sql2 = "SELECT DISTINCT t.".$periodo." as periodo FROM ".$table." t
            WHERE t.codigoestado = '100'";

        return array("data" => $db->GetAll($sql), "dataPeriodos" => $db->GetAll($sql2));
    } 
    
    public function getDataForm($db,$table,$periodo) {  
        $sql = "SELECT * FROM ".$table." WHERE codigoestado = '100' ORDER BY ".$periodo." DESC";
        
        $rows = $db->GetAll($sql);
        
        return $rows;
    }
    
    public function getDataFormPeriodo($db,$table,$periodo) {  
        $sql = "SELECT * FROM ".$table." WHERE codigoperiodo = ".$periodo." "; 
        
        $rows = $db->GetAll($sql);
        
        return $rows;
    }//Sergio
    public function getDataFormMatricu($db,$periodo) {  
        //$sql = "SELECT * FROM ".$table." WHERE  ";
        $sql="SELECT COUNT(ee.codigoestudiante) as total
                FROM estudianteestadistica ee
                INNER JOIN estudiante e ON e.codigoestudiante=ee.codigoestudiante
                INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera 
                WHERE ee.codigoperiodo = ".$periodo."
                and ee.codigoprocesovidaestudiante in(400,401)
                and ee.codigoestado like '1%'
                order by 1;";
        
        $rows = $db->GetAll($sql);
        
        return $rows;
    }//Sergio
    
    public function getFilterReporte($db,$id,$filtro) {  
        $sql = "SELECT * FROM siq_filtroDetalleReporte WHERE idDetalleReporte='".$id."' AND filtro = '".$filtro."' ";
        
        $row = $db->GetRow($sql);
        
        return $row;
    }
    
    public function UltimaColumnaReporte($db,$id) {  
        $num = 0;
        
        $sql = "SELECT numero_columna FROM siq_detalleReporte WHERE idReporte='".$id."' AND codigoestado = '100' ORDER BY numero_columna DESC ";
        
        $row = $db->GetRow($sql);
        if(count($row)>0){
            $num = $row["numero_columna"];
        }
        
        return $num;
    }
    
    public function getFiltroRel($db,$id) {  
        $alias = null;
        
        $sql = "SELECT d.alias FROM siq_relacionData r, siq_data d WHERE r.idDato1='".$id."' AND r.codigoestado = '100' AND d.idsiq_data = r.idDato2 ";

        $row = $db->GetRow($sql);
        if(count($row)>0){
            $alias = $row["alias"];
        }
        
        return $alias;
    }
    
    public function getDatesReport($db,$id) {  
        $fechas = array();
        
        $sql = "SELECT r.periodoFecha, r.fecha_inicial, r.fecha_final, p.valor, p.tipo FROM siq_reporte r 
                left join siq_periodoFechaReporte p ON p.idsiq_periodoFechaReporte=r.periodoFecha AND p.codigoestado='100'
                WHERE r.idsiq_reporte='".$id."' AND r.codigoestado = '100'";
        
        $row = $db->GetRow($sql);
        if(count($row)>0){
            if($row["fecha_inicial"]!=null){
                $sql = "SELECT * FROM periodo WHERE fechainicioperiodo>='".$row["fecha_inicial"]."' ";
                $fechas["fecha_inicial"] = $row["fecha_inicial"];
                if($row["fecha_final"]!=null){
                    $sql = $sql." AND fechavencimientoperiodo<='".$row["fecha_final"]."' ";
                    $fechas["fecha_final"] = $row["fecha_final"];
                }
            } else if($row["fecha_final"]!=null) {
                $sql = "SELECT * FROM periodo WHERE fechavencimientoperiodo<='".$row["fecha_final"]."' ";
                $fechas["fecha_final"] = $row["fecha_final"];
            } else if($row["periodoFecha"]!=null) {
                $currentdate  = date("Y-m-d");
                $fechas["fecha_final"] = $currentdate;
                list($year,$month,$day) = explode("-",$currentdate);
                if(strcmp($row["tipo"], "year")==0){
                    if($row["valor"]==0){   
                        
                        $s = $year.'-01-01 00:00:00';
                        $date = strtotime($s);
                        $fechas["fecha_inicial"] = date('Y-m-d H:i:s', $date); 
                    } else {
                        $fechas["fecha_final"] = $this->calculateCutEnd($currentdate);
                        $fechas["fecha_inicial"] = $this->calculateYear($fechas["fecha_final"],$row["valor"]);
                        $fechas["fecha_inicial"] = $this->calculateCut($fechas["fecha_inicial"]);
                    }
                } else if(strcmp($row["tipo"], "month")==0){
                    if($row["valor"]==0){                        
                        
                        $s = $year.'-'.$month.'-01 00:00:00';
                        $date = strtotime($s);
                        $fechas["fecha_inicial"] = date('Y-m-d H:i:s', $date);                         
                    } else {
                        $fechas["fecha_inicial"] = $this->calculateMonth($fechas["fecha_final"],$row["valor"]);
                    }
                } else {
                    if($row["valor"]==0){
                        //actualmente ¿?
                        $fechas["fecha_inicial"] = $this->calculateCut($currentdate);
                        /*$s = $year.'-'.$month.'-'.$day.' 00:00:00';
                        $date = strtotime($s);
                        $fechas["fecha_inicial"] = date('Y-m-d H:i:s', $date); */
                        $fechas["fecha_final"] = $this->calculateCutEnd($fechas["fecha_final"]);
                    } else {
                        $fechas["fecha_inicial"] = date("Y-m-d", strtotime($currentdate.' '.$row["valor"].' day'));
                    }                    
                }
                
                $sql = "SELECT * FROM periodo WHERE fechainicioperiodo>='".$fechas["fecha_inicial"]."' 
                         AND fechavencimientoperiodo<='".$fechas["fecha_final"]."' ";
            }
            
            $sql = $sql . " ORDER BY fechainicioperiodo ASC ";
            //var_dump($sql);
            //var_dump("<br/><br/>");
            $rows = $db->GetAll($sql);
            if(count($rows)>0){
                $fechas["periodo_inicial"] = $rows[0]["codigoperiodo"];
                $fechas["periodo_final"] = $rows[count($rows)-1]["codigoperiodo"];
            }
        }
        
        return $fechas;
    }
    
    /*********
     * Lo que hace es que me suma solo el mes... 
     * porque php si tengo 31 de enero + 1 mes me da 2 de marzo si febrero tiene 28 dias
     * mientras este método me retorna el 28 de febrero
     */    
    private function calculateMonth($date,$months){
        list($year,$month,$day2) = explode("-",$date);

        // add month here
        $month = $month + $months;
        while($month>12){
            $month = $month-12;
            $year = $year + 1;
        }
        while($month<0){
            $month = $month+12;
            $year = $year - 1;
        }
        
        // to avoid a month-wrap, set the day to the number of days of the new month if it's too high
        $day = min($day2,date("t",strtotime($year."-".$month."-01"))); 

        $date = $year."-".$month."-".$day;
        
        return $date;
    }
    
    /**
     *
     * @param string $date --> fecha inicial
     * @param type $day2 --> dia predefinido 
     * @param type $years --> años a sumar
     * @param type $fin_mes --> si el dia siempre es a fin de mes o no
     * @return string 
     */
    private function calculateYear($date,$years){
        list($year,$month,$day2) = explode("-",$date);
        
        // add year here
        $year = $year + $years;
                
        // to avoid a month-wrap, set the day to the number of days of the new month if it's too high
        $day = min($day2,date("t",strtotime($year."-".$month."-01"))); 

        $date = $year."-".$month."-".$day;
        
        return $date;
    }
    
    private function calculateCut($date){
        list($year,$month,$day) = explode("-",$date);

        $date = $year."-".$month."-".$day;
        
        //Para que me traiga el periodo del primer corte también
        if($month>1 && $month<7){
            $date = $year."-01-01";//.$day;
        } else if($month>7 && $month<12){
            $date = $year."-07-01";//.$day;
        }
        
        return $date;
    }
    
    private function calculateCutEnd($date){
        list($year,$month,$day) = explode("-",$date);

        $date = $year."-".$month."-".$day;
        
        //Para que me traiga el periodo del primer corte también
        if($month>1 && $month<7){
            $date = $year."-07-01";//.$day;
        } else if($month>7 && $month<12){
            $date = $year."-12-".$day;
        }
        
        return $date;
    }
    
    public function getYearsSelect($periodo="periodo",$selected=null){
            $yearInit = date("Y");
            
            echo "<select name='".$periodo."' id='".$periodo."' style='font-size:0.8em'>";
            for($i = 0; $i < 30; ++$i) {
                $year = $yearInit - $i;
                if($year==$yearInit && $selected==null){
                    echo "<option value='".$year."' selected>".$year."</option>";
                } else if($selected!=null && $year==$selected){
                    echo "<option value='".$year."' selected>".$year."</option>";
                } else {
                    echo "<option value='".$year."'>".$year."</option>";
                }
            }
            echo "</select>";
    }
    
    public function getYears($fechaInicio, $fechaFinal){
        $Y_date = split("-",$fechaInicio);
        $yearInit = $Y_date[0];
        
        $Y_date = split("-",$fechaFinal);
        $yearEnd = $Y_date[0];
        
        $years = array();
        $year = $yearInit+1;
            while($year <= $yearEnd) {
                $years[] = $year;
                $year = $year+1;
            }
        return $years;
    }
    
    public function getMonthsSelect($mes="mes",$imp=false,$funcion=''){
	    $arrMonths = array(	 1=>'Enero'	,2=>'Febrero'	,3=>'Marzo'	,4=>'Abril'	
	      			,5=>'Mayo'	,6=>'Junio'	,7=>'Julio'	,8=>'Agosto'
	    			,9=>'Septiembre',10=>'Octubre'	,11=>'Noviembre',12=>'Diciembre' );
	    if($imp) {
		return $arrMonths[$mes];
	    } else {
                $monthInit = date("m");
                if($funcion===""){
					echo "<select name='".$mes."' id='".$mes."' style='font-size:0.8em' onchange='".$funcion."'> ";
				} 
				else {
					echo "<select name='".$mes."' id='".$mes."' style='font-size:0.8em'  onchange='".$funcion."'>";
				}
	        foreach ($arrMonths as $key => $value) {
		    $selected=($key==$monthInit)?" selected":"";
                    echo "<option value='".$key."' ".$selected.">".$value."</option>";
                }
                echo "</select>";
	    }
    }
    
    public function getSemestresSelect($db,$periodo="codigoperiodo",$emptyOption=false,$selected=null,$funcion='',$periodolimite=''){//echo '<pre>';print_r($db);
            $yearInit = date("Y");
            $yearInit = $yearInit - 30;
            $periodoInit = $yearInit. "1";
            
            if($periodolimite!=''){
            $inicioperiodo="and codigoperiodo >='".$periodolimite."'";
            }
            
            $sql = "SELECT * FROM periodo WHERE codigoperiodo>='".$periodoInit."' AND fechainicioperiodo<='".date('Y-m-d H:i:s')."'
                         AND fechainicioperiodo!='0000-00-00 00:00:00'
                         $inicioperiodo
                         ORDER BY fechainicioperiodo DESC";
            $rows = $db->GetAll($sql);
            
            $num = count($rows);
            
            echo "<select name='".$periodo."' id='".$periodo."' class='required' style='font-size:0.8em'onchange='".$funcion."'  >"; 
            if($emptyOption){  echo "<option value=''></option>"; }
            for($i = 0; $i < $num; ++$i) {
                 $arrayP = str_split($rows[$i]["codigoperiodo"], strlen($rows[$i]["codigoperiodo"])-1);
                    $labelPeriodo = $arrayP[0]."-".$arrayP[1];
                if(($i==0 && !$emptyOption) || $selected==$rows[$i]["codigoperiodo"]){
                    echo "<option value='".$rows[$i]["codigoperiodo"]."' selected>".$labelPeriodo."</option>";
                } else {
                    if($selected==$rows[$i]["codigoperiodo"]){
                        echo "<option value='".$rows[$i]["codigoperiodo"]."' selected>".$labelPeriodo."</option>";
                    } else {
                        echo "<option value='".$rows[$i]["codigoperiodo"]."'>".$labelPeriodo."</option>";
                    }
                }
            }
            echo "</select>";
    }
    
    public function getMesesPeriodo($db,$codigoperiodo,$year=false){
                $periodos = "";
        if(!$year){
            $sql = "SELECT * FROM periodo WHERE codigoperiodo='".$codigoperiodo."'";
            $row = $db->GetRow($sql);
            if($row!=NULL && count($row)>0){
                $date = $row["fechainicioperiodo"];
                $mInicial = intval(date("m", strtotime($date)));
                $year = date("Y", strtotime($date));
                $date = $row["fechavencimientoperiodo"];
                $mFin = intval(date("m", strtotime($date)));
                for($i=$mInicial;$i<=$mFin;$i++){
                    if($periodos===""){
                        $periodos = "('".$i."-".$year."'";
                    } else {
                        $periodos .= ",'".$i."-".$year."'";
                    }
                }
                $periodos .= ")";
            }

        } else {
            for($i=1;$i<=12;$i++) {
            if($periodos===""){
                        $periodos = "('".$i."-".$codigoperiodo."'";
                    } else {
                        $periodos .= ",'".$i."-".$codigoperiodo."'";
                    }
            }
            $periodos .= ")";
        }
        return $periodos;
    }
    
    
    
    public function roundNumber($percent,$number){
        $result = round($number, 2);
        if(round(($percent+$result), 2)>round(100, 2)){
             $result = floor($number * 100) / 100;
        } else if (round(($percent+$result), 2)<round(100, 2)){
             $result = ceil($number * 100) / 100;
        } 
        return $result;
    }
    
    public function inactivateColumns($db,$id, $numColumnas) {  
        $currentdate  = date("Y-m-d H:i:s");
        $userid = $this->getUser();
        $userid = $userid["idusuario"];
        $sql = "UPDATE siq_detalleReporte SET `codigoestado`=200, `fecha_modificacion`='".$currentdate."', 
            `usuario_modificacion`='".$userid."' WHERE `idReporte`='".$id."' AND numero_columna>'".$numColumnas."'";
        
        return $db->Execute($sql);
    }
    
    public function inactivateAllFilters($db,$id) {  
        $currentdate  = date("Y-m-d H:i:s");
        $userid = $this->getUser();
        $userid = $userid["idusuario"];
        $sql = "UPDATE siq_filtroDetalleReporte SET `codigoestado`=200, `fecha_modificacion`='".$currentdate."', 
            `usuario_modificacion`='".$userid."' WHERE `idDetalleReporte`='".$id."'";
        
        return $db->Execute($sql);
    }
    
    public function getDataEntity($table,$id,$prefix="siq_",$idColumn=null) {
        $entity = new ManagerEntity($table,$this->rutaProyecto);  
        if($idColumn==null){
            $idColumn = "id".$prefix.$table;
        }
        $entity->sql_where = $idColumn." = ".$id."";
        $entity->prefix = $prefix;
		//if($table==="carrera"){
       // $entity->debug = true;
		//}
        $data = $entity->getData();
        $data = $data[0];
        
        return $data;
    }
    
    public function getDataEntityByAlias($table,$alias,$prefix="siq_") {
        $entity = new ManagerEntity($table,$this->rutaProyecto);  
        $entity->sql_where = "alias = '".$alias."'";
        $entity->prefix = $prefix;
        //$entity->debug = true;
        $data = $entity->getData();
        $data = $data[0];
        
        return $data;
    }   
    
    public function getDataEntityByQuery($table,$queryField,$value,$prefix="siq_",$carrera=null,$planEstudio=null) {
        $entity = new ManagerEntity($table,$this->rutaProyecto);  
		/*if($table==="formTalentoHumanoPersonalPrestacionServiciosCostoServicios"){
			print_r($entity);
		}*/
        if($carrera==null){
            $entity->sql_where = $queryField." = '".$value."' ";
        } else {
            $entity->sql_where = $queryField." = '".$value."' AND codigocarrera = '".$carrera."'";
        }
        if($planEstudio!=null){
            $entity->sql_where = $entity->sql_where." AND planEstudio = '".$planEstudio."'";
        }
        $entity->prefix = $prefix;
		/*if($table==="formTalentoHumanoPersonalPrestacionServiciosCostoServicios"){
			echo $entity->sql_where;
			$entity->debug = true;
		}*/
        //$entity->debug = true;
        $data = $entity->getData();
        $data = $data[0];
        
        return $data;
    }  
    
    public function getDataValue($db,$data,$cat,$filtros=null,$filtrosValores=null){  
        if($data["tipo_data"]==1){
            include_once("../datos/".$cat["alias"]."/datosClass.php");
            include_once("../datos/".$cat["alias"]."/mostrarClass.php");
        } else {
            //include_once("../datos/".$cat["alias"]."/datosClass.php");
            include_once("../informacion/".$cat["alias"]."/informacionClass.php");
            include_once("../informacion/".$cat["alias"]."/mostrarInfoClass.php");
        }
        
        if($data["tipo_data"]==1){
            $datos = new datosClass();
            $datos->initialize($db);
            $display = new mostrarClass();
            $datosQuery = array();
            $metodo = 'get'.ucfirst($data["alias"]);
            $metodoD = "display".ucfirst($data["alias"]);
            if(method_exists($datos,$metodo)){
                $datosQuery = $datos->$metodo($filtros,$filtrosValores);
            }
            
            $datosF = array();
            $num = count($datosQuery);
            for ($i = 0; $i < $num; $i++) 
            {    
                $res['label']=$display->$metodoD($datosQuery[$i]);
                //en cero siempre debe estar el id
                $res['value']=$datosQuery[$i][0];

                array_push($datosF,$res);
            }
            return $datosF;
            
        } else {
            $datos = new informacionClass();
            $datos->initialize($db);
            $display = new mostrarInfoClass();
            $metodo = 'get'.ucfirst($data["alias"]);
            $metodoD = "display".ucfirst($data["alias"]);
            //var_dump($metodo);
            if(method_exists($datos,$metodo)){
                $datosQuery = $datos->$metodo($filtros,$filtrosValores);
                //var_dump($datosQuery);
            }
            
            $datosF = array();
            $num = count($datosQuery);
            for ($i = 0; $i < $num; $i++) 
            {    
                if(method_exists($display,$metodoD)){                    
                    $res['label']=$display->$metodoD($datosQuery[$i]);
                    //en cero siempre debe estar el id
                    $res['value']=$datosQuery[$i][0];
                } else {
                    $res['label']=$datosQuery[$i];
                    $res['value']=$datosQuery[$i];
                }
                array_push($datosF,$res);                
            }
            return $datosF;
        }
    }
    
    public function viewForm($db,$formulario,$cat,$id="",$class=""){  
        include_once("../formularios/".$cat["alias"]."/buildFormClass.php");
        //include_once("../formularios/".$cat["alias"]."/mostrarClass.php");

        $form = new buildFormClass();
        $form->initialize($db,$this);
            
        $metodo = 'getForm'.ucfirst($formulario["alias"]);
        //$metodoD = "display".ucfirst($data["alias"]);

        if(method_exists($form,$metodo)){
            $form->$metodo($formulario,$id,$class);
        }
        
        //return $datosF;
    }
    
    public function getActives($db,$table,$order="",$orderType="ASC",$asArray=false) {  
        $sql = "";
        if($order!=""){
            $sql = "select * from ".$table." where codigoestado = '100' ORDER BY ".$order." ".$orderType;
        } else {
            $sql = "select * from ".$table." where codigoestado = '100'";            
        } 

        if($asArray){
            $rows = $db->GetAll($sql);
        } else {
            $rows = $db->Execute($sql);
        }
        
        return $rows;
    }
    
    public function getAll($db,$table,$query="",$order="",$orderType="ASC",$asArray=false) {  
        $sql = "select * from ".$table;
        if($query!=""){
            $sql .= " where ".$query;
        }
        if($order!=""){
            $sql .= " ORDER BY ".$order." ".$orderType;
        } 
        
        if($asArray){
            $rows = $db->GetAll($sql);
        } else {
            $rows = $db->Execute($sql);
        }
        
        return $rows;
    }
	
	public function pintarBotonCargar($onClickAction,$onClickSee=""){ 

        echo '<div class="vacio"></div>';
        
        echo '<div class="cargarArchivos" onmouseover="cargarArchivos(this)" title="">';

        echo '<input type="button" value="Cargar archivo de soporte" name="uploadFile" onClick="'.$onClickAction.'" class="small" style="float:right;margin-bottom:10px;margin-right:4%;"/>';  

        echo '</div>';

        echo '<div class="verArchivos" onmouseover="verArchivos(this)" title="">';

        echo '<input type="button" value="Ver archivos de soporte" name="seeFiles" onClick="'.$onClickSee.'" class="small" style="float:right;margin-bottom:10px;margin-right:0;"/>';  
        
        echo '</div>';

        echo '<div class="vacio"></div>';
    }
    
    public function getDataPermisos($db){
        $sql = "SELECT * FROM siq_gestionPermisosMGI gp 
            inner join usuario u on u.usuario='".$_SESSION['MM_Username']."' 
               INNER JOIN siq_rolesMGI r ON r.idsiq_rolesMGI=gp.idRol 
            WHERE (gp.idUsuario=u.idusuario or gp.usuario =u.usuario) AND gp.codigoestado=100 AND gp.idRol!=2";
        
        $result = $db->getRow($sql);
        $pemisos = array();
        if($result!=NULL && count($result)>0){
            $pemisos["rol"] = array($result["idRol"],$result["nombre"]);
            $pemisos["formulario"] = $result["idFormulario"];
        }
        return $pemisos;
    }
    
    public function getUser(){
        if(!isset($_SESSION['MM_Username'])){
            //$_SESSION['MM_Username'] = 'admintecnologia';
            echo "No ha iniciado sesión en el sistema"; die();
        }
        $entity = new ManagerEntity("usuario",$this->rutaProyecto);
        $entity->sql_select = "idusuario,usuario,nombres,apellidos";
        $entity->prefix ="";
        $entity->sql_where = " usuario='".$_SESSION['MM_Username']."' ";
        
        $data = $entity->getData();
        $user = $data[0];
        
        return $user;
    }    

   public function getDataFormTestuTadmon($db,$periodo) {  

        

         $sql="SELECT COUNT(ee.codigoestudiante) as total,( SELECT numadministrativos fROM siq_formTalentoHumanoNumeroPersonas WHERE codigoperiodo = ".$periodo.") AS totaladmon

                FROM estudianteestadistica ee

                INNER JOIN estudiante e ON e.codigoestudiante=ee.codigoestudiante

                INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera

                WHERE ee.codigoperiodo = ".$periodo."

                and ee.codigoprocesovidaestudiante in(400,401)

                and ee.codigoestado like '1%'

                order by 1";

        

        $rows = $db->GetAll($sql);

       

        return $rows;

    }//Sergio

   public function getDataViewTacadEspe($db,$periodo) { 

        /* $sql="select numAcademicosMaestriaMedico, numAcademicosEspecializacionMedico, numAcademicosProfesionalMedico,
                
                numAcademicosTecnicoMedico, numAcademicosLicenciadoMedico, numAcademicosNoTituloMedico

                from siq_formTalentoHumanoDocentesFormacion

                where codigoperiodo=".$periodo;

        // echo $sql;

        $rows = $db->GetAll($sql);

       

        return $rows;
        */
        
        $periodos = substr($periodo,-1);
			//var_dump($periodos);
			if($periodos==1 || $periodos=="1"){
				$mes = "3-".substr($periodo,0,strlen($periodo)-1);
			} else {
				$mes = "9-".substr($periodo,0,strlen($periodo)-1);
			}
			//el orden es para que me lea como numeros la primera parte del string de codigoperiodo
			$sql = "SELECT * FROM siq_formTalentoHumanoDocentesFormacion WHERE codigoestado=100 AND codigoperiodo='$mes'";
			//echo $sql;
			$row = $db->GetRow($sql);
			if($row!=NULL && count($row)>0){
			
			} else {
				$periodos = $this->getMesesPeriodo($db,$periodo);
				$sql = "SELECT * FROM siq_formTalentoHumanoDocentesFormacion WHERE codigoestado=100 AND codigoperiodo IN $periodos ORDER BY SUBSTRING_INDEX(codigoperiodo, '-', 1) DESC, CAST(SUBSTRING_INDEX(codigoperiodo, '-', 1) AS SIGNED)";
				$row = $db->GetRow($sql);
				if(!($row!=NULL && count($row)>0)){
					$row["numAcademicosDoctoradoMedico"] = 0;
					$row["numAcademicosMaestriaMedico"] = 0;
					$row["numAcademicosEspecializacionMedico"] = 0;
					$row["numAcademicosProfesionalMedico"] = 0;
					$row["numAcademicosLicenciadoMedico"] = 0;
					$row["numAcademicosTecnicoMedico"] = 0;
					$row["numAcademicosNoTituloMedico"] = 0;
				}
			}
        return $row;

    }  
	
	public function getSubperiodo($db,$anio,$mes){
		$fecha=$anio."-".$mes."-15";
		
		$query="select idsubperiodo
			from subperiodo
			where idtiposubperiodo=5
				and codigoestadosubperiodo='100'
				and '".$fecha."' between fechainicioacademicosubperiodo and fechafinalacademicosubperiodo";
				
				$row=$db->GetRow($query);
				return $row["idsubperiodo"];
	}
    
    public function getDataViewPresServ($db,$periodo){
        
         $periodos = substr($periodo,-1);
		 $anio = substr($periodo,0,strlen($periodo)-1);
			//var_dump($periodos);
			if($periodos==1 || $periodos=="1"){
				$idsuperiodo = $this->getSubperiodo($db,$anio,3);
			} else {
				$idsuperiodo = $this->getSubperiodo($db,$anio,9);
			}
			//el orden es para que me lea como numeros la primera parte del string de codigoperiodo
			$sql = "SELECT ps.*,aps.nombre FROM siq_formTalentoHumanoPersonalPrestacionServicios ps 
				INNER JOIN siq_actividadPrestacionServicios aps on aps.idsiq_actividadPrestacionServicios=ps.idActividad AND aps.codigoestado=100 
			WHERE ps.codigoestado=100 AND ps.idsubperiodo='$idsuperiodo'";
			//echo $sql;
			$rows = $db->GetAll($sql);
			
			$sql = "SELECT * FROM siq_formTalentoHumanoPersonalPrestacionServiciosCostoServicios ps 
			WHERE ps.codigoestado=100 AND ps.idsubperiodo='$idsuperiodo'";
			//echo $sql;
			$valor = $db->GetRow($sql);
        return array($rows,$valor);
    }
    
    public function getDataViewExtran($db,$periodo){
	
         $periodos = substr($periodo,-1);
		 $anio = substr($periodo,0,strlen($periodo)-1);
			//var_dump($periodos);
			if($periodos==1 || $periodos=="1"){
				$mes = "3-".$anio;
			} else {
				$mes = "9-".$anio;
			}
			//el orden es para que me lea como numeros la primera parte del string de codigoperiodo
			$sql = "SELECT dps.*,aps.nombre FROM siq_formTalentoHumanoAcademicosExtranjerosFacultad ps 
				INNER JOIN siq_detalleformTalentoHumanoAcademicosExtranjerosFacultad dps on dps.idData=ps.idsiq_formTalentoHumanoAcademicosExtranjerosFacultad and dps.codigoestado=100
				INNER JOIN siq_unidadAdministrativa aps on aps.idsiq_unidadAdministrativa=dps.idCategory AND aps.codigoestado=100 
				WHERE ps.codigoestado=100 AND ps.codigoperiodo='$mes' ORDER BY aps.nombre ASC";
				//echo $sql;
			$rows = $db->GetAll($sql);
			if($rows!=NULL && count($rows)>0){
			
			} else {
				$periodos = $this->getMesesPeriodo($db,$periodo);
				$sql = "SELECT dps.*,aps.nombre FROM siq_formTalentoHumanoAcademicosExtranjerosFacultad ps 
				INNER JOIN siq_detalleformTalentoHumanoAcademicosExtranjerosFacultad dps on dps.idData=ps.idsiq_formTalentoHumanoAcademicosExtranjerosFacultad and dps.codigoestado=100
				INNER JOIN siq_unidadAdministrativa aps on aps.idsiq_unidadAdministrativa=dps.idCategory AND aps.codigoestado=100 
				WHERE ps.codigoestado=100 AND ps.codigoperiodo IN $periodos 
				AND CAST(SUBSTRING_INDEX(ps.codigoperiodo, '-', 1) AS SIGNED) IN 
				(
				SELECT MAX(CAST(SUBSTRING_INDEX(ps.codigoperiodo, '-', 1) AS SIGNED))  
					FROM siq_formTalentoHumanoAcademicosExtranjerosFacultad ps 
					INNER JOIN siq_detalleformTalentoHumanoAcademicosExtranjerosFacultad dps on dps.idData=ps.idsiq_formTalentoHumanoAcademicosExtranjerosFacultad and dps.codigoestado=100
					INNER JOIN siq_unidadAdministrativa aps on aps.idsiq_unidadAdministrativa=dps.idCategory AND aps.codigoestado=100 
					WHERE ps.codigoestado=100 AND ps.codigoperiodo IN $periodos 
				)
				GROUP BY dps.idCategory 
				ORDER BY aps.nombre ASC";
				//echo $sql;
				$rows = $db->GetAll($sql);
			}
        return $rows;        
        
    }
	
	public function getDataViewExtranjerosPais($db,$periodo){
	
         $periodos = substr($periodo,-1);
		 $anio = substr($periodo,0,strlen($periodo)-1);
			//var_dump($periodos);
			if($periodos==1 || $periodos=="1"){
				$mes = "3-".$anio;
			} else {
				$mes = "9-".$anio;
			}
			//el orden es para que me lea como numeros la primera parte del string de codigoperiodo
			$sql = "SELECT dps.*,aps.nombrepais FROM siq_formTalentoHumanoAcademicosExtranjerosPais ps 
				INNER JOIN siq_detalleformTalentoHumanoAcademicosExtranjerosPais dps on dps.idData=ps.idsiq_formTalentoHumanoAcademicosExtranjerosPais and dps.codigoestado=100
				INNER JOIN pais aps on aps.idpais=dps.idCategory AND aps.codigoestado=100 
				WHERE ps.codigoestado=100 AND ps.codigoperiodo='$mes' ORDER BY aps.nombrepais ASC";
				//echo $sql;
			$rows = $db->GetAll($sql);
			if($rows!=NULL && count($rows)>0){
			
			} else {
				$periodos = $this->getMesesPeriodo($db,$periodo);
				$sql = "SELECT dps.*,aps.nombrepais FROM siq_formTalentoHumanoAcademicosExtranjerosPais ps 
				INNER JOIN siq_detalleformTalentoHumanoAcademicosExtranjerosPais dps on dps.idData=ps.idsiq_formTalentoHumanoAcademicosExtranjerosPais and dps.codigoestado=100
				INNER JOIN pais aps on aps.idpais=dps.idCategory AND aps.codigoestado=100 
				WHERE ps.codigoestado=100 AND ps.codigoperiodo IN $periodos 
				AND CAST(SUBSTRING_INDEX(ps.codigoperiodo, '-', 1) AS SIGNED) IN 
				(
				SELECT MAX(CAST(SUBSTRING_INDEX(ps.codigoperiodo, '-', 1) AS SIGNED))  
					FROM siq_formTalentoHumanoAcademicosExtranjerosPais ps 
					INNER JOIN siq_detalleformTalentoHumanoAcademicosExtranjerosPais dps on dps.idData=ps.idsiq_formTalentoHumanoAcademicosExtranjerosPais and dps.codigoestado=100
					INNER JOIN pais aps on aps.idpais=dps.idCategory AND aps.codigoestado=100 
					WHERE ps.codigoestado=100 AND ps.codigoperiodo IN $periodos 
				)
				GROUP BY dps.idCategory 
				ORDER BY aps.nombrepais ASC";
				//echo $sql;
				$rows = $db->GetAll($sql);
			}
        return $rows;        
        
    }
	
	public function getDataIndiceSelectividadDocentes($db,$periodo){
	
         $periodos = substr($periodo,-1);
		 $anio = substr($periodo,0,strlen($periodo)-1);
			//var_dump($periodos);
			if($periodos==1 || $periodos=="1"){
				$mes = "3-".$anio;
			} else {
				$mes = "9-".$anio;
			}
			//el orden es para que me lea como numeros la primera parte del string de codigoperiodo
			$sql = "SELECT ps.*,aps.nombre FROM siq_formTalentoIndiceSelectividad ps 
				INNER JOIN siq_dedicacionPersonal aps on aps.idsiq_dedicacionPersonal=ps.idDedicacion AND aps.codigoestado=100 
				WHERE ps.codigoestado=100 AND ps.codigoperiodo='$mes' ORDER BY aps.nombre ASC";
				//echo $sql;
			$rows = $db->GetAll($sql);
			if($rows!=NULL && count($rows)>0){
			} else {
				$periodos = $this->getMesesPeriodo($db,$periodo);
				$sql = "SELECT ps.*,aps.nombre FROM siq_formTalentoIndiceSelectividad ps 
				INNER JOIN siq_dedicacionPersonal aps on aps.idsiq_dedicacionPersonal=ps.idDedicacion AND aps.codigoestado=100 
				WHERE ps.codigoestado=100 AND ps.codigoperiodo IN $periodos 
				AND CAST(SUBSTRING_INDEX(ps.codigoperiodo, '-', 1) AS SIGNED) IN 
				(
				SELECT MAX(CAST(SUBSTRING_INDEX(ps.codigoperiodo, '-', 1) AS SIGNED))  
					FROM siq_formTalentoIndiceSelectividad ps 
					INNER JOIN siq_dedicacionPersonal aps on aps.idsiq_dedicacionPersonal=ps.idDedicacion AND aps.codigoestado=100 
					WHERE ps.codigoestado=100 AND ps.codigoperiodo IN $periodos  
				)
				GROUP BY ps.idDedicacion 
				ORDER BY aps.idsiq_dedicacionPersonal ASC";
				//echo $sql;
				$rows = $db->GetAll($sql);
			}
        return $rows;        
        
    }
    
     public function getSalonesPerio($db,$periodo){
        $sql="SELECT sum(cantidad) as total
                FROM siq_tecnologia AS t
                INNER JOIN  siq_clasificacionesinfhuerfana as i ON (i.idclasificacionesinfhuerfana=t.idpadreclasificacionesinfhuerfana)
                WHERE i.aliasclasificacionesinfhuerfana='T_DSREA' and t.codigoperiodo like '%$periodo%'
                group by t.idpadreclasificacionesinfhuerfana";
      //  echo $sql;
        $rows = $db->GetAll($sql);
        return $rows;
 
    }
    
     public function getSalones($db){
        $sql="SELECT sum(cantidad) as total
                FROM siq_tecnologia AS t
                INNER JOIN  siq_clasificacionesinfhuerfana as i ON (i.idclasificacionesinfhuerfana=t.idpadreclasificacionesinfhuerfana)
                WHERE i.aliasclasificacionesinfhuerfana='T_DSREA' 
                group by t.idpadreclasificacionesinfhuerfana";
      //  echo $sql;
        $rows = $db->GetAll($sql);
        return $rows;
 
    }
    
    public function getDataViewCursosEC($db,$periodo){
        $sql="select num_abierto, num_cerrado, num_pres, e.idclasificacion, clasificacion
                from siq_educacioncontinuadaprogramasinfhuerfana as e
                inner join infoEducacionContinuada as i on (i.idclasificacion=e.idclasificacion)
                join (
                        select idclasificacion
                        from infoEducacionContinuada
                        where alias='program'
                ) sub on i.idpadreclasificacion=sub.idclasificacion
                where e.periodicidad like '%$periodo%' ";
       $rows = $db->GetAll($sql);
       return $rows;
        
    }
    
    public function  getDataViewInvestigaciones($db,$periodo){
        
        $sql="select c.idclasificacionesinfhuerfana,c.clasificacionesinfhuerfana,
                        presupuestado, ejecutado
             from siq_clasificacionesinfhuerfana as c
             INNER JOIN siq_ofpresupuestos as p 
             ON (c.idclasificacionesinfhuerfana=p.idclasificacionesinfhuerfana)
             where c.idpadreclasificacionesinfhuerfana in 
             (select idclasificacionesinfhuerfana from siq_clasificacionesinfhuerfana 
             where aliasclasificacionesinfhuerfana='P_INV_A_CON') and anioperiodo='".$periodo."'";
        
        $rows = $db->GetAll($sql);

        return $rows;
        
    }
    public function getDataViewTacadForm($db,$periodo) { 

         $periodos = substr($periodo,-1);
			//var_dump($periodos);
			if($periodos==1 || $periodos=="1"){
				$mes = "3-".substr($periodo,0,strlen($periodo)-1);
			} else {
				$mes = "9-".substr($periodo,0,strlen($periodo)-1);
			}
			//el orden es para que me lea como numeros la primera parte del string de codigoperiodo
			$sql = "SELECT * FROM siq_formTalentoHumanoDocentesFormacion WHERE codigoestado=100 AND codigoperiodo='$mes'";
			//echo $sql;
			$row = $db->GetRow($sql);
			if($row!=NULL && count($row)>0){
			
			} else {
				$periodos = $this->getMesesPeriodo($db,$periodo);
				$sql = "SELECT * FROM siq_formTalentoHumanoDocentesFormacion WHERE codigoestado=100 AND codigoperiodo IN $periodos ORDER BY SUBSTRING_INDEX(codigoperiodo, '-', 1) DESC, CAST(SUBSTRING_INDEX(codigoperiodo, '-', 1) AS SIGNED)";
				$row = $db->GetRow($sql);
				if(!($row!=NULL && count($row)>0)){
					$row["numAcademicosEnDoctorado"] = 0;
					$row["numAcademicosEnMaestria"] = 0;
					$row["numAcademicosEnEspecializacion"] = 0;
				}
			}
        return $row;

    }//Sergio
   
    public function getDataFormEquipoEstu($db,$periodo) { 

        

         $sql="select sum(b.cantidad) Total_PC ,(SELECT COUNT(ee.codigoestudiante) FROM estudianteestadistica ee

                INNER JOIN estudiante e ON e.codigoestudiante=ee.codigoestudiante

                INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera

                WHERE ee.codigoperiodo = ".$periodo."

                and ee.codigoprocesovidaestudiante in(400,401)

                and ee.codigoestado like '1%'

                order by 1) as Total_Estu

                from siq_clasificacionesinfhuerfana a,siq_tecnologia b

                where a.idclasificacionesinfhuerfana= b.idclasificacionesinfhuerfana

                and a.idpadreclasificacionesinfhuerfana = 505

                and b.codigoperiodo = ".$periodo;

        

        $rows = $db->GetAll($sql);

       

        return $rows;

    }//Sergio
    
    public function UsuarioAprueba_FormHuerfana($db,$user_name) {  
        
        
        $sql = "select * from siq_gestionPermisosMGI gp 
            inner join usuario u on u.usuario='".$user_name."' 
            where (gp.idUsuario=u.idusuario or gp.usuario=u.usuario) and idRol=3 and codigoestado like '1%'";
               
        $row = $db->GetRow($sql);
        if(count($row)>0){
        
	  return true;
        
        }
        
    }
    
    public function esAdministradorMGI($db,$user_name) {  
        $sql = "select * from siq_gestionPermisosMGI gp 
            inner join usuario u on u.usuario='".$user_name."' 
            where (gp.idUsuario=u.idusuario or gp.usuario =u.usuario) and idRol=1 and codigoestado like '1%'";
               
        $row = $db->GetRow($sql);
        if(count($row)>0){
        
	  return true;
        
        }
        return false;
    }
    
    public function getUsuariosRol($db,$idRol,$query=false){
		if($idRol==1){
                    //administrador
                    $sql = "select u.usuario, u.idusuario, CONCAT(u.nombres,' ',u.apellidos) as nombre
				from menuopcion m, permisousuariomenuopcion pum, detallepermisomenuopcion dpum, usuario u 
                                inner join siq_gestionPermisosMGI gp on (gp.idUsuario=u.idusuario or gp.usuario=u.usuario) 
                                AND gp.idRol='".$idRol."' AND gp.codigoestado='100' 
				where pum.idpermisomenuopcion = dpum.idpermisomenuopcion
				and pum.codigoestado like '1%'
				and m.codigoestadomenuopcion like '01%'
				and dpum.codigoestado like '1%'
				and m.idmenuopcion = dpum.idmenuopcion
				and m.transaccionmenuopcion = 'MGI-GD-ROL' AND u.idusuario=pum.idusuario  
				order by nombre ASC";
                } else if($idRol==2){
                    //lider de factor
                    $sql = "select u.usuario, u.idusuario, CONCAT(u.nombres,' ',u.apellidos) as nombre
				from menuopcion m, permisousuariomenuopcion pum, detallepermisomenuopcion dpum, usuario u 
                                inner join siq_gestionPermisosMGI gp on (gp.idUsuario=u.idusuario or gp.usuario=u.usuario) 
                                AND gp.idRol='".$idRol."' AND gp.codigoestado='100' 
				where pum.idpermisomenuopcion = dpum.idpermisomenuopcion
				and pum.codigoestado like '1%'
				and m.codigoestadomenuopcion like '01%'
				and dpum.codigoestado like '1%'
				and m.idmenuopcion = dpum.idmenuopcion
				and m.transaccionmenuopcion = 'MGI-AC-GD' AND u.idusuario=pum.idusuario  
				order by nombre ASC";
                }else if($idRol==3 || $idRol==4){
                    //coordinador y usuarios de info huérfana
                    $sql = "select u.usuario, u.idusuario, CONCAT(u.nombres,' ',u.apellidos) as nombre
				from menuopcion m, permisousuariomenuopcion pum, detallepermisomenuopcion dpum, usuario u 
                                inner join siq_gestionPermisosMGI gp on (gp.idUsuario=u.idusuario or gp.usuario=u.usuario) 
                                AND gp.idRol='".$idRol."' AND gp.codigoestado='100' 
				where pum.idpermisomenuopcion = dpum.idpermisomenuopcion
				and pum.codigoestado like '1%'
				and m.codigoestadomenuopcion like '01%'
				and dpum.codigoestado like '1%'
				and m.idmenuopcion = dpum.idmenuopcion
				and m.transaccionmenuopcion = 'MGI-GD-RI' AND u.idusuario=pum.idusuario  
				order by nombre ASC";
                }
                //var_dump($sql);
		if($query){
			return $sql;
		} else {
			$result = $db->GetAll($sql);
			return $result;
		}
	}
        
        public function getIDsMenuMGI($db,$rol,$add=false){
            if($rol===0 || $rol===1){
                $ids = "'MGI','MGI-GD-ROL','MGI-AC-GD','MGI-GD-RI','MGI-AC','MGI-GD'";
            } else if($rol==2) {
                $ids = "'MGI-AC-GD','MGI-AC'";
                if($add){
                    $ids.=",'MGI','GSIQ'";
                }
            } else {
                $ids = "'MGI-GD-RI','MGI-GD'";
                if($add){
                    $ids.=",'MGI','GSIQ'";
                }
            }
                $sql = "SELECT idmenuopcion FROM menuopcion WHERE transaccionmenuopcion IN ($ids)";
		$id = $db->GetAll($sql);
		
		return $id;
	}
 
    function __destruct() {
        
    }

}

?>
