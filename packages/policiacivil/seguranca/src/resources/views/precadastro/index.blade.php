@extends('layouts.default')
@section('conteudo')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h3">Solicitação de acesso</h1>
</div>
<form id="form" action="{{url('admin/solicitar-acesso/grid')}}" onclick="oController.pesquisar(event)">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-sm-5">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" class="form-control">
            </div>
        </div>
        <div class="col-sm-5">
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" class="form-control">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <div class="form-group">
                <label for="cpf">CPF</label>
                <input type="text" id="cpf" name="cpf" class="form-control">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <div class="col-sm col-sm-offset-2">
                <button type="submit" id="pesquisar" class="btn btn-primary" onclick="oController.pesquisar(event)">Pesquisar</button>
            </div>
        </div>
    </div>
    <div class="row mt-2 justify-content-end mr-1">
        <div class="btn-group btn-group-sm" role="group">
            <button id="novo" type="button" onclick="oController.criar(this)" class="btn btn-secondary" title="Criar novo" data-url="{{ url('') }}" data-toggle="tooltip" data-placement="top">
                <i class="material-icons icone">add</i>
            </button>
            <button id="editar" type="button" onclick="oController.editar(this)" class="btn btn-secondary" title="Edita" data-url="{{ url('') }}" data-toggle="tooltip" data-placement="top">
                <i class="material-icons icone">edit</i>
            </button>
            <button id="excluir" type="button" onclick="oController.delete(this)" class="btn btn-secondary" title="Remove" data-url="{{ url('') }}" data-toggle="tooltip" data-placement="top">
                <i class="material-icons icone">delete</i>
            </button>
        </div>
    </div>
    <table id="grid" class="table table-striped table-bordered mb-3">
        <thead>
            <tr>
                <th class="col-sm-1">Nome</th>
                <th class="col-sm-3">E-mail</th>
                <th class="col-sm-3">Data</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</form>
@endsection
@section('scripts')
<script src="{{asset('js/app/models/Ajax.js')}}"></script>
<script src="{{asset('js/vanillaTextMask.js')}}"></script>
@include('layouts.datatables', ['colunas' => ['nome', 'email', 'nascimento']])
<script src="{{asset('js/app/controllers/PesquisarSolicitacaoAcessoController.js')}}"></script>
<script>
    oController = new PesquisarSolicitacaoAcessoController();
</script>
@endsection