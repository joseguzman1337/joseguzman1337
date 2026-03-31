ï»¿/* Japanese initialisation for the jQuery UI date picker plugin. */
/* Written by Kentaro SATO (kentaro@ranvis.com). */
jQuery(function($){
	$.datepicker.regional['ja'] = {
		closeText: 'éãã',
		prevText: '&#x3c;å',
		nextText: 'æ¬¡&#x3e;',
		currentText: 'ä»æ¥',
		monthNames: ['1æ','2æ','3æ','4æ','5æ','6æ',
		'7æ','8æ','9æ','10æ','11æ','12æ'],
		monthNamesShort: ['1æ','2æ','3æ','4æ','5æ','6æ',
		'7æ','8æ','9æ','10æ','11æ','12æ'],
		dayNames: ['æ¥ææ¥','æææ¥','ç«ææ¥','æ°´ææ¥','æ¨ææ¥','éææ¥','åææ¥'],
		dayNamesShort: ['æ¥','æ','ç«','æ°´','æ¨','é','å'],
		dayNamesMin: ['æ¥','æ','ç«','æ°´','æ¨','é','å'],
		dateFormat: 'yy/mm/dd', firstDay: 0,
		isRTL: false,
		showMonthAfterYear: true};
	$.datepicker.setDefaults($.datepicker.regional['ja']);
});