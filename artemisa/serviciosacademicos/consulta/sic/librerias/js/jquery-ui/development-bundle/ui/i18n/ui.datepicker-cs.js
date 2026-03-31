ï»¿/* Czech initialisation for the jQuery UI date picker plugin. */
/* Written by Tomas Muller (tomas@tomas-muller.net). */
jQuery(function($){
	$.datepicker.regional['cs'] = {
		closeText: 'ZavÅÃ­t',
		prevText: '&#x3c;DÅÃ­ve',
		nextText: 'PozdÄji&#x3e;',
		currentText: 'NynÃ­',
		monthNames: ['leden','Ãºnor','bÅezen','duben','kvÄten','Äerven',
        'Äervenec','srpen','zÃ¡ÅÃ­','ÅÃ­jen','listopad','prosinec'],
		monthNamesShort: ['led','Ãºno','bÅe','dub','kvÄ','Äer',
		'Ävc','srp','zÃ¡Å','ÅÃ­j','lis','pro'],
		dayNames: ['nedÄle', 'pondÄlÃ­', 'ÃºterÃ½', 'stÅeda', 'Ätvrtek', 'pÃ¡tek', 'sobota'],
		dayNamesShort: ['ne', 'po', 'Ãºt', 'st', 'Ät', 'pÃ¡', 'so'],
		dayNamesMin: ['ne','po','Ãºt','st','Ät','pÃ¡','so'],
		dateFormat: 'dd.mm.yy', firstDay: 1,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['cs']);
});
