<?php
class TelevisoresDinamicos{
    public function Display($db,$ip){ 
    
        $Data_ip = $this->BlokeIp($db,$ip);
       
        ?>
        
        <meta charset="utf-8">
        <link rel="stylesheet" href="../css/styles.css">
        <div id="container">
            <section id="horarios" class="col-md-9">
                <header>
                    <!--<span class="col-md-1">ID</span>-->
                    <span class="col-md-8">Materia</span>
                    <span class="col-md-2">Bloque / Aula</span>
                    <span class="col-md-1">Inicio</span>
                    <span class="col-md-1">Final</span>
                </header>
                <div id="CargaDinamic"></div>
            </section>
            <section id="mas-info" class="col-md-3">
                <div class="col-md-12 info-date">
                    <div class="logo"></div>
                    <div class="hora">
                        <?PHP include_once('../relojdigital/reloj.php');?>
                    </div>
                </div>   
                <div class="col-md-12">
                    <div id="EventoDinamico" class="eventos"></div>
                </div>
               <!-- horarios buses -->
                <div class="col-md-12">
                    <div class="horarios-bus" id="Trasnporte">
                        <?PHP //$this->Transporte($db);?>    
                    </div>
                </div>
        
        
            </section>
            <section class="col-md-12 fijo">
                <footer class="">
                    <marquee>
                    <?PHP echo $Asunto = $this->Asunto($db);?>      
                    </marquee>
                </footer>   
            </section>
        </div>   
         <?PHP 
       
    }// public function Display
    
