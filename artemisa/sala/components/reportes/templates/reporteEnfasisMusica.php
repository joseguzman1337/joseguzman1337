<?php 
    defined('_EXEC') or die; 
    echo Factory::printImportJsCss("css",HTTP_SITE."/assets/plugins/bootstrap-table/bootstrap-table.min.css");
    
    function sesion($id){
        $_SESSION["codigo"]="$id";
    }
?>

<style>
    .modal-dialog{
          width: 90%;
   }
    html input[value="Regresar"],input[value="Exportar Doc"],input[value="Modificar Carga Académica"],input[value="Syllabus y contenido materias electivas"] {
       display: none;
   }
</style>
<script></script>
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">
            Listado Estudiantes
        </h3>
    </div>
    <div class="panel-body">
        <table id="datosCambioPeriodo" data-toggle="table" 
                data-page-size="10"
                data-search="true"
                data-show-pagination-switch="false"
                data-pagination="true"   >
            <thead>
                <tr>
                    <th data-field="idnumber" class="hidden-xs">#</th>
                    <th data-switchable="false">Documento</th>
                    <th data-sortable="false">Apellido</th> 
                    <th data-switchable="false">Nombre</th>
                    <th data-switchable="false">Email</th>
                    <th data-sortable="false" class="hidden-xs">Enfasis</th> 
                    <th data-sortable="false" class="hidden-xs">Plan Estudio</th> 
                    <th data-sortable="false" class="hidden-xs">Boletin<br>calificaciones</th>
                    <th data-sortable="false" class="hidden-xs">Registro<br> matricula</th>
                    <th data-sortable="false" class="hidden-xs">Registro<br> pre-matricula</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $numerador = 1;
                foreach ( $estudianteEnfasis as $dato ){
                    $documento = $dato->getEstudianteGeneral( )->getNumerodocumento( );
                    $nombre = $dato->getEstudianteGeneral( )->getNombresestudiantegeneral( );
                    $apellido = $dato->getEstudianteGeneral( )->getApellidosestudiantegeneral( );
                    $enfasis = $dato->getNombrelineaenfasisplanestudio( );
                    $estudiante = $dato->getCodigoEstudiante();
                    $email = $dato->getEmail();
                ?>
                <tr>
                    <td><?php echo $numerador;?></td>
                    <td><?php echo $documento; ?></td>
                    <td><?php echo $apellido;?></td>
                    <td><?php echo $nombre;?></td>
                    <td><?php echo $email;?></td>
                    <td><?php echo $enfasis; ?></td>
                    <td>
                        <a href="#" class="planEstudio" id="<?php echo $estudiante;?>">
                            <i class="fa fa-list-alt fa-2x"></i>
                        </a>
                    </td>
                    <td>
                        <?php
                            $parametrosLink = 'tipodetalleseguimiento=100'.'&busqueda_codigo='.$estudiante.'&busqueda_semestre=';
                        ?>
                        <a class="notas" href="<?php echo HTTP_ROOT."/serviciosacademicos/consulta/facultades/boletines/seleccion_certificado.php?".$parametrosLink ?>"  target="_blank">
                            <i class="fa fa-list-alt fa-2x"></i>
                        </a>
                    </td>
                     <td>
                        <a href="#" class="registroMatricula" id="<?php echo $estudiante;?>">
                            <i class="fa fa-list-alt fa-2x "></i>
                        </a>
                    </td>
                    <td>
                        <a href="#" class="registroPreMatricula"  id="<?php echo $estudiante;?>">
                            <i class="fa fa-list-alt fa-2x"></i>
                        </a>
                    </td>
                </tr>
                <?php 
                    $numerador++;
                }
                ?>   
            </tbody>
        </table>
    </div>
</div>
<?php
    echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/bootstrap-table/bootstrap-table.min.js");
?>
