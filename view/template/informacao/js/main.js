
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
    formListPrepare(listToObect, key) {

        let listResult = [];
    

        for (let n = 0; n < listToObect.length; n++) {
            let item = new formPrepare(key, listToObect[n]);
            listResult.push(item);
        }
    
        return listResult;

    }

    static objectToList(objectList) {
        let result = [];
        objectList.forEach(function (item) {
            result.push(Object.values(item));

        });
        return result;
    }
}
class conexaoPHP {
    prepareToConnect(ArrayData, typeData, elementResponse) {
        let formPrepare = mainJS.formPrepare();
        formPrepare = formPrepare.formListPrepare(ArrayData, typeData);
   
        let phpConnect = mainJS.conexaoPHP();
       
        phpConnect.setPOSTsendToServer(formPrepare, typeData);

   
    
        if (elementResponse !== undefined)
            phpConnect.setFormResponse(elementResponse);
    
        phpConnect.prepare('POST', window.location.href);
        phpConnect.conectar();
    }
    setFormResponse(element) {
        this.formResponse = element;
    }
    setPOSTsendToServer(formPrepareObjectOrList, typeData) {
        let listItens = formPrepare.objectToList(formPrepareObjectOrList);
       
        let form = new FormData(), count = 0;
        listItens.forEach(function (item) {
            switch(typeData){
                case 'informacaoSession':
                    let url = window.location.search;
                    url = url.substring(url.indexOf('pagina'));
                    form.append(item[0] + '/' + count + '/' + url, item[1]);
                    break;
                default:
                    form.append(item[0] + '/' + count, item[1]);
                break;
            }
            ++count;
        })
        console.log(form);
        this.formPrepare = form;
    }
    prepare(postGetConection, url) {
        let xhr = new XMLHttpRequest();

        url = window.location.href.substring(0,window.location.href.indexOf(window.location.search));
        xhr.open(postGetConection, url);
        this.XMLHttpRequest = xhr;

    }

    conectar() {
        if (this.XMLHttpRequest === null || this.XMLHttpRequest === undefined)
            throw new Error('Você precisa definir o método: PREPARE desse OBJETO para poder utiliza-lo.');

        let xhr = this.XMLHttpRequest;
        if (this.formPrepare !== null && this.formPrepare !== undefined)
            xhr.send(this.formPrepare);
        else
            xhr.send();

        if (this.formResponse !== undefined) {
            let formResponse = this.formResponse;
            xhr.onloadend = function () {
                console.log(this.response);

                formResponse.innerHTML = this.response;
            }
        } else {
            xhr.onloadend = function () {
                console.log(this.response);
                xhr.abort();
            }
        }

    }



}