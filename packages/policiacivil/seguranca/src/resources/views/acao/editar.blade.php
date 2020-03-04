@extends('layouts.default')
@section('conteudo')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h3">Editar Ação</h1>
</div>
<form id="form" action="{{url('seguranca/acao/update')}}">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-4 mr-5">
            <div class="form-group">
                <label for="acao">Ação*</label>
                <input type="text" id="acao" name="nome" value="{{$oAcao->nome}}" class="form-control form-control-sm" placeholder="sugestão: modulo/controlador/acao" required>
            </div>
        </div>
        <div class="col-md-4 mr-5">
            <div class="form-group">
                <label for="descricao">Descrição</label>
                <input type="text" id="descricao" name="descricao" value="{{$oAcao->descricao}}" onclick="destaque()" class="form-control form-control-sm">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mr-5">
            <div class="form-group">
                <div class="checkbox col-sm-offset-2">
                    <label>
                        <input type="checkbox" id="destaque" {{$oAcao->destaque ? 'checked' : null}} name="destaque"> Destaque (aparece para o usuário na tela de permissões do perfil)
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mr-5">
            <div id="div_amigavel" class="form-group" style="display:none">
                <label>Nome amigável *</label>
                <div class="col-md-6 mr-5">
                    <input type="text" name="nome_amigavel" value="{{$oAcao->nome_amigavel}}" class="form-control" placeholder="Ex: Cadastrar usuário">
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
            <div id="conteudo_grid">
                <table id="grid" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($aDependencia as $d)
                        <tr id="{{$d->id}}">
                            <td>
                                {{$d->nome}}
                                <input type="hidden" name="dependencia[]" value="{{$d->id}}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
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
                <button type="submit" id="salvar" class="btn btn-primary" onsubmit="oController.salvar(event)">Salvar</button>
            </div>
        </div>
        <div class="form-group">
            <button id="cancelar" class="btn btn-light" href="{{url('seguranca/acao')}}">Cancelar</button>
        </div>
    </div>
    <input type="hidden" name="id" value="{{$oAcao->id}}">
</form>
@endsection
@section('scripts')
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/app/models/Ajax.js')}}"></script>
<script src="{{asset('js/app/views/Snackbar.js')}}"></script>
<script src="{{asset('js/app/views/Mensagem.js')}}"></script>
<script src="{{asset('js/app/controllers/EditarAcaoController.js')}}"></script>
@include('layouts/datatables-simples', ['colunas' => ['acao']])
<script>
    oController = new EditarAcaoController();
</script>
@endsection