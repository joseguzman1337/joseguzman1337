ï»¿/* Hebrew initialisation for the UI Datepicker extension. */
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
