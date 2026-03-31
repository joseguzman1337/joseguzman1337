<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
$rol=$_SESSION['rol'];
//$_SESSION['MM_Username']='admintecnologia';
//print_r($_SESSION);
$rutaado=("../../../funciones/adodb/");
require_once(realpath(dirname(__FILE__))."/../../../funciones/clases/debug/SADebug.php");
require_once(realpath(dirname(__FILE__))."/../../../Connections/salaado-pear.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/clases/formulario/clase_formulario.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/phpmailer/class.phpmailer.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/validaciones/validaciongenerica.php");
require_once(realpath(dirname(__FILE__))."/funciones/claseformularioaspirante.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/sala_genericas/FuncionesCadena.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/sala_genericas/FuncionesFecha.php");

require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");

//require_once('../../../funciones/clases/autenticacion/redirect.php' );
//echo $database_sala;
?>
<script LANGUAGE="JavaScript">
    function quitarFrame()
    {
        if (self.parent.frames.length != 0)
            self.parent.location=document.location.href="../../../../aspirantes/aspirantes.php";
    }
    function regresarGET()
    {
        //document.location.href="<?php echo "../../../".$_REQUEST['link_origen']?>";
<?php
if(!isset($_SESSION['sesion_linkorigen'])) {
    ?>
        document.location.href="<?php echo "../../estadisticas/matriculasnew/tabla_estadisticas_matriculas_detalle.php";?>";
    <?php
}
else {
    ?>
            document.location.href="<?php echo "../../estadisticas/matriculasnew/estadisticas_matriculas_detalle.php?".$_SESSION['sesion_linkorigen'];?>";
    <?php
}
?>
    }
    function enviarmenu(){
        var formulario=document.getElementById("form1");
        formulario.action="aspiranteseguimiento.php?codigoestudiante=<?php echo $_GET['codigoestudiante'] ?>";
        formulario.submit();
    }
    function resetenvio(){
        document.getElementById("idestudianteseguimiento").value="";
        document.getElementById("observacionestudianteseguimiento").value="";
        document.getElementById("codigotipoestudianteseguimiento").value="";
        enviarmenu();

        return false;
        //formulario.action="aspiranteseguimiento.php?codigoestudiante=<?php echo $_GET['codigoestudiante'] ?>";
        //formulario.submit();
    }
    function envioanula(idestudianteseguimiento,codigoestudiante){
        //formulario=
        document.getElementById("form1").action="aspiranteseguimiento.php?Anular=1&idestudianteseguimiento="+idestudianteseguimiento+"&codigoestudiante="+codigoestudiante;
        document.getElementById("idestudianteseguimiento").value=idestudianteseguimiento;
    }

    //quitarFrame()
