/* Lithuanian (UTF-8) initialisation for the jQuery UI date picker plugin. */
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
});