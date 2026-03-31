<?php
error_reporting(E_ALL);
/**
 * @modifed ivan Quintero <quinteroivan@unbosque.edu.co>
 * Se ajusta la consulta pra validacion de periodos y consulta de usuarios pendientes por activacion y creacion
 * @since Enero 15 del 2019
 */

require_once("../../../Connections/sala2.php");
$rutaado = "../../../funciones/adodb/";
require_once("../../../Connections/salaado.php");
require_once('../../../consulta/generacionclaves.php');

echo "<h2>Proceso para Creacion de usuarios pendientes</h2>";

$sqlestudiantes = "SELECT u.idusuario, e.codigoestudiante, o.numeroordenpago,".
" g.numerodocumento, c.codigocarrera ".
" FROM ordenpago o  ".
" INNER JOIN detalleordenpago od ON ( o.numeroordenpago = od.numeroordenpago ) ".
" INNER JOIN estudiante e ON ( o.codigoestudiante = e.codigoestudiante ) ".
" INNER JOIN estudiantegeneral g ON ( e.idestudiantegeneral = g.idestudiantegeneral ) ".
" INNER JOIN carrera c ON ( c.codigocarrera = e.codigocarrera ) ".
" LEFT JOIN usuario u ON ( g.numerodocumento = u.numerodocumento) ".
" WHERE o.codigoperiodo in (select codigoperiodo from periodo p where p.codigoestadoperiodo in (1, 3, 4)) ".
" AND od.codigoconcepto = 151 ".
" AND o.codigoestadoordenpago IN (40, 41, 44, 52) ".
" AND c.codigomodalidadacademica in  (200, 800, 300) ".
" and u.idusuario is NULL";
$datos = $db->GetAll($sqlestudiantes);

$html = "<table border='1px'>"
        . "<tr>"
        . "<td>#</td>"
        . "<td>CodigoEstudiante</td>"
        . "<td>NumeroOrden</td>"        
        . "</tr>";
$l=1;
foreach ($datos as $valores) {
    sleep(5);
    $html.="<tr>"
            . "<td>".$l."</td>"
            . "<td>".$valores['codigoestudiante']."</td>"
            . "<td>".$valores['numeroordenpago']."</td>";    
    //actualiza en 40 el estado de la prematricula de la orden de pago
    $query_prematricula = "UPDATE prematricula p, ordenpago o
    set p.codigoestadoprematricula = 40
    where o.idprematricula = p.idprematricula
    and o.codigoestudiante = p.codigoestudiante
    and o.numeroordenpago = ".$valores['numeroordenpago']."
    and o.codigoperiodo = p.codigoperiodo";    
    $prematricula = $db->Execute($query_prematricula);

    //Actualiza el estado del detalle prematricula en 30
    $query_detalleprematricula = "UPDATE detalleprematricula
    set codigoestadodetalleprematricula = '30'
    where numeroordenpago = ".$valores['numeroordenpago']."
    and codigoestadodetalleprematricula like '1%'";
    $detalleprematricula = $db->Execute($query_detalleprematricula);
    
    //CREA CUENTA CORREO
    $objetoclaveusuario = new GeneraClaveUsuario($valores['numeroordenpago'], $db);
    $html.= "<td>";
    
    $sqldatosusuario= "select g.apellidosestudiantegeneral, g.nombresestudiantegeneral, 
    u.usuario, l.tmpclavelogcreacionusuario, g.emailestudiantegeneral
    from estudiantegeneral g
    INNER JOIN estudiante e on (g.idestudiantegeneral = e.idestudiantegeneral)
    INNER JOIN usuario u on (g.numerodocumento = u.numerodocumento)
    INNER JOIN logcreacionusuario l on (u.idusuario = l.idusuario)
    WHERE e.codigoestudiante = ".$valores['codigoestudiante']." and u.codigotipousuario = 600";
    $datosusuario = $db->GetRow($sqldatosusuario);
    $nuevousuario = $datosusuario['usuario'];
    $apellidos = $datosusuario['apellidosestudiantegeneral'];
    $nombres = $datosusuario['nombresestudiantegeneral'];
    $clave = $datosusuario['tmpclavelogcreacionusuario'];
    $email = $datosusuario['emailestudiantegeneral'];
    //$email = "quinteroivan@unbosque.edu.co";
    
    echo "<br><br>***".$nuevousuario." - ".$apellidos." - ".$nombres." - ".$clave." - ".$email."**<br>";
    
    require_once(dirname(__FILE__)."/../../../../interfacegoogle/crearusuariogoogle.php");
    crearUsuarioGoogle($nuevousuario,$apellidos,$nombres,$clave,$email);
    echo "<br /><br />";
    construccionCorreo($nuevousuario,$apellidos,$nombres,$clave,$email);
    echo "<br /><br />";  
    $html.="</td></tr>";
    $l++;
}
$html.= "</table>";
echo $html;

function construccionCorreo($usuario,$apellidos,$nombres,$clave,$email) {
    require_once(dirname(__FILE__)."/../../../funciones/clases/phpmailer/class.phpmailer.php");
    $mail = new PHPMailer();
    $mail->SetLanguage("es", dirname(__FILE__).'/../../../funciones/clases/phpmailer/language/');
    $mail->From = "mesadeservicio@unbosque.edu.co";
    $mail->FromName = "MESA DE SERVICIO UNIVERSIDAD EL BOSQUE";
    $mail->ContentType = "text/html";
    $mail->Subject = "USUARIO CUENTA CORREO INSTITUCIONAL";
    $cuerpo="<b>BIENVENIDO A LA UNIVERSIDAD EL BOSQUE</b><br><br>".
            "La Universidad El Bosque le hace entrega del nombre de usuario y contraseña para el ingreso al servicio de correo y herramientas de servicios académicos.".
            "Puede ingresar a la página http://www.uelbosque.edu.co/ por la opción <b>EL BOSQUE DIGITAL</b>.<br><br>".
            "Puede ingresar a la seccion de <b>Entornos Digitales</b> http://www.uelbosque.edu.co/entornos-digitales.<br><br>".
            "<b>usuario:\t".$usuario."</b><br><b>clave:\t".$clave."</b>";
    $mail->Body = $cuerpo;
    $mail->AddAddress($email,$apellidos." ".$nombres);
    //$mail->AddAddress("bonillaleyla@unbosque.edu.co",$apellidos." ".$nombres);
    if($mail->Send())
            echo "<b><font color='green'>CORRECTO:</font></b> Se envío email de notificación de creación de cuenta al correo <b>".$email."</b>.<br>";
    else 
            echo "<b><font color='red'>ERROR:</font></b> No se pudo enviar email de notificación de creación de cuenta al correo <b>".$email."</b>. Motivo: ".$mail->ErrorInfo.".<br>";
}