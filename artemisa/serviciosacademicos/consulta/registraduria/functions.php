<?php

    function getModalidades($db){
        
        $query = "SELECT codigomodalidadacademicasic,nombremodalidadacademicasic FROM modalidadacademicasic 
                  WHERE codigoestado=100 
                  ORDER BY nombremodalidadacademicasic";
         $modalidades = $db->Execute($query);
         return $modalidades;
    }

    function getPeriodo($db){
        
        $query = "SELECT codigoperiodo,nombreperiodo FROM periodo 
                  WHERE NOW() between fechainicioperiodo and fechavencimientoperiodo";
         $periodos = $db->GetRow($query);
         return $periodos;
    }
    
    function getEstudiantesJurados($modalidades,$periodo,$db){
		include_once('../estadisticas/matriculasnew/funciones/obtener_datos.php');
		$datos_estadistica=new obtener_datos_matriculas($db,$periodo);
        $subquery = "";
        $num = count($modalidades);
        if($num>1){
            $mods = "";
            foreach($modalidades as $modalidad){
                if($mods===""){
                    $mods = $modalidad;
                } else {
                    $mods .= ",".$modalidad;
                }
                $subquery= " AND c.codigomodalidadacademicasic IN (".$mods.")";
            }
        } else {
            $subquery = " AND c.codigomodalidadacademicasic='".$modalidades[0]."'";
        }
        
        //mayores a 18 años
        $date=strtotime('-18 year');
        $date = date('Y-m-d', $date);
        //menores a 60 años
        $date60=strtotime('-60 year');
        $date60 = date('Y-m-d', $date);
        
        $query = "SELECT c.nombrecarrera, c.codigomodalidadacademicasic, eg.tipodocumento, eg.numerodocumento,
            eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,d.nombrecortodocumento,
            eg.fechanacimientoestudiantegeneral, eg.direccionresidenciaestudiantegeneral, 
            eg.telefonoresidenciaestudiantegeneral, eg.celularestudiantegeneral, city.nombreciudad,
            eg.emailestudiantegeneral, eg.expedidodocumento, e.codigoestudiante  
            FROM prematricula p 
            INNER JOIN estudiante e ON e.codigoestudiante=p.codigoestudiante 
            INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera 
            INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral 
			INNER JOIN documento d on d.tipodocumento=eg.tipodocumento   
			INNER JOIN ciudad city on city.idciudad=eg.idciudadnacimiento 
            WHERE p.codigoperiodo='".$periodo."' 
                AND p.codigoestadoprematricula IN (40,41) 
                $subquery                 
                AND eg.fechanacimientoestudiantegeneral<'".$date."' 
                    AND eg.fechanacimientoestudiantegeneral>'".$date60."' AND eg.idciudadnacimiento!=2000 
                        AND eg.tipodocumento IN ('01','02') 
						AND eg.idestudiantegeneral NOT IN (SELECT idestudiantegeneral
							FROM estudiantecondicionsalud es WHERE es.condiciondiscapacidadfisica<>0 AND codigoestado=100 
						)
						AND c.codigocarrera NOT IN (
							SELECT codigocarrera FROM detallecarrera WHERE esMedicoQuirurgica=1	 
						)
				AND eg.expedidodocumento NOT LIKE '%venezuela%' 
            GROUP BY eg.idestudiantegeneral ORDER BY c.codigomodalidadacademicasic ASC";
        //echo $query;
        $results = $db->Execute($query);
        $html = "";
        $estudiantes= array();
        foreach($results as $row){
            $contador++;
			$row["edad"] = $datos_estadistica->calcular_edad_estudiante($row["codigoestudiante"]);
			if($row["edad"]<18)
			{
				die;
			}
            if($row["codigomodalidadacademicasic"]==200 || $row["codigomodalidadacademicasic"]=="200"){
                $row["estudios"] = "BACHILLERATO";
                $row["nivel"] = "B";
            } else {
                $row["estudios"] = "UNIVERSIDAD";
                $row["nivel"] = "P";
            }
            $row["partido"] = "99";
            $row["politica"] = "APOLITICO ó NINGUNO";
            if($row["direccionresidenciaestudiantegeneral"]=="" || $row["direccionresidenciaestudiantegeneral"]=="Campo Faltante"){
				$row["direccionresidenciaestudiantegeneral"] = "No Registra";
			}
			
                    $html .= "<tr><td>".$contador."</td><td>".$row["numerodocumento"]."</td>
                        <td>".$row["nombresestudiantegeneral"]."</td>
                        <td>".$row["apellidosestudiantegeneral"]."</td><td>".$row["nivel"]."</td>
						<td>".$row["partido"]."</td>
                            <td>".$row["direccionresidenciaestudiantegeneral"]."</td><td>".$row["telefonoresidenciaestudiantegeneral"]."</td>
							<td>".$row["celularestudiantegeneral"]."</td>
                                <td>".$row["emailestudiantegeneral"]."</td><td>".$row["nombrecortodocumento"]."</td>
								<td>".$row["expedidodocumento"]."</td><td>".$row["nombreciudad"]."</td><td>".$row["nombrecarrera"]."</td>
								<td>".$row["edad"]."</td><td>".$row["estudios"]."</td><td>".$row["politica"]."</td>
                        </tr>";
              $estudiantes[] = $row;
        } if($html === "") {
             $html = "<td colspan='8' style='text-align:center' >No se encontraron estudiantes potenciales para ser jurado.</td>";
        } else {
            $html = $html;
        }
        
        $data=serialize($estudiantes); 
        $encoded=base64_encode($data);
        $input = '<input type="hidden" name="estudiantes" value="'.$encoded.'">';
        
        return array("data"=>$estudiantes,"html"=>$html,"inputs"=>$input,"encoded"=>$encoded);
    }
?>
