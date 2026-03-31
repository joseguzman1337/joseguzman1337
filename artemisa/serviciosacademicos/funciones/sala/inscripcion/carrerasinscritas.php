<?php    

    $codigocarrera=$_SESSION['codigocarrerasesion'];
    $codigoinscripcion = $_SESSION['numerodocumentosesion']; 
    $fecha = date("Y-m-d G:i:s",time());

    $query_data = "SELECT 
        eg.*,
        m.nombremodalidadacademica,
	ci.nombreciudad,
	i.idinscripcion,
	e.codigocarrera,
        c.nombrecarrera,
        c.codigomodalidadacademica
    FROM estudiantegeneral eg,inscripcion i,estudiantecarrerainscripcion e,carrera c,modalidadacademica m,ciudad ci
    WHERE numerodocumento = '".$this->estudiantegeneral->numerodocumento."'
    AND eg.idestudiantegeneral = i.idestudiantegeneral
    AND eg.idciudadnacimiento = ci.idciudad
    AND i.idinscripcion = e.idinscripcion
    AND e.codigocarrera = c.codigocarrera
    AND m.codigomodalidadacademica = i.codigomodalidadacademica 
    AND e.idnumeroopcion = '1'
    AND i.codigoestado like '1%'
    AND c.codigomodalidadacademica = '".$this->codigomodalidadacademica."'    
    AND i.idinscripcion = '".$this->idinscripcion."'"; 

    $data = $db->Execute($query_data);
    $totalRows_data = $data->RecordCount();
    $row_data = $data->FetchRow();

    //SI LA MODALIDA ACADEMICA ES PREGRADO NO SE DEBE MOSTRAR LA CARRERA 10 MEDICINA.
    //y tambien los codigos 134 (psicologia Nocturna) 143 (Psicologia-An) y 1624 (Integracion FACYC)
    $and = '';
    if($this->codigomodalidadacademica == '200'){
        $and = " and codigocarrera NOT IN(10,134,143,1624)";
    }

    #query para busqueda de periodo en estado de inscripciones
    $queryPeriodoInscripcion = "select codigoperiodo from periodo where codigoestadoperiodo=4 or
                                codigoestadoperiodo=1  order by codigoperiodo limit 1";
                                
    $periodoInscripcion = $db->getRow($queryPeriodoInscripcion);


//CONSULTA LAS CARRERAS ACTIVAS PARA SEGUNDA OPCION no  incluye departamentos ni carreras inscritas para
// el mismo periodo de inscripcion
    $query_car = "SELECT nombrecarrera,codigocarrera 
        FROM carrera 
        WHERE codigomodalidadacademica = $this->codigomodalidadacademica
        AND fechavencimientocarrera > '".$fecha."'
        AND codigocarrera NOT IN (1, 144, 146, 485, 150, 782, 491, 152, 417, 6, 492, 7, 157, 781, 486, 487, 151, 3, 4, 90, 93, 131, 554,560) 
        and fechavencimientocarrera >= NOW()
        and codigocarrera not in (
        select distinct eci.codigocarrera
        from estudiantecarrerainscripcion eci
             INNER JOIN inscripcion i on (eci.idinscripcion = i.idinscripcion)
        where eci.idestudiantegeneral = ".$this->estudiantegeneral->idestudiantegeneral."
        and eci.codigoestado = 100
        and i.codigoperiodo = ".$periodoInscripcion['codigoperiodo'].") 
        $and 
        ORDER BY FIND_IN_SET(codigocarrera, '13') desc";
    
    $car = $db->Execute($query_car);
    $totalRows_car = $car->RecordCount();
    $row_car = $car->FetchRow();

    // vista previa	   
    $query_periodo = "select * 
    from periodo p,carreraperiodo c
    where p.codigoperiodo = c.codigoperiodo
    and c.codigocarrera = '".$row_data['codigocarrera']."'
    and p.codigoestadoperiodo like '1' 
    order by p.codigoperiodo";
    $periodo = $db->Execute($query_periodo);
    $totalRows_periodo = $periodo->RecordCount();
    $row_periodo = $periodo->FetchRow();
