ï»¿/* Arabic Translation for jQuery UI date picker plugin. */
/* Khaled Al Horani -- koko.dw@gmail.com */
/* Ø®Ø§ÙØ¯ Ø§ÙØ­ÙØ±Ø§ÙÙ -- koko.dw@gmail.com */
/* NOTE: monthNames are the original months names and they are the Arabic names, not the new months name ÙØ¨Ø±Ø§ÙØ± - ÙÙØ§ÙØ± and there isn't any Arabic roots for these months */
jQuery(function($){
	$.datepicker.regional['ar'] = {
		closeText: 'Ø¥ØºÙØ§Ù',
		prevText: '&#x3c;Ø§ÙØ³Ø§Ø¨Ù',
		nextText: 'Ø§ÙØªØ§ÙÙ&#x3e;',
		currentText: 'Ø§ÙÙÙÙ',
		monthNames: ['ÙØ§ÙÙÙ Ø§ÙØ«Ø§ÙÙ', 'Ø´Ø¨Ø§Ø·', 'Ø¢Ø°Ø§Ø±', 'ÙÙØ³Ø§Ù', 'Ø¢Ø°Ø§Ø±', 'Ø­Ø²ÙØ±Ø§Ù',
		'ØªÙÙØ²', 'Ø¢Ø¨', 'Ø£ÙÙÙÙ',	'ØªØ´Ø±ÙÙ Ø§ÙØ£ÙÙ', 'ØªØ´Ø±ÙÙ Ø§ÙØ«Ø§ÙÙ', 'ÙØ§ÙÙÙ Ø§ÙØ£ÙÙ'],
		monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12'],
		dayNames: ['Ø§ÙØ³Ø¨Øª', 'Ø§ÙØ£Ø­Ø¯', 'Ø§ÙØ§Ø«ÙÙÙ', 'Ø§ÙØ«ÙØ§Ø«Ø§Ø¡', 'Ø§ÙØ£Ø±Ø¨Ø¹Ø§Ø¡', 'Ø§ÙØ®ÙÙØ³', 'Ø§ÙØ¬ÙØ¹Ø©'],
		dayNamesShort: ['Ø³Ø¨Øª', 'Ø£Ø­Ø¯', 'Ø§Ø«ÙÙÙ', 'Ø«ÙØ§Ø«Ø§Ø¡', 'Ø£Ø±Ø¨Ø¹Ø§Ø¡', 'Ø®ÙÙØ³', 'Ø¬ÙØ¹Ø©'],
		dayNamesMin: ['Ø³Ø¨Øª', 'Ø£Ø­Ø¯', 'Ø§Ø«ÙÙÙ', 'Ø«ÙØ§Ø«Ø§Ø¡', 'Ø£Ø±Ø¨Ø¹Ø§Ø¡', 'Ø®ÙÙØ³', 'Ø¬ÙØ¹Ø©'],
		dateFormat: 'dd/mm/yy', firstDay: 0,
  isRTL: true};
	$.datepicker.setDefaults($.datepicker.regional['ar']);
});ï»¿/* Bulgarian initialisation for the jQuery UI date picker plugin. */
/* Written by Stoyan Kyosev (http://svest.org). */
jQuery(function($){
    $.datepicker.regional['bg'] = {
        closeText: 'Ð·Ð°ÑÐ²Ð¾ÑÐ¸',
        prevText: '&#x3c;Ð½Ð°Ð·Ð°Ð´',
        nextText: 'Ð½Ð°Ð¿ÑÐµÐ´&#x3e;',
		nextBigText: '&#x3e;&#x3e;',
        currentText: 'Ð´Ð½ÐµÑ',
        monthNames: ['Ð¯Ð½ÑÐ°ÑÐ¸','Ð¤ÐµÐ²ÑÑÐ°ÑÐ¸','ÐÐ°ÑÑ','ÐÐ¿ÑÐ¸Ð»','ÐÐ°Ð¹','Ð®Ð½Ð¸',
        'Ð®Ð»Ð¸','ÐÐ²Ð³ÑÑÑ','Ð¡ÐµÐ¿ÑÐµÐ¼Ð²ÑÐ¸','ÐÐºÑÐ¾Ð¼Ð²ÑÐ¸','ÐÐ¾ÐµÐ¼Ð²ÑÐ¸','ÐÐµÐºÐµÐ¼Ð²ÑÐ¸'],
        monthNamesShort: ['Ð¯Ð½Ñ','Ð¤ÐµÐ²','ÐÐ°Ñ','ÐÐ¿Ñ','ÐÐ°Ð¹','Ð®Ð½Ð¸',
        'Ð®Ð»Ð¸','ÐÐ²Ð³','Ð¡ÐµÐ¿','ÐÐºÑ','ÐÐ¾Ð²','ÐÐµÐº'],
        dayNames: ['ÐÐµÐ´ÐµÐ»Ñ','ÐÐ¾Ð½ÐµÐ´ÐµÐ»Ð½Ð¸Ðº','ÐÑÐ¾ÑÐ½Ð¸Ðº','Ð¡ÑÑÐ´Ð°','Ð§ÐµÑÐ²ÑÑÑÑÐº','ÐÐµÑÑÐº','Ð¡ÑÐ±Ð¾ÑÐ°'],
        dayNamesShort: ['ÐÐµÐ´','ÐÐ¾Ð½','ÐÑÐ¾','Ð¡ÑÑ','Ð§ÐµÑ','ÐÐµÑ','Ð¡ÑÐ±'],
        dayNamesMin: ['ÐÐµ','ÐÐ¾','ÐÑ','Ð¡Ñ','Ð§Ðµ','ÐÐµ','Ð¡Ñ'],
        dateFormat: 'dd.mm.yy', firstDay: 1,
        isRTL: false};
    $.datepicker.setDefaults($.datepicker.regional['bg']);
});
/* Inicialitzaciï¿½ en catalï¿½ per a l'extenciï¿½ 'calendar' per jQuery. */
/* Writers: (joan.leon@gmail.com). */
jQuery(function($){
	$.datepicker.regional['ca'] = {
		closeText: 'Tancar',
		prevText: '&#x3c;Ant',
		nextText: 'Seg&#x3e;',
		currentText: 'Avui',
		monthNames: ['Gener','Febrer','Mar&ccedil;','Abril','Maig','Juny',
		'Juliol','Agost','Setembre','Octubre','Novembre','Desembre'],
		monthNamesShort: ['Gen','Feb','Mar','Abr','Mai','Jun',
		'Jul','Ago','Set','Oct','Nov','Des'],
		dayNames: ['Diumenge','Dilluns','Dimarts','Dimecres','Dijous','Divendres','Dissabte'],
		dayNamesShort: ['Dug','Dln','Dmt','Dmc','Djs','Dvn','Dsb'],
		dayNamesMin: ['Dg','Dl','Dt','Dc','Dj','Dv','Ds'],
		dateFormat: 'mm/dd/yy', firstDay: 0,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['ca']);
});ï»¿/* Czech initialisation for the jQuery UI date picker plugin. */
/* Written by Tomas Muller (tomas@tomas-muller.net). */
jQuery(function($){
	$.datepicker.regional['cs'] = {
		closeText: 'ZavÅÃ­t',
		prevText: '&#x3c;DÅÃ­ve',
		nextText: 'PozdÄji&#x3e;',
		currentText: 'NynÃ­',
		monthNames: ['leden','Ãºnor','bÅezen','duben','kvÄten','Äerven',
        'Äervenec','srpen','zÃ¡ÅÃ­','ÅÃ­jen','listopad','prosinec'],
		monthNamesShort: ['led','Ãºno','bÅe','dub','kvÄ','Äer',
		'Ävc','srp','zÃ¡Å','ÅÃ­j','lis','pro'],
		dayNames: ['nedÄle', 'pondÄlÃ­', 'ÃºterÃ½', 'stÅeda', 'Ätvrtek', 'pÃ¡tek', 'sobota'],
		dayNamesShort: ['ne', 'po', 'Ãºt', 'st', 'Ät', 'pÃ¡', 'so'],
		dayNamesMin: ['ne','po','Ãºt','st','Ät','pÃ¡','so'],
		dateFormat: 'dd.mm.yy', firstDay: 1,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['cs']);
});
ï»¿/* Danish initialisation for the jQuery UI date picker plugin. */
/* Written by Jan Christensen ( deletestuff@gmail.com). */
jQuery(function($){
    $.datepicker.regional['da'] = {
		closeText: 'Luk',
        prevText: '&#x3c;Forrige',
		nextText: 'NÃ¦ste&#x3e;',
		currentText: 'Idag',
        monthNames: ['Januar','Februar','Marts','April','Maj','Juni',
        'Juli','August','September','Oktober','November','December'],
        monthNamesShort: ['Jan','Feb','Mar','Apr','Maj','Jun',
        'Jul','Aug','Sep','Okt','Nov','Dec'],
		dayNames: ['SÃ¸ndag','Mandag','Tirsdag','Onsdag','Torsdag','Fredag','LÃ¸rdag'],
		dayNamesShort: ['SÃ¸n','Man','Tir','Ons','Tor','Fre','LÃ¸r'],
		dayNamesMin: ['SÃ¸','Ma','Ti','On','To','Fr','LÃ¸'],
        dateFormat: 'dd-mm-yy', firstDay: 0,
		isRTL: false};
    $.datepicker.setDefaults($.datepicker.regional['da']);
});
ï»¿/* German initialisation for the jQuery UI date picker plugin. */
/* Written by Milian Wolff (mail@milianw.de). */
jQuery(function($){
	$.datepicker.regional['de'] = {
		closeText: 'schlieÃen',
		prevText: '&#x3c;zurÃ¼ck',
		nextText: 'Vor&#x3e;',
		currentText: 'heute',
		monthNames: ['Januar','Februar','MÃ¤rz','April','Mai','Juni',
		'Juli','August','September','Oktober','November','Dezember'],
		monthNamesShort: ['Jan','Feb','MÃ¤r','Apr','Mai','Jun',
		'Jul','Aug','Sep','Okt','Nov','Dez'],
		dayNames: ['Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'],
		dayNamesShort: ['So','Mo','Di','Mi','Do','Fr','Sa'],
		dayNamesMin: ['So','Mo','Di','Mi','Do','Fr','Sa'],
		dateFormat: 'dd.mm.yy', firstDay: 1,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['de']);
});
ï»¿/* Greek (el) initialisation for the jQuery UI date picker plugin. */
/* Written by Alex Cicovic (http://www.alexcicovic.com) */
jQuery(function($){
	$.datepicker.regional['el'] = {
		closeText: 'ÎÎ»ÎµÎ¯ÏÎ¹Î¼Î¿',
		prevText: 'Î ÏÎ¿Î·Î³Î¿ÏÎ¼ÎµÎ½Î¿Ï',
		nextText: 'ÎÏÏÎ¼ÎµÎ½Î¿Ï',
		currentText: 'Î¤ÏÎ­ÏÏÎ½ ÎÎ®Î½Î±Ï',
		monthNames: ['ÎÎ±Î½Î¿ÏÎ¬ÏÎ¹Î¿Ï','Î¦ÎµÎ²ÏÎ¿ÏÎ¬ÏÎ¹Î¿Ï','ÎÎ¬ÏÏÎ¹Î¿Ï','ÎÏÏÎ¯Î»Î¹Î¿Ï','ÎÎ¬Î¹Î¿Ï','ÎÎ¿ÏÎ½Î¹Î¿Ï',
		'ÎÎ¿ÏÎ»Î¹Î¿Ï','ÎÏÎ³Î¿ÏÏÏÎ¿Ï','Î£ÎµÏÏÎ­Î¼Î²ÏÎ¹Î¿Ï','ÎÎºÏÏÎ²ÏÎ¹Î¿Ï','ÎÎ¿Î­Î¼Î²ÏÎ¹Î¿Ï','ÎÎµÎºÎ­Î¼Î²ÏÎ¹Î¿Ï'],
		monthNamesShort: ['ÎÎ±Î½','Î¦ÎµÎ²','ÎÎ±Ï','ÎÏÏ','ÎÎ±Î¹','ÎÎ¿ÏÎ½',
		'ÎÎ¿ÏÎ»','ÎÏÎ³','Î£ÎµÏ','ÎÎºÏ','ÎÎ¿Îµ','ÎÎµÎº'],
		dayNames: ['ÎÏÏÎ¹Î±ÎºÎ®','ÎÎµÏÏÎ­ÏÎ±','Î¤ÏÎ¯ÏÎ·','Î¤ÎµÏÎ¬ÏÏÎ·','Î Î­Î¼ÏÏÎ·','Î Î±ÏÎ±ÏÎºÎµÏÎ®','Î£Î¬Î²Î²Î±ÏÎ¿'],
		dayNamesShort: ['ÎÏÏ','ÎÎµÏ','Î¤ÏÎ¹','Î¤ÎµÏ','Î ÎµÎ¼','Î Î±Ï','Î£Î±Î²'],
		dayNamesMin: ['ÎÏ','ÎÎµ','Î¤Ï','Î¤Îµ','Î Îµ','Î Î±','Î£Î±'],
		dateFormat: 'dd/mm/yy', firstDay: 1,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['el']);
});ï»¿/* Esperanto initialisation for the jQuery UI date picker plugin. */
/* Written by Olivier M. (olivierweb@ifrance.com). */
jQuery(function($){
	$.datepicker.regional['eo'] = {
		closeText: 'Fermi',
		prevText: '&lt;Anta',
		nextText: 'Sekv&gt;',
		currentText: 'Nuna',
		monthNames: ['Januaro','Februaro','Marto','Aprilo','Majo','Junio',
		'Julio','AÅ­gusto','Septembro','Oktobro','Novembro','Decembro'],
		monthNamesShort: ['Jan','Feb','Mar','Apr','Maj','Jun',
		'Jul','AÅ­g','Sep','Okt','Nov','Dec'],
		dayNames: ['DimanÄo','Lundo','Mardo','Merkredo','Ä´aÅ­do','Vendredo','Sabato'],
		dayNamesShort: ['Dim','Lun','Mar','Mer','Ä´aÅ­','Ven','Sab'],
		dayNamesMin: ['Di','Lu','Ma','Me','Ä´a','Ve','Sa'],
		dateFormat: 'dd/mm/yy', firstDay: 0,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['eo']);
});
/* Inicializaciï¿½n en espaï¿½ol para la extensiï¿½n 'UI date picker' para jQuery. */
/* Traducido por Vester (xvester@gmail.com). */
jQuery(function($){
	$.datepicker.regional['es'] = {
		closeText: 'Cerrar',
		prevText: '&#x3c;Ant',
		nextText: 'Sig&#x3e;',
		currentText: 'Hoy',
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
		'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
		'Jul','Ago','Sep','Oct','Nov','Dic'],
		dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
		dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
		dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
		dateFormat: 'dd/mm/yy', firstDay: 0,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['es']);
});ï»¿/* Persian (Farsi) Translation for the jQuery UI date picker plugin. */
/* Javad Mowlanezhad -- jmowla@gmail.com */
/* Jalali calendar should supported soon! (Its implemented but I have to test it) */
jQuery(function($) {
	$.datepicker.regional['fa'] = {
		closeText: 'Ø¨Ø³ØªÙ',
		prevText: '&#x3c;ÙØ¨ÙÙ',
		nextText: 'Ø¨Ø¹Ø¯Ù&#x3e;',
		currentText: 'Ø§ÙØ±ÙØ²',
		monthNames: ['ÙØ±ÙØ±Ø¯ÙÙ','Ø§Ø±Ø¯ÙØ¨ÙØ´Øª','Ø®Ø±Ø¯Ø§Ø¯','ØªÙØ±','ÙØ±Ø¯Ø§Ø¯','Ø´ÙØ±ÙÙØ±',
		'ÙÙØ±','Ø¢Ø¨Ø§Ù','Ø¢Ø°Ø±','Ø¯Ù','Ø¨ÙÙÙ','Ø§Ø³ÙÙØ¯'],
		monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12'],
		dayNames: ['ÙÚ©Ø´ÙØ¨Ù','Ø¯ÙØ´ÙØ¨Ù','Ø³ÙâØ´ÙØ¨Ù','ÚÙØ§Ø±Ø´ÙØ¨Ù','Ù¾ÙØ¬Ø´ÙØ¨Ù','Ø¬ÙØ¹Ù','Ø´ÙØ¨Ù'],
		dayNamesShort: ['Ù','Ø¯','Ø³','Ú','Ù¾','Ø¬', 'Ø´'],
		dayNamesMin: ['Ù','Ø¯','Ø³','Ú','Ù¾','Ø¬', 'Ø´'],
		dateFormat: 'yy/mm/dd', firstDay: 6,
  isRTL: true};
	$.datepicker.setDefaults($.datepicker.regional['fa']);
});/* Finnish initialisation for the jQuery UI date picker plugin. */
/* Written by Harri Kilpiï¿½ (harrikilpio@gmail.com). */
jQuery(function($){
    $.datepicker.regional['fi'] = {
		closeText: 'Sulje',
		prevText: '&laquo;Edellinen',
		nextText: 'Seuraava&raquo;',
		currentText: 'T&auml;n&auml;&auml;n',
        monthNames: ['Tammikuu','Helmikuu','Maaliskuu','Huhtikuu','Toukokuu','Kes&auml;kuu',
        'Hein&auml;kuu','Elokuu','Syyskuu','Lokakuu','Marraskuu','Joulukuu'],
        monthNamesShort: ['Tammi','Helmi','Maalis','Huhti','Touko','Kes&auml;',
        'Hein&auml;','Elo','Syys','Loka','Marras','Joulu'],
		dayNamesShort: ['Su','Ma','Ti','Ke','To','Pe','Su'],
		dayNames: ['Sunnuntai','Maanantai','Tiistai','Keskiviikko','Torstai','Perjantai','Lauantai'],
		dayNamesMin: ['Su','Ma','Ti','Ke','To','Pe','La'],
        dateFormat: 'dd.mm.yy', firstDay: 1,
		isRTL: false};
    $.datepicker.setDefaults($.datepicker.regional['fi']);
});
ï»¿/* French initialisation for the jQuery UI date picker plugin. */
/* Written by Keith Wood (kbwood@virginbroadband.com.au) and StÃ©phane Nahmani (sholby@sholby.net). */
jQuery(function($){
	$.datepicker.regional['fr'] = {
		closeText: 'Fermer',
		prevText: '&#x3c;PrÃ©c',
		nextText: 'Suiv&#x3e;',
		currentText: 'Courant',
		monthNames: ['Janvier','FÃ©vrier','Mars','Avril','Mai','Juin',
		'Juillet','AoÃ»t','Septembre','Octobre','Novembre','DÃ©cembre'],
		monthNamesShort: ['Jan','FÃ©v','Mar','Avr','Mai','Jun',
		'Jul','AoÃ»','Sep','Oct','Nov','DÃ©c'],
		dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
		dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
		dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
		dateFormat: 'dd/mm/yy', firstDay: 1,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['fr']);
});ï»¿/* Hebrew initialisation for the UI Datepicker extension. */
/* Written by Amir Hardon (ahardon at gmail dot com). */
jQuery(function($){
	$.datepicker.regional['he'] = {
		closeText: '×¡×××¨',
		prevText: '&#x3c;××§×××',
		nextText: '×××&#x3e;',
		currentText: '××××',
		monthNames: ['×× ×××¨','×¤××¨×××¨','××¨×¥','××¤×¨××','×××','××× ×',
		'××××','×××××¡×','×¡×¤××××¨','×××§××××¨','× ×××××¨','××¦×××¨'],
		monthNamesShort: ['1','2','3','4','5','6',
		'7','8','9','10','11','12'],
		dayNames: ['×¨××©××','×©× ×','×©×××©×','×¨×××¢×','××××©×','×©××©×','×©××ª'],
		dayNamesShort: ['×\'','×\'','×\'','×\'','×\'','×\'','×©××ª'],
		dayNamesMin: ['×\'','×\'','×\'','×\'','×\'','×\'','×©××ª'],
		dateFormat: 'dd/mm/yy', firstDay: 0,
		isRTL: true};
	$.datepicker.setDefaults($.datepicker.regional['he']);
});
ï»¿/* Croatian i18n for the jQuery UI date picker plugin. */
/* Written by Vjekoslav Nesek. */
jQuery(function($){
	$.datepicker.regional['hr'] = {
		closeText: 'Zatvori',
		prevText: '&#x3c;',
		nextText: '&#x3e;',
		currentText: 'Danas',
		monthNames: ['SijeÄanj','VeljaÄa','OÅ¾ujak','Travanj','Svibanj','Lipani',
		'Srpanj','Kolovoz','Rujan','Listopad','Studeni','Prosinac'],
		monthNamesShort: ['Sij','Velj','OÅ¾u','Tra','Svi','Lip',
		'Srp','Kol','Ruj','Lis','Stu','Pro'],
		dayNames: ['Nedjalja','Ponedjeljak','Utorak','Srijeda','Äetvrtak','Petak','Subota'],
		dayNamesShort: ['Ned','Pon','Uto','Sri','Äet','Pet','Sub'],
		dayNamesMin: ['Ne','Po','Ut','Sr','Äe','Pe','Su'],
		dateFormat: 'dd.mm.yy.', firstDay: 1,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['hr']);
});/* Hungarian initialisation for the jQuery UI date picker plugin. */
/* Written by Istvan Karaszi (jquerycalendar@spam.raszi.hu). */
jQuery(function($){
	$.datepicker.regional['hu'] = {
		closeText: 'bezÃ¡rÃ¡s',
		prevText: '&laquo;&nbsp;vissza',
		nextText: 'elÅre&nbsp;&raquo;',
		currentText: 'ma',
		monthNames: ['JanuÃ¡r', 'FebruÃ¡r', 'MÃ¡rcius', 'Ãprilis', 'MÃ¡jus', 'JÃºnius',
		'JÃºlius', 'Augusztus', 'Szeptember', 'OktÃ³ber', 'November', 'December'],
		monthNamesShort: ['Jan', 'Feb', 'MÃ¡r', 'Ãpr', 'MÃ¡j', 'JÃºn',
		'JÃºl', 'Aug', 'Szep', 'Okt', 'Nov', 'Dec'],
		dayNames: ['VasÃ¡map', 'HÃ©tfÃ¶', 'Kedd', 'Szerda', 'CsÃ¼tÃ¶rtÃ¶k', 'PÃ©ntek', 'Szombat'],
		dayNamesShort: ['Vas', 'HÃ©t', 'Ked', 'Sze', 'CsÃ¼', 'PÃ©n', 'Szo'],
		dayNamesMin: ['V', 'H', 'K', 'Sze', 'Cs', 'P', 'Szo'],
		dateFormat: 'yy-mm-dd', firstDay: 1,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['hu']);
});
/* Armenian(UTF-8) initialisation for the jQuery UI date picker plugin. */
/* Written by Levon Zakaryan (levon.zakaryan@gmail.com)*/
jQuery(function($){
	$.datepicker.regional['hy'] = {
		closeText: 'ÕÕ¡Õ¯Õ¥Õ¬',
		prevText: '&#x3c;ÕÕ¡Õ­.',
		nextText: 'ÕÕ¡Õ».&#x3e;',
		currentText: 'Ô±ÕµÕ½ÖÖ',
		monthNames: ['ÕÕ¸ÖÕ¶Õ¾Õ¡Ö','ÕÕ¥Õ¿ÖÕ¾Õ¡Ö','ÕÕ¡ÖÕ¿','Ô±ÕºÖÕ«Õ¬','ÕÕ¡ÕµÕ«Õ½','ÕÕ¸ÖÕ¶Õ«Õ½',
		'ÕÕ¸ÖÕ¬Õ«Õ½','ÕÕ£Õ¸Õ½Õ¿Õ¸Õ½','ÕÕ¥ÕºÕ¿Õ¥Õ´Õ¢Õ¥Ö','ÕÕ¸Õ¯Õ¿Õ¥Õ´Õ¢Õ¥Ö','ÕÕ¸ÕµÕ¥Õ´Õ¢Õ¥Ö','Ô´Õ¥Õ¯Õ¿Õ¥Õ´Õ¢Õ¥Ö'],
		monthNamesShort: ['ÕÕ¸ÖÕ¶Õ¾','ÕÕ¥Õ¿Ö','ÕÕ¡ÖÕ¿','Ô±ÕºÖ','ÕÕ¡ÕµÕ«Õ½','ÕÕ¸ÖÕ¶Õ«Õ½',
		'ÕÕ¸ÖÕ¬','ÕÕ£Õ½','ÕÕ¥Õº','ÕÕ¸Õ¯','ÕÕ¸Õµ','Ô´Õ¥Õ¯'],
		dayNames: ['Õ¯Õ«ÖÕ¡Õ¯Õ«','Õ¥Õ¯Õ¸ÖÕ·Õ¡Õ¢Õ©Õ«','Õ¥ÖÕ¥ÖÕ·Õ¡Õ¢Õ©Õ«','Õ¹Õ¸ÖÕ¥ÖÕ·Õ¡Õ¢Õ©Õ«','Õ°Õ«Õ¶Õ£Õ·Õ¡Õ¢Õ©Õ«','Õ¸ÖÖÕ¢Õ¡Õ©','Õ·Õ¡Õ¢Õ¡Õ©'],
		dayNamesShort: ['Õ¯Õ«Ö','Õ¥ÖÕ¯','Õ¥ÖÖ','Õ¹ÖÖ','Õ°Õ¶Õ£','Õ¸ÖÖÕ¢','Õ·Õ¢Õ©'],
		dayNamesMin: ['Õ¯Õ«Ö','Õ¥ÖÕ¯','Õ¥ÖÖ','Õ¹ÖÖ','Õ°Õ¶Õ£','Õ¸ÖÖÕ¢','Õ·Õ¢Õ©'],
		dateFormat: 'dd.mm.yy', firstDay: 1,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['hy']);
});/* Indonesian initialisation for the jQuery UI date picker plugin. */
/* Written by Deden Fathurahman (dedenf@gmail.com). */
jQuery(function($){
	$.datepicker.regional['id'] = {
		closeText: 'Tutup',
		prevText: '&#x3c;mundur',
		nextText: 'maju&#x3e;',
		currentText: 'hari ini',
		monthNames: ['Januari','Februari','Maret','April','Mei','Juni',
		'Juli','Agustus','September','Oktober','Nopember','Desember'],
		monthNamesShort: ['Jan','Feb','Mar','Apr','Mei','Jun',
		'Jul','Agus','Sep','Okt','Nop','Des'],
		dayNames: ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'],
		dayNamesShort: ['Min','Sen','Sel','Rab','kam','Jum','Sab'],
		dayNamesMin: ['Mg','Sn','Sl','Rb','Km','jm','Sb'],
		dateFormat: 'dd/mm/yy', firstDay: 0,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['id']);
});/* Icelandic initialisation for the jQuery UI date picker plugin. */
/* Written by Haukur H. Thorsson (haukur@eskill.is). */
jQuery(function($){
	$.datepicker.regional['is'] = {
		closeText: 'Loka',
		prevText: '&#x3c; Fyrri',
		nextText: 'N&aelig;sti &#x3e;',
		currentText: '&Iacute; dag',
		monthNames: ['Jan&uacute;ar','Febr&uacute;ar','Mars','Apr&iacute;l','Ma&iacute','J&uacute;n&iacute;',
		'J&uacute;l&iacute;','&Aacute;g&uacute;st','September','Okt&oacute;ber','N&oacute;vember','Desember'],
		monthNamesShort: ['Jan','Feb','Mar','Apr','Ma&iacute;','J&uacute;n',
		'J&uacute;l','&Aacute;g&uacute;','Sep','Okt','N&oacute;v','Des'],
		dayNames: ['Sunnudagur','M&aacute;nudagur','&THORN;ri&eth;judagur','Mi&eth;vikudagur','Fimmtudagur','F&ouml;studagur','Laugardagur'],
		dayNamesShort: ['Sun','M&aacute;n','&THORN;ri','Mi&eth;','Fim','F&ouml;s','Lau'],
		dayNamesMin: ['Su','M&aacute;','&THORN;r','Mi','Fi','F&ouml;','La'],
		dateFormat: 'dd/mm/yy', firstDay: 0,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['is']);
});/* Italian initialisation for the jQuery UI date picker plugin. */
/* Written by Apaella (apaella@gmail.com). */
jQuery(function($){
	$.datepicker.regional['it'] = {
		closeText: 'Chiudi',
		prevText: '&#x3c;Prec',
		nextText: 'Succ&#x3e;',
		currentText: 'Oggi',
		monthNames: ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno',
		'Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'],
		monthNamesShort: ['Gen','Feb','Mar','Apr','Mag','Giu',
		'Lug','Ago','Set','Ott','Nov','Dic'],
		dayNames: ['Domenica','Luned&#236','Marted&#236','Mercoled&#236','Gioved&#236','Venerd&#236','Sabato'],
		dayNamesShort: ['Dom','Lun','Mar','Mer','Gio','Ven','Sab'],
		dayNamesMin: ['Do','Lu','Ma','Me','Gio','Ve','Sa'],
		dateFormat: 'dd/mm/yy', firstDay: 1,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['it']);
});
ï»¿/* Japanese initialisation for the jQuery UI date picker plugin. */
/* Written by Kentaro SATO (kentaro@ranvis.com). */
jQuery(function($){
	$.datepicker.regional['ja'] = {
		closeText: 'éãã',
		prevText: '&#x3c;å',
		nextText: 'æ¬¡&#x3e;',
		currentText: 'ä»æ¥',
		monthNames: ['1æ','2æ','3æ','4æ','5æ','6æ',
		'7æ','8æ','9æ','10æ','11æ','12æ'],
		monthNamesShort: ['1æ','2æ','3æ','4æ','5æ','6æ',
		'7æ','8æ','9æ','10æ','11æ','12æ'],
		dayNames: ['æ¥ææ¥','æææ¥','ç«ææ¥','æ°´ææ¥','æ¨ææ¥','éææ¥','åææ¥'],
		dayNamesShort: ['æ¥','æ','ç«','æ°´','æ¨','é','å'],
		dayNamesMin: ['æ¥','æ','ç«','æ°´','æ¨','é','å'],
		dateFormat: 'yy/mm/dd', firstDay: 0,
		isRTL: false,
		showMonthAfterYear: true};
	$.datepicker.setDefaults($.datepicker.regional['ja']);
});/* Korean initialisation for the jQuery calendar extension. */
/* Written by DaeKwon Kang (ncrash.dk@gmail.com). */
jQuery(function($){
	$.datepicker.regional['ko'] = {
		closeText: 'ë«ê¸°',
		prevText: 'ì´ì ë¬',
		nextText: 'ë¤ìë¬',
		currentText: 'ì¤ë',
		monthNames: ['1ì(JAN)','2ì(FEB)','3ì(MAR)','4ì(APR)','5ì(MAY)','6ì(JUN)',
		'7ì(JUL)','8ì(AUG)','9ì(SEP)','10ì(OCT)','11ì(NOV)','12ì(DEC)'],
		monthNamesShort: ['1ì(JAN)','2ì(FEB)','3ì(MAR)','4ì(APR)','5ì(MAY)','6ì(JUN)',
		'7ì(JUL)','8ì(AUG)','9ì(SEP)','10ì(OCT)','11ì(NOV)','12ì(DEC)'],
		dayNames: ['ì¼','ì','í','ì','ëª©','ê¸','í '],
		dayNamesShort: ['ì¼','ì','í','ì','ëª©','ê¸','í '],
		dayNamesMin: ['ì¼','ì','í','ì','ëª©','ê¸','í '],
		dateFormat: 'yy-mm-dd', firstDay: 0,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['ko']);
});/* Lithuanian (UTF-8) initialisation for the jQuery UI date picker plugin. */
/* @author Arturas Paleicikas <arturas@avalon.lt> */
jQuery(function($){
	$.datepicker.regional['lt'] = {
		closeText: 'UÅ¾daryti',
		prevText: '&#x3c;Atgal',
		nextText: 'Pirmyn&#x3e;',
		currentText: 'Å iandien',
		monthNames: ['Sausis','Vasaris','Kovas','Balandis','GeguÅ¾Ä','BirÅ¾elis',
		'Liepa','RugpjÅ«tis','RugsÄjis','Spalis','Lapkritis','Gruodis'],
		monthNamesShort: ['Sau','Vas','Kov','Bal','Geg','Bir',
		'Lie','Rugp','Rugs','Spa','Lap','Gru'],
		dayNames: ['sekmadienis','pirmadienis','antradienis','treÄiadienis','ketvirtadienis','penktadienis','Å¡eÅ¡tadienis'],
		dayNamesShort: ['sek','pir','ant','tre','ket','pen','Å¡eÅ¡'],
		dayNamesMin: ['Se','Pr','An','Tr','Ke','Pe','Å e'],
		dateFormat: 'yy-mm-dd', firstDay: 1,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['lt']);
});/* Latvian (UTF-8) initialisation for the jQuery UI date picker plugin. */
/* @author Arturas Paleicikas <arturas.paleicikas@metasite.net> */
jQuery(function($){
	$.datepicker.regional['lv'] = {
		closeText: 'AizvÄrt',
		prevText: 'Iepr',
		nextText: 'NÄka',
		currentText: 'Å odien',
		monthNames: ['JanvÄris','FebruÄris','Marts','AprÄ«lis','Maijs','JÅ«nijs',
		'JÅ«lijs','Augusts','Septembris','Oktobris','Novembris','Decembris'],
		monthNamesShort: ['Jan','Feb','Mar','Apr','Mai','JÅ«n',
		'JÅ«l','Aug','Sep','Okt','Nov','Dec'],
		dayNames: ['svÄtdiena','pirmdiena','otrdiena','treÅ¡diena','ceturtdiena','piektdiena','sestdiena'],
		dayNamesShort: ['svt','prm','otr','tre','ctr','pkt','sst'],
		dayNamesMin: ['Sv','Pr','Ot','Tr','Ct','Pk','Ss'],
		dateFormat: 'dd-mm-yy', firstDay: 1,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['lv']);
});/* Malaysian initialisation for the jQuery UI date picker plugin. */
/* Written by Mohd Nawawi Mohamad Jamili (nawawi@ronggeng.net). */
jQuery(function($){
	$.datepicker.regional['ms'] = {
		closeText: 'Tutup',
		prevText: '&#x3c;Sebelum',
		nextText: 'Selepas&#x3e;',
		currentText: 'hari ini',
		monthNames: ['Januari','Februari','Mac','April','Mei','Jun',
		'Julai','Ogos','September','Oktober','November','Disember'],
		monthNamesShort: ['Jan','Feb','Mac','Apr','Mei','Jun',
		'Jul','Ogo','Sep','Okt','Nov','Dis'],
		dayNames: ['Ahad','Isnin','Selasa','Rabu','Khamis','Jumaat','Sabtu'],
		dayNamesShort: ['Aha','Isn','Sel','Rab','kha','Jum','Sab'],
		dayNamesMin: ['Ah','Is','Se','Ra','Kh','Ju','Sa'],
		dateFormat: 'dd/mm/yy', firstDay: 0,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['ms']);
});ï»¿/* Dutch (UTF-8) initialisation for the jQuery UI date picker plugin. */
/* Written by Mathias Bynens <http://mathiasbynens.be/> */
jQuery(function($){
	$.datepicker.regional.nl = {
		closeText: 'Sluiten',
		prevText: 'â',
		nextText: 'â',
		currentText: 'Vandaag',
		monthNames: ['januari', 'februari', 'maart', 'april', 'mei', 'juni',
		'juli', 'augustus', 'september', 'oktober', 'november', 'december'],
		monthNamesShort: ['jan', 'feb', 'maa', 'apr', 'mei', 'jun',
		'jul', 'aug', 'sep', 'okt', 'nov', 'dec'],
		dayNames: ['zondag', 'maandag', 'dinsdag', 'woensdag', 'donderdag', 'vrijdag', 'zaterdag'],
		dayNamesShort: ['zon', 'maa', 'din', 'woe', 'don', 'vri', 'zat'],
		dayNamesMin: ['zo', 'ma', 'di', 'wo', 'do', 'vr', 'za'],
		dateFormat: 'dd/mm/yy', firstDay: 1,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional.nl);
});/* Norwegian initialisation for the jQuery UI date picker plugin. */
/* Written by Naimdjon Takhirov (naimdjon@gmail.com). */
jQuery(function($){
    $.datepicker.regional['no'] = {
		closeText: 'Lukk',
        prevText: '&laquo;Forrige',
		nextText: 'Neste&raquo;',
		currentText: 'I dag',
        monthNames: ['Januar','Februar','Mars','April','Mai','Juni',
        'Juli','August','September','Oktober','November','Desember'],
        monthNamesShort: ['Jan','Feb','Mar','Apr','Mai','Jun',
        'Jul','Aug','Sep','Okt','Nov','Des'],
		dayNamesShort: ['SÃ¸n','Man','Tir','Ons','Tor','Fre','LÃ¸r'],
		dayNames: ['SÃ¸ndag','Mandag','Tirsdag','Onsdag','Torsdag','Fredag','LÃ¸rdag'],
		dayNamesMin: ['SÃ¸','Ma','Ti','On','To','Fr','LÃ¸'],
        dateFormat: 'yy-mm-dd', firstDay: 0,
		isRTL: false};
    $.datepicker.setDefaults($.datepicker.regional['no']);
});
/* Polish initialisation for the jQuery UI date picker plugin. */
/* Written by Jacek Wysocki (jacek.wysocki@gmail.com). */
jQuery(function($){
	$.datepicker.regional['pl'] = {
		closeText: 'Zamknij',
		prevText: '&#x3c;Poprzedni',
		nextText: 'NastÄpny&#x3e;',
		currentText: 'DziÅ',
		monthNames: ['StyczeÅ','Luty','Marzec','KwiecieÅ','Maj','Czerwiec',
		'Lipiec','SierpieÅ','WrzesieÅ','PaÅºdziernik','Listopad','GrudzieÅ'],
		monthNamesShort: ['Sty','Lu','Mar','Kw','Maj','Cze',
		'Lip','Sie','Wrz','Pa','Lis','Gru'],
		dayNames: ['Niedziela','Poniedzialek','Wtorek','Åroda','Czwartek','PiÄtek','Sobota'],
		dayNamesShort: ['Nie','Pn','Wt','År','Czw','Pt','So'],
		dayNamesMin: ['N','Pn','Wt','År','Cz','Pt','So'],
		dateFormat: 'yy-mm-dd', firstDay: 1,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['pl']);
});
/* Brazilian initialisation for the jQuery UI date picker plugin. */
/* Written by Leonildo Costa Silva (leocsilva@gmail.com). */
jQuery(function($){
	$.datepicker.regional['pt-BR'] = {
		closeText: 'Fechar',
		prevText: '&#x3c;Anterior',
		nextText: 'Pr&oacute;ximo&#x3e;',
		currentText: 'Hoje',
		monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho',
		'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
		monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
		'Jul','Ago','Set','Out','Nov','Dez'],
		dayNames: ['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
		dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
		dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
		dateFormat: 'dd/mm/yy', firstDay: 0,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['pt-BR']);
});/* Romanian initialisation for the jQuery UI date picker plugin.
 *
 * Written by Edmond L. (ll_edmond@walla.com)
 * and Ionut G. Stan (ionut.g.stan@gmail.com)
 */
