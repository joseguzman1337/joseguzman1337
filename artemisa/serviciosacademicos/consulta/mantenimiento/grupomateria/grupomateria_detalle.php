<?php
/*
 * Ajustes de limpieza codigo y modificacion de interfaz
 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Universidad el Bosque - Direccion de Tecnologia.
 * Modificado 14 de Noviembre de 2017.
 */
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php'); 
    $rutaado = "../../../funciones/adodb/";
    require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado.php');
?>
<script language="JavaScript" src="../funciones/calendario/javascripts.js"></script>    
<link type="text/css" rel="stylesheet" href="../../../../assets/css/normalize.css">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/font-page.css">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/font-awesome.css">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.css">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/general.css">
<link type="text/css" rel="stylesheet" href="../../../../assets/css/chosen.css">
<script type="text/javascript" src="../../../../assets/js/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="../../../../assets/js/bootstrap.js"></script> 
<script language="Javascript">
    function abrir(pagina,ventana,parametros) 
    {
        window.open(pagina,ventana,parametros);
    }
    function enviar()
    {
        document.form1.submit()
    }
</script>
<?php

    $idgrupomateria = $_GET['idgrupomateria'];
    $codigoperiodo = $_GET['codigoperiodo'];

    $sqlnombremateria = "SELECT
        g.nombregrupomateria,
        g.codigotipogrupomateria,
        t.nombretipogrupomateria,
        g.CodigoEstado,
        g.codigomodalidadacademica
    FROM
        grupomateria g
    INNER JOIN tipogrupomateria t on g.codigotipogrupomateria = t.codigotipogrupomateria 
    WHERE
        g.idgrupomateria =".$idgrupomateria."";
    $materia = $db->GetRow($sqlnombremateria);

    $sqltipo ="select codigotipogrupomateria, nombretipogrupomateria from tipogrupomateria";
    $tipos = $db->GetAll($sqltipo);
    
    $sqlmodalidad ="select codigomodalidadacademica, nombremodalidadacademica  ";
    $sqlmodalidad .="from modalidadacademica where codigoestado=100 ";
    $sqlmodalidad .="and codigomodalidadacademica not between 500 and 599 ";
    $modalidades = $db->GetAll($sqlmodalidad);
    
    $sqlestado ="select * from estado";
    $estados = $db->GetAll($sqlestado);

?>
<div class="container">
    <center><h2>GRUPO MATERIA - EDITAR</h2></center>
    <form name="form1" action="" method="post">
        <table class="table" >
            <tr>
                <td bgcolor="#CCDADD">Nombre grupo
                    <input type="hidden" name="codigoperiodo" value="<?php echo $_GET['codigoperiodo']?>">
                    <input type="hidden" name="idgrupomateria" value="<?php echo $idgrupomateria?>">
                </td>
                <td bgcolor="#FEF7ED">
                    <?php echo $materia['nombregrupomateria'];
                    ?>
                </td>
            </tr>
            <tr>
                <td bgcolor="#CCDADD">Tipo grupo </td>
                <td bgcolor="#FEF7ED">
                    <select name="codigotipogrupomateria" id="codigotipogrupomateria">                        
                        <?php 
                            foreach($tipos as $tipo)
                            {
                                if($tipo['codigotipogrupomateria'] == $materia['codigotipogrupomateria'])
                                {
                                    echo "<option value='".$tipo['codigotipogrupomateria']."' selected>".$tipo['nombretipogrupomateria']."</option>";    
                                }
                                else
                                {
                                    echo "<option value='".$tipo['codigotipogrupomateria']."'>".$tipo['nombretipogrupomateria']."</option>";
                                }
                            }//foreach
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td bgcolor="#CCDADD">Modalidad</td>
                <td bgcolor="#FEF7ED">
                    <select name="codigomodalidadacademica" id="codigomodalidadacademica">                        
                        <?php 
                            foreach($modalidades as $modalidad)
                            {
                                if($modalidad['codigomodalidadacademica'] == $materia['codigomodalidadacademica'])
                                {
                                    echo "<option value='".$modalidad['codigomodalidadacademica']."' selected>".$modalidad['nombremodalidadacademica']."</option>";    
                                }
                                else
                                {
                                    echo "<option value='".$modalidad['codigomodalidadacademica']."'>".$modalidad['nombremodalidadacademica']."</option>";
                                }
                            }//foreach
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td bgcolor="#CCDADD">Estado</td>
                <td bgcolor="#FEF7ED">
                    <select name="codigoestado" id="codigoestado">                        
                        <?php 
                            foreach($estados as $estado)
                            {
                                if($estado['codigoestado'] == $materia['CodigoEstado'])
                                {
                                    echo "<option value='".$estado['codigoestado']."' selected>".$estado['nombreestado']."</option>";    
                                }
                                else
                                {
                                    echo "<option value='".$estado['codigoestado']."'>".$estado['nombreestado']."</option>";
                                }
                            }//foreach
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div align="center">
                        <input class="btn btn-fill-green-XL" name="Enviar" type="submit" id="Enviar" value="Enviar">
                    </div>
                </td>
            </tr>
        </table>
    </form>
</div>
<?php
if(isset($_POST['Enviar']))
{
    $sqlupdate = "update grupomateria set codigotipogrupomateria= '".$_POST['codigotipogrupomateria']."', ";
    $sqlupdate .= "codigomodalidadacademica= '".$_POST['codigomodalidadacademica']."', ";
    $sqlupdate .= "CodigoEstado= '".$_POST['codigoestado']."' where idgrupomateria = '".$_POST['idgrupomateria']."' ";
    $sqlupdate .= "and codigoperiodo = '".$_POST['codigoperiodo']."' ";
    $db->execute($sqlupdate);
    
    echo "<script language='javascript'>alert('Datos actualizados correctamente');</script>";
    echo '<script language="javascript">window.close();</script>';
    echo '<script language="javascript">window.opener.recargar();</script>';
}
//end
?>