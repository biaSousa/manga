@extends('layouts.default')
@section('conteudo')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h3">Pesquisa de usuários</h1>
</div>
<form id="form" method="post" action="{{url('seguranca/usuario/grid')}}">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-4 mr-5">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" class="form-control form-control-sm">
            </div>
        </div>
        <div class="col-md-4 mr-5">
            <div class="form-group">
                <label class="col-sm-4 control-label">Sistema:</label>
                <div class="col-sm-8">
                    <select name="sistema" class="form-control form-control-sm">
                        <option value="">SELECIONE</option>
                        @foreach($oSistema as $s)
                        <option value="{{$s->id}}">{{$s->nome}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mr-5">
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" class="form-control form-control-sm">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <div class="col-md-4 mr-5">
                <button type="submit" id="pesquisar" class="btn btn-primary" onclick="oController.pesquisar(event)">Pesquisar</button>
            </div>
        </div>
    </div>
    <div class="row mt-3 justify-content-end mr-1">
        <div>
            <div class="btn-group btn-group-sm" role="group">
                <button id="novo" type="button" onclick="oController.criar(this)" class="btn btn-secondary" data-url="{{ url('') }}" title="Criar novo" data-placement="top" data-toggle="modal" data-target="#exampleModal">
                    <i class="material-icons icone">add</i>
                </button>
                <button id="editar" type="button" onclick="oController.editar(this)" class="btn btn-secondary" data-url="{{ url('') }}" title="Edita" data-toggle="tooltip" data-placement="top">
                    <i class="material-icons icone">edit</i>
                </button>
                <button id="excluir" type="button" onclick="oController.excluir(this)" class="btn btn-secondary" data-url="{{ url('') }}" title="Delete" data-toggle="tooltip" data-placement="top">
                    <i class="material-icons icone">delete</i>
                </button>
            </div>
        </div>
    </div>
    <table id="grid" class="table table-striped table-bordered mb-3">
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="">Nome</th>
                <th width="">E-mail</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</form>
@endsection
@section('scripts')
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/app/models/Ajax.js')}}"></script>
<script src="{{asset('js/app/controllers/PesquisarUsuarioController.js')}}"></script>
@include('layouts.datatables', ['carregamento_inicial' => true, 'colunas' => ['id', 'nome', 'email']])
<script>
    oController = new PesquisarUsuarioController();
</script>
@endsection