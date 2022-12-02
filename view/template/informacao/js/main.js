
// export function mainClass(){
//     return new mainJS();
// }

export class mainJS {

    static conexaoPHP() {
        return new conexaoPHP();
    }
    static formPrepare() {
        return new formPrepare();
    }


}

class formPrepare {

    constructor(ChaveForm, ValorForm) {
        this.ChaveForm = ChaveForm;
        this.ValorForm = ValorForm
    }
    getValorForm() {
        return this.ValorForm;
    }
    getChaveForm() {
        return this.ChaveForm;
    }
    setValorForm(ValorForm) {
        this.ValorForm = ValorForm;
    }
    setChaveForm(ChaveForm) {
        this.ChaveForm = ValorForm;
    }
    formListPrepare(listToObect) {

        let listResult = [];


        for (let n = 0; n <= listToObect.length - 2; n++) {
            console.log(n);
            console.log(++n);
            let item = new formPrepare(listToObect[n], listToObect[++n]);
            listResult.push(item);
        }
        return listResult;

    }
}
class conexaoPHP {

    preparePOSTForm(formPrepareListOrVar) {

    }
    prepare(postGetConection, url) {
        let xhr = XMLHttpRequest();
        xhr.open(postGetConection, url);
    }

    conectar(url, tipo) {

        // xhr.send();

        // xhr.onload() = function(){
        //     if(xhr.status === 200){
        //         console.log(xhr.response);
        //     }
        // }

    }



}