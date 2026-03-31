<?PHP 
$ruta = "../";
 
 global $db;
 
    while (!is_file($ruta.'Connections/sala2.php'))
    {
        $ruta = $ruta."../";
    } 
    require_once($ruta.'Connections/sala2.php');
    $rutaado = $ruta."funciones/adodb/";
    require_once($ruta.'Connections/salaado.php');
    
    $ruta = "../";
?>
