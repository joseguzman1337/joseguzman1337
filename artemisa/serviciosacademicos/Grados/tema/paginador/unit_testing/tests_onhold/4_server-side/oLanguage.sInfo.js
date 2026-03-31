// DATA_TEMPLATE: empty_table
oTest.fnStart( "oLanguage.sInfo" );

$(document).ready( function () {
	/* Check the default */
	var oTable = $('#example').dataTable( {
		"bServerSide": true,
		"sAjaxSource": "../../../examples/server_side/scripts/server_processing.php"
	} );
	var oSettings = oTable.fnSettings();
	
	oTest.fnWaitTest( 
		"Info language is 'Mostrando _START_ a _END_ de _TOTAL_ registros' by default",
		null,
		function () { return oSettings.oLanguage.sInfo == "Mostrando _START_ a _END_ de _TOTAL_ registros"; }
	);
	
	oTest.fnTest( 
		"Info language default is in the DOM",
		null,
		function () { return document.getElementById('example_info').innerHTML = "Mostrando 1 a 10 de 57 registros"; }
	);
	
	
	oTest.fnWaitTest( 
		"Info language can be defined - without any macros",
		function () {
			oSession.fnRestore();
			oTable = $('#example').dataTable( {
				"bServerSide": true,
		"sAjaxSource": "../../../examples/server_side/scripts/server_processing.php",
				"oLanguage": {
					"sInfo": "unit test"
				}
			} );
			oSettings = oTable.fnSettings();
		},
		function () { return oSettings.oLanguage.sInfo == "unit test"; }
	);
	
	oTest.fnTest( 
		"Info language definition is in the DOM",
		null,
		function () { return document.getElementById('example_info').innerHTML = "unit test"; }
	);
	
	oTest.fnWaitTest( 
		"Info language can be defined - with macro _START_ only",
		function () {
			oSession.fnRestore();
			$('#example').dataTable( {
				"bServerSide": true,
		"sAjaxSource": "../../../examples/server_side/scripts/server_processing.php",
				"oLanguage": {
					"sInfo": "unit _START_ test"
				}
			} );
		},
		function () { return document.getElementById('example_info').innerHTML = "unit 1 test"; }
	);
	
	oTest.fnWaitTest( 
		"Info language can be defined - with macro _END_ only",
		function () {
			oSession.fnRestore();
			$('#example').dataTable( {
				"bServerSide": true,
		"sAjaxSource": "../../../examples/server_side/scripts/server_processing.php",
				"oLanguage": {
					"sInfo": "unit _END_ test"
				}
			} );
		},
		function () { return document.getElementById('example_info').innerHTML = "unit 10 test"; }
	);
	
	oTest.fnWaitTest( 
		"Info language can be defined - with macro _TOTAL_ only",
		function () {
			oSession.fnRestore();
			$('#example').dataTable( {
				"bServerSide": true,
		"sAjaxSource": "../../../examples/server_side/scripts/server_processing.php",
				"oLanguage": {
					"sInfo": "unit _END_ test"
				}
			} );
		},
		function () { return document.getElementById('example_info').innerHTML = "unit 57 test"; }
	);
	
	oTest.fnWaitTest( 
		"Info language can be defined - with macros _START_ and _END_",
		function () {
			oSession.fnRestore();
			$('#example').dataTable( {
				"bServerSide": true,
		"sAjaxSource": "../../../examples/server_side/scripts/server_processing.php",
				"oLanguage": {
					"sInfo": "unit _START_ _END_ test"
				}
			} );
		},
		function () { return document.getElementById('example_info').innerHTML = "unit 1 10 test"; }
	);
	
	oTest.fnWaitTest( 
		"Info language can be defined - with macros _START_, _END_ and _TOTAL_",
		function () {
			oSession.fnRestore();
			$('#example').dataTable( {
				"bServerSide": true,
		"sAjaxSource": "../../../examples/server_side/scripts/server_processing.php",
				"oLanguage": {
					"sInfo": "unit _START_ _END_ _TOTAL_ test"
				}
			} );
		},
		function () { return document.getElementById('example_info').innerHTML = "unit 1 10 57 test"; }
	);
	
	
	oTest.fnComplete();
} );