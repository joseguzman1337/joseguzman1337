<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include("../../templates/templateAutoevaluacion.php");
    $db =writeHeaderBD();
    $option=$_REQUEST['opt'];
    $val=$_REQUEST['id'];
    $query_indicador= "SELECT*
                        FROM 
                        usuario
                        WHERE codigorol ='".$val."'";
   //echo $query_indicador;
    $data_in= $db->Execute($query_indicador);
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
        $ndoc=$dt['numerodocumento'];
        $app=$dt['apellidos'];
        $nom=$dt['nombres'];
        $id=$dt['idusuario'];
        echo '<li class="ui-state-default" style="width:400px;" id="'.$id.' " >'.$ndoc.'-'.$nom.' '.$app;
        echo '<input type="hidden" name="ids['.$i.']" id="ids_'.$i.'" value="'.$id.'" />';
        echo'</li>';
        $i++;
    }
    if ($i==0) echo "No hay Datos"
?>
</ul>
                                     