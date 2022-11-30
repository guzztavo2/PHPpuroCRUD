<?php
if (!defined('APP_ROOT')) {
    include_once('../config.php');
    redirectSecurity();
}

class fileurls
{
    public static $URL;
    public static $GET;
    public static function redirect($url)
    {
        header('location: ' . $url);
        die();
    }
    public function verificarGET()
    {

        if (isset($_GET)) {
            if (count($_GET) <= count(application::LIST_GETS)) {
                $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
                self::verificarArrayGET($_GET);
            } else
                redirectSecurity();
        }
    }
    private static function verificarArrayGET(array $listGET)
    {
        $parameters = application::LIST_GETS;
        $testList = [];

        foreach ($parameters as $value) {
            //$listGET[$value];
            if (@$listGET[$value] !== null) {
                $testList[] = $listGET[$value];
            }
        }
        if (count($testList) !== count($listGET))
            redirectSecurity();
    }
    protected function verificarURL($url)
    {

        $refl = new ReflectionClass('informacaoController');

        foreach ($refl->getConstants() as $key => $value) {
            if ($url === strtolower($key)) {
                return;
            }
        }
        application::redirect(application::HOME_PATH);
    }
}
