<?php

    $ruta = "../";
    while (!is_file($ruta.'Connections/sala2.php'))
    {
        $ruta = $ruta."../";
    }
    require_once($ruta.'Connections/sala2.php');
    $rutaado = $ruta."funciones/adodb/";
    require_once($ruta.'Connections/salaado.php');
    global $db; 
    
class Utils_Certificados {
    private static $instance = NULL;
    private $db = NULL;
    private $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    private $maxCols = 5;
	
    
    private function __construct() {
        global $db;
        $this->db = $db;
    }
	
	public static function getInstance() {
		if(!isset(self::$instance)) {
		  self::$instance = new Utils_Certificados();
		}
		return self::$instance;
	}
        
        public function getFechaActual(){
            return date("d/m/Y");
        }
        
        public function getFechaActualTexto(){
            $dias = array("al primer (1) día", "a los dos (2) días", "a los tres (3) dias", "a los cuatro (4) días", "a los cinco (5) días", 
                "a los seis (6) días", "a los siete (7) días", "a los ocho (8) días", "a los nueve (9) días", "a los diez (10) días",
                "a los once (11) días", "a los doce (12) días", "a los trece (13) días", "a los catorce (14) días", "a los quince (15) días",
                "a los dieciséis (16) dias", "a los diecisiete (17) días", "a los dieciocho (18) días", "a los diecinueve (19) días",
                "a los veinte (20) días", "a los veintiún (21) dias", "a los veintidós (22) días", "a los veintitrés (23) dias",
                "a los veinticuatro (24) días", "a los veinticinco (25) días"," a los veintiséis (26) días", "a los veintisiete (27) días",
                "a los veintiocho (28) dias", "a los veintinueve (29) días", "a los treinta (30) días", "a los treinta y un (31) días");
            
            return $dias[date("j")-1]." del mes de ".$this->meses[date("n")-1]." de ".date("Y");
        }
		
		public function getFechaPrograma($idgrupo){
			$sql="SELECT fechainiciogrupo,fechafinalgrupo 
					FROM grupo where idgrupo='".$idgrupo."'";
            $row = $this->db->GetRow($sql);
			$dates = explode("-", $row["fechainiciogrupo"]);
			$fecha = $this->meses[intval($dates[1])-1]." ".$dates[2]." de ".$dates[0];
			
			if($row["fechafinalgrupo"]!=="0000-00-00" && $row["fechafinalgrupo"]!==$row["fechainiciogrupo"]){
				$dates = explode("-", $row["fechafinalgrupo"]);
				$fecha .= " a ".$this->meses[intval($dates[1])-1]." ".$dates[2]." de ".$dates[0];
			}
            
			return $fecha;
		}
        
        public function getRutaEncabezado($curso,$returnAll=false){
            $rutaImagen = "";
            $imagenSelectSql="SELECT * FROM parametrizacionEducacionContinuada where nombreCampo='imagenEncabezado'";
            $imagenSelectRow = $this->db->GetRow($imagenSelectSql);
            $rutaImagen=$imagenSelectRow['valor'];
			$esDefecto = true;	
			$id = null;
            if($curso!=null){
				$campo="SELECT * FROM campoParametrizadoPlantillaEducacionContinuada where etiqueta='{{imagenEncabezado}}'";
                $campo = $this->db->GetRow($campo);
                $campo=$campo['idcampoParametrizadoPlantillaEducacionContinuada'];
				
				$plantilla="SELECT * FROM plantillaCursoEducacionContinuada where codigocarrera='".$curso."' AND codigoestado='100'";
                $plantilla = $this->db->GetRow($plantilla);
                $plantilla=$plantilla['idplantillaCursoEducacionContinuada'];
				$imagen = null;
				if($plantilla!=null && $plantilla!=""){
					$imagen="SELECT * FROM detallePlantillaCursoEducacionContinuada where idPlantilla='".$plantilla."' AND idCampoParametrizado='".$campo."' AND codigoestado='100'";
					$imagen = $this->db->GetRow($imagen);
					$id = $imagen["iddetallePlantillaCursoEducacionContinuada"];
					$imagen=$imagen['valor'];
				}
				if($imagen!=null && $imagen!=""){
					$rutaImagen = $imagen;
					$esDefecto = false;	
				}
			}
			if($returnAll){
				return array($rutaImagen,$esDefecto,$id);
			} else {
				return $rutaImagen;
			}
        }
		
