<?php
    require_once(realpath(dirname(__FILE__) . "/../../sala/includes/adaptador.php"));

    if($Configuration->getEntorno()=="local"||$Configuration->getEntorno()=="Preproduccion"){
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    session_start();
    $db = Factory::createDbo();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <html>
        <head>
            <title>Servicios Académicos</title>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <style type="text/css">
                <!--
                body {
                    margin-top: 0px;
                    margin-left: 0px;
                }
                .Estilo1 {
                    font-family: Verdana, Arial, Helvetica, sans-serif;
                    font-weight: bold;
                    font-size: 10px;
                }
                .Estilo2 {
                    font-family: Verdana, Arial, Helvetica, sans-serif;
                    font-size: 10px;
                }
                -->
            </style>
        </head>
        <?php
        //Rol 1 Estudiante
        //Rol 2
        //Rol 3
        if($_SESSION['rol']==1 || $_SESSION['rol']==2) {
	        if($_SESSION['rol']==1 && $_SESSION['MM_Username']!='padre'){
	            //consulta los datos del estudiante en situacion 400
		        $query_sitestudiante="select codigoestudiante from estudiante where codigoestudiante=".$_SESSION['codigo']."
		         and codigosituacioncarreraestudiante=400";
		        $sitestudiante=$db->GetRow($query_sitestudiante);

                if(!isset($sitestudiante['codigoestudiante']) && empty($sitestudiante['codigoestudiante'])){
		            $query_modalidad="select codigomodalidadacademica from estudiante e, carrera c where 
                    e.codigoestudiante=".$_SESSION['codigo']." and e.codigocarrera=c.codigocarrera";
                    $row_modalidad=$db->GetRow($query_modalidad);

                    if($row_modalidad['codigomodalidadacademica']=='200'){
                        $query_votacion="SELECT v.idvotacion, v.nombrevotacion, v.descripcionvotacion, 
                        v.fechainiciovotacion, v.fechafinalvotacion, v.fechainiciovigenciacargoaspiracionvotacion, 
                        fechafinalvigenciacargoaspiracionvotacion FROM
                        votacion v, plantillavotacion pv,estudiante e
                        WHERE
                        v.codigoestado=100
                        and e.codigoestudiante=".$_SESSION['codigo']."
                        and pv.idvotacion=v.idvotacion                        
                        and (pv.codigocarrera = e.codigocarrera OR pv.codigocarrera=".$_SESSION['idCarrera']." or pv.codigocarrera = 1) 
                        and v.idtipocandidatodetalleplantillavotacion=2
                        AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion
                        group by v.idvotacion";
                    } elseif($row_modalidad['codigomodalidadacademica']=='300'){
                        $query_votacion="SELECT v.idvotacion, v.nombrevotacion, v.descripcionvotacion, v.fechainiciovotacion, 
                        v.fechafinalvotacion, v.fechainiciovigenciacargoaspiracionvotacion, fechafinalvigenciacargoaspiracionvotacion 
                        FROM votacion v WHERE v.codigoestado=100 and v.idtipocandidatodetalleplantillavotacion=2
                        AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion ";
                    }
		        }else{
                    $query_modalidad="select * from estudiante e, carrera c where e.codigoestudiante=".$_SESSION['codigo']."
                    and e.codigocarrera=c.codigocarrera";
                    $row_modalidad=$db->GetRow($query_modalidad);

                    $query_votacion="SELECT v.idvotacion, v.nombrevotacion, v.descripcionvotacion, v.fechainiciovotacion, 
                    v.fechafinalvotacion, v.fechainiciovigenciacargoaspiracionvotacion, fechafinalvigenciacargoaspiracionvotacion 
                    FROM votacion v WHERE v.codigoestado=100 and v.idtipocandidatodetalleplantillavotacion=3 
                    AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion ";
                }
	        }elseif ($_SESSION['rol']==2){
                $query_votacion="SELECT v.idvotacion, v.nombrevotacion, v.descripcionvotacion, v.fechainiciovotacion, 
                v.fechafinalvotacion, v.fechainiciovigenciacargoaspiracionvotacion, fechafinalvigenciacargoaspiracionvotacion 
                FROM votacion v WHERE v.codigoestado=100 and v.idtipocandidatodetalleplantillavotacion=1
                AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion";
	        }
            if ($_SESSION['rol']==1 && $_SESSION['MM_Username']!='padre'){
                $row_operacion_votacion=$db->GetRow($query_votacion);

                if(isset($row_operacion_votacion['idvotacion']) && !empty($row_operacion_votacion['idvotacion'])){
                    $idvotacion=$row_operacion_votacion['idvotacion'];
                    $_SESSION['datosvotante']['idvotacion']=$row_operacion_votacion['idvotacion'];
                }else{
                    $idvotacion = "";
                    $_SESSION['datosvotante']['idvotacion'] = "";
                }

            }elseif ($_SESSION['rol']==2){
		        $operacion_votacion=$db->GetRow($query_votacion);
                $row_operacion_votacion=$operacion_votacion->fetchRow();

		        if($row_operacion_votacion['idvotacion'] > 0){
                    $query_sitdocente="select numerodocumento, codigocarrera from docentesvoto where numerodocumento=".$_SESSION['codigodocente']."";
                    $row_operacion=$db->GetRow($query_sitdocente);

		            if(!isset($row_operacion['numerodocumento']) && empty($row_operacion['numerodocumento'])){
		                echo '<script language="JavaScript">alert("No tiene una Facultad asociada para la jornada de Votación, por favor acérquese a la Dirección de Tecnología")</script>';
		            } else{
		                $idvotacion=$row_operacion_votacion['idvotacion'];
		            }
                }
            }

	        if(!empty($idvotacion)){
	    ?>
        <link rel="stylesheet" href="../js/jquery.countdown/jquery.countdown.css">
        <style>
            .is-countdown{
            background-color: #fff;
            border:0;
            display:inline;
        }
        .countdown-row{
            display: inline;
        }
        .countdown-amount{
            font-size:1em;
            font-weight:normal;
        }
        </style>
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery.countdown/jquery.plugin.js"></script>
        <script src="../js/jquery.countdown/jquery.countdown.js"></script>
        <script src="../js/jquery.countdown/jquery.countdown-es.js"></script>
	    <script language="javascript">
            $(function () {
                var austDay = new Date("<?php echo date('M j, Y H:i:s O', strtotime($row_operacion_votacion['fechafinalvotacion'])); ?>");
                //austDay = new Date(austDay.getFullYear() + 1, 1 - 1, 26);
                $('#timer').countdown($.extend({until: austDay, serverSync: serverTime, description: 'para que finalice la votación.',
                padZeroes: false, compact: true, layout:'{d<}{dn} días, {d>}'+ '{hn} horas, {mn} minutos y {sn} segundos {desc}',
                onExpiry: acaboVotacion
                },$.countdown.regionalOptions['es']));
            });
    
            function serverTime() {
                var time = null;
                $.ajax({url: 'serverTime.php',
                    async: false, dataType: 'text',
                    success: function(text) {
                    time = new Date(text);
                }, error: function(http, message, exc) {
                time = new Date(); 
                }});
                return time;
            }

            function acaboVotacion() {
                $("table#votacion").html("<td style='font-size:16px;font-weight:bold;'>Ha finalizado la jornada de votación.</td>");
            }
        </script>
	    <?php
        $_SESSION['fecha_final']=$row_operacion_votacion['fechafinalvotacion'];
        if($_SESSION['rol']==1 && $_SESSION['MM_Username']!='padre'){
            if(!isset($sitestudiante['codigoestudiante']) && empty($sitestudiante['codigoestudiante'])){
                $tipovotante='estudiante';
            }else{
                $tipovotante='egresado';
            }
		    $query_numerodocumento="SELECT eg.numerodocumento, e.codigocarrera
		    FROM estudiante e, estudiantegeneral eg
		    WHERE e.idestudiantegeneral=eg.idestudiantegeneral
		    AND e.codigoestudiante='".$_SESSION['codigo']."'";
            $row_operacion=$db->GetRow($query_numerodocumento);
		    $numerodocumento=$row_operacion['numerodocumento'];
	    }elseif ($_SESSION['rol']==2){
		    $tipovotante='docente';
		    $numerodocumento=$_SESSION['codigodocente'];
	    }

	    $codigocarrera=$row_operacion['codigocarrera'];
	    $modalidadacademica=$row_modalidad['codigomodalidadacademica'];

	    if(!empty($numerodocumento)){
		    $query_votacion_vigente="SELECT COUNT(vv.numerodocumentovotantesvotacion) as votos FROM
		    votacion v, votantesvotacion vv WHERE v.codigoestado='100'
		    AND vv.codigoestado='100'
		    AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion
		    AND v.idvotacion=vv.idvotacion
		    and v.idvotacion='".$idvotacion."'
		    AND vv.numerodocumentovotantesvotacion='$numerodocumento'";
            $row_operacion_votacion_vigente=$db->GetRow($query_votacion_vigente);
            $cantVotos=$row_operacion_votacion_vigente['votos'];
            if($cantVotos==0){
                $_SESSION['datosvotante']=array('codigoestudiante'=>$_SESSION['codigo'],'numerodocumento'=>$numerodocumento,'codigocarrera'=>$codigocarrera,'tipovotante'=>$tipovotante,'cantVotos'=>$cantVotos,'idvotacion'=>$idvotacion,'modalidadacademica'=>$modalidadacademica);
            }
	    }
	}
        }

        if($_SESSION['rol']=='2'){
            $esdocente=true;
        }
?>
<body>
    <?php
    if(!empty($idvotacion)){
        ?>
        <p>
            <br>
            <span class="Estilo1"><?php echo $row_operacion_votacion['descripcionvotacion']?>
            <br>
            Periodo (<?php list($ano,$mes,$fecha)=explode("-",$row_operacion_votacion['fechainiciovigenciacargoaspiracionvotacion']);echo $ano?> a <?php echo ($ano+1);?>) </span>
            <br>
            <ul>
                <li>El plazo para votar va comprendido entre <?php list($fecha_ini,$hora_ini)=explode(" ",$row_operacion_votacion['fechainiciovotacion']);echo $fecha_ini?> a las <?php echo $hora_ini?> y <?php list($fecha_fin,$hora_fin)=explode(" ",$row_operacion_votacion['fechafinalvotacion']); echo $fecha_fin;?> a las <?php echo $hora_fin?></li>
                <li>Quedan <div id="timer"></div></li>
            </ul>
        </p>
        <table width="500" border="0" id="votacion">
            <tr><?php if($cantVotos==0){?>
                <td width="154">
                    <div align="right">
                        <br><br><br><br><br><br><br>
                        <a href="../votaciones/datosVotacion.php"><img src="vote.jpg" width="110" height="78"></a>
                </td>
                <td width="330">
                    <div align="center" id="bienvenida">
                        <a href="../votaciones/datosVotacion.php">
                            <img src="urna.gif" width="200" height="211"></a>
                    </div>
                </td>
                <?php
                }else{
                    echo "<td style='font-size:16px;font-weight:bold;'>Usted ya votó. Gracias por su voto.</td>";
                }?>
            </tr>
        </table>
        <br/>
    <?php
    }
    if(!empty($esdocente)){
        ?>
        <div id="bienvenidaTEXTO" style="width:630px; z-index:2; left: 29px; top: 30px; text-align:justify;" >
            <a href="https://docs.google.com/a/unbosque.edu.co/forms/d/15KoXdF-UCkitqAzEH5CktTllUhWP2AzcIKKYx8fchtk/viewform" target="_blank">
                <img src="evaluacionasignaturas2014.jpg" ></a>
            </td>
            <br>
        </div>
        <?php
    }
    if(isset($idvotacion) && empty($idvotacion)){
        ?>
        <div id="bienvenidaTEXTO" style="width:630px; z-index:2; left: 29px; top: 30px; text-align:justify;" >
            <p>No existen plantillas de votacion creadas para su facultad o programa</p>
            <br>
        </div>
        <?php
    }
    ?>
</body>
</html>

