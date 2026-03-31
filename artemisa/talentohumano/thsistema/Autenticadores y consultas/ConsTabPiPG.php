<?php require_once('../Connections/conexion.php'); ?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_ConsPiPG = "SELECT * FROM tpipg ORDER BY NoEval ASC";
$ConsPiPG = mysql_query($query_ConsPiPG, $conexion) or die(mysql_error());
$row_ConsPiPG = mysql_fetch_assoc($ConsPiPG);
$totalRows_ConsPiPG = mysql_num_rows($ConsPiPG);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo22 {color: #FFFFFF; font-weight: bold; }
.Estilo24 {color: #FFFFFF}
.Estilo4 {font-family: Tahoma;
	color: #596221;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table border="1">
  <tr>
    <td>IdPrueba</td>
    <td>CCEvaluado</td>
    <td>NoEval</td>
    <td>ApEv</td>
    <td>FeEva</td>
    <td>CarEva</td>
    <td>DivCar</td>
    <td>P1</td>
    <td>N1</td>
    <td>P2</td>
    <td>N2</td>
    <td>P3</td>
    <td>N3</td>
    <td>P4</td>
    <td>N4</td>
    <td>P5</td>
    <td>N5</td>
    <td>P6</td>
    <td>N6</td>
    <td>P7</td>
    <td>N7</td>
    <td>P8</td>
    <td>N8</td>
    <td>P9</td>
    <td>N9</td>
    <td>P10</td>
    <td>N10</td>
    <td>P11</td>
    <td>N11</td>
    <td>P12</td>
    <td>N12</td>
    <td>P13</td>
    <td>N13</td>
    <td>P14</td>
    <td>N14</td>
    <td>P15</td>
    <td>N15</td>
    <td>P16</td>
    <td>N16</td>
    <td>P17</td>
    <td>N17</td>
    <td>P18</td>
    <td>N18</td>
    <td>P19</td>
    <td>N19</td>
    <td>P20</td>
    <td>N20</td>
    <td>P21</td>
    <td>N21</td>
    <td>P22</td>
    <td>N22</td>
    <td>P23</td>
    <td>N23</td>
    <td>P24</td>
    <td>N24</td>
    <td>P25</td>
    <td>N25</td>
    <td>P26</td>
    <td>N26</td>
    <td>P27</td>
    <td>N27</td>
    <td>P28</td>
    <td>N28</td>
    <td>P29</td>
    <td>N29</td>
    <td>P30</td>
    <td>N30</td>
    <td>P31</td>
    <td>N31</td>
    <td>P32</td>
    <td>N32</td>
    <td>P33</td>
    <td>N33</td>
    <td>P34</td>
    <td>N34</td>
    <td>P35</td>
    <td>N35</td>
    <td>P36</td>
    <td>N36</td>
    <td>P37</td>
    <td>N37</td>
    <td>P38</td>
    <td>N38</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_ConsPiPG['IdPrueba']; ?></td>
      <td><?php echo $row_ConsPiPG['CCEvaluado']; ?></td>
      <td><?php echo $row_ConsPiPG['NoEval']; ?></td>
      <td><?php echo $row_ConsPiPG['ApEv']; ?></td>
      <td><?php echo $row_ConsPiPG['FeEva']; ?></td>
      <td><?php echo $row_ConsPiPG['CarEva']; ?></td>
      <td><?php echo $row_ConsPiPG['DivCar']; ?></td>
      <td><?php echo $row_ConsPiPG['P1']; ?></td>
      <td><?php echo $row_ConsPiPG['N1']; ?></td>
      <td><?php echo $row_ConsPiPG['P2']; ?></td>
      <td><?php echo $row_ConsPiPG['N2']; ?></td>
      <td><?php echo $row_ConsPiPG['P3']; ?></td>
      <td><?php echo $row_ConsPiPG['N3']; ?></td>
      <td><?php echo $row_ConsPiPG['P4']; ?></td>
      <td><?php echo $row_ConsPiPG['N4']; ?></td>
      <td><?php echo $row_ConsPiPG['P5']; ?></td>
      <td><?php echo $row_ConsPiPG['N5']; ?></td>
      <td><?php echo $row_ConsPiPG['P6']; ?></td>
      <td><?php echo $row_ConsPiPG['N6']; ?></td>
      <td><?php echo $row_ConsPiPG['P7']; ?></td>
      <td><?php echo $row_ConsPiPG['N7']; ?></td>
      <td><?php echo $row_ConsPiPG['P8']; ?></td>
      <td><?php echo $row_ConsPiPG['N8']; ?></td>
      <td><?php echo $row_ConsPiPG['P9']; ?></td>
      <td><?php echo $row_ConsPiPG['N9']; ?></td>
      <td><?php echo $row_ConsPiPG['P10']; ?></td>
      <td><?php echo $row_ConsPiPG['N10']; ?></td>
      <td><?php echo $row_ConsPiPG['P11']; ?></td>
      <td><?php echo $row_ConsPiPG['N11']; ?></td>
      <td><?php echo $row_ConsPiPG['P12']; ?></td>
      <td><?php echo $row_ConsPiPG['N12']; ?></td>
      <td><?php echo $row_ConsPiPG['P13']; ?></td>
      <td><?php echo $row_ConsPiPG['N13']; ?></td>
      <td><?php echo $row_ConsPiPG['P14']; ?></td>
      <td><?php echo $row_ConsPiPG['N14']; ?></td>
      <td><?php echo $row_ConsPiPG['P15']; ?></td>
      <td><?php echo $row_ConsPiPG['N15']; ?></td>
      <td><?php echo $row_ConsPiPG['P16']; ?></td>
      <td><?php echo $row_ConsPiPG['N16']; ?></td>
      <td><?php echo $row_ConsPiPG['P17']; ?></td>
      <td><?php echo $row_ConsPiPG['N17']; ?></td>
      <td><?php echo $row_ConsPiPG['P18']; ?></td>
      <td><?php echo $row_ConsPiPG['N18']; ?></td>
      <td><?php echo $row_ConsPiPG['P19']; ?></td>
      <td><?php echo $row_ConsPiPG['N19']; ?></td>
      <td><?php echo $row_ConsPiPG['P20']; ?></td>
      <td><?php echo $row_ConsPiPG['N20']; ?></td>
      <td><?php echo $row_ConsPiPG['P21']; ?></td>
      <td><?php echo $row_ConsPiPG['N21']; ?></td>
      <td><?php echo $row_ConsPiPG['P22']; ?></td>
      <td><?php echo $row_ConsPiPG['N22']; ?></td>
      <td><?php echo $row_ConsPiPG['P23']; ?></td>
      <td><?php echo $row_ConsPiPG['N23']; ?></td>
      <td><?php echo $row_ConsPiPG['P24']; ?></td>
      <td><?php echo $row_ConsPiPG['N24']; ?></td>
      <td><?php echo $row_ConsPiPG['P25']; ?></td>
      <td><?php echo $row_ConsPiPG['N25']; ?></td>
      <td><?php echo $row_ConsPiPG['P26']; ?></td>
      <td><?php echo $row_ConsPiPG['N26']; ?></td>
      <td><?php echo $row_ConsPiPG['P27']; ?></td>
      <td><?php echo $row_ConsPiPG['N27']; ?></td>
      <td><?php echo $row_ConsPiPG['P28']; ?></td>
      <td><?php echo $row_ConsPiPG['N28']; ?></td>
      <td><?php echo $row_ConsPiPG['P29']; ?></td>
      <td><?php echo $row_ConsPiPG['N29']; ?></td>
      <td><?php echo $row_ConsPiPG['P30']; ?></td>
      <td><?php echo $row_ConsPiPG['N30']; ?></td>
      <td><?php echo $row_ConsPiPG['P31']; ?></td>
      <td><?php echo $row_ConsPiPG['N31']; ?></td>
      <td><?php echo $row_ConsPiPG['P32']; ?></td>
      <td><?php echo $row_ConsPiPG['N32']; ?></td>
      <td><?php echo $row_ConsPiPG['P33']; ?></td>
      <td><?php echo $row_ConsPiPG['N33']; ?></td>
      <td><?php echo $row_ConsPiPG['P34']; ?></td>
      <td><?php echo $row_ConsPiPG['N34']; ?></td>
      <td><?php echo $row_ConsPiPG['P35']; ?></td>
      <td><?php echo $row_ConsPiPG['N35']; ?></td>
      <td><?php echo $row_ConsPiPG['P36']; ?></td>
      <td><?php echo $row_ConsPiPG['N36']; ?></td>
      <td><?php echo $row_ConsPiPG['P37']; ?></td>
      <td><?php echo $row_ConsPiPG['N37']; ?></td>
      <td><?php echo $row_ConsPiPG['P38']; ?></td>
      <td><?php echo $row_ConsPiPG['N38']; ?></td>
    </tr>
    <?php } while ($row_ConsPiPG = mysql_fetch_assoc($ConsPiPG)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($ConsPiPG);
?>
