<?php
    require_once("../templates/template.php");
    $db = getBD();
    
   $option=$_REQUEST['opt'];
   $val=$_REQUEST['id'];
   $rep=$_REQUEST['idReporte'];
    $wh='';
    if ($option==1){
        $wh=" and c.codigocarrera='".$val."' ";
    }
    if ($option==3){
        $wh=" and i.discriminacion='1' ";
    }
    $query_indicador= "SELECT
                        i.idsiq_indicador,
                        ig.codigo,
                        i.discriminacion,
                        ig.idsiq_indicadorGenerico,
                        ig.idAspecto,
                        ig.nombre,
                        ig.descripcion,
                        ig.idTipo,
                        ig.area,
                        c.codigocarrera,
                        c.codigocortocarrera,
                        c.nombrecortocarrera,
                        c.nombrecarrera,
                        c.codigofacultad
                        FROM 
                        siq_indicadorGenerico as ig
                        inner join siq_indicador as i on (ig.idsiq_indicadorGenerico=i.idindicadorGenerico)
                        left join carrera as c on (c.codigocarrera=i.idCarrera)
                        WHERE ig.codigoestado=100 and i.codigoestado=100 
                        AND i.idsiq_indicador NOT IN (SELECT idIndicador FROM siq_relacionReporteIndicador ri 
                            WHERE ri.idReporte = '".$rep."' AND ri.codigoestado=100) 
                        ".$wh." ;";

    //var_dump($query_indicador);
    $data_in= $db->Execute($query_indicador);
// print_r($data_in);
    $i=0;

    ?>
<script type="text/javascript">
    $(function() {
      $('#filter_input').fastLiveFilter('#sortable1');
       });
                       
      $(function() {
         $( "#sortable1" ).sortable({
            connectWith: ".connectedSortable",
            dropOnEmpty: true,
            //placeholder: "ui-state-highlight",
            start: function(e,ui){
                ui.placeholder.height(ui.item.height());
            }
        });
        
        $( "#sortable1" ).bind( "sortupdate", function(event, ui) {
            var clases=ui.item.attr('class').split(" "); 
            if(clases.length>1){
                var id=clases[1].replace("idInd",""); 
                var action2 = "inactivate";
                var idReporte = $("#idsiq_reporte").val();
                if($(".idInd"+id).hasClass("noAsociado")){
                    var action2 = "save";
                } 

                var order = 'idIndicador=' + id + '&idReporte='+idReporte+'&action=updateRecordsListings&action2='+action2;
                //alert(order);
                //console.log(ui.item.attr('class'));
                //console.log(ui.item);
                $.post("process.php", order, function(reponse){

                        if($(".idInd"+id).hasClass("noAsociado")){
                            $(".idInd"+id).removeClass("noAsociado");
                        } else {
                            $(".idInd"+id).addClass("noAsociado");
                        }

                }); 
            }
        });
        
        //$( "#sortable1, #sortable2" ).disableSelection();
      }); 
       
</script>
<input id="filter_input" placeholder="Buscar..." style="margin: 0 5px 5px 5px;">
                                      
     <ul id="sortable1" class="connectedSortable" style="min-height: 460px">                       

<?php
    $i=0;
    foreach($data_in as $dt){
    // print_r($dt);
        $nombre=$dt['nombre'];
        $dis=$dt['discriminacion'];
        $carrera=$dt['nombrecortocarrera'];
        $id_in=$dt['idsiq_indicador'];
        //$id_in=$dt['codigo'];
        if ($dis==3){
            $nombre=$nombre.'('.$carrera.')';
        }else{
            $nombre=$nombre.'(Institucional)';
        }

        //$id=$dt['idsiq_indicador'];
        $id=$dt['codigo'];
        echo '<li class="ui-state-default idInd'.$id_in.' noAsociado" id="'.$id.' " >'.$id.' - '.$nombre;
        //echo '<input type="hidden" id="ids_'.$i.'" value="'.$id_in.'" />';
        echo'</li>';
        $i++;
    }
    if ($i==0) echo "<p style='margin-left:5px'>No se encontraron indicadores</p>"
?>
</ul>
                                     