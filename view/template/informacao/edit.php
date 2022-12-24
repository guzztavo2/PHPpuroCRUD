<?php
if (!defined('APP_ROOT')) {
    include_once('../config.php');
    redirectSecurity();
}
extract($dataPage);

?>


<div class="container">
    <div style="background-color: white;" class="w100 box">
        <h2>Editar Informação: <?php echo $informacao->getInformacao() . '. ' . '(' . $informacao->getID() . ')'; ?></h2>
    </div>

    <div class="w100 formsWrapper box flexColumn">
        <h3 class="w100">Edite as informações abaixo:</h3>
        <form action="" class="w100 box flexColumn">
            <div class="inputGroup w100 box">
                <label for="informacao box">
                    <p>Digite a nova informação abaixo:</p>
                    <input type="text" name="informacao" class="w100 box" id="" value="<?php echo $informacao->getInformacao() ?>">
                    <p>Informações em branco serão ignoradas e não serão modificadas!</p>
                </label>
            </div>
            <div class="inputGroup w100 box">
                <label for="dataCriacao box">
                    <p>Data de criação da informação:</p>
                    <input disabled type="text" name="dataCriacao" value="<?php echo $informacao->getDataCriacao()->format('d/m/Y H:i:s') ?>" class="w100 box" id="">
                    <p>Informações em branco serão ignoradas e não serão modificadas!</p>
                </label>
            </div>
            <div class="inputGroup w100 box">
                <label for="dataAtualizacao box">
                    <p>Data de atualização da informação:</p>
                    <input disabled id="editInput" type="text" name="dataCriacao" value="<?php echo ($informacao->getDataAtualizacao() !== null) ? '0000-00-00 00:00:00' : $informacao->getDataAtualizacao()->format('Y-m-d H:i:s') ?>" class="w100 box" id="">
                    <p>Informações em branco serão ignoradas e não serão modificadas!</p>
                </label>
            </div>
            <div class="box">
            <input style="cursor:pointer;" type="submit" value="Enviar" class="box w100">

            </div>
        </form>
    </div>


</div>