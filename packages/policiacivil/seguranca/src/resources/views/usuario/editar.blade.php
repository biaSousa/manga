@extends('layouts.default')
@section('conteudo')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h3">Editar Usuário</h1>
</div>
<form id="form" method="post" action="{{url('seguranca/usuario/update')}}" onsubmit="oController.salvar(event)">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-4 mr-5">
            <div class="form-group">
                <label for="nome">Nome *</label>
                <input type="text" id="nome" name="nome" class="form-control form-control-sm" value="{{$oUsuario->nome}}" required>
            </div>
        </div>
        <div class="col-md-4 mr-5">
            <div class="form-group">
                <label for="email">E-mail *</label>
                <input type="email" id="email" name="email" class="form-control form-control-sm" value="{{$oUsuario->email}}" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 mr-6">
            <div class="form-group">
                <label for="senha">Senha *</label>
                <input type="password" id="senha" name="senha" class="form-control form-control-sm">
            </div>
        </div>
        <div class="col-md-2 mr-5">
            <div class="form-group">
                <label label for="senha_confirmation">Confirmar Senha *</label>
                <input type="password" id="senha_confirmation" name="senha_confirmation" class="form-control form-control-sm">
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label label for="CPF">CPF</label>
                <input type="text" id="cpf" name="cpf" class="form-control form-control-sm" value="{{$oUsuario->cpf}}">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="nascimentp">Data de nascimento</label>
                <input type="date" name="nascimento" id="nascimento" class="form-control form-control-sm" value="{{ $oUsuario->nascimento }}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mr-5">
            <div class="form-group">
                <label for="unidade">Unidade *</label>
                <select class="form-control form-control-sm" name="unidade" id="unidade" onchange="oController.changeUnidade()" required>
                    <option value="">Selecione</option>
                    @foreach($aUnidade as $p)
                    <option value="{{$p->id}}" {{ $oUsuario->id == $p->id ? 'selected' : '' }}>{{$p->nome}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4 mr-5">
            <label>
                <input type="checkbox" id="diretor" name="diretor" {{ $oUsuario->diretor ? 'checked' : '' }} onclick="oController.adicionarDiretor()" value="1"> Diretor Responsável
            </label>
        </div>
    </div>
    <!-- perfil -->
    <div class="row">
        <div class="col-md-4 mr-5">
            <div class="form-group">
                <legend>Perfis <small>(somente para o sistema atual)</small></legend>
                <select id="perfil2" class="custom-select form-control">
                    <option value="">selecione</option>
                    @foreach($aPerfisCadastrados as $p)
                    <option value="{{$p->id}}">{{$p->nome}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <!-- sistema -->
        <div class="col-md-4 mr-5">
            <div class="form-group">
                <legend>Sistemas</legend>
                <select id="sistema2" class="custom-select form-control">
                    <option value="">selecione</option>
                    @foreach($aSistema as $p)
                    <option value="{{$p->id}}">{{$p->nome}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <!-- perfil button -->
    <div class="row">
        <div class="col-md-4 mr-5">
            <div class="form-group">
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-secondary" id="adicionar" onclick="oController.adicionarPerfil()" title="atribuir perfil ao usuário">
                        <i class="material-icons icone">add</i>
                    </button>
                    <button type="button" class="btn btn-secondary" id="remover" onclick="oController.removerPerfil()" title="remover perfil do usuário">
                        <i class="material-icons icone">delete</i>
                    </button>
                </div>
            </div>
        </div>
        <!-- sistema button -->
        <div class="col-md-4 mr-5">
            <div class="form-group">
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-secondary" onclick="oController.adicionarSistema()" title="Permitir que usuário acesse este sistema">
                        <i class="material-icons icone">add</i>
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="oController.removerSistema()" title="Remover permissão do usuário a este sistema">
                        <i class="material-icons icone">delete</i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- perfil grid -->
    <div class="row">
        <div class="col-md-4 mr-5">
            <div class="form-group">
                <div id="conteudo_grid">
                    <table id="grid" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Perfil</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($aPerfilUsuario as $p)
                            <tr id="{{$p->id}}">
                                <td>
                                    {{$p->nome}}
                                    <input type="hidden" name="perfil[]" value="{{$p->id}}">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- sistema grid -->
        <div class="col-md-4 mr-5">
            <div class="form-group">
                <div id="sistemas_grid">
                    <table id="grid2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Sistema</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($aSistemasUsuario as $a)
                            <tr id="{{$a->id}}" class="odd" role="row">
                                <td>
                                    {{$a->nome}}
                                    <input value="{{$a->id}}" name="sistema[]" type="hidden">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="checkbox col-sm-offset-2">
            <label>
                <input type="checkbox" id="trocar_senha" name="trocar_senha"> Forçar troca de senha no próximo login
            </label>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <div class="form-group">
                <div id="snackbar" role="alert">
                    <button type="button" class="close">
                        <span aria-hidden="true"></span></button>
                    <div id="msg" style="text-align:center"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            <div class="col-sm-3 col-sm-offset-2">
                <button type="submit" id="salvar" class="btn btn-primary">Salvar</button>
            </div>
        </div>
        <div class="form-group">
            <a id="cancelar" class="btn btn-secondary" href="{{ url('seguranca/usuario/admin') }}">Cancelar</a>
        </div>
    </div>
    <div id="mensagem" class="alert alert-danger col-sm-6 col-sm-offset-2" style="display: none;"></div>
    <input type="hidden" name="id" value="{{$oUsuario->id}}">
    {{ csrf_field() }}
</form>
@endsection
@section('scripts')
<script src="{{asset('js/jquery.min.js')}}"></script>
@include('Seguranca::layouts.datatables-simples', ['colunas' => ['perfil']])
@include('Seguranca::layouts.datatables-simples2', ['colunas' => ['sistema'], 'id' => 'grid2'])
<script src="{{asset('js/vanillaTextMask.js')}}"></script>
<script src="{{asset('js/app/models/Ajax.js')}}"></script>
<script src="{{asset('js/app/views/Mensagem.js')}}"></script>
<script src="{{asset('js/app/views/Snackbar.js')}}"></script>
<script src="{{asset('js/app/controllers/SegUsuarioController.js')}}"></script>
<script>
    oController = new SegUsuarioController();
</script>
@endsection