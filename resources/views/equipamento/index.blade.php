@extends('layout.main')
@section('conteudo')
<section class="container-fluid">
    <form id="form" class="form-horizontal" method="POST" action="{{url('equipamento/search')}}">
    <input type="hidden" name="codigo" id="codigo" class="form-control" required>
        <h3>Pesquisa de Equipamentos</h3>
        <div class="panel panel-default">
            <div class="panel-body col-md-offset-2">
                {{csrf_field()}}
                <div class="row">
                    <!-- <div class="form-group">
                        <div class="col-md-9 mr-8">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Pesquisar...">
                                <span class="input-group-btn">
                                        <button type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-9 mr-2">
                            <div class="col-md-2">
                            </div>
                        </div>
                    </div> -->
                <p>Adicionar filtros bianca</p> 
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3 mr-5">
                        <label for="tipo">Tipo de Equipamento</label>
                            <select name="tipo" id="tipo" class="form-control">
                                <option value="">Selecione...</option>
                                @foreach($tipo as $p)
                                <option value="{{$p->id}}">{{$p->nome}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2 mr-5">
                        <label for="situacao">Situação</label>
                            <select name="situacao" id="situacao" class="form-control">
                                <option value="">Selecione...</option>
                                @foreach($situacao as $p)
                                <option value="{{$p->id}}">{{$p->nome}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mr-5">
                            <label for="patrimonio">Patrimônio</label>
                            <input type="patrimonio" id="patrimonio" name="patrimonio" onclick="oController.pesquisa(event)"
                            class="form-control"placeholder="xxxxxx-xxxxxx">
                        </div>
                    </div>
                </div>
                <!-- BOTÃO ADICIONAR -->
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-7 mr-5">
                            <div class="col-mr-1">
                                <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Pesquisar</button>
                            </div>
                        </div>
                        <div class="col-md-1 mr-5">
                            <div class="col-mr-1">
                                <button type="reset" class="btn btn-primary">Limpar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="row md-5 justify-content-end mr-5">
                <div class="btn-group btn-group-sm" role="group">
                    <button id="novo" type="button" class="btn btn-secondary" onclick="oController.criar(this)" base-url="{{ url('') }}" title="Criar novo" data-toggle="tooltip" data-placement="top">
                        <i class="material-icons icone">add</i>
                    </button>
                    <button id="editar" type="button" class="btn btn-secondary" onclick="oController.editar(this)" data-url="{{ url('') }}" title="Edita" data-toggle="tooltip" data-placement="top">
                        <i class="material-icons icone">edit</i>
                    </button>
                    <button id="excluir" type="button" class="btn btn-secondary" onclick="oController.excluir(this)" data-url="{{ url('') }}" title="Remove" data-toggle="tooltip" data-placement="top">
                        <i class="material-icons icone">delete</i>
                    </button>
                    <button id="reativar" type="button" class="btn btn-secondary" onclick="oController.reativar(this)" data-url="{{ url('') }}" title="Reativa" data-toggle="tooltip" data-placement="top">
                        <i class="material-icons icone">cached</i>
                    </button>
                </div>
            </div>
                <table id="grid" class="table table-striped table-bordered mb-3">
                    <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th width="8%">Patrimonio</th>
                            <th width="8%">Tipo</th>
                            <th width=10%>Modelo</th>
                            <th width="5%">Data de Entrada</th>
                        </tr> 
                    </thead> 
                    <tbody>
                    </tbody>
                </table>
    </form>
</section>

@endsection

@section('scripts')
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/jquery.form.js')}}"></script>
<script src="{{asset('js/app/helpers/Utils.js')}}"></script>
<script src="{{asset('js/app/models/Ajax.js')}}"></script>
<script src="{{asset('js/app/views/MensagemView.js')}}"></script>
<script src="{{asset('js/app/models/ValidaForm.js')}}"></script>
<script src="{{asset('js/app/helpers/GenericModalForm.js')}}"></script>
<script src="{{asset('js/app/controllers/PesquisaController.js')}}"></script>
@include('layout.datatables', ['carregamento_inicial' => true, 'colunas' => ['id', 'patrimonio', 'tipo', 'modelo', 'data_movimentacao']])
<script>
    var oController = new PesquisaController();
</script>
@endsection