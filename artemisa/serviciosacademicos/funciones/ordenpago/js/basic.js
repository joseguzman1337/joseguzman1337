/*
 * SimpleModal Basic Modal Dialog
 * http://www.ericmmartin.com/projects/simplemodal/
 * http://code.google.com/p/simplemodal/
 *
 * Copyright (c) 2010 Eric Martin - http://ericmmartin.com
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Revision: $Id: basic.js 254 2010-07-23 05:14:44Z emartin24 $
 */

jQuery(function ($) {
	// Load dialog on page load
	//$('#basic-modal-content').modal();
	// Load dialog on click
	$('#basic-modal .basic').click(function (e) {
		$('#basic-modal-content').modal();             
                CargarOrden();
		return false;
	});
});

function CargarOrden(id){
    var codigocarrera = document.getElementById("codigocarrera").value;
    var codigoestudiante = document.getElementById("codigoestudiante").value;

    $.get("OrdenPagoAjax.php", "crearorden=true&codigoestudiante="+codigoestudiante + "&codigocarrera=" + codigocarrera, function(resultado) {
        element = document.getElementById("ordenpagoid");
        $(element).html(resultado);
   });
}
function additem(id){
    $('#detalle').modal();
}
