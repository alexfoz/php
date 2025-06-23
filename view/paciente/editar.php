<!DOCTYPE html>
<html>
    <head>
        <title>Cadastro Paciente</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h2>Formulário de Cadastro</h2>
        <?php global $mensagem; ?>
        <?php global $dados; ?>
        <p><?= $mensagem; ?></p>
        <form action="/paciente/store" method="POST">
            <input type="hidden" name="id" value="<?= $id ?? "" ?>">
            <!--<p>ID: <?= $id ?></p> -->
            <p>Nome: <input type="text" name="nome" value="<?= htmlspecialchars($dados->nome ?? "") ?>"></p>
            <p>Data de Nascimento: <input type="date" name="dataNascimento" value="<?= htmlspecialchars($dados->dataNascimento ?? "") ?>"></p>
            <p>Telefone: <input type="text" name="telefone" value="<?= htmlspecialchars($dados->telefone ?? "") ?>"></p>
            <p>Email: <input type="email" name="email" value="<?= htmlspecialchars($dados->email ?? "") ?>"></p>
            <p><textarea name="observacao" rows="4" cols="50"><?= htmlspecialchars($dados->observacao ?? "") ?></textarea></p>    
            <p>
                <input type="submit" value="Gravar">
                <a href="/paciente">Cancelar</a>
            </p>
        </form>
    </body>
</html>
