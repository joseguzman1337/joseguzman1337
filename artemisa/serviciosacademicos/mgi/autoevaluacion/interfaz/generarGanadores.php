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

$ids = $_REQUEST["idEncuesta"];
$textoIn = "";
foreach($ids as $id){
    if($textoIn===""){
        $textoIn .= $id;
    } else {
        $textoIn .= ",".$id;
    }
}
$sql = "SELECT 
                    DISTINCT usuarioid,a.numerodocumento, 
                                    eg.nombresestudiantegeneral, 
                                    eg.apellidosestudiantegeneral
            
            						FROM 
            
            						actualizacionusuario  a
            INNER JOIN  estudiantegeneral eg on eg.numerodocumento=a.numerodocumento     
            						WHERE  
            
            						a.id_instrumento IN (".$textoIn.") 
            						AND
            						a.codigoestado=100
                                    AND
                                    a.estadoactualizacion=2 ORDER BY RAND() LIMIT ".$_REQUEST["numGanadores"];
    $ganadores = $db->GetArray($sql);

    $html = "<h4>Los ganadores son:</h4><ol>";
    foreach($ganadores as $ganador){
        $html .= "<li>".$ganador["nombresestudiantegeneral"]." ".$ganador["apellidosestudiantegeneral"]
                ." - ".$ganador["numerodocumento"]."</li>";
    }
    $html .= "</ol>";
    echo $html;
?>