		public function getFirmasPlantilla($idPlantilla=null,$curso=null){
			$firmas = array();
		
			if($idPlantilla!=null){
				$plantilla=$idPlantilla;
			} else {
				$plantilla="SELECT * FROM plantillaCursoEducacionContinuada where codigocarrera='".$curso."' AND codigoestado='100'";
				$plantilla = $this->db->GetRow($plantilla);
				$plantilla=$plantilla['idplantillaCursoEducacionContinuada'];
			}
			if($plantilla!=null && $plantilla!=""){
					$firmas="SELECT dp.iddetalleFirmasPlantillaCursoEducacionContinuada, f.nombre, f.cargo, dp.orden, dp.numFila, 
                                            f.unidad,f.ubicacionFirmaEscaneada
						FROM detalleFirmasPlantillaCursoEducacionContinuada dp 
						inner join firmaEscaneadaEducacionContinuada f ON f.idfirmaEscaneadaEducacionContinuada=dp.idFirma 
						where dp.idPlantilla='".$plantilla."' AND dp.codigoestado='100' ORDER BY dp.numFila ASC, dp.orden ASC";
					$firmas = $this->db->GetAll($firmas);
					if(count($firmas)>0){
						$sql="SELECT dp.orden FROM detalleFirmasPlantillaCursoEducacionContinuada dp 
						where dp.idPlantilla='".$plantilla."' AND dp.codigoestado='100' AND dp.numFila=1 ORDER BY dp.orden DESC";
						$col = $this->db->GetRow($sql);
						
						$sql="SELECT MAX(dp.numFila) as fila FROM detalleFirmasPlantillaCursoEducacionContinuada dp 
						where dp.idPlantilla='".$plantilla."' AND dp.codigoestado='100'";
						$fila = $this->db->GetRow($sql);
						
						$firmas = array("data"=>$firmas,"columnas"=>$col["orden"],"filas"=>$fila["fila"]);
					}
			}
			
			return $firmas;
		}
        
        public function decodificarPlantillaHTML($texto,$curso=null){
            $html = $texto;            
            $currentdate  = $this->getFechaActual();
            
            //fecha del dia
            $html = str_replace("{{fechaActual}}", $currentdate, $html);
            
            //fecha del dia texto
            $html = str_replace("{{fechaActualTexto}}", $this->getFechaActualTexto(), $html);
            
            //imagen encabezado certificados
            $htmlImage = "<img src='".$this->getRutaEncabezado($curso)."' alt='logo' width='100%'>";
            $html = str_replace("{{imagenEncabezado}}", $htmlImage, $html);
    
            
            //firmas certificados
            if($curso==null){
                $htmlFirmas = '<table width="100%" style="border: none;width:100%">
                                <tr align="center" >
                                    <td style="border: none;text-align:center"><hr/>Nombre </br> Cargo </br> Organización/Unidad</td>
                                                <td style="border: none"><hr/> Nombre </br> Cargo </br> Organización/Unidad</td>
                                        <td style="border: none"><hr/> Nombre </br> Cargo </br> Organización/Unidad</td>
                                </tr>
                            </table>';
                $html = str_replace("{{firmasPrograma}}", $htmlFirmas, $html);
            }
            
            //Previsualizar de ejemplo en las plantillas de cursos
            if($curso!=null){
                
            }
            
            return $html;
        }
        
