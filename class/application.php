<?php
if (!defined('APP_ROOT')) {
    include_once('../config.php');
    redirectSecurity();
}
// require_once('./controller/' . $url[0] . 'Controller.php');
require_once('filesurls.php');
class application extends fileurls
{
    const HOME_PATH = HOME_URL;
    static private $listControllers = array('informacao');
    const LIST_GETS = array('url', 'pagina', 'orderBy', 'asc', 'desc', 'buscar', 'quantidadeinput', 'id');
    function __construct()
    {

        if ($_GET['url'] !== null && strlen($_GET['url']) > 0) {
            $url = explode('/', $_GET['url']);
            self::$URL = $url;
            if (@strlen($url[2]) > 0)
                application::redirect(application::HOME_PATH);

            $this->verificarGET();
            foreach (self::$listControllers as $key => $value) {
                if ($value === $url[0]) {
                    if ($url[1] === null || strlen($url[1] === 0))
                        application::redirect(application::HOME_PATH . $url[0] . '/view/');
                    else {
                        $this->verificarURL($url[1]);
                        new informacaoController();
                    }
                } else {
                    redirectSecurity();
                }
            }
        } else {
            self::redirect(application::HOME_PATH . 'informacao');
        }
    }

    public static function removeAndReplaceArrayElement(array &$array, $elementReplace)
    {

        $resultado = [];
        foreach ($array as $key => $value) {
            if (array_search($value, $elementReplace) === false)
                $resultado[] = $value;
        }

        $array = array_merge($resultado, $elementReplace);
     
    }
    public static function visualizarArray($array)
    {
        echo '<pre>';
        var_export($array);
        echo '</pre>';
    }
}
