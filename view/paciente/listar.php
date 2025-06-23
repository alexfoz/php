<!DOCTYPE html>
<html>
    <head>
        <title>Cadastro Paciente</title>
    </head>
    
    <a href="/">Voltar</a>
    <a href="/paciente/create">Criar</a>

    <?php global $lista; ?>

    <?php if (!empty($lista)): ?>
        <h3>Dados Cadastrados:</h3>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Data Nascimento</th>
                <th>Telefone</th>
                <th>Email</th>  
                <th>Observação</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($lista as $dado) { ?>
                <tr>
                    <td><?= $dado->id ?></td>
                    <td><?= htmlspecialchars($dado->nome) ?></td>
                    <td><?= htmlspecialchars($dado->dataNascimento) ?></td>
                    <td><?= htmlspecialchars($dado->telefone) ?></td>
                    <td><?= htmlspecialchars($dado->email) ?></td>
                    <td><?= nl2br(htmlspecialchars($dado->observacao ?? '', ENT_QUOTES, 'UTF-8')) ?></td>
                    <td>
                        <a href="/paciente/edit?id=<?= $dado->id ?>">Editar</a>
                        <a href="/paciente/delete?id=<?= $dado->id ?>">Excluir</a> 
                    </td>
                </tr>
        <?php } ?>
    <?php else: ?>
        <p>Nenhum dado cadastrado.</p>
    <?php endif; ?>
</body>
</html>
