<?php 
set_time_limit(0);
ini_set('max_execution_time',30000);
ini_set("memory_limit","512M");
ini_set('mysql.connect_timeout', 14400);
ini_set('default_socket_timeout', 14400);

include("./templates/template.php");
include_once('Solicitud/SolicitudEspacio_class.php');
include_once('Solicitud/festivos.php');
include_once('Solicitud/AsignacionSalon.php'); 
                 
$C_AsignacionSalon = new AsignacionSalon();
$C_Festivo  = new festivos();  
$C_SolicitudEspacio = new SolicitudEspacio();
		
		$db = getBD();
        
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		 $userid=$Usario_id->fields['id'];
         
         //echo '<pre>';print_r($db);die;

//COMO EL INPUT FILE FUE LLAMADO archivo ENTONCES ACCESAMOS A TRAVÉS DE $_FILES["archivo"]
?>
<table align="center">
 <tr>
  <td>
   <b>Nombre:</b>: <?php echo $_FILES["archivo"]["name"]?>
       
   <b>Tipo:</b>: <?php echo $_FILES["archivo"]["type"]?>
       
   <b>Subida:</b>: <?php echo ($_FILES["archivo"]["error"]) ? "Incorrecta" : "Correcta"?>
       
   <b>Tamaño:</b>: <?php echo $_FILES["archivo"]["size"]?> bytes
  </td>
 </tr>
</table>