</script>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script><script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
<?php
function detalleobservaciones($numerodetalle,$codigoestudiante,$objetobase,$formulario, $numerodocumento, $anular=0) {
    if(isset($_SESSION['sesioncodigoprocesovidaestudiante']))
    //$procesovida = "and es.codigoprocesovidaestudiante = '".$_SESSION['sesioncodigoprocesovidaestudiante']."'";

        $query="SELECT
		es.codigoestudiante,
		es.idestudianteseguimiento,
		es.observacionestudianteseguimiento observacion,
		es.fechaestudianteseguimiento as fecha,
		es.fechahastaestudianteseguimiento,
		fechadesdeestudianteseguimiento,
		p.nombrecortoproceso as proceso,
        u.usuario as usuario,
		t.nombretipoestudianteseguimiento ObservacionTipo,
		if(es.idtipodetalleestudianteseguimiento=1,t.nombretipoestudianteseguimiento,CONCAT(t.nombretipoestudianteseguimiento,' / ',tpd.nombretipodetalleestudianteseguimiento)) TipoObservacion,
        pr.nombreprocesovidaestudiante Proceso
        FROM  usuario u, proceso p, tipoestudianteseguimiento t, procesovidaestudiante pr, estudianteseguimiento es
			left join tipodetalleestudianteseguimiento tpd
			on es.idtipodetalleestudianteseguimiento=tpd.idtipodetalleestudianteseguimiento
		WHERE es.codigoestudiante='".$codigoestudiante."'
		AND es.idusuario = u.idusuario
		AND es.codigoestado like '1%'
		AND es.idproceso=p.idproceso
		AND t.codigotipoestudianteseguimiento=es.codigotipoestudianteseguimiento
        and es.codigoprocesovidaestudiante = pr.codigoprocesovidaestudiante
                $procesovida
        union
        SELECT
        ps.idpreinscripcion,
        ps.idpreinscripcionseguimiento,
        ps.observacionpreinscripcionseguimiento observacion,
        ps.fechapreinscripcionseguimiento as fecha,
        ps.fechapreinscripcionseguimiento as Fecha_Contacto,
        ps.fechahastapreinscripcionseguimiento as Fecha_Proximo_Contacto,
        '' proceso,
        if(u.usuario='wfcortes','Estudiante',u.usuario) as usuario,
        t.nombretipoestudianteseguimiento ObservacionTipo,
        if(ps.idtipodetalleestudianteseguimiento=1,t.nombretipoestudianteseguimiento,CONCAT(t.nombretipoestudianteseguimiento,' / ',tpd.nombretipodetalleestudianteseguimiento)) TipoObservacion,
        'Interesados' Proceso
        FROM  usuario u, tipoestudianteseguimiento t, preinscripcion p,preinscripcionseguimiento ps
            left join tipodetalleestudianteseguimiento tpd
            on ps.idtipodetalleestudianteseguimiento=tpd.idtipodetalleestudianteseguimiento
        WHERE p.numerodocumento='$numerodocumento'
        and p.idpreinscripcion = ps.idpreinscripcion
        and codigoperiodo = '".$_SESSION['codigoperiodo_reporte']."'
        AND ps.idusuario = u.idusuario
        AND ps.codigoestado like '1%'
        AND t.codigotipoestudianteseguimiento=ps.codigotipoestudianteseguimiento
        order by 1 desc
        ";
    //echo $query;
    $operacionquery=$objetobase->conexion->PageExecute($query, $numerodetalle, 1,false);
    $formulario->dibujar_fila_titulo('Ultimas Observaciones','labelresaltado',4);
    echo "<tr><td colspan='6' align='center'><table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width=100%>";
    $fila["Tipo_De_Observacion"]="";
    $fila["Observacion"]="";				//
    $fila["Asesora"]="";
    $fila["Fecha_Contacto"]="";
    $fila["Fecha_Proximo_Contacto"]="";
    $fila["Proceso"]="";
    if($anular)
        $fila["Anular"]="";				//
    $formulario->dibujar_filas_texto($fila,'tdtitulogris','',$comentariotitulo,$comentariocelda);

    $i=0;
    while($datosregistrogrado=$operacionquery->fetchRow()) {
        unset($fila);
        $fila[$datosregistrogrado["TipoObservacion"]]="";
        $fila[$datosregistrogrado["observacion"]]="";				//

        $fila[$datosregistrogrado["usuario"]]="";
        $fila[formato_fecha_defecto($datosregistrogrado["fechadesdeestudianteseguimiento"])]="";
        $fila[formato_fecha_defecto($datosregistrogrado["fechahastaestudianteseguimiento"])."."]="";
        $fila[$datosregistrogrado["Proceso"]]="";

        $botonanular="<input type='submit' name='Anular' id='Anular' value='Anular' onclick='envioanula(".$datosregistrogrado["idestudianteseguimiento"].",".$datosregistrogrado["codigoestudiante"].")'>";
        if($anular)
            $fila[$botonanular]="";				//

        $formulario->dibujar_filas_texto($fila,'','',$comentariotitulo,$comentariocelda);
    }
    echo "</table></td></tr>";
}
$fechahoy=date("Y-m-d H:i:s");
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$formulario2=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);
$formularioseguimiento=new formulariobaseestudiante($sala,'form1','post','','true');

if($_REQUEST['depurar']=="si") {
    $depurar=new SADebug();
    $depurar->trace($formulario,'','');
    $formulario->depurar();
    if($_REQUEST['depurar_correo']=="si") {
        $depura_correo=true;
    }
    else {
        $depura_correo=false;
    }
}
$codigoperiodo=$formulario->carga_periodo(4);
$formulario2->agregar_tablas('estudiantegeneral','idestudiantegeneral');
$formulario->agregar_tablas('estudiante','codigoestudiante');
$formularioseguimiento->agregar_tablas('estudiante','codigoestudiante');
$formularioseguimiento->agregar_tablas('estudianteseguimiento','idestudianteseguimiento');

