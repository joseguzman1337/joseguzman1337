<?php
    session_start();

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once("../../serviciosacademicos/funciones/phpmailer/class.phpmailer.php");
    require_once("../../serviciosacademicos/funciones/validaciones/validaciongenerica.php");
    require_once("correoactivacioncuenta.php");
    require_once("constantesactivacion.php");

    if (isset($_REQUEST["ingresar"])) {
        is_file(dirname(__FILE__) . "/../../sala/includes/adaptador.php")
            ? require_once(dirname(__FILE__) . "/../../sala/includes/adaptador.php")
            : require_once(realpath(dirname(__FILE__) . "/../../sala/includes/adaptador.php"));

        $condicion = " and eg.idestudiantegeneral=up.idestudiantegeneral ".
        " and eg.emailestudiantegeneral='" . $_POST['usuario'] . "' ".
        " and up.claveusuariopreinscripcion='" . hash('sha256', $_POST['clave']) . "'";
        $tablas = "usuariopreinscripcion up,estudiantegeneral eg";
        $sql = "select numerodocumento from $tablas where 1 $condicion";
        $datosestudiante = $db->GetRow($sql);

        if (isset($datosestudiante['numerodocumento']) && !empty($datosestudiante['numerodocumento'])) {
            #session para validar que es una inscripcion activa
            $_SESSION['inscripcionactiva']=1;
            #session de usaurio igual a estudiante para que no genere problemas al insertar en logpagos
            $_SESSION['MM_Username'] = 'estudiante';
            # varible session id usuario seteado con el id de estudiante de la tabla usuario
            $_SESSION['idusuario'] = '6492'; //id ususario = estudiante

            if(isset($_POST['ajax']) && !empty($_POST['ajax'])){
                $data= array('val'=>true, 'doc'=>$datosestudiante['numerodocumento'], 'msg'=>'Datos correctos');
                echo json_encode($data);
            }else{
                echo "<META HTTP-EQUIV='Refresh' CONTENT='0;
            URL=../../serviciosacademicos/consulta/prematricula/inscripcionestudiante/formulariopreinscripcion.php?documentoingreso=" . $datosestudiante['numerodocumento'] . "'>";
            }
        } else {
            $mensaje = "Usuario o clave incorrectos, intente recuperar su contraseña o comuniquese a la mesa de servicio. ext 1555";
            if(isset($_POST['ajax']) && !empty($_POST['ajax'])) {
                $data= array('val'=>false, 'doc'=>'','msg'=>$mensaje);
                echo json_encode($data);
            }else{
                swal($mensaje);
                echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=" . ENLACEINGRESOASPIRANTE . "'>";
            }
        }
    }