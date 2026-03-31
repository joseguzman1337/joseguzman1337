<?php
session_start();
$rol=$_SESSION['rol'];
//$_SESSION['MM_Username']='admintecnologia';
//print_r($_SESSION);
$rutaado=("../../../funciones/adodb/");
require_once("../../../funciones/clases/debug/SADebug.php");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/clases/phpmailer/class.phpmailer.php");
require_once("../../../funciones/validaciones/validaciongenerica.php");
require_once("funciones/datos_mail.php");
?>
<html>
    <head>
<script LANGUAGE="JavaScript">
function quitarFrame()
{
    if (self.parent.frames.length != 0)
    self.parent.location=document.location.href="../../../../aspirantes/aspirantes.php";

}
function regresarGET()
{
    document.location.href="<?php echo $_GET['link_origen']?>";
}
//quitarFrame()
</script>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
<meta  content="text/html;" http-equiv="content-type" charset="UTF-8">

</head>
<body>
<?php
$fechahoy=date("Y-m-d H:i:s");
$formulario=new formulario($sala,'form1','post','','true');
if($_REQUEST['depurar']=="si")
{
    $depurar=new SADebug();
    $depurar->trace($formulario,'','');
    $formulario->depurar();
    if($_REQUEST['depurar_correo']=="si")
    {
        $depura_correo=true;
    }
    else
    {
        $depura_correo=false;
    }
}

$periodo=$formulario->carga_periodo_2_intentos(4,1);
$formulario->agregar_tablas('preinscripcion','idpreinscripcion');
if($_REQUEST['observacionpreinscripcionseguimiento']!="" or isset($_GET['idpreinscripcion']))
{
    $formulario->agregar_tablas('preinscripcionseguimiento','idpreinscripcionseguimiento',NULL,true);
}
$ip=$formulario->GetIP();
$documentoobligatorio = false;
if($ip != '190.144.204.2')
    $documentoobligatorio = true;

$formulario->array_datos_formulario[]=array('tabla'=>'preinscripcion','campo'=>'ip','valor'=>$ip);
$formulario->array_datos_formulario[]=array('tabla'=>'preinscripcion','campo'=>'codigoestado','valor'=>'100');
$formulario->array_datos_formulario[]=array('tabla'=>'preinscripcion','campo'=>'idusuario','valor'=>'1');
$formulario->array_datos_formulario[]=array('tabla'=>'preinscripcion','campo'=>'fechapreinscripcion','valor'=>$fechahoy);

$formulario->array_datos_formulario[]=array('tabla'=>'preinscripcion','campo'=>'codigoperiodo','valor'=>$periodo);
$formulario->array_datos_formulario[]=array('tabla'=>'preinscripcion','campo'=>'codigoestadopreinscripcionestudiante','valor'=>'300');
$formulario->array_datos_formulario[]=array('tabla'=>'preinscripcion','campo'=>'idtipoorigenpreinscripcion','valor'=>'2');

?>
<a href="../../../../aspirantes/aspirantessec.php" onClick="quitarFrame()" id="aparencialinknaranja">inicio</a>
<br><p></p>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
<tr>
    <td>
    Si tienes alguna dificultad en este proceso, puedes comunicarte al
    e-mail <a href="mailto:atencionalusuario@unbosque.edu.co">atencionalusuario@unbosque.edu.co</a>
    <br>Teléfono 6489072<br>
    </td>
</tr>
</table>
<br>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
<tr>
    <td>Gracias por tu interés en nuestros programas.<br>Si deseas mayor información registra tus datos. Si nos dejas tu correo electrónico recibirás respuesta inmediata. (te llegará un archivo en formato Word el cual contiene la información de tu interés). Si sólo dejas tu teléfono, espera nuestro contacto para dar respuesta a tu solicitud.</td>
