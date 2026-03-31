<?php 
          session_start();      
    require_once(realpath(dirname(__FILE__)).'/../../Connections/sala2.php' );
    mysql_select_db($database_sala, $sala);
    $x = $_GET["codigomodalidadacademica"];
    $_SESSION['codigomodalidadacademica'] = $x;

$departamento="departamento";
$curso="curso";

        $cad= 'SELECT 
            codigocarrera, 
            nombrecarrera 
            from carrera   
            WHERE codigomodalidadacademica = '.$x.' 
            and nombrecarrera NOT LIKE "%'.$departamento.'%"
            AND nombrecarrera not like "%'.$curso.'%" 
            and codigocarrera not in (30, 39, 74, 138, 2, 1, 12, 79, 3, 868, 4)  
            and fechavencimientocarrera > now()
            ORDER BY nombrecarrera';




    $Programa = mysql_query($cad, $sala) or die("$query".mysql_error());


?>
        <option value="">Seleccionar</option>
<?php

        while($ListProgramas = mysql_fetch_assoc($Programa))
    {

?>
        <option value="<?php echo $ListProgramas['codigocarrera']; ?>"><?php echo $ListProgramas['nombrecarrera']; ?></option>
<?php
    }

?>