    public function TablaDianmic($db,$Num,$id,$View,$Estado=''){
        
        $Data = $this->ConsultaBloque($db,'Arreglo',$id,$View,$Estado);
    
            //echo '<pre>';print_r($Data);die;
            
            if($Num==1){
                $i = 0;
                $N = 18;
            }else{
               $N = ((19*$Num)-1); 
               $i = ((19*$Num)-19);
               
            }
            
           // $N = 9*$Num;
        
            for($i;$i<=$N;$i++){
                if($Data[$i]['Nombre']){
                    
                    if($Data[$i]['Modificado']==1){
                        if($i%2){
                            $Class = 'class="row even cambio-horario"';
                        }else{
                            $Class = 'class="row odd cambio-horario"';
                        }
                        
                    }else{
                        if($i%2){
                            $Class = 'class="row even"';
                        }else{
                            $Class = 'class="row odd"';
                        }
                    }
                    switch($Data[$i]['id_bloke']){
                        /*
                        25	BLOQUE A
                        55	BLOQUE B
                        66	BLOQUE C
                        73	BLOQUE D
                        79	BLOQUE E
                        96	BLOQUE F
                        127	BLOQUE G
                        134	BLOQUE I
                        154	BLOQUE J 
                        164	BLOQUE K
                        168	BLOQUE M
                        185	BLOQUE N 
                        */
                        case 25:{ $ClasBloke='bloque-a';}break;
                        case 55:{$ClasBloke='bloque-b';}break;
                        case 66:{$ClasBloke='bloque-c';}break;
                        case 73:{ $ClasBloke='bloque-d';}break;
                        case 79:{$ClasBloke='bloque-e';}break;
                        case 96:{$ClasBloke='bloque-f';}break;
                        case 127:{ $ClasBloke='bloque-g';}break;
                        case 134:{$ClasBloke='bloque-i';}break;
                        case 154:{$ClasBloke='bloque-j';}break;
                        case 164:{ $ClasBloke='bloque-k';}break;
                        case 168:{$ClasBloke='bloque-m';}break;
                        case 185:{$ClasBloke='bloque-n';}break;
                        default:{$ClasBloke='bloque-Default';}break;                    }
                ?>
                <div <?PHP echo $Class?> >
                    <!--<span data-title="ID" class="id-num col-md-1"><?PHP //echo $i+1?></span>-->
                    <!--<span data-title="ID" class="id-num col-md-1"><?PHP //echo $Data[$i]['codigomateria']?></span>-->
                    <span data-title="Materia" class="materia col-md-8"><?PHP echo $Data[$i]['MateriaGrupo']?></span>
                    <span data-title="Aula" class="aula col-md-2"><span class="<?PHP echo $ClasBloke;?>"><?PHP echo $Data[$i]['Bloke'];?></span> <?PHP echo $Data[$i]['Nombre'];?></span>
                    <span data-title="Hora Inicio" class="numeric col-md-1"><?PHP echo substr($Data[$i]['HoraInicio'], 0,5);?></span>
                    <span data-title="Hora Final" class="numeric col-md-1"><?PHP echo substr($Data[$i]['HoraFin'], 0,5);?></span>
                </div>
                <?PHP
                }
            }//for
           
    }//public function TablaDianmic
    public function ConsultaBloque($db,$Opcion,$id='',$View,$Estado='',$Cadena=''){
        
        //echo '<pre>';print_r($Data_ip);
        $Fecha  = date('Y-m-d');
        
        if($Estado==1){
            $Select = ',CONCAT(d.nombredocente," ",d.apellidodocente) AS NameDocente';
            $Inner  = 'LEFT JOIN docente d ON d.numerodocumento=g.numerodocumento';
            $Condicion_id = '';
            if($View==1){
                /*******************************/
                $hora_A1 = date('H:i:s');
                $hora_A2 = date('H')+4;
                $hora_A2 = $hora_A2.':00';
                $hora_A3 = date('H:i:s');
                
                $Condicion_text = 'IF(a.HoraInicio<="'.$hora_A3.'","Inicio Clase","Pr&oacute;xima Clase") as Texto,';
                $Condicion_Hora = '( "'.$hora_A1.'" BETWEEN a.HoraInicio AND a.HoraFin  OR a.HoraInicio>="'.$hora_A1.'")  AND   a.codigoestado=200';// AND a.HoraInicio<="'.$hora_A2.'"
                /*******************************/
            }else if($View==2){
                /*******************************/
                $hora_A1 = date('H:i:s');
                $hora_A2 = date('H')+4;
                $hora_A2 = $hora_A2.':00';
                $hora_A3 = date('H:i:s');
                
                
                $Condicion_text = 'IF(a.HoraInicio,"Pr&oacute;xima Clase","Pr&oacute;xima Clase") as Texto,';
                $Condicion_Hora = '( "'.$hora_A1.'" BETWEEN a.HoraInicio AND a.HoraFin  OR a.HoraInicio>="'.$hora_A1.'") AND   a.Modificado=1';//AND a.Modificado=1
                /*******************************/    
            }
            
        }else{
        $Select = '';
        $Inner  = '';
        if($Cadena){
            $Valor = $Cadena;
          }else{
            $Valor = $id;  
          } 
          
          $Condicion_id = 'c.ClasificacionEspacionPadreId IN ('.$Valor.') AND';
        
            if($View==1){
                /*******************************/
                $hora_A1 = date('H:i:s');
                $hora_A2 = date('H')+4;
                $hora_A2 = $hora_A2.':00';
                $hora_A3 = date('H:i:s');
                
                $Condicion_text = 'IF(a.HoraInicio<="'.$hora_A3.'","Inicio Clase","Pr&oacute;xima Clase") as Texto,';
                $Condicion_Hora = '"'.$hora_A1.'" BETWEEN a.HoraInicio AND a.HoraFin';// AND a.HoraInicio<="'.$hora_A2.'"
                /*******************************/
            }else if($View==2){
                /*******************************/
                $hora_B1 = date('H:i:s');
                $hora_B1 = $hora_B1.':00';
                $hora_B2 = $hora_B1.':30';
                
                
                $Condicion_text = 'IF(a.HoraInicio,"Pr&oacute;xima Clase","Pr&oacute;xima Clase") as Texto,';
                $Condicion_Hora = 'a.HoraInicio>"'.$hora_B1.'"';
                /*******************************/    
            }
            
           
        
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
                CONCAT(	m.nombremateria, 	" :: ",	g.nombregrupo) AS Texto,
                s.NombreEvento,
                if(CONCAT(	m.nombremateria, 	" :: ",	g.nombregrupo) IS NULL,s.NombreEvento,CONCAT(	m.nombremateria, 	" :: ",	g.nombregrupo)) AS MateriaGrupo,
                g.nombregrupo,
                m.nombremateria,
                cc.ClasificacionEspaciosId AS id_bloke,
                SUBSTR(cc.Nombre , 7,7) AS Bloke,
                m.codigomateria,
                a.Modificado'.$Select.'
                
                FROM
                	ClasificacionEspacios c
                                            INNER JOIN AsignacionEspacios a ON a.ClasificacionEspaciosId = c.ClasificacionEspaciosId
                                            INNER JOIN ClasificacionEspacios cc ON cc.ClasificacionEspaciosId = c.ClasificacionEspacionPadreId
                                            INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId=a.SolicitudAsignacionEspacioId
                                            LEFT JOIN SolicitudEspacioGrupos sg ON sg.SolicitudAsignacionEspacioId = s.SolicitudAsignacionEspacioId
                                            LEFT JOIN grupo g ON g.idgrupo = sg.idgrupo
                                            LEFT JOIN materia m ON m.codigomateria = g.codigomateria
                                            '.$Inner.'
               
                WHERE
                
                
                '.$Condicion_id.'
                a.FechaAsignacion="'.$Fecha.'"
                AND
                '.$Condicion_Hora.'
                AND c.ClasificacionEspaciosId<>212
                AND s.codigocarrera NOT IN(887,888)
                AND s.codigoestado=100
                AND a.codigoestado=100
                AND (sg.codigoestado=100 OR sg.codigoestado IS NULL)
               
                GROUP BY a.SolicitudAsignacionEspacioId
                
                ORDER BY a.HoraInicio,m.nombremateria'; // AND   c.EspaciosFisicosId=5
                
                //if($Opcion=='Arreglo'){echo $SQL;}
                
           if($Consulta=&$db->Execute($SQL)===false){
                echo 'Error en el SQL de Consulta...<br><br>'.$SQL;
                die;
           }  
           
           $Data = $Consulta->GetArray();
           
           if($Opcion=='Numero'){
                if($Cadena){
                    $New = str_replace('"','',$Cadena);
                    $C_Data['Num'] = count($Data);
                    $C_Data['Cadena'] = $New;
                    
                    return $C_Data;    
                }else{
                    Return count($Data);
                }      
           }else if($Opcion=='Arreglo'){
             Return $Data;  
           }
           
           
    }//public function ConsultaBloque
    public function BlokeIp($db,$ip,$id='',$Opcion='',$ini='',$fin=''){
        //echo '<pre>';print_r($db);die;
        if($id){
            
            $Condicion = '  AND ip.ClasificacionEspaciosId IN ('.$id.')';
        }else{
            $Condicion = '';            
        }
        
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
                ip.Ip="'.$ip.'"'.$Condicion;
                
          if($Data_ip=&$db->Execute($SQL)===false){
              Echo 'Error en el SQL de la IP......<br><br>'.$SQL;
              die;
          }      
        
        //echo 'ip->'.$Data_ip->fields['Ip'];
        $Data = $Data_ip->GetArray();
        
       /* echo '<pre>';print_r($Data);die;
        echo 'Op->'.$Opcion;*/

        
        if($Opcion=='Numero'){
            return count($Data);
        }else if($Opcion=='Cadena'){
            //echo '<pre>';print_r($Data);
            
           
            if($ini==0){
                $ini = 0;
                $fin = $fin;
            }else{
                $ini_old = $ini;
                $fin_old = $fin;
                $ini = $fin*$ini;
                $fin = ($ini_old+1)*$fin_old;
                
            }
            
            for($i=$ini;$i<$fin;$i++){
                //echo '<br>$i->'.$i;
                if($i==$ini){
                    $Cadena = '"'.$Data[$i]['ClasificacionEspaciosId'].'"';
                }else{
                    $Cadena = $Cadena.',"'.$Data[$i]['ClasificacionEspaciosId'].'"';
                }    
            }
            return $Cadena;
        }else{
            return $Data;    
        }
        
    }//public function BlokeIp
     public function MultiPantallas($db,$ip){
       ?>
        <style>
            tr,th,td{
                border: black 1px solid;
            }
        </style>
        <div id="container">
        <table>
            <tr style="border: white 1px solid;">
                <td style="border: white 1px solid; width: 50%; vertical-align: top;">
                <?PHP $this->ViewTablaDinamica($db,$ip,'CargaDinamic_1','','Nickname_1');?>    
                </td>
                <td style="border: white 1px solid; width: 50%;vertical-align: top;">
                <?PHP $this->ViewTablaDinamica($db,$ip,'CargaDinamic_2','','Nickname_2');?>                    
                </td>
            </tr>
            <tr style="border: white 1px solid;">
                <td style="border: white 1px solid; width: 50%; vertical-align: top;">
                <?PHP $this->ViewTablaDinamica($db,$ip,'CargaDinamic_3','','Nickname_3');?>    
                </td>
                <td style="border: white 1px solid; width: 50%;vertical-align: top;">
                <?PHP $this->ViewTablaDinamica($db,$ip,'CargaDinamic_4','','Nickname_4');?>                    
                </td>
            </tr>
            <tr style="border: white 1px solid;">
                <td colspan="2" style="border: white 1px solid; width: 50%; vertical-align: top;">
                <?PHP $this->Evento($db);?>
                </td>
            </tr>
        </table>
        
        </div> 
        <?PHP
    }//public function MultiPantallas
    public function ViewTablaDinamica($db,$ip='',$Name_id,$Cacelada='',$Nickname=''){
        if($ip){
            $Data_ip = $this->BlokeIp($db,$ip);    
        }
        
        if($ip){
        ?>
        
        <fieldset>
        <legend id="<?PHP echo $Nickname?>"></legend>
        <?PHP
        }
        if($Cacelada==''){
        ?>
        
        <table style="width: 100%; text-align: left; border: black 1px solid;">
            <thead>
                <tr>
                    <th>Grupo :: Materia</th>
                    <th>Aula</th>
                    <th>Hora de Inicio</th>
                    <th>Hora Final</th>
                </tr>
            </thead>
                <tbody id="<?PHP echo $Name_id?>">
                 </tbody>
        </table>
        <?PHP
        }
        if($ip){
        ?>    
        </fieldset>
        <?PHP
        }
        if($Cacelada){
        ?>
            <table style="width: 100%; text-align: left; border: black 1px solid;">
                <thead>
                    <tr>
                        <th>Grupo :: Materia</th>
                        <th>Aula</th>
                        <th>Docente</th>
                    </tr>
                </thead>
                    <tbody id="<?PHP echo $Name_id?>">
                     </tbody>
            </table>
        <?PHP
        }
    }//public function TablaDinamica
    public function Evento($db){
        ?>
        <fieldset>
        <legend id="NicknameEvento">Eventos</legend>
        <table style="width: 100%; text-align: left; border: black 1px solid;">
            <thead>
                <tr>
                    <th>N&deg;</th>
                    <th>Nombre Del Evento</th>
                    <th>Lugar</th>
                    <th>Fecha</th>
                    <th>Hora Inicio</th>
                    <th>Hora Final</th>
                </tr>
            </thead>
                <tbody id="EventosDinamic">
                </tbody>
        </table>
        </fieldset>
        <?PHP
    }//public function Evento
    public function ViewCancelUpdate($db,$ip){
        ?>
        <style>
            tr,th,td{
                border: black 1px solid;
            }
        </style>
        <div id="container">
        <table>
            <tr style="border: white 1px solid;">
                <td style="border: white 1px solid; width: 50%; vertical-align: top;">
                <fieldset>
                <legend>Clases Canceladas</legend>
                <?PHP $this->ViewTablaDinamica($db,'','CargaDinamic_1',1);?>  
                </fieldset>  
                </td>
                <td style="border: white 1px solid; width: 50%;vertical-align: top;">
                <fieldset>
                <legend>Clases Modificadas</legend>
                <?PHP $this->ViewTablaDinamica($db,'','CargaDinamic_2','',1);?>                    
                </td>
                </fieldset>
            </tr>
            <tr style="border: white 1px solid;">
                <td colspan="2" style="border: white 1px solid; width: 50%; vertical-align: top;">
                <?PHP $this->Evento($db);?>
                </td>
            </tr>
        </table>
        
        </div> 
        <?PHP
    }//public function ViewCancelUpdate
    public function EventoDinamico($db,$num){
        $Data = $this->ConsultaEvento($db,'Arreglo');
    
            
            if($num==1){
                $i = 0;
                $N = 0;
            }else{
               $N = ((1*$num)-1); 
               $i = ((1*$num)-1);
               
            }
           ?>
           <!--<div class="tab-titulo">Eventos</div>-->
           <?PHP
            for($i;$i<=$N;$i++){
                if($Data[$i]['UbicacionImagen']){
                    
                        $Color = 'D7D9FE';
                        
                        if($i%2){
                            $Class = 'class="even"';
                        }else{
                            $Class = 'class="odd"';
                        }
                   
                ?>
                    <div class="img-horizontal">
                        <img src="<?PHP echo $Data[$i]['UbicacionImagen']?>" width="100%" /><!---width="380" height="450"  width="900" height="250"-->
                    </div>
                    <div class="img-vertical">
                        <img src="<?PHP echo $Data[$i]['UbicacionImagen2']?>" width="100%"/><!---width="380" height="450"  width="900" height="250"-->
                    </div>
                    
                <?PHP
                }
            }//for
    }//public function EventoDinamico
    public function ConsultaEvento($db,$Opcion){
        $Fecha  = date('Y-m-d');
        
        $dia = DiasSemana($Fecha);
    
        if($dia==7){
            //$FechaFutura_1 = dameFecha($Fecha,1);
            $FechaFutura_2 = dameFecha($Fecha,6);
        }else{
            $Falta  = 7-$dia+1;
            
            //$FechaFutura_1 = dameFecha($fecha_Now,$Falta);
          $FechaFutura_2 = dameFecha($Fecha,6);
        }
        
         $SQL='SELECT
                        UbicacionImagen,
                        UbicacionImagen2
                FROM
                        NoticiaEvento
                WHERE
                        CodigoEstado=100
                        and
                        FileSize <> ""
                        AND
                        FileSize2 <> ""
                        AND
                        CURDATE() BETWEEN FechaInicioVigencia AND FechaFinalVigencia';
                    
              if($Consulta=&$db->Execute($SQL)===false){
                echo 'Error en el SQL de Consulta...<br><br>'.$SQL;
                die;
           }  
           
           $Data = $Consulta->GetArray();
           
           if($Opcion=='Numero'){
            //echo 'Num->'.count($Data); 
             Return count($Data);  
           }else if($Opcion=='Arreglo'){
             Return $Data;  
           }       
    }//public function ConsultaEvento
    public function ConsolaRecuerda($db,$Opcion){
        $Fecha  = date('Y-m-d');
        
          $SQL='SELECT
                        n.NoticiaEventoId AS id,
                        n.TituloNoticia,
                        n.DescripcionNoticia
                
                FROM
                         NoticiaEvento n 
                
                WHERE
                
                        n.AprobadoPublicacion=1
                        AND "'.$Fecha.'" BETWEEN n.FechaInicioVigencia AND n.FechaFinalVigencia
                        AND n.CodigoEstado=100
                        AND Tipo IN (1,2)                        
                        AND (UbicacionImagen="" OR UbicacionImagen IS NULL)
                        AND (UbicacionImagen2="" OR UbicacionImagen2 IS NULL)';
                        
             if($InforRecuerda=&$db->Execute($SQL)===false){
                echo 'Error en el SQL de Recurda Que....<br><br>'.$SQL;
                die;
             }   
             
             $Data = $InforRecuerda->GetArray(); 
             
           if($Opcion=='Numero'){
            //echo 'Num->'.count($Data); 
             Return count($Data);  
           }else if($Opcion=='Arreglo'){
             Return $Data;  
           }        
    }//public function ConsolaRecuerda
    public function Asunto($db){
        $Fecha  = date('Y-m-d');
        
          $SQL='SELECT
                        n.NoticiaEventoId AS id,
                        n.TituloNoticia,
                        n.DescripcionNoticia
                
                FROM
                         NoticiaEvento n 
                
                WHERE
                
                        n.AprobadoPublicacion=1
                        AND "'.$Fecha.'" BETWEEN n.FechaInicioVigencia AND n.FechaFinalVigencia
                        AND n.CodigoEstado=100
                        AND Tipo = 3                        
                        AND (UbicacionImagen="" OR UbicacionImagen IS NULL)
                        AND (UbicacionImagen2="" OR UbicacionImagen2 IS NULL)';
                        
             if($InforAsunto=&$db->Execute($SQL)===false){
                echo 'Error en el SQL de Recurda Que....<br><br>'.$SQL;
                die;
             }
         $Asunto = '';    
        if(!$InforAsunto->EOF){
            while(!$InforAsunto->EOF){
                /******************************************/
                $Asunto = $Asunto.$InforAsunto->fields['DescripcionNoticia'].'&nbsp;&nbsp;<span class="sep"></span> '; 
                /******************************************/
                $InforAsunto->MoveNext();
            }   
        }else{
            $Asunto = 'No Hay Informacion...';
        }       
        
        return $Asunto;      
    }//public function Asunto
    public function DataCancel($db,$Num,$View,$Estado){
        $Data = $this->ConsultaBloque($db,'Arreglo',$ip,$View,$Estado);
        
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
                    <td><?PHP echo $Data[$i]['nombregrupo'].' :: '. $Data[$i]['nombremateria'];?></td>
                    <td><?PHP echo $Data[$i]['Nombre'];?></td>
                    <td><?PHP echo $Data[$i]['NameDocente'];?></td>                   
                </tr>
                <?PHP
                }
            }//for
    }//public function DataCancel
    public function MensajeDinamico($db,$num){
        $Data = $this->ConsolaRecuerda($db,'Arreglo');
    
            if($num==1){
                $i = 0;
                $N = 2;
            }else{
               $N = ((3*$num)-1); 
               $i = ((3*$num)-3);
               
            }
           ?>
           <div class="tab-titulo">Recuerda que...</div>
           <?PHP
            for($i;$i<=$N;$i++){
                if($Data[$i]['TituloNoticia']){
                    
                        $Color = 'D7D9FE';
                        
                        if($i%2){
                            $Class = 'class="even"';
                        }else{
                            $Class = 'class="odd"';
                        }
                   
                ?>
                    <div <?PHP echo$Class?>>
                        <h3><?PHP echo $Data[$i]['TituloNoticia'];?></h3>
                        <p><?PHP echo $Data[$i]['DescripcionNoticia'];?></p>
                    </div>
                <?PHP
                }
            }//for
    }//public function MensajeDinamico
    Public function Transporte($db,$N=''){
        if($N==2){
             $Now = date('Y-m-d'); 
             $Fecha = dameFecha($Now,1);
        }else{
             $Fecha = date('Y-m-d');  
        }
        
        $DiaNombre = DiasSemana($Fecha,'Nombre');
        $DiaCodigo = DiasSemana($Fecha);
        
        $Data = $this->DataTransporte($db,$Fecha,$DiaCodigo);
        ?>
        <div class="wrap-horarios-bus">
            <h3 id="dia-semana"><?PHP echo utf8_encode($DiaNombre);?>&nbsp;&nbsp;<span>Salida</span></h3>
            <header>
                <span class="col-md-6">A CHIA</span>
                <span class="col-md-6">A USAQUEN</span>
            </header>
            <?PHP 
            $Num1 = count($Data[4]['Hora']);
            $Num2 = count($Data[5]['Hora']);
            
            if($Num1>=1){
                if($Num1>=$Num2){
                    $Num = $Num1;
                }else{
                    $Num = $Num2;
                }
            }else{
               if($Num2>=$Num1){
                    $Num = $Num2;
                }else{
                    $Num = $Num1;
                } 
            }
            
            $N = 1;
            $Z = 1;
            for($i=0;$i<$Num;$i++){
                if($i%2){
                    $Class = 'class="row even"';
                }else{
                    $Class = 'class="row odd"';
                }
                
                if($Data[4]['Hora'][$i]){
                    $HoraUsa = substr($Data[4]['Hora'][$i], 0,5);
                }else{
                    $HoraUsa = '--//--';
                }
                if($Data[5]['Hora'][$i]){
                    $HoraChia = substr($Data[5]['Hora'][$i], 0,5);
                }else{
                    $HoraChia = '--//--';;
                }
                if($N==1){
                    if($Data[4]['print'][$i]==1){
                        $PrintUsa = 'active';
                        $N = 2;
                    }else{
                        $PrintUsa = '';
                                           
                    }
                }else{
                     $PrintUsa = '';
                }
                if($Z==1){    
                    if($Data[5]['print'][$i]==1){
                        $PrintChia = 'active';
                        $Z = 2;
                    }else{
                        $PrintChia = '';
                                       
                    }
                }else{
                    $PrintChia = '';
                }    
                
                ?>
                <div <?PHP echo $Class?> >
                    <span class="chia col-md-6 <?PHP echo $PrintChia?>"><?PHP echo $HoraChia;?></span>
                    <span class="usaquen col-md-6 <?PHP echo $PrintUsa?>"><?PHP echo $HoraUsa;?></span>
                </div>
                <?PHP
            }//for
            ?>
            <!--<div class="row even">
                <span class="chia col-md-6">07:00 am</span>
                <span class="usaquen col-md-6">10:00 am</span>
            </div>
            <div class="row odd">
                <span class="chia col-md-6">09:00 am</span>
                <span class="usaquen col-md-6">10:00 am</span>
            </div>
            <div class="row even">
                <span class="chia col-md-6 active">12:00 m</span>
                <span class="usaquen col-md-6 active">15:00 pm</span>
            </div>  
            <div class="row odd">
                <span class="chia col-md-6">14:00 pm</span>
                <span class="usaquen col-md-6">17:00 pm</span>
            </div>-->                                         
        </div>
        <?PHP
    }//Public function Transporte
    public function DataTransporte($db,$fecha,$Dia){
          $SQL='SELECT
                        t.Hora,
                        ClasificacionEspaciosId,
                        if(t.Hora>=CURTIME(),"1","0") AS print
                FROM
                        Transporte t                 
                WHERE
                
                        t.CodigoEstado=100
                        AND
                        t.CodigoDia="'.$Dia.'"
                        AND
                        t.Aprobado=1
                        AND
                        "'.$fecha.'" BETWEEN t.FechaInicial AND t.FechaFinal
                        
                        ORDER BY t.Hora';
                        
               if($Data=&$db->Execute($SQL)===false){
                    echo 'Error en el SQL ....<br><br>'.$SQL;
                    die;
               }        
           
           $Resultado = array();
           
           
           $C_Data = $Data->GetArray();
          
           
           for($i=0;$i<count($C_Data);$i++){
                if($C_Data[$i]['ClasificacionEspaciosId']==4){
                    $Resultado['4']['Hora'][] = $C_Data[$i]['Hora'];
                    $Resultado['4']['print'][] = $C_Data[$i]['print'];
                }else{
                    $Resultado['5']['Hora'][] = $C_Data[$i]['Hora'];
                    $Resultado['5']['print'][] = $C_Data[$i]['print'];
                }
           }//for
           
            return $Resultado;
              
    }//public function DataTransporte
    function imagenglobal(){
        ?>
        <img src="../imagenes/prueba_black.jpg" width="100%" />
        <?PHP
    }
}//class
function DiasSemana($Fecha,$Op=''){
    
        if($Op=='Nombre'){
            $dias = array('','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo');    
        }else{
            $dias = array('','1','2','3','4','5','6','7');    
        }
        
        $fecha = $dias[date('N', strtotime($Fecha))]; 
        
        return $fecha;

}//  function DiasSemana
function dameFecha($fecha,$dia){   
        list($year,$mon,$day) = explode('-',$fecha);
        return date('Y-m-d',mktime(0,0,0,$mon,$day+$dia,$year));        
}//function dameFecha

?>