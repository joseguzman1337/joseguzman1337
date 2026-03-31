<?php

/*
* Ivan dario quinterio rios
* Modificado 20 octubre 2017
* Modificacion de conexion de base de datos y adicion de estilos
* limpieza de codigo basura
*/
    require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php'); 
    $rutaado = "../../../funciones/adodb/";
    require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado.php');

    switch($_POST['action'])
    {
        
        case 'deleteCorteRol':
        {
            $corte = $_POST['indice']; 
                        
            $SQLd = "DELETE FROM corte WHERE idcorte='".$corte."'";										            
            $resultado = $db->Execute($SQLd);
            
            $a_vectt['mensaje'] = 'Corte eliminado correctamente';
            echo json_encode($a_vectt);
        }break;
        case 'Modificar':
        {         
            $banderagrabar = 0;
            $totalcortes = 0;
            $contador= $_POST['contador'];
            for($c = 1 ; $c <= $contador; $c++)
            {
                $fechainicio = $_POST['fechainicialcorte'.$c];
                $fechafinal = $_POST['fechafinalcorte'.$c];
                $porcentaje = $_POST['porcentajecorte'.$c];
                $idcorte = $_POST['idcorte'.$c];
                
                $ano = substr($fechainicio,0,4); 
                $mes = substr($fechainicio,5,2);
                $dia = substr($fechainicio,8,2);
                
                if (! checkdate($mes,$dia,$ano))
                {
                    $banderagrabar = 1;
                    $mensaje = 'Hay Fechas Iniciales Incorrectas';   
                    $value = false;
                }
                
                $ano1 = substr($fechafinal,0,4); 
                $mes1 = substr($fechafinal,5,2);
                $dia1 = substr($fechafinal,8,2);
                
                if (! checkdate($mes1,$dia1,$ano1))
                {
                    $banderagrabar = 1;
                    $mensaje = 'Hay Fechas Finales Incorrectas'; 
                    $value = false;
                }
                
                if ($fechafinal < $fechainicio)
                {
                    $banderagrabar = 1;
                    $mensaje = 'Las Fechas Iniciales no pueden ser mayores a las Finales en el corte '.$c.' '; 
                    $value = false;
                }
                
                $totalcortes += $porcentaje;
            }//for
            
            for($c = 1; $c <= $contador; $c++)
            {
                if ($_POST['fechafinalcorte'.$c] >= $_POST['fechainicialcorte'.($c+1)] and $_POST['fechainicialcorte'.($c+1)] <> "")
                {			
                    $banderagrabar = 1;
                    $mensaje = "Presenta Cruce de Fechas"; 
                    $value = false;
                }
            }//for
            
            if ($totalcortes <> 100)
            {			
                $banderagrabar = 1;
                $mensaje =  'Los Porcentajes deben sumar el 100%'; 
                $value = false;
            }
            
            if($banderagrabar == 0)
            {
                for($c = 1 ; $c <= $contador; $c++)
                {   
                    $fechainicio = $_POST['fechainicialcorte'.$c];
                    $fechafinal = $_POST['fechafinalcorte'.$c];
                    $porcentaje = $_POST['porcentajecorte'.$c];
                    $idcorte = $_POST['idcorte'.$c];
                    
                    $updateSQL = "UPDATE corte SET fechainicialcorte = '".$fechainicio."',  
                    fechafinalcorte = '".$fechafinal."', 
                    porcentajecorte = '".$porcentaje."'  
                    WHERE idcorte= '".$idcorte."'";		 
                    $db->execute($updateSQL);
                    $mensaje = 'Lista de cortes actualizados'; 
                    $value.= $updateSQL." -- ";
                }
            }            
            
            $a_vectt['mensaje'] = $mensaje;            
            $a_vectt['value'] = $value;            
            echo json_encode($a_vectt);
        }break;
    }//switch

?>