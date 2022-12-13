<?php 
require_once('config.php');
define('APP_ROOT', '');
reescreverHTACCESS();
database::verificarTabelas();


$app = new application();

