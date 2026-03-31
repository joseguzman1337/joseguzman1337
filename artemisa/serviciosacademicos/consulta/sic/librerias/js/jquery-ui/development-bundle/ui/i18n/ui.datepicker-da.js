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
