// DATA_TEMPLATE: dom_data
oTest.fnStart( "fnFilter" );

$(document).ready( function () {
	/* Check the default */
	var oTable = $('#example').dataTable();
	oTable.fnFilter(1);
	
	oTest.fnTest( 
		"Filtering with a non-string input is valid",
		null,
		function () { return $('#example_info').html() == "Mostrando 1 a 10 de 32 registros (filtrando desde 57 total de registros)"; }
	);
	
	oTest.fnComplete();
} );