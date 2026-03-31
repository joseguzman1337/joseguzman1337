<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

require_once(realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));
session_start();

?>
<?php
$usuario = $_SESSION['MM_Username'];
$periodoactual = $_SESSION['codigoperiodosesion'];

$query_tipousuario = "SELECT * from usuariofacultad where usuario = '".$usuario."'";
$row_tipousuario = $db->GetRow($query_tipousuario);

if (isset($_GET['codigocreado'])){
    $codigoestudiante = $_GET['codigocreado'];
}
else {
    if (isset($_SESSION['codigo'])) {
        $codigoestudiante = $_SESSION['codigo'];
    }
}
$znumerodocumento = $codigoestudiante;

$query_dataestudiante = "SELECT distinct eg.apellidosestudiantegeneral, eg.nombresestudiantegeneral, d.nombredocumento,".
"d.tipodocumento,eg.numerodocumento, eg.fechanacimientoestudiantegeneral,eg.expedidodocumento, ".
" eg.idestudiantegeneral, gr.nombregenero, eg.celularestudiantegeneral, eg.emailestudiantegeneral, ".
" eg.codigogenero, eg.direccionresidenciaestudiantegeneral, eg.telefonoresidenciaestudiantegeneral, ".
" eg.ciudadresidenciaestudiantegeneral, eg.direccioncorrespondenciaestudiantegeneral, ".
" eg.telefonocorrespondenciaestudiantegeneral, eg.ciudadcorrespondenciaestudiantegeneral ".
" FROM estudiantegeneral eg ".
" inner join documento d on eg.tipodocumento = d.tipodocumento ".
" inner join estudiantedocumento ed  on d.tipodocumento = ed.tipodocumento and ed.idestudiantegeneral = eg.idestudiantegeneral ".
" inner join genero gr on eg.codigogenero = gr.codigogenero ".
" WHERE ed.numerodocumento = '$codigoestudiante' and ed.fechavencimientoestudiantedocumento > now()";
$row_dataestudiante = $db->GetRow($query_dataestudiante);

