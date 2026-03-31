// DATA_TEMPLATE: empty_table
oTest.fnStart( "sPaginationType" );

$(document).ready( function () {
	/* Check the default */
	var oTable = $('#example').dataTable( {
		"sAjaxSource": "../../../examples/ajax/sources/objects.txt",
		"aoColumns": [
			{ "mData": "engine" },
			{ "mData": "browser" },
			{ "mData": "platform" },
			{ "mData": "version" },
			{ "mData": "grade" }
		]
	} );
	var oSettings = oTable.fnSettings();
	
	oTest.fnWaitTest( 
		"Check two button paging is the default",
		null,
		function () { return oSettings.sPaginationType == "two_button"; }
	);
	
	oTest.fnWaitTest( 
		"Check class is applied",
		null,
		function () { return $('#example_paginate').hasClass('paging_two_button'); }
	);
	
	oTest.fnWaitTest( 
		"Two A elements are in the wrapper",
		null,
		function () { return $('#example_paginate a').length == 2; }
	);
	
	oTest.fnWaitTest( 
		"We have the previous button",
		null,
		function () { return document.getElementById('example_previous'); }
	);
	
	oTest.fnWaitTest( 
		"We have the next button",
		null,
		function () { return document.getElementById('example_next'); }
	);
	
	oTest.fnWaitTest( 
		"Anterior button is disabled",
		null,
		function () { return $('#example_previous').hasClass('paginate_disabled_previous'); }
	);
	
	oTest.fnWaitTest( 
		"Siguiente button is enabled",
		null,
		function () { return $('#example_next').hasClass('paginate_enabled_next'); }
	);
	
	/* Don't test paging - that's done by the zero config test script. */
	
	
	/* Two buttons paging */
	var bComplete = false;
	oTest.fnWaitTest( 
		"Can enabled full numbers paging",
		function () {
			oSession.fnRestore();
			oTable = $('#example').dataTable( {
				"sAjaxSource": "../../../examples/ajax/sources/objects.txt",
				"aoColumnDefs": [
					{ "mData": "engine", "aTargets": [0] },
					{ "mData": "browser", "aTargets": [1] },
					{ "mData": "platform", "aTargets": [2] },
					{ "mData": "version", "aTargets": [3] },
					{ "mData": "grade", "aTargets": [4] }
				],
				"sPaginationType": "full_numbers",
				"fnInitComplete": function () {
					bComplete = true;
				}
			} );
			oSettings = oTable.fnSettings();
		},
		function () {
			if ( bComplete )
				return oSettings.sPaginationType == "full_numbers";
			else
				return false;
		}
	);
	
	oTest.fnWaitTest( 
		"Check full numbers class is applied",
		null,
		function () { return $('#example_paginate').hasClass('paging_full_numbers'); }
	);
	
	
	var nFirst, nAnterior, nSiguiente, nLast;
	oTest.fnWaitTest( 
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
	
	oTest.fnWaitTest( 
		"Go a two pages previous",
		function () {
			nAnterior.click();
			nAnterior.click();
		},
		function () {
			return document.getElementById('example_info').innerHTML == "Mostrando 31 a 40 de 57 registros";
		}
	);
	
	oTest.fnWaitTest( 
		"Siguiente (second last) page",
		function () {
			nSiguiente.click();
		},
		function () {
			return document.getElementById('example_info').innerHTML == "Mostrando 41 a 50 de 57 registros";
		}
	);
	
	oTest.fnWaitTest( 
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