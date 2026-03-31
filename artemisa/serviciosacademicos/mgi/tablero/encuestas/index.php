<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 //var_dump (is_file('class/Encuestas_Class.php'));die;
 include_once('class/Encuestas_Class.php'); $C_Encuestas = new Encuestas();
 
 $L_Encuestas = $C_Encuestas->ListaEncuestas();
  
 //echo '<pre>';print_r($L_Encuestas); 
  
 ?>
 <table border="1">
    <thead>
        <tr>
            <!--<th>&nbsp;&nbsp;</th>-->
            <th> </th>
            <!--<th>&nbsp;&nbsp;</th>-->
            <th>Fecha de vencimiento</th>
        </tr>
    </thead>
    <tbody>
        <?PHP 
        for($i=0;$i<count($L_Encuestas);$i++){
            ?>
            <tr>
                <!--<td><center><?PHP echo $i+1?></center></td>-->
                <td class="first"><a href="javascript:void(0)" onclick="cargarContenidoParametros('index.php?page=detalleEncuesta&id_instrumento=<?PHP echo $L_Encuestas[$i]['id_instrumento']?>');"><?PHP echo $L_Encuestas[$i]['nombre']?></a></td>
                <!--<td>&nbsp;&nbsp;</td>-->
                <td><?PHP echo $L_Encuestas[$i]['fecha']?></td>
            </tr>
            <?PHP
        }//for
        ?>
    </tbody>
 </table>
<script type="text/javascript">
      /* $('#detalleEncuesta').bind('click', function(event) {
                  cargarContenidoParametros("index.php?page=detalleEncuesta", { encuesta: $("#encuesta").val()  });
        }); */
</script>