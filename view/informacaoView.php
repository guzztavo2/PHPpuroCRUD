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
        exit;
    }
    private function includeAllFiles()
    {
        $this->includeFiles('css');
        $this->includeFiles('js');
    }
    private function verificarPOST($typePost)
    {
   
        if (isset($_POST) && count($_POST) > 0) {
  

            ob_clean();

            switch ($typePost) {
                case 'view':
                    $this->viewPost();
                    break;
                case 'add':
                    $this->addPost();
                    break;
            }

            exit;
        }
 

    }
    private function viewPost()
    {
        $listSelectedItens = filter_input_array(INPUT_POST, FILTER_VALIDATE_INT);


        $tipoItem = explode('/', key($listSelectedItens))[0];

        switch ($tipoItem) {
            case 'IDChecked':
                $this->postIDChecked($listSelectedItens);
                break;
            case 'IDUnchecked':
                $this->postIDUncheked($listSelectedItens);
                break;
            case 'DELETE_SELECTED_ITENS':
                setcookie('SELECTED_ITENS', null, -1);
                break;
            case 'QUANTIDADE_ITENS_SELECIONADOS':
                $listCookieSelected = filter_input(INPUT_COOKIE, 'SELECTED_ITENS', FILTER_DEFAULT);

                $listCookieSelected = (isset($listCookieSelected)) ? $listCookieSelected : null;
                $listCookieSelectedCount = 0;
                if ($listCookieSelected !== null)
                    $listCookieSelectedCount = (count(json_decode($listCookieSelected, JSON_OBJECT_AS_ARRAY)) > 0) ? count((array)json_decode($listCookieSelected)) : 0;
                echo $listCookieSelectedCount;
                exit;
                break;
            default:
                redirectSecurity();
        }
    }
    private function addPost()
    {
        $listSelectedItens = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $tipoItem = explode('/', key($listSelectedItens))[0];


        switch ($tipoItem) {
            case 'informacaoSession':
                $receivedList = $listSelectedItens;
                $resposta = [];
                foreach ($receivedList as $key => $value) {
                    $id = explode('/', $key)[1];
                    $page = explode('/', $key)[2];
                    $resposta[$page][] = [
                        'ID' => $id,
                        'valor' => $value
                    ];
                }
                //unset($_SESSION['INFORMACAO_LIST']);
                $sessionList = [];
                if (isset($_SESSION['INFORMACAO_LIST'])) {
                    $sessionList = $_SESSION['INFORMACAO_LIST'];
                }
                $sessionList = array_merge($sessionList, $resposta);
                $_SESSION['INFORMACAO_LIST'] = $sessionList;
                //var_export($sessionList);
                break;
            case 'CancelarSession':
                unset($_SESSION['INFORMACAO_LIST']);
                break;
            case 'SALVAR_SESSION':
                $listPost = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                $resultadoList = [];
                foreach ($listPost as $key => $value) {
                 $resultadoList[] = new informacao($value);
                }
                var_export($resultadoList);
                die;

                $sessionList = (isset($_SESSION['INFORMACAO_LIST'])) ? $_SESSION['INFORMACAO_LIST'] : null;
                $sessionList = ($sessionList !== null && count($sessionList) > 0) ? $sessionList : null;
                if($sessionList === null){
                    echo 'Não há itens para serem salvos!';
                    exit;
                }
                // foreach($sessionList as $key => $value){
                //     var_export($value);
                // } 
        }

        exit;
    }
    private function postIDChecked($listSelectedItens)
    {

        $listSelectedItens = array_values($listSelectedItens);

        //setcookie('SELECTED_ITENS', '', -1);

        //echo 'Linha 106:' . var_export($_COOKIE);


        if (isset($_COOKIE['SELECTED_ITENS'])) {
            $listCookieSelected = json_decode(filter_input(INPUT_COOKIE, 'SELECTED_ITENS', FILTER_DEFAULT));
            //$listSelectedItens = (array)$listSelectedItens;
            $listCookieSelected = array_values((array)$listCookieSelected);
            if (count($listCookieSelected) > 0) {
                application::removeAndReplaceArrayElement($listSelectedItens, $listCookieSelected);
                asort($listSelectedItens, SORT_ASC);
                setcookie('SELECTED_ITENS', json_encode($listSelectedItens), strtotime('+ 2 days'));
                return;
            }
        }
        setcookie('SELECTED_ITENS', json_encode($listSelectedItens), strtotime('+ 2 days'));
    }
    private function postIDUncheked($listUnselectedItens)
    {
        $ListUnselectedItem = array_values($listUnselectedItens);
        if (isset($_COOKIE['SELECTED_ITENS'])) {
            $listCookieSelected = json_decode(filter_input(INPUT_COOKIE, 'SELECTED_ITENS', FILTER_DEFAULT));
            $listCookieSelected = array_values((array)$listCookieSelected);

            foreach ($ListUnselectedItem as $unselectedItem) {
                if (array_search($unselectedItem, $listCookieSelected) !== false) {
                    $key = array_search($unselectedItem, $listCookieSelected);
                    unset($listCookieSelected[$key]);
                }
            }

            asort($listCookieSelected, SORT_ASC);

            setcookie('SELECTED_ITENS', json_encode($listCookieSelected), strtotime('+ 2 days'));
        }
        return;
    }
    private function includeFiles($typeFiles)
    {
        $listFiles = [];

        $diretorio = 'view\\template\\informacao\\' . $typeFiles;
        if ($typeFiles === 'css') {
            $listFiles[] = application::HOME_PATH . str_replace('\\', '/', $diretorio) . '/main.css';
            $listFiles[] = application::HOME_PATH . str_replace('\\', '/', $diretorio) . '/all.min.css';
        } else if ($typeFiles === 'js') {
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
                echo '<script type="Module" src="' . $file . '"></script>';
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
            $urlAtual = URL_ATUAL . "?orderBy=$parametro&desc";

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
        $this->verificarPOST($this->getTypePage());

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

    private function paginacao($quantidadeTotal, &$quantidadePaginas = null, $porPagina = null): int | null
    {

        if ($quantidadeTotal === 0)
            return null;

        if ($porPagina === null)
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
        $quantidadeinput = isset($_GET['quantidadeinput']) ? filter_input(INPUT_GET, 'quantidadeinput', FILTER_VALIDATE_INT) : null;

        if ($quantidadeinput === false) {
            echo "Nessa requisição, é necessário passar apenas números. Provavelmente algum engano ou erro. <a href=" . informacaoController::URLinformacaoController . ">Clique aqui para voltar para a pagina inicial</a>.";
            die();
        }

        $pagina = (int)isset($_GET['pagina']) ? filter_input(INPUT_GET, 'pagina', FILTER_VALIDATE_INT) : null;

        if ($pagina === false || $pagina === 0)
            application::redirect(informacaoController::URLinformacaoController . 'add');

        if ($pagina !== null && $quantidadeinput === null)
            application::redirect(informacaoController::URLinformacaoController . 'add');
        $quantidadeInputAdicionar = 0;
        if ($quantidadeinput !== null) {
            self::verificarInt(1, 50, $quantidadeinput);
            if ($pagina !== null) {
                $quantidadeInputAdicionar = ceil($quantidadeinput -  (($pagina - 1) * 6));
            } else {
                $quantidadeInputAdicionar = ceil($quantidadeinput -  ((1 - 1) * 6));
            }
        }
        $POR_PAGINA = 6;
        if ($quantidadeInputAdicionar > $POR_PAGINA) {
            $quantidadeInputAdicionar = $POR_PAGINA;
        }
        if (!isset($quantidadeinput)) {
            $quantidadeinput = 0;
        }
        $paginacao = ceil($quantidadeinput / $POR_PAGINA);
        return [
            'quantidadeinput' => $quantidadeinput,
            'pagina' => $pagina,
            'paginacao' => $paginacao,
            'quantidadeInputAdicionar' => $quantidadeInputAdicionar
        ];
    }
    private static function verificarInt($minvalue, $maxvalue, $value)
    {
        if ((int)$value < $minvalue || (int)$value > $maxvalue) {
            application::redirect(informacaoController::URLinformacaoController . 'add');
        }
    }
    private function deletePage()
    {
    }
}
