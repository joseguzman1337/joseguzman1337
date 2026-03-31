<?php require_once('../Connections/conexion.php'); ?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_ConsPerf = "SELECT * FROM tperfil";
$ConsPerf = mysql_query($query_ConsPerf, $conexion) or die(mysql_error());
$row_ConsPerf = mysql_fetch_assoc($ConsPerf);
$totalRows_ConsPerf = mysql_num_rows($ConsPerf);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<p>&nbsp;</p>
<p>&nbsp;</p>

<table border="1" bgcolor="#FFFFCC">
  <tr>
    <td>IdPerfil</td>
    <td>UnAcad</td>
    <td>FechaDil</td>
    <td>QuiProc</td>
    <td>NomCargo</td>
    <td>Area</td>
    <td>Asignatura</td>
    <td>NoAlum</td>
    <td>Creditos</td>
    <td>Escalafon</td>
    <td>NivCargo</td>
    <td>CargJeIn</td>
    <td>CargCol1</td>
    <td>CargCol2</td>
    <td>CargCol3</td>
    <td>CargCol4</td>
    <td>CargCol5</td>
    <td>CargRep1</td>
    <td>CargRep2</td>
    <td>CargRep3</td>
    <td>CargRep4</td>
    <td>CargRep5</td>
    <td>CarReIn1</td>
    <td>ObReIn1</td>
    <td>IgRiNu1</td>
    <td>IgRiDe1</td>
    <td>IgRiCu11</td>
    <td>IgRiCu12</td>
    <td>IgRiCu13</td>
    <td>IgRiCu14</td>
    <td>CarReIn2</td>
    <td>ObReIn2</td>
    <td>IgRiNu2</td>
    <td>IgRiDe2</td>
    <td>IgRiCu21</td>
    <td>IgRiCu22</td>
    <td>IgRiCu23</td>
    <td>IgRiCu24</td>
    <td>CarReIn3</td>
    <td>ObReIn3</td>
    <td>IgRiNu3</td>
    <td>IgRiDe3</td>
    <td>IgRiCu31</td>
    <td>IgRiCu32</td>
    <td>IgRiCu33</td>
    <td>IgRiCu34</td>
    <td>CarReIn4</td>
    <td>ObReIn4</td>
    <td>IgRiNu4</td>
    <td>IgRiDe4</td>
    <td>IgRiCu41</td>
    <td>IgRiCu42</td>
    <td>IgRiCu43</td>
    <td>IgRiCu44</td>
    <td>CarReIn5</td>
    <td>ObReIn5</td>
    <td>IgRiNu5</td>
    <td>IgRiDe5</td>
    <td>IgRiCu51</td>
    <td>IgRiCu52</td>
    <td>IgRiCu53</td>
    <td>IgRiCu54</td>
    <td>CarReEx1</td>
    <td>ObReEx1</td>
    <td>IgReNu1</td>
    <td>IgReDe1</td>
    <td>IgReCu11</td>
    <td>IgReCu12</td>
    <td>IgReCu13</td>
    <td>IgReCu14</td>
    <td>CarReEx2</td>
    <td>ObReEx2</td>
    <td>IgReNu2</td>
    <td>IgReDe2</td>
    <td>IgReCu21</td>
    <td>IgReCu22</td>
    <td>IgReCu23</td>
    <td>IgReCu24</td>
    <td>CarReEx3</td>
    <td>ObReEx3</td>
    <td>IgReNu3</td>
    <td>IgReDe3</td>
    <td>IgReCu31</td>
    <td>IgReCu32</td>
    <td>IgReCu33</td>
    <td>IgReCu34</td>
    <td>CarReEx4</td>
    <td>ObReEx4</td>
    <td>IgReNu4</td>
    <td>IgReDe4</td>
    <td>IgReCu41</td>
    <td>IgReCu42</td>
    <td>IgReCu43</td>
    <td>IgReCu44</td>
    <td>CarReEx5</td>
    <td>ObReEx5</td>
    <td>IgReNu5</td>
    <td>IgReDe5</td>
    <td>IgReCu51</td>
    <td>IgReCu52</td>
    <td>IgReCu53</td>
    <td>IgReCu54</td>
    <td>Prof1</td>
    <td>ProfNiv1</td>
    <td>Prof2</td>
    <td>ProfNiv2</td>
    <td>Prof3</td>
    <td>ProfNiv3</td>
    <td>Prof4</td>
    <td>ProfNiv4</td>
    <td>Prof5</td>
    <td>ProfNiv5</td>
    <td>Conoc1</td>
    <td>NivCon1</td>
    <td>Conoc2</td>
    <td>NivCon2</td>
    <td>Conoc3</td>
    <td>NivCon3</td>
    <td>Conoc4</td>
    <td>NivCon4</td>
    <td>Conoc5</td>
    <td>NivCon5</td>
    <td>Conoc6</td>
    <td>NivCon6</td>
    <td>Conoc7</td>
    <td>NivCon7</td>
    <td>Conoc8</td>
    <td>NivCon8</td>
    <td>Capac1</td>
    <td>NivCap1</td>
    <td>Capac2</td>
    <td>NivCap2</td>
    <td>Capac3</td>
    <td>NivCap3</td>
    <td>Capac4</td>
    <td>NivCap4</td>
    <td>Capac5</td>
    <td>NivCap5</td>
    <td>Capac6</td>
    <td>NivCap6</td>
    <td>Capac7</td>
    <td>NivCap7</td>
    <td>Capac8</td>
    <td>NivCap8</td>
    <td>ExpLab1</td>
    <td>TiExLa1</td>
    <td>ExpLab2</td>
    <td>TiExLa2</td>
    <td>ExpLab3</td>
    <td>TiExLa3</td>
    <td>ExpLab4</td>
    <td>TiExLa4</td>
    <td>ExpLab5</td>
    <td>TiExLa5</td>
    <td>ExpLab6</td>
    <td>TiExLa6</td>
    <td>ExpLab7</td>
    <td>TiExLa7</td>
    <td>ExpLab8</td>
    <td>TiExLa8</td>
    <td>ObCargo</td>
    <td>ResAcad1</td>
    <td>PeReAc1</td>
    <td>TiReAc1</td>
    <td>IGeRANu1</td>
    <td>IGeRADe1</td>
    <td>IgRAcCu11</td>
    <td>IgRAcCu12</td>
    <td>IgRAcCu13</td>
    <td>IgRAcCu14</td>
    <td>ResAcad2</td>
    <td>PeReAc2</td>
    <td>TiReAc2</td>
    <td>IGeRANu2</td>
    <td>IGeRADe2</td>
    <td>IgRAcCu21</td>
    <td>IgRAcCu22</td>
    <td>IgRAcCu23</td>
    <td>IgRAcCu24</td>
    <td>ResAcad3</td>
    <td>PeReAc3</td>
    <td>TiReAc3</td>
    <td>IGeRANu3</td>
    <td>IGeRADe3</td>
    <td>IgRAcCu31</td>
    <td>IgRAcCu32</td>
    <td>IgRAcCu33</td>
    <td>IgRAcCu34</td>
    <td>ResAcad4</td>
    <td>PeReAc4</td>
    <td>TiReAc4</td>
    <td>IGeRANu4</td>
    <td>IGeRADe4</td>
    <td>IgRAcCu41</td>
    <td>IgRAcCu42</td>
    <td>IgRAcCu43</td>
    <td>IgRAcCu44</td>
    <td>ResAcad5</td>
    <td>PeReAc5</td>
    <td>TiReAc5</td>
    <td>IGeRANu5</td>
    <td>IGeRADe5</td>
    <td>IgRAcCu51</td>
    <td>IgRAcCu52</td>
    <td>IgRAcCu53</td>
    <td>IgRAcCu54</td>
    <td>ResAcad6</td>
    <td>PeReAc6</td>
    <td>TiReAc6</td>
    <td>IGeRANu6</td>
    <td>IGeRADe6</td>
    <td>IgRAcCu61</td>
    <td>IgRAcCu62</td>
    <td>IgRAcCu63</td>
    <td>IgRAcCu64</td>
    <td>ResAcad7</td>
    <td>PeReAc7</td>
    <td>TiReAc7</td>
    <td>IGeRANu7</td>
    <td>IGeRADe7</td>
    <td>IgRAcCu71</td>
    <td>IgRAcCu72</td>
    <td>IgRAcCu73</td>
    <td>IgRAcCu74</td>
    <td>ResAcad8</td>
    <td>PeReAc8</td>
    <td>TiReAc8</td>
    <td>IGeRANu8</td>
    <td>IGeRADe8</td>
    <td>IgRAcCu81</td>
    <td>IgRAcCu82</td>
    <td>IgRAcCu83</td>
    <td>IgRAcCu84</td>
    <td>ResAdm1</td>
    <td>PeReAd1</td>
    <td>TiReAd1</td>
    <td>IgeRAdNu1</td>
    <td>IgeRAdDe1</td>
    <td>IgRAdCu11</td>
    <td>IgRAdCu12</td>
    <td>IgRAdCu13</td>
    <td>IgRAdCu14</td>
    <td>ResAdm2</td>
    <td>PeReAd2</td>
    <td>TiReAd2</td>
    <td>IgeRAdNu2</td>
    <td>IgeRAdDe2</td>
    <td>IgRAdCu21</td>
    <td>IgRAdCu22</td>
    <td>IgRAdCu23</td>
    <td>IgRAdCu24</td>
    <td>ResAdm3</td>
    <td>PeReAd3</td>
    <td>TiReAd3</td>
    <td>IgeRAdNu3</td>
    <td>IgeRAdDe3</td>
    <td>IgRAdCu31</td>
    <td>IgRAdCu32</td>
    <td>IgRAdCu33</td>
    <td>IgRAdCu34</td>
    <td>ResAdm4</td>
    <td>PeReAd4</td>
    <td>TiReAd4</td>
    <td>IgeRAdNu4</td>
    <td>IgeRAdDe4</td>
    <td>IgRAdCu41</td>
    <td>IgRAdCu42</td>
    <td>IgRAdCu43</td>
    <td>IgRAdCu44</td>
    <td>ResAdm5</td>
    <td>PeReAd5</td>
    <td>TiReAd5</td>
    <td>IgeRAdNu5</td>
    <td>IgeRAdDe5</td>
    <td>IgRAdCu51</td>
    <td>IgRAdCu52</td>
    <td>IgRAdCu53</td>
    <td>IgRAdCu54</td>
    <td>ResAdm6</td>
    <td>PeReAd6</td>
    <td>TiReAd6</td>
    <td>IgeRAdNu6</td>
    <td>IgeRAdDe6</td>
    <td>IgRAdCu61</td>
    <td>IgRAdCu62</td>
    <td>IgRAdCu63</td>
    <td>IgRAdCu64</td>
    <td>ResAdm7</td>
    <td>PeReAd7</td>
    <td>TiReAd7</td>
    <td>IgeRAdNu7</td>
    <td>IgeRAdDe7</td>
    <td>IgRAdCu71</td>
    <td>IgRAdCu72</td>
    <td>IgRAdCu73</td>
    <td>IgRAdCu74</td>
    <td>ResAdm8</td>
    <td>PeReAd8</td>
    <td>TiReAd8</td>
    <td>IgeRAdNu8</td>
    <td>IgeRAdDe8</td>
    <td>IgRAdCu81</td>
    <td>IgRAdCu82</td>
    <td>IgRAdCu83</td>
    <td>IgRAdCu84</td>
    <td>CCCoGeEs</td>
    <td>CCCoGeEd</td>
    <td>CCCoGeUn</td>
    <td>CCCoInAp</td>
    <td>CCCoBaIn</td>
    <td>CCCoMeEa</td>
    <td>CCCoCoEm</td>
    <td>CCCoEnPo</td>
    <td>CCCoTics</td>
    <td>CCCoIngl</td>
    <td>CCTiDoct</td>
    <td>CCTiMaes</td>
    <td>CCTiEspe</td>
    <td>CCTiPrCa</td>
    <td>CCFoDoUn</td>
    <td>CCPrApEs</td>
    <td>CIPlCoPe</td>
    <td>CIPlGeIn</td>
    <td>CIHaPeDi</td>
    <td>CIGePrEd</td>
    <td>CIAPEvOp</td>
    <td>CIDiLiIn</td>
    <td>CIDeInves</td>
    <td>CIApPrDo</td>
    <td>CIDiArea</td>
    <td>CIDiSeCo</td>
    <td>CIPrCoSe</td>
    <td>CIAdCeSe</td>
    <td>CIPrSeCo</td>
    <td>CIGePrCo</td>
    <td>CICaAcTi</td>
    <td>CIFuPlMd</td>
    <td>CIFuPlDi</td>
    <td>CIDiMaDi</td>
    <td>CIDiMaNt</td>
    <td>CIDiApMd</td>
    <td>CIFuPrEe</td>
    <td>CIDiEsEe</td>
    <td>CIAdPrEe</td>
    <td>CATEMfSi</td>
    <td>CATECoId</td>
    <td>CATECoCo</td>
    <td>CATEApGr</td>
    <td>CATEApDe</td>
    <td>CATEPrIn</td>
    <td>CATEFoUn</td>
    <td>CATEFoCo</td>
    <td>CATECoOp</td>
    <td>CATEReFt</td>
    <td>CACOEsAt</td>
    <td>CACOBuLe</td>
    <td>CACOTrIn</td>
    <td>CACODiIn</td>
    <td>CACOExPe</td>
    <td>CACOFoCo</td>
    <td>CACOSoIn</td>
    <td>CACOExDe</td>
    <td>CACOCoVi</td>
    <td>CACOExGc</td>
    <td>CACOTiSu</td>
    <td>CACOTiDe</td>
    <td>CACOExAb</td>
    <td>CALIExGr</td>
    <td>CALIEsPL</td>
    <td>CALIObCo</td>
    <td>CALIMeCo</td>
    <td>CALIAcCo</td>
    <td>CALIAcEx</td>
    <td>CALIAsRe</td>
    <td>CALIAtPr</td>
    <td>CALICoPt</td>
    <td>CALICoDe</td>
    <td>CALIFoPa</td>
    <td>CALICoId</td>
    <td>CALIGePa</td>
    <td>CALIEsCo</td>
    <td>CALIApEf</td>
    <td>CALIBuRe</td>
    <td>CALIJuEv</td>
    <td>CALIReCo</td>
    <td>CALITrMv</td>
    <td>CALIReEx</td>
    <td>CALIPeTd</td>
    <td>CALIViIn</td>
    <td>CALITaEs</td>
    <td>CALICoIn</td>
    <td>CALIReCa</td>
    <td>CASELuCl</td>
    <td>CASEAtAm</td>
    <td>CASEAsUs</td>
    <td>CASEPrNe</td>
    <td>CASESoUs</td>
    <td>CASEInSo</td>
    <td>CASEImUn</td>
    <td>CASEAdAc</td>
    <td>CASEApOb</td>
    <td>CASESeAc</td>
    <td>CAADApDi</td>
    <td>CAADReCa</td>
    <td>CAADPaGr</td>
    <td>CAADInCo</td>
    <td>CAADCaOp</td>
    <td>CAADRePo</td>
    <td>CAAPDeCo</td>
    <td>CAAPApCo</td>
    <td>CAAPNuTe</td>
    <td>CAAPAsCu</td>
    <td>CAAPUtHe</td>
    <td>CAAPInCo</td>
    <td>CAAPCoDe</td>
    <td>CAAPAcCo</td>
    <td>CACODiUn</td>
    <td>CACOCoEo</td>
    <td>CACOLoMi</td>
    <td>CACOLoVi</td>
    <td>CACOCoAr</td>
    <td>CACOPrIc</td>
    <td>CACOReIt</td>
    <td>CACOIdPr</td>
    <td>CACOCuPr</td>
    <td>CACOCoOb</td>
    <td>CACOCuRe</td>
    <td>CACNAnAd</td>
    <td>CACNCoPr</td>
    <td>CACNReRa</td>
    <td>CACNBuSo</td>
    <td>CACNCoCo</td>
    <td>CACNEsGg</td>
    <td>CACNEnRa</td>
    <td>CACNAbPr</td>
    <td>CACNEsSd</td>
    <td>CACNSeSo</td>
    <td>CACIPrId</td>
    <td>CACIFoOr</td>
    <td>CACIIdUt</td>
    <td>CACIReDe</td>
    <td>CACIIdNp</td>
    <td>CACIEsRe</td>
    <td>CADOCuHo</td>
    <td>CADOApTi</td>
    <td>CADOCoPr</td>
    <td>CADOImUn</td>
    <td>CADOCoOr</td>
    <td>CADOCuPl</td>
    <td>CADOTrOr</td>
    <td>CADOOrFi</td>
    <td>CADOEvDi</td>
    <td>CADOCuPr</td>
    <td>CAINAsRe</td>
    <td>CAINCoDh</td>
    <td>CAINCoIn</td>
    <td>CAINLeUn</td>
    <td>CAINVaUn</td>
    <td>CAINAcEt</td>
    <td>CAINEvBe</td>
    <td>CAINCoAc</td>
    <td>CAINReCo</td>
    <td>CAMEBaCt</td>
    <td>CAMEMaPr</td>
    <td>CAMEEnEs</td>
    <td>CAMEFoEs</td>
    <td>CAMEHaSa</td>
    <td>CAMECaMt</td>
    <td>CATDImDe</td>
    <td>CATDDeRe</td>
    <td>CATDRiDe</td>
    <td>CATDDeOp</td>
    <td>CATDDeAd</td>
    <td>CATDEvAl</td>
    <td>CATDDoDe</td>
    <td>CATDFiDe</td>
    <td>CARIAgDe</td>
    <td>CARIBuHu</td>
    <td>CARICoMe</td>
    <td>CARICoCl</td>
    <td>CARIBuTo</td>
    <td>CARIDiFa</td>
    <td>CARIPaAc</td>
    <td>CARIAcDi</td>
    <td>CARICoLo</td>
    <td>CARIPoCo</td>
    <td>CAOLInOb</td>
    <td>CAOLTrPe</td>
    <td>CAOLFoPe</td>
    <td>CAOLMcCv</td>
    <td>CAOLEjPl</td>
    <td>CAOLCrCa</td>
    <td>CAOLPpDe</td>
    <td>CAOLSuOb</td>
    <td>CAOLFoMe</td>
    <td>CAOLPrPe</td>
    <td>CADOInAp</td>
    <td>CADOAnOt</td>
    <td>CADOApOt</td>
    <td>CADOAcDe</td>
    <td>CADOApFl</td>
    <td>CADOBrAp</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_ConsPerf['IdPerfil']; ?></td>
      <td><?php echo $row_ConsPerf['UnAcad']; ?></td>
      <td><?php echo $row_ConsPerf['FechaDil']; ?></td>
      <td><?php echo $row_ConsPerf['QuiProc']; ?></td>
      <td><?php echo $row_ConsPerf['NomCargo']; ?></td>
      <td><?php echo $row_ConsPerf['Area']; ?></td>
      <td><?php echo $row_ConsPerf['Asignatura']; ?></td>
      <td><?php echo $row_ConsPerf['NoAlum']; ?></td>
      <td><?php echo $row_ConsPerf['Creditos']; ?></td>
      <td><?php echo $row_ConsPerf['Escalafon']; ?></td>
      <td><?php echo $row_ConsPerf['NivCargo']; ?></td>
      <td><?php echo $row_ConsPerf['CargJeIn']; ?></td>
      <td><?php echo $row_ConsPerf['CargCol1']; ?></td>
      <td><?php echo $row_ConsPerf['CargCol2']; ?></td>
      <td><?php echo $row_ConsPerf['CargCol3']; ?></td>
      <td><?php echo $row_ConsPerf['CargCol4']; ?></td>
      <td><?php echo $row_ConsPerf['CargCol5']; ?></td>
      <td><?php echo $row_ConsPerf['CargRep1']; ?></td>
      <td><?php echo $row_ConsPerf['CargRep2']; ?></td>
      <td><?php echo $row_ConsPerf['CargRep3']; ?></td>
      <td><?php echo $row_ConsPerf['CargRep4']; ?></td>
      <td><?php echo $row_ConsPerf['CargRep5']; ?></td>
      <td><?php echo $row_ConsPerf['CarReIn1']; ?></td>
      <td><?php echo $row_ConsPerf['ObReIn1']; ?></td>
      <td><?php echo $row_ConsPerf['IgRiNu1']; ?></td>
      <td><?php echo $row_ConsPerf['IgRiDe1']; ?></td>
      <td><?php echo $row_ConsPerf['IgRiCu11']; ?></td>
      <td><?php echo $row_ConsPerf['IgRiCu12']; ?></td>
      <td><?php echo $row_ConsPerf['IgRiCu13']; ?></td>
      <td><?php echo $row_ConsPerf['IgRiCu14']; ?></td>
      <td><?php echo $row_ConsPerf['CarReIn2']; ?></td>
      <td><?php echo $row_ConsPerf['ObReIn2']; ?></td>
      <td><?php echo $row_ConsPerf['IgRiNu2']; ?></td>
      <td><?php echo $row_ConsPerf['IgRiDe2']; ?></td>
      <td><?php echo $row_ConsPerf['IgRiCu21']; ?></td>
      <td><?php echo $row_ConsPerf['IgRiCu22']; ?></td>
      <td><?php echo $row_ConsPerf['IgRiCu23']; ?></td>
      <td><?php echo $row_ConsPerf['IgRiCu24']; ?></td>
      <td><?php echo $row_ConsPerf['CarReIn3']; ?></td>
      <td><?php echo $row_ConsPerf['ObReIn3']; ?></td>
      <td><?php echo $row_ConsPerf['IgRiNu3']; ?></td>
      <td><?php echo $row_ConsPerf['IgRiDe3']; ?></td>
      <td><?php echo $row_ConsPerf['IgRiCu31']; ?></td>
      <td><?php echo $row_ConsPerf['IgRiCu32']; ?></td>
      <td><?php echo $row_ConsPerf['IgRiCu33']; ?></td>
      <td><?php echo $row_ConsPerf['IgRiCu34']; ?></td>
      <td><?php echo $row_ConsPerf['CarReIn4']; ?></td>
      <td><?php echo $row_ConsPerf['ObReIn4']; ?></td>
      <td><?php echo $row_ConsPerf['IgRiNu4']; ?></td>
      <td><?php echo $row_ConsPerf['IgRiDe4']; ?></td>
      <td><?php echo $row_ConsPerf['IgRiCu41']; ?></td>
      <td><?php echo $row_ConsPerf['IgRiCu42']; ?></td>
      <td><?php echo $row_ConsPerf['IgRiCu43']; ?></td>
      <td><?php echo $row_ConsPerf['IgRiCu44']; ?></td>
      <td><?php echo $row_ConsPerf['CarReIn5']; ?></td>
      <td><?php echo $row_ConsPerf['ObReIn5']; ?></td>
      <td><?php echo $row_ConsPerf['IgRiNu5']; ?></td>
      <td><?php echo $row_ConsPerf['IgRiDe5']; ?></td>
      <td><?php echo $row_ConsPerf['IgRiCu51']; ?></td>
      <td><?php echo $row_ConsPerf['IgRiCu52']; ?></td>
      <td><?php echo $row_ConsPerf['IgRiCu53']; ?></td>
      <td><?php echo $row_ConsPerf['IgRiCu54']; ?></td>
      <td><?php echo $row_ConsPerf['CarReEx1']; ?></td>
      <td><?php echo $row_ConsPerf['ObReEx1']; ?></td>
      <td><?php echo $row_ConsPerf['IgReNu1']; ?></td>
      <td><?php echo $row_ConsPerf['IgReDe1']; ?></td>
      <td><?php echo $row_ConsPerf['IgReCu11']; ?></td>
      <td><?php echo $row_ConsPerf['IgReCu12']; ?></td>
      <td><?php echo $row_ConsPerf['IgReCu13']; ?></td>
      <td><?php echo $row_ConsPerf['IgReCu14']; ?></td>
      <td><?php echo $row_ConsPerf['CarReEx2']; ?></td>
      <td><?php echo $row_ConsPerf['ObReEx2']; ?></td>
      <td><?php echo $row_ConsPerf['IgReNu2']; ?></td>
      <td><?php echo $row_ConsPerf['IgReDe2']; ?></td>
      <td><?php echo $row_ConsPerf['IgReCu21']; ?></td>
      <td><?php echo $row_ConsPerf['IgReCu22']; ?></td>
      <td><?php echo $row_ConsPerf['IgReCu23']; ?></td>
      <td><?php echo $row_ConsPerf['IgReCu24']; ?></td>
      <td><?php echo $row_ConsPerf['CarReEx3']; ?></td>
      <td><?php echo $row_ConsPerf['ObReEx3']; ?></td>
      <td><?php echo $row_ConsPerf['IgReNu3']; ?></td>
      <td><?php echo $row_ConsPerf['IgReDe3']; ?></td>
      <td><?php echo $row_ConsPerf['IgReCu31']; ?></td>
      <td><?php echo $row_ConsPerf['IgReCu32']; ?></td>
      <td><?php echo $row_ConsPerf['IgReCu33']; ?></td>
      <td><?php echo $row_ConsPerf['IgReCu34']; ?></td>
      <td><?php echo $row_ConsPerf['CarReEx4']; ?></td>
      <td><?php echo $row_ConsPerf['ObReEx4']; ?></td>
      <td><?php echo $row_ConsPerf['IgReNu4']; ?></td>
      <td><?php echo $row_ConsPerf['IgReDe4']; ?></td>
      <td><?php echo $row_ConsPerf['IgReCu41']; ?></td>
      <td><?php echo $row_ConsPerf['IgReCu42']; ?></td>
      <td><?php echo $row_ConsPerf['IgReCu43']; ?></td>
      <td><?php echo $row_ConsPerf['IgReCu44']; ?></td>
      <td><?php echo $row_ConsPerf['CarReEx5']; ?></td>
      <td><?php echo $row_ConsPerf['ObReEx5']; ?></td>
      <td><?php echo $row_ConsPerf['IgReNu5']; ?></td>
      <td><?php echo $row_ConsPerf['IgReDe5']; ?></td>
      <td><?php echo $row_ConsPerf['IgReCu51']; ?></td>
      <td><?php echo $row_ConsPerf['IgReCu52']; ?></td>
      <td><?php echo $row_ConsPerf['IgReCu53']; ?></td>
      <td><?php echo $row_ConsPerf['IgReCu54']; ?></td>
      <td><?php echo $row_ConsPerf['Prof1']; ?></td>
      <td><?php echo $row_ConsPerf['ProfNiv1']; ?></td>
      <td><?php echo $row_ConsPerf['Prof2']; ?></td>
      <td><?php echo $row_ConsPerf['ProfNiv2']; ?></td>
      <td><?php echo $row_ConsPerf['Prof3']; ?></td>
      <td><?php echo $row_ConsPerf['ProfNiv3']; ?></td>
      <td><?php echo $row_ConsPerf['Prof4']; ?></td>
      <td><?php echo $row_ConsPerf['ProfNiv4']; ?></td>
      <td><?php echo $row_ConsPerf['Prof5']; ?></td>
      <td><?php echo $row_ConsPerf['ProfNiv5']; ?></td>
      <td><?php echo $row_ConsPerf['Conoc1']; ?></td>
      <td><?php echo $row_ConsPerf['NivCon1']; ?></td>
      <td><?php echo $row_ConsPerf['Conoc2']; ?></td>
      <td><?php echo $row_ConsPerf['NivCon2']; ?></td>
      <td><?php echo $row_ConsPerf['Conoc3']; ?></td>
      <td><?php echo $row_ConsPerf['NivCon3']; ?></td>
      <td><?php echo $row_ConsPerf['Conoc4']; ?></td>
      <td><?php echo $row_ConsPerf['NivCon4']; ?></td>
      <td><?php echo $row_ConsPerf['Conoc5']; ?></td>
      <td><?php echo $row_ConsPerf['NivCon5']; ?></td>
      <td><?php echo $row_ConsPerf['Conoc6']; ?></td>
      <td><?php echo $row_ConsPerf['NivCon6']; ?></td>
      <td><?php echo $row_ConsPerf['Conoc7']; ?></td>
      <td><?php echo $row_ConsPerf['NivCon7']; ?></td>
      <td><?php echo $row_ConsPerf['Conoc8']; ?></td>
      <td><?php echo $row_ConsPerf['NivCon8']; ?></td>
      <td><?php echo $row_ConsPerf['Capac1']; ?></td>
      <td><?php echo $row_ConsPerf['NivCap1']; ?></td>
      <td><?php echo $row_ConsPerf['Capac2']; ?></td>
      <td><?php echo $row_ConsPerf['NivCap2']; ?></td>
      <td><?php echo $row_ConsPerf['Capac3']; ?></td>
      <td><?php echo $row_ConsPerf['NivCap3']; ?></td>
      <td><?php echo $row_ConsPerf['Capac4']; ?></td>
      <td><?php echo $row_ConsPerf['NivCap4']; ?></td>
      <td><?php echo $row_ConsPerf['Capac5']; ?></td>
      <td><?php echo $row_ConsPerf['NivCap5']; ?></td>
      <td><?php echo $row_ConsPerf['Capac6']; ?></td>
      <td><?php echo $row_ConsPerf['NivCap6']; ?></td>
      <td><?php echo $row_ConsPerf['Capac7']; ?></td>
      <td><?php echo $row_ConsPerf['NivCap7']; ?></td>
      <td><?php echo $row_ConsPerf['Capac8']; ?></td>
      <td><?php echo $row_ConsPerf['NivCap8']; ?></td>
      <td><?php echo $row_ConsPerf['ExpLab1']; ?></td>
      <td><?php echo $row_ConsPerf['TiExLa1']; ?></td>
      <td><?php echo $row_ConsPerf['ExpLab2']; ?></td>
      <td><?php echo $row_ConsPerf['TiExLa2']; ?></td>
      <td><?php echo $row_ConsPerf['ExpLab3']; ?></td>
      <td><?php echo $row_ConsPerf['TiExLa3']; ?></td>
      <td><?php echo $row_ConsPerf['ExpLab4']; ?></td>
      <td><?php echo $row_ConsPerf['TiExLa4']; ?></td>
      <td><?php echo $row_ConsPerf['ExpLab5']; ?></td>
      <td><?php echo $row_ConsPerf['TiExLa5']; ?></td>
      <td><?php echo $row_ConsPerf['ExpLab6']; ?></td>
      <td><?php echo $row_ConsPerf['TiExLa6']; ?></td>
      <td><?php echo $row_ConsPerf['ExpLab7']; ?></td>
      <td><?php echo $row_ConsPerf['TiExLa7']; ?></td>
      <td><?php echo $row_ConsPerf['ExpLab8']; ?></td>
      <td><?php echo $row_ConsPerf['TiExLa8']; ?></td>
      <td><?php echo $row_ConsPerf['ObCargo']; ?></td>
      <td><?php echo $row_ConsPerf['ResAcad1']; ?></td>
      <td><?php echo $row_ConsPerf['PeReAc1']; ?></td>
      <td><?php echo $row_ConsPerf['TiReAc1']; ?></td>
      <td><?php echo $row_ConsPerf['IGeRANu1']; ?></td>
      <td><?php echo $row_ConsPerf['IGeRADe1']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu11']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu12']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu13']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu14']; ?></td>
      <td><?php echo $row_ConsPerf['ResAcad2']; ?></td>
      <td><?php echo $row_ConsPerf['PeReAc2']; ?></td>
      <td><?php echo $row_ConsPerf['TiReAc2']; ?></td>
      <td><?php echo $row_ConsPerf['IGeRANu2']; ?></td>
      <td><?php echo $row_ConsPerf['IGeRADe2']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu21']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu22']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu23']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu24']; ?></td>
      <td><?php echo $row_ConsPerf['ResAcad3']; ?></td>
      <td><?php echo $row_ConsPerf['PeReAc3']; ?></td>
      <td><?php echo $row_ConsPerf['TiReAc3']; ?></td>
      <td><?php echo $row_ConsPerf['IGeRANu3']; ?></td>
      <td><?php echo $row_ConsPerf['IGeRADe3']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu31']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu32']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu33']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu34']; ?></td>
      <td><?php echo $row_ConsPerf['ResAcad4']; ?></td>
      <td><?php echo $row_ConsPerf['PeReAc4']; ?></td>
      <td><?php echo $row_ConsPerf['TiReAc4']; ?></td>
      <td><?php echo $row_ConsPerf['IGeRANu4']; ?></td>
      <td><?php echo $row_ConsPerf['IGeRADe4']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu41']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu42']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu43']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu44']; ?></td>
      <td><?php echo $row_ConsPerf['ResAcad5']; ?></td>
      <td><?php echo $row_ConsPerf['PeReAc5']; ?></td>
      <td><?php echo $row_ConsPerf['TiReAc5']; ?></td>
      <td><?php echo $row_ConsPerf['IGeRANu5']; ?></td>
      <td><?php echo $row_ConsPerf['IGeRADe5']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu51']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu52']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu53']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu54']; ?></td>
      <td><?php echo $row_ConsPerf['ResAcad6']; ?></td>
      <td><?php echo $row_ConsPerf['PeReAc6']; ?></td>
      <td><?php echo $row_ConsPerf['TiReAc6']; ?></td>
      <td><?php echo $row_ConsPerf['IGeRANu6']; ?></td>
      <td><?php echo $row_ConsPerf['IGeRADe6']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu61']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu62']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu63']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu64']; ?></td>
      <td><?php echo $row_ConsPerf['ResAcad7']; ?></td>
      <td><?php echo $row_ConsPerf['PeReAc7']; ?></td>
      <td><?php echo $row_ConsPerf['TiReAc7']; ?></td>
      <td><?php echo $row_ConsPerf['IGeRANu7']; ?></td>
      <td><?php echo $row_ConsPerf['IGeRADe7']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu71']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu72']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu73']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu74']; ?></td>
      <td><?php echo $row_ConsPerf['ResAcad8']; ?></td>
      <td><?php echo $row_ConsPerf['PeReAc8']; ?></td>
      <td><?php echo $row_ConsPerf['TiReAc8']; ?></td>
      <td><?php echo $row_ConsPerf['IGeRANu8']; ?></td>
      <td><?php echo $row_ConsPerf['IGeRADe8']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu81']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu82']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu83']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAcCu84']; ?></td>
      <td><?php echo $row_ConsPerf['ResAdm1']; ?></td>
      <td><?php echo $row_ConsPerf['PeReAd1']; ?></td>
      <td><?php echo $row_ConsPerf['TiReAd1']; ?></td>
      <td><?php echo $row_ConsPerf['IgeRAdNu1']; ?></td>
      <td><?php echo $row_ConsPerf['IgeRAdDe1']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu11']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu12']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu13']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu14']; ?></td>
      <td><?php echo $row_ConsPerf['ResAdm2']; ?></td>
      <td><?php echo $row_ConsPerf['PeReAd2']; ?></td>
      <td><?php echo $row_ConsPerf['TiReAd2']; ?></td>
      <td><?php echo $row_ConsPerf['IgeRAdNu2']; ?></td>
      <td><?php echo $row_ConsPerf['IgeRAdDe2']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu21']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu22']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu23']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu24']; ?></td>
      <td><?php echo $row_ConsPerf['ResAdm3']; ?></td>
      <td><?php echo $row_ConsPerf['PeReAd3']; ?></td>
      <td><?php echo $row_ConsPerf['TiReAd3']; ?></td>
      <td><?php echo $row_ConsPerf['IgeRAdNu3']; ?></td>
      <td><?php echo $row_ConsPerf['IgeRAdDe3']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu31']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu32']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu33']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu34']; ?></td>
      <td><?php echo $row_ConsPerf['ResAdm4']; ?></td>
      <td><?php echo $row_ConsPerf['PeReAd4']; ?></td>
      <td><?php echo $row_ConsPerf['TiReAd4']; ?></td>
      <td><?php echo $row_ConsPerf['IgeRAdNu4']; ?></td>
      <td><?php echo $row_ConsPerf['IgeRAdDe4']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu41']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu42']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu43']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu44']; ?></td>
      <td><?php echo $row_ConsPerf['ResAdm5']; ?></td>
      <td><?php echo $row_ConsPerf['PeReAd5']; ?></td>
      <td><?php echo $row_ConsPerf['TiReAd5']; ?></td>
      <td><?php echo $row_ConsPerf['IgeRAdNu5']; ?></td>
      <td><?php echo $row_ConsPerf['IgeRAdDe5']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu51']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu52']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu53']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu54']; ?></td>
      <td><?php echo $row_ConsPerf['ResAdm6']; ?></td>
      <td><?php echo $row_ConsPerf['PeReAd6']; ?></td>
      <td><?php echo $row_ConsPerf['TiReAd6']; ?></td>
      <td><?php echo $row_ConsPerf['IgeRAdNu6']; ?></td>
      <td><?php echo $row_ConsPerf['IgeRAdDe6']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu61']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu62']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu63']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu64']; ?></td>
      <td><?php echo $row_ConsPerf['ResAdm7']; ?></td>
      <td><?php echo $row_ConsPerf['PeReAd7']; ?></td>
      <td><?php echo $row_ConsPerf['TiReAd7']; ?></td>
      <td><?php echo $row_ConsPerf['IgeRAdNu7']; ?></td>
      <td><?php echo $row_ConsPerf['IgeRAdDe7']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu71']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu72']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu73']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu74']; ?></td>
      <td><?php echo $row_ConsPerf['ResAdm8']; ?></td>
      <td><?php echo $row_ConsPerf['PeReAd8']; ?></td>
      <td><?php echo $row_ConsPerf['TiReAd8']; ?></td>
      <td><?php echo $row_ConsPerf['IgeRAdNu8']; ?></td>
      <td><?php echo $row_ConsPerf['IgeRAdDe8']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu81']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu82']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu83']; ?></td>
      <td><?php echo $row_ConsPerf['IgRAdCu84']; ?></td>
      <td><?php echo $row_ConsPerf['CCCoGeEs']; ?></td>
      <td><?php echo $row_ConsPerf['CCCoGeEd']; ?></td>
      <td><?php echo $row_ConsPerf['CCCoGeUn']; ?></td>
      <td><?php echo $row_ConsPerf['CCCoInAp']; ?></td>
      <td><?php echo $row_ConsPerf['CCCoBaIn']; ?></td>
      <td><?php echo $row_ConsPerf['CCCoMeEa']; ?></td>
      <td><?php echo $row_ConsPerf['CCCoCoEm']; ?></td>
      <td><?php echo $row_ConsPerf['CCCoEnPo']; ?></td>
      <td><?php echo $row_ConsPerf['CCCoTics']; ?></td>
      <td><?php echo $row_ConsPerf['CCCoIngl']; ?></td>
      <td><?php echo $row_ConsPerf['CCTiDoct']; ?></td>
      <td><?php echo $row_ConsPerf['CCTiMaes']; ?></td>
      <td><?php echo $row_ConsPerf['CCTiEspe']; ?></td>
      <td><?php echo $row_ConsPerf['CCTiPrCa']; ?></td>
      <td><?php echo $row_ConsPerf['CCFoDoUn']; ?></td>
      <td><?php echo $row_ConsPerf['CCPrApEs']; ?></td>
      <td><?php echo $row_ConsPerf['CIPlCoPe']; ?></td>
      <td><?php echo $row_ConsPerf['CIPlGeIn']; ?></td>
      <td><?php echo $row_ConsPerf['CIHaPeDi']; ?></td>
      <td><?php echo $row_ConsPerf['CIGePrEd']; ?></td>
      <td><?php echo $row_ConsPerf['CIAPEvOp']; ?></td>
      <td><?php echo $row_ConsPerf['CIDiLiIn']; ?></td>
      <td><?php echo $row_ConsPerf['CIDeInves']; ?></td>
      <td><?php echo $row_ConsPerf['CIApPrDo']; ?></td>
      <td><?php echo $row_ConsPerf['CIDiArea']; ?></td>
      <td><?php echo $row_ConsPerf['CIDiSeCo']; ?></td>
      <td><?php echo $row_ConsPerf['CIPrCoSe']; ?></td>
      <td><?php echo $row_ConsPerf['CIAdCeSe']; ?></td>
      <td><?php echo $row_ConsPerf['CIPrSeCo']; ?></td>
      <td><?php echo $row_ConsPerf['CIGePrCo']; ?></td>
      <td><?php echo $row_ConsPerf['CICaAcTi']; ?></td>
      <td><?php echo $row_ConsPerf['CIFuPlMd']; ?></td>
      <td><?php echo $row_ConsPerf['CIFuPlDi']; ?></td>
      <td><?php echo $row_ConsPerf['CIDiMaDi']; ?></td>
      <td><?php echo $row_ConsPerf['CIDiMaNt']; ?></td>
      <td><?php echo $row_ConsPerf['CIDiApMd']; ?></td>
      <td><?php echo $row_ConsPerf['CIFuPrEe']; ?></td>
      <td><?php echo $row_ConsPerf['CIDiEsEe']; ?></td>
      <td><?php echo $row_ConsPerf['CIAdPrEe']; ?></td>
      <td><?php echo $row_ConsPerf['CATEMfSi']; ?></td>
      <td><?php echo $row_ConsPerf['CATECoId']; ?></td>
      <td><?php echo $row_ConsPerf['CATECoCo']; ?></td>
      <td><?php echo $row_ConsPerf['CATEApGr']; ?></td>
      <td><?php echo $row_ConsPerf['CATEApDe']; ?></td>
      <td><?php echo $row_ConsPerf['CATEPrIn']; ?></td>
      <td><?php echo $row_ConsPerf['CATEFoUn']; ?></td>
      <td><?php echo $row_ConsPerf['CATEFoCo']; ?></td>
      <td><?php echo $row_ConsPerf['CATECoOp']; ?></td>
      <td><?php echo $row_ConsPerf['CATEReFt']; ?></td>
      <td><?php echo $row_ConsPerf['CACOEsAt']; ?></td>
      <td><?php echo $row_ConsPerf['CACOBuLe']; ?></td>
      <td><?php echo $row_ConsPerf['CACOTrIn']; ?></td>
      <td><?php echo $row_ConsPerf['CACODiIn']; ?></td>
      <td><?php echo $row_ConsPerf['CACOExPe']; ?></td>
      <td><?php echo $row_ConsPerf['CACOFoCo']; ?></td>
      <td><?php echo $row_ConsPerf['CACOSoIn']; ?></td>
      <td><?php echo $row_ConsPerf['CACOExDe']; ?></td>
      <td><?php echo $row_ConsPerf['CACOCoVi']; ?></td>
      <td><?php echo $row_ConsPerf['CACOExGc']; ?></td>
      <td><?php echo $row_ConsPerf['CACOTiSu']; ?></td>
      <td><?php echo $row_ConsPerf['CACOTiDe']; ?></td>
      <td><?php echo $row_ConsPerf['CACOExAb']; ?></td>
      <td><?php echo $row_ConsPerf['CALIExGr']; ?></td>
      <td><?php echo $row_ConsPerf['CALIEsPL']; ?></td>
      <td><?php echo $row_ConsPerf['CALIObCo']; ?></td>
      <td><?php echo $row_ConsPerf['CALIMeCo']; ?></td>
      <td><?php echo $row_ConsPerf['CALIAcCo']; ?></td>
      <td><?php echo $row_ConsPerf['CALIAcEx']; ?></td>
      <td><?php echo $row_ConsPerf['CALIAsRe']; ?></td>
      <td><?php echo $row_ConsPerf['CALIAtPr']; ?></td>
      <td><?php echo $row_ConsPerf['CALICoPt']; ?></td>
      <td><?php echo $row_ConsPerf['CALICoDe']; ?></td>
      <td><?php echo $row_ConsPerf['CALIFoPa']; ?></td>
      <td><?php echo $row_ConsPerf['CALICoId']; ?></td>
      <td><?php echo $row_ConsPerf['CALIGePa']; ?></td>
      <td><?php echo $row_ConsPerf['CALIEsCo']; ?></td>
      <td><?php echo $row_ConsPerf['CALIApEf']; ?></td>
      <td><?php echo $row_ConsPerf['CALIBuRe']; ?></td>
      <td><?php echo $row_ConsPerf['CALIJuEv']; ?></td>
      <td><?php echo $row_ConsPerf['CALIReCo']; ?></td>
      <td><?php echo $row_ConsPerf['CALITrMv']; ?></td>
      <td><?php echo $row_ConsPerf['CALIReEx']; ?></td>
      <td><?php echo $row_ConsPerf['CALIPeTd']; ?></td>
      <td><?php echo $row_ConsPerf['CALIViIn']; ?></td>
      <td><?php echo $row_ConsPerf['CALITaEs']; ?></td>
      <td><?php echo $row_ConsPerf['CALICoIn']; ?></td>
      <td><?php echo $row_ConsPerf['CALIReCa']; ?></td>
      <td><?php echo $row_ConsPerf['CASELuCl']; ?></td>
      <td><?php echo $row_ConsPerf['CASEAtAm']; ?></td>
      <td><?php echo $row_ConsPerf['CASEAsUs']; ?></td>
      <td><?php echo $row_ConsPerf['CASEPrNe']; ?></td>
      <td><?php echo $row_ConsPerf['CASESoUs']; ?></td>
      <td><?php echo $row_ConsPerf['CASEInSo']; ?></td>
      <td><?php echo $row_ConsPerf['CASEImUn']; ?></td>
      <td><?php echo $row_ConsPerf['CASEAdAc']; ?></td>
      <td><?php echo $row_ConsPerf['CASEApOb']; ?></td>
      <td><?php echo $row_ConsPerf['CASESeAc']; ?></td>
      <td><?php echo $row_ConsPerf['CAADApDi']; ?></td>
      <td><?php echo $row_ConsPerf['CAADReCa']; ?></td>
      <td><?php echo $row_ConsPerf['CAADPaGr']; ?></td>
      <td><?php echo $row_ConsPerf['CAADInCo']; ?></td>
      <td><?php echo $row_ConsPerf['CAADCaOp']; ?></td>
      <td><?php echo $row_ConsPerf['CAADRePo']; ?></td>
      <td><?php echo $row_ConsPerf['CAAPDeCo']; ?></td>
      <td><?php echo $row_ConsPerf['CAAPApCo']; ?></td>
      <td><?php echo $row_ConsPerf['CAAPNuTe']; ?></td>
      <td><?php echo $row_ConsPerf['CAAPAsCu']; ?></td>
      <td><?php echo $row_ConsPerf['CAAPUtHe']; ?></td>
      <td><?php echo $row_ConsPerf['CAAPInCo']; ?></td>
      <td><?php echo $row_ConsPerf['CAAPCoDe']; ?></td>
      <td><?php echo $row_ConsPerf['CAAPAcCo']; ?></td>
      <td><?php echo $row_ConsPerf['CACODiUn']; ?></td>
      <td><?php echo $row_ConsPerf['CACOCoEo']; ?></td>
      <td><?php echo $row_ConsPerf['CACOLoMi']; ?></td>
      <td><?php echo $row_ConsPerf['CACOLoVi']; ?></td>
      <td><?php echo $row_ConsPerf['CACOCoAr']; ?></td>
      <td><?php echo $row_ConsPerf['CACOPrIc']; ?></td>
      <td><?php echo $row_ConsPerf['CACOReIt']; ?></td>
      <td><?php echo $row_ConsPerf['CACOIdPr']; ?></td>
      <td><?php echo $row_ConsPerf['CACOCuPr']; ?></td>
      <td><?php echo $row_ConsPerf['CACOCoOb']; ?></td>
      <td><?php echo $row_ConsPerf['CACOCuRe']; ?></td>
      <td><?php echo $row_ConsPerf['CACNAnAd']; ?></td>
      <td><?php echo $row_ConsPerf['CACNCoPr']; ?></td>
      <td><?php echo $row_ConsPerf['CACNReRa']; ?></td>
      <td><?php echo $row_ConsPerf['CACNBuSo']; ?></td>
      <td><?php echo $row_ConsPerf['CACNCoCo']; ?></td>
      <td><?php echo $row_ConsPerf['CACNEsGg']; ?></td>
      <td><?php echo $row_ConsPerf['CACNEnRa']; ?></td>
      <td><?php echo $row_ConsPerf['CACNAbPr']; ?></td>
      <td><?php echo $row_ConsPerf['CACNEsSd']; ?></td>
      <td><?php echo $row_ConsPerf['CACNSeSo']; ?></td>
      <td><?php echo $row_ConsPerf['CACIPrId']; ?></td>
      <td><?php echo $row_ConsPerf['CACIFoOr']; ?></td>
      <td><?php echo $row_ConsPerf['CACIIdUt']; ?></td>
      <td><?php echo $row_ConsPerf['CACIReDe']; ?></td>
      <td><?php echo $row_ConsPerf['CACIIdNp']; ?></td>
      <td><?php echo $row_ConsPerf['CACIEsRe']; ?></td>
      <td><?php echo $row_ConsPerf['CADOCuHo']; ?></td>
      <td><?php echo $row_ConsPerf['CADOApTi']; ?></td>
      <td><?php echo $row_ConsPerf['CADOCoPr']; ?></td>
      <td><?php echo $row_ConsPerf['CADOImUn']; ?></td>
      <td><?php echo $row_ConsPerf['CADOCoOr']; ?></td>
      <td><?php echo $row_ConsPerf['CADOCuPl']; ?></td>
      <td><?php echo $row_ConsPerf['CADOTrOr']; ?></td>
      <td><?php echo $row_ConsPerf['CADOOrFi']; ?></td>
      <td><?php echo $row_ConsPerf['CADOEvDi']; ?></td>
      <td><?php echo $row_ConsPerf['CADOCuPr']; ?></td>
      <td><?php echo $row_ConsPerf['CAINAsRe']; ?></td>
      <td><?php echo $row_ConsPerf['CAINCoDh']; ?></td>
      <td><?php echo $row_ConsPerf['CAINCoIn']; ?></td>
      <td><?php echo $row_ConsPerf['CAINLeUn']; ?></td>
      <td><?php echo $row_ConsPerf['CAINVaUn']; ?></td>
      <td><?php echo $row_ConsPerf['CAINAcEt']; ?></td>
      <td><?php echo $row_ConsPerf['CAINEvBe']; ?></td>
      <td><?php echo $row_ConsPerf['CAINCoAc']; ?></td>
      <td><?php echo $row_ConsPerf['CAINReCo']; ?></td>
      <td><?php echo $row_ConsPerf['CAMEBaCt']; ?></td>
      <td><?php echo $row_ConsPerf['CAMEMaPr']; ?></td>
      <td><?php echo $row_ConsPerf['CAMEEnEs']; ?></td>
      <td><?php echo $row_ConsPerf['CAMEFoEs']; ?></td>
      <td><?php echo $row_ConsPerf['CAMEHaSa']; ?></td>
      <td><?php echo $row_ConsPerf['CAMECaMt']; ?></td>
      <td><?php echo $row_ConsPerf['CATDImDe']; ?></td>
      <td><?php echo $row_ConsPerf['CATDDeRe']; ?></td>
      <td><?php echo $row_ConsPerf['CATDRiDe']; ?></td>
      <td><?php echo $row_ConsPerf['CATDDeOp']; ?></td>
      <td><?php echo $row_ConsPerf['CATDDeAd']; ?></td>
      <td><?php echo $row_ConsPerf['CATDEvAl']; ?></td>
      <td><?php echo $row_ConsPerf['CATDDoDe']; ?></td>
      <td><?php echo $row_ConsPerf['CATDFiDe']; ?></td>
      <td><?php echo $row_ConsPerf['CARIAgDe']; ?></td>
      <td><?php echo $row_ConsPerf['CARIBuHu']; ?></td>
      <td><?php echo $row_ConsPerf['CARICoMe']; ?></td>
      <td><?php echo $row_ConsPerf['CARICoCl']; ?></td>
      <td><?php echo $row_ConsPerf['CARIBuTo']; ?></td>
      <td><?php echo $row_ConsPerf['CARIDiFa']; ?></td>
      <td><?php echo $row_ConsPerf['CARIPaAc']; ?></td>
      <td><?php echo $row_ConsPerf['CARIAcDi']; ?></td>
      <td><?php echo $row_ConsPerf['CARICoLo']; ?></td>
      <td><?php echo $row_ConsPerf['CARIPoCo']; ?></td>
      <td><?php echo $row_ConsPerf['CAOLInOb']; ?></td>
      <td><?php echo $row_ConsPerf['CAOLTrPe']; ?></td>
      <td><?php echo $row_ConsPerf['CAOLFoPe']; ?></td>
      <td><?php echo $row_ConsPerf['CAOLMcCv']; ?></td>
      <td><?php echo $row_ConsPerf['CAOLEjPl']; ?></td>
      <td><?php echo $row_ConsPerf['CAOLCrCa']; ?></td>
      <td><?php echo $row_ConsPerf['CAOLPpDe']; ?></td>
      <td><?php echo $row_ConsPerf['CAOLSuOb']; ?></td>
      <td><?php echo $row_ConsPerf['CAOLFoMe']; ?></td>
      <td><?php echo $row_ConsPerf['CAOLPrPe']; ?></td>
      <td><?php echo $row_ConsPerf['CADOInAp']; ?></td>
      <td><?php echo $row_ConsPerf['CADOAnOt']; ?></td>
      <td><?php echo $row_ConsPerf['CADOApOt']; ?></td>
      <td><?php echo $row_ConsPerf['CADOAcDe']; ?></td>
      <td><?php echo $row_ConsPerf['CADOApFl']; ?></td>
      <td><?php echo $row_ConsPerf['CADOBrAp']; ?></td>
    </tr>
    <?php } while ($row_ConsPerf = mysql_fetch_assoc($ConsPerf)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($ConsPerf);
?>
