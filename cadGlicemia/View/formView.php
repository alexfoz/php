<!DOCTYPE html>
<html>
<head>
    <title>Cadastro</title>
    <meta charset="UTF-8">
</head>
<body>
    <h2>Formulário de Cadastro</h2>
    <form action="" method="POST">
        <p>Data: <input type="text" name="data" value="<?= htmlspecialchars($data) ?>"></p>
        <p>Valor: <input type="text" name="valor" value="<?= htmlspecialchars($valor) ?>"></p>
        <p>Hora: <input type="text" name="hora" value="<?= htmlspecialchars($hora) ?>"></p>
        <p><input type="submit" value="Cadastrar"></p>
    </form>

    <form action="" method="POST">
        <input type="hidden" name="limpar" value="1">
        <input type="submit" value="Limpar Dados">
    </form>

    <p><?= $mensagem ?></p>

    <?php if (!empty($dados)): ?>
        <h3>Dados Cadastrados:</h3>
        <?php foreach ($dados as $dado): ?>
            <p>Data: <?= htmlspecialchars($dado['data']) ?>, Valor: <?= htmlspecialchars($dado['valor']) ?>, Hora: <?= htmlspecialchars($dado['hora']) ?></p>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Nenhum dado cadastrado.</p>
    <?php endif; ?>
</body>
</html>
