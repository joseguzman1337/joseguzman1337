<?php
namespace Sala\utiles\GetIp;

defined('_EXEC') or die;

/**
 * La clase (GetRealIp) captura y retorna la ip desde donde se esta accediendo
 * al sistema
 * 
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package Sala\lib\AdministracionPeriodos\api\interfaces
 */
abstract class GetRealIp {
    
    /**
     * El metodo getRealIP es el encargado de retornar la ip desde la cual está
     * accediendo el cliente
     * 
     * @access public static
     * @return string ip de acceso remoto
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since marzo 12, 2019
    */
    public static function getRealIP() {
        if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            return $_SERVER["HTTP_CLIENT_IP"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED"])) {
            return $_SERVER["HTTP_X_FORWARDED"];
        } elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_FORWARDED"])) {
            return $_SERVER["HTTP_FORWARDED"];
        } else {
            return $_SERVER["REMOTE_ADDR"];
        }
    }
}
