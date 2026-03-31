<?php
    // Proceso para generar la carga académica
    // Toma todas las materias del plan de estudios
    // La variable $quitaparacartas se usa para las cartas de los estudiantes graduandos

    if(!isset($quitaparacartas) || empty($quitaparacartas)){
        $quitaparacartas = "";
    }
    if(!isset($reprobada) || empty($reprobada)){
        $reprobada = "";
    }
    /*if(!isset($materiasobligatorias)) {
        $materiasobligatorias = "";
    }*/

     $query_materiasplanestudio = "SELECT 
     d.idplanestudio, d.codigomateria, m.nombremateria, m.codigoindicadorgrupomateria, m.numerocreditos as numCreditoTbMateria,".
    " d.semestredetalleplanestudio*1 as semestredetalleplanestudio, ".
    " t.nombretipomateria, t.codigotipomateria, d.numerocreditosdetalleplanestudio ".
    " FROM planestudioestudiante p, detalleplanestudio d, materia m, tipomateria t ".
    " WHERE p.codigoestudiante = '".$codigoestudiante."' ".
    " and p.idplanestudio = d.idplanestudio ".
    " and p.codigoestadoplanestudioestudiante like '1%' ".
    " and d.codigoestadodetalleplanestudio like '1%' ".
    " and d.codigomateria = m.codigomateria ".
    " and d.codigotipomateria = t.codigotipomateria ".
    " ".$quitaparacartas." ".
    " order by 6, 5, 4 asc ";
    $materiasplanestudio=mysql_query($query_materiasplanestudio, $sala) or die("$query_materiasplanestudio");
    $totalRows_materiasplanestudio = mysql_num_rows($materiasplanestudio);    
    $quitarmateriasdelplandestudios = "";
    $tieneunplandeestudios = true;

    if($totalRows_materiasplanestudio != ""){
	// Este arreglo sirve para guardar el semestre que mas se repite
	// Tomo el maximo numero de semestres del plan de estudio
	$query_semestreplanes = "select max(cantidadsemestresplanestudio*1) as semestre from planestudio";
	$semestreplanes=mysql_query($query_semestreplanes, $sala) or die("$query_semestreplanes");
	$totalRows_semestreplanes = mysql_num_rows($semestreplanes);
	$row_semestreplanes = mysql_fetch_array($semestreplanes);
	for($semestreini = 1; $semestreini <= $row_semestreplanes['semestre']; $semestreini++){
            $semestre[$semestreini] = 0;
	}
	$numerocreditoselectivas = 0;
	$tieneelectivas = false;
	$tieneenfasis = false;
	$estudiantetieneenfasis = false; 
	// String que va a guardar las materias del plan de estudios para quitarselas a las electivas libres, en caso de existir una obligatoria
	$quitarmateriasdelplandestudios = "";
	while($row_materiasplanestudio = mysql_fetch_array($materiasplanestudio)){            
            $idplan = $row_materiasplanestudio['idplanestudio'];            
            $quitarmateriasdelplandestudios = "$quitarmateriasdelplandestudios and m.codigomateria <> '".$row_materiasplanestudio['codigomateria']."'";
            if($row_materiasplanestudio['codigotipomateria'] == '4'){
                $numerocreditoselectivas = $numerocreditoselectivas + $row_materiasplanestudio['numerocreditosdetalleplanestudio'];
                $electivaslibresplan[] = $row_materiasplanestudio;
                $tieneelectivas = true;
            }else{
                // Mira si cada materia ha sido aprobada para agregarla en la carga
                // Por el momento toma totas las materias
                if($row_materiasplanestudio['codigotipomateria'] != '5'){
                    //valida si la materia esta aprobada por el estudiante
                    $estadomateria = materiaaprobada($codigoestudiante, $row_materiasplanestudio['codigomateria'], $row_materiasplanestudio['idplanestudio'], $reprobada, $sala);
                    //si la materia esta en estado "porver"
                    if($estadomateria == "porver"){
                        $materiasporver[] = $row_materiasplanestudio;                        
                    }else if($estadomateria == "reprobada"){
                        // Estas materias son obligatorias
                        $materiasobligatorias[] = $row_materiasplanestudio;
                        // Selección de la carga obligatoria
                        $cargaobligatoria[] = $row_materiasplanestudio['codigomateria'];
                        $materiasporver[] = $row_materiasplanestudio;
			
                        $semestre[$row_materiasplanestudio['semestredetalleplanestudio']]++;
                    }else if($estadomateria == "aprobada"){
                        //echo "bien<br>";
                        $materiaspasadas[] = $row_materiasplanestudio;
                    }else{
                        echo "error";
                    }
                }else if($row_materiasplanestudio['codigotipomateria'] == '5'){
                    // Aqui es para las lineas de enfasis
                    $tieneenfasis = true;
                    // Primero miro si el estudiante ya tiene linea de enfasis.
                    $query_poseelineaenfasis = "select le.idlineaenfasisplanestudio ".
                    " from lineaenfasisestudiante le ".
                    " where le.codigoestudiante = '".$codigoestudiante."' AND le.idplanestudio='".$idplan."' ".
                    " and (NOW() between le.fechainiciolineaenfasisestudiante and le.fechavencimientolineaenfasisestudiante)";
                    $poseelineaenfasis=mysql_query($query_poseelineaenfasis, $sala) or die("$query_poseelineaenfasis");
                    $totalRows_poseelineaenfasis = mysql_num_rows($poseelineaenfasis);
                    if($totalRows_poseelineaenfasis != ""){
                        // Selecciona las materias de la línea y efectua el proceso de carga para esas materias
                        $estudiantetieneenfasis = true; 
                    }else{
                        $query_poseelineaenfasis = "select le.idlineaenfasisestudiante,le.idlineaenfasisplanestudio, l.nombrelineaenfasisplanestudio".
                        " FROM lineaenfasisestudiante le INNER JOIN lineaenfasisplanestudio l ON l.idlineaenfasisplanestudio=le.idlineaenfasisplanestudio ".
                        " where le.codigoestudiante = '".$codigoestudiante."' ".
                        " and (NOW() between le.fechainiciolineaenfasisestudiante and le.fechavencimientolineaenfasisestudiante)";                        
                        $poseelineaenfasis=mysql_query($query_poseelineaenfasis, $sala) or die("$query_poseelineaenfasis");
                        $totalRows_poseelineaenfasis_2 = mysql_num_rows($poseelineaenfasis);
                    
                        if($totalRows_poseelineaenfasis_2 != ""){
                            $Name_uno  = mysql_fetch_array($poseelineaenfasis);
                            $SQL="SELECT idlineaenfasisplanestudio, nombrelineaenfasisplanestudio FROM lineaenfasisplanestudio WHERE idplanestudio='".$idplan."'";
                            $poseelineaenfasis=mysql_query($SQL, $sala) or die("$SQL");
                            
                            while($row_nameLineas = mysql_fetch_array($poseelineaenfasis)){
                                if($row_nameLineas['nombrelineaenfasisplanestudio']==$Name_uno['nombrelineaenfasisplanestudio']){
                                    $InsertNew="INSERT INTO lineaenfasisestudiante(idplanestudio,idlineaenfasisplanestudio, ".
                                    " codigoestudiante,fechaasignacionfechainiciolineaenfasisestudiante,fechainiciolineaenfasisestudiante,".
                                    " echavencimientolineaenfasisestudiante)VALUES('".$idplan."','".$row_nameLineas['idlineaenfasisplanestudio']."',".
                                    "'".$codigoestudiante."',NOW(),NOW(),'2099-12-31')";
                                    $NEWDataInsert=mysql_query($InsertNew, $sala) or die("$InsertNew");

                                    $UpdateNew="UPDATE lineaenfasisestudiante ".
                                                " SET fechavencimientolineaenfasisestudiante= (CURDATE()-1) ".
                                                " WHERE idlineaenfasisestudiante='".$Name_uno['idlineaenfasisestudiante']."'";
                                    $UpdateLineaNew=mysql_query($UpdateNew, $sala) or die("$UpdateNew");  
                                    $estudiantetieneenfasis = true;           
                                }//if
                            }//while
                        }//if
                    }//else			
                }//else if
            }//else
            $idplanestudioini = $row_materiasplanestudio['idplanestudio'];
	}//while        
                
        
	if($estudiantetieneenfasis=== true){
            // Selecciona las materias de la linea de enfasis de este estudiante las cuales deben estar activas
            $query_materiaslineaenfasis = "select d.idplanestudio, d.idlineaenfasisplanestudio, ".
            " d.codigomateriadetallelineaenfasisplanestudio as codigomateria, m.nombremateria, ".
            " d.semestredetallelineaenfasisplanestudio*1 as semestredetalleplanestudio, t.nombretipomateria, ".
            " t.codigotipomateria, d.numerocreditosdetallelineaenfasisplanestudio as numerocreditosdetalleplanestudio ".
            " from detallelineaenfasisplanestudio d, materia m, tipomateria t, lineaenfasisestudiante l ".
            " where d.codigomateriadetallelineaenfasisplanestudio = m.codigomateria ".
            " and d.codigotipomateria = t.codigotipomateria ".
            " and l.idplanestudio = d.idplanestudio ".
            " and l.codigoestudiante = '".$codigoestudiante."' ".
            " and l.idlineaenfasisplanestudio = d.idlineaenfasisplanestudio ".
            " and d.codigoestadodetallelineaenfasisplanestudio like '1%' ".
            " and (NOW() between l.fechainiciolineaenfasisestudiante and l.fechavencimientolineaenfasisestudiante) ".
            " group by 3 order by 5, 2";
            $materiaslineaenfasis=mysql_query($query_materiaslineaenfasis, $sala) or die("$query_materiaslineaenfasis");
            $totalRows_materiaslineaenfasis = mysql_num_rows($materiaslineaenfasis);
	}else if($tieneenfasis=== true){
            // Selecciona todas las materias del plan de estudio que son enfais
            // Es decir toma todos los enfasis
            $query_materiaslineaenfasis="SELECT d.idplanestudio, d.idlineaenfasisplanestudio, ".
            " d.codigomateriadetallelineaenfasisplanestudio AS codigomateria, m.nombremateria, ".
            " d.semestredetallelineaenfasisplanestudio * 1 AS semestredetalleplanestudio, ".
            " t.nombretipomateria, t.codigotipomateria, d.numerocreditosdetallelineaenfasisplanestudio AS numerocreditosdetalleplanestudio ".
            " FROM lineaenfasisplanestudio l ".
            " INNER JOIN detallelineaenfasisplanestudio d ON (d.idlineaenfasisplanestudio = l.idlineaenfasisplanestudio) ".
            " INNER JOIN materia m ON (m.codigomateria = d.codigomateriadetallelineaenfasisplanestudio) ".
            " INNER JOIN tipomateria t ON (t.codigotipomateria = d.codigotipomateria) ".
            " WHERE l.idplanestudio = '".$idplan."' ".
            " ORDER BY l.idlineaenfasisplanestudio, d.codigomateria";
            $materiaslineaenfasis=mysql_query($query_materiaslineaenfasis, $sala) or die("$query_materiaslineaenfasis");
            $totalRows_materiaslineaenfasis = mysql_num_rows($materiaslineaenfasis);
	}
        
	if(isset($totalRows_materiaslineaenfasis) && !empty($totalRows_materiaslineaenfasis)){
            while($row_materiaslineaenfasis = mysql_fetch_array($materiaslineaenfasis)){
                $quitarmateriasdelplandestudios = "$quitarmateriasdelplandestudios and m.codigomateria <> '".$row_materiaslineaenfasis['codigomateria']."'";
                $estadomateria = materiaaprobada($codigoestudiante, $row_materiaslineaenfasis['codigomateria'], $idplan, $reprobada, $sala);
                if($estadomateria == "porver"){
                    $materiasporver[] = $row_materiaslineaenfasis;
                }else if($estadomateria == "reprobada"){
                    // No la puse por que no hay linea de enfasis
                    // Estas materias son obligatorias
                    $materiasobligatorias[] = $row_materiaslineaenfasis;
                    // Selección de la carga obligatoria
                    $cargaobligatoria[] = $row_materiaslineaenfasis['codigomateria'];
                    $materiasporver[] = $row_materiaslineaenfasis;
                    $semestre[$row_materiaslineaenfasis['semestredetalleplanestudio']]++;
                }else if($estadomateria == "aprobada"){				
                    $materiaspasadas[] = $row_materiaslineaenfasis;
                }else{
                    echo "error";
                }
            }//while
	}//if        
        
	$materiasafiltrar = $materiasporver;	
	$materiasconprerequisito = $materiasporver;        
	$materiasobigatoriasquitar = $materiasobligatorias;
	// Solamente se filtran las materias por ver, es decir las sugeridas
	if(isset($materiasafiltrar)){
            foreach($materiasafiltrar as $key1 => $value1){
                // Debe tomar las materias que no tengan prerequisito, o el prerequisito este aprobado
                // Las materias del anterior arreglo deben filtrarse por las que no tengan prerequisito o el prerequisito este aprobado.
                // Mejor dicho si el prereqisito de una materia no se encuentra en este mismo arreglo se acepta la materia si no No.
                $query_materiasprerequisito = "select r.codigomateriareferenciaplanestudio ".
                " from referenciaplanestudio r where r.idplanestudio = '".$value1['idplanestudio']."'  ".
                " and r.codigomateria = '".$value1['codigomateria']."' ".
                " and r.codigotiporeferenciaplanestudio like '1%' ".
                " and r.codigoestadoreferenciaplanestudio = '101'";
                
                $materiasprerequisito=mysql_query($query_materiasprerequisito, $sala) or die("$query_materiasprerequisito");
                $totalRows_materiasprerequisito = mysql_num_rows($materiasprerequisito);
                if($totalRows_materiasprerequisito != ""){
                    $tieneprerequisito = false;		
                    while($row_materiasprerequisito = mysql_fetch_array($materiasprerequisito)){
                        // Cada una de las materias con prerequisitos se busca en el arreglo, si esta no incluye la materia
                        foreach($materiasconprerequisito as $key2 => $value2){
                            //valida si la materia de preriquisito esta en la materia de referncia                            
                            if($row_materiasprerequisito['codigomateriareferenciaplanestudio'] == $value2['codigomateria']){
                                //ELECTIVA TECNICA I
                                if($value1['codigomateria']==1273){
                                    $row_materiasprerequisito['codigomateriareferenciaplanestudio']." = ".$value2['codigomateria']."<br>";
                                }
                                $tieneprerequisito = true;                                
                            }//if
                        }//foreach
                    }//while 
                    if($tieneprerequisito === false){
                        $quitarobligatoria = false;                        
                        if(!$quitarobligatoria){
                            $materiaspropuestas[] = $value1;
                            //Selección de la carga obligatoria
                            $cargaobligatoria[] = $value1['codigomateria'];
                            $semestre[$value1['semestredetalleplanestudio']]++;
                        }
                    }
                }else{
                    $quitarobligatoria = false;
                    if(!$quitarobligatoria){
                        $materiaspropuestas[] = $value1;
                        // Selección de la carga obligatoria
                        $cargaobligatoria[] = $value1['codigomateria'];
                        $semestre[$value1['semestredetalleplanestudio']]++;
                    }//if
                }//else		
            }//foreach            
	}else{
            //echo '<h1 align="center">El estudiante no tiene materias para ver</h1>';
	}        
        
 	for($i=0;$i<count($materiasobligatorias);$i++){
            //asigna la materia obligatoria al array de $materiasobligatoriasobliga
            $materiasobligatoriasobliga[]=$materiasobligatorias[$i]["codigomateria"];
            
            for($j=0;$j<count($materiaspropuestas);$j++){
                //compara si la materia propuesta es igual a la oblitoria
                if($materiasobligatorias[$i]["codigomateria"]==$materiaspropuestas[$j]["codigomateria"]){
                    //unifica el array de materias obligatorias y propuestas en uno solo
                    $materiasobligatoriaspropuestas[]=$materiasobligatorias[$i]["codigomateria"];
		}//if
            }//for
        }//for           
        
        //valida si el array de obligatorias y propuestas son arrays
        if(is_array($materiasobligatoriasobliga)&&is_array($materiasobligatoriaspropuestas)){
            //valida la diferencia entre arrays obligatorias y propuestas
            $diferenciaobligatorias=array_diff($materiasobligatoriasobliga,$materiasobligatoriaspropuestas);
        }else{
            //valida si el array de obligatorias es array
            if(is_array($materiasobligatoriasobliga)){
                //asigna el array de obligaotiras a diferencia de obligatorias
                $diferenciaobligatorias=$materiasobligatoriasobliga;
            }
        }//else
        //valida si el array de diferencia de obligatorias es un array con datos
        if(is_array($diferenciaobligatorias)){
            //recorre cada campo de la direncia de obligatorias 
            foreach($diferenciaobligatorias as $nocodigomateria => $codigomateriaobliga ){
                //revisa la cantidad de materias obligatorias
                for($j=0;$j<count($materiasobligatorias);$j++){
                    //valida que la materia obligatoria corresponda a la materia obligatoria
                    if($materiasobligatorias[$j]["codigomateria"]==$codigomateriaobliga){
                        //asigna el array de materias propuestas
                        $materiaspropuestas[]=$materiasobligatorias[$j];
                    }//if
                }//for
            }//foreach
        }//if
    }else{
        //Este estudiante no tiene asignado un plan de estudios
        $tieneunplandeestudios = false;
        //exit();
    }//else
    //exit();            