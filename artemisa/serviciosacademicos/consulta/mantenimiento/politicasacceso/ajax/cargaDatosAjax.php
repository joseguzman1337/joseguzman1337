<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
include('../../../../../sala/includes/adaptador.php');
include('../modelo/resetClaveUsuarioModelo.php');
if (isset($_GET['accion'])){
    $accion = $_GET['accion'];
    $nombreUsuario =  $_GET['nombreUsuario'];
    $email = $updateMailInstitucional= '';
    $condicion='';
    switch ($accion) {
        case "administrativo":
            $condicion = "u.codigotipousuario='400'";
            $cnsUsuario = modeloResetClave::mdlCnsusuario($nombreUsuario,$condicion);
            $emailAdministrativo = $cnsUsuario['emailadministrativosdocentes'];
            $emailInstitucional = $cnsUsuario['EmailInstitucional'];
            $idAdministrativoDocente = $cnsUsuario['idadministrativosdocentes'];


            if ((isset($emailAdministrativo) && !empty($emailAdministrativo)) || (isset($emailInstitucional) && !empty($emailInstitucional))){
                    $email = $nombreUsuario.'@unbosque.edu.co';
                if ($emailAdministrativo!='' && $emailInstitucional==''){
                    $email = $emailAdministrativo;
                    $eMailInstitucional = $email;
                    $condicionUpdate = "EmailInstitucional='".$eMailInstitucional."'";
                }
                modeloResetClave::mdlActualizaCorreo($idAdministrativoDocente,$condicionUpdate);
                if ($emailInstitucional!='' && $emailAdministrativo ==''){
                    $email = $emailInstitucional;
                }
                echo "<script type='text/javascript'>
                        $('#emailAdministrativo').val('".$email."');
                      </script>";
            }
            break;
        case 'docentes':
          //
            break;
        default:
            # code..
            break;
    }
}
?>


