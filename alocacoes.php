<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastro de Alocações</title>
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
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        padding: 40px;
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

    form {
        background-color: #fff;
        padding: 35px 40px;
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
        width: 100%;
        max-width: 400px;
        margin-bottom: 30px;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #2d2e47;
    }

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

    .cadastro {
        color: green;
        text-align: center;
        margin-bottom: 15px;
        font-weight: bold;
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

    table {
        width: 50%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #fff;
        border-radius: 10px;
        overflow: hidden;
    }

    th,
    td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #00bab4;
        color: white;
    }

    tr:hover {
        background-color: #f1f1f1;
    }
    </style>
</head>

<body>

    <div class="top-buttons">
        <button class="btn-home" onclick="window.location.href='inicial.php'">Tela Inicial</button>
        <button class="btn-logout" onclick="window.location.href='login.php'">Sair</button>
    </div>

    <?php
    $pdo = new PDO("mysql:host=localhost;dbname=sgbd;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $cadastro = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $professor = $_POST["id_professor"];
        $disciplina = $_POST["id_disciplina"];
        $turma = $_POST["id_turma"];

        // Verificação para evitar duplicata
        $check = $pdo->prepare("SELECT COUNT(*) FROM alocacoes WHERE id_professor = ? AND id_disciplina = ? AND id_turma = ?");
        $check->execute([$professor, $disciplina, $turma]);

        if ($check->fetchColumn() > 0) {
            $cadastro = "Essa alocação já existe!";
        } else {
            $sql = "INSERT INTO alocacoes (id_professor, id_disciplina, id_turma) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$professor, $disciplina, $turma]);
            $cadastro = "Alocação cadastrada com sucesso!";
        }
    }

    $professores = $pdo->query("SELECT id_professor, Nome FROM Professores")->fetchAll(PDO::FETCH_ASSOC);
    $disciplinas = $pdo->query("SELECT id_disciplina, Nome FROM Disciplinas")->fetchAll(PDO::FETCH_ASSOC);
    $turmas = $pdo->query("SELECT id_turma, Nome FROM Turmas")->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <form method="post">
        <h2>Cadastro de Alocações</h2>

        <?php if (!empty($cadastro)): ?>
        <div class="cadastro"><?= htmlspecialchars($cadastro) ?></div>
        <?php endif; ?>

        <label>Professor:</label>
        <select name="id_professor" required>
            <option value="">Selecione...</option>
            <?php foreach ($professores as $p): ?>
            <option value="<?= $p['id_professor'] ?>"><?= htmlspecialchars($p['Nome']) ?></option>
            <?php endforeach; ?>
        </select>

        <label>Disciplina:</label>
        <select name="id_disciplina" required>
            <option value="">Selecione...</option>
            <?php foreach ($disciplinas as $d): ?>
            <option value="<?= $d['id_disciplina'] ?>"><?= htmlspecialchars($d['Nome']) ?></option>
            <?php endforeach; ?>
        </select>

        <label>Turma:</label>
        <select name="id_turma" required>
            <option value="">Selecione...</option>
            <?php foreach ($turmas as $t): ?>
            <option value="<?= $t['id_turma'] ?>"><?= htmlspecialchars($t['Nome']) ?></option>
            <?php endforeach; ?>
        </select>

        <input type="submit" value="Cadastrar Alocação">
    </form>

    <h2>Alocações Cadastradas</h2>
    <table>
        <tr>
            <th>Professor</th>
            <th>Disciplina</th>
            <th>Turma</th>
        </tr>
        <?php
        $all = $pdo->query("
        SELECT 
            p.nome AS professor, 
            d.nome AS disciplina, 
            t.nome AS turma
        FROM alocacoes a
        JOIN Professores p ON a.id_professor = p.id_professor
        JOIN Disciplinas d ON a.id_disciplina = d.id_disciplina
        JOIN Turmas t ON a.id_turma = t.id_turma
    ")->fetchAll(PDO::FETCH_ASSOC);

        foreach ($all as $r): ?>
        <tr>
            <td><?= htmlspecialchars($r['professor']) ?></td>
            <td><?= htmlspecialchars($r['disciplina']) ?></td>
            <td><?= htmlspecialchars($r['turma']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>