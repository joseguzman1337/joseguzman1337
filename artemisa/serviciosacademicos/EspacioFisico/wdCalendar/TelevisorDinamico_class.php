<?php
class TelevisoresDinamicos{
    public function Display($db,$ip){
        $Data_ip = $this->BlokeIp($db,$ip);
       
        ?>
        <style>
            tr,th,td{
                border: black 1px solid;
            }
        </style>
        <div id="container">
        <fieldset>
        <legend id="Nickname"><?PHP echo $Data_ip[0]['Nombre']?></legend>
        <table>
            <tr style="border: white 1px solid;">
                <td style="border: white 1px solid; width: 50%; vertical-align: top;">
                    <table style="width: 100%; text-align: left; border: black 1px solid;">
                        <thead>
                            <tr>
                                <th>N&deg;</th>
                                <th>Grupo :: Materia</th>
                                <th>Aula</th>
                                <th>Hora de Inicio</th>
                                <th>Hora Final</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                            <tbody id="CargaDinamic">
                        
                             </tbody>
                    </table>
                </td>
                <td style="border: white 1px solid; width: 50%;vertical-align: top;">
                    <table style="width: 100%; text-align: left; border: black 1px solid;">
                        <thead>
                            <tr>
                                <th>N&deg;</th>
                                <th>Grupo :: Materia</th>
                                <th>Aula</th>
                                <th>Hora de Inicio</th>
                                <th>Hora Final</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                            <tbody id="CargaDinamic2">
                        
                             </tbody>
                    </table>  
                </td>
            </tr>
        </table>
        </fieldset>
        </div>        
        <?PHP
    }// public function Display
    public function TablaDianmic($db,$Num,$ip,$View){
        $Data = $this->ConsultaBloque($db,'Arreglo',$ip,$View);
        
        //echo '<pre>';print_r($Data);
        ?>
        
            <?PHP 
            
            if($Num==1){
                $i = 0;
                $N = 9;
            }else{
               $N = ((10*$Num)-1); 
               $i = ((10*$Num)-10);
               
            }
            
           // $N = 9*$Num;
        
            for($i;$i<=$N;$i++){
                if($Data[$i]['Nombre']){
                    if($Data[$i]['Texto']=='Inicio Clase'){
                        $Color = 'E6FFFF';
                        $Text  = 'red';
                    }else{
                        $Color = 'F3FFC7';
                        $Text  = '000000';
                    }
                ?>
                <tr bgcolor="<?PHP echo $Color?>">
                    <td><?PHP echo $i+1?></td>
                    <td><?PHP echo $Data[$i]['nombregrupo'].' :: '. $Data[$i]['nombremateria'];?></td>
                    <td><?PHP echo $Data[$i]['Nombre'];?></td>
                    <td><?PHP echo $Data[$i]['HoraInicio'];?></td>
                    <td><?PHP echo $Data[$i]['HoraFin'];?></td>
                    <td><span style="color:<?PHP echo $Text?>;"><?PHP echo $Data[$i]['Texto'];?></span></td>
                </tr>
                <?PHP
                }
            }//for
            ?>
       
        <?PHP
    }//public function TablaDianmic
    public function ConsultaBloque($db,$Opcion,$ip,$View){
        $Data_ip = $this->BlokeIp($db,$ip);
        
        $Fecha  = date('Y-m-d');
        
        if($View==1){
            /*******************************/
            $hora_A1 = date('H:i:s');
            $hora_A2 = date('H')+4;
            $hora_A2 = $hora_A2.':00';
            $hora_A3 = date('H:i:s');
            
           $Condicion_text = 'IF(a.HoraInicio<="'.$hora_A3.'","Inicio Clase","Pr&oacute;xima Clase") as Texto,';
            $Condicion_Hora = '"'.$hora_A1.'" BETWEEN a.HoraInicio AND a.HoraFin';// AND a.HoraInicio<="'.$hora_A2.'"
            /*******************************/
        }else{
            /*******************************/
            $hora_B1 = date('H:i:s');
            $hora_B1 = $hora_B1.':00';
            $hora_B2 = $hora_B1.':30';
            
            
            $Condicion_text = 'IF(a.HoraInicio,"Pr&oacute;xima Clase","Pr&oacute;xima Clase") as Texto,';
            $Condicion_Hora = 'a.HoraInicio>"'.$hora_B1.'"';
            /*******************************/    
        }
        
        
        
        
         $SQL='SELECT

                c.ClasificacionEspaciosId,
                c.Nombre,
                a.AsignacionEspaciosId,
                a.SolicitudAsignacionEspacioId,
                a.HoraInicio,
                a.HoraFin,
                '.$Condicion_text.'
                sg.idgrupo,
                g.nombregrupo,
                m.nombremateria
                
                FROM
                	ClasificacionEspacios c
                                            INNER JOIN AsignacionEspacios a ON a.ClasificacionEspaciosId = c.ClasificacionEspaciosId
                                            INNER JOIN SolicitudEspacioGrupos sg ON sg.SolicitudAsignacionEspacioId=a.SolicitudAsignacionEspacioId
                                            INNER JOIN grupo g ON g.idgrupo=sg.idgrupo 
                                            INNER JOIN materia m ON m.codigomateria=g.codigomateria
                
               
                WHERE
                
                c.ClasificacionEspacionPadreId="'.$Data_ip[0]['ClasificacionEspaciosId'].'"
                AND
                a.FechaAsignacion="'.$Fecha.'"
                AND
                '.$Condicion_Hora.'
                AND
                c.EspaciosFisicosId=5
                
                
                
                ORDER BY a.HoraInicio';
                
           if($Consulta=&$db->Execute($SQL)===false){
                echo 'Error en el SQL de Consulta...<br><br>'.$SQL;
                die;
           }  
           
           $Data = $Consulta->GetArray();
           
           if($Opcion=='Numero'){
             Return count($Data);  
           }else if($Opcion=='Arreglo'){
             Return $Data;  
           }
           
           
    }//public function ConsultaBloque
    public function BlokeIp($db,$ip){
        
          $SQL='SELECT 

                ip.IpClasificacionEspaciosId,
                ip.Ip,
                ip.ClasificacionEspaciosId,
                c.Nombre
                
                FROM 
                
                IpClasificacionEspacios ip INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId=ip.ClasificacionEspaciosId
                
                WHERE
                  
                ip.codigoestado=100
                AND
                c.codigoestado=100
                AND
                ip.Ip="'.$ip.'"';
                
          if($Data_ip=&$db->Execute($SQL)===false){
              Echo 'Error en el SQL de la IP......<br><br>'.$SQL;
              die;
          }      
        
        $Data = $Data_ip->GetArray();
        
        return $Data;
    }//public function BlokeIp
}//class
?>