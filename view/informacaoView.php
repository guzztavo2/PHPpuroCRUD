<?php
if (!defined('APP_ROOT')) {
    include_once('../config.php');
    redirectSecurity();
}
define('URL_ATUAL', application::HOME_PATH . filter_input(INPUT_GET, 'url', FILTER_DEFAULT));

class informacaoView
{
    public const ELEMENTOS_POR_PAGINA = 10;
    private $typePage;

    public function __construct()
    {
        $this->setTypePage();
    }
    public function getTypePage(): string
    {
        return $this->typePage;
    }
    private function setTypePage()
    {
        $this->typePage =  application::$URL[1];
    }
    public static function getVarData($var, $key): string | null
    {
        // var_export($var);
        switch ($key) {
            case 'id':
                return $var->getID();
                break;

            case 'informacao':

                if (strlen($var->getInformacao()) >= 30) {
                    $informacao = substr($var->getInformacao(), 0, 27);
                    $informacao .= '...';

                    return $informacao;
                } else
                    return $var->getInformacao();

                break;

            case 'dataCriacao':
                return $var->getDataCriacao();

                break;
            case 'dataAtualizacao':
                return $var->getDataAtualizacao();

                break;
        }
        die();
        return '';
    }
    private function includeAllFiles()
    {
        $this->includeFiles('css');
        $this->includeFiles('js');
    }
    private function includeFiles($typeFiles)
    {
        $listFiles = [];

        $diretorio = 'view\\template\\informacao\\' . $typeFiles;
        if ($typeFiles === 'css') {
            $listFiles[] = application::HOME_PATH . str_replace('\\', '/', $diretorio) . '/main.css';
            $listFiles[] = application::HOME_PATH . str_replace('\\', '/', $diretorio) . '/all.min.css';
        } else if ($typeFiles === 'js'){
            $listFiles[] = application::HOME_PATH . str_replace('\\', '/', $diretorio) . '/main.js';
            // ob_clean();
            // application::visualizarArray($diretorio);
            // die();
        }

        $diretorio .= '\\' . $this->typePage . '\\';
        $files = new FilesystemIterator('.\\' . $diretorio);
        $diretorio = str_replace('\\', '/', $diretorio);
        foreach ($files as $file) {
            $file = explode('\\', $file);
            $file = $file[count($file) - 1];
            $listFiles[] = application::HOME_PATH . $diretorio . $file;
        }
        // var_export($listFiles);
        if ($typeFiles === 'css') {
            foreach ($listFiles as $file) {
                echo '<link rel="stylesheet" href="' . $file . '" type="text/css" media="all"/>';
            }
        } else if ($typeFiles === 'js') {
            foreach ($listFiles as $file) {
                echo '<script type="Module" src="' . $file . '" type="module"></script>';
            }
        }
    }
    public static function getURL($parametro): string
    {
        $urlAtual = '';
        if (isset($_GET['asc']))
            $urlAtual = URL_ATUAL . "?orderBy=$parametro&desc";
        else if (isset($_GET['desc']))
            $urlAtual = URL_ATUAL . "?orderBy=$parametro&asc";
        else
            $urlAtual = URL_ATUAL . "?orderBy=$parametro&asc";

        return $urlAtual;
    }
    public function setView()
    {
        // 
        // die();

        switch ($this->getTypePage()) {
            case 'view':
                $this->renderizar(self::viewPage());

                break;
            case 'add':
                $this->renderizar(self::addPage());

                break;
            case 'delete':
                $this->renderizar();

                break;
            case 'update':
                $this->renderizar();
                break;
            default:
                application::redirect(informacaoController::URLinformacaoController);
                break;
        }
    }

    private function renderizar(array $dataPage = null)
    {

        require_once('template/header.php');
        require_once('template/informacao/' . $this->getTypePage() . '.php');
        require_once('template/footer.php');
    }

    private static function viewPage(): array
    {
        $resultado = [
            'Informacoes' => informacaoController::listarLimitado(),
            'Quantidade' => informacaoController::listarQuantidadeInformacoes(), 'porPagina' => informacaoView::ELEMENTOS_POR_PAGINA,
            'URL_ATUAL' => URL_ATUAL,
            'Buscar' => informacaoController::filtrosInformacao()['buscar']

        ];
        // application::visualizarArray($resultado);
        foreach ($resultado as $key => $value) {
            if ($value === NULL)
                unset($resultado[$key]);
        }



        return $resultado;
    }

    public static function generateGETurl($chave, $valor): string
    {

        $listGET = $_GET;
        unset($listGET['url']);
        $listGET[$chave] = (string)$valor;
        $url = application::HOME_PATH . $_GET['url'] . '?' . http_build_query($listGET);

        return $url;
    }

    private function paginacao($quantidadeTotal, &$quantidadePaginas = null): int | null
    {

        if ($quantidadeTotal === 0)
            return null;


        $porPagina = self::ELEMENTOS_POR_PAGINA;
        $paginaAtual = informacaoController::inputGETPageAtual();



        // USAR ESTILO PAGINACAO GOOGLE
        $quantidade = $quantidadeTotal;
        $quantidadePaginas =  ceil($quantidade / $porPagina) - 1;

        if ($paginaAtual < 1)
            application::redirect(application::HOME_PATH . $_GET['url'] . '?pagina=1');

        return $paginaAtual;
    }
    private static function addPage(): array
    {
        $quantidadeinput = isset($_GET['quantidadeinput']) ? filter_input(INPUT_GET, 'quantidadeinput', FILTER_VALIDATE_INT) : 1;
        if ($quantidadeinput === false) {
            echo "Nessa requisição, é necessário passar apenas números. Provavelmente algum engano ou erro. <a href=" . informacaoController::URLinformacaoController . ">Clique aqui para voltar para a pagina inicial</a>.";
            die();
        }

        return ['quantidadeinput' => $quantidadeinput];
    }
    private function deletePage()
    {
    }

    public static function setCookie(String $chave, String | array $valor)
    {

        if (gettype($valor) === 'array') {
            foreach ($valor as $key => $value)
                $valor[$key] = (array) $value;

            $valor = json_encode($valor);
        }

        setcookie($chave, $valor, strtotime('+10 days'));
    }
    public static function verificarCookie($chave): bool
    {
        if ($_COOKIE[$chave] !== null && strlen($_COOKIE[$chave]) > 0)
            return true;
        else {
            setcookie($chave, null, -1);
            return false;
        }
    }
    public static function destruirCookie($chave)
    {
        setcookie($chave, null, -1);
    }
    public static function setCookie_array(array $array)
    {
    }
}
