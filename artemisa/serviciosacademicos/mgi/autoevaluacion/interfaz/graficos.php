<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include("../../templates/templateAutoevaluacion.php");
    
switch($_REQUEST['actionID'])
{ 
    case 'DatosGrafic':{
        
        $db =writeHeaderBD();
        
        $id_instrumento = $_GET['id_instru'];
        $id_preg   = $_GET['id_preg'];
        $t_preg   = $_GET['tipo_preg'];
        
        if ($t_preg=='2'){
            
            /*
            select pre.valor as respuesta, pre.texto_inicio, pre.texto_final, res.idsiq_Apreguntarespuesta, count(res.idsiq_Apreguntarespuesta) as total
                    from siq_Apreguntarespuesta as pre
                    left join siq_Arespuestainstrumento as res on (res.idsiq_Apreguntarespuesta=pre.idsiq_Apreguntarespuesta and res.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."')
                    where pre.idsiq_Apregunta='".$id_preg."' and pre.codigoestado='100' 
                    group by pre.valor
            */
              $sql_rep="select
                        sub.respuesta,
                        sub.texto_inicio,
                        sub.texto_final,
                        sub.idsiq_Apreguntarespuesta, sum(total) as total FROM (select
                        pre.valor as respuesta,
                        pre.texto_inicio,
                        pre.texto_final,
                        res.idsiq_Apreguntarespuesta,
                        
                        IF(act.usuarioid IS NULL, 0, count(res.idsiq_Apreguntarespuesta)) as total
                        
                        
                        
                        from
                        siq_Apreguntarespuesta as pre left join siq_Arespuestainstrumento as res on (res.idsiq_Apreguntarespuesta=pre.idsiq_Apreguntarespuesta and res.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."')
                        left JOIN actualizacionusuario act ON act.usuarioid=res.usuariocreacion AND act.estadoactualizacion=2 AND act.codigoestado=100 AND res.idsiq_Ainstrumentoconfiguracion=act.id_instrumento
                        
                        
                        where
                        pre.idsiq_Apregunta='".$id_preg."'
                        and
                        pre.codigoestado='100'
                        AND
                        res.codigoestado=100
                        
                        group by pre.valor,act.usuarioid) as sub GROUP BY sub.respuesta";
        }else{
          $sql_rep='SELECT

                                                                x.idsiq_Apreguntarespuesta,
                                                                COUNT(x.respuesta) AS total,
                                                                x.respuesta
                                                                
                                                                FROM(
                                                                SELECT
                                                                
                                                                rr.idsiq_Apreguntarespuesta,
                                                                ra.respuesta,
                                                                ra.valor,
                                                                ra.unica_respuesta,
                                                                ra.multiple_respuesta,
                                                                rr.idsiq_Ainstrumentoconfiguracion,
                                                                rr.usuariocreacion
                                                                
                                                                
                                                                FROM
                                                                    siq_Arespuestainstrumento AS rr
                                                                INNER JOIN siq_Apreguntarespuesta AS ra ON ra.idsiq_Apreguntarespuesta = rr.idsiq_Apreguntarespuesta
                                                                INNER JOIN actualizacionusuario act ON (rr.usuariocreacion = act.usuarioid OR rr.cedula=act.numerodocumento)
																AND rr.idsiq_Ainstrumentoconfiguracion = act.id_instrumento                                                                
                                                                WHERE
                                                                
                                                                rr.idsiq_Ainstrumentoconfiguracion="'.$id_instrumento.'"
                                                                AND
                                                                rr.idsiq_Apregunta="'.$id_preg.'" 
                                                                AND
                                                                rr.codigoestado=100 
                                                                AND 
                                                                (rr.usuariocreacion!="" OR rr.cedula!="") GROUP BY act.usuarioid,act.numerodocumento
                                                                ) x
                                                                
                                                                GROUP BY x.idsiq_Apreguntarespuesta';
       }
            //echo  $sql_rep;
			$data_rep = $db->Execute($sql_rep);
            if($data_rep===false){
                
                $a_vectt['val']			='FALSE';
                $a_vectt['descrip']		='Error al Buscar Datos ....'.$sql_rep;
                echo json_encode($a_vectt);
                exit;
            }
            
         $C_Data = $data_rep->GetArray();
         
         #echo '<pre>';print_r($C_Data);
         
         
        /* $sql_cp="select cedula, usuariocreacion 
                      from siq_Arespuestainstrumento 
                      where idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' group by usuariocreacion 
                      union
                      select cedula, usuariocreacion 
                      from siq_Arespuestainstrumento 
                      where idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' group by cedula 
                      ";*/
                      
            $sql_cp="select 
                        R.cedula, 
                        R.usuariocreacion 
                        from 
                        siq_Arespuestainstrumento R INNER JOIN actualizacionusuario a ON a.usuarioid=usuariocreacion AND R.idsiq_Ainstrumentoconfiguracion=a.id_instrumento
                        where 
                        R.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' 
                        AND
                        a.estadoactualizacion=2
                        and
                        a.codigoestado=100
                        and
                        R.codigoestado=100
                        
                        group by usuariocreacion 
                        
                        union 
                        select 
                        cedula, 
                        usuariocreacion 
                        from 
                        siq_Arespuestainstrumento 
                        where 
                        idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' 
                        AND
                        cedula<>''
                        group by cedula";
                //echo $sql_cp;  
                
                 $cant=0;
                 $data_cp = $db->Execute($sql_cp);
                 $C_data = $data_cp->GetArray();          
                // echo $sql_cp;
                
                //echo '<br>Num->'.count($C_data);
                
                 $cant=0;
                 $data_cp = $db->Execute($sql_cp);
                 $C_data = $data_cp->GetArray();
                 $C_total=count($C_data);
                 $ti=''; $tf='';
         $data2="";
         //echo 'Cant-->'.count($C_Data);
        // print"[";
         if ($t_preg=='2') {
            /*$C_total = 0;
            for($i=0;$i<count($C_Data);$i++){
                $C_total += $C_Data[$i]['total'];
            }*/
         }
         
         for($i=0;$i<count($C_Data);$i++){
                $tot=$C_Data[$i]['total'];
                $total=$total+$tot;
               // echo '<br>Calculo_2->('.$tot.'*100)/'.$C_total;
                $por=($tot*100)/$C_total;
                $por = round($por, 2);
                $Total[$i]=$por;
                
                if ($t_preg=='2') $ti=$C_Data[$i]['texto_inicio'];
                if ($t_preg=='2') $tf=$C_Data[$i]['texto_final'];
                if ($t_preg=='2') {
                    if ($i==0){
                        //$Respuesta[$i] = $ti.'  '.$C_Data[$i]['respuesta'];
                    }else if($i==(count($C_Data)-1)){
                        //$Respuesta[$i] = $C_Data[$i]['respuesta'].'  '.$tf;
                    }else{
                        $Respuesta[$i] = $C_Data[$i]['respuesta'];
                    }
                }else{
                    $Respuesta[$i] = $C_Data[$i]['respuesta'];
                }
         }
        // print"]";
         //$data3="[7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]";
        #echo 'Data---->'.$data2;
         //print_r($Respuesta);
                $a_vectt['val']			        ='TRUE';
                $a_vectt['Respuesta']		    =$Respuesta;
                $a_vectt['Total']               =$Total;
                $a_vectt['Tinicial']            =$ti;
                $a_vectt['Tfinal']              =$tf;
                echo json_encode($a_vectt);
                exit;
         
    }break;
    
}



?>