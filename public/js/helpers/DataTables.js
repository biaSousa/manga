//var oTable;
var rowData;

class DataTables {
    
    constructor(params) {
        this.load(params);
    }
    
    load(params) {
        
        let id = (params.idGrid? params.idGrid : 'grid');
        
        window.console.log(id);
        
        this._oTable = $('#'+id).dataTable({
            lengthChange: false,
            bFilter: false,
            bSort: false,
            bProcessing: true,
            bServerSide: true,
            sAjaxSource: params.url,   
            //deferLoading: 0,
            oLanguage: {sUrl: BASE_URL+"/js/datatables.portugues.txt"},
            aoColumns: this.setColums(params),
            fnServerData: (sSource, aoData, fnCallback) => {                
                
                this.ajaxExecute(sSource, aoData, fnCallback);
                
            }
        });
        
        this.selectRow();
    }
    
    setColums(params) {
        var aColunas = [];         
        $.each(params.oColums, function(i, coluna){
            aColunas.push('{data: "'+coluna+'"}');
        });
        
        var colunas = aColunas.join();        
        return eval("["+colunas+"]");
    }
        
    ajaxExecute(sSource, aoData, fnCallback) {        
        $.each($('#form-pesquisa').serializeArray(), function (index, value) {
            aoData.push({name: value.name, value: value.value});
        });
        
        $.ajax({
            url: sSource,
            data: aoData,
            type: 'GET',
            dataType: 'json',
            async: false,
            success: function (json) {
                if(json.erro) {
                    $( "#mensagem" ).html(json.msg).show().delay(5000).fadeOut("slow");
                }else {
                    fnCallback(json);                    
                }
            }
        });
    }
    
    selectRow() {
        
        this._oTable.on('click', 'tr', (e) => {
            
            //verifica se a linha clicada já estava selecionada (se já possui uma class tipo "selected")
            if ( e.target.parentNode.classList.contains('selected') ) {
                
                
                //remove a class "selected" desmarcando a linha
                e.target.parentNode.classList.remove('selected');
                
                //desabilita os botões de ação
                this.desabilitaAcoes();
                
                //atribui Null a esta variável pois a linha foi desmarcada
                rowData = null;
            }
            
            //aqui a linha clicada não estava selecionada
            else {
                           
                //desmarca todas as linhas selecionadas do Grid, removendo a class "selected"
                this._oTable.$('tr.selected').removeClass('selected');
                
                
                //seleciona a linha clicada adicina a class "selected" a ela
                //$(this).addClass('selected');
                e.target.parentNode.classList.add('selected');
                
                
                //obtem um objeto com os dados da linha selecionada
                rowData = this._oTable.fnGetData(e.target.parentNode);
                
                
                //habilita os botões de ação somente se a linha selecionada for valida
                if(rowData){
                    this.habilitaAcoes();                    
                }
                
                if(typeof callback === 'function') {
                    callback(rowData);
                }
                
            }
        });
    }
    
    reloadGrid(){
        this._oTable.fnDraw();
        this.desabilitaAcoes();
    }
    
    isRowSelected() {
        if (rowData.id) {
            return true;
        } else {
            alert('Por favor selecione um registro da tabela.');
            return false;
        }
    }
    
    totalRegistros() {
        return this._oTable.fnGetData().length;
    }
    
    habilitaAcoes() {
        $('#editar, #excluir').removeClass('disabled');
    }
    
    desabilitaAcoes() {
        $('#editar, #excluir').addClass('disabled');    
    }
    
}