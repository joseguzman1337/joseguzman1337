<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    unset($_SESSION['codigocarrerainfdetalle']);
    unset($_SESSION['codigocarrerainf']);
    unset($_SESSION['codigoperiodoinf']);
    unset($_SESSION['codigomodalidadacademicainf']);
?>
<script language="Javascript">
    function abrir(pagina,ventana,parametros) {
        window.open(pagina,ventana,parametros);
    }   
</script>
<script language="javascript">
    function enviar(event){
        document.form1.submit();  
    }

    function cambioCriterio(obj){
        var opcion=obj.options[obj.selectedIndex].value;
        var x=document.getElementById("criteriosituacion");
        switch(opcion){
            case '1':
                x.multiple=true;
            break;
            case '2':
                x.multiple=false;
            break;
        }
    }//cambioCriterio

    function enviofinal(opcion,cadenaget){
        var formulario=document.getElementById('form1');
        switch(opcion){
            case 1:
                formulario.action="estadisticas_matriculas.php";
            break;
            case 2:
                var x=document.getElementById("criteriosituacion");
                var valor=x.options[x.selectedIndex].value;
                cadenaget+='&criteriosituacion='+valor;
                formulario.action="../estadisticasSemestrales/principal.php?"+cadenaget;
                formulario.method="post";
            break;
            default:
                formulario.action="estadisticas_matriculas.php";
            break;
        }
        formulario.submit();
    }//enviofinal
</script>
<meta charset="UTF-8">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/normalize.css">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/font-page.css">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.css">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/general.css">
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<?php
    $fechahoy=date("Y-m-d H:i:s");
    $rutaado=("../../../funciones/adodb/");
    require_once('../../../Connections/salaado-pear.php');
    require_once("../../../funciones/validaciones/validaciongenerica.php");

    $mensajegeneral="Los campos marcados con *, no han sido correctamente diligenciados\n";
    $validaciongeneral=true;
    class carrera extends ADODB_Active_Record {}
    class periodo extends ADODB_Active_Record {}
    class modalidadacademica extends ADODB_Active_Record {}

    $modalidadacademica=new modalidadacademica('modalidadacademica');
    $row_modalidadacademica=$modalidadacademica->Find('codigoestado=100 order by nombremodalidadacademica asc');
    $carrera=new carrera('carrera');
    if(isset($_GET['codigomodalidadacademica']) && !empty($_GET['codigomodalidadacademica'])) {
        $row_carrera = $carrera->Find("codigomodalidadacademica='" . $_GET['codigomodalidadacademica'] .
        "' and fechainiciocarrera <= '" . $fechahoy . "' and fechavencimientocarrera >= '" .
        $fechahoy . "' order by nombrecarrera");
    }

    $periodo=new periodo('periodo');

    if(isset($_GET['ciclocontacto']) && !empty($_GET['ciclocontacto'])){
        if($_GET['ciclocontacto']==1){
            $_SESSION['ciclocontacto']=1;
        }
        if($_GET['ciclocontacto']==2){
            $_SESSION['ciclocontacto']=0;
        }
    }

    $row_periodo=$periodo->Find('codigoperiodo <> 1 order by codigoperiodo desc');

    $situacioncarreraestudiante[]='Interesados';
    $situacioncarreraestudiante[]='Aspirantes';
    $situacioncarreraestudiante[]='Inscritos';
    $situacioncarreraestudiante[]='Inscritos_No_Evaluados';
    $situacioncarreraestudiante[]='Entrevistas_Programadas';
    $situacioncarreraestudiante[]='Evaluados_No_Admitidos';
    $situacioncarreraestudiante[]='Admitidos_No_Matriculados';
    if(!isset($_SESSION['ciclocontacto']) && empty($_SESSION['ciclocontacto'])) {
        if (!$_SESSION['ciclocontacto'])
            $situacioncarreraestudiante[] = 'Admitidos_Que_No_Ingresaron';

        $situacioncarreraestudiante[] = 'Matriculados_Nuevos';

        if (!$_SESSION['ciclocontacto'])
            $situacioncarreraestudiante[] = 'Matriculados_Antiguos';

        if (!$_SESSION['ciclocontacto'])
            $situacioncarreraestudiante[] = 'Total_Matriculados';

        if (!$_SESSION['ciclocontacto'])
            $situacioncarreraestudiante[] = 'Prematriculados_Antiguos';

        if (!$_SESSION['ciclocontacto'])
            $situacioncarreraestudiante[] = 'Prematriculados_Nuevos';

        if (!$_SESSION['ciclocontacto'])
            $situacioncarreraestudiante[] = 'No_prematriculados';

        if (!$_SESSION['ciclocontacto'])
            $situacioncarreraestudiante[] = 'Estudiantes_en_Proceso_de_Financiacion';

        if (!$_SESSION['ciclocontacto'])
            $situacioncarreraestudiante[] = 'Desercion';
        $_SESSION['listadoestadoestudiantesesionestadisticas'] = $situacioncarreraestudiante;
    }
