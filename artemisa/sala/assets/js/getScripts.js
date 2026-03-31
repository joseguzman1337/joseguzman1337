$(document).ready(function(){
	console.log(loadScripts);
	for (var k in loadScripts) {
		console.log(loadScripts[ k ]);
	    $.getScript(loadScripts[ k ]);
	} 
});
