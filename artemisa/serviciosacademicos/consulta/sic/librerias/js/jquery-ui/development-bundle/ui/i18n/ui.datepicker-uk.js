/* Ukrainian (UTF-8) initialisation for the jQuery UI date picker plugin. */
/* Written by Maxim Drogobitskiy (maxdao@gmail.com). */
jQuery(function($){
	$.datepicker.regional['uk'] = {
		clearText: 'ÐÑÐ¸ÑÑÐ¸ÑÐ¸', clearStatus: '',
		closeText: 'ÐÐ°ÐºÑÐ¸ÑÐ¸', closeStatus: '',
		prevText: '&#x3c;',  prevStatus: '',
		prevBigText: '&#x3c;&#x3c;', prevBigStatus: '',
		nextText: '&#x3e;', nextStatus: '',
		nextBigText: '&#x3e;&#x3e;', nextBigStatus: '',
		currentText: 'Ð¡ÑÐ¾Ð³Ð¾Ð´Ð½Ñ', currentStatus: '',
		monthNames: ['Ð¡ÑÑÐµÐ½Ñ','ÐÑÑÐ¸Ð¹','ÐÐµÑÐµÐ·ÐµÐ½Ñ','ÐÐ²ÑÑÐµÐ½Ñ','Ð¢ÑÐ°Ð²ÐµÐ½Ñ','Ð§ÐµÑÐ²ÐµÐ½Ñ',
		'ÐÐ¸Ð¿ÐµÐ½Ñ','Ð¡ÐµÑÐ¿ÐµÐ½Ñ','ÐÐµÑÐµÑÐµÐ½Ñ','ÐÐ¾Ð²ÑÐµÐ½Ñ','ÐÐ¸ÑÑÐ¾Ð¿Ð°Ð´','ÐÑÑÐ´ÐµÐ½Ñ'],
		monthNamesShort: ['Ð¡ÑÑ','ÐÑÑ','ÐÐµÑ','ÐÐ²Ñ','Ð¢ÑÐ°','Ð§ÐµÑ',
		'ÐÐ¸Ð¿','Ð¡ÐµÑ','ÐÐµÑ','ÐÐ¾Ð²','ÐÐ¸Ñ','ÐÑÑ'],
		monthStatus: '', yearStatus: '',
		weekHeader: 'ÐÐµ', weekStatus: '',
		dayNames: ['Ð½ÐµÐ´ÑÐ»Ñ','Ð¿Ð¾Ð½ÐµÐ´ÑÐ»Ð¾Ðº','Ð²ÑÐ²ÑÐ¾ÑÐ¾Ðº','ÑÐµÑÐµÐ´Ð°','ÑÐµÑÐ²ÐµÑ','Ð¿âÑÑÐ½Ð¸ÑÑ','ÑÑÐ±Ð¾ÑÐ°'],
		dayNamesShort: ['Ð½ÐµÐ´','Ð¿Ð½Ð´','Ð²ÑÐ²','ÑÑÐ´','ÑÑÐ²','Ð¿ÑÐ½','ÑÐ±Ñ'],
		dayNamesMin: ['ÐÐ´','ÐÐ½','ÐÑ','Ð¡Ñ','Ð§Ñ','ÐÑ','Ð¡Ð±'],
		dayStatus: 'DD', dateStatus: 'D, M d',
		dateFormat: 'dd/mm/yy', firstDay: 1,
		initStatus: '', isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['uk']);
});