class EquipamentoController {
    
    constructor() {
        this._form = document.getElementById('form');
        this._tipo = document.getElementById('tipo');
        this._marca = document.getElementById('marca');
        this._modelo = document.getElementById('modelo');
        this._unidade = document.getElementById('unidade');
        this._garantia = document.getElementById('garantia');
        this._descricao = document.getElementById('decricao');
        this._patrimonio = document.getElementById('patrimonio');
        this._datacompra = document.getElementById('data_compra');
        this._notafiscal = document.getElementById('nota_fiscal');

        this._formGrid = document.getElementById('formulario');
        this._token = document.querySelector('input[name="_token"]');
        this._table = document.querySelector('#grid tbody');
        this._msgTable = "inhai bebe";
        this.carregaGrid();
    }

    //by patrimonio/num_serie show dados do equipamento
    eventoEnter(event) {
        if(event.key === 'Enter') {
            this.carregaPatrimonio();
        }
    }

    carregaPatrimonio()
    {
        this._tipo.value = '';
        this._marca.value = '';
        this._modelo.value = '';
        this._unidade.value = '';
        this._garantia.value = '';
        this._descricao.value = '';
        this._datacompra.value = '';
        this._notafiscal.value = '';

        Ajax.ajax({
            url: this._patrimonio.dataset.url,
            data: {patrimonio: this._patrimonio.value},
            success: (e) => {
                if(e.id) {
                    // this._email.disabled = true;
                    // this._senha.disabled = true;
                    // this._senhaConfirmation.disabled = true;

                    $('#msg-info').html(`Equipamento <b>${e.patrimonio}</b> carregado.`).removeClass('d-none');
                }

                this._tipo.value = e.fk_tipo;
                this._marca.value = e.fk_marca;
                this._modelo.value = e.fk_modelo;
                this._unidade.value = e.fk_unidade;
                this._garantia.value = e.fk_garantia;
                this._descricao.value = e.descricao;
                this._datacompra.value = e.data_compra;
                this._notafiscal.value = e.nota_fiscal;
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

    // adicionarEquipamento() {
    //     if (!this._perfil.value) return;

    //     if (this._grid.querySelectorAll(`tbody tr[id="${this._perfil.value}"]`).length > 0) {
    //         return false;
    //     }

    //     oTable.row.add({
    //         'DT_RowId': this._perfil.value,
    //         'perfil': this._perfil.options[this._perfil.selectedIndex].text + '<input type="hidden" value="' + this._perfil.value + '" name="perfil[]">'
    //     }).draw();
    // }

    // removerPerfil() {
    //     oTable.rows('.selected').remove().draw();
    // }

    carregaGrid() {        
        $.ajax({
            type: 'GET',
            url: BASE_URL+'/equipamento/grid',
            data: this._formGrid.serialize(),
            dataType: 'json',
            success: (response) => {
                var data = response.data;
                var size = data.length;
                var linha = '';
                
                if(size > 0) {
                    for(let i=0; i<size; i++){
                        
                        linha += `<tr>
                            <td>${data[i].tipo_conta}</td>
                            <td>${data[i].tipo_fonte}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" onclick="oController.remover(${data[i].id})">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </button>
                            </td>
                        </tr>`;
                    }
                    this._table.innerHTML = linha;
                    }else {
                    this._table.innerHTML = `<tr><td colspan="3" align="center">${this._msgTable}</td></tr>`;
                    }
                
            }
        });
    }
    
    //novo salvar
    salvar(e) {
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