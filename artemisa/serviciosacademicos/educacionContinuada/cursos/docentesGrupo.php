<?php
	session_start;
/*	include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);*/
	
    include_once(realpath(dirname(__FILE__))."/../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Docentes Grupo",TRUE);
    $docentes = array();
    
    if(isset($_REQUEST["idGrupo"])){  
       $id = $_REQUEST["idGrupo"];
       $utils = Utils::getInstance();
       //aqui buscar pagos
       $docentes = $utils->getDocentesGrupoCursoEducacionContinuada($db,$id); 
   }
      if(count($docentes)>0){
?>
<div id="contenido" style="margin:10px 0;">
        <table id="historialPagos" class="detalle">
		<tr>
                    <th class="center">Apellidos Docente</th>
                    <th class="center">Nombre Docente</th>
                    <th class="center">Documento</th>
                </tr>
                <?php foreach($docentes as $row) {  ?>
                <tr>
                    <td><?php echo $row["apellidodocente"]; ?></td>
                    <td><?php echo $row["nombredocente"]; ?></td>
                    <td class="column center"><?php echo $row["numerodocumento"]; ?></td>
                </tr>
                <?php } ?>
        </table>
</div>
<?php } else { echo "No hay docentes asignados para este grupo."; } ?>