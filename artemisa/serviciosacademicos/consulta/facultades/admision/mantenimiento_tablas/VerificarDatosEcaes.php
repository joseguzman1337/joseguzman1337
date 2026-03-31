<?php
    require(realpath(dirname(__FILE__)).'/../../../../funciones/sala_genericas/Excel/reader.php');    
    include_once (realpath(dirname(__FILE__)).'/../../../../EspacioFisico/templates/template.php');

    $db = getBD();

    $action= $_POST['action'];       
    if($action == 'v4l1d4r')
    {        
        $file = $_FILES['archivo']['tmp_name'];                
                
        move_uploaded_file($_FILES['archivo']['tmp_name'], "tmp/cargue.xls");
        
        $dataexcel = new Spreadsheet_Excel_Reader();
        $dataexcel->setOutputEncoding('CP1251');        
        $dataexcel->read('tmp/cargue.xls');          
        $valor =0;
        $tabla="";
        $r=0;
        $f=0;
        for($i=2; $i<=$dataexcel->sheets[0]['numRows']; $i++)
        {
            $documento = $dataexcel->sheets[0]['cells'][$i][1];            
            $Apellidos = utf8_encode($dataexcel->sheets[0]['cells'][$i][2]);
            $Nombres = utf8_encode($dataexcel->sheets[0]['cells'][$i][3]);
            $fecha = filter_var($dataexcel->sheets[0]['cells'][$i][4], FILTER_SANITIZE_NUMBER_INT);              
            $tamano_fecha = strlen($fecha);            
            $puntaje = $dataexcel->sheets[0]['cells'][$i][5];
            
            if(!$puntaje)
            {
               $puntaje = 0; 
            }
            $registro = $dataexcel->sheets[0]['cells'][$i][6];                              
           
            if($documento)
            {
                if($puntaje != "" && $puntaje < 16)
                {
                    if($tamano_fecha != '4')
                    {
                        $r++;
                        $tabla.='<tr><td>'.$r.'</td><td>'.$documento.'</td><td>'.$Apellidos.' '.$Nombres.'</td><td>Error de Fecha</td></tr>';

                    }else
                    {
                        $sqlbuscar = "SELECT RPE.ResultadoPruebaestadoEcaesId, EG.idestudiantegeneral FROM estudiantegeneral EG LEFT JOIN ResultadoPruebaestadoEcaes RPE on RPE.IdEstudianteGeneral = EG.idestudiantegeneral where EG.numerodocumento = '".$documento."'";                     
                        $resultado = $db->GetRow($sqlbuscar);                

                        if($resultado['ResultadoPruebaestadoEcaesId'])
                        {
                            if($resultado['idestudiantegeneral'])
                            {
                                $sqlupdate = "update ResultadoPruebaestadoEcaes set PuntajeGeneral='".$puntaje."', Numeroregistro='".$registro."', FechaPrueba ='".$fecha."' where (IdEstudianteGeneral = '".$resultado['IdEstudianteGeneral']."')"; 
                                $db->execute($sqlupdate);
                                $f++;
                            }else
                            {
                                $valor++;
                                $r++;
                                $tabla.='<tr><td>'.$r.'</td><td>'.$documento.'</td><td>'.$Apellidos.' '.$Nombres.'</td><td>No se encuentra en SALA</td></tr>';
                            }
                        }else
                        {
                            if($resultado['idestudiantegeneral'])
                            {
                                $sqlregistro ="select ResultadoPruebaestadoEcaesId, IdEstudianteGeneral from ResultadoPruebaestadoEcaes where NumeroRegistro ='".$registro."' and IdEstudianteGeneral = '".$resultado['idestudiantegeneral']."'";
                                $ResultadoEsta = $db->GetRow($sqlregistro);
                                if($ResultadoEsta['ResultadoPruebaestadoEcaesId'])
                                {
                                    if($ResultadoEsta['IdEstudianteGeneral'] != $resultado['idestudiantegeneral'])
                                    {
                                        $r++;
                                        $tabla.='<tr><td>'.$r.'</td><td>'.$documento.'</td><td>'.$Apellidos.' '.$Nombres.'</td><td>el numero de registro Ya existe para otro estudiante</td></tr>';    
                                    }else
                                    {
                                        $sqlupdate = "update ResultadoPruebaestadoEcaes set PuntajeGeneral='".$puntaje."', Numeroregistro='".$registro."', FechaPrueba ='".$fecha."' where (IdEstudianteGeneral = '".$resultado['IdEstudianteGeneral']."')"; 
                                        $db->execute($sqlupdate);
                                        $f++;
                                    }
                                    $valor++;                        
                                }
                                else
                                {
                                    $sqlinsert = "insert into ResultadoPruebaestadoEcaes (IdEstudianteGeneral, NumeroRegistro, FechaPrueba, PuntajeGeneral, CodigoEstado) values ('".$resultado['idestudiantegeneral']."', '".$registro."', '".$fecha."', '".$puntaje."', '100')";    
                                    $db->execute($sqlinsert);
                                    $f++;
                                }
                            }
                            else
                            {
                                $valor++;                        
                                $r++;
                                $tabla.='<tr><td>'.$r.'</td><td>'.$documento.'</td><td>'.$Apellidos.' '.$Nombres.'</td><td>No se encuentra en SALA</td></tr>';               
                            }
                        }
                    }
                }//puntaje
                else
                {
                    $valor++;
                    $r++;
                    if($puntaje)
                    {
                        $tabla.='<tr><td>'.$r.'</td><td>'.$documento.'</td><td>'.$Apellidos.' '.$Nombres.'</td><td>Error de Puntaje</td></tr>';  
                    }else
                    {
                        $tabla.='<tr><td>'.$r.'</td><td>'.$documento.'</td><td>'.$Apellidos.' '.$Nombres.'</td><td>Sin Puntaje</td></tr>';      
                    }
                }
            }//documento
        }//for        
        if($valor>0)
        {
            $a_vectt['success'] = false;
            $a_vectt['message']	='Algunos estudiantes no se actualizaron';            
            $a_vectt['tabla'] = "<table border='2'><tr><th>#</th><th>NumeroDocumento</th><th>Nombre completo</th><th>Error</th></tr>".$tabla."<tr><td colspan='4'><u><p id='total' onclick='mostrar(".$f.")' style='color:blue;'>Cargados :".$f."</p></u></td></tr></table>";
        }else
        {
            $a_vectt['success'] = true;
            $a_vectt['message']	='Todos los registros se actualizaron. total('.$f.').';
        }
        echo json_encode($a_vectt);
    }
    if($action == 'm0str4r')
    {
        $total= $_POST['numero'];
        
        $sqlcargados = "SELECT G.numerodocumento, G.apellidosestudiantegeneral, G.nombresestudiantegeneral, R.FechaPrueba, R.PuntajeGeneral, R.NumeroRegistro FROM ResultadoPruebaestadoEcaes R, estudiantegeneral G  where G.idestudiantegeneral = R.IdEstudianteGeneral ORDER BY R.ResultadoPruebaestadoEcaesId DESC LIMIT 0,".$total;  
        $totales = $db->GetAll($sqlcargados);
        $Tabla="<table border='2'><tr><th>#</th><th>NumeroDocumento</th><th>Nombre completo</th><th>Fecha</th><th>Puntaje</th></tr>";
        $u=1;
        foreach($totales as $datos)
        {
            $Tabla.="<tr><td>".$u."</td><td>".$datos['numerodocumento']."</td><td>".$datos['apellidosestudiantegeneral']." ".$datos['nombresestudiantegeneral']."</td><td>".$datos['FechaPrueba']."</td><td>".$datos['PuntajeGeneral']."</td></tr>";
            $u++;
        }
        $a_vectt['success'] = true;
        $a_vectt['tabla'] = $Tabla."</table>";
        echo json_encode($a_vectt);
    }
?>