if(isset($row_dataestudiante['idestudiantegeneral']) && !empty($row_dataestudiante['idestudiantegeneral'])){
    if ($_SESSION['rol'] == 1 ){
        if (!isset($_REQUEST['decidir'])){
            if (isset($_REQUEST['IngresoEmpleosi'])){
                $query_guardar = "INSERT INTO estudianteelempleo (idestudianteelempleo, idestudiantegeneral, ".
                " confimacionestudianteelempleo, fechaestudiantelempleo, codigoestado) values (0, ".
                "'{$row_dataestudiante['idestudiantegeneral']}', 'SI', now(), 100)";
                $guardar = $db->Execute($query_guardar);
                echo '<script language="JavaScript">alert("Se ha autorizado el envio de información a elempleo.com")</script>';
            }
            else if (isset($_REQUEST['IngresoEmpleono'])){
                $query_guardar = "INSERT INTO estudianteelempleo (idestudianteelempleo, idestudiantegeneral, ".
                " confimacionestudianteelempleo, fechaestudiantelempleo, codigoestado) values (0, ".
                "'{$row_dataestudiante['idestudiantegeneral']}', 'NO', now(), 100)";
                $guardar =$db->Execute($query_guardar);
            }

            $query_elempleo = "SELECT idestudianteelempleo, idestudiantegeneral FROM estudianteelempleo  ".
            " where idestudiantegeneral = '".$row_dataestudiante['idestudiantegeneral']."' and codigoestado like '1%' ";
            $row_elempleo = $db->GetRow($query_elempleo);

            if (!isset($row_elempleo['idestudianteelempleo']) || empty($row_elempleo['idestudianteelempleo'])){
                $query_egresado = "SELECT e.idestudiantegeneral, e.codigosituacioncarreraestudiante ".
                " FROM estudiante e, carrera c, modalidadacademica m ".
                " where e.codigosituacioncarreraestudiante = '104' ".
                " and e.idestudiantegeneral = '".$row_dataestudiante['idestudiantegeneral']."' ".
                " and e.codigocarrera=c.codigocarrera ".
                " and c.codigomodalidadacademica = m.codigomodalidadacademica ".
                " and m.codigomodalidadacademica like '2%'";
                $row_egresado = $db->GetRow($query_egresado);

                if (isset($row_egresado['idestudiantegeneral']) && !empty($row_egresado['idestudiantegeneral'])) {
                    require_once('../../estudianteelempleo/ingresoalempleo.php');
                }
                else {
                    $query_estadoestudiante = "SELECT e.idestudiantegeneral, e.semestre, c.codigocarrera, ".
                    " m.codigomodalidadacademica from estudiante e, planestudio p, planestudioestudiante pe,  ".
                    " estudiantegeneral eg, carrera c, modalidadacademica m ".
                    " where e.idestudiantegeneral=eg.idestudiantegeneral ".
                    " and e.codigoestudiante=pe.codigoestudiante ".
                    " and e.codigocarrera=c.codigocarrera ".
                    " and c.codigomodalidadacademica=m.codigomodalidadacademica ".
                    " and m.codigomodalidadacademica like '2%' ".
                    " and pe.idplanestudio=p.idplanestudio ".
                    " and e.idestudiantegeneral = '".$row_dataestudiante['idestudiantegeneral']."' ".
                    " and e.semestre = p.cantidadsemestresplanestudio ".
                    " and (e.codigosituacioncarreraestudiante like '3%'  or e.codigosituacioncarreraestudiante like '2%')";
                    $row_estadoestudiante = $db->GetAll($query_estadoestudiante);
                    $totalRows_estadoestudiante = count($row_estadoestudiante);

                    if ($totalRows_estadoestudiante != 0) {
                        require_once('../../estudianteelempleo/ingresoalempleo.php');
                    }
                }
            }
        }
    }
    $idestudiante = $row_dataestudiante['idestudiantegeneral'];
    $query_carreras = "SELECT codigocarrera, nombrecarrera FROM carrera ".
    " where codigocarrera = '".$_SESSION['codigofacultad']."' order by 2 asc";
    $row_carreras = $db->GetAll($query_carreras);
    $totalRows_carreras = count($row_carreras);

    $query_carreras = "SELECT distinct c.nombrecarrera, c.codigocarrera, e.codigoestudiante, e.codigoperiodo, ".
    " s.nombresituacioncarreraestudiante, e.codigocarrera ".
    " FROM estudiante e ".
    " inner join carrera c on e.codigocarrera = c.codigocarrera ".
    " inner join situacioncarreraestudiante s on e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante ".
    " WHERE e.idestudiantegeneral = '".$row_dataestudiante['idestudiantegeneral']."' order by e.codigoperiodo desc";
    $carreras = $db->GetAll($query_carreras);

    ///****************** && !isset($_POST['codigocreado'])
    if(preg_match("/^estudiante/",$_SESSION['MM_Username']) && !isset($_GET['sinestadocuenta']) ){
    $ruta = '../../../';
    $link = $ruta."../imagenes/estudiantes/";
    require_once($ruta.'funciones/datosestudiante.php');
    require_once('../../../funciones/sala/estadocuenta/estadocuenta.php');

    $codigoestudiante = $row_dataestudiante['codigoestudiante'];

    $estadocuenta = new estadocuenta($codigoestudiante);
    if($estadocuenta->codigoestudiante == '')
        $estadocuenta->estadocuenta($codigoestudiante);
    if(isset($_POST['continuar']))
    {
        if(!isset($_POST['respuesta']))
        {
            ?>
            <script language="javascript">
                alert("Debe seleccionar Si o No a la pregunta para poder continuar");
            </script>
            <?php
        }
        else
        {
            $guardar = true;
            $observacion = '';
            if($_POST['respuesta'] == 0){
                // Se valida que sean solo letras
                $observacion = trim($_POST['observacion']);
                if($observacion == ''){
                    $guardar = false;
                    ?>
                    <script language="javascript">
                        alert("Debe escribir la razón por la que no se encuentra de acuerdo con su estado de cuenta o su plan de pago");
                    </script>
                    <?php
                }
                $observacion = htmlspecialchars($observacion);
            }
            // Inserta en la base de datos de estudianteestadocuenta.
            if($guardar){
                $estadocuenta->guardarEstudianteestadocuenta($_POST['respuesta'], $observacion, $_POST['acumuladocontra'], $_POST['acumuladofavor']);
            }
        }
    }

    if(!$estadocuenta->tieneEstadocuentaactiva()){
        require("../../estadocredito/estado_cuenta_nuevo.php");
        exit();
    }
}
?>
<html lang="es">
    <head>
        <title>Crear Estudiante</title>
        <script src="../../../../assets/js/jquery-3.6.0.js"></script>
        <script src="<?php echo HTTP_SITE; ?>/assets/js/bootstrap.min.js"></script>
        <link href="<?php echo HTTP_SITE; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
        <!--  Space loading indicator  -->
        <script src="<?php echo HTTP_SITE; ?>/assets/js/spiceLoading/pace.min.js"></script>
        <!--  loading cornerIndicator  -->
        <link href="<?php echo HTTP_SITE; ?>/assets/css/cornerIndicator/cornerIndicator.css" rel="stylesheet">
        <script src="<?php echo HTTP_ROOT; ?>/sala/assets/js/jquery.dataTables.min.js" rel="stylesheet"></script>

         <link rel="stylesheet" href="<?php echo HTTP_ROOT; ?>/sala/assets/css/jquery.dataTables.min.css" type="text/css">
         <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
    </head>
    <body>
        <div class="col-md-12" align="center">
            <form name="form1" method="post" action="editarestudiante.php?codigocreado=<?php echo $codigoestudiante;?>&usuarioeditar=<?php echo $usuarioeditar;?>">
                <table class="table table-bordered" style="width: 90%;font-size: 13px">
                    <tr id="trtituloNaranjaInst" class="text-center">
                        <td colspan="4">
                            DATOS ESTUDIANTE
                        </td>
                    </tr>
                    <tr>
                        <td class="tdtituloWhiteInst"><b >Apellidos</b></td>
                        <td class="Estilo1">
                            <div align="center"><?php if(isset($_POST['apellidos'])) echo $_POST['apellidos']; else echo $row_dataestudiante['apellidosestudiantegeneral'];?></div>
                        </td>
                        <td class="tdtituloWhiteInst"><b align="center">Nombres</b></td>
                        <td class="Estilo1"><div align="center"><?php if(isset($_POST['nombres'])) echo $_POST['nombres']; else echo $row_dataestudiante['nombresestudiantegeneral'];?></div></td>
                    </tr>
                    <tr>
                        <td class="tdtituloWhiteInst"><b align="center">Tipo de Documento</b></td>
                        <td class="Estilo1"><div align="center"><?php echo $row_dataestudiante['nombredocumento']?></div></td>
                        <td colspan="1" class="tdtituloWhiteInst"><b align="center">N&uacute;mero</b></td>
                        <td colspan="1" class="Estilo1"><div align="center"><?php if(isset($_POST['documento'])) echo $_POST['documento']; else echo $row_dataestudiante['numerodocumento'];?></div></td>
                    </tr>
                    <tr>
                        <td class="tdtituloWhiteInst"><b>Expedido en</b></td>
                        <td class="Estilo1"><div align="center"><?php if(isset($_POST['expedido'])) echo $_POST['expedido']; else echo $row_dataestudiante['expedidodocumento'];?></div></td>
                        <td class="tdtituloWhiteInst"><b>Fecha de Nacimiento</b></td>
                        <td class="Estilo1"><div align="center">
                            <?php
                            $date = explode(' ', $row_dataestudiante['fechanacimientoestudiantegeneral']);
                            echo $date[0];?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="tdtituloWhiteInst"><b align="center">G&eacute;nero</b></td>
                        <td class="Estilo1"><div align="center"><?php echo $row_dataestudiante['nombregenero'];?></div></td>
                        <td class="tdtituloWhiteInst"><b>Id</td>
                        <td class="Estilo1" ><div align="center"><?php echo $row_dataestudiante['idestudiantegeneral']; ?></div></td>
                    </tr>
                    <tr>
                        <td class="tdtituloWhiteInst"><b>Celular</b></td>
                        <td class="Estilo1"><div align="center"><?php if(isset($_POST['celular'])) echo $_POST['celular']; else echo $row_dataestudiante['celularestudiantegeneral'];?></div></td>
                        <td class="tdtituloWhiteInst"><b>E-mail</b></td>
                        <td class="Estilo1" ><div align="center">
                                <?php if(isset($_POST['email'])) echo $_POST['email']; else echo $row_dataestudiante['emailestudiantegeneral'];?>
                            </div></td>
                    </tr>
                    <tr>
                        <td class="tdtituloWhiteInst"><b>Dir. Estudiante</b></td>
                        <td class="Estilo1"><div align="center"><?php if(isset($_POST['direccion1'])) echo $_POST['direccion1']; else echo $row_dataestudiante['direccionresidenciaestudiantegeneral'];?></div></td>
                        <td class="tdtituloWhiteInst"><b>Tel&eacute;fono</b></td>
                        <td class="Estilo1"><div align="center"><?php if(isset($_POST['telefono1'])) echo $_POST['telefono1']; else echo $row_dataestudiante['telefonoresidenciaestudiantegeneral'];?></div></td>
                    </tr>
                    <tr>
                        <td class="tdtituloWhiteInst"><b>Dir. Correspondencia</b></td>
                        <td class="Estilo1"><div align="center"><?php if(isset($_POST['direccion2'])) echo $_POST['direccion2']; else echo $row_dataestudiante['direccioncorrespondenciaestudiantegeneral'];?></div></td>
                        <td class="tdtituloWhiteInst"><b>Tel&eacute;fono</b></td>
                        <td class="Estilo1"><div align="center"><?php if(isset($_POST['telefono2'])) echo $_POST['telefono2']; else echo $row_dataestudiante['telefonocorrespondenciaestudiantegeneral'];?></div></td>
                    </tr>
                    <tr>
                        <?php
                        $query_usuario = "select u.usuario from usuario u, estudiantedocumento ed ".
                        " where ed.numerodocumento = '".$row_dataestudiante['numerodocumento']."' ".
                        " and ed.numerodocumento = u.numerodocumento ".
                        " and u.codigotipousuario='600' and u.codigoestadousuario=100 limit 1";
                        $row_usuario = $db->GetRow($query_usuario);
                        ?>
                        <td class="tdtituloWhiteInst"><b>Usuario</b></td>
                        <td class="Estilo1"  colspan="3"><div align="center" style="font-size: 15px"><b>
                            <?php echo (!isset($row_usuario['usuario']) || empty($row_usuario['usuario']))?'Usuario no asignado':$row_usuario['usuario'];?></b>
                            </div>
                        </td>
                    </tr>
                </table>
                <script language="javascript">
        function hRefCentral(url){
            var browser = navigator.appName;
            if(browser == 'Microsoft Internet Explorer'){
                parent.contenidocentral.location.href(url);
            }
            else{
                parent.contenidocentral.location=url;
            }
            return true;
        }

        function hRefIzq(url){
            var browser = navigator.appName;
            if(browser == 'Microsoft Internet Explorer'){
                parent.leftFrame.location.href(url);
            }
            else{
                parent.leftFrame.location=url;
            }
            return true;
        }
        function VerMensaje(codigo,codperiodo){
            if(confirm('Desea Ver El Listado General Estudiante...?')){
                var Consultar = 0;
            }else{
                var Consultar = 1;
            }
            location.href='../../mensajesestudianteaviso.php?codigo='+codigo+'&codperiodo='+codperiodo+'&Consultar='+Consultar;
        }//function VerMensaje

        $(document).ready(function() {
            $('#carrerasEstudiantes').DataTable(
                {
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                    },
                    "paging":   false,
                    "info":     false,
                    "searching":     false,

                }
            );
        } );
    </script>
                <table style="width: 90%;font-size: 13px" class="table table-bordered" id="carrerasEstudiantes">
                    <thead>
                    <tr id="trtituloNaranjaInst" >
                        <td colspan="5" class="text-center">
                            CARRERA(S)  ESTUDIANTE
                        </td>
                    </tr>
                    <tr class="tdtituloWhiteInst">
                        <td class="text-center">Id</td>
                        <td class="text-center">Nombre Carrera</td>
                        <td class="text-center">C&oacute;digo Carrera</td>
                        <td class="text-center">Situaci&oacute;n Carrera</td>
                        <td class="text-center">Periodo Ingreso</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($carreras as $rowcarreras){
                        ?>
                        <tr class="">
                            <td><div align="center"><?php echo $rowcarreras['codigoestudiante'];?></div></td>
                            <td align="center">
                                <?php
                                if ($_SESSION['rol'] == 1){
                                    // Esto lo hace cuando el rol es estudiante
                                    // Para cada carrera selecciona el código del estudiante y el periodo, pasandolo a mensajesestudianteaviso.php
                                    // Primero intenta seleccionar precierre si no hay selecciona el activo
                                    $query_selperiodo = "select p.codigoperiodo, p.codigoestadoperiodo ".
                                    " from periodo p, carreraperiodo cp where p.codigoestadoperiodo = '1' ".
                                    " and cp.codigocarrera = '".$rowcarreras['codigocarrera']."' ".
                                    " and p.codigoperiodo = cp.codigoperiodo";
                                    $row_selperiodo = $db->GetRow($query_selperiodo);
                                    $totalRows_selperiodo=count($row_selperiodo);
                                    if($totalRows_selperiodo == "0"){
                                        $query_selperiodo = "select p.codigoperiodo, p.codigoestadoperiodo ".
                                        " from periodo p, carreraperiodo cp where p.codigoestadoperiodo = '1' ".
                                        " and cp.codigocarrera = '".$rowcarreras['codigocarrera']."' ".
                                        " and p.codigoperiodo = cp.codigoperiodo";
                                        $row_selperiodo = $db->GetRow($query_selperiodo);
                                        $totalRows_selperiodo=count($row_selperiodo);
                                    }
                                    ?>
                                    <a onclick="VerMensaje('<?php echo $rowcarreras['codigoestudiante']?>',
                                    '<?PHP echo $row_selperiodo['codigoperiodo']?>')" style="cursor: pointer; color: blue;" ><u>
                                    <?php echo $rowcarreras['nombrecarrera']; ?></u></a>
                                    <?php
                                }
                                else {
                                    if ($rowcarreras['codigocarrera'] == $_SESSION['codigofacultad']
                                        or $row_tipousuario['codigotipousuariofacultad'] == 200
                                        or $usuario == "admintecnologia"
                                        or $usuario == "dirsecgeneral") {
                                        ?>
                                        <a href="../../prematricula/loginpru.php?codigocarrera=<?php
                                        echo $rowcarreras['codigocarrera']; ?>&estudiante=<?php
                                        echo $rowcarreras['codigoestudiante']; ?>">
                                            <?php echo $rowcarreras['nombrecarrera']; ?></a>
                                        <?php
                                    } else {
                                        echo $rowcarreras['nombrecarrera'];
                                    }
                                }
                                ?>
                            </td>
                            <td><div align="center">
                                <?php echo $rowcarreras['codigocarrera']; ?>
                                </div></td>
                            <td><div align="center"><?php echo $rowcarreras['nombresituacioncarreraestudiante'];?></div></td>
                            <td><div align="center"><?php echo $rowcarreras['codigoperiodo'];?></div></td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            <?php
    }
    ?>
</div>