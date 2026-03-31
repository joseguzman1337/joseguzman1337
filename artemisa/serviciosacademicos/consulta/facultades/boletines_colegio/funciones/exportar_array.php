<?php 
require_once("imprimir_arrays_bidimensionales.php");
class exportar
{
	function exportar($array,$formato,$nombrearchivo)
	{
		$this->nombrearchivo=$nombrearchivo;
		$this->formato=$formato;
		$this->array=$array;
	}
	function listar_array()
	{
		$nombrearchivo=trim($this->nombrearchivo);
		switch ($this->formato)
		{
			case 'txt' :
				$strType = 'text/plain';
				$strName = $strDownloadName . ".txt";
				break;
			case 'csv' :
				$strType = 'text/plain';
				$strName = $strDownloadName . ".csv";
				break;
			case 'doc' :
				$strType = 'application/msword';
				$strName = $strDownloadName . ".doc";
				break;
			case 'xml' :
				$strType = 'text/plain';
				$strName = $strDownloadName . ".xml";
				break;
			default :
				$strType = 'application/msexcel';
				$strName = $strDownloadName . ".xls";
				break;
		}
		// Send directly back to the client; set the document type and suggested name
		header("Content-Type: $strType");
		header("Content-Disposition: attachment; filename=$this->nombrearchivo\r\n\r\n");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Pragma: public");
		listar($this->array,"","","no");
		return;
	}
}
?>