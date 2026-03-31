<style type="text/css">
/*body{
	 background:#fff;
	 font:bold 12px Arial, Helvetica, sans-serif;
	 margin:0;
	 padding:0;
	 min-width:960px;
	 color:#bbbbbb; 
}*/

a { 
	text-decoration:none; 
	color:#00c6ff;
}

h1 {
	font: 4em normal Arial, Helvetica, sans-serif;
	padding: 20px;	margin: 0;
	text-align:center;
}

h1 small{
	font: 0.2em normal  Arial, Helvetica, sans-serif;
	text-transform:uppercase; letter-spacing: 0.2em; line-height: 5em;
	display: block;
}

h2 {
    font-weight:700;
    color:#bbb;
    font-size:10px;
}

h2, p {
	margin-bottom:10px;
}

@font-face {
    font-family: 'BebasNeueRegular';
    src: url('../relojdigital/BebasNeue-webfont.eot');
    src: url('../relojdigital/BebasNeue-webfont.eot?#iefix') format('embedded-opentype'),
         url('../relojdigital/BebasNeue-webfont.woff') format('woff'),
         url('../relojdigital/BebasNeue-webfont.ttf') format('truetype'),
         url('../relojdigital/BebasNeue-webfont.svg#BebasNeueRegular') format('svg');
    font-weight: normal;
    font-style: normal;

}

.container {width: 100%; margin: 0 auto; overflow: hidden;}

.clock { margin:0 auto;  solid #333; color:#fff; }

#Date { font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; font-size:16px; text-align:right; text-shadow:0 0 5px #00c6ff; }

ul { width:100%; margin:0 auto; padding:0px; list-style:none; text-align:right; }
ul li { display:inline; font-size:2em; text-align:right; font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; text-shadow:0 0 50px #00c6ff; }

#point { position:relative; -moz-animation:mymove 1s ease infinite; -webkit-animation:mymove 1s ease infinite; padding-left:10px; padding-right:10px; }

@-webkit-keyframes mymove 
{
0% {opacity:1.0; text-shadow:0 0 20px #00c6ff;}
50% {opacity:0; text-shadow:none; }
100% {opacity:1.0; text-shadow:0 0 20px #00c6ff; }	
}


@-moz-keyframes mymove 
{
0% {opacity:1.0; text-shadow:0 0 20px #00c6ff;}
50% {opacity:0; text-shadow:none; }
100% {opacity:1.0; text-shadow:0 0 20px #00c6ff; }	
}

</style>

<script type="text/javascript" src="../relojdigital/reloj.js"></script>
<script type="text/javascript">
$(document).ready(function() {
// Creamos 2 variables con los nombres de los meses.
var monthNames = [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre" ]; 
var dayNames= ["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"]

// Cramos un dato newDate()
var newDate = new Date(<?PHP echo strtotime('NOW')*1000;?>);
var diferencia = new Date - newDate;

// Extraemos la hora del objecto
newDate.setDate(newDate.getDate());

$('#Date').html(dayNames[newDate.getDay()] + " " + newDate.getDate() + ' ' + monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear());



setInterval( function() {
	// Creamos los newDate() y extraemos los segundos
    var fecha = new Date();
    fecha.setTime(fecha.getTime()+diferencia);
	var seconds = fecha.getSeconds();
    
 
	$("#sec").html(( seconds < 10 ? "0" : "" ) + seconds);
	},1000);
	
setInterval( function() {
	// Creamos un newDate() y extraemos los minutos
    var fecha = new Date();
    fecha.setTime(fecha.getTime()+diferencia);
 
	var minutes = fecha.getMinutes();

	$("#min").html(( minutes < 10 ? "0" : "" ) + minutes);
    },1000);
	
setInterval( function() {
	//Creamos un newDate() y extraemos la hora
    var fecha = new Date();
    fecha.setTime(fecha.getTime()-diferencia);
	var hours = fecha.getHours();
    
    if(hours==00 || hours=='00'){
         var newDate = new Date();
          newDate.setTime(newDate.getTime()-diferencia);
        
        // Extraemos la hora del objecto
        newDate.setDate(newDate.getDate());
        // Sacamos dia, mes y año
        $('#Date').html(dayNames[newDate.getDay()] + " " + newDate.getDate() + ' ' + monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear());
    }
	// Add a leading zero to the hours value
	$("#hours").html(( hours < 10 ? "0" : "" ) + hours);
    }, 1000);
	
}); 
</script>

<div class="container">
<div class="clock">
<div id="Date"></div>
<ul>
	<li id="hours"> </li>
    <li id="point">:</li>
    <li id="min"> </li>
    <li id="point">:</li>
    <li id="sec"> </li>
</ul>

</div>
</div>
</body>
</html>
