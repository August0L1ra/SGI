<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="static/img/icon.png">
    <title>Cadastro de Professores - Login</title>
    <link rel="stylesheet" href="style/styleLogin.css">
</head>

<body>

    <?php
    session_start();
    $pdo = new PDO("mysql:host=localhost;dbname=sgbd;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $erro = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = $_POST["email"];
        $senha = $_POST["senha"];

        $stmt = $pdo->prepare("SELECT * FROM Usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario["Senha_hash"])) {
            $_SESSION["usuario"] = $usuario["Nome"];
            header("Location: inicial.php");
            exit;
        } else {
            $erro = "Email ou senha inválidos.";
        }
    }
    ?>

    <form method="post">
        <h1>SGI</h1>
        <h2>Login</h2>

        <?php if (!empty($erro)): ?>
            <div class="error"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        Email:<br><input type="email" name="email" required><br>
        Senha:<br><input type="password" name="senha" required><br>
        <input type="submit" value="Entrar">
        <a href="usuarios.php">Cadastre-se</a>
        <a href="link.php">Recuperar Senha</a>
    </form>
</body>

</html>