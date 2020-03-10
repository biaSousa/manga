class EquipamentoController {
    
    constructor() {
        this._form = document.getElementById('form');
        this._formGrid = document.getElementById('formulario');
        this._token = document.querySelector('input[name="_token"]');
        this._table = document.querySelector('#grid tbody');
        this._msgTable = "inhai bebe";
        this.carregaGrid();
    }

    pesquisa(event) {
        event.preventDefault();
        oTable.draw();
    }  

    criar(this) {
        window.location = `${BASE_URL}/equipamento/novo`;
    }
    
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

    eventoEnter(event) {
        if(event.key === 'Enter') {
            this.carregaGrid();
        }
    }

    salvar() {
        var oValida = new ValidaForm();

        if (!oValida.validaFormulario('#form')) {
            $('#msg').html(oValida.getMensagem())
                            .addClass('alert-danger')
                            .removeClass('alert-success')
                            .fadeIn()
                            .delay(7000)
                            .fadeOut();
            return false;
        }

        $('#form').ajaxSubmit({
            success: (resp) => {                
                if(resp.retorno != 'sucesso') {
                    $('#msg').html(resp.msg)
                             .addClass('alert-danger')
                             .removeClass('alert-success')
                             .fadeIn();
                }else {
                    // this.carregaGrid();

                    $('#msg').html(resp.msg)
                             .addClass('alert-success')
                             .removeClass('alert-danger')
                             .fadeIn()
                             .delay(7000)
                             .fadeOut();

                    this._form.tipoPessoa.value = '';
                }
            }
        });
    }
    
    excluir(e) {
        let linha = oTable.rows('.selected').data()[0];
        
        if (linha !== null) {
            if (confirm('Deseja excluir este item?'))
                        
            Ajax.ajax({
                url: `${e.dataset.url}/admin/usuario/excluir/`+[linha.id],
                method: 'post',
                data: {id: linha.id},
                success: (response) => {
                    alert(response.message);
                    this._excluir = true;
                    this._excluir.Tooltip.hide();
                    oTable.draw();
                },
                error: (response) => {
                    alert(response.message);
                    this._excluir = false;
                }
            });
        } else
            alert('Selecione uma item para excluir');

        return false;
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