<!DOCTYPE html>
<html>
    <head>
        <title>Cadastro Paciente</title>
    </head>
    
    <a href="/">Voltar</a>
    <a href="/paciente/create">Criar</a>

    <?php global $lista, $nome; ?>

    <h3>pacientes Cadastrados:</h3>

    <form>
        <p>
            <input type="text" name="nome" value="<?= $nome ?? "" ?>">
            <input type="submit" value="Filtrar">
        </p>
    </form>

    <?php if (!empty($lista)): ?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Data Nascimento</th>
                <th>Telefone</th>
                <th>Email</th>
                <th>Medico</th>
                <th>Observação</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($lista as $paciente) { ?>
                <tr>
                    <td><?= $paciente->id ?></td>
                    <td><?= htmlspecialchars($paciente->nome) ?></td>
                    <td><?= htmlspecialchars($paciente->dataNascimento) ?></td>
                    <td><?= htmlspecialchars($paciente->telefone) ?></td>
                    <td><?= htmlspecialchars($paciente->email) ?></td>
                    <td><?= htmlspecialchars($paciente->medico ?? '') ?></td>
                    <td><?= nl2br(htmlspecialchars($paciente->observacao ?? '', ENT_QUOTES, 'UTF-8')) ?></td>
                    <td>
                        <a href="/paciente/edit?id=<?= $paciente->id ?>">Editar</a>
                        <a href="/paciente/delete?id=<?= $paciente->id ?>">Excluir</a> 
                    </td>
                </tr>
        <?php } ?>
    <?php else: ?>
        <p>Paciente não encontado.</p>
    <?php endif; ?>
</body>
</html>
