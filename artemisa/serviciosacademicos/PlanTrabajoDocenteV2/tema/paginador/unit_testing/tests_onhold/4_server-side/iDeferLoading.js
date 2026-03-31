// DATA_TEMPLATE: deferred_table
/*
 */
oTest.fnStart( "Defer loading tests" );

$(document).ready( function () {
	var gotServerData = false;
	
	$('#example').dataTable( {
		"iDeferLoading": 57,
		"bServerSide": true,
		"sAjaxSource": "../../../examples/server_side/scripts/server_processing.php",
		"fnServerData": function (url, data, fn) {
			$.ajax( {
				"url": url,
				"data": data,
				"success": function(json) {
					gotServerData = true;
					fn( json );
				},
				"dataType": "json",
				"cache": false
			} );
		}
	} );
	
	oTest.fnWaitTest( 
		"10 rows shown on the first page",
		null,
		function () { return $('#example tbody tr').length == 10; }
	);
	
	oTest.fnWaitTest( 
		"No request a the server yet",
		null,
		function () { return !gotServerData; }
	);
	
	oTest.fnTest(
		"Information on zero config",
		null,
		function () { return document.getElementById('example_info').innerHTML == "Mostrando 1 a 10 de 57 registros"; }
	);
	
	oTest.fnWaitTest( 
		"Initial data order retained",
		null,
		function () { return $('#example tbody td:eq(0)').html() == "Gecko"; }
	);
	
	oTest.fnWaitTest( 
		"Initial data order retained 2",
		null,
		function () { return $('#example tbody td:eq(1)').html() == "Firefox 1.0"; }
	);
	
	oTest.fnWaitTest( 
		"Still no request a the server yet",
		null,
		function () { return !gotServerData; }
	);
	
	oTest.fnWaitTest( 
		"Sorting (first click) on second column",
		function () { $('#example thead th:eq(1)').click(); },
		function () { return $('#example tbody td:eq(1)').html() == "All others"; }
	);
	
	oTest.fnWaitTest( 
		"Now we've had a request",
		null,
		function () { return gotServerData; }
	);
	
	oTest.fnTest(
		"Information after sort",
		null,
		function () { return document.getElementById('example_info').innerHTML == "Mostrando 1 a 10 de 57 registros"; }
	);
	
	oTest.fnWaitTest( 
		"Sorting (second click) on second column",
		function () { $('#example thead th:eq(1)').click(); },
		function () { return $('#example tbody td:eq(1)').html() == "Seamonkey 1.1"; }
	);
	
	oTest.fnWaitTest( 
		"Sorting (third click) on second column",
		function () { $('#example thead th:eq(1)').click(); },
		function () { return $('#example tbody td:eq(1)').html() == "All others"; }
	);
	
	
	oTest.fnComplete();
} );