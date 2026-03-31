<?php

/*
 * Clase con funciones genéricas para la gestión de usuarios
 */
session_start();
class functionsUsersClass {
    //var $loginUrl="https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/consultafacultadesv22.htm";
    
    function __construct() {
        
    }
    
    /**
    * Verificación de si el usuario ha iniciado sesión en el sistema de sala o no 
    * Ojo que para el redirect con header no se puede imprimir nada antes en la página
    */
    public function verifySession() {        
        //var_dump($_SESSION['MM_Username']);
        if(!isset ($_SESSION['MM_Username'])){
            header('Location: https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/consultafacultadesv2.htm');
            //echo "No ha iniciado sesión en el sistema";
            exit();
        }
    }
    
    function __destruct() {
        
    }
}
?>
