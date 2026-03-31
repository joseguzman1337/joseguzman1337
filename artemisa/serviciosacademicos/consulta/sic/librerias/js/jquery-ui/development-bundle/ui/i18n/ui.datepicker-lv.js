/* Latvian (UTF-8) initialisation for the jQuery UI date picker plugin. */
/* @author Arturas Paleicikas <arturas.paleicikas@metasite.net> */
jQuery(function($){
	$.datepicker.regional['lv'] = {
		closeText: 'AizvÄrt',
		prevText: 'Iepr',
		nextText: 'NÄka',
		currentText: 'Å odien',
		monthNames: ['JanvÄris','FebruÄris','Marts','AprÄ«lis','Maijs','JÅ«nijs',
		'JÅ«lijs','Augusts','Septembris','Oktobris','Novembris','Decembris'],
		monthNamesShort: ['Jan','Feb','Mar','Apr','Mai','JÅ«n',
		'JÅ«l','Aug','Sep','Okt','Nov','Dec'],
		dayNames: ['svÄtdiena','pirmdiena','otrdiena','treÅ¡diena','ceturtdiena','piektdiena','sestdiena'],
		dayNamesShort: ['svt','prm','otr','tre','ctr','pkt','sst'],
		dayNamesMin: ['Sv','Pr','Ot','Tr','Ct','Pk','Ss'],
		dateFormat: 'dd-mm-yy', firstDay: 1,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['lv']);
});