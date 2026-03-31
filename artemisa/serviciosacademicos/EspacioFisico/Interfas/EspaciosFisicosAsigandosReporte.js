 /**
 * @created Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Se crea este archivo para organizar las funciones javascript
 * @since Agosto 9, 2019
 */
    function generamensaje(Fecha_ini,Fecha_Fin,Num_Docente,Num_Estudiante){
         $.ajax({
            type: "POST",
            dataType: "html",
            url: 'funcionesEspaciosFisicosAsigandosReporte.php',
            data:{actionID:'generamensaje', Fecha_ini:Fecha_ini, Fecha_Fin:Fecha_Fin, Num_Docente:Num_Docente, Num_Estudiante:Num_Estudiante},
            beforeSend: function () {
                $('#procesando').attr("style", "display:inline");
            },
            success:function(data) {
                $('#procesando').attr("style", "display:none");
                $('#message').attr("style", "display:inline");
                $('#message').html(data);
            }

      });
    }
    function InformacionResultado() {
        var Fecha_ini = $('#Fecha_ini').val();
        var Fecha_Fin = $('#Fecha_Fin').val();
        var Num_Docente = $('#Num_Docente').val();
        var Num_Estudiante = $('#Num_Estudiante').val();

        if (!$.trim(Num_Docente) && !$.trim(Num_Estudiante)) {
            alert('Por favor Ingrese uno de los Items de Busqueda');
            /***************************************************/
            $('#Num_Docente').effect("pulsate", {times: 3}, 500);
            $('#Num_Docente').css('border-color', '#F00');
            /***************************************************/
            $('#Num_Estudiante').effect("pulsate", {times: 3}, 500);
            $('#Num_Estudiante').css('border-color', '#F00');
            /***************************************************/
            return false;
        }
        
         $.ajax({
            type: "POST",
            dataType: "html",
            url: 'funcionesEspaciosFisicosAsigandosReporte.php',
            data:{actionID:'consultardatos', Fecha_ini:Fecha_ini, Fecha_Fin:Fecha_Fin, Num_Docente:Num_Docente, Num_Estudiante:Num_Estudiante},
            beforeSend: function () {
                generamensaje(Fecha_ini,Fecha_Fin,Num_Docente,Num_Estudiante);
                $('#tabla').attr("style", "display:none");
                $('#procesando').attr("style", "display:inline");
            },
            success:function(data) {
                $('#procesando').attr("style", "display:none");
                $('#tabla').attr("style", "display:inline");
                $('#resultado').html(data);
            }

      });
    }

