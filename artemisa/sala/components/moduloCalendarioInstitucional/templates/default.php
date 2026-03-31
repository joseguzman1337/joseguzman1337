<?php
defined('_EXEC') or die;
//d($eventos);
echo Factory::printImportJsCss("css",HTTP_SITE."/assets/plugins/fullcalendar/fullcalendar.css"); 
echo Factory::printImportJsCss("css",HTTP_SITE."/assets/css/jquery.qtip.min.css"); 
echo Factory::printImportJsCss("css",HTTP_SITE."/components/moduloCalendarioInstitucional/assets/css/moduloCalendarioInstitucional.css"); 
$listaEventos = array();
foreach($eventos as $e){
    $listaEventos[] = "{
        id: ".$e->getCalenadrioInstitucionalId().",
        title: '".addslashes($e->getEvento())."',
        start: '".$e->getFechaInicial()."T".$e->getHoraInicial()."',
        end: '".$e->getFechaFin()."T".$e->getHoraFin()."',
        description: '".addslashes($e->getDescripcion())."',
        site: '".$e->getLugar()."',
        className: 'success'
    }";
}
?>
<script type="text/javascript">
    var events= [<?php echo implode(",",$listaEventos);?>];
</script>
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">Calendario institucional</h3>
    </div>
    <div class="panel-body">
        <div id='calendar'></div>
    </div>
</div>
<?php
echo Factory::printImportJsCss("js",HTTP_SITE."/assets/js/jquery.qtip.min.js"); 
echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/fullcalendar/lib/moment.min.js"); 
echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/fullcalendar/lib/jquery-ui.custom.min.js"); 
echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/fullcalendar/fullcalendar.min.js");
echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/fullcalendar/lang/es.js");
echo Factory::printImportJsCss("js",HTTP_SITE."/components/moduloCalendarioInstitucional/assets/js/moduloCalendarioInstitucional.js"); 
?>