<?php
//SI EL ARCHIVO SE ENVIÓ Y ADEMÁS SE SUBIO CORRECTAMENTE
if (isset($_FILES["archivo"]) && is_uploaded_file($_FILES['archivo']['tmp_name'])) {
 
 //SE ABRE EL ARCHIVO EN MODO LECTURA
 $fp = fopen($_FILES['archivo']['tmp_name'], "r");
 //SE RECORRE

     $n = 0;
     $t = 0; 
      while ($data = fgetcsv ($fp, 1000, ";")){//while (!feof($fp)){ //LEE EL ARCHIVO A DATA, LO VECTORIZA A DATA
     // echo '<pre>';print_r($data);die;
      
      //SI SE QUIERE LEER SEPARADO POR TABULADORES
      //$data  = explode(" ", fgets($fp));
      //SI SE LEE SEPARADO POR COMAS
      //$data  = explode(";", fgets($fp));
      
      //AHORA DATA ES UN VECTOR Y EN CADA POSICIÓN CONTIENE UN VALOR QUE ESTA SEPARADO POR COMA.
      //EJEMPLO    A, B, C, D
      //$data[0] CONTIENE EL VALOR "A", $data[1] -> B, $data[2] -> C.
    
    
      //SI QUEREMOS VER TODO EL CONTENIDO EN BRUTO:
       //echo '<pre>';print_r($data);
    /*
    Array
(
    [0] => 76679
    [1] => MARTES
    [2] => 03:00:00 p. m.
    [3] => 06:00:00 p. m.
    [4] => 21/07/2014
    [5] => 28/11/2014
    [6] => 0
    [7] => usaquen
    [8] => 
    [9] => K103
)
    */
       $SQL_Grupo='SELECT idgrupo FROM grupo WHERE idgrupo="'.$data[0].'" AND codigoestadogrupo=10'; 
       
       if($Grupo=&$db->Execute($SQL_Grupo)===false){
            echo 'Error en el SQl ....<br><br>'.$SQL_Grupo; 
            die;
       } 
      
       if(!$Grupo->EOF){
           /***********************************************/
                $Grupo_id = $data[0];
        
                $DiaSemana = trim($data[1]);
                
                $DiaSemana = str_replace(' ','',$DiaSemana);
                
                $SQL_Dia='SELECT codigodia FROM dia WHERE nombredia="'.$DiaSemana.'"';
                
                if($Dia=&$db->Execute($SQL_Dia)===false){
                    echo 'Error en el SQL del Dia...<br><BR>'.$SQL_Dia;
                    die;
                }
                
                $CodigoDia = $Dia->fields['codigodia'];
                
                $C_Horaini = explode(' ',$data[2]);//Dessarmar la Hora Inicial
                //echo '<pre>';print_r($C_Horaini);die;
                if($C_Horaini[1]=='AM' || $C_Horaini[1]=='am' || $C_Horaini[1]=='A.M.' || $C_Horaini[1]=='a.m.'){
                    $Horaini = $C_Horaini[0];
                }else{
                    $H_inicial = explode(':',$C_Horaini[0]);
                    echo '<pre>';print_r($H_inicial);
                    if($C_Horaini[1]=='PM' || $C_Horaini[1]=='pm' || $C_Horaini[1]=='P.M.' || $C_Horaini[1]=='p.m.'){
                        if($H_inicial[0]==12){
                            $Horaini = $H_inicial[0].':'.$H_inicial[1];
                        }else{
                            $H = $H_inicial[0]+12;
                            $Horaini = $H.':'.$H_inicial[1];
                        }
                    }
                }//if hora Inicial
                
                $C_Horafin = explode(' ',$data[3]);//Dessarmar la Hora final
                
                if($C_Horafin[1]=='AM' || $C_Horafin[1]=='am' || $C_Horafin[1]=='A.M.' || $C_Horafin[1]=='a.m.'){ 
                    $Horafin = $C_Horafin[0];
                }else{ 
                   
                   if($C_Horafin[1]=='PM' || $C_Horafin[1]=='pm' || $C_Horafin[1]=='P.M.' || $C_Horafin[1]=='p.m.'){ 
                        if($C_Horafin[0]==12){ 
                            $Horafin = $C_Horafin[0].' '.$C_Horafin[1];
                        }else{ 
                            //$C_DHora = explode(':',$C_Horafin[0]);
                            $H = $C_Horafin[0]+12;
                            $Horafin = $H.':'.$C_DHora[1];
                        }
                    }
                }//if hora final
                  
                //echo '<br>hora ini->'.$Horaini.'horafin-->'.$Horafin.'<br><br>';die;
                
                $C_Fechaini = explode('/',$data[4]);//Fecha Inicial.
                
                $Fechainicial = $C_Fechaini[2].'-'.$C_Fechaini[1].'-'.$C_Fechaini[0];
                
                $C_Fechafin = explode('/',$data[5]);//Fecha Final.
                
                $Fechafinal = $C_Fechafin[2].'-'.$C_Fechafin[1].'-'.$C_Fechafin[0];
                
                $SQL_Sede='SELECT 
        
                            ClasificacionEspaciosId AS id
        
                          FROM 
                            
                            ClasificacionEspacios 
                          
                          WHERE 
                            Nombre="'.$data[7].'" 
                            AND 
                            codigoestado=100 
                            AND 
                            ClasificacionEspacionPadreId=1';
                    
                    if($sedes=&$db->Execute($SQL_Sede)===false){
                        echo 'Error en el SQL de las Sedes...<br><br>'.$SQL_Sede;
                        die;
                    }       
                    
                 if(!$sedes->EOF){
                    $Sede_id = $sedes->fields['id'];
                 }else{
                    $Sede_id = 4;
                 }
                 
                $Espacio = trim($data[9]);
                
                $Espacio = str_replace(' ','',$Espacio);
                
                $SQL_Aula='SELECT
        
                            x.id
                            
                            FROM(
                            
                            SELECT 
                            
                            ClasificacionEspaciosId AS id,
                            ClasificacionEspacionPadreId 
                            
                            
                            FROM ClasificacionEspacios 
                            
                            WHERE Nombre="'.$Espacio.'" AND codigoestado=100
                            ) x INNER JOIN ClasificacionEspacios a ON x.ClasificacionEspacionPadreId=a.ClasificacionEspaciosId
                            
                            WHERE
                            
                            a.ClasificacionEspacionPadreId="'.$Sede_id.'"';
                            
                 //echo '<br><br>SQLConsulta-><samp style="color: pink;">'.$SQL_Aula.'</samp>';           
                 
                 if($Aula=&$db->Execute($SQL_Aula)===false){
                    echo 'Error en el SQl de Aulas...<br><br>'.$SQL_Aula;
                    die;
                 }
                 $Aula_id = '';
                 
                 
               //  echo '<br><br> DatoBD-><samp style="color: red;">'.$Aula->fields['id'].'</samp>';
                 
                 if(!$Aula->EOF){
                    $Aula_id = $Aula->fields['id'];
                 }else{
                    $Aula_id = 212;
                 }
                 
                 $Aula_old = $Aula_id;
                 
                
              
        $SQL_Insert='INSERT INTO SolicitudAsignacionEspacios(AccesoDiscapacitados,FechaInicio,FechaFinal,idsiq_periodicidad,ClasificacionEspaciosId,UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaUltimaModificacion,codigodia,observaciones)VALUES("'.$data[6].'","'.$Fechainicial.'","'.$Fechafinal.'","35","'.$Sede_id.'","'.$userid.'","'.$userid.'",NOW(),NOW(),"'.$CodigoDia.'","'.$data[8].'")';
         
         //echo '<br><br>$SQL_Insert-><samp style="color: green;">'.$SQL_Insert.'</samp>';
         
         if($InsertSolicitud=&$db->Execute($SQL_Insert)===false){
            echo 'Error en el SQL de la Solicitud...<br><br>'.$SQL_Insert;
            die;
         }
         
         $t++;
         $id=$db->Insert_ID();
         
         $InserGrupo='INSERT INTO SolicitudEspacioGrupos(SolicitudAsignacionEspacioId,idgrupo)VALUES("'.$id.'","'.$Grupo_id.'")';  
         
         //echo '<br><br>$InserGrupo->'.$InserGrupo;
         
         if($GrupoSolicitud=&$db->Execute($InserGrupo)===false){
            echo 'Error en el SQL de Solicitud Grupo...<br><br>'.$InserGrupo;
            die;
         }
         
         $InserTipoSalon='INSERT INTO SolicitudAsignacionEspaciostiposalon(SolicitudAsignacionEspacioId,codigotiposalon)VALUES("'.$id.'","32")';  
         
         //echo '<br><br>$InserGrupo->'.$InserGrupo;
         
         if($TipoSalonSolicitud=&$db->Execute($InserTipoSalon)===false){
            echo 'Error en el SQL de Solicitud codigotiposalon...<br><br>'.$InserTipoSalon;
            die;
         }
         
         //var_dump(is_file('Solicitud/SolicitudEspacio_class.php'));die;
         
         
         $C_dias[]=$CodigoDia;
         
         
         
         $Result = $C_SolicitudEspacio->FechasFuturas('35',$Fechainicial,$Fechafinal,$C_dias);
         //echo '<br><br>hola mundo....';
         //echo '<pre>';print_r($Result);die;
         
         $j = count($Result)-1;
         
         for($i=0;$i<count($Result[$j]);$i++){
            /*********************************************************************/
            $FechaFutura = $Result[$j][$i];
            
            $C_DatosDia  = explode('-',$FechaFutura);
                
             $dia  = $C_DatosDia[2];
             $mes  = $C_DatosDia[1];
                
             $Festivo = $C_Festivo->esFestivo($dia,$mes);
             
              if($Festivo==false){//$Festivo No es Festivo
                
                /*Validacion de Si el aula esta disponible*/
                 
                 $Disponible = $C_AsignacionSalon->ValidacionEspacio($db,$FechaFutura,$Horaini,$Horafin,$Aula_id);
                 
                /*******************************************/
                //$Aula_old = $Aula_id;
                //echo '<br><br>$Disponible->'.$Disponible;
                
                if($Disponible==1){
                    $Aula_id = $Aula_id;
                    
                  }else{
                    $Aula_id = 212;
                    
                    if($FechaFutura){
                        $FaltaAsignarAula['grupoid'][] = $data[0];
                        $FaltaAsignarAula['fecha'][]   = $FechaFutura;
                        $FaltaAsignarAula['Aula_old'][]   = $Aula_id;
                        $FaltaAsignarAula['Espacio'][]   = $Espacio;
                        $FaltaAsignarAula['hora_1'][]   = $Horaini;
                        $FaltaAsignarAula['hora_2'][]   = $Horafin; 
                        $n++;
                    }
                   // echo '<br>Falta Asignar Espacio en la fecha :'.$FechaFutura.' Para la solicitud del Grupo id : $data[0];
                    //echo '<pre>';print_r($data);
                }
                
               //echo '<br><br> DatoBD__2-><samp style="color: blue;">'.$Aula_id.'</samp>'; 
           
              
              $Asignacion='INSERT INTO AsignacionEspacios(FechaAsignacion,SolicitudAsignacionEspacioId,UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaultimaModificacion,ClasificacionEspaciosId,HoraInicio,HoraFin)VALUES("'.$FechaFutura.'","'.$id.'","'.$userid.'","'.$userid.'",NOW(),NOW(),"'.$Aula_id.'","'.$Horaini.'","'.$Horafin.'")';
               
                //echo '<br><br>$Asignacion-><samp style="color: blue;">'.$Asignacion.'</samp>'; 
                
                if($InsertAsignar=&$db->Execute($Asignacion)===false){
                    echo 'Error en el SQl de Asignacion...<br><br>'.$Asignacion;
                    die;
                }
                
             }//$Festivo No es Festivo
            /*********************************************************************/
         }//for
         
           /***********************************************/
       }else{
           $NoExiste[]=$data; 
          
       } 
       
    }//while
 
//echo '<pre>';print_r($FaltaAsignarAula);
?>
<table border=1>
    <tr>
        <td colspan="7">Error Al asignar el Espacio</td>
    </tr>
    <tr>
        <td>N</td>
        <td>Grupo id</td> 
        <td>Fecha</td>
    </tr>
    <?PHP 
    $Error = count($FaltaAsignarAula['grupoid']);
    for($f=0;$f<$Error;$f++){
        ?>
        <tr>
            <td><?PHP echo $f+1;?></td>
            <td><?PHP echo $FaltaAsignarAula['grupoid'][$f]?></td>
            <td><?PHP echo $FaltaAsignarAula['fecha'][$f]?></td>
            <td><?PHP echo $FaltaAsignarAula['Aula_old'][$f]?></td>
            <td><?PHP echo $FaltaAsignarAula['Espacio'][$f]?></td>
            <td><?PHP echo $FaltaAsignarAula['hora_1'][$f]?></td>
            <td><?PHP echo $FaltaAsignarAula['hora_2'][$f]?></td>
        </tr>
        <?PHP
    }//for
    ?>
</table>
<br />
<table border=1>
    <tr>
        <td colspan="10"><strong>Error el Codigo Grupo ID No Exite...</strong></td>
    </tr>
    <?PHP 
    $No = count($NoExiste);
    for($n=0;$n<$No;$n++){
        ?>
         <tr>
            <td><?PHP echo $n+1;?></td>
            <td><?PHP echo $NoExiste[$n][0]?></td>
            <td><?PHP echo $NoExiste[$n][1]?></td>
            <td><?PHP echo $NoExiste[$n][2]?></td>
            <td><?PHP echo $NoExiste[$n][3]?></td>
            <td><?PHP echo $NoExiste[$n][4]?></td>
            <td><?PHP echo $NoExiste[$n][5]?></td>
            <td><?PHP echo $NoExiste[$n][6]?></td>
            <td><?PHP echo $NoExiste[$n][7]?></td>
            <td><?PHP echo $NoExiste[$n][9]?></td>
        </tr>
        <?PHP
    }//for
    ?>
   
</table>
<?PHP
//echo '<pre>';print_r($DataReal);
} else{
    echo "Error de subida";
    
} 
 
?> 
