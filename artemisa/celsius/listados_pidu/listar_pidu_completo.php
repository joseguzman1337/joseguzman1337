<?php

require_once "../common/ServicesFacade.php";
require_once "../common/includes.php";
require_once "../layouts/top_layout_admin.php";

?>

<table width="90%"  cellpadding="2" cellspacing="1" style="font-family:verdana; font-color:black;">
<?

$pidu = $servicesFacade->getPIDU();

$cant = count($pidu);
$pidu[]=array("Id_Pais" => 0);

$countPaises = 0;
$countInstituciones = 0;
$countDependencias = 0;
$countUnidades = 0;

$i = 0;
$regI = $pidu[$i];
while ($i <= $cant){
    $lastPais = $regI["Id_Pais"];
    $countPaises++;
    
    ?>
    <tr>
    	<td style="font-size:12px; font-weight:bolder; medium double rgb(250,0,255)">Pais: <?= $regI["Nombre_Pais"] ?> (<?= $regI["Id_Pais"] ?>).</td>
    </tr>
	<?
	while (($i <= $cant) && ($regI["Id_Pais"]==$lastPais)){
		$lastInstitucion= $regI["Id_Institucion"];
		if (!isset($lastInstitucion)){
			$regI = $pidu[$i++];
		}else{
			$countInstituciones++;
			$cantUsuariosInstitucion = $servicesFacade->getCount("usuarios", array("Codigo_Institucion" => $lastInstitucion));
			?>
			<tr><td style="font-size:11px; font-weight:bold;padding-left:20px">Institucion: <?= $regI["Nombre_Institucion"] ?>  (<?= $regI["Id_Institucion"] ?>). <?=$cantUsuariosInstitucion?> usuarios.</td></tr>
			<?	
			while (($i <= $cant) && ($regI["Id_Institucion"]==$lastInstitucion)){
				$lastDependencia = $regI["Id_Dependencia"];
				if (!isset($lastDependencia)){
					$regI = $pidu[$i++];
				}else{
					$countDependencias++;
					$cantUsuariosDependencia = $servicesFacade->getCount("usuarios", array("Codigo_Dependencia" => $lastDependencia));
					?>
					<tr><td style="font-size:10px; font-weight:normal;padding-left:40px">Dependencia: <?= $regI["Nombre_Dependencia"] ?> (<?= $regI["Id_Dependencia"] ?>). <?=$cantUsuariosDependencia?> usuarios.</td></tr>
					<?
					while (($i <= $cant) && ($regI["Id_Dependencia"]==$lastDependencia)){
						$lastUnidad = $regI["Id_Unidad"];
						if (!isset($lastUnidad)){
						}else{
							$countUnidades++;
							$cantUsuariosUnidad= $servicesFacade->getCount("usuarios", array("Codigo_Unidad" => $lastUnidad));
							?>
							<tr><td style="font-size:9px; font-weight:lighter;padding-left:60px">Unidad: <?= $regI["Nombre_Unidad"] ?> (<?= $regI["Id_Unidad"] ?>). <?=$cantUsuariosUnidad?> usuarios.</td></tr>
						<?}
						$regI = $pidu[$i++];
						
					}
				}
			}
		}
	}
	flush();
}	

?>
</table>
$countPaises = <?=$countPaises?>;
<br/>
$countInstituciones = <?=$countInstituciones?>;
<br/>
$countDependencias = <?=$countDependencias?>;
<br/>
$countUnidades = <?=$countUnidades?>;
<br/>
<?require_once "../layouts/base_layout_admin.php";?>