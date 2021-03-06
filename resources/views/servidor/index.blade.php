@extends('layout.main')
@section('conteudo')
<section class="container-fluid">
    <form id="form" class="form-horizontal" method="post" action="{{url('servidor/gridServidor')}}">
        <h3>Pesquisa de Servidores</h3>
        <div class="panel panel-default">
            <div class="panel-body col-md-offset-2">
                {{csrf_field()}}
    <input type="hidden" name="id" id="id" class="form-control" required>
                <!-- <div class="row">
                    <div class="form-group">
                        <div class="col-md-9 mr-8">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Pesquisar...">
                                <span class="input-group-btn">
                                    <a type="button" class="btn btn-default"><i class="fa fa-search"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3 mr-5">
                            <label for="cpf">CPF</label>
                            <input type="text" id="cpf" name="cpf" class="form-control">
                        </div>
                        <div class="col-md-3 mr-5">
                            <label for="servidor">Servidor</label>
                            <input type="text" id="servidor" name="servidor" class="form-control">
                        </div>
                        <div class="col-md-3 mr-5">
                            <label for="unidade">Unidade</label>
                            <select name="unidade" id="unidade" class="form-control">
                                <option value="">Selecione...</option>
                                @foreach($unidade as $p)
                                <option value="{{$p->id}}">{{$p->nome}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- BOTÃO PESQUISAR -->
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-7 mr-5">
                            <div class="col-mr-1">
                                <button type="submit" class="btn btn-primary" >
                                <i class="glyphicon glyphicon-search" onsubmit="oController.pesquisar(e)"></i> Pesquisar</button>
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
            <!-- <div class="row md-5 justify-content-end mr-5"> -->
                <!-- <div class="btn-group btn-group-sm" role="group">
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
                </div> -->
            </div>
                <table id="grid" class="table table-striped table-bordered mb-3">
                    <thead>
                        <tr>
                            <th width="2%">ID</th>
                            <th width="5%">Nome</th>
                            <th width="5%">Unidade</th>
                            <th width="3%">Setor</th>
                            <th width="3%">CPF</th>
                            <th width="3%">Matrícula</th>
                            <th width="3%">Cargo</th>
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
@include('layout.datatables', ['carregamento_inicial' => true, 'colunas' => ['id', 'nome', 'unidade', 'setor', 'cpf', 'matricula', 'cargo']])
<script src="{{asset('js/app/models/Ajax.js')}}"></script>
<script src="{{asset('js/vanillaTextMask.js') }}"></script>
<script src="{{asset('js/app/models/ListaErrors.js') }}"></script>
<script src="{{asset('js/app/controllers/PesquisaController.js')}}"></script>
<script>
    var oController = new PesquisaController();
</script>
@endsection