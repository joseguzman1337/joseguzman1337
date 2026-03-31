<?PHP 
define('SessionActiva',false);
SessionActive();
function SessionActive(){
    if(SessionActiva==true){
        session_start();
        include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php');
        $ValidarSesion = new ValidarSesion();
        $ValidarSesion->Validar($_SESSION);
    }
}//function SessionActive
?>
<script type="text/javascript" language="javascript" src="../../mgi/js/jquery.js"></script>
<script type="text/javascript" src="../../EspacioFisico/asignacionSalones/js/jquery.datetimepicker.js"></script>
<script type="text/javascript" language="javascript" src="../../EspacioFisico/js/jquery.bpopup.min.js"></script>
<script type="text/javascript" language="javascript" src="../../EspacioFisico/js/jquery.clockpick.1.2.9.js"></script>
<script type="text/javascript" language="javascript" src="../../EspacioFisico/js/jquery.clockpick.1.2.9.min.js"></script>
<script type="text/javascript" language="javascript" src="../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
<script type="text/javascript" language="javascript" src="../../mgi/js/functions.js"></script>
<script type="text/javascript" language="javascript" src="../../mgi/js/functionsMonitoreo.js"></script>
<script type="text/javascript" language="javascript" >
    $(document).ready(function () {
        $.ajax({ //Ajax
            type: 'POST',
            url: '../Controller/CalendarioInstitucional_html.php',
            async: false,
            dataType: 'html',
            data:({action_ID: 'Inicio',view:1}),
            error: function (objeto, quepaso, otroobj) {
                alert('Error de Conexi?n , Favor Vuelva a Intentar');
            },
            success: function (data) {
                    $('#PrincipalView').html(data);
                } //DATA
        }); //AJAX
    });
</script>
<div id="PrincipalView"></div>