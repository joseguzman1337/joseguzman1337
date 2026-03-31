<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once ('../EspacioFisico/templates/template.php');
    include_once ('./Permisos/class/PermisosRotacion_class.php');
    $rutaVistas = "./vistasRotaciones"; /*carpeta donde se guardaran las vistas (html) de la aplicación */
    require_once("../utilidades/helpers/funcionesLoop.php");
    require_once("../../Mustache/load.php");/*Ruta a /html/Mustache */

    $db = getBD();
    /*$C_Permisos = new PermisosRotacion();
    
    $SQL_User='SELECT idusuario as id, codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
    if($Usario_id=&$db->Execute($SQL_User)===false)
    {
    	echo 'Error en el SQL Userid...<br>'.$SQL_User;
    	die;
    }
    $userid=$Usario_id->fields['id'];
    
    $Acceso = $C_Permisos->PermisoUsuarioRotacion($db,$userid,1,11);
    if($Acceso['val']===false){
        ?>
        <blink>
            <?PHP echo $Acceso['msn'];?>
        </blink>
        <?PHP
        Die;
    }*/

//echo '<pre>';print_r($_SESSION);
$sql = "SELECT nombrecarrera,codigocarrera FROM carrera WHERE codigocarrera=".$_SESSION["codigofacultad"]; 
$carrera=$db->GetRow($sql);
		
$db->Execute("SET @conteo1=0");		
			
$query ="select @conteo1:=@conteo1+1 AS conteo, m.codigomateria, m.nombrecortomateria, m.nombremateria, m.numerocreditos, m.codigoperiodo,  
			  m.codigocarrera,t.NombreTipoRotacion FROM materia m, TipoRotaciones t, grupo g
				WHERE m.codigocarrera = '".$_SESSION["codigofacultad"]."' AND m.codigomateria<>1 
				and m.codigoestadomateria = '01' and t.TipoRotacionId=m.TipoRotacionId 
				and  g.codigomateria = m.codigomateria
				and g.codigoperiodo = '".$_SESSION['codigoperiodosesion']."' and g.codigoestadogrupo = '10'
				group by m.codigomateria
				order by m.nombremateria";
                //echo $query;
$materias=$db->GetAll($query);
//var_dump($especialidades);
$template = $mustache->loadTemplate('listaMaterias');
//$g_counterEspecialidades = 1;
echo $template->render(array('title' => 'Materias del Programa',	
					'carrera' =>$carrera["nombrecarrera"],
					'materias' =>$materias,
					'class_even' => $helper_contadorParImpar,
					'rotacion' => false
					)
				);
?>
      