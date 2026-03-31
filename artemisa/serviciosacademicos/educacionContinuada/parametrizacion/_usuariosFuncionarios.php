<?php

session_start;
	include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
	
	include_once(realpath(dirname(__FILE__))."/../variables.php");
include($rutaTemplate."template.php");
$db = getBD();
$utils = Utils::getInstance();
$usuariosFuncionarios = $utils->getUsuariosFuncionarios($db);
?>

<script type="text/javascript">
                       
      $(function() {
         $( "#sortable2" ).sortable({
            connectWith: ".connectedSortable",
            dropOnEmpty: true,
            //placeholder: "ui-state-highlight",
            start: function(e,ui){
                ui.placeholder.height(ui.item.height());
            }
        });
        
        $( "#sortable2" ).bind( "sortupdate", function(event, ui) {
            var clases=ui.item.attr('class').split(" "); 
            if(clases.length>1){
                var id=clases[1].replace("idUsuario",""); 
                var action2 = "eliminarPermisosUsuario";
                    var rol = 2;
                if($(".idUsuario"+id).hasClass("usuarioAdmin")){
                    rol = 1;
                } 

                var order = 'usuario=' + id + '&rol='+rol+'&action='+action2;
                 var posting = $.post("process.php", order);
                
                    posting.done(function( data ) {
                        var json = $.parseJSON(data); // create an object with the key of the array
                        if (json.success == true){
                                    //ahora vuelvo a activar los permisos
                                    action2 = "agregarPermisosUsuario";
                                    order = 'usuario=' + id + '&rol='+rol+'&action='+action2;

                                    $.post("process.php", order, function(data2){
                                        var json2 = $.parseJSON(data2); // create an object with the key of the array
                                        if (json2.success == true){                        
                                            if($(".idUsuario"+id).hasClass("usuarioAdmin")){
                                                $(".idUsuario"+id).removeClass("usuarioAdmin");
                                                $(".idUsuario"+id).addClass("usuarioFuncionario");
                                            } else {
                                                $(".idUsuario"+id).removeClass("usuarioFuncionario");
                                                $(".idUsuario"+id).addClass("usuarioAdmin");
                                            }                                
                                        }else{      
                                            alert(json2.message);
                                        }
                                    }); 
                        } else {
                            alert(json.message);
                        }
                    });
            }
        });
        
      }); 
       
</script>
                                      
     <ul id="sortable2" class="connectedSortable" style="min-height: 490px">             
<li class="ui-state-highlight" id="0">Arrastrar hasta aquí</li>
          <?php
                if (!empty($usuariosFuncionarios)){
                                                    $i=0;
                        foreach($usuariosFuncionarios as $dt_sec){
                                                    // print_r($dt);
                               $nombre=$dt_sec['nombre']." (".$dt_sec['usuario'].")";
                               $id_in=$dt_sec['idusuario'];
                                                    
                              //$id=$dt_sec['codigo'];
                              echo '<li class="ui-state-default idUsuario'.$id_in.' usuarioFuncionario" id="'.$id_in.' ">'.$nombre;
                               echo'</li>';
                              $i++;
                        }
                   } else {
                      echo "<p style='margin-left:5px'>No se encontraron usuarios con este rol.</p>";
                  }
         ?>
</ul>
