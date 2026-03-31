<?php 
function ModalidadCarreraSeccion($db,$carrera){
   $SQL='SELECT
	k.codigomodalidadacademica,
	k.nombremodalidadacademica

	FROM
		modalidadacademica k 
	WHERE
		k.codigoestado=100 
	ORDER BY
		k.nombremodalidadacademica';
    
    if($CarrerasData=&$db->GetAll($SQL)===false){
        echo 'Error en el Sistema...';
        die;
    }    
	
	$SQL='SELECT
	c.codigomodalidadacademica

	FROM
		carrera c 
	WHERE c.codigocarrera="'.$carrera.'"';
		$carreraR = &$db->GetRow($SQL);
		
    ?>
    <select id="modalidadAcademica" name="modalidadAcademica">
        <?PHP 
        for($i=0;$i<count($CarrerasData);$i++){
            if($CarrerasData[$i]['codigomodalidadacademica']==$carreraR["codigomodalidadacademica"]){
                $Selected = 'selected="selected"';
            }else{
                 $Selected = '';
            }
            ?>
            <option <?PHP echo $Selected?> value="<?PHP echo $CarrerasData[$i]['codigomodalidadacademica']?>"><?PHP echo $CarrerasData[$i]['nombremodalidadacademica']?></option>
            <?PHP
        }//for
        ?>
    </select>
    <?PHP
}//function CarreraSeccion

function CarreraSeccion($db,$carrera,$modalidad=null){
   if($modalidad==null){
		   $SQL='SELECT
			k.codigocarrera,
			k.nombrecarrera

		FROM
			carrera k
		WHERE
			k.codigomodalidadacademica = (
				SELECT
					c.codigomodalidadacademica
				FROM
					carrera c
				WHERE
					c.codigocarrera = "'.$carrera.'"
			)
		AND k.codigocarrera NOT IN (1, 2)
		AND (
			k.fechavencimientocarrera >= curdate()
			OR k.EsAdministrativa = 1
		)
		ORDER BY
			k.nombrecarrera';
   } else {
		   $SQL='SELECT
			k.codigocarrera,
			k.nombrecarrera

		FROM
			carrera k
		WHERE
			k.codigomodalidadacademica = "'.$modalidad.'" 
		AND k.codigocarrera NOT IN (1, 2)
		AND (
			k.fechavencimientocarrera >= curdate()
			OR k.EsAdministrativa = 1
		)
		ORDER BY
			k.nombrecarrera';
   }
    
    if($CarrerasData=&$db->GetAll($SQL)===false){
        echo 'Error en el Sistema...';
        die;
    }    
    
   
    $html = '<select id="programaAcademico" name="programaAcademico">';
        
        for($i=0;$i<count($CarrerasData);$i++){
            if($CarrerasData[$i]['codigocarrera']==$carrera){
                $Selected = 'selected="selected"';
            }else{
                 $Selected = '';
            }
            
            $html.='<option '.$Selected.' value="'.$CarrerasData[$i]['codigocarrera'].'">'.$CarrerasData[$i]['nombrecarrera'].'</option>';
            
        }//for
    $html.='</select>';
    return $html;
}//function CarreraSeccion

function EstadoMateria($db,$materia){
      $SQL='SELECT
            	e.codigoestadomateria,
            	e.nombreestadomateria
            FROM
            	estadomateria e
            INNER JOIN materia m ON m.codigoestadomateria = e.codigoestadomateria
            WHERE
            	m.codigomateria = "'.$materia.'"';
      
      if($EsatdoMateria=&$db->Execute($SQL)===false){
         echo 'Error en el Sistema..';
         die;
      }          
                
      $SQL='SELECT
            	e.codigoestadomateria,
            	e.nombreestadomateria
            FROM
            	estadomateria e';     
                
      if($Estados=&$db->Execute($SQL)===false){
         echo 'Error en el sistema...';
         die;
      }               
    
    ?>
    <select id="EstadoMateria" name="EstadoMateria">
    <?PHP            
    while(!$Estados->EOF){
        if($Estados->fields['codigoestadomateria']==$EsatdoMateria->fields['codigoestadomateria']){
            $Selecte = 'selected="selected"';
        }else{
            $Selecte = '';
        }
        ?>
        <option <?PHP echo $Selecte;?> value="<?PHP echo $Estados->fields['codigoestadomateria']?>"><?PHP echo $Estados->fields['nombreestadomateria']?></option>
        <?PHP
        $Estados->MoveNext();
    }  
    ?>
    </select>
    <?PHP          
}//function EstadoMateria


require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
$q = $_REQUEST["carrera"];
if ($q){
	echo CarreraSeccion($db,$q,$_REQUEST["modalidad"]);
}
?>