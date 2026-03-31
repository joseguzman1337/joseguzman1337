<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
error_reporting('ALL');
ini_set('max_execution_time','6000');
require_once('../../Connections/sala2.php');
$ruta="../../";
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
require_once('../../class/table.php');
require_once('../../class/Class_andor.php');
//session_start();


$documento = 33333;
$objAndor = new class_andor($documento);

if(!$objAndor->servidor_activo()){
    echo "El Servicio no esta disponible no se puede realizar sincronizacion";
   Exit();
}



   
$usuario = $_SESSION['MM_Username'];
$periodoactual = $_SESSION['codigoperiodosesion'];
$query = "SELECT * FROM tarjetaestudiante";
$estudiantes_sala = new table("tarjetaestudiante");
//$estudiantes_sala->sql_select = "codigoestudiante";
$estudiantes_sala->sql_where = " (sinc_andover is null or sinc_andover ='0') and codigoestado = 100;";
//$estudiantes_sala->debug == true;
$array_estudiantes_sala = $estudiantes_sala->getData();
//echo "<pre>";
//print_r($array_estudiantes_sala);



$obj_table = new table("tarjetaestudiante");
$obj_table->setFields();
$obj_table->fieldlist['idtarjetaestudiante'] = array('pkey' => 'y');

if(is_array($array_estudiantes_sala)){
    echo "<table border=1>";

    foreach ($array_estudiantes_sala as $data_estu){
        echo "<tr>";
        echo "<td>".$data_estu['codigotarjetaestudiante']."</td>";
        echo "<td>".$data_estu['codigoestado']."</td>";    
        //if($data_estu['sinc_andover']==""){
            echo "<td>".$data_estu['codigoestado']."</td>";
            $estudiante_sala = new table("estudiantegeneral");
            $estudiante_sala->sql_select = "numerodocumento, nombresestudiantegeneral, apellidosestudiantegeneral ";
            $estudiante_sala->sql_where = " idestudiantegeneral = '".$data_estu['idestudiantegeneral']."' ;";
            $data_estudiante = $estudiante_sala->getData();
            $data_estudiante = $data_estudiante[0];
            //print_r($data_estudiante);
            echo "<td>".$data_estudiante['numerodocumento']."</td>";
            $objAndor = new class_andor($data_estudiante['numerodocumento']);
            $NivelAcceso = 1;
            $objAndor->setNivelAcceso($NivelAcceso);
            $objAndor->setNumeroTarjeta($data_estu['codigotarjetaestudiante']);
            echo "<td>";
            $rsutl = $objAndor->get_ws_result();
            print_r($rsutl);
            $objAndor->setDocumento($data_estudiante['numerodocumento']);
            $objAndor->setApellido($data_estudiante['apellidosestudiantegeneral']);
            $objAndor->setNombres($data_estudiante['nombresestudiantegeneral']);

            if($rsutl[0]['NumeroTarjeta'] == ""){
                $rsutl = $objAndor->set_ws_result();
                $rsutl = $objAndor->get_ws_result();
                if($rsutl[0]['NumeroTarjeta'] != ""){
                    $fieldarray_tarjeta['idtarjetaestudiante'] = $data_estu['idtarjetaestudiante'];
                    $fieldarray_tarjeta['sinc_andover'] = 1;
                    $obj_table->updateRecord($fieldarray_tarjeta);
                }else{
                    $fieldarray_tarjeta['idtarjetaestudiante'] = $data_estu['idtarjetaestudiante'];
                    $fieldarray_tarjeta['sinc_andover'] = 0;
                    $obj_table->updateRecord($fieldarray_tarjeta);
                }
            }else{                
                $fieldarray_tarjeta['idtarjetaestudiante'] = $data_estu['idtarjetaestudiante'];
                $fieldarray_tarjeta['sinc_andover'] = 1;
                $obj_table->updateRecord($fieldarray_tarjeta);   
            }
            echo "</td>";

            /*1885351053	100	100	1020765128*/
            //print_r($rsutl);
            //$objAndor->setApellido($data_estudiante['apellidosestudiantegeneral']);
            //$objAndor->setNombres($data_estudiante['apellidosestudiantegeneral']);
            //echo "<td>".
            
        //}
        //echo $data_estu['sinc_andover']."</td>";
        //echo "</td>";
        echo "</tr>";
    }    
    echo "</table>";
}else{
    Echo "No Existen Datos Pendientes de actualizacion";
}

?>
