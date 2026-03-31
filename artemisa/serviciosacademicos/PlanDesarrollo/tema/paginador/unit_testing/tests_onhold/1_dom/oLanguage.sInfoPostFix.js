// DATA_TEMPLATE: dom_data
oTest.fnStart( "oLanguage.sInfoPostFix" );

$(document).ready( function () {
	/* Check the default */
	var oTable = $('#example').dataTable();
	var oSettings = oTable.fnSettings();
	
	oTest.fnTest( 
		"Info post fix language is '' (blank) by default",
		null,
		function () { return oSettings.oLanguage.sInfoPostFix == ""; }
	);
	
	oTest.fnTest( 
		"Width no post fix, the basic info shows",
		null,
		function () { return document.getElementById('example_info').innerHTML = "Mostrando 1 a 10 de 57 registros"; }
	);
	
	
	oTest.fnTest( 
		"Info post fix language can be defined",
		function () {
			oSession.fnRestore();
			oTable = $('#example').dataTable( {
				"oLanguage": {
					"sInfoPostFix": "unit test"
				}
			} );
			oSettings = oTable.fnSettings();
		},
		function () { return oSettings.oLanguage.sInfoPostFix == "unit test"; }
	);
	
	oTest.fnTest( 
		"Info empty language default is in the DOM",
		null,
		function () { return document.getElementById('example_info').innerHTML = "Mostrando 1 a 10 de 57 registros unit test"; }
	);
	
	
	oTest.fnTest( 
		"Macros have no effect in the post fix",
		function () {
			oSession.fnRestore();
			oTable = $('#example').dataTable( {
				"oLanguage": {
					"sInfoPostFix": "unit _START_ _END_ _TOTAL_ test"
				}
			} );
		},
		function () { return document.getElementById('example_info').innerHTML = "Mostrando 1 a 10 de 57 registros unit _START_ _END_ _TOTAL_ test"; }
	);
	
	
	oTest.fnTest( 
		"Post fix is applied after fintering info",
		function () {
			oSession.fnRestore();
			oTable = $('#example').dataTable( {
				"oLanguage": {
					"sInfoPostFix": "unit test"
				}
			} );
			oTable.fnFilter("nothinghere");
		},
		function () { return document.getElementById('example_info').innerHTML = "Mostrando 0 a 0 de 0 registros unit (filtrando desde 57 total de registros) test"; }
	);
	
	
	oTest.fnComplete();
} );