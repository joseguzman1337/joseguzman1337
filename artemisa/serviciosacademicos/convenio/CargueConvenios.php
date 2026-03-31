<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once ('../EspacioFisico/templates/template.php');
    //include_once ('./Permisos/class/PermisosConvenio_class.php'); $C_Permisos = new PermisosConvenio();
    include_once('../mgi/Menu.class.php');        $C_Menu_Global  = new Menu_Global();
    //include_once('_menuConvenios.php');

    $db = getBD();
    $SQL_User='SELECT idusuario as id, codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';        
    if($Usario_id=&$db->GetRow($SQL_User)===false){
    		echo 'Error en el SQL Userid...<br>'.$SQL_User;
    		die;
	}
    function limpiarCadena($cadena) {
         $cadena = (ereg_replace('[^ -\s]', '', $cadena));
         return $cadena;
    }

    $userid=$Usario_id['id'];
  require_once('../educacionContinuada/Excel/reader.php');

    $sqlS = "select idusuario from usuario where usuario = '".$_SESSION['MM_Username']."'";
    $resultS = $db->GetRow($sqlS);    

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>cargue convenios</title>
        <link rel="stylesheet" type="text/css" href="../mgi/css/styleOrdenes.css" media="screen" />
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
		<script type="text/javascript" language="javascript" src="../mgi/js/functions.js"></script>
        <link type="text/css" href="../educacionContinuada/css/normalize.css" rel="stylesheet">
		<link media="screen, projection" type="text/css" href="../educacionContinuada/css/style.css" rel="stylesheet">
		<link media="screen, projection" type="text/css" href="css/style.css" rel="stylesheet"> 
    </head>
    <body class="body">
    <div id="pageContainer">
        <div id="container" class="wrapper" align="center">
        
			<h4>Cargue de covenios</h4>   	
            <form name="f1" action="../convenio/CargueConvenios.php" method="POST" enctype="multipart/form-data">
                <label>Archivo Convenios:</label>
                <input type="file" class="required" value="" name="file" id="file" /><br/><br/> 
                <label>Seleccione</label>
                <select name="tipo" id='tipo'>
                <option value="0"></option>
                <option value="1">Convenios</option>
                <option value="2">Instituciones</option>
                </select><br/><br/>                   
                <input name="buscar" type="submit" value="Cargar Datos" />
            </form>
    
    <?php
	
    if(isset($_POST['buscar']) &&  isset($_FILES))
    {
        switch($_POST['tipo'])
        {
            case '1':{
        ?>
        <hr /> 
        <br />
        <table border='2' align="center">
            <thead>
                <td><strong>N#</strong></td>
                <td><strong>numeroconvenio</strong></td>
                <td><strong>institucion</strong></td>
                <td><strong>Domicilio</strong></td>
                <td><strong>Estado</strong></td>
                <td><strong>Vigencia</strong></td>
                <td><strong>Fecha Inicio</strong></td>
                <td><strong>Fecha fin</strong></td>
                <td><strong>Renovacion</strong></td>
            </thead>  
        <tbody>
        <?php
        
       //TOCA PROCESAR EL ARCHIVO CON LAS ORDENES
		$data = new Spreadsheet_Excel_Reader();
        //echo '<pre>'; print_r($data);
		//echo "<pre>";print_r($_REQUEST); 
		//echo "<br/><br/><pre>";print_r($_FILES); die;
		$data->setOutputEncoding('CP1251');
		$data->read($_FILES["file"]["tmp_name"]); 
        $filas = $data->sheets[0]['numRows'];
		//var_dump($filas); die;
        //echo '<pre>'; print_r($filas);
		//se asume la primera como titulo
        $contador=0;
		$errores = 0;
        $x=1;
		for ($z = 3; $z <= $filas; $z++) 
        {
            if($data->sheets[0]['cells'][$z][1] ==! '')
            {
            $fields['numeroconvenio']=$data->sheets[0]['cells'][$z][1];
            $fields['institucion']=utf8_encode($data->sheets[0]['cells'][$z][2]);
            $fields['Domicilio']= utf8_encode($data->sheets[0]['cells'][$z][3]);            
            $fields['Estado']=utf8_encode($data->sheets[0]['cells'][$z][4]);
            $fields['Vigencia']=utf8_encode($data->sheets[0]['cells'][$z][5]);
            $fields['fechainicio']=$data->sheets[0]['cells'][$z][6];            
            $fields['fechafin']=$data->sheets[0]['cells'][$z][7];
            $fields['renovacion']=utf8_encode($data->sheets[0]['cells'][$z][8]);
            $fields['solicitante']=utf8_encode($data->sheets[0]['cells'][$z][9]);
            $fields['idsiq_tipoconvenio']=utf8_encode($data->sheets[0]['cells'][$z][10]);
            
            //echo '<pre>';print_r($fields);die;
            
            $fechaini = explode("/", $fields['fechainicio']);
            $dateinicial = $fechaini['2'].'-'.$fechaini['1'].'-'.$fechaini['0'];
                       
            if($fields['fechafin']!='Indefinido' || $fields['fechafin']!='00/00/0000')
            {
                $fechafin = explode("/", $fields['fechafin']);
                $datefinal = $fechafin['2'].'-'.$fechafin['1'].'-'.$fechafin['0'];    
            }else
            {
                $datefinal = '0000-00-00';
            }
            
            $sqlvigencia = "select idsiq_duracionconvenio from siq_duracionconvenio where nombreduracion like '%".ltrim(rtrim($fields['Vigencia']))."%'";            
            $resultadovigencia = $db->GetRow($sqlvigencia);
            $vigencia = $resultadovigencia['idsiq_duracionconvenio'];                        
            
            switch($fields['Estado'])
            {
                case 'Vigente':
                {
                    $estado = '1';
                }break;
                case 'En Proceso':
                {
                    $estado = '2';
                }break;
                case 'Anulado':
                {
                    $estado = '3';
                }break;
                case 'Vencido':
                {
                    $estado = '4';
                }break;            
            }
                        
            $sqltipoconvenio = "select idsiq_tipoconvenio from siq_tipoconvenio where nombretipoconvenio LIKE '%".$fields['idsiq_tipoconvenio']."%'";
            $resulttipoconvenio = $db->GetRow($sqltipoconvenio);
            $tipoconvenio= $resulttipoconvenio['idsiq_tipoconvenio'];
            
            $sqlvalidacion = "select ConvenioId from Convenios where CodigoConvenio = '".$fields['numeroconvenio']."'";            
            $result = $db->GetRow($sqlvalidacion);
                       
            if($result['ConvenioId']=='' || $fields['numeroconvenio']=='0000')
            {
                if(!empty($fields['institucion']))
                {
                    $sqlnombre = "select ConvenioId from Convenios where NombreConvenio ='".$fields['institucion']."' and CodigoConvenio='".$fields['numeroconvenio']."'";
                    $resultnombre = $db->GetRow($sqlnombre);
                    
                    if($resultnombre[ConvenioId]=='')
                    {
                    
                    if(strpos($fields['Domicilio'], 'Bt') !== false)
                    {
                        $fields['Domicilio'] ='Bogota';
                    }
                    
                    $sqlpais = "SELECT b.idpais FROM ciudad a INNER JOIN departamento b on b.iddepartamento = a.iddepartamento WHERE a.nombreciudad LIKE '%".$fields['Domicilio']."%'";
                    //echo $sqlpais.'<br>';
                    $resultpais = $db->GetRow($sqlpais);
                    
                    if($resultpais['idpais']=='')
                    {
                        $sqlpaisextranjero = "select idpais from pais where nombrepais like '%".trim($fields['Domicilio'])."%'";
                        //echo $sqlpaisextranjero.'<br>';
                        $resultpais = $db->GetRow($sqlpaisextranjero);
                    }
                    
                    if($resultpais['idpais']!='')
                    {
                        $sqlinstitucion = "select InstitucionConvenioId from InstitucionConvenios i where i.NombreInstitucion = '".$fields['institucion']."'";
                        $resultinstitucion = $db->GetRow($sqlinstitucion);
                        
                        //validacion de la institucion, si la institucion existe y esta creada procede a crear el nuevo convenio.                    
                        if($resultinstitucion['InstitucionConvenioId']!='')
                        {
                            $tiporenovaciones = "Select TipoRenovacionId from TipoRenovaciones where NombreTipoREnovacion LIKE '%".trim($fields['renovacion'])."%'";
                            $tipore = $db->GetRow($tiporenovaciones);
                                                        
                            $fechacreacion = date("Y-m-d H:i:s");
                            
                            $sqlinsert="INSERT INTO Convenios (NombreConvenio, PaisId, CodigoConvenio, FechaInicio, FechaFin, idsiq_tipoconvenio, InstitucionConvenioId, idsiq_estadoconvenio, idsiq_duracionconvenio, TipoRenovacionId, UsuarioCreacion, FechaCreacion, codigofacultad, SupervisorBosque)values ('".$fields['institucion']."', '".$resultpais['idpais']."', '".$fields['numeroconvenio']."', '".$dateinicial."', '".$datefinal."', '".$tipoconvenio."', '".$resultinstitucion['InstitucionConvenioId']."', '".$estado."','".$vigencia."', '".$tipore['TipoRenovacionId']."', '".$resultS['idusuario']."', '".$fechacreacion."', '10', '".$fields['solicitante']."')";                           
                            $result=$db->Execute($sqlinsert); 
                            echo '<tr><td>'.$x.'</td>';
                            echo '<td>'.$fields['numeroconvenio'].'</td>';
                            echo '<td>'.$fields['institucion'].'</td>';
                            echo '<td>'.$fields['Domicilio'].'</td>';
                            echo '<td>'.$fields['Estado'].'</td>';
                            echo '<td>'.$fields['Vigencia'].'</td>';
                            echo '<td>'.$fields['fechainicio'].'</td>';
                            echo '<td>'.$fields['fechafin'].'</td>';
                            echo '<td>'.$fields['renovacion'].'</td></tr>';
                            echo "<tr><td colspan='12' align='center'>La institucion fue creada. <strong>".$fields['institucion']."</strong></td></tr>";
                             
                        }else
                        {                        
                          echo "<tr><td>".$x."</td><td colspan='11' align='left'>La institucion no se encuentra creada. <strong>".$fields['institucion']."</strong></td></tr>";  
                        }
                    }else
                    {
                        echo "<tr><td>".$x."</td><td colspan='11' align='left'>El convenio tiene errores en el domicilio o la ciudad o pais no existe. <strong>".$fields['numeroconvenio']." ".$fields['institucion']."</strong></td></tr>";
                    }//domicilio
                }else
                {
                    
                 //  $sql = "UPDATE Convenios SET ConvenioId = '', NombreConvenio = '', PaisId = '', CodigoConvenio = '', FechaInicio = '', FechaFin = '', InstitucionConvenioId = '', idsiq_tipoconvenio = '', renovacionautomatica = '', TipoRenovacion = '', idsiq_duracionconvenio = '', idsiq_estadoconvenio = '', UsuarioCreacion = '', FechaCreacion = '', UsuarioModificacion = '', FechaModificacion = '', RCE = '', AfiliacionArl = '', AfiliacionSgsss = '', FechaClausulaTerminacion = '', Estado = '', FechaRespuesta = '', Representante = '', SupervisorBosque = '', SupervisorInstitucion = '', RutaArchivo = '', RutaArchivoSolicitdAcuerdo = '', RutaArchivoSolicitdProrroga = '',  PRB = '', NumeroActaConsejo = '', FechaActa = '', tipoSolicitud = '', Ambito = '', codigofacultad = '' WHERE (ConvenioId = '')";
                    echo "<tr><td>".$x."</td><td colspan='11' align='left'>El convenio ya existe. <strong>".$fields['numeroconvenio']." ".$fields['institucion']."</strong></td></tr>";
                }//validacion de convenio 0000
                
                }else
                {
                    echo "<tr><td>".$x."</td><td colspan='11' align='left'>El nombre del convenio tiene errores.<strong>".$fields['numeroconvenio']." ".$fields['institucion']."</strong></td></tr>";
                }//nombre incompleto
            }else
            {
                //si la institucion no esta creada se procede a crear la institucion. 
                
                echo "<tr><td>".$x."</td><td colspan='11' align='left'>El convenio ya existe. <strong>".$fields['numeroconvenio']." ".$fields['institucion']."</strong></td></tr>";
            }
            $x++;
        }//if
        }
        ?>
        </tbody>
        </table>
        <?php
        }break;
        case '2':
        {
           ?>
            <hr /> 
            <br />
            <table border='2' align="center">
                <thead>
                    <td><strong>N#</strong></td>
                    <td><strong>numeroinstitucion</strong></td>
                    <td><strong>institucion</strong></td>
                    <td><strong>Domicilio</strong></td>
                    <td><strong>Vigencia</strong></td>
                    <td><strong>Fecha Inicio</strong></td>
                    <td><strong>Fecha fin</strong></td>
                    <td><strong>Estado</strong></td>
                    <td><strong>supervisor</strong></td>
                </thead>  
                <tbody>
            <?php  
            //TOCA PROCESAR EL ARCHIVO CON LAS ORDENES
    		$data = new Spreadsheet_Excel_Reader();
            //echo '<pre>'; print_r($data);
    		//echo "<pre>";print_r($_REQUEST); 
    		//echo "<br/><br/><pre>";print_r($_FILES); die;
    		$data->setOutputEncoding('CP1251');
    		$data->read($_FILES["file"]["tmp_name"]); 
            $filas = $data->sheets[0]['numRows'];
            
    		//var_dump($filas); die;
            //echo '<pre>'; print_r($filas);
    		//se asume la primera como titulo
            $contador=0;
    		$errores = 0;
            $x=1;
    		for ($z = 3; $z <= $filas; $z++) 
            {
                if($data->sheets[0]['cells'][$z][1] ==! '')
                {
                $fields['numeroinstitucion']=$data->sheets[0]['cells'][$z][1];
                $fields['institucion']=utf8_encode($data->sheets[0]['cells'][$z][2]);                
                if(!empty($fields['institucion']))
                {
                    $fields['Domicilio']= utf8_encode($data->sheets[0]['cells'][$z][3]);               
                    if(strpos($fields['Domicilio'], 'Bt') !== false)
                    {
                        $fields['Domicilio'] ='Bogota';
                    }
                    
                    $fields['Vigencia']=utf8_encode($data->sheets[0]['cells'][$z][4]);
                    if($fields['Vigencia']== 'Indefinido')
                    {
                        $fields['Vigencia']= '11';
                    }
                    
                    $fields['fechainicio']=$data->sheets[0]['cells'][$z][5]; 
                    $fechaini = explode("/", $fields['fechainicio']);
                    $dateinicial = $fechaini['2'].'-'.$fechaini['1'].'-'.$fechaini['0'];
                               
                    $fields['fechafin']=$data->sheets[0]['cells'][$z][6];
                    if($fields['fechafin']!='Indefinido')
                    {
                        $fechafin = explode("/", $fields['fechafin']);
                        $datefinal = $fechafin['2'].'-'.$fechafin['1'].'-'.$fechafin['0'];    
                    }else
                    {
                        $datefinal = '0000-00-00';
                    }
                    
                    $fields['Estado']=utf8_encode($data->sheets[0]['cells'][$z][7]);
                    
                    switch($fields['Estado'])
                    {
                        case 'Vigente':
                        {
                            $estado = '1';
                        }break;
                        case 'En Proceso':
                        {
                            $estado = '2';
                        }break;
                        case 'Anulado':
                        {
                            $estado = '3';
                        }break;
                        case 'Vencido':
                        {
                            $estado = '4';
                        }break; 
                        case 'Liquidar':
                        {
                            $estado = '5';
                        }break;
                        case 'Liquidado':
                        {
                            $estado = '6';
                        }break;           
                    }
                    
                    $fields['supervisor']=utf8_encode($data->sheets[0]['cells'][$z][8]);
                    $fields['RepresentanteLegal']=utf8_encode($data->sheets[0]['cells'][$z][9]);
                    $fields['identificacionrepresentante']=utf8_encode($data->sheets[0]['cells'][$z][10]);
                    $ccrepresentante = str_replace('.','',$fields['identificacionrepresentante']);
                    $ccrepresentante = str_replace(',','',$ccrepresentante);
                    $fields['dirrecion']=utf8_encode($data->sheets[0]['cells'][$z][11]);
                    $fields['telefono']=utf8_encode($data->sheets[0]['cells'][$z][12]);
                    $telefonos = explode(' ', $fields['telefono']);
                    //echo '<pre>'; print_r($telefonos); 
                    
                   foreach($telefonos as $datostelefono)
                    {
                        if(strlen($datostelefono)== '7')
                        {
                            if(!isset($telefono))
                            {
                                $telefono= $datostelefono;
                                //echo 'telefono1---'.$telefono.'<br>';    
                            }else
                            {
                                $telefono2= $datostelefono;
                                //echo 'telefono2---'.$telefono2.'<br>';
                            }       
                        }
                    }
                    $fields['nit']=utf8_encode($data->sheets[0]['cells'][$z][13]);
                    $fields['email']=utf8_encode($data->sheets[0]['cells'][$z][14]);
                    $fields['nombresolicitantebosque']=utf8_encode($data->sheets[0]['cells'][$z][15]);
                    $fields['cargosolicitante']=utf8_encode($data->sheets[0]['cells'][$z][16]);
                    $fields['telefonosolicitante']=utf8_encode($data->sheets[0]['cells'][$z][17]);
                    $telefonosSolicitante = explode(' ', $fields['telefonosolicitante']);
                    //echo '<pre>'; print_r($telefonos); 
                   foreach($telefonosSolicitante as $datostelefonosolicitante)
                    {
                        if(strlen($datostelefonosolicitante)== '7')
                        {
                            if(!isset($telefono))
                            {
                                $telefonoSolicitante= $datostelefonosolicitante;
                                //echo 'telefono1---'.$telefono.'<br>';    
                            }else
                            {
                                $telefonoSupervisor= $datostelefonosolicitante;
                                //echo 'telefono2---'.$telefono2.'<br>';
                            }       
                        }
                    }
                    $fields['emailsolicitante']=utf8_encode($data->sheets[0]['cells'][$z][18]);
                    
                    $fechacreacion = date("Y-m-d H:i:s");
                    
                    $sqlciudad = "SELECT c.idciudad, d.idpais FROM ciudad c INNER JOIN departamento d ON d.iddepartamento = c.iddepartamento WHERE nombrecortociudad like '%".$fields['Domicilio']."'"; 
                    $ciudad = $db->GetRow($sqlciudad);                    
                         
                    $sqlcodigoinstitudion = "select InstitucionConvenioId from InstitucionConvenios where CodigoInstitucion='".$fields['numeroinstitucion']."' and NombreInstitucion = '". $fields['institucion']."'";
                    $resultcodigoinstitucion = $db->GetRow($sqlcodigoinstitudion);
                        
                    if($resultcodigoinstitucion['InstitucionConvenioId']=='')
                    {
                        if(!empty($ciudad['idciudad']))
                        {
                            $sqlvalidacioncampos = "select InstitucionConvenioId from InstitucionConvenios where CiudadId='".$ciudad['idciudad']."' and FechaInicio = '".$dateinicial."' and FechaFin = '".$datefinal."' and Vigencia = '".$fields['Vigencia']."' and CodigoInstitucion='".$fields['numeroinstitucion']."'";
                                //echo $sqlvalidacioncampos.'<br>';
                                $resultcampos = $db->GetRow($sqlvalidacioncampos);
                                if($resultcampos['InstitucionConvenioId']=='')
                                {
                                    $sqlinsertinstitucion = "INSERT INTO InstitucionConvenios (NombreInstitucion, Nit, Direccion, Telefono, TelefonoDos, Email, CiudadId, idsiq_tipoinstitucion, idsiq_estadoconvenio, UsuarioCreacion, FechaCreacion, NombreSupervisor, RepresentanteLegal, IdentificacionRepresentante,FechaInicio, FechaFin, Vigencia, CodigoInstitucion, NombreSolicitanteBosque, CargoSolicitanteBosque, TelefonoSolicitanteBosque, TelefonoSupervisorBosque) VALUES ('".$fields['institucion']."', '".$fields['nit']."', '".$fields['dirrecion']."', '".$telefono."', '".$telefono2."', '".$fields['email']."','".$ciudad['idciudad']."', '1', '".$estado."', '".$resultS['idusuario']."', '".$fechacreacion."','".$fields['supervisor']."','".$fields['RepresentanteLegal']."','".$ccrepresentante."', '".$dateinicial."', '".$datefinal."', '".$fields['Vigencia']."', '".$fields['numeroinstitucion']."', '".$fields['nombresolicitantebosque']."', '".$fields['cargosolicitante']."', '".$telefonoSolicitante."', '".$telefonoSupervisor."')";
                                    $result=$db->Execute($sqlinsertinstitucion);
                                    
                                    $id =  $db->Insert_ID();
                                    
                                    $sqlsede = "INSERT INTO UbicacionInstituciones (NombreUbicacion, codigoestado, InstitucionConvenioId, idciudad, idpais, Direccion) VALUES ('".$fields['Domicilio']."', '100', '".$id."', '".$ciudad['idciudad']."', '".$ciudad['idpais']."', '".$fields['dirrecion']."')";
                                    $result2=$db->Execute($sqlsede);
                                    
                                   //echo 'sql -->'.$sqlinsertinstitucion.'<br>';
                                    echo '<tr><td>'.$x.'</td>';
                                    echo '<td>'.$fields['numeroinstitucion'].'</td>';
                                    echo '<td>'.$fields['institucion'].'</td>';
                                    echo '<td>'.$fields['Domicilio'].'</td>';
                                    echo '<td>'.$fields['Vigencia'].'</td>';
                                    echo '<td>'.$fields['fechainicio'].'</td>';
                                    echo '<td>'.$fields['fechafin'].'</td>';
                                    echo '<td>'.$fields['Estado'].'</td>';
                                    echo '<td>'.$fields['supervisor'].'</td></tr>';
                                    echo "<tr><td>".$x."</td><td colspan='9' align='center'>Institucion creada. <strong>".$fields['institucion']."</strong></td></tr>";                 
                                }
                            }//ciudad 
                            else
                            {
                                echo "<tr><td>".$x."</td><td colspan='9' align='left'>Error. El Domicilio tiene errores. Por favor revisarlo. <strong>".$fields['institucion']."</strong></td></tr>";
                            }
                        }
                        else
                        {
                            echo "<tr><td>".$x."</td><td colspan='10' align='left'>Institucion ya se encuentra creada. <strong>".$fields['institucion']."</strong></td></tr>";
                        }
                    
                }else
                {
                    echo "<tr><td>".$x."</td><td colspan='10' align='left'><strong>Error. La institución tiene errores de escritura, por favor revisar el nombre de la institución..</strong></td></tr>";
                }
                $x++;
                }// fin 
            }                       
        }break;
        }
    } 
	    ?>
        </tbody>
        </table>
        </div>
        </div>
        </body>
</html>
