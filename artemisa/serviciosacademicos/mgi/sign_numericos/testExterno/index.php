<?PHP  
function array_envia($array) { 
    $tmp = serialize($array); 
    $tmp = urlencode($tmp); 
    return $tmp; 
}


$prueba = "PHP";
    $array=array(
       // array(0,18,3,1,555),
       // array(0,18,4,1,777),
       // array(0,18,5,1,888),
       //  array(0,18,6,1,999),
        array(1,2,1,444,3),
        );

$array=array_envia($array);


// Usando un formulario y campo hidden. 
echo <<<HTML
<form action="recibir_array.php" method="POST"> 
   <input name="array" type="hidden" value="$array"> 
   <input name="enviar" type="submit" value=" Enviar "> 
</form>  
HTML;
// Usando un link (URL).
echo "<a href='http://172.16.3.227/serviciosacademicos/mgi/sign_numericos/adminFunciones/funciontipo1.php?array=$array'>pasar array</a>";
?>