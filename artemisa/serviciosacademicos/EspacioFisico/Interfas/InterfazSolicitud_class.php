<?php
class InterfazSolicitud {
    public function Principal($db, $RolEspacioFisico){ 
        //echo 'Rol->'.$RolEspacioFisico;
        global $db, $userid;
        $Resultado = $this->DataSolicitudesPrint($db, $userid, $RolEspacioFisico);
        ?>
        <style>
            tr.odd:hover,tr.even:hover{
                background-color: yellow;
                cursor: pointer;
            }
            .ClasOnclikColor{
                background-color: red;
            }
            .odd{
                background-color: #e2e4ff;
            }
            .even{
                background-color: #A8F7C5;  
            }

        </style>
        <style type="text/css" title="currentStyle">
            @import "../../observatorio/data/media/css/demo_page.css";
            @import "../../observatorio/data/media/css/demo_table_jui.css";
            @import "../../observatorio/data/media/css/ColVis.css";
            @import "../../observatorio/data/media/css/TableTools.css";
            @import "../../observatorio/data/media/css/ColReorder.css";
            @import "../../observatorio/data/media/css/themes/smoothness/jquery-ui-1.8.4.custom.css";
            @import "../../observatorio/data/media/css/jquery.modal.css";

        </style>
        <!--<script type="text/javascript" language="javascript" src="../../observatorio/data/media/js/jquery.js"></script>
        <script type="text/javascript" charset="utf-8" src="../jquery/js/jquery-3.6.0.js"></script>-->
        <script type="text/javascript" language="javascript" src="../../observatorio/data/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../observatorio/data/media/js/ColVis.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../observatorio/data/media/js/ZeroClipboard.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../observatorio/data/media/js/TableTools.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../observatorio/data/media/js/FixedColumns.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../observatorio/data/media/js/ColReorder.js"></script>
        <script type="text/javascript" language="javascript">
            /****************************************************************/
            $(document).ready(function () {

                oTable = $('#example').dataTable({
                    "sDom": '<"H"Cfrltip>',
                    "bJQueryUI": true,
                    "bPaginate": true,
                    "aLengthMenu": [[100], [100, "All"]],
                    "iDisplayLength": 100,
                    "sPaginationType": "full_numbers",
                    "oColVis": {
                        "buttonText": "Ver/Ocultar Columns",
                        //"aiExclude": [ 0 ]
                    }
                });
                var oTableTools = new TableTools(oTable, {
                    "buttons": [
                        "copy",
                        "csv",
                        "xls",
                        "pdf",
                        {"type": "print", "buttonText": "Print me!"}
                    ]
                });
                //$('#demo').before( oTableTools.dom.container );
            });
            /**************************************************************/

        </script>
        <div id="container">
            <h2>M&oacute;dulo de Estado de Solicitudes de  Espacios F&iacute;sicos</h2>
            <div class="demo_jui">
                <div class="DTTT_container">
                    <?php
                    if ($RolEspacioFisico == 3 || $RolEspacioFisico == 2 || $RolEspacioFisico == 4 || $RolEspacioFisico == 5) {
                        ?>
                        <button id="ToolTables_example_4" class="DTTT_button DTTT_button_text tooltip" title="Crear Solicitud"  onclick="CrearSolicitud()">
                            <span>Crear Solicitud</span>                
                        </button>
                        <button id="ToolTables_example_4" class="DTTT_button DTTT_button_text tooltip" title="Editar Solicitud"  onclick="EditarSolicitud()">
                            <span>Editar Solicitud</span>                
                        </button>
                        <button id="ToolTables_example_6" class="DTTT_button DTTT_button_text  tooltip" title="Solicitu Externa" onclick="SolicitudExterna()">
                            <span>Solicitud Externa</span>                
                        </button>
                        <button id="ToolTables_example_7" class="DTTT_button DTTT_button_text  tooltip" title="Solicitu Externa" onclick="EditarExterna()">
                            <span>Editar Externa</span>                
                        </button>
                        <button id="ToolTables_example_0" class="DTTT_button DTTT_button_text  tooltip" title="Ver Estado de la Solicitud" onclick="Ver_EstadoSolicitud()">
                            <span>Ver Estado de la Solicitud</span>                
                        </button>
                        <button id="ToolTables_example_2" class="DTTT_button DTTT_button_text  tooltip" title="Eliminar Solicitud" onclick="EliminarSolicitud()">
                            <span>Eliminar Solicitud</span>                
                        </button>

                        <?php
                    }
                    ?>

                    <?php
                    if ($RolEspacioFisico == 2 || $RolEspacioFisico == 4 || $RolEspacioFisico == 5) {
                        ?>
                        <button id="ToolTables_example_1" class="DTTT_button DTTT_button_text  tooltip" title="Asignar Espacio F&iacute;sico" onclick="AsignarEspacio()">
                            <span>Asignar Espacio F&iacute;sico</span>                
                        </button>
                        <button id="ToolTables_example_5" class="DTTT_button DTTT_button_text tooltip" title="Editar Asignacion" onclick="EditarAsignacion()">
                            <span>Editar y Ver Eventos Programados</span>                
                        </button>
                        <?php
                    } else if ($RolEspacioFisico == 1) {
                        ?>
                        <button id="ToolTables_example_0" class="DTTT_button DTTT_button_text  tooltip" title="Ver Estado de la Solicitud" onclick="Ver_EstadoSolicitud()">
                            <span>Ver Estado de la Solicitud</span>                
                        </button>
                        <button id="ToolTables_example_2" class="DTTT_button DTTT_button_text  tooltip" title="Eliminar Solicitud" onclick="EliminarSolicitud()">
                            <span>Eliminar Solicitud</span>                
                        </button>
                        <button id="ToolTables_example_5" class="DTTT_button DTTT_button_text tooltip" title="Editar Asignacion" onclick="EditarAsignacion()">
                            <span>Editar y Ver Eventos Programados</span>                
                        </button>                        
                        <?php
                    }
                    ?>

                </div>
                <input type="hidden" id="Id_Solicitud" name="Id_Solicitud" />
                <?php
                $SQL = 'SELECT
                                codigoperiodo,codigoestadoperiodo
                                FROM
                                	periodo
                                WHERE
                                	codigoestadoperiodo=1';

                if ($Dato = &$db->Execute($SQL) === false) {
                    echo 'Error en el SQL ...<br><br>' . $SQL;
                    die;
                }

                $arrayP = str_split($Dato->fields['codigoperiodo'], strlen($Dato->fields['codigoperiodo']) - 1);

                $Year = $arrayP[0];

                if ($arrayP[1] == 1) {
                    $Periodo = 1;
                    $Periodo_2 = 2;
                } else {
                    $Periodo = 2;
                    $Periodo_2 = 1;
                }

                if ($Periodo == 2) {
                    $Year_2 = $Year + 1;
                } else {
                    $Year_2 = $Year;
                }
                ?>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>    
                            <th>#</th>  
                            <th>ID Solicitud</th> 
                            <th>ID Solicitud Detalle</th>   
                            <th>D&iacute;a Semana</th> 
                            <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hora&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                            <th>Instalaci&oacute;n</th> 
                            <th>Grupo &oacute; Unidad</th>
                            <th>Materia &oacute; Evento</th> 
                            <th>Fecha Creaci&oacute;n</th> 
                            <th>Fecha Inicial</th>                     
                            <th>Fecha Final</th>
                            <th>Acceso A Discapacitado</th>
                            <th>Atendiadas/Solicitadas</th>
                            <th>Tipo De Solicitud</th>
                            <th>Tipo De Espacio</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <?php
                        $num = count($Resultado);
                        $i = 0;
                        //for($i=0;$i<=count($Resultado)+1;$i++){
                        foreach ($Resultado as $R) {
                            /*                             * ************************************************** */
                            if ($R['AccesoDiscapacitados'] == 1) {
                                $Accesso = 'Si';
                            } else {
                                $Accesso = 'No';
                            }

                            $id = $R['Padre_ID'];

                            $valor = $this->ColorPeriodo($db, $R['FechaInicio'], $R['codigomodalidadacademica']);

                            if ($valor == 1) {
                                $Color = '#e2e4ff';
                                $Type = 'Interna';
                            } else if ($valor == 2) {
                                $Color = '#FAFF6B'; //Amarillo Externo
                                $Type = 'Externa';
                            } else {
                                $Color = '#A8F7C5';
                                $Type = 'Interna';
                            }


                            if ($R['Grupo-Unidad']) {
                                if ($R['codigomodalidadacademica'] == 001 || $R['codigomodalidadacademica'] == '001') {
                                    $Nombre = '<ul>';

                                    for ($n = 0; $n < count($R['Grupo-Unidad']); $n++) {

                                        $Nombre = $Nombre . '<li>' . $R['Grupo-Unidad'][$n]['nombregrupo'] . '</li>';
                                    }

                                    $Nombre = $Nombre . '</ul>';

                                    $Materia = '<ul>';

                                    for ($n = 0; $n < count($R['Grupo-Unidad']); $n++) {

                                        $Materia = $Materia . '<li>' . $R['Grupo-Unidad'][$n]['nombremateria'] . '</li>';
                                    }

                                    $Materia = $Materia . '</ul>';
                                } else {
                                    $Nombre = $R['Grupo-Unidad'][0]['UnidadNombre'] . '::' . $R['Grupo-Unidad'][0]['nombrecarrera'];
                                    $Materia = $R['Grupo-Unidad'][0]['NombreEvento'];
                                }
                            }


                            $Dia = '<ul>';
                            for ($d = 0; $d < count($R['Dia']); $d++) {
                                $Dia = $Dia . '<li>' . $R['Dia'][$d] . '</li>';
                            }
                            $Dia = $Dia . '</ul>';

                            $Hijos = '<ul>';
                            for ($h = 0; $h < count($R['Hijos']); $h++) {
                                $Hijos = $Hijos . '<li>' . $R['Hijos'][$h] . '</li>';
                            }
                            $Hijos = $Hijos . '</ul>';

                            $Horas = '<ul>';
                            for ($c = 0; $c < count($R['Hora']); $c++) {
                                $Horas = $Horas . '<li>' . $R['Hora'][$c] . '</li>';
                            }
                            $Horas = $Horas . '</ul>';

                            $Instalacion = '<ul>';
                            for ($s = 0; $s < count($R['Instalacion']); $s++) {
                                $Instalacion = $Instalacion . '<li>' . $R['Instalacion'][$s] . '</li>';
                            }
                            $Instalacion = $Instalacion . '</ul>';


                            $Salon = '<ul>';
                            for ($s = 0; $s < count($R['Salon']); $s++) {
                                $Salon = $Salon . '<li>' . $R['Salon'][$s] . '</li>';
                            }
                            $Salon = $Salon . '</ul>';
                            ?>
                            <tr style="background: <?php echo $Color ?>;" id="Tr_File_<?php echo $i ?>" onclick="CargarNum('<?php echo $i ?>', '<?php echo $id ?>', '<?php echo $num ?>')"  onmouseover="ColorNeutro('<?php echo $i ?>', '<?php echo $R['FechaInicio'] ?>', '<?php echo $R['codigomodalidadacademica'] ?>');">       
                                <td><?php echo $i + 1 ?></td>
                                <td><?php echo $id ?></td>
                                <td><?php echo $Hijos ?></td>
                                <td><?php echo $Dia ?></td>
                                <td style="font-size: 14px;"><?php echo $Horas ?></td>  
                                <td><?php echo $Instalacion ?></td> 
                                <td><?php echo $Nombre ?></td> 
                                <td><?php echo $Materia ?></td>
                                <td><?php echo $R['FechaCreacion'] ?></td> 
                                <td><?php echo $R['FechaInicio'] ?></td>                     
                                <td><?php echo $R['FechaFinal'] ?></td>
                                <td style="text-align: center;"><?php echo $Accesso ?></td>
                                <td><?php echo $R['Num_Atendida'] . '/' . $R['Total'] ?></td>
                                <td><?php echo $Type ?></td>
                                <td><?php echo $Salon ?></td>
                            </tr>
                            <?php
                            /*                             * ************************************************** */
                            $i++;
                        }//for
                        ?>                      
                    </tbody>
                </table>
                <div>
                    <table>
                        <tr>
                            <td>
                                <img src="../../mgi/images/Office-Excel-icon.png" width="40" style="cursor: pointer;" onclick="ExportarExcel();" title="Exportar a Excel" />
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="DTTT_container">
                <?php
                if ($RolEspacioFisico == 3 || $RolEspacioFisico == 2 || $RolEspacioFisico == 4 || $RolEspacioFisico == 5) {
                    ?>
                    <button id="ToolTables_example_4" class="DTTT_button DTTT_button_text tooltip" title="Crear Solicitud"  onclick="CrearSolicitud()">
                        <span>Crear Solicitud</span>                
                    </button>
                    <button id="ToolTables_example_4" class="DTTT_button DTTT_button_text tooltip" title="Editar Solicitud"  onclick="EditarSolicitud()">
                        <span>Editar Solicitud</span>                
                    </button>
                    <button id="ToolTables_example_6" class="DTTT_button DTTT_button_text  tooltip" title="Solicitu Externa" onclick="SolicitudExterna()">
                        <span>Solicitud Externa</span>                
                    </button>
                    <button id="ToolTables_example_7" class="DTTT_button DTTT_button_text  tooltip" title="Solicitu Externa" onclick="EditarExterna()">
                        <span>Editar Externa</span>                
                    </button>
                    <button id="ToolTables_example_0" class="DTTT_button DTTT_button_text  tooltip" title="Ver Estado de la Solicitud" onclick="Ver_EstadoSolicitud()">
                        <span>Ver Estado de la Solicitud</span>                
                    </button>
                    <button id="ToolTables_example_2" class="DTTT_button DTTT_button_text  tooltip" title="Eliminar Solicitud" onclick="EliminarSolicitud()">
                        <span>Eliminar Solicitud</span>                
                    </button>

                    <?php
                }
                ?>

                <?php
                if ($RolEspacioFisico == 2 || $RolEspacioFisico == 4 || $RolEspacioFisico == 5) {
                    ?>
                    <button id="ToolTables_example_1" class="DTTT_button DTTT_button_text  tooltip" title="Asignar Espacio F&iacute;sico" onclick="AsignarEspacio()">
                        <span>Asignar Espacio F&iacute;sico</span>                
                    </button>
                    <button id="ToolTables_example_5" class="DTTT_button DTTT_button_text tooltip" title="Editar Asignacion" onclick="EditarAsignacion()">
                        <span>Editar y Ver Eventos Programados</span>                
                    </button>
                    <?php
                } else if ($RolEspacioFisico == 1) {
                    ?>
                    <button id="ToolTables_example_0" class="DTTT_button DTTT_button_text  tooltip" title="Ver Estado de la Solicitud" onclick="Ver_EstadoSolicitud()">
                        <span>Ver Estado de la Solicitud</span>                
                    </button>
                    <button id="ToolTables_example_2" class="DTTT_button DTTT_button_text  tooltip" title="Eliminar Solicitud" onclick="EliminarSolicitud()">
                        <span>Eliminar Solicitud</span>                
                    </button>
                    <button id="ToolTables_example_5" class="DTTT_button DTTT_button_text tooltip" title="Editar Asignacion" onclick="EditarAsignacion()">
                        <span>Editar y Ver Eventos Programados</span>                
                    </button>                        
                    <?php
                }
                ?>

            </div>
        </div> 
        <?php
    }//public funcion principal

    public function MultiGrupoView($db, $id) {
        $SQL = 'SELECT
                	sg.idgrupo,
                    g.nombregrupo,
                	g.maximogrupo
                FROM
                	SolicitudAsignacionEspacios s
                                                    INNER JOIN SolicitudEspacioGrupos sg ON sg.SolicitudAsignacionEspacioId = s.SolicitudAsignacionEspacioId
                                                    INNER JOIN grupo g ON g.idgrupo=sg.idgrupo
                WHERE
                	s.SolicitudAsignacionEspacioId = "' . $id . '"
                AND s.codigoestado = 100';

        if ($MultiGroup = &$db->Execute($SQL) === false) {
            echo 'Error en el SQl multigrupo View...<br><br>' . $SQL;
            die;
        }

        $C_Multi = $MultiGroup->GetArray();

        $Num = count($C_Multi);

        $C_Resultado = array();

        if ($Num > 1) {
            $C_Resultado['val'] = true;
            $Name = '';
            $codigo = '';
            for ($i = 0; $i < $Num; $i++) {
                if ($i == 0) {
                    $Name = $C_Multi[$i]['nombregrupo'];
                    $codigo = $C_Multi[$i]['idgrupo'];
                } else {
                    $Name = $Name . ' :: ' . $C_Multi[$i]['nombregrupo'];
                    $codigo = $codigo . ' :: ' . $C_Multi[$i]['idgrupo'];
                }
            }
            $C_Resultado['name'] = $Name;
            $C_Resultado['codigo'] = $codigo;
        } else {
            $C_Resultado['val'] = false;
        }
        return $C_Resultado;
    }

//public function MultiGrupoView

    public function ColorPeriodo($db, $fecha_1, $Modalidad) {
        $SQL = 'SELECT
            date(fechainicioperiodo) AS fecha_ini, date(fechavencimientoperiodo) AS fecha_fin ,codigoperiodo,codigoestadoperiodo
    FROM
            periodo
    WHERE
            "' . $fecha_1 . '" BETWEEN fechainicioperiodo AND fechavencimientoperiodo';

        if ($Fechas = &$db->Execute($SQL) === false) {
            echo 'Error en el SQL de las Fechas del Periodo Academico.....<br><br>' . $SQL;
            die;
        }
        if ($Fechas->fields['codigoestadoperiodo'] == 1 && $Modalidad == 001) {
            $Color = 1;
        } else if ($Fechas->fields['codigoestadoperiodo'] != 1 && $Modalidad == 001) {
            $Color = 0;
        } else if ($Modalidad != 001 || $Modalidad != '001') {
            $Color = 2;
        }

        return $Color;
    }//public function ColorPeriodo

    public function DataSolicitudesPrint($db, $Userid, $Rol){
        //consulta datos del responsable 
        $Espacio = $this->EspaciosUser($db, $Userid);
        
        //si el codigo de facultad es 1 (todos los programas) o 156 (General)
        if ($_SESSION['codigofacultad'] == 1 || $_SESSION['codigofacultad'] == 156){
            $Condicion = "";
            $Condicion_2 = "";
        } else {
            $Condicon_Other ="";
            //si el rol diferente a 3 o 5
            if ($Rol != 3 && $Rol != 5) {
                $Condicon_Other = " OR  st.codigotiposalon=r.CodigoTipoSalon";
            }
            
            $Condicion = " AND ( m.codigocarrera='".$_SESSION['codigofacultad']."' ".
            " OR s.UsuarioCreacion='".$Userid."' OR s.codigocarrera='".$_SESSION['codigofacultad']."' ".$Condicon_Other." )";

            $Condicion_2 = " AND ( m.codigocarrera='".$_SESSION['codigofacultad']."' ".
            " OR  s.codigocarrera='".$_SESSION['codigofacultad']."' OR (s.UsuarioCreacion='".$Userid."'  AND st.codigotiposalon=r.CodigoTipoSalon) )";
            /* Actualizar campo codigocarrera tabla solicitud  para las internas */
        }

        $Fechas = $this->FechasPeriodo($db);

        if ($Fechas['val'] == true) {
            $C_fecha = explode('-', $Fechas['FechaFin']);
            if ($C_fecha[1] == 06 || $C_fecha[1] == '06') {
                $Fechaini_2 = $C_fecha[0] . '-07-01';
                $Fechafin_2 = $C_fecha[0] . '-12-31';
            }if ($C_fecha[1] == 12 || $C_fecha[1] == '12') {
                $year = $C_fecha[0] + 1;
                $Fechaini_2 = $year . '-01-01';
                $Fechafin_2 = $year . '-06-30';
            }
               /*
                * Agregar AND en $CondicionFecha (caso  96019)
                * Vega Gabriel <vegagabriel@unbosque.edu.do>.
                * Universidad el Bosque - Direccion de Tecnologia.
                * Modificado 4 de Diciembre de 2017.
                */  
            $CondicionFecha = 'AND asi.FechaAsignacion >= CURDATE() ';             
                /*end*/
        } else {
            $CondicionFecha = '';
        }

        /*******Lo Nuevo********************** */
        $DataResult = $this->ConsuntaPadreSolcitud($db, $Userid, $CondicionFecha, $Condicion, $Rol, $Condicion_2);
        Return $DataResult;
        /***/
    }//public function DataSolicitudesPrint

