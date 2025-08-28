<?php
$pdo = new PDO("mysql:host=localhost;dbname=sgbd;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["Nome"];
    $cpf = $_POST["CPF"];
    $email = $_POST["email"];
    $formacao = $_POST["Formacao"];

    $sql = "INSERT INTO Professores (Nome, CPF, email, Formacao) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $cpf, $email, $formacao]);

    $mensagem = "Professor cadastrado com sucesso!";
}

$professores = $pdo->query("SELECT * FROM Professores")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastro de Professores</title>
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
            padding: 40px;
            color: white;
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

        h2,
        h3 {
            text-align: center;
            margin-bottom: 20px;
        }

        .mensagem {
            text-align: center;
            color: #008000;
            font-weight: bold;
            margin-bottom: 20px;
        }

        form {
            background-color: #ffffff;
            color: #000;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
            max-width: 400px;
            margin: 0 auto 40px auto;
        }

        input[type="text"],
        input[type="email"] {
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

        button {
            margin: 10px 5px;
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            background-color: #ffffff;
            color: #2d2e47;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button.sair {
            background-color: #d62828;
            color: white;
        }

        button.sair:hover {
            background-color: #a61c1c;
        }

        button:hover {
            background-color: #cccccc;
        }

        .botoes {
            text-align: right;
            margin-bottom: 30px;
        }

        table {
            width: 60%;
            margin: 30px auto;
            border-collapse: collapse;
            background-color: #ffffff;
            color: #000;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            font-size: 20px;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #00bab4;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e0f7f7;
        }
    </style>
</head>

<body>

    <div class="botoes">
        <button onclick="window.location.href='inicial.php'">Tela Inicial</button>
        <button class="sair" onclick="window.location.href='login.php'">Sair</button>
    </div>

    <h2>Cadastro de Professores</h2>

    <form method="post">
        <?php if (!empty($mensagem)): ?>
            <p class="mensagem"><?= htmlspecialchars($mensagem) ?></p>
        <?php endif; ?>

        Nome:<br><input type="text" name="Nome" required><br>
        CPF:<br><input type="text" name="CPF" required><br>
        Email:<br><input type="email" name="email" required><br>
        Formação:<br><input type="text" name="Formacao" required><br>
        <input type="submit" value="Cadastrar Professor">
    </form>

    <h2>Professores cadastrados</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Email</th>
            <th>Formação</th>
        </tr>
        <?php foreach ($professores as $p): ?>
            <tr>
                <td><?= $p['id_professor'] ?></td>
                <td><?= htmlspecialchars($p['Nome']) ?></td>
                <td><?= $p['CPF'] ?></td>
                <td><?= htmlspecialchars($p['email']) ?></td>
                <td><?= htmlspecialchars($p['Formacao']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>