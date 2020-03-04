@extends('layouts.default')
@section('conteudo')
    <div id="app">

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h3">Pesquisa de Ações</h1>
        </div>
        <form id="form" method="post" action="{{url('seguranca/acao/grid')}}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" id="nome" name="nome" class="form-control">
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

            <tabela-paginada
                :fields="[{key: 'first_name', label: 'bem legal'}]">

            </tabela-paginada>
        </form>
    </div>
@endsection
@section('scripts')
<script src="{{asset('js/app/models/Ajax.js')}}"></script>
{{--<script src="{{asset('js/app/controllers/PesquisarAcaoController.js')}}"></script>--}}
<script src="{{ asset('js/vue.js') }}"></script>
<script src="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.js"></script>
<script type="module">
    // oController = new PesquisarAcaoController();
    import TabelaPaginada from '{{ asset('js/components/TabelaPaginada.js') }}'

    new Vue({
        el: '#app',
        components: {
            TabelaPaginada
        }
    });
</script>
@endsection