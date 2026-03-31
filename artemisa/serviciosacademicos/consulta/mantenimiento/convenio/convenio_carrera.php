<?php
$fechahoy=date("Y-m-d H:i:s");
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
$rutaJS = "../../sic/librerias/js/";
$varguardar = 0;
$filtroNombreCarrera = "";

if(isset($_POST['nombrecarrera'])) {
    $filtroNombreCarrera = " and nombrecarrera like '%".$_POST['nombrecarrera']."%'";
}
        $query_modalidadacademica ="SELECT codigomodalidadacademica, nombremodalidadacademica from modalidadacademica where codigoestado like '1%' ";
                $modalidadacademica= $db->Execute($query_modalidadacademica);
                $totalRows_modalidadacademica = $modalidadacademica->RecordCount();
?>


<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
        <script src="<?php echo $rutaJS; ?>jquery-3.6.0.js" type="text/javascript"></script>
        
        <script language="javascript">
    function cambio()
        {
            document.form1.submit();
        }
    function confirmar() {
        if(confirm('Esta seguro?')) {
            document.getElementById('grabar').value='ok';
            document.form1.submit();
        }
    }
</script>

<SCRIPT language="JavaScript" >
$(document).ready(function (){
  $("input[type='checkbox']").click(function () {
    var codigocarrera = $(this).attr("name");
    var idconvenio = $(this).attr("value");
    var check = $(this).is(":checked");
    $.ajax({
                    type: "GET",
                    url: 'asociarcarrera.php',
                    data: 'codigocarrera=' + codigocarrera + '&idconvenio=' + idconvenio + '&check=' + check,
                    success: function(datos){
                        //$("#central").html(datos);
                        //$("#dialog").append(datos);
                        //alert(datos);
                    }
                });
    //alert("sadasdasd" + codigocarrera + idconvenio + 'este es el check ' + check);
    
  })
})

</SCRIPT>
</head>
    <body>
        <form name="form1" id="form1"  method="POST">
        <input type="hidden" name="idconvenio" value="<?php echo $_REQUEST['idconvenio'];?>">
            <table width="50%"  border="0" align="center" cellpadding="3" cellspacing="3">
                <TR >
                    <TD colspan="2" align="center"><label id="labelresaltadogrande" >Selección de Programas</label>
                    </TD>
                </TR>
                <tr align="left" >
                    <td width="50%" id="tdtitulogris"><div align="center">Modalidad Académica</div>
                    </td>
                    <td width="50%" id="tdtitulogris">
                        <div align="justify">
                            <select name="modalidadacademica" id="modalidadacademica" onchange="cambio()" >
                            <option value="">
                                Seleccionar
                            </option>
                            <option value="1" <?php
                                if($_POST['modalidadacademica']==1) {
                                        echo "Selected";
                                        $entro2=true;
                                      
                                }
                                /*elseif ($row_convenio['codigocarrera']==1 && !isset ($_POST['codigocarrera'])){
                                           echo "Selected";
                                            $entro2=true;
                                            $_POST['modalidadacademica']=1;
                                        }*/
                                ?>>
                                Todas las Carreras
                            </option>
                                <?php while($row_modalidadacademica = $modalidadacademica->FetchRow()){?>
                            <option value="<?php echo $row_modalidadacademica['codigomodalidadacademica'];?>"
                                <?php
                                 if($row_modalidadacademica['codigomodalidadacademica']==$_POST['modalidadacademica']) {
                                echo "Selected";
                                 }
                                ?>>
                                <?php echo $row_modalidadacademica['nombremodalidadacademica'];?>
                            </option>
                            <?php }?>
                            </select>
                        </div>
                    </td>
                </tr>
            </table>
            <?php
                if((isset($_REQUEST['modalidadacademica']) && $_REQUEST['modalidadacademica']!=1)|| $entro2)  {
                    if($_REQUEST['modalidadacademica'] != ''){   
                        $query_codigocarrera ="SELECT codigocarrera, nombrecarrera from carrera
                        where codigomodalidadacademica='".$_REQUEST['modalidadacademica']."'
                        and '".$fechahoy."' between fechainiciocarrera and fechavencimientocarrera
                        $filtroNombreCarrera        
                        union 
                        SELECT codigocarrera, nombrecarrera FROM carrera where codigomodalidadacademica = '".$_REQUEST['modalidadacademica']."'
                        and codigocarrera='156'
                        union
                        SELECT codigocarrera, nombrecarrera FROM carrera where codigomodalidadacademica = '".$_REQUEST['modalidadacademica']."'
                        and codigocarrera='528'                       
                        order by nombrecarrera";
                        if ($entro2)
                        {   
                        $query_codigocarrera ="SELECT codigocarrera, nombrecarrera from carrera
                        where codigocarrera = 1";
                        }
                        $codigocarrera= $db->Execute($query_codigocarrera);
                        $totalRows_codigocarrera = $codigocarrera->RecordCount();
                        $row_codigocarrera = $codigocarrera->FetchRow();
            ?>
                        <table width="50%"  border="1" align="center" cellpadding="3" cellspacing="3">
                            <TR id="trgris">
                                <TD align="center"><label id="labelresaltado">Carrera </label>
                                </TD>
                                <TD align="center"><label id="labelresaltado">Aplicar a Convenio</label>
                                </TD>
                            </TR>
                            <TR>
                                <TD align="center"><INPUT type="text" name="nombrecarrera" id="nombrecarrera" value="<?php if ($_POST['nombrecarrera']!=""){
                                echo $_POST['nombrecarrera']; } ?>"></TD>
                                <TD align="center"><INPUT type="submit" name="Filtrar" value="Filtrar"></TD>
                            
                            </TR>
                            <?php 
                                if($totalRows_codigocarrera !=''){
                                do {
                                    $query_activos = "SELECT c.idconvenio, d.codigocarrera, d.idconveniocarrera FROM convenio c, conveniocarrera d 
                                    where c.idconvenio=d.idconvenio
                                    and c.idconvenio = '".$_REQUEST['idconvenio']."'
                                    and d.codigocarrera = '".$row_codigocarrera['codigocarrera']."'
                                    and d.codigoestado like '1%'";
                                    $activos = $db->Execute($query_activos);
                                    $totalRows_activos = $activos->RecordCount();
                                    $row_activos = $activos->FetchRow();
                                    $checked="";
                                    if ($totalRows_activos>0)
                                        $checked='checked';
                                    //echo "imprime".$_POST['activar'.$row_dependencia['codigocarrera']];
                                    
                            ?>
                            <TR>
                                <TD align="center"><?php echo $row_codigocarrera['nombrecarrera']; ?>
                                </TD>
                                <TD align="center"><INPUT type="checkbox" name="<?php echo $row_codigocarrera['codigocarrera'];?>" value="<?php echo $_REQUEST['idconvenio'];?>" <?php echo $checked;?>>
                                </TD>                                
                            </TR>
                            <?php } while($row_codigocarrera = $codigocarrera->FetchRow());
                             }
                             ?>
                            <TR>
                                <TD align="center" colspan="2"><INPUT type="button" value="Regresar" onclick="window.location.href='insertar_convenio.php?idconvenio=<?php echo $_REQUEST['idconvenio']; ?>'">
                                </TD>
                            </TR> 
                        </table>
            <?php 
                    }
                }    
            ?>
        </form>
    </body>
</html>