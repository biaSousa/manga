@extends('layouts.default')
@section('conteudo')
<main class="container">
    <div class="alert {{isset($sucesso) ? 'alert-success' : 'alert-info'}}" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        @if(isset($sucesso))
        Solicitação enviada com sucesso.<br>
        @endif
        Seu login só será ativado depois de aprovado pelo administrador deste sistema.
    </div>
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">Passo 1 - Solicitar acesso</div>
            <div class="panel-body">
                <form method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="cpf">CPF</label>
                        <input type="text" name="cpf" id="cpf" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script src="{{ asset('js/vanillaTextMask.js') }}"></script>
<script src="{{ asset('js/app/controllers/Passo1Controller.js') }}"></script>
<script>
    oController = new Passo1Controller();
</script>
@endsection