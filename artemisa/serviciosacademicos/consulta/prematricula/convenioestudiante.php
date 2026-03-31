<?php
session_start();
require_once($_SESSION['path_live'] . "/../sala/includes/adaptador.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convenios Estudiante</title>
    <?php
    
    echo Factory::printImportJsCss("css", HTTP_ROOT ."/assets/css/bootstrap.min.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/font-awesome.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/sala/assets/css/loader.css");
    echo Factory::printImportJsCss("css", HTTP_ROOT ."/assets/css/sweetalert.css");

    echo Factory::printImportJsCss("js", HTTP_ROOT ."/assets/js/sweetalert.min.js");
    echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/jquery-3.1.1.js");
    echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/spiceLoading/pace.min.js");
    echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/bootstrap.min.js");
 
    ?>

    <style>
    .w-100{
        width:100%;
    }

    .insideCenter{
        display:flex;
        justify-content:center;
    }    
    </style>
    <script>
            const regresar = ()=>{
                window.location.href = "matriculaautomaticaordenmatricula.php";
            }
    </script>
</head>
<body>
<!-- Boton para regresar al modulo de estudiante -->
<button type="button" class="btn btn-info" style="margin-bottom:10px" onclick="regresar()">⬅ Regresar al Perfil de Estudiante</button>

<?php

// Se inicializan las variables $codigoestudiante y $codigoperiodo que se van a usar en todo el modulo

$codigoestudiante = $_GET['codigoestudiante'];
$codigoperiodo = $_SESSION['codigoperiodosesion'];

if (isset($_POST['convenioinscrip_btn'])){
    
    $idconvenioinscripcion = $_POST['convenioestudiante'];
    
    //id del usuario quien realiza el procedimiento
    $idusuario = $_SESSION['idusuario'];
    
    //se verifica que no exista ningun registro con el tipo de convenio activo
    //para asi no crear registros de forma innecesaria

    $query_verificacion = "select * from logconvenioinscripcion where idconvenioinscripcion = $idconvenioinscripcion
                           and codigoestudiante=$codigoestudiante and codigoestado = 100";

    $result_verificacion = $db->GetRow($query_verificacion);

    /*
        si existe el registro mencionado, el sistema no debe hacer nada, puesto que estaria agregando mas registros
        innecesariamente
    */

    if (!$result_verificacion) {
        //primero se inactivan todos los convenios del estudiante
        $query_inactivacion = "update logconvenioinscripcion set codigoestado = 200 where codigoestudiante = $codigoestudiante";

        $db->Execute($query_inactivacion);

        //posteriormente se activa el convenio escogido para el estudiante

        $query_activacion = "insert into logconvenioinscripcion (idconvenioinscripcion, codigoestudiante, codigoperiodo, codigoestado, fechacreacion, usuariocreacion)
                             values ($idconvenioinscripcion,$codigoestudiante,$codigoperiodo,100,now(),$idusuario)";
   
        $result_activacion = $db->Execute($query_activacion);

        if ($result_activacion) {
            //Si todo sale bien se envia un mensaje positivo
            echo "<script>swal('','Convenio asignado correctamente','success')</script>";
        }else{
            //De lo contrario se envia un mensaje negativo
            echo "<script>console.log('No se insertó el registro en la base de datos linea ".__LINE__."')</script>";
            echo "<script>swal('','Error en la asignación de Convenio. Por favor contactarse con Mesa de Servicio','error')</script>";
        }

    }else{
        echo "<script>swal('','El convenio se encuentra actualmente activo','info')</script>";
    }
    
}

?>


<h3 style="margin-top:0px">Convenios del estudiante</h3>
<h5>Por favor escoja el convenio al cual pertenece el estudiante</h5>

<div class="w-100 insideCenter">
    <div class="col-xs-6">

        <div class="panel panel-default w-100">
            <div class="panel-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="convenioEstudiante">Convenio actual del estudiante</label>

                        <!-- inputs escondidos que almacenaran el codigo del estudiante y el codigo del periodo -->

                        <select class="form-control" id="convenioEstudiante" name="convenioestudiante">
                        <?php
                        
                            $sqlconvenios = "select idconvenioinscripcion, NombreConvenio from convenioinscripcion ".
                            " where codigoestado= 100";
                            $convenios = $db->GetAll($sqlconvenios);
        
                            $sqlconsulta = "select idconvenioinscripcion from logconvenioinscripcion where codigoestudiante ='".$_GET['codigoestudiante']."' ".
                            " and codigoestado = 100";
                            $idlog = $db->GetRow($sqlconsulta);

                            foreach($convenios as $convenio){
                                if($idlog['idconvenioinscripcion'] == $convenio['idconvenioinscripcion']){
                                    echo "<option value='".$convenio['idconvenioinscripcion']."' selected='selected'>".$convenio['NombreConvenio']."</option>";
                                }else{
                                    echo "<option value='".$convenio['idconvenioinscripcion']."' >".$convenio['NombreConvenio']."</option>";
                                }
                            }
                        
                        ?>
                        </select>
                    </div>
                    <div class="form-group insideCenter">
                    <button type="submit" class="btn btn-success" id="convenioinscrip_btn" name="convenioinscrip_btn">Asignar convenio</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<div>
<h3>Histórico de convenios del estudiante</h3>
<h5>Listado histórico de convenios asignados al estudiante</h5>
    <div class="w-100 insideCenter">

    <div class="col-xs-9">
           <?php
           
           $query_historico = "select c.NombreConvenio,lc.codigoperiodo,lc.fechacreacion, u.usuario,lc.codigoestado,e.nombreestado,idlog
                                    from logconvenioinscripcion lc
                                    join estado e on lc.codigoestado = e.codigoestado
                                    join convenioinscripcion c on lc.idconvenioinscripcion = c.idconvenioinscripcion
                                    join usuario u on lc.usuariocreacion = u.idusuario
                                where lc.codigoestudiante = $codigoestudiante
                                order by lc.idlog desc";
            
            $listado_convenios = $db->GetAll($query_historico);

            if ($listado_convenios) {
               
                //se dibuja la tabla de hitoricos

                echo "<table class='table table-bordered' style='margin-top:10px'>";
                    echo "<thead>
                            <tr>
                                <th>#</th>
                                <th>Convenio</th>
                                <th>Periodo</th>
                                <th>Fecha de Creación</th>
                                <th>Creado por</th>
                                <th>Estado</th>
                            </tr>
                        </thead>";
                    echo "<tbody>";
                    $n=1;
                    foreach ($listado_convenios as $key => $elemento_convenio) {
                        echo "<tr>";
                            echo "<td>".$n."</td>";
                            echo "<td>".$elemento_convenio['NombreConvenio']."</td>";
                            echo "<td>".$elemento_convenio['codigoperiodo']."</td>";
                            echo "<td>".$elemento_convenio['fechacreacion']."</td>";
                            echo "<td>".$elemento_convenio['usuario']."</td>";
                            
                            $colorEstado = ($elemento_convenio['codigoestado']=='100') ? 'bg-success' : 'bg-warning' ;
                            
                            echo "<td class='".$colorEstado."'>".$elemento_convenio['nombreestado']."</td>";
                        echo "</tr>";
                        $n++;
                    }
                    
                    echo "</tbody>";      
                echo "</table>";
            }else{
                echo "<div style='margin-top:10px' class='alert alert-warning' role='alert'>El estudiante no tiene convenios asignados</div>";
            }
           
           ?> 
    </div>                         

    </div>
</div>
</body>
</html>
