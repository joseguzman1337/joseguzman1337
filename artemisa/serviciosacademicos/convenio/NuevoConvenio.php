<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once ('../EspacioFisico/templates/template.php');   
    $db = getBD();
    
    $sqlS = "select idusuario from usuario where usuario = '".$_SESSION['MM_Username']."'";
    $usuario = $db->GetRow($sqlS);
    $user = $usuario['idusuario'];
    
if($_POST['Action_id']=='SaveData')
{
    $nombreconvenio                = $_POST['nombreconvenio']; 
    $pais                          = $_POST['pais'];
    $codigoconvenio                = $_POST['codigo'];
    $fechainicio                   = $_POST['fechainicio'];
    $fechafin                      = $_POST['fechafin'];
    $idsiq_tipoconvenio            = $_POST['tipoconvenio'];
    $InstitucionConvenioId         = $_POST['institucion'];
    $idsiq_estadoconvenio          = $_POST['estado'];
    $idsiq_duracionconvenio        = $_POST['duracion'];
    $fechaClausula                 = $_POST['fechaClausula'];
    $renovacion                    = $_POST['renovacion'];
    $afiliacionarl                 = $_POST['arl'];
    if(empty($afiliacionarl)){$afiliacionarl='0';}
    $rce                           = $_POST['rce'];
    if(empty($rce)){$rce='0';}
    $afiliacionsgss                = $_POST['sgsss'];
    if(empty($afiliacionsgss)){$afiliacionsgss='0';}
    $fechacreacion                 = date("Y-m-d H:i:s");
    $prb                           = $_POST['prb'];
    if(empty($prb)){$prb='0';}
    $id                            = $_POST['id'];
	$ambito                        = $_POST['ambito'];
	$ObjetoConvenioId			= $_POST['objetoconvenio']; 
    $nombreconvenio = filter_var($nombreconvenio,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $pais = filter_var($pais,FILTER_SANITIZE_NUMBER_INT);
    $codigoconvenio = filter_var($codigoconvenio,FILTER_SANITIZE_NUMBER_INT);
    $idsiq_tipoconvenio = filter_var($idsiq_tipoconvenio,FILTER_SANITIZE_NUMBER_INT);
    $InstitucionConvenioId = filter_var($InstitucionConvenioId,FILTER_SANITIZE_NUMBER_INT);
    $idsiq_estadoconvenio = filter_var($idsiq_estadoconvenio,FILTER_SANITIZE_NUMBER_INT);
    $idsiq_duracionconvenio = filter_var($idsiq_duracionconvenio,FILTER_SANITIZE_NUMBER_INT);
    $renovacion = filter_var($renovacion,FILTER_SANITIZE_NUMBER_INT);
    $afiliacionarl = filter_var($afiliacionarl,FILTER_SANITIZE_NUMBER_INT);
    $rce = filter_var($rce,FILTER_SANITIZE_NUMBER_INT);
    $afiliacionsgss = filter_var($afiliacionsgss,FILTER_SANITIZE_NUMBER_INT);
    $prb = filter_var($prb,FILTER_SANITIZE_NUMBER_INT);
    $id = filter_var($id,FILTER_SANITIZE_NUMBER_INT);
    $ambito = filter_var($ambito,FILTER_SANITIZE_NUMBER_INT);
    $ObjetoConvenioId = filter_var($ObjetoConvenioId,FILTER_SANITIZE_NUMBER_INT);
    
    $sql1="SELECT count(NombreConvenio) FROM Convenios where NombreConvenio = '".$nombreconvenio."' and InstitucionConvenioId='".$InstitucionConvenioId."'";
    if($Consulta=$db->Execute($sql1)===true)
    {
        $a_vectt['val']			=false;
        $a_vectt['descrip']		='Error al Consultar..';
        echo json_encode($a_vectt);
        exit;
    }
    $valores = $db->Execute($sql1);
    $datos =  $valores->getarray();
    if ($datos[0][0]>0)
    {
        //$descrip = $sql1;
        $descrip = 'El convenio que esta intentando ingresar ya se encuentra registrado.';
        ?>
        <script>
            localtion.href="../convenio/NuevoConvenio.php":
        </script>
        
        <?php
    }else
    {
        $sql2="INSERT INTO Convenios (NombreConvenio, PaisId, CodigoConvenio, FechaInicio, FechaFin, idsiq_tipoconvenio, InstitucionConvenioId, 
		idsiq_estadoconvenio, idsiq_duracionconvenio, FechaClausulaTerminacion, TipoRenovacionId, AfiliacionArl, 
		UsuarioCreacion, RCE, AfiliacionSgsss, FechaCreacion, PRB,Ambito) 
		values ('".$nombreconvenio."', '".$pais."', '".$codigoconvenio."', '".$fechainicio."','".$fechafin."', 
		'".$idsiq_tipoconvenio."','".$InstitucionConvenioId."', '".$idsiq_estadoconvenio."', '".$idsiq_duracionconvenio."', 
		'".$fechaClausula."', '".$renovacion."', '".$afiliacionarl."', '".$user."','".$rce."','".$afiliacionsgss."', 
		'".$fechacreacion."', '".$prb."','".$ambito."')"; 
        $agregar = $db->Execute($sql2);   
        $descrip = 'La institucion fue agregada';
        //$descrip =  $sql2;
    }
$a_vectt['val']			=true;
$a_vectt['descrip']		=$descrip;
echo json_encode($a_vectt);
exit;
}//if($_POST['Action_id']=='SaveData')        
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleDatos.css" type="text/css" /> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Nuevo Convenio</title>
        
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/functions.js"></script>
        <script type="text/javascript" language="javascript" src="js/funcionesConvenios.js"></script>
        <script type="text/javascript" language="javascript">
        /****************************************************************/
        
        
        	$(document).ready( function () {

        			
        		$("#fechainicio").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    showOn: "button",
                    buttonImage: "../css/themes/smoothness/images/calendar.gif",
                    buttonImageOnly: true,
                    dateFormat: "yy-mm-dd"
                });
                $("#fechafin").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    showOn: "button",
                    buttonImage: "../css/themes/smoothness/images/calendar.gif",
                    buttonImageOnly: true,
                    dateFormat: "yy-mm-dd"
                });
                $("#fechaClausula").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    showOn: "button",
                    buttonImage: "../css/themes/smoothness/images/calendar.gif",
                    buttonImageOnly: true,
                    dateFormat: "yy-mm-dd"
                });
               $('#ui-datepicker-div').css('display','none');
           	
                         
                                                                                                
                                 //$('#demo').before( oTableTools.dom.container );
        	} );
        	/**************************************************************/
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
        
        function val_dirrecion(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==8) return true;
            patron =/[0-9a-zA-ZñÑ-\s]+$/;            
            te = String.fromCharCode(tecla);
            return patron.test(te);
        }
        
       </script>
        
                
    </head>
    <body> 
        <div id="container">
        <center>
            <h1>NUEVO CONVENIO</h1>
        </center>
        <form  id="nuevoconvenio" action="../convenio/DetalleConvenio.php" method="post" enctype="multipart/form-data" >
            <input type="hidden" id="Action_id" name="Action_id" value="SaveData" />
            <table cellpadding="3" width="60%" border="0" align="center">
                <tr>
                    <td colspan="6">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td>Nombre Convenio:<span style="color: red;">*</span></td>
                    <td>
                        <input type="text" name="nombreconvenio" id="nombreconvenio" value="<?php echo $nombreconvenio ?>" size="50" class="required" onkeypress="return val_texto(event)"/>
                    </td>
                    <td>Institución:<span style="color: red;">*</span></td>
                    <td colspan="3">
                        <select name="institucion" id="institucion" class="required" style="width:100%">
                            <?php 
                            $sqlInstitucion = "select InstitucionConvenioId, NombreInstitucion from InstitucionConvenios where idsiq_estadoconvenio='1'";
                            $valoresInstitucion = $db->execute($sqlInstitucion);
                            foreach($valoresInstitucion as $datosInstitucion)
                            {
                                ?>
                                <option value="<?php echo $datosInstitucion['InstitucionConvenioId']?>"><?php echo $datosInstitucion['NombreInstitucion']?></option>
                                <?php
                            }                           
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Código</td>
                    <td>
                        <input type="text" name="codigo" id="codigo" onkeypress="return val_numero(event)" />
                    </td>
                
                    <td>País:</td>
                    <td>
                        <select name="pais" id="pais" class="required">
                        <?php
                        $sqlPais = "select idpais, nombrepais from pais where codigoestado = '100'";
                        $valorespais = $db->execute($sqlPais);
                        foreach($valorespais as $datospais)
                        {
                            ?>
                            <option value="<?php echo $datospais['idpais']?>"><?php echo $datospais['nombrepais']?></option>
                            <?php
                        }
                        ?>
                        </select>
                    </td>
                      <td>Tipo de Renovación</td>
                      <td>
                      <select name="renovacion" id="renovacion">
                        <option value="0" selected="selected">Ninguna</option>
                        <option value="1">Automática</option>
                        <option value="2">Por Evaluación</option>
                        <option value="3">Por Escrito</option>
                      </select>
                      </td> 
                 </tr>  
                <tr>
                    <td>Duración:</td>
                    <td>
                        <select name="duracion" id="duracion">
                        <?php
                        $sqlDuracion = "select idsiq_duracionconvenio, nombreduracion from siq_duracionconvenio ";
                        $valoresduracion = $db->execute($sqlDuracion);
                        foreach($valoresduracion as $datosduracion)
                        {
                            ?>
                            <option value="<?php echo $datosduracion['idsiq_duracionconvenio']?>"><?php echo $datosduracion['nombreduracion']?></option>
                            <?php
                        }                        
                        ?>
                        
                        </select>
                    </td>
                    <td>Fecha inicio:</td>
                      <td>
                          <input type="text" name="fechainicio" id="fechainicio" value="<?php echo $fechainicio?>" readonly="true"/>
                      </td>
                      <td>Fecha final</td>
                      <td>
                          <input type="text" name="fechafin" id="fechafin" value=""/>
                      </td>
                </tr> 
                <tr>    
                    <tr>
                    <td>Fecha Cláusula Terminación</td>
                    <td>
                        <input type="text" name="fechaClausula" id="fechaClausula" value="<?php echo $fechaClausula?>"/>
                    </td>                          
                
                    <td>Arl:</td>
                    <td>
                        <input type="text" name="arl" id="arl" value="<?php echo $afiliacionarl?>" onkeypress="return val_numero(event)"/>
                    </td>
                    <td>RCE</td>
                    <td>
                        <input type="text" name="rce" id="rce" value="<?php echo $rce?>" onkeypress="return val_numero(event)" />
                    </td>
                </tr>
                <tr>
                    <td>PRB</td>
                    <td>
                        <input type="text" name="prb" id="prb" value="<?php echo $prb?>" onkeypress="return val_numero(event)" />
                    </td>
                    <td>Afiliación SGSSS (EPS)</td>
                    <td>
                        <input type="text" name="sgsss" id="sgsss" value="<?php echo $afiliacionsgss?>"  onkeypress="return val_numero(event)"/>
                    </td>
                    
                    <td>Estado:</td>
                    <td>
                        <select name="estado" id="estado" class="required">
                        <option value="1" selected>Vigente</option>
                        <!--<option value="2">En proceso</option>
                        <option value="3">Anulado</option>
                        <option value="4">Vencido</option>-->
                        </select>
                    </td>
                </tr>
				<tr>
					<td>Ámbito:</td>
					 <td>
                        <select name="ambito" id="ambito" class="required">
                        <option value="1">Internacional</option>
                        <option value="2">Nacional</option>
                        </select>
						
                    </td>	
                    <td>Tipo convenio:</td>
                    <td>
                        <?php
                        $sqltipoconvenio = "select idsiq_tipoconvenio, nombretipoconvenio from siq_tipoconvenio where codigoestado=100";
                        $valorestipoconvenio = $db->execute($sqltipoconvenio);
                        ?>
                        <select name="tipoconvenio" id="tipoconvenio">
                        <option value=""></option>
                            <?php
                            foreach($valorestipoconvenio as $datostipoconvenio)
                            {
                                    ?>
                                    <option value="<?php echo $datostipoconvenio['idsiq_tipoconvenio']?>"><?php echo $datostipoconvenio['nombretipoconvenio']?></option>
                                    <?php
                            
                            }                                                 
                          ?>
                        </select> 
                    </td>
                    <td>&nbsp;</td>
                    <td>
					<!--
                        <?php
                        $sqltipoconvenio = "select ObjetoConvenioId, NombreObjeto FROM ObjetoConvenio WHERE CodigoEstado=100";
                        $valorestipoconvenio = $db->execute($sqltipoconvenio);
                        ?>
                        <select name="objetoconvenio" id="objetoconvenio">
                        <option value=""></option>
                            <?php
                            foreach($valorestipoconvenio as $datostipoconvenio)
                            {
                                    ?>
                                    <option value="<?php echo $datostipoconvenio['ObjetoConvenioId']?>"><?php echo $datostipoconvenio['NombreObjeto']?></option>
                                    <?php
                            
                            }                                                 
                          ?>
                        </select> -->
                    </td>  
                </tr>
                <tr>
                    <td colspan="6">
                        <hr />
                    </td>
                </tr>
               
            </table>
            <center>
            <table width="600" id="botones"><tr>
            <td>
                <input type="button" value="Guardar" onclick="validarDatos('#nuevoconvenio');" /></td>
                <td align='right'><input type="button" value="Regresar" onclick="RegresarConvenio()" /></td></tr>
                </table>
            </center>  
        </form>
    </div>
    <?php
       
    ?>
  </body>
