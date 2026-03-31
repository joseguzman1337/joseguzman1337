<?
      
   include_once "../inc/var.inc.php";
   include_once "../inc/conexion.inc.php";
   Conexion();	
   include_once "../inc/identif.php";
   Administracion();

  include_once "../inc/"."fgenped.php";
  include_once "../inc/"."fgentrad.php";
   global $IdiomaSitio;
   $Mensajes = Comienzo ("fid-001",$IdiomaSitio);  

   if (! isset($Id))			$Id = "";
   if (! isset($operacion))		$operacion=0;
   


	if ($operacion==1)
	{
	
       $Instruccion = "SELECT Nombre,";
		for ($i=0;$i<=6;$i++)
		{
			$Instruccion=$Instruccion.$i."_Dia,";
		}
		for ($i=1;$i<=12;$i++)
		{
			$Instruccion=$Instruccion.$i."_Mes,";
		}
		for ($i=1;$i<=12;$i++)
		{
			$Instruccion=$Instruccion."Evento".$i.",";
		}
		
		for ($i=1;$i<=3;$i++)
		{
			$Instruccion=$Instruccion."Eventos_Mail_".$i.",";
		}
		
		for ($i=1;$i<=10;$i++)
		{
			$Instruccion=$Instruccion."Estado_".$i."_Pedidos_S,";
			$Instruccion=$Instruccion."Estado_".$i."_Pedidos_P,";
		}
		for ($i=1;$i<=5;$i++)
		{
			$Instruccion=$Instruccion."Tipo_Pedido_".$i.",";
		}

		$Instruccion=$Instruccion."Perfil_Biblio_1,Perfil_Biblio_2,Perfil_Biblio_3,Operacion_1,Operacion_2,Predeterminado FROM Idiomas WHERE Id=".$Id;
		$result=mysql_query ($Instruccion);
		echo mysql_error();
		$row = mysql_fetch_row($result);		
	}
?>
<html>

<head>
<title>PrEBi |</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
	color: #000000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #000000;
}
a:hover {
	text-decoration: underline;
	color: #0099FF;
}
a:active {
	text-decoration: none;
	color: #000000;
}
.style22 {
	color: #333333;
	font-family: verdana;
	font-size: 9px;
}
.style33 {
	font-family: verdana;
	font-size: 9px;
	color: #006699;
}
a.style60 {
	font-family: verdana;
	font-size: 9px;
	color: #006699;
}

