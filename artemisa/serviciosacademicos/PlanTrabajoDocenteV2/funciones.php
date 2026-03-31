<?php

	function orderMultiDimensionalArray ($toOrderArray, $field, $inverse = false) {
    $position = array();
    $newRow = array();
    foreach ($toOrderArray as $key => $row) {
            $position[$key]  = $row[$field];
            $newRow[$key] = $row;
    }
    if ($inverse) {
        arsort($position);
    }
    else {
        asort($position);
    }
    $returnArray = array();
    foreach ($position as $key => $pos) {     
        $returnArray[] = $newRow[$key];
    }
    return $returnArray;
}

function strtolower_utf8($cadena) {
      $convertir_a = array(
           "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u",
           "v", "w", "x", "y", "z", "à", "á", "â", "ã", "ä", "å", "æ", "ç", "è", "é", "ê", "ë","ę", "ì", "í", "î", "ï",
           "ð", "ñ", "ò", "ó", "ô", "õ", "ö", "ø", "ù", "ú", "û", "ü", "ý", "а", "б", "в", "г", "д", "е", "ё", "ж",
           "з", "и", "й", "к", "л", "м", "н", "о", "п", "р", "с", "т", "у", "ф", "х", "ц", "ч", "ш", "щ", "ъ", "ы",
           "ь", "э", "ю", "я"
      );
      $convertir_de = array(
           "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U",
           "V", "W", "X", "Y", "Z", "À", "Á", "Â", "Ã", "Ä", "Å", "Æ", "Ç", "È", "É", "Ê", "Ë","Ę", "Ì", "Í", "Î", "Ï",
           "Ð", "Ñ", "Ò", "Ó", "Ô", "Õ", "Ö", "Ø", "Ù", "Ú", "Û", "Ü", "Ý", "А", "Б", "В", "Г", "Д", "Е", "Ё", "Ж",
           "З", "И", "Й", "К", "Л", "М", "Н", "О", "П", "Р", "С", "Т", "У", "Ф", "Х", "Ц", "Ч", "Ш", "Щ", "Ъ", "Ъ",
           "Ь", "Э", "Ю", "Я"
      );
      return str_replace($convertir_de, $convertir_a, $cadena);
 }

function titleCase($string, $delimiters = array(" ", "-", "O'"), $exceptions = array("to", "a", "the", "of", "by", "and", "with", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X")) { 
       /* 
        * Exceptions in lower case are words you don't want converted 
        * Exceptions all in upper case are any words you don't want converted to title case 
        *   but should be converted to upper case, e.g.: 
        *   king henry viii or king henry Viii should be King Henry VIII 
        */ 
       foreach ($delimiters as $delimiter){ 
               $words = explode($delimiter, $string); 
               $newwords = array(); 
               foreach ($words as $word){ 
                       if (in_array(strtoupper($word), $exceptions)){ 
                               // check exceptions list for any words that should be in upper case 
                               $word = strtoupper($word); 
                       } elseif (!in_array($word, $exceptions)){ 
                               // convert to uppercase 
                               $word = ucfirst($word); 
                       } 
                       array_push($newwords, $word); 
               } 
               $string = join($delimiter, $newwords); 
       } 
       return $string; 
}

function decode_entities($text) {
    $text= html_entity_decode($text,ENT_QUOTES,"ISO-8859-1"); #NOTE: UTF-8 does not work!
    $text= preg_replace('/&#(\d+);/me',"chr(\\1)",$text); #decimal notation
    $text= preg_replace('/&#x([a-f0-9]+);/mei',"chr(0x\\1)",$text);  #hex notation
    return $text;
}

function listar_archivos($carpeta){
	$fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'xlsx', 'xls', 'docx', 'doc', 'ppt', 'pptx', 'txt', 'pdf');
    if(is_dir($carpeta)){
        if($dir = opendir($carpeta)){ ?>
        	<link type="text/css" rel="stylesheet" href="css/style2.css">
			<div style="width: 80%; margin-left: 50px;">
			<h3 style="margin-top:30px;margin-bottom:0; font-weight: normal; font-family: Lucida Grande,Lucida Sans Unicode,Lucida Sans,Geneva,Verdana,sans-serif;">Los siguientes son los documentos asociados como evidencia a las actividades académicas</h3>
			<br />
			<ol id="listaDocumentos">
            <?php while(($archivo = readdir($dir)) !== false){
            	$filePart = pathinfo($archivo);
                if (in_array(strtolower($filePart['extension']), $fileTypes)) {
                	if($archivo != '.' && $archivo != '..' && $archivo != '.htaccess'){
                	
                	$ubicacion = base64_encode("ubicacion");
					$nombre = base64_encode("nombre");
                	$file = base64_encode( urlencode( serialize( "".$carpeta."/".$archivo."" ) ) );
				?>
				<li><a id="linkDocumentos" target="_blank" href="<?php echo 'descargar.php?'.$ubicacion.'='.$file.'&'.$nombre.'='. base64_encode( urlencode( serialize( $archivo ) ) ) .''; ?>" style="text-decoration: none;"><?php echo $archivo; ?></a></li>
              <?php  } 
				}
            } ?>
            </ol>
            </div>
           <?php closedir($dir);
        }
    }
}