        public function decodificarPlantillaPDF($texto,$idgrupo=null,$idestudiante=null,$utils=null,$curso=null,$idplantilla=null){
            $html = $this->decodificarCamposGenericos($texto,$idgrupo,$idestudiante,$utils);        
            
            //imagen encabezado certificados
            $htmlImage = "<img src='".$this->getRutaEncabezado($curso)."' alt='logo'  style='width: 100%'>";
            $html = str_replace("{{imagenEncabezado}}", $htmlImage, $html);
            
            //firmas certificados
            /*if($curso==null){
                $htmlFirmas = '<table width="100%" style="border: none;width:100%">
                                <tr align="center" >
                                    <td style="border: none;text-align:center"><hr/>Nombre </br> Cargo </br> Organización/Unidad</td>
                                                <td style="border: none"><hr/> Nombre </br> Cargo </br> Organización/Unidad</td>
                                        <td style="border: none"><hr/> Nombre </br> Cargo </br> Organización/Unidad</td>
                                </tr>
                            </table>';
                $html = str_replace("{{firmasPrograma}}", $htmlFirmas, $html);
            }*/
            
            //Previsualizar de ejemplo en las plantillas de cursos
            if($idplantilla!==null){
                $firmas = $this->getFirmasPlantilla($idplantilla);
                               //echo "<pre>";print_r($firmas);
                //$htmlFirmas = '<div id="firmasPrograma">';
                    $htmlFirmas =  $this->getHTMLFirmas($firmas);           
                  //      $htmlFirmas .= '</div>';
				$html = str_replace("{{firmasPrograma}}", $htmlFirmas, $html);
            } else if($idestudiante!==null && $idgrupo!==null){
				$sql = "SELECT idplantillaCursoEducacionContinuada FROM plantillaCursoEducacionContinuada pec 
				INNER JOIN grupo g ON g.idgrupo='".$idgrupo."' 
				INNER JOIN materia m on m.codigomateria=g.codigomateria  
				INNER JOIN carrera c on c.codigocarrera=m.codigocarrera 
				WHERE pec.codigocarrera=c.codigocarrera";
				$row = $this->db->GetRow($sql);
				$htmlFirmas = "";
					if(count($row)>0){
						$firmas = $this->getFirmasPlantilla($row["idplantillaCursoEducacionContinuada"]);
						$htmlFirmas =  $this->getHTMLFirmas($firmas);     
					}
				$html = str_replace("{{firmasPrograma}}", $htmlFirmas, $html);
			}else {
				$html = str_replace("{{firmasPrograma}}", "", $html);
			}
			
			$html = str_replace("{{fechaGrupoPrograma}}", $this->getFechaPrograma($idgrupo), $html);
            
            return $html;
        }
		
		public function getHTMLFirmas($firmas){
			$numFirmas = count($firmas["data"]);
                                if($numFirmas>0){
                                    $filas = intval($firmas["filas"]);
                                    $cols = intval($firmas["columnas"]);
									$ancho = 50;
									if($cols==3){
										$ancho = 33;
									} else if($cols==4){
										$ancho = 25;
									} else if($cols==5){
										$ancho = 20;
									}
                                    $htmlFirmas .= '<table style="border: none;width:1090px;margin: 5px 0 0;">';
                                      for($i=1;$i<=$filas;$i++){
                                        $htmlFirmas .='<tr align="center" >';
                                        for($j=1;$j<=$cols;$j++){
                                            $orden = intval(($this->maxCols*$i)-$this->maxCols+$j);
                                            $encontrado = false;
                                            for($z=0;$z<$numFirmas&&!$encontrado;$z++){
                                                //echo $orden." - ".$firmas["data"][$z]["orden"]."<br/>";
                                                if($orden==intval($firmas["data"][$z]["orden"])){
                                                   $htmlFirmas .= '<td style="border: none;text-align:center;width: '.$ancho.'%;"><img src="'.$firmas["data"][$z]["ubicacionFirmaEscaneada"].'" style="height:70px;"/><hr/>';
                                                   $htmlFirmas .= $firmas["data"][$z]["nombre"].'<br/>'; 
                                                   $htmlFirmas .= $firmas["data"][$z]["cargo"].'<br/>'.$firmas["data"][$z]["unidad"].'</td>'; 
                                                   $encontrado = true;
                                                }
                                            }     
                                            if(!$encontrado){
                                                $htmlFirmas .= '<td style="border: none;text-align:center"><img src="" style="height:100px;display:inline-block;"/><hr/>Nombre<br/>Cargo<br/>Unidad/Ubicación</td>'; 
                                            }
                                        }
                                        $htmlFirmas .= '</tr>';
                                      }
                                      $htmlFirmas .= '</table>';
                                }
								
								return $htmlFirmas;
		}
        
