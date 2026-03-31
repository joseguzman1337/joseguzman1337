// DATA_TEMPLATE: empty_table
oTest.fnStart( "2600 - Display rewind when changing length" );

$(document).ready( function () {
	$('#example').dataTable( {
		"bServerSide": true,
		"sAjaxSource": "../../../examples/server_side/scripts/server_processing.php"
	} );
	
	oTest.fnWaitTest( 
		"Info correct on init",
		null,
		function () { return $('#example_info').html() == "Mostrando 1 a 10 de 57 registros"; }
	);
	
	oTest.fnWaitTest( 
		"Page 2",
		function () { $('#example_next').click(); },
		function () { return $('#example_info').html() == "Mostrando 11 a 20 de 57 registros"; }
	);
	
	oTest.fnWaitTest( 
		"Page 3",
		function () { $('#example_next').click(); },
		function () { return $('#example_info').html() == "Mostrando 21 a 30 de 57 registros"; }
	);
	
	oTest.fnWaitTest( 
		"Page 4",
		function () { $('#example_next').click(); },
		function () { return $('#example_info').html() == "Mostrando 31 a 40 de 57 registros"; }
	);
	
	oTest.fnWaitTest( 
		"Page 5",
		function () { $('#example_next').click(); },
		function () { return $('#example_info').html() == "Mostrando 41 a 50 de 57 registros"; }
	);
	
	oTest.fnWaitTest( 
		"Rewind",
		function () { $('#example_length select').val('100'); $('#example_length select').change(); },
		function () { return $('#example_info').html() == "Mostrando 1 a 57 de 57 registros"; }
	);
	
	oTest.fnComplete();
} );