.style39 {color: #006699}

.style40 {
	color: #FFFFFF;
	font-family: Verdana;
	font-size: 9px;
}
.style41 {color: #006599}
-->
</style>
<base target="_self">
</head>



<body topmargin="0">
<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <div align="center">
        <center>
      <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
       <tr bgcolor="#EFEFEF" >
        <td valign="top" bgcolor="#E4E4E4" valign="top">            <div  align="center">
              
			     <form name="form1" method="POST" action="upd_idioma.php">
  					  <input type="hidden" name="operacion" value="<? echo $operacion; ?>">
					  <input type="hidden" name="Id" value=<? echo $Id; ?>>                

				  <table width="97%" border="0" cellpadding="1" cellspacing="0" valign="top">
                  <tr>
                    <td height="20" align="right" valign="middle" bgcolor="#006699" colspan=2 class="style22"><div align="left" class="style40"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["et-1"]?></td>
                    </tr>
                  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-1"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Categoria" size="54" value="<? if (isset($row))echo $row[0]; ?>">
                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-2"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Dia1" size="20" value="<? if (isset($row))echo $row[1]; ?>">                       
                      </div></td>
                  </tr>
				    
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-3"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Dia2" size="20" value="<? if (isset($row))echo $row[2]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-4"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Dia3" size="20" value="<? if (isset($row))echo $row[3]; ?>">                       
                      </div></td>
                  </tr>
				   <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-5"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Dia4" size="20" value="<? if (isset($row))echo $row[4]; ?>">                       
                      </div></td>
                  </tr>
				   <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-6"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Dia5" size="20" value="<? if (isset($row))echo $row[5]; ?>">                       
                      </div></td>
                  </tr>
				   <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-7"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Dia6" size="20" value="<? if (isset($row))echo $row[6]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-8"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Dia7" size="20" value="<? if (isset($row))echo $row[7]; ?>">                       
                      </div></td>
                  </tr>
				   <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-9"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Mes1" size="20" value="<? if (isset($row))echo $row[8]; ?>">                       
                      </div></td>
                  </tr>
				   <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-10"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Mes2" size="20" value="<? if (isset($row))echo $row[9]; ?>">                       
                      </div></td>
                  </tr>
				   <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-11"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Mes3" size="20" value="<? if (isset($row))echo $row[10]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-12"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Mes4" size="20" value="<? if (isset($row))echo $row[11]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-13"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Mes5" size="20" value="<? if (isset($row))echo $row[12]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-14"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Mes6" size="20" value="<? if (isset($row))echo $row[13]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-15"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Mes7" size="20" value="<? if (isset($row))echo $row[14]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-16"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Mes8" size="20" value="<? if (isset($row))echo $row[15]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-17"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Mes9" size="20" value="<? if (isset($row))echo $row[16]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-18"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Mes10" size="20" value="<? if (isset($row))echo $row[17]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-19"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Mes11" size="20" value="<? if (isset($row))echo $row[18]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-20"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Mes12" size="20" value="<? if (isset($row))echo $row[19]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-21"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Ev1" size="31" value="<? if (isset($row))echo $row[20]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-22"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Ev2" size="31" value="<? if (isset($row))echo $row[21]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-23"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Ev3" size="31" value="<? if (isset($row))echo $row[22]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-24"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Ev4" size="31" value="<? if (isset($row))echo $row[23]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-25"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Ev5" size="31" value="<? if (isset($row))echo $row[24]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-26"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Ev6" size="31" value="<? if (isset($row))echo $row[25]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-27"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Ev7" size="31" value="<? if (isset($row))echo $row[26]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-28"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Ev8" size="31" value="<? if (isset($row))echo $row[27]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-29"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Ev9" size="31" value="<? if (isset($row))echo $row[28]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-30"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Ev10" size="31" value="<? if (isset($row))echo $row[29]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-31"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Ev11" size="31" value="<? if (isset($row))echo $row[30]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-32"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Ev12" size="31" value="<? if (isset($row))echo $row[31]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-33"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Evm1" size="31" value="<? if (isset($row))echo $row[32]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-34"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Evm2" size="31" value="<? if (isset($row))echo $row[33]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-35"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Evm3" size="31" value="<? if (isset($row))echo $row[34]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-36"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Es1" size="31" value="<? if (isset($row))echo $row[35]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-37"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Ep1" size="31" value="<? if (isset($row))echo $row[36]; ?>">                       
                      </div></td>
                  </tr><tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-38"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Es2" size="31" value="<? if (isset($row))echo $row[37]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-39"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Ep2" size="31" value="<? if (isset($row))echo $row[38]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-40"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Es3" size="31" value="<? if (isset($row))echo $row[39]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-41"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Ep3" size="31" value="<? if (isset($row))echo $row[40]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-42"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Es4" size="31" value="<? if (isset($row))echo $row[41]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-43"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Ep4" size="31" value="<? if (isset($row))echo $row[42]; ?>">                       
                      </div></td>
                  </tr>

				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-44"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Es5" size="31" value="<? if (isset($row))echo $row[43]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-45"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Ep5" size="31" value="<? if (isset($row))echo $row[44]; ?>">                       
                      </div></td>
                  </tr>


				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-46"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Es6" size="31" value="<? if (isset($row))echo $row[45]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-47"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Ep6" size="31" value="<? if (isset($row))echo $row[46]; ?>">                       
                      </div></td>
                  </tr>


				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-48"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Es7" size="31" value="<? if (isset($row))echo $row[47]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-49"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Ep7" size="31" value="<? if (isset($row))echo $row[48]; ?>">                       
                      </div></td>
                  </tr>


				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-50"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Es8" size="31" value="<? if (isset($row))echo $row[49]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-51"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Ep8" size="31" value="<? if (isset($row))echo $row[50]; ?>">                       
                      </div></td>
                  </tr>


				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-52"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Es9" size="31" value="<? if (isset($row))echo $row[51]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-53"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Ep9" size="31" value="<? if (isset($row))echo $row[52]; ?>">                       
                      </div></td>
                  </tr>


				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-54"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Es10" size="31" value="<? if (isset($row))echo $row[53]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-55"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Ep10" size="31" value="<? if (isset($row))echo $row[54]; ?>">                       
                      </div></td>
                  </tr>

				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-56"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="TPed1" size="31" value="<? if (isset($row))echo $row[55]; ?>">                       
                      </div></td>
                  </tr>

				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-57"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="TPed2" size="31" value="<? if (isset($row))echo $row[56]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-58"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="TPed3" size="31" value="<? if (isset($row))echo $row[57]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-59"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="TPed4" size="31" value="<? if (isset($row))echo $row[58]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-60"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="TPed5" size="31" value="<? if (isset($row))echo $row[59]; ?>">                       
                      </div></td>
                  </tr>
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-61"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="PFB1" size="31" value="<? if (isset($row))echo $row[60]; ?>">                       
                      </div></td>
                  </tr>

				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-62"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="PFB2" size="31" value="<? if (isset($row))echo $row[61]; ?>">                       
                      </div></td>
                  </tr>


				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-63"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="PFB3" size="31" value="<? if (isset($row))echo $row[62]; ?>">                       
                      </div></td>
                  </tr>


				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-64"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Ope1" size="31" value="<? if (isset($row))echo $row[63]; ?>">                       
                      </div></td>
                  </tr>


				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-65"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="text" class="style22" name="Ope2" size="31" value="<? if (isset($row))echo $row[64]; ?>">                       
                      </div></td>
                  </tr>

				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-66"];?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
					    <input type="checkbox" class="style22" name="Predeterminado" size="31" value="ON" <? if (isset($row) && ($row[65]==1))  echo "checked"?>>                       
                      </div></td>
                  </tr>

				  <tr>
                    <td colspan="2" class="style22" align="center"><div align="right"></div>                      
                      <div align="center">
                        <input type="submit" class="style22" value="<? if ($operacion==0) {echo $Mensajes["bot-1"];} else { echo $Mensajes["bot-2"];} ?>" name="B1">
						<input type="reset" class="style22" value="<? echo $Mensajes["bot-3"];?>" name="B2">                 
                      </div></td>
                    </tr>
					</table>
			     </form><br>
			
            </div></td>
                
            
        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <table width="100%" bgcolor="#ececec">
            <tr>
              <td valign="top" class="style28"><div align="center"><img src="../images/image001.jpg" width="150" height="118"><br>
                  <span class="style60"><a class="style60" href="../admin/indexadm.php"><? echo $Mensajes["h-1"];?> </a></span></div>                <div align="center" class="style55"></div></td>
            </tr>
          </table>
          </div>
          </td>
        </tr>
    </table>    </center>
      </div>    </td>
  </tr>
  
  <tr>
    <td height="44" bgcolor="#E4E4E4"><div align="center">      
      <hr>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50"><div align="right" class="style33">
            <div align="center">fid-001</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
</body>
</html>


<?
	if (isset($result))
	  mysql_free_result ($result);
   Desconectar();
?>
