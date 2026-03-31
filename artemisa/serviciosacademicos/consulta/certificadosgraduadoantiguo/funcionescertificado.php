<?php

function certificados ($documento)
{
    global $db;
            $query_persona = "SELECT  concat(eg.nombresestudiantegeneral, ' ',eg.apellidosestudiantegeneral) as nombre, eg.numerodocumento,  r.tituloregistrograduadoantiguo, r.numeroactaregistrograduadoantiguo, r.fechagradoregistrograduadoantiguo, r.numerodiplomaregistrograduadoantiguo 
            FROM estudiantegeneral eg, estudiante e, registrograduadoantiguo r 
            where eg.numerodocumento = '$documento'
            and e.codigoestudiante=r.codigoestudiante 
            and eg.idestudiantegeneral=e.idestudiantegeneral
            union
            SELECT  concat(eg.nombresestudiantegeneral, ' ',eg.apellidosestudiantegeneral) as nombre, eg.numerodocumento, t.nombretitulo, r.numeroactaregistrograduado, r.fechagradoregistrograduado, r.numerodiplomaregistrograduado 
            FROM estudiantegeneral eg, estudiante e, carrera c, registrograduado r, titulo t 
            where eg.numerodocumento =  '$documento'
            and eg.idestudiantegeneral=e.idestudiantegeneral
            and e.codigocarrera=c.codigocarrera
            and e.codigoestudiante=r.codigoestudiante
            and c.codigotitulo=t.codigotitulo";
            $persona = $db->Execute($query_persona);
            $totalRows_persona = $persona->RecordCount();
            $row_persona = $persona->FetchRow();
                
                if ($totalRows_persona >0){ ?>
                    <TABLE   border="0" align="center" cellpadding="3">
                        <tr>
                        <td bgcolor="#D6D6D6" colspan="3" valign="center"><img src="../../../imagenes/logocertificado1.jpg" height="77"></td>
                        </tr>
                    </TABLE></br></br></br>
                    <table   border="0" align="center" cellpadding="3" cellspacing="3">          
                        <TR>
                            <TD colspan="5" align="justify" ><P><font size="+1">CERTIFICADO DE IDONEIDAD DE TÍTULO</font></P></BR><font size=2> La Universidad El Bosque, certifica que la persona, abajo relacionada, cursó y aprobó los estudios y obtuvo el título respectivo en esta institución, conforme a la siguiente información:</font></br></TD>
                        </TR>
                    </TABLE>
                    </br></br>
                    <table   border="1" align="center" cellpadding="3" cellspacing="3">      
                        <TR id="trtitulogris">
                            <TD align="center">Nombre</TD>
                            <TD align="center">Documento de Identificación</TD>
                            <TD align="center">Título Obtenido </TD>
                            <TD align="center">Acta y Fecha de Grado </TD>            
                            <TD align="center">Diploma Nº</TD>                    
                            
                        </TR>
                        <?php do { ?>
                        <TR>
                            <TD align="center"><?php echo $row_persona['nombre']; ?>
                            </TD>
                            <TD align="center"><?php echo $row_persona['numerodocumento']; ?>
                            </TD>
                            <TD align="center"><?php echo $row_persona['tituloregistrograduadoantiguo']; ?>
                            </TD>            
                            <TD align="center"><?php echo $row_persona['numeroactaregistrograduadoantiguo']."</br> ".$row_persona['fechagradoregistrograduadoantiguo']; ?>
                            </TD>
                            <TD align="center"><?php echo $row_persona['numerodiplomaregistrograduadoantiguo']; ?>                          
                        </TR>
                        <?php } while($row_persona = $persona->FetchRow()) ?>                              
                    </table>
                    </br></br></br></br></br></br></br>
                    <table   border="0" align="left" cellpadding="3" cellspacing="3">   
                        <TR>
                            <TD colspan="5" align="justify" ><P><font size="2">LUIS ARTURO RODRÍGUEZ BUITRAGO</font></P></TD>
                        </TR>
                        <TR>
                            <TD colspan="5" align="justify" ><P>Secretario General</P></TD>
                        </TR>
                    </TABLE>
                    </br></br>
                    <TABLE   border="0" align="center" cellpadding="3">
                        <tr align="right">
                        <td ><img src="../../../imagenes/logocertificado2.jpg" onclick="window.location.href='inicio.php'" ></td>
                        </tr>
                    </TABLE>
                                        
                 <?php   
                }
                else {
                    echo "<script language='javascript'> 
                    alert('Esta información no se encuentra disponible. Cualquier inquietud o inconsistencia con la información, favor comunicarse al teléfono 6489000 ext 347 o al correo auxsecgen@unbosque.edu.co');
                    window.location.href='inicio.php';
                    </script>";                                                     
                }        
}
function certificadousuario ($documento)
{
    global $db;
            $query_persona = "SELECT  concat(eg.nombresestudiantegeneral, ' ',eg.apellidosestudiantegeneral) as nombre, eg.numerodocumento,  r.tituloregistrograduadoantiguo, r.numeroactaregistrograduadoantiguo, r.fechagradoregistrograduadoantiguo, r.numerodiplomaregistrograduadoantiguo 
            FROM estudiantegeneral eg, estudiante e, registrograduadoantiguo r 
            where eg.numerodocumento = '$documento'
            and e.codigoestudiante=r.codigoestudiante 
            and eg.idestudiantegeneral=e.idestudiantegeneral
            union
            SELECT  concat(eg.nombresestudiantegeneral, ' ',eg.apellidosestudiantegeneral) as nombre, eg.numerodocumento, t.nombretitulo, r.numeroactaregistrograduado, r.fechagradoregistrograduado, r.numerodiplomaregistrograduado 
            FROM estudiantegeneral eg, estudiante e, carrera c, registrograduado r, titulo t 
            where eg.numerodocumento =  '$documento'
            and eg.idestudiantegeneral=e.idestudiantegeneral
            and e.codigocarrera=c.codigocarrera
            and e.codigoestudiante=r.codigoestudiante
            and c.codigotitulo=t.codigotitulo";
            $persona = $db->Execute($query_persona);
            $totalRows_persona = $persona->RecordCount();
            $row_persona = $persona->FetchRow();
                
                if ($totalRows_persona >0){ ?>
                    <TABLE   border="0" align="center" cellpadding="3">
                        <tr>
                        <td bgcolor="#D6D6D6" colspan="3" valign="center"><img src="../../../imagenes/logocertificado1.jpg" height="77"></td>
                        </tr>
                    </TABLE></br></br>
                    <table   border="0" align="center" cellpadding="3" cellspacing="3">
                        <TR align="center" >
                            <TD colspan="2" align="center"><p><font size="2">Consulta Título Obtenido</font></p></br>
                            </TD>
                        </TR>
                        <TR id="trtitulogris">
                            <TD align="center">Nombre</TD>                            
                            <TD align="center">Título Obtenido </TD>                    
                        </TR>
                        <?php do { ?>
                        <TR>
                            <TD align="center"><?php echo $row_persona['nombre']; ?>
                            </TD>                            
                            <TD align="center"><?php echo $row_persona['tituloregistrograduadoantiguo']; ?>
                            </TD>                        
                        </TR>                        
                        <?php } while($row_persona = $persona->FetchRow()) ?>
                        <tr  id="trgris">
                            <td align="justify" id="tdtitulogris" colspan="2"></BR><LABEL id="labelasterisco">*</LABEL>Nota:Si usted requiere información certificada directamente por autoridad competente de la Universidad, sírvase solicitar el certificado correspondiente, adjuntando el recibo de pago por los derechos del certificado.</td>
                        </tr>       
                        <tr align="center" id="trgris">
                            <td id="tdtitulogris" colspan="2">
                            <div align="center">
                            <INPUT type="button" value="Nueva Busqueda" onclick="window.location.href='estudiante.php'">
                            </div>
                            </td>
                        </tr>       
                    </table>
                    </br></br>
                    <TABLE   border="0" align="center" cellpadding="3">
                        <tr align="right">
                        <td  ><img src="../../../imagenes/logocertificado2.jpg" ></td>
                        </tr>
                    </TABLE>                    
                 <?php   
                }
                else {
                    echo "<script language='javascript'> 
                    alert('Esta información no se encuentra disponible. Cualquier inquietud o inconsistencia con la información, favor comunicarse al teléfono 6489000 ext 347 o al correo auxsecgen@unbosque.edu.co');
                    window.location.href='estudiante.php';
                    </script>";                                                     
                }        
}
function ingreso ($codigoestudiante)
{
    global $db;
   
    
            $query_registronuevo="SELECT * FROM registrograduado where codigoestudiante='$codigoestudiante'";
            $registronuevo = $db->Execute($query_registronuevo);
            $totalRows_registronuevo = $registronuevo->RecordCount();
            $row_registronuevo = $registronuevo->FetchRow();
                    
                if($totalRows_registronuevo >0) {
                    echo "<script language='javascript'>                            
                    window.location.href='../facultades/registro_graduados/registro_graduados.php?codigoestudiante=$codigoestudiante';
                    
                    </script>";
                }
                else {
                    $query_persona = "SELECT concat(eg.nombresestudiantegeneral, ' ',eg.apellidosestudiantegeneral) as nombre, eg.numerodocumento, e.codigocarrera, e.codigoestudiante, t.nombretitulo FROM estudiantegeneral eg, estudiante e, carrera c, titulo t
                    where e.codigoestudiante= '$codigoestudiante'
                    and e.idestudiantegeneral=eg.idestudiantegeneral
                    and e.codigosituacioncarreraestudiante = 400
                    and e.codigoperiodo <=20052
                    and e.codigocarrera=c.codigocarrera
                    and c.codigotitulo=t.codigotitulo";
                    $persona = $db->Execute($query_persona);
                    $totalRows_persona = $persona->RecordCount();
                    $row_persona = $persona->FetchRow();
                                
                    if ($totalRows_persona >0){                
                    
                        $query_registroantiguo = "SELECT idregistrograduadoantiguo, nombreregistrograduadoantiguo, documentoegresadoregistrograduadoantiguo, tituloregistrograduadoantiguo, numerodiplomaregistrograduadoantiguo, fechagradoregistrograduadoantiguo, numeroactaregistrograduadoantiguo, fechaactaregistrograduadoantiguo, numerolibroregistrograduadoantiguo, numerofolioregistrograduadoantiguo FROM registrograduadoantiguo where codigoestudiante= '$codigoestudiante'";
                        $registroantiguo = $db->Execute($query_registroantiguo);
                        $totalRows_registroantiguo = $registroantiguo->RecordCount();
                        $row_registroantiguo = $registroantiguo->FetchRow();                    
                        
                            if($totalRows_registroantiguo >0) {
                        ?>           
                                <SCRIPT language="JavaScript" type="text/javascript">
                                function confirmar() {
                                    if(confirm('¿Está Seguro de Actualizar la información para este usuario?')) {
                                        document.getElementById('guardar').value='ok';
                                        document.form1.submit();
                                    }
                                }
                                </SCRIPT>
                        <?php
                            }
                            else { ?>
                                <SCRIPT language="JavaScript" type="text/javascript">
                                function confirmar() {
                                    if(confirm('¿Está Seguro de Generar el registro para este usuario?')) {
                                        document.getElementById('guardar').value='ok';
                                        document.form1.submit();
                                    }
                                }
                                </SCRIPT>
                        <?php 
                            }
                            
                            $varguardar = 0;
                            if (isset($_POST['guardar']) && $_POST['guardar'] != '') {
                                if ($_POST['ndiploma'] == '') {
                                    echo '<script language="JavaScript">alert("Digite el Número de Diploma")</script>';
                                            $varguardar = 1;
                                    }
                                elseif ($_POST['fechagrado'] == '') {
                                    echo '<script language="JavaScript">alert("Debe Ingresar la Fecha de Grado")</script>';
                                            $varguardar = 1;
                                    }
                                elseif ($_POST['nacta'] == '') {
                                    echo '<script language="JavaScript">alert("Digite el Número Acta")</script>';
                                            $varguardar = 1;
                                    }
                                elseif ($_POST['nlibro'] == '') {
                                    echo '<script language="JavaScript">alert("Digite el Número de Libro")</script>';
                                            $varguardar = 1;
                                    }
                                elseif ($_POST['nfolio'] == '') {
                                    echo '<script language="JavaScript">alert("Digite el Número de Folio")</script>';
                                            $varguardar = 1;
                                    }                           
                                elseif ($varguardar == 0) {
                                    if($totalRows_registroantiguo >0) {
                                    
                                        $query_actualizar = "UPDATE registrograduadoantiguo SET numerodiplomaregistrograduadoantiguo='".$_POST['ndiploma']."', fechagradoregistrograduadoantiguo='".$_POST['fechagrado']."',  numeroactaregistrograduadoantiguo='".$_POST['nacta']."',
                                        fechaactaregistrograduadoantiguo='".$_POST['fechaacta']."', numerolibroregistrograduadoantiguo='".$_POST['nlibro']."', numerofolioregistrograduadoantiguo='".$_POST['nfolio']."'
                                        where idregistrograduadoantiguo = '{$row_registroantiguo['idregistrograduadoantiguo']}'";
                                        $actualizar= $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
                                        echo "<script language='javascript'> alert('Se ha Actualizado la información correctamente');  </script>";                 
                                    }
                                    else{                      
                                        $query_guardar = "INSERT INTO registrograduadoantiguo (idregistrograduadoantiguo, idciudadregistrograduadoantiguo, areaconocimientoregistrograduadoantiguo, codigocarrera, modalidadregistrograduadoantiguo, metodologiaregistrograduadoantiguo, tituloregistrograduadoantiguo, numerodiplomaregistrograduadoantiguo, nombreregistrograduadoantiguo, documentoegresadoregistrograduadoantiguo, fechagradoregistrograduadoantiguo, numeroactaregistrograduadoantiguo, fechaactaregistrograduadoantiguo, numerolibroregistrograduadoantiguo, numerofolioregistrograduadoantiguo, codigoestudiante) values (0,'359','0', '{$row_persona['codigocarrera']}', 'Universitaria', 'Presencial', '{$row_persona['nombretitulo']}', '{$_REQUEST['ndiploma']}', '{$row_persona['nombre']}', '{$row_persona['numerodocumento']}', '{$_REQUEST['fechagrado']}', '{$_REQUEST['nacta']}', '{$_REQUEST['fechaacta']}', '{$_REQUEST['nlibro']}', '{$_REQUEST['nfolio']}', '{$row_persona['codigoestudiante']}')";
                                        $guardar= $db->Execute ($query_guardar) or die("$query_guardar".mysql_error());
                                        
                                        echo "<script language='javascript'>
                                        alert('!!Gracias!! El proceso se ha ejecutado correctamente')    
                                        window.history.back();
                                        </script>";
                                    }
                                }
                            }          
                        ?>
                            <table width="60%"  border="0" align="center" cellpadding="3" cellspacing="3">
                                <TR align="center" id="trtitulogris">
                                    <TD colspan="2" align="center"><label id="labelresaltadogrande" >Ingreso Graduados</LABEL>
                                    </TD>
                                </TR>
                                <TR>
                                    <TD id="tdtitulogris" align="left" >Nombre</TD>
                                    <TD align="left"><?php echo $row_persona['nombre']; ?></TD>
                                </TR>
                                <TR>
                                    <TD id="tdtitulogris" align="left" >Número Documento</TD>
                                    <TD align="left"><?php echo $row_persona['numerodocumento']; ?></TD>
                                </TR>
                                <tr>
                                    <td id="tdtitulogris" align="left">Título Obtenido </TD>
                                    <TD align="left"><?php echo $row_persona['nombretitulo']; ?></TD>
                                </tr>                   
                                <TR>
                                    <TD id="tdtitulogris" align="left"><LABEL id="labelasterisco">*</LABEL>Número Diploma </TD>
                                    <TD align="left"><INPUT type="text" name="ndiploma"  value="<?php 
                                        if($totalRows_registroantiguo >0)
                                        {
                                        echo $row_registroantiguo['numerodiplomaregistrograduadoantiguo'];
                                        }
                                        else {
                                            if ($_POST['ndiploma']!=""){ echo $_POST['ndiploma']; } 
                                        }?>">
                                    </TD>
                                </TR>
                                <TR>
                                    <td id="tdtitulogris" align="left"><LABEL id="labelasterisco">*</LABEL>Fecha Grado </TD>                           
                                    <td align="left">                                
                                        <INPUT type="text" name="fechagrado" id="fechagrado"  value="<?php 
                                        if($totalRows_registroantiguo >0)
                                        {
                                        echo $row_registroantiguo['fechagradoregistrograduadoantiguo'];
                                        }
                                        else {                                
                                            if ($_POST['fechagrado']!=""){ echo $_POST['fechagrado']; } 
                                        } ?>"><LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                                        <script type="text/javascript">
                                            Calendar.setup(
                                                {
                                                inputField  : "fechagrado",         // ID of the input field
                                                ifFormat    : "%Y-%m-%d",    // the date format
                                                onUpdate    : "fechagrado" // ID of the button
                                                }
                                                );
                                        </script>                                
                                    </td>                   
                                </TR>
                                <TR>
                                    <TD id="tdtitulogris" align="left"><LABEL id="labelasterisco">*</LABEL>Número Acta </TD>
                                    <TD align="left"><INPUT type="text" name="nacta" value="<?php 
                                        if($totalRows_registroantiguo >0)
                                        {
                                        echo $row_registroantiguo['numeroactaregistrograduadoantiguo'];
                                        }
                                        else {
                                            if ($_POST['nacta']!=""){ echo $_POST['nacta']; } 
                                        } ?>">
                                    </TD>
                                </TR>
                                <TR>
                                    <TD id="tdtitulogris" align="left">&nbsp;&nbsp;&nbsp;&nbsp;Fecha Acta</TD>
                                    <td align="left">                                
                                        <INPUT type="text" name="fechaacta" id="fechaacta"  value="<?php 
                                            if($totalRows_registroantiguo >0)
                                            {
                                            echo $row_registroantiguo['fechaactaregistrograduadoantiguo'];
                                            }
                                            else {
                                                if ($_POST['fechaacta']!=""){ echo $_POST['fechaacta']; } 
                                            } ?>">
                                        <LABEL id="labelresaltado">aaaa-mm-dd</LABEL>
                                        <script type="text/javascript">
                                            Calendar.setup(
                                                {
                                                inputField  : "fechaacta",         // ID of the input field
                                                ifFormat    : "%Y-%m-%d",    // the date format
                                                onUpdate    : "fechaacta" // ID of the button
                                                }
                                                );
                                        </script>                                
                                    </td>                  
                                </TR>
                                <TR>
                                    <TD id="tdtitulogris" align="left"><LABEL id="labelasterisco">*</LABEL>Número Libro </TD>
                                    <TD align="left"><INPUT type="text" name="nlibro" value="<?php
                                        if($totalRows_registroantiguo >0)
                                        {
                                        echo $row_registroantiguo['numerolibroregistrograduadoantiguo'];
                                        }
                                        else {
                                            if ($_POST['nlibro']!=""){ echo $_POST['nlibro']; } 
                                        }?>">
                                    </TD>
                                </TR>
                                <TR>
                                    <TD id="tdtitulogris" align="left"><LABEL id="labelasterisco">*</LABEL>Número Folio </TD>
                                    <TD align="left"><INPUT type="text" name="nfolio" value="<?php
                                        if($totalRows_registroantiguo >0)
                                        {
                                        echo $row_registroantiguo['numerofolioregistrograduadoantiguo'];
                                        }
                                        else {
                                            if ($_POST['nfolio']!=""){ echo $_POST['nfolio']; } 
                                        } ?>">
                                    </TD>
                                </TR>
                                <TR id="trtitulogris" >
                                    <TD colspan="2">Los campos Marcados con <LABEL id="labelasterisco">*</LABEL> son obligatorios.</TD>
                                    
                                </TR>
                                <TR id="trtitulogris"><TD align="center" colspan="2">
                                    <INPUT type="button" value="Regresar" onclick="window.history.back();">
                                    <INPUT type="hidden" value="" name="guardar" id="guardar">
                                    <INPUT type="button" value="Guardar" onclick="return confirmar()">
                                    
                                    </TD>
                                </TR>                       
                            </table>                    
                    <?php   
                    }
                    else {                      
                        echo "<script language='javascript'> 
                        alert('El estudiante no cumple los requisitos para ingresarle datos de actualización por favor verifique que el estudiante se encuentra en situación GRADUADO');
                        window.history.back();
                        </script>";
                        
                    }
                }                                   
}
?>