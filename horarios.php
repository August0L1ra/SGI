<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastro de Horários</title>
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

    .container {
        width: 100%;
        max-width: 400px;
        background-color: #fff;
        padding: 30px 40px;
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
        margin-bottom: 40px;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #ffffff;
    }

    label {
        display: block;
        margin: 12px 0 4px;
        font-weight: bold;
    }

    select,
    input[type="time"],
    input[type="submit"] {
        width: 100%;
        padding: 12px;
        margin-bottom: 10px;
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

    .sucesso {
        color: green;
        text-align: center;
        margin-bottom: 10px;
        font-weight: bold;
    }

    .erro {
        color: red;
        text-align: center;
        margin-bottom: 10px;
        font-weight: bold;
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
        $dia_semana     = $_POST["dia_semana"];
        $turno          = $_POST["turno"];
        $horario_inicio = $_POST["horario_inicio"];
        $horario_fim    = $_POST["horario_fim"];

        if ($horario_fim <= $horario_inicio) {
            $mensagem = "<p style='color:red; text-align:center;'>Horário de fim deve ser após o horário de início.</p>";
        } else {
            $sql = "INSERT INTO Horarios (dia_semana, turno, horario_inicio, horario_fim)
                VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$dia_semana, $turno, $horario_inicio, $horario_fim]);
            $mensagem = "<p style='color:green; text-align:center;'>Horário cadastrado com sucesso!</p>";
        }
    }

    // Buscar horários cadastrados para exibir
    $horarios = $pdo->query("SELECT * FROM Horarios ORDER BY dia_semana, turno, horario_inicio")->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="top-buttons">
        <button class="btn-home" onclick="window.location.href='inicial.php'">Tela Inicial</button>
        <button class="btn-logout" onclick="window.location.href='login.php'">Sair</button>
    </div>

    <h2>Cadastro de Horários</h2>
    <div class="container">
        <?= $mensagem ?>

        <form method="post">
            <label for="dia_semana">Dia da Semana:</label>
            <select name="dia_semana" id="dia_semana" required>
                <option value="">Selecione...</option>
                <option value="Segunda">Segunda</option>
                <option value="Terça">Terça</option>
                <option value="Quarta">Quarta</option>
                <option value="Quinta">Quinta</option>
                <option value="Sexta">Sexta</option>
                <option value="Sábado">Sábado</option>
            </select>

            <label for="turno">Turno:</label>
            <select name="turno" id="Turno" required>
                <option value="">Selecione...</option>
                <option value="Manhã">Manhã</option>
                <option value="Tarde">Tarde</option>
                <option value="Noite">Noite</option>
            </select>

            <label for="horario_inicio">Horário Início:</label>
            <input type="time" name="horario_inicio" id="horario_inicio" required>

            <label for="horario_fim">Horário Fim:</label>
            <input type="time" name="horario_fim" id="horario_fim" required>

            <input type="submit" value="Cadastrar Horário">
        </form>
    </div>

    <?php if ($horarios): ?>
    <h2>Horários Cadastrados</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Dia da Semana</th>
                <th>Turno</th>
                <th>Horário Início</th>
                <th>Horário Fim</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($horarios as $h): ?>
            <tr>
                <td><?= $h['id_horario'] ?></td>
                <td><?= htmlspecialchars($h['dia_semana']) ?></td>
                <td><?= htmlspecialchars($h['turno']) ?></td>
                <td><?= htmlspecialchars(substr($h['horario_inicio'], 0, 5)) ?></td>
                <td><?= htmlspecialchars(substr($h['horario_fim'], 0, 5)) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p style="text-align:center;">Nenhum horário cadastrado ainda.</p>
    <?php endif; ?>

</body>

</html>