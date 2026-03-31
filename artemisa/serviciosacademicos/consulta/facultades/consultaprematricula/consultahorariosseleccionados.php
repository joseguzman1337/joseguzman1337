<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
     
require_once('../../../../Connections/sala2.php');
session_start();?>
<style type="text/css">
<!--
.Estilo4 {
	font-family: tahoma;
	font-size: xx-small;
}
.Estilo6 {font-family: tahoma}
.Estilo7 {font-size: x-small}
.Estilo8 {font-size: xx-small}
-->
</style>

<form name="form1" method="post" action="consultahorariosseleccionados.php">  

  <p align="center" class="Estilo1 Estilo2 Estilo4 Estilo7"><strong><font size="2" face="Tahoma">MATERIAS 
    Y HORARIOS SELECCIONADOS </font></strong></p>
  <font size="2" face="Tahoma"><span class="Estilo4"> 
<?php
  
     if ($_POST['volver'])
	 {
	   echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=consultaordenmatricula.php'>";
	   exit ();
	 }
	 $mas=1; 
	   $base7= "SELECT idgrupo FROM prematricula p,detalleprematricula d 
                WHERE p.codigoestudiante ='".$_SESSION['codigoestudiante']."'
                AND p.idprematricula = d.idprematricula 
                AND p.codigoestadoprematricula LIKE '1%'
                AND d.codigoestadodetalleprematricula LIKE '1%' ";  
	   $sol7=mysql_db_query($database_sala,$base7);
	   $totalRows7= mysql_num_rows($sol7);
       $row7=mysql_fetch_array($sol7);
	   
	   do{
	    $ordengrupo[$mas]=$row7['idgrupo'];
	    $mas=$mas+1;
	   }while ($row7=mysql_fetch_array($sol7));	   
