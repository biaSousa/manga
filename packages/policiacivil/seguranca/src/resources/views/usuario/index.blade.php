<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Polícia</title>
    <link href="{{ asset('materialize-css/materialize.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
        }

        .box {
            border: 1px solid #dadce0;
            border-radius: 10px;
            padding: 30px 0;
            float: none;
            width: 450px;
            position:absolute;
            left:50%;
            top:50%;
            margin-left:-225px;
            margin-top:-250px;
        }

        .corpo {
            padding: 15px 40px 0px;
        }

        .cabeca {
            text-align: center;
        }

        .cabeca img {
            width: 48px;
        }

        .cabeca h1 {
            color: #555;
            font-weight: 300;
            font-size: 22px;
            font-weight: normal;
            margin: 0 0 15px;
        }

        .cabeca h2 {
            color: #3c3c3c;
            font-weight: 300;
            font-size: 18px;
            font-weight: normal;
            margin: 0 0 15px;
        }

        .corpo input {
            padding: 15px;
            font-size: 16px;
            height: 20px;
            color: #777;
            border: 1px solid #ccc;
        }

        .corpo a {
            font-size: 14px;
        }

        .pe {
            padding: 0px 40px;
            text-align: center;
        }

        .pe div {
            padding: 10px 0;
            clear: both;

            color: #555;
            font-size: 12px;
        }

        .pe .letreiro {
            text-align: justify !important;
        }

        .pe .letreiro i, .pdtp {
            padding-top: 10px;
        }

        .indicator {
            display: none;
            height: 30px;
            padding: 8px;
            position: absolute;
            right: 5px;
            text-align: center;
            top: 5px;
            width: 30px;
        }

        .indicator.on {
            display: block
        }
    </style>
</head>
<body>

<div class="box">
    <div class="cabeca">
        <a href="index.html"><img class="logo" src="{{asset('images/policia2.png')}}"/></a>
        <h1>Polícia Civil do Estado do Pará</h1>
        <h2>Acessar {{config('policia.nome')}}</h2>
        <?php if (config('app.env') == 'local'): ?>
        <h1 style="color: red; text-decoration: blink;">DESENVOLVIMENTO</h1>
        <?php endif;?>
    </div>
    <div class="corpo">
        <form id="form" class="form-signin" action="{{url('seguranca/usuario/login')}}" method="post">
            <div class="content-wrap">
                <div class="input-field">
                    <label for="email">E-mail</label>
                    <input type="text" class="form-control" name="email"
                           value="{{old('email')}}" id="email" required>
                </div>
                <div class="input-field">
                    <label for="password">Senha</label>
                    <input type="password" class="form-control"
                           id="password" name="ab" required>
                    <div id="pnlIndicator" class="indicator">
                        <i class="material-icons right">warning</i>
                    </div>
                </div>
                @if (count($errors) > 0)
                    <div class="card-panel red lighten-4" style="color: #b71c1c">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif
                <div class="row">
                    <span class="left pdtp">
                        <a href="{{url('cadastro')}}">Solicitar acesso</a>
                    </span>
                    <button class="btn waves-effect blue darken-3 right" type="submit">Login</button>
                </div>
            </div>
            {{ csrf_field() }}
        </form>
    </div>
    <div class="pe">
        @php($letreiro = config('policia.letreiro'))
        @if (strlen($letreiro) > 0)
            <div class="letreiro">
                <i class="material-icons left">info</i>{{$letreiro}}
            </div>
        @endif
        <div class="creditos">
            &copy;  <?php echo date('Y') ?> - DIME - Diretoria de Informática, Manutenção e Estatística.
        </div>
    </div>
</div>
</body>
<script src="{{asset('materialize-css/materialize.min.js')}}"></script>

</html>