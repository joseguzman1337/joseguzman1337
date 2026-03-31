// DATA_TEMPLATE: empty_table
oTest.fnStart( "bPaginate" );

$(document).ready( function () {
	/* Check the default */
	$('#example').dataTable( {
		"sAjaxSource": "../../../examples/ajax/sources/arrays.txt"
	} );
	
	oTest.fnWaitTest( 
		"Pagiantion div exists by default",
		null,
		function () { return document.getElementById('example_paginate') != null; }
	);
	
	oTest.fnWaitTest(
		"Information div takes paging into account",
		null,
		function () { return document.getElementById('example_info').innerHTML == 
			"Mostrando 1 a 10 de 57 registros"; }
	);
	
	/* Check can disable */
	oTest.fnWaitTest( 
		"Pagiantion can be disabled",
		function () {
			oSession.fnRestore();
			$('#example').dataTable( {
				"sAjaxSource": "../../../examples/ajax/sources/arrays.txt",
				"bPaginate": false
			} );
		},
		function () { return document.getElementById('example_paginate') == null; }
	);
	
	oTest.fnWaitTest(
		"Information div takes paging disabled into account",
		null,
		function () { return document.getElementById('example_info').innerHTML == 
			"Mostrando 1 a 57 de 57 registros"; }
	);
	
	/* Enable makes no difference */
	oTest.fnWaitTest( 
		"Pagiantion enabled override",
		function () {
			oSession.fnRestore();
			$('#example').dataTable( {
				"sAjaxSource": "../../../examples/ajax/sources/arrays.txt",
				"bPaginate": true
			} );
		},
		function () { return document.getElementById('example_paginate') != null; }
	);
	
	
	
	oTest.fnComplete();
} );