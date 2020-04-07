/**
 * Classe de ajax
 * versão 2019.1
 * parametros aceitos:
 *
 * url: 'string'
 * method: get/post (get)
 * processData: true/false (true)
 * dataType: JSON/Text (JSON)
 * contentType: 'string'
 * data: Objeto JSON/'string' (Objeto JSON)
 * error: 'string'/function
 * success: 'string'/function
 * complete: 'string/function'
 * beforeSend: 'string/function'
 */
class Ajax {
    static post(url, data, callback) {
        return this.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: callback
        });
    }

    static get(url, callback, dataType) {
        return this.ajax({
            url: url,
            method: 'GET',
            success: callback,
            dataType: dataType === undefined ? 'JSON' : dataType
        });
    }

    static ajax(obj) {
        if (typeof obj.beforeSend === 'function')
            obj.beforeSend();

        if (typeof obj.method === 'undefined')
            obj.method = 'GET';

        if (typeof obj.dataType === 'undefined')
            obj.dataType = 'JSON';

        if (typeof obj.processData === 'undefined')
            obj.processData = true;

        obj.method = obj.method.toUpperCase();
        let token = document.querySelector('input[name="_token"]');

        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState === xhr.DONE) {
                switch (this.status) {
                    case 200: if (typeof obj.success === 'function') {
                        if (obj.dataType === 'JSON')
                            obj.success(JSON.parse(this.responseText));
                        else
                            obj.success(this.responseText);
                    } break;
                    case 401: alert('Sessão expirada');
                    case 403:
                    case 422:
                    case 500: if (typeof obj.error === 'function') {
                        obj.error(JSON.parse(this.responseText), this.status);
                    } break;
                }

                if (typeof obj.complete === 'function')
                    obj.complete(JSON.parse(this.responseText));
            }
        };
        // xhr.onreadystatechange = function() {
        //     if(this.readyState === xhr.DONE && this.status === 200) {
        //         if(typeof obj.success !== 'undefined') {
        //             if(obj.dataType === 'JSON')
        //                 obj.success(JSON.parse(this.responseText));
        //             else
        //                 obj.success(this.responseText);
        //         }
        //     } else if(this.readyState === xhr.DONE && this.status === 401) {
        //         alert('Sessão expirada');
        //     } else if(this.readyState === xhr.DONE && (this.status === 500) || (this.status === 422)) {
        //             if(typeof obj.error === 'function')
        //                 obj.error(JSON.parse(this.responseText).msg, this.status);
        //             // else
        //             //     mensagem(true, JSON.parse(this.responseText).msg, 'danger');
        //     }
        // };
        xhr.open(obj.method, obj.url, typeof obj.async === 'undefined' ? true : obj.async);//true deixa o ajax async
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        if (obj.contentType === undefined)
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

        if (typeof obj.processData !== 'undefined' && obj.processData === true)
            obj.data = this.param(obj.data);

        if (obj.method === 'POST' && obj.data !== 'undefined') {
            xhr.setRequestHeader('X-CSRF-Token', token.value);
            xhr.send(obj.data);
        }
        else
            xhr.send();
    }

    static param(object) {
        let encodedString = '';
        for (let prop in object) {
            if (object.hasOwnProperty(prop)) {
                if (encodedString.length > 0)
                    encodedString += '&';
                if (Array.isArray(object[prop]))
                    encodedString += encodeURI(prop + '=' + object[prop].join('&' + prop + '='));
                else
                    encodedString += encodeURI(prop + '=' + object[prop]);
            }
        }
        return encodedString;
    }
}

HTMLElement.prototype.serialize = function () {
    let obj = {};
    let elements = this.querySelectorAll("input, select, textarea");
    for (let i = 0; i < elements.length; ++i) {
        let element = elements[i];

        let name = element.name;
        let value = element.value;

        if (name) {
            if (name.match(/\[\]/) && element.type !== 'checkbox') {//para elementos do tipo array[] e não sejam checkbox

                if (Array.isArray(obj[name])) {
                    obj[name].push(value);
                }
                else {
                    obj[name] = [value];
                }

            }
            else if (element.type === 'checkbox') {//para checkbox

                //para elemento checkbox que não é array
                if(!name.match(/\[\]/)) {
                    obj[name] = element.checked;
                } else {//se o checkbox for array

                    if(element.checked) {//elemento lido está selecionado

                        if(Array.isArray(obj[name])) {//o array que vai guardar os valores já existe
                            obj[name].push(value);//apenas inclui o novo valor no array
                        } else {
                            obj[name] = [value];//cria o array e inclui o elemento selecionado
                        }
                    }
                }
            }
            else if (element.type === 'radio') {//para radio
                if (element.checked === true)
                    obj[name] = value;
            }
            else//todos os outros casos
            {
                obj[name] = value;
            }
        }
    }
    // return JSON.stringify( obj );
    return obj;
};