<?php
// $dataPage = variavel da página;
if (!defined('APP_ROOT')) {
    include_once('../config.php');
    redirectSecurity();
}
//setcookie('SELECTED_ITENS', '', -1);

$listSelectedItens = [];
if (isset($_COOKIE['SELECTED_ITENS'])) {
    $selectedItens = json_decode(filter_input(INPUT_COOKIE, 'SELECTED_ITENS', FILTER_DEFAULT));
    if ($selectedItens !== null) {
        $listSelectedItens = (array)$selectedItens;
    }
}


// application::visualizarArray($listSelectedItens);
$paginaAtual = $this->paginacao($dataPage['Quantidade'], $quantidadeTotalPaginas);
// application::visualizarArray($_GET);
// die();

?>

<div class="container w100 boxShadow flexColumn">
    <div class="menu w100 flexRow">
        <h1 class="w50">Gerenciamento de <b>Informações (CRUD)</b></h1>
        <div class="buttons w50 flexRow">
            <a class="btn add" href="<?php echo informacaoController::URLinformacaoController . 'add'; ?>">
                <i class="fa-solid fa-plus"></i>
                Adicionar Informacoes
            </a>
            <a class="btn remover" href="">
                <i class="fa-solid fa-minus"></i>
                Remover Informacoes
            </a>
        </div>
  
            <small class="w100" style="text-align:center;"><small id="desmarcarTodos"></small> itens selecionados (incluindo outras páginas). Clique aqui caso queira desmarcar todos.</small>


        <div class="buscarInfo flexRow w100">
            <form class="flexRow" method="get">
                <i class="fa-solid fa-magnifying-glass "></i>
                <?php
                if (isset($dataPage['Buscar']))
                    echo "<input type='text' name='buscar' class='w100' value = '" . $dataPage['Buscar'] . "' id='buscar' placeholder='buscar informações '>";
                else
                    echo "<input type='text' name='buscar' class='w100' id='buscar' placeholder='buscar informações '>";

                ?>
            </form>

        </div>


    </div>
    <div class="informacoesWrapper flexColumn">

        <div class="menuInfo flexRow">
            <h3><label class="containerCheck"><small>Selecionar todos</small>
                    <input id="selecionarTodos" type="checkbox">
                    <span class="checkmark"></span>
                </label>
            </h3>
            <a href="<?php echo informacaoView::getURL('id'); ?>">
                <h2 id="id_wrapper">id</h2>
            </a>
            <a href="<?php echo informacaoView::getURL('informacao'); ?>">
                <h2 id="informacao_wrapper">Informação</h2>
            </a>
            <a href="<?php echo informacaoView::getURL('dataCriacao'); ?>">
                <h2 id="dataCriacao_wrapper">Data Criação</h2>
            </a>
            <a href="<?php echo informacaoView::getURL('dataAtualizacao'); ?>">
                <h2 id="dataAtualizacao_wrapper">Data Atualização</h2>
            </a>
            <a class="editDeleteWrapper">
                *
            </a>

        </div>
        <?php
        if (!isset($dataPage['Informacoes'])) {


            echo "<div class='informacoes dark flexRow'>
                    <h4> Sem informações com esse parâmetro de busca.
                    <label class='containerCheck'></label></h4></div>";

            echo "<div class='informacoes flexRow'>
                    <h4> Sem informações com esse parâmetro de busca.
                    <label class='containerCheck'></label></h4></div>";
        } else {
            $count = 0;
            foreach ($dataPage['Informacoes'] as $key => $value) {
                //ob_clean();
                //$value[0]->getID();
                if ($count % 2 === 0)
                    echo "<div draggable='true' class='informacoes flexRow'>";
                else
                    echo "<div draggable='true' class='informacoes dark flexRow'>";

                $selectedHTML =  " <h4> <label class='containerCheck'>
                    <input  id='checkInfo' type='checkbox'>
                    <span class='checkmark'></span>
                    </h4>";


                if ($listSelectedItens !== 0 && count($listSelectedItens) > 0) {
                    if (array_search(informacaoView::getVarData($value, 'id'), $listSelectedItens) !== false) {

                        $selectedHTML = " <h4> <label class='containerCheck'>
                            <input checked id='checkInfo' type='checkbox'>
                            <span class='checkmark'></span>
                            </h4>";
                    }
                }

                echo  $selectedHTML;
                echo "<h4>" . informacaoView::getVarData($value, 'id') . "</h4>
                    <h4>" . informacaoView::getVarData($value, 'informacao') . "</h4>
                    <h4>" . informacaoView::getVarData($value, 'dataCriacao') . "</h4>
                    <h4>" . informacaoView::getVarData($value, 'dataAtualizacao') . "</h4>
                   <h4 class='flexRow'>
                    <a class='add' id='editInfo' href='" .  informacaoController::URLinformacaoController . 'edit/?id=' . informacaoView::getVarData($value, 'id') . "'>
                    <i id='' class='fa-solid fa-pen'>
                    </i></a>
                    <a class='remover' id='deleteInfo' href='" . informacaoController::URLinformacaoController . 'delete/?id=' . informacaoView::getVarData($value, 'id') . "'>
                    <i class='fa-solid fa-trash '>
                    </i></a>
                     </h4>
                    </div>";
                $count++;
            }
        } ?>
    </div>
    <div class="paginacao flexRow">
        <?php
        if ($paginaAtual !== null) {



            if ($paginaAtual >= 5) {
                $paginaInicio = $paginaAtual - 5;
                $paginaFinal =  $paginaAtual  + 5;
            } else {
                $paginaInicio = 1;
                $paginaFinal =  10;
            }


            if ($paginaFinal >= $quantidadeTotalPaginas) {
                $paginaInicio =  $quantidadeTotalPaginas - 10;
                $paginaFinal = $quantidadeTotalPaginas;
            }
            if ($paginaInicio <= 0)
                $paginaInicio = 1;

            $getPage = intval($paginaAtual);

            for ($n = $paginaInicio; $n <= $paginaFinal + 1; $n++) {
                if ((int)$n === $getPage)
                    echo "<a id='pagina' class='marcado' href='" . informacaoView::generateGETurl("pagina", $n) . "'><h1>$n</h1></a>";

                else
                    echo "<a id='pagina' onclick='return false;' href='" . informacaoView::generateGETurl("pagina", $n) . "'><h1>$n</h1></a>";
            }
        } else {
            echo "NÃO HÁ INFORMAÇÕES";
        }
        ?>

    </div>
</div>