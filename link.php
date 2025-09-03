<?php
// Configuração da conexão com o banco (ajuste para seu ambiente)
$conn = new mysqli("localhost", "root", "", "sgbd");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$message = ''; // Variável para armazenar a mensagem a ser exibida

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // Preparar a consulta para evitar SQL Injection
    $stmt = $conn->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Usuário encontrado - aqui você enviaria o link de recuperação
        // (implementação real do envio não incluída)
        $message = "<div class='alert alert-success'>Link de recuperação enviado para o e-mail informado.</div>";
    } else {
        // Usuário não encontrado
        $message = "<div class='alert alert-danger'>E-mail não cadastrado no sistema.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="static/img/icon.png">
    <title>Recuperar Senha</title>
    <link rel="stylesheet" href="static/style/link.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5" style="max-width: 400px;">
        <div class="card shadow">
            <div class="card-body">
                <h4 class="card-title mb-4 text-center">Recuperar Senha</h4>

                <!-- Mensagem de feedback -->
                <?php
                if (!empty($message)) {
                    echo $message;
                }
                ?>

                <form method="POST" novalidate>
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Digite seu e-mail" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Enviar link de recuperação</button>
                    </div>
                </form>

                <!-- Botão para voltar à tela de login -->
                <button class="voltar" onclick="window.location.href='login.php'">Voltar</button>
            </div>
        </div>
    </div>
</body>

</html>