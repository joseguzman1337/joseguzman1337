/* Turkish initialisation for the jQuery UI date picker plugin. */
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
});