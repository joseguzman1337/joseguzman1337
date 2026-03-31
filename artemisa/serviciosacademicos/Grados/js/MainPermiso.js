/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {
    // $( "#btnAdicionarPermiso" ).button({ label: "Asignar Permiso" });

    $("#cmbRoles").change(function () {
        var idRol = $("#cmbRoles").val( );
        var accion = "permiso"
        $.ajax({
            url: "../servicio/permiso.php",
            type: "POST",
            data: {idRol: idRol, accion: accion},
            success: function (data) {

                $("#cargarPermisos").html(data);
            }
        });
    });

    $(document).on('click', '.permiso', function (event) {
        var idRol = $("#cmbRoles").val( );
        var id = $(this).attr("attr-data");
        var estado = '';
        var accion = "asignacionPermiso";

        if ($(this).is(':checked')) {
            estado = 100;
        } else {
            estado = 200;
        }

        $.ajax({
            url: "../servicio/permiso.php",
            type: "POST",
            data: {idRol: idRol, accion: accion, permiso: id, estado: estado},
            success: function (data) {

            }
        });

    });
})

