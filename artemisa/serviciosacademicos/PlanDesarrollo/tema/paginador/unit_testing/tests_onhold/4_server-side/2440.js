// DATA_TEMPLATE: empty_table
/*
 * NOTE: There are some differences in this zero config script for server-side
 * processing compared a the other data sources. The main reason for this is the
 * difference in how the server-side processing does it's filtering. Also the
 * sorting state is always reset on each draw.
 */
oTest.fnStart( "Info element with display all" );

$(document).ready( function () {
	var oTable = $('#example').dataTable( {
		"bServerSide": true,
		"sAjaxSource": "../../../examples/server_side/scripts/server_processing.php"
	} );
	
	oTable.fnSettings()._iDisplayLength = -1;
	oTable.oApi._fnCalculateEnd( oTable.fnSettings() );
	oTable.fnDraw();
	
	
	/* Basic checks */
	oTest.fnWaitTest( 
		"Check length is correct when -1 length given",
		null,
		function () {
			return document.getElementById('example_info').innerHTML == 
				"Mostrando 1 a 57 de 57 registros";
		}
	);
	
	oTest.fnComplete();
} );