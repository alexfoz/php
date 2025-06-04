<!DOCTYPE html>
<html>
    <head>
        <title>Cadastro</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h2>Formulário de Cadastro</h2>
        <?php global $mensagem; ?>
        <?php global $dados; ?>
        <p><?= $mensagem; ?></p>
        <form action="/glicemia/store" method="POST">
            <input type="hidden" name="id" value="<?= $id ?? "" ?>">
            <p>ID: <?= $id ?></p>
            <p>Data: <input type="text" name="data" value="<?= htmlspecialchars($dados['data'] ?? "") ?>"></p>
            <p>Hora: <input type="text" name="valor" value="<?= htmlspecialchars($dados['valor'] ?? "") ?>"></p>
            <p>Valor: <input type="text" name="hora" value="<?= htmlspecialchars($dados['hora'] ?? "") ?>"></p>
            <p>
                <input type="submit" value="Gravar">
                <a href="/glicemia">Cancelar</a>
            </p>
        </form>
    </body>
</html>
