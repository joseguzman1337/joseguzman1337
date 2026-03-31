<?php 

require_once(realpath(dirname(__FILE__)).'/../../Connections/sala2.php' );
mysql_select_db($database_sala, $sala);
Global $database_sala,$sala;
class Observatorio{


  public function ModalidadAcademica(){

    Global $database_sala,$sala;

    $num ="5";
        $SQL_Modalidad_Academica = 'SELECT 

                                    m.codigomodalidadacademica, m.nombremodalidadacademica 
                                    FROM modalidadacademica as m
                                    WHERE m.codigoestado = 100 
                                    and m.codigomodalidadacademica NOT IN(100, 700, 500, 501, 502, 503, 506, 507, 400)';



    $AcademicaModalidad = mysql_query($SQL_Modalidad_Academica, $sala) or die("$AcademicaModalidad".mysql_error());

    ?>
    <select name="codigomodalidadacademica" id="codigomodalidadacademica" onchange="listar()" required>
      <option value="">Seleccionar</option>
        <?php 
        while($Modalidad_Academica = mysql_fetch_assoc($AcademicaModalidad)){
        ?>
          <option value="<?php echo $Modalidad_Academica['codigomodalidadacademica'] ?>"><?php echo $Modalidad_Academica['nombremodalidadacademica'] ?></option>
        <?php

        }
        ?>
    </select>

    <?php


  }




}



?>