/* Hungarian initialisation for the jQuery UI date picker plugin. */
/* Written by Istvan Karaszi (jquerycalendar@spam.raszi.hu). */
jQuery(function($){
	$.datepicker.regional['hu'] = {
		closeText: 'bezÃ¡rÃ¡s',
		prevText: '&laquo;&nbsp;vissza',
		nextText: 'elÅre&nbsp;&raquo;',
		currentText: 'ma',
		monthNames: ['JanuÃ¡r', 'FebruÃ¡r', 'MÃ¡rcius', 'Ãprilis', 'MÃ¡jus', 'JÃºnius',
		'JÃºlius', 'Augusztus', 'Szeptember', 'OktÃ³ber', 'November', 'December'],
		monthNamesShort: ['Jan', 'Feb', 'MÃ¡r', 'Ãpr', 'MÃ¡j', 'JÃºn',
		'JÃºl', 'Aug', 'Szep', 'Okt', 'Nov', 'Dec'],
		dayNames: ['VasÃ¡map', 'HÃ©tfÃ¶', 'Kedd', 'Szerda', 'CsÃ¼tÃ¶rtÃ¶k', 'PÃ©ntek', 'Szombat'],
		dayNamesShort: ['Vas', 'HÃ©t', 'Ked', 'Sze', 'CsÃ¼', 'PÃ©n', 'Szo'],
		dayNamesMin: ['V', 'H', 'K', 'Sze', 'Cs', 'P', 'Szo'],
		dateFormat: 'yy-mm-dd', firstDay: 1,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['hu']);
});
