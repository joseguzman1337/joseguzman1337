// DATA_TEMPLATE: dom_data
oTest.fnStart( "bPaginate" );

$(document).ready( function () {
	/* Check the default */
	$('#example').dataTable();
	
	oTest.fnTest( 
		"Pagiantion div exists by default",
		null,
		function () { return document.getElementById('example_paginate') != null; }
	);
	
	oTest.fnTest(
		"Information div takes paging into account",
		null,
		function () { return document.getElementById('example_info').innerHTML == 
			"Mostrando 1 a 10 de 57 registros"; }
	);
	
	/* Check can disable */
	oTest.fnTest( 
		"Pagiantion can be disabled",
		function () {
			oSession.fnRestore();
			$('#example').dataTable( {
				"bPaginate": false
			} );
		},
		function () { return document.getElementById('example_paginate') == null; }
	);
	
	oTest.fnTest(
		"Information div takes paging disabled into account",
		null,
		function () { return document.getElementById('example_info').innerHTML == 
			"Mostrando 1 a 57 de 57 registros"; }
	);
	
	/* Enable makes no difference */
	oTest.fnTest( 
		"Pagiantion enabled override",
		function () {
			oSession.fnRestore();
			$('#example').dataTable( {
				"bPaginate": true
			} );
		},
		function () { return document.getElementById('example_paginate') != null; }
	);
	
	
	
	oTest.fnComplete();
} );