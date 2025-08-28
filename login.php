<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastro de Professores - Login</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Reset geral */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Fundo com degradê animado */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(120deg, #2d2e47, #00bab4);
            background-size: 200% 200%;
            animation: gradientMove 10s ease infinite;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Formulário */
        form {
            background-color: #fff;
            padding: 35px 40px;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 400px;
        }

        /* Título */
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #000000;
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
            color: #000000;
        }


        /* Inputs */
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }

        /* Botão */
        input[type="submit"] {
            background-color: #00bab4;
            color: white;
            font-weight: bold;
            padding: 12px;
            border: none;
            width: 100%;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #005f87;
        }

        /* Links */
        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #00bab4;
            font-weight: bold;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Mensagem de erro */
        .error {
            color: #d62828;
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }
    </style>
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
        <h1>SGPD_2025</h1>
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