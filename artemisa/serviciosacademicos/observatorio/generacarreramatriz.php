<?php
include('../templates/templateObservatorio.php');
include_once ('../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');
   $db=writeHeader('Observatorio',true,'');
   $val=$_REQUEST['id'];
   $sin_ind=$_REQUEST['opt'];
   $codigoperiodo=$_REQUEST['periodo'];
   
   $query_carrera = "SELECT nombrecarrera, codigocarrera 
                     FROM carrera 
                     where codigomodalidadacademica='".$val."' and codigocarrera not in (1,2) and fechavencimientocarrera >= '2013-01-01 00:00:00'
                      order by 1";
   $data_in= $db->Execute($query_carrera);
   
   $c_Odata=new obtener_datos_matriculas($db,$codigoperiodo);
   
   //$datos=$reg_carrera->GetRows();
  // echo "Hola";
  // print_r($datos);
    
    
   //echo $reg_carrera->GetMenu2('codigocarrera',$data2[0]['codigocarrera'],false,false,1,' '.$onc.' name="codigocarrera"  id="codigocarrera"  style="width:150px;"')
 ?>
<table border="1">
    <thead>
        <th>Programa</th>
        <th>Interesados</th>
        <th>Aspirantes</th>
        <th>Inscritos</th>
        <th>Metas Inscritos</th>
        <th>Hemos Logrado</th>
        <th>Inscritos - Totales </th>
        <th>% Inscripción   Vs  </th>
        <th>Inscritos No Evaluados</th>
        <th>% de Inscritos no Evaluados</th>
        <th>Lista en Espera</th>
        <th>Evaluados no Adminitidos</th>
        <th>Admitidos no matriculados</th>
        <th>Admitidos que no ingresaron</th>
        <th>Matriculados Nuevos SALA</th>
        <th>Meta MAtriculados</th>
        <th>Hemos logrado un %</th>
        <th>Matriculados Totales</th>
        <th>% Matriculados Vs</th>
        <th>Matriculados Totales</th>
        <th>Matriculados Antiguos</th>
        <th>Matriculados Total</th>
    </thead>
    <tbody>
    <?php
        $i=0;
        foreach($data_in as $dt){
             $nombre=$dt['nombrecarrera'];
             $codcarrera=$dt['codigocarrera'];          
            ?>
                <tr>
                    <td><?php echo  $nombre; ?></td>
                    <td><?php echo  $nombre; ?></td>
                    <td>
                        <?php 
                        $aspirantes=$c_Odata->ObtenerAspirantes($codigocarrera,$codigoperiodo,'conteo');
                        echo $aspirantes; 
                        
                        ?>
                    </td>
                    
                </tr>
            <?php
        }
    ?>
    </tbody>
</table>
                                     