    public function ConsuntaPadreSolcitud($db, $Userid, $CondicionFecha, $Condicion, $Rol, $Condicion_2) {
        $CondicionResponsables = '';

        if ($Rol != 3 && $Rol != 5) {
            $CondicionResponsables = 'AND r.UsuarioId="' . $Userid . '" AND r.CodigoEstado=100';
        }



               /*
                * Agregar 1 en los Where para que no genera erroe de sintaxis (caso  96019)
                * Vega Gabriel <vegagabriel@unbosque.edu.do>.
                * Universidad el Bosque - Direccion de Tecnologia.
                * Modificado 4 de Diciembre de 2017.
                */  
        $SQL = 'SELECT
                    sp.SolicitudPadreId,
                    a.SolicitudAsignacionEspaciosId,
                    s.SolicitudAsignacionEspacioId,
                    DATE(s.FechaInicio),
                    t.nombretiposalon
            
              FROM
                    SolicitudPadre sp
                    INNER JOIN AsociacionSolicitud a ON a.SolicitudPadreId = sp.SolicitudPadreId
                    INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = a.SolicitudAsignacionEspaciosId
                    INNER JOIN SolicitudAsignacionEspaciostiposalon st ON st.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
                    INNER JOIN AsignacionEspacios asi ON asi.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
                    INNER JOIN tiposalon t ON t.codigotiposalon=st.codigotiposalon
                    INNER JOIN ResponsableEspacioFisico r ON r.CodigoTipoSalon=st.codigotiposalon
                    LEFT JOIN SolicitudEspacioGrupos sg ON sg.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
                    LEFT JOIN grupo g ON g.idgrupo=sg.idgrupo
                    LEFT JOIN materia m ON m.codigomateria=g.codigomateria
                    
                    WHERE 1
                    
                    ' . $CondicionFecha . '  
					' . $CondicionResponsables . ' 
					AND (sp.CodigoEstado = 100 OR sp.CodigoEstado IS NULL) 
                    AND s.codigoestado=100 
                    ' . $Condicion . '
            
             GROUP BY sp.SolicitudPadreId
             
             UNION
             
             SELECT
                    sp.SolicitudPadreId,
                    a.SolicitudAsignacionEspaciosId,
                    s.SolicitudAsignacionEspacioId,
                    DATE(s.FechaInicio),
                    t.nombretiposalon
            
              FROM
                    SolicitudPadre sp
                    INNER JOIN AsociacionSolicitud a ON a.SolicitudPadreId = sp.SolicitudPadreId
                    INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = a.SolicitudAsignacionEspaciosId
                    INNER JOIN SolicitudAsignacionEspaciostiposalon st ON st.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
                    INNER JOIN AsignacionEspacios asi ON asi.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
                    INNER JOIN tiposalon t ON t.codigotiposalon=st.codigotiposalon
                    INNER JOIN ResponsableEspacioFisico r ON r.CodigoTipoSalon=st.codigotiposalon
                    LEFT JOIN SolicitudEspacioGrupos sg ON sg.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
                    LEFT JOIN grupo g ON g.idgrupo=sg.idgrupo
                    LEFT JOIN materia m ON m.codigomateria=g.codigomateria
                    
                    WHERE 1
                    
                    ' . $CondicionFecha . '  
					 
					AND (sp.CodigoEstado = 100 OR sp.CodigoEstado IS NULL) 
                    AND s.codigoestado=100 
                    ' . $Condicion_2 . '
            
             GROUP BY sp.SolicitudPadreId';
//end
        if ($ConsutaPadre = &$db->Execute($SQL) === false) {
            echo 'Error en el SQL del Padre solicitud ID ....<br><br>' . $SQL;
            die;
        }

        $Resultado = array();
        $i = 0;
        while (!$ConsutaPadre->EOF) {
            /*             * **************************************************** */
            $Padre_ID = $ConsutaPadre->fields['SolicitudPadreId'];

            $SQL_Contenido = 'SELECT
                                	s.SolicitudAsignacionEspacioId,
                                	s.codigodia,
                                	s.ClasificacionEspaciosId,
                                	s.codigomodalidadacademica,
                                	s.codigocarrera,
                                	asg.HoraInicio,
                                	asg.HoraFin,
                                	d.nombredia,
                                	c.Nombre AS Instalacion,
                                    s.AccesoDiscapacitados,
                                    s.FechaCreacion,
                                    s.FechaInicio,
                                    s.FechaFinal,
                                    t.nombretiposalon
                                FROM
                                	AsociacionSolicitud a
                                    INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = a.SolicitudAsignacionEspaciosId
                                    INNER JOIN AsignacionEspacios asg ON asg.SolicitudAsignacionEspacioId = s.SolicitudAsignacionEspacioId
                                    INNER JOIN dia d ON d.codigodia = s.codigodia
                                    INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = s.ClasificacionEspaciosId
                                    INNER JOIN SolicitudAsignacionEspaciostiposalon st ON st.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
		                            INNER JOIN tiposalon t ON t.codigotiposalon=st.codigotiposalon
                                WHERE
                                	a.SolicitudPadreId ="' . $Padre_ID . '"
                                AND s.codigoestado = 100
                                GROUP BY
                                    s.SolicitudAsignacionEspacioId,
                                    s.codigodia,
                                    s.ClasificacionEspaciosId,
                                    s.codigocarrera
                                ORDER BY s.codigodia, asg.HoraInicio';

            if ($Contenido = &$db->Execute($SQL_Contenido) === false) {
                echo 'Error en el SQL del Contenido solicitud  ....<br><br>' . $SQL_Contenido;
                die;
            }
            //echo $SQL_Contenido;
            if (!$Contenido->EOF) {
                if ($Contenido->fields['codigomodalidadacademica'] == '001' || $Contenido->fields['codigomodalidadacademica'] == 001) {
                    /*                     * ****************Internas***************************** */
                    $SQL_ContDetalle = 'SELECT
                                                        g.idgrupo,
                                                        g.nombregrupo,
                                                        m.codigomateria,
                                                        m.nombremateria,
                                                        c.nombrecarrera
                                                FROM
                                                        SolicitudEspacioGrupos sg 
                                                        INNER JOIN grupo g ON g.idgrupo=sg.idgrupo
                                                        INNER JOIN materia m ON m.codigomateria=g.codigomateria
                                                        INNER JOIN carrera c ON c.codigocarrera=m.codigocarrera
                                                
                                                WHERE
                                                
                                                        sg.SolicitudAsignacionEspacioId="' . $Contenido->fields['SolicitudAsignacionEspacioId'] . '"
                                                        AND
                                                        sg.codigoestado=100';
                } else {
                    /*                     * ****************Externas***************************** */
                    $SQL_ContDetalle = 'SELECT
                                                    	s.NombreEvento,
                                                    	s.NumAsistentes,
                                                    	s.UnidadNombre,
                                                    	s.Responsable,
                                                        c.nombrecarrera
                                                FROM
                                                	   SolicitudAsignacionEspacios s INNER JOIN carrera c ON c.codigocarrera=s.codigocarrera
                                                WHERE
                                                       s.SolicitudAsignacionEspacioId ="' . $Contenido->fields['SolicitudAsignacionEspacioId'] . '"
                                                       AND 
                                                       s.codigoestado = 100';
                }

                if ($ContDetalle = &$db->Execute($SQL_ContDetalle) === false) {
                    echo 'Error en el SQL del Contenido Detalle...<br><br>' . $SQL_ContDetalle;
                    die;
                }
                $C_Detalle = $ContDetalle->GetArray();

                /*                 * *******************Construir Array()**************** */
                $Resultado[$i]['Padre_ID'] = $Padre_ID;
                $O = 0;
                $N = 0;
                while (!$Contenido->EOF) {
                    /*                     * ************************************** */
                    $Resultado[$i]['Hijos'][] = $Contenido->fields['SolicitudAsignacionEspacioId'];
                    $Resultado[$i]['Dia'][] = $Contenido->fields['nombredia'];
                    $Resultado[$i]['Hora'][] = substr($Contenido->fields['HoraInicio'], 0, 5) . ' :: ' . substr($Contenido->fields['HoraFin'], 0, 5);
                    $Resultado[$i]['Instalacion'][] = $Contenido->fields['Instalacion'];
                    $Resultado[$i]['Salon'][] = $Contenido->fields['nombretiposalon'];
                    $Resultado[$i]['Grupo-Unidad'] = $C_Detalle;
                    $Resultado[$i]['AccesoDiscapacitados'] = $Contenido->fields['AccesoDiscapacitados'];
                    $Resultado[$i]['FechaCreacion'] = $Contenido->fields['FechaCreacion'];
                    $Resultado[$i]['FechaInicio'] = $Contenido->fields['FechaInicio'];
                    $Resultado[$i]['FechaFinal'] = $Contenido->fields['FechaFinal'];
                    $Resultado[$i]['codigomodalidadacademica'] = $Contenido->fields['codigomodalidadacademica'];
                    $Resultado[$i]['codigocarrera'] = $Contenido->fields['codigocarrera'];

                    /*                     * *************************************** */

                    $SQL_X = 'SELECT
                                a.ClasificacionEspaciosId
                                FROM
                                AsignacionEspacios a
                                
                                WHERE  a.codigoestado=100 and a.SolicitudAsignacionEspacioId="' . $Contenido->fields['SolicitudAsignacionEspacioId'] . '"';

                    if ($Info = &$db->Execute($SQL_X) === false) {
                        echo 'Error al Calcular Atendidas...<br><br>' . $SQL_X;
                        die;
                    }

                    while (!$Info->EOF) {
                        /*                         * ********************************* */
                        if ($Info->fields['ClasificacionEspaciosId'] != 212) {
                            $O = $O + 1;
                        } else {
                            $N = $N + 1;
                        }
                        /*                         * ********************************* */
                        $Info->MoveNext();
                    }

                    /*                     * ************************************** */
                    $Contenido->MoveNext();
                }//while Hijos

                $Resultado[$i]['Num_Atendida'] = $O;
                $Resultado[$i]['Total'] = $N + $O;
            }
            /*             * **************************************************** */

            $ConsutaPadre->MoveNext();
            $i++;
        }//while

        return $Resultado;
    }

//public function ConsuntaPadreSolcitud

    public function EspaciosUser($db, $userid) {
        $SQL = "SELECT * FROM ResponsableEspacioFisico ".
        " WHERE UsuarioId=".$userid." AND CodigoEstado=100 AND EspaciosFisicosId=5";

        if ($Espacio = &$db->Execute($SQL) === false) {
            echo 'Error en el SQL del ....<br><br>' . $SQL;
            die;
        }

        if (!$Espacio->EOF) {
            return 1;
        } else {
            return 0;
        }
    }//public function EspaciosUser

    public function FechasPeriodo($db){
        /*
         * Ivan Quintero 
         * Diciembre 27 2018
         * Modificacion de consulta de periodos
         */
        $SQL = "SELECT date(p.fechainicioperiodo) AS fecha_ini, date(p.fechavencimientoperiodo) AS fecha_fin ".
        " FROM periodo p ".
        " WHERE (p.codigoestadoperiodo = 1 or p.codigoestadoperiodo = 3 or p.codigoestadoperiodo = 4) limit 1";
        /*end*/
        if ($Fechas = &$db->Execute($SQL) === false) {
            echo 'Error en el SQL de las Fechas del Periodo Academico.....<br><br>' . $SQL;
            die;
        }
        $C_Fecha = array();
        if (!$Fechas->EOF) {
            $C_Fecha['val'] = true;
            $C_Fecha['FechaIni'] = $Fechas->fields['fecha_ini'];
            $C_Fecha['FechaFin'] = $Fechas->fields['fecha_fin'];
        } else {
            $C_Fecha['val'] = false;
        }

        return $C_Fecha;        
    }//public function Periodo

    public function VerEstadoSolicitud($id, $db, $Asignacion = '', $Userid = '') {
        $Data = $this->DataVer($db, $id);


        if ($Data['codigomodalidadacademica'] == '001') {
            $TipoSolicitud = 1;
        } else {
            $TipoSolicitud = 2;
        }
        ?>

        <style>
            th{
                text-align: left;
            }
        </style>
        <form id="FromAsignacion" method="POST">
            <input id="actionID" name="actionID" type="hidden" value="" />
            <input id="Index_i" name="i" type="hidden" value="" />
            <input id="Index_j" name="j" type="hidden" value="" />
            <input id="id_Soli" name="id_Soli" type="hidden" value="<?php echo $id ?>" />
            <table> 
                <thead>
        <?php
        if ($TipoSolicitud == 1) {
            ?>
                        <tr>
                            <th>Programa Acad&eacute;mico</th>
                            <td><?php echo $Data['nombrecarrera'] ?><input type="hidden" id="Carrera" name="Carrera" value="<?php echo $Data['codigocarrera'] ?>" /></td>
                            <th>&nbsp;</th>
                            <td style="color:#<?php //echo $Data['Color'] ?>;"><samp style="font-size:25px;">&nbsp;<strong><?php //echo $Data['Estadotext'] ?></strong></samp></td>
                        </tr>
                        <tr>
                            <th colspan="2">Materia</th>
                            <th colspan="2">Grupo</th>
                        </tr>
                        <?php
                        for ($i = 0; $i < count($Data['idgrupo']); $i++) {
                            ?>
                            <tr>
                                <td colspan="2"><?php echo $Data['codigomateria'][$i] . '::' . $Data['nombremateria'][$i] ?></td>
                                <td colspan="2"><?php echo $Data['idgrupo'][$i] . '::' . $Data['nombregrupo'][$i] ?></td>
                            </tr>
                            <?php
                            if ($i == 0) {
                                $Max = $Data['max'][$i];
                                $Matriculados = $Data['matriculados'][$i];
                                $Prematriculados = $Data['prematriculados'][$i];
                            } else {
                                $Max = $Max + $Data['max'][$i];
                                $Matriculados = $Matriculados + $Data['matriculados'][$i];
                                $Prematriculados = $Prematriculados + $Data['prematriculados'][$i];
                            }
                        }
                        ?>

                        <tr>
                            <th colspan="4">N&uacute;mero de Estudiantes</th>
                        </tr>
                        <tr>
                            <th colspan="4"> 
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="text-align: center;">Maximo Cupo</td>
                                        <td style="text-align: center;">Matriculados</td>
                                        <td style="text-align: center;">Pre-Matriculados</td>
                                        <td style="text-align: center;">Matriculados y Pre-Matriculados</td>
                                    </tr>

                                    <tr>
                                        <td style="text-align: center;"><?php echo $Max ?>&nbsp;&nbsp;
                                            <?php if ($Asignacion == 1) { ?>
                                                <input type="radio" name="NumEstudiantes" id="Max" value="<?php echo $Max ?>" />
                                            <?php } ?>
                                        </td><!--Maximo Cupo-->
                                        <td style="text-align: center;"><?php echo $Matriculados ?>&nbsp;&nbsp;
                                            <?php if ($Asignacion == 1) { ?>
                                                <input type="radio" name="NumEstudiantes" id="matriculados" value="<?php echo $Matriculados ?>" />
                                            <?php } ?>
                                        </td><!--Matriculados-->
                                        <td style="text-align: center;"><?php echo $Prematriculados ?>&nbsp;&nbsp;
                                            <?php if ($Asignacion == 1) { ?>
                                                <input type="radio" name="NumEstudiantes" id="prematriculados" value="<?php echo $Prematriculados ?>" />
            <?php } ?>
                                        </td><!--Pre-Matriculados-->
                                        <td style="text-align: center;"><?php echo $Matriculados + $Prematriculados ?>&nbsp;&nbsp;
                        <?php if ($Asignacion == 1) { ?>
                                                <input type="radio" name="NumEstudiantes" id="Media" value="<?php echo $Matriculados + $Prematriculados ?>" />
                        <?php } ?>
                                        </td><!--Media-->
                                    </tr>
                                </table>
                            </th>
                        </tr>
            <?php
        } else {
            ?>
                        <tr>
                            <th>Unidad Academica &oacute; Administrativa:</th>
                            <th><?php echo $Data['nombremodalidadacademica'] ?></th>
                        </tr>
                        <tr>
                            <th>Nombre de la Unidad Solicitante:</th>
                            <th><?php echo $Data['UnidadNombre'] ?></th>
                        </tr>
                        <tr>
                            <th>Nombre de la Actividad - Evento:</th>
                            <th><?php echo $Data['NombreEvento'] ?></th>
                        </tr>
                        <tr>
                            <th colspan="2">
                                <table>
                                    <tr>
                                        <th colspan="2">Materia</th>
                                        <th colspan="2">Grupo</th>
                                    </tr>
                                    <?php
                                    for ($i = 0; $i < count($Data['idgrupo']); $i++) {
                                        ?>
                                        <tr>
                                            <td colspan="2"><?php echo $Data['codigomateria'][$i] . '::' . $Data['nombremateria'][$i] ?></td>
                                            <td colspan="2"><?php echo $Data['idgrupo'][$i] . '::' . $Data['nombregrupo'][$i] ?></td>
                                        </tr>
                <?php
            }
            ?>

                                    <tr>
                                </table>
                            </th>
                        </tr>
                        <tr>
                                <?php
                                if ($Asignacion == 1) {
                                    ?>
                                <th>N&deg; Asistentes:</th>
                                <th><?php echo $Data['NumAsistentes'];
                                    if ($Asignacion == 1) {
                                        ?>&nbsp;&nbsp;<input type="radio" name="NumEstudiantes" id="NumAsitentes" value="<?php echo $Data['NumAsistentes'] ?>" checked="true" /> <?php } ?></th>
                                <?php
                            } else {
                                ?>
                                <th>N&deg; Asistentes:</th>
                                <th>
                                    <input type="text" maxlength="3" size="5" style="text-align: center;" value="<?php echo $Data['NumAsistentes']; ?>" id="Num" name="Num" />&nbsp;&nbsp;<img src="../../mgi/images/Check.png" width="20" style="cursor: pointer;" onclick="ModificaNum()" id="UP_Num" title="Modificar Numero de Asistentes..."  />
                                </th>
                <?php
            }
            ?>
                        </tr>
                        <tr>
                            <th colspan="2">
                                <fieldset>
                                    <legend>Informaci&oacute;n Contacto</legend>
                                    <table>
                                        <tr>
                                            <th>Persona Responsable:</th>
                                            <th><?php echo $Data['Responsable'] ?></th>
                                        </tr>    
                                        <tr>    
                                            <th>Telefono:</th>
                                            <th><?php echo $Data['Telefono'] ?></th>
                                        </tr>
                                        <tr>    
                                            <th>E-mail:</th>
                                            <th><?php echo $Data['Email'] ?></th>
                                        </tr>
                                    </table>
                                </fieldset>
                            </th>
                        </tr>
                            <?php
                        }
                        ?>
                    <tr>
                        <th>Acceso a Discapacitados</th>                        
                        <?php
                        if ($Asignacion == 1) {
                            if ($Data['AccesoDiscapacitados'] == 1) {
                                $Check_1 = 'checked';
                                $Check_0 = '';
                            } else {
                                $Check_1 = '';
                                $Check_0 = 'checked';
                            }
                            ?>
                            <td>
                                Si&nbsp;<input type="radio" <?php echo $Check_1 ?> value="1" id="Acceso_1" name="Acceso" />&nbsp;&nbsp;No&nbsp;<input type="radio" <?php echo $Check_0 ?> value="0" id="Acceso_0" name="Acceso" />
                            </td>
            <?php
        } else {
            ?>
                            <td><?php echo $Data['Acceso'] ?><input  type="hidden" id="Acceso" name="Acceso" value="<?php echo $Data['AccesoDiscapacitados'] ?>" /></td>
                            <?php
                        }
                        ?>
                    </tr>
                    <tr>
                        <th>Observaciones</th>
                        <?php
                        if ($Asignacion == 1) {
                            ?>
                            <td>
                                <textarea rows="35" cols="55" name="Observaciones" id="Observaciones"><?php echo $Data['Observaciones'] ?></textarea>
                            </td>
                            <td><img src="../../mgi/images/Check.png" width="20" style="cursor: pointer;" onclick="ModificaObs()" id="UpObservciones" title="Click para Modificar Observacion..."  /></td>
            <?php
        } else {
            ?>
                            <td><?php echo $Data['Observaciones'] ?></td>
                            <td colspan="2">&nbsp;</td>
            <?php
        }
        ?>

                    </tr>
                    <tr>

                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <?php
                        if ($Asignacion == 1) {
                            ?>
                            <th>Fecha Inicial</th>
                            <td><?php echo $Data['FechaInicio'] ?></td>
                            <th>Fecha Final</th>
                            <td><?php echo $Data['FechaFinal'] ?></td>
                            <?php
                        }
                        ?>
                    </tr>
                    <tr>

                        <?php
                        if ($Data['EventoUnico'] == 1) {
                            ?>

                            <th>Fecha Inicial</th>
                            <td><?php echo $Data['FechaInicio'] ?><input type="hidden" id="FechaIni" name="FechaIni" value="<?php echo $Data['FechaInicio'] ?>" /></td>.

                            <?php
                        } else {
                            if ($Asignacion == 1) {
                                FechaBox($db, 'Fecha Inicio Programación', 'FechaIni', 'Fecha Inicial', date('Y-m-d'), 'readonly="readonly"', '', '');
                            } else {
                                ?>
                                <th>Fecha Inicial</th>
                                <td><?php echo $Data['FechaInicio'] ?><input type="hidden" id="FechaIni" name="FechaIni" value="<?php echo $Data['FechaInicio'] ?>" /></td>
                <?php
            }
        }
        ?>

                        <?php
                        if ($Data['EventoUnico'] == 1) {
                            ?>
                            <th>Fecha Final</th>
                            <td><?php echo $Data['FechaFinal'] ?><input type="hidden" id="FechaFinal" name="FechaFinal" value="<?php echo $Data['FechaFinal'] ?>" /></td>
                            <?php
                        } else {
                            if ($Asignacion == 1) {
                                FechaBox($db, 'Fecha Final Programación', 'FechaFinal', 'Fecha Final', $Data['FechaFinal'], 'readonly="readonly"', '', '');
                            } else {
                                ?>
                                <th>Fecha Final</th>
                                <td><?php echo $Data['FechaFinal'] ?><input type="hidden" id="FechaFinal" name="FechaFinal" value="<?php echo $Data['FechaFinal'] ?>" /></td>
                <?php
            }
        }
        ?>
                    </tr>
        <?php
        if ($Asignacion == 1) {
            ?>
                        <tr>
                            <td colspan="4" style="text-align: right;">
                                Programaci&oacute;n Automatica&nbsp;&nbsp;<img src="../imagenes/preferences-system-time.png" style="cursor: pointer;" title="Programaci&oacute;n Automatica" width="30" onclick="EspacioAutomatico()" />
                            </td>
                        </tr>
                        <tr>    
                            <td colspan="4">
                                <div id="dialog-form" title="" style="display: none;">
                                    <fieldset style="width: 95%; margin-left: 2%;">
                                        <legend>Programaci&oacute;n Automatica</legend>
                                        <table>
                                            <tr>
                                                <td colspan="3">
                                                    <p class="validateTips">Indique el n&uacute;mero maximo de busqueda para el aula.</p>
                                                </td>
                                                <td>
                                                    <input type="text" id="Num" name="Num" style="text-align: center;" size="2" />(<samp style="color: red;">*</samp>)
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <button type="button" id="AsignaAuto" value="Automatico" onclick="AutomaticoAsignacion('<?php echo $id ?>')">Automatico</button>
                                                </td>
                                            </tr>
                                        </table>
                                    </fieldset>
                                </div>
                            </td>
                        </tr>
            <?php
        }
        ?>
                </thead> 
                <tbody>
                    <tr>
                        <td colspan="4"><div id="DivDistrator"></div>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div id="Div_ContenidoDetalle">
        <?php
        $this->ContenidoDetalle($db, $id, $Asignacion, '', $Userid);
        ?>  
                            </div>  
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                </tbody>
            </table>
        </form>
        <form id="DataNewCarga">
            <input type="hidden" name="TipoSalon" id="TipoSalon" />
            <input type="hidden" name="Acceso" id="Acceso" />
            <input type="hidden" name="NumEstudiantes" id="NumEstudiantes" />
            <input type="hidden" name="Campus" id="Campus" />
            <input type="hidden" name="FechaAsignacion" id="FechaAsignacion" />
            <input type="hidden" name="HoraInicial" id="HoraInicial" />
            <input type="hidden" name="HoraFin" id="HoraFin" />
            <input type="hidden" name="idAsignacion" id="idAsignacion" />
            <input type="hidden" name="id_Soli" id="id_Soli" />
            <input type="hidden" name="id_Soli_Hijo" id="id_Soli_Hijo" />
            <input type="hidden" name="actionID" id="actionID_2" />
        </form>
        <?php
    }

//public function VerEstadoSolicitud

