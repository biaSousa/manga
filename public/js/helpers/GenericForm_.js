class GenericForm {
    constructor() {
        this._form = document.getElementById('formulario');
    }

    save(formId=null) {
        var retorno;        
        
        let valida = new ValidaForm();

        if (!valida.validaFormulario(formId)) {
            this._msgErroView.update(valida.getMensagem());
        }
        
        var $form = (formId) ? $(`#${formId}`) : $('#formulario');
        
        $form.ajaxSubmit({
            async: false,
            success: (response) => {
                retorno = response;
            }
        });

        return retorno;
    }

    remove() {
        if (confirm('Deseja realmente remover este registro?')) {
            Utils.ajaxPost(this._urlRemove, {id: rowData.id}, (response) => {
                if (response.retorno === 'erro' || (response.retorno !== 'erro' && response.retorno !== 'sucesso')) {
                    this._msgAvisoView.update(response.msg);
                    setTimeout(() => {
                        this._msgAvisoView.escondeMensagem()
                    }, 5000);
                }
                else if (response.retorno === 'sucesso') {
                    this._msgView.update(response.msg);
                    setTimeout(() => {
                        this._msgView.escondeMensagem()
                    }, 5000);
                    Grid.reloadGrid();
                }
            });
        }
    }

    openModalSalvar() {
        this._form.reset();
        this._form.id.value = '';
        this._btSalvar.classList.remove('hidden');
        this._btAlterar.classList.add('hidden');
        this._msgErroView.escondeMensagem();
    }
    
    setMessageErro(msg, time=null)
    {
        this._msgErroView.update(msg);
        setTimeout(()=>{this._msgErroView.escondeMensagem()}, (time)? time : 7000);
    }
    
    setMessageAviso(msg, time=null)
    {
        this._msgAvisoView.update(msg);
        setTimeout(()=>{this._msgAvisoView.escondeMensagem()}, (time)? time : 7000);
    }

//    loadGrid(options) {
//        Grid.load(options);
//    }
//
//    pesquisar(e) {
//        //       if (e.target.type == "submit") {
//        if (!e) {
//            Grid.reloadGrid();
//        } else if (e.keyCode == 13) {
//            Grid.reloadGrid();
//        }
//    }

}
