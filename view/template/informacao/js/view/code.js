import { mainJS } from '../main.js';

window.onload = function () {

    main();
    var ListInputs = [];
    function main() {
        actionToButtons();



    }

    function actionToButtons() {
        selecionarTodasInformacoesPagina();
        addLinksInButtons();
        paginaActionClick();
        verificarSelecionados();
        desmarcarTodosinput('criarInput');

    }

    function desmarcarTodosinput(constCriarInput) {

        let input = document.querySelector('#desmarcarTodos');

        setTimeout(() => {
            prepareToConnect([''], 'QUANTIDADE_ITENS_SELECIONADOS', input);

            setTimeout(() => {
                let quantidade = Number(input.innerHTML);
                let elementParent = input.parentElement;
                if (quantidade === 0)
                    elementParent.classList.add('opacityNone');
                else
                    elementParent.classList.remove('opacityNone');


            }, 50);
        }, 50);





        if (constCriarInput !== undefined) {
            input.parentElement.addEventListener('click', function () {
                prepareToConnect([''], 'DELETE_SELECTED_ITENS');
                setTimeout(() => {
                    window.location.href = window.location.href;
                }, 50);
            })
        }

    }
    function verificarSelecionados() {
        let listSelecionados = listCheckTrueFunc();
        if (listSelecionados.length == 10) {
            document.querySelector('#selecionarTodos').checked = true;
        }
    }
    function addLinksInButtons() {
        menuH1Button();



        function menuH1Button() {
            let input = document.querySelector('html body div.container.w100.boxShadow.flexColumn div.menu.w100.flexRow h1.w50');
            input.addEventListener('click', function () {
                window.location.href = HOME_PATH;
            })
        }
    }
    function paginaActionClick() {

        let listPagina = document.querySelectorAll('#pagina');
        listPagina.forEach(function (pagina) {
            pagina.addEventListener('click', function (e) {
                let listSelectedChecks = listCheckTrueFunc('ID');



                sendSelectedCheckPOST(listSelectedChecks);
                setTimeout(() => {
                    window.location.href = pagina.getAttribute('href');

                }, 100);
            })
        })
    }
    function selecionarTodasInformacoesPagina() {
        let selectInput = document.querySelector('input#selecionarTodos');
        var listOfChecks = document.querySelectorAll('div.informacoesWrapper h4 input#checkInfo');

        selectInput.addEventListener('change', function () {

            marcaTodosCheckBox(this.checked);

        })

        addEventChange(listOfChecks);
        selectOnClickForm();

        function selectOnClickForm() {
            let listInformacoes = document.querySelectorAll('div.informacoesWrapper  div.informacoes');

            const draggables = listInformacoes;
            const containers = document.querySelectorAll('.informacoesWrapper')
            draggables.forEach(draggable => {
              draggable.addEventListener('dragstart', () => {
                draggable.classList.add('dragging')
         
              })
            
              draggable.addEventListener('dragend', () => {
                draggable.classList.remove('dragging')
              })
            })
            
            containers.forEach(container => {
              container.addEventListener('dragover', e => {
                e.preventDefault()
                const afterElement = getDragAfterElement(container, e.clientY)
                const draggable = document.querySelector('.dragging')
                if (afterElement == null) {
                  container.appendChild(draggable)
                } else {
                  container.insertBefore(draggable, afterElement)
                }
              })
            })
            
            function getDragAfterElement(container, y) {
              const draggableElements = [...container.querySelectorAll('.informacoes:not(.dragging)')]
            
              return draggableElements.reduce((closest, child) => {
                const box = child.getBoundingClientRect()
                const offset = y - box.top - box.height / 2
                if (offset < 0 && offset > closest.offset) {
                  return { offset: offset, element: child }
                } else {
                  return closest
                }
              }, { offset: Number.NEGATIVE_INFINITY }).element
            }

            
            
            
            listInformacoes.forEach(function (item) {
                item.addEventListener('click', function () {

                    let itemChildren = item.children[0].children[0].children[0];
                    let itemID = item.children[1].innerHTML;
                    if (itemChildren.checked) {
                        itemChildren.checked = false;

                        selectandCompare();
                        sendUnselectCheckPost([itemID]);
                        desmarcarTodosinput();
                    } else {
                        itemChildren.checked = true;

                        selectandCompare();
                        sendSelectedCheckPOST([itemID]);
                        desmarcarTodosinput();

                    }
                    selectandCompare();

                })



                item.addEventListener('dblclick', function () {
                    //window.location.href = HOME_PATH + 'view/id/' + item.children[1].innerHTML;
                })
            })

        }
    }
}