    public function DisponibilidadManual($db, $TipoSalon, $Acceso, $Max, $Sede, $Feha_inicial, $Feha_final, $Hora_ini, $Hora_fin, $id_Soli, $Asignacio_id, $userid, $id_Soli_Hijo = '', $RolEspacioFisico = '') {

        include_once('../Solicitud/AsignacionSalon.php');
        $C_AsignacionSalon = new AsignacionSalon();
        // include_once('../Solicitud/festivos.php');        $C_Festivo         = new festivos();

        $SQL = 'SELECT
	sg.idgrupo,
	c.codigocarrera
        FROM
                SolicitudEspacioGrupos sg
        INNER JOIN grupo g ON g.idgrupo = sg.idgrupo
        INNER JOIN materia m ON m.codigomateria = g.codigomateria
        INNER JOIN carrera c ON c.codigocarrera = m.codigocarrera
        WHERE
                sg.SolicitudAsignacionEspacioId = "' . $id_Soli_Hijo . '"
        AND sg.codigoestado = 100';

        if ($Grupo = &$db->Execute($SQL) === false) {
            echo 'Error en el SQL del Grupo....<br><br>' . $SQL;
            die;
        }
        ?>
        <script type="text/javascript" language="javascript" src="../asignacionSalones/calendario3/wdCalendar/EventoSolicitud.js"></script> 
        <form id="AsignacionManual">
            <input type="hidden" id="actionID" name="actionID" value="" />
            <input type="hidden" id="id_Soli" name="id_Soli" value="<?php echo $id_Soli ?>" />
            <input type="hidden" id="id_Soli_Hijo" name="id_Soli_Hijo" value="<?php echo $id_Soli_Hijo ?>" />
            <input type="hidden" id="Asignacio_id" name="Asignacio_id" value="<?php echo $Asignacio_id ?>" />
            <div style="overflow-y: scroll; width:auto; height: 700px;">
                    <?php
                    $C_AsignacionSalon->Disponibilidad($db, $Sede, $TipoSalon, $Feha_inicial, $Feha_final, $Hora_ini, $Hora_fin, $Acceso, $Max, 1, $Grupo->fields['idgrupo'], $Grupo->fields['codigocarrera'], '', $userid, $RolEspacioFisico);
                    $Data = $C_AsignacionSalon->ValidacionGrupoEspacio($db, $Grupo->fields['idgrupo'], $Feha_inicial, $Hora_ini, $Hora_fin);
                    ?>
                <br />
                <div style="text-align: right;">
        <?php
        if ($Data['val'] == true) {
            ?>
                        <input type="button" id="SaveManual" name="SaveManual" onclick="ManualSave()" value="Asignar Aula." style="cursor: pointer;" title="Asingar Aula." />
            <?php
        }
        ?>

                </div>
                <br />
            </div>
        </form>
        <?php
    }

//public function DialogoAutomatico

    public function RolUsuario($db, $userid) {
        $SQL = 'SELECT
                codigorol
                FROM
                usuario
                WHERE
                idusuario="' . $userid . '"';

        if ($RolUser = &$db->Execute($SQL) === false) {
            echo 'Error en el Sistema...';
            die;
        }

        return $RolUser->fields['codigorol'];
    }

//public function RolUsuario

    public function ContenidoDetalle($db, $id, $Asignacion = '', $DataMsg = '', $Userid = '') {
        include_once('../Solicitud/AsignacionSalon.php');
        $C_AsignacionSalon = new AsignacionSalon();

        $RolUser = $this->RolUsuario($db, $Userid);

        if ($RolUser == 2 || $RolUser == '2') {
            $RolEspacioFisico = 6;
        } else {
            $Data = $this->UsuarioMenu($db, $Userid);

            $RolEspacioFisico = $Data['Data'][0]['RolEspacioFisicoId'];
        }

        $DataDetalle = $this->DataAsignacion($db, $id, $Userid);
        ?>
        <script>
            $(function () {
                $("#accordion").accordion({
                    heightStyle: "content",
                    collapsible: true,

                });
                $(".ui-accordion-content").css('width', '');
            });
        </script>

        <div id="VentanaNew"></div>  
        <div id="accordion" ><!---Ini Acordeon-->
        <?php
        for ($i = 0; $i < count($DataDetalle); $i++) {

            $SolicitudHijo = $DataDetalle[$i][0]['Solicitud_id'];
            ?>
                <h3>&nbsp;&nbsp;&nbsp;&nbsp;
            <?php echo $DataDetalle[$i][0]['nombredia'] ?><!--<input type="hidden" id="DiaSemana" name="DiaSemana[]" value="<?php echo $DataDetalle[$i][0]['codigodia'] ?>" />&nbsp;&nbsp;Sede:<?php echo $DataDetalle[$i][0]['SedeNombre'] ?><input type="hidden" id="Campus_<?php echo $i ?>" name="Campus_<?php echo $i ?>[]" value="<?php echo $DataDetalle[$i][0]['Campus'] ?>" />-->&nbsp;&nbsp;Solicitud ID ::<?php echo $DataDetalle[$i][0]['Solicitud_id']; ?>&nbsp;&nbsp;Asignado/Solicitado&nbsp;&nbsp;<?php echo $DataDetalle[$i][0]['Num_Asiganda'] . '/' . $DataDetalle[$i][0]['Total']; ?>
                </h3>
                <div style="width: 100%;">
                    <table style="border: 1px black solid;" width="auto">
                        <thead>
                            <tr style="border: 1px black solid;">
                                <th style="text-align: center; border: 1px black solid;" colspan="6">
                                    <?php echo $DataDetalle[$i][0]['nombredia'] ?><input type="hidden" id="DiaSemana" name="DiaSemana[]" value="<?php echo $DataDetalle[$i][0]['codigodia'] ?>" />&nbsp;&nbsp;Sede:<?php echo $DataDetalle[$i][0]['SedeNombre'] ?><input type="hidden" id="Campus_<?php echo $i ?>" name="Campus_<?php echo $i ?>[]" value="<?php echo $DataDetalle[$i][0]['Campus'] ?>" />&nbsp;&nbsp;Solicitud ID ::<?php echo $DataDetalle[$i][0]['Solicitud_id'] . '&nbsp;&nbsp;Tipo Salón&nbsp;&nbsp;' . $DataDetalle[$i][0]['NameSalon'] ?><input type="hidden" id="TipoSalon_<?php echo $i ?>" name="TipoSalon_<?php echo $i ?>[]" value="<?php echo $DataDetalle[$i][0]['TipoSalon'] ?>" />
                                </th>
                            </tr>
                            <tr style="border: 1px black solid;">
                                <th style="text-align: center; border: 1px black solid;"><strong>#</strong></th>
                                <th style="text-align: center; border: 1px black solid;"><strong>Aula</strong></strong></th>
                                <th style="text-align: center; border: 1px black solid;"><strong>Fecha</strong></strong></th>
                                <th style="text-align: center; border: 1px black solid;"><strong>Hora Inicio</strong></th>
                                <th style="text-align: center; border: 1px black solid;"><strong>Hora Fin</strong></th>
                                <th style="text-align: center; border: 1px black solid;"><strong>Opciones</strong>&nbsp;&nbsp;
            <?php
            if ($Asignacion == 1) {
                if ($RolEspacioFisico != 5) {
                    $ValidacionSalon = ValidaBotones($db, $Userid, $DataDetalle[$i][0]['TipoSalon']);
                } else {
                    $ValidacionSalon = true;
                }
                if ($ValidacionSalon) {
                    ?>
                                            <input type="checkbox"  id="AllChecko_<?php echo $i ?>" name="AllCheck" onclick="AllCheckTodo('<?php echo $i ?>')" />    
                                            <img src="../../mgi/images/delete.png" id="ElimnarAll" style="cursor: pointer;" title="Eliminar Todo Lo Seleccionado" width="15" onclick="EliminarAll('<?php echo $i ?>')" />&nbsp;&nbsp;<input type="hidden" id="SoliGrupo_<?php echo $i ?>" name="SoliGrupo" />
                                            <img src="../imagenes/Perspective Button - Search.png" id="BuscarUnico" style="cursor: pointer;" title="Buscar Disponibilidad" width="30" onclick="BuscarDisponibilidadMultiple2('<?php echo $i ?>', '<?php echo $DataDetalle[$i][0]['Solicitud_id'] ?>', '<?php echo $id ?>')" />
                                            <img src="../imagenes/System_Restore.png" id="Restaurar" style="cursor: pointer;" title="Restaurar Espacios" width="30" onclick="RestaurarEspacios('<?php echo $i ?>')" />
                    <?php
                }
            } else {//Nuevo
                ?>
                                        <input type="checkbox"  id="AllChecko_<?php echo $i ?>" name="AllCheck" onclick="AllCheckTodo('<?php echo $i ?>')" />    
                                        <img src="../../mgi/images/delete.png" id="ElimnarAll" style="cursor: pointer;" title="Eliminar Todo Lo Seleccionado" width="15" onclick="EliminarAll('<?php echo $i ?>')" />&nbsp;&nbsp;<input type="hidden" id="SoliGrupo_<?php echo $i ?>" name="SoliGrupo" />
                                <?php
                            }
                            ?>
                                </th>
                            </tr>
                        <input type="hidden" id="Num_<?php echo $i ?>" value="<?php echo count($DataDetalle[$i]) ?>" />
                        </thead>
                        <tbody>
                            <?php
                            for ($j = 0; $j < count($DataDetalle[$i]); $j++) {
                                /*                                 * ************************************************ */
                                $C_Fecha = explode('-', $DataDetalle[$i][$j]['FechaAsignacion']);

                                $Fecha_T = $C_Fecha[2] . '-' . $C_Fecha[1] . '-' . $C_Fecha[0];

                                $C_Hora = explode(':', $DataDetalle[$i][$j]['HoraInicio']);

                                $H = $C_Hora[0]; //horas
                                $M = $C_Hora[1] + 31; //Minutos
                                $S = $C_Hora[2]; //Segundos  

                                if ($M > 59) {
                                    $M = $M - 60;
                                    $H = $H + 1;
                                    $Hora_T = $H . ':' . $M . ':' . $S;
                                } else {
                                    $Hora_T = $H . ':' . $M . ':' . $S;
                                }

                                $fecha_actual = strtotime(date("d-m-Y H:i:s"));
                                $fecha_entrada = strtotime($Fecha_T . ' ' . $Hora_T);

                                if ($fecha_actual <= $fecha_entrada) {
                                    $Ver = 1;
                                    $Box = 'text';
                                } else {
                                    $Ver = 0;
                                    $Box = 'hidden';
                                }
                                /*                                 * ************************************************** */
                                $id_Msg = $DataDetalle[$i][$j]['AsignacionEspaciosId'];
                                $TextoView = $DataDetalle[$i][$j]['Nombre'];
                                $Buscar = 0;
                                if ($DataMsg[$id_Msg]) {
                                    $TextoView = $DataMsg[$id_Msg];
                                    $Buscar = 1;
                                }
                                if ($Ver == 1) {
                                    ?>

                                <script type="text/javascript" >
                                    $(document).ready(function () {
                                        $("#FechaAsignacion_<?php echo $i . '_' . $j ?>").datepicker({
                                            changeMonth: true,
                                            changeYear: true,
                                            showOn: "button",
                                            buttonImage: "<?php echo $url ?>../../css/themes/smoothness/images/calendar.gif",
                                            buttonImageOnly: true,
                                            dateFormat: "yy-mm-dd",
                                            minDate: new Date()
                                        });
                                        $('#ui-datepicker-div').css('display', 'none');
                                    });
                                </script>
                                <script>
                                    $(function () {
                                        $('#HoraInicial_<?php echo $i . '_' . $j ?>').datetimepicker({
                                            datepicker: false,
                                            format: 'H:i',
                                            step: 5
                                        });
                                        $('#HoraFin_<?php echo $i . '_' . $j ?>').datetimepicker({
                                            datepicker: false,
                                            format: 'H:i',
                                            step: 5
                                        });
                                    });
                                </script> 
                                        <?php
                                    }
                                    ?>
                            <tr style="border: 1px black solid;">
                                <td style="border: 1px black solid;"><?php echo $j + 1; ?><input type="hidden" id="idAsignacion_<?php echo $i . '_' . $j ?>"  name="idAsignacion_<?php echo $i . '_' . $j ?>[]" value="<?php echo $DataDetalle[$i][$j]['AsignacionEspaciosId'] ?>" /></td>
                                <td style="border: 1px black solid;"><?php echo $TextoView ?></td>
                                <td style="text-align: center; border: 1px black solid;">
                                    <?php
                                    if ($Asignacion == 1 || $Ver == 0) {
                                        if ($Box == 'hidden') {
                                            echo $DataDetalle[$i][$j]['FechaAsignacion'];
                                        }
                                        ?>
                                        <input type="hidden" size="12" style="text-align:center;" readonly="readonly" id="FechaAsignacion_Old_<?php echo $i . '_' . $j ?>" name="FechaAsignacion_Old_<?php echo $i ?>[]" value="<?php echo $DataDetalle[$i][$j]['FechaAsignacion'] ?>" />
                                        <input type="<?php echo $Box ?>" size="12" style="text-align:center;" readonly="readonly" id="FechaAsignacion_<?php echo $i . '_' . $j ?>" name="FechaAsignacion_<?php echo $i ?>[]" value="<?php echo $DataDetalle[$i][$j]['FechaAsignacion'] ?>" />
                                        <?php
                                    } else {
                                        ?>
                                        <input type="hidden" size="12" style="text-align:center;" readonly="readonly" id="FechaAsignacion_Old_<?php echo $i . '_' . $j ?>" name="FechaAsignacion_Old_<?php echo $i ?>[]" value="<?php echo $DataDetalle[$i][$j]['FechaAsignacion'] ?>" />
                                        <input type="<?php echo $Box ?>" size="12" style="text-align:center;" readonly="readonly" id="FechaAsignacion_<?php echo $i . '_' . $j ?>" name="FechaAsignacion_<?php echo $i ?>[]" value="<?php echo $DataDetalle[$i][$j]['FechaAsignacion'] ?>" />
                                        <?php
                                    }
                                    ?>
                                </td>
                                <td style="text-align: center; border: 1px black solid;">

                                    <?php
                                    if ($Asignacion == 1 || $Ver == 0) {
                                        if ($Box == 'hidden') {
                                            echo $DataDetalle[$i][$j]['HoraInicio'];
                                        }
                                        ?>
                                        <input type="<?php echo $Box ?>" id="HoraInicial_<?php echo $i . '_' . $j ?>" name="HoraInicial_<?php echo $i ?>[]" style="text-align:center;" size="6" maxlength="5" value="<?php echo substr($DataDetalle[$i][$j]['HoraInicio'], 0, 5) ?>" onclick="FormatBox('HoraInicial_<?php echo $i . '_' . $j ?>')" />   

                                        <?php
                                    } else {
                                        ?>
                                        <input type="<?php echo $Box ?>" id="HoraInicial_<?php echo $i . '_' . $j ?>" name="HoraInicial_<?php echo $i ?>[]" style="text-align:center;" maxlength="5" value="<?php echo substr($DataDetalle[$i][$j]['HoraInicio'], 0, 5) ?>" onclick="FormatBox('HoraInicial_<?php echo $i . '_' . $j ?>')" />
                                        <?php
                                    }
                                    ?>
                                </td>
                                <td style="text-align: center; border: 1px black solid;">
                                    <?php
                                    if ($Asignacion == 1 || $Ver == 0) {
                                        if ($Box == 'hidden') {
                                            echo $DataDetalle[$i][$j]['HoraFin'];
                                        }
                                        ?>
                                        <input type="<?php echo $Box ?>" id="HoraFin_<?php echo $i . '_' . $j ?>" name="HoraFin_<?php echo $i ?>[]" style="text-align:center;" value="<?php echo substr($DataDetalle[$i][$j]['HoraFin'], 0, 5); ?>"  onclick="FormatBox('HoraFin_<?php echo $i . '_' . $j ?>')" />
                                        <?php
                                    } else {
                                        ?>
                                        <input type="<?php echo $Box ?>" id="HoraFin_<?php echo $i . '_' . $j ?>" name="HoraFin_<?php echo $i ?>[]" style="text-align:center;" value="<?php echo substr($DataDetalle[$i][$j]['HoraFin'], 0, 5); ?>"  onclick="FormatBox('HoraFin_<?php echo $i . '_' . $j ?>')" />
                                        <?php
                                    }
                                    ?>

                                </td>
                                <td>
                                    <?php
                                    $C_Fecha = explode('-', $DataDetalle[$i][$j]['FechaAsignacion']);

                                    $Fecha_T = $C_Fecha[2] . '-' . $C_Fecha[1] . '-' . $C_Fecha[0];

                                    $C_Hora = explode(':', $DataDetalle[$i][$j]['HoraInicio']);

                                    $H = $C_Hora[0]; //horas
                                    $M = $C_Hora[1] + 31; //Minutos
                                    $S = $C_Hora[2]; //Segundos  

                                    if ($M > 59) {
                                        $M = $M - 60;
                                        $H = $H + 1;
                                        $Hora_T = $H . ':' . $M . ':' . $S;
                                    } else {
                                        $Hora_T = $H . ':' . $M . ':' . $S;
                                    }

                                    $fecha_actual = strtotime(date("d-m-Y H:i:s"));
                                    $fecha_entrada = strtotime($Fecha_T . ' ' . $Hora_T);

                                    if ($fecha_actual <= $fecha_entrada) {

                                        if ($Asignacion == 1 || $RolEspacioFisico == 6) {
                                            if ($RolEspacioFisico != 5) {
                                                $ValidacionSalon = ValidaBotones($db, $Userid, $DataDetalle[$i][0]['TipoSalon']);
                                            } else {
                                                $ValidacionSalon = true;
                                            }
                                            if ($ValidacionSalon) {
                                                $DuplicidaGrupo = DuplicidadGrupo($db, $DataDetalle[$i][$j]['AsignacionEspaciosId']);

                                                if ($DuplicidaGrupo['val'] == true) {
                                                    ?>
                                                    <p>Duplicidad de Grupo</p>
                                                    <br />
                                                    <p>&nbsp;&nbsp;Solicitud N&deg;<?php echo $DuplicidaGrupo['id']; ?></p>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <input type="checkbox" class="MultiEliminar AllCheckSeleciona_<?php echo $i ?>" id="CheckEliminar_<?php echo $i . '_' . $j ?>" onclick="OcultarImagen('<?php echo $i . '_' . $j ?>');
                                                            AddValor('<?php echo $DataDetalle[$i][$j]['AsignacionEspaciosId'] ?>', '<?php echo $i ?>', '<?php echo $i . '_' . $j ?>');" />
                                                    &nbsp;&nbsp;&nbsp;<input type="hidden" id="CheckEliminarDato_<?php echo $i . '_' . $j ?>" value="<?php echo $DataDetalle[$i][$j]['AsignacionEspaciosId'] ?>" />
                                                    <img src="../../mgi/images/delete.png" id="Elimnar_<?php echo $i . '_' . $j ?>" style="cursor: pointer;" title="Eliminar Fecha" width="15" onclick="EliminarFechaAsignacion('<?php echo $DataDetalle[$i][$j]['AsignacionEspaciosId'] ?>')" />&nbsp;&nbsp;&nbsp;
                                                    <?php
                                                    if ($DataDetalle[$i][$j]['EstadoAsignacionEspacio'] == 1) {
                                                        ?>
                                                        <img src="../../mgi/images/Pencil3_Edit.png" id="Elimnar" style="cursor: pointer;" title="Otros Eventos" width="25" onclick="OtrosEventos('<?php echo $DataDetalle[$i][$j]['AsignacionEspaciosId'] ?>', '<?php echo $id ?>', '1');" />
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <img src="../imagenes/Hint.png" id="VerObs" style="cursor: pointer;" title="Ver Observaci&oacute;n" width="25" onclick="VerCambio('<?php echo $DataDetalle[$i][$j]['AsignacionEspaciosId'] ?>', '<?php echo $id ?>', '1');" />
                                                        <?php
                                                    }
                                                    ?>     
                                                    <img src="../../mgi/images/Check.png" id="VerObs" style="cursor: pointer;" title="Modificar Registro" width="20" onclick="ModificarRegistroUnico('<?php echo $i . '_' . $j ?>')"  />
                                                    <?php
                                                }
                                            }
                                        }
                                        if ($Asignacion == 1 && $DataDetalle[$i][$j]['ClasificacionEspaciosId'] == 212 && $DataDetalle[$i][$j]['EstadoAsignacionEspacio'] == 1 && $Buscar == 0) {
                                            if ($RolEspacioFisico != 5) {
                                                $ValidacionSalon = ValidaBotones($db, $Userid, $DataDetalle[$i][0]['TipoSalon']);
                                            } else {
                                                $ValidacionSalon = true;
                                            }
                                            if ($ValidacionSalon) {
                                                $DuplicidaGrupo = DuplicidadGrupo($db, $DataDetalle[$i][$j]['AsignacionEspaciosId']);

                                                if ($DuplicidaGrupo['val'] == false) {
                                                    ?>
                                                    <img src="../imagenes/Perspective Button - Search.png" id="BuscarUnico" style="cursor: pointer;" title="Buscar Disponibilidad" width="30" onclick="BuscarDisponibilidad('<?php echo $i ?>', '<?php echo $j ?>', '<?php echo $SolicitudHijo ?>')" />

                                                    <?php
                                                }
                                            }
                                        } else if ($Asignacion != 1) {
                                            if ($RolEspacioFisico == 6) {
                                                $CondiconUser = true;
                                            } else {
                                                $CondiconUser = ValidaCreacionUser($db, $Userid, $SolicitudHijo);
                                            }
                                            if ($CondiconUser) {

                                                if ($RolEspacioFisico != 6) {
                                                    ?>
                                                    <!--Nuevo-->
                                                    <input type="checkbox" class="MultiEliminar AllCheckSeleciona_<?php echo $i ?>" id="CheckEliminar_<?php echo $i . '_' . $j ?>" onclick="OcultarImagen('<?php echo $i . '_' . $j ?>');
                                                            AddValor('<?php echo $DataDetalle[$i][$j]['AsignacionEspaciosId'] ?>', '<?php echo $i ?>', '<?php echo $i . '_' . $j ?>');" />
                                                    &nbsp;&nbsp;&nbsp;<input type="hidden" id="CheckEliminarDato_<?php echo $i . '_' . $j ?>" value="<?php echo $DataDetalle[$i][$j]['AsignacionEspaciosId'] ?>" />
                                                    &nbsp;&nbsp;&nbsp;
                                                    <img src="../../mgi/images/delete.png" id="Elimnar" style="cursor: pointer;" title="Eliminar Fecha" width="15" onclick="EliminarFechaAsignacion('<?php echo $DataDetalle[$i][$j]['AsignacionEspaciosId'] ?>')" />&nbsp;&nbsp;&nbsp;
                                                    <?php
                                                }
                                                if ($DataDetalle[$i][$j]['EstadoAsignacionEspacio'] == 1) {
                                                    ?>
                                                    <img src="../../mgi/images/Pencil3_Edit.png" id="Elimnar" style="cursor: pointer;" title="Otros Eventos" width="25" onclick="OtrosEventos('<?php echo $DataDetalle[$i][$j]['AsignacionEspaciosId'] ?>', '<?php echo $id ?>', '3');" />
                                                    <?php
                                                } else {
                                                    ?>
                                                    <img src="../imagenes/Hint.png" id="VerObs" style="cursor: pointer;" title="Ver Observaci&oacute;n" width="25" onclick="VerCambio('<?php echo $DataDetalle[$i][$j]['AsignacionEspaciosId'] ?>', '<?php echo $id ?>', '3');" />
                                            <?php
                                        }
                                        ?>     
                                                <img src="../../mgi/images/Check.png" id="VerObs" style="cursor: pointer;" title="Modificar Registro" width="20" onclick="ModificarRegistroUnico('<?php echo $i . '_' . $j ?>')"  />
                                        <?php
                                    }
                                }//Fecha Validacion
                                ?>
                                        <div id="msg-success" class="msg-success" style="display:none"></div>
                                    </td>
                                </tr>
                    <?php
                }
                /*                 * ************************************************** */
            }//for
            ?>
                        </tbody>
                    </table>
                </div>
            <?php
        }
        ?>
            <input type="hidden" id="I" name="I" value="<?php echo $i ?>" />
        </div><!---Fin Acordeon-->
        <?php
    }

//public function ContenidoDetalle

