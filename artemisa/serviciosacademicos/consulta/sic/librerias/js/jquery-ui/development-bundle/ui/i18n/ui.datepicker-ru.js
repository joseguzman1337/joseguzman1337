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
});