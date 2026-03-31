<?php
    $ruta = "../";
    while (!is_file($ruta.'Connections/sala2.php'))
    {
        $ruta = $ruta."../";
    }
    require_once($ruta.'Connections/sala2.php');
    $rutaado = $ruta."funciones/adodb/";
    require_once($ruta.'Connections/salaado.php');
    require_once('pintarSecciones.php');
    
    $id_instrumento = $_POST["idInstrumento"];
    $userid = $_POST["usuario"];
    $sql_cp="SELECT ins.idsiq_Aseccion,  sec.nombre as secce
            FROM  siq_Ainstrumento as ins
            inner join siq_Aseccion as sec on (sec.idsiq_Aseccion=ins.idsiq_Aseccion)
            where ins.codigoestado=100 
            and sec.codigoestado=100 
            and ins.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."'
            AND
            ins.idsiq_Aseccion IN (
                SELECT 
                insecc.idsiq_Aseccion 
                FROM 
                siq_ApreguntaRespuestaDependencia dep                            
                INNER JOIN siq_Ainstrumentoseccion insecc ON (insecc.idsiq_Ainstrumentoseccion=dep.idDependencia AND insecc.codigoestado=100 )
                INNER JOIN siq_Arespuestainstrumento r ON (r.idsiq_Ainstrumentoconfiguracion=dep.idInstrumento AND dep.idRespuesta=r.idsiq_Apreguntarespuesta AND r.codigoestado=100 
                AND (r.cedula='".$_POST['n']."' OR r.usuariocreacion='".$userid."') )
                WHERE dep.idInstrumento='".$id_instrumento."' AND dep.codigoestado = 100 AND dep.tipo=2 
                GROUP BY insecc.idsiq_Aseccion 
            )
            AND
            ins.idsiq_Aseccion NOT IN (
               SELECT i.idsiq_Aseccion
                FROM siq_Arespuestainstrumento r 
                INNER JOIN siq_Ainstrumento i ON (r.idsiq_Ainstrumentoconfiguracion=i.idsiq_Ainstrumentoconfiguracion AND r.idsiq_Apregunta=i.idsiq_Apregunta)
                WHERE r.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' 
                AND r.codigoestado = 100
                AND(r.cedula='".$_POST['n']."' OR r.usuariocreacion='".$userid."')
                GROUP BY i.idsiq_Aseccion      
            )
            group by idsiq_Aseccion  ";  
            $data_cp = $db->Execute($sql_cp); 
            
            $secciones = pintarSecciones($data_cp,$id_instrumento,$db,true);
            
            echo json_encode($secciones);
            exit();
?>
