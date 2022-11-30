<?php
if (!defined('APP_ROOT')) {
    include_once('../config.php');
    redirectSecurity();
}

class database
{

    private static $pdo;


    public static function conectar()
    {
        try {
            if (!isset($pdo)){
                $pdo = new PDO('mysql:host=' . HOST . ';dbname=' . DATABASE, USERNAME, PASSWORD);
                $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
            }
        } catch (Exception $e) {
            $e->getMessage();
        }

        return $pdo;
    }
}
