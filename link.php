<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    // (Em produção: enviar e-mail de recuperação)
    echo "<div class='alert alert-info'>Se o e-mail estiver cadastrado, um link de recuperação foi enviado.</div>";
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 400px;">
        <div class="card shadow">
            <div class="card-body">
                <h4 class="card-title mb-4 text-center">Recuperar Senha</h4>
                <form method="POST">
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Digite seu e-mail" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Enviar link de recuperação</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(120deg, #2d2e47, #00bab4);
            background-size: 200% 200%;
            animation: gradientMove 10s ease infinite;
            min-height: 100vh;
            padding-top: 80px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .btn-sair {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
            background-color: #d62828;
            color: white;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        .btn-sair:hover {
            background-color: #a50000;
        }

        .container {
            width: 100%;
            max-width: 400px;
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
        }

        .card-title {
            text-align: center;
            margin-bottom: 20px;
            color: #2d2e47;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }

        .btn-primary {
            background-color: #00bab4;
            color: white;
            font-weight: bold;
            border: none;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #005f87;
        }

        .mensagem {
            color: white;
            background-color: rgba(0, 0, 0, 0.4);
            font-weight: bold;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 10px;
            text-align: center;
            width: 80%;
        }
    </style>
</head>

<button class="btn-sair" onclick="window.location.href='login.php'">Sair</button>
