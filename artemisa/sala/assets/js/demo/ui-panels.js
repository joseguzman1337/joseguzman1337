
// UI-Panels.js
// ====================================================================
// This file should not be included in your project.
// This is just a sample how to initialize plugins or components.
//
// - ThemeOn.net -


 $(document).ready(function() {


	// PANEL WITH SWITCH - TURN YOUR DEFAULT CHECKBOX INTO BEAUTIFUL IOS 7 STYLE SWITCHES.
	// =================================================================
	// Require Switchery
	// http://abpetkov.github.io/switchery/
	// =================================================================
	new Switchery(document.getElementById('demo-panel-w-switch'));



	// PANEL WITH BUTTONS - LOADING OVERLAY
	// =================================================================
	// Require btheme Admin Javascript
	// http://www.themeon.net/
	// =================================================================
	$('.demo-panel-ref-btn').bthemeOverlay().on('click', function(){
		var $el = $(this), relTime;
		$el.bthemeOverlay('show');

		// Do something...



		relTime = setInterval(function(){
			// Hide the screen overlay
			$el.bthemeOverlay('hide');

			clearInterval(relTime);
		},2000);
	});



	// PANEL WITH VARIETY OF COMPONENTS - DEMO AUTO CLOSE ALERTS
	// =================================================================
	// Require btheme Admin Javascript
	// http://www.themeon.net/
	// =================================================================
	$('#demo-panel-alert').on('click', function(){
		$.bthemeNoty({
			type: 'primary',
			container : '#demo-panel-w-alert',
			html : '<strong>Well done!</strong> You successfully read this important alert message.',
			focus: false,
			timer : 2000
		});
	});



	// PANEL WITH VARIETY OF COMPONENTS - DEMO STICKY ALERTS
	// =================================================================
	// Require btheme Admin Javascript
	// http://www.themeon.net/
	// =================================================================
	$('#demo-panel-alert2').on('click', function(){
		$.bthemeNoty({
			type: 'warning',
			container : '#demo-panel-w-alert',
			html : '<strong>Well done!</strong> You successfully read this important alert message.',
			focus: false
		});
	});



 });