    public function VerCambio($db, $id, $id_Soli, $Op) {

        $SQL = 'SELECT Observaciones FROM AsignacionEspacios WHERE AsignacionEspaciosId="' . $id . '" AND codigoestado=100 AND EstadoAsignacionEspacio=0';

        if ($Observacion = &$db->Execute($SQL) === false) {
            echo 'Error en el SQL de Buscar la Observacion ASociada....<br><br>' . $SQL;
            die;
        }
        ?>
        <fieldset style="width: 60%;">
            <legend>Observaci&oacute;n</legend>
            <table style="text-align: center;">
                <tr>
                    <td>
                        <textarea id="TexObs" name="TexObs" cols="50" rows="10" readonly="readonly"><?php echo $Observacion->fields['Observaciones'] ?></textarea >
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="button" id="CambioEstado" onclick="SaveCambioEstado('<?php echo $id ?>', '<?php echo $id_Soli ?>', '<?php echo $Op ?>');" value="Devolver Estado o Situacion" />
                    </td>    
                </tr>
            </table>
        </fieldset>
        <?php
    }

//public function VerCambio

    public function DataVer($db, $id) {

        $SQL = 'SELECT
                	s.SolicitudAsignacionEspacioId AS id,
                
                IF (
                	s.AccesoDiscapacitados = 1, "si", "no") AS Acceso,
                 s.AccesoDiscapacitados,
                 s.FechaInicio,
                 s.FechaFinal,
                 s.idsiq_periodicidad,
                 s.ClasificacionEspaciosId,
                 s.codigodia,
                 CASE s.Estatus
                WHEN 1 THEN
                	"Pendiente"
                WHEN 2 THEN
                	"Parcial"
                WHEN 3 THEN
                	"Atendida"
                END AS Estadotext,
                 s.Estatus,
                 p.periodicidad,
                 c.Nombre,
                 d.nombredia,
                 g.nombregrupo,
                 m.nombremateria,
                 m.codigomateria,
                 ca.nombrecarrera,
                 g.matriculadosgrupo AS inscritos,
                 g.maximogrupo AS max,
                 g.idgrupo,
                 ca.codigocarrera,
                 s.observaciones,
                 s.NombreEvento,
                 s.NumAsistentes,
                 s.UnidadNombre,
                 s.codigomodalidadacademica,
                 s.Responsable,
                 s.Telefono,
                 s.Email,
                 mo.nombremodalidadacademica
                FROM                
                SolicitudPadre sp  
                INNER JOIN AsociacionSolicitud a ON a.SolicitudPadreId=sp.SolicitudPadreId
                INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId=a.SolicitudAsignacionEspaciosId
                INNER JOIN siq_periodicidad p ON p.idsiq_periodicidad = s.idsiq_periodicidad
                INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = s.ClasificacionEspaciosId
                INNER JOIN dia d ON d.codigodia = s.codigodia
                INNER JOIN modalidadacademica mo ON mo.codigomodalidadacademica = s.codigomodalidadacademica
                LEFT JOIN SolicitudEspacioGrupos sg ON s.SolicitudAsignacionEspacioId = sg.SolicitudAsignacionEspacioId
                LEFT JOIN grupo g ON g.idgrupo = sg.idgrupo
                LEFT JOIN materia m ON m.codigomateria = g.codigomateria
                LEFT JOIN carrera ca ON ca.codigocarrera = m.codigocarrera

                WHERE
                	s.codigoestado = 100
                AND p.codigoestado = 100
                AND (sg.codigoestado = 100 OR sg.codigoestado IS NULL)
                AND sp.SolicitudPadreId ="' . $id . '"
                
                GROUP BY g.idgrupo';

        if ($DataVer = &$db->Execute($SQL) === false) {
            echo 'Error en el SQL data del ver...<br>' . $SQL;
            die;
        }

        while (!$DataVer->EOF) {

            $SQL = 'SELECT
                            	COUNT(codigoestadodetalleprematricula) AS Num
                            FROM
                            	detalleprematricula
                            WHERE
                            	idgrupo= "' . $DataVer->fields['idgrupo'] . '"
                            AND codigoestadodetalleprematricula IN ("10")';


            if ($Prematriculados = &$db->Execute($SQL) === false) {
                echo 'Error en el SQL data de prematriculados...<br>' . $SQL;
                die;
            }

            $SQL = 'SELECT
                            	COUNT(codigoestadodetalleprematricula) AS Num
                            FROM
                            	detalleprematricula
                            WHERE
                            	idgrupo= "' . $DataVer->fields['idgrupo'] . '"
                            AND codigoestadodetalleprematricula IN (30)';


            if ($Matriculados = &$db->Execute($SQL) === false) {
                echo 'Error en el SQL data de prematriculados...<br>' . $SQL;
                die;
            }

            $SQL_TipoSalon = 'SELECT
                                    t.codigotiposalon,
                                    t.nombretiposalon
                                    FROM
                                    SolicitudAsignacionEspaciostiposalon s INNER JOIN tiposalon t ON t.codigotiposalon=s.codigotiposalon
                                    
                                    WHERE
                                    
                                     s.SolicitudAsignacionEspacioId="' . $DataVer->fields['id'] . '"';

            if ($TipoSalon = &$db->Execute($SQL_TipoSalon) === false) {
                echo 'Error en el SQL del Tipo Salon....<br>' . $SQL;
                die;
            }

            $C_TipoSalon = $TipoSalon->GetArray();

            $EventoUnico = $this->fechasValidacion($DataVer->fields['FechaInicio'], $DataVer->fields['FechaFinal']);

            $Result['Acceso'] = $DataVer->fields['Acceso'];
            $Result['FechaInicio'] = $DataVer->fields['FechaInicio'];
            $Result['FechaFinal'] = $DataVer->fields['FechaFinal'];
            $Result['EventoUnico'] = $EventoUnico;
            $Result['Estadotext'] = $DataVer->fields['Estadotext'];
            if ($DataVer->fields['Estatus'] == 1) {
                $Color = 'FF0101';
            } else if ($DataVer->fields['Estatus'] == 2) {
                $Color = 'FFEB01';
            } else if ($DataVer->fields['Estatus'] == 3) {
                $Color = '05FF01';
            }
            $Result['Color'] = $Color;
            $Result['Estatus'] = $DataVer->fields['Estatus'];
            $Result['nombregrupo'][] = $DataVer->fields['nombregrupo'];
            $Result['nombremateria'][] = $DataVer->fields['nombremateria'];
            $Result['codigomateria'][] = $DataVer->fields['codigomateria'];
            $Result['nombrecarrera'] = $DataVer->fields['nombrecarrera'];
            $Result['matriculados'][] = $Matriculados->fields['Num'];
            $Result['max'][] = $DataVer->fields['max'];
            $Result['inscritos'][] = $DataVer->fields['inscritos'];
            $Result['prematriculados'][] = $Prematriculados->fields['Num'];
            $Result['Campus'] = $DataVer->fields['ClasificacionEspaciosId'];
            $Result['codigotiposalon'] = $C_TipoSalon;
            $Result['AccesoDiscapacitados'] = $DataVer->fields['AccesoDiscapacitados'];
            $Result['codigocarrera'] = $DataVer->fields['codigocarrera'];
            $Result['idgrupo'][] = $DataVer->fields['idgrupo'];
            $Result['Observaciones'] = $DataVer->fields['observaciones'];
            $Result['NombreEvento'] = $DataVer->fields['NombreEvento'];
            $Result['NumAsistentes'] = $DataVer->fields['NumAsistentes'];
            $Result['UnidadNombre'] = $DataVer->fields['UnidadNombre'];
            $Result['codigomodalidadacademica'] = $DataVer->fields['codigomodalidadacademica'];
            $Result['Responsable'] = $DataVer->fields['Responsable'];
            $Result['Telefono'] = $DataVer->fields['Telefono'];
            $Result['Email'] = $DataVer->fields['Email'];
            $Result['nombremodalidadacademica'] = $DataVer->fields['nombremodalidadacademica'];


            $DataVer->MoveNext();
        }

        return $Result;
    }

//public function DataVer

    public function fechasValidacion($fecha_1, $fecha_2) {

        $C_Fecha_1 = explode('-', $fecha_1);
        $C_Fecha_2 = explode('-', $fecha_2);

        $year_1 = $C_Fecha_1[0];
        $month_1 = $C_Fecha_1[1];
        $day_1 = $C_Fecha_1[2];

        $year_2 = $C_Fecha_2[0];
        $month_2 = $C_Fecha_2[1];
        $day_2 = $C_Fecha_2[2];

        $dato = 0;

        if ($year_1 == $year_2) {//años iguales
            $dato = 0;
            if ($month_1 == $month_2) {//meses iguales
                $dato = 0;
                if ($day_1 == $day_2) {//dias iguales
                    $dato = 1;
                }
            }
        }

        return $dato;
    }

//public function fechasValidacion

    public function DataAsignacion($db, $id, $Userid = '') {

        $SQL = 'SELECT
                          p.SolicitudPadreId,
                          s.SolicitudAsignacionEspacioId AS id,
                          s.FechaInicio,
                          s.FechaFinal,
                          s.codigodia,
                          s.ClasificacionEspaciosId AS Sede,
                          st.codigotiposalon,
                          sg.idgrupo,
                          t.nombretiposalon,
                          d.nombredia,
                          c.Nombre AS NombreSede
                        FROM
                        	SolicitudPadre p
                        INNER JOIN AsociacionSolicitud a ON a.SolicitudPadreId = p.SolicitudPadreId
                        INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId=a.SolicitudAsignacionEspaciosId
                        INNER JOIN SolicitudAsignacionEspaciostiposalon st ON st.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
                        INNER JOIN SolicitudEspacioGrupos sg ON sg.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
                        INNER JOIN tiposalon t ON t.codigotiposalon=st.codigotiposalon
                        INNER JOIN dia d ON d.codigodia=s.codigodia
                        INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId=s.ClasificacionEspaciosId
                        
                        WHERE 
                        p.SolicitudPadreId="' . $id . '"
                        AND
                        s.codigoestado=100
                        AND
                        sg.codigoestado=100
                        
                        GROUP BY s.SolicitudAsignacionEspacioId,p.SolicitudPadreId';

        if ($DataDos = &$db->Execute($SQL) === false) {
            echo 'Error en el SQL de Datas Uno...<br><br>' . $SQL;
            die;
        }

        if (!$DataDos->EOF) {
            $i = 0;
            while (!$DataDos->EOF) {

                $SQL = 'SELECT 

                                a.AsignacionEspaciosId AS id,
                                a.FechaAsignacion,
                                a.HoraInicio,
                                a.HoraFin,
                                a.ClasificacionEspaciosId,
                                c.Nombre,
                                a.EstadoAsignacionEspacio,
                                a.SolicitudAsignacionEspacioId,
                                CASE s.Estatus   WHEN 1 THEN  "Pendiente"  WHEN 2 THEN   "Parcial"  WHEN 3 THEN   "Atendida"  END AS Estadotext
                                
                                
                                FROM 
                                
                                AsignacionEspacios  a INNER JOIN ClasificacionEspacios c ON a.ClasificacionEspaciosId=c.ClasificacionEspaciosId
                                                      INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId=a.SolicitudAsignacionEspacioId
                                
                                WHERE
                                
                                a.SolicitudAsignacionEspacioId="' . $DataDos->fields['id'] . '"
                                AND
                                a.codigoestado=100';

                if ($DataAsignacion = &$db->Execute($SQL) === false) {
                    echo 'Error en el SQL de Data ASignacion...<br><br>' . $SQL;
                    die;
                }

                $SQL = 'UPDATE SolicitudAsignacionEspacios
                                 SET    codigocarrera="' . $_SESSION['codigofacultad'] . '"
                                 WHERE  SolicitudAsignacionEspacioId ="' . $DataDos->fields['id'] . '" AND codigocarrera=2  AND  UsuarioCreacion="' . $Userid . '"';

                if ($Cambio = &$db->Execute($SQL) === false) {
                    echo 'Error en el SQL ....<br><br>' . $SQL;
                    die;
                }


                $Data_id[] = $DataDos->fields['id'];

                $j = 0;
                while (!$DataAsignacion->EOF) {
                    /*                     * *********************************************** */

                    $DataResultado[$i][$j]['AsignacionEspaciosId'] = $DataAsignacion->fields['id'];
                    $DataResultado[$i][$j]['FechaAsignacion'] = $DataAsignacion->fields['FechaAsignacion'];
                    $DataResultado[$i][$j]['HoraInicio'] = $DataAsignacion->fields['HoraInicio'];
                    $DataResultado[$i][$j]['HoraFin'] = $DataAsignacion->fields['HoraFin'];
                    $DataResultado[$i][$j]['ClasificacionEspaciosId'] = $DataAsignacion->fields['ClasificacionEspaciosId'];
                    $DataResultado[$i][$j]['Nombre'] = $DataAsignacion->fields['Nombre'];
                    $DataResultado[$i][$j]['codigodia'] = $DataDos->fields['codigodia'];
                    $DataResultado[$i][$j]['nombredia'] = $DataDos->fields['nombredia'];
                    $DataResultado[$i][$j]['Campus'] = $DataDos->fields['Sede'];
                    $DataResultado[$i][$j]['SedeNombre'] = $DataDos->fields['NombreSede'];
                    $DataResultado[$i][$j]['EstadoAsignacionEspacio'] = $DataAsignacion->fields['EstadoAsignacionEspacio'];
                    $DataResultado[$i][$j]['Solicitud_id'] = $DataAsignacion->fields['SolicitudAsignacionEspacioId'];
                    $DataResultado[$i][$j]['Estado'] = $DataAsignacion->fields['Estadotext'];
                    $DataResultado[$i][$j]['TipoSalon'] = $DataDos->fields['codigotiposalon'];
                    $DataResultado[$i][$j]['NameSalon'] = $DataDos->fields['nombretiposalon'];

                    $SQL_X = 'SELECT
                                        a.ClasificacionEspaciosId
                                        FROM
                                        AsignacionEspacios a
                                        
                                        WHERE  a.codigoestado=100 and a.SolicitudAsignacionEspacioId="' . $DataDos->fields['id'] . '"';

                    if ($Info = &$db->Execute($SQL_X) === false) {
                        echo 'Error al Calcular Atendidas...<br><br>' . $SQL_X;
                        die;
                    }
                    $O = 0;
                    $N = 0;
                    while (!$Info->EOF) {
                        /*                         * ********************************* */
                        if ($Info->fields['ClasificacionEspaciosId'] != 212) {
                            $O = $O + 1;
                        } else {
                            $N = $N + 1;
                        }
                        /*                         * ********************************* */
                        $Info->MoveNext();
                    }


                    $DataResultado[$i][$j]['Num_Asiganda'] = $O;
                    $DataResultado[$i][$j]['Total'] = $N + $O;

                    $j++;
                    $DataAsignacion->MoveNext();
                    /*                     * *********************************************** */
                }
                $i++;
                $DataDos->MoveNext();
            }//while
        } else {

            $SQL = 'SELECT
                            s.FechaInicio,
                            s.FechaFinal,
                            s.UsuarioCreacion,
                            s.codigomodalidadacademica,
                            s.NumAsistentes,
                            s.NombreEvento,
                            s.SolicitudAsignacionEspacioId AS id,
                            st.codigotiposalon,
                            t.nombretiposalon
                      FROM
                            SolicitudPadre sp 
                            INNER JOIN AsociacionSolicitud a ON a.SolicitudPadreId=sp.SolicitudPadreId
                            INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId=a.SolicitudAsignacionEspaciosId
                            INNER JOIN SolicitudAsignacionEspaciostiposalon st ON st.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
                            INNER JOIN tiposalon t ON t.codigotiposalon=st.codigotiposalon
                      WHERE
                        
                        sp.CodigoEstado=100
                        AND
                        s.codigoestado=100
                        AND	sp.SolicitudPadreId = "' . $id . '"';

            if ($DatosAdd = &$db->Execute($SQL) === false) {
                echo 'Error en el SQL de la data adicional.....<br><br>' . $SQL;
                die;
            }




            if (!$DatosAdd->EOF) {
                $i = 0;
                while (!$DatosAdd->EOF) {
                    $SQL = 'SELECT 

                                    a.AsignacionEspaciosId AS id,
                                    a.FechaAsignacion,
                                    a.HoraInicio,
                                    a.HoraFin,
                                    a.ClasificacionEspaciosId ,
                                    c.Nombre AS Aula,
                                    a.EstadoAsignacionEspacio,
                                    s.codigodia,
                                    s.ClasificacionEspaciosId as Sede,
                                    d.nombredia,
                                    cc.Nombre,
                                    a.SolicitudAsignacionEspacioId,
                                    CASE s.Estatus   WHEN 1 THEN  "Pendiente"  WHEN 2 THEN   "Parcial"  WHEN 3 THEN   "Atendida"  END AS Estadotext
                                    
                                    FROM
                                    	AsignacionEspacios a
                                    INNER JOIN ClasificacionEspacios c ON a.ClasificacionEspaciosId = c.ClasificacionEspaciosId
                                    INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId=a.SolicitudAsignacionEspacioId
                                    INNER JOIN ClasificacionEspacios cc ON cc.ClasificacionEspaciosId=s.ClasificacionEspaciosId
                                    INNER JOIN dia d ON d.codigodia=s.codigodia
                                    
                                    WHERE
                                    
                                    a.SolicitudAsignacionEspacioId ="' . $DatosAdd->fields['id'] . '"
                                    AND
                                    a.codigoestado=100
                                    AND
                                    s.codigoestado=100';

                    if ($DataAsignacion = &$db->Execute($SQL) === false) {
                        echo 'Error en el SQL de Data ASignacion...<br><br>' . $SQL;
                        die;
                    }

                    $SQL = 'UPDATE SolicitudAsignacionEspacios
                                     SET    codigocarrera="' . $_SESSION['codigofacultad'] . '"
                                     WHERE  SolicitudAsignacionEspacioId ="' . $DatosAdd->fields['id'] . '" AND codigocarrera=2  AND  UsuarioCreacion="' . $Userid . '"';

                    if ($Cambio = &$db->Execute($SQL) === false) {
                        echo 'Error en el SQL ....<br><br>' . $SQL;
                        die;
                    }

                    $j = 0;
                    if (!$DataAsignacion->EOF) {
                        while (!$DataAsignacion->EOF) {
                            /*                             * *********************************************** */

                            $DataResultado[$i][$j]['AsignacionEspaciosId'] = $DataAsignacion->fields['id'];
                            $DataResultado[$i][$j]['FechaAsignacion'] = $DataAsignacion->fields['FechaAsignacion'];
                            $DataResultado[$i][$j]['HoraInicio'] = $DataAsignacion->fields['HoraInicio'];
                            $DataResultado[$i][$j]['HoraFin'] = $DataAsignacion->fields['HoraFin'];
                            $DataResultado[$i][$j]['ClasificacionEspaciosId'] = $DataAsignacion->fields['ClasificacionEspaciosId'];
                            $DataResultado[$i][$j]['Nombre'] = $DataAsignacion->fields['Aula'];
                            $DataResultado[$i][$j]['codigodia'] = $DataAsignacion->fields['codigodia'];
                            $DataResultado[$i][$j]['nombredia'] = $DataAsignacion->fields['nombredia'];
                            $DataResultado[$i][$j]['Campus'] = $DataAsignacion->fields['Sede'];
                            $DataResultado[$i][$j]['SedeNombre'] = $DataAsignacion->fields['Nombre'];
                            $DataResultado[$i][$j]['EstadoAsignacionEspacio'] = $DataAsignacion->fields['EstadoAsignacionEspacio'];
                            $DataResultado[$i][$j]['Solicitud_id'] = $DataAsignacion->fields['SolicitudAsignacionEspacioId'];
                            $DataResultado[$i][$j]['Estado'] = $DataAsignacion->fields['Estadotext'];
                            $DataResultado[$i][$j]['TipoSalon'] = $DatosAdd->fields['codigotiposalon'];
                            $DataResultado[$i][$j]['NameSalon'] = $DatosAdd->fields['nombretiposalon'];

                            $SQL_X = 'SELECT
                                                a.ClasificacionEspaciosId
                                                FROM
                                                AsignacionEspacios a
                                                
                                                WHERE  a.codigoestado=100 and a.SolicitudAsignacionEspacioId="' . $DatosAdd->fields['id'] . '"';

                            if ($Info = &$db->Execute($SQL_X) === false) {
                                echo 'Error al Calcular Atendidas...<br><br>' . $SQL_X;
                                die;
                            }
                            $O = 0;
                            $N = 0;
                            while (!$Info->EOF) {
                                /*                                 * ********************************* */
                                if ($Info->fields['ClasificacionEspaciosId'] != 212) {
                                    $O = $O + 1;
                                } else {
                                    $N = $N + 1;
                                }
                                /*                                 * ********************************* */
                                $Info->MoveNext();
                            }


                            $DataResultado[$i][$j]['Num_Asiganda'] = $O;
                            $DataResultado[$i][$j]['Total'] = $N + $O;


                            $j++;
                            $DataAsignacion->MoveNext();
                            /*                             * *********************************************** */
                        }
                        $i++;
                    }
                    $DatosAdd->MoveNext();
                }
            }
        }//if 
        return $DataResultado;
    }

//public function DataAsignacion