function recorre_arbol($directorio, $db, $idVocacion){
 $fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'xlsx', 'xls', 'docx', 'doc', 'ppt', 'pptx', 'txt', 'pdf');
  $hDir= opendir($directorio); ?>
  <link type="text/css" rel="stylesheet" href="css/style2.css">
	<div style="width: 80%; margin-left: 50px;">
	<br />
	<ol id="listaDocumentos">
   <?php while($fich = readdir($hDir)) {
   		
        if(is_dir($directorio.'/'.$fich) && $fich != '.' && $fich != '..') {
        	
			if( $idVocacion == 1 ){
				
				$sqlPlanEstudio = "SELECT
										codigomateria
									FROM
										PlanesTrabajoDocenteEnsenanza
									WHERE
										PlanTrabajoDocenteEnsenanzaId = ".$fich."";
				$codigoMateria = $db->Execute( $sqlPlanEstudio );
				$codigoMateria = $codigoMateria->fields["codigomateria"];
				
	        	$sql = "SELECT codigomateria, nombremateria
	        			FROM materia
	        			WHERE codigomateria = ".$codigoMateria."";
				$materia = $db->Execute( $sql );
				$nombremateria = $materia->fields["nombremateria"];
			}else{
				$sql = "SELECT
							PlanTrabajoDocenteOtrosId, Nombres
						FROM
							PlanesTrabajoDocenteOtros
						WHERE
							PlanTrabajoDocenteOtrosId = ".$fich."";
				$materia = $db->Execute( $sql );
				$nombremateria = $materia->fields["Nombres"];
			}
                echo $nombremateria."<br />";
            recorre_arbol($directorio.'/'.$fich);
        }
        else 
        $filePart = pathinfo($fich);
        if (in_array(strtolower($filePart['extension']), $fileTypes)) {
        	if ($fich != '.' && $fich != '..') { 
        	$ubicacion = base64_encode("ubicacion");
			$nombre = base64_encode("nombre");
        	$file = base64_encode( urlencode( serialize( "".$directorio."/".$fich."" ) ) );
        	?>
            <li><a id="linkDocumentos" target="_blank" href="<?php echo 'descargar.php?'.$ubicacion.'='.$file.'&'.$nombre.'='. base64_encode( urlencode( serialize( $fich ) ) ) .''; ?>" style="text-decoration: none;"><?php echo $fich; ?></a></li>
               <?php }
          }
    }
    ?>
   </ol>
            </div>
 <?php closedir($hDir);
}


?>