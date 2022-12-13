<?php
if (!defined('APP_ROOT')) {
    include_once('../config.php');
    redirectSecurity();
}


extract($dataPage);
$auxPagina = false;
//echo $paginacao;
if ($quantidadeinput === 0 || $quantidadeinput === null) {
    $auxPagina = true;
    unset($_SESSION['INFORMACAO_LIST']);
}

$InformacoesSalvas = isset($_SESSION['INFORMACAO_LIST']) ? $_SESSION['INFORMACAO_LIST'] : null;
$InformacoesSalvas = isset($InformacoesSalvas['pagina=' . @$_GET['pagina']]) ?  $InformacoesSalvas['pagina=' . $_GET['pagina']] : null;
if (!isset($_SESSION['INFORMACAO_LIST']) || count($_SESSION['INFORMACAO_LIST']) <= 0)
    $InformacoesSalvas = null;

?>

<div class="container flexColumn boxShadow">
    <div class="w100 menulinks flexRow">
        <small class="home w100"><a href="<?php echo informacaoController::URLinformacaoController ?>"><i class="fa-solid fa-house"></i>
                Home

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
            <div class="buttonWrapp w100 flexRow">
                <div class="btn w50 Salvar">
                    <h3 class="box" id="salvar">Salvar</h3>
                </div>
                <div class="btn w50 Cancelar">
                    <h3 class="box">Cancelar</h3>
                </div>
            </div>

            <div class="listInput w100">
                <form class="w100 flexColumn" action="" method="post">
                    <?php for ($n = 1; $n <= $quantidadeInputAdicionar; $n++) {
                        if ($InformacoesSalvas !== null) {

                            $valor = (string)$InformacoesSalvas[$n - 1]['valor'];
                    ?>
                            <div class="box informacaoWrapper w100 flexColumn">
                                <label for=""><small>Digite a Informação, deixe o campo vazio caso não queira salvar:</small></label>
                                <input type="text" id="adicionarInformacao" class="box" name="" placeholder="Digite aqui a informação" value="<?php echo (strlen($valor) > 0) ? $valor : null ?>" id="">
                            </div>

                        <?php
                        } else {




                        ?>
                            <div class="box informacaoWrapper w100 flexColumn">
                                <label for=""><small>Digite a Informação, deixe o campo vazio caso não queira salvar:</small></label>
                                <input type="text" id="adicionarInformacao" class="box" name="" placeholder="Digite aqui a informação" id="">
                            </div>

                    <?php   }
                    } ?>


                </form>
            </div>
    </div>

    <div class="paginacao flexRow">
        <?php

            for ($count = 1; $count <= $paginacao; $count++) {
                if ($count === $pagina)
                    echo "<a id='pagina' class='marcado' href='" . informacaoView::generateGETurl("pagina", $count) . "'><h1>$count</h1></a>";
                else
                    echo "<a id='pagina' href='" . informacaoView::generateGETurl("pagina", $count) . "'><h1>$count</h1></a>";
            }
        ?>

    </div>
<?php } ?>
</div>