        public function decodificarCamposGenericos($html,$idgrupo=null,$idestudiante=null,$utils=null){
            $currentdate  = $this->getFechaActual();
            
            //fecha del dia
            $html = str_replace("{{fechaActual}}", $currentdate, $html);
            
            //fecha del dia texto
            $html = str_replace("{{fechaActualTexto}}", $this->getFechaActualTexto(), $html);
            
            $grupo = $utils->getDataEntity("grupo", $idgrupo, "idgrupo");     
            $materia = $utils->getDataEntity("materia", $grupo["codigomateria"], "codigomateria");  
            $data = $utils->getDataEntity("carrera", $materia["codigocarrera"], "codigocarrera");   
            $html = str_replace("{{nombrePrograma}}", $data["nombrecarrera"], $html);

            $detalleCurso = $utils->getDataEntity("detalleCursoEducacionContinuada", $materia["codigocarrera"], "codigocarrera");   
            $html = str_replace("{{intensidadPrograma}}", $detalleCurso["intensidad"], $html);

            $ciudad = $utils->getDataEntity("ciudad", $detalleCurso["ciudad"], "idciudad"); 
            if($ciudad["nombreciudad"]!="" && $ciudad["nombreciudad"]!=null)
            {$html = str_replace("{{ciudadPrograma}}", $ciudad["nombreciudad"], $html);}
            else{
                $html = str_replace("{{ciudadPrograma}}", "Bogotá D.C.", $html);
            }
            $estudiante = $utils->getDataEntity("estudiantegeneral", $idestudiante, "numerodocumento");    
            $html = str_replace("{{nombreEstudiante}}", $estudiante["nombresestudiantegeneral"]." ".$estudiante["apellidosestudiantegeneral"], $html);
                    
            $html = str_replace("{{consecutivoCertificado}}", $this->getNumeroConsecutivo($estudiante["idestudiantegeneral"],$idgrupo), $html);
            
            $html = str_replace("{{documentoEstudiante}}", number_format($estudiante["numerodocumento"], 0, '.', '.'), $html);
    
            $tipoDoc = $utils->getDataEntity("documento", $estudiante["tipodocumento"], "tipodocumento");  
            $html = str_replace("{{tipoDocumentoCortoEstudiante}}", $tipoDoc["nombrecortodocumento"], $html);

            $html = str_replace("{{tipoDocumentoEstudiante}}", strtolower($tipoDoc["nombredocumento"]), $html);
            
            return $html;
        }
        
        public function getNumeroConsecutivo($idestudiantegeneral,$idgrupo){
                $sql = "SELECT * FROM certificadoEstudianteCursoEducacionContinuada WHERE idEstudianteGeneral=".$idestudiantegeneral." 
                    AND idgrupo=".$idgrupo." AND codigoestado=100";
                $certificadoEstudiante = $this->db->GetRow($sql);
                if($certificadoEstudiante!=NULL && count($certificadoEstudiante)>0){
                    return $certificadoEstudiante["idcertificadoEstudianteCursoEducacionContinuada"];
                } else {
                    return "{{consecutivoCertificado}}";
                }
        }
		
