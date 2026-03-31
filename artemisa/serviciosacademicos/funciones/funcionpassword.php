<?php
function generar_pass ($longitud) 
{ 
        mt_srand((double)microtime()*1000000); 

        $letras=array (array ("a","e","i","o","u"),array ("b","c","d","f","g","h","j","k","l","m","n","p","q","r","s","t","v","w","x","y","z"),array ("1","2","3","4","5","6","7","8","9"),array ("1","2","3","4","5","6","7","8","9")); 

        // Primer caracter 
        $primero=mt_rand (0,2); 
        $elemento=mt_rand (0,count ($letras[$primero])-1); 
        $password=$letras[$primero][$elemento]; 
        if ($primero!=0) $cons=true; 

        while (strlen ($password)<$longitud) 
		{ 
                if ($cons) { 
                        $index_prob=mt_rand (0,4); 
                        $password.=$letras[0][$index_prob]; 
                        $cons=false; 
                } 
                else { 
                        $cons=array ("1","1","1","2","3"); 
                        // tiene mas probabilidades, 3/5 de salir solo una consonante 
                        $index_prob=mt_rand (0,count($cons)-1); 
                        $elemento=mt_rand (0,count ($letras[$cons[$index_prob]])-1); 
                        $password.=$letras[$cons[$index_prob]][$elemento]; 
                } 
        } 
        return substr ($password,0,$longitud); 
		// ya que si lo ultimo añadido es una consonante doble puede que estemos añadiendo un caracter de mas 
}
//$pass = generar_pass(8);
?>