    public function Crear($db, $id, $tipo = 1) {
        $Funcion = 'saveSolicitud';
        $DisabledClass = '';
        $Class = 'required';
        $hijo = '';
        if ($id) {
            define(AJAX, false);
            $Datos = $this->DataEditar($db, $id);
            $Funcion = 'ModificarSolicitud';
            $Grupo_id = $Datos['Principal'][0]['idgrupo'];
            $Fecha_1 = $Datos['Principal'][0]['FechaInicio'];
            $Fecha_2 = $Datos['Principal'][0]['FechaFinal'];
            $DisabledClass = 'disabled="disabled"';
            $Class = '';
        }

        $StyleCampus = '';
        if ($Datos['AccesoDiscapacitados'] == 1) {
            $acceso = 'checked';
        } else {
            $acceso = '';
        }

        $StyleCampus = ' style="display: none;"';

        $CodigoSalon = $Datos['codigotiposalon'];
        $Evento = 2;
        $Fecha_1 = $Datos['FechaInicio'];
        $Fecha_2 = $Datos['FechaFinal'];
        ?>

        <html>
            <head>
                <script type="text/javascript" language="javascript" src="InterfazSolicitud.js"></script>                 
            </head>		 
            <body>
                <div id="pageContainer">
                    <h2>M&oacute;dulo de Solicitudes de  Espacios F&iacute;sicos</h2>
                    <fieldset style="width:90%;" aling="center">
                        <legend>Solicitud de Espacios F&iacute;sicos</legend>
                        <form id="SolicitudEspacio">
                            <input id="method" name="method" value="addNew" type="hidden" />
                            <input  id="actionID" name="actionID" type="hidden" value="Save" />
                            <input id="Solicitud_id" name="Solicitud_id" value="<?php echo $id ?>" type="hidden" />
                            <table  border="0" style="width: 100%; " cellpadding="0" cellspacing="0"  >
                                <thead>
                                            <?php
                                            if ($_SESSION['codigofacultad'] == 1 || $_SESSION['codigofacultad'] == 156) {
                                                $CodigoModalidad = $Datos['codigomodalidadacademica'];
                                                ?>
                                        <tr>
                                            <td style="text-align: left; width: 20%;">Modalidad Acad&eacute;mica&nbsp;&nbsp;<span style="color: red;">*</span></td>
                                            <td><?php Modalidad($db, $Class, $CodigoModalidad, ''); ?></th>
                                            <td colspan="2">&nbsp;</th>
                                        </tr>
                                        <tr>
                                            <td style="text-align: left;">Programa Acad&eacute;mico&nbsp;&nbsp;<span style="color: red;">*</span></td>
                                            <td id="Th_Progra" style=" width: 20%;">
                                                <?php
                                                $NamePrograma = $Datos['nombrecarrera'];
                                                $CodigoCarrera = $Datos['codigocarrera'];
                                                AutocompletarBox('ProgramaText', 'Programa', 'AutocomplePrograma', '', $Class, $NamePrograma, $CodigoCarrera);
                                                ?>
                                            </td>
                                            <td colspan="2">&nbsp;</td>
                                        </tr>
                                        <?php
                                    } else {
                                        ?>
                                        <tr>
                                            <td style="text-align: left;">Programa Acad&eacute;mico&nbsp;&nbsp;<span style="color: red;">*</span></td>
                                            <td>
            <?php
            $NamePrograma = $Datos['nombrecarrera'];
            $CodigoCarrera = $Datos['codigocarrera'];
            $DataCarrera = $this->DataCarrera($db, $_SESSION['codigofacultad']);
            $NamePrograma = $DataCarrera[0];
            AutocompletarBox('ProgramaText', 'Programa', 'AutocomplePrograma', '', $Class, $NamePrograma, $_SESSION['codigofacultad']);
            ?>											
                                            </td>
                                            <td colspan="2">&nbsp;<input type="hidden" id="Modalidad" name="Modalidad" value="<?php echo $DataCarrera[1] ?>" /></td>
                                        </tr>
            <?php
        }

        $NameMateria = $Datos['Grupo-Unidad'][0]['nombremateria'];
        $CodigoMateria = $Datos['Grupo-Unidad'][0]['codigomateria'];
        ?>

                                    <tr>
                                        <td style="text-align: left;">Materia&nbsp;&nbsp;<span style="color: red;">*</span></td>
                                        <td id="Th_Materia"><?php AutocompletarBox('MateriaText', 'Materia', 'BuscarMateria', '', $Class, $NameMateria, $CodigoMateria); ?></td>
                                        <td style="text-align: left; width: 20%;">Grupo&nbsp;&nbsp;<span style="color: red;">*</span></td>
                                        <td id="Th_Grupo"><?php SelectGroup('GrupoText', 'Grupo', 'BuscarGrupo', '', $Class, $Datos['Grupo-Unidad'], $db); ?></td>

                                    </tr>									   
                                    <tr>
                                        <td colspan="2">
                                            <fieldset>
                                                <legend>Materia Grupos Selecionados</legend>
                                                <div id="GrupoMateria_Div">
        <?php //$this->MultiGrupoMateria($db,'',$Datos['Grupo-Unidad']);  ?>
                                                </div>
                                            </fieldset>
                                        </td>
                                        <td colspan="2">&nbsp;<input type="hidden" id="MultiGrupoMateria" name="MultiGrupoMateria" />&nbsp;</td>
                                    </tr>									   
        <?php
        $Num_Max = 0;
        for ($i = 0; $i < count($Datos['Grupo-Unidad']); $i++) {
            $Num_Max = $Num_Max + $Datos['Grupo-Unidad'][$i]['maximogrupo'];
        }
        ?>									   
                                    <tr>
                                        <td style="text-align: left;">Numero De Estudiantes</td>
                                        <td>
                                            <input type="text" readonly="readonly" id="NumEstudiantes" name="NumEstudiantes" style="text-align: center;" placeholder="Digite Numero de Estudiantes" size="45" value="<?php echo $Num_Max ?>" />
                                        </td>
                                        <td style="text-align: left;">Acceso a Discapacitados</td>
                                        <td>
                                            <input type="checkbox"  id="Acceso" name="Acceso" <?php echo $acceso ?> />
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="4">
                                            <table border="0" align="left" cellpadding="0" cellspacing="0" style="width: 100%;">

                                                <tr>
                                                    <td colspan="4">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
        <?php Tabs($db, $id, $Evento, $Fecha_1, $Fecha_2, $hijo); ?>	
                                                    </td>
                                                </tr>
                                            </table>										
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <div id="FechasAsigandas" style="padding: 10px;"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><strong>Observaciones</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align: center;">
                                            <textarea id="Observacion" name="Observacion" cols="160" rows="10"><?php echo $Datos['observaciones'] ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align: right;">
                                            <input type="button" id="SaveSolicitud" name="SaveSolicitud" value="Guardar" onclick="<?php echo $Funcion ?>()" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </fieldset>
                </div>
            </body>
        </html>
        <?php
    }

//public function Crear

    public function DataCarrera($db, $id) {
        $SQL = 'SELECT
                    nombrecarrera,
                    codigocarrera,
                    codigomodalidadacademica
                FROM
                    carrera
                WHERE
                    codigocarrera="' . $id . '"';

        if ($Data = &$db->Execute($SQL) === false) {
            echo 'Error en el SQL de la Data Carrera...<br><BR>' . $SQL;
            die;
        }

        $Carrera[0] = $Data->fields['codigocarrera'] . '::' . $Data->fields['nombrecarrera'];
        $Carrera[1] = $Data->fields['codigomodalidadacademica'];

        return $Carrera;
    }

//public function DataCarrera

    public function MultiGrupoMateria($db, $grupo = '', $Grupos_ID = '') {
        if ($Grupos_ID) {
            ?>
            <table>
            <?php
            for ($i = 0; $i < count($Grupos_ID); $i++) {
                ?>
                    <tr>
                        <td><?php echo $Grupos_ID[$i]['codigomateria'] . '::' . $Grupos_ID[$i]['nombremateria'] ?></td>
                        <td><?php echo $Grupos_ID[$i]['idgrupo'] . '::' . $Grupos_ID[$i]['nombregrupo'] ?></td>
                        <td>
                            <input type="checkbox" checked="true" id="Grupo_<?php echo $Grupos_ID[$i]['idgrupo'] ?>" name="MultiGrupos[]" value="<?php echo $Grupos_ID[$i]['idgrupo'] ?>" onclick="RerstGrupoMateria('<?php echo $Grupos_ID[$i]['idgrupo'] ?>')"  />
                        </td>
                    </tr>   
                    <?php
                }
                ?>
            </table>
                <?php
            } else {
                $Data = explode('::', $grupo);
                ?>
            <table>
                <?php
                for ($i = 1; $i < count($Data); $i++) {
                    $SQL = 'SELECT
                    	g.idgrupo,
                    g.nombregrupo,
                    m.nombremateria,
                    m.codigomateria
                    FROM
                    	grupo g INNER JOIN materia m ON m.codigomateria=g.codigomateria
                    
                    WHERE 
                    g.idgrupo="' . $Data[$i] . '"';

                    if ($GrupoMateria = &$db->Execute($SQL) === false) {
                        echo 'Error en el SQL de Grupo Multi Materia....<br><BR>' . $SQL;
                        die;
                    }
                    ?>
                    <tr>
                        <td><?php echo $GrupoMateria->fields['codigomateria'] . '::' . $GrupoMateria->fields['nombremateria'] ?></td>
                        <td><?php echo $GrupoMateria->fields['idgrupo'] . '::' . $GrupoMateria->fields['nombregrupo'] ?></td>
                        <td>
                            <input type="checkbox" checked="true" id="Grupo_<?php echo $Data[$i] ?>" name="MultiGrupos[]" value="<?php echo $Data[$i] ?>" onclick="RerstGrupoMateria('<?php echo $Data[$i] ?>')"  />
                        </td>
                    </tr>     
                <?php
            }//for
            ?>
            </table>
            <?php
        }
    }

//public function MultiGrupoMateria

    public function DataEditar($db, $id) {

        $SQL_Contenido = 'SELECT
                                	s.SolicitudAsignacionEspacioId,
                                	s.codigodia,
                                	s.ClasificacionEspaciosId,
                                	s.codigocarrera,
                                	asg.HoraInicio,
                                	asg.HoraFin,
                                	d.nombredia,
                                    c.Nombre AS Instalacion,
                                    c.ClasificacionEspaciosId AS id_Instalacion,
                                    s.AccesoDiscapacitados,
                                    s.FechaCreacion,
                                    s.FechaInicio,
                                    s.FechaFinal,
                                    ca.nombrecarrera,
                                    ca.codigomodalidadacademica,
                                    st.codigotiposalon,
                                    s.observaciones
                                FROM
                                	AsociacionSolicitud a
                                    INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = a.SolicitudAsignacionEspaciosId
                                    INNER JOIN AsignacionEspacios asg ON asg.SolicitudAsignacionEspacioId = s.SolicitudAsignacionEspacioId
                                    INNER JOIN dia d ON d.codigodia = s.codigodia
                                    INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = s.ClasificacionEspaciosId
                                    INNER JOIN carrera ca ON ca.codigocarrera=s.codigocarrera
                                    INNER JOIN SolicitudAsignacionEspaciostiposalon st ON st.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
                                    
                                WHERE
                                	a.SolicitudPadreId ="' . $id . '"
                                    AND s.codigoestado = 100
                                GROUP BY
                                	s.SolicitudAsignacionEspacioId,
                                	s.codigodia,
                                	s.ClasificacionEspaciosId,
                                	s.codigocarrera';

        if ($Contenido = &$db->Execute($SQL_Contenido) === false) {
            echo 'Error en el SQL del Contenido solicitud  ....<br><br>' . $SQL_Contenido;
            die;
        }

        if (!$Contenido->EOF) {
            /*             * ****************Internas***************************** */
            $SQL_ContDetalle = 'SELECT
                                                        g.idgrupo,
                                                        g.nombregrupo,
                                                        m.codigomateria,
                                                        m.nombremateria,
                                                        g.maximogrupo
                                                FROM
                                                        SolicitudEspacioGrupos sg 
                                                        INNER JOIN grupo g ON g.idgrupo=sg.idgrupo
                                                        INNER JOIN materia m ON m.codigomateria=g.codigomateria
                                                
                                                WHERE
                                                
                                                        sg.SolicitudAsignacionEspacioId="' . $Contenido->fields['SolicitudAsignacionEspacioId'] . '"
                                                        AND
                                                        sg.codigoestado=100';


            if ($ContDetalle = &$db->Execute($SQL_ContDetalle) === false) {
                echo 'Error en el SQL del Contenido Detalle...<br><br>' . $SQL_ContDetalle;
                die;
            }
            $C_Detalle = $ContDetalle->GetArray();

            /*             * *******************Construir Array()**************** */
            $Resultado['Padre_ID'] = $id;
            while (!$Contenido->EOF) {
                /*                 * ************************************** */
                $Resultado['Hijos'][] = $Contenido->fields['SolicitudAsignacionEspacioId'];
                $Resultado['Detalle']['Dia'][] = $Contenido->fields['codigodia'];
                $Resultado['Detalle']['Hora'][] = substr($Contenido->fields['HoraInicio'], 0, 5) . ' :: ' . substr($Contenido->fields['HoraFin'], 0, 5);
                $Resultado['Detalle']['Instalacion'][] = $Contenido->fields['id_Instalacion'];
                $Resultado['Detalle']['codigotiposalon'][] = $Contenido->fields['codigotiposalon'];
                $Resultado['Grupo-Unidad'] = $C_Detalle;
                $Resultado['AccesoDiscapacitados'] = $Contenido->fields['AccesoDiscapacitados'];
                $Resultado['FechaCreacion'] = $Contenido->fields['FechaCreacion'];
                $Resultado['FechaInicio'] = $Contenido->fields['FechaInicio'];
                $Resultado['FechaFinal'] = $Contenido->fields['FechaFinal'];
                $Resultado['codigomodalidadacademica'] = $Contenido->fields['codigomodalidadacademica'];
                $Resultado['codigocarrera'] = $Contenido->fields['codigocarrera'];
                $Resultado['nombrecarrera'] = $Contenido->fields['nombrecarrera'];
                $Resultado['observaciones'] = $Contenido->fields['observaciones'];
                $Resultado['SolicitudPadreId'] = $Contenido->fields['SolicitudPadreId'];
                /*                 * ************************************** */
                $Contenido->MoveNext();
            }//while Hijos    				  
        }

        return $Resultado;
    }

//public function DataEditar