$usuario=$formulario->datos_usuario();
$ip=$formulario->GetIP();
//echo "LINK_ORIGEN=".$_GET['link_origen'];
if(isset($_GET['codigoestudiante']) and $_GET['codigoestudiante']!="") {
    $datosestudiante=$formularioseguimiento->recuperar_datos_tabla('estudiante','codigoestudiante',$_GET['codigoestudiante']);

    $datoscarreraperiodo=$formularioseguimiento->recuperar_datos_tabla('carreraperiodo','codigocarrera',$datosestudiante['codigocarrera'],"and codigoperiodo=".$datosestudiante['codigoperiodo']);
//carga el formulario

    $row_estudiante=$formulario->datos_estudiante_noprematricula($_GET['codigoestudiante']);
    $formulario->cargar('codigoestudiante', $_GET['codigoestudiante']);
    $formulario2->cargar('idestudiantegeneral',$formulario->array_datos_cargados['estudiante']->idestudiantegeneral);

    //$formularioseguimiento->cargar('codigoestudiante', $_GET['codigoestudiante']);
    $formularioseguimiento->limites_flechas_tabla_padre_hijo('estudiante','estudianteseguimiento','codigoestudiante','idestudianteseguimiento',$_GET['codigoestudiante'],'codigoestado=100');
    //solo carga un id de la tabla hijo, porque no hay varios seguimientos
    //muestra flechas si aplica
    $maximo=count($_SESSION['array_flechas_tabla_padre_hijo']);
    if($maximo == 1) {
        $formularioseguimiento->iterar_flechas_tabla_padre_hijo();
        $formularioseguimiento->cargar_distintivo_condicional('estudiante','codigoestudiante',$_GET['codigoestudiante'],'codigotipoestudiante=10');
        $formularioseguimiento->cargar_distintivo_condicional_true('estudianteseguimiento','idestudianteseguimiento',$_SESSION['contador_flechas'],'codigoestado=100','codigoestudiante',$_GET['codigoestudiante']);
    }
    //carga las tablas de manera distintiva, porque hay varios seguimientos
    elseif($maximo >1) {
        $formularioseguimiento->iterar_flechas_tabla_padre_hijo();
        $formularioseguimiento->cargar_distintivo_condicional('estudiante','codigoestudiante',$_GET['codigoestudiante'],'codigotipoestudiante=10');
        $formularioseguimiento->cargar_distintivo_condicional('estudianteseguimiento','idestudianteseguimiento',$_SESSION['contador_flechas'],'codigoestado=100','codigoestudiante',$_GET['codigoestudiante']);
    }
    $formulario->cambiar_estado('estudiante','codigotipoestudiante',200,"<script language='javascript'>window.location.reload('".$_REQUEST['link_origen']."')</script>");


}
//echo "<pre>"; print_r($formulario2); echo "</pre>";
//echo "<h1>".$formulario2->array_datos_cargados['estudiantegeneral']->numerodocumento."numerodocumento</h1>";
$numerodocumento = $formulario2->array_datos_cargados['estudiantegeneral']->numerodocumento;
$datosciudadestudiante=$formularioseguimiento->recuperar_datos_tabla('ciudad','idciudad',$formulario2->array_datos_cargados['estudiantegeneral']->ciudadresidenciaestudiantegeneral);

