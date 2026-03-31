<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
    
    require_once('../../../../Connections/sala2.php');
    mysql_select_db($database_sala, $sala);
    require_once('../seguridadplandeestudio.php');
    
    if(isset($_GET['planestudio']))
    {
        $idplanestudio = $_REQUEST['planestudio'];        
    }
    $query_lineaenfasis = "select idlineaenfasisplanestudio, nombrelineaenfasisplanestudio from lineaenfasisplanestudio where idplanestudio = '$idplanestudio' and idlineaenfasisplanestudio not like '1' and codigoestadolineaenfasisplanestudio like '%1%'";
    $lineaenfasis = mysql_query($query_lineaenfasis, $sala) or die("$query_lineaenfasis");
    $totalRows_lineaenfasis = mysql_num_rows($lineaenfasis);
    $opciones='';
    if($totalRows_lineaenfasis != "")
    {
        while($row_lineaenfasis = mysql_fetch_assoc($lineaenfasis))
        {
            $nombrelineaenfasisplanestudio = $row_lineaenfasis['nombrelineaenfasisplanestudio'];
            $idlineaenfasis = $row_lineaenfasis['idlineaenfasisplanestudio'];
            $opciones.="<option value='".$idlineaenfasis."'>".$nombrelineaenfasisplanestudio."</option>";
            /*?><option value="<?php echo $idlineaenfasis; ?>"><?php echo $nombrelineaenfasisplanestudio; ?></option><?php*/
        }//while
    }//if    
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Líneas de énfasis en construcción</title>
    </head>
    <body>
        <div align="center">
            <form action="lineadeenfasisinicial.php?planestudio=<?php echo $idplanestudio; if(isset($_GET['visualizado'])) echo "&visualizado";?>" name="f1" method="post">
                <p align="center"><strong>LINEAS DE ENFASIS</strong></p>                
                <table width="500" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
                    <tr>
                        <td width="250" rowspan="3">
                            <select name='identlineaenfasis' size="7" style="width: 250px">
                                <?php
                                echo $opciones;
                                ?>
                            </select>
                        </td>
                        <td align="center">
                            <?php
                            if(!isset($_GET['visualizado']))
                            {
                            ?>
                                <input  type="submit" name="nuevo" value="Nueva" style="WIDTH:80px">
                            <?php
                            }
                            ?>
                              &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                        <?php
                            if(!isset($_GET['visualizado']))
                            {
                            ?>
                                <input type="submit" name="editar" value="Editar" style="WIDTH:80px">
                            <?php
                            }
                            else
                            {
                            ?>
                                <input type="submit" name="visualizar" value="Visualizar" style="WIDTH:80px">
                            <?php
                            }
                            ?>
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                        <?php
                            if(!isset($_GET['visualizado']))
                            {
                            ?>
                                <input type="submit" name="eliminar" value="Eliminar" style="WIDTH:80px">
                            <?php
                            }
                            ?>&nbsp;
                        </td>
                    </tr>
                    <tr>
                        <!--   	<td align="center">
                        <?php
                        if(!isset($_GET['visualizado']))
                        {
                        ?>
                            <input type="submit" name="asignar" value="Asignar" style="WIDTH:80px">
                        <?php
                        }
                        ?>
                        </td> -->
                    </tr>
                    <tr>
                        <td align="center" colspan="2">
                        <?php
                        if(isset($_GET['visualizado']))
                        {
                        ?>
                            <input type="button" name="regresar" value="Regresar" onClick="window.location.href='../materiasporsemestre.php?planestudio=<?php echo "$idplanestudio&visualizado";?>'">
                        <?php
                        }
                        else
                        {
                        ?>
                            <input type="button" name="regresar" value="Regresar" onClick="window.location.href='../materiasporsemestre.php?planestudio=<?php echo $idplanestudio;?>'">
                        <?php
                        }
                        ?>
                        &nbsp;
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
    <?php
    if(isset($_POST['nuevo']))
    {
        echo '<script language="javascript">
        window.location.href="nuevalineadeenfasis.php?planestudio='.$idplanestudio.'";
        </script>';
    }
    else if(isset($_POST['identlineaenfasis']))
    {
        if(isset($_POST['editar']))
        {
            echo '<script language="javascript">
            window.location.href="visualizarlineadeenfasis.php?planestudio='.$idplanestudio.'&lineaenfasis='.$_POST['identlineaenfasis'].'";
            </script>';
        }
        else if(isset($_POST['eliminar']))
        {
            echo '<script language="javascript">
            window.location.href="eliminarlineadeenfasis.php?planestudio='.$idplanestudio.'&lineaenfasis='.$_POST['identlineaenfasis'].'";
            </script>';
        }
        else if(isset($_POST['visualizar']))
        {
            echo '<script language="javascript">
            window.location.href="materiaslineadeenfasisporsemestre.php?planestudio='.$idplanestudio.'&lineaenfasis='.$_POST['identlineaenfasis'].'&visualizado";
            </script>';
        }
    }
    else
    {
        if(isset($_POST['editar']) || isset($_POST['eliminar']) || isset($_POST['visualizar']))
        {
            echo '<script language="javascript">
            alert("Debe seleccionar una línes de énfasis del panel de la izquierda");
            </script>';
        }
    }
    ?>
</html>