window.onload = function(){
main();
}



function main(){
    inputQuantidadeAction();



}



function inputQuantidadeAction(){
    var listInput = document.querySelector('div.listInput');
    var inputQuantidade = document.querySelector('#inputQuantidade');
    
    
    inputQuantidade.addEventListener('keyup', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    })
    actionInputQuantidade(inputQuantidade);
    actionListInput(listInput);


    function actionListInput(listInput){

    }
 
    function actionInputQuantidade(inputQuantidade){
    
    }
}
