@extends('layouts/default')
@section('conteudo')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h3">Inclusão de Ação</h1>
</div>
<form id="form" method="post" action="{{url('seguranca/acao/store')}}" onsubmit="oController.salvar(event)">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-4 mr-5">
            <div class="form-group">
                <label for="acao">Ação *</label>
                <input type="text" name="nome" required placeholder="sugestão: modulo/controlador/acao" class="form-control form-control-sm" value="{{$acao}}">
            </div>
        </div>
        <div class="col-md-4 mr-5">
            <div class="form-group">
                <label for="descricao">Descrição</label>
                <input type="text" name="descricao" class="form-control form-control-sm">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <div class="form-group">
                <label>
                    <input class="checkbox-inline" type="checkbox" id="destaque" onclick="destaque()" name="destaque"> Destaque(aparece para o usuário na tela de permissões do perfil)
                </label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mr-5">
            <div class="form-group">
                <div id="div_amigavel" class="form-group" style="display:none">
                    <label>Nome amigável *</label>
                    <div class="col-md-6 mr-5">
                        <input type="text" name="nome_amigavel" class="form-control" placeholder="Ex: Cadastrar usuário">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <legend>Dependências</legend>
    <div class="row">
        <div class="col-md-4 mr-5">
            <div class="form-group">
                <label for="acao2">Ação</label>
                <select id="acao2" class="form-control form-control-sm">
                    <option value="">selecione</option>
                    @foreach($aAcao as $acao)
                    <option value="{{$acao->id}}">{{$acao->nome}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="rowmt-3 justify-content-end mr-1">
        <div class="btn-group btn-group-sm" role="group">
            <button type="button" class="btn btn-secondary" id="adicionar" onclick="oController.adicionarAcao()" title="atribuir ação ao usuário">
                <i class="material-icons icone">add</i>
            </button>
            <button type="button" class="btn btn-secondary" id="remover" onclick="oController.removerAcao()" title="remover ação do usuário">
                <i class="material-icons icone">delete</i>
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mr-5">
            <div class="form-group">
                <div id="conteudo_grid">
                    <table id="grid" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <div class="form-group">
                <div id="snackbar" role="alert">
                    <button type="button" class="close">
                        <span aria-hidden="true"></span></button>
                    <div id="msg"></div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="form-group">
            <div class="col-sm-3 col-sm-offset-2">
                <button type="submit" id="salvar" class="btn btn-primary">Salvar</button>
            </div>
        </div>
        <div class="form-group">
            <button id="cancelar" class="btn btn-light" href="{{url('seguranca/acao')}}">Cancelar</button>
        </div>
    </div>
    <div id="mensagem" class="alert alert-danger col-sm-6 col-sm-offset-2" style="display: none;"></div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
</form>
@endsection
@section('scripts')
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/app/models/Ajax.js')}}"></script>
<script src="{{asset('js/app/views/Mensagem.js')}}"></script>
<script src="{{asset('js/app/views/Snackbar.js')}}"></script>
<script src="{{asset('js/app/controllers/SegAcaoController.js')}}"></script>
@include('Seguranca::layouts/datatables-simples', ['colunas' => ['acao']])
<script>
    oController = new SegAcaoController();
</script>
@endsection