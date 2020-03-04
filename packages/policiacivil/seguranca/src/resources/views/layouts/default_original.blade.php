<!doctype html>
<html lang="{{ config('app.locale') }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="{{asset('favicon.ico')}}">
    <title>{{config('policia.nome')}} - Polícia Civil do Pará</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    @yield('cabecalho')


    <style>
        /*.container {*/
        /*    width: auto;*/
        /*    max-width: 680px;*/
        /*    padding: 0 15px;*/
        /*}*/

        .footer {
            background-color: #f5f5f5;
        }

        /*.bd-placeholder-img {*/
        /*    font-size: 1.125rem;*/
        /*    text-anchor: middle;*/
        /*    -webkit-user-select: none;*/
        /*    -moz-user-select: none;*/
        /*    -ms-user-select: none;*/
        /*    user-select: none;*/
        /*}*/

        /*@media (min-width: 768px) {*/
        /*    .bd-placeholder-img-lg {*/
        /*        font-size: 3.5rem;*/
        /*    }*/
        /*}*/
    </style>
</head>

<body class="d-flex flex-column h-100">
<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
    <a class="navbar-brand" href="{{ url('') }}">{{ config('policia.nome') }}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav ml-auto">
            <!-- <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li> -->
            @if(!auth()->user())
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('seguranca/usuario') }}">Entrar</a>
                </li>
            @else
            <!-- <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li> -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">{{ auth()->user()->nome }}</a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown01">
                        <a class="dropdown-item" href="{{ url('seguranca/usuario/home') }}">Página inicial</a>
                        <a class="dropdown-item" href="{{ url('seguranca/usuario/alterar-senha') }}">Alterar senha</a>
                        <a class="dropdown-item" href="{{ url('seguranca/usuario/logout') }}">Sair</a>
                    </div>
                </li>
            @endif
        </ul>
    </div>
</nav>
<!-- Begin page content -->
{{--<main role="main" class="flex-shrink-0">--}}
{{--    <div class="container">--}}
{{--        <h1 class="mt-5">Sticky footer</h1>--}}
{{--        <p class="lead">Pin a footer to the bottom of the viewport in desktop browsers with this custom HTML and--}}
{{--            CSS.</p>--}}
{{--        <p>Use <a href="/docs/4.3/examples/sticky-footer-navbar/">the sticky footer with a fixed navbar</a> if need--}}
{{--            be, too.</p>--}}
{{--    </div>--}}
{{--</main>--}}

@yield('conteudo')

<footer class="footer mt-auto py-3">
    <div class="container">
            <span class="text-muted">&copy; {{date('Y')}} - DIME - Diretoria de Inform&aacute;tica,
                Manuten&ccedil;&atilde;o e Estat&iacute;stica.</span>
    </div>
</footer>
<script src="{{ asset('bootstrap/js/bootstrap-native-v4.min.js') }}"></script>
@yield('scripts')
</body>
</html>