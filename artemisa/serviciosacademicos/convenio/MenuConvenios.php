<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once (realpath(dirname(__FILE__)).'/../EspacioFisico/templates/template.php');
    include_once (realpath(dirname(__FILE__)).'/./Permisos/class/PermisosConvenio_class.php'); $C_Permisos = new PermisosConvenio();
    include_once(realpath(dirname(__FILE__)).'/../mgi/Menu.class.php');        $C_Menu_Global  = new Menu_Global();

    $db = getBD();
    $SQL_User='SELECT idusuario as id, codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';    
    $Usario_id=$db->GetRow($SQL_User);
    
    $Acceso = $C_Permisos->PermisoUsuarioConvenio($db,$Usario_id['id'],1,1);        
    if($Acceso['val']===false){
        ?>
        <blink>
            <?PHP echo $Acceso['msn'];?>             
        </blink>
        <?PHP
        Die;
    }  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Menú Convenios</title>
		<link type="text/css" href="../educacionContinuada/css/normalize.css" rel="stylesheet">
		<link media="screen, projection" type="text/css" href="../educacionContinuada/css/style.css" rel="stylesheet">
		<link media="screen, projection" type="text/css" href="css/style.css" rel="stylesheet">
         <style>
        table tr td a{
            background: transparent -moz-linear-gradient(center top , #7db72f, #4e7d0e) repeat scroll 0 0;
            border: 1px solid #538312;
            border-radius: 10px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            color: #e8f0de;
            cursor: pointer;
            display: inline-block;
            font-size: 14px;
            padding: 8px 19px 9px;
            text-align: center;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);
            text-decoration: none;
        }
        
        </style> 
    </head>
    <body class="body"> 
    <div id="pageContainer">
	    <div id="container">
            <center>
                <h1>SISTEMA DE CONVENIOS</h1>
            </center>
            <table align="center" cellpadding="14">
                <tr>
                    <td>
                        <a href="ConveniosActivos.php" class="buttonForm">Ver Convenios Activos</a>
                    </td>
                    <td>
                        <a href="ConveniosEnTramite.php" class="buttonForm">Ver Convenios En Trámite</a>
                    </td>    
                    <td>
                        <a href="ConveniosVencidos.php" class="buttonForm">Ver Convenios Vencidos</a>
                    </td>
                </tr>
            </table> 
            <?php
            if($Acceso['Rol'] !== '2')
            {
            ?>          
            <center>
                <h1>SOLICITUDES DE CONVENIOS</h1>
            </center>
                <table align="center" cellpadding="14" >
                    <tr><?php ?>
                        <td>
                            <a href="nuevapropuesta.php" class="buttonForm">Hacer Nueva Solicitud</a>
                        </td>
                        <td>
                            <a href="Propuestaconvenio.php" class="buttonForm">Ver Solicitudes</a>
                        </td>
                    </tr>
                </table>
            <?php
            }?>
        </div>   	
	</div>
    </body>
</html>