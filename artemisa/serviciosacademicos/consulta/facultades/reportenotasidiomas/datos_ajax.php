<?PHP 
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

include_once ('../../../EspacioFisico/templates/template.php');
$db = getBD();
$imp= "<tr>          
                <th rowspan='2'>N#</th>
                <th rowspan='2'>Codigo Periodo</th>
                <th rowspan='2'>No Documento</th>
                <th rowspan='2'>Apellidos y nombre</th>
                <th rowspan='2'>Codigo Estudiante</th>
                <th rowspan='2'>Otra carrera</th>
                <th rowspan='2'>Codigo Materia</th>
                <th rowspan='2'>nombre Materia</th>
                <th colspan='6'>Calificaciones</th>
                <th>Nota Historico</th>
                <th>%</th></tr>
                <tr><td>Nota 1</td>
                <td>%</td>
                <td>Nota 2</td>
                <td>%</td>
                <td>Nota 3</td>
                <td>%</td>
                <td>Nota historico</td>
                <td>%</td>
        </tr>";
   $j= 1;             
switch($_POST['actionID']){
    case 'Consultar':
    {
        $sqlestudiantes = "SELECT DISTINCT eg.numerodocumento, eg.nombresestudiantegeneral, eg.apellidosestudiantegeneral, e.codigoperiodo, e.codigoestudiante, pm.idprematricula FROM
	estudiante e INNER JOIN estudiantegeneral eg ON e.idestudiantegeneral = eg.idestudiantegeneral INNER JOIN prematricula pm ON pm.codigoestudiante = e.codigoestudiante INNER JOIN detalleprematricula dp on dp.idprematricula = pm.idprematricula INNER JOIN corte c on c.codigocarrera = e.codigocarrera WHERE e.codigoperiodo = '".$_POST['periodo']."' AND pm.codigoperiodo = e.codigoperiodo AND pm.codigoestadoprematricula IN (40, 41) and dp.codigoestadodetalleprematricula = 30 AND e.codigocarrera = '".$_POST['carrera']."' and c.codigoperiodo = e.codigoperiodo";
           
            $valoresestudiante=&$db->Execute($sqlestudiantes);
            foreach($valoresestudiante as $datoestudiante)
            {
                $imp.="<tr>";
                $imp.="<td>".$j."</td>";
                $imp.= "<td>".$datoestudiante['codigoperiodo']."</td>";
                $imp.= '<td>'.$datoestudiante['numerodocumento'].'</td>';
                $imp.= '<td>'.$datoestudiante['nombresestudiantegeneral'].' '.$datoestudiante['apellidosestudiantegeneral'].'</td>';
                $imp.= "<td>".$datoestudiante['codigoestudiante']."</td>";
                
                $sqlcarreraotra = "SELECT DISTINCT c.nombrecarrera FROM estudiante e, carrera c, documento d, estudiantegeneral eg, 
	estudiantedocumento ed, situacioncarreraestudiante s, genero gr WHERE e.codigocarrera = c.codigocarrera AND gr.codigogenero = eg.codigogenero AND eg.tipodocumento = d.tipodocumento
AND e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante AND ed.idestudiantegeneral = eg.idestudiantegeneral AND e.idestudiantegeneral = eg.idestudiantegeneral
AND e.idestudiantegeneral = ed.idestudiantegeneral AND ed.numerodocumento = '".$datoestudiante['numerodocumento']."' and c.codigocarrera <> '".$_POST['carrera']."' ORDER BY e.codigosituacioncarreraestudiante DESC"; 
                $valoresotra = &$db->execute($sqlcarreraotra);
                $imp.= "<td><ul style='margin:0'>";
                foreach($valoresotra as $datosotra)
                {
                   $imp.= "<li>".$datosotra['nombrecarrera']."</li>"; 
                }               
                $imp.= "</ul></td>";
                
                $sqldatosmateria = "SELECT DISTINCT dn.codigomateria, m.nombremateria FROM detallenota dn INNER JOIN materia m ON m.codigomateria = dn.codigomateria INNER JOIN grupo g ON g.codigomateria = m.codigomateria INNER JOIN detalleprematricula dp ON dp.idgrupo = g.idgrupo INNER JOIN corte c on c.idcorte = dn.idcorte WHERE m.codigocarrera = '".$_POST['carrera']."'
AND dn.codigoestudiante = '".$datoestudiante['codigoestudiante']."' AND dp.idprematricula = '".$datoestudiante['idprematricula']."' and c.codigoperiodo = '".$datoestudiante['codigoperiodo']."' and dp.codigoestadodetalleprematricula = '30'";
                $valormateria=&$db->Execute($sqldatosmateria);
                $datosmasterias = $valormateria->GetArray();
                if(!empty($datosmasterias))
                {
                    foreach($valormateria as $datosmateria)
                    {
                        $imp.= "<td>".$datosmateria['codigomateria']."</td>";
                        $imp.= "<td>".$datosmateria['nombremateria']."</td>"; 
                        
                        $sqlnotas = "SELECT c.porcentajecorte, dn.nota, c.numerocorte FROM corte c inner JOIN detallenota dn ON dn.idcorte = c.idcorte WHERE
                        dn.codigomateria ='".$datosmateria['codigomateria']."' and dn.codigoestudiante = '".$datoestudiante['codigoestudiante']."' and dn.codigoestado = '100' 
                        and c.codigoperiodo = '".$datoestudiante['codigoperiodo']."'";
                        $valoresnotas = $db->execute($sqlnotas);
                        
                        $Data = $valoresnotas->GetArray();

                        $posicion1 = '';
                        $posicion2 = '';
                        $posicion3 = '';
                        foreach($Data as $datosnotas)
                        {
                            switch($datosnotas['numerocorte'])
                            {
                               case '1':
                               {
                                    $posicion1 = "<td>".$datosnotas['nota']."</td><td>".$datosnotas['porcentajecorte']."%</td>";                                    
                               }break;
                               case '2':
                               {
                                    $posicion2 = "<td>".$datosnotas['nota']."</td><td>".$datosnotas['porcentajecorte']."%</td>";
                               }break;
                               case '3':
                               {
                                    $posicion3 = "<td>".$datosnotas['nota']."</td><td>".$datosnotas['porcentajecorte']."%</td>";   
                               }
                            }                           
                        }//foreach
                         if(empty($posicion1))
                            {
                                $posicion1 = "<td bgcolor='9CD1AA'>---</td><td bgcolor='9CD1AA'>%</td>";
                            }
                            if(empty($posicion2))
                            {
                                $posicion2 = "<td bgcolor='9CD1AA'>---</td><td bgcolor='9CD1AA'>%</td>";
                            }
                            if(empty($posicion3))
                            {
                                $posicion3 = "<td bgcolor='9CD1AA'>---</td><td bgcolor='9CD1AA'>%</td>";
                            }
                            $imp.= $posicion1.$posicion2.$posicion3;
                    }//foreach
                    $sqlnotahistorico = "select notadefinitiva from notahistorico where codigomateria = '".$datosmateria['codigomateria']."' and codigoestudiante= '".$datoestudiante['codigoestudiante']."' and codigoperiodo= '".$datoestudiante['codigoperiodo']."' AND codigoestadonotahistorico = '100'";
                    $valoreshistorico = $db->execute($sqlnotahistorico);
                    $Datahistorico = $valoreshistorico->GetArray();
                    if($Datahistorico[0]['notadefinitiva'] != "")
                    {
                        foreach($valoreshistorico as $datoshistorico)
                        {
                            $imp.= "<td>".$datoshistorico['notadefinitiva']."</td>";
                            $imp.= "<td>100%</td>";
                        }//foreach
                    }//if
                    else
                    {
                        $imp.= "<td bgcolor='9CD1AA'>---</td>";
                        $imp.= "<td>100%</td>";
                    }//else                    
                $imp.= '</td></tr>';
                }//if
                else
                {
                    $sqlmateria2 = "SELECT DISTINCT m.nombremateria, m.codigomateria FROM materia m INNER JOIN grupo g ON g.codigomateria = m.codigomateria 
                    INNER JOIN detalleprematricula dp ON dp.idgrupo = g.idgrupo WHERE m.codigocarrera = '".$_POST['carrera']."' AND 
                    dp.idprematricula = '".$datoestudiante['idprematricula']."' and dp.codigoestadodetalleprematricula = '30'";
                    $valoresmateria2 = $db->execute($sqlmateria2);
                    foreach($valoresmateria2 as $datosmateria2)
                    {
                        $imp.= "<td>".$datosmateria2['codigomateria']."</td>";
                        $imp.= "<td>".$datosmateria2['nombremateria']."</td>";
                    }//foreach
                    
                    $sqlnotahistorico = "select notadefinitiva from notahistorico where codigomateria = '".$datosmateria2['codigomateria']."' 
                    and codigoestudiante= '".$datoestudiante['codigoestudiante']."' and codigoperiodo= '".$datoestudiante['codigoperiodo']."' 
                    AND codigoestadonotahistorico = '100'";
                    $valoreshistorico = $db->execute($sqlnotahistorico);
                    $Datahistorico = $valoreshistorico->GetArray();
                    if($Datahistorico[0]['notadefinitiva'] != "")
                    {
                        foreach($valoreshistorico as $datoshistorico)
                        {
                            $imp.= "<td bgcolor='9CD1AA'>--</td><td>%</td> <td bgcolor='9CD1AA'>---</td><td>%</td> <td bgcolor='9CD1AA'>---</td><td>%</td> ";
                            $imp.= "<td>".$datoshistorico['notadefinitiva']."</td>";
                            $imp.= "<td>100%</td>";
                        }//foreach
                    }//if
                    else
                    {   $imp.= "<td bgcolor='9CD1AA'>---</td><td>%</td> <td bgcolor='9CD1AA'>---</td><td>%</td> <td bgcolor='9CD1AA'>---</td><td>%</td> ";
                        $imp.= "<td bgcolor='9CD1AA'>---</td>";
                        $imp.= "<td>100%</td>";
                    }//else                    
                $imp.= '</td></tr>';
                }//else
                $j= $j+1;
            }//foraech  
            $resultados = array();
            $resultados['imp'] = $imp;
            echo json_encode($resultados);
   
    }break;
}
?>