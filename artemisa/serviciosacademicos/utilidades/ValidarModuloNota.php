<?php
//var_dump (is_file(realpath(dirname(__FILE__)).'/DiasHorasAmdin.php'));die;
include_once(realpath(dirname(__FILE__)).'/DiasHorasAmdin.php');

class ValidarModulo
{
    public function ValidarIngresoModulo($user, $ip, $modulo)
    {
        
        $C_ValidarFecha = new AdminDiasHorasssss(); 
        $t = $C_ValidarFecha->ingresoFecha($user, $ip, $modulo);
               
        if($t == true)
        {
            $mensaje = "<strong>La función a la que está intentando ingresar no se encuentra activa temporalmente, por favor inténtelo durante los días y horas de oficina.</strong>";
            return $mensaje; 
        }
    } 
}


?>