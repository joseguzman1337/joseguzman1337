ï»¿/* Arabic Translation for jQuery UI date picker plugin. */
/* Khaled Al Horani -- koko.dw@gmail.com */
/* Ø®Ø§ÙØ¯ Ø§ÙØ­ÙØ±Ø§ÙÙ -- koko.dw@gmail.com */
/* NOTE: monthNames are the original months names and they are the Arabic names, not the new months name ÙØ¨Ø±Ø§ÙØ± - ÙÙØ§ÙØ± and there isn't any Arabic roots for these months */
jQuery(function($){
	$.datepicker.regional['ar'] = {
		closeText: 'Ø¥ØºÙØ§Ù',
		prevText: '&#x3c;Ø§ÙØ³Ø§Ø¨Ù',
		nextText: 'Ø§ÙØªØ§ÙÙ&#x3e;',
		currentText: 'Ø§ÙÙÙÙ',
		monthNames: ['ÙØ§ÙÙÙ Ø§ÙØ«Ø§ÙÙ', 'Ø´Ø¨Ø§Ø·', 'Ø¢Ø°Ø§Ø±', 'ÙÙØ³Ø§Ù', 'Ø¢Ø°Ø§Ø±', 'Ø­Ø²ÙØ±Ø§Ù',
		'ØªÙÙØ²', 'Ø¢Ø¨', 'Ø£ÙÙÙÙ',	'ØªØ´Ø±ÙÙ Ø§ÙØ£ÙÙ', 'ØªØ´Ø±ÙÙ Ø§ÙØ«Ø§ÙÙ', 'ÙØ§ÙÙÙ Ø§ÙØ£ÙÙ'],
		monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12'],
		dayNames: ['Ø§ÙØ³Ø¨Øª', 'Ø§ÙØ£Ø­Ø¯', 'Ø§ÙØ§Ø«ÙÙÙ', 'Ø§ÙØ«ÙØ§Ø«Ø§Ø¡', 'Ø§ÙØ£Ø±Ø¨Ø¹Ø§Ø¡', 'Ø§ÙØ®ÙÙØ³', 'Ø§ÙØ¬ÙØ¹Ø©'],
		dayNamesShort: ['Ø³Ø¨Øª', 'Ø£Ø­Ø¯', 'Ø§Ø«ÙÙÙ', 'Ø«ÙØ§Ø«Ø§Ø¡', 'Ø£Ø±Ø¨Ø¹Ø§Ø¡', 'Ø®ÙÙØ³', 'Ø¬ÙØ¹Ø©'],
		dayNamesMin: ['Ø³Ø¨Øª', 'Ø£Ø­Ø¯', 'Ø§Ø«ÙÙÙ', 'Ø«ÙØ§Ø«Ø§Ø¡', 'Ø£Ø±Ø¨Ø¹Ø§Ø¡', 'Ø®ÙÙØ³', 'Ø¬ÙØ¹Ø©'],
		dateFormat: 'dd/mm/yy', firstDay: 0,
  isRTL: true};
	$.datepicker.setDefaults($.datepicker.regional['ar']);
});