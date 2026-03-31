ï»¿/* Bulgarian initialisation for the jQuery UI date picker plugin. */
/* Written by Stoyan Kyosev (http://svest.org). */
jQuery(function($){
    $.datepicker.regional['bg'] = {
        closeText: 'Ð·Ð°ÑÐ²Ð¾ÑÐ¸',
        prevText: '&#x3c;Ð½Ð°Ð·Ð°Ð´',
        nextText: 'Ð½Ð°Ð¿ÑÐµÐ´&#x3e;',
		nextBigText: '&#x3e;&#x3e;',
        currentText: 'Ð´Ð½ÐµÑ',
        monthNames: ['Ð¯Ð½ÑÐ°ÑÐ¸','Ð¤ÐµÐ²ÑÑÐ°ÑÐ¸','ÐÐ°ÑÑ','ÐÐ¿ÑÐ¸Ð»','ÐÐ°Ð¹','Ð®Ð½Ð¸',
        'Ð®Ð»Ð¸','ÐÐ²Ð³ÑÑÑ','Ð¡ÐµÐ¿ÑÐµÐ¼Ð²ÑÐ¸','ÐÐºÑÐ¾Ð¼Ð²ÑÐ¸','ÐÐ¾ÐµÐ¼Ð²ÑÐ¸','ÐÐµÐºÐµÐ¼Ð²ÑÐ¸'],
        monthNamesShort: ['Ð¯Ð½Ñ','Ð¤ÐµÐ²','ÐÐ°Ñ','ÐÐ¿Ñ','ÐÐ°Ð¹','Ð®Ð½Ð¸',
        'Ð®Ð»Ð¸','ÐÐ²Ð³','Ð¡ÐµÐ¿','ÐÐºÑ','ÐÐ¾Ð²','ÐÐµÐº'],
        dayNames: ['ÐÐµÐ´ÐµÐ»Ñ','ÐÐ¾Ð½ÐµÐ´ÐµÐ»Ð½Ð¸Ðº','ÐÑÐ¾ÑÐ½Ð¸Ðº','Ð¡ÑÑÐ´Ð°','Ð§ÐµÑÐ²ÑÑÑÑÐº','ÐÐµÑÑÐº','Ð¡ÑÐ±Ð¾ÑÐ°'],
        dayNamesShort: ['ÐÐµÐ´','ÐÐ¾Ð½','ÐÑÐ¾','Ð¡ÑÑ','Ð§ÐµÑ','ÐÐµÑ','Ð¡ÑÐ±'],
        dayNamesMin: ['ÐÐµ','ÐÐ¾','ÐÑ','Ð¡Ñ','Ð§Ðµ','ÐÐµ','Ð¡Ñ'],
        dateFormat: 'dd.mm.yy', firstDay: 1,
        isRTL: false};
    $.datepicker.setDefaults($.datepicker.regional['bg']);
});
