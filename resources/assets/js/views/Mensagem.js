/**
 * Classe que determina que tipo de reposta foi enviada do controlador
 * Podem ser 3 tipos
 * 1 - Mensagem do programador.
 * {message: "Formulário salvo com sucesso"} - http 200;
 * 
 * 2 - Exception enviado pelo programador ou laravel (a do laravel vem mais coisas mas só interessa a mensagem)
 * {message: 'Falha ao conectar ao banco'} - http 500;
 * 
 * 3 - Erros de validação
 * {
 *      message: 'The given data was invalid.', ===> até o dia em que escrevi esta classe (06/02/2018) não há como traduzir esta mensagem sem gambiarra
 *      errors: {
 *          'nome_do_campo': [              ==> class Array
 *              0: 'mensagem de erro 1 para este campo', 
 *              1: 'menssagem de erro 2 para este campo',
 *              length: 2
 *          ],
 *          'nome_do_campo2': [
 *              0: 'mensagem de erro 1 para este campo',
 *              length: 1
 *          ]
 *      }
 * } - http 422
 */
class Mensagem {

    constructor(e) {
        this._mensagens = null;
        this._erroValidacao = false;
        this._e = e;

        //se o parametro enviado for string
        if(typeof e === 'string') {
            this._mensagens = e;
        }
        //verificando se é algum erro em algum campo
        else if(typeof e.errors !== 'undefined') {

            this._mensagens = e.message;
            this._erroValidacao = true;


        } else {// o último caso é que pode ser um objeto com string

            this._mensagens = e.message;

        }   
    }

    erroValidacao() {
        return this._erroValidacao;
    }

    getErros() {
        return this._e.errors;
    }

    toString(html = true) {
        //verificando se há alguma mensagem guardada na classe
        if(this._mensagens === null ? true : false) {
            return;
        }
        
        //se há várias mensagens
        if(this._erroValidacao) {
            
            return html ? this._obterElementosHTML() : this.getErros();
            
        } else {
            
            return this._mensagens;
        }
    }
    
    _obterElementosHTML() {
        let html = '';

        //o array aqui funciona como no php onde os indices são palavras e não números
        for(let x in this._e.errors) {//x é o nome do elemento
            
            //um campo pode ter mais de um erro
            if(this._e.errors[x].length > 1) {

                //percorrendo a lista de erros deste campo
                for(let i = 0; i < this._e.errors[x].length; i++) {
                    html += `<li><a href="#!" onclick="document.getElementById('${x}').scrollIntoView({block: 'center'}); document.getElementById('${x}').focus()">${this._e.errors[x][i]}</a></li>`;
                }
            }
            //se houver apenas um erro
            else {
                html += `<li><a href="#!" onclick="document.getElementById('${x}').scrollIntoView({block: 'center'}); document.getElementById('${x}').focus()">${this._e.errors[x][0]}</a></li>`;
            }
        }

        return `<ul>${html}</ul>`;
    }
}