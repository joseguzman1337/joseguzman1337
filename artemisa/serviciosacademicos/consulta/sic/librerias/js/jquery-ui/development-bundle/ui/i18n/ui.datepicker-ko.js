/* Korean initialisation for the jQuery calendar extension. */
/* Written by DaeKwon Kang (ncrash.dk@gmail.com). */
jQuery(function($){
	$.datepicker.regional['ko'] = {
		closeText: 'ë«ê¸°',
		prevText: 'ì´ì ë¬',
		nextText: 'ë¤ìë¬',
		currentText: 'ì¤ë',
		monthNames: ['1ì(JAN)','2ì(FEB)','3ì(MAR)','4ì(APR)','5ì(MAY)','6ì(JUN)',
		'7ì(JUL)','8ì(AUG)','9ì(SEP)','10ì(OCT)','11ì(NOV)','12ì(DEC)'],
		monthNamesShort: ['1ì(JAN)','2ì(FEB)','3ì(MAR)','4ì(APR)','5ì(MAY)','6ì(JUN)',
		'7ì(JUL)','8ì(AUG)','9ì(SEP)','10ì(OCT)','11ì(NOV)','12ì(DEC)'],
		dayNames: ['ì¼','ì','í','ì','ëª©','ê¸','í '],
		dayNamesShort: ['ì¼','ì','í','ì','ëª©','ê¸','í '],
		dayNamesMin: ['ì¼','ì','í','ì','ëª©','ê¸','í '],
		dateFormat: 'yy-mm-dd', firstDay: 0,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['ko']);
});