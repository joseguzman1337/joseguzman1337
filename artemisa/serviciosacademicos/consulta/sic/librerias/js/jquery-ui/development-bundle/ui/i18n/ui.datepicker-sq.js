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
