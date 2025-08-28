<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuários</title>
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

        .top-buttons {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
        }

        .top-buttons .btn {
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            font-size: 14px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .btn-home {
            background-color: #ffffff;
            color: black;
        }

        .sair {
            background-color: #d62828;
            color: white;
        }

        .btn-home:hover {
            background-color: #005f87;
        }

        .sair:hover {
            background-color: #a50000;
        }

        form {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 400px;
            margin-bottom: 30px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #ffffff;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select,
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #00bab4;
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #005f87;
        }

        .mensagem {
            color: green;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        .mensagem.error {
            color: red;
        }

        table {
            width: 50%;
            margin: 10px auto;
            border-collapse: collapse;
            background-color: #ffffff;
            color: #000;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            font-size: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #00bab4;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>

    <div class="top-buttons">
        <button class="btn sair" onclick="window.location.href='login.php'">Sair</button>
    </div>

    <?php
    $pdo = new PDO("mysql:host=localhost;dbname=sgbd;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $mensagem = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["cadastrar"])) {
        $nome = $_POST["Nome"];
        $email = $_POST["email"];
        $senha = $_POST["Senha_hash"];
        $perfil = $_POST["Perfil"];
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO Usuarios (Nome, email, Senha_hash, Perfil) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $email, $senha_hash, $perfil]);
        $mensagem =  "Usuário cadastrado com sucesso!";
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["recuperar"])) {
        $email_recuperar = $_POST["email_recuperar"];
        $stmt = $pdo->prepare("SELECT * FROM Usuarios WHERE email = ?");
        $stmt->execute([$email_recuperar]);

        if ($stmt->rowCount() > 0) {
            $token = bin2hex(random_bytes(32));
            $pdo->exec("CREATE TABLE IF NOT EXISTS recuperacoes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL,
            token VARCHAR(255) NOT NULL,
            criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
            usado BOOLEAN DEFAULT FALSE
        )");

            $inserir = $pdo->prepare("INSERT INTO recuperacoes (email, token) VALUES (?, ?)");
            $inserir->execute([$email_recuperar, $token]);

            $link = "http://localhost/resetar_senha.php?token=$token";
            echo "<div class='mensagem success'>Link de recuperação gerado:</div>";
            echo "<div class='mensagem'><a href='$link' target='_blank'>$link</a></div>";
        } else {
            echo "<div class='mensagem error'>E-mail não encontrado.</div>";
        }
    }

    $usuarios = $pdo->query("SELECT * FROM Usuarios")->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <h2>Cadastro de Usuários</h2>
    <form method="post">

        <?php if (!empty($mensagem)): ?>
            <p class="mensagem"><?= htmlspecialchars($mensagem) ?></p>
        <?php endif; ?>

        <input type="hidden" name="cadastrar" value="1">
        Nome Completo:<br><input type="text" name="Nome" required>
        Email:<br><input type="email" name="email" required>
        Senha:<br><input type="password" name="Senha_hash" required>
        Perfil:<br>
        <select name="Perfil" required>
            <option value="admin">Admin</option>
            <option value="professor">Professor</option>
        </select>
        <input type="submit" value="Cadastrar Usuário">
    </form>

    <h2>Usuários Cadastrados</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Perfil</th>
        </tr>
        <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?= htmlspecialchars($u['id_usuario']) ?></td>
                <td><?= htmlspecialchars($u['Nome']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td><?= htmlspecialchars($u['Perfil']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>