</tr>
</table>
<form name="form1" action="" method="POST">
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
    <caption align="left"><p>
    Registra aquí tus datos personales</p></caption>
    <tr>
        <td colspan="2"><label id="labelresaltado">Datos Requeridos</label></td>
    </tr>
    <tr>
        <td id="tdtitulogris"><?php $formulario->etiqueta('idtrato','Trato','requerido');?></td>
        <td><?php $formulario->combo('idtrato','preinscripcion','post','trato','idtrato','nombretrato',"",'nombretrato','','','','');?></td>
    </tr>
    <tr>
        <td id="tdtitulogris"><?php $formulario->etiqueta('nombresestudiante','Nombre','requerido');?></td>
        <td><?php $formulario->campotexto('nombresestudiante','preinscripcion',50,'','','','');?></td>
    </tr>
    <tr>
        <td id="tdtitulogris"><?php $formulario->etiqueta('apellidosestudiante',"Apellidos",'requerido');?></td>
        <td><?php $formulario->campotexto('apellidosestudiante','preinscripcion',50,'','','','');?></td>
    </tr>
<?php
if($documentoobligatorio) :
?>
    <tr>
        <td id="tdtitulogris"><?php
        $formulario->etiqueta('tipodocumento','Tipo de Documento','requerido');
?></td>
<td><?php $formulario->combo('tipodocumento','preinscripcion','post','documento','tipodocumento','nombredocumento',"",'nombredocumento',"","","","");?></td>
    </tr>
    <tr>
        <td id="tdtitulogris"><?php $formulario->etiqueta('numerodocumento',"Documento",'requerido');?></td>
        <td><?php $formulario->campotexto('numerodocumento','preinscripcion',50,'','','','');?></td>
    </tr>
<?php
endif;
?>
    <tr>
        <td id="tdtitulogris"><?php $formulario->etiqueta('emailestudiante','E-mail','');
        $formulario->asterisco('emailestudiante');
        if($_POST['emailestudiante']!="")
        {
            $mailvalido=validaciongenerica($_POST['emailestudiante'],'email','',true);
            if($mailvalido['valido']==0)
            {
                $formulario->agregar_validaciones_extra('emailestudiante','email',false,'El mail se encuentra mal digitado');
            }
        }
        ?></td>
        <td><?php $formulario->campotexto('emailestudiante','preinscripcion',30,'','','','');?><label id="labelresaltado">(Se requiere el E-mail o el Teléfono)</label></td>
    </tr>
    <tr>
        <td id="tdtitulogris"><?php
        $formulario->etiqueta('telefonoestudiante','Teléfono','');
        $formulario->asterisco('telefonoestudiante');?></td>
        <td><?php $formulario->campotexto('telefonoestudiante','preinscripcion',10,'','','','');?><label id="labelresaltado">(Se requiere el E-mail o el Teléfono)</label></td>
    </tr>
    <tr>
        <td id="tdtitulogris"><?php
        $formulario->etiqueta('celularestudiante','Otro Teléfono','');
        //$formulario->asterisco('celularestudiante');?></td>
        <td><?php $formulario->campotexto('celularestudiante','preinscripcion',10,'','','','');?></td>
    </tr>
    <tr>
        <td id="tdtitulogris"><?php
        $formulario->etiqueta('ciudadestudiante','Ciudad residencia','requerido');
        //$formulario->asterisco('ciudadestudiante');?></td>
        <td><?php $formulario->combo('ciudadestudiante','preinscripcion','post','ciudad','idciudad','nombreciudad',"",'nombreciudad',"","","","");?></td>
    </tr>
    <tr>
        <td colspan="2"><label id="labelresaltado">Datos Opcionales</label></td>
    </tr>
    <tr>
        <td id="tdtitulogris"><?php $formulario->etiqueta('observacionpreinscripcionseguimiento','Observación','');?></td>
        <td><?php $formulario->memo('observacionpreinscripcionseguimiento','preinscripcionseguimiento',70,3,'','','','');?></td>
    </tr>
    <tr>
        <td id="tdtitulogris"><?php $formulario->etiqueta('codigomodalidadacademica','Modalidad académica','');?></td>
        <td><?php $formulario->combo_valor_por_defecto('codigomodalidadacademica','','','modalidadacademica','codigomodalidadacademica','nombremodalidadacademica','200','codigoestado=100','nombremodalidadacademica','onChange=enviar()','','','La naturaleza de la carrera')?></td>
    </tr>
</table>
<br>
<?php

