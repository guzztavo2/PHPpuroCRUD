window.onload = function(){
main();

    
}





function main(){
    buttonsAction();


}






function buttonsAction(){
    editInputAction();
}





function editInputAction(){
    let inputEdit = document.querySelector('#editInput');
    if(inputEdit.value == '0000-00-00 00:00:00'){
        inputEdit.value = new Date().toLocaleString();
        setInterval(function(){
            inputEdit.value = new Date().toLocaleString();
        },1000)
    }
}