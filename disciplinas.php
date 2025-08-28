<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastro de Disciplinas</title>
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

        .top-buttons button {
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

        .btn-logout {
            background-color: #d62828;
            color: white;
        }

        .btn-home:hover {
            background-color: #005f87;
        }

        .btn-logout:hover {
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
            margin-bottom: 20px;
            color: #ffffff;
        }

        input[type="text"],
        input[type="number"],
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

        table {
            width: 50%;
            margin: 30px auto;
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

    <?php
    $pdo = new PDO("mysql:host=localhost;dbname=sgbd;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $mensagem = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nome = $_POST["Nome"];
        $carga_horaria = $_POST["carga_horaria"];

        $sql = "INSERT INTO Disciplinas (Nome, carga_horaria) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $carga_horaria]);

        $mensagem = "Disciplina cadastrada com sucesso!";
    }

    $disciplinas = $pdo->query("SELECT id_disciplina, Nome FROM Disciplinas")->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="top-buttons">
        <button class="btn-home" onclick="window.location.href='inicial.php'">Tela Inicial</button>
        <button class="btn-logout" onclick="window.location.href='login.php'">Sair</button>
    </div>

    <h2>Cadastro de Disciplinas</h2>
    <form method="post">
        <?php if (!empty($mensagem)): ?>
            <p class="mensagem"><?= htmlspecialchars($mensagem) ?></p>
        <?php endif; ?>

        Nome:<br><input type="text" name="Nome" required><br>
        Carga Horária:<br><input type="number" name="carga_horaria" required><br>
        <input type="submit" value="Cadastrar Disciplina">
    </form>

    <h2>Disciplinas cadastradas</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Carga Horária</th>
        </tr>
        <?php
        $all = $pdo->query("SELECT * FROM Disciplinas")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($all as $d) {
            echo "<tr>
                <td>{$d['id_disciplina']}</td>
                <td>" . htmlspecialchars($d['Nome']) . "</td>
                <td>{$d['carga_horaria']}</td>
              </tr>";
        }
        ?>
    </table>

</body>

</html>