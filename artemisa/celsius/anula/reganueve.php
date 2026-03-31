<?
   include_once "../inc/"."var.inc.php";
   include_once "../inc/conexion.inc.php";  
   Conexion();	
   include_once "../inc/identif.php"; 
   include_once "../inc/"."funcarch.php";
   Administracion();
   
 ?>

<html>

<head>
<title>PrEBi</title>
<style type="text/css">
<!--
body {
	margin:0px;
	background-color: #006599;
	margin-left: 10px;
}
body, td, th {
	color: #000000;
}
a:link {
	color: #006599;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #006599;
}
a:hover {
	text-decoration: underline;
	color: #0099FF;
}
a:active {
	text-decoration: none;
	color: #006599;
}
.style7 {color: #2D6FAC; font-size: 10px; }
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 9px; }
.style14 {
	font-size: 10px;
	font-family: Verdana;
	color: #FFFFFF;
}
.style15 {color: #006599}
.style17 {
	font-size: 9px;
	font-family: Verdana;
	color: #000000;
}
.style18 {color: #006699}
.style20 {color: #E4E4E4}
.style23 {font-size: 10}
.style24 {
	color: #000000;
	font-size: 9px;
	font-family: verdana;
}
.style26 {color: #006699; font-weight: bold; }
.style28 {font-size: 11px}
-->
</style>

</head>
<script language="JavaScript">
function actualizar ()
{  self.opener.document.forms[0].action='anulaeve.php'
   self.opener.document.forms[0].submit(); 
   return true;
}

</script>
<body>
<? 
if (!isset($Estado))
  $Estado = '';
function Obtener_Datos ($Pedido)
{
 // Esta función va a recorrer los eventos del pedido
 // (ya eliminado el que se desea anular)
 // y va a re-establecer las fechas que correspondan
 // Esto sirve suponiendo que registren dos veces solicitud
 // y anulan una de ellas para que quede registrada como
 // solicitud la fecha anterior
 
  $Instruccion = "SELECT Codigo_Evento,Fecha,";
  $Instruccion.= "Codigo_Pais,Codigo_Institucion,Codigo_Dependencia,";
  $Instruccion.= "Numero_Paginas,Operador";
  $Instruccion.= " FROM Eventos WHERE Eventos.Id_Pedido='".$Pedido."'";
  $result = mysql_query ($Instruccion);
  echo mysql_error();
  
  $Numero_Paginas = 0;
  $Ultimo_Operador = 0;
  $Ultimo_Estado = 1;
  $Ultimo_Pais = 0;
  $Ultima_Institucion = 0;
  $Ultima_Dependencia = 0;
  

  $Fecha_Inicio_Busqueda = 0;
  $Fecha_Solicitado = 0;
  $Fecha_Recepcion = 0;
  $Fecha_Entrega = 0; 

  while ($row=mysql_fetch_row($result))  
  {
    if ($row[0]!=Devuelve_Evento_Observado())
	{
  	  $Ultimo_Estado = Determinar_Estado($row[0]);	  
      $Numero_Paginas = $row[5];
	  $Ultimo_Operador = $row[6];
	  $Ultimo_Pais = $row[2];
	  $Ultima_Institucion = $row[3];
	  $Ultima_Dependencia = $row[4];
	 } 

	switch ($row[0])
	{
	  case Devuelve_Evento_Tomado():
			$Fecha_Inicio_Busqueda = $row[1];
			break;
	  case Devuelve_Evento_Solicitado():	
	    	$Fecha_Solicitado = $row[1];
			break;
	  case Devuelve_Evento_recepcion():		
		    $Fecha_Recepcion = $row[1];
			break;
	  case Devuelve_Evento_entrega():		
			$Fecha_Entrega = $row[1];
			break;
      default: {
		  $Fecha_Inicio_Busqueda = 0;
		  $Fecha_Solicitado = 0;
		  $Fecha_Recepcion = 0;
		  $Fecha_Entrega = 0; 
	  }
	}
  }
  
  $vector = array ($Ultimo_Estado,$Ultimo_Pais,$Ultima_Institucion,$Ultima_Dependencia,$Numero_Paginas,$Ultimo_Operador,$Fecha_Inicio_Busqueda,$Fecha_Solicitado,$Fecha_Recepcion,$Fecha_Entrega);
  mysql_free_result($result);
  return $vector;
  
}

function Roll_Back_Datos ($Id_Pedido)
{
   
   $vector = Obtener_Datos ($Id_Pedido);	
   
   $Instruccion = "SELECT Fecha_Alta_Pedido FROM Pedidos WHERE Pedidos.Id='".$Id_Pedido."'";
   $result = mysql_query($Instruccion);
   $row = mysql_fetch_row($result);
   mysql_free_result($result);
   
   if ($vector[6]!="''")
   {  $Tardanza_Atencion = Calcular_Dias($row[0],$vector[6]);  } 
   else
   {  $Tardanza_Atencion = 0; }
   
   if ($vector[7]!="''")
   {  $Tardanza_Busqueda = Calcular_Dias($vector[6],$vector[7]);   } 
   else
   {  $Tardanza_Busqueda = 0; }
   
   if ($vector[8]!="''")
   {  $Tardanza_Recepcion = Calcular_Dias($vector[7],$vector[8]);  }
   else
   {  $Tardanza_Recepcion = 0; }	 

   $Instruccion = "UPDATE Pedidos SET Estado=".$vector[0];
   $Instruccion.= ",Ultimo_Pais_Solicitado=".$vector[1];	
   $Instruccion.= ",Ultima_Institucion_Solicitado=".$vector[2];	
   $Instruccion.= ",Ultima_Dependencia_Solicitado=".$vector[3];	
   $Instruccion.= ",Numero_Paginas=".$vector[4];	
   $Instruccion.= ",Operador_Corriente=".$vector[5];	
   $Instruccion.= ",Fecha_Inicio_Busqueda='".$vector[6]."'";	
   $Instruccion.= ",Fecha_Solicitado='".$vector[7]."'";	
   $Instruccion.= ",Fecha_Recepcion='".$vector[8]."'";		
   $Instruccion.= ",Fecha_Entrega='".$vector[9]."'";		   
   $Instruccion.= ",Tardanza_Atencion=".$Tardanza_Atencion;
   $Instruccion.= ",Tardanza_Busqueda=".$Tardanza_Busqueda;
   $Instruccion.= ",Tardanza_Recepcion=".$Tardanza_Recepcion;
   $Instruccion.= " WHERE Id='".$Id_Pedido."'";
   $result = mysql_query($Instruccion);
}


  include_once "../inc/fgenhist.php";
  include_once "../inc/fgentrad.php";
  global $IdiomaSitio; 
   $Mensajes = Comienzo ("gen-anu",$IdiomaSitio);
  
  // Esto borra el evento y los inserta en las tablas de 
  // Eventos anulados.
  
  Baja_Eventos_anulados ($Id_Evento,2,$Fecha_Anulacion,$Causa_Anulacion,$Id_usuario);
  Roll_Back_Datos ($Id_Pedido,$Estado);
  if (!isset($dedonde))
    $dedonde = 0;

?>
<style type="text/css">
<!--
body {
	margin:0px;
	background-color: #006599;
	margin-left: 10px;
}
body, td, th {
	color: #000000;
}
a:link {
	color: #006599;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #006599;
}
a:hover {
	text-decoration: underline;
	color: #0099FF;
}
a:active {
	text-decoration: none;
	color: #006599;
}
.style7 {color: #2D6FAC; font-size: 10px; }
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 9px; }
.style14 {
	font-size: 10px;
	font-family: Verdana;
	color: #FFFFFF;
}
.style15 {color: #006599}
.style17 {
	font-size: 9px;
	font-family: Verdana;
	color: #000000;
}
.style18 {color: #006699}
.style20 {color: #E4E4E4}
.style23 {font-size: 10}
.style24 {
	color: #000000;
	font-size: 9px;
	font-family: verdana;
}
.style26 {color: #006699; font-weight: bold; }
.style28 {font-size: 11px}
-->
</style>
<script>

var secs = 10;
var timerID = null
var timerRunning = false
var delay = 1000

function InitializeTimer()
{
    // Set the length of the timer, in seconds
    secs = 4
    StopTheClock()
    StartTheTimer()
    document.forms.form1.B2.value = document.forms.form1.textButton.value + '(' + secs + ')';
}

function StopTheClock()
{
    if(timerRunning)
        clearTimeout(timerID)
    timerRunning = false
    

}

function StartTheTimer()
{
    if (secs==0)
    {
        StopTheClock()
        // Here's where you put something useful that's
        // supposed to happen after the allotted time.
        // For example, you could display a message:
        window.close();
		window.opener.document.forms.form1.action='elige_trad.php';
        window.opener.document.forms.form1.submit(); 

    }
    else
    {
        self.status = secs
        document.forms.form1.B2.value = document.forms.form1.textButton.value + '(' + secs + ')';
        secs = secs - 1
     
        timerRunning = true
        timerID = self.setTimeout("StartTheTimer()", delay)
    }
}

</script>
<body topmargin="0">
<div align="left">

  <table width="780" border="0" align="left" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#E4E4E4" style="border-collapse: collapse">
  <tr>
    <td valign="top" bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <span align="center">
        <center>
          <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#E4E4E4">
        <td valign="top" bgcolor="#E4E4E4">
            <span align="center">
              <center>
                <table width="97%" border="0" style="margin-bottom: 0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
              <tr>
                <td class="style17" align=left><blockquote>
                  <p class="style17 style23"><span class="style28"> <? echo $Mensajes["ec-1"]; ?> <span class="style26">
				  <? if ($dedonde==2){
		     echo $row[2].",".$row[3]; }
			else {
			 echo $Usuario; }  ?> 
			 </span> </span></p>
                          <p class="style17 style28">
			             <? echo $Mensajes["tf-3"]." ".$Usuario." ".$Mensajes["tf-5"]." ".$Id_Evento; ?>
						  </p>

                </td>
				</tr> <form name="form1"> 
				<tr> <td class="style17" align=riçht>
				     <center>
                      <input type="button" value="<? echo $Mensajes["bot-3"]; ?>" name="B2" class="style24  " OnClick="javascript:self.close();">
                      <input type='hidden' name='textButton' value="<? echo $Mensajes["bot-3"]; ?>">
					  </form>
					  </center>
				</td> </tr>
				</table> </center> </span> </td> </tr> </table> </center> </span> </td> </tr> 
				<tr> <td> cp: gen-anu </td> </tr> 
				</table> </div>

<? 
	Desconectar();
?>

<script language="Javascript">
	actualizar()
	InitializeTimer()
</script>
</body>
</html>
















