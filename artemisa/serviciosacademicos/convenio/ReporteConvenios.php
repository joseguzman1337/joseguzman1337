<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once (realpath(dirname(__FILE__)).'/../EspacioFisico/templates/template.php');
    include_once (realpath(dirname(__FILE__)).'/./Permisos/class/PermisosConvenio_class.php'); $C_Permisos = new PermisosConvenio();
    include_once(realpath(dirname(__FILE__)).'/../mgi/Menu.class.php');        $C_Menu_Global  = new Menu_Global();
    $db = getBD();

    $SQL_User='SELECT idusuario as id, codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
    $Usario_id=$db->GetRow($SQL_User);        
    $userid=$Usario_id['id'];

    $Acceso = $C_Permisos->PermisoUsuarioConvenio($db,$userid,1,5);

    if($Acceso['val']===false){
        ?>
        <blink>
            <?PHP echo $Acceso['msn'];?>
        </blink>
        <?PHP
        Die;
    }
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Menú Convenios</title>
        <link type="text/css" href="../educacionContinuada/css/normalize.css" rel="stylesheet">
        <link media="screen, projection" type="text/css" href="../educacionContinuada/css/style.css" rel="stylesheet">
		<link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" />
        <script type='text/javascript' language="javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery-ui-1.8.21.custom.min.js"></script>   
        <script type="application/javascript">
         $("#fechaIni").datepicker({
            changeMonth: true,
            changeYear: true,
            showOn: "button",
            buttonImage: "../css/themes/smoothness/images/calendar.gif",
            buttonImageOnly: true,
            dateFormat: "yy-mm-dd"
        });
         $("#fechaFin").datepicker
        ({
            changeMonth: true,
            changeYear: true,
            showOn: "button",
            buttonImage: "../css/themes/smoothness/images/calendar.gif",
            buttonImageOnly: true,
            dateFormat: "yy-mm-dd"
        });
        </script>
    </head>
    <body class="body"> 
        <div id="pageContainer">
            <div id="container">
                <input type="hidden" name="reporteGeneral" id="reporteGeneral" value="1">
                <center>
                    <h1><font face="sans-serif">REPORTE CONVENIOS</font></h1>
                </center>
                <?php 
                    $sqlestados = "select idsiq_estadoconvenio, nombreestado from siq_estadoconvenio";
                    $resultdatos = $db->execute($sqlestados);
                ?>
                <table align="center" cellpadding="14" border="2" >
                    <tr>
                        <td><font face="sans-serif">Seleccione Estado Convenio:</font></td>
                        <td><select name="estadoConvenio" id="estadoConvenio">
                                <option value="">Seleccione</option>
                                <?php
                                while(!$resultdatos->EOF)
                                {
                                    ?>
                                         <option value="<?php echo $resultdatos->fields['idsiq_estadoconvenio'];?>"><?php echo $resultdatos->fields['nombreestado'];?></option>
                                    <?php
                                    $resultdatos->MoveNext();
                                } ?>
                            </select>
                        </td>
                    </tr>
					<tr>
					<?php 
						$sqlestadosInsti = "select InstitucionConvenioId, NombreInstitucion from InstitucionConvenios where idsiq_estadoconvenio = '1'";
						$resultdatosInsti = $db->execute($sqlestadosInsti);
					?>
                        <td><font face="sans-serif">Institución Convenio:</font></td>
                        <td colspan="3"><select name="instituConvenio" id="instituConvenio">
                                <option value="">Seleccione</option>
                                <?php
                               while(!$resultdatosInsti->EOF)
                                {
                                    ?>
                                         <option value="<?php echo $resultdatosInsti->fields['InstitucionConvenioId'];?>"><?php echo $resultdatosInsti->fields['NombreInstitucion'];?></option>
                                    <?php
                                    $resultdatosInsti->MoveNext();
                                } ?>
                            </select>
                        </td>
                    </tr>
					<tr>
                        <td><font face="sans-serif">Fecha Inicio Convenio</font></td>
						<td>
							<input type="text" name="fechaIni" id="fechaIni" />
						</td> 
                        <td><font face="sans-serif">Fecha Fin Convenio</font></td>
						<td>
							<input type="text" name="fechaFin" id="fechaFin" />
						</td>  	
					</tr>
					<tr>
                        <td><font face="sans-serif">Ambito:</font></td>
						<td>
							<select id="ambito" class="required" name="ambito">
								<option value="">Seleccione</option>
								<option value="1">Internacional</option>
								<option value="2">Nacional</option>
							</select>
						</td>
						<?php 
							$sqlTipoCon = "select idsiq_tipoconvenio, nombretipoconvenio from siq_tipoconvenio where codigoestado = '100'";
							$resulTipoCon = $db->execute($sqlTipoCon);
						?>
                        <td><font face="sans-serif">Tipo Convenio:</font></td>
							<td><select name="tipoConvenio" id="tipoConvenio">
									<option value="">Seleccione</option>
									<?php
								   while(!$resulTipoCon->EOF)
									{
										?>
											 <option value="<?php echo $resulTipoCon->fields['idsiq_tipoconvenio'];?>"><?php echo $resulTipoCon->fields['nombretipoconvenio'];?></option>
										<?php
										$resulTipoCon->MoveNext();
									} ?>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="4">
                                <center><button class="buttons-menu" type="button" style="cursor:pointer;padding:8px 22px;height:auto;width:auto;" id="consultarData"><font face="sans-serif">Consultar</font></button></center>
							</td>
						</tr>
                </table>
            </div>
            <div align="center">
                <div id="dataReporte" align="center"></div>
            </div>
        </div>
        <div align="center" id="exportExcel">
            <button class="buttons-menu" type="button" style="cursor:pointer;padding:8px 22px;height:auto;width:auto;" id="exportExcel"><font face="sans-serif">Exportar a Excel</font></button>
            <form id="formInforme" style="z-index: -1; width:100%" method="post" action="ficheroExcel.php" align="center">
                <input id="datos_a_enviar" type="hidden" name="datos_a_enviar">
            </form>
        </div>
    </body>
