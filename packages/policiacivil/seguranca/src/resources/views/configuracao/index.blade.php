@extends('layouts.default')
@section('conteudo')
    <main class="container mt-5">
        <h3>Bem vindo ao seu novo projeto</h3>
        <p>Para o correto funcionamento do sistema você ainda precisa configurar manualmente os seguintes arquivos:</p>
        <ul>
            <li>[obrigatório] Na raiz do pojeto digite o seguinte comando: php artisan key:generate</li>
            <li>[obrigatório] config/policia.php</li>
            <li>[opcional] Modifique a configuração do arquivo .env</li>
            <li>[opcional] routes/web.php (para deixar de ver esta tela)</li>
        </ul>
    </main>
@endsection