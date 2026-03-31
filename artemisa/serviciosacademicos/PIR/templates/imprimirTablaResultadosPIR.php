<?php 
if(empty($resultadosGuardados)){
    $estructura = $respuesta->examen->estructura;
    $periodo = null;
} 
?>
<table class="table table-bordered" id="resultados" style="font-size: 13px">
    <tr>
        <td >Puesto</td>
        <td >
            <?php 
            echo $objResultado->getPuestoresultadopruebaestado(); 
            ?>
        </td>
        <?php
        if($estructura == 6 || $estructura == 7 ){
            ?>
            <td >Puntaje Global</td>
            <td >
                <?php echo $objResultado->getPuntajeGlobal(); ?>
            </td>
            <?php
        }
        ?>
    </tr>
    <tr id="trtituloNaranjaInst">
        <td>Asignatura</td>
        <td>Puntaje</td>
        <?php
        if($estructura == 6 || $estructura == 7 ){
            ?> 
            <td >
                <?php 
                switch ($estructura){
                    case 7:
                        echo "Percentil";
                        break;
                    case 6:
                        echo "Decil";
                        break;
                }
                ?>
            </td>
            <?php
        } 
        ?> 
    </tr>
    <?php
    if(empty($resultadosGuardados)){
        foreach($respuesta->examen->resultado->pruebas as $p){
            if(!empty($p->id)){
                ?>
                <tr>
                    <td>
                        <?php echo $objMaterias->getMateriaNombre($p->id);?>
                    </td> 
                    <td>
                        <?php echo DetalleResultadoPruebaEstado::getCalificacionNormal($p->calificacion);?>
                    </td>
                    <?php
                    if($respuesta->examen->estructura == 6 || $respuesta->examen->estructura == 7 ){

                        ?> 
                        <td>
                            <?php 
                            switch ($respuesta->examen->estructura){
                                case 7:
                                    echo DetalleResultadoPruebaEstado::getCalificacionPercentil($p->calificacion);
                                    break;
                                case 6:
                                    echo DetalleResultadoPruebaEstado::getCalificacionDecil($p->calificacion);
                                    break;
                            }
                            ?>
                        </td>
                        <?php
                    } 
                    ?> 
                </tr>
                <?php
            }
        }
    }else{
        foreach($resultadosGuardados as $r){
            ?>
            <tr>
                <td>
                    <?php echo $objMaterias->getMateriaNombre($r->getIdasignaturaestado(), true);?>
                </td> 
                <td>
                    <?php echo $r->getNotadetalleresultadopruebaestado();?>
                </td>
                <?php
                if($estructura == 6 || $estructura == 7 ){

                    ?> 
                    <td>
                        <?php 
                        echo $r->getDecil();
                        ?>
                    </td>
                    <?php
                } 
                ?> 
            </tr>
            <?php
        }
    }
    ?>
</table>
