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

    if(!empty($_REQUEST['idinstitucion']))
    {
        $id = $_REQUEST['idinstitucion'];  
    }
    function limpiarCadena($cadena) {
         $cadena = (ereg_replace('[^ A-Za-z0-9_ñÑáéíóúÁÉÍÓÚ\s]', '', $cadena));
         return $cadena;
    }
switch($_REQUEST['Action_id']){
    case 'Ciudades':{
        $Pais= $_POST['Pais'];
        Ciudades($db,$Pais);
    }break;
    case 'SaveData':
    {
    $nombreubicacion               = $_POST['nombreubicacion']; 
    $estado                        = $_POST['estado'];
    $idinstitucion                 = $_POST['idinstitucion'];
    $ciudad                        = $_POST['ciudad'];
    $direccion                     = $_POST['direccion'];
    $Pais                          = $_POST['pais'];
    $ciudadExtranjera              = $_POST['CiudadExtranjera'];
    
    $nombreubicacion = limpiarCadena(filter_var($nombreubicacion,FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
    $estado = limpiarCadena(filter_var($estado,FILTER_SANITIZE_NUMBER_INT));
    $idinstitucion = limpiarCadena(filter_var($idinstitucion,FILTER_SANITIZE_NUMBER_INT));
    $ciudad = limpiarCadena(filter_var($ciudad,FILTER_SANITIZE_NUMBER_INT));
    $Pais = limpiarCadena(filter_var($Pais,FILTER_SANITIZE_NUMBER_INT));
    $ciudadExtranjera = limpiarCadena(filter_var($ciudadExtranjera,FILTER_SANITIZE_NUMBER_INT));
        
    $sql1="SELECT count(IdUbicacionInstitucion) FROM UbicacionInstituciones WHERE InstitucionConvenioId = '".$idinstitucion."' AND NombreUbicacion = '".$nombreubicacion."'";
        if($Consulta=$db->Execute($sql1)===true)
        {
            $a_vectt['val']			=false;
            $a_vectt['descrip']		='Error al Consultar..';
            echo json_encode($a_vectt);
            exit;
        }
        $valores = $db->Execute($sql1);
        $datos =  $valores->getarray();
        if (!empty($datos[0][0]))
        {
            //$descrip = $sql1;
            $descrip = 'La ubicacion que esta intentando ingresar ya se encuentra registrada.';
        }else
        {
            if($ciudadExtranjera==null)
            {
                $sql2="insert into UbicacionInstituciones(NombreUbicacion,codigoestado, InstitucionConvenioId, DomicilioUbicacion, idciudad, idpais, Direccion ) 
                values('".$nombreubicacion."', '".$estado."','".$idinstitucion."', '', '".$ciudad."', '".$Pais."', '".$direccion."')"; 
                $agregar = $db->Execute($sql2);
                $descrip = 'La ubicacion fue agregada' ;
            }
            else
            { 
                $sqlciudadextranjera = "select iddepartamento, nombredepartamento from departamento where  idpais ='".$Pais."'";
                $valoresciudadextranjera = $db->execute($sqlciudadextranjera);
                $datosciudadextranjera =  $valoresciudadextranjera->getarray();
                $totaldatos=count($datosciudadextranjera); 
                if($totaldatos == 0)
                {
                    $sqlpais = "select nombrecortopais from pais where idpais = '".$Pais."'";
                    $valorespais = $db->execute($sqlpais);
                    foreach($valorespais as $datospais)
                    {
                        $nombrepais = $datospais['nombrecortopais'];
                    }
                    
                    $sqlnuevodepartamentoestranjero ="INSERT INTO departamento (nombrecortodepartamento, nombredepartamento, idpais, codigosapdepartamento, codigoestado, idregionnatural) VALUES ('".$nombrepais."', '".$nombrepais."', '".$Pais."', '0".$Pais."', '100', '1')";
                    $agregar = $db->execute($sqlnuevodepartamentoestranjero); 
                    
                    $sqldepartamentoextranjero = "select iddepartamento, nombredepartamento from departamento where idpais = '".$Pais."'";
                    $valoresdepartamento = $db->execute($sqldepartamentoextranjero);
                    
                    foreach($valoresdepartamento as $datosdepartamento)
                    {
                        $departamentoid = $datosdepartamento['iddepartamento'];
                        $departamentoNombre = $datosdepartamento['nombredepartamento'];
                        
                        $sqlciudadnueva = "select idciudad from ciudad where iddepartamento = '".$departamentoid."' and nombreciudad = '".$ciudadExtranjera."'";
                        $valoresciudadnueva = $db->execute($sqlciudadnueva);
                        $datosciudadnueva =  $valoresciudadnueva->getarray();
                        $totaldatosciudadnueva=count($datosciudadnueva);
                        if($datosciudadnueva == 0)
                        {
                            $sqlnuevaciudad = "insert into ciudad (nombrecortociudad, nombreciudad, iddepartamento, codigosapciudad, codigoestado) values 
                            ('".$ciudadExtranjera."', '".$ciudadExtranjera."', '".$departamentoid."', '0".$departamentoid."', '100')";
                            $agregarciudad = $db->execute($sqlnuevaciudad);
                            
                            $sqlconsultaciudad = "select idciudad from ciudad where nombreciudad = '".$ciudadExtranjera."' and iddepartamento = '".$departamentoid."' and codigoestado ='100'";
                            $valoresconsultaciudad = $db->execute($sqlconsultaciudad);
                            foreach($valoresconsultaciudad as $datosconsultaciudad)
                            {
                                $sql2="insert into UbicacionInstituciones(NombreUbicacion,codigoestado, InstitucionConvenioId, idciudad, idpais, Direccion ) values('".$nombreubicacion."', '".$estado."','".$idinstitucion."', '".$datosconsultaciudad['idciudad']."', '".$Pais."', '".$direccion."')"; 
                                $agregar = $db->Execute($sql2);
                                $descrip = 'La ubicacion fue agregada';
                                //$descrip =  $sql2;   
                            }
                        }else
                        {  
                            $sqlconsultaciudad = "select idciudad from ciudad where nombreciudad = '".$ciudadExtranjera."' and iddepartamento = '".$departamentoid."' and codigoestado ='100'";
                            $valoresconsultaciudad = $db->execute($sqlconsultaciudad);
                            foreach($valoresconsultaciudad as $datosconsultaciudad)
                            {
                                $sql2="insert into UbicacionInstituciones(NombreUbicacion,codigoestado, InstitucionConvenioId, idciudad, idpais, Direccion) values('".$nombreubicacion."', '".$estado."','".$idinstitucion."', '".$datosconsultaciudad['idciudad']."', '".$Pais."', '".$direccion."')"; 
                                $agregar = $db->Execute($sql2);
                                $descrip = 'La ubicacion fue agregada';
                                //$descrip =  $sql2;   
                            } 
                        }
                    }      
                }else
                {
                    $departamentoid = $datosciudadextranjera[0]['iddepartamento'];
                    $departamentoNombre = $datosciudadextranjera[0]['nombredepartamento'];
                    
                    $sqlciudadnueva = "select idciudad from ciudad where iddepartamento = '".$departamentoid."' and nombreciudad = '".$ciudadExtranjera."'";
                    $valoresciudadnueva = $db->execute($sqlciudadnueva);
                    $datosciudadnueva =  $valoresciudadnueva->getarray();
                    $totaldatosciudadnueva=count($datosciudadnueva);
                                         
                    if($totaldatosciudadnueva == 0)
                    {
                        $sqlnuevaciudad = "insert into ciudad (nombrecortociudad, nombreciudad, iddepartamento, codigosapciudad, codigoestado) values 
                        ('".$ciudadExtranjera."', '".$ciudadExtranjera."', '".$departamentoid."', '0".$departamentoid."', '100')";
                        $agregarciudad = $db->execute($sqlnuevaciudad);
                                               
                        $sqlconsultaciudad = "select idciudad from ciudad where nombreciudad = '".$ciudadExtranjera."' and iddepartamento = '".$departamentoid."' and codigoestado ='100'";
                        $valoresconsultaciudad = $db->execute($sqlconsultaciudad);
                        $datosconsultaciudad =  $valoresconsultaciudad->getarray();
                        $totaldatosconsultaciudad=count($datosconsultaciudad);
                        
                        foreach($valoresconsultaciudad as $datosconsultaciudad)
                        {
                            $sql2="insert into UbicacionInstituciones(NombreUbicacion,codigoestado, InstitucionConvenioId, idciudad, idpais, Direccion) values('".$nombreubicacion."', '".$estado."','".$idinstitucion."', '".$datosconsultaciudad['idciudad']."', '".$Pais."', '".$direccion."')"; 
                            $agregar = $db->Execute($sql2);
                            $descrip = 'La ubicacion y la ciudad fueron agregadas';
                            //$descrip =  $sql2;   
                        }
                    }else
                    {
                        $sqlconsultaciudad = "select idciudad from ciudad where nombreciudad = '".$ciudadExtranjera."' and iddepartamento = '".$departamentoid."' and codigoestado ='100'";
                        $valoresconsultaciudad = $db->execute($sqlconsultaciudad);
                        $datosconsultaciudad =  $valoresconsultaciudad->getarray();
                        $totaldatosconsultaciudad=count($datosconsultaciudad);
                        
                       foreach($valoresconsultaciudad as $datosconsultaciudad)
                        {
                            $sql2="insert into UbicacionInstituciones(NombreUbicacion,codigoestado, InstitucionConvenioId, idciudad, idpais, Direccion) values('".$nombreubicacion."', '".$estado."','".$idinstitucion."', '".$datosconsultaciudad['idciudad']."', '".$Pais."', '".$direccion."')"; 
                            $agregar = $db->Execute($sql2);
                            $descrip = 'La ubicacion fue agregada';
                            //$descrip =  $sql2;   
                        }
                    }
                }
            }
        }
        $a_vectt['val']			=true;
        $a_vectt['descrip']		=$descrip;
        echo json_encode($a_vectt);
        exit;
    }break;
}
function Ciudades($db,$Pais)
{
    if($Pais<> 1)
    {
            $sqlciudadextranjera="SELECT c.idciudad, c.nombreciudad FROM ciudad c JOIN departamento d ON d.iddepartamento = c.iddepartamento
JOIN pais p ON p.idpais = d.idpais WHERE p.idpais = '".$Pais."' AND d.codigoestado = '100' AND d.iddepartamento <> '216' ORDER BY d.nombredepartamento ASC";
            $valoresCiudadextranjera = $db->execute($sqlciudadextranjera);
            $datos_ciudades =  $valoresCiudadextranjera->getarray();
            if($datos_ciudades[0][0]==null)
            {
                ?><td>Ciudad:</td>
                
                <td>
                <input type="text" name="CiudadExtranjera" id="CiudadExtranjera" />
                </td>           
                <?php
                exit;
            }
            else
            {
                ?>
                <td>Ciudad:</td>
                <td>  
                <select name="ciudad" id="ciudad">   
                <?php
                foreach($valoresCiudadextranjera as $datosCiudadExtranjera)
                {              
                    ?>
                    <option value="<?php echo $datosCiudadExtranjera['idciudad'];?>"><?php echo  $datosCiudadExtranjera['nombreciudad'];?></option>           
                    <?php
                }
                ?>
                    </select>
                    <input type="button" value="Nueva Ciudad" onclick="Nuevaciudad()" /></td>
                    </td>
                    
                    <td id="nueva_ciudad">
                    </td>

                <?php 
                exit;
            }
    }else
    {
        $sqlciudad = "select c.idciudad, c.nombreciudad from ciudad c JOIN departamento d ON d.iddepartamento = c.iddepartamento JOIN pais p on p.idpais = d.idpais
where p.idpais = '".$Pais."' and d.codigoestado = '100' and d.iddepartamento <> '216' ORDER BY c.nombreciudad ASC";
        $valoresciudad = $db->execute($sqlciudad);
         ?><td>Ciudad:</td>    
                <td>
                <select name="ciudad" id="ciudad">   
         <?php
        foreach($valoresciudad as $datosciudad)
        {
            ?>
            <option value="<?php echo $datosciudad['idciudad'];?>"><?php echo $datosciudad['nombreciudad'];?></option>           
            <?php
        }
         ?>
                </select>
                </td>   
         <?php 
      exit;
    }     
}//function Ciudades        
 ?> 
<html>
    <head>
        <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleDatos.css" type="text/css" /> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Nueva Ubicación Institución</title>
        
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/functions.js"></script>
        <script type="text/javascript" language="javascript" src="js/funcionesInstituciones.js"></script>   
        <script>
        function Nuevaciudad(){
            $('#nueva_ciudad').html("<td>Ciudad:</td><td><input type='text' name='CiudadExtranjera' id='CiudadExtranjera' /></td>");
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
            <h1>NUEVA UBICACIÓN INSTITUCIÓN</h1>
        </center>
        <form  id="nuevaubicacion" action="../convenio/NuevaUbicacionInstitucion.php" method="post" enctype="multipart/form-data" >
        <input type="hidden" id="Action_id" name="Action_id" value="SaveData" />
        <input type="hidden" id="idinstitucion" name="idinstitucion" value="<?php echo $id?>" />
            <table cellpadding="3" width="60%" border="0" align="center">
                <tr>
                    <td colspan="6">
                        <hr />
                    </td>
                </tr>
                <tr>
                <?php $sqlinst = "select NombreInstitucion from InstitucionConvenios where InstitucionConvenioId = '".$id."'";
                $datos = $db->execute($sqlinst);
                $nombreinstitucion = $datos->fields['NombreInstitucion'];
                
                echo "<td aling='center' colspan='6'><center><strong>".$nombreinstitucion."</strong></center><td>";
                ?>
                </tr>
                <tr>
                    <td colspan="6">
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td>Nombre Ubicación:<span style="color: red;">*</span></td>
                    <td>
                        <input type="text" name="nombreubicacion" id="nombreubicacion" value="<?php echo $nombreubicacion ?>" size="50" class="required" onkeypress="return val_texto(event)"/>
                    </td>
                     <td>Dirección:</td>
                        <td>
                            <input type="text" name="direccion" id="direccion" onkeypress="return val_dirrecion(event)"/>
                     </td>
                   
                    </tr>
                    <tr>
                        <td>País:
                        </td>
                        <td>
                            <select name="pais" id="pais" onchange="cambiarciudad()">
                                <option></option>
                                <?php
                                    $slqpais = "SELECT idpais, nombrepais from pais where codigoestado ='100'";
                                    $valorespais = $db->execute($slqpais);
                                    foreach($valorespais as $datospais)
                                    {
                                        ?>
                                            <option value="<?php echo $datospais['idpais']?>"><?php echo $datospais['nombrepais']?></option>
                                        <?php
                                    }
                                ?>                            
                            </select>
                        </td>
                        <td>Estado:</td>
                    <td>
                       <select name="estado" id="estado">
                       <option value=""></option>
                        <?php 
                            $sqlestado = "select codigoestado, nombreestado from estado where codigoestado <> '300'";
                            $valoresestado = $db->execute($sqlestado);
                            foreach($valoresestado as $datosetado)
                            {
                                ?>
                                <option value="<?php echo $datosetado['codigoestado']?>"><?php echo $datosetado['nombreestado']?></option>
                                <?php
                            }
                        ?>
                        </select> 
                    </td>
                    </tr>
                    <tr id="Tr_Ciudad">
                        <td>Ciudad:</td>
                        <td>
                            <select name="carrera" id="carrera" required="required" >
                            <option value=""></option>                           
                            </select>
                        </td>
                    </tr>   
                <tr>
                    <td colspan="6">
                        <hr />
                    </td>
                </tr>
               
            </table>
            <center>
                <table width="600" id="botones">
                <tr><td><input type="button" value="Guardar" onclick="validarDatosUbicacion('#nuevaubicacion');" /></td>
                 <td align='right'><input type="button" value="Regresar" onclick="Regresar()" /></td></tr>
                </table>
            </center>  
        </form>
    </div>
  </body>
</html>