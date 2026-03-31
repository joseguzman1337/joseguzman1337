  var help_title;
  var help_text;
  var help_table;


  function obtenerUltimaFila()
  {var tr = document.createElement('TR');
   var td = document.createElement('TD');
   td.setAttribute('width','470');
   var vacio = document.createTextNode(' ');
   td.appendChild(vacio);
   tr.appendChild(td);
   var td2 = document.createElement('TD');
   td2.setAttribute('width','30');
   td2.setAttribute('align','center');

   var a = document.createElement('A');
   a.setAttribute('href','javascript:window.print();');
   var img = document.createElement('IMG');
   img.setAttribute('border','0');
   img.setAttribute('src','../images/printer.gif');
   img.setAttribute('width','32');
   img.setAttribute('height','32');
   
   a.appendChild(img);

   td2.appendChild(a);

   tr.appendChild(td2);
   
   return tr;
   }


  function tabla_texto()
  { var tabla = document.createElement('TABLE');
    tabla.setAttribute('width','480');
    tabla.setAttribute('border','0');
    tabla.setAttribute('align','center');
    tabla.setAttribute('cellpadding','0');
    tabla.setAttribute('cellspacing','0');

    var tr = document.createElement('TR');
    tr.setAttribute('valign','middle');
    
    var td1 = document.createElement('TD');
    td1.setAttribute('width','30');
    var img = document.createElement('IMG');
    img.setAttribute('src','../images/help.gif');
    img.setAttribute('width','22');
    img.setAttribute('height','22');
    td1.appendChild(img);
    tr.appendChild(td1);

    var td2 = document.createElement('TD');
    td2.setAttribute('width','450');
    td2.setAttribute('align','center');
    td2.style.fontFamily = 'Verdana';
    td2.style.color = '#000000';
    td2.style.fontSize = '9px';

    var texto = document.createTextNode('');
    td2.appendChild(texto);
    tr.appendChild(td2);

    var tbody = document.createElement('tbody');
    tabla.appendChild(tbody);
    tbody.appendChild(tr);
    var hr = document.createElement('HR');
    tr.appendChild(hr);
    
    help_text = texto;
    return tabla;
   }
     
  function initialize()
  {
   var newDiv = document.createElement('SPAN');
   newDiv.setAttribute('id','help_window');
   var theNewParagraph = document.createElement('P');
   theNewParagraph.style.color = '000000';
   theNewParagraph.style.fontSize = '9px';
   theNewParagraph.style.fontFamily= 'verdana';
   theNewParagraph.setAttribute('id','help_title');
   var theTextOfTheParagraph = document.createTextNode('titulo');

   newDiv.appendChild(theNewParagraph);
   
   /*var theText = document.createElement('P');
   theText.setAttribute('id','help_text');
   var theMainText = document.createTextNode('texto');
   theNewParagraph.appendChild(theMainText);
   newDiv.appendChild(theMainText); */

   var tabla = document.createElement('TABLE');
   var tr1 = document.createElement('TR');
   var td11 = document.createElement('TD');
   var midiv = document.createElement('DIV');
   

   
  var img = document.createElement('IMG');
  img.setAttribute('src','../images/square-lb.gif');
  img.setAttribute('width','8');
  img.setAttribute('height','8');
  var img2 = img.cloneNode(true);


  var tbody1 = document.createElement('tbody');

  tabla.setAttribute('width','480');
  tabla.setAttribute('border','0');
  tabla.setAttribute('align','center');
  tabla.setAttribute('cellpadding','0');
  tabla.setAttribute('cellspacing','0');
  tabla.setAttribute('bgcolor','#CCCCCC');
  tabla.style.backgroundColor = '#CCCCCC';
  tabla.style.position = 'absolute';
  tabla.style.top = 60;
  tabla.style.left = 60;
  tabla.style.border = 'thin solid #33CCCC';

  tbody1.setAttribute('bgcolor','#E4E4E4');
  tr1.setAttribute('align','left');
  tr1.setAttribute('valign','middle');
  tr1.setAttribute('bgcolor','#E4E4E4');
  tr1.setAttribute('height','10');
  td11.setAttribute('height','10');
//  td11.setAttribute('colspan','2');
  document.getElementsByTagName('body')[0].appendChild(tabla);
  tabla.style.visibility = 'hidden';
  midiv.setAttribute('align','center');

  var a1 = document.createElement('A');
  a1.setAttribute('href','javascript:ocultarVentana();');
  var img1 = document.createElement('IMG');
  img1.setAttribute('border','0');
  img1.setAttribute('src','../images/menos.gif');
  img1.setAttribute('width','8');
  img1.setAttribute('height','8');
  a1.appendChild(img1);
  var span = document.createElement('SPAN');
  span.setAttribute('align','left');
  span.appendChild(a1);
  var td10 = document.createElement('td');
  td10.appendChild(span);
  td10.setAttribute('height','10');


  tabla.appendChild(tbody1);
  tbody1.appendChild(tr1);
  tr1.appendChild(td10);
  tr1.appendChild(td11);
  theNewParagraph.appendChild(img);
  theNewParagraph.appendChild(theTextOfTheParagraph);
  theNewParagraph.appendChild(img2);
  midiv.appendChild(theNewParagraph);
  td11.appendChild(midiv);

  var tabla2 = tabla_texto();
  var tr2 = document.createElement('TR');
  tr2.setAttribute('align','center');
  tr2.setAttribute('valign','middle');
  tr2.setAttribute('colspan','2');
  tr2.style.backgroundColor = '#E4E4E4';

  var td22 = document.createElement('TD');
  td22.style.backgroundColor = '#E4E4E4';
  td22.setAttribute('colspan','2');
  td22.setAttribute('align','center');
  td22.appendChild(tabla2);
  tr2.appendChild(td22);
  tbody1.appendChild(tr2);

  var tr3 = obtenerUltimaFila();
  tbody1.appendChild(tr3);

  help_title = theTextOfTheParagraph;
  help_table = tabla;
  }

  
  function  mostrarVentana(titulo,texto)
  {
      help_title.nodeValue = titulo;
      help_text.nodeValue = texto;
      help_table.style.visibility = 'visible';
  }
  
  function  ocultarVentana()
  {
      help_table.style.visibility = 'hidden';
  }
  
