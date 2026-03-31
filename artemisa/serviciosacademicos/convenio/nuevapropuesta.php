<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php');
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    include_once (realpath(dirname(__FILE__)).'/../EspacioFisico/templates/template.php');
    require_once(realpath(dirname(__FILE__))."/../modelos/convenios/SolicitudConvenios.php");

    if(!$db){
    	$db = getBD();
    }
    $sqlS = "select idusuario from usuario where usuario = '" . $_SESSION['MM_Username'] . "'";
    $datosusuario = $db->GetRow($sqlS);
    $usuario = $datosusuario['idusuario'];

    $codigoFacultad = $_SESSION['codigofacultad'];
    if(!isset ($codigoFacultad))
    {
        echo "<script>alert('Error de ingreso a la facultad'); location.href='MenuConvenios.php'; </script>";
    }

    $tipofacultad = "SELECT count(*) as id from carrera where EsAdministrativa = '1'  and codigocarrera = '".$codigoFacultad."'";
    $facultad = $db->GetRow($tipofacultad);

    if($facultad['id']!= '0')
    {
        $validar_facultad= true;
    }

    $edit=false;
    $action = "SaveData";
    if(isset($_REQUEST["id"])){
        $solicitud = new solicitudConvenio();
        $solicitud->load("SolicitudConvenioId=?", array($_REQUEST["id"]));
        $edit = true;
        $action = "UpdateData";

        $db->SetFetchMode(ADODB_FETCH_NUM);
        $sqlS = "select codigocarrera from SolicitudConvenioCarrera where CodigoEstado=100 AND SolicitudConvenioId = ? ";
        $stmt = $db->Prepare($sqlS);
        $carrerasS = $db->GetAll($stmt,array($_REQUEST["id"]));
        $db->SetFetchMode(ADODB_FETCH_ASSOC);
    }
