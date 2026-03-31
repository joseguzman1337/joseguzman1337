<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    //session_start();
    if(!isset($_SESSION['MM_Username'])){
            //$_SESSION['MM_Username'] = 'admintecnologia';
            echo "No ha iniciado sesión en el sistema"; die();
        }
        
    $ruta = "../";
    while (!is_file($ruta.'Connections/sala2.php'))
    {
        $ruta = $ruta."../";
    }
    require_once($ruta.'Connections/sala2.php');
    $rutaado = $ruta."funciones/adodb/";
    require_once($ruta.'Connections/salaado.php');
    //var_dump($db);
    $sql = "SELECT * FROM usuario WHERE usuario='".$_SESSION['MM_Username']."'";
    $result = $db->GetRow($sql);
    $actualizo = array();
    
    $today = date('Y-m-d H:i:s');
    $sql = "SELECT * FROM periodo WHERE fechainicioperiodo<='".$today."' AND fechavencimientoperiodo>='".$today."'";
    $resultP = $db->GetRow($sql);
    
    if(count($result)==0){
        echo "No ha iniciado sesión en el sistema"; die();
    } else {
        $usuario = $result["idusuario"];
        $periodo = $resultP["codigoperiodo"];
        $sql = "SELECT * FROM actualizacionusuario WHERE usuarioid='".$usuario."' AND tipoactualizacion='2' AND estadoactualizacion='1' AND codigoestado='100'";
        $actualizo = $db->GetRow($sql);        
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html class="js" lang="es" xmlns:v="urn:schemas-microsoft-com:vml" dir="ltr" xml:lang="es" xmlns="http://www.w3.org/1999/xhtml">
    <?php //si ya lleno la encuesta
    if(count($actualizo)>0){ ?>    
        <head>
            <script type="text/javascript">
                <?php if($result["codigotipousuario"]!=600){ ?>
                    window.parent.continuar2("../facultades/central.php");
                //parent.window.frames[0].location.href=    "../facultades/facultadeslv2.php";
                //window.location.href="../facultades/central.php";
                //window.location.href="../facultades/facultadeslv2.php";
                <?php }else { ?>
                window.location.href="../encuesta/encuestaestudiantesnuevos/validaingresoestudiante.php?idencuesta=50&idusuario=<?PHP echo $_REQUEST["idusuario"]; ?>&codigotipousuario=600";
                <?php } ?>
            </script>
        </head></html>
    <?php die(); } ?>
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
            <title>Entre todos seguimos construyendo una mejor Universidad | Universidad El Bosque</title>
    
            <link type="image/x-icon" href="http://www.uelbosque.edu.co/sites/default/themes/ueb/images/ueb_favicon.ico" rel="shortcut icon">
            <!--<link href="http://www.uelbosque.edu.co/sites/default/files/css/css_622446f6c49d22331f4a2101ac4ce8e7.css" media="all" rel="stylesheet" type="text/css">-->
			<style type="text/css">
			.node-unpublished{background-color:#fff4f4}.preview .node{background-color:#ffffea}#node-admin-filter ul{list-style-type:none;padding:0;margin:0;width:100%}#node-admin-buttons{float:left;margin-left:.5em;clear:right}td.revision-current{background:#ffc}.node-form .form-text{display:block;width:95%}.node-form .container-inline .form-text{display:inline;width:auto}.node-form .standard{clear:both}.node-form textarea{display:block;width:95%}.node-form .attachments fieldset{float:none;display:block}.terms-inline{display:inline}.poll .bar{height:1em;margin:1px 0;background-color:#ddd}.poll .bar .foreground{background-color:#000;height:1em;float:left}.poll .links{text-align:center}.poll .percent{text-align:right}.poll .total{text-align:center}.poll .vote-form{text-align:center}.poll .vote-form .choices{text-align:left;margin:0 auto;display:table}.poll .vote-form .choices .title{font-weight:bold}.node-form #edit-poll-more{margin:0}td.poll-chtext{width:80%}td.poll-chvotes .form-text{width:85%}fieldset{margin-bottom:1em;padding:.5em}form{margin:0;padding:0}hr{height:1px;border:1px solid gray}img{border:0}table{border-collapse:collapse}th{text-align:left;padding-right:1em;border-bottom:3px solid #ccc}.clear-block:after{content:".";display:block;height:0;clear:both;visibility:hidden}.clear-block{display:inline-block}/*\*/* html .clear-block{height:1%}.clear-block{display:block}/**/body.drag{cursor:move}th.active img{display:inline}tr.even,tr.odd{background-color:#eee;border-bottom:1px solid #ccc;padding:.1em .6em}tr.drag{background-color:#fffff0}tr.drag-previous{background-color:#ffd}td.active{background-color:#ddd}td.checkbox,th.checkbox{text-align:center}tbody{border-top:1px solid #ccc}tbody th{border-bottom:1px solid #ccc}thead th{text-align:left;padding-right:1em;border-bottom:3px solid #ccc}.breadcrumb{padding-bottom:.5em}div.indentation{width:20px;height:1.7em;margin:-0.4em .2em -0.4em -0.4em;padding:.42em 0 .42em .6em;float:left}div.tree-child{background:url(/misc/tree.png) no-repeat 11px center}div.tree-child-last{background:url(/misc/tree-bottom.png) no-repeat 11px center}div.tree-child-horizontal{background:url(/misc/tree.png) no-repeat -11px center}.error{color:#e55}div.error{border:1px solid #d77}div.error,tr.error{background:#fcc;color:#200;padding:2px}.warning{color:#e09010}div.warning{border:1px solid #f0c020}div.warning,tr.warning{background:#ffd;color:#220;padding:2px}.ok{color:#008000}div.ok{border:1px solid #0a0}div.ok,tr.ok{background:#dfd;color:#020;padding:2px}.item-list .icon{color:#555;float:right;padding-left:.25em;clear:right}.item-list .title{font-weight:bold}.item-list ul{margin:0 0 .75em 0;padding:0}.item-list ul li{margin:0 0 .25em 1.5em;padding:0;list-style:disc}ol.task-list li.active{font-weight:bold}.form-item{margin-top:1em;margin-bottom:1em}tr.odd .form-item,tr.even .form-item{margin-top:0;margin-bottom:0;white-space:nowrap}tr.merge-down,tr.merge-down td,tr.merge-down th{border-bottom-width:0!important}tr.merge-up,tr.merge-up td,tr.merge-up th{border-top-width:0!important}.form-item input.error,.form-item textarea.error,.form-item select.error{border:2px solid red}.form-item .description{font-size:.85em}.form-item label{display:block;font-weight:bold}.form-item label.option{display:inline;font-weight:normal}.form-checkboxes,.form-radios{margin:1em 0}.form-checkboxes .form-item,.form-radios .form-item{margin-top:.4em;margin-bottom:.4em}.marker,.form-required{color:#f00}.more-link{text-align:right}.more-help-link{font-size:.85em;text-align:right}.nowrap{white-space:nowrap}.item-list .pager{clear:both;text-align:center}.item-list .pager li{background-image:none;display:inline;list-style-type:none;padding:.5em}.pager-current{font-weight:bold}.tips{margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;font-size:.9em}dl.multiselect dd.b,dl.multiselect dd.b .form-item,dl.multiselect dd.b select{font-family:inherit;font-size:inherit;width:14em}dl.multiselect dd.a,dl.multiselect dd.a .form-item{width:10em}dl.multiselect dt,dl.multiselect dd{float:left;line-height:1.75em;padding:0;margin:0 1em 0 0}
dl.multiselect .form-item{height:1.75em;margin:0}.container-inline div,.container-inline label{display:inline}ul.primary{border-collapse:collapse;padding:0 0 0 1em;white-space:nowrap;list-style:none;margin:5px;height:auto;line-height:normal;border-bottom:1px solid #bbb}ul.primary li{display:inline}ul.primary li a{background-color:#ddd;border-color:#bbb;border-width:1px;border-style:solid solid none solid;height:auto;margin-right:.5em;padding:0 1em;text-decoration:none}ul.primary li.active a{background-color:#fff;border:1px solid #bbb;border-bottom:#fff 1px solid}ul.primary li a:hover{background-color:#eee;border-color:#ccc;border-bottom-color:#eee}ul.secondary{border-bottom:1px solid #bbb;padding:.5em 1em;margin:5px}ul.secondary li{display:inline;padding:0 1em;border-right:1px solid #ccc}ul.secondary a{padding:0;text-decoration:none}ul.secondary a.active{border-bottom:4px solid #999}#autocomplete{position:absolute;border:1px solid;overflow:hidden;z-index:100}#autocomplete ul{margin:0;padding:0;list-style:none}#autocomplete li{background:#fff;color:#000;white-space:pre;cursor:default}#autocomplete li.selected{background:#0072b9;color:#fff}html.js input.form-autocomplete{background-image:url(/misc/throbber.gif);background-repeat:no-repeat;background-position:100% 2px}html.js input.throbbing{background-position:100% -18px}html.js fieldset.collapsed{border-bottom-width:0;border-left-width:0;border-right-width:0;margin-bottom:0;height:1em}html.js fieldset.collapsed *{display:none}html.js fieldset.collapsed legend{display:block}html.js fieldset.collapsible legend a{padding-left:15px;background:url(/misc/menu-expanded.png) 5px 75% no-repeat}html.js fieldset.collapsed legend a{background-image:url(/misc/menu-collapsed.png);background-position:5px 50%}* html.js fieldset.collapsed legend,* html.js fieldset.collapsed legend *,* html.js fieldset.collapsed table *{display:inline}html.js fieldset.collapsible{position:relative}html.js fieldset.collapsible legend a{display:block}html.js fieldset.collapsible .fieldset-wrapper{overflow:auto}.resizable-textarea{width:95%}.resizable-textarea .grippie{height:9px;overflow:hidden;background:#eee url(/misc/grippie.png) no-repeat center 2px;border:1px solid #ddd;border-top-width:0;cursor:s-resize}html.js .resizable-textarea textarea{margin-bottom:0;width:100%;display:block}.draggable a.tabledrag-handle{cursor:move;float:left;height:1.7em;margin:-0.4em 0 -0.4em -0.5em;padding:.42em 1.5em .42em .5em;text-decoration:none}a.tabledrag-handle:hover{text-decoration:none}a.tabledrag-handle .handle{margin-top:4px;height:13px;width:13px;background:url(/misc/draggable.png) no-repeat 0 0}a.tabledrag-handle-hover .handle{background-position:0 -20px}.joined+.grippie{height:5px;background-position:center 1px;margin-bottom:-2px}.teaser-checkbox{padding-top:1px}div.teaser-button-wrapper{float:right;padding-right:5%;margin:0}.teaser-checkbox div.form-item{float:right;margin:0 5% 0 0;padding:0}textarea.teaser{display:none}html.js .no-js{display:none}.progress{font-weight:bold}.progress .bar{background:#fff url(/misc/progress.gif);border:1px solid #00375a;height:1.5em;margin:0 .2em}.progress .filled{background:#0072b9;height:1em;border-bottom:.5em solid #004a73;width:0}.progress .percentage{float:right}.progress-disabled{float:left}.ahah-progress{float:left}.ahah-progress .throbber{width:15px;height:15px;margin:2px;background:transparent url(/misc/throbber.gif) no-repeat 0 -18px;float:left}tr .ahah-progress .throbber{margin:0 2px}.ahah-progress-bar{width:16em}#first-time strong{display:block;padding:1.5em 0 .5em}tr.selected td{background:#ffc}table.sticky-header{margin-top:0;background:#fff}#clean-url.install{display:none}html.js .js-hide{display:none}#system-modules div.incompatible{font-weight:bold}#system-themes-form div.incompatible{font-weight:bold}span.password-strength{visibility:hidden}input.password-field{margin-right:10px}div.password-description{padding:0 2px;margin:4px 0 0 0;font-size:.85em;max-width:500px}div.password-description ul{margin-bottom:0}.password-parent{margin:0}input.password-confirm{margin-right:10px}
.confirm-parent{margin:5px 0 0 0}span.password-confirm{visibility:hidden}span.password-confirm span{font-weight:normal}ul.menu{list-style:none;border:0;text-align:left}ul.menu li{margin:0 0 0 .5em}li.expanded{list-style-type:circle;list-style-image:url(/misc/menu-expanded.png);padding:.2em .5em 0 0;margin:0}li.collapsed{list-style-type:disc;list-style-image:url(/misc/menu-collapsed.png);padding:.2em .5em 0 0;margin:0}li.leaf{list-style-type:square;list-style-image:url(/misc/menu-leaf.png);padding:.2em .5em 0 0;margin:0}li a.active{color:#000}td.menu-disabled{background:#ccc}ul.links{margin:0;padding:0}ul.links.inline{display:inline}ul.links li{display:inline;list-style-type:none;padding:0 .5em}.block ul{margin:0;padding:0 0 .25em 1em}#permissions td.module{font-weight:bold}#permissions td.permission{padding-left:1.5em}#access-rules .access-type,#access-rules .rule-type{margin-right:1em;float:left}#access-rules .access-type .form-item,#access-rules .rule-type .form-item{margin-top:0}#access-rules .mask{clear:both}#user-login-form{text-align:center}#user-admin-filter ul{list-style-type:none;padding:0;margin:0;width:100%}#user-admin-buttons{float:left;margin-left:.5em;clear:right}#user-admin-settings fieldset .description{font-size:.85em;padding-bottom:.5em}.profile{clear:both;margin:1em 0}.profile .picture{float:right;margin:0 1em 1em 0}.profile h3{border-bottom:1px solid #ccc}.profile dl{margin:0 0 1.5em 0}.profile dt{margin:0 0 .2em 0;font-weight:bold}.profile dd{margin:0 0 1em 0}.calendar-calendar tr.odd,.calendar-calendar tr.even{background-color:#fff}.calendar-calendar table{border-collapse:collapse;border-spacing:0;margin:0 auto;padding:0;width:100%}.calendar-calendar .month-view table{border:0;padding:0;margin:0;width:100%}.calendar-calendar .year-view td{width:32%;padding:1px;border:0}.calendar-calendar .year-view td table td{width:13%;padding:0}.calendar-calendar tr{padding:0;margin:0;background-color:white}.calendar-calendar th{text-align:center;margin:0}.calendar-calendar th a{font-weight:bold}.calendar-calendar td{width:12%;min-width:12%;border:1px solid #ccc;color:#777;text-align:right;vertical-align:top;margin:0;padding:0}.calendar-calendar .mini{border:0}.calendar-calendar td.week{width:1%;min-width:1%}.calendar-calendar .week{clear:both;font-style:normal;color:#555;font-size:.8em}.calendar-calendar .week a{font-weight:normal}.calendar-calendar .inner{height:auto!important;height:5em;padding:0;margin:0}.calendar-calendar .inner div{padding:0;margin:0}.calendar-calendar .inner p{padding:0 0 .8em 0;margin:0}.calendar-calendar td a{font-weight:bold;text-decoration:none}.calendar-calendar td a:hover{text-decoration:underline}.calendar-calendar td.year,.calendar-calendar td.month{text-align:center}.calendar-calendar th.days{color:#ccc;background-color:#224;text-align:center;padding:1px;margin:0}.calendar-calendar div.day{float:right;text-align:center;padding:.125em .25em 0 .25em;margin:0;background-color:#f3f3f3;border:1px solid gray;border-width:0 0 1px 1px;clear:both;width:1.5em}.calendar-calendar div.calendar{background-color:#fff;border:solid 1px #ddd;text-align:left;margin:0 .25em .25em 0;width:96%;float:right;clear:both}.calendar-calendar .day-view div.calendar{float:none;width:98%;margin:1% 1% 0 1%}.calendar-calendar div.title{font-size:.8em;text-align:center}.calendar-calendar div.title a{color:#000}.calendar-calendar div.title a:hover{color:#c00}.calendar-calendar .content{clear:both;padding:3px;padding-left:5px}.calendar div.form-item{white-space:normal}table td.mini,table th.mini,table.mini td.week{padding:0 1px 0 0;margin:0}table td.mini a{font-weight:normal}.calendar-calendar .mini-day-off{padding:0}.calendar-calendar .mini-day-on{padding:0}table .mini-day-on a{text-decoration:underline}.calendar-calendar .mini .title{font-size:.8em}.mini .calendar-calendar .week{font-size:.7em}.mini-row{width:100%;border:0}.mini{width:32%;vertical-align:top}.calendar-calendar .stripe{height:5px;width:auto;font-size:1px!important;line-height:1px!important}.calendar-calendar .day-view .stripe{width:100%}table.calendar-legend{background-color:#ccc;width:100%;margin:0;padding:0}
table.calendar-legend tr.odd .stripe,table.calendar-legend tr.even .stripe{height:12px!important;font-size:9px!important;line-height:10px!important}.calendar-legend td{text-align:left}.calendar-empty{font-size:1px;line-height:1px}.calendar-calendar td.calendar-agenda-hour{text-align:right;border:0;border-top:1px solid #ccc;padding-top:.25em;width:1%}.calendar-calendar td.calendar-agenda-no-hours{min-width:1%}.calendar-calendar td.calendar-agenda-hour .calendar-hour{font-size:1.2em;font-weight:bold}.calendar-calendar td.calendar-agenda-hour .calendar-ampm{font-size:1em}.calendar-calendar td.calendar-agenda-items{border:1px solid #ccc;text-align:left}.calendar-calendar td.calendar-agenda-items div.calendar{width:auto;padding:.25em;margin:0}.calendar-calendar div.calendar div.inner .calendar-agenda-empty{width:100%;text-align:center;vertical-align:middle;padding:1em 0;background-color:#fff}.calendar-date-select form{text-align:right;float:right;width:25%}.calendar-date-select div,.calendar-date-select input,.calendar-date-select label{text-align:right;padding:0;margin:0;float:right;clear:both}.calendar-date-select .description{float:right}.calendar-label{font-weight:bold;display:block;clear:both}.calendar-calendar div.date-nav{background-color:#ccc;color:#777;padding:.2em;width:auto;border:1px solid #ccc}.calendar-calendar div.date-nav a,.calendar-calendar div.date-nav h3{color:#777;text-decoration:none}.calendar-calendar th.days{background-color:#eee;color:#777;font-weight:bold;border:1px solid #ccc}.calendar-calendar td.empty{background:#ccc;border-color:#ccc}.calendar-calendar table.mini td.empty{background:#fff;border-color:#fff}.calendar-calendar td div.day{border:1px solid #ccc;border-top:0;border-right:0;margin-bottom:2px}.calendar-calendar td .inner div,.calendar-calendar td .inner div a{background:#eee}.calendar-calendar div.calendar{border:0;font-size:x-small}.calendar-calendar td .inner div.calendar div,.calendar-calendar td .inner div.calendar div a{border:0;background:#ffc;padding:0}.calendar-calendar td .inner div.calendar div.calendar-more,.calendar-calendar td .inner div.calendar div.calendar-more a{color:#444;background:#fff;text-align:right}.calendar-calendar td .inner .view-field,.calendar-calendar td .inner .view-field a{color:#444;font-weight:normal}.calendar-calendar td span.date-display-single,.calendar-calendar td span.date-display-start,.calendar-calendar td span.date-display-end,.calendar-calendar td span.date-display-separator{font-weight:bold}.calendar-calendar td .inner div.day a{color:#4b85ac}.calendar-calendar tr td.today,.calendar-calendar tr.odd td.today,.calendar-calendar tr.even td.today{background-color:#c3d6e4}.calendar-calendar tbody{border-top:0}.calendar-calendar .month-view .full .inner,.calendar-calendar .week-view .full .multi-day .inner{height:auto;min-height:auto}.calendar-calendar .week-view .full .calendar-agenda-hour .calendar-calendar .month-view .full .single-day .inner .view-item{float:left;width:100%}.calendar-calendar .week-view .full .calendar-agenda-hour{width:6%;min-width:0;padding-right:2px}.calendar-calendar .week-view .full .days{width:13%}.calendar-calendar .month-view .full div.calendar,.calendar-calendar .week-view .full div.calendar,.calendar-calendar .day-view div.calendar{width:auto}.calendar-calendar .month-view .full tr.date-box,.calendar-calendar .month-view .full tr.date-box td,.calendar-calendar .month-view .full tr.multi-day,.calendar-calendar .month-view .full tr.multi-day td{height:19px;max-height:19px}.calendar-calendar .month-view .full tr.single-day .no-entry,.calendar-calendar .month-view .full tr.single-day .no-entry .inner{height:44px!important;line-height:44px;font-size:1px}.calendar-calendar .month-view .full tr.single-day .noentry-multi-day,.calendar-calendar .month-view .full tr.single-day .noentry-multi-day .inner{height:22px!important;line-height:22px;font-size:1px}.calendar-calendar .month-view .full td,.calendar-calendar .week-view .full td,.calendar-calendar .day-view td{vertical-align:top;padding:1px 2px 0 2px}.calendar-calendar .month-view .full td.date-box{height:1%;border-bottom:0;padding-bottom:2px}
.calendar-calendar .month-view .full .week{font-size:inherit}.calendar-calendar .month-view .full .week a,.calendar-calendar .week-view .full .week a{color:#4b85ac}.calendar-calendar .month-view .full td .inner div.day,.calendar-calendar .month-view .full td .inner div.day a{border:0;background:0;margin-bottom:0}.calendar-calendar .month-view .full td.date-box .inner,.calendar-calendar .week-view .full td.date-box .inner{min-height:inherit}.calendar-calendar .month-view .full td.multi-day,.calendar-calendar .week-view .full td.multi-day{border-top:0;border-bottom:0}.calendar-calendar .week-view .full .first td.multi-day{border-top:1px solid #ccc}.calendar-calendar .month-view .full td.single-day{border-top:0}.calendar-calendar .month-view .full td.multi-day .inner,.calendar-calendar .week-view .full td.multi-day .inner,.calendar-calendar .day-view .full td.multi-day .inner{min-height:inherit;width:auto;position:relative}.calendar-calendar .month-view .full td.multi-day.no-entry{min-height:0}.calendar-calendar .month-view .full td.single-day .calendar-empty,.calendar-calendar .month-view .full td.single-day.empty,.calendar-calendar .month-view .full td.date-box.empty{background:#f4f4f4}.calendar-calendar .month-view .full td.single-day .inner div,.calendar-calendar .month-view .full td.single-day .inner div a,.calendar-calendar .month-view .full td.multi-day .inner div,.calendar-calendar .month-view .full td.multi-day .inner div a,.calendar-calendar .month-view .full td .inner div.calendar.monthview div,.calendar-calendar .month-view .full td .inner div.calendar.monthview div a,.calendar-calendar .week-view .full td.single-day .inner div,.calendar-calendar .week-view .full td.single-day .inner div a,.calendar-calendar .week-view .full td.multi-day .inner div,.calendar-calendar .week-view .full td.multi-day .inner div a,.calendar-calendar .week-view .full td .inner div.calendar.weekview div,.calendar-calendar .week-view .full td .inner div.calendar.weekview div a,.calendar-calendar .day-view .full td .inner div.view-item,.calendar-calendar .day-view .full td .inner div.calendar div,.calendar-calendar .day-view .full td .inner div.calendar div a{background:0}.calendar-calendar .day-view .full td .inner div.calendar div,.calendar-calendar .day-view .full td .inner div.calendar div a{margin:0 3px}.calendar-calendar .day-view .full td .inner div.calendar div.stripe{margin:0}.calendar-calendar .month-view .full tr td.today,.calendar-calendar .month-view .full tr.odd td.today,.calendar-calendar .month-view .full tr.even td.today{background:0;border-left:2px solid #7c7f12;border-right:2px solid #7c7f12}.calendar-calendar .month-view .full td.date-box.today{border-width:2px 2px 0 2px;border-style:solid;border-color:#7c7f12}.calendar-calendar .month-view .full tr td.single-day.today{border-bottom:2px solid #7c7f12}.calendar-calendar .month-view .full tr td.multi-day.starts-today{border-left:2px solid #7c7f12}.calendar-calendar .month-view .full tr td.multi-day.ends-today{border-right:2px solid #7c7f12}.calendar-calendar .month-view .full tr td.multi-day,.calendar-calendar .month-view .full tr td.single-day{border-top:0}.calendar-calendar .month-view .full tr td.multi-day,.calendar-calendar .month-view .full tr td.date-box{border-bottom:0}.calendar-calendar .month-view .full .inner .monthview,.calendar-calendar .week-view .full .inner .weekview,.calendar-calendar .day-view .full .inner .dayview{-moz-border-radius:5px;border-radius:5px;width:auto;float:none;display:block;margin:.25em auto;position:relative}.calendar-calendar .month-view .full td.single-day div.monthview,.calendar-calendar .week-view .full td.single-day div.weekview,.calendar-calendar .day-view .full td.single-day div.dayview{background:#ffd8c0;width:auto;padding:0 3px;overflow:hidden}.calendar-calendar .month-view .full td.single-day .calendar-more div.monthview{background:0}.calendar-calendar .day-view td div.dayview{padding:0}.calendar-calendar .month-view .full td.multi-day div.monthview,.calendar-calendar .week-view .full td.multi-day div.weekview,.calendar-calendar .day-view .full td.multi-day div.dayview{background:#74a5d7;height:1.9em;overflow:hidden;margin:0 auto;color:#fff;position:relative}
.calendar-calendar .week-view .full td.multi-day div.weekview{height:3.5em}.calendar-calendar .month-view .full td.multi-day .inner .view-field,.calendar-calendar .month-view .full td.multi-day .inner .view-field a,.calendar-calendar .week-view .full td.multi-day .inner .view-field,.calendar-calendar .week-view .full td.multi-day .inner .view-field a,.calendar-calendar .day-view .full td.multi-day .inner .view-field,.calendar-calendar .day-view .full td.multi-day .inner .view-field a{color:#fff}.calendar-calendar .day-view .full td.multi-day div.dayview,.calendar-calendar .week-view .full td.multi-day div.weekview{margin-bottom:2px}.calendar-calendar .month-view .full td.multi-day .calendar.monthview .view-field{white-space:nowrap;float:left;margin-right:3px}.calendar-calendar .week-view .full td.multi-day .calendar.weekview .view-field{white-space:nowrap;display:inline;margin-right:3px}.calendar-calendar .day-view .full td.multi-day .calendar.weekview .view-field{display:block}.calendar-calendar .month-view .full td.multi-day .calendar.monthview .contents,.calendar-calendar .week-view .full td.multi-day .calendar.weekview .contents{position:absolute;width:3000px;left:5px}.calendar-calendar .day-view td .stripe,.calendar-calendar .month-view .full td .stripe,.calendar-calendar .week-view .full td .stripe{-moz-border-radius:5px 5px 0 0;border-radius:5px 5px 0 0;left:0;top:0;position:absolute;width:100%;height:3px;z-index:2}.calendar-calendar .full td.single-day .continuation,.calendar-calendar .full td.single-day .continues,.calendar-calendar .full td.single-day .cutoff{display:none}.calendar-calendar .month-view .full td.multi-day .inner .monthview .continuation,.calendar-calendar .week-view .full td.multi-day .inner .weekview .continuation{float:left;margin-right:3px;height:1.9em}.calendar-calendar .week-view .full td.multi-day .inner .weekview .continuation{height:2.75em;padding-top:.75em;margin-right:8px}.calendar-calendar .month-view .full td.multi-day .inner .monthview .continues,.calendar-calendar .month-view .full td.multi-day .inner .monthview .cutoff,.calendar-calendar .week-view .full td.multi-day .inner .weekview .continues,.calendar-calendar .week-view .full td.multi-day .inner .weekview .cutoff{position:absolute;right:0!important;right:-1px;width:10px;text-align:left;background:#74a5d7;-moz-border-radius:0 5px 5px 0;border-radius:0 5px 5px 0;height:1.9em;padding-left:6px;z-index:1}.calendar-calendar .week-view .full td.multi-day .inner .weekview .continues,.calendar-calendar .week-view .full td.multi-day .inner .weekview .cutoff{height:2.75em;padding-top:.75em}.calendar-calendar .month-view .full td.multi-day .inner .monthview .cutoff,.calendar-calendar .week-view .full td.multi-day .inner .weekview .cutoff{width:8px;padding-left:0}.calendar-calendar .week-view .full td.multi-day{padding:2px}.calendar-calendar .week-view td.single-day div.calendar{width:100%;padding-left:0;padding-right:0}.calendar-calendar .week-view .full tr.last td.multi-day{border-bottom:1px solid #ccc}.view-content .calendar-calendar{position:relative;margin-top:5px;float:left;width:100%}.view-content .calendar-calendar .links{display:block}.view-content .calendar-calendar ul.links{margin-bottom:3px}.view-content .calendar-calendar ul{position:absolute;top:8px;line-height:inherit;z-index:1}.view-content .calendar-calendar li{float:left;line-height:inherit;margin-left:10px}.view-content .calendar-calendar li a{text-decoration:underline;line-height:inherit}.view-content .calendar-calendar .date-nav{background-color:transparent;border:0;height:30px;height:auto;min-height:30px}.view-content .calendar-calendar .date-prev a,.view-content .calendar-calendar .date-next a{text-decoration:none;color:inherit;font-size:12px}.view-content .calendar-calendar .date-nav a:hover{text-decoration:underline}.view-content .calendar-calendar .date-prev{-moz-border-radius:5px 0 0 5px;border-radius:5px 0 0 5px;background:none repeat scroll 0 0 #dfdfdf;float:none;padding:5px 0;position:absolute;right:60px;text-align:right;top:0;width:auto;z-index:1;font-size:12px}
div.block .view-content .calendar-calendar .date-prev{left:0;right:auto}.view-content .calendar-calendar .date-prev span{margin-left:10px;font-style:bold}.view-content .calendar-calendar .date-heading{position:relative;width:100%;top:0;text-align:center;z-index:0;float:none}.view-content .calendar-calendar .date-heading h3{line-height:30px;font-size:1.7em}.view-content .calendar-calendar .date-next{-moz-border-radius:0 5px 5px 0;border-radius:0 5px 5px 0;background:none repeat scroll 0 0 #dfdfdf;float:none;padding:5px 0;position:absolute;right:0;text-align:right;top:0;width:auto;z-index:1;font-size:12px}.view-content .calendar-calendar .date-next span{margin-right:10px;font-style:bold}.view-content:after{content:".";display:block;height:0;clear:both;visibility:hidden}.attachment .calendar-calendar{margin-top:20px;clear:both}.calendar-calendar th a,.attachment .calendar-calendar th{background-color:transparent;border:0}.attachment .calendar-calendar th.calendar-agenda-hour{color:#777;font-weight:bold;text-align:right}.view-calendar .feed-icon{margin-top:5px}
			
				.field .field-label,.field .field-label-inline,.field .field-label-inline-first{font-weight:bold}.field .field-label-inline,.field .field-label-inline-first{display:inline}.field .field-label-inline{visibility:hidden}.node-form .content-multiple-table td.content-multiple-drag{width:30px;padding-right:0}.node-form .content-multiple-table td.content-multiple-drag a.tabledrag-handle{padding-right:.5em}.node-form .content-add-more .form-submit{margin:0}.node-form .number{display:inline;width:auto}.node-form .text{width:auto}.form-item #autocomplete .reference-autocomplete{white-space:normal}.form-item #autocomplete .reference-autocomplete label{display:inline;font-weight:normal}#content-field-overview-form .advanced-help-link,#content-display-overview-form .advanced-help-link{margin:4px 4px 0 0}#content-field-overview-form .label-group,#content-display-overview-form .label-group,#content-copy-export-form .label-group{font-weight:bold}table#content-field-overview .label-add-new-field,table#content-field-overview .label-add-existing-field,table#content-field-overview .label-add-new-group{float:left}table#content-field-overview tr.content-add-new .tabledrag-changed{display:none}table#content-field-overview tr.content-add-new .description{margin-bottom:0}table#content-field-overview .content-new{font-weight:bold;padding-bottom:.5em}.advanced-help-topic h3,.advanced-help-topic h4,.advanced-help-topic h5,.advanced-help-topic h6{margin:1em 0 .5em 0}.advanced-help-topic dd{margin-bottom:.5em}.advanced-help-topic span.code{background-color:#edf1f3;font-family:"Bitstream Vera Sans Mono",Monaco,"Lucida Console",monospace;font-size:.9em;padding:1px}.advanced-help-topic .content-border{border:1px solid #AAA}.ctools-locked{color:red;border:1px solid red;padding:1em}.ctools-owns-lock{background:#ffd none repeat scroll 0 0;border:1px solid #f0c020;padding:1em}a.ctools-ajaxing,input.ctools-ajaxing,button.ctools-ajaxing,select.ctools-ajaxing{padding-right:18px!important;background:url(/sites/default/modules/ctools/images/status-active.gif) right center no-repeat}div.ctools-ajaxing{float:left;width:18px;background:url(/sites/default/modules/ctools/images/status-active.gif) center center no-repeat}.container-inline-date{width:auto;clear:both;display:inline-block;vertical-align:top;margin-right:.5em}.container-inline-date .form-item{float:none;padding:0;margin:0}.container-inline-date .form-item .form-item{float:left}.container-inline-date .form-item,.container-inline-date .form-item input{width:auto}.container-inline-date .description{clear:both}.container-inline-date .form-item input,.container-inline-date .form-item select,.container-inline-date .form-item option{margin-right:5px}.container-inline-date .date-spacer{margin-left:-5px}.views-right-60 .container-inline-date div{padding:0;margin:0}.container-inline-date .date-timezone .form-item{float:none;width:auto;clear:both}#calendar_div,#calendar_div td,#calendar_div th{margin:0;padding:0}#calendar_div,.calendar_control,.calendar_links,.calendar_header,.calendar{width:185px;border-collapse:separate;margin:0}.calendar td{padding:0}.date-repeat-input{float:left;width:auto;margin-right:5px}.date-repeat-input select{min-width:7em}.date-repeat fieldset{clear:both;float:none}.date-views-filter-wrapper{min-width:250px}.date-views-filter input{float:left!important;margin-right:2px!important;padding:0!important;width:12em;min-width:12em}.date-nav{width:100%}.date-nav div.date-prev{text-align:left;width:24%;float:left}.date-nav div.date-next{text-align:right;width:24%;float:right}.date-nav div.date-heading{text-align:center;width:50%;float:left}.date-nav div.date-heading h3{margin:0;padding:0}.date-clear{float:none;clear:both;display:block}.date-clear-block{float:none;width:auto;clear:both}.date-clear-block:after{content:" ";display:block;height:0;clear:both;visibility:hidden}.date-clear-block{display:inline-block}/*\*/* html .date-clear-block{height:1%}.date-clear-block{display:block}/**/.date-container .date-format-delete{margin-top:1.8em;margin-left:1.5em;float:left}
.date-container .date-format-name{float:left}.date-container .date-format-type{float:left;padding-left:10px}.date-container .select-container{clear:left;float:left}div.date-calendar-day{line-height:1;width:40px;float:left;margin:6px 10px 0 0;background:#f3f3f3;border-top:1px solid #eee;border-left:1px solid #eee;border-right:1px solid #bbb;border-bottom:1px solid #bbb;color:#999;text-align:center;font-family:Georgia,Arial,Verdana,sans}div.date-calendar-day span{display:block;text-align:center}div.date-calendar-day span.month{font-size:.9em;background-color:#b5bebe;color:white;padding:2px;text-transform:uppercase}div.date-calendar-day span.day{font-weight:bold;font-size:2em}div.date-calendar-day span.year{font-size:.9em;padding:2px}#ui-datepicker-div table,#ui-datepicker-div td,#ui-datepicker-div th{margin:0;padding:0}#ui-datepicker-div,#ui-datepicker-div table,.ui-datepicker-div,.ui-datepicker-div table,.ui-datepicker-inline,.ui-datepicker-inline table{font-size:12px!important}.ui-datepicker-div,.ui-datepicker-inline,#ui-datepicker-div{margin:0;padding:0;border:0;outline:0;line-height:1.3;text-decoration:none;font-size:100%;list-style:none;background:#fff;border:2px solid #d3d3d3;font-family:Verdana,Arial,sans-serif;font-size:1.1em;margin:0;padding:2.5em .5em .5em .5em;position:relative;width:15.5em}#ui-datepicker-div{background:#fff;display:none;z-index:9999}.ui-datepicker-inline{display:block;float:left}.ui-datepicker-control{display:none}.ui-datepicker-current{display:none}.ui-datepicker-next,.ui-datepicker-prev{background:#e6e6e6 url(/sites/default/modules/date/date_popup/themes/images/e6e6e6_40x100_textures_02_glass_75.png) 0 50% repeat-x;left:.5em;position:absolute;top:.5em}.ui-datepicker-next{left:14.6em}.ui-datepicker-next:hover,.ui-datepicker-prev:hover{background:#dadada url(/sites/default/modules/date/date_popup/themes/images/dadada_40x100_textures_02_glass_75.png) 0 50% repeat-x}.ui-datepicker-next a,.ui-datepicker-prev a{background:url(/sites/default/modules/date/date_popup/themes/images/888888_7x7_arrow_left.gif) 50% 50% no-repeat;border:1px solid #d3d3d3;cursor:pointer;display:block;font-size:1em;height:1.4em;text-indent:-999999px;width:1.3em}.ui-datepicker-next a{background:url(/sites/default/modules/date/date_popup/themes/images/888888_7x7_arrow_right.gif) 50% 50% no-repeat}.ui-datepicker-prev a:hover{background:url(/sites/default/modules/date/date_popup/themes/images/454545_7x7_arrow_left.gif) 50% 50% no-repeat}.ui-datepicker-next a:hover{background:url(/sites/default/modules/date/date_popup/themes/images/454545_7x7_arrow_right.gif) 50% 50% no-repeat}.ui-datepicker-prev a:active{background:url(/sites/default/modules/date/date_popup/themes/images/222222_7x7_arrow_left.gif) 50% 50% no-repeat}.ui-datepicker-next a:active{background:url(/sites/default/modules/date/date_popup/themes/images/222222_7x7_arrow_right.gif) 50% 50% no-repeat}.ui-datepicker-header select{background:#e6e6e6;border:1px solid #d3d3d3;color:#555;font-size:1em;line-height:1.4em;margin:0!important;padding:0!important;position:absolute;top:.5em}.ui-datepicker-header select.ui-datepicker-new-month{left:2.2em;width:7em}.ui-datepicker-header select.ui-datepicker-new-year{left:9.4em;width:5em}table.ui-datepicker{text-align:right;width:15.5em}table.ui-datepicker td a{color:#555;display:block;padding:.1em .3em .1em 0;text-decoration:none}table.ui-datepicker tbody{border-top:0}table.ui-datepicker tbody td a{background:#e6e6e6 url(/sites/default/modules/date/date_popup/themes/images/e6e6e6_40x100_textures_02_glass_75.png) 0 50% repeat-x;border:1px solid #fff;cursor:pointer}table.ui-datepicker tbody td a:hover{background:#dadada url(/sites/default/modules/date/date_popup/themes/images/dadada_40x100_textures_02_glass_75.png) 0 50% repeat-x;border:1px solid #999;color:#212121}table.ui-datepicker tbody td a:active{background:#fff url(/sites/default/modules/date/date_popup/themes/images/ffffff_40x100_textures_02_glass_65.png) 0 50% repeat-x;border:1px solid #ddd;color:#222}table.ui-datepicker .ui-datepicker-title-row td{color:#222;font-size:.9em;padding:.3em 0;text-align:center;text-transform:uppercase}
table.ui-datepicker .ui-datepicker-title-row td a{color:#222}.timeEntry_control{vertical-align:middle;margin-left:2px}* html .timeEntry_control{margin-top:-4px}.fake-leaf{font-size:8pt;font-style:italic}li.start-collapsed ul{display:none}.filefield-icon{margin:0 2px 0 0}.filefield-element{margin:1em 0;white-space:normal}.filefield-element .widget-preview{float:left;padding:0 10px 0 0;margin:0 10px 0 0;border-width:0 1px 0 0;border-style:solid;border-color:#CCC;max-width:30%}.filefield-element .widget-edit{float:left;max-width:70%}.filefield-element .filefield-preview{width:16em;overflow:hidden}.filefield-element .widget-edit .form-item{margin:0 0 1em 0}.filefield-element input.form-submit,.filefield-element input.form-file{margin:0}.filefield-element input.progress-disabled{float:none;display:inline}.filefield-element div.ahah-progress,.filefield-element div.throbber{display:inline;float:none;padding:1px 13px 2px 3px}.filefield-element div.ahah-progress-bar{display:none;margin-top:4px;width:28em;padding:0}.filefield-element div.ahah-progress-bar div.bar{margin:0}form.fivestar-widget{clear:both;display:block}form.fivestar-widget select,form.fivestar-widget input{margin:0}.fivestar-combo-stars .fivestar-static-form-item{float:left;margin-right:40px}.fivestar-combo-stars .fivestar-form-item{float:left}.fivestar-static-form-item .form-item,.fivestar-form-item .form-item{margin:0}div.fivestar-widget-static{display:block}div.fivestar-widget-static br{clear:left}div.fivestar-widget-static .star{float:left;width:17px;height:15px;overflow:hidden;text-indent:-999em;background:url(/sites/default/modules/fivestar/widgets/default/star.gif) no-repeat 0 0}div.fivestar-widget-static .star span.on{display:block;width:100%;height:100%;background:url(/sites/default/modules/fivestar/widgets/default/star.gif) no-repeat 0 -32px}div.fivestar-widget-static .star span.off{display:block;width:100%;height:100%;background:url(/sites/default/modules/fivestar/widgets/default/star.gif) no-repeat 0 0}div.fivestar-widget{display:block}div.fivestar-widget .cancel,div.fivestar-widget .star{float:left;width:17px;height:15px;overflow:hidden;text-indent:-999em}div.fivestar-widget .cancel,div.fivestar-widget .cancel a{background:url(/sites/default/modules/fivestar/widgets/default/delete.gif) no-repeat 0 -16px;text-decoration:none}div.fivestar-widget .star,div.fivestar-widget .star a{background:url(/sites/default/modules/fivestar/widgets/default/star.gif) no-repeat 0 0;text-decoration:none}div.fivestar-widget .cancel a,div.fivestar-widget .star a{display:block;width:100%;height:100%;background-position:0 0;cursor:pointer}div.fivestar-widget div.on a{background-position:0 -16px}div.fivestar-widget div.hover a,div.rating div a:hover{background-position:0 -32px}form.fivestar-widget div.description{margin-bottom:0}div.fivestar-widget-static .star{background:0;width:16px;height:14px}div.fivestar-widget-static .star span.on{background:url(/sites/default/modules/fivestar/widgets/ueb-stars/stars-s.png) no-repeat 0 -16px}div.fivestar-widget-static .star{background:url(/sites/default/modules/fivestar/widgets/ueb-stars/stars-s.png) no-repeat 0 0}div.fivestar-widget-static .star span.off{background:url(/sites/default/modules/fivestar/widgets/ueb-stars/stars-s.png) no-repeat 0 0}div.fivestar-widget .star{background:url(/sites/default/modules/fivestar/widgets/ueb-stars/star.png)}div.fivestar-widget .star a{background:url(/sites/default/modules/fivestar/widgets/ueb-stars/star.png)}div.fivestar-widget .cancel{background:0}div.fivestar-widget .cancel a{background:url(/sites/default/modules/fivestar/widgets/ueb-stars/cancel.png)}div.fivestar-widget div.hover a,div.rating div a:hover{background-image:url(/sites/default/modules/fivestar/widgets/ueb-stars/star.png)}div.fivestar-widget .cancel,div.fivestar-widget .star{float:left;width:21px;height:20px;overflow:hidden;text-indent:-999em}div.fivestar-widget div.on a{background-position:0 -21px}div.fivestar-widget div.hover a,div.rating div a:hover{background-position:0 -42px}form.fivestar-widget div.description{margin-bottom:0}#lightbox{position:absolute;top:40px;left:0;width:100%;z-index:100;text-align:center;line-height:0}
#lightbox a img{border:0}#outerImageContainer{position:relative;background-color:#fff;width:250px;height:250px;margin:0 auto;min-width:240px;overflow:hidden}#imageContainer,#frameContainer,#modalContainer{padding:10px}#modalContainer{line-height:1em;overflow:auto}#loading{height:25%;width:100%;text-align:center;line-height:0;position:absolute;top:40%;left:45%;*left:0}#hoverNav{position:absolute;top:0;left:0;height:100%;width:100%;z-index:10}#imageContainer>#hoverNav{left:0}#frameHoverNav{z-index:10;margin-left:auto;margin-right:auto;width:20%;position:absolute;bottom:0;height:45px}#imageData>#frameHoverNav{left:0}#hoverNav a,#frameHoverNav a{outline:0}#prevLink,#nextLink{width:49%;height:100%;background:transparent url(/sites/default/modules/lightbox2/images/blank.gif) no-repeat;display:block}#prevLink,#framePrevLink{left:0;float:left}#nextLink,#frameNextLink{right:0;float:right}#prevLink:hover,#prevLink:visited:hover,#prevLink.force_show_nav,#framePrevLink{background:url(/sites/default/modules/lightbox2/images/prev.gif) left 15% no-repeat}#nextLink:hover,#nextLink:visited:hover,#nextLink.force_show_nav,#frameNextLink{background:url(/sites/default/modules/lightbox2/images/next.gif) right 15% no-repeat}#prevLink:hover.force_show_nav,#prevLink:visited:hover.force_show_nav,#framePrevLink:hover,#framePrevLink:visited:hover{background:url(/sites/default/modules/lightbox2/images/prev_hover.gif) left 15% no-repeat}#nextLink:hover.force_show_nav,#nextLink:visited:hover.force_show_nav,#frameNextLink:hover,#frameNextLink:visited:hover{background:url(/sites/default/modules/lightbox2/images/next_hover.gif) right 15% no-repeat}#framePrevLink,#frameNextLink{width:45px;height:45px;display:block;position:absolute;bottom:0}#imageDataContainer{font:10px Verdana,Helvetica,sans-serif;background-color:#fff;margin:0 auto;line-height:1.4em;min-width:240px}#imageData{padding:0 10px}#imageData #imageDetails{width:70%;float:left;text-align:left}#imageData #caption{font-weight:bold}#imageData #numberDisplay{display:block;clear:left;padding-bottom:1.0em}#imageData #lightbox2-node-link-text{display:block;padding-bottom:1.0em}#imageData #bottomNav{height:66px}.lightbox2-alt-layout #imageData #bottomNav,.lightbox2-alt-layout-data #bottomNav{margin-bottom:60px}#lightbox2-overlay{position:absolute;top:0;left:0;z-index:90;width:100%;height:500px;background-color:#000}#overlay_default{opacity:.6}#overlay_macff2{background:transparent url(/sites/default/modules/lightbox2/images/overlay.png) repeat}.clearfix:after{content:".";display:block;height:0;clear:both;visibility:hidden}* html>body .clearfix{display:inline;width:100%}* html .clearfix{/*\*/height:1%;/**/}#bottomNavClose{display:block;background:url(/sites/default/modules/lightbox2/images/close.gif) left no-repeat;margin-top:33px;float:right;padding-top:.7em;height:26px;width:26px}#bottomNavClose:hover{background-position:right}#loadingLink{display:block;background:url(/sites/default/modules/lightbox2/images/loading.gif) no-repeat;width:32px;height:32px}#bottomNavZoom{display:none;background:url(/sites/default/modules/lightbox2/images/expand.gif) no-repeat;width:34px;height:34px;position:relative;left:30px;float:right}#bottomNavZoomOut{display:none;background:url(/sites/default/modules/lightbox2/images/contract.gif) no-repeat;width:34px;height:34px;position:relative;left:30px;float:right}#lightshowPlay{margin-top:42px;float:right;margin-right:5px;margin-bottom:1px;height:20px;width:20px;background:url(/sites/default/modules/lightbox2/images/play.png) no-repeat}#lightshowPause{margin-top:42px;float:right;margin-right:5px;margin-bottom:1px;height:20px;width:20px;background:url(/sites/default/modules/lightbox2/images/pause.png) no-repeat}.lightbox2-alt-layout-data #bottomNavClose,.lightbox2-alt-layout #bottomNavClose{margin-top:93px}.lightbox2-alt-layout-data #bottomNavZoom,.lightbox2-alt-layout-data #bottomNavZoomOut,.lightbox2-alt-layout #bottomNavZoom,.lightbox2-alt-layout #bottomNavZoomOut{margin-top:93px}
.lightbox2-alt-layout-data #lightshowPlay,.lightbox2-alt-layout-data #lightshowPause,.lightbox2-alt-layout #lightshowPlay,.lightbox2-alt-layout #lightshowPause{margin-top:102px}.lightbox_hide_image{display:none}#lightboxImage{-ms-interpolation-mode:bicubic}#edit-mollom-captcha{display:block}.dblog-event pre,#simpletest-result-form table td{white-space:pre-wrap}#forum .description{font-size:.9em;margin:.5em}#forum td.created,#forum td.posts,#forum td.topics,#forum td.last-reply,#forum td.replies,#forum td.pager{white-space:nowrap}#forum td.posts,#forum td.topics,#forum td.replies,#forum td.pager{text-align:center}#forum tr td.forum{padding-left:25px;background-position:2px 2px;background-image:url(/misc/forum-default.png);background-repeat:no-repeat}#forum tr.new-topics td.forum{background-image:url(/misc/forum-new.png)}#forum div.indent{margin-left:20px}.forum-topic-navigation{padding:1em 0 0 3em;border-top:1px solid #888;border-bottom:1px solid #888;text-align:center;padding:.5em}.forum-topic-navigation .topic-previous{text-align:right;float:left;width:46%}.forum-topic-navigation .topic-next{text-align:left;float:right;width:46%}div.fieldgroup{margin:.5em 0 1em 0}div.fieldgroup .content{padding-left:1em}.views-exposed-form .views-exposed-widget{float:left;padding:.5em 1em 0 0}.views-exposed-form .views-exposed-widget .form-submit{margin-top:1.6em}.views-exposed-form .form-item,.views-exposed-form .form-submit{margin-top:0;margin-bottom:0}.views-exposed-form label{font-weight:bold}.views-exposed-widgets{margin-bottom:.5em}html.js a.views-throbbing,html.js span.views-throbbing{background:url(/sites/default/modules/views/images/status-active.gif) no-repeat right center;padding-right:18px}div.view div.views-admin-links{font-size:xx-small;margin-right:1em;margin-top:1em}.block div.view div.views-admin-links{margin-top:0}div.view div.views-admin-links ul{margin:0;padding:0}div.view div.views-admin-links li{margin:0;padding:0 0 2px 0;z-index:201}div.view div.views-admin-links li a{padding:0;margin:0;color:#ccc}div.view div.views-admin-links li a:before{content:"["}div.view div.views-admin-links li a:after{content:"]"}div.view div.views-admin-links-hover a,div.view div.views-admin-links:hover a{color:#000}div.view div.views-admin-links-hover,div.view div.views-admin-links:hover{background:transparent}div.view div.views-hide{display:none}div.view div.views-hide-hover,div.view:hover div.views-hide{display:block;position:absolute;z-index:200}div.view:hover div.views-hide{margin-top:-1.5em}.views-view-grid tbody{border-top:0}
			
			input.webform-calendar{display:none;padding:3px;vertical-align:top}html.js input.webform-calendar{display:inline}.webform-container-inline label{display:inline;margin-right:1em}.webform-container-inline div,.webform-container-inline div.form-item{display:inline}.webform-container-inline div.description{display:block}
			
			@charset "utf-8";h3{font-size:1.2em;font-weight:bold;margin-bottom:5px}#grueso #node-60 em{padding-left:10px;color:#88ab0c}#grueso #node-60.node p{line-height:1em}html{height:100%;overflow-x:auto;overflow-y:scroll}body{height:100%;margin:0;padding:0;font-family:'PTSansRegular',sans-serif;font-size:1em;line-height:1.3em;color:#3e4729;background-color:#eff2dc;background-repeat:no-repeat;background-position:top right;background-attachment:fixed}body.page-medios{background-color:#FFF}#grueso h2.js-hide{display:none}body.cuerpo_sin_promo #grueso{width:720px}body.cuerpo_con_promo #grueso{width:500px}body.cuerpo_sin_promo.cuerpo_sin_menu #grueso{width:960px;margin:0}a{text-decoration:none;color:#88ab0c;outline:0}a:visited{color:#88ab0c}a:hover{color:#eb8906}a.placeholder{cursor:pointer;cursor:hand}a.logo_externo{-webkit-transition:background .2s ease-in-out;-moz-transition:background .2s ease-in-out;-o-transition:background .2s ease-in-out;transition:background .2s ease-in-out;margin-left:15px}.node{font-size:.9em;line-height:1.2em}#encabezado>div>a{display:block;width:172px}.form-item label{clear:both}img{-ms-interpolation-mode:bicubic;display:block}#admin-menu img{display:inline}.item-list ol li{list-style:decimal}.views-admin-links li{float:left;list-style:none}#correo{font-size:.8em;margin-left:-15px}.webform .webform-component-fieldset{margin-top:30px}.webform .webform-component-fieldset legend{color:#df7e00;font-size:1.3em;margin-bottom:10px}.webform-component-markup{margin-bottom:20px;margin-top:20px}#encabezado{background-color:#3e4729;width:100%;height:80px;position:fixed;z-index:100;border-bottom:7px solid #88ab0c}body.pages-medios #encabezado{background-color:#3e4729;width:100%;height:80px;position:fixed;z-index:2;border-bottom:7px solid #88ab0c}#logo{display:block;float:left}#logo img{float:right}.cajon{width:960px;position:relative;left:50%;margin-left:-480px;clear:both}.cajon.grueso{padding-top:87px}#herramientas{width:720px;height:25px;z-index:99;padding-left:240px}.front #herramientas{margin-top:-80px}#micrositios{width:720px;height:35px;z-index:98;margin-top:20px;padding-left:237px}#menu{width:240px;position:relative;margin-top:20px}.front #destacado{margin-left:240px;overflow:hidden;width:720px}.not-front #destacado{overflow:hidden;width:720px}#grueso{width:720px;float:left}.cuerpo_con_menu .contenedor{width:auto;margin:0;padding:0 0 0 240px}.cuerpo_sin_menu .contenedor{padding:0;margin:0}#seccion1,#seccion2,#seccion3,#seccion4{width:500px;float:left;margin:0 0 30px 240px}#promocional,#promocional1,#promocional2,#promocional3,#promocional4{width:200px;float:left;margin-left:20px}#pie{width:100%;height:25px;font-size:.7em;font-family:'PTSansRegular',sans-serif;color:#fff;clear:both;bottom:0}table.context-admin td.tag{font-weight:bold}#sticky_footer-body{height:auto;min-height:100%;margin:0 auto -25px}#stycky_footer-footer{height:25px;clear:both}#pie p{width:100%;height:25px;margin:0 0 -25px;padding:0}#block-block-185{position:relative}#canales{position:fixed;width:34px;height:144px;right:50%;bottom:5px;margin-right:-520px}body.cuerpo_sin_promo.cuerpo_sin_menu.not-front #canales{margin-left:965px}#canales a{margin-bottom:2px;width:34px;height:34px;display:block;cursor:pointer;-webkit-transition:background-color .2s ease-in-out;-moz-transition:background-color .2s ease-in-out;-o-transition:background-color .2s ease-in-out;transition:background-color .2s ease-in-out;background-color:#dde1bf}#canal-facebook{background:url(/sites/default/themes/ueb/images/canales.png) 0 0 no-repeat}#canal-facebook:hover{background:url(/sites/default/themes/ueb/images/canales.png) 0 -34px no-repeat;background-color:#6c88b0}#canal-twitter{background:url(/sites/default/themes/ueb/images/canales.png) -34px 0 no-repeat}#canal-twitter:hover{background:url(/sites/default/themes/ueb/images/canales.png) -34px -34px no-repeat;background-color:#73c3c4}#canal-youtube{background:url(/sites/default/themes/ueb/images/canales.png) -102px 0 no-repeat}#canal-youtube:hover{background:url(/sites/default/themes/ueb/images/canales.png) -102px -34px no-repeat;background-color:#db6564}
#canal-issuu{background:url(/sites/default/themes/ueb/images/canales.png) -68px 0 no-repeat}#canal-issuu:hover{background:url(/sites/default/themes/ueb/images/canales.png) -68px -34px no-repeat;background-color:#e49f45}.front #grueso div#block-block-185{border:0;margin-bottom:0}#herramientas .block-user{float:right;margin-right:20px;padding:15px 5px 5px}#herramientas #edit-name-wrapper,#herramientas #edit-name-1-wrapper,#herramientas #edit-pass-wrapper{margin:0;float:left;height:18px}#herramientas #edit-name-wrapper input,#herramientas #edit-name-1-wrapper input,#herramientas #edit-pass-wrapper input{border-top:1px solid #1a1e11;border-right:1px solid #272d1a;border-bottom:1px solid #6a7b2d;border-left:1px solid #54612b;height:17px;padding:0;margin:0 1px 0 0;font-family:'PTSansRegular',sans-serif;display:block;color:#a1c425;background-color:#2f381d}#herramientas #edit-name-1-wrapper input,#herramientas #edit-name-wrapper input{-moz-border-radius-topleft:5px;-moz-border-radius-bottomleft:5px;-webkit-border-top-left-radius:5px;-webkit-border-bottom-left-radius:5px}#herramientas #user-login-form>div>input.form-submit{color:#88ab0c;border-top:1px solid #1a1e11;border-right:1px solid #272d1a;border-bottom:1px solid #6a7b2d;border-left:1px solid #54612b;height:19px;font-family:'PTSansRegular',sans-serif;float:left;cursor:pointer;background-color:#2f381d}#herramientas #user-login-form:hover #edit-name-wrapper>input,#herramientas #user-login-form:hover #edit-name-1-wrapper>input,#herramientas #user-login-form:hover #edit-pass-wrapper>input{background-color:#3e4729}#herramientas #user-login-form:hover div>input.form-submit{background:url(/sites/default/themes/ueb/images/herramientas-boton-fondo.gif) repeat-x #88ab0c;color:#fff}#herramientas #user-login-form:hover div>input.form-submit:hover{background:url(/sites/default/themes/ueb/images/herramientas-boton-fondo-hover.gif) repeat-x #88ab0c;color:#fff}#herramientas .clear-block.block.block-user h2{display:none}#herramientas #edit-name-wrapper label,#herramientas #edit-name-1-wrapper label{display:none}#herramientas #edit-pass-wrapper label,#herramientas #user-login-form ul{display:none}#herramientas #block-block-43{margin-right:20px;padding:15px 5px 5px;color:#88ab0c}#herramientas #block-block-43 form div:first-child{display:none}#herramientas #block-locale-0{float:right;margin-right:20px;padding:15px 5px 5px;color:#88ab0c;font-size:.8em}#herramientas #block-locale-0 h2{display:none}#herramientas #block-locale-0 li{float:right;position:relative;list-style:none}#herramientas #block-locale-0 li.active-trail a{background:url(/sites/default/themes/ueb/images/herramientas-boton-fondo-hover.gif) repeat-x #88ab0c;color:#fff}#herramientas #block-locale-0 li a{width:auto;color:#88ab0c;font-family:'PTSansRegular',sans-serif;float:left;cursor:pointer;background-color:#2f381d;padding:0 5px;margin-left:2px;height:22px}#herramientas #block-locale-0:hover li a:hover{background:#88ab0c;color:#fff}#herramientas .block-search{float:right;margin-top:15px}#herramientas .block-search .form-item{float:left;margin:0}#herramientas .block-search #edit-search-block-form-1{width:136px;border:0;padding:3px 0 0 5px;margin:0;font-family:'PTSansRegular',sans-serif;display:block;color:#3e4729;background-color:#535e39;font-size:.8em;height:19px}#salir,#herramientas .block-search input.form-submit{width:auto;color:#88ab0c;border:0;font-family:'PTSansRegular',sans-serif;float:left;cursor:pointer;background-color:#2f381d;height:22px}#herramientas .block-search:hover #edit-search-block-form-1{background-color:#eff2dc}#salir:hover,#herramientas .block-search:hover input.form-submit{color:#fff;background:#88ab0c}#salir:hover{color:#fff;background:#88ab0c}#herramientas .block-search:hover input.form-submit:hover{color:#fff;background:#df7e00}#herramientas .block-search label{display:none}#micrositios .block-menu ul.menu{padding:0}#micrositios .block-menu ul.menu li{float:left;list-style:none;margin:0;padding:0 3px}#micrositios .block-menu ul.menu li a{float:left;display:block;height:37px;margin-top:5px;padding:0 7px;color:#fff;text-transform:uppercase;line-height:30px;font-size:.8em}
#micrositios .block-menu ul.menu li a:hover{border-bottom:7px solid #fff;height:30px;color:#fff}#micrositios .block-menu ul.menu li a.active{color:#88ab0c;background-color:#fff}#aviso{width:208px;display:block;font-size:.9em;line-height:1em;padding:5px;border-top:solid 1px #dae0b8;border-right:solid 1px #dae0b8;border-bottom:solid 1px #fff;border-left:solid 1px #dae0b8;background-color:#e8ecce}#aviso:hover{padding:4px 5px 6px 5px;border-top:solid 1px #fff;border-right:solid 1px #fff;border-bottom:solid 1px #fff;border-left:solid 1px #fff;background-color:#f5f7ea}#aviso span{display:block;margin:0;padding:3px;background-color:#ecefd5;border-top:solid 1px #fff;border-right:solid 1px #dae0b8;border-bottom:solid 1px #dae0b8;border-left:solid 1px #dae0b8}#aviso:hover span{border-top:solid 1px #fff;border-right:solid 1px #fff;border-bottom:solid 1px #fff;border-left:solid 1px #fff;background-color:#fff}#aviso:hover span a{color:#88ab0c}#aviso:hover span a:hover{color:#df7e00}#promo_izq{width:240px}#promo_izq .promo{width:auto;border-right:0}#promo_izq .promo a{border-right:0}.promo{margin-bottom:5px;text-align:right;display:block;font-size:.9em;border:1px solid #fff;width:198px}#promocional_programas p{margin:0}.micropromo{width:95px;margin-bottom:5px;border:1px solid #fff;font-size:.8em;text-align:right;line-height:1em}.micropromo a{color:#70764c;display:block;padding:3px 5px 7px 5px;border:solid 1px #c6ce94;background-color:#dde1bf;-webkit-transition:background-color .15s ease-in-out;-moz-transition:background-color .15s ease-in-out;-o-transition:background-color .15s ease-in-out;transition:background-color .15s ease-in-out}.micropromo a:hover{background-color:#eff2dc;color:#596221}.promo a{-webkit-transition:background-color .2s ease-in-out;-moz-transition:background-color .2s ease-in-out;-o-transition:background-color .2s ease-in-out;transition:background-color .2s ease-in-out}.promo a.promo_permanente{color:#70764c;display:block;padding:10px;line-height:1em;border:solid 1px #c6ce94;background-color:#dde1bf}.promo a.promo_permanente:hover{background-color:#eff2dc;color:#596221}.promo a.promo_anaranjado{color:#fff;display:block;padding:10px;line-height:1em;border:solid 1px #d8711b;background-color:#eb8906}.promo a.promo_anaranjado:hover{border:solid 5px #f7c727;background-color:#f0a00e;padding:6px;text-shadow:#d8711b 0 1px 2px}.promo a.promo_verde{color:#fff;display:block;padding:10px;line-height:1em;border:solid 1px #77931d;background-color:#88ab0c}.promo a.promo_verde:hover{border:solid 5px #c6d93f;background-color:#9fbd1a;padding:6px;text-shadow:#88ab0c 0 1px 2px}.promo a.promo_morado{color:#fff;display:block;padding:10px;line-height:1em;border:solid 1px #7d65b2;background-color:#8567cf}.promo a.promo_morado:hover{border:solid 5px #cdbff1;background-color:#a28bdd;padding:6px;text-shadow:#704daf 0 1px 2px}.promo a.promo_violeta{color:#fff;display:block;padding:10px;line-height:1em;border:solid 1px #9565b2;background-color:#a567cf}.promo a.promo_violeta:hover{border:solid 5px #debff1;background-color:#bc8bdd;padding:6px;text-shadow:#704daf 0 1px 2px}.promo a.promo_fucsia{color:#fff;display:block;padding:10px;line-height:1em;border:solid 1px #a1365f;background-color:#c33b74}.promo a.promo_fucsia:hover{border:solid 5px #e58db5;background-color:#d0558b;padding:6px;text-shadow:#704daf 0 1px 2px}.promo a.promo_amarillo{color:#fff;display:block;padding:10px;line-height:1em;border:solid 1px #afa714;background-color:#cabd00}.promo a.promo_amarillo:hover{border:solid 5px #e7e37d;background-color:#d9d12d;padding:6px}.promo a.promo_azul{color:#fff;display:block;padding:10px;line-height:1em;border:solid 1px #368ba1;background-color:#3bacc3}.promo a.promo_azul:hover{border:solid 5px #8dd9e5;background-color:#55bed0;padding:6px}.promo a.promo_cyan{color:#fff;display:block;padding:10px;line-height:1em;border:solid 1px #349a96;background-color:#39bcb2}.promo a.promo_cyan:hover{border:solid 5px #89ded5;background-color:#52c9bc;padding:6px}.promo a.promo_verdeinstitucional{color:#fff;display:block;padding:10px;line-height:1em;border:solid 1px #333925;background-color:#3e4729}
.promo a.promo_verdeinstitucional:hover{border:solid 5px #607729;background-color:#50602a;padding:6px}.promo a.promo_denim{color:#fff;display:block;padding:10px;line-height:1em;border:solid 1px #3f4e86;background-color:#6475b8}.promo a.promo_denim:hover{border:solid 5px #a1b1ef;background-color:#7c8fdf;padding:6px}.promo a.promo_gris{color:#fff;display:block;padding:10px;line-height:1em;border:solid 1px #424242;background-color:#848484}.promo a.promo_gris:hover{border:solid 5px #bdbdbd;background-color:#a4a4a4;padding:6px}.promo a.promo_rojoartesplasticas{color:#fff;display:block;padding:10px;line-height:1em;border:solid 1px #9c322a;background-color:#bf2e25}.promo a.promo_rojoartesplasticas:hover{border:solid 5px #f2766d;background-color:#e0493e;padding:6px}.promo a.promo_lea{display:block;border:solid 1px #2b1f2b;background-color:#462e46;height:117px}.promo a.promo_lea:hover{border:solid 5px #462e46;background-color:#5d345d;padding:6px;height:97px}.promo a.promo_lea:hover img{margin-top:-10px;margin-left:-10px}.promo a.promo_facebook{color:#fff;display:block;padding:10px;line-height:1em;border:solid 1px #2b4270;background-color:#3b5998}.promo a.promo_facebook:hover{border:solid 5px #819ac7;background-color:#627aad;padding:6px}#promo_izq{position:relative;display:block}#promo_izq .content .promo{float:right}a.boton_tarjeton{display:block;width:45%;background-color:#dde1bf;border:1px solid #c6ce94;float:left;margin:0;padding:10px;text-align:right;color:#70764c;text-decoration:none;line-height:1.1em;vertical-align:middle;font-size:1.2em;font-weight:bold}a.boton_tarjeton:hover{background-color:#e7eacf;border:4px solid #f3f5e7;padding:7px}a.boton_tarjeton p{font-weight:normal}div.tarjeton{font-weight:bold;font-size:1.1em}#menu #block-block-187{background-color:#FF0;padding:10px 10px 0;border:1px solid #ced2af;line-height:1em}#menu #block-block-187 a{display:inline-block;margin-bottom:10px}#block-block-110{width:100%}.promo a#boton_chat{color:#fff;display:block;padding:10px;line-height:1em;border-top:solid 2px #b55b76;border-right:solid 1px #b55b76;border-bottom:solid 2px #fff;border-left:solid 1px #b55b76;background-color:#cb7584}.promo a#boton_chat:hover{border:solid 5px #e6bec3;background-color:#db93a0;padding:6px 6px 8px 6px;text-shadow:#cb7584 0 1px 2px}.minipromo{display:block;width:93px;float:left;height:93px;background-color:#fff;margin-bottom:10px;border-top:0;border-right:solid 1px #e3e8cc;border-bottom:solid 2px #e3e8cc;border-left:solid 1px #e3e8cc}#promocional div div p{margin:0;padding:0}.front #promocional1 .block-block:nth-child(even),.front #promocional .block-block:nth-child(even),.front #promocional .block-views:nth-child(even){float:left;clear:left}body.page-medios #promocional1 .block-block:nth-child(odd),#promocional .block-block:nth-child(odd),#promocional .block-views:nth-child(odd){float:none;clear:none}.front #promocional1 .block-block:nth-child(odd),.front #promocional .block-block:nth-child(odd),.front #promocional .block-views:nth-child(odd){float:right;clear:right}body.page-medios #promocional1 .block-block:nth-child(odd),#promocional .block-block:nth-child(odd),#promocional .block-views:nth-child(odd){clear:none}.promo-info{margin-top:8px;margin-bottom:8px}#block-block-56 .promo-info,#block-block-113 .promo-info,#block-block-121 .promo-info,#block-block-122 .promo-info{margin-top:0;padding:10px;background-color:#fff;width:180px}#block-block-56 ul,#block-block-113 ul,#block-block-121 ul,#block-block-122 ul{font-size:.9em}#block-block-88{clear:both;width:100%;border-top:1px solid #d6dcb1;margin-top:15px}#block-block-88 p{border-top:1px solid #fff}#block-block-139{clear:both;width:100%}#block-block-139 p div{margin-top:15px}.promo-info h5{border-bottom:3px solid #88ab0c;font-family:'Georgia';padding:0 0 5px;line-height:1em;font-size:1.2em;margin:0}.promo-info span{display:block;font-size:.8em;line-height:1.2em;margin-top:5px}.promo-info span a{letter-spacing:-0.05em}.promo-info a.mas_info{display:block;font-size:.8em;margin-top:10px;text-align:right}.promo-enlace{padding-right:20px;margin-top:20px;width:200px}
.promo-enlace h5{border-bottom:3px solid #88ab0c;font-family:'Georgia';padding:0 0 5px;line-height:1em;font-size:1.2em;margin:0}.promo-enlace p{margin:0;padding:0}.promo-enlace>p.promo-enlace{font-size:.8em;padding-left:10px}.promo-enlace>p a{font-size:.9em;font-style:italic;margin-top:10px;line-height:.9em;display:block;margin:0;padding:0}#block-views-medios_comentarios-block_1 .field-content{font-size:.8em;line-height:1.2em;display:block;margin-left:5px}body.page-medios .block-views#block-views-semanario_tags-block_1 .view-content li a{display:inline}#block-views-inicio_eventos-block_3 img{float:left;margin-right:5px}#block-views-inicio_eventos-block_3 .views-field-title{line-height:1.2em;font-size:.8em;margin-bottom:5px}#block-views-inicio_eventos-block_3 .views-field-title a{padding-left:45px;display:block;min-height:50px;max-height:inherit}#block-views-inicio_eventos-block_3 .content{margin-left:10px;padding:0}body.page-medios #promocional{margin-top:10px}body.page-medios #promocional .block .content{margin-top:-15px}#block-views-semanario_tags-block_1 .views-summary li{display:block;text-style:none;text-decoration:none;margin-left:-5px;font-size:.8em;line-height:1em;display:block}#menu #semanario_ueb a{width:195px;height:50px;text-align:right;font-family:'PTSansItalic';font-size:1.5em;display:block;padding:10px;color:#eff2dc;background-color:#3e4729;z-index:100;margin-top:25px;margin-left:10px;letter-spacing:.1em}#menu #semanario_ueb{position:relative}body.page-taxonomy #menu #block-menu-menu-medios{margin-top:-80px}#menu #semanario_ueb a:hover{color:#fff;color:#df7e00}#semanario_ueb a{height:24px;text-align:center;font-family:Georgia,"Times New Roman",Times,serif,'PTSansRegular';font-size:1.5em;line-height:24px;display:block;padding:5px;color:#eff2dc;background-color:#cad0a6;margin-bottom:0}#semanario_ueb a:hover{height:24px;background-color:#c3da50;color:#fff;padding:0 1px 2px 1px}#block-menu-menu-medios #menu{background-color:none}#menu #block-menu-menu-medios{border:0;margin-bottom:40px}#menu #block-menu-menu-medios>.content>.menu{margin-top:80px}#menu #block-menu-menu-medios>.content>.menu ul{background-color:#none;border-bottom:solid 0 #d6e38f}#menu #block-menu-menu-medios ul li{background-color:#none}#menu #block-menu-menu-medios ul li a{background-color:#none;border-bottom:1px solid #dfe1cb;border-right:1px solid #dfe1cb;border-width:thin;padding:7px;display:inline-block;margin-right:-6px}#menu #block-menu-menu-medios.block{border:0;margin-top:-90px}body.page-taxonomy #menu #block-menu-menu-medios.block{background-color:#none}body.page-medios #promocional h2{text-align:center;height:40px;background-image:url(/sites/default/themes/ueb/images/pager-fondo.png);border-left:1px solid #dfe1cb;border-right:1px solid #dfe1cb;padding-top:10px;color:#3e4729}body.page-medios #promocional .block-views:hover h2{background-color:#fc0;background-image:url(/sites/default/themes/ueb/images/pager-fondo_hover.png);color:#df7e00}body.page-medios #promocional #menu .block{margin-bottom:00px;padding:5px;text-align:right}body.page-medios #menu .block{padding:5px;margin-top:-30px;margin-bottom:40px;background-color:none;border-top:solid 10px #fff;border-bottom:solid 10px #fff;text-align:right}#block-views-medios_comentarios-block_1{margin-top:20px}#block-views-semanario_mas_visitados-block_1 img{float:left;margin-right:5px;margin-top:5px}#block-views-semanario_mas_visitados-block_1 .views-field-title{line-height:1.2em;font-size:.8em}#block-views-semanario_mas_visitados-block_1 .views-field-title a{padding-left:45px;display:block;min-height:50PX;max-height:AUTO}#block-views-semanario_mas_visitados-block_1 .content{margin-left:10px}#block-views-semanario_mas_visitados-block_1 .view_content{padding-left:20px}.view .node.ddblock_news_item .field-field-image img{float:left;margin-left:10px}.node.ddblock_news_item .field-field-image a img{margin-right:20px}#edit-comment-wrapper #edit-comment{height:100px}#comments #comment-form .collapsible{display:none}
#menu h2{text-align:right;padding:5px;font-size:1em;line-height:1em;font-weight:normal;background-color:#ced2af;display:inline-block;margin-top:0}.page-medios #menu .block{padding:5px;margin-bottom:40px;text-align:right}#menu .block{margin-bottom:20px;text-align:right}#menu #block-block-146{border-bottom:0;padding:5px;text-align:right}#menu .block-block,#menu .block-views{border-right:1px solid #dae0b8;margin:0 15px 15px 0}#menu .block-block .content{padding:0 10px 10px 0}#menu #block-block-37{padding:0;margin-bottom:20px;background:#FFF;border-top:0;border-bottom:0}#block-block-37 .content p{display:block;float:left;background-color:#C36}#menu ul{line-height:1em;text-align:right;padding:0}#menu ul li{list-style:none;list-style-image:none;margin:0;padding:0;display:block}#menu ul li.active-trail a.active{background-color:#eb8906;color:#FFF}#menu ul li a{line-height:.8em;display:inline-block;margin-bottom:2px;padding:6px 15px;color:#6a7528;-webkit-transition:background-color .2s ease-in-out,color .2s ease-in-out;-moz-transition:background-color .2s ease-in-out,color .2s ease-in-out;-o-transition:background-color .2s ease-in-out,color .2s ease-in-out;transition:background-color .2s ease-in-out,color .2s ease-in-out}#menu ul li a:hover{color:#FFF;background-color:#88ab0c}#menu ul li ul li a{line-height:.8em;display:inline-block;margin-bottom:2px;padding-right:30px;color:#6a7528}#menu ul li ul{margin-bottom:10px}body.page-educacion-continuada #menu .block{background:0;border:0}body.page-educacion-continuada #menu ul li a:hover{background:url(/sites/default/themes/ueb/images/fondo-menu-activo.gif) repeat-y right #eb8906;color:#fff}#menu .content>.menu>li>a{text-transform:uppercase}#menu .content>.menu>li.expanded>a{color:#fff;background-color:#df7e00;display:inline-block}#menu .content>.menu>li>.menu>li.active-trail>a,#menu .content>.menu>li>.menu>li.expanded>a{color:#fff;background-color:#df7e00}#menu .content>.menu>li>.menu>li>.menu>li>a.active{color:#fff;background-color:#df7e00}#menu .content>.menu>li>.menu>li>.menu>li>a{padding-right:55px}#menu .block-views{padding:5px;margin-bottom:50px;border-top:solid 10px #ced2af;border-bottom:solid 10px #ced2af;font-size:.8em;line-height:1em}#menu .block-views .views-row{border-bottom:solid 2px #ced2af;padding:10px 0}#menu .block-views .views-row-last{border-bottom:0}#menu .block-views p{margin:0}#menu .block-views .views-field-title{font-weight:bold}.node,#grueso .help,#grueso .admin-list,#grueso .profile,#grueso form{padding:20px;margin-bottom:10px;background-color:#fff;border:1px solid #fff}.gmap-popup .node{padding:0;margin-bottom:0;background-color:#fff;border:0}.gmap-popup{max-height:300px;max-width:500px}.gmap-popup h3.location-locations-header,.gmap-popup .location-locations-wrapper{display:none}.node-unpublished{background-color:#fae9bf}#grueso form#views-ui-list-views-form{overflow:hidden}.view td.node-unpublished{background-color:#fae9bf}#grueso table.views-entry.view-enabled,#grueso table.views-entry.view-disabled{display:block;margin-bottom:5px;padding:10px;background-color:#fff;border-top:0;border-right:solid 1px #e3e8cc;border-bottom:solid 2px #e3e8cc;border-left:solid 1px #e3e8cc}#grueso table.views-entry.view-enabled tbody tr:first-child td{margin:0;padding:10px;background-color:#fff}#grueso table.views-entry.view-enabled tbody tr:last-child td{margin:0;padding:10px;background-color:#fff}#grueso table.views-entry.view-disabled tbody tr:first-child td{margin:0;padding:10px;border-top:solid 2px #e3e8cc;border-right:solid 1px #e3e8cc;border-bottom:0;border-left:solid 1px #e3e8cc;color:#bcc692;background-color:#eff2dc}#grueso table.views-entry.view-disabled:hover tbody tr:first-child td{background-color:#dde3c8;border-top:solid 2px #dde3c8;border-right:solid 1px #dde3c8;border-bottom:0;border-left:solid 1px #dde3c8;color:#596221}#grueso table.views-entry.view-disabled tbody tr:last-child td{margin:0;padding:10px;background-color:#eff2dc;border-top:solid 2px #e3e8cc;border-right:solid 1px #e3e8cc;border-bottom:0;border-left:solid 1px #e3e8cc;color:#bcc692}#grueso table.views-entry.view-disabled:hover tbody tr:last-child td{margin:0;padding:10px;background-color:#eff2dc;border-top:solid 2px #e3e8cc;border-right:solid 1px #e3e8cc;border-bottom:0;border-left:solid 1px #e3e8cc;color:#596221}
#grueso table.views-entry.view-disabled tbody tr:first-child td:last-child a{width:inherit;padding:5px;color:#596221}#grueso table.views-entry.view-disabled:hover tbody tr:first-child td:last-child a{background-color:#88ab0c;color:#fff}#grueso table.views-entry.view-disabled:hover tbody tr:first-child td:last-child a:hover{background-color:#eb8906;color:#fff}#edit-order-wrapper{clear:none}.view-content>div.views-row{background-color:#fff;margin-bottom:10px}#grueso .field.field-type-text.field-field-pager-item-text,#grueso .field.field-type-filefield.field-field-image .field-label{display:none}#grueso h2{font-size:1.5em;margin:0}#grueso h2{display:block;height:100%;color:#000;line-height:1em;border-bottom:solid 2px #88ab0c;padding-bottom:5px}#grueso h2 a:hover{color:#eb8906;text-decoration:none}#grueso .timestamp{text-align:right;margin-bottom:20px}#grueso .timestamp span{text-transform:lowercase}#grueso .node .content p{margin:0 0 10px 0}.field-field-programa-descripcion-movil{display:none}#grueso .node .clear-block .links ul.links{padding:0;color:#f60}li.node_read_more{float:right}#grueso .node-form .admin{background-color:#fff;clear:both}#grueso>table{background-color:#fff}#grueso .form-text,#grueso #edit-comment,#grueso .form-textarea{background:url(/sites/default/themes/ueb/images/campo_fondo.gif) repeat-x #eff2dc;font-family:'PTSansRegular';font-size:1em;width:99%;border-top:solid 2px #e3e8cc;border-right:solid 1px #e3e8cc;border-bottom:0;border-left:solid 1px #e3e8cc}#grueso .form-text text{width:auto}#grueso .form-item .description{font-family:"PTSansItalic";font-size:.85em;line-height:1em;margin-top:3px}#grueso select{font-family:"PTSansItalic";border:solid 1px #e8eee3;background-color:#f5f7f2;width:100%}#grueso .teaser-checkbox{overflow:hidden;padding-top:0;vertical-align:middle}#grueso #edit-teaser-include-wrapper{margin-top:5px;padding:0;height:25px;border:0;background:url(/sites/default/themes/ueb/images/campo-de-busqueda.gif);border-left:1px solid #c6ccb3;font-size:.9em;line-height:25px}#grueso #edit-teaser-include-wrapper .edit-teaser-include{margin:0;padding:0}#grueso .teaser-button-wrapper{padding:0}#grueso input#edit-teaser-include{margin:0;padding:0}#grueso .teaser-checkbox label.option{margin:0;display:block;padding:0 5px}.resizable-textarea .grippie{border-color:#e3e8cc;border-style:solid;border-width:0 1px 1px;cursor:s-resize;height:9px;overflow:hidden;background:url(/sites/default/themes/ueb/images/ampliar_campo.gif) no-repeat center #e3e8cc}#grueso input.form-submit,#grueso input.teaser-button,#menu .clear-block .form-submit,.login-servicios{font-family:"PTSansRegular";line-height:25px;text-align:center;margin:5px 0 0 0;padding:3px 3px 1px 3px;height:25px;border-top:1px solid #dde2bc;border-right:1px solid #dde2bc;border-bottom:1px solid #dde2bc;border-left:1px solid #dde2bc;-moz-border-radius:5px;border-bottom-radius:5px}#grueso #edit-delete{float:right}#grueso input.form-submit:hover,#grueso input.teaser-button:hover,#menu .clear-block .form-submit,.login-servicios:hover{border-top:1px solid #fff}#grueso input.form-submit:active,#grueso input.teaser-button:active{}.meta .terms li a,.view-u-medios-externos .views-field-tid a{display:inline-block;font-family:"PTSansRegular";line-height:25px;text-align:center;margin:5px 0 0 0;padding:0 5px;height:25px;border-top:1px solid #dde2bc;border-right:1px solid #dde2bc;border-bottom:1px solid #dde2bc;border-left:1px solid #dde2bc;border-bottom-radius:5px}#grueso .forum .meta .terms li,#grueso #comment-form div fieldset.collapsible{display:none}.meta .terms li a:hover{border:1px solid #eb8906;background-color:#fff;-webkit-transition:background-color .2s ease-in-out;-moz-transition:background-color .2s ease-in-out;-o-transition:background-color .2s ease-in-out;transition:background-color .2s ease-in-out}#grueso .meta ul.links{padding:0}#grueso .meta ul.links li{padding:0;margin:0}#grueso .form-item{padding:10px 0;margin:0}#grueso #edit-field-datoprograma-examen-tipo-0-value-wrapper{clear:both}#grueso .form-radios>div{padding:0}#grueso .options .fieldset-wrapper>div{padding:0;border:0}#grueso .options .fieldset-wrapper{padding-bottom:10px}#grueso #node-admin-filter .multiselect>dt:first-child{width:100%}#grueso ul{padding:0 0 0 20px}#grueso ul.links{margin:0}#grueso .description .tips{list-style:none;padding:0 0 0 27px}#grueso .fieldset-wrapper>div{padding:5px 0 5px 30px}#grueso .fieldset-wrapper>.form-radios{padding-top:0;padding-bottom:10px}.form-checkboxes,.form-radios{margin:0}#grueso div fieldset.collapsible{border-bottom:1px solid #88ab0c;height:auto}#grueso div fieldset.collapsible legend{font-size:1.1em}#grueso div fieldset.collapsible legend a{display:block;padding:10px 0 10px 20px;background:transparent url(/sites/default/themes/ueb/images/menu-expanded.png) no-repeat scroll 5px 60%;color:#df7e00}#grueso .view-electivas-indice div fieldset.collapsible legend a,#grueso .view-electivas-indice div fieldset.collapsible.collapsed legend a{white-space:normal;max-width:190px}#grueso div fieldset.collapsible.collapsed legend a{padding:10px 0 10px 20px;background:transparent url(/sites/default/themes/ueb/images/menu-collapsed.png) no-repeat scroll 5px 60%;color:#88ab0c}fieldset,img{border:0;margin:0;padding:0}#grueso form{background-color:#fff;padding:20px}#grueso form#comment-form{padding:0;border:0}#user-admin-perm thead{display:none}#grueso .help p{margin:0;padding:0}#grueso .container-inline{text-align:right}#context-blockform div.context-blockform-selector{height:auto;max-height:500px}.context-plugins .context-plugin-form .form-checkboxes{overflow:hidden;max-height:inherit}#grueso>ul.tabs.primary,#grueso>ul.tabs.secondary,#grueso span ul.tabs.primary,#grueso span ul.tabs.secondary{position:relative;margin:0;padding:10px 10px 0 10px;font-size:.8em;line-height:1.1em;border-top:0;border-right:solid 1px #e3e8cc;border-bottom:solid 1px #88ab0c;border-left:solid 1px #e3e8cc;background-color:#fff}#grueso>ul.tabs.primary li.active a,#grueso>ul.tabs.secondary li.active a,#grueso span ul.tabs.primary li.active a,#grueso span ul.tabs.secondary li.active a{background-color:#fff;color:#000;border:0;border-top:solid 1px #88ab0c;border-right:solid 1px #88ab0c;border-bottom:solid 1px #fff;border-left:solid 1px #88ab0c}#grueso>ul.tabs.primary li.active a:hover,#grueso>ul.tabs.secondary li.active a:hover,#grueso span ul.tabs.primary li.active a:hover,#grueso span ul.tabs.secondary li.active a:hover{cursor:default;color:#000;background-color:#fff}#grueso>ul.tabs.primary li a,#grueso>ul.tabs.secondary li a,#grueso span ul.tabs.primary li a,#grueso span ul.tabs.secondary li a{background-color:#fff;color:#b9bbaa;margin:0;padding:0 5px;border-top:#e3e8cc solid 1px;border-right:#e3e8cc solid 1px;border-bottom:#88ab0c solid 1px;border-left:#e3e8cc solid 1px}#grueso>ul.tabs.primary li:hover a,#grueso>ul.tabs.secondary li:hover a,#grueso span ul.tabs.primary li:hover a,#grueso span ul.tabs.secondary li:hover a{background-color:#e3e8cc;color:#000}#grueso>ul.tabs.secondary li,#grueso span ul.tabs.secondary li{border:0;padding:0}#grueso form #node-admin-filter li{list-style:none}#grueso form #node-admin-filter li #node-admin-buttons input{margin-top:0}#grueso form #node-admin-filter dl.multiselect dd div{padding:0;margin:0}#grueso form #node-admin-filter dl.multiselect dd div label input{padding:0;margin:0;vertical-align:middle}#grueso form #node-admin-filter dl.multiselect dd{padding:0;margin:0;width:auto}#grueso>form>div>#node-admin-filter{padding:0 0 20px 0;margin:0;border-bottom:1px solid #e8eee3}
#grueso>form>div>.container-inline{padding:10px 0 20px 0;margin:0;border-bottom:1px solid #e8eee3}#grueso form#node-admin-content legend{font-family:"PTSansBold"}#grueso table.sticky-table tbody{border:1px solid #e3e8cc}thead th{border:1px solid #e3e8cc;width:auto;font-size:.6em;padding:3px;margin:0}body.page-admin #grueso tbody tr td{vertical-align:top;font-size:.8em;line-height:.9em;padding:5px}#grueso tbody tr td.active{background:url(/sites/default/themes/ueb/images/fondo_columna.png) repeat}#grueso thead th.active img{padding-left:5px}#grueso tbody tr td label input{margin:0;padding:0}#grueso tbody tr td div.form-item{margin:0;padding:0}table.sticky-table thead th{width:auto;font-size:.6em;padding:3px;margin:0}#grueso table.sticky-table tbody tr{border:0}#grueso table.sticky-table tbody tr.odd{background-color:#f8faf2}#grueso table.sticky-table tbody tr.even{background-color:#fff}.node .fieldgroup .field-field-forum-enlace{float:right}.field-field-especial-inicioadmision{clear:both}.node .fieldgroup .field-field-forum-enlace a{background-color:#787fca;color:#fff;display:block;font-size:1.2em;letter-spacing:.1em;margin-bottom:-10px;padding:5px 10px;right:0}#grueso .box{background-color:#fff;margin-bottom:20px;padding:20px;border-top:0;border-right:solid 1px #e3e8cc;border-bottom:solid 2px #e3e8cc;border-left:solid 1px #e3e8cc}#grueso li.comment_add .active{display:none}#grueso .box h2{display:none}#grueso .box #edit-subject-wrapper label,#grueso .box #edit-comment-wrapper label{display:inherit;font-size:.8em}#grueso .resizable-textarea{width:100%}#grueso #comments{font-size:.9em;line-height:1.2em}#grueso #comments #comments-title{padding:5px;font-size:1.2em;text-align:center}#grueso #comments>.comment{border-top:2px solid #f4f6e7}#grueso .indented .comment-inner{border-top:2px solid #f4f6e7;border-top:2px solid #fff}#grueso .indented{margin-left:0;background-color:#f4f6e7}#grueso #comments .indented p{padding-left:20px}#grueso #comments .indented .indented p{padding-left:40px}#grueso .indented h3{display:none}#grueso #comments .indented .comment .content{background:0;padding:0 30px}#grueso .comment-inner{margin:0}#grueso .comment-inner h3{font-size:1.3em;padding:20px 0;padding-bottom:5px;margin:0 20px;border-bottom:solid 2px #88ab0c;display:none}#grueso #comments .comment .submitted,#grueso #comments .comment .links{visibility:hidden;margin:0 20px;text-align:right;font-size:.9em}#grueso #comments .comment:hover .submitted,#grueso #comments .comment:hover .links{visibility:visible}#grueso #comments .comment:hover .links li{margin-left:10px}#grueso .comment-inner>.content{padding:10px;background-color:#fff}#grueso .comment-inner .content>p{margin:0;padding:0}#grueso .comment-inner .links li{list-style:none;float:right}li.comment_add{float:left}#grueso #edit-field-image-0-upload-wrapper .filefield-element{margin:0;padding:0}#grueso #edit-field-image-0-upload-wrapper .filefield-element .filefield-upload{margin:0;padding:0}#grueso .form-item .form-item{padding:0}#grueso #edit-field-image-0-upload-wrapper .filefield-element .filefield-upload .form-submit{margin:0}.profile{margin:0}table#blocks{width:100%}.ueb_funcionalidades_izq{text-align:right}.ueb_funcionalidades_izq div,.ueb_funcionalidades_der div{border:solid 2px #093}.ueb_funcionalidades_izq div a,.ueb_funcionalidades_der div a{display:block;border:solid 1px #fff;padding:5px;overflow:hidden}.ueb_funcionalidades_izq div a span,.ueb_funcionalidades_der div a span{display:block;width:6px;height:6px;float:right;border:solid 1px #fff;background-color:#093;overflow:hidden;margin-left:5px}#grueso .messages{border:3px #ff0 solid;background-color:#555;color:#fff;font-size:.8em;padding:5px}#grueso .messages a{color:#eb8906}#grueso .status{background-color:#ff0;color:#fff;font-size:.8em;padding:5px;color:#000}@font-face{font-family:'PTSansRegular';src:url(/sites/default/themes/ueb/fonts/PT_Sans-webfont.eot);src:local('?'),url(/sites/default/themes/ueb/fonts/PT_Sans-webfont.woff) format('woff'),url(/sites/default/themes/ueb/fonts/PT_Sans-webfont.ttf) format('truetype'),url(/sites/default/themes/ueb/fonts/PT_Sans-webfont.svg#webfont) format('svg');font-weight:normal;font-style:normal}
@font-face{font-family:'PTSansItalic';src:url(/sites/default/themes/ueb/fonts/PT_Sans_Italic-webfont.eot);src:local('?'),url(/sites/default/themes/ueb/fonts/PT_Sans_Italic-webfont.woff) format('woff'),url(/sites/default/themes/ueb/fonts/PT_Sans_Italic-webfont.ttf) format('truetype'),url(/sites/default/themes/ueb/fonts/PT_Sans_Italic-webfont.svg#webfont) format('svg');font-weight:normal;font-style:normal}@font-face{font-family:'PTSansBold';src:url(/sites/default/themes/ueb/fonts/PT_Sans_Bold-webfont.eot);src:local('?'),url(/sites/default/themes/ueb/fonts/PT_Sans_Bold-webfont.woff) format('woff'),url(/sites/default/themes/ueb/fonts/PT_Sans_Bold-webfont.ttf) format('truetype'),url(/sites/default/themes/ueb/fonts/PT_Sans_Bold-webfont.svg#webfont) format('svg');font-weight:normal;font-style:normal}@font-face{font-family:'PTSansBoldItalic';src:url(/sites/default/themes/ueb/fonts/PT_Sans_Bold_Italic-webfont.eot);src:local('?'),url(/sites/default/themes/ueb/fonts/PT_Sans_Bold_Italic-webfont.woff) format('woff'),url(/sites/default/themes/ueb/fonts/PT_Sans_Bold_Italic-webfont.ttf) format('truetype'),url(/sites/default/themes/ueb/fonts/PT_Sans_Bold_Italic-webfont.svg#webfont) format('svg');font-weight:normal;font-style:normal}@font-face{font-family:'PTSerifBold';src:url(/sites/default/themes/ueb/fonts/PTF75F-webfont.eot);src:local('?'),url(/sites/default/themes/ueb/fonts/PTF75F-webfont.woff) format('woff'),url(/sites/default/themes/ueb/fonts/PTF75F-webfont.ttf) format('truetype'),url(/sites/default/themes/ueb/fonts/PTF75F-webfont.svg#webfontNckRu2nu) format('svg');font-weight:normal;font-style:normal}@font-face{font-family:'PTSansNarrow';src:url(/sites/default/themes/ueb/fonts/PTN57F-webfont.eot);src:local('?'),url(/sites/default/themes/ueb/fonts/PTN57F-webfont.woff) format('woff'),url(/sites/default/themes/ueb/fonts/PTN57F-webfont.ttf) format('truetype'),url(/sites/default/themes/ueb/fonts/PTN57F-webfont.svg#webfontNckRu2nu) format('svg');font-weight:normal;font-style:normal}hr{display:none}ul.borderedlist li{border-bottom:1px dashed #d1cfcd}ul.borderedlist li a{display:block;padding:3px 0 0 2px;height:26px;color:#42423b}ul.borderedlist li a:hover{background:#e5e5e4;color:#42423b}.three-container{width:960px;margin:0 auto;position:relative;overflow:hidden}#navigation li{float:left;padding-right:27px;text-transform:uppercase;font-size:1.3em;font-weight:normal}#navigation li a{color:#fff}#navigation li a:hover,#navigation li.active a{color:#2c2c2c}#promocional .block h2{font-size:1.3em;color:#483f3d;font-weight:bold;margin-bottom:5px}.lastbox{margin:0}.iconlist{border-top:1px dashed #d1cfcd;font-size:1.2em}a.translation-link{display:none}#lightbox #imageData #bottomNav{height:auto}.img_internacionalizacion{float:left;margin:10px;margin-top:10px}#links_formularios{width:495px;height:auto;background-color:#FFF;float:left;margin-left:20px;line-height:10px;line-height:1.1em;font-size:.9em;margin-top:-10px}#grueso #node-1743 table{font-size:1.4em;line-height:1.5em}#grueso #node-1743 td{padding:15px}#grueso #node-1743 td a img{border:3px solid #88ab0c;margin-right:15px}#grueso #node-1743 td a:hover img{border-color:#df7e00}#contenedor_logos_col2{width:720px;height:50px;padding-top:5px;margin-bottom:20px;text-align:center;padding-left:40px}#block-block-137{margin:40px 0}#block-block-136{background:#FFF;margin-top:-40px;padding-top:20px}#logo_clinica{display:block;width:114px;height:40px;float:left;margin-top:15px;background-image:url("/sites/default/files/imagenes/logo-clinica-reposo.png")}
#logo_clinica:hover{background-image:url("/sites/default/files/imagenes/logo-clinica-hover.png")}#logo_universia{display:block;width:86px;height:40px;float:right;margin-top:20px;background:url("/sites/default/files/imagenes/logo-universia-reposo.png")}#logo_universia:hover{background:url("/sites/default/files/imagenes/logo-universia-hover.png")}#logo_cooperativa{display:block;width:114px;height:39px;float:left;margin-top:15px;background:url("/sites/default/files/imagenes/logo-cooperativa-reposo.png")}#logo_cooperativa:hover{background:url("/sites/default/files/imagenes/logo-cooperativa-hover.png")}#fulbright_btn{display:block;width:85px;height:35px;float:left;margin-top:0;background:url("/sites/default/files/imagenes/logos_convenios/fulbright_btn.png") no-repeat}#fulbright_btn:hover{background:url("/sites/default/files/imagenes/logos_convenios/fulbright_hover.png") no-repeat}#dad{display:block;width:76px;height:27px;float:left;background:url("/sites/default/files/imagenes/logos_convenios/dad_btnr.png") no-repeat}#dad:hover{background:url("/sites/default/files/imagenes/logos_convenios/dad_hover.png") no-repeat}#f_carolina{display:block;width:85px;height:24px;float:left;background:url("/sites/default/files/imagenes/logos_convenios/logo_fundacion_carolina.png") no-repeat}#f_carolina:hover{background:url("/sites/default/files/imagenes/logos_convenios/logo_fundacion_carolina_hover.png") no-repeat}#colciencias{display:block;width:100px;height:33px;float:left;background:url("/sites/default/files/imagenes/logos_convenios/colciencias_btn.png") no-repeat}#colciencias:hover{background:url("/sites/default/files/imagenes/logos_convenios/colciencias_hover.png") no-repeat}#mafpre{display:block;width:85px;height:30px;float:left;background:url("/sites/default/files/imagenes/logos_convenios/Mapfre_btn.gif.png") no-repeat}#mafpre:hover{background:url("/sites/default/files/imagenes/logos_convenios/Mapfre_hover.png") no-repeat}#colfuturos{display:block;width:100px;height:36px;float:left;margin-top:-10px;background:url("/sites/default/files/imagenes/logos_convenios/colfuturo.hover.png") no-repeat}#colfuturos:hover{background:url("/sites/default/files/imagenes/logos_convenios/colfuturo.png") no-repeat}#americas{background:url("/sites/default/files/imagenes/logos_convenios/oea.png") no-repeat scroll 0 0 transparent;display:block;float:left;height:47px;width:50px;margin-top:-10px;margin-left:100px}#americas:hover{background:url("/sites/default/files/imagenes/logos_convenios/oea_hover.png") no-repeat}#francia{background:url("/sites/default/files/imagenes/logos_convenios/logorep.hover.png") no-repeat scroll 0 0 transparent;display:block;float:left;height:35px;width:60px}#francia:hover{background:url("/sites/default/files/imagenes/logos_convenios/logorep.jpg") no-repeat}#universia{background:url("/sites/default/files/imagenes/logos_convenios/logo-universia.png") no-repeat scroll 0 0 transparent;display:block;float:left;height:22px;width:100px}#universia:hover{background:url("/sites/default/files/imagenes/logos_convenios/logo-universia_hover.png") no-repeat}#icetex{background:url("/sites/default/files/imagenes/logos_convenios/logoICETEX.hover.png") no-repeat scroll 0 0 transparent;display:block;float:left;height:18px;width:100px;margin-top:2px}#icetex:hover{background:url("/sites/default/files/imagenes/logos_convenios/logoICETEX.png") no-repeat}#ue{background:url("/sites/default/files/imagenes/logos_convenios/ue_btn.png") no-repeat scroll 0 0 transparent;display:block;float:left;height:33px;width:50px}#ue:hover{background:url("/sites/default/files/imagenes/logos_convenios/ue_hover.png") no-repeat}.recla{background:url("/sites/default/files/imagenes/recla_btn.png") no-repeat;width:140px;height:72px;display:block;text-align:center;margin-left:40%}.recla:hover{background:url("/sites/default/files/imagenes/recla_hover.png") no-repeat}#block-block-118{text-align:center}body.page-medios #promocional .block{margin-bottom:30px}#block-views-inicio_eventos-block_3 .item-list .pager-next .active{color:#88ab0c}#block-views-inicio_eventos-block_3 .item-list .pager-next .active:hover{color:#eb8906}#block-views-inicio_eventos-block_3 .item-list .pager-previous .active{color:#88ab0c}#block-views-inicio_eventos-block_3 .item-list .pager{background-color:#eff2dc;padding:0;margin:0;height:30px;width:200px;color:88ab0c;margin-left:-25px;border-left:1px solid #dfe1cb;border-right:1px solid #dfe1cb;background:url(/sites/default/themes/ueb/images/pager-fondo.png) repeat scroll 0 -8px transparent}#contenedor{width:700px;height:800px}#seccion_publi{width:340px;float:left;margin-right:5px;padding-top:10px}#cuadernos{width:330px}#titulo_cuadernos_hs{opacity:.8;background-color:#3e4729;line-height:1.5em;padding:.1em .1em .1em 1.5em;font-size:.8em;color:#FFF;margin-top:0;margin-bottom:1em;padding-left:5px}#titulo_cuadernos_proyecto{opacity:.8;background-color:#3e4729;line-height:1.5em;color:#FFF;font-size:.8em;margin-bottom:1em;padding:.1em .1em .1em 1.5em}
#titulo_aulas{opacity:.8;background-color:#3e4729;line-height:1.5em;color:#FFF;font-size:.8em;margin-bottom:1em;padding:.1em .1em .1em 1.5em}#cuadernos_bg{width:330px;height:70px;color:#FFF;text-align:left;background-image:url(/sites/default/files/imagenes/publicaciones//IMG_4758--.jpg)}#cuadernos{width:330px;margin-bottom:5px;padding:0}#proyecto_bg{width:330px;height:100px;color:#FFF;text-align:left;background-image:url(/sites/default/files/imagenes/publicaciones/proyecto_vida.gif);margin-bottom:2em}#boletin{width:330px;margin-bottom:5px}#aulas_sico{width:330px;margin-bottom:5px}#pulicaciones{list-style:none;list-style-type:none;padding:1em;margin-left:-5px;margin:0;padding:0;margin-bottom:2em;line-height:1em}#pulicaciones li{text-align:left;margin-bottom:.7em;margin-left:20px}#pulicaciones ul li{list-style:none;list-style-type:none;font:.7em;margin-bottom:.8em}body.portal_egresados #grueso .clear-block.block.block-views{margin-bottom:20px;margin-top:20px}#promo_matematica_img{background-image:url("/sites/default/files/promo/mathpromo.jpg");display:block;height:85px;margin-bottom:5px;width:210px}#promo_matematica_img:hover{background-image:url("/sites/default/files/promo/mathpromo_hover.jpg")}#promo_derecho_img{background-image:url("/sites/default/files/promo/derecho_promo.jpg");display:block;height:85px;margin-bottom:5px;width:210px}#promo_derecho_img:hover{background-image:url("/sites/default/files/promo/derecho_promo_hover.jpg")}#promo_bioing_img{background-image:url("/sites/default/files/promo/bioing_promo.jpg");display:block;height:85px;margin-bottom:5px;width:210px}#promo_bioing_img:hover{background-image:url("/sites/default/files/promo/bioing_promo_hover.jpg")}#block-block-103{margin-bottom:20px}div.views-field-field-contenido-carrusel-imagen-fid+div.views-field-title,div.views-field-field-contenido-carrusel-imagen-fid ~ div.views-field-value{display:none}.views-field-field-mencion-video-value iframe{z-index:-2000}.contenedor{width:auto}div.views-field-field-mencion-youtube-embed,div.views-field-field-mencion-imagen-fid,div.views-field-field-mencion-audio-fid{float:left}.view-boletin-egresados-el-bosque .view-content>div.views-row{padding:20px 0}.view-boletin-egresados-el-bosque .view-content>div.views-row-first{margin-top:-20px}.view-boletin-egresados-el-bosque .view-header{padding:10px 10px 0}.view-boletin-egresados-el-bosque .views-field-field-boletin-imagen-fid{padding:0 15px;float:left}.view-boletin-egresados-el-bosque .views-field-field-boletin-indice-value{padding:0 15px}.page-medios #promocional .content{padding:0 15px}.view-u-medios-externos,.page-taxonomy.page-medios #grueso{padding-top:10px}span.conteo{color:#3e4729}.view-u-medios-externos .mencion_medios_externos{max-width:480px}.view-u-medios-externos table.views-view-grid td{padding:0}.page-medios #grueso div.mencion_medios_externos{padding:5px 5px 40px;border:0;margin:0}.page-medios #grueso .mencion_medios_externos h2{color:#df7e00;font-weight:normal;font-family:'PTSansRegular';border-bottom:1px solid #dfe1cb;padding-bottom:0;margin-bottom:5px}div.view-u-medios-externos table.views-view-grid td{font-size:inherit}.fuente-mencion{font-style:italic}.mencion_medios_externos .field-field-mencion-imagen a,.mencion_medios_externos .field-field-mencion-youtube a{display:block;border:3px solid #88ab0c;margin-top:5px;margin-right:10px;float:left}.mencion_medios_externos .clear-block:after{clear:none}.content.archivo,.content.archivo span.conteo{font-size:.7em}.content.archivo a{font-size:1.4em}.content.archivo a.mes{margin-left:25px}div.view-u-medios-externos table td{padding-bottom:40px}.view-u-medios-externos .views-field-tid a{margin-right:5px}.view-u-medios-externos .views-field-field-mencion-imagen-fid a img{display:block}.view-u-medios-externos .views-field-field-mencion-imagen-fid a:hover,.view-u-medios-externos .views-field-field-mencion-youtube-embed a:hover,.mencion_medios_externos .field-field-mencion-imagen a:hover,.mencion_medios_externos .field-field-mencion-youtube a:hover{border-color:#df7e00}.views-field-field-mencion-bocadillo-value,.mencion_medios_externos .field-field-mencion-bocadillo{margin-top:10px}
#lightboxFrame{overflow:hidden}.mencion_medios_externos .field-label-inline-first{font-weight:normal}body.node-type-boletin-facultades table,body.node-type-boletin-facultades table tr td,body.node-type-boletin table,body.node-type-boletin table tr td{padding:0!important}body table tr td class.seccion{line-height:50px!important}.view-boletin-la-facultad-informa .views-field-field-boletin-imagen-fid{float:left;margin:0 15px}.view-boletin-la-facultad-informa .view-footer{background-color:white;font-size:1em;line-height:1.1em;padding:0 0 10px 130px}.view-boletin-la-facultad-informa .views-field-field-boletin-imagen-fid+.views-field-title{font-family:'PTSansBold';font-size:1.4em;display:block;line-height:1em;padding-bottom:10px}#grueso .views-field-field-boletin-indice-value{padding:0 0 0 130px}#grueso .block-views .view-boletin-la-facultad-informa table.views-view-grid td .views-field-title{font-size:1.1em;padding-left:146px}.block-mobile_tools{float:left}#grueso .view-content ul.jp-controls{padding:0 40px 0 0}#grueso .view-content ul.jp-controls li{line-height:inherit;overflow:inherit;padding:5ps;position:inherit;float:left}div.jp-interface ul.jp-controls a{position:absolute}.issuuembed>div div:nth-last-child{visibility:hidden}.ui-helper-hidden{display:none}.ui-helper-hidden-accessible{position:absolute;left:-99999999px}.ui-helper-reset{margin:0;padding:0;border:0;outline:0;line-height:1.3;text-decoration:none;font-size:100%;list-style:none}.ui-helper-clearfix:after{content:".";display:block;height:0;clear:both;visibility:hidden}.ui-helper-clearfix{display:inline-block}/*\*/* html .ui-helper-clearfix{height:1%}.ui-helper-clearfix{display:block}/**/.ui-helper-zfix{width:100%;height:100%;top:0;left:0;position:absolute;opacity:0;filter:Alpha(Opacity=0)}.ui-state-disabled{cursor:default!important}.ui-icon{display:block;text-indent:-99999px;overflow:hidden;background-repeat:no-repeat}.ui-widget-overlay{position:absolute;top:0;left:0;width:100%;height:100%}.ui-accordion .ui-accordion-header{cursor:pointer;position:relative;margin-top:1px;zoom:1}.ui-accordion .ui-accordion-li-fix{display:inline}.ui-accordion .ui-accordion-header-active{border-bottom:0!important}.ui-accordion .ui-accordion-header a{display:block;font-size:1em;padding:.5em .5em .5em 2.2em}.ui-accordion .ui-accordion-header .ui-icon{position:absolute;left:.5em;top:50%;margin-top:-8px}.ui-accordion .ui-accordion-content{padding:1em 2.2em;border-top:0;margin-top:-2px;position:relative;top:1px;margin-bottom:2px;overflow:auto;display:none}.ui-accordion .ui-accordion-content-active{display:block}.ui-datepicker{width:17em;padding:.2em .2em 0}.ui-datepicker .ui-datepicker-header{position:relative;padding:.2em 0}.ui-datepicker .ui-datepicker-prev,.ui-datepicker .ui-datepicker-next{position:absolute;top:2px;width:1.8em;height:1.8em}.ui-datepicker .ui-datepicker-prev-hover,.ui-datepicker .ui-datepicker-next-hover{top:1px}.ui-datepicker .ui-datepicker-prev{left:2px}.ui-datepicker .ui-datepicker-next{right:2px}.ui-datepicker .ui-datepicker-prev-hover{left:1px}.ui-datepicker .ui-datepicker-next-hover{right:1px}.ui-datepicker .ui-datepicker-prev span,.ui-datepicker .ui-datepicker-next span{display:block;position:absolute;left:50%;margin-left:-8px;top:50%;margin-top:-8px}.ui-datepicker .ui-datepicker-title{margin:0 2.3em;line-height:1.8em;text-align:center}.ui-datepicker .ui-datepicker-title select{float:left;font-size:1em;margin:1px 0}.ui-datepicker select.ui-datepicker-month-year{width:100%}.ui-datepicker select.ui-datepicker-month,.ui-datepicker select.ui-datepicker-year{width:49%}.ui-datepicker .ui-datepicker-title select.ui-datepicker-year{float:right}.ui-datepicker table{width:100%;font-size:.9em;border-collapse:collapse;margin:0 0 .4em}.ui-datepicker th{padding:.7em .3em;text-align:center;font-weight:bold;border:0}.ui-datepicker td{border:0;padding:1px}.ui-datepicker td span,.ui-datepicker td a{display:block;padding:.2em;text-align:right;text-decoration:none}
.ui-datepicker .ui-datepicker-buttonpane{background-image:none;margin:.7em 0 0 0;padding:0 .2em;border-left:0;border-right:0;border-bottom:0}.ui-datepicker .ui-datepicker-buttonpane button{float:right;margin:.5em .2em .4em;cursor:pointer;padding:.2em .6em .3em .6em;width:auto;overflow:visible}.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current{float:left}.ui-datepicker.ui-datepicker-multi{width:auto}.ui-datepicker-multi .ui-datepicker-group{float:left}.ui-datepicker-multi .ui-datepicker-group table{width:95%;margin:0 auto .4em}.ui-datepicker-multi-2 .ui-datepicker-group{width:50%}.ui-datepicker-multi-3 .ui-datepicker-group{width:33.3%}.ui-datepicker-multi-4 .ui-datepicker-group{width:25%}.ui-datepicker-multi .ui-datepicker-group-last .ui-datepicker-header{border-left-width:0}.ui-datepicker-multi .ui-datepicker-group-middle .ui-datepicker-header{border-left-width:0}.ui-datepicker-multi .ui-datepicker-buttonpane{clear:left}.ui-datepicker-row-break{clear:both;width:100%}.ui-datepicker-rtl{direction:rtl}.ui-datepicker-rtl .ui-datepicker-prev{right:2px;left:auto}.ui-datepicker-rtl .ui-datepicker-next{left:2px;right:auto}.ui-datepicker-rtl .ui-datepicker-prev:hover{right:1px;left:auto}.ui-datepicker-rtl .ui-datepicker-next:hover{left:1px;right:auto}.ui-datepicker-rtl .ui-datepicker-buttonpane{clear:right}.ui-datepicker-rtl .ui-datepicker-buttonpane button{float:left}.ui-datepicker-rtl .ui-datepicker-buttonpane button.ui-datepicker-current{float:right}.ui-datepicker-rtl .ui-datepicker-group{float:right}.ui-datepicker-rtl .ui-datepicker-group-last .ui-datepicker-header{border-right-width:0;border-left-width:1px}.ui-datepicker-rtl .ui-datepicker-group-middle .ui-datepicker-header{border-right-width:0;border-left-width:1px}.ui-datepicker-cover{display:none;display:block;position:absolute;z-index:-1;filter:mask();top:-4px;left:-4px;width:200px;height:200px}.ui-dialog{position:relative;padding:.2em;width:300px}.ui-dialog .ui-dialog-titlebar{padding:.5em .3em .3em 1em;position:relative}.ui-dialog .ui-dialog-title{float:left;margin:.1em 0 .2em}.ui-dialog .ui-dialog-titlebar-close{position:absolute;right:.3em;top:50%;width:19px;margin:-10px 0 0 0;padding:1px;height:18px}.ui-dialog .ui-dialog-titlebar-close span{display:block;margin:1px}.ui-dialog .ui-dialog-titlebar-close:hover,.ui-dialog .ui-dialog-titlebar-close:focus{padding:0}.ui-dialog .ui-dialog-content{border:0;padding:.5em 1em;background:0;overflow:auto;zoom:1}.ui-dialog .ui-dialog-buttonpane{text-align:left;border-width:1px 0 0 0;background-image:none;margin:.5em 0 0 0;padding:.3em 1em .5em .4em}.ui-dialog .ui-dialog-buttonpane button{float:right;margin:.5em .4em .5em 0;cursor:pointer;padding:.2em .6em .3em .6em;line-height:1.4em;width:auto;overflow:visible}.ui-dialog .ui-resizable-se{width:14px;height:14px;right:3px;bottom:3px}.ui-draggable .ui-dialog-titlebar{cursor:move}.ui-progressbar{height:2em;text-align:left}.ui-progressbar .ui-progressbar-value{margin:-1px;height:100%}.ui-resizable{position:relative}.ui-resizable-handle{position:absolute;font-size:.1px;z-index:99999;display:block}.ui-resizable-disabled .ui-resizable-handle,.ui-resizable-autohide .ui-resizable-handle{display:none}.ui-resizable-n{cursor:n-resize;height:7px;width:100%;top:-5px;left:0}.ui-resizable-s{cursor:s-resize;height:7px;width:100%;bottom:-5px;left:0}.ui-resizable-e{cursor:e-resize;width:7px;right:-5px;top:0;height:100%}.ui-resizable-w{cursor:w-resize;width:7px;left:-5px;top:0;height:100%}.ui-resizable-se{cursor:se-resize;width:12px;height:12px;right:1px;bottom:1px}.ui-resizable-sw{cursor:sw-resize;width:9px;height:9px;left:-5px;bottom:-5px}.ui-resizable-nw{cursor:nw-resize;width:9px;height:9px;left:-5px;top:-5px}.ui-resizable-ne{cursor:ne-resize;width:9px;height:9px;right:-5px;top:-5px}.ui-slider{position:relative;text-align:left}.ui-slider .ui-slider-handle{position:absolute;z-index:2;width:1.2em;height:1.2em;cursor:default}.ui-slider .ui-slider-range{position:absolute;z-index:1;font-size:.7em;display:block;border:0}.ui-slider-horizontal{height:.8em}.ui-slider-horizontal .ui-slider-handle{top:-.3em;margin-left:-.6em}
.ui-slider-horizontal .ui-slider-range{top:0;height:100%}.ui-slider-horizontal .ui-slider-range-min{left:0}.ui-slider-horizontal .ui-slider-range-max{right:0}.ui-slider-vertical{width:.8em;height:100px}.ui-slider-vertical .ui-slider-handle{left:-.3em;margin-left:0;margin-bottom:-.6em}.ui-slider-vertical .ui-slider-range{left:0;width:100%}.ui-slider-vertical .ui-slider-range-min{bottom:0}.ui-slider-vertical .ui-slider-range-max{top:0}.ui-tabs{padding:.2em;zoom:1}.ui-tabs .ui-tabs-nav{list-style:none;position:relative;padding:.2em .2em 0}.ui-tabs .ui-tabs-nav li{position:relative;float:left;border-bottom-width:0!important;margin:0 .2em -1px 0;padding:0}.ui-tabs .ui-tabs-nav li a{float:left;text-decoration:none;padding:.5em 1em}.ui-tabs .ui-tabs-nav li.ui-tabs-selected{padding-bottom:1px;border-bottom-width:0}.ui-tabs .ui-tabs-nav li.ui-tabs-selected a,.ui-tabs .ui-tabs-nav li.ui-state-disabled a,.ui-tabs .ui-tabs-nav li.ui-state-processing a{cursor:text}.ui-tabs .ui-tabs-nav li a,.ui-tabs.ui-tabs-collapsible .ui-tabs-nav li.ui-tabs-selected a{cursor:pointer}.ui-tabs .ui-tabs-panel{padding:1em 1.4em;display:block;border-width:0;background:0}.ui-tabs .ui-tabs-hide{display:none!important}.ui-widget{font-family:Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;font-size:1.1em}.ui-widget input,.ui-widget select,.ui-widget textarea,.ui-widget button{font-family:Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;font-size:1em}.ui-widget-content{border:1px solid #ddd;background:#eee url(/sites/default/themes/ueb/piemovible/images/ui-bg_highlight-soft_100_eeeeee_1x100.png) 50% top repeat-x;color:#333}.ui-widget-content a{color:#333}.ui-widget-header{color:#fff;font-weight:bold;padding-top:4px}.ui-widget-header a{color:#fff}.ui-state-default,.ui-widget-content .ui-state-default{border:1px solid #ccc;background:#f6f6f6 url(/sites/default/themes/ueb/piemovible/images/ui-bg_glass_100_f6f6f6_1x400.png) 50% 50% repeat-x;font-weight:bold;color:#1c94c4;outline:0}.ui-state-default a,.ui-state-default a:link,.ui-state-default a:visited{color:#1c94c4;text-decoration:none;outline:0}.ui-state-hover,.ui-widget-content .ui-state-hover,.ui-state-focus,.ui-widget-content .ui-state-focus{border:1px solid #fbcb09;background:#fdf5ce url(/sites/default/themes/ueb/piemovible/images/ui-bg_glass_100_fdf5ce_1x400.png) 50% 50% repeat-x;font-weight:bold;color:#c77405;outline:0}.ui-state-hover a,.ui-state-hover a:hover{color:#c77405;text-decoration:none;outline:0}.ui-state-active,.ui-widget-content .ui-state-active{border:1px solid #fbd850;background:#fff url(/sites/default/themes/ueb/piemovible/images/ui-bg_glass_65_ffffff_1x400.png) 50% 50% repeat-x;font-weight:bold;color:#eb8f00;outline:0}.ui-state-active a,.ui-state-active a:link,.ui-state-active a:visited{color:#eb8f00;outline:0;text-decoration:none}.ui-state-highlight,.ui-widget-content .ui-state-highlight{border:1px solid #fed22f;background:#ffe45c url(/sites/default/themes/ueb/piemovible/images/ui-bg_highlight-soft_75_ffe45c_1x100.png) 50% top repeat-x;color:#363636}.ui-state-highlight a,.ui-widget-content .ui-state-highlight a{color:#363636}.ui-state-error,.ui-widget-content .ui-state-error{border:1px solid #cd0a0a;background:#b81900 url(/sites/default/themes/ueb/piemovible/images/ui-bg_diagonals-thick_18_b81900_40x40.png) 50% 50% repeat;color:#fff}.ui-state-error a,.ui-widget-content .ui-state-error a{color:#fff}.ui-state-error-text,.ui-widget-content .ui-state-error-text{color:#fff}.ui-state-disabled,.ui-widget-content .ui-state-disabled{opacity:.35;filter:Alpha(Opacity=35);background-image:none}.ui-priority-primary,.ui-widget-content .ui-priority-primary{font-weight:bold}.ui-priority-secondary,.ui-widget-content .ui-priority-secondary{opacity:.7;filter:Alpha(Opacity=70);font-weight:normal}.ui-icon{width:16px;height:16px;background-image:url(/sites/default/themes/ueb/piemovible/images/ui-icons_222222_256x240.png)}.ui-widget-content .ui-icon{background-image:url(/sites/default/themes/ueb/piemovible/images/ui-icons_222222_256x240.png)}.ui-widget-header .ui-icon{background-image:url(/sites/default/themes/ueb/piemovible/images/ui-icons_ffffff_256x240.png)}.ui-state-default .ui-icon{background-image:url(/sites/default/themes/ueb/piemovible/images/ui-icons_ef8c08_256x240.png)}.ui-state-hover .ui-icon,.ui-state-focus .ui-icon{background-image:url(/sites/default/themes/ueb/piemovible/images/ui-icons_ef8c08_256x240.png)}.ui-state-active .ui-icon{background-image:url(/sites/default/themes/ueb/piemovible/images/ui-icons_ef8c08_256x240.png)}.ui-state-highlight .ui-icon{background-image:url(/sites/default/themes/ueb/piemovible/images/ui-icons_228ef1_256x240.png)}
.ui-state-error .ui-icon,.ui-state-error-text .ui-icon{background-image:url(/sites/default/themes/ueb/piemovible/images/ui-icons_ffd27a_256x240.png)}.ui-icon-carat-1-n{background-position:0 0}.ui-icon-carat-1-ne{background-position:-16px 0}.ui-icon-carat-1-e{background-position:-32px 0}.ui-icon-carat-1-se{background-position:-48px 0}.ui-icon-carat-1-s{background-position:-64px 0}.ui-icon-carat-1-sw{background-position:-80px 0}.ui-icon-carat-1-w{background-position:-96px 0}.ui-icon-carat-1-nw{background-position:-112px 0}.ui-icon-carat-2-n-s{background-position:-128px 0}.ui-icon-carat-2-e-w{background-position:-144px 0}.ui-icon-triangle-1-n{background-position:0 -16px}.ui-icon-triangle-1-ne{background-position:-16px -16px}.ui-icon-triangle-1-e{background-position:-32px -16px}.ui-icon-triangle-1-se{background-position:-48px -16px}.ui-icon-triangle-1-s{background-position:-64px -16px}.ui-icon-triangle-1-sw{background-position:-80px -16px}.ui-icon-triangle-1-w{background-position:-96px -16px}.ui-icon-triangle-1-nw{background-position:-112px -16px}.ui-icon-triangle-2-n-s{background-position:-128px -16px}.ui-icon-triangle-2-e-w{background-position:-144px -16px}.ui-icon-arrow-1-n{background-position:0 -32px}.ui-icon-arrow-1-ne{background-position:-16px -32px}.ui-icon-arrow-1-e{background-position:-32px -32px}.ui-icon-arrow-1-se{background-position:-48px -32px}.ui-icon-arrow-1-s{background-position:-64px -32px}.ui-icon-arrow-1-sw{background-position:-80px -32px}.ui-icon-arrow-1-w{background-position:-96px -32px}.ui-icon-arrow-1-nw{background-position:-112px -32px}.ui-icon-arrow-2-n-s{background-position:-128px -32px}.ui-icon-arrow-2-ne-sw{background-position:-144px -32px}.ui-icon-arrow-2-e-w{background-position:-160px -32px}.ui-icon-arrow-2-se-nw{background-position:-176px -32px}.ui-icon-arrowstop-1-n{background-position:-192px -32px}.ui-icon-arrowstop-1-e{background-position:-208px -32px}.ui-icon-arrowstop-1-s{background-position:-224px -32px}.ui-icon-arrowstop-1-w{background-position:-240px -32px}.ui-icon-arrowthick-1-n{background-position:0 -48px}.ui-icon-arrowthick-1-ne{background-position:-16px -48px}.ui-icon-arrowthick-1-e{background-position:-32px -48px}.ui-icon-arrowthick-1-se{background-position:-48px -48px}.ui-icon-arrowthick-1-s{background-position:-64px -48px}.ui-icon-arrowthick-1-sw{background-position:-80px -48px}.ui-icon-arrowthick-1-w{background-position:-96px -48px}.ui-icon-arrowthick-1-nw{background-position:-112px -48px}.ui-icon-arrowthick-2-n-s{background-position:-128px -48px}.ui-icon-arrowthick-2-ne-sw{background-position:-144px -48px}.ui-icon-arrowthick-2-e-w{background-position:-160px -48px}.ui-icon-arrowthick-2-se-nw{background-position:-176px -48px}.ui-icon-arrowthickstop-1-n{background-position:-192px -48px}.ui-icon-arrowthickstop-1-e{background-position:-208px -48px}.ui-icon-arrowthickstop-1-s{background-position:-224px -48px}.ui-icon-arrowthickstop-1-w{background-position:-240px -48px}.ui-icon-arrowreturnthick-1-w{background-position:0 -64px}.ui-icon-arrowreturnthick-1-n{background-position:-16px -64px}.ui-icon-arrowreturnthick-1-e{background-position:-32px -64px}.ui-icon-arrowreturnthick-1-s{background-position:-48px -64px}.ui-icon-arrowreturn-1-w{background-position:-64px -64px}.ui-icon-arrowreturn-1-n{background-position:-80px -64px}.ui-icon-arrowreturn-1-e{background-position:-96px -64px}.ui-icon-arrowreturn-1-s{background-position:-112px -64px}.ui-icon-arrowrefresh-1-w{background-position:-128px -64px}.ui-icon-arrowrefresh-1-n{background-position:-144px -64px}.ui-icon-arrowrefresh-1-e{background-position:-160px -64px}.ui-icon-arrowrefresh-1-s{background-position:-176px -64px}.ui-icon-arrow-4{background-position:0 -80px}.ui-icon-arrow-4-diag{background-position:-16px -80px}.ui-icon-extlink{background-position:-32px -80px}.ui-icon-newwin{background-position:-48px -80px}.ui-icon-refresh{background-position:-64px -80px}.ui-icon-shuffle{background-position:-80px -80px}.ui-icon-transfer-e-w{background-position:-96px -80px}.ui-icon-transferthick-e-w{background-position:-112px -80px}.ui-icon-folder-collapsed{background-position:0 -96px}
.ui-icon-folder-open{background-position:-16px -96px}.ui-icon-document{background-position:-32px -96px}.ui-icon-document-b{background-position:-48px -96px}.ui-icon-note{background-position:-64px -96px}.ui-icon-mail-closed{background-position:-80px -96px}.ui-icon-mail-open{background-position:-96px -96px}.ui-icon-suitcase{background-position:-112px -96px}.ui-icon-comment{background-position:-128px -96px}.ui-icon-person{background-position:-144px -96px}.ui-icon-print{background-position:-160px -96px}.ui-icon-trash{background-position:-176px -96px}.ui-icon-locked{background-position:-192px -96px}.ui-icon-unlocked{background-position:-208px -96px}.ui-icon-bookmark{background-position:-224px -96px}.ui-icon-tag{background-position:-240px -96px}.ui-icon-home{background-position:0 -112px}.ui-icon-flag{background-position:-16px -112px}.ui-icon-calendar{background-position:-32px -112px}.ui-icon-cart{background-position:-48px -112px}.ui-icon-pencil{background-position:-64px -112px}.ui-icon-clock{background-position:-80px -112px}.ui-icon-disk{background-position:-96px -112px}.ui-icon-calculator{background-position:-112px -112px}.ui-icon-zoomin{background-position:-128px -112px}.ui-icon-zoomout{background-position:-144px -112px}.ui-icon-search{background-position:-160px -112px}.ui-icon-wrench{background-position:-176px -112px}.ui-icon-gear{background-position:-192px -112px}.ui-icon-heart{background-position:-208px -112px}.ui-icon-star{background-position:-224px -112px}.ui-icon-link{background-position:-240px -112px}.ui-icon-cancel{background-position:0 -128px}.ui-icon-plus{background-position:-16px -128px}.ui-icon-plusthick{background-position:-32px -128px}.ui-icon-minus{background-position:-48px -128px}.ui-icon-minusthick{background-position:-64px -128px}.ui-icon-close{background-position:-80px -128px}.ui-icon-closethick{background-position:-96px -128px}.ui-icon-key{background-position:-112px -128px}.ui-icon-lightbulb{background-position:-128px -128px}.ui-icon-scissors{background-position:-144px -128px}.ui-icon-clipboard{background-position:-160px -128px}.ui-icon-copy{background-position:-176px -128px}.ui-icon-contact{background-position:-192px -128px}.ui-icon-image{background-position:-208px -128px}.ui-icon-video{background-position:-224px -128px}.ui-icon-script{background-position:-240px -128px}.ui-icon-alert{background-position:0 -144px}.ui-icon-info{background-position:-16px -144px}.ui-icon-notice{background-position:-32px -144px}.ui-icon-help{background-position:-48px -144px}.ui-icon-check{background-position:-64px -144px}.ui-icon-bullet{background-position:-80px -144px}.ui-icon-radio-off{background-position:-96px -144px}.ui-icon-radio-on{background-position:-112px -144px}.ui-icon-pin-w{background-position:-128px -144px}.ui-icon-pin-s{background-position:-144px -144px}.ui-icon-play{background-position:0 -160px}.ui-icon-pause{background-position:-16px -160px}.ui-icon-seek-next{background-position:-32px -160px}.ui-icon-seek-prev{background-position:-48px -160px}.ui-icon-seek-end{background-position:-64px -160px}.ui-icon-seek-first{background-position:-80px -160px}.ui-icon-stop{background-position:-96px -160px}.ui-icon-eject{background-position:-112px -160px}.ui-icon-volume-off{background-position:-128px -160px}.ui-icon-volume-on{background-position:-144px -160px}.ui-icon-power{background-position:0 -176px}.ui-icon-signal-diag{background-position:-16px -176px}.ui-icon-signal{background-position:-32px -176px}.ui-icon-battery-0{background-position:-48px -176px}.ui-icon-battery-1{background-position:-64px -176px}.ui-icon-battery-2{background-position:-80px -176px}.ui-icon-battery-3{background-position:-96px -176px}.ui-icon-circle-plus{background-position:0 -192px}.ui-icon-circle-minus{background-position:-16px -192px}.ui-icon-circle-close{background-position:-32px -192px}.ui-icon-circle-triangle-e{background-position:-48px -192px}.ui-icon-circle-triangle-s{background-position:-64px -192px}.ui-icon-circle-triangle-w{background-position:-80px -192px}.ui-icon-circle-triangle-n{background-position:-96px -192px}.ui-icon-circle-arrow-e{background-position:-112px -192px}
.ui-icon-circle-arrow-s{background-position:-128px -192px}.ui-icon-circle-arrow-w{background-position:-144px -192px}.ui-icon-circle-arrow-n{background-position:-160px -192px}.ui-icon-circle-zoomin{background-position:-176px -192px}.ui-icon-circle-zoomout{background-position:-192px -192px}.ui-icon-circle-check{background-position:-208px -192px}.ui-icon-circlesmall-plus{background-position:0 -208px}.ui-icon-circlesmall-minus{background-position:-16px -208px}.ui-icon-circlesmall-close{background-position:-32px -208px}.ui-icon-squaresmall-plus{background-position:-48px -208px}.ui-icon-squaresmall-minus{background-position:-64px -208px}.ui-icon-squaresmall-close{background-position:-80px -208px}.ui-icon-grip-dotted-vertical{background-position:0 -224px}.ui-icon-grip-dotted-horizontal{background-position:-16px -224px}.ui-icon-grip-solid-vertical{background-position:-32px -224px}.ui-icon-grip-solid-horizontal{background-position:-48px -224px}.ui-icon-gripsmall-diagonal-se{background-position:-64px -224px}.ui-icon-grip-diagonal-se{background-position:-80px -224px}.ui-corner-tl{-moz-border-radius-topleft:4px;-webkit-border-top-left-radius:4px}.ui-corner-tr{-moz-border-radius-topright:4px;-webkit-border-top-right-radius:4px}.ui-corner-bl{-moz-border-radius-bottomleft:4px;-webkit-border-bottom-left-radius:4px}.ui-corner-br{-moz-border-radius-bottomright:4px;-webkit-border-bottom-right-radius:4px}.ui-corner-top{-moz-border-radius-topleft:4px;-webkit-border-top-left-radius:4px;-moz-border-radius-topright:4px;-webkit-border-top-right-radius:4px}.ui-corner-bottom{-moz-border-radius-bottomleft:4px;-webkit-border-bottom-left-radius:4px;-moz-border-radius-bottomright:4px;-webkit-border-bottom-right-radius:4px}.ui-corner-right{-moz-border-radius-topright:4px;-webkit-border-top-right-radius:4px;-moz-border-radius-bottomright:4px;-webkit-border-bottom-right-radius:4px}.ui-corner-left{-moz-border-radius-topleft:4px;-webkit-border-top-left-radius:4px;-moz-border-radius-bottomleft:4px;-webkit-border-bottom-left-radius:4px}.ui-corner-all{-moz-border-radius:4px;-webkit-border-radius:4px}.ui-widget-overlay{background:#666 url(/sites/default/themes/ueb/piemovible/images/ui-bg_diagonals-thick_20_666666_40x40.png) 50% 50% repeat;opacity:.50;filter:Alpha(Opacity=50)}.ui-widget-shadow{margin:-5px 0 0 -5px;padding:5px;background:#000 url(/sites/default/themes/ueb/piemovible/images/ui-bg_flat_10_000000_40x100.png) 50% 50% repeat-x;opacity:.20;filter:Alpha(Opacity=20);-moz-border-radius:5px;-webkit-border-radius:5px}#footMenuBar{position:fixed;bottom:0;width:960px;height:40px;margin-bottom:-40px}.redes_institucionales #footMenuBar>#footContainer{margin-left:auto;margin-right:auto;padding:5px 0;float:right;margin-right:-200px;overflow:hidden;width:200px;background-color:#eb8906;z-index:10080}.redes_bienestar #footMenuBar>#footContainer{margin-left:auto;margin-right:auto;padding:5px 0;float:right;margin-right:-200px;overflow:hidden;width:200px;background-color:#91b415;z-index:10080}#footMenuBar>#footContainer div{display:inline-block;margin:0;padding:0 5px 0 5px;margin-right:10px;float:left}#pie #footMenuBar>#footContainer div{height:25px}.redes_institucionales #pestana{background-color:#f7930c;border-top:1px solid #d47907;border-right:1px solid #e98908;border-bottom:1px solid #dc8005;border-left:1px solid #e98908;bottom:35px;margin:0;padding:0;height:34px;width:198px;text-align:center;letter-spacing:.1em;position:relative;float:right;font-weight:bold;font-size:1.3em;color:#fff;z-index:10080}.redes_bienestar #pestana{background-color:#9bbe1f;border-top:1px solid #81a405;border-right:1px solid #91b415;border-bottom:1px solid #87aa0b;border-left:1px solid #91b415;bottom:35px;margin:0;padding:0;height:34px;width:198px;text-align:center;letter-spacing:.1em;position:relative;float:right;font-weight:bold;font-size:1.3em;color:#fff;z-index:10080}.redes_institucionales #pestana_span{border-top:solid 1px #ffb556;line-height:34px}.redes_bienestar #pestana_span{border-top:solid 1px #badd3e;line-height:34px}#block-block-10{margin-top:-25px}#admisiones{height:auto;margin:0 0 210px;font-size:.9em;font-weight:normal}
#admisiones table{border-collapse:inherit}#admisiones td{padding:0;margin:0}#admisiones table td .contenido{padding-left:5px}#admisiones table td .contenido ul{padding-left:12px;list-style-type:disc}#admisiones #Layer1{position:absolute;top:0;width:200px;height:20px;border-bottom:2px solid;background-color:#f7b549;text-align:center;z-index:1;font-weight:bold}#admisiones #Layer1:hover{background-color:#FF9}#admisiones #dialogo{background-color:#f7b549;top:22px;left:0;width:200px;height:180px;position:absolute;text-align:center;display:none}#block-block-39{height:auto}#admisiones #dialogo-chat{display:block;cursor:default;text-decoration:none;height:23px;color:#596221}.desplegable{font-weight:bold;font-size:1.0em;line-height:30px;border-bottom:#8aaa1c solid 1px;background:url(/sites/default/themes/ueb/styles/.misc/menu-collapsed.png) no-repeat scroll 5px 50% transparent}.desplegable .desplegable{border-bottom:0}#costosyrequisitos tbody tr td{padding-left:5px;line-height:normal}.desplegable table{border-collapse:inherit;background-color:#e8ecd2;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}.desplegable table table{border:#8aaa1c solid 1px;width:100%;background-color:#FFF;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}.desplegable table table .titular{border-bottom:#e8ecd2 solid 1px;color:#8aaa1c;font-size:.75em;text-align:center;padding-right:4px}.desplegable table table .subtitular{vertical-align:top;text-align:right;font-weight:bold;font-size:.75em;padding-right:4px;border-right:#e8ecd2 1px solid}.desplegable table table .contenido{border-bottom:1px solid #e8ecd2;font-weight:normal}.desplegable table .tablaenlace{background-color:#fff;width:100%;text-align:center}.desplegable table .tablaenlace .titular{border-bottom:0}.desplegable table .tablaenlace:hover{background-color:#8aaa1c;text-decoration:none;color:#FFF}.desplegable table .tablaenlace a{background-color:#fff;text-decoration:none;color:#8aaa1c}.desplegable table .tablaenlace:hover a{background-color:#8aaa1c;text-decoration:none;color:#FFF}.desplegable table table:hover{background-color:#FF9}.desplegable td{padding:0;margin:0}.desplegable table td .contenido{padding-left:5px}.desplegable table td .contenido ul{padding-left:12px;list-style-type:disc}.desplegable ul,ul{margin:0 0 10px;padding:0;line-heigth:20px}#uno,#dos,#tres,#cuatro{background-color:#fff}div>ul>a{display:block;cursor:default;text-decoration:none;height:23px;background-color:#fff;border-top:#8aaa1c solid 1px}div>ul>a:hover{background-color:#8aaa1c}div>ul>a>span{font-weight:bold;line-height:23px;margin-left:10px;color:#8aaa1c}div>ul>a:hover>span{color:#fff;margin-left:10px}div>ul>a>div{min-width:200px;min-height:200px;height:auto;margin:0 0 10px;font-size:.9em;font-weight:normal;background-color:#e8ecd2;display:none}div#dos>a span{margin-left:10px}#dos>div{border-top:#8aaa1c solid 1px;margin-left:20px}#dos>a{display:block;cursor:default;text-decoration:none;height:23px;background-color:#fff;border-top:#8aaa1c solid 1px}#dos>a span{color:#8aaa1c}body .cajon>.contenedor>#grueso>#node-238,body .cajon>.contenedor>#grueso>#node-240,body .cajon>.contenedor>#grueso>#node-241,body .cajon>.contenedor>#grueso>.estimulos{padding:0;margin-bottom:10px;border:0;background:0}body .cajon>.contenedor>#grueso>#node-238>h2,body .cajon>.contenedor>#grueso>#node-240>h2,body .cajon>.contenedor>#grueso>#node-241>h2,body .cajon>.contenedor>#grueso>.estimulos>h2{padding:20px 20px 0 20px;border-top:0;border-right:solid 1px #e3e8cc;border-bottom:0;border-left:solid 1px #e3e8cc;background-color:#fff}.field-field-inscrp-imagen-encabezado .field-items,.field-field-financia-imagen-encabezado .field-items,.field-field-estimulos-imagen-encabezado .field-items{padding:0 20px 0 20px;border-top:0;border-right:solid 1px #e3e8cc;border-bottom:0;border-left:solid 1px #e3e8cc;background-color:#fff}body .cajon>.contenedor>#grueso>#node-238>.content>p,body .cajon>.contenedor>#grueso>#node-240>.content>.group-financia-encabezado,body .cajon>.contenedor>#grueso>#node-241>.content>p,body .cajon>.contenedor>#grueso>.estimulos>.content>p{padding:0 20px 20px 20px;margin-bottom:20px;border-top:0;border-right:solid 1px #e3e8cc;border-bottom:solid 2px #e3e8cc;border-left:solid 1px #e3e8cc;background-color:#fff}
body .cajon #grueso>#node-238>.content>#tabs-tabset>ul,body .cajon #grueso>#node-240>.content>#tabs-tabset>ul,body .cajon #grueso>#node-241>.content>#tabs-tabset>ul,body .cajon #grueso>.estimulos>.content>#tabs-tabset>ul{margin:0;padding:0;border:0}#tabs-tabset span.clear{height:0;margin:0;margin-top:4px}body .cajon #grueso>#node-238 #modo-en-l-nea,body .cajon #grueso>#node-238 #modo-presencial{padding:30px 10px 10px 10px;background-color:#fff;border-top:0;border-right:solid 1px #e3e8cc;border-bottom:solid 2px #e3e8cc;border-left:solid 1px #e3e8cc}body .cajon #grueso>#node-238 #modo-en-l-nea>table,body .cajon #grueso>#node-238 #modo-presencial>table{padding:10px;display:block;border-top:2px solid #eef1e1;background-color:#f7f9f3}body .cajon #grueso>#node-238 #modo-en-l-nea tbody,body .cajon #grueso>#node-238 #modo-presencial tbody{border:0}body .cajon #grueso>#node-238 #modo-en-l-nea tr,body .cajon #grueso>#node-238 #modo-presencial tr{background-color:#fff;border-bottom:solid 2px #eef1e1}body .cajon #grueso>#node-238 #modo-en-l-nea td,body .cajon #grueso>#node-238 #modo-presencial td{margin:0;padding:10px}body .cajon #grueso>#node-238 #modo-en-l-nea td label,body .cajon #grueso>#node-238 #modo-presencial td label{display:block;width:20px;height:20px;float:left;border-top:solid 2px #eef1e1;background-color:#f7f9f3;text-align:center;line-height:20px;margin-right:10px}body .cajon #grueso>#node-238 #modo-en-l-nea td .field-label,body .cajon #grueso>#node-238 #modo-presencial td .field-label,body .cajon #grueso>#node-240>.content>.group-financia-encabezado .field-label,body .cajon #grueso>#node-240>.content>.group-financia-encabezado legend,.field-field-inscrp-imagen-encabezado .field-label,.field-field-financia-imagen-encabezado .field-label,.field-field-estimulos-imagen-encabezado .field-label{display:none}body .cajon #grueso>#node-238 #modo-en-l-nea td .field-field-inscrp-online-paso .field-items,body .cajon #grueso>#node-238 #modo-presencial td .field-field-inscrp-offline-paso .field-items{color:#88ab0c;font-size:1.3em;height:20px;line-height:30px;vertical-align:bottom}#node-238 .content-multigroup-display-table-single-column .field-type-text{margin-bottom:10px;float:none;font-size:1.2em;line-height:1.2em;width:auto;margin-left:30px}#node-238 .content-multigroup-display-table-single-column .field-type-link{margin-left:30px}.content-multigroup-wrapper:hover .field-type-link a{color:#eb8906}#node-238 .content-multigroup-display-table-single-column .field-type-text ul{margin-top:0}#node-238 .content-multigroup-display-table-single-column .field-type-text h6{margin:0;font-weight:normal;font-size:1em}#calculadora_de_credito{padding:10px 0 10px 20px;float:left;width:60%}#grueso #calculadora_de_credito .etiqueta_seccion{display:block;font-size:.8em;margin-left:5px}#grueso #calculadora_de_credito #numcuotas{font-size:.8em}#grueso #calculadora_de_credito form{padding:5px;margin-bottom:0;border:0;background-color:#c3c5b1;-moz-border-radius:5px;border-radius:5px}#grueso #calculadora_de_credito .cuotas{float:left;width:47%}#grueso #calculadora_de_credito .cuotas select{width:150px;margin-left:20px}#grueso #calculadora_de_credito div{background-color:#b6b9a1;margin:0 0 5px;padding:5px}#grueso input#calcular{font-family:"PTSansRegular";line-height:25px;text-align:center;margin:5px 0 0 0;padding:3px 3px 1px 3px;height:25px;border-top:1px solid #dde2bc;border-right:1px solid #dde2bc;border-bottom:1px solid #dde2bc;border-left:1px solid #dde2bc;-moz-border-radius:5px;border-bottom-radius:5px;width:100%}#grueso input#calcular:hover{border-top:1px solid #fff}#valor_matricula{display:block;text-align:right}#grueso p#textolegal{background:0;padding:10px;float:left;width:30%;margin-left:20px}#grueso #calculadora_de_credito tbody{border:0}#grueso #calculadora_de_credito form>div:first-child{background-color:#eff2dc;font-size:1.7em;text-align:right;padding:10px}
#node-240 #con-la-universidad,#node-240 #con-otras-entidades,#node-240 #con-el-icetex,#node-801 #el-bosque-university-loans,#node-801 #financing-with-other-institutions,#node-801 #financing-with-the-icetex,#node-954 #modalit-s-de-financement-avec-l-universit-,#node-954 #modalit-s-de-financement-avec-d-autres-institutions,#node-954 #avec-l-icetex{padding:30px 20px 20px 20px;background-color:#fff;border-top:0;border-right:solid 1px #e3e8cc;border-bottom:solid 2px #e3e8cc;border-left:solid 1px #e3e8cc}#node-240 #tabs-tabset #con-la-universidad .field-field-financia-nuevos,#node-240 #tabs-tabset #con-la-universidad .field-field-financia-antiguos{width:44%;float:left;border:solid 10px #eef1e1;background-color:#f7f9f3;padding:5px;position:relative}#node-240 #tabs-tabset .tabs-tabset .field-type-text{border-top:solid 2px #eef1e1;background-color:#f7f9f3;padding:5px;overflow:hidden;width:98.5%}#node-240 #tabs-tabset #con-la-universidad .field-field-financia-antiguos{float:right}ul.primary{line-height:inherit}body .cajon>.contenedor>#grueso>.estimulos #becas,body .cajon>.contenedor>#grueso>.estimulos #scholarships,body .cajon>.contenedor>#grueso>.estimulos #est-mulos,body .cajon>.contenedor>#grueso>.estimulos #stimuli,body .cajon>.contenedor>#grueso>.estimulos #bourses-d-039-tudes{padding:0 20px;background-color:#fff;border-top:0;border-right:solid 1px #e3e8cc;border-bottom:solid 2px #e3e8cc;border-left:solid 1px #e3e8cc}body .cajon>.contenedor>#grueso>#node-241 #becas .field-label,body .cajon>.contenedor>#grueso>#node-241 #est-mulos .field-label,body .cajon>.contenedor>#grueso>.estimulos #becas .field-label,body .cajon>.contenedor>#grueso>.estimulos #scholarships .field-label,body .cajon>.contenedor>#grueso>.estimulos #bourses-d-039-tudes .field-label,body .cajon>.contenedor>#grueso>.estimulos #est-mulos .field-label,body .cajon>.contenedor>#grueso>.estimulos #stimuli .field-label{display:none}#grueso #node-241 div fieldset.collapsible legend a,#grueso .estimulos div fieldset.collapsible legend a{font-size:1.2em;width:100%}#grueso #node-241 div fieldset.collapsible .fieldset-wrapper,#grueso .estimulos div fieldset.collapsible .fieldset-wrapper{padding-left:30px}#grueso #node-241 div fieldset.collapsible .fieldset-wrapper>div,#grueso .estimulos div fieldset.collapsible .fieldset-wrapper>div{padding:0;width:100%;margin-bottom:0;padding-bottom:10px;border-bottom:0}body .cajon>.contenedor>#grueso>#node-241 #becas .fieldset-wrapper h3,body .cajon>.contenedor>#grueso>#node-241 #est-mulos .fieldset-wrapper h3,body .cajon>.contenedor>#grueso>.estimulos #becas .fieldset-wrapper h3,body .cajon>.contenedor>#grueso>.estimulos #scholarships .fieldset-wrapper h3,body .cajon>.contenedor>#grueso>.estimulos #bourses-d-039-tudes .fieldset-wrapper h3,body .cajon>.contenedor>#grueso>.estimulos #est-mulos .fieldset-wrapper h3,body .cajon>.contenedor>#grueso>.estimulos #stimuli .fieldset-wrapper h3{margin:5px 0 5px 0;color:#eb8906;font-size:1.0em}body .cajon>.contenedor>#grueso>#node-241 #becas .fieldset-wrapper h4,body .cajon>.contenedor>#grueso>#node-241 #est-mulos .fieldset-wrapper h4,body .cajon>.contenedor>#grueso>.estimulos #becas .fieldset-wrapper h4,body .cajon>.contenedor>#grueso>.estimulos #scholarships .fieldset-wrapper h4,body .cajon>.contenedor>#grueso>.estimulos #bourses-d-039-tudes .fieldset-wrapper h4,body .cajon>.contenedor>#grueso>.estimulos #est-mulos .fieldset-wrapper h4,body .cajon>.contenedor>#grueso>.estimulos #stimuli .fieldset-wrapper h4{margin:0}body .cajon>.contenedor>#grueso>#node-241 #becas .fieldset-wrapper ul,body .cajon>.contenedor>#grueso>#node-241 #est-mulos .fieldset-wrapper ul,body .cajon>.contenedor>#grueso>.estimulos #becas .fieldset-wrapper ul,body .cajon>.contenedor>#grueso>.estimulos #scholarships .fieldset-wrapper ul,body .cajon>.contenedor>#grueso>.estimulos #bourses-d-039-tudes .fieldset-wrapper ul,body .cajon>.contenedor>#grueso>.estimulos #est-mulos .fieldset-wrapper ul,body .cajon>.contenedor>#grueso>.estimulos #stimuli .fieldset-wrapper ul{margin:0 0 10px 0;font-size:.9em;line-height:1.1em}body .cajon>.contenedor>#grueso>#node-241 #becas .content-multigroup-4,body .cajon>.contenedor>#grueso>#node-241 #est-mulos .content-multigroup-5,body .cajon>.contenedor>#grueso>.estimulos #becas .content-multigroup-4,body .cajon>.contenedor>#grueso>.estimulos #scholarships .content-multigroup-4,body .cajon>.contenedor>#grueso>.estimulos #bourses-d-039-tudes .content-multigroup-4,body .cajon>.contenedor>#grueso>.estimulos #est-mulos .content-multigroup-5,body .cajon>.contenedor>#grueso>.estimulos #stimuli .content-multigroup-5{border-bottom:0}form[action="/node/241/edit"] table,form[action="/node/802/edit"] table,form[action="/node/1036/edit"] table{width:100%}.inscripciones>div>.drupal-tabs.js-hide.tabs-processed,.financiacion>div>.drupal-tabs.js-hide.tabs-processed,.estimulos>div>.drupal-tabs.js-hide.tabs-processed{width:720px}.inscripciones>div>.drupal-tabs.js-hide.tabs-processed table,.estimulos>div>.drupal-tabs.js-hide.tabs-processed table{width:auto}
.view .attachment .view-content>.view-header{display:none}.view-centro-de-actualizacion-de-datos.view-display-id-page .view-header p{margin:0;padding:20px;background-color:#fff;font-size:1.6em;text-align:center}#grueso .view-centro-de-actualizacion-de-datos tbody tr td{padding:0}.view .attachment .view-content{text-align:center;height:auto;background-color:#fff;margin-bottom:10px;padding-bottom:10px}.view .attachment .view-content span{border-top:solid 1px #e8ecce;border-right:solid 1px #fff;border-bottom:solid 1px #e8ecce;border-left:solid 1px #e8ecce;margin:0;padding:6px;text-align:center;font-size:xx-small;color:#000;}.view .attachment .view-content span:last-child{border-right:solid 1px #e8ecce}.view .attachment .view-content span:hover{background:0}.view .attachment .view-content span a{font-size:medium;font-weight:bold;vertical-align:middle;color:#88ab0c}.view .attachment .view-content span a.active{font-size:medium;font-weight:bold;vertical-align:middle;color:#eb8906}.view.view-centro-de-actualizacion-de-datos .node .group-programa-generalidades legend,.view.view-centro-de-actualizacion-de-datos .node .group-programa-generalidades .field-field-datoprograma-tipo .field-label,.view.view-centro-de-actualizacion-de-datos .node .group-programa-generalidades .field-field-datoprograma-ruta .field-label{display:none}.view.view-centro-de-actualizacion-de-datos .node .group-programa-generalidades .field-field-datoprograma-tipo .field-items{font-weight:bold;font-size:1.2em;margin:10px 0 5px 0;text-align:center;margin-left:-20%}.view.view-centro-de-actualizacion-de-datos .node .group-programa-admisiones legend{visibility:hidden}.view.view-centro-de-actualizacion-de-datos .node .group-programa-generalidades .field-field-datoprograma-ruta .field-items{margin:0 0 10px 0;text-align:center;margin-left:-20%}#grueso .view.view-centro-de-actualizacion-de-datos .node .field-items ul,#grueso .view.view-centro-de-actualizacion-de-datos .node .field-items p,#grueso .view.view-centro-de-actualizacion-de-datos .node .field-field-datoprograma-registro .field-item,#grueso .view.view-centro-de-actualizacion-de-datos .node .field-field-horario-especial .field-item{padding:0;margin-left:40%}#grueso .view.view-centro-de-actualizacion-de-datos .node .field-items li ul{padding:0;margin:0}.view.view-centro-de-actualizacion-de-datos .node .field-label,.view.view-centro-de-actualizacion-de-datos .node .field-label-inline-first{float:left;width:40%;text-align:right}.view.view-centro-de-actualizacion-de-datos .node .field{margin:5px 0}.field-field-cartelera-cultural-imagen,.field-field-cartelera-deportiva-imagen{background-color:#88ab0c;float:left;margin-right:10px}.field-field-cartelera-cultural-imagen:hover,.field-field-cartelera-deportiva-imagen:hover{background-color:#df7e00}a.imagefield-lightbox2-miniatura_cartelera{display:block;padding:5px 5px 0 5px}#grueso .field-field-cartelera-deportiva-imagen{float:left;width:auto;margin-right:20px}.container-inline-date form-item date-clear-block{float:left;margin-right:20px;width:45%}#edit-field-cartelera-deportiva-fecha-0-value-datepicker-popup-0-wrapper,#edit-field-cartelera-deportiva-fecha-0-value-timeEntry-popup-1-wrapper{width:100%}#edit-field-cartelera-deportiva-lugar-0-value-wrapper{width:50%;float:left}#edit-field-cartelera-deportiva-descri-0-value-wrapper{clear:both}.field-field-cartelera-deportiva-fecha{font-size:1.2em;margin-top:20px}.field-field-cartelera-deportiva-lugar{font-size:1.2em;margin:20px 0}.maestria>div>div .field-label,.maestria>div>fieldset>legend{display:block;width:666px;padding:5px;font-size:1.1em;font-weight:normal;color:#df7e00;border-top:2px solid #edf0df;border-right:solid 1px #edf0df;border-left:solid 1px #edf0df;background-color:#f7f9ec}.maestria>div>div.field-type-text,.maestria>div>fieldset{margin-top:30px}.maestria>div>div .field-item{margin-top:10px}.maestria>h2{padding:10px 10px 0;border-top:1px solid #e3e8cc;background-color:#f7f9ec}.maestria>h2{font-size:1.4em}.maestria .group-maestria-oferta{background-color:#f7f9ec;margin:0}
.maestria .field-field-maestria-titulo-obtenido{padding:5px 10px;background:0}.maestria .field-field-maestria-titulo-obtenido .field-label{float:left;font-weight:normal;color:#88ab0c}.maestria .group-maestria-normatividad{padding:4px 10px;border-bottom:1px solid #e3e8cc;margin:0}.maestria .group-maestria-normatividad div{float:left;font-size:.9em;line-height:1em}.maestria .group-maestria-normatividad div.field-label{font-weight:normal;color:#df7e00}.maestria .group-maestria-normatividad div.field-items{font-weight:bold;margin-right:20px}#grueso .maestria .group-maestria-generalidades p{margin:0}.maestria .group-maestria-generalidades>div>div{padding-bottom:10px;padding-right:10px}.maestria .group-maestria-generalidades{margin-bottom:30px;padding-top:20px;background-color:#f7f9ec;margin:0}.maestria .group-maestria-generalidades .field-label{float:left;width:150px;text-align:right;color:#df7e00;font-weight:normal}.maestria .field-field-maestria-imagen-promo{margin:20px 20px 0 0;float:left}.maestria .group-maestria-generalidades .field-items{display:table}.maestria .field-field-maestria-organizador a:after{content:" \00BB"}.maestria .field-field-maestria-organizador a{color:#596221}.maestria .field-field-maestria-organizador a:hover{color:#df7e00}.maestria .group-maestria-generalidades .field-field-maestria-inicioadmision .field-items{padding:0}.maestria .group-maestria-generalidades .field-field-maestria-inicioadmision div{width:100%;text-align:center}#grueso .maestria .group-maestria-generalidades ul{margin:0;padding:0}#grueso .maestria .group-maestria-generalidades li{margin-left:15px}.maestria .field-field-maestria-inicioadmision{background-color:#f1f4e2}.maestria .group-maestria-cita{width:200px;text-align:right;padding:10px;font-size:1.1em;float:left;margin-right:20px;background-color:#ffff9d;border:2px solid #e3e8cc}.maestria .group-maestria-cita .field-field-maestria-cita-comentario .field-item:before{content:url("/sites/default/themes/ueb/images/comillas-abren.png");display:inline}.maestria .group-maestria-cita .field-field-maestria-cita-comentario .field-item:after{content:url("/sites/default/themes/ueb/images/comillas-cierran.png");display:inline}.maestria .group-maestria-cita .field-field-maestria-cita-autor{font-weight:bold;font-size:.8em;margin-top:10px;line-height:1em}.maestria .group-maestria-cita .field-field-maestria-cita-autor-cargo{font-size:.8em;line-height:1em}.group-maestria-cita.collapsible{background-color:#ffff9d}.maestria .content-multigroup-group-maestria-contacto{background-color:#e3e8cc;margin-top:20px;padding:10px 20px;font-size:.8em;line-height:1.2em;margin:20px -20px;overflow:hidden}.imagefield.imagefield-imagelink.imagefield-field_maestria_vcard{background:url("/sites/default/themes/ueb/images/vcard.png");width:21px;height:16px;display:block}.imagefield.imagefield-imagelink.imagefield-field_maestria_vcard:hover{background:url("/sites/default/themes/ueb/images/vcard-hover.png")}.maestria .content-multigroup-group-maestria-contacto .content-multigroup-wrapper{float:left;width:50%}.maestria .content-multigroup-group-maestria-contacto .content-multigroup-wrapper .field-field-maestria-vcard{float:left}#grueso .node.maestria .field-field-maestria-informes p{margin-left:30px}#grueso .maestria .field-field-maestria-informacion-persistente,#grueso .maestria>div .field-field-maestria-snies,#grueso .maestria>div .field-field-maestria-reg-calificado{background:0;font-size:.8em;margin-top:-10px}#grueso .maestria>div .field-field-maestria-snies,#grueso .maestria>div .field-field-maestria-snies div,#grueso .maestria>div .field-field-maestria-reg-calificado,#grueso .maestria>div .field-field-maestria-reg-calificado div{display:inline-block}#grueso .maestria .group-maestria-infolegal{margin-top:0;text-align:center}.content-multigroup-group-maestria-programa .field-field-maestria-programa-titulo{font-weight:bold}#grueso .maestria .field-field-maestria-programa-contenido p{margin-left:15px}#grueso .maestria .group-maestria-semestres p{margin:0 0 0 10px}#grueso .maestria .group-maestria-semestres .field-type-text{margin-top:10px}#grueso .container-inline-date{float:left;clear:none;margin-right:20px;width:45%}
#grueso .node.congreso .field-field-evento-fecha,#grueso .node.congreso .field-field-evento-lugar,#grueso .node..evento_profesional .field-field-evento-fecha{color:#000;font-family:'Georgia';float:left}#grueso .field-field-evento-lugar{text-align:left;margin-bottom:25px}#grueso .node.congreso .field-type-datestamp .field-field-evento-fecha,#grueso .node..evento_profesional .field-type-datestamp .field-field-evento-fecha{float:none}#grueso .field-field-evento-organizador .field-label{display:none}#grueso .node .content .field-field-evento-organizador p{margin:0;font-size:.8em;line-height:1em;padding:5px 0;text-align:right;margin-bottom:10px}#grueso .content-multigroup-group-evento-programa legend{font-weight:bold;padding:0;padding-top:10px}#grueso .content-multigroup-group-evento-programa table{border:0;border-collapse:inherit}#grueso .content-multigroup-group-evento-programa{width:100%}#grueso .content-multigroup-cell-field-evento-hora{width:120px;text-align:right}#grueso .content-multigroup-display-table-single-column .content-multigroup-wrapper .field{margin-right:10px}#grueso .content-multigroup-display-table-single-column .content-multigroup-wrapper td{padding:10px 0 10px 0}.content-multigroup-group-evento-programa .field-label{display:none}.content-multigroup-group-evento-programa .field-field-evento-hora{width:20%;text-align:right}.content-multigroup-group-evento-programa .field-field-evento-tema{width:70%;font-size:1.4em;color:#000}.content-multigroup-group-evento-programa .field-field-evento-tema-encargado{margin-left:20%;padding:5px 0 0 10px}.content-multigroup-group-evento-programa .field-field-evento-programa-lugar{padding:5px 0 0 10px}#grueso .content-multigroup-group-evento-programa .field-field-evento-programa-descripcion{margin-left:20%;padding:0 0 0 10px;margin-top:10px;font-size:1.2em;line-height:1.2em}.content-multigroup-group-evento-programa tr{background-color:#FFF;border:0}#grueso .node.congreso .field-field-evento-fecha .field-label,#grueso .node.congreso .field-field-evento-lugar .field-label,#grueso .node.evento_profesional .field-field-evento-fecha .field-label{display:none}#grueso .field-field-evento-imagen .field-label{display:none}#grueso .field-field-evento-descripcion .field-label{display:none}#grueso .field.field-type-filefield.field-field-evento-imagen,#grueso .field.field-type-filefield.field-field-convocatoria-imagen{float:left;margin:0 10px 10px 0}#grueso .field-field-afiche-evento .field-items img{width:290px;height:160px;float:left;margin:0 10px 0 0}#grueso .field-field-dirigido-a{clear:both}.node-type-evento #grueso .field-field-evento-teaser{font-size:1.2em;line-height:1.2em;margin:10px 0}.field-field-evento-educ-tema-central .field-item{font-size:1.4em;line-height:1em;margin-top:5px;margin-bottom:15px}#grueso .field-field-evento-educ-fecha,#grueso .field-field-evento-educ-lugar{color:#000;font-family:'Georgia';margin-bottom:25px}#grueso .field-field-evento-educ-organizador{margin-bottom:25px}#grueso .node .content .field-field-evento-educ-tema-central p{border-bottom:2px solid #88ab0c;font-size:1.3em;color:#eb8906;margin:0;padding:5px 0}#grueso .field-field-evento-educ-fecha{float:left}#grueso .field-field-evento-educ-lugar{text-align:right}#grueso .field-field-evento-educ-organizador .field-label{display:none}#grueso .node .content .field-field-evento-educ-organizador p{margin:0;font-size:.8em;line-height:1em;padding:5px 0;text-align:right;margin-bottom:10px}#grueso .field-field-evento-educ-dirigidoa{clear:both}#grueso .content-multigroup-group-evento-educ-programa legend{font-weight:bold;padding:0;padding-top:10px}#grueso .content-multigroup-group-evento-educ-programa table{border:0;border-collapse:inherit;margin-bottom:40px}#grueso .content-multigroup-group-evento-educ-programa{width:100%}#grueso .content-multigroup-cell-field-evento-educ-hora{width:120px;text-align:right}#grueso .content-multigroup-display-table-single-column .content-multigroup-wrapper .field.field-field-evento-educ-dia{width:100%;color:#eb8906;border-bottom:2px solid #eb8906;font-family:'PTSansNarrow';text-align:center;float:inherit;margin-right:0;height:30px;line-height:30px;font-size:1.2em;margin-bottom:10px}
.content-multigroup-group-evento-educ-programa .field-field-evento-educ-hora{width:25%;text-align:right}.content-multigroup-group-evento-educ-programa .field-field-evento-educ-tema{width:70%;font-size:1.2em;color:#000}.content-multigroup-group-evento-educ-programa .field-field-evento-educ-tema-encargado,.content-multigroup-group-evento-educ-programa .field-field-evento-educ-programa-lugar{margin-left:25%;padding-left:10px}.content-multigroup-group-evento-educ-programa .field-field-evento-educ-programa-lugar{padding:5px 0 0 10px}#grueso .content-multigroup-group-evento-educ-programa .field-field-evento-educ-programa-descripcion{margin-left:25%;padding:0 0 0 10px;margin-top:10px;font-size:1.2em;line-height:1.2em}.content-multigroup-group-evento-educ-programa tr{background-color:#FFF;border:0}#grueso .field-field-evento-educ-fecha .field-label,#grueso .field-field-evento-educ-lugar .field-label{display:none}#grueso .field-field-evento-educ-imagen .field-label{display:none}#grueso .field-field-evento-educ-descripcion .field-label{display:none}#grueso .field.field-type-filefield.field-field-evento-educ-imagen{width:220px;height:160px;float:left;margin:0 10px 0 0}#grueso .field-field-afiche-evento-educ .field-items img{width:290px;height:160px;float:left;margin:0 10px 0 0}#grueso .field-field-dirigido-a,.field-field-evento-educ-organizador>.field-items{clear:both}.content-multigroup-group-evento-educ-conferencistas fieldset{margin-bottom:20px}.field-field-evento-educ-imagen-conferencista{float:left;margin-right:10px}.field-field-evento-educ-imagen-conferencista img{border-right:2px solid #eb8906}.field-field-evento-educ-conferencista-nombre p{font-size:1.3em;font-family:'PTSansNarrow';color:#eb8906;border-bottom:2px solid #eb8906}#grueso .container-inline-date{float:left;clear:none;margin-right:20px;width:45%}.field-field-congreso-tema-central .field-item{font-size:1.4em;line-height:1em;margin-top:5px;margin-bottom:15px}#grueso .field-field-congreso-fecha,#grueso .field-field-congreso-lugar{color:#000;font-family:'Georgia';margin-bottom:25px}#grueso .field-field-congreso-organizador{margin-bottom:25px}#grueso .node .content .field-field-congreso-tema-central p{border-bottom:2px solid #88ab0c;font-size:1.3em;color:#eb8906;margin:0;padding:5px 0}#grueso .field-field-congreso-fecha{float:left}#grueso .field-field-congreso-lugar{text-align:right}#grueso .field-field-congreso-organizador .field-label{display:none}#grueso .node .content .field-field-congreso-organizador p{margin:0;font-size:.8em;line-height:1em;padding:5px 0;text-align:right;margin-bottom:10px}#grueso .field-field-congreso-dirigidoa{clear:both}#grueso .content-multigroup-group-congreso-programa legend{font-weight:bold;padding:0;padding-top:10px}#grueso .content-multigroup-group-congreso-programa table{border:0;border-collapse:inherit;margin-bottom:40px}#grueso .content-multigroup-group-congreso-programa{width:100%}#grueso .content-multigroup-cell-field-congreso-hora{width:120px;text-align:right}#grueso .content-multigroup-display-table-single-column .content-multigroup-wrapper .field.field-field-congreso-dia{width:100%;color:#eb8906;border-bottom:2px solid #eb8906;font-family:'PTSansNarrow';text-align:center;float:inherit;margin-right:0;height:30px;line-height:30px;font-size:1.2em;margin-bottom:10px}#grueso .content-multigroup-display-table-single-column .content-multigroup-wrapper .field{margin-right:10px;float:left}#grueso .content-multigroup-display-table-single-column .content-multigroup-wrapper td{padding:5px 0}.content-multigroup-group-congreso-programa .field-field-congreso-hora{width:25%;text-align:right}.content-multigroup-group-congreso-programa .field-field-congreso-tema{width:70%;font-size:1.2em;color:#000}.content-multigroup-group-congreso-programa .field-field-congreso-tema-encargado,.content-multigroup-group-congreso-programa .field-field-congreso-programa-lugar{margin-left:25%;padding-left:10px}.content-multigroup-group-congreso-programa .field-field-congreso-programa-lugar{padding:5px 0 0 10px}
#grueso .content-multigroup-group-congreso-programa .field-field-congreso-programa-descripcion{margin-left:25%;padding:0 0 0 10px;margin-top:10px;font-size:1.2em;line-height:1.2em}.content-multigroup-group-congreso-programa tr{background-color:#FFF;border:0}#grueso .field-field-congreso-fecha .field-label,#grueso .field-field-congreso-lugar .field-label{display:none}#grueso .field-field-congreso-imagen .field-label{display:none}#grueso .field-field-congreso-descripcion .field-label{display:none}#grueso .field.field-type-filefield.field-field-congreso-imagen{width:220px;height:160px;float:left;margin:0 10px 0 0}#grueso .field-field-afiche-congreso .field-items img{width:290px;height:160px;float:left;margin:0 10px 0 0}#grueso .field-field-dirigido-a,.field-field-congreso-organizador>.field-items{clear:both}.content-multigroup-group-congreso-conferencistas fieldset{margin-bottom:20px}.field-field-congreso-imagen-conferencista{float:left;margin-right:10px}.field-field-congreso-imagen-conferencista img{border-right:2px solid #eb8906}.field-field-congreso-conferencista-nombre p{font-size:1.3em;font-family:'PTSansNarrow';color:#eb8906;border-bottom:2px solid #eb8906}.especializacion>div>div .field-label,.especializacion .group-especial-semestres legend,.content-multigroup-group-especial-programa legend{display:block;width:666px;padding:5px;font-size:1.1em;font-weight:normal;color:#df7e00;border-top:2px solid #edf0df;border-right:solid 1px #edf0df;border-left:solid 1px #edf0df;background-color:#f7f9ec}.especializacion>div>div.field-type-text,.especializacion>div>fieldset{margin-top:30px}.especializacion>div>div .field-item{margin-top:10px}.especializacion>div>fieldset>legend{margin-bottom:10px}.especializacion>h2{padding:10px 10px 0;border-top:1px solid #e3e8cc;background-color:#f7f9ec}.especializacion>h2{font-size:1.4em}.especializacion .group-especial-oferta{background-color:#f7f9ec;margin:0}.especializacion .field-field-especial-titulo-obtenido{padding:5px 10px;background:0}.especializacion .field-field-especial-titulo-obtenido .field-label{float:left;font-weight:normal;color:#88ab0c}.especializacion .group-especial-normatividad{padding:4px 10px;border-bottom:1px solid #e3e8cc;margin:0}.especializacion .group-especial-normatividad div{float:left;font-size:.9em;line-height:1em}.especializacion .group-especial-normatividad div.field-label{font-weight:normal;color:#df7e00}.especializacion .group-especial-normatividad div.field-items{font-weight:bold;margin-right:20px}#grueso .especializacion .group-especial-generalidades p{margin:0}.especializacion .group-especial-generalidades>div>div{padding-bottom:10px;padding-right:10px}.especializacion .group-especial-generalidades{padding-top:20px;margin-bottom:30px;background-color:#f7f9ec;margin:0}.especializacion .group-especial-generalidades .field-label{float:left;width:150px;text-align:right;color:#df7e00;font-weight:normal}.especializacion .group-especial-generalidades .field-items{display:table}.especializacion .field-field-especial-organizador a:after{content:" \00BB"}.especializacion .field-field-especial-organizador a{color:#596221}.especializacion .field-field-especial-organizador a:hover{color:#df7e00}.especializacion .group-especial-generalidades .field-field-especial-inicioadmision .field-items{padding:0}#grueso .especializacion .group-especial-generalidades ul{margin:0;padding:0}#grueso .especializacion .group-especial-generalidades li{margin-left:15px}.field-type-link.field-field-especial-inicioadmision,.field-type-link.field-field-especial-enlace-calendario{float:right;margin:10px}.field-type-link.field-field-especial-inicioadmision a,.field-type-link.field-field-especial-enlace-calendario a{font-family:"PTSansRegular";text-align:center;margin:5px 0 0 0;padding:5px;border-top:1px solid #dde2bc;border-right:1px solid #dde2bc;border-bottom:1px solid #dde2bc;border-left:1px solid #dde2bc;-moz-border-radius:5px;border-bottom-radius:5px}
.field-type-link.field-field-especial-inicioadmision a:hover,.field-type-link.field-field-especial-enlace-calendario a:hover{padding:4px 5px 6px}.especializacion .group-especial-cita{width:200px;text-align:right;padding:10px;font-size:1.1em;float:left;margin-right:20px;background-color:#ffff9d;border:2px solid #e3e8cc}.especializacion .group-especial-cita .field-field-especial-cita-comentario .field-item:before{content:url(/sites/default/themes/ueb/images/comillas-abren.png);display:inline}.especializacion .group-especial-cita .field-field-especial-cita-comentario .field-item:after{content:url(/sites/default/themes/ueb/images/comillas-cierran.png);display:inline}.especializacion .group-especial-cita .field-field-especial-cita-autor{font-weight:bold;font-size:.8em;margin-top:10px;line-height:1em}.especializacion .group-especial-cita .field-field-especial-cita-autor-cargo{font-size:.8em;line-height:1em}.group-especial-cita.collapsible{background-color:#ffff9d}.especializacion .content-multigroup-group-especial-contacto{background-color:#e3e8cc;margin-top:20px;padding:10px 20px;font-size:.8em;line-height:1.2em;margin:20px -20px;overflow:hidden}.imagefield.imagefield-imagelink.imagefield-field_especial_vcard{background:url(/sites/default/themes/ueb/images/vcard.png);width:21px;height:16px;display:block}.imagefield.imagefield-imagelink.imagefield-field_especial_vcard:hover{background:url(/sites/default/themes/ueb/images/vcard-hover.png)}.especializacion .content-multigroup-group-especial-contacto .content-multigroup-wrapper{float:left;width:50%}.especializacion .content-multigroup-group-especial-contacto .content-multigroup-wrapper .field-field-especial-vcard{float:left}.imagefield.imagefield-imagelink.imagefield-field_especial_vcard img{display:none}#grueso .node.especializacion .field-field-especial-informes .field-label{display:none}#grueso .node.especializacion .field-field-especial-informes p{margin-left:30px}#grueso .especializacion .field-field-especial-informacion-persistente,#grueso .especializacion>div .field-field-especial-snies,#grueso .especializacion>div .field-field-especial-reg-calificado{background:0;font-size:.8em;margin-top:-10px}#grueso .especializacion>div .field-field-especial-snies,#grueso .especializacion>div .field-field-especial-snies div,#grueso .especializacion>div .field-field-especial-reg-calificado,#grueso .especializacion>div .field-field-especial-reg-calificado div{display:inline-block}#grueso .especializacion .group-especial-infolegal{margin-top:0;text-align:center}.content-multigroup-group-especial-programa .field-field-especial-programa-titulo{font-weight:bold}#grueso .especializacion .field-field-especial-programa-contenido p{margin-left:15px}.diplomado>div>div .field-label,.diplomado>div>fieldset>legend{display:block;width:666px;padding:5px;font-size:1.1em;font-weight:normal;color:#df7e00;border-top:2px solid #edf0df;border-right:solid 1px #edf0df;border-left:solid 1px #edf0df;background-color:#f7f9ec}.diplomado>div>fieldset>legend{margin-bottom:10px}.diplomado>div>div.field-type-text,.diplomado>div>fieldset{margin-top:30px}.diplomado .imagefield-field_diplomado_imagen_promo{float:left;margin-right:20px}.diplomado .field-field-diplomado-imagen{margin-top:-40px}.diplomado>h2{padding:10px 10px 0;border-top:2px solid #edf0df;border-right:solid 1px #edf0df;border-left:solid 1px #edf0df;background-color:#f7f9ec}.diplomado>h2{font-size:1.4em}#grueso .diplomado .group-diplomado-generalidades p{margin:0}.diplomado .group-diplomado-generalidades>div>div{padding-bottom:10px;padding-right:10px}.diplomado .group-diplomado-generalidades{margin-bottom:30px;border-right:solid 1px #edf0df;border-left:solid 1px #edf0df;background-color:#f7f9ec;margin-top:0;padding-top:20px}.diplomado .group-diplomado-generalidades .field-label{float:left;width:150px;text-align:right;color:#df7e00;font-weight:normal}.diplomado .group-diplomado-generalidades .field-items{display:table}.diplomado .field-field-diplomado-organizador a:after{content:" \00BB"}.diplomado .field-field-diplomado-organizador a{color:#596221}.diplomado .field-field-diplomado-organizador a:hover{color:#df7e00}#grueso .diplomado .group-diplomado-generalidades ul{margin:0;padding:0}#grueso .diplomado .group-diplomado-generalidades li{margin-left:15px}.diplomado .field-field-diplomado-nombre-modulo-1,.diplomado .field-field-diplomado-nombre-modulo-2,.diplomado .field-field-diplomado-nombre-modulo-3,.diplomado .field-field-diplomado-nombre-modulo-4,.diplomado .field-field-diplomado-nombre-modulo-5,.diplomado .field-field-diplomado-nombre-modulo-6,.diplomado .field-field-diplomado-nombre-modulo-7,.diplomado .field-field-diplomado-nombre-modulo-8,.diplomado .field-field-diplomado-nombre-modulo-9,.diplomado .field-field-diplomado-nombre-modulo-10{font-weight:bold;margin-left:40px}
.diplomado .field-field-diplomado-primer-modulo,.diplomado .field-field-diplomado-segundo-modulo,.diplomado .field-field-diplomado-tercer-modulo,.diplomado .field-field-diplomado-cuarto-modulo,.diplomado .field-field-diplomado-quinto-modulo,.diplomado .field-field-diplomado-sexto-modulo,.diplomado .field-field-diplomado-septimo-modulo,.diplomado .field-field-diplomado-octavo-modulo,.diplomado .field-field-diplomado-noveno-modulo,.diplomado .field-field-diplomado-decimo-modulo{margin-left:60px;margin-bottom:10px}.field-field-diplomado-otra-informacion{padding-left:150px}.diplomado .content-multigroup-group-diplomado-contacto{background-color:#e3e8cc;margin-top:20px;padding:10px 20px;font-size:.8em;line-height:1.2em;margin:20px -20px;overflow:hidden}.imagefield.imagefield-imagelink.imagefield-field_diplomado_vcard{background:url(/sites/default/themes/ueb/images/vcard.png);width:21px;height:16px;display:block}.imagefield.imagefield-imagelink.imagefield-field_diplomado_vcard:hover{background:url(/sites/default/themes/ueb/images/vcard-hover.png)}.diplomado .content-multigroup-group-diplomado-contacto .content-multigroup-wrapper{float:left;width:50%}.diplomado .content-multigroup-group-diplomado-contacto .content-multigroup-wrapper .field-field-diplomado-vcard{float:left}.imagefield.imagefield-imagelink.imagefield-field_diplomado_vcard img{display:none}#grueso .node.diplomado .field-field-diplomado-informes .field-label{display:none}#grueso .node.diplomado .field-field-diplomado-informes p{margin-left:30px}.content-multigroup-group-diplomado-programa .field-field-diplomado-programa-titulo{font-weight:bold}#grueso .diplomado .field-field-diplomado-programa-contenido p{margin-left:15px}#grueso .diplomado .field-field-diplomado-informacion-persistente{margin-top:0;text-align:center;font-size:.8em}.enlace-pestana{display:block;text-align:center;text-decoration:none}#grueso .diplomado fieldset .field-field-diplomado-enlace-fb,#grueso .diplomado fieldset .field-field-diplomado-enlace-twitt,#grueso .diplomado fieldset .field-field-diplomado-enlace-blog,#grueso .diplomado fieldset .field-field-diplomado-enlace-aula,#grueso .diplomado fieldset .field-field-diplomado-enlace-faq,#grueso .diplomado fieldset .field-field-diplomado-enlace-registro{display:block;float:right}.field-field-diplomado-enlace-fb,.field-field-diplomado-enlace-twitt,.field-field-diplomado-enlace-blog,.field-field-diplomado-enlace-faq,.field-field-diplomado-enlace-aula,.field-field-diplomado-enlace-registro{float:right;bottom:0;padding-right:5px}.diplomado>div>.fieldgroup.group-diplomado-enlaces{float:right;width:676px;padding:15px 0;margin:0;background-color:#f7f9ec;border-left:1px solid #edf0df;border-right:1px solid #edf0df}.diplomado .field-field-diplomado-enlace-fb .field-item,.diplomado .field-field-diplomado-enlace-twitt .field-item,.diplomado .field-field-diplomado-enlace-blog .field-item,.diplomado .field-field-diplomado-enlace-faq .field-item,.diplomado .field-field-diplomado-enlace-aula .field-item,.diplomado .field-field-diplomado-enlace-registro .field-item{margin:0}.standard>.group-diplomado-enlaces{position:inherit}#node-1126 h2,#node-1101 h2,#node-544 h2,#node-457 h2{display:none}.diplomado .field-field-evento-fecha .date-display-start:before,.diplomado .field-field-evento-fecha .date-display-single:before{content:"Inicia el "}.diplomado .field-field-evento-fecha .date-display-separator{display:none}.diplomado .field-field-evento-fecha .date-display-end:before{content:" y finaliza el "}.curso_corto>div>div .field-label,.curso_corto>div>fieldset>legend{display:block;width:666px;padding:5px;font-size:1.1em;font-weight:normal;color:#df7e00;border-top:2px solid #edf0df;border-right:solid 1px #edf0df;border-left:solid 1px #edf0df;background-color:#f7f9ec}.curso_corto>div>fieldset>legend{margin-bottom:10px}.curso_corto>div>div.field-type-text,.curso_corto>div>fieldset{margin-top:30px}.curso_corto>div>div .field-item{margin-top:10px}.curso_corto .imagefield-field_curso_corto_imagen_promo{float:left;margin-right:20px}
.curso_corto>h2{padding:10px 10px 0;border-top:1px solid #e3e8cc;background-color:#f7f9ec}.curso_corto>h2{font-size:1.4em}#grueso .curso_corto .group-curso-corto-generalidades p{margin:0}.curso_corto .group-curso-corto-generalidades>div>div{padding-bottom:10px;padding-right:10px}.curso_corto .group-curso-corto-generalidades{margin-bottom:30px;background-color:#f7f9ec;margin:0;padding-top:20px}.curso_corto .group-curso-corto-generalidades>div{overflow:hidden}.curso_corto .group-curso-corto-generalidades .field-label{float:left;width:150px;text-align:right;color:#df7e00;font-weight:normal}.curso_corto .group-curso-corto-generalidades .field-items{display:table}.curso_corto .field-field-curso_corto-organizador a:after{content:" \00BB"}.curso_corto .field-field-curso_corto-organizador a{color:#596221}.curso_corto .field-field-curso_corto-organizador a:hover{color:#df7e00}#grueso .curso_corto .group-curso-corto-generalidades ul{margin:0;padding:0}#grueso .curso_corto .group-curso-corto-generalidades li{margin-left:15px}.curso_corto .field-field-curso-corto-nombre-modulo-1,.curso_corto .field-field-curso-corto-nombre-modulo-2,.curso_corto .field-field-curso-corto-nombre-modulo-3,.curso_corto .field-field-curso-corto-nombre-modulo-4,.curso_corto .field-field-curso-corto-nombre-modulo-5,.curso_corto .field-field-curso-corto-nombre-modulo-6,.curso_corto .field-field-curso-corto-nombre-modulo-7,.curso_corto .field-field-curso-corto-nombre-modulo-8,.curso_corto .field-field-curso-corto-nombre-modulo-9,.curso_corto .field-field-curso-corto-nombre-modulo-10{font-weight:bold;margin-left:40px}.curso_corto .field-field-curso-corto-primer-modulo,.curso_corto .field-field-curso-corto-segundo-modulo,.curso_corto .field-field-curso-corto-tercer-modulo,.curso_corto .field-field-curso-corto-cuarto-modulo,.curso_corto .field-field-curso-corto-quinto-modulo,.curso_corto .field-field-curso-corto-sexto-modulo,.curso_corto .field-field-curso-corto-septimo-modulo,.curso_corto .field-field-curso-corto-octavo-modulo,.curso_corto .field-field-curso-corto-noveno-modulo,.curso_corto .field-field-curso-corto-decimo-modulo{margin-left:60px;margin-bottom:10px}.curso_corto .content-multigroup-group-curso-corto-contacto{background-color:#e3e8cc;margin-top:20px;padding:10px 20px;font-size:.8em;line-height:1.2em;margin:20px -20px;overflow:hidden}.curso_corto .content-multigroup-group-curso-corto-contacto .content-multigroup-wrapper{float:left;width:50%}.imagefield.imagefield-imagelink.imagefield-field_curso_corto_vcard{background:url(/sites/default/themes/ueb/images/vcard.png);width:21px;height:16px;display:block}.imagefield.imagefield-imagelink.imagefield-field_curso_corto_vcard:hover{background:url(/sites/default/themes/ueb/images/vcard-hover.png)}.curso_corto .content-multigroup-group-curso-corto-contacto .content-multigroup-wrapper .field-field-curso-corto-vcard{float:left}.imagefield.imagefield-imagelink.imagefield-field_curso-corto_vcard img{display:none}#grueso .node.curso_corto .field-field-curso-corto-informes p{margin-left:30px}.content-multigroup-group-curso-corto-programa .field-field-curso-corto-programa-titulo{font-weight:bold}#grueso .curso_corto .field-field-curso-corto-informacion-defecto{margin-top:0}#grueso .curso_corto .field-field-curso-corto-informacion-defecto p{margin-left:15px}#grueso .curso_corto .field-field-curso-corto-informacion-defecto{text-align:center;font-size:.8em}.curso_corto .field-field-evento-fecha .date-display-start:before,.curso_corto .field-field-evento-fecha .date-display-single:before{content:"Inicia el "}.curso_corto .field-field-evento-fecha .date-display-separator{display:none}.curso_corto .field-field-evento-fecha .date-display-end:before{content:" y finaliza el "}a.imagefield-field_galeria_imagen{display:block;float:left;width:64px;height:49px;z-index:-1}a.imagefield-field_galeria_imagen:hover{z-index:999}a.imagefield-field_galeria_imagen img{width:60px;height:45px;display:block;z-index:-1;border:solid 2px #fff;-webkit-transition:width .1s ease-in-out,height .1s ease-in-out,margin .1s ease-in-out;-moz-transition:width .1s ease-in-out,height .1s ease-in-out,margin .1s ease-in-out;-o-transition:width .1s ease-in-out,height .1s ease-in-out,margin .1s ease-in-out;transition:width .1s ease-in-out,height .1s ease-in-out,margin .1s ease-in-out}
a.imagefield-field_galeria_imagen:hover img{width:140px;height:105px;margin-left:-43px;margin-top:-33px;z-index:999;position:absolute;border:solid 5px #fff;-moz-box-shadow:0 5px 7px 0 rgba(0,0,0,0.5);-webkit-box-shadow:0 5px 7px 0 rgba(0,0,0,0.5);box-shadow:0 5px 7px 0 rgba(0,0,0,0.5)}.node.galeria .meta,.node.galeria .field-label{display:none}.node.galeria .content p{width:40%;float:left;padding-right:20px}#imageData #caption{font-weight:normal;font-family:'PTSansRegular';line-height:1em;font-size:1.4em}#imageData #imageDetails{width:100%}#imageData{padding:10px;overflow:hidden}#numberDisplay{display:none!important}#bottomNavClose{display:none}body.page-medios,body.node-type-ddblock-news-item,body.node-type-nota{background:0}.node.nota .field-field-nota-imagen{float:left;margin-right:15px}body.page-medios #grueso .box,body.node-type-ddblock-news-item #grueso .box,body.node-type-nota #grueso .box,body.node-type-boletin #grueso .box{margin-bottom:20px;padding:20px;border:0;background:0}#block-views-blog_ri-block_1 h2{font-weight:100}body.page-medios #block-views-medios_notas-block_2{width:60%;float:left;margin-right:10px}#block-views-medios_notas-block_1 .views-field-field-nota-imagen-fid,#block-views-medios_notas-block_2 .views-field-field-nota-imagen-fid{float:left;margin-right:10px}body.page-medios #grueso .block-views{background:0;border:0}#grueso .view-medios-notas .item-list ul{padding:0}body.page-medios .block-views .view-content li a,body.page-medios.block-views .view-content .views-field-title a{line-height:1.2em;display:block}body.page-medios #menu .block-menu{padding-right:21px}.page-medios .view-semanario-ueb .views-field-field-image-fid a,.page-medios .view-medios-notas .views-field-field-nota-imagen-fid a{display:block;border:3px solid #ddd;width:208px;height:89px}.page-medios .view-semanario-ueb .views-field-field-image-fid a:hover,.page-medios .view-medios-notas .views-field-field-nota-imagen-fid a:hover{border:3px solid #eb8906}.page-medios .view-semanario-ueb .views-field-field-image-fid a img,.page-medios .view-medios-notas .views-field-field-nota-imagen-fid a img{margin:0;display:block}#grueso #block-views-medios_comentarios-block_1.block-views{padding:5px;background-color:#f8f8f8;float:right;width:35%}#grueso .block-views .view-medios-comentarios .view-content .views-field-title a,#grueso .block-views .view-medios-comentarios .view-content .views-field-comment p,#grueso .block-views .view-medios-comentarios .view-content .views-field-name{font-size:.9em;line-height:1.3em}#grueso .block-views .view-medios-comentarios .view-content .views-field-comment p{margin:0;padding-left:20px;padding-right:20px}#grueso .block-views .view-medios-comentarios .view-content .views-field-name{padding-right:20px}#grueso .block-views .view-medios-comentarios .view-content .views-field-comment .field-content:before{content:"\201C";font-size:2.5em;padding-top:7px;margin-right:5px;position:relative;line-height:.5em;float:left;color:#ddd}#grueso .block-views .view-medios-comentarios .view-content .views-field-comment p:after{content:"\201D";font-size:2.5em;padding-top:10px;position:absolute;margin-left:5px;color:#ddd}#grueso .block-views .view-medios-comentarios .view-content .views-field-name{text-align:right;margin-bottom:10px}#block-views-th_boletin_destacado-block_1{background-color:#fff}.view-boletin-talento-el-bosque,.view-boletin-u-al-dia{margin-top:20px}.view-boletin-talento-el-bosque .views-row,.view-boletin-u-al-dia .views-row{display:block;margin-bottom:5px;padding:10px;background-color:#fff;overflow:hidden}.view-boletin-talento-el-bosque .views-field-field-boletin-imagen-fid,.view-boletin-u-al-dia .views-field-field-boletin-imagen-fid{float:left;margin-right:10px}.view-boletin-talento-el-bosque .views-field-field-boletin-indice-value,.view-boletin-u-al-dia>div>div>.views-field-field-boletin-indice-value{margin-left:110px;font-size:.8em;line-height:1.2em}.view-boletin-talento-el-bosque .views-field-title,.view-boletin-u-al-dia .views-field-title{font-weight:bold}
#inicio .views-field-field-carta-rector-video-value,#inicio .views-field-field-carta-rector-video-value iframe{width:220px;height:auto}.field-field-video-embedded{float:left;margin:0 20px 20px 0}.views-field-field-video-embedded-value{float:left;margin:0 20px 0 0}.field-field-video-descripcion{margin-top:10px}.field.field-type-date.field-field-video-fecha{margin-bottom:10px}.view-comunicado-del-rector .views-view-grid .views-field-title{font-weight:bold;font-size:1.5em;margin-top:10px}.view-comunicado-del-rector .views-view-grid td{border-bottom:2px solid #ccc;margin-bottom:2px;margin-top:10px;padding:15px}#bottomNavZoom{left:0;background:url(/sites/default/themes/ueb/images/lightbox-expand.png) no-repeat transparent;width:19px;height:19px;bottom:10px}#bottomNavZoomOut{left:0;background:url(/sites/default/themes/ueb/images/lightbox-contract.png) no-repeat transparent;width:19px;height:19px;bottom:10px}.imagefield-field_laboratorio_imagen a{display:block;padding:5px;background-color:#30F}.imagefield-field_laboratorio_imagen img{display:block}.pdf{margin-bottom:5px}.pdf:before{content:url(/sites/default/themes/ueb/images/icono-pdf.png);margin-right:5px}.archivo.excel:after{content:url(/sites/default/themes/ueb/images/archivo-excel.png);margin-left:5px}.content-multigroup-group-laboratorio .content-multigroup-wrapper,.content-multigroup-group-galeria-descriptiva .content-multigroup-wrapper{margin-top:30px}.field-field-laboratorio-imagen,.field-field-laboratorio-imagen div,.field-field-galeria-descriptiva-imagen,.field-field-galeria-descriptiva-imagen div{float:left}.field-field-laboratorio-imagen,.field-field-galeria-descriptiva-imagen{margin-right:10px}.field-field-laboratorio-imagen a,.field-field-galeria-descriptiva-imagen a{border:3px solid #88ab0c;display:block}.field-field-laboratorio-imagen a:hover,.field-field-galeria-descriptiva-imagen a:hover{border:3px solid #f60}.field-field-laboratorio-imagen a img,.field-field-galeria-descriptiva-imagen a img{display:block}.field-field-laboratorio-nombre,.field-field-galeria-descriptiva-nombre{font-family:Georgia,"Times New Roman",Times,serif;font-size:1.3em;border-bottom:2px solid #3e4729;padding-bottom:5px;margin-bottom:10px}.node.indice .field-item{width:45%;padding:0 5px 0;overflow:hidden}.node.indice .field-item.odd{float:left;clear:left}.node.indice .field-item a{display:block;padding:10px;font-size:1.2em;border-bottom:1px solid #690}.node.indice .field-item a:hover{border-bottom:1px solid #f60}.rteindent1{padding-left:10px;margin-left:0}.rteindent2{padding-left:30px}.field .field-label-inline{visibility:visible}.content-multigroup-group-directorio-colaboradores .field-field-directorio-cola-nombre .field-item{font-weight:bold;font-size:1.1em}.content-multigroup-group-directorio-colaboradores .content-multigroup-wrapper{margin-top:20px;width:50%;float:left;height:inherit}.content-multigroup-group-directorio-colaboradores .content-multigroup-wrapper div.field-items{padding-left:10px}.content-multigroup-group-directorio-colaboradores .content-multigroup-wrapper .field-field-directorio-cola-nombre div.field-items{padding-left:0}.field-field-directorio-cola-cargo .field-label-inline,.field-field-directorio-cola-extension .field-label-inline,.field-field-directorio-cola-telefono .field-label-inline{font-weight:normal}.field-field-directorio-area-ubicacion .field-item{font-size:1.2em;font-weight:bold}.field-field-directorio-area-extension{margin-bottom:15px}.view-directorio-inicio table.views-view-grid td{background:#dde1bf;padding:0}.view-directorio-inicio table.views-view-grid td>div{border-bottom:1px solid #dae0b8;-moz-box-shadow:0 5px 10px -5px #dae0b8;-webkit-box-shadow:0 5px 10px -5px #dae0b8;box-shadow:0 5px 10px -5px #dae0b8}.view-header{background-color:#fff;text-align:center;padding:10px}.attachment .view-header{display:none}table.views-view-grid td{background-color:#fff;vertical-align:top;line-height:1.1em;font-size:.9em}.view-becas-ri table.views-view-grid td{padding:15px}.menu-revista-enfermeria table.views-view-grid td{background-color:#e2e5ca;font-size:1.2em}
.menu-revista-enfermeria table.views-view-grid td a{color:#3e4729}.menu-revista-enfermeria table.views-view-grid td a:hover{color:#df7e00}.grueso-revista-enfermeria .views-field-title{color:#3e4729;font-weight:bold;padding-left:15px}.grueso-revista-enfermeria .views-field-field-publicacion-volumen-value .field-content{padding:0}.grueso-revista-enfermeria .views-field-phpcode{padding:20px;font-size:.9em;line-height:1em}.view-publi-revistas-edicion-actual .views-field-title{font-size:1.1em;font-weight:bold;padding-left:20px}.grueso-revistas .views-field-field-publicacion-volumen-value .field-content{padding:0}.grueso-revistas .views-field-phpcode{padding:20px;font-size:.95em;line-height:1em}.view-publi-revistas-edicion-actual p{margin:0 0 10px 20px}.views-field-field-publicacion-serial-electronico-value,.views-field-field-publicacion-serial-value{text-align:right;margin-right:10px}.views-field-field-publicacion-serial-electronico-value{margin-top:-42px}.views-field-field-publicacion-serial-value{margin-bottom:30px}.view-publi-revistas-edicion-actual .views-field-field-publicacion-volumen-value,.view-publi-revistas-edicion-actual .views-field-field-publicacion-fecha-publicacion-value{margin-left:12px;margin-top:15px}.view-publi-revistas-edi-anteriores,.view-publi-revistas-edicion-actual{padding:10px;background:#fff}.cabezote-publicacion-revistas h1:first-child{background:#8463ce;font-size:1.2em;text-align:left;display:block;height:100%;line-height:1em;padding:5px;margin:0;color:#fff}.view-publi-revistas-edi-anteriores .cabezote-publicacion-revistas h1:first-child,.view-publi-revistas-edicion-actual .cabezote-publicacion-revistas h1:first-child{border-left:1px solid #fff;border-right:1px solid #fff}.cabezote-publicacion-revistas h1:last-child{margin:0;padding-bottom-1em}.cabezote-publicacion-revistas img{margin:0 auto;padding-bottom:10px}.view-publi-revistas-edicion-actual .cabezote-publicacion-revistas p,.view-publi-revistas-edi-anteriores .cabezote-publicacion-revistas p{margin:0}.view-publi-revistas-edicion-actual .views-field-phpcode{padding:30px 0 0 140px}.view-publi-revistas-edi-anteriores table tr{padding:15px 0}.view-publi-revistas-edi-anteriores table td{background:0;padding:20px}.view-publi-revistas-edi-anteriores table tr:nth-child(2n+1){background:#f4f6e8}.view-publi-revistas-edi-anteriores table tr>td:first-child{border-right:1px dashed #e0e2d5}.view-publi-revistas-edicion-actual .views-field-field-publicacion-fecha-publicacion-value p,.view-publi-revistas-edicion-actual .views-field-field-publicacion-fecha-publicacion-value,.view-publi-revistas-edi-anteriores .views-field-field-publicacion-serial-value p,.view-publi-revistas-edi-anteriores .views-field-field-publicacion-serial-value{display:inline}.node-2122 td{padding:5px 0}.view-publi-revistas-edicion-actual object{margin-left:10px}.view-publi-revistas-edi-anteriores .views-field-field-publicacion-serial-value p,.view-publi-revistas-edi-anteriores .views-field-field-publicacion-volumen-value p,.view-publi-revistas-edi-anteriores .views-field-field-publicacion-fecha-publicacion-value p{margin:0;clear:both}body.portal_egresados #grueso .views-view-grid td{padding:20px}table.views-view-grid td .views-field-title{font-size:1.3em;line-height:1.1em}.grueso-revista-enfermeria .nombre_articulo{font-size:1.1em}.grueso-revista-enfermeria p{margin:0 0 20px 20px;padding:0}table.views-view-grid td .views-field-field-image-fid span,table.views-view-grid td .views-field-field-image-fid span img{display:block;margin:10px auto 5px;text-align:center}.views-field-field-curso-corto-imagen-promo-fid{float:left;margin-right:10px}.view-inicio-educacion-continuada .views-field-field-congreso-imagen-fid,.view-inicio-educacion-continuada .views-field-field-evento-educ-imagen-fid{float:left;padding:0 10px 0 10px}.view-inicio-educacion-continuada .views-field-field-evento-fecha-value{font-style:italic;font-size:1.1em}body.page-educacion-continuada #menu .block{background:0;border:0;padding:0}body.page-educacion-continuada #menu .block .micropromo{font-size:large;margin-bottom:0;width:inherit}
body.page-educacion-continuada #menu ul li a:hover{background:url(/sites/default/themes/ueb/images/fondo-menu-hover.gif) repeat-y right #88ab0c;color:#fff}body.page-educacion-continuada #menu ul li a{display:inline-block;padding-left:10px;padding-right:20px}body.page-educacion-continuada #menu{width:240px}body.page-educacion-continuada #menu .content>.menu>li.expanded>a{color:#FFF;background:url(/sites/default/themes/ueb/images/fondo-menu-activo.gif) repeat-y right #eb8906;display:inline-block}.view-inicio-educacion-continuada .item-list ul.pager{background-color:#fff}.view-inicio-educacion-continuada{border:solid 1px #ced2af}.view-inicio-educacion-continuada.view-dom-id-1{margin-bottom:50px}table.views-view-grid td{padding:10px}.view-inicio-educacion-continuada.view-dom-id-1 a.imagecache,#block-views-5e8a3a9ee6e1eea81a82631662c7d1a4 a.imagecache{float:left;margin-right:15px}body.page-educacion-continuada #menu .block{margin-bottom:10px}body.page-educacion-continuada #menu .micropromo,body.page-educacion-continuada #menu .micropromo a{display:inline-block}.menu-revista-enfermeria #menu .block-views p{font-size:14px}.ddblock_news_item .field-field-slide-text .field-item{background:url(/sites/default/themes/ueb/custom/modules/ddblock/images/transparent_bg.png) repeat scroll 0 0 transparent;margin-top:-65px;height:45px;margin-bottom:20px;font-size:1.2em;padding:10px;color:#fff;position:relative;line-height:1.2em}.ddblock_news_item .field-field-slide-text .field-label{display:none}.field-field-noticia-fbytwitter{float:right}#node-692>h2,#node-692>h1,#node-1225>h2,#node-1225>h1,#node-2346>h2,#node-2346>h1,#node-2739>h2,#node-2739>h1,#node-2946>h2,#node-2946>h1{display:none}#node-2406>h2,#node-2406>h1{background-color:#d60b52;color:#fff;padding:5px;position:relative}.views-field-field-curso-corto-bocadillo-value p{margin:0}label.views-label-field-diplomado-fecha-inicio-value,label.views-label-field-curso-corto-fecha-inicio-value{float:left;margin-right:5px}.views-field-field-diplomado-fecha-inicio-value .field-content,.views-field-field-curso-corto-fecha-inicio-value .field-content{font-size:1.1em;font-style:italic}.views-field-field-diplomado-fecha-inicio-value .field-content p,.views-field-field-curso-corto-fecha-inicio-value .field-content p{margin:0}.view-congresos-indice .views-field-field-evento-imagen-fid{float:left;margin-right:15px}.node.evento .field-field-evento-pagina-web a{color:#fff;font-weight:bold;background-color:#88ab0c;padding:7px;display:inline-block}.node.evento .field-field-evento-pagina-web a:hover{background-color:#e77f18}.node.evento_profesional .field-field-evento-educ-pagina-web a{color:#fff;font-weight:bold;background-color:#88ab0c;padding:7px;display:inline-block}.node.evento_profesional .field-field-evento-educ-pagina-web a:hover{background-color:#e77f18}#grueso .node.publicacion h2{font-family:'PTSerifCaptionRegular';border-bottom:0}.node.publicacion .field-field-publicacion-imagen-portada{float:left;margin-right:10px}.group-publicacion-edicion{position:relative;color:#777;padding-bottom:25px;font-size:1em}.field-field-publicacion-serial,.field-field-publicacion-volumen,.field-field-publicacion-fecha-publicacion,.field-field-publicacion-serial-electronico{font-family:'PTSerifCaptionRegular'}.field-field-publicacion-volumen{margin-top:15px}.field-field-publicacion-serial{margin-top:-35px;text-align:right}.field-field-publicacion-serial-electronico{text-align:right}.content-multigroup-group-publicacion-articulos legend{display:block;font-family:'PTSerifCaptionRegular';font-size:1.1em;padding-bottom:15px;padding-top:25px}#grueso .node.publicacion .content>p{margin-top:25px}.node.publicacion .content>p:first-letter {font-size:3em;float:left;font-family:'PTSerifCaptionRegular';margin-right:5px;line-height:.8em}.content-multigroup-group-publicacion-articulos{margin-left:160px}.field-field-publicacion-autor-es{margin-left:20px}.field-field-publicacion-nombre-articulo{font-size:1.1em}.indice-publicaciones .view-content{background-color:#fff}.indice-publicaciones .view-content .views-field-body{font-size:.8em;line-height:1.3em;margin:-5px 0 0 100px;clear:both}
.view-publicaciones-revista-enfermeria .view-content .views-field-body{margin-left:0}.indice-publicaciones .view-content .views-row{clear:both;overflow:hidden;padding:0 0 30px 20px}.views-field-field-publicacion-imagen-portada-fid{float:left;margin-right:20px}.views-field-field-publicacion-serial-value p,.views-field-field-publicacion-volumen-value p,.views-field-field-publicacion-fecha-publicacion-value p{margin-left:20px;font-size:.9em;padding:0}#grueso .calendar-calendar .day{border:0;background:0;float:left;width:auto;padding:0 0 0 2px;width:20px;margin:0;font-family:helvetica,arial;cursor:default}.calendar-calendar .has-no-events{color:#c6cbbb;cursor:default}.calendar-calendar .has-events a,.mini-day-on{text-decoration:none;font-weight:bold;color:#88ab0c}.calendar-calendar td.has-events,.calendario_academico .calendar-calendar table.odd td.has-events{background-color:#f3f9dc}.calendar-calendar td.today.has-events,.calendar-calendar .odd td.today.has-events,.calendario_academico .calendar-calendar td.today.has-events,.calendario_academico .calendar-calendar .odd td.today.has-events{background-color:#e77f18}.calendar-calendar td.today.has-events a,.calendar-calendar .odd td.today.has-events a{text-decoration:none;font-weight:bold;color:#fff}.calendar-calendar td.today.has-events a:hover{color:#FF0}.calendar-calendar td.today.has-events .day a{color:#fff}.view-calendario-de-ingenierias .bt-content{min-height:58px;padding-top:5px;color:#3e4729}.view-calendario-de-ingenierias .bt-wrapper{position:absolute;width:200px;z-index:9997;text-align:left}.calendario_academico .calendar-calendar .has-events a,.mini-day-on{color:#000}.calendario_academico .calendar-calendar .has-events a:hover{color:#000}#convenciones td.convencion{border-width:1px;border-spacing:2px;border-style:outset;border-color:gray;border-collapse:separate}#convenciones tbody{border-top:0}#convenciones tr{height:25px}.calendario_academico .fieldset-wrapper td.primer_dia_clase,.calendario_academico .calendar-calendar td.has-events.primer_dia_clase,.calendario_academico .calendar-calendar table.odd td.has-events.primer_dia_clase{background-color:#a9e99a}.calendario_academico .fieldset-wrapper td.induccion_nuevos_estudiantes,.calendario_academico .calendar-calendar td.has-events.induccion_nuevos_estudiantes,.calendario_academico .calendar-calendar table.odd td.has-events.induccion_nuevos_estudiantes{background-color:#bee243}.calendario_academico .fieldset-wrapper td.inicio_actividades_docentes,.calendario_academico .calendar-calendar td.has-events.inicio_actividades_docentes,.calendario_academico .calendar-calendar table.odd td.has-events.inicio_actividades_docentes{background-color:#5fc548}.calendario_academico .fieldset-wrapper td.limite_para_cancelacion_asignaturas,.calendario_academico .calendar-calendar td.has-events.limite_para_cancelacion_asignaturas,.calendario_academico .calendar-calendar table.odd td.has-events.limite_para_cancelacion_asignaturas{background-color:#f2e549}.calendario_academico .fieldset-wrapper td.entrega_notas_a_secretaria_academica,.calendario_academico .calendar-calendar td.has-events.entrega_notas_a_secretaria_academica,.calendario_academico .calendar-calendar table.odd td.has-events.entrega_notas_a_secretaria_academica{background-color:#fdcd8d}.calendario_academico .fieldset-wrapper td.examenes_finales_teoricos,.calendario_academico .calendar-calendar td.has-events.examenes_finales_teoricos,.calendario_academico .calendar-calendar table.odd td.has-events.examenes_finales_teoricos{background-color:#f9a6ae}.calendario_academico .fieldset-wrapper td.pre_matriculas,.calendario_academico .calendar-calendar td.has-events.pre_matriculas,.calendario_academico .calendar-calendar table.odd td.has-events.pre_matriculas,.calendario_academico .fieldset-wrapper td.prematriculas,.calendario_academico .calendar-calendar td.has-events.prematriculas,.calendario_academico .calendar-calendar table.odd td.has-events.prematriculas{background-color:#8a58e2}.calendario_academico .fieldset-wrapper td.corte_notas,.calendario_academico .calendar-calendar td.has-events.corte_notas,.calendario_academico .calendar-calendar table.odd td.has-events.corte_notas{background-color:#e3d639}
.calendario_academico .fieldset-wrapper td.supletorios,.calendario_academico .calendar-calendar td.has-events.supletorios,.calendario_academico .calendar-calendar table.odd td.has-events.supletorios{background-color:#db5c9d}.calendario_academico .fieldset-wrapper td.semana_santa,.calendario_academico .calendar-calendar td.has-events.semana_santa,.calendario_academico .calendar-calendar table.odd td.has-events.semana_santa{background-color:#fab252}.calendario_academico .fieldset-wrapper td.semana_receso_estudiantil,.calendario_academico .calendar-calendar td.has-events.semana_receso_estudiantil,.calendario_academico .calendar-calendar table.odd td.has-events.semana_receso_estudiantil{background-color:#e9a141}.calendario_academico .fieldset-wrapper td.ultimo_dia_clase,.calendario_academico .calendar-calendar td.has-events.ultimo_dia_clase,.calendario_academico .calendar-calendar table.odd td.has-events.ultimo_dia_clase{background-color:#7dd26a}.calendario_academico .fieldset-wrapper td.cierre_academico,.calendario_academico .calendar-calendar td.has-events.cierre_academico,.calendario_academico .calendar-calendar table.odd td.has-events.cierre_academico{background-color:#c19eff}.calendario_academico .fieldset-wrapper td.finalizacion_actividades_docentes,.calendario_academico .calendar-calendar td.has-events.finalizacion_actividades_docentes,.calendario_academico .calendar-calendar table.odd td.has-events.finalizacion_actividades_docentes{background-color:#d7f081}.calendario_academico .fieldset-wrapper td.grados,.calendario_academico .calendar-calendar td.has-events.grados,.calendario_academico .calendar-calendar table.odd td.has-events.grados{background-color:#9e74e8}.calendario_academico .fieldset-wrapper td.limite_para_adicion_asignaturas,.calendario_academico .calendar-calendar td.has-events.limite_para_adicion_asignaturas,.calendario_academico .calendar-calendar table.odd td.has-events.limite_para_adicion_asignaturas{background-color:#f5ed80}.calendario_academico .fieldset-wrapper td.entrega_trabajos_finales,.calendario_academico .calendar-calendar td.has-events.entrega_trabajos_finales,.calendario_academico .calendar-calendar table.odd td.has-events.entrega_trabajos_finales{background-color:#dc93ed}.calendario_academico .fieldset-wrapper td.practicas_profesionales,.calendario_academico .calendar-calendar td.has-events.practicas_profesionales,.calendario_academico .calendar-calendar table.odd td.has-events.practicas_profesionales{background-color:#bb6acc}.calendario_academico .fieldset-wrapper td.examenes_finales_practicos,.calendario_academico .calendar-calendar td.has-events.examenes_finales_practicos,.calendario_academico .calendar-calendar table.odd td.has-events.examenes_finales_practicos{background-color:#f26774}.calendario_academico .fieldset-wrapper td.habilitaciones_recuperaciones,.calendario_academico .calendar-calendar td.has-events.habilitaciones_recuperaciones,.calendario_academico .calendar-calendar table.odd td.has-events.habilitaciones_recuperaciones{background-color:#cf3684}.calendario_academico .fieldset-wrapper td.induccion_docentes,.calendario_academico .calendar-calendar td.has-events.induccion_docentes,.calendario_academico .calendar-calendar table.odd td.has-events.induccion_docentes{background-color:#b1d33c}.calendario_academico .fieldset-wrapper td.examenes_admisiones,.calendario_academico .calendar-calendar td.has-events.examenes_admisiones,.calendario_academico .calendar-calendar table.odd td.has-events.examenes_admisiones{background-color:#61a5ff}.calendario_academico .fieldset-wrapper td.matriculas,.calendario_academico .calendar-calendar td.has-events.matriculas,.calendario_academico .calendar-calendar table.odd td.has-events.matriculas{background-color:#94c0ff}.calendario_academico .fieldset-wrapper td.salidas_campo,.calendario_academico .calendar-calendar td.has-events.salidas_campo,.calendario_academico .calendar-calendar table.odd td.has-events.salidas_campo{background-color:#aa53bd}.calendario_academico .fieldset-wrapper td.autoevaluacion_docentes,.calendario_academico .calendar-calendar td.has-events.autoevaluacion_docentes,.calendario_academico .calendar-calendar table.odd td.has-events.autoevaluacion_docentes{background-color:#418cf1}.calendario_academico .fieldset-wrapper td.reunion_coordinadores,.calendario_academico .calendar-calendar td.has-events.reunion_coordinadores,.calendario_academico .calendar-calendar table.odd td.has-events.reunion_coordinadores{background-color:#a6e7ff}.calendario_academico .fieldset-wrapper td.presustentaciones,.calendario_academico .calendar-calendar td.has-events.presustentaciones,.calendario_academico .calendar-calendar table.odd td.has-events.presustentaciones{background-color:#e24d5b}.calendario_academico .fieldset-wrapper td.sustentaciones,.calendario_academico .calendar-calendar td.has-events.sustentaciones,.calendario_academico .calendar-calendar table.odd td.has-events.sustentaciones{background-color:#ed98c3}.calendario_academico .fieldset-wrapper td.reunion_consejo_facultad,.calendario_academico .calendar-calendar td.has-events.reunion_consejo_facultad,.calendario_academico .calendar-calendar table.odd td.has-events.reunion_consejo_facultad{background-color:#4dceff}.calendario_academico .fieldset-wrapper td.reunion_induccion_padres_familia,.calendario_academico .calendar-calendar td.has-events.reunion_induccion_padres_familia,.calendario_academico .calendar-calendar table.odd td.has-events.reunion_induccion_padres_familia{background-color:#24bfe0}.calendar-calendar tr td.today{color:#eb8906;background:0}.calendario div.calendar-calendar div.day a{color:#88ab0c;background:0}.calendar-calendar td,.calendar-calendar td.empty,.calendar-calendar td.calendar-agenda-items,.calendar-calendar td .inner div,.calendar-calendar td .inner div a{border:0;background:0}.calendar-calendar .month-view .full td.single-day .calendar-empty,.calendar-calendar .month-view .full td.single-day.empty,.calendar-calendar .month-view .full td.date-box.empty{border:0;background:0}.calendario .calendar-calendar td a:hover{text-decoration:none;color:#eb8906}.calendar-calendar td .inner div.calendar div,.calendar-calendar td .inner div.calendar div a{background:0}.calendar-calendar td .inner div.calendar div{line-height:1em;font-size:1.2em}.calendar-calendar td{width:auto;padding-bottom:10px}#grueso .calendar-calendar th.days,#menu .calendar-calendar th.days,#promocional .calendar-calendar th.days,#grueso .calendar-calendar .calendar-agenda-hour{background:0;border:0;color:#3e4729;font-size:.7em;font-weight:normal;cursor:default}
.calendario .calendar-calendar thead tr{background:0;background:url(/sites/default/themes/ueb/images/pager-fondo.png) -10px repeat-x;border:0;height:40px;border-left:1px solid #dfe1cb;border-right:1px solid #dfe1cb;border-top:1px solid #dddcc5}#grueso .calendar-calendar tbody{border:0}#grueso .calendario{margin-top:20px}#grueso .calendario .calendar-calendar ul.links{text-align:center;background-color:#f2f2e6;border:1px solid #dfe1cb;border-bottom:0;overflow:hidden;padding:0 0 0 150px}#grueso .attachment .calendar-calendar{margin-top:0}#grueso .calendario .calendar-calendar ul.links li:first-child{border-left:1px solid #dfe1cb}#grueso .calendario .calendar-calendar ul.links li{padding:0;border-right:1px solid #dfe1cb;overflow:hidden;display:block;float:left;width:100px}#grueso .calendario .calendar-calendar ul.links a{display:block;width:100%;padding:5px;float:left;text-transform:uppercase;font-size:.7em;letter-spacing:.2em;text-decoration:none}.calendar-calendar div.date-nav,.view-content .calendar-calendar div.date-nav{clear:both;background-color:#f2f2e6;border:0;border-bottom:1px solid #88ab0c;background-color:#FFF;border-left:1px solid #dfe1cb;border-right:1px solid #dfe1cb}.view-content .calendar-calendar ul{line-height:inherit;position:inherit;top:0;z-index:1}.view-content .calendar-calendar .date-nav{position:relative}.view-content .calendar-calendar .date-prev{right:auto;-moz-border-radius:0;background:0;font-size:12px;padding:5px}.view-content .calendar-calendar .date-next{left:auto;-moz-border-radius:0;background:0;font-size:12px;padding:5px}.calendar-calendar .year-view td{padding:0}.year-view td:first-child .calendar-calendar div.date-nav{border-right:0}.year-view td:last-child .calendar-calendar div.date-nav{border-left:none}#grueso .year-view td:first-child .calendar-calendar thead tr{border-right:0}#grueso .year-view td:last-child .calendar-calendar thead tr{border-left:none}.calendar-calendar td{text-align:center}.calendario .day-view thead{display:none}.calendar-calendar .day-view .calendar{font-size:1em}.calendar-calendar table.mini tbody{border-top:0}table td.mini,table th.mini,table.mini td.week{padding:4px}.view-content .calendar-calendar .date-heading h3{font-size:1em}.view-content .calendar-calendar .date-heading h3 a{display:block}.view-content .calendar-calendar .date-heading h3 a:hover{color:#060}#grueso .view-content .calendar-calendar .date-heading h3 a{display:block;background:0;color:#88ab0c;cursor:default}.calendar-calendar div.date-nav a,.calendar-calendar div.date-nav h3{color:#88ab0c}.view-content .calendar-calendar .date-heading h3 a:hover{color:#df7e00;text-decoration:none}div.block .view-content .calendar-calendar .date-prev,div.block .view-content .calendar-calendar .date-next{top:3px;color:#fff;font-size:1.3em;-moz-border-radius:0;background:0}.view-content .calendar-calendar .date-prev span,.view-content .calendar-calendar .date-next span{margin:0;line-height:0}div.block .view-content .calendar-calendar .date-prev,div.block .view-content .calendar-calendar .date-next{height:24px;padding:0}div.block .view-content .calendar-calendar .date-prev{left:3px}div.block .view-content .calendar-calendar .date-next{right:3px}div.block .view-content .calendar-calendar .date-prev span a,div.block .view-content .calendar-calendar .date-next span a{display:inline-block;width:24px;height:24px;color:#88ab0c;vertical-align:middle;text-align:center;line-height:2em}div.block .view-content .calendar-calendar .date-prev span a:hover,div.block .view-content .calendar-calendar .date-next span a:hover{color:#df7e00;color:#F30;text-decoration:none}#menu #block-views-e16f512a45aaea5429cf8d401aa95336,#menu #block-views-432a0f41b064a134ec7df123689e4a1a,#menu #block-views-c9aeeaf83aa97abd5b1b8ed64790e05e,#menu #block-views-8e60bafd5be8ff4b4a992120f4c58b9c,#menu #block-views-04bb0b396b25f601b59f2e046ba39431,#menu #block-views-df8b8e11524417f5d0017c6670abd8ff{background:0;border:0;padding:0}.calendar-calendar div.date-nav{padding:inherit}.attachment .calendar-calendar{margin-top:0}.calendar-calendar .month-view .full td.multi-day .calendar.monthview .view-field{white-space:normal;background-color:#f3f9dc;padding:5px;margin-right:0;width:100%}
.calendar-calendar .month-view .full td.multi-day .calendar.monthview .contents,.calendar-calendar .week-view .full td.multi-day .calendar.weekview .contents{width:auto}.calendar-calendar .month-view .full td.multi-day div.monthview,.calendar-calendar .week-view .full td.multi-day div.weekview,.calendar-calendar .day-view .full td.multi-day div.dayview{background-color:#666}.calendar-calendar .month-view .full td.multi-day .inner .view-field a,.calendar-calendar .week-view .full td.multi-day .inner .view-field a,.calendar-calendar .day-view .full td.multi-day .inner .view-field a{color:#3e4729}.calendar-calendar .month-view .full td.multi-day .inner .view-field a:hover,.calendar-calendar .week-view .full td.multi-day .inner .view-field a:hover,.calendar-calendar .day-view .full td.multi-day .inner .view-field a:hover{color:#e77f18}.calendar-calendar .month-view .full td.multi-day div.monthview,.calendar-calendar .week-view .full td.multi-day div.weekview,.calendar-calendar .day-view .full td.multi-day div.dayview{overflow:hidden;background:0}.calendar-calendar .month-view .full td.multi-day div.monthview,.calendar-calendar .week-view .full td.multi-day div.weekview,.calendar-calendar .day-view .full td.multi-day div.dayview{height:auto}.calendar-calendar .month-view .full td.multi-day .calendar.monthview .view-field{float:none}.calendar-calendar .month-view .full td.multi-day .inner .monthview .continues,.calendar-calendar .month-view .full td.multi-day .inner .monthview .cutoff,.calendar-calendar .week-view .full td.multi-day .inner .weekview .continues,.calendar-calendar .week-view .full td.multi-day .inner .weekview .cutoff{display:none}.calendar-calendar .month-view .full td.multi-day .calendar.monthview .contents,.calendar-calendar .week-view .full td.multi-day .calendar.weekview .contents{position:relative}.calendar-calendar .month-view .full td.multi-day .calendar.monthview .contents,.calendar-calendar .week-view .full td.multi-day .calendar.weekview .contents{left:0}.calendar-calendar .month-view .full tr td.today,.calendar-calendar .month-view .full tr.odd td.today,.calendar-calendar .month-view .full tr.even td.today,.calendar-calendar .month-view .full tr td.single-day.today,.calendar-calendar .month-view .full td.date-box.today{border:0}body .single-day,body .multi-day{max-width:20%;width:5%}.not-front #grueso .view.central-de-noticias .item-list{margin-top:-100px;margin-bottom:30px;padding:100px 0 0;background:url(/sites/default/themes/ueb/images/pager-fondo.png) bottom repeat-x;color:#a6aa99;font-size:.9em;border-left:1px solid #dfe1cb;border-right:1px solid #dfe1cb}.not-front #grueso .view .item-list ul.pager{padding:0 0 15px;margin:0}.not-front #grueso .view .item-list ul.pager a{color:#a6aa99}.entrada .content .field-field-entrada-mas-info{float:right;position:relative;top:175px;margin-right:20px;z-index:120}#menu ul.pager li{text-align:center;margin-top:10px;color:#3e4729}#menu ul.pager li a:hover{color:#df7e00}#menu ul.pager li.pager-next,#menu ul.pager li.pager-next.last{float:right;margin-top:-17px;color:#88ab0c;padding-right:10px}#menu ul.pager li.pager-previous,#menu ul.pager li.pager-previous.first{float:left;margin-top:-17px;color:#88ab0c;padding-right:10px}#menu ul.pager li.pager-previous,#menu ul.pager li.pager-previous.first{float:left}.menu-revista-enfermeria .view-footer{text-align:left;margin-left:1%;font-size:1em;line-height:1.5em;margin-top:20px}.menu-revista-enfermeria .view-footer a{color:#88ab0c}.menu-revista-enfermeria .view-footer a:hover{color:#df7e00}#block-views-cartelera_cultural_area-block_1 h2{background-color:#fff}.field-field-blog-imagen-entrada,.field-field-persona-destacada-imagen{float:left;margin-right:20px}#block-block-131{background-color:#fff;padding:10px}body.page-bienestar.cuerpo_con_promo #grueso,body.page-relaciones-internacionales.cuerpo_con_promo #grueso{width:510px}body.page-bienestar.cuerpo_sin_promo #grueso{width:720px}body.page-bienestar #promocional,body.page-relaciones-internacionales #promocional{margin-top:0;margin-left:10px}body.node-type-blog #grueso{width:720px}
body.node-type-blog #promocional{float:right}.node.cartelera_cultural form.fivestar-widget{clear:none;overflow:hidden}.view.calendario{margin-bottom:5px}.view-bienestar-entrada-salud .view-content>div.views-row,.view-bienestar-entrada-salud .node{margin-bottom:0}#block-block-104{margin-bottom:10px}#block-views-becas_ri-block_1,#block-views-persona_destacada-block_1{margin-bottom:10px}.persona_destacada{border-bottom:1px solid #eff2dc;margin-bottom:0}.persona_destacada .terms{display:none}.node.blog div.links li.blog_usernames_blog{display:none}.node.blog .terms li:first-child{display:none}.field-field-evento-educ-imagen{float:left;margin-right:20px;border:2px solid #df7e00}.field-field-evento-educ-imagen img{display:block}.node.cineforo{background-color:#5e644e;color:#fff}#grueso .node.cineforo h2{color:#fff;border-bottom:2px solid #df7e00}.field-field-cineforo-imagen{float:left;margin-right:20px;border:2px solid #df7e00}.field-field-cineforo-imagen img{display:block}#grueso .node.cineforo form.fivestar-widget{clear:none;overflow:hidden;background-color:#5e644e;border-top:0;border-right:0;border-bottom:2px solid #88ab0c;border-left:none;padding:0}.field-field-cineforo-fecha,.field-field-cineforo-lugar{font-size:1.2em;margin-bottom:5px;font-weight:bold}.field-field-cineforo-ciclo table.views-view-grid td{background:0;padding:0;height:30px}.field-field-cineforo-ciclo table.views-view-grid td a{border:2px solid #88ab0c;display:inline-block;font-size:14px}.field-field-cineforo-ciclo table.views-view-grid td a:hover{border:2px solid #df7e00}.field-field-cineforo-ciclo table.views-view-grid td a img{display:block}.field-field-cineforo-ciclo-nombre{border-bottom:2px solid #df7e00;color:#fff;font-size:1.4em;margin-top:20px;font-weight:bold;padding-bottom:10px;margin-bottom:10px}.node.cineforo .terms{display:none}.view-bienestar-cineforo-actual .view-content td{background:0;padding:0}.view-bienestar-cineforo-actual .view-content td:first-child{padding:1px}.view-bienestar-cineforo-actual .view-content td a{border:2px solid #88ab0c;display:block}.view-bienestar-cineforo-actual .view-content td a:hover{border:2px solid #df7e00}div.view-bienestar-cineforo-actual table{border-collapse:inherit}.view-bienestar-cineforo-actual{background-color:#5e644e;font-family:'PTSansBold';margin-bottom:6px}.view-bienestar-cineforo-actual .view-header{background-color:#5e644e;padding:5px;color:#FFF}.field-field-clasificado-tira-imagen{float:left}.view-bienestar-clasificados .view-content{background-color:#fff;padding:20px}.view-bienestar-clasificados .view-content td{padding:5px}.view-bienestar-clasificados .view-content td:first-child{vertical-align:middle;text-align:center}.views-exposed-widgets>div{float:left}.views-exposed-widgets .views-exposed-widget .form-item{width:280px}#grueso .views-exposed-widgets .views-exposed-widget input.form-submit{margin-top:30px}#grueso .view-filters form{padding:20px 20px 0}#block-views-16be10bf5c0711b26fbf886ecdb79f91 .view-header h5{text-align:left}#block-views-16be10bf5c0711b26fbf886ecdb79f91 .view-content ul{padding:0;background-color:#fff}#block-views-16be10bf5c0711b26fbf886ecdb79f91 .view-content li{font-size:.9em;padding:0 5px 5px 0;line-height:1em;margin:0 0 0 25px}#block-views-16be10bf5c0711b26fbf886ecdb79f91 .view-footer{margin-top:-5px;background-color:#fff;padding:10px;text-align:right}.group-clasificado-info-basica{margin-bottom:20px}.group-clasificado-info-basica p{display:inline}.group-clasificado-info-basica div.field-item{padding:10px 0;border-bottom:1px solid #eee}.node.entrada .terms li:first-child{display:none}.entrada{position:relative;height:239px}#grueso .entrada h2,#destacado .entrada h2{position:absolute;margin:10px 0 10px 400px;z-index:90;border:0;height:auto;font-family:'PTSansRegular',sans-serif;font-weight:normal;font-size:1.5em;line-height:.8em;color:#000}.entrada .field-field-entrada-texto,.entrada .field-field-entrada-imagen{position:absolute}.entrada .field-field-entrada-texto{margin-left:400px;margin-right:40px;margin-top:50px;z-index:90}
.entrada .field-field-entrada-texto p{margin:0;padding:0}.entrada div.clear-block.etiquetas{position:absolute;z-index:90;bottom:30px;margin-left:400px}ul.links li{padding:0}.entrada ul{padding:0}.telon-oscuro{background:url(/sites/default/themes/ueb/images/fondo-telon-blanco.png) repeat scroll 0 0 transparent;height:259px;position:relative;float:right;width:300px;margin-top:-17px;z-index:0}.view-calendario-academico .attachment-after{width:550px}.mapa-becas .view-content{padding:0 10px 10px;background-color:#fff}.anclaje{left:-1000px;margin-top:-100px;position:absolute}.view.electivas .view-content{background-color:#fff;padding:20px;line-height:1em}.view.electivas .view-content caption{font-size:1.3em;padding:10px;color:#df7e00;margin-top:-19px}.electivaclass{color:black;font-size:13px;text-align:justify}.view.electivas .view-content table:nth-child(2) caption{margin-top:0}.view.electivas .view-content caption p{font-weight:normal;color:#3e4729;text-align:left;font-size:.65em;text-align:left;line-height:1.3em;margin:10px auto}.view.electivas .view-content td{vertical-align:top;font-size:.8em;padding:3px;max-width:200px}.view.electivas .view-content td p{margin:0;padding:0}.view.electivas .view-content td.views-field p{text-align:center}.view.electivas table.sticky-header{margin-top:87px;z-index:90}.view.electivas table.sticky-header thead th{padding:0;line-height:1.0em;padding:3px;color:#df7e00;padding-top:10px}.view.electivas table.sticky-table thead th{padding:0;line-height:1.0em;padding:3px;color:#df7e00;padding-top:10px}#grueso div.view.electivas fieldset.collapsible legend a{padding:0 0 5px 15px;margin:0}.view.electivas .view-content td.views-field:first-child{font-weight:bold}.view.electivas .view-content td.views-field:last-child{padding:0}#grueso div.view.electivas .view-content tr.odd,#grueso div.view.electivas .view-content tr.even{background:0}#grueso .view-electivas-indice .views-field-field-electiva-salon-lista-value{width:auto}#grueso div.view.electivas .view-content tr.odd.node-unpublished,#grueso div.view.electivas .view-content tr.even.node-unpublished{background-color:#fae9bf}#grueso .view.electivas .view-content table.sticky-table tbody{margin:0;padding:0;border:0}#grueso div.view.electivas .view-content fieldset.collapsible{border-bottom:1px solid #eff2dc}#grueso .view.electivas .view-content fieldset.collapsible .fieldset-wrapper>div{padding-left:30px}#grueso .view.electivas td:last-child p{margin-bottom:10px}#grueso .view.electivas td:last-child p.rteindent1{margin-left:20px}#grueso .view.electivas td:last-child p.rteindent2{margin-left:40px}.views-field-field-electiva-intensidad-value{width:80px}.views-field-field-electiva-creditos-value,.views-field-field-electiva-intensidad-value{text-align:center}.views-field-field-electiva-horario-value{width:200px}.field-type-text .field-items table,.field-type-text .field-items table tr,.field-type-text .field-items table td{border:0;padding:5px;border-collapse:separate;vertical-align:top}#grueso .field-type-text .field-items table td p{margin:0}#grueso #node-867 h2,#grueso #node-864 h2{background-color:#c10a47;color:#fff;padding:5px;position:relative}#grueso #node-866 h2,#grueso #node-865 h2{background-color:#b91c4c;color:#fff;padding:5px;position:relative}.row-1 row-first{#dde1bf}#block-views-blog_ri-block_1{margin-bottom:10px}#block-views-blog_ri-block_1 h2{font-style:normal}.view-galerias-internacionalizacion{background-color:#fff;overflow:hidden;clear:right;padding:20px 30px}.view-galerias-internacionalizacion .view-content{width:65%;position:relative;float:left}.view-galerias-internacionalizacion .view-footer{position:relative;float:right;width:35%;z-index:1}.view-galerias-internacionalizacion .galeria_ri_titulo{font-size:1em;color:#e77f18;padding-right:20px}.view-galerias-internacionalizacion .galeria_ri_descripcion{font-size:.8em;line-height:17px;padding-right:20px}.view-galerias-internacionalizacion .view-content>div.views-row{margin-bottom:0}.view-blog-ri .view-content .views-view-grid .node{margin-bottom:0;border:0}.view-galerias-internacionalizacion #galeria_ri_boton{background-color:#88ab0c;margin-top:10px;padding:2px 10px 2px 135px;font-size:.8em;color:#fff}
.view-galerias-internacionalizacion #galeria_ri_boton a{color:#fff;text-align:right}#menu .block#block-menu-menu-internacionalizacion{background:0;border:0;padding:none;text-align:right}.view-diplomados table.views-view-grid td{padding:10px}#grueso #node-742 h2,#grueso #node-2119 h2,#grueso #node-2120 h2,#grueso #node-2121 h2,#grueso #node-2122 h2,#grueso #node-2123 h2,#grueso #node-2136 h2,#grueso #node-2306 h2,#grueso #node-2307 h2,#grueso #node-2309 h2,#grueso #node-2310 h2,#grueso #node-2473 h2,#grueso #node-2719 h2,#grueso #node-2721 h2,#grueso #node-2722 h2,#grueso #node-2723 h2{display:none}.tab-categorias a{display:block;padding:8px 10px;font-size:.9em;text-align:right;color:#fff;line-height:1.1em;-webkit-transition:.2s all;-moz-transition:.2s all;-ms-transition:.2s all;-o-transition:.2s all;transition:.2s all}.tab-categorias>div{float:right;width:220px;margin-left:4px;position:relative;margin-top:-2px}.tab-categorias>.tab3{width:100px}.tab-categorias div a.active{border:0;margin-top:5px}.tab-categorias .tab3 a.active:hover,.tab-categorias .tab3 a.active{color:#fff;background-color:#3f482b}.tab-categorias .tab3 a:hover{background-color:#3f482b;color:#fff}.tab-categorias div a.active+div{display:block}.tab-categorias .tab3 a{background-color:#88ab0c}.tab-categorias .tab2 a{background-color:#97004a}.tab-categorias .tab2 a:hover,.tab-categorias .tab2 a.active{background-color:#97004a;color:#fff}.tab-categorias .tab1 a{background-color:#cf297b}.tab-categorias .tab1 a:hover,.tab-categorias .tab1 a.active{background-color:#cf297b;color:#fff}.gestion+.tab-categorias .tab2 a{background-color:#ca005d}.gestion+.tab-categorias .tab2 a:hover,.gestion+.tab-categorias .tab2 a.active{background-color:#ca005d;color:#fff}.gestion+.tab-categorias .tab1 a{background-color:#fa2989}.gestion+.tab-categorias .tab1 a:hover,.gestion+.tab-categorias .tab1 a.active{background-color:#fa2989;color:#fff}.tab-categorias{background-color:#fff;padding-left:5px;margin-top:15px;border-top:1px solid #dde3bd;height:70px}.tab-categorias div:nth-child(3) .arrow-down{border-top:10px solid #3f482b}.tab-categorias div:nth-child(2) .arrow-down{border-top:10px solid #97004a}.tab-categorias div:nth-child(1) .arrow-down{border-top:10px solid #cf297b}.gestion+.tab-categorias div:nth-child(2) .arrow-down{border-top:10px solid #ca005d}.gestion+.tab-categorias div:nth-child(1) .arrow-down{border-top:10px solid #fa2989}.view-cursos-certificados .view-header h3,.cursos-artesanias-head h3{margin-top:30px;text-align:left}.view-cursos-certificados .view-header h3{font-size:1.05em;white-space:nowrap}.cursos-artesanias-head{width:678px}.img-desdacada{border-bottom:5px solid #3e4729;height:200px}.tab-cursos{position:relative;float:right;padding-left:5px;margin-top:-30px}.tab-cursos .active{display:block;background-color:#fff;color:#88ab0c}.tab-cursos .active+.arrow-down{display:block}.tab-cursos .active:after{content:" "}.tab-cursos a{display:block;background-color:#88ab0c;width:150px;text-align:right;padding:23px 25px 23px;font-size:1.05em;line-height:1em;color:#fff;text-decoration:none;-webkit-transition:.2s all;-moz-transition:.2s all;-ms-transition:.2s all;-o-transition:.2s all;transition:.2s all;padding-bottom:15px;margin-top:-30px;border-top:1px solid #fff}.tab-cursos a.active{border:0;padding-bottom:30px}.tab-cursos div:nth-child(1) .arrow-down{border-top:10px solid #623a16}.tab-cursos>div{margin-right:5px;float:left}.certificado_enlace{float:left}.tab-cursos div a.active+div{display:block}.tab-cursos div a:hover,.tab-categorias div a:hover{background-color:#fff;color:#3e4729}.view-cursos-certificados .creditos_cursos{text-align:center;background-color:#784d44;font-size:3em}.view-cursos-certificados .views-row .views-field-phpcode p{margin:0;float:left}.view-cursos-certificados .views-row .views-field-phpcode{border:1px solid #000;min-height:70px}.tab-cursos .general{border-top:medium none;float:left;font-size:1em;margin:-7px 103px 0 5px;padding:8px 0!important;text-align:center}.tab-cursos .active.general{margin-top:4px}#grueso .view-cursos-certificados .views-row div fieldset.collapsible legend a,#grueso .view-cursos-certificados .views-row div fieldset.collapsible.collapsed legend a{background:0;padding:5px 20px 5px 5px}
#grueso .view-cursos-certificados .views-row div fieldset.collapsible,#grueso .view-cursos-certificados .views-row div fieldset.collapsible.collapsed{border:0}.view-cursos-certificados .columnilla{float:left;width:220px;margin-left:15px}.tab-categorias .active span{display:none}.tab-categorias .arrow-down,.tab-cursos .arrow-down{width:0;height:0;border-left:10px solid transparent;border-right:10px solid transparent;border-top:10px solid #3f482b;float:right;margin-right:15px;display:none}.cursos-artesanias-head .contenido h4{border-width:0;font-size:1.1em;margin:0 0 20px}.cursos-artesanias-head .contenido{padding-top:8px 0;text-align:left}.cursos-artesanias-head .contenido>h3+p{padding:0;margin:20px 0 0 0;font-size:.9em}.gestion .cursos-artesanias-head .contenido>p+p,.diseno .cursos-artesanias-head .contenido>p+p{padding:0;margin:0;font-size:.7em}.view-cursos-certificados .view-header{padding:20px}.view-cursos-certificados .view-content{float:left;background-color:#fff;position:relative;width:100%;padding-bottom:20px}.view-cursos-certificados .view-content .cursos-creditos{position:absolute;font-size:2.5em;text-align:center;color:#fff;z-index:1}.view-cursos-certificados .view-content .cursos-creditos span{display:table;font-size:.25em;padding:0 5px;line-height:0/9}#grueso .view-cursos-certificados .columnilla fieldset.collapsible legend{padding:0 0 0 50px;font-size:.8em;width:168px}#grueso .view-cursos-certificados .columnilla fieldset.collapsible{line-height:1.1em;border:0}#grueso .view-cursos-certificados .columnilla fieldset.collapsible.collapsed legend{width:170px}.view-cursos-certificados .columnilla>div{border:1px solid #ced2af;margin-bottom:15px;background-color:#eff2dc;overflow:hidden;background:#eff2dd}.view-cursos-certificados .columnilla>div.node-unpublished{background-color:#fae9bf}#grueso .view-cursos-certificados .columnilla fieldset.collapsible .fieldset-wrapper{width:100%;background-color:#fff}#grueso .view-cursos-certificados .columnilla fieldset.collapsible .fieldset-wrapper>div{padding:0}#grueso .view-cursos-certificados .columnilla fieldset.collapsible .fieldset-wrapper>div>div{padding:0 10px}#grueso .view-cursos-certificados .columnilla fieldset.collapsible legend a,#grueso .view-cursos-certificados .columnilla fieldset.collapsible.collapsed legend a{background:0;height:53px;padding-bottom:10px/9;padding:5px 25px 0 10px;line-height:1em}.view-cursos-certificados .view-content .produccion_artesanal_sostenible{background-color:#97004a;height:58px}.view-cursos-certificados .view-content .produccion_artesanal_sostenible+.arrow-right{border-left:5px solid #97004a}.view-cursos-certificados .view-content .diseno_desarrollo_producto_artesanal{background-color:#cf297b;height:58px}.view-cursos-certificados .view-content .diseno_desarrollo_producto_artesanal+.arrow-right{border-left:5px solid #cf297b}.view-cursos-certificados .view-content .comercializacion_artesanias{background-color:#ca005d;height:58px}.view-cursos-certificados .view-content .comercializacion_artesanias+.arrow-right{border-left:5px solid #ca005d}.view-cursos-certificados .view-content .gestion_productos_empresas_artesanias{background-color:#fa2989;height:58px}.view-cursos-certificados .view-content .gestion_productos_empresas_artesanias+.arrow-right{border-left:5px solid #fa2989}.columnilla .arrow-right{width:0;height:0;border-top:5px solid transparent;border-bottom:5px solid transparent}#grueso .view-cursos-certificados .columnilla fieldset.collapsible.collapsed legend a{background:url("/sites/default/files/imagenes/arrow-expandir.jpg") no-repeat scroll 99% 60% transparent;color:#7b8960;font-size:.98em}#grueso .view-cursos-certificados .columnilla .fieldset-wrapper .views-field-phpcode{background-color:#88ab0c;border:medium none;min-height:0;padding-bottom:5px!important;padding-right:10px;padding-top:5px!important;text-align:right;-webkit-transition:.2s all;-moz-transition:.2s all;-ms-transition:.2s all;-o-transition:.2s all;transition:.2s all}#grueso .view-cursos-certificados .columnilla .fieldset-wrapper .views-field-phpcode:hover{background:#678211}#grueso .view-cursos-certificados .columnilla .fieldset-wrapper .views-field-phpcode span a{color:#fff;font-size:.9em;font-style:italic;text-transform:uppercase}#grueso .view-cursos-certificados .view-header .descripcion{background-color:#fff;text-align:left}
.cursos-artesanias-head .col-izq{float:left;width:45%;padding-right:30px;border-right:1px solid #e5e6e1;margin-top:20px}.cursos-artesanias-head .col-derecha{float:left;margin-left:30px;width:45%;margin-top:20px}#grueso #node-2406+a+.block-views,#grueso #node-2406+.block-views{margin:0 20px 0 20px;padding:20px 40px 0 0;background:#fff;border-top:4px solid #88ab0c}#grueso #node-2406+a+.block-views+.block-views,#grueso #node-2406+.block-views+.block-views{margin:10px 20px 0;padding:20px 0 0 0;background:#fff;border-top:1px solid #e5e6e1}#grueso.artesanias{background:#fff;overflow:hidden;padding-bottom:20px;font-size:1em}#grueso>#node-2406{margin-bottom:0;padding-bottom:10px}.view-cursos-certificados-testimonios .view-header>p{background:url("/sites/default/files/imagenes/loquedicen.png") no-repeat;height:66px;margin:0;position:absolute;text-indent:-9999px;width:155px}.view-cursos-certificados-testimonios.view-display-id-block_2 .views-field-title{text-transform:uppercase;margin-bottom:2px}.views-field-field-curso-certificado-testimonio-value>div{float:right;background:#e9890e;width:220px;padding:20px;font-style:italic;font-size:.9em;color:#fff;margin-top:35px;line-height:1.3em}.views-field-field-curso-certificado-autor-testimonio-value{float:right;color:#88ab0c;font-family:"Times New Roman",Times,serif;font-style:italic;font-size:1.1em;width:100%;text-align:right;margin-top:2px}.view-id-cursos_certificados_testimonios .views-field-field-curso-certificado-autor-testimonio-value+.views-field-title,.view-id-cursos_certificados_testimonios .views-field-field-curso-certificado-testimonio-value+.views-field-title{float:right;color:#7d7f67;font-family:"Times New Roman",Times,serif;font-style:italic;font-size:.9em;text-align:right;line-height:1em;margin-top:2px}.views-field-field-curso-certificado-testimonio-value{padding-bottom:8px;background:url("/sites/default/files/imagenes/loquedicen-arrow.png") no-repeat bottom right;overflow:hidden}.view-cursos-certificados .view-content .cursos-creditos .diseno_desarrollo_producto_artesanal>div,.view-cursos-certificados .view-content .produccion_artesanal_sostenible>div,.view-cursos-certificados .view-content .comercializacion_artesanias>div,.view-cursos-certificados .view-content .gestion_productos_empresas_artesanias>div{padding-top:12px;padding-top:16px\9}.views-field-field-curso-certificado-inversion-value,.views-field-field-curso-certificado-horas-presenciales-value{font-size:.8em;font-style:italic;padding-top:20px!important}.views-field-field-curso-certificado-horas-presenciales-value{padding-top:0!important}#grueso .view-cursos-certificados .field-content ul{padding-left:0}#grueso .view-cursos-certificados .field-content ul li{padding-left:10px;background:url("/sites/default/files/imagenes/dot-artesanias.png") no-repeat 0 5px}.view-cursos-certificados .field-content p,.view-cursos-certificados .field-content ul{font-size:.9em;color:#8d917a;margin:0;padding-bottom:10px;line-height:1em}.view-cursos-certificados .field-content>p:first-child,.view-cursos-certificados .field-content>ul:first-child{margin-top:10px}.view-cursos-certificados .descripcion>p{font-size:.9em;line-height:1.2em;margin-left:133px;border-top:1px dotted #dde3bd}.artesanias .views-field-field-galeria-imagen-fid a>img{border:1px solid #f4f4f4}.artesanias .views-field-field-galeria-imagen-fid a>img:hover{border:0}.artesanias .contactenos{color:#7d7f67;font-size:.85em;line-height:1.2em;margin-left:50px;width:310px;margin-top:-10px}.artesanias #block-views-4dc6c3746d5fee9cde8518998aa8e494 .view-content{float:left;width:300px;border-right:1px solid #e5e6e1;padding-right:40px}.artesanias #block-views-4dc6c3746d5fee9cde8518998aa8e494 .view-footer{float:left;width:300px}.artesanias .contacto-p{margin:0 0 10px 0}.diseno .condiciones,.gestion .condiciones{font-size:.7em;color:#8d917a;margin:0 0 25px;padding:0}#grueso .node .cursos-artesanias-head+.webform-client-form .form-checkboxes .form-item{background-color:rgba(227,232,204,0.3)}.view-cursos-certificados-testimonios .views-field-body p{color:#7d7f67;font-size:.85em;margin:0;padding:0 0 10px}
@font-face{font-family:'oswaldbold';src:url(/sites/default/themes/ueb/fonts/oswald/oswald-bold-webfont.eot);src:url(/sites/default/themes/ueb/fonts/oswald/oswald-bold-webfont.eot?#iefix) format('embedded-opentype'),url(/sites/default/themes/ueb/fonts/oswald/oswald-bold-webfont.woff) format('woff'),url(/sites/default/themes/ueb/fonts/oswald/oswald-bold-webfont.ttf) format('truetype'),url(/sites/default/themes/ueb/fonts/oswald/oswald-bold-webfont.svg#oswaldbold) format('svg');font-weight:normal;font-style:normal}h3>span.date-display-single{color:white;background:black;padding:0 5px 0 5px}.view-bienestar-eventos-mes fieldset.collapsible legend a,.date-display-numero{color:#fff}h3>span.date-display-single,.view-bienestar-eventos-mes fieldset.collapsible legend a,.date-display-numero,.view-bienestar-eventos-mes .view-header{font:normal normal 1em 'oswaldbold';text-transform:uppercase}#destacado .view-bienestar-eventos-mes fieldset.collapsible>div.fieldset-wrapper .view-content>div,#destacado .view-bienestar-eventos-mes fieldset.collapsible>div.fieldset-wrapper .view-content>div table{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}#destacado .view-bienestar-eventos-mes fieldset.collapsible>div.fieldset-wrapper .view-content>div,#block-views-bienestar_eventos_mes-block_1 .calBienestar .view-content div,.view-bienestar-eventos-mes.calBienestar .view-content div{margin-left:7px}#block-views-bienestar_eventos_mes-block_1 .calBienestar .view-content div,.view-bienestar-eventos-mes.calBienestar .view-content div{float:left;width:135px}#destacado .view-bienestar-eventos-mes fieldset.collapsible>div.fieldset-wrapper .view-content>div td,.view-bienestar-eventos-mes .view-content>div td{padding:0}#destacado .view-bienestar-eventos-mes fieldset.collapsible>div.fieldset-wrapper .view-content>div h3{margin:0 0 15px}#destacado .view-bienestar-eventos-mes fieldset.collapsible>div.fieldset-wrapper .view-content>div td>div:first-child,#block-views-bienestar_eventos_mes-block_2 table.views-view-grid td>div:first-child,.view-bienestar-eventos-mes .view-content>div td>div:first-child{border-top:1px solid #fff;border-top:1px solid rgba(255,255,255,.15);padding:5px 0 0;font-weight:bold}#destacado .view-bienestar-eventos-mes fieldset.collapsible>div.fieldset-wrapper .view-content>div td>div:last-child,#block-views-bienestar_eventos_mes-block_2 table.views-view-grid td>div:last-child,.view-bienestar-eventos-mes .view-content>div td>div:last-child{border-bottom:1px solid #000;border-bottom:1px solid rgba(0,0,0,.1);padding:0 0 5px}html.js .calBienestar>fieldset>div.fieldset-wrapper{overflow:hidden}#block-views-bienestar_eventos_mes-block_1 .calBienestar fieldset{margin-left:-15px;width:730px;margin-bottom:10px}body.page-bienestar.not-front #destacado{overflow:inherit}#block-views-bienestar_eventos_mes-block_1 .calBienestar fieldset legend{-webkit-border-radius:15px;-moz-border-radius:15px;border-radius:15px}#block-views-bienestar_eventos_mes-block_1 .calBienestar fieldset.collapsed,#block-views-bienestar_eventos_mes-block_2 .calBienestar fieldset.collapsed{background:0}#promocional .view-bienestar-eventos-mes .view-header{margin:0}body.not-front #promocional #block-views-bienestar_eventos_mes-block_2.block-views{margin-bottom:6px}body.page-node .views-field-field-noticia-bienestar-imagen-promocional-fid{float:left;margin-right:10px}body.page-bienestar #grueso .block-views .views-field-field-noticia-bienestar-imagen-promocional-fid{float:left;margin-right:10px}#block-block-235.clear-block:after{content:none}#destacado #block-views-bienestar_eventos_mes-block_1 .views-field-field-prog-mensual-fecha-value-1,#destacado #block-views-bienestar_eventos_mes-block_1 .views-field-field-prog-mensual-hora-value,#block-views-bienestar_eventos_mes-block_2 .views-field-field-prog-mensual-fecha-value-1,#destacado #block-views-bienestar_eventos_mes-block_2 .views-field-field-prog-mensual-hora-value,div#block-block-185+div.view-bienestar-eventos-mes .view-content .views-field-field-prog-mensual-hora-value,div#block-block-185+div.view-bienestar-eventos-mes .view-content .views-field-field-prog-mensual-fecha-value-1{width:auto;font-style:italic}
#block-views-bienestar_eventos_mes-block_1 .views-field-field-prog-mensual-hora-value:before,#block-views-bienestar_eventos_mes-block_2 .views-field-field-prog-mensual-hora-value:before,div#block-block-185+div.view-bienestar-eventos-mes .view-content .views-field-field-prog-mensual-hora-value:before{content:" - ";margin-left:3px}.piebienestar{clear:both;background:#000;background:rgba(0,0,0,.3);padding:10px;color:#fff;margin-top:5px;font-size:.9em;line-height:.8em}.piebienestar:hover{background:rgba(0,0,0,.5)}.piebienestar a{color:#fff;display:block}#block-views-bienestar_eventos_mes-block_1 .calBienestar .view-header h2{text-align:left}#block-views-bienestar_eventos_mes-block_2 table.views-view-grid td{padding:0 20px}#block-views-bienestar_eventos_mes-block_2 h3>span.date-display-single{margin-left:20px}.contenedor .view-bienestar-eventos-mes .view-content>div td>div{margin-left:0}.view-bienestar-eventos-mes .view-header{color:#000}.contenedor .view-bienestar-eventos-mes .view-content>div td{background:0}div#block-block-185+div.view-bienestar-eventos-mes .view-content{background:rgba(255,255,255,.15);padding-bottom:20px;font-size:.9em}body.publicaciones_home{width:100%}body.publicaciones_home.not-front #destacado{width:auto}body.publicaciones_home.cuerpo_con_promo #grueso{width:740px}.view-publicaciones-encabezado{margin-bottom:20px}.view-publicaciones-encabezado .views-field-field-publicacion-imagen-portada-fid{margin-right:0}.view-publicaciones-encabezado tr.row-first td.col-first .views-field-field-publicacion-imagen-portada-fid img{height:230px;width:auto}.view-publicaciones-revista{width:170px;float:left}.view-publicaciones-encabezado .view-footer{background-color:#7d65b2}.view-publicaciones-encabezado .view-footer ul{list-style-type:none;padding:0;height:46px}.view-publicaciones-encabezado .view-footer ul li{float:left;width:240px;text-align:middle;height:100%;text-align:center;line-height:15px}.view-publicaciones-encabezado .view-footer ul li a{color:#fff;text-transform:uppercase;display:block;margin-top:10px}.view-publicaciones-lateral-home .view-content table.views-view-grid td{padding:10px}.publicaciones_home .clear-block .view-header{text-align:left}#block-block-203{background-color:#fff;margin-top:20px}#node-2502{display:none}body.publicaciones_home.cuerpo_con_promo .views-field-field-publicacion-imagen-portada-fid{float:none}.view-publicaciones-catalogo-secciones .view-content td>div,.view-publicaciones-lateral-home .view-content td>div{font-size:.9em;line-height:1.1em}.view-publicaciones-catalogo-secciones .view-content td>div{width:100px}.view-publicaciones-encabezado .view-content td>div{font-size:1.1em;line-height:1.1em}body.publicaciones_home.cuerpo_con_promo .clear-block .repositorio{float:right;line-height:200px;margin-right:5px}.cabezote-idioma{background-color:#fff;height:295px;padding:10px;width:700px}.cabezote-idioma img{width:698px}.idioma-caption{background-color:#3e4729;overflow:hidden}.idioma-titulo{color:#df7e00;float:left;font-size:1.8em;height:60px;line-height:60px;text-align:right;width:175px}.desc-idioma{color:#fff;float:left;font-size:.8em;height:60px;line-height:65px;padding:0 30px 0 10px;width:483px}.idioma-promos{background:#fff;height:60px;margin-bottom:10px}.view-centro-de-lenguas table.views-view-grid{background:#fff;border-spacing:1em;border-collapse:separate}.view-centro-de-lenguas table.views-view-grid td{background:rgba(239,242,220,0.3);border-bottom:1px solid #88ab0c;padding:1em 1em 0;-webkit-transition:.2s all;-moz-transition:.2s all;-ms-transition:.2s all;-o-transition:.2s all;transition:.2s all}.view-centro-de-lenguas table.views-view-grid td:hover{background:rgba(239,242,220,0.6)}.view-centro-de-lenguas td .views-field-title{padding-bottom:10px}.view-centro-de-lenguas td .views-field-view-node{margin-top:12px;text-align:right;width:100%}#autoevaluacion li.item-home-active,#autoevaluacion li.item-home-active a:hover,#autoevaluacion li.item-home a:hover{background:url("http://www.uelbosque.edu.co/sites/default/files/imagenes/institucionales/autoevaluacion/globos.png") no-repeat scroll center -124px #cd3362}
#autoevaluacion li.item-home-active a{background:0;width:10px;text-indent:-1000%}#autoevaluacion li.item-home{background:url("http://www.uelbosque.edu.co/sites/default/files/imagenes/institucionales/autoevaluacion/globos.png") no-repeat scroll 7px -124px #3e4729}#autoevaluacion li.item-home a{background:0;width:10px;text-indent:-1000%}#autoevaluacion li.item-home:hover{background:url("http://www.uelbosque.edu.co/sites/default/files/imagenes/institucionales/autoevaluacion/globos.png") no-repeat scroll 7px -124px #cd3362}.desplegable-menu{background:rgba(255,255,255,0.8);filter:progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr='#ffffff',endColorstr='#ffffff');height:0;list-style:none outside none;margin:0;overflow:hidden;padding:0;position:absolute;width:180px;z-index:-1;-webkit-transition:height .17s ease-in-out;-ms-transition:height .17s ease-in-out;-moz-transition:height .17s ease-in-out;-o-transition:height .17s ease-in-out;transition:height .17s ease-in-out}.desplegable-menu>li a{color:#3e4729;display:block;font-size:.8em;margin-top:2px;text-decoration:none;padding:5px 15px}.desplegable-menu>li a:hover{background:#fff;display:block}.general{margin:0;padding:0}.general>li{float:left;display:block;margin-left:7px;list-style:none;overflow:hidden}.general>li>a{background:url("http://www.uelbosque.edu.co/sites/default/files/imagenes/institucionales/autoevaluacion/globos.png") no-repeat scroll 8px 7px #3e4729;color:#fff;display:block;font-weight:bold;line-height:30px;padding:8px 17px;text-decoration:none;width:auto}.general>li>a:after{content:" \BB"}#autoevaluacion>li>a:hover,#autoevaluacion>li>a.current{background:#fff;color:#3e4729}#autoevaluacion>li:hover .desplegable-menu{margin-top:0;height:270px}#autoevaluacion>li:hover>a{color:#3e4729;background:#fff}.general>li:nth-child(3)>a,.general>li:nth-child(3)>a:hover{background:url("http://www.uelbosque.edu.co/sites/default/files/imagenes/institucionales/autoevaluacion/globos.png") no-repeat scroll 8px -38px #3e4729}.general>li:nth-child(4)>a,.general>li:nth-child(4)>a:hover{background:url("http://www.uelbosque.edu.co/sites/default/files/imagenes/institucionales/autoevaluacion/globos.png") no-repeat scroll 8px -81px #3e4729}.general>li:nth-child(5)>a,.general>li:nth-child(5)>a:hover{background:url("http://www.uelbosque.edu.co/sites/default/files/imagenes/institucionales/autoevaluacion/globos.png") no-repeat scroll 8px -159px #3e4729}.header-autoevaluacion{display:inline-block;margin:22px;position:relative}.head-autoevaluacion{background:#cd3362 url("http://www.uelbosque.edu.co/sites/default/files/imagenes/institucionales/autoevaluacion/promo_head-autoevaluacion.png") no-repeat;height:153px;width:678px}.nav-autoevaluacion{position:absolute;right:0;top:140px;z-index:1}#block-block-215{height:215px}body.node-type-boletin.portal_egresados .node{padding:0}body.node-type-boletin.portal_egresados .node .field-type-text .field-items table{border-collapse:collapse}body.node-type-boletin.portal_egresados #grueso h2{margin-bottom:20px;color:#fff!important}h3.anaranjado{font-size:1.2em;font-weight:bold;background-color:#eb8906;display:inline-block;color:#fff;padding:5px}p.nomargin{margin:0}table.horarios_deportes{border:3px solid #39F;width:328px}div.horarios_deportes{float:left;margin-right:20px}table.horarios_deportes td{border-bottom:1px solid #eee;padding:0 5px}table.horarios_deportes td.deportes-titulo{text-transform:uppercase;letter-spacing:.2em;font-weight:bold;font-size:.9em;background-color:#39F;padding:10px;color:#fff}table.horarios_deportes td.deporte_individual{background-color:#bddcfb;padding:5px;font-weight:bold}table.horarios_deportes td.genero{font-weight:bold;background:#eee}img.servicio-bienestar{float:left;width:329px;margin-right:10px;margin-bottom:10px}div.deporte-horarios img{float:left;margin-right:20px}div.deporte-horarios{border-top:2px solid #df7e00;overflow:hidden;margin-bottom:30px}div.deporte-horarios .nombre_deporte{color:#df7e00;font-size:1.4em;margin-top:10px!important;font-weight:bold}div.deporte-horarios div{float:left}div.deporte-horarios p{margin:0!important}div.deporte-horarios p.genero{font-weight:bold;margin-top:10px!important}#promocional #block-views-bienestar_actividades-block_1 .view-header{background:#3e4729;height:33px;padding:5px;margin:0}#promocional #block-views-bienestar_actividades-block_2 .view-header{background:#3e5194;height:33px;padding:5px;margin:0}#promocional #block-views-bienestar_actividades-block_3 .view-header{background:#bf3039;height:33px;padding:5px;margin:0}
#promocional #block-views-bienestar_actividades-block_1 .view-header img{float:left;margin-top:-5px}#promocional #block-views-bienestar_actividades-block_2 .view-header img{float:left;margin-top:-5px}#promocional #block-views-bienestar_actividades-block_3 .view-header img{float:left;margin-top:-5px}#promocional #block-views-bienestar_actividades-block_1 .view-header p{margin-left:10px;text-align:right}#promocional #block-views-bienestar_actividades-block_2 .view-header p{margin-left:10px;text-align:right}#promocional #block-views-bienestar_actividades-block_3 .view-header p{margin-left:10px;text-align:right}#promocional #block-views-bienestar_actividades-block_1 .view-content,#promocional #block-views-bienestar_actividades-block_2 .view-content,#promocional #block-views-bienestar_actividades-block_3 .view-content{background-color:#88ab0c;line-height:1em;padding:5px;text-align:right}#promocional #block-views-bienestar_actividades-block_1 .view-content a,#promocional #block-views-bienestar_actividades-block_2 .view-content a,#promocional #block-views-bienestar_actividades-block_3 .view-content a{color:#fff;font-size:1.2em}#promocional #block-views-bienestar_actividades-block_1 .view-content>div.views-row,#promocional #block-views-bienestar_actividades-block_2 .view-content>div.views-row,#promocional #block-views-bienestar_actividades-block_3 .view-content>div.views-row{background:0;margin-bottom:0}.view-noticias-bienestar table.views-view-grid td{padding:10px 0 10px 8px}body.page-bienestar ul.pager{background:#88ab0c;padding:5px!important;margin-bottom:30px!important}body.page-bienestar ul.pager li{padding:0;margin:0;display:inline-block}body.page-bienestar ul.pager a{padding:3px 10px;display:inline-block;color:#fff!important;font-weight:bold}body.page-bienestar ul.pager a:hover{display:inline-block;color:#88ab0c!important;background:#fff}.imagefield-field_noticia_bienestar_imagen_promocional,.imagefield-field_servicio_bienestar_imagen,.imagefield-field_actividad_bienestar_imagen{float:left;margin-right:20px}.field-field-actividad-bienestar-a-cargo{font-size:1.5em;padding:10px 0 5px 0;color:#df7e00}.field-field-actividad-bienestar-fecha{margin-bottom:10px;font-weight:bold}.imagefield-field_evento_bienestar_imagen_banner{margin:-2px 0 20px -21px}.field-field-evento-bienestar-fecha{font-size:1.3em}.field-field-evento-bienestar-lugar{margin:5px 0;border-top:#df7e00;color:#df7e00;font-weight:bold}.imagefield-field_entrada_imagen{width:676px}.node.entrada .clear-block:after{display:none}.front #grueso .block{margin-bottom:10px}.front #grueso .block-block{border-bottom:1px solid #dae0b8;background-color:#fff;-moz-box-shadow:0 5px 10px -5px #dae0b8;-webkit-box-shadow:0 5px 10px -5px #dae0b8;box-shadow:0 5px 10px -5px #dae0b8}.front .grueso .block-views .view-content{border-bottom:1px solid #dae0b8;background-color:#fff;-moz-box-shadow:0 5px 10px -5px #dae0b8;-webkit-box-shadow:0 5px 10px -5px #dae0b8;box-shadow:0 5px 10px -5px #dae0b8}.front #grueso #block-views-inicio_programas-block_1.block tr.row-2 div,.front #grueso #block-views-inicio_programas-block_1.block tr.row-3 div{display:none}.front #grueso #block-views-inicio_programas-block_1.block tr.row-2 div.views-field-title,.front #grueso #block-views-inicio_programas-block_1.block tr.row-3 div.views-field-title{display:block;font-size:1em}.front .views-view-grid tr td,.page-ri .views-view-grid tr td:first-child{padding:10px}.front .views-view-grid p:last-child,.page-ri .views-view-grid p:last-child{margin-bottom:0}.front .views-view-grid tr td:first-child{padding-right:10px}.page-ri .views-field-field-convocatoria-imagen-fid span.field-content{float:left;padding-right:10px}.front .views-view-grid td,.page-ri .views-view-grid td{vertical-align:top;border-bottom:1px solid #eff2dc;padding:0}body.page-educacion-continuada .views-view-grid{font-size:.9em}body.page-educacion-continuada .view-inicio-educacion-continuada td{vertical-align:top;border-bottom:1px solid #eff2dc;padding:10px}.front .views-view-grid tr.row-last td,.page-ri .views-view-grid tr.row-last td{border-bottom:0}.front .views-view-grid tr img,body.not-front .views-field-field-persona-destacada-imagen-fid img{float:left;margin-right:10px}.front #grueso .block-views li:hover{background-color:#fff}#grueso .view-medios-notas .item-list ul a{font-weight:normal}body.front #grueso .view-content li a{cursor:pointer;color:#596221}#grueso .view-content li:hover a{cursor:pointer}#grueso .view-content li .views-field-title .field-content{font-weight:bold;color:#596221}#grueso .view-content li{padding:0 5px 10px 5px;position:relative;list-style:none;margin:0;overflow:hidden;line-height:1em}.views-field-view-node{float:right;margin-top:-12px}.views-admin-links .links li span a{font-weight:bold;background:0}body.front #grueso .view-footer{text-align:right}.mas_pestana{float:right;margin-left:5px}.mas_enlace{display:block;border-left:1px solid #ceceba;background:url(/sites/default/themes/ueb/images/pestana_boton.png) bottom right;height:31px;color:#70764c;font-size:1em;line-height:30px;padding:0 5px}.mas_enlace:visited{color:#70764c}.mas_enlace:hover{color:#fff;background:url(/sites/default/themes/ueb/images/pestana_boton_hover.png) bottom right}#promocional1 p{margin:0}#node-3 h2{display:none}.field-field-programa-plan-extra>.field-label{color:#88ab0c}.field-field-programa-plan-extra h4{margin:20px 0 0 -20px}#grueso .field-field-programa-imagen .field-label{display:none}#grueso .field-field-programa-imagen .field-items div,#grueso .field-field-colegio-imagen-promocional .field-items div{height:180px}#grueso #node-1468 .field-field-programa-imagen .field-items div{height:auto}#grueso .fieldgroup.group-programa-normatividad legend,#grueso .fieldgroup.group-colegio-normatividad legend{display:none}#grueso .fieldgroup.group-programa-normatividad,#grueso .fieldgroup.group-colegio-normatividad{background-color:#3e4729;font-size:.9em;line-height:20px;height:auto}#grueso #node-336 .fieldgroup.group-programa-normatividad,#grueso #node-330 .fieldgroup.group-colegio-normatividad{line-height:15px;height:auto}.field-field-programa-abrebocas{font-size:1.2em}.field-field-programa-abrebocas h4{margin:0}.field-field-programa-imagen01,.field-field-programa-imagen02{float:left;margin-right:10px}.field-field-programa-facebook,.field-field-colegio-facebook{display:block;overflow:hidden}#grueso .fieldgroup.group-programa-normatividad>div,#grueso .fieldgroup.group-colegio-normatividad>div{float:left;padding:0 0 0 5px;margin:0;font-size:.8em}#grueso .fieldgroup.group-programa-normatividad>div>div,#grueso .fieldgroup.group-colegio-normatividad>div>div{float:left;color:#fff;font-weight:normal}#grueso .group-programa-normatividad>div>div>div,#grueso .group-colegio-normatividad>div>div>div{margin-right:20px;font-weight:bold}#grueso .node-form #edit-field-programa-creditos-0-value-wrapper,#grueso .node-form #edit-field-programa-horario-0-value-wrapper,#grueso .node-form #edit-field-programa-duracion-0-value-wrapper{float:left;width:30%;margin:0 20px 0 0}#grueso .node-form div#edit-field-programa-titulo-obtenido-0-value-wrapper{float:none;width:99%}#tabs-tabset div.field-type-text,.field-field-programa-persistente,.field-field-programa-registro,.field-field-programa-sin-pestana{width:460px;margin-bottom:20px}body.i18n-en #tabs-tabset div.field-type-text,body.i18n-fr #tabs-tabset div.field-type-text{width:auto}body.i18n-en ul.ui-tabs-nav li,body.i18n-fr ul.ui-tabs-nav li{visibility:hidden}div#plan-de-estudios div.field-item{padding-left:20px}#grueso div.field-field-programa-coordenadas .field-label,#grueso .field-field-programa-email-director .field-label,#grueso .field-field-programa-email-secretario .field-label,#grueso .field-field-programa-email-decano .field-label{display:none}
.node.programa_academico .content-multigroup-group-programa-equipo-a-cargo{font-size:.8em;line-height:1.2em;text-align:center;width:100%;position:relative}.node.programa_academico .content-multigroup-group-programa-equipo-a-cargo>fieldset{display:inline-block;text-align:center;margin:0 20px 20px;vertical-align:top}.node.programa_academico .content-multigroup-group-programa-equipo-a-cargo .field-field-programa-equipo-a-cargo-nombre{font-weight:bold}#grueso div.field-field-programa-coordenadas{background-color:#596221;padding:3px;color:#fff;overflow:hidden}#grueso .content-multigroup-group-programa-correos-facultad{text-align:center}#grueso div.field-field-programa-correos-facultad{width:100%;position:relative}#grueso .content-multigroup-group-programa-correos-facultad fieldset,#grueso .content-multigroup-group-programa-correos-facultad fieldset div{display:inline;text-align:center}#grueso .content-multigroup-group-programa-correos-facultad fieldset a{color:#fff;font-size:.8em;padding:0 5px;display:block}#grueso .content-multigroup-group-programa-correos-facultad fieldset a:hover{background-color:#3e4729}#grueso div.field-field-programa-coordenadas .field-items{background-color:rgba(0,0,0,0.2);color:#fff;font-size:.8em;padding:5px 3px;line-height:1;text-align:center}#grueso div.field-field-programa-persistente,div.field-field-programa-registro,div.field-field-programa-alta-calidad{padding:3px 0 5px 0;margin:0;width:100%;font-size:.7em;line-height:1;clear:both;overflow:hidden;text-align:center;color:#fff;background-color:#596221}#grueso div.field-field-programa-persistente .field-items,div.field-field-programa-registro .field-items,div.field-field-programa-alta-calidad .field-items{padding:0 5px}#grueso .field-field-programa-imagen+#tabs-tabset ul.ui-tabs-nav,#grueso .field-field-colegio-imagen-promocional+#tabs-tabset ul.ui-tabs-nav{padding-left:0;margin:-31px 0 0 0;padding-top:10px;border:0;line-height:1.1em}#grueso ul.ui-tabs-nav li a{margin:0 0 0 10px}#grueso ul.ui-tabs-nav li a span{border:0}#grueso ul.ui-tabs-nav li.ui-tabs-selected a{color:#596221;background-color:#fff}ul.primary li.ui-tabs-selected a{border:0}#grueso ul.ui-tabs-nav li.ui-tabs-selected a:hover{cursor:default;color:#596221;background-color:#fff}ul.primary li a{background-color:#88ab0c;color:#fff;padding:5px 10px;border:0}span.clear{height:3px;margin-bottom:20px}ul.primary li a:hover{background-color:#88ab0c;border-bottom:5px solid #fff;padding-bottom:0;color:#fff}#programa,#fortalezas,#plan-de-estudios,#generalidades,#fortalezas,#c-mo-ingresar{padding-top:25px}#promocional_programas{float:right;width:200px;margin-left:10px;margin-bottom:20px}.view-id-promo_academico label{display:none}#grueso .programa_academico div h2{font-family:'PTSansBold';font-weight:bold;font-size:1.4em}#grueso #node-177 h2,#grueso #node-2823 h2,#grueso #node-2805 h2{color:#fff;background-color:#86181b;padding:5px;position:relative}#grueso #node-177 .group-normatividad-men,#grueso #node-2823 .group-normatividad-men,#grueso #node-2805 .group-normatividad-men{width:678px;background-color:rgba(134,24,27,0.7);position:absolute}#grueso #node-177 .content-multigroup-group-programa-correos-facultad,#grueso #node-177 .field-field-programa-coordenadas,#grueso #node-177 .field-field-programa-persistente,#grueso #node-177 .field-field-programa-registro,#grueso #node-2823 .content-multigroup-group-programa-correos-facultad,#grueso #node-2823 .field-field-programa-coordenadas,#grueso #node-2823 .field-field-programa-persistente,#grueso #node-2823 .field-field-programa-registro,#grueso #node-2805 .content-multigroup-group-programa-correos-facultad,#grueso #node-2805 .field-field-programa-coordenadas,#grueso #node-2805 .field-field-programa-persistente,#grueso #node-2805 .field-field-programa-registro{background-color:#86181b}#grueso #node-178 h2,#grueso #node-2806 h2,#grueso #node-2824 h2{color:#fff;background-color:#bf2e25;padding:5px;position:relative}#grueso #node-178 .group-normatividad-men,#grueso #node-2806 .group-normatividad-men,#grueso #node-2824 .group-normatividad-men{width:678px;background-color:rgba(191,46,37,0.7);position:absolute}
#grueso #node-178 .content-multigroup-group-programa-correos-facultad,#grueso #node-178 .field-field-programa-coordenadas,#grueso #node-178 .field-field-programa-persistente,#grueso #node-178 .field-field-programa-registro,#grueso #node-2806 .content-multigroup-group-programa-correos-facultad,#grueso #node-2806 .field-field-programa-coordenadas,#grueso #node-2806 .field-field-programa-persistente,#grueso #node-2806 .field-field-programa-registro,#grueso #node-2824 .content-multigroup-group-programa-correos-facultad,#grueso #node-2824 .field-field-programa-coordenadas,#grueso #node-2824 .field-field-programa-persistente,#grueso #node-2824 .field-field-programa-registro{background-color:#bf2e25}#grueso #node-180 h2,#grueso #node-2810 h2,#grueso #node-2834 h2{color:#fff;background-color:#d60b52;padding:5px;position:relative}#grueso #node-180 .group-normatividad-men,#grueso #node-2810 .group-normatividad-men,#grueso #node-2834 .group-normatividad-men{width:678px;background-color:rgba(215,15,82,0.7);position:absolute}#grueso #node-180 .content-multigroup-group-programa-correos-facultad,#grueso #node-180 .field-field-programa-coordenadas,#grueso #node-180 .field-field-programa-persistente,#grueso #node-180 .field-field-programa-registro,#grueso #node-2810 .content-multigroup-group-programa-correos-facultad,#grueso #node-2810 .field-field-programa-coordenadas,#grueso #node-2810 .field-field-programa-persistente,#grueso #node-2810 .field-field-programa-registro,#grueso #node-2834 .content-multigroup-group-programa-correos-facultad,#grueso #node-2834 .field-field-programa-coordenadas,#grueso #node-2834 .field-field-programa-persistente,#grueso #node-2834 .field-field-programa-registro{background-color:#d60b52}#grueso #node-179 h2,#grueso #node-2813 h2,#grueso #node-2840 h2{color:#fff;background-color:#a01e21;padding:5px;position:relative}#grueso #node-179 .group-normatividad-men,#grueso #node-2813 .group-normatividad-men,#grueso #node-2840 .group-normatividad-men{width:678px;background-color:rgba(160,30,33,0.7);position:absolute}#grueso #node-179 .content-multigroup-group-programa-correos-facultad,#grueso #node-179 .field-field-programa-coordenadas,#grueso #node-179 .field-field-programa-persistente,#grueso #node-179 .field-field-programa-registro,#grueso #node-2813 .content-multigroup-group-programa-correos-facultad,#grueso #node-2813 .field-field-programa-coordenadas,#grueso #node-2813 .field-field-programa-persistente,#grueso #node-2813 .field-field-programa-registro,#grueso #node-2840 .content-multigroup-group-programa-correos-facultad,#grueso #node-2840 .field-field-programa-coordenadas,#grueso #node-2840 .field-field-programa-persistente,#grueso #node-2840 .field-field-programa-registro{background-color:#a01e21}#grueso #node-181 h2,#grueso #node-2808 h2,#grueso #node-2828 h2{color:#fff;background-color:#84ae40;padding:5px;position:relative}#grueso #node-181 .group-normatividad-men,#grueso #node-2808 .group-normatividad-men,#grueso #node-2828 .group-normatividad-men{width:678px;background-color:rgba(132,174,64,0.7);position:absolute}#grueso #node-181 .content-multigroup-group-programa-correos-facultad,#grueso #node-181 .field-field-programa-coordenadas,#grueso #node-181 .field-field-programa-persistente,#grueso #node-181 .field-field-programa-registro,#grueso #node-2808 .content-multigroup-group-programa-correos-facultad,#grueso #node-2808 .field-field-programa-coordenadas,#grueso #node-2808 .field-field-programa-persistente,#grueso #node-2808 .field-field-programa-registro,#grueso #node-2828 .content-multigroup-group-programa-correos-facultad,#grueso #node-2828 .field-field-programa-coordenadas,#grueso #node-2828 .field-field-programa-persistente,#grueso #node-2828 .field-field-programa-registro{background-color:#84ae40}#grueso #node-182 h2,#grueso #node-2811 h2,#grueso #node-2838 h2{color:#fff;background-color:#f99d1c;padding:5px;position:relative}#grueso #node-182 .group-normatividad-men,#grueso #node-2811 .group-normatividad-men,#grueso #node-2838 .group-normatividad-men{width:678px;background-color:rgba(249,157,28,0.7);position:absolute}
#grueso #node-182 .content-multigroup-group-programa-correos-facultad,#grueso #node-182 .field-field-programa-coordenadas,#grueso #node-182 .field-field-programa-persistente,#grueso #node-182 .field-field-programa-registro,#grueso #node-182 .field-field-programa-alta-calidad,#grueso #node-2811 .content-multigroup-group-programa-correos-facultad,#grueso #node-2811 .field-field-programa-coordenadas,#grueso #node-2811 .field-field-programa-persistente,#grueso #node-2811 .field-field-programa-registro,#grueso #node-2811 .field-field-programa-alta-calidad,#grueso #node-2838 .content-multigroup-group-programa-correos-facultad,#grueso #node-2838 .field-field-programa-coordenadas,#grueso #node-2838 .field-field-programa-persistente,#grueso #node-2838 .field-field-programa-registro,#grueso #node-2838 .field-field-programa-alta-calidad{background-color:#f99d1c}#grueso #node-186 h2,#grueso #node-2822 h2,#grueso #node-2850 h2{color:#fff;background-color:#f58220;padding:5px;position:relative}#grueso #node-186 .group-normatividad-men,#grueso #node-2822 .group-normatividad-men,#grueso #node-2850 .group-normatividad-men{width:678px;background-color:rgba(245,130,32,0.7);position:absolute}#grueso #node-186 .content-multigroup-group-programa-correos-facultad,#grueso #node-186 .field-field-programa-coordenadas,#grueso #node-186 .field-field-programa-persistente,#grueso #node-186 .field-field-programa-registro,#grueso #node-2822 .content-multigroup-group-programa-correos-facultad,#grueso #node-2822 .field-field-programa-coordenadas,#grueso #node-2822 .field-field-programa-persistente,#grueso #node-2822 .field-field-programa-registro,#grueso #node-2850 .content-multigroup-group-programa-correos-facultad,#grueso #node-2850 .field-field-programa-coordenadas,#grueso #node-2850 .field-field-programa-persistente,#grueso #node-2850 .field-field-programa-registro{background-color:#f58220}#grueso #node-184 h2,#grueso #node-2830 h2,#grueso #node-2853 h2{color:#fff;background-color:#e1740b;padding:5px;position:relative}#grueso #node-184 .group-normatividad-men,#grueso #node-2830 .group-normatividad-men,#grueso #node-2853 .group-normatividad-men{width:678px;background-color:rgba(225,116,0,0.7);position:absolute}#grueso #node-184 .content-multigroup-group-programa-correos-facultad,#grueso #node-184 .field-field-programa-coordenadas,#grueso #node-184 .field-field-programa-persistente,#grueso #node-184 .field-field-programa-registro,#grueso #node-2830 .content-multigroup-group-programa-correos-facultad,#grueso #node-2830 .field-field-programa-coordenadas,#grueso #node-2830 .field-field-programa-persistente,#grueso #node-2830 .field-field-programa-registro,#grueso #node-2853 .content-multigroup-group-programa-correos-facultad,#grueso #node-2853 .field-field-programa-coordenadas,#grueso #node-2853 .field-field-programa-persistente,#grueso #node-2853 .field-field-programa-registro{background-color:#e1740b}#grueso #node-187 h2,#grueso #node-2832 h2,#grueso #node-2854 h2{color:#fff;background-color:#dc4128;padding:5px;position:relative}#grueso #node-187 .group-normatividad-men,#grueso #node-2832 .group-normatividad-men,#grueso #node-2854 .group-normatividad-men{width:678px;background-color:rgba(220,65,40,0.7);position:absolute}#grueso #node-187 .content-multigroup-group-programa-correos-facultad,#grueso #node-187 .field-field-programa-coordenadas,#grueso #node-187 .field-field-programa-persistente,#grueso #node-187 .field-field-programa-registro,#grueso #node-2832 .content-multigroup-group-programa-correos-facultad,#grueso #node-2832 .field-field-programa-coordenadas,#grueso #node-2832 .field-field-programa-persistente,#grueso #node-2832 .field-field-programa-registro,#grueso #node-2854 .content-multigroup-group-programa-correos-facultad,#grueso #node-2854 .field-field-programa-coordenadas,#grueso #node-2854 .field-field-programa-persistente,#grueso #node-2854 .field-field-programa-registro{background-color:#dc4128}#grueso #node-185 h2,#grueso #node-2833 h2,#grueso #node-2855 h2{color:#fff;background-color:#f15a22;padding:5px;position:relative}#grueso #node-185 .group-normatividad-men,#grueso #node-2833 .group-normatividad-men,#grueso #node-2855 .group-normatividad-men{width:678px;background-color:rgba(241,90,34,0.7);position:absolute}
#grueso #node-185 .content-multigroup-group-programa-correos-facultad,#grueso #node-185 .field-field-programa-coordenadas,#grueso #node-185 .field-field-programa-persistente,#grueso #node-185 .field-field-programa-registro,#grueso #node-2833 .content-multigroup-group-programa-correos-facultad,#grueso #node-2833 .field-field-programa-coordenadas,#grueso #node-2833 .field-field-programa-persistente,#grueso #node-2833 .field-field-programa-registro,#grueso #node-2855 .content-multigroup-group-programa-correos-facultad,#grueso #node-2855 .field-field-programa-coordenadas,#grueso #node-2855 .field-field-programa-persistente,#grueso #node-2855 .field-field-programa-registro{background-color:#f15a22}#grueso #node-183 h2,#grueso #node-2835 h2,#grueso #node-2859 h2{color:#fff;background-color:#f1b51c;padding:5px;position:relative}#grueso #node-183 .group-normatividad-men,#grueso #node-2835 .group-normatividad-men,#grueso #node-2859 .group-normatividad-men{width:678px;background-color:rgba(241,181,28,0.7);position:absolute}#grueso #node-183 .content-multigroup-group-programa-correos-facultad,#grueso #node-183 .field-field-programa-coordenadas,#grueso #node-183 .field-field-programa-persistente,#grueso #node-183 .field-field-programa-registro,#grueso #node-2835 .content-multigroup-group-programa-correos-facultad,#grueso #node-2835 .field-field-programa-coordenadas,#grueso #node-2835 .field-field-programa-persistente,#grueso #node-2835 .field-field-programa-registro,#grueso #node-2859 .content-multigroup-group-programa-correos-facultad,#grueso #node-2859 .field-field-programa-coordenadas,#grueso #node-2859 .field-field-programa-persistente,#grueso #node-2859 .field-field-programa-registro{background-color:#f1b51c}#grueso #node-1468 h2,#grueso #node-2809 h2,#grueso #node-2831 h2{color:#fff;background-color:#c0590e;padding:5px;position:relative}#grueso #node-1468 .group-normatividad-men,#grueso #node-2809 .group-normatividad-men,#grueso #node-1468 .group-normatividad-men{width:678px;background-color:rgba(0,121,131,0.7);position:absolute}#grueso #node-1468 .content-multigroup-group-programa-correos-facultad,#grueso #node-1468 .field-field-programa-coordenadas,#grueso #node-1468 .field-field-programa-persistente,#grueso #node-1468 .field-field-programa-registro,#grueso #node-2809 .content-multigroup-group-programa-correos-facultad,#grueso #node-2809 .field-field-programa-coordenadas,#grueso #node-2809 .field-field-programa-persistente,#grueso #node-2809 .field-field-programa-registro,#grueso #node-2831 .content-multigroup-group-programa-correos-facultad,#grueso #node-2831 .field-field-programa-coordenadas,#grueso #node-2831 .field-field-programa-persistente,#grueso #node-2831 .field-field-programa-registro{background-color:#c0590e}#grueso #node-190 h2,#grueso #node-2812 h2,#grueso #node-2836 h2{color:#fff;background-color:#84192e;padding:5px;position:relative}#grueso #node-190 .group-normatividad-men,#grueso #node-2812 .group-normatividad-men,#grueso #node-2836 .group-normatividad-men{width:678px;background-color:rgba(132,25,46,0.7);position:absolute}#grueso #node-190 .content-multigroup-group-programa-correos-facultad,#grueso #node-190 .field-field-programa-coordenadas,#grueso #node-190 .field-field-programa-persistente,#grueso #node-190 .field-field-programa-registro,#grueso #node-2812 .content-multigroup-group-programa-correos-facultad,#grueso #node-2812 .field-field-programa-coordenadas,#grueso #node-2812 .field-field-programa-persistente,#grueso #node-2812 .field-field-programa-registro,#grueso #node-2836 .content-multigroup-group-programa-correos-facultad,#grueso #node-2836 .field-field-programa-coordenadas,#grueso #node-2836 .field-field-programa-persistente,#grueso #node-2836 .field-field-programa-registro{background-color:#84192e}#grueso #node-191 h2:after{content:" con énfasis en la enseñanza del inglés";font-size:.8em}#grueso #node-191 h2,#grueso #node-2825 h2,#grueso #node-2851 h2{color:#fff;background-color:#ecc500;padding:5px;position:relative}#grueso #node-191 .group-normatividad-men,#grueso #node-2825 .group-normatividad-men,#grueso #node-2851 .group-normatividad-men{width:678px;background-color:rgba(236,197,0,0.7);position:absolute}
#grueso #node-191 .content-multigroup-group-programa-correos-facultad,#grueso #node-191 .field-field-programa-coordenadas,#grueso #node-191 .field-field-programa-persistente,#grueso #node-191 .field-field-programa-registro,#grueso #node-2825 .content-multigroup-group-programa-correos-facultad,#grueso #node-2825 .field-field-programa-coordenadas,#grueso #node-2825 .field-field-programa-persistente,#grueso #node-2825 .field-field-programa-registro,#grueso #node-2851 .content-multigroup-group-programa-correos-facultad,#grueso #node-2851 .field-field-programa-coordenadas,#grueso #node-2851 .field-field-programa-persistente,#grueso #node-2851 .field-field-programa-registro{background-color:#ecc500}#grueso #node-192 h2,#grueso #node-2829 h2,#grueso #node-2852 h2{color:#fff;background-color:#d3ad07;padding:5px;position:relative}#grueso #node-192 .group-normatividad-men,#grueso #node-2829 .group-normatividad-men,#grueso #node-2852 .group-normatividad-men{width:678px;background-color:rgba(211,173,7,0.7);position:absolute}#grueso #node-192 .content-multigroup-group-programa-correos-facultad,#grueso #node-192 .field-field-programa-coordenadas,#grueso #node-192 .field-field-programa-persistente,#grueso #node-192 .field-field-programa-registro,#grueso #node-2829 .content-multigroup-group-programa-correos-facultad,#grueso #node-2829 .field-field-programa-coordenadas,#grueso #node-2829 .field-field-programa-persistente,#grueso #node-2829 .field-field-programa-registro,#grueso #node-2852 .content-multigroup-group-programa-correos-facultad,#grueso #node-2852 .field-field-programa-coordenadas,#grueso #node-2852 .field-field-programa-persistente,#grueso #node-2852 .field-field-programa-registro{background-color:#d3ad07}#grueso #node-195 h2,#grueso #node-2804 h2,#grueso #node-2821 h2{color:#fff;background-color:#0a4159;padding:5px;position:relative}#grueso #node-195 .group-normatividad-men,#grueso #node-2804 .group-normatividad-men,#grueso #node-195 .group-normatividad-men{width:678px;background-color:rgba(10,65,89,0.7);position:absolute}#grueso #node-195 .content-multigroup-group-programa-correos-facultad,#grueso #node-195 .field-field-programa-coordenadas,#grueso #node-195 .field-field-programa-persistente,#grueso #node-195 .field-field-programa-registro,#grueso #node-2804 .content-multigroup-group-programa-correos-facultad,#grueso #node-2804 .field-field-programa-coordenadas,#grueso #node-2804 .field-field-programa-persistente,#grueso #node-2804 .field-field-programa-registro,#grueso #node-2821 .content-multigroup-group-programa-correos-facultad,#grueso #node-2821 .field-field-programa-coordenadas,#grueso #node-2821 .field-field-programa-persistente,#grueso #node-2821 .field-field-programa-registro{background-color:#0a4159}#grueso #node-751 h2,#grueso #node-2807 h2,#grueso #node-2826 h2{color:#fff;background-color:#004946;padding:5px;position:relative}#grueso #node-751 .group-normatividad-men,#grueso #node-2807 .group-normatividad-men,#grueso #node-2826 .group-normatividad-men{width:678px;background-color:rgba(0,121,131,0.7);position:absolute}#grueso #node-751 .content-multigroup-group-programa-correos-facultad,#grueso #node-751 .field-field-programa-coordenadas,#grueso #node-751 .field-field-programa-persistente,#grueso #node-751 .field-field-programa-registro,#grueso #node-2807 .content-multigroup-group-programa-correos-facultad,#grueso #node-2807 .field-field-programa-coordenadas,#grueso #node-2807 .field-field-programa-persistente,#grueso #node-2807 .field-field-programa-registro,#grueso #node-2826 .content-multigroup-group-programa-correos-facultad,#grueso #node-2826 .field-field-programa-coordenadas,#grueso #node-2826 .field-field-programa-persistente,#grueso #node-2826 .field-field-programa-registro{background-color:#004946}#grueso #node-196 h2,#grueso #node-2815 h2,#grueso #node-2841 h2{color:#fff;background-color:#00b8a5;padding:5px;position:relative}#grueso #node-196 .group-normatividad-men,#grueso #node-2815 .group-normatividad-men,#grueso #node-2841 .group-normatividad-men{width:678px;background-color:rgba(0,184,165,0.7);position:absolute}
#grueso #node-196 .content-multigroup-group-programa-correos-facultad,#grueso #node-196 .field-field-programa-coordenadas,#grueso #node-196 .field-field-programa-persistente,#grueso #node-196 .field-field-programa-registro,#grueso #node-196 .field-field-programa-alta-calidad,#grueso #node-2815 .content-multigroup-group-programa-correos-facultad,#grueso #node-2815 .field-field-programa-coordenadas,#grueso #node-2815 .field-field-programa-persistente,#grueso #node-2815 .field-field-programa-registro,#grueso #node-2815 .field-field-programa-alta-calidad,#grueso #node-2841 .content-multigroup-group-programa-correos-facultad,#grueso #node-2841 .field-field-programa-coordenadas,#grueso #node-2841 .field-field-programa-persistente,#grueso #node-2841 .field-field-programa-registro,#grueso #node-2841 .field-field-programa-alta-calidad{background-color:#00b8a5}#grueso #node-197 h2,#grueso #node-197 h2,#grueso #node-197 h2{color:#fff;background-color:#007983;padding:5px;position:relative}#grueso #node-197 .group-normatividad-men,#grueso #node-2817 .group-normatividad-men,#grueso #node-2842 .group-normatividad-men{width:678px;background-color:rgba(0,121,131,0.7);position:absolute}#grueso #node-197 .content-multigroup-group-programa-correos-facultad,#grueso #node-197 .field-field-programa-coordenadas,#grueso #node-197 .field-field-programa-persistente,#grueso #node-197 .field-field-programa-registro,#grueso #node-2817 .content-multigroup-group-programa-correos-facultad,#grueso #node-2817 .field-field-programa-coordenadas,#grueso #node-2817 .field-field-programa-persistente,#grueso #node-2817 .field-field-programa-registro,#grueso #node-2842 .content-multigroup-group-programa-correos-facultad,#grueso #node-2842 .field-field-programa-coordenadas,#grueso #node-2842 .field-field-programa-persistente,#grueso #node-2842 .field-field-programa-registro{background-color:#007983}#grueso #node-198 h2,#grueso #node-2819 h2,#grueso #node-2843 h2{color:#fff;background-color:#009c9a;padding:5px;position:relative}#grueso #node-198 .group-normatividad-men,#grueso #node-2819 .group-normatividad-men,#grueso #node-2843 .group-normatividad-men{width:678px;background-color:rgba(0,156,154,0.7);position:absolute}#grueso #node-198 .content-multigroup-group-programa-correos-facultad,#grueso #node-198 .field-field-programa-coordenadas,#grueso #node-198 .field-field-programa-persistente,#grueso #node-198 .field-field-programa-registro,#grueso #node-2819 .content-multigroup-group-programa-correos-facultad,#grueso #node-2819 .field-field-programa-coordenadas,#grueso #node-2819 .field-field-programa-persistente,#grueso #node-2819 .field-field-programa-registro,#grueso #node-2843 .content-multigroup-group-programa-correos-facultad,#grueso #node-2843 .field-field-programa-coordenadas,#grueso #node-2843 .field-field-programa-persistente,#grueso #node-2843 .field-field-programa-registro{background-color:#009c9a}#grueso #node-199 h2,#grueso #node-2820 h2,#grueso #node-2844 h2{color:#fff;background-color:#005e6e;padding:5px;position:relative}#grueso #node-199 .group-normatividad-men,#grueso #node-2820 .group-normatividad-men,#grueso #node-2844 .group-normatividad-men{width:678px;background-color:rgba(0,94,110,0.7);position:absolute}#grueso #node-199 .content-multigroup-group-programa-correos-facultad,#grueso #node-199 .field-field-programa-coordenadas,#grueso #node-199 .field-field-programa-persistente,#grueso #node-199 .field-field-programa-registro,#grueso #node-2820 .content-multigroup-group-programa-correos-facultad,#grueso #node-2820 .field-field-programa-coordenadas,#grueso #node-2820 .field-field-programa-persistente,#grueso #node-2820 .field-field-programa-registro,#grueso #node-2844 .content-multigroup-group-programa-correos-facultad,#grueso #node-2844 .field-field-programa-coordenadas,#grueso #node-2844 .field-field-programa-persistente,#grueso #node-2844 .field-field-programa-registro{background-color:#005e6e}#grueso #node-1673 h2{color:#fff;background-color:#0090cb;padding:5px;position:relative}#grueso #node-1673 .group-normatividad-men{width:678px;background-color:rgba(0,121,131,0.7);position:absolute}
#grueso #node-1673 .content-multigroup-group-programa-correos-facultad,#grueso #node-1673 .field-field-programa-coordenadas,#grueso #node-1673 .field-field-programa-persistente,#grueso #node-1673 .field-field-programa-registro{background-color:#0090cb}#grueso #node-335 h2{color:#fff;background-color:#9b0f4c;padding:5px;position:relative}#grueso #node-335 .group-normatividad-men{width:678px;background-color:rgba(0,94,110,0.7);position:absolute}#grueso #node-335 .content-multigroup-group-programa-correos-facultad,#grueso #node-335 .field-field-programa-coordenadas,#grueso #node-335 .field-field-programa-persistente,#grueso #node-335 .field-field-programa-registro{background-color:#9b0f4c}#grueso #node-336 h2{color:#fff;background-color:#9b0f4c;padding:5px;position:relative}#grueso #node-336 .group-normatividad-men{width:678px;background-color:rgba(0,94,110,0.7);position:absolute}#grueso #node-336 .content-multigroup-group-programa-correos-facultad,#grueso #node-336 .field-field-programa-coordenadas,#grueso #node-336 .field-field-programa-persistente,#grueso #node-336 .field-field-programa-registro{background-color:#9b0f4c}#grueso #node-339 h2{color:#fff;background-color:#a01e21;padding:5px;position:relative}#grueso #node-339 .group-normatividad-men{width:678px;background-color:rgba(0,94,110,0.7);position:absolute}#grueso #node-339 .content-multigroup-group-programa-correos-facultad,#grueso #node-339 .field-field-programa-coordenadas,#grueso #node-339 .field-field-programa-persistente,#grueso #node-339 .field-field-programa-registro{background-color:#a01e21}#grueso #node-667 h2{color:#fff;background-color:#007983;padding:5px;position:relative}#grueso #node-667 .group-normatividad-men{width:678px;background-color:rgba(0,94,110,0.7);position:absolute}#grueso #node-667 .content-multigroup-group-programa-correos-facultad,#grueso #node-667 .field-field-programa-coordenadas,#grueso #node-667 .field-field-programa-persistente,#grueso #node-667 .field-field-programa-registro{background-color:#007983}#block-menu-menu-programas ul.menu li:nth-child(2) ul.menu li:nth-child(4) ul.menu{font-size:.8em}.fb_edge_widget_with_comment.fb_iframe_widget{float:left}.twitter-share-button.twitter-count-horizontal{float:right}#block-block-60{margin-bottom:10px}#grueso #node-864 .group-normatividad-men,#grueso #node-865 .group-normatividad-men,#grueso #node-866 .group-normatividad-men,#grueso #node-867 .group-normatividad-men{width:678px;background-color:rgba(215,15,82,0.7);position:absolute}#grueso #node-864 .content-multigroup-group-programa-correos-facultad,#grueso #node-864 .field-field-programa-coordenadas,#grueso #node-864 .field-field-programa-persistente,#grueso #node-864 .field-field-programa-registro,#grueso #node-865 .content-multigroup-group-programa-correos-facultad,#grueso #node-865 .field-field-programa-coordenadas,#grueso #node-865 .field-field-programa-persistente,#grueso #node-865 .field-field-programa-registro,#grueso #node-866 .content-multigroup-group-programa-correos-facultad,#grueso #node-866 .field-field-programa-coordenadas,#grueso #node-866 .field-field-programa-persistente,#grueso #node-866 .field-field-programa-registro,#grueso #node-867 .content-multigroup-group-programa-correos-facultad,#grueso #node-867 .field-field-programa-coordenadas,#grueso #node-867 .field-field-programa-persistente,#grueso #node-867 .field-field-programa-registro{background-color:#d60b52}#estilo360 table{background-color:#e3e3e6;border-collapse:inherit;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#estilo360 table table{border:#8aaa1c solid 1px;width:100%;background-color:#FFF;font-size:1.0em;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#nodo360-menu{border-top:#003d52 solid 1px}#nodo360-menu:hover{background-color:#003d52;color:#fff}#nodo360-menu:hover span{color:#fff}#nodo360-menu span{color:#003d52}#estilo360 table .tabla1{background-color:#FFF;border:#003d52 solid 1px;width:100%}#estilo360 table .tabla1:hover{background-color:#FF9}#estilo360 table .tabla1 .titular{border-bottom:#e3e3e6 solid 1px;color:#003d52;text-align:center;padding-right:4px}
#estilo360 table .tabla1 .subtitular{border-right:#e3e3e6 1px solid;color:#003d52}#estilo360 table .tabla1 .contenido{line-height:1.2em;border-bottom:1px solid #e3e3e6}#estilo360 table .tablaenlace{background-color:#fff;border:#003d52 solid 1px}#estilo360 table .tablaenlace a{background-color:#fff;color:#003d52}#estilo360 table .tablaenlace:hover{background-color:#003d52;color:#FFF}#estilo360 table .tablaenlace:hover a{background-color:#003d52;color:#FFF}#estilo344 table{background-color:#f8dedc;border-collapse:inherit;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#estilo344 table table{border:#8aaa1c solid 1px;width:100%;background-color:#FFF;font-size:1.0em;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#nodo344-menu{border-top:#86181b solid 1px}#nodo344-menu:hover{background-color:#86181b;color:#fff}#nodo344-menu:hover span{color:#fff}#nodo344-menu span{color:#86181b}#estilo344 table .tabla1{background-color:#FFF;border:#86181b solid 1px;width:100%}#estilo344 table .tabla1:hover{background-color:#FF9;8}#estilo344 table .tabla1 .titular{border-bottom:#f8dedc solid 1px;color:#86181b;text-align:center;padding-right:4px}#estilo344 table .tabla1 .subtitular{border-right:#f8dedc 1px solid;color:#86181b}#estilo344 table .tabla1 .contenido{line-height:1.2em;border-bottom:1px solid #f8dedc}#estilo344 table .tablaenlace{background-color:#fff;border:#86181b solid 1px}#estilo344 table .tablaenlace a{background-color:#fff;color:#86181b}#estilo344 table .tablaenlace:hover{background-color:#86181b;color:#FFF}#estilo344 table .tablaenlace:hover a{background-color:#86181b;color:#FFF}#estilo345 table{background-color:#f5e0d4;border-collapse:inherit;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#estilo345 table table{border:#8aaa1c solid 1px;width:100%;background-color:#FFF;font-size:1.0em;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#nodo345-menu1{border-top:#be241c solid 1px}#nodo345-menu1:hover{background-color:#be241c;color:#fff}#nodo345-menu1:hover span{color:#fff}#nodo345-menu1 span{color:#be241c}#estilo345 table .tabla1{background-color:#FFF;border:#be241c solid 1px;width:100%}#estilo345 table .tabla1:hover{background-color:#FF9}#estilo345 table .tabla1 .titular{border-bottom:#f5e0d4 solid 1px;color:#be241c;text-align:center;padding-right:4px}#estilo345 table .tabla1 .subtitular{border-right:#f5e0d4 1px solid;color:#be241c}#estilo345 table .tabla1 .contenido{line-height:1.2em;border-bottom:1px solid #f5e0d4}#estilo345 table .tablaenlace{background-color:#fff;border:#be241c solid 1px}#estilo345 table .tablaenlace a{background-color:#fff;color:#be241c}#estilo345 table .tablaenlace:hover{background-color:#be241c;color:#FFF}#estilo345 table .tablaenlace:hover a{background-color:#be241c;color:#FFF}#estilo355 table{background-color:#e8ecd2;border-collapse:inherit;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#estilo355 table table{border:#8aaa1c solid 1px;width:100%;background-color:#FFF;font-size:1.0em;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#nodo355-menu{border-top:#8aaa1c solid 1px}#nodo355-menu:hover{background-color:#8aaa1c;color:#fff}#nodo355-menu:hover span{color:#fff}#nodo355-menu4 span{color:#8aaa1c}#estilo355 table .tabla1{background-color:#FFF;border:#8aaa1c solid 1px;width:100%}#estilo355 table .tabla4:hover{background-color:#FF9}#estilo355 table .tabla1 .titular{border-bottom:#e8ecd2 solid 1px;color:#8aaa1c;text-align:center;padding-right:4px}#estilo355 table .tabla1 .subtitular{border-right:#e8ecd2 1px solid;color:#8aaa1c}#estilo355 table .tabla1 .contenido{line-height:1.2em;border-bottom:1px solid #e8ecd2}#estilo355 table .tablaenlace{background-color:#fff;border:#8aaa1c solid 1px}#estilo355 table .tablaenlace a{background-color:#fff;color:#8aaa1c}#estilo355 table .tablaenlace:hover{background-color:#8aaa1c;color:#FFF}#estilo355 table .tablaenlace:hover a{background-color:#8aaa1c;color:#FFF}
#estilo346 table,#estilo864 table,#estilo865 table,#estilo866 table,#estilo867 table{background-color:#f8dedc;border-collapse:inherit;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#estilo346 table table,#estilo864 table table,#estilo865 table table,#estilo866 table table,#estilo867 table table{border:#8aaa1c solid 1px;width:100%;background-color:#FFF;font-size:1.0em;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#nodo346-menu,#nodo864-menu,#nodo865-menu,#nodo866-menu,#nodo867-menu{border-top:#d2004a solid 1px}#nodo346-menu:hover,#nodo864-menu:hover,#nodo865-menu:hover,#nodo866-menu:hover,#nodo867-menu:hover{background-color:#d2004a;color:#fff}#nodo346-menu:hover span,#nodo864-menu:hover span,#nodo865-menu:hover span,#nodo866-menu:hover span,#nodo867-menu:hover span{color:#fff}#nodo346-menu span,#nodo864-menu span,#nodo865-menu span,#nodo866-menu span,#nodo867-menu span{color:#d2004a}#estilo346 table .tabla1,#estilo864 table .tabla1,#estilo865 table .tabla1,#estilo866 table .tabla1,#estilo867 table .tabla1{background-color:#FFF;border:#d2004a solid 1px;width:100%}#estilo346 table .tabla1:hover,#estilo864 table .tabla1:hover,#estilo865 table .tabla1:hover,#estilo866 table .tabla1:hover,#estilo867 table .tabla1:hover{background-color:#FF9}#estilo346 table .tabla1 .titular,#estilo864 table .tabla1 .titular,#estilo865 table .tabla1 .titular,#estilo866 table .tabla1 .titular,#estilo867 table .tabla1 .titular{border-bottom:#f8dedc solid 1px;color:#d2004a;text-align:center;padding-right:4px}#estilo346 table .tabla1 .subtitular,#estilo864 table .tabla1 .subtitular,#estilo865 table .tabla1 .subtitular,#estilo866 table .tabla1 .subtitular,#estilo867 table .tabla1 .subtitular{border-right:#f8dedc 1px solid;color:#d2004a}#estilo346 table .tabla1 .contenido,#estilo864 table .tabla1 .contenido,#estilo865 table .tabla1 .contenido,#estilo866 table .tabla1 .contenido,#estilo867 table .tabla1 .contenido{line-height:1.2em;border-bottom:1px solid #f8dedc}#estilo346 table .tablaenlace,#estilo864 table .tablaenlace,#estilo865 table .tablaenlace,#estilo866 table .tablaenlace,#estilo867 table .tablaenlace{background-color:#fff;border:#d2004a solid 1px}#estilo346 table .tablaenlace a,#estilo864 table .tablaenlace a,#estilo865 table .tablaenlace a,#estilo866 table .tablaenlace a,#estilo867 table .tablaenlace a{background-color:#fff;color:#d2004a}#estilo346 table .tablaenlace:hover,#estilo864 table .tablaenlace:hover,#estilo865 table .tablaenlace:hover,#estilo866 table .tablaenlace:hover,#estilo867 table .tablaenlace:hover{background-color:#d2004a;color:#FFF}#estilo346 table .tablaenlace:hover a,#estilo864 table .tablaenlace:hover a,#estilo865 table .tablaenlace:hover a,#estilo866 table .tablaenlace:hover a,#estilo867 table .tablaenlace:hover a{background-color:#d2004a;color:#FFF}#estilo351 table{background-color:#fee8c8;border-collapse:inherit;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#estilo351 table table{border:#8aaa1c solid 1px;width:100%;background-color:#FFF;font-size:1.0em;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#nodo351-menu{border-top:#f49e00 solid 1px}#nodo351-menu6:hover{background-color:#f49e00;color:#fff}#nodo351-menu:hover span{color:#fff}#nodo351-menu span{color:#f49e00}#estilo351 table .tabla1{background-color:#FFF;border:#f49e00 solid 1px;width:100%}#estilo351 table .tabla1:hover{background-color:#FF9}#estilo351 table .tabla1 .titular{border-bottom:#fee8c8 solid 1px;color:#f49e00;text-align:center;padding-right:4px}#estilo351 table .tabla1 .subtitular{border-right:#fee8c8 1px solid;color:#f49e00}#estilo351 table .tabla1 .contenido{line-height:1.2em;border-bottom:1px solid #fee8c8}#estilo351 table .tablaenlace{background-color:#fff;border:#f49e00 solid 1px}#estilo351 table .tablaenlace a{background-color:#fff;color:#f49e00}#estilo351 table .tablaenlace:hover{background-color:#f49e00;color:#FFF}#estilo351 table .tablaenlace:hover a{background-color:#f49e00;color:#FFF}
#estilo338 table{background-color:#f0e3df;border-collapse:inherit;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#estilo338 table table{border:#8aaa1c solid 1px;width:100%;background-color:#FFF;font-size:1.0em;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#nodo338-menu{border-top:#88152a solid 1px}#nodo338-menu:hover{background-color:#88152a;color:#fff}#nodo338-menu:hover span{color:#fff}#nodo338-menu span{color:#88152a}#estilo338 table .tabla1{background-color:#FFF;border:#88152a solid 1px;width:100%}#estilo338 table .tabla1:hover{background-color:#FF9}#estilo338 table .tabla1 .titular{border-bottom:#f0e3df solid 1px;color:#88152a;text-align:center;padding-right:4px}#estilo338 table .tabla1 .subtitular{border-right:#f0e3df 1px solid;color:#88152a}#estilo338 table .tabla1 .contenido{line-height:1.2em;border-bottom:1px solid #f0e3df}#estilo338 table .tablaenlace{background-color:#fff;border:#88152a solid 1px}#estilo338 table .tablaenlace a{background-color:#fff;color:#88152a}#estilo338 table .tablaenlace:hover{background-color:#88152a;color:#FFF}#estilo338 table .tablaenlace:hover a{background-color:#88152a;color:#FFF}#estilo341 table{background-color:#f3e2da;border-collapse:inherit;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#estilo341 table table{border:#8aaa1c solid 1px;width:100%;background-color:#FFF;font-size:1.0em;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#nodo341-menu{border-top:#a1141c solid 1px}#nodo341-menu:hover{background-color:#a1141c;color:#fff}#nodo341-menu:hover span{color:#fff}#nodo341-menu8 span{color:#a1141c}#estilo341 table .tabla1{background-color:#FFF;border:#a1141c solid 1px;width:100%}#estilo341 table .tabla1:hover{background-color:#FF9}#estilo341 table .tabla1 .titular{border-bottom:#f3e2da solid 1px;color:#a1141c;text-align:center;padding-right:4px}#estilo341 table .tabla1 .subtitular{border-right:#f3e2da 1px solid;color:#a1141c}#estilo341 table .tabla1 .contenido{line-height:1.2em;border-bottom:1px solid #f3e2da}#estilo341 table .tablaenlace{background-color:#fff;border:#a1141c solid 1px}#estilo341 table .tablaenlace a{background-color:#fff;color:#a1141c}#estilo341 table .tablaenlace:hover{background-color:#a1141c;color:#FFF}#estilo341 table .tablaenlace:hover a{background-color:#a1141c;color:#FFF}#estilo357 table{background-color:#dae9e8;border-collapse:inherit;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#estilo357 table table{border:#8aaa1c solid 1px;width:100%;background-color:#FFF;font-size:1.0em;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#nodo357-menu{border-top:#009392 solid 1px}#nodo357-menu:hover{background-color:#009392;color:#fff}#nodo357-menu:hover span{color:#fff}#nodo357-menu span{color:#009392}#estilo357 table .tabla1{background-color:#FFF;border:#009392 solid 1px;width:100%}#estilo357 table .tabla1:hover{background-color:#FF9}#estilo357 table .tabla1 .titular{border-bottom:#dae9e8 solid 1px;color:#009392;text-align:center;padding-right:4px}#estilo357 table .tabla1 .subtitular{border-right:#dae9e8 1px solid;color:#009392}#estilo357 table .tabla1 .contenido{line-height:1.2em;border-bottom:1px solid #dae9e8}#estilo357 table .tablaenlace{background-color:#fff;border:#009392 solid 1px}#estilo357 table .tablaenlace a{background-color:#fff;color:#009392}#estilo357 table .tablaenlace:hover{background-color:#009392;color:#FFF}#estilo357 table .tablaenlace:hover a{background-color:#009392;color:#FFF}#estilo359 table{background-color:#e0e4e7;border-collapse:inherit;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#estilo359 table table{border:#8aaa1c solid 1px;width:100%;background-color:#FFF;font-size:1.0em;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#nodo359-menu{border-top:#005969 solid 1px}#nodo359-menu:hover{background-color:#005969;color:#fff}
#nodo359-menu:hover span{color:#fff}#nodo359-menu span{color:#005969}#estilo359 table .tabla1{background-color:#FFF;border:#005969 solid 1px;width:100%}#estilo359 table .tabla1 hover{background-color:#FF9}#estilo359 table .tabla1 .titular{border-bottom:#e0e4e7 solid 1px;color:#005969;text-align:center;padding-right:4px}#estilo359 table .tabla1 .subtitular{border-right:#e0e4e7 1px solid;color:#005969}#estilo359 table .tabla1 .contenido{line-height:1.2em;border-bottom:1px solid #e0e4e7}#estilo359 table .tablaenlace{background-color:#fff;border:#005969 solid 1px}#estilo359 table .tablaenlace a{background-color:#fff;color:#005969}#estilo359 table .tablaenlace:hover{background-color:#005969;color:#FFF}#estilo359 table .tablaenlace:hover a{background-color:#005969;color:#FFF}#estilo358 table{background-color:#dee4e6;border-collapse:inherit;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#estilo358 table table{border:#8aaa1c solid 1px;width:100%;background-color:#FFF;font-size:1.0em;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#nodo358-menu{border-top:#00747e solid 1px}#nodo358-menu:hover{background-color:#00747e;color:#fff}#nodo358-menu:hover span{color:#fff}#nodo358-menu span{color:#00747e}#estilo358 table .tabla1{background-color:#FFF;border:#00747e solid 1px;width:100%}#estilo358 table .tabla1:hover{background-color:#FF9}#estilo358 table .tabla1 .titular{border-bottom:#dee4e6 solid 1px;color:#00747e;text-align:center;padding-right:4px}#estilo358 table .tabla1 .subtitular{border-right:#dee4e6 1px solid;color:#00747e}#estilo358 table .tabla1 .contenido{line-height:1.2em;border-bottom:1px solid #dee4e6}#estilo358 table .tablaenlace{background-color:#fff;border:#00747e solid 1px}#estilo358 table .tablaenlace a{background-color:#fff;color:#00747e}#estilo358 table .tablaenlace:hover{background-color:#00747e;color:#FFF}#estilo358 table .tablaenlace:hover a{background-color:#00747e;color:#FFF}#estilo356 table{background-color:#dbede8;border-collapse:inherit;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#estilo356 table table{border:#8aaa1c solid 1px;width:100%;background-color:#FFF;font-size:1.0em;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#nodo356-menu{border-top:#1eae9c solid 1px}#nodo356-menu:hover{background-color:#1eae9c;color:#fff}#nodo356-menu:hover span{color:#fff}#nodo356-menu span{color:#1eae9c}#estilo356 table .tabla1{background-color:#FFF;border:#1eae9c solid 1px;width:100%}#estilo356 table .tabla1:hover{background-color:#FF9}#estilo356 table .tabla1 .titular{border-bottom:#dbede8 solid 1px;color:#1eae9c;text-align:center;padding-right:4px}#estilo356 table .tabla1 .subtitular{border-right:#dbede8 1px solid;color:#1eae9c}#estilo356 table .tabla1 .contenido{line-height:1.2em;border-bottom:1px solid #dbede8}#estilo356 table .tablaenlace{background-color:#fff;border:#1eae9c solid 1px}#estilo356 table .tablaenlace a{background-color:#fff;color:#1eae9c}#estilo356 table .tablaenlace:hover{background-color:#1eae9c;color:#FFF}#estilo356 table .tablaenlace:hover a{background-color:#1eae9c;color:#FFF}#estilo350 table{background-color:#fde6ce;border-collapse:inherit;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#estilo350 table table{border:#8aaa1c solid 1px;width:100%;background-color:#FFF;font-size:1.0em;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#nodo350-menu{border-top:#ee7f00 solid 1px}#nodo350-menu:hover{background-color:#ee7f00;color:#fff}#nodo350-menu:hover span{color:#fff}#nodo350-menu span{color:#ee7f00}#estilo350 table .tabla1{background-color:#FFF;border:#ee7f00 solid 1px;width:100%}#estilo350 table .tabla1:hover{background-color:#FF9}#estilo350 table .tabla1 .titular{border-bottom:#fde6ce solid 1px;color:#ee7f00;text-align:center;padding-right:4px}#estilo350 table .tabla1 .subtitular{border-right:#fde6ce 1px solid;color:#ee7f00}#estilo350 table .tabla1 .contenido{line-height:1.2em;border-bottom:1px solid #fde6ce}#estilo350 table .tablaenlace{background-color:#fff;border:#ee7f00 solid 1px}#estilo350 table .tablaenlace a{background-color:#fff;color:#ee7f00}#estilo350 table .tablaenlace:hover{background-color:#ee7f00;color:#FFF}#estilo350 table .tablaenlace:hover a{background-color:#ee7f00;color:#FFF}#estilo353 table{background-color:#fbecbe;border-collapse:inherit;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#estilo353 table table{border:#8aaa1c solid 1px;width:100%;background-color:#FFF;font-size:1.0em;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}
#nodo353-menu{border-top:#edc500 solid 1px}#nodo353-menu:hover{background-color:#edc500;color:#fff}#nodo353-menu:hover span{color:#fff}#nodo353-menu span{color:#edc500}#estilo353 table .tabla1{background-color:#FFF;border:#edc500 solid 1px;width:100%}#estilo353 table .tabla1:hover{background-color:#FF9}#estilo353 table .tabla1 .titular{border-bottom:#fbecbe solid 1px;color:#edc500;text-align:center;padding-right:4px}#estilo353 table .tabla1 .subtitular{border-right:#fbecbe 1px solid;color:#edc500}#estilo353 table .tabla1 .contenido{line-height:1.2em;border-bottom:1px solid #fbecbe}#estilo353 table .tablaenlace{background-color:#fff;border:#edc500 solid 1px}#estilo353 table .tablaenlace a{background-color:#fff;color:#edc500}#estilo353 table .tablaenlace:hover{background-color:#edc500;color:#FFF}#estilo353 table .tablaenlace:hover a{background-color:#edc500;color:#FFF}#estilo354 table{background-color:#f7ebc7;border-collapse:inherit;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#estilo354 table table{border:#8aaa1c solid 1px;width:100%;background-color:#FFF;font-size:1.0em;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#nodo354-menu{border-top:#d8b200 solid 1px}#nodo354-menu:hover{background-color:#d8b200;color:#fff}#nodo354-menu:hover span{color:#fff}#nodo354-menu span{color:#d8b200}#estilo354 table .tabla1{background-color:#FFF;border:#d8b200 solid 1px;width:100%}#estilo354 table .tabla1:hover{background-color:#FF9}#estilo354 table .tabla1 .titular{border-bottom:#f7ebc7 solid 1px;color:#d8b200;text-align:center;padding-right:4px}#estilo354 table .tabla1 .subtitular{border-right:#f7ebc7 1px solid;color:#d8b200}#estilo354 table .tabla1 .contenido{line-height:1.2em;border-bottom:1px solid #f7ebc7}#estilo354 table .tablaenlace{background-color:#fff;border:#d8b200 solid 1px}#estilo354 table .tablaenlace a{background-color:#fff;color:#d8b200}#estilo354 table .tablaenlace:hover{background-color:#d8b200;color:#FFF}#estilo354 table .tablaenlace:hover a{background-color:#d8b200;color:#FFF}#estilo349 table{background-color:#fde5d1;border-collapse:inherit;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#estilo349 table table{border:#8aaa1c solid 1px;width:100%;background-color:#FFF;font-size:1.0em;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#nodo349-menu{border-top:#eb690b solid 1px}#nodo349-menu:hover{background-color:#eb690b;color:#fff}#nodo349-menu:hover span{color:#fff}#nodo349-menu span{color:#eb690b}#estilo349 table .tabla1{background-color:#FFF;border:#eb690b solid 1px;width:100%}#estilo349 table .tabla1:hover{background-color:#FF9}#estilo349 table .tabla1 .titular{border-bottom:#fde5d1 solid 1px;color:#eb690b;text-align:center;padding-right:4px}#estilo349 table .tabla1 .subtitular{border-right:#fde5d1 1px solid;color:#eb690b}#estilo349 table .tabla1 .contenido{line-height:1.2em;border-bottom:1px solid #fde5d1}#estilo349 table .tablaenlace{background-color:#fff;border:#eb690b solid 1px}#estilo349 table .tablaenlace a{background-color:#fff;color:#eb690b}#estilo349 table .tablaenlace:hover{background-color:#eb690b;color:#FFF}#estilo349 table .tablaenlace:hover a{background-color:#eb690b;color:#FFF}#estilo347 table{background-color:#f9e1d2;border-collapse:inherit;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#estilo347 table table{border:#8aaa1c solid 1px;width:100%;background-color:#FFF;font-size:1.0em;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#nodo347-menu{border-top:#d6361b solid 1px}#nodo347-menu:hover{background-color:#d6361b;color:#fff}#nodo347-menu:hover span{color:#fff}#nodo347-menu span{color:#d6361b}#estilo347 table .tabla1{background-color:#FFF;border:#d6361b solid 1px;width:100%}#estilo347 table .tabla1:hover{background-color:#FF9}#estilo347 table .tabla1 .titular{border-bottom:#f9e1d2 solid 1px;color:#d6361b;text-align:center;padding-right:4px}
#estilo347 table .tabla1 .subtitular{border-right:#f9e1d2 1px solid;color:#d6361b}#estilo347 table .tabla1 .contenido{line-height:1.2em;border-bottom:1px solid #f9e1d2}#estilo347 table .tablaenlace{background-color:#fff;border:#d6361b solid 1px}#estilo347 table .tablaenlace a{background-color:#fff;color:#d6361b}#estilo347 table .tablaenlace:hover{background-color:#d6361b;color:#FFF}#estilo347 table .tablaenlace:hover a{background-color:#d6361b;color:#FFF}#estilo348 table{background-color:#fde3d2;border-collapse:inherit;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#estilo348 table table{border:#8aaa1c solid 1px;width:100%;background-color:#FFF;font-size:1.0em;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#nodo348-menu{border-top:#e75113 solid 1px}#nodo348-menu:hover{background-color:#e75113;color:#fff}#nodo348-menu:hover span{color:#fff}#nodo348-menu span{color:#e75113}#estilo348 table .tabla1{background-color:#FFF;border:#e75113 solid 1px;width:100%}#estilo348 table .tabla1:hover{background-color:#FF9}#estilo348 table .tabla1 .titular{border-bottom:#fde3d2 solid 1px;color:#e75113;text-align:center;padding-right:4px}#estilo348 table .tabla1 .subtitular{border-right:#fde3d2 1px solid;color:#e75113}#estilo348 table .tabla1 .contenido{line-height:1.2em;border-bottom:1px solid #fde3d2}#estilo348 table .tablaenlace{background-color:#fff;border:#e75113 solid 1px}#estilo348 table .tablaenlace a{background-color:#fff;color:#e75113}#estilo348 table .tablaenlace:hover{background-color:#e75113;color:#FFF}#estilo348 table .tablaenlace:hover a{background-color:#e75113;color:#FFF}#estilo352 table{background-color:#fceac2;border-collapse:inherit;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#estilo352 table table{border:#8aaa1c solid 1px;width:100%;background-color:#FFF;font-size:1.0em;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#nodo352-menu{border-top:#f2b800 solid 1px}#nodo352-menu:hover{background-color:#f2b800;color:#fff}#nodo352-menu:hover span{color:#fff}#nodo352-menu span{color:#f2b800}#estilo352 table .tabla1{background-color:#FFF;border:#f2b800 solid 1px;width:100%}#estilo352 table .tabla1:hover{background-color:#FF9}#estilo352 table .tabla1 .titular{border-bottom:#fceac2 solid 1px;color:#f2b800;text-align:center;padding-right:4px}#estilo352 table .tabla1 .subtitular{border-right:#fceac2 1px solid;color:#f2b800}#estilo352 table .tabla1 .contenido{line-height:1.2em;border-bottom:1px solid #fceac2}#estilo352 table .tablaenlace{background-color:#fff;border:#f2b800 solid 1px}#estilo352 table .tablaenlace a{background-color:#fff;color:#f2b800}#estilo352 table .tablaenlace:hover{background-color:#f2b800;color:#FFF}#estilo352 table .tablaenlace:hover a{background-color:#f2b800;color:#FFF}#estilo536 table,#estilo537 table,#estilo361 table,#estilo623 table,#estilo659 table{background-color:#e7e7e7;border-collapse:inherit;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#estilo536 table table,#estilo537 table table,#estilo361 table table,#estilo623 table table,#estilo659 table table{border:#000 solid 1px;width:100%;background-color:#FFF;font-size:1.0em;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#nodo536-menu,#nodo537-menu,#nodo361-menu,#nodo659-menu{border-top:#000 solid 1px}#nodo536-menu:hover,#nodo537-menu:hover,#nodo361-menu:hover,#nodo659-menu:hover{background-color:#888;color:#fff}#nodo536-menu:hover span,#nodo537-menu:hover span,#nodo361-menu:hover span,#nodo659-menu:hover span{color:#fff}#nodo536-menu span,#nodo537-menu span,#nodo361-menu span{color:#000}#estilo536 table .tabla1,#estilo537 table .tabla1,#estilo361 table .tabla1,#estilo623 table .tabla1,#estilo659 table .tabla{background-color:#FFF;border:#000 solid 1px;width:100%}#estilo536 table .tabla1:hover,#estilo537 table .tabla1:hover,#estilo361 table .tabla1:hover{background-color:#FF9}#estilo536 table .tabla1 .titular,#estilo537 table .tabla1 .titular,#estilo361 table .tabla1 .titular,#estilo623 table .tabla1 .titular,#estilo659 table .tabla1 .titular{border-bottom:#CCC solid 1px;color:#000;text-align:center;padding-right:4px}
#estilo536 table .tabla1 .subtitular,#estilo537 table .tabla1 .subtitular,#estilo361 table .tabla1 .subtitular,#estilo623 table .tabla1 .subtitular,#estilo659 table .tabla1 .subtitular{border-right:#CCC 1px solid;color:#000}#estilo536 table .tabla1 .contenido,#estilo537 table .tabla1 .contenido,#estilo361 table .tabla1 .contenido,#estilo623 table .tabla1 .contenido,#estilo659 table .tabla1 .contenido{line-height:1.2em;border-bottom:1px solid #CCC}#estilo536 table .tablaenlace,#estilo537 table .tablaenlace,#estilo361 table .tablaenlace,#estilo659 table .tablaenlace{background-color:#fff;border:#f2b800 solid 1px}#estilo536 table .tablaenlace a,#estilo537 table .tablaenlace a,#estilo361 table .tablaenlace a,#estilo659 table .tablaenlace a{background-color:#fff;color:#f2b800}#estilo536 table .tablaenlace:hover,#estilo537 table .tablaenlace:hover,#estilo361 table .tablaenlace:hover,#estilo659 table .tablaenlace:hover{background-color:#888;color:#FFF}#estilo536 table .tablaenlace:hover a,#estilo537 table .tablaenlace:hover a,#estilo361 table .tablaenlace:hover a,#estilo659 table .tablaenlace:hover a{background-color:#888;color:#FFF}#estilo750 table{background-color:#dee4e6;border-collapse:inherit;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#estilo750 table table{border:#004946 solid 1px;width:100%;background-color:#FFF;font-size:1.0em;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#nodo750-menu{border-top:#00747e solid 1px}#nodo750-menu:hover{background-color:#00747e;color:#fff}#nodo750-menu:hover span{color:#fff}#nodo750-menu span{color:#00747e}#estilo750 table .tabla1{background-color:#FFF;border:#00747e solid 1px;width:100%}#estilo750 table .tabla1:hover{background-color:#FF9}#estilo750 table .tabla1 .titular{border-bottom:#dee4e6 solid 1px;color:#00747e;text-align:center;padding-right:4px}#estilo750 table .tabla1 .subtitular{border-right:#dee4e6 1px solid;color:#00747e}#estilo750 table .tabla1 .contenido{line-height:1.2em;border-bottom:1px solid #dee4e6}#estilo750 table .tablaenlace{background-color:#fff;border:#00747e solid 1px}#estilo750 table .tablaenlace a{background-color:#fff;color:#00747e}#estilo750 table .tablaenlace:hover{background-color:#00747e;color:#FFF}#estilo750 table .tablaenlace:hover a{background-color:#00747e;color:#FFF}#estilo1468 table{background-color:#b09566;border-collapse:inherit;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#estilo1468 table table{border:#004946 solid 1px;width:100%;background-color:#FFF;font-size:1.0em;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#nodo1468-menu{border-top:#00747e solid 1px}#nodo1468-menu:hover{background-color:#00747e;color:#fff}#nodo1468-menu:hover span{color:#fff}#nodo1468-menu span{color:#00747e}#estilo1468 table .tabla1{background-color:#FFF;border:#00747e solid 1px;width:100%}#estilo1468 table .tabla1:hover{background-color:#FF9}#estilo1468 table .tabla1 .titular{border-bottom:#dee4e6 solid 1px;color:#00747e;text-align:center;padding-right:4px}#estilo1468 table .tabla1 .subtitular{border-right:#dee4e6 1px solid;color:#00747e}#estilo1468 table .tabla1 .contenido{line-height:1.2em;border-bottom:1px solid #dee4e6}#estilo1468 table .tablaenlace{background-color:#fff;border:#00747e solid 1px}#estilo1468 table .tablaenlace a{background-color:#fff;color:#00747e}#estilo1468 table .tablaenlace:hover{background-color:#00747e;color:#FFF}#estilo1468 table .tablaenlace:hover a{background-color:#00747e;color:#FFF}#estilo346 table{background-color:#f8dedc;border-collapse:inherit;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#estilo864 table table{border:#8aaa1c solid 1px;width:100%;background-color:#FFF;font-size:1.0em;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#nodo864-menu{border-top:#d2004a solid 1px}#nodo864-menu:hover{background-color:#d2004a;color:#fff}#nodo864-menu:hover span{color:#fff}#nodo864-menu span{color:#d2004a}
#estilo864 table .tabla1{background-color:#FFF;border:#d2004a solid 1px;width:100%}#estilo864 table .tabla1:hover{background-color:#FF9}#estilo864 table .tabla1 .titular{border-bottom:#f8dedc solid 1px;color:#d2004a;text-align:center;padding-right:4px}#estilo864 table .tabla1 .subtitular{border-right:#f8dedc 1px solid;color:#d2004a}#estilo864 table .tabla1 .contenido{line-height:1.2em;border-bottom:1px solid #f8dedc}#estilo864 table .tablaenlace{background-color:#fff;border:#d2004a solid 1px}#estilo864 table .tablaenlace a{background-color:#fff;color:#d2004a}#estilo864 table .tablaenlace:hover{background-color:#d2004a;color:#FFF}#estilo864 table .tablaenlace:hover a{background-color:#d2004a;color:#FFF}#estilo865 table{background-color:#f8dedc;border-collapse:inherit;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#estilo865 table table{border:#8aaa1c solid 1px;width:100%;background-color:#FFF;font-size:1.0em;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#nodo865-menu{border-top:#d2004a solid 1px}#nodo865-menu:hover{background-color:#d2004a;color:#fff}#nodo865-menu:hover span{color:#fff}#nodo865-menu span{color:#d2004a}#estilo865 table .tabla1{background-color:#FFF;border:#d2004a solid 1px;width:100%}#estilo865 table .tabla1:hover{background-color:#FF9}#estilo865 table .tabla1 .titular{border-bottom:#f8dedc solid 1px;color:#d2004a;text-align:center;padding-right:4px}#estilo865 table .tabla1 .subtitular{border-right:#f8dedc 1px solid;color:#d2004a}#estilo865 table .tabla1 .contenido{line-height:1.2em;border-bottom:1px solid #f8dedc}#estilo865 table .tablaenlace{background-color:#fff;border:#d2004a solid 1px}#estilo865 table .tablaenlace a{background-color:#fff;color:#d2004a}#estilo865 table .tablaenlace:hover{background-color:#d2004a;color:#FFF}#estilo865 table .tablaenlace:hover a{background-color:#d2004a;color:#FFF}#estilo866 table{background-color:#f8dedc;border-collapse:inherit;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#estilo866 table table{border:#8aaa1c solid 1px;width:100%;background-color:#FFF;font-size:1.0em;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#nodo866-menu{border-top:#d2004a solid 1px}#nodo866-menu:hover{background-color:#d2004a;color:#fff}#nodo866-menu:hover span{color:#fff}#nodo866-menu span{color:#d2004a}#estilo866 table .tabla1{background-color:#FFF;border:#d2004a solid 1px;width:100%}#estilo866 table .tabla1:hover{background-color:#FF9}#estilo866 table .tabla1 .titular{border-bottom:#f8dedc solid 1px;color:#d2004a;text-align:center;padding-right:4px}#estilo866 table .tabla1 .subtitular{border-right:#f8dedc 1px solid;color:#d2004a}#estilo866 table .tabla1 .contenido{line-height:1.2em;border-bottom:1px solid #f8dedc}#estilo866 table .tablaenlace{background-color:#fff;border:#d2004a solid 1px}#estilo866 table .tablaenlace a{background-color:#fff;color:#d2004a}#estilo866 table .tablaenlace:hover{background-color:#d2004a;color:#FFF}#estilo866 table .tablaenlace:hover a{background-color:#d2004a;color:#FFF}#estilo867 table{background-color:#f8dedc;border-collapse:inherit;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#estilo867 table table{border:#8aaa1c solid 1px;width:100%;background-color:#FFF;font-size:1.0em;border-radius:7px;-moz-border-radius:7px;-webkit-border-radius:7px;-khtml-border-radius:7px}#nodo867-menu{border-top:#d2004a solid 1px}#nodo867-menu:hover{background-color:#d2004a;color:#fff}#nodo867-menu:hover span{color:#fff}#nodo867-menu span{color:#d2004a}#estilo867 table .tabla1{background-color:#FFF;border:#d2004a solid 1px;width:100%}#estilo867 table .tabla1:hover{background-color:#FF9}#estilo867 table .tabla1 .titular{border-bottom:#f8dedc solid 1px;color:#d2004a;text-align:center;padding-right:4px}#estilo867 table .tabla1 .subtitular{border-right:#f8dedc 1px solid;color:#d2004a}#estilo867 table .tabla1 .contenido{line-height:1.2em;border-bottom:1px solid #f8dedc}
#estilo867 table .tablaenlace{background-color:#fff;border:#d2004a solid 1px}#estilo867 table .tablaenlace a{background-color:#fff;color:#d2004a}#estilo867 table .tablaenlace:hover{background-color:#d2004a;color:#FFF}#estilo867 table .tablaenlace:hover a{background-color:#d2004a;color:#FFF}#indice_programas_academicos a{text-decoration:none;color:#888}#indice_programas_academicos .enlacearea{color:#fff;height:100%}#indice_programas_academicos .subtitles{font-weight:bold;color:black;margin-left:-15px;list-style:none}#indice_programas_academicos .highlight{color:#000}#indice_programas_academicos .highlight2{color:#000}#indice_programas_academicos #areas,#areas2{width:auto;height:auto;background-color:#3e4729;color:#FFF;margin:0;font-size:1em;text-align:center;float:left;cursor:default}#indice_programas_academicos #areas a:visited,#areas2 a:visited{color:#FFF;cursor:default}#indice_programas_academicos #areas div{width:25%;cursor:default;float:left}#indice_programas_academicos #areas2 div{padding:10px 16px 0 16px;height:30px;float:left;margin:0 auto}#indice_programas_academicos #liarea1,#liarea2,#liarea3,#liarea4,#liarea1_hover,#liarea2_hover,#liarea3_hover,#liarea4_hover,#liarea5_hover,#liarea6_hover,#liarea7_hover,#liarea8_hover,#liarea9_hover,#liarea10_hover{height:40px;cursor:default;color:#FFF}#indice_programas_academicos #liarea1,#liarea1_hover{padding-top:10px;margin:0 auto;height:auto;min-height:30px}#indice_programas_academicos #liarea1_hover{background-color:#e74c61}#indice_programas_academicos .enlacefacultad1_hover{color:#e74c61}#indice_programas_academicos #liarea2_hover{background-color:#eb990f}#indice_programas_academicos .enlacefacultad2_hover{color:#be7801}#indice_programas_academicos #liarea3_hover{background-color:#efc000;color:#FFF;cursor:default}#indice_programas_academicos .enlacefacultad3_hover{color:#c49d00}#indice_programas_academicos #liarea4_hover{background-color:#209abf}#indice_programas_academicos .enlacefacultad4_hover{color:#209abf}#indice_programas_academicos #liarea5_hover{background-color:#99bd13}#indice_programas_academicos #liarea6_hover{background-color:#99bd13}#indice_programas_academicos #liarea7_hover{background-color:#99bd13}#indice_programas_academicos #liarea8_hover{background-color:#99bd13}#indice_programas_academicos #liarea9_hover{background-color:#99bd13}#indice_programas_academicos #liarea10_hover{background-color:#99bd13}@font-face{font-family:'PTSansRegular';src:url(/sites/default/themes/ueb/fonts/PT_Sans-webfont.eot);src:local('?'),url(/sites/default/themes/ueb/fonts/PT_Sans-webfont.woff) format('woff'),url(/sites/default/themes/ueb/fonts/PT_Sans-webfont.ttf) format('truetype'),url(/sites/default/themes/ueb/fonts/PT_Sans-webfont.svg#webfont) format('svg');font-weight:normal;font-style:normal}@font-face{font-family:'PTSansItalic';src:url(/sites/default/themes/ueb/fonts/PT_Sans_Italic-webfont.eot);src:local('?'),url(/sites/default/themes/ueb/fonts/PT_Sans_Italic-webfont.woff) format('woff'),url(/sites/default/themes/ueb/fonts/PT_Sans_Italic-webfont.ttf) format('truetype'),url(/sites/default/themes/ueb/fonts/PT_Sans_Italic-webfont.svg#webfont) format('svg');font-weight:normal;font-style:normal}#indice_programas_academicos table tr td{background-color:#FFF;width:25%;height:40px;font-size:.9em;padding:2px 2px 1px 2px;line-height:1.0em}#indice_programas_academicos table{border-collapse:inherit}.filefield-element .imagefield-preview{min-height:inherit}tr.even,tr.odd{border-bottom:1px solid #ccc;padding:.1em .6em;border-bottom:0}tr.even{background-color:#fff}tr.odd{background-color:#f6f9ea}tr.content-add-new{background-color:#fff}#content-field-overview-form+.tabs.secondary{display:none}table{width:100%}dl.admin-list{margin-top:0}.body-field-wrapper{clear:both}.form-item .description span.destacado{color:#C00}
tr.odd .form-item,tr.even .form-item{white-space:normal}#block-views-cronologia-block_1{padding:20px;margin-bottom:10px;border-top:0;border-right:solid 1px #e3e8cc;border-bottom:solid 2px #e3e8cc;border-left:solid 1px #e3e8cc;background-color:#fff;-moz-border-radius:10px;border-bottom-radius:10px}#block-views-cronologia-block_1 h2{display:block;width:100%;height:100%;color:#000;line-height:1em;border-bottom:solid 2px #88ab0c;padding-bottom:5px}#cronologia .timeline-copyright{display:none}.timeline-event-bubble-body .views-field-title{display:none}.timeline-event-bubble-title{font-size:1.1em;line-height:.9em}.views-field-field-hito-inicio-value,.views-field-field-hito-inicio-value2{display:none}body.page-medios .contenedor #promocional{-moz-box-sizing:border-box;margin-top:20px;padding-right:20px}body.not-front #promocional .block-views{margin-bottom:10px}.encuesta .choice-header{display:none}.encuesta,.block-webform{background-color:#44a6a3;color:#fff;padding:5px}.node.advpoll_binary{background:none repeat scroll 0 0 transparent;border:medium none;padding:0}#promocional .view-header,#promocional #block-views-opinion-block_1 h2{background:none repeat scroll 0 0 transparent;color:#fff;font-family:'PTSansNarrow';font-size:1.5em;margin:5px 0 10px;padding:0}.encuesta table.views-view-grid td{background:none repeat scroll 0 0 transparent;padding:0}.encuesta input.form-submit,.block-webform input.form-submit{border:0;background:#88ab0c;color:#fff;width:100%;padding:5px;margin-top:10px;cursor:pointer}.encuesta input.form-submit:hover,#promocional .block-webform input.form-submit:hover{background:#df7e00}.encuesta .vote-choices .form-item{background:#379391;padding:2px;margin:2px 0}.encuesta .form-item label.option,.block-webform .form-item label.option{margin-left:20px;display:block}.encuesta .form-item label.option input{margin-left:-20px}.poll .bar{background-color:#379391}.poll .bar .foreground{background-color:#df7e00}.poll .percent{font-size:.8em;color:#000;margin-right:2px;margin-top:-15px;margin-bottom:10px}.poll .total{color:#000;font-weight:bold;text-transform:uppercase;background-color:#379391;padding:5px;letter-spacing:.1em}.poll .total em{font-style:normal}#promocional .encuesta .terms{display:none}body.page-medios #promocional .block .content{margin-top:0}.page-medios #promocional .content{padding:0}body.page-medios #promocional h2,body.page-medios #promocional h2 a{color:#fff;text-align:left;border:0;height:auto}#promocional .block.block-webform h2{background:none repeat scroll 0 0 transparent;color:#fff;font-family:'PTSansNarrow';font-size:1.2em;margin:0 0 10px;padding:0;line-height:.9em}#promocional .block-webform .form-item label.option{font-size:.9em;line-height:1em}#promocional .block-webform .form-item label.option input{margin-left:-17px}#promocional .block-webform .webform-component>.form-item>label{font-size:1.1em;line-height:1.1em;font-family:'PTSansNarrow';font-weight:normal;border-left:5px solid #df7e00;padding-left:5px;margin-left:-5px}#promocional .block-webform .form-text{-moz-box-sizing:border-box;-webkit-box-sizing:border-box;box-sizing:border-box;background:none repeat scroll 0 0 #98cecc;border:medium none;display:block;padding:5px;width:100%;margin-top:3px}#promocional .form-checkboxes .form-item,#promocional .form-radios .form-item{background:#379391;padding:2px;margin:2px 0}.webform-confirmation{background:#fff;font-size:1.3em;padding:30px;margin:80px;text-align:center}td{margin:0;padding:0}.titulo{width:460px;font-size:16px;font-weight:bold;color:#000;background-color:#e7e7e7}.bg_columna{height:auto;padding:5px;background-color:#e7e7e7}.subtitulo{color:#000}#node-177 .titulo{color:#861b18;background-color:#f9f4f3}#node-177 .bg_columna{background-color:#f9f4f3}#node-177 .subtitulo{color:#861b18}#node-178 .titulo{color:#bf2e25;background-color:#f7eae8}#node-178 .bg_columna{background-color:#f7eae8}#node-178 .subtitulo{color:#bf2e25}#node-864 .titulo,#node-865 .titulo,#node-866 .titulo,#node-867 .titulo{color:#397ebf;background-color:#f0f3f5}#node-864 .bg_columna,#node-865 .bg_columna,#node-866 .bg_columna,#node-867 .bg_columna{background-color:#f0f3f5}#node-864 .subtitulo,#node-865 .subtitulo,#node-866 .subtitulo,#node-867 .subtitulo{color:#397ebf}#node-180 .titulo{color:#d60b52;background-color:#fff0f4}#node-180 .bg_columna{background-color:#fff0f4}#node-180 .subtitulo{color:#d60b52}#node-179 .titulo,#node-339 .titulo{color:#a01e21;background-color:#f2edee}#node-179 .bg_columna,#node-339 .bg_columna{background-color:#f2edee}
#node-179 .subtitulo,#node-339 .subtitulo{color:#a01e21}#node-181 .titulo{color:#84ae40;background-color:#ecf3dc}#node-181 .bg_columna{background-color:#ecf3dc}#node-181 .subtitulo{color:#84ae40}#node-182 .titulo{color:#f99d1c;background-color:#f9f0de}#node-182 .bg_columna{background-color:#f9f0de}#node-182 .subtitulo{color:#f99d1c}#node-186 .titulo{color:#f58220;background-color:#f8eee4}#node-186 .bg_columna{background-color:#f8eee4}#node-186 .subtitulo{color:#f58220}#node-184 .titulo{color:#e1740b;background-color:#f7efd7}#node-184 .bg_columna{background-color:#f7efd7}#node-184 .subtitulo{color:#e1740b}#node-187 .titulo{color:#dc4128;background-color:#f3e2dc}#node-187 .bg_columna{background-color:#f3e2dc}#node-187 .subtitulo{color:#dc4128}#node-185 .titulo{color:#f15a22;background-color:#f5e1d5}#node-185 .bg_columna{background-color:#f5e1d5}#node-185 .subtitulo{color:#f15a22}#node-190 .titulo{color:#94192e;background-color:#f8f1f1}#node-190 .bg_columna{background-color:#f8f1f1}#node-190 .subtitulo{color:#94192e}#node-191 .titulo{color:#ecc500;background-color:#faf5e1}#node-191 .bg_columna{background-color:#faf5e1}#node-191 .subtitulo{color:#ecc500}#node-192 .titulo{color:#d3ad07;background-color:#f7edd0}#node-192 .bg_columna{background-color:#f7edd0}#node-192 .subtitulo{color:#d3ad07}#node-183 .titulo{color:#f1b51c;background-color:#faf4e1}#node-183 .bg_columna{background-color:#faf4e1}#node-183 .subtitulo{color:#f1b51c}#node-195 .titulo{color:#0a4159;background-color:#e7eff5}#node-195 .bg_columna{background-color:#e7eff5}#node-195 .subtitulo{color:#0a4159}#node-751 .titulo{color:#004946;background-color:#e8f1f1}#node-751 .bg_columna{background-color:#e8f1f1}#node-751 .subtitulo{color:#004946}#node-196 .titulo{color:#00b8a5;background-color:#f0f5f4}#node-196 .bg_columna{background-color:#f0f5f4}#node-196 .subtitulo{color:#00b8a5}#node-197 .titulo{color:#007983;background-color:#e8eef0}#node-197 .bg_columna{background-color:#e8eef0}#node-197 .subtitulo{color:#007983}#node-198 .titulo{color:#009c9a;background-color:#e3eeef}#node-198 .bg_columna{background-color:#e3eeef}#node-198 .subtitulo{color:#009c9a}#node-199 .titulo{color:#005e6e;background-color:#f1f1f1}#node-199 .bg_columna{background-color:#f1f1f1}#node-199 .subtitulo{color:#005e6e}#node-1468 .titulo{color:#c0590e;background-color:#f2decf}#node-1468 .bg_columna{background-color:#f2decf}#node-1468 .subtitulo{color:#c0590e}@font-face{font-family:'Fjalla One';src:url(/sites/default/themes/ueb/fonts/fjallaone-regular-webfont.eot);src:url(/sites/default/themes/ueb/fonts/fjallaone-regular-webfont.eot?#iefix) format('embedded-opentype'),url(/sites/default/themes/ueb/fonts/fjallaone-regular-webfont.woff) format('woff'),url(/sites/default/themes/ueb/fonts/fjallaone-regular-webfont.ttf) format('truetype'),url(/sites/default/themes/ueb/fonts/fjallaone-regular-webfont.svg#fjalla_oneregular) format('svg');font-weight:normal;font-style:normal}.node-2946,.node-type-informacion-exito-estudiantil,.node-type-servicio-exito-estudiantil{background:url(http://www.uelbosque.edu.co/sites/default/files/exito_estudiantil/bg_exito.jpg)}.node-2946 .contenedor{position:relative}.node-2946 #destacado{width:auto}#node-2946.node{display:none}body.node-2946 #grueso,.node-type-informacion-exito-estudiantil #grueso,.node-type-servicio-exito-estudiantil #grueso{background:#fff;margin-bottom:60px!important;-moz-box-shadow:0 0 5px 0 #ccc;-webkit-box-shadow:0 0 5px 0 #ccc;box-shadow:0 0 5px 0 #ccc;width:960px}body.node-type-servicio-exito-estudiantil #grueso{width:960px}.arriba{background:url(http://www.uelbosque.edu.co/sites/default/files/exito_estudiantil/parentesis.png) no-repeat 370px 50px;border-bottom:1px solid #ececed;padding:20px;width:auto;overflow:hidden}#block-menu-menu-menu-exito-estudiantil{background:url(http://www.uelbosque.edu.co/sites/default/files/exito_estudiantil/bg_menu-exito.png) no-repeat left bottom;height:72px;position:absolute;width:960px}#block-menu-menu-menu-exito-estudiantil ul{padding:0}
#block-menu-menu-menu-exito-estudiantil li{float:left;list-style:none;margin:0;padding:0;text-align:center;width:320px}#block-menu-menu-menu-exito-estudiantil a{-moz-box-sizing:border-box;-webkit-box-sizing:border-box;box-sizing:border-box;-webkit-transition:color .2s ease-in-out 0s;-moz-transition:color .2s ease-in-out 0s;-ms-transition:color .2s ease-in-out 0s;transition:color .2s ease-in-out 0s;background:#123736;color:#fff;display:block;font-family:'Fjalla One';font-size:1.1em;line-height:60px;text-transform:uppercase}#block-menu-menu-menu-exito-estudiantil a:hover,#block-menu-menu-menu-exito-estudiantil a.active{background:#123736 url(http://www.uelbosque.edu.co/sites/default/files/exito_estudiantil/underline.png) no-repeat 30px 42px;color:#e5d912}#block-webform-client-block-2971{background:#fff}#block-webform-client-block-2971 h2{text-indent:-1000px;height:0;border:0}#block-webform-client-block-2971 #edit-actions{margin:0 auto;text-align:center}.bloque-serv-exito-sin-enlace .views-field-field-servicio-exito-estudiantil-resumen-interno-value{padding:10px 0 0}.bloque-serv-exito-sin-enlace.bloque-serv-exito-orden-2,.bloque-serv-exito-orden-3{padding-left:30px}.cabezote-exito-node{background:none repeat scroll 0 0 #fff;padding:80px 30px 0;width:auto}.cortina{background:url(http://www.uelbosque.edu.co/sites/default/files/exito_estudiantil/cortina.png);height:10px;margin-bottom:50px}.contenido-exito-node,.integrantes_exito-node,.contenido-especifico-node,.node-type-servicio-exito-estudiantil #comments{width:650px}.content .view-exito-estudiantil-destacad-home .item-list a{-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;-moz-box-shadow:0 0 1px 0 #999;-webkit-box-shadow:0 0 1px 0 #999;box-shadow:0 0 1px 0 #999;font-size:1em;padding:10px 15px}.content .view-exito-estudiantil-destacad-home .item-list a:hover{background:#fafafa}.descripcion-exito{float:left;margin-left:300px;margin-top:50px}.descripcion-exito p{font-family:'Fjalla One';float:left;margin:0;line-height:100px}.destacado-exito{background:url("http://www.uelbosque.edu.co/sites/default/files/exito_estudiantil/bg_tablero.gif") no-repeat scroll 130px 170px #2c8b86;height:465px;padding-top:50px}.dot-exito{-moz-border-radius:40px;-webkit-border-radius:40px;border-radius:40px;background:#1e5251;color:#fff;float:left;height:40px;line-height:40px;margin-right:150px;text-align:center;width:40px}.enlace-info-servi-exito-estudiantil{background:url(http://www.uelbosque.edu.co/sites/default/files/exito_estudiantil/enlace.png) no-repeat 0 -1px;font-size:1.1em;font-style:italic;padding:5px 0 5px 70px}.footer-exito{border-top:1px solid #ececed;background:#fff;margin:0 auto;padding:10px 0;overflow:hidden;width:95%}.footer-exito div{-moz-box-sizing:border-box;-webkit-box-sizing:border-box;box-sizing:border-box;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;float:left;line-height:.9em;margin-left:22px;padding:20px 10px 10px;position:relative;text-align:center;width:30%}.footer-exito .bloque-centro>div{background:url("http://www.uelbosque.edu.co/sites/default/files/exito_estudiantil/iconos_exito.png") no-repeat -30px 0;height:24px;left:100px;position:absolute;top:0;width:30px}.footer-exito .bloque-derecha>div{background:url("http://www.uelbosque.edu.co/sites/default/files/exito_estudiantil/iconos_exito.png") no-repeat -72px 0;height:24px;left:100px;position:absolute;top:0;width:24px}.footer-exito .bloque-izquierda>div{background:url("http://www.uelbosque.edu.co/sites/default/files/exito_estudiantil/iconos_exito.png") no-repeat 3px 0;height:24px;left:100px;position:absolute;top:0;width:30px}.footer-exito h3{color:#b9cbcb;font-weight:normal;font-size:1em}.footer-exito p{color:#2b8581;font-weight:normal;font-size:.9em;margin-top:5px}.footer-exito p a{color:#2b8581}#grueso .view-exito-estudiantil-destacad-home .view-header>h2{border-bottom:1px solid #ececed;color:#2c8b86;font-family:'Fjalla One';font-size:1.8em;font-weight:normal;padding:20px 24px;text-align:right;text-transform:uppercase}#grueso .view-exito-estudiantil-destacad-home .view-header{position:relative}.hitos-exito{float:left;font-family:'Fjalla One';padding-left:40px;padding-right:0;width:150px}
.hitos-exito a{-webkit-transition:background .2s ease-in-out 0s;-moz-transition:background .2s ease-in-out 0s;-ms-transition:background .2s ease-in-out 0s;transition:background .2s ease-in-out 0s;color:#fff}.hitos-exito a:hover{color:#e5d912}.hitos-universitarios{background:url(http://www.uelbosque.edu.co/sites/default/files/exito_estudiantil/linea_de_tiempo.png) no-repeat 0 20px;float:left;margin-top:40px}.imagecache-exito_estudiantil_imagen_serv_destacad_home{-moz-border-radius:5px 5px 0 0;-webkit-border-radius:5px 5px 0 0;border-radius:5px 5px 0 0}.imagne-exito{float:left;margin-right:80px;border:1px solid #ececed}.info-exito{color:#123736;font-size:1.1em;line-height:1em}.indicador-exito{background:url(http://www.uelbosque.edu.co/sites/default/files/exito_estudiantil/indicador-servicios.png) no-repeat;position:absolute;width:42px;height:53px;left:330px;top:40px}.integrantes_exito-node{padding-top:20px}.integrantes_exito-node table{border-top:1px solid #ececed}.integrantes_exito-node thead{height:0;display:none}.integrantes_exito-node tbody{border:0}.integrantes_exito-node tr{float:left;font-size:.9em;line-height:1em;margin-bottom:10px;vertical-align:bottom;width:285px}.integrantes_exito-node tr:nth-child(1){padding-top:30px}.integrantes_exito-node tr:nth-child(2){padding-top:30px}.integrantes_exito-node tr img{margin-right:5px}.informacion_exito_estudiantil .programa-vida-unirversitaria{color:#2c8b86;font-family:'Fjalla One';font-size:1.4em;font-weight:normal}#grueso .integrantes_exito-node table.sticky-table tbody tr.odd{background:#fff;margin-right:20px}.integrantes_exito-node p{margin:0;padding:0}#grueso .informacion_exito_estudiantil h2{padding-top:80px;margin-bottom:10px}#grueso .view-exito-estudiant-bloques-interes>.view-header{margin:0;padding-bottom:10px}#grueso .view-exito-estudiant-bloques-interes>.view-header p{color:#3e4729;font-family:'PTSansRegular',sans-serif;font-size:.6em;font-weight:normal;line-height:1em;text-align:left;margin:0;padding:15px 10px 0 10px!important}.node-type-informacion-exito-estudiantil #grueso{background:#fff}.node-type-informacion-exito-estudiantil #grueso>div{padding:0 30px}.node-type-informacion-exito-estudiantil #block-block-185{padding-top:80px}.node-type-informacion-exito-estudiantil #grueso>div .view-content:after{display:inline}.node-type-informacion-exito-estudiantil #grueso>div .view-footer{padding-left:210px;border-bottom:1px solid #ececed;margin-bottom:20px;padding-bottom:30px}.node-type-informacion-exito-estudiantil #grueso>div .view-footer p{margin:-10px 0 20px -10px}.node-type-informacion-exito-estudiantil #grueso .bloque-serv-exito-sin-enlace .views-field-title{background:0;color:#3e4729;font-family:'PTSansRegular',sans-serif;font-size:1.2em;font-weight:bold;float:none;height:auto;line-height:inherit;padding:0;text-align:left;text-transform:inherit;width:auto}.node-type-informacion-exito-estudiantil #grueso>div .views-field-title{-moz-box-sizing:border-box;-webkit-box-sizing:border-box;box-sizing:border-box;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;background:#2c8b86;color:#fff;font-family:'Fjalla One';font-size:1.4em;float:left;margin:0 15px 0 0;height:100px;line-height:1.1em;padding:15px 10px 0;text-transform:uppercase;text-align:center;width:195px}.node-type-informacion-exito-estudiantil #grueso>div:last-child .view-footer{border-top:0}.node-type-informacion-exito-estudiantil .view-content>div.views-row{margin:0}.personaje{background:url(http://www.uelbosque.edu.co/sites/default/files/exito_estudiantil/personaje.png) no-repeat;height:623px;left:80px;position:absolute;top:45px;width:244px;z-index:1}#promocional .view-exito-estudiant-bloques-interes .view-content>div{font-size:1em;line-height:1.1em;margin:0;padding:0 0 0 10px}.respnsable-exito{color:#2b8581;font-family:'Fjalla One';font-size:2.5em;line-height:1em;padding-top:40px}.trama{background:url(http://www.uelbosque.edu.co/sites/default/files/exito_estudiantil/line.png);height:455px}
.view-exito-estudiantil-destacad-home .item-list a:before{content:"Ver "}.view-exito-estudiantil-destacad-home .item-list a:after{content:" servicios "}.view-exito-estudiantil-destacad-home .item-list{margin:20px 0}.view-exito-estudiantil-destacad-home .view-content{background:#fff;padding-left:12px;padding-top:5px}.view-exito-estudiantil-destacad-home .view-content>div{background:#123736;display:inline-block;height:250px;margin-left:20px;overflow:hidden;text-align:center;vertical-align:top;width:205px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;-moz-box-shadow:0 0 4px 2px #ccc;-webkit-box-shadow:0 0 4px 2px #ccc;box-shadow:0 0 4px 2px #ccc;-webkit-transition:background .2s ease-in-out 0s;-moz-transition:background .2s ease-in-out 0s;-ms-transition:background .2s ease-in-out 0s;transition:background .2s ease-in-out 0s}.view-exito-estudiantil-destacad-home .view-content>div:hover{background:#e5d912}.view-exito-estudiantil-destacad-home .view-content>div:hover .views-field-field-servicio-exito-estudiantil-resumen-portada-value a{color:#3e4729}.view-exito-estudiantil-destacad-home .view-content>div:hover .views-field-title a{color:#123736}.views-field-field-servicio-exito-estudiantil-imagen-dot-fid{position:relative}.view-exito-estudiantil-destacad-home .imagecache-_linked{position:absolute;left:100px;top:-9px}.view-exito-estudiantil-destacad-home .views-field-title{padding:20px 3px 7px}.view-exito-estudiantil-destacad-home .views-field-title a{color:#fff;font-family:'Fjalla One';font-size:1.4em;text-transform:uppercase}.views-field-field-servicio-exito-estudiantil-resumen-portada-value{line-height:.8em;padding:0 5px}.views-field-field-servicio-exito-estudiantil-resumen-portada-value>span>a{color:#319d98;font-size:.8em}.node-type-servicio-exito-estudiantil #promocional{border-left:1px solid #ececed;position:absolute;padding:0 0 10px 10px;right:30px;top:460px}.view-exito-estudiant-bloques-interes>.view-header h5{background:url(http://www.uelbosque.edu.co/sites/default/files/exito_estudiantil/bg_interes.png) no-repeat 0 bottom;color:#3e4729;font-family:'PTSansRegular',sans-serif;font-size:.7em;font-weight:bold;line-height:1em;text-align:left;margin:0;padding:0 10px 7px}.views-field-field-servicio-exito-estudiantil-resumen-interno-value{padding-left:210px}#webform-client-form-2971{color:#3e4729}#webform-client-form-2971 .form-submit{color:#3e4729;width:100px}
			</style>
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
            <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.13.1/jquery-ui.min.js"></script>


	    <!--[if lt IE 7]>
		<style type="text/css">
		#encabezado {
		position:relative;
		}
		#logo {
		position:absolute;
		}
		.grueso.cajon {
		padding-top:0;
		}
		#menu {
		left:0;
		}
		#indice_programas_academicos #areas div {
		width:24.9%;
		}
		</style>
    <![endif]-->
	<!-- javascript -->
           <!-- <script src="http://www.uelbosque.edu.co/sites/default/files/js/js_89139bb5e2b877317c37281661acb980.js" type="text/javascript"/>-->
		   <script type="text/javascript">
		   
/*
 * jQuery 1.2.6 - New Wave Javascript
 *
 * Copyright (c) 2008 John Resig (jquery.com)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * Date: 2008-05-24 14:22:17 -0400 (Sat, 24 May 2008)
 * Rev: 5685
 */
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('(H(){J w=1b.4M,3m$=1b.$;J D=1b.4M=1b.$=H(a,b){I 2B D.17.5j(a,b)};J u=/^[^<]*(<(.|\\s)+>)[^>]*$|^#(\\w+)$/,62=/^.[^:#\\[\\.]*$/,12;D.17=D.44={5j:H(d,b){d=d||S;G(d.16){7[0]=d;7.K=1;I 7}G(1j d=="23"){J c=u.2D(d);G(c&&(c[1]||!b)){G(c[1])d=D.4h([c[1]],b);N{J a=S.61(c[3]);G(a){G(a.2v!=c[3])I D().2q(d);I D(a)}d=[]}}N I D(b).2q(d)}N G(D.1D(d))I D(S)[D.17.27?"27":"43"](d);I 7.6Y(D.2d(d))},5w:"1.2.6",8G:H(){I 7.K},K:0,3p:H(a){I a==12?D.2d(7):7[a]},2I:H(b){J a=D(b);a.5n=7;I a},6Y:H(a){7.K=0;2p.44.1p.1w(7,a);I 7},P:H(a,b){I D.P(7,a,b)},5i:H(b){J a=-1;I D.2L(b&&b.5w?b[0]:b,7)},1K:H(c,a,b){J d=c;G(c.1q==56)G(a===12)I 7[0]&&D[b||"1K"](7[0],c);N{d={};d[c]=a}I 7.P(H(i){R(c 1n d)D.1K(b?7.V:7,c,D.1i(7,d[c],b,i,c))})},1g:H(b,a){G((b==\'2h\'||b==\'1Z\')&&3d(a)<0)a=12;I 7.1K(b,a,"2a")},1r:H(b){G(1j b!="49"&&b!=U)I 7.4E().3v((7[0]&&7[0].2z||S).5F(b));J a="";D.P(b||7,H(){D.P(7.3t,H(){G(7.16!=8)a+=7.16!=1?7.76:D.17.1r([7])})});I a},5z:H(b){G(7[0])D(b,7[0].2z).5y().39(7[0]).2l(H(){J a=7;1B(a.1x)a=a.1x;I a}).3v(7);I 7},8Y:H(a){I 7.P(H(){D(7).6Q().5z(a)})},8R:H(a){I 7.P(H(){D(7).5z(a)})},3v:H(){I 7.3W(19,M,Q,H(a){G(7.16==1)7.3U(a)})},6F:H(){I 7.3W(19,M,M,H(a){G(7.16==1)7.39(a,7.1x)})},6E:H(){I 7.3W(19,Q,Q,H(a){7.1d.39(a,7)})},5q:H(){I 7.3W(19,Q,M,H(a){7.1d.39(a,7.2H)})},3l:H(){I 7.5n||D([])},2q:H(b){J c=D.2l(7,H(a){I D.2q(b,a)});I 7.2I(/[^+>] [^+>]/.11(b)||b.1h("..")>-1?D.4r(c):c)},5y:H(e){J f=7.2l(H(){G(D.14.1f&&!D.4n(7)){J a=7.6o(M),5h=S.3h("1v");5h.3U(a);I D.4h([5h.4H])[0]}N I 7.6o(M)});J d=f.2q("*").5c().P(H(){G(7[E]!=12)7[E]=U});G(e===M)7.2q("*").5c().P(H(i){G(7.16==3)I;J c=D.L(7,"3w");R(J a 1n c)R(J b 1n c[a])D.W.1e(d[i],a,c[a][b],c[a][b].L)});I f},1E:H(b){I 7.2I(D.1D(b)&&D.3C(7,H(a,i){I b.1k(a,i)})||D.3g(b,7))},4Y:H(b){G(b.1q==56)G(62.11(b))I 7.2I(D.3g(b,7,M));N b=D.3g(b,7);J a=b.K&&b[b.K-1]!==12&&!b.16;I 7.1E(H(){I a?D.2L(7,b)<0:7!=b})},1e:H(a){I 7.2I(D.4r(D.2R(7.3p(),1j a==\'23\'?D(a):D.2d(a))))},3F:H(a){I!!a&&D.3g(a,7).K>0},7T:H(a){I 7.3F("."+a)},6e:H(b){G(b==12){G(7.K){J c=7[0];G(D.Y(c,"2A")){J e=c.64,63=[],15=c.15,2V=c.O=="2A-2V";G(e<0)I U;R(J i=2V?e:0,2f=2V?e+1:15.K;i<2f;i++){J d=15[i];G(d.2W){b=D.14.1f&&!d.at.2x.an?d.1r:d.2x;G(2V)I b;63.1p(b)}}I 63}N I(7[0].2x||"").1o(/\\r/g,"")}I 12}G(b.1q==4L)b+=\'\';I 7.P(H(){G(7.16!=1)I;G(b.1q==2p&&/5O|5L/.11(7.O))7.4J=(D.2L(7.2x,b)>=0||D.2L(7.34,b)>=0);N G(D.Y(7,"2A")){J a=D.2d(b);D("9R",7).P(H(){7.2W=(D.2L(7.2x,a)>=0||D.2L(7.1r,a)>=0)});G(!a.K)7.64=-1}N 7.2x=b})},2K:H(a){I a==12?(7[0]?7[0].4H:U):7.4E().3v(a)},7b:H(a){I 7.5q(a).21()},79:H(i){I 7.3s(i,i+1)},3s:H(){I 7.2I(2p.44.3s.1w(7,19))},2l:H(b){I 7.2I(D.2l(7,H(a,i){I b.1k(a,i,a)}))},5c:H(){I 7.1e(7.5n)},L:H(d,b){J a=d.1R(".");a[1]=a[1]?"."+a[1]:"";G(b===12){J c=7.5C("9z"+a[1]+"!",[a[0]]);G(c===12&&7.K)c=D.L(7[0],d);I c===12&&a[1]?7.L(a[0]):c}N I 7.1P("9u"+a[1]+"!",[a[0],b]).P(H(){D.L(7,d,b)})},3b:H(a){I 7.P(H(){D.3b(7,a)})},3W:H(g,f,h,d){J e=7.K>1,3x;I 7.P(H(){G(!3x){3x=D.4h(g,7.2z);G(h)3x.9o()}J b=7;G(f&&D.Y(7,"1T")&&D.Y(3x[0],"4F"))b=7.3H("22")[0]||7.3U(7.2z.3h("22"));J c=D([]);D.P(3x,H(){J a=e?D(7).5y(M)[0]:7;G(D.Y(a,"1m"))c=c.1e(a);N{G(a.16==1)c=c.1e(D("1m",a).21());d.1k(b,a)}});c.P(6T)})}};D.17.5j.44=D.17;H 6T(i,a){G(a.4d)D.3Y({1a:a.4d,31:Q,1O:"1m"});N D.5u(a.1r||a.6O||a.4H||"");G(a.1d)a.1d.37(a)}H 1z(){I+2B 8J}D.1l=D.17.1l=H(){J b=19[0]||{},i=1,K=19.K,4x=Q,15;G(b.1q==8I){4x=b;b=19[1]||{};i=2}G(1j b!="49"&&1j b!="H")b={};G(K==i){b=7;--i}R(;i<K;i++)G((15=19[i])!=U)R(J c 1n 15){J a=b[c],2w=15[c];G(b===2w)6M;G(4x&&2w&&1j 2w=="49"&&!2w.16)b[c]=D.1l(4x,a||(2w.K!=U?[]:{}),2w);N G(2w!==12)b[c]=2w}I b};J E="4M"+1z(),6K=0,5r={},6G=/z-?5i|8B-?8A|1y|6B|8v-?1Z/i,3P=S.3P||{};D.1l({8u:H(a){1b.$=3m$;G(a)1b.4M=w;I D},1D:H(a){I!!a&&1j a!="23"&&!a.Y&&a.1q!=2p&&/^[\\s[]?H/.11(a+"")},4n:H(a){I a.1C&&!a.1c||a.2j&&a.2z&&!a.2z.1c},5u:H(a){a=D.3k(a);G(a){J b=S.3H("6w")[0]||S.1C,1m=S.3h("1m");1m.O="1r/4t";G(D.14.1f)1m.1r=a;N 1m.3U(S.5F(a));b.39(1m,b.1x);b.37(1m)}},Y:H(b,a){I b.Y&&b.Y.2r()==a.2r()},1Y:{},L:H(c,d,b){c=c==1b?5r:c;J a=c[E];G(!a)a=c[E]=++6K;G(d&&!D.1Y[a])D.1Y[a]={};G(b!==12)D.1Y[a][d]=b;I d?D.1Y[a][d]:a},3b:H(c,b){c=c==1b?5r:c;J a=c[E];G(b){G(D.1Y[a]){2U D.1Y[a][b];b="";R(b 1n D.1Y[a])1X;G(!b)D.3b(c)}}N{1U{2U c[E]}1V(e){G(c.5l)c.5l(E)}2U D.1Y[a]}},P:H(d,a,c){J e,i=0,K=d.K;G(c){G(K==12){R(e 1n d)G(a.1w(d[e],c)===Q)1X}N R(;i<K;)G(a.1w(d[i++],c)===Q)1X}N{G(K==12){R(e 1n d)G(a.1k(d[e],e,d[e])===Q)1X}N R(J b=d[0];i<K&&a.1k(b,i,b)!==Q;b=d[++i]){}}I d},1i:H(b,a,c,i,d){G(D.1D(a))a=a.1k(b,i);I a&&a.1q==4L&&c=="2a"&&!6G.11(d)?a+"2X":a},1F:{1e:H(c,b){D.P((b||"").1R(/\\s+/),H(i,a){G(c.16==1&&!D.1F.3T(c.1F,a))c.1F+=(c.1F?" ":"")+a})},21:H(c,b){G(c.16==1)c.1F=b!=12?D.3C(c.1F.1R(/\\s+/),H(a){I!D.1F.3T(b,a)}).6s(" "):""},3T:H(b,a){I D.2L(a,(b.1F||b).6r().1R(/\\s+/))>-1}},6q:H(b,c,a){J e={};R(J d 1n c){e[d]=b.V[d];b.V[d]=c[d]}a.1k(b);R(J d 1n c)b.V[d]=e[d]},1g:H(d,e,c){G(e=="2h"||e=="1Z"){J b,3X={30:"5x",5g:"1G",18:"3I"},35=e=="2h"?["5e","6k"]:["5G","6i"];H 5b(){b=e=="2h"?d.8f:d.8c;J a=0,2C=0;D.P(35,H(){a+=3d(D.2a(d,"57"+7,M))||0;2C+=3d(D.2a(d,"2C"+7+"4b",M))||0});b-=29.83(a+2C)}G(D(d).3F(":4j"))5b();N D.6q(d,3X,5b);I 29.2f(0,b)}I D.2a(d,e,c)},2a:H(f,l,k){J e,V=f.V;H 3E(b){G(!D.14.2k)I Q;J a=3P.54(b,U);I!a||a.52("3E")==""}G(l=="1y"&&D.14.1f){e=D.1K(V,"1y");I e==""?"1":e}G(D.14.2G&&l=="18"){J d=V.50;V.50="0 7Y 7W";V.50=d}G(l.1I(/4i/i))l=y;G(!k&&V&&V[l])e=V[l];N G(3P.54){G(l.1I(/4i/i))l="4i";l=l.1o(/([A-Z])/g,"-$1").3y();J c=3P.54(f,U);G(c&&!3E(f))e=c.52(l);N{J g=[],2E=[],a=f,i=0;R(;a&&3E(a);a=a.1d)2E.6h(a);R(;i<2E.K;i++)G(3E(2E[i])){g[i]=2E[i].V.18;2E[i].V.18="3I"}e=l=="18"&&g[2E.K-1]!=U?"2F":(c&&c.52(l))||"";R(i=0;i<g.K;i++)G(g[i]!=U)2E[i].V.18=g[i]}G(l=="1y"&&e=="")e="1"}N G(f.4g){J h=l.1o(/\\-(\\w)/g,H(a,b){I b.2r()});e=f.4g[l]||f.4g[h];G(!/^\\d+(2X)?$/i.11(e)&&/^\\d/.11(e)){J j=V.1A,66=f.65.1A;f.65.1A=f.4g.1A;V.1A=e||0;e=V.aM+"2X";V.1A=j;f.65.1A=66}}I e},4h:H(l,h){J k=[];h=h||S;G(1j h.3h==\'12\')h=h.2z||h[0]&&h[0].2z||S;D.P(l,H(i,d){G(!d)I;G(d.1q==4L)d+=\'\';G(1j d=="23"){d=d.1o(/(<(\\w+)[^>]*?)\\/>/g,H(b,a,c){I c.1I(/^(aK|4f|7E|aG|4T|7A|aB|3n|az|ay|av)$/i)?b:a+"></"+c+">"});J f=D.3k(d).3y(),1v=h.3h("1v");J e=!f.1h("<au")&&[1,"<2A 7w=\'7w\'>","</2A>"]||!f.1h("<ar")&&[1,"<7v>","</7v>"]||f.1I(/^<(aq|22|am|ak|ai)/)&&[1,"<1T>","</1T>"]||!f.1h("<4F")&&[2,"<1T><22>","</22></1T>"]||(!f.1h("<af")||!f.1h("<ad"))&&[3,"<1T><22><4F>","</4F></22></1T>"]||!f.1h("<7E")&&[2,"<1T><22></22><7q>","</7q></1T>"]||D.14.1f&&[1,"1v<1v>","</1v>"]||[0,"",""];1v.4H=e[1]+d+e[2];1B(e[0]--)1v=1v.5T;G(D.14.1f){J g=!f.1h("<1T")&&f.1h("<22")<0?1v.1x&&1v.1x.3t:e[1]=="<1T>"&&f.1h("<22")<0?1v.3t:[];R(J j=g.K-1;j>=0;--j)G(D.Y(g[j],"22")&&!g[j].3t.K)g[j].1d.37(g[j]);G(/^\\s/.11(d))1v.39(h.5F(d.1I(/^\\s*/)[0]),1v.1x)}d=D.2d(1v.3t)}G(d.K===0&&(!D.Y(d,"3V")&&!D.Y(d,"2A")))I;G(d[0]==12||D.Y(d,"3V")||d.15)k.1p(d);N k=D.2R(k,d)});I k},1K:H(d,f,c){G(!d||d.16==3||d.16==8)I 12;J e=!D.4n(d),40=c!==12,1f=D.14.1f;f=e&&D.3X[f]||f;G(d.2j){J g=/5Q|4d|V/.11(f);G(f=="2W"&&D.14.2k)d.1d.64;G(f 1n d&&e&&!g){G(40){G(f=="O"&&D.Y(d,"4T")&&d.1d)7p"O a3 a1\'t 9V 9U";d[f]=c}G(D.Y(d,"3V")&&d.7i(f))I d.7i(f).76;I d[f]}G(1f&&e&&f=="V")I D.1K(d.V,"9T",c);G(40)d.9Q(f,""+c);J h=1f&&e&&g?d.4G(f,2):d.4G(f);I h===U?12:h}G(1f&&f=="1y"){G(40){d.6B=1;d.1E=(d.1E||"").1o(/7f\\([^)]*\\)/,"")+(3r(c)+\'\'=="9L"?"":"7f(1y="+c*7a+")")}I d.1E&&d.1E.1h("1y=")>=0?(3d(d.1E.1I(/1y=([^)]*)/)[1])/7a)+\'\':""}f=f.1o(/-([a-z])/9H,H(a,b){I b.2r()});G(40)d[f]=c;I d[f]},3k:H(a){I(a||"").1o(/^\\s+|\\s+$/g,"")},2d:H(b){J a=[];G(b!=U){J i=b.K;G(i==U||b.1R||b.4I||b.1k)a[0]=b;N 1B(i)a[--i]=b[i]}I a},2L:H(b,a){R(J i=0,K=a.K;i<K;i++)G(a[i]===b)I i;I-1},2R:H(a,b){J i=0,T,2S=a.K;G(D.14.1f){1B(T=b[i++])G(T.16!=8)a[2S++]=T}N 1B(T=b[i++])a[2S++]=T;I a},4r:H(a){J c=[],2o={};1U{R(J i=0,K=a.K;i<K;i++){J b=D.L(a[i]);G(!2o[b]){2o[b]=M;c.1p(a[i])}}}1V(e){c=a}I c},3C:H(c,a,d){J b=[];R(J i=0,K=c.K;i<K;i++)G(!d!=!a(c[i],i))b.1p(c[i]);I b},2l:H(d,a){J c=[];R(J i=0,K=d.K;i<K;i++){J b=a(d[i],i);G(b!=U)c[c.K]=b}I c.7d.1w([],c)}});J v=9B.9A.3y();D.14={5B:(v.1I(/.+(?:9y|9x|9w|9v)[\\/: ]([\\d.]+)/)||[])[1],2k:/75/.11(v),2G:/2G/.11(v),1f:/1f/.11(v)&&!/2G/.11(v),42:/42/.11(v)&&!/(9s|75)/.11(v)};J y=D.14.1f?"7o":"72";D.1l({71:!D.14.1f||S.70=="6Z",3X:{"R":"9n","9k":"1F","4i":y,72:y,7o:y,9h:"9f",9e:"9d",9b:"99"}});D.P({6W:H(a){I a.1d},97:H(a){I D.4S(a,"1d")},95:H(a){I D.3a(a,2,"2H")},91:H(a){I D.3a(a,2,"4l")},8Z:H(a){I D.4S(a,"2H")},8X:H(a){I D.4S(a,"4l")},8W:H(a){I D.5v(a.1d.1x,a)},8V:H(a){I D.5v(a.1x)},6Q:H(a){I D.Y(a,"8U")?a.8T||a.8S.S:D.2d(a.3t)}},H(c,d){D.17[c]=H(b){J a=D.2l(7,d);G(b&&1j b=="23")a=D.3g(b,a);I 7.2I(D.4r(a))}});D.P({6P:"3v",8Q:"6F",39:"6E",8P:"5q",8O:"7b"},H(c,b){D.17[c]=H(){J a=19;I 7.P(H(){R(J i=0,K=a.K;i<K;i++)D(a[i])[b](7)})}});D.P({8N:H(a){D.1K(7,a,"");G(7.16==1)7.5l(a)},8M:H(a){D.1F.1e(7,a)},8L:H(a){D.1F.21(7,a)},8K:H(a){D.1F[D.1F.3T(7,a)?"21":"1e"](7,a)},21:H(a){G(!a||D.1E(a,[7]).r.K){D("*",7).1e(7).P(H(){D.W.21(7);D.3b(7)});G(7.1d)7.1d.37(7)}},4E:H(){D(">*",7).21();1B(7.1x)7.37(7.1x)}},H(a,b){D.17[a]=H(){I 7.P(b,19)}});D.P(["6N","4b"],H(i,c){J b=c.3y();D.17[b]=H(a){I 7[0]==1b?D.14.2G&&S.1c["5t"+c]||D.14.2k&&1b["5s"+c]||S.70=="6Z"&&S.1C["5t"+c]||S.1c["5t"+c]:7[0]==S?29.2f(29.2f(S.1c["4y"+c],S.1C["4y"+c]),29.2f(S.1c["2i"+c],S.1C["2i"+c])):a==12?(7.K?D.1g(7[0],b):U):7.1g(b,a.1q==56?a:a+"2X")}});H 25(a,b){I a[0]&&3r(D.2a(a[0],b,M),10)||0}J C=D.14.2k&&3r(D.14.5B)<8H?"(?:[\\\\w*3m-]|\\\\\\\\.)":"(?:[\\\\w\\8F-\\8E*3m-]|\\\\\\\\.)",6L=2B 4v("^>\\\\s*("+C+"+)"),6J=2B 4v("^("+C+"+)(#)("+C+"+)"),6I=2B 4v("^([#.]?)("+C+"*)");D.1l({6H:{"":H(a,i,m){I m[2]=="*"||D.Y(a,m[2])},"#":H(a,i,m){I a.4G("2v")==m[2]},":":{8D:H(a,i,m){I i<m[3]-0},8C:H(a,i,m){I i>m[3]-0},3a:H(a,i,m){I m[3]-0==i},79:H(a,i,m){I m[3]-0==i},3o:H(a,i){I i==0},3S:H(a,i,m,r){I i==r.K-1},6D:H(a,i){I i%2==0},6C:H(a,i){I i%2},"3o-4u":H(a){I a.1d.3H("*")[0]==a},"3S-4u":H(a){I D.3a(a.1d.5T,1,"4l")==a},"8z-4u":H(a){I!D.3a(a.1d.5T,2,"4l")},6W:H(a){I a.1x},4E:H(a){I!a.1x},8y:H(a,i,m){I(a.6O||a.8x||D(a).1r()||"").1h(m[3])>=0},4j:H(a){I"1G"!=a.O&&D.1g(a,"18")!="2F"&&D.1g(a,"5g")!="1G"},1G:H(a){I"1G"==a.O||D.1g(a,"18")=="2F"||D.1g(a,"5g")=="1G"},8w:H(a){I!a.3R},3R:H(a){I a.3R},4J:H(a){I a.4J},2W:H(a){I a.2W||D.1K(a,"2W")},1r:H(a){I"1r"==a.O},5O:H(a){I"5O"==a.O},5L:H(a){I"5L"==a.O},5p:H(a){I"5p"==a.O},3Q:H(a){I"3Q"==a.O},5o:H(a){I"5o"==a.O},6A:H(a){I"6A"==a.O},6z:H(a){I"6z"==a.O},2s:H(a){I"2s"==a.O||D.Y(a,"2s")},4T:H(a){I/4T|2A|6y|2s/i.11(a.Y)},3T:H(a,i,m){I D.2q(m[3],a).K},8t:H(a){I/h\\d/i.11(a.Y)},8s:H(a){I D.3C(D.3O,H(b){I a==b.T}).K}}},6x:[/^(\\[) *@?([\\w-]+) *([!*$^~=]*) *(\'?"?)(.*?)\\4 *\\]/,/^(:)([\\w-]+)\\("?\'?(.*?(\\(.*?\\))?[^(]*?)"?\'?\\)/,2B 4v("^([:.#]*)("+C+"+)")],3g:H(a,c,b){J d,1t=[];1B(a&&a!=d){d=a;J f=D.1E(a,c,b);a=f.t.1o(/^\\s*,\\s*/,"");1t=b?c=f.r:D.2R(1t,f.r)}I 1t},2q:H(t,o){G(1j t!="23")I[t];G(o&&o.16!=1&&o.16!=9)I[];o=o||S;J d=[o],2o=[],3S,Y;1B(t&&3S!=t){J r=[];3S=t;t=D.3k(t);J l=Q,3j=6L,m=3j.2D(t);G(m){Y=m[1].2r();R(J i=0;d[i];i++)R(J c=d[i].1x;c;c=c.2H)G(c.16==1&&(Y=="*"||c.Y.2r()==Y))r.1p(c);d=r;t=t.1o(3j,"");G(t.1h(" ")==0)6M;l=M}N{3j=/^([>+~])\\s*(\\w*)/i;G((m=3j.2D(t))!=U){r=[];J k={};Y=m[2].2r();m=m[1];R(J j=0,3i=d.K;j<3i;j++){J n=m=="~"||m=="+"?d[j].2H:d[j].1x;R(;n;n=n.2H)G(n.16==1){J g=D.L(n);G(m=="~"&&k[g])1X;G(!Y||n.Y.2r()==Y){G(m=="~")k[g]=M;r.1p(n)}G(m=="+")1X}}d=r;t=D.3k(t.1o(3j,""));l=M}}G(t&&!l){G(!t.1h(",")){G(o==d[0])d.4s();2o=D.2R(2o,d);r=d=[o];t=" "+t.6v(1,t.K)}N{J h=6J;J m=h.2D(t);G(m){m=[0,m[2],m[3],m[1]]}N{h=6I;m=h.2D(t)}m[2]=m[2].1o(/\\\\/g,"");J f=d[d.K-1];G(m[1]=="#"&&f&&f.61&&!D.4n(f)){J p=f.61(m[2]);G((D.14.1f||D.14.2G)&&p&&1j p.2v=="23"&&p.2v!=m[2])p=D(\'[@2v="\'+m[2]+\'"]\',f)[0];d=r=p&&(!m[3]||D.Y(p,m[3]))?[p]:[]}N{R(J i=0;d[i];i++){J a=m[1]=="#"&&m[3]?m[3]:m[1]!=""||m[0]==""?"*":m[2];G(a=="*"&&d[i].Y.3y()=="49")a="3n";r=D.2R(r,d[i].3H(a))}G(m[1]==".")r=D.5m(r,m[2]);G(m[1]=="#"){J e=[];R(J i=0;r[i];i++)G(r[i].4G("2v")==m[2]){e=[r[i]];1X}r=e}d=r}t=t.1o(h,"")}}G(t){J b=D.1E(t,r);d=r=b.r;t=D.3k(b.t)}}G(t)d=[];G(d&&o==d[0])d.4s();2o=D.2R(2o,d);I 2o},5m:H(r,m,a){m=" "+m+" ";J c=[];R(J i=0;r[i];i++){J b=(" "+r[i].1F+" ").1h(m)>=0;G(!a&&b||a&&!b)c.1p(r[i])}I c},1E:H(t,r,h){J d;1B(t&&t!=d){d=t;J p=D.6x,m;R(J i=0;p[i];i++){m=p[i].2D(t);G(m){t=t.8r(m[0].K);m[2]=m[2].1o(/\\\\/g,"");1X}}G(!m)1X;G(m[1]==":"&&m[2]=="4Y")r=62.11(m[3])?D.1E(m[3],r,M).r:D(r).4Y(m[3]);N G(m[1]==".")r=D.5m(r,m[2],h);N G(m[1]=="["){J g=[],O=m[3];R(J i=0,3i=r.K;i<3i;i++){J a=r[i],z=a[D.3X[m[2]]||m[2]];G(z==U||/5Q|4d|2W/.11(m[2]))z=D.1K(a,m[2])||\'\';G((O==""&&!!z||O=="="&&z==m[5]||O=="!="&&z!=m[5]||O=="^="&&z&&!z.1h(m[5])||O=="$="&&z.6v(z.K-m[5].K)==m[5]||(O=="*="||O=="~=")&&z.1h(m[5])>=0)^h)g.1p(a)}r=g}N G(m[1]==":"&&m[2]=="3a-4u"){J e={},g=[],11=/(-?)(\\d*)n((?:\\+|-)?\\d*)/.2D(m[3]=="6D"&&"2n"||m[3]=="6C"&&"2n+1"||!/\\D/.11(m[3])&&"8q+"+m[3]||m[3]),3o=(11[1]+(11[2]||1))-0,d=11[3]-0;R(J i=0,3i=r.K;i<3i;i++){J j=r[i],1d=j.1d,2v=D.L(1d);G(!e[2v]){J c=1;R(J n=1d.1x;n;n=n.2H)G(n.16==1)n.4q=c++;e[2v]=M}J b=Q;G(3o==0){G(j.4q==d)b=M}N G((j.4q-d)%3o==0&&(j.4q-d)/3o>=0)b=M;G(b^h)g.1p(j)}r=g}N{J f=D.6H[m[1]];G(1j f=="49")f=f[m[2]];G(1j f=="23")f=6u("Q||H(a,i){I "+f+";}");r=D.3C(r,H(a,i){I f(a,i,m,r)},h)}}I{r:r,t:t}},4S:H(b,c){J a=[],1t=b[c];1B(1t&&1t!=S){G(1t.16==1)a.1p(1t);1t=1t[c]}I a},3a:H(a,e,c,b){e=e||1;J d=0;R(;a;a=a[c])G(a.16==1&&++d==e)1X;I a},5v:H(n,a){J r=[];R(;n;n=n.2H){G(n.16==1&&n!=a)r.1p(n)}I r}});D.W={1e:H(f,i,g,e){G(f.16==3||f.16==8)I;G(D.14.1f&&f.4I)f=1b;G(!g.24)g.24=7.24++;G(e!=12){J h=g;g=7.3M(h,H(){I h.1w(7,19)});g.L=e}J j=D.L(f,"3w")||D.L(f,"3w",{}),1H=D.L(f,"1H")||D.L(f,"1H",H(){G(1j D!="12"&&!D.W.5k)I D.W.1H.1w(19.3L.T,19)});1H.T=f;D.P(i.1R(/\\s+/),H(c,b){J a=b.1R(".");b=a[0];g.O=a[1];J d=j[b];G(!d){d=j[b]={};G(!D.W.2t[b]||D.W.2t[b].4p.1k(f)===Q){G(f.3K)f.3K(b,1H,Q);N G(f.6t)f.6t("4o"+b,1H)}}d[g.24]=g;D.W.26[b]=M});f=U},24:1,26:{},21:H(e,h,f){G(e.16==3||e.16==8)I;J i=D.L(e,"3w"),1L,5i;G(i){G(h==12||(1j h=="23"&&h.8p(0)=="."))R(J g 1n i)7.21(e,g+(h||""));N{G(h.O){f=h.2y;h=h.O}D.P(h.1R(/\\s+/),H(b,a){J c=a.1R(".");a=c[0];G(i[a]){G(f)2U i[a][f.24];N R(f 1n i[a])G(!c[1]||i[a][f].O==c[1])2U i[a][f];R(1L 1n i[a])1X;G(!1L){G(!D.W.2t[a]||D.W.2t[a].4A.1k(e)===Q){G(e.6p)e.6p(a,D.L(e,"1H"),Q);N G(e.6n)e.6n("4o"+a,D.L(e,"1H"))}1L=U;2U i[a]}}})}R(1L 1n i)1X;G(!1L){J d=D.L(e,"1H");G(d)d.T=U;D.3b(e,"3w");D.3b(e,"1H")}}},1P:H(h,c,f,g,i){c=D.2d(c);G(h.1h("!")>=0){h=h.3s(0,-1);J a=M}G(!f){G(7.26[h])D("*").1e([1b,S]).1P(h,c)}N{G(f.16==3||f.16==8)I 12;J b,1L,17=D.1D(f[h]||U),W=!c[0]||!c[0].32;G(W){c.6h({O:h,2J:f,32:H(){},3J:H(){},4C:1z()});c[0][E]=M}c[0].O=h;G(a)c[0].6m=M;J d=D.L(f,"1H");G(d)b=d.1w(f,c);G((!17||(D.Y(f,\'a\')&&h=="4V"))&&f["4o"+h]&&f["4o"+h].1w(f,c)===Q)b=Q;G(W)c.4s();G(i&&D.1D(i)){1L=i.1w(f,b==U?c:c.7d(b));G(1L!==12)b=1L}G(17&&g!==Q&&b!==Q&&!(D.Y(f,\'a\')&&h=="4V")){7.5k=M;1U{f[h]()}1V(e){}}7.5k=Q}I b},1H:H(b){J a,1L,38,5f,4m;b=19[0]=D.W.6l(b||1b.W);38=b.O.1R(".");b.O=38[0];38=38[1];5f=!38&&!b.6m;4m=(D.L(7,"3w")||{})[b.O];R(J j 1n 4m){J c=4m[j];G(5f||c.O==38){b.2y=c;b.L=c.L;1L=c.1w(7,19);G(a!==Q)a=1L;G(1L===Q){b.32();b.3J()}}}I a},6l:H(b){G(b[E]==M)I b;J d=b;b={8o:d};J c="8n 8m 8l 8k 2s 8j 47 5d 6j 5E 8i L 8h 8g 4K 2y 5a 59 8e 8b 58 6f 8a 88 4k 87 86 84 6d 2J 4C 6c O 82 81 35".1R(" ");R(J i=c.K;i;i--)b[c[i]]=d[c[i]];b[E]=M;b.32=H(){G(d.32)d.32();d.80=Q};b.3J=H(){G(d.3J)d.3J();d.7Z=M};b.4C=b.4C||1z();G(!b.2J)b.2J=b.6d||S;G(b.2J.16==3)b.2J=b.2J.1d;G(!b.4k&&b.4K)b.4k=b.4K==b.2J?b.6c:b.4K;G(b.58==U&&b.5d!=U){J a=S.1C,1c=S.1c;b.58=b.5d+(a&&a.2e||1c&&1c.2e||0)-(a.6b||0);b.6f=b.6j+(a&&a.2c||1c&&1c.2c||0)-(a.6a||0)}G(!b.35&&((b.47||b.47===0)?b.47:b.5a))b.35=b.47||b.5a;G(!b.59&&b.5E)b.59=b.5E;G(!b.35&&b.2s)b.35=(b.2s&1?1:(b.2s&2?3:(b.2s&4?2:0)));I b},3M:H(a,b){b.24=a.24=a.24||b.24||7.24++;I b},2t:{27:{4p:H(){55();I},4A:H(){I}},3D:{4p:H(){G(D.14.1f)I Q;D(7).2O("53",D.W.2t.3D.2y);I M},4A:H(){G(D.14.1f)I Q;D(7).4e("53",D.W.2t.3D.2y);I M},2y:H(a){G(F(a,7))I M;a.O="3D";I D.W.1H.1w(7,19)}},3N:{4p:H(){G(D.14.1f)I Q;D(7).2O("51",D.W.2t.3N.2y);I M},4A:H(){G(D.14.1f)I Q;D(7).4e("51",D.W.2t.3N.2y);I M},2y:H(a){G(F(a,7))I M;a.O="3N";I D.W.1H.1w(7,19)}}}};D.17.1l({2O:H(c,a,b){I c=="4X"?7.2V(c,a,b):7.P(H(){D.W.1e(7,c,b||a,b&&a)})},2V:H(d,b,c){J e=D.W.3M(c||b,H(a){D(7).4e(a,e);I(c||b).1w(7,19)});I 7.P(H(){D.W.1e(7,d,e,c&&b)})},4e:H(a,b){I 7.P(H(){D.W.21(7,a,b)})},1P:H(c,a,b){I 7.P(H(){D.W.1P(c,a,7,M,b)})},5C:H(c,a,b){I 7[0]&&D.W.1P(c,a,7[0],Q,b)},2m:H(b){J c=19,i=1;1B(i<c.K)D.W.3M(b,c[i++]);I 7.4V(D.W.3M(b,H(a){7.4Z=(7.4Z||0)%i;a.32();I c[7.4Z++].1w(7,19)||Q}))},7X:H(a,b){I 7.2O(\'3D\',a).2O(\'3N\',b)},27:H(a){55();G(D.2Q)a.1k(S,D);N D.3A.1p(H(){I a.1k(7,D)});I 7}});D.1l({2Q:Q,3A:[],27:H(){G(!D.2Q){D.2Q=M;G(D.3A){D.P(D.3A,H(){7.1k(S)});D.3A=U}D(S).5C("27")}}});J x=Q;H 55(){G(x)I;x=M;G(S.3K&&!D.14.2G)S.3K("69",D.27,Q);G(D.14.1f&&1b==1S)(H(){G(D.2Q)I;1U{S.1C.7V("1A")}1V(3e){3B(19.3L,0);I}D.27()})();G(D.14.2G)S.3K("69",H(){G(D.2Q)I;R(J i=0;i<S.4W.K;i++)G(S.4W[i].3R){3B(19.3L,0);I}D.27()},Q);G(D.14.2k){J a;(H(){G(D.2Q)I;G(S.3f!="68"&&S.3f!="1J"){3B(19.3L,0);I}G(a===12)a=D("V, 7A[7U=7S]").K;G(S.4W.K!=a){3B(19.3L,0);I}D.27()})()}D.W.1e(1b,"43",D.27)}D.P(("7R,7Q,43,85,4y,4X,4V,7P,"+"7O,7N,89,53,51,7M,2A,"+"5o,7L,7K,8d,3e").1R(","),H(i,b){D.17[b]=H(a){I a?7.2O(b,a):7.1P(b)}});J F=H(a,c){J b=a.4k;1B(b&&b!=c)1U{b=b.1d}1V(3e){b=c}I b==c};D(1b).2O("4X",H(){D("*").1e(S).4e()});D.17.1l({67:D.17.43,43:H(g,d,c){G(1j g!=\'23\')I 7.67(g);J e=g.1h(" ");G(e>=0){J i=g.3s(e,g.K);g=g.3s(0,e)}c=c||H(){};J f="2P";G(d)G(D.1D(d)){c=d;d=U}N{d=D.3n(d);f="6g"}J h=7;D.3Y({1a:g,O:f,1O:"2K",L:d,1J:H(a,b){G(b=="1W"||b=="7J")h.2K(i?D("<1v/>").3v(a.4U.1o(/<1m(.|\\s)*?\\/1m>/g,"")).2q(i):a.4U);h.P(c,[a.4U,b,a])}});I 7},aL:H(){I D.3n(7.7I())},7I:H(){I 7.2l(H(){I D.Y(7,"3V")?D.2d(7.aH):7}).1E(H(){I 7.34&&!7.3R&&(7.4J||/2A|6y/i.11(7.Y)||/1r|1G|3Q/i.11(7.O))}).2l(H(i,c){J b=D(7).6e();I b==U?U:b.1q==2p?D.2l(b,H(a,i){I{34:c.34,2x:a}}):{34:c.34,2x:b}}).3p()}});D.P("7H,7G,7F,7D,7C,7B".1R(","),H(i,o){D.17[o]=H(f){I 7.2O(o,f)}});J B=1z();D.1l({3p:H(d,b,a,c){G(D.1D(b)){a=b;b=U}I D.3Y({O:"2P",1a:d,L:b,1W:a,1O:c})},aE:H(b,a){I D.3p(b,U,a,"1m")},aD:H(c,b,a){I D.3p(c,b,a,"3z")},aC:H(d,b,a,c){G(D.1D(b)){a=b;b={}}I D.3Y({O:"6g",1a:d,L:b,1W:a,1O:c})},aA:H(a){D.1l(D.60,a)},60:{1a:5Z.5Q,26:M,O:"2P",2T:0,7z:"4R/x-ax-3V-aw",7x:M,31:M,L:U,5Y:U,3Q:U,4Q:{2N:"4R/2N, 1r/2N",2K:"1r/2K",1m:"1r/4t, 4R/4t",3z:"4R/3z, 1r/4t",1r:"1r/as",4w:"*/*"}},4z:{},3Y:H(s){s=D.1l(M,s,D.1l(M,{},D.60,s));J g,2Z=/=\\?(&|$)/g,1u,L,O=s.O.2r();G(s.L&&s.7x&&1j s.L!="23")s.L=D.3n(s.L);G(s.1O=="4P"){G(O=="2P"){G(!s.1a.1I(2Z))s.1a+=(s.1a.1I(/\\?/)?"&":"?")+(s.4P||"7u")+"=?"}N G(!s.L||!s.L.1I(2Z))s.L=(s.L?s.L+"&":"")+(s.4P||"7u")+"=?";s.1O="3z"}G(s.1O=="3z"&&(s.L&&s.L.1I(2Z)||s.1a.1I(2Z))){g="4P"+B++;G(s.L)s.L=(s.L+"").1o(2Z,"="+g+"$1");s.1a=s.1a.1o(2Z,"="+g+"$1");s.1O="1m";1b[g]=H(a){L=a;1W();1J();1b[g]=12;1U{2U 1b[g]}1V(e){}G(i)i.37(h)}}G(s.1O=="1m"&&s.1Y==U)s.1Y=Q;G(s.1Y===Q&&O=="2P"){J j=1z();J k=s.1a.1o(/(\\?|&)3m=.*?(&|$)/,"$ap="+j+"$2");s.1a=k+((k==s.1a)?(s.1a.1I(/\\?/)?"&":"?")+"3m="+j:"")}G(s.L&&O=="2P"){s.1a+=(s.1a.1I(/\\?/)?"&":"?")+s.L;s.L=U}G(s.26&&!D.4O++)D.W.1P("7H");J n=/^(?:\\w+:)?\\/\\/([^\\/?#]+)/;G(s.1O=="1m"&&O=="2P"&&n.11(s.1a)&&n.2D(s.1a)[1]!=5Z.al){J i=S.3H("6w")[0];J h=S.3h("1m");h.4d=s.1a;G(s.7t)h.aj=s.7t;G(!g){J l=Q;h.ah=h.ag=H(){G(!l&&(!7.3f||7.3f=="68"||7.3f=="1J")){l=M;1W();1J();i.37(h)}}}i.3U(h);I 12}J m=Q;J c=1b.7s?2B 7s("ae.ac"):2B 7r();G(s.5Y)c.6R(O,s.1a,s.31,s.5Y,s.3Q);N c.6R(O,s.1a,s.31);1U{G(s.L)c.4B("ab-aa",s.7z);G(s.5S)c.4B("a9-5R-a8",D.4z[s.1a]||"a7, a6 a5 a4 5N:5N:5N a2");c.4B("X-9Z-9Y","7r");c.4B("9W",s.1O&&s.4Q[s.1O]?s.4Q[s.1O]+", */*":s.4Q.4w)}1V(e){}G(s.7m&&s.7m(c,s)===Q){s.26&&D.4O--;c.7l();I Q}G(s.26)D.W.1P("7B",[c,s]);J d=H(a){G(!m&&c&&(c.3f==4||a=="2T")){m=M;G(f){7k(f);f=U}1u=a=="2T"&&"2T"||!D.7j(c)&&"3e"||s.5S&&D.7h(c,s.1a)&&"7J"||"1W";G(1u=="1W"){1U{L=D.6X(c,s.1O,s.9S)}1V(e){1u="5J"}}G(1u=="1W"){J b;1U{b=c.5I("7g-5R")}1V(e){}G(s.5S&&b)D.4z[s.1a]=b;G(!g)1W()}N D.5H(s,c,1u);1J();G(s.31)c=U}};G(s.31){J f=4I(d,13);G(s.2T>0)3B(H(){G(c){c.7l();G(!m)d("2T")}},s.2T)}1U{c.9P(s.L)}1V(e){D.5H(s,c,U,e)}G(!s.31)d();H 1W(){G(s.1W)s.1W(L,1u);G(s.26)D.W.1P("7C",[c,s])}H 1J(){G(s.1J)s.1J(c,1u);G(s.26)D.W.1P("7F",[c,s]);G(s.26&&!--D.4O)D.W.1P("7G")}I c},5H:H(s,a,b,e){G(s.3e)s.3e(a,b,e);G(s.26)D.W.1P("7D",[a,s,e])},4O:0,7j:H(a){1U{I!a.1u&&5Z.9O=="5p:"||(a.1u>=7e&&a.1u<9N)||a.1u==7c||a.1u==9K||D.14.2k&&a.1u==12}1V(e){}I Q},7h:H(a,c){1U{J b=a.5I("7g-5R");I a.1u==7c||b==D.4z[c]||D.14.2k&&a.1u==12}1V(e){}I Q},6X:H(a,c,b){J d=a.5I("9J-O"),2N=c=="2N"||!c&&d&&d.1h("2N")>=0,L=2N?a.9I:a.4U;G(2N&&L.1C.2j=="5J")7p"5J";G(b)L=b(L,c);G(c=="1m")D.5u(L);G(c=="3z")L=6u("("+L+")");I L},3n:H(a){J s=[];G(a.1q==2p||a.5w)D.P(a,H(){s.1p(3u(7.34)+"="+3u(7.2x))});N R(J j 1n a)G(a[j]&&a[j].1q==2p)D.P(a[j],H(){s.1p(3u(j)+"="+3u(7))});N s.1p(3u(j)+"="+3u(D.1D(a[j])?a[j]():a[j]));I s.6s("&").1o(/%20/g,"+")}});D.17.1l({1N:H(c,b){I c?7.2g({1Z:"1N",2h:"1N",1y:"1N"},c,b):7.1E(":1G").P(H(){7.V.18=7.5D||"";G(D.1g(7,"18")=="2F"){J a=D("<"+7.2j+" />").6P("1c");7.V.18=a.1g("18");G(7.V.18=="2F")7.V.18="3I";a.21()}}).3l()},1M:H(b,a){I b?7.2g({1Z:"1M",2h:"1M",1y:"1M"},b,a):7.1E(":4j").P(H(){7.5D=7.5D||D.1g(7,"18");7.V.18="2F"}).3l()},78:D.17.2m,2m:H(a,b){I D.1D(a)&&D.1D(b)?7.78.1w(7,19):a?7.2g({1Z:"2m",2h:"2m",1y:"2m"},a,b):7.P(H(){D(7)[D(7).3F(":1G")?"1N":"1M"]()})},9G:H(b,a){I 7.2g({1Z:"1N"},b,a)},9F:H(b,a){I 7.2g({1Z:"1M"},b,a)},9E:H(b,a){I 7.2g({1Z:"2m"},b,a)},9D:H(b,a){I 7.2g({1y:"1N"},b,a)},9M:H(b,a){I 7.2g({1y:"1M"},b,a)},9C:H(c,a,b){I 7.2g({1y:a},c,b)},2g:H(k,j,i,g){J h=D.77(j,i,g);I 7[h.36===Q?"P":"36"](H(){G(7.16!=1)I Q;J f=D.1l({},h),p,1G=D(7).3F(":1G"),46=7;R(p 1n k){G(k[p]=="1M"&&1G||k[p]=="1N"&&!1G)I f.1J.1k(7);G(p=="1Z"||p=="2h"){f.18=D.1g(7,"18");f.33=7.V.33}}G(f.33!=U)7.V.33="1G";f.45=D.1l({},k);D.P(k,H(c,a){J e=2B D.28(46,f,c);G(/2m|1N|1M/.11(a))e[a=="2m"?1G?"1N":"1M":a](k);N{J b=a.6r().1I(/^([+-]=)?([\\d+-.]+)(.*)$/),2b=e.1t(M)||0;G(b){J d=3d(b[2]),2M=b[3]||"2X";G(2M!="2X"){46.V[c]=(d||1)+2M;2b=((d||1)/e.1t(M))*2b;46.V[c]=2b+2M}G(b[1])d=((b[1]=="-="?-1:1)*d)+2b;e.3G(2b,d,2M)}N e.3G(2b,a,"")}});I M})},36:H(a,b){G(D.1D(a)||(a&&a.1q==2p)){b=a;a="28"}G(!a||(1j a=="23"&&!b))I A(7[0],a);I 7.P(H(){G(b.1q==2p)A(7,a,b);N{A(7,a).1p(b);G(A(7,a).K==1)b.1k(7)}})},9X:H(b,c){J a=D.3O;G(b)7.36([]);7.P(H(){R(J i=a.K-1;i>=0;i--)G(a[i].T==7){G(c)a[i](M);a.7n(i,1)}});G(!c)7.5A();I 7}});J A=H(b,c,a){G(b){c=c||"28";J q=D.L(b,c+"36");G(!q||a)q=D.L(b,c+"36",D.2d(a))}I q};D.17.5A=H(a){a=a||"28";I 7.P(H(){J q=A(7,a);q.4s();G(q.K)q[0].1k(7)})};D.1l({77:H(b,a,c){J d=b&&b.1q==a0?b:{1J:c||!c&&a||D.1D(b)&&b,2u:b,41:c&&a||a&&a.1q!=9t&&a};d.2u=(d.2u&&d.2u.1q==4L?d.2u:D.28.5K[d.2u])||D.28.5K.74;d.5M=d.1J;d.1J=H(){G(d.36!==Q)D(7).5A();G(D.1D(d.5M))d.5M.1k(7)};I d},41:{73:H(p,n,b,a){I b+a*p},5P:H(p,n,b,a){I((-29.9r(p*29.9q)/2)+0.5)*a+b}},3O:[],48:U,28:H(b,c,a){7.15=c;7.T=b;7.1i=a;G(!c.3Z)c.3Z={}}});D.28.44={4D:H(){G(7.15.2Y)7.15.2Y.1k(7.T,7.1z,7);(D.28.2Y[7.1i]||D.28.2Y.4w)(7);G(7.1i=="1Z"||7.1i=="2h")7.T.V.18="3I"},1t:H(a){G(7.T[7.1i]!=U&&7.T.V[7.1i]==U)I 7.T[7.1i];J r=3d(D.1g(7.T,7.1i,a));I r&&r>-9p?r:3d(D.2a(7.T,7.1i))||0},3G:H(c,b,d){7.5V=1z();7.2b=c;7.3l=b;7.2M=d||7.2M||"2X";7.1z=7.2b;7.2S=7.4N=0;7.4D();J e=7;H t(a){I e.2Y(a)}t.T=7.T;D.3O.1p(t);G(D.48==U){D.48=4I(H(){J a=D.3O;R(J i=0;i<a.K;i++)G(!a[i]())a.7n(i--,1);G(!a.K){7k(D.48);D.48=U}},13)}},1N:H(){7.15.3Z[7.1i]=D.1K(7.T.V,7.1i);7.15.1N=M;7.3G(0,7.1t());G(7.1i=="2h"||7.1i=="1Z")7.T.V[7.1i]="9m";D(7.T).1N()},1M:H(){7.15.3Z[7.1i]=D.1K(7.T.V,7.1i);7.15.1M=M;7.3G(7.1t(),0)},2Y:H(a){J t=1z();G(a||t>7.15.2u+7.5V){7.1z=7.3l;7.2S=7.4N=1;7.4D();7.15.45[7.1i]=M;J b=M;R(J i 1n 7.15.45)G(7.15.45[i]!==M)b=Q;G(b){G(7.15.18!=U){7.T.V.33=7.15.33;7.T.V.18=7.15.18;G(D.1g(7.T,"18")=="2F")7.T.V.18="3I"}G(7.15.1M)7.T.V.18="2F";G(7.15.1M||7.15.1N)R(J p 1n 7.15.45)D.1K(7.T.V,p,7.15.3Z[p])}G(b)7.15.1J.1k(7.T);I Q}N{J n=t-7.5V;7.4N=n/7.15.2u;7.2S=D.41[7.15.41||(D.41.5P?"5P":"73")](7.4N,n,0,1,7.15.2u);7.1z=7.2b+((7.3l-7.2b)*7.2S);7.4D()}I M}};D.1l(D.28,{5K:{9l:9j,9i:7e,74:9g},2Y:{2e:H(a){a.T.2e=a.1z},2c:H(a){a.T.2c=a.1z},1y:H(a){D.1K(a.T.V,"1y",a.1z)},4w:H(a){a.T.V[a.1i]=a.1z+a.2M}}});D.17.2i=H(){J b=0,1S=0,T=7[0],3q;G(T)ao(D.14){J d=T.1d,4a=T,1s=T.1s,1Q=T.2z,5U=2k&&3r(5B)<9c&&!/9a/i.11(v),1g=D.2a,3c=1g(T,"30")=="3c";G(T.7y){J c=T.7y();1e(c.1A+29.2f(1Q.1C.2e,1Q.1c.2e),c.1S+29.2f(1Q.1C.2c,1Q.1c.2c));1e(-1Q.1C.6b,-1Q.1C.6a)}N{1e(T.5X,T.5W);1B(1s){1e(1s.5X,1s.5W);G(42&&!/^t(98|d|h)$/i.11(1s.2j)||2k&&!5U)2C(1s);G(!3c&&1g(1s,"30")=="3c")3c=M;4a=/^1c$/i.11(1s.2j)?4a:1s;1s=1s.1s}1B(d&&d.2j&&!/^1c|2K$/i.11(d.2j)){G(!/^96|1T.*$/i.11(1g(d,"18")))1e(-d.2e,-d.2c);G(42&&1g(d,"33")!="4j")2C(d);d=d.1d}G((5U&&(3c||1g(4a,"30")=="5x"))||(42&&1g(4a,"30")!="5x"))1e(-1Q.1c.5X,-1Q.1c.5W);G(3c)1e(29.2f(1Q.1C.2e,1Q.1c.2e),29.2f(1Q.1C.2c,1Q.1c.2c))}3q={1S:1S,1A:b}}H 2C(a){1e(D.2a(a,"6V",M),D.2a(a,"6U",M))}H 1e(l,t){b+=3r(l,10)||0;1S+=3r(t,10)||0}I 3q};D.17.1l({30:H(){J a=0,1S=0,3q;G(7[0]){J b=7.1s(),2i=7.2i(),4c=/^1c|2K$/i.11(b[0].2j)?{1S:0,1A:0}:b.2i();2i.1S-=25(7,\'94\');2i.1A-=25(7,\'aF\');4c.1S+=25(b,\'6U\');4c.1A+=25(b,\'6V\');3q={1S:2i.1S-4c.1S,1A:2i.1A-4c.1A}}I 3q},1s:H(){J a=7[0].1s;1B(a&&(!/^1c|2K$/i.11(a.2j)&&D.1g(a,\'30\')==\'93\'))a=a.1s;I D(a)}});D.P([\'5e\',\'5G\'],H(i,b){J c=\'4y\'+b;D.17[c]=H(a){G(!7[0])I;I a!=12?7.P(H(){7==1b||7==S?1b.92(!i?a:D(1b).2e(),i?a:D(1b).2c()):7[c]=a}):7[0]==1b||7[0]==S?46[i?\'aI\':\'aJ\']||D.71&&S.1C[c]||S.1c[c]:7[0][c]}});D.P(["6N","4b"],H(i,b){J c=i?"5e":"5G",4f=i?"6k":"6i";D.17["5s"+b]=H(){I 7[b.3y()]()+25(7,"57"+c)+25(7,"57"+4f)};D.17["90"+b]=H(a){I 7["5s"+b]()+25(7,"2C"+c+"4b")+25(7,"2C"+4f+"4b")+(a?25(7,"6S"+c)+25(7,"6S"+4f):0)}})})();',62,669,'|||||||this|||||||||||||||||||||||||||||||||||if|function|return|var|length|data|true|else|type|each|false|for|document|elem|null|style|event||nodeName|||test|undefined||browser|options|nodeType|fn|display|arguments|url|window|body|parentNode|add|msie|css|indexOf|prop|typeof|call|extend|script|in|replace|push|constructor|text|offsetParent|cur|status|div|apply|firstChild|opacity|now|left|while|documentElement|isFunction|filter|className|hidden|handle|match|complete|attr|ret|hide|show|dataType|trigger|doc|split|top|table|try|catch|success|break|cache|height||remove|tbody|string|guid|num|global|ready|fx|Math|curCSS|start|scrollTop|makeArray|scrollLeft|max|animate|width|offset|tagName|safari|map|toggle||done|Array|find|toUpperCase|button|special|duration|id|copy|value|handler|ownerDocument|select|new|border|exec|stack|none|opera|nextSibling|pushStack|target|html|inArray|unit|xml|bind|GET|isReady|merge|pos|timeout|delete|one|selected|px|step|jsre|position|async|preventDefault|overflow|name|which|queue|removeChild|namespace|insertBefore|nth|removeData|fixed|parseFloat|error|readyState|multiFilter|createElement|rl|re|trim|end|_|param|first|get|results|parseInt|slice|childNodes|encodeURIComponent|append|events|elems|toLowerCase|json|readyList|setTimeout|grep|mouseenter|color|is|custom|getElementsByTagName|block|stopPropagation|addEventListener|callee|proxy|mouseleave|timers|defaultView|password|disabled|last|has|appendChild|form|domManip|props|ajax|orig|set|easing|mozilla|load|prototype|curAnim|self|charCode|timerId|object|offsetChild|Width|parentOffset|src|unbind|br|currentStyle|clean|float|visible|relatedTarget|previousSibling|handlers|isXMLDoc|on|setup|nodeIndex|unique|shift|javascript|child|RegExp|_default|deep|scroll|lastModified|teardown|setRequestHeader|timeStamp|update|empty|tr|getAttribute|innerHTML|setInterval|checked|fromElement|Number|jQuery|state|active|jsonp|accepts|application|dir|input|responseText|click|styleSheets|unload|not|lastToggle|outline|mouseout|getPropertyValue|mouseover|getComputedStyle|bindReady|String|padding|pageX|metaKey|keyCode|getWH|andSelf|clientX|Left|all|visibility|container|index|init|triggered|removeAttribute|classFilter|prevObject|submit|file|after|windowData|inner|client|globalEval|sibling|jquery|absolute|clone|wrapAll|dequeue|version|triggerHandler|oldblock|ctrlKey|createTextNode|Top|handleError|getResponseHeader|parsererror|speeds|checkbox|old|00|radio|swing|href|Modified|ifModified|lastChild|safari2|startTime|offsetTop|offsetLeft|username|location|ajaxSettings|getElementById|isSimple|values|selectedIndex|runtimeStyle|rsLeft|_load|loaded|DOMContentLoaded|clientTop|clientLeft|toElement|srcElement|val|pageY|POST|unshift|Bottom|clientY|Right|fix|exclusive|detachEvent|cloneNode|removeEventListener|swap|toString|join|attachEvent|eval|substr|head|parse|textarea|reset|image|zoom|odd|even|before|prepend|exclude|expr|quickClass|quickID|uuid|quickChild|continue|Height|textContent|appendTo|contents|open|margin|evalScript|borderTopWidth|borderLeftWidth|parent|httpData|setArray|CSS1Compat|compatMode|boxModel|cssFloat|linear|def|webkit|nodeValue|speed|_toggle|eq|100|replaceWith|304|concat|200|alpha|Last|httpNotModified|getAttributeNode|httpSuccess|clearInterval|abort|beforeSend|splice|styleFloat|throw|colgroup|XMLHttpRequest|ActiveXObject|scriptCharset|callback|fieldset|multiple|processData|getBoundingClientRect|contentType|link|ajaxSend|ajaxSuccess|ajaxError|col|ajaxComplete|ajaxStop|ajaxStart|serializeArray|notmodified|keypress|keydown|change|mouseup|mousedown|dblclick|focus|blur|stylesheet|hasClass|rel|doScroll|black|hover|solid|cancelBubble|returnValue|wheelDelta|view|round|shiftKey|resize|screenY|screenX|relatedNode|mousemove|prevValue|originalTarget|offsetHeight|keyup|newValue|offsetWidth|eventPhase|detail|currentTarget|cancelable|bubbles|attrName|attrChange|altKey|originalEvent|charAt|0n|substring|animated|header|noConflict|line|enabled|innerText|contains|only|weight|font|gt|lt|uFFFF|u0128|size|417|Boolean|Date|toggleClass|removeClass|addClass|removeAttr|replaceAll|insertAfter|prependTo|wrap|contentWindow|contentDocument|iframe|children|siblings|prevAll|wrapInner|nextAll|outer|prev|scrollTo|static|marginTop|next|inline|parents|able|cellSpacing|adobeair|cellspacing|522|maxLength|maxlength|readOnly|400|readonly|fast|600|class|slow|1px|htmlFor|reverse|10000|PI|cos|compatible|Function|setData|ie|ra|it|rv|getData|userAgent|navigator|fadeTo|fadeIn|slideToggle|slideUp|slideDown|ig|responseXML|content|1223|NaN|fadeOut|300|protocol|send|setAttribute|option|dataFilter|cssText|changed|be|Accept|stop|With|Requested|Object|can|GMT|property|1970|Jan|01|Thu|Since|If|Type|Content|XMLHTTP|th|Microsoft|td|onreadystatechange|onload|cap|charset|colg|host|tfoot|specified|with|1_|thead|leg|plain|attributes|opt|embed|urlencoded|www|area|hr|ajaxSetup|meta|post|getJSON|getScript|marginLeft|img|elements|pageYOffset|pageXOffset|abbr|serialize|pixelLeft'.split('|'),0,{}));

var Drupal = Drupal || { 'settings': {}, 'behaviors': {}, 'themes': {}, 'locale': {} };

/**
 * Set the variable that indicates if JavaScript behaviors should be applied
 */
Drupal.jsEnabled = true;

/**
 * Attach all registered behaviors to a page element.
 *
 * Behaviors are event-triggered actions that attach to page elements, enhancing
 * default non-Javascript UIs. Behaviors are registered in the Drupal.behaviors
 * object as follows:
 * @code
 *    Drupal.behaviors.behaviorName = function () {
 *      ...
 *    };
 * @endcode
 *
 * Drupal.attachBehaviors is added below to the jQuery ready event and so
 * runs on initial page load. Developers implementing AHAH/AJAX in their
 * solutions should also call this function after new page content has been
 * loaded, feeding in an element to be processed, in order to attach all
 * behaviors to the new content.
 *
 * Behaviors should use a class in the form behaviorName-processed to ensure
 * the behavior is attached only once to a given element. (Doing so enables
 * the reprocessing of given elements, which may be needed on occasion despite
 * the ability to limit behavior attachment to a particular element.)
 *
 * @param context
 *   An element to attach behaviors to. If none is given, the document element
 *   is used.
 */
Drupal.attachBehaviors = function(context) {
  context = context || document;
  // Execute all of them.
  jQuery.each(Drupal.behaviors, function() {
    this(context);
  });
};

/**
 * Encode special characters in a plain-text string for display as HTML.
 */
Drupal.checkPlain = function(str) {
  str = String(str);
  var replace = { '&': '&amp;', '"': '&quot;', '<': '&lt;', '>': '&gt;' };
  for (var character in replace) {
    var regex = new RegExp(character, 'g');
    str = str.replace(regex, replace[character]);
  }
  return str;
};

/**
 * Translate strings to the page language or a given language.
 *
 * See the documentation of the server-side t() function for further details.
 *
 * @param str
 *   A string containing the English string to translate.
 * @param args
 *   An object of replacements pairs to make after translation. Incidences
 *   of any key in this array are replaced with the corresponding value.
 *   Based on the first character of the key, the value is escaped and/or themed:
 *    - !variable: inserted as is
 *    - @variable: escape plain text to HTML (Drupal.checkPlain)
 *    - %variable: escape text and theme as a placeholder for user-submitted
 *      content (checkPlain + Drupal.theme('placeholder'))
 * @return
 *   The translated string.
 */
Drupal.t = function(str, args) {
  // Fetch the localized version of the string.
  if (Drupal.locale.strings && Drupal.locale.strings[str]) {
    str = Drupal.locale.strings[str];
  }

  if (args) {
    // Transform arguments before inserting them
    for (var key in args) {
      switch (key.charAt(0)) {
        // Escaped only
        case '@':
          args[key] = Drupal.checkPlain(args[key]);
        break;
        // Pass-through
        case '!':
          break;
        // Escaped and placeholder
        case '%':
        default:
          args[key] = Drupal.theme('placeholder', args[key]);
          break;
      }
      str = str.replace(key, args[key]);
    }
  }
  return str;
};

/**
 * Format a string containing a count of items.
 *
 * This function ensures that the string is pluralized correctly. Since Drupal.t() is
 * called by this function, make sure not to pass already-localized strings to it.
 *
 * See the documentation of the server-side format_plural() function for further details.
 *
 * @param count
 *   The item count to display.
 * @param singular
 *   The string for the singular case. Please make sure it is clear this is
 *   singular, to ease translation (e.g. use "1 new comment" instead of "1 new").
 *   Do not use @count in the singular string.
 * @param plural
 *   The string for the plural case. Please make sure it is clear this is plural,
 *   to ease translation. Use @count in place of the item count, as in "@count
 *   new comments".
 * @param args
 *   An object of replacements pairs to make after translation. Incidences
 *   of any key in this array are replaced with the corresponding value.
 *   Based on the first character of the key, the value is escaped and/or themed:
 *    - !variable: inserted as is
 *    - @variable: escape plain text to HTML (Drupal.checkPlain)
 *    - %variable: escape text and theme as a placeholder for user-submitted
 *      content (checkPlain + Drupal.theme('placeholder'))
 *   Note that you do not need to include @count in this array.
 *   This replacement is done automatically for the plural case.
 * @return
 *   A translated string.
 */
Drupal.formatPlural = function(count, singular, plural, args) {
  var args = args || {};
  args['@count'] = count;
  // Determine the index of the plural form.
  var index = Drupal.locale.pluralFormula ? Drupal.locale.pluralFormula(args['@count']) : ((args['@count'] == 1) ? 0 : 1);

  if (index == 0) {
    return Drupal.t(singular, args);
  }
  else if (index == 1) {
    return Drupal.t(plural, args);
  }
  else {
    args['@count['+ index +']'] = args['@count'];
    delete args['@count'];
    return Drupal.t(plural.replace('@count', '@count['+ index +']'), args);
  }
};

/**
 * Generate the themed representation of a Drupal object.
 *
 * All requests for themed output must go through this function. It examines
 * the request and routes it to the appropriate theme function. If the current
 * theme does not provide an override function, the generic theme function is
 * called.
 *
 * For example, to retrieve the HTML that is output by theme_placeholder(text),
 * call Drupal.theme('placeholder', text).
 *
 * @param func
 *   The name of the theme function to call.
 * @param ...
 *   Additional arguments to pass along to the theme function.
 * @return
 *   Any data the theme function returns. This could be a plain HTML string,
 *   but also a complex object.
 */
Drupal.theme = function(func) {
  for (var i = 1, args = []; i < arguments.length; i++) {
    args.push(arguments[i]);
  }

  return (Drupal.theme[func] || Drupal.theme.prototype[func]).apply(this, args);
};

/**
 * Parse a JSON response.
 *
 * The result is either the JSON object, or an object with 'status' 0 and 'data' an error message.
 */
Drupal.parseJson = function (data) {
  if ((data.substring(0, 1) != '{') && (data.substring(0, 1) != '[')) {
    return { status: 0, data: data.length ? data : Drupal.t('Unspecified error') };
  }
  return eval('(' + data + ');');
};

/**
 * Freeze the current body height (as minimum height). Used to prevent
 * unnecessary upwards scrolling when doing DOM manipulations.
 */
Drupal.freezeHeight = function () {
  Drupal.unfreezeHeight();
  var div = document.createElement('div');
  $(div).css({
    position: 'absolute',
    top: '0px',
    left: '0px',
    width: '1px',
    height: $('body').css('height')
  }).attr('id', 'freeze-height');
  $('body').append(div);
};

/**
 * Unfreeze the body height
 */
Drupal.unfreezeHeight = function () {
  $('#freeze-height').remove();
};

/**
 * Wrapper around encodeURIComponent() which avoids Apache quirks (equivalent of
 * drupal_urlencode() in PHP). This function should only be used on paths, not
 * on query string arguments.
 */
Drupal.encodeURIComponent = function (item, uri) {
  uri = uri || location.href;
  item = encodeURIComponent(item).replace(/%2F/g, '/');
  return (uri.indexOf('?q=') != -1) ? item : item.replace(/%26/g, '%2526').replace(/%23/g, '%2523').replace(/\/\//g, '/%252F');
};

/**
 * Get the text selection in a textarea.
 */
Drupal.getSelection = function (element) {
  if (typeof(element.selectionStart) != 'number' && document.selection) {
    // The current selection
    var range1 = document.selection.createRange();
    var range2 = range1.duplicate();
    // Select all text.
    range2.moveToElementText(element);
    // Now move 'dummy' end point to end point of original range.
    range2.setEndPoint('EndToEnd', range1);
    // Now we can calculate start and end points.
    var start = range2.text.length - range1.text.length;
    var end = start + range1.text.length;
    return { 'start': start, 'end': end };
  }
  return { 'start': element.selectionStart, 'end': element.selectionEnd };
};

/**
 * Build an error message from ahah response.
 */
Drupal.ahahError = function(xmlhttp, uri) {
  if (xmlhttp.status == 200) {
    if (jQuery.trim(xmlhttp.responseText)) {
      var message = Drupal.t("An error occurred. \n@uri\n@text", {'@uri': uri, '@text': xmlhttp.responseText });
    }
    else {
      var message = Drupal.t("An error occurred. \n@uri\n(no information available).", {'@uri': uri });
    }
  }
  else {
    var message = Drupal.t("An HTTP error @status occurred. \n@uri", {'@uri': uri, '@status': xmlhttp.status });
  }
  return message.replace(/\n/g, '<br />');
}

// Global Killswitch on the <html> element
$(document.documentElement).addClass('js');
// Attach all behaviors.
$(document).ready(function() {
  Drupal.attachBehaviors(this);
});

/**
 * The default themes.
 */
Drupal.theme.prototype = {

  /**
   * Formats text for emphasized display in a placeholder inside a sentence.
   *
   * @param str
   *   The text to format (plain-text).
   * @return
   *   The formatted text (html).
   */
  placeholder: function(str) {
    return '<em>' + Drupal.checkPlain(str) + '</em>';
  }
};
;
Drupal.locale = { 'pluralFormula': function($n) { return Number(($n!=1)); }, 'strings': {"Unspecified error":"Error no especificado","Your server has been successfully tested to support this feature.":"Su servidor pas\u00f3 con \u00e9xito la prueba sobre soporte de esta caracter\u00edstica.","Your system configuration does not currently support this feature. The \u003ca href=\"http:\/\/drupal.org\/node\/15365\"\u003ehandbook page on Clean URLs\u003c\/a\u003e has additional troubleshooting information.":"La configuraci\u00f3n de su sistema no admite actualmente esta caracter\u00edstica. La \u003ca href=\"http:\/\/drupal.org\/node\/15365\"\u003ep\u00e1gina del manual sobre URL limpias\u003c\/a\u003e tiene m\u00e1s informaci\u00f3n sobre posibles problemas.","Testing clean URLs...":"Probando URL limpias...","Select all rows in this table":"Seleccionar todas las filas de esta tabla","Deselect all rows in this table":"Quitar la selecci\u00f3n a todas las filas de esta tabla","Drag to re-order":"Arrastre para reordenar","Changes made in this table will not be saved until the form is submitted.":"Los cambios realizados en esta tabla no se guardar\u00e1n hasta que se env\u00ede el formulario","The changes to these blocks will not be saved until the \u003cem\u003eSave blocks\u003c\/em\u003e button is clicked.":"Los cambios sobre estos bloques no se guardar\u00e1n hasta que no pulse el bot\u00f3n \u003cem\u003eGuardar bloques\u003c\/em\u003e.","The selected file %filename cannot be uploaded. Only files with the following extensions are allowed: %extensions.":"El archivo seleccionado %filename no puede ser subido. Solo se permiten archivos con las siguientes extensiones: %extensions.","jQuery UI Tabs: Mismatching fragment identifier.":"jQuery UI Tabs: Identificador de fragmento no coincidente.","jQuery UI Tabs: Not enough arguments to add tab.":"jQuery UI Tabs: No hay argumentos para a\u00f1adir solapa.","Internal server error. Please see server or PHP logs for error information.":"Error interno del servidor. Por favor, consulte los registros de informaci\u00f3n de error del servidor o PHP.","Next":"Siguiente","Remove this item":"Eliminar este elemento","Loading...":"Cargando...","Close":"Cerrar","Previous":"Anterior","Content can be only inserted into CKEditor in WYSIWYG mode.":"En CKEditor, el contenido s\u00f3lo se puede insertar en modo WYSIWYG.","Automatic alias":"Alias autom\u00e1tico","Alias: @alias":"Alias: @alias","No alias":"Sin alias"} };;


// $Id: dhtml_menu.js,v 1.18.2.10 2009/01/12 10:13:30 arancaytar Exp $

/**
 * @file dhtml_menu.js
 * The Javascript code for DHTML Menu
 */
 
Drupal.dhtmlMenu = {};

/**
 * Initialize the module's JS functions
 */
Drupal.behaviors.dhtmlMenu = function() {
  // Do not run this function more than once.
  if (Drupal.dhtmlMenu.init) {
    return;
  }
  else {
    Drupal.dhtmlMenu.init = true;
  }

  // Get the settings.
  var effects = Drupal.settings.dhtmlMenu;

  $('.collapsed').removeClass('expanded');

  // Get cookie
  if (!effects.siblings) {
    var cookie = Drupal.dhtmlMenu.cookieGet();
    for (var i in cookie) {
      // If the cookie was not applied to the HTML code yet, do so now.
      var li = $('#dhtml_menu-' + cookie[i]).parents('li:first');
      if ($(li).hasClass('collapsed')) {
        Drupal.dhtmlMenu.toggleMenu(li);
      }
    }
  }

  /* Add jQuery effects and listeners to all menu items.
   * The ~ (sibling) selector is unidirectional and selects 
   * only the latter element, so we must use siblings() to get 
   * back to the link element.
   */
   $('ul.menu li.dhtml-menu:not(.leaf,.no-dhtml)').each(function() {
    var li = this;
    if (effects.clone) {
      var ul = $(li).find('ul:first');
      if (ul.length) {
        $(li).find('a:first').clone().prependTo(ul).wrap('<li class="leaf fake-leaf"></li>');
      }
    }

    if (effects.doubleclick) {
      $(li).find('a:first').dblclick(function(e) {
        window.location = this.href;
      });
    }

    $(li).find('a:first').click(function(e) {
      Drupal.dhtmlMenu.toggleMenu($(li));
      return false;
    });
  });
}

/**
 * Toggles the menu's state between open and closed.
 *
 * @param li
 *   Object. The <li> element that will be expanded or collapsed.
 */
Drupal.dhtmlMenu.toggleMenu = function(li) {
  var effects = Drupal.settings.dhtmlMenu;

  // If the menu is expanded, collapse it.
  if($(li).hasClass('expanded')) {
    if (effects.slide) {
      $(li).find('ul:first').animate({height: 'hide', opacity: 'hide','filter':''}, '1000');
    }
    else $(li).find('ul:first').css('display', 'none');

    // If children are closed automatically, find and close them now.
    if (effects.children) {
      if (effects.slide) {
        $(li).find('li.expanded').find('ul:first').animate({height: 'hide', opacity: 'hide','filter':''}, '1000');
      }
      else $(li).find('li.expanded').find('ul:first').css('display', 'none');

      $(li).find('li.expanded').removeClass('expanded').addClass('collapsed')
    }

    $(li).removeClass('expanded').addClass('collapsed');
  }

  // Otherwise, expand it.
  else {
    if (effects.slide) {
      $(li).find('ul:first').animate({height: 'show', opacity: 'show','filter':''}, '1000');
    }
    else $(li).find('ul:first').css('display', 'block');
    $(li).removeClass('collapsed').addClass('expanded');

    // If the siblings effect is on, close all sibling menus.
    if (effects.siblings) {
      var id = $(li).find('a:first').attr('id');

      // Siblings are all open menus that are neither parents nor children of this menu.
      $(li).find('li').addClass('own-children-temp');
	  
      // If the relativity option is on, select only the siblings that have the same parent
      if (effects.relativity) {
        var siblings = $(li).parent().find('li.expanded').not('.own-children-temp').not(':has(#' + id + ')');
      }
      // Otherwise, select all menus of the same level
      else {
        var siblings = $('ul.menu li.expanded').not('.own-children-temp').not(':has(#' + id + ')');
      }

      // If children should not get closed automatically...
      if (!effects.children) {
        // Remove items that are currently hidden from view (do not close these).
        $('li.collapsed li.expanded').addClass('sibling-children-temp');
        // Only close the top-most open sibling, not its children.
        $(siblings).find('li.expanded').addClass('sibling-children-temp');
        siblings = $(siblings).not('.sibling-children-temp');
      }

      $('.own-children-temp, .sibling-children-temp').removeClass('own-children-temp').removeClass('sibling-children-temp');

      if (effects.slide) {
        $(siblings).find('ul:first').animate({height: 'hide', opacity: 'hide','filter':''}, '1000');
      }
      else $(siblings).find('ul:first').css('display', 'none');

      $(siblings).removeClass('expanded').addClass('collapsed');
    }
  }

  // Save the current state of the menus in the cookie.
  Drupal.dhtmlMenu.cookieSet();
}

/**
 * Reads the dhtml_menu cookie.
 */
Drupal.dhtmlMenu.cookieGet = function() {
  var c = /dhtml_menu=(.*?)(;|$)/.exec(document.cookie);
  if (c) {
    return c[1];
  }
  else return '';
}

/**
 * Saves the dhtml_menu cooki.
 */
Drupal.dhtmlMenu.cookieSet = function() {
  var expanded = new Array();
  $('li.expanded').each(function() {
    expanded.push($(this).find('a:first').attr('id').substr(5));
  });
  document.cookie = 'dhtml_menu=' + expanded.join(',') + ';path=/';
}

;
/**
 * Modified Star Rating - jQuery plugin
 *
 * Copyright (c) 2006 Wil Stuckey
 *
 * Original source available: http://sandbox.wilstuckey.com/jquery-ratings/
 * Extensively modified by Lullabot: http://www.lullabot.com
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */

/**
 * Create a degradeable star rating interface out of a simple form structure.
 * Returns a modified jQuery object containing the new interface.
 *   
 * @example jQuery('form.rating').fivestar();
 * @cat plugin
 * @type jQuery 
 *
 */
(function($){ // Create local scope.
    /**
     * Takes the form element, builds the rating interface and attaches the proper events.
     * @param {Object} $obj
     */
    var buildRating = function($obj){
        var $widget = buildInterface($obj),
            $stars = $('.star', $widget),
            $cancel = $('.cancel', $widget),
            $summary = $('.fivestar-summary', $obj),
            feedbackTimerId = 0,
            summaryText = $summary.html(),
            summaryHover = $obj.is('.fivestar-labels-hover'),
            currentValue = $("select", $obj).val(),
            cancelTitle = $('label', $obj).html(),
            voteTitle = cancelTitle != Drupal.settings.fivestar.titleAverage ? cancelTitle : Drupal.settings.fivestar.titleUser,
            voteChanged = false;

        // Record star display.
        if ($obj.is('.fivestar-user-stars')) {
          var starDisplay = 'user';
        }
        else if ($obj.is('.fivestar-average-stars')) {
          var starDisplay = 'average';
          currentValue = $("input[name=vote_average]", $obj).val();
        }
        else if ($obj.is('.fivestar-combo-stars')) {
          var starDisplay = 'combo';
        }
        else {
          var starDisplay = 'none';
        }

        // Smart is intentionally separate, so the average will be set if necessary.
        if ($obj.is('.fivestar-smart-stars')) {
          var starDisplay = 'smart';
        }

        // Record text display.
        if ($summary.size()) {
          var textDisplay = $summary.attr('class').replace(/.*?fivestar-summary-([^ ]+).*/, '$1').replace(/-/g, '_');
        }
        else {
          var textDisplay = 'none';
        }

        // Add hover and focus events.
        $stars
            .mouseover(function(){
                event.drain();
                event.fill(this);
            })
            .mouseout(function(){
                event.drain();
                event.reset();
            });
        $stars.children()
            .focus(function(){
                event.drain();
                event.fill(this.parentNode)
            })
            .blur(function(){
                event.drain();
                event.reset();
            }).end();

        // Cancel button events.
        $cancel
            .mouseover(function(){
                event.drain();
                $(this).addClass('on')
            })
            .mouseout(function(){
                event.reset();
                $(this).removeClass('on')
            });
        $cancel.children()
            .focus(function(){
                event.drain();
                $(this.parentNode).addClass('on')
            })
            .blur(function(){
                event.reset();
                $(this.parentNode).removeClass('on')
            }).end();

        // Click events.
        $cancel.click(function(){
            currentValue = 0;
            event.reset();
            voteChanged = false;
            // Inform a user that his vote is being processed
            if ($("input.fivestar-path", $obj).size() && $summary.is('.fivestar-feedback-enabled')) {
              setFeedbackText(Drupal.settings.fivestar.feedbackDeletingVote);
            }
            // Save the currentValue in a hidden field.
            $("select", $obj).val(0);
            // Update the title.
            cancelTitle = starDisplay != 'smart' ? cancelTitle : Drupal.settings.fivestar.titleAverage;
            $('label', $obj).html(cancelTitle);
            // Update the smart classes on the widget if needed.
            if ($obj.is('.fivestar-smart-text')) {
              $obj.removeClass('fivestar-user-text').addClass('fivestar-average-text');
              $summary[0].className = $summary[0].className.replace(/-user/, '-average');
              textDisplay = $summary.attr('class').replace(/.*?fivestar-summary-([^ ]+).*/, '$1').replace(/-/g, '_');
            }
            if ($obj.is('.fivestar-smart-stars')) {
              $obj.removeClass('fivestar-user-stars').addClass('fivestar-average-stars');
            }
            // Submit the form if needed.
            $("input.fivestar-path", $obj).each(function() {
              var token = $("input.fivestar-token", $obj).val();
              $.ajax({
                type: 'GET',
                data: { token: token },
                dataType: 'xml',
                url: this.value + '/' + 0,
                success: voteHook
              });
            });
            return false;
        });
        $stars.click(function(){
            currentValue = $('select option', $obj).get($stars.index(this) + $cancel.size() + 1).value;
            // Save the currentValue to the hidden select field.
            $("select", $obj).val(currentValue);
            // Update the display of the stars.
            voteChanged = true;
            event.reset();
            // Inform a user that his vote is being processed.
            if ($("input.fivestar-path", $obj).size() && $summary.is('.fivestar-feedback-enabled')) {
              setFeedbackText(Drupal.settings.fivestar.feedbackSavingVote);
            }
            // Update the smart classes on the widget if needed.
            if ($obj.is('.fivestar-smart-text')) {
              $obj.removeClass('fivestar-average-text').addClass('fivestar-user-text');
              $summary[0].className = $summary[0].className.replace(/-average/, '-user');
              textDisplay = $summary.attr('class').replace(/.*?fivestar-summary-([^ ]+).*/, '$1').replace(/-/g, '_');
            }
            if ($obj.is('.fivestar-smart-stars')) {
              $obj.removeClass('fivestar-average-stars').addClass('fivestar-user-stars');
            }
            // Submit the form if needed.
            $("input.fivestar-path", $obj).each(function () {
              var token = $("input.fivestar-token", $obj).val();
              $.ajax({
                type: 'GET',
                data: { token: token },
                dataType: 'xml',
                url: this.value + '/' + currentValue,
                success: voteHook
              });
            });
            return false;
        });

        var event = {
            fill: function(el){
              // Fill to the current mouse position.
              var index = $stars.index(el) + 1;
              $stars
                .children('a').css('width', '100%').end()
                .filter(':lt(' + index + ')').addClass('hover').end();
              // Update the description text and label.
              if (summaryHover && !feedbackTimerId) {
                var summary = $("select option", $obj)[index + $cancel.size()].text;
                var value = $("select option", $obj)[index + $cancel.size()].value;
                $summary.html(summary != index + 1 ? summary : '&nbsp;');
                $('label', $obj).html(voteTitle);
              }
            },
            drain: function() {
              // Drain all the stars.
              $stars
                .filter('.on').removeClass('on').end()
                .filter('.hover').removeClass('hover').end();
              // Update the description text.
              if (summaryHover && !feedbackTimerId) {
                var cancelText = $("select option", $obj)[1].text;
                $summary.html(($cancel.size() && cancelText != 0) ? cancelText : '&nbsp');
                if (!voteChanged) {
                  $('label', $obj).html(cancelTitle);
                }
              }
            },
            reset: function(){
              // Reset the stars to the default index.
              var starValue = currentValue/100 * $stars.size();
              var percent = (starValue - Math.floor(starValue)) * 100;
              $stars.filter(':lt(' + Math.floor(starValue) + ')').addClass('on').end();
              if (percent > 0) {
                $stars.eq(Math.floor(starValue)).addClass('on').children('a').css('width', percent + "%").end().end();
              }
              // Restore the summary text and original title.
              if (summaryHover && !feedbackTimerId) {
                $summary.html(summaryText ? summaryText : '&nbsp;');
              }
              if (voteChanged) {
                $('label', $obj).html(voteTitle);
              }
              else {
                $('label', $obj).html(cancelTitle);
              }
            }
        };

        var setFeedbackText = function(text) {
          // Kill previous timer if it isn't finished yet so that the text we
          // are about to set will not get cleared too early.
          feedbackTimerId = 1;
          $summary.html(text);
        };

        /**
         * Checks for the presence of a javascript hook 'fivestarResult' to be
         * called upon completion of a AJAX vote request.
         */
        var voteHook = function(data) {
          var returnObj = {
            result: {
              count: $("result > count", data).text(),
              average: $("result > average", data).text(),
              summary: {
                average: $("summary average", data).text(),
                average_count: $("summary average_count", data).text(),
                user: $("summary user", data).text(),
                user_count: $("summary user_count", data).text(),
                combo: $("summary combo", data).text(),
                count: $("summary count", data).text()
              }
            },
            vote: {
              id: $("vote id", data).text(),
              tag: $("vote tag", data).text(),
              type: $("vote type", data).text(),
              value: $("vote value", data).text()
            },
            display: {
              stars: starDisplay,
              text: textDisplay
            }
          };
          // Check for a custom callback.
          if (window.fivestarResult) {
            fivestarResult(returnObj);
          }
          // Use the default.
          else {
            fivestarDefaultResult(returnObj);
          }
          // Update the summary text.
          summaryText = returnObj.result.summary[returnObj.display.text];
          if ($(returnObj.result.summary.average).is('.fivestar-feedback-enabled')) {
            // Inform user that his/her vote has been processed.
            if (returnObj.vote.value != 0) { // check if vote has been saved or deleted 
              setFeedbackText(Drupal.settings.fivestar.feedbackVoteSaved);
            }
            else {
              setFeedbackText(Drupal.settings.fivestar.feedbackVoteDeleted);
            }
            // Setup a timer to clear the feedback text after 3 seconds.
            feedbackTimerId = setTimeout(function() { clearTimeout(feedbackTimerId); feedbackTimerId = 0; $summary.html(returnObj.result.summary[returnObj.display.text]); }, 2000);
          }
          // Update the current star currentValue to the previous average.
          if (returnObj.vote.value == 0 && (starDisplay == 'average' || starDisplay == 'smart')) {
            currentValue = returnObj.result.average;
            event.reset();
          }
        };

        event.reset();
        return $widget;
    };
    
    /**
     * Accepts jQuery object containing a single fivestar widget.
     * Returns the proper div structure for the star interface.
     * 
     * @return jQuery
     * @param {Object} $widget
     * 
     */
    var buildInterface = function($widget){
        var $container = $('<div class="fivestar-widget clear-block"></div>');
        var $options = $("select option", $widget);
        var size = $('option', $widget).size() - 1;
        var cancel = 1;
        for (var i = 1, option; option = $options[i]; i++){
            if (option.value == "0") {
              cancel = 0;
              $div = $('<div class="cancel"><a href="#0" title="' + option.text + '">' + option.text + '</a></div>');
            }
            else {
              var zebra = (i + cancel - 1) % 2 == 0 ? 'even' : 'odd';
              var count = i + cancel - 1;
              var first = count == 1 ? ' star-first' : '';
              var last = count == size + cancel - 1 ? ' star-last' : '';
              $div = $('<div class="star star-' + count + ' star-' + zebra + first + last + '"><a href="#' + option.value + '" title="' + option.text + '">' + option.text + '</a></div>');
            }
            $container.append($div[0]);
        }
        $container.addClass('fivestar-widget-' + (size + cancel - 1));
        // Attach the new widget and hide the existing widget.
        $('select', $widget).after($container).css('display', 'none');
        return $container;
    };

    /**
     * Standard handler to update the average rating when a user changes their
     * vote. This behavior can be overridden by implementing a fivestarResult
     * function in your own module or theme.
     * @param object voteResult
     * Object containing the following properties from the vote result:
     * voteResult.result.count The current number of votes for this item.
     * voteResult.result.average The current average of all votes for this item.
     * voteResult.result.summary.average The textual description of the average.
     * voteResult.result.summary.user The textual description of the user's current vote.
     * voteResult.vote.id The id of the item the vote was placed on (such as the nid)
     * voteResult.vote.type The type of the item the vote was placed on (such as 'node')
     * voteResult.vote.tag The multi-axis tag the vote was placed on (such as 'vote')
     * voteResult.vote.average The average of the new vote saved
     * voteResult.display.stars The type of star display we're using. Either 'average', 'user', or 'combo'.
     * voteResult.display.text The type of text display we're using. Either 'average', 'user', or 'combo'.
     */
    function fivestarDefaultResult(voteResult) {
      // Update the summary text.
      $('div.fivestar-summary-'+voteResult.vote.tag+'-'+voteResult.vote.id).html(voteResult.result.summary[voteResult.display.text]);
      // If this is a combo display, update the average star display.
      if (voteResult.display.stars == 'combo') {
        $('div.fivestar-form-'+voteResult.vote.id).each(function() {
          // Update stars.
          var $stars = $('.fivestar-widget-static .star span', this);
          var average = voteResult.result.average/100 * $stars.size();
          var index = Math.floor(average);
          $stars.removeClass('on').addClass('off').css('width', 'auto');
          $stars.filter(':lt(' + (index + 1) + ')').removeClass('off').addClass('on');
          $stars.eq(index).css('width', ((average - index) * 100) + "%");
          // Update summary.
          var $summary = $('.fivestar-static-form-item .fivestar-summary', this);
          if ($summary.size()) {
            var textDisplay = $summary.attr('class').replace(/.*?fivestar-summary-([^ ]+).*/, '$1').replace(/-/g, '_');
            $summary.html(voteResult.result.summary[textDisplay]);
          }
        });
      }
    };

    /**
     * Set up the plugin
     */
    $.fn.fivestar = function() {
      var stack = [];
      this.each(function() {
          var ret = buildRating($(this));
          stack.push(ret);
      });
      return stack;
    };

  // Fix ie6 background flicker problem.
  if ($.browser.msie == true) {
    try {
      document.execCommand('BackgroundImageCache', false, true);
    } catch(err) {}
  }

  Drupal.behaviors.fivestar = function(context) {
    $('div.fivestar-form-item:not(.fivestar-processed)', context).addClass('fivestar-processed').fivestar();
    $('input.fivestar-submit', context).css('display', 'none');
  }

})(jQuery);;

$(document).ready(function() {

  // Attach onclick event to document only and catch clicks on all elements.
  $(document.body).click(function(event) {
    // Catch only the first parent link of a clicked element.
    $(event.target).parents("a:first,area:first").andSelf().filter("a,area").each(function() {

      var ga = Drupal.settings.googleanalytics;
      // Expression to check for absolute internal links.
      var isInternal = new RegExp("^(https?):\/\/" + window.location.host, "i");
      // Expression to check for special links like gotwo.module /go/* links.
      var isInternalSpecial = new RegExp("(\/go\/.*)$", "i");
      // Expression to check for download links.
      var isDownload = new RegExp("\\.(" + ga.trackDownloadExtensions + ")$", "i");

      // Is the clicked URL internal?
      if (isInternal.test(this.href)) {
        // Is download tracking activated and the file extension configured for download tracking?
        if (ga.trackDownload && isDownload.test(this.href)) {
          // Download link clicked.
          var extension = isDownload.exec(this.href);
          _gaq.push(["_trackEvent", "Downloads", extension[1].toUpperCase(), this.href.replace(isInternal, '')]);
        }
        else if (isInternalSpecial.test(this.href)) {
          // Keep the internal URL for Google Analytics website overlay intact.
          _gaq.push(["_trackPageview", this.href.replace(isInternal, '')]);
        }
      }
      else {
        if (ga.trackMailto && $(this).is("a[href^=mailto:],area[href^=mailto:]")) {
          // Mailto link clicked.
          _gaq.push(["_trackEvent", "Mails", "Click", this.href.substring(7)]);
        }
        else if (ga.trackOutgoing && this.href) {
          if (ga.trackOutboundAsPageview) {
            // Track all external links as page views after URL cleanup.
            // Currently required, if click should be tracked as goal.
            _gaq.push(["_trackPageview", '/outbound/' + this.href.replace(/^(https?|ftp|news|nntp|telnet|irc|ssh|sftp|webcal):\/\//i, '').split('/').join('--')]);
          }
          else {
            // External link clicked.
            _gaq.push(["_trackEvent", "Outbound links", "Click", this.href]);
          }
        }
      }
    });
  });
});
;
/* $Id: auto_image_handling.js,v 1.1.4.33 2010/09/22 21:07:57 snpower Exp $ */

// Image Node Auto-Format with Auto Image Grouping.
// Original version by Steve McKenzie.
// Altered by Stella Power for jQuery version.

function parse_url(url, param) {
  param = param.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  url = url.replace(/&amp;/, "&");
  var regexS = "[\\?&]"+param+"=([^&#]*)";
  var regex = new RegExp(regexS);
  var results = regex.exec(url);
  if (results === null) {
    return "";
  }
  else {
    return results[1];
  }
}


function lightbox2_init_triggers(classes, rel_type, custom_class) {
  if (classes == '' || rel_type == 0) {
    return;
  }
  var settings = Drupal.settings.lightbox2;

  var link_target  = "";
  if (settings.node_link_target !== 0) {
    link_target = 'target="'+ settings.node_link_target +'"';
  }

  $("a:has("+classes+")").each(function(i) {

    if ((!settings.disable_for_gallery_lists && !settings.disable_for_acidfree_gallery_lists) || (!$(this).parents("td.giAlbumCell").attr("class") && !$(this).parents(".galleries").length && !$(this).parents(".acidfree-folder").length && !$(this).parents(".acidfree-list").length) || ($(this).parents(".galleries").length && !settings.disable_for_gallery_lists) || (($(this).parents(".acidfree-folder").length || $(this).parents(".acidfree-list").length) && !settings.disable_for_acidfree_gallery_lists)) {

      var child = $(this).find(classes);

      // Ensure the child has a class attribute we can work with.
      if ($(child).attr("class") && !$(this).parents("div.acidfree-video").length) {

        // Set the alt text.
        var alt = $(child).attr("alt");
        if (!alt) {
          alt = "";
        }

        // Set the image node link text.
        var link_text = settings.node_link_text;
        var download_link_text = settings.download_link_text;
        var rewrite = 1;

        // Set the rel attribute.
        var rel = "lightbox";
        var lightframe = false;
        if (rel_type == "lightframe_ungrouped") {
          rel = "lightframe[]";
          lightframe = true;
        }
        else if (rel_type == "lightframe") {
          lightframe = true;
        }
        else if (rel_type == "lightbox_ungrouped") {
          rel = "lightbox[]";
        }
        if (rel_type != "lightbox_ungrouped" && rel_type != "lightframe_ungrouped") {
          rel = rel_type + "[" + $(child).attr("class") + "]";
        }

        // Set the basic href attribute - need to ensure there's no language
        // string (e.g. /en) prepended to the URL.
        var id = null;
        var href = $(child).attr("src");
        var download = null;
        var orig_href = $(this).attr("href");
        var pattern = new RegExp(settings.file_path);
        if (orig_href.match(pattern)) {
          var lang_pattern = new RegExp(Drupal.settings.basePath + "\\w\\w\\/");
          orig_href = orig_href.replace(lang_pattern, Drupal.settings.basePath);
        }
        var frame_href = orig_href;

        // Handle flickr images.
        if ($(child).attr("class").match("flickr-photo-img") ||
          $(child).attr("class").match("flickr-photoset-img")) {
          href = $(child).attr("src").replace("_s.", ".").replace("_t.", ".").replace("_m.", ".").replace("_b.", ".");
          if (rel_type != "lightbox_ungrouped" && rel_type != "lightframe_ungrouped") {
            rel = rel_type + "[flickr]";
            if ($(child).parents("div.block-flickr").attr("class")) {
              id = $(child).parents("div.block-flickr").attr("id");
              rel = rel_type + "["+ id +"]";
            }
          }
          download = href;
        }

        // Handle "image-img_assist_custom" images.
        else if ($(child).filter("img[class*=img_assist_custom]").size()) {
          // Image assist uses "+" signs for spaces which doesn't work for
          // normal links.
          if (settings.display_image_size != "original") {
            orig_href = orig_href.replace(/\+/, " ");
            href = $(child).attr("src").replace(new RegExp("\\.img_assist_custom-[0-9]+x[0-9]+"), ((settings.display_image_size === "")?settings.display_image_size:"."+ settings.display_image_size));
            if (rel_type != "lightbox_ungrouped" && rel_type != "lightframe_ungrouped") {
              rel = rel_type + "[node_images]";
            }
            if (lightframe) {
              frame_href = orig_href + "/lightbox2";
            }
          }
          else {
            rewrite = 0;
          }
        }

        // Handle "inline" images.
        else if ($(child).attr("class").match("inline")) {
          href = orig_href;
        }

        // Handle gallery2 block images.
        else if ($(child).attr("class").match("ImageFrame_image") || $(child).attr("class").match("ImageFrame_none")) {
          var thumb_id = parse_url(href, "g2_itemId");
          var new_id = parse_url(orig_href, "g2_itemId");
          if (new_id && thumb_id) {
            var g2pattern = new RegExp("g2_itemId="+thumb_id);
            var replacement = "g2_itemId="+ new_id;
            href = href.replace(g2pattern, replacement);
          }
          rel = rel_type + "[gallery2]";
          if ($(child).parents("div.block-gallery").attr("class")) {
            id = $(child).parents("div.block-gallery").attr("id");
            rel = rel_type + "["+ id +"]";
          }
          download = href;
        }


        // Set the href attribute.
        else if (settings.image_node_sizes != '()' && !custom_class) {
          if (settings.display_image_size != "original") {
            href = $(child).attr("src").replace(new RegExp(settings.image_node_sizes), ((settings.display_image_size === "")?settings.display_image_size:"."+ settings.display_image_size)).replace(/(image\/view\/\d+)(\/[\w\-]*)/, ((settings.display_image_size === "")?"$1/_original":"$1/"+ settings.display_image_size));
            if (rel_type != "lightbox_ungrouped" && rel_type != "lightframe_ungrouped") {
              rel = rel_type + "[node_images]";
              if ($(child).parents("div.block-multiblock,div.block-image").attr("class")) {
                id = $(child).parents("div.block-multiblock,div.block-image").attr("id");
                rel = rel_type + "["+ id +"]";
              }
            }
            download = $(child).attr("src").replace(new RegExp(settings.image_node_sizes), "").replace(/(image\/view\/\d+)(\/[\w\-]*)/, "$1/_original");
            if (lightframe) {
              frame_href = orig_href + "/lightbox2";
            }
          }
          else {
            rewrite = 0;
          }
        }

        // Modify the image url.
        var img_title = $(child).attr("title");
        if (!img_title) {
          img_title = $(this).attr("title");
          if (!img_title) {
            img_title = $(child).attr("alt");
          }
          $(child).attr({title: img_title});
        }
        if (lightframe) {
          href = frame_href;
        }
        if (rewrite) {
          if (!custom_class) {
            var title_link = "";
            if (link_text.length) {
              title_link = "<br /><br /><a href=\"" + orig_href + "\" id=\"lightbox2-node-link-text\" "+ link_target +" >"+ link_text + "</a>";
            }
            if (download_link_text.length && download) {
              title_link = title_link + " - <a href=\"" + download + "\" id=\"lightbox2-download-link-text\" target=\"_blank\">" + download_link_text + "</a>";
            }
            rel = rel + "[" + img_title + title_link + "]";
            $(this).attr({
              rel: rel,
              href: href
            });
          }
          else {
            if (rel_type != "lightbox_ungrouped" && rel_type != "lightframe_ungrouped") {
              rel = rel_type + "[" + $(child).attr("class") + "]";
              if ($(child).parents("div.block-image").attr("class")) {
                id = $(child).parents("div.block-image").attr("id");
                rel = rel_type + "["+ id +"]";
              }
            }
            rel = rel + "[" + img_title + "]";
            $(this).attr({
              rel: rel,
              href: orig_href
            });
          }
        }
      }
    }

  });
}

function lightbox2_init_acidfree_video() {
  var settings = Drupal.settings.lightbox2;

  var link_target  = "";
  if (settings.node_link_target !== 0) {
    link_target = 'target="'+ settings.node_link_target +'"';
  }

  var link_text = settings.node_link_text;
  var rel = "lightframe";

  $("div.acidfree-video a").each(function(i) {

    if (!settings.disable_for_acidfree_gallery_lists || (!$(this).parents(".acidfree-folder").length && !$(this).parents(".acidfree-list").length) || (($(this).parents(".acidfree-folder").length || $(this).parents(".acidfree-list").length) && !settings.disable_for_acidfree_gallery_lists)) {
      var orig_href = $(this).attr("href");
      var href = orig_href + "/lightframevideo";
      var title = $(this).attr("title");
      var title_link = "";
      if (link_text.length) {
        title_link = "<br /><a href=\"" + orig_href + "\" id=\"lightbox2-node-link-text\" "+ link_target +" >"+ link_text + "</a>";
      }

      $(this).attr({
        rel: rel,
        title: title + title_link,
        href: href
      });
    }
  });
}

function lightbox2_image_nodes() {

  var settings = Drupal.settings.lightbox2;

  // Don't do it on the image assist popup selection screen.
  var img_assist = document.getElementById("img_assist_thumbs");
  if (!img_assist) {

    // Select the enabled image types.
    lightbox2_init_triggers(settings.trigger_lightbox_classes, "lightbox_ungrouped");
    lightbox2_init_triggers(settings.custom_trigger_classes, settings.custom_class_handler, true);
    lightbox2_init_triggers(settings.trigger_lightbox_group_classes, "lightbox");
    lightbox2_init_triggers(settings.trigger_slideshow_classes, "lightshow");
    lightbox2_init_triggers(settings.trigger_lightframe_classes, "lightframe_ungrouped");
    lightbox2_init_triggers(settings.trigger_lightframe_group_classes, "lightframe");
    if (settings.enable_acidfree_videos) {
      lightbox2_init_acidfree_video();
    }

  }
}


Drupal.behaviors.initAutoLightbox = function (context) {
  lightbox2_image_nodes();
};

;
/* $Id: lightbox.js,v 1.5.2.6.2.136 2010/09/24 08:39:40 snpower Exp $ */

/**
 * jQuery Lightbox
 * @author
 *   Stella Power, <http://drupal.org/user/66894>
 *
 * Based on Lightbox v2.03.3 by Lokesh Dhakar
 * <http://www.huddletogether.com/projects/lightbox2/>
 * Also partially based on the jQuery Lightbox by Warren Krewenki
 *   <http://warren.mesozen.com>
 *
 * Permission has been granted to Mark Ashmead & other Drupal Lightbox2 module
 * maintainers to distribute this file via Drupal.org
 * Under GPL license.
 *
 * Slideshow, iframe and video functionality added by Stella Power.
 */

var Lightbox = {
  auto_modal : false,
  overlayOpacity : 0.8, // Controls transparency of shadow overlay.
  overlayColor : '000', // Controls colour of shadow overlay.
  disableCloseClick : true,
  // Controls the order of the lightbox resizing animation sequence.
  resizeSequence: 0, // 0: simultaneous, 1: width then height, 2: height then width.
  resizeSpeed: 'normal', // Controls the speed of the lightbox resizing animation.
  fadeInSpeed: 'normal', // Controls the speed of the image appearance.
  slideDownSpeed: 'slow', // Controls the speed of the image details appearance.
  minWidth: 240,
  borderSize : 10,
  boxColor : 'fff',
  fontColor : '000',
  topPosition : '',
  infoHeight: 20,
  alternative_layout : false,
  imageArray : [],
  imageNum : null,
  total : 0,
  activeImage : null,
  inprogress : false,
  disableResize : false,
  disableZoom : false,
  isZoomedIn : false,
  rtl : false,
  loopItems : false,
  keysClose : ['c', 'x', 27],
  keysPrevious : ['p', 37],
  keysNext : ['n', 39],
  keysZoom : ['z'],
  keysPlayPause : [32],

  // Slideshow options.
  slideInterval : 5000, // In milliseconds.
  showPlayPause : true,
  autoStart : true,
  autoExit : true,
  pauseOnNextClick : false, // True to pause the slideshow when the "Next" button is clicked.
  pauseOnPrevClick : true, // True to pause the slideshow when the "Prev" button is clicked.
  slideIdArray : [],
  slideIdCount : 0,
  isSlideshow : false,
  isPaused : false,
  loopSlides : false,

  // Iframe options.
  isLightframe : false,
  iframe_width : 600,
  iframe_height : 400,
  iframe_border : 1,

  // Video and modal options.
  enableVideo : false,
  flvPlayer : '/flvplayer.swf',
  flvFlashvars : '',
  isModal : false,
  isVideo : false,
  videoId : false,
  modalWidth : 400,
  modalHeight : 400,
  modalHTML : null,


  // initialize()
  // Constructor runs on completion of the DOM loading.
  // The function inserts html at the bottom of the page which is used
  // to display the shadow overlay and the image container.
  initialize: function() {

    var s = Drupal.settings.lightbox2;
    Lightbox.overlayOpacity = s.overlay_opacity;
    Lightbox.overlayColor = s.overlay_color;
    Lightbox.disableCloseClick = s.disable_close_click;
    Lightbox.resizeSequence = s.resize_sequence;
    Lightbox.resizeSpeed = s.resize_speed;
    Lightbox.fadeInSpeed = s.fade_in_speed;
    Lightbox.slideDownSpeed = s.slide_down_speed;
    Lightbox.borderSize = s.border_size;
    Lightbox.boxColor = s.box_color;
    Lightbox.fontColor = s.font_color;
    Lightbox.topPosition = s.top_position;
    Lightbox.rtl = s.rtl;
    Lightbox.loopItems = s.loop_items;
    Lightbox.keysClose = s.keys_close.split(" ");
    Lightbox.keysPrevious = s.keys_previous.split(" ");
    Lightbox.keysNext = s.keys_next.split(" ");
    Lightbox.keysZoom = s.keys_zoom.split(" ");
    Lightbox.keysPlayPause = s.keys_play_pause.split(" ");
    Lightbox.disableResize = s.disable_resize;
    Lightbox.disableZoom = s.disable_zoom;
    Lightbox.slideInterval = s.slideshow_interval;
    Lightbox.showPlayPause = s.show_play_pause;
    Lightbox.showCaption = s.show_caption;
    Lightbox.autoStart = s.slideshow_automatic_start;
    Lightbox.autoExit = s.slideshow_automatic_exit;
    Lightbox.pauseOnNextClick = s.pause_on_next_click;
    Lightbox.pauseOnPrevClick = s.pause_on_previous_click;
    Lightbox.loopSlides = s.loop_slides;
    Lightbox.alternative_layout = s.use_alt_layout;
    Lightbox.iframe_width = s.iframe_width;
    Lightbox.iframe_height = s.iframe_height;
    Lightbox.iframe_border = s.iframe_border;
    Lightbox.enableVideo = s.enable_video;
    if (s.enable_video) {
      Lightbox.flvPlayer = s.flvPlayer;
      Lightbox.flvFlashvars = s.flvFlashvars;
    }

    // Make the lightbox divs.
    var layout_class = (s.use_alt_layout ? 'lightbox2-alt-layout' : 'lightbox2-orig-layout');
    var output = '<div id="lightbox2-overlay" style="display: none;"></div>\
      <div id="lightbox" style="display: none;" class="' + layout_class + '">\
        <div id="outerImageContainer"></div>\
        <div id="imageDataContainer" class="clearfix">\
          <div id="imageData"></div>\
        </div>\
      </div>';
    var loading = '<div id="loading"><a href="#" id="loadingLink"></a></div>';
    var modal = '<div id="modalContainer" style="display: none;"></div>';
    var frame = '<div id="frameContainer" style="display: none;"></div>';
    var imageContainer = '<div id="imageContainer" style="display: none;"></div>';
    var details = '<div id="imageDetails"></div>';
    var bottomNav = '<div id="bottomNav"></div>';
    var image = '<img id="lightboxImage" alt="" />';
    var hoverNav = '<div id="hoverNav"><a id="prevLink" href="#"></a><a id="nextLink" href="#"></a></div>';
    var frameNav = '<div id="frameHoverNav"><a id="framePrevLink" href="#"></a><a id="frameNextLink" href="#"></a></div>';
    var hoverNav = '<div id="hoverNav"><a id="prevLink" title="' + Drupal.t('Previous') + '" href="#"></a><a id="nextLink" title="' + Drupal.t('Next') + '" href="#"></a></div>';
    var frameNav = '<div id="frameHoverNav"><a id="framePrevLink" title="' + Drupal.t('Previous') + '" href="#"></a><a id="frameNextLink" title="' + Drupal.t('Next') + '" href="#"></a></div>';
    var caption = '<span id="caption"></span>';
    var numberDisplay = '<span id="numberDisplay"></span>';
    var close = '<a id="bottomNavClose" title="' + Drupal.t('Close') + '" href="#"></a>';
    var zoom = '<a id="bottomNavZoom" href="#"></a>';
    var zoomOut = '<a id="bottomNavZoomOut" href="#"></a>';
    var pause = '<a id="lightshowPause" title="' + Drupal.t('Pause Slideshow') + '" href="#" style="display: none;"></a>';
    var play = '<a id="lightshowPlay" title="' + Drupal.t('Play Slideshow') + '" href="#" style="display: none;"></a>';

    $("body").append(output);
    $('#outerImageContainer').append(modal + frame + imageContainer + loading);
    if (!s.use_alt_layout) {
      $('#imageContainer').append(image + hoverNav);
      $('#imageData').append(details + bottomNav);
      $('#imageDetails').append(caption + numberDisplay);
      $('#bottomNav').append(frameNav + close + zoom + zoomOut + pause + play);
    }
    else {
      $('#outerImageContainer').append(bottomNav);
      $('#imageContainer').append(image);
      $('#bottomNav').append(close + zoom + zoomOut);
      $('#imageData').append(hoverNav + details);
      $('#imageDetails').append(caption + numberDisplay + pause + play);
    }

    // Setup onclick handlers.
    if (Lightbox.disableCloseClick) {
      $('#lightbox2-overlay').click(function() { Lightbox.end(); return false; } ).hide();
    }
    $('#loadingLink, #bottomNavClose').click(function() { Lightbox.end('forceClose'); return false; } );
    $('#prevLink, #framePrevLink').click(function() { Lightbox.changeData(Lightbox.activeImage - 1); return false; } );
    $('#nextLink, #frameNextLink').click(function() { Lightbox.changeData(Lightbox.activeImage + 1); return false; } );
    $('#bottomNavZoom').click(function() { Lightbox.changeData(Lightbox.activeImage, true); return false; } );
    $('#bottomNavZoomOut').click(function() { Lightbox.changeData(Lightbox.activeImage, false); return false; } );
    $('#lightshowPause').click(function() { Lightbox.togglePlayPause("lightshowPause", "lightshowPlay"); return false; } );
    $('#lightshowPlay').click(function() { Lightbox.togglePlayPause("lightshowPlay", "lightshowPause"); return false; } );

    // Fix positioning.
    $('#prevLink, #nextLink, #framePrevLink, #frameNextLink').css({ 'paddingTop': Lightbox.borderSize + 'px'});
    $('#imageContainer, #frameContainer, #modalContainer').css({ 'padding': Lightbox.borderSize + 'px'});
    $('#outerImageContainer, #imageDataContainer, #bottomNavClose').css({'backgroundColor': '#' + Lightbox.boxColor, 'color': '#'+Lightbox.fontColor});
    if (Lightbox.alternative_layout) {
      $('#bottomNavZoom, #bottomNavZoomOut').css({'bottom': Lightbox.borderSize + 'px', 'right': Lightbox.borderSize + 'px'});
    }
    else if (Lightbox.rtl == 1 && $.browser.msie) {
      $('#bottomNavZoom, #bottomNavZoomOut').css({'left': '0px'});
    }

    // Force navigation links to always be displayed
    if (s.force_show_nav) {
      $('#prevLink, #nextLink').addClass("force_show_nav");
    }

  },

  // initList()
  // Loops through anchor tags looking for 'lightbox', 'lightshow' and
  // 'lightframe', etc, references and applies onclick events to appropriate
  // links. You can rerun after dynamically adding images w/ajax.
  initList : function(context) {

    if (context == undefined || context == null) {
      context = document;
    }

    // Attach lightbox to any links with rel 'lightbox', 'lightshow' or
    // 'lightframe', etc.
    $("a[rel^='lightbox']:not(.lightbox-processed), area[rel^='lightbox']:not(.lightbox-processed)", context).addClass('lightbox-processed').click(function(e) {
      if (Lightbox.disableCloseClick) {
        $('#lightbox').unbind('click');
        $('#lightbox').click(function() { Lightbox.end('forceClose'); } );
      }
      Lightbox.start(this, false, false, false, false);
      if (e.preventDefault) { e.preventDefault(); }
      return false;
    });
    $("a[rel^='lightshow']:not(.lightbox-processed), area[rel^='lightshow']:not(.lightbox-processed)", context).addClass('lightbox-processed').click(function(e) {
      if (Lightbox.disableCloseClick) {
        $('#lightbox').unbind('click');
        $('#lightbox').click(function() { Lightbox.end('forceClose'); } );
      }
      Lightbox.start(this, true, false, false, false);
      if (e.preventDefault) { e.preventDefault(); }
      return false;
    });
    $("a[rel^='lightframe']:not(.lightbox-processed), area[rel^='lightframe']:not(.lightbox-processed)", context).addClass('lightbox-processed').click(function(e) {
      if (Lightbox.disableCloseClick) {
        $('#lightbox').unbind('click');
        $('#lightbox').click(function() { Lightbox.end('forceClose'); } );
      }
      Lightbox.start(this, false, true, false, false);
      if (e.preventDefault) { e.preventDefault(); }
      return false;
    });
    if (Lightbox.enableVideo) {
      $("a[rel^='lightvideo']:not(.lightbox-processed), area[rel^='lightvideo']:not(.lightbox-processed)", context).addClass('lightbox-processed').click(function(e) {
        if (Lightbox.disableCloseClick) {
          $('#lightbox').unbind('click');
          $('#lightbox').click(function() { Lightbox.end('forceClose'); } );
        }
        Lightbox.start(this, false, false, true, false);
        if (e.preventDefault) { e.preventDefault(); }
        return false;
      });
    }
    $("a[rel^='lightmodal']:not(.lightbox-processed), area[rel^='lightmodal']:not(.lightbox-processed)", context).addClass('lightbox-processed').click(function(e) {
      $('#lightbox').unbind('click');
      // Add classes from the link to the lightbox div - don't include lightbox-processed
      $('#lightbox').addClass($(this).attr('class'));
      $('#lightbox').removeClass('lightbox-processed');
      Lightbox.start(this, false, false, false, true);
      if (e.preventDefault) { e.preventDefault(); }
      return false;
    });
    $("#lightboxAutoModal:not(.lightbox-processed)", context).addClass('lightbox-processed').click(function(e) {
      Lightbox.auto_modal = true;
      $('#lightbox').unbind('click');
      Lightbox.start(this, false, false, false, true);
      if (e.preventDefault) { e.preventDefault(); }
      return false;
    });
  },

  // start()
  // Display overlay and lightbox. If image is part of a set, add siblings to
  // imageArray.
  start: function(imageLink, slideshow, lightframe, lightvideo, lightmodal) {

    Lightbox.isPaused = !Lightbox.autoStart;

    // Replaces hideSelectBoxes() and hideFlash() calls in original lightbox2.
    Lightbox.toggleSelectsFlash('hide');

    // Stretch overlay to fill page and fade in.
    var arrayPageSize = Lightbox.getPageSize();
    $("#lightbox2-overlay").hide().css({
      'width': '100%',
      'zIndex': '10090',
      'height': arrayPageSize[1] + 'px',
      'backgroundColor' : '#' + Lightbox.overlayColor
    });
    // Detect OS X FF2 opacity + flash issue.
    if (lightvideo && this.detectMacFF2()) {
      $("#lightbox2-overlay").removeClass("overlay_default");
      $("#lightbox2-overlay").addClass("overlay_macff2");
      $("#lightbox2-overlay").css({'opacity' : null});
    }
    else {
      $("#lightbox2-overlay").removeClass("overlay_macff2");
      $("#lightbox2-overlay").addClass("overlay_default");
      $("#lightbox2-overlay").css({'opacity' : Lightbox.overlayOpacity});
    }
    $("#lightbox2-overlay").fadeIn(Lightbox.fadeInSpeed);


    Lightbox.isSlideshow = slideshow;
    Lightbox.isLightframe = lightframe;
    Lightbox.isVideo = lightvideo;
    Lightbox.isModal = lightmodal;
    Lightbox.imageArray = [];
    Lightbox.imageNum = 0;

    var anchors = $(imageLink.tagName);
    var anchor = null;
    var rel_parts = Lightbox.parseRel(imageLink);
    var rel = rel_parts["rel"];
    var rel_group = rel_parts["group"];
    var title = (rel_parts["title"] ? rel_parts["title"] : imageLink.title);
    var rel_style = null;
    var i = 0;

    if (rel_parts["flashvars"]) {
      Lightbox.flvFlashvars = Lightbox.flvFlashvars + '&' + rel_parts["flashvars"];
    }

    // Set the title for image alternative text.
    var alt = imageLink.title;
    if (!alt) {
      var img = $(imageLink).find("img");
      if (img && $(img).attr("alt")) {
        alt = $(img).attr("alt");
      }
      else {
        alt = title;
      }
    }

    if ($(imageLink).attr('id') == 'lightboxAutoModal') {
      rel_style = rel_parts["style"];
      Lightbox.imageArray.push(['#lightboxAutoModal > *', title, alt, rel_style, 1]);
    }
    else {
      // Handle lightbox images with no grouping.
      if ((rel == 'lightbox' || rel == 'lightshow') && !rel_group) {
        Lightbox.imageArray.push([imageLink.href, title, alt]);
      }

      // Handle other items with no grouping.
      else if (!rel_group) {
        rel_style = rel_parts["style"];
        Lightbox.imageArray.push([imageLink.href, title, alt, rel_style]);
      }

      // Handle grouped items.
      else {

        // Loop through anchors and add them to imageArray.
        for (i = 0; i < anchors.length; i++) {
          anchor = anchors[i];
          if (typeof(anchor.href) == "string" && $(anchor).attr('rel')) {
            var rel_data = Lightbox.parseRel(anchor);
            var anchor_title = (rel_data["title"] ? rel_data["title"] : anchor.title);
            img_alt = anchor.title;
            if (!img_alt) {
              var anchor_img = $(anchor).find("img");
              if (anchor_img && $(anchor_img).attr("alt")) {
                img_alt = $(anchor_img).attr("alt");
              }
              else {
                img_alt = title;
              }
            }
            if (rel_data["rel"] == rel) {
              if (rel_data["group"] == rel_group) {
                if (Lightbox.isLightframe || Lightbox.isModal || Lightbox.isVideo) {
                  rel_style = rel_data["style"];
                }
                Lightbox.imageArray.push([anchor.href, anchor_title, img_alt, rel_style]);
              }
            }
          }
        }

        // Remove duplicates.
        for (i = 0; i < Lightbox.imageArray.length; i++) {
          for (j = Lightbox.imageArray.length-1; j > i; j--) {
            if (Lightbox.imageArray[i][0] == Lightbox.imageArray[j][0]) {
              Lightbox.imageArray.splice(j,1);
            }
          }
        }
        while (Lightbox.imageArray[Lightbox.imageNum][0] != imageLink.href) {
          Lightbox.imageNum++;
        }
      }
    }

    if (Lightbox.isSlideshow && Lightbox.showPlayPause && Lightbox.isPaused) {
      $('#lightshowPlay').show();
      $('#lightshowPause').hide();
    }

    // Calculate top and left offset for the lightbox.
    var arrayPageScroll = Lightbox.getPageScroll();
    var lightboxTop = arrayPageScroll[1] + (Lightbox.topPosition == '' ? (arrayPageSize[3] / 10) : Lightbox.topPosition) * 1;
    var lightboxLeft = arrayPageScroll[0];
    $('#frameContainer, #modalContainer, #lightboxImage').hide();
    $('#hoverNav, #prevLink, #nextLink, #frameHoverNav, #framePrevLink, #frameNextLink').hide();
    $('#imageDataContainer, #numberDisplay, #bottomNavZoom, #bottomNavZoomOut').hide();
    $('#outerImageContainer').css({'width': '250px', 'height': '250px'});
    $('#lightbox').css({
      'zIndex': '10500',
      'top': lightboxTop + 'px',
      'left': lightboxLeft + 'px'
    }).show();

    Lightbox.total = Lightbox.imageArray.length;
    Lightbox.changeData(Lightbox.imageNum);
  },

  // changeData()
  // Hide most elements and preload image in preparation for resizing image
  // container.
  changeData: function(imageNum, zoomIn) {

    if (Lightbox.inprogress === false) {
      if (Lightbox.total > 1 && ((Lightbox.isSlideshow && Lightbox.loopSlides) || (!Lightbox.isSlideshow && Lightbox.loopItems))) {
        if (imageNum >= Lightbox.total) imageNum = 0;
        if (imageNum < 0) imageNum = Lightbox.total - 1;
      }

      if (Lightbox.isSlideshow) {
        for (var i = 0; i < Lightbox.slideIdCount; i++) {
          window.clearTimeout(Lightbox.slideIdArray[i]);
        }
      }
      Lightbox.inprogress = true;
      Lightbox.activeImage = imageNum;

      if (Lightbox.disableResize && !Lightbox.isSlideshow) {
        zoomIn = true;
      }
      Lightbox.isZoomedIn = zoomIn;


      // Hide elements during transition.
      $('#loading').css({'zIndex': '10500'}).show();
      if (!Lightbox.alternative_layout) {
        $('#imageContainer').hide();
      }
      $('#frameContainer, #modalContainer, #lightboxImage').hide();
      $('#hoverNav, #prevLink, #nextLink, #frameHoverNav, #framePrevLink, #frameNextLink').hide();
      $('#imageDataContainer, #numberDisplay, #bottomNavZoom, #bottomNavZoomOut').hide();

      // Preload image content, but not iframe pages.
      if (!Lightbox.isLightframe && !Lightbox.isVideo && !Lightbox.isModal) {
        $("#lightbox #imageDataContainer").removeClass('lightbox2-alt-layout-data');
        imgPreloader = new Image();
        imgPreloader.onerror = function() { Lightbox.imgNodeLoadingError(this); };

        imgPreloader.onload = function() {
          var photo = document.getElementById('lightboxImage');
          photo.src = Lightbox.imageArray[Lightbox.activeImage][0];
          photo.alt = Lightbox.imageArray[Lightbox.activeImage][2];

          var imageWidth = imgPreloader.width;
          var imageHeight = imgPreloader.height;

          // Resize code.
          var arrayPageSize = Lightbox.getPageSize();
          var targ = { w:arrayPageSize[2] - (Lightbox.borderSize * 2), h:arrayPageSize[3] - (Lightbox.borderSize * 6) - (Lightbox.infoHeight * 4) - (arrayPageSize[3] / 10) };
          var orig = { w:imgPreloader.width, h:imgPreloader.height };

          // Image is very large, so show a smaller version of the larger image
          // with zoom button.
          if (zoomIn !== true) {
            var ratio = 1.0; // Shrink image with the same aspect.
            $('#bottomNavZoomOut, #bottomNavZoom').hide();
            if ((orig.w >= targ.w || orig.h >= targ.h) && orig.h && orig.w) {
              ratio = ((targ.w / orig.w) < (targ.h / orig.h)) ? targ.w / orig.w : targ.h / orig.h;
              if (!Lightbox.disableZoom && !Lightbox.isSlideshow) {
                $('#bottomNavZoom').css({'zIndex': '10500'}).show();
              }
            }

            imageWidth  = Math.floor(orig.w * ratio);
            imageHeight = Math.floor(orig.h * ratio);
          }

          else {
            $('#bottomNavZoom').hide();
            // Only display zoom out button if the image is zoomed in already.
            if ((orig.w >= targ.w || orig.h >= targ.h) && orig.h && orig.w) {
              // Only display zoom out button if not a slideshow and if the
              // buttons aren't disabled.
              if (!Lightbox.disableResize && Lightbox.isSlideshow === false && !Lightbox.disableZoom) {
                $('#bottomNavZoomOut').css({'zIndex': '10500'}).show();
              }
            }
          }

          photo.style.width = (imageWidth) + 'px';
          photo.style.height = (imageHeight) + 'px';
          Lightbox.resizeContainer(imageWidth, imageHeight);

          // Clear onLoad, IE behaves irratically with animated gifs otherwise.
          imgPreloader.onload = function() {};
        };

        imgPreloader.src = Lightbox.imageArray[Lightbox.activeImage][0];
        imgPreloader.alt = Lightbox.imageArray[Lightbox.activeImage][2];
      }

      // Set up frame size, etc.
      else if (Lightbox.isLightframe) {
        $("#lightbox #imageDataContainer").addClass('lightbox2-alt-layout-data');
        var src = Lightbox.imageArray[Lightbox.activeImage][0];
        $('#frameContainer').html('<iframe id="lightboxFrame" style="display: none;" src="'+src+'"></iframe>');

        // Enable swf support in Gecko browsers.
        if ($.browser.mozilla && src.indexOf('.swf') != -1) {
          setTimeout(function () {
            document.getElementById("lightboxFrame").src = Lightbox.imageArray[Lightbox.activeImage][0];
          }, 1000);
        }

        if (!Lightbox.iframe_border) {
          $('#lightboxFrame').css({'border': 'none'});
          $('#lightboxFrame').attr('frameborder', '0');
        }
        var iframe = document.getElementById('lightboxFrame');
        var iframeStyles = Lightbox.imageArray[Lightbox.activeImage][3];
        iframe = Lightbox.setStyles(iframe, iframeStyles);
        Lightbox.resizeContainer(parseInt(iframe.width, 10), parseInt(iframe.height, 10));
      }
      else if (Lightbox.isVideo || Lightbox.isModal) {
        $("#lightbox #imageDataContainer").addClass('lightbox2-alt-layout-data');
        var container = document.getElementById('modalContainer');
        var modalStyles = Lightbox.imageArray[Lightbox.activeImage][3];
        container = Lightbox.setStyles(container, modalStyles);
        if (Lightbox.isVideo) {
          Lightbox.modalHeight =  parseInt(container.height, 10) - 10;
          Lightbox.modalWidth =  parseInt(container.width, 10) - 10;
          Lightvideo.startVideo(Lightbox.imageArray[Lightbox.activeImage][0]);
        }
        Lightbox.resizeContainer(parseInt(container.width, 10), parseInt(container.height, 10));
      }
    }
  },

  // imgNodeLoadingError()
  imgNodeLoadingError: function(image) {
    var s = Drupal.settings.lightbox2;
    var original_image = Lightbox.imageArray[Lightbox.activeImage][0];
    if (s.display_image_size !== "") {
      original_image = original_image.replace(new RegExp("."+s.display_image_size), "");
    }
    Lightbox.imageArray[Lightbox.activeImage][0] = original_image;
    image.onerror = function() { Lightbox.imgLoadingError(image); };
    image.src = original_image;
  },

  // imgLoadingError()
  imgLoadingError: function(image) {
    var s = Drupal.settings.lightbox2;
    Lightbox.imageArray[Lightbox.activeImage][0] = s.default_image;
    image.src = s.default_image;
  },

  // resizeContainer()
  resizeContainer: function(imgWidth, imgHeight) {

    imgWidth = (imgWidth < Lightbox.minWidth ? Lightbox.minWidth : imgWidth);

    this.widthCurrent = $('#outerImageContainer').width();
    this.heightCurrent = $('#outerImageContainer').height();

    var widthNew = (imgWidth  + (Lightbox.borderSize * 2));
    var heightNew = (imgHeight  + (Lightbox.borderSize * 2));

    // Scalars based on change from old to new.
    this.xScale = ( widthNew / this.widthCurrent) * 100;
    this.yScale = ( heightNew / this.heightCurrent) * 100;

    // Calculate size difference between new and old image, and resize if
    // necessary.
    wDiff = this.widthCurrent - widthNew;
    hDiff = this.heightCurrent - heightNew;

    $('#modalContainer').css({'width': imgWidth, 'height': imgHeight});
    // Detect animation sequence.
    if (Lightbox.resizeSequence) {
      var animate1 = {width: widthNew};
      var animate2 = {height: heightNew};
      if (Lightbox.resizeSequence == 2) {
        animate1 = {height: heightNew};
        animate2 = {width: widthNew};
      }
      $('#outerImageContainer').animate(animate1, Lightbox.resizeSpeed).animate(animate2, Lightbox.resizeSpeed, 'linear', function() { Lightbox.showData(); });
    }
    // Simultaneous.
    else {
      $('#outerImageContainer').animate({'width': widthNew, 'height': heightNew}, Lightbox.resizeSpeed, 'linear', function() { Lightbox.showData(); });
    }

    // If new and old image are same size and no scaling transition is necessary
    // do a quick pause to prevent image flicker.
    if ((hDiff === 0) && (wDiff === 0)) {
      if ($.browser.msie) {
        Lightbox.pause(250);
      }
      else {
        Lightbox.pause(100);
      }
    }

    var s = Drupal.settings.lightbox2;
    if (!s.use_alt_layout) {
      $('#prevLink, #nextLink').css({'height': imgHeight + 'px'});
    }
    $('#imageDataContainer').css({'width': widthNew + 'px'});
  },

  // showData()
  // Display image and begin preloading neighbors.
  showData: function() {
    $('#loading').hide();

    if (Lightbox.isLightframe || Lightbox.isVideo || Lightbox.isModal) {
      Lightbox.updateDetails();
      if (Lightbox.isLightframe) {
        $('#frameContainer').show();
        if ($.browser.safari || Lightbox.fadeInSpeed === 0) {
          $('#lightboxFrame').css({'zIndex': '10500'}).show();
        }
        else {
          $('#lightboxFrame').css({'zIndex': '10500'}).fadeIn(Lightbox.fadeInSpeed);
        }
      }
      else {
        if (Lightbox.isVideo) {
          $("#modalContainer").html(Lightbox.modalHTML).click(function(){return false;}).css('zIndex', '10500').show();
        }
        else {
          var src = unescape(Lightbox.imageArray[Lightbox.activeImage][0]);
          if (Lightbox.imageArray[Lightbox.activeImage][4]) {
            $(src).appendTo("#modalContainer");
            $('#modalContainer').css({'zIndex': '10500'}).show();
          }
          else {
            // Use a callback to show the new image, otherwise you get flicker.
            $("#modalContainer").hide().load(src, function () {$('#modalContainer').css({'zIndex': '10500'}).show();});
          }
          $('#modalContainer').unbind('click');
        }
        // This might be needed in the Lightframe section above.
        //$('#modalContainer').css({'zIndex': '10500'}).show();
      }
    }

    // Handle display of image content.
    else {
      $('#imageContainer').show();
      if ($.browser.safari || Lightbox.fadeInSpeed === 0) {
        $('#lightboxImage').css({'zIndex': '10500'}).show();
      }
      else {
        $('#lightboxImage').css({'zIndex': '10500'}).fadeIn(Lightbox.fadeInSpeed);
      }
      Lightbox.updateDetails();
      this.preloadNeighborImages();
    }
    Lightbox.inprogress = false;

    // Slideshow specific stuff.
    if (Lightbox.isSlideshow) {
      if (!Lightbox.loopSlides && Lightbox.activeImage == (Lightbox.total - 1)) {
        if (Lightbox.autoExit) {
          Lightbox.slideIdArray[Lightbox.slideIdCount++] = setTimeout(function () {Lightbox.end('slideshow');}, Lightbox.slideInterval);
        }
      }
      else {
        if (!Lightbox.isPaused && Lightbox.total > 1) {
          Lightbox.slideIdArray[Lightbox.slideIdCount++] = setTimeout(function () {Lightbox.changeData(Lightbox.activeImage + 1);}, Lightbox.slideInterval);
        }
      }
      if (Lightbox.showPlayPause && Lightbox.total > 1 && !Lightbox.isPaused) {
        $('#lightshowPause').show();
        $('#lightshowPlay').hide();
      }
      else if (Lightbox.showPlayPause && Lightbox.total > 1) {
        $('#lightshowPause').hide();
        $('#lightshowPlay').show();
      }
    }

    // Adjust the page overlay size.
    var arrayPageSize = Lightbox.getPageSize();
    var arrayPageScroll = Lightbox.getPageScroll();
    var pageHeight = arrayPageSize[1];
    if (Lightbox.isZoomedIn && arrayPageSize[1] > arrayPageSize[3]) {
      var lightboxTop = (Lightbox.topPosition == '' ? (arrayPageSize[3] / 10) : Lightbox.topPosition) * 1;
      pageHeight = pageHeight + arrayPageScroll[1] + lightboxTop;
    }
    $('#lightbox2-overlay').css({'height': pageHeight + 'px', 'width': arrayPageSize[0] + 'px'});

    // Gecko browsers (e.g. Firefox, SeaMonkey, etc) don't handle pdfs as
    // expected.
    if ($.browser.mozilla) {
      if (Lightbox.imageArray[Lightbox.activeImage][0].indexOf(".pdf") != -1) {
        setTimeout(function () {
          document.getElementById("lightboxFrame").src = Lightbox.imageArray[Lightbox.activeImage][0];
        }, 1000);
      }
    }
  },

  // updateDetails()
  // Display caption, image number, and bottom nav.
  updateDetails: function() {

    $("#imageDataContainer").hide();

    var s = Drupal.settings.lightbox2;

    if (s.show_caption) {
      var caption = Lightbox.filterXSS(Lightbox.imageArray[Lightbox.activeImage][1]);
      if (!caption) caption = '';
      $('#caption').html(caption).css({'zIndex': '10500'}).show();
    }

    // If image is part of set display 'Image x of x'.
    var numberDisplay = null;
    if (s.image_count && Lightbox.total > 1) {
      var currentImage = Lightbox.activeImage + 1;
      if (!Lightbox.isLightframe && !Lightbox.isModal && !Lightbox.isVideo) {
        numberDisplay = s.image_count.replace(/\!current/, currentImage).replace(/\!total/, Lightbox.total);
      }
      else if (Lightbox.isVideo) {
        numberDisplay = s.video_count.replace(/\!current/, currentImage).replace(/\!total/, Lightbox.total);
      }
      else {
        numberDisplay = s.page_count.replace(/\!current/, currentImage).replace(/\!total/, Lightbox.total);
      }
      $('#numberDisplay').html(numberDisplay).css({'zIndex': '10500'}).show();
    }
    else {
      $('#numberDisplay').hide();
    }

    $("#imageDataContainer").hide().slideDown(Lightbox.slideDownSpeed, function() {
      $("#bottomNav").show();
    });
    if (Lightbox.rtl == 1) {
      $("#bottomNav").css({'float': 'left'});
    }
    Lightbox.updateNav();
  },

  // updateNav()
  // Display appropriate previous and next hover navigation.
  updateNav: function() {

    $('#hoverNav').css({'zIndex': '10500'}).show();
    var prevLink = '#prevLink';
    var nextLink = '#nextLink';

    // Slideshow is separated as we need to show play / pause button.
    if (Lightbox.isSlideshow) {
      if ((Lightbox.total > 1 && Lightbox.loopSlides) || Lightbox.activeImage !== 0) {
        $(prevLink).css({'zIndex': '10500'}).show().click(function() {
          if (Lightbox.pauseOnPrevClick) {
            Lightbox.togglePlayPause("lightshowPause", "lightshowPlay");
          }
          Lightbox.changeData(Lightbox.activeImage - 1); return false;
        });
      }
      else {
        $(prevLink).hide();
      }

      // If not last image in set, display next image button.
      if ((Lightbox.total > 1 && Lightbox.loopSlides) || Lightbox.activeImage != (Lightbox.total - 1)) {
        $(nextLink).css({'zIndex': '10500'}).show().click(function() {
          if (Lightbox.pauseOnNextClick) {
            Lightbox.togglePlayPause("lightshowPause", "lightshowPlay");
          }
          Lightbox.changeData(Lightbox.activeImage + 1); return false;
        });
      }
      // Safari browsers need to have hide() called again.
      else {
        $(nextLink).hide();
      }
    }

    // All other types of content.
    else {

      if ((Lightbox.isLightframe || Lightbox.isModal || Lightbox.isVideo) && !Lightbox.alternative_layout) {
        $('#frameHoverNav').css({'zIndex': '10500'}).show();
        $('#hoverNav').css({'zIndex': '10500'}).hide();
        prevLink = '#framePrevLink';
        nextLink = '#frameNextLink';
      }

      // If not first image in set, display prev image button.
      if ((Lightbox.total > 1 && Lightbox.loopItems) || Lightbox.activeImage !== 0) {
        // Unbind any other click handlers, otherwise this adds a new click handler
        // each time the arrow is clicked.
        $(prevLink).css({'zIndex': '10500'}).show().unbind().click(function() {
          Lightbox.changeData(Lightbox.activeImage - 1); return false;
        });
      }
      // Safari browsers need to have hide() called again.
      else {
        $(prevLink).hide();
      }

      // If not last image in set, display next image button.
      if ((Lightbox.total > 1 && Lightbox.loopItems) || Lightbox.activeImage != (Lightbox.total - 1)) {
        // Unbind any other click handlers, otherwise this adds a new click handler
        // each time the arrow is clicked.
        $(nextLink).css({'zIndex': '10500'}).show().unbind().click(function() {
          Lightbox.changeData(Lightbox.activeImage + 1); return false;
        });
      }
      // Safari browsers need to have hide() called again.
      else {
        $(nextLink).hide();
      }
    }

    // Don't enable keyboard shortcuts so forms will work.
    if (!Lightbox.isModal) {
      this.enableKeyboardNav();
    }
  },


  // enableKeyboardNav()
  enableKeyboardNav: function() {
    $(document).bind("keydown", this.keyboardAction);
  },

  // disableKeyboardNav()
  disableKeyboardNav: function() {
    $(document).unbind("keydown", this.keyboardAction);
  },

  // keyboardAction()
  keyboardAction: function(e) {
    if (e === null) { // IE.
      keycode = event.keyCode;
      escapeKey = 27;
    }
    else { // Mozilla.
      keycode = e.keyCode;
      escapeKey = e.DOM_VK_ESCAPE;
    }

    key = String.fromCharCode(keycode).toLowerCase();

    // Close lightbox.
    if (Lightbox.checkKey(Lightbox.keysClose, key, keycode)) {
      Lightbox.end('forceClose');
    }
    // Display previous image (p, <-).
    else if (Lightbox.checkKey(Lightbox.keysPrevious, key, keycode)) {
      if ((Lightbox.total > 1 && ((Lightbox.isSlideshow && Lightbox.loopSlides) || (!Lightbox.isSlideshow && Lightbox.loopItems))) || Lightbox.activeImage !== 0) {
        Lightbox.changeData(Lightbox.activeImage - 1);
      }

    }
    // Display next image (n, ->).
    else if (Lightbox.checkKey(Lightbox.keysNext, key, keycode)) {
      if ((Lightbox.total > 1 && ((Lightbox.isSlideshow && Lightbox.loopSlides) || (!Lightbox.isSlideshow && Lightbox.loopItems))) || Lightbox.activeImage != (Lightbox.total - 1)) {
        Lightbox.changeData(Lightbox.activeImage + 1);
      }
    }
    // Zoom in.
    else if (Lightbox.checkKey(Lightbox.keysZoom, key, keycode) && !Lightbox.disableResize && !Lightbox.disableZoom && !Lightbox.isSlideshow && !Lightbox.isLightframe) {
      if (Lightbox.isZoomedIn) {
        Lightbox.changeData(Lightbox.activeImage, false);
      }
      else if (!Lightbox.isZoomedIn) {
        Lightbox.changeData(Lightbox.activeImage, true);
      }
      return false;
    }
    // Toggle play / pause (space).
    else if (Lightbox.checkKey(Lightbox.keysPlayPause, key, keycode) && Lightbox.isSlideshow) {

      if (Lightbox.isPaused) {
        Lightbox.togglePlayPause("lightshowPlay", "lightshowPause");
      }
      else {
        Lightbox.togglePlayPause("lightshowPause", "lightshowPlay");
      }
      return false;
    }
  },

  preloadNeighborImages: function() {

    if ((Lightbox.total - 1) > Lightbox.activeImage) {
      preloadNextImage = new Image();
      preloadNextImage.src = Lightbox.imageArray[Lightbox.activeImage + 1][0];
    }
    if (Lightbox.activeImage > 0) {
      preloadPrevImage = new Image();
      preloadPrevImage.src = Lightbox.imageArray[Lightbox.activeImage - 1][0];
    }

  },

  end: function(caller) {
    var closeClick = (caller == 'slideshow' ? false : true);
    if (Lightbox.isSlideshow && Lightbox.isPaused && !closeClick) {
      return;
    }
    // To prevent double clicks on navigation links.
    if (Lightbox.inprogress === true && caller != 'forceClose') {
      return;
    }
    Lightbox.disableKeyboardNav();
    $('#lightbox').hide();
    $("#lightbox2-overlay").fadeOut();
    Lightbox.isPaused = true;
    Lightbox.inprogress = false;
    // Replaces calls to showSelectBoxes() and showFlash() in original
    // lightbox2.
    Lightbox.toggleSelectsFlash('visible');
    if (Lightbox.isSlideshow) {
      for (var i = 0; i < Lightbox.slideIdCount; i++) {
        window.clearTimeout(Lightbox.slideIdArray[i]);
      }
      $('#lightshowPause, #lightshowPlay').hide();
    }
    else if (Lightbox.isLightframe) {
      $('#frameContainer').empty().hide();
    }
    else if (Lightbox.isVideo || Lightbox.isModal) {
      if (!Lightbox.auto_modal) {
        $('#modalContainer').hide().html("");
      }
      Lightbox.auto_modal = false;
    }
  },


  // getPageScroll()
  // Returns array with x,y page scroll values.
  // Core code from - quirksmode.com.
  getPageScroll : function() {

    var xScroll, yScroll;

    if (self.pageYOffset || self.pageXOffset) {
      yScroll = self.pageYOffset;
      xScroll = self.pageXOffset;
    }
    else if (document.documentElement && (document.documentElement.scrollTop || document.documentElement.scrollLeft)) {  // Explorer 6 Strict.
      yScroll = document.documentElement.scrollTop;
      xScroll = document.documentElement.scrollLeft;
    }
    else if (document.body) {// All other Explorers.
      yScroll = document.body.scrollTop;
      xScroll = document.body.scrollLeft;
    }

    arrayPageScroll = [xScroll,yScroll];
    return arrayPageScroll;
  },

  // getPageSize()
  // Returns array with page width, height and window width, height.
  // Core code from - quirksmode.com.
  // Edit for Firefox by pHaez.

  getPageSize : function() {

    var xScroll, yScroll;

    if (window.innerHeight && window.scrollMaxY) {
      xScroll = window.innerWidth + window.scrollMaxX;
      yScroll = window.innerHeight + window.scrollMaxY;
    }
    else if (document.body.scrollHeight > document.body.offsetHeight) { // All but Explorer Mac.
      xScroll = document.body.scrollWidth;
      yScroll = document.body.scrollHeight;
    }
    else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari.
      xScroll = document.body.offsetWidth;
      yScroll = document.body.offsetHeight;
    }

    var windowWidth, windowHeight;

    if (self.innerHeight) { // All except Explorer.
      if (document.documentElement.clientWidth) {
        windowWidth = document.documentElement.clientWidth;
      }
      else {
        windowWidth = self.innerWidth;
      }
      windowHeight = self.innerHeight;
    }
    else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode.
      windowWidth = document.documentElement.clientWidth;
      windowHeight = document.documentElement.clientHeight;
    }
    else if (document.body) { // Other Explorers.
      windowWidth = document.body.clientWidth;
      windowHeight = document.body.clientHeight;
    }
    // For small pages with total height less than height of the viewport.
    if (yScroll < windowHeight) {
      pageHeight = windowHeight;
    }
    else {
      pageHeight = yScroll;
    }
    // For small pages with total width less than width of the viewport.
    if (xScroll < windowWidth) {
      pageWidth = xScroll;
    }
    else {
      pageWidth = windowWidth;
    }
    arrayPageSize = new Array(pageWidth,pageHeight,windowWidth,windowHeight);
    return arrayPageSize;
  },


  // pause(numberMillis)
  pause : function(ms) {
    var date = new Date();
    var curDate = null;
    do { curDate = new Date(); }
    while (curDate - date < ms);
  },


  // toggleSelectsFlash()
  // Hide / unhide select lists and flash objects as they appear above the
  // lightbox in some browsers.
  toggleSelectsFlash: function (state) {
    if (state == 'visible') {
      $("select.lightbox_hidden, embed.lightbox_hidden, object.lightbox_hidden").show();
    }
    else if (state == 'hide') {
      $("select:visible, embed:visible, object:visible").not('#lightboxAutoModal select, #lightboxAutoModal embed, #lightboxAutoModal object').addClass("lightbox_hidden");
      $("select.lightbox_hidden, embed.lightbox_hidden, object.lightbox_hidden").hide();
    }
  },


  // parseRel()
  parseRel: function (link) {
    var parts = [];
    parts["rel"] = parts["title"] = parts["group"] = parts["style"] = parts["flashvars"] = null;
    if (!$(link).attr('rel')) return parts;
    parts["rel"] = $(link).attr('rel').match(/\w+/)[0];

    if ($(link).attr('rel').match(/\[(.*)\]/)) {
      var info = $(link).attr('rel').match(/\[(.*?)\]/)[1].split('|');
      parts["group"] = info[0];
      parts["style"] = info[1];
      if (parts["style"] != undefined && parts["style"].match(/flashvars:\s?(.*?);/)) {
        parts["flashvars"] = parts["style"].match(/flashvars:\s?(.*?);/)[1];
      }
    }
    if ($(link).attr('rel').match(/\[.*\]\[(.*)\]/)) {
      parts["title"] = $(link).attr('rel').match(/\[.*\]\[(.*)\]/)[1];
    }
    return parts;
  },

  // setStyles()
  setStyles: function(item, styles) {
    item.width = Lightbox.iframe_width;
    item.height = Lightbox.iframe_height;
    item.scrolling = "auto";

    if (!styles) return item;
    var stylesArray = styles.split(';');
    for (var i = 0; i< stylesArray.length; i++) {
      if (stylesArray[i].indexOf('width:') >= 0) {
        var w = stylesArray[i].replace('width:', '');
        item.width = jQuery.trim(w);
      }
      else if (stylesArray[i].indexOf('height:') >= 0) {
        var h = stylesArray[i].replace('height:', '');
        item.height = jQuery.trim(h);
      }
      else if (stylesArray[i].indexOf('scrolling:') >= 0) {
        var scrolling = stylesArray[i].replace('scrolling:', '');
        item.scrolling = jQuery.trim(scrolling);
      }
      else if (stylesArray[i].indexOf('overflow:') >= 0) {
        var overflow = stylesArray[i].replace('overflow:', '');
        item.overflow = jQuery.trim(overflow);
      }
    }
    return item;
  },


  // togglePlayPause()
  // Hide the pause / play button as appropriate.  If pausing the slideshow also
  // clear the timers, otherwise move onto the next image.
  togglePlayPause: function(hideId, showId) {
    if (Lightbox.isSlideshow && hideId == "lightshowPause") {
      for (var i = 0; i < Lightbox.slideIdCount; i++) {
        window.clearTimeout(Lightbox.slideIdArray[i]);
      }
    }
    $('#' + hideId).hide();
    $('#' + showId).show();

    if (hideId == "lightshowPlay") {
      Lightbox.isPaused = false;
      if (!Lightbox.loopSlides && Lightbox.activeImage == (Lightbox.total - 1)) {
        Lightbox.end();
      }
      else if (Lightbox.total > 1) {
        Lightbox.changeData(Lightbox.activeImage + 1);
      }
    }
    else {
      Lightbox.isPaused = true;
    }
  },

  triggerLightbox: function (rel_type, rel_group) {
    if (rel_type.length) {
      if (rel_group && rel_group.length) {
        $("a[rel^='" + rel_type +"\[" + rel_group + "\]'], area[rel^='" + rel_type +"\[" + rel_group + "\]']").eq(0).trigger("click");
      }
      else {
        $("a[rel^='" + rel_type +"'], area[rel^='" + rel_type +"']").eq(0).trigger("click");
      }
    }
  },

  detectMacFF2: function() {
    var ua = navigator.userAgent.toLowerCase();
    if (/firefox[\/\s](\d+\.\d+)/.test(ua)) {
      var ffversion = new Number(RegExp.$1);
      if (ffversion < 3 && ua.indexOf('mac') != -1) {
        return true;
      }
    }
    return false;
  },

  checkKey: function(keys, key, code) {
    return (jQuery.inArray(key, keys) != -1 || jQuery.inArray(String(code), keys) != -1);
  },

  filterXSS: function(str, allowed_tags) {
    var output = "";
    $.ajax({
      url: Drupal.settings.basePath + 'system/lightbox2/filter-xss',
      data: {
        'string' : str,
        'allowed_tags' : allowed_tags
      },
      type: "POST",
      async: false,
      dataType:  "json",
      success: function(data) {
        output = data;
      }
    });
    return output;
  }

};

// Initialize the lightbox.
Drupal.behaviors.initLightbox = function (context) {
  $('body:not(.lightbox-processed)', context).addClass('lightbox-processed').each(function() {
    Lightbox.initialize();
    return false; // Break the each loop.
  });

  // Attach lightbox to any links with lightbox rels.
  Lightbox.initList(context);
  $('#lightboxAutoModal', context).triggerHandler('click');
};

;
(function ($) {

/**
 * Open Mollom privacy policy link in a new window.
 *
 * Required for valid XHTML Strict markup.
 */
Drupal.behaviors.mollomPrivacy = function (context) {
  $('.mollom-privacy a', context).click(function () {
    this.target = '_blank';
  });
};

/**
 * Attach click event handlers for CAPTCHA links.
 */
Drupal.behaviors.mollomCaptcha = function (context) {
  $('a.mollom-switch-captcha', context).click(getMollomCaptcha);
};

/**
 * Fetch a Mollom CAPTCHA and output the image or audio into the form.
 */
function getMollomCaptcha() {
  // Get the current requested CAPTCHA type from the clicked link.
  var newCaptchaType = $(this).hasClass('mollom-audio-captcha') ? 'audio' : 'image';

  var context = $(this).parents('form');

  // Extract the Mollom session id from the form.
  var mollomSessionId = $('input.mollom-session-id', context).val();

  // Retrieve a CAPTCHA:
  $.getJSON(Drupal.settings.basePath + 'mollom/captcha/' + newCaptchaType + '/' + mollomSessionId,
    function (data) {
      if (!(data && data.content)) {
        return;
      }
      // Inject new CAPTCHA.
      $('.mollom-captcha-content', context).parent().html(data.content);
      // Update session id.
      $('input.mollom-session-id', context).val(data.session_id);
      // Add an onclick-event handler for the new link.
      Drupal.attachBehaviors(context);
      // Focus on the CATPCHA input.
      $('input[name="mollom[captcha]"]', context).focus();
    }
  );
  return false;
}

})(jQuery);
;



/**
 * JavaScript behaviors for the front-end display of webforms.
 */

(function ($) {

Drupal.behaviors.webform = function(context) {
  // Calendar datepicker behavior.
  Drupal.webform.datepicker(context);
};

Drupal.webform = Drupal.webform || {};

Drupal.webform.datepicker = function(context) {
  $('div.webform-datepicker').each(function() {
    var $webformDatepicker = $(this);
    var $calendar = $webformDatepicker.find('input.webform-calendar');
    var startDate = $calendar[0].className.replace(/.*webform-calendar-start-(\d{4}-\d{2}-\d{2}).*/, '$1').split('-');
    var endDate = $calendar[0].className.replace(/.*webform-calendar-end-(\d{4}-\d{2}-\d{2}).*/, '$1').split('-');
    var firstDay = $calendar[0].className.replace(/.*webform-calendar-day-(\d).*/, '$1');

    // Convert date strings into actual Date objects.
    startDate = new Date(startDate[0], startDate[1] - 1, startDate[2]);
    endDate = new Date(endDate[0], endDate[1] - 1, endDate[2]);

    // Ensure that start comes before end for datepicker.
    if (startDate > endDate) {
      var laterDate = startDate;
      startDate = endDate;
      endDate = laterDate;
    }

    var startYear = startDate.getFullYear();
    var endYear = endDate.getFullYear();

    // Set up the jQuery datepicker element.
    $calendar.datepicker({
      dateFormat: 'yy-mm-dd',
      yearRange: startYear + ':' + endYear,
      firstDay: parseInt(firstDay),
      minDate: startDate,
      maxDate: endDate,
      onSelect: function(dateText, inst) {
        var date = dateText.split('-');
        $webformDatepicker.find('select.year, input.year').val(+date[0]);
        $webformDatepicker.find('select.month').val(+date[1]);
        $webformDatepicker.find('select.day').val(+date[2]);
      },
      beforeShow: function(input, inst) {
        // Get the select list values.
        var year = $webformDatepicker.find('select.year, input.year').val();
        var month = $webformDatepicker.find('select.month').val();
        var day = $webformDatepicker.find('select.day').val();

        // If empty, default to the current year/month/day in the popup.
        var today = new Date();
        year = year ? year : today.getFullYear();
        month = month ? month : today.getMonth() + 1;
        day = day ? day : today.getDate();

        // Make sure that the default year fits in the available options.
        year = (year < startYear || year > endYear) ? startYear : year;

        // jQuery UI Datepicker will read the input field and base its date off
        // of that, even though in our case the input field is a button.
        $(input).val(year + '-' + month + '-' + day);
      }
    });

    // Prevent the calendar button from submitting the form.
    $calendar.click(function(event) {
      $(this).focus();
      event.preventDefault();
    });
  });
}

})(jQuery);
;
// Copyright 2006 Google Inc.
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//   http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
document.createElement("canvas").getContext||(function(){var s=Math,j=s.round,F=s.sin,G=s.cos,V=s.abs,W=s.sqrt,k=10,v=k/2;function X(){return this.context_||(this.context_=new H(this))}var L=Array.prototype.slice;function Y(b,a){var c=L.call(arguments,2);return function(){return b.apply(a,c.concat(L.call(arguments)))}}var M={init:function(b){if(/MSIE/.test(navigator.userAgent)&&!window.opera){var a=b||document;a.createElement("canvas");a.attachEvent("onreadystatechange",Y(this.init_,this,a))}},init_:function(b){b.namespaces.g_vml_||
b.namespaces.add("g_vml_","urn:schemas-microsoft-com:vml","#default#VML");b.namespaces.g_o_||b.namespaces.add("g_o_","urn:schemas-microsoft-com:office:office","#default#VML");if(!b.styleSheets.ex_canvas_){var a=b.createStyleSheet();a.owningElement.id="ex_canvas_";a.cssText="canvas{display:inline-block;overflow:hidden;text-align:left;width:300px;height:150px}g_vml_\\:*{behavior:url(#default#VML)}g_o_\\:*{behavior:url(#default#VML)}"}var c=b.getElementsByTagName("canvas"),d=0;for(;d<c.length;d++)this.initElement(c[d])},
initElement:function(b){if(!b.getContext){b.getContext=X;b.innerHTML="";b.attachEvent("onpropertychange",Z);b.attachEvent("onresize",$);var a=b.attributes;if(a.width&&a.width.specified)b.style.width=a.width.nodeValue+"px";else b.width=b.clientWidth;if(a.height&&a.height.specified)b.style.height=a.height.nodeValue+"px";else b.height=b.clientHeight}return b}};function Z(b){var a=b.srcElement;switch(b.propertyName){case "width":a.style.width=a.attributes.width.nodeValue+"px";a.getContext().clearRect();
break;case "height":a.style.height=a.attributes.height.nodeValue+"px";a.getContext().clearRect();break}}function $(b){var a=b.srcElement;if(a.firstChild){a.firstChild.style.width=a.clientWidth+"px";a.firstChild.style.height=a.clientHeight+"px"}}M.init();var N=[],B=0;for(;B<16;B++){var C=0;for(;C<16;C++)N[B*16+C]=B.toString(16)+C.toString(16)}function I(){return[[1,0,0],[0,1,0],[0,0,1]]}function y(b,a){var c=I(),d=0;for(;d<3;d++){var f=0;for(;f<3;f++){var h=0,g=0;for(;g<3;g++)h+=b[d][g]*a[g][f];c[d][f]=
h}}return c}function O(b,a){a.fillStyle=b.fillStyle;a.lineCap=b.lineCap;a.lineJoin=b.lineJoin;a.lineWidth=b.lineWidth;a.miterLimit=b.miterLimit;a.shadowBlur=b.shadowBlur;a.shadowColor=b.shadowColor;a.shadowOffsetX=b.shadowOffsetX;a.shadowOffsetY=b.shadowOffsetY;a.strokeStyle=b.strokeStyle;a.globalAlpha=b.globalAlpha;a.arcScaleX_=b.arcScaleX_;a.arcScaleY_=b.arcScaleY_;a.lineScale_=b.lineScale_}function P(b){var a,c=1;b=String(b);if(b.substring(0,3)=="rgb"){var d=b.indexOf("(",3),f=b.indexOf(")",d+
1),h=b.substring(d+1,f).split(",");a="#";var g=0;for(;g<3;g++)a+=N[Number(h[g])];if(h.length==4&&b.substr(3,1)=="a")c=h[3]}else a=b;return{color:a,alpha:c}}function aa(b){switch(b){case "butt":return"flat";case "round":return"round";case "square":default:return"square"}}function H(b){this.m_=I();this.mStack_=[];this.aStack_=[];this.currentPath_=[];this.fillStyle=this.strokeStyle="#000";this.lineWidth=1;this.lineJoin="miter";this.lineCap="butt";this.miterLimit=k*1;this.globalAlpha=1;this.canvas=b;
var a=b.ownerDocument.createElement("div");a.style.width=b.clientWidth+"px";a.style.height=b.clientHeight+"px";a.style.overflow="hidden";a.style.position="absolute";b.appendChild(a);this.element_=a;this.lineScale_=this.arcScaleY_=this.arcScaleX_=1}var i=H.prototype;i.clearRect=function(){this.element_.innerHTML=""};i.beginPath=function(){this.currentPath_=[]};i.moveTo=function(b,a){var c=this.getCoords_(b,a);this.currentPath_.push({type:"moveTo",x:c.x,y:c.y});this.currentX_=c.x;this.currentY_=c.y};
i.lineTo=function(b,a){var c=this.getCoords_(b,a);this.currentPath_.push({type:"lineTo",x:c.x,y:c.y});this.currentX_=c.x;this.currentY_=c.y};i.bezierCurveTo=function(b,a,c,d,f,h){var g=this.getCoords_(f,h),l=this.getCoords_(b,a),e=this.getCoords_(c,d);Q(this,l,e,g)};function Q(b,a,c,d){b.currentPath_.push({type:"bezierCurveTo",cp1x:a.x,cp1y:a.y,cp2x:c.x,cp2y:c.y,x:d.x,y:d.y});b.currentX_=d.x;b.currentY_=d.y}i.quadraticCurveTo=function(b,a,c,d){var f=this.getCoords_(b,a),h=this.getCoords_(c,d),g={x:this.currentX_+
0.6666666666666666*(f.x-this.currentX_),y:this.currentY_+0.6666666666666666*(f.y-this.currentY_)};Q(this,g,{x:g.x+(h.x-this.currentX_)/3,y:g.y+(h.y-this.currentY_)/3},h)};i.arc=function(b,a,c,d,f,h){c*=k;var g=h?"at":"wa",l=b+G(d)*c-v,e=a+F(d)*c-v,m=b+G(f)*c-v,r=a+F(f)*c-v;if(l==m&&!h)l+=0.125;var n=this.getCoords_(b,a),o=this.getCoords_(l,e),q=this.getCoords_(m,r);this.currentPath_.push({type:g,x:n.x,y:n.y,radius:c,xStart:o.x,yStart:o.y,xEnd:q.x,yEnd:q.y})};i.rect=function(b,a,c,d){this.moveTo(b,
a);this.lineTo(b+c,a);this.lineTo(b+c,a+d);this.lineTo(b,a+d);this.closePath()};i.strokeRect=function(b,a,c,d){var f=this.currentPath_;this.beginPath();this.moveTo(b,a);this.lineTo(b+c,a);this.lineTo(b+c,a+d);this.lineTo(b,a+d);this.closePath();this.stroke();this.currentPath_=f};i.fillRect=function(b,a,c,d){var f=this.currentPath_;this.beginPath();this.moveTo(b,a);this.lineTo(b+c,a);this.lineTo(b+c,a+d);this.lineTo(b,a+d);this.closePath();this.fill();this.currentPath_=f};i.createLinearGradient=function(b,
a,c,d){var f=new D("gradient");f.x0_=b;f.y0_=a;f.x1_=c;f.y1_=d;return f};i.createRadialGradient=function(b,a,c,d,f,h){var g=new D("gradientradial");g.x0_=b;g.y0_=a;g.r0_=c;g.x1_=d;g.y1_=f;g.r1_=h;return g};i.drawImage=function(b){var a,c,d,f,h,g,l,e,m=b.runtimeStyle.width,r=b.runtimeStyle.height;b.runtimeStyle.width="auto";b.runtimeStyle.height="auto";var n=b.width,o=b.height;b.runtimeStyle.width=m;b.runtimeStyle.height=r;if(arguments.length==3){a=arguments[1];c=arguments[2];h=g=0;l=d=n;e=f=o}else if(arguments.length==
5){a=arguments[1];c=arguments[2];d=arguments[3];f=arguments[4];h=g=0;l=n;e=o}else if(arguments.length==9){h=arguments[1];g=arguments[2];l=arguments[3];e=arguments[4];a=arguments[5];c=arguments[6];d=arguments[7];f=arguments[8]}else throw Error("Invalid number of arguments");var q=this.getCoords_(a,c),t=[];t.push(" <g_vml_:group",' coordsize="',k*10,",",k*10,'"',' coordorigin="0,0"',' style="width:',10,"px;height:",10,"px;position:absolute;");if(this.m_[0][0]!=1||this.m_[0][1]){var E=[];E.push("M11=",
this.m_[0][0],",","M12=",this.m_[1][0],",","M21=",this.m_[0][1],",","M22=",this.m_[1][1],",","Dx=",j(q.x/k),",","Dy=",j(q.y/k),"");var p=q,z=this.getCoords_(a+d,c),w=this.getCoords_(a,c+f),x=this.getCoords_(a+d,c+f);p.x=s.max(p.x,z.x,w.x,x.x);p.y=s.max(p.y,z.y,w.y,x.y);t.push("padding:0 ",j(p.x/k),"px ",j(p.y/k),"px 0;filter:progid:DXImageTransform.Microsoft.Matrix(",E.join(""),", sizingmethod='clip');")}else t.push("top:",j(q.y/k),"px;left:",j(q.x/k),"px;");t.push(' ">','<g_vml_:image src="',b.src,
'"',' style="width:',k*d,"px;"," height:",k*f,'px;"',' cropleft="',h/n,'"',' croptop="',g/o,'"',' cropright="',(n-h-l)/n,'"',' cropbottom="',(o-g-e)/o,'"'," />","</g_vml_:group>");this.element_.insertAdjacentHTML("BeforeEnd",t.join(""))};i.stroke=function(b){var a=[],c=P(b?this.fillStyle:this.strokeStyle),d=c.color,f=c.alpha*this.globalAlpha;a.push("<g_vml_:shape",' filled="',!!b,'"',' style="position:absolute;width:',10,"px;height:",10,'px;"',' coordorigin="0 0" coordsize="',k*10," ",k*10,'"',' stroked="',
!b,'"',' path="');var h={x:null,y:null},g={x:null,y:null},l=0;for(;l<this.currentPath_.length;l++){var e=this.currentPath_[l];switch(e.type){case "moveTo":a.push(" m ",j(e.x),",",j(e.y));break;case "lineTo":a.push(" l ",j(e.x),",",j(e.y));break;case "close":a.push(" x ");e=null;break;case "bezierCurveTo":a.push(" c ",j(e.cp1x),",",j(e.cp1y),",",j(e.cp2x),",",j(e.cp2y),",",j(e.x),",",j(e.y));break;case "at":case "wa":a.push(" ",e.type," ",j(e.x-this.arcScaleX_*e.radius),",",j(e.y-this.arcScaleY_*e.radius),
" ",j(e.x+this.arcScaleX_*e.radius),",",j(e.y+this.arcScaleY_*e.radius)," ",j(e.xStart),",",j(e.yStart)," ",j(e.xEnd),",",j(e.yEnd));break}if(e){if(h.x==null||e.x<h.x)h.x=e.x;if(g.x==null||e.x>g.x)g.x=e.x;if(h.y==null||e.y<h.y)h.y=e.y;if(g.y==null||e.y>g.y)g.y=e.y}}a.push(' ">');if(b)if(typeof this.fillStyle=="object"){var m=this.fillStyle,r=0,n={x:0,y:0},o=0,q=1;if(m.type_=="gradient"){var t=m.x1_/this.arcScaleX_,E=m.y1_/this.arcScaleY_,p=this.getCoords_(m.x0_/this.arcScaleX_,m.y0_/this.arcScaleY_),
z=this.getCoords_(t,E);r=Math.atan2(z.x-p.x,z.y-p.y)*180/Math.PI;if(r<0)r+=360;if(r<1.0E-6)r=0}else{var p=this.getCoords_(m.x0_,m.y0_),w=g.x-h.x,x=g.y-h.y;n={x:(p.x-h.x)/w,y:(p.y-h.y)/x};w/=this.arcScaleX_*k;x/=this.arcScaleY_*k;var R=s.max(w,x);o=2*m.r0_/R;q=2*m.r1_/R-o}var u=m.colors_;u.sort(function(ba,ca){return ba.offset-ca.offset});var J=u.length,da=u[0].color,ea=u[J-1].color,fa=u[0].alpha*this.globalAlpha,ga=u[J-1].alpha*this.globalAlpha,S=[],l=0;for(;l<J;l++){var T=u[l];S.push(T.offset*q+
o+" "+T.color)}a.push('<g_vml_:fill type="',m.type_,'"',' method="none" focus="100%"',' color="',da,'"',' color2="',ea,'"',' colors="',S.join(","),'"',' opacity="',ga,'"',' g_o_:opacity2="',fa,'"',' angle="',r,'"',' focusposition="',n.x,",",n.y,'" />')}else a.push('<g_vml_:fill color="',d,'" opacity="',f,'" />');else{var K=this.lineScale_*this.lineWidth;if(K<1)f*=K;a.push("<g_vml_:stroke",' opacity="',f,'"',' joinstyle="',this.lineJoin,'"',' miterlimit="',this.miterLimit,'"',' endcap="',aa(this.lineCap),
'"',' weight="',K,'px"',' color="',d,'" />')}a.push("</g_vml_:shape>");this.element_.insertAdjacentHTML("beforeEnd",a.join(""))};i.fill=function(){this.stroke(true)};i.closePath=function(){this.currentPath_.push({type:"close"})};i.getCoords_=function(b,a){var c=this.m_;return{x:k*(b*c[0][0]+a*c[1][0]+c[2][0])-v,y:k*(b*c[0][1]+a*c[1][1]+c[2][1])-v}};i.save=function(){var b={};O(this,b);this.aStack_.push(b);this.mStack_.push(this.m_);this.m_=y(I(),this.m_)};i.restore=function(){O(this.aStack_.pop(),
this);this.m_=this.mStack_.pop()};function ha(b){var a=0;for(;a<3;a++){var c=0;for(;c<2;c++)if(!isFinite(b[a][c])||isNaN(b[a][c]))return false}return true}function A(b,a,c){if(!!ha(a)){b.m_=a;if(c)b.lineScale_=W(V(a[0][0]*a[1][1]-a[0][1]*a[1][0]))}}i.translate=function(b,a){A(this,y([[1,0,0],[0,1,0],[b,a,1]],this.m_),false)};i.rotate=function(b){var a=G(b),c=F(b);A(this,y([[a,c,0],[-c,a,0],[0,0,1]],this.m_),false)};i.scale=function(b,a){this.arcScaleX_*=b;this.arcScaleY_*=a;A(this,y([[b,0,0],[0,a,
0],[0,0,1]],this.m_),true)};i.transform=function(b,a,c,d,f,h){A(this,y([[b,a,0],[c,d,0],[f,h,1]],this.m_),true)};i.setTransform=function(b,a,c,d,f,h){A(this,[[b,a,0],[c,d,0],[f,h,1]],true)};i.clip=function(){};i.arcTo=function(){};i.createPattern=function(){return new U};function D(b){this.type_=b;this.r1_=this.y1_=this.x1_=this.r0_=this.y0_=this.x0_=0;this.colors_=[]}D.prototype.addColorStop=function(b,a){a=P(a);this.colors_.push({offset:b,color:a.color,alpha:a.alpha})};function U(){}G_vmlCanvasManager=
M;CanvasRenderingContext2D=H;CanvasGradient=D;CanvasPattern=U})();
;
/*
 * @name BeautyTips
 * @desc a tooltips/baloon-help plugin for jQuery
 *
 * @author Jeff Robbins - Lullabot - http://www.lullabot.com
 * @version 0.9.5 release candidate 1  (5/20/2009)
 */
jQuery.bt={version:'0.9.5-rc1'};;(function($){jQuery.fn.bt=function(content,options){if(typeof content!='string'){var contentSelect=true;options=content;content=false;}
else{var contentSelect=false;}
if(jQuery.fn.hoverIntent&&jQuery.bt.defaults.trigger=='hover'){jQuery.bt.defaults.trigger='hoverIntent';}
return this.each(function(index){var opts=jQuery.extend(false,jQuery.bt.defaults,jQuery.bt.options,options);opts.spikeLength=numb(opts.spikeLength);opts.spikeGirth=numb(opts.spikeGirth);opts.overlap=numb(opts.overlap);var ajaxTimeout=false;if(opts.killTitle){$(this).find('[title]').andSelf().each(function(){if(!$(this).attr('bt-xTitle')){$(this).attr('bt-xTitle',$(this).attr('title')).attr('title','');}});}
if(typeof opts.trigger=='string'){opts.trigger=[opts.trigger];}
if(opts.trigger[0]=='hoverIntent'){var hoverOpts=jQuery.extend(opts.hoverIntentOpts,{over:function(){this.btOn();},out:function(){this.btOff();}});$(this).hoverIntent(hoverOpts);}
else if(opts.trigger[0]=='hover'){$(this).hover(function(){this.btOn();},function(){this.btOff();});}
else if(opts.trigger[0]=='now'){if($(this).hasClass('bt-active')){this.btOff();}
else{this.btOn();}}
else if(opts.trigger[0]=='none'){}
else if(opts.trigger.length>1&&opts.trigger[0]!=opts.trigger[1]){$(this).bind(opts.trigger[0],function(){this.btOn();}).bind(opts.trigger[1],function(){this.btOff();});}
else{$(this).bind(opts.trigger[0],function(){if($(this).hasClass('bt-active')){this.btOff();}
else{this.btOn();}});}
this.btOn=function(){if(typeof $(this).data('bt-box')=='object'){this.btOff();}
opts.preBuild.apply(this);$(jQuery.bt.vars.closeWhenOpenStack).btOff();$(this).addClass('bt-active '+opts.activeClass);if(contentSelect&&opts.ajaxPath==null){if(opts.killTitle){$(this).attr('title',$(this).attr('bt-xTitle'));}
content=$.isFunction(opts.contentSelector)?opts.contentSelector.apply(this):eval(opts.contentSelector);if(opts.killTitle){$(this).attr('title','');}}
if(opts.ajaxPath!=null&&content==false){if(typeof opts.ajaxPath=='object'){var url=eval(opts.ajaxPath[0]);url+=opts.ajaxPath[1]?' '+opts.ajaxPath[1]:'';}
else{var url=opts.ajaxPath;}
var off=url.indexOf(" ");if(off>=0){var selector=url.slice(off,url.length);url=url.slice(0,off);}
var cacheData=opts.ajaxCache?$(document.body).data('btCache-'+url.replace(/\./g,'')):null;if(typeof cacheData=='string'){content=selector?$("<div/>").append(cacheData.replace(/<script(.|\s)*?\/script>/g,"")).find(selector):cacheData;}
else{var target=this;var ajaxOpts=jQuery.extend(false,{type:opts.ajaxType,data:opts.ajaxData,cache:opts.ajaxCache,url:url,complete:function(XMLHttpRequest,textStatus){if(textStatus=='success'||textStatus=='notmodified'){if(opts.ajaxCache){$(document.body).data('btCache-'+url.replace(/\./g,''),XMLHttpRequest.responseText);}
ajaxTimeout=false;content=selector?$("<div/>").append(XMLHttpRequest.responseText.replace(/<script(.|\s)*?\/script>/g,"")).find(selector):XMLHttpRequest.responseText;}
else{if(textStatus=='timeout'){ajaxTimeout=true;}
content=opts.ajaxError.replace(/%error/g,XMLHttpRequest.statusText);}
if($(target).hasClass('bt-active')){target.btOn();}}},opts.ajaxOpts);jQuery.ajax(ajaxOpts);content=opts.ajaxLoading;}}
var shadowMarginX=0;var shadowMarginY=0;var shadowShiftX=0;var shadowShiftY=0;if(opts.shadow&&!shadowSupport()){opts.shadow=false;jQuery.extend(opts,opts.noShadowOpts);}
if(opts.shadow){if(opts.shadowBlur>Math.abs(opts.shadowOffsetX)){shadowMarginX=opts.shadowBlur*2;}
else{shadowMarginX=opts.shadowBlur+Math.abs(opts.shadowOffsetX);}
shadowShiftX=(opts.shadowBlur-opts.shadowOffsetX)>0?opts.shadowBlur-opts.shadowOffsetX:0;if(opts.shadowBlur>Math.abs(opts.shadowOffsetY)){shadowMarginY=opts.shadowBlur*2;}
else{shadowMarginY=opts.shadowBlur+Math.abs(opts.shadowOffsetY);}
shadowShiftY=(opts.shadowBlur-opts.shadowOffsetY)>0?opts.shadowBlur-opts.shadowOffsetY:0;}
if(opts.offsetParent){var offsetParent=$(opts.offsetParent);var offsetParentPos=offsetParent.offset();var pos=$(this).offset();var top=numb(pos.top)-numb(offsetParentPos.top)+numb($(this).css('margin-top'))-shadowShiftY;var left=numb(pos.left)-numb(offsetParentPos.left)+numb($(this).css('margin-left'))-shadowShiftX;}
else{var offsetParent=($(this).css('position')=='absolute')?$(this).parents().eq(0).offsetParent():$(this).offsetParent();var pos=$(this).btPosition();var top=numb(pos.top)+numb($(this).css('margin-top'))-shadowShiftY;var left=numb(pos.left)+numb($(this).css('margin-left'))-shadowShiftX;}
var width=$(this).btOuterWidth();var height=$(this).outerHeight();if(typeof content=='object'){if(content==null){return;}
var original=content;var clone=$(original).clone(true).show();var origClones=$(original).data('bt-clones')||[];origClones.push(clone);$(original).data('bt-clones',origClones);$(clone).data('bt-orig',original);$(this).data('bt-content-orig',{original:original,clone:clone});content=clone;}
if(typeof content=='null'||content==''){return;}
var $text=$('<div class="bt-content"></div>').append(content).css({padding:opts.padding,position:'absolute',width:(opts.shrinkToFit?'auto':opts.width),zIndex:opts.textzIndex,left:shadowShiftX,top:shadowShiftY}).css(opts.cssStyles);var $box=$('<div class="bt-wrapper"></div>').append($text).addClass(opts.cssClass).css({position:'absolute',width:opts.width,zIndex:opts.wrapperzIndex,visibility:'hidden'}).appendTo(offsetParent);if(jQuery.fn.bgiframe){$text.bgiframe();$box.bgiframe();}
$(this).data('bt-box',$box);var scrollTop=numb($(document).scrollTop());var scrollLeft=numb($(document).scrollLeft());var docWidth=numb($(window).width());var docHeight=numb($(window).height());var winRight=scrollLeft+docWidth;var winBottom=scrollTop+docHeight;var space=new Object();var thisOffset=$(this).offset();space.top=thisOffset.top-scrollTop;space.bottom=docHeight-((thisOffset+height)-scrollTop);space.left=thisOffset.left-scrollLeft;space.right=docWidth-((thisOffset.left+width)-scrollLeft);var textOutHeight=numb($text.outerHeight());var textOutWidth=numb($text.btOuterWidth());if(opts.positions.constructor==String){opts.positions=opts.positions.replace(/ /,'').split(',');}
if(opts.positions[0]=='most'){var position='top';for(var pig in space){position=space[pig]>space[position]?pig:position;}}
else{for(var x in opts.positions){var position=opts.positions[x];if((position=='left'||position=='right')&&space[position]>textOutWidth+opts.spikeLength){break;}
else if((position=='top'||position=='bottom')&&space[position]>textOutHeight+opts.spikeLength){break;}}}
var horiz=left+((width-textOutWidth)*.5);var vert=top+((height-textOutHeight)*.5);var points=new Array();var textTop,textLeft,textRight,textBottom,textTopSpace,textBottomSpace,textLeftSpace,textRightSpace,crossPoint,textCenter,spikePoint;switch(position){case'top':$text.css('margin-bottom',opts.spikeLength+'px');$box.css({top:(top-$text.outerHeight(true))+opts.overlap,left:horiz});textRightSpace=(winRight-opts.windowMargin)-($text.offset().left+$text.btOuterWidth(true));var xShift=shadowShiftX;if(textRightSpace<0){$box.css('left',(numb($box.css('left'))+textRightSpace)+'px');xShift-=textRightSpace;}
textLeftSpace=($text.offset().left+numb($text.css('margin-left')))-(scrollLeft+opts.windowMargin);if(textLeftSpace<0){$box.css('left',(numb($box.css('left'))-textLeftSpace)+'px');xShift+=textLeftSpace;}
textTop=$text.btPosition().top+numb($text.css('margin-top'));textLeft=$text.btPosition().left+numb($text.css('margin-left'));textRight=textLeft+$text.btOuterWidth();textBottom=textTop+$text.outerHeight();textCenter={x:textLeft+($text.btOuterWidth()*opts.centerPointX),y:textTop+($text.outerHeight()*opts.centerPointY)};points[points.length]=spikePoint={y:textBottom+opts.spikeLength,x:((textRight-textLeft)*.5)+xShift,type:'spike'};crossPoint=findIntersectX(spikePoint.x,spikePoint.y,textCenter.x,textCenter.y,textBottom);crossPoint.x=crossPoint.x<textLeft+opts.spikeGirth/2+opts.cornerRadius?textLeft+opts.spikeGirth/2+opts.cornerRadius:crossPoint.x;crossPoint.x=crossPoint.x>(textRight-opts.spikeGirth/2)-opts.cornerRadius?(textRight-opts.spikeGirth/2)-opts.CornerRadius:crossPoint.x;points[points.length]={x:crossPoint.x-(opts.spikeGirth/2),y:textBottom,type:'join'};points[points.length]={x:textLeft,y:textBottom,type:'corner'};points[points.length]={x:textLeft,y:textTop,type:'corner'};points[points.length]={x:textRight,y:textTop,type:'corner'};points[points.length]={x:textRight,y:textBottom,type:'corner'};points[points.length]={x:crossPoint.x+(opts.spikeGirth/2),y:textBottom,type:'join'};points[points.length]=spikePoint;break;case'left':$text.css('margin-right',opts.spikeLength+'px');$box.css({top:vert+'px',left:((left-$text.btOuterWidth(true))+opts.overlap)+'px'});textBottomSpace=(winBottom-opts.windowMargin)-($text.offset().top+$text.outerHeight(true));var yShift=shadowShiftY;if(textBottomSpace<0){$box.css('top',(numb($box.css('top'))+textBottomSpace)+'px');yShift-=textBottomSpace;}
textTopSpace=($text.offset().top+numb($text.css('margin-top')))-(scrollTop+opts.windowMargin);if(textTopSpace<0){$box.css('top',(numb($box.css('top'))-textTopSpace)+'px');yShift+=textTopSpace;}
textTop=$text.btPosition().top+numb($text.css('margin-top'));textLeft=$text.btPosition().left+numb($text.css('margin-left'));textRight=textLeft+$text.btOuterWidth();textBottom=textTop+$text.outerHeight();textCenter={x:textLeft+($text.btOuterWidth()*opts.centerPointX),y:textTop+($text.outerHeight()*opts.centerPointY)};points[points.length]=spikePoint={x:textRight+opts.spikeLength,y:((textBottom-textTop)*.5)+yShift,type:'spike'};crossPoint=findIntersectY(spikePoint.x,spikePoint.y,textCenter.x,textCenter.y,textRight);crossPoint.y=crossPoint.y<textTop+opts.spikeGirth/2+opts.cornerRadius?textTop+opts.spikeGirth/2+opts.cornerRadius:crossPoint.y;crossPoint.y=crossPoint.y>(textBottom-opts.spikeGirth/2)-opts.cornerRadius?(textBottom-opts.spikeGirth/2)-opts.cornerRadius:crossPoint.y;points[points.length]={x:textRight,y:crossPoint.y+opts.spikeGirth/2,type:'join'};points[points.length]={x:textRight,y:textBottom,type:'corner'};points[points.length]={x:textLeft,y:textBottom,type:'corner'};points[points.length]={x:textLeft,y:textTop,type:'corner'};points[points.length]={x:textRight,y:textTop,type:'corner'};points[points.length]={x:textRight,y:crossPoint.y-opts.spikeGirth/2,type:'join'};points[points.length]=spikePoint;break;case'bottom':$text.css('margin-top',opts.spikeLength+'px');$box.css({top:(top+height)-opts.overlap,left:horiz});textRightSpace=(winRight-opts.windowMargin)-($text.offset().left+$text.btOuterWidth(true));var xShift=shadowShiftX;if(textRightSpace<0){$box.css('left',(numb($box.css('left'))+textRightSpace)+'px');xShift-=textRightSpace;}
textLeftSpace=($text.offset().left+numb($text.css('margin-left')))-(scrollLeft+opts.windowMargin);if(textLeftSpace<0){$box.css('left',(numb($box.css('left'))-textLeftSpace)+'px');xShift+=textLeftSpace;}
textTop=$text.btPosition().top+numb($text.css('margin-top'));textLeft=$text.btPosition().left+numb($text.css('margin-left'));textRight=textLeft+$text.btOuterWidth();textBottom=textTop+$text.outerHeight();textCenter={x:textLeft+($text.btOuterWidth()*opts.centerPointX),y:textTop+($text.outerHeight()*opts.centerPointY)};points[points.length]=spikePoint={x:((textRight-textLeft)*.5)+xShift,y:shadowShiftY,type:'spike'};crossPoint=findIntersectX(spikePoint.x,spikePoint.y,textCenter.x,textCenter.y,textTop);crossPoint.x=crossPoint.x<textLeft+opts.spikeGirth/2+opts.cornerRadius?textLeft+opts.spikeGirth/2+opts.cornerRadius:crossPoint.x;crossPoint.x=crossPoint.x>(textRight-opts.spikeGirth/2)-opts.cornerRadius?(textRight-opts.spikeGirth/2)-opts.cornerRadius:crossPoint.x;points[points.length]={x:crossPoint.x+opts.spikeGirth/2,y:textTop,type:'join'};points[points.length]={x:textRight,y:textTop,type:'corner'};points[points.length]={x:textRight,y:textBottom,type:'corner'};points[points.length]={x:textLeft,y:textBottom,type:'corner'};points[points.length]={x:textLeft,y:textTop,type:'corner'};points[points.length]={x:crossPoint.x-(opts.spikeGirth/2),y:textTop,type:'join'};points[points.length]=spikePoint;break;case'right':$text.css('margin-left',(opts.spikeLength+'px'));$box.css({top:vert+'px',left:((left+width)-opts.overlap)+'px'});textBottomSpace=(winBottom-opts.windowMargin)-($text.offset().top+$text.outerHeight(true));var yShift=shadowShiftY;if(textBottomSpace<0){$box.css('top',(numb($box.css('top'))+textBottomSpace)+'px');yShift-=textBottomSpace;}
textTopSpace=($text.offset().top+numb($text.css('margin-top')))-(scrollTop+opts.windowMargin);if(textTopSpace<0){$box.css('top',(numb($box.css('top'))-textTopSpace)+'px');yShift+=textTopSpace;}
textTop=$text.btPosition().top+numb($text.css('margin-top'));textLeft=$text.btPosition().left+numb($text.css('margin-left'));textRight=textLeft+$text.btOuterWidth();textBottom=textTop+$text.outerHeight();textCenter={x:textLeft+($text.btOuterWidth()*opts.centerPointX),y:textTop+($text.outerHeight()*opts.centerPointY)};points[points.length]=spikePoint={x:shadowShiftX,y:((textBottom-textTop)*.5)+yShift,type:'spike'};crossPoint=findIntersectY(spikePoint.x,spikePoint.y,textCenter.x,textCenter.y,textLeft);crossPoint.y=crossPoint.y<textTop+opts.spikeGirth/2+opts.cornerRadius?textTop+opts.spikeGirth/2+opts.cornerRadius:crossPoint.y;crossPoint.y=crossPoint.y>(textBottom-opts.spikeGirth/2)-opts.cornerRadius?(textBottom-opts.spikeGirth/2)-opts.cornerRadius:crossPoint.y;points[points.length]={x:textLeft,y:crossPoint.y-opts.spikeGirth/2,type:'join'};points[points.length]={x:textLeft,y:textTop,type:'corner'};points[points.length]={x:textRight,y:textTop,type:'corner'};points[points.length]={x:textRight,y:textBottom,type:'corner'};points[points.length]={x:textLeft,y:textBottom,type:'corner'};points[points.length]={x:textLeft,y:crossPoint.y+opts.spikeGirth/2,type:'join'};points[points.length]=spikePoint;break;}
var canvas=document.createElement('canvas');$(canvas).attr('width',(numb($text.btOuterWidth(true))+opts.strokeWidth*2+shadowMarginX)).attr('height',(numb($text.outerHeight(true))+opts.strokeWidth*2+shadowMarginY)).appendTo($box).css({position:'absolute',zIndex:opts.boxzIndex});if(typeof G_vmlCanvasManager!='undefined'){canvas=G_vmlCanvasManager.initElement(canvas);}
if(opts.cornerRadius>0){var newPoints=new Array();var newPoint;for(var i=0;i<points.length;i++){if(points[i].type=='corner'){newPoint=betweenPoint(points[i],points[(i-1)%points.length],opts.cornerRadius);newPoint.type='arcStart';newPoints[newPoints.length]=newPoint;newPoints[newPoints.length]=points[i];newPoint=betweenPoint(points[i],points[(i+1)%points.length],opts.cornerRadius);newPoint.type='arcEnd';newPoints[newPoints.length]=newPoint;}
else{newPoints[newPoints.length]=points[i];}}
points=newPoints;}
var ctx=canvas.getContext("2d");if(opts.shadow&&opts.shadowOverlap!==true){var shadowOverlap=numb(opts.shadowOverlap);switch(position){case'top':if(opts.shadowOffsetX+opts.shadowBlur-shadowOverlap>0){$box.css('top',(numb($box.css('top'))-(opts.shadowOffsetX+opts.shadowBlur-shadowOverlap)));}
break;case'right':if(shadowShiftX-shadowOverlap>0){$box.css('left',(numb($box.css('left'))+shadowShiftX-shadowOverlap));}
break;case'bottom':if(shadowShiftY-shadowOverlap>0){$box.css('top',(numb($box.css('top'))+shadowShiftY-shadowOverlap));}
break;case'left':if(opts.shadowOffsetY+opts.shadowBlur-shadowOverlap>0){$box.css('left',(numb($box.css('left'))-(opts.shadowOffsetY+opts.shadowBlur-shadowOverlap)));}
break;}}
drawIt.apply(ctx,[points],opts.strokeWidth);ctx.fillStyle=opts.fill;if(opts.shadow){ctx.shadowOffsetX=opts.shadowOffsetX;ctx.shadowOffsetY=opts.shadowOffsetY;ctx.shadowBlur=opts.shadowBlur;ctx.shadowColor=opts.shadowColor;}
ctx.closePath();ctx.fill();if(opts.strokeWidth>0){ctx.shadowColor='rgba(0, 0, 0, 0)';ctx.lineWidth=opts.strokeWidth;ctx.strokeStyle=opts.strokeStyle;ctx.beginPath();drawIt.apply(ctx,[points],opts.strokeWidth);ctx.closePath();ctx.stroke();}
opts.preShow.apply(this,[$box[0]]);$box.css({display:'none',visibility:'visible'});opts.showTip.apply(this,[$box[0]]);if(opts.overlay){var overlay=$('<div class="bt-overlay"></div>').css({position:'absolute',backgroundColor:'blue',top:top,left:left,width:width,height:height,opacity:'.2'}).appendTo(offsetParent);$(this).data('overlay',overlay);}
if((opts.ajaxPath!=null&&opts.ajaxCache==false)||ajaxTimeout){content=false;}
if(opts.clickAnywhereToClose){jQuery.bt.vars.clickAnywhereStack.push(this);$(document).click(jQuery.bt.docClick);}
if(opts.closeWhenOthersOpen){jQuery.bt.vars.closeWhenOpenStack.push(this);}
opts.postShow.apply(this,[$box[0]]);};this.btOff=function(){var box=$(this).data('bt-box');if(typeof box=='undefined'){return;}
opts.preHide.apply(this,[box]);var i=this;i.btCleanup=function(){var box=$(i).data('bt-box');var contentOrig=$(i).data('bt-content-orig');var overlay=$(i).data('bt-overlay');if(typeof box=='object'){$(box).remove();$(i).removeData('bt-box');}
if(typeof contentOrig=='object'){var clones=$(contentOrig.original).data('bt-clones');$(contentOrig).data('bt-clones',arrayRemove(clones,contentOrig.clone));}
if(typeof overlay=='object'){$(overlay).remove();$(i).removeData('bt-overlay');}
jQuery.bt.vars.clickAnywhereStack=arrayRemove(jQuery.bt.vars.clickAnywhereStack,i);jQuery.bt.vars.closeWhenOpenStack=arrayRemove(jQuery.bt.vars.closeWhenOpenStack,i);$(i).removeClass('bt-active '+opts.activeClass);opts.postHide.apply(i);}
opts.hideTip.apply(this,[box,i.btCleanup]);};var refresh=this.btRefresh=function(){this.btOff();this.btOn();};});function drawIt(points,strokeWidth){this.moveTo(points[0].x,points[0].y);for(i=1;i<points.length;i++){if(points[i-1].type=='arcStart'){this.quadraticCurveTo(round5(points[i].x,strokeWidth),round5(points[i].y,strokeWidth),round5(points[(i+1)%points.length].x,strokeWidth),round5(points[(i+1)%points.length].y,strokeWidth));i++;}
else{this.lineTo(round5(points[i].x,strokeWidth),round5(points[i].y,strokeWidth));}}};function round5(num,strokeWidth){var ret;strokeWidth=numb(strokeWidth);if(strokeWidth%2){ret=num;}
else{ret=Math.round(num-.5)+.5;}
return ret;};function numb(num){return parseInt(num)||0;};function arrayRemove(arr,elem){var x,newArr=new Array();for(x in arr){if(arr[x]!=elem){newArr.push(arr[x]);}}
return newArr;};function canvasSupport(){var canvas_compatible=false;try{canvas_compatible=!!(document.createElement('canvas').getContext('2d'));}catch(e){canvas_compatible=!!(document.createElement('canvas').getContext);}
return canvas_compatible;}
function shadowSupport(){try{var userAgent=navigator.userAgent.toLowerCase();if(/webkit/.test(userAgent)){return true;}
else if(/gecko|mozilla/.test(userAgent)&&parseFloat(userAgent.match(/firefox\/(\d+(?:\.\d+)+)/)[1])>=3.1){return true;}}
catch(err){}
return false;}
function betweenPoint(point1,point2,dist){var y,x;if(point1.x==point2.x){y=point1.y<point2.y?point1.y+dist:point1.y-dist;return{x:point1.x,y:y};}
else if(point1.y==point2.y){x=point1.x<point2.x?point1.x+dist:point1.x-dist;return{x:x,y:point1.y};}};function centerPoint(arcStart,corner,arcEnd){var x=corner.x==arcStart.x?arcEnd.x:arcStart.x;var y=corner.y==arcStart.y?arcEnd.y:arcStart.y;var startAngle,endAngle;if(arcStart.x<arcEnd.x){if(arcStart.y>arcEnd.y){startAngle=(Math.PI/180)*180;endAngle=(Math.PI/180)*90;}
else{startAngle=(Math.PI/180)*90;endAngle=0;}}
else{if(arcStart.y>arcEnd.y){startAngle=(Math.PI/180)*270;endAngle=(Math.PI/180)*180;}
else{startAngle=0;endAngle=(Math.PI/180)*270;}}
return{x:x,y:y,type:'center',startAngle:startAngle,endAngle:endAngle};};function findIntersect(r1x1,r1y1,r1x2,r1y2,r2x1,r2y1,r2x2,r2y2){if(r2x1==r2x2){return findIntersectY(r1x1,r1y1,r1x2,r1y2,r2x1);}
if(r2y1==r2y2){return findIntersectX(r1x1,r1y1,r1x2,r1y2,r2y1);}
var r1m=(r1y1-r1y2)/(r1x1-r1x2);var r1b=r1y1-(r1m*r1x1);var r2m=(r2y1-r2y2)/(r2x1-r2x2);var r2b=r2y1-(r2m*r2x1);var x=(r2b-r1b)/(r1m-r2m);var y=r1m*x+r1b;return{x:x,y:y};};function findIntersectY(r1x1,r1y1,r1x2,r1y2,x){if(r1y1==r1y2){return{x:x,y:r1y1};}
var r1m=(r1y1-r1y2)/(r1x1-r1x2);var r1b=r1y1-(r1m*r1x1);var y=r1m*x+r1b;return{x:x,y:y};};function findIntersectX(r1x1,r1y1,r1x2,r1y2,y){if(r1x1==r1x2){return{x:r1x1,y:y};}
var r1m=(r1y1-r1y2)/(r1x1-r1x2);var r1b=r1y1-(r1m*r1x1);var x=(y-r1b)/r1m;return{x:x,y:y};};};jQuery.fn.btPosition=function(){function num(elem,prop){return elem[0]&&parseInt(jQuery.curCSS(elem[0],prop,true),10)||0;};var left=0,top=0,results;if(this[0]){var offsetParent=this.offsetParent(),offset=this.offset(),parentOffset=/^body|html$/i.test(offsetParent[0].tagName)?{top:0,left:0}:offsetParent.offset();offset.top-=num(this,'marginTop');offset.left-=num(this,'marginLeft');parentOffset.top+=num(offsetParent,'borderTopWidth');parentOffset.left+=num(offsetParent,'borderLeftWidth');results={top:offset.top-parentOffset.top,left:offset.left-parentOffset.left};}
return results;};jQuery.fn.btOuterWidth=function(margin){function num(elem,prop){return elem[0]&&parseInt(jQuery.curCSS(elem[0],prop,true),10)||0;};return this["innerWidth"]()
+num(this,"borderLeftWidth")
+num(this,"borderRightWidth")
+(margin?num(this,"marginLeft")
+num(this,"marginRight"):0);};jQuery.fn.btOn=function(){return this.each(function(index){if(jQuery.isFunction(this.btOn)){this.btOn();}});};jQuery.fn.btOff=function(){return this.each(function(index){if(jQuery.isFunction(this.btOff)){this.btOff();}});};jQuery.bt.vars={clickAnywhereStack:[],closeWhenOpenStack:[]};jQuery.bt.docClick=function(e){if(!e){var e=window.event;};if(!$(e.target).parents().andSelf().filter('.bt-wrapper, .bt-active').length&&jQuery.bt.vars.clickAnywhereStack.length){$(jQuery.bt.vars.clickAnywhereStack).btOff();$(document).unbind('click',jQuery.bt.docClick);}};jQuery.bt.defaults={trigger:'hover',clickAnywhereToClose:true,closeWhenOthersOpen:false,shrinkToFit:false,width:'200px',padding:'10px',spikeGirth:10,spikeLength:15,overlap:0,overlay:false,killTitle:true,textzIndex:9999,boxzIndex:9998,wrapperzIndex:9997,offsetParent:null,positions:['most'],fill:"rgb(255, 255, 102)",windowMargin:10,strokeWidth:1,strokeStyle:"#000",cornerRadius:5,centerPointX:.5,centerPointY:.5,shadow:false,shadowOffsetX:2,shadowOffsetY:2,shadowBlur:3,shadowColor:"#000",shadowOverlap:false,noShadowOpts:{strokeStyle:'#999'},cssClass:'',cssStyles:{},activeClass:'bt-active',contentSelector:"$(this).attr('title')",ajaxPath:null,ajaxError:'<strong>ERROR:</strong> <em>%error</em>',ajaxLoading:'<blink>Loading...</blink>',ajaxData:{},ajaxType:'GET',ajaxCache:true,ajaxOpts:{},preBuild:function(){},preShow:function(box){},showTip:function(box){$(box).show();},postShow:function(box){},preHide:function(box){},hideTip:function(box,callback){$(box).hide();callback();},postHide:function(){},hoverIntentOpts:{interval:300,timeout:500}};jQuery.bt.options={};})(jQuery);;
// $Id: beautytips.js,v 1.2.2.5 2010/06/16 20:35:47 kleinmp Exp $

/**
 * Defines the default beautytip and adds them to the content on the page
 */ 
Drupal.behaviors.beautytips = function() {
  jQuery.bt.options.closeWhenOthersOpen = true;
  beautytips = Drupal.settings.beautytips;

  // Add the the tooltips to the page
  for (var key in beautytips) {
    // Build array of options that were passed to beautytips_add_beautyips
    var bt_options = new Array();
    if (beautytips[key]['list']) {
      for ( var k = 0; k < beautytips[key]['list'].length; k++) {
        bt_options[beautytips[key]['list'][k]] = beautytips[key][beautytips[key]['list'][k]];
      }
    }
    if (beautytips[key]['cssSelect']) {
      // Run any java script that needs to be run when the page loads
      if (beautytips[key]['contentSelector'] && beautytips[key]['preEval']) {
        $(beautytips[key]['cssSelect']).each(function() {
          eval(beautytips[key]['contentSelector']);
        });
      }
      if (beautytips[key]['text']) {
        $(beautytips[key]['cssSelect']).each(function() {
          $(this).bt(beautytips[key]['text'], bt_options);
        });
      }
      else if (beautytips[key]['ajaxPath']) {
        $(beautytips[key]['cssSelect']).each(function() {
          $(this).bt(bt_options);
          if (beautytips[key]['ajaxDisableLink']) {
            $(beautytips[key]['ajaxDisableLink']).click(function() {
              return false;
            });
          }
        });
      }
      else { 
        $(beautytips[key]['cssSelect']).each(function() {
          $(this).bt(bt_options);
        });
      }
    }
    bt_options.length = 0;
  }
}
;

/* Vars globales */

primerHijo=0; //ref a primer bloque dentro de otro
timer="";//temporizador para retardos
pos=0; pes=0;
function isMSIE() {
  var isIE = /*@cc_on!@*/false;
  isIE = isIE && (document.all || document.layers);
  isIE = isIE && ('\v' == 'v');
  return isIE;
}
function getIEVersion()
// Retorna version of Internet Explorer o -1
{
  var rv = -1; // Return value assumes failure.
  if (navigator.appName == 'Microsoft Internet Explorer')
  {
    var ua = navigator.userAgent;
    var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
    if (re.exec(ua) != null)
      rv = parseFloat( RegExp.$1 );
  }
  return rv;
}
function inicializacion(){
	var ruta=location.pathname.split("/",3)[2]+"";

  	if (isMSIE()) { //Es IE
		primerHijo=0;
	}
  	else { //No es IE
		primerHijo=1;
	}
	/* Activar y abrir arbol de menus de un enlace activo */
	$("li.leaf").each( function() {
		if ($(this).hasClass('active-trail')) {
			$(this).parents().filter('li.dhtml-menu').removeClass('collapsed').addClass('expanded');
			$(this).parents().filter('ul.menu').show();
		}
	});
	/* Ajuste para gestionar grupos de campos colapsables */
	Drupal.toggleFieldset = function(fieldset) {
	var nodeInfo;
	  if ($(fieldset).is('.collapsed')) {
		// Action div containers are processed separately because of a IE bug
		// that alters the default submit button behavior.
		//Colapsables para electivas
		if ($(fieldset.parentNode).attr('class') == 'views-field views-field-title') {			
                    
			//Cierro todos los fieldsets de titulo
			$('td.views-field-title > fieldset').each(function() { //Solo un campo expandido a la vez	
				if (!$(this).is('.collapsed')) {Drupal.toggleFieldset(this);}
			});
                     nodeInfo=$(fieldset.parentNode.parentNode).next('.info').find('fieldset');
			var content1 = $('> div:not(.action)', nodeInfo);
			$(nodeInfo).removeClass('collapsed');
			content1.hide();
			content1.slideDown( {
			  duration: 'fast',
			  easing: 'linear',
			  complete: function() {
				Drupal.collapseScrollIntoView(this.parentNode);
				this.parentNode.animating = false;
				$('div.action', nodeInfo).show();
			  },
			  step: function() {
				// Scroll the fieldset into view
				Drupal.collapseScrollIntoView(this.parentNode);
			  }
			});
		}
		//Cierro todos los fieldsets de info. Solo un campo expandido a la vez
		if ($(fieldset.parentNode.parentNode).attr('class') == 'info') {
			$('tr.info td.electiva-info > fieldset').each(function() {
				if (!$(this).is('.collapsed')) {Drupal.toggleFieldset(this);}
			});
		}

		if ($(fieldset.parentNode.parentNode).attr('class') == 'columnilla') {
			$('div.columnilla div.views-row > fieldset').each(function(){ //Solo un campo expandido a la vez
				if (!$(this).is('.collapsed')) {Drupal.toggleFieldset(this);}
			});
		}
				
		if ($(fieldset.parentNode).attr('class') == 'tabs-tabset ui-tabs-panel') {
			$('div.ui-tabs-panel > fieldset').each(function(){ //Solo un campo expandido a la vez
				if (!$(this).is('.collapsed')) {Drupal.toggleFieldset(this);}
			});
		}
		if ($(fieldset.parentNode).attr('class') == 'content clear-block') {
			$('div.clear-block > fieldset').each(function(){ //Solo un campo expandido a la vez
				if (!$(this).is('.collapsed')) {Drupal.toggleFieldset(this);}
			});
		}
		if ($(fieldset.parentNode).attr('class') == 'content archivo') {
			$('div.archivo > fieldset').each(function(){ //Solo un campo expandido a la vez
				if (!$(this).is('.collapsed')) {Drupal.toggleFieldset(this);}
			});
		}
		var content = $('> div:not(.action)', fieldset);
		$(fieldset).removeClass('collapsed');
		content.hide();
		content.slideDown( {
		  duration: 'fast',
		  easing: 'linear',
		  complete: function() {
			Drupal.collapseScrollIntoView(this.parentNode);
			this.parentNode.animating = false;
			$('div.action', fieldset).show();
		  },
		  step: function() {
			// Scroll the fieldset into view
			Drupal.collapseScrollIntoView(this.parentNode);
		  }
		});
	  }
	  else {
		if ($(fieldset.parentNode).attr('class') == 'views-field views-field-title')  {  
                    
			nodeInfo=$(fieldset.parentNode.parentNode).next('.info').find('fieldset');
			$('div.action', nodeInfo).hide();
			var content1 = $('> div:not(.action)', nodeInfo).slideUp('fast', function() {
			  $(this.parentNode).addClass('collapsed');
			  this.parentNode.animating = false;
			});			
		} 	  	  
		$('div.action', fieldset).hide();
		var content = $('> div:not(.action)', fieldset).slideUp('fast', function() {
		  $(this.parentNode).addClass('collapsed');
		  this.parentNode.animating = false;
		});
	  }
	};	
}
function escapame(str){
  str = str.replace(/&uacute;/g, '\xFA');
  str = str.replace(/&oacute;/g, '\xF3');
  str = str.replace(/&iacute;/g, '\xED');
  str = str.replace(/&eacute;/g, '\xE9');
  str = str.replace(/&aacute;/g, '\xE1');
  str = str.replace(/&ntilde;/g, '\xF1');

  str = str.replace(/&Uacute;/g, '\xDA');
  str = str.replace(/&Oacute;/g, '\xD3');
  str = str.replace(/&Iacute;/g, '\xCD');
  str = str.replace(/&Eacute;/g, '\xC9');
  str = str.replace(/&Aacute;/g, '\xC1');
  str = str.replace(/&Ntilde;/g, '\xD1');
  return str;
}
function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}
function setOpacity(imgNodo,valor){
	//Debido a incompatibilidad entre versiones y navegadores
	//se define de manera diferente la opacidad CSS
	if (isMSIE()){  /* IE */
		imgNodo.style.filter="alpha(opacity="+valor+")";
		imgNodo.style.float="left"; //Requerido en vers viejas de IE
		if(imgNodo.style.filters) imgNodo.style.filters.alpha.opacity=valor; //IE4
	}else{
		imgNodo.style.MozOpacity=valor/100; /* NS6, Firefox, Opera, ... */
		imgNodo.style.opacity=valor/100;  /* CSS 3*/
	}
}
function externalLinks() { 
	if (!document.getElementsByTagName) return;
	var anchors = document.getElementsByTagName("a");
	for (var i=0; i<anchors.length; i++) { 
		var anchor = anchors[i];
		if (anchor.getAttribute("href") && anchor.getAttribute("rel") == "external") anchor.target = "_blank";
		if (anchor.getAttribute("href") && anchor.getAttribute("rel") == "descargar") {
			anchor.onclick = function() { confirm('Desea descargar el archivo: '+this.href);return false; };
		}
	}
	inicializacion();
} 
window.onload = externalLinks;;
if (!window['google']) {
window['google'] = {};
}
if (!window['google']['loader']) {
window['google']['loader'] = {};
google.loader.ServiceBase = 'http://www.google.com/uds';
google.loader.GoogleApisBase = 'http://ajax.googleapis.com/ajax';
google.loader.ApiKey = 'notsupplied';
google.loader.KeyVerified = true;
google.loader.LoadFailure = false;
google.loader.Secure = false;
google.loader.GoogleLocale = 'www.google.com';
google.loader.ClientLocation = {"latitude":4.633,"longitude":-74.083,"address":{"city":"","region":"Distrito Capital","country":"Colombia","country_code":"CO"}};
google.loader.AdditionalParams = '';
google.loader.OriginalAppPath = 'http://www.trycatchfail.com/demos/AutoHideMenu.html';
(function() {var d=true,g=null,h=false,j=encodeURIComponent,l=window,n=undefined,o=document;function p(a,b){return a.load=b}var q="push",r="replace",s="charAt",t="ServiceBase",u="name",v="getTime",w="length",x="prototype",y="setTimeout",z="loader",A="substring",B="join",C="toLowerCase";function D(a){if(a in E)return E[a];return E[a]=navigator.userAgent[C]().indexOf(a)!=-1}var E={};function F(a,b){var c=function(){};c.prototype=b[x];a.Q=b[x];a.prototype=new c}
function G(a,b){var c=Array[x].slice.call(arguments,2)||[];return function(){var e=c.concat(Array[x].slice.call(arguments));return a.apply(b,e)}}function H(a){a=Error(a);a.toString=function(){return this.message};return a}function I(a,b){for(var c=a.split(/\./),e=l,f=0;f<c[w]-1;f++){e[c[f]]||(e[c[f]]={});e=e[c[f]]}e[c[c[w]-1]]=b}function J(a,b,c){a[b]=c}if(!K)var K=I;if(!L)var L=J;google[z].t={};K("google.loader.callbacks",google[z].t);var M={},N={};google[z].eval={};K("google.loader.eval",google[z].eval);
p(google,function(a,b,c){function e(k){var m=k.split(".");if(m[w]>2)throw H("Module: '"+k+"' not found!");else if(typeof m[1]!="undefined"){f=m[0];c.packages=c.packages||[];c.packages[q](m[1])}}var f=a;c=c||{};if(a instanceof Array||a&&typeof a=="object"&&typeof a[B]=="function"&&typeof a.reverse=="function")for(var i=0;i<a[w];i++)e(a[i]);else e(a);if(a=M[":"+f]){if(c&&!c.language&&c.locale)c.language=c.locale;if(c&&typeof c.callback=="string"){i=c.callback;if(i.match(/^[[\]A-Za-z0-9._]+$/)){i=l.eval(i);
c.callback=i}}if((i=c&&c.callback!=g)&&!a.s(b))throw H("Module: '"+f+"' must be loaded before DOM onLoad!");else if(i)a.m(b,c)?l[y](c.callback,0):a.load(b,c);else a.m(b,c)||a.load(b,c)}else throw H("Module: '"+f+"' not found!");});K("google.load",google.load);
google.P=function(a,b){if(b){if(O[w]==0){P(l,"load",Q);if(!D("msie")&&!(D("safari")||D("konqueror"))&&D("mozilla")||l.opera)l.addEventListener("DOMContentLoaded",Q,h);else if(D("msie"))o.write("<script defer onreadystatechange='google.loader.domReady()' src=//:><\/script>");else(D("safari")||D("konqueror"))&&l[y](S,10)}O[q](a)}else P(l,"load",a)};K("google.setOnLoadCallback",google.P);
function P(a,b,c){if(a.addEventListener)a.addEventListener(b,c,h);else if(a.attachEvent)a.attachEvent("on"+b,c);else{var e=a["on"+b];a["on"+b]=e!=g?aa([c,e]):c}}function aa(a){return function(){for(var b=0;b<a[w];b++)a[b]()}}var O=[];google[z].K=function(){var a=l.event.srcElement;if(a.readyState=="complete"){a.onreadystatechange=g;a.parentNode.removeChild(a);Q()}};K("google.loader.domReady",google[z].K);var ba={loaded:d,complete:d};function S(){if(ba[o.readyState])Q();else O[w]>0&&l[y](S,10)}
function Q(){for(var a=0;a<O[w];a++)O[a]();O.length=0}
google[z].d=function(a,b,c){if(c){var e;if(a=="script"){e=o.createElement("script");e.type="text/javascript";e.src=b}else if(a=="css"){e=o.createElement("link");e.type="text/css";e.href=b;e.rel="stylesheet"}(a=o.getElementsByTagName("head")[0])||(a=o.body.parentNode.appendChild(o.createElement("head")));a.appendChild(e)}else if(a=="script")o.write('<script src="'+b+'" type="text/javascript"><\/script>');else a=="css"&&o.write('<link href="'+b+'" type="text/css" rel="stylesheet"></link>')};
K("google.loader.writeLoadTag",google[z].d);google[z].M=function(a){N=a};K("google.loader.rfm",google[z].M);google[z].O=function(a){for(var b in a)if(typeof b=="string"&&b&&b[s](0)==":"&&!M[b])M[b]=new T(b[A](1),a[b])};K("google.loader.rpl",google[z].O);google[z].N=function(a){if((a=a.specs)&&a[w])for(var b=0;b<a[w];++b){var c=a[b];if(typeof c=="string")M[":"+c]=new U(c);else{c=new V(c[u],c.baseSpec,c.customSpecs);M[":"+c[u]]=c}}};K("google.loader.rm",google[z].N);
google[z].loaded=function(a){M[":"+a.module].k(a)};K("google.loader.loaded",google[z].loaded);google[z].J=function(){return"qid="+((new Date)[v]().toString(16)+Math.floor(Math.random()*1E7).toString(16))};K("google.loader.createGuidArg_",google[z].J);I("google_exportSymbol",I);I("google_exportProperty",J);google[z].b={};K("google.loader.themes",google[z].b);google[z].b.z="http://www.google.com/cse/style/look/bubblegum.css";L(google[z].b,"BUBBLEGUM",google[z].b.z);google[z].b.B="http://www.google.com/cse/style/look/greensky.css";
L(google[z].b,"GREENSKY",google[z].b.B);google[z].b.A="http://www.google.com/cse/style/look/espresso.css";L(google[z].b,"ESPRESSO",google[z].b.A);google[z].b.D="http://www.google.com/cse/style/look/shiny.css";L(google[z].b,"SHINY",google[z].b.D);google[z].b.C="http://www.google.com/cse/style/look/minimalist.css";L(google[z].b,"MINIMALIST",google[z].b.C);function U(a){this.a=a;this.q=[];this.p={};this.i={};this.e={};this.l=d;this.c=-1}
U[x].g=function(a,b){var c="";if(b!=n){if(b.language!=n)c+="&hl="+j(b.language);if(b.nocss!=n)c+="&output="+j("nocss="+b.nocss);if(b.nooldnames!=n)c+="&nooldnames="+j(b.nooldnames);if(b.packages!=n)c+="&packages="+j(b.packages);if(b.callback!=g)c+="&async=2";if(b.style!=n)c+="&style="+j(b.style);if(b.other_params!=n)c+="&"+b.other_params}if(!this.l){if(google[this.a]&&google[this.a].JSHash)c+="&sig="+j(google[this.a].JSHash);var e=[];for(var f in this.p)f[s](0)==":"&&e[q](f[A](1));for(f in this.i)f[s](0)==
":"&&this.i[f]&&e[q](f[A](1));c+="&have="+j(e[B](","))}return google[z][t]+"/?file="+this.a+"&v="+a+google[z].AdditionalParams+c};U[x].v=function(a){var b=g;if(a)b=a.packages;var c=g;if(b)if(typeof b=="string")c=[a.packages];else if(b[w]){c=[];for(a=0;a<b[w];a++)typeof b[a]=="string"&&c[q](b[a][r](/^\s*|\s*$/,"")[C]())}c||(c=["default"]);b=[];for(a=0;a<c[w];a++)this.p[":"+c[a]]||b[q](c[a]);return b};
p(U[x],function(a,b){var c=this.v(b),e=b&&b.callback!=g;if(e)var f=new W(b.callback);for(var i=[],k=c[w]-1;k>=0;k--){var m=c[k];e&&f.F(m);if(this.i[":"+m]){c.splice(k,1);e&&this.e[":"+m][q](f)}else i[q](m)}if(c[w]){if(b&&b.packages)b.packages=c.sort()[B](",");for(k=0;k<i[w];k++){m=i[k];this.e[":"+m]=[];e&&this.e[":"+m][q](f)}if(!b&&N[":"+this.a]!=g&&N[":"+this.a].versions[":"+a]!=g&&!google[z].AdditionalParams&&this.l){c=N[":"+this.a];google[this.a]=google[this.a]||{};for(var R in c.properties)if(R&&
R[s](0)==":")google[this.a][R[A](1)]=c.properties[R];google[z].d("script",google[z][t]+c.path+c.js,e);c.css&&google[z].d("css",google[z][t]+c.path+c.css,e)}else if(!b||!b.autoloaded)google[z].d("script",this.g(a,b),e);if(this.l){this.l=h;this.c=(new Date)[v]();if(this.c%100!=1)this.c=-1}for(k=0;k<i[w];k++){m=i[k];this.i[":"+m]=d}}});
U[x].k=function(a){if(this.c!=-1){X("al_"+this.a,"jl."+((new Date)[v]()-this.c),d);this.c=-1}this.q=this.q.concat(a.components);google[z][this.a]||(google[z][this.a]={});google[z][this.a].packages=this.q.slice(0);for(var b=0;b<a.components[w];b++){this.p[":"+a.components[b]]=d;this.i[":"+a.components[b]]=h;var c=this.e[":"+a.components[b]];if(c){for(var e=0;e<c[w];e++)c[e].I(a.components[b]);delete this.e[":"+a.components[b]]}}X("hl",this.a)};U[x].m=function(a,b){return this.v(b)[w]==0};U[x].s=function(){return d};
function W(a){this.H=a;this.n={};this.r=0}W[x].F=function(a){this.r++;this.n[":"+a]=d};W[x].I=function(a){if(this.n[":"+a]){this.n[":"+a]=h;this.r--;this.r==0&&l[y](this.H,0)}};function V(a,b,c){this.name=a;this.G=b;this.o=c;this.u=this.h=h;this.j=[];google[z].t[this[u]]=G(this.k,this)}F(V,U);p(V[x],function(a,b){var c=b&&b.callback!=g;if(c){this.j[q](b.callback);b.callback="google.loader.callbacks."+this[u]}else this.h=d;if(!b||!b.autoloaded)google[z].d("script",this.g(a,b),c);X("el",this[u])});V[x].m=function(a,b){return b&&b.callback!=g?this.u:this.h};V[x].k=function(){this.u=d;for(var a=0;a<this.j[w];a++)l[y](this.j[a],0);this.j=[]};
var Y=function(a,b){return a.string?j(a.string)+"="+j(b):a.regex?b[r](/(^.*$)/,a.regex):""};V[x].g=function(a,b){return this.L(this.w(a),a,b)};
V[x].L=function(a,b,c){var e="";if(a.key)e+="&"+Y(a.key,google[z].ApiKey);if(a.version)e+="&"+Y(a.version,b);b=google[z].Secure&&a.ssl?a.ssl:a.uri;if(c!=g)for(var f in c)if(a.params[f])e+="&"+Y(a.params[f],c[f]);else if(f=="other_params")e+="&"+c[f];else if(f=="base_domain")b="http://"+c[f]+a.uri[A](a.uri.indexOf("/",7));google[this[u]]={};if(b.indexOf("?")==-1&&e)e="?"+e[A](1);return b+e};V[x].s=function(a){return this.w(a).deferred};
V[x].w=function(a){if(this.o)for(var b=0;b<this.o[w];++b){var c=this.o[b];if(RegExp(c.pattern).test(a))return c}return this.G};function T(a,b){this.a=a;this.f=b;this.h=h}F(T,U);p(T[x],function(a,b){this.h=d;google[z].d("script",this.g(a,b),h)});T[x].m=function(){return this.h};T[x].k=function(){};
T[x].g=function(a,b){if(!this.f.versions[":"+a]){if(this.f.aliases){var c=this.f.aliases[":"+a];if(c)a=c}if(!this.f.versions[":"+a])throw H("Module: '"+this.a+"' with version '"+a+"' not found!");}c=google[z].GoogleApisBase+"/libs/"+this.a+"/"+a+"/"+this.f.versions[":"+a][b&&b.uncompressed?"uncompressed":"compressed"];X("el",this.a);return c};T[x].s=function(){return h};var ca=h,Z=[],da=(new Date)[v](),X=function(a,b,c){if(!ca){P(l,"unload",ea);ca=d}if(c){if(!google[z].Secure&&(!google[z].Options||google[z].Options.csi===h)){a=a[C]()[r](/[^a-z0-9_.]+/g,"_");b=b[C]()[r](/[^a-z0-9_.]+/g,"_");l[y](G($,g,"http://csi.gstatic.com/csi?s=uds&v=2&action="+j(a)+"&it="+j(b)),1E4)}}else{Z[q]("r"+Z[w]+"="+j(a+(b?"|"+b:"")));l[y](ea,Z[w]>5?0:15E3)}},ea=function(){if(Z[w]){$(google[z][t]+"/stats?"+Z[B]("&")+"&nc="+(new Date)[v]()+"_"+((new Date)[v]()-da));Z.length=0}},$=function(a){var b=
new Image,c=fa++;ga[c]=b;b.onload=b.onerror=function(){delete ga[c]};b.src=a;b=g},ga={},fa=0;I("google.loader.recordStat",X);I("google.loader.createImageForLogging",$);

}) ();google.loader.rm({"specs":[{"name":"books","baseSpec":{"uri":"http://books.google.com/books/api.js","ssl":null,"key":{"string":"key"},"version":{"string":"v"},"deferred":true,"params":{"callback":{"string":"callback"},"language":{"string":"hl"}}}},"feeds",{"name":"friendconnect","baseSpec":{"uri":"http://www.google.com/friendconnect/script/friendconnect.js","ssl":null,"key":{"string":"key"},"version":{"string":"v"},"deferred":false,"params":{}}},"spreadsheets","gdata","visualization",{"name":"sharing","baseSpec":{"uri":"http://www.google.com/s2/sharing/js","ssl":null,"key":{"string":"key"},"version":{"string":"v"},"deferred":false,"params":{"language":{"string":"hl"}}}},"search",{"name":"maps","baseSpec":{"uri":"http://maps.google.com/maps?file\u003dgoogleapi","ssl":"https://maps-api-ssl.google.com/maps?file\u003dgoogleapi","key":{"string":"key"},"version":{"string":"v"},"deferred":true,"params":{"callback":{"regex":"callback\u003d$1\u0026async\u003d2"},"language":{"string":"hl"}}},"customSpecs":[{"uri":"http://maps.google.com/maps/api/js","ssl":"https://maps-api-ssl.google.com/maps/api/js","key":{"string":"key"},"version":{"string":"v"},"deferred":true,"params":{"callback":{"string":"callback"},"language":{"string":"hl"}},"pattern":"^(3|3..*)$"}]},"annotations_v2","wave","orkut",{"name":"annotations","baseSpec":{"uri":"http://www.google.com/reviews/scripts/annotations_bootstrap.js","ssl":null,"key":{"string":"key"},"version":{"string":"v"},"deferred":true,"params":{"callback":{"string":"callback"},"language":{"string":"hl"},"country":{"string":"gl"}}}},"language","earth","ads","elements"]});
google.loader.rfm({":search":{"versions":{":1":"1",":1.0":"1"},"path":"/api/search/1.0/2a8ff2a70ad0b091ae9dfd8b5e832141/","js":"default+es.I.js","css":"default.css","properties":{":JSHash":"2a8ff2a70ad0b091ae9dfd8b5e832141",":NoOldNames":false,":Version":"1.0"}},":language":{"versions":{":1":"1",":1.0":"1"},"path":"/api/language/1.0/62c64af2122d2da7dcb0087852fa7396/","js":"default+es.I.js","properties":{":JSHash":"62c64af2122d2da7dcb0087852fa7396",":Version":"1.0"}},":wave":{"versions":{":1":"1",":1.0":"1"},"path":"/api/wave/1.0/3b6f7573ff78da6602dda5e09c9025bf/","js":"default.I.js","properties":{":JSHash":"3b6f7573ff78da6602dda5e09c9025bf",":Version":"1.0"}},":spreadsheets":{"versions":{":0":"1",":0.3":"1"},"path":"/api/spreadsheets/0.3/8331b0bbcc74776270648505340e9200/","js":"default.I.js","properties":{":JSHash":"8331b0bbcc74776270648505340e9200",":Version":"0.3"}},":earth":{"versions":{":1":"1",":1.0":"1"},"path":"/api/earth/1.0/819ffbf1e363d238791231792a2e0a90/","js":"default.I.js","properties":{":JSHash":"819ffbf1e363d238791231792a2e0a90",":Version":"1.0"}},":annotations":{"versions":{":1":"1",":1.0":"1"},"path":"/api/annotations/1.0/11cfaf30c00ca64601d09fcac7dd8bc7/","js":"default+es.I.js","properties":{":JSHash":"11cfaf30c00ca64601d09fcac7dd8bc7",":Version":"1.0"}}});
google.loader.rpl({":scriptaculous":{"versions":{":1.8.3":{"uncompressed":"scriptaculous.js","compressed":"scriptaculous.js"},":1.8.2":{"uncompressed":"scriptaculous.js","compressed":"scriptaculous.js"},":1.8.1":{"uncompressed":"scriptaculous.js","compressed":"scriptaculous.js"}},"aliases":{":1.8":"1.8.3",":1":"1.8.3"}},":yui":{"versions":{":2.6.0":{"uncompressed":"build/yuiloader/yuiloader.js","compressed":"build/yuiloader/yuiloader-min.js"},":2.7.0":{"uncompressed":"build/yuiloader/yuiloader.js","compressed":"build/yuiloader/yuiloader-min.js"},":2.8.0r4":{"uncompressed":"build/yuiloader/yuiloader.js","compressed":"build/yuiloader/yuiloader-min.js"},":2.8.1":{"uncompressed":"build/yuiloader/yuiloader.js","compressed":"build/yuiloader/yuiloader-min.js"}},"aliases":{":2":"2.8.1",":2.7":"2.7.0",":2.6":"2.6.0",":2.8":"2.8.1",":2.8.0":"2.8.0r4"}},":swfobject":{"versions":{":2.1":{"uncompressed":"swfobject_src.js","compressed":"swfobject.js"},":2.2":{"uncompressed":"swfobject_src.js","compressed":"swfobject.js"}},"aliases":{":2":"2.2"}},":webfont":{"versions":{":1.0.2":{"uncompressed":"webfont_debug.js","compressed":"webfont.js"},":1.0.1":{"uncompressed":"webfont_debug.js","compressed":"webfont.js"},":1.0.0":{"uncompressed":"webfont_debug.js","compressed":"webfont.js"},":1.0.6":{"uncompressed":"webfont_debug.js","compressed":"webfont.js"},":1.0.5":{"uncompressed":"webfont_debug.js","compressed":"webfont.js"},":1.0.4":{"uncompressed":"webfont_debug.js","compressed":"webfont.js"},":1.0.3":{"uncompressed":"webfont_debug.js","compressed":"webfont.js"}},"aliases":{":1":"1.0.6",":1.0":"1.0.6"}},":ext-core":{"versions":{":3.1.0":{"uncompressed":"ext-core-debug.js","compressed":"ext-core.js"},":3.0.0":{"uncompressed":"ext-core-debug.js","compressed":"ext-core.js"}},"aliases":{":3":"3.1.0",":3.0":"3.0.0",":3.1":"3.1.0"}},":mootools":{"versions":{":1.2.3":{"uncompressed":"mootools.js","compressed":"mootools-yui-compressed.js"},":1.1.1":{"uncompressed":"mootools.js","compressed":"mootools-yui-compressed.js"},":1.2.4":{"uncompressed":"mootools.js","compressed":"mootools-yui-compressed.js"},":1.2.1":{"uncompressed":"mootools.js","compressed":"mootools-yui-compressed.js"},":1.2.2":{"uncompressed":"mootools.js","compressed":"mootools-yui-compressed.js"},":1.1.2":{"uncompressed":"mootools.js","compressed":"mootools-yui-compressed.js"}},"aliases":{":1":"1.1.2",":1.11":"1.1.1",":1.2":"1.2.4",":1.1":"1.1.2"}},":jqueryui":{"versions":{":3.6.0":{"uncompressed":"jquery-ui.js","compressed":"jquery-ui.min.js"},":1.7.3":{"uncompressed":"jquery-ui.js","compressed":"jquery-ui.min.js"},":1.6.0":{"uncompressed":"jquery-ui.js","compressed":"jquery-ui.min.js"},":1.7.0":{"uncompressed":"jquery-ui.js","compressed":"jquery-ui.min.js"},":1.7.1":{"uncompressed":"jquery-ui.js","compressed":"jquery-ui.min.js"},":1.8.4":{"uncompressed":"jquery-ui.js","compressed":"jquery-ui.min.js"},":1.5.3":{"uncompressed":"jquery-ui.js","compressed":"jquery-ui.min.js"},":1.8.0":{"uncompressed":"jquery-ui.js","compressed":"jquery-ui.min.js"},":1.5.2":{"uncompressed":"jquery-ui.js","compressed":"jquery-ui.min.js"},":1.8.2":{"uncompressed":"jquery-ui.js","compressed":"jquery-ui.min.js"},":1.8.1":{"uncompressed":"jquery-ui.js","compressed":"jquery-ui.min.js"}},"aliases":{":1.8":"1.8.4",":1.7":"1.7.3",":1.6":"1.6.0",":1":"1.8.4",":1.5":"1.5.3",":1.8.3":"1.8.4"}},":chrome-frame":{"versions":{":1.0.2":{"uncompressed":"CFInstall.js","compressed":"CFInstall.min.js"},":1.0.1":{"uncompressed":"CFInstall.js","compressed":"CFInstall.min.js"},":1.0.0":{"uncompressed":"CFInstall.js","compressed":"CFInstall.min.js"}},"aliases":{":1":"1.0.2",":1.0":"1.0.2"}},":prototype":{"versions":{":1.6.0.2":{"uncompressed":"prototype.js","compressed":"prototype.js"},":1.6.1.0":{"uncompressed":"prototype.js","compressed":"prototype.js"},":1.6.0.3":{"uncompressed":"prototype.js","compressed":"prototype.js"}},"aliases":{":1.6.1":"1.6.1.0",":1":"1.6.1.0",":1.6":"1.6.1.0",":1.6.0":"1.6.0.3"}},":jquery":{"versions":{":1.2.3":{"uncompressed":"jquery.js","compressed":"jquery.min.js"},":1.3.1":{"uncompressed":"jquery.js","compressed":"jquery.min.js"},":1.3.0":{"uncompressed":"jquery.js","compressed":"jquery.min.js"},":3.6.0":{"uncompressed":"jquery.js","compressed":"jquery.min.js"},":1.2.6":{"uncompressed":"jquery.js","compressed":"jquery.min.js"},":1.4.0":{"uncompressed":"jquery.js","compressed":"jquery.min.js"},":1.4.1":{"uncompressed":"jquery.js","compressed":"jquery.min.js"},":1.4.2":{"uncompressed":"jquery.js","compressed":"jquery.min.js"}},"aliases":{":1":"1.4.2",":1.4":"1.4.2",":1.3":"3.6.0",":1.2":"1.2.6"}},":dojo":{"versions":{":1.2.3":{"uncompressed":"dojo/dojo.xd.js.uncompressed.js","compressed":"dojo/dojo.xd.js"},":1.3.1":{"uncompressed":"dojo/dojo.xd.js.uncompressed.js","compressed":"dojo/dojo.xd.js"},":1.1.1":{"uncompressed":"dojo/dojo.xd.js.uncompressed.js","compressed":"dojo/dojo.xd.js"},":1.3.0":{"uncompressed":"dojo/dojo.xd.js.uncompressed.js","compressed":"dojo/dojo.xd.js"},":3.6.0":{"uncompressed":"dojo/dojo.xd.js.uncompressed.js","compressed":"dojo/dojo.xd.js"},":1.4.3":{"uncompressed":"dojo/dojo.xd.js.uncompressed.js","compressed":"dojo/dojo.xd.js"},":1.5.0":{"uncompressed":"dojo/dojo.xd.js.uncompressed.js","compressed":"dojo/dojo.xd.js"},":1.2.0":{"uncompressed":"dojo/dojo.xd.js.uncompressed.js","compressed":"dojo/dojo.xd.js"},":1.4.0":{"uncompressed":"dojo/dojo.xd.js.uncompressed.js","compressed":"dojo/dojo.xd.js"},":1.4.1":{"uncompressed":"dojo/dojo.xd.js.uncompressed.js","compressed":"dojo/dojo.xd.js"}},"aliases":{":1":"1.5.0",":1.5":"1.5.0",":1.4":"1.4.3",":1.3":"3.6.0",":1.2":"1.2.3",":1.1":"1.1.1"}}});
}
;
/* Codigo para manejar el pie */
/*  google.load("jquery", "3.6.0");
  google.load("jqueryui", "3.6.0");
*/  
  google.setOnLoadCallback(function() { 
	var timeout = null;
	var initialMargin = parseInt($("#footMenuBar").css("margin-bottom"));

	$("#footMenuBar").hover(
		function() {
			if (timeout) {
				clearTimeout(timeout);
				timeout = null;
			}
			$(this).animate({ marginBottom: 0 }, 'fast');
		},
		function() {
			var menuBar = $(this);
			timeout = setTimeout(function() {
				timeout = null;
				menuBar.animate({ marginBottom: initialMargin }, 'slow');
			}, 1000);
		}
	);
  });;
//** Animated Collapsible DIV v2.0- (c) Dynamic Drive DHTML code library: http://www.dynamicdrive.com.
//** May 24th, 08'- Script rewritten and updated to 2.0.
//** June 4th, 08'- Version 2.01: Bug fix to work with jquery 1.2.6 (which changed the way attr() behaves).
//** March 5th, 09'- Version 2.2, which adds the following:
			//1) ontoggle($, divobj, state) event that fires each time a DIV is expanded/collapsed, including when the page 1st loads
			//2) Ability to expand a DIV via a URL parameter string, ie: index.htm?expanddiv=jason or index.htm?expanddiv=jason,kelly

//** March 9th, 09'- Version 2.2.1: Optimized ontoggle event handler slightly.
//** July 3rd, 09'- Version 2.4, which adds the following:
			//1) You can now insert rel="expand[divid] | collapse[divid] | toggle[divid]" inside arbitrary links to act as DIV togglers
			//2) For image toggler links, you can insert the attributes "data-openimage" and "data-closedimage" to update its image based on the DIV state

var animatedcollapse={
divholders: {}, //structure: {div.id, div.attrs, div.$divref, div.$togglerimage}
divgroups: {}, //structure: {groupname.count, groupname.lastactivedivid}
lastactiveingroup: {}, //structure: {lastactivediv.id}
preloadimages: [],

show:function(divids){ //public method
	if (typeof divids=="object"){
		for (var i=0; i<divids.length; i++)
			this.showhide(divids[i], "show")
	}
	else
		this.showhide(divids, "show")
},

hide:function(divids){ //public method
	if (typeof divids=="object"){
		for (var i=0; i<divids.length; i++)
			this.showhide(divids[i], "hide")
	}
	else
		this.showhide(divids, "hide")
},

toggle:function(divid){ //public method
	if (typeof divid=="object")
		divid=divid[0]
	this.showhide(divid, "toggle")
},

addDiv:function(divid, attrstring){ //public function
	this.divholders[divid]=({id: divid, $divref: null, attrs: attrstring})
	this.divholders[divid].getAttr=function(name){ //assign getAttr() function to each divholder object
		var attr=new RegExp(name+"=([^,]+)", "i") //get name/value config pair (ie: width=400px,)
		return (attr.test(this.attrs) && parseInt(RegExp.$1)!=0)? RegExp.$1 : null //return value portion (string), or 0 (false) if none found
	}
	this.currentid=divid //keep track of current div object being manipulated (in the event of chaining)
	return this
},

showhide:function(divid, action){
	var $divref=this.divholders[divid].$divref //reference collapsible DIV
	if (this.divholders[divid] && $divref.length==1){ //if DIV exists
		var targetgroup=this.divgroups[$divref.attr('groupname')] //find out which group DIV belongs to (if any)
		if ($divref.attr('groupname') && targetgroup.count>1 && (action=="show" || action=="toggle" && $divref.css('display')=='none')){ //If current DIV belongs to a group
			if (targetgroup.lastactivedivid && targetgroup.lastactivedivid!=divid) //if last active DIV is set
				this.slideengine(targetgroup.lastactivedivid, 'hide') //hide last active DIV within group first
				this.slideengine(divid, 'show')
			targetgroup.lastactivedivid=divid //remember last active DIV
		}
		else{
			this.slideengine(divid, action)
		}
	}
},

slideengine:function(divid, action){
	var $divref=this.divholders[divid].$divref
	var $togglerimage=this.divholders[divid].$togglerimage
	if (this.divholders[divid] && $divref.length==1){ //if this DIV exists
		var animateSetting={height: action}
		if ($divref.attr('fade'))
			animateSetting.opacity=action
		$divref.animate(animateSetting, $divref.attr('speed')? parseInt($divref.attr('speed')) : 500, function(){
			if ($togglerimage){
				$togglerimage.attr('src', ($divref.css('display')=="none")? $togglerimage.data('srcs').closed : $togglerimage.data('srcs').open)
			}
			if (animatedcollapse.ontoggle){
				try{
					animatedcollapse.ontoggle(jQuery, $divref.get(0), $divref.css('display'))
				}
				catch(e){
					alert("An error exists inside your \"ontoggle\" function:\n\n"+e+"\n\nAborting execution of function.")
				}
			}
		})
		return false
	}
},

generatemap:function(){
	var map={}
	for (var i=0; i<arguments.length; i++){
		if (arguments[i][1]!=null){ //do not generate name/value pair if value is null
			map[arguments[i][0]]=arguments[i][1]
		}
	}
	return map
},

init:function(){
	var ac=this
	jQuery(document).ready(function($){
		animatedcollapse.ontoggle=animatedcollapse.ontoggle || null
		var urlparamopenids=animatedcollapse.urlparamselect() //Get div ids that should be expanded based on the url (['div1','div2',etc])
		var persistopenids=ac.getCookie('acopendivids') //Get list of div ids that should be expanded due to persistence ('div1,div2,etc')
		var groupswithpersist=ac.getCookie('acgroupswithpersist') //Get list of group names that have 1 or more divs with "persist" attribute defined
		if (persistopenids!=null) //if cookie isn't null (is null if first time page loads, and cookie hasnt been set yet)
			persistopenids=(persistopenids=='nada')? [] : persistopenids.split(',') //if no divs are persisted, set to empty array, else, array of div ids
		groupswithpersist=(groupswithpersist==null || groupswithpersist=='nada')? [] : groupswithpersist.split(',') //Get list of groups with divs that are persisted
		jQuery.each(ac.divholders, function(){ //loop through each collapsible DIV object
			this.$divref=$('#'+this.id)
			if ((this.getAttr('persist') || jQuery.inArray(this.getAttr('group'), groupswithpersist)!=-1) && persistopenids!=null){ //if this div carries a user "persist" setting, or belong to a group with at least one div that does
				var cssdisplay=(jQuery.inArray(this.id, persistopenids)!=-1)? 'block' : 'none'
			}
			else{
				var cssdisplay=this.getAttr('hide')? 'none' : null
			}
			if (urlparamopenids[0]=="all" || jQuery.inArray(this.id, urlparamopenids)!=-1){ //if url parameter string contains the single array element "all", or this div's ID
				cssdisplay='block' //set div to "block", overriding any other setting
			}
			else if (urlparamopenids[0]=="none"){
				cssdisplay='none' //set div to "none", overriding any other setting
			}
			this.$divref.css(ac.generatemap(['height', this.getAttr('height')], ['display', cssdisplay]))
			this.$divref.attr(ac.generatemap(['groupname', this.getAttr('group')], ['fade', this.getAttr('fade')], ['speed', this.getAttr('speed')]))
			if (this.getAttr('group')){ //if this DIV has the "group" attr defined
				var targetgroup=ac.divgroups[this.getAttr('group')] || (ac.divgroups[this.getAttr('group')]={}) //Get settings for this group, or if it no settings exist yet, create blank object to store them in
				targetgroup.count=(targetgroup.count||0)+1 //count # of DIVs within this group
				if (jQuery.inArray(this.id, urlparamopenids)!=-1){ //if url parameter string contains this div's ID
					targetgroup.lastactivedivid=this.id //remember this DIV as the last "active" DIV (this DIV will be expanded). Overrides other settings
					targetgroup.overridepersist=1 //Indicate to override persisted div that would have been expanded
				}
				if (!targetgroup.lastactivedivid && this.$divref.css('display')!='none' || cssdisplay=="block" && typeof targetgroup.overridepersist=="undefined") //if this DIV was open by default or should be open due to persistence								
					targetgroup.lastactivedivid=this.id //remember this DIV as the last "active" DIV (this DIV will be expanded)
				this.$divref.css({display:'none'}) //hide any DIV that's part of said group for now
			}
		}) //end divholders.each
		jQuery.each(ac.divgroups, function(){ //loop through each group
			if (this.lastactivedivid && urlparamopenids[0]!="none") //show last "active" DIV within each group (one that should be expanded), unless url param="none"
				ac.divholders[this.lastactivedivid].$divref.show()
		})
		if (animatedcollapse.ontoggle){
			jQuery.each(ac.divholders, function(){ //loop through each collapsible DIV object and fire ontoggle event
				animatedcollapse.ontoggle(jQuery, this.$divref.get(0), this.$divref.css('display'))
			})
		}
 		//Parse page for links containing rel attribute
		var $allcontrols=$('a[rel]').filter('[rel^="collapse["], [rel^="expand["], [rel^="toggle["]') //get all elements on page with rel="collapse[]", "expand[]" and "toggle[]"
		$allcontrols.each(function(){ //loop though each control link
			this._divids=this.getAttribute('rel').replace(/(^\w+)|(\s+)/g, "").replace(/[\[\]']/g, "") //cache value 'div1,div2,etc' within identifier[div1,div2,etc]
			if (this.getElementsByTagName('img').length==1 && ac.divholders[this._divids]){ //if control is an image link that toggles a single DIV (must be one to one to update status image)
				animatedcollapse.preloadimage(this.getAttribute('data-openimage'), this.getAttribute('data-closedimage')) //preload control images (if defined)
				$togglerimage=$(this).find('img').eq(0).data('srcs', {open:this.getAttribute('data-openimage'), closed:this.getAttribute('data-closedimage')}) //remember open and closed images' paths
				ac.divholders[this._divids].$togglerimage=$(this).find('img').eq(0) //save reference to toggler image (to be updated inside slideengine()
				ac.divholders[this._divids].$togglerimage.attr('src', (ac.divholders[this._divids].$divref.css('display')=="none")? $togglerimage.data('srcs').closed : $togglerimage.data('srcs').open)
			}
			$(this).click(function(){ //assign click behavior to each control link
				var relattr=this.getAttribute('rel')
				var divids=(this._divids=="")? [] : this._divids.split(',') //convert 'div1,div2,etc' to array 
				if (divids.length>0){
					animatedcollapse[/expand/i.test(relattr)? 'show' : /collapse/i.test(relattr)? 'hide' : 'toggle'](divids) //call corresponding public function
					return false
				}
			}) //end control.click
		})// end control.each

		$(window).bind('unload', function(){
			ac.uninit()
		})
	}) //end doc.ready()
},

uninit:function(){
	var opendivids='', groupswithpersist=''
	jQuery.each(this.divholders, function(){
		if (this.$divref.css('display')!='none'){
			opendivids+=this.id+',' //store ids of DIVs that are expanded when page unloads: 'div1,div2,etc'
		}
		if (this.getAttr('group') && this.getAttr('persist'))
			groupswithpersist+=this.getAttr('group')+',' //store groups with which at least one DIV has persistance enabled: 'group1,group2,etc'
	})
	opendivids=(opendivids=='')? 'nada' : opendivids.replace(/,$/, '')
	groupswithpersist=(groupswithpersist=='')? 'nada' : groupswithpersist.replace(/,$/, '')
	this.setCookie('acopendivids', opendivids)
	this.setCookie('acgroupswithpersist', groupswithpersist)
},

getCookie:function(Name){ 
	var re=new RegExp(Name+"=[^;]*", "i"); //construct RE to search for target name/value pair
	if (document.cookie.match(re)) //if cookie found
		return document.cookie.match(re)[0].split("=")[1] //return its value
	return null
},

setCookie:function(name, value, days){
	if (typeof days!="undefined"){ //if set persistent cookie
		var expireDate = new Date()
		expireDate.setDate(expireDate.getDate()+days)
		document.cookie = name+"="+value+"; path=/; expires="+expireDate.toGMTString()
	}
	else //else if this is a session only cookie
		document.cookie = name+"="+value+"; path=/"
},

urlparamselect:function(){
	window.location.search.match(/expanddiv=([\w\-_,]+)/i) //search for expanddiv=divid or divid1,divid2,etc
	return (RegExp.$1!="")? RegExp.$1.split(",") : []
},

preloadimage:function(){
	var preloadimages=this.preloadimages
	for (var i=0; i<arguments.length; i++){
		if (arguments[i] && arguments[i].length>0){
			preloadimages[preloadimages.length]=new Image()
			preloadimages[preloadimages.length-1].src=arguments[i]
		}
	}
}

};
function setClassName(what, name) {
  if (document.getElementById) {	
	document.getElementById(what).className = name;
  }
}

function highlight(what, on, facultad) {
	var prefix = what.substring(0, 1);
	what = what.substring(1,3);
	facultad+="";
	switch (prefix) {
		case "a":
				setClassName("b"+what, (on ? "enlacefacultad"+facultad+"_hover" : "enlacefacultad"+facultad));							
 			break;
		case "b":
			if (what.length==1) what="0"+what;
			setClassName("b"+what, (on ? "highlight" : "text"));
			facultades=facultad.split(",");			
			for (i=0;i<facultades.length;i++){	
			if (facultades[i]!="") {
				if (on)
					document.getElementById("liarea"+facultades[i]).setAttribute("id","liarea"+facultades[i]+"_hover");
				else
					document.getElementById("liarea"+facultades[i]+"_hover").setAttribute("id","liarea"+facultades[i]);			
				}			
			}
			break;
		case "d":
			if (on)
				document.getElementById("liarea"+parseInt(what)).setAttribute("id","liarea"+parseInt(what)+"_hover");	
			else
				document.getElementById("liarea"+parseInt(what)+"_hover").setAttribute("id","liarea"+parseInt(what));				

			switch (parseInt(what)) {
				case 1: //Artes y Dise�o
					highlight("a02", on, "1");
					highlight("a03", on, "1");
					highlight("a05", on, "1");
					highlight("a08", on, "1");
					highlight("a94", on, "1");
					highlight("a92", on, "1");					
					highlight("a93", on, "1");						
					highlight("a95", on, "1");
					highlight("a98", on, "1");													
					break;
				case 2://Ciencias Naturales y de la Salud
					highlight("a04", on, "2");
					highlight("a06", on, "2");
                    highlight("a13", on, "2");
					highlight("a16", on, "2");
                    highlight("a17", on, "2");
                    highlight("a18", on, "2");
					highlight("a19", on, "2");
					highlight("a92", on, "2");					
					highlight("a93", on, "2");										
					highlight("a95", on, "2");
					highlight("a97", on, "2");					
					break;					
				case 3://Ciencias Sociales y Humanidades
					highlight("a07", on, "3");
					highlight("a14", on, "3");
					highlight("a15", on, "3");
					highlight("a19", on, "3");					
					highlight("a92", on, "3");					
					highlight("a93", on, "3");										
					highlight("a95", on, "3");	
					highlight("a99", on, "3");					
					break;
				case 4://Ingenier�as y Administraci�n
					highlight("a01", on, "4");
					highlight("a05", on, "4");					
					highlight("a09", on, "4");
					highlight("a10", on, "4");
					highlight("a11", on, "4");
					highlight("a12", on, "4");
					highlight("a96", on, "4");					
					highlight("a92", on, "4");					
					highlight("a93", on, "4");										
					highlight("a95", on, "4");
					highlight("a97", on, "4");	
					highlight("a98", on, "4");	
			
					break;
			}
			break;
		case "e":
			if (on)
				document.getElementById("liarea"+parseInt(what)).setAttribute("id","liarea"+parseInt(what)+"_hover");	
			else
				document.getElementById("liarea"+parseInt(what)+"_hover").setAttribute("id","liarea"+parseInt(what));			
			switch (parseInt(what)) {				
				case 5: //Educacion
					highlight("c33", on, "5");
					highlight("c35", on, "5");				
					break;
				case 6://Ingenierias
					highlight("c43", on, "6");
					highlight("c44", on, "6");
					highlight("c81", on, "6");
					highlight("c85", on, "6");
					highlight("c86", on, "6");					
					break;					
				case 7://Interdisciplinarios
					highlight("c23", on, "7");
					highlight("c37", on, "7");
					highlight("c38", on, "7");
					highlight("c39", on, "7");
					highlight("c40", on, "7");
					highlight("c42", on, "7");
					highlight("c46", on, "7");
					highlight("c79", on, "7");
					highlight("c80", on, "7");															
					break;
				case 8://Medicina
					highlight("c20", on, "8");
					highlight("c21", on, "8");
					highlight("c22", on, "8");
					highlight("c24", on, "8");
					highlight("c25", on, "8");
					highlight("c26", on, "8");
					highlight("c27", on, "8");
					highlight("c28", on, "8");
					highlight("c29", on, "8");
					highlight("c31", on, "8");
					highlight("c32", on, "8");
					highlight("c34", on, "8");
					highlight("c41", on, "8");
					highlight("c45", on, "8");
					highlight("c47", on, "8");
					highlight("c48", on, "8");
					highlight("c49", on, "8");
					highlight("c50", on, "8");
					highlight("c51", on, "8");
					highlight("c52", on, "8");
					highlight("c54", on, "8");
					highlight("c55", on, "8");
					highlight("c56", on, "8");
					highlight("c57", on, "8");
					highlight("c58", on, "8");
					highlight("c59", on, "8");
					highlight("c61", on, "8");
					highlight("c62", on, "8");
					highlight("c65", on, "8");
					highlight("c67", on, "8");
					highlight("c76", on, "8");
					highlight("c77", on, "8");
					highlight("c78", on, "8");
					highlight("c82", on, "8");				
					highlight("c83", on, "8");
					highlight("c84", on, "8");
					highlight("c97", on, "8");					
					break;
				case 9://Odontologia
					highlight("c30", on, "9");
					highlight("c36", on, "9");
					highlight("c60", on, "9");
					highlight("c63", on, "9");
					highlight("c64", on, "9");
					highlight("c66", on, "9");
					highlight("c68", on, "9");
					highlight("c69", on, "9");								
					break;
				case 10://Psicologia
					highlight("c70", on, "10");
					highlight("c71", on, "10");					
					highlight("c72", on, "10");
					highlight("c73", on, "10");
					highlight("c74", on, "10");
					highlight("c75", on, "10");
					break;
			}
			break;				
		case "c":
			setClassName("f"+what, (on ? "highlight2" : "text"));
			break;
		case "f":
			if (what.length==1) what="0"+what;
			setClassName("f"+what, (on ? "highlight2" : "text"));
			facultades=facultad.split(",");
			
			for (i=0;i<facultades.length;i++){			
			if (on)
				document.getElementById("liarea"+facultades[i]).setAttribute("id","liarea"+facultades[i]+"_hover");	
			else
				document.getElementById("liarea"+facultades[i]+"_hover").setAttribute("id","liarea"+facultades[i]);			
			}			
			break;
	}
	
};

		   </script>
                <script type="text/javascript">
                <!--//--><![CDATA[//><!--
                jQuery.extend(Drupal.settings, {"basePath":"\/","dhtmlMenu":{"slide":"slide","siblings":"siblings","relativity":"relativity","children":"children","clone":0,"doubleclick":0},"fivestar":{"titleUser":"Su puntuaci\u00f3n: ","titleAverage":"Promedio: ","feedbackSavingVote":"Guardando su voto....","feedbackVoteSaved":"Su voto ha sido guardado","feedbackDeletingVote":"Eliminando tu voto...","feedbackVoteDeleted":"Su voto ha sido eliminado"},"googleanalytics":{"trackOutgoing":1,"trackMailto":1,"trackDownload":1,"trackDownloadExtensions":"7z|aac|arc|arj|asf|asx|avi|bin|csv|doc|exe|flv|gif|gz|gzip|hqx|jar|jpe?g|js|mp(2|3|4|e?g)|mov(ie)?|msi|msp|pdf|phps|png|ppt|qtm?|ra(m|r)?|sea|sit|tar|tgz|torrent|txt|wav|wma|wmv|wpd|xls|xml|z|zip"},"lightbox2":{"rtl":"0","file_path":"\/(\\w\\w\/)sites\/default\/files","default_image":"\/sites\/default\/modules\/lightbox2\/images\/brokenimage.jpg","border_size":0,"font_color":"000","box_color":"fff","top_position":"","overlay_opacity":"0.8","overlay_color":"000","disable_close_click":1,"resize_sequence":0,"resize_speed":400,"fade_in_speed":400,"slide_down_speed":600,"use_alt_layout":0,"disable_resize":0,"disable_zoom":0,"force_show_nav":0,"show_caption":1,"loop_items":0,"node_link_text":"","node_link_target":0,"image_count":"Image !current of !total","video_count":"Video !current of !total","page_count":"Page !current of !total","lite_press_x_close":"press \u003ca href=\"#\" onclick=\"hideLightbox(); return FALSE;\"\u003e\u003ckbd\u003ex\u003c\/kbd\u003e\u003c\/a\u003e to close","download_link_text":"","enable_login":false,"enable_contact":false,"keys_close":"c x 27","keys_previous":"p 37","keys_next":"n 39","keys_zoom":"z","keys_play_pause":"32","display_image_size":"original","image_node_sizes":"(\\.thumbnail)","trigger_lightbox_classes":"img.inline,img.thumbnail, img.image-thumbnail","trigger_lightbox_group_classes":"","trigger_slideshow_classes":"img.ImageFrame_image,img.ImageFrame_none","trigger_lightframe_classes":"","trigger_lightframe_group_classes":"","custom_class_handler":0,"custom_trigger_classes":"","disable_for_gallery_lists":1,"disable_for_acidfree_gallery_lists":true,"enable_acidfree_videos":true,"slideshow_interval":5000,"slideshow_automatic_start":0,"slideshow_automatic_exit":0,"show_play_pause":0,"pause_on_next_click":0,"pause_on_previous_click":0,"loop_slides":1,"iframe_width":766,"iframe_height":400,"iframe_border":0,"enable_video":0},"beautytips":{"calendar-tooltips":{"fill":"#F7F7F7","padding":8,"strokeStyle":"#B7B7B7","cornerRadius":0,"cssStyles":{"fontFamily":"\"lucida grande\",tahoma,verdana,arial,sans-serif","fontSize":"11px"},"cssSelect":".calendar-calendar .mini-day-on a, .calendar-calendar .day a, .calendar-calendar .mini-day-on span, .calendar-calendar .day span","contentSelector":"$(this).next().html()","trigger":["mouseover","mouseout"],"list":["fill","padding","strokeStyle","cornerRadius","cssStyles","contentSelector","trigger"]}}});
                //--><!]]>
                
                </script>
            
    </head>
     <body class="not-front not-logged-in page-node node-type-webform no-sidebars i18n-es not-front not-logged-in cuerpo_sin_promo cuerpo_sin_menu page-node-1">
    
         <!-- Layout -->
  <div id="sticky_footer-body">
	
	<!--<div id="encabezado" style="height:30px">
		<div class="cajon">
		<a href="/" title="Ir a la p&aacute;gina principal"><img src="http://www.uelbosque.edu.co/sites/default/themes/ueb/images/logotipo_ueb.png" alt="" id="logo" /></a>    	
        			<div id="herramientas">  
</div>        		
		</div>
	</div>-->

    <div class="cajon grueso" style="padding-top:47px;">
    	<!-- menu -->
        <div style="position:relative; float:left;">
				        </div> 
		<div class="contenedor">
			<!-- destacados -->
				  
			<div id="grueso">
                            <div class="messages error" id="msgError" style="display:none;"> El campo ¿Conoces sobre el proceso de Autoevaluación Institucional que vivimos actualmente? es obligatorio.</div>
								<!-- grueso -->
				  <div id="block-block-185" class="clear-block block block-block">
    	
    <div class="content">

    </div>
</div>
            <div id="node-2922" class="node webform">
                    <h2>Entre todos seguimos construyendo una mejor Universidad</h2>

                <div class="content entre todos seguimos construyendo una mejor universidad">
                <form enctype="multipart/form-data" class="webform-client-form" id="webform-client-form-2922" method="post" accept-charset="UTF-8" action="http://www.uelbosque.edu.co/content/entre-todos-seguimos-construyendo-una-mejor-universidad" target="POPUPW">
                    <div><div id="webform-component-conoces-sobre-el-proceso-de-autoevaluacion-institucional-que-vivimos-actualmente" class="webform-component webform-component-radios"><div class="form-item">
                    <label>¿Conoces sobre el proceso de Autoevaluación Institucional que vivimos actualmente?: <span title="Este campo es obligatorio." class="form-required">*</span></label>
                    <div class="form-radios"><div id="edit-submitted-conoces-sobre-el-proceso-de-autoevaluacion-institucional-que-vivimos-actualmente-1-wrapper" class="form-item">
                    <label for="edit-submitted-conoces-sobre-el-proceso-de-autoevaluacion-institucional-que-vivimos-actualmente-1" class="option"><input type="radio" class="form-radio" value="si" name="submitted[conoces_sobre_el_proceso_de_autoevaluacion_institucional_que_vivimos_actualmente]" id="edit-submitted-conoces-sobre-el-proceso-de-autoevaluacion-institucional-que-vivimos-actualmente-1"> Sí</label>
                    </div>
                    <div id="edit-submitted-conoces-sobre-el-proceso-de-autoevaluacion-institucional-que-vivimos-actualmente-2-wrapper" class="form-item">
                    <label for="edit-submitted-conoces-sobre-el-proceso-de-autoevaluacion-institucional-que-vivimos-actualmente-2" class="option"><input type="radio" class="form-radio" value="no" name="submitted[conoces_sobre_el_proceso_de_autoevaluacion_institucional_que_vivimos_actualmente]" id="edit-submitted-conoces-sobre-el-proceso-de-autoevaluacion-institucional-que-vivimos-actualmente-2"> No</label>
                    </div>
                    </div>
                    </div>
                    </div><div id="webform-component-por-que-medio-te-enteraste" class="webform-component webform-component-checkboxes"><div class="form-item">
                    <label>¿Por qué medio conoces sobre este proceso?: </label>
                    <div class="form-checkboxes"><div id="edit-submitted-por-que-medio-te-enteraste-1-wrapper" class="form-item">
                    <label for="edit-submitted-por-que-medio-te-enteraste-1" class="option"><input type="checkbox" class="form-checkbox" value="sitio_web" id="edit-submitted-por-que-medio-te-enteraste-1" name="submitted[por_que_medio_te_enteraste][sitio_web]"> Sitio web</label>
                    </div>
                    <div id="edit-submitted-por-que-medio-te-enteraste-2-wrapper" class="form-item">
                    <label for="edit-submitted-por-que-medio-te-enteraste-2" class="option"><input type="checkbox" class="form-checkbox" value="redes_sociales" id="edit-submitted-por-que-medio-te-enteraste-2" name="submitted[por_que_medio_te_enteraste][redes_sociales]"> Redes Sociales</label>
                    </div>
                    <div id="edit-submitted-por-que-medio-te-enteraste-3-wrapper" class="form-item">
                    <label for="edit-submitted-por-que-medio-te-enteraste-3" class="option"><input type="checkbox" class="form-checkbox" value="correo_institucional" id="edit-submitted-por-que-medio-te-enteraste-3" name="submitted[por_que_medio_te_enteraste][correo_institucional]"> Correo institucional</label>
                    </div>
                    <div id="edit-submitted-por-que-medio-te-enteraste-4-wrapper" class="form-item">
                    <label for="edit-submitted-por-que-medio-te-enteraste-4" class="option"><input type="checkbox" class="form-checkbox" value="afiches_impresos" id="edit-submitted-por-que-medio-te-enteraste-4" name="submitted[por_que_medio_te_enteraste][afiches_impresos]"> Afiches impresos</label>
                    </div>
                    <div id="edit-submitted-por-que-medio-te-enteraste-5-wrapper" class="form-item">
                    <label for="edit-submitted-por-que-medio-te-enteraste-5" class="option"><input type="checkbox" class="form-checkbox" value="charlas" id="edit-submitted-por-que-medio-te-enteraste-5" name="submitted[por_que_medio_te_enteraste][charlas]"> Charlas</label>
                    </div>
                    <div id="edit-submitted-por-que-medio-te-enteraste-6-wrapper" class="form-item">
                    <label for="edit-submitted-por-que-medio-te-enteraste-6" class="option"><input type="checkbox" class="form-checkbox" value="voz_voz" id="edit-submitted-por-que-medio-te-enteraste-6" name="submitted[por_que_medio_te_enteraste][voz_voz]"> Voz a voz</label>
                    </div>
                    </div>
                    </div>
                    </div><div id="webform-component-por-que-otro-medio-te-gustaria-recibir-informacion" class="webform-component webform-component-textfield"><div id="edit-submitted-por-que-otro-medio-te-gustaria-recibir-informacion-wrapper" class="form-item">
                    <label for="edit-submitted-por-que-otro-medio-te-gustaria-recibir-informacion">¿Por qué otro medio te gustaría recibir información?: </label>
                    <input type="text" class="form-text" value="" size="60" id="edit-submitted-por-que-otro-medio-te-gustaria-recibir-informacion" name="submitted[por_que_otro_medio_te_gustaria_recibir_informacion]" maxlength="128">
                    </div>
                    </div><input type="hidden" value="" id="edit-details-sid" name="details[sid]">
                    <input type="hidden" value="1" id="edit-details-page-num" name="details[page_num]">
                    <input type="hidden" value="1" id="edit-details-page-count" name="details[page_count]">
                    <input type="hidden" value="0" id="edit-details-finished" name="details[finished]">
                    <input type="hidden" value="form-60edd81ad6a1148e27885ed6213b3135" id="form-60edd81ad6a1148e27885ed6213b3135" name="form_build_id">
                    <input type="hidden" value="webform_client_form_2922" id="edit-webform-client-form-2922" name="form_id">
                    <div class="form-actions form-wrapper" id="edit-actions"><input type="submit" class="form-submit loading" value="Enviar" id="edit-submit-1" name="op" style="font-weight: bold;padding: 1px 5px 5px;font-size:1.1em;">
                    <img class="hidden loading" style="position:relative;left:25px;top:0px" src="ajax-loader2.gif" />
					</div>
                    </div></form>
                </div>
            <div class="clear-block">
    <div class="meta">
        </div>
    

      </div>

</div>

				<!-- grueso inferior-->
				 
			</div>
	
			<!-- promocional -->
			        <!-- promocional para programas -->
					
		</div>
	</div>
	<div id="stycky_footer-push"></div>
  </div>
  <div id="stycky_footer-footer">
	<!-- Pie -->
			<div id="pie" >  <div id="block-block-7" class="clear-block block block-block">
    	
    <div class="content">
      <div style="background-color:#3E4729;position:relative;">
<p style="text-align:center;">Av. Cra 9 No. 131 A - 02 • Edificio Fundadores • Línea Gratuita 018000 113033 • PBX (571) 6489000 • Bogotá D.C. - Colombia.</p>
</div>
    </div>
</div>
</div>
	  </div>
         
         <script type="text/javascript">
                        $('img.loading').each(function() {
                             //$(this).removeClass('hidden');
                             $(this).css("display","none");                             
                        });
						
    $(':submit').click(function(event) {
        event.preventDefault();
                
        if($('input[name="submitted[conoces_sobre_el_proceso_de_autoevaluacion_institucional_que_vivimos_actualmente]"]:checked').val()=="" ||
        $('input[name="submitted[conoces_sobre_el_proceso_de_autoevaluacion_institucional_que_vivimos_actualmente]"]:checked').val()==undefined){
            $('#msgError').css("display","block");  
        } else {
            $('#msgError').css("display","none");
            /*POPUPW = window.open('about:blank','POPUPW','width=5,height=5,status=no,resizable=no,scrollbars=no');
                            
            if (POPUPW == null || typeof(POPUPW)=='undefined' || POPUPW.closed || parseInt(POPUPW.innerWidth) == 0) { 	
                    alert('Pot favor habilita las ventanas emergentes en tu navegador y haz clic en enviar de nuevo.'); 
            } else {*/
                crossDomainPost();
                        
                        $('input.loading').each(function() {
                             //$(this).removeClass('hidden');
                             $(this).css("display","none");
                        });   
                        
                        $('img.loading').each(function() {
                             //$(this).removeClass('hidden');
                             $(this).css("display","block");                             
                        });			
                
            //}      
          
        }
    });

		function crossDomainPost() {
		  // Add the iframe with a unique name
		  var iframe = document.createElement("iframe");
		  var uniqueString = "ENCUESTAWEB";
		  document.body.appendChild(iframe);
		  iframe.style.display = "none";
		  iframe.setAttribute('id', uniqueString+"frame");
		  iframe.contentWindow.name = uniqueString;

		  // construct a form with hidden inputs, targeting the iframe
		  var form = document.createElement("form");
		  form.target = uniqueString;
		  form.action = "http://www.uelbosque.edu.co/content/entre-todos-seguimos-construyendo-una-mejor-universidad";
		  form.method = "POST";
		  form.setAttribute('enctype', "multipart/form-data");
		  form.setAttribute('class', "webform-client-form");
		  form.setAttribute('id', "webform-client-form-2922");
		  form.setAttribute('accept-charset', "UTF-8");

		  // repeat for each parameter
		  var input = document.createElement("input");
		  input.type = "hidden";
		  input.name = "submitted[conoces_sobre_el_proceso_de_autoevaluacion_institucional_que_vivimos_actualmente]";
		  input.value = $('input[name="submitted[conoces_sobre_el_proceso_de_autoevaluacion_institucional_que_vivimos_actualmente]"]:checked').val();
		  form.appendChild(input);
                  
                  var mediosDivulgacion = "";
		  
		  if($('input[name="submitted[por_que_medio_te_enteraste][sitio_web]"]').is(':checked')){
			  var input = document.createElement("input");
			  input.type = "hidden";
			  input.name = "submitted[por_que_medio_te_enteraste][sitio_web]";
			  input.value = $('input[name="submitted[por_que_medio_te_enteraste][sitio_web]"]').val();
			  form.appendChild(input);
                          if(mediosDivulgacion==""){
                              mediosDivulgacion = $('input[name="submitted[por_que_medio_te_enteraste][sitio_web]"]').val();
                          } else {
                              mediosDivulgacion = mediosDivulgacion + "," + $('input[name="submitted[por_que_medio_te_enteraste][sitio_web]"]').val();
                          }
		  }
		  
		  if($('input[name="submitted[por_que_medio_te_enteraste][redes_sociales]"]').is(':checked')){
			  var input = document.createElement("input");
			  input.type = "hidden";
			  input.name = "submitted[por_que_medio_te_enteraste][redes_sociales]";
			  input.value = $('input[name="submitted[por_que_medio_te_enteraste][redes_sociales]"]').val();
			  form.appendChild(input);
                          if(mediosDivulgacion==""){
                              mediosDivulgacion = $('input[name="submitted[por_que_medio_te_enteraste][redes_sociales]"]').val();
                          } else {
                              mediosDivulgacion = mediosDivulgacion + "," + $('input[name="submitted[por_que_medio_te_enteraste][redes_sociales]"]').val();
                          }
		  }
		  
		  if($('input[name="submitted[por_que_medio_te_enteraste][correo_institucional]"]').is(':checked')){
			  var input = document.createElement("input");
			  input.type = "hidden";
			  input.name = "submitted[por_que_medio_te_enteraste][correo_institucional]";
			  input.value = $('input[name="submitted[por_que_medio_te_enteraste][correo_institucional]"]').val();
			  form.appendChild(input);
                          if(mediosDivulgacion==""){
                              mediosDivulgacion = $('input[name="submitted[por_que_medio_te_enteraste][correo_institucional]"]').val();
                          } else {
                              mediosDivulgacion = mediosDivulgacion + "," + $('input[name="submitted[por_que_medio_te_enteraste][correo_institucional]"]').val();
                          }
			}
		  
		  if($('input[name="submitted[por_que_medio_te_enteraste][afiches_impresos]"]').is(':checked')){
			  var input = document.createElement("input");
			  input.type = "hidden";
			  input.name = "submitted[por_que_medio_te_enteraste][afiches_impresos]";
			  input.value = $('input[name="submitted[por_que_medio_te_enteraste][afiches_impresos]"]').val();
			  form.appendChild(input);
                          if(mediosDivulgacion==""){
                              mediosDivulgacion = $('input[name="submitted[por_que_medio_te_enteraste][afiches_impresos]"]').val();
                          } else {
                              mediosDivulgacion = mediosDivulgacion + "," + $('input[name="submitted[por_que_medio_te_enteraste][afiches_impresos]"]').val();
                          }
			}
		  
		  if($('input[name="submitted[por_que_medio_te_enteraste][charlas]"]').is(':checked')){
			  var input = document.createElement("input");
			  input.type = "hidden";
			  input.name = "submitted[por_que_medio_te_enteraste][charlas]";
			  input.value = $('input[name="submitted[por_que_medio_te_enteraste][charlas]"]').val();
			  form.appendChild(input);
                          if(mediosDivulgacion==""){
                              mediosDivulgacion = $('input[name="submitted[por_que_medio_te_enteraste][charlas]"]').val();
                          } else {
                              mediosDivulgacion = mediosDivulgacion + "," + $('input[name="submitted[por_que_medio_te_enteraste][charlas]"]').val();
                          }
			}
		  
		  if($('input[name="submitted[por_que_medio_te_enteraste][voz_voz]"]').is(':checked')){
			  var input = document.createElement("input");
			  input.type = "hidden";
			  input.name = "submitted[por_que_medio_te_enteraste][voz_voz]";
			  input.value = $('input[name="submitted[por_que_medio_te_enteraste][voz_voz]"]').val();
			  form.appendChild(input);
                          if(mediosDivulgacion==""){
                              mediosDivulgacion = $('input[name="submitted[por_que_medio_te_enteraste][voz_voz]"]').val();
                          } else {
                              mediosDivulgacion = mediosDivulgacion + "," + $('input[name="submitted[por_que_medio_te_enteraste][voz_voz]"]').val();
                          }
		}		  
		  
		  var input = document.createElement("input");
		  input.type = "hidden";
		  input.name = "submitted[por_que_otro_medio_te_gustaria_recibir_informacion]";
		  input.value = $('input[name="submitted[por_que_otro_medio_te_gustaria_recibir_informacion]"]').val();
		  form.appendChild(input);
		  
		  var input = document.createElement("input");
		  input.type = "hidden";
		  input.name = "details[sid]";
		  input.value = "";
		  form.appendChild(input);
		  
		  var input = document.createElement("input");
		  input.type = "hidden";
		  input.name = "details[page_num]";
		  input.value = "1";
		  form.appendChild(input);
		  
		  var input = document.createElement("input");
		  input.type = "hidden";
		  input.name = "details[page_count]";
		  input.value = "1";
		  form.appendChild(input);
		  
		  var input = document.createElement("input");
		  input.type = "hidden";
		  input.name = "details[finished]";
		  input.value = "0";
		  form.appendChild(input);
		  
		  var input = document.createElement("input");
		  input.type = "hidden";
		  input.name = "form_build_id";
		  input.value = "form-b8b292393d232b5dd18c62c4c068e9eb";
		  form.appendChild(input);
		  
		  var input = document.createElement("input");
		  input.type = "hidden";
		  input.name = "form_id";
		  input.value = "webform_client_form_2922";
		  form.appendChild(input);
		  
		  var input = document.createElement("input");
		  input.type = "hidden";
		  input.name = "op";
		  input.value = "Enviar";
		  form.appendChild(input);
		  
		  document.body.appendChild(form);
		  form.submit();
		  
		  $('#ENCUESTAWEBframe').load(function() {
			//guardar que el usuario ya lleno la info
                       var conoceProceso = $('input[name="submitted[conoces_sobre_el_proceso_de_autoevaluacion_institucional_que_vivimos_actualmente]"]:checked').val();
                       var otrosMedios = $('input[name="submitted[por_que_otro_medio_te_gustaria_recibir_informacion]"]').val();
                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: 'process.php',
                    data: { usuario: "<?php echo $usuario; ?>", periodo: "<?php echo $periodo; ?>", conoceProceso: conoceProceso, otrosMedios: otrosMedios, mediosDivulgacion:mediosDivulgacion},                
                    success:function(data){
                        if (data.success == true){							
                            //$('#webform-client-form-2922').submit();
                            
							submitPop = window.open('http://www.uelbosque.edu.co/node/2922/done?sid=2441','submitPop','width=980,height=650,status=no,resizable=yes,scrollbars=yes');
  							if (submitPop == null || typeof(submitPop)=='undefined' || submitPop.closed || parseInt(submitPop.innerWidth) == 0) { 	
									redirectmywindow()();
							} else {
								checkmywindow();
							}
							/*$(POPUPW.document).ready(
							   function() { if(POPUPW.location.href=="http://www.uelbosque.edu.co/node/2922/done?sid=2444"){
							   	   POPUPW.close();   setTimeout("checkmysubmit();", 200);
									} else {
											//para poner la ventana en frente
											window.focus();
											submitPop.focus();
									}
							   }
							);

                            checkmywindow();*/
                        }
                    },
                    error: function(data,error,errorThrown){alert(error + errorThrown);}
                }); 
		});
	}		
	
    
    function checkmywindow()
    {
        if(submitPop.closed)
        {
            //alert("la cerre");
            <?php //if($result["codigotipousuario"]!=600){ ?>
                    window.parent.continuar2("../facultades/central.php");
                //parent.window.frames[0].location.href=    "../facultades/facultadeslv2.php";
                //window.location.href="../facultades/central.php";
                //window.location.href="../facultades/facultadeslv2.php";
                <?php //}else { ?>
                //window.location.href="../encuesta/encuestaestudiantesnuevos/validaingresoestudiante.php?idencuesta=50&idusuario=<?PHP echo $_REQUEST["idusuario"]; ?>&codigotipousuario=600";
                <?php //} ?>
            
        }
        else
        {
            setTimeout("checkmywindow();", 1000);
        }
    }  
	
	function redirectmywindow()
    {
            <?php //if($result["codigotipousuario"]!=600){ ?>
                    window.parent.continuar2("../facultades/central.php");
                //parent.window.frames[0].location.href=    "../facultades/facultadeslv2.php";
                //window.location.href="../facultades/central.php";
                //window.location.href="../facultades/facultadeslv2.php";
                <?php //}else { ?>
                //window.location.href="../encuesta/encuestaestudiantesnuevos/validaingresoestudiante.php?idencuesta=50&idusuario=<?PHP echo $_REQUEST["idusuario"]; ?>&codigotipousuario=600";
                <?php //} ?>
    }
    
    </script>
        </body>
</html>
