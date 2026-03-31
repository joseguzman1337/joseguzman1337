<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

include("../../templates/templateAutoevaluacion.php");
   $db =writeHeaderBD();
   $option=$_REQUEST['opt'];
   $val=$_REQUEST['id'];
    $wh='';
    if ($option==1){
        $wh=" and c.codigocarrera='".$val."' ";
    }
    if ($option==3){
        $wh=" and i.discriminacion='1' ";
    }
    $query_indicador= "SELECT
                        i.idsiq_indicador,
                        i.ubicacion,
                        i.fecha_ultima_actualizacion,
                        i.fecha_proximo_vencimiento,
                        i.idEstado,
                        i.es_objeto_analisis,
                        i.tiene_anexo,
                        i.inexistente,
                        i.discriminacion,
                        ig.idsiq_indicadorGenerico,
                        ig.idAspecto,
                        ig.nombre,
                        ig.descripcion,
                        ig.idTipo,
                        ig.area,
                        ig.codigo,
                        c.codigocarrera,
                        c.codigocortocarrera,
                        c.nombrecortocarrera,
                        c.nombrecarrera,
                        c.codigofacultad
                        FROM 
                        siq_indicadorGenerico as ig
                        inner join siq_indicador as i on (ig.idsiq_indicadorGenerico=i.idindicadorGenerico)
                        left join carrera as c on (c.codigocarrera=i.idCarrera)
                        WHERE idTipo ='2'
                        and ig.codigoestado=100 and i.codigoestado=100
                        ".$wh." ;";
    //echo $query_indicador;
    $data_in= $db->Execute($query_indicador);
// print_r($data_in);
    $i=0;

    ?>
<script>
    $(function() {
                      $('#filter_input').fastLiveFilter('#sortable1');
                       });
                       
      $(function() {
        $( "#sortable1" ).sortable({
            connectWith: ".connectedSortable"
        })
      }) 
       
</script>
<input id="filter_input" placeholder="Buscar..">
                                      <br><br>
                                      <ul id="sortable1" class="connectedSortable">
                                          
                                      

<?php
    $i=0;
    foreach($data_in as $dt){
    // print_r($dt);
        $nombre=$dt['nombre'];
        $dis=$dt['discriminacion'];
        $carrera=$dt['nombrecortocarrera'];
        $id_in=$dt['idsiq_indicador'];
         $codigo=$dt['codigo'];
        if ($dis==3){
            $nombre=$codigo.' - '.$nombre.'('.$carrera.')';
        }else{
            $nombre=$codigo.' - '.$nombre.'(Institucional)';
        }

        $id=$dt['idsiq_indicador'];
        echo '<li class="ui-state-default" style="width:400px;" id="'.$id.' " >'.$id.'-'.$nombre;
        echo '<input type="hidden" name="ids['.$i.']" id="ids_'.$i.'" value="'.$id.'" />';
        echo'</li>';
        $i++;
    }
    if ($i==0) echo "No hay Datos"
?>
</ul>
                                     