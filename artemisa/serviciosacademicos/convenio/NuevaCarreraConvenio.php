<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once (realpath(dirname(__FILE__)).'/../EspacioFisico/templates/template.php');
    
    $db = getBD();
    $sqlS = "select idusuario from usuario where usuario = '".$_SESSION['MM_Username']."'";
    $usuario = $db->GetRow($sqlS);
    $user = $usuario['idusuario'];
    
    $idconvenio = $_REQUEST['idconvenio'];
    if(!isset ($idconvenio)){
        
        echo "<script>alert('Error de ingreso programa academico'); location.href='ConveniosActivos.php'; </script>";    
    }
    $txtIdPrestacion = $_REQUEST['txtTipoConvenio'];
    
    $busqueda = $_GET['busqueda'];
    function limpiarCadena($cadena) {
         $cadena = (ereg_replace('[^ A-Za-z0-9_ñÑáéíóúÁÉÍÓÚ\s]', '', $cadena));
         return $cadena;
    }

    function Listainstituciones($db)
    {
        $lista = "";
        $sqlinstituciones= "select InstitucionConvenioId, NombreInstitucion from InstitucionConvenios where CodigoEstado = '100'";
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
    
    
    if($_POST['Action_id']=='SaveData')
    {
        $tipocontraprestacion          = $_POST['busqueda2']; 
        $estado                        = '100';
        $idconvenio                    = $_POST['idconvenio'];
        $FechaCreacion                 = date("Y-m-d H:i:s");
        $UsuarioCreacion               = $user;
        $contador                      = $_POST['contador'];
        
        $tipocontraprestacion = limpiarCadena(filter_var($tipocontraprestacion,FILTER_SANITIZE_NUMBER_INT));
        $idconvenio = limpiarCadena(filter_var($idconvenio,FILTER_SANITIZE_NUMBER_INT));
        $contador = limpiarCadena(filter_var($contador,FILTER_SANITIZE_NUMBER_INT));
        $UsuarioCreacion = limpiarCadena(filter_var($UsuarioCreacion,FILTER_SANITIZE_NUMBER_INT));
        
        $contador = $contador-1;
       $descrip ='';
       for($i=1; $contador >= $i; $i++)
       {   
            $carrera[$i] = $_POST['carrera'.$i];
            if(!empty($carrera))
            {
                $sql1="SELECT count(idconveniocarrera) FROM conveniocarrera WHERE ConvenioId = '".$idconvenio."' AND codigocarrera = '". $carrera[$i]."' and codigoestado = '".$estado."'";
                $valores = $db->Execute($sql1);
                $datos =  $valores->fields['count(idconveniocarrera)'];
                /*if ($datos == 0)
                {*/
                    $sql2="insert into conveniocarrera(ConvenioId, codigocarrera, codigoestado, IdContraprestacion, UsuarioCreacion, FechaCreacion) values('".$idconvenio."', '". $carrera[$i]."','".$estado."', '".$tipocontraprestacion."', '".$user."', '".$FechaCreacion."')";
                    $agregar = $db->Execute($sql2);
                    $descrip = 'La carrera-convenio fue agregada';
                    //$descrip.= $sql2." ---- ";
               /* }else
                {
                    $descrip.= "La carrera numero ".$carrera[$i]." no se pudo ingresar......";
                }*/
            }        
        }
          
    $a_vectt['val']			=true;
    $a_vectt['descrip']		=$descrip;
    echo json_encode($a_vectt);
    exit;
    }//if($_POST['Action_id']=='SaveData')       
?>
<html>
    <head>
        <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleDatos.css" type="text/css" /> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Nueva Carrera Convenio</title>
        
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/functions.js"></script>
        <script type="text/javascript" language="javascript" src="js/funcionesConvenios.js"></script>
        <script   language="javascript">
            function CambiarContraprestacion()
            {
                //tomo el valor del select del tipo elegido
                var tipo
                tipo = $('#nuevacarreraconvenio #tipocontraprestacion').val();
                var idconvenio = $('#nuevacarreraconvenio #idconvenio').val();
                //miro a ver si el tipo estï¿½ definido
                if (tipo>0)
                {
                    window.location.href="../convenio/NuevaCarreraConvenio.php?busqueda="+tipo+"&idconvenio="+idconvenio;
                }else
                {
                    window.location.href="../convenio/NuevaCarreraConvenio.php?idconvenio="+idconvenio;
                }
            }
    
        </script>
    </head>
    <body> 
        <div id="container">
        <center>
            <h1>NUEVO PROGRAMA ACADEMICO CONVENIO</h1>
        </center>
        <form  id="nuevacarreraconvenio" name="nuevacarreraconvenio" action="../convenio/DetalleConvenio.php" method="post" enctype="multipart/form-data" >
        <input type="hidden" id="Action_id" name="Action_id" value="SaveData" />
        <input type="hidden" id="busqueda2" name="busqueda2" value="<?php if( $txtIdPrestacion != "2" && $txtIdPrestacion != "5"){echo $busqueda; }else{ $busqueda = ""; echo $busqueda;}?>" />
        <input type="hidden" id="idconvenio" name="idconvenio" value="<?php echo $idconvenio?>" />
        <input type="hidden" id="txtTipoConvenio" name="txtTipoConvenio" value="<?php echo $txtIdPrestacion; ?>" />
             <table cellpadding="3" width="60%" border="0" align="center" >
                 <tr>
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                    <?php 
                        $sql = "select NombreConvenio from Convenios where ConvenioId = '".$idconvenio."'";
                        $Consulta=$db->GetRow($sql);
                    ?>
                    <center><?php echo $Consulta['NombreConvenio']; ?></center>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
                <tr id="dvNuevaCarrera" align='center'>
                    <td>Contraprestaciones Disponibles:</td>
                    <td>
                        <select name="tipocontraprestacion" id="tipocontraprestacion" onChange="CambiarContraprestacion()" >
                        <option value="0">Seleccionar</option>
                        <?php 
                            $sqlcarrera = "SELECT c.IdContraprestacion, u.NombreUbicacion, c.IdTipoPracticante, sc.nombretipocontraprestacion, tp.NombrePracticante, "
                                    . "c.ValorContraprestacion, tpc.NombrePagoContraprestacion FROM Contraprestaciones c, UbicacionInstituciones u, "
                                    . "siq_contraprestacion sc, TipoPracticantes tp, TipoPagoContraprestaciones tpc "
                                    . "WHERE c.ConvenioId = '".$idconvenio."' AND c.codigoestado = '100' "
                                    . "AND u.IdUbicacionInstitucion = c.IdUbicacionInstitucion "
                                    . "AND sc.idsiq_contraprestacion = c.idsiq_contraprestacion "
                                    . "AND tp.IdTipoPracticante = c.IdTipoPracticante and c.IdTipoPagoContraprestacion = tpc.IdTipoPagoContraprestacion";                            
                            
							//echo $sqlcarrera;
							
                            $valorcarrera = $db->execute($sqlcarrera);
                            $datoscarrera = $valorcarrera->fields['IdContraprestacion'];
							
							
							//validaticiones de contraprestaciones creadas.
							if($datoscarrera ==''){
								if( $txtIdPrestacion != "2" && $txtIdPrestacion != "5" ){
								echo '<script language="javascript">alert(" El convenio no tiene contraprestaciones disponibles.");</script>';
								echo '<script>document.location="DetalleConvenio.php?Detalle='.$idconvenio.'";</script>';
								}
								 
							}else
                            foreach($valorcarrera as $datocarreras)
                            {
                                if($datocarreras['IdContraprestacion'] == $_GET['busqueda'])
                                {
                                  ?>
                                <option value="<?php echo $datocarreras['IdContraprestacion']?>" selected="selected"><?php echo $datocarreras['nombretipocontraprestacion']." ".$datocarreras['ValorContraprestacion']."-".$datocarreras['NombrePagoContraprestacion']." ".$datocarreras['NombrePracticante'];?></option>
                                 <?php                       
                                 }else
                                 {
                                    ?>
                                <option value="<?php echo $datocarreras['IdContraprestacion']?>" ><?php echo $datocarreras['nombretipocontraprestacion']." ".$datocarreras['ValorContraprestacion']."-".$datocarreras['NombrePagoContraprestacion']." ".$datocarreras['NombrePracticante'];?></option>
                                 <?php 
                                 }                                   
                            }
                            ?>                                
                        </select>
                    </td>
                    </tr>
                    <tr>
                    <td colspan="4">
                        <hr />
                    </td>
                    </tr>
                    </table>
                       <?php
                       		
                            if(isset($_GET['busqueda']) || isset($txtIdPrestacion))
                            {
                                $sqlCarreratipo = "select IdTipoPracticante from Contraprestaciones where IdContraprestacion = '".$_GET['busqueda']."' and codigoestado = '100'";
                                $valorescarrera = $db->execute($sqlCarreratipo);
                                foreach($valorescarrera as $datoscarrera)
                                {
                                    switch($datoscarrera['IdTipoPracticante'])
                                    {
                                        case  1;
                                        //echo 'Pre-grado';
                                        $modalidad = '200';
                                        break;
                                        
                                        case 2;
                                        //echo 'Post-grado';
                                        $modalidad = '300';
                                        break;
                                        
                                        case 3;
                                        //echo 'Internado';
                                        $modalidad = '400';
                                        break;
                                    }    
                                }
                           ?>
                    <table id="expense_table" cellpadding="3" width="60%" border="0" align="center">
                    <tr>
                         <th>
                            <h3>Modalidad</h3>
                        </th>
                        <td>
                            <select id="modalidad">
                                <option value="0" selected="selected">Seleccione</option>
                                <?php
                                if( $txtIdPrestacion != "2" && $txtIdPrestacion != "5" ){
	                                $SQL = "SELECT 	codigomodalidadacademica, nombremodalidadacademica FROM modalidadacademica WHERE codigomodalidadacademica = '".$modalidad."'";
	                                if($Modalidades=&$db->Execute($SQL)===false){
	                                    echo 'Error en consulta a base de datos';
	                                    die; 
	                                }
	                                if(!$Modalidades->EOF)
	                                {
	                				    while(!$Modalidades->EOF)
	                                    {
	                    				    echo '<option value="'.$Modalidades->fields['codigomodalidadacademica'].'">'.$Modalidades->fields['nombremodalidadacademica'].'</option>';
	                    					$Modalidades->MoveNext();
	                					 }
	                				 }
								}else{
									$SQL = "SELECT 	codigomodalidadacademica, nombremodalidadacademica FROM modalidadacademica";
	                                if($Modalidades=&$db->Execute($SQL)===false){
	                                    echo 'Error en consulta a base de datos';
	                                    die; 
	                                }
	                                if(!$Modalidades->EOF)
	                                {
	                				    while(!$Modalidades->EOF)
	                                    {
	                    				    echo '<option value="'.$Modalidades->fields['codigomodalidadacademica'].'">'.$Modalidades->fields['nombremodalidadacademica'].'</option>';
	                    					$Modalidades->MoveNext();
	                					 }
	                				 }
								}                                                       
                                ?>
                            </select>
                        </td>                          					
                    </tr>
                    <tr id="Div_Facultad">
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
                </tr>  
                <tr>
                    <td colspan="4">
                        <hr />
                        <?php 
                        }
                        ?> 
                   </td>
                </tr>
            </table>
            <center>
            <table width="600" id="botones"><tr>
            <td><input type="button" value="Guardar" onclick="validarDatosCarreraConvenio('#nuevacarreraconvenio');" /></td>
            <td align='right'><form action="DetalleConvenio.php" method="post">
            <input type="hidden" id="Detalle" name="Detalle" value="<?php echo $idconvenio?>" />
            <input type="submit" value="Regresar" />
            </form></td>
            </tr>
            </table>
            </center>  
        </form>
    </div>
    <?php
       
    ?>
  </body>
</html>