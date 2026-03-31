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

    /*** OBTENER MODALIDADES ***/
    
    $SQL = "SELECT 	* FROM modalidadacademica WHERE codigomodalidadacademica IN(200,300) AND codigoestado = 100";
    if($Modalidades=&$db->Execute($SQL)===false){
        echo 'Error en consulta a base de datos';
        die; 
    }

    function Listainstituciones($db)
    {
        $lista = "";
        $sqlinstituciones= "select InstitucionConvenioId, NombreInstitucion from InstitucionConvenios where idsiq_estadoconvenio ='1'";
        if($instituciones=&$db->Execute($sqlinstituciones)===false){
            echo 'Error en consulta a base de datos';
            die; 
        } 
        while(!$instituciones->EOF)
        {
            $lista.=  "<option value='".$instituciones->fields['InstitucionConvenioId']."'>".$instituciones->fields['NombreInstitucion']."</option>"; 
            $instituciones->MoveNext();
        }                           
        return $lista;                                              
    }
?>
<html>
    <head>
        <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleDatos.css" type="text/css" /> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Nuevo Acuerdos</title>
        
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.13.1/jquery.min.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/functions.js"></script>
        <script type="text/javascript" language="javascript" src="js/funcionesAcuerdos.js"></script>
        <script type="text/javascript" language="javascript" src="js/custom.js"></script>
        <link type="text/css" href="../educacionContinuada/css/normalize.css" rel="stylesheet">
		<link media="screen, projection" type="text/css" href="../educacionContinuada/css/style.css" rel="stylesheet">
        <script type="text/javascript">        
		$(function(){
			$("#regresar").on( "click", function () {				
				window.location.href="../convenio/AcuerdosCarreras.php";
			});
		});
        </script>
        <script>
        function val_numero(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==8) return true;
            patron =/[0-9-]+$/;            
            te = String.fromCharCode(tecla);
            return patron.test(te);
        }
        </script>
        
        
    </head>
    <body>
        <div id="container">
            <center>
                <h2>NUEVO ACUERDO</h2>
            </center>
            <form  id="nuevoacuerdo" name="nuevoacuerdo" method="post" enctype="multipart/form-data" >
                <input type="hidden" id="user" name="user" value="<?php echo $user;?>" />     
                <table cellpadding='3' WIDTH='70%' border='0' align='center' id='programas'>
                    <tr>
                        <td colspan="3">
                            <hr />
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <h3>Número Acuerdo</h3>
                        </th>
                        <td>
                            <input type="text" id="numeroAcuerdo" name="numeroAcuerdo" onkeypress="return val_numero(event)"/>
                        </td>                         					
                    </tr>
                    <tr>
                        <th>
                            <h3>Modalidad</h3>
                        </th>
                        <td>
                            <select id="modalidad">
                                <option value="0" selected="selected">Seleccione</option>
                                <?php
                                if(!$Modalidades->EOF)
                                {
                				    while(!$Modalidades->EOF)
                                    {
                    				    echo '<option value="'.$Modalidades->fields['codigomodalidadacademica'].'">'.$Modalidades->fields['nombremodalidadacademica'].'</option>';
                    					$Modalidades->MoveNext();
                					 }
                				 }                                                        
                                ?>
                            </select>
                        </td>                           					
                    </tr>
                    <tr id="Div_Facultad" style="width: 70%;">
                        <th>
                            <h3>Unidad académica</h3>
                        </th> 
                        <td>
                            <div >
                                <select id="facultad" disabled="disabled">
                                  <option value='0' selected='selected'>Seleccione</option>
                                </select>
                            </div>
                        </td>                         
                    </tr>
                    <tr>
                        <th>
                            <h3>Programa adscrito</h3>
                        </th> 
                        <td>
                            <div id="Div_Programa">
                                <table>
                                <tr id="programa" disabled="disabled">
                                <td></td>                 
                                </tr>
                                </table>
                            </div>
                            
                        </td>
                    </tr>
                </table>
                <table cellpadding='3' WIDTH='60%' border='0' align='center' id="expense_table">
                    <tr>
                        <td colspan="3">
                            <hr />
                        </td>
                    </tr>
                    <tr>
                        <th>Archivo: </th>
                        <td colspan="2">
                            <input name="archivo" type="file" id="archivo" />
                            <div class="messages"></div><br /><br />
                        </td>                    
                    </tr>
                    <tr>
                        <th>Instituciones</th>
                        <th>Cupos</th>
         			</tr>
       				<tbody id="1">
    				    <tr name="lista_01">
    					   <td>
                                <select name="1" id="instituciones_01" >
                                    <option value="0">Seleccione</option>
                                    <?php echo Listainstituciones($db); ?>
                                </select>
                            </td>
    						<td>
                               <center><input id="cupos_01" type="number" name="cupos_01" maxlength="40" onkeypress="return val_numero(event)"/></center>
                            </td>
    					</tr>
    				</tbody>
     			</table>
                <center><input type="hidden" id="contador" name="contador" value="1"/></center>        
                <center><input type="button" value="Agregar Institución" id="add_ExpenseRow" /></center>
            
                <div class="div-btn-guardar" style="margin-top:20px">
                    <center>
                    <table width="600" id="botones"><tr>
                    <td><input type="button" value="Guardar" id="guardar" class="guardar"/></td> 
					<td align='right'><input type="button" id="regresar" value="Regresar" name="regresar" style="background:transparent;color:#555;margin-left:20px" /></td>
                    </tr>
                    </table>	           
                    </center>
                </div>	
             </form>
        </div><!-- END form_container -->
  </body>
</html>