function sendUnselectCheckPost(IDUnchecked) {
    prepareToConnect(IDUnchecked, 'IDUnchecked')
}
function prepareToConnect(ArrayData, typeData, elementResponse) {
    let formPrepare = mainJS.formPrepare();
    formPrepare = formPrepare.formListPrepare(ArrayData, typeData);
    let phpConnect = mainJS.conexaoPHP();
    phpConnect.setPOSTsendToServer(formPrepare);

    if (elementResponse !== undefined)
        phpConnect.setFormResponse(elementResponse);

    phpConnect.prepare('POST', window.location.href);
    phpConnect.conectar();
}
function sendSelectedCheckPOST(listSelectedChecks) {
    prepareToConnect(listSelectedChecks, 'IDChecked')
}
function marcaTodosCheckBox(isChecked) {
    let listOfChecks = document.querySelectorAll('div.informacoesWrapper h4 input#checkInfo');

    if (isChecked) {
        let resultado = [];
        listOfChecks.forEach(function (item) {
            item.checked = true;
            let ID = item.parentElement.parentElement.parentElement.children[1].innerHTML;
            resultado.push(ID);
        })
        sendSelectedCheckPOST(resultado)

    } else {
        let resultado = [];
        listOfChecks.forEach(function (item) {
            item.checked = false;
            let ID = item.parentElement.parentElement.parentElement.children[1].innerHTML;
            resultado.push(ID);
        })
        sendUnselectCheckPost(resultado)
    }
    desmarcarTodosinput();

}
function addEventChange(listOfChecks) {
    listOfChecks.forEach(function (item) {
        item.addEventListener('change', function () {

            selectandCompare(this);

        })
    })

}
function selectandCompare() {
    var listOfChecks = document.querySelectorAll('div.informacoesWrapper h4 input#checkInfo');


    let selectInput = document.querySelector('input#selecionarTodos');
    let listCheckTrue = listCheckTrueFunc();
    if (listOfChecks.length !== listCheckTrue.length)
        selectInput.checked = false;

    else if (listOfChecks.length === listCheckTrue.length)
        selectInput.checked = true;


    //transicaoCheckBox(listCheckTrue);
    return;
}
function listCheckTrueFunc(typeOFReturn) {
    let listCheckTrue = [];
    var listOfChecks = document.querySelectorAll('div.informacoesWrapper h4 input#checkInfo');

    listOfChecks.forEach(function (item) {
        if (item.checked) {
            if (typeOFReturn === undefined || typeOFReturn === null)
                listCheckTrue.push(item);
            else {
                if (typeOFReturn === 'ID') {
                    let ID = item.parentElement.parentElement.parentElement.children[1].innerHTML;
                    listCheckTrue.push(ID);

                }

            }
        }
    })


    return listCheckTrue;
}

function listCheckFalse() {
    var listOfChecks = document.querySelectorAll('div.informacoesWrapper h4 input#checkInfo');
    let listCheckFalse = [];

    listOfChecks.forEach(function (item) {
        if (item.checked === false) {
            listCheckFalse.push(item);
        }
    })
    return listCheckFalse;
}
function transicaoCheckBox(listOfChecks) {
    // alert('a');
    // console.log(listOfChecks);
    listOfChecks.forEach(function (item) {
        let parentElement = item.parentElement.parentElement.parentElement;
        parentElement.classList.add('slide-out');
        setTimeout(() => {
            parentElement.remove();
        }, 500);
        reconfigurarCores(listCheckFalse());

        // item.classList.add('slide-out');
    })

}
function reconfigurarCores(listCheck) {
    for (let n = 0; n < listCheck.length; n++) {
        let item = listCheck[n].parentElement.parentElement.parentElement;
        if (n % 2 === 0)
            item.classList.add('dark');
        else
            item.classList.remove('dark');
    }
}

