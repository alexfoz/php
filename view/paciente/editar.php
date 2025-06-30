<!DOCTYPE html>
<html>
    <head>
        <title>Cadastro Paciente</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h2>Formulário de Cadastro Paciente</h2>
        <?php global $mensagem; ?>
        <?php global $dados; ?>
        <p><?= $mensagem; ?></p>
        <form action="/paciente/store" method="POST">
            <input type="hidden" name="id" value="<?= $id ?? "" ?>">
            <!--<p>ID: <?= $id ?></p> -->
            <table>
                <tr>
                    <th style="text-align: right">Nome:</th>
                    <td><input type="text" name="nome" value="<?= htmlspecialchars($dados->nome ?? "") ?>"></td>
                </tr>

                <tr>
                    <th style="text-align: right">Nascimento:</th>
                    <td><input type="date" name="dataNascimento" value="<?= htmlspecialchars($dados->dataNascimento ?? "") ?>"></td>
                </tr>
                    <th style="text-align: right">Telefone:</th>
                    <td><input type="text" name="telefone" value="<?= htmlspecialchars($dados->telefone ?? "") ?>"></td>
                </tr>
                <tr>
                    <th style="text-align: right">Email:</th>
                    <td><input type="email" name="email" value="<?= htmlspecialchars($dados->email ?? "") ?>"></td>
                </tr>
                <tr>
                    <th style="text-align: right">Observação:</th>
                    <td><textarea name="observacao" rows="4" cols="50"><?= htmlspecialchars($dados->observacao ?? "") ?></textarea></td>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <input type="submit" value="Gravar">
                        <a href="/paciente">Cancelar</a>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