?>
<div class="container">
    <h2>ESTADISTICAS MATRICULAS <br> MENU PRINCIPAL </h2>
    <br>
    <form name="form1" id="form1" method="get" action="">
        <table class="table table-bordered" cellpadding="1" cellspacing="0" width="90%" bordercolor="#E9E9E9">
            <tr>
                <td width="14%" nowrap id="tdtitulogris">
                    <strong><label>Modalidad academica</label></strong>
                </td>
                <td>
                    <select name="codigomodalidadacademica" id="codigomodalidadacademica" onchange="enviar()">
                        <option value="">Seleccionar</option>
                        <option value="todos"<?php if($_GET['codigomodalidadacademica']=="todos"){echo "Selected";}?>>*Todos*</option>
                        <?php foreach ($row_modalidadacademica as $llave => $valor){?>
                        <option value="<?php echo $valor->codigomodalidadacademica;?>"<?php if($valor->codigomodalidadacademica==$_GET['codigomodalidadacademica']){echo "Selected";}?>><?php echo $valor->nombremodalidadacademica?>
                        </option>
                        <?php }?>
                    </select>
                    <?php
                    if(isset($_GET['codigomodalidadacademica']) && !empty($_GET['codigomodalidadacademica'])){
                        $validacion['codigomodalidadacademica']=validaciongenerica($_GET['codigomodalidadacademica'], "requerido", "Modalidad acad&eacute;mica");
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap id="tdtitulogris">
                    <strong><label>Programa</label></strong>
                </td>
                <td>
                    <select name="codigocarrera[]" id="codigocarrera" multiple='multiple'>
                        <option value="todos" <?php if($_GET['codigocarrera']=="todos"){echo "Selected";}?> > *Todos* </option>
                        <?php 
                        for($i=0;$i<count($row_carrera);$i++){
                            if(is_array($_GET['codigocarrera']))
                                if(in_array($row_carrera[$i]->codigocarrera,$_GET['codigocarrera']))
                                  $seleccionar=" selected";
                                else
                                  $seleccionar="";
                            echo "<option value='".$row_carrera[$i]->codigocarrera."' ".$seleccionar.">".$row_carrera[$i]->nombrecarrera."</option>";
                        }//for
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td nowrap id="tdtitulogris">
                    <strong><label>Periodo</label></strong>
                </td>
                <td>
                    <select name="codigoperiodo" id="codigoperiodo">
                        <option value="">Seleccionar</option>
                        <?php foreach ($row_periodo as $llave => $valor){?>
                        <option value="<?php echo $valor->codigoperiodo?>"<?php if($valor->codigoperiodo==$_GET['codigoperiodo']){echo "Selected";}?>><?php echo $valor->codigoperiodo?></option>
                        <?php }?>
                    </select>
                    <?php
                    if(isset($_GET['codigoperiodo']) && !empty($_GET['codigoperiodo'])) {
                        $validacion['codigoperiodo'] = validaciongenerica($_GET['codigoperiodo'], "requerido", "Periodo");
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap id="tdtitulogris">
                    <strong><label>Criterio</label></strong>
                </td>
                <td>
                    <select name="criterio" onchange="cambioCriterio(this);">
                        <option selected value="1">Estadísticas Generales</option>
                        <option value="2">Estadísticas matriculados x Semestre</option>
                    </select>
                </td>
            </tr>            
            <tr>
                <td nowrap id="tdtitulogris">
                    <strong><label>Estados </label></strong>
                </td>
                <td>
                    <select id="criteriosituacion" name="criteriosituacion[]" multiple='multiple'>
                        <option value="todos">TODOS</option>
                        <?php
                        for($i=0;$i<count($situacioncarreraestudiante);$i++)
                        {
                            if(is_array($_GET['criteriosituacion']))
                                if(in_array($situacioncarreraestudiante[$i],$_GET['criteriosituacion']))
                                    $seleccionar=" selected";
                                else
                                    $seleccionar="";
                            echo "<option value='".$situacioncarreraestudiante[$i]."' ".$seleccionar.">".str_replace("_"," ",$situacioncarreraestudiante[$i])."</option>";
                        }//for
                        ?>
                    </select>               
                </td>
            <tr>
                <td colspan="2">
                    <div align="justify">
                        Escoja los estados que prefiera en la estadistica con ayuda del click del mouse y las teclas (shift) o (ctrl). Para seleccionar todas no escoja ninguna opción o la opción TODOS.
                    </div>
                </td>    
            </tr>            
            <tr>
                <td colspan="3" nowrap>
                    <div align="center" class="verde">
                        <br>
                        <input class="btn btn-fill-green-XL" name="Enviar" type="submit" id="Enviar" value="Enviar">
                        <input class="btn btn-fill-green-XL" name="Restablecer" type="submit" id="Restablecer" value="Restablecer">
                    </div>
                </td>
            </tr>
        </table>
    </form>
</div>
    <?php if(isset($_GET['Restablecer'])){?>
        <script language="javascript">window.location.href="menu.php"</script>
    <?php } ?>
    <?php
    if(isset($_GET['Enviar'])){
        foreach ($validacion as $key => $valor){
            if($valor['valido']==0){
                $mensajegeneral=$mensajegeneral.'\n'.$valor['mensaje'];
                $validaciongeneral=false;
            }
        }
        if($validaciongeneral==true){
            /**
            * Si existe array de recarga, se podrá recargar de nuevo
            */
            $array_recarga[]=array('variable'=>'codigoperiodo','valor_variable'=>$_GET['codigoperiodo']);
            $array_recarga[]=array('variable'=>'codigomodalidadacademica','valor_variable'=>$_GET['codigomodalidadacademica']);
            $array_recarga[]=array('variable'=>'codigocarrera','valor_variable'=>$_GET['codigocarrera']);
            $array_recarga[]=array('variable'=>'criterio','valor_variable'=>$_GET['criterio']);
            $array_recarga[]=array('variable'=>'criteriosituacion','valor_variable'=>$_GET['criteriosituacion']);
            $_SESSION['archivo_ejecuta_recarga']='tabla_estadisticas_matriculas.php';

            echo "<script language='javascript'>
            enviofinal(".$_GET['criterio'].",'".'codigomodalidadacademica='.$_GET['codigomodalidadacademica'].'&codigocarrerainf='.
                $_GET['codigocarrera'][0].'&codigoperiodo='.$_GET['codigoperiodo']."')</script>";
        }
        else
        {
            echo "<script language='javascript'>alert('".$mensajegeneral."');</script>";
        }
    }
?>
