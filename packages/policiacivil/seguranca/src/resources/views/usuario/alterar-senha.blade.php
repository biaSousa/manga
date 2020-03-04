@extends('layouts.default')

@section('conteudo')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Atualizar Senha</h1>
        {{--                <div class="btn-toolbar mb-2 mb-md-0">--}}
        {{--                    <div class="btn-group mr-2">--}}
        {{--                        <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>--}}
        {{--                        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>--}}
        {{--                    </div>--}}
        {{--                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">--}}
        {{--                        <span data-feather="calendar"></span>--}}
        {{--                        This week--}}
        {{--                    </button>--}}
        {{--                </div>--}}
    </div>
    <main class="container-fluid">
        <form id="formulario" action="{{ url('seguranca/usuario/atualizar-senha') }}" method="post"
              @submit.prevent="salvar($event)">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-3 mb-2">
                    <label for="senha_atual">Senha atual</label>
                    <input type="password" name="senha_atual" id="senha_atual" class="form-control" minlength="8"
                           required>
                    <small class="form-text text-muted">
                        Mínimo 8 caracteres
                    </small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-2">
                    <label for="nova_senha">Nova senha</label>
                    <input type="password" name="nova_senha" id="nova_senha" class="form-control" required minlength="8">
                    <small class="form-text text-muted">
                        Mínimo 8 caracteres
                    </small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-2">
                    <label for="nova_senha_confirmation">Confirmar senha</label>
                    <input type="password" name="nova_senha_confirmation" id="nova_senha_confirmation"
                           class="form-control" required minlength="8">
                </div>
            </div>

            {{--            <div class="alert alert-danger mt-3" v-if="exibirErro">--}}
            {{--                <ul>--}}
            {{--                    <li v-for="erro in erros" v-text="erro"></li>--}}
            {{--                </ul>--}}
            {{--            </div>--}}
            <br>

            <validation-errors :errors="validationErrors" v-if="validationErrors"></validation-errors>

            <div class="row">
                <div class="col-md-3 mb-3 mt-3">
                    <button typeof="button" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </form>
    </main>
@endsection

@section('scripts')
    <script src="{{ asset('js/vue.js') }}"></script>

    <script type="module">
        {{--import validationErrors from "{{ asset('js/app/componentes/validation-errors.js') }}"--}}

        Vue.component('validation-errors', {
            props: ['errors'],
            template: `
                <div class="alert alert-danger" v-if="validationErrors">
                    <ul>
                        <li v-for="(value, key, index) in validationErrors" v-text="value"></li>
                    </ul>
                </div>
            `,
            computed: {
                validationErrors() {

                    let errors = Object.values(this.errors);
                    errors = errors.flat();
                    return errors;
                }
            }
        });


        let app = new Vue({
            el: '#formulario',
            data: {
                erros: [],
                validationErrors: ''
            },
            computed: {
                exibirErro() {
                    return this.erros.length > 0;
                }
            },
            methods: {
                salvar(e) {
                    let form = new FormData(e.target);

                    fetch(e.target.action, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-Token': e.target._token.value
                        },
                        method: 'POST',
                        body: form
                    })
                        .then(r => r.json())
                        .then(r => {
                            if(r.errors)
                                this.validationErrors = r.errors;

                            if(r.message) {
                                this.validationErrors = {'message': r.message};
                            }

                        })
                }
            },
            components: {
                validationErrors
            }
        });

    </script>
@endsection