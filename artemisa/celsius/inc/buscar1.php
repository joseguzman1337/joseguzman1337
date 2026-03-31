<HTML>
<HEAD>
<TITLE> New Document </TITLE>
<script language="javascript">
libros = new Array;
valoreslibros = new Array;
revistas = new Array;
valoresrevista = new Array;
tesis = new Array;
valorestesis = new Array;
congreso = new Array;
valorescongreso = new Array;
patentes = new Array;
valorespatentes = new Array;

function cargarlibros()
{         libros[0]="<? echo $Mensaje["tl-1"]; ?>";
          valoreslibros[0]="1";
          libros[1]="<? echo $Mensaje["tl-2"]; ?>";
          valoreslibros[1]="2";
          libros[2]="<? echo $Mensaje["tl-3"]; ?>";
          valoreslibros[2]="3";
          libros[3]="<? echo $Mensaje["tl-4"]; ?>";
          valoreslibros[3]="4";
		  document.formu.forma.length=0;
		  for (var i=0;i<4;i++){document.formu.forma.options[i]=new Option(libros[i],valoreslibros[i]);};
	     
		  }
function cargarrevistas()
{
revistas[0]="<? echo $Mensaje["tr-2"]; ?>";
valoresrevista[0]="1";
revistas[1]="<? echo $Mensaje["tr-3"]; ?>";
valoresrevista[1]="2";
revistas[2]="<? echo $Mensaje["tr-4"]; ?>";
valoresrevista[2]="3";
document.formu.forma.length=0;
for (var i=0;i<3;i++){document.formu.forma.options[i]=new Option(revistas[i],valoresrevista[i]);
};
}
function verificar()
 {
  if (document.formu.tipomaterial.value=="1")
     {    var l=cargarlibros();  
	  }
	  else if (document.formu.tipomaterial.value=="2")
	          { 
		        var r=cargarrevistas();		        	  
			   }
			    else if (document.formu.tipomaterial.value=="3")
                          {
					      tesis[0]="<? echo $Mensaje["tt-1"]; ?>";
                          valorestesis[0]="1";
                          tesis[1]="<? echo $Mensaje["tt-2"]; ?>";
                          valorestesis[1]="2";
                          tesis[2]="<? echo $Mensaje["tt-3"]; ?>";
                          valorestesis[2]="3";
                          tesis[3]="<? echo $Mensaje["tt-4"]; ?>";
                          valorestesis[3]="4";  
						  document.formu.forma.length=0;
						  for (var i=0;i<4;i++){document.formu.forma.options[i]=new Option(tesis[i],valorestesis[i]);};
				
						 }
					else if (document.formu.tipomaterial.value=="4")
                          {
				          congreso[0]="<? echo $Mensaje["tc-1"]; ?>";
                          valorescongreso[0]="1";
                          congreso[1]="<? echo $Mensaje["tc-2"]; ?>";
                          valorescongreso[1]="2";
                          congreso[2]="<? echo $Mensaje["tc-3"]; ?>";
                          valorescongreso[2]="3";
                          congreso[3]="<? echo $Mensaje["tc-4"]; ?>";
                          valorescongreso[3]="4";
						  document.formu.forma.length=0;
				          for (var i=0;i<4;i++){document.formu.forma.options[i]=new Option(congreso[i],valorescongreso[i]);};
						 
						  }
                         else if (document.formu.tipomaterial.value=="5")
                          {
					      patentes[0]="<? echo $Mensaje["tp-1"]; ?>";
						  valorespatentes[0]="1";
						  patentes[1]="<? echo $Mensaje["tp-2"]; ?>";
						  valorespatentes[1]="2";
						  patentes[2]="<? echo $Mensaje["tp-3"]; ?>";
						  valorespatentes[2]="3";
  						  document.formu.forma.length=0;
						  for (var i=0;i<3;i++){document.formu.forma.options[i]=new Option(patentes[i],valorespatentes[i]);
						  };
				          
						  }


  };

  function mandar()
    
	 {  if ((document.formu.tipomaterial.value!=0)&&( document.formu.forma.value!=0)&&(document.formu.buscar.value!=''))
	       {             document.formu.action="../buscar/busquedaAvanzada1.php?tipo="+document.formu.tipomaterial.value+"&forma="+document.formu.forma.value+"&titulo="+document.formu.buscar.value;
	         document.formu.submit;
		   }
		    else 
		     {alert("Deberia seleccionar todos los campo para realizar la consulta");
			  return false;};
			 
	
	};

</script>
</HEAD>

<body background="../imagenes/banda.jpg" onload="return cargarlibros()"; >
    <center><table border='1' width='400' bgcolor='#808080'><tr><td width='100%' align='center'><p align='center'><font face='MS Sans Serif' size='3' color='#FFFF00'><? echo $Mensaje["ec-1"];?></font></p></td></tr></table></center>
		
<FORM METHOD=POST onsubmit="return mandar()"; name="formu">


<TABLE border="0" width="70%" height="15%"  align="center" bgcolor="#0083AE">

<TR>
     <TD width='20%' align="right"><font face="MS Sans Serif" size="1" color="#FFFFFF"><? echo $Mensaje["ec-2"]; ?></font></td>
	  <td width='30%'><SELECT NAME="tipomaterial" size="1"  onchange="return verificar()";>
	      <option value="1"><? echo $Mensaje["tl-0"]; ?></option>
          <option value="2"><? echo $Mensaje["tr-0"]; ?></option>
          <option value="3"><? echo $Mensaje["tt-0"]; ?></option>
          <option value="4"><? echo $Mensaje["tc-0"]; ?></option>
          <option value="5"><? echo $Mensaje["tp-0"]; ?></option>
		  </SELECT>
	  </td>
	  <td  width='20%' align="right"><font face="MS Sans Serif" size="1" color="#FFFFFF"><? echo $Mensaje["ec-3"]; ?></font></td>
	  	<td width='30%'><SELECT NAME="forma" size="1" >
	     <script language="javascript"></script>
        </SELECT>
		</td>
</tr>
</table>
<TABLE border="0" width="70%" height="15%" align="center" bgcolor="#0083AE">
<tr>
	    <td align="right" width='50%'><font face="MS Sans Serif" size="1" color="#FFFFFF"><? echo $Mensaje["ec-4"];?></font></td><td  align="left"><INPUT TYPE="text" NAME="buscar" size='40'></td><td align="left" width='50%'><INPUT TYPE="submit" value="<? echo $Mensaje["bot-1"]; ?>"></td><td>&nbsp;</td>
</tr>
		  
     
</TABLE>
</form>

