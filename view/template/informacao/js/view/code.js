window.onload = function () {
    main();

    function main() {
        actionToButtons();




    }

    function actionToButtons() {
        selecionarTodasInformacoesPagina();
        addLinksInButtons();
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
            listInformacoes.forEach(function (item) {
                item.addEventListener('click', function () {

                    let itemChildren = item.children[0].children[0].children[0];
                    if (itemChildren.checked) {
                        itemChildren.checked = false;
                    } else {
                        itemChildren.checked = true;
                    }
                    selectandCompare();

                })
                item.addEventListener('dblclick', function () {
                    console.log();
                    window.location.href = HOME_PATH + 'view/id/' + item.children[1].innerHTML;
                })
            })
        }





    }
    function marcaTodosCheckBox(isChecked) {
        let listOfChecks = document.querySelectorAll('div.informacoesWrapper h4 input#checkInfo');

        if (isChecked) {
            listOfChecks.forEach(function (item) {
                item.checked = true;
            })
        } else {
            listOfChecks.forEach(function (item) {
                item.checked = false;
            })
        }

    }
    function addEventChange(listOfChecks) {
        listOfChecks.forEach(function (item) {
            item.addEventListener('change', function () {
                selectandCompare();

            })
        })

    }
    function selectandCompare() {
        var listOfChecks = document.querySelectorAll('div.informacoesWrapper h4 input#checkInfo');

        let selectInput = document.querySelector('input#selecionarTodos');
        let listCheckTrue = listCheckTrueFunc(listOfChecks);
        if (listOfChecks.length !== listCheckTrue.length)
            selectInput.checked = false;
        else if (listOfChecks.length === listCheckTrue.length)
            selectInput.checked = true;
        //transicaoCheckBox(listCheckTrue);

        return;
    }
    function listCheckTrueFunc(listOfChecks) {
        let listCheckTrue = [];
        listOfChecks.forEach(function (item) {
            if (item.checked)
                listCheckTrue.push(item);
        })


        return listCheckTrue;
    }
    function listCheckFalse(){
        var listOfChecks = document.querySelectorAll('div.informacoesWrapper h4 input#checkInfo');
        let listCheckFalse = [];

        listOfChecks.forEach(function(item){
            if(item.checked === false){
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
        console.log(listCheck);
        for (let n = 0; n < listCheck.length; n++) {
            let item = listCheck[n].parentElement.parentElement.parentElement;

            if (n % 2 === 0) {
                item.classList.add('dark');
                console.log(item);
            } else {
                item.classList.remove('dark');
                console.log(item);


            }
        }
    }
}