<?php
if (!defined('APP_ROOT')) {
    include_once('../config.php');
    redirectSecurity();
}


extract($dataPage);

const POR_PAGINA = 6;

if (!isset($quantidadeinput)) {
    $quantidadeinput = 0;
}

$paginacao = (int)ceil($quantidadeinput / POR_PAGINA);
$pagina = isset($_GET['pagina']) ? filter_input(INPUT_GET, 'pagina', FILTER_VALIDATE_INT) : 1;
if ($pagina === false || $pagina === 0)
    application::redirect(informacaoController::URLinformacaoController . 'add');
$auxPagina = false;
if($quantidadeinput === 1){
    $auxPagina = true;
}
?>

<div class="container flexColumn boxShadow">
    <div class="w100 menulinks flexRow">
        <small class="home w50"><a href="http://#"><i class="fa-solid fa-house"></i>
                Home

            </a></small>
        <small class="delete w50"><a href="http://#"> <i class="fa-solid fa-minus"></i>
                Remover

            </a></small>
    </div>
    <h1 class="w100 title box textShadow ">
        Adicionar <b>Informações</b>
    </h1>
    <div class="adicionarInformacaoWrapper w100 flexColumn">
        <?php if ($auxPagina === true) { ?>
            <div class="inputQuantidade w100">
                <span style="display: block;"><small>Digite em números a quantidade de informação que você gostaria de salvar:</small></span>
                <input id="inputQuantidade" pattern="^[0-9]*$" type="text" name="" placeholder="Digite a quantidade de informações que você irá adicionar" id="">

            </div>
        <?php } else { ?>
                            <div class="buttonWrapp box w100 flexRow">
                                <div class="btn w50 Salvar"><h3>Salvar</h3></div>
                                <div class="btn w50 Cancelar"><h3>Cancelar</h3></div>
                            </div>
       
        <div class="listInput w100">
            <form class="w100 flexColumn" action="" method="post">
                <div class="box informacaoWrapper w100 flexColumn">
                    <label for=""><small>Digite a Informação, deixe o campo vazio caso não queira salvar:</small></label>
                    <input type="text" id="adicionarInformacao" class="box" name="" placeholder="Digite aqui a informação" id="">
                </div>
                <div class="box informacaoWrapper w100 flexColumn">
                    <label for=""><small>Digite a Informação, deixe o campo vazio caso não queira salvar:</small></label>
                    <input type="text" id="adicionarInformacao" class="box" name="" placeholder="Digite aqui a informação" id="">
                </div>
                <div class="box informacaoWrapper w100 flexColumn">
                    <label for=""><small>Digite a Informação, deixe o campo vazio caso não queira salvar:</small></label>
                    <input type="text" id="adicionarInformacao" class="box" name="" placeholder="Digite aqui a informação" id="">
                </div>
                <div class="box informacaoWrapper w100 flexColumn">
                    <label for=""><small>Digite a Informação, deixe o campo vazio caso não queira salvar:</small></label>
                    <input type="text" id="adicionarInformacao" class="box" name="" placeholder="Digite aqui a informação" id="">
                </div>
                <div class="box informacaoWrapper w100 flexColumn">
                    <label for=""><small>Digite a Informação, deixe o campo vazio caso não queira salvar:</small></label>
                    <input type="text" id="adicionarInformacao" class="box" name="" placeholder="Digite aqui a informação" id="">
                </div>
                <div class="box informacaoWrapper w100 flexColumn">
                    <label for=""><small>Digite a Informação, deixe o campo vazio caso não queira salvar:</small></label>
                    <input type="text" id="adicionarInformacao" class="box" name="" placeholder="Digite aqui a informação" id="">
                </div>
            </form>
        </div>
    </div>

    <div class="paginacao flexRow">
        <?php

        for ($count = 1; $count <= $paginacao; $count++) {
            if ($count === $pagina)
                echo "<a class='marcado' href='" . informacaoView::generateGETurl("pagina", $count) . "'><h1>$count</h1></a>";
            else
                echo "<a href='" . informacaoView::generateGETurl("pagina", $count) . "'><h1>$count</h1></a>";
        }
        ?>

    </div>
    <?php } ?>
</div>