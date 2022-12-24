<?php
// CONFIGURAÇÕES GERAIS
if(!defined('HOME'))
    define('HOME', 'phpPuroCRUD');

    if(!defined('URL'))
    define('URL', 'http://192.168.100.7/');

spl_autoload_register(function ($className) {
    if (file_exists('class/' . $className . '.php'))
        require_once('class/' . $className . '.php');
    else if (file_exists('controller/' . $className . '.php'))
        require_once('controller/' . $className . '.php');
    if ($className === 'informacao')
        require_once('model/informacao.php');
});
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
session_regenerate_id();
date_default_timezone_set('America/Sao_Paulo');

if (!defined('HOST'))
    define('HOST', 'localhost');
if (!defined('USERNAME'))
    define('USERNAME', 'root');
if (!defined('PASSWORD'))
    define('PASSWORD', '');
if (!defined('DATABASE'))
    define('DATABASE', 'phpcrud');


//  TABELA DE INFORMACOES
if (!defined('TB_INFORMACOES'))
    define('TB_INFORMACOES', 'tb_informacoes');


// URL
if (!defined('HOME_URL'))
    define('HOME_URL', URL.HOME.'/');


// REDIRECIONAR POR SEGURANÇA
function redirectSecurity()
{
    ob_clean();
    header('location: ' . HOME_URL);
    die();
}


//REESCREVER O HTACCESS


function reescreverHTACCESS()
{
    $strHtaccess = "Options -Indexes
    RewriteEngine On
    RewriteCond %{SCRIPT_FILENAME} !-f
    RewriteCond %{SCRIPT_FILENAME} !-d
    RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
    SetEnvIf Referer ".HOME_URL." localreferer
    <FilesMatch \.(jpg|jpeg|png|gif|css)$>
    Order deny,allow
    Deny from all
    Allow from env=localreferer
    </FilesMatch>
    ErrorDocument 403 /phpPuroCRUD/index.php
    ";
    $file = fopen('.htaccess', 'w');
    fwrite($file, $strHtaccess);
    fclose($file);


}
