<?
$pageName = "estadisticas";
//terminar de acomodar cxon estilos esta pagina q es horribleeeeeeeeeeee
require "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

$DiadeHoy = getdate();
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
.style28 {color: #FFFFFF; font-size: 11px; }
.style43 {
	font-family: verdana;
	font-size: 10px;
}
.style46 {
	color: #006599;
	font-family: verdana;
	font-size: 10px;
	font-style: normal;
	font-weight: bold;
}
.style49 {font-family: verdana; font-size: 10px; color: #006599; }
.style54 {font-family: verdana; font-size: 10px; color: #000000; }
.style55 {
	font-size: 10px;
	color: #000000;
	font-family: Verdana;
}
.style57 {
	font-family: verdana;
	font-size: 10px;
	font-weight: bold;
	color: #000000;
}
.style63 {
	font-size: 9px;
	font-family: Arial, Helvetica, sans-serif;
}

	    #menu1 {
		    position=relative;
		    visibility='visible';
	    }
	    #menu2 {
		    position=relative;
		    visibility='visible';
	    }
	    #menu3 {
		    position=relative;
		    visibility='visible';
	    }
	    #menu4 {
		    position=relative;
		    visibility='visible';
	    }
-->
</style>
<script>
      var menues = new Array(1,1,1,1);
       
      function initialize()
      {
       resize(1,'menu1');
       resize(2,'menu2');
       resize(3,'menu3');
       resize(4,'menu4');
       }
	      function resize(num,menu)
	      {//var boton = document.getElementById('sizer');
	       var mimenu = document.getElementById(menu);
	       if (menues[num-1]==1) //hay que minimizar
	         {menues[num-1]=0;
     		  mimenu.style.visibility = 'hidden';
		      mimenu.style.position = 'absolute';
		      }
           else //hay que maximizar
	         { menues[num-1]=1;
     		   mimenu.style.visibility = 'visible';
		       mimenu.style.position = 'relative';
		     }
     }
</script>

<table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td bgcolor="#E4E4E4">
            <div align="center">
              <center>

<table width="576" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
	<tr>
    	<td valign="top" bgcolor="#E4E4E4">

