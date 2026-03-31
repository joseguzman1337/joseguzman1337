<?php
	session_start;
/*	include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);*/
    
	include_once(realpath(dirname(__FILE__))."/../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Empresas Grupo",TRUE);
    $empresas = array();
    
    if(isset($_REQUEST["idGrupo"])){  
       $id = $_REQUEST["idGrupo"];
       $utils = Utils::getInstance();
       //aqui buscar pagos
       $empresas = $utils->getEmpresasGrupoCursoEducacionContinuada($db,$id); 
   }
   
   if(count($empresas)>0){
?>
<div id="contenido" style="margin:10px 0;">
    <table id="historialPagos" class="detalle">
		<tr>
                    <th style="text-align:center">Empresa patrocinadora</th>
                </tr>
                <?php foreach($empresas as $row) { ?>
                <tr>
                    <td><?php echo $row["nombreempresa"]; ?></td>
                </tr>
                <?php } ?>
        </table>
  </div>
<?php } else { echo "No se encontraron empresas patrocinadoras para este grupo."; } ?>