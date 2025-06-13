<!DOCTYPE html>
<html>
    <head>
        <title>Cadastro</title>
    </head>
    
    <a href="/">Voltar</a>
    <a href="/glicemia/create">Criar</a>

    <?php global $lista; ?>

    <?php if (!empty($lista)): ?>
        <h3>Dados Cadastrados:</h3>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Data</th>
                <th>Hora</th>
                <th>Valor</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($lista as $id => $dado) { ?>
                <tr>
                    <td><?= $id ?></td>
                    <td><?= htmlspecialchars($dado['data']) ?></td>
                    <td><?= htmlspecialchars($dado['hora']) ?></td>
                    <td><?= htmlspecialchars($dado['valor']) ?></td>
                    <td>
                        <a href="/glicemia/edit?id=<?= $id ?>">Editar</a>
                        <a href="/glicemia/delete?id=<?= $id ?>">Excluir</a>
                    </td>
                </tr>
        <?php } ?>
    <?php else: ?>
        <p>Nenhum dado cadastrado.</p>
    <?php endif; ?>
</body>
</html>
