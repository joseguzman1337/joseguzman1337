// DATA_TEMPLATE: dom_data
oTest.fnStart( "sPaginationType" );

$(document).ready( function () {
	/* Check the default */
	var oTable = $('#example').dataTable();
	var oSettings = oTable.fnSettings();
	
	oTest.fnTest( 
		"Check two button paging is the default",
		null,
		function () { return oSettings.sPaginationType == "two_button"; }
	);
	
	oTest.fnTest( 
		"Check class is applied",
		null,
		function () { return $('#example_paginate').hasClass('paging_two_button'); }
	);
	
	oTest.fnTest( 
		"Two A elements are in the wrapper",
		null,
		function () { return $('#example_paginate a').length == 2; }
	);
	
	oTest.fnTest( 
		"We have the previous button",
		null,
		function () { return document.getElementById('example_previous'); }
	);
	
	oTest.fnTest( 
		"We have the next button",
		null,
		function () { return document.getElementById('example_next'); }
	);
	
	oTest.fnTest( 
		"Anterior button is disabled",
		null,
		function () { return $('#example_previous').hasClass('paginate_disabled_previous'); }
	);
	
	oTest.fnTest( 
		"Siguiente button is enabled",
		null,
		function () { return $('#example_next').hasClass('paginate_enabled_next'); }
	);
	
	/* Don't test paging - that's done by the zero config test script. */
	
	
	/* Two buttons paging */
	oTest.fnTest( 
		"Can enabled full numbers paging",
		function () {
			oSession.fnRestore();
			oTable = $('#example').dataTable( {
				"sPaginationType": "full_numbers"
			} );
			oSettings = oTable.fnSettings();
		},
		function () { return oSettings.sPaginationType == "full_numbers"; }
	);
	
	oTest.fnTest( 
		"Check full numbers class is applied",
		null,
		function () { return $('#example_paginate').hasClass('paging_full_numbers'); }
	);
	
	
	var nFirst, nAnterior, nSiguiente, nLast;
	oTest.fnTest( 
		"Jump a last page",
		function () {
			nFirst = $('div.dataTables_paginate a.first');
			nAnterior = $('div.dataTables_paginate a.previous');
			nSiguiente = $('div.dataTables_paginate a.next');
			nLast = $('div.dataTables_paginate a.last');
			nLast.click();
		},
		function () {
			return document.getElementById('example_info').innerHTML == "Mostrando 51 a 57 de 57 registros";
		}
	);
	
	oTest.fnTest( 
		"Go a two pages previous",
		function () {
			nAnterior.click();
			nAnterior.click();
		},
		function () {
			return document.getElementById('example_info').innerHTML == "Mostrando 31 a 40 de 57 registros";
		}
	);
	
	oTest.fnTest( 
		"Siguiente (second last) page",
		function () {
			nSiguiente.click();
		},
		function () {
			return document.getElementById('example_info').innerHTML == "Mostrando 41 a 50 de 57 registros";
		}
	);
	
	oTest.fnTest( 
		"Jump a first page",
		function () {
			nFirst.click();
		},
		function () {
			return document.getElementById('example_info').innerHTML == "Mostrando 1 a 10 de 57 registros";
		}
	);
	
	
	oTest.fnComplete();
} );