<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="style43">
	<tr>
    	<td height="20" colspan="2" align="left" bgcolor="#006599" class="style45">
    		<img src="../images/square-lb.gif" width="8" height="8"> 
    		<span class="style28"><? echo $Mensajes['tit-1'];?></span>
    	</td>
	</tr>
    <!-- inicio menu 1 -->
    <tr valign="top">
    	<td align="left" class="style45">
        	<p align="left" class="style54">
        		<img src="../images/stats.gif" width="30" height="30" hspace="0" vspace="0" align="left">
        		<br>
			</p>
		</td>
		<td align="left" class="style45">
			<p class="style54"><span class="style57">
				<a href="javascript:resize(1,'menu1')"><? echo $Mensajes['txt-1']; ?></a>
				</span><br>
                <? echo $Mensajes['txt-2'];?>
			</p>
		</td>
	</tr>
	<!-- fin menu 1 -->
	<tr valign="top" class='menu1' id='menu1'>
		<td align="center" valign="middle" class="style45">&nbsp;</td>
		<td align="left" bgcolor="#ECECEC" class="style45">
			<blockquote>
				<br>
				<p><span class="style46"><? echo $Mensajes['txt-3'];?></span></p>
				<p>
					<span class="style49">
						<span class="style46"><img src="../images/sa6.gif" width="8" height="10"></span>
						<a href="est-numpedidosmesanio.php?Anio=<? echo $DiadeHoy["year"];?>&TPed=1&TipoGrafico=1&Caja=0&AnioFinal=<? echo $DiadeHoy["year"];?>&Modalidad=1">
							<? echo $Mensajes['txt-4']; ?>
						</a>
					</span>
					<br>
					<span class="style54"><? echo $Mensajes['txt-5']; ?></span>
                    <br><br>
                    
                    <span class="style49">
                    	<span class="style46"><img src="../images/sa6.gif" width="8" height="10"></span>
                        <a href="est-destinopaisped.php?Anio=<? echo $DiadeHoy['year'];?>&TPed=1&AnioFinal=<? echo $DiadeHoy['year'];?>">
                        	<? echo $Mensajes['txt-6']; ?>
                        </a>
					</span>
					<br>
					<span class="style54"><? echo $Mensajes['txt-7']; ?></span>
					<br><br>
					
					<span class="style49">
						<span class="style46"><img src="../images/sa6.gif" width="8" height="10"></span>
						<a href="est-destinopaisinstped.php?Anio=<? echo $DiadeHoy["year"];?>&TPed=1&AnioFinal=<? echo $DiadeHoy["year"];?>">
							<? echo $Mensajes['txt-8']; ?>
						</a>
					</span>
					<br>
					<span class="style54"><? echo $Mensajes['txt-9']; ?></span>
					<br><br>
					
					<span class="style49">
						<span class="style46"><img src="../images/sa6.gif" width="8" height="10"></span>
						<a href="est-destinodepeped.php?Anio=<? echo $DiadeHoy["year"];?>&TPed=1&AnioFinal=<? echo $DiadeHoy["year"];?>">
							<? echo $Mensajes['txt-10']; ?>
						</a>
					</span>
					<br/>
					<span class="style54"><? echo $Mensajes['txt-11']; ?></span>
					<br/><br/>
					
					<span class="style49">
						<span class="style46"><img src="../images/sa6.gif" width="8" height="10"></span>
						<a href="est-paginasmes.php?Anio=<? echo $DiadeHoy["year"];?>&TPed=1&AnioFinal=<? echo $DiadeHoy["year"];?>&Modalidad=1">
							<? echo $Mensajes['txt-12']; ?>
						</a>
					</span>
					<br>
					<span class="style54"><? echo $Mensajes['txt-13']; ?></span>
				</p>
                <p><span class="style46"><strong><? echo $Mensajes['txt-14']; ?></strong></span></p>
				<p>
					<span class="style58">
						<span class="style49">
							<span class="style46"><img src="../images/sa6.gif" width="8" height="10"></span>
							<a href="est-numpedidosmesanio.php?Anio=<? echo $DiadeHoy["year"];?>&TPed=2&TipoGrafico=1&Caja=0&AnioFinal=<? echo $DiadeHoy["year"];?>&Modalidad=1">
								<? echo $Mensajes['txt-15']; ?>
							</a>
						</span>.
					</span>
					<br>
					<span class="style58">
						<span class="style55"><? echo $Mensajes['txt-16']; ?> </span>
						<br>
					</span>
					<br>
					<span class="style49">
                    	<span class="style46"><img src="../images/sa6.gif" width="8" height="10"></span>
                    	<a href="est-paginasmes.php?Anio=<? echo $DiadeHoy["year"];?>&TPed=2&AnioFinal=<? echo $DiadeHoy["year"];?>&Modalidad=1">
                    		<? echo $Mensajes['txt-17']; ?>
                    	</a>
                    </span>
                    <br>
                    <span class="style58"><span class="style54"><? echo $Mensajes['txt-18']; ?></span></span>
				</p>
			</blockquote>                      
            <div align="right">
            	<a href="javascript:resize(1,'menu1')"><img src="../images/menos.gif" width="9" border="0" height="9"></a>
            </div>
		</td>
	</tr>
	<tr valign="top">
		<td align="left" class="style45">
			<span class="style54">
				<img src="../images/stats.gif" width="30" height="30" hspace="0" vspace="0" align="left">
				<br>
			</span>
		</td>
		<td align="left" class="style45">
			<span class="style54">
				<span class="style46">
					<span class="style57">
						<a href="javascript:resize(2,'menu2')"><? echo $Mensajes['txt-19']; ?></a>
					</span>
					<br>
                </span>
                <? echo $Mensajes['txt-20']; ?>
			</span>
		</td>
	</tr>
	<!-- fin menu 1 -->
	<!-- inicio menu 2 -->
    <tr valign="top"  class='menu2' id='menu2'>
    	<td align="center" valign="middle" class="style45">
    		<br><br>
    	</td>
    	<td align="left" bgcolor="#ECECEC" class="style45">
			<blockquote>
				<p>
				<span class="style60"><br></span>
				<span class="style46"><? echo $Mensajes['txt-21']; ?></span>
				<span class="style60"><br><br></span>
				<span class="style55">
					<span class="style46"><img src="../images/sa6.gif" width="8" height="10"></span>
				</span>
				<span class="style49"><a href="est-tardanzaglobal.php?Anio=<? echo $DiadeHoy["year"];?>&AnioFinal=<? echo $DiadeHoy["year"];?>&TPed=1"><? echo $Mensajes['txt-22']; ?></a></span>
				<span class="style55">
					<br>
					<? echo $Mensajes['txt-23']; ?>
					<br><br>
				</span>
				<span class="style49">
					<span class="style46"><img src="../images/sa6.gif" width="8" height="10"></span>
					<a href="est-tardanzapaisinst.php?Anio=<? echo $DiadeHoy["year"];?>&AnioFinal=<? echo $DiadeHoy["year"];?>&TPed=1"> <? echo $Mensajes['txt-24']; ?></a>
				</span>
				<span class="style55">
					<br>
					<? echo $Mensajes['txt-25']; ?>
					<br><br>
				</span>
				<span class="style49">
					<span class="style46"><img src="../images/sa6.gif" width="8" height="10"></span>
					<a href="est-tardanzapaisdepe.php?Anio=<? echo $DiadeHoy["year"];?>&AnioFinal=<? echo $DiadeHoy["year"];?>&TPed=1"> <? echo $Mensajes['txt-26']; ?> </a>
				</span>
				<span class="style55">
					<br>
					<? echo $Mensajes['txt-27']; ?> 
					<br><br>
				</span>
				<span class="style49">
					<span class="style46"><img src="../images/sa6.gif" width="8" height="10"></span>
					<a href="est-tardanzabiblio.php?Anio=<? echo $DiadeHoy["year"];?>&AnioFinal=<? echo $DiadeHoy["year"];?>&TPed=1"> <? echo $Mensajes['txt-28']; ?></a>
				</span>
				<span class="style55">
					.<br>
					<? echo $Mensajes['txt-29']; ?> 
					<br><br>
					<span class="style46"><img src="../images/sa6.gif" width="8" height="10"></span> 
				</span>
				<span class="style49">
					<a href="est-tardanzapromediopais.php?Anio=<? echo $DiadeHoy["year"];?>&TPed=1&AnioFinal=<? echo $DiadeHoy["year"];?>"><? echo $Mensajes['txt-30']; ?></a>
				</span>
				<span class="style55">
					.<br>
					<? echo $Mensajes['txt-31']; ?>
				</span>
			</p>
		</blockquote>
                        <div align="right"><a href="javascript:resize(2,'menu2')"><img src="../images/menos.gif" border="0" width="9" height="9"></a></div></td>
                  </tr>
                  <tr valign="top">
                    <td align="left" class="style45"><span class="style54"><img src="../images/stats.gif" width="30" height="30" hspace="0" vspace="0" align="left"><br>
                    </span></td>
                    <td align="left" class="style45"><span class="style54"><span class="style57"><a href="javascript:resize(3,'menu3')"><? echo $Mensajes['txt-32']; ?></a></span><br>
                      <? echo $Mensajes['txt-33']; ?></span></td>
                  </tr>
                  <tr valign="top"  class='menu3' id='menu3'>
                    <td align="center" valign="middle" class="style45">
                      <p class="style54"><br>
                      </p>
                      <p>&nbsp; </p></td>
                    <td align="left" bgcolor="#ECECEC" class="style45"><blockquote><span class="style55">
                      <p><br>
                        <span class="style46"> <? echo $Mensajes['txt-34']; ?></span><br>
                        <br>
                        <span class="style49"> <span class="style55"><span class="style46"><img src="../images/sa6.gif" width="8" height="10"></span> </span><a href="est-usunuevos.php?Anio=<? echo $DiadeHoy["year"];?>&AnioFinal=<? echo $DiadeHoy["year"]; ?>&Modalidad=1"><? echo $Mensajes['txt-35']; ?></a></span><br>
