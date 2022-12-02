<?php
if (!defined('APP_ROOT')) {
    include_once('../config.php');
    redirectSecurity();
}
extract($dataPage);

const POR_PAGINA = self::ELEMENTOS_POR_PAGINA;

if (!isset($quantidadeinput)){
    $quantidadeinput = 1;
}


$paginacao = (int)ceil($quantidadeinput / POR_PAGINA);
$pagina = 1;


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
        <div class="inputQuantidade w100">
            <span style="display: block;"><small>Digite em números a quantidade de informação que você gostaria de salvar:</small></span>
            <input id="inputQuantidade" pattern="^[0-9]*$" type="text" name="" placeholder="Digite a quantidade de informações que você irá adicionar" id="">

        </div>
        <div class="listInput"></div>
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
</div>