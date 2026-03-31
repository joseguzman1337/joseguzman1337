<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $title; ?></title>
        <link type="text/css" href="../../educacionContinuada/css/normalize.css" rel="stylesheet">
        <link rel="stylesheet" href="../../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link media="screen, projection" type="text/css" href="../../educacionContinuada/css/style.css" rel="stylesheet">
        <script type='text/javascript' language="javascript" src="../../js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../../js/jquery-ui-1.8.21.custom.min.js"></script> 
        <script type="text/javascript" language="javascript" src="../../educacionContinuada/js/functions.js"></script>
        <script type="text/javascript" language="javascript" src="../js/funcionesGestionContraprestaciones.js "></script>
        <style>
            form span.info{
                margin-left:15px;position:relative;top:2px;
                clear: right;
                display: inline-block;
                float: left;
            }
        </style>
    </head>
    <body class="body">
        <div id="container">
            <center><h1><font face="sans-serif"><?php echo $title; ?></font></h1></center>
            <center><h3><?php echo $Nombreprograma; ?></h3></center>
        </div>
        <div>
            <fieldset>
                <center>
                    <table cellpadding="3" border="0" width="920px">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Entidad de salud</th>
                                <th>Formula</th>                        
                                <th>Fecha inicio Vigencia</th>
                                <th>Fecha fin Vigencia</th>
                                <th>Fecha de Creacion</th>
                                <th>Detalles</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($Entidades as $e){ ?>
                            <tr>
                                <td><?php echo $e['ROW']; ?></td>
                                <td><?php echo $e['NombreInstitucion']; ?></td>
                                <td><?php echo $e['formula']; ?></td>                                                        
                                <td><?php echo $e['FechaInicioVigencia']; ?></td>                                                        
                                <td><?php echo $e['FechaFinVigencia']; ?></td>                                                        
                                <td><?php echo $e['FechaCreacion']; ?></td>                                                        
                                <td>
                                    <?php 
                                    if(!empty($e['FormulaLiquidacionId'])){
                                    ?>
                                    <form action="../Controller/Formulasliquidacion.php" method="post">
                                        <input type="hidden" name="Accion" id="Accion" value="Detalles" />
                                        <input type="hidden" name="formula" id="formula" value="<?php echo $e['formula']; ?>" />
                                        <input type="hidden" name="FormulaLiquidacionId" id="FormulaLiquidacionId" value="<?php echo $e['FormulaLiquidacionId']; ?>" />
                                        <input type="hidden" name="codigocarrera" id="codigocarrera" value="<?php echo $codigocarrera; ?>" />
                                        <input type="hidden" name="InstitucionConvenioId" id="InstitucionConvenioId" value="<?php echo $e['InstitucionConvenioId']; ?>" />
                                        <input type="hidden" name="ConvenioId" id="ConvenioId" value="<?php echo $e['ConvenioId']; ?>" />
                                        <input type="hidden" name="IdContraprestacion" id="IdContraprestacion" value="<?php echo $e['IdContraprestacion']; ?>" />
                                        <input type="image" src="../../mgi/images/file_edit.png" title="Editar" width="20"/>
                                    </form>
                                    <?php 
                                    }
                                    ?>
                                    <form action="../Controller/Formulasliquidacion.php" method="post">
                                        <input type="hidden" name="Accion" id="Accion" value="Detalles" />
                                        <input type="hidden" name="FormulaLiquidacionId" id="FormulaLiquidacionId" value="" />
                                        <input type="hidden" name="formula" id="formula" value="" />
                                        <input type="hidden" name="codigocarrera" id="codigocarrera" value="<?php echo $codigocarrera; ?>" />
                                        <input type="hidden" name="InstitucionConvenioId" id="InstitucionConvenioId" value="<?php echo $e['InstitucionConvenioId']; ?>" />
                                        <input type="hidden" name="ConvenioId" id="ConvenioId" value="<?php echo $e['ConvenioId']; ?>" />
                                        <input type="hidden" name="IdContraprestacion" id="IdContraprestacion" value="<?php echo $e['IdContraprestacion']; ?>" />
                                        <input type="image" src="../../mgi/images/add.png" title="Nuevo" width="20"/>
                                    </form>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <form action="../Controller/Formulasliquidacion.php" method="post">                               
                        <input type="button" value="regresar" onclick="RegresarFormulas();" />
                    </form>
                </center>
            </fieldset>
        </div>
    </body>
</html>