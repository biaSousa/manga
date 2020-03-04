@extends('layouts.default')
@section('conteudo')
<section class="container">
    <form class="container" action="{{url('cadastro/store')}}" method="post">
        {{csrf_field()}}
        <fieldset>
            <legend>Solicitação de acesso</legend>
        </fieldset>
        <div class="alert {{isset($sucesso) ? 'alert-success' : 'alert-info'}}" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            @if(isset($sucesso))
            Solicitação
            enviada com sucesso.<br>
            @endif Seu login só será ativado depois de aprovado pelo administrador deste sistema.
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" name="nome" id="nome" required value="{{old('nome')}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" class="form-control" name="email" id="email" required style="text-transform:lowercase!important" value="{{old('email') ? old('email') : $email}}" readonly>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                    <label for="cpf">CPF:</label>
                    <input type="text" class="form-control" name="cpf" id="cpf" required value="{{old('cpf') ? old('cpf') : $cpf}}" readonly>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                    <label for="nascimento">Nascimento:</label>
                    <input type="text" class="form-control" name="nascimento" id="nascimento" required value="{{old('nascimento')}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="unidade">Unidade que está lotado:</label>
                    <input type="text" class="form-control" name="unidade" id="unidade" required value="{{old('unidade')}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" class="form-control" name="senha" id="senha" minlength="8" required>
                    <span class="help-block">Mínimo de 8 dígitos</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                    <label for="senha_confirmacao">Senha:</label>
                    <input type="password" class="form-control" name="senha_confirmation" id="senha_confirmation" minlength="8" required>
                </div>
            </div>
        </div>
        <br> @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <button class="btn btn-primary">Enviar solicitação</button>
        <a href="{{ url('cadastro') }}" class="btn btn-default">Voltar</a>
    </form>
    <br>
</section>
@endSection
@section('scripts')
<script src="{{asset('js/vanillaTextMask.js')}}"></script>
<script src="{{asset('js/app/controllers/SolicitarAcessoController.js')}}"></script>
<script>
    oController = new SolicitarAcessoController();
</script>
@endSection