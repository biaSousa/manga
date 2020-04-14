class ServidorController {
    
    constructor() {
        this._form       = document.getElementById('form');
        this._matricula  = document.getElementById('matricula');
        this._cpf        = document.getElementById('cpf');
        this._servidor   = document.getElementById('servidor');
        this._email      = document.getElementById('email');
        this._data_nasc  = document.getElementById('data_nasc');
        this._data_entra = document.getElementById('data_entra');
        this._unidade    = document.getElementById('unidade');
        this._setor      = document.getElementById('setor');
        this._cargo      = document.getElementById('cargo');

        this._token = document.querySelector('input[name="_token"]');

        //from bono
        this._excluir = document.getElementById('excluir');
        }

        pesquisar(e) {
            e.preventDefault();
            this._table.draw();
            // e.preventDefault();
            // oTable.odraw();
        }
    
        criar(e) { 
            window.location = `${e.dataset.url}/servidor/novo/`;
        }
    
        editar(e) {
            let linha = oTable.rows('.selected').data()[0];
            if (linha !== null) {
                window.location = `${e.dataset.url}/servidor/edita/${linha.id}`;
            }
            else
                alert('Selecione um item');
            return false;
        }
    
        excluir(e) {
            let linha = oTable.rows('.selected').data()[0];
        
            if (linha !== null) {
        
                if (confirm('Deseja excluir este item?'))
        
                    Ajax.ajax({
                        url: `${e.dataset.url}/${linha.id}`,
                        method: 'POST',
                        data: { linha: linha.guia },
                        beforeSend: () => {
                            this._excluir.disabled = true;
                        },
                        success: (json) => {
                            alert(json.message);
                            this._excluir.Tooltip.hide();
                            oTable.draw();
                        },
                        error: (json) => {
                            alert(json.message);
                            this._excluir.disabled = false;
                        }
                    });
            }
            else
                alert('Selecione uma item para excluir');
        
            return false;
        }
    

    old_pesquisar(e) {
        e.preventDefault();
        this._table.draw();
       
    }  

    old_salvar(e) {
        e.preventDefault();
        Ajax.ajax({
            url: this._form.action,
            data: this._form.serialize(),
            method: 'post',
            success: function (e) {
                let snackbar = new Snackbar();
                snackbar.exibirVerde(e.msg);
            },
            error: function (e) {
                let snackbar = new Snackbar();
                snackbar.exibirVermelho(e.msg);
                $('#snackbar').html(e.msg)
                            .addClass('alert')
                            .removeClass('alert-success')
                            .addClass('alert-danger')
                            .fadeIn()
                            .delay(5000)
                            .fadeOut();
            }
        });
    }

    old_remover(id) {
        if (confirm('Deseja realmente remover este registro?')) {
            $.ajax({
                type: 'POST',
                url: BASE_URL + '/equipamento/remove-equipamento/' + id,
                data: {_token: this._token.value},
                dataType: 'json',
                    success: (resp) => {                    
                        if(resp.retorno != 'sucesso') {
                            $('#msg').html(resp.msg)
                                     .addClass('alert-danger')
                                     .removeClass('alert-success')
                                     .fadeIn();
                        }else {
                            $('#msg').html(resp.msg)
                                     .addClass('alert-success')
                                     .removeClass('alert-danger')
                                     .fadeIn()
                                     .delay(7000)
                                     .fadeOut();

                        this.carregaGrid();
                        }      
                    }
                });
            }
        }
    }