    public function Administrativo($RolEspacioFisico){
        if ($RolEspacioFisico == 3){
            ?>
            <blink>No tiene Permisos de Administrador del Sistema.</blink>
            <?php
            die;
        }
        ?>
        <div id="container">
            <h2>M&oacute;dulo de Estado de Solicitudes de  Espacios F&iacute;sicos</h2>
            <div id="VentanaNew"></div>
            <div id="CargarData">
                <div class="demo_jui">
                    <div class="DTTT_container">
                    <?php
                    if ($RolEspacioFisico == 1) {
                        ?>
                        <button id="ToolTables_example_4" class="DTTT_button DTTT_button_text tooltip" title="Creaci&oacute;n Categor&iacute;as Espacio F&iacute;sico">
                            <span>Creaci&oacute;n  Categor&iacute;as Espacio F&iacute;sico</span>                
                        </button>
                        <button id="ToolTables_example_0" class="DTTT_button DTTT_button_text tooltip" title="Creaci&oacute;n Tipo Sal&oacute;n">
                            <span>Creaci&oacute;n Tipo Sal&oacute;n</span>                
                        </button>
                        <button id="ToolTables_example_2" class="DTTT_button DTTT_button_text tooltip" title="Dise&nacute;o Espacio F&iacute;sico">
                            <span>Dise&nacute;o Espacio F&iacute;sico</span>                
                        </button>
                        <button id="ToolTables_example_6" class="DTTT_button DTTT_button_text tooltip" title="Habilitar o Deshabilitar">
                            <span>Habilitar o Deshabilitar</span>                
                        </button>
                        <?php
                    }//rol 1
                    if ($RolEspacioFisico == 2) {
                        ?>     
                        <button id="ToolTables_example_3" class="DTTT_button DTTT_button_text tooltip" title="Solicitar SobreCupo">
                            <span>Solicitar SobreCupo</span>                
                        </button>
                        <button id="ToolTables_example_5" class="DTTT_button DTTT_button_text tooltip" title="Ver Estados Del SobreCupo">
                            <span>Ver Estados del SobreCupo</span>                
                        </button>
                        <?php 
                    }//rol 2 ?> 
                    </div>    
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                        <thead>
                            <tr>       
                                <th>Nombre</th> 
                                <th>Ubicaci&oacute;n</th> 
                                <th>Acceso A Discapacitado</th>
                                <th>Categoria</th>
                                <th>Capacidad</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>                       
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            var oTable;
            var aSelected = [];
            $(document).ready(function () {                
                var sql;
                sql = 'SELECT c.ClasificacionEspaciosId,c.Nombre,cc.Nombre AS Padre,c.AccesoDiscapacitados,e.Nombre AS Categoria, c.CapacidadEstudiantes,CASE c.codigoestado  WHEN 100 THEN "Habilitado" WHEN 200 THEN "Deshabilitado" END AS Estado  FROM ClasificacionEspacios c';
                sql += ' INNER JOIN EspaciosFisicos e ON c.EspaciosFisicosId=e.EspaciosFisicosId';
                sql += ' INNER JOIN ClasificacionEspacios cc ON c.ClasificacionEspacionPadreId=cc.ClasificacionEspaciosId';                
                oTable = $('#example').dataTable({
                    "bJQueryUI": true,
                    "sPaginationType": "full_numbers",
                    "bProcessing": true,
                    "oLanguage": {
                        "sEmptyTable": "No se encontraron datos."
                    },
                    "bServerSide": true,
                    "sAjaxSource": "../../mgi/server_processing.php?active=true&table=ClasificacionEspacios&sql=" + sql + "&wh=e.codigoestado=100 AND e.EspaciosFisicosId<>6 AND c.ClasificacionEspaciosId<>1&tableNickname=c&join=true&omi=1&IndexColumn=ClasificacionEspaciosId",
                    "aoColumnDefs": [
                        {"sClass": "column_fecha", "aTargets": [0, 2, 3]},
                        {"fnRender": function (oObj) {
                                if (oObj.aData[2] == 1) {
                                    return 'si';
                                } else {
                                    return 'no';
                                }
                            },
                            "aTargets": [2]

                        }


                    ],
                    "fnInitComplete": function () {
                        this.fnAdjustColumnSizing(true);
                        var maxWidth = $('#container').width();
                        this.width(maxWidth);
                    }
                });
                /* Click event handler */

                /* Click event handler */

                $('#example tbody tr').live('click', function () {
                    var id = this.id;

                    var index = jQuery.inArray(id, aSelected);
                    if ($(this).hasClass('row_selected') && index === -1) {
                        aSelected1.splice(index, 1);
                        $("#ToolTables_example_0").removeClass('DTTT_disabled');
                        $("#ToolTables_example_2").removeClass('DTTT_disabled');
                        $("#ToolTables_example_4").removeClass('DTTT_disabled');
                        $("#ToolTables_example_3").removeClass('DTTT_disabled');
                        $("#ToolTables_example_5").removeClass('DTTT_disabled');
                        $("#ToolTables_example_6").removeClass('DTTT_disabled');
                    } else {
                        aSelected.push(id);

                        if (aSelected.length > 1)
                            aSelected.shift();
                        oTable.$('tr.row_selected').removeClass('row_selected');
                        $(this).addClass('row_selected');
                        $("#ToolTables_example_0").removeClass('DTTT_disabled');
                        $("#ToolTables_example_2").removeClass('DTTT_disabled');
                        $("#ToolTables_example_4").removeClass('DTTT_disabled');
                        $("#ToolTables_example_3").removeClass('DTTT_disabled');
                        $("#ToolTables_example_5").removeClass('DTTT_disabled');
                        $("#ToolTables_example_6").removeClass('DTTT_disabled');
                    }
                });

                $('#ToolTables_example_0').click(function () {
                    if (!$('#ToolTables_example_0').hasClass('DTTT_disabled'))
                    {
                        TipoSalon();
                    }
                });


                $('#ToolTables_example_2').click(function () {
                    if (!$('#ToolTables_example_2').hasClass('DTTT_disabled'))
                    {
                        DisenoEspacio();
                    }
                });


                $('#ToolTables_example_4').click(function () {
                    if (!$('#ToolTables_example_4').hasClass('DTTT_disabled'))
                    {
                        CreacionEditarEspacio();
                    }
                });

                $('#ToolTables_example_3').click(function () {
                    if (!$('#ToolTables_example_3').hasClass('DTTT_disabled'))
                    {
                        SolicitarSobreCupo();
                    }
                });

                $('#ToolTables_example_5').click(function () {
                    if (!$('#ToolTables_example_5').hasClass('DTTT_disabled'))
                    {
                        VerSolicitarSobreCupo();
                    }
                });

                $('#ToolTables_example_6').click(function () {
                    if (!$('#ToolTables_example_6').hasClass('DTTT_disabled'))
                    {
                        AvilitarDesavilitar();
                    }
                });
            });

        </script>
        <?php
    }

//public function Administrativo

    public function OmitirFecha($db, $id, $id_Soli, $Op) {
        ?>
        <fieldset style="width: 60%;">
            <legend>Observaci&oacute;n</legend>
            <p>
                Al realizar esta acci&oacute;n, est&aacute; liberando el sal&oacute;n para que pueda ser utilizado para otra asignaci&oacute;n. Por favor explique en este cuadro las razones por las cuales libera el espacio. 
            </p>
            <table style="text-align: center;">
                <tr>
                    <td>
                        <textarea id="TexObs" name="TexObs" cols="50" rows="10"></textarea >
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="button" id="OmitirSave" onclick="SaveOmitirFecha('<?php echo $id ?>', '<?php echo $id_Soli ?>', '<?php echo $Op ?>');" value="Guardar" />
                    </td>    
                </tr>
            </table>
        </fieldset>
        <?php
    }

//public function OmitirFecha

    public function UsuarioMenu($db, $userId) {
        $SQL = "SELECT  p.PermisoEspacioFisicoId, m.ModulosEspacioFisicoId, ".
	" r.RolEspacioFisicoId, p.CodigoEstado, m.Nombre, ".
	" m.Url ".
        " FROM PermisoEspacioFisico p ".
        " INNER JOIN ModulosEspacioFisico m ON (m.ModulosEspacioFisicoId = p.ModulosEspacioFisicoId and m.CodigoEstado = p.CodigoEstado AND m.CodigoEstado = 100)  ".
        " INNER JOIN RolEspacioFisico r ON (r.RolEspacioFisicoId = p.RolEspacioFisicoId) ".
        " WHERE r.CodigoEstado = 100 ".
        " AND p.Usuarioid = ".$userId;
        
        if ($Consulta = &$db->Execute($SQL) === false) {
            echo 'Error en el SQL de El Menu...<br><br>' . $SQL;
            die;
        }
        if (!$Consulta->EOF) {
            $Data['val'] = true;
            $Data['Data'] = $Consulta->GetArray();
        } else {
            $Data['val'] = false;
            $Data['Data'] = 'No Tiene Acceso al Menu...';
        }

        return $Data;
    }

//public function UsuarioMenu

    public function SobrecupoSolicitud($db, $id) {
        ?>
        <fieldset>
            <form id="SobrecupoConsola">
                <legend>Solicitar Sobrecupo</legend>
                <table>
                    <thead>
                        <tr>    
                            <th>
        <?php $this->DataEspacioCupo($db, $id); ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <strong>Observaci&oacute;n</strong>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <textarea cols="50" rows="10" id="Observaciones" name="Observaciones"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>N&uacute;mero de Sobrecupo&nbsp;&nbsp;<span style="color: red;">*</span></strong>
                            </td>
                            <td>
                                <input type="text" id="NumSolicitud" name="NumSolicitud" style="text-align: center;" autocomplete="off" class="required number" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="button" id="SaveSobreCupo" value="Guardar" onclick="GuardaSobreCupo('<?php echo $id ?>')"/>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </fieldset>
        <script type="text/javascript">
            function GuardaSobreCupo(id) {

                var Observaciones = $('#Observaciones').val();
                var NumSolicitud = $('#NumSolicitud').val();

                var ValidaCampos = validateForm('#SobrecupoConsola');

                if (ValidaCampos == true) {
                    $.ajax({//Ajax   
                        type: 'POST',
                        url: 'InterfazSolicitud_html.php',
                        async: false,
                        dataType: 'json',
                        data: ({actionID: 'SaveSobrecupo', id: id, Observaciones: Observaciones, NumSolicitud: NumSolicitud}),
                        error: function (objeto, quepaso, otroobj) {
                            alert('Error de ConexiÃ¯Â¿Â½n , Favor Vuelva a Intentar');
                        },
                        success: function (data) {
                            if (data.val == false) {
                                alert(data.descrip);
                                return false;
                            } else {
                                alert(data.descrip);
                                $('#SaveSobreCupo').css('display', 'none');
                            }
                        }//data 

                    });//AJAX

                }
            }
        </script>
        <?php
    }

//public function SobrecupoSolicitud

    public function DataEspacioCupo($db, $id) {
        $SQL = 'SELECT
                        c.ClasificacionEspaciosId,
                        c.Nombre,
                        c.CapacidadEstudiantes
                FROM
                
                        ClasificacionEspacios c 
                
                WHERE
                
                        c.ClasificacionEspaciosId="' . $id . '"';

        if ($Data = &$db->Execute($SQL) === false) {
            echo 'Error en el SQL de la Data...<br><br>' . $SQL;
            die;
        }
        ?>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th><?php echo $Data->fields['Nombre'] ?></th>
                    <th>Capacidad</th>
                    <th><?php echo $Data->fields['CapacidadEstudiantes'] ?></th>
                </tr>
            </thead>
        </table>
        <?php
    }

//public function DataEspacioCupo

    public function PintarError($Fechas) {
        ?>
        <fieldset>
            <b>
                Las Siguientes Fechas ya tiene una solicitud realizada para el Grupo y horas que se estan Indicando.
            </b>
            <ul>
            <?php
            for ($i = 0; $i <= count($Fechas); $i++) {
                foreach ($Fechas[$i] as $Ver) {
                    //4for($j=0;$j<count($Fechas[$i]);$j++){
                    ?>
                        <li><?php echo $Ver; ?></li>
                <?php
            }//for
        }//for
        ?>
            </ul>
        </fieldset>
        <?php
    }

//public function PintarError

    public function AddTrNew($db, $NumFiles) {

        $i = 7;

        for ($x = 1; $x <= $i; $x++) {
            ?>

            <td style="border: black 1px solid;">
            <?php
            $Name = 'Campus';
            $Name_id = 'Campus_' . $x;
            //EspacioCategoria($db,$Name,$Name_id,3,'','','','1');
            $NameSalon = 'TipoSalon_' . $NumFiles;
            TipoSalon($db, '', 'need', '', $NameSalon);
            ?>
                <br />
                <label style="font-size: 14px;">Hora Inicial</label>
                <input type="text" size="10" class="Hora_1 " id="HoraInicial_<?php echo $x ?>_<?php echo $NumFiles ?>" name="HoraInicial_<?php echo $NumFiles ?>[]" title="Formato 24 Horas" style="text-align: center;" placeholder="Hora Inicial" />
                <br />
                <label style="font-size: 14px;">Hora Final</label>
                <input type="text" size="10" class="Hora_2 " id="HoraFin_<?php echo $x ?>_<?php echo $NumFiles ?>" name="HoraFin_<?php echo $NumFiles ?>[]"  title="Formato 24 Horas" style="text-align: center;" placeholder="Hora Final" />
            </td>
            <script>
                $(function () {
                    $('#HoraInicial_<?php echo $x ?>_<?php echo $NumFiles ?>').datetimepicker({
                        datepicker: false,
                        format: 'H:i',
                        step: 5
                    });
                    $('#HoraFin_<?php echo $x ?>_<?php echo $NumFiles ?>').datetimepicker({
                        datepicker: false,
                        format: 'H:i',
                        step: 5
                    });
                });
            </script>
            <?php
        }
    }

// function AddTrNew

    public function VerHorarioOld($db, $id_grupo) {
        $SQL = 'SELECT
                h.codigodia,
                n.nombredia,
                h.idgrupo,
                g.nombregrupo,
                g.maximogrupo,
                m.nombremateria,
                g.fechainiciogrupo,
                g.fechafinalgrupo,
                h.horainicial,
                h.horafinal,
                CONCAT(d.nombredocente," ",d.apellidodocente) AS DocenteName
              FROM
                horario h INNER JOIN grupo g ON g.idgrupo=h.idgrupo
                INNER JOIN materia m ON m.codigomateria=g.codigomateria
                INNER JOIN docente d ON d.numerodocumento=g.numerodocumento
                INNER JOIN dia n ON n.codigodia=h.codigodia
              WHERE
                h.idgrupo ="' . $id_grupo . '"
                AND
                h.codigoestado=100';

        if ($DataGrupo = &$db->Execute($SQL) === false) {
            echo 'Error en el SQL de la Data...<br><br>' . $SQL;
            die;
        }
        ?>
        <table>
            <thead>
                <tr>
                    <th colspan="3"><?php echo $DataGrupo->fields['nombremateria'] ?>&nbsp;&nbsp;<?php echo $DataGrupo->fields['nombregrupo'] ?></th>
                </tr>
                <tr>
                    <th>id Grupo</th>
                    <th>Maxima Capacidad</th>
                    <th>Docente</th>
                </tr>
                <tr>
                    <th><?php echo $DataGrupo->fields['idgrupo'] ?></th>
                    <th><?php echo $DataGrupo->fields['maximogrupo'] ?></th>
                    <th><?php echo $DataGrupo->fields['DocenteName'] ?></th>
                </tr>
                <tr>
                    <th colspan="3">
                        <table>
                            <tr>
                                <th>Fecha de Incio</th>
                                <th>Fecha de Vencimiento</th>
                            </tr>
                            <tr>
                                <th><?php echo $DataGrupo->fields['fechainiciogrupo'] ?></th>
                                <th><?php echo $DataGrupo->fields['fechafinalgrupo'] ?></th>
                            </tr>
                        </table>
                    </th>
                </tr>
                <tr>
                    <th colspan="3">Horario</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>D&iacute;a</strong></td>
                    <td><strong>Hora Inicio</strong></td>
                    <td><strong>Hora Final</strong></td>
                </tr>
        <?php
        while (!$DataGrupo->EOF) {
            ?>
                    <tr>
                        <td><?php echo $DataGrupo->fields['nombredia'] ?></td>
                        <td><?php echo $DataGrupo->fields['horainicial'] ?></td>
                        <td><?php echo $DataGrupo->fields['horafinal'] ?></td>
                    </tr>
            <?php
            $DataGrupo->MoveNext();
        }
        ?>
            </tbody>
        </table>
        <?php
    }

//public function VerHorarioOld

    public function VerSalones($db, $Cupo, $Campus, $Data, $idSoli, $S_Hijo, $userid, $RolEspacioFisico) {

        $InnerCondicion = '';
        $Condicion = '';

        if ($RolEspacioFisico == 2) {
            $InnerCondicion = ' INNER JOIN ResponsableEspacioFisico r ON r.EspaciosFisicosId=e.EspaciosFisicosId AND r.CodigoTipoSalon=t.codigotiposalon';
            $Condicion = ' AND r.CodigoEstado=100  AND r.UsuarioId="' . $userid . '"';
        } else if ($RolEspacioFisico == 5) {
            $InnerCondicion = ' INNER JOIN ResponsableClasificacionEspacios z ON z.ClasificacionEspaciosId=  c.ClasificacionEspaciosId';
            $Condicion = ' AND z.CodigoEstado=100 AND z.idusuario="' . $userid . '"';
        }


        $SQL = 'SELECT  

                c.ClasificacionEspaciosId AS id,
                c.Nombre,
                c.CapacidadEstudiantes,
                c.AccesoDiscapacitados,
                c.EspaciosFisicosId,
                c.codigotiposalon,
                e.Nombre,
                t.nombretiposalon
                
                
                FROM
                
                ClasificacionEspacios c INNER JOIN ClasificacionEspacios cc ON cc.ClasificacionEspaciosId=c.ClasificacionEspacionPadreId
                INNER JOIN EspaciosFisicos e ON e.EspaciosFisicosId=c.EspaciosFisicosId
                INNER JOIN tiposalon t ON t.codigotiposalon=c.codigotiposalon
                ' . $InnerCondicion . '
                
                WHERE
                
                c.codigoestado=100
                AND
                cc.ClasificacionEspacionPadreId="' . $Campus . '"
                AND
                c.ClasificacionEspaciosId<>212 ' . $Condicion . '
                
                GROUP BY c.ClasificacionEspaciosId
                
                ORDER BY c.Nombre';

        if ($Aulas = &$db->Execute($SQL) === false) {
            echo 'Error en el SQL de las Aulas....<br><br>' . $SQL;
            die;
        }

        while (!$Aulas->EOF) {
            /*             * *************************************************** */
            $Aula_id = $Aulas->fields['id'];

            $SQL = 'SELECT
                            *
                            FROM
                            ( SELECT 
     
                            c.Nombre,
                            c.CapacidadEstudiantes AS maxi,
                            t.nombretiposalon,
                            c.AccesoDiscapacitados,
                            d.Sobrecupo AS SobreCupo,
                            IF(SUM( d.Sobrecupo+c.CapacidadEstudiantes ) is NULL,c.CapacidadEstudiantes,SUM( d.Sobrecupo+c.CapacidadEstudiantes )) as CupoMax
    
                            
                            FROM ClasificacionEspacios c  INNER JOIN tiposalon t ON c.codigotiposalon=t.codigotiposalon
                                                          INNER JOIN SobreCupoClasificacionEspacios d ON c.ClasificacionEspaciosId = d.ClasificacionEspacioId
                            
                            WHERE 
                            
                            c.ClasificacionEspaciosId="' . $Aula_id . '"
                            AND 
                            d.EstadoAprobacion=1) x
    
                            WHERE
                            
                            x.CupoMax>=' . $Cupo . '';

            if ($DiponibleAula = &$db->Execute($SQL) === false) {
                echo 'Error en el SQL de las Aulas Diponibles Por Cupo....<br><br>' . $SQL;
                die;
            }
            /*             * *************************************************** */

            if (!$DiponibleAula->EOF) {
                $C_Aulas['id'][] = $Aula_id;
                $C_Aulas['Nombre'][] = $DiponibleAula->fields['Nombre'];
                $C_Aulas['Cupo'][] = $DiponibleAula->fields['maxi'];
                $C_Aulas['Salon'][] = $DiponibleAula->fields['nombretiposalon'];
                $C_Aulas['Acceso'][] = $DiponibleAula->fields['AccesoDiscapacitados'];
                $C_Aulas['SobreCupo'][] = $DiponibleAula->fields['SobreCupo'];
                $C_Aulas['CupoMax'][] = $DiponibleAula->fields['CupoMax'];
                $C_Aulas['Espacio'][] = $Aulas->fields['Nombre'];
            }

            $Aulas->MoveNext();
        }//while

        $this->PrintSalonesMultiple($db, $Data, $C_Aulas, $idSoli, $S_Hijo);
    }

//public function VerSalones

    public function PrintSalonesMultiple($db, $Data, $Espacios, $idSoli, $S_Hijo) {
        ?>
        <div style=" width:1000px;height:700px; overflow: scroll;">
            <div id="DivDibujo"></div>
            <table>
                <thead>
                    <tr>
                        <th>Nombre Espacio</th>
                        <th>Capacidad Espacio</th>
                        <th>Sobre Cupo</th>
                        <th>Capacidad Total</th>
                        <th>Tipo de Aula</th>
                        <th>Acceso a Discapacitados</th>
                        <th>Tipo Espacio</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
        <?php
        for ($i = 0; $i < count($Espacios['id']); $i++) {
            ?>
                        <tr>
                            <td><?php echo $Espacios['Nombre'][$i] ?></td>
                            <td style="text-align: center;"><?php echo $Espacios['Cupo'][$i] ?></td>
                            <td style="text-align: center;"><?php echo $Espacios['SobreCupo'][$i] ?></td>
                            <td style="text-align: center;"><?php echo $Espacios['CupoMax'][$i] ?></td>
                            <td><?php echo $Espacios['Salon'][$i] ?></td>
                            <td style="text-align: center;"><?php
                        if ($Espacios['Acceso'][$i] == 1) {
                            echo $Acceso = 'Si';
                        } else {
                            echo $Acceso = 'No';
                        }
                        ?></td>
                            <td><?php echo $Espacios['Espacio'][$i] ?></td>
                            <td><input type="button" id="asignarAula" class="BotonMultiple" name="asignarAula" value="Asignar Espacio" style="cursor: pointer;" onclick="MultipleAsignarAula('<?php echo $Espacios['id'][$i] ?>', '<?php echo $Data ?>', '<?php echo $idSoli ?>', '<?php echo $S_Hijo ?>')" /></td>
                        </tr>
                            <?php
                        }//for
                        ?>
                </tbody>
            </table>
        </div>
        <?php
    }

//public function PrintSalonesMultiple

    public function PendienteAsignar($db) {
        $Asignacion = 1;
        ?>  
        <div id="container">  
            <fieldset>
                <legend>Solicitud Detalle Pendiente</legend>
                <div>
                    <table>
                        <tr>
                            <td>
        <?php
        FechaBox($db, 'Fecha Inicial', 'FechaIni', 'Fecha Inicial', date('Y-m-d'), 'readonly="readonly"');
        FechaBox($db, 'Fecha Final', 'FechaFinal', 'Fecha Final', date('Y-m-d'), 'readonly="readonly"');
        ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="center" class="Estilo1">
                                <input name="buscar" type="submit" value="Buscar" onclick="return DataPendienteAsignar()">
                            </td>
                        </tr>
                    </table>
                    <br /><br />
                    <div id="CargaFaltaAsigancion">
        <?php $this->DataPendienteAsignar($db, date('Y-m-d'), date('Y-m-d')); ?>
                    </div>
            </fieldset>
        </div>  

        <?php
    }