		public function decodificarPlantillaHTMLEditar($texto, $curso,$idplantilla){
			$reemplazos = array();
			//imagen encabezado certificados
			$encabezado = $this->getRutaEncabezado($curso,true);
            $htmlImage = "<div id='decodeImagenEncabezado'><img id='imagenEncabezado' src='".$encabezado[0]."' alt='logo' width='100%'>";
			$htmlImage .= '<input type="button" value="Cambiar encabezado actual" id="cambiarEncabezado" style="display:block;float:left;margin-left:0px;text-align:left;margin-top: 10px;" class="first small"/>';
			if($encabezado[1]==false){ 
				$htmlImage .= '<input type="button" value="Volver a encabezado por defecto" id="inactivarEncabezado" style="display:block;float:left;margin-left:20px;text-align:left;margin-top: 10px;" class="small"/>';
			}
			$htmlImage .= '<br/><br/><script type="text/javascript">
								$("#cambiarEncabezado").click( function () {
									popup_carga("../certificados/cambiarEncabezadoCurso.php?idplantilla='.$idplantilla.'");
								}); ';
			if($encabezado[1]==false){ 
				$htmlImage .= "$('#inactivarEncabezado').click( function () {
									$.ajax({
										dataType: 'json',
										type: 'POST',
										url: 'process.php',
										data: { action: 'inactivate', iddetallePlantillaCursoEducacionContinuada:".$encabezado[2].", entity:'detallePlantillaCursoEducacionContinuada' },                
										success:function(data){
											if (data.success == true){
												window.location.reload(true);
											}
											else{             
												alert('Ocurrio un error al eliminar el encabezado.');
											}
										},
										error: function(data,error,errorThrown){alert(error + errorThrown);}
									 });
								});";
			}			
								
			$htmlImage .= '</script></div>';
            $html = str_replace("{{imagenEncabezado}}", $htmlImage, $texto);
			$reemplazos[] = array ("{{imagenEncabezado}}", "decodeImagenEncabezado");
            
                            //firmas certificados data,columnas,filas
                               $firmas = $this->getFirmasPlantilla($idplantilla);
                               //echo "<pre>";print_r($firmas);
                                $htmlFirmas = '<div id="decodeFirmasPrograma">';
								//$htmlFirmas .=  $this->getHTMLFirmas($firmas);       
                                $numFirmas = count($firmas["data"]);
                                if($numFirmas>0){
                                    $filas = intval($firmas["filas"]);
                                    $cols = intval($firmas["columnas"]);
                                    $htmlFirmas .= '<table width="100%" style="border: none;width:100%">';
                                      for($i=1;$i<=$filas;$i++){
                                        $htmlFirmas .='<tr align="center" >';
                                        for($j=1;$j<=$cols;$j++){
                                            $orden = intval(($this->maxCols*$i)-$this->maxCols+$j);
                                            $encontrado = false;
                                            for($z=0;$z<$numFirmas&&!$encontrado;$z++){
                                                //echo $orden." - ".$firmas["data"][$z]["orden"]."<br/>";
                                                if($orden==intval($firmas["data"][$z]["orden"])){
                                                   $htmlFirmas .= '<td style="border: none;text-align:center"><img src="'.$firmas["data"][$z]["ubicacionFirmaEscaneada"].'" style="height:100px;"/><hr/>';
                                                   $htmlFirmas .= $firmas["data"][$z]["nombre"].'<br/>'; 
                                                   $htmlFirmas .= $firmas["data"][$z]["cargo"].'<br/>'.$firmas["data"][$z]["unidad"].'</td>'; 
                                                   $encontrado = true;
                                                }
                                            }     
                                            if(!$encontrado){
                                                $htmlFirmas .= '<td style="border: none;text-align:center"><img src="" style="height:100px;display:inline-block;"/><hr/>Nombre<br/>Cargo<br/>Unidad/Ubicación</td>'; 
                                            }
                                        }
                                        $htmlFirmas .= '</tr>';
                                      }
                                      $htmlFirmas .= '</table>';
                                }
                        $htmlFirmas .= '<input type="button" value="Asociar firmas" id="asociarFirmas" style="margin-left:0px;margin-top: 10px;" class="first small"/>
							<script type="text/javascript">
								$("#asociarFirmas").click( function () {
									popup_carga("../certificados/asociarFirmasCurso.php?idplantilla='.$idplantilla.'");
								});
							</script>
							</div>';
			$html = str_replace("{{firmasPrograma}}", $htmlFirmas, $html);
			$reemplazos[] = array ("{{firmasPrograma}}", "decodeFirmasPrograma");
			
			return array("plantilla"=>$html,"decode"=>$reemplazos);
		}
		
		public function decodificarPlantillaHTMLEditarGenerico($texto){
			$reemplazos = array();
			//imagen encabezado certificados
			$encabezado = $this->getRutaEncabezado(null);
            $htmlImage = "<div id='decodeImagenEncabezado'><img id='imagenEncabezado' src='".$encabezado."' alt='logo' width='100%'>";
			$htmlImage .= '</div>';
            $html = str_replace("{{imagenEncabezado}}", $htmlImage, $texto);
			$reemplazos[] = array ("{{imagenEncabezado}}", "decodeImagenEncabezado");
            
            //firmas certificados
			$htmlFirmas = '<div id="decodeFirmasPrograma">
							<table width="100%" style="border: none;width:100%">
                                <tr align="center" >
                                    <td style="border: none;text-align:center"><hr/>Nombre </br> Cargo </br> Organización/Unidad</td>
                                                <td style="border: none"><hr/> Nombre </br> Cargo </br> Organización/Unidad</td>
                                        <td style="border: none"><hr/> Nombre </br> Cargo </br> Organización/Unidad</td>
                                </tr>
                            </table>
							</div>';
			$html = str_replace("{{firmasPrograma}}", $htmlFirmas, $html);
			$reemplazos[] = array ("{{firmasPrograma}}", "decodeFirmasPrograma");
            /*if($curso==null){
                $htmlFirmas = '<table width="100%" style="border: none;width:100%">
                                <tr align="center" >
                                    <td style="border: none;text-align:center"><hr/>Nombre </br> Cargo </br> Organización/Unidad</td>
                                                <td style="border: none"><hr/> Nombre </br> Cargo </br> Organización/Unidad</td>
                                        <td style="border: none"><hr/> Nombre </br> Cargo </br> Organización/Unidad</td>
                                </tr>
                            </table>';
                $html = str_replace("{{firmasPrograma}}", $htmlFirmas, $html);
            }*/
			
			return array("plantilla"=>$html,"decode"=>$reemplazos);
		}
                
                public function decodificarGuardarPlantillaHTML($texto){
                    $content = str_replace('\"', "", $texto);
                    $dom = new DOMDocument();
                    $dom->loadHTML(utf8_decode($content));
                    $tables = $dom->getElementsByTagName('div'); 
                    if($tables!=null)
                    {
                        foreach ($tables as $row) 
                        {
                                $row->removeAttribute('data-mce-style');
                                $row->removeAttribute('contenteditable');
                                $row->removeAttribute('spellcheck');
                                $row->removeAttribute('tabindex');
                                $row->removeAttribute('id');
                        }
                    }
                    
                    $tables = $dom->getElementsByTagName('br'); 
                    if($tables!=null)
                    {
                        foreach ($tables as $row) 
                        {
                                $row->removeAttribute('data-mce-bogus');
                        }
                    }

                    $tables = $dom->getElementsByTagName('p'); 
                    if($tables!=null)
                    {
                       foreach ($tables as $row) 
                        {
                                $row->removeAttribute('data-mce-style');
                                $row->removeAttribute('contenteditable');
                                $row->removeAttribute('spellcheck');
                                $row->removeAttribute('tabindex');
                                $row->removeAttribute('id');
                        }
                    }
                    
                    $nodes = $dom->getElementsByTagName('input');

                    // 2. loop through elements
                    foreach($nodes as $node) {
                        if($node->hasAttributes()) {
                            foreach($node->attributes as $attribute) {
                                if($attribute->nodeName == 'type' && $attribute->nodeValue == 'hidden') {
                                    $node->parentNode->removeChild($node);
                                }
                            }
                        }
                    } 
                    
                    $nodes = $dom->getElementsByTagName('input');
                    foreach($nodes as $node) {
                         $node->parentNode->removeChild($node);
                    }
                    
                    $plantilla = $dom->saveHTML();
                    $plantilla = substr($plantilla, strpos($plantilla, "<body>")+6,  strlen($plantilla)); 
                    $plantilla = substr($plantilla, 0,  strpos($plantilla, "</body>")); 
                    return $plantilla;
                }
}

?>
