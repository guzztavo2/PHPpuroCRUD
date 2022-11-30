<?php
if (!defined('APP_ROOT')) {
    include_once('../config.php');
    redirectSecurity();
}

include_once('supermodel.php');
class informacao extends supermodel
{
    private $informacao;
    private $dataCriacao;
    private $dataAtualizacao;
    public function __construct($informacao = null)
    {
        $this->setTableName(TB_INFORMACOES);
        if ($informacao !== null) {
            if ($this->informacao !== null)
                $this->dataAtualizacao = date('Y-m-d H:i:s');
            else
                $this->dataCriacao = date('Y-m-d H:i:s');

            $this->definindoID();
            $this->informacao = $informacao;
        }
    }
    public function getInformacao()
    {
        return $this->informacao;
    }
    public function getDataCriacao()
    {
        return $this->dataCriacao;
    }
    public function getDataAtualizacao()
    {
        return $this->dataAtualizacao;
    }
    private function setInformacao($informacao)
    {
        $this->informacao = $informacao;
    }
    private function setDataCriacao($dataCriacao)
    {
        $this->dataCriacao = $dataCriacao;
    }
    private function setDataAtualizacao($dataAtualizacao)
    {
        $this->dataAtualizacao = $dataAtualizacao;
    }
    public static function getClassVar(): array
    {
        return array_keys(get_class_vars('informacao'));
    }
    private function definindoID()
    {
        if (isset($dataAtualizacao)) {
            try {
                $pdo = database::conectar()->prepare('SELECT * FROM `' . $this->getTableName() . '` WHERE `informacao` = ? LIMIT 1');
                if (!$pdo->execute(array($this->informacao)))
                    throw new Exception('Não foi possivel estabelecer a conexão com o banco de dados, aguarde ou tente novamente mais tarde.');

                $pdo->setFetchMode(PDO::FETCH_ASSOC);
                $this->id = $pdo->fetch()['id'];
            } catch (Exception $e) {
                die($e->getMessage());
            }
        } else {
            try {
                $pdo = database::conectar()->prepare('SELECT * FROM `' . $this->getTableName() . '` ORDER BY `id` DESC LIMIT 1');
                if (!$pdo->execute())
                    throw new Exception('Não foi possivel estabelecer a conexão com o banco de dados, aguarde ou tente novamente mais tarde.');
                $pdo->setFetchMode(PDO::FETCH_ASSOC);
                $this->id = 1 + (int)$pdo->fetch()['id'];
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
    }
    public function salvar()
    {
        if (isset($dataAtualizacao)) {
            try {
                $pdo = database::conectar()->prepare('UPDATE `' . $this->getTableName() . '` SET `informacao`= ?, `dataAtualizacao` = ? WHERE `id` = ?');
                if (!$pdo->execute(array($this->informacao, $this->dataAtualizacao, $this->id)))
                    throw new Exception('Não foi possivel estabelecer a conexão com o banco de dados, aguarde ou tente novamente mais tarde.');
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
    }
    private static function selectAllPDO(array $where = null)
    {
        $informacao = new informacao();

        if ($where !== null) {

            try {
                $pdo = database::conectar()->prepare('SELECT * FROM `' . $informacao->getTableName() . '` ' . $where[0]);
                //application::visualizarArray($pdo);
                if (isset($where[1]))
                    $pdo->execute($where[1]);
                else
                    $pdo->execute();
            } catch (Exception $e) {
                die($e->getMessage());
            }
        } else {
            try {
                $pdo = database::conectar()->prepare('SELECT * FROM `' . $informacao->getTableName() . '`');
                $pdo->execute();
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }


        $pdo->setFetchMode(PDO::FETCH_ASSOC);
        return $pdo;
    }
    private static function orderByQuery($orderBy): string | null
    {
        if ($orderBy !== null) {
            $ascendencia = '';
            if (isset($_GET['asc']))
                $ascendencia = 'ASC';
            else
                $ascendencia = 'DESC';

            return $orderBy = "ORDER BY $orderBy $ascendencia ";
        }
        return null;
    }
    private static function buscarQuery($buscar): string | null
    {
        if ($buscar !== null) {
            $queryBuscar = "WHERE(";
            foreach (informacao::getClassVar() as $key => $value) {
                if ($key === 0)
                    $queryBuscar .= " `$value` LIKE '%$buscar%' ";
                else
                    $queryBuscar .= "OR `$value` LIKE '%$buscar%' ";
            }
            $queryBuscar .= ") ";
            return $queryBuscar;
        }
        return null;
    }
    public static function listarLimitado($initialLimit, $finalLimit, $orderBy = null, $buscar = null): array
    {
        $orderbyQuery =  self::orderByQuery($orderBy);
        $queryBuscar = self::buscarQuery($buscar);
        if ($orderbyQuery === NULL)
            $pdo = self::selectAllPDO(array($queryBuscar . "LIMIT $initialLimit,$finalLimit"));
        else if ($queryBuscar === NULL)
            $pdo = self::selectAllPDO(array($orderbyQuery . "LIMIT $initialLimit,$finalLimit"));
        else
            $pdo = self::selectAllPDO(array($queryBuscar . $orderbyQuery . "LIMIT $initialLimit,$finalLimit"));

        return $pdo->fetchAll();
    }
    public static function listarTodos(array $where = null): array
    {
        $pdo = self::selectAllPDO($where);

        // construir array de INFORMACOES.

        return $pdo->fetchAll();
    }
    public static function quantidadeInformacoes(array $where = null): int
    {
        $queryBuscar = self::buscarQuery($where['buscar']);

        $pdo = self::selectAllPDO(array($queryBuscar));

        return $pdo->rowCount();
    }
    public static function constructIndexedArray(array $indexedArray = null, array &$resultado = null)
    {
        $isNull = false;

        if ($resultado === null) {
            $resultado = [];
            $isNull = true;
        }
        foreach ($indexedArray as $key => $value) {
            $informacao = new informacao();
            $informacao->setID($value['id']);
            $informacao->setInformacao($value['informacao']);
            $informacao->setDataCriacao($value['dataCriacao']);
            $informacao->setDataAtualizacao($value['dataAtualizacao']);
            $resultado[] = $informacao;
        }

        return ($isNull === true) ? $resultado : null;
    }
}
