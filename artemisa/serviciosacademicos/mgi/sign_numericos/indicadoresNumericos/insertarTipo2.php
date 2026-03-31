<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once("../variables.php");
    include($rutaTemplate."templateNumericos.php");
    $db = writeHeader("Gestión de Indicadores",true,$proyectoNumericos);    
    include("./menu.php");
    writeMenu(1);    ?>

<?php 

$campo=$_GET["id"];
//var_dump($campo);

 $query_doc= "SELECT idsiq_funcionIndicadores FROM siq_funcionIndicadores WHERE idIndicador ='$campo'";
 $reg_resultado = $db->Execute($query_doc);
foreach($reg_resultado as $dt_sec){
 $asignado=$dt_sec['idsiq_funcionIndicadores']; 
//var_dump($asignado);

}

?>

<script language="javascript"> 
    var asignado = 0;
    var asignado = "<?php echo $asignado; ?>" ;
    if(asignado != 0){
        window.location.href= "registroTipo2.php?id="+asignado;
    }

</script> 
