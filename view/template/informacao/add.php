<?php
if (!defined('APP_ROOT')) {
    include_once('../config.php');
    redirectSecurity();
}  ?>

<div class="container flexColumn boxShadow">
    <div class="w100 menulinks flexRow">
        <small class="home w25"><a href="http://#"><i class="fa-solid fa-house"></i>
                Home

            </a></small>
        <small class="delete w25"><a href="http://#"> <i class="fa-solid fa-minus"></i>
                Remover

            </a></small>
        <small class="add w25"><a href="http://#"><i class="fa-solid fa-plus"></i>
                Adicionar</a></small>

    </div>
    <h1 class="w100 box textShadow ">
        Adicionar <b>Informações</b>
    </h1>
    <div class="adicionarInformacaoWrapper w100 flexColumn">
        <div class="inputQuantidade w100">
            <span><small>Digite em números a quantidade de informação que você gostaria de salvar:</small></span>
            <input id="inputQuantidade" pattern="^[0-9]*$" type="text" name="" placeholder="Digite a quantidade de informações que você irá adicionar" id="">

        </div>
        <div class="listInput"></div>
    </div>
    <div class="paginacao">

    </div>
</div>