    public function DataPendienteAsignar($db, $fechaIni, $fechaFin) {
        /*
         * Se agrega campo nombretiposalon de acuerdo a solicitud de Claudia Cristiano
         * Vega Gabriel <vegagabriel@unbosque.edu.do>.
         * Universidad el Bosque - Direccion de Tecnologia.
         * Modificado 10 de Agosto de 2017.
         */
        $SQL = 'SELECT
                pd.SolicitudPadreId,
                    s.SolicitudAsignacionEspacioId,
                    t.nombretiposalon,
                    c.Nombre,
                    sg.idgrupo,
                d.nombredia,
                g.nombregrupo,
                m.nombremateria,
                t.nombretiposalon,
                    s.FechaCreacion,
                    s.FechaInicio,
                    s.FechaFinal,
                    s.AccesoDiscapacitados,
                    s.Estatus,
                    p.periodicidad,
                    d.nombredia,
                    CASE s.Estatus
            WHEN 1 THEN
                    "Pendiente"
            WHEN 2 THEN
                    "Parcial"
            WHEN 3 THEN
                    "Atendida"
            END AS Estadotext,
            s.NombreEvento,
            s.UnidadNombre,
            s.codigomodalidadacademica,
a.FechaAsignacion,
if(s.codigomodalidadacademica=001,"Interna","Externa") AS TipoSolicitud,
a.HoraInicio,
a.HoraFin

            FROM
                    SolicitudAsignacionEspacios s
            INNER JOIN siq_periodicidad p ON p.idsiq_periodicidad = s.idsiq_periodicidad
            INNER JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = s.ClasificacionEspaciosId
            INNER JOIN dia d ON d.codigodia = s.codigodia
            INNER JOIN SolicitudAsignacionEspaciostiposalon st ON s.SolicitudAsignacionEspacioId = st.SolicitudAsignacionEspacioId
            INNER JOIN tiposalon t ON st.codigotiposalon = t.codigotiposalon
            INNER JOIN AsignacionEspacios a ON a.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
            INNER JOIN AsociacionSolicitud pd ON pd.SolicitudAsignacionEspaciosId=s.SolicitudAsignacionEspacioId
            LEFT JOIN SolicitudEspacioGrupos sg ON s.SolicitudAsignacionEspacioId = sg.SolicitudAsignacionEspacioId
            LEFT JOIN grupo g ON g.idgrupo = sg.idgrupo
            LEFT JOIN materia m ON m.codigomateria = g.codigomateria


            WHERE
                    s.codigoestado = 100
            AND t.codigoestado = 100
            AND p.codigoestado = 100
            AND (sg.codigoestado = 100 OR sg.codigoestado IS NULL)
                            AND (a.FechaAsignacion="' . $fechaIni . '"OR a.FechaAsignacion="' . $fechaFin . '")
                            AND a.ClasificacionEspaciosId=212
            AND a.codigoestado=100



            GROUP BY s.SolicitudAsignacionEspacioId

            ORDER BY 
            s.SolicitudAsignacionEspacioId,
            s.Estatus';

        if ($Pendientes = &$db->Execute($SQL) === false) {
            echo 'Error en el SQL de las Aulas....<br><br>' . $SQL;
            die;
        }
        $Resultado = $Pendientes->GetArray();
        $this->MostrarPendiente($db, $Resultado);
        //end  
    }

    public function MostrarPendiente($db, $Resultado) {
        ?>
        <style>
            tr.odd:hover,tr.even:hover{
                background-color: yellow;
                cursor: pointer;
            }
            .ClasOnclikColor{
                background-color: red;
            }
            .odd{
                background-color: #e2e4ff;
            }
            .even{
                background-color: #A8F7C5;  
            }

        </style>

        <style type="text/css" title="currentStyle">
            @import "../../observatorio/data/media/css/demo_page.css";
            @import "../../observatorio/data/media/css/demo_table_jui.css";
            @import "../../observatorio/data/media/css/ColVis.css";
            @import "../../observatorio/data/media/css/TableTools.css";
            @import "../../observatorio/data/media/css/ColReorder.css";
            @import "../../observatorio/data/media/css/themes/smoothness/jquery-ui-1.8.4.custom.css";
            @import "../../observatorio/data/media/css/jquery.modal.css";

        </style>
        <!--<script type="text/javascript" language="javascript" src="../../observatorio/data/media/js/jquery.js"></script>
        <script type="text/javascript" charset="utf-8" src="../jquery/js/jquery-3.6.0.js"></script>-->
        <script type="text/javascript" language="javascript" src="../../observatorio/data/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../observatorio/data/media/js/ColVis.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../observatorio/data/media/js/ZeroClipboard.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../observatorio/data/media/js/TableTools.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../observatorio/data/media/js/FixedColumns.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../observatorio/data/media/js/ColReorder.js"></script>
        <script type="text/javascript" language="javascript">
                                    /****************************************************************/
                                    $(document).ready(function () {

                                        oTable = $('#example').dataTable({
                                            "sDom": '<"H"Cfrltip>',
                                            "bJQueryUI": true,
                                            "bPaginate": true,
                                            "aLengthMenu": [[100], [100, "All"]],
                                            "iDisplayLength": 100,
                                            "sPaginationType": "full_numbers",
                                            "oColVis": {
                                                "buttonText": "Ver/Ocultar Columns",
                                                //"aiExclude": [ 0 ]
                                            }
                                        });
                                        var oTableTools = new TableTools(oTable, {
                                            "buttons": [
                                                "copy",
                                                "csv",
                                                "xls",
                                                "pdf",
                                                {"type": "print", "buttonText": "Print me!"}
                                            ]
                                        });
                                    });
                                    /**************************************************************/

        </script>
        <div id="containerTwo" >
            <h2>Pendiente Asignar</h2>
            <button id="ToolTables_example_1" class="DTTT_button DTTT_button_text  tooltip" title="Asignar Espacio F&iacute;sico" onclick="AsignarEspacio()">
                <span>Asignar Espacio F&iacute;sico</span>                
            </button>
            <div class="demo_jui">              
                <input id="Id_Solicitud" value="" name="Id_Solicitud" type="hidden" />

                <!-- * Se agrega campo nombretiposalon de acuerdo a solicitud de Claudia Cristiano
                     * Vega Gabriel <vegagabriel@unbosque.edu.do>.
                     * Universidad el Bosque - Direccion de Tecnologia.
                     * Modificado 10 de Agosto de 2017.-->

                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>    
                            <th>#</th>  
                            <th>ID Solicitud</th>   
                            <th>Materia &oacute; Evento</th>  
                            <th>D&iacute;a</th>                                
                            <th>Tipo De Aula</th>                                
                            <th>Fecha Creaci&oacute;n</th> 
                            <th>Hora Inicial</th>                     
                            <th>Hora Final</th>
                            <th>Tipo De Solicitud</th>
                        </tr>
                    </thead>
                    <tbody> 
        <?php
        $num = count($Resultado);
        for ($i = 0; $i < count($Resultado); $i++) {
            $id = $Resultado[$i]['SolicitudPadreId']
            ?>
                            <tr style="background: <?php echo $Color ?>;" id="Tr_File_2<?php echo $i ?>" onclick="CargarNum_ID('<?php echo $i ?>', '<?php echo $id ?>', '<?php echo $num ?>')"  onmouseover="ColorNeutro('<?php echo $i ?>', '<?php echo $Resultado[$i]['FechaInicio'] ?>', '<?php echo $Resultado[$i]['codigomodalidadacademica'] ?>');">       
                                <td><?php echo $i + 1 ?></td>                                
                                <td><?php echo $Resultado[$i]['SolicitudAsignacionEspacioId'] ?></td>                                
                                <td><?php echo $Resultado[$i]['nombregrupo'] ?></td>                                 
                                <td><?php echo $Resultado[$i]['nombredia'] ?></td>
                                <td><?php echo $Resultado[$i]['nombretiposalon'] ?></td>
                                <td><?php echo $Resultado[$i]['FechaAsignacion'] ?></td> 
                                <td><?php echo $Resultado[$i]['HoraInicio'] ?></td>                     
                                <td><?php echo $Resultado[$i]['HoraFin'] ?></td>                                
                                <td><?php echo $Resultado[$i]['TipoSolicitud'] ?></td>                                
                            </tr>
            <?php
        }//for
        ?>                      
                    </tbody>
                </table>    
                <!--end-->
            </div>
        </div> 
            <?php
        }

    }

//class

    function Modalidad($db, $class = '', $id = '', $Name = '', $Disable = '') {

        $SQL = 'SELECT 
                
                codigomodalidadacademica AS id,
                nombremodalidadacademica AS Nombre
                
                FROM modalidadacademica
                
                WHERE
                
                codigoestado=100';

        if ($Modalidad = &$db->Execute($SQL) === false) {
            echo 'Error en el SQL Modalidad....<br><br>' . $SQL;
            die;
        }
        if ($Disable) {
            $Ver = 'disabled="disabled"';
        } else {
            $Ver = '';
        }
        ?>
    <select id="Modalidad" name="Modalidad" style="width: auto;" class="<?php echo $class ?>" <?php echo $Ver ?> >
        <option value=""></option>
    <?php
    $selected = '';
    while (!$Modalidad->EOF) {
        if ($id) {
            if ($id == $Modalidad->fields['id']) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            ?>
                <option <?php echo $selected ?>  value="<?php echo $Modalidad->fields['id'] ?>"><?php echo $Modalidad->fields['Nombre'] ?></option>
            <?php
        } else {
            ?>
                <option  value="<?php echo $Modalidad->fields['id'] ?>"><?php echo $Modalidad->fields['Nombre'] ?></option>
            <?php
        }
        $Modalidad->MoveNext();
    }
    ?>
    </select>
    <?php
}

//function Modalidad

function Programa($db, $Modalidad = '', $Programa_id = '', $Letra = '') {

    if ($Modalidad) {
        $Condicion = 'codigomodalidadacademica="' . $Modalidad . '"';
    } else {
        $Condicion = 'codigocarrera="' . $Programa_id . '"';
    }

    if ($Letra) {

        $Condicion_2 = ' AND  (codigocarrera LIKE "' . $Letra . '%" OR nombrecarrera LIKE "' . $Letra . '%")';
    } else {
        $Condicion_2 = ' ';
    }

    $SQL = 'SELECT 

                codigocarrera AS id,
                nombrecarrera AS Nombre
                
                FROM carrera
                
                WHERE
                
                ' . $Condicion . '
                ' . $Condicion_2 . '
                
                ORDER BY  nombrecarrera ASC';

    if ($Programa = &$db->Execute($SQL) === false) {
        echo 'Error En el SQL .....<br><br>' . $SQL;
        die;
    }

    if ($Modalidad) {
        return $Programa;
    } else {
        $Cadena[] = $Programa->fields['id'];
        $Cadena[] = $Programa->fields['Nombre'];

        return $Cadena;
    }
}

//function Programa

function Materia($db, $Programa_id, $Letra) {

    $SQL = 'SELECT 
          
                        m.nombremateria AS Nombre,
                        m.codigomateria AS id
                
                FROM 
                        grupo g INNER JOIN materia m ON m.codigomateria=g.codigomateria
        						INNER JOIN carrera c ON c.codigocarrera=m.codigocarrera
        						INNER JOIN periodo p ON p.codigoperiodo=g.codigoperiodo
        
                WHERE
                
                        p.codigoestadoperiodo=1
                        AND
                        c.codigocarrera="' . $Programa_id . '"
                        AND
                        (m.nombremateria LIKE "' . $Letra . '%" OR  m.codigomateria LIKE "' . $Letra . '%")
                
                GROUP BY m.codigomateria
                
                ORDER BY m.nombremateria ASC';

    if ($Materia = &$db->Execute($SQL) === false) {
        echo 'Error en el SQL de las Materias..<br><br>' . $SQL;
        die;
    }

    return $Materia;
}

// function Materia

function Grupo($db, $Programa_id, $Materia_id, $Letra) {

    $SQL = 'SELECT 

                        g.idgrupo AS id,
                        g.codigogrupo,
                        g.nombregrupo AS Nombre,
                        m.nombremateria,
                        g.codigoperiodo,
                        m.codigomateria,
                        g.maximogrupo AS Cupo
                
                FROM grupo g INNER JOIN materia m ON m.codigomateria=g.codigomateria
    						 INNER JOIN carrera c ON c.codigocarrera=m.codigocarrera
    						 INNER JOIN periodo p ON p.codigoperiodo=g.codigoperiodo
                
                WHERE
                
                    p.codigoestadoperiodo=1
                    AND
                    c.codigocarrera="' . $Programa_id . '"
                    AND
                    g.codigomateria="' . $Materia_id . '"
                    AND
                    (g.idgrupo LIKE "' . $Letra . '%" OR g.nombregrupo LIKE "' . $Letra . '%")';

    if ($Grupo = &$db->Execute($SQL) === false) {
        echo 'Error en el SQL de los Grupos...<br><br>' . $SQL;
        die;
    }

    return $Grupo;
}

// function Grupo

function EspacioCategoria($db, $name, $name_id, $filtro, $funcion = '', $op = '', $id = '', $ver = '', $Class = '') {

    $disabled = 'disabled="disabled"';

    if ($op) {
        $Add = ' AND ClasificacionEspacionPadreId="' . $op . '"';
        $Bloke = ', descripcion AS Bloke';
    } else {
        $Add = '';
        $Bloke = '';
    }

    if ($id) {
        $disabled = '';
    }

    $SQL = 'SELECT 

                ClasificacionEspaciosId AS id,
                Nombre' . $Bloke . '
                
                FROM ClasificacionEspacios
                
                WHERE
                
                EspaciosFisicosId="' . $filtro . '"
                AND
                codigoestado=100' . $Add;

    if ($Respuesta = &$db->Execute($SQL) === false) {
        echo 'Error en el SQL de Campus...<br><br>' . $SQL;
        die;
    }
    ?>
    <select <?php echo $disabled ?> onchange="<?php echo $funcion ?>" name="<?php echo $name ?>[]" id="<?php echo $name_id ?>" style="width: 80%;"  class="<?php echo $Class ?> Sede">
    <?php
    if (!$ver) {
        ?>
            <option value=""></option>
                <?php
            }

            while (!$Respuesta->EOF) {
                if ($id == $Respuesta->fields['id']) {
                    $selected = 'selected="selected"';
                } else {
                    $selected = '';
                }
                ?>
            <option <?php echo $selected ?>  value="<?php echo $Respuesta->fields['id'] ?>"><?php
                echo $Respuesta->fields['Nombre'];
                if ($op) {
                    echo '&nbsp;&nbsp;' . $Respuesta->fields['Bloke'];
                }
                ?></option>
        <?php
        $Respuesta->MoveNext();
    }
    ?>
    </select>
    <?php
}

// function EspacioCategoria

function Periocidad($db, $Class = '') {

    $SQL = 'SELECT idsiq_periodicidad AS id, periodicidad AS Nombre, valor, tipo_valor 
  FROM siq_periodicidad 
  WHERE  idsiq_periodicidad IN(3,35,36)
  ORDER BY tipo_valor';


    if ($Frecuencia = &$db->Execute($SQL) === false) {
        echo 'Error en el SQl ...<br><br>' . $SQL;
        die;
    }
    ?>
    <fieldset id="Frecu_Cont" style="width: auto;">
        <legend>Frecuencia</legend>
        <input type="hidden" id="FrecuenciaOnline" name="FrecuenciaOnline" />
        <table>
                <?php
                while (!$Frecuencia->EOF) {
                    ?>
                <tr>
                    <td><?php echo $Frecuencia->fields['Nombre'] ?></td>
                    <td>
                        <input type="radio" class="<?php echo $Class ?>" id="Fre_<?php echo $Frecuencia->fields['id'] ?>" name="Frecuencia" value="<?php echo $Frecuencia->fields['id'] ?>" onclick="CargarFrecuencia('<?php echo $Frecuencia->fields['id'] ?>');"  />
                    </td>
                </tr>
                    <?php
                    $Frecuencia->MoveNext();
                }
                ?>
        </table>
    </fieldset>
                <?php
            }

// function Periocidad

            function Horario($db, $Class = '', $Grupo_id = '', $Data = '') {
                include_once('../Administradores/Admin_Categorias_class.php');
                $C_Admin_Categorias = new Admin_Categorias();

                $SQL = 'SELECT codigodia, nombredia FROM dia';

                if ($Dia = &$db->Execute($SQL) === false) {
                    echo 'Error en el SQL del Dia...<br><br>' . $SQL;
                    die;
                }
                $C_HorarioGrupo = '';
                $sede = '';
                if ($Grupo_id) {
                    $C_HorarioGrupo = HorarioGrupo($db, $Grupo_id);
                }
                ?>
    <fieldset style="width: auto;">
        <legend>Horario</legend>
        <input type="hidden" id="DiasOnline" name="DiasOnline" />
        <table style="border: black 1px solid; width: 90%; margin-left: 1%; margin-right: 5%;" id="TablaHorario" >
            <tr id="Tr_Dias">
                        <?php
                        $i = 0;
                        while (!$Dia->EOF) {
                            $l = $C_Admin_Categorias->ispar($i);
                            if ($l == 1) {
                                $color = 'background:#F2EAFB;';
                            } else {
                                $color = 'background:#F7FFFF;';
                            }
                            $Check = '';
                            $Ver_Check = 0;
                            if ($Grupo_id) {
                                for ($d = 0; $d < count($C_HorarioGrupo['dia']); $d++) {

                                    if ($C_HorarioGrupo['dia'][$d] == $Dia->fields['codigodia']) {
                                        $Check = 'checked="checked"';
                                        $Ver_Check = 1;
                                        break;
                                    } else {
                                        $Check = '';
                                        $Ver_Check = 0;
                                    }
                                }//for
                            }
                            if ($Data) {
                                for ($l = 0; $l < count($Data[$Dia->fields['codigodia']]); $l++) { //echo '<pre>';print_r($Data[$Dia->fields['codigodia']]);die;
                                    if ($Data[$Dia->fields['codigodia']]['Dia'][0] == $Dia->fields['codigodia']) {
                                        $Check = 'checked="checked"';
                                        $Ver_Check = 1;
                                        break;
                                    } else {
                                        $Check = '';
                                        $Ver_Check = 0;
                                    }
                                }//for
                            }
                            ;
                            ?>
                    <td style="border: black 1px solid;<?php echo $color ?>font-size: 14px;">
                        <div style="text-align: left; width: 50%; float: left;">
                    <?php echo $Dia->fields['nombredia'] ?>
                        </div>
                        <div style="text-align: right; width: 30%; float: right;">
                    <?php
                    if ($Ver_Check == 1) {
                        $Check = 'checked="checked"';
                    } else {
                        $Check = '';
                    }
                    ?>
                            <input style=" float: right;"  <?php echo $Check ?> type="checkbox"   class="DiaChekck DiaMulti <?php echo $Class ?>"  id="Dia_<?php echo $i + 1 ?>" name="DiaSemana[]" value="<?php echo $Dia->fields['codigodia'] ?>" onclick="ActivaMultiple('<?php echo $i + 1 ?>');" />
                    <?php ?>
                        </div>    
                    </td>
                    <?php
                    $i++;
                    $Dia->MoveNext();
                }
                ?>
            </tr>
    <?php
    if (!$Data) {
        ?>
                <tr style="border: black 1px solid;" id="trNewDetalle0">
        <?php
        for ($x = 1; $x <= $i; $x++) {
            $Hora_Programa_1 = '';
            $Hora_Programa_2 = '';
            $sede = '';
            if ($Grupo_id) {
                for ($d = 0; $d < count($C_HorarioGrupo['dia']); $d++) {
                    if ($C_HorarioGrupo['dia'][$d] == $x) {
                        $Hora_Programa_1 = $C_HorarioGrupo['hora_1'][$d];
                        $Hora_Programa_2 = $C_HorarioGrupo['hora_2'][$d];
                        $sede = '1';
                        $Disabled_Box1 = 'readonly="readonly"';
                        $Disabled_Box2 = 'readonly="readonly"';
                        break;
                    } else {
                        $Hora_Programa_1 = '';
                        $Hora_Programa_2 = '';
                    }
                }//for
            }
            if ($Data) {
                for ($l = 0; $l < count($Data[$x]); $l++) {

                    if ($Data[$l][$x]['codigodia'] == $x) {

                        $Hora_Programa_1 = $Data[$l][$x]['HoraInicio'];
                        $Hora_Programa_2 = $Data[$l][$x]['HoraFin'];
                        $Disabled_Box1 = 'readonly="readonly"';
                        $Disabled_Box2 = 'readonly="readonly"';
                        $sede = $Data[$l][$x]['Sede'];
                        break;
                    } else {
                        $Hora_Programa_1 = '';
                        $Hora_Programa_2 = '';
                    }
                }//for
            }
            ?>

                    <script>
                        $(function () {
                            $('#HoraInicial_<?php echo $x ?>').datetimepicker({
                                datepicker: false,
                                format: 'H:i',
                                step: 5
                            });
                            $('#HoraFin_<?php echo $x ?>').datetimepicker({
                                datepicker: false,
                                format: 'H:i',
                                step: 5
                            });
                        });
                    </script> 
                    <td style="border: black 1px solid;">
                        <label style="font-size: 14px;">Instalaci&oacute;n</label>
                        <?php
                        $Name = 'Campus';
                        $Name_id = 'Campus_' . $x;
                        ?>

                        <?php EspacioCategoria($db, $Name, $Name_id, 3, '', '', $sede, '1'); ?>
                        <label style="font-size: 14px;">Tipo Salon&nbsp;<span style="color: red;">*</span></label>
                        <?php TipoSalon($db, '', 'need', '', 'TipoSalon_0'); ?>
                        <br />
                        <label style="font-size: 14px;">Hora Inicial&nbsp;&nbsp;<span style="color: red;">*</span></label>
                        <input type="text" size="10" class="Hora_1 <?php echo $Class . '_' . $x ?>" id="HoraInicial_<?php echo $x ?>" name="HoraInicial_0[]" title="Formato 24 Horas" style="text-align: center;" placeholder="Hora Inicial" maxlength="5" value="<?php echo $Hora_Programa_1 ?>" />
                        <br />
                        <label style="font-size: 14px;">Hora Final&nbsp;&nbsp;<span style="color: red;">*</span></label>
                        <input type="text" size="10"  class="Hora_2 <?php echo $Class . '_' . $x ?>"  id="HoraFin_<?php echo $x ?>" name="HoraFin_0[]" title="Formato 24 Horas" style="text-align: center;" placeholder="Hora Final" maxlength="5" value="<?php echo $Hora_Programa_2 ?>" />
                    </td>

                        <?php
                    }
                    ?> 
                </tr>
                    <?php
                } else {
                    $Hora_Programa_1 = '';
                    $Hora_Programa_2 = '';
                    $sede = '';
                    $Old = 0;

                    for ($x = 1; $x <= $i; $x++) {

                        $N = count($Data[$x]['Hora_1']);

                        if ($N > $Old) {
                            $Old = $N;
                        }
                    }//for
                    for ($l = 0; $l < $Old; $l++) {
                        ?>
                    <tr style="border: black 1px solid;" id="trNewDetalle<?php echo $l ?>">
                        <?php
                        for ($x = 1; $x <= $i; $x++) {
                            $Hora_Programa_1 = '';
                            $Hora_Programa_2 = '';
                            $sede = '';
                            if ($Grupo_id) {
                                for ($d = 0; $d < count($C_HorarioGrupo['dia']); $d++) {

                                    if ($C_HorarioGrupo['dia'][$d] == $x) {
                                        $Hora_Programa_1 = $C_HorarioGrupo['hora_1'][$d];
                                        $Hora_Programa_2 = $C_HorarioGrupo['hora_2'][$d];
                                        $sede = '1';
                                        $Disabled_Box1 = 'readonly="readonly"';
                                        $Disabled_Box2 = 'readonly="readonly"';
                                        break;
                                    } else {
                                        $Hora_Programa_1 = '';
                                        $Hora_Programa_2 = '';
                                    }
                                }//for
                            }
                            if ($Data) {

                                /* MARCOS, CAMBIAR LA E */
                                $Salon = '-1';
                                $id = '';
                                for ($e = 0; $e < count($Data[$x]['Dia']); $e++) {

                                    if ($Data[$x]['Dia'][$e] == $x) {
                                        //echo '<pre>';print_r($Data[$x]['Hora_1']);
                                        $Hora_Programa_1 = $Data[$x]['Hora_1'][$l];
                                        $Hora_Programa_2 = $Data[$x]['Hora_2'][$l];
                                        $id = $Data[$x]['id_Soli'][$l];
                                        $Dia_Id = $Data[$x]['Dia'][$e];
                                        $Disabled_Box1 = 'readonly="readonly"';
                                        $Disabled_Box2 = 'readonly="readonly"';
                                        $sede = $Data[$x]['Sede'][$e];
                                        $Salon = $Data[$x]['Salon'][$l];
                                        break;
                                    } else {
                                        $id = '';
                                    }
                                }
                            }
                            ?>   
                            <td style="border: black 1px solid;">
                                <label style="font-size: 14px;">Instalaci&oacute;n</label>
                    <?php
                    $Name = 'Campus';
                    $Name_id = 'Campus_' . $x;

                    if ($l == 0) {
                        EspacioCategoria($db, $Name, $Name_id, 3, '', '', $sede, '1');
                    } else {
                        $Class = 'Other';
                    }

                    TipoSalon($db, $Salon, 'need', '', 'TipoSalon_' . $l);


                    if ($id) {
                        $N = $id;
                        ?>
                                    <input type="hidden" name="HoraInicial_<?php echo $l ?>[]" />
                                    <input type="hidden" name="HoraFin_<?php echo $l ?>[]" />
                    <?php
                } else {
                    $N = $l;
                }
                ?>
                                <br />
                                <label style="font-size: 14px;">Hora Inicial&nbsp;&nbsp;<span style="color: red;">*</span></label>
                                <input type="text" size="10" class="Hora_1 <?php echo $Class . '_' . $x ?>" id="HoraInicial_<?php echo $l ?>" name="HoraInicial_<?php echo $N ?>[]"  title="Formato 24 Horas" style="text-align: center;" placeholder="Hora Inicial" maxlength="5" value="<?php echo $Hora_Programa_1 ?>" />
                                <input type="hidden" name="Dia_<?php echo $id ?>" value="<?php echo $Dia_Id ?>" />
                                <br />
                                <label style="font-size: 14px;">Hora Final&nbsp;&nbsp;<span style="color: red;">*</span></label>
                                <input type="text" size="10"  class="Hora_2 <?php echo $Class . '_' . $x ?>"  id="HoraFin_<?php echo $l ?>" name="HoraFin_<?php echo $N ?>[]" title="Formato 24 Horas" style="text-align: center;" placeholder="Hora Final" maxlength="5" value="<?php echo $Hora_Programa_2 ?>" />
                            </td>

                <?php
            }//for  for($x=1;$x<=$i;$x++)
            ?> 
                    </tr>

            <?php
        }//for  OLD
        ?>
                </tr>
    <?php } ?>

        </table>
    <?php
    if ($Old) {
        ?>
            <input type="hidden" id="numIndices" name="numIndices" value="<?php echo $Old ?>" />
        <?php
    } else {
        ?>
            <input type="hidden" id="numIndices" name="numIndices" value="0" />
        <?php
    }
    ?>

        <input type="button" value="+" onclick="AddTr()" />
        <input type="button" value="-" onclick="DeleteTr()" />
    </fieldset>
    <?php
}

