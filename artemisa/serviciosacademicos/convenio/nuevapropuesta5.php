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

    if(!$_REQUEST['id'])
    {
        ?>
    	<script type="text/javascript">
    		window.location = './Propuestaconvenio.php';
    	</script>
    	<?php
    }

    $ambitos_obligatorios = "Select Ambito from SolicitudConvenios where SolicitudConvenioId = '".$_REQUEST["id"]."'";
    $ambito = $db->GetRow($ambitos_obligatorios);
    if($ambito['Ambito'] == 1)
    {
        $Nacionalidad = 1;
    }
    if($ambito['Ambito'] == 2)
    {
        $Nacionalidad = 2;
    }

    $codigoFacultad = $_SESSION['codigofacultad'];
    $edit=false;
    $action = "SaveData";
    if(isset($_REQUEST["id"])){
    		$solicitud = new solicitudConvenio();
    		$solicitud->load("SolicitudConvenioId=?", array($_REQUEST["id"]));
    		$edit = true;
    		$action = "UpdateData";
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

        <script type="text/javascript" language="javascript" src="uploadify/uploadify.swf"></script>
        <script type="text/javascript" language="javascript" src="uploadify/jquery.uploadify-3.1.10.min.js"></script>
        <script type="text/javascript" language="javascript" src="js/funcionArchivosSolicitudes.js"></script>

        <script>
            function Regresar()
            {
                location.href = "./nuevapropuesta4.php?id=<?php echo $_GET["id"]; ?>";
            }
            $(document).ready(function () {

				$("#txtAnexos").uploadify({
					'swf' : 'uploadify/uploadify.swf',
        			'uploader' : 'uploadify/uploadify.php',
        			'queueID': 'listaArchivos',
        			'buttonText': 'Examinar',
        			'wmode': 'transparent',
					'hideButton': true,
        			'auto' : false,
        			'multi' : true,
        			'hideButton': true
				});

                //$('#demo').before( oTableTools.dom.container );
            });

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
			<table>
			<tr>
				<td style="background-color:#DDD;" align="center" colspan="2">Anexos</td>
			</tr>
				<tr>
					<td>Carta de solicitud por parte de Decano de la Facultad o Director de Posgrados(PDF):</td>
					<td id="archivo1">
                        <form enctype="multipart/form-data" class="formulario1" id="formulario1">
                            <table>
                            <tr>
                                <td><center>
                                <input type="hidden" id="Nacionalidad" name="Nacionalidad" value="<?php echo $Nacionalidad;?>" />
                                <input type="hidden" id="TipoAnexo" name="TipoAnexo" value="1" />
                                <input type="hidden" id="id" name="id" value="<?php echo $_GET["id"]; ?>" />
                                <input type="hidden" id="usuario" name="usuario" value="<?php echo $usuario ?>" />
                                <?php
                                if($action=='UpdateData')
                                { $indicador = 0; }
                                else
                                { $indicador = 1; }
                                $sql="SELECT s.Nombre, s.Url, s.SolicitudAnexoId FROM SolicitudAnexos s where s.TipoAnexoId ='1' and s.SolicitudConvenioId = '".$_GET["id"]."' and s.CodigoEstado = '100';";
                                $consultar = $db->GetRow($sql);
                                if($consultar['Nombre'])
                                {
                                    ?><strong><?php echo $consultar['Nombre']?></strong>
                                    <input name="archivoCartanombre" type="hidden" id="archivoCartanombre" value="<?php echo $consultar['Url']; ?>"/> </td>
                                    <td><a href='<?php echo $consultar['Url']?>' target="_blank"><img src='../mgi/images/file_document.png' width='50' height='37'  border="0" alt=""/></a>
                                    </td>
                                    <?php
                                }
                                ?>
                            </tr>
                            <tr>
                                <td>
                                    <input type="hidden" id="indicador1" name="indicador1" value="<?php echo $indicador;?>" />
                                    <input type="hidden" id="actionID" name="actionID" value="SaveFile" />
                                    <input name="archivoCarta" type="file" id="archivoCarta" accept=".pdf" /></td>
                                    <td><input type="button" value="Subir Archivo" />
                                    </center>
                                </td>
                            </tr>
                            </table>
                        </form>
                        <!--div para visualizar mensajes-->
                        <div class="messagesCarta"></div><br /><br />
					</td>
				</tr>
				<tr>
					<td>Proyecto de Convenio(WORD):</td>
					<td id="archivo2">
                        <form enctype="multipart/form-data" class="formulario2" id="formulario2">
                        <table>
                            <tr>
                            <td><center>
                            <input type="hidden" id="TipoAnexo" name="TipoAnexo" value="2" />
                            <input type="hidden" id="id" name="id" value="<?php echo $_GET["id"]; ?>" />
                            <input type="hidden" id="usuario" name="usuario" value="<?php echo $usuario ?>" />
                            <?php
                            if($action=='UpdateData')
                                { $indicador = 0; }
                                else
                                { $indicador = 1; }
                            $sql="SELECT s.Nombre, s.Url, s.SolicitudAnexoId FROM SolicitudAnexos s where s.TipoAnexoId ='2' and s.SolicitudConvenioId = '".$_GET["id"]."' and s.CodigoEstado = '100';";
                            $consultar = $db->GetRow($sql);
                            if($consultar['Nombre'])
                            {
                                ?><strong><?php echo $consultar['Nombre']?></strong>
                                <input name="archivoConvenionombre" type="hidden" id="archivoConvenionombre" value="<?php echo $consultar['Url']; ?>"/> </td>
                                <td><a href='<?php echo $consultar['Url']?>' target="_blank"><img src='../mgi/images/file_document.png' width='50' height='37'  border="0" alt=""/></a>
                                <?php
                            }
                               ?>
                               </tr>
                               <tr>
                                    <td>
                               <input type="hidden" id="indicador2" name="indicador2" value="<?php echo $indicador;?>" />
                               <input type="hidden" id="actionID" name="actionID" value="SaveFile" />
                                <input name="archivoConvenio" type="file" id="archivoConvenio" accept="application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword"/></td>
                                <td><input type="button" value="Subir Archivo"/>
                                </center></td>
                            </tr>
                        </table>
                        </form>
                        <!--div para visualizar mensajes-->
                        <div class="messagesConvenio"></div><br /><br />
					</td>
				</tr>
				<tr>
					<td>Certificado Cámara de comercio o Representación legal de la contraparte(PDF):</td>
					<td id="archivo3">
                        <form enctype="multipart/form-data" class="formulario3" id="formulario3">
                        <table>
                            <tr>
                            <td><center>
                            <input type="hidden" id="TipoAnexo" name="TipoAnexo" value="3" />
                            <input type="hidden" id="id" name="id" value="<?php echo $_GET["id"]; ?>" />
                            <input type="hidden" id="usuario" name="usuario" value="<?php echo $usuario ?>" />
                            <?php
                             if($action=='UpdateData')
                                { $indicador = 0; }
                                else
                                { $indicador = 1; }
                            $sql="SELECT s.Nombre, s.Url, s.SolicitudAnexoId FROM SolicitudAnexos s where s.TipoAnexoId ='3' and s.SolicitudConvenioId = '".$_GET["id"]."' and s.CodigoEstado = '100';";
                            $consultar = $db->GetRow($sql);
                            if($consultar['Nombre'])
                            {
                                ?><strong><?php echo $consultar['Nombre']?></strong>
                                <input name="archivoCamaranombre" type="hidden" id="archivoCamaranombre" value="<?php echo $consultar['Url']; ?>"/> </td>
                                <td><a href='<?php echo $consultar['Url']?>' target="_blank"><img src='../mgi/images/file_document.png' width='50' height='37'  border="0" alt=""/></a>
                                <?php
                             }
                               ?>
                               </tr><tr>
                                    <td>
                               <input type="hidden" id="indicador3" name="indicador3" value="<?php echo $indicador;?>" />
                                <input type="hidden" id="actionID" name="actionID" value="SaveFile" />
                                <input name="archivoCamara" type="file" id="archivoCamara" accept=".pdf" /></td>
                            <td><input type="button" value="Subir Archivo" /></center></td>
                            </tr>
                        </table>
                        </form>
                        <!--div para visualizar mensajes-->
                        <div class="messagesCamara"></div><br /><br />
					</td>
				</tr>
				<tr>
					<td>Documento de Identidad de Representante Legal(PDF):</td>
					<td id="archivo4">
                        <form enctype="multipart/form-data" class="formulario4" id="formulario4">
                        <table>
                            <tr>
                            <td><center>
                            <input type="hidden" id="TipoAnexo" name="TipoAnexo" value="4" />
                            <input type="hidden" id="id" name="id" value="<?php echo $_GET["id"]; ?>" />
                            <input type="hidden" id="usuario" name="usuario" value="<?php echo $usuario ?>" />
                            <?php
                            if($action=='UpdateData')
                                { $indicador = 0; }
                                else
                                { $indicador = 1; }
                            $sql="SELECT s.Nombre, s.Url, s.SolicitudAnexoId FROM SolicitudAnexos s where s.TipoAnexoId ='4' and s.SolicitudConvenioId = '".$_GET["id"]."' and s.CodigoEstado = '100';";
                            $consultar = $db->GetRow($sql);
                            if($consultar['Nombre'])
                            {
                                ?><strong><?php echo $consultar['Nombre']?></strong>
                                <input name="archivoRepresentantenombre" type="hidden" id="archivoRepresentantenombre" value="<?php echo $consultar['Url']; ?>"/> </td>
                                <td><a href='<?php echo $consultar['Url']?>' target="_blank"><img src='../mgi/images/file_document.png' width='50' height='37'  border="0" alt=""/></a>
                              <?php
                             } ?>
                             </tr><tr>
                             <td>
                               <input type="hidden" id="indicador4" name="indicador4" value="<?php echo $indicador;?>" />
                            <input type="hidden" id="actionID" name="actionID" value="SaveFile" />
                            <input name="archivoRepresentante" type="file" id="archivoRepresentante" <?php if($Nacionalidad == '2'){echo "class='required'";}?> accept=".pdf" /></td>
                        <td><input type="button" value="Subir Archivo" /></center></td>
                            </tr>
                        </table>
                        </form>
                        <!--div para visualizar mensajes-->
                        <div class="messagesRepresentante"></div><br /><br />
					</td>
				</tr>
				<tr>
					<td>Plan de trabajo(PDF):</td>
					<td id="archivo5">
                        <form enctype="multipart/form-data" class="formulario5" id="formulario5">
                        <table>
                            <tr>
                            <td><center>
                            <input type="hidden" id="TipoAnexo" name="TipoAnexo" value="5" />
                            <input type="hidden" id="id" name="id" value="<?php echo $_GET["id"]; ?>" />
                            <input type="hidden" id="usuario" name="usuario" value="<?php echo $usuario ?>" />
                            <?php
                             if($action=='UpdateData')
                                { $indicador = 0; }
                                else
                                { $indicador = 1; }
                            $sql="SELECT s.Nombre, s.Url, s.SolicitudAnexoId FROM SolicitudAnexos s where s.TipoAnexoId ='5' and s.SolicitudConvenioId = '".$_GET["id"]."' and s.CodigoEstado = '100';";
                            $consultar = $db->GetRow($sql);
                            if($consultar['Nombre'])
                            {
                                ?><strong><?php echo $consultar['Nombre']?></strong>
                               <input name="archivoPlanNombre" type="hidden" id="archivoPlanNombre" value="<?php echo $consultar['Url']; ?>"/> </td>
                                <td><a href='<?php echo $consultar['Url']?>' target="_blank"><img src='../mgi/images/file_document.png' width='50' height='37'  border="0" alt=""/></a>
                             <?php
                             }
                               ?>
                               </tr><tr>
                                    <td>
                               <input type="hidden" id="indicador5" name="indicador5" value="<?php echo $indicador;?>" />
                            <input type="hidden" id="actionID" name="actionID" value="SaveFile" />
                             <input name="archivoPlan" type="file" id="archivoPlan" accept=".pdf" /></td>
                        <td><input type="button" value="Subir Archivo"/></center></td>
                            </tr>
                        </table>
                        </form>
                        <!--div para visualizar mensajes-->
                        <div class="messagesPlan"></div><br /><br />
					</td>
				</tr>
				<tr>
					<td>Presupuesto(PDF):</td>
					<td id="archivo6">
                        <form enctype="multipart/form-data" class="formulario6" id="formulario6">
                        <table>
                            <tr><td><center>
                            <input type="hidden" id="TipoAnexo" name="TipoAnexo" value="6" />
                            <input type="hidden" id="id" name="id" value="<?php echo $_GET["id"]; ?>" />
                            <input type="hidden" id="usuario" name="usuario" value="<?php echo $usuario ?>" />
                            <?php
                            if($action=='UpdateData')
                                { $indicador = 0; }
                                else
                                { $indicador = 1; }
                            $sql="SELECT s.Nombre, s.Url, s.SolicitudAnexoId FROM SolicitudAnexos s where s.TipoAnexoId ='6' and s.SolicitudConvenioId = '".$_GET["id"]."' and s.CodigoEstado = '100';";
                            $consultar = $db->GetRow($sql);
                            if($consultar['Nombre'])
                            {
                                ?><strong><?php echo $consultar['Nombre']?></strong>
                                 <input name="archivoPresupuestoNombre" type="hidden" id="archivoPresupuestoNombre" value="<?php echo $consultar['Url']; ?>"/> </td>
                                <td><a href='<?php echo $consultar['Url']?>' target="_blank"><img src='../mgi/images/file_document.png' width='50' height='37'  border="0" alt=""/></a>
                            <?php
                             }
                               ?>
                               </tr><tr>
                                    <td>
                            <input type="hidden" id="indicador6" name="indicador6" value="<?php echo $indicador;?>" />
                            <input type="hidden" id="actionID" name="actionID" value="SaveFile" />
                            <input name="archivoPresupuesto" type="file" id="archivoPresupuesto" accept=".pdf"  /></td>
                            <td><input type="button" value="Subir Archivo"  /></center></td>
                            </tr>
                        </table>
                        </form>
                        <!--div para visualizar mensajes-->
                        <div class="messagesPresupuesto"></div><br /><br />
					</td>
				</tr>
                <tr>
                    <td>Otro(PDF/WORD):</td>
                    <td id="archivo7">
                        <form enctype="multipart/form-data" class="formulario7" id="formulario7">
                           <table>
                           <tr><td><center>
                            <input type="hidden" id="TipoAnexo" name="TipoAnexo" value="7" />
                            <input type="hidden" id="id" name="id" value="<?php echo $_GET["id"]; ?>" />
                            <input type="hidden" id="usuario" name="usuario" value="<?php echo $usuario ?>" />
                            <?php
                            if($action=='UpdateData')
                                { $indicador = 0; }
                                else
                                { $indicador = 1; }
                            $sql="SELECT s.Nombre, s.Url, s.SolicitudAnexoId FROM SolicitudAnexos s where s.TipoAnexoId ='7' and s.SolicitudConvenioId = '".$_GET["id"]."' and s.CodigoEstado = '100';";
                            $consultar = $db->GetRow($sql);
                            if($consultar['Nombre'])
                            {
                                ?><strong><?php echo $consultar['Nombre']?></strong>
                                 <input name="otronombre" type="hidden" id="otronombre" value="<?php echo $consultar['Url']; ?>"/> </td>
                                <td><a href='<?php echo $consultar['Url']?>' target="_blank"><img src='../mgi/images/file_document.png' width='50' height='37'  border="0" alt=""/></a>
                            <?php
                             }
                            ?>
                            </tr><tr>
                             <td>
                             <input type="hidden" id="indicador7" name="indicador7" value="<?php echo $indicador;?>" />
                            <input type="file" name="otro" id="otro" />
                            <input type="hidden" id="actionID" name="actionID" value="SaveFile" />
                            </center>
                            </td>
                            <td>
                            <input type="button" value="Subir Archivo" />
                            </td>
                             </tr>
                            </table>
                        </form>
                        <!--div para visualizar mensajes-->
                        <div class="messagesOtro"></div><br /><br />
                    </td>
                </tr>
                    <tr>
                        <td colspan="5"><hr /></td>
                    </tr>
                    <tr>
                    <td colspan="3">
                         <form id="propuesta" name="propuesta" method="post" action="procesarSolicitudConvenio.php">
                            <input type="hidden" id="Action_id" name="Action_id" value="<?php echo $action; ?>" />
                            <input type="hidden" id="paso" name="paso" value="5" />
                            <?php
                             if($edit){ ?>
                            <input type="hidden" id="SolicitudConvenioId" name="SolicitudConvenioId" value="<?php echo $_REQUEST["id"]; ?>" />
                            <?php } ?>
                            <input type="submit" class="boton" id="Guardar" name="Guardar" value="Enviar Solicitud" style="display:block;float:right;width:auto;"/>
                            <input type="button" class="boton" value="Anterior" onclick="Regresar()" style="display:block;float:left;"/>
             			</form>
                    </td>
                    </tr>
		    		</table>
                </div>
		</div>
<script type="text/javascript">
       /* $(':submit').click(function(event) {
            event.preventDefault();
            var indicador = $("#indicador1").val();
            if(indicador=="0")
            {
                var nombre1 = $("#archivoCartanombre").val();
                if(nombre1)
                {
                    valido = true;
                }else
                {
                    var ext = $('#archivoCarta').val().split('.').pop().toLowerCase();
    				if($.inArray(ext, ['pdf']) == -1) {
    					$( "#archivoCarta" ).addClass('error');
    					$( "#archivoCarta" ).effect("pulsate", { times:3 }, 500);
    					valido = false;
    				}
                }
            }else
            {
                valido = true;
            }
            var nacionalidad = $("#Nacionalidad").val();
            if(nacionalidad == '2')
            {
                var indicador3 = $("#indicador3").val();
                if(indicador3=="0")
                {
                    var nombre3 = $("#archivoCamaranombre").val()
                    if(nombre3)
                    {
                       valido = true;
                    }else{
        				var ext = $('#archivoCamara').val().split('.').pop().toLowerCase();
        				if($.inArray(ext, ['pdf']) == -1) {
        					$( "#archivoCamara" ).addClass('error');
        					$( "#archivoCamara" ).effect("pulsate", { times:3 }, 500);
        					valido = false;
        				}
                    }
                }
                var indicador4 = $("#indicador4").val();
                if(indicador4=="0")
                {
                    var nombre4 = $("#archivoRepresentantenombre").val();
                    if(nombre4)
                    {
                        valido = true;
                    }else{
        				var ext = $('#archivoRepresentante').val().split('.').pop().toLowerCase();
        				if($.inArray(ext, ['pdf']) == -1) {
        					$( "#archivoRepresentante" ).addClass('error');
        					$( "#archivoRepresentante" ).effect("pulsate", { times:3 }, 500);
        					valido = false;
        				}
                    }
                }
            }
            if(valido){
               $( "#propuesta" ).submit();
            }
        });*/
</script>
    </body>
</html>