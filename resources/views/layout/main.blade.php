<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sentinela</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style type="text/css">
        body {
            font-family: 'Open Sans',
                sans-serif;
        }

        .form-control {
            box-shadow: none;
            border-radius: 4px;
            border-color: #dfe3e8;
        }

        .form-control:focus {
            border-color: #29c68c;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
        }

        .navbar-header.col {
            padding: 0 !important;
        }

        .navbar {
            background: #fff;
            padding-left: 16px;
            padding-right: 16px;
            border-bottom: 1px solid #dfe3e8;
            border-radius: 0;
        }

        .navbar .navbar-brand {
            font-size: 20px;
            padding-left: 0;
            padding-right: 50px;
        }

        .navbar .navbar-brand b {
            font-weight: bold;
            color: #29c68c;
        }

        .navbar ul.nav li a {
            color: #999;
        }

        .navbar ul.nav li a:hover,.navbar ul.nav li a:focus {
            color: #29c68c !important;
        }

        .navbar ul.nav li.active>a,.navbar ul.nav li.open>a {
            color: #26bb84 !important;
            background: transparent !important;
        }

        .navbar .form-inline .input-group-addon {
            box-shadow: none;
            border-radius: 2px 0 0 2px;
            background: #f5f5f5;
            border-color: #dfe3e8;
            font-size: 16px;
        }

        .navbar .form-inline i {
            font-size: 16px;
        }

        .navbar .form-inline .btn {
            border-radius: 2px;
            color: #fff;
            border-color: #29c68c;
            background: #29c68c;
            outline: none;
        }

        .navbar .form-inline .btn:hover,.navbar .form-inline .btn:focus {
            border-color: #26bb84;
            background: #26bb84;
        }

        .navbar .search-form {
            display: inline-block;
        }

        .navbar .search-form .btn {
            margin-left: 4px;
        }

        .navbar .search-form .form-control {
            border-radius: 2px;
        }

        .navbar .login-form .input-group {
            margin-right: 4px;
            float: left;
        }

        .navbar .login-form .form-control {
            max-width: 158px;
            border-radius: 0 2px 2px 0;
        }

        .navbar .navbar-right .dropdown-toggle::after {
            display: none;
        }

        .navbar .dropdown-menu {
            border-radius: 1px;
            border-color: #e5e5e5;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .05);
        }

        .navbar .dropdown-menu li a {
            padding: 6px 20px;
        }

        .navbar .navbar-right .dropdown-menu {
            width: 505px;
            padding: 20px;
            left: auto;
            right: 0;
            font-size: 14px;
        }

        @media (min-width: 1200px) {
            .search-form .input-group {
                width: 300px;
                margin-left: 30px;
            }
        }

        @media (max-width: 768px) {
            .navbar .navbar-right .dropdown-menu {
                width: 100%;
                background: transparent;
                padding: 10px 20px;
            }

            .navbar .input-group {
                width: 100%;
                margin-bottom: 15px;
            }

            .navbar .input-group .form-control {
                max-width: none;
            }

            .navbar .login-form .btn {
                width: 100%;
            }
        }

        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #29c68c;
            color: white;
            text-align: center;
        }

        button[type=button] {
            box-shadow: none;
            border-radius: 6px;
            background-color: #1f996c;
            border-color: #ffffff;
            font-size: 16px;
        }   

        button[type=submit] {
            box-shadow: none;
            border-radius: 6px;
            background-color: #1f996c;
            border-color: #ffffff;
            font-size: 16px;
        }

        button[type=reset] {
            box-shadow: none;
            border-radius: 6px;
            background-color: #1f996c;
            border-color: #ffffff;
            font-size: 16px;
        }
                
        button[type=button]:hover {
            background-color: #29c68c;
            border-color: #ffffff;
        }
        
        button[type=submit]:hover {
            background-color: #29c68c;
            border-color: #ffffff;
        }
        
        button[type=reset]:hover {
            background-color: #29c68c;
            border-color: #ffffff;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-default navbar-expand-lg navbar-light">
        <div class="navbar-header d-flex col">
            <a class="navbar-brand" href="#">DIME<b>|Sentinela</b></a>
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle navbar-toggler ml-auto">
                <span class="navbar-toggler-icon"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbarCollapse" class="collapse navbar-collapse justify-content-start">
            <ul class="nav navbar-nav">
                <li class="nav-item"><a href="/app-laravel/public/equipamento/index" class="nav-link">Início</a></li>
                <li class="nav-item"><a href="/app-laravel/public/equipamento/novo" class="nav-link">Novo Equipamento</a></li>
                <li class="nav-item"><a href="/app-laravel/public/servidor/ordem_servico" class="nav-link">Abertuda de OS</a></li>
                <li class="nav-item dropdown">
                    <a data-toggle="dropdown" class="nav-link dropdown-toggle" href="#">Movimentação<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="/app-laravel/public/equipamento/entrada" class="dropdown-item">Entrada de Equipamento</a></li>
                        <li><a href="/app-laravel/public/equipamento/saida" class="dropdown-item">Saida de Equipamento</a></li>
                    </ul>
                </li>
            </ul>
            <form class="navbar-form form-inline search-form">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Pesquisar...">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </form>
            <ul class="nav navbar-nav navbar-right ml-auto">
                <li class="nav-item active" class="nav-item dropdown">
                    <a data-toggle="dropdown" class="nav-link dropdown-toggle" href="#"><i class="fa fa-user-o"></i> Login</a>
                    <ul class="dropdown-menu">
                        <li>
                            <form class="form-inline login-form" action="/examples/actions/confirmation.php" method="post">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" placeholder="Username" required>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="text" class="form-control" placeholder="Password" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Login</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <script>
    </script>
    @yield('conteudo')
    <div class="footer">
        <p>@BIASOUSA</p>
    </div>
</body>

</html>