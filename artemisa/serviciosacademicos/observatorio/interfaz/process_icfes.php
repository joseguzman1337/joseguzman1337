<?php

require('../../Connections/sala2.php');
$sala2 = $sala;

$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');

if (isset($_POST['grabado']))
{
    $asignaturas = explode(":", $_POST['asignatura']);
    $puntajes = explode(":", $_POST['puntaje']);
    $niveles = explode(":", $_POST['nivel']);
    $deciles = explode(":", $_POST['decil']);
    $percentiles = explode(":", $_POST['percentil']);
    $id_update=explode(":", $_POST['id']);
    $chequeofacultad=explode(":", $_POST['checkfacultad']);
    $banderagrabar = 0;
    
    $query_datosgrabados = "SELECT count(*) as 'conteo' FROM detalleresultadopruebaestado d,resultadopruebaestado r WHERE r.idestudiantegeneral = '".$_POST['idestudiante']."' and r.idresultadopruebaestado = d.idresultadopruebaestado and d.codigoestado like '1%' ";    
    $row_datosgrabados = $db->GetRow($query_datosgrabados);    
        
    if ($row_datosgrabados['conteo'] > "0")
    {        
        /////////////////mofificar registro
        if ($banderagrabar == 0) 
        {
            if($_POST['nombre'])
            {
                $nombre =  "nombreresultadopruebaestado = '".$_POST['nombre']."',";
            }
            if($_POST['puesto'])
            {
                $puesto = "puestoresultadopruebaestado = '".$_POST['puesto']."',";
            }
            if($_POST['fecha1'])
            {
                $fechas = "fecharesultadopruebaestado = '".$_POST['fecha1']."',";
            }
            if($_POST['descripcion'])
            {
                $observacion = "observacionresultadopruebaestado = '".$_POST['descripcion']."',";
            }
            $base="update resultadopruebaestado set ".$nombre." numeroregistroresultadopruebaestado = '".$_POST['registro']."', 		 ".$puesto.$fechas.$observacion." PuntajeGlobal = '".$_POST['puntaje_global']."' where idestudiantegeneral = '".$_POST['idestudiante']."'";                   
            $sol = $db->Execute($base);
            
            for ($i=0; $i<count($asignaturas);$i++) 
            {                
                if ($puntajes[$i] <> "") 
                {        
                    $base1="update detalleresultadopruebaestado set notadetalleresultadopruebaestado = '".$puntajes[$i]."', nivel = '".$niveles[$i]."', decil = '".$deciles[$i]."', ChequeoFacultad=".$chequeofacultad[$i]." where iddetalleresultadopruebaestado = '".$id_update[$i]."'";                    
                    $sol1 = $db->Execute($base1);
                }
            }//for
                    
            $a_vectt['val'] = 'NO_Exite';
            $a_vectt['descrip'] = 'El registro de saber 11 fue actualizado';
            echo json_encode($a_vectt);
        }//if
        
    }else
    {
        ///////agregar registro nuevo
        if ($banderagrabar == 0)
        {
            if(isset($_POST['prueba_tipo'])&&($_POST['prueba_tipo']=="1"))
            {
                $query_resultado = "INSERT INTO resultadopruebaestado(idresultadopruebaestado,nombreresultadopruebaestado,idestudiantegeneral,numeroregistroresultadopruebaestado,puestoresultadopruebaestado,fecharesultadopruebaestado,observacionresultadopruebaestado,codigoestado)
            	VALUES(0,'".$_POST['nombre']."','".$_POST['idestudiante']."','".$_POST['registro']."','".$_POST['puesto']."','".$_POST['fecha1']."','prueba antes del 01-ago-2014: ".$_POST['descripcion']."','100' )";                      
            	$resultado = $db->Execute($query_resultado);
            	$idrespuesta = $db->Insert_ID();
            	for ($i=0; $i<count($asignaturas);$i++)
                {
                    if ($puntajes[$i] <> "")
                    {
                        $query_puntajeresultado = "INSERT INTO detalleresultadopruebaestado(iddetalleresultadopruebaestado,idresultadopruebaestado,idasignaturaestado,notadetalleresultadopruebaestado,codigoestado,ChequeoFacultad)
                        VALUES(0,'$idrespuesta','".$asignaturas[$i]."','".$puntajes[$i]."','100',".$chequeofacultad[$i].")";
                        $puntajeresultado = $db->Execute($query_puntajeresultado);
                    }
                }//for
            }
            if(isset($_POST['prueba_tipo'])&&($_POST['prueba_tipo']=="2"))
            {
                $query_resultado = "INSERT INTO resultadopruebaestado(idresultadopruebaestado,nombreresultadopruebaestado,idestudiantegeneral,numeroregistroresultadopruebaestado,puestoresultadopruebaestado,fecharesultadopruebaestado,observacionresultadopruebaestado,PuntajeGlobal,codigoestado)
                VALUES(0,'".$_POST['nombre']."','".$_POST['idestudiante']."','".$_POST['registro']."','".$_POST['puesto']."','".$_POST['fecha1']."','prueba entre 01-ago-2014 y 01-mar-2016: ".$_POST['descripcion']."','".$_POST['puntaje_global']."','100' )";                
                $resultado = $db->Execute($query_resultado);
            	$idrespuesta = $db->Insert_ID();
            	for ($i=0; $i<count($asignaturas);$i++)
                {
                    if ($puntajes[$i] <> "")
                    {              
                        $query_puntajeresultado = "INSERT INTO detalleresultadopruebaestado(iddetalleresultadopruebaestado,idresultadopruebaestado,idasignaturaestado,notadetalleresultadopruebaestado,nivel,decil,codigoestado,ChequeoFacultad)
                    	VALUES(0,'$idrespuesta','".$asignaturas[$i]."','".$puntajes[$i]."','".$niveles[$i]."','".$deciles[$i]."','100',".$chequeofacultad[$i].")";
                    	$puntajeresultado = $db->Execute($query_puntajeresultado);
                    }
                }            
            }
            if(isset($_POST['prueba_tipo'])&&($_POST['prueba_tipo']=="3"))
            {
                $query_resultado = "INSERT INTO resultadopruebaestado(idresultadopruebaestado,nombreresultadopruebaestado,idestudiantegeneral,numeroregistroresultadopruebaestado,puestoresultadopruebaestado,fecharesultadopruebaestado,observacionresultadopruebaestado,PuntajeGlobal,codigoestado)
                VALUES(0,'".$_POST['nombre']."','".$_POST['idestudiante']."','".$_POST['registro']."','".$_POST['puesto']."','".$_POST['fecha1']."','prueba despues del  01-mar-2016: ".$_POST['descripcion']."','".$_POST['puntaje_global']."','100' )";                
                $resultado = $db->Execute($query_resultado);
            	$idrespuesta = $db->Insert_ID();
            	for ($i=0; $i<count($asignaturas);$i++)
                {
                    if ($puntajes[$i] <> "")
                    {              
                        $query_puntajeresultado = "INSERT INTO detalleresultadopruebaestado(iddetalleresultadopruebaestado,idresultadopruebaestado,idasignaturaestado,notadetalleresultadopruebaestado,nivel,decil,codigoestado,ChequeoFacultad)
                    	VALUES(0,'$idrespuesta','".$asignaturas[$i]."','".$puntajes[$i]."','".$niveles[$i]."','".$percentiles[$i]."','100',".$chequeofacultad[$i].")";
                    	$puntajeresultado = $db->Execute($query_puntajeresultado);
                    }
                }                 
            }
            
            $a_vectt['val'] = 'NO_Exite';
            $a_vectt['descrip'] = 'El registro de saber 11 fue agregado';
            echo json_encode($a_vectt);
            //echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=ingresoicfes_new.php?inicial&idestudiante=".$_POST['idestudiante']."'>";
        }
    }  
}//grabado
?>