</html>
<script>
    $("#duracion").on("change",function(){
         var fechaIni=$("#fechainicio").val();
         if(fechaIni){
            var duracion=$("#duracion").val();
            var elem = fechaIni.split('-');

            ano = elem[0];
            mes = elem[1];
            dia = elem[2];
            var ano= parseInt(ano);
            var duracion=parseInt(duracion);
            var anofin=ano+duracion;
           fechafin1=anofin+"-"+mes+"-"+dia;
           ms = Date.parse(fechafin1);
           fecha = new Date(ms);
           fechaFin=$.datepicker.formatDate('yy-mm-dd', fecha);
           var fechafin = document.getElementById("fechafin");
           fechafin.value = fechaFin;
        }
    });
    
    $("#fechainicio").on("change",function(){
         var fechaIni=$("#fechainicio").val();
         var duracion=$("#duracion").val();
         var elem = fechaIni.split('-');
         
         ano = elem[0];
         mes = elem[1];
         dia = elem[2];
         var ano= parseInt(ano);
         var duracion=parseInt(duracion);
         var anofin=ano+duracion;
        fechafin1=anofin+"-"+mes+"-"+dia;
        ms = Date.parse(fechafin1);
        fecha = new Date(ms);
        fechaFin=$.datepicker.formatDate('yy-mm-dd', fecha);
        var fechafin = document.getElementById("fechafin");
        fechafin.value = fechaFin;
        });
</script>