?>
<?php
////////////////////***************************** HORARIOS SELECCIONADOS 
for ($qq =1;$qq < $mas ;$qq ++)
{//FOR
      $consulta= "select g.codigomateria,m.nombremateria,m.semestre,m.numerocreditos
	              from grupo g,materia m
	              where g.idgrupo = '".$ordengrupo[$qq]."'			   
			      and g.codigomateria=m.codigomateria
				  and g.codigomaterianovasoft=m.codigomaterianovasoft "; 
	  $solucion=mysql_db_query($database_sala,$consulta);
	  $totalRows5= mysql_num_rows($solucion);
      $resultado=mysql_fetch_array($solucion);   

do {?>
</span></font>
  <table width="632" border="1" align="center" cellpadding="2" cellspacing="1"bordercolor="#003333">
    <tr bgcolor="#C5D5D6"> 
      <td width="226" class="Estilo1 Estilo4 Estilo8"> <div align="center"><font face="Tahoma"><strong> 
          Materia</strong></font></div>
      <div align="center"></div></td>
      <td width="145" class="Estilo1 Estilo4"> <div align="center" class="Estilo8"><font face="Tahoma"><strong>C&oacute;digo</strong></font></div></td>
      <td width="131" class="Estilo1 Estilo4"> <div align="center" class="Estilo8"><font face="Tahoma"><strong>Semestre 
      </strong></font></div></td>
      <td width="100" class="Estilo1 Estilo4"> <div align="center" class="Estilo8"><font face="Tahoma"><strong>Cr&eacute;ditos </strong></font></div></td>
    </tr>
    <tr> 
      <td class="Estilo1 Estilo4"><div align="center"><font size="2" face="Tahoma"><span class="Estilo6"><?php echo $resultado['nombremateria'];?></span></font></div>
        <div align="center"></div></td>
      <td class="Estilo1 Estilo4"><div align="center"><font size="2" face="Tahoma"><span class="Estilo6"><?php echo $resultado['codigomateria'];?></span></font></div></td>
      <td class="Estilo1 Estilo4"><div align="center"><font size="2" face="Tahoma"><span class="Estilo6"><?php echo $resultado['semestre'];?></span></font></div></td>
      <td class="Estilo1 Estilo4"><div align="center"><font size="2" face="Tahoma"><span class="Estilo6"><?php echo $resultado['numerocreditos'];?></span></font></div></td>
    </tr>
  </table>
  <table width="632" border="1" align="center" cellpadding="2" cellspacing="1"bordercolor="#003333">
    <tr bgcolor="#C5D5D6"> 
      <td width="115" class="Estilo1 Estilo3 Estilo4 Estilo8"> <div align="center"></div>
      <div align="center"><font face="Tahoma"><strong>Sede</strong></font></div></td>
      <td width="107" class="Estilo4"> <div align="center"></div>
      <div align="center"><font face="Tahoma"><strong>Sal&oacute;n</strong></font></div></td>
      <td width="145" class="Estilo1 Estilo4"> <div align="center" class="Estilo8"><font face="Tahoma"><strong>D&iacute;a 
      </strong></font></div></td>
      <td width="129" class="Estilo1 Estilo4"> <div align="center" class="Estilo8"><font face="Tahoma"><strong>H. Inicial 
      </strong></font></div></td>
      <td width="102" class="Estilo1 Estilo4"> <div align="center" class="Estilo8"><font face="Tahoma"><strong>H. Final</strong></font></div></td>
    </tr>
  </table>
  <font size="2" face="Tahoma"><span class="Estilo1 Estilo4"> 
  <?php
      $consulta1= "SELECT h.codigodia,h.horainicial,h.horafinal,h.codigosalon,d.nombredia
                   FROM horario h,dia d
                   WHERE h.idgrupo = '".$ordengrupo[$qq]."'
				   and h.codigodia=d.codigodia"; 
	  $solucion1=mysql_db_query($database_sala,$consulta1);	  
      $resultado1=mysql_fetch_array($solucion1);

do{
      $consulta2= "SELECT *
                   FROM salon s
                   WHERE s.codigosalon= '".$resultado1['codigosalon']."'"; 
	  $solucion2=mysql_db_query($database_sala,$consulta2);	  
      $resultado2=mysql_fetch_array($solucion2);   


?>
  </span> </font> 
  <table width="632" border="1" align="center" cellpadding="2" cellspacing="1"  bordercolor="#E97914">
    <tr> 
      <td width="115" class="Estilo1 Estilo4"><div align="center"><font size="2" face="Tahoma"><span class="Estilo6"><?php echo $resultado2['codigosalon'];?></span></font></div></td>
      <td width="109" class="Estilo1 Estilo4"><div align="center"><font size="2" face="Tahoma"><span class="Estilo6"><?php echo $resultado1['codigosalon'];?></span></font></div></td>
      <td width="145" class="Estilo1 Estilo4"><div align="center"><font size="2" face="Tahoma"><span class="Estilo6"><?php echo $resultado1['nombredia'];?></span></font></div></td>
      <td width="129" class="Estilo1 Estilo4"><div align="center"><font size="2" face="Tahoma"><span class="Estilo6"><?php echo $resultado1['horainicial'];?></span></font></div></td>
      <td width="100" class="Estilo1 Estilo4"><div align="center"><font size="2" face="Tahoma"><span class="Estilo6"><?php echo $resultado1['horafinal'];?></span></font></div></td>
    </tr>
  </table>
  <font size="2" face="Tahoma"><span class="Estilo1 Estilo4"> 
<?php
}while ($resultado1=mysql_fetch_array($solucion1));
}while ($resultado=mysql_fetch_array($solucion));
}//FIN FOR 
?>
  </span></font><font face="Tahoma"><span class="Estilo1 Estilo4"></span></font> 
  <p align="center">
  <span class="Estilo1">
  <input name="imprimir" type="submit" id="imprimir" value="Imprimir" onClick="window.print()">
&nbsp;
<input name="volver" type="submit" id="volver" value="Regresar">
</span> </p>
</FORM>