?>
<html>
    <head>
        <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" />
        <link rel="stylesheet" href="../mgi/css/styleMonitoreo.css" type="text/css" />
        <link rel="stylesheet" href="../mgi/css/styleDatos.css" type="text/css" />
        <link rel="stylesheet" href="cssEmail/style.css" type="text/css" />
        <link rel="stylesheet" href="uploadify/uploadify.css" type="text/css" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Nueva Solicitud</title>

        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript" language="javascript" src="js/funcionesPropuestas.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/functions.js"></script>

        <script>
            function Regresar()
            {
                location.href = "../convenio/Propuestaconvenio.php";
            }
        </script>
		<script>
        function val_texto(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==8) return true;
            patron = /[a-zA-ZñÑ\s]+$/;
            te = String.fromCharCode(tecla);
            return patron.test(te);
        }
         function val_numero(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==8) return true;
            patron =/[0-9-]+$/;
            te = String.fromCharCode(tecla);
            return patron.test(te);
        }
        </script>
         <script>
        function val_email(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==8) return true;
            patron = /[0-9a-zA-Z\-\.\@\s]+$/;
            te = String.fromCharCode(tecla);
            return patron.test(te);
        }
        </script>
  <style>
			table{
				width:80%;
				align:"center";
			}

			#container{
				margin-top:10px;
			}
			.titulo{
				font-size:16px;
				font-weight:bold;
				background-color:#CCC;
			}
			.tablagris tr td:first-child{
				background-color:#DDD;
                width: 420px;
			}
			input{
				width:90%;
			}
			textarea{
				width:95%;
			}
			.boton{
				width:100px;
			}
		</style>
    </head>
    <body>
  		<div align="center" id="container">
            <div id="observacion">
                <?php
                if($edit)
                {
                    ?>
                   <div style="overflow-y: scroll; width: 900px; height: 200px;">
                    <table><tr>
                    <td colspan="2"><center><strong>Observaciones</strong></center>
                   </td>
                   </tr>
                    <?php
                    $sqlobservaciones = "SELECT o.ObservacionSolicitudId, o.Observacion, o.FechaCreacion, u.usuario FROM ObservacionSolicitudes o INNER JOIN usuario u ON u.idusuario = o.Usuario WHERE o.SolicitudConvenioId = '".$_REQUEST['id']."' AND o.codigoestado = '100' order by ObservacionSolicitudId DESC";
                    $observaciones = $db->GetAll($sqlobservaciones);
                    foreach($observaciones as $listaobservacion)
                    {
                    ?>
                        <tr>
                            <td><li><?php echo $listaobservacion['Observacion']?></li></td>
                            <td><?php echo $listaobservacion['usuario']." - ".$listaobservacion['FechaCreacion']?></td>
                        </tr>
                    <?php
                    }
                    ?></table>
                    </div>
                    <?php
                }
                ?>

            </div>

			<form id="propuesta" name="propuesta" method="post" enctype="multipart/form-data" action="procesarSolicitudConvenio.php">
	    		<input type="hidden" id="Action_id" name="Action_id" value="<?php echo $action; ?>" />
	    		<input type="hidden" id="paso" name="paso" value="1" />
				<?php if($edit){ ?>
	    		<input type="hidden" id="SolicitudConvenioId" name="SolicitudConvenioId" value="<?php echo $_REQUEST['id']; ?>" />
				<?php } ?>
			<table class="tablagris">
				<tr>
					<td colspan="2" class="titulo" align="center">Información de Unidad Académica Solicitante de Convenio</td>
				</tr>
				<tr>
					<td>Fecha de Solicitud:
					<td><?php if($edit && $solicitud->fechaenviosolicitud!=null){ date('Y-m-d',strtotime($solicitud->fechaenviosolicitud)); } else { echo date('Y-m-d'); } ?></td>
				</tr>
				<tr>
					<td>Programa Académico <span style="color: red;">*</span></td>
					<td>
					    <?php
					    $sqlCarrera = "SELECT u.codigofacultad, c.nombrecarrera, c.codigocarrera
							FROM usuariofacultad u, carrera c, usuario us
							WHERE us.usuario = u.usuario AND us.usuario = '".$_SESSION['MM_Username']."'
							AND u.codigofacultad = c.codigocarrera AND u.codigoestado LIKE '1%' ORDER BY c.nombrecarrera";
					    $carreras = $db->GetAll($sqlCarrera);
                        $t='0';
                        foreach ($carreras as $carrera) {
							$check = "";
							if($edit){
								foreach($carrerasS as $c){
									if($c[0]==$carrera["codigocarrera"]){
										$check = "checked";
										break;
									}
								}
							}

							echo "<input id='codigoCarrera".$t."' name='carrera[]' type='checkbox' value='".$carrera['codigocarrera']."'
							style='width: auto;' class='required' ".$check.">".$carrera['nombrecarrera']."<br>";
                            $t++;
					    }
					    ?>
                    </td>
				</tr>
                <tr>
                    <td>Otras facultades (Diligenciar este campo si aplica para mas programas y/o facultades)</td>
                    <td><textarea name="OtrasFacultades"></textarea></td>
                </tr>
				<tr>
					<td>Acta Consejo Facultad: (PDF)<?php if(!$validar_facultad){echo "<span style='color: red;'>*</span> "; $class = "class='required'";}?></td>
					<td>
                    <?php
                        $sqlarchivo = "select SolicitudAnexoId, Nombre, Url from SolicitudAnexos where SolicitudConvenioId = '".$_REQUEST["id"]."' and TipoAnexoId = '8'";
                        //echo $sqlarchivo;
                        $archivo =  $db->GetRow($sqlarchivo);
                        if($archivo['SolicitudAnexoId'])
                        {
                        ?>
                            <input type="text" name="archivo" id="archivo" readonly="true" value="<?php echo $archivo['Nombre']; ?>" style="width: 50%;" />
                            <a href="<?php echo $archivo['Url'];?>" target="_blank"><img src='../mgi/images/file_document.png' width='50' height='37'  border="0" alt="" /></a>
                        <?php
                        }

                        if($validar_facultad)
                        {
                            ?>
                            <input type="hidden" id="Validar_facultad" name="Validar_facultad" value="1" />
                            <?php
                        }
                        ?>
                            <input name="archivo" type="file" id="archivo" <?php echo $class;?> accept=".pdf"/>
					</td>
				</tr>
				<tr>
					<td>N°Acta Consejo de Facultad donde se aprobó solicitud de Gestión de Convenio <span style="color: red;">*</span></td>
					<td><input type="text" name="nconsejo" id="nconsejo" size="50%" class="required" value="<?php if($edit){ echo $solicitud->numeroacta;} ?>"
                    onkeypress="return val_numero(event)" /></td>
				</tr>
				<tr>
					<td>Responsable del Convenio en Facultad <span style="color: red;">*</span></td>
					<td><input type="text" id="supervisorbosque" name="supervisorbosque" size="50%" class="required" value="<?php if($edit){ echo $solicitud->responsableconvenio;} ?>" onkeypress="return val_texto(event)"/></td>
				</tr>
				<tr>
					<td>Cargo <span style="color: red;">*</span></td>
					<td><input type="text" id="txtCargoSU" name="txtCargoSU" size="50%" class="required" value="<?php if($edit){ echo $solicitud->cargoresponsableconvenio;} ?>" onkeypress="return val_texto(event)"/></td>
				</tr>
				<tr>
					<td>Correo Electrónico <span style="color: red;">*</span></td>
					<td><input type="text" id="txtCorreoSU" name="txtCorreoSU" size="50%" class="required correo" value="<?php if($edit){ echo $solicitud->correoresponsableconvenio;} ?>"  onkeypress="return val_email(event)"/></td>
				</tr>
				<tr>
					<td>Teléfono celular</td>
					<td><input type="text" id="txtCelularSU" name="txtCelularSU" size="50%" value="<?php if($edit){ echo $solicitud->celularresponsableconvenio;} ?>" onkeypress="return val_numero(event)"/></td>
				</tr>
			</table>
				<div style="width:80%;margin-bottom:20px;clear:both;height:40px">
	                        <input type="submit" class="boton" id="Guardar" name="Guardar" value="Siguiente" style="display:block;float:right;"/>
	                        <input type="button" class="boton" value="Regresar" onclick="Regresar()" style="display:block;float:left;"/>
	            </div>
			</form>
		</div>
<script type="text/javascript">
                $(':submit').click(function(event) {
                    event.preventDefault();
                    var action = $("#Action_id").val();
                    if(action=="SaveData")
                    {
                        var valido= validateForm("#propuesta");
                        var tipofacultad = $('#Validar_facultad').val();
                        //validar el archivo adjunto sea pdf la extension ['gif','png','jpg','jpeg']
                        if(tipofacultad != '1')
                        {
                            var ext = $('#archivo').val().split('.').pop().toLowerCase();
        					if($.inArray(ext, ['pdf']) == -1) {
        						$( "#archivo" ).addClass('error');
        						$( "#archivo" ).effect("pulsate", { times:3 }, 500);
        						valido = false;
        					}
                        }else
                        {
                            valido = true;
                        }
                    }else
                    {
                        valido = true;
                    }
                    if(valido){
                       $( "#propuesta" ).submit();
                    }
                });
</script>
    </body>
</html>