</html>
<script>
    $('#exportExcel').click(function (e) 
    {
        $("#datos_a_enviar").val($("<div>").append($("#dataR").eq(0).clone()).html());
        $("#formInforme").submit();
    });
    $('#exportExcel').hide(); //oculto mediante id        
    $('#consultarData').click(function (e) 
    {
        var selecEstado = document.getElementById("estadoConvenio").value;
		var instituConvenio = document.getElementById("instituConvenio").value;
		var fechaIni = document.getElementById("fechaIni").value;
		var fechaFin = document.getElementById("fechaFin").value;
		var ambito = document.getElementById("ambito").value;
		var tipoConvenio = document.getElementById("tipoConvenio").value;
		var reporteGeneral = document.getElementById("reporteGeneral").value;
		
        $.ajax({//Ajax
            type: 'POST',
            url: 'classReportes.php',
            async: false,
            dataType: 'html',
            data: {selecEstado: selecEstado,instituConvenio: instituConvenio,fechaIni: fechaIni,fechaFin: fechaFin,ambito: ambito,tipoConvenio: tipoConvenio,
				   reporteGeneral:reporteGeneral},
            error: function (objeto, quepaso, otroobj) 
            {
                alert('Error de Conexión , Favor Vuelva a Intentar');
            },
            success: function (data) 
            {
                if (data.val === false) 
                {
                    alert(data.descrip);
                    return false;
                } else
                {
                    $('#exportExcel').show(); //muestro mediante id    
                    $('#dataReporte').show(); //muestro mediante id    
                    $('#dataReporte').html(data);
                }
            }//data
        });// AJAX
    });
</script>