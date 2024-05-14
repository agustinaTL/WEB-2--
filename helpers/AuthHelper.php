<?php

class AuthHelper
{

    public static function verificoLogueo()
    {
        session_start();
        if (!isset($_SESSION["ID_USER"]))
            die;
    }
}
