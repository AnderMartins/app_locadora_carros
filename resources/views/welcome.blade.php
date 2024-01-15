<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo à Locadora de Carros</title>

    <!-- Adicione o link para o arquivo CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Adicione o link para a fonte Nunito do Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito">

    <!-- Adicione estilos personalizados -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fa; /* Cor de fundo */
        }

        .container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            width: 25rem;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-img-top {
            width: 100%;
            height: auto;
            border-top-left-radius: calc(0.375rem - 1px);
            border-top-right-radius: calc(0.375rem - 1px);
        }

        .card-body {
            background-color: #ffffff; /* Cor de fundo do corpo da card */
            border-bottom-left-radius: calc(0.375rem - 1px);
            border-bottom-right-radius: calc(0.375rem - 1px);
        }

        .card-title {
            color: #343a40; /* Cor do título */
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card text-center">
        <img src="/img/LocadoraDeCarro.jpeg" class="card-img-top" alt="Imagem da Locadora de Carros">
        <div class="card-body">
            <h5 class="card-title">Bem-vindo à Locadora de Carros</h5>
            <div class="d-grid gap-2">
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                @endif

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-success">Registro</a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Adicione o link para o arquivo JS do Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
