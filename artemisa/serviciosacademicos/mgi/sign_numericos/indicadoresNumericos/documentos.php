<?php

    include_once("../variables.php");
      include($rutaTemplate."templateNumericos.php");
    $db = writeHeader("Gestión de Indicadores",true,$proyectoNumericos);    
   // include("./menu.php");
    //writeMenu(1);   
    ?>


<?php 

$campo=$_GET["id"];
//var_dump($campo);
if($_GET["ver"] == ""){
    $ver=0;
}else{
    $ver=$_GET["ver"];
}
//var_dump($ver);
//die();
 $query_doc= "SELECT g.idsiq_indicador,g.inexistente FROM siq_indicador g where  g.idsiq_indicador ='$campo'";
 $reg_resultado = $db->Execute($query_doc);
foreach($reg_resultado as $dt_sec){
 $indicador=$dt_sec['idsiq_indicador'];   
  $existente=$dt_sec['inexistente'];  
//var_dump($existente);

 if ($existente == 0){
      $query_doc= "SELECT idsiq_funcion FROM siq_funcionIndicadores WHERE idIndicador='$campo'";
 $reg_resultado = $db->Execute($query_doc);
// var_dump($reg_resultado);

foreach($reg_resultado as $dt_sec){
 $funcion=$dt_sec['idsiq_funcion'];   
//var_dump($funcion);
//  die();
 /*if ($funcion == 0){
     echo ("NO existe   Funcion Asociada");
     die();
 }else if ($funcion == 1){
         echo ("Existe  y  es   :"+$funcion);
           die();
 }*/
 
  $i++;  
    }
 }else{
      $query_doc2= "select idsiq_documento, codigoestado  from siq_documento where siqindicador_id ='$campo'";
           $reg_resultado2 = $db->Execute($query_doc2);
           
               foreach($reg_resultado2 as $dt_sec){
                // print_r($dt);
                $documento=$dt_sec['idsiq_documento'];
                $estado=$dt_sec['codigoestado'];
                //var_dump($documento);
                if (empty($documento)){
                }else{
            echo '<script>';
               echo 'var variablejs = "<?php echo $documento; ?>"' ;
            echo 'document.write("VariableJS = " + variablejs);';
            echo '</script>';
                     }
                $i++;
  }
 }
   $i++;  
}

?>

<script language="javascript"> 
    var variablejs = 0;
    var variablejs = "<?php echo $documento; ?>" ;
     var estado = "<?php echo $estado; ?>" ;
    var id = "<?php echo $campo; ?>" ;
    var existente = "<?php echo $existente; ?>" ;
     var funcion = "<?php echo $funcion; ?>" ;
      var ver = "<?php echo $ver; ?>" ;
//document.write("ver = " + ver);
//document.write("funcion = " + funcion);
// document.write("VariableJS respuesta = " + variablejs);
//document.write("id respuesta = " + id);
//document.write("existente = " + existente);
//alert("Impresion");
    if(existente == 1){
if(variablejs != 0 && estado == 100){
      window.location.href= "../../SQI_Documento/Documento_Ver.html.php?Docuemto_id="+variablejs; 
}else{
    window.location.href= "../../SQI_Documento/Carga_Documento.html.php?actionID=numerico&indicador_id="+id;
}
    }else if(existente == 0){
        //window.location.href="../../sign_numericos/indicadoresNumericos/detalle.php?id=row_"+id;
        
        if(funcion == 0){
          alert("No existe una Función Definida para el indicador");
            window.location.href= "index.php?id="+id;
        }else if (funcion == 1){
             //alert("Ingrese a funcion tipo 1");
             //window.location.href= "detalle.php?id="+id;
             window.location.href= "detalle.php?id="+id+'&ver='+ver;
             // location.href = location.href+'?var1='+var1+'&var2='+var2;
        }else if (funcion == 2){
            //alert("Ingrese a funcion tipo 2");
              window.location.href= "detalleTipo2.php?id="+id+'&ver='+ver;
        }
        
    }

</script> 
