<?php require_once('../Connections/conexion.php'); ?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO tperfil (UnAcad, FechaDil, QuiProc, NomCargo, Area, Asignatura, NoAlum, Creditos, Escalafon, NivCargo, CargJeIn, CargCol1, CargCol2, CargCol3, CargCol4, CargCol5, CargRep1, CargRep2, CargRep3, CargRep4, CargRep5, CarReIn1, ObReIn1, IgRiNu1, IgRiDe1, IgRiCu11, IgRiCu12, IgRiCu13, IgRiCu14, CarReIn2, ObReIn2, IgRiNu2, IgRiDe2, IgRiCu21, IgRiCu22, IgRiCu23, IgRiCu24, CarReIn3, ObReIn3, IgRiNu3, IgRiDe3, IgRiCu31, IgRiCu32, IgRiCu33, IgRiCu34, CarReIn4, ObReIn4, IgRiNu4, IgRiDe4, IgRiCu41, IgRiCu42, IgRiCu43, IgRiCu44, CarReIn5, ObReIn5, IgRiNu5, IgRiDe5, IgRiCu51, IgRiCu52, IgRiCu53, IgRiCu54, CarReEx1, ObReEx1, IgReNu1, IgReDe1, IgReCu11, IgReCu12, IgReCu13, IgReCu14, CarReEx2, ObReEx2, IgReNu2, IgReDe2, IgReCu21, IgReCu22, IgReCu23, IgReCu24, CarReEx3, ObReEx3, IgReNu3, IgReDe3, IgReCu31, IgReCu32, IgReCu33, IgReCu34, CarReEx4, ObReEx4, IgReNu4, IgReDe4, IgReCu41, IgReCu42, IgReCu43, IgReCu44, CarReEx5, ObReEx5, IgReNu5, IgReDe5, IgReCu51, IgReCu52, IgReCu53, IgReCu54, Prof1, ProfNiv1, Prof2, ProfNiv2, Prof3, ProfNiv3, Prof4, ProfNiv4, Prof5, ProfNiv5, Conoc1, NivCon1, Conoc2, NivCon2, Conoc3, NivCon3, Conoc4, NivCon4, Conoc5, NivCon5, Conoc6, NivCon6, Conoc7, NivCon7, Conoc8, NivCon8, Capac1, NivCap1, Capac2, NivCap2, Capac3, NivCap3, Capac4, NivCap4, Capac5, NivCap5, Capac6, NivCap6, Capac7, NivCap7, Capac8, NivCap8, ExpLab1, TiExLa1, ExpLab2, TiExLa2, ExpLab3, TiExLa3, ExpLab4, TiExLa4, ExpLab5, TiExLa5, ExpLab6, TiExLa6, ExpLab7, TiExLa7, ExpLab8, TiExLa8, ObCargo, ResAcad1, PeReAc1, TiReAc1, IGeRANu1, IGeRADe1, IgRAcCu11, IgRAcCu12, IgRAcCu13, IgRAcCu14, ResAcad2, PeReAc2, TiReAc2, IGeRANu2, IGeRADe2, IgRAcCu21, IgRAcCu22, IgRAcCu23, IgRAcCu24, ResAcad3, PeReAc3, TiReAc3, IGeRANu3, IGeRADe3, IgRAcCu31, IgRAcCu32, IgRAcCu33, IgRAcCu34, ResAcad4, PeReAc4, TiReAc4, IGeRANu4, IGeRADe4, IgRAcCu41, IgRAcCu42, IgRAcCu43, IgRAcCu44, ResAcad5, PeReAc5, TiReAc5, IGeRANu5, IGeRADe5, IgRAcCu51, IgRAcCu52, IgRAcCu53, IgRAcCu54, ResAcad6, PeReAc6, TiReAc6, IGeRANu6, IGeRADe6, IgRAcCu61, IgRAcCu62, IgRAcCu63, IgRAcCu64, ResAcad7, PeReAc7, TiReAc7, IGeRANu7, IGeRADe7, IgRAcCu71, IgRAcCu72, IgRAcCu73, IgRAcCu74, ResAcad8, PeReAc8, TiReAc8, IGeRANu8, IGeRADe8, IgRAcCu81, IgRAcCu82, IgRAcCu83, IgRAcCu84, ResAdm1, PeReAd1, TiReAd1, IgeRAdNu1, IgeRAdDe1, IgRAdCu11, IgRAdCu12, IgRAdCu13, IgRAdCu14, ResAdm2, PeReAd2, TiReAd2, IgeRAdNu2, IgeRAdDe2, IgRAdCu21, IgRAdCu22, IgRAdCu23, IgRAdCu24, ResAdm3, PeReAd3, TiReAd3, IgeRAdNu3, IgeRAdDe3, IgRAdCu31, IgRAdCu32, IgRAdCu33, IgRAdCu34, ResAdm4, PeReAd4, TiReAd4, IgeRAdNu4, IgeRAdDe4, IgRAdCu41, IgRAdCu42, IgRAdCu43, IgRAdCu44, ResAdm5, PeReAd5, TiReAd5, IgeRAdNu5, IgeRAdDe5, IgRAdCu51, IgRAdCu52, IgRAdCu53, IgRAdCu54, ResAdm6, PeReAd6, TiReAd6, IgeRAdNu6, IgeRAdDe6, IgRAdCu61, IgRAdCu62, IgRAdCu63, IgRAdCu64, ResAdm7, PeReAd7, TiReAd7, IgeRAdNu7, IgeRAdDe7, IgRAdCu71, IgRAdCu72, IgRAdCu73, IgRAdCu74, ResAdm8, PeReAd8, TiReAd8, IgeRAdNu8, IgeRAdDe8, IgRAdCu81, IgRAdCu82, IgRAdCu83, IgRAdCu84, CCCoGeEs, CCCoGeEd, CCCoGeUn, CCCoInAp, CCCoBaIn, CCCoMeEa, CCCoCoEm, CCCoEnPo, CCCoTics, CCCoIngl, CCTiDoct, CCTiMaes, CCTiEspe, CCTiPrCa, CCFoDoUn, CCPrApEs, CCGerPro, CCGePoPr, CCGesDoc, CCMaCoOr, CCEmpren, CCInnTra, CCResSoc, CIPlCoPe, CIPlGeIn, CIHaPeDi, CIGePrEd, CIAPEvOp, CIDiLiIn, CIDeInves, CIApPrDo, CIDiArea, CIDiSeCo, CIPrCoSe, CIAdCeSe, CIPrSeCo, CIGePrCo, CICaAcTi, CIFuPlMd, CIFuPlDi, CIDiMaDi, CIDiMaNt, CIDiApMd, CIFuPrEe, CIDiEsEe, CIAdPrEe, CIDePlETO, CIIdOpPr, CIDeImSc, CIeLeVaP, CIInInLe, CIFoSiIn, CIDiPrEm, CICoPrEm, CIFoPrRs, CIDeOpNe, CIAdInTe, CATEMfSi, CATECoId, CATECoCo, CATEApGr, CATEApDe, CATEPrIn, CATEFoUn, CATEFoCo, CATECoOp, CATEReFt, CACOEsAt, CACOBuLe, CACOTrIn, CACODiIn, CACOExPe, CACOFoCo, CACOSoIn, CACOExDe, CACOCoVi, CACOExGc, CACOTiSu, CACOTiDe, CACOExAb, CALIExGr, CALIEsPL, CALIObCo, CALIMeCo, CALIAcCo, CALIAcEx, CALIAsRe, CALIAtPr, CALICoPt, CALICoDe, CALIFoPa, CALICoId, CALIGePa, CALIEsCo, CALIApEf, CALIBuRe, CALIJuEv, CALIReCo, CALITrMv, CALIMoEe, CALIReEx, CALIPeTd, CALIViIn, CALITaEs, CALICoIn, CALIReCa, CASELuCl, CASEAtAm, CASEAsUs, CASEPrNe, CASESoUs, CASEInSo, CASEImUn, CASEAdAc, CASEApOb, CASESeAc, CAADApDi, CAADReCa, CAADPaGr, CAADInCo, CAADCaOp, CAADRePo, CAAPDeCo, CAAPApCo, CAAPNuTe, CAAPAsCu, CAAPUtHe, CAAPInCo, CAAPCoDe, CAAPAcCo, CACODiUn, CACOCoEo, CACOLoMi, CACOLoVi, CACOCoAr, CACOPrIc, CACOReIt, CACOIdPr, CACOCuPr, CACOCoOb, CACOCuRe, CACNAnAd, CACNCoPr, CACNReRa, CACNBuSo, CACNCoCo, CACNEsGg, CACNEnRa, CACNAbPr, CACNEsSd, CACNSeSo, CACIPrId, CACIFoOr, CACIIdUt, CACIReDe, CACIIdNp, CACIEsRe, CADOCuHo, CADOApTi, CADOCoPr, CADOImUn, CADOCoOr, CADOCuPl, CADOTrOr, CADOOrFi, CADOEvDi, CADOCuPr, CAINAsRe, CAINCoDh, CAINCoIn, CAINLeUn, CAINVaUn, CAINAcEt, CAINEvBe, CAINCoAc, CAINReCo, CAMEBaCt, CAMEMaPr, CAMEEnEs, CAMEFoEs, CAMEHaSa, CAMECaMt, CATDImDe, CATDDeRe, CATDRiDe, CATDDeOp, CATDDeAd, CATDEvAl, CATDDoDe, CATDFiDe, CARIAgDe, CARIBuHu, CARICoMe, CARICoCl, CARIBuTo, CARIDiFa, CARIPaAc, CARIAcDi, CARICoLo, CARIPoCo, CAOLInOb, CAOLTrPe, CAOLFoPe, CAOLMcCv, CAOLEjPl, CAOLCrCa, CAOLPpDe, CAOLSuOb, CAOLFoMe, CAOLPrPe, CADOInAp, CADOAnOt, CADOApOt, CADOAcDe, CADOApFl, CADOBrAp) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['UnAcad'], "text"),
                       GetSQLValueString($_POST['FechaDil'], "date"),
                       GetSQLValueString($_POST['QuiProc'], "text"),
                       GetSQLValueString($_POST['NomCargo'], "text"),
                       GetSQLValueString($_POST['Area'], "text"),
                       GetSQLValueString($_POST['Asignatura'], "text"),
                       GetSQLValueString($_POST['NoAlum'], "text"),
                       GetSQLValueString($_POST['Creditos'], "int"),
                       GetSQLValueString($_POST['Escalafon'], "text"),
                       GetSQLValueString($_POST['NivCargo'], "text"),
                       GetSQLValueString($_POST['CargJeIn'], "text"),
                       GetSQLValueString($_POST['CargCol1'], "text"),
                       GetSQLValueString($_POST['CargCol2'], "text"),
                       GetSQLValueString($_POST['CargCol3'], "text"),
                       GetSQLValueString($_POST['CargCol4'], "text"),
                       GetSQLValueString($_POST['CargCol5'], "text"),
                       GetSQLValueString($_POST['CargRep1'], "text"),
                       GetSQLValueString($_POST['CargRep2'], "text"),
                       GetSQLValueString($_POST['CargRep3'], "text"),
                       GetSQLValueString($_POST['CargRep4'], "text"),
                       GetSQLValueString($_POST['CargRep5'], "text"),
                       GetSQLValueString($_POST['CarReIn1'], "text"),
                       GetSQLValueString($_POST['ObReIn1'], "text"),
                       GetSQLValueString($_POST['IgRiNu1'], "text"),
                       GetSQLValueString($_POST['IgRiDe1'], "text"),
                       GetSQLValueString($_POST['IgRiCu11'], "text"),
                       GetSQLValueString($_POST['IgRiCu12'], "text"),
                       GetSQLValueString($_POST['IgRiCu13'], "text"),
                       GetSQLValueString($_POST['IgRiCu14'], "text"),
                       GetSQLValueString($_POST['CarReIn2'], "text"),
                       GetSQLValueString($_POST['ObReIn2'], "text"),
                       GetSQLValueString($_POST['IgRiNu2'], "text"),
                       GetSQLValueString($_POST['IgRiDe2'], "text"),
                       GetSQLValueString($_POST['IgRiCu21'], "text"),
                       GetSQLValueString($_POST['IgRiCu22'], "text"),
                       GetSQLValueString($_POST['IgRiCu23'], "text"),
                       GetSQLValueString($_POST['IgRiCu24'], "text"),
                       GetSQLValueString($_POST['CarReIn3'], "text"),
                       GetSQLValueString($_POST['ObReIn3'], "text"),
                       GetSQLValueString($_POST['IgRiNu3'], "text"),
                       GetSQLValueString($_POST['IgRiDe3'], "text"),
                       GetSQLValueString($_POST['IgRiCu31'], "text"),
                       GetSQLValueString($_POST['IgRiCu32'], "text"),
                       GetSQLValueString($_POST['IgRiCu33'], "text"),
                       GetSQLValueString($_POST['IgRiCu34'], "text"),
                       GetSQLValueString($_POST['CarReIn4'], "text"),
                       GetSQLValueString($_POST['ObReIn4'], "text"),
                       GetSQLValueString($_POST['IgRiNu4'], "text"),
                       GetSQLValueString($_POST['IgRiDe4'], "text"),
                       GetSQLValueString($_POST['IgRiCu41'], "text"),
                       GetSQLValueString($_POST['IgRiCu42'], "text"),
                       GetSQLValueString($_POST['IgRiCu43'], "text"),
                       GetSQLValueString($_POST['IgRiCu44'], "text"),
                       GetSQLValueString($_POST['CarReIn5'], "text"),
                       GetSQLValueString($_POST['ObReIn5'], "text"),
                       GetSQLValueString($_POST['IgRiNu5'], "text"),
                       GetSQLValueString($_POST['IgRiDe5'], "text"),
                       GetSQLValueString($_POST['IgRiCu51'], "text"),
                       GetSQLValueString($_POST['IgRiCu52'], "text"),
                       GetSQLValueString($_POST['IgRiCu53'], "text"),
                       GetSQLValueString($_POST['IgRiCu54'], "text"),
                       GetSQLValueString($_POST['CarReEx1'], "text"),
                       GetSQLValueString($_POST['ObReEx1'], "text"),
                       GetSQLValueString($_POST['IgReNu1'], "text"),
                       GetSQLValueString($_POST['IgReDe1'], "text"),
                       GetSQLValueString($_POST['IgReCu11'], "text"),
                       GetSQLValueString($_POST['IgReCu12'], "text"),
                       GetSQLValueString($_POST['IgReCu13'], "text"),
                       GetSQLValueString($_POST['IgReCu14'], "text"),
                       GetSQLValueString($_POST['CarReEx2'], "text"),
                       GetSQLValueString($_POST['ObReEx2'], "text"),
                       GetSQLValueString($_POST['IgReNu2'], "text"),
                       GetSQLValueString($_POST['IgReDe2'], "text"),
                       GetSQLValueString($_POST['IgReCu21'], "text"),
                       GetSQLValueString($_POST['IgReCu22'], "text"),
                       GetSQLValueString($_POST['IgReCu23'], "text"),
                       GetSQLValueString($_POST['IgReCu24'], "text"),
                       GetSQLValueString($_POST['CarReEx3'], "text"),
                       GetSQLValueString($_POST['ObReEx3'], "text"),
                       GetSQLValueString($_POST['IgReNu3'], "text"),
                       GetSQLValueString($_POST['IgReDe3'], "text"),
                       GetSQLValueString($_POST['IgReCu31'], "text"),
                       GetSQLValueString($_POST['IgReCu32'], "text"),
                       GetSQLValueString($_POST['IgReCu33'], "text"),
                       GetSQLValueString($_POST['IgReCu34'], "text"),
                       GetSQLValueString($_POST['CarReEx4'], "text"),
                       GetSQLValueString($_POST['ObReEx4'], "text"),
                       GetSQLValueString($_POST['IgReNu4'], "text"),
                       GetSQLValueString($_POST['IgReDe4'], "text"),
                       GetSQLValueString($_POST['IgReCu41'], "text"),
                       GetSQLValueString($_POST['IgReCu42'], "text"),
                       GetSQLValueString($_POST['IgReCu43'], "text"),
                       GetSQLValueString($_POST['IgReCu44'], "text"),
                       GetSQLValueString($_POST['CarReEx5'], "text"),
                       GetSQLValueString($_POST['ObReEx5'], "text"),
                       GetSQLValueString($_POST['IgReNu5'], "text"),
                       GetSQLValueString($_POST['IgReDe5'], "text"),
                       GetSQLValueString($_POST['IgReCu51'], "text"),
                       GetSQLValueString($_POST['IgReCu52'], "text"),
                       GetSQLValueString($_POST['IgReCu53'], "text"),
                       GetSQLValueString($_POST['IgReCu54'], "text"),
                       GetSQLValueString($_POST['Prof1'], "text"),
                       GetSQLValueString($_POST['ProfNiv1'], "text"),
                       GetSQLValueString($_POST['Prof2'], "text"),
                       GetSQLValueString($_POST['ProfNiv2'], "text"),
                       GetSQLValueString($_POST['Prof3'], "text"),
                       GetSQLValueString($_POST['ProfNiv3'], "text"),
                       GetSQLValueString($_POST['Prof4'], "text"),
                       GetSQLValueString($_POST['ProfNiv4'], "text"),
                       GetSQLValueString($_POST['Prof5'], "text"),
                       GetSQLValueString($_POST['ProfNiv5'], "text"),
                       GetSQLValueString($_POST['Conoc1'], "text"),
                       GetSQLValueString($_POST['NivCon1'], "text"),
                       GetSQLValueString($_POST['Conoc2'], "text"),
                       GetSQLValueString($_POST['NivCon2'], "text"),
                       GetSQLValueString($_POST['Conoc3'], "text"),
                       GetSQLValueString($_POST['NivCon3'], "text"),
                       GetSQLValueString($_POST['Conoc4'], "text"),
                       GetSQLValueString($_POST['NivCon4'], "text"),
                       GetSQLValueString($_POST['Conoc5'], "text"),
                       GetSQLValueString($_POST['NivCon5'], "text"),
                       GetSQLValueString($_POST['Conoc6'], "text"),
                       GetSQLValueString($_POST['NivCon6'], "text"),
                       GetSQLValueString($_POST['Conoc7'], "text"),
                       GetSQLValueString($_POST['NivCon7'], "text"),
                       GetSQLValueString($_POST['Conoc8'], "text"),
                       GetSQLValueString($_POST['NivCon8'], "text"),
                       GetSQLValueString($_POST['Capac1'], "text"),
                       GetSQLValueString($_POST['NivCap1'], "text"),
                       GetSQLValueString($_POST['Capac2'], "text"),
                       GetSQLValueString($_POST['NivCap2'], "text"),
                       GetSQLValueString($_POST['Capac3'], "text"),
                       GetSQLValueString($_POST['NivCap3'], "text"),
                       GetSQLValueString($_POST['Capac4'], "text"),
                       GetSQLValueString($_POST['NivCap4'], "text"),
                       GetSQLValueString($_POST['Capac5'], "text"),
                       GetSQLValueString($_POST['NivCap5'], "text"),
                       GetSQLValueString($_POST['Capac6'], "text"),
                       GetSQLValueString($_POST['NivCap6'], "text"),
                       GetSQLValueString($_POST['Capac7'], "text"),
                       GetSQLValueString($_POST['NivCap7'], "text"),
                       GetSQLValueString($_POST['Capac8'], "text"),
                       GetSQLValueString($_POST['NivCap8'], "text"),
                       GetSQLValueString($_POST['ExpLab1'], "text"),
                       GetSQLValueString($_POST['TiExLa1'], "text"),
                       GetSQLValueString($_POST['ExpLab2'], "text"),
                       GetSQLValueString($_POST['TiExLa2'], "text"),
                       GetSQLValueString($_POST['ExpLab3'], "text"),
                       GetSQLValueString($_POST['TiExLa3'], "text"),
                       GetSQLValueString($_POST['ExpLab4'], "text"),
                       GetSQLValueString($_POST['TiExLa4'], "text"),
                       GetSQLValueString($_POST['ExpLab5'], "text"),
                       GetSQLValueString($_POST['TiExLa5'], "text"),
                       GetSQLValueString($_POST['ExpLab6'], "text"),
                       GetSQLValueString($_POST['TiExLa6'], "text"),
                       GetSQLValueString($_POST['ExpLab7'], "text"),
                       GetSQLValueString($_POST['TiExLa7'], "text"),
                       GetSQLValueString($_POST['ExpLab8'], "text"),
                       GetSQLValueString($_POST['TiExLa8'], "text"),
                       GetSQLValueString($_POST['ObCargo'], "text"),
                       GetSQLValueString($_POST['ResAcad1'], "text"),
                       GetSQLValueString($_POST['PeReAc1'], "text"),
                       GetSQLValueString($_POST['TiReAc1'], "text"),
                       GetSQLValueString($_POST['IGeRANu1'], "text"),
                       GetSQLValueString($_POST['IGeRADe1'], "text"),
                       GetSQLValueString($_POST['IgRAcCu11'], "text"),
                       GetSQLValueString($_POST['IgRAcCu12'], "text"),
                       GetSQLValueString($_POST['IgRAcCu13'], "text"),
                       GetSQLValueString($_POST['IgRAcCu14'], "text"),
                       GetSQLValueString($_POST['ResAcad2'], "text"),
                       GetSQLValueString($_POST['PeReAc2'], "text"),
                       GetSQLValueString($_POST['TiReAc2'], "text"),
                       GetSQLValueString($_POST['IGeRANu2'], "text"),
                       GetSQLValueString($_POST['IGeRADe2'], "text"),
                       GetSQLValueString($_POST['IgRAcCu21'], "text"),
                       GetSQLValueString($_POST['IgRAcCu22'], "text"),
                       GetSQLValueString($_POST['IgRAcCu23'], "text"),
                       GetSQLValueString($_POST['IgRAcCu24'], "text"),
                       GetSQLValueString($_POST['ResAcad3'], "text"),
                       GetSQLValueString($_POST['PeReAc3'], "text"),
                       GetSQLValueString($_POST['TiReAc3'], "text"),
                       GetSQLValueString($_POST['IGeRANu3'], "text"),
                       GetSQLValueString($_POST['IGeRADe3'], "text"),
                       GetSQLValueString($_POST['IgRAcCu31'], "text"),
                       GetSQLValueString($_POST['IgRAcCu32'], "text"),
                       GetSQLValueString($_POST['IgRAcCu33'], "text"),
                       GetSQLValueString($_POST['IgRAcCu34'], "text"),
                       GetSQLValueString($_POST['ResAcad4'], "text"),
                       GetSQLValueString($_POST['PeReAc4'], "text"),
                       GetSQLValueString($_POST['TiReAc4'], "text"),
                       GetSQLValueString($_POST['IGeRANu4'], "text"),
                       GetSQLValueString($_POST['IGeRADe4'], "text"),
                       GetSQLValueString($_POST['IgRAcCu41'], "text"),
                       GetSQLValueString($_POST['IgRAcCu42'], "text"),
                       GetSQLValueString($_POST['IgRAcCu43'], "text"),
                       GetSQLValueString($_POST['IgRAcCu44'], "text"),
                       GetSQLValueString($_POST['ResAcad5'], "text"),
                       GetSQLValueString($_POST['PeReAc5'], "text"),
                       GetSQLValueString($_POST['TiReAc5'], "text"),
                       GetSQLValueString($_POST['IGeRANu5'], "text"),
                       GetSQLValueString($_POST['IGeRADe5'], "text"),
                       GetSQLValueString($_POST['IgRAcCu51'], "text"),
                       GetSQLValueString($_POST['IgRAcCu52'], "text"),
                       GetSQLValueString($_POST['IgRAcCu53'], "text"),
                       GetSQLValueString($_POST['IgRAcCu54'], "text"),
                       GetSQLValueString($_POST['ResAcad6'], "text"),
                       GetSQLValueString($_POST['PeReAc6'], "text"),
                       GetSQLValueString($_POST['TiReAc6'], "text"),
                       GetSQLValueString($_POST['IGeRANu6'], "text"),
                       GetSQLValueString($_POST['IGeRADe6'], "text"),
                       GetSQLValueString($_POST['IgRAcCu61'], "text"),
                       GetSQLValueString($_POST['IgRAcCu62'], "text"),
                       GetSQLValueString($_POST['IgRAcCu63'], "text"),
                       GetSQLValueString($_POST['IgRAcCu64'], "text"),
                       GetSQLValueString($_POST['ResAcad7'], "text"),
                       GetSQLValueString($_POST['PeReAc7'], "text"),
                       GetSQLValueString($_POST['TiReAc7'], "text"),
                       GetSQLValueString($_POST['IGeRANu7'], "text"),
                       GetSQLValueString($_POST['IGeRADe7'], "text"),
                       GetSQLValueString($_POST['IgRAcCu71'], "text"),
                       GetSQLValueString($_POST['IgRAcCu72'], "text"),
                       GetSQLValueString($_POST['IgRAcCu73'], "text"),
                       GetSQLValueString($_POST['IgRAcCu74'], "text"),
                       GetSQLValueString($_POST['ResAcad8'], "text"),
                       GetSQLValueString($_POST['PeReAc8'], "text"),
                       GetSQLValueString($_POST['TiReAc8'], "text"),
                       GetSQLValueString($_POST['IGeRANu8'], "text"),
                       GetSQLValueString($_POST['IGeRADe8'], "text"),
                       GetSQLValueString($_POST['IgRAcCu81'], "text"),
                       GetSQLValueString($_POST['IgRAcCu82'], "text"),
                       GetSQLValueString($_POST['IgRAcCu83'], "text"),
                       GetSQLValueString($_POST['IgRAcCu84'], "text"),
                       GetSQLValueString($_POST['ResAdm1'], "text"),
                       GetSQLValueString($_POST['PeReAd1'], "text"),
                       GetSQLValueString($_POST['TiReAd1'], "text"),
                       GetSQLValueString($_POST['IgeRAdNu1'], "text"),
                       GetSQLValueString($_POST['IgeRAdDe1'], "text"),
                       GetSQLValueString($_POST['IgRAdCu11'], "text"),
                       GetSQLValueString($_POST['IgRAdCu12'], "text"),
                       GetSQLValueString($_POST['IgRAdCu13'], "text"),
                       GetSQLValueString($_POST['IgRAdCu14'], "text"),
                       GetSQLValueString($_POST['ResAdm2'], "text"),
                       GetSQLValueString($_POST['PeReAd2'], "text"),
                       GetSQLValueString($_POST['TiReAd2'], "text"),
                       GetSQLValueString($_POST['IgeRAdNu2'], "text"),
                       GetSQLValueString($_POST['IgeRAdDe2'], "text"),
                       GetSQLValueString($_POST['IgRAdCu21'], "text"),
                       GetSQLValueString($_POST['IgRAdCu22'], "text"),
                       GetSQLValueString($_POST['IgRAdCu23'], "text"),
                       GetSQLValueString($_POST['IgRAdCu24'], "text"),
                       GetSQLValueString($_POST['ResAdm3'], "text"),
                       GetSQLValueString($_POST['PeReAd3'], "text"),
                       GetSQLValueString($_POST['TiReAd3'], "text"),
                       GetSQLValueString($_POST['IgeRAdNu3'], "text"),
                       GetSQLValueString($_POST['IgeRAdDe3'], "text"),
                       GetSQLValueString($_POST['IgRAdCu31'], "text"),
                       GetSQLValueString($_POST['IgRAdCu32'], "text"),
                       GetSQLValueString($_POST['IgRAdCu33'], "text"),
                       GetSQLValueString($_POST['IgRAdCu34'], "text"),
                       GetSQLValueString($_POST['ResAdm4'], "text"),
                       GetSQLValueString($_POST['PeReAd4'], "text"),
                       GetSQLValueString($_POST['TiReAd4'], "text"),
                       GetSQLValueString($_POST['IgeRAdNu4'], "text"),
                       GetSQLValueString($_POST['IgeRAdDe4'], "text"),
                       GetSQLValueString($_POST['IgRAdCu41'], "text"),
                       GetSQLValueString($_POST['IgRAdCu42'], "text"),
                       GetSQLValueString($_POST['IgRAdCu43'], "text"),
                       GetSQLValueString($_POST['IgRAdCu44'], "text"),
                       GetSQLValueString($_POST['ResAdm5'], "text"),
                       GetSQLValueString($_POST['PeReAd5'], "text"),
                       GetSQLValueString($_POST['TiReAd5'], "text"),
                       GetSQLValueString($_POST['IgeRAdNu5'], "text"),
                       GetSQLValueString($_POST['IgeRAdDe5'], "text"),
                       GetSQLValueString($_POST['IgRAdCu51'], "text"),
                       GetSQLValueString($_POST['IgRAdCu52'], "text"),
                       GetSQLValueString($_POST['IgRAdCu53'], "text"),
                       GetSQLValueString($_POST['IgRAdCu54'], "text"),
                       GetSQLValueString($_POST['ResAdm6'], "text"),
                       GetSQLValueString($_POST['PeReAd6'], "text"),
                       GetSQLValueString($_POST['TiReAd6'], "text"),
                       GetSQLValueString($_POST['IgeRAdNu6'], "text"),
                       GetSQLValueString($_POST['IgeRAdDe6'], "text"),
                       GetSQLValueString($_POST['IgRAdCu61'], "text"),
                       GetSQLValueString($_POST['IgRAdCu62'], "text"),
                       GetSQLValueString($_POST['IgRAdCu63'], "text"),
                       GetSQLValueString($_POST['IgRAdCu64'], "text"),
                       GetSQLValueString($_POST['ResAdm7'], "text"),
                       GetSQLValueString($_POST['PeReAd7'], "text"),
                       GetSQLValueString($_POST['TiReAd7'], "text"),
                       GetSQLValueString($_POST['IgeRAdNu7'], "text"),
                       GetSQLValueString($_POST['IgeRAdDe7'], "text"),
                       GetSQLValueString($_POST['IgRAdCu71'], "text"),
                       GetSQLValueString($_POST['IgRAdCu72'], "text"),
                       GetSQLValueString($_POST['IgRAdCu73'], "text"),
                       GetSQLValueString($_POST['IgRAdCu74'], "text"),
                       GetSQLValueString($_POST['ResAdm8'], "text"),
                       GetSQLValueString($_POST['PeReAd8'], "text"),
                       GetSQLValueString($_POST['TiReAd8'], "text"),
                       GetSQLValueString($_POST['IgeRAdNu8'], "text"),
                       GetSQLValueString($_POST['IgeRAdDe8'], "text"),
                       GetSQLValueString($_POST['IgRAdCu81'], "text"),
                       GetSQLValueString($_POST['IgRAdCu82'], "text"),
                       GetSQLValueString($_POST['IgRAdCu83'], "text"),
                       GetSQLValueString($_POST['IgRAdCu84'], "text"),
                       GetSQLValueString($_POST['CCCoGeEs'], "int"),
                       GetSQLValueString($_POST['CCCoGeEd'], "int"),
                       GetSQLValueString($_POST['CCCoGeUn'], "int"),
                       GetSQLValueString($_POST['CCCoInAp'], "int"),
                       GetSQLValueString($_POST['CCCoBaIn'], "int"),
                       GetSQLValueString($_POST['CCCoMeEa'], "int"),
                       GetSQLValueString($_POST['CCCoCoEm'], "int"),
                       GetSQLValueString($_POST['CCCoEnPo'], "int"),
                       GetSQLValueString($_POST['CCCoTics'], "int"),
                       GetSQLValueString($_POST['CCCoIngl'], "int"),
                       GetSQLValueString($_POST['CCTiDoct'], "int"),
                       GetSQLValueString($_POST['CCTiMaes'], "int"),
                       GetSQLValueString($_POST['CCTiEspe'], "int"),
                       GetSQLValueString($_POST['CCTiPrCa'], "int"),
                       GetSQLValueString($_POST['CCFoDoUn'], "int"),
                       GetSQLValueString($_POST['CCPrApEs'], "int"),
                       GetSQLValueString($_POST['CCGerPro'], "int"),
                       GetSQLValueString($_POST['CCGePoPr'], "int"),
                       GetSQLValueString($_POST['CCGesDoc'], "int"),
                       GetSQLValueString($_POST['CCMaCoOr'], "int"),
                       GetSQLValueString($_POST['CCEmpren'], "int"),
                       GetSQLValueString($_POST['CCInnTra'], "int"),
                       GetSQLValueString($_POST['CCResSoc'], "int"),
                       GetSQLValueString($_POST['CIPlCoPe'], "int"),
                       GetSQLValueString($_POST['CIPlGeIn'], "int"),
                       GetSQLValueString($_POST['CIHaPeDi'], "int"),
                       GetSQLValueString($_POST['CIGePrEd'], "int"),
                       GetSQLValueString($_POST['CIAPEvOp'], "int"),
                       GetSQLValueString($_POST['CIDiLiIn'], "int"),
                       GetSQLValueString($_POST['CIDeInves'], "int"),
                       GetSQLValueString($_POST['CIApPrDo'], "int"),
                       GetSQLValueString($_POST['CIDiArea'], "int"),
                       GetSQLValueString($_POST['CIDiSeCo'], "int"),
                       GetSQLValueString($_POST['CIPrCoSe'], "int"),
                       GetSQLValueString($_POST['CIAdCeSe'], "int"),
                       GetSQLValueString($_POST['CIPrSeCo'], "int"),
                       GetSQLValueString($_POST['CIGePrCo'], "int"),
                       GetSQLValueString($_POST['CICaAcTi'], "int"),
                       GetSQLValueString($_POST['CIFuPlMd'], "int"),
                       GetSQLValueString($_POST['CIFuPlDi'], "int"),
                       GetSQLValueString($_POST['CIDiMaDi'], "int"),
                       GetSQLValueString($_POST['CIDiMaNt'], "int"),
                       GetSQLValueString($_POST['CIDiApMd'], "int"),
                       GetSQLValueString($_POST['CIFuPrEe'], "int"),
                       GetSQLValueString($_POST['CIDiEsEe'], "int"),
                       GetSQLValueString($_POST['CIAdPrEe'], "int"),
                       GetSQLValueString($_POST['CIDePlETO'], "int"),
                       GetSQLValueString($_POST['CIIdOpPr'], "int"),
                       GetSQLValueString($_POST['CIDeImSc'], "int"),
                       GetSQLValueString($_POST['CIeLeVaP'], "int"),
                       GetSQLValueString($_POST['CIInInLe'], "int"),
                       GetSQLValueString($_POST['CIFoSiIn'], "int"),
                       GetSQLValueString($_POST['CIDiPrEm'], "int"),
                       GetSQLValueString($_POST['CICoPrEm'], "int"),
                       GetSQLValueString($_POST['CIFoPrRs'], "int"),
                       GetSQLValueString($_POST['CIDeOpNe'], "int"),
                       GetSQLValueString($_POST['CIAdInTe'], "int"),
                       GetSQLValueString($_POST['CATEMfSi'], "int"),
                       GetSQLValueString($_POST['CATECoId'], "int"),
                       GetSQLValueString($_POST['CATECoCo'], "int"),
                       GetSQLValueString($_POST['CATEApGr'], "int"),
                       GetSQLValueString($_POST['CATEApDe'], "int"),
                       GetSQLValueString($_POST['CATEPrIn'], "int"),
                       GetSQLValueString($_POST['CATEFoUn'], "int"),
                       GetSQLValueString($_POST['CATEFoCo'], "int"),
                       GetSQLValueString($_POST['CATECoOp'], "int"),
                       GetSQLValueString($_POST['CATEReFt'], "int"),
                       GetSQLValueString($_POST['CACOEsAt'], "int"),
                       GetSQLValueString($_POST['CACOBuLe'], "int"),
                       GetSQLValueString($_POST['CACOTrIn'], "int"),
                       GetSQLValueString($_POST['CACODiIn'], "int"),
                       GetSQLValueString($_POST['CACOExPe'], "int"),
                       GetSQLValueString($_POST['CACOFoCo'], "int"),
                       GetSQLValueString($_POST['CACOSoIn'], "int"),
                       GetSQLValueString($_POST['CACOExDe'], "int"),
                       GetSQLValueString($_POST['CACOCoVi'], "int"),
                       GetSQLValueString($_POST['CACOExGc'], "int"),
                       GetSQLValueString($_POST['CACOTiSu'], "int"),
                       GetSQLValueString($_POST['CACOTiDe'], "int"),
                       GetSQLValueString($_POST['CACOExAb'], "int"),
                       GetSQLValueString($_POST['CALIExGr'], "int"),
                       GetSQLValueString($_POST['CALIEsPL'], "int"),
                       GetSQLValueString($_POST['CALIObCo'], "int"),
                       GetSQLValueString($_POST['CALIMeCo'], "int"),
                       GetSQLValueString($_POST['CALIAcCo'], "int"),
                       GetSQLValueString($_POST['CALIAcEx'], "int"),
                       GetSQLValueString($_POST['CALIAsRe'], "int"),
                       GetSQLValueString($_POST['CALIAtPr'], "int"),
                       GetSQLValueString($_POST['CALICoPt'], "int"),
                       GetSQLValueString($_POST['CALICoDe'], "int"),
                       GetSQLValueString($_POST['CALIFoPa'], "int"),
                       GetSQLValueString($_POST['CALICoId'], "int"),
                       GetSQLValueString($_POST['CALIGePa'], "int"),
                       GetSQLValueString($_POST['CALIEsCo'], "int"),
                       GetSQLValueString($_POST['CALIApEf'], "int"),
                       GetSQLValueString($_POST['CALIBuRe'], "int"),
                       GetSQLValueString($_POST['CALIJuEv'], "int"),
                       GetSQLValueString($_POST['CALIReCo'], "int"),
                       GetSQLValueString($_POST['CALITrMv'], "int"),
                       GetSQLValueString($_POST['CALIMoEe'], "int"),
                       GetSQLValueString($_POST['CALIReEx'], "int"),
                       GetSQLValueString($_POST['CALIPeTd'], "int"),
                       GetSQLValueString($_POST['CALIViIn'], "int"),
                       GetSQLValueString($_POST['CALITaEs'], "int"),
                       GetSQLValueString($_POST['CALICoIn'], "int"),
                       GetSQLValueString($_POST['CALIReCa'], "int"),
                       GetSQLValueString($_POST['CASELuCl'], "int"),
                       GetSQLValueString($_POST['CASEAtAm'], "int"),
                       GetSQLValueString($_POST['CASEAsUs'], "int"),
                       GetSQLValueString($_POST['CASEPrNe'], "int"),
                       GetSQLValueString($_POST['CASESoUs'], "int"),
                       GetSQLValueString($_POST['CASEInSo'], "int"),
                       GetSQLValueString($_POST['CASEImUn'], "int"),
                       GetSQLValueString($_POST['CASEAdAc'], "int"),
                       GetSQLValueString($_POST['CASEApOb'], "int"),
                       GetSQLValueString($_POST['CASESeAc'], "int"),
                       GetSQLValueString($_POST['CAADApDi'], "int"),
                       GetSQLValueString($_POST['CAADReCa'], "int"),
                       GetSQLValueString($_POST['CAADPaGr'], "int"),
                       GetSQLValueString($_POST['CAADInCo'], "int"),
                       GetSQLValueString($_POST['CAADCaOp'], "int"),
                       GetSQLValueString($_POST['CAADRePo'], "int"),
                       GetSQLValueString($_POST['CAAPDeCo'], "int"),
                       GetSQLValueString($_POST['CAAPApCo'], "int"),
                       GetSQLValueString($_POST['CAAPNuTe'], "int"),
                       GetSQLValueString($_POST['CAAPAsCu'], "int"),
                       GetSQLValueString($_POST['CAAPUtHe'], "int"),
                       GetSQLValueString($_POST['CAAPInCo'], "int"),
                       GetSQLValueString($_POST['CAAPCoDe'], "int"),
                       GetSQLValueString($_POST['CAAPAcCo'], "int"),
                       GetSQLValueString($_POST['CACODiUn'], "int"),
                       GetSQLValueString($_POST['CACOCoEo'], "int"),
                       GetSQLValueString($_POST['CACOLoMi'], "int"),
                       GetSQLValueString($_POST['CACOLoVi'], "int"),
                       GetSQLValueString($_POST['CACOCoAr'], "int"),
                       GetSQLValueString($_POST['CACOPrIc'], "int"),
                       GetSQLValueString($_POST['CACOReIt'], "int"),
                       GetSQLValueString($_POST['CACOIdPr'], "int"),
                       GetSQLValueString($_POST['CACOCuPr'], "int"),
                       GetSQLValueString($_POST['CACOCoOb'], "int"),
                       GetSQLValueString($_POST['CACOCuRe'], "int"),
                       GetSQLValueString($_POST['CACNAnAd'], "int"),
                       GetSQLValueString($_POST['CACNCoPr'], "int"),
                       GetSQLValueString($_POST['CACNReRa'], "int"),
                       GetSQLValueString($_POST['CACNBuSo'], "int"),
                       GetSQLValueString($_POST['CACNCoCo'], "int"),
                       GetSQLValueString($_POST['CACNEsGg'], "int"),
                       GetSQLValueString($_POST['CACNEnRa'], "int"),
                       GetSQLValueString($_POST['CACNAbPr'], "int"),
                       GetSQLValueString($_POST['CACNEsSd'], "int"),
                       GetSQLValueString($_POST['CACNSeSo'], "int"),
                       GetSQLValueString($_POST['CACIPrId'], "int"),
                       GetSQLValueString($_POST['CACIFoOr'], "int"),
                       GetSQLValueString($_POST['CACIIdUt'], "int"),
                       GetSQLValueString($_POST['CACIReDe'], "int"),
                       GetSQLValueString($_POST['CACIIdNp'], "int"),
                       GetSQLValueString($_POST['CACIEsRe'], "int"),
                       GetSQLValueString($_POST['CADOCuHo'], "int"),
                       GetSQLValueString($_POST['CADOApTi'], "int"),
                       GetSQLValueString($_POST['CADOCoPr'], "int"),
                       GetSQLValueString($_POST['CADOImUn'], "int"),
                       GetSQLValueString($_POST['CADOCoOr'], "int"),
                       GetSQLValueString($_POST['CADOCuPl'], "int"),
                       GetSQLValueString($_POST['CADOTrOr'], "int"),
                       GetSQLValueString($_POST['CADOOrFi'], "int"),
                       GetSQLValueString($_POST['CADOEvDi'], "int"),
                       GetSQLValueString($_POST['CADOCuPr'], "int"),
                       GetSQLValueString($_POST['CAINAsRe'], "int"),
                       GetSQLValueString($_POST['CAINCoDh'], "int"),
                       GetSQLValueString($_POST['CAINCoIn'], "int"),
                       GetSQLValueString($_POST['CAINLeUn'], "int"),
                       GetSQLValueString($_POST['CAINVaUn'], "int"),
                       GetSQLValueString($_POST['CAINAcEt'], "int"),
                       GetSQLValueString($_POST['CAINEvBe'], "int"),
                       GetSQLValueString($_POST['CAINCoAc'], "int"),
                       GetSQLValueString($_POST['CAINReCo'], "int"),
                       GetSQLValueString($_POST['CAMEBaCt'], "int"),
                       GetSQLValueString($_POST['CAMEMaPr'], "int"),
                       GetSQLValueString($_POST['CAMEEnEs'], "int"),
                       GetSQLValueString($_POST['CAMEFoEs'], "int"),
                       GetSQLValueString($_POST['CAMEHaSa'], "int"),
                       GetSQLValueString($_POST['CAMECaMt'], "int"),
                       GetSQLValueString($_POST['CATDImDe'], "int"),
                       GetSQLValueString($_POST['CATDDeRe'], "int"),
                       GetSQLValueString($_POST['CATDRiDe'], "int"),
                       GetSQLValueString($_POST['CATDDeOp'], "int"),
                       GetSQLValueString($_POST['CATDDeAd'], "int"),
                       GetSQLValueString($_POST['CATDEvAl'], "int"),
                       GetSQLValueString($_POST['CATDDoDe'], "int"),
                       GetSQLValueString($_POST['CATDFiDe'], "int"),
                       GetSQLValueString($_POST['CARIAgDe'], "int"),
                       GetSQLValueString($_POST['CARIBuHu'], "int"),
                       GetSQLValueString($_POST['CARICoMe'], "int"),
                       GetSQLValueString($_POST['CARICoCl'], "int"),
                       GetSQLValueString($_POST['CARIBuTo'], "int"),
                       GetSQLValueString($_POST['CARIDiFa'], "int"),
                       GetSQLValueString($_POST['CARIPaAc'], "int"),
                       GetSQLValueString($_POST['CARIAcDi'], "int"),
                       GetSQLValueString($_POST['CARICoLo'], "int"),
                       GetSQLValueString($_POST['CARIPoCo'], "int"),
                       GetSQLValueString($_POST['CAOLInOb'], "int"),
                       GetSQLValueString($_POST['CAOLTrPe'], "int"),
                       GetSQLValueString($_POST['CAOLFoPe'], "int"),
                       GetSQLValueString($_POST['CAOLMcCv'], "int"),
                       GetSQLValueString($_POST['CAOLEjPl'], "int"),
                       GetSQLValueString($_POST['CAOLCrCa'], "int"),
                       GetSQLValueString($_POST['CAOLPpDe'], "int"),
                       GetSQLValueString($_POST['CAOLSuOb'], "int"),
                       GetSQLValueString($_POST['CAOLFoMe'], "int"),
                       GetSQLValueString($_POST['CAOLPrPe'], "int"),
                       GetSQLValueString($_POST['CADOInAp'], "int"),
                       GetSQLValueString($_POST['CADOAnOt'], "int"),
                       GetSQLValueString($_POST['CADOApOt'], "int"),
                       GetSQLValueString($_POST['CADOAcDe'], "int"),
                       GetSQLValueString($_POST['CADOApFl'], "int"),
                       GetSQLValueString($_POST['CADOBrAp'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo24 {font-size: 10px}
.Estilo3 {color: #596221}
.Estilo4 {font-family: Tahoma;
	color: #596221;
	font-weight: bold;
}
.Estilo5 {font-family: Tahoma; color: #596221; }
.Estilo15 {font-size: 16px}
.Estilo22 {color: #FFFFFF; font-weight: bold; }
.Estilo23 {font-family: Tahoma; font-weight: bold; font-size: 12px; color: #FFFFFF; }
.Estilo33 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo37 {color: #FF0000}
.Estilo39 {font-size: 14px}
.Estilo40 {font-family: Tahoma; color: #596221; font-weight: bold; font-size: 14px; }
.Estilo41 {
	font-size: 20px;
	font-weight: bold;
}
.Estilo42 {font-family: Tahoma; color: #596221; font-weight: bold; font-size: 12px; }
.Estilo43 {font-size: 10px}
-->
</style>
<script type="text/JavaScript">
<!--
function MM_popupMsg(msg) { //v1.0
  alert(msg);
}
//-->
</script>
</head>

<body>
<table width="841" border="0">
  <tr>
    <td width="155" height="72" bgcolor="#98BD0D"><div align="center" class="Estilo22"><img src="../IMAGENES/LOGOBOSQUETH.jpg" alt="as" width="138" height="62" /></div></td>
    <td width="277" bgcolor="#98BD0D"><div align="center" class="Estilo23"><span class="Estilo15">FORMATO DE PERFIL DE CARGO</span></div></td>
    <td width="187" bgcolor="#98BD0D"><div align="center" class="Estilo23">C&oacute;digo: <br />
      E-GTH &ndash;F-PC<br />
      Versi&oacute;n: 02<br />
      Fecha de Actualizaci&oacute;n: 27/04/2010</div></td>
    <td width="204" bgcolor="#98BD0D"><div align="center" class="Estilo22"><img src="../IMAGENES/GAPP.jpg" alt="a" width="149" height="53" /></div></td>
  </tr>
</table>
<table width="841" border="0">
  <tr>
    <td bgcolor="#FFB112"><div align="center" class="Estilo4">DEPARTAMENTO DE TALENTO HUMANO - CONSTRUYENDO UN MEJOR EQUIPO </div></td>
  </tr>
</table>
<br />
<table width="840" border="0">
  <tr>
    <td><div align="center">
      <p class="Estilo4">Estimado directivo, por favor responda integralmente el formato. <br />
        </p>
      <p class="Estilo4">Encontrar&aacute; un ejemplo a manera de gu&iacute;a presionando <a href="EJEMPLO DE PERFIL DE CARGO DOCENTES.pdf">aqui</a>. </p>
      </div></td>
  </tr>
</table>
<p class="Estilo4">&nbsp;</p>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <p>&nbsp;</p>
  <table width="841" border="0">
    <tr>
      <td colspan="2" valign="top" bgcolor="#FFFFCC" class="Estilo4"><span class="Estilo4">Unidad Acad&eacute;mica o Administrativa:</span> <span class="Estilo3">
        <input name="UnAcad" type="text" value="" size="70" />
        <br />
      </span></td>
      <td width="192" valign="top" bgcolor="#FFFFCC" class="Estilo4"><span class="Estilo5"><strong>Fecha: <span class="Estilo24">(A&ntilde;o-Mes-Dia</span><span class="Estilo43">)</span><br />
        </strong>
            <input name="FechaDil" type="text" value="" size="32" />
      </span></td>
      <td width="203" valign="top" bgcolor="#FFFFCC" class="Estilo4"><span class="Estilo5"><strong>Persona que procesa</strong>:
        <label> <br />
            <input name="QuiProc" type="text" size="32" />
        </label>
      </span></td>
    </tr>
    <tr>
      <td width="213" valign="top" bgcolor="#FFFFCC" class="Estilo4"><span class="Estilo5"><strong>Nombre del Cargo:<br />
              <input name="NomCargo" type="text" value="" size="32" />
      </strong></span></td>
      <td width="215" valign="top" bgcolor="#FFFFCC" class="Estilo4"><span class="Estilo5"><strong>&Aacute;rea de la unidad:<br />
              <input name="Area" type="text" value="" size="32" />
      </strong></span></td>
      <td colspan="2" valign="top" bgcolor="#FFFFCC" class="Estilo4"><span class="Estilo5"><strong>Nivel del cargo:<br />
      </strong><strong>
      <label>
      <select name="NivCargo">
        <option value="No ha seleccionado">Seleccione el nivel</option>
        <option value="Estrategico">Estrategico</option>
        <option value="Tactico">Tactico</option>
        <option value="Operativo">Operativo</option>
      </select>
      </label>
      </strong></span></td>
    </tr>
    <tr>
      <td height="54" valign="top" bgcolor="#FFFFCC" class="Estilo4">&nbsp;</td>
      <td valign="top" bgcolor="#FFFFCC" class="Estilo4">&nbsp;</td>
      <td valign="top" bgcolor="#FFFFCC" class="Estilo4">&nbsp;</td>
      <td valign="top" bgcolor="#FFFFCC" class="Estilo4">&nbsp;</td>
    </tr>
    <tr>
      <td height="54" colspan="4" valign="top" bgcolor="#FFFF66" class="Estilo4"><div align="center">Si el cargo es acad&eacute;mico responda estos espacios </div></td>
    </tr>
    <tr>
      <td height="54" valign="top" bgcolor="#FFFF33" class="Estilo4"><span class="Estilo5"><strong>        N&uacute;mero de Alumnos:<br />
  <strong><strong>
  <select name="NoAlum">
    <option value="No ha seleccionado">Seleccione el rango</option>
    <option value="5 a 10">5 a 10</option>
    <option value="10 a 20">10 a 20</option>
    <option value="20 a 30">20 a 30</option>
    <option value="30 o mas">30 o mas</option>
  </select>
</strong></strong></strong></span></td>
      <td valign="top" bgcolor="#FFFF33" class="Estilo4"><span class="Estilo5"><strong>        Creditos asignatura:<br />
  <strong>
  <input name="Creditos" type="text" value="" size="10" />
</strong></strong></span></td>
      <td valign="top" bgcolor="#FFFF33" class="Estilo4"><strong>Asignatura:<br />
          <input name="Asignatura" type="text" value="" size="30" />
      </strong></td>
      <td valign="top" bgcolor="#FFFF33" class="Estilo4"><span class="Estilo5"><strong>Escalafon:<br />
      </strong></span><span class="Estilo5"><strong>
      <select name="Escalafon">
        <option value="No ha seleccionado" selected="selected">Seleccione el escalafon</option>
        <option value="Instructor asistente">Instructor asistente</option>
        <option value="Instructor asociado">Instructor asociado</option>
        <option value="Profesor asistente">Profesor asistente</option>
        <option value="Profesor asociado">Profesor asociado</option>
        <option value="Profesor Titular">Profesor Titular</option>
      </select>
      </strong></span></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="840" border="0">
    <tr>
      <td colspan="4" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <p align="center"><strong>OBJETIVO DEL CARGO</strong><br />
            Describa el servicio que brinda y cu&aacute;les son sus clientes internos </p>
      </div></td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="ObCargo" cols="120" rows="10"></textarea>
      </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="840" border="0">
    <tr>
      <td colspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <p class="Estilo4">Seleccione los niveles acad&eacute;micos  y escriba los t&iacute;tulos requeridos para el desempe&ntilde;o del cargo </p>
      </div>
          <div align="center"></div></td>
    </tr>
    <tr>
      <td width="176" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>NIVEL</strong></div></td>
      <td width="654" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>&iquest;EN QU&Eacute;?</strong></div></td>
    </tr>
    <tr>
      <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo4"><label>
        <select name="Prof1">
          <option value="No ha seleccionado">Escoja el nivel</option>
          <option value="Tecnologo">Tecnologo</option>
          <option value="Profesional">Profesional</option>
          <option value="Especialista">Especialista</option>
          <option value="Maestria">Maestria</option>
          <option value="Doctorado">Doctorado</option>
        </select>
      </label></td>
      <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <label></label>
          <input name="ProfNiv1" type="text" size="100" />
      </div></td>
    </tr>
    <tr>
      <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="Prof2">
            <option value="No ha seleccionado">Escoja el nivel</option>
            <option value="Tecnologo">Tecnologo</option>
            <option value="Profesional">Profesional</option>
            <option value="Especialista">Especialista</option>
            <option value="Maestria">Maestria</option>
            <option value="Doctorado">Doctorado</option>
          </select>
      </div></td>
      <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <input name="ProfNiv2" type="text" size="100" />
      </div></td>
    </tr>
    <tr>
      <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="Prof3">
            <option value="No ha seleccionado">Escoja el nivel</option>
            <option value="Tecnologo">Tecnologo</option>
            <option value="Profesional">Profesional</option>
            <option value="Especialista">Especialista</option>
            <option value="Maestria">Maestria</option>
            <option value="Doctorado">Doctorado</option>
          </select>
      </div></td>
      <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <input name="ProfNiv3" type="text" size="100" />
      </div></td>
    </tr>
    <tr>
      <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="Prof4">
            <option value="No ha seleccionado">Escoja el nivel</option>
            <option value="Tecnologo">Tecnologo</option>
            <option value="Profesional">Profesional</option>
            <option value="Especialista">Especialista</option>
            <option value="Maestria">Maestria</option>
            <option value="Doctorado">Doctorado</option>
          </select>
      </div></td>
      <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <input name="ProfNiv4" type="text" size="100" />
      </div></td>
    </tr>
    <tr>
      <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="Prof5">
            <option value="No ha seleccionado">Escoja el nivel</option>
            <option value="Tecnologo">Tecnologo</option>
            <option value="Profesional">Profesional</option>
            <option value="Especialista">Especialista</option>
            <option value="Maestria">Maestria</option>
            <option value="Doctorado">Doctorado</option>
          </select>
      </div></td>
      <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <input name="ProfNiv5" type="text" size="100" />
      </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="840" border="0">
    <tr>
      <td colspan="4" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>CONOCIMIENTOS REQUERIDOS PARA DESEMPE&Ntilde;AR EL CARGO</strong>
              <p>Especifique  el tipo de conocimientos y el nivel requerido para desempe&ntilde;ar el cargo. Tics, Idiomas,  pedagog&iacute;a / andragog&iacute;a, servicio al cliente conocimientos espec&iacute;ficos del &aacute;rea,  otros.</p>
        <p>&nbsp;</p>
      </div></td>
    </tr>
    <tr>
      <td width="655" bgcolor="#FFFFCC" class="Estilo4"><div align="center">Conocimientos en:</div></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center">Nivel</div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><input type="text" name="Conoc1" value="" size="100" /></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="NivCon1">
            <option value="No ha seleccionado">Escoja el nivel</option>
            <option value="Bajo">Bajo</option>
            <option value="Medio">Medio</option>
            <option value="Alto">Alto</option>
          </select>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><input type="text" name="Conoc2" value="" size="100" /></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="NivCon2">
            <option value="No ha seleccionado">Escoja el nivel</option>
            <option value="Bajo">Bajo</option>
            <option value="Medio">Medio</option>
            <option value="Alto">Alto</option>
          </select>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><input type="text" name="Conoc3" value="" size="100" /></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="NivCon3">
            <option value="No ha seleccionado">Escoja el nivel</option>
            <option value="Bajo">Bajo</option>
            <option value="Medio">Medio</option>
            <option value="Alto">Alto</option>
          </select>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><input type="text" name="Conoc4" value="" size="100" /></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="NivCon4">
            <option value="No ha seleccionado">Escoja el nivel</option>
            <option value="Bajo">Bajo</option>
            <option value="Medio">Medio</option>
            <option value="Alto">Alto</option>
          </select>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><input type="text" name="Conoc5" value="" size="100" /></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="NivCon5">
            <option value="No ha seleccionado">Escoja el nivel</option>
            <option value="Bajo">Bajo</option>
            <option value="Medio">Medio</option>
            <option value="Alto">Alto</option>
          </select>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><input type="text" name="Conoc6" value="" size="100" /></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="NivCon6">
            <option value="No ha seleccionado">Escoja el nivel</option>
            <option value="Bajo">Bajo</option>
            <option value="Medio">Medio</option>
            <option value="Alto">Alto</option>
          </select>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><input type="text" name="Conoc7" value="" size="100" /></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="NivCon7">
            <option value="No ha seleccionado">Escoja el nivel</option>
            <option value="Bajo">Bajo</option>
            <option value="Medio">Medio</option>
            <option value="Alto">Alto</option>
          </select>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><input type="text" name="Conoc8" value="" size="100" /></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="NivCon8">
            <option value="No ha seleccionado">Escoja el nivel</option>
            <option value="Bajo">Bajo</option>
            <option value="Medio">Medio</option>
            <option value="Alto">Alto</option>
          </select>
      </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="840" border="0">
    <tr>
      <td colspan="4" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <p><strong>EXPERIENCIA LABORAL PARA DESEMPE&Ntilde;AR EL CARGO</strong></p>
        <p>Especifique el  tipo de experiencia requerida para este cargo e indique el tiempo m&iacute;nimo en  meses o a&ntilde;os.</p>
        <p>&nbsp;</p>
      </div></td>
    </tr>
    <tr>
      <td width="655" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>Experiencia en</strong>:</div></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center">Nivel</div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><input type="text" name="ExpLab1" value="" size="100" /></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="TiExLa1">
            <option value="No ha seleccionado">Escoja el tiempo</option>
            <option value="0 a 6 meses">0 a 6 meses</option>
            <option value="6 meses a 1 a&ntilde;o">6 meses a 1 a&ntilde;o</option>
            <option value="1 a 2 a&ntilde;os">1 a 2 a&ntilde;os</option>
            <option value="2 a 3 a&ntilde;os">2 a 3 a&ntilde;os</option>
            <option value="3 a 5 a&ntilde;os">3 a 5 a&ntilde;os</option>
            <option value="m&aacute;s de 5 a&ntilde;os">m&aacute;s de 5 a&ntilde;os</option>
          </select>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><input type="text" name="ExpLab2" value="" size="100" /></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="TiExLa2">
            <option value="No ha seleccionado">Escoja el tiempo</option>
            <option value="0 a 6 meses">0 a 6 meses</option>
            <option value="6 meses a 1 a&ntilde;o">6 meses a 1 a&ntilde;o</option>
            <option value="1 a 2 a&ntilde;os">1 a 2 a&ntilde;os</option>
            <option value="2 a 3 a&ntilde;os">2 a 3 a&ntilde;os</option>
            <option value="3 a 5 a&ntilde;os">3 a 5 a&ntilde;os</option>
            <option value="m&aacute;s de 5 a&ntilde;os">m&aacute;s de 5 a&ntilde;os</option>
          </select>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><input type="text" name="ExpLab3" value="" size="100" /></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="TiExLa3">
            <option value="No ha seleccionado">Escoja el tiempo</option>
            <option value="0 a 6 meses">0 a 6 meses</option>
            <option value="6 meses a 1 a&ntilde;o">6 meses a 1 a&ntilde;o</option>
            <option value="1 a 2 a&ntilde;os">1 a 2 a&ntilde;os</option>
            <option value="2 a 3 a&ntilde;os">2 a 3 a&ntilde;os</option>
            <option value="3 a 5 a&ntilde;os">3 a 5 a&ntilde;os</option>
            <option value="m&aacute;s de 5 a&ntilde;os">m&aacute;s de 5 a&ntilde;os</option>
          </select>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><input type="text" name="ExpLab4" value="" size="100" /></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="TiExLa4">
            <option value="No ha seleccionado">Escoja el tiempo</option>
            <option value="0 a 6 meses">0 a 6 meses</option>
            <option value="6 meses a 1 a&ntilde;o">6 meses a 1 a&ntilde;o</option>
            <option value="1 a 2 a&ntilde;os">1 a 2 a&ntilde;os</option>
            <option value="2 a 3 a&ntilde;os">2 a 3 a&ntilde;os</option>
            <option value="3 a 5 a&ntilde;os">3 a 5 a&ntilde;os</option>
            <option value="m&aacute;s de 5 a&ntilde;os">m&aacute;s de 5 a&ntilde;os</option>
          </select>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><input type="text" name="ExpLab5" value="" size="100" /></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="TiExLa5">
            <option value="No ha seleccionado">Escoja el tiempo</option>
            <option value="0 a 6 meses">0 a 6 meses</option>
            <option value="6 meses a 1 a&ntilde;o">6 meses a 1 a&ntilde;o</option>
            <option value="1 a 2 a&ntilde;os">1 a 2 a&ntilde;os</option>
            <option value="2 a 3 a&ntilde;os">2 a 3 a&ntilde;os</option>
            <option value="3 a 5 a&ntilde;os">3 a 5 a&ntilde;os</option>
            <option value="m&aacute;s de 5 a&ntilde;os">m&aacute;s de 5 a&ntilde;os</option>
          </select>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><input type="text" name="ExpLab6" value="" size="100" /></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="TiExLa6">
            <option value="No ha seleccionado">Escoja el tiempo</option>
            <option value="0 a 6 meses">0 a 6 meses</option>
            <option value="6 meses a 1 a&ntilde;o">6 meses a 1 a&ntilde;o</option>
            <option value="1 a 2 a&ntilde;os">1 a 2 a&ntilde;os</option>
            <option value="2 a 3 a&ntilde;os">2 a 3 a&ntilde;os</option>
            <option value="3 a 5 a&ntilde;os">3 a 5 a&ntilde;os</option>
            <option value="m&aacute;s de 5 a&ntilde;os">m&aacute;s de 5 a&ntilde;os</option>
          </select>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><input type="text" name="ExpLab7" value="" size="100" /></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="TiExLa7">
            <option value="No ha seleccionado">Escoja el tiempo</option>
            <option value="0 a 6 meses">0 a 6 meses</option>
            <option value="6 meses a 1 a&ntilde;o">6 meses a 1 a&ntilde;o</option>
            <option value="1 a 2 a&ntilde;os">1 a 2 a&ntilde;os</option>
            <option value="2 a 3 a&ntilde;os">2 a 3 a&ntilde;os</option>
            <option value="3 a 5 a&ntilde;os">3 a 5 a&ntilde;os</option>
            <option value="m&aacute;s de 5 a&ntilde;os">m&aacute;s de 5 a&ntilde;os</option>
          </select>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><input type="text" name="ExpLab8" value="" size="100" /></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="TiExLa8">
            <option value="No ha seleccionado">Escoja el tiempo</option>
            <option value="0 a 6 meses">0 a 6 meses</option>
            <option value="6 meses a 1 a&ntilde;o">6 meses a 1 a&ntilde;o</option>
            <option value="1 a 2 a&ntilde;os">1 a 2 a&ntilde;os</option>
            <option value="2 a 3 a&ntilde;os">2 a 3 a&ntilde;os</option>
            <option value="3 a 5 a&ntilde;os">3 a 5 a&ntilde;os</option>
            <option value="m&aacute;s de 5 a&ntilde;os">m&aacute;s de 5 a&ntilde;os</option>
          </select>
      </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="840" border="0">
    <tr>
      <td colspan="4" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <p><strong>CAPACITACI&Oacute;N QUE LA UNIVERSIDAD O UNIDAD <br />
            DEBEN BRINDAR PARA DESEMPE&Ntilde;AR  EL CARGO</strong></p>
        <p>Especifique  la capacitaci&oacute;n requerida y el nivel requerido para desempe&ntilde;ar el cargo. <br />
          (TICs,  Idiomas, softwares espec&iacute;ficos,  otros que no puede aprender en ning&uacute;n otro cargo)</p>
        <p>&nbsp;</p>
      </div></td>
    </tr>
    <tr>
      <td width="655" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>Capacitaci&oacute;n en</strong>:</div></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center">Nivel</div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><input type="text" name="Capac1" value="" size="100" /></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="NivCap1">
            <option value="No ha seleccionado">Escoja el nivel</option>
            <option value="Bajo">Bajo</option>
            <option value="Medio">Medio</option>
            <option value="Alto">Alto</option>
          </select>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><input type="text" name="Capac2" value="" size="100" /></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="NivCap2">
            <option value="No ha seleccionado">Escoja el nivel</option>
            <option value="Bajo">Bajo</option>
            <option value="Medio">Medio</option>
            <option value="Alto">Alto</option>
          </select>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><input type="text" name="Capac3" value="" size="100" /></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="NivCap3">
            <option value="No ha seleccionado">Escoja el nivel</option>
            <option value="Bajo">Bajo</option>
            <option value="Medio">Medio</option>
            <option value="Alto">Alto</option>
          </select>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><input type="text" name="Capac4" value="" size="100" /></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="NivCap4">
            <option value="No ha seleccionado">Escoja el nivel</option>
            <option value="Bajo">Bajo</option>
            <option value="Medio">Medio</option>
            <option value="Alto">Alto</option>
          </select>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><input type="text" name="Capac5" value="" size="100" /></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="NivCap5">
            <option value="No ha seleccionado">Escoja el nivel</option>
            <option value="Bajo">Bajo</option>
            <option value="Medio">Medio</option>
            <option value="Alto">Alto</option>
          </select>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><input type="text" name="Capac6" value="" size="100" /></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="NivCap6">
            <option value="No ha seleccionado">Escoja el nivel</option>
            <option value="Bajo">Bajo</option>
            <option value="Medio">Medio</option>
            <option value="Alto">Alto</option>
          </select>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><input type="text" name="Capac7" value="" size="100" /></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="NivCap7">
            <option value="No ha seleccionado">Escoja el nivel</option>
            <option value="Bajo">Bajo</option>
            <option value="Medio">Medio</option>
            <option value="Alto">Alto</option>
          </select>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><input type="text" name="Capac8" value="" size="100" /></td>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="NivCap8">
            <option value="No ha seleccionado">Escoja el nivel</option>
            <option value="Bajo">Bajo</option>
            <option value="Medio">Medio</option>
            <option value="Alto">Alto</option>
          </select>
      </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="845" border="0">
    <tr>
      <td colspan="5" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
        <p>Relacione enseguida las responsabilidades del cargo</p>
        <p>Tenga en cuenta que algunos cargos acad&eacute;micos pueden tener responsabilidades administrativas.<br />
          (SI NO LAS TIENE, DEJE ESTOS ESPACIOS EN BLANCO) </p>
        </div></td>
    </tr>
    <tr>
      <td width="185" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo33">RESPONSABILIDADES ADMINISTRATIVAS </div></td>
      <td width="194" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>PERIODICIDAD</strong></div></td>
      <td width="162" bgcolor="#FFFFCC" class="Estilo4"><div align="center">TIPO</div></td>
      <td width="167" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>&Iacute;NDICE DE GESTI&Oacute;N CUANTITATIVO</strong><br />
              <span class="Estilo43">numerador<br />
                -------------------<br />
                denominador</span><br />
      </div></td>
      <td width="115" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>&Iacute;NDICES DE GESTI&Oacute;N CUALITATIVO</strong></div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="ResAdm1" cols="25" rows="3"></textarea>
      </div></td>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <select name="PeReAd1">
            <option value="No ha seleccionado">Escoja la periodicidad</option>
            <option value="Diario">Diario</option>
            <option value="Semanal">Semanal</option>
            <option value="Mensual">Mensual</option>
            <option value="Trimestral">Trimestral</option>
            <option value="Semestral">Semestral</option>
            <option value="Anual">Anual</option>
            <option value="Otro">Otro</option>
          </select>
      </div></td>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <select name="TiReAd1">
            <option value="No ha seleccionado" selected="selected">Escoja el tipo</option>
            <option value="Planeacion">Planeacion</option>
            <option value="Ejecucion">Ejecucion</option>
            <option value="Control">Control</option>
            <option value="Analisis">Analisis</option>
            <option value="Retroalimentacion">Retroalimentacion</option>
          </select>
      </div></td>
      <td height="50" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="IgeRAdNu1" cols="25" rows="2"></textarea>
      </div></td>
      <td rowspan="2" align="center" valign="middle" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <input type="text" name="IgRAdCu11" value="" size="15" />
          <br />
          <input type="text" name="IgRAdCu12" value="" size="15" />
          <br />
          <input type="text" name="IgRAdCu13" value="" size="15" />
          <br />
          <input type="text" name="IgRAdCu14" value="" size="15" />
          <br />
          <br />
      </div></td>
    </tr>
    <tr>
      <td height="46" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="IgeRAdDe1" cols="25" rows="2"></textarea>
      </div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="ResAdm2" cols="25" rows="3"></textarea>
      </div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="PeReAd2">
            <option value="No ha seleccionado">Escoja la periodicidad</option>
            <option value="Diario">Diario</option>
            <option value="Semanal">Semanal</option>
            <option value="Mensual">Mensual</option>
            <option value="Trimestral">Trimestral</option>
            <option value="Semestral">Semestral</option>
            <option value="Anual">Anual</option>
            <option value="Otro">Otro</option>
          </select>
      </div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="TiReAd2">
            <option value="No ha seleccionado" selected="selected">Escoja el tipo</option>
            <option value="Planeacion">Planeacion</option>
            <option value="Ejecucion">Ejecucion</option>
            <option value="Control">Control</option>
            <option value="Analisis">Analisis</option>
            <option value="Retroalimentacion">Retroalimentacion</option>
          </select>
      </div></td>
      <td height="53" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="IgeRAdNu2" cols="25" rows="2"></textarea>
      </div></td>
      <td rowspan="2" valign="middle" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <input type="text" name="IgRAdCu21" value="" size="15" />
          <br />
          <input type="text" name="IgRAdCu22" value="" size="15" />
          <br />
          <input type="text" name="IgRAdCu23" value="" size="15" />
          <br />
          <input type="text" name="IgRAdCu24" value="" size="15" />
          <br />
          <br />
      </div></td>
    </tr>
    <tr>
      <td height="39" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="IgeRAdDe2" cols="25" rows="2"></textarea>
      </div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="ResAdm3" cols="25" rows="3"></textarea>
      </div></td>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <select name="PeReAd3">
            <option value="No ha seleccionado">Escoja la periodicidad</option>
            <option value="Diario">Diario</option>
            <option value="Semanal">Semanal</option>
            <option value="Mensual">Mensual</option>
            <option value="Trimestral">Trimestral</option>
            <option value="Semestral">Semestral</option>
            <option value="Anual">Anual</option>
            <option value="Otro">Otro</option>
          </select>
      </div></td>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <select name="TiReAd3">
            <option value="No ha seleccionado" selected="selected">Escoja el tipo</option>
            <option value="Planeacion">Planeacion</option>
            <option value="Ejecucion">Ejecucion</option>
            <option value="Control">Control</option>
            <option value="Analisis">Analisis</option>
            <option value="Retroalimentacion">Retroalimentacion</option>
          </select>
      </div></td>
      <td height="52" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="IgeRAdNu3" cols="25" rows="2"></textarea>
      </div></td>
      <td rowspan="2" valign="middle" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <input type="text" name="IgRAdCu31" value="" size="15" />
          <br />
          <input type="text" name="IgRAdCu32" value="" size="15" />
          <br />
          <input type="text" name="IgRAdCu33" value="" size="15" />
          <br />
          <input type="text" name="IgRAdCu34" value="" size="15" />
          <br />
          <br />
          <br />
      </div></td>
    </tr>
    <tr>
      <td height="49" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="IgeRAdDe3" cols="25" rows="2"></textarea>
      </div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="ResAdm4" cols="25" rows="3"></textarea>
      </div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="PeReAd4">
            <option value="No ha seleccionado">Escoja la periodicidad</option>
            <option value="Diario">Diario</option>
            <option value="Semanal">Semanal</option>
            <option value="Mensual">Mensual</option>
            <option value="Trimestral">Trimestral</option>
            <option value="Semestral">Semestral</option>
            <option value="Anual">Anual</option>
            <option value="Otro">Otro</option>
          </select>
      </div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="TiReAd4">
            <option value="No ha seleccionado" selected="selected">Escoja el tipo</option>
            <option value="Planeacion">Planeacion</option>
            <option value="Ejecucion">Ejecucion</option>
            <option value="Control">Control</option>
            <option value="Analisis">Analisis</option>
            <option value="Retroalimentacion">Retroalimentacion</option>
          </select>
      </div></td>
      <td height="48" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="IgeRAdNu4" cols="25" rows="2"></textarea>
      </div></td>
      <td rowspan="2" valign="middle" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <input type="text" name="IgRAdCu41" value="" size="15" />
          <br />
          <input type="text" name="IgRAdCu42" value="" size="15" />
          <br />
          <input type="text" name="IgRAdCu43" value="" size="15" />
          <br />
          <input type="text" name="IgRAdCu44" value="" size="15" />
          <br />
          <br />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="IgeRAdDe4" cols="25" rows="2"></textarea>
      </div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="ResAdm5" cols="25" rows="3"></textarea>
      </div></td>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <select name="PeReAd5">
            <option value="No ha seleccionado">Escoja la periodicidad</option>
            <option value="Diario">Diario</option>
            <option value="Semanal">Semanal</option>
            <option value="Mensual">Mensual</option>
            <option value="Trimestral">Trimestral</option>
            <option value="Semestral">Semestral</option>
            <option value="Anual">Anual</option>
            <option value="Otro">Otro</option>
          </select>
      </div></td>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <select name="TiReAd5">
            <option value="No ha seleccionado" selected="selected">Escoja el tipo</option>
            <option value="Planeacion">Planeacion</option>
            <option value="Ejecucion">Ejecucion</option>
            <option value="Control">Control</option>
            <option value="Analisis">Analisis</option>
            <option value="Retroalimentacion">Retroalimentacion</option>
          </select>
      </div></td>
      <td height="50" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="IgeRAdNu5" cols="25" rows="2"></textarea>
      </div></td>
      <td rowspan="2" valign="middle" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <input type="text" name="IgRAdCu51" value="" size="15" />
          <br />
          <input type="text" name="IgRAdCu52" value="" size="15" />
          <br />
          <input type="text" name="IgRAdCu53" value="" size="15" />
          <br />
          <input type="text" name="IgRAdCu54" value="" size="15" />
          <br />
          <br />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="IgeRAdDe5" cols="25" rows="2"></textarea>
      </div></td>
    </tr>
  </table>
  <table width="845" border="0">
    <tr>
      <td width="185" rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="ResAdm6" cols="25" rows="3"></textarea>
      </div></td>
      <td width="194" rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><select name="PeReAd6">
          <option value="No ha seleccionado">Escoja la periodicidad</option>
          <option value="Diario">Diario</option>
          <option value="Semanal">Semanal</option>
          <option value="Mensual">Mensual</option>
          <option value="Trimestral">Trimestral</option>
          <option value="Semestral">Semestral</option>
          <option value="Anual">Anual</option>
          <option value="Otro">Otro</option>
      </select></td>
      <td width="163" rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="TiReAd6">
            <option value="No ha seleccionado" selected="selected">Escoja el tipo</option>
            <option value="Planeacion">Planeacion</option>
            <option value="Ejecucion">Ejecucion</option>
            <option value="Control">Control</option>
            <option value="Analisis">Analisis</option>
            <option value="Retroalimentacion">Retroalimentacion</option>
          </select>
      </div></td>
      <td width="167" height="50" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="IgeRAdNu6" cols="25" rows="2"></textarea>
      </div></td>
      <td width="114" rowspan="2" align="center" valign="middle" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <input type="text" name="IgRAdCu61" value="" size="15" />
          <br />
          <input type="text" name="IgRAdCu62" value="" size="15" />
          <br />
          <input type="text" name="IgRAdCu63" value="" size="15" />
          <br />
          <input type="text" name="IgRAdCu64" value="" size="15" />
          <br />
          <br />
      </div></td>
    </tr>
    <tr>
      <td height="46" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="IgeRAdDe6" cols="25" rows="2"></textarea>
      </div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="ResAdm7" cols="25" rows="3"></textarea>
      </div></td>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><select name="PeReAd7">
          <option value="No ha seleccionado">Escoja la periodicidad</option>
          <option value="Diario">Diario</option>
          <option value="Semanal">Semanal</option>
          <option value="Mensual">Mensual</option>
          <option value="Trimestral">Trimestral</option>
          <option value="Semestral">Semestral</option>
          <option value="Anual">Anual</option>
          <option value="Otro">Otro</option>
      </select></td>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <select name="TiReAd7">
            <option value="No ha seleccionado" selected="selected">Escoja el tipo</option>
            <option value="Planeacion">Planeacion</option>
            <option value="Ejecucion">Ejecucion</option>
            <option value="Control">Control</option>
            <option value="Analisis">Analisis</option>
            <option value="Retroalimentacion">Retroalimentacion</option>
          </select>
      </div></td>
      <td height="53" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="IgeRAdNu7" cols="25" rows="2"></textarea>
      </div></td>
      <td rowspan="2" valign="middle" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <input type="text" name="IgRAdCu71" value="" size="15" />
          <br />
          <input type="text" name="IgRAdCu72" value="" size="15" />
          <br />
          <input type="text" name="IgRAdCu73" value="" size="15" />
          <br />
          <input type="text" name="IgRAdCu74" value="" size="15" />
          <br />
          <br />
      </div></td>
    </tr>
    <tr>
      <td height="39" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="IgeRAdDe7" cols="25" rows="2"></textarea>
      </div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="ResAdm8" cols="25" rows="3"></textarea>
      </div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><select name="PeReAd8">
          <option value="No ha seleccionado">Escoja la periodicidad</option>
          <option value="Diario">Diario</option>
          <option value="Semanal">Semanal</option>
          <option value="Mensual">Mensual</option>
          <option value="Trimestral">Trimestral</option>
          <option value="Semestral">Semestral</option>
          <option value="Anual">Anual</option>
          <option value="Otro">Otro</option>
      </select></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="TiReAd8">
            <option value="No ha seleccionado" selected="selected">Escoja el tipo</option>
            <option value="Planeacion">Planeacion</option>
            <option value="Ejecucion">Ejecucion</option>
            <option value="Control">Control</option>
            <option value="Analisis">Analisis</option>
            <option value="Retroalimentacion">Retroalimentacion</option>
          </select>
      </div></td>
      <td height="52" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="IgeRAdNu8" cols="25" rows="2"></textarea>
      </div></td>
      <td rowspan="2" valign="middle" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <input type="text" name="IgRAdCu81" value="" size="15" />
          <br />
          <input type="text" name="IgRAdCu82" value="" size="15" />
          <br />
          <input type="text" name="IgRAdCu83" value="" size="15" />
          <br />
          <input type="text" name="IgRAdCu84" value="" size="15" />
          <br />
          <br />
      </div></td>
    </tr>
    <tr>
      <td height="49" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="IgeRAdDe8" cols="25" rows="2"></textarea>
      </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="845" border="0" bgcolor="#FFFF66">
    <tr>
      <td colspan="5" bgcolor="#FFFFCC" class="Estilo4"><p align="center">Si el cargo es acad&eacute;mico relacione a continuaci&oacute;n las responsabilidades <strong><u><br />
      </u></strong>del  cargo.</p></td>
    </tr>
    <tr>
      <td colspan="5" bgcolor="#FFFFCC" class="Estilo4"><div align="center"></div></td>
    </tr>
    <tr>
      <td width="185" bgcolor="#FFFFCC" class="Estilo4"><div align="center" class="Estilo33">RESPONSABILIDADES ACAD&Eacute;MICAS</div></td>
      <td width="194" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>PERIODICIDAD</strong></div></td>
      <td width="162" bgcolor="#FFFFCC" class="Estilo4"><div align="center">TIPO</div></td>
      <td width="167" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>&Iacute;NDICE DE GESTI&Oacute;N CUANTITATIVO</strong><br />
              <span class="Estilo43">numerador<br />
                -------------------<br />
                denominador</span><br />
      </div></td>
      <td width="115" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>&Iacute;NDICES DE GESTI&Oacute;N CUALITATIVO</strong></div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="ResAcad1" cols="25" rows="3"></textarea>
      </div></td>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <select name="PeReAc1">
            <option value="No ha seleccionado">Escoja la periodicidad</option>
            <option value="Diario">Diario</option>
            <option value="Semanal">Semanal</option>
            <option value="Mensual">Mensual</option>
            <option value="Trimestral">Trimestral</option>
            <option value="Semestral">Semestral</option>
            <option value="Anual">Anual</option>
            <option value="Otro">Otro</option>
          </select>
      </div></td>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <select name="TiReAc1">
            <option value="No ha seleccionado" selected="selected">Escoja el tipo</option>
            <option value="Planeacion">Planeacion</option>
            <option value="Ejecucion">Ejecucion</option>
            <option value="Control">Control</option>
            <option value="Analisis">Analisis</option>
            <option value="Retroalimentacion">Retroalimentacion</option>
          </select>
      </div></td>
      <td height="50" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="IGeRANu1" cols="25" rows="2"></textarea>
      </div></td>
      <td rowspan="2" align="center" valign="middle" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <input type="text" name="IgRAcCu11" value="" size="15" />
          <br />
          <input type="text" name="IgRAcCu12" value="" size="15" />
          <br />
          <input type="text" name="IgRAcCu13" value="" size="15" />
          <br />
          <input type="text" name="IgRAcCu14" value="" size="15" />
          <br />
          <br />
      </div></td>
    </tr>
    <tr>
      <td height="46" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="IGeRADe1" cols="25" rows="2"></textarea>
      </div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="ResAcad2" cols="25" rows="3"></textarea>
      </div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="PeReAc2">
            <option value="No ha seleccionado">Escoja la periodicidad</option>
            <option value="Diario">Diario</option>
            <option value="Semanal">Semanal</option>
            <option value="Mensual">Mensual</option>
            <option value="Trimestral">Trimestral</option>
            <option value="Semestral">Semestral</option>
            <option value="Anual">Anual</option>
            <option value="Otro">Otro</option>
          </select>
      </div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="TiReAc2">
            <option value="No ha seleccionado" selected="selected">Escoja el tipo</option>
            <option value="Planeacion">Planeacion</option>
            <option value="Ejecucion">Ejecucion</option>
            <option value="Control">Control</option>
            <option value="Analisis">Analisis</option>
            <option value="Retroalimentacion">Retroalimentacion</option>
          </select>
      </div></td>
      <td height="53" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="IGeRANu2" cols="25" rows="2"></textarea>
      </div></td>
      <td rowspan="2" valign="middle" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <input type="text" name="IgRAcCu21" value="" size="15" />
          <br />
          <input type="text" name="IgRAcCu22" value="" size="15" />
          <br />
          <input type="text" name="IgRAcCu23" value="" size="15" />
          <br />
          <input type="text" name="IgRAcCu24" value="" size="15" />
          <br />
          <br />
      </div></td>
    </tr>
    <tr>
      <td height="39" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="IGeRADe2" cols="25" rows="2"></textarea>
      </div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="ResAcad3" cols="25" rows="3"></textarea>
      </div></td>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <select name="PeReAc3">
            <option value="No ha seleccionado">Escoja la periodicidad</option>
            <option value="Diario">Diario</option>
            <option value="Semanal">Semanal</option>
            <option value="Mensual">Mensual</option>
            <option value="Trimestral">Trimestral</option>
            <option value="Semestral">Semestral</option>
            <option value="Anual">Anual</option>
            <option value="Otro">Otro</option>
          </select>
      </div></td>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <select name="TiReAc3">
            <option value="No ha seleccionado" selected="selected">Escoja el tipo</option>
            <option value="Planeacion">Planeacion</option>
            <option value="Ejecucion">Ejecucion</option>
            <option value="Control">Control</option>
            <option value="Analisis">Analisis</option>
            <option value="Retroalimentacion">Retroalimentacion</option>
          </select>
      </div></td>
      <td height="52" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="IGeRANu3" cols="25" rows="2"></textarea>
      </div></td>
      <td rowspan="2" valign="middle" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <input type="text" name="IgRAcCu31" value="" size="15" />
          <br />
          <input type="text" name="IgRAcCu32" value="" size="15" />
          <br />
          <input type="text" name="IgRAcCu33" value="" size="15" />
          <br />
          <input type="text" name="IgRAcCu34" value="" size="15" />
          <br />
          <br />
          <br />
      </div></td>
    </tr>
    <tr>
      <td height="49" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="IGeRADe3" cols="25" rows="2"></textarea>
      </div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="ResAcad4" cols="25" rows="3"></textarea>
      </div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="PeReAc4">
            <option value="No ha seleccionado">Escoja la periodicidad</option>
            <option value="Diario">Diario</option>
            <option value="Semanal">Semanal</option>
            <option value="Mensual">Mensual</option>
            <option value="Trimestral">Trimestral</option>
            <option value="Semestral">Semestral</option>
            <option value="Anual">Anual</option>
            <option value="Otro">Otro</option>
          </select>
      </div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="TiReAc4">
            <option value="No ha seleccionado" selected="selected">Escoja el tipo</option>
            <option value="Planeacion">Planeacion</option>
            <option value="Ejecucion">Ejecucion</option>
            <option value="Control">Control</option>
            <option value="Analisis">Analisis</option>
            <option value="Retroalimentacion">Retroalimentacion</option>
          </select>
      </div></td>
      <td height="48" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="IGeRANu4" cols="25" rows="2"></textarea>
      </div></td>
      <td rowspan="2" valign="middle" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <input type="text" name="IgRAcCu41" value="" size="15" />
          <br />
          <input type="text" name="IgRAcCu42" value="" size="15" />
          <br />
          <input type="text" name="IgRAcCu43" value="" size="15" />
          <br />
          <input type="text" name="IgRAcCu44" value="" size="15" />
          <br />
          <br />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="IGeRADe4" cols="25" rows="2"></textarea>
      </div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="ResAcad5" cols="25" rows="3"></textarea>
      </div></td>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <select name="PeReAc5">
            <option value="No ha seleccionado">Escoja la periodicidad</option>
            <option value="Diario">Diario</option>
            <option value="Semanal">Semanal</option>
            <option value="Mensual">Mensual</option>
            <option value="Trimestral">Trimestral</option>
            <option value="Semestral">Semestral</option>
            <option value="Anual">Anual</option>
            <option value="Otro">Otro</option>
          </select>
      </div></td>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <select name="TiReAc5">
            <option value="No ha seleccionado" selected="selected">Escoja el tipo</option>
            <option value="Planeacion">Planeacion</option>
            <option value="Ejecucion">Ejecucion</option>
            <option value="Control">Control</option>
            <option value="Analisis">Analisis</option>
            <option value="Retroalimentacion">Retroalimentacion</option>
          </select>
      </div></td>
      <td height="50" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="IGeRANu5" cols="25" rows="2"></textarea>
      </div></td>
      <td rowspan="2" valign="middle" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <input type="text" name="IgRAcCu51" value="" size="15" />
          <br />
          <input type="text" name="IgRAcCu52" value="" size="15" />
          <br />
          <input type="text" name="IgRAcCu53" value="" size="15" />
          <br />
          <input type="text" name="IgRAcCu54" value="" size="15" />
          <br />
          <br />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="IGeRADe5" cols="25" rows="2"></textarea>
      </div></td>
    </tr>
  </table>
  <table width="845" border="0">
    <tr>
      <td width="185" rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="ResAcad6" cols="25" rows="3"></textarea>
      </div></td>
      <td width="194" rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><select name="PeReAc6">
          <option value="No ha seleccionado">Escoja la periodicidad</option>
          <option value="Diario">Diario</option>
          <option value="Semanal">Semanal</option>
          <option value="Mensual">Mensual</option>
          <option value="Trimestral">Trimestral</option>
          <option value="Semestral">Semestral</option>
          <option value="Anual">Anual</option>
          <option value="Otro">Otro</option>
      </select></td>
      <td width="163" rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="TiReAc6">
            <option value="No ha seleccionado" selected="selected">Escoja el tipo</option>
            <option value="Planeacion">Planeacion</option>
            <option value="Ejecucion">Ejecucion</option>
            <option value="Control">Control</option>
            <option value="Analisis">Analisis</option>
            <option value="Retroalimentacion">Retroalimentacion</option>
          </select>
      </div></td>
      <td width="167" height="50" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="IGeRANu6" cols="25" rows="2"></textarea>
      </div></td>
      <td width="114" rowspan="2" align="center" valign="middle" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <input type="text" name="IgRAcCu61" value="" size="15" />
          <br />
          <input type="text" name="IgRAcCu62" value="" size="15" />
          <br />
          <input type="text" name="IgRAcCu63" value="" size="15" />
          <br />
          <input type="text" name="IgRAcCu64" value="" size="15" />
          <br />
          <br />
      </div></td>
    </tr>
    <tr>
      <td height="46" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="IGeRADe6" cols="25" rows="2"></textarea>
      </div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="ResAcad7" cols="25" rows="3"></textarea>
      </div></td>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><select name="PeReAc7">
          <option value="No ha seleccionado">Escoja la periodicidad</option>
          <option value="Diario">Diario</option>
          <option value="Semanal">Semanal</option>
          <option value="Mensual">Mensual</option>
          <option value="Trimestral">Trimestral</option>
          <option value="Semestral">Semestral</option>
          <option value="Anual">Anual</option>
          <option value="Otro">Otro</option>
      </select></td>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <select name="TiReAc7">
            <option value="No ha seleccionado" selected="selected">Escoja el tipo</option>
            <option value="Planeacion">Planeacion</option>
            <option value="Ejecucion">Ejecucion</option>
            <option value="Control">Control</option>
            <option value="Analisis">Analisis</option>
            <option value="Retroalimentacion">Retroalimentacion</option>
          </select>
      </div></td>
      <td height="53" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="IGeRANu7" cols="25" rows="2"></textarea>
      </div></td>
      <td rowspan="2" valign="middle" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <input type="text" name="IgRAcCu71" value="" size="15" />
          <br />
          <input type="text" name="IgRAcCu72" value="" size="15" />
          <br />
          <input type="text" name="IgRAcCu73" value="" size="15" />
          <br />
          <input type="text" name="IgRAcCu74" value="" size="15" />
          <br />
          <br />
      </div></td>
    </tr>
    <tr>
      <td height="39" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="IGeRADe7" cols="25" rows="2"></textarea>
      </div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="ResAcad8" cols="25" rows="3"></textarea>
      </div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="PeReAc8">
            <option value="No ha seleccionado">Escoja la periodicidad</option>
            <option value="Diario">Diario</option>
            <option value="Semanal">Semanal</option>
            <option value="Mensual">Mensual</option>
            <option value="Trimestral">Trimestral</option>
            <option value="Semestral">Semestral</option>
            <option value="Anual">Anual</option>
            <option value="Otro">Otro</option>
          </select>
      </div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <select name="TiReAc8">
            <option value="No ha seleccionado" selected="selected">Escoja el tipo</option>
            <option value="Planeacion">Planeacion</option>
            <option value="Ejecucion">Ejecucion</option>
            <option value="Control">Control</option>
            <option value="Analisis">Analisis</option>
            <option value="Retroalimentacion">Retroalimentacion</option>
          </select>
      </div></td>
      <td height="52" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="IGeRANu8" cols="25" rows="2"></textarea>
      </div></td>
      <td rowspan="2" valign="middle" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <input type="text" name="IgRAcCu81" value="" size="15" />
          <br />
          <input type="text" name="IgRAcCu82" value="" size="15" />
          <br />
          <input type="text" name="IgRAcCu83" value="" size="15" />
          <br />
          <input type="text" name="IgRAcCu84" value="" size="15" />
          <br />
          <br />
      </div></td>
    </tr>
    <tr>
      <td height="49" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="IGeRADe8" cols="25" rows="2"></textarea>
      </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="840" border="0">
    <tr>
      <td><p align="center" class="Estilo4">De acuerdo  al organigrama de la unidad a la cual corresponde el cargo, por favor  especifique los cargos colaterales y los cargos subalternos </p></td>
    </tr>
  </table>
  <table width="840" border="0">
    <tr>
      <td colspan="2" bgcolor="#FFFFCC"><p align="center" class="Estilo5"><strong>CARGO DEL JEFE INMEDIATO</strong>:
        <input type="text" name="CargJeIn" value="" size="60" />
      </p></td>
    </tr>
    <tr>
      <td width="414" bgcolor="#FFFFCC"><div align="center" class="Estilo5"><strong>CARGOS COLATERALES</strong></div></td>
      <td width="416" bgcolor="#FFFFCC"><div align="center" class="Estilo5"><strong>CARGOS SUBALTERNOS </strong></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC"><div align="center" class="Estilo5">
          <input type="text" name="CargCol1" value="" size="60" />
      </div></td>
      <td bgcolor="#FFFFCC"><div align="center" class="Estilo5">
          <input type="text" name="CargRep1" value="" size="60" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC"><div align="center" class="Estilo5">
          <input type="text" name="CargCol2" value="" size="60" />
      </div></td>
      <td bgcolor="#FFFFCC"><div align="center" class="Estilo5">
          <input type="text" name="CargRep2" value="" size="60" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC"><div align="center" class="Estilo5">
          <input type="text" name="CargCol3" value="" size="60" />
      </div></td>
      <td bgcolor="#FFFFCC"><div align="center" class="Estilo5">
          <input type="text" name="CargRep3" value="" size="60" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC"><div align="center" class="Estilo5">
          <input type="text" name="CargCol4" value="" size="60" />
      </div></td>
      <td bgcolor="#FFFFCC"><div align="center" class="Estilo5">
          <input type="text" name="CargRep4" value="" size="60" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC"><div align="center" class="Estilo5">
          <input type="text" name="CargCol5" value="" size="60" />
      </div></td>
      <td bgcolor="#FFFFCC"><div align="center" class="Estilo5">
          <input type="text" name="CargRep5" value="" size="60" />
      </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="832" border="0">
    <tr>
      <td colspan="4" bgcolor="#FFFFCC" class="Estilo4"><p align="center">Describa a  continuaci&oacute;n las relaciones INTERNAS que tiene el cargo y la  actividad que se desarrolla.<br />
      ESTAS RELACIONES SON CON CARGOS DE LA UNIDAD Y DE OTRAS UNIDADES </p>
      </td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#FFFFCC" class="Estilo4"><div align="center"></div></td>
    </tr>
    <tr>
      <td width="209" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>CON QU&Eacute; CARGO</strong></div></td>
      <td width="210" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>&iquest;PARA QU&Eacute;?</strong></div></td>
      <td width="185" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>&Iacute;NDICE DE GESTI&Oacute;N CUANTITATIVO</strong><br />
              <span class="Estilo24">numerador<br />
                -------------------<br />
                denominador</span><br />
      </div></td>
      <td width="210" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>&Iacute;NDICES DE GESTI&Oacute;N CUALITATIVO</strong></div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="CarReIn1" cols="25" rows="3"></textarea>
      </div></td>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="ObReIn1" cols="25" rows="3"></textarea>
      </div></td>
      <td height="50" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="IgRiNu1" cols="25" rows="2"></textarea>
      </div></td>
      <td rowspan="2" align="center" valign="middle" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <input type="text" name="IgRiCu11" value="" size="15" />
          <br />
          <input type="text" name="IgRiCu12" value="" size="15" />
          <br />
          <input type="text" name="IgRiCu13" value="" size="15" />
          <br />
          <input type="text" name="IgRiCu14" value="" size="15" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="IgRiDe1" cols="25" rows="2"></textarea>
      </div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="CarReIn2" cols="25" rows="3"></textarea>
      </div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="ObReIn2" cols="25" rows="3"></textarea>
      </div></td>
      <td height="44" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="IgRiNu2" cols="25" rows="2"></textarea>
      </div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <input type="text" name="IgRiCu21" value="" size="15" />
          <br />
          <input type="text" name="IgRiCu22" value="" size="15" />
          <br />
          <input type="text" name="IgRiCu23" value="" size="15" />
          <br />
          <input type="text" name="IgRiCu24" value="" size="15" />
          <br />
          <br />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="IgRiDe2" cols="25" rows="2"></textarea>
      </div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="CarReIn3" cols="25" rows="3"></textarea>
      </div></td>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="ObReIn3" cols="25" rows="3"></textarea>
      </div></td>
      <td height="44" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="IgRiNu3" cols="25" rows="2"></textarea>
      </div></td>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <input type="text" name="IgRiCu31" value="" size="15" />
          <br />
          <input type="text" name="IgRiCu32" value="" size="15" />
          <br />
          <input type="text" name="IgRiCu33" value="" size="15" />
          <br />
          <input type="text" name="IgRiCu34" value="" size="15" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="IgRiDe3" cols="25" rows="2"></textarea>
      </div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="CarReIn4" cols="25" rows="3"></textarea>
      </div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="ObReIn4" cols="25" rows="3"></textarea>
      </div></td>
      <td height="48" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="IgRiNu4" cols="25" rows="2"></textarea>
      </div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <input type="text" name="IgRiCu41" value="" size="15" />
          <br />
          <input type="text" name="IgRiCu42" value="" size="15" />
          <br />
          <input type="text" name="IgRiCu43" value="" size="15" />
          <br />
          <input type="text" name="IgRiCu44" value="" size="15" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="IgRiDe4" cols="25" rows="2"></textarea>
      </div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="CarReIn5" cols="25" rows="3"></textarea>
      </div></td>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="ObReIn5" cols="25" rows="3"></textarea>
      </div></td>
      <td height="45" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="IgRiNu5" cols="25" rows="2"></textarea>
      </div></td>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <input type="text" name="IgRiCu51" value="" size="15" />
          <br />
          <input type="text" name="IgRiCu52" value="" size="15" />
          <br />
          <input type="text" name="IgRiCu53" value="" size="15" />
          <br />
          <input type="text" name="IgRiCu54" value="" size="15" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="IgRiDe5" cols="25" rows="2"></textarea>
      </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="832" border="0">
    <tr>
      <td colspan="4" bgcolor="#FFFFCC" class="Estilo4"><p align="center">Describa a  continuaci&oacute;n las relaciones EXTERNAS que tiene el cargo y la  actividad que se desarrolla.<br />
      ESTAS RELACIONES SON CON CARGOS FUERA DE LA UNIVERSIDAD </p>
        <p align="center">DEJE EN BLANCO SI NO APLICA PARA ESTE CARGO </p></td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#FFFFCC" class="Estilo4"><div align="center"></div></td>
    </tr>
    <tr>
      <td width="209" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>CON QU&Eacute; CARGO</strong></div></td>
      <td width="210" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>&iquest;PARA QU&Eacute;?</strong></div></td>
      <td width="185" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>&Iacute;NDICE DE GESTI&Oacute;N CUANTITATIVO</strong><br />
              <span class="Estilo24">numerador<br />
                -------------------<br />
                denominador</span><br />
      </div></td>
      <td width="210" bgcolor="#FFFFCC" class="Estilo4"><div align="center"><strong>&Iacute;NDICES DE GESTI&Oacute;N CUALITATIVO</strong></div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="CarReEx1" cols="25" rows="3"></textarea>
      </div></td>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="ObReEx1" cols="25" rows="3"></textarea>
      </div></td>
      <td height="50" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="IgReNu1" cols="25" rows="2"></textarea>
      </div></td>
      <td rowspan="2" align="center" valign="middle" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <input type="text" name="IgReCu11" value="" size="15" />
          <br />
          <input type="text" name="IgReCu12" value="" size="15" />
          <br />
          <input type="text" name="IgReCu13" value="" size="15" />
          <br />
          <input type="text" name="IgReCu14" value="" size="15" />
          <br />
          <br />
      </div></td>
    </tr>
    <tr>
      <td height="46" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="IgReDe1" cols="25" rows="2"></textarea>
      </div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="CarReEx2" cols="25" rows="3"></textarea>
      </div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="ObReEx2" cols="25" rows="3"></textarea>
      </div></td>
      <td height="53" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="IgReNu2" cols="25" rows="2"></textarea>
      </div></td>
      <td rowspan="2" valign="middle" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <input type="text" name="IgReCu21" value="" size="15" />
          <br />
          <input type="text" name="IgReCu22" value="" size="15" />
          <br />
          <input type="text" name="IgReCu23" value="" size="15" />
          <br />
          <input type="text" name="IgReCu24" value="" size="15" />
          <br />
          <br />
      </div></td>
    </tr>
    <tr>
      <td height="39" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="IgReDe2" cols="25" rows="2"></textarea>
      </div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="CarReEx3" cols="25" rows="3"></textarea>
      </div></td>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="ObReEx3" cols="25" rows="3"></textarea>
      </div></td>
      <td height="52" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="IgReNu3" cols="25" rows="2"></textarea>
      </div></td>
      <td rowspan="2" valign="middle" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <input type="text" name="IgReCu31" value="" size="15" />
          <br />
          <input type="text" name="IgReCu32" value="" size="15" />
          <br />
          <input type="text" name="IgReCu33" value="" size="15" />
          <br />
          <input type="text" name="IgReCu34" value="" size="15" />
          <br />
          <br />
      </div></td>
    </tr>
    <tr>
      <td height="49" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="IgReDe3" cols="25" rows="2"></textarea>
      </div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="CarReEx4" cols="25" rows="3"></textarea>
      </div></td>
      <td rowspan="2" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="ObReEx4" cols="25" rows="3"></textarea>
      </div></td>
      <td height="48" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="IgReNu4" cols="25" rows="2"></textarea>
      </div></td>
      <td rowspan="2" valign="middle" bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <input type="text" name="IgReCu41" value="" size="15" />
          <br />
          <input type="text" name="IgReCu42" value="" size="15" />
          <br />
          <input type="text" name="IgReCu43" value="" size="15" />
          <br />
          <input type="text" name="IgReCu44" value="" size="15" />
          <br />
          <br />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><div align="center">
          <textarea name="IgReDe4" cols="25" rows="2"></textarea>
      </div></td>
    </tr>
    <tr>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="CarReEx5" cols="25" rows="3"></textarea>
      </div></td>
      <td rowspan="2" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="ObReEx5" cols="25" rows="3"></textarea>
      </div></td>
      <td height="50" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="IgReNu5" cols="25" rows="2"></textarea>
      </div></td>
      <td rowspan="2" valign="middle" bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <input type="text" name="IgReCu51" value="" size="15" />
          <br />
          <input type="text" name="IgReCu52" value="" size="15" />
          <br />
          <input type="text" name="IgReCu53" value="" size="15" />
          <br />
          <input type="text" name="IgReCu54" value="" size="15" />
          <br />
          <br />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#E7CEFF" class="Estilo4"><div align="center">
          <textarea name="IgReDe5" cols="25" rows="2"></textarea>
      </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="844" border="0">
    <tr>
      <td width="838" bgcolor="#FFFFCC" class="Estilo4"><p align="center" class="Estilo41">A continuaci&oacute;n debe determinar los niveles </p>
        <p align="center" class="Estilo41">de las competencias que requiere el cargo</p>
      <p align="center">&nbsp;</p></td>
    </tr>
  </table>
  <table border="1" cellspacing="0" cellpadding="0">
    <tr>
      <td width="307" valign="top" bordercolor="#FFFFFF" bgcolor="#FFFFCC" class="Estilo4"><p><strong>COMPETENCIAS    COGNOSCITIVAS:</strong></p></td>
      <td width="315" valign="top" bordercolor="#FFFFFF" bgcolor="#FFFFCC" class="Estilo4"><p align="justify">Se    refieren a los conocimientos requeridos para el adecuado desempe&ntilde;o del cargo</p></td>
      <td width="213" rowspan="3" bordercolor="#FFFFFF" bgcolor="#FFFFCC" class="Estilo4"><p align="center">Usted debe definir los niveles    esperados seg&uacute;n su criterio teniendo en cuenta el cargo que est&aacute; analizando<strong></strong></p></td>
    </tr>
    <tr>
      <td width="307" valign="top" bordercolor="#FFFFFF" bgcolor="#FFFFCC" class="Estilo4"><p><strong>COMPETENCIAS    INSTRUMENTALES</strong></p></td>
      <td width="315" valign="top" bordercolor="#FFFFFF" bgcolor="#FFFFCC" class="Estilo4"><p align="justify">Se    refieren a las habilidades (aplicaci&oacute;n del conocimiento) requeridas para el    adecuado desempe&ntilde;o del cargo</p></td>
    </tr>
    <tr>
      <td width="307" valign="top" bordercolor="#FFFFFF" bgcolor="#FFFFCC" class="Estilo4"><p><strong>COMPETENCIAS    ACTITUDINALES</strong></p></td>
      <td width="315" valign="top" bordercolor="#FFFFFF" bgcolor="#FFFFCC" class="Estilo4"><p align="justify">Se    refieren a las actitudes y comportamientos&nbsp;    que debe poseer el funcionario para enfrentar con &eacute;xito el entorno    social donde se desempe&ntilde;ar&aacute;</p></td>
    </tr>
  </table>
  <p></p>
  <table width="853" border="1" bordercolor="#FFFFFF" bgcolor="#FFFFCC">
    <tr>
      <td colspan="6" bordercolor="#FFFFFF" class="Estilo4"><div align="center">
        <p><strong>COMPETENCIAS  <span class="Estilo37">COGNOSCITIVAS</span> PARA DESEMPE&Ntilde;AR EL CARGO</strong><br />          
          <strong>Conocimientos que debe  poseer el funcionario para desempe&ntilde;ar adecuadamente el cargo</strong><br />
        DEJE EN BLANCO LOS QUE NO APLICAN PARA ESTE CARGO </p>
        <p>&nbsp;</p>
      </div></td>
    </tr>
    
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4"><div align="center">COMPETENCIA</div></td>
      <td width="255" colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><strong>Determine el nivel  requerido</strong></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Conocimientos    en Gerencia estrat&eacute;gica</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CCCoGeEs">
        <option value="0">No requiere esta competencia</option>
        <option value="2">Bajo</option>
        <option value="3">Intermedio</option>
        <option value="4">Alto</option>
        <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Conocimientos    en Gerencia educativa</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CCCoGeEd">
        <option value="0">No requiere esta competencia</option>
        <option value="2">Bajo</option>
        <option value="3">Intermedio</option>
        <option value="4">Alto</option>
        <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Conocimientos    en gesti&oacute;n universitaria</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CCCoGeUn">
        <option value="0">No requiere esta competencia</option>
        <option value="2">Bajo</option>
        <option value="3">Intermedio</option>
        <option value="4">Alto</option>
        <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Conocimientos    en investigaci&oacute;n en su &aacute;rea particular</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CCCoInAp">
        <option value="0">No requiere esta competencia</option>
        <option value="2">Bajo</option>
        <option value="3">Intermedio</option>
        <option value="4">Alto</option>
        <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Conocimientos    generales en investigaci&oacute;n </td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CCCoBaIn">
        <option value="0">No requiere esta competencia</option>
        <option value="2">Bajo</option>
        <option value="3">Intermedio</option>
        <option value="4">Alto</option>
        <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Conocimientos    en metodolog&iacute;as y t&eacute;cnicas de ense&ntilde;anza-aprendizaje</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CCCoMeEa">
        <option value="0">No requiere esta competencia</option>
        <option value="2">Bajo</option>
        <option value="3">Intermedio</option>
        <option value="4">Alto</option>
        <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Conocimientos    &nbsp;en consultor&iacute;a empresarial</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CCCoCoEm">
        <option value="0">No requiere esta competencia</option>
        <option value="2">Bajo</option>
        <option value="3">Intermedio</option>
        <option value="4">Alto</option>
        <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Conocimiento    del entorno pol&iacute;tico, econ&oacute;mico, social y cultural</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CCCoEnPo">
        <option value="0">No requiere esta competencia</option>
        <option value="2">Bajo</option>
        <option value="3">Intermedio</option>
        <option value="4">Alto</option>
        <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Conocimientos    de TICS y desarrollos tecnol&oacute;gicos</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CCCoTics">
        <option value="0">No requiere esta competencia</option>
        <option value="2">Bajo</option>
        <option value="3">Intermedio</option>
        <option value="4">Alto</option>
        <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Dominio    del idioma ingl&eacute;s</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CCCoIngl">
        <option value="0">No requiere esta competencia</option>
        <option value="2">Bajo</option>
        <option value="3">Intermedio</option>
        <option value="4">Alto</option>
        <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Titulaci&oacute;n    de doctorado o su equivalente en experiencia</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CCTiDoct">
        <option value="0">No requiere esta competencia</option>
        <option value="2">Bajo</option>
        <option value="3">Intermedio</option>
        <option value="4">Alto</option>
        <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Titulaci&oacute;n&nbsp; de maestr&iacute;a o su equivalente en experiencia</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CCTiMaes">
        <option value="0">No requiere esta competencia</option>
        <option value="2">Bajo</option>
        <option value="3">Intermedio</option>
        <option value="4">Alto</option>
        <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Titulaci&oacute;n&nbsp; de especializaci&oacute;n o su equivalente en    experiencia</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CCTiEspe">
        <option value="0">No requiere esta competencia</option>
        <option value="2">Bajo</option>
        <option value="3">Intermedio</option>
        <option value="4">Alto</option>
        <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Titulaci&oacute;n    profesional (pregrado) en carreras afines a la actividad</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CCTiPrCa">
        <option value="0">No requiere esta competencia</option>
        <option value="2">Bajo</option>
        <option value="3">Intermedio</option>
        <option value="4">Alto</option>
        <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Formaci&oacute;n    en docencia universitaria</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CCFoDoUn">
        <option value="0">No requiere esta competencia</option>
        <option value="2">Bajo</option>
        <option value="3">Intermedio</option>
        <option value="4">Alto</option>
        <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Conocimientos    de procesos de apoyo al &eacute;xito estudiantil </td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CCPrApEs">
        <option value="0">No requiere esta competencia</option>
        <option value="2">Bajo</option>
        <option value="3">Intermedio</option>
        <option value="4">Alto</option>
        <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" bgcolor="#CC33FF" class="Estilo4">Conocimiento en gerencia de proyectos </td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" bgcolor="#CC33FF" class="Estilo4"><select name="CCGerPro">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" bgcolor="#CC33FF" class="Estilo4">Conocimiento en gestion por procesos</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" bgcolor="#CC33FF" class="Estilo4"><select name="CCGePoPr">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" bgcolor="#CC33FF" class="Estilo4">Conocimiento en gestion documental</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" bgcolor="#CC33FF" class="Estilo4"><select name="CCGesDoc">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" bgcolor="#CC33FF" class="Estilo4">Conocimiento en manejo de comunicacion organizacional</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" bgcolor="#CC33FF" class="Estilo4"><select name="CCMaCoOr">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" bgcolor="#CC33FF" class="Estilo4">Conocimiento en emprendimiento</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" bgcolor="#CC33FF" class="Estilo4"><select name="CCEmpren">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" bgcolor="#CC33FF" class="Estilo4">Conocimiento en innovacion y transferencia (I+T) </td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" bgcolor="#CC33FF" class="Estilo4"><select name="CCInnTra">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" bgcolor="#CC33FF" class="Estilo4">Conocimiento en responsabilidad social</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" bgcolor="#CC33FF" class="Estilo4"><select name="CCResSoc">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="853" border="1" bordercolor="#FFFFFF" bgcolor="#FFFFCC">
    <tr>
      <td colspan="6" bordercolor="#FFFFFF" class="Estilo4"><div align="center">
        <p><strong>COMPETENCIAS  <span class="Estilo37">INSTRUMENTALES</span> PARA DESEMPE&Ntilde;AR EL CARGO</strong><br />
          <strong>Habilidades o experiencia que debe  poseer el funcionario para desempe&ntilde;ar adecuadamente el cargo</strong><br />
        DEJE EN BLANCO LAS QUE NO APLICAN PARA ESTE CARGO </p>
        <p>&nbsp;</p>
      </div></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4"><div align="center">COMPETENCIA</div></td>
      <td width="255" colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><strong>Determine el nivel  requerido</strong></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Planeaci&oacute;n,    control y seguimiento&nbsp; pol&iacute;tico,    estrat&eacute;gico y administrativo del proyecto&nbsp;    educativo</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CIPlCoPe">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Planeaci&oacute;n y gesti&oacute;n de Investigaci&oacute;n</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CIPlGeIn">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Habilidades pedag&oacute;gicas y did&aacute;cticas</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CIHaPeDi">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Gesti&oacute;n de procesos de calidad educativa</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CIGePrEd">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Aplicaci&oacute;n de evaluaciones operativas a los procesos de    aprendizaje, evaluaci&oacute;n del aprendizaje y procesos formaci&oacute;n</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CIAPEvOp">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Direcci&oacute;n de l&iacute;neas y grupos de investigaci&oacute;n</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CIDiLiIn">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Desarrollo de investigaci&oacute;n en los diversos niveles de formaci&oacute;n</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CIDeInves">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Apoyo a procesos de docencia, investigaci&oacute;n y servicios en    funciones delegadas</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CIApPrDo">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Direcci&oacute;n de &aacute;reas</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CIDiArea">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Dise&ntilde;o de servicios y consultor&iacute;as especializados</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CIDiSeCo">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Programaci&oacute;n y control de servicios y consultor&iacute;as    especializados</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CIPrCoSe">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Administraci&oacute;n de los centros de servicios especializados</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CIAdCeSe">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Prestaci&oacute;n de los servicios y consultor&iacute;as especializados</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CIPrSeCo">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Gesti&oacute;n de Proyectos&nbsp; y    convenios</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CIGePrCo">
        <option value="0">No requiere esta competencia</option>
        <option value="2">Bajo</option>
        <option value="3">Intermedio</option>
        <option value="4">Alto</option>
        <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Capacidad de acceder a las TICs</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CICaAcTi">
        <option value="0">No requiere esta competencia</option>
        <option value="2">Bajo</option>
        <option value="3">Intermedio</option>
        <option value="4">Alto</option>
        <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Fundamentaci&oacute;n y planeaci&oacute;n de materiales did&aacute;cticos y nuevas    tecnolog&iacute;as para la educaci&oacute;n</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CIFuPlMd">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Fundamentaci&oacute;n, planeaci&oacute;n y dise&ntilde;o de materiales did&aacute;cticos y    nuevas tecnolog&iacute;as para la educaci&oacute;n</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CIFuPlDi">
        <option value="0">No requiere esta competencia</option>
        <option value="2">Bajo</option>
        <option value="3">Intermedio</option>
        <option value="4">Alto</option>
        <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Dise&ntilde;o de materiales did&aacute;cticos</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CIDiMaDi">
        <option value="0">No requiere esta competencia</option>
        <option value="2">Bajo</option>
        <option value="3">Intermedio</option>
        <option value="4">Alto</option>
        <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Dise&ntilde;o de materiales did&aacute;cticos y nuevas tecnolog&iacute;as para la    educaci&oacute;n</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CIDiMaNt">
        <option value="0">No requiere esta competencia</option>
        <option value="2">Bajo</option>
        <option value="3">Intermedio</option>
        <option value="4">Alto</option>
        <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Desarrollo&nbsp; y aplicaci&oacute;n    de materiales did&aacute;cticos y nuevas tecnolog&iacute;as para la educaci&oacute;n</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CIDiApMd">
        <option value="0">No requiere esta competencia</option>
        <option value="2">Bajo</option>
        <option value="3">Intermedio</option>
        <option value="4">Alto</option>
        <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Fundamentar&nbsp; los programas    y proyectos que promuevan el &eacute;xito estudiantil</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CIFuPrEe">
        <option value="0">No requiere esta competencia</option>
        <option value="2">Bajo</option>
        <option value="3">Intermedio</option>
        <option value="4">Alto</option>
        <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td width="582" valign="bottom" bordercolor="#006600" class="Estilo4">Dise&ntilde;o de estrategias que promuevan el &eacute;xito estudiantil</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CIDiEsEe">
        <option value="0">No requiere esta competencia</option>
        <option value="2">Bajo</option>
        <option value="3">Intermedio</option>
        <option value="4">Alto</option>
        <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" class="Estilo4">Administraci&oacute;n del proceso de &eacute;xito estudiantil</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CIAdPrEe">
        <option value="0">No requiere esta competencia</option>
        <option value="2">Bajo</option>
        <option value="3">Intermedio</option>
        <option value="4">Alto</option>
        <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" bgcolor="#CC66FF" class="Estilo4">Desarrollo plantemiento t&aacute;ctico estrategico y operativo </td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" bgcolor="#CC66FF" class="Estilo4"><select name="CIDePlETO">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" bgcolor="#CC66FF" class="Estilo4">Identificar y optimizar procesos academicos y/o administrativos de su area</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" bgcolor="#CC66FF" class="Estilo4"><select name="CIIdOpPr">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" bgcolor="#CC66FF" class="Estilo4">Desarrollar e implementar sistemas de control</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" bgcolor="#CC66FF" class="Estilo4"><select name="CIDeImSc">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" bgcolor="#CC66FF" class="Estilo4">Elaborar evaluar y administrar proyectos</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" bgcolor="#CC66FF" class="Estilo4"><select name="CIeLeVaP">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" bgcolor="#CC66FF" class="Estilo4">Interpretar informaci&oacute;n legal, contable y financiera para la toma de decisiones</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" bgcolor="#CC66FF" class="Estilo4"><select name="CIInInLe">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" bgcolor="#CC66FF" class="Estilo4">Formular y optimizar sistemas de informacion de su area</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" bgcolor="#CC66FF" class="Estilo4"><select name="CIFoSiIn">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" bgcolor="#CC66FF" class="Estilo4">Dise&ntilde;ar proyectos de emprendimiento</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" bgcolor="#CC66FF" class="Estilo4"><select name="CIDiPrEm">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" bgcolor="#CC66FF" class="Estilo4">Controlar proyectos de emprendimiento</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" bgcolor="#CC66FF" class="Estilo4"><select name="CICoPrEm">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" bgcolor="#CC66FF" class="Estilo4">Fomentar proyectos de responsabilidad social</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" bgcolor="#CC66FF" class="Estilo4"><select name="CIFoPrRs">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" bgcolor="#CC66FF" class="Estilo4">Detectar oportunidads de negocio y desarrollo de nuevos productos o servicios</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" bgcolor="#CC66FF" class="Estilo4"><select name="CIDeOpNe">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
    <tr>
      <td valign="bottom" bordercolor="#006600" bgcolor="#CC66FF" class="Estilo4">Administrar infraestructura tecnol&oacute;gica (software y hardware)</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#006600" bgcolor="#CC66FF" class="Estilo4"><select name="CIAdInTe">
          <option value="0">No requiere esta competencia</option>
          <option value="2">Bajo</option>
          <option value="3">Intermedio</option>
          <option value="4">Alto</option>
          <option value="5">Muy Alto</option>
      </select></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="851" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#FFFFCC">
    <tr>
      <td colspan="4" bordercolor="#FFFFFF" bgcolor="#FFFFCC" class="Estilo4"><p align="center"><strong>COMPETENCIAS  <span class="Estilo37">ACTITUDINALES</span> PARA DESEMPE&Ntilde;AR EL CARGO </strong><br />
      Caracter&iacute;sticas  que debe poseer el funcionario para enfrentar con &eacute;xito el cargo y el entorno social donde  se desempe&ntilde;ar&aacute;</p>
      <p align="center"><strong>&nbsp;ESCOJA LA FRECUENCIA ESPERADA PARA CADA COMPORTAMIENTO </strong><br />
        <strong>SEG&Uacute;N SU CRITERIO TENIENDO EN CUENTA EL CARGO QUE EST&Aacute;  ANALIZANDO</strong></p>
      <p align="center">DEJE EN BLANCO LAS CONDUCTAS QUE NO APLICAN PARA ESTE CARGO </p></td>
    </tr>
    <tr>
      <td colspan="3" bordercolor="#FFFFFF" bgcolor="#FFFFCC" class="Estilo4">&nbsp;</td>
      <td align="center" valign="middle" bordercolor="#FFFFFF" bgcolor="#FFFFCC" class="Estilo4">&nbsp;</td>
    </tr>
    <tr>
      <td width="186" bordercolor="#006600" class="Estilo4"><div align="center">COMPETENCIA</div></td>
      <td width="155" bordercolor="#006600" class="Estilo4"><div align="center">DEFINICI&Oacute;N    OPERACIONAL</div></td>
      <td width="242" bordercolor="#006600" class="Estilo4">CONDUCTAS    IDENTIFICATORIAS</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4">ESCOJA EL NIVEL</td>
    </tr>
    <tr>
      <td width="186" rowspan="10" bordercolor="#006600" class="Estilo4 Estilo39"><div align="center">TRABAJO EN EQUIPO</div></td>
      <td width="155" rowspan="10" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad    de cooperar arm&oacute;nicamente con los dem&aacute;s para lograr los objetivos del equipo.</div></td>
      <td width="242" bordercolor="#006600" class="Estilo42">Muestra    flexibilidad cuando la situaci&oacute;n as&iacute; lo requiere.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CATEMfSi">
        <option value="0">No requiere este comportamiento</option>
        <option value="2">Casi nunca</option>
        <option value="3">A veces</option>
        <option value="4">Casi siempre</option>
        <option value="5">Siempre</option>
            </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Comparte    sus ideas para mejorar la calidad del trabajo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CATECoId">
        <option value="0">No requiere este comportamiento</option>
        <option value="2">Casi nunca</option>
        <option value="3">A veces</option>
        <option value="4">Casi siempre</option>
        <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Comparte    sus conocimientos para mejorar la calidad del trabajo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CATECoCo">
        <option value="0">No requiere este comportamiento</option>
        <option value="2">Casi nunca</option>
        <option value="3">A veces</option>
        <option value="4">Casi siempre</option>
        <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Apoya al    grupo en todo lo que sea necesario para el logro de los objetivos del &aacute;rea.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CATEApGr">
        <option value="0">No requiere este comportamiento</option>
        <option value="2">Casi nunca</option>
        <option value="3">A veces</option>
        <option value="4">Casi siempre</option>
        <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Apoya las    decisiones grupales.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CATEApDe">
        <option value="0">No requiere este comportamiento</option>
        <option value="2">Casi nunca</option>
        <option value="3">A veces</option>
        <option value="4">Casi siempre</option>
        <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Da    prioridad a los intereses del equipo por encima de los propios.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CATEPrIn">
        <option value="0">No requiere este comportamiento</option>
        <option value="2">Casi nunca</option>
        <option value="3">A veces</option>
        <option value="4">Casi siempre</option>
        <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Fomenta la    uni&oacute;n del equipo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CATEFoUn">
        <option value="0">No requiere este comportamiento</option>
        <option value="2">Casi nunca</option>
        <option value="3">A veces</option>
        <option value="4">Casi siempre</option>
        <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Fomenta la    confianza del equipo en situaciones dif&iacute;ciles.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CATEFoCo">
        <option value="0">No requiere este comportamiento</option>
        <option value="2">Casi nunca</option>
        <option value="3">A veces</option>
        <option value="4">Casi siempre</option>
        <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Colabora    oportunamente con sus compa&ntilde;eros para brindar un &oacute;ptimo servicio.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CATECoOp">
        <option value="0">No requiere este comportamiento</option>
        <option value="2">Casi nunca</option>
        <option value="3">A veces</option>
        <option value="4">Casi siempre</option>
        <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Respeta la    forma de trabajo de los dem&aacute;s.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CATEReFt">
        <option value="0">No requiere este comportamiento</option>
        <option value="2">Casi nunca</option>
        <option value="3">A veces</option>
        <option value="4">Casi siempre</option>
        <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="186" rowspan="13" bordercolor="#006600" class="Estilo40"><div align="center">COMUNICACI&Oacute;N</div></td>
      <td width="155" rowspan="13" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad    para recibir, procesar y compartir informaci&oacute;n de manera clara, oralmente y    por escrito</div></td>
      <td width="242" height="32" bordercolor="#006600" class="Estilo42">Escucha    atentamente a los dem&aacute;s.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACOEsAt">
        <option value="0">No requiere este comportamiento</option>
        <option value="2">Casi nunca</option>
        <option value="3">A veces</option>
        <option value="4">Casi siempre</option>
        <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Hace buen    uso del lenguaje.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACOBuLe">
        <option value="0">No requiere este comportamiento</option>
        <option value="2">Casi nunca</option>
        <option value="3">A veces</option>
        <option value="4">Casi siempre</option>
        <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Transmite    la informaci&oacute;n pertinente a los dem&aacute;s.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACOTrIn">
        <option value="0">No requiere este comportamiento</option>
        <option value="2">Casi nunca</option>
        <option value="3">A veces</option>
        <option value="4">Casi siempre</option>
        <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Es    discreto(a) con la informaci&oacute;n confidencial</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACODiIn">
        <option value="0">No requiere este comportamiento</option>
        <option value="2">Casi nunca</option>
        <option value="3">A veces</option>
        <option value="4">Casi siempre</option>
        <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Se expresa    pensando en quienes van a recibir el mensaje.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACOExPe">
        <option value="0">No requiere este comportamiento</option>
        <option value="2">Casi nunca</option>
        <option value="3">A veces</option>
        <option value="4">Casi siempre</option>
        <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Fomenta la    comunicaci&oacute;n para solucionar conflictos.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACOFoCo">
        <option value="0">No requiere este comportamiento</option>
        <option value="2">Casi nunca</option>
        <option value="3">A veces</option>
        <option value="4">Casi siempre</option>
        <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Solicita    la informaci&oacute;n pertinente cuando la requiere</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACOSoIn">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Expresa    prudentemente los desacuerdos con las ideas.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACOExDe">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Mantiene    contacto visual con quien se comunica.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACOCoVi">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Su    expresi&oacute;n gestual y corporal facilita la comunicaci&oacute;n.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACOExGc">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Dedica el    tiempo suficiente para que la comunicaci&oacute;n sea efectiva.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACOTiSu">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Tiene en    cuenta el tiempo de los dem&aacute;s al comunicarse con ellos.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACOTiDe">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Expresa    sus ideas abiertamente.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACOExAb">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="186" rowspan="26" bordercolor="#006600" class="Estilo40"><div align="center">LIDERAZGO</div></td>
      <td width="155" rowspan="26" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad    para establecer objetivos y guiar al grupo&nbsp;    hacia su cumplimiento.</div></td>
      <td width="242" bordercolor="#006600" class="Estilo42">Destaca    los &eacute;xitos del grupo sin apropiarse de ellos.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CALIExGr">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Establece    planes para realizar de manera adecuada y efectiva el trabajo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CALIEsPL">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Establece    objetivos coherentes con los medios t&eacute;cnicos, financieros y humanos    disponibles</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CALIObCo">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Dise&ntilde;a    mecanismos de control y seguimiento del desempe&ntilde;o del equipo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CALIMeCo">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Tiene en    cuenta los acontecimientos laborales y personales importantes de sus    colaboradores.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CALIAcCo">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Aclara las    expectativas que tiene con el equipo de trabajo</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CALIAcEx">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Asume la    responsabilidad por los fracasos del grupo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CALIAsRe">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Atiende    con prontitud a sus colaboradores cuando le necesitan.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CALIAtPr">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Conoce en    profundidad los puestos de trabajo de sus colaboradores.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CALICoPt">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Corrige a    tiempo las desviaciones de los objetivos.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CALICoDe">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Fomenta la    participaci&oacute;n de los miembros del equipo para mejorar los procesos.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CALIFoPa">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Selecciona    colaboradores id&oacute;neos para el equipo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CALICoId">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Genera    participaci&oacute;n para la toma de decisiones</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CALIGePa">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Fomenta en    el grupo un esp&iacute;ritu de cooperaci&oacute;n y confianza.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CALIEsCo">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Aporta    efectivamente para la soluci&oacute;n de conflictos en el equipo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CALIApEf">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Mantiene    una buena relaci&oacute;n interpersonal con sus colaboradores.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CALIBuRe">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Es justo    en la evaluaci&oacute;n de sus colaboradores.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CALIJuEv">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Proporciona    retroalimentaci&oacute;n continua a sus colaboradores.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CALIReCo">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Alinea el    trabajo con la misi&oacute;n y visi&oacute;n de la Universidad.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CALITrMv">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td bordercolor="#006600" bgcolor="#CC00CC" class="Estilo42">Motiva el emprendimiento y esp&iacute;ritu empresarial</td>
      <td align="center" valign="middle" bordercolor="#006600" bgcolor="#CC00CC" class="Estilo4"><select name="CALIMoEe">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Da    reconocimiento a la gente por el &eacute;xito del &aacute;rea.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CALIReEx">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Permite a    sus colaboradores tomar decisiones</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CALIPeTd">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Impulsa    una visi&oacute;n innovadora en el equipo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CALIViIn">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Asigna    tareas a sus colaboradores para estimular su desarrollo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CALITaEs">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Comparte    oportunamente la informaci&oacute;n con sus colaboradores.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CALICoIn">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Encarga a    sus colaboradores retos acordes con sus capacidades.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CALIReCa">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="186" rowspan="10" bordercolor="#006600" class="Estilo40"><div align="center">SERVICIO</div></td>
      <td width="155" rowspan="10" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad    de comprender las necesidades del usuario interno y externo y enfocarse en su    satisfacci&oacute;n.</div></td>
      <td width="242" bordercolor="#006600" class="Estilo42">Se pone en    el lugar del usuario para entender sus necesidades</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CASELuCl">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Atiende    amablemente al usuario.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CASEAtAm">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Asesora al    usuario para encontrar soluci&oacute;n a sus necesidades</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CASEAsUs">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Da    prioridad a las necesidades del usuario antes que a las propias.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CASEPrNe">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Procura    una soluci&oacute;n al usuario, incluso si debe asumir riesgos.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CASESoUs">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Muestra    inter&eacute;s para solucionar posibles problemas de servicio.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CASEInSo">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Se    preocupa por la imagen de la universidad ante el usuario.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CASEImUn">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Adapta sus    actividades para dar mejor servicio al usuario.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CASEAdAc">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Apoya los    objetivos que tiene la Universidad sobre servicio al usuario.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CASEApOb">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Se    esfuerza por brindar un servicio de alta calidad.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CASESeAc">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="186" rowspan="6" bordercolor="#006600" class="Estilo40"><div align="center">ADAPTABILIDAD</div></td>
      <td width="155" rowspan="6" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad    de flexibilizar el comportamiento propio ante el cambio para el logro de    objetivos personales y organizacionales</div></td>
      <td width="242" bordercolor="#006600" class="Estilo42">Aplica a    su trabajo las nuevas disposiciones establecidas por la Universidad</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAADApDi">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Implementa    estrategias para manejar la resistencia al cambio.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAADReCa">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Participa    activamente al interior de su grupo de trabajo para que los cambios tengan    &eacute;xito.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAADPaGr">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Muestra    inter&eacute;s por adquirir conocimientos sobre los cambios que implementa la    Universidad</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAADInCo">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Ve el    cambio como una oportunidad de crecimiento</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAADCaOp">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Responde    positivamente a los cambios de la Universidad</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAADRePo">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="186" rowspan="8" bordercolor="#006600" class="Estilo40"><div align="center">APRENDIZAJE</div></td>
      <td width="155" rowspan="8" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad    para integrar nueva informaci&oacute;n y aplicarla eficazmente</div></td>
      <td width="242" bordercolor="#006600" class="Estilo42">Genera    espacios para el desarrollo del conocimiento en su &aacute;rea</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAAPDeCo">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Aplica en    su trabajo los conocimientos adquiridos</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAAPApCo">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Aplica con    inter&eacute;s las nuevas tecnolog&iacute;as</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAAPNuTe">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Asiste a    cursos de entrenamiento, capacitaci&oacute;n o formaci&oacute;n dentro y fuera de la    Universidad</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAAPAsCu">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Utiliza    herramientas para mejorar su conocimiento en el trabajo (computador,    biblioteca, eventos).</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAAPUtHe">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Muestra    inter&eacute;s por adquirir conocimientos.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAAPInCo">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Pone en    pr&aacute;ctica los conocimientos que le transmiten los dem&aacute;s</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAAPCoDe">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Actualiza    constantemente su conocimiento de normas y procesos relacionados con su    trabajo</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAAPAcCo">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="186" rowspan="11" bordercolor="#006600" class="Estilo40"><div align="center">CONCIENCIA    ORGANIZACIONAL</div></td>
      <td width="155" rowspan="11" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad    de enfocar su labor hacia el cumplimiento de la misi&oacute;n, visi&oacute;n, pol&iacute;ticas,    objetivos y estrategias </div></td>
      <td width="242" bordercolor="#006600" class="Estilo42">Aplica las    directrices de la Universidad a su trabajo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACODiUn">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Conoce la    estructura organizacional de la universidad</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACOCoEo">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Contribuye    al logro de la misi&oacute;n de la Universidad</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACOLoMi">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Contribuye    al logro de la visi&oacute;n de la Universidad</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACOLoVi">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Coopera    con las diferentes &aacute;reas de la Universidad para el logro de los objetivos.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACOCoAr">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Protege la    imagen corporativa de la organizaci&oacute;n.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACOPrIc">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Reconoce    el impacto que tiene su trabajo en otras &aacute;reas.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACOReIt">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Identifica    los procesos de su &aacute;rea de trabajo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACOIdPr">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Cumple con    los procesos de su &aacute;rea de trabajo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACOCuPr">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Conoce los    objetivos de las &aacute;reas con las que se relaciona.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACOCoOb">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Cumple con    el reglamento de trabajo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACOCuRe">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="186" rowspan="10" bordercolor="#006600" class="Estilo40"><div align="center">MANEJO DE CONFLICTOS Y    CAPACIDAD DE NEGOCIACI&Oacute;N</div></td>
      <td width="155" rowspan="10" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad    para manejar situaciones que puedan afectar el desempe&ntilde;o y el avance    organizacional</div></td>
      <td width="242" bordercolor="#006600" class="Estilo42">Act&uacute;a    luego de analizar adecuadamente el conflicto o problema.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACNAnAd">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Conserva    el profesionalismo en situaciones de conflicto o problema.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACNCoPr">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Reacciona    r&aacute;pidamente para solucionar conflictos o problemas.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACNReRa">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Busca    soluciones y no culpables del conflicto o problema.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACNBuSo">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Controla    su comportamiento para no generar ni prolongar el conflicto.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACNCoCo">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Plantea    estrategias GANA-GANA para resolver conflictos y problemas.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACNEsGg">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Entiende    las razones de las partes involucradas en el conflicto</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACNEnRa">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Est&aacute;    abierto/a las propuestas para solucionar el conflicto.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACNAbPr">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Establece    soluciones duraderas a los conflictos o problemas.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACNEsSd">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Hace    seguimiento a la soluci&oacute;n dada a los conflictos y problemas.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACNSeSo">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="186" rowspan="6" bordercolor="#006600" class="Estilo40"><div align="center">CREATIVIDAD E    INNOVACI&Oacute;N</div></td>
      <td width="155" rowspan="6" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad    de generar y aplicar ideas nuevas y &uacute;tiles para un mayor desarrollo personal    y organizacional.</div></td>
      <td width="242" bordercolor="#006600" class="Estilo42">Promueve    la generaci&oacute;n de nuevas ideas.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACIPrId">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Propone    formas originales de hacer las cosas.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACIFoOr">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Genera    ideas &uacute;tiles para la Universidad</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACIIdUt">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Muestra    recursividad cuando enfrenta desaf&iacute;os laborales y personales</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACIReDe">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Cuestiona    la forma de hacer las cosas para idear nuevas pr&aacute;cticas.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACIIdNp">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Fomenta    espacios de reflexi&oacute;n&nbsp; para mejorar los    procesos de trabajo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CACIEsRe">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="186" rowspan="10" bordercolor="#006600" class="Estilo40"><div align="center">DISCIPLINA Y    ORGANIZACI&Oacute;N</div></td>
      <td width="155" rowspan="10" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad    para cumplir las normas de la Universidad y conservar el orden en sus    aspectos personales y profesionales</div></td>
      <td width="242" bordercolor="#006600" class="Estilo42">Cumple los    horarios establecidos.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CADOCuHo">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Aprovecha    productivamente el tiempo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CADOApTi">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Concluye    los procesos y tareas que inicia.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CADOCoPr">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Refleja la    imagen de la Universidad con su comportamiento y presentaci&oacute;n personal.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CADOImUn">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Conserva    un orden adecuado de la documentaci&oacute;n a su cargo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CADOCoOr">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Cumple con    los planes que establece.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CADOCuPl">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" height="31" bordercolor="#006600" class="Estilo42">Realiza su    trabajo ordenadamente.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CADOTrOr">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Mantiene    el orden f&iacute;sico de su &aacute;rea de trabajo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CADOOrFi">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Evita las    distracciones, concentr&aacute;ndose en la actividad que realiza.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CADOEvDi">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Cumple    con los procesos inherentes al cargo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CADOCuPr">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="186" rowspan="9" bordercolor="#006600" class="Estilo40"><div align="center">INTEGRIDAD</div></td>
      <td width="155" rowspan="9" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad para actuar    conforme a las normas &eacute;ticas y&nbsp; morales    y velar por su cumplimiento</div></td>
      <td width="242" bordercolor="#006600" class="Estilo42">Asume la    responsabilidad por sus errores.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAINAsRe">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Muestra    coherencia entre lo que dice y lo que hace.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAINCoDh">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Maneja la    confidencialidad de la informaci&oacute;n pertinente a la Universidad.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAINCoIn">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Muestra    lealtad a la Universidad.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAINLeUn">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Pr&aacute;ctica    los valores de la Universidad</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAINVaUn">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Act&uacute;a    &eacute;ticamente al tomar decisiones</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAINAcEt">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Evita    aceptar beneficios inmerecidos por logros que no le corresponden</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAINEvBe">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Evita    incurrir en comportamientos de acoso laboral.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAINCoAc">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Es    respetuoso/a con sus compa&ntilde;eros.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAINReCo">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="186" rowspan="6" bordercolor="#006600" class="Estilo40"><div align="center">MANEJO DEL ESTR&Eacute;S</div></td>
      <td width="155" rowspan="6" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad de mantener    la efectividad y la serenidad al trabajar bajo presi&oacute;n</div></td>
      <td width="242" bordercolor="#006600" class="Estilo42">Balancea    adecuadamente la carga de trabajo con su vida personal.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAMEBaCt">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Maneja    adecuadamente las presiones que otras personas ejercen.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAMEMaPr">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Enfrenta    lo que le genera estr&eacute;s en lugar de evitarlo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAMEEnEs">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Fomenta    estrategias para el manejo del estr&eacute;s propio y del grupo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAMEFoEs">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Pr&aacute;ctica    h&aacute;bitos de salud que contribuyen con el manejo de estr&eacute;s (alimentaci&oacute;n,    sue&ntilde;o, ejercicio, esparcimiento).</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAMEHaSa">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Conserva    la calma en momentos de alta tensi&oacute;n.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAMECaMt">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    
    <tr>
      <td width="186" rowspan="8" bordercolor="#006600" class="Estilo40"><div align="center">TOMA DE DECISIONES</div></td>
      <td width="155" rowspan="8" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad de definir de    manera precisa, &aacute;gil y &eacute;tica el curso de acci&oacute;n a tomar en diversas    situaciones</div></td>
      <td width="242" bordercolor="#006600" class="Estilo42">Tiene en    cuenta el impacto de las decisiones que toma.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CATDImDe">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Asume las    decisiones con responsabilidad.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CATDDeRe">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Asume los    riesgos al tomar una decisi&oacute;n.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CATDRiDe">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Toma    decisiones oportunamente.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CATDDeOp">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Toma    decisiones adecuadamente cuando la situaci&oacute;n lo requiere</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CATDDeAd">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Eval&uacute;a las    alternativas al tomar decisiones.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CATDEvAl">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Se    documenta para tomar decisiones acertadas.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CATDDoDe">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Se    mantiene firme luego de tomar una decisi&oacute;n.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CATDFiDe">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="186" rowspan="10" bordercolor="#006600" class="Estilo40"><div align="center">RELACIONES    INTERPERSONALES</div></td>
      <td width="155" rowspan="10" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad de mantener    buenas relaciones con los compa&ntilde;eros&nbsp;    para el logro de los objetivos organizacionales y personales</div></td>
      <td width="242" bordercolor="#006600" class="Estilo42">Es    agradable en su trato con los dem&aacute;s.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CARIAgDe">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Comparte    el buen humor con sus compa&ntilde;eros.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CARIBuHu">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Comprende    las manifestaciones emocionales de los dem&aacute;s.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CARICoMe">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Contribuye    al buen clima organizacional.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CARICoCl">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Tiene    buenas relaciones con todas las personas, aunque haya conflictos entre ellas.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CARIBuTo">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Disculpa    f&aacute;cilmente, sin guardar rencor.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CARIDiFa">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Participa    en las actividades sociales de la Universidad</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CARIPaAc">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Acepta la    diversidad (Raza, estrato, sexo, religi&oacute;n, regi&oacute;n, profesi&oacute;n, pol&iacute;tica,    etc.).</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CARIAcDi">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Comparte    con agrado el logro de los dem&aacute;s.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CARICoLo">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Adopta una    posici&oacute;n conciliadora en las relaciones dif&iacute;ciles.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CARIPoCo">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="186" rowspan="10" bordercolor="#006600" class="Estilo40"><div align="center">ORIENTACI&Oacute;N AL LOGRO</div></td>
      <td width="155" rowspan="10" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad para buscar    el desarrollo personal y profesional haciendo el esfuerzo permanente para    lograrlo</div></td>
      <td width="242" bordercolor="#006600" class="Estilo42">Muestra    iniciativa para lograr objetivos personales y laborales.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAOLInOb">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Trabaja    persistentemente hasta lograr las metas que se propone.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAOLTrPe">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Dedica    tiempo a su formaci&oacute;n personal.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAOLFoPe">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Busca    mejorar continuamente su calidad de vida.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAOLMcCv">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Ejecuta    los proyectos laborales a los que se compromete.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAOLEjPl">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Cree en    sus capacidades para lograr lo que se propone.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAOLCrCa">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Tiene un    proyecto profesional definido.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAOLPpDe">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Supera los    obst&aacute;culos para lograr lo que parece imposible.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAOLSuOb">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Busca    formas de mejorar la eficacia de su trabajo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAOLFoMe">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Tiene un    proyecto personal definido.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CAOLPrPe">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="186" rowspan="6" bordercolor="#006600" class="Estilo40"><div align="center">DESARROLLO DE OTRAS    PERSONAS</div></td>
      <td width="155" rowspan="6" bordercolor="#006600" class="Estilo40"><div align="center">Capacidad de motivar y    orientar el crecimiento personal y profesional de compa&ntilde;eros y colaboradores</div></td>
      <td width="242" bordercolor="#006600" class="Estilo42">Act&uacute;a como    instructor de quienes est&aacute;n aprendiendo de un tema</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CADOInAp">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Anima a    los dem&aacute;s a lograr sus objetivos.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CADOAnOt">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Apoya a    otros en su desarrollo personal o profesional.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CADOApOt">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Genera    actividades de desarrollo en el equipo de trabajo.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CADOAcDe">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Apoya a    otros para lograr mayor flexibilidad al cambio.</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CADOApFl">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
    <tr>
      <td width="242" bordercolor="#006600" class="Estilo42">Brinda    apoyo a los dem&aacute;s cuando tienen problemas laborales o personales</td>
      <td width="258" align="center" valign="middle" bordercolor="#006600" class="Estilo4"><select name="CADOBrAp">
          <option value="0">No requiere este comportamiento</option>
          <option value="2">Casi nunca</option>
          <option value="3">A veces</option>
          <option value="4">Casi siempre</option>
          <option value="5">Siempre</option>
      </select></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="840" border="0">
    <tr>
      <td><div align="center">
        <input name="submit" type="submit" onclick="MM_popupMsg('El perfil ha sido enviado correctamente. Ahora ver&aacute; un nuevo perfil en blanco por si requiere diligenciar otro cargo. Si no, simplemente cierre la p&aacute;gina o vaya a otra p&aacute;gina. \r\rMuchas gracias por su colaboraci&oacute;n para construir un mejor equipo\r\rDEPARTAMENTO DE TALENTO HUMANO')" value="Enviar perfil de cargo" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">&nbsp;</td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" class="Estilo4"><p align="center"><strong>MUCHAS GRACIAS POR SU COLABORACI&Oacute;N.</strong></p>
        <p align="center"><strong>ESTO CONTRIBUYE AMPLIAMENTE CON LA CALIDAD DE NUESTRA UNIVERSIDAD  </strong></p>
      <p align="center"><strong>DEPARTAMENTO DE TALENTO HUMANO - GAPP</strong></p></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;  </p>
  <p>
    <input type="hidden" name="MM_insert" value="form1">
  </p>
</form>
<p>&nbsp;</p>
</body>
</html>
