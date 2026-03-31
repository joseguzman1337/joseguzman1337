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
});