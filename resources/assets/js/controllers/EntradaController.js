class EquipamentoController {
    
    constructor() {
        this._form = document.getElementById('form');
        this._formGrid = document.getElementById('formulario');
        this._tipo  = document.getElementById('tipo');
        this._marca = document.getElementById('marca');
        this._modelo = document.getElementById('modelo')
        this._numserie = document.getElementById('num_serie')
        this._patrimonio = document.getElementById('patrimonio')
        this._table = document.querySelector('#grid tbody');
        this._token = document.querySelector('input[name="_token"]');
    }

    carregaEquipamento()
    {
        this._tipo.value = '';
        this._marca.value = '';
        this._modelo.value = '';
        this._numserie.value = '';
        this._patrimonio.value = '';

        Ajax.ajax({
            url: this._form.dataset.url,
            data: {equipamento: this._equipamento.value},
            success: (e) => {
                if(e.id) {
                    $('#msg-info').html(`Equipamento <b>${e.equipamento}</b> carregado.`).removeClass('d-none');
                }

                this._tipo.value = e.fk_tipo;
                this._marca.value = e.fk_marca;
                this._modelo.value = e.fk_modelo;
                this._unidade.value = e.fk_unidade;
                this._numserie.value = e.num_serie;
                this._patrimonio.value = e.patrimonio;
               ;
            },
            method: 'POST',
            error: (e) => {
                if(e.url) {
                    window.location = e.url;
                    return false;
                }

                $('#snackbar').html(e.message)
                            .addClass('alert')
                            .addClass('alert-danger')
                            .fadeIn();
            }
        });
    }

    eventoEnter(event) {
        if(event.key === 'Enter') {
            this.carregaGrid();
        }
    }
//salvar
    adicionar(e) {
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
    
    remover(id) {
        if (confirm('Deseja realmente remover este registro?')) {
            $.ajax({
                type: 'POST',
                url: BASE_URL + 'bianca/remove-item/' + id,
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