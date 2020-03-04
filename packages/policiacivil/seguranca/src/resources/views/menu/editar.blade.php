@extends('layouts.default')
@section('conteudo')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h3">Editar Menu</h1>
</div>
<form id="form" method="post" action="{{url('seguranca/menu/update')}}" onsubmit="oController.salvar(event)">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-4 mr-5">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" class="form-control form-control-sm" value="{{$oMenu->nome}}">
            </div>
        </div>
        <div class="col-md-4 mr-5">
            <div class="form-group">
                <label for="ordem">Ordem</label>
                <input type="text" id="ordem" name="ordem" class="form-control form-control-sm" value="{{$oMenu->ordem}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mr-5">
            <div class="form-group">
                <label for="pai">Pai</label>
                <select class="form-control form-control-sm" name="pai" id="pai">
                    <option value="">SELECIONE</option>
                    @foreach($aPai as $menu_raiz)
                    <option value="{{$menu_raiz->id}}" {{$menu_raiz->id == $oMenu->pai ? 'selected' : null}}>{{$menu_raiz->nome}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4 mr-5">
            <div class="form-group">
                <label for="dica">Dica</label>
                <input type="text" id="dica" name="dica" value="{{$oMenu->dica}}" class="form-control form-control-sm">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mr-5">
            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" id="status" name="status" {{$oMenu->status ? 'checked' : null}}> Ativo
                    </label>
                </div>
            </div>
        </div>
    </div>
    <legend>Ação do Menu</legend>
    <div class="row">
        <div class="col-md-4 mr-5">
            <div class="form-group">
                <label for="acao">Ação:</label>
                <select class="form-control form-control-sm" name="acao" id="acao">
                    <option value="">SELECIONE</option>
                    @foreach($aAcao as $acao)
                    <option value="{{$acao->id}}" {{$acao->id == $oMenu->acao_id ? 'selected' : null}}>{{$acao->nome_amigavel}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mr-5">
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
            <button id="cancelar" class="btn btn-light" href="{{url('seguranca/menu')}}">Cancelar</button>
        </div>
    </div>
    <input type="hidden" name="menu" value="{{$oMenu->id}}">
</form>
@endsection
@section('scripts')
<script src="{{asset('js/app/models/Ajax.js')}}"></script>
<script src="{{asset('js/app/views/Mensagem.js')}}"></script>
<script src="{{asset('js/app/views/Snackbar.js')}}"></script>
<script src="{{asset('js/app/controllers/EditarMenuController.js')}}"></script>
<script>
    oController = new EditarMenuController();
</script>
@endsection