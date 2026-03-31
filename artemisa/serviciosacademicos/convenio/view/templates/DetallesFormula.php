<?php
$readonly = " class=\"daterange\" readonly ";
if(!empty($formulaLiquidacionId)){
    $readonly = " readonly ";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $title; ?></title>
        <link type="text/css" href="../../educacionContinuada/css/normalize.css" rel="stylesheet">
        <link rel="stylesheet" href="../../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link media="screen, projection" type="text/css" href="../../educacionContinuada/css/style.css" rel="stylesheet">
        <link href="<?php echo HTTP_SITE ?>/assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
        <link href="<?php echo HTTP_SITE ?>/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css" rel="stylesheet">
        <script type="text/javascript" language="javascript" src="<?php echo HTTP_SITE ?>/assets/js/jquery-3.6.0.min.js"></script> 
        <?php /*/ ?>
        <script type='text/javascript' language="javascript" src="../../js/jquery.js"></script>
        <script type='text/javascript' language="javascript" src="../../js/jquery.min.js"></script>
        <?php /**/ ?>
        <script type="text/javascript" language="javascript" src="../../js/jquery-ui-1.8.21.custom.min.js"></script> 
        <script type="text/javascript" language="javascript" src="../../educacionContinuada/js/functions.js"></script>
        <script type="text/javascript" language="javascript" src="../js/funcionesGestionContraprestaciones.js "></script> 
        <script type="text/javascript" language="javascript" src="<?php echo HTTP_SITE ?>/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script> 
        <script type="text/javascript" language="javascript" src="<?php echo HTTP_SITE ?>/assets/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.js"></script> 
        
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
            <center><h3><font face="sans-serif"><?php echo $nombreinstitucion; ?> - <?php echo $nombreprograma; ?></font></h3></center>
        </div>
        <div>
            <fieldset>
                <center>
                    <div style="display: <?php echo $div; ?>">
                        <table border="0"><thead><th><font face="sans-serif" color="#6a7528">Fx = <?php echo $formulaanterior; ?></font></th></thead></table>
                    </div>
                </center>
            </fieldset>
            <fieldset>               
                <center>
                    <form method="post" action="ActualizarFormulas.php" id="form_programa" enctype="multipart/form-data" >
                        <input type="button" id="btnAdd" value="Agregar Campos" />
                        <input type="button" id="btnDel" value="Eliminar Campos" />
                        <br /><br />
                        <table id="">
                            <tr>
                                <td>
                                    Fecha Inicio Vigencia
                                </td>
                                <td>
                                    <input type="text" id="fechaInicioVigencia" name="fechaInicioVigencia" value="<?php echo $fechaInicioVigencia; ?>" <?php echo $readonly; ?> >
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Fecha Fin Vigencia
                                </td>
                                <td>
                                    <input type="text" id="fechaFinVigencia" name="fechaFinVigencia" value="<?php echo $fechaFinVigencia; ?>" <?php echo $readonly; ?> >
                                </td>
                            </tr>
                        </table>
                        <table id="camposformula">
                            <tr>
                                <td id="1">
                                    <select id="campo_1" name="campo_1"  onchange="Valor(this.value, this.name)">
                                        <option></option>
                                        <?php foreach ($campos as $c) { ?>
                                            <option value="<?php echo $c['CamposFormulaId']; ?>"><?php echo $c['Nombre']; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>                        
                                <td id="2">
                                    <select id="campo_2" name="campo_2">
                                        <option></option>
                                        <?php foreach ($simbolos as $s) { ?>
                                            <option value="<?php echo $s['id']; ?>"><?php echo $s['simbolo']; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>                        
                                <td id="3">
                                    <select id="campo_3" name="campo_3" onchange="Valor(this.value, this.name)">
                                        <option></option>
                                        <?php foreach ($campos as $c) { ?>
                                            <option value="<?php echo $c['CamposFormulaId']; ?>"><?php echo $c['Nombre']; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>                        
                            </tr>
                        </table>
                        <input type="hidden" name="Accion" id="Accion" value="GuardarFormula" />
                        <input type="hidden" name="contador" id="contador" value="3" />
                        <input type="hidden" name="codigocarrera" id="codigocarrera" value="<?php echo $codigocarrera; ?>" />
                        <input type="hidden" name="ConvenioId" id="ConvenioId" value="<?php echo $ConvenioId; ?>" />
                        <input type="hidden" name="IdContraprestacion" id="IdContraprestacion" value="<?php echo $IdContraprestacion; ?>" />
                        <input type="hidden" name="formulaLiquidacionId" id="formulaLiquidacionId" value="<?php echo $formulaLiquidacionId; ?>" />
                        <input type="submit" name="submit" id="submit" value="Guardar cambios" />
                        <input type="button" value="regresar" onclick="RegresarFormulas();" />                
                    </form>
                </center>
            </fieldset>
        </div>
    </body>
</html>
<script type="text/javascript">
    $(document).ready(function(){
        $('.daterange').datepicker({
            format: "yyyy-mm-dd",
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true, 
            language: 'es',
            orientation: "top"
        });
    });
    $(':submit').click(function (event) {
        var fechaInicioVigencia = $('#fechaInicioVigencia').val();
        var fechaFinVigencia = $('#fechaFinVigencia').val();
        event.preventDefault();
        var c = 0;
        var d = 1;
        $('#camposformula tr td').each(function (index)
        {
            if (!$('#campo_' + d).val())
            {
                alert("Verifique que no este ningun campo vacio");
                $('#camposformula').finish();
                $c++;
            }
        });

        if (fechaInicioVigencia.trim() === "") {
            alert("El campo Fecha Inicio Vigencia es obligatorio");
            $c++;
        }else if (fechaFinVigencia.trim() === "") {
            alert("El campo Fecha Fin Vigencia es obligatorio");
            $c++;
        }else{
            var d1 = new Date(fechaInicioVigencia.trim());    
            var d2 = new Date(fechaFinVigencia.trim());    
            if(d2 < d1){
                alert("La Fecha Fin Vigencia debe ser mayro a la Fecha Inicio Vigencia");
                $c++;
            }
        }

        if (c == 0)
        {
            $.ajax({
                dataType: 'json',
                type: 'GET',
                url: '../Controller/ActualizarFormulas.php',
                data: $('#form_programa').serialize(),
                success: function (data) {
                    if (data.success == true) {
                        alert(data.message);
                        window.location.href = "../Controller/Formulasliquidacion.php";
                    } else {
                        alert(data.message);
                    }
                },
                error: function (data, error, errorThrown) {
                    alert(error + errorThrown);
                }
            });
        }
    });
</script>
<script>
    $(document).ready(function ()
    {
        var c = 0;
        $('#camposformula tr td').each(function (index)
        {
            c = c + 1;
        });
        if (c == 3 || c < 3)
        {
            $("#btnDel").hide();
        } else
        {
            $("#btnDel").show();
        }
    });

    $('#btnAdd').click(function ()
    {
        var $id = $('#camposformula tr:last-child td:last-child select').attr("name");
        if ($id.length == '7')
        {
            $lastChar = parseInt($id.substr($id.length - 1), 10);
        }
        if ($id.length == '8')
        {
            $lastChar = parseInt($id.substr($id.length - 2), 10);
        }
        if ($lastChar < 16)
        {
            $lastCharA = $lastChar + 1;
            $lastCharB = $lastCharA + 1;

            var newRow = "<td id='" + $lastCharA + "'><select id='campo_" + $lastCharA + "' name='campo_" + $lastCharA + "'><option></option><?php foreach ($simbolos as $s) { ?><option value='<?php echo $s['id']; ?>'><?php echo $s['simbolo']; ?></option><?php } ?></select></td><td id='" + $lastCharB + "'><select id='campo_" + $lastCharB + "' name='campo_" + $lastCharB + "'  onchange='Valor(this.value, this.name)'><option></option><?php foreach ($campos as $c) { ?><option value='<?php echo $c['CamposFormulaId']; ?>' ><?php echo $c['Nombre']; ?></option><?php } ?></select></td>";
            $('#camposformula tr:last-child ').append(newRow);

            $('#contador').val($lastCharB);
            $("#btnDel").show();
        } else
        {
            $('#btnAdd').hide();
        }
    });

    $("#btnDel").click(function () {
        var c = 0;
        $('#camposformula tr td').each(function (index)
        {
            c = c + 1;
        });
        if (c == 3 || c < 3)
        {
            $("#btnDel").hide();
        } else
        {
            $('#camposformula tr:last-child td:last-child').remove();
            $('#camposformula tr:last-child td:last-child').remove();
            $lastChar = $lastChar - 2;
            $('#btnAdd').show();
        }
    });

    function Valor(datos, name)
    {
        var num = name.slice(6);
        if (datos == 12 || datos == 3 || datos == 11 || datos == 6 || datos == 9 || datos == 15 || datos == 16 || datos == 17)
        {
            $("#N" + num).remove();
            var input = "<br /><input type='text' id='N" + num + "' name='N" + num + "' />";
            $("#" + num).append(input);
        } else
        {
            $('#N' + num).remove();
        }
    }
</script>