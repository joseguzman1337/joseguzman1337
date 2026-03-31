<?php

class DiplomaControl
{
    private $idDiploma;
    public function __construct($idDiploma){
        $this->idDiploma = $idDiploma;
    }

    public function ctrDiploma(){
        $arrayDataDiploma = array();
        $firmas = false;
        #Consulta datos de diploma en la tabla diploma
        $dataDiploma = DiplomaModelo::mdlDiplomasActivos($this->idDiploma);
        $dataFirmas = $this->ctrFirmasDiploma();
        if (!empty($dataDiploma)){
            $validaCampos = DiplomaControl::crtValidaCamposDiploma($dataDiploma);
            $arrayDataDiploma = $validaCampos;
            if (!empty($dataFirmas)){
                $firmas = true;//cuando hay registro de firmas en la consulta
                $arrayDataDiploma["conjuntoFirmas"] = $dataFirmas;
            }
        }
        return $arrayDataDiploma;
    }
    public function crtValidaCamposDiploma($datosDiploma){
        $arrayDataDiploma = array();
        if(empty($datosDiploma[0]["iddiploma"])){ $datosDiploma[0]["iddiploma"]="dummy"; };
        if(empty($datosDiploma[0]["nombrediploma"])){ $datosDiploma[0]["nombrediploma"]="dummy"; };
        if(empty($datosDiploma[0]["encabezadodiploma"])){ $datosDiploma[0]["encabezadodiploma"]="dummy"; };
        if(empty($datosDiploma[0]["intensidaddiploma"])){ $datosDiploma[0]["intensidaddiploma"]="dummy"; };
        if(empty($datosDiploma[0]["fechadiploma"])){ $datosDiploma[0]["fechadiploma"]="dummy"; };

        if(empty($datosDiploma[0]["otorgadiploma"])){ $datosDiploma[0]["otorgadiploma"]="dummy"; };
        if(empty($datosDiploma[0]["enlaceencabezadodiploma"])){ $datosDiploma[0]["enlaceencabezadodiploma"]="imagenDefaultPrioridad.png"; };


        $arrayDataDiploma["orientacionDiploma"]    = "L";
        $arrayDataDiploma["unidadDiploma"]         = "mm";
        $arrayDataDiploma["formatoDiploma"]        = "Letter";
        $arrayDataDiploma["idDiploma"]             = $datosDiploma[0]["iddiploma"];
        $arrayDataDiploma["nombreDiploma"]         = utf8_decode($datosDiploma[0]["nombrediploma"]);
        $arrayDataDiploma["encabezadoDiplomado"]   = utf8_decode($datosDiploma[0]["encabezadodiploma"]);
        $arrayDataDiploma["numeroHorasDiploma"]    = $datosDiploma[0]["intensidaddiploma"];
        $arrayDataDiploma["fechaDiploma"]          = $datosDiploma[0]["fechadiploma"];
        $atributosDiploma                          = $datosDiploma[0]["atributodiploma"];
        $arrayDataDiploma["otorgaDiploma"]         = utf8_decode($datosDiploma[0]["otorgadiploma"]);
        $arrayDataDiploma["fondoImagen"]           = $datosDiploma[0]["enlaceencabezadodiploma"];

        #manejo de atributos y posicionamiento



        return $arrayDataDiploma;
    }
    public function ctrAtributosDiploma($atributosDiploma){
        $position = explode(",", $atributosDiploma);
        if(empty($position[0])){ $position[0]=0; };
        if(empty($position[1])){ $position[1]=0; };
        if(empty($position[2])){ $position[2]=0; };
        if(empty($position[3])){ $position[3]=0; };
        if(empty($position[4])){ $position[4]=0; };
        if(empty($position[5])){ $position[5]=0; };
        // $c Caja para campos interfaz
        $arrayDataDiploma["cNombreDiploma"]          = $position[0];// caja para pocisionar el nombre del diploma
        $arrayDataDiploma["cEncabezadoDiploma"]      = $position[1];// caja para pocisionar el encabezado diploma
        $arrayDataDiploma["cIntensidadHorasDiploma"] = $position[2];// caja para pocisionar la intensidad de horas del diploma
        $arrayDataDiploma["cFechaDiploma"]           = $position[3];// caja para pocisionar la fecha del diploma
        $arrayDataDiploma["cOtorgaDiploma"]          = $position[4];// caja para pocisionar campo otorga diploma
        $arrayDataDiploma["cImagenDiploma"]          = $position[5];// caja para pocisionar campo imagen diploma
    }
    public function ctrFirmasDiploma(){
        $idFirma = $nombreDiploma = $cargoFirmaDiploma = $dependenciaFirmaDiploma = $enlaceFirmasDiploma = $pesoFirmaDiploma = $atributosFirma="";
        $dataFirma = array();
        $dataSqlFimas = DiplomaModelo::mdlFirmasDiplomaActivas($this->idDiploma);//$this->idDiploma

        if (!empty($dataSqlFimas)){
            $indice = 0;//este indice se crea para enviar todos las firma
            foreach ($dataSqlFimas as $value){
                if(empty($value["nombrefirmadiploma"])){ $value["nombrefirmadiploma"]="dummy"; };
                if(empty($value["cargofirmadiploma"])){ $value["cargofirmadiploma"]="dummy"; };
                if(empty($value["dependenciafirmadiploma"])){ $value["dependenciafirmadiploma"]="dummy"; };
                if(empty($value["enlacefirmasdiploma"])){ $value["enlacefirmasdiploma"]="dummy"; };
                if(empty($value["pesofirmadiploma"])){ $value["pesofirmadiploma"]="dummy"; };

                $dataFirma[$indice]["numeroFirma"]             = $indice;
                $dataFirma[$indice]["nombreDiploma"]           = utf8_decode($value["nombrefirmadiploma"]);
                $dataFirma[$indice]["cargoFirmaDiploma"]       = utf8_decode($value["cargofirmadiploma"]);
                $dataFirma[$indice]["dependenciaFirmaDiploma"] = utf8_decode($value["dependenciafirmadiploma"]);
                $dataFirma[$indice]["enlaceFirmasDiploma"]     = $value["enlacefirmasdiploma"];
                $dataFirma[$indice]["pesoFirmaDiploma"]        = $value["pesofirmadiploma"];
                $atributosFirma = $value["atributosfirmadiploma"];

                $position = explode(",", $atributosFirma);
                //asignando cajas para manejo en ubicaciones
                if (empty($position[0])){ $position[0]=0; };
                if (empty($position[1])){ $position[1]=0; };
                if (empty($position[2])){ $position[2]=0; };
                if (empty($position[3])){ $position[3]=0; };
                if (empty($position[3])){ $position[3]=0; };

                $dataFirma[$indice]["cImgagenFirma"]        = $position[0]; // caja imagen firma
                $dataFirma[$indice]["cLineaFirma"]          = $position[1];// caja linea de dicision de firma
                $dataFirma[$indice]["cTxtNombreFirma"]      = $position[2];// caja text Nombre firma
                $dataFirma[$indice]["cTxtCargoFirma"]       = $position[3];// caja texto cargo firma
                $dataFirma[$indice]["cTxtDependencia"]      = $position[3];// caja texto Dependencia ejemplo Universidad el bosque
                $indice++;

            }
        }

        return $dataFirma;
    }

}