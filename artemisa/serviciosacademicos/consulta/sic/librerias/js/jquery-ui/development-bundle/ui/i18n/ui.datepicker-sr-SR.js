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
