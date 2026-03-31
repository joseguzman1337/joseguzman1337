/* Romanian initialisation for the jQuery UI date picker plugin.
 *
 * Written by Edmond L. (ll_edmond@walla.com)
 * and Ionut G. Stan (ionut.g.stan@gmail.com)
 */
jQuery(function($){
	$.datepicker.regional['ro'] = {
		closeText: 'Ãnchide',
		prevText: '&laquo; Luna precedentÄ',
		nextText: 'Luna urmÄtoare &raquo;',
		currentText: 'Azi',
		monthNames: ['Ianuarie','Februarie','Martie','Aprilie','Mai','Iunie',
		'Iulie','August','Septembrie','Octombrie','Noiembrie','Decembrie'],
		monthNamesShort: ['Ian', 'Feb', 'Mar', 'Apr', 'Mai', 'Iun',
		'Iul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		dayNames: ['DuminicÄ', 'Luni', 'MarÅ£i', 'Miercuri', 'Joi', 'Vineri', 'SÃ¢mbÄtÄ'],
		dayNamesShort: ['Dum', 'Lun', 'Mar', 'Mie', 'Joi', 'Vin', 'SÃ¢m'],
		dayNamesMin: ['Du','Lu','Ma','Mi','Jo','Vi','SÃ¢'],
		dateFormat: 'dd MM yy', firstDay: 1,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['ro']);
});