<? echo $Mensajes['txt-36']; ?> <br>
<br>
<span class="style49">
	<span class="style46"><img src="../images/sa6.gif" width="8" height="10"></span>
	<a href="est-origenpaisped.php?Anio=<? echo $DiadeHoy["year"];?>&TPed=1&AnioFinal=<? echo $DiadeHoy["year"];?>"> <? echo $Mensajes['txt-37']; ?></a>
</span>
<br>
<? echo $Mensajes['txt-38']; ?> <br>
<br>
<span class="style49"><span class="style46"><img src="../images/sa6.gif" width="8" height="10"></span><a href="est-origeninstped.php?Anio=<? echo $DiadeHoy["year"];?>&TPed=1&AnioFinal=<? echo $DiadeHoy["year"];?>"> <? echo $Mensajes['txt-39']; ?> </a></span><br>
<? echo $Mensajes['txt-39']; ?> <br>
<br>
<span class="style49"><span class="style55"><span class="style46"><img src="../images/sa6.gif" width="8" height="10"></span> </span>    <a href="est-origendepeped.php?Anio=<? echo $DiadeHoy["year"];?>&TPed=1&AnioFinal=<? echo $DiadeHoy["year"];?>"> <? echo $Mensajes['txt-41']; ?> </a></span><br>
<? echo $Mensajes['txt-42']; ?> <br>
<br>
<span class="style49"><span class="style55"><span class="style46"><img src="../images/sa6.gif" width="8" height="10"></span> </span><a href="est-origenunidped.php?Anio=<? echo $DiadeHoy["year"];?>&TPed=1&AnioFinal=<? echo $DiadeHoy["year"];?>"><? echo $Mensajes['txt-43']; ?></a></span><br>
<? echo $Mensajes['txt-44']; ?> <br>
<br>
<span class="style49"><span class="style55"><span class="style46"><img src="../images/sa6.gif" width="8" height="10"></span> </span><a href="est-estadusact.php?Anio=<? echo $DiadeHoy["year"];?>&TPed=1&AnioFinal=<? echo $DiadeHoy["year"];?>"><? echo $Mensajes['txt-45']; ?></a></span><br>
<? echo $Mensajes['txt-46']; ?><br>
<br>
<span class="style49"><span class="style55"><span class="style46"><img src="../images/sa6.gif" width="8" height="10"></span> </span><a href="est-funcionusped.php?Anio=<? echo $DiadeHoy["year"];?>&TPed=1&AnioFinal=<? echo $DiadeHoy["year"];?>"><? echo $Mensajes['txt-47']; ?></a></span><br>
<? echo $Mensajes['txt-48']; ?> <br>
<br>
<span class="style46"> <? echo $Mensajes['txt-49']; ?></span><br>
<br>
<span class="style49"><span class="style46"><img src="../images/sa6.gif" width="8" height="10"></span><a href="est-funcionusped.php?Anio=<? echo $DiadeHoy["year"];?>&TPed=2&AnioFinal=<? echo $DiadeHoy["year"];?>"> <? echo $Mensajes['txt-50']; ?></a></span><br>
<? echo $Mensajes['txt-51']; ?></p>
                     </span> </blockquote>                        
                      <p align="right"><a href="javascript:resize(3,'menu3')"><img src="../images/menos.gif" border="0" width="9" height="9"></a>
                        </p></td>
                  </tr>
                  <tr valign="top">
                    <td align="left" class="style45"><span class="style54"><img src="../images/stats.gif" width="30" height="30" hspace="0" vspace="0" align="left">                    </span></td>
                    <td align="left" class="style45"><span class="style54"><span class="style57"><a href="javascript:resize(4,'menu4')"><? echo $Mensajes['txt-52']; ?></a></span> <br>
                      <? echo $Mensajes['txt-53']; ?>
                    </span></td>
                  </tr>
                  <tr valign="top"  class='menu4' id='menu4'>
                    <td align="center" valign="middle" class="style45">
                      <p class="style54"><br>
                      </p>
                      <p>&nbsp; </p></td>
                    <td align="left" bgcolor="#ECECEC" class="style45"><blockquote><span class="style55">
                      <p><span class="style46"><br>
                            <? echo $Mensajes['txt-54']; ?><br>
                        </span><br>
                          <span class="style49"><img src="../images/sa6.gif" width="8" height="10"><a href="est-decadadocum.php?Anio=<? echo $DiadeHoy["year"];?>&AnioFinal=<? echo $DiadeHoy["year"];?>&TPed=1"> <? echo $Mensajes['txt-55']; ?></a></span><br>
                          <? echo $Mensajes['txt-56']; ?> <br>
                          <br>
                          <span class="style49"><img src="../images/sa6.gif" width="8" height="10"><a href="est-estadtitrev.php?Anio=<? echo $DiadeHoy["year"];?>&AnioFinal=<? echo $DiadeHoy["year"];?>&TPed=1&Pagina=0"> <? echo $Mensajes['txt-57']; ?></a></span><br>
                          <? echo $Mensajes['txt-58']; ?> <br>
                          <br>
                          <span class="style49"><img src="../images/sa6.gif" width="8" height="10"><a href="est-estadcolact.php?Anio=<? echo $DiadeHoy["year"]; ?>&AnioFinal=<? echo $DiadeHoy["year"]; ?>&TPed=1"> <? echo $Mensajes['txt-59']; ?></a></span><br>
                          <? echo $Mensajes['txt-60']; ?> <br>
                          <br>
                          <span class="style49"><img src="../images/sa6.gif" width="8" height="10"> <a href="est-tipomaterial.php?Anio=<? echo $DiadeHoy["year"];?>&TPed=1&Caja=1&TipoGrafico=1&AnioFinal=<? echo $DiadeHoy["year"];?>"><? echo $Mensajes['txt-61']; ?></a></span><br>
                          <? echo $Mensajes['txt-62']; ?> <br>
                          <br>
  
                        <span class="style46"><? echo $Mensajes['txt-49']; ?></span><br>
                          <br>
                          <span class="style49"><img src="../images/sa6.gif" width="8" height="10"> <a href="est-decadadocum.php?Anio=<? echo $DiadeHoy["year"];?>&AnioFinal=<? echo $DiadeHoy["year"];?>&TPed=2"><? echo $Mensajes['txt-55']; ?></a></span><br>
                          <? echo $Mensajes['txt-63'];?><br>
                          <br>
                          <span class="style49"><img src="../images/sa6.gif" width="8" height="10"><a href="est-estadtitrev.php?Anio=<? echo $DiadeHoy["year"];?>&AnioFinal=<? echo $DiadeHoy["year"];?>&TPed=2&Pagina=0"> <? echo $Mensajes['txt-64']; ?></a></span><br>
                          <? echo $Mensajes['txt-65']; ?><br>
                          <br>
                          <span class="style49"><img src="../images/sa6.gif" width="8" height="10"><a href="est-estadcolact.php?Anio=<? echo $DiadeHoy["year"]; ?>&AnioFinal=<? echo $DiadeHoy["year"]; ?>&TPed=2"> <? echo $Mensajes['txt-66']; ?></a></span><br>
                          <? echo $Mensajes['txt-67']; ?> <br>
                          <br>
                          <span class="style49"><img src="../images/sa6.gif" width="8" height="10"> <a href="est-tipomaterial.php?Anio=<? echo $DiadeHoy["year"];?>&TPed=2&Caja=1&TipoGrafico=1&AnioFinal=<? echo $DiadeHoy["year"];?>"><? echo $Mensajes['txt-68']; ?></a></span><br>
                          <? echo $Mensajes['txt-69']; ?></p>
                      </span>	</blockquote>                        
                      <p align="right"><a href="javascript:resize(4,'menu4')"><img src="../images/menos.gif" border="0" width="9" height="9"></a></p></td></tr>
                </table>                  </td>
              </tr>
            </table>
              </center>
            </div>
            </td>
        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <table width="100%" bgcolor="#ececec">
            <tr>
              <td class="style28"><div align="center"></div>                <div align="center" class="style55"><img src="../images/image001.jpg" width="150" height="118"></div></td>
            </tr>
          </table>
          </div>
          </td>
        </tr>
    </table>   
<script language="JavaScript" type="text/javascript">
  initialize();
</script>
  
<?

require "../layouts/base_layout_admin.php";
?>