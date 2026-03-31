var objtmp;
var objseleccionado;
var estadomousesobre=false;
var rowsini ;
var posicioninicial=0;
var posicionfinal=0;
function mousesobre(obj){
//alert("Sobre el objeto ="+obj.innerHTML);

if(estadodrag==true)
objtmp=obj;

estadomousesobre=true;
}
function seleccionafila(obj){
//alert("clase objeto="+obj.className);
if(objseleccionado!=null)
objseleccionado.className="alt";

objseleccionado=obj;
objseleccionado.className="myDragClass";
//alert("Sobre el objeto ="+obj.innerHTML);
//objtmp=obj;

}
$(document).ready(function() {

	// Initialise the first table (as before)
	$("#table-1").tableDnD();

	// Make a nice striped effect on the table
	//$("#table-2 tr:even').addClass('alt')");

	// Initialise the second table specifying a dragClass and an onDrop function that will display an alert
	$("#table-2").tableDnD({
	    onDragClass: "myDragClass",
	    onDrop: function(table, row) {
		
            var rows = table.tBodies[0].rows;
            var debugStr = "Row dropped was "+row.id+". New order: ";


	  //  alert(row.innerHTML);
	//alert("Sobre el objeto ="+objtmp.innerHTML);
	/*	if(rowsini!=null)
		alert("largo ini "+rowsini.length);
		else
		alert("largo ini no iniciado");*/

            for (var i=0; i<rows.length; i++) {
              //  debugStr += rows[i].id+" ";
		if(row.id==rowsini[i].id){
			posicionfinal=i;
			//alert("posicionfinal=" + posicionfinal);
		}
            }
		if(posicioninicial!=posicionfinal){
			if(estadomousesobre==true){
				//row.innerHTML = "" + row.innerHTML
				//img".$contadoritem."
				document.getElementById("img"+row.id).width=document.getElementById("img"+row.id).width+20;
			}	
			//alert("cambio de " + posicioninicial + " a " + posicionfinal);
		}
		//else
		//	alert("no cambio de " + posicioninicial + " a " + posicionfinal);

	        //$("#debugArea").html(debugStr);
		estadomousesobre=false;
	    },
	    onDragStart: function(table, row) {
			$("#debugArea").html("Started dragging row "+row.id);
			rowsini = table.tBodies[0].rows;
		 	 for (var i=0; i<rowsini.length; i++) {
               // debugStr += rows[i].id+" ";
				if(row.id==rowsini[i].id){
					posicioninicial=i;
					//alert("posicioninicial=" + posicioninicial);
				}
            		}
			estadodrag=true;
		}
	});
});

