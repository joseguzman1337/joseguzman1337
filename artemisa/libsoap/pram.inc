<?php
    /**
    * @modifed Ivan Dario Quintero Rios <quinteroivan@unbosque.edu.co>
    * @since Marzo 19 del 2019
    * Limpieza de codigo y definicion de url por http_root, eliminacion de variable redeclarada
    */
    session_start();
    require_once(realpath(dirname(__FILE__) . "/../sala/includes/adaptador.php"));

    $EntityCode = '10017';
    $SrvCode = '10001';

    if(isset($_REQUEST['PaymentSystem'])){
        if(!isset($_SESSION['tipodepagosesion'])){
            $GLOBALS['tipodepagosesion']= "";
            $_SESSION['tipodepagosesion'] = $_REQUEST['PaymentSystem'];
        }//if
    }else{
        if(!isset($_SESSION['tipodepagosesion'])){
            $GLOBALS['tipodepagosesion']="";
            $_SESSION['tipodepagosesion'] = 0;
        }//if
    }//else
    
    $PaymentSystem = $_SESSION['tipodepagosesion'];   
    $URLResponse = HTTP_ROOT.'/libsoap/class.getRequest.php';
