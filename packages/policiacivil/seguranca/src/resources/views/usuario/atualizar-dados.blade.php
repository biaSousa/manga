@extends('layouts.default')
@section('conteudo')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Atualize seus dados</h1>
    </div>
    <form id="form" class="form-horizontal container" method="POST"
          action="{{url('seguranca/usuario/atualizar-dados')}}">
        {{ csrf_field() }}

        <div class="form-group">
            <label class="col-sm-2 control-label">CPF *</label>
            <div class="col-sm-2">
                <input type="text" name="cpf" id="cpf" required class="form-control" value="{{old('cpf')}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Data de nascimento *</label>
            <div class="col-sm-2">
                <input type="text" name="nascimento" id="nascimento" class="form-control" required
                       value="{{old('nascimento')}}">
            </div>
        </div>
        @if ($errors->any())
            <div id="mensagem" class="alert alert-danger col-sm-6 col-sm-offset-2">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="form-group">
            <div class="col-sm-5 col-sm-offset-2">
                <button type="submit" class="btn btn-primary" id="salvar">Salvar</button>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script src="{{asset('js/vanillaTextMask.js')}}"></script>
    <script src="{{asset('js/app/controllers/AtualizarDadosController.js')}}"></script>
    <script>
        oController = new AtualizarDadosController();
    </script>
@endsection
