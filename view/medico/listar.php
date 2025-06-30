<!DOCTYPE html>
<html>
    <head>
        <title>Cadastro de Medico</title>
    </head>
    
    <a href="/">Voltar</a>
    <a href="/medico/create">Criar</a>

    <?php global $lista; ?>

    <?php if (!empty($lista)): ?>
        <h3>Dados Cadastrados:</h3>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CRM</th>
                <th>Especialidade</th>
                <th>Telefone</th>
                <th>Email</th>  
                <th>Observação</th>
                <th>Criado em</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($lista as $dado) { ?>
                <tr>
                    <td><?= $dado->id ?></td>
                    <td><?= htmlspecialchars($dado->nome) ?></td>
                    <td><?= htmlspecialchars($dado->crm) ?></td>
                    <td><?= htmlspecialchars($dado->especialidade) ?></td>
                    <td><?= htmlspecialchars($dado->telefone) ?></td>
                    <td><?= htmlspecialchars($dado->email) ?></td>
                    <td><?= nl2br(htmlspecialchars($dado->observacao ?? '', ENT_QUOTES, 'UTF-8')) ?></td>
                    <td><?= !empty($dado->criado_em) ? date('d/m/Y H:i', strtotime($dado->criado_em)) : '' ?></td>
                    <td>
                        <a href="/medico/edit?id=<?= $dado->id ?>">Editar</a>
                        <a href="/medico/delete?id=<?= $dado->id ?>">Excluir</a> 
                    </td>
                </tr>
        <?php } ?>
    <?php else: ?>
        <p>Nenhum dado cadastrado.</p>
    <?php endif; ?>
</body>
</html>
