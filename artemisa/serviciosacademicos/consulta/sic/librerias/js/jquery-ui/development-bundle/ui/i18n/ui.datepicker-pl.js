/* Polish initialisation for the jQuery UI date picker plugin. */
/* Written by Jacek Wysocki (jacek.wysocki@gmail.com). */
jQuery(function($){
	$.datepicker.regional['pl'] = {
		closeText: 'Zamknij',
		prevText: '&#x3c;Poprzedni',
		nextText: 'NastÄpny&#x3e;',
		currentText: 'DziÅ',
		monthNames: ['StyczeÅ','Luty','Marzec','KwiecieÅ','Maj','Czerwiec',
		'Lipiec','SierpieÅ','WrzesieÅ','PaÅºdziernik','Listopad','GrudzieÅ'],
		monthNamesShort: ['Sty','Lu','Mar','Kw','Maj','Cze',
		'Lip','Sie','Wrz','Pa','Lis','Gru'],
		dayNames: ['Niedziela','Poniedzialek','Wtorek','Åroda','Czwartek','PiÄtek','Sobota'],
		dayNamesShort: ['Nie','Pn','Wt','År','Czw','Pt','So'],
		dayNamesMin: ['N','Pn','Wt','År','Cz','Pt','So'],
		dateFormat: 'yy-mm-dd', firstDay: 1,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['pl']);
});
