/*
 * Se crea este archivo para que valide la clase form_datetime
 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Universidad el Bosque - Direccion de Tecnologia.
 * Creado 8 de Marzo de 2018.
 */
 /**
 * @modified David Perez <perezdavid@unbosque.edu.co>
 * @since  Julio 31, 2018
 * Se agrega fecha minima para ser escogida en el calendario
*/

$( document ).ready(function() {
    $(".form_datetime").datetimepicker({
        format: 'YYYY-MM-DD',
		startDate: '01/01/1900'
    }).on('changeDate', function(ev) { 
        $('.form_datetime').datepicker('hide');
    });
});
//end