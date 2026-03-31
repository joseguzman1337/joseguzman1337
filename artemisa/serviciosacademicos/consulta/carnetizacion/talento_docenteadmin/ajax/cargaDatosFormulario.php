<?php
is_file(dirname(__FILE__) . "../../../../../sala/includes/adaptador.php")
    ? require_once(dirname(__FILE__) . "/../../../../../sala/includes/adaptador.php")
    : require_once(realpath(dirname(__FILE__) . "/../../../../../sala/includes/adaptador.php"));
   include ('../modelo/generalModelo.php');

   $cnsUsuarioAdministrativoDocente = generalModelo::mdlConsultaUsuarioAdministrativoDocente($_GET["numeroDocumento"],$_GET["tipoDocumento"]);

   if (!empty($cnsUsuarioAdministrativoDocente)){
        $idAdministrativosDocentes = $cnsUsuarioAdministrativoDocente[0]["idadministrativosdocentes"];
        $nombresAdministrativosDocentes = $cnsUsuarioAdministrativoDocente[0]["nombresadministrativosdocentes"];
        $apellidosAdministrativosDocentes = $cnsUsuarioAdministrativoDocente[0]["apellidosadministrativosdocentes"];
        $tipoDocumento = $cnsUsuarioAdministrativoDocente[0]["tipodocumento"];
        $numeroDocumento = $cnsUsuarioAdministrativoDocente[0]["numerodocumento"];
        $expedidoDocumento = $cnsUsuarioAdministrativoDocente[0]["expedidodocumento"];
        $idtipoGruposAnguineo = $cnsUsuarioAdministrativoDocente[0]["idtipogruposanguineo"];
        $codigoGenero = $cnsUsuarioAdministrativoDocente[0]["codigogenero"];
        $celularAdministrativosDocentes = $cnsUsuarioAdministrativoDocente[0]["celularadministrativosdocentes"];
        $emailAdministrativosDocentes = $cnsUsuarioAdministrativoDocente[0]["emailadministrativosdocentes"];
        $direccionAdministrativosDocentes = $cnsUsuarioAdministrativoDocente[0]["direccionadministrativosdocentes"];
        $telefonoAdministrativosDocentes = $cnsUsuarioAdministrativoDocente[0]["telefonoadministrativosdocentes"];
        $fechaTerminancionContratoAdministrativosDocentes = $cnsUsuarioAdministrativoDocente[0]["fechaterminancioncontratoadministrativosdocentes"];
        $cargoAdministrativosDocentes = $cnsUsuarioAdministrativoDocente[0]["cargoadministrativosdocentes"];
        $idtipousuarioadmdocen = $cnsUsuarioAdministrativoDocente[0]["idtipousuarioadmdocen"];
        $emailInstitucional = $cnsUsuarioAdministrativoDocente[0]["EmailInstitucional"];
        ?>
       <script>
           swal("Que Bien!", "El usuario ya existe actualiza sus datos!", "success");
           $('#idadministrativosdocentes').val(<?php echo $idAdministrativosDocentes;?>);
           $('#tituloProceso').html('Actualizar Usuario');
           $('#accion').val('actualizarAdministrativoDocente');
           $('#accion').html('Actualizar');
           $('#apellidos').val('<?php echo $apellidosAdministrativosDocentes;?>');
           $('#nombres').val('<?php echo $nombresAdministrativosDocentes;?>');
           $('#expedidodocumento').val('<?php echo $expedidoDocumento;?>');
           $('#tipogruposanguineo').val('<?php echo $idtipoGruposAnguineo;?>');
           $('#genero').val('<?php echo $codigoGenero;?>');
           $('#tipousuarioadmdocen').val('<?php echo $idtipousuarioadmdocen;?>');
           $('#celular').val('<?php echo $celularAdministrativosDocentes;?>');
           $('#email').val('<?php echo $emailAdministrativosDocentes;?>');
           $('#direccion').val('<?php echo $direccionAdministrativosDocentes;?>');
           $('#telefono').val('<?php echo $telefonoAdministrativosDocentes;?>');
           $('#cargo').val('<?php echo $cargoAdministrativosDocentes;?>');
           $('#fechavigencia').val('<?php echo $fechaTerminancionContratoAdministrativosDocentes;?>');
           $('#emailInstitucional').val('<?php echo $emailInstitucional;?>');
       </script>
       <?php
   }else{ ?>
       <script>
           $('#tituloProceso').html('Ingreso Nuevo Usuario');
           $("#accion").removeClass("btn-primary");
           $("#accion").addClass("btn-success");
           $('#accion').val('crearAdministrativoDocente');
           $('#accion').html('Crear');
           $('#apellidos').val('');
           $('#nombres').val('');
           $('#expedidodocumento').val('');
           $('#tipogruposanguineo').val('');
           $('#genero').val('');
           $('#tipousuarioadmdocen').val('');
           $('#celular').val('');
           $('#email').val('');
           $('#direccion').val('');
           $('#telefono').val('');
           $('#cargo').val('');
           $('#fechavigencia').val('');
           $('#emailInstitucional').val('');
       </script>
       <?php
   }
