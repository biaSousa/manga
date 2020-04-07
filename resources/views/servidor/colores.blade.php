@extends('layouts.default')

<link rel="stylesheet" href="{{ asset('css/menu-lateral.css') }}">


@section('menu-lateral')
<a href="{{ url('') }}" class="bg-dark">
    <i class="material-icons mr-2 menu-item-icon">home</i> Home
</a>
<a href="#" class="bg-dark menu-item-action">
    <i class="material-icons mr-2 menu-item-icon">find_in_page</i> Pesquisa
</a>
<a href="{{ url('admin/perfil/novo') }}" class="bg-dark">
    <i class="material-icons mr-2 menu-item-icon">note_add</i> Novo
</a>
@endsection


@section('conteudo')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h3">Pesquisa de perfis</h1>
</div>
<form id="form" onsubmit="oController.pesquisar(event)" action="{{url('admin/perfil/grid')}}">
    {{ csrf_field()}}
    <div class="row">
        <div class="col-sm-5">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome">
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
                <button id="novo" type="button" class="btn btn-secondary" onclick="oController.criar(this)" title="Criar novo" data-url="{{ url('') }}" data-toggle="tooltip" data-placement="top">
                    <i class="material-icons icone">add</i>
                </button>
                <button id="editar" type="button" class="btn btn-secondary" onclick="oController.editar(this)" title="alterar" data-url="{{ url('') }}" data-toggle="tooltip" data-placement="top">
                    <i class="material-icons icone">edit</i>
                </button>
                <button id="excluir" type="button" class="btn btn-secondary" onclick="oController.excluir(this)" title="excluir" data-url="{{ url('') }}" data-toggle="tooltip" data-placement="top">
                    <i class="material-icons icone">delete</i>
                </button>
            </div>
        </div>
    </div>

    <table id="grid" class="table table-striped table-bordered mb-3">
        <thead>
            <tr>
                <th class="col-3">Nome</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</form>
@endsection

@section('scripts')
<script src="{{asset('js/jquery.min.js')}}"></script>
@include('layouts.datatables', ['colunas' => ['nome']])
<script src="{{asset('js/app/models/Ajax.js')}}"></script>
<script src="{{asset('js/app/controllers/PesquisaPerfilController.js')}}"></script>
<script>
    oController = new PesquisaPerfilController();
</script>
@endsection