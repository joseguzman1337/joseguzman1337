ï»¿/* Swedish initialisation for the jQuery UI date picker plugin. */
/* Written by Anders Ekdahl ( anders@nomadiz.se). */
jQuery(function($){
    $.datepicker.regional['sv'] = {
		closeText: 'StÃ¤ng',
        prevText: '&laquo;FÃ¶rra',
		nextText: 'NÃ¤sta&raquo;',
		currentText: 'Idag',
        monthNames: ['Januari','Februari','Mars','April','Maj','Juni',
        'Juli','Augusti','September','Oktober','November','December'],
        monthNamesShort: ['Jan','Feb','Mar','Apr','Maj','Jun',
        'Jul','Aug','Sep','Okt','Nov','Dec'],
		dayNamesShort: ['SÃ¶n','MÃ¥n','Tis','Ons','Tor','Fre','LÃ¶r'],
		dayNames: ['SÃ¶ndag','MÃ¥ndag','Tisdag','Onsdag','Torsdag','Fredag','LÃ¶rdag'],
		dayNamesMin: ['SÃ¶','MÃ¥','Ti','On','To','Fr','LÃ¶'],
        dateFormat: 'yy-mm-dd', firstDay: 1,
		isRTL: false};
    $.datepicker.setDefaults($.datepicker.regional['sv']);
});
