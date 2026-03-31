<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once ('../EspacioFisico/templates/template.php');
    include_once ('./Permisos/class/PermisosRotacion_class.php');
    $rutaVistas = "./vistasRotaciones"; /*carpeta donde se guardaran las vistas (html) de la aplicación */
    require_once(realpath(dirname(__FILE__))."/../../Mustache/load.php"); /*Ruta a /html/Mustache */
    		include(realpath(dirname(__FILE__))."/../utilidades/helpers/funcionesLoop.php");
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
    $sql = "SELECT nombrecarrera,codigocarrera FROM carrera WHERE codigocarrera=".$_SESSION["codigofacultad"]; 
    $carrera=$db->GetRow($sql);
    		
    $db->Execute("SET @conteo=0");		
    	$sql = "SELECT @conteo:=@conteo+1 AS conteo, Especialidad,EspecialidadCarreraId as id, 
    			FechaCreacion as fecha,
    			FechaModificacion as fecha2, u.usuario 
    			from EspecialidadCarrera  e
    			INNER JOIN usuario u on e.UsuarioModificacion=u.idusuario 
    			where e.codigoestado=100 AND codigocarrera=".$carrera["codigocarrera"]."
    			order by FechaModificacion DESC";
    	$especialidades=$db->GetAll($sql);
    	//var_dump($especialidades);
    	$template = $mustache->loadTemplate('listaEspecialidades');
    	//$g_counterEspecialidades = 1;
    	echo $template->render(array('title' => 'Servicios o Especialidades Carrera',	
    						'carrera' =>$carrera["nombrecarrera"],
    						'especialidades' =>$especialidades,
    						'class_even' => $helper_contadorParImpar//,
    						//'variable' => 'g_counterEspecialidades'
    						)
    					);
?>