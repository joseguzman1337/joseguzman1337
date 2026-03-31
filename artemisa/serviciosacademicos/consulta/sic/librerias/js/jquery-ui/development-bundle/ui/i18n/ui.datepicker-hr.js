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
});