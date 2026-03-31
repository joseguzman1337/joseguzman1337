<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once (realpath(dirname(__FILE__)).'/../EspacioFisico/templates/template.php');
    include_once (realpath(dirname(__FILE__)).'/./Permisos/class/PermisosRotacion_class.php'); 
    
    $C_Permisos = new PermisosRotacion();     
    
    $db = getBD();
    $SQL_User='SELECT idusuario as id, codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
    $Usario_id=$db->GetRow($SQL_User);
    $userid=$Usario_id['id'];
    
    $Acceso = $C_Permisos->PermisoUsuarioRotacion($db,$userid,2,9);    
    foreach ($Acceso['Data'] as $datos) {
        $rol = $datos['RolSistemaId'];
    }   
    if(!$rol)
    {
        $rol =7;
    }
    if($_REQUEST['Action_id']=='carrera')
    {
        $carrera = $_REQUEST['carrera'];
        Materia($db,$carrera);    
    }
    if($_REQUEST['Action_id']=='modalidad')
    {
        $modalidad = $_REQUEST['modalidad'];
        Modalidad($db,$modalidad);    
    }
    
    function Materia($db,$carrera)
    {	
        ?>
        <label>Este campo es opcional</label>
        <select id="Materia" name="Materia">
            <option value=""></option>
        <?php                               
        $sqlMaterias = "SELECT m.codigomateria, m.nombremateria FROM carrera c JOIN materia m ON m.codigocarrera = c.codigocarrera WHERE c.codigocarrera = '".$carrera."' and m.TipoRotacionId in (2,3) ORDER BY m.nombremateria";		
        $valoresMaterias = $db->GetAll($sqlMaterias);
        foreach($valoresMaterias as $datosMaterias)
        {
            ?>
            <option value="<?php echo $datosMaterias['codigomateria']?>"><?php echo $datosMaterias['nombremateria']?></option>
            <?php 
        }
        ?>
        </select>
        <?php
        exit;
    }
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Reportes convenios rotaciones</title>
        <link rel="stylesheet" href="../mgi/css/cssreset-min.css" type="text/css" /> 
        <link rel="stylesheet" href="../css/demo_page.css" type="text/css" /> 
        <link rel="stylesheet" href="../css/demo_table_jui.css" type="text/css" />
        <link rel="stylesheet" href="../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleMonitoreo.css" type="text/css" /> 
        <link rel="stylesheet" href="../mgi/css/styleDatos.css" type="text/css" /> 
        <link type="text/css" href="../educacionContinuada/css/normalize.css" rel="stylesheet">
        <link media="screen, projection" type="text/css" href="../educacionContinuada/css/style.css" rel="stylesheet">
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>   
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.fastLiveFilter.js"></script>   
        <script type="text/javascript" language="javascript" src="../mgi/js/nicEdit.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/functions.js"></script>  
        <script type="text/javascript" language="javascript" src="../mgi/js/functionsMonitoreo.js"></script> 
        <script type="text/javascript" language="javascript" src="js/funcionesConvenios.js"></script>
    </head>
    <script language="javascript">
    function cambia_tipo()
    {
        //tomo el valor del select del tipo elegido
        var consulta;
        consulta = document.f1.consulta[document.f1.consulta.selectedIndex].value;
        //miro a ver si el tipo estï¿½ definido
        window.location.href="../convenio/ReportesConveniosRotaciones.php?busqueda="+consulta;
    }
    function seleccionar_consulta(){
        var seleccionar;
        seleccionar = document.f1.consulta2[document.f1.consulta2.selectedIndex].value;
        window.location.href="../convenio/ReportesConveniosRotaciones.php?busqueda=1&consulta="+seleccionar; 
    }
    function seleccionar_consulta3(){
        var seleccionar;
        seleccionar = document.f1.consulta3[document.f1.consulta3.selectedIndex].value;
        window.location.href="../convenio/ReportesConveniosRotaciones.php?busqueda=2&consulta3="+seleccionar; 
    }
        
    function validacion() 
    { 
       var fechainicial = $('#codigoperiodoinicial').val();
       var fechafin = $('#codigoperiodofinal').val();
       if(fechainicial > fechafin)
       {
            alert("El Periodo final no debe ser mayor al Periodo inicial.");
            $('#codigoperiodofinal').val(fechainicial);
       }
       
    }
    </script>
    <script>
        function val_texto(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla==8) return true;
            patron = /[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/;
            te = String.fromCharCode(tecla);
            return patron.test(te);
        }
        function val_numero(e) {
            tecla = (document.all) ? e.keyCode : e.which; 
            //118 pegar texto
            if (tecla==8 || tecla == 118) return true;
            patron =/[0-9]+$/;            
            te = String.fromCharCode(tecla);
            return patron.test(te);
        }
        </script> 
    <body>
    <div align="center">  
        <center>
            <h1>Reportes Rotaciones</h1>
        </center>
        <form name="f1" action="../consulta/facultades/materiasgrupos/rotaciones/ReporteRotaciones.php" method="get">
            <table width="60%"  cellpadding="2" cellspacing="1" border="0">
                <tr>
                    <?php
					$arrayBusqueda = array("1"=>"Facultad o Materia","2"=>"Instituciones","3"=>"Estudiante", "4"=>"Registros Totales");
                    ?>
                    <td>Buscar por: </td>
                        <td colspan="3">
                            <select name="consulta2" onChange="seleccionar_consulta()">
                                <option value=""></option>
                            <?php
                            foreach($arrayBusqueda as $key=>$busqueda){
                                $selected = '';
                                if($key==$_GET['consulta']){
                                    $selected = 'selected="selected"';
                                }
                                echo '<option value="'.$key.'" '.$selected.'>'.$busqueda.'</option>';
                            }
                            ?>
                            </select>
                       </td>
                </tr>
                <tr>
                <?php
                    if($_GET['busqueda']=="1")//instituciones
                    {
                    ?> 
                    <tr>
                        <td>Periodo inicial</td>
                        <td>
                        <?php
                            $sql1= "SELECT codigoperiodo FROM periodo ORDER BY codigoperiodo DESC";
                            $Consulta=$db->GetAll($sql1);                     
                            ?>
                            <select name='codigoperiodoinicial' id='codigoperiodoinicial'>
                            <?php
                            foreach($Consulta as $datosperiodo)
                            {
                                if($_SESSION['codigoperiodosesion'] == $datosperiodo['codigoperiodo'])
                                {
                                    ?><option value='<?php echo $datosperiodo['codigoperiodo']; ?>' selected='selected'><?php echo $datosperiodo['codigoperiodo']?></option><?php
                                }else
                                {
                                    ?><option value='<?php echo $datosperiodo['codigoperiodo']; ?>' ><?php echo $datosperiodo['codigoperiodo']?></option><?php
                                }     
                            }
                            ?>
                            </select>                                
                        </td>
                        <td>Periodo Final</td>
                        <td>
                        <?php
                            $sql1= "SELECT codigoperiodo FROM periodo ORDER BY codigoperiodo DESC";
                            $Consulta=$db->GetAll($sql1);                     
                            ?> <select name='codigoperiodofinal' id='codigoperiodofinal' onchange="validacion()"><option value="0"></option><?php
                            foreach($Consulta as $datosperiodo)
                            {
                                if($_SESSION['codigoperiodosesion'] == $datosperiodo['codigoperiodo'])
                                {
                                    ?><option value='<?php echo $datosperiodo['codigoperiodo']; ?>' selected='selected'><?php echo $datosperiodo['codigoperiodo']?></option><?php
                                }else
                                {
                                    ?><option value='<?php echo $datosperiodo['codigoperiodo']; ?>' ><?php echo $datosperiodo['codigoperiodo']?></option><?php
                                }     
                            }
                            ?>
                            </select>
                        </td>
                    </tr>
                    <?php
                    if($_GET['consulta']=="1")//MATERIA
                    {
                    ?>
                    <tr>
                        <td>Carrera:</td>
                        <td colspan="3">
                            <select id="carrera" name="carrera" onchange="BuscarCarreraMateria()">
                                <option value="0">Seleccione</option>
                                <?php
                                if($rol != '7')
                                {
                                   $where = " and uf.usuario = '".$_SESSION['MM_Username']."'"; 
                                }

                                $query_carreras = "SELECT DISTINCT c.codigocarrera, c.nombrecarrera from carrera c INNER JOIN usuariofacultad uf on uf.codigofacultad = c.codigocarrera where c.codigomodalidadacademica in ('200', '300') ".$where." and c.codigocarrera <> '1' order by c.nombrecarrera;";
                                $carreras = $db->GetAll($query_carreras);

                                foreach($carreras as $ca)
                                {
                                    ?>
                                    <option value="<?php echo $ca['codigocarrera']; ?>"><?php echo $ca['nombrecarrera']; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>  
                        <td>Materia:</td>
                        <td id="Td_Materia" colspan="3">  						
                        </td>
                    </tr>
                    <?php
                    }//materia
                    else
                    {
                        if($_GET['consulta']=="2")//UBICACION
                        {
                        ?>
                        <tr>
                            <td>Institucion Ubicacion:</td>
                            <?php 
                                $sql= "SELECT i.InstitucionConvenioId, i.NombreInstitucion FROM InstitucionConvenios i  ORDER BY i.NombreInstitucion";
                                if($Consulta=&$db->Execute($sql)===false){
                                    echo 'Error en el SQL de la Consulta....<br><br>'.$sql;
                                    die;
                                }   
                                $valor_modalidad = &$db->Execute($sql);
                                $datos_modalidad =  $valor_modalidad->getarray();
                                $totaldatos=count($datos_modalidad);
                                if ($totaldatos>0){
                            ?>
                            <td colspan="3">
                                <select name="ubicacion" id="ubicacion">
                                    <option value=""></option>  
                                    <?php
                                        foreach($valor_modalidad as $datos){
                                    ?>
                                    <option value="<?php echo $datos['InstitucionConvenioId'] ?>"><?php echo $datos['NombreInstitucion']; ?></option>
                                    <?php
                                        }
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <?php
                        }//ubiacion
                        else
                        {
                            if($_GET['consulta']=="3")//estudiante
                            {
                            ?>
                            <tr>
                                <td>Documento:</td>
                                <td colspan="3">
                                    <input type="text" name="Documento" id="Documento" onkeypress="return val_numero(event)"/>
                                </td>
                            </tr>
                            <tr>
                                <td>Apellido:</td>
                                <td colspan="3">
                                    <input type="text" name="Apellido" id="Apellido" onkeypress="return val_texto(event)"/>
                                </td>
                            </tr>
                            <?php
                            }//estudiante                            
                        }//else
                    }//else
                    }//consulta intituciones
                    else
                    {
                        if($_GET['consulta3']==1)
                        {
                        ?>
                            <tr>
                                <td>Lista de Convenios:</td> 
                                <td>
                                    <select name="convenios" id="convenios">
                                    <option value=""></option>
                                   <?php 
                                    $sqlconvenios="select NombreConvenio, ConvenioId from Convenios order by NombreConvenio";
                                    $valoresconvenio = $db->execute($sqlconvenios);
                                    foreach($valoresconvenio as $datosconvenios){
                                        ?>
                                        <option value="<?php echo $datosconvenios['ConvenioId'];?>"><?php echo $datosconvenios['NombreConvenio'];?></option>
                                        <?php
                                    }
                                    ?>
                                    <option value=""></option>
                                    </select> 
                                </td>
                            </tr>
                            <?php    
                        }else
                        {
                            if($_GET['consulta3']==2)
                            {
                            ?>
                            <tr>
                               <td>Lista de Instituciones:</td> 
                               <td>
                               <select name="instituciones" id="instituciones">
                                   <option value=""></option>
                                   <?php 
                                    $sqlinstitucion="select InstitucionConvenioId, NombreInstitucion from InstitucionConvenios order by NombreInstitucion";
                                    $valoresinstitucion = $db->execute($sqlinstitucion);
                                    foreach($valoresinstitucion as $datosinstitucion){
                                        ?>
                                        <option value="<?php echo $datosinstitucion['InstitucionConvenioId'];?>"><?php echo $datosinstitucion['NombreInstitucion'];?></option>
                                        <?php
                                    }
                                    ?>
                               <option value=""></option>
                               </select> 
                               </td>
                            </tr>
                            <tr>
                                <td>Domicilio:</td>
                                <td></td>
                            </tr>
                            <?php  
                            }//consulta 2
                        }//else
                    }//else consulta                
              ?>               
        </table>
        <input type="submit" value="Consultar" onclick="buscar()" />
        </form>
    </div>
    </body>
</html>