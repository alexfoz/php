<!DOCTYPE html>
<head>
<link rel="stylesheet" href="/main.css">
</head>
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

        <?php
        require_once __DIR__ . '/../../model/Model.php'; // ajuste o caminho se necessário

        try {
            $conn = Model::connect();
            $stmt = $conn->query("SELECT id, nome FROM medico ORDER BY nome");
            $medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Erro ao carregar médicos: " . htmlspecialchars($e->getMessage()) . "</p>";
            $medicos = [];
        }
        ?>

        <form action="/paciente/store" method="POST">
            <input type="hidden" name="id" value="<?= $id ?? "" ?>">
            <table class="editar">
                <tr>
                    <th>Nome:</th>
                    <td><input type="text" name="nome" value="<?= htmlspecialchars($dados->nome ?? "") ?>"></td>
                </tr>
                <tr>
                    <th>Nascimento:</th>
                    <td><input type="date" name="dataNascimento" value="<?= htmlspecialchars($dados->dataNascimento ?? "") ?>"></td>
                </tr>
                <tr>
                    <th>Telefone:</th>
                    <td><input type="text" name="telefone" value="<?= htmlspecialchars($dados->telefone ?? "") ?>"></td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td><input type="email" name="email" value="<?= htmlspecialchars($dados->email ?? "") ?>"></td>
                </tr>
                <tr>
                    <th>Observação:</th>
                    <td><textarea name="observacao" rows="4" cols="50"><?= htmlspecialchars($dados->observacao ?? "") ?></textarea></td>
                </tr>
                <tr>
                    <th>Médico Responsável:</th>
                    <td>
                        <select name="medico_id" required>
                            <option value="">Selecione um médico</option>
                            <?php foreach ($medicos as $medico): ?>
                                <option value="<?= $medico['id'] ?>" <?= isset($dados->medico_id) && $dados->medico_id == $medico['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($medico['nome']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
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
