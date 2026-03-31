<script type="text/javascript">
function createRequestObject()
{
	var ro;
	var browser = navigator.appName;
	if(browser == 'Microsoft Internet Explorer')
	{
		ro = new ActiveXObject("Microsoft.XMLHTTP");
	} else
	{
		ro = new XMLHttpRequest();
	}
	return ro;
}
function handleTimestamp() {
	if(map.handleTimestamp.ajax.readyState == 4) {
		var response = map.handleTimestamp.ajax.responseText;
		if(response != timestamp) {
			timestamp = response;
		}
	}
}
function handleFoo() {
	if(map.handleUsersOnline.ajax.readyState == 4) {
		var response = map.handleFoo.ajax.responseText;
		if(response != 'noupdate') {
			document.getElementById('foo').innerHTML = response;
		}
	}
}
var map = {
	handleTimestamp:{
		ajax: createRequestObject(),
		handler: handleTimestamp
	},
	handleFoo:{
		ajax: createRequestObject(),
		handler: handleFoo
	}
};
function sndReq(timestamp, action) {
	map[action].ajax.open('get', 'ajax.php?time='+timestamp+
	'&action='+action+'&nocache='+Date());
	map[action].ajax.onreadystatechange = map[action].handler
	map[action].ajax.send(null);
}
function reqUpdates(timestamp) {
	sndReq(timestamp, 'handleTimestamp');
	sndReq(timestamp, 'handleFoo');
}
var timestamp = '<?php echo time(); ?>';
setInterval("reqUpdates(timestamp)", 30000);
</script>