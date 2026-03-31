<?php
    require_once('../../../serviciosacademicos/Connections/sala2.php');
    require('../../../serviciosacademicos/funciones/funcionpassword.php');
    $rutaado = '../../../serviciosacademicos/funciones/adodb/';
    require_once('../../../serviciosacademicos/Connections/salaado.php');
    require_once('../../../serviciosacademicos/funciones/phpmailer/class.phpmailer.php');
    require_once("../correoactivacioncuenta.php");
    require_once("../constantesactivacion.php");

$hoy = date("Y-m-d H:i:s");
switch($_POST['action']){
    case 'Validar':{
        $tipodocumento = explode("|*||*|" ,$_POST['tipodocumento']);
        $SQL_Existei= "SELECT tipodocumento,numerodocumento,nombresestudiantegeneral,apellidosestudiantegeneral,".
        " emailestudiantegeneral,numerodocumento,fechanacimientoestudiantegeneral ".
        " FROM estudiantegeneral WHERE 1 ";
        $SQL_ExisteCA= "AND tipodocumento = '".$tipodocumento[0]."' 
                        AND numerodocumento = '".$_POST['documento']."' 
                        AND fechanacimientoestudiantegeneral='".$_POST['fechanacimiento']."' ";
        $SQL_Existe=$SQL_Existei;
        $SQL_Existe.=$SQL_ExisteCA;
        $resultadoExiste = $db->GetRow($SQL_Existe);           
        if($resultadoExiste){  
            $SQL_tdoc= "SELECT nombredocumento FROM documento WHERE tipodocumento= '".$tipodocumento[0]."'";
            $resultadotdoc = $db->GetRow($SQL_tdoc);
            echo '<strong>Tipo de Documento:</strong> '.$resultadotdoc['nombredocumento'];
            echo '<br><strong>Documento:</strong> '.$resultadoExiste['numerodocumento'];
            echo '<br><strong>Direccion de Correo:</strong> '.$resultadoExiste['emailestudiantegeneral'];
            echo '<br><br>Ya se encuentran registrados, por favor continue al paso dos, si no recuerda su contraseña intente recuperarla. ';
            echo '<br><br>Si los datos registrados no corresponden a sus datos personales comunique a la mesa de ayuda de la universidad mesadeservicio@unbosque.edu.co o la ext: 1555.';
        }else{
            $SQL_ExisteCB= "AND nombresestudiantegeneral LIKE '%".$_POST['nombre']."%' 
                            AND apellidosestudiantegeneral LIKE '%".$_POST['apellido']."%' 
                            AND fechanacimientoestudiantegeneral='".$_POST['fechanacimiento']."' ";
            $SQL_Existex=$SQL_Existei;
            $SQL_Existex.=$SQL_ExisteCB;
            $resultadoExisteb = $db->GetRow($SQL_Existex);           
            if($resultadoExisteb){
                echo '<strong>Nombres:</strong> '.$resultadoExisteb['nombresestudiantegeneral'];
                echo '<br><strong>Apellidos:</strong> '.$resultadoExisteb['apellidosestudiantegeneral'];
                echo '<br><strong>Direccion de Correo:</strong> '.$resultadoExisteb['emailestudiantegeneral'];
                echo '<br><br>Ya se encuentran registrados, por favor continue al paso dos, si no recuerda su contraseña intente recuperarla. ';
                echo '<br><br>Si los datos registrados no corresponden a sus datos personales comunique a la mesa de ayuda de la universidad mesadeservicio@unbosque.edu.co o la ext: 1555.';
            }else{
                $SQL_ExisteCC= "AND emailestudiantegeneral ='".$_POST['correo']."' ";
                $SQL_Existey=$SQL_Existei;
                $SQL_Existey.=$SQL_ExisteCC;
                $resultadoExistec = $db->GetRow($SQL_Existey); 
                if($resultadoExistec){
                echo '<br><strong>Direccion de Correo:</strong> '.$resultadoExistec['emailestudiantegeneral'];
                echo '<br><br>Ya se encuentran registrados, por favor continue al paso dos, si no recuerda su contraseña intente recuperarla. ';
                echo '<br><br>Si los datos registrados no corresponden a sus datos personales comunique a la mesa de ayuda de la universidad mesadeservicio@unbosque.edu.co o la ext: 1555.';                    
                }                
            } 
        } 
    }
    break;
    case 'Nuevo':{
        $sqlexiste = "select idestudianteinscripciontemporal as id from estudianteinscripciontemporal ".
        " where codigoestado = 100 and tipodocumento = '".$_POST['tipodocumento']."' ".
        " and documentoestudianteinscripciontemporal = '".$_POST['documento']."' ".
        " and correoestudianteinscripciontemporal = '".$_POST['correo']."' ".
        " and fechanacimientoestudianteinscripciontemporal = '".$_POST['fechanacimiento']."' ";
        $idexiste = $db->GetRow($sqlexiste);

        if(!isset($idexiste['id']) && empty($idexiste['id'])){
            $SQL_insert ="INSERT INTO estudianteinscripciontemporal( ".
            " idtrato, nombresestudianteinscripciontemporal, apellidosestudianteinscripciontemporal, ".
            " correoestudianteinscripciontemporal, tipodocumento, documentoestudianteinscripciontemporal, ".
            " codigogenero, fechanacimientoestudianteinscripciontemporal, telefonoresidenciaestudianteinscripciontemporal, ".
            " celularestudianteinscripciontemporal, claveestudianteinscripciontemporal, codigoestado, ".
            " flagestudianteinscripciontemporal ) ".
            " VALUES ( '1', '".strtoupper($_POST['nombre'])."', '".strtoupper($_POST['apellido'])."',  ".
            " '".$_POST['correo']."', '".$_POST['tipodocumento']."', '".$_POST['documento']."', '".$_POST['codigogenero']."', ".
            " '".$_POST['fechanacimiento']."', '".$_POST['telefonoresidencia']."', '".$_POST['celular']."', ".
            " '".hash('sha256', $_POST['clave'])."', '100', '".$_POST['politica']."' )";
            $db->Execute($SQL_insert);
        }

        $sqlbusqueda = "select idestudianteinscripciontemporal, correoestudianteinscripciontemporal, ".
        " nombresestudianteinscripciontemporal, apellidosestudianteinscripciontemporal, ".
        " correoestudianteinscripciontemporal from estudianteinscripciontemporal where 1 ".
        " and tipodocumento='".$_POST["tipodocumento"]."' and documentoestudianteinscripciontemporal='" .
        $_POST['documento']."' and codigoestado = 100 and correoestudianteinscripciontemporal = '".$_POST['correo']."' ";
        $datosestudiante = $db->GetRow($sqlbusqueda);

        $mktimeactiva = mktime();
        $tiempoactivacion = 86400;
        $urlactivacion = ENLACEACTIVACION . "?ta=" . $mktimeactiva .
        "&id=" . $datosestudiante["idestudianteinscripciontemporal"] .
        "&correo=" . $datosestudiante["correoestudianteinscripciontemporal"]."&lang=es-es";

        $destinatario = $datosestudiante["correoestudianteinscripciontemporal"];
        $nombredestinatario = $datosestudiante["nombresestudianteinscripciontemporal"] . " " . $datosestudiante["apellidosestudianteinscripciontemporal"];
        $trato = "<B>UNIVERSIDAD EL BOSQUE<BR>ACTIVACION USUARIO ASPIRANTE</B><BR>Cordial Saludo";
        $mensaje = "<br><br> ".
        " Gracias por preferir la UNIVERSIDAD EL BOSQUE, La siguiente es la información de su cuenta para ".
        " continuar su inscripcion <br><br>Nombre: " . $nombredestinatario .
        "<br>Correo: " . $datosestudiante["correoestudianteinscripciontemporal"] .
        "<br>Clave: " . $_POST['clave'] .
        "<br><br>Para continuar con su proceso de inscripción de click ".
        "<a href='" . $urlactivacion . "' target='new'>aqui</a> ".
        " o copie el siguiente enlace en su navegador<br><br><br>" . $urlactivacion;

        $array_datos_correspondencia['correoorigencorrespondencia'] = "UNIVERSIDAD EL BOSQUE";
        $array_datos_correspondencia['nombreorigencorrespondencia'] = "UNIVERSIDAD EL BOSQUE";
        $array_datos_correspondencia['asuntocorrespondencia'] = "UNIVERSIDAD EL BOSQUE ACTIVACION USUARIO ASPIRANTE";
        $array_datos_correspondencia['encabezamientocorrespondencia'] = $mensaje;
        ConstruirCorreo($array_datos_correspondencia, $destinatario, $nombredestinatario, $trato);
        echo $urlactivacion;
    }
    break;
}
?>