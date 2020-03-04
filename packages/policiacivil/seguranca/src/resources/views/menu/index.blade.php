@extends('layouts.default')
@section('conteudo')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h3">Pesquisa de menus</h1>
</div>
<form id="form" action="{{url('seguranca/menu/grid')}}">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-4 mr-5">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control form-control-sm" id="nome" name="nome">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <div class="col-sm-3 col-sm-offset-2">
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
                <button id="excluir" type="button" onclick="oController.excluir(this)" class="btn btn-secondary" data-url="{{ url('') }}" title="Remove" data-toggle="tooltip" data-placement="top">
                    <i class="material-icons icone">delete</i>
                </button>
            </div>
        </div>
    </div>
    <table id="grid" class="table table-striped table-bordered mb-3">
        <thead>
            <tr>
                <th class="col-3">Nome no menu</th>
                <th class="col-3">Pai</th>
                <th class="col-3">Ação (amigável)</th>
                <th class="col-2">Ação</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</form>
@endsection
@section('scripts')
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/app/models/Ajax.js')}}"></script>
<script src="{{asset('js/app/controllers/PesquisarMenuController.js')}}"></script>
@include('layouts.datatables', ['colunas' => ['nome', 'pai', 'nome_amigavel', 'acao']])
<script>
    oController = new PesquisarMenuController();
</script>
@endsection