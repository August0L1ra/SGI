<?php
session_start();

$action = $_GET['action'] ?? '';
$id     = $_GET['id'] ?? null;
$termo  = $_POST['termo'] ?? '';

$mensagem = '';
if (isset($_SESSION['usuario']) && !isset($_SESSION['boas_vindas_exibida'])) {
    $usuario = $_SESSION['usuario'];
    $mensagem = "Bem-vindo(a), $usuario!";
    $_SESSION['boas_vindas_exibida'] = true;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>SGPD - Início</title>
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
            display: flex;
            flex-direction: column;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        button {
            position: absolute;
            top: 40px;
            right: 40px;
            padding: 10px 16px;
            background-color: #d62828;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        button:hover {
            background-color: #a50000;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 100px;
            padding: 25px;
            flex-direction: column;
        }

        .nav {
            background-color: white;
            padding: 30px 90px;
            border-radius: 20px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .nav h2 {
            color: #2d2e47;
            margin-bottom: 20px;
        }

        .nav a {
            text-decoration: none;
            background-color: #00bab4;
            color: white;
            padding: 12px 24px;
            border-radius: 15px;
            font-weight: bold;
            width: 400px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .nav a:hover {
            background-color: #007b7a;
        }

        .boas-vindas {
            background-color: #ffffffcc;
            padding: 16px 32px;
            border-radius: 12px;
            color: #2d2e47;
            font-weight: bold;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<button onclick="window.location.href='login.php'">Sair</button>

<div class="container">
    <?php if ($mensagem): ?>
        <div class="boas-vindas"><?= htmlspecialchars($mensagem) ?></div>
    <?php endif; ?>

    <div class="nav">
        <h2>SGPD_2025</h2>
        <a href="professores.php">Professores</a>
        <a href="disciplinas.php">Disciplinas</a>
        <a href="turmas.php">Turmas</a>
        <a href="horarios.php">Horários</a>
        <a href="alocacoes.php">Alocações</a>
    </div>
</div>

</body>
</html>