jQuery(function($){
	$.datepicker.regional['ro'] = {
		closeText: 'Ãnchide',
		prevText: '&laquo; Luna precedentÄ',
		nextText: 'Luna urmÄtoare &raquo;',
		currentText: 'Azi',
		monthNames: ['Ianuarie','Februarie','Martie','Aprilie','Mai','Iunie',
		'Iulie','August','Septembrie','Octombrie','Noiembrie','Decembrie'],
		monthNamesShort: ['Ian', 'Feb', 'Mar', 'Apr', 'Mai', 'Iun',
		'Iul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		dayNames: ['DuminicÄ', 'Luni', 'MarÅ£i', 'Miercuri', 'Joi', 'Vineri', 'SÃ¢mbÄtÄ'],
		dayNamesShort: ['Dum', 'Lun', 'Mar', 'Mie', 'Joi', 'Vin', 'SÃ¢m'],
		dayNamesMin: ['Du','Lu','Ma','Mi','Jo','Vi','SÃ¢'],
		dateFormat: 'dd MM yy', firstDay: 1,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['ro']);
});
/* Russian (UTF-8) initialisation for the jQuery UI date picker plugin. */
/* Written by Andrew Stromnov (stromnov@gmail.com). */
jQuery(function($){
	$.datepicker.regional['ru'] = {
		closeText: 'ÐÐ°ÐºÑÑÑÑ',
		prevText: '&#x3c;ÐÑÐµÐ´',
		nextText: 'Ð¡Ð»ÐµÐ´&#x3e;',
		currentText: 'Ð¡ÐµÐ³Ð¾Ð´Ð½Ñ',
		monthNames: ['Ð¯Ð½Ð²Ð°ÑÑ','Ð¤ÐµÐ²ÑÐ°Ð»Ñ','ÐÐ°ÑÑ','ÐÐ¿ÑÐµÐ»Ñ','ÐÐ°Ð¹','ÐÑÐ½Ñ',
		'ÐÑÐ»Ñ','ÐÐ²Ð³ÑÑÑ','Ð¡ÐµÐ½ÑÑÐ±ÑÑ','ÐÐºÑÑÐ±ÑÑ','ÐÐ¾ÑÐ±ÑÑ','ÐÐµÐºÐ°Ð±ÑÑ'],
		monthNamesShort: ['Ð¯Ð½Ð²','Ð¤ÐµÐ²','ÐÐ°Ñ','ÐÐ¿Ñ','ÐÐ°Ð¹','ÐÑÐ½',
		'ÐÑÐ»','ÐÐ²Ð³','Ð¡ÐµÐ½','ÐÐºÑ','ÐÐ¾Ñ','ÐÐµÐº'],
		dayNames: ['Ð²Ð¾ÑÐºÑÐµÑÐµÐ½ÑÐµ','Ð¿Ð¾Ð½ÐµÐ´ÐµÐ»ÑÐ½Ð¸Ðº','Ð²ÑÐ¾ÑÐ½Ð¸Ðº','ÑÑÐµÐ´Ð°','ÑÐµÑÐ²ÐµÑÐ³','Ð¿ÑÑÐ½Ð¸ÑÐ°','ÑÑÐ±Ð±Ð¾ÑÐ°'],
		dayNamesShort: ['Ð²ÑÐº','Ð¿Ð½Ð´','Ð²ÑÑ','ÑÑÐ´','ÑÑÐ²','Ð¿ÑÐ½','ÑÐ±Ñ'],
		dayNamesMin: ['ÐÑ','ÐÐ½','ÐÑ','Ð¡Ñ','Ð§Ñ','ÐÑ','Ð¡Ð±'],
		dateFormat: 'dd.mm.yy', firstDay: 1,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['ru']);
});/* Slovak initialisation for the jQuery UI date picker plugin. */
/* Written by Vojtech Rinik (vojto@hmm.sk). */
jQuery(function($){
	$.datepicker.regional['sk'] = {
		closeText: 'ZavrieÅ¥',
		prevText: '&#x3c;PredchÃ¡dzajÃºci',
		nextText: 'NasledujÃºci&#x3e;',
		currentText: 'Dnes',
		monthNames: ['JanuÃ¡r','FebruÃ¡r','Marec','AprÃ­l','MÃ¡j','JÃºn',
		'JÃºl','August','September','OktÃ³ber','November','December'],
		monthNamesShort: ['Jan','Feb','Mar','Apr','MÃ¡j','JÃºn',
		'JÃºl','Aug','Sep','Okt','Nov','Dec'],
		dayNames: ['Nedel\'a','Pondelok','Utorok','Streda','Å tvrtok','Piatok','Sobota'],
		dayNamesShort: ['Ned','Pon','Uto','Str','Å tv','Pia','Sob'],
		dayNamesMin: ['Ne','Po','Ut','St','Å t','Pia','So'],
		dateFormat: 'dd.mm.yy', firstDay: 0,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['sk']);
});
/* Slovenian initialisation for the jQuery UI date picker plugin. */
/* Written by Jaka Jancar (jaka@kubje.org). */
/* c = &#x10D;, s = &#x161; z = &#x17E; C = &#x10C; S = &#x160; Z = &#x17D; */
jQuery(function($){
	$.datepicker.regional['sl'] = {
		closeText: 'Zapri',
		prevText: '&lt;Prej&#x161;nji',
		nextText: 'Naslednji&gt;',
		currentText: 'Trenutni',
		monthNames: ['Januar','Februar','Marec','April','Maj','Junij',
		'Julij','Avgust','September','Oktober','November','December'],
		monthNamesShort: ['Jan','Feb','Mar','Apr','Maj','Jun',
		'Jul','Avg','Sep','Okt','Nov','Dec'],
		dayNames: ['Nedelja','Ponedeljek','Torek','Sreda','&#x10C;etrtek','Petek','Sobota'],
		dayNamesShort: ['Ned','Pon','Tor','Sre','&#x10C;et','Pet','Sob'],
		dayNamesMin: ['Ne','Po','To','Sr','&#x10C;e','Pe','So'],
		dateFormat: 'dd.mm.yy', firstDay: 1,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['sl']);
});
ï»¿/* Albanian initialisation for the jQuery UI date picker plugin. */
/* Written by Flakron Bytyqi (flakron@gmail.com). */
jQuery(function($){
	$.datepicker.regional['sq'] = {
		closeText: 'mbylle',
		prevText: '&#x3c;mbrapa',
		nextText: 'PÃ«rpara&#x3e;',
		currentText: 'sot',
		monthNames: ['Janar','Shkurt','Mars','Prill','Maj','Qershor',
		'Korrik','Gusht','Shtator','Tetor','NÃ«ntor','Dhjetor'],
		monthNamesShort: ['Jan','Shk','Mar','Pri','Maj','Qer',
		'Kor','Gus','Sht','Tet','NÃ«n','Dhj'],
		dayNames: ['E Diel','E HÃ«nÃ«','E MartÃ«','E MÃ«rkurÃ«','E Enjte','E Premte','E Shtune'],
		dayNamesShort: ['Di','HÃ«','Ma','MÃ«','En','Pr','Sh'],
		dayNamesMin: ['Di','HÃ«','Ma','MÃ«','En','Pr','Sh'],
		dateFormat: 'dd.mm.yy', firstDay: 1,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['sq']);
});
ï»¿/* Serbian i18n for the jQuery UI date picker plugin. */
/* Written by Dejan DimiÄ. */
jQuery(function($){
	$.datepicker.regional['sr-SR'] = {
		closeText: 'Zatvori',
		prevText: '&#x3c;',
		nextText: '&#x3e;',
		currentText: 'Danas',
		monthNames: ['Januar','Februar','Mart','April','Maj','Jun',
		'Jul','Avgust','Septembar','Oktobar','Novembar','Decembar'],
		monthNamesShort: ['Jan','Feb','Mar','Apr','Maj','Jun',
		'Jul','Avg','Sep','Okt','Nov','Dec'],
		dayNames: ['Nedelja','Ponedeljak','Utorak','Sreda','Äetvrtak','Petak','Subota'],
		dayNamesShort: ['Ned','Pon','Uto','Sre','Äet','Pet','Sub'],
		dayNamesMin: ['Ne','Po','Ut','Sr','Äe','Pe','Su'],
		dateFormat: 'dd/mm/yy', firstDay: 1,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['sr-SR']);
});
ï»¿/* Serbian i18n for the jQuery UI date picker plugin. */
/* Written by Dejan DimiÄ. */
jQuery(function($){
	$.datepicker.regional['sr'] = {
		closeText: 'ÐÐ°ÑÐ²Ð¾ÑÐ¸',
		prevText: '&#x3c;',
		nextText: '&#x3e;',
		currentText: 'ÐÐ°Ð½Ð°Ñ',
		monthNames: ['ÐÐ°Ð½ÑÐ°Ñ','Ð¤ÐµÐ±ÑÑÐ°Ñ','ÐÐ°ÑÑ','ÐÐ¿ÑÐ¸Ð»','ÐÐ°Ñ','ÐÑÐ½',
		'ÐÑÐ»','ÐÐ²Ð³ÑÑÑ','Ð¡ÐµÐ¿ÑÐµÐ¼Ð±Ð°Ñ','ÐÐºÑÐ¾Ð±Ð°Ñ','ÐÐ¾Ð²ÐµÐ¼Ð±Ð°Ñ','ÐÐµÑÐµÐ¼Ð±Ð°Ñ'],
		monthNamesShort: ['ÐÐ°Ð½','Ð¤ÐµÐ±','ÐÐ°Ñ','ÐÐ¿Ñ','ÐÐ°Ñ','ÐÑÐ½',
		'ÐÑÐ»','ÐÐ²Ð³','Ð¡ÐµÐ¿','ÐÐºÑ','ÐÐ¾Ð²','ÐÐµÑ'],
		dayNames: ['ÐÐµÐ´ÐµÑÐ°','ÐÐ¾Ð½ÐµÐ´ÐµÑÐ°Ðº','Ð£ÑÐ¾ÑÐ°Ðº','Ð¡ÑÐµÐ´Ð°','Ð§ÐµÑÐ²ÑÑÐ°Ðº','ÐÐµÑÐ°Ðº','Ð¡ÑÐ±Ð¾ÑÐ°'],
		dayNamesShort: ['ÐÐµÐ´','ÐÐ¾Ð½','Ð£ÑÐ¾','Ð¡ÑÐµ','Ð§ÐµÑ','ÐÐµÑ','Ð¡ÑÐ±'],
		dayNamesMin: ['ÐÐµ','ÐÐ¾','Ð£Ñ','Ð¡Ñ','Ð§Ðµ','ÐÐµ','Ð¡Ñ'],
		dateFormat: 'dd/mm/yy', firstDay: 1,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['sr']);
});
ï»¿/* Swedish initialisation for the jQuery UI date picker plugin. */
/* Written by Anders Ekdahl ( anders@nomadiz.se). */
jQuery(function($){
    $.datepicker.regional['sv'] = {
		closeText: 'StÃ¤ng',
        prevText: '&laquo;FÃ¶rra',
		nextText: 'NÃ¤sta&raquo;',
		currentText: 'Idag',
        monthNames: ['Januari','Februari','Mars','April','Maj','Juni',
        'Juli','Augusti','September','Oktober','November','December'],
        monthNamesShort: ['Jan','Feb','Mar','Apr','Maj','Jun',
        'Jul','Aug','Sep','Okt','Nov','Dec'],
		dayNamesShort: ['SÃ¶n','MÃ¥n','Tis','Ons','Tor','Fre','LÃ¶r'],
		dayNames: ['SÃ¶ndag','MÃ¥ndag','Tisdag','Onsdag','Torsdag','Fredag','LÃ¶rdag'],
		dayNamesMin: ['SÃ¶','MÃ¥','Ti','On','To','Fr','LÃ¶'],
        dateFormat: 'yy-mm-dd', firstDay: 1,
		isRTL: false};
    $.datepicker.setDefaults($.datepicker.regional['sv']);
});
ï»¿/* Thai initialisation for the jQuery UI date picker plugin. */
/* Written by pipo (pipo@sixhead.com). */
jQuery(function($){
	$.datepicker.regional['th'] = {
		closeText: 'à¸à¸´à¸',
		prevText: '&laquo;&nbsp;à¸¢à¹à¸­à¸',
		nextText: 'à¸à¸±à¸à¹à¸&nbsp;&raquo;',
		currentText: 'à¸§à¸±à¸à¸à¸µà¹',
		monthNames: ['à¸¡à¸à¸£à¸²à¸à¸¡','à¸à¸¸à¸¡à¸ à¸²à¸à¸±à¸à¸à¹','à¸¡à¸µà¸à¸²à¸à¸¡','à¹à¸¡à¸©à¸²à¸¢à¸','à¸à¸¤à¸©à¸ à¸²à¸à¸¡','à¸¡à¸´à¸à¸¸à¸à¸²à¸¢à¸',
		'à¸à¸£à¸à¸à¸²à¸à¸¡','à¸ªà¸´à¸à¸«à¸²à¸à¸¡','à¸à¸±à¸à¸¢à¸²à¸¢à¸','à¸à¸¸à¸¥à¸²à¸à¸¡','à¸à¸¤à¸¨à¸à¸´à¸à¸²à¸¢à¸','à¸à¸±à¸à¸§à¸²à¸à¸¡'],
		monthNamesShort: ['à¸¡.à¸.','à¸.à¸.','à¸¡à¸µ.à¸.','à¹à¸¡.à¸¢.','à¸.à¸.','à¸¡à¸´.à¸¢.',
		'à¸.à¸.','à¸ª.à¸.','à¸.à¸¢.','à¸.à¸.','à¸.à¸¢.','à¸.à¸.'],
		dayNames: ['à¸­à¸²à¸à¸´à¸à¸¢à¹','à¸à¸±à¸à¸à¸£à¹','à¸­à¸±à¸à¸à¸²à¸£','à¸à¸¸à¸','à¸à¸¤à¸«à¸±à¸ªà¸à¸à¸µ','à¸¨à¸¸à¸à¸£à¹','à¹à¸ªà¸²à¸£à¹'],
		dayNamesShort: ['à¸­à¸².','à¸.','à¸­.','à¸.','à¸à¸¤.','à¸¨.','à¸ª.'],
		dayNamesMin: ['à¸­à¸².','à¸.','à¸­.','à¸.','à¸à¸¤.','à¸¨.','à¸ª.'],
		dateFormat: 'dd/mm/yy', firstDay: 0,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['th']);
});/* Turkish initialisation for the jQuery UI date picker plugin. */
/* Written by Izzet Emre Erkan (kara@karalamalar.net). */
jQuery(function($){
	$.datepicker.regional['tr'] = {
		closeText: 'kapat',
		prevText: '&#x3c;geri',
		nextText: 'ileri&#x3e',
		currentText: 'bugÃ¼n',
		monthNames: ['Ocak','Åubat','Mart','Nisan','MayÄ±s','Haziran',
		'Temmuz','AÄustos','EylÃ¼l','Ekim','KasÄ±m','AralÄ±k'],
		monthNamesShort: ['Oca','Åub','Mar','Nis','May','Haz',
		'Tem','AÄu','Eyl','Eki','Kas','Ara'],
		dayNames: ['Pazar','Pazartesi','SalÄ±','ÃarÅamba','PerÅembe','Cuma','Cumartesi'],
		dayNamesShort: ['Pz','Pt','Sa','Ãa','Pe','Cu','Ct'],
		dayNamesMin: ['Pz','Pt','Sa','Ãa','Pe','Cu','Ct'],
		dateFormat: 'dd.mm.yy', firstDay: 1,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['tr']);
});/* Ukrainian (UTF-8) initialisation for the jQuery UI date picker plugin. */
/* Written by Maxim Drogobitskiy (maxdao@gmail.com). */
jQuery(function($){
	$.datepicker.regional['uk'] = {
		clearText: 'ÐÑÐ¸ÑÑÐ¸ÑÐ¸', clearStatus: '',
		closeText: 'ÐÐ°ÐºÑÐ¸ÑÐ¸', closeStatus: '',
		prevText: '&#x3c;',  prevStatus: '',
		prevBigText: '&#x3c;&#x3c;', prevBigStatus: '',
		nextText: '&#x3e;', nextStatus: '',
		nextBigText: '&#x3e;&#x3e;', nextBigStatus: '',
		currentText: 'Ð¡ÑÐ¾Ð³Ð¾Ð´Ð½Ñ', currentStatus: '',
		monthNames: ['Ð¡ÑÑÐµÐ½Ñ','ÐÑÑÐ¸Ð¹','ÐÐµÑÐµÐ·ÐµÐ½Ñ','ÐÐ²ÑÑÐµÐ½Ñ','Ð¢ÑÐ°Ð²ÐµÐ½Ñ','Ð§ÐµÑÐ²ÐµÐ½Ñ',
		'ÐÐ¸Ð¿ÐµÐ½Ñ','Ð¡ÐµÑÐ¿ÐµÐ½Ñ','ÐÐµÑÐµÑÐµÐ½Ñ','ÐÐ¾Ð²ÑÐµÐ½Ñ','ÐÐ¸ÑÑÐ¾Ð¿Ð°Ð´','ÐÑÑÐ´ÐµÐ½Ñ'],
		monthNamesShort: ['Ð¡ÑÑ','ÐÑÑ','ÐÐµÑ','ÐÐ²Ñ','Ð¢ÑÐ°','Ð§ÐµÑ',
		'ÐÐ¸Ð¿','Ð¡ÐµÑ','ÐÐµÑ','ÐÐ¾Ð²','ÐÐ¸Ñ','ÐÑÑ'],
		monthStatus: '', yearStatus: '',
		weekHeader: 'ÐÐµ', weekStatus: '',
		dayNames: ['Ð½ÐµÐ´ÑÐ»Ñ','Ð¿Ð¾Ð½ÐµÐ´ÑÐ»Ð¾Ðº','Ð²ÑÐ²ÑÐ¾ÑÐ¾Ðº','ÑÐµÑÐµÐ´Ð°','ÑÐµÑÐ²ÐµÑ','Ð¿âÑÑÐ½Ð¸ÑÑ','ÑÑÐ±Ð¾ÑÐ°'],
		dayNamesShort: ['Ð½ÐµÐ´','Ð¿Ð½Ð´','Ð²ÑÐ²','ÑÑÐ´','ÑÑÐ²','Ð¿ÑÐ½','ÑÐ±Ñ'],
		dayNamesMin: ['ÐÐ´','ÐÐ½','ÐÑ','Ð¡Ñ','Ð§Ñ','ÐÑ','Ð¡Ð±'],
		dayStatus: 'DD', dateStatus: 'D, M d',
		dateFormat: 'dd/mm/yy', firstDay: 1,
		initStatus: '', isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['uk']);
});/* Chinese initialisation for the jQuery UI date picker plugin. */
/* Written by Cloudream (cloudream@gmail.com). */
jQuery(function($){
	$.datepicker.regional['zh-CN'] = {
		closeText: 'å³é­',
		prevText: '&#x3c;ä¸æ',
		nextText: 'ä¸æ&#x3e;',
		currentText: 'ä»å¤©',
		monthNames: ['ä¸æ','äºæ','ä¸æ','åæ','äºæ','å­æ',
		'ä¸æ','å«æ','ä¹æ','åæ','åä¸æ','åäºæ'],
		monthNamesShort: ['ä¸','äº','ä¸','å','äº','å­',
		'ä¸','å«','ä¹','å','åä¸','åäº'],
		dayNames: ['æææ¥','ææä¸','ææäº','ææä¸','ææå','ææäº','ææå­'],
		dayNamesShort: ['å¨æ¥','å¨ä¸','å¨äº','å¨ä¸','å¨å','å¨äº','å¨å­'],
		dayNamesMin: ['æ¥','ä¸','äº','ä¸','å','äº','å­'],
		dateFormat: 'yy-mm-dd', firstDay: 1,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['zh-CN']);
});
ï»¿/* Chinese initialisation for the jQuery UI date picker plugin. */
/* Written by Ressol (ressol@gmail.com). */
jQuery(function($){
	$.datepicker.regional['zh-TW'] = {
		closeText: 'éé',
		prevText: '&#x3c;ä¸æ',
		nextText: 'ä¸æ&#x3e;',
		currentText: 'ä»å¤©',
		monthNames: ['ä¸æ','äºæ','ä¸æ','åæ','äºæ','å­æ',
		'ä¸æ','å«æ','ä¹æ','åæ','åä¸æ','åäºæ'],
		monthNamesShort: ['ä¸','äº','ä¸','å','äº','å­',
		'ä¸','å«','ä¹','å','åä¸','åäº'],
		dayNames: ['æææ¥','ææä¸','ææäº','ææä¸','ææå','ææäº','ææå­'],
		dayNamesShort: ['å¨æ¥','å¨ä¸','å¨äº','å¨ä¸','å¨å','å¨äº','å¨å­'],
		dayNamesMin: ['æ¥','ä¸','äº','ä¸','å','äº','å­'],
		dateFormat: 'yy/mm/dd', firstDay: 1,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['zh-TW']);
});
