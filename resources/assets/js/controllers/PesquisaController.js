class PesquisaController {
    
    constructor() {
        this._form = document.getElementById('form');
        this._grid = document.getElementById('grid');
        // this._token = document.querySelector('input[name="_token"]');
        this._table = document.querySelector('#grid tbody');
        this._msgTable = "inhai bebe";
        // this.carregaGrid();
        //never gonna give a fuck
    }

    pesquisar(e) {
        e.preventDefault();
        this._table.draw();
    }  

    criar(this) {
        window.location = `${BASE_URL}/equipamento/novo`;
    }
    
    carregaGrid() {        
        $.ajax({
            type: 'get',
            url: BASE_URL+'/equipamento/gridPesquisa',
            data: this._form.serialize(),
            dataType: 'json',
            success: (response) => {
                var data = response.data;
                var size = data.length;
                var linha = '';
                
                if(size > 0) {
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
    
    // salvar() {
    //     var oValida = new ValidaForm();

    //     if (!oValida.validaFormulario('#form')) {
    //         $('#msg').html(oValida.getMensagem())
    //                         .addClass('alert-danger')
    //                         .removeClass('alert-success')
    //                         .fadeIn()
    //                         .delay(7000)
    //                         .fadeOut();
    //         return false;
    //     }
    //     $('#form').ajaxSubmit({
    //         success: (resp) => {                
    //             if(resp.retorno != 'sucesso') {
    //                 $('#msg').html(resp.msg)
    //                          .addClass('alert-danger')
    //                          .removeClass('alert-success')
    //                          .fadeIn();
    //             }else {
    //                 this.carregaGrid();

    //                 $('#msg').html(resp.msg)
    //                          .addClass('alert-success')
    //                          .removeClass('alert-danger')
    //                          .fadeIn()
    //                          .delay(7000)
    //                          .fadeOut();
    //             }
    //         }
    //     });
    // }
    
    excluir(e) {
        let linha = oTable.rows('.selected').data()[0];
        
        if (linha !== null) {
            if (confirm('Deseja excluir este item?'))
                        
            Ajax.ajax({
                url: `${e.dataset.url}/equipametno/excluir/`+[linha.id],
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
    oController = new PesquisaController();