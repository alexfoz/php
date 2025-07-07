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
                <th>Data Hora</th>
                <th>Valor</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($lista as $dado) { ?>
                <tr>
                    <td><?= $dado->id ?></td>
                    <td><?= htmlspecialchars($dado->data) ?></td>
                    <td><?= htmlspecialchars($dado->valor) ?></td>
                    <td>
                        <a href="/glicemia/edit?id=<?= $dado->id ?>">Editar</a>
                        <a href="/glicemia/delete?id=<?= $dado->id ?>">Excluir</a>
                        <a href="/glicemia/relatorio-form?paciente_id=<?= $paciente->id ?>">Gerar Relatório</a>
                    </td>
                </tr>
        <?php } ?>
    <?php else: ?>
        <p>Nenhum dado cadastrado.</p>
    <?php endif; ?>
</body>
</html>
