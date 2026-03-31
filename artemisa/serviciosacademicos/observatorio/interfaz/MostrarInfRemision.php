<?php 
   require_once(realpath(dirname(__FILE__)).'/../../Connections/sala2.php' );
  mysql_select_db($database_sala, $sala);

$RemisionEsudianteId = $_REQUEST['RemisionEsudianteId'];
$TipoRemisionId = $_REQUEST['TipoRemisionId'];
$idestudiantegeneral = $_REQUEST['idestudiantegeneral'];
$periodo = $_REQUEST['periodo'];




              $RemEstudiante = " SELECT * 
              from RemisionEstudiante
              Where  
              RemisionEsudianteId = '".$RemisionEsudianteId."'
              and idestudiantegeneral = '".$idestudiantegeneral."'
              and PeriodoAcademico LIKE '".$periodo."'";
              $remisionesEstudiantes = mysql_query($RemEstudiante, $sala) or die(mysql_error());
              $EstudianteRemision2 = mysql_fetch_assoc($remisionesEstudiantes);

?>
<script type="text/javascript">
    
            // $( "#NomRem" ).attr({
            //     disabled: "disabled"
            // });
            // $( "#FacRem" ).attr({
            //     disabled: "disabled"
            // });
            // $( "#CelRem" ).attr({
            //     disabled: "disabled"
            // });
            // $( "#FijoRem" ).attr({
            //     disabled: "disabled"
            // });
            // $( "#EmailRem" ).attr({
            //     disabled: "disabled"
            // });
            // $( "#DescripcionRemision" ).attr({
            //     disabled: "disabled"
            // });
            // $( "#DescripcionCompObs" ).attr({
            //     disabled: "disabled"
            // });
            // $( "#DescripcionIntervenPae" ).attr({
            //     disabled: "disabled"
            // });
            // $( "#DescripcionSolAcademica" ).attr({
            //     disabled: "disabled"
            // });


            document.getElementById('NomRem').value="<?php echo $EstudianteRemision2['NombreRemitente']?>";
            document.getElementById('FacRem').value="<?php echo $EstudianteRemision2['FacultadRemitente']?>";
            document.getElementById('CelRem').value="<?php echo $EstudianteRemision2['CelularRemitente']?>";
            document.getElementById('FijoRem').value="<?php echo $EstudianteRemision2['FijoRemitente']?>";
            document.getElementById('EmailRem').value="<?php echo $EstudianteRemision2['EmailRemitente']?>";

            document.getElementById('DescripcionRemision').value="<?php echo $EstudianteRemision2['MotivoRemision']?>";
            document.getElementById('DescripcionCompObs').value="<?php echo $EstudianteRemision2['ComportamientoObRemision']?>";
            document.getElementById('DescripcionIntervenPae').value="<?php echo $EstudianteRemision2['IntervencionPaeRemision']?>";
            document.getElementById('DescripcionSolAcademica').value="<?php echo $EstudianteRemision2['SolicitudEcRemision']?>";

            
            $('#modal').modal();
            $('#guardar').slideUp();

            $('#FechaRegistro').text("Fecha de registro: "+"<?php echo $EstudianteRemision2['FechaRegistro']?>");
            $('#FechaRegistro').slideDown();

            $("#idActualizar").val("<?php echo $RemisionEsudianteId ?>");   

            $idRemision = <?php echo $EstudianteRemision2['TipoRemisionId']?>;


            if ($idRemision==21) {

                $('#SolAc').slideUp();
                $('#ComObser').slideUp();
                $('#primariaPae').slideUp();

                $('#Pares').slideDown();
                $('#Psico').slideUp();
                $('#Psicope').slideUp();
                $('#Lpl').slideUp();
                $('#Fin').slideUp();

            }
            if ($idRemision==22) {

                $('#SolAc').slideUp();
                $('#ComObser').slideDown();
                $('#primariaPae').slideDown();

                $('#Pares').slideUp();
                $('#Psico').slideDown();
                $('#Psicope').slideUp();
                $('#Lpl').slideUp();
                $('#Fin').slideUp();
                
            }
            if ($idRemision==23 || $idRemision==24) {

                $('#SolAc').slideUp();
                $('#ComObser').slideUp();
                $('#primariaPae').slideDown();

                $('#Pares').slideUp();
                $('#Psico').slideUp();
                $('#Psicope').slideUp();
                $('#Lpl').slideUp();
                $('#Fin').slideUp();

                if ($idRemision==23) {$('#Psicope').slideDown();}else{$('#Lpl').slideDown();}
                
            }

            if ($idRemision==25) {
                
                $('#SolAc').slideDown();
                $('#ComObser').slideUp();
                $('#primariaPae').slideUp();


                $('#Pares').slideUp();
                $('#Psico').slideUp();
                $('#Psicope').slideUp();
                $('#Lpl').slideUp();
                $('#Fin').slideDown();

                
            }
</script>