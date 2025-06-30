<!DOCTYPE html>
<html>
    <head>
        <title>Cadastro Medico</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h2>Formulário de Cadastro Medico</h2>
        <?php global $mensagem; ?>
        <?php global $dados; ?>
        <p><?= $mensagem; ?></p>
        <form action="/medico/store" method="POST">
            <input type="hidden" name="id" value="<?= $id ?? "" ?>">
            <p>Nome: <input type="text" name="nome" value="<?= htmlspecialchars($dados->nome ?? "") ?>"></p>
            <p>CRM: <input type="text" name="crm" value="<?= htmlspecialchars($dados->crm ?? "") ?>"></p>
            <p>Especialidade: <input type="text" name="especialidade" value="<?= htmlspecialchars($dados->especialidade ?? "") ?>"></p>
            <p>Telefone: <input type="text" name="telefone" value="<?= htmlspecialchars($dados->telefone ?? "") ?>"></p>
            <p>Email: <input type="email" name="email" value="<?= htmlspecialchars($dados->email ?? "") ?>"></p>
            <p>Criado em: <input type="datetime-local" name="criado_em" value="<?= isset($dados->criado_em) ? date('Y-m-d\TH:i', strtotime($dados->criado_em)) : '' ?>"></p>
            <p><textarea name="observacao" rows="4" cols="50"><?= htmlspecialchars($dados->observacao ?? "") ?></textarea></p>
            
            
            <p>
                <input type="submit" value="Gravar">
                <a href="/medico">Cancelar</a>
            </p>
        </form>
    </body>
</html>
