<?php 
function modalidad ($nombreformulario = "f1")
{
    global $db;
       
                $query_modalidadacademica = "SELECT codigomodalidadacademica, nombremodalidadacademica from modalidadacademica where codigoestado=100";
                $modalidadacademica= $db->Execute($query_modalidadacademica);
                $totalRows_modalidadacademica = $modalidadacademica->RecordCount();


                        $query_carrera ="SELECT codigocarrera, nombrecarrera from carrera
                        where codigomodalidadacademica='".$_REQUEST['nacodigomodalidadacademica']."'
                        and now() between fechainiciocarrera and fechavencimientocarrera
                        order by nombrecarrera";


                $carrera= $db->Execute($query_carrera);
                $totalRows_carrera = $carrera->RecordCount();
              // print_r($_GET);
                ?>
                
                    <script language="javascript">
                        function prueba()
                        {
                            document.<?php echo $nombreformulario; ?>.submit();
                        }
                    </script>
                   <table  border="0"  cellpadding="3" cellspacing="3">
                   <tr>
                    <td  id="tdtitulogris" colspan="4" >Seleccione la Modalidad
                        
                            <select name="nacodigomodalidadacademica" id="nacodigomodalidadacademica" onchange="prueba()">
                            <option value="">
                                Seleccionar
                            </option><?php while($row_modalidadacademica = $modalidadacademica->FetchRow()){?><option value="<?php echo $row_modalidadacademica['codigomodalidadacademica'];?>"
                            <?php
                                 if($row_modalidadacademica['codigomodalidadacademica']==$_REQUEST['nacodigomodalidadacademica']) {
                                echo "Selected";
                                 }?>>
                            <?php echo $row_modalidadacademica['nombremodalidadacademica'];?>
                            </option><?php }?>
                            </select>
                       
                    </td>
                </tr>
                <tr>
                    <td  id="tdtitulogris" colspan="4">Seleccione la Carrera
                        
                            <select name="nacodigocarrera" id="nacodigocarrera" onchange="prueba()">

                            <option value="todas">TODAS</option>
                            <?php while ($row_carrera = $carrera->FetchRow()){?><option value="<?php echo $row_carrera['codigocarrera'] ?>"<?php
                                if ($row_carrera['codigocarrera']==$_REQUEST['nacodigocarrera']) {
                                echo "Selected";
                                $nombrecarrera = $row_carrera['nombrecarrera'];
                                 }?>>
                                <?php echo $row_carrera['nombrecarrera'];
                                ?>

                            </option><?php };?>
                            </select>
                           
                    </td>
                </tr>
               </table>
<?php
                       
}
?>
<?php 
function periodo ($nombreformulario = "f1")
{
    global $db;
       
                $query_periodo = "SELECT codigoperiodo, nombreperiodo from periodo order by 1 desc";
                $periodo= $db->Execute($query_periodo);
                $totalRows_periodo = $periodo->RecordCount();                        
                ?>
                
                    <script language="javascript">
                        function prueba()
                        {
                            document.<?php echo $nombreformulario; ?>.submit();
                        }
                    </script>
                   <table  border="0"  cellpadding="3" cellspacing="3">
                   <tr>
                    <td  id="tdtitulogris" colspan="4" >Seleccione el Periodo
                        
                            <select name="periodo" id="periodo" onchange="prueba()">
                            <option value="">
                                TODOS
                            </option>
                            <?php while($row_periodo = $periodo->FetchRow()){?>
                            <option value="<?php echo $row_periodo['codigoperiodo'];?>"
                            <?php
                                 if($row_periodo['codigoperiodo']==$_REQUEST['periodo']) {
                                echo "Selected";
                                 }?>>
                            <?php echo $row_periodo['nombreperiodo'];?>
                            </option><?php }?>
                            </select>
                       
                    </td>
                </tr>                
               </table>
<?php
                       
}
?>