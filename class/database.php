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
            if (!isset(self::$pdo) || self::$pdo == null) {


                $pdo = new \PDO('mysql:host=' . HOST . ';dbname=' . DATABASE, USERNAME, PASSWORD);
                self::$pdo = $pdo;
                //$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);



            }
        } catch (PDOException $e) {
            echo 'O seguinte erro foi identificado: </br>' . $e->getMessage();
            exit;
        }
        //var_export(gettype($pdo));
        return self::$pdo;
    }
    public static function verificarTabelas()
    {
        $SQL = 'CREATE TABLE IF NOT EXISTS ' . TB_INFORMACOES . '(id int NOT NULL AUTO_INCREMENT, informacao text NOT NULL , dataCriacao datetime NOT NULL, dataAtualizacao datetime, PRIMARY KEY (id));';
        try {
            $pdo = database::conectar()->prepare($SQL);
            $pdo->execute();
        } catch (Exception $e) {
            echo 'O seguinte erro foi identificado: </br>' . $e->getMessage();
            exit;
        }
    }
}
