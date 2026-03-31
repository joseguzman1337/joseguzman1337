// DATA_TEMPLATE: js_data
oTest.fnStart( "oLanguage.oPaginate" );

/* Note that the paging language information only has relevence in full numbers */

$(document).ready( function () {
	/* Check the default */
	var oTable = $('#example').dataTable( {
		"aaData": gaaData,
		"sPaginationType": "full_numbers"
	} );
	var oSettings = oTable.fnSettings();
	
	oTest.fnTest( 
		"oLanguage.oPaginate defaults",
		null,
		function () {
			var bReturn = 
				oSettings.oLanguage.oPaginate.sFirst == "First" &&
				oSettings.oLanguage.oPaginate.sAnterior == "Anterior" &&
				oSettings.oLanguage.oPaginate.sSiguiente == "Siguiente" &&
				oSettings.oLanguage.oPaginate.sLast == "Last";
			return bReturn;
		}
	);
	
	oTest.fnTest( 
		"oLanguage.oPaginate defaults are in the DOM",
		null,
		function () {
			var bReturn = 
				$('#example_paginate .first').html() == "First" &&
				$('#example_paginate .previous').html() == "Anterior" &&
				$('#example_paginate .next').html() == "Siguiente" &&
				$('#example_paginate .last').html() == "Last";
			return bReturn;
		}
	);
	
	
	oTest.fnTest( 
		"oLanguage.oPaginate can be defined",
		function () {
			oSession.fnRestore();
			oTable = $('#example').dataTable( {
				"aaData": gaaData,
				"sPaginationType": "full_numbers",
				"oLanguage": {
					"oPaginate": {
						"sFirst":    "unit1",
						"sAnterior": "test2",
						"sSiguiente":     "unit3",
						"sLast":     "test4"
					}
				}
			} );
			oSettings = oTable.fnSettings();
		},
		function () {
			var bReturn = 
				oSettings.oLanguage.oPaginate.sFirst == "unit1" &&
				oSettings.oLanguage.oPaginate.sAnterior == "test2" &&
				oSettings.oLanguage.oPaginate.sSiguiente == "unit3" &&
				oSettings.oLanguage.oPaginate.sLast == "test4";
			return bReturn;
		}
	);
	
	oTest.fnTest( 
		"oLanguage.oPaginate definitions are in the DOM",
		null,
		function () {
			var bReturn = 
				$('#example_paginate .first').html() == "unit1" &&
				$('#example_paginate .previous').html() == "test2" &&
				$('#example_paginate .next').html() == "unit3" &&
				$('#example_paginate .last').html() == "test4";
			return bReturn;
		}
	);
	
	
	oTest.fnComplete();
} );