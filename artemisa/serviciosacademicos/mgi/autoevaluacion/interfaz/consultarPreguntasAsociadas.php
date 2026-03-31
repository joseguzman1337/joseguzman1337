<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    $ruta = "../";
    while (!is_file($ruta.'Connections/sala2.php'))
        {
            $ruta = $ruta."../";
        }
        require_once($ruta.'Connections/sala2.php');
        $rutaado = $ruta."funciones/adodb/";
    require_once($ruta.'Connections/salaado.php');
    
    $idPregunta = $_REQUEST["idPregunta"];
    $idRespuesta = $_REQUEST["respuestaElegida"];
    $id_instrumento = $_REQUEST["idInstrumento"];
    
    $mostrar = array();
    $ocultas = array();
    //echo $idRespuesta;
    if($idRespuesta!=NULL && $idRespuesta!=="null"){
    $query_tipo= "SELECT p.titulo, p.idsiq_Apregunta, p.cat_ins, dep.idsiq_ApreguntaRespuestaDependencia as dependencia, 
                                                        ins.idsiq_Ainstrumento, p.idsiq_Atipopregunta,  
                                                        ins.idsiq_Apregunta as preg_asig, ins.idsiq_Ainstrumentoconfiguracion, 
                                                        ins.idsiq_Aseccion, ins.codigoestado, sec.nombre as secce
                                                        FROM siq_Apregunta as p
                                                        inner join siq_Ainstrumento as ins on (ins.idsiq_Apregunta=p.idsiq_Apregunta 
                                                                                              and ins.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."')
                                                        inner join siq_Aseccion as sec on (sec.idsiq_Aseccion=ins.idsiq_Aseccion)
                                                        inner join siq_ApreguntaRespuestaDependencia dep on dep.tipo=1 
                                                        AND dep.idInstrumento='".$id_instrumento."' where p.codigoestado=100 
                                                        AND dep.codigoestado=100 AND dep.idRespuesta NOT IN 
                                                            (".$idRespuesta.") AND dep.idDependencia=ins.idsiq_Ainstrumento
                                                            AND dep.idRespuesta IN (SELECT idsiq_Apreguntarespuesta 
                                                            FROM siq_Apreguntarespuesta
                                                            WHERE idsiq_Apregunta='".$idPregunta."')
                                                       group by p.idsiq_Apregunta;";
    } else {
        $query_tipo= "SELECT p.titulo, p.idsiq_Apregunta, p.cat_ins, dep.idsiq_ApreguntaRespuestaDependencia as dependencia, 
                                                        ins.idsiq_Ainstrumento, p.idsiq_Atipopregunta,  
                                                        ins.idsiq_Apregunta as preg_asig, ins.idsiq_Ainstrumentoconfiguracion, 
                                                        ins.idsiq_Aseccion, ins.codigoestado, sec.nombre as secce
                                                        FROM siq_Apregunta as p
                                                        inner join siq_Ainstrumento as ins on (ins.idsiq_Apregunta=p.idsiq_Apregunta 
                                                                                              and ins.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."')
                                                        inner join siq_Aseccion as sec on (sec.idsiq_Aseccion=ins.idsiq_Aseccion)
                                                        inner join siq_ApreguntaRespuestaDependencia dep on dep.tipo=1 
                                                        AND dep.idInstrumento='".$id_instrumento."' where p.codigoestado=100 
                                                        AND dep.codigoestado=100 AND dep.idDependencia=ins.idsiq_Ainstrumento
                                                            AND dep.idRespuesta IN (SELECT idsiq_Apreguntarespuesta 
                                                            FROM siq_Apreguntarespuesta
                                                            WHERE idsiq_Apregunta='".$idPregunta."')
                                                       group by p.idsiq_Apregunta;";
    }
    $ocultas = $db->GetArray($query_tipo);
    //echo $query_tipo;
    
    $query_tipo= "SELECT p.titulo, p.idsiq_Apregunta, p.cat_ins, dep.idsiq_ApreguntaRespuestaDependencia as dependencia, 
                                                        ins.idsiq_Ainstrumento, p.idsiq_Atipopregunta,  
                                                        ins.idsiq_Apregunta as preg_asig, ins.idsiq_Ainstrumentoconfiguracion, 
                                                        ins.idsiq_Aseccion, ins.codigoestado, sec.nombre as secce
                                                        FROM siq_Apregunta as p
                                                        inner join siq_Ainstrumento as ins on (ins.idsiq_Apregunta=p.idsiq_Apregunta 
                                                                                              and ins.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."')
                                                        inner join siq_Aseccion as sec on (sec.idsiq_Aseccion=ins.idsiq_Aseccion)
                                                        inner join siq_ApreguntaRespuestaDependencia dep on dep.tipo=1 
                                                        AND dep.idInstrumento='".$id_instrumento."' where p.codigoestado=100 
                                                        AND dep.codigoestado=100 AND dep.idRespuesta IN 
                                                            (".$idRespuesta.") AND dep.idDependencia=ins.idsiq_Ainstrumento
                                                       group by p.idsiq_Apregunta;";
    $mostrar = $db->GetArray($query_tipo);
    //echo $query_tipo;
    
    $data = array('success'=> true,'ocultar'=> $ocultas,'totalOcultar'=> count($ocultas),'mostrar'=>$mostrar,'totalMostrar'=> count($mostrar));
    
    echo json_encode($data);
?>