$formulario2->array_datos_cargados['estudiantegeneral']->nombreciudadresidenciaestudiantegeneral=$datosciudadestudiante['nombreciudad'];
?>
<form name="form1" id="form1" action="" method="POST">
    <input type="hidden" name="link_origen" value="<?php echo $_REQUEST['link_origen']; ?>">
    <input type="hidden" name="AnularOK" value="">
    <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
        <?php $formulario->dibujar_fila_titulo('Datos Generales','labelresaltado');?>
        <tr>
            <td colspan="2">
                <?php
                $formulario2->dibujar_tabla_informacion_estudiante("../../../../","#003333","Estilo1","Estilo2","#CCCCCC");
                ?>
            </td>
        </tr>
        <?php
        if(isset($_GET['idestudianteseguimiento'])&&(isset($_REQUEST['Desbloquear']))) {
            $datosseguimiento=$objetobase->recuperar_datos_tabla('estudianteseguimiento','idestudianteseguimiento',$_GET['idestudianteseguimiento'],"","",0);
            $codigotipoestudianteseguimiento=$datosseguimiento["codigotipoestudianteseguimiento"];
            $observacionestudianteseguimiento=$datosseguimiento["observacionestudianteseguimiento"];
            $idtipodetalleestudianteseguimiento=$datosseguimiento["idtipodetalleestudianteseguimiento"];
            $fechadesdeestudianteseguimiento=formato_fecha_defecto($datosseguimiento["fechadesdeestudianteseguimiento"]);
            $fechahastaestudianteseguimiento=formato_fecha_defecto($datosseguimiento["fechahastaestudianteseguimiento"]);
            $idestudianteseguimiento=$_GET['idestudianteseguimiento'];
        }
        else {
            $codigotipoestudianteseguimiento=$_POST["codigotipoestudianteseguimiento"];
            $observacionestudianteseguimiento=$_POST["observacionestudianteseguimiento"];
            $idestudianteseguimiento=$_POST["idestudianteseguimiento"];
            $idtipodetalleestudianteseguimiento=$_POST["idtipodetalleestudianteseguimiento"];
            $fechadesdeestudianteseguimiento=$_POST["fechadesdeestudianteseguimiento"];
            $fechahastaestudianteseguimiento=$_POST["fechahastaestudianteseguimiento"];

        }

        $conboton=0;

        $condicion=" and codigoestado='100' and
		('".$fechahoy."' between fechadesdeestudianteseguimiento and fechahastaestudianteseguimiento)
		 and codigotipoestudianteseguimiento like '4%' ";
        if(!($datosseguimientovencido=$objetobase->recuperar_datos_tabla('estudianteseguimiento','codigoestudiante',$_GET['codigoestudiante'],$condicion,"",0))||isset($_REQUEST['Desbloquear'])) {

            detalleobservaciones(5,$_GET['codigoestudiante'],$objetobase,$formulario,$numerodocumento,1);
            $formulario->dibujar_fila_titulo('Nueva Observacion','labelresaltado',4);

            //$formulario->valida_formulario();

            /*$formulario->dibujar_fila_titulo('Datos Opcionales','labelresaltado');
		$parametrocombotiposeguimiento="'codigotipoestudianteseguimiento','estudianteseguimiento','post','tipoestudianteseguimiento','codigotipoestudianteseguimiento','nombretipoestudianteseguimiento','','','nombretipoestudianteseguimiento','require'";
		$formularioseguimiento->dibujar_campo('combo',$parametrocombotiposeguimiento,"Tipo Observacion","tdtitulogris",'codigotipoestudianteseguimiento','requerido');*/

            $condicion=" codigoestado='100'";
            $formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("tipoestudianteseguimiento","codigotipoestudianteseguimiento","nombretipoestudianteseguimiento",$condicion);
            $campo='menu_fila';
            $parametros="'codigotipoestudianteseguimiento','".$codigotipoestudianteseguimiento."','onchange=\'enviarmenu();\''";
            $formulario->dibujar_campo($campo,$parametros,"Tipo Observacion","tdtitulogris",'codigotipoestudianteseguimiento','');

            $condicion=" codigoestado='100'
					and codigotipoestudianteseguimiento='".$codigotipoestudianteseguimiento."'";
            $formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("tipodetalleestudianteseguimiento","idtipodetalleestudianteseguimiento","nombretipodetalleestudianteseguimiento",$condicion);
            if(is_array($formulario->filatmp)) {
                $campo='menu_fila';
                $parametros="'idtipodetalleestudianteseguimiento','".$idtipodetalleestudianteseguimiento."',''";
                $formulario->dibujar_campo($campo,$parametros,"Tipo Detalle Observacion","tdtitulogris",'idtipodetalleestudianteseguimiento','');
            }
            //$formularioseguimiento->dibujar_campo('memo',"'observacionestudianteseguimiento','estudianteseguimiento',70,8,'','','',''","Observacion","tdtitulogris",'observacionestudianteseguimiento','requerido');
            $campo = "boton_tipo";
            $parametros ="'text','fechadesdeestudianteseguimiento','".formato_fecha_defecto($fechahoy)."','readonly '";
            $formulario->dibujar_campo($campo,$parametros,"Fecha De Contacto","tdtitulogris",'fechadesdeestudianteseguimiento','requerido');
            $campo = "campo_fecha";
            $parametros ="'text','fechahastaestudianteseguimiento','".$fechahastaestudianteseguimiento."','onKeyUp = \"this.value=formateafecha(this.value);\" $funcionfechainicial'";
            $formulario->dibujar_campo($campo,$parametros,"Fecha Proximo Contacto","tdtitulogris",'fechahastaestudianteseguimiento','requerido');

            $campo="memo";
            $parametros="'observacionestudianteseguimiento','estudianteseguimiento',70,8,'','','',''";
            $formularioseguimiento->dibujar_campo($campo,$parametros,"Observacion","tdtitulogris",'observacionestudianteseguimiento');
            $formularioseguimiento->cambiar_valor_campo('observacionestudianteseguimiento',$observacionestudianteseguimiento);


            if(isset($_GET['codigoestudiante']) and $_GET['codigoestudiante']!="") {
                //if($maximo >1)
                //{

                //$formularioseguimiento->dibujar_campo('mostrar_flechas_tabla_padre_hijo','',"","tdtitulogris",'flechaspadrehijo');

                //}

                $datossubperiodo=$formularioseguimiento->recuperar_datos_tabla('subperiodo','idcarreraperiodo',$datoscarreraperiodo['idcarreraperiodo']);

                if(!isset($datossubperiodo['idsubperiodo'])||($datossubperiodo['idsubperiodo']==''))
                    $datossubperiodo['idsubperiodo']=1;

                $parametrocamposubperiodo="'hidden','idsubperiodo','".$datossubperiodo['idsubperiodo']."'";
                $formularioseguimiento->dibujar_campo('boton_tipo',$parametrocamposubperiodo,"","tdtitulogris",'idsubperiodo');

            }
            $parametrocampooculto="'hidden','idestudianteseguimiento','".$idestudianteseguimiento."'";
            $formularioseguimiento->dibujar_campo('boton_tipo',$parametrocampooculto,"","tdtitulogris",'Enviar');

            if($_REQUEST['Desbloquear']) {

                $parametrobotonenviar[$conboton]="'submit','Modificar','Modificar'";
                $boton[$conboton]='boton_tipo';
                $conboton++;
                $parametrobotonenviar[$conboton]="'submit','Anular','Anular'";
                $boton[$conboton]='boton_tipo';
                $conboton++;
                $parametrobotonenviar[$conboton]="'submit','Nuevo','Nuevo','onclick=\'return resetenvio();\''";
                $boton[$conboton]='boton_tipo';
                $conboton++;

            }
            else {
                $parametrobotonenviar[$conboton]="'submit','Enviar','Enviar'";
                $boton[$conboton]='boton_tipo';
                $conboton++;
            }
            //}
        }
        else {
            detalleobservaciones(5,$_GET['codigoestudiante'],$objetobase,$formulario,0);

            $formulario->dibujar_fila_titulo('<table width=100%><tr><td align="center" ><label id="labelresaltado">EL ESTUDIANTE YA HA FINALIZADO EL PROCESO DE SEGUIMIENTO</label></td></tr></table>','"labelresaltado"',4);
        }

        $parametrobotonventanaemergente="'Historial','listadoaspiranteseguimiento.php','codigoestudiante=".$_GET['codigoestudiante']."',800,400,10,100,'yes','yes','no','yes','no'";
        $formulario2->dibujar_campo('boton_ventana_emergente',$parametrobotonventanaemergente,"","tdtitulogris",'observacionaspiranteseguimiento');

        $parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=regresarGET()'";
        $boton[$conboton]='boton_tipo';
        $formulario2->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');

        //if(isset($_GET['nuevo']))
        //$formularioseguimiento->cambiar_valor_campo("observacionestudianteseguimiento","");

        if(isset($_REQUEST['Enviar'])) {
            if($formulario->valida_formulario()) {
                $tabla="estudianteseguimiento";
                $fila['codigoestudiante']=$_GET['codigoestudiante'];
                $fila['observacionestudianteseguimiento']=$_POST['observacionestudianteseguimiento'];
                $fila['codigotipoestudiante']=$datosestudiante['codigotipoestudiante'];
                $fila['codigosituacioncarreraestudiante']=$datosestudiante['codigosituacioncarreraestudiante'];
                $fila['fechaestudianteseguimiento']=$fechahoy;
                //$datoshistoricoestudiante=$formulario2->recuperar_datos_tabla('historicosituacionestudiante','codigoestudiante',$_GET['codigoestudiante'],'group by codigoestudiante',', max(idhistoricosituacionestudiante)');
                //$fila['fechadesdeestudianteseguimiento']=$datoshistoricoestudiante['fechainiciohistoricosituacionestudiante'];
                //$fila['fechahastaestudianteseguimiento']=$datoshistoricoestudiante['fechafinalhistoricosituacionestudiante'];
                $fila['fechadesdeestudianteseguimiento']=formato_fecha_mysql($_POST['fechadesdeestudianteseguimiento']);
                $fila['fechahastaestudianteseguimiento']=formato_fecha_mysql($_POST['fechahastaestudianteseguimiento']);
                $fila['codigoestado']='100';
                if(isset($usuario['idusuario']) and $usuario['idusuario']!="")
                    $fila['idusuario']=$usuario['idusuario'];
                else
                    $fila['idusuario']=4186;

                if(isset($_POST['idtipodetalleestudianteseguimiento'])&&(trim($_POST['idtipodetalleestudianteseguimiento'])!=''))
                    $fila['idtipodetalleestudianteseguimiento']=$_POST['idtipodetalleestudianteseguimiento'];
                else
                    $fila['idtipodetalleestudianteseguimiento']=1;

                $fila['ip']=$ip;
                $fila['idproceso']='3';
                $fila['codigotipoestudianteseguimiento']=$_POST['codigotipoestudianteseguimiento'];
                $fila['idsubperiodo']=$_POST['idsubperiodo'];

                $fila['codigoprocesovidaestudiante']=$_SESSION['sesioncodigoprocesovidaestudiante'];
                $objetobase->insertar_fila_bd($tabla,$fila);
                $datosinsercion=$objetobase->recuperar_datos_tabla($tabla,"codigoestado","100"," group by codigoestado",", max(idestudianteseguimiento) maxidestudianteseguimiento",0);

                //echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";
                echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=aspiranteseguimiento.php?codigoestudiante=".$_GET['codigoestudiante']."&idestudianteseguimiento=".$datosinsercion['maxidestudianteseguimiento']."'>";
                $formularioseguimiento->cambiar_valor_campo("observacionestudianteseguimiento","");
            }
        }

        if(isset($_REQUEST['Modificar'])) {
            if($formulario->valida_formulario()) {
                $tabla="estudianteseguimiento";
                echo $filaactualizar['fechadesdeestudianteseguimiento']=formato_fecha_mysql($_POST['fechadesdeestudianteseguimiento']);
                echo $filaactualizar['fechahastaestudianteseguimiento']=formato_fecha_mysql($_POST['fechahastaestudianteseguimiento']);
                //exit();
                $filaactualizar['observacionestudianteseguimiento']=$_POST['observacionestudianteseguimiento'];
                if(isset($usuario['idusuario']) and $usuario['idusuario']!="")
                    $filaactualizar['idusuario']=$usuario['idusuario'];
                else
                    $filaactualizar['idusuario']=4186;
                if(isset($_POST['idtipodetalleestudianteseguimiento'])&&(trim($_POST['idtipodetalleestudianteseguimiento'])!=''))
                    $filaactualizar['idtipodetalleestudianteseguimiento']=$_POST['idtipodetalleestudianteseguimiento'];
                else
                    $filaactualizar['idtipodetalleestudianteseguimiento']="1";

                $filaactualizar['codigotipoestudianteseguimiento']=$_POST['codigotipoestudianteseguimiento'];
                $nombreidtabla="idestudianteseguimiento";
                $idtabla=$_POST['idestudianteseguimiento'];
                //if($_POST['codigotipoestudianteseguimiento']!='')
                $objetobase->actualizar_fila_bd($tabla,$filaactualizar,$nombreidtabla,$idtabla);
                echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";
                $formularioseguimiento->cambiar_valor_campo("observacionestudianteseguimiento","");
            }
        }


        if(isset($_REQUEST['Anular'])&&(isset($_POST['idestudianteseguimiento'])&&($_POST['idestudianteseguimiento']!=''))) {
            $tabla="estudianteseguimiento";
            $filaanular['codigoestado']='200';
            $nombreidtabla="idestudianteseguimiento";
            $idtabla=$_POST['idestudianteseguimiento'];
            $objetobase->actualizar_fila_bd($tabla,$filaanular,$nombreidtabla,$idtabla,"",0);
            echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";
            $formularioseguimiento->cambiar_valor_campo("observacionestudianteseguimiento","");

        }

        ?>

    </table>
</form>