if(isset($_POST['codigomodalidadacademica']))
{
    $query_carrera="
    SELECT DISTINCT c.codigocarrera, c.nombrecarrera
    FROM carrera c, carreragrupofechainscripcion cgfi
    WHERE
    c.codigocarrera=cgfi.codigocarrera
    AND '$fechahoy' <= cgfi.fechahastacarreragrupofechainformacion
    AND c.codigomodalidadacademica='".$_POST['codigomodalidadacademica']."'
    AND c.codigocarrera <> 1
    ORDER BY c.nombrecarrera
    ";
    $formulario->cuadro_chulitos_bd_query($query_carrera,'Marca aquí las carreras de tu interés','carrera','','','nombrecarrera','codigocarrera','nombrecarrera','preinscripcioncarrera','idpreinscripcioncarrera','codigoestado',100,200,2,"750","wrap");
}
else
{
    $query_carrera="
    SELECT DISTINCT c.codigocarrera, c.nombrecarrera
    FROM carrera c, carreragrupofechainscripcion cgfi
    WHERE
    c.codigocarrera=cgfi.codigocarrera
    AND '$fechahoy' <= cgfi.fechahastacarreragrupofechainformacion
    AND c.codigomodalidadacademica=200
    AND c.codigocarrera <> 1
    ORDER BY c.nombrecarrera
    ";
    $formulario->cuadro_chulitos_bd_query($query_carrera,'Marca aquí las carreras de tu interés','carrera','','','nombrecarrera','codigocarrera','nombrecarrera','preinscripcioncarrera','idpreinscripcioncarrera','codigoestado',100,200,2,"750","wrap");
}

