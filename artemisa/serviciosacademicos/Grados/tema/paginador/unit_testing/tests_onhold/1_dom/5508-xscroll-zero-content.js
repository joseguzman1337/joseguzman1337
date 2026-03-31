// DATA_TEMPLATE: dom_data
oTest.fnStart( "5508 - Table container width doesn't change when filtering applied a scrolling table" );

$(document).ready( function () {
	$('#example').dataTable( {
		"sScrollY": "300px",
		"bPaginate": false
	} );
	
	oTest.fnTest( 
		"Width de container 800px on init with scroll",
		null,
		function () { return $('div.dataTables_scrollBody').width() == 800; }
	);
	
	oTest.fnTest( 
		"Unaltered when filter applied",
		function () { $('#example').dataTable().fnFilter('123'); },
		function () { return $('div.dataTables_scrollBody').width() == 800; }
	);
	
	oTest.fnComplete();
} );