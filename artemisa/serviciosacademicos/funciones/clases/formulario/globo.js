if (!document.layers&&!document.all)
event="test"
function showtip2(current,e,text){
if (document.all&&document.readyState=="complete"){
document.all.tooltip2.innerHTML='<marquee style="border:1px solid black">'+text+'</marquee>'
document.all.tooltip2.style.pixelLeft=event.clientX+document.body.scrollLeft+10
document.all.tooltip2.style.pixelTop=event.clientY+document.body.scrollTop+10
document.all.tooltip2.style.visibility="visible"
}
else if (document.layers){
document.tooltip2.document.nstip.document.write('<b>'+text+'</b>')
document.tooltip2.document.nstip.document.close()
document.tooltip2.document.nstip.left=0
currentscroll=setInterval("scrolltip()",100)
document.tooltip2.left=e.pageX+10
document.tooltip2.top=e.pageY+10
document.tooltip2.visibility="show"
}
}
function hidetip2(){
if (document.all)
document.all.tooltip2.style.visibility="hidden"
else if (document.layers){
clearInterval(currentscroll)
document.tooltip2.visibility="hidden"
}
}

function scrolltip(){
if (document.tooltip2.document.nstip.left>=-document.tooltip2.document.nstip.document.width)
document.tooltip2.document.nstip.left-=5
else
document.tooltip2.document.nstip.left=150
}
