class GenericModalForm {
    
    constructor(params) {
        this._form        = document.getElementById('formulario');
        this._mensagem    = new MensagemView(document.getElementById('msg'));
        this._msgModal    = new MensagemView(document.getElementById('msgModal'));
        this._urlEdita    = params.url_edit;
        this._urlRemove   = params.url_remove;
        this._btSalvar    = document.getElementById('btnSalvar');
        this._btAlterar   = document.getElementById('btnAlterar');
        this._btnFechar   = $('#btnFechar');
        this._modalView   = $('#modal');
        this._token       = document.querySelector('input[name="_token"]');
        
        $('input[required], select[required], textarea[required]').parent().siblings('label').append('<span style="color:red" data-toggle="tooltip" title="Campo obrigatório">*</span>');
    }

    salvar(formId = null) {
        this._oValida = new ValidaForm();

        if (!this._oValida.validaFormulario(formId)) {
            this._msgModal.update(this._oValida.getMensagem(), 'E');
            return false;
        }
        
        let $form = (formId)? $(`#${formId}`) : $('#formulario');
        
        $form.ajaxSubmit({
            async: false,
            success: (response) => {
                if (response.retorno !== 'sucesso') {
                    this._msgModal.update(response.msg, 'E');
                }
                else if (response.retorno === 'sucesso') {
                    this._mensagem.update(response.msg);
                    this._btnFechar.trigger('click');
                    oTable.draw();
                }
            },
            error: (request, status, error) => {
                if(request.status === 404) {
                    this._msgModal.update('Página não encontrada.', 'E', 7000);
                }else {
                    window.console.log(request.responseText);
                }
            }
        });

        return false;
    }

    remover() {
        if (confirm('Deseja realmente remover este registro?')) {
            var row = oTable.row('.selected').data();

            $.ajax({
                type: 'POST',
                url: this._urlRemove + row.id,
                data: {_token: this._token.value},
                dataType: 'JSON',
                success: (response) => {
                    if (response.retorno !== 'sucesso') {
                        this._mensagem.update(response.msg, 'E');
                    }
                    else if (response.retorno === 'sucesso') {
                        this._mensagem.update(response.msg);
                        oTable.draw();
                    }
                }
            });
        }
    }

    inicializaModal(formId=null) {
        this._form.reset();
        this._form.id.value = '';
        this._msgModal.escondeMensagem();
        
        if(!formId) {
            this._formulario = $('input[required], select[required], textarea[required]');
        }else {
            this._formulario = $(`${formId} input[required], ${formId} select[required], ${formId} textarea[required]`);
        }
        
        $.each(this._formulario, function(){
            $(this).parent().parent().removeClass('has-error').removeClass('has-danger');
        });
    }
    
    getToken() {
        return this._token.value;
    }
    
}
