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