// function Horario

function FechaBox($db, $Label, $name, $Ejemplo = '', $value = '', $readonly = '', $Ver = '', $url = '', $Class = '', $Onchage = '') {
    ?>
    <td style="text-align: left;"><?php echo $Label ?> &nbsp;<span style="color: red;">*</span></td>
    <td>
        <input type="text" id="<?php echo $name ?>" name="<?php echo $name ?>" class="<?php echo $Class ?>" size="12" style="text-align:center;" readonly="readonly" value="<?php echo $value ?>" placeholder="<?php echo $Ejemplo ?>" <?php echo $readonly; ?>  onchange="<?php echo $Onchage ?>" />
    </td>
    <?php
    if ($Ver != 1) {
        ?>
        <script type="text/javascript" >
                $(document).ready(function () {
                    $("#<?php echo $name ?>").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        showOn: "button",
                        buttonImage: "<?php echo $url ?>../../css/themes/smoothness/images/calendar.gif",
                        buttonImageOnly: true,
                        dateFormat: "yy-mm-dd",
                        minDate: new Date()
                    });
                    $('#ui-datepicker-div').css('display', 'none');
                });
        </script>
                <?php
            }
            ?>

    <?php
}

// function FechaBox

function Tabs($db, $Data = '', $Evento = '', $Fecha_1 = '', $Fecha_2 = '') {
    $DataNew = DataHorario($db, $Data);
    if ($Evento == 1) {
        $Checkd_1 = '';
        $Checkd_2 = 'checked="checked"';
        $Disabled_1 = 'disabled="disabled"';
        $Disabled_2 = '';
        $hora_1 = $Data[0]['HoraInicio'];
        $hora_2 = $Data[0]['HoraFin'];
    } else if ($Evento == 2) {
        $Checkd_1 = 'checked="checked"';
        $Checkd_2 = '';
        $Disabled_1 = '';
        $Disabled_2 = 'disabled="disabled"';
        $hora_1 = '';
        $hora_2 = '';
    } else {
        $Checkd_1 = 'checked="checked"';
        $Checkd_2 = '';
    }
    ?>
    <script>
        $(function () {
            $("#tabs").tabs();
        });

    </script>
    <div id="tabs" style="margin-left: 10px;">
        <ul>
            <li><a href="#tabs-2" style="cursor: pointer;">Multiple Evento</a>&nbsp;&nbsp;<!--<input type="checkbox"  <?php echo $Checkd_1 ?> <?php echo $Disabled_1 ?> id="AvilitarMultiple" onclick="Ocultar(2)" class="UnicoTab" />--></li>
        </ul>
        <div id="tabs-2">
    <?php
    if ($Evento == 1) {
        Multiple($db);
    } else if ($Evento == 2) {
        Multiple($db, $DataNew, $Fecha_1, $Fecha_2);
    } else {
        Multiple($db);
    }
    ?>
        </div>
    </div>
    <?php
}

//function Tabs

function Multiple($db, $Data = '', $Fecha_1 = '', $Fecha_2 = '') {
    ?>
    <table border=0 cellpadding="0" cellspacing="0" >
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
    <?php FechaBox($db, 'Fecha Inicial', 'FechaIni', 'Fecha Inicial', $Fecha_1, 'readonly="readonly"', '', '', 'fechaMulti', 'ValidarFechasUnic()'); ?>     
        <input type="hidden" id="FechaIni_OLD" name="FechaIni_OLD" value="<?php echo $Fecha_1 ?>" />
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <?php FechaBox($db, 'Fecha Final', 'FechaFin', 'Fecha Final', $Fecha_2, 'readonly="readonly"', '', '', 'fechaMulti', 'ValidarFechasUnic()'); ?>
    </tr>
    </table>
    <div id="Div_Horario"><?php Horario($db, 'HoraMulti', '', $Data); ?></div>
        <?php
    }

//Multiple

    function TipoSalon($db, $id = '', $Class = '', $op = '', $NameSalon) {
        if ($op == 1) {
            $Condicion = '';
        } else {
            $Condicion = ''; //AND  t.EspaciosFisicosId=5
        }

        $SQL = 'SELECT 

                t.codigotiposalon AS id,
                t.nombretiposalon


                
                FROM tiposalon t INNER JOIN EspaciosFisicos e ON t.EspaciosFisicosId=e.EspaciosFisicosId
                
                WHERE 
                t.codigoestado=100 AND 
						(t.codigotiposalon="0" OR t.codigotiposalon IN 
								(SELECT codigotiposalon FROM ClasificacionEspacios WHERE codigoestado=100)
						)
                AND
                e.PermitirAsignacion=1 
                ' . $Condicion . '
                
                ORDER BY  t.nombretiposalon';

        if ($TipoSalon = &$db->Execute($SQL) === false) {
            echo 'Error en el SQL de Tipo Salon....<br><br>' . $SQL;
            die;
        }
        ?>
    <select id="<?php echo $NameSalon ?>" class="<?php echo $Class ?>" name="<?php echo $NameSalon ?>[]" style="width: 92%;">
        <option value="-1"></option>
    <?php
    while (!$TipoSalon->EOF) {
        if ($TipoSalon->fields['id'] == $id) {
            $selected = 'selected="selected"';
        } else {
            $selected = '';
        }
        ?>
            <option <?php echo$selected ?> value="<?php echo $TipoSalon->fields['id'] ?>"><?php echo $TipoSalon->fields['nombretiposalon'] ?></option>
        <?php
        $TipoSalon->MoveNext();
    }
    ?>
    </select>
    <?php
}

//function TipoSalon

function SelectGroup($name, $name_id, $funcion, $Disable, $Class = '', $Grupos = '', $db) {
    if ($Grupos) {
        ?>
        <fieldset style="height:120px;border:1px solid #ccc;overflow:auto;">
            <legend>Multiple Grupos</legend>
            <input type="hidden" id="GruposEliminar" name="GruposEliminar" />
            <table>
        <?php
        for ($i = 0; $i < count($Grupos); $i++) {
            ?>
                    <tr>
                        <td ><?php echo $Grupos[$i]['idgrupo'] . ' :: ' . $Grupos[$i]['nombregrupo'] ?><td>
                        <td>
                            <div id="Div_Horario_<?php echo $Consulta->fields['id'] ?>" title="Horario"></div>
                            <input type="checkbox" checked="checked"  value="<?php echo $Grupos[$i]['idgrupo'] ?>" id="GrupoText_<?php echo $Grupos[$i]['idgrupo'] ?>" name="GrupoText[]" class="Gropup" onclick="AddNumGrupo('<?php echo $Grupos[$i]['idgrupo'] ?>', '<?php echo $Consulta->fields['maximogrupo'] ?>', 'Div_Horario_', 1);"  style="cursor: pointer;" />
                        </td>
                    </tr>
            <?php
        }
        ?>
            </table>
        </fieldset>
        <?php
    } else {
        ?>
        <select name="<?php echo $name ?>" id="<?php echo $name ?>" onchange="<?php echo $funcion ?>()">
            <option value="-1"></option>
        </select>
        <?php
    }
}

//function SelectGroup

function AutocompletarBox($name, $name_id, $funcion, $Disable, $Class = '', $nameText = '', $Codigo = '') {
    if ($Disable) {
        $Ver = 'disabled="disabled"';
    } else {
        $Ver = '';
    }
    ?>
    <input type="text" class="<?php echo $Class ?>" <?php echo $Ver ?>   id="<?php echo $name ?>" name="<?php echo $name ?>" autocomplete="off"  style="text-align:center;width:90%;" size="70" onClick="formReset('<?php echo $name ?>', '<?php echo $name_id ?>');" onKeyPress="<?php echo $funcion ?>()" value="<?php echo $nameText ?>"  /><input type="hidden" id="<?php echo $name_id ?>" name="<?php echo $name_id ?>" value="<?php echo $Codigo ?>"/>
    <?php
}

//function AutocompletarBox

function AutoPrograma($name, $name_id, $db, $Codigo, $Class = '', $Disable = '') {

    $Data = Programa($db, '', $Codigo, '');

    if ($Disable) {
        $Ver = 'disabled="disabled"';
    } else {
        $Ver = '';
    }
    ?>
    <input type="text" class="<?php echo $Class ?>" <?php echo $Ver ?> readonly="readonly" id="<?php echo $name ?>" name="<?php echo $name ?>" autocomplete="off"  style="text-align:center;width:90%;" size="70" value="<?php echo $Data[0] . ' :: ' . $Data[1] ?>" /><input type="hidden" id="<?php echo $name_id ?>" name="<?php echo $name_id ?>" value="<?php echo $Data[0] ?>"/>
    <?php
}

//function AutoPrograma

function HorarioGrupo($db, $Grupo_id) {
    $SQL = 'SELECT codigodia,horainicial,horafinal FROM horario WHERE idgrupo ="' . $Grupo_id . '"  AND codigoestado=100';

    if ($Horario = &$db->Execute($SQL) === false) {
        echo 'Error en el SQL de los Horarios Grupo...<br><BR>' . $SQL;
        die;
    }

    $C_horario = array();

    if (!$Horario->EOF) {
        while (!$Horario->EOF) {

            $C_horario['dia'][] = $Horario->fields['codigodia'];
            $C_horario['hora_1'][] = $Horario->fields['horainicial'];
            $C_horario['hora_2'][] = $Horario->fields['horafinal'];

            $Horario->MoveNext();
        }
    }

    return $C_horario;
}

//function HorarioGrupo

function DataHorario($db, $id) {

    $SQL = 'SELECT
                    sp.SolicitudPadreId,
                    s.SolicitudAsignacionEspacioId,
                    aa.AsignacionEspaciosId,
                    aa.HoraInicio,
                    aa.HoraFin,
                    s.codigodia,
                    s.ClasificacionEspaciosId,
                    st.codigotiposalon
            FROM
                    SolicitudPadre sp INNER JOIN AsociacionSolicitud a ON a.SolicitudPadreId=sp.SolicitudPadreId
                                      INNER JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId=a.SolicitudAsignacionEspaciosId
                                      INNER JOIN SolicitudAsignacionEspaciostiposalon st ON  st.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
                                      INNER JOIN AsignacionEspacios aa ON aa.SolicitudAsignacionEspacioId=s.SolicitudAsignacionEspacioId
            
            WHERE
            
                    sp.CodigoEstado=100
                    AND
                    s.codigoestado=100
                    AND
                    aa.codigoestado=100
                    AND
                    sp.SolicitudPadreId="' . $id . '"
                   
            GROUP BY s.SolicitudAsignacionEspacioId
			ORDER BY s.codigodia,aa.HoraInicio';

    if ($Data = &$db->Execute($SQL) === false) {
        echo 'Error en el SQL de Data Inicial....<br><br>' . $SQL;
        die;
    }
    $Resultado = array();
    $i = 1;
    while (!$Data->EOF) {
        $Resultado[$Data->fields['codigodia']]['id_Soli'][] = $Data->fields['SolicitudAsignacionEspacioId'];
        $Resultado[$Data->fields['codigodia']]['Dia'][] = $Data->fields['codigodia'];
        $Resultado[$Data->fields['codigodia']]['Hora_1'][] = $Data->fields['HoraInicio'];
        $Resultado[$Data->fields['codigodia']]['Hora_2'][] = $Data->fields['HoraFin'];
        $Resultado[$Data->fields['codigodia']]['Sede'][] = $Data->fields['ClasificacionEspaciosId'];
        $Resultado[$Data->fields['codigodia']]['Salon'][] = $Data->fields['codigotiposalon'];
        $Data->MoveNext();
    }//while
    return $Resultado;
}

//function DataHorario

function ValidaBotones($db, $userid, $TipoSalon) {
    $SQL = 'SELECT
            *
            FROM
            ResponsableEspacioFisico 
            WHERE
            UsuarioId="' . $userid . '"
            AND 
            CodigoTipoSalon="' . $TipoSalon . '"
            AND
            CodigoEstado=100';

    if ($TiposAcceso = &$db->Execute($SQL) === false) {
        echo 'Error en el SQL de Permiso Vizualizar Botones....<br>' . $SQL;
        die;
    }

    if (!$TiposAcceso->EOF) {
        return true;
    } else {
        return false;
    }
}

//function ValidaBotones

function ValidaCreacionUser($db, $Userid, $id) {
    $Carrera = $_SESSION['codigofacultad'];

    if ($Carrera == 1) {
        return true;
    } else {

        $SQL = 'SELECT
                *
                FROM
                SolicitudAsignacionEspacios
                WHERE
                
                codigocarrera="' . $Carrera . '"
                AND
                codigoestado=100
                AND SolicitudAsignacionEspacioId="' . $id . '"';

        if ($Valida = &$db->Execute($SQL) === false) {
            echo 'Error en el SQL validacion Permisos Creacion....<br><br>' . $SQL;
            die;
        }

        if (!$Valida->EOF) {
            return true;
        } else {
            return false;
        }
    }
}

//function ValidaCreacion

function DuplicidadGrupo($db, $id) {
    $SQL = 'SELECT
            	sg.idgrupo,
            	a.HoraInicio,
            	a.HoraFin,
            	a.FechaAsignacion
            FROM
            	AsignacionEspacios a
            INNER JOIN SolicitudEspacioGrupos sg ON sg.SolicitudAsignacionEspacioId = a.SolicitudAsignacionEspacioId
            WHERE
            	a.AsignacionEspaciosId = "' . $id . '"
            AND a.codigoestado = 100
            AND sg.codigoestado = 100';

    if ($ConsultaData = &$db->GetArray($SQL) === false) {
        echo 'Error en la Consulta de DATA del sistema';
        die;
    }
    $Grupos = '';
    if (count($ConsultaData) == 1) {
        $Grupos = $ConsultaData[0]['idgrupo'];
    } else {
        for ($i = 0; $i < count($ConsultaData); $i++) {
            if ($i == 0) {
                $Grupos = $ConsultaData[$i]['idgrupo'];
            } else {
                $Grupos = $Grupos . ',' . $ConsultaData[$i]['idgrupo'];
            }
        }
    }

    if (count($ConsultaData) > 0) {
        $SQL_V = 'SELECT
                        a.AsignacionEspaciosId,
                        a.SolicitudAsignacionEspacioId,
                        aa.SolicitudPadreId
                    FROM
                        SolicitudEspacioGrupos sg 
                        INNER JOIN AsignacionEspacios a ON a.SolicitudAsignacionEspacioId=sg.SolicitudAsignacionEspacioId
                        INNER JOIN AsociacionSolicitud aa ON aa.SolicitudAsignacionEspaciosId=a.SolicitudAsignacionEspacioId
                        INNER JOIN  SolicitudAsignacionEspacios ss ON ss.SolicitudAsignacionEspacioId=a.SolicitudAsignacionEspacioId
                        INNER JOIN SolicitudPadre sp ON sp.SolicitudPadreId=aa.SolicitudPadreId
                    WHERE
                        sg.idgrupo IN (' . $Grupos . ')
                        AND
                        a.FechaAsignacion="' . $ConsultaData[0]['FechaAsignacion'] . '"
                        AND
                        a.HoraInicio="' . $ConsultaData[0]['HoraInicio'] . '"
                        AND
                        a.HoraFin="' . $ConsultaData[0]['HoraFin'] . '"
                        AND 
                        a.AsignacionEspaciosId <> "' . $id . '"
                        AND
                        a.codigoestado=100
                        AND
                        ss.codigoestado=100
                        AND
                        sp.CodigoEstado=100

                        GROUP BY a.SolicitudAsignacionEspacioId';

        if ($ValidaGruposAsignacion = &$db->Execute($SQL_V) === false) {
            echo 'Error en la Consulta de DATA del sistema Validacion';
            die;
        }

        if (!$ValidaGruposAsignacion->EOF) {
            $Datos['val'] = true;
            $Datos['id'] = $ValidaGruposAsignacion->fields['SolicitudPadreId'];

            return $Datos;
        } else {
            $Datos['val'] = false;
            return $Datos;
        }
    } else {
        //externa 
        $Datos['val'] = false;
        return $Datos;
    }
}

//function DuplicidadGrupo
?>       