?>
<br>
<input type="submit" name="Enviar" value="Enviar">
<?php
$cantidad_llamadas_cuadro_chulitos=1;
?>
<?php
if(isset($_REQUEST['Enviar']))
{
    //print_r($_POST);
    $formulario->submitir();
    $formulario->agregar_datos_formulario('preinscripcion','codigoindicadorenvioemailacudientepreinscripcion','100');
    $formulario->agregar_datos_formulario('preinscripcion','idempresa','1');

    if($_POST['tipodocumento']=="")
    {
        $formulario->agregar_datos_formulario('preinscripcion','tipodocumento','0');
    }
    else
    {
        $formulario->agregar_datos_formulario('preinscripcion','tipodocumento',$_POST['tipodocumento']);
    }

    if($_POST['codigocalendarioestudiante']=="")
    {
        $formulario->agregar_datos_formulario('preinscripcion','codigocalendarioestudiante','0');
    }

    if($_POST['telefonoestudiante']=="" and $_POST['emailestudiante']=="")
    {
        $formulario->agregar_validaciones_extra('telefono_mail','requerido',false,'Teléfono e E-mail');
    }

    $valido=$formulario->valida_formulario();
    if($_REQUEST['observacionpreinscripcionseguimiento']!="" or isset($_GET['idpreinscripcion']))
    {
        if($documentoobligatorio)
        {
            $numerodocumento = $_REQUEST['numerodocumento'];
            $formulario->agregar_datos_formulario('preinscripcion','numerodocumento',$numerodocumento);
        }

        //$formulario->agregar_tablas('preinscripcionseguimiento','idpreinscripcionseguimiento');
        $formulario->array_datos_formulario[]=array('tabla'=>'preinscripcionseguimiento','campo'=>'fechapreinscripcionseguimiento','valor'=>$fechahoy);
        $formulario->array_datos_formulario[]=array('tabla'=>'preinscripcionseguimiento','campo'=>'idusuario','valor'=>'1');
        $formulario->array_datos_formulario[]=array('tabla'=>'preinscripcionseguimiento','campo'=>'codigoestado','valor'=>100);
        $formulario->array_datos_formulario[]=array('tabla'=>'preinscripcionseguimiento','campo'=>'idtipodetalleestudianteseguimiento','valor'=>1);
        $formulario->array_datos_formulario[]=array('tabla'=>'preinscripcionseguimiento','campo'=>'codigotipoestudianteseguimiento','valor'=>'999');
        $formulario->array_datos_formulario[]=array('tabla'=>'preinscripcionseguimiento','campo'=>'fechahastapreinscripcionseguimiento','valor'=>$fechahoy);

        if((!(isset($_SESSION['sesioncodigosituacionestadisticaestudiante'])))||($_SESSION['sesioncodigosituacionestadisticaestudiante']==''))
        $_SESSION['sesioncodigosituacionestadisticaestudiante']='100';

        $formulario->array_datos_formulario[]=array('tabla'=>'preinscripcionseguimiento','campo'=>'codigosituacionestadisticaestudiante','valor'=>$_SESSION['sesioncodigosituacionestadisticaestudiante']);

        $formulario->array_datos_formulario[]=array('tabla'=>'preinscripcionseguimiento','campo'=>'codigoprocesovidaestudiante','valor'=>'100');

    }
    $ids=$formulario->insertar("<script language='javascript'>reCarga('preinscripcion_enviada.html')</script>","<script language='javascript'>reCarga('preinscripcion_enviada.html')</script>",false);
    //$ids=$formulario->insertar('','');

    /**Instanciar mailer */
    if($valido==true and $_POST['emailestudiante']<>"")
    {
        //verificar que carreras chulió el interesado
        //si chulio 1 se instancia el objeto ObtenerDatosMail con el codigocarrera chuliado,
        //si no, pailas, se manda el generico, con codigocarrera 1
        foreach ($_POST as $key => $val)
        {
            if(ereg("selpreinscripcioncarrera",$key))
            {
                $codigocarrera=ereg_replace("selpreinscripcioncarrera","",$key);
                //$array_carreras_chuliadas[]=array('codigocarrera'=>$codigocarrera);
                $array_carreras_chuliadas[]=$codigocarrera;
            }
        }
        //echo "<pre>".print_r($array_carreras_chuliadas)."</pre>";
        //$depura_correo=true;
        /*if(count($array_carreras_chuliadas)==0 or count($array_carreras_chuliadas)>1)
        {
            $prueba=new ObtenerDatosMail($sala,1,2,$depura_correo);
        }
        else
        {*/
        $prueba=new ObtenerDatosMail($sala,$array_carreras_chuliadas,2,$depura_correo);
        //}
        $trato=$prueba->Obtener_trato();
        $correo=$prueba->Construir_correo($_POST['emailestudiante'],$_POST['nombresestudiante']." ".$_POST['apellidosestudiante'],$trato['nombretrato']);
        /*echo "Otro ? detalle_correspondencia: <pre>";
        print_r($_SESSION['detalle_correspondencia']);
        echo $_SESSION['detalle_correspondencia'];
        echo "</pre>";*/
        //exit();
        //$seguimiento=$prueba->Construir_correo_seguimiento($_POST['nombresestudiante']." ".$_POST['apellidosestudiante'],$ids[0]['ultimoid']);
        //echo "<h1>$correo $seguimiento</h1>";
        if($depura_correo==true)
        {
            exit();
        }
    }

    //insertar chulitos y cambiar pantallazo
    $datos_sql_preinscripcioncarrera[]=array('campo'=>'idpreinscripcion','valor'=>$ids[0]['ultimoid']);
    $datos_sql_preinscripcioncarrera[]=array('campo'=>'codigoestado','valor'=>100);
    $formulario->sql_cuadro_chulitos_bd_query($datos_sql_preinscripcioncarrera,'preinscripcioncarrera','codigocarrera','codigoestado',100,200,$cantidad_llamadas_cuadro_chulitos,"<script language='javascript'>reCarga('preinscripcion_enviada.html')</script>","<script language='javascript'>reCarga('preinscripcion_enviada.html')</script>",false);
}
?>
</form>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
<tr>
    <td>
    Si tienes alguna dificultad en este proceso, puedes comunicarte al
    e-mail <a href="mailto:atencionalusuario@unbosque.edu.co">atencionalusuario@unbosque.edu.co</a>
    <br>Teléfono 6489072<br>
    </td>
</tr>
</table>
<?php
if($_REQUEST['depurar']=="si")
{
    $depurar2=new SADebug();
    $depurar2->trace($formulario,'','');
    $formulario->depurar();
}
?>
</body>
</html>