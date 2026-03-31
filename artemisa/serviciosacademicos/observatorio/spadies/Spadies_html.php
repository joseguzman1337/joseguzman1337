<?php
session_start();
/*if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesi�n en el sistema</strong></blink>';
	exit();
} */


switch($_REQUEST['actionID']){
    case 'BuscarCarreras':{
        global $db,$userid,$C_Spadies;
        define(AJAX,true);
        MainGeneral();
        
        $Modalidad  = $_POST['Modalidad'];
        
        $C_Spadies->Carreras($Modalidad,1);
    }break;
    case 'Auditoria':{
        global $db,$userid,$C_Spadies;
        define(AJAX,true);
        MainGeneral();
        
        $C_Spadies->Auditoria();
    }break;
    case 'BuscarText':{
        global $db,$userid;
        
        MainJson();
        
        $TypeRepote         = $_POST['TypeRepote'];
        
        switch($TypeRepote){
            case '0':{
                ?>
                "Son los alumnos que ingresan por primera vez a la instituci&oacute;n de Educaci&oacute;n Superior, Caracterizados por:<br />
                <ul style="color: black;">
                    <li>Alumnos que ingresan por primera vez a la IES, despu&eacute;s de aprobar el proceso de admisi&oacute;n e ingresan a primer semestre de un programa</li>
                    <li>Alumnos que ingresan por primera vez a la instituci&oacute;n por homologaci&oacute;n o traslado</li>
                    <li>Alumnos que se grad&uacute;an de un programa y contin&uacute;an con otro. En el caso de las IES que ofrecen programas T&eacute;cnicos, Tecnol&oacute;gicos y pregrado, cada vez que el estudiante termine un ciclo lo debe registrar en la planilla de graduados y para el siguiente ciclo se debe registrar como prim&iacute;paro asoci&aacute;ndole el c&oacute;digo SNIES ya sea del programa Tecnol&oacute;gico o de Pregrado</li>
                </ul>"
                <?PHP
            }break;
            case '1':{
                ?>
                "Es el total de alumnos que se matriculan en el IES para los diversos programas que ofrece.<br />
                Aquellos alumnos que pagan alg&uacute;n dinero ya sea para ver una sola materia o para presentar la tesis o pasant&iacute;as tambi&eacute;n se deben registrar, en caso de que el alumno este realizando sus pasant&iacute;as y la IES no tiene como requisito matricular ese semestre o semestres, la IES no lo debe registrar."
                <?PHP
            }break;
            case '2':{
                ?>
                "Son los alumnos que en el semestre citado se grad&uacute;an de un programa."
                <?PHP
            }break;
            case '3':{
                ?>
                "Son los registros de los estudiantes que por alg&uacute;n motivo se ausentande la universidad y esta ausencia no es voluntaria del estudiante, sino, que le es impuesta por alguna normatividad propia de la IES de car&aacute;cter disciplinario. Son todos aquellos estudiantes que por razones exclusivamente disciplinarias (casos de plagio, falta al reglamento, etc) han sido sancionados disciplinariamnete por la instituci&oacute;n y por esa raz&oacute;n no se encuentran mariculados en la instituci&oacute;n dentro del per&iacute;odo en cuesti&oacute;n. Todos los retiros disciplinarios deben estar respaldados por un acto administrativo."
                <?PHP
            }break;
            case '4':{
                ?>
                "Son los estudiantes que se benefician con apoyos acad&eacute;micosque no representan ning&uacute;n costo, los cuales pueden ser:<br />
                <ul style="color: black;">
                    <li>Monitorias acad&eacute;micas.</li>
                    <li>Plenarias.</li>
                    <li>Tutor&iacute;as.</li>
                    <li>Semilleros de investigaci&oacute;n.</li>
                    <li>Cursos inter-semestrales.</li>
                    <li>Nivelaciones.</li>
                    <li>Actividades acad&eacute;micas encaminadas al refuerzo de los conocimientos, habilidades y competencias.</li>
                    <li>Cursos de nivelaci&oacute;n orientados hacia aquellos estudiantes que deseen adelantar materias o cr&eacute;ditos acad&aacute;micos del siguiente semestre.</li>
                </ul>"
                <?PHP
            }break;
            case '5':{
                ?>
                "Son los estudiantes que se beneficiaron con un apoyo finaciero que son todos aquellos apoyos que ofrece directamente la IES sin intermediarios como los son:<br />
                <ul style="color: black;">
                    <li>Becas y descuentos en el valor de la matr&iacute;cula por m&eacute;ritos acad&eacute;micos, deportivos o art&iacute;sticos.</li>
                    <li>Descuentos en el valor de la matr&iacute;cula por convenios interinstitucionales o por cooperaci&oacute;n extranjera.</li>
                    <li>Descuentos en el valor de la matr&iacute;cula por acuerdos sindicales o con empleados.</li>
                    <li>Est&iacute;mulos econ&oacute;micos por participaci&oacute;n en actividades curriculares.</li>
                    <li>Finaciaci&oacute;n directa del valor de la matr&iacute;cula.</li>
                    <li>Finaciaci&oacute;n de la alimentaci&oacute;n o transporte.</li>
                </ul>"
                <?PHP
            }break;
            case '6':{
                ?>   
                "Son los estudiantes que se benefician con apoyos acad&eacute;micos que no representan ningun costo, los cuales pueden ser:<br />
                <ul style="color: black;">
                    <li>Monitorias acad&eacute;micas.</li>
                    <li>Plenarias.</li>
                    <li>Tutor&iacute;as.</li>
                    <li>Semilleros de investigaci&oacute;n.</li>
                    <li>Cursos inter-semestrales.</li>
                    <li>Nivelaciones.</li>
                    <li>Actividades acad&eacute;micas encaminadas alrefuerzo de los conocimientos, habilidades y competencias.</li>
                    <li>Cursos de nivelaci&oacute;n orientados hacia aquellos estudiantes que deseen adelantar materias o cr&eacute;ditos acad&eacute;micos del siguiente semestre.</li>
                </ul>"
                <?PHP
            }break;
        }
        
    }break;
    case 'Ecxel':{
        global $db,$userid,$C_Spadies;
        
        include ('Spadies_Class.php');  $C_Spadies = new Spadies();
        MainJson();
        
        
        $TypeRepote         = $_REQUEST['TypeRepote'];
        $Carrera_id         = $_REQUEST['Carrera_id'];
        $Periodo            = $_REQUEST['Periodo'];
        $TypeSemestre       = $_REQUEST['TypeSemestre'];
        $Modalidad          = $_REQUEST['Modalidad'];
        
        
        switch($TypeRepote){
            case '0':{$Repote  = 'Primer_Nivel';}break;
            case '1':{$Repote  = 'Matriculados';}break;
            case '2':{$Repote  = 'Graduados';}break;
            case '3':{$Repote  = 'Retiros_Disciplinarios';}break;
            case '4':{$Repote  = 'Apoyos_Academicos';}break;
        }
        
        $arrayP = str_split($Periodo, strlen($Periodo)-1);
                
        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename=".$arrayP[0].'-'.$arrayP[1].'-'.$Repote.".xls");  
        header("Pragma: no-cache");
        header("Expires: 0");
        
        
        $C_Spadies->Reportes($TypeRepote,$Carrera_id,$Periodo,$TypeSemestre,'1',$Modalidad,true,true);  
        
        
        
    }break;
    case 'CSV':{
        global $db,$userid,$C_Spadies;
        
        include ('Spadies_Class.php');  $C_Spadies = new Spadies();
        MainJson();
        
        
        $TypeRepote         = $_REQUEST['TypeRepote'];
        $Carrera_id         = $_REQUEST['Carrera_id'];
        $Periodo            = $_REQUEST['Periodo'];
        $TypeSemestre       = $_REQUEST['TypeSemestre'];
        $Modalidad          = $_REQUEST['Modalidad'];
        
        
        switch($TypeRepote){
            case '0':{$Repote  = 'Primer_Nivel';}break;
            case '1':{$Repote  = 'Matriculados';}break;
            case '2':{$Repote  = 'Graduados';}break;
            case '3':{$Repote  = 'Retiros_Disciplinarios';}break;
            case '4':{$Repote  = 'Apoyos_Academicos';}break;
        }
        
        $arrayP = str_split($Periodo, strlen($Periodo)-1);
                
         
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Encoding: UTF-8');
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=".$arrayP[0].'-'.$arrayP[1].'-'.$Repote.".csv");  
        header("Pragma: no-cache");
        header("Expires: 0");
        
        $a = "<table">$_REQUEST['csvdata'];
        //var_dump($a);
        preg_match('/<table(>| [^>]*>)(.*?)<\/table( |>)/is',$a,$b);
        if(count($b)>0){
            $table = $b[2];
            //var_dump($table);
            preg_match_all('/<tr(>| [^>]*>)(.*?)<\/tr( |>)/is',$table,$b);
            $rows = $b[2];
            //var_dump($rows);
            foreach ($rows as $row){
                    preg_match_all('/<td(>| [^>]*>)(.*?)<\/td( |>)/is',$row,$b);
                    if(count($b[2])>0){
                        $out[] = strip_tags(implode(',',$b[2]));
                    }
            }
            $out = implode("\n", $out);
            print_r(utf8_decode($out)); 
        } else {
            $a = "<table>".$_REQUEST['csvdata']."</table>";
            $doc = new DOMDocument();
            $doc->loadHTML("<html><body>".$a."</body></html>");
            //$tables = $doc->getElementsByTagName('tbody');
            //$table = $tables->item(0);
            $rows = $doc->getElementsByTagName('tr');
            foreach ($rows as $row) {
                $line = "";
                foreach ($row->childNodes as $node) {
                    if ($node->nodeName == 'td') {
                        if($line===""){
                            $line = $node->nodeValue;
                        } else {
                            $line .= ",".$node->nodeValue;
                        }
                    }
                }
                if($line!==""){
                    $out[] = $line;   
                }
                /*$html = $row->nodeValue;
                $b = explode(" ", $html);
                var_dump($b);
                $out[] = strip_tags(implode(',',$b[2]));*/
            }
            $out = implode("\n", $out);
            echo "\xEF\xBB\xBF"; // UTF-8 BOM
            print_r(utf8_decode($out));    
        }
        
        //echo $_REQUEST['csvData'];
        
       // $reporte = $C_Spadies->Reportes($TypeRepote,$Carrera_id,$Periodo,$TypeSemestre,'1');
        //$html = str_get_html($table);
        
        
    }break;
    case 'BuscarInfo':{
        global $db,$userid,$C_Spadies;
        define(AJAX,true);
        MainGeneral();
        
        $TypeRepote         = $_POST['TypeRepote'];
        $Carrera_id         = $_POST['Carrera_id'];
        $Periodo            = $_POST['Periodo'];
        $TypeSemestre       = $_POST['TypeSemestre'];
        $Modalidad          = $_POST['Modalidad'];
        
        include("../../utilidades/funcionesTexto.php");
        $C_Spadies->Reportes($TypeRepote,$Carrera_id,$Periodo,$TypeSemestre,'',$Modalidad);
        
        
    }break;
    default:{
        global $db,$userid,$C_Spadies;
        define(AJAX,false);
        MainGeneral();
        MainJSGeneral();
        
        $C_Spadies->Display();
        
    }break;
}//switch
function MainGeneral(){
    
    global $db,$userid,$C_Spadies;
    
    //include ('../templates/mainjson.php');
    
    if(AJAX==false){
        include("../templates/templateObservatorio.php");
        $db =writeHeader("Gesti&oacute;n de Reportes",true,"Spadies",1);
        
    }else{
        include ('../templates/mainjson.php');
	    
    }
    
    
    
    include ('Spadies_Class.php');  $C_Spadies = new Spadies();
	
	
	$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
	
	if($Usario_id=&$db->Execute($SQL_User)===false){
		echo 'Error en el SQL Userid...<br>';
		die;
	}
	
	$userid=$Usario_id->fields['id'];
    
}
function MainJson(){
	
	global $db,$userid;
	
	
	include ('../templates/mainjson.php');
	
	$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
	
	if($Usario_id=&$db->Execute($SQL_User)===false){
		echo 'Error en el SQL Userid...<br>';
		die;
	}
	
	$userid=$Usario_id->fields['id'];
	
}
function MainJSGeneral(){
    ?>
    <script type="text/javascript" language="javascript" src="Spadies.js"></script> 
    <?PHP
}//MainJSGeneral

?>