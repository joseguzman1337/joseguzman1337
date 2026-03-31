<?php
 /*include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);*/

?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<?php
require(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado-pear.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/formulariov2/clase_formulario.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');
require_once("../../../funciones/funcionip.php");
$fechahoy=date("Y-m-d H:i:s");
$idpazysalvoegresado=$_GET['idpazysalvoegresado'];
$formulario = new formulario(&$sala,"form1","post","",true,"detallepazysalvoegresado.php");
$ip=$formulario->tomarip();
$formulario->jsCalendario();
$formulario->agregar_tablas('detallepazysalvoegresado','iddetallepazysalvoegresado');
if(isset($_GET['iddetallepazysalvoegresado']) and !empty($_GET['iddetallepazysalvoegresado'])){
	$formulario->cargar('iddetallepazysalvoegresado',$_GET['iddetallepazysalvoegresado']);
}
?>
<strong>Edición de detalle de paz y salvo egresados (Parametrización de las cartas egresados)</strong><br><br>
<form name="form1" action="" method="POST">
<table border="1" cellpadding="1" cellspacing="0" width="60%" bordercolor="#E9E9E9">
<?php $formulario->celda_horizontal_combo('idtipodetallepazysalvoegresado','Tipo detalle','tipodetallepazysalvoegresado','detallepazysalvoegresado','idtipodetallepazysalvoegresado','nombretipodetallepazysalvoegresado','requerido','','','nombretipodetallepazysalvoegresado');?>
<?php $formulario->celda_vertical_memo('textodetallepazysalvoegresado','Detalle','detallepazysalvoegresado','90','4','requerido');?>
<?php $formulario->celda_horizontal_combo('codigoestado','Estado','estado','detallepazysalvoegresado','codigoestado','nombreestado','requerido','','','nombreestado');?>
<?php $formulario->celda_horizontal_campotexto('ubicacionpaginadetallepazysalvoegresado','Ubicación página carta egresados','detallepazysalvoegresado',5,'numero');?>
</table>

<?php
$formulario->Boton('Enviar','Enviar','submit');
?>
</form>

<?php
if(isset($_POST['Enviar'])){
	$valido=$formulario->valida_formulario();
	if($valido){
		$formulario->agregar_datos_formulario('detallepazysalvoegresado','idpazysalvoegresado',$idpazysalvoegresado);

        //inscritos despues de enviar los saca del sistema
        if($_REQUEST['descriptor'] == "ediciondetallepazysalvoegresado")
        {
            $data['idtipodetallepazysalvoegresado'] = $_REQUEST['idtipodetallepazysalvoegresado'];
            $data['textodetallepazysalvoegresado'] = $_REQUEST['textodetallepazysalvoegresado'];
            $data['codigoestado'] = $_REQUEST['codigoestado'];
            $data['ubicacionpaginadetallepazysalvoegresado'] = $_REQUEST['ubicacionpaginadetallepazysalvoegresado'];
            $formulario->actualizarFilaBD('detallepazysalvoegresado',$data,'iddetallepazysalvoegresado',$_REQUEST['iddetallepazysalvoegresado']);
            $data['iddetallepazysalvoegresado'] = $_REQUEST['iddetallepazysalvoegresado'];
        }
        else
        {
            $data['idtipodetallepazysalvoegresado'] = $_REQUEST['idtipodetallepazysalvoegresado'];
            $data['textodetallepazysalvoegresado'] = $_REQUEST['textodetallepazysalvoegresado'];
            $data['codigoestado'] = $_REQUEST['codigoestado'];
            $data['ubicacionpaginadetallepazysalvoegresado'] = $_REQUEST['ubicacionpaginadetallepazysalvoegresado'];
            $formulario->insertar();
            $data["iddetallepazysalvoegresado"] = $formulario->conexion->Insert_ID();
        }
        //echo "<pre>"; print_r($_REQUEST); echo "</pre>";

        $query_id = "select idusuario
        from usuario
        where usuario = '".$_SESSION['MM_Username']."'";
        $oper = $formulario->conexion->query($query_id);
        $row_id = $oper->fetchRow();
        $data['idusuario'] = $row_id['idusuario'];

        $query = "select idpazysalvoegresado
        from detallepazysalvoegresado
        where iddetallepazysalvoegresado = '".$data["iddetallepazysalvoegresado"]."'";
        $oper_id = $formulario->conexion->query($query);
        $row_id = $oper_id->fetchRow();
        $data['idpazysalvoegresado'] = $row_id['idpazysalvoegresado'];

        $data['ip'] = tomarip();

        // Aca va el log de los cambios del detallepazysalvoegresado
        $ins_query = "INSERT INTO logdetallepazysalvoegresado(idlogdetallepazysalvoegresado, iddetallepazysalvoegresado, idpazysalvoegresado, idtipodetallepazysalvoegresado, textodetallepazysalvoegresado, codigoestado, ubicacionpaginadetallepazysalvoegresado, fechalogdetallepazysalvoegresado, idusuario, ip)
        VALUES(0, '".$data['iddetallepazysalvoegresado']."', '".$data['idpazysalvoegresado']."', '".$data['idtipodetallepazysalvoegresado']."', '".$data['textodetallepazysalvoegresado']."', '".$data['codigoestado']."', '".$data['ubicacionpaginadetallepazysalvoegresado']."', now(), '".$data['idusuario']."', '".$data['ip']."')";
        $ins = $formulario->conexion->query($ins_query);
?>
<script language='javascript'>
    alert('Datos actualizados correctamente');
    window.close();
    window.opener.recargar();
</script>
<?php
    }
}
?>