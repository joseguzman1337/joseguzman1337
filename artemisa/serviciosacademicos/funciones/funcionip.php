<?php

/**
 * @Modifed Ivan quintero <quinteroivan@unbosque.edu.co>
 * @Since  Mayo 14 del 2019
 * Adicion de validacion de existencias de variables en tomarip
 */
function getRealIP() {
    if ($_SERVER['HTTP_X_FORWARDED_FOR'] != '') {
        $client_ip = (!empty($_SERVER['REMOTE_ADDR']) ) ?
                $_SERVER['REMOTE_ADDR'] :
                ( (!empty($_ENV['REMOTE_ADDR']) ) ?
                $_ENV['REMOTE_ADDR'] :
                "unknown" );

        // los proxys van añadiendo al final de esta cabecera
        // las direcciones ip que van "ocultando". Para localizar la ip real
        // del usuario se comienza a mirar por el principio hasta encontrar
        // una dirección ip que no sea del rango privado. En caso de no
        // encontrarse ninguna se toma como valor el REMOTE_ADDR

        $entries = split('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);

        reset($entries);
        while (list(, $entry) = each($entries)) {
            $entry = trim($entry);
            if (preg_match("/^([0-9]+.[0-9]+.[0-9]+.[0-9]+)/", $entry, $ip_list)) {
                // http://www.faqs.org/rfcs/rfc1918.html
                $private_ip = array(
                    '/^0./',
                    '/^127.0.0.1/',
                    '/^192.168..*/',
                    '/^172.((1[6-9])|(2[0-9])|(3[0-1]))..*/',
                    '/^10..*/');

                $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);

                if ($client_ip != $found_ip) {
                    $client_ip = $found_ip;
                    break;
                }
            }
        }
    } else {
        $client_ip = (!empty($_SERVER['REMOTE_ADDR']) ) ?
                $_SERVER['REMOTE_ADDR'] :
                ( (!empty($_ENV['REMOTE_ADDR']) ) ?
                $_ENV['REMOTE_ADDR'] :
                "unknown" );
    }
    return $client_ip;
}

function GetIP() {
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("HTTP_X_FORWARDED_FOR ") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR "), "unknown"))
        $ip = getenv("HTTP_X_FORWARDED_FOR ");
    else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
        $ip = getenv("REMOTE_ADDR");
    else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
        $ip = $_SERVER['REMOTE_ADDR'];
    else
        $ip = "unknown";

    return($ip);
}

// Esta es la que creo se encuentra mejor
function tomarip() {
    $ip = "";
    if (isset($_SERVER["HTTP_CLIENT_IP"]) && !empty($_SERVER["HTTP_CLIENT_IP"])) {
        if (preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        }
    } else {
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]) && !empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            if (preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $_SERVER["HTTP_X_FORWARDED_FOR"])) {
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            }
        } else {
            if (isset($_SERVER["REMOTE_HOST"]) && !empty($_SERVER["REMOTE_HOST"])) {
                if (preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $_SERVER["REMOTE_HOST"])) {
                    $ip = $_SERVER["REMOTE_HOST"];
                }
            } else {
                $ip = $_SERVER["REMOTE_ADDR"];
            }
        }
    }
    return $ip;
}

//tomarip
