<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="static/img/icon.png">
    <title>Cadastro de Turmas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #2d2e47, #00bab4);
            background-size: 200% 200%;
            animation: move 8s infinite alternate;
            min-height: 100vh;
            padding-top: 60px;
        }

        @keyframes move {
            0% {
                background-position: 0% 50%;
            }

            100% {
                background-position: 100% 50%;
            }
        }

        .top-buttons {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            z-index: 1000;
        }

        .top-buttons button {
            padding: 10px 16px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Estilo do botão Tela Inicial */
        .btn-inicial {
            background-color: #ffffff;
            color: black;
        }

        /* Estilo do botão Sair (vermelho) */
        .btn-sair {
            background-color: #d9534f;
            color: white;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
            margin-bottom: 40px;
        }

        h2 {
            color: #ffffff;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
            color: #2d2e47;
        }

        input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        input[type="submit"] {
            background-color: #00bab4;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            padding: 12px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #007b7a;
        }

        table {
            width: 40%;
            margin: 30px auto;
            border-collapse: collapse;
            background-color: #ffffff;
            color: #000;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            font-size: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #00bab4;
            color: white;
        }

        .mensagem {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
            color: green;
        }
    </style>
</head>

<body>

    <div class="top-buttons">
        <button onclick="window.location.href='inicial.php'" class="btn-inicial">Tela Inicial</button>
        <button onclick="window.location.href='login.php'" class="btn-sair">Sair</button>
    </div>

    <?php
    $pdo = new PDO("mysql:host=localhost;dbname=sgbd;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $mensagem = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nome = $_POST["Nome"];
        $semestre = $_POST["Semestre"];

        $sql = "INSERT INTO Turmas (Nome, Semestre) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $semestre]);

        $mensagem = "Turma cadastrada com sucesso!";
    }

    $turmas = $pdo->query("SELECT * FROM Turmas")->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <h2>Cadastro de Turmas</h2>
    <div class="container">
        <form method="post">
            <?php if (!empty($mensagem)): ?>
                <p class="mensagem"><?= htmlspecialchars($mensagem) ?></p>
            <?php endif; ?>

            <label for="Nome">Nome da Turma:</label>
            <input type="text" id="Nome" name="Nome" required>

            <label for="Semestre">Semestre:</label>
            <input type="text" id="Semestre" name="Semestre" required>

            <input type="submit" value="Cadastrar Turma">
        </form>
    </div>

    <h2>Turmas Cadastradas</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Turma</th>
            <th>Semestre</th>
        </tr>
        <?php foreach ($turmas as $t): ?>
            <tr>
                <td><?= htmlspecialchars($t['id_turma']) ?></td>
                <td><?= htmlspecialchars($t['Nome']) ?></td>
                <td><?= htmlspecialchars($t['Semestre']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>