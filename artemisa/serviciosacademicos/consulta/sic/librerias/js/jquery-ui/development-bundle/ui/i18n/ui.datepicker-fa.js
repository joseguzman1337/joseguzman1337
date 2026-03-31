ï»¿/* Persian (Farsi) Translation for the jQuery UI date picker plugin. */
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
});