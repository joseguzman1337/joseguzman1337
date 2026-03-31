<?php
class Factores{
	public function consultaFactores(){
		global $db;
		include_once('../../ReportesAuditoria/templates/mainjson.php');
		include("../pChart/class/pDraw.class.php"); 
		include("../pChart/class/pImage.class.php"); 
		$qry = "select s.*,sf.nombre
			from (
				select   sc.idFactor
					,round(sum(Actualizado)*100/sum(total)) as porcentaje
				from siq_caracteristica sc
				join siq_aspecto sa on sc.idsiq_caracteristica=sa.idCaracteristica
				join siq_indicadorGenerico sig on sa.idsiq_aspecto=sig.idAspecto
				join (
					select   idIndicadorGenerico
						,total
						,coalesce(Actualizado,0) as Actualizado
					from (select idIndicadorGenerico,count(*) as total from siq_indicador where idcarrera is null group by idIndicadorGenerico) st
					left join (select idIndicadorGenerico,count(*) as Actualizado from siq_indicador where idEstado=4 and idcarrera is null group by idIndicadorGenerico) s4 using(idIndicadorGenerico) 
				) sub1 on sig.idsiq_indicadorGenerico=sub1.idIndicadorGenerico
				group by sc.idFactor
			) s
			join siq_factor sf on s.idFactor=sf.idsiq_factor
			order by sf.nombre";
		$rs=$db->Execute($qry);
?>
		<table>
			<caption>Factores e indicadores</caption>
			<thead></thead>
			<tbody>
<?php
				while($row=$rs->fetchrow()) {
					/* Create the pChart object */ 
					$myPicture = new pImage(803,23); 
					/* Set the font & shadow options */  
					$myPicture->setFontProperties(array("FontName"=>"../pChart/fonts/Forgotte.ttf", "FontSize"=>10)); 
					$myPicture->setShadow(TRUE,array("X"=>1, "Y"=>1, "R"=>0, "G"=>0, "B"=>0, "Alpha"=>10)); 
					/* Draw a progress bar */  
					$progressOptions = array("Width"=>800, "R"=>134, "G"=>209, "B"=>27, "Surrounding"=>20, "BoxBorderR"=>202, "BoxBorderG"=>202, "BoxBorderB"=>202, "BoxBackR"=>255, "BoxBackG"=>255, "BoxBackB"=>255, "RFade"=>206, "GFade"=>133, "BFade"=>30, "ShowLabel"=>TRUE); 
					$myPicture->drawProgress(0,0,$row["porcentaje"],$progressOptions); 
					/* Render the picture (choose the best way) */ 
					$myPicture->Render("pictures/factor".$row["idFactor"].".png");
?>
					<tr>
						<td width="40%"><a href="javascript:void(0)" onclick="cargarContenidoParametros('index.php?page=caracteristicas&id=<?=$row["idFactor"]?>')"><?php echo$row["nombre"]?></a></td>
						<td width="60%" style="text-align:left !important"><img alt="Resultados " src="<?php echo "pictures/factor".$row["idFactor"].".png?random=".time(); ?>"></td>
					</tr>
<?php
				}
?>
			</tbody>
		</table>
<?php
	}
	public function consultaFactoresDetalle(){
		global $db;
		include_once('../../ReportesAuditoria/templates/mainjson.php');
		$qry = "select s.*,sf.nombre
			from (
				select   sc.idFactor
					,sum(total) as total
					,sum(Desactualizado) as desactualizado
					,sum(En_proceso) as enproceso
					,sum(En_revision) as enrevision
					,sum(Actualizado) as actualizado
					,round(sum(Desactualizado)*100/sum(total)) as porcentaje_desactualizado
				from siq_caracteristica sc
				join siq_aspecto sa on sc.idsiq_caracteristica=sa.idCaracteristica
				join siq_indicadorGenerico sig on sa.idsiq_aspecto=sig.idAspecto
				join (
					select   idIndicadorGenerico
						,total
						,coalesce(Desactualizado,0) as Desactualizado
						,coalesce(En_proceso,0) as En_proceso
						,coalesce(En_revision,0) as En_revision
						,coalesce(Actualizado,0) as Actualizado
					from (select idIndicadorGenerico,count(*) as total from siq_indicador where idcarrera is null group by idIndicadorGenerico) st
					left join (select idIndicadorGenerico,count(*) as Desactualizado from siq_indicador where idEstado=1 and idcarrera is null group by idIndicadorGenerico) s1 using(idIndicadorGenerico) 
					left join (select idIndicadorGenerico,count(*) as En_proceso from siq_indicador where idEstado=2 and idcarrera is null group by idIndicadorGenerico) s2 using(idIndicadorGenerico) 
					left join (select idIndicadorGenerico,count(*) as En_revision from siq_indicador where idEstado=3 and idcarrera is null group by idIndicadorGenerico) s3 using(idIndicadorGenerico) 
					left join (select idIndicadorGenerico,count(*) as Actualizado from siq_indicador where idEstado=4 and idcarrera is null group by idIndicadorGenerico) s4 using(idIndicadorGenerico) 
				) sub1 on sig.idsiq_indicadorGenerico=sub1.idIndicadorGenerico
				group by sc.idFactor
			) s
			join siq_factor sf on s.idFactor=sf.idsiq_factor
			order by sf.nombre";
		$rs=$db->Execute($qry);
?>
		<table>
			<caption>Factores e indicadores / Detalle</caption>
			<thead>
				<tr>
					<th width="40%">&nbsp;</th>
					<th width="12%" style="text-align:center !important">Total</th>
					<th width="12%" style="text-align:center !important">Desactualizados</th>
					<th width="12%" style="text-align:center !important">En proceso</th>
					<th width="12%" style="text-align:center !important">En revisi&oacute;n</th>
					<th width="12%" style="text-align:center !important">Actualizados</th>
				</tr>
			</thead>
			<tbody>
<?php
				while($row=$rs->fetchrow()) {
					$clase=($row["porcentaje_desactualizado"]>=50)?"badResult":"";
?>
					<tr>
						<td width="40%"><?php echo$row["nombre"]?></td>
						<td width="12%" style="text-align:center !important"><b><?php echo$row["total"]?></b></td>
						<td width="12%" style="text-align:center !important"><b><span class="<?php echo$clase?>"><?php echo$row["desactualizado"]?></span></b></td>
						<td width="12%" style="text-align:center !important"><b><?php echo$row["enproceso"]?></b></td>
						<td width="12%" style="text-align:center !important"><b><?php echo$row["enrevision"]?></b></td>
						<td width="12%" style="text-align:center !important"><b><?php echo$row["actualizado"]?></b></td>
					</tr>
<?php
				}
?>
			</tbody>
		</table>
<?php
	}
	public function consultaCaracteristicas($id){
		global $db;
		include_once('../../ReportesAuditoria/templates/mainjson.php');
		include("../pChart/class/pDraw.class.php"); 
		include("../pChart/class/pImage.class.php"); 
		$qry = "select s.*,sc.nombre
			from (  
				select   sa.idCaracteristica
					,sum(total) as total
					,round(sum(Actualizado)*100/sum(total)) as porcentaje
				from siq_aspecto sa 
				join siq_indicadorGenerico sig on sa.idsiq_aspecto=sig.idAspecto
				join (  
					select   idIndicadorGenerico
						,total  
						,coalesce(Actualizado,0) as Actualizado
					from (select idIndicadorGenerico,count(*) as total from siq_indicador where idcarrera is null group by idIndicadorGenerico) st
					left join (select idIndicadorGenerico,count(*) as Actualizado from siq_indicador where idEstado=4 and idcarrera is null group by idIndicadorGenerico) s4 using(idIndicadorGenerico) 
				) sub1 on sig.idsiq_indicadorGenerico=sub1.idIndicadorGenerico
				group by sa.idCaracteristica
			) s     
			join siq_caracteristica sc on sc.idsiq_caracteristica=s.idCaracteristica
			where sc.idFactor=".$id."
			order by sc.nombre";
		$rs=$db->Execute($qry);
?>
		<table>
			<caption>Caracter&iacute;sticas e indicadores</caption>
			<thead></thead>
			<tbody>
<?php
				while($row=$rs->fetchrow()) {
					/* Create the pChart object */ 
					$myPicture = new pImage(803,23); 
					/* Set the font & shadow options */  
					$myPicture->setFontProperties(array("FontName"=>"../pChart/fonts/Forgotte.ttf", "FontSize"=>10)); 
					$myPicture->setShadow(TRUE,array("X"=>1, "Y"=>1, "R"=>0, "G"=>0, "B"=>0, "Alpha"=>10)); 
					/* Draw a progress bar */  
					$progressOptions = array("Width"=>800, "R"=>134, "G"=>209, "B"=>27, "Surrounding"=>20, "BoxBorderR"=>202, "BoxBorderG"=>202, "BoxBorderB"=>202, "BoxBackR"=>255, "BoxBackG"=>255, "BoxBackB"=>255, "RFade"=>206, "GFade"=>133, "BFade"=>30, "ShowLabel"=>TRUE); 
					$myPicture->drawProgress(0,0,$row["porcentaje"],$progressOptions); 
					/* Render the picture (choose the best way) */ 
					$myPicture->Render("pictures/caracteristica".$row["idCaracteristica"].".png");
?>
					<tr>
						<td width="40%"><a href="javascript:void(0)" onclick="cargarContenidoParametros('index.php?page=indicadores&id=<?=$row["idCaracteristica"]?>&tot=<?=$row["total"]?>')"><?php echo$row["nombre"]?></a></td>
						<td width="60%" style="text-align:left !important"><img alt="Resultados " src="<?php echo "pictures/caracteristica".$row["idCaracteristica"].".png?random=".time(); ?>"></td>
					</tr>
<?php
				}
?>
			</tbody>
		</table>
<?php
	}
	public function consultaCaracteristicasDetalle($id){
		global $db;
		include_once('../../ReportesAuditoria/templates/mainjson.php');
		$qry = "select s.*,sc.nombre
			from (  
				select   sa.idCaracteristica
					,sum(total) as total
					,sum(Desactualizado) as desactualizado
					,sum(En_proceso) as enproceso
					,sum(En_revision) as enrevision
					,sum(Actualizado) as actualizado
					,round(sum(Desactualizado)*100/sum(total)) as porcentaje_desactualizado
				from siq_aspecto sa 
				join siq_indicadorGenerico sig on sa.idsiq_aspecto=sig.idAspecto
				join (  
					select   idIndicadorGenerico
						,total  
						,coalesce(Desactualizado,0) as Desactualizado
						,coalesce(En_proceso,0) as En_proceso
						,coalesce(En_revision,0) as En_revision
						,coalesce(Actualizado,0) as Actualizado
					from (select idIndicadorGenerico,count(*) as total from siq_indicador where idcarrera is null group by idIndicadorGenerico) st
					left join (select idIndicadorGenerico,count(*) as Desactualizado from siq_indicador where idEstado=1 and idcarrera is null group by idIndicadorGenerico) s1 using(idIndicadorGenerico) 
					left join (select idIndicadorGenerico,count(*) as En_proceso from siq_indicador where idEstado=2 and idcarrera is null group by idIndicadorGenerico) s2 using(idIndicadorGenerico) 
					left join (select idIndicadorGenerico,count(*) as En_revision from siq_indicador where idEstado=3 and idcarrera is null group by idIndicadorGenerico) s3 using(idIndicadorGenerico) 
					left join (select idIndicadorGenerico,count(*) as Actualizado from siq_indicador where idEstado=4 and idcarrera is null group by idIndicadorGenerico) s4 using(idIndicadorGenerico) 
				) sub1 on sig.idsiq_indicadorGenerico=sub1.idIndicadorGenerico
				group by sa.idCaracteristica
			) s     
			join siq_caracteristica sc on sc.idsiq_caracteristica=s.idCaracteristica
			where sc.idFactor=".$id."
			order by sc.nombre";
		$rs=$db->Execute($qry);
?>
		<table>
			<caption>Caracter&iacute;sticas e indicadores / Detalle</caption>
			<thead>
				<tr>
					<th width="40%">&nbsp;</th>
					<th width="12%" style="text-align:center !important">Total</th>
					<th width="12%" style="text-align:center !important">Desactualizados</th>
					<th width="12%" style="text-align:center !important">En proceso</th>
					<th width="12%" style="text-align:center !important">En revisi&oacute;n</th>
					<th width="12%" style="text-align:center !important">Actualizados</th>
				</tr>
			</thead>
			<tbody>
<?php
				while($row=$rs->fetchrow()) {
					$clase=($row["porcentaje_desactualizado"]>=50)?"badResult":"";
?>
					<tr>
						<td width="40%"><?php echo$row["nombre"]?></td>
						<td width="12%" style="text-align:center !important"><b><?php echo$row["total"]?></b></td>
						<td width="12%" style="text-align:center !important"><b><span class="<?php echo$clase?>"><?php echo$row["desactualizado"]?></span></b></td>
						<td width="12%" style="text-align:center !important"><b><?php echo$row["enproceso"]?></b></td>
						<td width="12%" style="text-align:center !important"><b><?php echo$row["enrevision"]?></b></td>
						<td width="12%" style="text-align:center !important"><b><?php echo$row["actualizado"]?></b></td>
					</tr>
<?php
				}
?>
			</tbody>
		</table>
<?php
	}
	public function consultaIndicadores($id,$tot){
		global $db;
		include_once('../../ReportesAuditoria/templates/mainjson.php');
		include("../pChart/class/pDraw.class.php"); 
		include("../pChart/class/pImage.class.php"); 
		$qry = "select   sub.*
				,sei.nombre
			from siq_estadoIndicador sei
			join (
				select   sa.idCaracteristica
					,si.idEstado
					,round(count(*)*100/".$tot.") as porcentaje_estado
				from siq_indicador si
				join siq_indicadorGenerico sig on si.idIndicadorGenerico=sig.idsiq_indicadorGenerico
				join siq_aspecto sa on sa.idsiq_aspecto=sig.idAspecto
				where idcarrera is null
				group by sa.idCaracteristica
					,si.idEstado
			) sub on sub.idEstado=sei.idsiq_estadoIndicador 
			where sub.idCaracteristica=".$id."
			order by sei.nombre";
		$rs=$db->Execute($qry);
?>
		<table>
			<caption>Indicadores</caption>
			<thead></thead>
			<tbody>
<?php
				while($row=$rs->fetchrow()) {
					/* Create the pChart object */ 
					$myPicture = new pImage(803,23); 
					/* Set the font & shadow options */  
					$myPicture->setFontProperties(array("FontName"=>"../pChart/fonts/Forgotte.ttf", "FontSize"=>10)); 
					$myPicture->setShadow(TRUE,array("X"=>1, "Y"=>1, "R"=>0, "G"=>0, "B"=>0, "Alpha"=>10)); 
					/* Draw a progress bar */  
					$progressOptions = array("Width"=>800, "R"=>134, "G"=>209, "B"=>27, "Surrounding"=>20, "BoxBorderR"=>202, "BoxBorderG"=>202, "BoxBorderB"=>202, "BoxBackR"=>255, "BoxBackG"=>255, "BoxBackB"=>255, "RFade"=>206, "GFade"=>133, "BFade"=>30, "ShowLabel"=>TRUE); 
					$myPicture->drawProgress(0,0,$row["porcentaje_estado"],$progressOptions); 
					/* Render the picture (choose the best way) */ 
					$myPicture->Render("pictures/caracteristica".$row["idCaracteristica"]."_".$row["nombre"].".png");
?>
					<tr>
						<td width="40%"><?php echo$row["nombre"]?></td>
						<td width="60%" style="text-align:left !important"><img alt="Resultados " src="<?php echo "pictures/caracteristica".$row["idCaracteristica"]."_".$row["nombre"].".png?random=".time(); ?>"></td>
					</tr>
<?php
				}
?>
			</tbody>
		</table>
<?php
	}
	public function consultaIndicadoresDetalle($id){
		global $db;
		$qry = "select   sei.nombre					as nombreestado
				,group_concat(sig.nombre separator '<br><br>')	as nombreindicador
			from siq_indicador si 
			join siq_estadoIndicador sei on si.idEstado=sei.idsiq_estadoIndicador 
			join siq_indicadorGenerico sig on si.idIndicadorGenerico=sig.idsiq_indicadorGenerico 
			join siq_aspecto sa on sa.idsiq_aspecto=sig.idAspecto 
			where idcarrera is null 
				and sa.idCaracteristica=".$id."
			group by sei.nombre
			order by sei.nombre";
		$rs=$db->Execute($qry);
?>
		<table>
			<caption>Indicadores / Detalle</caption>
			<thead></thead>
			<tbody>
<?php
				$i=1;
				while($row=$rs->fetchrow()) {
					$color=($i%2==0)?"ffffff":"cccccc";
?>
					<tr bgcolor="#<?php echo$color?>">
						<td width="40%" style="text-align:center !important"><b><?php echo$row["nombreestado"]?></b></td>
						<td width="60%" style="text-align:left !important"><?php echo$row["nombreindicador"]?></td>
					</tr>
<?php
					$i++;
				}
?>
			</tbody>
		</table>
<?php
	}
}

?>