?>
<label id="labelresaltado">Puede seleccionar una sola carrera como segunda opción.</label>
<?php 
    $query_datosgrabados = "SELECT idnumeroopcion, c.nombrecarrera, m.nombremodalidadacademica, c.codigocarrera,
        e.idinscripcion , e.idestudiantecarrerainscripcion
        FROM estudiantecarrerainscripcion e,carrera c,modalidadacademica m
        WHERE e.idestudiantegeneral = '".$this->estudiantegeneral->idestudiantegeneral."'
        AND m.codigomodalidadacademica = c.codigomodalidadacademica								
        AND e.codigocarrera = c.codigocarrera
        AND e.codigoestado like '1%'
        AND e.idinscripcion = '".$this->idinscripcion."'
        AND e.codigocarrera <> '".$row_data['codigocarrera']."'  
        AND idnumeroopcion <> '1'    
        ORDER BY idnumeroopcion";
    
    $datosgrabados = $db->Execute($query_datosgrabados);
    $totalRows_datosgrabados = $datosgrabados->RecordCount();
    $row_datosgrabados = $datosgrabados->FetchRow();
    if ($row_datosgrabados <> "")
    { 
        ?>
        <br>
        <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
            <tr id="trtitulogris">
                <td>Opción</td>
                <td>Carrera</td>					
                <td>Modalidad</td>
                <td>Editar</td>		
            </tr>
            <?php 			    
            do{ 
                ?>
                <tr>
                    <td><?php echo $row_datosgrabados['idnumeroopcion'];?></td>
                    <td><?php echo $row_datosgrabados['nombrecarrera'];?></td>
                    <td><?php echo $row_datosgrabados['nombremodalidadacademica'];?></td>
                    <td>
                        <?php 
                        $query_datosgrabados1 = "SELECT * 
                        FROM estudiante e,inscripcion i, situacioncarreraestudiante s 
                        WHERE i.idestudiantegeneral = '".$row_data['idestudiantegeneral']."'
                        AND e.codigocarrera = '".$row_datosgrabados['codigocarrera']."'												   								   
                        AND i.idinscripcion = '".$row_datosgrabados['idinscripcion']."'
                        AND e.idestudiantegeneral = i.idestudiantegeneral 
                        AND e.codigosituacioncarreraestudiante=s.codigosituacioncarreraestudiante";		
                        $datosgrabados1 = $db->Execute($query_datosgrabados1);
                        $totalRows_datosgrabados1 = $datosgrabados1->RecordCount();
                        $row_datosgrabados1 = $datosgrabados1->FetchRow();
                        if (! $row_datosgrabados1){			 
                            ?>
                            <a onClick="window.location.href='editarcarrerasinscritas_new.php?id=<?php echo $row_datosgrabados['idestudiantecarrerainscripcion'].'&numerodocumento='.$this->estudiantegeneral->numerodocumento.'&idinscripcion='.$this->idinscripcion; ?>'" style="cursor: pointer"><img src="../../../../imagenes/editar.png" width="20" height="20" alt="Editar"></a>
                            <a onClick="if(!confirm('¿Está seguro de elimiar el registro?')) return true; else window.location.href='eliminar_new.php?carrerasinscritas&id=<?php echo $row_datosgrabados['idestudiantecarrerainscripcion'];?>'" style="cursor: pointer"><img src="../../../../imagenes/eliminar.png" width="20" height="20" alt="Eliminar"></a>
                            <?php 
                        }else{
                            echo $row_datosgrabados1["nombresituacioncarreraestudiante"];
                        }
                        ?>
                    </td>
                </tr>			   
                <?php  
            }while($row_datosgrabados = $datosgrabados->FetchRow());
            ?>
        </table> 
        <?php
    }else if(!isset($_POST['inicial']) && !isset($_GET['inicial'])){
       
    }	     	      
    
    { // vista previa	  
        ?>
	<br>
    <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
            <tr id="trtitulogris">
            <td colspan="1"><?php echo $nombremodulo[$moduloinicial]; ?><a onClick="window.open('pregunta.php?id=<?php echo $iddescripcion[$moduloinicial];?>','mensajes','width=400,height=200,left=300,top=500,scrollbars=yes')" style="cursor: pointer">&nbsp;&nbsp;<img src="../../../../imagenes/pregunta.gif" alt="Ayuda"></a></td>
	</tr>
	<tr id="trtitulogris">
            <td colspan="2">Carrera*</td>	  
            <?php 
            $cuentamedio = 1;
            ?> 
        </tr>
        <tr>
            <td width="70%">
                <div>
                    <select name="carrera" id="especializacion" onChange="enviar()">
                        <option value="0" <?php if (!(strcmp("0", $_POST['carrera']))) {echo "SELECTED";} ?>>Seleccionar</option>
                        <?php
                        do{  
                            ?>
                            <option value="<?php echo $row_car['codigocarrera']?>"<?php if (!(strcmp($row_car['codigocarrera'], $_POST['carrera']))) {echo "SELECTED";} ?>><?php echo $row_car['nombrecarrera']?></option>
                            <?php
                        }while ($row_car = $car->FetchRow());
                        ?>
                    </select>
                </div>
            </td>
        </tr>       
    </table>
    <script language="javascript">
        function grabar(){
            document.inscripcion.submit();
        }
    </script>

    <input type="hidden" name="grabado" value="grabado">   
    <?php
    } // vista previa	  
    ?>
    <script language="javascript">
        function vista(){	
            window.location.reload("vistaformularioinscripcion.php");	
        }
    </script>
