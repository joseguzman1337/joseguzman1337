<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package config
 */

/**
 * @modified Andres Aroza <arizaandres@unbosque.edu.do>
 * Se agrega el uso de namespace para evitar conflictos con el archivo de configuracion 
 * generla de salaV1.0
 * @since Septiembre 10, 2018
 */
namespace PIR\config;
class Configuration {

    /**/
    //Produccion
    /**
     * @modified Andres Ariza <arizaandres@unbosque.edu.do>
     * Se agrega el estado active para poder encender o apagar el sistema de consulta
     * a PIR
     * @since Octubre 23, 2018
     */
    public static $active = false;// true activo, false inactivo
    public static $baseCurl = "https://www2.icfesinteractivo.gov.co/";
    public static $userCurl = "EK1729";
    public static $passwdCurl = "Bz2Rx";
    public static $pathAutentication = "interoperabilidad-web/rest/autenticacion/correo";
    public static $pathConsult = "interoperabilidad-web/rest/prisma/resultados/instituciones/";
    public static $pathSubjects = "interoperabilidad-web/rest/dominios/PRUEBA";
    /*/
    //Test
    public static $baseCurl = "http://www2.icfesinteractivo.gov.co/";
    public static $userCurl = "1723admin01";
    public static $passwdCurl = "Icfes.2017";
    public static $pathAutentication = "interoperabilidadtest-web/rest/autenticacion/correo";
    public static $pathConsult = "interoperabilidadtest-web/rest/prisma/resultados/instituciones/";
    public static $pathSubjects = "interoperabilidadtest-web/rest/dominios/PRUEBA";
    /**/

}