window.onload = function(){
main();
}



function main(){
    inputQuantidadeAction();



}



function inputQuantidadeAction(){
    var listInput = document.querySelector('div.listInput');
    var inputQuantidade = document.querySelector('#inputQuantidade');
    
    let smallInput = document.querySelector('div.inputQuantidade span small');
    inputQuantidade.addEventListener('keyup', function(){
        if(/[^0-9]/g.test(this.value)){
            smallInput.innerHTML = 'Tente digitar apenas números por aqui';
        }
        this.value = this.value.replace(/[^0-9]/g, '');
    })

    inputQuantidade.addEventListener('keypress', function(e){
        if(e.key === 'Enter'){
            if(this.value.length > 0){
                //window.location.href = 
                let URL = LOCAL_PATH + "/?quantidadeinput=" + this.value;

                console.log(URL);
                alert('a');
                window.location.href = URL
            } else{
                smallInput.innerHTML = 'Você precisa adicionar um número, antes de qualquer coisa.';
            }
            
        }
    })
    actionInputQuantidade(inputQuantidade);
    actionListInput(listInput);


    function actionListInput(listInput){

    }
 
    function actionInputQuantidade(inputQuantidade){
        
    }
}
