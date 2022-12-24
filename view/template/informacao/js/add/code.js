import { mainJS } from '../main.js';

window.onload = function () {
    main();




}



function main() {
    inputQuantidadeAction();
    inputAdicionarInformacoes();


}


function inputAdicionarInformacoes() {

    let paginaList = document.querySelectorAll('#pagina'),
        salvarBtn = document.querySelector('#salvar'),
        cancelarBtn = document.querySelector('.Cancelar');
    if (cancelarBtn !== null) {
        cancelarBtn.addEventListener('click', function () {
            let conexaoPHP = mainJS.conexaoPHP();
            conexaoPHP.prepareToConnect([''], 'CancelarSession');
            setTimeout(() => {
                window.location.href = HOME_PATH;
            }, 50);
        })
    }
    paginaList.forEach((item) => {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            eventClick();
            setTimeout(() => {
                let url = window.location.search;
                url = url.substring(0, url.indexOf('pagina'));


                if (url.length <= 0) {
                    url = window.location.search;
                    url = LOCAL_PATH + '/' + url + '&pagina=' + item.children[0].innerHTML;
                }
                else
                    url = LOCAL_PATH + '/' + url + 'pagina=' + item.children[0].innerHTML;

                window.location.href = url;
            }, 20);
        });
    })
    if(salvarBtn !== null){
    salvarBtn.addEventListener('click', function () {
        let conexaoPHP = mainJS.conexaoPHP();
        let informacoesInput = document.querySelectorAll('#adicionarInformacao');
        let resultado = [];
        informacoesInput.forEach(function(item){
         if(item.value.length > 0){
            resultado.push(item.value);
         }
        })
        conexaoPHP.prepareToConnect(resultado,'SALVAR_SESSION');
        setTimeout(() => {  
            window.location.href = HOME_PATH + 'view/?orderBy=id&desc';
        }, 50);
    });

}
}

function eventClick() {
    let listInput = document.querySelectorAll('#adicionarInformacao');
    let resultado = [];
    listInput.forEach((item) => {

        resultado.push(item.value);

    })
    let conexaoPHP = mainJS.conexaoPHP();
    conexaoPHP.prepareToConnect(resultado, 'informacaoSession');
}
function inputQuantidadeAction() {
    var listInput = document.querySelector('div.listInput');
    var inputQuantidade = document.querySelector('#inputQuantidade');

    let smallInput = document.querySelector('div.inputQuantidade span small');
    if (inputQuantidade !== null) {
        inputQuantidade.addEventListener('keyup', function () {
            if (/[^0-9]/g.test(this.value)) {
                smallInput.innerHTML = 'Tente digitar apenas números por aqui';
            }
            this.value = this.value.replace(/[^0-9]/g, '');
        })

        inputQuantidade.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                if (this.value.length > 0) {
                    let URL = LOCAL_PATH + "/?quantidadeinput=" + this.value + '&pagina=1';
                    window.location.href = URL
                } else {
                    smallInput.innerHTML = 'Você precisa adicionar um número, antes de qualquer coisa.';
                }

            }
        })
    }
    actionInputQuantidade(inputQuantidade);
    actionListInput(listInput);


    function actionListInput(listInput) {

    }

    function actionInputQuantidade(inputQuantidade) {

    }
}
