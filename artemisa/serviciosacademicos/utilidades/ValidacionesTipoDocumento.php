<?php
include(realpath(dirname(__FILE__)).'/../../utilidades/funcionesTexto.php');

class validacionesDocumento
{
    public function ValidacionDatos($db,$tipodoc,$genero,$numerodoc)
    {
        $tamano = strlen($numerodoc);
        $Error = "";

        switch($tipodoc)
        {
            case '01':
            {
                if($genero == '1')
                {
                    if($tamano > '2' && $tamano < '9')//valida si el tamaño del numero de identificaion esta entre 3 y 8 digitos
                    {
                        if($numerodoc < '20000000' || $numerodoc > '70000000' && $numerodoc < '100000000')
                        {
                            $datos['TipoDocumento'] = 'CC';
                        }else
                        {
                            $datos['TipoDocumento'] = 'CC';
                            $datos['Error']= "valor no encontrado entre 20.000.000 y 80.000.0000 genero hombre CC";
                        }
                    }else if($tamano == '10')//valida si el tamaño del numero de identificaion es 10
                    {
                        if($numerodoc > '1000000000')
                        {
                            $datos['TipoDocumento'] = 'CC';
                        }else
                        {
                            $datos['TipoDocumento'] = 'CC';
                            $datos['Error']= "Error de valor menor a 1.000.000.000";
                        }
                    }else
                    {
                        $datos['TipoDocumento'] = 'CC';
                        $datos['Error']= " numero de digitos diferente a 10 - 8 - 7 - 6 - 5 - 4 - 3 en genero hombre";
                    }
                }elseif($genero == '2') 
                {
                    if($tamano== '8')
                    {
                        if($numerodoc > '20000000' && $numerodoc < '80000000')
                        {
                            $datos['TipoDocumento'] = 'CC';
                        }else
                        {
                            $datos['TipoDocumento'] = 'CC';
                            $datos['Error'] = "valor no encontrado entre 20.000.000 y 80.000.0000 genero mujer CC";
                        }//else
                    }//tamano 8
                    else if ($tamano == '10')
                    {
                        if($numerodoc > '1000000000')
                        {
                            $datos['TipoDocumento'] = 'CC';
                        }else
                        {
                            $datos['TipoDocumento'] = 'CC';
                            $datos['Error'] = "valor menor a 1000000000 en genero mujer CC";
                        }
                    }else
                    {
                        $datos['TipoDocumento'] = 'CC';
                        $datos['Error'] = "tamaño numero de digitos diferente a 8 y 10 genero mujer CC";
                    }
                }//else genero
            }break;
            case '02':
            {
                if($tamano == '11')
                {
                    $parte1 = substr($numerodoc, 0, 2);
                    $parte2 = substr($numerodoc, 2, 2);
                    $parte3 = substr($numerodoc, 4, 2);
                    $parte4 = substr($numerodoc, 6, 3);
                    $parte5 = substr($numerodoc, 9, 1);
                    if($parte1 >= '00' && $parte1 <= '99')
                    {
                        if($parte2 >= '01' && $parte2 <= '12')
                        {
                            if($parte3 >= '01' && $parte3 <= '31')
                            { 
                                if(is_numeric($parte4))
                                {
                                    $datos['TipoDocumento'] = 'TI';
                                }
                                else
                                {
                                    $datos['TipoDocumento'] = 'TI';
                                    $datos['Error'] = "Error de numero de identificacion en TI.";
                                }
                            }else
                            {
                                $datos['TipoDocumento'] = 'TI';
                                $datos['Error'] = "Error de numero de identificacion en TI.";
                            }//else
                        }else
                        {
                            $datos['TipoDocumento'] = 'TI';
                            $datos['Error'] = "Error de numero de identificacion en TI.";
                        }
                    }else
                    {
                        $datos['TipoDocumento'] = 'TI';
                        $datos['Error'] = "Error de numero de identificacion en TI.";
                    }
                }elseif($tamano == 10)
                {
                    if($identificacion > '1000000000')
                    {
                        $datos['TipoDocumento'] = 'TI';
                    }else
                    {
                        $datos['TipoDocumento'] = 'TI';
                        $datos['Error'] = "Error de valor de identificaion mayor a 1000000000 en TI.";
                    }
                }else
                {
                    $datos['TipoDocumento'] = 'TI';
                    $datos['Error'] = "Error de numero de digitos diferente a 10 y 11 en TI.";
                }
            }
            break;
            case '03':
            {
                if($tamano < '6')
                {
                    $datos['TipoDocumento'] = 'CE';
                    $datos['Error']= "numero de digitos menor a 7 en CE";
                }else
                {
                    $datos['TipoDocumento'] = 'CE';
                }
            }
            break;
            case '05':
            {
                $datos['TipoDocumento']= 'PS';
            }
            break;
            case '13':
            {
                $datos['TipoDocumento'] = 'DE';
            }
            break;
            case '14':
            {
                $datos['TipoDocumento'] = 'CA';
            }
            break;
            default:
            {
                $datos['TipoDocumento'] = $tipodoc;
                $datos['Error'] = 'No esta en la lista de tipos validos';   
            }
        }//switch
        if($datos['Error'])
        {
            //consulta de la faculatad a la cual pertence el estudiante en el periodo consultado
            $sqlCarrera = "SELECT DISTINCT c.nombrecarrera FROM estudiante e, carrera c, documento d, estudiantegeneral eg, estudiantedocumento ed, situacioncarreraestudiante s, genero gr WHERE e.codigocarrera = c.codigocarrera AND gr.codigogenero = eg.codigogenero AND eg.tipodocumento = d.tipodocumento AND e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante AND ed.idestudiantegeneral = eg.idestudiantegeneral AND e.idestudiantegeneral = eg.idestudiantegeneral AND e.idestudiantegeneral = ed.idestudiantegeneral AND ed.numerodocumento = '".$numerodoc."' AND c.codigomodalidadacademica in ('200', '300') ORDER BY e.codigoperiodo DESC limit 1";                
            $carreranombre = $db->GetRow($sqlCarrera);
            
            $carreranombre['nombrecarrera'] = sanear_string($carreranombre['nombrecarrera']);

            $datos['programa']=$carreranombre['nombrecarrera'];                
        }

        return $datos;
    }
    
}

?>