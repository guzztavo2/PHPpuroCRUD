<?php

if (!defined('APP_ROOT')) {
    include_once('../config.php');
    redirectSecurity();
}

class informacaoController
{
    public const URLinformacaoController = application::HOME_PATH.'informacao/';
    public const VIEW = 1;
    public const ADD = 2;
    public const DELETE = 3;
    public const EDIT = 4;
    public function __construct()
    {

        require_once('./view/informacaoView.php');

        $infoView = new informacaoView();
        $infoView->setView();
    }
    public static function inputGETPageAtual(): int
    {
        $item = (isset($_GET['pagina'])) ? filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_NUMBER_INT) : 1;
        $item = intval($item);
        if (gettype($item) !== 'integer' || $item === 0)
            redirectSecurity();
    
        return $item;
    }
    public static function listarTodos(array $where = null): array
    {
        $listInformacao = [];


        informacao::constructIndexedArray(informacao::listarTodos($where), $listInformacao);
        return $listInformacao;
    }
    public static function filtrosInformacao(): array
    {
        return [
            'limitStart' => informacaoController::inputGETPageAtual() * informacaoView::ELEMENTOS_POR_PAGINA - informacaoView::ELEMENTOS_POR_PAGINA,
            'limitEnd' => informacaoView::ELEMENTOS_POR_PAGINA,
            'orderBy' => (isset($_GET['orderBy'])) ? (string)strtolower(filter_input(INPUT_GET, 'orderBy', FILTER_DEFAULT)) : null,
            'buscar' => (isset($_GET['buscar'])) ? (string)strtolower(filter_input(INPUT_GET, 'buscar', FILTER_DEFAULT)) : null
        ];
    }
    public static function listarQuantidadeInformacoes(array $where = null): int
    {
        $quantidade = informacao::quantidadeInformacoes(array(
            'orderBy' => self::filtrosInformacao()['orderBy'],
            'buscar' => self::filtrosInformacao()['buscar']
        ));


        return $quantidade;


        //$Where = 
        //self::listarTodos(self::filtrosInformacao()[]);
    }

    public static function listarLimitado(): array | null
    {
        // $limitStart = informacaoController::inputGETPageAtual() * informacaoView::ELEMENTOS_POR_PAGINA - informacaoView::ELEMENTOS_POR_PAGINA;
        // $limitEnd = informacaoView::ELEMENTOS_POR_PAGINA;
        // $orderBy = (isset($_GET['orderBy'])) ? (string)strtolower(filter_input(INPUT_GET, 'orderBy', FILTER_DEFAULT)) : null;
        // $buscar = (isset($_GET['buscar'])) ? (string)strtolower(filter_input(INPUT_GET, 'buscar', FILTER_DEFAULT)) : null;
        $filtrosInfo = self::filtrosInformacao();
        $listInfo = informacao::listarLimitado(
            $filtrosInfo['limitStart'],
            $filtrosInfo['limitEnd'],
            $filtrosInfo['orderBy'],
            $filtrosInfo['buscar']

        );
        if (count($listInfo) > 0) {
            $listInfo = informacao::constructIndexedArray($listInfo);
            return $listInfo;
        } else
            return null;
    }
}
